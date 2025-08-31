<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
class Model_customers extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getCustomersData($id = null)
    {
        if($id) {
            return $this->db->get_where('customers', array('id' => $id))->row_array();
        }
        return $this->db->get('customers')->result_array();
    }

    public function create($data)
    {
        if($data) {
            // $data should include 'address'
            return $this->db->insert('customers', $data);
        }
    }

    public function update($data, $id)
    {
        if($data && $id) {
            // $data should include 'address'
            $this->db->where('id', $id);
            return $this->db->update('customers', $data);
        }
    }

    public function remove($id)
    {
        if($id) {
            $this->db->where('id', $id);
            return $this->db->delete('customers');
        }
        return false;
    }
    
    public function countTotalCustomers()
    {
        $sql = "SELECT * FROM customers";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }
    public function getCustomersItems(){
        return $this->db->get('customers')->result();
    }
}
