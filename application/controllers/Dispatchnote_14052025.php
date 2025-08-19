<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Dispatchnote extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Dispatchnoteinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['grnlist']=$this->Dispatchnoteinfo->Getporder();
        $result['companylist']=$this->Dispatchnoteinfo->Getcompany();
		$result['branchlist']=$this->Dispatchnoteinfo->Getcompanybranch();
        $result['measurelist']=$this->Dispatchnoteinfo->Getmeasuretype();
        $result['customerlist']=$this->Dispatchnoteinfo->Getcustomerlist();

        $result['joblist']=$this->Dispatchnoteinfo->Getjoblist();
		$this->load->view('dispatchnote', $result);
	}
    public function Dispatchnoteinsertupdate(){
		$this->load->model('Dispatchnoteinfo');
        $result=$this->Dispatchnoteinfo->Dispatchnoteinsertupdate();
	}
    public function Dispatchnotestatus($x, $y, $z){
		$this->load->model('Dispatchnoteinfo');
        $result=$this->Dispatchnoteinfo->Dispatchnotestatus($x, $y, $z);
	}
    public function Dispatchnoteedit(){
		$this->load->model('Dispatchnoteinfo');
        $result=$this->Dispatchnoteinfo->Dispatchnoteedit();
	}
    public function Getponumber(){
		$this->load->model('Dispatchnoteinfo');
        $result=$this->Dispatchnoteinfo->Getponumber();
	}
    public function Getcustomer(){
		$this->load->model('Dispatchnoteinfo');
        $result=$this->Dispatchnoteinfo->Getcustomer();
	}
    public function Getjobsaccoinqury(){
		$this->load->model('Dispatchnoteinfo');
        $result=$this->Dispatchnoteinfo->Getjobsaccoinqury();
	}
    public function Getqtyaccjob(){
		$this->load->model('Dispatchnoteinfo');
        $result=$this->Dispatchnoteinfo->Getqtyaccjob();
	}
    public function Dispatchview(){
		$this->load->model('Dispatchnoteinfo');
        $result=$this->Dispatchnoteinfo->Dispatchview();
	}
    public function dispatchviewheader(){
		$this->load->model('Dispatchnoteinfo');
        $result=$this->Dispatchnoteinfo->dispatchviewheader();
	}
    public function Approdispatch(){
		$this->load->model('Dispatchnoteinfo');
        $result=$this->Dispatchnoteinfo->Approdispatch();
	}
    public function Getinquryacccjob(){
		$this->load->model('Dispatchnoteinfo');
        $result=$this->Dispatchnoteinfo->Getinquryacccjob();
	}
    public function Getcustomeraccjob(){
		$this->load->model('Dispatchnoteinfo');
        $result=$this->Dispatchnoteinfo->Getcustomeraccjob();
	}
    public function pdfget($x) {
        $this->load->model('Pdfviewinfo');
        $this->Pdfviewinfo->pdfdata($x);
    }
}