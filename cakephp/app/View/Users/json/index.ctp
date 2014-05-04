<?php

$user_array = [];

foreach ($users as &$user) {
	array_push($user_array,$user['User']);
}

echo json_encode($user_array);

?>