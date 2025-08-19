<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Assetremove extends CI_Controller {
    public function index(){
		$this->load->model('Assetremoveinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('assetremove',$result);
	}
   
	public function Assetremoveinsertupdate(){
		$this->load->model('Assetremoveinfo');
        $result=$this->Assetremoveinfo->Assetremoveinsertupdate();
	}
	public function Assetremoveedit(){
		$this->load->model('Assetremoveinfo');
        $result=$this->Assetremoveinfo->Assetremoveedit();
	}
	public function Assetremovestatus($x, $y){
		$this->load->model('Assetremoveinfo');
        $result=$this->Assetremoveinfo->Assetremovestatus($x, $y);
	}
	
}
