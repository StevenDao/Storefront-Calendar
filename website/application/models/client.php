<?php

/*
 * The phone number will be in the format x{11,} (11+ numbers). Have utility 
 * functions that can format to
 *   +1 (800) 416 5555
 *   +1 (800) 416-5555
 *
 * TODO: format phone function, format address function, etc...
 */
class Client
{
	public $id;
	public $name;
	public $partnername;
	public $programname;
	public $manager;
	public $managerposition;
	public $programfc;
	public $fcposition;
	public $address;
	public $phone;
	public $fax;
	public $email;
	public $agreement;
	public $insurance;
	public $salt;
	public $password;
	

    // Encrypt a clear-text password by hashing it with SHA-512 and a salt
    public function encryptPassword($clearPassword) {
        $this->salt = mt_rand();
        $this->password = hash('sha512', $this->salt . $clearPassword);
    }
    
    
    // Initializes the password to a random value
    public function initPassword() {
        $clearPassword = mt_rand();
        $this->encryptPassword($clearPassword);
        return $clearPassword;
    }

    // Check to see if a given clear-text password matches this user's password
    public function comparePassword($clearPassword) {
        $hashed_password = hash('sha512', $this->salt . $clearPassword);
        if ($this->password == $hashed_password) {
            return true;
        } else {
            return false;
        }
    }
}
