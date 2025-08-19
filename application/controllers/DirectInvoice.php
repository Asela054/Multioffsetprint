<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class DirectInvoice extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('DirectInvoiceinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['dispatchlist']=$this->DirectInvoiceinfo->Getdispatchlist();
		$result['chargelist']=$this->DirectInvoiceinfo->Getchargetype();
		$this->load->view('directinvoice', $result);
	}
    public function DirectInvoiceinsertupdate(){
		$this->load->model('DirectInvoiceinfo');
        $result=$this->DirectInvoiceinfo->DirectInvoiceinsertupdate();
	}
    public function DirectInvoicestatus($x, $y){
		$this->load->model('DirectInvoiceinfo');
        $result=$this->DirectInvoiceinfo->DirectInvoicestatus($x, $y);
	}
    public function Getmateriallist(){
		$this->load->model('DirectInvoiceinfo');
        $result=$this->DirectInvoiceinfo->Getmateriallist();
	}
    public function Getdispatchdetails(){
		$this->load->model('DirectInvoiceinfo');
        $result=$this->DirectInvoiceinfo->Getdispatchdetails();
	}
    public function Getunitprice(){
		$this->load->model('DirectInvoiceinfo');
        $result=$this->DirectInvoiceinfo->Getunitprice();
	}
	public function DirectInvoiceview(){
		$this->load->model('DirectInvoiceinfo');
        $result=$this->DirectInvoiceinfo->DirectInvoiceview();
	}
    public function DirectInvoiceviewheader(){
		$this->load->model('DirectInvoiceinfo');
        $result=$this->DirectInvoiceinfo->DirectInvoiceviewheader();
	}
	public function Approdirectinvoice(){
		$this->load->model('DirectInvoiceinfo');
        $result=$this->DirectInvoiceinfo->Approdirectinvoice();
	}
		public function DirectInvoicecheckstatus(){
		$this->load->model('DirectInvoiceinfo');
        $result=$this->DirectInvoiceinfo->DirectInvoicecheckstatus();
	}
	public function pdfget($x) {
        $this->load->model('PdfviewDirectInvoiceinfo');
        $result=$this->PdfviewDirectInvoiceinfo->pdfdata($x);
    }
}
