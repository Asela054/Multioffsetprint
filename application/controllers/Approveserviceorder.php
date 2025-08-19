<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Approveserviceorder extends CI_Controller {
    public function index(){
		$this->load->model('Approveserviceorderinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('approveserviceorder',$result);
	}
	public function Approveserviceorderstatus($x, $y){
		$this->load->model('Approveserviceorderinfo');
        $result=$this->Approveserviceorderinfo->Approveserviceorderstatus($x, $y);
	}
	
	
}
