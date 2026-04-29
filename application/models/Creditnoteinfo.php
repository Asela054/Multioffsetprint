<?php

class Creditnoteinfo extends CI_Model {
    public function Customerget() {
        $comapnyID=$_SESSION['company_id'];

        $this->db->select('customer, idtbl_customer');
        $this->db->from('tbl_customer');
        $this->db->where('status', 1);  
        $this->db->where('tbl_company_idtbl_company', $comapnyID);     
		$respond=$this->db->get();
        return $respond;

    }
    public function fetchDispatchList() {
        $invoiceId = $this->input->post('hideinvoiceid');

        $this->db->select('dispatch_no, tbl_print_dispatch_idtbl_print_dispatch AS id');
        $this->db->from('tbl_print_invoicedetail');
        $this->db->where('tbl_print_invoice_idtbl_print_invoice', $invoiceId);
        $this->db->where('status', 1);
        $query = $this->db->get();
        $dispatchList = $query->result_array();

        $this->db->select('percentage');
        $this->db->from('tbl_tax_control');
        $this->db->order_by('id_tax_control', 'DESC');
        $this->db->limit(1);
        $vatQuery = $this->db->get();
        $vatPercentage = $vatQuery->row_array()['percentage'];

        echo json_encode([
            'dispatchList' => $dispatchList,
            'percentage' => $vatPercentage
        ]);
    }

    
    public function Getjobdetails() {
        $recordID = $this->input->post('recordID');    
            
        $this->db->select('`qty`, `unitprice`, `job_id`, `job_no`, `job`');
        $this->db->from('tbl_print_invoicedetail');
        $this->db->where('tbl_print_dispatch_idtbl_print_dispatch', $recordID);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->qty=$respond->row(0)->qty;
        $obj->unitprice=$respond->row(0)->unitprice;
        $obj->job_id=$respond->row(0)->job_id;
        $obj->job_no=$respond->row(0)->job_no;
        $obj->job=$respond->row(0)->job;

        echo json_encode($obj);
    }

    public function Returninvoiceinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $tableData=$this->input->post('tableData');
        $hideinvoiceID=$this->input->post('hideinvoiceID');
        $total=$this->input->post('total');
        $tax=$this->input->post('tax');
        $totalwithtax=$this->input->post('totalwithtax');
        $remark=$this->input->post('remark');
        $company_id=$this->input->post('f_company_id');
        $branch_id=$this->input->post('f_branch_id');


        $updatedatetime=date('Y-m-d H:i:s');
        $today=date('Y-m-d');
        $batchnodate=date('Ymd');

        $data = array(
            'date'=> $today,
            'total'=> $total, 
            'vat_amount'=> $tax, 
            'subtotal'=> $totalwithtax, 
            'remark'=> $remark, 
            'status'=> '1', 
            'insertdatetime'=> $updatedatetime, 
            'tbl_user_idtbl_user'=> $userID, 
            'tbl_company_idtbl_company'=> $company_id, 
            'tbl_company_branch_idtbl_company_branch'=> $branch_id, 
            'tbl_print_invoice_idtbl_print_invoice'=> $hideinvoiceID
        );

        $this->db->insert('tbl_credit_note', $data);

        $returninvoiceID=$this->db->insert_id();

