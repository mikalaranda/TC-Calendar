<script src='./assets/js/gcal.js'></script>

<?php
	require_once 'classes/database.php';
	$db = new Database();
	$con = $db->connect();
	$result = mysqli_query($con,"SELECT * FROM googleCalendars");

	$data = array();
	while($row = mysqli_fetch_assoc($result))
	{
		$data[] = $row;
	}

	echo json_encode($data);
?>