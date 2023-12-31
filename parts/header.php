<?php
    session_start();
    if (isset($_SESSION['login']) && ($_SESSION['login'] === '1' )){
        $headerClass = 'logedin';
    } else {
        $headerClass = '';
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/main.css">
    <title>Bit Bank</title>
</head>
<body>
    <header class="<?= $headerClass?>">
        <div class="logo">
            <a href="index.php">BIT Bank</a>
        </div>
        
        <ul class="user_menu">
        <?php if (isset($_SESSION['login']) && ($_SESSION['login'] === '1' )){ ?>
            <li><form action="http://localhost/bank/process/session/destroy.php"" method='post'><button type="submit">Log Out</button></form></li>
        <?php } else { ?>
            <li><a href="index.php?p=signup">Sign Up</a></li>    
            <li><a href="index.php?p=login">Log In</a></li>    
        <?php } ?>
            
        </ul>
    </header>

<!-- Message handling -->
    <?php
    if (isset($_SESSION['msg'])){
        $msg = $_SESSION['msg'];
        unset($_SESSION['msg']);
        if (isset($_SESSION['msgType'])){
            $msgType = $_SESSION['msgType'];
            unset($_SESSION['msgType']);
        } else {
            $msgType = 'blue';
        }
        echo '<div class="message '. $msgType .'">';
        echo $msg;
        echo '</div>';
    } 
    ?>