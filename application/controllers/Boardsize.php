<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Boardsize extends CI_Controller {
    public function index(){
		$this->load->model('Boardsizeinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('boardsize',$result);
	}
   
	public function Boardsizeinsertupdate(){
		$this->load->model('Boardsizeinfo');
        $result=$this->Boardsizeinfo->Boardsizeinsertupdate();
	}
	public function Boardsizeedit(){
		$this->load->model('Boardsizeinfo');
        $result=$this->Boardsizeinfo->Boardsizeedit();
	}
	public function Boardsizestatus($x, $y){
		$this->load->model('Boardsizeinfo');
        $result=$this->Boardsizeinfo->Boardsizestatus($x, $y);
	}
	
}
