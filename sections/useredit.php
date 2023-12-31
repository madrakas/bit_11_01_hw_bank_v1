<?php if (isset($_SESSION['login']) && ($_SESSION['login'] === '1' )){ 
    $users = unserialize(file_get_contents(__DIR__ . '/../data/users.ser'));
    $users = array_filter($users, fn($user) => ($user['id'] === $_SESSION['uid']));
    $firstname = $users[0]['firstname'] ?? '';
    $lastname = $users[0]['lastname'] ?? '';
    $email = $users[0]['email'] ?? '';
    $ak = $users[0]['ak'] ?? '';

} else {
    header("HTTP/1.1 401 Unauthorized");
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

    <button type="submit">Save changes</button>
    <button type="reset">Reset Form</button>
</form> 