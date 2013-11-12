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
				'end' => $booking->end_time,
				'resourceId' => intval($booking->roomid)
			);
		}

		echo json_encode($events);
	}

	function next($limit){
		//move the page to next set of rooms
		$limit = intval($limit) + 6;

		$data['title'] = 'Storefront Calendar';
		$data['main'] = 'main/body';
		$data['scripts'] = 'main/scripts';
		$data['styles'] = 'main/styles';
		$data['lower_limit'] = $limit;

		$this->load->view('template', $data);
	}

	function get_rooms($id){	
		$var = intval($id);
		
		for($i=$var; $i<$var+6; $i++){
			$rooms[] = array(
				'id' => $i,
				'name' => "room ". strval($i)
				);
		}
		echo json_encode($rooms);
	}

	function move_event() {
		$data = $this->input->get_post('json');
		$event = json_decode($data);

		$this->load->model('booking_model');

		$booking = $this->booking_model->get($event->id);
		$booking->move($event->day_delta, $event->minute_delta, $event->resourceId);

		$this->booking_model->update_date_time($booking);
		$this->booking_model-> updateRoom($booking);
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

		function form_edit_booking(){
		$this->load->model('booking_model');
		$this->load->model('client_model');
		$this->load->model('user_model');
		$this->load->model('room_model');

		$user =  $this->session->userdata('user'); 

		if ($user->usertype == 1){
			$data['booking_list'] =  $this->booking_model->get_bookings();
		} 
		else{
			$data['booking'] = $this->booking_model->getByUserID($user->clientid);
		}

		$data['rooms'] = $this->room_model->get_rooms();
		$data['clients'] = $this->client_model->get_clients();
		$data['booking'] = new Booking();
		$data['title'] = 'Storefront Calendar';
		$data['main'] = 'booking/edit_event';
		$data['styles'] = 'booking/styles';
		$data['scripts'] = 'booking/scripts';

		$this->load->view('template', $data);
	}

	function edit_booking(){

		$this->load->model('booking_model');
		$this->load->model('client_model');
		$this->load->model('room_model');


		$id = $this->input->post('id');
		$booking = $this->booking_model->get($id);

		$start = $this->input->post('from_date') . 't' . $this->input->post('from_time');
		$end = $this->input->post('to_date') . 't' . $this->input->post('to_time');

		$booking->set_times($start, $end);
		$booking->userid = $this->input->post('client');
		$booking->roomid = $this->input->post('room');
		$booking->status = $this->input->post('status');

		$this->booking_model->updateRoom($booking);
		$this->booking_model->update_date_time($booking);
		$this->booking_model->updateStatus($booking);

		$user =  $this->session->userdata('user'); 

		if ($user->usertype == 1){
			$data['booking_list'] =  $this->booking_model->get_bookings();
		} 
		else{
			$data['booking'] = $this->booking_model->getByUserID($user->clientid);
		}

		$data['rooms'] = $this->room_model->get_rooms();
		$data['clients'] = $this->client_model->get_clients();
		$data['booking'] = new Booking();
		$data['title'] = 'Storefront Calendar';
		$data['main'] = 'booking/edit_event';
		$data['styles'] = 'booking/styles';
		$data['scripts'] = 'booking/scripts';
		$data['message'] = $booking->title . " has been updated";

		$this->load->view('template', $data);

	}

	function delete_booking(){

		$this->load->model('booking_model');
		$this->load->model('client_model');
		$this->load->model('room_model');

		$user =  $this->session->userdata('user'); 

		if ($user->usertype == 1){
			$data['booking_list'] =  $this->booking_model->get_bookings();
		} 
		else{
			$data['booking'] = $this->booking_model->getByUserID($user->clientid);
		}


		$id = $this->input->post('id');
		$booking = $this->booking_model->get($id);

		$this->booking_model->deleteBooking($id);

		$data['rooms'] = $this->room_model->get_rooms();
		$data['clients'] = $this->client_model->get_clients();
		$data['booking'] = new Booking();
		$data['title'] = 'Storefront Calendar';
		$data['main'] = 'booking/edit_event';
		$data['styles'] = 'booking/styles';
		$data['scripts'] = 'booking/scripts';
		$data['message'] = $booking->title . " has been deleted";

		$this->load->view('template', $data);

	}


	function change_booking(){

		$this->load->model('booking_model');
		$this->load->model('client_model');
		$this->load->model('room_model');

		$id = $this->input->post('booking_id');
		$user =  $this->session->userdata('user'); 

		if ($user->usertype == 1){
			$data['booking_list'] =  $this->booking_model->get_bookings();
		} 
		else{
			$data['booking'] = $this->booking_model->getByUserID($user->clientid);
		}

		$data['rooms'] = $this->room_model->get_rooms();
		$data['clients'] = $this->client_model->get_clients();
		$data['booking'] = $this->booking_model->get($id);
		$data['title'] = 'Storefront Calendar';
		$data['main'] = 'booking/edit_event';
		$data['styles'] = 'booking/styles';
		$data['scripts'] = 'booking/scripts';

		$this->load->view('template', $data);

	}
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */
