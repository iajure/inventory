<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Controller_Returns extends Admin_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->not_logged_in();
        $this->data['page_title'] = 'Returns';
        $this->load->model('Model_returns');
    }

    public function index()
    {
        if(!in_array('viewReturns', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        $this->load->model('Model_returns');
        $returns = $this->Model_returns->getReturnsData();
        $this->data['returns'] = $returns;
        $this->render_template('returns/index', $this->data);	
    }

    public function fetchReturnsData()
    {
        $data = $this->Model_returns->getReturnsData();
        $result = ['data' => []];
        foreach ($data as $row) {
            $buttons = '';
            if (in_array('updateReturns', $this->permission)) {
                $buttons .= '<a href="'.base_url('Controller_Returns/update/'.$row['id']).'" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a> ';
            }
            if (in_array('deleteReturns', $this->permission)) {
                $buttons .= '<button type="button" class="btn btn-sm btn-danger" onclick="removeFunc('.$row['id'].')"><i class="fa fa-trash"></i></button>';
            }
            $result['data'][] = [
                '<img src="'.base_url($row['image']).'" width="50" height="50">',
                $row['name'],
                $row['qty'],
                $row['price'],
                $row['description'],
                $row['returns_date'],
                $buttons
            ];
        }
        echo json_encode($result);
    }

    public function create()
    {
        if (!in_array('createReturns', $this->permission)) redirect('dashboard', 'refresh');
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('qty', 'Quantity', 'trim|required');
        $this->form_validation->set_rules('description', 'Description', 'trim');
        $this->form_validation->set_rules('return_date', 'Date', 'trim|required');
        $this->form_validation->set_rules('customer_name', 'Customer Name', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $image = null;
            $image_from_sales = $this->input->post('image');
            // Always use the image from sales dropdown if present and not empty
            if (!empty($image_from_sales)) {
                $image = basename($image_from_sales);
            } else if (isset($_FILES['product_image']['name']) && $_FILES['product_image']['name']) {
                // Only use uploaded image if no sales image is selected
                $image = $this->upload_image();
            }
            // If still empty, use default
            if (empty($image)) {
                $image = 'default.jpg';
            }
            // Always store returns images in returns_image folder, even if from sales
            if ($image !== 'default.jpg' && strpos($image, 'returns_image/') === false) {
                // Copy image from sales_image to returns_image if it exists and not already in returns_image
                $sales_img_path = FCPATH . 'assets/images/sales_image/' . $image;
                $returns_img_path = FCPATH . 'assets/images/returns_image/' . $image;
                if (file_exists($sales_img_path) && !file_exists($returns_img_path)) {
                    @copy($sales_img_path, $returns_img_path);
                }
            }
            // Copy image to product_image folder for products page
            if ($image !== 'default.jpg') {
                $src_img_path = FCPATH . 'assets/images/returns_image/' . $image;
                $dest_img_path = FCPATH . 'assets/images/product_image/' . $image;
                if (file_exists($src_img_path) && !file_exists($dest_img_path)) {
                    @copy($src_img_path, $dest_img_path);
                }
                // Also check if image is from sales_image and not in returns_image
                $src_sales_img_path = FCPATH . 'assets/images/sales_image/' . $image;
                if (file_exists($src_sales_img_path) && !file_exists($dest_img_path)) {
                    @copy($src_sales_img_path, $dest_img_path);
                }
            }
            // Add/update product as returned in products table
            $this->load->model('Model_products');
            // Always create a new duplicate product for each return, keep the original name
            $product_data = [
                'name' => $this->input->post('name'),
                'price' => $this->input->post('price'),
                'qty' => $this->input->post('qty'),
                'image' => $image,
                'description' => $this->input->post('description'),
                'returned' => 1,
                'sku' => '',
                'attribute_value_id' => '',
                'availability' => 1,
                'product_date' => date('Y-m-d')
            ];
            $this->Model_products->create($product_data);
            $data = array(
                'customer_name' => $this->input->post('customer_name'),
                'name' => $this->input->post('name'),
                'qty' => $this->input->post('qty'),
                'price' => $this->input->post('price'),
                'description' => $this->input->post('description'),
                'image' => $image, // Only filename, always in returns_image folder
                'return_date' => $this->input->post('return_date')
            );
            $create = $this->Model_returns->create($data);
            // Set is_returned=1 for the sales record if sales_id is posted
            $sales_id = $this->input->post('sales_id');
            if ($create && $sales_id) {
                $this->load->model('Model_sales');
                $this->Model_sales->update(['is_returned' => 1], $sales_id);
            }
            if ($create) {
                $this->session->set_flashdata('success', 'Successfully created');
                redirect('Controller_Returns/', 'refresh');
            } else {
                $this->session->set_flashdata('errors', 'Error occurred!!');
                redirect('Controller_Returns/create', 'refresh');
            }
        } else {
            $this->load->model('Model_sales');
            $sales = $this->Model_sales->getUnreturnedSales();
            foreach ($sales as &$sale) {
                if (isset($sale['image'])) {
                    $sale['image'] = $sale['image'] ? basename($sale['image']) : 'default.jpg';
                }
            }
            $this->data['sales'] = $sales;
            $this->render_template('returns/create', $this->data);
        }
    }


    private function upload_image()
    {
        $config['upload_path'] = 'assets/images/returns_image';
        $config['file_name'] = uniqid();
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '1000';
        $this->load->library('upload', $config);
        // Fix: use correct input name for file upload
        if (!isset($_FILES['product_image']['name']) || !$_FILES['product_image']['name']) {
            return 'default.jpg'; // Only filename
        }
        if (!$this->upload->do_upload('product_image')) {
            return 'default.jpg';
        }
        $data = $this->upload->data();
        return $data['file_name']; // Only filename
    }

    public function update($id = null)
    {
        if (!in_array('updateReturns', $this->permission)) redirect('dashboard', 'refresh');
        if (empty($id)) {
            redirect('Controller_Returns', 'refresh');
            return;
        }
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('qty', 'Quantity', 'trim|required');
        $this->form_validation->set_rules('price', 'Price', 'trim|required'); // Ensure price is required
        $this->form_validation->set_rules('description', 'Description', 'trim');
        $this->form_validation->set_rules('return_date', 'Date', 'trim|required');
        $this->form_validation->set_rules('customer_name', 'Customer Name', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $returns_data = $this->Model_returns->getReturnsData($id);
            $data = [
                'customer_name' => $this->input->post('customer_name'),
                'name' => $this->input->post('name'),
                'qty' => $this->input->post('qty'),
                'price' => $this->input->post('price'),
                'description' => $this->input->post('description'),
                'return_date' => $this->input->post('return_date'),
                'image' => $returns_data['image'] // Default to old image
            ];
            if (isset($_FILES['product_image']['size']) && $_FILES['product_image']['size'] > 0 && $_FILES['product_image']['name']) {
                $upload_image = $this->upload_image();
                $data['image'] = $upload_image;
            }
            $update = $this->Model_returns->update($data, $id);
            if ($update) {
                $this->session->set_flashdata('success', 'Successfully updated');
                redirect('Controller_Returns/', 'refresh');
            } else {
                $this->session->set_flashdata('errors', 'Error occurred!!');
                redirect('Controller_Returns/update/'.$id, 'refresh');
            }
        } else {
            $returns_data = $this->Model_returns->getReturnsData($id);
            $this->data['returns_data'] = $returns_data;
            $this->render_template('returns/edit', $this->data);
        }
    }

    public function remove()
    {
        if (!in_array('deleteReturns', $this->permission)) redirect('dashboard', 'refresh');
        $id = $this->input->post('return_id');
        $response = ['success' => false, 'messages' => 'Refresh the page again!!'];
        if ($id) {
            $delete = $this->Model_returns->remove($id);
            if ($delete) {
                $response['success'] = true;
                $response['messages'] = 'Successfully deleted';
            } else {
                $response['messages'] = 'Error in the database while removing the returned item';
            }
        }
        echo json_encode($response);
    }
}

