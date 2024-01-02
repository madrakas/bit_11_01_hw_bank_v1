<?php if (isset($_SESSION['login']) && ($_SESSION['login'] === '1' )){ 
       
    } else {
        header('Location: http://localhost/bank/index.php');
    die;
}?>

<h1>Add new money account?</h1>
<form action="http://localhost/bank/process/accounts/add.php" method="post">
    <button type="submit">Add account</button>
</form>