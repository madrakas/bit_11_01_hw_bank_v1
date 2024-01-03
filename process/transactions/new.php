<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        // show 405 error response
        header('HTTP/1.1 405 Method Not Allowed');
        die;
} else {
    $acc = $_POST['acc'] ?? '';
    $riban = $_POST['riban'] ?? '';
    $rname = $_POST['rname'] ?? '';
    $samount = ($_POST['amount']) ?? '';
    $acc = intval($acc);
    $samount = intval($samount);

    session_start();
    if (isset($_SESSION['login']) && ($_SESSION['login'] === '1' )){ 
        $users = unserialize(file_get_contents(__DIR__ . '/../../data/users.ser'));
        $users = array_filter($users, fn($user) => ($user['id'] === $_SESSION['uid']));
        $users = array_values($users);
        $firstname = $users[0]['firstname'] ?? '';
        $lastname = $users[0]['lastname'] ?? '';

        $accounts = unserialize(file_get_contents(__DIR__ . '/../../data/accounts.ser'));
        $accounts = array_filter($accounts, fn($account) => ($account['id'] === $acc && $account['uid'] === $_SESSION['uid']));
        $accounts = array_values($accounts);
        $curr =$accounts[0]['currency'];
        $fromIBAN = $accounts[0]['iban'];

        $err = '';
        if (count($accounts) < 1){
            $err .= "Sender's Account not found";
        } 

        if ($accounts[0]['amount'] < $samount){
            $err .= 'Insuficient funds in selected account';
        }

        $bankCode = substr($riban, 4, 5);
        if ($bankCode === '99999'){
           $accounts = unserialize(file_get_contents(__DIR__ . '/../../data/accounts.ser'));
           $accounts = array_filter($accounts, fn($account) => ($account['iban'] ===  $riban)); 
           if (count($accounts) < 1) {
               $err .= "Recipient's IBAN not found in BIT bank.";
           }   
        }
        

        if ($err !== ''){
            $_SESSION['msg'] = 'Error: ' . $err;
            $_SESSION['msgType'] = 'red';    
            echo $err;
            header('location: http://localhost/bank/index.php?p=transfernew');
            die;
        }



        //reduce amount
        $accounts = unserialize(file_get_contents(__DIR__ . '/../../data/accounts.ser'));
        foreach($accounts as $key=>$value){
            if ($accounts[$key]['id'] === $acc){
                $accounts[$key]['amount'] -= $samount;
            }
        }
        file_put_contents(__DIR__ . '/../../data/accounts.ser', serialize($accounts));
        
        //check if recipient's account is in Our bank
        $accounts = unserialize(file_get_contents(__DIR__ . '/../../data/accounts.ser'));
        $to = 0;
        foreach($accounts as $account){
            if ($account['iban'] === $riban){
                $to = $account['id'];
            }
        }

        //log transaction
        $transfers = unserialize(file_get_contents(__DIR__ . '/../../data/transfers.ser'));
        $transfers[] = [
            'time' => date('Y-m-d H:i:s'),
            'from' => $acc,
            'to' => $to,
            'toIBAN' => $riban,
            'fromIBAN' => $fromIBAN,
            'fromName' => $firstname . ' ' . $lastname,
            'toName' => $rname,
            'amount' => $samount,
            'curr' => $curr
        ];
        file_put_contents(__DIR__ . '/../../data/transfers.ser', serialize($transfers));

        //increase amount
        if ($to !==0) {
            $accounts = unserialize(file_get_contents(__DIR__ . '/../../data/accounts.ser'));
            foreach($accounts as $key=>$value){
                if ($accounts[$key]['id'] === $to){
                    $accounts[$key]['amount'] += $samount;
                }
        }
        file_put_contents(__DIR__ . '/../../data/accounts.ser', serialize($accounts));
        }

        $_SESSION['msg'] = $samount . ' ' . $curr . ' has been sent to ' . $rname;
        $_SESSION['msgType'] = 'green';

        header('location: http://localhost/bank/index.php?p=accountsview');
    }else{
        header('location: http://localhost/bank/index.php');
        die;
    }
}