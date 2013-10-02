<?php

class User
{
	public $id;
	public $login;
	public $first;
	public $last;
	public $password;   // hashed version
	public $salt;
	public $email;

	public function encryptPassword($clearPassword) {
		$this->salt = mt_rand();
		$this->password = sha1($this->salt . $clearPassword);
	}

	// Initializes the password to a random value
	public function initPassword() {
		$this->salt = mt_rand();
		$clearPassword = mt_rand();
		$this->password = sha1($this->salt . $clearPassword);
		return $clearPassword;
	}

	public function comparePassword($clearPassword) {
		if ($this->password == sha1($this->salt . $clearPassword))
			return true;
		return false;
	}

	public function fullName() {
		return $this->first . " " . $this->last;
	}

}
