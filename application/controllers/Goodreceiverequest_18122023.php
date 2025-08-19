<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Goodreceiverequest extends CI_Controller {
    public function index(){
		$this->load->model('Goodreceiverequestinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		// $result['companylist']=$this->Goodreceiverequestinfo->Getcompany();
		$result['departmentlist']=$this->Goodreceiverequestinfo->Getdepartment();
		$result['supplierlist']=$this->Goodreceiverequestinfo->Getsupplier();
		$result['ordertypelist']=$this->Goodreceiverequestinfo->Getordertype();
		$result['servicetypelist']=$this->Goodreceiverequestinfo->Getservicetype();
		$result['locationlist']=$this->Goodreceiverequestinfo->Getlocation();
		$this->load->view('goodreceiverequest',$result);
	}
   
	public function Goodreceiverequestinsertupdate(){
		$this->load->model('Goodreceiverequestinfo');
        $result=$this->Goodreceiverequestinfo->Goodreceiverequestinsertupdate();
	}
    public function Goodreceiverequeststatus($x, $y){
		$this->load->model('Goodreceiverequestinfo');
        $result=$this->Goodreceiverequestinfo->Goodreceiverequeststatus($x, $y);
	}
    // public function Purchaseorderedit(){
	// 	$this->load->model('Newpurchaserequestinfo');
    //     $result=$this->Newpurchaserequestinfo->Purchaseorderedit();
	// }
    public function Getproductaccosupplier(){
		$this->load->model('Goodreceiverequestinfo');
        $result=$this->Goodreceiverequestinfo->Getproductaccosupplier();
	}
	public function Getproductforvehicle(){
		$this->load->model('Goodreceiverequestinfo');
        $result=$this->Goodreceiverequestinfo->Getproductforvehicle();
	}
	public function Getproductformachine(){
		$this->load->model('Goodreceiverequestinfo');
        $result=$this->Goodreceiverequestinfo->Getproductformachine();
	}
	// public function Getservicetype(){
	// 	$this->load->model('Purchaseorderinfo');
    //     $result=$this->Purchaseorderinfo->Getservicetype();
	// }
    public function Grnorderview(){
		$this->load->model('Goodreceiverequestinfo');
        $result=$this->Goodreceiverequestinfo->Grnorderview();
	}
	public function porderviewheader(){
		$this->load->model('Goodreceiverequestinfo');
        $result=$this->Goodreceiverequestinfo->porderviewheader();
	}
	public function Printinvoice($x){
		$this->load->model('InvoicePrintinfo');
        $result=$this->InvoicePrintinfo->Printinvoice($x);
	}
}
