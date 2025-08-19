<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Invoice extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Invoiceinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['customerlist']=$this->Invoiceinfo->Getcustomerlist();
		$result['chargelist']=$this->Invoiceinfo->Getchargetype();
		$result['companylist']=$this->Invoiceinfo->Getcompany();
		$result['measurelist']=$this->Invoiceinfo->Getmeasuretype();
		$this->load->view('invoice', $result);
	}
    public function Invoiceinsertupdate(){
		$this->load->model('Invoiceinfo');
        $result=$this->Invoiceinfo->Invoiceinsertupdate();
	}
    public function Invoicestatus($x, $y){
		$this->load->model('Invoiceinfo');
        $result=$this->Invoiceinfo->Invoicestatus($x, $y);
	}
    public function Purchaseorderedit(){
		$this->load->model('Purchaseorderinfo');
        $result=$this->Purchaseorderinfo->Purchaseorderedit();
	}
    public function Getjobsaccodispatch(){
		$this->load->model('Invoiceinfo');
        $result=$this->Invoiceinfo->Getjobsaccodispatch();
	}
    public function Getqtyaccdispatch(){
		$this->load->model('Invoiceinfo');
        $result=$this->Invoiceinfo->Getqtyaccdispatch();
	}
    public function Getcustomer(){
		$this->load->model('Invoiceinfo');
        $result=$this->Invoiceinfo->Getcustomer();
	}

	public function Getdispatchnote(){
		$this->load->model('Invoiceinfo');
        $result=$this->Invoiceinfo->Getdispatchnote();
	}

	public function Getprocescharges(){
		$this->load->model('Invoiceinfo');
        $result=$this->Invoiceinfo->Getprocescharges();
	}
	public function Invoiceview(){
		$this->load->model('Invoiceinfo');
        $result=$this->Invoiceinfo->Invoiceview();
	}
    public function Invoiceviewheader(){
		$this->load->model('Invoiceinfo');
        $result=$this->Invoiceinfo->Invoiceviewheader();
	}
	public function Getdispatchaccjob(){
		$this->load->model('Invoiceinfo');
        $result=$this->Invoiceinfo->Getdispatchaccjob();
	}
	public function Approinvoice(){
		$this->load->model('Invoiceinfo');
        $result=$this->Invoiceinfo->Approinvoice();
	}
		public function getCustomerVatStatus(){
		$this->load->model('Invoiceinfo');
        $result=$this->Invoiceinfo->getCustomerVatStatus();
	}
	public function pdfget($x) {
        $this->load->model('Pdfviewinvoiceinfo');
        $this->Pdfviewinvoiceinfo->pdfdata($x);
    }
}
