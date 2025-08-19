<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Jobdetails extends CI_Controller {
    public function index(){
		$recordId = $_GET['recordId'];
		$this->load->model('Jobdetailsinfo');
		$this->load->model('Commeninfo');
		$this->load->model('Customerinquiryinfo');
        $this->load->model('AllocatedMachineInfo');

	}

	public function Jobdetailsinsertupdate(){
		$this->load->model('Jobdetailsinfo');
        $result=$this->Jobdetailsinfo->Jobdetailsinsertupdate();
	}
	public function Jobdetailsstatus($x, $y, $z){
		$this->load->model('Jobdetailsinfo');
        $result=$this->Jobdetailsinfo->Jobdetailsstatus($x, $y, $z);
	}
	public function FetchPassedValue($x){
		$recordId = $x;
		$this->load->model('Jobdetailsinfo');
		$this->load->model('Commeninfo');
		$this->load->model('Customerinquiryinfo');
        $this->load->model('AllocatedMachineInfo');

		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['machineList']=$this->AllocatedMachineInfo->Getmachinelist();

		$result['jobId']=$recordId;
		$result['jobDetails']=$this->Jobdetailsinfo->GetPrimaryJob($recordId);
		$this->load->view('jobdetails',$result);
	}
	public function Jobdetailsedit(){
		$this->load->model('Jobdetailsinfo');
        $result=$this->Jobdetailsinfo->Jobdetailsedit();
	}
	public function FetchJobInfo(){
		$this->load->model('Jobdetailsinfo');
        $result=$this->Jobdetailsinfo->FetchJobInfo();
	}
}
