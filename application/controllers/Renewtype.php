<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Renewtype extends CI_Controller {
    public function index(){
	    $this->load->model('Renewtypeinfo');
		$this->load->model('Commeninfo');
		 $result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('renewtype',$result);
	}
   
	public function Renewtypeinsertupdate(){
		$this->load->model('Renewtypeinfo');
        $result=$this->Renewtypeinfo->Renewtypeinsertupdate();
	}
	public function Renewtypeedit(){
		$this->load->model('Renewtypeinfo');
        $result=$this->Renewtypeinfo->Renewtypeedit();
	}
	public function Renewtypestatus($x, $y){
		$this->load->model('Renewtypeinfo');
        $result=$this->Renewtypeinfo->Renewtypestatus($x, $y);
	}
	
}