<?php 
require('config.php'); 
?>
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
			data: $(this).serialize(),
			success: function () {
				$('#myModal').modal('hide');
				$('#calendar').fullCalendar('refetchEvents');
			}
		});
	})
	var calendar = $('#calendar').fullCalendar({

		selectable: true,
		selectHelper: true,
		select: function(start, end, allDay) {
			$('#myModal').modal('show');
			$('.modal-title').html(start);
			var date = start.getDate();
			var month = start.getMonth() + 1; //Months are zero based
			var year = start.getFullYear();
			var date =  year + '-' + ('0' + (month)).slice(-2) + '-' + ('0' + date).slice(-2);
			$('#start').val(date);
		},

		editable: true,

		events: "dat-events.php",

		eventDrop: function(event, delta) {
			$.ajax({
				type: 'post',
				url: 'update-event.php',
				data: {id: event.id, dayDelta: delta, updateType: 'drop'},
				success: function (result) {
					// alert(result);
				}
			});
		},
	    eventResize: function(event,delta) {
			$.ajax({
				type: 'post',
				url: 'update-event.php',
				data: {id: event.id, dayDelta: delta, updateType: 'resize'},
				success: function (result) {
					// alert(result);
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
		eventClick: function(calEvent, jsEvent, view) {
			$('#eventViewModal').modal('show');
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
	<div class='progress progress-striped active' style='display:none'>
		<div class='progress-bar'  role='progressbar' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100' style='width: 100%'></div>
	</div>
	<div id='calendar'></div>
	<? include 'event-view-modal.php' ?>
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel"></h4>
				</div>
				<div class="modal-body">
					<form id="event-form" class="form-horizontal" role="form" action="#">
						<div class="form-group">
							<label for="title" class="col-sm-3 control-label">Title</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="title" name="title" placeholder="Enter title">
							</div>
						</div>
						<div class="form-group">
							<label for="start" class="col-sm-3 control-label">Start Date</label>
							<div class="col-sm-8">
								<input type="date" class="form-control" id="start" name="start" placeholder="Enter date">
							</div>
						</div>
						<div class="form-group">
							<label for="end" class="col-sm-3 control-label">End Date</label>
							<div class="col-sm-8">
								<input type="date" class="form-control" id="end" name="end" placeholder="Enter date">
							</div>
						</div>
						<div class="form-group">
							<label for="url" class="col-sm-3 control-label">URL</label>
							<div class="col-sm-8">
								<input type="url" class="form-control" id="url" name="url" placeholder="Enter url">
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<div class="checkbox">
									<label>
										<input id="allDay" name="allDay" type="checkbox"> All day event?
									</label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-default">Submit</button>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary">Save changes</button>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
