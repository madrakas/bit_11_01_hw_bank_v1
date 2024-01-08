<?php  if (isset($_SESSION['login']) && ($_SESSION['login'] === '1' )){
        $admins = unserialize(file_get_contents(__DIR__ . '/../data/admins.ser'));
        if (in_array($_SESSION['uid'], $admins)){
            $isAdmin = true;
            if(isset($_GET['accid'])){
               
                $accounts = unserialize(file_get_contents(__DIR__ . '/../data/accounts.ser'));
                $accountExists = false;
                foreach($accounts as $account) {

                    if ($account['id'] === intval($_GET['accid'])){
                        $accountExists = true;
                        $accid = $account['id'];
                        $iban = $account['iban'];
                    }
                }
                if (!$accountExists){
                    // echo "No account";
                    header('Location: http://localhost/bank/index.php?p=adminlistusers');
                    die;
                }
            }else{
                header('Location: http://localhost/bank/index.php?p=adminlistusers');
                die;
            }
        } else {
            header('Location: http://localhost/bank/index.php?p=accountsview');
            die;
        }
    } else {
        header('Location: http://localhost/bank/index.php');
        die;
    }


?>

<h1>Withdraw Funds from <?= $iban ?></h1>
<form action="http://localhost/bank/process/accounts/remfunds.php" method="post">
    <input type="number" name="amount"></input>
    <input type="hidden" name="accid" value="<?= $accid ?>"></input>
    <button type="submit">Withdraw Funds</button>
    <button type="reset">Reset</button>
</form>

<?php
    
?>
