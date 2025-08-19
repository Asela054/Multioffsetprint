<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Customerinquiry extends CI_Controller {
    public function index(){
		$this->load->model('Customerinquiryinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['jobname']=$this->Customerinquiryinfo->Getjobs();
		$result['measurelist']=$this->Customerinquiryinfo->Getmeasuretype();
		$this->load->view('customerinquiry',$result);
	}
	public function Getcustomerlist(){
        $searchTerm=$this->input->post('searchTerm');
		$result=SearchCustomerList($searchTerm);
	}	
	public function Getjobuom(){
		$this->load->model('Customerinquiryinfo');
        $result=$this->Customerinquiryinfo->Getjobuom();
	}
	public function Customerinquiryinsertupdate(){
		$this->load->model('Customerinquiryinfo');
        $result=$this->Customerinquiryinfo->Customerinquiryinsertupdate();
	}
	public function Customerinquiryedit(){
		$this->load->model('Customerinquiryinfo');
        $result=$this->Customerinquiryinfo->Customerinquiryedit();
	}
	public function Customerinquiryapprove(){
		$this->load->model('Customerinquiryinfo');
        $result=$this->Customerinquiryinfo->Customerinquiryapprove();
	}
	public function Getcustomejobs(){
		$this->load->model('Customerinquiryinfo');
        $result=$this->Customerinquiryinfo->Getcustomejobs();
	}
	

	
	
	public function GetAllCustomerInquiries(){
		$this->load->model('Customerinquiryinfo');
        $result=$this->Customerinquiryinfo->GetAllCustomerInquiries();
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
	
	
	public function Customerinquiryviewjoblist(){
		$this->load->model('Customerinquiryinfo');
        $result=$this->Customerinquiryinfo->Customerinquiryviewjoblist();
	}
	public function Getcompanybranch(){
		$this->load->model('Customerinquiryinfo');
        $result=$this->Customerinquiryinfo->Getcompanybranch();
	}
	
}
