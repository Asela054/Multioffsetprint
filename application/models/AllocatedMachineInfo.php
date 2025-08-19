<?php
class AllocatedMachineInfo extends CI_Model{
    public function Getmachinelist(){
        $this->db->select('`idtbl_machine`, `machine`, `machinecode`');
        $this->db->from('tbl_machine');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
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
                <td>'.$rowlist->costitemname.'</td>
                <td>'.$rowlist->qty.'</td>
                <td>'.$rowlist->startdatetime.'</td>
                <td>'.$rowlist->enddatetime.'</td>
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

    public function GetAllocationData(){
        $recordID=$this->input->post('recordId');

        $html='';

        $sql = "SELECT * FROM `tbl_machine_allocation` AS `ma` LEFT JOIN `tbl_machine` AS `m` ON (`m`.`idtbl_machine` = `ma`.`tbl_machine_idtbl_machine`) LEFT JOIN `tbl_cost_items` AS `ci` ON (`ci`.`idtbl_cost_items` = `ma`.`tbl_cost_items_idtbl_cost_items`) LEFT JOIN `tbl_employee` AS `e` ON (`e`.`idtbl_employee` = `ma`.`tbl_employee_idtbl_employee`) LEFT JOIN `tbl_customerinquiry_detail` AS `d` ON (`d`.`idtbl_customerinquiry_detail` = `ci`.`tbl_customerinquiry_detail_idtbl_customerinquiry_detail`) LEFT JOIN `tbl_customerinquiry` AS `i` ON (`i`.`idtbl_customerinquiry` = `d`.`tbl_customerinquiry_idtbl_customerinquiry`) LEFT JOIN `tbl_customer` AS `c` ON (`c`.`idtbl_customer` = `i`.`tbl_customer_idtbl_customer`) WHERE `ma`.`tbl_machine_idtbl_machine` = '$recordID' ORDER BY `ma`.`startdatetime` ASC";

        $respond=$this->db->query($sql, array(1, $recordID));

              
        foreach($respond->result() as $rowlist){
            $html .= '<tr id ="'.$rowlist->idtbl_customerinquiry.'">
                <td>'.$rowlist->idtbl_customerinquiry.'</td>
                <td>'.$rowlist->customer.'</td>
                <td>'.$rowlist->fullname.'</td>
                <td>'.$rowlist->po_number.'</td>
                <td>'.$rowlist->job.'</td>
                <td>'.$rowlist->costitemname.'</td>
                <td>'.$rowlist->startdatetime.'</td>
                <td>'.$rowlist->enddatetime.'</td>
                <td>'.round((strtotime($rowlist->enddatetime) - strtotime($rowlist->startdatetime))/3600, 1).'</td>
                <td class = "text-right">
                ';
                if($rowlist->allocationstart == 0){ 
                    $html .='<button type="button" id="'.$rowlist->idtbl_machine_allocation.'" class="btn btn-outline-warning btn-sm btnStartAllocation mr-1"><i class="fa fa-check"></i></button>'; 
                }else{
                    $html .= '<button type="button" id="'.$rowlist->idtbl_machine_allocation.'" class="btn btn-outline-success btn-sm mr-1"><i class="fa fa-check"></i></button>';
                } 
                if($rowlist->breakdown_status == 0 && $rowlist->allocationstart == 1){ 
                    $html .='<button type="button" id="'.$rowlist->idtbl_machine_allocation.'" class="btn btn-outline-primary btn-sm btnBreakDown mr-1"><i class="fas fa-tools"></i></button>'; 
                }else if ($rowlist->breakdown_status == 1 && $rowlist->allocationstart == 1){
                    $html .= '<button type="button" id="'.$rowlist->idtbl_machine_allocation.'" class="btn btn-outline-danger btn-sm mr-1"><i class="fas fa-tools"></i></button>';
                } 
                if($rowlist->breakdown_status == 1 && $rowlist->breakdown_fixed_status == 1){ 
                    $html .='<button type="button" id="'.$rowlist->idtbl_machine_allocation.'" class="btn btn-outline-warning btn-sm btnFixBreakDown mr-1"><i class="fa fa-wrench"></i></button>'; 
                }
                $html .= '
                <button type="button" id="'.$rowlist->idtbl_machine_allocation.'" class="btn btn-outline-danger btn-sm btnQaIssues mr-1"><i class="fas fa-exclamation-circle"></i>
                </button>';
                if($rowlist->completed_status == 0 && $rowlist->allocationstart == 1 && $rowlist->breakdown_status == 0){ 
                    $html .='<button type="button" id="'.$rowlist->idtbl_machine_allocation.'" class="btn btn-outline-warning btn-sm btnComplete mr-1"><i class="fa fa-times"></i></button>'; 
                }else if ($rowlist->completed_status == 1 && $rowlist->allocationstart == 1 && $rowlist->breakdown_status == 0){
                    $html .= '<button type="button" id="'.$rowlist->idtbl_machine_allocation.'" class="btn btn-outline-success btn-sm mr-1"><i class="fa fa-check"></i></button>';
                } 
                if($rowlist->allocationstart == 1 && $rowlist->breakdown_status == 0){ 
                    $html .='<button type="button" id="'.$rowlist->idtbl_machine_allocation.'" class="btn btn-outline-info btn-sm btnDetails mr-1"><i class="fa fa-eye"></i>
                </button></td>';
                }
                $html .= '</tr>';
        }

        echo $html;
    }
    public function StartAllocation(){
        $currentdatetime=date('Y-m-d h:i:s');
        $recordID=$this->input->post('recordID');
        $userID=$_SESSION['userid'];

        $data = [
            'allocationstart' => 1,
            'allocationstarttime' => $currentdatetime,
            'allocatedstarteduser' => $userID
        ];
        $this->db->where('idtbl_machine_allocation', $recordID);
        $this->db->update('tbl_machine_allocation', $data);

        echo true;

    }

    public function AllocationComplete(){
        $currentdatetime=date('Y-m-d h:i:s');
        $recordID=$this->input->post('recordID');

        $data = [
            'completed_status' => 1,
            'completeddatetime' => $currentdatetime
        ];
        $this->db->where('idtbl_machine_allocation', $recordID);
        $this->db->update('tbl_machine_allocation', $data);

        echo true;

    }

    public function MachineBreakDown(){
        $machineId=$this->input->post('machineId');
        $allocationId=$this->input->post('recordID');
        $insertdatetime=date('Y-m-d H:i:s');
        $userID=$_SESSION['userid'];

        $insertdata = array( 
            'tbl_machine_idtbl_machine'=> $machineId,
            'tbl_user_idtbl_user'=> $userID,
            'insertdatetime'=> $insertdatetime, 
            'acceptstatus'=> '0', 
            'status'=> '0', 
            'tbl_machine_allocation_idtbl_machine_allocation'=> $allocationId, 
        );

        $this->db->insert('tbl_machine_breakdown', $insertdata);

        $data = [
            'breakdown_status' => 1,
        ];
        $this->db->where('idtbl_machine_allocation', $allocationId);
        $this->db->update('tbl_machine_allocation', $data);

        echo true;

    }
    public function EnterQaIssues(){
        $qaissue=$this->input->post('qaissue');
        $allocationval=$this->input->post('allocationval');
        $qaissuecategory=$this->input->post('qaissuecategory');
        $insertdatetime=date('Y-m-d H:i:s');
        $userID=$_SESSION['userid'];

        $data = [
            'description' => $qaissue,
            'tbl_machine_issue_category_idtbl_machine_issue_category' => $qaissuecategory,
            'tbl_machine_allocation_idtbl_machine_allocation' => $allocationval,
            'insertdatetime' => $insertdatetime,
            'insertuser' => $userID,
            'status' => '1',
        ];
        $this->db->insert('tbl_allocation_qa_issues', $data);

        echo true;

    }

    public function GetAllocationHours(){
        $recordID=$this->input->post('recordId');
        $count = 0;
        $start = null;
        $end  = null;
        $hours = array();
        $html='';

		$sql="SELECT `startdatetime`, `enddatetime` FROM `tbl_machine_allocation`
		WHERE `idtbl_machine_allocation`= '$recordID'";

        $respond=$this->db->query($sql, array(1, $recordID));
        $results = $respond->result();

              
        foreach($respond->result() as $rowlist){
            $start = $rowlist->startdatetime;
            $end = $rowlist->enddatetime;

        }

        while($start <= $end){
            $count++;
            $starthour = new DateTime($start);
            $hour = $starthour->format('m-d H.i');
            array_push($hours, $hour);
            $start = date('Y-m-d H:i:s', strtotime($start. ' + 1 hours'));
        }

        echo json_encode($hours);

    }

    public function EnterHourlyDetails(){

        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $tableData = $this->input->post('tableData');
        $allocationval=$this->input->post('allocationval');

        $insertdatetime=date('Y-m-d H:i:s');
        $allocatedatetime=date('Y-m-d H:i:s');

        $this->db->where('tbl_machine_allocation_idtbl_machine_allocation', $allocationval);
        $this->db->delete('tbl_machine_allocation_details');

        foreach($tableData as $rowtabledata){
            $data = array( 
                'hour'=> $rowtabledata['col_2'],
                'completedqty'=> $rowtabledata['col_3'],
                'wastageqty'=> $rowtabledata['col_4'], 
                'insertuser'=> $userID, 
                'status'=> '1', 
                'tbl_machine_allocation_idtbl_machine_allocation'=> $allocationval, 
            );

            $this->db->insert('tbl_machine_allocation_details', $data);

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
            }        

    }

    public function GetHourlyListData(){
        $recordID=$this->input->post('recordId');
        $html='';

        $sql = "SELECT * FROM `tbl_machine_allocation_details` WHERE `tbl_machine_allocation_idtbl_machine_allocation` = '$recordID'";
        $respond=$this->db->query($sql, array(1, $recordID));
    
        foreach($respond->result() as $rowlist){
            $html .= '<tr id ="'.$rowlist->idtbl_machine_allocation_details.'">
                <td>'.$rowlist->hour.'</td>
                <td>'.$rowlist->completedqty.'</td>
                <td>'.$rowlist->wastageqty.'</td>
                <td><button type="button" onclick= "productDelete(this);" id="btnDeleterow" class=" btn btn-danger btn-sm float-right"><i class="fas fa-trash-alt"></i></button></td>
                </tr>';
        }

        echo $html;
    }

    public function GetQaIssueData(){
        $recordID=$this->input->post('recordId');
        $html='';
        $sql = "SELECT * FROM `tbl_allocation_qa_issues` AS `m` LEFT JOIN `tbl_machine_allocation` AS `ma` ON (`m`.`tbl_machine_allocation_idtbl_machine_allocation` = `ma`.`idtbl_machine_allocation`) LEFT JOIN `tbl_machine_issue_category` AS `ci` ON (`ci`.`idtbl_machine_issue_category` = `m`.`tbl_machine_issue_category_idtbl_machine_issue_category`) WHERE `m`.`tbl_machine_allocation_idtbl_machine_allocation` = '$recordID'";

        $respond=$this->db->query($sql, array(1, $recordID));

              
        foreach($respond->result() as $rowlist){
            $html .= '<tr id ="'.$rowlist->idtbl_allocation_qa_issues.'">
                <td>'.$rowlist->type.'</td>
                <td>'.$rowlist->description.'</td>
                <td class = "text-center">
                <button type="button" id="'.$rowlist->idtbl_allocation_qa_issues.'" class="btn btn-outline-danger btn-sm btnAllocatedIssue mr-1"><i class="fas fa-trash"></i>
                </button>
                </td>
                </tr>';
        }

        echo $html;
    }

    public function RemoveQaAllocatedIssue(){
        $recordId=$this->input->post('recordId');

        $this->db->where('idtbl_allocation_qa_issues', $recordId);
        $this->db->delete('tbl_allocation_qa_issues');

        echo true;

    }

    public function StartBrokeDownMachine(){
        $currentdatetime=date('Y-m-d h:i:s');
        $recordID=$this->input->post('recordID');

        $data = [
            'breakdown_status' => 0,
            'breakdown_fixed_status' => 0,
            'fixed_started_time' => $currentdatetime
        ];
        $this->db->where('idtbl_machine_allocation', $recordID);
        $this->db->update('tbl_machine_allocation', $data);

        echo true;

    }

}