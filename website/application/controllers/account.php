<?php

/*
 * TODO: Add validation for the email and ensure that the email is valid.
 * TODO: Add a new form for adding a client.(DONE)
 * TODO: Add a new form for editing a client (should load the old values and
 *       then allow changing the values and update the database after updating). It
 *       should also validate that all the values are valid. (ALMOST)
 *
 * CLARK TODO: Please add a separate email function so that email functionality is
 *             not repeated code over and over again.
 */

class Account extends CI_Controller {

    function __construct() {
        // Call the Controller constructor
        parent::__construct();
        //session_start();
    }

    public function _remap($method, $params = array()) {
        // enforce access control to protected functions

        $user = $this->session->userdata('user');

        $protected = array(
            'form_update_password',
            'update_password',
            'form_recover_password',
            'recover_password',
            'logout'
        );

        $admin = array('form_new_user', 'form_new_client', 'create_new_user', 'create_new_client');

        /* Check if the user is logged in */
        if (in_array($method, array_merge($protected, $admin)) && !$user) {

            redirect('account/index', 'refresh');
        } else if (in_array($method, $admin) && !$user) {

            /* Check if the user is an admin */
            if ($user->usertype != User::ADMIN)
                redirect('main/index', 'refresh');
        }

        return call_user_func_array(array($this, $method), $params);
    }

    function index() {
        $this->load->view('account/login');
    }

    /*
     * Loads the main form for making a new user.
     */

    function form_new_user() {
        $this->load->model('client_model');
        $data['clients'] = $this->client_model->display_all_clients();
        $this->load->view('account/new_user', $data);
    }

    /*
     * Loads the main form for making a new client.
     */

    function form_new_client() {

        $this->load->view('account/new_client');
    }

    function form_edit_user() {
        $this->load->library('form_validation');
        $this->load->model('user_model');
        $this->load->model("client_model");

        $data['query'] = $this->user_model->display_all_users();
        $data['clients'] = $this->client_model->display_all_clients();
        $data['user'] = new User();
        $this->load->view('account/edit_user', $data);
    }

    /*
     * Loads the main form for making a new client.
     */

    function form_edit_client() {
        $this->load->model('client_model');
        $data['clients'] = $this->client_model->display_all_clients();
        $data['client'] = new Client();
        $this->load->view('account/edit_client', $data);
    }

    /*
     * Loads the main form for updating your password.
     */

    function form_update_password() {
        $this->load->view('account/update_password');
    }

    /*
     * Loads the main form for recovering your lost password with your email
     * that you are associated with.
     *
     * TODO: The emailing system should be setup.
     */

    function form_recover_password() {
        $this->load->view('account/recover_password');
    }

    /*
     * Checks the login credentials as stored in the database.
     *
     * Runs server-side validation. TODO: Add error messages so the user 
     * understands and knows when they have entered the right or wrong 
     * credentials.
     */

