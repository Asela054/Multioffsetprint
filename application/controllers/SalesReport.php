<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Colombo');

class SalesReport extends CI_Controller {

	public function index(){
		$this->load->model('SalesReportinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['getcustomer']=$this->SalesReportinfo->Customerget();
		$this->load->view('salesReport', $result);
	}
}