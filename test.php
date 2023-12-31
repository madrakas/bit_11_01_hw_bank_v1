<?php
session_start();
unset($_SESSION['test']);

echo '<pre>';

print_r($_SESSION);
echo '</pre>';