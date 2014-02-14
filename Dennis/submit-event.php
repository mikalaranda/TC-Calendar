<?php
	require('config.php');
// require('password.php');
// require('checklogin.php');
	$query = "INSERT INTO events (title, start, end) 
			  VALUES 
			  ('$_POST[title]','$_POST[start]','$_POST[end]')";
	$ok = mysqli_query($con,$query) or die(mysqli_error($con));
	if ($ok){ 
	 echo "The operation was a success!"; 
	} 
	mysqli_close($con);

?>