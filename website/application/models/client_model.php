<?php
class Client_model extends CI_Model
{
	function get_from_name($name) {
		$this->db->where('name', $name);
		$query = $this->db->get('client');
		if ($query && $query->num_rows() > 0)
			return $query->row(0, 'Client');
		else
			return null;
	}

	function get_from_id($id) {
		$this->db->where('id', $id);
		$query = $this->db->get('client');
		if ($query && $query->num_rows() > 0)
			return $query->row(0, 'Client');
		else
			return null;
	}

	function get_clients() {
		$clients = array();
		$query = $this->db->query("SELECT * FROM client;");

		foreach ($query->result('Client') as $row) {
			$clients[$row->id] = $row->name;
		}

		return $clients;
	}

	function insert($client) {
		return $this->db->insert('client', $client);
	}

	function update_address($client) {
		$this->db->where('id', $client->id);
		return $this->db->update('client', array('address' => $client->address));
	}

	function getExclusive($name) {
		$sql = "SELECT * FROM client WHERE login=? FOR UPDATE";
		$query = $this->db->query($sql, array($name));
		if ($query && $query->num_rows() > 0)
			return $query->row(0, 'Client');
		else
			return null;
	}
}
?>
