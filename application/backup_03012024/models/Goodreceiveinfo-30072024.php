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

	public function Getsupplier() {
		$this->db->select('`idtbl_supplier`, `name`');
		$this->db->from('tbl_supplier');
		$this->db->where('status', 1);

		return $respond=$this->db->get();
	}

	public function Getporder() {
		$this->db->select('`idtbl_print_porder`');
		$this->db->from('tbl_print_porder');
		$this->db->where('status', 1);
		$this->db->where('confirmstatus', 1);
		$this->db->where('grnconfirm', 0);
		$this->db->where_in('tbl_order_type_idtbl_order_type', array(1, 3, 4));


		return $respond=$this->db->get();
	}

	public function Getproductaccosupplier() {
		$recordID=$this->input->post('recordID');

		$sql="SELECT `tbl_print_material_info`.`idtbl_print_material_info`, `tbl_print_material_info`.`materialinfocode`, `tbl_material_code`.`materialname` FROM `tbl_print_material_info` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_print_material_info`.`tbl_material_code_idtbl_material_code` WHERE `tbl_print_material_info`.`status`=? AND `tbl_print_material_info`.`tbl_material_category_idtbl_material_category` IN (SELECT `tbl_material_category_idtbl_material_category` FROM `tbl_supplier_has_tbl_material_category` WHERE `tbl_supplier_idtbl_supplier`=?)";
		$respond=$this->db->query($sql, array(1, $recordID));

		echo json_encode($respond->result());
	}

	// public function Getproductformachine(){
	//     $recordID=$this->input->post('recordID');
	//     $sql="SELECT `idtbl_machine`, `machine` FROM `tbl_machine` ";
	//     $respond=$this->db->query($sql, array($recordID));

	//     echo json_encode($respond->result());
	// }

	public function Getgoodreceiveid() {
		$recordID=$this->input->post('recordID');

		$sql="SELECT `idtbl_print_grn` FROM `tbl_print_grn` WHERE `idtbl_print_grn`=? AND `status`=1";
		$respond=$this->db->query($sql, array($recordID));

		echo json_encode($respond->result());
	}

	public function Goodreceiveinsertupdate() {
		$this->db->trans_begin();

		$userID=$_SESSION['userid'];

		$tableData=$this->input->post('tableData');
		$grndate=$this->input->post('grndate');
		$total=$this->input->post('total');
		$remark=$this->input->post('remark');
		$supplier=$this->input->post('supplier');
		$location=$this->input->post('location');
		$company_id=$this->input->post('company_id');
		$branch_id=$this->input->post('branch_id');
		$porder=$this->input->post('porder');

		// if( !empty($this->input->post('porder'))) {
		// 	$porder=$this->input->post('porder');
		// 	$grntype=1;
		// }

		// else {
		// 	$porder=1;
		// 	$grntype=2;
		// }

		$batchno=$this->input->post('batchno');
		$invoice=$this->input->post('invoice');
		$discount=$this->input->post('discount');
		$grntype=$this->input->post('grntype');
		$vat_type=$this->input->post('vat_type');
		$subtotal=$this->input->post('subtotal');
		$vat=$this->input->post('vat');

		$updatedatetime=date('Y-m-d H:i:s');

		$data=array('batchno'=> $batchno,
			'grntype'=> $grntype,
			'grndate'=> $grndate,
			'total'=> $total,
			'invoicenum'=> $invoice,
			'discount'=> $discount,
			'approvestatus'=> '0',
			'subtotal'=> $subtotal, 
			'vat'=> $vat, 
			'vat_type'=> $vat_type, 
			'company_id'=> $company_id, 
			'company_branch_id'=> $branch_id, 
			'status'=> '1',
			'insertdatetime'=> $updatedatetime,
			'tbl_user_idtbl_user'=> $userID,
			'tbl_supplier_idtbl_supplier'=> $supplier,
			'tbl_location_idtbl_location'=> $location,
			'tbl_print_porder_idtbl_print_porder'=> $porder,
			'tbl_order_type_idtbl_order_type'=> $grntype);

		$this->db->insert('tbl_print_grn', $data);

		$grnID=$this->db->insert_id();

		if($grntype==3) {
			foreach($tableData as $rowtabledata) {
				$materialname=$rowtabledata['col_1'];
				$comment=$rowtabledata['col_2'];
				// $mfdate=$rowtabledata['col_3'];
				// $expdate=$rowtabledata['col_4'];
				$materialID=$rowtabledata['col_3'];
				$unit=$rowtabledata['col_4'];
				$qty=$rowtabledata['col_5'];
				$uom=$rowtabledata['col_6'];
				$unit_discount=$rowtabledata['col_7'];
				$uomID=$rowtabledata['col_8'];
				$nettotal=$rowtabledata['col_9'];

				$dataone=array('date'=> $grndate,
					'qty'=> $qty,
					'unitprice'=> $unit,
					'costunitprice'=> $unit,
					'total'=> $nettotal,
					'comment'=> $comment,
					'measure_type_id'=> $uomID,
					'unit_discount'=> $unit_discount,
					'expdate'=> '',
					'quater'=> '',
					'status'=> '1',
					'insertdatetime'=> $updatedatetime,
					'tbl_print_grn_idtbl_print_grn'=> $grnID,
					'tbl_print_material_info_idtbl_print_material_info'=> $materialID);

				$this->db->insert('tbl_print_grndetail', $dataone);
			}
		}

		else if($grntype==4) {
			foreach($tableData as $rowtabledata) {
				$materialname=$rowtabledata['col_1'];
				$comment=$rowtabledata['col_2'];
				// $mfdate=$rowtabledata['col_3'];
				// $expdate=$rowtabledata['col_4'];
				// $quater=$rowtabledata['col_5'];
				$materialID=$rowtabledata['col_3'];
				$unit=$rowtabledata['col_4'];
				$qty=$rowtabledata['col_5'];
				$uom=$rowtabledata['col_6'];
				$uomID=$rowtabledata['col_7'];
				$nettotal=$rowtabledata['col_8'];

				$dataone=array('date'=> $grndate,
					'qty'=> $qty,
					'unitprice'=> $unit,
					'costunitprice'=> $unit,
					'total'=> $nettotal,
					'comment'=> $comment,
					'measure_type_id'=> $uomID,
					'mfdate'=> '',
					'expdate'=> '',
					'quater'=> '',
					'status'=> '1',
					'insertdatetime'=> $updatedatetime,
					'tbl_print_grn_idtbl_print_grn'=> $grnID,
					'tbl_machine_id'=> $materialID);

				$this->db->insert('tbl_print_grndetail', $dataone);
			}
		}

		else if($grntype==1) {
			foreach($tableData as $rowtabledata) {
				$materialname=$rowtabledata['col_1'];
				$comment=$rowtabledata['col_2'];
				// $mfdate=$rowtabledata['col_3'];
				// $expdate=$rowtabledata['col_4'];
				// $quater=$rowtabledata['col_5'];
				$materialID=$rowtabledata['col_3'];
				$unit=$rowtabledata['col_4'];
				$qty=$rowtabledata['col_5'];
				$uom=$rowtabledata['col_6'];
				$uomID=$rowtabledata['col_7'];
				$nettotal=$rowtabledata['col_8'];

				$dataone=array('date'=> $grndate,
					'qty'=> $qty,
					'unitprice'=> $unit,
					'costunitprice'=> $unit,
					'total'=> $nettotal,
					'comment'=> $comment,
					'measure_type_id'=> $uomID,
					'mfdate'=> '',
					'expdate'=> '',
					'quater'=> '',
					'status'=> '1',
					'insertdatetime'=> $updatedatetime,
					'tbl_print_grn_idtbl_print_grn'=> $grnID,
					'tbl_sparepart_id'=> $materialID);

				$this->db->insert('tbl_print_grndetail', $dataone);
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

	public function Goodreceiveview() {
		$recordID=$this->input->post('recordID');

		$sql="SELECT `u`.*, `ua`.`name`, `ua`.`telephone_no`, `ua`.`address_line1`, `ub`.`location`, `ub`.`phone`, `ub`.`address`, `ub`.`phone2`, `ub`.`email` AS `locemail` FROM `tbl_print_grn` AS `u` LEFT JOIN `tbl_supplier` AS `ua` ON (`ua`.`idtbl_supplier` = `u`.`tbl_supplier_idtbl_supplier`) LEFT JOIN `tbl_location` AS `ub` ON (`ub`.`idtbl_location` = `u`.`tbl_location_idtbl_location`) WHERE `u`.`status`=? AND `u`.`idtbl_print_grn`=?";
		$respond=$this->db->query($sql, array(1, $recordID));

		$this->db->select('tbl_print_grndetail.*,tbl_print_grn.tbl_order_type_idtbl_order_type, tbl_print_material_info.materialinfocode, tbl_print_material_info.materialname,tbl_machine.machine,tbl_machine.machinecode,tbl_spareparts.spare_part_name,tbl_measurements.measure_type');
		$this->db->from('tbl_print_grndetail');
		$this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_print_grndetail.tbl_print_material_info_idtbl_print_material_info', 'left');
		$this->db->join('tbl_print_grn', 'tbl_print_grn.idtbl_print_grn = tbl_print_grndetail.tbl_print_grn_idtbl_print_grn', 'left');
		$this->db->join('tbl_machine', 'tbl_machine.idtbl_machine = tbl_print_grndetail.tbl_machine_id', 'left');
		$this->db->join('tbl_spareparts', 'tbl_spareparts.idtbl_spareparts = tbl_print_grndetail.tbl_sparepart_id', 'left');//for sparepart get
		$this->db->join('tbl_measurements', 'tbl_measurements.idtbl_mesurements = tbl_print_grndetail.measure_type_id', 'left');
		$this->db->where('tbl_print_grndetail.tbl_print_grn_idtbl_print_grn', $recordID);
		$this->db->where('tbl_print_grndetail.status', 1);

		$responddetail=$this->db->get();
		// print_r($this->db->last_query());

		$html='';

		$html.='
		<div class="row"><div class="col-12 text-right font-family: cursive;font-size:15px; font-weight: bold;">'.$respond->row(0)->name.'</div><div class="col-12"><hr><h6>Invoice No: '.$respond->row(0)->invoicenum.'</h6> <h6>Dispatch No:</h6> <h6>Batch No: '.$respond->row(0)->batchno.'</h6> </div> </div> <div class="row"> <div class="col-12"> <hr> <table class="table table-striped table-bordered table-sm"> <thead> <tr> <th>Material Info</th> <th>Unit Price</th> <th class="text-center">Qty</th><th class="text-center">Uom</th> <th class="text-center">Discount</th> <th class="text-right">Total</th> </tr> </thead> <tbody>';
		foreach($responddetail->result() as $roworderinfo) {
					$total=number_format(($roworderinfo->qty*$roworderinfo->unitprice), 2);

					if($roworderinfo->tbl_order_type_idtbl_order_type==3) {
						$html.='<tr>
					<td>'.$roworderinfo->materialname.'/ '.$roworderinfo->materialinfocode.'</td><td>'.$roworderinfo->unitprice.'</td><td class="text-center">'.$roworderinfo->qty.'</td><td class="text-center">'.$roworderinfo->measure_type.'</td><td class="text-center">'.$roworderinfo->unit_discount.'</td><td class="text-right">'.$total.'</td></tr>';

					}

					else if($roworderinfo->tbl_order_type_idtbl_order_type==4) {
						$html.='<tr>
					<td>'.$roworderinfo->machine.'/ '.$roworderinfo->machinecode.'</td><td>'.$roworderinfo->unitprice.'</td><td class="text-center">'.$roworderinfo->qty.'</td><td class="text-center">'.$roworderinfo->measure_type.'</td><td class="text-center">'.$roworderinfo->unit_discount.'</td><td class="text-right">'.$total.'</td></tr>';

			}
			else if($roworderinfo->tbl_order_type_idtbl_order_type==1) {
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
				$this->db->join('tbl_company', 'tbl_company.idtbl_company = tbl_print_grn.company_id', 'left');
				$this->db->join('tbl_company_branch', 'tbl_company_branch.idtbl_company_branch = tbl_print_grn.company_branch_id', 'left');
				$this->db->where('tbl_print_grn.idtbl_print_grn', $recordID);
				$companydetails = $this->db->get();

				$obj=new stdClass();
				$obj->companyname=$companydetails->row(0)->companyname;
				$obj->companyaddress=$companydetails->row(0)->companyaddress;
				$obj->companymobile=$companydetails->row(0)->companymobile;
				$obj->companyphone=$companydetails->row(0)->companyphone;
				$obj->companyemail=$companydetails->row(0)->companyemail;
				$obj->branchname=$companydetails->row(0)->branchname;
		// $html .= '</tbody></table></div></div><div class="row mt-3" style="margin-bottom: -15px;""><div class="col-12 text-right"><h6 class="font-weight-normal"><strong style="background-color: yellow;">Discount</strong> &nbsp; &nbsp;<b>Rs. ' . number_format(($respond->row(0)->discount), 2) . '</b></h6></div></div>';
		// $html .= '</tbody></table></div></div><div class="row mt-3" style="margin-bottom: -15px;"><div class="col-12 text-right"><h6 class="font-weight-normal"><strong style="background-color: yellow;">Sub Total </strong> &nbsp; &nbsp;<b>Rs. ' . number_format(($respond->row(0)->subtotal), 2) . '</b></h6></div></div>';
		// // $html .= '</tbody></table></div></div><div class="row mt-3" style="margin-bottom: -15px;"><div class="col-12 text-right"><h5 class="font-weight-normal"><strong style="background-color: yellow;">Vat Total</strong> &nbsp; &nbsp;<b>Rs. ' . number_format(($respond->row(0)->vattotamount), 2) . '</b></h5></div></div>';
		// $html.='</tbody></table></div></div><div class="row mt-3"><div class="col-12 text-right"><h3 class="font-weight-normal"><strong style="background-color: yellow;">Final Price</strong> &nbsp; &nbsp;<b>Rs. ' .number_format(($respond->row(0)->total), 2).'</b></h3></div></div>';
		
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

		if($type==1) {
			$data=array('approvestatus'=> '1',
				'updateuser'=> $userID,
				'updatedatetime'=> $updatedatetime);

			$this->db->where('idtbl_print_grn', $recordID);
			$this->db->update('tbl_print_grn', $data);
			////////////////////////////////////////////// Add Materials and Machine to stock Table //////////////////////////////////////////////////////////////////

			$this->db->select('tbl_print_grn.batchno,tbl_print_grn.grntype, tbl_print_grn.tbl_location_idtbl_location,tbl_print_grn.tbl_supplier_idtbl_supplier,tbl_print_grn.grndate,tbl_print_grndetail.qty,tbl_print_grndetail.total,tbl_print_grndetail.measure_type_id, tbl_print_grndetail.unitprice, tbl_print_grndetail.tbl_print_material_info_idtbl_print_material_info,tbl_print_grndetail.tbl_machine_id,tbl_print_grndetail.tbl_sparepart_id');
			$this->db->from('tbl_print_grn');
			$this->db->join('tbl_print_grndetail', 'tbl_print_grn.idtbl_print_grn = tbl_print_grndetail.tbl_print_grn_idtbl_print_grn', 'left');
			$this->db->where('tbl_print_grn.status', 1);
			$this->db->where('tbl_print_grn.idtbl_print_grn', $recordID);

			$respond=$this->db->get();

			if ($respond->num_rows() > 0) {
				foreach ($respond->result() as $row) {
					$batchno=$row->batchno;
					$location=$row->tbl_location_idtbl_location;
					$supplier=$row->tbl_supplier_idtbl_supplier;
					$grndate=$row->grndate;
					$qty=$row->qty;
					$measure_type=$row->measure_type_id;
					$unitprice=$row->unitprice;
					$total=$row->total;
					$materialID=$row->tbl_print_material_info_idtbl_print_material_info;
					$orderType=$row->grntype;
					$machineID=$row->tbl_machine_id;
					$sparepartID=$row->tbl_sparepart_id;

					if ($orderType==3) {
						$stockData=array('batchno'=> $batchno,
						    'location'=> $location,
							'grndate'=> $grndate,
							'supplier_id'=> $supplier,
							'qty'=> $qty,
							'measure_type_id'=> $measure_type,
							'unitprice'=> $unitprice,
							'total'=> $total,
							'status'=> '1',
							'insertdatetime'=> $updatedatetime,
							'tbl_user_idtbl_user'=> $userID,
							'tbl_print_material_info_idtbl_print_material_info'=> $materialID);
					}

					elseif ($orderType==4) {
						$stockData=array('batchno'=> $batchno,
						    'location'=> $location,
							'grndate'=> $grndate,
							'supplier_id'=> $supplier,
							'qty'=> $qty,
							'measure_type_id'=> $measure_type,
							'unitprice'=> $unitprice,
							'total'=> $total,
							'status'=> '1',
							'insertdatetime'=> $updatedatetime,
							'tbl_user_idtbl_user'=> $userID,
							'tbl_machine_id'=> $machineID);
					}

					elseif ($orderType==1) {
						$stockData=array('batchno'=> $batchno,
						    'location'=> $location,
							'grndate'=> $grndate,
							'supplier_id'=> $supplier,
							'qty'=> $qty,
							'measure_type_id'=> $measure_type,
							'unitprice'=> $unitprice,
							'total'=> $total,
							'status'=> '1',
							'insertdatetime'=> $updatedatetime,
							'tbl_user_idtbl_user'=> $userID,
							'tbl_sparepart_id'=> $sparepartID);
					}

					// Insert the data into the 'tbl_print_stock' table
					$this->db->insert('tbl_print_stock', $stockData);
				}
			}

			//////////////////////////////////////////////////////////// End of add Materials and Machine to stock Table ////////////////////////////////////////////////////////

			////////////////////////////////////////////// Add GRN Details for Chart of accounts tbl_expence_info //////////////////////////////////////////////////////////////////

			$this->db->select('tbl_print_grn.idtbl_print_grn,tbl_print_grn.grndate, tbl_print_grn.total,tbl_print_grn.tbl_supplier_idtbl_supplier');
			$this->db->from('tbl_print_grn');
			$this->db->where('tbl_print_grn.status', 1);
			$this->db->where('tbl_print_grn.idtbl_print_grn', $recordID);

			$respond=$this->db->get();

			if ($respond->num_rows() > 0) {
				foreach ($respond->result() as $row) {
					$grnid=$row->idtbl_print_grn;
					$totalamount=$row->total;
					$supplier=$row->tbl_supplier_idtbl_supplier;
					$grndate=$row->grndate;


				
						// $accountsData=array(
						// 	'grndate'=> $grndate,
						// 	'tbl_supplier_idtbl_supplier'=> $supplier,
						// 	'exptype'=> '1',
						// 	'grnno'=> $grnid,
						// 	'expcode'=> 'GRN',
						// 	'amount'=> $totalamount,
						// 	'status'=> '1',
						// 	'insertdatetime'=> $updatedatetime,
						// 	'tbl_user_idtbl_user'=> $userID);
					


							if ($orderType==3) {
								$accountsData=array(
									'grndate'=> $grndate,
									'tbl_supplier_idtbl_supplier'=> $supplier,
									'exptype'=> '1',
									'grnno'=> $grnid,
									'expcode'=> 'GRN',
									'amount'=> $totalamount,
									'status'=> '1',
									'insertdatetime'=> $updatedatetime,
									'tbl_user_idtbl_user'=> $userID);
							}
		
							elseif ($orderType==4) {
								$accountsData=array(
									'grndate'=> $grndate,
									'tbl_supplier_idtbl_supplier'=> $supplier,
									'exptype'=> '4',
									'grnno'=> $grnid,
									'expcode'=> 'MAC',
									'amount'=> $totalamount,
									'status'=> '1',
									'insertdatetime'=> $updatedatetime,
									'tbl_user_idtbl_user'=> $userID);
							}
		
							elseif ($orderType==1) {
								$accountsData=array(
									'grndate'=> $grndate,
									'tbl_supplier_idtbl_supplier'=> $supplier,
									'exptype'=> '3',
									'grnno'=> $grnid,
									'expcode'=> 'SPR',
									'amount'=> $totalamount,
									'status'=> '1',
									'insertdatetime'=> $updatedatetime,
									'tbl_user_idtbl_user'=> $userID);
							}
					

					// Insert the data into the 'tbl_expence_info' table
					$this->db->insert('tbl_expence_info', $accountsData);
				}
			}

			$data1=array('grnconfirm'=> '1',
				'updateuser'=> $userID,
				'updatedatetime'=> $updatedatetime);

			$this->db->where('idtbl_print_porder', $porderid);
			$this->db->update('tbl_print_porder', $data1);


			$this->db->trans_complete();

			if ($this->db->trans_status()===TRUE) {
				$this->db->trans_commit();

				$actionObj=new stdClass();
				$actionObj->icon='fas fa-check';
				$actionObj->title='';
				$actionObj->message='Order Confirm Successfully';
				$actionObj->url='';
				$actionObj->target='_blank';
				$actionObj->type='success';

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

		else if($type==3) {
			$data=array('status'=> '3',
				'updateuser'=> $userID,
				'updatedatetime'=> $updatedatetime);

			$this->db->where('idtbl_print_grn', $recordID);
			$this->db->update('tbl_print_grn', $data);

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

	public function Getsupplieraccoporder() {
		$recordID=$this->input->post('recordID');

		$this->db->select('`tbl_supplier_idtbl_supplier`');
		$this->db->from('tbl_print_porder');
		$this->db->where('status', 1);
		$this->db->where('idtbl_print_porder', $recordID);

		$respond=$this->db->get();

		echo $respond->row(0)->tbl_supplier_idtbl_supplier;
	}

	public function Getcompanyaccoporder() {
		$recordID=$this->input->post('recordID');

		$this->db->select('`company_id`');
		$this->db->from('tbl_print_porder');
		$this->db->where('status', 1);
		$this->db->where('idtbl_print_porder', $recordID);

		$respond=$this->db->get();

		echo $respond->row(0)->company_id;
	}
	public function Getbranchaccoporder() {
		$recordID=$this->input->post('recordID');

		$this->db->select('`company_branch_id`');
		$this->db->from('tbl_print_porder');
		$this->db->where('status', 1);
		$this->db->where('idtbl_print_porder', $recordID);

		$respond=$this->db->get();

		echo $respond->row(0)->company_branch_id;
	}

	 public function Getporderaccsupllier() {
            $recordID = $this->input->post('recordID');
        
            $this->db->select('*');
            $this->db->from('tbl_print_porder');
            // $this->db->join('tbl_print_dispatch', 'tbl_print_dispatchdetail.tbl_print_dispatch_idtbl_print_dispatch = tbl_print_dispatch.idtbl_print_dispatch');
            $this->db->where('status', 1);
			$this->db->where('confirmstatus', 1);
			$this->db->where('grnconfirm', 0);
            $this->db->where('tbl_supplier_idtbl_supplier', $recordID);
			$this->db->where_in('tbl_order_type_idtbl_order_type', array(1, 3, 4));
        
            $respond = $this->db->get();
        
            if ($respond->num_rows() > 0) {
                echo json_encode($respond->result());
            }
        }
        
    //////////////////////////////////////////////// Get Materials product/////////////////////////////////////////

	public function Getproductaccoporder() {
		$recordID=$this->input->post('recordID');

		$sql="SELECT `tbl_print_material_info`.`idtbl_print_material_info`, `tbl_print_material_info`.`materialinfocode`, `tbl_print_material_info`.`materialname` FROM `tbl_print_porder_detail` LEFT JOIN `tbl_print_material_info` ON `tbl_print_material_info`.`idtbl_print_material_info`=`tbl_print_porder_detail`.`tbl_material_id` WHERE `tbl_print_material_info`.`status`=? AND `tbl_print_porder_detail`.`tbl_print_porder_idtbl_print_porder`=?";
		$respond=$this->db->query($sql, array(1, $recordID));

		echo json_encode($respond->result());
	}

	//////////////////////////////////////////////// Get Spare part product/////////////////////////////////////////
	public function Getproductforsparepart() {
		$recordID=$this->input->post('recordID');

		$sql="SELECT `tbl_spareparts`.`idtbl_spareparts`, `tbl_spareparts`.`spare_part_name` FROM `tbl_print_porder_detail` LEFT JOIN `tbl_spareparts` ON `tbl_spareparts`.`idtbl_spareparts` = `tbl_print_porder_detail`.`tbl_sparepart_id` WHERE `tbl_spareparts`.`status` = ? AND `tbl_print_porder_detail`.`tbl_print_porder_idtbl_print_porder` = ?";
		$respond=$this->db->query($sql, array(1, $recordID));

		echo json_encode($respond->result());
	}

	//////////////////////////////////////////////// Get Machine product/////////////////////////////////////////
	public function Getproductformachine() {
		$recordID=$this->input->post('recordID');

		$sql="SELECT `tbl_machine`.`idtbl_machine`, `tbl_machine`.`machine` FROM `tbl_print_porder_detail` LEFT JOIN `tbl_machine` ON `tbl_machine`.`idtbl_machine` = `tbl_print_porder_detail`.`tbl_machine_id` WHERE `tbl_machine`.`status` = ? AND `tbl_print_porder_detail`.`tbl_print_porder_idtbl_print_porder` = ?";
		$respond=$this->db->query($sql, array(1, $recordID));

		echo json_encode($respond->result());
	}

	// new//////////////////////////////////////////
	public function Getproductinfoaccoproduct() {
		$recordID=$this->input->post('recordID');
		$grn_id=$this->input->post('grn_id');

		$this->db->select('`qty`, `unitprice`, `comment`, `measure_type_id`');
		$this->db->from('tbl_print_porder_detail');
		$this->db->where('status', 1);
		$this->db->where('tbl_print_porder_idtbl_print_porder', $grn_id);
		$this->db->where('tbl_material_id', $recordID);

		$respond=$this->db->get();

		if($respond->num_rows()>0) {
			$obj=new stdClass();
			$obj->qty=$respond->row(0)->qty;
			$obj->uom=$respond->row(0)->measure_type_id;
			$obj->unitprice=$respond->row(0)->unitprice;
			$obj->comment=$respond->row(0)->comment;
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

	public function Getproductinfoamachine() {
		$recordID=$this->input->post('recordID');
		$porderid=$this->input->post('grn_id');

		$this->db->select('`qty`, `unitprice`, `comment` ,`measure_type_id`');
		$this->db->from('tbl_print_porder_detail');
		$this->db->where('status', 1);
		$this->db->where('tbl_machine_id', $recordID);
		$this->db->where('tbl_print_porder_idtbl_print_porder', $porderid);

		$respond=$this->db->get();

		if($respond->num_rows()>0) {
			$obj=new stdClass();
			$obj->qty=$respond->row(0)->qty;
			$obj->unitprice=$respond->row(0)->unitprice;
			$obj->uom=$respond->row(0)->measure_type_id;
			$obj->comment=$respond->row(0)->comment;
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

		$this->db->select('`qty`, `unitprice`, `comment` ,`measure_type_id`');
		$this->db->from('tbl_print_porder_detail');
		$this->db->where('status', 1);
		$this->db->where('tbl_sparepart_id', $recordID);
		$this->db->where('tbl_print_porder_idtbl_print_porder', $porderid);

		$respond=$this->db->get();

		if($respond->num_rows()>0) {
			$obj=new stdClass();
			$obj->qty=$respond->row(0)->qty;
			$obj->unitprice=$respond->row(0)->unitprice;
			$obj->uom=$respond->row(0)->measure_type_id;
			$obj->comment=$respond->row(0)->comment;
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

	// public function Getexpdateaccoquater(){
	//     $recordID=$this->input->post('recordID');
	//     $mfdate=$this->input->post('mfdate');

	//     if($recordID==1){$addmonth=3;}
	//     else if($recordID==2){$addmonth=6;}
	//     else if($recordID==3){$addmonth=9;}
	//     else if($recordID==4){$addmonth=12;}
	//     else if($recordID==5){$addmonth=18;}
	//     else if($recordID==6){$addmonth=24;}

	//     echo date('Y-m-d', strtotime("+$addmonth months", strtotime($mfdate)));
	// }
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

			// print_r($this->db->last_query());    
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


	// public function GetBatchNoFromMachineAndMaterialInfo() {
	//     $recordID = $this->input->post('recordID');

	//     if (!empty($recordID)) {
	//         // Query to get information from tbl_machine
	//         $this->db->select('tbl_machine.`idtbl_machine`, tbl_machine.machinecode');
	//         $this->db->from('tbl_machine');
	//         $this->db->where('tbl_machine.idtbl_machine', $recordID);
	//         $this->db->where('tbl_machine.status', 1);

	//         $machineInfo = $this->db->get();
	//         $machineCode = $machineInfo->row(0)->machinecode;
	//         $machineId = $machineInfo->row(0)->idtbl_machine;

	//         // Query to get information from tbl_print_material_info
	//         $this->db->select('tbl_print_material_info.`idtbl_print_material_info`, tbl_print_material_info.materialinfocode');
	//         $this->db->from('tbl_print_material_info');
	//         $this->db->where('tbl_print_material_info.tbl_machine_idtbl_machine', $machineId);
	//         $this->db->where('tbl_print_material_info.status', 1);

	//         $materialInfo = $this->db->get();
	//         $materialCode = $materialInfo->row(0)->materialinfocode;
	//         $materialInfoId = $materialInfo->row(0)->idtbl_print_material_info;

	//         $sql = "SELECT COUNT(*) AS `count` FROM `tbl_print_grn`";
	//         $response = $this->db->query($sql);

	//         if ($response->row(0)->count == 0) {
	//             $batchNo = date('dmY') . '001';
	//         } else {
	//             $count = '000' . ($response->row(0)->count + 1);
	//             $count = substr($count, -3);
	//             $batchNo = date('dmY') . $count;
	//         }

	//         echo $machineCode . $materialCode . $batchNo;
	//     } else {
	//         echo '';
	//     }
	// }


	public function Getordertype() {
		$this->db->select('`idtbl_order_type`, `type`');
		$this->db->from('tbl_order_type');
		$this->db->where('status', 1);
		$this->db->where_in('idtbl_order_type', array(1, 3, 4));

		return $respond=$this->db->get();
	}

	public function Getpordertpeaccoporder() {
		$recordID=$this->input->post('recordID');

		$this->db->select('`tbl_order_type_idtbl_order_type`');
		$this->db->from('tbl_print_porder');
		$this->db->where('status', 1);
		$this->db->where('idtbl_print_porder', $recordID);

		$respond=$this->db->get();

		echo $respond->row(0)->tbl_order_type_idtbl_order_type;
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

}
