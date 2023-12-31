<content>

    <?php 
        $page ?? '';
        switch ($page) {
            case 'signup':
                require(__DIR__ . '/../sections/signup.php');
                break;
            case 'login':
                require(__DIR__ . '/../sections/login.php');
                break;
            case 'logout':
                require(__DIR__ . '/../sections/logout.php');
                break;
            case 'useredit':
                require(__DIR__ . '/../sections/useredit.php');
                break;
            default:
                //consider if user is loged in when redirecting
                require(__DIR__ . '/../sections/main.php');
                //add page not found error here
                break;
        }
    ?>
</content>
