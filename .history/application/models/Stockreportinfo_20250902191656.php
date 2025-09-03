<?php
class Stockreportinfo extends CI_Model{
    public function Getlocation(){
        $this->db->select('`idtbl_location`, `location`');
        $this->db->from('tbl_location');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Getsupplier(){
        $this->db->select('`idtbl_supplier`, `suppliername`');
        $this->db->from('tbl_supplier');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Getordertype(){
        $this->db->select('`idtbl_material_group`, `group`');
        $this->db->from('tbl_material_group');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Getproductaccosupplier(){
        $recordID=$this->input->post('recordID');
        $sql="SELECT `idtbl_print_material_info`, `materialinfocode`, `materialname` FROM `tbl_print_material_info` WHERE `tbl_supplier_idtbl_supplier`=?";
        $respond=$this->db->query($sql, array($recordID));

        echo json_encode($respond->result());
    }
    public function Purchaseorderinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $tableData=$this->input->post('tableData');
        $orderdate=$this->input->post('orderdate');
        $duedate=$this->input->post('duedate');
        $total=$this->input->post('total');
        $remark=$this->input->post('remark');
        $supplier=$this->input->post('supplier');
        $location=$this->input->post('location');
        $ordertype=$this->input->post('ordertype');

        $updatedatetime=date('Y-m-d H:i:s');

        $data = array(
            'orderdate'=> $orderdate, 
            'duedate'=> $duedate, 
            'subtotal'=> $total, 
            'discount'=> '0', 
            'discountamount'=> '0', 
            'nettotal'=> $total, 
            'confirmstatus'=> '0', 
            'grnconfirm'=> '0', 
            'remark'=> $remark, 
            'status'=> '1', 
            'insertdatetime'=> $updatedatetime, 
            'tbl_user_idtbl_user'=> $userID,
            'tbl_location_idtbl_location'=> $location,
            'tbl_supplier_idtbl_supplier'=> $supplier,
            'tbl_material_group_idtbl_material_group'=> $ordertype
        );

        $this->db->insert('tbl_print_porder', $data);

        $porderID=$this->db->insert_id();

        foreach($tableData as $rowtabledata){
            $materialname=$rowtabledata['col_1'];
            $comment=$rowtabledata['col_2'];
            $materialID=$rowtabledata['col_3'];
            $unit=$rowtabledata['col_4'];
            $qty=$rowtabledata['col_5'];
            $nettotal=$rowtabledata['col_6'];

            $dataone = array(
                'qty'=> $qty, 
                'unitprice'=> $unit, 
                'discount'=> '0', 
                'discountamount'=> '0', 
                'comment'=> $comment, 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime,
                'tbl_print_porder_idtbl_print_porder'=> $porderID, 
                'tbl_print_material_info_idtbl_print_material_info'=> $materialID
            );

            $this->db->insert('tbl_print_porder_detail', $dataone);
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
    public function Purchaseorderview(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `u`.*, `ua`.`suppliername`, `ua`.`address_line1`, `ub`.`location`, `ub`.`phone`, `ub`.`address`, `ub`.`phone2`, `ub`.`email` AS `locemail` FROM `tbl_print_porder` AS `u` LEFT JOIN `tbl_supplier` AS `ua` ON (`ua`.`idtbl_supplier` = `u`.`tbl_supplier_idtbl_supplier`) LEFT JOIN `tbl_location` AS `ub` ON (`ub`.`idtbl_location` = `u`.`tbl_location_idtbl_location`) WHERE `u`.`status`=? AND `u`.`idtbl_print_porder`=?";
        $respond=$this->db->query($sql, array(1, $recordID));

        $this->db->select('tbl_print_porder_detail.*, tbl_print_material_info.materialinfocode, tbl_print_material_info.materialname');
        $this->db->from('tbl_print_porder_detail');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_print_porder_detail.tbl_print_material_info_idtbl_print_material_info', 'left');
        $this->db->where('tbl_print_porder_detail.tbl_print_porder_idtbl_print_porder', $recordID);
        $this->db->where('tbl_print_porder_detail.status', 1);

        $responddetail=$this->db->get();
        // print_r($this->db->last_query());

        $html='';
        $html.='
        <div class="row">
            <div class="col-12">'.$respond->row(0)->name.'<br>'.$respond->row(0)->address.'</div>
            <div class="col-12 text-right">'.$respond->row(0)->location.'<br>'.$respond->row(0)->phone.' / '.$respond->row(0)->phone2.'<br>'.$respond->row(0)->address.'<br>'.$respond->row(0)->locemail.'</div>
        </div>
        <div class="row">
            <div class="col-12">
                <hr>
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>Material Info</th>
                            <th>Unit Price</th>
                            <th>Qty</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>';
                    foreach($responddetail->result() as $roworderinfo){
                        $html.='<tr>
                            <td>'.$roworderinfo->materialname.' / '.$roworderinfo->materialinfocode.'</td>
                            <td>'.$roworderinfo->unitprice.'</td>
                            <td>'.$roworderinfo->qty.'</td>
                            <td class="text-right">'.number_format(($roworderinfo->qty*$roworderinfo->unitprice), 2).'</td>
                        </tr>';
                    }
                    $html.='</tbody>
                </table>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12 text-right"><h3 class="font-weight-normal">Rs. '.number_format(($respond->row(0)->nettotal), 2).'</h3></div>
        </div>
        ';

        echo $html;
    }
    public function Purchaseorderstatus($x, $y){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $recordID=$x;
        $type=$y;
        $updatedatetime=date('Y-m-d H:i:s');

        if($type==1){
            $data = array(
                'confirmstatus' => '1',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_print_porder', $recordID);
            $this->db->update('tbl_print_porder', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-check';
                $actionObj->title='';
                $actionObj->message='Order Confirm Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='success';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Purchaseorder');                
            } else {
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
                redirect('Purchaseorder');
            }
        }
    }
}