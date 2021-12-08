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
}

