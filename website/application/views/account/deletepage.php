<!DOCTYPE html>

<html>
	<head>
	</head>
	<body>
		<tbody>
			<?php foreach($query as $row): ?>
			<tr>
				<td><?php echo $row->login; ?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</body>
</html>