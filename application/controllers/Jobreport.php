<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Colombo');

class Jobreport extends CI_Controller {

	public function index(){
		$this->load->model('Jobreportinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['getcustomer']=$this->Jobreportinfo->Customerget();
		$this->load->view('jobreport', $result);
	}
}