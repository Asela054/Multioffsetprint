<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Colombo');

class Unfinishedjobsreport extends CI_Controller {

	public function index(){
		$this->load->model('Unfinishedjobsreportinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['getcustomer']=$this->Unfinishedjobsreportinfo->Customerget();
		$this->load->view('unfinishedjobsreport', $result);
	}
}