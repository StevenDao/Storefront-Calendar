<!DOCTYPE html>
<!http://localhost/PhpProject2/index.php/account/newForm>
<html>
    <head>
        
         <link rel="stylesheet" type="text/css" media="all" href="<?= base_url() ?>css/newForm.css"/>
         
        <style>
               
                 
                input {
                        display: block;
                }
        </style>
       <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <script>
                
                function checkPassword() {
                        var p1 = $("#pass1");
                        var p2 = $("#pass2");

                if (p1.val() == p2.val()) {
                    p1.get(0).setCustomValidity(""); // All is well, clear error message
                    return true;
                }
                else {
                    p1.get(0).setCustomValidity("Passwords do not match");
                    return false;
                }
            }
        </script>
    </head>
<body>
    <div style="height:100%;">
        <header>
            <nav>
                <ul>
                    <li>
                         <a href="#" class="logo-link">
                            Storefront Calendar<span id="logo-caret" class="icon"></span>
                        </a>
                        <ul>
                            <li><?= anchor('account/form_new_user', 'Add New User') ?></li>
                            <li><?= anchor('account/form_edit_user', 'Edit User') ?></li>
                            <li><?= anchor('account/form_new_client', 'Add New Client') ?></li>
                            <li><?= anchor('account/form_edit_client', 'Edit Client') ?></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </header>
        
        <p>&nbsp;&nbsp;&nbsp;&nbsp;Add New Client</p>
      
        <table>
            <tr>
                <td>
                    <?php
                    	echo form_open('account/create_new_client');
                    	echo form_label('Product/ Agency Name');
                    	echo form_error('partnername');
						
                   	 	echo form_input(array(
                        	'name' => 'partnername',
                        	'value' => set_value('partnername'),
                        	'placeholder' => 'Fullname',
                        	'required' => 'required'
                   		 ));
                   ?>
			   </td>
			   <td>
				   <?php
                   	 	echo form_label('Program/ Group name');
                    	echo form_error('programname');
					
                		echo form_input(array(
                        	'name' => 'programname',
                        	'value' => set_value('programname'),
                        	'required' => 'required'
                   	 	 ));
                    ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php
                  		echo form_label('Username');
                  	  	echo form_error('name');
					
                  	  	echo form_input(array(
                  		  	'name' => 'name',
                    		'value' => set_value('name'),
                    		'placeholder' => 'Username',
                      	  	'required' => 'required'
                  		  ));
                    ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php
                   	 	echo form_label('Password');
                   	 	echo form_error('password');
						
                   	 	echo form_password(array(
                    		'name' => 'password',
                    		'id' => 'pass1',
                    		'value' => '',
                    		'placeholder' => 'at least 6-characters',
                       	 	'required' => 'required'
                   		 ));
                    ?>
				</td>

				<td>
					<?php
                    	echo form_label('Password Confirmation');
                    	echo form_error('passconf');
					
                    	echo form_password(array(
                        	'name' => 'passconf',
                        	'id' => 'pass2',
                        	'value' => '',
                        	'required' => 'required',
                        	'oninput' => 'checkPassword();'
                    	));
                    ?>
				</td>

			</tr>
			<tr>
				<td>
					<?php
                    	echo form_label('Manager Name');
                    	echo form_error('manager');
						
                    	echo form_input(array(
                        	'name' => 'manager',
                        	'value' => set_value('manager'),
                        	'placeholder' => 'Fullname',
                        	'required' => 'required'
                    	));
                   ?>
			   </td>
			   <td>
				   <?php
                   		echo form_label('Position');
                    	echo form_error('managerposition');
					
                   	 	echo form_input(array(
                        	'name' => 'managerposition',
                       	 	'value' => set_value('managerposition'),
                        	'placeholder' => "Manange's position",
                        	'required' => 'required'
                    	));
                    ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php
                    	echo form_label('Facilitator Name');
                    	echo form_error('programfc');
						
                    	echo form_input(array(
                        	'name' => 'programfc',
                        	'value' => set_value('programfc'),
                        	'placeholder' => 'Fullname',
                        	'required' => 'required'
                    	));
                   ?>
			   </td>
			   <td>
				   <?php
                    	echo form_label('Position');
                   	 	echo form_error('fcposition');
					
                   	 	echo form_input(array(
                     	   'name' => 'fcposition',
                     	   'value' => set_value('fcposition'),
                     	   'placeholder' => "Manange's position",
                     	   'required' => 'required'
                   		));
                    ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php
                   	 	echo form_label('Telephone Number');
                   	 	echo form_error('phone');
					
                  	  	echo form_input(array(
                        	'name' => 'phone',
                        	'value' => set_value('phone'),
                       	 	'placeholder' => '',
                       	 	'required' => 'required',
                   		 ));
                    ?>
				</td>
				<td>
					<?php
                    	echo form_label('Fax Number');
                   	 	echo form_error('fax');
					
                   	 	echo form_input(array(
                       	 	'name' => 'fax',
                       	 	'value' => set_value('fax'),
                        	'placeholder' => 'Optional',
                        	'required' => 'required',
                   		 ));
                    ?>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<?php
                   	 	echo form_label('Address');
                   	 	echo form_error('address');
						
                    	echo form_input(array(
                      	 	'name' => 'address',
                      	  	'value' => set_value('address'),
                      	 	'placeholder' => 'Street, City, Postal Code',
                       		'required' => 'required',
                    		));
                    ?>
				
				</td>
			</tr>
			<tr>
				<td rowspan="1">
					<?php
                   		echo form_label('Email Address');
                    	echo form_error('email');
						
                    	echo form_input(array(
                        	'name' => 'email',
                        	'value' => set_value('email'),
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
                	?>
				</td>
				<td>
					<?php
                  	 	echo anchor('main/index', 'Cancel');
                  	?>
				</td>
			</tr>
			<tr height="70px">
			</tr>
		</table>
	</div>
</body>

</html>