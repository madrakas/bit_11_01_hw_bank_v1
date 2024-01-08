<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        // show 405 error response
        header('HTTP/1.1 405 Method Not Allowed');
        die;
} else {
    
    session_start();
    if (isset($_SESSION['login']) && ($_SESSION['login'] === '1' )){ 
        if (isset($_POST['accid'])){
            $accid = intval($_POST['accid']);
            //Check if user is admin
            $isAdmin = false;
            $admins = unserialize(file_get_contents(__DIR__ . '/../../data/admins.ser'));
            if (in_array($_SESSION['uid'], $admins)){
                $isAdmin = true;
            }
            if (!$isAdmin){
                header('Location: http://localhost/bank/index.php');
                die;
            } 
        } else {
            header('Location: http://localhost/bank/index.php');
            die;
        }
        
    }else{
        header('Location: http://localhost/bank/index.php');
        die;
    }

    if (intval($_POST['amount']) < 0){
        $_SESSION['msg'] = "To reduce money use witdraw function";
        $_SESSION['msgType'] = 'red';
        header('location: http://localhost/bank/index.php?p=adminaccaddfunds&accid=' . $accid);
        die;
    }

    $accounts = unserialize(file_get_contents(__DIR__ . '/../../data/accounts.ser'));
    $accUid = 0;
    foreach ($accounts as $key => $value) {
        if ($accounts[$key]['id'] === $accid) {
            // echo "radau";
            $accounts[$key]['amount'] = $accounts[$key]['amount'] + intval($_POST['amount']);
            $accUid = $accounts[$key]['uid'];
            $riban = $accounts[$key]['iban'];
            $curr = $accounts[$curr];
        }
    }

    if ($accid === 0){
        $_SESSION['msg'] = "Culdn't add funds.";
        $_SESSION['msgType'] = 'red';
        header('location: http://localhost/bank/index.php?p=adminlistusers');
        die;
    }else{
        file_put_contents(__DIR__ . '/../../data/accounts.ser', serialize($accounts));

        
        //log transaction
        $users = unserialize(file_get_contents(__DIR__ . '/../../data/users.ser'));
        $users = array_filter($users, fn($user) => ($user['id'] === $accid));
        $users = array_values($users);
        $firstname = $users[0]['firstname'] ?? '';
        $lastname = $users[0]['lastname'] ?? '';
        $transfers = unserialize(file_get_contents(__DIR__ . '/../../data/transfers.ser'));
        $transfers[] = [
            'time' => date('Y-m-d H:i:s'),
            'from' => 0,
            'to' => $accid,
            'toIBAN' => $riban,
            'fromIBAN' => 'Cash',
            'fromName' => $firstname . ' ' . $lastname,
            'toName' => $firstname . ' ' . $lastname,
            'amount' => intval($_POST['amount']),
            'curr' => $curr
        ];
        file_put_contents(__DIR__ . '/../../data/transfers.ser', serialize($transfers));

        $_SESSION['msg'] = 'Funds added successfully.';
        $_SESSION['msgType'] = 'green';
        header('location: http://localhost/bank/index.php?p=adminuserdetails&usr=' . $accUid);
        die;
    }
    
}