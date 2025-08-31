<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
class Model_sales extends CI_Model
{
    // Get only sales items that have not been returned
    public function getUnreturnedSales()
    {
        $this->db->select('*');
        $this->db->where('is_returned', 0);
        $query = $this->db->get('sales');
        return $query->result_array();
    }
    public function __construct()
    {
        parent::__construct();
        $this->load->database(); // <-- Ensure the database is loaded
    }

    public function getSalesData($id = null, $where = [])
    {
        $this->db->select('*');
        if($id) {
            $query = $this->db->get_where('sales', array('id' => $id));
            return $query->row_array();
        }
        if (!empty($where)) {
            $this->db->where($where);
            $query = $this->db->get('sales');
            return $query->result_array();
        }
    // Return all sales (including sold/returned)
    $query = $this->db->get('sales');
    return $query->result_array();
    }

    public function create($data = array())
    {
        if($data) {
            return $this->db->insert('sales', $data);
        }
        return false;
    }

    public function update($data, $id)
    {
        if($data && $id) {
            $this->db->where('id', $id);
            return $this->db->update('sales', $data); // $data should include 'customer_name'
        }
        return false;
    }

    public function remove($id)
    {
        if($id) {
            $this->db->where('id', $id);
            return $this->db->delete('sales');
        }
        return false;
    }
    
    public function countTotalSales()
    {
        $sql = "SELECT * FROM sales";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }
    public function getSalesItems(){
        return $this->db->get('sales')->result();
    }
}



