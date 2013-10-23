<?php

/*
 * TODO: Add validation for the email and ensure that the email is valid.
 * TODO: Add a new form for adding a client.
 * TODO: Add a new form for editing a client (should load the old values and
 *       then allow changing the values and update the database after updating). It
 *       should also validate that all the values are valid.
 */
class Account extends CI_Controller
{
	function __construct() {
		// Call the Controller constructor
		parent::__construct();
		session_start();
	}

	public function _remap($method, $params = array()) {
		// enforce access control to protected functions

		$protected = array('updatePasswordForm','updatePassword','logout');
		$admin = array('create_new_user', 'create_new_client');

		// Check if the user is logged in
		if (in_array($method,$protected) && !isset($_SESSION['user']))
			redirect('account/index', 'refresh');

		// Check if the user is an admin
		if (in_array($method,$admin) &&
				(!isset($_SESSION['user'])) &&
				(!($_SESSION['user']->usertype == User::ADMIN)))
			redirect('main/index', 'refresh');

		return call_user_func_array(array($this, $method), $params);
	}

	function index() {
		$this->load->view('account/loginForm');
	}

	/*
	 * Loads the main form for making a new user.
	 */
	function form_new_user() {
		$this->load->view('account/new_user');
	}

	/*
	 * Loads the main form for making a new client.
	 */
	function form_new_client() {
		$this->load->view('account/new_client');
	}
	
	/*
	 * Loads the main form for making a new client.
	 */
	function form_edit_client() {
		$this->load->model('client_model');
		$data['clients'] = $this->client_model->get_clients();
		$this->load->view('account/edit_client', $data);
	}

	/*
	 * Loads the main form for updating your password.
	 */
	function updatePasswordForm() {
		$this->load->view('account/updatePasswordForm');
	}

