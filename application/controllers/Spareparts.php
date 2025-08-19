<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Spareparts extends CI_Controller {
    
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Sparepartsinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['type']=$this->Sparepartsinfo->Getmachinetype();
        $result['machinemodels_name']=$this->Sparepartsinfo->Getmachinemodels();
        $result['name']=$this->Sparepartsinfo->Getsupplier();
		$this->load->view('spareparts', $result);
	}

    public function Sparepartsinsertupdate(){
		$this->load->model('Sparepartsinfo');
        $result = $this->Sparepartsinfo->Sparepartsinsertupdate();
	}
    public function Sparepartsstatus($x, $y){
		$this->load->model('Sparepartsinfo');
        $result = $this->Sparepartsinfo->Sparepartsstatus($x, $y);
	}
    public function Sparepartsedit(){
		$this->load->model('Sparepartsinfo');
        $result = $this->Sparepartsinfo->Sparepartsedit();
    }
}