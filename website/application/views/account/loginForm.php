<!DOCTYPE html>

<html>
    <head>
        <link rel="stylesheet" type="text/css" media="all" href="<?= base_url() ?>css/loginpage.css"/>
        
    </head>
    <body>
        
        <div class="header"></div>
        
        <div class='banner'>
            <img class='spImage' src="<?= base_url() ?>images/banner.png" height="auto" width="100%">
        </div>
        
        
        <div class="centered"＞

            
        <?php
            if (isset($errorMsg)) {
                echo "<p>" . $errorMsg . "</p>";
            }
            echo form_open('account/login');
            ?>
            <ul>
                <li style="height:20px">
                    <h5 class="specialH">Login</h5>
                    <h5>
                        <?php
                        echo anchor('account/recoverPasswordForm', 'Forgot Password');
                        ?>
                    </h5>
                   
                </li>
                <li class="line"></li>
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
                    'style' => 'position: absolute; left: -9999px; width: 1px; height: 1px;'
                );
                ?>
                <?php
                echo form_submit($attributes, 'Login');
                ?>
                
            </ul>
            <?php
            echo form_close();
            ?>
        </div>
        
        <img class="background" src="<?= base_url() ?>images/photo-Cover.jpg">
        
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

