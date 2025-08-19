<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class AllocatedMachines extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('AllocatedMachineInfo');
        $this->load->model('Customerinquiryinfo');
        $this->load->model('Machineissuecategoryinfo');

		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['machineList']=$this->AllocatedMachineInfo->Getmachinelist();
        $result['inquiryinfo']=$this->Customerinquiryinfo->GetAllCustomerInquiries();
        $result['issuecategorylist']=$this->Machineissuecategoryinfo->GetIssueCategoryList();
		$this->load->view('allocatedmachines', $result);
	}

    public function GetAllocationData(){
		$this->load->model('AllocatedMachineInfo');
        $result=$this->AllocatedMachineInfo->GetAllocationData();
	}

    public function StartAllocation(){
		$this->load->model('AllocatedMachineInfo');
        $result=$this->AllocatedMachineInfo->StartAllocation();
	}

    public function MachineBreakDown(){
		$this->load->model('AllocatedMachineInfo');
        $result=$this->AllocatedMachineInfo->MachineBreakDown();
	}
    
    public function AllocationComplete(){
		$this->load->model('AllocatedMachineInfo');
        $result=$this->AllocatedMachineInfo->AllocationComplete();
	}

    public function EnterQaIssues(){
		$this->load->model('AllocatedMachineInfo');
        $result=$this->AllocatedMachineInfo->EnterQaIssues();
	}

    public function GetAllocationHours(){
		$this->load->model('AllocatedMachineInfo');
        $result=$this->AllocatedMachineInfo->GetAllocationHours();
	}

    public function EnterHourlyDetails(){
		$this->load->model('AllocatedMachineInfo');
        $result=$this->AllocatedMachineInfo->EnterHourlyDetails();
	}

    public function GetHourlyListData(){
		$this->load->model('AllocatedMachineInfo');
        $result=$this->AllocatedMachineInfo->GetHourlyListData();
	}

    public function GetQaIssueData(){
		$this->load->model('AllocatedMachineInfo');
        $result=$this->AllocatedMachineInfo->GetQaIssueData();
	}
    public function RemoveQaAllocatedIssue(){
		$this->load->model('AllocatedMachineInfo');
        $result=$this->AllocatedMachineInfo->RemoveQaAllocatedIssue();
	}

    public function StartBrokeDownMachine(){
		$this->load->model('AllocatedMachineInfo');
        $result=$this->AllocatedMachineInfo->StartBrokeDownMachine();
	}

}