<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Colombo');

class DAReport extends CI_Controller {

	public function index(){
		$this->load->model('DAReportinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['getcustomer']=$this->DAReportinfo->Customerget();
		$this->load->view('dareport', $result);
	}
}