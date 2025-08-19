<?php
use Dompdf\Dompdf;
use Dompdf\Options;
class Dispatchnoteinfo extends CI_Model{
    
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

    public function Getcustomerlist(){
        $this->db->select('`idtbl_customer`, `name`');
        $this->db->from('tbl_customer');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }


	public function Getjoblist() {


		$comapnyID=$_SESSION['company_id'];

		$this->db->select('`idtbl_customerinquiry_detail`,`job`, `job_no`');
		$this->db->from('tbl_customerinquiry_detail');
		$this->db->join('tbl_customerinquiry', 'tbl_customerinquiry.idtbl_customerinquiry = tbl_customerinquiry_detail.tbl_customerinquiry_idtbl_customerinquiry');
		$this->db->where('tbl_customerinquiry.status', 1);
		$this->db->where('tbl_customerinquiry.approvestatus', 1);
		$this->db->where('tbl_customerinquiry_detail.company_id', $comapnyID);
		
		// Exclude records where job_finish_status is 1
		$this->db->where('tbl_customerinquiry_detail.job_finish_status !=', 1);
		
		// Include records where (qty - actual_qty) > 0
		$this->db->where('(tbl_customerinquiry_detail.qty - tbl_customerinquiry_detail.actual_qty) >', 0);
		$this->db->order_by('tbl_customerinquiry_detail.idtbl_customerinquiry_detail', 'DESC');
	
		return $respond=$this->db->get();
	}


	public function Getmeasuretype() {
		$this->db->select('`idtbl_mesurements`, `measure_type`');
		$this->db->from('tbl_measurements');
		$this->db->where('status', 1);

		return $respond=$this->db->get();
	}
    public function Getporder() {
		
		$this->db->select('`idtbl_customerinquiry`');
		$this->db->from('tbl_customerinquiry');
		$this->db->join('tbl_customerinquiry_detail', 'tbl_customerinquiry_detail.tbl_customerinquiry_idtbl_customerinquiry = tbl_customerinquiry.idtbl_customerinquiry', 'left');
		$this->db->where('tbl_customerinquiry.status', 1);
		$this->db->where('tbl_customerinquiry.approvestatus', 1);
		$this->db->group_by('tbl_customerinquiry.idtbl_customerinquiry');
		$this->db->having('SUM(tbl_customerinquiry_detail.qty - tbl_customerinquiry_detail.actual_qty) >', 0);
        // $this->db->where('porderconfirm', 0);
		// $this->db->where_in('tbl_order_type_idtbl_order_type', array(3, 4));


		return $respond=$this->db->get();
	}

	// public function Getporder() {
	// 	$this->db->select('tbl_customerinquiry.idtbl_customerinquiry');
	// 	$this->db->from('tbl_customerinquiry');
	// 	$this->db->join('tbl_customerinquiry_detail', 'tbl_customerinquiry.idtbl_customerinquiry = tbl_customerinquiry_detail.tbl_customerinquiry_idtbl_customerinquiry');
	// 	$this->db->where('tbl_customerinquiry.status', 1);
	// 	$this->db->where('tbl_customerinquiry.approvestatus', 1);
	// 	$this->db->where('(tbl_customerinquiry_detail.qty - tbl_customerinquiry_detail.actual_qty) >', 0);
	// 	// Add any other conditions if necessary
	// 	// $this->db->where('tbl_customerinquiry.porderconfirm', 0);
	// 	// $this->db->where_in('tbl_customerinquiry.tbl_order_type_idtbl_order_type', array(3, 4));
	
	// 	return $this->db->get();
	// }


	// public function Getporder() {
	// 	$this->db->select('ci.*');
	// 	$this->db->from('tbl_customerinquiry ci');
	// 	$this->db->join('tbl_customerinquiry_detail cid', 'ci.idtbl_customerinquiry = cid.tbl_customerinquiry_idtbl_customerinquiry');
	// 	$this->db->where('ci.status', 1);
	// 	$this->db->group_by('ci.idtbl_customerinquiry');
	// 	$this->db->having('SUM(cid.qty - cid.actual_qty)', 0);
	
	// 	$query = $this->db->get();
		
	// 	if ($query->num_rows() > 0) {
	// 		return $query->result();
	// 	} else {
	// 		return array(); // No rows found
	// 	}
	// }
	
