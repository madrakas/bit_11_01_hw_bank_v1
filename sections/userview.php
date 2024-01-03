<?php if (isset($_SESSION['login']) && ($_SESSION['login'] === '1' )){ 
    $users = unserialize(file_get_contents(__DIR__ . '/../data/users.ser'));
    $users = array_filter($users, fn($user) => ($user['id'] === $_SESSION['uid']));
    $users = array_values($users);
    $firstname = $users[0]['firstname'] ?? '';
    $lastname = $users[0]['lastname'] ?? '';
    $email = $users[0]['email'] ?? '';
    $ak = $users[0]['ak'] ?? '';

} else {
    header('Location: http://localhost/bank/index.php');
    die;
}?>


<h1>Your Bit Bank account</h1>
    <p><strong>First name: </strong> <?= $firstname?>.</p>
    <p><strong>Last name: </strong><?= $lastname?>.</p>
    <p><strong>Personal identification number: </strong> <?= $ak?>.</p>
    <p><strong>Email address: </strong> <?= $email?>.</p>
    

    <h2>Change your data</h2>
    <p><a href="index.php?p=useredit">Edit personal information</a></p>
    <p><a href="index.php?p=userchangepw">Change password</a></p>
    <p><a href="index.php?p=usercloseacc">Close acount</a></p>

