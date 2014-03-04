<?php

$gc_array = [];

foreach ($google_calendars as &$gc) {
	array_push($gc_array,$gc['GoogleCalendar']);
}

echo json_encode($gc_array);

?>