	// public function Getporder() {
	// 	$this->db->select('tbl_customerinquiry.idtbl_customerinquiry');
	// 	$this->db->from('tbl_customerinquiry');
	// 	$this->db->join('tbl_customerinquiry_detail', 'tbl_customerinquiry.idtbl_customerinquiry = tbl_customerinquiry_detail.tbl_customerinquiry_idtbl_customerinquiry');
	// 	$this->db->where('tbl_customerinquiry.status', 1);
	// 	// $this->db->where('tbl_customerinquiry.confirmstatus', 1);
	// 	// $this->db->where('tbl_customerinquiry.porderconfirm', 0);
	// 	// $this->db->where_in('tbl_customerinquiry.tbl_order_type_idtbl_order_type', array(3, 4));
	// 	$this->db->group_by('tbl_customerinquiry.idtbl_customerinquiry');
	// 	$this->db->having('SUM(tbl_customerinquiry_detail.qty)', 0);
	
	// 	return $this->db->get();
	// }
	

	public function Dispatchnoteinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $tableData=$this->input->post('tableData');
		$date=$this->input->post('date');
		$customerinqury=$this->input->post('customerinqury');
		$ponum=$this->input->post('ponum');
		$customer=$this->input->post('customer');
		$remark=$this->input->post('remark');
		// $itemrequest=$this->input->post('itemrequest');
		$company_id=$this->input->post('company_id');
		$branch_id=$this->input->post('branch_id');
		$jobFinishValue=$this->input->post('jobFinishValue');
        $updatedatetime=date('Y-m-d H:i:s');

		$data=array(
		'date'=> $date,
		'total'=> '0',
		'approvestatus'=> '0',
		'status'=> '1',
		'insertdatetime'=> $updatedatetime,
		'tbl_user_idtbl_user'=> $userID,
		'ponum'=> $ponum,
		'remark'=> $remark,
		'company_id'=> $company_id, 
		'company_branch_id'=> $branch_id, 
		'customer_id'=> $customer,
		'tbl_customerinquiry_idtbl_customerinquiry'=> $customerinqury);

        $this->db->insert('tbl_print_dispatch', $data);

        $dispatchID=$this->db->insert_id();
		// $materialid=0;
		// $machineid=0;

			foreach($tableData as $rowtabledata) {
				$job=$rowtabledata['col_1'];
				$job_no=$rowtabledata['col_2'];
				$comment=$rowtabledata['col_3'];
				$job_id=$rowtabledata['col_7'];
				$unitprice=$rowtabledata['col_9'];
				$disqty=$rowtabledata['col_4'];
				$uom_id=$rowtabledata['col_6'];
				// $total=$rowtabledata['col_6'];
				$inquerydetailsid=$rowtabledata['col_8'];

				// $ordertype==3 ? $materialid=$productid:$machineid=$productid;

				$dataone=array(
					'issue_date'=> $date,
					'qty'=> $disqty,
					'unitprice'=> $unitprice,
					'total'=> '0',
					'comment'=> $comment,
					'job_no'=> $job_no,
					'job_id'=> $job_id,
					'job'=> $job,
					'measure_id'=> $uom_id,
					'status'=> '1',
					'insertdatetime'=> $updatedatetime,
					'tbl_print_dispatch_idtbl_print_dispatch'=> $dispatchID);

				$this->db->insert('tbl_print_dispatchdetail', $dataone);


				$this->db->select('actual_qty');
				$this->db->from('tbl_customerinquiry_detail');
				$this->db->where('idtbl_customerinquiry_detail', $inquerydetailsid);

				$query = $this->db->get();

				$currentQuantity=0;
				if ($query->num_rows() > 0) {
					$row = $query->row();
					$currentQuantity = $row->actual_qty;
				} 
				$newQuantity = $currentQuantity + $disqty;


				$data1=array(
				'actual_qty'=> $newQuantity,
				'job_finish_status'=> $jobFinishValue);

			$this->db->where('idtbl_customerinquiry_detail', $inquerydetailsid);
			$this->db->update('tbl_customerinquiry_detail', $data1);
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


	public function Dispatchnotestatus($x, $y, $z) {
		$this->db->trans_begin();

		$userID=$_SESSION['userid'];
		$recordID=$x;
		$type=$y;
		$inquryid=$z;
		$updatedatetime=date('Y-m-d H:i:s');

		if($type==3) {
			$data=array('status'=> '3',
				'updateuser'=> $userID,
				'updatedatetime'=> $updatedatetime);

			$this->db->where('idtbl_print_dispatch', $recordID);
			$this->db->update('tbl_print_dispatch', $data);

			$current_qty=0;
			$this->db->select('qty');
			$this->db->where('tbl_print_dispatch_idtbl_print_dispatch', $recordID);
			$query1 = $this->db->get('tbl_print_dispatchdetail');
			$result1 = $query1->row();
			if ($result1) {
				$current_qty = $result1->qty;
			}
			
			$this->db->select(' actual_qty');
			$this->db->where('tbl_customerinquiry_idtbl_customerinquiry', $inquryid);
			$query = $this->db->get('tbl_customerinquiry_detail');
			$result = $query->row();
	
			if ($result) {
				$new_actual_qty = $result->actual_qty - $current_qty;

				$dataqty = array(
					'actual_qty' => $new_actual_qty,
					// 'actual_qty' => '0',
					// 'updateuser' => $userID,
					'updatedatetime' => $updatedatetime
				);
			
				$this->db->where('tbl_customerinquiry_idtbl_customerinquiry', $inquryid);
				$this->db->update('tbl_customerinquiry_detail', $dataqty);
			}

	
				// $this->db->trans_complete();

			
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
				redirect('Dispatchnote');
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
				redirect('Dispatchnote');
			}
		
	}
	}
	

