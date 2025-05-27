<?php

require_once 'config.php';
require_once 'classes/User.php';

$user = new User($conn);
$user-> logout();
header('Location: index.php');
exit();
?>
