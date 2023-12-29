<?php
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        // show 405 error response
        header('HTTP/1.1 405 Method Not Allowed');
        die;
}



header('Location: ' . __DIR__ . '/index.php');
die;
?>