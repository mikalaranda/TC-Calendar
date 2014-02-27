<?php require('classes/database.php'); ?>
<!DOCTYPE html>
<html>
<head>
<style>
.datepicker {z-index: 1151 !important;}
</style>
<!-- Bootstrap -->
<link href="./assets/css/bootstrap.min.css" rel="stylesheet">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->  
<!-- end Bootstrap -->
<link href='./assets/css/datepicker3.css' rel='stylesheet' />

<link href='./assets/css/fullcalendar.css' rel='stylesheet' />
<link href='./assets/css/fullcalendar.print.css' rel='stylesheet' media='print' />
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="./assets/js/bootstrap.min.js"></script>
<script src='./assets/js/jquery-ui.custom.min.js'></script>
<script src='./assets/js/fullcalendar.min.js'></script>
<script src='./assets/js/bootstrap-datepicker.js'></script>
<script src='./assets/js/gcal.js'></script>

<script>

$(document).ready(function() {
	$('#end').datepicker({
		format: 'yyyy-mm-dd'
	});
	$('#start').datepicker({
		format: 'yyyy-mm-dd'
	});

	$('#start').datepicker().on('changeDate', function(e){
		var start_date = $('#start').datepicker('getDate');
		var end_date = $('#end').datepicker('getDate');
		// if end date is less than start date, remove it
		if (start_date > end_date)
			$('#end').datepicker('update', e.date);
    });

    $('#end').datepicker().on('changeDate', function(e){
		var start_date = $('#start').datepicker('getDate');
		var end_date = $('#end').datepicker('getDate');
		// if end date is less than start date, remove it
		if (end_date < start_date)
			$('#start').datepicker('update', e.date);

    });

    $('#google-calendar-button').click(function(){
    	$('#googleCalendarSubmitModal').modal('show');
    });

	//This is executed when the user submits google calendar
	$('#google-calendar-form').submit(function (e) {
		e.preventDefault();
		$.ajax({
			type: 'post',
			url: 'submit-event.php',
			data: $(this).serialize() + "&type=google",
			success: function (result) {
				$('#googleCalendarSubmitModal').modal('hide');
				$('#google-calendar-form')[0].reset();
				alert("submitted");
				getEvents();
				//alert(result);
			}
		});
	})

	//This is executed when the user submits/updates events
	$('#event-form').submit(function (e) {
		e.preventDefault();
		$.ajax({
			type: 'post',
			url: 'submit-event.php',
			data: $(this).serialize() + "&type=submit",
			success: function (result) {
				$('#eventSubmitModal').modal('hide');
				$('#calendar').fullCalendar('refetchEvents'); //same here
				//alert(result);
			}
		});
	})

	//This is executed when a user clicks the edit event button.
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
				$('#eventSubmitModal .event-modal-title').html("Edit Event");
				$('#eventViewModal').modal('hide');
				$('#update').val(result[0].id);
				$('#title').val(result[0].title);
				$('#start').val(start_arr[0]);
				$('#end').val(end_arr[0]);
				$('#url').val(result[0].URL);
				if(result[0].allDay == 1)
					$('#allDay').prop('checked', true);

				$('#eventSubmitModal').modal('show');
			}
		});
	})

	function getEvents(){
			//get db events
			var JSONEvents = 
				
					[{
						url: "dat-events.php",
						color: "yellow",
						textColor: "black"
					}]
				;
			var googleEvents;
			$.ajax({
				type: 'post',
				url: 'get-google-events.php',
				dataType: 'json',
				success: function (result) {
					for ( var i = 0; i < result.length; i++ ) {
						$('#calendar').fullCalendar( 'addEventSource', result[i] );
					}
					$('#calendar').fullCalendar( 'refetchEvents' )
				}
			});
			return JSONEvents;
	}

	var calendar = $('#calendar').fullCalendar({

		selectable: true,
		selectHelper: true,
		select: function(start, end, allDay) {
			$('#event-form')[0].reset();
			$('#event-form #update').val('0');
			$('.event-modal-title').html("Create New Event");
			var date = start.getDate();
			var month = start.getMonth() + 1; //Months are zero based
			var year = start.getFullYear();
			var date =  year + '-' + ('0' + (month)).slice(-2) + '-' + ('0' + date).slice(-2);
			$('#start').datepicker('update', date);
			$('#end').datepicker('update', date);
			$('#start').val(date);
			$('#eventSubmitModal').modal('show');
		},

		editable: true,

		eventSources: getEvents(),

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
			$('#eventViewURL').html("<a href='"+calEvent.url+"' target='_blank'>Link</a>");
			if(calEvent.allDay == 1)
				$('#eventViewAllday').html("Yes");
			else
				$('#eventViewAllday').html("No");
			return false;
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
	<button type="button" id="google-calendar-button" class="btn btn-default btn-lg">
		Link Google Calendar
	</button>
	<!-- <div class='progress progress-striped active' style='display:none'>
		<div class='progress-bar' role='progressbar' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100' style='width: 100%'></div>
	</div> -->
	<div id='calendar'></div>
	<?php include 'includes/event-view-modal.php' ?>
	<?php include 'includes/event-submit-modal.php' ?>
	<?php include 'includes/google-calendar-submit-modal.php' ?>
</body>
</html>
