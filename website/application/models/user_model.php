<?php
class User_model extends CI_Model {
    
    // Get a user's record from the 'user' table using their login as a key
    function get($username) {
        $this->db->where('login',$username);
        $query = $this->db->get('user');
        if ($query && $query->num_rows() > 0)
            return $query->row(0,'User');
        else
            return null;
    }
    
    /*
     * Get a user's record from the 'user' table using their id as a key
     */
    function get_from_id($id) {
        $this->db->where('id',$id);
        $query = $this->db->get('user');
        if ($query && $query->num_rows() > 0)
            return $query->row(0,'User');
        else
            return null;
    }
    
    /*
     * Get a user's record from the 'user' table using their email as a key
     */
    function get_from_email($email) {
        $this->db->where('email',$email);
        $query = $this->db->get('user');
        if ($query && $query->num_rows() > 0)
            return $query->row(0,'User');
        else
            return null;
    }
	
	function get_same_email($email){
		$this->db->where('email', $email);
		$query = $this->db->get('user');
		if($query->num_rows() > 0)
			return false;
		else
			return true;
	}
    
    /*
     * Insert a new user into the 'user' table
     */
    function insert($user) {
        return $this->db->insert('user',$user);
    }
    
    /*
     * Update the email address of an existing user
     */
    function update_email($user) {
        $this->db->where('id', $user->id);
        return $this->db->update('user', array('email'=>$user->email));
    }
    
    /*
     *  Update the first and last names of an existing user
     */
    function update_name($user) {
        $this->db->where('id', $user->id);
        return $this->db->update('user', array('first'=>$user->first,
                                               'last'=>$user->last));
    }
    
    /*
     * Update permission level of user
     */
    function update_usertype($user){
         $this->db->where('id', $user->id);
         return $this->db->update('user', array('usertype'=>$user->usertype));
    }
    
    /*
     * Update clientid of user
     */
    function update_clientid($user){
         $this->db->where('id', $user->id);
         return $this->db->update('user', array('clientid'=>$user->clientid));
    }
    
    /*
     *  Update the password of an existing user
     */
    function update_password($user) {
        $this->db->where('id', $user->id);
        return $this->db->update('user',array('password'=>$user->password,
                                                'salt' => $user->salt));
    }
    
    /*
     *  Exclusive lookup of a user
     */
    function get_exclusive($username) {
        $sql = "select * from user where login=? for update";
        $query = $this->db->query($sql,array($username));
        if ($query && $query->num_rows() > 0)
            return $query->row(0,'User');
        else
            return null;
    }
    
    /*
     *  Show users
     */
    function display_all_users() {
        $query = $this->db->select('*')->from('user')->get();
        return $query->result();
    }
    
    /*
     *  Delete a user based on username
     */
    function delete_user($login){
        $this->db->where('login', $login);
        $this->db->delete('user');
    }
    
    /*
     * This function is totally avoidable if we put 'delete cascade' in our client table
     */
    function delete_clients($client_id){
        $this->db->where('clientid', $client_id);
        $this->db->delete('user');
    }
}
