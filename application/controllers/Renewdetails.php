<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Renewdetails extends CI_Controller {
    public function index($x){
		$this->load->model('Renewdetailsinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['RenewType']=$this->Renewdetailsinfo->Getrenewtype();
		$result['Insurance']=$this->Renewdetailsinfo->Getinsurance();
        $result['vehicleid']=$this->Renewdetailsinfo->GetVehicleid($x);

        $this->load->view('renewdetails',$result);
	}
   
	public function Renewdetailsinsertupdate(){
		$this->load->model('Renewdetailsinfo');
        $result=$this->Renewdetailsinfo->Renewdetailsinsertupdate();
	}
	public function Renewdetailsedit(){
		$this->load->model('Renewdetailsinfo');
        $result=$this->Renewdetailsinfo->Renewdetailsedit();
	}
	public function Renewdetailsstatus($x,$y,$z){
		$this->load->model('Renewdetailsinfo');
        $result=$this->Renewdetailsinfo->Renewdetailsstatus($x,$y,$z);
	}
	
}
