<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Maintenace extends CI_Controller {
    public function index(){
	    $this->load->model('Maintenaceinfo');
		$this->load->model('Commeninfo');
		 $result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		 $result['VehicleRegNo']=$this->Maintenaceinfo->Getvehicleregno();
		$this->load->view('maintenace',$result);
	}
   
	public function maintenaceinsertupdate(){
		$this->load->model('Maintenaceinfo');
        $result=$this->Maintenaceinfo->maintenaceinsertupdate();
	}
	public function maintenaceedit(){
		$this->load->model('Maintenaceinfo');
        $result=$this->Maintenaceinfo->maintenaceedit();
	}
	public function maintenacestatus($x, $y){
		$this->load->model('Maintenaceinfo');
        $result=$this->Maintenaceinfo->maintenacestatus($x, $y);
	}
	
}