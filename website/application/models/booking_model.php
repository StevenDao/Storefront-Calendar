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
    
    // Get an array of booking objects by their status
    // $status should be "tentative", "confirmed", or "rejected"
	/*
    function getByUserID($status) {
        $code = 0;
        switch ($status) {
            case "tentative":
                $code = 2;
                break;
            case "confirmed":
                $code = 1;
                break;
            case "rejected":
                $code = 3;
                break;
            default:
                return null;
        }
        $this->db->where('status', $code);
        $query = $this->db->get('booking');
        if ($query && $query->num_rows() > 0)
            return $query->result('Booking');
        else
            return null;
    }
	 */
    
    // Insert a new booking into the 'booking' table
	function insert($booking) {
		$this->db->insert('booking', $booking);
		return ($this->db->affected_rows() != 1) ? false : true;
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
    function deleteBooking($id){
        $this->db->where('id', $id);
        $this->db->delete('booking');
    }

   function get_all_rooms() {
        $query = $this->db->select('*')->from('room')->get();
        return $query->result();
    }
}

/* End of file booking_model.php */
/* Location: ./application/models/booking_model.php */