	public function Getinquryacccjob() {
		$recordID = $this->input->post('recordID');
		
		$this->db->select('*');
		$this->db->from('tbl_customerinquiry');
		$this->db->join('tbl_customerinquiry_detail', 'tbl_customerinquiry_detail.tbl_customerinquiry_idtbl_customerinquiry = tbl_customerinquiry.idtbl_customerinquiry');
		$this->db->where('tbl_customerinquiry.status', 1);
		$this->db->where('tbl_customerinquiry.approvestatus', 1);
		$this->db->where('tbl_customerinquiry_detail.status', 1);
		$this->db->where('tbl_customerinquiry_detail.job_id', $recordID);
		$this->db->group_by('tbl_customerinquiry.idtbl_customerinquiry');
		$this->db->having('SUM(tbl_customerinquiry_detail.qty - tbl_customerinquiry_detail.actual_qty) >', 0);
		
		$respond = $this->db->get();
		
		if ($respond->num_rows() > 0) {
			echo json_encode($respond->result());
		}
	}
	



	// public function Getdispatchaccjob() {
    //     $recordID = $this->input->post('recordID');
        
    //     $this->db->select('*');
	// 	$this->db->from('tbl_print_dispatchdetail');
    //     $this->db->join('tbl_print_dispatch', 'tbl_print_dispatchdetail.tbl_print_dispatch_idtbl_print_dispatch = tbl_print_dispatch.idtbl_print_dispatch');
    //     $this->db->join('tbl_print_invoicedetail', 'tbl_print_dispatchdetail.tbl_print_dispatch_idtbl_print_dispatch = tbl_print_invoicedetail.dispath_id', 'left');
    //     $this->db->where('tbl_print_dispatch.status', 1);
	// 	$this->db->where('tbl_print_dispatchdetail.status', 1);
    //     $this->db->where('tbl_print_dispatch.approvestatus', 1);
    //     $this->db->where('tbl_print_dispatch.invoice_status', 0);

    //     $this->db->where('(tbl_print_invoicedetail.status = 3 OR tbl_print_invoicedetail.dispath_id IS NULL)');

		
	// 	$this->db->where('tbl_print_dispatchdetail.job_id', $recordID);
        
    //         $respond = $this->db->get();
        
    //         if ($respond->num_rows() > 0) {
    //             echo json_encode($respond->result());
    //         }
    //     }




