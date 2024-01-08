<?php if (isset($_SESSION['login']) && ($_SESSION['login'] === '1' )){ 
    if (isset($_GET['usr'])){
        $isAdmin = false;
        if (isset($_SESSION['login']) && ($_SESSION['login'] === '1' )){
            $admins = unserialize(file_get_contents(__DIR__ . '/../data/admins.ser'));
            if (in_array($_SESSION['uid'], $admins)){
                $isAdmin = true;
            }      
        }
        if (!$isAdmin){
            header('Location: http://localhost/bank/index.php');
            die;
        }
        $users = unserialize(file_get_contents(__DIR__ . '/../data/users.ser'));
        $userExists = false;
        foreach($users as $user) {

            if (strval($user['id']) === strval($_GET['usr'])){
                $userExists = true;
                $uid = $user['id'];
                $ufname = $user['firstname'];
                $ulname = $user['lastname'];
                $uak = $user['ak'];
                $uemail = $user['email'];
            }
        }
        if (!$userExists){
            header('Location: http://localhost/bank/index.php?p=adminlistusers');
            die;
        }
        $usrInput = '<input type="hidden" name="usr" value="'. $uid .'"></input>';
    }else{
        $usrInput = '';
    }
    
} else {
    header('Location: http://localhost/bank/index.php');
    die;
}?>

<h1>Add new money account?</h1>
<form action="http://localhost/bank/process/accounts/add.php" method="post">
    <?= $usrInput ?>
    <button type="submit">Add account</button>
</form>