<?php

class Machineserviceinfo extends CI_Model {

	public function Getmachinetype(){
		$this->db->select('idtbl_machine_type AS id, type AS name');
        $this->db->from('tbl_machine_type');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
	}

	public function Getmachinename(){
		$recordID = $this->input->post('recordID');

		$this->db->select('idtbl_machine, machine');
		$this->db->from('tbl_machine');
		$this->db->where('tbl_machine_type_idtbl_machine_type', $recordID);
		$this->db->where('status', 1);

		$respond = $this->db->get()->result();
		echo json_encode($respond);
	}

	public function Getsparepartname(){
		$recordID = $this->input->post('recordID');

		$this->db->select('idtbl_spareparts, spare_part_name');
		$this->db->from('tbl_spareparts');
		$this->db->where('machine_type_id', $recordID);
		$this->db->where('status', 1);

		$respond = $this->db->get()->result();
		echo json_encode($respond);
	}

	public function Getfactorycode(){
		$recordID = $this->input->post('recordID');

		$this->db->select('ua.factorycode');
		$this->db->from('tbl_machine AS u');
		$this->db->join('tbl_factory AS ua', 'ua.idtbl_factory = u.tbl_factory_idtbl_factory1', 'left');
		$this->db->where('u.idtbl_machine', $recordID);
		$this->db->where('u.status', 1);

		$respond = $this->db->get();

		$obj=new stdClass();
		$obj->factorycode = $respond->row(0)->factorycode;

		echo json_encode($obj);
	}

    public function Machineserviceinsertupdate() {
        
		$this->db->trans_begin();

		$userID=$_SESSION['userid'];
		$datetime=date('Y-m-d H:i:s');

        $tableData = $this->input->post('tableData');

        $idtbl_machine_service = $this->input->post('idtbl_machine_service');
        $job_type = $this->input->post('job_type');
        $sevice_date_to = $this->input->post('sevice_date_to');
        $service_date_from = $this->input->post('service_date_from');
        $machine_type = $this->input->post('machine_type');
        $machine_name = $this->input->post('machine_name');
        $factory_code = $this->input->post('factory_code');
        $estimated_sevice_hours = $this->input->post('estimated_sevice_hours');

		$recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){
            $recordID=$this->input->post('recordID');
        }

