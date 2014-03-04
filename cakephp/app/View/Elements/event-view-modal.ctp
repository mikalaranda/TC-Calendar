<div class="modal fade" id="eventViewModal" tabindex="-1" role="dialog" aria-labelledby="eventViewModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<?php echo $this->Form->create('Edit', array('id' => 'event-view-form')); ?>
				<?php echo $this->Form->input('hidden_id', array('type' => 'hidden', 'value' => '0', 'id' => 'hidden_id')); ?>
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="eventViewModalLabel"></h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class ="col-md-2 text-right">Start:</div>
						<div class ="col-md-8 text-left" id="eventViewStart"></div>
					</div>
					<div class="row">
						<div class ="col-md-2 text-right">End:</div>
						<div class ="col-md-8 text-left" id="eventViewEnd"></div>
					</div>
					<div class="row">
						<div class ="col-md-2 text-right">URL:</div>
						<div class ="col-md-8 text-left" id="eventViewURL"></div>
					</div>
					<div class="row">
						<div class ="col-md-2 text-right">All Day:</div>
						<div class ="col-md-8 text-left" id="eventViewAllday"></div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Edit</button>
				</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>

<?php
$data = $this->Js->get('#event-view-form')->serializeForm(array('isForm' => true, 'inline' => true));
$this->Js->get('#event-view-form')->event(
   'submit',
   $this->Js->request(
    array(
    	'action' => 'getEvent', 
    	'controller' => 'events'
    ),
    array(
       	'type' => 'json',
        'data' => $data,
        'async' => true,    
        'dataExpression'=>true,
        'method' => 'POST',
    	'success' => 'loadEvent(data)'
    )
  )
);
echo $this->Js->writeBuffer(); 
?>