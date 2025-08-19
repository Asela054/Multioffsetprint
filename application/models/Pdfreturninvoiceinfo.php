<?php
class Pdfreturninvoiceinfo extends CI_Model{
    public function Getinvoiceprint(){

        $recordID = $this->input->post('recordID');

        $this->db->select('tbl_credit_note_detail.*, tbl_credit_note.idtbl_credit_note , tbl_credit_note.total, tbl_print_invoice.date, tbl_print_invoice.idtbl_print_invoice, tbl_print_invoice.subtotal, tbl_print_invoicedetail.job, tbl_print_invoicedetail.dispatch_no, tbl_customer.customer');
        $this->db->from('tbl_credit_note_detail');
        $this->db->join('tbl_credit_note', 'tbl_credit_note.idtbl_credit_note = tbl_credit_note_detail.tbl_credit_note_idtbl_credit_note', 'left');
        $this->db->join('tbl_print_invoice', 'tbl_print_invoice.idtbl_print_invoice = tbl_credit_note.invoice_id', 'left');
        $this->db->join('tbl_print_invoicedetail', 'tbl_print_invoice.idtbl_print_invoice = tbl_print_invoicedetail.tbl_print_invoice_idtbl_print_invoice', 'left');
        $this->db->join('tbl_customer', 'tbl_customer.idtbl_customer = tbl_print_invoice.customer_id', 'left');
        $this->db->where('tbl_credit_note.idtbl_credit_note', $recordID);
        $this->db->where('tbl_credit_note_detail.status', 1);
        $responddetail = $this->db->get();

        $this->db->select('tbl_company.company AS companyname,tbl_company.address1 As companyaddress,tbl_company.mobile AS companymobile,
        tbl_company.phone companyphone,tbl_company.email AS companyemail,
        tbl_company_branch.branch AS branchname');
        $this->db->from('tbl_print_invoice');
        $this->db->join('tbl_company', 'tbl_company.idtbl_company = tbl_print_invoice.company_id', 'left');
        $this->db->join('tbl_company_branch', 'tbl_company_branch.idtbl_company_branch = tbl_print_invoice.company_branch_id', 'left');
        $companydetails = $this->db->get();

        $html = '';

        if ($responddetail->num_rows() > 0) {
            $row = $responddetail->row();
            $html .= '
            
            <style>
                .pheader {
					margin-top: 2px;
                    font-size: 12px;
                    line-height: 2.5px;
                }
                .tax {
					font-size: 30px;
					color: white;
					background-color: black;
					padding: 2px; 
				}
            </style>
            
            <table border="0" width="100%">
            <tr>
                <td rowspan="2" align="left">
                    <h2 class="pheader" style="font-size: 22px; margin-top: 2px;">'.$companydetails->row()->companyname.'</h2> 
                    <br>
                    <p class="pheader" style="margin-top: 4px;font-size: 14px;">'.$companydetails->row()->companyaddress.'</p>
                    <p class="pheader" style="font-size: 14px;">'.$companydetails->row()->companymobile.'/'.$companydetails->row()->companyphone.'</p>         
                    <p class="pheader" style="font-size: 14px;">'.$companydetails->row()->companyemail.'</p>                
                </td>';

            $html .= '<td class="tax" align="center"><strong>Tax Invoice</strong></td>';

        $html .= '</tr>
                </table>
            <div class="row">
                <div class="col-12">
                    <hr>
                    <table class="table table-striped table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>Return Job</th>
                                <th>Unit Price</th>
                                <th>Return Qty</th>
                                <th class="text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>';
            foreach($responddetail->result() as $roworderinfo) {
                $html .= '<tr>
                    <td>'.$roworderinfo->job.'</td>
                    <td>'.$roworderinfo->unitprice.'</td>
                    <td>'.$roworderinfo->qty.'</td>
                    <td class="text-right">'.number_format(($roworderinfo->qty*$roworderinfo->unitprice), 2).'</td>
                </tr>';
            }
            $html .= '</tbody>
                    </table>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12 text-right"><h3 class="font-weight-normal"><span class="font-weight-bold">Invoice Total :</span>Rs. '.number_format(($row->subtotal),2).'</h3></div>
            </div>
            <div class="row mt-3">
                <div class="col-12 text-right"><h3 class="font-weight-normal"><span class="font-weight-bold">Return Total :</span>Rs. '.number_format(($row->total),2).'</h3></div>
            </div>

            <div class="row" style="margin-top: 100px;">
                <div class="ml-3">
                    <p class="text-right">Approved by: </p>
                </div>
                <div class="col-md-3">
                    <p style="border-bottom: 1px dotted; margin-bottom: 0;">&nbsp;</p>
                </div>
            </div>


            ';
        } else {
            $html .= '<p>No data found</p>';
        }

        echo $html;
    }

}
?>