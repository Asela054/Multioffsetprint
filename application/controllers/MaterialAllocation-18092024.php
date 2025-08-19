<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class MaterialAllocation extends CI_Controller {
    public function index(){
		$this->load->model('Materialallocationinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['customerlist']=$this->Materialallocationinfo->Getcustomerlist();
		$result['materiallist']=$this->Materialallocationinfo->GetMaterialList();
		$this->load->view('materialallocation',$result);
	}
   
	public function Suppliertypeinsertupdate(){
		$this->load->model('Materialallocationinfo');
        $result=$this->Materialallocationinfo->Suppliertypeinsertupdate();
	}
	public function Suppliertypeedit(){
		$this->load->model('Materialallocationinfo');
        $result=$this->Materialallocationinfo->Suppliertypeedit();
	}
	public function Getmaterialdetailsforqutation(){
		$this->load->model('Materialallocationinfo');
        $result=$this->Materialallocationinfo->Getmaterialdetailsforqutation();
	}
	public function Suppliertypestatus($x, $y){
		$this->load->model('Materialallocationinfo');
        $result=$this->Materialallocationinfo->Suppliertypestatus($x, $y);
	}

	public function Getcustomerjobs(){
		$this->load->model('Materialallocationinfo');
        $result=$this->Materialallocationinfo->Getcustomerjobs();
	}
	public function Getjobvisequotations(){
		$this->load->model('Materialallocationinfo');
        $result=$this->Materialallocationinfo->Getjobvisequotations();
	}
	public function Getquotationdetailsfortable(){
		$this->load->model('Materialallocationinfo');
        $result=$this->Materialallocationinfo->Getquotationdetailsfortable();
	}
	public function Insertupdateallocatedmaterials(){
		$this->load->model('Materialallocationinfo');
        $result=$this->Materialallocationinfo->Insertupdateallocatedmaterials();
	}
	public function GetAllocationdetailsformodal(){
		$this->load->model('Materialallocationinfo');
        $result=$this->Materialallocationinfo->GetAllocationdetailsformodal();
	}
	
	public function ApproveAllocatedQuotation($x){
		$this->load->model('Materialallocationinfo');
        $result=$this->Materialallocationinfo->ApproveAllocatedQuotation($x);
	}
	
}
