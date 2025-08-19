<?php
class Goodreceiverequestinfo extends CI_Model{
    // public function Getcompany(){
    //     $this->db->select('`id`, `name`');
    //     $this->db->from('companies');
    //     // $this->db->where('status', 1);

    //     return $respond=$this->db->get();
    // }
    public function Getlocation() {
		$this->db->select('`idtbl_location`, `location`');
		$this->db->from('tbl_location');
		$this->db->where('status', 1);

		return $respond=$this->db->get();
	}

    public function Getdepartment(){
        $this->db->select('`id`, `name`');
        $this->db->from('departments');
        // $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Getservicetype(){
        $this->db->select('`idtbl_service_type`, `service_name`');
        $this->db->from('tbl_service_type');
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
        $this->db->select('`idtbl_order_type`, `type`');
        $this->db->from('tbl_order_type');
        $this->db->where('status', 1);
        $this->db->where_in('idtbl_order_type', array(3, 4)); // Filter for idtbl_order_type 3 and 4

        return $respond=$this->db->get();
    }

    public function Getproductaccosupplier(){
        $recordID=$this->input->post('recordID');
        $sql="SELECT `idtbl_print_material_info`, `materialinfocode`, `materialname` FROM `tbl_print_material_info` ";
        $respond=$this->db->query($sql, array($recordID));

        echo json_encode($respond->result());
    }

    public function Getproductforvehicle(){
        $recordID=$this->input->post('recordID');
        $sql="SELECT `idtbl_service_item_list`, `service_type` FROM `tbl_service_item_list` ";
        $respond=$this->db->query($sql, array($recordID));

        echo json_encode($respond->result());
    }
    public function Getproductformachine(){
        $recordID=$this->input->post('recordID');
        $sql="SELECT `idtbl_machine`, `machine` FROM `tbl_machine`";
        $respond=$this->db->query($sql, array($recordID));

        echo json_encode($respond->result());
    }


    public function Goodreceiverequestinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $tableData=$this->input->post('tableData');
        // $orderdate=$this->input->post('orderdate');
        // $duedate=$this->input->post('duedate');
        // $total=$this->input->post('total');
        $company=$this->input->post('company');
        $department=$this->input->post('department');
        $reason=$this->input->post('reason');
        $ordertype=$this->input->post('ordertype');
        $servicetype=$this->input->post('servicetype');

        $updatedatetime=date('Y-m-d H:i:s');

        $data = array(
            // 'orderdate'=> $orderdate, 
            // 'duedate'=> 'null', 
            'departments_id '=> $department, 
            // 'discount'=> '0', 
            // 'discountamount'=> '0', 
            // 'nettotal'=> $total, 
            'confirmstatus'=> '0', 
            // 'grnconfirm'=> '0', 
            'company_id '=> $company, 
            'status'=> '1', 
            'tbl_service_type_idtbl_service_type'=> $servicetype,
            'insertdatetime'=> $updatedatetime, 
            'tbl_user_idtbl_user'=> $userID,
            // 'tbl_location_idtbl_location'=> '1',
            // 'tbl_supplier_idtbl_supplier'=> $supplier,
            'tbl_order_type_idtbl_order_type'=> $ordertype
            
        );

        $this->db->insert('tbl_grn_req', $data);

        $porderID=$this->db->insert_id();

