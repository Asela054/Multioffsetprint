<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Colombo');

class Materialissuereport extends CI_Controller {

	public function index(){
		$this->load->model('Materialissuereportinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['getcustomer']=$this->Materialissuereportinfo->Customerget();
		$this->load->view('materialissuereport', $result);
	}
}