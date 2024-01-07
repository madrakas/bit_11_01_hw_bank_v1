<?php if (isset($_SESSION['login']) && ($_SESSION['login'] === '1' )){ 
    $isAdmin = false;
    $admins = unserialize(file_get_contents(__DIR__ . '/../data/admins.ser'));
    if (in_array($_SESSION['uid'], $admins)){
        $isAdmin = true;
        if(isset($_GET['usr'])){
            $users = unserialize(file_get_contents(__DIR__ . '/../data/users.ser'));
            $userExists = false;
            foreach($users as $user) {
                if ($user['id'] === intval($_GET['usr'])){
                    $userExists = true;
                }
            }
            if ($userExists){
                $usrInput = '<input type="hidden" name="usr" value="'. $_GET['usr'] .'">';
            }else{
                header('Location: http://localhost/bank/index.php');
                die;
            }
            
        }else{
            $usrInput = '';
        }
    }
} else {
    header('Location: http://localhost/bank/index.php');
    die;
}?>

<h1>Change password</h1>

<form action="http://localhost/bank/process/users/editpw.php" method='post'>
    <label for="pw1">Password</label>
    <input id="pw1" name="pw1" type="password"></input>
    <label for="pw2">Repeat Password</label>
    <input id="pw2" name="pw2" type="password"></input>
    <?= $usrInput ?>
    <button type="submit">Save password</button>
    <button type="reset">Reset Form</button>
</form> 