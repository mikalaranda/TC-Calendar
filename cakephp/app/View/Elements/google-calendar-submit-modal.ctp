<div class="modal fade" id="googleCalendarSubmitModal" tabindex="-1" role="dialog" aria-labelledby="googleCalendarModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<?php echo $this->Form->create('GoogleCalendar', array(
				'class' => 'form-horizontal',
				'novalidate' => true,
				'id' => 'google-calendar-form',
				'inputDefaults' => array(
				'format' => array('before', 'label', 'between', 'input', 'after'),
				'div' => array('class' => 'form-group'),
				'label' => array('class' => 'col-sm-3 control-label'),
				'between' => '<div class="col-sm-7">',
				'after' => '</div>'
			)));?>
				<input type="hidden" id="update" name="update" value="0">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="google-calendar-title" id="googleCalendarModalLabel">Link Google Calendar</h4>
				</div>
				<div class="modal-body">
					<?php echo $this->Form->input('url', array('label' => array('class' => 'col-sm-3 control-label'), 'class' => 'form-control')); ?>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>

<?php
$data = $this->Js->get('#google-calendar-form')->serializeForm(array('isForm' => true, 'inline' => true));
$this->Js->get('#google-calendar-form')->event(
   'submit',
   $this->Js->request(
    array(
    	'action' => 'submit', 
    	'controller' => 'google_calendars'
    ),
    array(
    	'type' => 'json',
        'data' => $data,
        'async' => true,    
        'dataExpression'=>true,
        'method' => 'POST',
    	'success' => 'gcalSubmitSuccess(data)'
    )
  )
);
echo $this->Js->writeBuffer(); 
?>