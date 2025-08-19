<?php
use Dompdf\Dompdf;
use Dompdf\Options;
class DirectDispatchnoteinfo extends CI_Model{
    
    public function Getmeasuretype() {
		$this->db->select('`idtbl_mesurements`, `measure_type`');
		$this->db->from('tbl_measurements');
		$this->db->where('status', 1);

		return $respond=$this->db->get();
	}

	public function Getbatchlist() {
		$recordID = $this->input->post('recordID');

		$this->db->select('tbl_print_stock.idtbl_print_stock, tbl_print_stock.batchno, tbl_print_stock.qty');
		$this->db->from('tbl_print_stock');
		$this->db->where('tbl_print_stock.status', 1);
		$this->db->where('tbl_print_stock.tbl_print_material_info_idtbl_print_material_info', $recordID);
		
		$response = $this->db->get();
		
		if ($response->num_rows() > 0) {
			$batches = $response->result();
			$result = array();
			
			foreach ($batches as $batch) {
				$result[] = [
					'id' => $batch->idtbl_print_stock,
					'batchno' => $batch->batchno,
					'qty' => $batch->qty,
				];
			}
			
			echo json_encode($result);
		} else {
			echo json_encode([]);
		}
	}

	public function DirectDispatchnoteinsertupdate(){
			$this->db->trans_begin();

			$userID=$_SESSION['userid'];

			$companyID=$_SESSION['company_id'];
			$branchID=$_SESSION['branch_id'];

			$tableData=$this->input->post('tableData');
			$date=$this->input->post('date');
			$customer=$this->input->post('customer');
			$remark=$this->input->post('remark');
			$updatedatetime=date('Y-m-d H:i:s');

			$data=array(
			'date'=> $date,
			'remark'=> $remark,
			'approvestatus'=> '0',
			'invoice_status'=> '0',
			'status'=> '1',
			'check_by'=> '0',
			'insertdatetime'=> $updatedatetime,
			'tbl_user_idtbl_user'=> $userID,
			'tbl_customer_idtbl_customer'=> $customer,
			'tbl_company_idtbl_company'=> $companyID, 
			'tbl_company_branch_idtbl_company_branch'=> $branchID
		);

			$this->db->insert('tbl_direct_dispatch', $data);

			$directdispatchID=$this->db->insert_id();

				foreach($tableData as $rowtabledata) {
					$material=$rowtabledata['col_2'];
					$comment=$rowtabledata['col_3'];
					$qty=$rowtabledata['col_4'];
					$uom_id=$rowtabledata['col_6'];
					$batchno=$rowtabledata['col_7'];

					$dataone=array(
						'issue_date'=> $date,
						'qty'=> $qty,
						'batchno'=> $batchno,
						'comment'=> $comment,
						'status'=> '1',
						'insertdatetime'=> $updatedatetime,
						'tbl_user_idtbl_user'=> $userID,
						'tbl_measurements_idtbl_mesurements'=> $uom_id,
						'tbl_print_material_info_idtbl_print_material_info'=> $material,
						'tbl_direct_dispatch_idtbl_direct_dispatch'=> $directdispatchID
					);

					$this->db->insert('tbl_direct_dispatchdetail', $dataone);
				}

			
				$currentYear = date("Y", strtotime($date));
				$currentMonth = date("m", strtotime($date));
			
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

				$this->db->select('dispatch_no');
				$this->db->from('tbl_direct_dispatch');
				$this->db->where('tbl_company_idtbl_company', $companyID);
				$this->db->where("DATE(insertdatetime) >=", $fromyear);
				$this->db->where("DATE(insertdatetime) <=", $toyear);
				$this->db->order_by('dispatch_no', 'DESC');
				$this->db->limit(1);
				$respond = $this->db->get();
				
				if ($respond->num_rows() > 0) {
					$last_dispatch_no = $respond->row()->dispatch_no;
					$dispatch_number = intval(substr($last_dispatch_no, -4));
					$count = $dispatch_number;
				} else {
					$count = 0;
				}

				$count++; 
				$countPrefix = sprintf('%04d', $count);

				$yearDigit = substr(date("Y", strtotime($fromyear)), -2);

				$reqno = 'FTDPN' . $yearDigit . $countPrefix;

				$datadetail = array(
					'dispatch_no'=> $reqno, 
					'updatedatetime'=> $updatedatetime
				);

			$this->db->where('idtbl_direct_dispatch', $directdispatchID);
			$this->db->update('tbl_direct_dispatch', $datadetail);

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


	public function DirectDispatchnotestatus($x, $y) {
			$this->db->trans_begin();

			$userID=$_SESSION['userid'];
			$recordID=$x;
			$type=$y;
			$updatedatetime=date('Y-m-d H:i:s');

			if($type==3) {
				$data=array('status'=> '3',
					'updateuser'=> $userID,
					'updatedatetime'=> $updatedatetime);

				$this->db->where('idtbl_direct_dispatch', $recordID);
				$this->db->update('tbl_direct_dispatch', $data);
				
				$this->db->trans_complete();

				if ($this->db->trans_status()===TRUE) {
					$this->db->trans_commit();

					$actionObj=new stdClass();
					$actionObj->icon='fas fa-trash-alt';
					$actionObj->title='';
					$actionObj->message='Record Delete Successfully';
					$actionObj->url='';
					$actionObj->target='_blank';
					$actionObj->type='danger';

					$actionJSON=json_encode($actionObj);

					$this->session->set_flashdata('msg', $actionJSON);
					redirect('DirectDispatchnote');
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
					redirect('DirectDispatchnote');
				}
			
		}
	}

	public function DirectDispatchview() {
			$recordID=$this->input->post('recordID');

			$sql="SELECT `u`.*, `ua`.`customer`, `ua`.`address_line1` AS `locemail` FROM `tbl_direct_dispatch` AS `u` LEFT JOIN `tbl_customer` AS `ua` ON (`ua`.`idtbl_customer` = `u`.`tbl_customer_idtbl_customer`)  WHERE `u`.`status`=? AND `u`.`idtbl_direct_dispatch`=?";
			$respond=$this->db->query($sql, array(1, $recordID));

			$this->db->select('dd.*, ddd.*, pmi.materialname, m.measure_type');
			$this->db->from('tbl_direct_dispatch dd');
			$this->db->join('tbl_direct_dispatchdetail ddd', 'dd.idtbl_direct_dispatch = ddd.tbl_direct_dispatch_idtbl_direct_dispatch', 'left');
			$this->db->join('tbl_print_material_info pmi', 'ddd.tbl_print_material_info_idtbl_print_material_info = pmi.idtbl_print_material_info', 'left');
			$this->db->join('tbl_customer c', 'dd.tbl_customer_idtbl_customer = c.idtbl_customer', 'left');
			$this->db->join('tbl_measurements m', 'ddd.tbl_measurements_idtbl_mesurements = m.idtbl_mesurements', 'left');
			$this->db->where('dd.idtbl_direct_dispatch', $recordID);
			$this->db->where_in('ddd.status', array(1, 2));

			$responddetail=$this->db->get();

			$html='';

			$html.='
			<div class="row">
			</div>
			<div class="row">
			<div class="col-12">
			<hr>
			<table class="table table-striped table-bordered table-sm">
			<thead>
			<th style="background-color: #c3faf6">Material</th>
			<th style="background-color: #c3faf6">Qty</th>
			<th style="background-color: #c3faf6">UOM</th>
			<th style="background-color: #c3faf6" class="text-center">Comment</th>
			</thead>
			<tbody>';
			foreach($responddetail->result() as $roworderinfo) {
				
					$html.='<tr>
			<td>'.$roworderinfo->materialname.'</td>
			<td>'.$roworderinfo->qty.'</td>
			<td>'.$roworderinfo->measure_type.'</td>
			<td class="text-center">'.$roworderinfo->comment.'</td></tr>';

				

			}

			$html.='</tbody>
			</table></div></div>';

			echo $html;
	}

	public function Directdispatchviewheader() {
		$recordID=$this->input->post('recordID');

		$this->db->select('tbl_direct_dispatch.*,tbl_customer.customer AS customername,tbl_customer.telephone_no AS customercontact,tbl_customer.address_line1 AS address1,tbl_customer.address_line2 AS address2,tbl_customer.city AS city,tbl_customer.state AS state,
								tbl_company.company AS companyname,tbl_company.address1 As companyaddress,tbl_company.mobile AS companymobile,
                                tbl_company.phone companyphone,tbl_company.email AS companyemail,
                                tbl_company_branch.branch AS branchname');
		$this->db->from('tbl_direct_dispatch');
		$this->db->join('tbl_customer', 'tbl_customer.idtbl_customer  = tbl_direct_dispatch.tbl_customer_idtbl_customer', 'left');
		$this->db->join('tbl_company', 'tbl_company.idtbl_company = tbl_direct_dispatch.tbl_company_idtbl_company', 'left');
		$this->db->join('tbl_company_branch', 'tbl_company_branch.idtbl_company_branch = tbl_direct_dispatch.tbl_company_branch_idtbl_company_branch', 'left');
		$this->db->where('idtbl_direct_dispatch', $recordID);
		$this->db->where('tbl_direct_dispatch.status', 1);

		$respond=$this->db->get();

		$obj=new stdClass();
		$obj->dispatch_no=$respond->row(0)->dispatch_no;
		$obj->date=$respond->row(0)->date;
		$obj->customername=$respond->row(0)->customername;
		$obj->customercontact=$respond->row(0)->customercontact;
		$obj->address1=$respond->row(0)->address1;
		$obj->address2=$respond->row(0)->address2;
		$obj->city=$respond->row(0)->city;
		$obj->state=$respond->row(0)->state;
		$obj->companyname=$respond->row(0)->companyname;
		$obj->companyaddress=$respond->row(0)->companyaddress;
		$obj->companymobile=$respond->row(0)->companymobile;
		$obj->companyphone=$respond->row(0)->companyphone;
		$obj->companyemail=$respond->row(0)->companyemail;
		$obj->branchname=$respond->row(0)->branchname;

		echo json_encode($obj);
	}


	public function Approdispatch(){
		$this->db->trans_begin();

		$userID = $_SESSION['userid'];
		$recordID = $this->input->post('dispatchid');
		$inqId = $this->input->post('inqid');
		$confirmnot = $this->input->post('confirmnot');
		$tableData = $this->input->post('tableData');
		$updatedatetime = date('Y-m-d H:i:s');

		$data = array(
			'approvestatus' => $confirmnot,
			'updateuser' => $userID,
			'updatedatetime' => $updatedatetime
		);

		$this->db->where('idtbl_direct_dispatch', $recordID);
		$this->db->update('tbl_direct_dispatch', $data);

		if ($confirmnot == 1) {
			$this->db->select('qty, tbl_print_material_info_idtbl_print_material_info, batchno');
			$this->db->where('tbl_direct_dispatch_idtbl_direct_dispatch', $recordID);
			$query = $this->db->get('tbl_direct_dispatchdetail');
			$dispatchDetails = $query->result();
			
			foreach ($dispatchDetails as $detail) {
				$current_qty = $detail->qty;
				$material = $detail->tbl_print_material_info_idtbl_print_material_info;
				$batchno = $detail->batchno;
				
				$this->db->select('qty');
				$this->db->where('tbl_print_material_info_idtbl_print_material_info', $material);
				$this->db->where('batchno', $batchno);
				$stockQuery = $this->db->get('tbl_print_stock');
				$stock = $stockQuery->row();

				if ($stock) {
					$new_actual_qty = $stock->qty - $current_qty;

					$dataqty = array(
						'qty' => $new_actual_qty,
						'updatedatetime' => $updatedatetime
					);
				
					$this->db->where('tbl_print_material_info_idtbl_print_material_info', $material);
					$this->db->where('batchno', $batchno);
					$this->db->update('tbl_print_stock', $dataqty);
				}
			}
		}

		$this->db->trans_complete();

		if ($this->db->trans_status() === TRUE) {
			$this->db->trans_commit();
			
			$actionObj = new stdClass();
			$actionObj->icon = 'fas fa-save';
			$actionObj->title = '';
			$actionObj->message = ($confirmnot == 1) ? 'Record Approved Successfully' : 'Record Rejected Successfully';
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
	
	public function Dispatchnotecheckstatus() {
		$this->db->trans_begin();

        $recordID=$this->input->post('requestid');
		$confirmnot=$this->input->post('confirmnot');
		$userID=$_SESSION['userid'];
		$updatedatetime=date('Y-m-d H:i:s');

			$data=array(
				'check_by'=> $userID);

			$this->db->where('idtbl_direct_dispatch', $recordID);
			$this->db->update('tbl_direct_dispatch', $data);


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
