<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Controller_Purchased extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Purchased';

		$this->load->model('Model_purchased');
    }

    /* 
    * It only redirects to the manage product page
    */
	public function index()
	{
        $this->load->model('Model_purchased');
        $purchased = $this->Model_purchased->getPurchasedData();
        $this->data['purchased'] = $purchased;
        $this->render_template('purchased/index', $this->data);	
	}

    /*
    * It Fetches the products data from the product table 
    * this function is called from the datatable ajax function
    */
public function fetchPurchasedData()
{
    $date_from = $this->input->get('date_from');
    $date_to = $this->input->get('date_to');
    $data = $this->Model_purchased->getPurchasedDataByDate($date_from, $date_to);
    $result = [];
    foreach ($data as $row) {
        $img_url = base_url('assets/images/purchased_image/' . (!empty($row['image']) ? basename($row['image']) : 'default.jpg'));
        $img_html = '<img src="'.$img_url.'" alt="image" class="img-circle" width="50" height="50">';
        $buttons = '';
        if ($row['moved_to_product'] == 1) {
            $buttons .= '<a href="'.base_url('Controller_Purchased/update/'.$row['id']).'" class="btn btn-info btn-sm"><i class="fa fa-info-circle"></i></a>';
        } else if (in_array('updatePurchased', $this->permission)) {
            $buttons .= '<a href="'.base_url('Controller_Purchased/update/'.$row['id']).'" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i></a>';
        }
        if (in_array('deletePurchased', $this->permission)) {
            $buttons .= ' <button type="button" class="btn btn-danger btn-sm" onclick="removeFunc('.$row['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
        }
        $arrived_col = ($row['moved_to_product'] == 1)
            ? '<span class="label label-primary">In Store</span>'
            : '';
        $desc = isset($row['description']) ? preg_replace('/<\/?p>/', '', $row['description']) : '';
        $result[] = [
            $img_html,
            htmlspecialchars($row['name']),
            htmlspecialchars($row['qty']),
            htmlspecialchars($desc),
            $arrived_col,
            $buttons
        ];
    }
    echo json_encode(['data' => $result]);
}

public function create()
{
    if (!in_array('createPurchased', $this->permission)) redirect('dashboard', 'refresh');
    $this->form_validation->set_rules('name', 'Name', 'trim|required');
    $this->form_validation->set_rules('qty', 'Quantity', 'trim|required');
    $this->form_validation->set_rules('description', 'Description', 'trim');
    $this->form_validation->set_rules('purchase_date', 'Date', 'trim|required');
    if ($this->form_validation->run() == TRUE) {
        $image = 'default.jpg';
        if (isset($_FILES['product_image']['size']) && $_FILES['product_image']['size'] > 0) {
            $image = $this->upload_image();
        }
        $data = array(
            'name' => $this->input->post('name'),
            'qty' => $this->input->post('qty'),
            'description' => $this->input->post('description'),
            'image' => $image, // Save only the filename
            'purchase_date' => $this->input->post('purchase_date'),
            'moved_to_product' => 0 // Ensure new items are visible in manage purchased page
        );
        $create = $this->Model_purchased->create($data);
        if ($create) {
            $this->session->set_flashdata('success', 'Successfully created');
            redirect('Controller_Purchased/', 'refresh');
        } else {
            $this->session->set_flashdata('errors', 'Error occurred!!');
            redirect('Controller_Purchased/create', 'refresh');
        }
    } else {
        $this->render_template('purchased/create', $this->data);
    }
}

private function upload_image()
{
    $config['upload_path'] = 'assets/images/purchased_image';
    $config['file_name'] = uniqid();
    $config['allowed_types'] = 'gif|jpg|png|jpeg';
    $config['max_size'] = '1000';
    $this->load->library('upload', $config);
    if (!isset($_FILES['product_image']['name']) || !$_FILES['product_image']['name']) {
        $this->session->set_flashdata('error', 'No image selected or file input missing.');
        return 'default.jpg';
    }
    if (!$this->upload->do_upload('product_image')) {
        $error = $this->upload->display_errors();
        $this->session->set_flashdata('error', 'Image upload failed: ' . $error);
        return 'default.jpg';
    }
    $data = $this->upload->data();
    return $data['file_name'];
}

public function update($id = null)
{
    if (!in_array('updatePurchased', $this->permission)) redirect('dashboard', 'refresh');
    if (empty($id)) {
        redirect('Controller_Purchased', 'refresh');
        return;
    }
    $this->form_validation->set_rules('name', 'Name', 'trim|required');
    $this->form_validation->set_rules('qty', 'Quantity', 'trim|required');
    $this->form_validation->set_rules('description', 'Description', 'trim');
    $this->form_validation->set_rules('purchase_date', 'Date', 'trim|required');
    if ($this->form_validation->run() == TRUE) {
        $data = [
            'name' => $this->input->post('name'),
            'qty' => $this->input->post('qty'),
            'description' => $this->input->post('description'),
            'purchase_date' => $this->input->post('purchase_date')
        ];
        if (isset($_FILES['product_image']['size']) && $_FILES['product_image']['size'] > 0) {
            $upload_image = $this->upload_image();
            $data['image'] = $upload_image;
        }
        $update = $this->Model_purchased->update($data, $id);
        if ($update) {
            $this->session->set_flashdata('success', 'Successfully updated');
            redirect('Controller_Purchased/', 'refresh');
        } else {
            $this->session->set_flashdata('errors', 'Error occurred!!');
            redirect('Controller_Purchased/update/'.$id, 'refresh');
        }
    } else {
        $purchased_data = $this->Model_purchased->getPurchasedData($id);
        $this->data['purchased_data'] = $purchased_data;
        $this->render_template('purchased/edit', $this->data);
    }
}

public function remove()
{
    if (!in_array('deletePurchased', $this->permission)) redirect('dashboard', 'refresh');
    $id = $this->input->post('product_id');
    $response = ['success' => false, 'messages' => 'Refresh the page again!!'];
    if ($id) {
        $delete = $this->Model_purchased->remove($id);
        if ($delete) {
            $response['success'] = true;
            $response['messages'] = 'Successfully removed';
        } else {
            $response['messages'] = 'Error in the database while removing the product information';
        }
    }
    echo json_encode($response);
}
}
