

<?php 
if (isset($_SESSION['login']) && ($_SESSION['login'] === '1' )){
    ?>
    <div class="left-menu">
        <ul>
            <li><a href="index.php?p=accountsview">My money accounts</a></li>
            <li><a href="#">Make a transaction</a></li>
            <li><a href="#">Transactions history</a></li>
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
    case 'accountsview':
        require(__DIR__ . '/../sections/accountsview.php');
        break;
    case 'accountsadd':
        require(__DIR__ . '/../sections/accountsadd.php');
        break;
    case 'accountsdel':
        require(__DIR__ . '/../sections/accountsdel.php');
        break;
    default:
        //consider if user is loged in when redirecting
        require(__DIR__ . '/../sections/main.php');
        //add page not found error here
        break;
}
    ?>
</content>
