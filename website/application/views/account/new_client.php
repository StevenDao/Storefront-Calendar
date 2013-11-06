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
        <header>
            <nav>
                <ul>
                    <li>
                        <a href="<?= base_url() ?>#" class="logo-link">
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

        <p class="specialP">&nbsp;&nbsp;&nbsp;&nbsp;Add New Client</p>

        <table class="tableS">`
            
            <tr>
                <td>
                    <?php
                    echo form_open('account/create_new_client');
                    echo form_label('Product/ Agency Name');
                    echo form_error('partnername');

                    echo form_input(array(
                        'name' => 'partnername',
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
                        'required' => 'required'
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
                        'required' => 'required'
                    ));
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php
                    $options = array(
                        "Community Information" => "Community Information",
                        "Education" => "Education",
                        "Employment" => "Employment",
                        "Financial" => "Financial",
                        "Food" => "Food",
                        "Health" => "Health",
                        "Housing" => "Housing",
                        "Legal" =>  "Legal",
                        "Mental Health/Counselling" =>  "Mental Health/Counselling",
                        "Parenting/Children Service" => "Parenting/Children Service",
                        "Recreation" => "Recreation",
                        "Settlement" => "Settlement",
                        "Storefront Information" => "Storefront Information",
                        "Transportation" => "Transportation",
                        "Violence/Safety" => "Violence/Safety",
                        "Volunteerism" => "Volunteerism",
                        "Storefront Business Use" => "Storefront Business Use",
                        "Storefront Internal" => "Storefront Internal",
                        "Community Organizing" => "Community Organizing",
                        "Resident Leadership" => "Resident Leadership"
                    );

                    echo form_label("Category");
                    echo form_dropdown('category', $options, "Education");
                    ?>
                </td>
                <td>
                    <?php
                    echo form_label('Email Address');
                    echo form_error('email');

                    echo form_input(array(
                        'name' => 'email',
                        'required' => 'required',
                    ));
                    ?>
                </td>

            </tr>
            <tr>
                <td>
                    <?php
                    echo form_label('Agreement Status');
                    echo form_error('Agreement status');

                    echo form_input(array(
                        'name' => 'agreement_status'
                    ));
                    ?>
                </td>
                
                <td>
                    <?php
                    echo form_label('Insurans Status');
                    echo form_error('insurance');

                    echo form_input(array(
                        'name' => 'insurance',
                        'required' => 'required',
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
                    echo anchor('main/index', 'Cancel');
                    ?>
                </td>
            </tr>
            <tr height="70px">
            </tr>
        </table>
    </body>

</html>
