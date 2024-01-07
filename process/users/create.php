<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        // show 405 error response
        header('HTTP/1.1 405 Method Not Allowed');
        die;
} else {
        session_start();
        $isAdmin = false;
        if (isset($_SESSION['login']) && ($_SESSION['login'] === '1' )){
            $admins = unserialize(file_get_contents(__DIR__ . '/../../data/admins.ser'));
            if (in_array($_SESSION['uid'], $admins)){
                $isAdmin = true;
            }      
        }

        $firstname = $_POST['firstname'] ?? '';
        $lastname = $_POST['lastname'] ?? '';
        $ak = $_POST['ak'] ?? '';
        $email = $_POST['email'] ?? '';
        $pw1 = $_POST['pw1'] ?? '';
        $pw2 = $_POST['pw2'] ?? '';

        $err ='';
        $users = unserialize(file_get_contents(__DIR__ . '/../../data/users.ser'));

        if ($firstname === '' || $lastname === '' || $ak === '' || $email === '' || $pw1 === '' || $pw2 === ''){
                $err .= 'All fields are required.<br/>';
        }elseif ($pw1 !== $pw2) {
                $err .= 'Passwords do not match.<br/>';
        } elseif(!validPersonalCode($ak)){
                $err .= 'Invalid Personal identification number.<br/>';
        } elseif (count(array_filter($users, fn($user) => ($user['email'] === $email))) > 0) {
                $err .= 'User with same Email already exists.<b/r>.';
        } elseif (count(array_filter($users, fn($user) => ($user['ak'] === $ak))) > 0){
                $err .= 'User with same Personal identification number already exists.<b/r>';
        } elseif (strlen($firstname) < 4){
                $err .= 'First name must be 4 letters or longer';
        } elseif (strlen($lastname) < 4){
                $err .= 'Last name must be 4 letters or longer';
        }
        
        if ($err === ''){
                // create new user
                $usersMaxID = unserialize(file_get_contents(__DIR__ . '/../../data/users-max-id.ser'));
                $users[]= [
                        'id' => ++$usersMaxID, 
                        'firstname' => $firstname,
                        'lastname' => $lastname,
                        'email' => $email,
                        'ak' => $ak,
                        'password' => sha1($pw1),
                ];
                                
                // echo '<pre>';
                // print_r($users);
                // echo '</pre>';
                
                file_put_contents(__DIR__ . '/../../data/users.ser',  serialize($users));
                file_put_contents(__DIR__ . '/../../data/users-max-id.ser',  serialize($usersMaxID));

                // Add account
                $accounts = unserialize(file_get_contents(__DIR__ . '/../../data/accounts.ser'));
                $maxAccountID = unserialize(file_get_contents(__DIR__ . '/../../data/accounts-max-id.ser'));
                $accounts[] = [
                    'id' => ++$maxAccountID,
                    'uid' => $usersMaxID,
                    'iban' => 'LT' . rand(0, 9) . rand(0, 9) . '99999' . str_pad(++$maxAccountID, 10, '0', STR_PAD_LEFT),
                    'amount' => rand(100, 1000),
                    'currency' => 'Eur',
                ];

                // echo '<pre>';
                // print_r($accounts);
                // echo '</pre>';
                file_put_contents(__DIR__ . '/../../data/accounts.ser', serialize($accounts));
                file_put_contents(__DIR__ . '/../../data/accounts-max-id.ser', serialize($maxAccountID));
                
                //Create Success message
                
                $_SESSION['msg'] = 'User created successfully.';
                $_SESSION['msgType'] = 'green';
                if ($isAdmin === true){
                        // Go to users list page
                        header('location: http://localhost/bank/index.php?p=adminlistusers');
                }else{
                        // Go to login page
                        header('location: http://localhost/bank/index.php?p=login');
                }

                
        } else {
                // create error message
                
                $_SESSION['msg'] = 'Error: ' . $err;
                $_SESSION['msgType'] = 'red';
                echo 'Klaida: ' . $err;
                // Go back to form page
                
                header('location: http://localhost/bank/index.php?p=signup&firstname=' . $firstname . '&lastname=' . $lastname . '&ak='. $ak . '&email=' . $email);
        }

}

die;

function validPersonalCode($code): bool
{
    if (strlen($code) === 11) {
        if ($code[0] >= 1 && $code[0] <= 6) {
            if (checkdate(substr($code, 3, 2), substr($code, 5, 2), substr($code, 1, 2))) {
                $s = $code[0] * 1 + $code[1] * 2 + $code[2] * 3 + $code[3] * 4 + $code[4] * 5 + $code[5] * 6 + $code[6] * 7 + $code[7] * 8 + $code[8] * 9 + $code[9] * 1;
                if ($s % 11 === 10) {
                    $s = $code[0] * 3 + $code[1] * 4 + $code[2] * 5 + $code[3] * 6 + $code[4] * 7 + $code[5] * 8 + $code[6] * 9 + $code[7] * 1 + $code[8] * 2 + $code[9] * 3;
                    if ($s % 11 === 10 && $s % 11 == $code[10]) {
                        return true;
                    } elseif ($s % 11 == $code[10]) {
                        return true;
                    }
                } elseif ($s % 11 == $code[10]) {
                    return true;
                }
            }
        }
    }
    return false;
}

?>