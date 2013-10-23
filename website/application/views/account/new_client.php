
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
                    p1.get(0).setCustomValidity("");  // All is well, clear error message
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
        <nav>
                <ul>
                    <li style="margin-left: 20px;">
                        <button>
                            <input class="imageIcon" type="image" src="<?= base_url() ?>images/b_actions.png"/>
                         
                        <ul>
                            	<li><?= anchor('account/form_new_user', 'Create New User') ?></li>
                                <li><?= anchor('account/modify_user', 'Modify User') ?></li>
                                <li><?= anchor('account/delete_user', 'Delete User') ?></li>
                                <li><?= anchor('account/form_new_client', 'Create New Client') ?></li>
                                <li><?= anchor('account/form_edit_client', 'Edit Client') ?></li>
                                <li><a href="#">Do..</a></li>
                        </ul>
                        </button>
                    </li>
                    
                    <li class="special">
                            <h5 class="header">STOREFRONT CALENDER</h5>
                    </li>
                    
                    <li style="float:right; margin-right:20px;">
                        <button>
                            <input class="imageIcon" type="image" src="<?= base_url() ?>images/b_actions.png"/>
                            <ul style="left:85%;">
                            <li><a href="#">Email</a></li>
                            <li><a href="#">User Experience</a></li>
                        </ul>
                        </button>
                            
                    </li>
                </ul>
            </nav>
        
        <p>&nbsp;&nbsp;&nbsp;&nbsp;New Client</p>
      
        <table>    
            <tr>
                <td>
                    <?php
                    echo form_open('account/createNew');
                    echo form_label('Product/ Agency Name');
                    echo form_error('name');
                    echo form_input(array(
                        'name' => 'name',
                        'value' => set_value('name'),
                        'placeholder' => 'Fullname',
                        'required' => 'required'
                    ));

                   ?>
                </td>
                <td>
                    <?php
                    echo form_label('Program/ Group name');
                    echo form_error('username');
                    echo form_input(array(
                        'name' => 'username',
                        'value' => set_value('username'),
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
                        'name' => 'username',
                        'value' => set_value('username'),
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
                        'name' => 'passcof',
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
                    echo form_error('mName');
                    echo form_input(array(
                        'name' => 'mName',
                        'value' => set_value('mName'),
                        'placeholder' => 'Fullname',
                        'required' => 'required'
                    ));

                   ?>
                </td>
                <td>
                    <?php
                    echo form_label('Position');
                    echo form_error('mPos');
                    echo form_input(array(
                        'name' => 'mPos',
                        'value' => set_value('mPos'),
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
                    echo form_error('fName');
                    echo form_input(array(
                        'name' => 'fName',
                        'value' => set_value('fName'),
                        'placeholder' => 'Fullname',
                        'required' => 'required'
                    ));

                   ?>
                </td>
                <td>
                    <?php
                    echo form_label('Position');
                    echo form_error('fPos');
                    echo form_input(array(
                        'name' => 'fPos',
                        'value' => set_value('fPos'),
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
                    echo form_label('Alternate Number');
                    echo form_error('Aphone');
                    echo form_input(array(
                        'name' => 'Aphone',
                        'value' => set_value('Aphone'),
                        'placeholder' => 'Optional',
                        'required' => 'required',
                    ));
                    ?>
                </td>    
            </tr>
            
            <tr >
                
                
                
                <td>
                    <?php
                    echo form_label('Street');
                    echo form_error('Street');
                    echo form_input(array(
                        'name' => 'Street',
                        'value' => set_value('Street'),
                        'placeholder' => 'Street, Unit #',
                        'required' => 'required',
                    ));
                    ?>
                    <br>
                    <?php
                
                    echo form_error('City');
                    echo form_input(array(
                        'name' => 'City',
                        'value' => set_value('City'),
                        'placeholder' => 'City,State',
                        'style' => 'margin-top:5px;',
                        'required' => 'required',
                    ));
                    ?>
                    <br>
                    <?php
    
                    echo form_error('Post');
                    echo form_input(array(
                        'name' => 'Post',
                        'value' => set_value('Post'),
                        'placeholder' => 'Postal Code',
                        'style' => 'margin-top:5px;',
                        'required' => 'required',
                    ));
                    ?>
                </td>
                
            </tr>
            <tr >
                
                <td rowspan="1">
                    <?php
                    echo form_label('Email Address');
                    echo form_error('Address');
                    echo form_input(array(
                        'name' => 'Address',
                        'value' => set_value('Address'),
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
                    echo form_submit('', 'Cancel');
                    ?>
                </td>
            
            </tr>
            <tr height=70px">
                
            </tr>
            
                
                 
        </table>
    
</div>
</body>

</html>

