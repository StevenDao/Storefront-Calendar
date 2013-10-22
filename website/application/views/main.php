<!DOCTYPE html>
<html>
	<head>
		<title>Storefront Calendar</title>
	</head>
<body>

<h1>Welcome <?= $user->first . " " . $user->last?>, you are now successfully logged in!</h1>

<?php
if (isset($message))
	echo '<p>' . $message . '</p>';
?>

<ul>
	<li><?= anchor("account/create_new_user", 'Create New User'); ?></li>
	<li><?= anchor("account/delete_user", 'Delete User'); ?></li>
	<li><?= anchor("account/modify_user", 'Modify User'); ?></li>
 	<li><?= anchor("account/logout", 'Logout'); ?></li>
</ul>

</body>

</html>