		if($recordOption==1) {

			$data = array(
                'job_type'=> $job_type,
				'sevice_date_to' => $sevice_date_to,
				'service_date_from' => $service_date_from,
                'factory_code'=> $factory_code,
				'estimated_sevice_hours' => $estimated_sevice_hours,
                'status'=> '1', 
                'insertdatetime'=> $datetime,
				'tbl_machine_idtbl_machine' => $machine_name,
				'tbl_machine_type_idtbl_machine_type' => $machine_type,
                'tbl_user_idtbl_user'=> $userID
            );
			$this->db->insert('tbl_machine_service', $data);

            $insertID = $this->db->insert_id();

            foreach($tableData as $row){
                $serviceID = $row['col_1'];
                $qty = $row['col_3'];

                $datadetails = array(
                    'qty'=> $qty,
                    'status'=> '1',
					'insertdatetime' => $datetime,
					'tbl_spareparts_idtbl_spareparts' => $serviceID,
					'tbl_machine_service_idtbl_machine_service' => $insertID,
					'tbl_user_idtbl_user' => $userID
                );
            
                $this->db->insert('tbl_machine_service_details', $datadetails);
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

				$actionJSON = json_encode($actionObj);

                $obj = new stdClass();
                $obj->status = 1;
                $obj->action = $actionJSON;
			} else {
                $this->db->trans_rollback();

                $actionObj=new stdClass();
                $actionObj->icon='fas fa-warning';
                $actionObj->title='';
                $actionObj->message='Record Error';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='danger';

				$actionJSON = json_encode($actionObj);

                $obj = new stdClass();
                $obj->status = 0;
                $obj->action = $actionJSON;
            }
		} 
		else{
            $data = array(
                'job_type'=> $job_type,
				'sevice_date_to' => $sevice_date_to,
				'service_date_from' => $service_date_from,
                'factory_code'=> $factory_code,
				'estimated_sevice_hours' => $estimated_sevice_hours,
                'status'=> '1', 
                'updateuser'=> $userID, 
                'updatedatetime' => $datetime,
				'tbl_machine_idtbl_machine' => $machine_name,
				'tbl_machine_type_idtbl_machine_type' => $machine_type,
            );
			$this->db->where('idtbl_machine_service', $recordID);
			$this->db->update('tbl_machine_service', $data);

			$this->db->where('tbl_machine_service_idtbl_machine_service', $recordID);
			$this->db->delete('tbl_machine_service_details');

			foreach($tableData as $row){
                $serviceID = $row['col_1'];
                $qty = $row['col_3'];

                $datadetails = array(
                    'qty'=> $qty,
                    'status'=> '1',
					'insertdatetime' => $datetime,
					'tbl_spareparts_idtbl_spareparts' => $serviceID,
					'tbl_machine_service_idtbl_machine_service' => $recordID,
					'tbl_user_idtbl_user' => $userID
                );
            
                $this->db->insert('tbl_machine_service_details', $datadetails);
            }

			$this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-save';
                $actionObj->title='';
                $actionObj->message='Record Update Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='primary';

				$actionJSON = json_encode($actionObj);

                $obj = new stdClass();
                $obj->status = 1;
                $obj->action = $actionJSON;
            } else {
                $this->db->trans_rollback();

                $actionObj=new stdClass();
                $actionObj->icon='fas fa-warning';
                $actionObj->title='';
                $actionObj->message='Record Error';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='danger';

				$actionJSON = json_encode($actionObj);

                $obj = new stdClass();
                $obj->status = 0;
                $obj->action = $actionJSON;
            }
		}
	}

    public function Machineserviceedit() {
		$recordID=$this->input->post('recordID');

		$this->db->select('*');
        $this->db->from('tbl_machine_service');
        $this->db->where('idtbl_machine_service', $recordID);
        $this->db->where('status', 1);

		$respond=$this->db->get();

		$this->db->select('u.qty,ua.idtbl_spareparts,ua.spare_part_name');
        $this->db->from('tbl_machine_service_details AS u');
		$this->db->join('tbl_spareparts AS ua', 'ua.idtbl_spareparts = u.tbl_spareparts_idtbl_spareparts', 'left');
        $this->db->where('u.tbl_machine_service_idtbl_machine_service', $recordID);
        $this->db->where('u.status', 1);

		$responddetails=$this->db->get();

		$html='';
		foreach($responddetails->result() as $row){
			$html.='<tr class="pointer">
						<td class="d-none">'.$row->idtbl_spareparts.'</td>
						<td>'.$row->spare_part_name.'</td>
						<td>'.$row->qty.'</td>
						<td class="text-right"><button class="btn btn-danger btn-sm btnRowRemove mr-1"><i class="fas fa-times"></i></button></td>
					</tr>';
		}

        $obj=new stdClass();
		$obj->id=$respond->row(0)->idtbl_machine_service;
        $obj->job_type=$respond->row(0)->job_type;
        $obj->service_date_from=$respond->row(0)->service_date_from;
        $obj->sevice_date_to=$respond->row(0)->sevice_date_to;
        $obj->machineid=$respond->row(0)->tbl_machine_idtbl_machine;
        $obj->machinetypeid=$respond->row(0)->tbl_machine_type_idtbl_machine_type;
        $obj->factory_code=$respond->row(0)->factory_code;
        $obj->estimated_sevice_hours=$respond->row(0)->estimated_sevice_hours;
		$obj->view = $html;

		echo json_encode($obj);
	}

    public function Machineservicestatus($x, $y) {
		$this->db->trans_begin();

		$userID=$_SESSION['userid'];
        $recordID=$x;
        $type=$y;
        $updatedatetime=date('Y-m-d H:i:s');

		if ($type==1) {
            $data = array(
                'status' => '1',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );
			$this->db->where('idtbl_machine_service', $recordID);
            $this->db->update('tbl_machine_service', $data);

			$this->db->trans_complete();

			if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-check';
                $actionObj->title='';
                $actionObj->message='Record Activate Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='success';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Machineservice');

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
                redirect('Machineservice');
            }
		}
		else if ($type==2) {
            $data = array(
                'status' => '2',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_machine_service', $recordID);
            $this->db->update('tbl_machine_service', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-times';
                $actionObj->title='';
                $actionObj->message='Record Deactivate Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='warning';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Machineservice'); 

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
                redirect('Machineservice');
            }
		}
		else if ($type==3) {
            $data = array(
                'status' => '3',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_machine_service', $recordID);
            $this->db->update('tbl_machine_service', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-trash-alt';
                $actionObj->title='';
                $actionObj->message='Record Remove Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='danger';

				$actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Machineservice');      
                       
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
                redirect('Machineservice');
            }
        }
	}

	public function Getmachineservicedetails(){
		$recordID=$this->input->post('recordID');
		
		$this->db->select('u.qty,ua.idtbl_spareparts,ua.spare_part_name');
        $this->db->from('tbl_machine_service_details AS u');
		$this->db->join('tbl_spareparts AS ua', 'ua.idtbl_spareparts = u.tbl_spareparts_idtbl_spareparts', 'left');
        $this->db->where('u.tbl_machine_service_idtbl_machine_service', $recordID);
        $this->db->where('u.status', 1);

		$respond=$this->db->get();
        
        $html='
        	<table class="table table-striped table-bordered table-sm small">
            	<thead>
                	<tr>
						<th>Estimated Service Items</th>
						<th>Quantity</th>
                	</tr>
            	</thead>
            	<tbody>';
        foreach($respond->result() AS $row){
            $html.='
                <tr>
                    <td>'.$row->spare_part_name.'</td>
                    <td>'.$row->qty.'</td>
                </tr>';
        }
        $html.='</tbody>
			</table>';

        echo $html;
	}
}
