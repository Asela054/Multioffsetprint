<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Assetmain extends CI_Controller {
    public function index(){
		$this->load->model('Assetmaininfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('assetmain',$result);
	}
   
	public function Assetmaininsertupdate(){
		$this->load->model('Assetmaininfo');
        $result=$this->Assetmaininfo->Assetmaininsertupdate();
	}
	public function Assetmainedit(){
		$this->load->model('Assetmaininfo');
        $result=$this->Assetmaininfo->Assetmainedit();
	}
	public function Assetmainstatus($x, $y){
		$this->load->model('Assetmaininfo');
        $result=$this->Assetmaininfo->Assetmainstatus($x, $y);
	}
	
}
