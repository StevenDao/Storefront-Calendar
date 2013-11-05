<!DOCTYPE html>

<html>
	<head>
	    <link rel="stylesheet" type="text/css" media="all" href="<?= base_url() ?>css/reset.css"/>
	    <link rel="stylesheet" type="text/css" media="all" href="<?= base_url() ?>css/newForm.css"/>
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
		<?php $options = array();
				if($user->login == ""){
					$options["Select user"] = "Select user";
				}
				foreach ($query as $row):
					$options["$row->login"] = "$row->login";
				endforeach;
		?>
		<p>&nbsp;&nbsp;&nbsp;&nbsp;Add New User</p>
		
		<table> 
			<tr>
			    <td>
			      <?php
			          echo form_open('account/change_user');
			          echo form_label('username');
			          echo form_error('username');
					  $js = "value='$user->login' onChange='this.form.submit()'";
			          echo form_dropdown('user', $options, $user->login, $js);
					  echo form_close();
			      ?>
		    	</td>
			</tr>
			<tr>
			    <td>
			      <?php
				      $hidden = array("login" => "$user->login");
				      echo form_open("account/edit_user", "", $hidden); 
			          echo form_label("First Name");
			          echo form_error('first');
			          echo form_input(array(
			              'name' => 'first',
						  "value" => "$user->first",
			              'required' => 'required'
			          ));
			      ?>
		    	</td>
			    <td>
			      <?php
			          echo form_label("Last Name");
			          echo form_error('last');
			          echo form_input(array(
			              'name' => 'last',
						  "value" => "$user->last",
			              'required' => 'required'
			          ));
			      ?>
		    	</td>
		  </tr>
			  <tr >
			    <td rowspan="1">
			      <?php
			          echo form_label('Email Address');
			          echo form_error('email');
			          echo form_input(array(
			              'name' => 'email',
			              'value' => "$user->email",
			              'required' => 'required',
			          ));
			      ?>
		    </td>
		  </tr>
			  <tr>
			    <td>
			      <?php
			          echo form_submit(array(
			              'name' => 'submit',
			              'value' => 'Register',
			              'style' => 'float:right;'));
						  echo form_close();
			      ?>
		    </td>
			    <td>
			      <?php
				      echo form_open("account/delete_user", "", $hidden); 
			          echo form_submit('submit', "Delete");  
			          echo form_close();
			      ?>
		    </td>
		  </tr>
			  <tr height=70px">
		  </tr>
		</table>
		
		
	</body>
</html>