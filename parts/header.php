<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/main.css">
    <title>Bit Bank</title>
</head>
<body>
    <header>
        <div class="logo">
            <a href="index.php">BIT Bank</a>
        </div>
        
        <ul class="user_menu">
            <li><a href="index.php?p=signup">Sign Up</a></li>    
            <li><a href="index.php?p=login">Log In</a></li>    
            <li><a href="/user/logout.php">Log Out</a></li>
        </ul>
    </header>

<!-- Message handling -->
    <?php
    session_start();
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