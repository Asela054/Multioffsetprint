<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class JobCardAllocation extends CI_Controller {
    public function index(){
		$this->load->model('Jobcardallocationinfo');
		$this->load->model('Materialallocationinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['measurelist']=$this->Jobcardallocationinfo->Getmeasuretype();
		$result['customerlist']=$this->Materialallocationinfo->Getcustomerlist();
		$result['materiallist']=$this->Jobcardallocationinfo->Getmateriallist();
		$result['printingformatlist']=$this->Jobcardallocationinfo->Getprintingformatlist();
		$result['colorlist']=$this->Jobcardallocationinfo->Getcolorlist();
		$result['varnishlist']=$this->Jobcardallocationinfo->Getvarnishlist();
		$result['laminationlist']=$this->Jobcardallocationinfo->Getlaminationlist();
		$result['foilinglist']=$this->Jobcardallocationinfo->Getfoilinglist();
		$result['rimminglist']=$this->Jobcardallocationinfo->Getrimminglist();
		$result['otherfinishinglist']=$this->Jobcardallocationinfo->Getotherfinishinglist();
		$result['diecuttinglist']=$this->Jobcardallocationinfo->Getdiecuttinglist();
		$result['pastinglist']=$this->Jobcardallocationinfo->Getpastinglist();
		$result['binderylist']=$this->Jobcardallocationinfo->Getbinderylist();
		$this->load->view('jobcardallocation',$result);
	}
   

	public function InsertJobCardAllocation(){
		$this->load->model('Jobcardallocationinfo');
        $result=$this->Jobcardallocationinfo->InsertJobCardAllocation();
	}
	public function Getcustomerjobs(){
		$this->load->model('Jobcardallocationinfo');
        $result=$this->Jobcardallocationinfo->Getcustomerjobs();
	}
	public function GetJobCardPrint(){
		$this->load->model('Jobcardallocationinfo');
        $result=$this->Jobcardallocationinfo->GetJobCardPrint();
	}
	public function ApproveJobCard($x){
		$this->load->model('Jobcardallocationinfo');
        $result=$this->Jobcardallocationinfo->ApproveJobCard($x);
	}
	public function IssueStock($x){
		$this->load->model('Jobcardallocationinfo');
        $result=$this->Jobcardallocationinfo->IssueStock($x);
	}
	public function GetNonValidatedAccounts(){
		$this->load->model('Jobcardallocationinfo');
        $result=$this->Jobcardallocationinfo->GetNonValidatedAccounts();
	}
	public function TransferToAccounts(){
		$this->load->model('Jobcardallocationinfo');
        $result=$this->Jobcardallocationinfo->TransferToAccounts();
	}
	public function GetJobBOMDetails(){
		$this->load->model('Jobcardallocationinfo');
        $result=$this->Jobcardallocationinfo->GetJobBOMDetails();
	}
	public function Getbatchnolistaccomaterial(){
		$this->load->model('Jobcardallocationinfo');
        $result=$this->Jobcardallocationinfo->Getbatchnolistaccomaterial();
	}
}
