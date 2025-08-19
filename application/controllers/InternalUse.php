<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class InternalUse extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('InternalUseInfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['productlist']=$this->InternalUseInfo->GetAllProducts();

		$this->load->view('internaluse', $result);
	}
    public function InternalUseinsertupdate(){
		$this->load->model('InternalUseInfo');
        $result=$this->InternalUseInfo->InternalUseinsertupdate();
	}
    public function InternalUsestatus($x, $y){
		$this->load->model('InternalUseInfo');
        $result=$this->InternalUseInfo->Employeestatus($x, $y);
	}
    public function InternalUseedit(){
		$this->load->model('InternalUseInfo');
        $result=$this->InternalUseInfo->Employeeedit();
	}
    public function FetchAvailableStock(){
		$this->load->model('InternalUseInfo');
        $result=$this->InternalUseInfo->FetchAvailableStock();
	}
}