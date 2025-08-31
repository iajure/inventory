<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_settings extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }

    // Get settings for a user
    public function get_settings($user_id)
    {
        $query = $this->db->get_where('user_settings', array('user_id' => $user_id));
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            // Default settings if not set
            return array(
                'mode' => 'light',
                'language' => 'english',
                'calendar' => 'european'
            );
        }
    }

    // Update settings for a user
    public function update_settings($user_id, $data)
    {
        if ($this->db->get_where('user_settings', array('user_id' => $user_id))->num_rows() > 0) {
            return $this->db->update('user_settings', $data, array('user_id' => $user_id));
        } else {
            $data['user_id'] = $user_id;
            return $this->db->insert('user_settings', $data);
        }
    }
}
