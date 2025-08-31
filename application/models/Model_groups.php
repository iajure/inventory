<?php 

class Model_groups extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	public function edit($data = [], $id = null)
    {
        if ($id && !empty($data)) {
            $this->db->where('id', $id);
            return $this->db->update('groups', $data);
        }
        return false;
    }

	public function getGroupData($groupId = null) 
	{
		if($groupId) {
			$sql = "SELECT * FROM groups WHERE id = ?";
			$query = $this->db->query($sql, array($groupId));
			return $query->row_array();
		}

		// Show all groups, including id=1, so permissions like viewReport are visible
		$sql = "SELECT * FROM groups";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function create($data = '')
	{
		$create = $this->db->insert('groups', $data);
		return ($create == true) ? true : false;
	}

	public function update($data, $id)
	{
		if($data && $id) {
			$this->db->where('id', $id);
			return $this->db->update('groups', $data);
		}
		return false;
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		$delete = $this->db->delete('groups');
		return ($delete == true) ? true : false;
	}

	public function existInUserGroup($id)
	{
		$sql = "SELECT * FROM user_group WHERE group_id = ?";
		$query = $this->db->query($sql, array($id));
		return ($query->num_rows() == 1) ? true : false;
	}

	public function getUserGroupByUserId($user_id) 
	{
		$sql = "SELECT * FROM user_group 
		INNER JOIN groups ON groups.id = user_group.group_id 
		WHERE user_group.user_id = ?";
		$query = $this->db->query($sql, array($user_id));
		$result = $query->row_array();

		return $result;

	}
}