	public function Getjobsaccoinqury() {
		$recordID = $this->input->post('recordID');
		$branchID = $this->input->post('branchID');
		$companyID = $this->input->post('companyID');
	
		$this->db->select('*');
		$this->db->from('tbl_customerinquiry_detail');
		$this->db->join('tbl_customerinquiry', 'tbl_customerinquiry.idtbl_customerinquiry = tbl_customerinquiry_detail.tbl_customerinquiry_idtbl_customerinquiry');
		$this->db->where('tbl_customerinquiry.status', 1);
		$this->db->where('tbl_customerinquiry.approvestatus', 1);
		$this->db->where('tbl_customerinquiry.tbl_customer_idtbl_customer', $recordID);
		$this->db->where('tbl_customerinquiry.company_id', $companyID);
        $this->db->where('tbl_customerinquiry.company_branch_id', $branchID);
		
		// Exclude records where job_finish_status is 1
		$this->db->where('tbl_customerinquiry_detail.job_finish_status !=', 1);
		
		// Include records where (qty - actual_qty) > 0
		$this->db->where('(tbl_customerinquiry_detail.qty - tbl_customerinquiry_detail.actual_qty) >', 0);
	
		$respond = $this->db->get();
	
		if ($respond->num_rows() > 0) {
			echo json_encode($respond->result());
		} else {
			echo json_encode([]);
		}
	}
	
	
	
	
	public function Getcustomeraccjob() {
		$recordID=$this->input->post('recordID');

		$this->db->select('tbl_customerinquiry.tbl_customer_idtbl_customer');
		$this->db->from('tbl_customerinquiry_detail');
		$this->db->join('tbl_customerinquiry','tbl_customerinquiry.idtbl_customerinquiry = tbl_customerinquiry_detail.tbl_customerinquiry_idtbl_customerinquiry','left');
		$this->db->where('tbl_customerinquiry_detail.status', 1);
		$this->db->where('tbl_customerinquiry_detail.idtbl_customerinquiry_detail', $recordID);

		$respond=$this->db->get();
		if($respond->num_rows()>0) {
			$obj=new stdClass();
			$obj->customer=$respond->row(0)->tbl_customer_idtbl_customer;
			// $obj->actual_qty=$respond->row(0)->actual_qty;
			// $obj->comment=$respond->row(0)->comments;
			// $obj->unitprice=$respond->row(0)->unitprice;
			// $obj->job_no=$respond->row(0)->job_no;
			// $obj->uom=$respond->row(0)->uom_id;
			// $obj->detailsid=$respond->row(0)->idtbl_customerinquiry_detail;
			// $obj->customerinquryid=$respond->row(0)->tbl_customerinquiry_idtbl_customerinquiry;
			// $obj->pono=$respond->row(0)->po_number;
			// $obj->unitprice=$respond->row(0)->unitprice;
			//$obj->batchno=$respond->row(0)->batchno;
		}

		echo json_encode($obj);
		// echo $respond->row(0)->company_id;
	}

	// public function Getbranchaccinquery() {
	// 	$recordID=$this->input->post('recordID');

	// 	$this->db->select('tbl_customerinquiry.company_branch_id');
	// 	$this->db->from('tbl_customerinquiry_detail');
	// 	$this->db->join('tbl_customerinquiry','tbl_customerinquiry.idtbl_customerinquiry = tbl_customerinquiry_detail.tbl_customerinquiry_idtbl_customerinquiry','left');
	// 	$this->db->where('tbl_customerinquiry_detail.status', 1);
	// 	$this->db->where('tbl_customerinquiry_detail.idtbl_customerinquiry_detail', $recordID);

	// 	$respond=$this->db->get();
	// 	if ($respond->num_rows() > 0) {
	// 		echo $respond->row()->company_branch_id;
	// 	} else {
	// 		echo 'No records found';
	// 	}
	// }


    public function Getcustomer() {
		$recordID=$this->input->post('recordID');

		$this->db->select('`tbl_customer_idtbl_customer`');
		$this->db->from('tbl_customerinquiry');
		$this->db->where('status', 1);
		$this->db->where('idtbl_customerinquiry', $recordID);

		$respond=$this->db->get();

		echo $respond->row(0)->tbl_customer_idtbl_customer;
	}

    
    public function Getponumber() {
		$recordID=$this->input->post('recordID');
		// $itemreq_id=$this->input->post('grn_id');

		$this->db->select('`po_number`');
		$this->db->from('tbl_customerinquiry');
		$this->db->where('status', 1);
		// $this->db->where('tbl_print_porder_idtbl_print_porder', $grn_id);
		$this->db->where('idtbl_customerinquiry', $recordID);

		$respond=$this->db->get();

		if($respond->num_rows()>0) {
			$obj=new stdClass();
			 $obj->ponum=$respond->row(0)->po_number;
			// $obj->uom=$respond->row(0)->measure_type_id;
			// $obj->unitprice=$respond->row(0)->unitprice;
			//$obj->batchno=$respond->row(0)->batchno;
		}

		echo json_encode($obj);
	}

