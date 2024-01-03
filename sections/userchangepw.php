<?php if (isset($_SESSION['login']) && ($_SESSION['login'] === '1' )){ 
    
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
    <button type="submit">Save password</button>
    <button type="reset">Reset Form</button>
</form> 