<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
class Model_returns extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database(); // <-- Add this line to ensure $this->db is initialized
    }

    public function getReturnsData($id = null)
    {
        if($id) {
            $query = $this->db->get_where('returns', array('id' => $id));
            return $query->row_array();
        }
        $query = $this->db->get('returns');
        return $query->result_array();
    }

    public function create($data)
    {
        return $this->db->insert('returns', $data);
    }

    public function update($data, $id)
    {
        if($data && $id) {
            $this->db->where('id', $id);
            return $this->db->update('returns', $data); // $data should include 'customer_name'
        }
        return false;
    }

    public function remove($id)
    {
        if($id) {
            $this->db->where('id', $id);
            return $this->db->delete('returns');
        }
        return false;
    }
    
    public function countTotalReturns()
    {
        $this->db->from('returns');
        return $this->db->count_all_results();
    }
    public function getReturnsItems(){
        return $this->db->get('returns')->result();
    }
}


