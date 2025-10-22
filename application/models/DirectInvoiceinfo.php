<?php
use Dompdf\Dompdf;
use Dompdf\Options;
class DirectInvoiceinfo extends CI_Model{
    public function Getdispatchlist() {
        $this->db->select('`idtbl_direct_dispatch`, `dispatch_no`');
        $this->db->from('tbl_direct_dispatch');
        $this->db->where('invoice_status', 0);
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Getchargetype(){
        $this->db->select('`idtbl_charges`, `charges_type`');
        $this->db->from('tbl_charges');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Getmateriallist() {
        $recordID = $this->input->post('recordID');

        $this->db->select('tbl_print_material_info.idtbl_print_material_info, tbl_print_material_info.materialname, tbl_direct_dispatchdetail.batchno');
        $this->db->from('tbl_direct_dispatchdetail');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_direct_dispatchdetail.tbl_print_material_info_idtbl_print_material_info');
        $this->db->where('tbl_direct_dispatchdetail.status', 1);
        $this->db->where('tbl_direct_dispatchdetail.tbl_direct_dispatch_idtbl_direct_dispatch', $recordID);
        
        $response = $this->db->get();
        
        if ($response->num_rows() > 0) {
            $materials = $response->result();
            $result = array();
            
            foreach ($materials as $material) {
                $result[] = [
                    'id' => $material->idtbl_print_material_info,
                    'material' => $material->materialname,
                    'batchno' => $material->batchno
                ];
            }
            
            echo json_encode($result);
        } else {
            echo json_encode([]);
        }
    }

    public function Getdispatchdetails() {
        $recordID = $this->input->post('recordID');
        $dispatchID = $this->input->post('dispatchID');

        $this->db->select('tbl_measurements.idtbl_mesurements, tbl_measurements.measure_type, tbl_direct_dispatchdetail.qty');
        $this->db->from('tbl_direct_dispatchdetail');
        $this->db->join('tbl_measurements', 'tbl_measurements.idtbl_mesurements = tbl_direct_dispatchdetail.tbl_measurements_idtbl_mesurements');
        $this->db->where('tbl_direct_dispatchdetail.status', 1);
        $this->db->where('tbl_direct_dispatchdetail.tbl_print_material_info_idtbl_print_material_info', $recordID);
        $this->db->where('tbl_direct_dispatchdetail.tbl_direct_dispatch_idtbl_direct_dispatch', $dispatchID);
        
        $response = $this->db->get();
        
        if ($response->num_rows() > 0) {
            $dispatchdetails = $response->result();
            $result = array();
            
            foreach ($dispatchdetails as $dispatch) {
                $result[] = [
                    'id' => $dispatch->idtbl_mesurements,
                    'type' => $dispatch->measure_type,
                    'material' => $dispatch->qty
                ];
            }
            
            echo json_encode($result);
        } else {
            echo json_encode([]);
        }
    }

    public function Getunitprice() {
        $recordID = $this->input->post('recordID');
        $batchno = $this->input->post('batchno');

        $this->db->select('tbl_print_stock.saleprice');
        $this->db->from('tbl_print_stock');
        $this->db->where('tbl_print_stock.status', 1);
        $this->db->where('tbl_print_stock.tbl_print_material_info_idtbl_print_material_info', $recordID);
        $this->db->where('tbl_print_stock.batchno', $batchno);
        
        $response = $this->db->get();
        
        if ($response->num_rows() > 0) {
            $pricedetails = $response->result();
            $result = array();
            
            foreach ($pricedetails as $price) {
                $result[] = [
                    'saleprice' => $price->saleprice
                ];
            }
            
            echo json_encode($result);
        } else {
            echo json_encode([]);
        }
    }  
    public function DirectInvoiceinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $companyID=$_SESSION['company_id'];
        $branchID=$_SESSION['branch_id'];

        $tableData=$this->input->post('tableData');
        $chargestableData=$this->input->post('chargestableData');
        $date=$this->input->post('date');
        $dispatch_note=$this->input->post('dispatch_note');
        $total=$this->input->post('total');
        $subtotal=$this->input->post('subtotal');
        $vat=$this->input->post('vat');
        $discount=$this->input->post('discount');
        $vatamount=$this->input->post('vatamount');
        $remark=$this->input->post('remark');
        $updatedatetime=date('Y-m-d H:i:s');
    
        $data=array(
            'date'=> $date,
            'total'=> $total,
            'subtotal'=> $subtotal,
            'vat'=> $vat,
            'vat_amount'=> $vatamount,
            'discount'=> $discount,
            'remark'=> $remark,
            'approvestatus'=> '0',
            'paymentcomplete'=> '0',
            'status'=> '1',
            'check_by'=> '0',
            'insertdatetime'=> $updatedatetime,
            'tbl_user_idtbl_user'=> $userID,
            'tbl_company_idtbl_company'=> $companyID, 
            'tbl_company_branch_idtbl_company_branch'=> $branchID, 
            'tbl_direct_dispatch_idtbl_direct_dispatch'=> $dispatch_note
        );
    
        $this->db->insert('tbl_direct_invoice', $data);
    
        $invoiceID=$this->db->insert_id();
    
        foreach($tableData as $rowtabledata) {
            $materialId=$rowtabledata['col_2'];
            $qty=$rowtabledata['col_3'];
            $uom_id=$rowtabledata['col_5'];
            $unitprice=$rowtabledata['col_6'];
            $total=$rowtabledata['col_7'];
            
            
            $inquerydetailsid=$rowtabledata['col_6'];

            $dataone=array(
                'date'=> $date,
                'qty'=> $qty,
                'unitprice'=> $unitprice,
                'total'=> $total,
                'status'=> '1',
                'insertdatetime'=> $updatedatetime,
                'tbl_user_idtbl_user'=> $userID,
                'tbl_direct_invoice_idtbl_direct_invoice'=> $invoiceID,
                'tbl_print_material_info_idtbl_print_material_info'=> $materialId,
                'tbl_measurements_idtbl_mesurements'=> $uom_id
            );

            $this->db->insert('tbl_direct_invoicedetail', $dataone);
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
                    'tbl_direct_invoice_idtbl_direct_invoice' => $invoiceID,
                    'tbl_user_idtbl_user'=> $userID
                );
    
                $this->db->insert('tbl_direct_invoice_othercharges', $dataone);
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
        $this->db->from('tbl_direct_invoice');
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

        $this->db->where('idtbl_direct_invoice', $invoiceID);
        $this->db->update('tbl_direct_invoice', $datadetail);

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

    public function DirectInvoicestatus($x, $y) {
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $recordID=$x;
        $type=$y;
        $updatedatetime=date('Y-m-d H:i:s');

        if($type==3) {
            $data=array('status'=> '3',
                'updateuser'=> $userID,
                'updatedatetime'=> $updatedatetime);

            $this->db->where('idtbl_direct_invoice', $recordID);
            $this->db->update('tbl_direct_invoice', $data);


            $querydetails = $this->db->query("SELECT idtbl_direct_invoicedetail FROM tbl_direct_invoicedetail WHERE tbl_direct_invoice_idtbl_direct_invoice = $recordID");
            if ($querydetails) {
                $result_array = $querydetails->result_array();
            }
    
            foreach ($result_array as $row) {
                $id = $row['idtbl_direct_invoicedetail'];
    
                $datadetail = array(
                    'status' => '3',
                    'updatedatetime'=> $updatedatetime
                );
        
                $this->db->where('idtbl_direct_invoicedetail', $id);
                $this->db->update('tbl_direct_invoicedetail', $datadetail);
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
                redirect('DirectInvoice');
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
                redirect('DirectInvoice');
            }
        }

        if($type==4) {
            $data=array('status'=> '4',
                'updateuser'=> $userID,
                'updatedatetime'=> $updatedatetime);

            $this->db->where('idtbl_direct_invoice', $recordID);
            $this->db->update('tbl_direct_invoice', $data);


            $querydetails = $this->db->query("SELECT tbl_direct_invoicedetail.idtbl_direct_invoicedetail,tbl_direct_invoice.tbl_direct_dispatch_idtbl_direct_dispatch FROM tbl_direct_invoicedetail JOIN tbl_direct_invoice ON tbl_direct_invoice.idtbl_direct_invoice=tbl_direct_invoicedetail.tbl_direct_invoice_idtbl_direct_invoice WHERE tbl_direct_invoice_idtbl_direct_invoice = $recordID");
            if ($querydetails) {
                $result_array = $querydetails->result_array();
            }
    
            foreach ($result_array as $row) {
                $dispath_id = $row['tbl_direct_dispatch_idtbl_direct_dispatch'];
    
                $datadetail = array(
                    'invoice_status' => '0',
                    'updatedatetime'=> $updatedatetime
                );
        
                $this->db->where('idtbl_direct_dispatch', $dispath_id);
                $this->db->update('tbl_direct_dispatch', $datadetail);
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
                redirect('DirectInvoice');
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
                redirect('DirectInvoice');
            }
        }
    }

    public function DirectInvoiceview() {
        $recordID=$this->input->post('recordID');

        $sql="SELECT `u`.*, `ub`.`customer`, `ub`.`address_line1` AS `locemail` FROM `tbl_direct_invoice` AS `u` LEFT JOIN `tbl_direct_dispatch` AS `ua` ON (`ua`.`idtbl_direct_dispatch` = `u`.`tbl_direct_dispatch_idtbl_direct_dispatch`) LEFT JOIN `tbl_customer` AS `ub` ON (`ub`.`idtbl_customer` = `ua`.`tbl_customer_idtbl_customer`)  WHERE `u`.`status`=? AND `u`.`idtbl_direct_invoice`=?";
        $respond=$this->db->query($sql, array(1, $recordID));

        $this->db->select('tbl_direct_invoicedetail.*,tbl_direct_invoice.date, tbl_direct_invoice.discount,tbl_direct_invoice.vat_amount, tbl_direct_invoice.total AS invoicetotal, tbl_print_material_info.materialname');
        $this->db->from('tbl_direct_invoicedetail');
        $this->db->join('tbl_direct_invoice', 'tbl_direct_invoice.idtbl_direct_invoice = tbl_direct_invoicedetail.tbl_direct_invoice_idtbl_direct_invoice', 'left');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_direct_invoicedetail.tbl_print_material_info_idtbl_print_material_info', 'left');
        $this->db->where('tbl_direct_invoicedetail.tbl_direct_invoice_idtbl_direct_invoice', $recordID);
        $this->db->where('tbl_direct_invoicedetail.status', 1);
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

        $this->db->select('tbl_direct_invoice_othercharges.charge_amount,tbl_charges.charges_type');
        $this->db->from('tbl_direct_invoice');
        $this->db->join('tbl_direct_invoice_othercharges', 'tbl_direct_invoice.idtbl_direct_invoice = tbl_direct_invoice_othercharges.tbl_direct_invoice_idtbl_direct_invoice', 'left');
        $this->db->join('tbl_charges', 'tbl_charges.idtbl_charges = tbl_direct_invoice_othercharges.charge_id', 'left');
        $this->db->where('tbl_direct_invoice.idtbl_direct_invoice', $recordID);
        
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
                        <th style="background-color: #c3faf6">Material</th>
                        <th style="background-color: #c3faf6">Qty</th>
                        <th style="background-color: #c3faf6" class="text-right">Unit Price</th>
                        <th style="background-color: #c3faf6" class="text-right">Total</th>
                    </thead>
                    <tbody>';
                foreach ($responddetail->result() as $roworderinfo) {
                    $html .= '<tr>
                                <td>' . $roworderinfo->materialname . '</td>
                                <td>' . $roworderinfo->qty . '</td>
                                <td class="text-right">' . $roworderinfo->unitprice . '</td>
                                <td class="text-right">' . number_format(($roworderinfo->total), 2) . '</td>
                                
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

    public function DirectInvoiceviewheader() {
        $recordID=$this->input->post('recordID');

        $this->db->select('tbl_direct_invoice.*,tbl_customer.customer AS customername,tbl_customer.telephone_no AS customercontact,tbl_customer.address_line1 AS address1,tbl_customer.address_line2 AS address2,tbl_customer.city AS city,tbl_customer.state AS state,
                            tbl_company.company AS companyname,tbl_company.address1 As companyaddress,tbl_company.mobile AS companymobile,
                            tbl_company.phone companyphone,tbl_company.email AS companyemail,
                            tbl_company_branch.branch AS branchname');
        $this->db->from('tbl_direct_invoice');
        $this->db->join('tbl_direct_dispatch', 'tbl_direct_dispatch.idtbl_direct_dispatch  = tbl_direct_invoice.tbl_direct_dispatch_idtbl_direct_dispatch ', 'left');
        $this->db->join('tbl_customer', 'tbl_customer.idtbl_customer  = tbl_direct_dispatch.tbl_customer_idtbl_customer ', 'left');
        $this->db->join('tbl_company', 'tbl_company.idtbl_company = tbl_direct_invoice.tbl_company_idtbl_company', 'left');
        $this->db->join('tbl_company_branch', 'tbl_company_branch.idtbl_company_branch = tbl_direct_invoice.tbl_company_branch_idtbl_company_branch', 'left');
        $this->db->where('idtbl_direct_invoice', $recordID);
        $this->db->where_in('tbl_direct_invoice.status', array(1, 4));
        

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


    public function Approdirectinvoice(){
        $this->db->trans_begin();
    
        $userID = $_SESSION['userid'];
        $company = $_SESSION['company_id'];
        $branch = $_SESSION['branch_id'];
        $recordID = $this->input->post('invoiceid');
        $disid = $this->input->post('reqestid');
        $confirmnot=$this->input->post('confirmnot');
        $updatedatetime = date('Y-m-d H:i:s');
    
        $data = array(
            'approvestatus' => $confirmnot,
            'updateuser' => $userID,
            'updatedatetime' => $updatedatetime
        );
    
        $this->db->where('idtbl_direct_invoice', $recordID);
        $this->db->update('tbl_direct_invoice', $data);
    
            $data1 = array(
                'invoice_status' => '1',
                'updateuser' => $userID, 
                'updatedatetime' => $updatedatetime
            );
    
            $this->db->where('idtbl_direct_dispatch', $disid);
            $this->db->update('tbl_direct_dispatch', $data1);
    
        $this->db->select('tbl_direct_invoice.idtbl_direct_invoice,tbl_direct_invoice.date, tbl_direct_invoice.total,
                            tbl_direct_dispatch.tbl_customer_idtbl_customer,tbl_direct_invoice.inv_no,
                            tbl_direct_invoice.vat_amount,tbl_direct_invoice.subtotal,tbl_customer.vat_customer');
        $this->db->from('tbl_direct_invoice');
        $this->db->join('tbl_direct_dispatch', 'tbl_direct_dispatch.idtbl_direct_dispatch  = tbl_direct_invoice.tbl_direct_dispatch_idtbl_direct_dispatch ', 'left');
        $this->db->join('tbl_customer', 'tbl_customer.idtbl_customer  = tbl_direct_dispatch.tbl_customer_idtbl_customer ', 'left');
        $this->db->where('tbl_direct_invoice.status', 1);
        $this->db->where('tbl_direct_invoice.idtbl_direct_invoice', $recordID);
    
        $respond = $this->db->get();
    
        if ($respond->num_rows() > 0) {
            foreach ($respond->result() as $row) {
                $invoiceid = $row->idtbl_direct_invoice;
                $totalamount = $row->total;
                $customer = $row->tbl_customer_idtbl_customer;
                $invoicedate = $row->date;
                $invoicenum = $row->inv_no;
                $vatamount = $row->vat_amount;
                $grossamount = $row->subtotal;
                $customer_type = $row->vat_customer;
    
                $accountsData = array(
                    'saletype' => '1',
                    'salecode' => 'INV',
                    'invno' => $invoicenum,
                    'manual_invno' => '',
                    'invdate' => $invoicedate,
                    'sub_total' => $grossamount,
                    'vat' => $vatamount,
                    'amount' => $totalamount,
                    'status' => '1',   
                    'insertdatetime' => $updatedatetime,
                    'tbl_user_idtbl_user' => $userID,
                    'tbl_customer_idtbl_customer' => $customer,
                    'tbl_company_idtbl_company' => $company, 
                    'tbl_company_branch_idtbl_company_branch' => $branch
                );
    
                $this->db->insert('tbl_sales_info', $accountsData);
            }
        }
    
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

    public function DirectInvoicecheckstatus() {
        $this->db->trans_begin();

        $recordID=$this->input->post('requestid');
        $confirmnot=$this->input->post('confirmnot');
        $userID=$_SESSION['userid'];
        $updatedatetime=date('Y-m-d H:i:s');

            $data=array(
                'check_by'=> $userID);

            $this->db->where('idtbl_direct_invoice', $recordID);
            $this->db->update('tbl_direct_invoice', $data);


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