<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Rptservicesummery extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Serviceinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['VehicleRegNo']=$this->Serviceinfo->Getvehicleregno();
        $result['Supplier']=$this->Serviceinfo->Getsupplier();
		$this->load->view('rptservicesummery', $result);
	}
}