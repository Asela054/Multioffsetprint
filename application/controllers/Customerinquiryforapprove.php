<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Customerinquiryforapprove extends CI_Controller {
    public function index(){
		$this->load->model('Customerinquiryforapproveinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['customerlist']=$this->Customerinquiryforapproveinfo->Getcustomer();
		$this->load->view('customerinquiryforapprove',$result);
	}
   
	public function Customerinquiryapproveinsertupdate(){
		$this->load->model('Customerinquiryforapproveinfo');
        $result=$this->Customerinquiryforapproveinfo->Customerinquiryapproveinsertupdate();
	}
	public function Customerinquiryapproveedit(){
		$this->load->model('Customerinquiryforapproveinfo');
        $result=$this->Customerinquiryforapproveinfo->Customerinquiryapproveedit();
	}
	public function Customerinquiryapprovestatus($x, $y){
		$this->load->model('Customerinquiryforapproveinfo');
        $result=$this->Customerinquiryforapproveinfo->Customerinquiryapprovestatus($x, $y);
	}
	public function Customerinquiryapprovejobedit(){
		$this->load->model('Customerinquiryforapproveinfo');
        $result=$this->Customerinquiryforapproveinfo->Customerinquiryapprovejobedit();
	}
	public function Customerinquiryapprovejoblistedit(){
		$this->load->model('Customerinquiryforapproveinfo');
        $result=$this->Customerinquiryforapproveinfo->Customerinquiryapprovejoblistedit();
	}

	public function Customerinquiryapprovestatusapprove($x){
		$this->load->model('Customerinquiryforapproveinfo');
        $result=$this->Customerinquiryforapproveinfo->Customerinquiryapprovestatusapprove($x);
	}

	public function Customerinquiryviewjoblist(){
		$this->load->model('Customerinquiryinfo');
        $result=$this->Customerinquiryinfo->Customerinquiryviewjoblist();
	}
	
}
