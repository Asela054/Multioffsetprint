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
        $this->db->select('`idtbl_customer`, `customer`');
        $this->db->from('tbl_customer');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }


	public function Getjoblist() {
		$companyID = $_SESSION['company_id'];
	
		$this->db->select('idtbl_customerinquiry_detail, job, job_no');
		$this->db->from('tbl_customerinquiry_detail');
		$this->db->join('tbl_customerinquiry', 'tbl_customerinquiry.idtbl_customerinquiry = tbl_customerinquiry_detail.tbl_customerinquiry_idtbl_customerinquiry');
		$this->db->where('tbl_customerinquiry.status', 1);
		$this->db->where('tbl_customerinquiry.approvestatus', 1);
		$this->db->where('tbl_customerinquiry_detail.tbl_company_idtbl_company', $companyID);
		$this->db->where('tbl_customerinquiry_detail.job_finish_status', 0);
		$this->db->order_by('tbl_customerinquiry_detail.idtbl_customerinquiry_detail', 'DESC');
	
		return $this->db->get();
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

		return $respond=$this->db->get();
	}
	

	public function Dispatchnoteinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

		$companyID=$_SESSION['company_id'];
		$branchID=$_SESSION['branch_id'];

        $tableData=$this->input->post('tableData');
		$date=$this->input->post('date');
		$customerinqury=$this->input->post('customerinqury');
		$ponum=$this->input->post('ponum');
		$customer=$this->input->post('customer');
		$remark=$this->input->post('remark');
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
		'tbl_company_idtbl_company'=> $companyID, 
		'tbl_company_branch_idtbl_company_branch'=> $branchID, 
		'tbl_customer_idtbl_customer'=> $customer,
		'tbl_customerinquiry_idtbl_customerinquiry'=> $customerinqury);

        $this->db->insert('tbl_print_dispatch', $data);

        $dispatchID=$this->db->insert_id();

			foreach($tableData as $rowtabledata) {
				$job=$rowtabledata['col_1'];
				$job_no=$rowtabledata['col_2'];
				$comment=$rowtabledata['col_3'];
				$job_id=$rowtabledata['col_7'];
				$unitprice=$rowtabledata['col_9'];
				$disqty=$rowtabledata['col_4'];
				$uom_id=$rowtabledata['col_6'];
				$inquerydetailsid=$rowtabledata['col_8'];

				$dataone=array(
					'issue_date'=> $date,
					'qty'=> $disqty,
					'unitprice'=> $unitprice,
					'total'=> '0',
					'comment'=> $comment,
					'job_no'=> $job_no,
					'job_id'=> $job_id,
					'job'=> $job,
					'tbl_measurements_idtbl_measurements'=> $uom_id,
					'status'=> '1',
					'insertdatetime'=> $updatedatetime,
					'tbl_user_idtbl_user'=> $userID,
					'tbl_print_dispatch_idtbl_print_dispatch'=> $dispatchID
				);

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

				// Generate the Dispatch NO
		
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
		$this->db->from('tbl_print_dispatch');
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

		$reqno = 'DPN' . $yearDigit . $countPrefix;

		$datadetail = array(
			'dispatch_no'=> $reqno, 
			'updatedatetime'=> $updatedatetime
		);

		$this->db->where('idtbl_print_dispatch', $dispatchID);
		$this->db->update('tbl_print_dispatch', $datadetail);

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
					'job_finish_status' => '0',
					'updatedatetime' => $updatedatetime
				);
			
				$this->db->where('tbl_customerinquiry_idtbl_customerinquiry', $inquryid);
				$this->db->update('tbl_customerinquiry_detail', $dataqty);
			}

			
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
		$this->db->where('tbl_customerinquiry_detail.job_finish_status', 0);
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

		$this->db->select('tbl_customer.idtbl_customer, tbl_customer.customer');
		$this->db->from('tbl_customerinquiry_detail');
		$this->db->join('tbl_customerinquiry','tbl_customerinquiry.idtbl_customerinquiry = tbl_customerinquiry_detail.tbl_customerinquiry_idtbl_customerinquiry','left');
		$this->db->join('tbl_customer','tbl_customer.idtbl_customer = tbl_customerinquiry.tbl_customer_idtbl_customer','left');
		$this->db->where('tbl_customerinquiry_detail.status', 1);
		$this->db->where('tbl_customerinquiry_detail.idtbl_customerinquiry_detail', $recordID);

		$respond=$this->db->get();
		if($respond->num_rows()>0) {
			$obj=new stdClass();
			$obj->id=$respond->row(0)->idtbl_customer;
			$obj->customer=$respond->row(0)->customer;
		}

		echo json_encode($obj);
	}


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

		$this->db->select('`po_number`');
		$this->db->from('tbl_customerinquiry');
		$this->db->where('status', 1);
		$this->db->where('idtbl_customerinquiry', $recordID);

		$respond=$this->db->get();

		if($respond->num_rows()>0) {
			$obj=new stdClass();
			 $obj->ponum=$respond->row(0)->po_number;
		}

		echo json_encode($obj);
	}

	public function Getqtyaccjob() {
		$recordID=$this->input->post('recordID');

		$this->db->select('tbl_customerinquiry_detail.*,tbl_customerinquiry.po_number,tbl_measurements.idtbl_mesurements,tbl_measurements.measure_type');
		$this->db->from('tbl_customerinquiry_detail');
		$this->db->join('tbl_customerinquiry','tbl_customerinquiry.idtbl_customerinquiry = tbl_customerinquiry_detail.tbl_customerinquiry_idtbl_customerinquiry','left');
		$this->db->join('tbl_measurements','tbl_measurements.idtbl_mesurements = tbl_customerinquiry_detail.uom_id','left');
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
			$obj->uom_id=$respond->row(0)->idtbl_mesurements;
			$obj->uom=$respond->row(0)->measure_type;
			$obj->detailsid=$respond->row(0)->idtbl_customerinquiry_detail;
			$obj->customerinquryid=$respond->row(0)->tbl_customerinquiry_idtbl_customerinquiry;
			$obj->pono=$respond->row(0)->po_number;
		}

		echo json_encode($obj);
	}


	public function Dispatchview() {
		$recordID=$this->input->post('recordID');

		$sql="SELECT `u`.*, `ua`.`customer`, `ua`.`address_line1` AS `locemail` FROM `tbl_print_dispatch` AS `u` LEFT JOIN `tbl_customer` AS `ua` ON (`ua`.`idtbl_customer` = `u`.`tbl_customer_idtbl_customer`)  WHERE `u`.`status`=? AND `u`.`idtbl_print_dispatch`=?";
		$respond=$this->db->query($sql, array(1, $recordID));

		$this->db->select('*');
        $this->db->from('tbl_print_dispatch');
		$this->db->join('tbl_print_dispatchdetail', 'tbl_print_dispatch.idtbl_print_dispatch = tbl_print_dispatchdetail.tbl_print_dispatch_idtbl_print_dispatch', 'left');
        $this->db->join('tbl_customer', 'tbl_print_dispatch.tbl_customer_idtbl_customer = tbl_customer.idtbl_customer', 'left');
        $this->db->join('tbl_measurements', 'tbl_print_dispatchdetail.tbl_measurements_idtbl_measurements = tbl_measurements.idtbl_mesurements', 'left');

        $this->db->where('tbl_print_dispatch.idtbl_print_dispatch', $recordID);
		$this->db->where_in('tbl_print_dispatchdetail.status', array(1, 2));

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

		$this->db->select('tbl_print_dispatch.*,tbl_customer.customer AS customername,tbl_customer.telephone_no AS customercontact,tbl_customer.address_line1 AS address1,tbl_customer.address_line2 AS address2,tbl_customer.city AS city,tbl_customer.state AS state,
								tbl_company.company AS companyname,tbl_company.address1 As companyaddress,tbl_company.mobile AS companymobile,
                                tbl_company.phone companyphone,tbl_company.email AS companyemail,
                                tbl_company_branch.branch AS branchname');
		$this->db->from('tbl_print_dispatch');
		$this->db->join('tbl_customer', 'tbl_customer.idtbl_customer  = tbl_print_dispatch.tbl_customer_idtbl_customer', 'left');
		$this->db->join('tbl_company', 'tbl_company.idtbl_company = tbl_print_dispatch.tbl_company_idtbl_company', 'left');
		$this->db->join('tbl_company_branch', 'tbl_company_branch.idtbl_company_branch = tbl_print_dispatch.tbl_company_branch_idtbl_company_branch', 'left');
		$this->db->where('idtbl_print_dispatch', $recordID);
		$this->db->where('tbl_print_dispatch.status', 1);

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

        $userID=$_SESSION['userid'];
		$recordID=$this->input->post('dispatchid');
		$confirmnot=$this->input->post('confirmnot');
        $tableData=$this->input->post('tableData');
		$updatedatetime=date('Y-m-d H:i:s');

		$data=array(
				'approvestatus'=> $confirmnot,
				'updateuser'=> $userID,
				'updatedatetime'=> $updatedatetime);

			$this->db->where('idtbl_print_dispatch', $recordID);
			$this->db->update('tbl_print_dispatch', $data);

        $this->db->trans_complete();

        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            
            $actionObj=new stdClass();
            $actionObj->icon='fas fa-save';
            $actionObj->title='';
            if($confirmnot==1){$actionObj->message='Record Approved Successfully';}
            else{$actionObj->message='Record Rejected Successfully';}
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
