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
                            <li><a href="#">Add Account</a></li>
                            <li><a href="#">Manage Account</a></li>
                            <li><a href="#">Do...</a></li>
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
                    echo form_label('Name');
                    echo form_error('first');
                    echo form_input(array(
                        'name' => 'first',
                        'value' => set_value('first'),
                        'placeholder' => 'First Name',
                        'required' => 'required'
                    ));

                   ?>
                </td>
                <td>
                    
                    <?php
                    
                    echo form_label("Last Name ","dd",array(
                        'style' => 'color:transparent;'
                    ));
                    echo form_error('last');
                    echo form_input(array(
                        'name' => 'last',
                        'value' => set_value('last'),
                        'placeholder' => 'Last Name',
                        'required' => 'required'
                    ));
                    ?>
                </td>
            </tr>
            <tr>
                <td>
              
                    <?php
                    echo form_label('Username');
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
                    echo form_label('Password');
                    echo form_error('password');
                    echo form_password(array(
                        'name' => 'password',
                        'id' => 'pass1',
                        'value' => '',
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
            
            <tr >
                
                <td rowspan="1">
                    <?php
                    echo form_label('Email Address');
                    echo form_error('Email');
                    echo form_input(array(
                        'name' => 'Email',
                        'value' => set_value('Email'),
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
                    echo achor('main/index', "Cancel");               
                    ?>
                    
                </td>
            
            </tr>
            <tr height=70px">
                
            </tr>
            
                
                 
        </table>
    
</div>
</body>

</html>

