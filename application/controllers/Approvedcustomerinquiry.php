<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Approvedcustomerinquiry extends CI_Controller {
    public function index(){
		$this->load->model('Approvedcustomerinquiryinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['customerlist']=$this->Approvedcustomerinquiryinfo->Getcustomer();
		$result['materialtypelist']=$this->Approvedcustomerinquiryinfo->Getmaterialtype();
		$result['gaugetypelist']=$this->Approvedcustomerinquiryinfo->Getgaugetype();
		$this->load->view('approvedcustomerinquiry',$result);
	}
	public function Approvedcustomerinquiryedit(){
		$this->load->model('Approvedcustomerinquiryinfo');
        $result=$this->Approvedcustomerinquiryinfo->Approvedcustomerinquiryedit();
	}
	public function Approvedcustomerinquirystatus($x, $y){
		$this->load->model('Approvedcustomerinquiryinfo');
        $result=$this->Approvedcustomerinquiryinfo->Approvedcustomerinquirystatus($x, $y);
	}
	public function Approvedcustomerinquiryjobeditview(){
		$this->load->model('Approvedcustomerinquiryinfo');
        $result=$this->Approvedcustomerinquiryinfo->Approvedcustomerinquiryjobeditview();
	}
	public function Approvedcustomerinquiryjoblistedit(){
		$this->load->model('Approvedcustomerinquiryinfo');
        $result=$this->Approvedcustomerinquiryinfo->Approvedcustomerinquiryjoblistedit();
	}
	public function Approvedcustomerinquiryjobedit(){
		$this->load->model('Approvedcustomerinquiryinfo');
        $result=$this->Approvedcustomerinquiryinfo->Approvedcustomerinquiryjobedit();
	}
	public function Customerinquiryapproveedit(){
		$this->load->model('Approvedcustomerinquiryinfo');
        $result=$this->Approvedcustomerinquiryinfo->Customerinquiryapproveedit();
	}
	public function Approvedcustomerinquiryinsertupdate(){
		$this->load->model('Approvedcustomerinquiryinfo');
        $result=$this->Approvedcustomerinquiryinfo->Approvedcustomerinquiryinsertupdate();
	}
	public function Getfilteredmaterials(){
		$this->load->model('Approvedcustomerinquiryinfo');
        $result=$this->Approvedcustomerinquiryinfo->Getfilteredmaterials();
	}
	public function Getmaterialunitprice(){
		$this->load->model('Approvedcustomerinquiryinfo');
        $result=$this->Approvedcustomerinquiryinfo->Getmaterialunitprice();
	}
	public function Insertupdateallocatedmaterials(){
		$this->load->model('Approvedcustomerinquiryinfo');
        $result=$this->Approvedcustomerinquiryinfo->Insertupdateallocatedmaterials();
	}
	public function Fetchinsertedmaterials(){
		$this->load->model('Approvedcustomerinquiryinfo');
        $result=$this->Approvedcustomerinquiryinfo->Fetchinsertedmaterials();
	}
	public function pdfgrnget($x) {
        $this->load->model('Pdfjobcardinfo');
        $this->Pdfjobcardinfo->pdfgrnget($x);
    }
}
