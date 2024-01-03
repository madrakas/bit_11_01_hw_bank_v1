<?php if (isset($_SESSION['login']) && ($_SESSION['login'] === '1' )){ 
    $users = unserialize(file_get_contents(__DIR__ . '/../data/users.ser'));
    $users = array_filter($users, fn($user) => ($user['id'] === $_SESSION['uid']));
    $users = array_values($users);
    $firstname = $users[0]['firstname'] ?? '';
    $lastname = $users[0]['lastname'] ?? '';
} else {
    header('Location: http://localhost/bank/index.php');
    die;
}?>

<h1>New transaction</h1>

<form action="http://localhost/bank/process/transactions/new.php" method="post">
    <label for="sender">Sender</label>
    <p id="sender"><?= $firstname . ' ' . $lastname?></p>
    <label for="acc">Sender account</label>
    <select name="acc" id="acc">
    
    <?php 
    $accounts = unserialize(file_get_contents(__DIR__ . '/../data/accounts.ser'));
    $accounts = array_filter($accounts, fn($account) => ($account['uid'] === $_SESSION['uid']));
    foreach($accounts as $account) {
        echo '<option value="' . $account['id'] . '">' . $account['iban'] . ' (' . $account['amount'] . ' ' . $account['currency'] . ')';
    }
    ?>    
    
    </select>
    <label>Recipient account</label>
    <input id="riban" name="riban"></input>
    <label for="rname">Recipient name</label>
    <input id="rname" name="rname"></input>
    <label for="amount">Amount</label>
    <input id="amount" name="amount"></input>

    <button type="submit">Transfer money</button>
    <button type="reset">Reset form</button>
</form>