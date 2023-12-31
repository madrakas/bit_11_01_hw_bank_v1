<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        // show 405 error response
        header('HTTP/1.1 405 Method Not Allowed');
        die;
    }else{
        session_start();
        $_SESSION['login'] = '0';
        $_SESSION['uid'] = null;
        $_SESSION['msg'] = 'Loged Out successfully.';
        $_SESSION['msgType'] = 'green';
        header('Location: http://localhost/bank/index.php');
    }
?>