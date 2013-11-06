<!DOCTYPE html>

<html>
    <head>
        <link rel="stylesheet" type="text/css" media="all" href="<?= base_url() ?>css/reset.css"/>
        <link rel="stylesheet" type="text/css" media="all" href="<?= base_url() ?>css/newForm.css"/>
        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    </head>

    <body style="margin:0px;padding: 0px;">
        <header>
            <nav>
                <ul>
                    <li>
                        <a href="<?= base_url() ?>" class="logo-link">
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

        <p class="specialP">&nbsp;&nbsp;&nbsp;&nbsp;Edit User</p>
        <?php $options = array(); 
                if($user->login == "" ){
                    $options["Select user"] = "Select user";
                }
        ?>
        <table class="tableS">  
            <tr>
                <td>
                    <?php
                    foreach ($query as $row):
                        $options["$row->login"] = "$row->login ";

                    endforeach;
                    ?>


                    <?php
            
                    
                    echo form_open('account/change_user');
                    echo form_label('Username');
                    echo form_error('username');
                    $js = "value='$user->login' onChange='this.form.submit()'";
                    echo form_dropdown('category', $options, $user->login, $js);
                    echo form_close();
                    ?>

                </td>
            </tr>

            <tr>
                <td>
                    <?php
                    $hidden = array("login" => "$user->login", "category" => "$user->login");
                    echo form_open('account/edit_user', '', $hidden);
                    echo form_label('First name');
                    echo form_error('first');
                    echo form_input(array(
                        'name' => 'first',
                        'value' => "$user->first",
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
                        'value' => "$user->last",
                        'required' => 'required'
                    ));
                    ?>
                </td>
            </tr>
              <tr>
                <td>
                    <?php
                        $client_type =array();
                        $client_type["1"] = "admin";
                        $client_type["2"] = "client";
                        $user_type = strval($user->usertype);
                        
                        echo form_label('User type');
                        echo form_dropdown("type", $client_type,$user_type);
                        
                    
                    
                    ?>
                </td> 
                <td>
                    <?php
                        $agency = array();
                        foreach ($clients as $row):
                        $agency["$row->id"] = "$row->agency";
                    endforeach;
                    
                    $agency_id = strval($user->clientid);
                    
                    echo form_label("Agency Name");
                    echo form_dropdown("agency", $agency, $agency_id);
                    
                    ?>
                </td>
            </tr>

            <tr>

                <td>
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
                        'value' => 'Save',
                        'style' => 'float:right;'));
                    echo form_close();
                    ?>
                </td>


                <td>
                    <?php
                    echo form_open('account/delete_user', '', $hidden);
                    echo form_submit('delete', "Delete", "style=background-color:red;");
                    echo form_close();
                    ?>
                </td>

            </tr>
            <tr height=70px">

            </tr>



        </table>
    </body>
</html>