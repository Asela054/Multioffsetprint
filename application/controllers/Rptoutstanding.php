<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Colombo');

class Rptoutstanding extends CI_Controller {

	public function index(){
		$this->load->model('Rptoutstandinginfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['getcustomer']=$this->Rptoutstandinginfo->Customerget();
		$this->load->view('rptoutstanding', $result);
	}
}