<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Asset extends CI_Controller {
    public function index(){
		$this->load->model('Assetinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['Assetsubtypelist']=$this->Assetinfo->GetAssetsubcategory();
		$this->load->view('asset',$result);
	}
   
	public function Assetinsertupdate(){
		$this->load->model('Assetinfo');
        $result=$this->Assetinfo->Assetinsertupdate();
	}
	public function Assetedit(){
		$this->load->model('Assetinfo');
        $result=$this->Assetinfo->Assetedit();
	}
	public function Assetstatus($x, $y){
		$this->load->model('Assetinfo');
        $result=$this->Assetinfo->Assetstatus($x, $y);
	}
	
}
