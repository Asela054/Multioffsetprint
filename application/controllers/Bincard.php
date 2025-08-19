<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Colombo');

class Bincard extends CI_Controller {

	public function index(){
		$this->load->model('Bincardinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['getmaterial']=$this->Bincardinfo->Materialget();
		$this->load->view('bincard', $result);
	}

	public function bincardReport() {
		$this->load->model('Bincardinfo');
		$result=$this->Bincardinfo->bincardReport();
	}
}