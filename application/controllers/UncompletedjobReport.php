<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Colombo');

class UncompletedjobReport extends CI_Controller {

	public function index(){
		$this->load->model('UncompletedjobReportinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['getcustomer']=$this->UncompletedjobReportinfo->Customerget();
		$this->load->view('uncompletedjobreport', $result);
	}
}