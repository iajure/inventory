<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Controller_Sales extends Admin_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->not_logged_in();
        $this->data['page_title'] = 'Sales';
        $this->load->model('Model_sales');
        $this->load->model('model_products'); // <-- Add this line
    }

    public function index()
    {
        $this->load->model('Model_sales');
        $sales = $this->Model_sales->getSalesData(); // Should return array of sales records
        $this->data['sales'] = $sales;
        $this->render_template('sales/index', $this->data);    
    }

    public function fetchSalesData()
    {
        $data = $this->Model_sales->getSalesData();
        $result = ['data' => []];
        foreach ($data as $row) {
            $buttons = '';
            if (in_array('updateSales', $this->permission)) {
                $buttons .= '<a href="'.base_url('Controller_Sales/update/'.$row['id']).'" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a> ';
            }
            if (in_array('deleteSales', $this->permission)) {
                $buttons .= '<button type="button" class="btn btn-sm btn-danger" onclick="removeFunc('.$row['id'].')"><i class="fa fa-trash"></i></button>';
            }
            $result['data'][] = [
                '<img src="'.base_url($row['image']).'" width="50" height="50">',
                $row['name'],
                $row['qty'],
                $row['price'],
                $row['description'],
                $row['sales_date'],
                $buttons
            ];
        }
        echo json_encode($result);
    }

    public function create()
    {
        if (!in_array('createSales', $this->permission)) redirect('dashboard', 'refresh');
        $this->load->model('Model_products');
        $this->load->model('model_attributes');
        $this->load->model('Model_elementsales');
        $this->load->model('Model_customers');

    // Only include products that are active (availability=1)
    $products_raw = $this->model_products->getActiveProductData();
        $attributes = $this->model_attributes->getActiveAttributeData();
        // Fetch all active element sales and their values
        $elementsales = $this->Model_elementsales->getActiveAttributeData();
        $elementsales_full = [];
        foreach ($elementsales as $es) {
            $es['values'] = $this->Model_elementsales->getAttributeValueData($es['id']);
            $elementsales_full[] = $es;
        }
        $customers = $this->Model_customers->getCustomersData();

        $products = [];
        foreach ($products_raw as $product) {
            $element_names = [];
            $element_values = [];
            if (!empty($product['attribute_value_id'])) {
                $attribute_ids = json_decode($product['attribute_value_id'], true);
                if (is_array($attribute_ids)) {
                    foreach ($attribute_ids as $attr_val_id) {
                        $attr_data = $this->model_attributes->getAttributeDataByValueId($attr_val_id);
                        if ($attr_data) {
                            $element_names[] = $attr_data['attribute_name'];
                            if (!isset($element_values[$attr_data['attribute_name']])) {
                                $element_values[$attr_data['attribute_name']] = [];
                            }
                            if ($attr_data['value'] !== $attr_data['attribute_name']) {
                                $element_values[$attr_data['attribute_name']][] = $attr_data['value'];
                            }
                        }
                    }
                }
            }
            // Always use just the filename for image
            $product['image'] = !empty($product['image']) ? basename($product['image']) : 'default.jpg';
            $product['element_names'] = array_unique($element_names);
            $product['element_values'] = $element_values;
            // Ensure description is present
            $product['description'] = isset($product['description']) ? $product['description'] : '';
            $products[] = $product;
        }
        $selected_product_id = $this->input->post('product_id');
        $default_description = '';
        if ($selected_product_id) {
            foreach ($products as $product) {
                if ($product['id'] == $selected_product_id && !empty($product['description'])) {
                    $default_description = $product['description'];
                    break;
                }
            }
        }
        $this->data['products'] = $products;
        $this->data['attributes'] = $attributes;
        $this->data['elementsales'] = $elementsales_full;
        $this->data['customers'] = $customers;
        $this->data['default_description'] = $default_description;

        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('qty', 'Quantity', 'trim|required');
        $this->form_validation->set_rules('price', 'Price', 'trim|required');
        $this->form_validation->set_rules('description', 'Description', 'trim');
        $this->form_validation->set_rules('sales_date', 'Sales Date', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            // Debug: check if description is empty in POST
            $posted_description = $this->input->post('description');
            if (empty($posted_description)) {
                $this->session->set_flashdata('errors', 'DEBUG: Description is empty in POST!');
            }
            $product_image = $this->input->post('image');
            $new_image_filename = $product_image;
            if (!empty($product_image) && $product_image !== 'default.jpg') {
                $src = FCPATH . 'assets/images/product_image/' . $product_image;
                $ext = pathinfo($product_image, PATHINFO_EXTENSION);
                $new_image_filename = uniqid() . '.' . $ext;
                $dest = FCPATH . 'assets/images/sales_image/' . $new_image_filename;
                if (file_exists($src)) {
                    @copy($src, $dest);
                } else {
                    $new_image_filename = 'default.jpg';
                }
            } else {
                $new_image_filename = 'default.jpg';
            }
            $elementsales_value_ids = $this->input->post('elementsales_value');
            // Only save selected values (not empty)
            $elementsales_value_ids = is_array($elementsales_value_ids) ? array_filter($elementsales_value_ids) : [];
            $data = [
                'name' => $this->input->post('name'),
                'qty' => $this->input->post('qty'),
                'price' => $this->input->post('price'),
                'description' => $this->input->post('description'),
                'sales_date' => $this->input->post('sales_date'),
                'image' => $new_image_filename,
                'elementsales_value_id' => json_encode(array_values($elementsales_value_ids)),
                'customer_name' => $this->input->post('customer_name')
            ];
            $create = $this->Model_sales->create($data);

            // Mark product as moved if product_id is set
            $product_id = $this->input->post('product_id');
            if ($product_id) {
                $this->load->model('model_products');
                $this->model_products->markAsMoved($product_id);
            }

            if ($create) {
                $this->session->set_flashdata('success', 'Successfully created');
                redirect('Controller_Sales/', 'refresh');
            } else {
                $this->session->set_flashdata('errors', 'Error occurred!!');
                redirect('Controller_Sales/create', 'refresh');
            }
        } else {
            $this->render_template('sales/create', $this->data);
        }
    }

    private function upload_image()
    {
        $config['upload_path'] = 'assets/images/sales_image';
        $config['file_name'] = uniqid();
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '1000';
        $this->load->library('upload', $config);
        if (!isset($_FILES['product_image']['name']) || !$_FILES['product_image']['name']) {
            return 'assets/images/default.jpg';
        }
        if (!$this->upload->do_upload('product_image')) {
            return 'assets/images/default.jpg';
        }
        $data = $this->upload->data();
        return $config['upload_path'].'/'.$data['file_name'];
    }

    public function update($id = null)
    {
        if (!in_array('updateSales', $this->permission)) redirect('dashboard', 'refresh');
        if (empty($id)) {
            redirect('Controller_Sales', 'refresh');
            return;
        }
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('qty', 'Quantity', 'trim|required');
        $this->form_validation->set_rules('price', 'Price', 'trim|required|numeric');
        $this->form_validation->set_rules('description', 'Description', 'trim');
        $this->form_validation->set_rules('sales_date', 'Date', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $elementsales_value_ids = $this->input->post('elementsales_value');
            $elementsales_value_ids = is_array($elementsales_value_ids) ? array_filter($elementsales_value_ids) : [];
            $data = [
                'name' => $this->input->post('name'),
                'qty' => $this->input->post('qty'),
                'price' => $this->input->post('price'),
                'description' => $this->input->post('description'),
                'sales_date' => $this->input->post('sales_date'),
                'elementsales_value_id' => json_encode(array_values($elementsales_value_ids)),
                'customer_name' => $this->input->post('customer_name')
            ];
            if (isset($_FILES['product_image']['size']) && $_FILES['product_image']['size'] > 0) {
                $upload_image = $this->upload_image();
                $data['image'] = $upload_image;
            }
            $update = $this->Model_sales->update($data, $id);
            if ($update) {
                $this->session->set_flashdata('success', 'Successfully updated');
                redirect('Controller_Sales/', 'refresh');
            } else {
                $this->session->set_flashdata('errors', 'Error occurred!!');
                redirect('Controller_Sales/update/'.$id, 'refresh');
            }
        } else {
            $this->load->model('Model_customers');
            $this->load->model('Model_elementsales');
            $sales_data = $this->Model_sales->getSalesData($id);
            $customers = $this->Model_customers->getCustomersData();
            $elementsales = $this->Model_elementsales->getActiveAttributeData();
            $elementsales_full = [];
            foreach ($elementsales as $es) {
                $es['values'] = $this->Model_elementsales->getAttributeValueData($es['id']);
                $elementsales_full[] = $es;
            }
            $this->data['sales_data'] = $sales_data;
            $this->data['customers'] = $customers;
            $this->data['elementsales'] = $elementsales_full;
            $this->render_template('sales/edit', $this->data);
        }
    }

    public function remove()
    {
        if (!in_array('deleteSales', $this->permission)) redirect('dashboard', 'refresh');
        $id = $this->input->post('sale_id');
        $response = ['success' => false, 'messages' => 'Refresh the page again!!'];
        if ($id) {
            $delete = $this->Model_sales->remove($id);
            if ($delete) {
                $response['success'] = true;
                $response['messages'] = 'Successfully deleted';
            } else {
                $response['messages'] = 'Error in the database while removing the sales item';
            }
        }
        echo json_encode($response);
    }

    public function removeFromProducts()
    {
        $product_id = $this->input->post('product_id');

        if ($product_id) {
            $this->load->model('model_products');
            // Instead of deleting, mark as moved
            $update = $this->model_products->markAsMoved($product_id);

            if ($update) {
                $response = ['success' => true, 'message' => 'Item successfully moved from Products.'];
            } else {
                $response = ['success' => false, 'message' => 'Failed to move item from Products.'];
            }
        } else {
            $response = ['success' => false, 'message' => 'Invalid request.'];
        }

        echo json_encode($response);
    }
}
                $response['messages'] = 'Error in the database while removing the sales item';
