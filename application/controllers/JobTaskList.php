<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class JobTaskList extends CI_Controller {
    public function index(){
		$this->load->model('Jobtaskinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('jobtasklist',$result);
	}
	public function Jobtaskinsertupdate(){
		$this->load->model('Jobtaskinfo');
        $result=$this->Jobtaskinfo->Jobtaskinsertupdate();
	}
	public function Jobtaskedit(){
		$this->load->model('Jobtaskinfo');
        $result=$this->Jobtaskinfo->Jobtaskedit();
	}
	public function JobTaskstatus($x, $y){
		$this->load->model('Jobtaskinfo');
        $result=$this->Jobtaskinfo->JobTaskstatus($x, $y);
	}
}
