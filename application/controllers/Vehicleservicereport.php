<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Vehicleservicereport extends CI_Controller {


public function index(){

$this->load->model('Vehicleservicereportinfo');

$this->load->model('Commeninfo');


$data['menuaccess']=$this->Commeninfo->Getmenuprivilege();


$data['servicetype']=$this->Vehicleservicereportinfo->ServiceTypeget();


$this->load->view('vehicleservicereport',$data);


}

}