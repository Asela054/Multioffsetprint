<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Colombo');

class Rptgrn extends CI_Controller {

	public function index(){
		$this->load->model('Rptgrninfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['getsuppier']=$this->Rptgrninfo->Suppliearget();
		$this->load->view('rptgrn', $result);
	}
}