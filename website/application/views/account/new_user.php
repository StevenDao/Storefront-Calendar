<!DOCTYPE html>
<!http://localhost/PhpProject2/index.php/account/newForm>
<html>
<head>
  <link rel="stylesheet" type="text/css" media="all" href="<?= base_url() ?>css/reset.css"/>
  <link rel="stylesheet" type="text/css" media="all" href="<?= base_url() ?>css/newForm.css"/>
  <style> input { display: block; } </style>

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

<p>&nbsp;&nbsp;&nbsp;&nbsp;Add New User</p>

<table>    
  <tr>
    <td>
      <?php
          echo form_open('account/create_new_user');
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
              'name' => 'passconf',
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
          echo anchor('main/index', "Cancel");  
          echo form_close();
      ?>
    </td>

  </tr>
  <tr height=70px">

  </tr>



</table>

</body>

</html>

