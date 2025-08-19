<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class OrderReconsilation extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Customerinquiryinfo');
        $this->load->model('OrderReconsilationinfo');

        $result['inquirylist']=$this->Customerinquiryinfo->GetAllCustomerInquiries();
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['machineList']=$this->OrderReconsilationinfo->Getmachinelist();
   
		$this->load->view('orderreconsilation', $result);
	}

    public function GetInquiryDetails(){
		$this->load->model('OrderReconsilationinfo');
        $result=$this->OrderReconsilationinfo->GetInquiryDetails();
        echo json_encode($result);
	}
    public function GetJobList(){
		$this->load->model('OrderReconsilationinfo');
        $result=$this->OrderReconsilationinfo->GetJobList();
	}


}