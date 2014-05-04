<div class="modal fade" id="registrationModal" tabindex="-1" role="dialog" aria-labelledby="registrationModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<?php echo $this->Form->create('User', array(
				'class' => 'form-horizontal',
				'novalidate' => true,
				'id' => 'registration-form',
				'inputDefaults' => array(
				'format' => array('before', 'label', 'between', 'input', 'after'),
				'div' => array('class' => 'form-group'),
				'label' => array('class' => 'col-sm-3 control-label'),
				'between' => '<div class="col-sm-7">',
				'after' => '</div>'
			)));?>
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="registration-modal-title" id="registrationModalLabel">Register</h4>
				</div>
				<div class="modal-body">
					<div id = "error"></div>
					<p>Please enter your details below to register.</p>
					<?php 
						echo $this->Form->input('username', array('label' => array('class' => 'col-sm-3 control-label'), 'class' => 'form-control')); 
						echo $this->Form->input('password', array('label' => array('class' => 'col-sm-3 control-label'), 'class' => 'form-control'));
						echo $this->Form->input('email', array('label' => array('class' => 'col-sm-3 control-label'), 'class' => 'form-control'));
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
$data = $this->Js->get('#registration-form')->serializeForm(array('isForm' => true, 'inline' => true));
$this->Js->get('#registration-form')->event(
   'submit',
   $this->Js->request(
    array(
    	'action' => 'submit', 
    	'controller' => 'users'
    ),
    array(
        'data' => $data,
        'async' => true,    
        'dataExpression'=>true,
        'method' => 'POST',
    	'success' => 'userSubmitSuccess(data)'
    )
  )
);
echo $this->Js->writeBuffer(); 
?>