<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchaseorderreport extends CI_Controller {


public function index(){

$this->load->model('Purchaseorderreportinfo');
$this->load->model('Commeninfo');


$data['menuaccess']=$this->Commeninfo->Getmenuprivilege();

$data['supplier']=$this->Purchaseorderreportinfo->Supplierget();


$this->load->view('purchaseorderreport',$data);

}


}