<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class JobSummaryReport extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Jobsummaryreportinfo');
        // $this->load->model('Customerinquiryinfo');
        $this->load->model('Customerinfo');

		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['machine']=$this->Jobsummaryreportinfo->Getmachinelist();
        $result['employee']=$this->Jobsummaryreportinfo->Getemployeelist();
        // $result['inquiryinfo']=$this->Customerinquiryinfo->GetAllCustomerInquiries();
        $result['customerlist']=$this->Jobsummaryreportinfo->GetCustomerList();
		$this->load->view('jobsummaryreport', $result);
	}

    public function Machineinsertupdate(){
		$this->load->model('Jobsummaryreportinfo');
        $result=$this->Jobsummaryreportinfo->Machineinsertupdate();
	}

    public function Checkmachineavailability(){
		$this->load->model('Jobsummaryreportinfo');
        $result=$this->Jobsummaryreportinfo->Checkmachineavailability();
	}

    public function Checkissueqty(){
		$this->load->model('Jobsummaryreportinfo');
        $result=$this->Jobsummaryreportinfo->Checkissueqty();
	}
  
    public function GetInquieryDetails(){
		$this->load->model('Jobsummaryreportinfo');
        $result=$this->Jobsummaryreportinfo->GetInquieryDetails();
        echo json_encode($result);
	}

    public function GetCostItemData(){
		$this->load->model('Jobsummaryreportinfo');
        $result=$this->Jobsummaryreportinfo->GetCostItemData();
        echo json_encode($result);

	}

    public function FetchItemDataForAllocation(){
		$this->load->model('Jobsummaryreportinfo');
        $result=$this->Jobsummaryreportinfo->FetchItemDataForAllocation();
	}
    

    public function GetDeliveryPlanDetails(){
		$this->load->model('Jobsummaryreportinfo');
        $result=$this->Jobsummaryreportinfo->GetDeliveryPlanDetails();
        echo json_encode($result);
	}

    public function GetJobsAccoCustomer(){
		$this->load->model('Jobsummaryreportinfo');
        $result=$this->Jobsummaryreportinfo->GetJobsAccoCustomer();
        echo json_encode($result);
	}

    public function FetchDeliveryPlanData(){
		$this->load->model('Jobsummaryreportinfo');
        $result=$this->Jobsummaryreportinfo->FetchDeliveryPlanData();
	}

    public function FetchAllocationData(){
		$this->load->model('Jobsummaryreportinfo');
        $result=$this->Jobsummaryreportinfo->FetchAllocationData();
	}
   

}