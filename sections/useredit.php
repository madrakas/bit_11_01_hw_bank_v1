<?php 
if (isset($_SESSION['login']) && ($_SESSION['login'] === '1' )){ 
    if (isset($_GET['usr'])){
        $uid = intval($_GET['usr']);
        $users = unserialize(file_get_contents(__DIR__ . '/../data/users.ser'));
        $userExists = false;
        foreach($users as $user) {
            if ($user['id'] === $uid){
                $userExists = true;
                $firstname = $user['firstname'];
                $lastname = $user['lastname'];
                $ak = $user['ak'];
                $email = $user['email'];
            }
        }
        $isAdmin = false;
        $admins = unserialize(file_get_contents(__DIR__ . '/../data/admins.ser'));
        if (in_array($_SESSION['uid'], $admins)){
            $isAdmin = true;
        }
        if ($isAdmin && $userExists ){
            $usrInput ='<input type="hidden" name="usr" value="' . $uid .'"></input>';
        } else {
            header('Location: http://localhost/bank/index.php');
            die;
        }
    } else{
        $users = unserialize(file_get_contents(__DIR__ . '/../data/users.ser'));
        $users = array_filter($users, fn($user) => ($user['id'] === $_SESSION['uid']));
        $users = array_values($users);
        $firstname = $users[0]['firstname'] ?? '';
        $lastname = $users[0]['lastname'] ?? '';
        $email = $users[0]['email'] ?? '';
        $ak = $users[0]['ak'] ?? '';
        $usrInput = '';
    } 
}else {
    header('Location: http://localhost/bank/index.php');
    die;
}?>


<h1>Edit your Bit Bank account</h1>
<form action="http://localhost/bank/process/users/edit.php" method='post'>
    
    <label for="firstname">First name</label>
    <input id="firstname" name="firstname" type="text" value="<?= $firstname?>"></input>
    <label for="lastname">Last name</label>
    <input id="lastname" name="lastname" type="text" value="<?= $lastname?>"></input>
    <label for="ak">Personal identification number</label>
    <input id="ak" name="ak" type="text" value="<?= $ak?>"></input>
    <label for="email">Email address</label>
    <input id="email" name="email" type="text" value="<?= $email?>"></input>
    <?= $usrInput ?>
    <button type="submit">Save changes</button>
    <button type="reset">Reset Form</button>
</form> 