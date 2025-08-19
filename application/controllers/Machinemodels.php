<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Machinemodels extends CI_Controller {
    
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Machinemodelsinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('machinemodels', $result);
	}

    public function Machinemodelsinsertupdate(){
		$this->load->model('Machinemodelsinfo');
        $result = $this->Machinemodelsinfo->Machinemodelsinsertupdate();
	}
    public function Machinemodelsstatus($x, $y){
		$this->load->model('Machinemodelsinfo');
        $result = $this->Machinemodelsinfo->Machinemodelsstatus($x, $y);
	}
    public function Machinemodelsedit(){
		$this->load->model('Machinemodelsinfo');
        $result = $this->Machinemodelsinfo->Machinemodelsedit();
    }
}