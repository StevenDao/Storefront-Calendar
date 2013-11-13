<?php

class Booking
{
	// Booking status types
	const TENTATIVE = 0;
	const CONFIRMED = 1;
	const REJECTED = 2;

	// Class members
	public $id;                         // Unique booking-id
	public $userid;                     // The user-id of this booking's user
	public $roomid;                     // The room-id of this booking's location
	public $title;                      // The title of the booking event.
	public $description;
	public $date_booked;                // Date that this booking was made
	public $start_time;                 // Start datetime
	public $end_time;                   // End datetime
	public $status = self::TENTATIVE;   // Booking status is tentative by default
	public $repeat =0;
	public $repeat_freq = 0;
	public $repeat_end=NULL;

	// NOTE: dates are in the format YYYY-MM-DD
	// NOTE: datetimes are in the format YYYY-MM-DD HH:MM:SS
	// TODO: Globalize the format of the date/time so it's consistent and easy
	// to maintain.

	/*
	 * Format a date into the database's date format.
	 *
	 * Takes 3 integers: year, month, and day and returns a date string. Will
	 * fail if the year-month-day combination is invalid as per the mktime
	 * function.
	 *
	 * @param year:integer
	 * @param month:integer
	 * @param day:integer
	 */
	function format_date($year, $month, $day){
		$time = new DateTime("$year-$month-$day");
		return $time->format('Y-m-d');
	}

	// Format a time into the DB's format
	// Takes 3 integers: hour, minute, and a selector (0 for AM, 1 for PM)
	// The hour should be specified for a 12-hour clock
	// Leading zeroes are not necessary in the arguments (so 2, 0, 0 is OK) 
	// Returns true on success, false on fail
	// Failure occurs when the combination of hour, minute, and selector is invalid
	// Returns a timestamp of the form: HH:MM:SS on success, in 24-hour format, or false on fail
	// Failure occurs when the combination of hour, minute, and selector is invalid
	function format_time($hour, $minute) {
		$time = new DateTime("t $hour:$minute:00");
		return $time->format('H:i:s');
	}

	function format_datetime(DateTime $time) {
		return $time->format('Y-m-d H:i:s');
	}
    
    
    /**
     * Validates a set of booking details, as submitted to the add_booking()
     * controller function (main controller). Note that the all_day, room,
     * client, and status properties of a booking are set up in our forms so
     * that they will always have valid values, so they are not checked here.
     * 
     * Returns 0 on successful validation of details, or one of the following:
     * 1 = The 'title' field is blank
     * 2 = The 'from' date is after the 'to' date
     * 3 = The 'from' date is before today's date
     * 4 = The 'from' time of a same-day event occurs at or after its 'to' time
     * 5 = A repeating event has a non-integer frequency
     * 6 = A repeating event has a frequency that is less than 1 day
     * 7 = A repeating event has an end-date that is before its from-date
     * 8 = The 'description' field is blank
     */
    functon validate_booking_details
        ( $title, $from_date, $to_date, $from_time, $to_time,
          $repeat, $repeat_freq, $repeat_end, $description ){
        
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
            // ... and doesn't have an integer frequency, return error code 5
            if ( !is_int($repeat_freq) ? (ctype_digit($repeat_freq)) : true ) {
                return 5;
            }
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
        
        // If the description field is blank, return error code 8
        if ($description == '') {
            return 8;
        }
        
        // If we got here, then there are no errors in the input, so return 0
        return 0;
        
    }
    
    
    
    

	/*
	 * Set the initial booking date (today).
	 */
	function init() {
		$this->date_booked = date('Y-m-d');
	}

	function get_start_date() {
		$start = new DateTime($this->start_time);
		return $start->format('Y-m-d');
	}

	/*
	 * Set the start date of the booking.
	 */
	function set_start_date($year, $month, $day) {
		$start = new DateTime($this->start_time);
		$start->setDate($year, $month, $day);

		$this->start_time = $this->format_datetime($start);
	}

	/*
	 * Set the end date of the booking.
	 */
	function set_end_date($year, $month, $day) {
		$end = new DateTime($this->end_time);
		$end->setDate($year, $month, $day);

		$this->end_time = $this->format_datetime($end);
	}

	/*
	 * Set the start-time of this booking
	 */
	function set_start_time($hour, $minute, $second = 0) {
		$start = new DateTime($this->start_time);
		$start->setTime($hour, $minute, $second);

		$this->start_time = $this->format_datetime($start);
	}

	/*
	 * Set the end-time of this booking.
	 */
	function set_end_time($hour, $minute, $selector) {
		$end = new DateTime($this->end_time);
		$end->setTime($hour, $minute, $second);

		$this->end_time = $this->format_datetime($end);
	}

	/*
	 * Set the start and end of this booking when adding an event from the
	 * calendar directly.
	 */
	function set_times($start, $end, $utc = FALSE) {
		if ($utc) {
			$start = new DateTime($start, new DateTimeZone('UTC'));
			$end = new DateTime($end, new DateTimeZone('UTC'));

			$start->setTimeZone(new DateTimeZone('America/New_York'));
			$end->setTimeZone(new DateTimeZone('America/New_York'));
		} else {
			$start = new DateTime($start);
			$end = new DateTime($end);
		}

		$this->start_time = $this->format_datetime($start);
		$this->end_time = $this->format_datetime($end);
	}

	/*
	 * Moves this booking.
	 *
	 * Uses that change in days and minutes as indicators for where to move the
	 * booking. delta_days indicates the days moved and delta_minutes indicates
	 * the minutes moved.
	 *
	 * @param delta_days: integer
	 * @param delta_minutes: integer
	 */
	function move($delta_days, $delta_minutes, $room_id) {
		// Use the createFromDateString function in order to gracefully handle
		// negative days and minutes.
		$arg = $delta_days . ' days ' . $delta_minutes . ' minutes';
		$interval = DateInterval::createFromDateString($arg);

		$date = new DateTime($this->start_time);
		$date->add($interval);
		$this->start_time = $this->format_datetime($date);

		$date = new DateTime($this->end_time);
		$date->add($interval);
		$this->end_time = $this->format_datetime($date);

		$this->roomid = $room_id;

	}

	/*
	 * Resizes this booking.
	 *
	 * Uses the change in days and minutes as indicators of how much to shift
	 * the end time of this booking.
	 *
	 * @param delta_days: integer
	 * @param delta_minutes: integer
	 */
	function resize($delta_days, $delta_minutes) {
		$arg = $delta_days . ' days ' . $delta_minutes . ' minutes';
		$interval = DateInterval::createFromDateString($arg);

		$date = new DateTime($this->end_time);
		$date->add($interval);
		$this->end_time = $this->format_datetime($date);
	}

	/*
	 * TODO: Recurring event function
	 */
}

/* End of file booking.php */
/* Location: ./application/models/booking.php */
