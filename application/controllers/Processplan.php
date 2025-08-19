<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Processplan extends CI_Controller {
    public function index(){
		$this->load->model('Processplaninfo');
        $this->load->model('Jobtaskinfo');
		$this->load->model('Commeninfo');

		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['jobtasklist']=$this->Jobtaskinfo->Getjobtasklist();

		$this->load->view('processplan',$result);
	}
	public function ProcessPlaninsertupdate(){
		$this->load->model('Processplaninfo');
        $result=$this->Processplaninfo->ProcessPlaninsertupdate();
	}
	public function Processplansstatus($x, $y){
		$this->load->model('Processplaninfo');
        $result=$this->Processplaninfo->Processplansstatus($x, $y);
	}
	
	public function Processplanedit(){
		$this->load->model('Processplaninfo');
        $result=$this->Processplaninfo->Processplanedit();
	}
}
