<?php
class Issuegoodreceiveinfo extends CI_Model{
    // public function Getcompany(){
    //     $this->db->select('`id`, `name`');
    //     $this->db->from('companies');
    //     // $this->db->where('status', 1);

    //     return $respond=$this->db->get();
    // }

    public function Getlocation() {
		$this->db->select('`idtbl_location`, `location`');
		$this->db->from('tbl_location');
		$this->db->where('status', 1);

		return $respond=$this->db->get();
	}

    public function Getdepartment(){
        $this->db->select('`id`, `name`');
        $this->db->from('departments');
        // $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Getservicetype(){
        $this->db->select('`idtbl_service_type`, `service_name`');
        $this->db->from('tbl_service_type');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    
    public function Getsupplier(){
        $this->db->select('`idtbl_supplier`, `name`');
        $this->db->from('tbl_supplier');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Getordertype(){
        $this->db->select('`idtbl_order_type`, `type`');
        $this->db->from('tbl_order_type');
        $this->db->where('status', 1);
        $this->db->where_in('idtbl_order_type', array(3, 4)); // Filter for idtbl_order_type 3 and 4

        return $respond=$this->db->get();
    }
    public function Getporder() {
		$this->db->select('`idtbl_grn_req`');
		$this->db->from('tbl_grn_req');
		$this->db->where('status', 1);
		$this->db->where('confirmstatus', 1);
        // $this->db->where('porderconfirm', 0);
		// $this->db->where_in('tbl_order_type_idtbl_order_type', array(3, 4));


		return $respond=$this->db->get();
	}

	public function Issuegoodreceiveinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $tableData=$this->input->post('tableData');
		$issuedate=$this->input->post('issuedate');
		$total=$this->input->post('total');
		$department=$this->input->post('department');
		$ordertype=$this->input->post('ordertype');
		$location=$this->input->post('location');
		$itemrequest=$this->input->post('itemrequest');
        $updatedatetime=date('Y-m-d H:i:s');

		$data=array(
		'ordertype'=> $ordertype,
		'issuedate'=> $issuedate,
		'total'=> $total,
		'approvestatus'=> '0',
		'status'=> '1',
		'insertdatetime'=> $updatedatetime,
		'tbl_user_idtbl_user'=> $userID,
		'location_id'=> $location,
		'department_id'=> $department,
		'tbl_grn_req_idtbl_grn_req'=> $itemrequest);

        $this->db->insert('tbl_print_issue', $data);

        $issueID=$this->db->insert_id();
		$materialid=0;
		$machineid=0;

			foreach($tableData as $rowtabledata) {
				$productid=$rowtabledata['col_6'];
				$comment=$rowtabledata['col_2'];
				$stockid=$rowtabledata['col_8'];
				$unitprice=$rowtabledata['col_3'];
				$qty=$rowtabledata['col_4'];
				$total=$rowtabledata['col_7'];

				$ordertype==3 ? $materialid=$productid:$machineid=$productid;

				$dataone=array(
					'issue_date'=> $issuedate,
					'qty'=> $qty,
					'unitprice'=> $unitprice,
					'total'=> $total,
					'comment'=> $comment,
					'measure_type_id'=> '0',
					'status'=> '1',
					'insertdatetime'=> $updatedatetime,
					'tbl_print_issue_idtbl_print_issue'=> $issueID,
					'tbl_print_material_info_idtbl_print_material_info'=> $materialid,
					'tbl_machine_id'=> $machineid,
					'stock_id'=> $stockid);

				$this->db->insert('tbl_print_issuedetail', $dataone);
			}

        $this->db->trans_complete();

        if ($this->db->trans_status() === TRUE) {
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
        } else {
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


	public function Issuegoodreceivestatus($x, $y, $z) {
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

			$this->db->select('tbl_print_grn.batchno,tbl_print_grn.grntype, tbl_print_grn.tbl_location_idtbl_location,tbl_print_grn.tbl_supplier_idtbl_supplier,tbl_print_grn.grndate,tbl_print_grndetail.qty,tbl_print_grndetail.measure_type_id, tbl_print_grndetail.unitprice, tbl_print_grndetail.tbl_print_material_info_idtbl_print_material_info,tbl_print_grndetail.tbl_machine_id');
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
					$materialID=$row->tbl_print_material_info_idtbl_print_material_info;
					$orderType=$row->grntype;
					$machineID=$row->tbl_machine_id;

					if ($orderType==3) {
						$stockData=array('batchno'=> $batchno,
						    'location'=> $location,
							'grndate'=> $grndate,
							'supplier_id'=> $supplier,
							'qty'=> $qty,
							'measure_type_id'=> $measure_type,
							'unitprice'=> $unitprice,
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
							'status'=> '1',
							'insertdatetime'=> $updatedatetime,
							'tbl_user_idtbl_user'=> $userID,
							'tbl_machine_id'=> $machineID);
					}

					// Insert the data into the 'tbl_print_stock' table
					$this->db->insert('tbl_print_stock', $stockData);
				}
			}

			//////////////////////////////////////////////////////////// Add Materials and Machine to stock Table ////////////////////////////////////////////////////////



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

    public function Getcompanyaccordinggrnreq() {
		$recordID=$this->input->post('recordID');

		$this->db->select('`company_id`');
		$this->db->from('tbl_grn_req');
		$this->db->where('status', 1);
		$this->db->where('idtbl_grn_req', $recordID);

		$respond=$this->db->get();

		echo $respond->row(0)->company_id;
	}
    ////////Get Location///////////////
    public function Getlocationaccoitemreq() {
		$recordID=$this->input->post('recordID');

		$this->db->select('`company_id`');
		$this->db->from('tbl_grn_req');
		$this->db->where('status', 1);
		$this->db->where('idtbl_grn_req', $recordID);

		$respond=$this->db->get();

		echo $respond->row(0)->company_id;
	}

    ////////Get Department///////////////
    public function Getdepartmentaccoitemreq() {
		$recordID=$this->input->post('recordID');

		$this->db->select('`departments_id`');
		$this->db->from('tbl_grn_req');
		$this->db->where('status', 1);
		$this->db->where('idtbl_grn_req', $recordID);

		$respond=$this->db->get();

		echo $respond->row(0)->departments_id;
	}

     ////////Get OrderType///////////////
     public function Getordertypeaccoitemreq() {
		$recordID=$this->input->post('recordID');

		$this->db->select('`tbl_order_type_idtbl_order_type`');
		$this->db->from('tbl_grn_req');
		$this->db->where('status', 1);
		$this->db->where('idtbl_grn_req', $recordID);

		$respond=$this->db->get();

		echo $respond->row(0)->tbl_order_type_idtbl_order_type;
	}

    //Get Material////
    public function Getmaterialitem() {
		$recordID=$this->input->post('recordID');

		$sql="SELECT `tbl_print_material_info`.`idtbl_print_material_info`, `tbl_print_material_info`.`materialinfocode`, `tbl_print_material_info`.`materialname` FROM `tbl_grn_req_detail` LEFT JOIN `tbl_print_material_info` ON `tbl_print_material_info`.`idtbl_print_material_info`=`tbl_grn_req_detail`.`tbl_material_id` WHERE `tbl_print_material_info`.`status`=? AND `tbl_grn_req_detail`.`tbl_grn_req_idtbl_grn_req`=?";
		$respond=$this->db->query($sql, array(1, $recordID));

		echo json_encode($respond->result());
	}

	// Get Machine/////
	public function Getmachineitem() {
		$recordID=$this->input->post('recordID');

		$sql="SELECT `tbl_machine`.`idtbl_machine`, `tbl_machine`.`machine` FROM `tbl_grn_req_detail` LEFT JOIN `tbl_machine` ON `tbl_machine`.`idtbl_machine` = `tbl_grn_req_detail`.`tbl_machine_id` WHERE `tbl_machine`.`status` = ? AND `tbl_grn_req_detail`.`tbl_grn_req_idtbl_grn_req` = ?";
		$respond=$this->db->query($sql, array(1, $recordID));

		echo json_encode($respond->result());
	}

    public function Getproductinfoaccoproduct() {
		$recordID=$this->input->post('recordID');
		// $itemreq_id=$this->input->post('grn_id');

		$this->db->select('*');
		$this->db->from('tbl_print_stock');
		$this->db->where('status', 1);
		$this->db->where('tbl_print_material_info_idtbl_print_material_info', $recordID);

		$respond=$this->db->get();

		if($respond->num_rows()>0) {
			echo json_encode($respond->result());
		}

	}
	public function Getproductinfoaccomachine() {
		$recordID=$this->input->post('recordID');
		// $itemreq_id=$this->input->post('grn_id');

		$this->db->select('*');
		$this->db->from('tbl_print_stock');
		$this->db->where('status', 1);
		$this->db->where('tbl_machine_id', $recordID);

		$respond=$this->db->get();

		if($respond->num_rows()>0) {
			echo json_encode($respond->result());
		}

	}

    public function GetBachnoInfo() {
		$recordID=$this->input->post('recordID');
		// $itemreq_id=$this->input->post('grn_id');

		$this->db->select('*');
		$this->db->from('tbl_print_stock');
		$this->db->where('status', 1);
		// $this->db->where('tbl_print_porder_idtbl_print_porder', $grn_id);
		$this->db->where('idtbl_print_stock', $recordID);

		$respond=$this->db->get();

		if($respond->num_rows()>0) {
			$obj=new stdClass();
			$obj->item=$respond->row();
		}

		echo json_encode($obj);
	}

    public function GetitemreQTY() {
		$recordID=$this->input->post('recordID');
		// $itemreq_id=$this->input->post('grn_id');

		$this->db->select('`qty`');
		$this->db->from('tbl_print_stock');
		$this->db->where('status', 1);
		// $this->db->where('tbl_print_porder_idtbl_print_porder', $grn_id);
		$this->db->where('idtbl_print_stock', $recordID);

		$respond=$this->db->get();

		if($respond->num_rows()>0) {
			$obj=new stdClass();
			 $obj->qty=$respond->row(0)->qty;
			// $obj->uom=$respond->row(0)->measure_type_id;
			// $obj->unitprice=$respond->row(0)->unitprice;
			//$obj->batchno=$respond->row(0)->batchno;
		}

		echo json_encode($obj);
	}

	public function Getqtyfromreq() {
		$recordID=$this->input->post('recordID');
		$itemreq_id=$this->input->post('itemreq_id');

		$this->db->select('`qty`');
		$this->db->from('tbl_grn_req_detail');
		$this->db->where('status', 1);
		$this->db->where('tbl_grn_req_idtbl_grn_req', $itemreq_id);
		$this->db->where('tbl_material_id', $recordID);

		$respond=$this->db->get();

		if($respond->num_rows()>0) {
			$obj=new stdClass();
			 $obj->qtylabel=$respond->row(0)->qty;
			// $obj->uom=$respond->row(0)->measure_type_id;
			// $obj->unitprice=$respond->row(0)->unitprice;
			//$obj->batchno=$respond->row(0)->batchno;
		}

		echo json_encode($obj);
	}

	public function Getqtyfromreqmachine() {
		$recordID=$this->input->post('recordID');
		$itemreq_id=$this->input->post('itemreq_id');

		$this->db->select('`qty`');
		$this->db->from('tbl_grn_req_detail');
		$this->db->where('status', 1);
		$this->db->where('tbl_grn_req_idtbl_grn_req', $itemreq_id);
		$this->db->where('tbl_machine_id', $recordID);

		$respond=$this->db->get();

		if($respond->num_rows()>0) {
			$obj=new stdClass();
			 $obj->qtylabel=$respond->row(0)->qty;
			// $obj->uom=$respond->row(0)->measure_type_id;
			// $obj->unitprice=$respond->row(0)->unitprice;
			//$obj->batchno=$respond->row(0)->batchno;
		}

		echo json_encode($obj);
	}

	public function Issueview() {
		$recordID=$this->input->post('recordID');

		

		$this->db->select('tbl_print_issuedetail.*');
		$this->db->from('tbl_print_issuedetail');
		$this->db->where('tbl_print_issuedetail.tbl_print_issue_idtbl_print_issue', $recordID);
		$this->db->where('tbl_print_issuedetail.status', 1);

		$responddetail=$this->db->get();
		// print_r($this->db->last_query());

		$html='';

		$html.='
 <table class="table table-striped table-bordered table-sm" id="approveltable"> 
 <thead> 
 <tr> 
 <th class="text-center">Qty</th> 
 <th class="text-right">Unit Price</th> 
 <th class="text-right">Total</th> 
 <th class="text-center d-none">materialid</th> 
 <th class="text-center d-none">machineid</th>
 <th class="text-center d-none">stockid</th>  
 </tr> 
 </thead> 
 <tbody>';
foreach($responddetail->result() as $roworderinfo) {
			$total=number_format(($roworderinfo->qty*$roworderinfo->unitprice), 2);
		$html.='<tr>
				<td class="text-center">'.$roworderinfo->qty.'</td>
				<td class="text-right">'.$roworderinfo->unitprice.'</td>
				<td class="text-right">'.$total.'</td>
				<td class="text-center d-none">'.$roworderinfo->tbl_print_material_info_idtbl_print_material_info.'</td>
				<td class="text-center d-none">'.$roworderinfo->tbl_machine_id.'</td>
				<td class="text-center d-none">'.$roworderinfo->stock_id.'</td>';
		}
		$html.='</tbody></table>';

		echo $html;
	}


	public function Approveissue(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $tableData=$this->input->post('tableData');
		$viewissueid=$this->input->post('viewissueid');
        $updatedatetime=date('Y-m-d H:i:s');

		$data=array(
			'approvestatus '=> '1',
			'updateuser'=> $userID,
			'updatedatetime'=> $updatedatetime);

		$this->db->where('idtbl_print_issue', $viewissueid);
		$this->db->update('tbl_print_issue', $data);

			foreach($tableData as $rowtabledata) {
				$stockid=$rowtabledata['col_6'];
				$issueqty=$rowtabledata['col_1'];

				$this->db->select('qty');
				$this->db->from('tbl_print_stock');
				$this->db->where('idtbl_print_stock', $stockid);

				$query = $this->db->get();

				$currentQuantity=0;
				if ($query->num_rows() > 0) {
					$row = $query->row();
					$currentQuantity = $row->qty;
				} 
				$newQuantity = $currentQuantity - $issueqty;


				$data1=array(
					'qty '=> $newQuantity,
					'updateuser'=> $userID,
					'updatedatetime'=> $updatedatetime);
		
				$this->db->where('idtbl_print_stock', $stockid);
				$this->db->update('tbl_print_stock', $data1);
		
			}

        $this->db->trans_complete();

        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            
            $actionObj=new stdClass();
            $actionObj->icon='fas fa-save';
            $actionObj->title='';
            $actionObj->message='Record Issue Successfully';
            $actionObj->url='';
            $actionObj->target='_blank';
            $actionObj->type='success';

            $actionJSON=json_encode($actionObj);

            $obj=new stdClass();
            $obj->status=1;          
            $obj->action=$actionJSON;  
            
            echo json_encode($obj);
        } else {
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