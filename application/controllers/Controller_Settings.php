<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Controller_Settings extends Admin_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_settings');
        $this->data['page_title'] = 'Settings';
    }

    public function index()
    {
        // Load current settings (could be from session, db, etc.)
        $settings = $this->Model_settings->get_settings($this->session->userdata('user_id'));
        $this->data['settings'] = $settings;
        $this->render_template('settings/index', $this->data);
    }

    public function update()
    {
        if ($this->input->post()) {
            $data = array(
                'mode' => $this->input->post('mode'),
                'language' => $this->input->post('language'),
                'calendar' => $this->input->post('calendar'),
            );
            $update = $this->Model_settings->update_settings($this->session->userdata('user_id'), $data);
            if ($update) {
                $this->session->set_flashdata('success', 'Settings updated successfully');
            } else {
                $this->session->set_flashdata('error', 'Failed to update settings');
            }
            redirect('Controller_Settings');
        } else {
            redirect('Controller_Settings');
        }
    }
}
