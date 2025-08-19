<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class ProductFinish extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Customerinquiryinfo');
        $this->load->model('ProductFinishinfo');

        $result['inquirylist']=$this->Customerinquiryinfo->GetAllCustomerInquiries();
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['machineList']=$this->ProductFinishinfo->Getmachinelist();
   
		$this->load->view('productfinish', $result);
	}

    public function GetInquiryDetails(){
		$this->load->model('ProductFinishinfo');
        $result=$this->ProductFinishinfo->GetInquiryDetails();
        echo json_encode($result);
	}
    public function Getdeliveryplanlist(){
		$this->load->model('ProductFinishinfo');
        $result=$this->ProductFinishinfo->Getdeliveryplanlist();
	}


}