<!DOCTYPE html>

<html>
<head>
  <link rel="stylesheet" type="text/css" media="all" href="<?= base_url() ?>css/reset.css"/>
  <link rel="stylesheet" type="text/css" media="all" href="<?= base_url() ?>css/loginpage.css"/>
</head>
<body>
  <div id="container">

    <div class='banner'>
      <img class='spImage' src="<?= base_url() ?>images/logo.png" height="auto" width="100%">
    </div>

    <div class="centered">
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
            echo anchor('account/recover_password', 'Forgot Password');
            ?>
          </h5>

        </li>
        <div class="line"></div>
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
    <div class="background">
      <img src="<?= base_url() ?>images/photo-Cover.jpg">
    </div>
    <div class="footer">
      <section id="about">
        <h6>About</h6>
        <p>
          Scarborough is a safe, well-educated and prosperous community.  The
          Storefront contributes to making the impossible possible by providing
          accessible sites for community members of all ages and cultures to find
          and share solutions they need to live healthy lives, find meaningful
          work, play and thrive. We are seen as an excellent model for
          sustainable social innovation and transformation in communities.
        </p>
      </section>
      <section id="address">
        <h6>Address</h6>
        4040 Lawrence Ave E, Scarborough, ON M1E 2R6 <br />
        (416) 208-9889
      </section>
      <div class=clear></div>
    </div>
  </div>
</body>
</html>
