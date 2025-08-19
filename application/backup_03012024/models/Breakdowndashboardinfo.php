<?php 
class Breakdowndashboardinfo extends CI_Model{
    public function Getmachinelist(){
        $this->db->select('`idtbl_machine`, `machine`, `machinecode`');
        $this->db->from('tbl_machine');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }


    public function AcceptBreakDown($x){
        $this->db->trans_begin();
        $currentdatetime=date('Y-m-d h:i:s');
        $userID=$_SESSION['userid'];

        $data = [
            'acceptstatus' => 1,
            'tbl_user_idtbl_user' => $userID,
        ];
        $this->db->where('idtbl_machine_breakdown', $x);
        $this->db->update('tbl_machine_breakdown', $data);

        $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-check';
                $actionObj->title='';
                $actionObj->message='Record Updated Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='primary';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('BreakDownDashboard');                
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
                redirect('BreakDownDashboard');
            }

        echo true;

    }
    public function CompleteBreakdown($x, $y){
        $this->db->trans_begin();
        $currentdatetime=date('Y-m-d h:i:s');
        $userID=$_SESSION['userid'];

        $dataNew = [
            'breakdown_fixed_status' => 1,
        ];
        $this->db->where('idtbl_machine_allocation', $y);
        $this->db->update('tbl_machine_allocation', $dataNew);

        $data = [
            'status' => 1,
        ];
        $this->db->where('idtbl_machine_breakdown', $x);
        $this->db->update('tbl_machine_breakdown', $data);

        $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-check';
                $actionObj->title='';
                $actionObj->message='Record Updated Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='primary';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('BreakDownDashboard');                
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
                redirect('BreakDownDashboard');
            }

        echo true;

    }

    public function GetFixedBreakDowms(){
        $this->db->select('idtbl_machine_breakdown');
        $this->db->from('tbl_machine_breakdown');
        $this->db->where('status', 1);
        $respond=$this->db->get();

        return $respond->num_rows();
    }

    public function GetAcceptedBreakDowms(){
        $this->db->select('idtbl_machine_breakdown');
        $this->db->from('tbl_machine_breakdown');
        $this->db->where('status', 0);
        $this->db->where('acceptstatus', 1);
        $respond=$this->db->get();

        return $respond->num_rows();
    }

    public function GetNewBreakDowms(){
        $this->db->select('idtbl_machine_breakdown');
        $this->db->from('tbl_machine_breakdown');
        $this->db->where('status', 0);
        $this->db->where('acceptstatus', 0);
        $respond=$this->db->get();

        return $respond->num_rows();
    }

    public function GetFixedAndNotStartedBreakDowms(){
        $this->db->select('idtbl_machine_allocation');
        $this->db->from('tbl_machine_allocation');
        $this->db->where('breakdown_fixed_status', 1);
        $this->db->where('breakdown_status', 1);
        $respond=$this->db->get();

        return $respond->num_rows();
    }
}