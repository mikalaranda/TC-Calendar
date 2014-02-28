<?php require('./classes/database.php'); ?>
<?php include"./includes/session.php"; ?>
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
<link href='./assets/css/custom.css' rel='stylesheet' />
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
<script src='./assets/js/jquery.validate.min.js'></script>

<script>

$(document).ready(function() {

	$('#register-btn').click(function(){
		$('#registrationModal').modal('show');
	});

	$('#registration-form').validate({
		//debug: true,
		rules: {
			username: {
				required: true,
				minlength: 6
			},
			password: {
				required: true,
				minlength: 6
			},
			email: {
				required: true,
				email: true
			}
		},
		messages: {
			username: {
				required: "Please specify a username",
				minlength: "Username has to be more than 6 characters long."
			},
			password: {
				required: "Please specify a password",
				minlength: "Password has to be more than 6 characters long."
			},
			email: {
				required: "We need your email address to contact you",
				email: "Your email address must be in the format of name@domain.com"
			}
		},
	    submitHandler: function(form) {
			$.ajax({
				type: 'post',
				url: 'submit-user.php',
				data: $("#registration-form").serialize() + "&type=register",
				success: function (result) {
					if(result == "Success"){
						$('#registrationModal').modal('hide');
						$('#registration-form')[0].reset();
					}else{
						$("#registrationModal #error").html(result);
					}
				}
			});
	    }
	});

	$("#login-form").submit(function(e) {
		e.preventDefault();
		$.ajax({
			type: 'post',
			url: 'submit-user.php',
			data: $(this).serialize() + "&type=login",
			success: function (result) {
				if(result == "Success")
					location.reload();
				else
					alert(result)
			}
		});
	});
	
	$("#logout").submit(function(e){
		e.preventDefault();
		$.ajax({
			type: 'post',
			url: 'submit-user.php',
			data: $(this).serialize() + "&type=logout",
			success: function (result) {
				location.reload();
			}
		});
	});

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
			dataType: 'json',
			success: function (result) {
				$('#googleCalendarSubmitModal').modal('hide');
				$('#google-calendar-form')[0].reset();
				$('#calendar').fullCalendar( 'addEventSource', result[0] );
			}
		});
	})

	//This is executed when the user submits/updates events
	$('#event-form').submit(function (e) {
		var update = $("#event-form #update").val();
		e.preventDefault();
		$.ajax({
			type: 'post',
			url: 'submit-event.php',
			data: $(this).serialize() + "&type=submit",
			dataType: 'json',
			success: function (result) {
				$('#eventSubmitModal').modal('hide');
				console.log(JSON.stringify(result))
				if(update == 0)
					$('#calendar').fullCalendar( 'renderEvent', result[0], true )
				else{
					var event = $('#calendar').fullCalendar( 'clientEvents' ,update );
					$.each(result[0], function(k, v) {
						var obj = {};
						event[0][k] = v;
					});
					$('#calendar').fullCalendar('updateEvent', event[0]);
				}
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
						url: "dat-events.php"
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
		header:
			{
			left:   'title today',
			center: '',
			right:  'month,agendaWeek,agendaDay prev,next'
			},
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
		//this is a really ugly implementation of login check to see if calendar is editable..
		//please fix this by making eventdrop and eventresize validate user.
		<?php if(empty($_SESSION['LoggedIn']) && empty($_SESSION['Username'])){?>
			editable: false,
		<?php }else{ ?>
			editable: true,
		<?php } ?>
		eventSources: getEvents(),

		eventDrop: function(event, delta) {
			$.ajax({
				type: 'post',
				url: 'submit-event.php',
				data: {id: event.id, dayDelta: delta, type: 'drop'},
				success: function (result) {
					//$('.errors').html(result);
				}
			});
		},
	    eventResize: function(event,delta) {
			$.ajax({
				type: 'post',
				url: 'submit-event.php',
				data: {id: event.id, dayDelta: delta, type: 'resize'},
				success: function (result) {
					//$('.errors').html(result);
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
	    },
	    viewRender: function(view, element) { 
            //$('.fc-header-title span').append("TEST" ); 
        } 

	});

});

</script>

</head>
<body>
	<div class="container-fluid">
		<div class="header">
			<ul class="nav nav-pills pull-right">
			
			<?php if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username'])){?>
 				<li>
	 				<form class="navbar-form navbar-right" name="logout" id="logout">
	 					<button type="submit" id="" class="btn btn-success">Log Out</button>
	 				</form>
	 			</li>
			<?php }else{ ?>
				<li>
					<form class="navbar-form navbar-right" role="form" name="loginform" id="login-form">
						<div class="form-group">
							<input type="text" placeholder="Username" name="username" id="username" class="form-control">
						</div>
						<div class="form-group">
							<input type="password" placeholder="Password" name="password" id="password" class="form-control">
						</div>
						<button type="submit" class="btn btn-success">Sign in</button>
					</form>
				</li>
				<li>
					<button class="btn btn-success registerbtn" id="register-btn">Register</button>
				</li>
			<?php } ?>
		
			</ul>
			<div class="navleft text-muted pull-left">
				<img class = "tclogo" src = "http://www.tzuchi.org.sg/eng/images/intro/edu/jy006logo.jpg">
				<h1>TC-Calendar</h1>
			</div>
		</div>
		<div class="errors"></div>
		<div id='calendar'></div>
		<?php include 'includes/event-view-modal.php' ?>
		<?php if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username'])){
				include ('includes/event-submit-modal.php');
				include ('includes/google-calendar-submit-modal.php');?>
				<br> <button type="button" class="btn btn-default" id="google-calendar-button">Link Google Calendar</button>
		<?php } ?>
		<?php include 'includes/registration-modal.php' ?>
		<div class="footer">
			<p>&copy; Michael Aranda &amp; Dennis Chen 2014</p>
		</div>
	</div>
</body>
</html>
