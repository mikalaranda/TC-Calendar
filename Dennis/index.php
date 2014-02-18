<?php require('classes/database.php'); ?>
<!DOCTYPE html>
<html>
<head>

<!-- Bootstrap -->
<link href="./assets/css/bootstrap.min.css" rel="stylesheet">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->  
<!-- end Bootstrap -->

<link href='./assets/css/fullcalendar.css' rel='stylesheet' />
<link href='./assets/css/fullcalendar.print.css' rel='stylesheet' media='print' />
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="./assets/js/bootstrap.min.js"></script>
<script src='./assets/js/jquery-ui.custom.min.js'></script>
<script src='./assets/js/fullcalendar.min.js'></script>

<script>

$(document).ready(function() {

	$('#event-form').submit(function (e) {
		e.preventDefault();
		$.ajax({
			type: 'post',
			url: 'submit-event.php',
			data: $(this).serialize() + "&type=submit",
			success: function (result) {
				$('#eventSubmitModal').modal('hide');
				$('#calendar').fullCalendar('refetchEvents');
				// $('.errors').html(result);
				// alert(result);
			}
		});
	})
	$('#view-event-form').submit(function (e) {
		e.preventDefault();
		$.ajax({
			type: 'post',
			url: 'get-event.php',
			data: $(this).serialize(),
			dataType: 'json',
			success: function (result) {
				var start = result[0].start;
				var start_arr = start.split(' ');
				var end = result[0].end;
				var end_arr = end.split(' ');
				$('#eventViewModal').modal('hide');
				$('#update').val(result[0].id);
				$('#title').val(result[0].title);
				$('#start').val(start_arr[0]);
				$('#end').val(end_arr[0]);
				$('#url').val(result[0].URL);

				$('#eventSubmitModal').modal('show');
			}
		});
	})
	var calendar = $('#calendar').fullCalendar({

		selectable: true,
		selectHelper: true,
		select: function(start, end, allDay) {
			$('#event-form')[0].reset();
			$('.event-modal-title').html(start);
			var date = start.getDate();
			var month = start.getMonth() + 1; //Months are zero based
			var year = start.getFullYear();
			var date =  year + '-' + ('0' + (month)).slice(-2) + '-' + ('0' + date).slice(-2);
			$('#start').val(date);
			$('#eventSubmitModal').modal('show');
		},

		editable: true,

		events: "dat-events.php",

		eventDrop: function(event, delta) {
			$.ajax({
				type: 'post',
				url: 'submit-event.php',
				data: {id: event.id, dayDelta: delta, type: 'drop'},
				success: function (result) {
					$('.errors').html(result);
				}
			});
		},
	    eventResize: function(event,delta) {
			$.ajax({
				type: 'post',
				url: 'submit-event.php',
				data: {id: event.id, dayDelta: delta, type: 'resize'},
				success: function (result) {
					$('.errors').html(result);
				}
			});
	    },
		loading: function(bool) {
			if (bool){
				$('.progress').show();
			}
			else{
				$('.progress').hide();
			}
		},
		eventClick: function(calEvent) {
			$('#eventViewModal').modal('show');
			$('#hidden_id').val(calEvent.id);
			$('.modal-title').html(calEvent.title);
			$('#eventViewStart').html(calEvent.start);
			$('#eventViewEnd').html(calEvent.end);
			$('#eventViewURL').html(calEvent.URL);
	    }

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

#loading {
	position: absolute;
	top: 5px;
	right: 5px;
}

#calendar {
	width: 900px;
	margin: 0 auto;
}

</style>
</head>
<body>
	<div class="errors"></div>
	<div class='progress progress-striped active' style='display:none'>
		<div class='progress-bar'  role='progressbar' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100' style='width: 100%'></div>
	</div>
	<div id='calendar'></div>
	<?php include 'includes/event-view-modal.php' ?>
	<?php include 'includes/event-submit-modal.php' ?>
</body>
</html>
