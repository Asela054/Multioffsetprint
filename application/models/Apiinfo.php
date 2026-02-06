<?php 
class Apiinfo extends CI_Model{
    public function GRNApi($grnID) {
        $userID = $_SESSION['userid'];
        $companyID = $_SESSION['company_id'];
        $branchID = $_SESSION['branch_id'];
        $updatedatetime = date('Y-m-d H:i:s');
        $segregationdata = array();
        $grnno='';

        try {
            $this->db->trans_begin();
            
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
                        'amount' => str_replace(",", "", (!empty($row->amount) ? $row->amount : $row->invamount)),
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

            $sqlmaterialaccount = "SELECT `idtbl_account`, `accountno`, `accountname` FROM `tbl_print_grn` LEFT JOIN `tbl_account` ON `tbl_account`.`specialcate` = CASE WHEN `tbl_print_grn`.`grntype` = 1 THEN '37' WHEN `tbl_print_grn`.`grntype` IN (2, 3) THEN '38' END LEFT JOIN `tbl_account_allocation` ON `tbl_account_allocation`.`tbl_account_idtbl_account` = `tbl_account`.`idtbl_account` WHERE `tbl_print_grn`.`idtbl_print_grn`=? AND `tbl_account_allocation`.`companybank`=? AND `tbl_account_allocation`.`branchcompanybank`=? AND `tbl_account_allocation`.`status`=?";
            $respondmaterialaccount = $this->db->query($sqlmaterialaccount, array($grnID, $companyID, $branchID, 1));

            $sqlmaterial="SELECT `tbl_print_grndetail`.`qty`, `tbl_print_grndetail`.`unitprice`, (`tbl_print_grndetail`.`qty`*`tbl_print_grndetail`.`unitprice`) AS `grncosttotal`, `tbl_print_grndetail`.`costunitprice`, `tbl_print_grndetail`.`total` As `costtotal`, `tbl_account_detail`.`idtbl_account_detail`, `tbl_account_detail`.`accountno`, `tbl_account_detail`.`accountname`, `tbl_print_material_info`.`materialname`, `tbl_print_grn`.`tbl_material_group_idtbl_material_group`, `tbl_print_material_info`.`idtbl_print_material_info` FROM `tbl_print_grndetail` LEFT JOIN `tbl_print_grn` ON `tbl_print_grn`.`idtbl_print_grn` = `tbl_print_grndetail`.`tbl_print_grn_idtbl_print_grn` LEFT JOIN `tbl_print_material_info` ON `tbl_print_material_info`.`idtbl_print_material_info` = `tbl_print_grndetail`.`tbl_print_material_info_idtbl_print_material_info` LEFT JOIN `tbl_account_detail` ON `tbl_account_detail`.`special_cate_sub` = `tbl_print_material_info`.`tbl_material_type_idtbl_material_type` AND `tbl_account_detail`.`status`=? AND `tbl_account_detail`.`special_cate_detail`=? WHERE `tbl_print_grndetail`.`tbl_print_grn_idtbl_print_grn`=? AND `tbl_print_grndetail`.`status`=?";
            $respondmaterial = $this->db->query($sqlmaterial, array(1, 2, $grnID, 1));       
            
            if ($respondmaterial->num_rows() > 0) {
                $materiltotalvalue = 0;
                foreach ($respondmaterial->result() as $rowmaterial) {
                    // if(!empty($rowmaterial->idtbl_account_detail)){
                    //     $obj = new stdClass();
                    //     $obj->amount = str_replace(",", "", $rowmaterial->costtotal);
                    //     $obj->narration = 'Material Costing for ' . $rowmaterial->materialname . ' ' . $grnno;
                    //     $obj->detailaccount = $rowmaterial->idtbl_account_detail;
                    //     $obj->chartaccount = 0;
                    //     $obj->crder = 'D';
                    //     $segregationdata[] = $obj;
                    // }
                    // else{
                        if($rowmaterial->tbl_material_group_idtbl_material_group==4){
                            $this->db->select('tbl_account_detail.idtbl_account_detail, tbl_account_detail.accountno, tbl_account_detail.accountname, tbl_account.idtbl_account, tbl_account.accountno AS chartaccountno, tbl_account.accountname AS chartaccountname');
                            $this->db->from('tbl_print_material_info');
                            $this->db->join('tbl_account', 'tbl_account.idtbl_account = tbl_print_material_info.tbl_account_idtbl_account', 'left');
                            $this->db->join('tbl_account_detail', 'tbl_account_detail.idtbl_account_detail = tbl_print_material_info.tbl_account_detail_idtbl_account_detail', 'left');
                            $this->db->where('tbl_print_material_info.idtbl_print_material_info', $rowmaterial->idtbl_print_material_info);
                            $this->db->where('tbl_print_material_info.status', 1);
                            $responddetail=$this->db->get();

                            if (empty($responddetail->row(0)->idtbl_account_detail) && empty($responddetail->row(0)->idtbl_account)) {
                                throw new Exception("No account found for material: " . $rowmaterial->materialname);
                            }

                            $obj = new stdClass();
                            $obj->amount = str_replace(",", "", $rowmaterial->costtotal);
                            $obj->narration = 'Service Costing for ' . $rowmaterial->materialname . ' ' . $grnno;
                            if(!empty($responddetail->row(0)->idtbl_account_detail)){$obj->detailaccount = $responddetail->row(0)->idtbl_account_detail;}else{$obj->detailaccount = 0;}
                            if(!empty($responddetail->row(0)->idtbl_account)){$obj->chartaccount = $responddetail->row(0)->idtbl_account;}else{$obj->chartaccount = 0;}
                            $obj->crder = 'D';
                            $segregationdata[] = $obj;
                        }
                        else{
                            $materiltotalvalue += $rowmaterial->costtotal;
                        }
                    // }
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
                    else{
                        throw new Exception("No detail account found for other cost.");
                        // $creditortotalvalue += $rowothercost->amount;
                    }
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
                if ($respondcreditor->num_rows() == 0) {
                    throw new Exception("No creditor account found.");
                }

                $obj = new stdClass();
                $obj->amount = str_replace(",", "", $creditortotalvalue);
                $obj->narration = 'Costing for GRN No: ' . $grnno;
                $obj->detailaccount = 0;
                $obj->chartaccount = $respondcreditor->row()->idtbl_account;
                $obj->crder = 'C';
                $segregationdata[] = $obj;
            }
            
            if ($materiltotalvalue > 0) {
                if ($respondmaterialaccount->num_rows() == 0) {
                    throw new Exception("No material account found.");
                }
                $obj = new stdClass();
                $obj->amount = str_replace(",", "", $materiltotalvalue);
                $obj->narration = 'Material Costing for GRN No: ' . $grnno;
                $obj->detailaccount = 0;
                $obj->chartaccount = $respondmaterialaccount->row()->idtbl_account;
                $obj->crder = 'D';
                $segregationdata[] = $obj;
            }

            if ($respondvat->num_rows() > 0) {
                if($respondvataccount->num_rows() == 0) {
                    throw new Exception("No VAT account found.");
                }

                $vatamount = $respondvat->row()->vatamount;
                $vatamountcost = $respondvat->row()->vatamountcost;

                if ($vatamountcost > 0) {
                    $obj = new stdClass();
                    $obj->amount = str_replace(",", "", $vatamountcost);
                    $obj->narration = 'VAT Costing for GRN No: ' . $grnno;
                    $obj->detailaccount = 0;
                    $obj->chartaccount = $respondvataccount->row()->idtbl_account;
                    $obj->crder = 'D';
                    $segregationdata[] = $obj;
                }
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $segregationdata = array();
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

        try {
            $this->db->trans_begin();

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
                if($respondchart->num_rows() == 0) {
                    throw new Exception("No chart accounts found for special categories 35, 13, or 18.");
                }
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

            if($respondchart->num_rows() == 0) {
                throw new Exception("No chart accounts found for special categories 35, 13, or 18.");
            }

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

            $this->db->trans_commit();
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $segregationdata = array();
        }

        return $segregationdata;
    }
    public function JobfinishApi($customerinquerydetailID){
        $userID = $_SESSION['userid'];
        $companyID = $_SESSION['company_id'];
        $branchID = $_SESSION['branch_id'];
        $segregationdata = array();

        try {
            $this->db->select('job_no, tbl_customerinquiry_idtbl_customerinquiry');
            $this->db->from('tbl_customerinquiry_detail');
            $this->db->where('idtbl_customerinquiry_detail', $customerinquerydetailID); 
            $respondinquery = $this->db->get();

            $customerinqueryID = $respondinquery->row(0)->tbl_customerinquiry_idtbl_customerinquiry;
            $customerjobno = $respondinquery->row(0)->job_no;

            $this->db->select('SUM(tbl_direct_invoicedetail.issueqty) AS totalqty', FALSE);
            $this->db->select('SUM(tbl_jobcard_issue_meterial.issueqty * tbl_jobcard_issue_meterial.unitprice) AS issuetotal', FALSE);
            $this->db->select('tbl_jobcard_issue_meterial.tbl_print_material_info_idtbl_print_material_info');
            $this->db->select('tbl_jobcard.tbl_customerinquiry_idtbl_customerinquiry');
            $this->db->select('tbl_account_detail.idtbl_account_detail, tbl_account_detail.accountno, tbl_account_detail.accountname, tbl_print_material_info.materialname');
            $this->db->from('tbl_jobcard_issue_meterial');
            $this->db->join('tbl_jobcard', 'tbl_jobcard.idtbl_jobcard = tbl_jobcard_issue_meterial.tbl_jobcard_idtbl_jobcard', 'left');
            $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_issue_meterial.tbl_print_material_info_idtbl_print_material_info', 'left');
            $this->db->join('tbl_account_detail', 
                'tbl_account_detail.special_cate_sub = tbl_print_material_info.tbl_material_type_idtbl_material_type 
                AND tbl_account_detail.status = 1 
                AND tbl_account_detail.special_cate_detail = 2', 
                'left'
            );
            $this->db->where('tbl_jobcard_issue_meterial.status', 2);
            $this->db->where('tbl_jobcard.tbl_customerinquiry_idtbl_customerinquiry', $customerinqueryID);
            $this->db->group_by('tbl_jobcard_issue_meterial.tbl_print_material_info_idtbl_print_material_info');
            $respond = $this->db->get();

            $materialissuenettotal = 0;
            foreach ($respond->result() as $rowmaterial) {
                if(!empty($rowmaterial->idtbl_account_detail)){
                    $obj = new stdClass();
                    $obj->amount = str_replace(",", "", $rowmaterial->issuetotal);
                    $obj->narration = 'Material Costing for ' . $rowmaterial->materialname . ' ' . $customerjobno;
                    $obj->detailaccount = $rowmaterial->idtbl_account_detail;
                    $obj->chartaccount = 0;
                    $obj->crder = 'D';
                    $segregationdata[] = $obj;

                    $materialissuenettotal += $rowmaterial->issuetotal;
                }
                else{
                    // $segregationdata = array();
                    // return $segregationdata;
                    throw new Exception("No account detail found for material: " . $rowmaterial->materialname);
                }
            }

            $chartspecialcate = array('39');
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

            foreach($respondchart->result() as $rowrchartaccount):
                if($rowrchartaccount->specialcate==39 && $materialissuenettotal>0):
                    $obj = new stdClass();
                    $obj->amount = str_replace(",", "", $materialissuenettotal);
                    $obj->narration = 'Material Costing for Job No: ' . $customerjobno;
                    $obj->detailaccount = '0';
                    $obj->chartaccount = $rowrchartaccount->idtbl_account;
                    $obj->crder = 'C';
                    $segregationdata[] = $obj;
                else:
                    // $segregationdata = array();
                    // return $segregationdata;
                    throw new Exception("No chart account found for material costing.");
                endif;
            endforeach;
        } catch (Exception $e) {
            $segregationdata = array();
        }

        return $segregationdata;
    }
    public function InternalIssueApi($issuenoteID){
        $userID = $_SESSION['userid'];
        $companyID = $_SESSION['company_id'];
        $branchID = $_SESSION['branch_id'];
        $segregationdata = array();

        try {
            $this->db->select('SUM(tbl_print_issuedetail.qty) AS totalqty', FALSE);
            $this->db->select('SUM(tbl_print_issuedetail.qty * tbl_print_issuedetail.unitprice) AS issuetotal', FALSE);
            $this->db->select('tbl_print_issuedetail.tbl_print_material_info_idtbl_print_material_info');
            $this->db->select('tbl_print_material_info.tbl_material_group_idtbl_material_group, tbl_print_material_info.materialname');
            $this->db->select('tbl_print_issuedetail.tbl_account_idtbl_account, tbl_print_issuedetail.tbl_account_detail_idtbl_account_detail');
            $this->db->from('tbl_print_issuedetail');
            $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_print_issuedetail.tbl_print_material_info_idtbl_print_material_info', 'left');
            $this->db->where('tbl_print_issuedetail.status', 1);
            $this->db->where('tbl_print_issuedetail.tbl_print_issue_idtbl_print_issue', $issuenoteID);
            $this->db->group_by('tbl_print_issuedetail.tbl_print_material_info_idtbl_print_material_info');
            $respond = $this->db->get();

            $materialissuenettotal = 0;
            $sundryissuenettotal = 0;
            foreach ($respond->result() as $rowmaterial) {
                if(!empty($rowmaterial->idtbl_account_detail)){
                    $obj = new stdClass();
                    $obj->amount = str_replace(",", "", $rowmaterial->issuetotal);
                    $obj->narration = 'Material Costing for ' . $rowmaterial->materialname . ' ' . $issuenoteID;
                    $obj->detailaccount = $rowmaterial->tbl_account_detail_idtbl_account_detail ?? 0;
                    $obj->chartaccount = $rowmaterial->tbl_account_idtbl_account ?? 0;
                    $obj->crder = 'D';
                    $segregationdata[] = $obj;

                    if($rowmaterial->tbl_material_group_idtbl_material_group == 1){
                        $materialissuenettotal += $rowmaterial->issuetotal;
                    }
                    else if($rowmaterial->tbl_material_group_idtbl_material_group == 2){
                        $sundryissuenettotal += $rowmaterial->issuetotal;
                    }
                }
                else{
                    // $segregationdata = array();
                    // return $segregationdata;
                    throw new Exception("No account detail found for material: " . $rowmaterial->materialname);
                }
            }

            if($materialissuenettotal > 0){
                $this->db->where('tbl_account_allocation.companybank', $companyID);
                $this->db->where('tbl_account_allocation.branchcompanybank', $branchID);
                $this->db->where('tbl_account.specialcate', 37);
                $this->db->where('tbl_account.status', 1);
                $this->db->where('tbl_account_allocation.status', 1);
                $this->db->where('tbl_account_allocation.tbl_account_idtbl_account is NOT NULL', NULL, FALSE);
                $this->db->select('`tbl_account`.`idtbl_account`, `tbl_account`.`accountno`, `tbl_account`.`accountname`, `tbl_account`.`specialcate`');
                $this->db->from('tbl_account');
                $this->db->join('tbl_account_allocation', 'tbl_account_allocation.tbl_account_idtbl_account = tbl_account.idtbl_account', 'left');

                $respondchart=$this->db->get();

                if($respondchart->num_rows() == 0) {
                    throw new Exception("No chart account found for material costing.");
                }

                foreach($respondchart->result() as $rowrchartaccount):
                    if($rowrchartaccount->specialcate==37):
                        $obj = new stdClass();
                        $obj->amount = str_replace(",", "", $materialissuenettotal);
                        $obj->narration = 'Material Costing for Issue Note ID: ' . $issuenoteID;
                        $obj->detailaccount = '0';
                        $obj->chartaccount = $rowrchartaccount->idtbl_account;
                        $obj->crder = 'C';
                        $segregationdata[] = $obj;
                    endif;
                endforeach;
            }

            if($sundryissuenettotal > 0){
                $this->db->where('tbl_account_allocation.companybank', $companyID);
                $this->db->where('tbl_account_allocation.branchcompanybank', $branchID);
                $this->db->where('tbl_account.specialcate', 38);
                $this->db->where('tbl_account.status', 1);
                $this->db->where('tbl_account_allocation.status', 1);
                $this->db->where('tbl_account_allocation.tbl_account_idtbl_account is NOT NULL', NULL, FALSE);
                $this->db->select('`tbl_account`.`idtbl_account`, `tbl_account`.`accountno`, `tbl_account`.`accountname`, `tbl_account`.`specialcate`');
                $this->db->from('tbl_account');
                $this->db->join('tbl_account_allocation', 'tbl_account_allocation.tbl_account_idtbl_account = tbl_account.idtbl_account', 'left');

                $respondchart=$this->db->get();

                if($respondchart->num_rows() == 0) {
                    throw new Exception("No chart account found for sundry costing.");
                }

                foreach($respondchart->result() as $rowrchartaccount):
                    if($rowrchartaccount->specialcate==38):
                        $obj = new stdClass();
                        $obj->amount = str_replace(",", "", $sundryissuenettotal);
                        $obj->narration = 'Sundry Costing for Issue Note ID: ' . $issuenoteID;
                        $obj->detailaccount = '0';
                        $obj->chartaccount = $rowrchartaccount->idtbl_account;
                        $obj->crder = 'C';
                        $segregationdata[] = $obj;
                    endif;
                endforeach;
            }
        }
        catch (Exception $e) {
            $segregationdata = array();
        }

        return $segregationdata;
    }
    public function DirectinvoiceMaterialApi($directinvoiceID){
        $userID = $_SESSION['userid'];
        $companyID = $_SESSION['company_id'];
        $branchID = $_SESSION['branch_id'];
        $segregationdata = array();

        try {
            $this->db->select('inv_no');
            $this->db->from('tbl_direct_invoice');
            $this->db->where('idtbl_direct_invoice', $directinvoiceID);
            $respondinvoice = $this->db->get();
            $invoiceno = $respondinvoice->row(0)->inv_no;

            $this->db->select('SUM(tbl_direct_invoicedetail.issueqty) AS totalqty', FALSE);
            $this->db->select('SUM(tbl_direct_invoicedetail.issueqty * tbl_direct_invoicedetail.unitprice) AS issuetotal', FALSE);
            $this->db->select('tbl_direct_invoicedetail.tbl_print_material_info_idtbl_print_material_info');
            $this->db->select('tbl_account_detail.idtbl_account_detail, tbl_account_detail.accountno, tbl_account_detail.accountname, tbl_print_material_info.materialname');
            $this->db->from('tbl_direct_invoicedetail');
            $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_direct_invoicedetail.tbl_print_material_info_idtbl_print_material_info', 'left');
            $this->db->join('tbl_account_detail', 
                'tbl_account_detail.special_cate_sub = tbl_print_material_info.tbl_material_type_idtbl_material_type 
                AND tbl_account_detail.status = 1 
                AND tbl_account_detail.special_cate_detail = 2', 
                'left'
            );
            $this->db->where('tbl_direct_invoicedetail.status', 2);
            $this->db->where('tbl_direct_invoicedetail.tbl_direct_invoice_idtbl_direct_invoice', $directinvoiceID);
            $this->db->group_by('tbl_direct_invoicedetail.tbl_print_material_info_idtbl_print_material_info');
            $respond = $this->db->get();

            $materialissuenettotal = 0;
            foreach ($respond->result() as $rowmaterial) {
                if(!empty($rowmaterial->idtbl_account_detail)){
                    $obj = new stdClass();
                    $obj->amount = str_replace(",", "", $rowmaterial->issuetotal);
                    $obj->narration = 'Material Costing for ' . $rowmaterial->materialname . ' ' . $directinvoiceID;
                    $obj->detailaccount = $rowmaterial->idtbl_account_detail;
                    $obj->chartaccount = 0;
                    $obj->crder = 'D';
                    $segregationdata[] = $obj;

                    $materialissuenettotal += $rowmaterial->issuetotal;
                }
                else{
                    // $segregationdata = array();
                    // return $segregationdata;
                    throw new Exception("No account detail found for material: " . $rowmaterial->materialname);
                }
            }

            $chartspecialcate = array('37');
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

            foreach($respondchart->result() as $rowrchartaccount):
                if($rowrchartaccount->specialcate==37 && $materialissuenettotal>0):
                    $obj = new stdClass();
                    $obj->amount = str_replace(",", "", $materialissuenettotal);
                    $obj->narration = 'Material Costing for Invoice No: ' . $invoiceno;
                    $obj->detailaccount = '0';
                    $obj->chartaccount = $rowrchartaccount->idtbl_account;
                    $obj->crder = 'C';
                    $segregationdata[] = $obj;
                else:
                    // $segregationdata = array();
                    // return $segregationdata;
                    throw new Exception("No chart account found for special category 37");
                endif;
            endforeach;
        } catch (Exception $e) {
            $segregationdata = array();
        }

        return $segregationdata;
    }
    public function DirectInvoiceApi($directinvoiceID){
        $userID = $_SESSION['userid'];
        $companyID = $_SESSION['company_id'];
        $branchID = $_SESSION['branch_id'];
        $updatedatetime = date('Y-m-d H:i:s');
        $segregationdata = array();
        $svatstatus = 0;
        $vatstatus = 0;

        try {
            $this->db->trans_begin();

            $this->db->select('tbl_direct_invoice.idtbl_direct_invoice,tbl_direct_invoice.date, tbl_direct_invoice.total, tbl_direct_dispatch.tbl_customer_idtbl_customer,tbl_direct_invoice.inv_no, tbl_direct_invoice.vat_amount,tbl_direct_invoice.subtotal,tbl_customer.vat_customer');
            $this->db->from('tbl_direct_invoice');
            $this->db->join('tbl_direct_dispatch', 'tbl_direct_dispatch.idtbl_direct_dispatch  = tbl_direct_invoice.tbl_direct_dispatch_idtbl_direct_dispatch ', 'left');
            $this->db->join('tbl_customer', 'tbl_customer.idtbl_customer  = tbl_direct_dispatch.tbl_customer_idtbl_customer ', 'left');
            $this->db->where('tbl_direct_invoice.status', 1);
            $this->db->where('tbl_direct_invoice.idtbl_direct_invoice', $directinvoiceID);
        
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
                if($respondchart->num_rows() == 0) {
                    throw new Exception("No chart accounts found for special categories 35, 13, or 18.");
                }

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

            if($respondchart->num_rows() == 0) {
                throw new Exception("No chart accounts found for special categories 35, 13, or 18.");
            }

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

            $this->db->trans_commit();
        }
        catch (Exception $e) {
            $this->db->trans_rollback();
            $segregationdata = array();
        }

        return $segregationdata;
    }
}