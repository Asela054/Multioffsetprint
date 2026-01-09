<?php 
class Apiinfo extends CI_Model{
    public function GRNApi($grnID) {
        $userID = $_SESSION['userid'];
        $companyID = $_SESSION['company_id'];
        $branchID = $_SESSION['branch_id'];
        $updatedatetime = date('Y-m-d H:i:s');
        $segregationdata = array();
        $grnno='';

        //Insert GRN expense details
        $sql="SELECT `total` AS `amount`, `totalcost` AS `invamount`, `tbl_supplier_idtbl_supplier` AS `supplierid`, `grndate` AS `expdate`, `idtbl_print_grn` AS `grnid`, CASE WHEN `grntype` = 1 THEN 'SPR' WHEN `grntype` = 4 THEN 'MAC' ELSE 'GRN' END AS `expcode`, '1' AS `exptype`, `tbl_print_grn`.`grn_no` FROM `tbl_print_grn` WHERE `idtbl_print_grn`=? AND `tbl_company_idtbl_company`=? AND `tbl_company_branch_idtbl_company_branch`=?
        UNION ALL
        SELECT `tbl_grn_vouchar_import_cost_detail`.`cost_amount` AS `amount`, `tbl_grn_vouchar_import_cost_detail`.`cost_amount` AS `invamount`, `tbl_grn_vouchar_import_cost_detail`.`tbl_supplier_idtbl_supplier` AS `supplierid`, `tbl_grn_vouchar_import_cost`.`date` AS `expdate`, `tbl_grn_vouchar_import_cost`.`tbl_print_grn_idtbl_print_grn` AS `grnid`, 'OTH' AS `expcode`, '4' AS `exptype`, `tbl_print_grn`.`grn_no` FROM `tbl_grn_vouchar_import_cost_detail` LEFT JOIN `tbl_grn_vouchar_import_cost` ON `tbl_grn_vouchar_import_cost`.`idtbl_grn_vouchar_import_cost`=`tbl_grn_vouchar_import_cost_detail`.`tbl_grn_vouchar_import_cost_idtbl_grn_vouchar_import_cost` LEFT JOIN `tbl_print_grn` ON `tbl_print_grn`.`idtbl_print_grn`=`tbl_grn_vouchar_import_cost`.`tbl_print_grn_idtbl_print_grn` WHERE `tbl_grn_vouchar_import_cost_detail`.`status`=? AND `tbl_grn_vouchar_import_cost`.`tbl_company_idtbl_company`=? AND `tbl_grn_vouchar_import_cost`.`tbl_company_branch_idtbl_company_branch`=? AND `tbl_grn_vouchar_import_cost`.`tbl_print_grn_idtbl_print_grn`=?";
        $respond=$this->db->query($sql, array($grnID, $companyID, $branchID, 1, $companyID, $branchID, $grnID));

        if ($respond->num_rows() > 0) {
            foreach ($respond->result() as $row) {
                $dataexpence = array(
                    'exptype' => $row->exptype,
                    'expcode' => $row->expcode,
                    'grnno' => $row->grn_no,
                    'grndate' => $row->expdate,
                    'amount' => str_replace(",", "", $row->amount),
                    'invamount' => str_replace(",", "", $row->invamount),
                    'status' => '1',
                    'insertdatetime' => $updatedatetime,
                    'tbl_user_idtbl_user' => $userID,
                    'tbl_supplier_idtbl_supplier' => $row->supplierid,
                    'tbl_company_idtbl_company' => $companyID,
                    'tbl_company_branch_idtbl_company_branch' => $branchID
                );
                $this->db->insert('tbl_expence_info', $dataexpence);
                $grnno=$row->grn_no;
            }
        }

        $sqlmaterialaccount = "SELECT `idtbl_account`, `accountno`, `accountname` FROM `tbl_print_grn` LEFT JOIN `tbl_account` ON `tbl_account`.`specialcate` = CASE WHEN `tbl_print_grn`.`grntype` = 1 OR `tbl_print_grn`.`grntype` = 4 THEN 38 ELSE 37 END LEFT JOIN `tbl_account_allocation` ON `tbl_account_allocation`.`tbl_account_idtbl_account` = `tbl_account`.`idtbl_account` WHERE `tbl_print_grn`.`idtbl_print_grn`=? AND `tbl_account_allocation`.`companybank`=? AND `tbl_account_allocation`.`branchcompanybank`=? AND `tbl_account_allocation`.`status`=?";
        $respondmaterialaccount = $this->db->query($sqlmaterialaccount, array($grnID, $companyID, $branchID, 1));

        $sqlmaterial="SELECT `tbl_print_grndetail`.`qty`, `tbl_print_grndetail`.`unitprice`, (`tbl_print_grndetail`.`qty`*`tbl_print_grndetail`.`unitprice`) AS `grncosttotal`, `tbl_print_grndetail`.`costunitprice`, `tbl_print_grndetail`.`total` As `costtotal`, `tbl_account_detail`.`idtbl_account_detail`, `tbl_account_detail`.`accountno`, `tbl_account_detail`.`accountname`, `tbl_print_material_info`.`materialname`, `tbl_print_grn`.`tbl_material_group_idtbl_material_group`, `tbl_print_material_info`.`idtbl_print_material_info` FROM `tbl_print_grndetail` LEFT JOIN `tbl_print_grn` ON `tbl_print_grn`.`idtbl_print_grn` = `tbl_print_grndetail`.`tbl_print_grn_idtbl_print_grn` LEFT JOIN `tbl_print_material_info` ON `tbl_print_material_info`.`idtbl_print_material_info` = `tbl_print_grndetail`.`tbl_print_material_info_idtbl_print_material_info` LEFT JOIN `tbl_account_detail` ON `tbl_account_detail`.`special_cate_sub` = `tbl_print_material_info`.`tbl_material_type_idtbl_material_type` AND `tbl_account_detail`.`status`=? AND `tbl_account_detail`.`special_cate_detail`=? WHERE `tbl_print_grndetail`.`tbl_print_grn_idtbl_print_grn`=? AND `tbl_print_grndetail`.`status`=?";
        $respondmaterial = $this->db->query($sqlmaterial, array(1, 2, $grnID, 1));       
        
        if ($respondmaterial->num_rows() > 0) {
            $materiltotalvalue = 0;
            foreach ($respondmaterial->result() as $rowmaterial) {
                if(!empty($rowmaterial->idtbl_account_detail)){
                    $obj = new stdClass();
                    $obj->amount = str_replace(",", "", $rowmaterial->costtotal);
                    $obj->narration = 'Material Costing for ' . $rowmaterial->materialname . ' ' . $grnno;
                    $obj->detailaccount = $rowmaterial->idtbl_account_detail;
                    $obj->chartaccount = 0;
                    $obj->crder = 'D';
                    $segregationdata[] = $obj;
                }
                else{
                    if($rowmaterial->tbl_material_group_idtbl_material_group==4){
                        $this->db->select('tbl_account_detail.idtbl_account_detail, tbl_account_detail.accountno, tbl_account_detail.accountname, tbl_account.idtbl_account, tbl_account.accountno AS chartaccountno, tbl_account.accountname AS chartaccountname');
                        $this->db->from('tbl_print_material_info');
                        $this->db->join('tbl_account', 'tbl_account.idtbl_account = tbl_print_material_info.tbl_account_idtbl_account', 'left');
                        $this->db->join('tbl_account_detail', 'tbl_account_detail.idtbl_account_detail = tbl_print_material_info.tbl_account_detail_idtbl_account_detail', 'left');
                        $this->db->where('tbl_print_material_info.idtbl_print_material_info', $rowmaterial->idtbl_print_material_info);
                        $this->db->where('tbl_print_material_info.status', 1);
                        $responddetail=$this->db->get();

                        $obj = new stdClass();
                        $obj->amount = str_replace(",", "", $rowmaterial->costtotal);
                        $obj->narration = 'Material Costing for ' . $rowmaterial->materialname . ' ' . $grnno;
                        if(!empty($responddetail->row(0)->idtbl_account_detail)){$obj->detailaccount = $responddetail->row(0)->idtbl_account_detail;}else{$obj->detailaccount = 0;}
                        if(!empty($responddetail->row(0)->idtbl_account)){$obj->chartaccount = $responddetail->row(0)->idtbl_account;}else{$obj->chartaccount = 0;}
                        $obj->crder = 'D';
                        $segregationdata[] = $obj;
                    }
                    else{
                        $materiltotalvalue += $rowmaterial->costtotal;
                    }
                }
            }
        }

        //Get Creditor Account
        $creditortotalvalue = 0;

        $this->db->where('tbl_account_allocation.companybank', $companyID);
        $this->db->where('tbl_account_allocation.branchcompanybank', $branchID);
        $this->db->where('tbl_account.specialcate', 34);
        $this->db->where('tbl_account.status', 1);
        $this->db->where('tbl_account_allocation.status', 1);
        $this->db->where('tbl_account_allocation.tbl_account_idtbl_account is NOT NULL', NULL, FALSE);
        $this->db->select('`tbl_account`.`idtbl_account`, `tbl_account`.`accountno`, `tbl_account`.`accountname`');
        $this->db->from('tbl_account');
        $this->db->join('tbl_account_allocation', 'tbl_account_allocation.tbl_account_idtbl_account = tbl_account.idtbl_account', 'left');

        $respondcreditor=$this->db->get();

        $sqlstockvalue = "SELECT `total` AS `amount`, `totalcost` AS `invamount`, `tbl_supplier_idtbl_supplier` AS `supplierid`, `grndate` AS `expdate`, `idtbl_print_grn` AS `grnid` FROM `tbl_print_grn` WHERE `idtbl_print_grn`=? AND `tbl_company_idtbl_company`=? AND `tbl_company_branch_idtbl_company_branch`=?";
        $respondstockvalue = $this->db->query($sqlstockvalue, array($grnID, $companyID, $branchID));
        
        if ($respondstockvalue->num_rows() > 0) {
            $creditortotalvalue += $respondstockvalue->row()->invamount;
        }
        
        $sqlothercost = "SELECT `tbl_grn_vouchar_import_cost_detail`.`cost_amount` AS `amount`, `tbl_grn_vouchar_import_cost_detail`.`cost_amount` AS `invamount`, `tbl_grn_vouchar_import_cost_detail`.`tbl_supplier_idtbl_supplier` AS `supplierid`, `tbl_grn_vouchar_import_cost`.`date` AS `expdate`, `tbl_grn_vouchar_import_cost`.`tbl_print_grn_idtbl_print_grn` AS `grnid`, `tbl_account_detail`.`idtbl_account_detail`, `tbl_account_detail`.`accountno`, `tbl_account_detail`.`accountname` FROM `tbl_grn_vouchar_import_cost_detail` LEFT JOIN `tbl_grn_vouchar_import_cost` ON `tbl_grn_vouchar_import_cost`.`idtbl_grn_vouchar_import_cost`=`tbl_grn_vouchar_import_cost_detail`.`tbl_grn_vouchar_import_cost_idtbl_grn_vouchar_import_cost`  LEFT JOIN `tbl_account_detail` ON `tbl_account_detail`.`special_cate_sub` = `tbl_grn_vouchar_import_cost_detail`.`tbl_import_cost_types_idtbl_import_cost_types` AND `tbl_account_detail`.`status`=? AND `tbl_account_detail`.`special_cate_detail`=? WHERE `tbl_grn_vouchar_import_cost_detail`.`status`=? AND `tbl_grn_vouchar_import_cost`.`tbl_company_idtbl_company`=? AND `tbl_grn_vouchar_import_cost`.`tbl_company_branch_idtbl_company_branch`=? AND `tbl_grn_vouchar_import_cost`.`tbl_print_grn_idtbl_print_grn`=?";
        $respondothercost = $this->db->query($sqlothercost, array(1, 2, 1, $companyID, $branchID, $grnID)); 
        
        if ($respondothercost->num_rows() > 0) {
            foreach ($respondothercost->result() as $rowothercost) {
                if(!empty($rowothercost->idtbl_account_detail)){
                    $obj = new stdClass();
                    $obj->amount = str_replace(",", "", $rowothercost->amount);
                    $obj->narration = 'Other Costing for GRN No: ' . $grnno;
                    $obj->detailaccount = $rowothercost->idtbl_account_detail;
                    $obj->chartaccount = 0;
                    $obj->crder = 'C';
                    $segregationdata[] = $obj;
                }
                // else{
                //     $creditortotalvalue += $rowothercost->amount;
                // }
            }
        }
        
        //Get Vat Amount Information
        $this->db->select('`vatamount`, `vatamountcost`');
        $this->db->from('tbl_print_grn');
        $this->db->where('status', 1);
        $this->db->where('idtbl_print_grn', $grnID);

        $respondvat = $this->db->get();

        $sqlvataccount = "SELECT `idtbl_account`, `accountno`, `accountname` FROM `tbl_account` LEFT JOIN `tbl_account_allocation` ON `tbl_account_allocation`.`tbl_account_idtbl_account` = `tbl_account`.`idtbl_account` WHERE `tbl_account_allocation`.`companybank`=? AND `tbl_account_allocation`.`branchcompanybank`=? AND `tbl_account_allocation`.`status`=? AND `tbl_account`.`specialcate`=? AND `tbl_account`.`status`=?";
        $respondvataccount = $this->db->query($sqlvataccount, array($companyID, $branchID, 1, 13, 1));
        
        if ($creditortotalvalue > 0) {
            $obj = new stdClass();
            $obj->amount = str_replace(",", "", $creditortotalvalue);
            $obj->narration = 'Costing for GRN No: ' . $grnno;
            $obj->detailaccount = 0;
            $obj->chartaccount = $respondcreditor->row()->idtbl_account;
            $obj->crder = 'C';
            $segregationdata[] = $obj;
        }
        
        if ($materiltotalvalue > 0) {
            $obj = new stdClass();
            $obj->amount = str_replace(",", "", $materiltotalvalue);
            $obj->narration = 'Material Costing for GRN No: ' . $grnno;
            $obj->detailaccount = 0;
            $obj->chartaccount = $respondmaterialaccount->row()->idtbl_account;
            $obj->crder = 'D';
            $segregationdata[] = $obj;
        }

        if ($respondvat->num_rows() > 0 && $respondvataccount->num_rows() > 0) {
            $vatamount = $respondvat->row()->vatamount;
            $vatamountcost = $respondvat->row()->vatamountcost;

            if ($vatamount > 0) {
                $obj = new stdClass();
                $obj->amount = str_replace(",", "", $vatamount);
                $obj->narration = 'VAT Costing for GRN No: ' . $grnno;
                $obj->detailaccount = 0;
                $obj->chartaccount = $respondvataccount->row()->idtbl_account;
                $obj->crder = 'D';
                $segregationdata[] = $obj;
            }
        }

        return $segregationdata;
    }
    public function InvoiceApi($invoiceID){
        $userID = $_SESSION['userid'];
        $companyID = $_SESSION['company_id'];
        $branchID = $_SESSION['branch_id'];
        $updatedatetime = date('Y-m-d H:i:s');
        $segregationdata = array();
        $svatstatus = 0;
        $vatstatus = 0;

        $this->db->select('`tbl_print_invoice`.`idtbl_print_invoice`, `tbl_print_invoice`.`inv_no`, `tbl_print_invoice`.`date`, `tbl_print_invoice`.`total`, `tbl_print_invoice`.`subtotal`, `tbl_print_invoice`.`vat_amount`, `tbl_customer`.`vat_customer`, `tbl_print_invoice`.`tbl_customer_idtbl_customer`');
        $this->db->from('tbl_print_invoice');
        $this->db->join('tbl_customer', 'tbl_print_invoice.tbl_customer_idtbl_customer = tbl_customer.idtbl_customer');
        $this->db->where('tbl_print_invoice.idtbl_print_invoice', $invoiceID);
        $this->db->where('tbl_print_invoice.status', 1);
    
        $respond=$this->db->get();
        
        if($respond->row(0)->vat_customer==1):$vatstatus = 1;elseif($respond->row(0)->vat_customer==2):$svatstatus = 1;endif;

        $dataexpence = array(
            'saletype'=> '1', 
            'salecode'=> 'INV', 
            'invno'=> $respond->row(0)->inv_no,  
            'invdate'=> $respond->row(0)->date,
            'sub_total'=> $respond->row(0)->subtotal, 
            'vat'=> $respond->row(0)->vat_amount, 
            'amount'=> $respond->row(0)->subtotal, 
            'invamount'=> $respond->row(0)->total, 
            'svat_status'=> $svatstatus, 
            'vat_status'=> $vatstatus, 
            'status'=> '1', 
            'insertdatetime'=> $updatedatetime, 
            'tbl_user_idtbl_user'=> $userID, 
            'tbl_customer_idtbl_customer'=> $respond->row(0)->tbl_customer_idtbl_customer, 
            'tbl_company_idtbl_company'=> $companyID, 
            'tbl_company_branch_idtbl_company_branch'=> $branchID
        );
        $this->db->insert('tbl_sales_info', $dataexpence);

        $chartspecialcate = array('35', '13', '18');
        $this->db->where('tbl_account_allocation.companybank', $companyID);
        $this->db->where('tbl_account_allocation.branchcompanybank', $branchID);
        $this->db->where_in('tbl_account.specialcate', $chartspecialcate);
        $this->db->where('tbl_account.status', 1);
        $this->db->where('tbl_account_allocation.status', 1);
        $this->db->where('tbl_account_allocation.tbl_account_idtbl_account is NOT NULL', NULL, FALSE);
        $this->db->select('`tbl_account`.`idtbl_account`, `tbl_account`.`accountno`, `tbl_account`.`accountname`, `tbl_account`.`specialcate`');
        $this->db->from('tbl_account');
        $this->db->join('tbl_account_allocation', 'tbl_account_allocation.tbl_account_idtbl_account = tbl_account.idtbl_account', 'left');

        $respondchart=$this->db->get();

        $detailspecialcate = array('1', '2');
        $this->db->where('tbl_account_allocation.companybank', $companyID);
        $this->db->where('tbl_account_allocation.branchcompanybank', $branchID);
        $this->db->where('tbl_account_detail.special_cate_detail', '3');
        $this->db->where_in('tbl_account_detail.special_cate_sub', $detailspecialcate);
        $this->db->where('tbl_account_detail.status', 1);
        $this->db->where('tbl_account_allocation.status', 1);
        $this->db->where('tbl_account_allocation.tbl_account_detail_idtbl_account_detail is NOT NULL', NULL, FALSE);
        $this->db->select('`tbl_account_detail`.`idtbl_account_detail`, `tbl_account_detail`.`accountno`, `tbl_account_detail`.`accountname`, `tbl_account_detail`.`special_cate_sub`');
        $this->db->from('tbl_account_detail');
        $this->db->join('tbl_account_allocation', 'tbl_account_allocation.tbl_account_detail_idtbl_account_detail = tbl_account_detail.idtbl_account_detail', 'left');

        $respondotherdetail=$this->db->get();

        if(!empty($respondotherdetail->result())): 
            foreach($respondotherdetail->result() as $rowdetailaccount):
                if(($companyID==1 || $companyID==2) && $rowdetailaccount->special_cate_sub==2):
                    $obj = new stdClass();
                    $obj->amount = str_replace(",", "", $respond->row(0)->subtotal);
                    $obj->narration = 'Costing for INVOICE ID: ' . $respond->row(0)->inv_no;
                    $obj->detailaccount = $rowdetailaccount->idtbl_account_detail;
                    $obj->chartaccount = '0';
                    $obj->crder = 'C';
                    $segregationdata[] = $obj;
                    break;
                else:
                    $obj = new stdClass();
                    $obj->amount = str_replace(",", "", $respond->row(0)->subtotal);
                    $obj->narration = 'Costing for INVOICE ID: ' . $respond->row(0)->inv_no;
                    $obj->detailaccount = $rowdetailaccount->idtbl_account_detail;
                    $obj->chartaccount = '0';
                    $obj->crder = 'C';
                    $segregationdata[] = $obj;
                    break;
                endif;
            endforeach;
        else: 
            foreach($respondchart->result() as $rowrchartaccount):
                if($rowrchartaccount->specialcate==18):
                    $obj = new stdClass();
                    $obj->amount = str_replace(",", "", $respond->row(0)->subtotal);
                    $obj->narration = 'Costing for INVOICE ID: ' . $respond->row(0)->inv_no;
                    $obj->detailaccount = '0';
                    $obj->chartaccount = $rowrchartaccount->idtbl_account;
                    $obj->crder = 'C';
                    $segregationdata[] = $obj;
                endif;
            endforeach;            
        endif;

        foreach($respondchart->result() as $rowrchartaccount):
            if($rowrchartaccount->specialcate==13 && $respond->row(0)->vat_amount>0):
                $obj = new stdClass();
                $obj->amount = str_replace(",", "", $respond->row(0)->vat_amount);
                $obj->narration = 'VAT Costing for INVOICE ID: ' . $respond->row(0)->inv_no;
                $obj->detailaccount = '0';
                $obj->chartaccount = $rowrchartaccount->idtbl_account;
                $obj->crder = 'C';
                $segregationdata[] = $obj;
            elseif($rowrchartaccount->specialcate==35):
                $obj = new stdClass();
                $obj->amount = str_replace(",", "", $respond->row(0)->total);
                $obj->narration = 'Costing for INVOICE ID: ' . $respond->row(0)->inv_no;
                $obj->detailaccount = '0';
                $obj->chartaccount = $rowrchartaccount->idtbl_account;
                $obj->crder = 'D';
                $segregationdata[] = $obj;
            endif;
        endforeach; 

        return $segregationdata;
    }
}