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

        function get_from_email($email) {
                $this->db->where('email',$email);
                $query = $this->db->get('client');
                if ($query && $query->num_rows() > 0)
                        return $query->row(0,'Client');
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

        function get_exclusive($name) {
                $sql = "SELECT * FROM client WHERE login=? FOR UPDATE";
                $query = $this->db->query($sql, array($name));
                if ($query && $query->num_rows() > 0)
                        return $query->row(0, 'Client');
                else
                        return null;
        }
        
    // Show all clients
    function display_all_clients() {
        $query = $this->db->select('*')->from('client')->get();
        return $query->result();
    }
    
    //TO DO: the users are deleting properly; apperantly I can't delete two times
    function delete_client($id){
    	$this->db->delete('user', array('clientid' => $id));
        $this->db->delete('client', array('id' => $id));
        
    }
}

/* End of file client_model.php */
/* Location: ./application/models/client_model.php */