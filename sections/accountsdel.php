<?php if (isset($_SESSION['login']) && ($_SESSION['login'] === '1' )){ 
       if (isset($_GET['acc'])){
        $accid = intval($_GET['acc']);
        
        // Check if user owns account
        $accounts = unserialize(file_get_contents(__DIR__ . '/../data/accounts.ser'));
        $accounts = array_filter($accounts, fn($account) => ($account['id'] === $accid));
        $accounts = array_values($accounts);
        $accUid = $accounts[0]['uid'];
        if ($accUid !== $_SESSION['uid']){   // user doesn't own account
            $admins = unserialize(file_get_contents(__DIR__ . '/../data/admins.ser'));
            if (in_array($_SESSION['uid'], $admins)){
                $isAdmin = true;   // if user is admin we may continue
            }else{
                header('Location: http://localhost/bank/index.php');   // dead end if not admin
                die;
            }
        } else { // user owns account

        }
        
        // at this point acount either belongs to user either user is admin, so we are good
        $accounts = unserialize(file_get_contents(__DIR__ . '/../data/accounts.ser'));
        $accounts = array_filter($accounts, fn($account) => ($account['uid'] === $accUid));
        $err= '';
        if (count($accounts) < 2){
            $err .= 'Cannot delete. User must have at least 1 account.<br/>';
        }
        
        $accounts = unserialize(file_get_contents(__DIR__ . '/../data/accounts.ser'));
        $accounts = array_filter($accounts, fn($account) => ($account['id'] === $accid));
        $accounts = array_values($accounts);
        if ($accounts[0]['amount'] !== 0){     //Check if account is empty
            $err .= 'Canot delete - account is not empty (' . $accounts[0]['amount'] . ').<br/>';
        }

        if ($err !== ''){
            $_SESSION['msg'] = 'Error: ' . $err ;
            $_SESSION['msgType'] = 'red';
            // echo '<pre>';
            // print_r ($accounts);
            // echo '</pre>';
            // echo $accounts[0]['amount'];
            header('Location: http://localhost/bank/index.php?p=accountsview');
            die;
        }
       }else{
        header('Location: http://localhost/bank/index.php');
        die;
       }
    
    
    } else {
        header('Location: http://localhost/bank/index.php');
        die;
    }
    
    ?>

<h1>Delete money account <?= $accounts[0]['iban']?>?</h1>
<form action="http://localhost/bank/process/accounts/delete.php" method="post">
    <input type="hidden" name="acc" value="<?= $accid ?>"></input>
    <button type="submit">Confirm deletion</button>
</form>