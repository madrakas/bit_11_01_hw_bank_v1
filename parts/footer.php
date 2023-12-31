<?php 
    if (isset($_SESSION['login']) && ($_SESSION['login'] === '1' )){
        $footerClass = 'logedin';
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