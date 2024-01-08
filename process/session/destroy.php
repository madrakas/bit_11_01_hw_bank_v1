<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        // show 405 error response
        header('HTTP/1.1 405 Method Not Allowed');
        die;
    }else{
        session_start();
        if (isset($_SESSION['login']) && ($_SESSION['login'] === '1' )){ 
            $logins = unserialize(file_get_contents(__DIR__ . '/../../data/logins.ser'));
            $logins[] = [
                'time' => date('Y-m-d H:i:s'),
                'user' => $_SESSION['uid'],
                'status' => 'Logout ok',
            ];
            file_put_contents(__DIR__ . '/../../data/logins.ser', serialize($logins));
        }

        $_SESSION['login'] = '0';
        $_SESSION['uid'] = null;
        $_SESSION['msg'] = 'Loged Out successfully.';
        $_SESSION['msgType'] = 'green';
        header('Location: http://localhost/bank/index.php');
    }
?>