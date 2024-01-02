<?php

$data = unserialize(file_get_contents(__DIR__ . '/data/transfers.ser'));

echo '<pre>';
print_r($data);
echo '<pre>';
?>