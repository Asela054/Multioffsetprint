<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Vehiclemodel extends CI_Controller {
    public function index(){
	    $this->load->model('Vehiclemodelinfo');
		$this->load->model('Commeninfo');
		 $result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('vehiclemodel',$result);
	}
   
	public function Vehiclemodelinsertupdate(){
		$this->load->model('Vehiclemodelinfo');
        $result=$this->Vehiclemodelinfo->Vehiclemodelinsertupdate();
	}
	public function Vehiclemodeledit(){
		$this->load->model('Vehiclemodelinfo');
        $result=$this->Vehiclemodelinfo->Vehiclemodeledit();
	}
	public function Vehiclemodelstatus($x, $y){
		$this->load->model('Vehiclemodelinfo');
        $result=$this->Vehiclemodelinfo->Vehiclemodelstatus($x, $y);
	}
	
}