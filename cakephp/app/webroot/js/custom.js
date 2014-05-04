$(document).ready(function() {

	$('#event-form').validate();

	$('#google-calendar-form').validate({
		rules: {
			"data[GoogleCalendar][url]": {
				url:true
			}
		}
	});

	$('#register-btn').click(function(){
		$('#registrationModal').modal('show');
	});

	$('#registration-form').validate({
		//debug: true,
		rules: {
			'data[User][username]': {
				required: true
			},
			'data[User][password]': {
				required: true
			},
			'data[User][email]': {
				required: true,
				email: true
			}
		},
		messages: {
			'data[User][username]': {
				required: "Please specify a username",
				minlength: "Username has to be more than 6 characters long."
			},
			'data[User][password]': {
				required: "Please specify a password",
				minlength: "Password has to be more than 6 characters long."
			},
			'data[User][email]': {
				required: "We need your email address to contact you",
				email: "Your email address must be in the format of name@domain.com"
			}
		}
	});


	$("#UserIndexForm").submit(function(e) {
		e.preventDefault();
		$.ajax({
			type: 'post',
			url: 'users/login',
			data: $(this).serialize(),
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

	$('#EventEnd').datepicker({
		format: 'yyyy-mm-dd'
	});
	$('#EventStart').datepicker({
		format: 'yyyy-mm-dd'
	});

	$('#EventStart').datepicker().on('changeDate', function(e){
		var start_date = $('#EventStart').datepicker('getDate');
		var end_date = $('#EventEnd').datepicker('getDate');
		// if end date is less than start date, remove it
		if (start_date > end_date)
			$('#EventEnd').datepicker('update', e.date);
    });

    $('#EventEnd').datepicker().on('changeDate', function(e){
		var start_date = $('#EventStart').datepicker('getDate');
		var end_date = $('#EventEnd').datepicker('getDate');
		// if end date is less than start date, remove it
		if (end_date < start_date)
			$('#EventStart').datepicker('update', e.date);

    });

    $('#google-calendar-button').click(function(){
    	$('#googleCalendarSubmitModal').modal('show');
    });

	function getEvents(){
			//get db events
			var JSONEvents = 
					[{
						url: "events.json"
					}]
				;
			var googleEvents;
			$.ajax({
				type: 'get',
				url: 'google_calendars.json',
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
			$('#event-form #EventUpdateId').val('0');
			$('.event-modal-title').html("Create New Event");
			var date = start.getDate();
			var month = start.getMonth() + 1; //Months are zero based
			var year = start.getFullYear();
			var date =  year + '-' + ('0' + (month)).slice(-2) + '-' + ('0' + date).slice(-2);
			$('#EventStart').datepicker('update', date);
			$('#EventStart').val(date);
			$('#EventEnd').datepicker('update', date);
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

//This is executed when the user submits/updates events
function submitSuccess(result) {
	$('#eventSubmitModal').modal('hide');
	if(result.update == false){
		$('#calendar').fullCalendar( 'renderEvent', result, true )
	}else if(result.update == true){
		var event = $('#calendar').fullCalendar( 'clientEvents' ,result.id );
		$.each(result, function(k, v) {
			var obj = {};
			event[0][k] = v;
		});
		$('#calendar').fullCalendar('updateEvent', event[0]);
	}
}

//This is executed when a user clicks the edit event button.
function loadEvent (result) {
	console.log(result);
	var start = result.start;
	var start_arr = start.split(' ');
	var end = result.end;
	var end_arr = end.split(' ');
	$('#eventSubmitModal .event-modal-title').html("Edit Event");
	$('#eventViewModal').modal('hide');
	$('#EventUpdateId').val(result.id);
	$('#EventTitle').val(result.title);
	$('#EventStart').val(start_arr[0]);
	$('#EventEnd').val(end_arr[0]);
	$('#EventUrl').val(result.url);
	if(result.allDay == 1)
		$('#EventAllDay').prop('checked', true);
	$('#eventSubmitModal').modal('show');
}
//This is executed when the user submits google calendar
function gcalSubmitSuccess(result) {
	$('#googleCalendarSubmitModal').modal('hide');
	$('#google-calendar-form')[0].reset();
	$('#calendar').fullCalendar( 'addEventSource', result );
		
}

function userSubmitSuccess(result) {
	if(result == "Success"){
		$('#registrationModal').modal('hide');
		$('#registration-form')[0].reset();
	}else{
		$("#registrationModal #error").html(result);
	}
}