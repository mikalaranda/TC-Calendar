<div class="modal fade" id="eventSubmitModal" tabindex="-1" role="dialog" aria-labelledby="eventSubmitModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<?php echo $this->Form->create('Event', array(
				'class' => 'form-horizontal',
				'id' => 'event-form',
				'inputDefaults' => array(
				'format' => array('before', 'label', 'between', 'input', 'after'),
				'div' => array('class' => 'form-group'),
				'label' => array('class' => 'col-sm-3 control-label'),
				'between' => '<div class="col-sm-8">',
				'after' => '</div>'
			)));?>
				<input type="hidden" id="update" name="update" value="0">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="event-modal-title" id="eventSubmitModalLabel"></h4>
				</div>
				<div class="modal-body">
					<?php 
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
			</form>
		</div>
	</div>
</div>