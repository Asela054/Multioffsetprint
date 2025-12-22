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
    
	public function Gedispatch() {
		$this->db->select('`idtbl_print_dispatch`');
		$this->db->from('tbl_print_dispatch');
		$this->db->where('status', 1);
		$this->db->where('status', 1);

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

        $comapnyID=$_SESSION['company_id'];

        $this->db->select('tbl_customer.idtbl_customer, tbl_customer.customer');
        $this->db->from('tbl_customer');
        $this->db->join('tbl_print_dispatch', 'tbl_print_dispatch.tbl_customer_idtbl_customer = tbl_customer.idtbl_customer', 'left');
        $this->db->where('tbl_print_dispatch.status', 1);
        $this->db->where('tbl_customer.status', 1);
        $this->db->where('tbl_customer.tbl_company_idtbl_company', $comapnyID);
        $this->db->group_by('tbl_print_dispatch.tbl_customer_idtbl_customer');
    
        return $this->db->get();
    }

    public function getCustomerVatStatus() {
        $customer_id = $this->input->post('customer_id');
        $this->db->select('vat_customer');
        $this->db->from('tbl_customer');
        $this->db->where('idtbl_customer', $customer_id);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            $response = array('vat_customer' => $query->row()->vat_customer);
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
        } else {
            $response = array('vat_customer' => '0');
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
        }
    }
    
    public function Invoiceinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $companyID=$_SESSION['company_id'];

        $tableData=$this->input->post('tableData');
        $chargestableData=$this->input->post('chargestableData');
        $date=$this->input->post('date');
        $ink_charges=$this->input->post('ink_charges');
        $plate_charges=$this->input->post('plate_charges');
        $proces_charges=$this->input->post('proces_charges');
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
            'tbl_company_idtbl_company'=> $company_id, 
            'tbl_company_branch_idtbl_company_branch'=> $branch_id, 
            'approvestatus'=> '0',
            'status'=> '1',
            'insertdatetime'=> $updatedatetime,
            'tbl_user_idtbl_user'=> $userID,
            'tbl_customer_idtbl_customer'=> $customer
        );

        $this->db->insert('tbl_print_invoice', $data);

        $invoiceID=$this->db->insert_id();

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
            
            
            $inquerydetailsid=$rowtabledata['col_6'];

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
                'tbl_user_idtbl_user'=> $userID,
                'tbl_print_invoice_idtbl_print_invoice'=> $invoiceID,
                'tbl_measurements_idtbl_measurements'=> $uom_id,
                'tbl_print_dispatch_idtbl_print_dispatch'=> $dispath_noteid
            );

            $this->db->insert('tbl_print_invoicedetail', $dataone);
        }


        $chargestableData = $this->input->post('chargestableData');

        if (!empty($chargestableData)) {
            foreach ($chargestableData as $rowtabledata) {
                $typeid = $rowtabledata['col_3'];
                $amount = $rowtabledata['col_2'];
    
                $dataone = array(
                    'charge_id' => $typeid,
                    'charge_amount' => $amount,
                    'status' => '1',
                    'insertdatetime' => $updatedatetime,
                    'tbl_print_invoice_idtbl_print_invoice' => $invoiceID,
                    'tbl_user_idtbl_user'=> $userID
                );
    
                $this->db->insert('tbl_print_invoice_charge_detail', $dataone);
            }
        }
            
    	// Generate the Invoice NO
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

		$this->db->select('inv_no');
		$this->db->from('tbl_print_invoice');
		$this->db->where('tbl_company_idtbl_company', $companyID);
        $this->db->where("DATE(insertdatetime) >=", $fromyear);
        $this->db->where("DATE(insertdatetime) <=", $toyear);
		$this->db->order_by('inv_no', 'DESC');
		$this->db->limit(1);
		$respond = $this->db->get();
		
		if ($respond->num_rows() > 0) {
			$last_inv_no = $respond->row()->inv_no;
			$inv_no = intval(substr($last_inv_no, -4));
			$count = $inv_no;
		} else {
			$count = 0;
		}

		$count++; 
		$countPrefix = sprintf('%04d', $count);

		$yearDigit = substr(date("Y", strtotime($fromyear)), -2);

		$reqno = 'INV' . $yearDigit . $countPrefix;

		$datadetail = array(
			'inv_no'=> $reqno, 
			'updatedatetime'=> $updatedatetime
		);

		$this->db->where('idtbl_print_invoice', $invoiceID);
		$this->db->update('tbl_print_invoice', $datadetail);

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


            $querydetails = $this->db->query("SELECT idtbl_print_invoicedetail,tbl_print_dispatch_idtbl_print_dispatch FROM tbl_print_invoicedetail WHERE tbl_print_invoice_idtbl_print_invoice = $recordID");
            if ($querydetails) {
                $result_array = $querydetails->result_array();
            }
    
            foreach ($result_array as $row) {
                $dispath_id = $row['tbl_print_dispatch_idtbl_print_dispatch'];
    
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
        $this->db->where('tbl_print_dispatch.tbl_company_idtbl_company', $companyID);
        $this->db->where('tbl_print_dispatch.tbl_company_branch_idtbl_company_branch', $branchID);
        $this->db->where('tbl_print_dispatch.tbl_customer_idtbl_customer', $recordID);
    
        $respond = $this->db->get();
    
        if ($respond->num_rows() > 0) {
            echo json_encode($respond->result());
        }
    }
        

    public function Getdispatchaccjob() {
        $recordID = $this->input->post('recordID');
        $branchID = $this->input->post('branchID');
        $companyID = $this->input->post('companyID');
        
        $this->db->select('tbl_print_dispatchdetail.*, tbl_print_dispatch.dispatch_no');
		$this->db->from('tbl_print_dispatchdetail');
        $this->db->join('tbl_print_dispatch', 'tbl_print_dispatchdetail.tbl_print_dispatch_idtbl_print_dispatch = tbl_print_dispatch.idtbl_print_dispatch');
        $this->db->join('tbl_print_invoicedetail', 'tbl_print_dispatchdetail.tbl_print_dispatch_idtbl_print_dispatch = tbl_print_invoicedetail.tbl_print_dispatch_idtbl_print_dispatch', 'left');
        $this->db->where('tbl_print_dispatch.status', 1);
		$this->db->where('tbl_print_dispatchdetail.status', 1);
        $this->db->where('tbl_print_dispatch.approvestatus', 1);
        $this->db->where('tbl_print_dispatch.invoice_status', 0);

        $this->db->where('(tbl_print_invoicedetail.status = 3 OR tbl_print_invoicedetail.tbl_print_dispatch_idtbl_print_dispatch IS NULL)');

        $this->db->where('tbl_print_dispatch.tbl_company_idtbl_company', $companyID);
        $this->db->where('tbl_print_dispatch.tbl_company_branch_idtbl_company_branch', $branchID);
		$this->db->where('tbl_print_dispatchdetail.job_id', $recordID);
        
        $respond = $this->db->get();
        
        if ($respond->num_rows() > 0) {
            echo json_encode($respond->result());
        } else {
            echo json_encode([]);
        }
    }


    public function Getqtyaccdispatch() {
        $recordID=$this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('tbl_print_dispatchdetail');
        $this->db->where('status', 1);
        $this->db->where('tbl_print_dispatch_idtbl_print_dispatch', $recordID);

        $respond=$this->db->get();

        if($respond->num_rows()>0) {
            $obj=new stdClass();
            $obj->qty=$respond->row(0)->qty;
            $obj->unitprice=$respond->row(0)->unitprice;
            $obj->job_no=$respond->row(0)->job_no;
            $obj->detailsid=$respond->row(0)->idtbl_print_dispatchdetail;
            $obj->uom=$respond->row(0)->tbl_measurements_idtbl_measurements;
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

        $sql="SELECT `u`.*, `ua`.`customer`, `ua`.`address_line1` AS `locemail` FROM `tbl_print_invoice` AS `u` LEFT JOIN `tbl_customer` AS `ua` ON (`ua`.`idtbl_customer` = `u`.`tbl_customer_idtbl_customer`)  WHERE `u`.`status`=? AND `u`.`idtbl_print_invoice`=?";
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
                                <td>' . $jobname . '</td>
                                
                                <td>' . $roworderinfo->job_no . '</td>
                                <td>' . $roworderinfo->qty . '</td>
                                <td class="text-right">' . $roworderinfo->unitprice . '</td>
                                <td class="text-right">' . number_format(($roworderinfo->total), 2) . '</td>
                                <td class="text-center d-none ">' . $roworderinfo->tbl_print_dispatch_idtbl_print_dispatch . '</td>
                                
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

        $this->db->select('tbl_print_invoice.*,tbl_customer.customer AS customername,tbl_customer.telephone_no AS customercontact,tbl_customer.address_line1 AS address1,tbl_customer.address_line2 AS address2,tbl_customer.city AS city,tbl_customer.state AS state,
                            tbl_company.company AS companyname,tbl_company.address1 As companyaddress,tbl_company.mobile AS companymobile,
                            tbl_company.phone companyphone,tbl_company.email AS companyemail,
                            tbl_company_branch.branch AS branchname');
        $this->db->from('tbl_print_invoice');
        $this->db->join('tbl_customer', 'tbl_customer.idtbl_customer  = tbl_print_invoice.tbl_customer_idtbl_customer ', 'left');
        $this->db->join('tbl_company', 'tbl_company.idtbl_company = tbl_print_invoice.tbl_company_idtbl_company', 'left');
        $this->db->join('tbl_company_branch', 'tbl_company_branch.idtbl_company_branch = tbl_print_invoice.tbl_company_branch_idtbl_company_branch', 'left');
        $this->db->where('idtbl_print_invoice', $recordID);
        $this->db->where_in('tbl_print_invoice.status', array(1, 4));
        

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->date=$respond->row(0)->date;
        $obj->invo_no=$respond->row(0)->inv_no;
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
        $userID = $_SESSION['userid'];
        $company = $_SESSION['company_id'];
        $branch = $_SESSION['branch_id'];
        $recordID = $this->input->post('invoiceid');
        $disid = $this->input->post('reqestid');
        $confirmnot=$this->input->post('confirmnot');
        $updatedatetime = date('Y-m-d H:i:s');

        $obj = new stdClass();
        $actionObj = new stdClass();
    
         try {
            $this->db->trans_begin();
    
            if ($confirmnot == 1) {
                $data = array(
                    'approvestatus' => $confirmnot,
                    'updateuser' => $userID,
                    'updatedatetime' => $updatedatetime
                );
            
                $this->db->where('idtbl_print_invoice', $recordID);
                $this->db->update('tbl_print_invoice', $data);

                $data1 = array(
                    'invoice_status' => '1',
                    'updateuser' => $userID, 
                    'updatedatetime' => $updatedatetime
                );
        
                $this->db->where('idtbl_print_dispatch', $disid);
                $this->db->update('tbl_print_dispatch', $data1);                

                $this->db->select('tbl_print_invoice.idtbl_print_invoice,tbl_print_invoice.date, tbl_print_invoice.total, tbl_print_invoice.tbl_customer_idtbl_customer,tbl_print_invoice.inv_no, tbl_print_invoice.vat_amount,tbl_print_invoice.subtotal,tbl_customer.vat_customer');
                $this->db->from('tbl_print_invoice');
                $this->db->join('tbl_customer', 'tbl_print_invoice.tbl_customer_idtbl_customer = tbl_customer.idtbl_customer');
                $this->db->where('tbl_print_invoice.status', 1);
                $this->db->where('tbl_print_invoice.idtbl_print_invoice', $recordID);
                $respond = $this->db->get();

         
            }
            else{
                $data = array(
                    'approvestatus' => $confirmnot,
                    'updateuser' => $userID,
                    'updatedatetime' => $updatedatetime
                );
            
                $this->db->where('idtbl_print_invoice', $recordID);
                $this->db->update('tbl_print_invoice', $data);
            }

            $this->db->trans_commit();
    
            $actionObj->icon = 'fas fa-check-circle';
            $actionObj->title = '';
            $actionObj->message = ($confirmnot == 1) ? 'Invoice Confirmed Successfully' : 'Record Rejected Successfully';
            $actionObj->url = '';
            $actionObj->target = '_blank';
            $actionObj->type = 'success';
    
            $obj->status = 1;
            $obj->action = json_encode($actionObj);
        } catch (Exception $e) {
            $this->db->trans_rollback();
            
            error_log("GRNVoucherapprove Error: " . $e->getMessage());
            
            $actionObj->icon = 'fas fa-exclamation-triangle';
            $actionObj->title = '';
            $actionObj->message = 'Operation Failed: ' . $e->getMessage();
            $actionObj->url = '';
            $actionObj->target = '_blank';
            $actionObj->type = 'danger';
    
            $obj->status = 0;
            $obj->action = json_encode($actionObj);
        }
    
        echo json_encode($obj);
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
	
    public function Invoicecheckstatus() {
		$this->db->trans_begin();

        $recordID=$this->input->post('requestid');
		$confirmnot=$this->input->post('confirmnot');
		$userID=$_SESSION['userid'];
		$updatedatetime=date('Y-m-d H:i:s');

			$data=array(
				'check_by'=> $userID);

			$this->db->where('idtbl_print_invoice', $recordID);
			$this->db->update('tbl_print_invoice', $data);


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