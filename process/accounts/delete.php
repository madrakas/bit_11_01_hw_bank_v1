<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        // show 405 error response
        header('HTTP/1.1 405 Method Not Allowed');
        die;
} else {
    session_start();

    if (isset($_SESSION['login']) && ($_SESSION['login'] === '1' && isset($_POST['acc']) )){ 
        $accid = intval($_POST['acc']);
        $notMyAcc = false;
        $accounts = unserialize(file_get_contents(__DIR__ . '/../../data/accounts.ser'));
        $accounts = array_filter($accounts, fn($account) => ($account['id'] === $accid));
        $accounts = array_values($accounts);
        $accUid = $accounts[0]['uid'];

        if ($accUid !== $_SESSION['uid']){   // user doesn't own account
            $admins = unserialize(file_get_contents(__DIR__ . '/../../data/admins.ser'));
            if (in_array($_SESSION['uid'], $admins)){
                $isAdmin = true;   // if user is admin we may continue
                $notMyAcc =true;
            }else{
                header('Location: http://localhost/bank/index.php');   // dead end if not admin
                die;
            }
        } else { // user owns account

        }

        // at this point acount either belongs to user either user is admin, so we are good
        $accounts = unserialize(file_get_contents(__DIR__ . '/../../data/accounts.ser'));
        $accounts = array_filter($accounts, fn($account) => ($account['uid'] === $accUid));
        $err= '';
        if (count($accounts) < 2){
            $err .= 'Cannot delete. User must have at least 1 account.<br/>';
        }

        $accounts = unserialize(file_get_contents(__DIR__ . '/../../data/accounts.ser'));
        $accounts = array_filter($accounts, fn($account) => ($account['id'] === $accid));
        $accounts = array_values($accounts);
        if ($accounts[0]['amount'] !== 0){     //Check if account is empty
            $err .= 'Canot delete - account is not empty (' . $accounts[0]['amount'] . ').<br/>';
        }

        if ($err !== ''){
            $_SESSION['msg'] = 'Error: ' . $err ;
            $_SESSION['msgType'] = 'red';
            header('Location: http://localhost/bank/index.php?p=accountsview');
            die;
        }

        $accounts = unserialize(file_get_contents(__DIR__ . '/../../data/accounts.ser'));
    
        foreach ($accounts as $key => $value) {
            if($accounts[$key]['id'] === $accid){
                unset($accounts[$key]);
            }
        }

        $accounts = array_values($accounts);
        file_put_contents(__DIR__ . '/../../data/accounts.ser', serialize($accounts));

        $_SESSION['msg'] = 'Money account deleted successfully.';
        $_SESSION['msgType'] = 'green';

        if ($notMyAcc){
            header('location: http://localhost/bank/index.php?p=adminuserdetails&usr=' . $accUid);
            die;
        }else{
            header('location: http://localhost/bank/index.php?p=accountsview');
            die;
        }
    }else{
        header('location: http://localhost/bank/index.php');
        die;
    }
}