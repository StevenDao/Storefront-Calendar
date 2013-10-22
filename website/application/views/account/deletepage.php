<!DOCTYPE html>

<html>
	<head>
		<h1>please choose the user you want to delete</h1>
	</head>
	<body>		
		<?php foreach($query as $row): ?>
		<tr>
			<td><?php echo $row->login; ?></td>
			<td><?php echo $row->first; ?></td>
			<td><?php echo $row->last; ?></td>
		</tr>
		<?php endforeach; ?>
	</body>
</html>