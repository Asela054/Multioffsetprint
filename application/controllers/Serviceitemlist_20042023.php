<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Serviceitemlist extends CI_Controller {
    public function index(){
	    $this->load->model('Serviceitemlistinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('serviceitemlist',$result);
	}
   
	public function Serviceitemlistinsertupdate(){
		$this->load->model('Serviceitemlistinfo');
        $result=$this->Serviceitemlistinfo->Serviceitemlistinsertupdate();
	}
	public function Serviceitemlistedit(){
		$this->load->model('Serviceitemlistinfo');
        $result=$this->Serviceitemlistinfo->Serviceitemlistedit();
	}
	public function Serviceitemliststatus($x, $y){
		$this->load->model('Serviceitemlistinfo');
        $result=$this->Serviceitemlistinfo->Serviceitemliststatus($x, $y);
	}
	
}