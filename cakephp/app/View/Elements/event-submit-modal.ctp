<div class="modal fade" id="eventSubmitModal" tabindex="-1" role="dialog" aria-labelledby="eventSubmitModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<?php echo $this->Form->create('Event', array(
				'class' => 'form-horizontal',
				'novalidate' => true,
				'id' => 'event-form',
				'inputDefaults' => array(
				'format' => array('before', 'label', 'between', 'input', 'after'),
				'div' => array('class' => 'form-group'),
				'label' => array('class' => 'col-sm-3 control-label'),
				'between' => '<div class="col-sm-7">',
				'after' => '</div>'
			)));?>
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="event-modal-title" id="eventSubmitModalLabel"></h4>
				</div>
				<div class="modal-body">
					<?php 
						echo $this->Form->input('update_id', array('type' => 'hidden', 'value' => '0'));
						echo $this->Form->input('title', array('label' => array('class' => 'col-sm-3 control-label'), 'class' => 'form-control'));
						echo $this->Form->input('start', array('label' => array('class' => 'col-sm-3 control-label'), 'class' => 'form-control', 'type'=> 'text'));
						echo $this->Form->input('end', array('label' => array('class' => 'col-sm-3 control-label'), 'class' => 'form-control', 'type'=> 'text'));
						echo $this->Form->input('url', array('label' => array('class' => 'col-sm-3 control-label'), 'class' => 'form-control'));
						echo $this->Form->input('allDay', array('label' => array('class' => 'col-sm-3 control-label'), 'class' => 'form-control'));
					?>
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
$data = $this->Js->get('#event-form')->serializeForm(array('isForm' => true, 'inline' => true));
$this->Js->get('#event-form')->event(
   'submit',
   $this->Js->request(
    array(
    	'action' => 'submit', 
    	'controller' => 'events'
    ),
    array(
    	'type' => 'json',
        'data' => $data,
        'async' => true,    
        'dataExpression'=>true,
        'method' => 'POST',
    	'success' => 'submitSuccess(data)'
    )
  )
);
echo $this->Js->writeBuffer(); 
?>