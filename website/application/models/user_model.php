<?php
class User_model extends CI_Model
{
	function get($username) {
		$this->db->where('login',$username);
		$query = $this->db->get('user');
		if ($query && $query->num_rows() > 0)
			return $query->row(0,'User');
		else
			return null;
	}

	function getFromId($id) {
		$this->db->where('id',$id);
		$query = $this->db->get('user');
		if ($query && $query->num_rows() > 0)
			return $query->row(0,'User');
		else
			return null;
	}

	function getFromEmail($email) {
		$this->db->where('email',$email);
		$query = $this->db->get('user');
		if ($query && $query->num_rows() > 0)
			return $query->row(0,'User');
		else
			return null;
	}

	function insert($user) {
		return $this->db->insert('user',$user);
	}

	function updatePassword($user) {
		$this->db->where('id',$user->id);
		return $this->db->update('user',array('password'=>$user->password,
				                                'salt' => $user->salt));
	}

	function getExclusive($username) {
		$sql = "select * from user where login=? for update";
		$query = $this->db->query($sql,array($username));
		if ($query && $query->num_rows() > 0)
			return $query->row(0,'User');
		else
			return null;
	}
	
	function displayAllUsers() {
		$query = $this->db->select('*')->from('user')->get();
		return $query->result();
	}
	
	function deleteUser($username){
		$this->db->where('login', $username);
		$this->db->delete('user');
		redirect('account/deletepage', 'refresh');
	}
}
?>
