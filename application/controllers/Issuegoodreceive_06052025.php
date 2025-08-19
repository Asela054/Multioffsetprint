<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Issuegoodreceive extends CI_Controller {
    public function index(){
		$this->load->model('Issuegoodreceiveinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['locationlist']=$this->Issuegoodreceiveinfo->Getlocation();
		$result['departmentlist']=$this->Issuegoodreceiveinfo->Getdepartment();
		$result['supplierlist']=$this->Issuegoodreceiveinfo->Getsupplier();
		$result['ordertypelist']=$this->Issuegoodreceiveinfo->Getordertype();
		$result['servicetypelist']=$this->Issuegoodreceiveinfo->Getservicetype();
		$result['grnlist']=$this->Issuegoodreceiveinfo->Getporder();
		$this->load->view('issuegoodreceive',$result);
	}
   
	public function Issuegoodreceiveinsertupdate(){
		$this->load->model('Issuegoodreceiveinfo');
        $result=$this->Issuegoodreceiveinfo->Issuegoodreceiveinsertupdate();
	}
	public function Issuepdf($x){
		$this->load->model('Issuegoodreceiveinfo');
        $result=$this->Issuegoodreceiveinfo->Issuepdf($x);
		echo  $result;
	}
	public function Issuegoodreceivestatus($x, $y){
		$this->load->model('Issuegoodreceiveinfo');
        $result=$this->Issuegoodreceiveinfo->Issuegoodreceivestatus($x, $y);
	}
	public function Getlocationaccoitemreq(){
		$this->load->model('Issuegoodreceiveinfo');
        $result=$this->Issuegoodreceiveinfo->Getlocationaccoitemreq();
	}
	public function Getdepartmentaccoitemreq(){
		$this->load->model('Issuegoodreceiveinfo');
        $result=$this->Issuegoodreceiveinfo->Getdepartmentaccoitemreq();
	}
	public function Getordertypeaccoitemreq(){
		$this->load->model('Issuegoodreceiveinfo');
        $result=$this->Issuegoodreceiveinfo->Getordertypeaccoitemreq();
	}
	public function Getmachineitem(){
		$this->load->model('Issuegoodreceiveinfo');
        $result=$this->Issuegoodreceiveinfo->Getmachineitem();
	}
	public function Getmaterialitem(){
		$this->load->model('Issuegoodreceiveinfo');
        $result=$this->Issuegoodreceiveinfo->Getmaterialitem();
	}
	public function Getproductinfoaccoproduct(){
		$this->load->model('Issuegoodreceiveinfo');
        $result=$this->Issuegoodreceiveinfo->Getproductinfoaccoproduct();
	}
	public function Getproductinfoaccomachine(){
		$this->load->model('Issuegoodreceiveinfo');
        $result=$this->Issuegoodreceiveinfo->Getproductinfoaccomachine();
	}
	public function GetitemreQTY(){
		$this->load->model('Issuegoodreceiveinfo');
        $result=$this->Issuegoodreceiveinfo->GetitemreQTY();
	}
	public function Getqtyfromreq(){
		$this->load->model('Issuegoodreceiveinfo');
        $result=$this->Issuegoodreceiveinfo->Getqtyfromreq();
	}
	public function Getqtyfromreqmachine(){
		$this->load->model('Issuegoodreceiveinfo');
        $result=$this->Issuegoodreceiveinfo->Getqtyfromreqmachine();
	}
	public function GetBachnoInfo(){
		$this->load->model('Issuegoodreceiveinfo');
        $result=$this->Issuegoodreceiveinfo->GetBachnoInfo();
	}
	public function Issueview(){
		$this->load->model('Issuegoodreceiveinfo');
        $result=$this->Issuegoodreceiveinfo->Issueview();
	}
	public function Approveissue(){
		$this->load->model('Issuegoodreceiveinfo');
        $result=$this->Issuegoodreceiveinfo->Approveissue();
	}
}