	/*
	 * Loads the main form for recovering your lost password with your email
	 * that you are associated with.
	 *
	 * TODO: The emailing system should be setup.
	 */
	function recoverPasswordForm() {
		$this->load->view('account/recoverPasswordForm');
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
			$this->load->view('account/loginForm');
		} else {
			$login = $this->input->post('username');
			$clearPassword = $this->input->post('password');

			$this->load->model('user_model');

			$user = $this->user_model->get($login);

			if (isset($user) && $user->comparePassword($clearPassword)) {
				$_SESSION['user'] = $user;
				$data['user'] = $user;

				redirect('main/index', 'refresh'); //redirect to the main application page
			} else {
				redirect('account/index', 'refresh');
			}
		}
	}

	/*
	 * Logs out the current user by destroying the session.
	 */
	function logout() {
		session_destroy();
		redirect('account/index', 'refresh'); //Then we redirect to the index page again
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
			$clearPassword = $this->input->post('password');
			$user->encryptPassword($clearPassword);
			$user->email = $this->input->post('email');
			
			$newuser = $user->login;
			$newPassword = $clearPassword;
			$this->load->library('email');

			$config['protocol']    = 'smtp';
			$config['smtp_host']    = 'ssl://smtp.gmail.com';
			$config['smtp_port']    = '465';
			$config['smtp_timeout'] = '7';
			$config['smtp_user']    = 'c1chenhu@gmail.com';
			$config['smtp_pass']    = 'sinceqq123';
			$config['charset']    = 'utf-8';
			$config['newline']    = "\r\n";
			$config['mailtype'] = 'text'; // or html
			$config['validation'] = TRUE; // bool whether to validate email or not
			
			
			$this->email->initialize($config);

			$this->email->from('eaststorefront@storefront.com', 'eaststorefront');
			$this->email->to($user->email);

			$this->email->subject('eaststorefront account successfully created');
			$this->email->message("
				welcome to eaststorefront $newuser
				Your password is $newPassword , please remember it ");

			$result = $this->email->send();
			
			// Placeholder until actual client functionality is made
			$user->clientid = 1;

			$this->load->model('user_model');

			$this->user_model->insert($user);

			$this->session->set_flashdata('message',
				"The new user " .
				$user->first . " " . $user->last .
				" has been made!");
			redirect('main/index', 'refresh'); //redirect to the main application page
		}
	}

	/*
	 * Update the password of the current logged in user.
	 */
	function updatePassword() {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('oldPassword', 'Old Password', 'required');
		$this->form_validation->set_rules('newPassword', 'New Password', 'required');


		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('account/updatePasswordForm');
		}
		else
		{
			$user = $_SESSION['user'];

			$oldPassword = $this->input->post('oldPassword');
			$newPassword = $this->input->post('newPassword');

			if ($user->comparePassword($oldPassword)) {
				$user->encryptPassword($newPassword);
				$this->load->model('user_model');
				$this->user_model->updatePassword($user);
				$data['user']=$user;
				$this->load->view('mainPage',$data);
			}
			else {
				$data['errorMsg']="Incorrect password!";
				$this->load->view('account/updatePasswordForm',$data);
			}
		}
	}

	/*
	 * Recover the password by using the emailing system.
	 */
	function recoverPassword() {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'email', 'required');

		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('account/recoverPasswordForm');
		}
		else
		{
			$email = $this->input->post('email');
			$this->load->model('user_model');
			$user = $this->user_model->getFromEmail($email);

			if (isset($user)) {
				$newPassword = $user->initPassword();
				$this->user_model->updatePassword($user);

				$this->load->library('email');

				$config['protocol']    = 'smtp';
				$config['smtp_host']    = 'ssl://smtp.gmail.com';
				$config['smtp_port']    = '465';
				$config['smtp_timeout'] = '7';
				$config['smtp_user']    = 'c1chenhu@gmail.com';
				$config['smtp_pass']    = 'sinceqq123';
				$config['charset']    = 'utf-8';
				$config['newline']    = "\r\n";
				$config['mailtype'] = 'text'; // or html
				$config['validation'] = TRUE; // bool whether to validate email or not

				$this->email->initialize($config);

				$this->email->from('eaststorefront@storefront.com', 'eaststorefront');
				$this->email->to($user->email);

				$this->email->subject('Password recovery');
				$this->email->message("Your new password is $newPassword , please remember it ");

				$result = $this->email->send();

				//$data['errorMsg'] = $this->email->print_debugger();

				//$this->load->view('account/emailPage',$data);
				$this->load->view('account/emailPage');

			}
			else {
				$data['errorMsg']="No record exists for this email!";
				$this->load->view('account/recoverPasswordForm',$data);
			}
		}
	}
	
	/*
	 * Remove specific user and all infos that related to this user
	 */
	function displayusers() {
		$this->load->library('form_validation');
		$this->load->model('user_model');
		$data['query'] = $this->user_model->displayAllUsers();
		$this->load->view('account/deletepage', $data); 
	}
	/*
	 * Not works for now
	*/
	function delete_user(){
		$this->load->library('form_validation');
		
		$login = $this->input->post('login');
		$this->user_model->deleteUser($login); 
		redirect('account/deletepage', 'refresh');
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

			$client->name = $this->input->post('name');
			$client->address = $this->input->post('address');
			$client->phone = $this->input->post('phone');

			$this->load->model('client_model');

			$this->client_model->insert($client);

			$this->session->set_flashdata('message',
				"The new client " .
				$client->name .
				" has been made!");
			redirect('main/index', 'refresh'); //redirect to the main application page
		}
	}

	/*
	 * Create a new client and add it to the database. Very simplified version
	 * of a client for now.
	 *
	 * TODO: Create a more sophisticated client class and associated database
	 * table for it.
	 */
	function edit_client() {
		$this->load->library('form_validation');

		if ($this->form_validation->run() == FALSE) {
			redirect('account/form_edit_client', 'refresh'); //redirect to the main application page
		} else {
			$this->load->model('client_model');

			$id = $this->input->post('id');

			$client = $this->client_model->get_from_id($id);
			$client->address = $this->input->post('address');

			$this->client_model->update_address($client);

			$this->session->set_flashdata('message',
				"The client " .
				$client->name .
				" has been updated!");
			redirect('main/index', 'refresh'); //redirect to the main application page
		}
	}

}

