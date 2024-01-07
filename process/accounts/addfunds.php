<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        // show 405 error response
        header('HTTP/1.1 405 Method Not Allowed');
        die;
} else {
    
    session_start();
    if (isset($_SESSION['login']) && ($_SESSION['login'] === '1' )){ 
        if (isset($_POST['accid'])){
            $accid = intval($_POST['accid']);
            //Check if user is admin
            $isAdmin = false;
            $admins = unserialize(file_get_contents(__DIR__ . '/../../data/admins.ser'));
            if (in_array($_SESSION['uid'], $admins)){
                $isAdmin = true;
            }
            if (!$isAdmin){
                header('Location: http://localhost/bank/index.php');
                die;
            } 
        } else {
            header('Location: http://localhost/bank/index.php');
            die;
        }
        
    }else{
        header('Location: http://localhost/bank/index.php');
        die;
    }

    $accounts = unserialize(file_get_contents(__DIR__ . '/../../data/accounts.ser'));
    $accUid = 0;
    foreach ($accounts as $key => $value) {
        if ($accounts[$key]['id'] === $accid) {
            // echo "radau";
            $accounts[$key]['amount'] = $accounts[$key]['amount'] + $_POST['amount'];
            $accUid = $accounts[$key]['uid'];
        }
    }

    if ($accid === 0){
        $_SESSION['msg'] = "Culdn't add funds.";
        $_SESSION['msgType'] = 'red';
        header('location: http://localhost/bank/index.php?p=adminlistusers');
    }else{
        file_put_contents(__DIR__ . '/../../data/accounts.ser', serialize($accounts));
        $_SESSION['msg'] = 'Funds added successfully.';
        $_SESSION['msgType'] = 'green';
        header('location: http://localhost/bank/index.php?p=adminuserdetails&usr=' . $accUid);
    }
    
}