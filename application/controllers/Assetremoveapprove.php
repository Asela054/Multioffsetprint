<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Assetremoveapprove extends CI_Controller {
    public function index(){
		$this->load->model('Assetremoveapproveinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('assetremoveapprove',$result);
	}
   
	public function Assetremoveapproveinsert(){
		$this->load->model('Assetremoveapproveinfo');
        $result=$this->Assetremoveapproveinfo->Assetremoveapproveinsert();
	}
	public function Assetremoveapproveedit(){
		$this->load->model('Assetremoveapproveinfo');
        $result=$this->Assetremoveapproveinfo->Assetremoveapproveedit();
	}
	
}
