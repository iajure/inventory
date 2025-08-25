<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
class Model_sales extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database(); // <-- Ensure the database is loaded
    }

    public function getSalesData($id = null, $where = [])
    {
        if($id) {
            $query = $this->db->get_where('sales', array('id' => $id));
            return $query->row_array();
        }
        if (!empty($where)) {
            $this->db->where($where);
            $query = $this->db->get('sales');
            return $query->result_array();
        }
        // Only return sales not moved to returns
        $this->db->where('(moved_to_returns IS NULL OR moved_to_returns = 0)');
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



