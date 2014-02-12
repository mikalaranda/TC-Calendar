<?php
function csv_to_array($filename='', $delimiter=',')
{
    if(!file_exists($filename) || !is_readable($filename))
        return FALSE;

    $header = NULL;
    $data = array();
    if (($handle = fopen($filename, 'r')) !== FALSE)
    {
        while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
        {
            if(!$header)
                $header = $row;
            else
                $data[] = array_combine($header, $row);
        }
        fclose($handle);
    }
    return $data;
}

$dat_array = csv_to_array('./calendar.dat', ', ');

// $fh = fopen('./calendar.dat','r');
// $date_info_array = []
// while ($line = fgets($fh)) {
// 	$dat_array = explode(', ', $line);
// 	array_push($date_info_array, $dat_array);

// 	var_dump($date_info_array);
// }
// fclose($fh)
?>

<!DOCTYPE html>
<html>
<head>
<link href='./assets/css/fullcalendar.css' rel='stylesheet' />
<link href='./assets/css/fullcalendar.print.css' rel='stylesheet' media='print' />
<script src='./assets/js/jquery.min.js'></script>
<script src='./assets/js/jquery-ui.custom.min.js'></script>
<script src='./assets/js/fullcalendar.min.js'></script>
<script>
	$(document).ready(function() {
	
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
		
		$('#calendar').fullCalendar({
			editable: true,
			events: [
				<?php foreach ($dat_array as $dat_value) { ?>
				{
					title: '<?php echo $dat_value['title'] ?>',
					start: new Date(<?php echo $dat_value['year'] ?>, 
									<?php echo $dat_value['month']-1 ?>, 
									<?php echo $dat_value['day'] ?>),
					url: '<?php echo $dat_value['url'] ?>',
					allDay: <?php echo $dat_value['allday'] ?>
				},
				<?php } ?>
			]
		});
		
	});

</script>
<style>

	body {
		margin-top: 40px;
		text-align: center;
		font-size: 14px;
		font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
		}

	#calendar {
		width: 900px;
		margin: 0 auto;
		}

</style>
</head>
<body>
<div id='calendar'></div>

</body>
</html>


