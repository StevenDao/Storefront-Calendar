<?php
class Booking_model extends CI_Model
{
	// Get a booking object by id
	function get($id) {
		$this->db->where('id', $id);
		$query = $this->db->get('booking');
		if ($query && $query->num_rows() > 0)
			return $query->row(0, 'Booking');
		else
			return null;
	}

	// Get an array of booking objects by userid
	function getByUserID($userid) {
		$this->db->where('userid', $userid);
		$query = $this->db->get('booking');
		if ($query && $query->num_rows() > 0)
			return $query->result('Booking');
		else
			return null;
	}

	// Get an array of booking objects by roomid
	function getByRoomID($roomid) {
		$this->db->where('roomid', $roomid);
		$query = $this->db->get('booking');
		if ($query && $query->num_rows() > 0)
			return $query->result('Booking');
		else
			return null;
	}

	// Get an array of booking objects by the day on which they were made
	function getByDateBooked($year, $month, $day) {
		//$date = Booking->formatDate($year, $month, $day);
		if ($date == FALSE) {
			return null;
		}
		$this->db->where('date_booked', $date);
		$query = $this->db->get('booking');
		if ($query && $query->num_rows() > 0)
			return $query->result('Booking');
		else
			return null;
	}

	// Get an array of booking objects by their target date
	function getByDate($year, $month, $day) {
		//$date = Booking->formatDate($year, $month, $day);
		if ($date == FALSE) {
			return null;
		}
		$this->db->where('date', $date);
		$query = $this->db->get('booking');
		if ($query && $query->num_rows() > 0)
			return $query->result('Booking');
		else
			return null;
	}

	// Insert a new booking into the 'booking' table
	function insert($booking) {
		return $this->db->insert('booking', $booking);
		//return ($this->db->affected_rows() != 1);
	}

	function update_freq($booking) {
		$this->db->where('id', $booking->id);
		return $this->db->update('booking', array('repeat'=>$booking->repeat,
							'repeat_freq' => $booking->repeat_freq,
							'repeat_end' => $booking->repeat_end));
	}


	// Update the roomid
	function updateRoom($booking) {
		$this->db->where('id', $booking->id);
		return $this->db->update('booking', array('roomid'=>$booking->roomid));
	}

	// Update the booked-on date
	function updateBookedOnDate($booking) {
		$this->db->where('id', $booking->id);
		return $this->db->update('booking', array('date_booked'=>$booking->bookdate));
	}

	// Update the date, start time, and end time
	function update_date_time($booking) {
		$this->db->where('id', $booking->id);
		return $this->db->update('booking', array('start_time'=>$booking->start_time,
			'end_time'=>$booking->end_time));
	}

	// Update the status
	function updateStatus($booking) {
		$this->db->where('id', $booking->id);
		return $this->db->update('booking', array('status'=>$booking->status));
	}
	// update
	function update_client($booking) {
		$this->db->where('id', $booking->id);
		return $this->db->update('booking', array('userid'=>$booking->userid));
	}

	// Exclusive lookup of a booking by ID
	function getExclusive($id) {
		$sql = "select * from booking where id=? for update";
		$query = $this->db->query($sql, array($id));
		if ($query && $query->num_rows() > 0)
			return $query->row(0,'Booking');
		else
			return null;
	}

	// Show bookings
	function get_bookings() {
		$bookings = array();
		$query = $this->db->query("SELECT * FROM booking;");

		foreach ($query->result('Booking') as $row) {
			$bookings[$row->id] = $row;
		}

		return $bookings;
	}

	// Delete a booking based on ID
	function delete($id){
		$this->db->where('id', $id);
		$this->db->delete('booking');
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
     * 1 = The 'title' field is blank
     * 2 = The 'from' date is after the 'to' date
     * 3 = The 'from' date is before today's date
     * 4 = The 'from' time of a same-day event occurs at or after its 'to' time
     * 5 = A repeating event has a non-integer frequency
     * 6 = A repeating event has a frequency that is less than 1 day
     * 7 = A repeating event has an end-date that is before its from-date
     */
    function validate_booking_details
        ( $title, $from_date, $to_date, $from_time, $to_time,
          $repeat, $repeat_freq, $repeat_end ){
        
        // If the title field is empty, return error code 1
        if ($title == '') {
            return 1;
        }
        
        // If the from-date is after the to-date, return error code 2
        $from = ( substr($from_date, 0, 4) * 10000 ) +
                ( substr($from_date, 5, 2) * 100   ) +
                  substr($from_date, 8, 2);
        $to = ( substr($to_date, 0, 4) * 10000 ) +
              ( substr($to_date, 5, 2) * 100   ) +
                substr($to_date, 8, 2);
        if ($from > $to) {
            return 2;
        }
        
        // If the from-date is before today's date, return error code 3
        $today = date_format(new DateTime(), 'Y-m-d');
        $today = ( substr($today, 0, 4) * 10000 ) +
                 ( substr($today, 5, 2) * 100   ) +
                   substr($today, 8, 2);
        if ($from < $today) {
            return 3;
        }
        
        // If the event is same-day, and the from-time is after the to-time, return error code 4
        if ($from == $to) {
            $from_t = ( substr($from_time, 0, 2) * 100 ) + substr($from_time, 3, 2);
            $to_t   = ( substr($to_time,   0, 2) * 100 ) + substr($to_time,   3, 2);
            if ($from_t >= $to_t) {
                return 4;
            }
        }
        
        // If the event is repeating...
        if ($repeat == 1) {
            
            /** Deprecated, since this is checked by the form itself **/
            /*
            // ... and doesn't have an integer frequency, return error code 5
            if ( !is_int($repeat_freq) ? (ctype_digit($repeat_freq)) : true ) {
                return 5;
            }*/
            
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
        
    }
    
    
    
    
    
    
}

/* End of file booking_model.php */
/* Location: ./application/models/booking_model.php */
