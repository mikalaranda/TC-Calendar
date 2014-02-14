<?php
	// Create connection
	$con=mysqli_connect("localhost","root","root","TC-Calendar");

	// Check connection
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	$result = mysqli_query($con,"SELECT * FROM events");
	
	$data = array();
	while($row = mysqli_fetch_assoc($result))
	{
		$data[] = $row;
	}

	mysqli_close($con);

	echo json_encode($data);
?>