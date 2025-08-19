<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Newpurchaserequest extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Newpurchaserequestinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['locationlist']=$this->Newpurchaserequestinfo->Getlocation();
		$result['supplierlist']=$this->Newpurchaserequestinfo->Getsupplier();
		$result['ordertypelist']=$this->Newpurchaserequestinfo->Getordertype();
		$result['servicetypelist']=$this->Newpurchaserequestinfo->Getservicetype();
		$result['measurelist']=$this->Newpurchaserequestinfo->Getmeasuretype();
		$this->load->view('newpurchaserequest', $result);
	}
    public function Newpurchaserequestinsertupdate(){
		$this->load->model('Newpurchaserequestinfo');
        $result=$this->Newpurchaserequestinfo->Newpurchaserequestinsertupdate();
	}
    public function Newpurchaserequeststatus(){
		$this->load->model('Newpurchaserequestinfo');
        $result=$this->Newpurchaserequestinfo->Newpurchaserequeststatus();
	}
    // public function Purchaseorderedit(){
	// 	$this->load->model('Newpurchaserequestinfo');
    //     $result=$this->Newpurchaserequestinfo->Purchaseorderedit();
	// }
    public function Getproductaccosupplier(){
		$this->load->model('Newpurchaserequestinfo');
        $result=$this->Newpurchaserequestinfo->Getproductaccosupplier();
	}
	public function Getsparepartaccosupplier(){
		$this->load->model('Newpurchaserequestinfo');
        $result=$this->Newpurchaserequestinfo->Getsparepartaccosupplier();
	}
	public function Getproductforvehicle(){
		$this->load->model('Newpurchaserequestinfo');
        $result=$this->Newpurchaserequestinfo->Getproductforvehicle();
	}
	public function Getproductformachine(){
		$this->load->model('Newpurchaserequestinfo');
        $result=$this->Newpurchaserequestinfo->Getproductformachine();
	}
	public function Getproductforsparepart(){
		$this->load->model('Newpurchaserequestinfo');
        $result=$this->Newpurchaserequestinfo->Getproductforsparepart();
	}
	public function Getproductprice(){
		$this->load->model('Newpurchaserequestinfo');
        $result=$this->Newpurchaserequestinfo->Getproductprice();
	}
	public function Getproductpricespare(){
		$this->load->model('Newpurchaserequestinfo');
        $result=$this->Newpurchaserequestinfo->Getproductpricespare();
	}
    public function Purchaseorderview(){
		$this->load->model('Newpurchaserequestinfo');
        $result=$this->Newpurchaserequestinfo->Purchaseorderview();
	}
	public function porderviewheader(){
		$this->load->model('Newpurchaserequestinfo');
        $result=$this->Newpurchaserequestinfo->porderviewheader();
	}
	public function Printinvoice($x){
		$this->load->model('PorderreqPrintinfo');
        $result=$this->PorderreqPrintinfo->Printinvoice($x);
	}
}
