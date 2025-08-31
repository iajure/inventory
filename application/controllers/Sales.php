<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('Sales_model');
        $this->load->helper('url');
    }

	// ...existing code...

    public function get_product_image() {
        $product_id = $this->input->post('product_id');
        $image_path = $this->Sales_model->get_product_image($product_id);

        if ($image_path) {
            echo json_encode(['success' => true, 'image_path' => base_url($image_path)]);
        } else {
            echo json_encode(['success' => false]);
        }
    }
}