	public function Getqtyaccjob() {
		$recordID=$this->input->post('recordID');
		// $inqury_id=$this->input->post('inqury_id');

		$this->db->select('tbl_customerinquiry_detail.*,tbl_customerinquiry.po_number');
		$this->db->from('tbl_customerinquiry_detail');
		$this->db->join('tbl_customerinquiry','tbl_customerinquiry.idtbl_customerinquiry = tbl_customerinquiry_detail.tbl_customerinquiry_idtbl_customerinquiry','left');
		$this->db->where('tbl_customerinquiry_detail.status', 1);
		$this->db->where('tbl_customerinquiry_detail.idtbl_customerinquiry_detail', $recordID);

		$respond=$this->db->get();

		if($respond->num_rows()>0) {
			$obj=new stdClass();
			$obj->qty=$respond->row(0)->qty;
			$obj->actual_qty=$respond->row(0)->actual_qty;
			$obj->comment=$respond->row(0)->comments;
			$obj->unitprice=$respond->row(0)->unitprice;
			$obj->job_no=$respond->row(0)->job_no;
			$obj->uom=$respond->row(0)->uom_id;
			$obj->detailsid=$respond->row(0)->idtbl_customerinquiry_detail;
			$obj->customerinquryid=$respond->row(0)->tbl_customerinquiry_idtbl_customerinquiry;
			$obj->pono=$respond->row(0)->po_number;
			// $obj->unitprice=$respond->row(0)->unitprice;
			//$obj->batchno=$respond->row(0)->batchno;
		}

		echo json_encode($obj);
	}


	public function Dispatchview() {
		$recordID=$this->input->post('recordID');

		$sql="SELECT `u`.*, `ua`.`name`, `ua`.`address_line1` AS `locemail` FROM `tbl_print_dispatch` AS `u` LEFT JOIN `tbl_customer` AS `ua` ON (`ua`.`idtbl_customer` = `u`.`customer_id`)  WHERE `u`.`status`=? AND `u`.`idtbl_print_dispatch`=?";
		$respond=$this->db->query($sql, array(1, $recordID));

		$this->db->select('*');
        $this->db->from('tbl_print_dispatch');
		$this->db->join('tbl_print_dispatchdetail', 'tbl_print_dispatch.idtbl_print_dispatch = tbl_print_dispatchdetail.tbl_print_dispatch_idtbl_print_dispatch', 'left');
        $this->db->join('tbl_customer', 'tbl_print_dispatch.customer_id = tbl_customer.idtbl_customer', 'left');
        $this->db->join('tbl_measurements', 'tbl_print_dispatchdetail.measure_id = tbl_measurements.idtbl_mesurements', 'left');

        $this->db->where('tbl_print_dispatch.idtbl_print_dispatch', $recordID);
		$this->db->where_in('tbl_print_dispatchdetail.status', array(1, 2)); // Adding the condition for status 1 or 2

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
		<th style="background-color: #c3faf6">Job</th>
		<th style="background-color: #c3faf6">Qty</th>
		<th style="background-color: #c3faf6">UOM</th>
		<th style="background-color: #c3faf6" class="text-center">Job No</th>
		<th style="background-color: #c3faf6" class="text-center">Comment</th>
		</thead>
		<tbody>';
        foreach($responddetail->result() as $roworderinfo) {
			
				$html.='<tr>
        <td>'.$roworderinfo->job.'</td>
		<td>'.$roworderinfo->qty.'</td>
		<td>'.$roworderinfo->measure_type.'</td>
		<td class="text-center">'.$roworderinfo->job_no.'</td>
		<td class="text-center">'.$roworderinfo->comment.'</td></tr>';

			

		}

		$html.='</tbody>
        </table></div></div>';

		echo $html;
}

