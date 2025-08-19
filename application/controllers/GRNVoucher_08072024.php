<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class GRNVoucher extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('GRNVoucherinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['costtypelist']=$this->GRNVoucherinfo->Getcosttype();
		$result['supplierlist']=$this->GRNVoucherinfo->Getsupplier();
		$result['porderlist']=$this->GRNVoucherinfo->Getporder();
		$result['ordertypelist']=$this->GRNVoucherinfo->Getordertype();
		$result['measurelist']=$this->GRNVoucherinfo->Getmeasuretype();
		$this->load->view('grnvoucher', $result);
	}
    public function GRNvoucherinsertupdate(){
		$this->load->model('GRNVoucherinfo');
        $result=$this->GRNVoucherinfo->GRNvoucherinsertupdate();
	}
    public function Goodreceivevoucherstatus($x, $y, $z){
		$this->load->model('GRNVoucherinfo');
        $result=$this->GRNVoucherinfo->Goodreceivevoucherstatus($x, $y, $z);
	}
    public function Goodreceiveedit(){
		$this->load->model('GRNVoucherinfo');
        $result=$this->GRNVoucherinfo->Goodreceiveedit();
	}
    public function Getproductaccosupplier(){
		$this->load->model('GRNVoucherinfo');
        $result=$this->GRNVoucherinfo->Getproductaccosupplier();
	}
	//add machine product
	public function Getproductformachine(){
		$this->load->model('GRNVoucherinfo');
        $result=$this->GRNVoucherinfo->Getproductformachine();
	}
	public function Getproductforsparepart(){
		$this->load->model('GRNVoucherinfo');
        $result=$this->GRNVoucherinfo->Getproductforsparepart();
	}
    public function Goodreceivevoucherview(){
		$this->load->model('GRNVoucherinfo');
        $result=$this->GRNVoucherinfo->Goodreceivevoucherview();
	}
    public function Getsupplieraccoporder(){
		$this->load->model('GRNVoucherinfo');
        $result=$this->GRNVoucherinfo->Getsupplieraccoporder();
	}
	public function Getlocationaccoporder(){
		$this->load->model('GRNVoucherinfo');
        $result=$this->GRNVoucherinfo->Getlocationaccoporder();
	}
    public function Getproductaccoporder(){
		$this->load->model('GRNVoucherinfo');
        $result=$this->GRNVoucherinfo->Getproductaccoporder();
	}
    public function Getproductinfoaccoproduct(){
		$this->load->model('GRNVoucherinfo');
        $result=$this->GRNVoucherinfo->Getproductinfoaccoproduct();
	}
	// get qty ,unitprice and comment according to machine
	public function Getproductinfoamachine(){
		$this->load->model('GRNVoucherinfo');
        $result=$this->GRNVoucherinfo->Getproductinfoamachine();
	}
	public function Getproductinfosparepart(){
		$this->load->model('GRNVoucherinfo');
        $result=$this->GRNVoucherinfo->Getproductinfosparepart();
	}
    public function Getexpdateaccoquater(){
		$this->load->model('GRNVoucherinfo');
        $result=$this->GRNVoucherinfo->Getexpdateaccoquater();
	}
    public function Getbatchnoaccosupplier(){
		$this->load->model('GRNVoucherinfo');
        $result=$this->GRNVoucherinfo->Getbatchnoaccosupplier();
	}
	public function GetBatchNoFromMachineAndMaterialInfo(){
		$this->load->model('GRNVoucherinfo');
        $result=$this->GRNVoucherinfo->GetBatchNoFromMachineAndMaterialInfo();
	}
    public function Getpordertpeaccoporder(){
		$this->load->model('GRNVoucherinfo');
        $result=$this->GRNVoucherinfo->Getpordertpeaccoporder();
	}
	public function Getgoodreceiveid(){
		$this->load->model('GRNVoucherinfo');
        $result=$this->GRNVoucherinfo->Getgoodreceiveid();
	}
	public function Costinsertupdate(){
		$this->load->model('GRNVoucherinfo');
        $result=$this->GRNVoucherinfo->Costinsertupdate();
	}
	public function Getmateriallistaccogrn(){
		$this->load->model('GRNVoucherinfo');
        $result=$this->GRNVoucherinfo->Getmateriallistaccogrn();
	}
	public function Getgrnaccsupllier(){
		$this->load->model('GRNVoucherinfo');
        $result=$this->GRNVoucherinfo->Getgrnaccsupllier();
	}
	public function Getvatpresentage(){
		$this->load->model('GRNVoucherinfo');
        $result=$this->GRNVoucherinfo->Getvatpresentage();
	}

	public function pdfgrnget($x) {
        $this->load->model('PdfGRNinfo');
        $this->PdfGRNinfo->pdfgrnget($x);
    }
}