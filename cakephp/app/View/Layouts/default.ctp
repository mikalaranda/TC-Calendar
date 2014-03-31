<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('bootstrap.min');
		echo $this->Html->css('custom');
		echo $this->Html->css('datepicker3');
		echo $this->Html->css('fullcalendar');
		echo $this->Html->css('fullcalendar.print', array('media' => 'print'));

		echo $this->Html->script('jquery.min');
		echo $this->Html->script('bootstrap.min');
		echo $this->Html->script('jquery-ui.custom.min');
		echo $this->Html->script('fullcalendar.min');
		echo $this->Html->script('bootstrap-datepicker');
		echo $this->Html->script('gcal');
		echo $this->Html->script('jquery.validate.min');
		echo $this->Html->script('custom');
		
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<?php if (AuthComponent::user('id')): ?>
   Logged in as <?= AuthComponent::user('name') ?>
<?php endif; ?>
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
				<img class = "tclogo" src = "img/tzuchinglogo.jpg">
				<h1>TC-Calendar</h1>
			</div>
		</div>
		<?php echo $this->Session->flash(); ?>
		<?php echo $this->fetch('content'); ?>

		<div class="footer">
			<p>&copy; Michael Aranda &amp; Dennis Chen 2014</p>
		</div>
	</div>
	<?php
		echo $this->element('sql_dump'); 
		echo $this->Js->writeBuffer(); // Write cached scripts
	?>
</body>
</html>

