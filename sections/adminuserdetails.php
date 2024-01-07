<?php  if (isset($_SESSION['login']) && ($_SESSION['login'] === '1' )){
        $admins = unserialize(file_get_contents(__DIR__ . '/../data/admins.ser'));
        if (in_array($_SESSION['uid'], $admins)){
            $isAdmin = true;
            if(isset($_GET['usr'])){
                $users = unserialize(file_get_contents(__DIR__ . '/../data/users.ser'));
                $userExists = false;
                foreach($users as $user) {

                    if (strval($user['id']) === strval($_GET['usr'])){
                        $userExists = true;
                        $uid = $user['id'];
                        $ufname = $user['firstname'];
                        $ulname = $user['lastname'];
                        $uak = $user['ak'];
                        $uemail = $user['email'];
                    }
                }
                if (!$userExists){
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

<h1>User Details</h1>
<?php
    echo '<div class="acc_row">';
    echo '<div>ID: ' .  $uid . '</div>';
    echo '</div>';
    echo '<div class="details-head">Personal data</div>';
    echo '<div class="detail-row">';
    echo '<div><p><strong>First Name: </strong>'. $ufname .'</p>';
    echo '<p><strong>Last Name: </strong>'. $ulname .'</p>';
    echo '<p><strong>Email Name: </strong>'. $uemail .'</p>';
    echo '<p><strong>Personal identificartion code: </strong>'. $uak .'</p>';
    echo '<p><a href="#">Edit data</a> <a href="#">Delete user</a></p></div>';
    echo '</div>';
    echo '<div class="details-head">Money accounts</div>';

    $accounts = unserialize(file_get_contents(__DIR__ . '/../data/accounts.ser'));
    $accounts = array_filter($accounts, fn($account) => $account['uid'] === $uid);
    $i = 0;
    foreach ($accounts as $account) {
        echo '<div class="detail-row">';
        echo '<div>' . ++$i . '.</div>';
        echo '<div>' .  $account['iban'] . ' | ' . $account['amount'] . ' ' . $account['currency'] . ' | <a href="#">Add funds</a> | <a href="#">Withdraw funds</a> | <a href="#">View transactions</a> | <a href="#">Delete money account</a></div>';
        echo '</div>';
    }

?>
<h2>More actions</h2>
<p><a href="#">Add money account</a></p>
