<?php
	require_once 'classes/database.php';
	$db = new Database();
	$con = $db->connect();
	$result = mysqli_query($con,"SELECT * FROM events");

	$data = array();
	while($row = mysqli_fetch_assoc($result))
	{
		$data[] = $row;
	}

	echo json_encode($data);
?>