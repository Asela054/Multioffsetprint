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

    public function Getretruninvoicedetails(){
        $html = '';

        $recordID=$this->input->post('recordID');


        $sql = "SELECT `tbl_credit_note`.`idtbl_credit_note`, `tbl_credit_note`.`date`, `tbl_credit_note`.`total`, `tbl_credit_note`.`vat_amount`, `tbl_credit_note`.`subtotal`, `tbl_credit_note`.`approvestatus`, `tbl_credit_note`.`checkby`
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
                <th scope="col">Approve Status</th>
                <th scope="col">Checked By</th>
                <th scope="col">Actions</th>

                </tr>
            </thead>
            <tbody>
        ';
        foreach ($respond->result() as $invoicelist) {
            $approveStatus = '<span class="badge badge-secondary">Pending</span>';
            if ($invoicelist->approvestatus == 1) {
                $approveStatus = '<span class="badge badge-success">Approved</span>';
            } else if ($invoicelist->approvestatus == 2) {
                $approveStatus = '<span class="badge badge-danger">Rejected</span>';
            }

            $checkedBy = '<span class="badge badge-secondary">Not Checked</span>';
            if (!empty($invoicelist->checkby) && $invoicelist->checkby != 0) {
                $checkedBy = '<span class="badge badge-info">Checked</span>';
            }

            $buttonClass = 'btn btn-danger btn-sm btnprintReturn mr-1';
            $viewButton = '<button class="btn btn-dark btn-sm btnviewCreditNote mr-1" id="' . $invoicelist->idtbl_credit_note . '" data-approvestatus="' . $invoicelist->approvestatus . '" data-checkstatus="' . ($invoicelist->checkby ? 1 : 0) . '"><i class="fas fa-eye"></i></button>';
                $html .= '<tr>
                            <td>' . $invoicelist->idtbl_credit_note . '</td>
                            <td>' . $invoicelist->date . '</td>
                            <td>' . number_format($invoicelist->total, 2, '.', ',') . '</td>
                            <td>' . number_format($invoicelist->vat_amount, 2, '.', ',') . '</td>
                            <td>' . number_format($invoicelist->subtotal, 2, '.', ',') . '</td>
                            <td>' . $approveStatus . '</td>
                            <td>' . $checkedBy . '</td>
                            <td>
                            ' . $viewButton . '
                            <button class="' . $buttonClass . '" id="' . $invoicelist->idtbl_credit_note . '"><i class="fas fa-file-alt"></i></button>
                            </td>
                        </tr>';
        }        
        $html.='</tbody></table>';

        echo $html;
    }

    public function GetCreditNoteDetails(){
        $recordID = $this->input->post('recordID');

        $this->db->select('cn.*, c.customer, c.telephone_no, c.address_line1, c.address_line2, c.city, c.state');
        $this->db->from('tbl_credit_note cn');
        $this->db->join('tbl_print_invoice pi', 'pi.idtbl_print_invoice = cn.tbl_print_invoice_idtbl_print_invoice', 'left');
        $this->db->join('tbl_customer c', 'c.idtbl_customer = pi.tbl_customer_idtbl_customer', 'left');
        $this->db->where('cn.idtbl_credit_note', $recordID);
        $query = $this->db->get();
        $creditnote = $query->row();

        if($creditnote){
            echo '<script>
                document.getElementById("creditnotecustomername").innerHTML = "' . addslashes($creditnote->customer) . '";
                document.getElementById("creditnotecustomercontact").innerHTML = "' . addslashes($creditnote->contact) . '";
                document.getElementById("creditnoteaddress1").innerHTML = "' . addslashes($creditnote->address1) . '";
                document.getElementById("creditnoteaddress2").innerHTML = "' . addslashes($creditnote->address2) . '";
                document.getElementById("creditnotecity").innerHTML = "' . addslashes($creditnote->city) . '";
                document.getElementById("creditnotestate").innerHTML = "' . addslashes($creditnote->state) . '";
            </script>';

            $html = '<table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>Job</th>
                        <th>Qty</th>
                        <th>Unit Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>';

            $this->db->select('cnd.*, pid.job');
            $this->db->from('tbl_credit_note_detail cnd');
            $this->db->join('tbl_print_invoicedetail pid', 'pid.tbl_print_dispatch_idtbl_print_dispatch = cnd.dispatch_id', 'left');
            $this->db->where('cnd.tbl_credit_note_idtbl_credit_note', $recordID);
            $details = $this->db->get()->result();

            foreach($details as $detail){
                $html .= '<tr>
                    <td>' . $detail->job . '</td>
                    <td>' . $detail->qty . '</td>
                    <td>' . number_format($detail->unitprice, 2) . '</td>
                    <td>' . number_format($detail->total, 2) . '</td>
                </tr>';
            }

            $html .= '</tbody></table>';
            $html .= '<div class="row">
                <div class="col-6">
                    <strong>Remark:</strong> ' . $creditnote->remark . '
                </div>
                <div class="col-6 text-right">
                    <strong>Total:</strong> Rs. ' . number_format($creditnote->total, 2) . '<br>
                    <strong>VAT:</strong> Rs. ' . number_format($creditnote->vat_amount, 2) . '<br>
                    <strong>Subtotal:</strong> Rs. ' . number_format($creditnote->subtotal, 2) . '
                </div>
            </div>';

            echo $html;
        }
    }

    public function Creditnotestatus(){
        $creditnoteid = $this->input->post('creditnoteid');
        $status = $this->input->post('status');
        $userid = $_SESSION['userid'];

        $data = array(
            'approvestatus' => $status
        );

        $this->db->where('idtbl_credit_note', $creditnoteid);
        $this->db->update('tbl_credit_note', $data);

        if($this->db->affected_rows() > 0){
            $message = $status == 1 ? 'Credit Note Approved Successfully' : 'Credit Note Rejected Successfully';
            echo json_encode(array('status' => 1, 'message' => $message));
        } else {
            echo json_encode(array('status' => 0, 'message' => 'Failed to update status'));
        }
    }

    public function Creditnotecheckstatus(){
        $creditnoteid = $this->input->post('creditnoteid');
        $userid = $_SESSION['userid'];

        $data = array(
            'checkby' => $userid
        );

        $this->db->where('idtbl_credit_note', $creditnoteid);
        $this->db->update('tbl_credit_note', $data);

        if($this->db->affected_rows() > 0){
            echo json_encode(array('status' => 1, 'message' => 'Credit Note Checked Successfully'));
        } else {
            echo json_encode(array('status' => 0, 'message' => 'Failed to check credit note'));
        }
    }
}