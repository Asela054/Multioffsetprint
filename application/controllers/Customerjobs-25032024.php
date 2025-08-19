<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Customerjobs extends CI_Controller {
    public function index($x){
		$this->load->model('Customerjobsinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['Customerbankdetails']=$this->Customerjobsinfo->GetCustomerjobid($x);
		$result['measurelist']=$this->Customerjobsinfo->Getmeasuretype();
		$this->load->view('customerjobs',$result);
	}
   
	public function Customerjobsinsertupdate(){
		$this->load->model('Customerjobsinfo');
        $result=$this->Customerjobsinfo->Customerjobsinsertupdate();
	}
	public function Customerjobsedit(){
		$this->load->model('Customerjobsinfo');
        $result=$this->Customerjobsinfo->Customerjobsedit();
	}
	public function Customerjobsstatus($x,$z,$y){
		$this->load->model('Customerjobsinfo');
        $result=$this->Customerjobsinfo->Customerjobsstatus($x,$z,$y);
	}
	
}
