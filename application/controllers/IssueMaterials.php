<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class IssueMaterials extends CI_Controller {
    public function index(){
		$this->load->model('IssueMaterialsinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('issuematerials',$result);
	}

	public function Fetchinsertedmaterials(){
		$this->load->model('IssueMaterialsinfo');
        $result=$this->IssueMaterialsinfo->Fetchinsertedmaterials();
	}
	public function UpdateStockForMaterialIssue(){
		$this->load->model('IssueMaterialsinfo');
        $result=$this->IssueMaterialsinfo->UpdateStockForMaterialIssue();
	}
	public function ApproveMaterialIssue($x){
		$this->load->model('IssueMaterialsinfo');
        $result=$this->IssueMaterialsinfo->ApproveMaterialIssue($x);
	}
	
}
