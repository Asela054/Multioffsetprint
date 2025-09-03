<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class StockReport extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Stockreportinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['locationlist']=$this->Stockreportinfo->Getlocation();
		$result['supplierlist']=$this->Stockreportinfo->Getsupplier();
		$result['ordertypelist']=$this->Stockreportinfo->Getordertype();
		$this->load->view('stockreport', $result);
	}
    public function Purchaseorderinsertupdate(){
		$this->load->model('Stockreportinfo');
        $result=$this->Stockreportinfo->Purchaseorderinsertupdate();
	}
    public function Purchaseorderstatus($x, $y){
		$this->load->model('Stockreportinfo');
        $result=$this->Stockreportinfo->Purchaseorderstatus($x, $y);
	}
    public function Purchaseorderedit(){
		$this->load->model('Stockreportinfo');
        $result=$this->Stockreportinfo->Purchaseorderedit();
	}
    public function Getproductaccosupplier(){
		$this->load->model('Stockreportinfo');
        $result=$this->Stockreportinfo->Getproductaccosupplier();
	}
    public function Purchaseorderview(){
		$this->load->model('Stockreportinfo');
        $result=$this->Stockreportinfo->Purchaseorderview();
	}
}