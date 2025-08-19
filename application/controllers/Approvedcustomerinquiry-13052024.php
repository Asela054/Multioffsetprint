<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Approvedcustomerinquiry extends CI_Controller {
    public function index(){
		$this->load->model('Approvedcustomerinquiryinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('approvedcustomerinquiry',$result);
	}
   
	public function Approvedcustomerinquiryedit(){
		$this->load->model('Approvedcustomerinquiryinfo');
        $result=$this->Approvedcustomerinquiryinfo->Approvedcustomerinquiryedit();
	}
	public function Approvedcustomerinquirystatus($x, $y){
		$this->load->model('Approvedcustomerinquiryinfo');
        $result=$this->Approvedcustomerinquiryinfo->Approvedcustomerinquirystatus($x, $y);
	}
	public function Approvedcustomerinquiryjobedit(){
		$this->load->model('Approvedcustomerinquiryinfo');
        $result=$this->Approvedcustomerinquiryinfo->Approvedcustomerinquiryjobedit();
	}
	
}
