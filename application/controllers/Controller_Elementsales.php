
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Controller_Elementsales extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Element Sales';

		$this->load->model('model_elementsales');
	}

	public function index()
	{
		if(!in_array('viewAttributeSales', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		$this->render_template('elementsales/index', $this->data);	
	}

	public function fetchAttributeDataById($id) 
	{
		if($id) {
			$data = $this->model_elementsales->getAttributeData($id);
			echo json_encode($data);
		}
	}

	public function fetchAttributeData()
	{
		$result = array('data' => array());
		$data = $this->model_elementsales->getAttributeData();
		foreach ($data as $key => $value) {
			$count_attribute_value = $this->model_elementsales->countAttributeValue($value['id']);
			$buttons = '<a href="'.base_url('Controller_Elementsales/addvalue/'.$value['id']).'" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add Value</a> 
			<button type="button" class="btn btn-warning btn-sm" onclick="editFunc('.$value['id'].')" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i></button>
			<button type="button" class="btn btn-danger btn-sm" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			$status = ($value['active'] == 1) ? '<span class="label label-success">Active</span>' : '<span class="label label-warning">Inactive</span>';
			$result['data'][$key] = array(
				$value['name'],
				$count_attribute_value,
				$status,
				$buttons
			);
		}
		echo json_encode($result);
	}

	public function create()
	{
		if(!in_array('createAttributeSales', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		$response = array();
		$this->form_validation->set_rules('attribute_name', 'Element Sale name', 'trim|required');
		$this->form_validation->set_rules('active', 'Active', 'trim|required');
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'name' => $this->input->post('attribute_name'),
        		'active' => $this->input->post('active'),	
        	);
        	$create = $this->model_elementsales->create($data);
        	if($create == true) {
        		$response['success'] = true;
        		$response['messages'] = 'Succesfully created';
        	}
        	else {
        		$response['success'] = false;
        		$response['messages'] = 'Error in the database while creating the element sale information';
        	}
        }
        else {
        	$response['success'] = false;
        	$response['messages'] = validation_errors();
        }
        echo json_encode($response);
	}

	// ...other methods (edit, remove, addvalue, etc.) should be duplicated and updated similarly...
	/*
	* this function redirects to the addvalue page with the parent attribute id
	*/
	public function addvalue($attribute_id = null)
	{
		if(!$attribute_id) {
			redirect('dashboard', 'refresh');
		}
	$this->data['attribute_data'] = $this->model_elementsales->getAttributeData($attribute_id);
	$this->data['page_title'] = 'Element Sales Value';
	$this->render_template('elementsales/addvalue', $this->data);
	}
    	public function createValue()
	{
		$this->form_validation->set_rules('attribute_value_name', 'Element value', 'trim|required');
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
		$response = array();
		if ($this->form_validation->run() == TRUE) {
			$attribute_parent_id = $this->input->post('attribute_parent_id');
			$data = array(
				'value' => $this->input->post('attribute_value_name'),
				'attribute_parent_id' => $attribute_parent_id
			);
			$create = $this->model_elementsales->createValue($data);
			if($create == true) {
				$response['success'] = true;
				$response['messages'] = 'Succesfully created';
			}
			else {
				$response['success'] = false;
				$response['messages'] = 'Error in the database while creating the value information';
			}
		}
		else {
			$response['success'] = false;
			foreach ($_POST as $key => $value) {
				$response['messages'][$key] = form_error($key);
			}
		}
		echo json_encode($response);
	}

	public function updateValue($id)
	{
		$response = array();
		if($id) {
			$this->form_validation->set_rules('edit_attribute_value_name', 'Element value', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
			if ($this->form_validation->run() == TRUE) {
				$attribute_parent_id = $this->input->post('attribute_parent_id');
				$data = array(
					'value' => $this->input->post('edit_attribute_value_name'),
					'attribute_parent_id' => $attribute_parent_id
				);
				$update = $this->model_elementsales->updateValue($data, $id);
				if($update == true) {
					$response['success'] = true;
					$response['messages'] = 'Succesfully updated';
				}
				else {
					$response['success'] = false;
					$response['messages'] = 'Error in the database while updating the value information';
				}
			}
			else {
				$response['success'] = false;
				foreach ($_POST as $key => $value) {
					$response['messages'][$key] = form_error($key);
				}
			}
		}
		else {
			$response['success'] = false;
			$response['messages'] = 'Error please refresh the page again!!';
		}
		echo json_encode($response);
	}

	public function removeValue()
	{
		$attribute_value_id = $this->input->post('attribute_value_id');
		$response = array();
		if($attribute_value_id) {
			$delete = $this->model_elementsales->removeValue($attribute_value_id);
			if($delete == true) {
				$response['success'] = true;
				$response['messages'] = "Successfully removed";
			}
			else {
				$response['success'] = false;
				$response['messages'] = "Error in the database while removing the value information";
			}
		}
		else {
			$response['success'] = false;
			$response['messages'] = "Refresh the page again!!";
		}
		echo json_encode($response);
	}
	public function fetchAttributeValueData($attribute_parent_id)
	{
		$result = array('data' => array());
		$data = $this->model_elementsales->getAttributeValueData($attribute_parent_id);
		foreach ($data as $key => $value) {
			$buttons = '
			<button type="button" class="btn btn-warning btn-sm" onclick="editFunc('.$value['id'].')" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i></button>
			<button type="button" class="btn btn-danger btn-sm" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>
			';
			$result['data'][$key] = array(
				$value['value'],
				$buttons
			);
		}
		echo json_encode($result);
	}

	public function fetchAttributeValueById($id)
	{
		if($id) {
			$data = $this->model_elementsales->getAttributeValueById($id);
			echo json_encode($data);
		}
	}
	public function remove()
	{
		$attribute_id = $this->input->post('attribute_id');
		$response = array();
		if($attribute_id) {
			$delete = $this->model_elementsales->remove($attribute_id);
			if($delete == true) {
				$response['success'] = true;
				$response['messages'] = "Successfully removed";
			}
			else {
				$response['success'] = false;
				$response['messages'] = "Error in the database while removing the element sale information";
			}
		}
		else {
			$response['success'] = false;
			$response['messages'] = "Refresh the page again!!";
		}
		echo json_encode($response);
	}

}
