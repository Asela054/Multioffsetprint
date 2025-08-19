<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Colombo');

class Deletedinvoice extends CI_Controller {

	public function index(){
		$this->load->model('Deletedinvoiceinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['getcustomer']=$this->Deletedinvoiceinfo->Customerget();
		$this->load->view('deletedinvoice', $result);
	}
}