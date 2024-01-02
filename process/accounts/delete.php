<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        // show 405 error response
        header('HTTP/1.1 405 Method Not Allowed');
        die;
} else {
    session_start();
    if (isset($_SESSION['login']) && ($_SESSION['login'] === '1' && isset($_POST['acc']) )){ 
        $accid = intval($_POST['acc']);
        // Check if user owns account
        $accounts = unserialize(file_get_contents(__DIR__ . '/../../data/accounts.ser'));
        $accounts = array_filter($accounts, fn($account) => ($account['uid'] === $_SESSION['uid']));
        $err= '';
        if (count($accounts) < 2){
            $err .= 'Cannot delete. User must have at least 1 account.<br/>';
        }
        $accounts = array_filter($accounts, fn($account) => ($account['id'] === $accid));
        $accounts = array_values($accounts);
        if (count($accounts) === 0){
            $err .= 'Account not found.<br/>';
        } elseif($accounts[0]['amount'] !== 0){     //Check if account is empty
            $err .= 'Canot delete - account is not empty (' . $accounts[0]['amount'] . ').<br/>';
        }

        if ($err !== ''){
            $_SESSION['msg'] = 'Error: ' . $err ;
            $_SESSION['msgType'] = 'red';
            header('Location: http://localhost/bank/index.php?p=accountsview');
        }
        

        $accounts = unserialize(file_get_contents(__DIR__ . '/../../data/accounts.ser'));
    
        foreach ($accounts as $key => $value) {
            if($accounts[$key]['id'] === $accid){
                unset($accounts[$key]);
            }
        }

        $accounts = array_values($accounts);
        
        // echo '<pre>';
        // print_r($accounts);
        // echo '</pre>';
        file_put_contents(__DIR__ . '/../../data/accounts.ser', serialize($accounts));

        $_SESSION['msg'] = 'Money account deleted successfully.';
        $_SESSION['msgType'] = 'green';

        header('location: http://localhost/bank/index.php?p=accountsview');
    }else{
        header('location: http://localhost/bank/index.php');
        die;
    }
}