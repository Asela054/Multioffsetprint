<?php class Purchaseorderinfo extends CI_Model {
	public function Getcompany() {
		$this->db->select('`idtbl_company`, `company`');
		$this->db->from('tbl_company');
		$this->db->where('status', 1);

		return $respond=$this->db->get();
	}

	public function Getmeasuretype() {
		$this->db->select('`idtbl_mesurements`, `measure_type`');
		$this->db->from('tbl_measurements');
		$this->db->where('status', 1);

		return $respond=$this->db->get();
	}

	public function Getporder() {

		$comapnyID=$_SESSION['company_id'];

		$this->db->select('`idtbl_print_porder_req`,`porder_req_no`');
		$this->db->from('tbl_print_porder_req');
		$this->db->where('status', 1);
		$this->db->where('confirmstatus', 1);
        $this->db->where('porderconfirm', 0);
		$this->db->where('tbl_print_porder_req.company_id', $comapnyID);


		return $respond=$this->db->get();
	}

	public function Getservicetype() {
		$this->db->select('`idtbl_service_type`, `service_name`');
		$this->db->from('tbl_service_type');
		$this->db->where('status', 1);

		return $respond=$this->db->get();
	}

	public function Getsupplier() {

		$companyID=$_SESSION['company_id'];

		$this->db->select('`idtbl_supplier`, `name`');
		$this->db->from('tbl_supplier');
		$this->db->where('status', 1);
		$this->db->where('company_id', $companyID);

		return $respond=$this->db->get();
	}

	public function Getordertype() {
		$this->db->select('`idtbl_order_type`, `type`');
		$this->db->from('tbl_order_type');
		$this->db->where('status', 1);

		return $respond=$this->db->get();
	}

    public function Getproductaccoporder(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `tbl_print_material_info`.`idtbl_print_material_info`, `tbl_print_material_info`.`materialinfocode`, `tbl_print_material_info`.`materialname` FROM `tbl_print_porder_req_detail` LEFT JOIN `tbl_print_material_info` ON `tbl_print_material_info`.`idtbl_print_material_info`=`tbl_print_porder_req_detail`.`tbl_material_id` WHERE `tbl_print_material_info`.`status`=? AND `tbl_print_porder_req_detail`.`tbl_print_porder_idtbl_print_porder`=?";
        $respond=$this->db->query($sql, array(1, $recordID));

        echo json_encode($respond->result());
    }

	public function Getproductformachine() {
		$recordID=$this->input->post('recordID');

		$sql="SELECT `tbl_machine`.`idtbl_machine`, `tbl_machine`.`machine` FROM `tbl_print_porder_req_detail` LEFT JOIN `tbl_machine` ON `tbl_machine`.`idtbl_machine` = `tbl_print_porder_req_detail`.`tbl_machine_id` WHERE `tbl_machine`.`status` = ? AND `tbl_print_porder_req_detail`.`tbl_print_porder_idtbl_print_porder` = ?";
		$respond=$this->db->query($sql, array(1, $recordID));

		echo json_encode($respond->result());
	}


    public function Getservicetyperequest() {
		$recordID=$this->input->post('recordID');

		$sql="SELECT `tbl_service_type`.`idtbl_service_type`, `tbl_service_type`.`service_name` FROM `tbl_print_porder_req_detail` LEFT JOIN `tbl_service_type` ON `tbl_service_type`.`idtbl_service_type` = `tbl_print_porder_req_detail`.`tbl_service_type_id` WHERE `tbl_service_type`.`status` = ? AND `tbl_print_porder_req_detail`.`tbl_print_porder_idtbl_print_porder` = ?";
		$respond=$this->db->query($sql, array(1, $recordID));

		echo json_encode($respond->result());
	}


    public function Getproductforsparepart() {
		$recordID=$this->input->post('recordID');

		$sql="SELECT `tbl_spareparts`.`idtbl_spareparts`, `tbl_spareparts`.`spare_part_name` FROM `tbl_print_porder_req_detail` LEFT JOIN `tbl_spareparts` ON `tbl_spareparts`.`idtbl_spareparts` = `tbl_print_porder_req_detail`.`tbl_sparepart_id` WHERE `tbl_spareparts`.`status` = ? AND `tbl_print_porder_req_detail`.`tbl_print_porder_idtbl_print_porder` = ?";
		$respond=$this->db->query($sql, array(1, $recordID));

		echo json_encode($respond->result());
	}

	public function Getproductinfoaccoproduct() {
		$recordID = $this->input->post('recordID');
		$supplier = $this->input->post('supplier');
	
		$this->db->select('unitprice');
		$this->db->from('tbl_print_material_info');
		$this->db->where('status', 1);
		$this->db->where('idtbl_print_material_info', $recordID);
		$respond = $this->db->get();
	
		$unitprice = $this->getLatestGRNUnitPrice($supplier, $recordID);
	
		$obj = new stdClass();
		if ($respond->num_rows() > 0) {
			$obj->unitprice = ($unitprice !== null) ? $unitprice : $respond->row(0)->unitprice;
		} else {
			$obj->unitprice = 0;
		}
	
		echo json_encode($obj);
	}

	public function Getproductinfosparepart() {
		$recordID = $this->input->post('recordID');
		$supplier = $this->input->post('supplier');
	
		$this->db->select('unit_price');
		$this->db->from('tbl_spareparts');
		$this->db->where('status', 1);
		$this->db->where('idtbl_spareparts', $recordID);
		$respond = $this->db->get();
	
		$unitprice = $this->getLatestGRNUnitPrice($supplier, $recordID);
	
		$obj = new stdClass();
		if ($respond->num_rows() > 0) {
			$obj->unitprice = ($unitprice !== null) ? $unitprice : $respond->row(0)->unit_price;
		} else {
			$obj->unitprice = 0;
		}
	
		echo json_encode($obj);
	}
	
	private function getLatestGRNUnitPrice($supplier, $recordID) {
		$this->db->select('grnd.unitprice');
		$this->db->from('tbl_print_grndetail grnd');
		$this->db->join('tbl_print_grn grn', 'grn.idtbl_print_grn = grnd.tbl_print_grn_idtbl_print_grn');
		$this->db->where('grn.tbl_supplier_idtbl_supplier', $supplier);
		$this->db->where('grnd.tbl_print_material_info_idtbl_print_material_info', $recordID);
		$this->db->where('grn.status', 1);
		$this->db->order_by('grn.insertdatetime', 'desc');
		$this->db->limit(1);
		$result = $this->db->get();
		return ($result->num_rows() > 0) ? $result->row(0)->unitprice : null;
	}
	
	public function Getpiecesforqty() {
		$uomID = $this->input->post('recordID');
		$productId = $this->input->post('productId');
		$qty = $this->input->post('qty');
	
		$this->db->select('qty, measure_type');
		$this->db->from('tbl_material_uom_qty');
		$this->db->join('tbl_measurements', 'tbl_measurements.idtbl_mesurements=tbl_material_uom_qty.measurement');
		$this->db->join('tbl_material_uom_qty_has_tbl_print_material_info', 'tbl_material_uom_qty_has_tbl_print_material_info.tbl_material_uom_qty_idtbl_material_uom_qty =tbl_material_uom_qty.idtbl_material_uom_qty');
		$this->db->where('tbl_print_material_info_idtbl_print_material_info', $productId);
		$this->db->where('tbl_measurements_idtbl_measurements', $uomID);
		$this->db->where('tbl_material_uom_qty.status', 1);
	
		$query = $this->db->get();
		$result = $query->row();
	
		$response = new stdClass();
		if ($result) {
			$response->piecesper_qty = $result->qty*$qty;  
			$response->measure_type = $result->measure_type;  
		} else {
			$response->piecesper_qty = 0;
			$response->measure_type = 0;
		}
	
		echo json_encode($response);
	}

    public function Getproductinfoamachine(){
        $recordID=$this->input->post('recordID');
		$purchaseorder_id=$this->input->post('purchaseorder_id');

        $this->db->select('`qty`, `unitprice`, `measure_type_id`');
        $this->db->from('tbl_print_porder_req_detail');
        $this->db->where('status', 1);
		$this->db->where('tbl_print_porder_idtbl_print_porder', $purchaseorder_id);
        $this->db->where('tbl_machine_id', $recordID);
        $respond=$this->db->get();

		$this->db->select('*');
        $this->db->from('tbl_print_stock');
        $this->db->where('status', 1);
		$this->db->where('tbl_machine_id ', $recordID);
		$this->db->order_by('idtbl_print_stock', 'desc');
		$this->db->limit(1);
        $respond2=$this->db->get();
		$count = $respond2->num_rows();

		$unitprice='';
		if($respond2->num_rows()>0){
            $obj=new stdClass();
            $unitprice=$respond2->row(0)->unitprice;
        }


        if($respond->num_rows()>0){
            $obj=new stdClass();
            $obj->qty=$respond->row(0)->qty;
			($count==0 ?  $obj->unitprice=$respond->row(0)->unitprice : $obj->unitprice=$unitprice);
            $obj->uom=$respond->row(0)->measure_type_id;
        }

        else{
            $obj=new stdClass();
            $obj->qty=0;
            $obj->unitprice=0;
            $obj->uom='';
        }
        echo json_encode($obj);
    }


    public function Getproductinfoservice(){
        $recordID=$this->input->post('recordID');
		$purchaseorder_id=$this->input->post('purchaseorder_id');

        $this->db->select('`qty`, `unitprice`, `measure_type_id`');
        $this->db->from('tbl_print_porder_req_detail');
        $this->db->where('status', 1);
		$this->db->where('tbl_print_porder_idtbl_print_porder', $purchaseorder_id);
        $this->db->where('tbl_service_type_id', $recordID);

        $respond=$this->db->get();

        if($respond->num_rows()>0){
            $obj=new stdClass();
            $obj->qty=$respond->row(0)->qty;
            $obj->unitprice=$respond->row(0)->unitprice;
            $obj->uom=$respond->row(0)->measure_type_id;
        }

        else{
            $obj=new stdClass();
            $obj->qty=0;
            $obj->unitprice=0;
            $obj->uom='';
        }
        echo json_encode($obj);
    }


	public function Purchaseorderinsertupdate() {
		$this->db->trans_begin();

		$userID=$_SESSION['userid'];

		$comapnyID=$_SESSION['company_id'];

		$date1 = $this->input->post('orderdate');
            $current = new DateTime($date1);
            
            $currentYear = $current->format('Y'); 
            $currentMonth = $current->format('m'); 
            
            if ($currentMonth < 4) { //03
                $startDate = new DateTime(($currentYear-1)."-04-01");
                $endDate = new DateTime($currentYear . "-03-31");
            } else {
                $startDate = new DateTime("$currentYear-04-01");
                $endDate = new DateTime(($currentYear + 1) . "-03-31");
            }
            
            $fromyear = $startDate->format('Y-m-d');
            $toyear = $endDate->format('Y-m-d');
            
            $query = $this->db->query("SELECT porder_no FROM tbl_print_porder WHERE company_id = $comapnyID AND `orderdate` BETWEEN '$fromyear' AND '$toyear' ORDER BY porder_no DESC LIMIT 1");
            
            if ($query->num_rows() > 0) {
                $last_req_no = $query->row()->porder_no;
                $po_number = intval(substr($last_req_no, -4)); 
                $count = $po_number;
            } else {
                $count = 0;
            }


		$tableData=$this->input->post('tableData');
		$orderdate=$this->input->post('orderdate');
		$discounttotal=$this->input->post('discounttotal');
		$vatamounttotal=$this->input->post('vatamounttotal');
		$grosstotal=$this->input->post('grosstotal');
		$total=$this->input->post('total');
		$remark=$this->input->post('remark');
		$supplier=$this->input->post('supplier');
		$location=$this->input->post('location');
		$ordertype=$this->input->post('ordertype');
		$company_id=$this->input->post('company_id');
		$branch_id=$this->input->post('branch_id');
		$porderrequest=$this->input->post('porderrequest');

		$updatedatetime=date('Y-m-d H:i:s');

		$data=array('orderdate'=> $orderdate,
			'duedate'=> 'null',
			'subtotal'=>'0',
			'vattotamount'=> '0',
			'discountamount'=> '0',
			'nettotal'=>$grosstotal,
			'confirmstatus'=> '0',
			'grnconfirm'=>'0',
			'remark'=> $remark,
			'company_id'=> $company_id, 
			'company_branch_id'=> $branch_id, 
			'status'=> '1',
			'tbl_service_type_idtbl_service_type'=>'0',
			'insertdatetime'=> $updatedatetime,
			'tbl_user_idtbl_user'=> $userID,
			'tbl_location_idtbl_location'=> '0',
			'tbl_supplier_idtbl_supplier'=> $supplier,
			'tbl_order_type_idtbl_order_type'=> $ordertype,
			'tbl_print_porder_req_idtbl_print_porder_req '=> $porderrequest,

		);

		$this->db->insert('tbl_print_porder', $data);

		$porderID=$this->db->insert_id();


		$result_array = array();
            $querydetails = $this->db->query("SELECT idtbl_print_porder FROM tbl_print_porder WHERE idtbl_print_porder = $porderID");
            if ($querydetails) {
                $result_array = $querydetails->result_array();
            }
    
            foreach ($result_array as $row) {
                $id = $row['idtbl_print_porder'];
    
                $count++; 
                $countPrefix = sprintf('%04d', $count);

                $invoiceDate = new DateTime($updatedatetime);
                $year = (int) $invoiceDate->format('Y');
                $month = (int) $invoiceDate->format('m');

                if ($month < 4) {
                    $year -= 1;
                }

                $yearDigit = substr($year, -2);

                $po_no = 'PO' . $yearDigit . $countPrefix;

                $invodetail = array(
                    'porder_no'=> $po_no, 
                    'updatedatetime'=> $updatedatetime
                );
        
                $this->db->where('idtbl_print_porder', $id);
                $this->db->update('tbl_print_porder', $invodetail);
            }

		if($ordertype==3) {
			foreach ($tableData as $rowtabledata) {
				$materialname=$rowtabledata['col_1'];
				$comment=$rowtabledata['col_2'];
				$materialID=$rowtabledata['col_3'];
				$qty=$rowtabledata['col_4'];
				$uom=$rowtabledata['col_5'];
				$uomID=$rowtabledata['col_6'];
				$unit=$rowtabledata['col_7'];
				$packetprice=$rowtabledata['col_8'];
				$nettotal=$rowtabledata['col_9'];
				$pieces=$rowtabledata['col_11'];
				

				$dataone=array(
					'qty'=> $qty,
					'pieces'=> $pieces,
					'unitprice'=> $unit,
					'packetprice'=> $packetprice,
					'discount'=>'0',
					'vat'=>'0',
					'measure_type_id'=> $uomID,
					'vatamount'=>'0',
					'grossprice'=>'0',
					'netprice'=>  $nettotal,
					'comment'=> $comment,
					'status'=> '1',
					'insertdatetime'=> $updatedatetime,
					'tbl_print_porder_idtbl_print_porder'=> $porderID,
					'tbl_material_id'=> $materialID,
					
				);

				$this->db->insert('tbl_print_porder_detail', $dataone);
			}
		}

		else if($ordertype==4) {
			foreach ($tableData as $rowtabledata) {
				$materialname=$rowtabledata['col_1'];
				$comment=$rowtabledata['col_2'];
				$materialID=$rowtabledata['col_3'];
				$qty=$rowtabledata['col_4'];
				$uom=$rowtabledata['col_5'];
				$uomID=$rowtabledata['col_6'];
				$unit=$rowtabledata['col_7'];
				$nettotal=$rowtabledata['col_8'];

				$dataone=array('qty'=> $qty,
					'unitprice'=> $unit,
					'measure_type_id'=> $uomID,
					'discount'=>'0',
					'vat'=> '0',
					'vatamount'=>'0',
					'grossprice'=>'0',
					'netprice'=> $nettotal,
					'comment'=> $comment,
					'status'=> '1',
					'insertdatetime'=> $updatedatetime,
					'tbl_print_porder_idtbl_print_porder'=> $porderID,
					'tbl_machine_id'=> $materialID,
				);

				$this->db->insert('tbl_print_porder_detail', $dataone);
			}
		}

		else if($ordertype==1) {
			foreach ($tableData as $rowtabledata) {
				$materialname=$rowtabledata['col_1'];
				$comment=$rowtabledata['col_2'];
				$materialID=$rowtabledata['col_3'];
				$qty=$rowtabledata['col_4'];
				$uom=$rowtabledata['col_5'];
				$uomID=$rowtabledata['col_6'];
				$unit=$rowtabledata['col_7'];
				$nettotal=$rowtabledata['col_8'];

				$dataone=array('qty'=> $qty,
					'unitprice'=> $unit,
					'measure_type_id'=> $uomID,
					'discount'=>'0',
					'vat'=> '0',
					'vatamount'=>'0',
					'grossprice'=>'0',
					'netprice'=> $nettotal,
					'comment'=> $comment,
					'status'=> '1',
					'insertdatetime'=> $updatedatetime,
					'tbl_print_porder_idtbl_print_porder'=> $porderID,
					'tbl_sparepart_id'=> $materialID,
				);

				$this->db->insert('tbl_print_porder_detail', $dataone);
			}
		}

		else {
			foreach ($tableData as $rowtabledata) {
				$materialname=$rowtabledata['col_1'];
				$comment=$rowtabledata['col_2'];
				$materialID=$rowtabledata['col_3'];
				$qty=$rowtabledata['col_4'];
				$uom=$rowtabledata['col_5'];
				$uomID=$rowtabledata['col_6'];
				$unit=$rowtabledata['col_7'];
				$nettotal=$rowtabledata['col_8'];

				$dataone=array('qty'=> $qty,
					'unitprice'=> $unit,
					'measure_type_id'=> $uomID,
					'discount'=>'0',
					'vat'=>'0',
					'vatamount'=>'0',
					'grossprice'=> '0',
					'netprice'=> $nettotal,
					'comment'=> $comment,
					'status'=> '1',
					'insertdatetime'=> $updatedatetime,
					'tbl_print_porder_idtbl_print_porder'=> $porderID,
					'tbl_service_type_id'=> $materialID,
				);

				$this->db->insert('tbl_print_porder_detail', $dataone);
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

	public function Purchaseorderview() {
		$recordID=$this->input->post('recordID');

		$sql="SELECT `u`.*, `ua`.`name`, `ua`.`address_line1`, `ub`.`location`, `ub`.`phone`, `ub`.`address`, `ub`.`phone2`, `ub`.`email` AS `locemail` FROM `tbl_print_porder` AS `u` LEFT JOIN `tbl_supplier` AS `ua` ON (`ua`.`idtbl_supplier` = `u`.`tbl_supplier_idtbl_supplier`) LEFT JOIN `tbl_location` AS `ub` ON (`ub`.`idtbl_location` = `u`.`tbl_location_idtbl_location`) WHERE `u`.`status`=? AND `u`.`idtbl_print_porder`=?";
		$respond=$this->db->query($sql, array(1, $recordID));

		$this->db->select('tbl_print_porder_detail.*,tbl_print_porder.orderdate As orderdate,tbl_print_porder.tbl_order_type_idtbl_order_type, tbl_print_material_info.materialinfocode, tbl_print_material_info.materialname,tbl_machine.machine,tbl_machine.machinecode, tbl_service_type.service_name, tbl_measurements.measure_type');
		$this->db->from('tbl_print_porder_detail');
		$this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_print_porder_detail.tbl_material_id', 'left');
		$this->db->join('tbl_measurements', 'tbl_measurements.idtbl_mesurements = tbl_print_porder_detail.measure_type_id', 'left'); // get measurements 
		$this->db->join('tbl_machine', 'tbl_machine.idtbl_machine = tbl_print_porder_detail.tbl_machine_id', 'left');
		$this->db->join('tbl_print_porder', 'tbl_print_porder.idtbl_print_porder = tbl_print_porder_detail.tbl_print_porder_idtbl_print_porder', 'left');
		$this->db->join('tbl_service_type', 'tbl_service_type.idtbl_service_type = tbl_print_porder_detail.tbl_service_type_id', 'left'); // Add this line to join tbl_service_type
		$this->db->where('tbl_print_porder_detail.tbl_print_porder_idtbl_print_porder', $recordID);
		$this->db->where('tbl_print_porder_detail.status', 1);

		$responddetail=$this->db->get();

		$html='';

		$html.='
<div class="row"></div><div class="row"><div class="col-12"><hr><table class="table table-striped table-bordered table-sm"><thead><tr><th>Product Info</th><th class="text-right">Unit Price</th><th class="text-right">Qty</th><th class="text-center">Uom</th><th class="text-right">Total</th></tr></thead><tbody>';
foreach($responddetail->result() as $roworderinfo) {
			if($roworderinfo->tbl_order_type_idtbl_order_type==3) {
				$html .= '<tr>
				<td>' . $roworderinfo->materialname . '/ ' . $roworderinfo->materialinfocode . '</td>
				<td class="text-right">' . (!empty($roworderinfo->packetprice) ? $roworderinfo->packetprice : $roworderinfo->unitprice) . '</td>
				<td class="text-right">' . $roworderinfo->qty . '</td>
				<td class="text-center">' . $roworderinfo->measure_type . '</td>
				<td class="text-right">' . number_format(($roworderinfo->netprice), 2) . '</td>
			</tr>';			

			}

			else if($roworderinfo->tbl_order_type_idtbl_order_type==4) {
				$html.='<tr>
<td>'.$roworderinfo->machine.'/ '.$roworderinfo->machinecode.'</td><td class="text-right">'.$roworderinfo->unitprice.'</td><td class="text-right">'.$roworderinfo->qty.'</td><td class="text-center">'.$roworderinfo->measure_type.'</td><td class="text-right">'.number_format(($roworderinfo->netprice), 2).'</td></tr>';

			}

			else {
				$html.='<tr>
<td>'.$roworderinfo->service_name.'</td><td class="text-right">'.$roworderinfo->unitprice.'</td><td class="text-right">'.$roworderinfo->qty.'</td><td class="text-center">'.$roworderinfo->measure_type.'</td><td class="text-right">'.number_format(($roworderinfo->netprice), 2).'</td></tr>';

			}
		}

$html .= '</tbody></table></div></div><div class="row mt-3" ><div class="col-12 text-right"><h3 class="font-weight-normal"><strong style="background-color: yellow;">Final Price</strong> &nbsp; &nbsp;<b>Rs. ' . number_format(($respond->row(0)->nettotal), 2) . '</b></h3></div></div>';

echo $html;

	}

	public function porderviewheader() {
		$recordID=$this->input->post('recordID');

		$this->db->select('tbl_print_porder.*,tbl_supplier.name AS suppliername,tbl_supplier.telephone_no AS suppliercontact,tbl_supplier.address_line1 AS address1,tbl_supplier.address_line2 AS address2,tbl_supplier.city AS city,tbl_supplier.state AS supplierstate,
								tbl_company.company AS companyname,tbl_company.address1 As companyaddress,tbl_company.mobile AS companymobile,
                                tbl_company.phone companyphone,tbl_company.email AS companyemail,
                                tbl_company_branch.branch AS branchname');
		$this->db->from('tbl_print_porder');
		$this->db->join('tbl_supplier', 'tbl_supplier.idtbl_supplier  = tbl_print_porder.tbl_supplier_idtbl_supplier ', 'left');
		$this->db->join('tbl_company', 'tbl_company.idtbl_company = tbl_print_porder.company_id', 'left');
		$this->db->join('tbl_company_branch', 'tbl_company_branch.idtbl_company_branch = tbl_print_porder.company_branch_id', 'left');
		$this->db->where('idtbl_print_porder', $recordID);
		$this->db->where('tbl_print_porder.status', 1);

		$respond=$this->db->get();

		$obj=new stdClass();
		$obj->orderdate=$respond->row(0)->orderdate;
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

	public function Purchaseorderstatus() {
		$this->db->trans_begin();

		$userID=$_SESSION['userid'];
		$recordID=$this->input->post('approvebtn');
        $porderid=$this->input->post('porderrequestid');
		$updatedatetime=date('Y-m-d H:i:s');

		// if($type==1) {
			$data=array('confirmstatus'=> '1',
				'updateuser'=> $userID,
				'updatedatetime'=> $updatedatetime);

			$this->db->where('idtbl_print_porder', $recordID);
			$this->db->update('tbl_print_porder', $data);

            $data1 = array(
                'porderconfirm' => '1',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_print_porder_req', $porderid);
            $this->db->update('tbl_print_porder_req', $data1);


			$this->db->select('tbl_print_porder.idtbl_print_porder,tbl_print_porder.orderdate, tbl_print_porder.nettotal,tbl_print_porder.tbl_order_type_idtbl_order_type,tbl_print_porder.tbl_supplier_idtbl_supplier');
			$this->db->from('tbl_print_porder');
			$this->db->where('tbl_print_porder.status', 1);
			$this->db->where('tbl_print_porder.idtbl_print_porder', $recordID);

			$respond=$this->db->get();

			if ($respond->num_rows() > 0) {
				foreach ($respond->result() as $row) {
					$grnid=$row->idtbl_print_porder;
					$totalamount=$row->nettotal;
					$supplier=$row->tbl_supplier_idtbl_supplier;
					$grndate=$row->orderdate;
					$orderType=$row->tbl_order_type_idtbl_order_type;


					if ($orderType == 2) {
						$accountsData = array(
							'grndate' => $grndate,
							'tbl_supplier_idtbl_supplier' => $supplier,
							'exptype' => '2',
							'grnno' => $grnid,
							'expcode' => 'SER',
							'amount' => $totalamount,
							'status' => '1',
							'insertdatetime' => $updatedatetime,
							'tbl_user_idtbl_user' => $userID
						);
						$this->db->insert('tbl_expence_info', $accountsData);
					} elseif ($orderType == 3 || $orderType == 4) {
					}
				}
			}



			$this->db->trans_complete();

			if ($this->db->trans_status()===TRUE) {
				$this->db->trans_commit();

				$actionObj=new stdClass();
				$actionObj->icon='fas fa-check';
				$actionObj->title='';
				$actionObj->message='Purchase Order Confirm Successfully';
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

	public function Getsupplieraccoporderreq() {
		$recordID=$this->input->post('recordID');

		$this->db->select('`tbl_supplier_idtbl_supplier`');
		$this->db->from('tbl_print_porder_req');
		$this->db->where('status', 1);
		$this->db->where('idtbl_print_porder_req', $recordID);

		$respond=$this->db->get();

		echo $respond->row(0)->tbl_supplier_idtbl_supplier;
	}

	public function Getporderreqdetails() {
		$recordID = $this->input->post('recordID');
		
		$this->db->select('requestname, qty, measure_type, type');
		$this->db->from('tbl_print_porder_req_detail');
		$this->db->join('tbl_print_porder_req', 'tbl_print_porder_req.idtbl_print_porder_req = tbl_print_porder_req_detail.tbl_print_porder_idtbl_print_porder', 'left');
		$this->db->join('tbl_order_type', 'tbl_order_type.idtbl_order_type = tbl_print_porder_req.tbl_order_type_idtbl_order_type ', 'left');
		$this->db->join('tbl_measurements', 'tbl_measurements.idtbl_mesurements = tbl_print_porder_req_detail.measure_type_id', 'left');
		$this->db->where('tbl_print_porder_req_detail.status', 1);
		$this->db->where('tbl_print_porder_idtbl_print_porder', $recordID);
		
		$response = $this->db->get();
		
		if ($response->num_rows() > 0) {
			$result = [];
			foreach ($response->result() as $row) {
				$result[] = [
					'requestname' => $row->requestname,
					'qty' => $row->qty,
					'measure_type' => $row->measure_type,
					'order_type' => $row->type
				];
			}
			echo json_encode($result);
		} else {
			echo json_encode([]);
		}
	}			

	public function getProductsByType() {
		$companyID=$_SESSION['company_id'];
		$branchID=$_SESSION['branch_id'];
		$searchTerm=$this->input->post('searchTerm');
		$ordertype = $this->input->post('ordertype');

        if ($ordertype == 1) {
            $this->db->select('idtbl_spareparts as id, spare_part_name as name');
			$this->db->where('status', 1);
			$this->db->where('company_id', $companyID);
            $query = $this->db->get('tbl_spareparts');
        } elseif ($ordertype == 2) {
            $this->db->select('idtbl_service_type as id, service_name as name');
			$this->db->where('status', 1);
			$this->db->where('company_id', $companyID);
            $query = $this->db->get('tbl_service_type');
        } elseif ($ordertype == 3) {
			if(!isset($searchTerm)){
				$this->db->select('idtbl_print_material_info as id, materialname as name');
				$this->db->where('status', 1);
				$this->db->where('company_id', $companyID);
				$this->db->limit(5);
				$query = $this->db->get('tbl_print_material_info');                     
			}
			else{            
				if(!empty($searchTerm)){
					$this->db->select('idtbl_print_material_info as id, materialname as name');
					$this->db->where('status', 1);
					$this->db->where('company_id', $companyID);
					$this->db->like('materialname', $searchTerm, 'after');
					$query = $this->db->get('tbl_print_material_info');  
				}
				else{
					$this->db->select('idtbl_print_material_info as id, materialname as name');
					$this->db->where('status', 1);
					$this->db->where('company_id', $companyID);
					$this->db->limit(5);
					$query = $this->db->get('tbl_print_material_info');             
				}
			}            
        } elseif ($ordertype == 4) {
            $this->db->select('idtbl_machine as id, machine as name');
			$this->db->where('status', 1);
			$this->db->where('company_id', $companyID);
            $query = $this->db->get('tbl_machine');
        }
        
		$data=array();
        
        foreach ($query->result() as $row) {
            $data[]=array("id"=>$row->id, "text"=>$row->name);
        }
        
        echo json_encode($data);
    }

	public function GetSemimateriallist(){
        $searchTerm=$this->input->post('searchTerm');

        if(!isset($searchTerm)){
            $sql="SELECT `tbl_material_info`.`idtbl_material_info`, `tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname`, `tbl_unit`.`unitcode` FROM `tbl_material_info` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code` LEFT JOIN `tbl_unit` ON `tbl_unit`.`idtbl_unit`=`tbl_material_info`.`tbl_unit_idtbl_unit` WHERE `tbl_material_info`.`status`=? AND `tbl_material_info`.`semistatus`=? LIMIT 5";
            $respond=$this->db->query($sql, array(1, 1));                       
        }
        else{            
            if(!empty($searchTerm)){
                $sql="SELECT `tbl_material_info`.`idtbl_material_info`, `tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname`, `tbl_unit`.`unitcode` FROM `tbl_material_info` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code` LEFT JOIN `tbl_unit` ON `tbl_unit`.`idtbl_unit`=`tbl_material_info`.`tbl_unit_idtbl_unit` WHERE `tbl_material_info`.`status`=? AND `tbl_material_info`.`semistatus`=? AND `tbl_material_code`.`materialname` LIKE '$searchTerm%'";
                $respond=$this->db->query($sql, array(1, 1));    
            }
            else{
                $sql="SELECT `tbl_material_info`.`idtbl_material_info`, `tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname`, `tbl_unit`.`unitcode` FROM `tbl_material_info` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code` LEFT JOIN `tbl_unit` ON `tbl_unit`.`idtbl_unit`=`tbl_material_info`.`tbl_unit_idtbl_unit` WHERE `tbl_material_info`.`status`=? AND `tbl_material_info`.`semistatus`=? LIMIT 5";
                $respond=$this->db->query($sql, array(1, 1));                
            }
        }
        
        $data=array();
        
        foreach ($respond->result() as $row) {
            $data[]=array("id"=>$row->idtbl_material_info, "text"=>$row->materialname.' - '.$row->materialinfocode.'/'.$row->unitcode);
        }
        
        echo json_encode($data);
    }

	public function Getpordertpeaccoporderrequest() {
		$recordID=$this->input->post('recordID');

		$this->db->select('`tbl_order_type_idtbl_order_type`');
		$this->db->from('tbl_print_porder_req');
		$this->db->where('status', 1);
		$this->db->where('idtbl_print_porder_req', $recordID);

		$respond=$this->db->get();

		echo $respond->row(0)->tbl_order_type_idtbl_order_type;
	}

	public function Getmesuretpeaccorproduct() {
		$recordID=$this->input->post('recordID');

		$this->db->select('`measure_type_id`');
		$this->db->from('tbl_print_porder_req_detail');
		$this->db->where('status', 1);
		$this->db->where('tbl_print_porder_idtbl_print_porder', $recordID);

		$respond=$this->db->get();

		echo $respond->row(0)->measure_type_id;
	}
}