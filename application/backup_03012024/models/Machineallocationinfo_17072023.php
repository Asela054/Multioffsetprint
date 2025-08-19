<?php
class Machineallocationinfo extends CI_Model{
    public function Getmachinelist(){
        $this->db->select('`idtbl_machine`, `machine`, `machinecode`');
        $this->db->from('tbl_machine');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Getemployeelist(){
        $this->db->select('`idtbl_employee`, `fullname`, `empno`');
        $this->db->from('tbl_employee');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
   
    public function Machineinsertupdate(){

        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $tableData = $this->input->post('tableData');
        $costitemid=$this->input->post('costitemid');
        $jobid=$this->input->post('jobid');
        $deliveryplan=$this->input->post('deliveryplan');
        $employee=$this->input->post('employee');

        $insertdatetime=date('Y-m-d H:i:s');
        $allocatedatetime=date('Y-m-d H:i:s');

        foreach($tableData as $rowtabledata){
            $data = array( 
                'tbl_machine_idtbl_machine'=> $rowtabledata['col_2'],
                'allocatedate'=> $allocatedatetime,
                'startdatetime'=> $rowtabledata['col_3'], 
                'enddatetime'=> $rowtabledata['col_4'], 
                'status'=> '1', 
                'insertdatetime'=> $insertdatetime, 
                'tbl_user_idtbl_user'=> $userID,
                'tbl_customerinquiry_detail_idtbl_customerinquiry_detail'=> $jobid, 
                'tbl_cost_items_idtbl_cost_items'=> $costitemid,
                'tbl_delivery_plan_details_idtbl_delivery_plan_details'=> $deliveryplan,
                'tbl_employee_idtbl_employee'=> $employee
            );

            $this->db->insert('tbl_machine_allocation', $data);

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
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Productionorderview');                
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
                redirect('Productionorderview');
            }        

    }

    public function Checkmachineavailability(){
        $machineid = $_POST['machineid'];
        $startdate = $_POST['startdate'];
        $enddate = $_POST['enddate'];

        $sql="SELECT `tbl_machine_idtbl_machine`, `startdatetime`, `enddatetime` FROM `tbl_machine_allocation`
        WHERE ('$startdate' BETWEEN `startdatetime` AND `enddatetime`) OR ('$enddate' BETWEEN `startdatetime` AND `enddatetime`) AND `tbl_machine_idtbl_machine`= '$machineid'  AND `status`= 1";
        $respond=$this->db->query($sql, array($machineid));
        //echo $sql;die;//var_dump($respond);
            //     WHERE new_start < existing_end
            //   AND new_end   > existing_start;

        $obj=new stdClass();
        if($respond->num_rows() > 0){    
            $obj->actiontype = 1; 
        }
        else{
            $obj->actiontype = 2;
        }
        echo json_encode($obj);

    }

    public function Checkissueqty(){
        $recordID=$this->input->post('recordID');
        $productionmaterialinfoID=$this->input->post('productionmaterialinfoID');

        $sql="SELECT SUM(`qty`) AS `issueqty` FROM `tbl_production_material` WHERE `tbl_production_orderdetail_idtbl_production_orderdetail`=? AND `tbl_material_info_idtbl_material_info`=?";
        $respond=$this->db->query($sql, array($productionmaterialinfoID, $recordID));

        echo $respond->row(0)->issueqty;
    }

    public function FetchAllocationData(){
        $recordID=$this->input->post('recordID');

        $html='';

		$sql="SELECT `a`.`startdatetime`, `a`.`enddatetime`, `c`.`costitemname`, `c`.`qty` FROM `tbl_machine_allocation` AS `a`
		LEFT JOIN `tbl_cost_items` AS `c` ON `a`.`tbl_cost_items_idtbl_cost_items`=`c`.`idtbl_cost_items`
		WHERE `a`.`tbl_machine_idtbl_machine`= '$recordID'";

        $respond=$this->db->query($sql, array(1, $recordID));

              
        foreach($respond->result() as $rowlist){
            $html.='
            <tr id ="'.$rowlist->costitemname.'">
                <td>'.$rowlist->startdatetime.'</td>
                <td>'.$rowlist->enddatetime.'</td>
                <td>'.$rowlist->costitemname.'</td>
                <td>'.$rowlist->qty.'</td>
             </tr>
            
            ';
        }

        echo ($html);
    }

    public function GetInquieryDetails(){
        $recordID=$this->input->post('recordId');

        $sql="SELECT * FROM `tbl_customerinquiry_detail` WHERE `tbl_customerinquiry_idtbl_customerinquiry` = '$recordID'";
        $respond=$this->db->query($sql);
        return $respond->result_array();
    }

    public function GetCostItemData(){
        $recordID=$this->input->post('recordId');

        $sql="SELECT * FROM `tbl_cost_items` WHERE `tbl_customerinquiry_detail_idtbl_customerinquiry_detail` = '$recordID' AND `status` = '1'";
        $respond=$this->db->query($sql);
        return $respond->result_array();

    }

    public function FetchItemDataForAllocation(){
        $recordID=$this->input->post('recordId');

        $html='';

		$sql="SELECT * FROM `tbl_customerinquiry` AS `u`
        JOIN `tbl_customerinquiry_detail` AS `ub` ON `u`.`idtbl_customerinquiry` = `ub`.`tbl_customerinquiry_idtbl_customerinquiry`
        JOIN `tbl_cost_items` AS `uc` ON `ub`.`idtbl_customerinquiry_detail` = `uc`.`tbl_customerinquiry_detail_idtbl_customerinquiry_detail`  JOIN `tbl_customer` AS `ud` ON (`ud`.`idtbl_customer` = `u`.`tbl_customer_idtbl_customer`) WHERE `u`.`status` IN (1) AND `ub`.`status` IN (1) AND `uc`.`status` IN (1) AND `uc`.`tbl_customerinquiry_detail_idtbl_customerinquiry_detail` = '$recordID'";

        $respond=$this->db->query($sql, array(1, $recordID));

              
        foreach($respond->result() as $rowlist){
            $html.='
            <tr id ="'.$rowlist->idtbl_customerinquiry.'">
                <td>'.$rowlist->idtbl_customerinquiry.'</td>
                <td>'.$rowlist->name.'</td>
                <td>'.$rowlist->po_number.'</td>
                <td>'.$rowlist->job.'</td>
                <td>'.$rowlist->qty.'</td>
                <td>'.$rowlist->costitemname.'</td>
                <td class = "text-center"><button type="button" id="'.$rowlist->idtbl_cost_items.'" class="btn btn-dark btn-sm btnAdd mr-1">
                <i class="fas fa-tools"></i>
                </button></td>
             </tr>
            
            ';
        }

        echo $html;
    }

    public function GetDeliveryPlanDetails(){
        $recordID=$this->input->post('recordId');

        $this->db->select('*');
        $this->db->from('tbl_delivery_plan');
        $this->db->join('tbl_delivery_plan_details', 'tbl_delivery_plan_details.tbl_delivery_plan_idtbl_delivery_plan = tbl_delivery_plan.idtbl_delivery_plan');
        $this->db->where('tbl_delivery_plan_details.tbl_customerinquiry_detail_idtbl_customerinquiry_detail', $recordID);
        $respond=$this->db->get();
        return $respond->result_array();
    }

}