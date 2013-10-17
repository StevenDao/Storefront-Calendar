<!DOCTYPE html>

<html>
    <head>
        <link rel="stylesheet" type="text/css" media="all" href="<?= base_url() ?>css/loginpage.css"/>
        
    </head>
    <body>
        
        <div class="header">
            
        </div>
        
        <div class='banner'>
            <img class='spImage' src="<?= base_url() ?>images/logo.png" height="auto" width="233px">
        </div>
        
        
        <div class="centered">

            
        <?php
            if (isset($errorMsg)) {
                echo "<p>" . $errorMsg . "</p>";
            }
            echo form_open('account/login');
            ?>
            <ul>
                <li>
                    <h5>
                        <?php
                        echo anchor('account/recoverPasswordForm', 'Forgot Password');
                        ?>
                    </h5>
                    <h2>Login</h2>
                </li>
                <li>
                    <?php
                   
                    echo form_error('username');
                    echo form_input(array(
                                    'name' => 'username',
                                    'value' => set_value('username'),
                                    'placeholder' => 'Username',
                                    'required' => 'required'
              
                                    ));
                    ?>
                </li>

                <li>
                    <?php
                    echo form_error('password');
                    echo form_password(array(
                                    'name' => 'password',
                                    'value' => '',
                                    'placeholder' => 'Password',
                                    'required' => 'required'
              
                                    ));
                    ?>
                </li>
                <?php
                $attributes = array(
                    'name' => 'submit',
                    'class' => 'submit');
                ?>
                <?php
                echo form_submit($attributes, 'Login');
                ?>
            </ul>
            <?php
            echo form_close();
            ?>
        </div>
        
        <footer>
            
            <div>
                <section>
                    <h6>About</h6>
                    <ul class="special">
                        <li>
                            The East Storefront provides services for the community in the East Scarborough region <br>
                            bla bla bla bla bla bla someone good with english please edit this area, I'm not the  <br>
                            for this task, please don't kill me!! :D 
                        </li> 
                    </ul>
                    </section>
                    <section>
                    <h6>Address</h6>
                    <ul class='special'>
                        <li>
                            1 Herderson Drive
                        </li>
                    </ul>
                    </section>
                
                    <section>
                    <h6>Links</h6>
                    <ul class='special'>
                        <li>
                            <a href='#'> Nope, the link takes nowhere</a>
                        </li>
                        <li>
                            <a href='#'> Nope, the links take nowhere</a>
                        </li>
                        <li>
                            <a href='#'> Nope, the links take nowhere</a>
                        </li>
                    </ul>
                    </section>
                    
                
            </div>
            
            
        </footer>
        
            



    </body>

</html>

