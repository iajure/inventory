
<?php

class model_permission extends CI_Model
{
    // Add customers permissions for group creation/update
    public function getCustomersPermissions()
    {
        return [
            'createCustomers',
            'updateCustomers',
            'viewCustomers',
            'deleteCustomers'
        ];
    }
    public function __construct()
    {
        parent::__construct();
    }

    public function getGroupData($id = null)
    {
        if($id) {
            $sql = "SELECT * FROM groups WHERE id = ?";
            $query = $this->db->query($sql, array($id));
            return $query->row_array();
        }

        $sql = "SELECT * FROM groups";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    // Add sales permissions for group creation/update
    public function getSalesPermissions()
    {
        return [
            'createSales',
            'updateSales',
            'viewSales',
            'deleteSales'
        ];
    }

    public function update($id, $data)
    {
        if($id && $data) {
            $this->db->where('id', $id);
            return $this->db->update('groups', $data);
        }
        return false;
    }
   // Add elementsales permissions for group creation/update
    public function getElementsalesPermissions()
    {
        return [
            'createAttributeSales',
            'updateAttributeSales',
            'viewAttributeSales',
            'deleteAttributeSales'
        ];
    }
        // Add salary permissions for group creation/update
    public function getSalaryPermissions()
    {
        return [
            'createSalary',
            'updateSalary',
            'viewSalary',
            'deleteSalary'
        ];
    }
 
}
