<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Machinealloction extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Machineallocationinfo');
        $this->load->model('Customerinquiryinfo');

		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['machine']=$this->Machineallocationinfo->Getmachinelist();
        $result['inquiryinfo']=$this->Customerinquiryinfo->GetAllCustomerInquiries();
		$this->load->view('machineallocation', $result);
	}

    public function Machineinsertupdate(){
		$this->load->model('Machineallocationinfo');
        $result=$this->Machineallocationinfo->Machineinsertupdate();
	}

    public function Checkmachineavailability(){
		$this->load->model('Machineallocationinfo');
        $result=$this->Machineallocationinfo->Checkmachineavailability();
	}

    public function Checkissueqty(){
		$this->load->model('Machineallocationinfo');
        $result=$this->Machineallocationinfo->Checkissueqty();
	}
    public function FetchAllocationData(){
		$this->load->model('Machineallocationinfo');
        $result=$this->Machineallocationinfo->FetchAllocationData();
	}
   
    public function GetInquieryDetails(){
		$this->load->model('Machineallocationinfo');
        $result=$this->Machineallocationinfo->GetInquieryDetails();
        echo json_encode($result);
	}

    public function GetCostItemData(){
		$this->load->model('Machineallocationinfo');
        $result=$this->Machineallocationinfo->GetCostItemData();
        echo json_encode($result);

	}

    public function FetchItemDataForAllocation(){
		$this->load->model('Machineallocationinfo');
        $result=$this->Machineallocationinfo->FetchItemDataForAllocation();
	}

    public function GetDeliveryPlanDetails(){
		$this->load->model('Machineallocationinfo');
        $result=$this->Machineallocationinfo->GetDeliveryPlanDetails();
        echo json_encode($result);
	}

}