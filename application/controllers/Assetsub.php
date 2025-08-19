<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Assetsub extends CI_Controller {
    public function index(){
		$this->load->model('Assetsubinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['Assetsubtypelist']=$this->Assetsubinfo->GetAssetsub();
		$this->load->view('assetsub',$result);
	}
   
	public function Assetsubinsertupdate(){
		$this->load->model('Assetsubinfo');
        $result=$this->Assetsubinfo->Assetsubinsertupdate();
	}
	public function Assetsubedit(){
		$this->load->model('Assetsubinfo');
        $result=$this->Assetsubinfo->Assetsubedit();
	}
	public function Assetsubstatus($x, $y){
		$this->load->model('Assetsubinfo');
        $result=$this->Assetsubinfo->Assetsubstatus($x, $y);
	}
	
}
