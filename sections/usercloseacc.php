<?php if (isset($_SESSION['login']) && ($_SESSION['login'] === '1' )){ 
    $isAdmin = false;
    $admins = unserialize(file_get_contents(__DIR__ . '/../data/admins.ser'));
    if (in_array($_SESSION['uid'], $admins)){
        $isAdmin = true;
        if(isset($_GET['usr'])){
            $users = unserialize(file_get_contents(__DIR__ . '/../data/users.ser'));
            $userExists = false;
            foreach($users as $user) {
                if ($user['id'] === intval($_GET['usr'])){
                    $userExists = true;
                }
            }
            if ($userExists){
                $usrInput = '<input type="hidden" name="usr" value="'. $_GET['usr'] .'">';
                $uid = intval($_GET['usr']);
            }else{
                header('Location: http://localhost/bank/index.php');
                die;
            }
            
        }else{
            $usrInput = '';
            $uid = intval($_SESSION['uid']);
        }
    }else{
        $usrInput = '';
        $uid = intval($_SESSION['uid']);
    }



        // Check user money accounts
        $accounts = unserialize(file_get_contents(__DIR__ . '/../data/accounts.ser'));
        $accounts = array_filter($accounts, fn($account) => ($account['uid'] === $uid));
        $accounts = array_values($accounts);
        $err= '';
        
        if (count($accounts) !== 0){
        // there are acounts to check
            $amountSum = array_reduce($accounts, (fn($accu, $value) => $accu + $value['amount']), 0);
            if ($amountSum !== 0){
                $err = 'Cannot delete. Money account is not empty.';
            }
        }

        if ($err !== ''){
            $_SESSION['msg'] = 'Error: ' . $err ;
            $_SESSION['msgType'] = 'red';
            if (isset($userExists) &&  $userExists === true){
                header('Location: http://localhost/bank/index.php?p=adminuserdetails&usr=' . $uid);
                die;
            }else{
                header('Location: http://localhost/bank/index.php?p=userview');
                die;
            }
            
        }
       
    } else {
        header('Location: http://localhost/bank/index.php');
        die;
}?>

<h1>Delete BIT bank account?</h1>
<form action="http://localhost/bank/process/users/delete.php" method="post">
    <?= $usrInput ?>
    <button type="submit">Confirm deletion</button>
</form>