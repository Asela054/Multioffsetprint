<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Serviceorder extends CI_Controller {
    public function index(){
		$this->load->model('Serviceorderinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['VehicleRegNo']=$this->Serviceorderinfo->Getvehicleregno();
        $result['Supplier']=$this->Serviceorderinfo->Getsupplier();
		$this->load->view('serviceorder',$result);
	}
   
	public function Serviceorderinsertupdate(){
		$this->load->model('Serviceorderinfo');
        $result=$this->Serviceorderinfo->Serviceorderinsertupdate();
	}
	public function Serviceorderedit(){
		$this->load->model('Serviceorderinfo');
        $result=$this->Serviceorderinfo->Serviceorderedit();
	}
	public function Serviceorderstatus($x, $y){
		$this->load->model('Serviceorderinfo');
        $result=$this->Serviceorderinfo->Serviceorderstatus($x, $y);
	}
	public function Serviceorderstatusapprove($x){
		$this->load->model('Serviceorderinfo');
        $result=$this->Serviceorderinfo->Serviceorderstatusapprove($x);
	}

	
}
