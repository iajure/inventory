<?php 

class Model_elementsales extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getActiveAttributeData()
	{
		$sql = "SELECT * FROM elementsales WHERE active = ?";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	public function getAttributeData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM elementsales where id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}
		$sql = "SELECT * FROM elementsales";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function countAttributeValue($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM elementsales_value WHERE attribute_parent_id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->num_rows();
		}
	}

	public function getAttributeValueData($id = null)
	{
		$sql = "SELECT * FROM elementsales_value WHERE attribute_parent_id = ?";
		$query = $this->db->query($sql, array($id));
		return $query->result_array();
	}

	public function getAttributeValueById($id = null)
	{
		$sql = "SELECT * FROM elementsales_value WHERE id = ?";
		$query = $this->db->query($sql, array($id));
		return $query->row_array();
	}

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('elementsales', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $id)
	{
		if($data && $id) {
			$this->db->where('id', $id);
			$update = $this->db->update('elementsales', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('elementsales');
			return ($delete == true) ? true : false;
		}
	}

	public function createValue($data)
	{
		if($data) {
			$insert = $this->db->insert('elementsales_value', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function updateValue($data, $id)
	{
		if($data && $id) {
			$this->db->where('id', $id);
			$update = $this->db->update('elementsales_value', $data);
			return ($update == true) ? true : false;
		}
	}

	public function removeValue($id)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('elementsales_value');
			return ($delete == true) ? true : false;
		}
	}
}
