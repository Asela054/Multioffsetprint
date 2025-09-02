<?php
use Dompdf\Dompdf;
use Dompdf\Options;
class Issuegoodreceiveinfo extends CI_Model{

    public function Getlocation() {
		$this->db->select('`idtbl_location`, `location`');
		$this->db->from('tbl_location');
		$this->db->where('status', 1);

		return $respond=$this->db->get();
	}

    public function Getemployee(){
        $comapnyID=$_SESSION['company_id'];

        $this->db->select('`id`, `emp_id`, `emp_name_with_initial`');
        $this->db->from('employees');
        $this->db->where('emp_location', $comapnyID);
        $this->db->where('is_resigned', 0);

        return $respond=$this->db->get();
    }
    public function Getservicetype(){
        $this->db->select('`idtbl_service_type`, `service_name`');
        $this->db->from('tbl_service_type');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    
    public function Getsupplier(){
        $this->db->select('`idtbl_supplier`, `suppliername`');
        $this->db->from('tbl_supplier');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Getordertype(){
        $this->db->select('`idtbl_order_type`, `type`');
        $this->db->from('tbl_order_type');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Getporder() {
		$this->db->select('`idtbl_grn_req`');
		$this->db->from('tbl_grn_req');
		$this->db->where('status', 1);
		$this->db->where('confirmstatus', 1);

		return $respond=$this->db->get();
	}

	public function Issuegoodreceiveinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $tableData=$this->input->post('tableData');
		$issuedate=$this->input->post('issuedate');
		$total=$this->input->post('total');
		$employee=$this->input->post('employee');
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
		'employee_id'=> $employee,
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

		$this->db->select('`employee_id`');
		$this->db->from('tbl_grn_req');
		$this->db->where('status', 1);
		$this->db->where('idtbl_grn_req', $recordID);

		$respond=$this->db->get();

		echo $respond->row(0)->employee_id;
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

		$sql="SELECT `tbl_print_material_info`.`idtbl_print_material_info`, `tbl_print_material_info`.`materialinfocode`, `tbl_print_material_info`.`materialname` FROM `tbl_grn_req_detail` LEFT JOIN `tbl_print_material_info` ON `tbl_print_material_info`.`idtbl_print_material_info`=`tbl_grn_req_detail`.`tbl_material_id` WHERE `tbl_grn_req_detail`.`tbl_grn_req_idtbl_grn_req`=?";
		$respond=$this->db->query($sql, array($recordID));

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
		$recordID = $this->input->post('recordID');
	
		$this->db->select('idtbl_print_stock, batchno, qty');
		$this->db->from('tbl_print_stock');
		$this->db->where('status', 1);
		$this->db->where('tbl_print_material_info_idtbl_print_material_info', $recordID);
	
		$respond = $this->db->get();
	
		if ($respond->num_rows() > 0) {
			echo json_encode($respond->result());
		} else {
			echo json_encode([]);
		}
	}
	
	public function Getproductinfoaccomachine() {
		$recordID=$this->input->post('recordID');

		$this->db->select('*');
		$this->db->from('tbl_print_stock');
		$this->db->where('status', 1);
		$this->db->where('tbl_machine_id', $recordID);

		$respond=$this->db->get();

		if($respond->num_rows()>0) {
			echo json_encode($respond->result());
		}

	}

    public function GetitemreQTY() {
		$recordID=$this->input->post('recordID');

		$this->db->select('`qty`');
		$this->db->from('tbl_print_stock');
		$this->db->where('status', 1);
		$this->db->where('idtbl_print_stock', $recordID);

		$respond=$this->db->get();

		if($respond->num_rows()>0) {
			$obj=new stdClass();
			 $obj->qty=$respond->row(0)->qty;
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
		}

		echo json_encode($obj);
	}

	public function Issueview() {
		$recordID = $this->input->post('recordID');
	
		$this->db->select('tbl_print_issuedetail.*');
		$this->db->from('tbl_print_issuedetail');
		$this->db->where('tbl_print_issuedetail.tbl_print_issue_idtbl_print_issue', $recordID);
		$this->db->where('tbl_print_issuedetail.status', 1);
	
		$responddetail = $this->db->get();
	
		$html = '';
		
		foreach($responddetail->result() as $roworderinfo) {
			$total = number_format(($roworderinfo->qty * $roworderinfo->unitprice), 2);
			$html .= '<tr>
							<td class="text-center">'.$roworderinfo->qty.'</td>
							<td class="text-right">'.$roworderinfo->unitprice.'</td>
							<td class="text-right">'.$total.'</td>
							<td class="text-center d-none">'.$roworderinfo->tbl_print_material_info_idtbl_print_material_info.'</td>
							<td class="text-center d-none">'.$roworderinfo->tbl_machine_id.'</td>
							<td class="text-center d-none">'.$roworderinfo->stock_id.'</td>
							<td class="accountlist"></td>
							<td class="text-center d-none"><input type="text" class="row_account_id" name="row_account_id[]"></td>					
							<td class="text-center d-none"><input type="text" class="row_account_type" name="row_account_type[]"></td>
						</tr>';
		}
	
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
				$stockid = $rowtabledata['stockid'];
				$issueqty = $rowtabledata['qty'];
				$account_id = $rowtabledata['account_id'];
				$account_type = $rowtabledata['account_type'];

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

				$accountData = array();
				if ($account_type == 1) {
					$accountData['tbl_account_idtbl_account'] = $account_id;
				} elseif ($account_type == 2) {
					$accountData['tbl_account_detail_idtbl_account_detail'] = $account_id;
				}

				$data = array_merge(array(
					'updateuser'=> $userID,
					'updatedatetime'=> $updatedatetime
				), $accountData);
		
				$this->db->where('stock_id', $stockid);
				$this->db->where('tbl_print_issue_idtbl_print_issue', $viewissueid);
				$this->db->update('tbl_print_issuedetail', $data);
		
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

	public function Issuepdf($x)
	{

		$recordID = $x;

		$this->db->select('tbl_print_issuedetail.*, tbl_print_issue.ordertype, tbl_order_type.type, tbl_location.location, employees.emp_id, employees.emp_name_with_initial, tbl_print_issue.idtbl_print_issue, tbl_print_material_info.materialname, tbl_machine.machine');
		$this->db->from('tbl_print_issuedetail');
		$this->db->join('tbl_print_issue', 'tbl_print_issuedetail.tbl_print_issue_idtbl_print_issue = tbl_print_issue.idtbl_print_issue', 'left');
		$this->db->join('tbl_order_type', 'tbl_print_issue.ordertype = tbl_order_type.idtbl_order_type', 'left');
		$this->db->join('tbl_print_material_info', 'tbl_print_issuedetail.tbl_print_material_info_idtbl_print_material_info = tbl_print_material_info.idtbl_print_material_info', 'left');
		$this->db->join('tbl_machine', 'tbl_print_issuedetail.tbl_machine_id = tbl_machine.idtbl_machine', 'left');

		$this->db->join('tbl_location', 'tbl_print_issue.location_id = tbl_location.idtbl_location', 'left');
		$this->db->join('employees', 'tbl_print_issue.employee_id = employees.id', 'left');

		$this->db->where('tbl_print_issuedetail.tbl_print_issue_idtbl_print_issue', $recordID);
		$this->db->where('tbl_print_issuedetail.status', 1);

		$responddetail = $this->db->get();
		if ($responddetail->num_rows() > 0) {
			$row = $responddetail->row();
			$ordertype = $row->type;
			$location = $row->location;
			$name = $row->emp_name_with_initial;
			$empid = $row->emp_id;
			$idtbl_print_issue = $row->idtbl_print_issue;
		}

		$sub_total_amount = 0;
		$path = 'images/book.jpg';
		$type = pathinfo($path, PATHINFO_EXTENSION);
		$data = file_get_contents($path);
		$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

		$this->load->library('pdf');

		$fontDir = 'fonts/';
		$options = new Options();
		$options->set('fontDir', $fontDir);
		$options->set('isPhpEnabled', true);
		$dompdf = new Dompdf($options);

		$html = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Purchase Order Request</title>
            <style>
                
                body {
                    margin: 5px;
                    padding: 5px;
                    font-family: Arial, sans-serif;
                    width: 100%;
                }
                p {
                    font-size: 14px;
                    line-height: 3px;
                }
                .pheader {
                    font-size: 12px;
                    line-height: 1.5px;
                }
                .tablec {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 20px;
                }
                .thc, .tdc {
                    padding: 5px;
                    text-align: left;
                    border: 1px solid black;
                }
                .thc {
                    background-color: #f2f2f2;
                   
                }
                hr {
                    border: 1px solid #ddd;
                }
                .postion {
                    position: relative;
                }
                .pos{
                    padding-bottom: -20px; 
                }
                .hedfont {
                    font: 20px comicz;
                }
            </style>
        </head>
        <body>

            <table border="0" width="100%">

                <tr>
                    <th width="15%" valign="top"></th>
                    <td align="center">
                        <h3><i>MULTI OFFSET PRINTERS (PVT) LTD</i></h3>
                        <p class="pheader"><i>345,NEGOMBO ROAD MUKALANGAMUWA, SEEDUWA</i></p>
                        <p class="pheader"><i>Phone : +94-11-2253505, 2253876, 2256615</i></p>
                        <p class="pheader"><i>E-Mail : multioffsetprinters@gmail.com</i></p>
                        <p class="pheader"><i>Fax : +94-11-2254057</i></p>
                    </td>
                    <th width="15%"></th>
                </tr>

                <tr>
                    <th colspan="3" height="10px"></th>
                </tr>

                <tr>
                    <td colspan="3">
                        <table width="100%" border="0" cellspacing="0">
                            <tr>
                                <td class="postion"><h3 class="pos">Issue Item Request</h3></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td valign="top">
                                    <p><b>Location: </b>' . $location . '</p>
                                    
                                    <p><b>Employee: </b>' .$name. '-'.$empid. '</p>
									
                                    <p><b>Order Type: </b>' . $ordertype . '</p>
                                    
                                      
                                </td>
                                <td></td>
                                <td align="right" width="30%" valign="top">
                                    <p>MO/GRNR-<b>' . $idtbl_print_issue . '</b></p>
                                </td>
                            </tr>
                            
                        </table>
                    </td>
                </tr>

                <tr>
                    <td colspan="3"><hr></td>
                </tr>

                <tr>
                    <td colspan="3">
                        <table class="tablec">
                            <thead class="thc">
                                <tr>
								<th class="thc" style="text-align:center;" width="25%">Item Name</th>
                                    <th class="thc" style="text-align:center;" width="25%">Qty</th>
                                    <th class="thc" width="25%" style="text-align:right;">Unit Price</th>
									<th class="thc" width="25%" style="text-align:right;">Total</th>
                                </tr>
                            </thead>
                            <tbody class="tdc">';

								foreach ($responddetail->result() as $roworderinfo) {
									$total = ($roworderinfo->qty * $roworderinfo->unitprice);
									$html .= '<tr>';
									if ($roworderinfo->tbl_print_material_info_idtbl_print_material_info == 0) {
										$html .= '<td class="tdc" style="text-align:center;">' . $roworderinfo->machine . '</td>';
									} else {
										$html .= '<td class="tdc" style="text-align:center;">' . $roworderinfo->materialname . '</td>';
									}
									$html .= '<td class="tdc" style="text-align:center;">' . $roworderinfo->qty . '</td>
																<td class="tdc" style="text-align:right;">' .  number_format($roworderinfo->unitprice, 2) . '</td>
																<td class="tdc" style="text-align:right;">' . number_format($total, 2) . '</td></tr>';
									$sub_total_amount +=  $total;
								}


								$html .= '<tr>
									<td colspan="3" style="text-align:right; padding-right:5px"><b>Sub Total</b></td>
									<td class="tdc" style="text-align:right;">' . number_format($sub_total_amount, 2) . '</td>
								</tr>
                            </tbody>
                        </table>
                    </td>
                </tr>

            </table>
        </body>
        </html>
        ';

		$dompdf->loadHtml($html);
		$dompdf->setPaper('A4', 'portrait');
		$dompdf->render();
		$dompdf->stream("Purchase Order Request - ", ["Attachment" => 0]);
	}


}