<?php

class Main extends CI_Controller
{
	function __construct() {
		// Call the Controller constructor
		parent::__construct();
		session_start();
	}

	public function _remap($method, $params = array()) {
		// enforce access control to protected functions

		$protected = array('index');
		$admin = array('');

		// Check if the user is logged in
		if (in_array($method,$protected) && !isset($_SESSION['user']))
			redirect('account/index', 'refresh');

		// Check if the user is an admin
		if (in_array($method,$admin) && !($_SESSION['user']->usertype == User::ADMIN))
			redirect('main/index', 'refresh');

		return call_user_func_array(array($this, $method), $params);
	}

	function index() {
		// Check if a custom message was specified.
		$message = $this->session->flashdata('message');
		if (isset($message))
			$data['message'] = $message;

		$data['user'] = $_SESSION['user'];
		$this->load->view('main', $data);
	}
}
?>
