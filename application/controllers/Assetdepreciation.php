<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Assetdepreciation extends CI_Controller {
    public function index(){
		$this->load->model('Assetdepreciationinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('assetdepreciation',$result);
	}
   
	public function Assetdepreciationinsertupdate(){
		$this->load->model('Assetdepreciationinfo');
        $result=$this->Assetdepreciationinfo->Assetdepreciationinsertupdate();
	}
	public function Assetdepreciationedit(){
		$this->load->model('Assetdepreciationinfo');
        $result=$this->Assetdepreciationinfo->Assetdepreciationedit();
	}
	public function Assetdepreciationstatus($x, $y){
		$this->load->model('Assetdepreciationinfo');
        $result=$this->Assetdepreciationinfo->Assetdepreciationstatus($x, $y);
	}
	
}
