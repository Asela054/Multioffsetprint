<?php
    use Dompdf\Dompdf;
    use Dompdf\Options;
    class GRNVoucherinfo extends CI_Model{
	
    public function Getcostlisttype() {
        $this->db->select('`idtbl_import_cost_types`, `cost_type`');
        $this->db->from('tbl_import_cost_types');
        $this->db->where('status', 1);
    
        return $respond=$this->db->get();
    }
    public function Getsupplierlist() {
        $this->db->select('idtbl_supplier, name');
        $this->db->from('tbl_supplier');
        $this->db->where('status', 1);
    
        return $this->db->get();
    }    
    public function get_grn_details($grnno) {
        $this->db->select('tbl_print_grndetail.*,tbl_print_grn.tbl_order_type_idtbl_order_type, tbl_print_material_info.idtbl_print_material_info, tbl_print_material_info.materialinfocode, tbl_print_material_info.materialname,tbl_machine.machine,tbl_machine.machinecode,tbl_measurements.measure_type');
		$this->db->from('tbl_print_grndetail');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_print_grndetail.tbl_print_material_info_idtbl_print_material_info', 'left');
		$this->db->join('tbl_print_grn', 'tbl_print_grn.idtbl_print_grn = tbl_print_grndetail.tbl_print_grn_idtbl_print_grn', 'left');
		$this->db->join('tbl_machine', 'tbl_machine.idtbl_machine = tbl_print_grndetail.tbl_machine_id', 'left');
		$this->db->join('tbl_measurements', 'tbl_measurements.idtbl_mesurements = tbl_print_grndetail.measure_type_id', 'left');
        $this->db->where('tbl_print_grn_idtbl_print_grn', $grnno);
        $this->db->where('tbl_print_grndetail.status', 1);
        $query = $this->db->get();

        $this->db->select('`idtbl_print_grn`, `grn_no`, `vatamount`, `total`, `discount`, `subtotal`, `vat`');
        $this->db->from('tbl_print_grn');
        $this->db->where('idtbl_print_grn', $grnno);
        $this->db->where('status', 1);
    
        $respond=$this->db->get();
        
        if ($query->num_rows() > 0) {
            $obj=new stdClass();
            $obj->idtbl_print_grn=$respond->row(0)->idtbl_print_grn;
            $obj->grn_no=$respond->row(0)->grn_no;
            $obj->vatamount=$respond->row(0)->vatamount;
            $obj->total=$respond->row(0)->total;
            $obj->discount=$respond->row(0)->discount;
            $obj->subtotal=$respond->row(0)->subtotal;
            $obj->vat=$respond->row(0)->vat;
            $obj->detailinfo=$query->result_array();

            return $obj;
        } else {
            return false;
        }
    } 
    public function Insertgrnvoucher() {
        $this->db->trans_begin();
    
        $userID = $_SESSION['userid'];
        $grnDetails = $this->input->post('grnDetails');
        $costDetails = $this->input->post('costDetails');
        $grndate = $this->input->post('date');
        $grnsubtotal = $this->input->post('grnsubtotal');
        $grndiscount = $this->input->post('grndiscount');
        $grnvatamount = $this->input->post('grnvatamount');
        $hidetotalorder = $this->input->post('totalGRN');
        $hidechargestotal = $this->input->post('totalCost');
        $remark = $this->input->post('remark');
        $grnno = $this->input->post('grnno');
        $invoiceno = $this->input->post('invoiceno');
        $company_id=$this->input->post('company_id');
		$branch_id=$this->input->post('branch_id');
    
        $updatedatetime = date('Y-m-d H:i:s');
    
        // Insert the GRN voucher
        $data = array(
            'date' => $grndate,
            'total' => $hidechargestotal,
            'grnsubtotal' => $grnsubtotal,
            'grndiscount' => $grndiscount,
            'grnvatamount' => $grnvatamount,
            'grntotal' => $hidetotalorder,
            'remarks' => $remark,
            'invoiceno' => $invoiceno,
            'approvestatus' => '0',
            'status' => '1',
            'insertdatetime' => $updatedatetime,
            'tbl_user_idtbl_user' => $userID,
            'tbl_print_grn_idtbl_print_grn' => $grnno,
            'company_id'=> $company_id, 
			'company_branch_id'=> $branch_id
        );
    
        $this->db->insert('tbl_grn_vouchar_import_cost', $data);
        $grnvoucherID = $this->db->insert_id();
    
        // Insert the GRN details
        foreach ($grnDetails as $grn) {
            $data = array(
                'date' => $grndate,
                'qty' => $grn['qty'],
                'costunitprice' => $grn['unitprice'],
                'total' => $grn['total'],
                'comment' => $grn['comment'],
                'measure_type_id' => 0,
                'status' => '1',
                'insertdatetime' => $updatedatetime,
                'tbl_print_grn_idtbl_print_grn' => $grnno,
                'tbl_print_material_info_idtbl_print_material_info' => $grn['idtbl_print_material_info']
            );
    
            $this->db->insert('tbl_print_grndetail_after_costing', $data);
        }
    
        // Check if costDetails is empty
        if (empty($costDetails)) {
            // Insert a default entry with cost_amount as 0
            $data = array(
                'cost_amount' => 0,
                'status' => '1',
                'insertdatetime' => $updatedatetime,
                'tbl_grn_vouchar_import_cost_idtbl_grn_vouchar_import_cost' => $grnvoucherID,
                'tbl_import_cost_types_idtbl_import_cost_types' => 0  // Assuming 0 as a default type ID
            );
    
            $this->db->insert('tbl_grn_vouchar_import_cost_detail', $data);
        } else {
            // Insert the cost details
            foreach ($costDetails as $cost) {
                $data = array(
                    'cost_amount' => $cost['chargeamount'],
                    'status' => '1',
                    'insertdatetime' => $updatedatetime,
                    'tbl_grn_vouchar_import_cost_idtbl_grn_vouchar_import_cost' => $grnvoucherID,
                    'tbl_import_cost_types_idtbl_import_cost_types' => $cost['chargetypeid']
                );
    
                $this->db->insert('tbl_grn_vouchar_import_cost_detail', $data);
            }
        }

        //Good receive not voucher issue
        $dataupdategrn=array(
            'voucherissue'=> '1',
            'updateuser'=> $userID,
            'updatedatetime'=> $updatedatetime
        );

        $this->db->where('idtbl_print_grn', $grnno);
        $this->db->update('tbl_print_grn', $dataupdategrn);
    
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
    
            $actionObj = new stdClass();
            $actionObj->icon = 'fas fa-save';
            $actionObj->title = '';
            $actionObj->message = 'Record Added Successfully';
            $actionObj->url = '';
            $actionObj->target = '_blank';
            $actionObj->type = 'success';
    
            $actionJSON = json_encode($actionObj);
    
            $obj = new stdClass();
            $obj->status = 1;
            $obj->action = $actionJSON;
    
            echo json_encode($obj);
        } else {
            $this->db->trans_rollback();
    
            $actionObj = new stdClass();
            $actionObj->icon = 'fas fa-exclamation-triangle';
            $actionObj->title = '';
            $actionObj->message = 'Record Error';
            $actionObj->url = '';
            $actionObj->target = '_blank';
            $actionObj->type = 'danger';
    
            $actionJSON = json_encode($actionObj);
    
            $obj = new stdClass();
            $obj->status = 0;
            $obj->action = $actionJSON;
    
            echo json_encode($obj);
        }
    }
    public function Goodreceivevoucherview() {
        $recordID=$this->input->post('recordID');
    
        $sql="SELECT `u`.*, `ub`.`name`, `ub`.`telephone_no`, `ub`.`address_line1` FROM `tbl_grn_vouchar_import_cost` AS `u` LEFT JOIN `tbl_print_grn` AS `ua` ON (`ua`.`idtbl_print_grn` = `u`.`tbl_print_grn_idtbl_print_grn`) LEFT JOIN `tbl_supplier` AS `ub` ON (`ub`.`idtbl_supplier` = `ua`.`tbl_supplier_idtbl_supplier`) WHERE `u`.`status`=? AND `u`.`idtbl_grn_vouchar_import_cost`=?";
        $respond=$this->db->query($sql, array(1, $recordID));
    
        $this->db->select('tbl_grn_vouchar_import_cost_detail.*, tbl_import_cost_types.cost_type');
        $this->db->from('tbl_grn_vouchar_import_cost_detail');
        $this->db->join('tbl_grn_vouchar_import_cost', 'tbl_grn_vouchar_import_cost.idtbl_grn_vouchar_import_cost = tbl_grn_vouchar_import_cost_detail.tbl_grn_vouchar_import_cost_idtbl_grn_vouchar_import_cost', 'left');
        $this->db->join('tbl_import_cost_types', 'tbl_import_cost_types.idtbl_import_cost_types = tbl_grn_vouchar_import_cost_detail.tbl_import_cost_types_idtbl_import_cost_types', 'left');
        $this->db->where('tbl_grn_vouchar_import_cost_detail.tbl_grn_vouchar_import_cost_idtbl_grn_vouchar_import_cost', $recordID);
        $this->db->where('tbl_grn_vouchar_import_cost_detail.status', 1);
    
        $responddetail=$this->db->get();
        // print_r($this->db->last_query());
    
        $html='';
    
        $html.='
        <div class="row"><div class="col-12 text-right font-family: cursive;font-size:15px; font-weight: bold;">'.$respond->row(0)->name.'</div><div class="col-12"><hr><h6>GRN No: MO/GRN-0000'.$respond->row(0)->tbl_print_grn_idtbl_print_grn.'</h6></div> </div> <div class="row"> <div class="col-12"> <hr> <table class="table table-striped table-bordered table-sm"> <thead> <tr> <th>Cost Type</th> <th class="text-right">Cost Amount</th></tr></thead><tbody>';
        foreach($responddetail->result() as $roworderinfo) {
                    $html.='<tr>
                    <td>'.$roworderinfo->cost_type.'</td><td class="text-right">'.$roworderinfo->cost_amount.'</td></tr>';
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
                                <td width="70%" style="text-align: right; font-weight: bold;">Total Cost</td>
                                <td width="10%" style="text-align: right; font-weight: bold;">:</td>
                                <td width="20%" style="text-align: right; font-weight: bold;">Rs. ' . number_format(($respond->row(0)->total), 2) . '</td>
                            </tr>
    
                        </tbody>
                    </table>
    
                    </body>
                    </html>';
    
        echo $html;
    }
    public function Getgrnaccsupllier() {
        $searchTerm = $this->input->post('searchTerm');
        $companyid=$_SESSION['company_id'];
        $branchid=$_SESSION['branch_id'];

        if(!isset($searchTerm)){        
            $this->db->select('`tbl_print_grn`.`idtbl_print_grn`, `tbl_print_grn`.`grn_no`, `tbl_print_grn`.`invoicenum`, `tbl_supplier`.`name`');
            $this->db->from('tbl_print_grn');
            $this->db->join('tbl_supplier', 'tbl_supplier.idtbl_supplier = tbl_print_grn.tbl_supplier_idtbl_supplier', 'left');
            $this->db->where('tbl_print_grn.status', 1);
            $this->db->where('tbl_print_grn.approvestatus', 1);
            $this->db->where('tbl_print_grn.voucherissue', 0);
            $this->db->where('tbl_print_grn.company_id', $companyid);
            $this->db->where('tbl_print_grn.company_branch_id', $branchid);
            $this->db->limit(5); 
            $respond = $this->db->get();
		}
		else{            
            if(!empty($searchTerm)){
				$this->db->select('`tbl_print_grn`.`idtbl_print_grn`, `tbl_print_grn`.`grn_no`, `tbl_print_grn`.`invoicenum`, `tbl_supplier`.`name`');
                $this->db->from('tbl_print_grn');
                $this->db->join('tbl_supplier', 'tbl_supplier.idtbl_supplier = tbl_print_grn.tbl_supplier_idtbl_supplier', 'left');
                $this->db->where('tbl_print_grn.status', 1);
                $this->db->where('tbl_print_grn.approvestatus', 1);
                $this->db->where('tbl_print_grn.voucherissue', 0);
                $this->db->where('tbl_print_grn.company_id', $companyid);
                $this->db->where('tbl_print_grn.company_branch_id', $branchid);
                $this->db->like('`tbl_print_grn`.`grn_no`', $searchTerm, 'both'); 
                $respond = $this->db->get();
			}
			else{
				$this->db->select('`tbl_print_grn`.`idtbl_print_grn`, `tbl_print_grn`.`grn_no`, `tbl_print_grn`.`invoicenum`, `tbl_supplier`.`name`');
                $this->db->from('tbl_print_grn');
                $this->db->join('tbl_supplier', 'tbl_supplier.idtbl_supplier = tbl_print_grn.tbl_supplier_idtbl_supplier', 'left');
                $this->db->where('tbl_print_grn.status', 1);
                $this->db->where('tbl_print_grn.approvestatus', 1);
                $this->db->where('tbl_print_grn.voucherissue', 0);
                $this->db->where('tbl_print_grn.company_id', $companyid);
                $this->db->where('tbl_print_grn.company_branch_id', $branchid);
                $this->db->limit(5); 
                $respond = $this->db->get();
			}
		}
    
        $data=array();
        
        foreach ($respond->result() as $row) {
            $data[]=array("id"=>$row->idtbl_print_grn, "text"=>$row->grn_no, "suppname" => $row->name, "invoicenum" => $row->invoicenum);
        }
        
        echo json_encode($data);
    }
    public function Goodreceivevoucherstatus($x, $y) {
        $userID=$_SESSION['userid'];
        $company=$_SESSION['company_id'];
        $branch=$_SESSION['branch_id'];
        $recordID=$y;
        $type=$x;
        $updatedatetime=date('Y-m-d H:i:s');
    
        if($type==1) {
            $this->db->trans_begin();

            // Other cost approve
            $data=array(
                'approvestatus'=> '1',
                'updateuser'=> $userID,
                'updatedatetime'=> $updatedatetime
            );
    
            $this->db->where('idtbl_grn_vouchar_import_cost', $recordID);
            $this->db->update('tbl_grn_vouchar_import_cost', $data);

            // Update grn unit price with other cost
            $this->db->select('`tbl_print_grndetail_after_costing`.`costunitprice`, `tbl_print_grndetail_after_costing`.`total`, `tbl_print_grndetail_after_costing`.`tbl_print_material_info_idtbl_print_material_info`, `tbl_print_grndetail_after_costing`.`tbl_print_grn_idtbl_print_grn`');
			$this->db->from('tbl_print_grndetail_after_costing');
            $this->db->join('tbl_grn_vouchar_import_cost', 'tbl_grn_vouchar_import_cost.tbl_print_grn_idtbl_print_grn = tbl_print_grndetail_after_costing.tbl_print_grn_idtbl_print_grn', 'left');
			$this->db->where('tbl_print_grndetail_after_costing.status', 1);
			$this->db->where('tbl_grn_vouchar_import_cost.idtbl_grn_vouchar_import_cost', $recordID);

			$respond=$this->db->get();

            $newnettotal=0;

            foreach($respond->result() as $rowaftercostdata){
                $dataupdategrndetail=array(
                    'costunitprice'=> $rowaftercostdata->costunitprice,
                    'total'=> $rowaftercostdata->total,
                    'updateuser'=> $userID,
                    'updatedatetime'=> $updatedatetime
                );
                $this->db->where('tbl_print_grn_idtbl_print_grn', $rowaftercostdata->tbl_print_grn_idtbl_print_grn);
                $this->db->where('tbl_print_material_info_idtbl_print_material_info', $rowaftercostdata->tbl_print_material_info_idtbl_print_material_info);
                $this->db->update('tbl_print_grndetail', $dataupdategrndetail);

                $newnettotal+=$rowaftercostdata->total;
            }

            $this->db->select('`tbl_print_grn`.`vat`, `tbl_print_grn`.`idtbl_print_grn`, `tbl_print_grn`.`grn_no`, `tbl_print_grn`.`grntype`, `tbl_print_grn`.`grndate`, `tbl_print_grn`.`tbl_supplier_idtbl_supplier`, `tbl_supplier`.`name`, `tbl_grn_vouchar_import_cost`.`grnsubtotal`, `tbl_grn_vouchar_import_cost`.`grndiscount`, `tbl_grn_vouchar_import_cost`.`grnvatamount`, `tbl_grn_vouchar_import_cost`.`grntotal`');
			$this->db->from('tbl_grn_vouchar_import_cost');
            $this->db->join('tbl_print_grn', 'tbl_print_grn.idtbl_print_grn = tbl_grn_vouchar_import_cost.tbl_print_grn_idtbl_print_grn', 'left');
            $this->db->join('tbl_supplier', 'tbl_supplier.idtbl_supplier = tbl_print_grn.tbl_supplier_idtbl_supplier', 'left');
			$this->db->where('tbl_grn_vouchar_import_cost.idtbl_grn_vouchar_import_cost', $recordID);

			$respondgrn=$this->db->get();

            $newvattotal=($newnettotal*$respondgrn->row(0)->vat)/100;
            $withvattotal=$newnettotal+$newvattotal;

            $dataupdategrn=array(
                'subtotal'=> $respondgrn->row(0)->grnsubtotal,
                'vatamount'=> $respondgrn->row(0)->grnvatamount,
                'discount'=> $respondgrn->row(0)->grndiscount,
                'total'=> $respondgrn->row(0)->grntotal,
                'updateuser'=> $userID,
                'updatedatetime'=> $updatedatetime
            );
    
            $this->db->where('idtbl_print_grn', $respondgrn->row(0)->idtbl_print_grn);
            $this->db->update('tbl_print_grn', $dataupdategrn);

            // Expences detail insert
            if($respondgrn->row(0)->grntype==1){$expcode='SPR';}
            else if($respondgrn->row(0)->grntype==3){$expcode='GRN';}
            else if($respondgrn->row(0)->grntype==4){$expcode='MAC';}

            $dataexpence=array(
                'grndate'=> $respondgrn->row(0)->grndate,
                'tbl_supplier_idtbl_supplier'=> $respondgrn->row(0)->tbl_supplier_idtbl_supplier,
                'exptype'=> '1',
                'grnno'=> $respondgrn->row(0)->idtbl_print_grn,
                'expcode'=> $expcode,
                'amount'=> $withvattotal,
                'status'=> '1',
                'insertdatetime'=> $updatedatetime,
                'tbl_user_idtbl_user'=> $userID
            );
            $this->db->insert('tbl_expence_info', $dataexpence);
    
            // Parse to account API
            $narration=$respondgrn->row(0)->grn_no.' on '.$respondgrn->row(0)->grndate.' by '.$respondgrn->row(0)->name;

            if($company==1){
                $chartofaccount=115;
                $detailaccount=0;
                $vatreserve=141;
            }

            $segregationdata=array();

            $obj=new stdClass();
            $obj->amount=$newnettotal;
            $obj->narration=$narration;
            $obj->chartaccount=$chartofaccount;
            $obj->detailaccount=$detailaccount;

            array_push($segregationdata, $obj);

            if($newvattotal>0){
                $obj=new stdClass();
                $obj->amount=$newvattotal;
                $obj->narration=$narration;
                $obj->chartaccount=$vatreserve;
                $obj->detailaccount=$detailaccount;

                array_push($segregationdata, $obj);
            }

            $segregationdataencode=json_encode($segregationdata);
            $supplier=$respondgrn->row(0)->tbl_supplier_idtbl_supplier;
            $invoice=$respondgrn->row(0)->idtbl_print_grn;
            
            $this->db->trans_complete();
            
            if ($this->db->trans_status() === TRUE) {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://aws.erav.lk/multioffsetaccount/Api/Payablesegregationinsertupdate");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, "userid=$userID&company=$company&branch=$branch&supplier=$supplier&invoice=$invoice&invoiceamount=$withvattotal&segregationdata=$segregationdataencode");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $server_output = curl_exec($ch);
                $err = curl_error($ch);
                curl_close($ch);
                // print_r($server_output);

                if ($err) {
                    $this->db->trans_rollback();
        
                    $actionObj = new stdClass();
                    $actionObj->icon = 'fas fa-exclamation-triangle';
                    $actionObj->title = '';
                    $actionObj->message = 'Record Error';
                    $actionObj->url = '';
                    $actionObj->target = '_blank';
                    $actionObj->type = 'danger';
        
                    $actionJSON = json_encode($actionObj);
        
                    $this->session->set_flashdata('msg', $actionJSON);
                    redirect('GRNVoucher');
                } else {
                    $responseArray = json_decode($server_output, true);
                    $responseCode = $responseArray['status'];
                    
                    if ($responseCode==200) {
                        $this->db->trans_commit();
    
                        $actionObj = new stdClass();
                        $actionObj->icon = 'fas fa-save';
                        $actionObj->title = '';
                        $actionObj->message = 'GRN Voucher Confirmed Successfully';
                        $actionObj->url = '';
                        $actionObj->target = '_blank';
                        $actionObj->type = 'success';
        
                        $actionJSON = json_encode($actionObj);

                        $this->session->set_flashdata('msg', $actionJSON);
                        redirect('GRNVoucher');
                    } 
                    else{
                        $this->db->trans_rollback();
        
                        $actionObj = new stdClass();
                        $actionObj->icon = 'fas fa-exclamation-triangle';
                        $actionObj->title = '';
                        $actionObj->message = 'Record Error';
                        $actionObj->url = '';
                        $actionObj->target = '_blank';
                        $actionObj->type = 'danger';
            
                        $actionJSON = json_encode($actionObj);
            
                        $this->session->set_flashdata('msg', $actionJSON);
                        redirect('GRNVoucher');
                    }
                }
            } else {
                $this->db->trans_rollback();

                $actionObj = new stdClass();
                $actionObj->icon = 'fas fa-exclamation-triangle';
                $actionObj->title = '';
                $actionObj->message = 'Record Error';
                $actionObj->url = '';
                $actionObj->target = '_blank';
                $actionObj->type = 'danger';

                $actionJSON = json_encode($actionObj);

                $obj = new stdClass();
                $obj->status = 0;
                $obj->action = $actionJSON;

                echo json_encode($obj);
            }
    
        }
        else if($type==3) {
            $this->db->select('`tbl_print_grn_idtbl_print_grn`');
			$this->db->from('tbl_grn_vouchar_import_cost');
			$this->db->where('idtbl_grn_vouchar_import_cost', $recordID);

			$respondgrn=$this->db->get();

            $data=array(
                'status'=> '3',
                'updateuser'=> $userID,
                'updatedatetime'=> $updatedatetime);
    
            $this->db->where('idtbl_grn_vouchar_import_cost', $recordID);
            $this->db->update('tbl_grn_vouchar_import_cost', $data);

            //Good receive not voucher issue
            $dataupdategrn=array(
                'voucherissue'=> '0',
                'updateuser'=> $userID,
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_print_grn', $respondgrn->row(0)->tbl_print_grn_idtbl_print_grn);
            $this->db->update('tbl_print_grn', $dataupdategrn);
            
    
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
                redirect('GRNVoucher');
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
                redirect('GRNVoucher');
            }
        }
    }
}