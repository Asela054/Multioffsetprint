<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Machinetype extends CI_Controller {
    public function index(){
		$this->load->model('Machinetypeinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('machinetype',$result);
	}
   
	public function Machinetypeinsertupdate(){
		$this->load->model('Machinetypeinfo');
        $result=$this->Machinetypeinfo->Machinetypeinsertupdate();
	}
	public function Machinetypeedit(){
		$this->load->model('Machinetypeinfo');
        $result=$this->Machinetypeinfo->Machinetypeedit();
	}
	public function Machinetypestatus($x, $y){
		$this->load->model('Machinetypeinfo');
        $result=$this->Machinetypeinfo->Machinetypestatus($x, $y);
	}
	
}
