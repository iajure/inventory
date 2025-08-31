<?php
/**
 * Controller_Salary
 * Handles CRUD for salary module
 */
class Controller_Salary extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        $this->not_logged_in();
        $this->load->model('Model_salary');
        $this->load->model('Model_users');
        // Permission check
        if(!in_array('viewSalary', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
    }

    public function index() {
        if(!in_array('viewSalary', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        $this->data['page_title'] = 'Manage Salaries';
        $this->data['salary_data'] = $this->Model_salary->getSalaryData();
        $this->render_template('salary/index', $this->data);
    }

    public function fetchSalaryData() {
        if(!in_array('viewSalary', $this->permission)) {
            echo json_encode(['data'=>[]]);
            return;
        }
        $result = array('data' => array());
        $salaryData = $this->Model_salary->getSalaryData();
        foreach ($salaryData as $row) {
            $buttons = '';
            if(in_array('updateSalary', $this->permission)) {
                $buttons .= '<a href="'.base_url('Controller_Salary/edit/'.$row['id']).'" class="btn btn-default"><i class="fa fa-edit"></i></a>';
            }
            if(in_array('deleteSalary', $this->permission)) {
                $buttons .= ' <a href="#" class="btn btn-danger" onclick="removeFunc('.$row['id'].')"><i class="fa fa-trash"></i></a>';
            }
            $result['data'][] = array(
                $row['employee_name'],
                number_format($row['basic_salary'],2),
                number_format($row['allowances'],2),
                number_format($row['deductions'],2),
                number_format($row['net_salary'],2),
                $row['salary_date'],
                $buttons
            );
        }
        echo json_encode($result);
    }

    public function create() {
        if(!in_array('createSalary', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        $this->form_validation->set_rules('user_id', 'Employee', 'required');
        $this->form_validation->set_rules('basic_salary', 'Basic Salary', 'required|numeric');
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'user_id' => $this->input->post('user_id'),
                'month' => $this->input->post('month'),
                'employee_name' => $this->input->post('employee_name'),
                'position' => $this->input->post('position'),
                'basic_salary' => $this->input->post('basic_salary'),
                'allowances' => $this->input->post('allowances'),
                'deductions' => $this->input->post('deductions'),
                'net_salary' => $this->input->post('net_salary'),
                'salary_date' => $this->input->post('salary_date'),
                'notes' => $this->input->post('notes'),
            );
            $create = $this->Model_salary->create($data);
            if($create) {
                $this->session->set_flashdata('success', 'Successfully created');
                redirect('Controller_Salary/','refresh');
            } else {
                $this->session->set_flashdata('errors', 'Error occurred');
                redirect('Controller_Salary/create','refresh');
            }
        } else {
            $this->data['users'] = $this->Model_users->getActiveUsers();
            $this->render_template('salary/create', $this->data);
        }
    }

    public function edit($id) {
        if(!in_array('updateSalary', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        if(!$id) redirect('Controller_Salary','refresh');
        $this->form_validation->set_rules('basic_salary', 'Basic Salary', 'required|numeric');
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'month' => $this->input->post('month'),
                'basic_salary' => $this->input->post('basic_salary'),
                'allowances' => $this->input->post('allowances'),
                'deductions' => $this->input->post('deductions'),
                'net_salary' => $this->input->post('net_salary'),
                'salary_date' => $this->input->post('salary_date'),
                'notes' => $this->input->post('notes'),
            );
            $update = $this->Model_salary->edit($data, $id);
            if($update) {
                $this->session->set_flashdata('success', 'Successfully updated');
                redirect('Controller_Salary/','refresh');
            } else {
                $this->session->set_flashdata('errors', 'Error occurred');
                redirect('Controller_Salary/edit/'.$id,'refresh');
            }
        } else {
            $salary = $this->Model_salary->getSalaryById($id);
            $this->data['salary'] = $salary;
            $this->data['users'] = $this->Model_users->getActiveUsers();
            $this->render_template('salary/edit', $this->data);
        }
    }

    public function delete() {
        if(!in_array('deleteSalary', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        $id = $this->input->post('id');
        if(!$id) redirect('Controller_Salary','refresh');
        $delete = $this->Model_salary->remove($id);
        if($delete) {
            $this->session->set_flashdata('success', 'Successfully deleted');
        } else {
            $this->session->set_flashdata('errors', 'Error occurred');
        }
        redirect('Controller_Salary','refresh');
    }
}
