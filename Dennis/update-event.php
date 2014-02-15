<?php
	require('config.php');
// require('password.php');
// require('checklogin.php');
	if($_POST[updateType] == 'drop'){
		$query = "UPDATE events SET start = DATE_ADD(start, INTERVAL " . $_POST[dayDelta] . " DAY),
			end = DATE_ADD(end, INTERVAL " . $_POST[dayDelta] . " DAY)
			WHERE events.id = " . $_POST[id];		
	}
	else if($_POST[updateType] == 'resize'){
		$query = "UPDATE events SET	end = DATE_ADD(end, INTERVAL " . $_POST[dayDelta] . " DAY)
			WHERE events.id = " . $_POST[id];	
	}

	$ok = mysqli_query($con,$query) or die(mysqli_error($con));
	if ($ok){ 
	 echo "The operation was a success!"; 
	} 
	mysqli_close($con);
?>