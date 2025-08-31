<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Controller_Customers extends Admin_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->not_logged_in();
        $this->data['page_title'] = 'Customers';
        $this->load->model('Model_customers');
    }

    public function index()
    {
        if(!in_array('viewCustomers', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        $this->data['customers'] = $this->Model_customers->getCustomersData();
        $this->render_template('customers/index', $this->data);
    }

    public function fetchCustomersData()
    {
        $data = $this->Model_customers->getCustomersData();
        $result = ['data' => []];
        foreach ($data as $row) {
            $buttons = '';
            if (in_array('updateCustomers', $this->permission)) {
                $buttons .= '<a href="'.base_url('Controller_Customers/update/'.$row['id']).'" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a> ';
            }
            if (in_array('deleteCustomers', $this->permission)) {
                $buttons .= '<button type="button" class="btn btn-sm btn-danger" onclick="removeFunc('.$row['id'].')"><i class="fa fa-trash"></i></button>';
            }
            $result['data'][] = [
                $row['customer_name'],
                $row['phone'],
                $row['date'],
                $row['description'],
                $buttons
            ];
        }
        echo json_encode($result);
    }

    public function create()
    {
        if (!in_array('createCustomers', $this->permission)) redirect('dashboard', 'refresh');
        $this->form_validation->set_rules('customer_name', 'Customer Name', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone Number', 'trim|required');
        $this->form_validation->set_rules('date', 'Date', 'trim|required');
        $this->form_validation->set_rules('description', 'Description', 'trim');
        if ($this->form_validation->run() == TRUE) {
            $data = [
                'customer_name' => $this->input->post('customer_name'),
                'phone' => $this->input->post('phone'),
                'date' => $this->input->post('date'),
                'description' => $this->input->post('description')
            ];
            $create = $this->Model_customers->create($data);
            if ($create) {
                $this->session->set_flashdata('success', 'Successfully created');
                redirect('Controller_Customers/', 'refresh');
            } else {
                $this->session->set_flashdata('errors', 'Error occurred!!');
                redirect('Controller_Customers/create', 'refresh');
            }
        } else {
            $this->render_template('customers/create', $this->data);
        }
    }

    public function update($id = null)
    {
        if (!in_array('updateCustomers', $this->permission)) redirect('dashboard', 'refresh');
        if (empty($id)) {
            redirect('Controller_Customers', 'refresh');
            return;
        }
        $this->form_validation->set_rules('customer_name', 'Customer Name', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone Number', 'trim|required');
        $this->form_validation->set_rules('date', 'Date', 'trim|required');
        $this->form_validation->set_rules('description', 'Description', 'trim');
        if ($this->form_validation->run() == TRUE) {
            $data = [
                'customer_name' => $this->input->post('customer_name'),
                'phone' => $this->input->post('phone'),
                'date' => $this->input->post('date'),
                'description' => $this->input->post('description')
            ];
            $update = $this->Model_customers->update($data, $id);
            if ($update) {
                $this->session->set_flashdata('success', 'Successfully updated');
                redirect('Controller_Customers/', 'refresh');
            } else {
                $this->session->set_flashdata('errors', 'Error occurred!!');
                redirect('Controller_Customers/update/'.$id, 'refresh');
            }
        } else {
            $customers_data = $this->Model_customers->getCustomersData($id);
            $this->data['customers_data'] = $customers_data;
            $this->render_template('customers/edit', $this->data);
        }
    }

    public function remove()
    {
        if (!in_array('deleteCustomers', $this->permission)) redirect('dashboard', 'refresh');
        $id = $this->input->post('customer_id');
        $response = ['success' => false, 'messages' => 'Refresh the page again!!'];
        if ($id) {
            $delete = $this->Model_customers->remove($id);
            if ($delete) {
                $response['success'] = true;
                $response['messages'] = 'Successfully removed';
            } else {
                $response['messages'] = 'Error in the database while removing the customer information';
            }
        }
        echo json_encode($response);
    }
}
