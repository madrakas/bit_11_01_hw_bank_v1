<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        // show 405 error response
        header('HTTP/1.1 405 Method Not Allowed');
        die;
} else {
    session_start();
    if (isset($_SESSION['login']) && ($_SESSION['login'] === '1' )){ 
        // Check user money accounts
        $accounts = unserialize(file_get_contents(__DIR__ . '/../../data/accounts.ser'));
        $accounts = array_filter($accounts, fn($account) => ($account['uid'] === $_SESSION['uid']));
        $accounts = array_values($accounts);
        $err= '';
        
        if (count($accounts) !== 0){
        // there are acounts to check
            $amountSum = array_reduce($accounts, (fn($accu, $value) => $accu + $value['amount']), 0);
            if ($amountSum !== 0){
                $err .= 'Cannot delete. Your money account is not empty.';
            }
        }

        if ($err !== ''){
            $_SESSION['msg'] = 'Error: ' . $err ;
            $_SESSION['msgType'] = 'red';
            header('Location: http://localhost/bank/index.php?p=userview');
            die;
        }
        //Delete process
        //Delete money accounts
        $accounts = unserialize(file_get_contents(__DIR__ . '/../../data/accounts.ser'));
        foreach ($accounts as $key => $value) {
            if ($accounts[$key]['uid'] === $_SESSION['uid']){
                unset($accounts[$key]);
            }
        }
        $accounts = array_values($accounts);
        file_put_contents(__DIR__ . '/../../data/accounts.ser', serialize($accounts));
        
        //Delete user
        $users = unserialize(file_get_contents(__DIR__ . '/../../data/users.ser'));
        foreach ($users as $key => $value) {
            if ($users[$key]['id'] === $_SESSION['uid']){
                unset($users[$key]);
            }
        }
        file_put_contents(__DIR__ . '/../../data/users.ser', serialize($users));
        
        //LogOut
        $_SESSION['login'] = '0';
        $_SESSION['uid'] = null;
        $_SESSION['msg'] = 'Loged Out successfully.';
        $_SESSION['msgType'] = 'green';
        header('Location: http://localhost/bank/index.php');
    } else {
        echo 'User not found';
        var_dump($_SESSION);
        // header('Location: http://localhost/bank/index.php');
        // die;
    }
}