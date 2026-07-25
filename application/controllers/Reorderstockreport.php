<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reorderstockreport extends CI_Controller {


public function index(){

$this->load->model('Reorderstockreportinfo');
$this->load->model('Commeninfo');


$data['menuaccess']=$this->Commeninfo->Getmenuprivilege();

$data['materialgroup']=$this->Reorderstockreportinfo->MaterialGroupget();


$this->load->view('reorderstockreport',$data);

}


}