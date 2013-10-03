<?php

class Main extends CI_Controller
{
	function __construct() {
		// Call the Controller constructor
		parent::__construct();
		session_start();
	}

	function index() {
		$data['user'] = $_SESSION['user'];
		$this->load->view('main', $data);
	}
}
?>
