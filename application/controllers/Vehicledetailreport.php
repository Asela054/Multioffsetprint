<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicledetailreport extends CI_Controller {


public function index(){

$this->load->model('Vehicledetailreportinfo');
$this->load->model('Commeninfo');


$data['menuaccess']=$this->Commeninfo->Getmenuprivilege();

$data['vehiclemodel']=$this->Vehicledetailreportinfo->VehicleModelget();
$data['vehiclebrand']=$this->Vehicledetailreportinfo->VehicleBrandget();


$this->load->view('vehicledetailreport',$data);

}


}