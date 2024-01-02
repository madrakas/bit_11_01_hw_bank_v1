<?php if (isset($_SESSION['login']) && ($_SESSION['login'] === '1' )){ 
    //Collect user accounts
    echo "<h1>Transactions history</h1>";
    $accounts = unserialize(file_get_contents(__DIR__ . '/../data/accounts.ser'));
    $accounts = array_filter($accounts, fn($a) => ($a['uid'] === $_SESSION['uid']));


    $transactions = unserialize(file_get_contents(__DIR__ . '/../data/transfers.ser'));
    $i = 0;
    foreach ($accounts as $account) {
        echo '<div class="acc_row">';
        echo '<div>' . ++$i . '.</div>';
        echo '<div>' .  $account['iban'] . '</div>';
        echo '</div>';
        $acc = $account['id'];
        $transIn = array_filter($transactions, fn($t) => ($t['to'] === $acc));
        $transOut = array_filter($transactions, fn($t) => ($t['from'] === $acc));
        $transIn = array_values($transIn);
        $transOut = array_values($transOut);
        if (count($transOut) > 0){
            echo '<div class="details-head">Sent:</div>';
        }
        foreach ($transOut as $tout){
            echo '<div class="detail-headings">
                <div class="time">When</div>
                <div class="toIBAN">Recipient IBAN</div>
                <div class="toName">Recipient name</div>
                <div class="amount">Amount</div>
                <div class="currency">Currency</div>
            </div>';
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
        }
        foreach ($transIn as $tin){
            echo '<div class="detail-headings">
                <div class="time">When</div>
                <div class="toIBAN">Sender IBAN</div>
                <div class="toName">Sender name</div>
                <div class="amount">Amount</div>
                <div class="currency">Currency</div>
            </div>';
            echo '<div class="detail-row">';
                echo '<div class="time">' . $tin['time'] . '</div>';
                echo '<div class="toIBAN">' . $tin['fromIBAN'] . '</div>';
                echo '<div class="toName">' . $tin['fromName'] . '</div>';
                echo '<div class="amount">' . $tin['amount'] . '</div>';
                echo '<div class="currency">' . $tin['curr'] . '</div>';
            echo '</div>';
        }
    }
    
} else {
    header("HTTP/1.1 401 Unauthorized");
    die;
}?>

