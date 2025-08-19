<?php
    use Dompdf\Dompdf;
    use Dompdf\Options;
    class Invoiceinfo extends CI_Model{
	

     public function Getcompany() {
         $this->db->select('`idtbl_company`, `company`');
         $this->db->from('tbl_company');
         $this->db->where('status', 1);
    
            return $respond=$this->db->get();
        }
    
    // public function Getcompanybranch() {
    //     $this->db->select('`idtbl_company_branch`, `branch`');
    //     $this->db->from('tbl_company_branch');
    //     $this->db->where('status', 1);
    
    //         return $respond=$this->db->get();
    //     }
	public function Gedispatch() {
		$this->db->select('`idtbl_print_dispatch`');
		$this->db->from('tbl_print_dispatch');
		$this->db->where('status', 1);
		$this->db->where('status', 1);
        //$this->db->where('porderconfirm', 0);
		// $this->db->where_in('tbl_order_type_idtbl_order_type', array(3, 4));


		return $respond=$this->db->get();
	}
    public function Getchargetype(){
        $this->db->select('`idtbl_charges`, `charges_type`');
        $this->db->from('tbl_charges');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Getmeasuretype() {
		$this->db->select('`idtbl_mesurements`, `measure_type`');
		$this->db->from('tbl_measurements');
		$this->db->where('status', 1);

		return $respond=$this->db->get();
	}

    public function Getcustomerlist() {
        $this->db->select('tbl_customer.idtbl_customer, tbl_customer.name');
        $this->db->from('tbl_customer');
        $this->db->join('tbl_print_dispatch', 'tbl_print_dispatch.customer_id = tbl_customer.idtbl_customer', 'left');
        // $this->db->where('tbl_print_dispatch.approvestatus', 1);
        $this->db->where('tbl_print_dispatch.status', 1);
        $this->db->where('tbl_customer.status', 1);
        $this->db->group_by('tbl_print_dispatch.customer_id');
    
        return $this->db->get();
    }

    
    
        public function Invoiceinsertupdate(){
            $this->db->trans_begin();
    
            $userID=$_SESSION['userid'];

             ////////////////////////////////////////////// Create manual Invoice no ////////////////////////////////////////////////////////////////
             $comapnyID=$_SESSION['company_id'];

             $query = $this->db->query("SELECT * FROM tbl_print_invoice WHERE  company_id= $comapnyID");
             $count = $query->num_rows();
    
            $tableData=$this->input->post('tableData');
            $chargestableData=$this->input->post('chargestableData');
            $date=$this->input->post('date');
            $ink_charges=$this->input->post('ink_charges');
            $plate_charges=$this->input->post('plate_charges');
            $proces_charges=$this->input->post('proces_charges');
           //$ponum=$this->input->post('ponum');
            $customer=$this->input->post('customer');
            $total=$this->input->post('total');
            $subtotal=$this->input->post('subtotal');
		    $vat=$this->input->post('vat');
            $discount=$this->input->post('discount');
            $vatamount=$this->input->post('vatamount');
            $company_id=$this->input->post('company_id');
		    $branch_id=$this->input->post('branch_id');
            $remark=$this->input->post('remark');
            $updatedatetime=date('Y-m-d H:i:s');
    
            $data=array(
            'date'=> $date,
            'total'=> $total,
            'ink_charges'=> $ink_charges,
            'plate_charges'=> $plate_charges,
            'process_charges'=> $proces_charges,
            'subtotal'=> $subtotal,
            'vat'=> $vat,
            'discount'=> $discount,
            'remark'=> $remark,
            'vat_amount'=> $vatamount,
            'company_id'=> $company_id, 
			'company_branch_id'=> $branch_id, 
            'approvestatus'=> '0',
            'status'=> '1',
            'insertdatetime'=> $updatedatetime,
            'tbl_user_idtbl_user'=> $userID,
            // 'ponum'=> $ponum,
            'customer_id'=> $customer,
            'tbl_print_dispatch_idtbl_print_dispatch'=>'',);
    
            $this->db->insert('tbl_print_invoice', $data);
    
            $invoiceID=$this->db->insert_id();


    
            $result_array = array();
            $querydetails = $this->db->query("SELECT idtbl_print_invoice FROM tbl_print_invoice WHERE idtbl_print_invoice = $invoiceID");
            if ($querydetails) {
                $result_array = $querydetails->result_array();
            }
    
            foreach ($result_array as $row) {
                $id = $row['idtbl_print_invoice'];
    
                $count++; 

                $invono = 'INV000' . $count;

                $invodetail = array(
                    'inv_no'=> $invono, 
                    'updatedatetime'=> $updatedatetime
                );
        
                $this->db->where('idtbl_print_invoice', $id);
                $this->db->update('tbl_print_invoice', $invodetail);
            }


            // $materialid=0;
            // $machineid=0;
    
                foreach($tableData as $rowtabledata) {
                    $dispatch=$rowtabledata['col_1'];
                    $job=$rowtabledata['col_2'];
                    $job_no=$rowtabledata['col_3'];
                    $qty=$rowtabledata['col_4'];
                    $uom_id=$rowtabledata['col_6'];
                    $unitprice=$rowtabledata['col_7'];
                    $job_id=$rowtabledata['col_8'];
                    $total=$rowtabledata['col_10'];
                    $dispath_noteid=$rowtabledata['col_12'];
                   
                  
                    // $total=$rowtabledata['col_7'];
                    $inquerydetailsid=$rowtabledata['col_6'];
    
                    // $ordertype==3 ? $materialid=$productid:$machineid=$productid;
    
                    $dataone=array(
                        'date'=> $date,
                        'qty'=> $qty,
                        'total'=> $total,
                        'unitprice'=> $unitprice,
                        'job'=> $job,
                        'job_no'=> $job_no,
                        'job_id'=> $job_id,
                        'status'=> '1',
                        'insertdatetime'=> $updatedatetime,
                        'dispatch_no'=> $dispatch,
                        'measure_id'=> $uom_id,
                        'dispath_id'=> $dispath_noteid,
                        'tbl_print_invoice_idtbl_print_invoice'=> $invoiceID);
    
                    $this->db->insert('tbl_print_invoicedetail', $dataone);
                }
    

                $chargestableData = $this->input->post('chargestableData');

                // Check if $chargestableData is not null and has data
                if (!empty($chargestableData)) {
                    foreach ($chargestableData as $rowtabledata) {
                        $typeid = $rowtabledata['col_3'];
                        $amount = $rowtabledata['col_2'];
            
                        $dataone = array(
                            'charge_id' => $typeid,
                            'charge_amount' => $amount,
                            'status' => '1',
                            'insertdatetime' => $updatedatetime,
                            'tbl_print_invoice_idtbl_print_invoice' => $invoiceID
                        );
            
                        $this->db->insert('tbl_print_invoice_charge_detail', $dataone);
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
    
    
        public function Invoicestatus($x, $y) {
            $this->db->trans_begin();
    
            $userID=$_SESSION['userid'];
            $recordID=$x;
            $type=$y;
            // $porderid=$z;
            $updatedatetime=date('Y-m-d H:i:s');
    
            if($type==3) {
                $data=array('status'=> '3',
                    'updateuser'=> $userID,
                    'updatedatetime'=> $updatedatetime);
    
                $this->db->where('idtbl_print_invoice', $recordID);
                $this->db->update('tbl_print_invoice', $data);


                $querydetails = $this->db->query("SELECT idtbl_print_invoicedetail FROM tbl_print_invoicedetail WHERE tbl_print_invoice_idtbl_print_invoice = $recordID");
                if ($querydetails) {
                    $result_array = $querydetails->result_array();
                }
        
                foreach ($result_array as $row) {
                    $id = $row['idtbl_print_invoicedetail'];
        
                    $datadetail = array(
                        'status' => '3',
                        'updatedatetime'=> $updatedatetime
                    );
            
                    $this->db->where('idtbl_print_invoicedetail', $id);
                    $this->db->update('tbl_print_invoicedetail', $datadetail);
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
                    redirect('Invoice');
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
                    redirect('Invoice');
                }
            }

            if($type==4) {
                $data=array('status'=> '4',
                    'updateuser'=> $userID,
                    'updatedatetime'=> $updatedatetime);
    
                $this->db->where('idtbl_print_invoice', $recordID);
                $this->db->update('tbl_print_invoice', $data);


                $querydetails = $this->db->query("SELECT idtbl_print_invoicedetail,dispath_id FROM tbl_print_invoicedetail WHERE tbl_print_invoice_idtbl_print_invoice = $recordID");
                if ($querydetails) {
                    $result_array = $querydetails->result_array();
                }
        
                foreach ($result_array as $row) {
                    $dispath_id = $row['dispath_id'];
        
                    $datadetail = array(
                        'invoice_status' => '0',
                        'updatedatetime'=> $updatedatetime
                    );
            
                    $this->db->where('idtbl_print_dispatch', $dispath_id);
                    $this->db->update('tbl_print_dispatch', $datadetail);
                }


                $datasaleinfo=array('status'=> '3',
                'updateuser'=> $userID,
                'updatedatetime'=> $updatedatetime);

                $this->db->where('invno', $recordID);
                $this->db->update('tbl_sales_info', $datasaleinfo);


                                    // $querydetails = $this->db->query("SELECT idtbl_print_invoicedetail,dispath_id FROM tbl_print_invoicedetail WHERE tbl_print_invoice_idtbl_print_invoice = $recordID");
                                    // if ($querydetails) {
                                    //     $result_array = $querydetails->result_array();
                                    // }
                            
                                    // foreach ($result_array as $row) {
                                    //     $dispath_id = $row['dispath_id'];
                            
                                    //     $datadetail = array(
                                    //         'invoice_status' => '0',
                                    //         'updatedatetime'=> $updatedatetime
                                    //     );
                                
                                    //     $this->db->where('idtbl_print_dispatch', $dispath_id);
                                    //     $this->db->update('tbl_print_dispatch', $datadetail);
                                    // }

                            //         $tableData=$this->input->post('tableData');
                            //         foreach($tableData as $rowtabledata) {
                            //         $dispatchid=$rowtabledata['col_7'];

                            //         $data1 = array(
                            //             'invoice_status' => '1',
                            //             'updateuser'=> $userID, 
                            //             'updatedatetime'=> $updatedatetime
                            //     );
                        
                            //     $this->db->where('idtbl_print_dispatch', $dispatchid);
                            //     $this->db->update('tbl_print_dispatch', $data1);
                        

                            // }
                                    // $querydetails = $this->db->query("SELECT idtbl_print_invoicedetail FROM tbl_print_invoicedetail WHERE tbl_print_invoice_idtbl_print_invoice = $recordID");
                                    // if ($querydetails) {
                                    //     $result_array = $querydetails->result_array();
                                    // }
                            
                                    // foreach ($result_array as $row) {
                                    //     $id = $row['idtbl_print_invoicedetail'];
                            
                                    //     $datadetail = array(
                                    //         'status' => '3',
                                    //         'updatedatetime'=> $updatedatetime
                                    //     );
                                
                                    //     $this->db->where('idtbl_print_invoicedetail', $id);
                                    //     $this->db->update('tbl_print_invoicedetail', $datadetail);
                                    // }

                $this->db->trans_complete();
    
                if ($this->db->trans_status()===TRUE) {
                    $this->db->trans_commit();
    
                    $actionObj=new stdClass();
                    $actionObj->icon='fas fa-trash-alt';
                    $actionObj->title='';
                    $actionObj->message='Record Cancel Successfully';
                    $actionObj->url='';
                    $actionObj->target='_blank';
                    $actionObj->type='danger';
    
                    $actionJSON=json_encode($actionObj);
    
                    $this->session->set_flashdata('msg', $actionJSON);
                    redirect('Invoice');
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
                    redirect('Invoice');
                }
            }
        }
    
       
    
        // public function Getjobsaccodispatch() {
        //     $recordID=$this->input->post('recordID');
        //     // $itemreq_id=$this->input->post('grn_id');
    
        //     $this->db->select('*');
        //     $this->db->from('tbl_print_dispatchdetail');
        //     $this->db->where('status', 1);
        //     $this->db->where('tbl_print_dispatch_idtbl_print_dispatch', $recordID);
    
        //     $respond=$this->db->get();
    
        //     if($respond->num_rows()>0) {
        //         echo json_encode($respond->result());
        //     }
        // }
        
        public function Getjobsaccodispatch() {
            $recordID = $this->input->post('recordID');
            $branchID = $this->input->post('branchID');
            $companyID = $this->input->post('companyID');
        
            $this->db->select('*');
            $this->db->from('tbl_print_dispatchdetail');
            $this->db->join('tbl_print_dispatch', 'tbl_print_dispatchdetail.tbl_print_dispatch_idtbl_print_dispatch = tbl_print_dispatch.idtbl_print_dispatch');
            $this->db->where('tbl_print_dispatch.status', 1);
            $this->db->where('tbl_print_dispatch.invoice_status', 0);
            $this->db->where('tbl_print_dispatch.approvestatus', 1);
            $this->db->group_by('tbl_print_dispatchdetail.job_id');
            $this->db->where('tbl_print_dispatch.company_id', $companyID);
            $this->db->where('tbl_print_dispatch.company_branch_id', $branchID);
            $this->db->where('tbl_print_dispatch.customer_id', $recordID);
        
            $respond = $this->db->get();
        
            if ($respond->num_rows() > 0) {
                echo json_encode($respond->result());
            }
        }
        

        public function Getdispatchaccjob() {
        $recordID = $this->input->post('recordID');
        $branchID = $this->input->post('branchID');
        $companyID = $this->input->post('companyID');
        
        $this->db->select('*');
		$this->db->from('tbl_print_dispatchdetail');
        $this->db->join('tbl_print_dispatch', 'tbl_print_dispatchdetail.tbl_print_dispatch_idtbl_print_dispatch = tbl_print_dispatch.idtbl_print_dispatch');
        $this->db->join('tbl_print_invoicedetail', 'tbl_print_dispatchdetail.tbl_print_dispatch_idtbl_print_dispatch = tbl_print_invoicedetail.dispath_id', 'left');
        $this->db->where('tbl_print_dispatch.status', 1);
		$this->db->where('tbl_print_dispatchdetail.status', 1);
        $this->db->where('tbl_print_dispatch.approvestatus', 1);
        $this->db->where('tbl_print_dispatch.invoice_status', 0);

        $this->db->where('(tbl_print_invoicedetail.status = 3 OR tbl_print_invoicedetail.dispath_id IS NULL)');

        $this->db->where('tbl_print_dispatch.company_id', $companyID);
        $this->db->where('tbl_print_dispatch.company_branch_id', $branchID);
		$this->db->where('tbl_print_dispatchdetail.job_id', $recordID);
        
            $respond = $this->db->get();
        
            if ($respond->num_rows() > 0) {
                echo json_encode($respond->result());
            }
        }
    
        // public function Getqtyaccjob() {
        //     $recordID=$this->input->post('recordID');
        //     $dispatchID=$this->input->post('dispatchID');
    
        //     $this->db->select('*');
        //     $this->db->from('tbl_print_dispatchdetail');
        //     $this->db->where('status', 1);
        //     //$this->db->where('idtbl_customerinquiry_detail', $inqury_id);
        //     $this->db->where('idtbl_print_dispatchdetail', $recordID);
    
        //     $respond=$this->db->get();
    
        //     if($respond->num_rows()>0) {
        //         $obj=new stdClass();
        //         $obj->qty=$respond->row(0)->qty;
        //         $obj->unitprice=$respond->row(0)->unitprice;
        //         $obj->job_no=$respond->row(0)->job_no;
        //         $obj->detailsid=$respond->row(0)->idtbl_print_dispatchdetail;
        //         $obj->dispath_note=$respond->row(0)->tbl_print_dispatch_idtbl_print_dispatch;
        //         //$obj->batchno=$respond->row(0)->batchno;
        //     }
    
        //     echo json_encode($obj);
        // }

        public function Getqtyaccdispatch() {
            $recordID=$this->input->post('recordID');
            // $dispatchID=$this->input->post('dispatchID');
    
            $this->db->select('*');
            $this->db->from('tbl_print_dispatchdetail');
            $this->db->where('status', 1);
            //$this->db->where('idtbl_customerinquiry_detail', $inqury_id);
            $this->db->where('tbl_print_dispatch_idtbl_print_dispatch', $recordID);
    
            $respond=$this->db->get();
    
            if($respond->num_rows()>0) {
                $obj=new stdClass();
                $obj->qty=$respond->row(0)->qty;
                $obj->unitprice=$respond->row(0)->unitprice;
                $obj->job_no=$respond->row(0)->job_no;
                $obj->detailsid=$respond->row(0)->idtbl_print_dispatchdetail;
                $obj->uom=$respond->row(0)->measure_id;
                $obj->dispath_note=$respond->row(0)->tbl_print_dispatch_idtbl_print_dispatch;
            }
    
            echo json_encode($obj);
        }

        public function Getdispatchnote() {
            $recordID = $this->input->post('recordID');
        
            $this->db->select('*');
            $this->db->from('tbl_print_dispatchdetail');
            $this->db->join('tbl_print_dispatch', 'tbl_print_dispatchdetail.tbl_print_dispatch_idtbl_print_dispatch = tbl_print_dispatch.idtbl_print_dispatch');
            $this->db->where('tbl_print_dispatch.status', 1);
            $this->db->where('tbl_print_dispatch.idtbl_print_dispatch', $recordID);
        
            $respond = $this->db->get();
        
            if ($respond->num_rows() > 0) {
                echo json_encode($respond->result());
            }
        }
    
    
        public function Invoiceview() {
			$recordID=$this->input->post('recordID');
    
            $sql="SELECT `u`.*, `ua`.`name`, `ua`.`address_line1` AS `locemail` FROM `tbl_print_invoice` AS `u` LEFT JOIN `tbl_customer` AS `ua` ON (`ua`.`idtbl_customer` = `u`.`customer_id`)  WHERE `u`.`status`=? AND `u`.`idtbl_print_invoice`=?";
            $respond=$this->db->query($sql, array(1, $recordID));
    
            $this->db->select('tbl_print_invoicedetail.*,tbl_print_invoice.date, tbl_print_invoice.discount,tbl_print_invoice.vat_amount, tbl_print_invoice.total AS invoicetotal, tbl_customer_job_details.job_name');
            $this->db->from('tbl_print_invoicedetail');
            $this->db->join('tbl_print_invoice', 'tbl_print_invoice.idtbl_print_invoice = tbl_print_invoicedetail.tbl_print_invoice_idtbl_print_invoice', 'left');

            $this->db->join('tbl_customerinquiry_detail', 'tbl_customerinquiry_detail.idtbl_customerinquiry_detail = tbl_print_invoicedetail.job_id', 'left');
            $this->db->join('tbl_customer_job_details', 'tbl_customer_job_details.idtbl_customer_job_details = tbl_customerinquiry_detail.job_id', 'left');
           


            $this->db->where('tbl_print_invoicedetail.tbl_print_invoice_idtbl_print_invoice', $recordID);
            $this->db->where('tbl_print_invoicedetail.status', 1);
            $responddetail=$this->db->get();

            $discount=0;
            $vat_amount=0;
            $total=0;
            foreach ($responddetail->result() as $roworderinfo) {
                $discount=$roworderinfo->discount;
                $vat_amount=$roworderinfo->vat_amount;
                $total=$roworderinfo->invoicetotal;
             
            }

			$tblcharges='';

			$this->db->select('tbl_print_invoice_charge_detail.charge_amount,tbl_charges.charges_type');
			$this->db->from('tbl_print_invoice');
			$this->db->join('tbl_print_invoice_charge_detail', 'tbl_print_invoice.idtbl_print_invoice = tbl_print_invoice_charge_detail.tbl_print_invoice_idtbl_print_invoice', 'left');
			$this->db->join('tbl_charges', 'tbl_charges.idtbl_charges = tbl_print_invoice_charge_detail.charge_id', 'left');
		    $this->db->where('tbl_print_invoice.idtbl_print_invoice', $recordID);
            
			$chargesquery = $this->db->get();

			if ($chargesquery->num_rows() > 0) {
				$charges = $chargesquery->result_array();
			   
				foreach ($charges as $rowlist) {
					if ($rowlist['charge_amount'] != 0) {
						$tblcharges.='
						<tr>
							<td width="80%" style="text-align: right; font-weight: bold;">'.$rowlist['charges_type'] .'</td>
							<td width="20%" style="text-align: right; font-weight: bold;">Rs. ' . number_format($rowlist['charge_amount'], 2) . '</td>
						</tr>';
					}
				}
			}
			
    
            $html='';
$html = '
        <div class="row"></div>
        <div class="row">
            <div class="col-12">
                <hr>
                <table class="table table-striped table-bordered table-sm" id="viewtable">
                    <thead>
                        <th style="background-color: #c3faf6">Dispatch No</th>
                        <th style="background-color: #c3faf6">Job</th>
                        
                        <th style="background-color: #c3faf6">Job No</th>
                        <th style="background-color: #c3faf6">Qty</th>
                        <th style="background-color: #c3faf6" class="text-right">Unit Price</th>
                        <th style="background-color: #c3faf6" class="text-right">Total</th>
                        <th class="text-center d-none">Dispatch_id</th>  
                    </thead>
                    <tbody>';
                foreach ($responddetail->result() as $roworderinfo) {
                    $job = $roworderinfo->job_no;
                    $jobname = $roworderinfo->job;
                    $jobname_without_job = str_replace(" / $job", '', $jobname);
					$html .= '<tr>
								<td>' . $roworderinfo->dispatch_no . '</td>
								<td>' . $jobname_without_job . '</td>
                                
                                <td>' . $roworderinfo->job_no . '</td>
								<td>' . $roworderinfo->qty . '</td>
								<td class="text-right">' . $roworderinfo->unitprice . '</td>
								<td class="text-right">' . number_format(($roworderinfo->total), 2) . '</td>
                                <td class="text-center d-none ">' . $roworderinfo->dispath_id . '</td>
								
							</tr>';
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
							'.$tblcharges.'
							</tr>
							<tr>
								<td width="80%" style="text-align: right; font-weight: bold;">Discount</td>
								<td width="20%" style="text-align: right; font-weight: bold;">Rs. ' . number_format(($discount), 2) . '</td>
							</tr>
							<tr>
								<td width="80%" style="text-align: right; font-weight: bold;">Vat Amount</td>
								<td width="20%" style="text-align: right; font-weight: bold;">Rs. ' . number_format(($vat_amount), 2) . '</td>
							</tr>
							<tr>
								<td width="80%" style="text-align: right; font-weight: bold;"><strong><span style="color: black; font-size: 18px;">Final Price</span></strong></td>
								<td width="20%" style="text-align: right; font-weight: bold;"><span style="color: black; font-size: 18px;">Rs. ' . number_format(($total), 2) . '</span></td>
							</tr>

						</tbody>
					</table>

					</body>
					</html>';


echo $html;



    }
    
        public function Invoiceviewheader() {
            $recordID=$this->input->post('recordID');
    
            $this->db->select('tbl_print_invoice.*,tbl_customer.name AS customername,tbl_customer.telephone_no AS customercontact,tbl_customer.address_line1 AS address1,tbl_customer.address_line2 AS address2,tbl_customer.city AS city,tbl_customer.state AS state,
                                tbl_company.company AS companyname,tbl_company.address1 As companyaddress,tbl_company.mobile AS companymobile,
                                tbl_company.phone companyphone,tbl_company.email AS companyemail,
                                tbl_company_branch.branch AS branchname');
            $this->db->from('tbl_print_invoice');
            $this->db->join('tbl_customer', 'tbl_customer.idtbl_customer  = tbl_print_invoice.customer_id ', 'left');
            $this->db->join('tbl_company', 'tbl_company.idtbl_company = tbl_print_invoice.company_id', 'left');
            $this->db->join('tbl_company_branch', 'tbl_company_branch.idtbl_company_branch = tbl_print_invoice.company_branch_id', 'left');
            // $this->db->join('tbl_supplier_contact_details', 'tbl_supplier_contact_details.tbl_supplier_idtbl_supplier   = tbl_supplier.idtbl_supplier', 'left'); 
            $this->db->where('idtbl_print_invoice', $recordID);
            $this->db->where_in('tbl_print_invoice.status', array(1, 4));
            
    
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
    
    
        public function Approinvoice(){
            $this->db->trans_begin();
    
        $userID=$_SESSION['userid'];
        $recordID=$this->input->post('approvebtn');
		// $type=$this->input->post('reqestid');
        $disid=$this->input->post('dispatchid');
		$updatedatetime=date('Y-m-d H:i:s');
    
        $data=array('approvestatus'=> '1',
        'updateuser'=> $userID,
        'updatedatetime'=> $updatedatetime);

        $this->db->where('idtbl_print_invoice', $recordID);
        $this->db->update('tbl_print_invoice', $data);

        $tableData=$this->input->post('tableData');
        foreach($tableData as $rowtabledata) {
            $dispatchid=$rowtabledata['col_7'];

            $data1 = array(
                'invoice_status' => '1',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );
    
            $this->db->where('idtbl_print_dispatch', $dispatchid);
            $this->db->update('tbl_print_dispatch', $data1);
    

        }

    
                ////////////////////////////////////////////// Add Service Details for Chart of accounts tbl_expence_info //////////////////////////////////////////////////////////////////

			$this->db->select('tbl_print_invoice.idtbl_print_invoice,tbl_print_invoice.date, tbl_print_invoice.total,tbl_print_invoice.customer_id');
			$this->db->from('tbl_print_invoice');
			$this->db->where('tbl_print_invoice.status', 1);
			$this->db->where('tbl_print_invoice.idtbl_print_invoice', $recordID);

			$respond=$this->db->get();

			if ($respond->num_rows() > 0) {
				foreach ($respond->result() as $row) {
					$invoiceid=$row->idtbl_print_invoice;
					$totalamount=$row->total;
					$customer=$row->customer_id;
					$invoicedate=$row->date;
					// $orderType=$row->tbl_order_type_idtbl_order_type;

						$accountsData = array(
							'invdate' => $invoicedate,
							'tbl_customer_idtbl_customer' => $customer,
							'invno' => $invoiceid,
							'amount' => $totalamount,
							'status' => '1',
							'insertdatetime' => $updatedatetime,
							'tbl_user_idtbl_user' => $userID
						);
						// Insert the data into the 'tbl_print_stock' table
						$this->db->insert('tbl_sales_info', $accountsData);
					
				}
			}
    
            $this->db->trans_complete();
    
            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-save';
                $actionObj->title='';
                $actionObj->message='Invoice Confirm Successfully';
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
    

        public function Getcustomer() {
            $recordID=$this->input->post('recordID');
    
            $this->db->select('`customer_id`');
            $this->db->from('tbl_print_dispatch');
            $this->db->where('status', 1);
            $this->db->where('idtbl_print_dispatch', $recordID);
    
            $respond=$this->db->get();
    
            echo $respond->row(0)->customer_id;
        }

        // public function Getprocescharges() {
        //     $recordCurrentDate=$this->input->post('currentDate');
        //     $currentDate = date('Y-m-d');

        //     $this->db->select('*');
        //     $this->db->from('tbl_charges_detail');
        //     $this->db->join('tbl_charges', 'tbl_charges_detail.charges_type = tbl_charges.idtbl_charges', 'left');
        //     $this->db->where('tbl_charges_detail.status', 1);
        //     // $this->db->where('tbl_charges_detail.charges_type', 1);
        //     $this->db->where('tbl_charges_detail.charges_date <=', $recordCurrentDate);

        //     $this->db->group_start();
        //     $this->db->where('tbl_charges_detail.charges_effective >=', $recordCurrentDate);
        //     $this->db->or_where('tbl_charges_detail.charges_effective', NULL);
        //     $this->db->group_end();
    
        //     $respond = $this->db->get();

        //     $taxPercentage='';
        //     $row_count = $respond->num_rows();

        //     $data = array();
        //     $Process_Charges=0;
        //     $Ink_Charges=0;
        //     $Plate_Charges=0;
  
        //     if ($respond->num_rows() > 0) {
        //         for ($i = 0; $i < $row_count; $i++) {
        //             $row = $respond->row($i);
        //             $price = $row->price;
        //             $charges_type = $row->charges_type;

        //             if($charges_type=="Process Charges"){
        //                 $Process_Charges=$price;

        //             }else if($charges_type=="Ink Charges"){
        //                 $Ink_Charges=$price;
        //             }
        //             else if($charges_type=="Plate Charges"){
        //                 $Plate_Charges=$price;
        //             }

        //             $rowData = array(
        //                 'Process_Charges_Price' => $Process_Charges,
        //                 'Ink_Charges_Price' => $Ink_Charges,
        //                 'Plate_Charges_Price' => $Plate_Charges,
        //             );
            
        //             $data[] = $rowData;
        //         }
               
        //             $jsonResponse = json_encode($data[$row_count-1]);
        
        //     // Return JSON response
        //     echo $jsonResponse;
        //     } else {
        //         echo $taxPercentage=0;
        //     }

           
    
    
    
        // }

        // public function Getprocescharges() {
        //     $recordCurrentDate = $this->input->post('currentDate');
        //     $currentDate = date('Y-m-d');
        //     $useDate = ($recordCurrentDate == $currentDate) ? $currentDate : $recordCurrentDate;
        
        //     // Process charges for charges_type = 1
        //     $charge1 = $this->processChargesByType(1, $useDate);
        
        //     // Process charges for charges_type = 2
        //     $charge2 = $this->processChargesByType(2, $useDate);
        
        //     // Process charges for charges_type = 3
        //     $charge3 = $this->processChargesByType(3, $useDate);
        
        //     // Combine charges into an array
        //     $charges = array(
        //         'charge1' => $charge1,
        //         'charge2' => $charge2,
        //         'charge3' => $charge3
        //     );
        
        //     // Encode charges array into JSON format
        //     $jsonResponse = json_encode($charges);
        
        //     // Return JSON response
        //     echo $jsonResponse;
        // }
        
        
        // private function processChargesByType($charges_type, $useDate) {
        //     $this->db->select('*');
        //     $this->db->from('tbl_charges_detail');
        //     $this->db->join('tbl_charges', 'tbl_charges_detail.charges_type = tbl_charges.idtbl_charges', 'left');
        //     $this->db->where('tbl_charges_detail.status', 1);
        //     $this->db->where('tbl_charges_detail.charges_type', $charges_type);
        //     $this->db->where("DATE(charges_date) <=", $useDate);
        //     $this->db->where("(DATE(charges_effective) >= '$useDate' OR charges_effective IS NULL)");
        
        //     $respond = $this->db->get();
        //     $chargevalue = 0; // Default value
        
        //     if ($respond->num_rows() > 0) {
        //                 $chargevalue = $respond->row()->price;
        //                 $chargevalueA = null;
        //                 $chargevalueB = null;
        //                 $chargevalueC = null;
        //                 //$obj=new stdClass();
        //                 // $obj->chargevalue=$respond->row(0)->price;
            
        //             switch ($charges_type) {
        //                 case 1:
        //                     // Custom processing for charges_type = 1
        //                     $chargevalueA = ($chargevalue !== null && $chargevalue !== 0) ? $chargevalue : 0;

        //                     break;
        //                 case 2:
        //                     $chargevalueB = ($chargevalue !== null && $chargevalue !== 0) ? $chargevalue : 0;

        //                     break;
        //                 case 3:
        //                    $chargevalueC = ($chargevalue !== null && $chargevalue !== 0) ? $chargevalue : 0;

        //                     break;
        //                 default:
        //                     echo "Invalid charges_type";
        //             }
        //         }
        //         return array($chargevalueA, $chargevalueB, $chargevalueC);
        // }

        // public function Issuepdf($x)
        // {
    
        //     $recordID = $x;
    
        //     $this->db->select('tbl_print_issuedetail.*, tbl_print_issue.ordertype, tbl_order_type.type, tbl_location.location, departments.name, tbl_print_issue.idtbl_print_issue');
        //     $this->db->from('tbl_print_issuedetail');
        //     $this->db->join('tbl_print_issue', 'tbl_print_issuedetail.tbl_print_issue_idtbl_print_issue = tbl_print_issue.idtbl_print_issue', 'left');
        //     $this->db->join('tbl_order_type', 'tbl_print_issue.ordertype = tbl_order_type.idtbl_order_type', 'left');
    
        //     $this->db->join('tbl_location', 'tbl_print_issue.location_id = tbl_location.idtbl_location', 'left');
        //     $this->db->join('departments', 'tbl_print_issue.department_id = departments.id', 'left');
    
        //     $this->db->where('tbl_print_issuedetail.tbl_print_issue_idtbl_print_issue', $recordID);
        //     $this->db->where('tbl_print_issuedetail.status', 1);
    
        //     $responddetail = $this->db->get();
        //     if ($responddetail ->num_rows() > 0) {
        //         $row = $responddetail ->row();
        //         $ordertype = $row->type;
        //         $location = $row->location;
        //         $name = $row->name;
        //         $idtbl_print_issue = $row->idtbl_print_issue;
                
        //     }
    
        //     $sub_total_amount = 0;
        //     $path = 'images/book.jpg';
        //     $type = pathinfo($path, PATHINFO_EXTENSION);
        //     $data = file_get_contents($path);
        //     $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    
        //     $this->load->library('pdf');
    
        //     $fontDir = 'fonts/';
        //     $options = new Options();
        //     $options->set('fontDir', $fontDir);
        //     $options->set('isPhpEnabled', true);
        //     $dompdf = new Dompdf($options);
    
        //     $html = '
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
        //                                 <th class="thc" width="25%" style="text-align:right;">Total</th>
        //                             </tr>
        //                         </thead>
        //                         <tbody class="tdc">';
    
        //                         foreach ($responddetail->result() as $roworderinfo) {
        //                             $total = ($roworderinfo->qty * $roworderinfo->unitprice);
        //                             $html .= '
        //                                 <tr>
                                        
        //                                     <td class="tdc" style="text-align:center;">' . $roworderinfo->qty . '</td>
        //                                     <td class="tdc" style="text-align:right;">' .  number_format($roworderinfo->unitprice, 2) . '</td>
        //                                     <td class="tdc" style="text-align:right;">' . number_format($total, 2) . '</td></tr>
        //                                 </tr>
        //                                 ';
    
        //                                 $sub_total_amount +=  $total;
        //                              }
                                    
        //                               $html .= '<tr>
        //                                 <td colspan="2" style="text-align:right; padding-right:5px"><b>Sub Total</b></td>
        //                                 <td class="tdc" style="text-align:right;">'.number_format($sub_total_amount, 2) .'</td>
        //                             </tr>
        //                         </tbody>
        //                     </table>
        //                 </td>
        //             </tr>
    
        //         </table>
        //     </body>
        //     </html>
        //     ';
    
        //     // $dompdf = new Dompdf();
        //     $dompdf->loadHtml($html);
        //     $dompdf->setPaper('A4', 'portrait');
        //     $dompdf->render();
        //     $dompdf->stream("Purchase Order Request - ", ["Attachment" => 0]);
        // }
	
}