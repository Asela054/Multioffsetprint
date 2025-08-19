<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Machine extends CI_Controller {
    public function index(){
		$this->load->model('Machineinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['Machinecategory']=$this->Machineinfo->GetMachinecategory();
		$result['factorylist']=$this->Machineinfo->Getfactory();
		$this->load->view('machine',$result);
	}
   
	public function Machineinsertupdate(){
		$this->load->model('Machineinfo');
        $result=$this->Machineinfo->Machineinsertupdate();
	}
	public function Machineedit(){
		$this->load->model('Machineinfo');
        $result=$this->Machineinfo->Machineedit();
	}
	public function Machinestatus($x, $y){
		$this->load->model('Machineinfo');
        $result=$this->Machineinfo->Machinestatus($x, $y);
	}
	public function GetMachineList(){
		$this->load->model('Machineinfo');
        $result=$this->Machineinfo->GetMachineList();
	}
}
