<?php

$accounts = unserialize(file_get_contents(__DIR__ . '/data/accounts.ser'));
$acountsMaxID = unserialize(file_get_contents(__DIR__ . '/data/accounts-max-id.ser'));


echo '<pre>';
print_r($accounts);
print_r($acountsMaxID);
echo '<pre>';
?>

