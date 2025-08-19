<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Colombo');

class MachineService extends CI_Controller {

	public function index(){
		 $this->load->model('Machineserviceinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['machine']=$this->Machineserviceinfo->Getmachinename();
		$this->load->view('machineservice', $result);
	}

	public function Machineserviceinsertupdate(){
		$this->load->model('Machineserviceinfo');
        $result=$this->Machineserviceinfo->Machineserviceinsertupdate();
	}

	public function Machineserviceedit(){
		$this->load->model('Machineserviceinfo');
        $result=$this->Machineserviceinfo->Machineserviceedit();
	}
    
	public function Machineservicestatus($x, $y){
		$this->load->model('Machineserviceinfo');
        $result=$this->Machineserviceinfo->Machineservicestatus($x, $y);
	}

}
