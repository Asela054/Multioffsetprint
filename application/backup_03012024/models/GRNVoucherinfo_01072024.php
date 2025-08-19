<?php class GRNVoucherinfo extends CI_Model {

public function Getcosttype() {
    $this->db->select('`idtbl_import_cost_types`, `cost_type`');
    $this->db->from('tbl_import_cost_types');
    $this->db->where('status', 1);

    return $respond=$this->db->get();
}

public function Getmeasuretype() {
    $this->db->select('`idtbl_mesurements`, `measure_type`');
    $this->db->from('tbl_measurements');
    $this->db->where('status', 1);

    return $respond=$this->db->get();
}

public function Getsupplier() {
    $this->db->select('`idtbl_supplier`, `name`');
    $this->db->from('tbl_supplier');
    $this->db->join('tbl_supplier_type', 'tbl_supplier_type.idtbl_supplier_type=tbl_supplier.tbl_supplier_type_idtbl_supplier_type', 'left');
    $this->db->where('tbl_supplier.status', 1);
    $this->db->where('tbl_supplier.tbl_supplier_type_idtbl_supplier_type', 2);

    return $respond=$this->db->get();
}

public function Getporder() {
    $this->db->select('`idtbl_print_porder`');
    $this->db->from('tbl_print_porder');
    $this->db->where('status', 1);
    $this->db->where('confirmstatus', 1);
    $this->db->where('grnconfirm', 0);
    $this->db->where_in('tbl_order_type_idtbl_order_type', array(1, 3, 4));


    return $respond=$this->db->get();
}

public function Getproductaccosupplier() {
    $recordID=$this->input->post('recordID');

    $sql="SELECT `tbl_print_material_info`.`idtbl_print_material_info`, `tbl_print_material_info`.`materialinfocode`, `tbl_material_code`.`materialname` FROM `tbl_print_material_info` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_print_material_info`.`tbl_material_code_idtbl_material_code` WHERE `tbl_print_material_info`.`status`=? AND `tbl_print_material_info`.`tbl_material_category_idtbl_material_category` IN (SELECT `tbl_material_category_idtbl_material_category` FROM `tbl_supplier_has_tbl_material_category` WHERE `tbl_supplier_idtbl_supplier`=?)";
    $respond=$this->db->query($sql, array(1, $recordID));

    echo json_encode($respond->result());
}

// public function Getproductformachine(){
//     $recordID=$this->input->post('recordID');
//     $sql="SELECT `idtbl_machine`, `machine` FROM `tbl_machine` ";
//     $respond=$this->db->query($sql, array($recordID));

//     echo json_encode($respond->result());
// }

public function Getgoodreceiveid() {
    $recordID=$this->input->post('recordID');

    $sql="SELECT `idtbl_print_grn` FROM `tbl_print_grn` WHERE `idtbl_print_grn`=? AND `status`=1";
    $respond=$this->db->query($sql, array($recordID));

    echo json_encode($respond->result());
}

public function GRNvoucherinsertupdate() {
    $this->db->trans_begin();

    $userID=$_SESSION['userid'];

    $tableData=$this->input->post('tableData');
    $grndate=$this->input->post('grndate');
    $total=$this->input->post('total');
    $remark=$this->input->post('remark');
    $supplier=$this->input->post('supplier');
    $grnno=$this->input->post('grnno');

    $updatedatetime=date('Y-m-d H:i:s');

    $data=array(
        'date'=> $grndate,
        'total'=> $total,
        'remarks'=> $remark,
        'approvestatus'=> '0',
        'status'=> '1',
        'insertdatetime'=> $updatedatetime,
        'tbl_user_idtbl_user'=> $userID,
        'tbl_print_grn_idtbl_print_grn'=> $grnno
    );

    $this->db->insert('tbl_grn_vouchar_import_cost', $data);

    $grnvoucherID=$this->db->insert_id();

        foreach($tableData as $rowtabledata) {
            $comment=$rowtabledata['col_1'];
            $costtype=$rowtabledata['col_3'];
            $amount=$rowtabledata['col_4'];

            $dataone=array(
                'cost_amount'=> $amount,
                'comment'=> $comment,
                'status'=> '1',
                'insertdatetime'=> $updatedatetime,
                'tbl_grn_vouchar_import_cost_idtbl_grn_vouchar_import_cost'=> $grnvoucherID,
                'tbl_import_cost_types_idtbl_import_cost_types'=> $costtype
            );

            $this->db->insert('tbl_grn_vouchar_import_cost_detail', $dataone);
        }

    if ($this->db->trans_status()===TRUE) {
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
    }

    else {
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

public function Goodreceivevoucherstatus($x, $y, $z) {
    $this->db->trans_begin();

    $userID=$_SESSION['userid'];
    $recordID=$x;
    $type=$y;
    $porderid=$z;
    $updatedatetime=date('Y-m-d H:i:s');

    if($type==1) {
        $data=array('approvestatus'=> '1',
            'updateuser'=> $userID,
            'updatedatetime'=> $updatedatetime);

        $this->db->where('idtbl_grn_vouchar_import_cost', $recordID);
        $this->db->update('tbl_grn_vouchar_import_cost', $data);

        $this->db->trans_complete();

        if ($this->db->trans_status()===TRUE) {
            $this->db->trans_commit();

            $actionObj=new stdClass();
            $actionObj->icon='fas fa-check';
            $actionObj->title='';
            $actionObj->message='Voucher Confirm Successfully';
            $actionObj->url='';
            $actionObj->target='_blank';
            $actionObj->type='success';

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

    else if($type==3) {
        $data=array('status'=> '3',
            'updateuser'=> $userID,
            'updatedatetime'=> $updatedatetime);

        $this->db->where('idtbl_grn_vouchar_import_cost', $recordID);
        $this->db->update('tbl_grn_vouchar_import_cost', $data);

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

public function Getsupplieraccoporder() {
    $recordID=$this->input->post('recordID');

    $this->db->select('`tbl_supplier_idtbl_supplier`');
    $this->db->from('tbl_print_porder');
    $this->db->where('status', 1);
    $this->db->where('idtbl_print_porder', $recordID);

    $respond=$this->db->get();

    echo $respond->row(0)->tbl_supplier_idtbl_supplier;
}

public function Getlocationaccoporder() {
    $recordID=$this->input->post('recordID');

    $this->db->select('`tbl_location_idtbl_location`');
    $this->db->from('tbl_print_porder');
    $this->db->where('status', 1);
    $this->db->where('idtbl_print_porder', $recordID);

    $respond=$this->db->get();

    echo $respond->row(0)->tbl_location_idtbl_location;
}
// public function Getporderaccsu() {
// 	$recordID=$this->input->post('recordID');

// 	$this->db->select('`idtbl_print_porder`');
// 	$this->db->from('tbl_print_porder');
// 	$this->db->where('status', 1);
// 	$this->db->where('tbl_supplier_idtbl_supplier', $recordID);
// 	// $this->db->where('tbl_print_porder_idtbl_print_porder', $grn_id);

// 	$respond=$this->db->get();

// 	echo $respond->row(0)->idtbl_print_porder;
// }

 public function Getgrnaccsupllier() {
        $recordID = $this->input->post('recordID');
    
        $this->db->select('idtbl_print_grn');
        $this->db->from('tbl_print_grn');
        $this->db->where('status', 1);
        $this->db->where('approvestatus', 1);
        $this->db->where('tbl_supplier_idtbl_supplier', $recordID);
        $this->db->where_in('tbl_order_type_idtbl_order_type', array(1, 3, 4));
    
        $respond = $this->db->get();
    
        if ($respond->num_rows() > 0) {
            echo json_encode($respond->result());
        }
    }
    
//////////////////////////////////////////////// Get Materials product/////////////////////////////////////////

public function Getproductaccoporder() {
    $recordID=$this->input->post('recordID');

    $sql="SELECT `tbl_print_material_info`.`idtbl_print_material_info`, `tbl_print_material_info`.`materialinfocode`, `tbl_print_material_info`.`materialname` FROM `tbl_print_porder_detail` LEFT JOIN `tbl_print_material_info` ON `tbl_print_material_info`.`idtbl_print_material_info`=`tbl_print_porder_detail`.`tbl_material_id` WHERE `tbl_print_material_info`.`status`=? AND `tbl_print_porder_detail`.`tbl_print_porder_idtbl_print_porder`=?";
    $respond=$this->db->query($sql, array(1, $recordID));

    echo json_encode($respond->result());
}

//////////////////////////////////////////////// Get Spare part product/////////////////////////////////////////
public function Getproductforsparepart() {
    $recordID=$this->input->post('recordID');

    $sql="SELECT `tbl_spareparts`.`idtbl_spareparts`, `tbl_spareparts`.`spare_part_name` FROM `tbl_print_porder_detail` LEFT JOIN `tbl_spareparts` ON `tbl_spareparts`.`idtbl_spareparts` = `tbl_print_porder_detail`.`tbl_sparepart_id` WHERE `tbl_spareparts`.`status` = ? AND `tbl_print_porder_detail`.`tbl_print_porder_idtbl_print_porder` = ?";
    $respond=$this->db->query($sql, array(1, $recordID));

    echo json_encode($respond->result());
}

//////////////////////////////////////////////// Get Machine product/////////////////////////////////////////
public function Getproductformachine() {
    $recordID=$this->input->post('recordID');

    $sql="SELECT `tbl_machine`.`idtbl_machine`, `tbl_machine`.`machine` FROM `tbl_print_porder_detail` LEFT JOIN `tbl_machine` ON `tbl_machine`.`idtbl_machine` = `tbl_print_porder_detail`.`tbl_machine_id` WHERE `tbl_machine`.`status` = ? AND `tbl_print_porder_detail`.`tbl_print_porder_idtbl_print_porder` = ?";
    $respond=$this->db->query($sql, array(1, $recordID));

    echo json_encode($respond->result());
}

// new//////////////////////////////////////////
public function Getproductinfoaccoproduct() {
    $recordID=$this->input->post('recordID');
    $grn_id=$this->input->post('grn_id');

    $this->db->select('`qty`, `unitprice`, `comment`, `measure_type_id`');
    $this->db->from('tbl_print_porder_detail');
    $this->db->where('status', 1);
    $this->db->where('tbl_print_porder_idtbl_print_porder', $grn_id);
    $this->db->where('tbl_material_id', $recordID);

    $respond=$this->db->get();

    if($respond->num_rows()>0) {
        $obj=new stdClass();
        $obj->qty=$respond->row(0)->qty;
        $obj->uom=$respond->row(0)->measure_type_id;
        $obj->unitprice=$respond->row(0)->unitprice;
        $obj->comment=$respond->row(0)->comment;
    }

    else {
        $obj=new stdClass();
        $obj->qty=0;
        $obj->unitprice=0;
        $obj->comment='';
        $obj->uom='';
    }

    echo json_encode($obj);
}

public function Getproductinfoamachine() {
    $recordID=$this->input->post('recordID');
    $porderid=$this->input->post('grn_id');

    $this->db->select('`qty`, `unitprice`, `comment` ,`measure_type_id`');
    $this->db->from('tbl_print_porder_detail');
    $this->db->where('status', 1);
    $this->db->where('tbl_machine_id', $recordID);
    $this->db->where('tbl_print_porder_idtbl_print_porder', $porderid);

    $respond=$this->db->get();

    if($respond->num_rows()>0) {
        $obj=new stdClass();
        $obj->qty=$respond->row(0)->qty;
        $obj->unitprice=$respond->row(0)->unitprice;
        $obj->uom=$respond->row(0)->measure_type_id;
        $obj->comment=$respond->row(0)->comment;
    }

    else {
        $obj=new stdClass();
        $obj->qty=0;
        $obj->unitprice=0;
        $obj->comment='';
        $obj->uom='';
    }

    echo json_encode($obj);
}

public function Getproductinfosparepart() {
    $recordID=$this->input->post('recordID');
    $porderid=$this->input->post('grn_id');

    $this->db->select('`qty`, `unitprice`, `comment` ,`measure_type_id`');
    $this->db->from('tbl_print_porder_detail');
    $this->db->where('status', 1);
    $this->db->where('tbl_sparepart_id', $recordID);
    $this->db->where('tbl_print_porder_idtbl_print_porder', $porderid);

    $respond=$this->db->get();

    if($respond->num_rows()>0) {
        $obj=new stdClass();
        $obj->qty=$respond->row(0)->qty;
        $obj->unitprice=$respond->row(0)->unitprice;
        $obj->uom=$respond->row(0)->measure_type_id;
        $obj->comment=$respond->row(0)->comment;
    }

    else {
        $obj=new stdClass();
        $obj->qty=0;
        $obj->unitprice=0;
        $obj->comment='';
        $obj->uom='';
    }

    echo json_encode($obj);
}

// public function Getexpdateaccoquater(){
//     $recordID=$this->input->post('recordID');
//     $mfdate=$this->input->post('mfdate');

//     if($recordID==1){$addmonth=3;}
//     else if($recordID==2){$addmonth=6;}
//     else if($recordID==3){$addmonth=9;}
//     else if($recordID==4){$addmonth=12;}
//     else if($recordID==5){$addmonth=18;}
//     else if($recordID==6){$addmonth=24;}

//     echo date('Y-m-d', strtotime("+$addmonth months", strtotime($mfdate)));
// }
public function Getbatchnoaccosupplier() {
    $recordID=$this->input->post('recordID');

    if( !empty($recordID)) {
        $this->db->select('tbl_supplier.`idtbl_supplier`, tbl_material_category.categorycode');
        $this->db->from('tbl_supplier');
        $this->db->join('tbl_supplier_has_tbl_material_category', 'tbl_supplier_has_tbl_material_category.tbl_supplier_idtbl_supplier = tbl_supplier.idtbl_supplier', 'left');
        $this->db->join('tbl_material_category', 'tbl_material_category.idtbl_material_category = tbl_supplier_has_tbl_material_category.tbl_material_category_idtbl_material_category', 'left');
        $this->db->where('tbl_supplier.idtbl_supplier', $recordID);
        $this->db->where('tbl_supplier.status', 1);

        $responddetail=$this->db->get();

        // print_r($this->db->last_query());    
        $materialcode=$responddetail->row(0)->categorycode;
        $supplierid=$responddetail->row(0)->idtbl_supplier;

        $sql="SELECT COUNT(*) AS `count` FROM `tbl_print_grn`";
        $respond=$this->db->query($sql);

        if($respond->row(0)->count==0) {
            $batchno=date('dmY').'001';
        }

        else {
            $count='000'.($respond->row(0)->count+1);
            $count=substr($count, -3);
            $batchno=date('dmY').$count;
        }

        echo $supplierid.$materialcode.$batchno;
    }

    else {
        echo '';
    }
}


// public function GetBatchNoFromMachineAndMaterialInfo() {
//     $recordID = $this->input->post('recordID');

//     if (!empty($recordID)) {
//         // Query to get information from tbl_machine
//         $this->db->select('tbl_machine.`idtbl_machine`, tbl_machine.machinecode');
//         $this->db->from('tbl_machine');
//         $this->db->where('tbl_machine.idtbl_machine', $recordID);
//         $this->db->where('tbl_machine.status', 1);

//         $machineInfo = $this->db->get();
//         $machineCode = $machineInfo->row(0)->machinecode;
//         $machineId = $machineInfo->row(0)->idtbl_machine;

//         // Query to get information from tbl_print_material_info
//         $this->db->select('tbl_print_material_info.`idtbl_print_material_info`, tbl_print_material_info.materialinfocode');
//         $this->db->from('tbl_print_material_info');
//         $this->db->where('tbl_print_material_info.tbl_machine_idtbl_machine', $machineId);
//         $this->db->where('tbl_print_material_info.status', 1);

//         $materialInfo = $this->db->get();
//         $materialCode = $materialInfo->row(0)->materialinfocode;
//         $materialInfoId = $materialInfo->row(0)->idtbl_print_material_info;

//         $sql = "SELECT COUNT(*) AS `count` FROM `tbl_print_grn`";
//         $response = $this->db->query($sql);

//         if ($response->row(0)->count == 0) {
//             $batchNo = date('dmY') . '001';
//         } else {
//             $count = '000' . ($response->row(0)->count + 1);
//             $count = substr($count, -3);
//             $batchNo = date('dmY') . $count;
//         }

//         echo $machineCode . $materialCode . $batchNo;
//     } else {
//         echo '';
//     }
// }


public function Getordertype() {
    $this->db->select('`idtbl_order_type`, `type`');
    $this->db->from('tbl_order_type');
    $this->db->where('status', 1);
    $this->db->where_in('idtbl_order_type', array(1, 3, 4));

    return $respond=$this->db->get();
}

public function Getpordertpeaccoporder() {
    $recordID=$this->input->post('recordID');

    $this->db->select('`tbl_order_type_idtbl_order_type`');
    $this->db->from('tbl_print_porder');
    $this->db->where('status', 1);
    $this->db->where('idtbl_print_porder', $recordID);

    $respond=$this->db->get();

    echo $respond->row(0)->tbl_order_type_idtbl_order_type;
}

public function Getvatpresentage() {
    $recordCurrentDate=$this->input->post('currentDate');
    $currentDate = date('Y-m-d');

    $useDate='';

    if($recordCurrentDate==$currentDate){
        $useDate=$currentDate;
    }else{
        $useDate=$recordCurrentDate;
    }

    $this->db->select('*');
    $this->db->from('tbl_tax_control');
    $this->db->where('status', 1);
    $this->db->where("DATE(effective_from) <=", $useDate);
    $this->db->where("(DATE(effective_to) >= '$useDate' OR effective_to IS NULL)");

    $respond = $this->db->get();
    $taxPercentage='';

    if ($respond->num_rows() > 0) {
        $taxPercentage = $respond->row()->percentage;

        if ($taxPercentage !== null && $taxPercentage !== 0) {
            echo $taxPercentage;
        } else {
            echo $taxPercentage=0;
        }
    } else {
        echo $taxPercentage=0;
    }



}

}