	public function dispatchviewheader() {
		$recordID=$this->input->post('recordID');

		$this->db->select('tbl_print_dispatch.*,tbl_customer.name AS customername,tbl_customer.telephone_no AS customercontact,tbl_customer.address_line1 AS address1,tbl_customer.address_line2 AS address2,tbl_customer.city AS city,tbl_customer.state AS state,
								tbl_company.company AS companyname,tbl_company.address1 As companyaddress,tbl_company.mobile AS companymobile,
                                tbl_company.phone companyphone,tbl_company.email AS companyemail,
                                tbl_company_branch.branch AS branchname');
		$this->db->from('tbl_print_dispatch');
		$this->db->join('tbl_customer', 'tbl_customer.idtbl_customer  = tbl_print_dispatch.customer_id ', 'left');
		$this->db->join('tbl_company', 'tbl_company.idtbl_company = tbl_print_dispatch.company_id', 'left');
		$this->db->join('tbl_company_branch', 'tbl_company_branch.idtbl_company_branch = tbl_print_dispatch.company_branch_id', 'left');
		// $this->db->join('tbl_supplier_contact_details', 'tbl_supplier_contact_details.tbl_supplier_idtbl_supplier   = tbl_supplier.idtbl_supplier', 'left'); 
		$this->db->where('idtbl_print_dispatch', $recordID);
		$this->db->where('tbl_print_dispatch.status', 1);

		$respond=$this->db->get();

		$obj=new stdClass();
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

        $userID=$_SESSION['userid'];
		$recordID=$this->input->post('approvebtn');
        $tableData=$this->input->post('tableData');
		// $porderid=$this->input->post('porderrequestid');
		$updatedatetime=date('Y-m-d H:i:s');

		$data=array('approvestatus'=> '1',
				'updateuser'=> $userID,
				'updatedatetime'=> $updatedatetime);

			$this->db->where('idtbl_print_dispatch', $recordID);
			$this->db->update('tbl_print_dispatch', $data);

            // $data1 = array(
            //     'porderconfirm' => '1',
            //     'updateuser'=> $userID, 
            //     'updatedatetime'=> $updatedatetime
            // );

            // $this->db->where('idtbl_print_porder_req', $porderid);
            // $this->db->update('tbl_print_porder_req', $data1);


        $this->db->trans_complete();

        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            
            $actionObj=new stdClass();
            $actionObj->icon='fas fa-save';
            $actionObj->title='';
            $actionObj->message='Dispatch Note Confirm Successfully';
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

	// public function Issuepdf($x)
	// {

	// 	$recordID = $x;

	// 	$this->db->select('tbl_print_issuedetail.*, tbl_print_issue.ordertype, tbl_order_type.type, tbl_location.location, departments.name, tbl_print_issue.idtbl_print_issue');
	// 	$this->db->from('tbl_print_issuedetail');
	// 	$this->db->join('tbl_print_issue', 'tbl_print_issuedetail.tbl_print_issue_idtbl_print_issue = tbl_print_issue.idtbl_print_issue', 'left');
	// 	$this->db->join('tbl_order_type', 'tbl_print_issue.ordertype = tbl_order_type.idtbl_order_type', 'left');

	// 	$this->db->join('tbl_location', 'tbl_print_issue.location_id = tbl_location.idtbl_location', 'left');
	// 	$this->db->join('departments', 'tbl_print_issue.department_id = departments.id', 'left');

	// 	$this->db->where('tbl_print_issuedetail.tbl_print_issue_idtbl_print_issue', $recordID);
	// 	$this->db->where('tbl_print_issuedetail.status', 1);

	// 	$responddetail = $this->db->get();
	// 	if ($responddetail ->num_rows() > 0) {
    //         $row = $responddetail ->row();
    //         $ordertype = $row->type;
	// 		$location = $row->location;
	// 		$name = $row->name;
	// 		$idtbl_print_issue = $row->idtbl_print_issue;
            
    //     }

	// 	$sub_total_amount = 0;
	// 	$path = 'images/book.jpg';
	// 	$type = pathinfo($path, PATHINFO_EXTENSION);
	// 	$data = file_get_contents($path);
	// 	$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

	// 	$this->load->library('pdf');

	// 	$fontDir = 'fonts/';
	// 	$options = new Options();
	// 	$options->set('fontDir', $fontDir);
	// 	$options->set('isPhpEnabled', true);
	// 	$dompdf = new Dompdf($options);

	// 	$html = '
    //     <!DOCTYPE html>
    //     <html lang="en">
    //     <head>
    //         <meta charset="UTF-8">
    //         <meta name="viewport" content="width=device-width, initial-scale=1.0">
    //         <title>Purchase Order Request</title>
    //         <style>
                
    //             body {
    //                 margin: 5px;
    //                 padding: 5px;
    //                 font-family: Arial, sans-serif;
    //                 width: 100%;
    //             }
    //             p {
    //                 font-size: 14px;
    //                 line-height: 3px;
    //             }
    //             .pheader {
    //                 font-size: 12px;
    //                 line-height: 1.5px;
    //             }
    //             .tablec {
    //                 width: 100%;
    //                 border-collapse: collapse;
    //                 margin-bottom: 20px;
    //             }
    //             .thc, .tdc {
    //                 padding: 5px;
    //                 text-align: left;
    //                 border: 1px solid black;
    //             }
    //             .thc {
    //                 background-color: #f2f2f2;
                   
    //             }
    //             hr {
    //                 border: 1px solid #ddd;
    //             }
    //             .postion {
    //                 position: relative;
    //             }
    //             .pos{
    //                 padding-bottom: -20px; 
    //             }
    //             .hedfont {
    //                 font: 20px comicz;
    //             }
    //         </style>
    //     </head>
    //     <body>

    //         <table border="0" width="100%">

    //             <tr>
    //                 <th width="15%" valign="top"><img src="' . $base64 . '"/></th>
    //                 <td align="center">
    //                     <h3><i>MULTI OFFSET PRINTERS (PVT) LTD</i></h3>
    //                     <p class="pheader"><i>345,NEGOMBO ROAD MUKALANGAMUWA, SEEDUWA</i></p>
    //                     <p class="pheader"><i>Phone : +94-11-2253505, 2253876, 2256615</i></p>
    //                     <p class="pheader"><i>E-Mail : multioffsetprinters@gmail.com</i></p>
    //                     <p class="pheader"><i>Fax : +94-11-2254057</i></p>
    //                 </td>
    //                 <th width="15%"></th>
    //             </tr>

    //             <tr>
    //                 <th colspan="3" height="10px"></th>
    //             </tr>

    //             <tr>
    //                 <td colspan="3">
    //                     <table width="100%" border="0" cellspacing="0">
    //                         <tr>
    //                             <td class="postion"><h3 class="pos">Issue Item Request</h3></td>
    //                             <td></td>
    //                             <td></td>
    //                         </tr>
    //                         <tr>
    //                             <td valign="top">
    //                                 <p><b>Location: </b>' . $location . '</p>
                                    
    //                                 <p><b>Department: </b>' . $name . '</p>
									
    //                                 <p><b>Order Type: </b>' . $ordertype . '</p>
                                    
                                      
    //                             </td>
    //                             <td></td>
    //                             <td align="right" width="30%" valign="top">
    //                                 <p>MO/POR-<b>'.$idtbl_print_issue.'</b></p>
    //                             </td>
    //                         </tr>
                            
    //                     </table>
    //                 </td>
    //             </tr>

    //             <tr>
    //                 <td colspan="3"><hr></td>
    //             </tr>

    //             <tr>
    //                 <td colspan="3">
    //                     <table class="tablec">
    //                         <thead class="thc">
    //                             <tr>
                                    
    //                                 <th class="thc" style="text-align:center;" width="25%">Qty</th>
    //                                 <th class="thc" width="25%" style="text-align:right;">Unit Price</th>
	// 								<th class="thc" width="25%" style="text-align:right;">Total</th>
    //                             </tr>
    //                         </thead>
    //                         <tbody class="tdc">';

    //                         foreach ($responddetail->result() as $roworderinfo) {
	// 							$total = ($roworderinfo->qty * $roworderinfo->unitprice);
	// 							$html .= '
    //                                 <tr>
		                            
    //                                     <td class="tdc" style="text-align:center;">' . $roworderinfo->qty . '</td>
    //                                     <td class="tdc" style="text-align:right;">' .  number_format($roworderinfo->unitprice, 2) . '</td>
	// 									<td class="tdc" style="text-align:right;">' . number_format($total, 2) . '</td></tr>
	// 								</tr>
	// 								';

	// 								$sub_total_amount +=  $total;
	// 	                         }
								
	// 	                          $html .= '<tr>
	// 								<td colspan="2" style="text-align:right; padding-right:5px"><b>Sub Total</b></td>
	// 								<td class="tdc" style="text-align:right;">'.number_format($sub_total_amount, 2) .'</td>
	// 							</tr>
    //                         </tbody>
    //                     </table>
    //                 </td>
    //             </tr>

    //         </table>
    //     </body>
    //     </html>
    //     ';

	// 	// $dompdf = new Dompdf();
	// 	$dompdf->loadHtml($html);
	// 	$dompdf->setPaper('A4', 'portrait');
	// 	$dompdf->render();
	// 	$dompdf->stream("Purchase Order Request - ", ["Attachment" => 0]);
	// }


}
