<?php 
    if (isset($_SESSION['login']) && ($_SESSION['login'] === '1' )){
        $admins = unserialize(file_get_contents(__DIR__ . '/../data/admins.ser'));
        if (in_array($_SESSION['uid'], $admins)){
            $isAdmin = true;
            $footerClass = 'admin';
        } else {
            $footerClass = 'logedin';
            $isAdmin = false;
        }
        
    } else {
        $footerClass = '';
    }
?>

<footer class="<?= $footerClass?>">
    
        <div class="logo">
            BIT Bank
        </div>
    </footer>
</body>
</html>