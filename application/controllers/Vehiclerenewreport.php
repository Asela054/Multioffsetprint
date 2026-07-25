<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehiclerenewreport extends CI_Controller {


public function index(){

$this->load->model('Vehiclerenewreportinfo');
$this->load->model('Commeninfo');

$data['menuaccess']=$this->Commeninfo->Getmenuprivilege();

$data['vehiclemodel']=$this->Vehiclerenewreportinfo->VehicleModelget();
$data['vehiclebrand']=$this->Vehiclerenewreportinfo->VehicleBrandget();


$this->load->view('vehiclerenewreport',$data);

}


}