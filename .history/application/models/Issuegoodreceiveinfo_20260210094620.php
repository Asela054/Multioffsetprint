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
		$this->db->where('deleted', 0);

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
        $this->db->select('`idtbl_material_group`, `group`');
        $this->db->from('tbl_material_group');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Getporder() {
		$this->db->select('`idtbl_grn_req`');
		$this->db->from('tbl_grn_req');
		$this->db->where('status', 1);
		$this->db->where('confirmstatus', 1);
		$this->db->where('issuestatus', 0);

		return $respond=$this->db->get();
	}
	public function Getmeasuretype() {
		$this->db->select('`idtbl_mesurements`, `measure_type`');
		$this->db->from('tbl_measurements');
		$this->db->where('status', 1);

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


			foreach($tableData as $rowtabledata) {
				$uomId=$rowtabledata['col_3'];
				$comment=$rowtabledata['col_4'];
				$unitprice=$rowtabledata['col_5'];
				$qty=$rowtabledata['col_6'];
				$productid=$rowtabledata['col_8'];
				$total=$rowtabledata['col_9'];
				$stockid=$rowtabledata['col_10'];

				$dataone=array(
					'issue_date'=> $issuedate,
					'qty'=> $qty,
					'unitprice'=> $unitprice,
					'total'=> $total,
					'comment'=> $comment,
					'measure_type_id'=> $uomId,
					'status'=> '1',
					'insertdatetime'=> $updatedatetime,
					'tbl_print_issue_idtbl_print_issue'=> $issueID,
					'tbl_print_material_info_idtbl_print_material_info'=> $productid,
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

		$this->db->select('`tbl_material_group_idtbl_material_group`');
		$this->db->from('tbl_grn_req');
		$this->db->where('status', 1);
		$this->db->where('idtbl_grn_req', $recordID);

		$respond=$this->db->get();

		echo $respond->row(0)->tbl_material_group_idtbl_material_group;
	}

    //Get Material////
    public function Getmaterialitem() {
		$recordID=$this->input->post('recordID');

		$sql="SELECT `tbl_print_material_info`.`idtbl_print_material_info`, `tbl_print_material_info`.`materialinfocode`, `tbl_print_material_info`.`materialname` FROM `tbl_grn_req_detail` LEFT JOIN `tbl_print_material_info` ON `tbl_print_material_info`.`idtbl_print_material_info`=`tbl_grn_req_detail`.`tbl_material_id` WHERE `tbl_grn_req_detail`.`tbl_grn_req_idtbl_grn_req`=?";
		$respond=$this->db->query($sql, array($recordID));

		echo json_encode($respond->result());
	}

	public function Getproductinfoaccoproduct() {
		$recordID = $this->input->post('recordID');
	
		$this->db->select('idtbl_print_stock, batchno, qty, unitprice');
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

	public function Getunitpricefrombatch() {

		$recordID = $this->input->post('recordID');
		$batchno  = $this->input->post('batchno');

		$obj = new stdClass();
		$obj->unitprice = 0;

		$this->db->select('unitprice');
		$this->db->from('tbl_print_stock');
		$this->db->where('status', 1);
		$this->db->where_in('batchno', $batchno);
		$this->db->where('tbl_print_material_info_idtbl_print_material_info', $recordID);

		$respond = $this->db->get();

		if ($respond->num_rows() > 0) {
			$obj->unitprice = $respond->row()->unitprice;
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
	
		$this->db->select('tbl_print_issuedetail.*, tbl_print_material_info.materialname, tbl_print_material_info.materialinfocode, tbl_measurements.measure_type');
		$this->db->from('tbl_print_issuedetail');
		$this->db->join('tbl_print_material_info', 'tbl_print_issuedetail.tbl_print_material_info_idtbl_print_material_info = tbl_print_material_info.idtbl_print_material_info', 'left');
		$this->db->join('tbl_measurements', 'tbl_measurements.idtbl_mesurements = tbl_print_issuedetail.measure_type_id', 'left');
		$this->db->where('tbl_print_issuedetail.tbl_print_issue_idtbl_print_issue', $recordID);
		$this->db->where('tbl_print_issuedetail.status', 1);
	
		$responddetail = $this->db->get();
	
		$html = '';
		
		foreach($responddetail->result() as $roworderinfo) {
			$total = number_format(($roworderinfo->qty * $roworderinfo->unitprice), 2);
			$html .= '<tr>
							<td>'.$roworderinfo->materialname. '-' .$roworderinfo->materialinfocode. '</td>
							<td class="text-left">'.$roworderinfo->measure_type.'</td>
							<td class="text-center">'.$roworderinfo->qty.'</td>
							<td class="text-center d-none">'.$roworderinfo->tbl_print_material_info_idtbl_print_material_info.'</td>
							<td class="text-center d-none">'.$roworderinfo->stock_id.'</td>
							<td class="accountlist"></td>
							<td class="text-center d-none"><input type="text" class="row_account_id" name="row_account_id[]"></td>					
							<td class="text-center d-none"><input type="text" class="row_account_type" name="row_account_type[]"></td>
						</tr>';
		}
	
		echo $html;
	}

	public function Approveissue()
	{
		$userID = $_SESSION['userid'];
		$company = $_SESSION['company_id'];
		$branch = $_SESSION['branch_id'];

		$tableData = $this->input->post('tableData');
		$viewissueid = $this->input->post('viewissueid');
		$updatedatetime = date('Y-m-d H:i:s');

		$obj = new stdClass();
		$actionObj = new stdClass();

		try {
			$this->db->trans_begin();

			foreach ($tableData as $rowtabledata) {

				$stockid = $rowtabledata['stockid'];
				$account_id = $rowtabledata['account_id'];
				$account_type = $rowtabledata['account_type'];

				$accountData = array();

				if ($account_type == 1) {
					$accountData['tbl_account_idtbl_account'] = $account_id;
					$accountData['tbl_account_detail_idtbl_account_detail'] = null;
				} elseif ($account_type == 2) {
					$accountData['tbl_account_detail_idtbl_account_detail'] = $account_id;
					$accountData['tbl_account_idtbl_account'] = null;
				}

				$data = array_merge(array(
					'updateuser' => $userID,
					'updatedatetime' => $updatedatetime
				), $accountData);

				$this->db->where('stock_id', $stockid);
				$this->db->where('tbl_print_issue_idtbl_print_issue', $viewissueid);
				$this->db->update('tbl_print_issuedetail', $data);
			}

			$this->db->trans_commit();

			$actionObj->icon = 'fas fa-check-circle';
			$actionObj->title = '';
			$actionObj->message = 'Accounts Updated Successfully';
			$actionObj->type = 'success';

			$obj->status = 1;
			$obj->action = json_encode($actionObj);

		} catch (Exception $e) {

			$this->db->trans_rollback();

			error_log("Issue Approve Error: " . $e->getMessage());

			$actionObj->icon = 'fas fa-exclamation-triangle';
			$actionObj->title = '';
			$actionObj->message = 'Operation Failed';
			$actionObj->type = 'danger';

			$obj->status = 0;
			$obj->action = json_encode($actionObj);
		}

		echo json_encode($obj);
	}

	public function IssueNoteView()
		{
			$recordID = $this->input->post('recordID');

			// ================= HEADER =================
			$this->db->select('
				i.idtbl_print_issue,
				i.issuedate,
				i.total,
				l.location,
				e.emp_fullname
			');
			$this->db->from('tbl_print_issue i');
			$this->db->join('tbl_location l', 'l.idtbl_location = i.location_id', 'left');
			$this->db->join('employees e', 'e.id = i.employee_id', 'left');
			$this->db->where('i.idtbl_print_issue', $recordID);
			$this->db->where('i.status', 1);
			$header = $this->db->get();

			// ================= DETAILS =================
			$this->db->select('
				d.qty,
				d.unitprice,
				d.total,
				d.comment,
				m.materialname,
				m.materialinfocode,
				u.measure_type
			');
			$this->db->from('tbl_print_issuedetail d');
			$this->db->join('tbl_print_material_info m',
				'm.idtbl_print_material_info = d.tbl_print_material_info_idtbl_print_material_info',
				'left'
			);
			$this->db->join('tbl_measurements u',
				'u.idtbl_mesurements = d.measure_type_id',
				'left'
			);
			$this->db->where('d.tbl_print_issue_idtbl_print_issue', $recordID);
			$this->db->where('d.status', 1);
			$details = $this->db->get();

			// ================= HTML =================
			$html = '
			<div class="row mb-2">
				<div class="col-6 small">
					<strong>Issue Date:</strong> ' . $header->row()->issuedate . '<br>
					<strong>Location:</strong> ' . $header->row()->location . '
				</div>
				<div class="col-6 small text-right">
					<strong>Employee:</strong> ' . $header->row()->emp_fullname . '<br>
					<strong>Issue No:</strong> ' . $header->row()->idtbl_print_issue . '
				</div>
			</div>

			<hr class="border-dark">

			<table class="table table-bordered table-sm">
				<thead class="thead-light">
					<tr>
						<th>Material</th>
						<th class="text-center">Qty</th>
						<th class="d-none">Stock ID</th>
						<th class="text-center">UOM</th>
						<th class="text-right">Unit Price</th>
						<th class="text-right">Total</th>
						<th>Remark</th>
					</tr>
				</thead>
				<tbody>';

			foreach ($details->result() as $row) {

				$material = $row->materialname;
				if (!empty($row->materialinfocode)) {
					$material .= ' / ' . $row->materialinfocode;
				}

				$html .= '
				<tr>
					<td>' . $material . '</td>
					<td class="text-center">' . $row->qty . '</td>
					<td class="text-center">' . $row->qty . '</td>
					<td class="text-center">' . $row->measure_type . '</td>
					<td class="text-right">' . number_format($row->unitprice, 2) . '</td>
					<td class="text-right">' . number_format($row->total, 2) . '</td>
					<td>' . $row->comment . '</td>
				</tr>';
			}

			$html .= '
				</tbody>
			</table>

			<table width="100%" class="mt-3">
				<tr>
					<td width="80%" class="text-right font-weight-bold">Total</td>
					<td width="20%" class="text-right font-weight-bold">
						Rs. ' . number_format($header->row()->total, 2) . '
					</td>
				</tr>
			</table>';

			$response = [
				'html' => $html
			];

			$this->output
				->set_content_type('application/json')
				->set_output(json_encode($response));
		}

	public function Approvestatus() {
		$this->db->trans_begin();
		$userID = $_SESSION['userid'];
		$updatedatetime = date('Y-m-d H:i:s');
		$approveID = $this->input->post('grnid');
		$grnreqid = $this->input->post('req_id');
		$confirmnot = $this->input->post('confirmnot');
		$tableData = $this->input->post('tableData');

		$data=array(
			'approvestatus '=> $confirmnot,
			'updateuser'=> $userID,
			'updatedatetime'=> $updatedatetime);

		$this->db->where('idtbl_print_issue', $approveID);
		$this->db->update('tbl_print_issue', $data);

		$datareq=array(
			'issuestatus '=> '1',
			'updateuser'=> $userID,
			'updatedatetime'=> $updatedatetime);

		$this->db->where('idtbl_grn_req', $grnreqid);
		$this->db->update('tbl_grn_req', $datareq);

		if ($confirmnot == 1) {
			foreach($tableData as $rowtabledata) {
					$stockid = $rowtabledata['stockid'];
					$issueqty = $rowtabledata['qty'];

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

				

		}else{
				$data=array(
					'approvestatus '=> $confirmnot,
					'updateuser'=> $userID,
					'updatedatetime'=> $updatedatetime);

				$this->db->where('idtbl_print_issue', $viewissueid);
				$this->db->update('tbl_print_issue', $data);
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

	public function Issuepdf($x)
	{

		$recordID = $x;

		$this->db->select('tbl_print_issuedetail.*, tbl_print_issue.ordertype, tbl_order_type.type, tbl_location.location, employees.emp_id, employees.emp_name_with_initial, tbl_print_issue.idtbl_print_issue, tbl_print_material_info.materialname, tbl_measurements.measure_type');
		$this->db->from('tbl_print_issuedetail');
		$this->db->join('tbl_print_issue', 'tbl_print_issuedetail.tbl_print_issue_idtbl_print_issue = tbl_print_issue.idtbl_print_issue', 'left');
		$this->db->join('tbl_order_type', 'tbl_print_issue.ordertype = tbl_order_type.idtbl_order_type', 'left');
		$this->db->join('tbl_print_material_info', 'tbl_print_issuedetail.tbl_print_material_info_idtbl_print_material_info = tbl_print_material_info.idtbl_print_material_info', 'left');
        $this->db->join('tbl_measurements', 'tbl_measurements.idtbl_mesurements = tbl_print_issuedetail.measure_type_id', 'left');
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
									<th class="thc" style="text-align:center;" width="25%">UOM</th>
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
									$html .= '<td class="tdc" style="text-align:center;">' . $roworderinfo->measure_type . '</td>';
									$html .= '<td class="tdc" style="text-align:center;">' . $roworderinfo->qty . '</td>
																<td class="tdc" style="text-align:right;">' .  number_format($roworderinfo->unitprice, 2) . '</td>
																<td class="tdc" style="text-align:right;">' . number_format($total, 2) . '</td></tr>';
									$sub_total_amount +=  $total;
								}


								$html .= '<tr>
									<td colspan="4" style="text-align:right; padding-right:5px"><b>Sub Total</b></td>
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