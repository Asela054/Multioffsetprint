<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class MachineIssueCategory extends CI_Controller {
    public function index(){
		$this->load->model('Machineissuecategoryinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('machineissuecategory',$result);
	}
   
	public function Machineissuecategoryinsertupdate(){
		$this->load->model('Machineissuecategoryinfo');
        $result=$this->Machineissuecategoryinfo->Machineissuecategoryinsertupdate();
	}
	public function Machineissuecategoryedit(){
		$this->load->model('Machineissuecategoryinfo');
        $result=$this->Machineissuecategoryinfo->Machineissuecategoryedit();
	}
	public function Machineissuecategorystatus($x, $y){
		$this->load->model('Machineissuecategoryinfo');
        $result=$this->Machineissuecategoryinfo->Machineissuecategorystatus($x, $y);
	}
	public function GetIssueCategoryList($x, $y){
		$this->load->model('Machineissuecategoryinfo');
        $result=$this->Machineissuecategoryinfo->GetIssueCategoryList($x, $y);
	}
	
}
