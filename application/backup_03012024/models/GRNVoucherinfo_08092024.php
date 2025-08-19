<?php
    use Dompdf\Dompdf;
    use Dompdf\Options;
    class GRNVoucherinfo extends CI_Model{
	
    public function Getcostlisttype() {
        $this->db->select('`idtbl_import_cost_types`, `cost_type`');
        $this->db->from('tbl_import_cost_types');
        $this->db->where('status', 1);
    
        return $respond=$this->db->get();
    }

    public function Getsupplierlist() {
        $this->db->select('idtbl_supplier, name');
        $this->db->from('tbl_supplier');
        $this->db->where('status', 1);
    
        return $this->db->get();
    }

    
    public function get_grn_details($grnno) {
        $this->db->select('tbl_print_grndetail.*,tbl_print_grn.tbl_order_type_idtbl_order_type, tbl_print_material_info.idtbl_print_material_info, tbl_print_material_info.materialinfocode, tbl_print_material_info.materialname,tbl_machine.machine,tbl_machine.machinecode,tbl_measurements.measure_type');
		$this->db->from('tbl_print_grndetail');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_print_grndetail.tbl_print_material_info_idtbl_print_material_info', 'left');
		$this->db->join('tbl_print_grn', 'tbl_print_grn.idtbl_print_grn = tbl_print_grndetail.tbl_print_grn_idtbl_print_grn', 'left');
		$this->db->join('tbl_machine', 'tbl_machine.idtbl_machine = tbl_print_grndetail.tbl_machine_id', 'left');
		$this->db->join('tbl_measurements', 'tbl_measurements.idtbl_mesurements = tbl_print_grndetail.measure_type_id', 'left');
        $this->db->where('tbl_print_grn_idtbl_print_grn', $grnno);
        $this->db->where('tbl_print_grndetail.status', 1);

        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
    
    public function Insertgrnvoucher() {
        $this->db->trans_begin();
    
        $userID = $_SESSION['userid'];
        $grnDetails = $this->input->post('grnDetails');
        $costDetails = $this->input->post('costDetails');
        $grndate = $this->input->post('date');
        $hidetotalorder = $this->input->post('totalGRN');
        $hidechargestotal = $this->input->post('totalCost');
        $remark = $this->input->post('remark');
        $grnno = $this->input->post('grnno');
    
        $updatedatetime = date('Y-m-d H:i:s');
    
        // Insert the GRN voucher
        $data = array(
            'date' => $grndate,
            'total' => $hidechargestotal,
            'grntotal' => $hidetotalorder,
            'remarks' => $remark,
            'approvestatus' => '0',
            'status' => '1',
            'insertdatetime' => $updatedatetime,
            'tbl_user_idtbl_user' => $userID,
            'tbl_print_grn_idtbl_print_grn' => $grnno
        );
    
        $this->db->insert('tbl_grn_vouchar_import_cost', $data);
        $grnvoucherID = $this->db->insert_id();
    
        // Insert the GRN details
        foreach ($grnDetails as $grn) {
            $data = array(
                'date' => $grndate,
                'qty' => $grn['qty'],
                'costunitprice' => $grn['unitprice'],
                'total' => $grn['total'],
                'comment' => $grn['comment'],
                'measure_type_id' => 0,
                'status' => '1',
                'insertdatetime' => $updatedatetime,
                'tbl_print_grn_idtbl_print_grn' => $grnno,
                'tbl_print_material_info_idtbl_print_material_info' => $grn['idtbl_print_material_info']
            );
    
            $this->db->insert('tbl_print_grndetail_after_costing', $data);
        }
    
        // Check if costDetails is empty
        if (empty($costDetails)) {
            // Insert a default entry with cost_amount as 0
            $data = array(
                'cost_amount' => 0,
                'status' => '1',
                'insertdatetime' => $updatedatetime,
                'tbl_grn_vouchar_import_cost_idtbl_grn_vouchar_import_cost' => $grnvoucherID,
                'tbl_import_cost_types_idtbl_import_cost_types' => 0  // Assuming 0 as a default type ID
            );
    
            $this->db->insert('tbl_grn_vouchar_import_cost_detail', $data);
        } else {
            // Insert the cost details
            foreach ($costDetails as $cost) {
                $data = array(
                    'cost_amount' => $cost['chargeamount'],
                    'status' => '1',
                    'insertdatetime' => $updatedatetime,
                    'tbl_grn_vouchar_import_cost_idtbl_grn_vouchar_import_cost' => $grnvoucherID,
                    'tbl_import_cost_types_idtbl_import_cost_types' => $cost['chargetypeid']
                );
    
                $this->db->insert('tbl_grn_vouchar_import_cost_detail', $data);
            }
        }
    
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
    
            $actionObj = new stdClass();
            $actionObj->icon = 'fas fa-save';
            $actionObj->title = '';
            $actionObj->message = 'Record Added Successfully';
            $actionObj->url = '';
            $actionObj->target = '_blank';
            $actionObj->type = 'success';
    
            $actionJSON = json_encode($actionObj);
    
            $obj = new stdClass();
            $obj->status = 1;
            $obj->action = $actionJSON;
    
            echo json_encode($obj);
        } else {
            $this->db->trans_rollback();
    
            $actionObj = new stdClass();
            $actionObj->icon = 'fas fa-exclamation-triangle';
            $actionObj->title = '';
            $actionObj->message = 'Record Error';
            $actionObj->url = '';
            $actionObj->target = '_blank';
            $actionObj->type = 'danger';
    
            $actionJSON = json_encode($actionObj);
    
            $obj = new stdClass();
            $obj->status = 0;
            $obj->action = $actionJSON;
    
            echo json_encode($obj);
        }
    }
    

    public function Goodreceivevoucherview() {
        $recordID=$this->input->post('recordID');
    
        $sql="SELECT `u`.*, `ub`.`name`, `ub`.`telephone_no`, `ub`.`address_line1` FROM `tbl_grn_vouchar_import_cost` AS `u` LEFT JOIN `tbl_print_grn` AS `ua` ON (`ua`.`idtbl_print_grn` = `u`.`tbl_print_grn_idtbl_print_grn`) LEFT JOIN `tbl_supplier` AS `ub` ON (`ub`.`idtbl_supplier` = `ua`.`tbl_supplier_idtbl_supplier`) WHERE `u`.`status`=? AND `u`.`idtbl_grn_vouchar_import_cost`=?";
        $respond=$this->db->query($sql, array(1, $recordID));
    
        $this->db->select('tbl_grn_vouchar_import_cost_detail.*, tbl_import_cost_types.cost_type');
        $this->db->from('tbl_grn_vouchar_import_cost_detail');
        $this->db->join('tbl_grn_vouchar_import_cost', 'tbl_grn_vouchar_import_cost.idtbl_grn_vouchar_import_cost = tbl_grn_vouchar_import_cost_detail.tbl_grn_vouchar_import_cost_idtbl_grn_vouchar_import_cost', 'left');
        $this->db->join('tbl_import_cost_types', 'tbl_import_cost_types.idtbl_import_cost_types = tbl_grn_vouchar_import_cost_detail.tbl_import_cost_types_idtbl_import_cost_types', 'left');
        $this->db->where('tbl_grn_vouchar_import_cost_detail.tbl_grn_vouchar_import_cost_idtbl_grn_vouchar_import_cost', $recordID);
        $this->db->where('tbl_grn_vouchar_import_cost_detail.status', 1);
    
        $responddetail=$this->db->get();
        // print_r($this->db->last_query());
    
        $html='';
    
        $html.='
        <div class="row"><div class="col-12 text-right font-family: cursive;font-size:15px; font-weight: bold;">'.$respond->row(0)->name.'</div><div class="col-12"><hr><h6>GRN No: MO/GRN-0000'.$respond->row(0)->tbl_print_grn_idtbl_print_grn.'</h6></div> </div> <div class="row"> <div class="col-12"> <hr> <table class="table table-striped table-bordered table-sm"> <thead> <tr> <th>Cost Type</th> <th class="text-right">Cost Amount</th></tr></thead><tbody>';
        foreach($responddetail->result() as $roworderinfo) {
                    $html.='<tr>
                    <td>'.$roworderinfo->cost_type.'</td><td class="text-right">'.$roworderinfo->cost_amount.'</td></tr>';
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
                                <td width="70%" style="text-align: right; font-weight: bold;">Total Cost</td>
                                <td width="10%" style="text-align: right; font-weight: bold;">:</td>
                                <td width="20%" style="text-align: right; font-weight: bold;">Rs. ' . number_format(($respond->row(0)->total), 2) . '</td>
                            </tr>
    
                        </tbody>
                    </table>
    
                    </body>
                    </html>';
    
        echo $html;
    }

    public function Getgrnaccsupllier() {
        $recordID = $this->input->post('recordID');
    
        $this->db->select('tbl_print_grn.idtbl_print_grn');
        $this->db->from('tbl_print_grn');
        $this->db->join('tbl_grn_vouchar_import_cost', 'tbl_grn_vouchar_import_cost.tbl_print_grn_idtbl_print_grn = tbl_print_grn.idtbl_print_grn', 'left');
        $this->db->where('tbl_print_grn.status', 1);
        $this->db->where('tbl_print_grn.approvestatus', 1);
        $this->db->where('tbl_print_grn.tbl_supplier_idtbl_supplier', $recordID);
        $this->db->where_in('tbl_print_grn.tbl_order_type_idtbl_order_type', array(1, 3, 4));
    
        // Add an additional condition if approvestatus !== 0
        $this->db->group_start();
        $this->db->where('tbl_grn_vouchar_import_cost.approvestatus !=', 1);
        $this->db->or_where('tbl_grn_vouchar_import_cost.approvestatus IS NULL');
        $this->db->group_end();
    
        $respond = $this->db->get();
    
        if ($respond->num_rows() > 0) {
            echo json_encode($respond->result());
        }
    }
    

    public function Goodreceivevoucherstatus($x, $y, $z) {
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
    
            $this->db->where('idtbl_grn_vouchar_import_cost', $recordID);
            $this->db->update('tbl_grn_vouchar_import_cost', $data);



            ////////////////////////////////////////////// Add Materials and Machine to stock Table //////////////////////////////////////////////////////////////////

			$this->db->select('tbl_print_grn.batchno,tbl_print_grn.grntype, tbl_print_grn.tbl_location_idtbl_location,tbl_print_grn.tbl_supplier_idtbl_supplier,tbl_print_grn.grndate,tbl_print_grndetail_after_costing.qty,tbl_print_grndetail_after_costing.total,tbl_print_grndetail_after_costing.measure_type_id, tbl_print_grndetail_after_costing.costunitprice, tbl_print_grndetail_after_costing.tbl_print_material_info_idtbl_print_material_info');
			$this->db->from('tbl_grn_vouchar_import_cost');
			$this->db->join('tbl_print_grndetail_after_costing', 'tbl_grn_vouchar_import_cost.tbl_print_grn_idtbl_print_grn = tbl_print_grndetail_after_costing.tbl_print_grn_idtbl_print_grn', 'left');
            $this->db->join('tbl_print_grn', 'tbl_grn_vouchar_import_cost.tbl_print_grn_idtbl_print_grn = tbl_print_grn.idtbl_print_grn', 'left');
			$this->db->where('tbl_print_grn.status', 1);
			$this->db->where('tbl_grn_vouchar_import_cost.idtbl_grn_vouchar_import_cost', $recordID);

			$respond=$this->db->get();


            if ($respond->num_rows() > 0) {
				foreach ($respond->result() as $row) {
					$batchno=$row->batchno;
					$location=$row->tbl_location_idtbl_location;
					$supplier=$row->tbl_supplier_idtbl_supplier;
					$grndate=$row->grndate;
					$qty=$row->qty;
					$measure_type=$row->measure_type_id;
					$unitprice=$row->costunitprice;
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


            ////////////////////////////////////////////// Add GRN Details for Chart of accounts tbl_expence_info //////////////////////////////////////////////////////////////////

			$this->db->select('tbl_print_grn.idtbl_print_grn,tbl_print_grn.grndate, tbl_print_grn.total,tbl_print_grn.tbl_supplier_idtbl_supplier');
			$this->db->from('tbl_grn_vouchar_import_cost');
            $this->db->join('tbl_print_grn', 'tbl_grn_vouchar_import_cost.tbl_print_grn_idtbl_print_grn = tbl_print_grn.idtbl_print_grn', 'left');
			$this->db->where('tbl_print_grn.status', 1);
			$this->db->where('tbl_grn_vouchar_import_cost.idtbl_grn_vouchar_import_cost', $recordID);

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
    
            $this->db->trans_complete();
    
            if ($this->db->trans_status()===TRUE) {
                $this->db->trans_commit();
    
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-check';
                $actionObj->title='';
                $actionObj->message='Voucher Confirm Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='success';
    
                $actionJSON=json_encode($actionObj);
    
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('GRNVoucher');
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
                redirect('GRNVoucher');
            }
        }
    
        else if($type==3) {
            $data=array(
                'status'=> '3',
                'updateuser'=> $userID,
                'updatedatetime'=> $updatedatetime);
    
            $this->db->where('idtbl_grn_vouchar_import_cost', $recordID);
            $this->db->update('tbl_grn_vouchar_import_cost', $data);
            
    
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
                redirect('GRNVoucher');
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
                redirect('GRNVoucher');
            }
        }
    }
	
}