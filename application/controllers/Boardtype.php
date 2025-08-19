<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Boardtype extends CI_Controller {
    public function index(){
		$this->load->model('Boardtypeinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('boardtype',$result);
	}
   
	public function Boardtypeinsertupdate(){
		$this->load->model('Boardtypeinfo');
        $result=$this->Boardtypeinfo->Boardtypeinsertupdate();
	}
	public function Boardtypeedit(){
		$this->load->model('Boardtypeinfo');
        $result=$this->Boardtypeinfo->Boardtypeedit();
	}
	public function Boardtypestatus($x, $y){
		$this->load->model('Boardtypeinfo');
        $result=$this->Boardtypeinfo->Boardtypestatus($x, $y);
	}
	
}
