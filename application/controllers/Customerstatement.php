<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Colombo');

class Customerstatement extends CI_Controller {

	public function index(){
		$this->load->model('Customerstatementinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['getcustomer']=$this->Customerstatementinfo->Customerget();
		$this->load->view('customerstatement', $result);
	}

	public function customerstatementReport() {
		$this->load->model('Customerstatementinfo');
		$result=$this->Customerstatementinfo->customerstatementReport();
	}
}