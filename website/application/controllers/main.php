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

		$client = array(
			'index',
			'get_events',
			'next',
			'get_rooms',
			'form_add_booking',
			'add_booking',
			'form_edit_booking',
			'edit_booking',
			'change_booking'
		);

		$admin = array(
			'move_event',
			'resize_event',
			'confirm_event',
			'add_event',
			'delete_booking',
		);

		/* Check if the user is logged in */
		if (in_array($method, array_merge($client, $admin)) && !$user) {
			redirect('account/index', 'refresh');
		} else if (in_array($method, $admin) && $user) {
			/* Check if the user is an admin */
			if ($user->usertype != User::ADMIN)
				redirect('main/index', 'refresh');
		}

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

			$str = "Room: " . $room->name . "<br />" .
                   "Booked from: " . $start . " to " . $end . "<br />" .
                   "Booked by: " . $client->agency . "<br />";
                   "Description: " . $booking->description;

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
			$room = $this->room_model->getFromId($i);
			$rooms[] = array(
				'id' => $i,
				'name' => $room->name
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

		if ($user->usertype == User::ADMIN || $user->usertype == User::FRONTDESK) {
			$data['clients'] = $this->client_model->get_clients();
		} else if ($user->usertype == User::CLIENT) {
			$client = $this->client_model->get_from_id($user->clientid);
			$clients = array($client->id => $client->agency);
			$data['clients'] = $clients;
		} else {
			$data['clients'] = array();
		}

		$data['rooms'] = $this->room_model->get_rooms();
		$data['title'] = 'Storefront Calendar';
		$data['main'] = 'booking/add_booking';
		$data['styles'] = 'booking/styles';
		$data['scripts'] = 'booking/scripts';

		$this->load->view('template', $data);
	}



    // If the from-date is before today's date, it is invalid
    public function validate_from_date($from_date){
        
        return FALSE;
        /*
        $from_val = ( substr($from_date, 0, 4) * 10000 ) +
                    ( substr($from_date, 5, 2) * 100   ) +
                      substr($from_date, 8, 2);
        
        $today = date_format(new DateTime(), 'Y-m-d');
        $today_val = ( substr($today, 0, 4) * 10000 ) +
                     ( substr($today, 5, 2) * 100   ) +
                       substr($today, 8, 2);
        
        if ($from_val < $today_val) {
            $this->form_validation->set_message('validate_from_date',
            'The \'From\' date cannot be before today\'s date.');
			return FALSE;
		} else {
            return TRUE;
		}*/
        
    }
    
    // If the to-date is before the from-date, it is invalid
    public function validate_to_date($to_date, $from_date){
        
        $from_val = ( substr($from_date, 0, 4) * 10000 ) +
                    ( substr($from_date, 5, 2) * 100   ) +
                      substr($from_date, 8, 2);
        
        $to_val = ( substr($to_date, 0, 4) * 10000 ) +
                  ( substr($to_date, 5, 2) * 100   ) +
                    substr($to_date, 8, 2);
        
        if ($to_val < $from_val) {
			$this->form_validation->set_message('validate_to_date',
            'The \'To\' date cannot be before the \'From\' date.');
			return FALSE;
		} else {
            return TRUE;
		}
        
    }
    
    // If from-date = to-date, and the from-time > to-time, to-time is invalid
    public function validate_to_time($to_time, $from_date, $to_date, $from_time){
        
        $from_val = ( substr($from_date, 0, 4) * 10000 ) +
                    ( substr($from_date, 5, 2) * 100   ) +
                      substr($from_date, 8, 2);
        
        $to_val = ( substr($to_date, 0, 4) * 10000 ) +
                  ( substr($to_date, 5, 2) * 100   ) +
                    substr($to_date, 8, 2);
        
        if( $from_val == $to_val ){
            
            $from_t = ( substr($from_time, 0, 2) * 100 ) + substr($from_time, 3, 2);
            $to_t   = ( substr($to_time,   0, 2) * 100 ) + substr($to_time,   3, 2);
            
            if ($from_t >= $to_t) {
                $this->form_validation->set_message('validate_to_time',
                'The \'To\' time cannot be before the \'From\' time for same-day events.');
                return FALSE;
            }
            
        }
        
        return TRUE;
        
    }
    
    
    /**
     * Validates a set of booking details, as submitted to the add_booking()
     * controller function (main controller). Note that the all_day, room,
     * client, and status properties of a booking are set up in our forms so
     * that they will always have valid values, so they are not checked here.
     * The description field may be blank, or anything, so that isn't checked
     * either.
     * 
     * Returns 0 on successful validation of details, or one of the following:
     * 2 = The 'from' date is after the 'to' date
     * 3 = The 'from' date is before today's date
     * 4 = The 'from' time of a same-day event occurs at or after its 'to' time
     * 5 = A repeating event has a non-integer frequency
     * 6 = A repeating event has a frequency that is less than 1 day
     * 7 = A repeating event has an end-date that is before its from-date
     *
    function validate_booking_details
        ( $title, $from_date, $to_date, $from_time, $to_time,
          $repeat, $repeat_freq, $repeat_end ){
        
        
        // If the event is repeating...
        if ($repeat == 1) {
            
            
            // ... and doesn't have a frequency of at least 1 day, return error code 6
            if ($repeat_freq < 1) {
                return 6;
            }
            // ... and has an end-date before the the original event, return error code 7
            $end = ( substr($repeat_end, 0, 4) * 10000 ) +
                   ( substr($repeat_end, 5, 2) * 100   ) +
                     substr($repeat_end, 8, 2);
            if ($end < $from) {
                return 7;
            }
        }
        
        // If we got here, then there are no errors in the input, so return 0
        return 0;
        
    }*/
    

	function add_booking() {
        
        // Load model, helper, library
		$this->load->model('booking_model');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
        
        
        if ($this->form_validation->run() == FALSE) {

			$this->load->model('room_model');
			$this->load->model('client_model');

			$user = $this->session->userdata('user');

			if ($user->usertype != 2){ 
				$data['booking_list'] = $this->booking_model->get_bookings(); 
				$data['clients'] = $this->client_model->get_clients();
			} else {
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

		} else {

			// Get the input data from the POST data
			$title       = $this->input->post('title');
			$from_date   = $this->input->post('from_date');
			$from_time   = $this->input->post('from_time');
			$to_date     = $this->input->post('to_date');
			$to_time     = $this->input->post('to_time');
			$all_day     = $this->input->post('all_day');
			$repeat      = $this->input->post('repeat');
			$repeat_freq = $this->input->post('repeat_freq');
			$repeat_end  = $this->input->post('repeat_end');
			$description = $this->input->post('description');
			$client      = $this->input->post('client');
			$room        = $this->input->post('room');
			$status      = $this->input->post('status');

			// All day events default to same-day events running from 9-7
			if ($all_day == TRUE) {
				$to_date = $from_date;
				$from_time = '09:00:00';
				$to_time = '19:00:00';
			}

			// Handle repeating events
			if ($repeat == 'repeat') {
				$repeat = 1;
			} else {
				$repeat = 0;
				$repeat_freq = 0;
				$repeat_end = NULL;
			}

			// Add the event

			// Create a new Booking object
			$booking = new Booking();
			$booking->init();

			// Set the relevant properties in the Booking object
			$start = $from_date . 't' . $from_time;
			$end = $to_date . 't' . $to_time;
			$booking->set_times($start, $end);

			$booking->title = $title;
			$booking->description = $description;
			$booking->userid = $client;
			$booking->roomid = $room;
			$booking->status = $status;
			$booking->repeat = $repeat;
			$booking->repeat_freq = $repeat_freq;
			$booking->repeat_end = $repeat_end;

			$booking->date_booked = date_format(new DateTime(), 'Y-m-d');

			$this->booking_model->insert($booking);

			// Redirect to the main application page
			redirect('main/index', 'refresh');

		}

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
        
        // Get the input data from the POST data
        $title       = $this->input->post('title');
        $from_date   = $this->input->post('from_date');
        $from_time   = $this->input->post('from_time');
        $to_date     = $this->input->post('to_date');
        $to_time     = $this->input->post('to_time');
        $all_day     = $this->input->post('all_day');
        $repeat      = $this->input->post('repeat');
        $repeat_freq = $this->input->post('repeat_freq');
        $repeat_end  = $this->input->post('repeat_end');
        $description = $this->input->post('description');
        $client      = $this->input->post('client');
        $room        = $this->input->post('room');
        $status      = $this->input->post('status');
        
        // All day events default to same-day events running from 9-7
        if ($all_day == TRUE) {
            $to_date = $from_date;
            $from_time = '09:00:00';
            $to_time = '19:00:00';
        }
        
        // Handle repeating events
        if ($repeat == 'repeat') {
            $repeat = 1;
		} else {
		    $repeat = 0;
		    $repeat_freq = 0;
            $repeat_end = NULL;
		}
        
        // Load the booking model
		$this->load->model('booking_model');
		
        // Validate any data that needs to be validated
        // This function was removed. This will also be removed soon in favour
        // of proper form validation.
        $errno = 0;
        
        if ($errno != 0 ) {
            
            // Load the input_error view
            $data['title'] = 'Invalid form input';
            $data['errno'] = $errno;
            $this->load->view('invalid_input', $data);
            
        } else {
            
            // Get the booking record from the table
		    $booking = $this->booking_model->get($id);
            
            // Set the start and end times
            $start = $from_date . 't' . $from_time;
		    $end = $to_date . 't' . $to_time;
		    $booking->set_times($start, $end);
            
            // Set more data
            $booking->description = $description;
		    $booking->userid = $client;
		    $booking->roomid = $room;
		    $booking->status = $status;
		    $booking->repeat = $repeat;
		    $booking->repeat_freq = $repeat_freq;
		    $booking->repeat_end = $repeat_end;
		    
            // Update fields
            $this->booking_model->updateRoom($booking);
		    $this->booking_model->update_date_time($booking);
		    $this->booking_model->updateStatus($booking);
		    $this->booking_model->update_client($booking);
		    $this->booking_model->update_freq($booking);
		    $this->booking_model->update_description($booking);
            
            // Load the client and room models
            $this->load->model('client_model');
		    $this->load->model('room_model');
            
            $user =  $this->session->userdata('user'); 
            
			if ($user->usertype == User::ADMIN || $user->usertype == User::FRONTDESK) {
				$data['booking_list'] = $this->booking_model->get_bookings();
				$data['clients'] = $this->client_model->get_clients();
			} else if ($user->usertype == User::CLIENT) {
				$data['booking_list'] = $this->booking_model->getByUserID($user->clientid);
				$client = $this->client_model->get_from_id($user->clientid);
				$clients = array($client->id => $client->agency);
				$data['clients'] = $clients;
			}

            // Call the view
		    $data['rooms'] = $this->room_model->get_rooms();
		    $data['booking'] = new Booking();
		    $data['title'] = 'Storefront Calendar';
		    $data['main'] = 'booking/edit_event';
		    $data['styles'] = 'booking/styles';
		    $data['scripts'] = 'booking/scripts';
		    $data['message'] = $booking->title . " has been updated";
            
		    $this->load->view('template', $data);

	    }
	    
	}

	function delete_booking(){

		$this->load->model('booking_model');
		$this->load->model('client_model');
		$this->load->model('room_model');

		$user =  $this->session->userdata('user'); 

		$id = $this->input->post('id');
		$booking = $this->booking_model->get($id);

		$this->booking_model->delete($id);

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

		if ($user->usertype == User::ADMIN || $user->usertype == User::FRONTDESK) {
				$data['booking_list'] = $this->booking_model->get_bookings();
				$data['clients'] = $this->client_model->get_clients();
		} else if ($user->usertype == User::CLIENT) {
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
