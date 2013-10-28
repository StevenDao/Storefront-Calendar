<!DOCTYPE html>

<html>
	<head>
		<link rel="stylesheet" type="text/css" media="all" href="<?= base_url() ?>css/modifyclient.css"/>
		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
		<h1>Modify Users</h1>
		<script>
		
		function edit(cValue){
			console.log(cValue);
			$("."+cValue).attr("disabled",  false);
			
		}
		
		
		</script>
	</head>
	
	<body>
		<div class='main'>
			<?php foreach($query as $row): ?>
				<div class='container'>
					<h2><?php echo $row->name; ?></h2>
					
					<ul>
						<li>
						<?php
						
						echo form_open('account/edit_client'); 
						echo form_label("Partner Name : ");
	                    echo form_input(array(
							'name' => "partnername",
	                        'class' => $row->name,
	                        'value' => $row->partnername,
	                        'required' => 'required',
							'disabled' => 'true'
	                    ));
						?>
					</li>
					<input type="hidden" name="loginID" value = <?php echo $row->name; ?>>
					<li>
						<?php
						echo form_label("Programname : ");
	                    echo form_input(array(
							'name'	=> "program Name",
	                        'class' => $row->name,
	                        'value' => $row->programname,
	                        'required' => 'required',
							'disabled' => 'true'
	                    ));
						?>
					</li>
					
					<li>
						<?php
						echo form_label("Email ID &nbsp&nbsp&nbsp&nbsp;: ");
	                    echo form_input(array(
							'name' => 'email',
	                        'class' => $row->name,
	                        'value' => $row->email,
	                        'required' => 'required',
							'disabled' => 'true'
						));
						echo form_submit(array(
							'name' => "save",
							'class'=> "$row->name specialSubmit",
						    'value' =>  "SAVE"
						));
						 echo form_close();
								
	                   
						?>
					</li>	
					
					</ul>
					
					
					
					<button id="editable" type="button" class="specialSubmit extraSpecial" onClick='edit("<?php echo $row->name?>")'>EDIT</button>
					<?php 
						echo form_open('account/delete_client'); 
					?>
					<p>
						<input type="hidden" name="loginID" value = <?php echo $row->name; ?>>
						<?php echo form_submit(array(
						                       		'name' => $row->name,
													'class' => "close",
						                        	'value' =>  "X"
						                        	));?>
					</p>
						
					<?php 
						echo form_close();
					?>
				</div>					
			<?php endforeach; ?>
		</div>
	</body>
</html>