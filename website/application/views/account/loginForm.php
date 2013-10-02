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
		<div class="header">Login</div>
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
<p class="link">
<?php
	echo "<div>" . anchor('account/newForm','Create Account') . "</div>";
	echo "<div>" . anchor('account/recoverPasswordForm','Recover Password') . "</div>";
?>
</p>

<?php
	echo form_close();
?>

</div>

</body>

</html>