    function login() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('account/login');
        } else {
            $login = $this->input->post('username');
            $password = $this->input->post('password');

            $this->load->model('user_model');

            $user = $this->user_model->get($login);

            if (isset($user) && $user->compare_password($password)) {
                $data = array('user' => $user);
                $this->session->set_userdata($data);
                $data['user'] = $user;
                //to easily retrive the login id later
                //$this->session->set_userdata("login", $user->login);

                redirect('main/index', 'refresh'); //redirect to the main application page
            } else {
                redirect('account/index', 'refresh');
            }
        }
    }

    /*
     * Logs out the current user by unsetting the user class.
     */

    function logout() {
        $this->session->unset_userdata('user');
        redirect('account/index', 'refresh');
    }

    /*
     * The functionality for the form in order to create a new user. It checks 
     * the validation of the form and creates a new instance of a User and
     * stores it in the database.
     */

    function create_new_user() {
        $this->load->library('form_validation');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('account/new_user');
        } else {
            $user = new User();

            $user->login = $this->input->post('username');
            $user->first = $this->input->post('first');
            $user->last = $this->input->post('last');
            $password = $this->input->post('password');
            $user->encrypt_password($password);
            $user->email = $this->input->post('email');
            $user->clientid = intval($this->input->post("agency"));
            $user->usertype = intval($this->input->post("type"));

            $this->load->library('email');

            $config['protocol'] = 'smtp';
            $config['smtp_host'] = 'ssl://smtp.gmail.com';
            $config['smtp_port'] = '465';
            $config['smtp_timeout'] = '7';
            $config['smtp_user'] = 'c1chenhu@gmail.com';
            $config['smtp_pass'] = 'sinceqq123';
            $config['charset'] = 'utf-8';
            $config['newline'] = "\r\n";
            $config['mailtype'] = 'text'; // or html
            $config['validation'] = TRUE; // bool whether to validate email or not


            $this->email->initialize($config);

            $this->email->from('eaststorefront@storefront.com', 'eaststorefront');
            $this->email->to($user->email);

            $this->email->subject('eaststorefront account successfully created');
            $this->email->message("
                                welcome to eaststorefront $user->login
                                Your password is $password , please remember it ");

            $result = $this->email->send();

            $this->load->model('user_model');

            $this->user_model->insert($user);

            $this->session->set_flashdata('message', "The new user " .
                    $user->first . " " . $user->last .
                    " has been made!");
            redirect('main/index', 'refresh'); //redirect to the main application page
        }
    }

    /*
     * Update the password of the current logged in user.
     */

    function update_password() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('old_password', 'Old Password', 'required');
        $this->form_validation->set_rules('new_password', 'New Password', 'required');


        if ($this->form_validation->run() == FALSE) {
            $this->load->view('account/update_password');
        } else {
            $user = $this->session->userdata('user');

            $old_password = $this->input->post('old_password');
            $new_password = $this->input->post('new_password');

            if ($user->compare_password($old_password)) {
                $user->encrypt_password($new_password);
                $this->load->model('user_model');
                $this->user_model->update_password($user);
                $data['user'] = $user;
                $this->load->view('main', $data);
            } else {
                $data['errorMsg'] = "Incorrect password!";
                $this->load->view('account/update_password', $data);
            }
        }
    }

    /*
     * Recover the password by using the emailing system.
     */

    function recover_password() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'email', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('account/recover_password');
        } else {
            $email = $this->input->post('email');
            $this->load->model('user_model');
            $user = $this->user_model->get_from_email($email);

            if (!isset($user)) {
                $this->load->model('client_model');
                $client = $this->client_model->get_from_email($email);
            }

            if (isset($user) || isset($client)) {
                $password = $user->init();
                $this->user_model->update_password($user);

                $this->load->library('email');

                $config['protocol'] = 'smtp';
                $config['smtp_host'] = 'ssl://smtp.gmail.com';
                $config['smtp_port'] = '465';
                $config['smtp_timeout'] = '7';
                $config['smtp_user'] = 'c1chenhu@gmail.com';
                $config['smtp_pass'] = 'sinceqq123';
                $config['charset'] = 'utf-8';
                $config['newline'] = "\r\n";
                $config['mailtype'] = 'text'; // or html
                $config['validation'] = TRUE; // bool whether to validate email or not

                $this->email->initialize($config);

                $this->email->from('eaststorefront@storefront.com', 'eaststorefront');
                $this->email->to($user->email);

                $this->email->subject('Password recovery');
                $this->email->message("Your new password is $password , please remember it ");

                $result = $this->email->send();

                $this->load->view('account/email_page');
            } else {
                $data['errorMsg'] = "No record exists for this email!";
                $this->load->view('account/recover_password', $data);
            }
        }
    }

    /*
     * Remove specific user and all infos that related to this user
     */

    function delete_user() {
        $login = $this->input->post('login');
        $this->load->model('user_model');

        $currentlogin = $this->session->userdata('login');

        if ($currentlogin == $login) {
            redirect("account/form_edit_user", "refresh");
        } else {
            $this->user_model->delete_user($login);
            redirect("account/form_edit_user", "refresh");
        }
    }

    function change_user() {
        $login = $this->input->post('category');

        $this->load->model('user_model');
        $this->load->model('client_model');
        $user = $this->user_model->get($login);

        $data['user'] = $user;
        $data['query'] = $this->user_model->display_all_users();
        $data['clients'] = $this->client_model->display_all_clients();

        $this->load->view('account/edit_user', $data);
    }

    /* Edit the user's information */

    function edit_user() {
        
        $this->load->model('user_model');
        $this->load->model("client_model");

        $login = $this->input->post('login');
        $user = $this->user_model->get($login);

        $this->load->library('form_validation');
        $this->form_validation->set_rules('first', 'First', 'required|max_length[20]');
        $this->form_validation->set_rules('last', 'Last', 'required|max_length[20]');
        $this->form_validation->set_rules('email', 'Email', "required|valid_email|max_length[120]|callback_email_check");

        if ($this->form_validation->run() == FALSE) {
            $data['user'] = $user;
            $data['query'] = $this->user_model->display_all_users();
            $data['clients'] = $this->client_model->display_all_clients();
            $this->load->view('account/edit_user', $data);
            
        } else {

            $first = $this->input->post('first');
            $last = $this->input->post('last');
            $email = $this->input->post('email');
            $client_id = intval($this->input->post('agency'));
            $user_type = intval($this->input->post('type'));

            $user->first = $first;
            $user->last = $last;
            $user->email = $email;
            $user->clientid = $client_id;
            $user->usertype = $user_type;

            //TO DO : update only one function for efficiency
            $this->user_model->update_email($user);
            $this->user_model->update_name($user);
            $this->user_model->update_usertype($user);
            $this->user_model->update_clientid($user);

            $data['user'] = $user;
            $data['query'] = $this->user_model->display_all_users();
            $data['clients'] = $this->client_model->display_all_clients();

            $this->load->view('account/edit_user', $data);
        }
        
    }

    /*
     * Check the given email is already exist in database or not
     * XXX: What is this function for? Unique elements can be checked
     *      automatically by doing is_unique[user.email] when validating forms.
     * Thurai : is_unique will fail because if user didn't change email the email will be in database hence it no unique
     */

    public function email_check($email) {

        $login = $this->input->post('login');

        $this->load->model("user_model");
        $user = $this->user_model->get($login);

        if ($user->email != $email) {
            if ($this->user_model->get_same_email($email)) {
                return TRUE;
            } else {
                $this->form_validation->set_message("email_check", "The email already exists");
                return FALSE;
            }
        }
    }

    /*
     * Create a new client and add it to the database. Very simplified version
     * of a client for now.
     *
     * TODO: Create a more sophisticated client class and associated database
     * table for it.
     */

    function create_new_client() {
        $this->load->library('form_validation');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('account/new_client');
        } else {
            $client = new Client();

            //Sorry for inconsistency between client's parameters and input's names but I'll try to change it soon. 
            $client->agency = $this->input->post('partnername');
            $client->program = $this->input->post('programname');
            $client->manager = $this->input->post('manager');
            $client->manager_position = $this->input->post('managerposition');
            $client->facilitator = $this->input->post('programfc');
            $client->facilitator_position = $this->input->post('fcposition');
            $client->address = $this->input->post('address');
            $client->phone = $this->input->post('phone');
            $client->fax = $this->input->post('fax');
            $client->email = $this->input->post('email');
            $client->agreement_status = $this->input->post('agreement_status');
            $client->insurance_status = $this->input->post('insurance');
            $client->category = $this->input->post('category');

            /*
            $newclient = $client->name;
            $newPassword = $clearPassword;
            $this->load->library('email');

            $config['protocol'] = 'smtp';
            $config['smtp_host'] = 'ssl://smtp.gmail.com';
            $config['smtp_port'] = '465';
            $config['smtp_timeout'] = '7';
            $config['smtp_user'] = 'c1chenhu@gmail.com';
            $config['smtp_pass'] = 'sinceqq123';
            $config['charset'] = 'utf-8';
            $config['newline'] = "\r\n";
            $config['mailtype'] = 'text'; // or html
            $config['validation'] = TRUE; // bool whether to validate email or not


            $this->email->initialize($config);

            $this->email->from('eaststorefront@storefront.com', 'eaststorefront');
            $this->email->to($client->email);

            $this->email->subject('eaststorefront account successfully created');
            $this->email->message("
                                welcome to eaststorefront $newclient
                                Your password is $newPassword , please remember it ");

            $result = $this->email->send();
             * 
             */

            $this->load->model('client_model');

            $this->client_model->insert($client);

            $this->session->set_flashdata('message', "The new client " .
                    $client->name .
                    " has been made!");
            redirect('main/index', 'refresh'); //redirect to the main application page
        }
    }

    /*
     * Update client's data according to choosen client
     * 
     * 
     */
    function change_client(){
        $this->load->model('client_model');
        
        $id = $this->input->post('agency');
        $data['clients'] = $this->client_model->display_all_clients();
        $data['client'] =  $this->client_model->get_from_id($id);
        
        $this->load->view('account/edit_client', $data);
    }
    
    /*
     * Create a new client and add it to the database. Very simplified version
     * of a client for now.
     *
     * TODO: Create a more sophisticated client class and associated database
     * table for it.
     */

    function edit_client() {
        $this->load->model('client_model');

        $id = $this->input->post('id');
        $client = $this->client_model->get_from_id($id);
        
        $this->load->library('form_validation');

        if ($this->form_validation->run() == FALSE) {
            $data['clients'] = $this->client_model->display_all_clients();
            $data['client'] = $client;

            $this->load->view('account/edit_client', $data);
        } else {
            $client->program = $this->input->post('programname');
            $client->manager = $this->input->post('manager');
            $client->manager_position = $this->input->post('managerposition');
            $client->facilitator = $this->input->post('programfc');
            $client->facilitator_position = $this->input->post('fcposition');
            $client->address = $this->input->post('address');
            $client->phone = $this->input->post('phone');
            $client->fax = $this->input->post('fax');
            $client->email = $this->input->post('email');
            $client->agreement_status = $this->input->post('agreement_status');
            $client->insurance_status = $this->input->post('insurance');
            $client->category = $this->input->post('category');
            
            $this->client_model->update_client_info($client);
            
            $this->session->set_flashdata('message', "The client " .
                    $client->agency .
                    " has been updated!");
            $data['clients'] = $this->client_model->display_all_clients();
            $data['client'] = $client;

            $this->load->view('account/edit_client', $data); 
        }
    }
    
    
    /*
     * delete clients from database
     * TO DO: delete all the connected users as well
     */
    function delete_client(){
        $this->load->model('client_model');
        $this->load->model('user_model');
        
        $login = $this->session->userdata('login'); 
        $current_user = $this->user_model->get($login);
        
        $client_id = $this->input->post('id');
        
        if ($current_user->id == $client_id) {
            redirect("account/form_edit_client", "refresh");
        }
        else{    
            $this->client_model->delete_client($client_id);
            redirect("account/form_edit_client", "refresh");
        }
        
        
    }

}
