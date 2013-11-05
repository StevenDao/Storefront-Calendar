<?php

class Main extends CI_Controller
{
	function __construct() {
		// Call the Controller constructor
		parent::__construct();
		//session_start();
	}

	public function _remap($method, $params = array()) {
		// enforce access control to protected functions

		$user = $this->session->userdata('user');

		$protected = array('index');

		// Check if the user is logged in
		if (in_array($method,$protected) && !$user)
			redirect('account/index', 'refresh');

		return call_user_func_array(array($this, $method), $params);
	}

	function index() {
		// Check if a custom message was specified.
		$message = $this->session->flashdata('message');
		if (isset($message))
			$data['message'] = $message;

		$data['user'] = $this->session->userdata('user');

		$data['title'] = 'Storefront Calendar';
		$data['main'] = 'main/body';
		$data['scripts'] = 'main/scripts';
		$data['styles'] = 'main/styles';

		$this->load->view('template', $data);
	}

	function get_events() {
		$this->load->model('booking_model');
		$bookings = $this->booking_model->get_bookings();
		$events = array();

		foreach ($bookings as $booking) {
			$events[] = array(
				'id' => $booking->id,
				'title' => $booking->title,
				'start' => $booking->start_time,
				'end' => $booking->end_time
			);
		}

		echo json_encode($events);
	}

	function move_event() {
		$data = $this->input->get_post('json');
		$event = json_decode($data);

		$this->load->model('booking_model');

		$booking = $this->booking_model->get($event->id);
		$booking->move($event->dayDelta, $event->minuteDelta);

		$this->booking_model->updateDateTime($booking);
	}

	function resize_event() {
		$data = $this->input->get_post('json');
		$event = json_decode($data);

		$this->load->model('booking_model');

		$booking = $this->booking_model->get($event->id);
		$booking->resize($event->dayDelta, $event->minuteDelta);

		$this->booking_model->updateDateTime($booking);
	}
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */
