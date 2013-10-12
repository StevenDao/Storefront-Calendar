<!DOCTYPE html>

<html>
	<head>
		<link rel="stylesheet" type="text/css" media="all" href="<?= base_url() ?>css/reset.css"/>
		<link rel="stylesheet" type="text/css" media="all" href="<?= base_url() ?>css/style.css"/>
	</head>
<body>

<header class="topbg"></header>

<header class="main">
<?php
	if (isset($errorMsg)) {
		echo "<p>" . $errorMsg . "</p>";
	}

	echo form_open('account/login');
?>

<aside class="login">
	<h5>
		<?php
			echo anchor('account/newForm','Create Account') . '&nbsp &nbsp';
			echo anchor('account/recoverPasswordForm','Recover Password');
		?>
	</h5>

	<?php

	$attributes = array(
		'name' => 'username',
		'placeholder' => 'username'
	);

	echo '<h2>Login</h2>';
	echo '<div>';
	echo form_error('username');
	echo form_input($attributes,set_value('username'),"required");
	echo '</div>';

	echo '<div>';
	echo form_error('password');
	echo form_password('password','',"required");
	echo '</div>';

	$attributes = array(
		'name' => 'submit',
		'class' => 'submit');

	echo form_submit($attributes, 'Login');
	echo form_close();
?>

</aside>

</header>

</body>

</html>

