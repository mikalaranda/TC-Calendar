<?php
	require('config.php');
	$result = mysqli_query($con,"SELECT * FROM events");
	
	$data = array();
	while($row = mysqli_fetch_assoc($result))
	{
		$data[] = $row;
	}

	mysqli_close($con);

	echo json_encode($data);
?>