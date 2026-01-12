<?php
use Dompdf\Dompdf;
use Dompdf\Options;
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
		$deliverydate = $this->input->post('deliverydate');
		$deliveryby = $this->input->post('deliveryby');
		$jobbom = $this->input->post('jobbom');
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
                'deliveryby'=> $deliveryby, 
                'deliverydate'=> $deliverydate, 
                'status'=> '1', 
                'insertdatetime'=> $insertdatetime, 
                'tbl_customerinquiry_idtbl_customerinquiry'=> $insertId, 
                'tbl_company_idtbl_company'=> $company_id, 
                'tbl_user_idtbl_user'=> $userID,
                'tbl_jobcard_bom_idtbl_jobcard_bom'=> $jobbom
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
                    'deliveryby'=> $deliveryby, 
                    'deliverydate'=> $deliverydate, 
                    'status'=> '1', 
                    'updatedatetime'=> $insertdatetime, 
                    'tbl_company_idtbl_company'=> $company_id, 
                    'tbl_user_idtbl_user'=> $userID,
                    'tbl_jobcard_bom_idtbl_jobcard_bom'=> $jobbom
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
                    'tbl_user_idtbl_user'=> $userID,
                    'tbl_jobcard_bom_idtbl_jobcard_bom'=> $jobbom
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

        $this->db->select('tbl_customerinquiry_detail.*, tbl_customer_job_details.job_name, tbl_jobcard_bom.jobbomname');
        $this->db->from('tbl_customerinquiry_detail');
        $this->db->join('tbl_customer_job_details', 'tbl_customer_job_details.idtbl_customer_job_details = tbl_customerinquiry_detail.job_id', 'left');
        $this->db->join('tbl_jobcard_bom', 'tbl_jobcard_bom.idtbl_jobcard_bom = tbl_customerinquiry_detail.tbl_jobcard_bom_idtbl_jobcard_bom', 'left');
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
		$obj->jobbomid=$responddetail->row(0)->tbl_jobcard_bom_idtbl_jobcard_bom;
		$obj->jobbomname=$responddetail->row(0)->jobbomname;
		$obj->deliveryby=$responddetail->row(0)->deliveryby;
		$obj->deliverydate=$responddetail->row(0)->deliverydate;

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

        $this->db->select('`tbl_customerinquiry_detail`.`job`, `tbl_customerinquiry_detail`.`qty`, `tbl_customerinquiry_detail`.`uom`, `tbl_customerinquiry_detail`.`unitprice`, `tbl_customerinquiry_detail`.`comments`, `tbl_jobcard_bom`.`jobbomname`, `tbl_customerinquiry_detail`.`deliveryby`, `tbl_customerinquiry_detail`.`deliverydate`');
		$this->db->from('tbl_customerinquiry_detail');
        $this->db->join('tbl_jobcard_bom', 'tbl_jobcard_bom.idtbl_jobcard_bom = tbl_customerinquiry_detail.tbl_jobcard_bom_idtbl_jobcard_bom', 'left');
		$this->db->where('tbl_customerinquiry_detail.status', 1);
		$this->db->where('tbl_customerinquiry_detail.tbl_customerinquiry_idtbl_customerinquiry', $recordID);
        $responddetail=$this->db->get();

        $html='';
        $html.='
        <div class="row">
            <div class="col-6 small"><label class="small font-weight-bold text-dark mb-1">Date:</label> '.$respond->row(0)->date.'<br><label class="small font-weight-bold text-dark mb-1">PO No:</label> '.$respond->row(0)->po_number.'<br><label class="small font-weight-bold text-dark mb-1">Customer:</label> '.$respond->row(0)->customer.'<br><label class="small font-weight-bold text-dark mb-1">Job BOM:</label> '.$responddetail->row(0)->jobbomname.'</div>
            <div class="col-6 small"><label class="small font-weight-bold text-dark mb-1">Company:</label> '.$respond->row(0)->company.'<br><label class="small font-weight-bold text-dark mb-1">Branch:</label> '.$respond->row(0)->branch.'<br><label class="small font-weight-bold text-dark mb-1">Delivery Date:</label> '.$responddetail->row(0)->deliverydate.'<br><label class="small font-weight-bold text-dark mb-1">Delivery By:</label> '.$responddetail->row(0)->deliveryby.'</div>
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
    public function Customerinquiryfinish(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $finishreason=$this->input->post('finishreason');
        $hiddenID=$this->input->post('hiddenID');
        $updatedatetime=date('Y-m-d H:i:s');

            $data = array(
                'job_finish_status' => '1',
                'finish_reason'=> $finishreason, 
                'updatedatetime'=> $updatedatetime
            );

			$this->db->where('tbl_customerinquiry_idtbl_customerinquiry', $hiddenID);
            $this->db->update('tbl_customerinquiry_detail', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-check';
                $actionObj->title='';
                $actionObj->message='Job Finish Successfully';
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
    public function Getjobbominfo() {
        $jobID=$this->input->post('recordID');

        $this->db->select('idtbl_jobcard_bom, jobbomname');
        $this->db->from('tbl_jobcard_bom');
        $this->db->where('status', 1);
        $this->db->where('tbl_customer_job_details_idtbl_customer_job_details', $jobID);    
        $respond=$this->db->get();
        if ($respond->num_rows() > 0) {
            echo json_encode($respond->result());
        }
    }
    public function Customerinquiryviewjobcard(){
        $recordID=$this->input->post('recordID');

        $this->db->select('date, po_number, company, branch, customer');
		$this->db->from('tbl_customerinquiry');
        $this->db->join('tbl_company', 'tbl_company.idtbl_company = tbl_customerinquiry.tbl_company_idtbl_company');
        $this->db->join('tbl_company_branch', 'tbl_company_branch.idtbl_company_branch = tbl_customerinquiry.tbl_company_branch_idtbl_company_branch');
        $this->db->join('tbl_customer', 'tbl_customer.idtbl_customer = tbl_customerinquiry.tbl_customer_idtbl_customer');
		$this->db->where('tbl_customerinquiry.status', 1);
		$this->db->where('tbl_customerinquiry.idtbl_customerinquiry', $recordID);
		$respond=$this->db->get();

        $this->db->select('`tbl_customerinquiry_detail`.`job`, `tbl_customerinquiry_detail`.`job_no`, `tbl_customerinquiry_detail`.`qty`, `tbl_customerinquiry_detail`.`uom`, `tbl_customerinquiry_detail`.`unitprice`, `tbl_customerinquiry_detail`.`comments`, `tbl_jobcard_bom`.`jobbomname`, `tbl_customerinquiry_detail`.`deliveryby`, `tbl_customerinquiry_detail`.`deliverydate`, `tbl_customerinquiry_detail`.`tbl_jobcard_bom_idtbl_jobcard_bom`');
		$this->db->from('tbl_customerinquiry_detail');
        $this->db->join('tbl_jobcard_bom', 'tbl_jobcard_bom.idtbl_jobcard_bom = tbl_customerinquiry_detail.tbl_jobcard_bom_idtbl_jobcard_bom', 'left');
		$this->db->where('tbl_customerinquiry_detail.status', 1);
		$this->db->where('tbl_customerinquiry_detail.tbl_customerinquiry_idtbl_customerinquiry', $recordID);
        $responddetail=$this->db->get();

        $requestqty = $responddetail->row(0)->qty;

        $this->db->select('
            `tbl_jobcard_bom_material`.`materialby`, 
            `tbl_jobcard_bom_material`.`cutsize`, 
            `tbl_jobcard_bom_material`.`cutups`, 
            `tbl_jobcard_bom_material`.`upspersheet`, 
            `tbl_jobcard_bom_material`.`wastage`, 
            CEIL((("' . $requestqty . '"/(`tbl_jobcard_bom_material`.`cutups`*`tbl_jobcard_bom_material`.`upspersheet`))*(100+`tbl_jobcard_bom_material`.`wastage`)/100)) AS `issueqty`, 
            (("' . $requestqty . '"/(`tbl_jobcard_bom_material`.`cutups`*`tbl_jobcard_bom_material`.`upspersheet`))*(100+`tbl_jobcard_bom_material`.`wastage`)/100) AS `actqty`, 
            tbl_print_material_info.`materialname`, 
            tbl_print_material_info.materialinfocode
        ');
        $this->db->from('tbl_jobcard_bom_material');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_bom_material.tbl_print_material_info_idtbl_print_material_info', 'left');
        $this->db->where('tbl_jobcard_bom_material.status', 1);
        $this->db->where('tbl_jobcard_bom_material.tbl_jobcard_bom_idtbl_jobcard_bom', $responddetail->row(0)->tbl_jobcard_bom_idtbl_jobcard_bom);
        $respondbommaterial = $this->db->get(); 

        $this->db->select('
            `tbl_jobcard_bom_color`.`colormaterialby`, 
            `tbl_jobcard_bom_color`.`colortype`, 
            `tbl_jobcard_bom_color`.`remark`, 
            `tbl_jobcard_bom_color`.`qty`,
            CEIL("' . $requestqty . '"*`tbl_jobcard_bom_color`.`qty`) AS `issueqty`,
            "' . $requestqty . '"*`tbl_jobcard_bom_color`.`qty` AS `actqty`,
            tbl_print_material_info.`materialname`, 
            tbl_print_material_info.materialinfocode');
        $this->db->from('tbl_jobcard_bom_color');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_bom_color.tbl_print_material_info_idtbl_print_material_info', 'left');
        $this->db->where('tbl_jobcard_bom_color.status', 1);
        $this->db->where('tbl_jobcard_bom_color.tbl_jobcard_bom_idtbl_jobcard_bom', $responddetail->row(0)->tbl_jobcard_bom_idtbl_jobcard_bom);
        $respondbomcolor = $this->db->get();

        $this->db->select('
            `tbl_jobcard_bom_varnish`.`glossmatt`, 
            `tbl_jobcard_bom_varnish`.`fullspot`, 
            `tbl_jobcard_bom_varnish`.`varnishQty`, 
            CEIL("' . $requestqty . '"*`tbl_jobcard_bom_varnish`.`varnishQty`) AS `issueqty`,
            "' . $requestqty . '"*`tbl_jobcard_bom_varnish`.`varnishQty` AS `actqty`,
            `tbl_jobcard_bom_varnish`.`remark`,
            tbl_print_material_info.`materialname`, 
            tbl_print_material_info.materialinfocode, 
            tbl_varnish.varnish
        ');
        $this->db->from('tbl_jobcard_bom_varnish');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_bom_varnish.tbl_print_material_info_idtbl_print_material_info', 'left');
        $this->db->join('tbl_varnish', 'tbl_varnish.idtbl_varnish = tbl_jobcard_bom_varnish.tbl_varnish_idtbl_varnish', 'left');
        $this->db->where('tbl_jobcard_bom_varnish.status', 1);
        $this->db->where('tbl_jobcard_bom_varnish.tbl_jobcard_bom_idtbl_jobcard_bom', $responddetail->row(0)->tbl_jobcard_bom_idtbl_jobcard_bom);
        $respondbomvarnish = $this->db->get();

        $this->db->select('
            `tbl_jobcard_bom_foil`.`foilmaterialby`, 
            `tbl_jobcard_bom_foil`.`qty`, 
            `tbl_jobcard_bom_foil`.`remark`,
            CEIL("' . $requestqty . '"*`tbl_jobcard_bom_foil`.`qty`) AS `issueqty`,
            "' . $requestqty . '"*`tbl_jobcard_bom_foil`.`qty` AS `actqty`,
            tbl_print_material_info.`materialname`,
            tbl_print_material_info.materialinfocode
        ');
        $this->db->from('tbl_jobcard_bom_foil');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_bom_foil.tbl_print_material_info_idtbl_print_material_info', 'left');
        $this->db->where('tbl_jobcard_bom_foil.status', 1);
        $this->db->where('tbl_jobcard_bom_foil.tbl_jobcard_bom_idtbl_jobcard_bom', $responddetail->row(0)->tbl_jobcard_bom_idtbl_jobcard_bom);
        $respondbomfoil = $this->db->get();

        $this->db->select('
            `tbl_jobcard_bom_lamination`.`sides`, 
            `tbl_jobcard_bom_lamination`.`filmsize`, 
            `tbl_jobcard_bom_lamination`.`lamination_qty`, 
            CEIL("' . $requestqty . '"*`tbl_jobcard_bom_lamination`.`lamination_qty`) AS `issueqty`,
            "' . $requestqty . '"*`tbl_jobcard_bom_lamination`.`lamination_qty` AS `actqty`,
            tbl_print_material_info.`materialname`,
            tbl_print_material_info.materialinfocode,
            tbl_lamination.lamination
        ');
        $this->db->from('tbl_jobcard_bom_lamination');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_bom_lamination.tbl_print_material_info_idtbl_print_material_info', 'left');
        $this->db->join('tbl_lamination', 'tbl_lamination.idtbl_lamination = tbl_jobcard_bom_lamination.tbl_lamination_idtbl_lamination', 'left');
        $this->db->where('tbl_jobcard_bom_lamination.status', 1);
        $this->db->where('tbl_jobcard_bom_lamination.tbl_jobcard_bom_idtbl_jobcard_bom', $responddetail->row(0)->tbl_jobcard_bom_idtbl_jobcard_bom);
        $respondbomlamination = $this->db->get();

        $this->db->select('
            `tbl_jobcard_bom_pasting`.`pastetype`, 
            `tbl_jobcard_bom_pasting`.`pasteqty`, 
            `tbl_jobcard_bom_pasting`.`remark`,
            CEIL("' . $requestqty . '"*`tbl_jobcard_bom_pasting`.`pasteqty`) AS `issueqty`,
            "' . $requestqty . '"*`tbl_jobcard_bom_pasting`.`pasteqty` AS `actqty`,
            tbl_print_material_info.`materialname`,
            tbl_print_material_info.materialinfocode,
            tbl_machine.machine
        ');
        $this->db->from('tbl_jobcard_bom_pasting');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_bom_pasting.tbl_print_material_info_idtbl_print_material_info', 'left');
        $this->db->join('tbl_machine', 'tbl_machine.idtbl_machine = tbl_jobcard_bom_pasting.tbl_machine_idtbl_machine', 'left');
        $this->db->where('tbl_jobcard_bom_pasting.status', 1);
        $this->db->where('tbl_jobcard_bom_pasting.tbl_jobcard_bom_idtbl_jobcard_bom', $responddetail->row(0)->tbl_jobcard_bom_idtbl_jobcard_bom);
        $respondbompasting = $this->db->get();

        $this->db->select('`channel`, `board`, `size`, `qty`, `diecutby`, `embossby`');
		$this->db->from('tbl_jobcard_bom_diecutting');
		$this->db->where('tbl_jobcard_bom_idtbl_jobcard_bom', $responddetail->row(0)->tbl_jobcard_bom_idtbl_jobcard_bom);
		$this->db->where('status', 1);

		$responddiecut=$this->db->get();

        $this->db->select('
            `tbl_jobcard_bom_rimming`.`rimmingby`, 
            `tbl_jobcard_bom_rimming`.`sides`, 
            `tbl_jobcard_bom_rimming`.`remark`,
            `tbl_jobcard_bom_rimming`.`qty`,
            CEIL("' . $requestqty . '"*`tbl_jobcard_bom_rimming`.`qty`) AS `issueqty`,
            "' . $requestqty . '"*`tbl_jobcard_bom_rimming`.`qty` AS `actqty`,
            tbl_print_material_info.`materialname`,
            tbl_print_material_info.materialinfocode,
            tbl_rimming.rimming
        ');
        $this->db->from('tbl_jobcard_bom_rimming');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_bom_rimming.tbl_print_material_info_idtbl_print_material_info', 'left');
        $this->db->join('tbl_rimming', 'tbl_rimming.idtbl_rimming = tbl_jobcard_bom_rimming.tbl_rimming_idtbl_rimming', 'left');
        $this->db->where('tbl_jobcard_bom_rimming.tbl_jobcard_bom_idtbl_jobcard_bom', $responddetail->row(0)->tbl_jobcard_bom_idtbl_jobcard_bom);
        $this->db->where('tbl_jobcard_bom_rimming.status', 1);
        $respondbomrimming = $this->db->get();

        $this->db->select('`perfoating`, `gattering`, `rimming`, `binding`, `stapling`, `padding`, `creasing`, `threading`');
		$this->db->from('tbl_jobcard_bom_other');
		$this->db->where('tbl_jobcard_bom_idtbl_jobcard_bom', $responddetail->row(0)->tbl_jobcard_bom_idtbl_jobcard_bom);
		$this->db->where('status', 1);

		$respondother=$this->db->get();

        // print_r($this->db->last_query());    

        $html='';
        $html.='
        <div class="row">
            <div class="col-6 small"><label class="small font-weight-bold text-dark mb-1">Date:</label> '.$respond->row(0)->date.'<br><label class="small font-weight-bold text-dark mb-1">PO No:</label> '.$respond->row(0)->po_number.'<br><label class="small font-weight-bold text-dark mb-1">Customer:</label> '.$respond->row(0)->customer.'<br><label class="small font-weight-bold text-dark mb-1">Delivery Date:</label> '.$responddetail->row(0)->deliverydate.'<br><label class="small font-weight-bold text-dark mb-1">Delivery By:</label> '.$responddetail->row(0)->deliveryby.'</div>
            <div class="col-6 small"><label class="small font-weight-bold text-dark mb-1">Company:</label> '.$respond->row(0)->company.'<br><label class="small font-weight-bold text-dark mb-1">Branch:</label> '.$respond->row(0)->branch.'<br><label class="small font-weight-bold text-dark mb-1">Job:</label> '.$responddetail->row(0)->job.'<br><label class="small font-weight-bold text-dark mb-1">Job No:</label> '.$responddetail->row(0)->job_no.'</div>
        </div>
        <div class="row">
            <div class="col-12">
                <hr class="border-dark">
                <div class="card shadow-none border">
                    <div class="card-body p-2">
                        <h6 class="title-style small"><span>Material Section</span></h6>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm small nowrap">
                                <thead>
                                    <tr>
                                        <th>Material Info Code</th>
                                        <th>Material Name</th>
                                        <th>Material By</th>
                                        <th>Cut Size</th>
                                        <th class="text-center">Cut Ups</th>
                                        <th class="text-center">Ups Per Sheet</th>
                                        <th class="text-center">Wastage (%)</th>
                                        <th class="text-center">Act. Qty</th>
                                        <th class="text-center">Issue Qty</th>
                                    </tr>
                                </thead>
                                <tbody>';
                                foreach($respondbommaterial->result() as $rowlist){
                                    $html.='<tr>
                                        <td>'.$rowlist->materialinfocode.'</td>
                                        <td>'.$rowlist->materialname.'</td>
                                        <td>'.$rowlist->materialby.'</td>
                                        <td>'.$rowlist->cutsize.'</td>
                                        <td class="text-center">'.$rowlist->cutups.'</td>
                                        <td class="text-center">'.$rowlist->upspersheet.'</td>
                                        <td class="text-center">'.$rowlist->wastage.'</td>
                                        <td class="text-center">'.$rowlist->actqty.'</td>
                                        <td class="text-center">'.$rowlist->issueqty.'</td>
                                    </tr>';
                                }
                                $html.='</tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card shadow-none border mt-2">
                    <div class="card-body p-2">
                        <h6 class="title-style small"><span>Printing Section</span></h6>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm small nowrap">
                                <thead>
                                    <tr>
                                        <th>Material Info Code</th>
                                        <th>Material Name</th>
                                        <th>Material By</th>
                                        <th>Color Type</th>
                                        <th>Remark</th>
                                        <th class="text-center">BOM Qty</th>
                                        <th class="text-center">Act. Qty</th>
                                        <th class="text-center">Issue Qty</th>
                                    </tr>
                                </thead>
                                <tbody>';
                                foreach($respondbomcolor->result() as $rowlist){
                                    $html.='<tr>
                                        <td>'.$rowlist->materialinfocode.'</td>
                                        <td>'.$rowlist->materialname.'</td>
                                        <td>'.$rowlist->colormaterialby.'</td>
                                        <td>'.$rowlist->colortype.'</td>
                                        <td>'.$rowlist->remark.'</td>
                                        <td class="text-center">'.$rowlist->qty.'</td>
                                        <td class="text-center">'.$rowlist->actqty.'</td>
                                        <td class="text-center">'.$rowlist->issueqty.'</td>
                                    </tr>';
                                }
                                $html.='</tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card shadow-none border mt-2">
                    <div class="card-body p-2">
                        <h6 class="title-style small"><span>Coating Section</span></h6>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm small nowrap">
                                <thead>
                                    <tr>
                                        <th>Material Info Code</th>
                                        <th>Material Name</th>
                                        <th>Varnish Name</th>
                                        <th>Gloss / Matt</th>
                                        <th>Full / Spot</th>
                                        <th>Remark</th>
                                        <th class="text-center">BOM Qty</th>
                                        <th class="text-center">Act. Qty</th>
                                        <th class="text-center">Issue Qty</th>
                                    </tr>
                                </thead>
                                <tbody>';
                                foreach($respondbomvarnish->result() as $rowlist){
                                    $html.='<tr>
                                        <td>'.$rowlist->materialinfocode.'</td>
                                        <td>'.$rowlist->materialname.'</td>
                                        <td>'.$rowlist->varnish.'</td>
                                        <td>'.$rowlist->glossmatt.'</td>
                                        <td>'.$rowlist->fullspot.'</td>
                                        <td>'.$rowlist->remark.'</td>
                                        <td class="text-center">'.$rowlist->varnishQty.'</td>
                                        <td class="text-center">'.$rowlist->actqty.'</td>
                                        <td class="text-center">'.$rowlist->issueqty.'</td>
                                    </tr>';
                                }
                                $html.='</tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card shadow-none border mt-2">
                    <div class="card-body p-2">
                        <h6 class="title-style small"><span>Foil Section</span></h6>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm small nowrap">
                                <thead>
                                    <tr>
                                        <th>Material Info Code</th>
                                        <th>Material Name</th>
                                        <th>Material By</th>
                                        <th>Remark</th>
                                        <th class="text-center">BOM Qty</th>
                                        <th class="text-center">Act. Qty</th>
                                        <th class="text-center">Issue Qty</th>
                                    </tr>
                                </thead>
                                <tbody>';
                                foreach($respondbomfoil->result() as $rowlist){
                                    $html.='<tr>
                                        <td>'.$rowlist->materialinfocode.'</td>
                                        <td>'.$rowlist->materialname.'</td>
                                        <td>'.$rowlist->foilmaterialby.'</td>
                                        <td>'.$rowlist->remark.'</td>
                                        <td class="text-center">'.$rowlist->qty.'</td>
                                        <td class="text-center">'.$rowlist->actqty.'</td>
                                        <td class="text-center">'.$rowlist->issueqty.'</td>
                                    </tr>';
                                }
                                $html.='</tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card shadow-none border mt-2">
                    <div class="card-body p-2">
                        <h6 class="title-style small"><span>Lamination Section</span></h6>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm small nowrap">
                                <thead>
                                    <tr>
                                        <th>Material Info Code</th>
                                        <th>Material Name</th>
                                        <th>Lamination Name</th>
                                        <th>Sides</th>
                                        <th>Film Size</th>
                                        <th class="text-center">BOM Qty</th>
                                        <th class="text-center">Act. Qty</th>
                                        <th class="text-center">Issue Qty</th>
                                    </tr>
                                </thead>
                                <tbody>';
                                foreach($respondbomlamination->result() as $rowlist){
                                    $html.='<tr>
                                        <td>'.$rowlist->materialinfocode.'</td>
                                        <td>'.$rowlist->materialname.'</td>
                                        <td>'.$rowlist->lamination.'</td>
                                        <td>'.$rowlist->sides.'</td>
                                        <td>'.$rowlist->filmsize.'</td>
                                        <td class="text-center">'.$rowlist->lamination_qty.'</td>
                                        <td class="text-center">'.$rowlist->actqty.'</td>
                                        <td class="text-center">'.$rowlist->issueqty.'</td>
                                    </tr>';
                                }
                                $html.='</tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card shadow-none border mt-2">
                    <div class="card-body p-2">
                        <h6 class="title-style small"><span>Pasting Section</span></h6>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm small nowrap">
                                <thead>
                                    <tr>
                                        <th>Material Info Code</th>
                                        <th>Material Name</th>
                                        <th>Machine Name</th>
                                        <th>Paste Type</th>
                                        <th>Remark</th>
                                        <th class="text-center">BOM Qty</th>
                                        <th class="text-center">Act. Qty</th>
                                        <th class="text-center">Issue Qty</th>
                                    </tr>
                                </thead>
                                <tbody>';
                                foreach($respondbompasting->result() as $rowlist){
                                    $html.='<tr>
                                        <td>'.$rowlist->materialinfocode.'</td>
                                        <td>'.$rowlist->materialname.'</td>
                                        <td>'.$rowlist->machine.'</td>
                                        <td>'.$rowlist->pastetype.'</td>
                                        <td>'.$rowlist->remark.'</td>
                                        <td class="text-center">'.$rowlist->pasteqty.'</td>
                                        <td class="text-center">'.$rowlist->actqty.'</td>
                                        <td class="text-center">'.$rowlist->issueqty.'</td>
                                    </tr>';
                                }
                                $html.='</tbody>
                            </table>
                        </div>
                    </div>
                </div>';
                if($responddiecut->num_rows()>0){
                $html.='<div class="card shadow-none border">
                    <div class="card-body p-2 small">
                        <h6 class="small title-style"><span>Die Cutting Section</span></h6>
                        <div class="row">
                            <div class="col-6"><strong>Channel :</strong> '.$responddiecut->row(0)->channel.'</div>
                            <div class="col-6"><strong>Qty :</strong> '.$responddiecut->row(0)->qty.'</div>
                            <div class="col-6"><strong>Board :</strong> '.$responddiecut->row(0)->board.'</div>
                            <div class="col-6"><strong>Die Cut By :</strong> '.$responddiecut->row(0)->diecutby.'</div>
                            <div class="col-6"><strong>Size :</strong> '.$responddiecut->row(0)->size.'</div>
                            <div class="col-6"><strong>Emboss By :</strong> '.$responddiecut->row(0)->embossby.'</div>
                        </div>
                    </div>
                </div>';
                }
                $html.='<div class="card shadow-none border mt-2">
                    <div class="card-body p-2">
                        <h6 class="title-style small"><span>Rimming Section</span></h6>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm small nowrap">
                                <thead>
                                    <tr>
                                        <th>Material Info Code</th>
                                        <th>Material Name</th>
                                        <th>Material By</th>
                                        <th>Sides</th>
                                        <th>Remark</th>
                                        <th class="text-center">BOM Qty</th>
                                        <th class="text-center">Act. Qty</th>
                                        <th class="text-center">Issue Qty</th>
                                    </tr>
                                </thead>
                                <tbody>';
                                foreach($respondbomrimming->result() as $rowlist){
                                    $html.='<tr>
                                        <td>'.$rowlist->materialinfocode.'</td>
                                        <td>'.$rowlist->materialname.'</td>
                                        <td>'.$rowlist->rimmingby.'</td>
                                        <td>'.$rowlist->sides.'</td>
                                        <td>'.$rowlist->remark.'</td>
                                        <td class="text-center">'.$rowlist->qty.'</td>
                                        <td class="text-center">'.$rowlist->actqty.'</td>
                                        <td class="text-center">'.$rowlist->issueqty.'</td>
                                    </tr>';
                                }
                                $html.='</tbody>
                            </table>
                        </div>
                    </div>
                </div>';
                if($responddiecut->num_rows()>0){
                $html.='<h6 class="small title-style"><span>Other Section</span></h6>
                <div class="card shadow-none border">
                    <div class="card-body p-2 small">
                        <div class="row">
                            <div class="col-6"><strong>Perfoating :</strong> '.$respondother->row(0)->perfoating.'</div>
                            <div class="col-6"><strong>Gattering :</strong> '.$respondother->row(0)->gattering.'</div>
                            <div class="col-6"><strong>Rimming :</strong> '.$respondother->row(0)->rimming.'</div>
                            <div class="col-6"><strong>Binding :</strong> '.$respondother->row(0)->binding.'</div>
                            <div class="col-6"><strong>Stapling :</strong> '.$respondother->row(0)->stapling.'</div>
                            <div class="col-6"><strong>Padding :</strong> '.$respondother->row(0)->padding.'</div>
                            <div class="col-6"><strong>Creasing :</strong> '.$respondother->row(0)->creasing.'</div>
                            <div class="col-6"><strong>Threading :</strong> '.$respondother->row(0)->threading.'</div>
                        </div>
                    </div>
                </div>';
                }
            $html.='</div>
        </div>
        ';

        echo ($html);
    }
    public function Customerinquiryexportpdf($id) {
        $recordID=$id;

        $this->db->select('date, po_number, company, branch, customer');
		$this->db->from('tbl_customerinquiry');
        $this->db->join('tbl_company', 'tbl_company.idtbl_company = tbl_customerinquiry.tbl_company_idtbl_company');
        $this->db->join('tbl_company_branch', 'tbl_company_branch.idtbl_company_branch = tbl_customerinquiry.tbl_company_branch_idtbl_company_branch');
        $this->db->join('tbl_customer', 'tbl_customer.idtbl_customer = tbl_customerinquiry.tbl_customer_idtbl_customer');
		$this->db->where('tbl_customerinquiry.status', 1);
		$this->db->where('tbl_customerinquiry.idtbl_customerinquiry', $recordID);
		$respond=$this->db->get();

        $this->db->select('`tbl_customerinquiry_detail`.`job`, `tbl_customerinquiry_detail`.`job_no`, `tbl_customerinquiry_detail`.`qty`, `tbl_customerinquiry_detail`.`uom`, `tbl_customerinquiry_detail`.`unitprice`, `tbl_customerinquiry_detail`.`comments`, `tbl_jobcard_bom`.`jobbomname`, `tbl_customerinquiry_detail`.`deliveryby`, `tbl_customerinquiry_detail`.`deliverydate`, `tbl_customerinquiry_detail`.`tbl_jobcard_bom_idtbl_jobcard_bom`');
		$this->db->from('tbl_customerinquiry_detail');
        $this->db->join('tbl_jobcard_bom', 'tbl_jobcard_bom.idtbl_jobcard_bom = tbl_customerinquiry_detail.tbl_jobcard_bom_idtbl_jobcard_bom', 'left');
		$this->db->where('tbl_customerinquiry_detail.status', 1);
		$this->db->where('tbl_customerinquiry_detail.tbl_customerinquiry_idtbl_customerinquiry', $recordID);
        $responddetail=$this->db->get();

        $requestqty = $responddetail->row(0)->qty;

        $this->db->select('
            `tbl_jobcard_bom_material`.`materialby`, 
            `tbl_jobcard_bom_material`.`cutsize`, 
            `tbl_jobcard_bom_material`.`cutups`, 
            `tbl_jobcard_bom_material`.`upspersheet`, 
            `tbl_jobcard_bom_material`.`wastage`, 
            CEIL((("' . $requestqty . '"/(`tbl_jobcard_bom_material`.`cutups`*`tbl_jobcard_bom_material`.`upspersheet`))*(100+`tbl_jobcard_bom_material`.`wastage`)/100)) AS `issueqty`, 
            tbl_print_material_info.`materialname`, 
            tbl_print_material_info.materialinfocode
        ');
        $this->db->from('tbl_jobcard_bom_material');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_bom_material.tbl_print_material_info_idtbl_print_material_info', 'left');
        $this->db->where('tbl_jobcard_bom_material.status', 1);
        $this->db->where('tbl_jobcard_bom_material.tbl_jobcard_bom_idtbl_jobcard_bom', $responddetail->row(0)->tbl_jobcard_bom_idtbl_jobcard_bom);
        $respondbommaterial = $this->db->get();

        $this->db->select('
            `tbl_jobcard_bom_color`.`colormaterialby`, 
            `tbl_jobcard_bom_color`.`colortype`, 
            `tbl_jobcard_bom_color`.`remark`, 
            `tbl_jobcard_bom_color`.`qty`,
            CEIL("' . $requestqty . '"*`tbl_jobcard_bom_color`.`qty`) AS `issueqty`,
            tbl_print_material_info.`materialname`, 
            tbl_print_material_info.materialinfocode');
        $this->db->from('tbl_jobcard_bom_color');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_bom_color.tbl_print_material_info_idtbl_print_material_info', 'left');
        $this->db->where('tbl_jobcard_bom_color.status', 1);
        $this->db->where('tbl_jobcard_bom_color.tbl_jobcard_bom_idtbl_jobcard_bom', $responddetail->row(0)->tbl_jobcard_bom_idtbl_jobcard_bom);
        $respondbomcolor = $this->db->get();

        $this->db->select('
            `tbl_jobcard_bom_varnish`.`glossmatt`, 
            `tbl_jobcard_bom_varnish`.`fullspot`, 
            `tbl_jobcard_bom_varnish`.`varnishQty`, 
            CEIL("' . $requestqty . '"*`tbl_jobcard_bom_varnish`.`varnishQty`) AS `issueqty`,
            `tbl_jobcard_bom_varnish`.`remark`,
            tbl_print_material_info.`materialname`, 
            tbl_print_material_info.materialinfocode, 
            tbl_varnish.varnish
        ');
        $this->db->from('tbl_jobcard_bom_varnish');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_bom_varnish.tbl_print_material_info_idtbl_print_material_info', 'left');
        $this->db->join('tbl_varnish', 'tbl_varnish.idtbl_varnish = tbl_jobcard_bom_varnish.tbl_varnish_idtbl_varnish', 'left');
        $this->db->where('tbl_jobcard_bom_varnish.status', 1);
        $this->db->where('tbl_jobcard_bom_varnish.tbl_jobcard_bom_idtbl_jobcard_bom', $responddetail->row(0)->tbl_jobcard_bom_idtbl_jobcard_bom);
        $respondbomvarnish = $this->db->get();

        $this->db->select('
            `tbl_jobcard_bom_foil`.`foilmaterialby`, 
            `tbl_jobcard_bom_foil`.`qty`, 
            `tbl_jobcard_bom_foil`.`remark`,
            CEIL("' . $requestqty . '"*`tbl_jobcard_bom_foil`.`qty`) AS `issueqty`,
            tbl_print_material_info.`materialname`,
            tbl_print_material_info.materialinfocode
        ');
        $this->db->from('tbl_jobcard_bom_foil');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_bom_foil.tbl_print_material_info_idtbl_print_material_info', 'left');
        $this->db->where('tbl_jobcard_bom_foil.status', 1);
        $this->db->where('tbl_jobcard_bom_foil.tbl_jobcard_bom_idtbl_jobcard_bom', $responddetail->row(0)->tbl_jobcard_bom_idtbl_jobcard_bom);
        $respondbomfoil = $this->db->get();

        $this->db->select('
            `tbl_jobcard_bom_lamination`.`sides`, 
            `tbl_jobcard_bom_lamination`.`filmsize`, 
            `tbl_jobcard_bom_lamination`.`lamination_qty`, 
            CEIL("' . $requestqty . '"*`tbl_jobcard_bom_lamination`.`lamination_qty`) AS `issueqty`,
            tbl_print_material_info.`materialname`,
            tbl_print_material_info.materialinfocode,
            tbl_lamination.lamination
        ');
        $this->db->from('tbl_jobcard_bom_lamination');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_bom_lamination.tbl_print_material_info_idtbl_print_material_info', 'left');
        $this->db->join('tbl_lamination', 'tbl_lamination.idtbl_lamination = tbl_jobcard_bom_lamination.tbl_lamination_idtbl_lamination', 'left');
        $this->db->where('tbl_jobcard_bom_lamination.status', 1);
        $this->db->where('tbl_jobcard_bom_lamination.tbl_jobcard_bom_idtbl_jobcard_bom', $responddetail->row(0)->tbl_jobcard_bom_idtbl_jobcard_bom);
        $respondbomlamination = $this->db->get();

        $this->db->select('
            `tbl_jobcard_bom_pasting`.`pastetype`, 
            `tbl_jobcard_bom_pasting`.`pasteqty`, 
            `tbl_jobcard_bom_pasting`.`remark`,
            CEIL("' . $requestqty . '"*`tbl_jobcard_bom_pasting`.`pasteqty`) AS `issueqty`,
            tbl_print_material_info.`materialname`,
            tbl_print_material_info.materialinfocode,
            tbl_machine.machine
        ');
        $this->db->from('tbl_jobcard_bom_pasting');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_bom_pasting.tbl_print_material_info_idtbl_print_material_info', 'left');
        $this->db->join('tbl_machine', 'tbl_machine.idtbl_machine = tbl_jobcard_bom_pasting.tbl_machine_idtbl_machine', 'left');
        $this->db->where('tbl_jobcard_bom_pasting.status', 1);
        $this->db->where('tbl_jobcard_bom_pasting.tbl_jobcard_bom_idtbl_jobcard_bom', $responddetail->row(0)->tbl_jobcard_bom_idtbl_jobcard_bom);
        $respondbompasting = $this->db->get();

        $this->db->select('`channel`, `board`, `size`, `qty`, `diecutby`, `embossby`');
		$this->db->from('tbl_jobcard_bom_diecutting');
		$this->db->where('tbl_jobcard_bom_idtbl_jobcard_bom', $responddetail->row(0)->tbl_jobcard_bom_idtbl_jobcard_bom);
		$this->db->where('status', 1);

		$responddiecut=$this->db->get();

        $this->db->select('
            `tbl_jobcard_bom_rimming`.`rimmingby`, 
            `tbl_jobcard_bom_rimming`.`sides`, 
            `tbl_jobcard_bom_rimming`.`remark`,
            `tbl_jobcard_bom_rimming`.`qty`,
            CEIL("' . $requestqty . '"*`tbl_jobcard_bom_rimming`.`qty`) AS `issueqty`,
            tbl_print_material_info.`materialname`,
            tbl_print_material_info.materialinfocode,
            tbl_rimming.rimming
        ');
        $this->db->from('tbl_jobcard_bom_rimming');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_bom_rimming.tbl_print_material_info_idtbl_print_material_info', 'left');
        $this->db->join('tbl_rimming', 'tbl_rimming.idtbl_rimming = tbl_jobcard_bom_rimming.tbl_rimming_idtbl_rimming', 'left');
        $this->db->where('tbl_jobcard_bom_rimming.tbl_jobcard_bom_idtbl_jobcard_bom', $responddetail->row(0)->tbl_jobcard_bom_idtbl_jobcard_bom);
        $this->db->where('tbl_jobcard_bom_rimming.status', 1);
        $respondbomrimming = $this->db->get();

        $this->db->select('`perfoating`, `gattering`, `rimming`, `binding`, `stapling`, `padding`, `creasing`, `threading`');
		$this->db->from('tbl_jobcard_bom_other');
		$this->db->where('tbl_jobcard_bom_idtbl_jobcard_bom', $responddetail->row(0)->tbl_jobcard_bom_idtbl_jobcard_bom);
		$this->db->where('status', 1);

		$respondother=$this->db->get();

        $html='';
        $html.='
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Job Card Information</title>
            <style>
                @page {
                    size: 210mm 297mm;
                    margin: 5mm 5mm 5mm 5mm; /* top right bottom left */
                    font-family: Arial, sans-serif;
                }
                body {
                    font-family: Arial, sans-serif;
                    line-height: 1.5;
                    text-align:left;
                    margin-top: 150px;
                }

                /** Define the header rules **/
                header {
                    position: fixed;
                    top: 0px;
                    left: 0px;
                    right: 0px;
                    height: 210px;
                }

                /* Page break control for tables */
                table {
                    page-break-inside: auto;
                }
                
                tr {
                    page-break-inside: avoid;
                    page-break-after: auto;
                }
                
                thead {
                    display: table-header-group;
                }
                
                tfoot {
                    display: table-footer-group;
                }
                
                /* Prevent sections from breaking in the middle */
                .section {
                    page-break-inside: avoid;
                }
                
                /* Force page break when needed */
                .page-break {
                    page-break-before: always;
                }
                
                /* Ensure content doesn`t break awkwardly */
                .no-break {
                    page-break-inside: avoid;
                }
            </style>
        </head>
        <body>
            <header>
                <div style="border: 1px solid black; border-radius: 10px; padding: 5px;">
                    <table style="width:100%;border-collapse: collapse;">
                        <tr>
                            <td style="text-align: center;vertical-align: top;padding: 0px;font-size: 18px;font-weight: bold;">
                                <u>Job Card Information</u>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table style="width:100%;border-collapse: collapse;">
                                    <td width="50%" style="vertical-align: top;">
                                        <p style="margin:0px;font-size: 13px;"><span style="font-weight: bold;">Date: </span>'.$respond->row(0)->date.'</p>
                                        <p style="margin:0px;font-size: 13px;"><span style="font-weight: bold;">PO No: </span>'.$respond->row(0)->po_number.'</p>
                                        <p style="margin:0px;font-size: 13px;"><span style="font-weight: bold;">Customer: </span>'.$respond->row(0)->customer.'</p>
                                        <p style="margin:0px;font-size: 13px;"><span style="font-weight: bold;">Delivery Date: </span>'.$responddetail->row(0)->deliverydate.'</p>
                                        <p style="margin:0px;font-size: 13px;"><span style="font-weight: bold;">Delivery By: </span>'.$responddetail->row(0)->deliveryby.'</p>
                                    </td>
                                    <td style="vertical-align: top;">
                                        <p style="margin:0px;font-size: 13px;"><span style="font-weight: bold;">Company: </span>'.$respond->row(0)->company.'</p>
                                        <p style="margin:0px;font-size: 13px;"><span style="font-weight: bold;">Branch: </span>'.$respond->row(0)->branch.'</p>
                                        <p style="margin:0px;font-size: 13px;"><span style="font-weight: bold;">Job: </span>'.$responddetail->row(0)->job.'</p>
                                        <p style="margin:0px;font-size: 13px;"><span style="font-weight: bold;">Job No: </span>'.$responddetail->row(0)->job_no.'</p>
                                    </td>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </header>
            <main>
                <div class="section">
                <table style="width:100%;border-collapse: collapse;">
                    <tr>
                        <td style="font-size: 13px;"><u>Material Inforamtion</u></td>
                    </tr>
                    <tr>
                        <td>
                            <table style="width:100%;border-collapse: collapse;font-size: 13px;margin-top:20px;margin-bottom:20px;">
                                <thead>
                                    <tr>
                                        <th style="border-bottom: 1px thin solid;vertical-align: top;">Material Info Code</th>
                                        <th style="border-bottom: 1px thin solid;vertical-align: top;">Material Name</th>
                                        <th style="border-bottom: 1px thin solid;vertical-align: top;">Material By</th>
                                        <th style="border-bottom: 1px thin solid;vertical-align: top;">Cut Size</th>
                                        <th style="border-bottom: 1px thin solid;vertical-align: top;text-align: center;">Cut Ups</th>
                                        <th style="border-bottom: 1px thin solid;vertical-align: top;text-align: center;">Ups Per Sheet</th>
                                        <th style="border-bottom: 1px thin solid;vertical-align: top;text-align: center;">Wastage (%)</th>
                                        <th style="border-bottom: 1px thin solid;vertical-align: top;text-align: center;">Issue Qty</th>
                                    </tr>
                                </thead>
                                <tbody>';
                                foreach($respondbommaterial->result() as $rowlist){
                                    $html.='<tr>
                                        <td style="border-bottom: 1px thin solid;vertical-align: top;">'.$rowlist->materialinfocode.'</td>
                                        <td style="border-bottom: 1px thin solid;vertical-align: top;">'.$rowlist->materialname.'</td>
                                        <td style="border-bottom: 1px thin solid;vertical-align: top;">'.$rowlist->materialby.'</td>
                                        <td style="border-bottom: 1px thin solid;vertical-align: top;">'.$rowlist->cutsize.'</td>
                                        <td style="border-bottom: 1px thin solid;vertical-align: top;text-align: center;">'.$rowlist->cutups.'</td>
                                        <td style="border-bottom: 1px thin solid;vertical-align: top;text-align: center;">'.$rowlist->upspersheet.'</td>
                                        <td style="border-bottom: 1px thin solid;vertical-align: top;text-align: center;">'.$rowlist->wastage.'</td>
                                        <td style="border-bottom: 1px thin solid;vertical-align: top;text-align: center;">'.$rowlist->issueqty.'</td>
                                    </tr>';
                                }
                                $html.='</tbody>
                            </table>
                        </td>
                    </tr>
                </table>
                </div>
                <div class="section">
                    <table style="width:100%;border-collapse: collapse;">
                        <tr>
                            <td style="font-size: 13px;"><u>Printing Inforamtion</u></td>
                        </tr>
                        <tr>
                            <td>
                                <table style="width:100%;border-collapse: collapse;font-size: 13px;margin-top:20px;margin-bottom:20px;">
                                    <thead>
                                        <tr>
                                            <th style="border-bottom: 1px thin solid;vertical-align: top;">Material Info Code</th>
                                            <th style="border-bottom: 1px thin solid;vertical-align: top;">Material Name</th>
                                            <th style="border-bottom: 1px thin solid;vertical-align: top;">Material By</th>
                                            <th style="border-bottom: 1px thin solid;vertical-align: top;">Color Type</th>
                                            <th style="border-bottom: 1px thin solid;vertical-align: top;">Remark</th>
                                            <th style="border-bottom: 1px thin solid;vertical-align: top;text-align:center;">BOM Qty</th>
                                            <th style="border-bottom: 1px thin solid;vertical-align: top;text-align:center;">Issue Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                                    foreach($respondbomcolor->result() as $rowlist){
                                        $html.='<tr>
                                            <td style="border-bottom: 1px thin solid;vertical-align: top;">'.$rowlist->materialinfocode.'</td>
                                            <td style="border-bottom: 1px thin solid;vertical-align: top;">'.$rowlist->materialname.'</td>
                                            <td style="border-bottom: 1px thin solid;vertical-align: top;">'.$rowlist->colormaterialby.'</td>
                                            <td style="border-bottom: 1px thin solid;vertical-align: top;">'.$rowlist->colortype.'</td>
                                            <td style="border-bottom: 1px thin solid;vertical-align: top;">'.$rowlist->remark.'</td>
                                            <td style="border-bottom: 1px thin solid;vertical-align: top;text-align:center;">'.$rowlist->qty.'</td>
                                            <td style="border-bottom: 1px thin solid;vertical-align: top;text-align:center;">'.$rowlist->issueqty.'</td>
                                        </tr>';
                                    }
                                    $html.='</tbody>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="section">
                    <table style="width:100%;border-collapse: collapse;">
                        <tr>
                            <td style="font-size: 13px;"><u>Coating Inforamtion</u></td>
                        </tr>
                        <tr>
                            <td>
                                <table style="width:100%;border-collapse: collapse;font-size: 13px;margin-top:20px;margin-bottom:20px;">
                                    <thead>
                                        <tr>
                                            <th style="border-bottom: 1px thin solid;vertical-align: top;">Material Info Code</th>
                                            <th style="border-bottom: 1px thin solid;vertical-align: top;">Material Name</th>
                                            <th style="border-bottom: 1px thin solid;vertical-align: top;">Varnish Name</th>
                                            <th style="border-bottom: 1px thin solid;vertical-align: top;">Gloss / Matt</th>
                                            <th style="border-bottom: 1px thin solid;vertical-align: top;">Full / Spot</th>
                                            <th style="border-bottom: 1px thin solid;vertical-align: top;">Remark</th>
                                            <th style="border-bottom: 1px thin solid;vertical-align: top;text-align:center;">BOM Qty</th>
                                            <th style="border-bottom: 1px thin solid;vertical-align: top;text-align:center;">Issue Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                                    foreach($respondbomvarnish->result() as $rowlist){
                                        $html.='<tr>
                                            <td style="border-bottom: 1px thin solid;vertical-align: top;">'.$rowlist->materialinfocode.'</td>
                                            <td style="border-bottom: 1px thin solid;vertical-align: top;">'.$rowlist->materialname.'</td>
                                            <td style="border-bottom: 1px thin solid;vertical-align: top;">'.$rowlist->varnish.'</td>
                                            <td style="border-bottom: 1px thin solid;vertical-align: top;">'.$rowlist->glossmatt.'</td>
                                            <td style="border-bottom: 1px thin solid;vertical-align: top;">'.$rowlist->fullspot.'</td>
                                            <td style="border-bottom: 1px thin solid;vertical-align: top;">'.$rowlist->remark.'</td>
                                            <td style="border-bottom: 1px thin solid;vertical-align: top;text-align:center;">'.$rowlist->varnishQty.'</td>
                                            <td style="border-bottom: 1px thin solid;vertical-align: top;text-align:center;">'.$rowlist->issueqty.'</td>
                                        </tr>';
                                    }
                                    $html.='</tbody>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="section">
                    <table style="width:100%;border-collapse: collapse;">
                        <tr>
                            <td style="font-size: 13px;"><u>Foil Inforamtion</u></td>
                        </tr>
                        <tr>
                            <td>
                                <table style="width:100%;border-collapse: collapse;font-size: 13px;margin-top:20px;margin-bottom:20px;">
                                    <thead>
                                        <tr>
                                            <th style="border-bottom: 1px thin solid;vertical-align: top;">Material Info Code</th>
                                            <th style="border-bottom: 1px thin solid;vertical-align: top;">Material Name</th>
                                            <th style="border-bottom: 1px thin solid;vertical-align: top;">Material By</th>
                                            <th style="border-bottom: 1px thin solid;vertical-align: top;">Remark</th>
                                            <th style="border-bottom: 1px thin solid;vertical-align: top;text-align:center;">BOM Qty</th>
                                            <th style="border-bottom: 1px thin solid;vertical-align: top;text-align:center;">Issue Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                                    foreach($respondbomfoil->result() as $rowlist){
                                        $html.='<tr>
                                            <td style="border-bottom: 1px thin solid;vertical-align: top;">'.$rowlist->materialinfocode.'</td>
                                            <td style="border-bottom: 1px thin solid;vertical-align: top;">'.$rowlist->materialname.'</td>
                                            <td style="border-bottom: 1px thin solid;vertical-align: top;">'.$rowlist->foilmaterialby.'</td>
                                            <td style="border-bottom: 1px thin solid;vertical-align: top;">'.$rowlist->remark.'</td>
                                            <td style="border-bottom: 1px thin solid;vertical-align: top;text-align:center;">'.$rowlist->qty.'</td>
                                            <td style="border-bottom: 1px thin solid;vertical-align: top;text-align:center;">'.$rowlist->issueqty.'</td>
                                        </tr>';
                                    }
                                    $html.='</tbody>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="section">
                    <table style="width:100%;border-collapse: collapse;">
                        <tr>
                            <td style="font-size: 13px;"><u>Lamination Inforamtion</u></td>
                        </tr>
                        <tr>
                            <td>
                                <table style="width:100%;border-collapse: collapse;font-size: 13px;margin-top:20px;margin-bottom:20px;">
                                    <thead>
                                        <tr>
                                            <th style="border-bottom: 1px thin solid;vertical-align: top;">Material Info Code</th>
                                            <th style="border-bottom: 1px thin solid;vertical-align: top;">Material Name</th>
                                            <th style="border-bottom: 1px thin solid;vertical-align: top;">Lamination Name</th>
                                            <th style="border-bottom: 1px thin solid;vertical-align: top;">Sides</th>
                                            <th style="border-bottom: 1px thin solid;vertical-align: top;">Film Size</th>
                                            <th style="border-bottom: 1px thin solid;vertical-align: top;text-align:center;">BOM Qty</th>
                                            <th style="border-bottom: 1px thin solid;vertical-align: top;text-align:center;">Issue Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                                    foreach($respondbomlamination->result() as $rowlist){
                                        $html.='<tr>
                                            <td style="border-bottom: 1px thin solid;vertical-align: top;">'.$rowlist->materialinfocode.'</td>
                                            <td style="border-bottom: 1px thin solid;vertical-align: top;">'.$rowlist->materialname.'</td>
                                            <td style="border-bottom: 1px thin solid;vertical-align: top;">'.$rowlist->lamination.'</td>
                                            <td style="border-bottom: 1px thin solid;vertical-align: top;">'.$rowlist->sides.'</td>
                                            <td style="border-bottom: 1px thin solid;vertical-align: top;">'.$rowlist->filmsize.'</td>
                                            <td style="border-bottom: 1px thin solid;vertical-align: top;text-align:center;">'.$rowlist->lamination_qty.'</td>
                                            <td style="border-bottom: 1px thin solid;vertical-align: top;text-align:center;">'.$rowlist->issueqty.'</td>
                                        </tr>';
                                    }
                                    $html.='</tbody>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="section">
                    <table style="width:100%;border-collapse: collapse;">
                        <tr>
                            <td style="font-size: 13px;"><u>Pasting Inforamtion</u></td>
                        </tr>
                        <tr>
                            <td>
                                <table style="width:100%;border-collapse: collapse;font-size: 13px;margin-top:20px;margin-bottom:20px;">
                                    <thead>
                                        <tr>
                                            <th style="border-bottom: 1px thin solid;vertical-align: top;">Material Info Code</th>
                                            <th style="border-bottom: 1px thin solid;vertical-align: top;">Material Name</th>
                                            <th style="border-bottom: 1px thin solid;vertical-align: top;">Machine Name</th>
                                            <th style="border-bottom: 1px thin solid;vertical-align: top;">Paste Type</th>
                                            <th style="border-bottom: 1px thin solid;vertical-align: top;">Remark</th>
                                            <th style="border-bottom: 1px thin solid;vertical-align: top;text-align:center;">BOM Qty</th>
                                            <th style="border-bottom: 1px thin solid;vertical-align: top;text-align:center;">Issue Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                                    foreach($respondbompasting->result() as $rowlist){
                                        $html.='<tr>
                                            <td style="border-bottom: 1px thin solid;vertical-align: top;">'.$rowlist->materialinfocode.'</td>
                                            <td style="border-bottom: 1px thin solid;vertical-align: top;">'.$rowlist->materialname.'</td>
                                            <td style="border-bottom: 1px thin solid;vertical-align: top;">'.$rowlist->machine.'</td>
                                            <td style="border-bottom: 1px thin solid;vertical-align: top;">'.$rowlist->pastetype.'</td>
                                            <td style="border-bottom: 1px thin solid;vertical-align: top;">'.$rowlist->remark.'</td>
                                            <td style="border-bottom: 1px thin solid;vertical-align: top;text-align:center;">'.$rowlist->pasteqty.'</td>
                                            <td style="border-bottom: 1px thin solid;vertical-align: top;text-align:center;">'.$rowlist->issueqty.'</td>
                                        </tr>';
                                    }
                                    $html.='</tbody>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="section">
                    <table style="width:100%;border-collapse: collapse;">
                        <tr>
                            <td style="font-size: 13px;"><u>Die Cutting Inforamtion</u></td>
                        </tr>
                        <tr>
                            <td>
                                <table style="width:100%;border-collapse: collapse;margin-top:20px;margin-bottom:20px;">
                                    <td width="50%" style="vertical-align: top;">
                                        <p style="margin:0px;font-size: 13px;"><span style="font-weight: bold;">Channel: </span>'.$responddiecut->row(0)->channel.'</p>
                                        <p style="margin:0px;font-size: 13px;"><span style="font-weight: bold;">Board: </span>'.$responddiecut->row(0)->board.'</p>
                                        <p style="margin:0px;font-size: 13px;"><span style="font-weight: bold;">Size: </span>'.$responddiecut->row(0)->size.'</p>
                                    </td>
                                    <td style="vertical-align: top;">
                                        <p style="margin:0px;font-size: 13px;"><span style="font-weight: bold;">Qty: </span>'.$responddiecut->row(0)->qty.'</p>
                                        <p style="margin:0px;font-size: 13px;"><span style="font-weight: bold;">Die Cut By: </span>'.$responddiecut->row(0)->diecutby.'</p>
                                        <p style="margin:0px;font-size: 13px;"><span style="font-weight: bold;">Emboss By: </span>'.$responddiecut->row(0)->embossby.'</p>
                                    </td>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="section">
                    <table style="width:100%;border-collapse: collapse;">
                        <tr>
                            <td style="font-size: 13px;"><u>Rimming Inforamtion</u></td>
                        </tr>
                        <tr>
                            <td>
                                <table style="width:100%;border-collapse: collapse;font-size: 13px;margin-top:20px;margin-bottom:20px;">
                                    <thead>
                                        <tr>
                                            <th style="border-bottom: 1px thin solid;vertical-align: top;">Material Info Code</th>
                                            <th style="border-bottom: 1px thin solid;vertical-align: top;">Material Name</th>
                                            <th style="border-bottom: 1px thin solid;vertical-align: top;">Material By</th>
                                            <th style="border-bottom: 1px thin solid;vertical-align: top;">Sides</th>
                                            <th style="border-bottom: 1px thin solid;vertical-align: top;">Remark</th>
                                            <th style="border-bottom: 1px thin solid;vertical-align: top;text-align:center;">BOM Qty</th>
                                            <th style="border-bottom: 1px thin solid;vertical-align: top;text-align:center;">Issue Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                                    foreach($respondbomrimming->result() as $rowlist){
                                        $html.='<tr>
                                            <td style="border-bottom: 1px thin solid;vertical-align: top;">'.$rowlist->materialinfocode.'</td>
                                            <td style="border-bottom: 1px thin solid;vertical-align: top;">'.$rowlist->materialname.'</td>
                                            <td style="border-bottom: 1px thin solid;vertical-align: top;">'.$rowlist->rimmingby.'</td>
                                            <td style="border-bottom: 1px thin solid;vertical-align: top;">'.$rowlist->sides.'</td>
                                            <td style="border-bottom: 1px thin solid;vertical-align: top;">'.$rowlist->remark.'</td>
                                            <td style="border-bottom: 1px thin solid;vertical-align: top;text-align:center;">'.$rowlist->qty.'</td>
                                            <td style="border-bottom: 1px thin solid;vertical-align: top;text-align:center;">'.$rowlist->issueqty.'</td>
                                        </tr>';
                                    }
                                    $html.='</tbody>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="section">
                    <table style="width:100%;border-collapse: collapse;">
                        <tr>
                            <td style="font-size: 13px;"><u>Other Inforamtion</u></td>
                        </tr>
                        <tr>
                            <td>
                                <table style="width:100%;border-collapse: collapse;margin-top:20px;margin-bottom:20px;">
                                    <td width="50%" style="vertical-align: top;">
                                        <p style="margin:0px;font-size: 13px;"><span style="font-weight: bold;">Perfoating: </span>'.$respondother->row(0)->perfoating.'</p>
                                        <p style="margin:0px;font-size: 13px;"><span style="font-weight: bold;">Rimming: </span>'.$respondother->row(0)->rimming.'</p>
                                        <p style="margin:0px;font-size: 13px;"><span style="font-weight: bold;">Stapling: </span>'.$respondother->row(0)->stapling.'</p>
                                        <p style="margin:0px;font-size: 13px;"><span style="font-weight: bold;">Creasing: </span>'.$respondother->row(0)->creasing.'</p>
                                    </td>
                                    <td style="vertical-align: top;">
                                        <p style="margin:0px;font-size: 13px;"><span style="font-weight: bold;">Gattering: </span>'.$respondother->row(0)->gattering.'</p>
                                        <p style="margin:0px;font-size: 13px;"><span style="font-weight: bold;">Binding: </span>'.$respondother->row(0)->binding.'</p>
                                        <p style="margin:0px;font-size: 13px;"><span style="font-weight: bold;">Padding: </span>'.$respondother->row(0)->padding.'</p>
                                        <p style="margin:0px;font-size: 13px;"><span style="font-weight: bold;">Threading: </span>'.$respondother->row(0)->threading.'</p>
                                    </td>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </main>
        </body>
        </html>
        ';

        $this->load->library('pdf');

        $options = new Options();
		$options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("Goods Received Note - ". $id .".pdf", ["Attachment"=>0]);
    }
}
