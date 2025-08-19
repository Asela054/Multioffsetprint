<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Vehiclerenewforapprove extends CI_Controller {
    public function index(){
		$this->load->model('Vehiclerenewforapproveinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['VehicleRegNo']=$this->Vehiclerenewforapproveinfo->Getvehicleregno();
        $result['Supplier']=$this->Vehiclerenewforapproveinfo->Getsupplier();
		$this->load->view('vehiclerenewforapprove',$result);
	}
   
	public function Vehiclerenewforapproveinsertupdate(){
		$this->load->model('Vehiclerenewforapproveinfo');
        $result=$this->Vehiclerenewforapproveinfo->Vehiclerenewforapproveinsertupdate();
	}
	public function Vehiclerenewforapproveedit(){
		$this->load->model('Vehiclerenewforapproveinfo');
        $result=$this->Vehiclerenewforapproveinfo->Vehiclerenewforapproveedit();
	}
	public function Vehiclerenewforapprovestatus($x, $y){
		$this->load->model('Vehiclerenewforapproveinfo');
        $result=$this->Vehiclerenewforapproveinfo->Vehiclerenewforapprovestatus($x, $y);
	}
    public function Vehiclerenewforapprovestatusapprove($x){
		$this->load->model('Vehiclerenewforapproveinfo');
        $result=$this->Vehiclerenewforapproveinfo->Vehiclerenewforapprovestatusapprove($x);
	}
	
}
