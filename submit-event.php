<?php
require_once 'classes/event.php';

$event = new Event($_POST);
$result = $event->getResult();

echo json_encode($result);
?>