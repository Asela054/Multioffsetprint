<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Colombo');

class VatReport extends CI_Controller {

	public function index(){
		$this->load->model('VatReportinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['getcustomer']=$this->VatReportinfo->Customerget();
		$this->load->view('vatReport', $result);
	}
}