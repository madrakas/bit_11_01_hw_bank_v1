<?php  if (isset($_SESSION['login']) && ($_SESSION['login'] === '1' )){
        $admins = unserialize(file_get_contents(__DIR__ . '/../data/admins.ser'));
        if (in_array($_SESSION['uid'], $admins)){
            $isAdmin = true;
            if(isset($_GET['usr'])){
                $users = unserialize(file_get_contents(__DIR__ . '/../data/users.ser'));
                $userExists = false;
                foreach($users as $user) {

                    if ($user['id'] === intval($_GET['usr'])){
                        $userExists = true;
                        $uid = $user['id'];
                        $ufname = $user['firstname'];
                        $ulname = $user['lastname'];
                    }
                }
                if (!$userExists){
                    header('Location: http://localhost/bank/index.php?p=adminlistusers');
                    die;
                }
            }
        } else {
            header('Location: http://localhost/bank/index.php');
            die;
        }
    } else {
        header('Location: http://localhost/bank/index.php');
        die;
    }

    $logins = unserialize(file_get_contents(__DIR__ . '/../data/logins.ser'));
    
if (isset($userExists) && $userExists){
    array_filter($logins, fn($login) => $login['user'] === $uid);
    echo '<h1>View '. $ufname . ' '. $ulname .'(ID: '. $uid .') login logs</h1>';
    echo '<div class="acc_row">';
    echo '<div>ID: '. $uid .'</div><div>'. $ufname .' ' . $ulname . '</div>';
    echo '</div>';
    $logins = array_filter($logins, fn($login) => $login['user'] === $uid);
    foreach($logins as $login){
        $uid = $login['user'];
        $user = array_values(array_filter($users, fn($user) => $user['id'] === $uid))[0];
        echo '<div class="detail-row">';
            echo $login['time'] . ', ' . $login['status'];
        echo '</div>';
    }
}else{
    echo '<h1>View login logs</h1>';

    $users = unserialize(file_get_contents(__DIR__ . '/../data/users.ser'));
    
    foreach($logins as $login){
        $uid = $login['user'];
        $user = array_values(array_filter($users, fn($user) => $user['id'] === $uid))[0];
        echo '<div class="detail-row">';
            echo 'ID ' . $uid . ', ' . $user['firstname'] . ' ' . $user['lastname'] . ':  ' . $login['time'] . ', ' . $login['status'];
        echo '</div>';
    }
}

?>

