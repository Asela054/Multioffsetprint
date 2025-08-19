<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Approvevehiclerenew extends CI_Controller {
    public function index(){
		$this->load->model('Approvevehiclerenewinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('approvevehiclerenew',$result);
	}
	public function Approvevehiclerenewstatus($x, $y){
		$this->load->model('Approvevehiclerenewinfo');
        $result=$this->Approvevehiclerenewinfo->Approvevehiclerenewstatus($x, $y);
	}
	
	
}
