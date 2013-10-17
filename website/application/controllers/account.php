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

		$protected = array('updatePasswordForm','updatePassword','index','logout');

		if (in_array($method,$protected) && !isset($_SESSION['user']))
			redirect('account/loginForm', 'refresh'); //Then we redirect to the index page again

		return call_user_func_array(array($this, $method), $params);
	}

	function index() {
		$this->load->view('account/loginForm');
	}

	/*
	 * Loads the main login form view.
	 */
	function loginForm() {
		$this->load->view('account/loginForm');
	}

	/*
	 * Loads the main form for making a new user.
	 */
	function newForm() {
		$this->load->view('account/newForm');
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
				$data['user']=$user;

				redirect('main/index', 'refresh'); //redirect to the main application page
			} else {
				redirect('account/loginForm', 'refresh');
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
	function createNew() {
		$this->load->library('form_validation');

		$this->form_validation->set_rules('username', 'Username', 'required|is_unique[user.login]');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('first', 'First', "required");
		$this->form_validation->set_rules('last', 'last', "required");
		$this->form_validation->set_rules('email', 'Email', "required|is_unique[user.email]");
		$this->form_validation->set_rules('captcha', 'Captcha', "trim|required|callback__check_captcha");

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('account/newForm');
		} else {
			$user = new User();

			$user->login = $this->input->post('username');
			$user->first = $this->input->post('first');
			$user->last = $this->input->post('last');
			$clearPassword = $this->input->post('password');
			$user->encryptPassword($clearPassword);
			$user->email = $this->input->post('email');

			// Placeholder until actual client functionality is made
			$user->clientid = 1;

			$this->load->model('user_model');

			$this->user_model->insert($user);

			$this->load->view('account/loginForm');
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
				$config['smtp_user']    = 'google_username@gmail.com';
				$config['smtp_pass']    = 'google_password';
				$config['charset']    = 'utf-8';
				$config['newline']    = "\r\n";
				$config['mailtype'] = 'text'; // or html
				$config['validation'] = TRUE; // bool whether to validate email or not

				$this->email->initialize($config);

				$this->email->from('csc309Login@cs.toronto.edu', 'Login App');
				$this->email->to($user->email);

				$this->email->subject('Password recovery');
				$this->email->message("Your new password is $newPassword");

				$result = $this->email->send();

				//$data['errorMsg'] = $this->email->print_debugger();

				//$this->load->view('emailPage',$data);
				$this->load->view('account/emailPage');

			}
			else {
				$data['errorMsg']="No record exists for this email!";
				$this->load->view('account/recoverPasswordForm',$data);
			}
		}
	}
}

