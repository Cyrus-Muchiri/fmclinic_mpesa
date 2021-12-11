<?php 
class Payments_model extends CI_Model {

    public function __construct() {
        $this->load->database();
        parent::__construct();
    }

    public function insert_mpesa_details($data)
    {
        $this->db->insert('payments', $data);

    }
    public function get_mpesa_details()
    {
        $this->db->select('*');
        $this->db->from('payments');
        $this->db->where('isFetched', 0);
        $query = $this->db->get();
        return $query->result();
    }
    public function update_mpesa_details($id)
    {
        $this->db->set('isFetched', 1);
        $this->db->where('id', $id);
        return $this->db->update('payments');

    }
}

