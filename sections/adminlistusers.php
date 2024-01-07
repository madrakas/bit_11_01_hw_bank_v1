<?php  if (isset($_SESSION['login']) && ($_SESSION['login'] === '1' )){
        $admins = unserialize(file_get_contents(__DIR__ . '/../data/admins.ser'));
        if (in_array($_SESSION['uid'], $admins)){
            $isAdmin = true;
     
        } else {
            header('Location: http://localhost/bank/index.php?p=accountsview');
            die;
        }
    } else {
        header('Location: http://localhost/bank/index.php');
        die;
    }

?>

<h1>List of Users</h1>

<?php 
    $users = unserialize(file_get_contents(__DIR__ . '/../data/users.ser'));
    usort($users, fn($a, $b) => ($b['lastname'] <= $a['lastname']));
    $i = 0;
    foreach ($users as $user) {
        echo '<div class="acc_row">';
        echo '<div>' . ++$i . '.</div>';
        echo '<div>' .  $user['id'] . '</div>';
        echo '<div>' .  $user['firstname'] . '</div>';
        echo '<div>' .  $user['lastname'] . '</div>';
        echo '<div><a href="http://localhost/bank/index.php?p=adminuserdetails&usr='. $user['id'] .'">Show details</a></div>';
        echo '</div>';
    }
    // echo '<pre>';
    // print_r($users);
    // echo '</pre>';
?>

<h2>More actions</h2>
    <p><a href="index.php?p=signup">Add new user</a></p>