        foreach ($tableData as $rowtabledata) {
            $jobID = $rowtabledata['col_4'];
            $dispatchID = $rowtabledata['col_5'];
            $returnType = $rowtabledata['col_6'];
            $unitprice = $rowtabledata['col_7'];
            $qty = $rowtabledata['col_9'];
            $nettotal = $rowtabledata['col_10'];
        
            $dataone = array(
                'qty' => $qty,
                'unitprice' => $unitprice,
                'total' => $nettotal,
                'job_id' => $jobID,
                'dispatch_id' => $dispatchID,
                'status' => '1',
                'insertdatetime' => $updatedatetime,
                'tbl_credit_note_idtbl_credit_note' => $returninvoiceID,
                'tbl_user_idtbl_user'=> $userID 
            );
        
            $this->db->insert('tbl_credit_note_detail', $dataone);
        
            if ($returnType == 2) {
                $this->db->select('qty');
                $this->db->from('tbl_print_dispatchdetail');
                $this->db->where('tbl_print_dispatch_idtbl_print_dispatch', $dispatchID);
                $this->db->where('job_id', $jobID);
                $currentQtyResult = $this->db->get()->row();
        
                if ($currentQtyResult) {
                    $currentQty = $currentQtyResult->qty;
        
                    $newQty = $currentQty - $qty;
                    if ($newQty < 0) {
                        $newQty = 0;
                    }
        
                    $data = array(
                        'qty' => $newQty,
                    );
        
                    $this->db->where('tbl_print_dispatch_idtbl_print_dispatch', $dispatchID);
                    $this->db->where('job_id', $jobID);
                    $this->db->update('tbl_print_dispatchdetail', $data);
                }
        
                $data = array(
                    'invoice_status' => '0',
                );
        
                $this->db->where('idtbl_print_dispatch', $dispatchID);
                $this->db->update('tbl_print_dispatch', $data);
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

    public function Creditnoteapprove(){
        $recordID=1;
        $userID = $_SESSION['userid'];
        $company = $_SESSION['company_id'];
        $branch = $_SESSION['branch_id'];
        $confirmnot=1;
        $updatedatetime = date('Y-m-d H:i:s');

        $obj = new stdClass();
        $actionObj = new stdClass();

        try {
            $this->db->trans_begin();
            if ($confirmnot == 1) {
                // UPDATE APPROVE STATUS
                $data = array(
                    'approvestatus' => 1,
                    'tbl_user_idtbl_user' => $userID
                );
                $this->db->where('idtbl_credit_note', $recordID);
                $this->db->update('tbl_credit_note', $data);

                // GET API SEGREGATION DATA
                $this->db->select('tbl_credit_note.idtbl_credit_note, tbl_credit_note.date, tbl_credit_note.total, tbl_credit_note.vat_amount, tbl_credit_note.subtotal, tbl_credit_note.creditnoteno, tbl_print_invoice.tbl_customer_idtbl_customer');
                $this->db->from('tbl_credit_note');
                $this->db->join('tbl_print_invoice', 'tbl_print_invoice.idtbl_print_invoice = tbl_credit_note.tbl_print_invoice_idtbl_print_invoice', 'left');
                $this->db->where('tbl_credit_note.idtbl_credit_note', $recordID);
                $this->db->where('tbl_credit_note.status', 1);
                $respond=$this->db->get();

                $APIstatus = $this->load->model('Apiinfo');
                $APIstatus = $this->Apiinfo->CreditnoteApi($recordID);

                if (empty($APIstatus)) {
                    throw new Exception("Invoice API configuration error: Missing chart of accounts for one or more items.");
                }

                $fullnarration = 'Costing for Internal Issue Note ID: ' . $respond->row(0)->idtbl_credit_note;
                $apiurljobfinish = $_SESSION['accountapiurl'].'Api/Creditnoteprocess';

                $postDataList = http_build_query([
                    'userid' => $userID,
                    'company' => $company,
                    'branch' => $branch,
                    'fullnarration' => $fullnarration,
                    'fulltotal' => $respond->row(0)->subtotal,
                    'jurnalentrydata' => json_encode($APIstatus)
                ]);

                $ch = curl_init();
                curl_setopt_array($ch, [
                    CURLOPT_URL => $apiurljobfinish,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => $postDataList,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTPHEADER => [
                        'Content-Type: application/x-www-form-urlencoded',
                    ]
                ]);
                
                $server_output = curl_exec($ch);
                $curlError = curl_error($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);

                // Check both HTTP status and API response
                $apiResponsejobfinish = json_decode($server_output, true);

                if ($httpCode != 200 || !isset($apiResponsejobfinish['status']) || $apiResponsejobfinish['status'] !== 'success') {
                    $errorMsg = $apiResponsejobfinish['message'] ?? 'API request failed in jobfinish';
                    throw new Exception($errorMsg);
                }
            }
            else{
                $data = array(
                    'approvestatus' => 2,
                    'tbl_user_idtbl_user' => $userID
                );
                $this->db->where('idtbl_credit_note', $recordID);
                $this->db->update('tbl_credit_note', $data);
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

    public function Getretruninvoicedetails(){
        $html = '';

        $recordID=$this->input->post('recordID');


        $sql = "SELECT `tbl_credit_note`.`idtbl_credit_note`, `tbl_credit_note`.`date`, `tbl_credit_note`.`total`, `tbl_credit_note`.`vat_amount`, `tbl_credit_note`.`subtotal`
        FROM `tbl_credit_note` WHERE `tbl_credit_note`.`tbl_print_invoice_idtbl_print_invoice`=? AND `tbl_credit_note`.`status`=?";
        $respond = $this->db->query($sql, array($recordID, 1)); 

        $html.='
        <table class="table table-bordered table-striped table-sm nowrap" id="tblReturnInvoicelist">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Date</th>
                <th scope="col">Total</th>
                <th scope="col">VAT Amount</th>
                <th scope="col">Sub Total</th>
                <th scope="col">Actions</th>

                </tr>
            </thead>
            <tbody>
        ';
        foreach ($respond->result() as $invoicelist) {
            $buttonClass = 'btn btn-danger btn-sm btnprintReturn mr-1';
                $html .= '<tr>
                            <td>' . $invoicelist->idtbl_credit_note . '</td>
                            <td>' . $invoicelist->date . '</td>
                            <td>' . number_format($invoicelist->total, 2, '.', ',') . '</td>
                            <td>' . number_format($invoicelist->vat_amount, 2, '.', ',') . '</td>
                            <td>' . number_format($invoicelist->subtotal, 2, '.', ',') . '</td>
                            <td>
                            <button class="' . $buttonClass . '" id="' . $invoicelist->idtbl_credit_note . '"><i class="fas fa-file-alt"></i></button>
                            </td>
                        </tr>';
        }        
        $html.='</tbody></table>';

        echo $html;
    }
}