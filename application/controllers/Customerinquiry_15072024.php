<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Customerinquiry extends CI_Controller {
    public function index(){
		$this->load->model('Customerinquiryinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['customerlist']=$this->Customerinquiryinfo->Getcustomer();
		$result['companylist']=$this->Customerinquiryinfo->Getcompany();
		$result['branchlist']=$this->Customerinquiryinfo->Getcompanybranch();
		$result['jobname']=$this->Customerinquiryinfo->Getjobs();
		$result['measurelist']=$this->Customerinquiryinfo->Getmeasuretype();
		$this->load->view('customerinquiry',$result);
	}
   
	public function Customerinquiryinsertupdate(){
		$this->load->model('Customerinquiryinfo');
        $result=$this->Customerinquiryinfo->Customerinquiryinsertupdate();
	}
	public function GetAllCustomerInquiries(){
		$this->load->model('Customerinquiryinfo');
        $result=$this->Customerinquiryinfo->GetAllCustomerInquiries();
	}
	public function Customerinquiryedit(){
		$this->load->model('Customerinquiryinfo');
        $result=$this->Customerinquiryinfo->Customerinquiryedit();
	}
	public function Customerinquirystatus($x, $y){
		$this->load->model('Customerinquiryinfo');
        $result=$this->Customerinquiryinfo->Customerinquirystatus($x, $y);
	}
	public function Customerinquiryjobedit(){
		$this->load->model('Customerinquiryinfo');
        $result=$this->Customerinquiryinfo->Customerinquiryjobedit();
	}
	public function Customerinquiryjoblistedit(){
		$this->load->model('Customerinquiryinfo');
        $result=$this->Customerinquiryinfo->Customerinquiryjoblistedit();
	}
	public function Getcustomejobs(){
		$this->load->model('Customerinquiryinfo');
        $result=$this->Customerinquiryinfo->Getcustomejobs();
	}
	public function Getjobuom(){
		$this->load->model('Customerinquiryinfo');
        $result=$this->Customerinquiryinfo->Getjobuom();
	}
	public function Customerinquiryviewjoblist(){
		$this->load->model('Customerinquiryinfo');
        $result=$this->Customerinquiryinfo->Customerinquiryviewjoblist();
	}
	
}
