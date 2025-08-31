<?php 

class Model_products extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/* get the brand data */
	public function getProductData($id = null)
	{
		if($id) {
			$query = $this->db->get_where('products', array('id' => $id));
			return $query->row_array();
		}
		$query = $this->db->get('products');
		return $query->result_array();
	}

	// New: Get products by date range
	public function getProductDataByDate($date_from = null, $date_to = null)
	{
		if ($date_from && $date_to) {
			$this->db->where('DATE(product_date) >=', $date_from);
			$this->db->where('DATE(product_date) <=', $date_to);
		} elseif ($date_from) {
			$this->db->where('DATE(product_date) >=', $date_from);
		} elseif ($date_to) {
			$this->db->where('DATE(product_date) <=', $date_to);
		}
		$query = $this->db->get('products');
		return $query->result_array();
	}

	public function getActiveProductData()
	{
		// Only show products that are active (availability = 1)
		$sql = "SELECT * FROM products WHERE availability = 1 ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getProductByName($name)
	{
		$query = $this->db->get_where('products', ['name' => $name]);
		return $query->row_array();
	}

	public function create($data)
	{
		return $this->db->insert('products', $data);
	}
   public function update($data, $id)
   {
	   $this->db->where('id', $id);
	   return $this->db->update('products', $data);
   }

	public function remove($id)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('products');
			return ($delete == true) ? true : false;
		}
	}

	public function countTotalProducts()
	{
		$sql = "SELECT * FROM products";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}


	public function countTotalbrands()
	{
		$sql = "SELECT * FROM brands";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	public function countTotalcategory()
	{
		$sql = "SELECT * FROM categories";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}


	public function countTotalattribures()
	{
		$sql = "SELECT * FROM attributes";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	public function markAsMoved($id)
	{
		if($id) {
			$this->db->where('id', $id);
			// Set both moved_to_sales=1 and availability=2 (inactive)
			return $this->db->update('products', ['moved_to_sales' => 1, 'availability' => 2]);
		}
		return false;
	}

	public function countProducts()
	{
	    $this->db->from('products');
	    return $this->db->count_all_results();
	}

}