<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class MaterialAllocation extends CI_Controller {
    public function index(){
		$this->load->model('Materialallocationinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('materialallocation',$result);
	}
	public function Getcustomerlist(){
        $searchTerm=$this->input->post('searchTerm');
		$result=SearchCustomerList($searchTerm);
	}
	public function Getcustomerinquirylist(){
		$this->load->model('Materialallocationinfo');
        $result=$this->Materialallocationinfo->Getcustomerinquirylist();
	}
	public function GetBomInfoAccoJobId(){
		$this->load->model('Materialallocationinfo');
        $result=$this->Materialallocationinfo->GetBomInfoAccoJobId();
	}
	public function CheckBomMaterialInfo(){
		$this->load->model('Materialallocationinfo');
        $result=$this->Materialallocationinfo->CheckBomMaterialInfo();
	}
	public function Getbatchnolistaccomaterial(){
		$this->load->model('Materialallocationinfo');
        $result=$this->Materialallocationinfo->Getbatchnolistaccomaterial();
	}
	public function Issuematerialinsertupdate(){
		$this->load->model('Materialallocationinfo');
        $result=$this->Materialallocationinfo->Issuematerialinsertupdate();
	}
	public function Getjobissuematerialinfo(){
		$this->load->model('Materialallocationinfo');
        $result=$this->Materialallocationinfo->Getjobissuematerialinfo();
	}
	public function MaterialAllocationapprove(){
		$this->load->model('Materialallocationinfo');
        $result=$this->Materialallocationinfo->MaterialAllocationapprove();
	}	
	public function Jobcardstatus($x, $y){
		$this->load->model('Materialallocationinfo');
        $result=$this->Materialallocationinfo->Jobcardstatus($x, $y);
	}	
	public function jobCardPdf($x){
		$this->load->model('Materialallocationinfo');
        $result=$this->Materialallocationinfo->jobCardPdf($x);
	}	
	public function GetRequestIssueQty(){
		$this->load->model('Materialallocationinfo');
        $result=$this->Materialallocationinfo->GetRequestIssueQty();
	}	
	public function MaterialAllocationcheckstatus(){
		$this->load->model('Materialallocationinfo');
        $result=$this->Materialallocationinfo->MaterialAllocationcheckstatus();
	}	
}
