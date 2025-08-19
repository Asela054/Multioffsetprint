<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Servicesitem extends CI_Controller {
    public function index($x){
		$this->load->model('Servicesiteminfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['ServiceType']=$this->Servicesiteminfo->Getservicetype();
        $result['Serviceid']=$this->Servicesiteminfo->GetServiceid($x);

        $this->load->view('servicesitem',$result);
	}
   
	public function Servicesiteminsertupdate(){
		$this->load->model('Servicesiteminfo');
        $result=$this->Servicesiteminfo->Servicesiteminsertupdate();
	}
	public function Servicesitemedit(){
		$this->load->model('Servicesiteminfo');
        $result=$this->Servicesiteminfo->Servicesitemedit();
	}
	public function Servicesitemstatus($x,$y,$z){
		$this->load->model('Servicesiteminfo');
        $result=$this->Servicesiteminfo->Servicesitemstatus($x,$y,$z);
	}
	
}
