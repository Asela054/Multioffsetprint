<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Vehicletype extends CI_Controller {
    public function index(){
	    $this->load->model('Vehicletypeinfo');
		$this->load->model('Commeninfo');
		 $result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('vehicletype',$result);
	}
   
	public function Vehicletypeinsertupdate(){
		$this->load->model('Vehicletypeinfo');
        $result=$this->Vehicletypeinfo->Vehicletypeinsertupdate();
	}
	public function Vehicletypeedit(){
		$this->load->model('Vehicletypeinfo');
        $result=$this->Vehicletypeinfo->Vehicletypeedit();
	}
	public function Vehicletypestatus($x, $y){
		$this->load->model('Vehicletypeinfo');
        $result=$this->Vehicletypeinfo->Vehicletypestatus($x, $y);
	}
	
}