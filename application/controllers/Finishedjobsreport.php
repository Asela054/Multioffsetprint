<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Colombo');

class Finishedjobsreport extends CI_Controller {

	public function index(){
		$this->load->model('Finishedjobsreportinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['getcustomer']=$this->Finishedjobsreportinfo->Customerget();
		$this->load->view('finishedjobsreport', $result);
	}
}