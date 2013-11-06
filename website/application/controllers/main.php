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
		$booking->set_times($event->start, $event->end);

		if ($event->allDay) {
			$booking->set_start_time(9, 0);
			$booking->set_end_time(18, 0);
		}

		$this->booking_model->insert($booking);

		//error_log(json_encode($booking, JSON_PRETTY_PRINT));
	}

    /*
     * Thurai edit
     */
    function form_add_event() {
        $message = $this->session->flashdata('message');
        $this->load->model('user_model');
        $this->load->model('booking_model');
        
        $user = $this->session->userdata('user');
        $type = $user->usertype;
        
        if($user->usertype == 1):
            $book_as = $this->user_model->display_all_users();
        else:
            $book_as = $user;
        endif;
        
        if (isset($message))
            $data['message'] = $message;

        $data['title'] = 'Storefront Calendar';
        $data['main'] = 'booking/add_event';
        $data['styles'] = 'booking/styles';
        $data['type'] = $type;
        $data['book_as'] = $book_as;
        $data['rooms'] = $this->booking_model->get_all_rooms();

        $this->load->view('template', $data);
    }


    function detailed_add_event() {

        $this->load->model('booking_model');
        $this->load->model('user_model');
        
        $booking = new Booking();


        $start_date = $this->input->post('start_date');
        $start_hour = $this->input->post('start_hour');
        $start_minute = $this->input->post('start_minute');

        $end_date = $this->input->post('finish_date');
        $end_hour = $this->input->post('finish_hour');
        $end_minute = $this->input->post('finish_minute');

        $start = $start_date . " " . $start_hour . ":" . $start_minute . ":00";
        $end = $end_date . " " . $end_hour . ":" . $end_minute . ":00";



        $booking->userid = $this->input->post('userid');
        $booking->roomid = $this->input->post('room_id');
        $booking->title = $this->input->post('title');
        $booking->date_booked = date('d-m-Y');
        $booking->set_times($start, $end);

        $this->booking_model->insert($booking);
        redirect('main/index', 'refresh');
        
        
    }

}

/* End of file main.php */
/* Location: ./application/controllers/main.php */
