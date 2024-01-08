<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        // show 405 error response
        header('HTTP/1.1 405 Method Not Allowed');
        die;
} else {
    session_start();
    if (isset($_SESSION['login']) && ($_SESSION['login'] === '1' )){ 
        $uid = $_SESSION['uid'];
        
        if (isset($_POST['usr'])){
            $isAdmin = false;
                $admins = unserialize(file_get_contents(__DIR__ . '/../../data/admins.ser'));
                if (in_array($_SESSION['uid'], $admins)){
                    $isAdmin = true;
                }      
                if (!$isAdmin){
                    header('Location: http://localhost/bank/index.php');
                    die;
                }
                $users = unserialize(file_get_contents(__DIR__ . '/../../data/users.ser'));
                $userExists = false;
                foreach($users as $user) {
                    if ($user['id'] === intval($_POST['usr'])){
                        $userExists = true;
                        $uid = $user['id'];
                    }
                }
                
                if (!$userExists){
                    header('Location: http://localhost/bank/index.php?p=adminlistusers');
                    die;
                }
            
            }

        $accounts = unserialize(file_get_contents(__DIR__ . '/../../data/accounts.ser'));
        $maxAccountID = unserialize(file_get_contents(__DIR__ . '/../../data/accounts-max-id.ser'));
        $accounts[] = [
            'id' => ++$maxAccountID,
            'uid' => $uid,
            'iban' => 'LT' . rand(0, 9) . rand(0, 9) . '99999' . str_pad($maxAccountID, 10, '0', STR_PAD_LEFT),
            'amount' => 0,
            'currency' => 'Eur',
        ];
        // echo '<pre>';
        // print_r($accounts);
        // echo '</pre>';
        file_put_contents(__DIR__ . '/../../data/accounts.ser', serialize($accounts));
        file_put_contents(__DIR__ . '/../../data/accounts-max-id.ser', serialize($maxAccountID));

        $_SESSION['msg'] = 'Money account added successfully.';
        $_SESSION['msgType'] = 'green';
        if ($isAdmin && isset($userExists) && $userExists){
            header('location: http://localhost/bank/index.php?p=adminuserdetails&usr=' . $uid);
        }else{
            header('location: http://localhost/bank/index.php?p=accountsview');
        }
    }else{
        header('location: http://localhost/bank/index.php');
        die;
    }
}