<?php
require_once 'classes/user.php';

$user = new User($_POST);
$result = $user->getResult();

echo $result;
?>