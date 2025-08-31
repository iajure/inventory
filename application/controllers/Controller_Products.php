<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Controller_Products extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Products';

		$this->load->model('model_products');
		$this->load->model('model_attributes');
	}

    /* 
    * It only redirects to the manage product page
    */
	public function index()
	{
        if(!in_array('viewProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->render_template('products/index', $this->data);	
	}

    /*
    * It Fetches the products data from the product table 
    * this function is called from the datatable ajax function
    */
    public function fetchProductData()
    {
        $this->load->model('model_products');
        $date_from = $this->input->get('date_from');
        $date_to = $this->input->get('date_to');
        $data = $this->model_products->getProductDataByDate($date_from, $date_to);
    $result = ['data' => []];
    // Removed misplaced continue statement
    foreach ($data as $row) {
        $is_sold = isset($row['moved_to_sales']) && $row['moved_to_sales'] == 1;
        $img = !empty($row['image']) ? basename($row['image']) : 'default.jpg';
        $img_path = FCPATH . 'assets/images/product_image/' . $img;
        if (!empty($img) && $img !== 'default.jpg' && file_exists($img_path)) {
            $img_url = base_url('assets/images/product_image/' . $img);
        } else {
            $img_url = base_url('assets/images/product_image/default.jpg');
        }
        $buttons = '';
        if ($is_sold) {
            $buttons .= '<a href="'.base_url('Controller_Products/update/'.$row['id']).'" class="btn btn-info btn-sm"><i class="fa fa-info-circle"></i></a>';
        } else if(in_array('updateProduct', $this->permission)) {
            $buttons .= '<a href="'.base_url('Controller_Products/update/'.$row['id']).'" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i></a>';
        }
        if(in_array('deleteProduct', $this->permission)) { 
            $buttons .= ' <button type="button" class="btn btn-danger btn-sm" onclick="removeFunc('.$row['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
        }

        // If product is a returned duplicate and sold again, show as Inactive and no Returned label
        $is_returned_duplicate = (isset($row['returned']) && $row['returned']) && (strpos($row['name'], 'Returned') !== false);
        if ($is_returned_duplicate && $is_sold) {
            $availability = '<span class="label label-warning">Inactive</span>';
            $returned = '';
        } else if (isset($row['returned']) && $row['returned']) {
            $availability = '<span class="label label-success">Active</span>';
            $returned = '<span class="label label-warning">Returned</span>';
        } else {
            $availability = ($is_sold || $row['availability'] != 1) ? '<span class="label label-warning">Inactive</span>' : '<span class="label label-success">Active</span>';
            $returned = '';
        }

        $qty_status = '';
        if($row['qty'] <= 10) {
            $qty_status = '<span class="label label-warning">Low</span>';
        } else if($row['qty'] <= 0) {
            $qty_status = '<span class="label label-danger">Out of Stock!</span>';
        }
        // Show only Returned label (not Sold) for active returned products
        if ($row['availability'] == 1 && isset($row['returned']) && $row['returned']) {
            $sale_col = '';
        } else {
            $sale_col = $is_sold ? '<span class="label label-primary">Sold</span>' : '';
        }
        // Only apply dark theme to inactive products
        $is_inactive = ($is_sold || $row['availability'] != 1);
        $row_class = $is_inactive ? 'inactive-row' : '';
        $result['data'][] = [
            '<img src="' . $img_url . '" alt="image" class="img-circle" width="50" height="50">',
            '<span class="'.$row_class.'">'.htmlspecialchars($row['name']).'</span>',
            htmlspecialchars($row['price']),
            htmlspecialchars($row['qty']),
            htmlspecialchars($row['description']),
            $availability,
            $returned,
            $sale_col,
            $buttons
        ];
    }
    // Always return valid JSON
    header('Content-Type: application/json');
    echo json_encode($result);
	}	

    /*
    * If the validation is not valid, then it redirects to the create page.
    * If the validation for each input field is valid then it inserts the data into the database 
    * and it stores the operation message into the session flashdata and display on the manage product page
    */
	public function create()
	{
        // echo 'came';
        // exit();
		if(!in_array('createProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->form_validation->set_rules('product_name', 'Product name', 'trim|required');
		// $this->form_validation->set_rules('sku', 'SKU', 'trim|required');
		$this->form_validation->set_rules('price', 'Price', 'trim|required');
        $this->form_validation->set_rules('entry_price', 'Entry Price', 'trim|required');
		$this->form_validation->set_rules('qty', 'Qty', 'trim|required');
    // $this->form_validation->set_rules('store', 'Store', 'trim|required');
		$this->form_validation->set_rules('availability', 'Availability', 'trim|required');
        $this->form_validation->set_rules('product_date', 'Product Date', 'trim|required');
		
	
    $this->load->model('Model_purchased');
    $purchased_items = $this->Model_purchased->getNotMovedPurchasedItems();
    $this->data['purchased_items'] = $purchased_items;

    if ($this->form_validation->run() == TRUE) {
            // true case
            $image_to_save = '';
            if ($this->input->post('entry_mode') === 'purchased') {
                $image_filename = $this->input->post('purchased_image');
                $image_to_save = 'default.jpg';
                if (!empty($image_filename) && $image_filename !== 'default.jpg') {
                    $image_to_save = basename($image_filename);
                    $src = FCPATH . 'assets/images/purchased_image/' . $image_to_save;
                    $dest = FCPATH . 'assets/images/product_image/' . $image_to_save;
                    if (file_exists($src)) {
                        @copy($src, $dest);
                    }
                }
            } else {
                $upload_image = $this->upload_image();
                $image_to_save = $upload_image ? basename($upload_image) : 'default.jpg';
            }

            $data = array(
                'name' => $this->input->post('product_name'),
                // 'sku' => $this->input->post('sku'),
                'price' => $this->input->post('price'),
                    'entry_price' => $this->input->post('entry_price'),
                'qty' => $this->input->post('qty'),
                'image' => $image_to_save, // only filename, not path
                'description' => $this->input->post('description'),
                'attribute_value_id' => json_encode($this->input->post('attributes_value_id')),
                // 'brand_id' => json_encode($this->input->post('brands')),
                // 'category_id' => json_encode($this->input->post('category')),
                // 'store_id' => $this->input->post('store'),
                'availability' => $this->input->post('availability'),
                'product_date' => $this->input->post('product_date'),
            );

            $create = $this->model_products->create($data);
            if($create == true) {
                $this->session->set_flashdata('success', 'Successfully created');
                redirect('Controller_Products/', 'refresh');
            }
            else {
                $this->session->set_flashdata('errors', 'Error occurred!!');
                redirect('Controller_Products/create', 'refresh');
            }
        }
        else {
            // false case

        	// attributes 
        	$attribute_data = $this->model_attributes->getActiveAttributeData();

        	$attributes_final_data = array();
        	foreach ($attribute_data as $k => $v) {
        		$attributes_final_data[$k]['attribute_data'] = $v;

        		$value = $this->model_attributes->getAttributeValueData($v['id']);

        		$attributes_final_data[$k]['attribute_value'] = $value;
        	}

             $this->data['attributes'] = $attributes_final_data;

            // Get user calendar setting
            $this->load->model('Model_settings');
            $user_id = $this->session->userdata('user_id');
            $settings = $this->Model_settings->get_settings($user_id);
            $calendar = isset($settings['calendar']) ? $settings['calendar'] : 'european';
            $this->data['calendar'] = $calendar;

            $this->render_template('products/create', $this->data);
        }	
	}

    /*
    * This function is invoked from another function to upload the image into the assets folder
    * and returns the image path
    */
	public function upload_image()
    {
    	// assets/images/product_image
        $config['upload_path'] = 'assets/images/product_image';
        $config['file_name'] =  uniqid();
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '1000';

        // $config['max_width']  = '1024';s
        // $config['max_height']  = '768';

        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('product_image'))
        {
            $error = $this->upload->display_errors();
            return $error;
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());
            $type = explode('.', $_FILES['product_image']['name']);
            $type = $type[count($type) - 1];
            
            $path = $config['upload_path'].'/'.$config['file_name'].'.'.$type;
            return ($data == true) ? $path : false;            
        }
    }

    /*
    * If the validation is not valid, then it redirects to the edit product page 
    * If the validation is successfully then it updates the data into the database 
    * and it stores the operation message into the session flashdata and display on the manage product page
    */
	public function update($product_id)
	{      
        if(!in_array('updateProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        if(!$product_id) {
            redirect('dashboard', 'refresh');
        }

        $this->form_validation->set_rules('product_name', 'Product name', 'trim|required');
        // $this->form_validation->set_rules('sku', 'SKU', 'trim|required');
        $this->form_validation->set_rules('price', 'Price', 'trim|required');
        $this->form_validation->set_rules('entry_price', 'Entry Price', 'trim|required');
        $this->form_validation->set_rules('qty', 'Qty', 'trim|required');
    // $this->form_validation->set_rules('store', 'Store', 'trim|required');
        $this->form_validation->set_rules('availability', 'Availability', 'trim|required');
        $this->form_validation->set_rules('product_date', 'Product Date', 'trim|required');

        $this->load->model('Model_purchased');
        $purchased_items = $this->Model_purchased->getPurchasedData();
        $this->data['purchased_items'] = $purchased_items;

        if ($this->form_validation->run() == TRUE) {
            // true case
            
            $data = array(
                'name' => $this->input->post('product_name'),
                // 'sku' => $this->input->post('sku'),
                'price' => $this->input->post('price'),
                    'entry_price' => $this->input->post('entry_price'),
                'qty' => $this->input->post('qty'),
                'description' => $this->input->post('description'),
                'attribute_value_id' => json_encode($this->input->post('attributes_value_id')),
                // 'brand_id' => json_encode($this->input->post('brands')),
                // 'category_id' => json_encode($this->input->post('category')),
                // 'store_id' => $this->input->post('store'),
                'availability' => $this->input->post('availability'),
                'product_date' => $this->input->post('product_date'),
            );

            
            if($_FILES['product_image']['size'] > 0) {
                $upload_image = $this->upload_image();
                if ($upload_image) {
                    $image_filename = basename($upload_image);
                    $data['image'] = $image_filename;
                    // Always copy the new image to product_image folder (overwrite if exists)
                    $src = FCPATH . 'assets/images/product_image/' . $image_filename;
                    $tmp_upload = FCPATH . 'assets/images/product_image/' . $image_filename;
                    // If uploaded to a temp location, move/copy to product_image
                    if (file_exists($tmp_upload)) {
                        @copy($tmp_upload, $src);
                    }
                }
            }
            $update = $this->model_products->update($data, $product_id);
            if($update == true) {
                $this->session->set_flashdata('success', 'Successfully updated');
                redirect('Controller_Products/', 'refresh');
            }
            else {
                $this->session->set_flashdata('errors', 'Error occurred!!');
                redirect('Controller_Products/update/'.$product_id, 'refresh');
            }
        }
        else {
            // attributes 
            $attribute_data = $this->model_attributes->getActiveAttributeData();

            $attributes_final_data = array();
            foreach ($attribute_data as $k => $v) {
                $attributes_final_data[$k]['attribute_data'] = $v;

                $value = $this->model_attributes->getAttributeValueData($v['id']);

                $attributes_final_data[$k]['attribute_value'] = $value;
            }
            
            // false case
            $this->data['attributes'] = $attributes_final_data;
            // $this->data['brands'] = $this->model_brands->getActiveBrands();         
            // $this->data['category'] = $this->model_category->getActiveCategroy();         
            // $this->data['stores'] = $this->model_stores->getActiveStore();        

            $product_data = $this->model_products->getProductData($product_id);
            // Ensure attributes_value_id is always an array
            if (isset($product_data['attributes_value_id']) && !is_array($product_data['attributes_value_id'])) {
                $decoded = json_decode($product_data['attributes_value_id'], true);
                $product_data['attributes_value_id'] = is_array($decoded) ? $decoded : [];
            }
            $this->data['product_data'] = $product_data;
            $this->render_template('products/edit', $this->data); 
        }   
	}

    /*
    * It removes the data from the database
    * and it returns the response into the json format
    */
	public function remove()
	{
        if(!in_array('deleteProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        
        $product_id = $this->input->post('product_id');

        $response = array();
        if($product_id) {
            $delete = $this->model_products->remove($product_id);
            if($delete == true) {
                $response['success'] = true;
                $response['messages'] = "Successfully removed"; 
            }
            else {
                $response['success'] = false;
                $response['messages'] = "Error in the database while removing the product information";
            }
        }
        else {
            $response['success'] = false;
            $response['messages'] = "Refresh the page again!!";
        }

        echo json_encode($response);
	}

    public function removeFromPurchased()
    {
        $purchased_id = $this->input->post('purchased_id');

        if ($purchased_id) {
            // Load the Purchased model
            $this->load->model('Model_purchased');

            // Instead of deleting, mark as moved
            $update = $this->Model_purchased->markAsMoved($purchased_id);

            if ($update) {
                $response = ['success' => true, 'message' => 'Item successfully moved from Purchased.'];
            } else {
                $response = ['success' => false, 'message' => 'Failed to move item from Purchased.'];
            }
        } else {
            $response = ['success' => false, 'message' => 'Invalid request.'];
        }

        echo json_encode($response);
    }

    public function markProductAsMoved($product_id)
	{
	    $this->load->model('model_products');
	    if ($product_id) {
	        $this->model_products->markAsMoved($product_id);
	    }
	}

}