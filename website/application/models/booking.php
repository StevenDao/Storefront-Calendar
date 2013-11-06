<?php

class Booking
{

	// Booking status types
	const CONFIRMED = 1;
	const TENTATIVE = 2;
	const REJECTED = 3;

	// Class members
	public $id;                         // Unique booking-id
	public $userid;                     // The user-id of this booking's user
	public $roomid;                     // The room-id of this booking's location
	public $title;                      // The title of the booking event.
	public $date_booked;                // Date that this booking was made
	public $start_time;                 // Start-time
	public $end_time;                   // End-time
	public $status = self::TENTATIVE;   // Booking status is tentative by default
	// Note that dates are stored as strings with the form: YYYY-MM-DD
	// This is the same format our MySQL DB uses.

	// Format a date into the DB's date format
	// Takes 3 integers: year, month, and day
	// Leading zeroes are not necessary in the arguments (so 2014, 4, 5 is OK) 
	// Returns a date string on success, false on fail
	// Failure occurs when the combination of year, month, day is invalid
	public function formatDate($year, $month, $day){
		$timestamp = mktime(0, 0, 0, $month, $day, $year);
		if ($timestamp == FALSE) {
			return FALSE;
		}
		return date("Y-m-d", $timestamp);
	}

	// Format a time into the DB's format
	// Takes 3 integers: hour, minute, and a selector (0 for AM, 1 for PM)
	// The hour should be specified for a 12-hour clock
	// Leading zeroes are not necessary in the arguments (so 2, 0, 0 is OK) 
	// Returns true on success, false on fail
	// Failure occurs when the combination of hour, minute, and selector is invalid
	// Returns a timestamp of the form: HH:MM:SS on success, in 24-hour format, or false on fail
	// Failure occurs when the combination of hour, minute, and selector is invalid
	public function formatTime($hour, $minute, $selector) {
		// Hour must be in the range of 1-12, inclusive
		if ($hour < 1  ||  $hour > 12) {
			return FALSE;
		}
		// Minute must be in the range of 0-59, inclusive
		if ($minute < 0  ||  $minute > 59) {
			return FALSE;
		}
		// Selector must be 0 (AM) or 1 (PM), nothing else
		switch ($selector) {
			case 0:
				break;
			case 1:
				$hour += 12;  // Switch to the 24-hour version
				break;
			default:
				return FALSE;
		}
		// Get a timestamp, format it, and return it
		$timestamp = mktime($hour, $minute, 0, 1, 1, 2001);
		if ($timestamp == FALSE) {
			return FALSE;
		}
		return date("H:i:s", $timestamp);
	}

	// Set the booking date (when the booking is made) to today
	// Returns the datestamp
	public function initBookDate() {
		$this->$bookdate = date("Y-m-d");
		return $this->$bookdate;
	}

	// Set the date that this booking is for
	public function setDate($year, $month, $day) {
		$date = formatDate($year, $month, $day);
		if ($date == FALSE) {
			return FALSE;
		}
		$this->$date = $date;
		return TRUE;
	}

	/*
	* Set the start-time of this booking
	*/
	function set_start_time($hour, $minute, $second = 0) {
		$start = new DateTime($this->start_time);
		$start->setTime($hour, $minute, $second);
		$this->start_time = $start->format('Y-m-d H:i:s');
	}

	/*
	* Set the end-time of this booking.
	*/
	function set_end_time($hour, $minute, $selector) {
		$end = new DateTime($this->end_time);
		$end->setTime($hour, $minute, $second);
		$this->end_time = $end->format('Y-m-d H:i:s');
	}

	/*
	 * Set the start and end of this booking when adding an event from the 
	 * calendar directly.
	 */
	function set_times($start, $end) {
		$start_utc = new DateTime($start, new DateTimeZone('UTC'));
		$end_utc = new DateTime($end, new DateTimeZone('UTC'));

		$start = $start_utc;
		$start->setTimeZone(new DateTimeZone('America/New_York'));
		$end = $end_utc;
		$end->setTimeZone(new DateTimeZone('America/New_York'));

		$this->start_time = $start->format('Y-m-d H:i:s');
		$this->end_time = $end->format('Y-m-d H:i:s');
	}

	function move($deltaDays, $deltaMinutes) {
		$arg = $deltaDays . ' days ' . $deltaMinutes . ' minutes';
		$interval = DateInterval::createFromDateString($arg);

		$date = new DateTime($this->start_time);
		$date->add($interval);
		$this->start_time = $date->format('Y-m-d H:i:s');

		$date = new DateTime($this->end_time);
		$date->add($interval);
		$this->end_time = $date->format('Y-m-d H:i:s');
	}

	function resize($deltaDays, $deltaMinutes) {
		$arg = $deltaDays . ' days ' . $deltaMinutes . ' minutes';
		$interval = DateInterval::createFromDateString($arg);

		$date = new DateTime($this->end_time);
		$date->add($interval);
		$this->end_time = $date->format('Y-m-d H:i:s');
	}

	// Confirm this booking
	// Always returns true, since this cannot fail
	public function confirm() {
		$this->status = self::CONFIRMED;
		return true;
	}

	// Reject this booking
	// Always returns true, since this cannot fail
	public function reject() {
		$this->status = self::REJECTED;
		return true;
	}

	// Make this booking tentative
	// Always returns true, since this cannot fail
	public function tentative() {
		$this->status = self::TENTATIVE;
		return true;
	}
}

/* End of file booking.php */
/* Location: ./application/models/booking.php */
