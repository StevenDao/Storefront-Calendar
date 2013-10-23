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
    
    // Get a user's record from the 'user' table using their id as a key
    function getFromId($id) {
        $this->db->where('id',$id);
        $query = $this->db->get('user');
        if ($query && $query->num_rows() > 0)
            return $query->row(0,'User');
        else
            return null;
    }
    
    // Get a user's record from the 'user' table using their email as a key
    function getFromEmail($email) {
        $this->db->where('email',$email);
        $query = $this->db->get('user');
        if ($query && $query->num_rows() > 0)
            return $query->row(0,'User');
        else
            return null;
    }
    
    // Insert a new user into the 'user' table
    function insert($user) {
        return $this->db->insert('user',$user);
    }
    
    // Update the email address of an existing user
    function updateEmail($user) {
        $this->db->where('id', $user->id);
        return $this->db->update('user', array('email'=>$user->email));
    }
    
    // Update the first and last names of an existing user
    function updateName($user) {
        $this->db->where('id', $user->id);
        return $this->db->update('user', array('first'=>$user->first,
                                               'last'=>$user->last));
    }
    
    // Update the password of an existing user
    function updatePassword($user) {
        $this->db->where('id', $user->id);
        return $this->db->update('user',array('password'=>$user->password,
                                                'salt' => $user->salt));
    }
    
    // Exclusive lookup of a user
    function getExclusive($username) {
        $sql = "select * from user where login=? for update";
        $query = $this->db->query($sql,array($username));
        if ($query && $query->num_rows() > 0)
            return $query->row(0,'User');
        else
            return null;
    }
    
    // Show users
    function displayAllUsers() {
        $query = $this->db->select('*')->from('user')->get();
        return $query->result();
    }
    
    // Delete a user based on username
    function deleteUser($username){
        $this->db->where('login', $username);
        $this->db->delete('user');
    }
}
?>
