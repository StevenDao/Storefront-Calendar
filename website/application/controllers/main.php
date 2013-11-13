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
		$this->load->model('client_model');
		$this->load->model('room_model');

		$bookings = $this->booking_model->get_bookings();
		$events = array();
		$color = array('0' => 'blue' , '1' => 'green', '2' => 'red' );

		foreach ($bookings as $booking) {
			$client = $this->client_model->get_from_id($booking->userid);
			$room = $this->room_model->getFromId($booking->roomid);

			$date = new DateTime("$booking->start_time");
			$start = $date->format('h:ia');
			$date = new DateTime("$booking->end_time");
			$end = $date->format('h:ia');

			$str = "Booked by :" . "$client->agency" . "<br>" . "Initialy, booked $room->name" .  " from ". "$start to  $end" ."<br>" ."$booking->description";

			if ($booking->repeat == 1) {
				$repeat = true;
				$repeat_end = new DateTime($booking->repeat_end);

				while ($repeat) {
					$events[] = array(
						'id' => $booking->id,
						'title' => $booking->title,
						'start' => $booking->start_time,
						'color' => $color[$booking->status],
						'end' => $booking->end_time,
						'resourceId' => intval($booking->roomid),
						'description' => "$str"
					);

					$booking->move($booking->repeat_freq, 0, $booking->roomid);
					$start = new DateTime($booking->get_start_date());

					if ($start < $repeat_end) {
						$repeat = true;
					} else {
						$repeat = false;
					}
				}
			} else {
				$events[] = array(
					'id' => $booking->id,
					'title' => $booking->title,
					'start' => $booking->start_time,
					'end' => $booking->end_time,
					'color' => $color[$booking->status],
					'resourceId' => intval($booking->roomid),
					'description' => "$str"
				);
			}
		}

		echo json_encode($events);
	}

	function next($limit){
		//move the page to next set of rooms
		$limit = intval($limit) + 6;

		$data['go_date'] = $this->input->post('date');
		$data['title'] = 'Storefront Calendar';
		$data['main'] = 'main/body';
		$data['scripts'] = 'main/scripts';
		$data['styles'] = 'main/styles';
		$data['lower_limit'] = $limit;

		$this->load->view('template', $data);
	}

	function get_rooms($id){
		$var = intval($id);
		$this->load->model('room_model');
		
		for($i=$var; $i<$var+7; $i++){
			$name = $this->room_model->getFromId($i);
			$rooms[] = array(
				'id' => $i,
				'name' => $name
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

	function confirm_event(){
		$data = $this->input->get_post('json');
		$event = json_decode($data);

		$this->load->model('booking_model');
		$booking = $this->booking_model->get($event->id);

		$user = $this->session->userdata('user');
		
		if ($user->usertype == 1){
			$booking->status = 1;
			$this->booking_model->updateStatus($booking);
		}

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
		$this->load->model('booking_model');
		
		$user = $this->session->userdata('user');
		
		if ($user->usertype != 2){ 
				$data['booking_list'] = $this->booking_model->get_bookings(); 
				$data['clients'] = $this->client_model->get_clients();
		}else{
				$data['booking_list'] = $this->booking_model->getByUserID($user->clientid); 
				$client = $this->client_model->get_from_id($user->clientid); 
				$clients = array($client->id => $client->agency ); 
				$data['clients'] = $clients;
		}

		$data['rooms'] = $this->room_model->get_rooms();
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
		$repeat = $this->input->post('repeat');

		if ($repeat == 'repeat') {
			$booking->repeat = 1;
			$booking->repeat_freq = $this->input->post('repeat_freq');
			$booking->repeat_end = $this->input->post('repeat_end');
		}

		$this->booking_model->insert($booking);
		
		redirect('main/index', 'refresh');
	}

	function form_edit_booking(){ 
		$this->load->model('booking_model'); 
		$this->load->model('client_model'); 
		$this->load->model('user_model'); 
		$this->load->model('room_model');

		$user = $this->session->userdata('user');

		if ($user->usertype != 2){ 
			$data['booking_list'] = $this->booking_model->get_bookings(); 
			$data['clients'] = $this->client_model->get_clients(); 
		} 
		else{ 
			$data['booking_list'] = $this->booking_model->getByUserID($user->clientid); 
			$client = $this->client_model->get_from_id($user->clientid); 
			$clients = array($client->id => $client->agency ); 
			$data['clients'] = $clients; 
		}

			$data['rooms'] = $this->room_model->get_rooms(); 
			$data['booking'] = new Booking(); 
			$data['title'] = 'Storefront Calendar'; 
			$data['main'] = 'booking/edit_event'; 			
			$data['styles'] = 'booking/styles';
			$data['scripts'] = 'booking/scripts';

			$this->load->view('template', $data); 
	}

	function edit_booking($id){

		$this->load->model('booking_model');
		$this->load->model('client_model');
		$this->load->model('room_model');

		
		$booking = $this->booking_model->get($id);

		if ($this->input->post('all_day') == TRUE) {
			$booking->set_start_time(9, 0);
			$booking->set_end_time(18, 0);
		} else {
			$start = $this->input->post('from_date') . 't' . $this->input->post('from_time');
			$end = $this->input->post('to_date') . 't' . $this->input->post('to_time');
			$booking->set_times($start, $end);
		}

		$booking->description = $this->input->post('description');
		$booking->userid = $this->input->post('client');
		$booking->roomid = $this->input->post('room');
		$booking->status = $this->input->post('status');
		$repeat = $this->input->post('repeat');

		if ($repeat == 'repeat') {
			$booking->repeat = 1;
			$booking->repeat_freq = $this->input->post('repeat_freq');
			$booking->repeat_end = $this->input->post('repeat_end');
		}
		else{
			$booking->repeat = 0;
			$booking->repeat_freq = 0;
			$booking->repeat_end = NULL;
		}

		$this->booking_model->updateRoom($booking);
		$this->booking_model->update_date_time($booking);
		$this->booking_model->updateStatus($booking);
		$this->booking_model->update_client($booking);
		$this->booking_model->update_freq($booking);

		$user =  $this->session->userdata('user'); 

		if ($user->usertype != 2){ 
				$data['booking_list'] = $this->booking_model->get_bookings(); 
				$data['clients'] = $this->client_model->get_clients();
		}else{
				$data['booking_list'] = $this->booking_model->getByUserID($user->clientid); 
				$client = $this->client_model->get_from_id($user->clientid); 
				$clients = array($client->id => $client->agency ); 
				$data['clients'] = $clients;
		}

		$data['rooms'] = $this->room_model->get_rooms();
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

		if ($user->usertype != 2){ 
				$data['booking_list'] = $this->booking_model->get_bookings(); 
				$data['clients'] = $this->client_model->get_clients();
		}else{
				$data['booking_list'] = $this->booking_model->getByUserID($user->clientid); 
				$client = $this->client_model->get_from_id($user->clientid); 
				$clients = array($client->id => $client->agency ); 
				$data['clients'] = $clients;
		}


		$id = $this->input->post('id');
		$booking = $this->booking_model->get($id);

		$this->booking_model->delete($id);

		$data['rooms'] = $this->room_model->get_rooms();
		$data['booking'] = new Booking();
		$data['title'] = 'Storefront Calendar';
		$data['main'] = 'booking/edit_event';
		$data['styles'] = 'booking/styles';
		$data['scripts'] = 'booking/scripts';
		$data['message'] = $booking->title . " has been deleted";

		$this->load->view('template', $data);

	}

	function change_booking($id=""){

		$this->load->model('booking_model');
		$this->load->model('client_model');
		$this->load->model('room_model');

		if($id == ""){
			$id = $this->input->post('booking_id');
		}

		$user =  $this->session->userdata('user'); 

		if ($user->usertype != 2){ 
				$data['booking_list'] = $this->booking_model->get_bookings(); 
				$data['clients'] = $this->client_model->get_clients();
		}else{
				$data['booking_list'] = $this->booking_model->getByUserID($user->clientid); 
				$client = $this->client_model->get_from_id($user->clientid); 
				$clients = array($client->id => $client->agency ); 
				$data['clients'] = $clients;
		}

		$data['rooms'] = $this->room_model->get_rooms();
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
