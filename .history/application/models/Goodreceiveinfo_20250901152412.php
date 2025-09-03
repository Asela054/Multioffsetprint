<?php class Goodreceiveinfo extends CI_Model {

	public function Getlocation() {
		$this->db->select('`idtbl_location`, `location`');
		$this->db->from('tbl_location');
		$this->db->where('status', 1);

		return $respond=$this->db->get();
	}

	public function Getcompany() {
		$this->db->select('`idtbl_company`, `company`');
		$this->db->from('tbl_company');
		$this->db->where('status', 1);

		return $respond=$this->db->get();
	}

	public function Getcompanybranch() {
		$this->db->select('`idtbl_company_branch`, `branch`');
		$this->db->from('tbl_company_branch');
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

		$this->db->select('`idtbl_print_porder`,`porder_no`');
		$this->db->from('tbl_print_porder');
		$this->db->where('status', 1);
		$this->db->where('confirmstatus', 1);
		$this->db->where_in('grnconfirm', [0, 2]);
		$this->db->where_in('tbl_material_group_idtbl_material_group', array(1, , 4));
		$this->db->where('tbl_company_idtbl_company', $comapnyID);


		return $respond=$this->db->get();
	}

	public function Getproductaccosupplier() {
		$recordID=$this->input->post('recordID');

		$sql="SELECT `tbl_print_material_info`.`idtbl_print_material_info`, `tbl_print_material_info`.`materialinfocode`, `tbl_material_code`.`materialname` FROM `tbl_print_material_info` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_print_material_info`.`tbl_material_code_idtbl_material_code` WHERE `tbl_print_material_info`.`status`=? AND `tbl_print_material_info`.`tbl_material_category_idtbl_material_category` IN (SELECT `tbl_material_category_idtbl_material_category` FROM `tbl_supplier_has_tbl_material_category` WHERE `tbl_supplier_idtbl_supplier`=?)";
		$respond=$this->db->query($sql, array(1, $recordID));

		echo json_encode($respond->result());
	}

	public function Getgoodreceiveid() {
		$recordID=$this->input->post('recordID');

		$sql="SELECT `idtbl_print_grn` FROM `tbl_print_grn` WHERE `idtbl_print_grn`=? AND `status`=1";
		$respond=$this->db->query($sql, array($recordID));

		echo json_encode($respond->result());
	}

	public function Goodreceiveinsertupdate() {
		$this->db->trans_begin();

		$userID=$_SESSION['userid'];

		$companyID=$_SESSION['company_id'];

		$tableData=$this->input->post('tableData');
		$grndate=$this->input->post('grndate');
		$total=$this->input->post('total');
		$vatamount=$this->input->post('vatamount');
		$remark=$this->input->post('remark');
		$supplier=$this->input->post('supplier');
		$location=$this->input->post('location');
		$company_id=$this->input->post('company_id');
		$branch_id=$this->input->post('branch_id');
		$porder=$this->input->post('porder');
		$batchno=$this->input->post('batchno');
		$invoice=$this->input->post('invoice');
		$discount=$this->input->post('discount');
		$grntype=$this->input->post('grntype');
		$vat_type=$this->input->post('vat_type');
		$subtotal=$this->input->post('subtotal');
		$vat=$this->input->post('vat');

		$updatedatetime=date('Y-m-d H:i:s');

		$data=array(
			'batchno'=> $batchno,
			'grntype'=> $grntype,
			'grndate'=> $grndate,
			'total'=> $total,
			'invoicenum'=> $invoice,
			'discount'=> $discount,
			'approvestatus'=> '0',
			'subtotal'=> $subtotal, 
			'vatamount'=> $vatamount, 
			'remark'=> $remark, 
			'vat'=> $vat, 
			'vat_type'=> $vat_type, 
			'tbl_company_idtbl_company'=> $company_id, 
			'tbl_company_branch_idtbl_company_branch'=> $branch_id, 
			'subtotalcost'=> $subtotal, 
			'discountcost'=> $discount, 
			'vatamountcost'=> $vatamount, 
			'totalcost'=> $total, 
			'status'=> '1',
			'insertdatetime'=> $updatedatetime,
			'tbl_user_idtbl_user'=> $userID,
			'tbl_supplier_idtbl_supplier'=> $supplier,
			'tbl_location_idtbl_location'=> $location,
			'tbl_print_porder_idtbl_print_porder'=> $porder,
			'tbl_material_group_idtbl_material_group'=> $grntype);

		$this->db->insert('tbl_print_grn', $data);

		$grnID=$this->db->insert_id();

		if($grntype==3) {
			foreach($tableData as $rowtabledata) {
				$materialname=$rowtabledata['col_1'];
				$comment=$rowtabledata['col_2'];
				$materialID=$rowtabledata['col_3'];
				$unit=$rowtabledata['col_4'];
				$qty=$rowtabledata['col_5'];
				$uom=$rowtabledata['col_6'];
				$packetprice=$rowtabledata['col_7'];
				$unit_discount=$rowtabledata['col_8'];
				$uomID=$rowtabledata['col_9'];
				$nettotal=$rowtabledata['col_10'];
				$porderdetailsid=$rowtabledata['col_12'];
				$pieces=$rowtabledata['col_13'];

				$dataone=array('date'=> $grndate,
					'qty'=> $qty,
					'pieces'=> $pieces,
					'unitprice'=> $unit,
					'packetprice'=> $packetprice,
					'costunitprice'=> $unit,
					'total'=> $nettotal,
					'comment'=> $comment,
					'tbl_measurements_idtbl_mesurements'=> $uomID,
					'unit_discount'=> $unit_discount,
					'expdate'=> '',
					'quater'=> '',
					'status'=> '1',
					'insertdatetime'=> $updatedatetime,
					'tbl_user_idtbl_user'=> $userID,
					'tbl_print_grn_idtbl_print_grn'=> $grnID,
					'tbl_print_material_info_idtbl_print_material_info'=> $materialID);

				$this->db->insert('tbl_print_grndetail', $dataone);
			}
		}

		else if($grntype==4) {
			foreach($tableData as $rowtabledata) {
				$materialname=$rowtabledata['col_1'];
				$comment=$rowtabledata['col_2'];
				$materialID=$rowtabledata['col_3'];
				$unit=$rowtabledata['col_4'];
				$qty=$rowtabledata['col_5'];
				$uom=$rowtabledata['col_6'];
				$uomID=$rowtabledata['col_7'];
				$nettotal=$rowtabledata['col_8'];
				$porderdetailsid=$rowtabledata['col_11'];


				$dataone=array('date'=> $grndate,
					'qty'=> $qty,
					'unitprice'=> $unit,
					'costunitprice'=> $unit,
					'total'=> $nettotal,
					'comment'=> $comment,
					'tbl_measurements_idtbl_mesurements'=> $uomID,
					'mfdate'=> '',
					'expdate'=> '',
					'quater'=> '',
					'status'=> '1',
					'insertdatetime'=> $updatedatetime,
					'tbl_user_idtbl_user'=> $userID,
					'tbl_print_grn_idtbl_print_grn'=> $grnID,
					'tbl_machine_id'=> $materialID);

				$this->db->insert('tbl_print_grndetail', $dataone);
			}
		}

		else if($grntype==1) {
			foreach($tableData as $rowtabledata) {
				$materialname=$rowtabledata['col_1'];
				$comment=$rowtabledata['col_2'];
				$materialID=$rowtabledata['col_3'];
				$unit=$rowtabledata['col_4'];
				$qty=$rowtabledata['col_5'];
				$uom=$rowtabledata['col_6'];
				$uomID=$rowtabledata['col_7'];
				$nettotal=$rowtabledata['col_8'];
				$porderdetailsid=$rowtabledata['col_11'];

				$dataone=array('date'=> $grndate,
					'qty'=> $qty,
					'unitprice'=> $unit,
					'costunitprice'=> $unit,
					'total'=> $nettotal,
					'comment'=> $comment,
					'tbl_measurements_idtbl_mesurements'=> $uomID,
					'mfdate'=> '',
					'expdate'=> '',
					'quater'=> '',
					'status'=> '1',
					'insertdatetime'=> $updatedatetime,
					'tbl_user_idtbl_user'=> $userID,
					'tbl_print_grn_idtbl_print_grn'=> $grnID,
					'tbl_sparepart_id'=> $materialID);

				$this->db->insert('tbl_print_grndetail', $dataone);
			}
		}

		// Generate the GRN NO
		
		$currentYear = date("Y", strtotime($grndate));
		$currentMonth = date("m", strtotime($grndate));
	
		if ($currentMonth < 4) { //03
			$startDate = $currentYear."-04-01";
			$startDate = date('Y-m-d',  strtotime($startDate.'-1 year'));
			$endDate = $currentYear."-03-31";
		} else {
			$startDate = $currentYear."-04-01";
			$endDate = $currentYear."-03-31";
			$endDate = date('Y-m-d',  strtotime($endDate.'+1 year'));
		}
	
		$fromyear = date("Y-m-d", strtotime($startDate));
		$toyear = date("Y-m-d", strtotime($endDate));

		$this->db->select('grn_no');
		$this->db->from('tbl_print_grn');
		$this->db->where('tbl_company_idtbl_company', $companyID);
        $this->db->where("DATE(insertdatetime) >=", $fromyear);
        $this->db->where("DATE(insertdatetime) <=", $toyear);
		$this->db->order_by('grn_no', 'DESC');
		$this->db->limit(1);
		$respond = $this->db->get();
		
		if ($respond->num_rows() > 0) {
			$last_grn_no = $respond->row()->grn_no;
			$grn_number = intval(substr($last_grn_no, -4));
			$count = $grn_number;
		} else {
			$count = 0;
		}

		$count++; 
		$countPrefix = sprintf('%04d', $count);

		$yearDigit = substr(date("Y", strtotime($fromyear)), -2);

		$reqno = 'GRN' . $yearDigit . $countPrefix;

		$datadetail = array(
			'grn_no'=> $reqno, 
			'updatedatetime'=> $updatedatetime
		);

		$this->db->where('idtbl_print_grn', $grnID);
		$this->db->update('tbl_print_grn', $datadetail);

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

	public function Goodreceiveview() {
		$recordID=$this->input->post('recordID');

		$sql="SELECT `u`.*, `ua`.`suppliername`, `ua`.`telephone_no`, `ua`.`address_line1`, `ub`.`branch`, `ub`.`phone`, `ub`.`address1`, `ub`.`address2`, `ub`.`mobile`, `ub`.`email` AS `locemail`, `uc`.`company` FROM `tbl_print_grn` AS `u` LEFT JOIN `tbl_supplier` AS `ua` ON (`ua`.`idtbl_supplier` = `u`.`tbl_supplier_idtbl_supplier`) LEFT JOIN `tbl_company_branch` AS `ub` ON (`ub`.`idtbl_company_branch` = `u`.`tbl_company_branch_idtbl_company_branch`) LEFT JOIN `tbl_company` AS `uc` ON (`uc`.`idtbl_company` = `u`.`tbl_company_idtbl_company`) WHERE `u`.`status`=? AND `u`.`idtbl_print_grn`=?";
		$respond=$this->db->query($sql, array(1, $recordID));

		$this->db->select('tbl_print_grndetail.*,tbl_print_grn.grndate,tbl_print_grn.grn_no,tbl_print_grn.tbl_material_group_idtbl_material_group, tbl_print_material_info.materialinfocode, tbl_print_material_info.materialname,tbl_machine.machine,tbl_machine.machinecode,tbl_spareparts.spare_part_name,tbl_measurements.measure_type');
		$this->db->from('tbl_print_grndetail');
		$this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_print_grndetail.tbl_print_material_info_idtbl_print_material_info', 'left');
		$this->db->join('tbl_print_grn', 'tbl_print_grn.idtbl_print_grn = tbl_print_grndetail.tbl_print_grn_idtbl_print_grn', 'left');
		$this->db->join('tbl_machine', 'tbl_machine.idtbl_machine = tbl_print_grndetail.tbl_machine_id', 'left');
		$this->db->join('tbl_spareparts', 'tbl_spareparts.idtbl_spareparts = tbl_print_grndetail.tbl_sparepart_id', 'left');//for sparepart get
		$this->db->join('tbl_measurements', 'tbl_measurements.idtbl_mesurements = tbl_print_grndetail.tbl_measurements_idtbl_mesurements', 'left');
		$this->db->where('tbl_print_grndetail.tbl_print_grn_idtbl_print_grn', $recordID);
		$this->db->where('tbl_print_grndetail.status', 1);

		$responddetail=$this->db->get();

		$html='';

		$html.='
				        <div class="row">
            <div class="col-6 small"><label class="small font-weight-bold text-dark mb-1">Date:</label> '.$responddetail->row(0)->grndate.'<br><label class="small font-weight-bold text-dark mb-1">PO No:</label> '.$responddetail->row(0)->grn_no.'<br><label class="small font-weight-bold text-dark mb-1">Customer:</label> '.$respond->row(0)->suppliername.'</div>
            <div class="col-6 small"><label class="small font-weight-bold text-dark mb-1">Company:</label> '.$respond->row(0)->company.'<br><label class="small font-weight-bold text-dark mb-1">Branch:</label> '.$respond->row(0)->branch.'</div>
        </div>
        <hr class="border-dark"> <table class="table table-striped table-bordered table-sm"> <thead> <tr> <th>Material Info</th> <th>Unit Price</th> <th class="text-center">Qty</th><th class="text-center">Uom</th> <th class="text-center">Discount</th> <th class="text-right">Total</th> </tr> </thead> <tbody>';
		foreach($responddetail->result() as $roworderinfo) {
					$total=number_format(($roworderinfo->qty*$roworderinfo->unitprice), 2);

					if($roworderinfo->tbl_material_group_idtbl_material_group==3) {
						$html .= '<tr>
						<td>' . $roworderinfo->materialname . '/ ' . $roworderinfo->materialinfocode . '</td>
						<td>' . (!empty($roworderinfo->packetprice) 
							? number_format($roworderinfo->packetprice, 2, '.', ',') 
							: number_format($roworderinfo->unitprice, 2, '.', ',')) . '</td>
						<td class="text-center">' . $roworderinfo->qty . '</td>
						<td class="text-center">' . $roworderinfo->measure_type . '</td>
						<td class="text-center">' . $roworderinfo->unit_discount . '</td>
						<td class="text-right">' . number_format($roworderinfo->total, 2, '.', ',') . '</td>
					</tr>';					

					}

					else if($roworderinfo->tbl_material_group_idtbl_material_group==4) {
						$html.='<tr>
					<td>'.$roworderinfo->machine.'/ '.$roworderinfo->machinecode.'</td><td>'.$roworderinfo->unitprice.'</td><td class="text-center">'.$roworderinfo->qty.'</td><td class="text-center">'.$roworderinfo->measure_type.'</td><td class="text-center">'.$roworderinfo->unit_discount.'</td><td class="text-right">'.$total.'</td></tr>';

			}
			else if($roworderinfo->tbl_material_group_idtbl_material_group==1) {
				$html.='<tr>
			<td>'.$roworderinfo->spare_part_name.'</td><td>'.$roworderinfo->unitprice.'</td><td class="text-center">'.$roworderinfo->qty.'</td><td class="text-center">'.$roworderinfo->measure_type.'</td><td class="text-center">'.$roworderinfo->unit_discount.'</td><td class="text-right">'.$total.'</td></tr>';

	}
		}



		$html .= '</tbody>
									</table>
								</div>
							</div>
							<!DOCTYPE html>
					<html lang="en">
					<head>
					<style>
						table {
							border-collapse: collapse;
						}
						td {
							padding: 5px;
						}
					</style>
					</head>
					<body>

					<table border="0" width="100%">
					
						<tbody>';
								$html .= '
							<tr>
								<td width="80%" style="text-align: right; font-weight: bold;">Discount</td>
								<td width="20%" style="text-align: right; font-weight: bold;">Rs. ' . number_format(($respond->row(0)->discount), 2) . '</td>
							</tr>
							<tr>
								<td width="80%" style="text-align: right; font-weight: bold;">Sub Total</td>
								<td width="20%" style="text-align: right; font-weight: bold;">Rs. ' . number_format(($respond->row(0)->subtotal), 2) . '</td>
							</tr>
							<tr>
								<td width="80%" style="text-align: right; font-weight: bold;">Vat(%)</td>
								<td width="20%" style="text-align: right; font-weight: bold;">' . $respond->row(0)->vat . '%</td>

							</tr>
							<tr>
								<td width="80%" style="text-align: right; font-weight: bold;"><strong><span style="color: black; font-size: 18px;">Final Price</span></strong></td>
								<td width="20%" style="text-align: right; font-weight: bold;"><span style="color: black; font-size: 18px;">Rs. ' . number_format(($respond->row(0)->total), 2) . '</span></td>
							</tr>

						</tbody>
					</table>

					</body>
					</html>';


				$this->db->select('tbl_company.company AS companyname,tbl_company.address1 As companyaddress,tbl_company.mobile AS companymobile,
					tbl_company.phone companyphone,tbl_company.email AS companyemail,
					tbl_company_branch.branch AS branchname');
				$this->db->from('tbl_print_grn');
				$this->db->join('tbl_company', 'tbl_company.idtbl_company = tbl_print_grn.tbl_company_idtbl_company', 'left');
				$this->db->join('tbl_company_branch', 'tbl_company_branch.idtbl_company_branch = tbl_print_grn.tbl_company_branch_idtbl_company_branch', 'left');
				$this->db->where('tbl_print_grn.idtbl_print_grn', $recordID);
				$companydetails = $this->db->get();

				$obj=new stdClass();
				$obj->companyname=$companydetails->row(0)->companyname;
				$obj->companyaddress=$companydetails->row(0)->companyaddress;
				$obj->companymobile=$companydetails->row(0)->companymobile;
				$obj->companyphone=$companydetails->row(0)->companyphone;
				$obj->companyemail=$companydetails->row(0)->companyemail;
				$obj->branchname=$companydetails->row(0)->branchname;
		
		$response = [
            'html' => $html,
            'details' => $obj
        ];
		$this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function Goodreceivestatus($x, $y, $z) {
		$this->db->trans_begin();

		$userID=$_SESSION['userid'];
		$recordID=$x;
		$type=$y;
		$porderid=$z;
		$updatedatetime=date('Y-m-d H:i:s');

		$approveID=$this->input->post('approveID');

		if($type==3) {
			$data=array('status'=> '3',
				'updateuser'=> $userID,
				'updatedatetime'=> $updatedatetime);

			$this->db->where('idtbl_print_grn', $recordID);
			$this->db->update('tbl_print_grn', $data);

			$current_qty=0;
			$this->db->select('qty');
			$this->db->from('tbl_print_grndetail');
			$this->db->where('tbl_print_grn_idtbl_print_grn', $recordID);
			$query1 = $this->db->get();

			if ($query1->num_rows() > 0) {
				$row = $query1->row();
				$current_qty = $row->qty;
			} 
			
			$this->db->select(' actual_qty');
			$this->db->from('tbl_print_porder_detail');
			$this->db->where('tbl_print_porder_idtbl_print_porder', $porderid);
			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				$row = $query->row();
				$oldactual_qty = $row->actual_qty;
			} 
	
			$new_actual_qty = $oldactual_qty - $current_qty;

				$dataqty = array(
					'actual_qty' => $new_actual_qty,
					'updatedatetime' => $updatedatetime
				);
			
				$this->db->where('tbl_print_porder_idtbl_print_porder', $porderid);
				$this->db->update('tbl_print_porder_detail', $dataqty);
			

			$this->db->trans_complete();


			if ($this->db->trans_status()===TRUE) {
				$this->db->trans_commit();

				$actionObj=new stdClass();
				$actionObj->icon='fas fa-trash-alt';
				$actionObj->title='';
				$actionObj->message='Record Reject Successfully';
				$actionObj->url='';
				$actionObj->target='_blank';
				$actionObj->type='danger';

				$actionJSON=json_encode($actionObj);

				$this->session->set_flashdata('msg', $actionJSON);
				redirect('Goodreceive');
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

				$this->session->set_flashdata('msg', $actionJSON);
				redirect('Goodreceive');
			}
		}
	}

	public function Approvestatus() {
		$this->db->trans_begin();
		$userID = $_SESSION['userid'];
		$updatedatetime = date('Y-m-d H:i:s');
		$approveID = $this->input->post('grnid');
		$confirmnot = $this->input->post('confirmnot');

		$data = array(
			'approvestatus' => $confirmnot,
			'updateuser' => $userID,
			'updatedatetime' => $updatedatetime
		);
		$this->db->where('idtbl_print_grn', $approveID);
		$this->db->update('tbl_print_grn', $data);

		$this->db->select('tbl_print_porder_idtbl_print_porder');
		$this->db->where('idtbl_print_grn', $approveID);
		$grn = $this->db->get('tbl_print_grn')->row();
		$porderID = $grn->tbl_print_porder_idtbl_print_porder;

		if ($confirmnot == 1) {
			$this->db->select('qty, pieces, tbl_print_material_info_idtbl_print_material_info, tbl_machine_id, tbl_sparepart_id');
			$this->db->from('tbl_print_grndetail');
			$this->db->where('tbl_print_grn_idtbl_print_grn', $approveID);
			$grnDetails = $this->db->get();

			foreach ($grnDetails->result() as $detail) {
				$qtyToAdd = ($detail->pieces != 0) ? $detail->pieces : $detail->qty;

				$this->db->where('tbl_print_porder_idtbl_print_porder', $porderID);

				if (!empty($detail->tbl_print_material_info_idtbl_print_material_info)) {
					$this->db->where('tbl_material_id', $detail->tbl_print_material_info_idtbl_print_material_info);
				} elseif (!empty($detail->tbl_machine_id)) {
					$this->db->where('tbl_machine_id', $detail->tbl_machine_id);
				} elseif (!empty($detail->tbl_sparepart_id)) {
					$this->db->where('tbl_sparepart_id', $detail->tbl_sparepart_id);
				}

				$query = $this->db->get('tbl_print_porder_detail');
				if ($query->num_rows() > 0) {
					$row = $query->row();
					$currentQty = $row->actual_qty;
					$newQty = $currentQty + $qtyToAdd;

					$this->db->where('idtbl_print_porder_detail', $row->idtbl_print_porder_detail);
					$this->db->update('tbl_print_porder_detail', ['actual_qty' => $newQty]);
				}
			}

			$this->db->select('SUM(qty) as total_qty, SUM(pieces) as total_pieces,  SUM(actual_qty) as total_actual_qty');
			$this->db->where('tbl_print_porder_idtbl_print_porder', $porderID);
			$qty_check = $this->db->get('tbl_print_porder_detail')->row();

			if ($qty_check->total_pieces > 0) {
				$issueqty = $qty_check->total_pieces;
			} else {
				$issueqty = $qty_check->total_qty;
			}

			if ($qty_check->total_actual_qty >= $issueqty) {
				$dataporder = array(
					'grnconfirm' => '1', 
					'updateuser' => $userID,
					'updatedatetime' => $updatedatetime
				);
				$this->db->where('idtbl_print_porder', $porderID);
				$this->db->update('tbl_print_porder', $dataporder);
			}

			$this->db->select('tbl_print_grn.batchno, tbl_print_grn.tbl_company_idtbl_company, tbl_print_grn.tbl_company_branch_idtbl_company_branch, tbl_print_grn.grntype, tbl_print_grn.tbl_location_idtbl_location, tbl_print_grn.tbl_supplier_idtbl_supplier, tbl_print_grn.grndate, tbl_print_grndetail.qty, tbl_print_grndetail.pieces, tbl_print_grndetail.total, tbl_print_grndetail.tbl_measurements_idtbl_mesurements, tbl_print_grndetail.unitprice, tbl_print_grndetail.tbl_print_material_info_idtbl_print_material_info, tbl_print_grndetail.tbl_machine_id, tbl_print_grndetail.tbl_sparepart_id, tbl_print_grn.tbl_print_porder_idtbl_print_porder');
			$this->db->from('tbl_print_grn');
			$this->db->join('tbl_print_grndetail', 'tbl_print_grn.idtbl_print_grn = tbl_print_grndetail.tbl_print_grn_idtbl_print_grn', 'left');
			$this->db->where('tbl_print_grn.status', 1);
			$this->db->where('tbl_print_grn.idtbl_print_grn', $approveID);
			$respond = $this->db->get();

			if ($respond->num_rows() > 0) {
				foreach ($respond->result() as $row) {
					$batchno = $row->batchno;
					$location = $row->tbl_location_idtbl_location;
					$supplier = $row->tbl_supplier_idtbl_supplier;
					$grndate = $row->grndate;
					$qty = $row->qty;
					$pieces = $row->pieces;
					$measure_type = $row->tbl_measurements_idtbl_mesurements;
					$unitprice = $row->unitprice;
					$total = $row->total;
					$materialID = $row->tbl_print_material_info_idtbl_print_material_info;
					$orderType = $row->grntype;
					$machineID = $row->tbl_machine_id;
					$sparepartID = $row->tbl_sparepart_id;
					$companyid = $row->tbl_company_idtbl_company;
					$branchid = $row->tbl_company_branch_idtbl_company_branch;

					$finalQty = ($pieces != 0) ? $pieces : $qty;

					$stockData = array(
						'batchno' => $batchno,
						'location' => $location,
						'grndate' => $grndate,
						'supplier_id' => $supplier,
						'qty' => $finalQty,
						'measure_type_id' => $measure_type,
						'unitprice' => $unitprice,
						'total' => $total,
						'status' => '1',
						'insertdatetime' => $updatedatetime,
						'tbl_user_idtbl_user' => $userID,
						'tbl_company_idtbl_company' => $companyid,
						'tbl_company_branch_idtbl_company_branch' => $branchid
					);

					if ($orderType == 3) {
						$stockData['tbl_print_material_info_idtbl_print_material_info'] = $materialID;
					} elseif ($orderType == 4) {
						$stockData['tbl_machine_id'] = $machineID;
					} elseif ($orderType == 1) {
						$stockData['tbl_sparepart_id'] = $sparepartID;
					}

					$this->db->insert('tbl_print_stock', $stockData);
				}
			}
		}

		$this->db->trans_complete();

		if ($this->db->trans_status() === TRUE) {
			$this->db->trans_commit();

			$actionObj = new stdClass();
			$actionObj->icon = 'fas fa-check';
			$actionObj->title = '';

			if ($confirmnot == 1) {
				$actionObj->message = 'Record Approved Successfully';

				if (isset($qty_check)) {
					$is_fully_received = ($qty_check->total_actual_qty >= $issueqty);
					if (!$is_fully_received) {
						$unit = ($qty_check->total_pieces > 0) ? 'pieces' : 'quantity';
						$actionObj->message .= " (GRN not fully confirmed - $unit not met)";
					}
				}
			} else {
				$actionObj->message = 'Record Rejected Successfully';
			}

			$actionObj->url = '';
			$actionObj->target = '_blank';
			$actionObj->type = 'success';

			$response = [
				'status' => 1,
				'action' => json_encode($actionObj)
			];
			
			if ($confirmnot == 1 && isset($qty_check)) {
				$is_fully_received = ($qty_check->total_actual_qty >= $issueqty);
				$response['grnconfirmed'] = $is_fully_received ? 1 : 0;
			}

			echo json_encode($response);
		} else {
			$this->db->trans_rollback();
			echo json_encode([
				'status' => 0,
				'message' => 'Transaction failed. Please try again.'
			]);
		}
	}


	public function Goodreceiverejectstatus() {
		$this->db->trans_begin();

		$userID=$_SESSION['userid'];
		$recordID=$this->input->post('rejectbtn');
		$updatedatetime=date('Y-m-d H:i:s');

			$data=array(
				'approvestatus'=> '2',
				'updateuser'=> $userID,
				'updatedatetime'=> $updatedatetime);

			$this->db->where('idtbl_print_grn', $recordID);
			$this->db->update('tbl_print_grn', $data);


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

	public function Getsupplier() {
		$recordID = $this->input->post('recordID');

		$this->db->select('tbl_supplier.idtbl_supplier, tbl_supplier.suppliername');
		$this->db->from('tbl_print_porder');
		$this->db->join('tbl_supplier', 'tbl_supplier.idtbl_supplier = tbl_print_porder.tbl_supplier_idtbl_supplier');
		$this->db->where('tbl_print_porder.status', 1);
		$this->db->where('tbl_print_porder.idtbl_print_porder', $recordID);
	
		$response = $this->db->get();
	
		if ($response->num_rows() > 0) {
			$supplier = $response->row();
			
			echo json_encode([
				'id' => $supplier->idtbl_supplier,
				'name' => $supplier->suppliername
			]);
		} else {
			echo json_encode([]);
		}
	}

	public function Getsupplieraccoporder() {
		$recordID = $this->input->post('recordID');
	
		$this->db->select('tbl_supplier_idtbl_supplier');
		$this->db->from('tbl_print_porder');
		$this->db->where('status', 1);
		$this->db->where('idtbl_print_porder', $recordID);
	
		$response = $this->db->get();
	
		if ($response->num_rows() > 0) {
			echo $response->row(0)->tbl_supplier_idtbl_supplier;
		} else {
			echo '';
		}
	}
	

	public function Getcompanyaccoporder() {
		$recordID=$this->input->post('recordID');

		$this->db->select('`tbl_company_idtbl_company`');
		$this->db->from('tbl_print_porder');
		$this->db->where('status', 1);
		$this->db->where('idtbl_print_porder', $recordID);

		$respond=$this->db->get();

		echo $respond->row(0)->tbl_company_idtbl_company;
	}
	public function Getbranchaccoporder() {
		$recordID=$this->input->post('recordID');

		$this->db->select('`tbl_company_branch_idtbl_company_branch`');
		$this->db->from('tbl_print_porder');
		$this->db->where('status', 1);
		$this->db->where('idtbl_print_porder', $recordID);

		$respond=$this->db->get();

		echo $respond->row(0)->tbl_company_branch_idtbl_company_branch;
	}

	 public function Getporderaccsupllier() {
            $recordID = $this->input->post('recordID');
			$branchID = $this->input->post('branchID');
            $companyID = $this->input->post('companyID');
        
            $this->db->select('*');
            $this->db->from('tbl_print_porder');
            $this->db->where('status', 1);
			$this->db->where('confirmstatus', 1);
			$this->db->where('grnconfirm', 0);
			$this->db->where('tbl_company_idtbl_company', $companyID);
            $this->db->where('tbl_company_branch_idtbl_company_branch', $branchID);
            $this->db->where('tbl_supplier_idtbl_supplier', $recordID);
			$this->db->where_in('tbl_material_group_idtbl_material_group', array(1, 3, 4));
        
            $respond = $this->db->get();
        
            if ($respond->num_rows() > 0) {
                echo json_encode($respond->result());
            }
        }
        

	public function Getproductaccoporder() {
		$recordID=$this->input->post('recordID');

		$sql="SELECT `tbl_print_material_info`.`idtbl_print_material_info`, `tbl_print_material_info`.`materialinfocode`, `tbl_print_material_info`.`materialname` FROM `tbl_print_porder_detail` LEFT JOIN `tbl_print_material_info` ON `tbl_print_material_info`.`idtbl_print_material_info`=`tbl_print_porder_detail`.`tbl_material_id` WHERE `tbl_print_material_info`.`status`=? AND `tbl_print_porder_detail`.`tbl_print_porder_idtbl_print_porder`=?";
		$respond=$this->db->query($sql, array(1, $recordID));

		echo json_encode($respond->result());
	}

	public function Getproductforsparepart() {
		$recordID=$this->input->post('recordID');

		$sql="SELECT `tbl_spareparts`.`idtbl_spareparts`, `tbl_spareparts`.`spare_part_name` FROM `tbl_print_porder_detail` LEFT JOIN `tbl_spareparts` ON `tbl_spareparts`.`idtbl_spareparts` = `tbl_print_porder_detail`.`tbl_sparepart_id` WHERE `tbl_spareparts`.`status` = ? AND `tbl_print_porder_detail`.`tbl_print_porder_idtbl_print_porder` = ?";
		$respond=$this->db->query($sql, array(1, $recordID));

		echo json_encode($respond->result());
	}

	public function Getproductformachine() {
		$recordID=$this->input->post('recordID');

		$sql="SELECT `tbl_machine`.`idtbl_machine`, `tbl_machine`.`machine` FROM `tbl_print_porder_detail` LEFT JOIN `tbl_machine` ON `tbl_machine`.`idtbl_machine` = `tbl_print_porder_detail`.`tbl_machine_id` WHERE `tbl_machine`.`status` = ? AND `tbl_print_porder_detail`.`tbl_print_porder_idtbl_print_porder` = ?";
		$respond=$this->db->query($sql, array(1, $recordID));

		echo json_encode($respond->result());
	}

	public function Getproductinfoaccoproduct() {
		$recordID = $this->input->post('recordID');
		$grn_id = $this->input->post('grn_id');

		$this->db->select('qty, unitprice, pieces, comment, tbl_measurements_idtbl_measurements, idtbl_print_porder_detail, actual_qty');
		$this->db->from('tbl_print_porder_detail');
		$this->db->where('status', 1);
		$this->db->where('tbl_print_porder_idtbl_print_porder', $grn_id);
		$this->db->where('tbl_material_id', $recordID);
		$respond = $this->db->get();

		if($respond->num_rows() > 0) {
			$row = $respond->row(0);
			$mainUom = $row->tbl_measurements_idtbl_measurements;

			$this->db->select('qty as conversion_rate');
			$this->db->from('tbl_uom_conversions');
			$this->db->where('main_uom', $mainUom);
			$this->db->where('status', 1);
			$conversionQuery = $this->db->get();
			
			$conversionRate = 1; 
			if($conversionQuery->num_rows() > 0) {
				$conversionRate = $conversionQuery->row()->conversion_rate;
			}

			$obj = new stdClass();
			$obj->qty = $row->qty;
			$obj->pieces = $row->pieces;
			$obj->actual_qty = $row->actual_qty;
			$obj->uom = $mainUom;
			$obj->unitprice = $row->unitprice;
			$obj->comment = $row->comment;
			$obj->detailsid = $row->idtbl_print_porder_detail;
			$obj->conversion_rate = $conversionRate;
		}
		else {
			$obj = new stdClass();
			$obj->qty = 0;
			$obj->pieces = 0;
			$obj->actual_qty = 0;
			$obj->uom = '';
			$obj->unitprice = 0;
			$obj->comment = '';
			$obj->detailsid = 0;
			$obj->conversion_rate = 1;
		}

		echo json_encode($obj);
	}

	public function Getproductinfoamachine() {
		$recordID=$this->input->post('recordID');
		$porderid=$this->input->post('grn_id');

		$this->db->select('`qty`, `unitprice`, `comment` ,`tbl_measurements_idtbl_measurements`,`idtbl_print_porder_detail`,`actual_qty`');
		$this->db->from('tbl_print_porder_detail');
		$this->db->where('status', 1);
		$this->db->where('tbl_machine_id', $recordID);
		$this->db->where('tbl_print_porder_idtbl_print_porder', $porderid);

		$respond=$this->db->get();

		if($respond->num_rows()>0) {
			$obj=new stdClass();
			$obj->qty=$respond->row(0)->qty;
			$obj->actual_qty=$respond->row(0)->actual_qty;
			$obj->unitprice=$respond->row(0)->unitprice;
			$obj->uom=$respond->row(0)->tbl_measurements_idtbl_measurements;
			$obj->comment=$respond->row(0)->comment;
			$obj->detailsid=$respond->row(0)->idtbl_print_porder_detail;
		}

		else {
			$obj=new stdClass();
			$obj->qty=0;
			$obj->unitprice=0;
			$obj->comment='';
			$obj->uom='';
		}

		echo json_encode($obj);
	}

	public function Getproductinfosparepart() {
		$recordID=$this->input->post('recordID');
		$porderid=$this->input->post('grn_id');

		$this->db->select('`qty`, `unitprice`, `comment` ,`tbl_measurements_idtbl_measurements`,`idtbl_print_porder_detail`,`actual_qty`');
		$this->db->from('tbl_print_porder_detail');
		$this->db->where('status', 1);
		$this->db->where('tbl_sparepart_id', $recordID);
		$this->db->where('tbl_print_porder_idtbl_print_porder', $porderid);

		$respond=$this->db->get();

		if($respond->num_rows()>0) {
			$obj=new stdClass();
			$obj->qty=$respond->row(0)->qty;
			$obj->actual_qty=$respond->row(0)->actual_qty;
			$obj->unitprice=$respond->row(0)->unitprice;
			$obj->uom=$respond->row(0)->tbl_measurements_idtbl_measurements;
			$obj->comment=$respond->row(0)->comment;
			$obj->detailsid=$respond->row(0)->idtbl_print_porder_detail;
		}

		else {
			$obj=new stdClass();
			$obj->qty=0;
			$obj->unitprice=0;
			$obj->comment='';
			$obj->uom='';
		}

		echo json_encode($obj);
	}

	public function Getbatchnoaccosupplier() {
		$recordID=$this->input->post('recordID');

		if( !empty($recordID)) {
			$this->db->select('tbl_supplier.`idtbl_supplier`, tbl_material_category.categorycode');
			$this->db->from('tbl_supplier');
			$this->db->join('tbl_supplier_has_tbl_material_category', 'tbl_supplier_has_tbl_material_category.tbl_supplier_idtbl_supplier = tbl_supplier.idtbl_supplier', 'left');
			$this->db->join('tbl_material_category', 'tbl_material_category.idtbl_material_category = tbl_supplier_has_tbl_material_category.tbl_material_category_idtbl_material_category', 'left');
			$this->db->where('tbl_supplier.idtbl_supplier', $recordID);
			$this->db->where('tbl_supplier.status', 1);

			$responddetail=$this->db->get();

			$materialcode=$responddetail->row(0)->categorycode;
			$supplierid=$responddetail->row(0)->idtbl_supplier;

			$sql="SELECT COUNT(*) AS `count` FROM `tbl_print_grn`";
			$respond=$this->db->query($sql);

			if($respond->row(0)->count==0) {
				$batchno=date('dmY').'001';
			}

			else {
				$count='000'.($respond->row(0)->count+1);
				$count=substr($count, -3);
				$batchno=date('dmY').$count;
			}

			echo $supplierid.$materialcode.$batchno;
		}

		else {
			echo '';
		}
	}


	public function Getordertype() {
		$this->db->select('`idtbl_material_group`, `group`');
		$this->db->from('tbl_material_group');
		$this->db->where('status', 1);
		$this->db->where_in('idtbl_material_group', array(1, 3, 4));

		return $respond=$this->db->get();
	}

	public function Getpordertpeaccoporder() {
		$recordID=$this->input->post('recordID');

		$this->db->select('`tbl_material_group_idtbl_material_group`');
		$this->db->from('tbl_print_porder');
		$this->db->where('status', 1);
		$this->db->where('idtbl_print_porder', $recordID);

		$respond=$this->db->get();

		echo $respond->row(0)->tbl_material_group_idtbl_material_group;
	}

	public function Getvatpresentage() {
		$recordCurrentDate=$this->input->post('currentDate');
		$currentDate = date('Y-m-d');

		$useDate='';

		if($recordCurrentDate==$currentDate){
			$useDate=$currentDate;
		}else{
			$useDate=$recordCurrentDate;
		}

		$this->db->select('*');
		$this->db->from('tbl_tax_control');
		$this->db->where('status', 1);
		$this->db->where("DATE(effective_from) <=", $useDate);
		$this->db->where("(DATE(effective_to) >= '$useDate' OR effective_to IS NULL)");

		$respond = $this->db->get();
		$taxPercentage='';

		if ($respond->num_rows() > 0) {
			$taxPercentage = $respond->row()->percentage;

			if ($taxPercentage !== null && $taxPercentage !== 0) {
				echo $taxPercentage;
			} else {
				echo $taxPercentage=0;
			}
		} else {
			echo $taxPercentage=0;
		}



	}

	public function Goodreceivecheckstatus() {
		$this->db->trans_begin();

        $recordID=$this->input->post('requestid');
		$confirmnot=$this->input->post('confirmnot');
		$userID=$_SESSION['userid'];
		$updatedatetime=date('Y-m-d H:i:s');

			$data=array(
				'check_by'=> $userID);

			$this->db->where('idtbl_print_grn', $recordID);
			$this->db->update('tbl_print_grn', $data);


			$this->db->trans_complete();

			if ($this->db->trans_status()===TRUE) {
				$this->db->trans_commit();

				$actionObj=new stdClass();
				$actionObj->icon='fas fa-check';
				$actionObj->title='';
				if($confirmnot==1){$actionObj->message='Record Checked Successfully';}
				else{$actionObj->message='Record Rejected Successfully';}
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