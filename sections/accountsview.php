<?php if (isset($_SESSION['login']) && ($_SESSION['login'] === '1' )){ 
        $accounts = unserialize(file_get_contents(__DIR__ . '/../data/accounts.ser'));
        $accounts = array_filter($accounts, fn($account) => ($account['uid'] === $_SESSION['uid']));
    } else {
        header("HTTP/1.1 401 Unauthorized");
    die;
}?>


<h1>Your money accounts</h1>
    
    <?php 
        $i = 0;
        foreach($accounts as $account){

            ?>
            <div class="acc_row">
                <div class="acc_ln"><?= ++$i?>.</div>
                <div class="acc_iban"><?= $account['iban']?></div>
                <div class="acc_amouont"><?= $account['amount']?></div>
                <div class="acc_curr"><?= $account['currency']?></div>
                <div class="acc_del"><a href="index.php?p=accountsdel&acc=<?= $account['id']?>">Delete</a></div>
            </div>
            <?php
        }
    ?>

    <h2>More actions</h2>
    <p><a href="index.php?p=accountsadd">Add new money account</a></p>
