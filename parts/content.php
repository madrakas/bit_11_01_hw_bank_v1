

<?php 
if (isset($_SESSION['login']) && ($_SESSION['login'] === '1' )){
    $admins = unserialize(file_get_contents(__DIR__ . '/../data/admins.ser'));
    if (in_array($_SESSION['uid'], $admins)){
        $isAdmin = true;
    } else {
        $isAdmin = false;
    }

    ?>
    <div class="left-menu">
        <ul>
            <?php if ($isAdmin) { ?>
                <strong>Admin menu</strong>
                <hr/>
                <li><a href="index.php?p=adminlistusers">Show users</a></li>    
                <strong>User menu</strong><hr/>
                <?php } ?>
            <li><a href="index.php?p=accountsview">My money accounts</a></li>
            <li><a href="index.php?p=transfernew">Make a transaction</a></li>
            <li><a href="index.php?p=transferview">Transactions history</a></li>
            <li><a href="index.php?p=userview">User data</a></li>
        </ul>
    </div>
    <content class="logedin">
<?php
}else{
    echo '<content>';
}
$page ?? '';
switch ($page) {
    case 'signup':
        require(__DIR__ . '/../sections/signup.php');
        break;
    case 'login':
        require(__DIR__ . '/../sections/login.php');
        break;
    case 'logout':
        require(__DIR__ . '/../sections/logout.php');
        break;
    case 'userview':
        require(__DIR__ . '/../sections/userview.php');
        break;
    case 'useredit':
        require(__DIR__ . '/../sections/useredit.php');
        break;
    case 'userchangepw':
        require(__DIR__ . '/../sections/userchangepw.php');
        break;
    case 'usercloseacc':
        require(__DIR__ . '/../sections/usercloseacc.php');
        break;
    case 'accountsview':
        require(__DIR__ . '/../sections/accountsview.php');
        break;
    case 'accountsadd':
        require(__DIR__ . '/../sections/accountsadd.php');
        break;
    case 'accountsdel':
        require(__DIR__ . '/../sections/accountsdel.php');
        break;
    case 'transfernew':
        require(__DIR__ . '/../sections/transfernew.php');
        break;
    case 'transferview':
        require(__DIR__ . '/../sections/transferview.php');
        break;
    case 'adminlistusers':
        require(__DIR__ . '/../sections/adminlistusers.php');
        break;
    case 'adminuserdetails':
        require(__DIR__ . '/../sections/adminuserdetails.php');
        break;
    default:
        //consider if user is loged in when redirecting
        require(__DIR__ . '/../sections/main.php');
        //add page not found error here
        break;
}
    ?>
</content>
