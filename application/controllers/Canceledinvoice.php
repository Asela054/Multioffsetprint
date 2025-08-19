<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Colombo');

class Canceledinvoice extends CI_Controller {

	public function index(){
		$this->load->model('Canceledinvoiceinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['getcustomer']=$this->Canceledinvoiceinfo->Customerget();
		$this->load->view('canceledinvoice', $result);
	}
}