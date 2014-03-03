<?php

$event_array = [];

foreach ($events as &$event) {
	array_push($event_array,$event['Event']);
}

echo json_encode($event_array);

?>