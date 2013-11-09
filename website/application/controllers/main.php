<?php

class Main extends CI_Controller
{
	function __construct() {
		// Call the Controller constructor
		parent::__construct();
		$this->load->library('session');
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
		$booking->move($event->day_delta, $event->minute_delta);

		$this->booking_model->update_date_time($booking);
	}

	function resize_event() {
		$data = $this->input->get_post('json');
		$event = json_decode($data);

		$this->load->model('booking_model');

		$booking = $this->booking_model->get($event->id);
		$booking->resize($event->day_delta, $event->minute_delta);

		$this->booking_model->update_date_time($booking);
	}

	function add_event() {
		$data = $this->input->get_post('json');
		$event = json_decode($data);

		$this->load->model('booking_model');
		$this->load->model('user_model');

		$booking = new Booking();

		$user = $this->session->userdata('user');

		$booking->userid = $user->id;
		$booking->roomid = 1; // Placeholder
		$booking->title = $event->title;
		$booking->date_booked = date('d-m-Y');
		$booking->set_times($event->start, $event->end, TRUE);

		if ($event->allDay) {
			$booking->set_start_time(9, 0);
			$booking->set_end_time(18, 0);
		}

		$this->booking_model->insert($booking);
	}

	function form_add_booking() {
		$this->load->model('room_model');
		$this->load->model('client_model');

		$data['rooms'] = $this->room_model->get_rooms();
		$data['clients'] = $this->client_model->get_clients();

		$data['title'] = 'Storefront Calendar';
		$data['main'] = 'booking/add_booking';
		$data['styles'] = 'booking/styles';
		$data['scripts'] = 'booking/scripts';

		$this->load->view('template', $data);
	}

	function form_edit_booking() {
		$this->load->model('room_model');
		$this->load->model('client_model');

		$data['rooms'] = $this->room_model->get_rooms();
		$data['clients'] = $this->client_model->get_clients();

		$data['title'] = 'Storefront Calendar';
		$data['main'] = 'booking/add_booking';
		$data['styles'] = 'booking/styles';
		$data['scripts'] = 'booking/scripts';

		$this->load->view('template', $data);
	}

	function add_booking() {
		$this->load->model('booking_model');

		$booking = new Booking();
		$booking->init();

		if ($this->input->post('all_day') == TRUE) {
			$booking->set_start_time(9, 0);
			$booking->set_end_time(18, 0);
		} else {
			$start = $this->input->post('from_date') . 't' . $this->input->post('from_time');
			$end = $this->input->post('to_date') . 't' . $this->input->post('to_time');
			$booking->set_times($start, $end);
		}

		$booking->title = $this->input->post('title');
		$booking->description = $this->input->post('description');

		$booking->userid = $this->input->post('client');
		$booking->roomid = $this->input->post('room');
		$booking->status = $this->input->post('status');
		$booking->repeat = $this->input->post('repeat');
		$booking->repeat_feq = $this->input->post('repeat_freq');

		$this->booking_model->insert($booking);
		redirect('main/index', 'refresh');
	}
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */
