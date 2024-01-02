<?php if (isset($_SESSION['login']) && ($_SESSION['login'] === '1' )){ 
       if (isset($_GET['acc'])){
        $accid = intval($_GET['acc']);
        // Check if user owns account
        $accounts = unserialize(file_get_contents(__DIR__ . '/../data/accounts.ser'));
        $accounts = array_filter($accounts, fn($account) => ($account['uid'] === $_SESSION['uid']));
        $err= '';
        if (count($accounts) < 2){
            $err .= 'Cannot delete. User must have at least 1 account.<br/>';
        }
        $accounts = array_filter($accounts, fn($account) => ($account['id'] === $accid));
        $accounts = array_values($accounts);
        if (count($accounts) === 0){
            $err .= 'Account not found.<br/>';
        } elseif($accounts[0]['amount'] !== 0){     //Check if account is empty
            $err .= 'Canot delete - account is not empty (' . $accounts[0]['amount'] . ').<br/>';
        }

        if ($err !== ''){
            $_SESSION['msg'] = 'Error: ' . $err ;
            $_SESSION['msgType'] = 'red';
            header('Location: http://localhost/bank/index.php?p=accountsview');
        }
       }
    } else {
        header('Location: http://localhost/bank/index.php');
    die;
}?>

<h1>Delete money account <?= $accounts[0]['iban']?>?</h1>
<form action="http://localhost/bank/process/accounts/delete.php" method="post">
    <input type="hidden" name="acc" value="<?= $accid ?>"></input>
    <button type="submit">Confirm deletion</button>
</form>