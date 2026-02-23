<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class MaterialAllocationManual extends CI_Controller {
    public function index(){
		$this->load->model('MaterialAllocationManualinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('materialallocationmanual',$result);
	}
	public function Getcustomerlist(){
        $searchTerm=$this->input->post('searchTerm');
		$result=SearchCustomerList($searchTerm);
	}
	public function Getcustomerinquirylist(){
		$this->load->model('MaterialAllocationManualinfo');
        $result=$this->MaterialAllocationManualinfo->Getcustomerinquirylist();
	}
	public function GetBomInfoAccoJobId(){
		$this->load->model('MaterialAllocationManualinfo');
        $result=$this->MaterialAllocationManualinfo->GetBomInfoAccoJobId();
	}
	public function CheckBomMaterialInfo(){
		$this->load->model('MaterialAllocationManualinfo');
        $result=$this->MaterialAllocationManualinfo->CheckBomMaterialInfo();
	}
	public function Getbatchnolistaccomaterial(){
		$this->load->model('MaterialAllocationManualinfo');
        $result=$this->MaterialAllocationManualinfo->Getbatchnolistaccomaterial();
	}
	public function Issuematerialinsertupdate(){
		$this->load->model('MaterialAllocationManualinfo');
        $result=$this->MaterialAllocationManualinfo->Issuematerialinsertupdate();
	}
	public function Getjobissuematerialinfo(){
		$this->load->model('MaterialAllocationManualinfo');
        $result=$this->MaterialAllocationManualinfo->Getjobissuematerialinfo();
	}
	public function MaterialAllocationManualapprove(){
		$this->load->model('MaterialAllocationManualinfo');
        $result=$this->MaterialAllocationManualinfo->MaterialAllocationManualapprove();
	}	
	public function Jobcardstatus($x, $y){
		$this->load->model('MaterialAllocationManualinfo');
        $result=$this->MaterialAllocationManualinfo->Jobcardstatus($x, $y);
	}	
	public function jobCardPdf($x){
		$this->load->model('MaterialAllocationManualinfo');
        $result=$this->MaterialAllocationManualinfo->jobCardPdf($x);
	}	
	public function GetRequestIssueQty(){
		$this->load->model('MaterialAllocationManualinfo');
        $result=$this->MaterialAllocationManualinfo->GetRequestIssueQty();
	}	
	public function MaterialAllocationManualcheckstatus(){
		$this->load->model('MaterialAllocationManualinfo');
        $result=$this->MaterialAllocationManualinfo->MaterialAllocationManualcheckstatus();
	}
	public function GetManualAllocationDetails(){
		$this->load->model('MaterialAllocationManualinfo');
        $result=$this->MaterialAllocationManualinfo->GetManualAllocationDetails();
	}
	
	
	public function GetMaterialList(){
		$searchTerm=$this->input->post('searchTerm');
		$searchCategory=json_decode($this->input->post('searchCategory'));
		$result=GetMaterialList($searchTerm, $searchCategory);
	}
}
