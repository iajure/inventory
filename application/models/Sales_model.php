<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // ...existing methods...

    /**
     * Get product image path by product ID.
     *
     * @param int $product_id
     * @return string|bool Image path or false if not found.
     */
    public function get_product_image($product_id) {
        $this->db->select('image');
        $this->db->from('products');
        $this->db->where('id', $product_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->image; // Return the image path
        } else {
            return false;
        }
    }
}