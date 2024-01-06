<?php  if (isset($_SESSION['login']) && ($_SESSION['login'] === '1' )){
        $admins = unserialize(file_get_contents(__DIR__ . '/../data/admins.ser'));
        if (in_array($_SESSION['uid'], $admins)){
            $isAdmin = true;
            if(isset($_GET['usr'])){
                $users = unserialize(file_get_contents(__DIR__ . '/../data/users.ser'));
                $userExists = false;
                foreach($users as $user) {
                    if ($user['id'] === strval($_GET['usr'])){
                        $userExists = true;
                        $usrid = $user['id'];
                        $ufname = $user['firstname'];
                        $ulname = $user['lastname'];
                        $uak = $user['ak'];
                        $uemail = $user['email'];
                        echo ($uak);
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
    echo '<div>ID: ' .  $usrid . '</div>';
    echo '</div>';
?>