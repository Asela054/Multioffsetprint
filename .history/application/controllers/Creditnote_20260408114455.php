<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Colombo');

class Creditnote extends CI_Controller {

	public function index(){
		$this->load->model('Creditnoteinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['getcustomer']=$this->Creditnoteinfo->Customerget();
		$this->load->view('creditnote', $result);
	}

	public function fetchDispatchList(){
		$this->load->model('Creditnoteinfo');
        $result=$this->Creditnoteinfo->fetchDispatchList();
	}

    public function Getjobdetails(){
		$this->load->model('Creditnoteinfo');
        $result=$this->Creditnoteinfo->Getjobdetails();
	}

    public function Returninvoiceinsertupdate(){
		$this->load->model('Creditnoteinfo');
        $result=$this->Creditnoteinfo->Returninvoiceinsertupdate();
	}
	public function Getretruninvoicedetails(){
		$this->load->model('Creditnoteinfo');
        $result=$this->Creditnoteinfo->Getretruninvoicedetails();
	}

	public function GetCreditNoteDetails(){
		$this->load->model('Creditnoteinfo');
        $result=$this->Creditnoteinfo->GetCreditNoteDetails();
	}

	public function Creditnotestatus(){
		$this->load->model('Creditnoteinfo');
        $result=$this->Creditnoteinfo->Creditnotestatus();
	}

	public function Creditnotecheckstatus(){
		$this->load->model('Creditnoteinfo');
        $result=$this->Creditnoteinfo->Creditnotecheckstatus();
	}

	public function Getinvoiceprint(){
		$this->load->model('Pdfreturninvoiceinfo');
        $result=$this->Pdfreturninvoiceinfo->Getinvoiceprint();
	}

	public function GetCreditNotePrint(){
		$this->load->model('Creditnoteinfo');
        $result=$this->Creditnoteinfo->GetCreditNotePrint();
	}
    
}