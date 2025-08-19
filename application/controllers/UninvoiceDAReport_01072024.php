<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Colombo');

class UninvoiceDAReport extends CI_Controller {

	public function index(){
		$this->load->model('UninvoiceDAReportinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['getcustomer']=$this->UninvoiceDAReportinfo->Customerget();
		$this->load->view('uninvoicedareport', $result);
	}
}