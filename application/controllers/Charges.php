<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Colombo');

class Charges extends CI_Controller {
	public function index(){
		$this->load->model('Chargesinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('charges', $result);
	}
	public function Chargesinsertupdate(){
		$this->load->model('Chargesinfo');
        $result=$this->Chargesinfo->Chargesinsertupdate();
	}
	public function Chargesedit(){
		$this->load->model('Chargesinfo');
        $result=$this->Chargesinfo->Chargesedit();
	}
	public function Chargesstatus($x, $y){
		$this->load->model('Chargesinfo');
        $result=$this->Chargesinfo->Chargesstatus($x, $y);
	}
}
