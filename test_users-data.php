<?php

$users = unserialize(file_get_contents(__DIR__ . '/data/users.ser'));
$usersMaxID = unserialize(file_get_contents(__DIR__ . '/data/users-max-id.ser'));


echo '<pre>';
print_r($users);
print_r($usersMaxID);
echo '<pre>';
?>