<!DOCTYPE html>

<html>
	<head>
		<link rel="stylesheet" type="text/css" media="all" href="<?= base_url() ?>css/deletepage.css"/>
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
					<h2><?php echo $row->login; ?></h2>
					
					<ul>
						<li>
						<?php
						
						echo form_open('account/edit_user'); 
						echo form_label("First Name : ");
	                    echo form_input(array(
							'name' => "first",
	                        'class' => $row->login,
	                        'value' => $row->first,
	                        'required' => 'required',
							'disabled' => 'true'
	                    ));
						?>
					</li>
					<input type="hidden" name="loginID" value = <?php echo $row->login; ?>>
					<li>
						<?php
						echo form_label("Last Name : ");
	                    echo form_input(array(
							'name'	=> "last",
	                        'class' => $row->login,
	                        'value' => $row->last,
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
	                        'class' => $row->login,
	                        'value' => $row->email,
	                        'required' => 'required',
							'disabled' => 'true'
						));
						echo form_submit(array(
							'name' => "save",
							'class'=> "$row->login specialSubmit",
						    'value' =>  "SAVE"
						));
						 echo form_close();
								
	                   
						?>
					</li>	
					
					</ul>
					
					
					
					<button id="editable" type="button" class="specialSubmit extraSpecial" onClick='edit("<?php echo $row->login?>")'>EDIT</button>
					<?php 
						echo form_open('account/delete_user'); 
					?>
					<p>
						<input type="hidden" name="loginID" value = <?php echo $row->login; ?>>
						<?php echo form_submit(array(
						                       		'name' => $row->login,
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