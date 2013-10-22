<!DOCTYPE html>

<html>
	<head>
		<h1>please choose the user you want to delete</h1>
	</head>
	<body>
		<Form Name= "deletepage.php" Method="POST" ACTION="account/delete_user">
		<table border = "1">		
			<tbody>
				<?php foreach($query as $row): ?>
					<tr>
						<td><?php echo $row->login; ?></td>
						<td><?php echo $row->first; ?></td>
						<td><?php echo $row->last; ?></td>
						<td><INPUT TYPE="Submit" Name = <form action="account/delete_user" method="post">value="Delete"></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</body>
</html>