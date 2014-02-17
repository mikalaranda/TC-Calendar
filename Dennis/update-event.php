<?php
require_once 'classes/event.php';

$event = new Event($_POST);
$result = $event->getResult();

?>