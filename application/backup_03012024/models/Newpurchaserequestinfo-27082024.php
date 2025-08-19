<?php class Newpurchaserequestinfo extends CI_Model {
	public function Getcompany() {
		$this->db->select('`idtbl_company`, `company`');
		$this->db->from('tbl_company');
		$this->db->where('status', 1);

		return $respond=$this->db->get();
	}

	// public function Getcompanybranch() {
	// 	$this->db->select('`idtbl_company_branch`, `branch`');
	// 	$this->db->from('tbl_company_branch');
	// 	$this->db->where('status', 1);

	// 	return $respond=$this->db->get();
	// }

	public function Getservicetype() {
		$this->db->select('`idtbl_service_type`, `service_name`');
		$this->db->from('tbl_service_type');
		$this->db->where('status', 1);

		return $respond=$this->db->get();
	}

	public function Getsupplier() {
		$this->db->select('`idtbl_supplier`, `name`');
		$this->db->from('tbl_supplier');
		$this->db->where('status', 1);

		return $respond=$this->db->get();
	}

	public function Getordertype() {
		$this->db->select('`idtbl_order_type`, `type`');
		$this->db->from('tbl_order_type');
		$this->db->where('status', 1);

		return $respond=$this->db->get();
	}

	public function Getmeasuretype() {
		$this->db->select('`idtbl_mesurements`, `measure_type`');
		$this->db->from('tbl_measurements');
		$this->db->where('status', 1);

		return $respond=$this->db->get();
	}

	public function Getproductaccosupplier() {
		$recordID = $this->input->post('recordID');
		$sql = "SELECT `idtbl_print_material_info`, `materialinfocode`, `materialname` FROM `tbl_print_material_info` WHERE `tbl_supplier_idtbl_supplier`=? AND `status`=1";
		$respond = $this->db->query($sql, array($recordID));
	
		echo json_encode($respond->result());
	}
	public function Getsparepartaccosupplier() {
		$recordID = $this->input->post('recordID');
		$sql = "SELECT `idtbl_spareparts`, `spare_part_name` FROM `tbl_spareparts` WHERE `supplier_id`=? AND `status`=1";
		$respond = $this->db->query($sql, array($recordID));
	
		echo json_encode($respond->result());
	}
	

	public function Getproductforvehicle() {
		$recordID=$this->input->post('recordID');
		$sql="SELECT `idtbl_service_item_list`, `service_type` FROM `tbl_service_item_list` WHERE `status`=1";
		$respond=$this->db->query($sql, array($recordID));

		echo json_encode($respond->result());
	}

	public function Getproductformachine() {
		$recordID=$this->input->post('recordID');
		$sql="SELECT `idtbl_machine`, `machine` FROM `tbl_machine` WHERE `status`=1";
		$respond=$this->db->query($sql, array($recordID));

		echo json_encode($respond->result());
	}

	public function Getproductforsparepart() {
		$recordID=$this->input->post('recordID');
		$sql="SELECT `idtbl_spareparts`, `name` FROM `tbl_spareparts` WHERE `status`=1";
		$respond=$this->db->query($sql, array($recordID));

		echo json_encode($respond->result());
	}


	public function Getproductprice(){
        $recordID=$this->input->post('recordID');
		// $purchaseorder_id=$this->input->post('purchaseorder_id');

		$this->db->select('*'); 
        $this->db->from('tbl_print_material_info');
        $this->db->where('status', 1);
		// $this->db->where('tbl_print_porder_idtbl_print_porder', $purchaseorder_id);
        $this->db->where('idtbl_print_material_info', $recordID);

        $respond=$this->db->get();

        if($respond->num_rows()>0){
            $obj=new stdClass();
            $obj->unitprice=$respond->row(0)->unitprice;
        }

        else{
            $obj=new stdClass(); 
            $obj->unitprice=0;
          
        }
        echo json_encode($obj);
    }

	public function Getproductpricespare(){
        $recordID=$this->input->post('recordID');
		// $purchaseorder_id=$this->input->post('purchaseorder_id');

		$this->db->select('*'); 
        $this->db->from('tbl_spareparts');
        $this->db->where('status', 1);
		// $this->db->where('tbl_print_porder_idtbl_print_porder', $purchaseorder_id);
        $this->db->where('idtbl_spareparts', $recordID);

        $respond=$this->db->get();

        if($respond->num_rows()>0){
            $obj=new stdClass();
            $obj->unitprice=$respond->row(0)->unit_price;
        }

        else{
            $obj=new stdClass(); 
            $obj->unitprice=0;
          
        }
        echo json_encode($obj);
    }

	public function Newpurchaserequestinsertupdate() {
		$this->db->trans_begin();

		$userID=$_SESSION['userid'];

		// ////////////////////////////////////////////// Create manual Porder_req no ////////////////////////////////////////////////////////////////
		// $comapnyID=$_SESSION['company_id'];

		// $query = $this->db->query("SELECT * FROM tbl_print_invoice WHERE  company_id= $comapnyID");
		// $count = $query->num_rows();



		$tableData=$this->input->post('tableData');
		// $orderdate=$this->input->post('orderdate');
		// $duedate=$this->input->post('duedate');
		$company_id=$this->input->post('company_id');
		$branch_id=$this->input->post('branch_id');
		$supplier=$this->input->post('supplier');
		// $location=$this->input->post('location');
		$ordertype=$this->input->post('ordertype');
		$servicetype=$this->input->post('servicetype');

        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

		$updatedatetime=date('Y-m-d H:i:s');
		

		if($recordOption==1) {

			$data=array( // 'orderdate'=> $orderdate, 
				// 'duedate'=> 'null', 
				// 'subtotal'=> $total, 
				// 'discount'=> '0', 
				'company_id'=> $company_id, 
				'company_branch_id'=> $branch_id, 
				'confirmstatus'=> '0',
				'porderconfirm'=> '0',
				// 'remark'=> $remark, 
				'status'=> '1',
				// 'tbl_service_type_idtbl_service_type'=> $servicetype,
				'insertdatetime'=> $updatedatetime,
				'tbl_user_idtbl_user'=> $userID,
				// 'tbl_location_idtbl_location'=> '1',
				'tbl_supplier_idtbl_supplier'=> $supplier,
				'tbl_order_type_idtbl_order_type'=> $ordertype);

			$this->db->insert('tbl_print_porder_req', $data);

			$porderID=$this->db->insert_id();

			if($ordertype==3) {
				foreach ($tableData as $rowtabledata) {
					$materialname=$rowtabledata['col_1'];
					// $comment = $rowtabledata['col_2'];
					$materialID=$rowtabledata['col_2'];
					$uom=$rowtabledata['col_4'];
					$uomID=$rowtabledata['col_6'];
					$qty=$rowtabledata['col_3'];
					$unitprice = $rowtabledata['col_5'];

					$dataone=array('qty'=> $qty,
						'measure_type_id'=> $uomID,
						'unitprice' => $unitprice,
						// 'discountamount' => '0',
						// 'comment' => $comment,
						'status'=> '1',
						'insertdatetime'=> $updatedatetime,
						'tbl_print_porder_idtbl_print_porder'=> $porderID,
						'tbl_material_id'=> $materialID,
					);

					$this->db->insert('tbl_print_porder_req_detail', $dataone);
				}
			}

			else if($ordertype==4) {
				foreach ($tableData as $rowtabledata) {
					$materialname=$rowtabledata['col_1'];
					// $comment = $rowtabledata['col_2'];
					$materialID=$rowtabledata['col_2'];
					$uom=$rowtabledata['col_4'];
					$uomID=$rowtabledata['col_6'];
					$qty=$rowtabledata['col_3'];
					$unitprice = $rowtabledata['col_5'];
					// $nettotal = $rowtabledata['col_6'];

					$dataone=array('qty'=> $qty,
						'measure_type_id'=> $uomID,
						'unitprice' => $unitprice,
						// 'discountamount' => '0',
						// 'comment' => $comment,
						'status'=> '1',
						'insertdatetime'=> $updatedatetime,
						'tbl_print_porder_idtbl_print_porder'=> $porderID,
						'tbl_machine_id'=> $materialID,
					);

					$this->db->insert('tbl_print_porder_req_detail', $dataone);
				}
			}

			else if($ordertype==2) {
				foreach ($tableData as $rowtabledata) {
					$materialname=$rowtabledata['col_1'];
					// $comment = $rowtabledata['col_2'];
					$materialID=$rowtabledata['col_2'];
					$uom=$rowtabledata['col_4'];
					$uomID=$rowtabledata['col_5'];
					$qty=$rowtabledata['col_3'];
					// $nettotal = $rowtabledata['col_6'];

					$dataone=array('qty'=> $qty,
						'measure_type_id'=> $uomID,
						// 'discount' => '0',
						// 'discountamount' => '0',
						// 'comment' => $comment,
						'status'=> '1',
						'insertdatetime'=> $updatedatetime,
						'tbl_print_porder_idtbl_print_porder'=> $porderID,
						'tbl_service_type_id'=> $materialID,
					);

					$this->db->insert('tbl_print_porder_req_detail', $dataone);
				}
			}

			else {
				foreach ($tableData as $rowtabledata) {
					$materialname=$rowtabledata['col_1'];
					// $comment = $rowtabledata['col_2'];
					$materialID=$rowtabledata['col_2'];
					$uom=$rowtabledata['col_4'];
					$uomID=$rowtabledata['col_6'];
					$qty=$rowtabledata['col_3'];
					$unitprice = $rowtabledata['col_5'];
					// $nettotal = $rowtabledata['col_6'];

					$dataone=array('qty'=> $qty,
						'measure_type_id'=> $uomID,
						'unitprice' => $unitprice,
						// 'discountamount' => '0',
						// 'comment' => $comment,
						'status'=> '1',
						'insertdatetime'=> $updatedatetime,
						'tbl_print_porder_idtbl_print_porder'=> $porderID,
						'tbl_sparepart_id'=> $materialID,
					);

					$this->db->insert('tbl_print_porder_req_detail', $dataone);
				}
			}


			if ($this->db->trans_status()===TRUE) {
				$this->db->trans_commit();

				$actionObj=new stdClass();
				$actionObj->icon='fas fa-save';
				$actionObj->title='';
				$actionObj->message='Record Added Successfully';
				$actionObj->url='';
				$actionObj->target='_blank';
				$actionObj->type='success';

				$actionJSON=json_encode($actionObj);

				$obj=new stdClass();
				$obj->status=1;
				$obj->action=$actionJSON;

				echo json_encode($obj);
			}

			else {
				$this->db->trans_rollback();

				$actionObj=new stdClass();
				$actionObj->icon='fas fa-exclamation-triangle';
				$actionObj->title='';
				$actionObj->message='Record Error';
				$actionObj->url='';
				$actionObj->target='_blank';
				$actionObj->type='danger';

				$actionJSON=json_encode($actionObj);

				$obj=new stdClass();
				$obj->status=0;
				$obj->action=$actionJSON;

				echo json_encode($obj);
			}
		}
	}

	public function Purchaseorderview() {
		$recordID=$this->input->post('recordID');

		$sql="SELECT `u`.*, `ua`.`name`, `ua`.`address_line1` AS `locemail` FROM `tbl_print_porder_req` AS `u` LEFT JOIN `tbl_supplier` AS `ua` ON (`ua`.`idtbl_supplier` = `u`.`tbl_supplier_idtbl_supplier`)  WHERE `u`.`status`=? AND `u`.`idtbl_print_porder_req`=?";
		$respond=$this->db->query($sql, array(1, $recordID));

		$this->db->select('tbl_print_porder_req_detail.*,tbl_print_porder_req.tbl_order_type_idtbl_order_type, tbl_print_material_info.materialinfocode, tbl_print_material_info.materialname,tbl_machine.machine,tbl_machine.machinecode, tbl_service_type.service_name,tbl_measurements.measure_type ');
		$this->db->from('tbl_print_porder_req_detail');
		$this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_print_porder_req_detail.tbl_material_id', 'left');
		$this->db->join('tbl_measurements', 'tbl_measurements.idtbl_mesurements = tbl_print_porder_req_detail.measure_type_id', 'left'); // get measurements 
		$this->db->join('tbl_machine', 'tbl_machine.idtbl_machine = tbl_print_porder_req_detail.tbl_machine_id', 'left');
		$this->db->join('tbl_service_type', 'tbl_service_type.idtbl_service_type = tbl_print_porder_req_detail.tbl_service_type_id', 'left');
		$this->db->join('tbl_print_porder_req', 'tbl_print_porder_req.idtbl_print_porder_req = tbl_print_porder_req_detail.tbl_print_porder_idtbl_print_porder', 'left');
		$this->db->where('tbl_print_porder_req_detail.tbl_print_porder_idtbl_print_porder', $recordID);
		$this->db->where('tbl_print_porder_req_detail.status', 1);

		$responddetail=$this->db->get();
		// print_r($this->db->last_query());

		$html='';

		$html.='
        <div class="row">
        </div>
		<div class="row">
		<div class="col-12">
		<hr>
		<table class="table table-striped table-bordered table-sm">
		<thead>
		<th style="background-color: #c3faf6">Product Info</th>
		<th style="background-color: #c3faf6">Qty</th>
		<th style="background-color: #c3faf6">Uom</th>
		</thead>
		<tbody>';
        foreach($responddetail->result() as $roworderinfo) {
			if($roworderinfo->tbl_order_type_idtbl_order_type==3) {
				$html.='<tr>
        <td>'.$roworderinfo->materialname.'/ '.$roworderinfo->materialinfocode.'</td><td>'.$roworderinfo->qty.'</td><td>'.$roworderinfo->measure_type.'</td></tr>';

			}

			else if($roworderinfo->tbl_order_type_idtbl_order_type==4) {
				$html.='<tr>
        <td>'.$roworderinfo->machine.'/ '.$roworderinfo->machinecode.'</td><td>'.$roworderinfo->qty.'</td><td>'.$roworderinfo->measure_type.'</td></tr>';

			}

			else {
				$html.='<tr>
        <td>'.$roworderinfo->service_name.'</td><td>'.$roworderinfo->qty.'</td><td>'.$roworderinfo->measure_type.'</td></tr>';

			}
		}

		$html.='</tbody>
        </table></div></div>';

		echo $html;
	}

	public function porderviewheader() {
		$recordID=$this->input->post('recordID');

		$this->db->select('tbl_print_porder_req.*,tbl_supplier.name AS suppliername,tbl_supplier.telephone_no AS suppliercontact,tbl_supplier.address_line1 AS address1,tbl_supplier.address_line2 AS address2,tbl_supplier.city AS city,tbl_supplier.state AS supplierstate,
								tbl_company.company AS companyname,tbl_company.address1 As companyaddress,tbl_company.mobile AS companymobile,
                                tbl_company.phone companyphone,tbl_company.email AS companyemail,
                                tbl_company_branch.branch AS branchname');
		$this->db->from('tbl_print_porder_req');
		$this->db->join('tbl_supplier', 'tbl_supplier.idtbl_supplier  = tbl_print_porder_req.tbl_supplier_idtbl_supplier ', 'left');
		$this->db->join('tbl_company', 'tbl_company.idtbl_company = tbl_print_porder_req.company_id', 'left');
		$this->db->join('tbl_company_branch', 'tbl_company_branch.idtbl_company_branch = tbl_print_porder_req.company_branch_id', 'left');
		// $this->db->join('tbl_supplier_contact_details', 'tbl_supplier_contact_details.tbl_supplier_idtbl_supplier   = tbl_supplier.idtbl_supplier', 'left'); 
		$this->db->where('idtbl_print_porder_req', $recordID);
		$this->db->where('tbl_print_porder_req.status', 1);

		$respond=$this->db->get();

		$obj=new stdClass();
		// $obj->orderdate=$respond->row(0)->orderdate;
		$obj->suppliername=$respond->row(0)->suppliername;
		$obj->suppliercontact=$respond->row(0)->suppliercontact;
		$obj->address1=$respond->row(0)->address1;
		$obj->address2=$respond->row(0)->address2;
		$obj->city=$respond->row(0)->city;
		$obj->state=$respond->row(0)->supplierstate;
		$obj->companyname=$respond->row(0)->companyname;
            $obj->companyaddress=$respond->row(0)->companyaddress;
            $obj->companymobile=$respond->row(0)->companymobile;
            $obj->companyphone=$respond->row(0)->companyphone;
            $obj->companyemail=$respond->row(0)->companyemail;
            $obj->branchname=$respond->row(0)->branchname;

		echo json_encode($obj);
	}

	public function Newpurchaserequeststatus() {
		$this->db->trans_begin();

        $recordID=$this->input->post('approvebtn');
		$userID=$_SESSION['userid'];
		$updatedatetime=date('Y-m-d H:i:s');

			$data=array('confirmstatus'=> '1',
				'updateuser'=> $userID,
				'updatedatetime'=> $updatedatetime);

			$this->db->where('idtbl_print_porder_req', $recordID);
			$this->db->update('tbl_print_porder_req', $data);

			$this->db->trans_complete();

			if ($this->db->trans_status()===TRUE) {
				$this->db->trans_commit();

				$actionObj=new stdClass();
				$actionObj->icon='fas fa-check';
				$actionObj->title='';
				$actionObj->message='Order Request Confirm Successfully';
				$actionObj->url='';
				$actionObj->target='_blank';
				$actionObj->type='success';

				$actionJSON=json_encode($actionObj);

				$obj=new stdClass();
				$obj->status=1;
				$obj->action=$actionJSON;

				echo json_encode($obj);
			}

			else {
				$this->db->trans_rollback();

				$actionObj=new stdClass();
				$actionObj->icon='fas fa-warning';
				$actionObj->title='';
				$actionObj->message='Record Error';
				$actionObj->url='';
				$actionObj->target='_blank';
				$actionObj->type='danger';

				$actionJSON=json_encode($actionObj);

				$obj=new stdClass();
				$obj->status=2;
				$obj->action=$actionJSON;

				echo json_encode($obj);
			}
	}
}