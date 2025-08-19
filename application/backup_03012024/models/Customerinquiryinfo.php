<?php
class Customerinquiryinfo extends CI_Model{

    public function Getcompany() {
		$this->db->select('`idtbl_company`, `company`');
		$this->db->from('tbl_company');
		$this->db->where('status', 1);

		return $respond=$this->db->get();
	}

	public function Getcompanybranch() {
		$company_id = $this->input->post('company_id');
        $this->db->select('idtbl_company_branch, branch');
        $this->db->from('tbl_company_branch');
        $this->db->where('status', 1);
        $this->db->where('tbl_company_idtbl_company', $company_id); 
        $query = $this->db->get();
        $result = $query->result_array();
        echo json_encode($result);
        
	}

	public function Getcustomer(){
        $comapnyID=$_SESSION['company_id'];
        $this->db->select('`idtbl_customer`, `name`');
        $this->db->from('tbl_customer');
        $this->db->where('status', 1);
        $this->db->where('company_id', $comapnyID);

        return $respond=$this->db->get();
    }
    public function Getjobs(){
        $this->db->select('`idtbl_customer_job_details`, `job_name`');
        $this->db->from('tbl_customer_job_details');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
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

        $date=$this->input->post('date');
		$ponumber=$this->input->post('ponumber');
		$customer=$this->input->post('customer');
        $company_id=$this->input->post('company_id');
		$branch_id=$this->input->post('branch_id');
		$tableData = $this->input->post('tableData');
		
        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

        $insertdatetime=date('Y-m-d H:i:s');

        if($recordOption==1){
            $data = array(
                'date'=> $date, 
				'po_number'=> $ponumber,
                'company_id'=> $company_id, 
			    'company_branch_id'=> $branch_id,  
				'tbl_customer_idtbl_customer'=> $customer, 
                'status'=> '1', 
                'insertdatetime'=> $insertdatetime, 
                'tbl_user_idtbl_user'=> $userID,
            );

            $this->db->insert('tbl_customerinquiry', $data);

			$insertId = $this->db->insert_id();

            foreach($tableData as $rowtabledata){
                $data = array(
                    'job'=> $rowtabledata['col_1'], 
                    'qty'=> $rowtabledata['col_2'],
                    'uom'=> $rowtabledata['col_3'], 
                    'unitprice'=> $rowtabledata['col_4'],
                    'comments'=> $rowtabledata['col_5'], 
                    'job_id'=> $rowtabledata['col_6'], 
                    'uom_id'=> $rowtabledata['col_7'], 
                    'company_id'=> $company_id, 
                    'status'=> '1', 
                    'insertdatetime'=> $insertdatetime, 
                    'tbl_user_idtbl_user'=> $userID,
                    'tbl_customerinquiry_idtbl_customerinquiry'=> $insertId, 
                );
                $this->db->insert('tbl_customerinquiry_detail', $data);
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
        else{
            $data = array(
				'date'=> $date, 
				'po_number'=> $ponumber, 
                'company_id'=> $company_id, 
			    'company_branch_id'=> $branch_id,  
				'tbl_customer_idtbl_customer'=> $customer, 
                'status'=> '1', 
                'updatedatetime'=> $insertdatetime, 
                'tbl_user_idtbl_user'=> $userID,
            );

            $this->db->where('idtbl_customerinquiry', $recordID);
            $this->db->update('tbl_customerinquiry', $data);

			foreach($tableData as $rowtabledata){

                $insertMethod = $rowtabledata['col_8'];
                if($insertMethod=="NewRow"){
                    $inquiryID = $rowtabledata['col_9'];
                    // $jobID = $rowtabledata['col_7'];
                    $data = array(
						'job'=> $rowtabledata['col_1'], 
						'qty'=> $rowtabledata['col_2'],
                        'uom'=> $rowtabledata['col_3'],
                        'unitprice'=> $rowtabledata['col_4'],
						'comments'=> $rowtabledata['col_5'], 
                        'job_id'=> $rowtabledata['col_6'], 
                        'uom_id'=> $rowtabledata['col_7'], 
                        'status'=> '1', 
                        'insertdatetime'=> $insertdatetime, 
                        'tbl_user_idtbl_user'=> $userID,
                        'tbl_customerinquiry_idtbl_customerinquiry'=> $inquiryID,
                    );
                    $this->db->insert('tbl_customerinquiry_detail', $data);
                }else if($insertMethod=="Updated"){
                    $inquiryID = $rowtabledata['col_9'];
                    $detailsID = $rowtabledata['col_10'];
                    $data = array(
						'job'=> $rowtabledata['col_1'], 
						'qty'=> $rowtabledata['col_2'],
                        'uom'=> $rowtabledata['col_3'],
                        'unitprice'=> $rowtabledata['col_4'],
						'comments'=> $rowtabledata['col_5'], 
                        'job_id'=> $rowtabledata['col_6'], 
                        'uom_id'=> $rowtabledata['col_7'], 
                        'status'=> '1', 
                        'updatedatetime'=> $insertdatetime, 
                        'tbl_user_idtbl_user'=> $userID,
                        'tbl_customerinquiry_idtbl_customerinquiry'=> $inquiryID,
                    );

                    $this->db->where('idtbl_customerinquiry_detail', $detailsID);
                    $this->db->update('tbl_customerinquiry_detail', $data);
                }
                
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

    public function Customerinquiryedit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('tbl_customerinquiry');
        $this->db->where('idtbl_customerinquiry', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_customerinquiry;
        $obj->date=$respond->row(0)->date;
		$obj->po_number=$respond->row(0)->po_number;
		$obj->customer=$respond->row(0)->tbl_customer_idtbl_customer;

        echo json_encode($obj);
    }

    public function Getcustomejobs() {
        $recordID = $this->input->post('recordID');
    
        $this->db->select('*');
        $this->db->from('tbl_customer_job_details');
        // $this->db->join('tbl_print_dispatch', 'tbl_print_dispatchdetail.tbl_print_dispatch_idtbl_print_dispatch = tbl_print_dispatch.idtbl_print_dispatch');
        $this->db->where('tbl_customer_job_details.status', 1);
        $this->db->where('tbl_customer_job_details.tbl_customer_idtbl_customer', $recordID);
    
        $respond = $this->db->get();
    
        if ($respond->num_rows() > 0) {
            echo json_encode($respond->result());
        }
    }

    public function Getjobuom() {
		$recordID=$this->input->post('recordID');
		$jobID=$this->input->post('jobID');

		$this->db->select('*','tbl_measurements.measure_type');
		$this->db->from('tbl_customer_job_details');
        $this->db->join('tbl_measurements', 'tbl_measurements.idtbl_mesurements = tbl_customer_job_details.measure_type_id');
		$this->db->where('tbl_customer_job_details.status', 1);
		//$this->db->where('idtbl_customerinquiry_detail', $inqury_id);
		// $this->db->where('tbl_customer_idtbl_customer', $recordID);
		$this->db->where('tbl_customer_job_details.idtbl_customer_job_details', $recordID);


		$respond=$this->db->get();

        $obj=new stdClass();
		if($respond->num_rows()>0) {
			$obj->measure_type_id=$respond->row(0)->measure_type_id;
            $obj->measure_type=$respond->row(0)->measure_type;
		
			$obj->unitprice=$respond->row(0)->unitprice;
			//$obj->batchno=$respond->row(0)->batchno;
		}

		echo json_encode($obj);
	}

    public function GetAllCustomerInquiries(){

        $this->db->select('*');
        $this->db->from('tbl_customerinquiry');
        $this->db->join('tbl_customer', 'tbl_customer.idtbl_customer = tbl_customerinquiry.tbl_customer_idtbl_customer');
        $this->db->where('tbl_customerinquiry.status', 1);

        return $respond=$this->db->get();
    }

	public function Customerinquiryjobedit(){
        $recordID=$this->input->post('recordID');

        $html='';

		$sql="SELECT * FROM `tbl_customerinquiry_detail` 
		LEFT JOIN `tbl_customerinquiry` ON `tbl_customerinquiry`.`idtbl_customerinquiry`=`tbl_customerinquiry_detail`.`tbl_customerinquiry_idtbl_customerinquiry`
		WHERE `tbl_customerinquiry_idtbl_customerinquiry`= '$recordID'";

        $respond=$this->db->query($sql, array(1, $recordID));

              
        foreach($respond->result() as $rowlist){
           
            $html.='
            <tr id ="'.$rowlist->idtbl_customerinquiry_detail.'">
               
                <td>'.$rowlist->job.'</td>
                <td>'.$rowlist->qty.'</td>
                <td>'.$rowlist->uom.'</td>
                <td>'.$rowlist->unitprice.'</td>
                <td>'.$rowlist->comments.'</td>
                <td class="d-none">OldData</td>
                <td class="d-none"> '.$rowlist->tbl_customerinquiry_idtbl_customerinquiry.'</td>
                <td ><button type="button" id="'.$rowlist->idtbl_customerinquiry_detail.'" class="btnEditlist btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#exampleModal">
                <i class="fas fa-pen"></i>
              </button>
              </td>
              <td class="d-none"><input class="hiddenid" type ="hidden" id ="hiddenid" name="hiddenid" value="'.$rowlist->idtbl_customerinquiry_detail.'"></td>
                
             </tr>
            
            ';
            
        }

        echo ($html);


    }
	public function Customerinquiryjoblistedit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('tbl_customerinquiry_detail');
        $this->db->where('idtbl_customerinquiry_detail', $recordID);
        $this->db->where('tbl_customerinquiry_detail.status', 1);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_customerinquiry_detail;
        $obj->job_id=$respond->row(0)->job_id;
        $obj->job=$respond->row(0)->job;
        $obj->uom_id=$respond->row(0)->uom_id;
        $obj->uom=$respond->row(0)->uom;
        $obj->qty=$respond->row(0)->qty;
        $obj->unitprice=$respond->row(0)->unitprice;
        $obj->comments=$respond->row(0)->comments;
        $obj->idtbl_customerinquiry=$respond->row(0)->tbl_customerinquiry_idtbl_customerinquiry;
        echo json_encode($obj);
    }
    
    public function Customerinquiryviewjoblist(){
        $recordID=$this->input->post('recordID');

        $html='';

		$sql="SELECT * FROM `tbl_customerinquiry_detail` 
		LEFT JOIN `tbl_customerinquiry` ON `tbl_customerinquiry`.`idtbl_customerinquiry`=`tbl_customerinquiry_detail`.`tbl_customerinquiry_idtbl_customerinquiry`
		WHERE `tbl_customerinquiry_idtbl_customerinquiry`= '$recordID'";

        $respond=$this->db->query($sql, array(1, $recordID));

              
        foreach($respond->result() as $rowlist){
            $html.='
            <tr id ="'.$rowlist->idtbl_customerinquiry_detail.'">
                <td>'.$rowlist->job.'</td>
                <td>'.$rowlist->qty.'</td>
                <td>'.$rowlist->uom.'</td>
                <td>'.$rowlist->unitprice.'</td>
                <td>'.$rowlist->comments.'</td>
                <td class = ""><a href ='.base_url().'Jobdetails/FetchPassedValue/'.$rowlist->idtbl_customerinquiry_detail.'><button class = "btn btn-primary btn-sm addJobDetails" id = "'. $rowlist->idtbl_customerinquiry_detail .'"><i class="fas fa-plus"></i></button></a></td>
             </tr>
            
            ';
        }

        echo ($html);


    }

    
}
