<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class ServicePurchaseOrder extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('ServicePurchaseOrderinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('servicepurchaseorder', $result);
	}

    public function Purchaseorderedit(){
		$this->load->model('ServicePurchaseOrderinfo');
        $result=$this->ServicePurchaseOrderinfo->Purchaseorderedit();
	}

	public function Getservicetyperequest(){
		$this->load->model('ServicePurchaseOrderinfo');
        $result=$this->ServicePurchaseOrderinfo->Getservicetyperequest();
	}
	public function Getproductforvehicle(){
		$this->load->model('ServicePurchaseOrderinfo');
        $result=$this->ServicePurchaseOrderinfo->Getproductforvehicle();
	}
	public function Getproductformachine(){
		$this->load->model('ServicePurchaseOrderinfo');
        $result=$this->ServicePurchaseOrderinfo->Getproductformachine();
	}
	public function Getproductforsparepart(){
		$this->load->model('ServicePurchaseOrderinfo');
        $result=$this->ServicePurchaseOrderinfo->Getproductforsparepart();
	}
	public function Getproductaccoporder(){
		$this->load->model('ServicePurchaseOrderinfo');
        $result=$this->ServicePurchaseOrderinfo->Getproductaccoporder();
	}
	public function Getsupplieraccoporderreq(){
		$this->load->model('ServicePurchaseOrderinfo');
        $result=$this->ServicePurchaseOrderinfo->Getsupplieraccoporderreq();
	}
	public function Getporderreqdetails(){
		$this->load->model('ServicePurchaseOrderinfo');
        $result=$this->ServicePurchaseOrderinfo->Getporderreqdetails();
	}
	public function Getproductinfoaccoproduct(){
		$this->load->model('ServicePurchaseOrderinfo');
        $result=$this->ServicePurchaseOrderinfo->Getproductinfoaccoproduct();
	}
	public function Getproductinfoamachine(){
		$this->load->model('ServicePurchaseOrderinfo');
        $result=$this->ServicePurchaseOrderinfo->Getproductinfoamachine();
	}
	public function Getproductinfosparepart(){
		$this->load->model('ServicePurchaseOrderinfo');
        $result=$this->ServicePurchaseOrderinfo->Getproductinfosparepart();
	}
		public function Getproductinfoservice(){
			$this->load->model('ServicePurchaseOrderinfo');
			$result=$this->ServicePurchaseOrderinfo->Getproductinfoservice();
		}
    public function Purchaseorderview(){
		$this->load->model('ServicePurchaseOrderinfo');
        $result=$this->ServicePurchaseOrderinfo->Purchaseorderview();
	}
	public function porderviewheader(){
		$this->load->model('ServicePurchaseOrderinfo');
        $result=$this->ServicePurchaseOrderinfo->porderviewheader();
	}
	public function Getvatpresentage(){
		$this->load->model('ServicePurchaseOrderinfo');
        $result=$this->ServicePurchaseOrderinfo->Getvatpresentage();
	}
	public function Printinvoice($x){
		$this->load->model('InvoicePrintinfo');
        $result=$this->InvoicePrintinfo->Printinvoice($x);
	}
	public function GetProductList() {
        $this->load->model('ServicePurchaseOrderinfo');
        $products = $this->ServicePurchaseOrderinfo->getProductsByType();
    }
	public function Getpiecesforqty(){
		$this->load->model('ServicePurchaseOrderinfo');
        $result=$this->ServicePurchaseOrderinfo->Getpiecesforqty();
	}
	public function Purchaseorderupdate(){
		$this->load->model('ServicePurchaseOrderinfo');
        $result=$this->ServicePurchaseOrderinfo->Purchaseorderupdate();
	}
	public function Getsupplierlist(){
		$searchTerm=$this->input->post('searchTerm');
        $result=SearchSupplierList($searchTerm);
	}
}