        if($ordertype==3){
        foreach ($tableData as $rowtabledata) {
            $materialname = $rowtabledata['col_1'];
            $reason = $rowtabledata['col_4'];
            $materialID = $rowtabledata['col_2'];
            // $unit = $rowtabledata['col_4'];
            $qty = $rowtabledata['col_3'];
            // $nettotal = $rowtabledata['col_6'];
        
            $dataone = array(
                'qty' => $qty,
                // 'unitprice' => $unit,
                // 'discount' => '0',
                // 'discountamount' => '0',
                'comment' => $reason,
                'status' => '1',
                'insertdatetime' => $updatedatetime,
                'tbl_grn_req_idtbl_grn_req' => $porderID,
                'tbl_material_id' => $materialID,
            );
        
            $this->db->insert('tbl_grn_req_detail', $dataone);
        }
        }
        else if($ordertype==4){
            foreach ($tableData as $rowtabledata) {
                $materialname = $rowtabledata['col_1'];
                $reason = $rowtabledata['col_4'];
                $materialID = $rowtabledata['col_2'];
                // $unit = $rowtabledata['col_4'];
                $qty = $rowtabledata['col_3'];
                // $nettotal = $rowtabledata['col_6'];
            
                $dataone = array(
                    'qty' => $qty,
                    // 'unitprice' => $unit,
                    // 'discount' => '0',
                    // 'discountamount' => '0',
                    'comment' => $reason,
                    'status' => '1',
                    'insertdatetime' => $updatedatetime,
                    'tbl_grn_req_idtbl_grn_req' => $porderID,
                    'tbl_machine_id' => $materialID,
                );
            
                $this->db->insert('tbl_grn_req_detail', $dataone);
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
    public function Grnorderview(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `u`.*, `ua`.`location` AS `locemail`,  `ub`.`name` AS `departname`, `uc`.`type` AS `ordertype` FROM `tbl_grn_req` AS `u` LEFT JOIN `tbl_location` AS `ua` ON (`ua`.`idtbl_location` = `u`.`company_id`)  LEFT JOIN `departments` AS `ub` ON (`ub`.`id` = `u`.`departments_id`)  LEFT JOIN `tbl_order_type` AS `uc` ON (`uc`.`idtbl_order_type` = `u`.`tbl_order_type_idtbl_order_type`)WHERE `u`.`status`=? AND `u`.`idtbl_grn_req`=?";
        $respond=$this->db->query($sql, array(1, $recordID));

        $this->db->select('tbl_grn_req_detail.*,tbl_grn_req.tbl_order_type_idtbl_order_type, tbl_print_material_info.materialinfocode, tbl_print_material_info.materialname,tbl_machine.machine,tbl_machine.machinecode ');
        $this->db->from('tbl_grn_req_detail');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_grn_req_detail.tbl_material_id', 'left');
        $this->db->join('tbl_machine', 'tbl_machine.idtbl_machine = tbl_grn_req_detail.tbl_machine_id', 'left');
        // $this->db->join('tbl_service_type', 'tbl_service_type.idtbl_service_type = tbl_grn_req_detail.tbl_service_type_id', 'left');
        $this->db->join('tbl_grn_req', 'tbl_grn_req.idtbl_grn_req = tbl_grn_req_detail.tbl_grn_req_idtbl_grn_req', 'left');
        // $this->db->join('tbl_service_type', 'tbl_service_type.idtbl_service_type = tbl_print_porder_req.tbl_service_type_idtbl_service_type', 'left'); // Add this line to join tbl_service_type
        $this->db->where('tbl_grn_req_detail.tbl_grn_req_idtbl_grn_req', $recordID);
        $this->db->where('tbl_grn_req_detail.status', 1);

        $responddetail=$this->db->get();
        // print_r($this->db->last_query());

        $html='';
        $html.='<div style="display:flex;"><div><img src="images/book.jpg" alt=""></div>
        <div style="margin-left:375px;"><h2  class="text-right">Internal Item Request</h2>
        <p class="text-right">MO/IR-<b>'.$respond->row(0)->idtbl_grn_req.'</b></P></div></div>
        <div class="row">
        
        <div class="col-12 text-right"></div>
            <div class="col-12 text-left">
                <hr>
                <h6>Company : '.$respond->row(0)->locemail.'</h6>
                <h6>Department : '.$respond->row(0)->departname.'</h6>
                <h6>Order Type : '.$respond->row(0)->ordertype.'</h6>
            </div>
            
        </div>
        <div class="row">
            <div class="col-12">
                <hr>
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th class="text-center">Qty</th>
                        </tr>
                    </thead>
                    <tbody>';
                    foreach($responddetail->result() as $roworderinfo){
                        if($roworderinfo->tbl_order_type_idtbl_order_type==3){
                            $html.='<tr>
                            <td>'.$roworderinfo->materialname.' / '.$roworderinfo->materialinfocode.'</td>
                            <td class="text-center">'.$roworderinfo->qty.'</td>
                        </tr>';
                        } 
                        else if($roworderinfo->tbl_order_type_idtbl_order_type==4){
                            $html.='<tr>
                            <td>'.$roworderinfo->machine.' / '.$roworderinfo->machinecode.'</td>
                            <td class="text-center">'.$roworderinfo->qty.'</td>
                        </tr>';
                        }
                    }
                    $html.='</tbody>
                </table>
            </div>
        </div>
        ';

        echo $html;
    }
    // public function porderviewheader(){
    //     $recordID=$this->input->post('recordID');

    //     $this->db->select('tbl_print_porder_req.*,tbl_supplier.name AS suppliername,tbl_supplier.telephone_no AS suppliercontact,tbl_supplier.address_line1 AS address1,tbl_supplier.address_line2 AS address2,tbl_supplier.city AS city,tbl_supplier.state AS supplierstate');
    //     $this->db->from('tbl_print_porder_req');
    //     $this->db->join('tbl_supplier', 'tbl_supplier.idtbl_supplier  = tbl_print_porder_req.tbl_supplier_idtbl_supplier ', 'left'); 
    //     // $this->db->join('tbl_supplier_contact_details', 'tbl_supplier_contact_details.tbl_supplier_idtbl_supplier   = tbl_supplier.idtbl_supplier', 'left'); 
    //     $this->db->where('idtbl_print_porder_req', $recordID);
    //     $this->db->where('tbl_print_porder_req.status', 1);

    //     $respond=$this->db->get();

    //     $obj=new stdClass();
    //     // $obj->orderdate=$respond->row(0)->orderdate;
    //     $obj->suppliername=$respond->row(0)->suppliername;
    //     $obj->suppliercontact=$respond->row(0)->suppliercontact;
    //     $obj->address1=$respond->row(0)->address1;
    //     $obj->address2=$respond->row(0)->address2;
    //     $obj->city=$respond->row(0)->city;
    //     $obj->state=$respond->row(0)->supplierstate;

    //     echo json_encode($obj);
    // }
    public function Goodreceiverequeststatus($x, $y){
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

            $this->db->where('idtbl_grn_req', $recordID);
            $this->db->update('tbl_grn_req', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-check';
                $actionObj->title='';
                $actionObj->message='GRN Request Confirm Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='success';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Goodreceiverequest');                
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
                redirect('Goodreceiverequest');
            }
        }
    }
}
