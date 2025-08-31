<?php
/**
 * Model_salary
 * Handles DB operations for salary module
 */
class Model_salary extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    public function getSalaryData() {
        $this->db->select('salary.*, users.firstname, users.lastname');
        $this->db->from('salary');
        $this->db->join('users', 'users.id = salary.user_id', 'left');
        $query = $this->db->get();
        $result = $query->result_array();
        foreach($result as &$row) {
            $row['employee_name'] = $row['firstname'].' '.$row['lastname'];
        }
        return $result;
    }

    public function getSalaryById($id) {
        $this->db->select('salary.*, users.firstname, users.lastname');
        $this->db->from('salary');
        $this->db->join('users', 'users.id = salary.user_id', 'left');
        $this->db->where('salary.id', $id);
        $query = $this->db->get();
        $row = $query->row_array();
        if($row) {
            $row['employee_name'] = $row['firstname'].' '.$row['lastname'];
        }
        return $row;
    }

    public function create($data) {
        return $this->db->insert('salary', $data);
    }

    public function edit($data, $id) {
        $this->db->where('id', $id);
        return $this->db->update('salary', $data);
    }

    public function remove($id) {
        $this->db->where('id', $id);
        return $this->db->delete('salary');
    }
}
