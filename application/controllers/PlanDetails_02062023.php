<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class PlanDetails extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Customerinquiryinfo');
        $this->load->model('Plandetailsinfo');

        $result['inquirylist']=$this->Customerinquiryinfo->GetAllCustomerInquiries();
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['machineList']=$this->Plandetailsinfo->Getmachinelist();
   
		$this->load->view('plandetails', $result);
	}

    public function GetInquiryDetails(){
		$this->load->model('Plandetailsinfo');
        $result=$this->Plandetailsinfo->GetInquiryDetails();
        echo json_encode($result);
	}
    public function GetJobList(){
		$this->load->model('Plandetailsinfo');
        $result=$this->Plandetailsinfo->GetJobList();
	}
    public function GetDeliveryPlanDetails(){
		$this->load->model('Plandetailsinfo');
        $result=$this->Plandetailsinfo->GetDeliveryPlanDetails();
	}


}