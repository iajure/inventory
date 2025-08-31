<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Controller_Report extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->not_logged_in();
        $this->data['page_title'] = 'Report';

        $this->load->model('Model_products');
        $this->load->model('Model_sales');
    }

    public function index()
    {
        $products = $this->Model_products->getProductData();
        $sales = $this->Model_sales->getSalesData();

        $total_product_value = 0.0;
        foreach ($products as $p) {
            $total_product_value += (float)$p['price'] * (int)$p['qty'];
        }

        $total_sales_value = 0.0;
        foreach ($sales as $s) {
            $total_sales_value += (float)$s['price'] * (int)$s['qty'];
        }

        $this->data['total_product_value'] = $total_product_value;
        $this->data['total_sales_value'] = $total_sales_value;

        $this->render_template('report/index', $this->data);
    }
}
