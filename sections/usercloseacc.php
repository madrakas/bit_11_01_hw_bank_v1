<?php if (isset($_SESSION['login']) && ($_SESSION['login'] === '1' )){ 
      
        // Check user money accounts
        $accounts = unserialize(file_get_contents(__DIR__ . '/../data/accounts.ser'));
        $accounts = array_filter($accounts, fn($account) => ($account['uid'] === $_SESSION['uid']));
        $accounts = array_values($accounts);
        $err= '';
        
        if (count($accounts) !== 0){
        // there are acounts to check
            $amountSum = array_reduce($accounts, (fn($accu, $value) => $accu + $value['amount']), 0);
            if ($amountSum !== 0){
                $err = 'Cannot delete. Your money account is not empty.';
            }
        }

        if ($err !== ''){
            $_SESSION['msg'] = 'Error: ' . $err ;
            $_SESSION['msgType'] = 'red';
            header('Location: http://localhost/bank/index.php?p=userview');
            die;
        }
       
    } else {
        header('Location: http://localhost/bank/index.php');
        die;
}?>

<h1>Delete BIT bank account?</h1>
<form action="http://localhost/bank/process/users/delete.php" method="post">
    <button type="submit">Confirm deletion</button>
</form>