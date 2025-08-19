<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Board extends CI_Controller {
    public function index(){
		$this->load->model('Boardinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['boardtypelist']=$this->Boardinfo->Getboardcategory();
		$result['boardsizelist']=$this->Boardinfo->Getboardsize();
		$this->load->view('board',$result);
	}
   
	public function Boardinsertupdate(){
		$this->load->model('Boardinfo');
        $result=$this->Boardinfo->Boardinsertupdate();
	}
	public function Boardedit(){
		$this->load->model('Boardinfo');
        $result=$this->Boardinfo->Boardedit();
	}
	public function Boardstatus($x, $y){
		$this->load->model('Boardinfo');
        $result=$this->Boardinfo->Boardstatus($x, $y);
	}
	
}
