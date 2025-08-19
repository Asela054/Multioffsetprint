<?php
class Customerinquiryinfo extends CI_Model{
    public function Getjobs(){
        $this->db->select('`idtbl_customer_job_details`, `job_name`');
        $this->db->from('tbl_customer_job_details');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Getjobuom() {
		$recordID=$this->input->post('recordID');
		$jobID=$this->input->post('jobID');

		$this->db->select('tbl_measurements.idtbl_mesurements, tbl_measurements.measure_type, tbl_customer_job_details.unitprice');
		$this->db->from('tbl_customer_job_details');
        $this->db->join('tbl_measurements', 'tbl_measurements.idtbl_mesurements = tbl_customer_job_details.tbl_measurements_idtbl_measurements');
		$this->db->where('tbl_customer_job_details.status', 1);
		$this->db->where('tbl_customer_job_details.idtbl_customer_job_details', $recordID);
		$respond=$this->db->get();

        $obj=new stdClass();
		if($respond->num_rows()>0) {
			$obj->measure_type_id=$respond->row(0)->idtbl_mesurements;
            $obj->measure_type=$respond->row(0)->measure_type;
			$obj->unitprice=$respond->row(0)->unitprice;
		}

		echo json_encode($obj);
	}
    public function Getmeasuretype() {
		$this->db->select('`idtbl_mesurements`, `measure_type`');
		$this->db->from('tbl_measurements');
		$this->db->where('status', 1);

		return $respond=$this->db->get();
	}
    public function Customerinquiryinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $company_id=$_SESSION['company_id'];
		$branch_id=$_SESSION['branch_id'];

        $date=$this->input->post('date');
		$ponumber=$this->input->post('ponumber');
		$customer=$this->input->post('customer');
		$jobID = $this->input->post('jobID');
		$job = $this->input->post('job');
		$qty = $this->input->post('qty');
		$uom = $this->input->post('uom');
		$uomID = $this->input->post('uomID');
		$unitprice = $this->input->post('unitprice');
		$comment = $this->input->post('comment');
		
        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

        $insertdatetime=date('Y-m-d H:i:s');

        if($recordOption==1){
            $data = array(
                'date'=> $date, 
				'po_number'=> $ponumber,
                'status'=> '1', 
                'insertdatetime'=> $insertdatetime, 
				'tbl_customer_idtbl_customer'=> $customer, 
                'tbl_company_idtbl_company'=> $company_id, 
			    'tbl_company_branch_idtbl_company_branch'=> $branch_id,  
                'tbl_user_idtbl_user'=> $userID,
            );

            $this->db->insert('tbl_customerinquiry', $data);
			$insertId = $this->db->insert_id();

            $data = array(
                'job'=> $job, 
                'job_id'=> $jobID, 
                'qty'=> $qty,
                'uom'=> $uom, 
                'uom_id'=> $uomID, 
                'unitprice'=> $unitprice,
                'comments'=> $comment, 
                'status'=> '1', 
                'insertdatetime'=> $insertdatetime, 
                'tbl_customerinquiry_idtbl_customerinquiry'=> $insertId, 
                'tbl_company_idtbl_company'=> $company_id, 
                'tbl_user_idtbl_user'=> $userID
            );
            $this->db->insert('tbl_customerinquiry_detail', $data);

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
        else{
            $this->db->select('`approvestatus`');
            $this->db->from('tbl_customerinquiry');
            $this->db->where('idtbl_customerinquiry', $recordID);

            $respond=$this->db->get();

            if($respond->row(0)->approvestatus==0){
                $data = array(
                    'date'=> $date, 
                    'po_number'=> $ponumber, 
                    'tbl_company_idtbl_company'=> $company_id, 
                    'tbl_company_branch_idtbl_company_branch'=> $branch_id,  
                    'tbl_customer_idtbl_customer'=> $customer, 
                    'status'=> '1', 
                    'updatedatetime'=> $insertdatetime, 
                    'tbl_user_idtbl_user'=> $userID,
                );

                $this->db->where('idtbl_customerinquiry', $recordID);
                $this->db->update('tbl_customerinquiry', $data);

                $data = array(
                    'job'=> $job, 
                    'job_id'=> $jobID, 
                    'qty'=> $qty,
                    'uom'=> $uom, 
                    'uom_id'=> $uomID, 
                    'unitprice'=> $unitprice,
                    'comments'=> $comment, 
                    'status'=> '1', 
                    'updatedatetime'=> $insertdatetime, 
                    'tbl_company_idtbl_company'=> $company_id, 
                    'tbl_user_idtbl_user'=> $userID
                );
                $this->db->where('tbl_customerinquiry_idtbl_customerinquiry', $recordID);
                $this->db->update('tbl_customerinquiry_detail', $data);
            }
            else{
                $data = array(
                    'po_number'=> $ponumber, 
                    'updatedatetime'=> $insertdatetime, 
                    'tbl_user_idtbl_user'=> $userID,
                );

                $this->db->where('idtbl_customerinquiry', $recordID);
                $this->db->update('tbl_customerinquiry', $data);

                $data = array( 
                    'qty'=> $qty,
                    'updatedatetime'=> $insertdatetime, 
                    'tbl_user_idtbl_user'=> $userID
                );
                $this->db->where('tbl_customerinquiry_idtbl_customerinquiry', $recordID);
                $this->db->update('tbl_customerinquiry_detail', $data);
            }

            $this->db->trans_complete();

			if ($this->db->trans_status() === TRUE) {
				$this->db->trans_commit();
				
				$actionObj=new stdClass();
				$actionObj->icon='fas fa-save';
				$actionObj->title='';
				$actionObj->message='Record Update Successfully';
				$actionObj->url='';
				$actionObj->target='_blank';
				$actionObj->type='primary';
	
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
    public function Customerinquiryedit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('tbl_customerinquiry.*, tbl_customer.customer');
        $this->db->from('tbl_customerinquiry');
        $this->db->join('tbl_customer', 'tbl_customer.idtbl_customer = tbl_customerinquiry.tbl_customer_idtbl_customer', 'left');
        $this->db->where('idtbl_customerinquiry', $recordID);
        $this->db->where('tbl_customerinquiry.status', 1);

        $respond=$this->db->get();

        $this->db->select('tbl_customerinquiry_detail.*, tbl_customer_job_details.job_name');
        $this->db->from('tbl_customerinquiry_detail');
        $this->db->join('tbl_customer_job_details', 'tbl_customer_job_details.idtbl_customer_job_details = tbl_customerinquiry_detail.job_id', 'left');
        $this->db->where('tbl_customerinquiry_detail.tbl_customerinquiry_idtbl_customerinquiry', $recordID);
        $this->db->where('tbl_customerinquiry_detail.status', 1);

        $responddetail=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_customerinquiry;
        $obj->date=$respond->row(0)->date;
		$obj->po_number=$respond->row(0)->po_number;
		$obj->customerid=$respond->row(0)->tbl_customer_idtbl_customer;
		$obj->customer=$respond->row(0)->customer;

		$obj->job_id=$responddetail->row(0)->job_id;
		$obj->job_name=$responddetail->row(0)->job_name;
		$obj->qty=$responddetail->row(0)->qty;
		$obj->uom_id=$responddetail->row(0)->uom_id;
		$obj->uom=$responddetail->row(0)->uom;
		$obj->unitprice=$responddetail->row(0)->unitprice;
		$obj->comments=$responddetail->row(0)->comments;

        echo json_encode($obj);
    }
    public function Customerinquiryviewjoblist(){
        $recordID=$this->input->post('recordID');

        $this->db->select('date, po_number, company, branch, customer');
		$this->db->from('tbl_customerinquiry');
        $this->db->join('tbl_company', 'tbl_company.idtbl_company = tbl_customerinquiry.tbl_company_idtbl_company');
        $this->db->join('tbl_company_branch', 'tbl_company_branch.idtbl_company_branch = tbl_customerinquiry.tbl_company_branch_idtbl_company_branch');
        $this->db->join('tbl_customer', 'tbl_customer.idtbl_customer = tbl_customerinquiry.tbl_customer_idtbl_customer');
		$this->db->where('tbl_customerinquiry.status', 1);
		$this->db->where('tbl_customerinquiry.idtbl_customerinquiry', $recordID);
		$respond=$this->db->get();

        $this->db->select('`job`, `qty`, `uom`, `unitprice`, `comments`');
		$this->db->from('tbl_customerinquiry_detail');
		$this->db->where('status', 1);
		$this->db->where('tbl_customerinquiry_idtbl_customerinquiry', $recordID);
        $responddetail=$this->db->get();

        $html='';
        $html.='
        <div class="row">
            <div class="col-6 small"><label class="small font-weight-bold text-dark mb-1">Date:</label> '.$respond->row(0)->date.'<br><label class="small font-weight-bold text-dark mb-1">PO No:</label> '.$respond->row(0)->po_number.'<br><label class="small font-weight-bold text-dark mb-1">Customer:</label> '.$respond->row(0)->customer.'</div>
            <div class="col-6 small"><label class="small font-weight-bold text-dark mb-1">Company:</label> '.$respond->row(0)->company.'<br><label class="small font-weight-bold text-dark mb-1">Branch:</label> '.$respond->row(0)->branch.'</div>
        </div>
        <hr class="border-dark">
        <table class="table table-bordered table-striped table-sm small nowrap">
            <thead>
                <tr>
                    <th>Job</th>
                    <th>Qty</th>
                    <th>UOM</th>
                    <th>Unitprice</th>
                    <th>Comments</th>
                </tr>
            </thead>
            <tbody>';
            foreach($responddetail->result() as $rowlist){
                $html.='<tr>
                    <td>'.$rowlist->job.'</td>
                    <td>'.$rowlist->qty.'</td>
                    <td>'.$rowlist->uom.'</td>
                    <td>'.$rowlist->unitprice.'</td>
                    <td>'.$rowlist->comments.'</td>
                </tr>';
            }
            $html.='</tbody>
        </table>
        ';

        echo ($html);


    }
    public function Customerinquirystatus($x, $y){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $recordID=$x;
        $type=$y;
        $updatedatetime=date('Y-m-d H:i:s');

        if($type==1){
            $data = array(
                'status' => '1',
                'tbl_user_idtbl_user'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

			$this->db->where('idtbl_customerinquiry', $recordID);
            $this->db->update('tbl_customerinquiry', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-check';
                $actionObj->title='';
                $actionObj->message='Record Activate Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='success';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Customerinquiry');                
            } else {
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
                redirect('Customerinquiry');
            }
        }
        else if($type==2){
            $data = array(
                'status' => '2',
                'tbl_user_idtbl_user'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

			$this->db->where('idtbl_customerinquiry', $recordID);
            $this->db->update('tbl_customerinquiry', $data);


            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-times';
                $actionObj->title='';
                $actionObj->message='Record Deactivate Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='warning';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Customerinquiry');                
            } else {
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
                redirect('Customerinquiry');
            }
        }
        else if($type==3){
			$data = array(
                'status' => '3',
                'tbl_user_idtbl_user'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

			$this->db->where('idtbl_customerinquiry', $recordID);
            $this->db->update('tbl_customerinquiry', $data);


            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-trash-alt';
                $actionObj->title='';
                $actionObj->message='Record Remove Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='danger';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Customerinquiry');                
            } else {
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
                redirect('Customerinquiry');
            }
        }
    }
    public function Customerinquiryapprove(){
		$this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $companyID=$_SESSION['company_id'];
        $recordID=$this->input->post('inquiryid');
        $confirmnot=$this->input->post('confirmnot');
        $updatedatetime=date('Y-m-d H:i:s');

        $this->db->select('`date`');
		$this->db->from('tbl_customerinquiry');
		$this->db->where('status', 1);
		$this->db->where('idtbl_customerinquiry', $recordID);
        $respondcusinquery=$this->db->get();

        $recorddate = $respondcusinquery->row(0)->date;
        $currentYear = date("Y", strtotime($recorddate));
        $currentMonth = date("m", strtotime($recorddate));

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

        $this->db->select('job_no');
        $this->db->from('tbl_customerinquiry_detail');
        $this->db->where('approvestatus !=', 0);
        $this->db->where('tbl_company_idtbl_company', $companyID);
        $this->db->where("DATE(insertdatetime) >=", $fromyear);
        $this->db->where("DATE(insertdatetime) <=", $toyear);
        $this->db->order_by('job_no', 'DESC');
        $this->db->limit(1);
        $respond = $this->db->get();
        
        if ($respond->num_rows() > 0) {
            $last_inv_no = $respond->row()->job_no;
            $inv_number = intval(substr($last_inv_no, -4));
            $count = $inv_number;
        } else {
            $count = 0;
        }
        
        //Update tbl_customerinquiry table
		$data = array(
			'approvestatus' => $confirmnot,
			'tbl_user_idtbl_user'=> $userID, 
			'updatedatetime'=> $updatedatetime
		);
		$this->db->where('idtbl_customerinquiry', $recordID);
		$this->db->update('tbl_customerinquiry', $data);

        //Update idtbl_customerinquiry_detail table
        if($confirmnot==1){
            $count++; 
            $countPrefix = sprintf('%04d', $count);

            $yearDigit = substr(date("Y", strtotime($fromyear)), -2);

            if($companyID==1){$jobcode = 'MOPV' . $yearDigit . $countPrefix;} 
            else if($companyID==2){$jobcode = 'FTH' . $yearDigit . $countPrefix;}
            else if($companyID==3){$jobcode = 'RMI' . $yearDigit . $countPrefix;}
        }
        else{
            $jobcode = '';
        }
        
        $datadetail = array(
            'approvestatus' => $confirmnot,
            'job_no'=> $jobcode, 
            'updatedatetime'=> $updatedatetime
        );

        $this->db->where('tbl_customerinquiry_idtbl_customerinquiry', $recordID);
        $this->db->update('tbl_customerinquiry_detail', $datadetail);

		$this->db->trans_complete();

		if ($this->db->trans_status() === TRUE) {
			$this->db->trans_commit();
			
			$actionObj=new stdClass();
			$actionObj->icon='fas fa-times';
			$actionObj->title='';
            if($confirmnot==1){$actionObj->message='Record Approved Successfully';}
            else{$actionObj->message='Record Rejected Successfully';}
			$actionObj->url='';
			$actionObj->target='_blank';
			$actionObj->type='primary';

			$actionJSON=json_encode($actionObj);
			
			$obj=new stdClass();
            $obj->status=1;
            $obj->action=$actionJSON;

            echo json_encode($obj);            
		} else {
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
            $obj->status=0;
            $obj->action=$actionJSON;

            echo json_encode($obj);       
		}
	} 
    public function Getcustomejobs() {
        $recordID = $this->input->post('recordID');
    
        $this->db->select('idtbl_customer_job_details, job_name');
        $this->db->from('tbl_customer_job_details');
        $this->db->where('tbl_customer_job_details.status', 1);
        $this->db->where('tbl_customer_job_details.tbl_customer_idtbl_customer', $recordID);
    
        $respond = $this->db->get();
    
        if ($respond->num_rows() > 0) {
            echo json_encode($respond->result());
        }
    }
}
