<!DOCTYPE html>

<html>
	<head>
		<link rel="stylesheet" type="text/css" media="all" href="<?= base_url() ?>css/loginpage.css"/>
	</head>
<body class="loginPage">

<div class="centered">

<?php
	if (isset($errorMsg)) {
		echo "<p>" . $errorMsg . "</p>";
	}


	echo form_open('account/login');
?>
<ul>
	<li>
		<h5 class="link">
		<?php
			echo anchor('account/newForm','Create Account') . '&nbsp &nbsp';
			echo anchor('account/recoverPasswordForm','Recover Password');
		?>
		</h5>

		<h2>Login</h2>
	</li>
	<li>
<?php
	echo form_label('Username');
	echo form_error('username');
	echo form_input('username',set_value('username'),"required");
?>
	</li>

	<li>
<?php
	echo form_label('Password');
	echo form_error('password');
	echo form_password('password','',"required");
?>
	</li>
<?php
	$attributes = array(
		'name' => 'submit',
		'class' => 'submit');
?>
<?php
	echo form_submit($attributes, 'Login');
?>
</ul>

<?php
	echo form_close();
?>

</div>

</body>

</html>

