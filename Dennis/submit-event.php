<?php
// require('password.php');
// require('config.php');
// require('checklogin.php');
	// Create connection
	$con=mysqli_connect("localhost","root","root","TC-Calendar");

	// Check connection
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	$query = "INSERT INTO events (title, start, end) 
			  VALUES 
			  ('$_POST[title]','$_POST[start]','$_POST[end]')";
	$ok = mysqli_query($con,$query) or die(mysqli_error($con));
	if ($ok){ 
	 echo "The operation was a success!"; 
	} 
	mysqli_close($con);

?>