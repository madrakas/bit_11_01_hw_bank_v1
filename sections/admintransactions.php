<?php  if (isset($_SESSION['login']) && ($_SESSION['login'] === '1' )){
        $admins = unserialize(file_get_contents(__DIR__ . '/../data/admins.ser'));
        if (in_array($_SESSION['uid'], $admins)){
            $isAdmin = true;
            if(isset($_GET['usr'])){
                $users = unserialize(file_get_contents(__DIR__ . '/../data/users.ser'));
                $userExists = false;
                foreach($users as $user) {

                    if ($user['id'] === intval($_GET['usr'])){
                        $userExists = true;
                        $uid = $user['id'];
                        $ufname = $user['firstname'];
                        $ulname = $user['lastname'];
                    }
                }
                if (!$userExists){
                    header('Location: http://localhost/bank/index.php?p=adminlistusers');
                    die;
                }
            }
        } else {
            header('Location: http://localhost/bank/index.php');
            die;
        }
    } else {
        header('Location: http://localhost/bank/index.php');
        die;
    }

    $transactions = unserialize(file_get_contents(__DIR__ . '/../data/transfers.ser'));
    
    
if (isset($userExists) && $userExists){

    echo '</pre>';
    echo '<h1>View '. $ufname . ' '. $ulname .' (ID: '. $uid .') transactions</h1>';
    
    $accounts = unserialize(file_get_contents(__DIR__ . '/../data/accounts.ser'));
    $accounts = array_filter($accounts, fn($account) => $account['uid'] === $uid);
    foreach($accounts as $account){
        $transIn = array_filter($transactions, fn($transaction) => $transaction['to'] === $account['id']);
        $transOut = array_filter($transactions, fn($transaction) => $transaction['from'] === $account['id']);
        echo '<div class="acc_row">';
        echo '<div>IBAN: '. $account['iban'] .'</div>';
        echo '</div>';
        if (count($transOut) > 0){
            echo '<div class="details-head">Sent:</div>';
            echo '<div class="detail-headings">
            <div class="time">When</div>
            <div class="toIBAN">Recipient IBAN</div>
            <div class="toName">Recipient name</div>
            <div class="amount">Amount</div>
            <div class="currency">Currency</div>
        </div>';
        }
        foreach ($transOut as $tout){
            echo '<div class="detail-row">';
                echo '<div class="time">' . $tout['time'] . '</div>';
                echo '<div class="toIBAN">' . $tout['toIBAN'] . '</div>';
                echo '<div class="toName">' . $tout['toName'] . '</div>';
                echo '<div class="amount">' . $tout['amount'] . '</div>';
                echo '<div class="currency">' . $tout['curr'] . '</div>';
            echo '</div>';
        }
        if (count($transIn) > 0){
            echo '<div class="details-head">Received:</div>';
            echo '<div class="detail-headings">
            <div class="time">When</div>
            <div class="toIBAN">Sender IBAN</div>
            <div class="toName">Sender name</div>
            <div class="amount">Amount</div>
            <div class="currency">Currency</div>
            </div>';
        }
        foreach ($transIn as $tin){
    
            echo '<div class="detail-row">';
                echo '<div class="time">' . $tin['time'] . '</div>';
                echo '<div class="toIBAN">' . $tin['fromIBAN'] . '</div>';
                echo '<div class="toName">' . $tin['fromName'] . '</div>';
                echo '<div class="amount">' . $tin['amount'] . '</div>';
                echo '<div class="currency">' . $tin['curr'] . '</div>';
            echo '</div>';
        }
    }
   
}else{
    echo '<h1>View transactions</h1>';
    if (count($transactions) > 0){
        
        echo '<div class="detail-headings">
        <div class="time">When</div>
        <div class="toIBAN">Sender IBAN</div>
        <div class="toName">Sender name</div>
        <div class="toIBAN">Recipient IBAN</div>
        <div class="toName">Recipient name</div>
        <div class="amount">Amount</div>
        <div class="currency">Currency</div>
    </div>';
    }
    foreach ($transactions as $transaction){

        echo '<div class="detail-row">';
            echo '<div class="time">' . $transaction['time'] . '</div>';
            echo '<div class="toIBAN">' . $transaction['fromIBAN'] . '</div>';
            echo '<div class="toName">' . $transaction['fromName'] . '</div>';
            echo '<div class="toIBAN">' . $transaction['toIBAN'] . '</div>';
            echo '<div class="toName">' . $transaction['toName'] . '</div>';
            echo '<div class="amount">' . $transaction['amount'] . '</div>';
            echo '<div class="currency">' . $transaction['curr'] . '</div>';
        echo '</div>';
    }
   
}

?>

