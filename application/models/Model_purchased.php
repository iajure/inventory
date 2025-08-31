<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_purchased extends CI_Model
{

    public function update($data, $id)
    {
        if($data && $id) {
            $this->db->where('id', $id);
            return $this->db->update('purchased', $data);
        }
        return false;
    }
    // Simple mechanism: get all purchased items not moved to products
    public function getNotMovedPurchasedItems()
    {
        return $this->db->get_where('purchased', array('moved_to_product' => 0))->result_array();
    }
    public function __construct()
    {
        parent::__construct();
    }

    public function create($data = array())
    {
        if($data) {
            $insert = $this->db->insert('purchased', $data);
            return ($insert == true);
        }
        return false;
    }

    public function getPurchasedData($id = null)
    {
        if($id) {
                return $this->db->get_where('purchased', array('id' => $id))->row_array();
        }
            return $this->db->get('purchased')->result_array();
    }

    public function remove($id)
    {
        if($id) {
            $this->db->where('id', $id);
            $delete = $this->db->delete('purchased');
            return ($delete == true);
        }
        return false;
    }

    public function countTotalPurchased()
    {
        $this->db->from('purchased');
        return $this->db->count_all_results();
    }

    public function getPurchasedItems()
    {
        return $this->db->get('purchased')->result();
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('purchased');
    }

    public function markAsMoved($id)
    {
        if($id) {
            $this->db->where('id', $id);
            return $this->db->update('purchased', ['moved_to_product' => 1]);
        }
        return false;
    }

    public function getPurchasedDataByDate($date_from = null, $date_to = null)
    {
        if ($date_from && $date_to) {
            $this->db->where('DATE(purchase_date) >=', $date_from);
            $this->db->where('DATE(purchase_date) <=', $date_to);
        } elseif ($date_from) {
            $this->db->where('DATE(purchase_date) >=', $date_from);
        } elseif ($date_to) {
            $this->db->where('DATE(purchase_date) <=', $date_to);
        }
        $query = $this->db->get('purchased');
        $result = $query->result_array();
        // Ensure result is always an array for DataTables
        return is_array($result) ? $result : [];
    }
}
