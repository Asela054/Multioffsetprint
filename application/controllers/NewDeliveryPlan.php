<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class NewDeliveryPlan extends CI_Controller {
    public function index(){
		$this->load->model('Newdeliveryplaninfo');
		$this->load->model('Customerinquiryinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['customerlist']=$this->Newdeliveryplaninfo->Getcustomer();
        $result['inquirylist']=$this->Customerinquiryinfo->GetAllCustomerInquiries();
        $result['productlist']=$this->Newdeliveryplaninfo->GetAllProducts();

		$this->load->view('newdeliveryplan',$result);
	}
	public function Deliveryplaninsertupdate(){
		$this->load->model('Newdeliveryplaninfo');
        $result=$this->Newdeliveryplaninfo->Deliveryplaninsertupdate();
	}
	public function GetAllCustomerInquiries(){
		$this->load->model('Newdeliveryplaninfo');
        $result=$this->Newdeliveryplaninfo->GetAllCustomerInquiries();
	}
	public function Deliveryplanedit(){
		$this->load->model('Newdeliveryplaninfo');
        $result=$this->Newdeliveryplaninfo->Deliveryplanedit();
	}
	public function Deliveryplanstatus($x, $y){
		$this->load->model('Newdeliveryplaninfo');
        $result=$this->Newdeliveryplaninfo->Deliveryplanstatus($x, $y);
	}
	public function Deliveryplanlistedit(){
		$this->load->model('Newdeliveryplaninfo');
        $result=$this->Newdeliveryplaninfo->Deliveryplanlistedit();
	}
	public function Deliveryplanlistitemsedit(){
		$this->load->model('Newdeliveryplaninfo');
        $result=$this->Newdeliveryplaninfo->Deliveryplanlistitemsedit();
	}
	public function Deliveryplanviewjoblist(){
		$this->load->model('Newdeliveryplaninfo');
        $result=$this->Newdeliveryplaninfo->Deliveryplanviewjoblist();
	}
	public function Deliveryplanviewmateriallist(){
		$this->load->model('Newdeliveryplaninfo');
        $result=$this->Newdeliveryplaninfo->Deliveryplanviewmateriallist();
	}
    public function GetInquiryDetails(){
		$this->load->model('Newdeliveryplaninfo');
        $result=$this->Newdeliveryplaninfo->GetInquiryDetails();
        echo json_encode($result);
	}
    public function GetPlanDetails(){
		$this->load->model('Newdeliveryplaninfo');
        $result=$this->Newdeliveryplaninfo->GetPlanDetails();
        echo json_encode($result);
	}
    public function AllocationInsertUpdate(){
		$this->load->model('Newdeliveryplaninfo');
		$result=$this->Newdeliveryplaninfo->AllocationInsertUpdate();
	}
	public function Completedeliveryplanviewjoblist(){
		$this->load->model('Newdeliveryplaninfo');
        $result=$this->Newdeliveryplaninfo->Completedeliveryplanviewjoblist();
	}
	public function Completedeliveryplanviewmateriallist(){
		$this->load->model('Newdeliveryplaninfo');
        $result=$this->Newdeliveryplaninfo->Completedeliveryplanviewmateriallist();
	}
	public function GetMachineAllocationSummary(){
		$this->load->model('Newdeliveryplaninfo');
        $result=$this->Newdeliveryplaninfo->GetMachineAllocationSummary();
	}
	public function CompleteSelectedDelivery(){
		$this->load->model('Newdeliveryplaninfo');
        $result=$this->Newdeliveryplaninfo->CompleteSelectedDelivery();
	}
}