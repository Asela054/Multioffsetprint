<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Colombo');

class Chargesdetail extends CI_Controller {
	public function index(){
		$this->load->model('Chargesdetailinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['chargestype']=$this->Chargesdetailinfo->Getchargestype();
		$this->load->view('chargesdetail', $result);
	}
	public function Chargesdetailinsertupdate(){
		$this->load->model('Chargesdetailinfo');
        $result=$this->Chargesdetailinfo->Chargesdetailinsertupdate();
	}
	public function Chargesdetailedit(){
		$this->load->model('Chargesdetailinfo');
        $result=$this->Chargesdetailinfo->Chargesdetailedit();
	}
	public function Chargesdetailstatus($x, $y){
		$this->load->model('Chargesdetailinfo');
        $result=$this->Chargesdetailinfo->Chargesdetailstatus($x, $y);
	}
}
