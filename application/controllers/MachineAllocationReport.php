<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class MachineAllocationReport extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('AllocatedMachineInfo');
        $this->load->model('Customerinquiryinfo');
        $this->load->model('Machineissuecategoryinfo');

		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['machineList']=$this->AllocatedMachineInfo->Getmachinelist();
        $result['inquiryinfo']=$this->Customerinquiryinfo->GetAllCustomerInquiries();
        $result['issuecategorylist']=$this->Machineissuecategoryinfo->GetIssueCategoryList();
		$this->load->view('machineallocationreport', $result);
	}
}