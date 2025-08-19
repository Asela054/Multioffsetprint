<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Vehiclebrand extends CI_Controller {
    public function index(){
	    $this->load->model('Vehiclebrandinfo');
		$this->load->model('Commeninfo');
		 $result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('vehiclebrand',$result);
	}
   
	public function Vehiclebrandinsertupdate(){
		$this->load->model('Vehiclebrandinfo');
        $result=$this->Vehiclebrandinfo->Vehiclebrandinsertupdate();
	}
	public function Vehiclebrandedit(){
		$this->load->model('Vehiclebrandinfo');
        $result=$this->Vehiclebrandinfo->Vehiclebrandedit();
	}
	public function Vehiclebrandstatus($x, $y){
		$this->load->model('Vehiclebrandinfo');
        $result=$this->Vehiclebrandinfo->Vehiclebrandstatus($x, $y);
	}
	
}