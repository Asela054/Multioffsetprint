<?php class Newpurchaserequestinfo extends CI_Model {
	public function Getcompany() {
		$this->db->select('`idtbl_company`, `company`');
		$this->db->from('tbl_company');
		$this->db->where('status', 1);

		return $respond=$this->db->get();
	}

	public function Getsupplier() {

		$comapnyID=$_SESSION['company_id'];

		$this->db->select('`idtbl_supplier`, `name`');
		$this->db->from('tbl_supplier');
		$this->db->where('status', 1);
		$this->db->where('tbl_supplier.company_id', $comapnyID);

		return $respond=$this->db->get();
	}

	public function Getordertype() {
		$this->db->select('`idtbl_order_type`, `type`');
		$this->db->from('tbl_order_type');
		$this->db->where('status', 1);

		return $respond=$this->db->get();
	}

	public function Getmeasuretype() {
		$this->db->select('`idtbl_mesurements`, `measure_type`');
		$this->db->from('tbl_measurements');
		$this->db->where('status', 1);

		return $respond=$this->db->get();
	}

	public function Getproductlisttoselectpicker(){
        $searchTerm=$this->input->post('searchTerm');

        if(!isset($searchTerm)){
            $sql="SELECT `idtbl_print_material_info`, `materialinfocode`, `materialname` FROM `tbl_print_material_info` WHERE `status`=? LIMIT 5";
            $respond=$this->db->query($sql, array(1));                       
        }
        else{            
            if(!empty($searchTerm)){
                $sql="SELECT `idtbl_print_material_info`, `materialinfocode`, `materialname` FROM `tbl_print_material_info` WHERE `status`=? AND `materialname` LIKE '$searchTerm%'";
                $respond=$this->db->query($sql, array(1));    
            }
            else{
				$sql="SELECT `idtbl_print_material_info`, `materialinfocode`, `materialname` FROM `tbl_print_material_info` WHERE `status`=? LIMIT 5";
                $respond=$this->db->query($sql, array(1));                
            }
        }
        
        $data=array();
        
        foreach ($respond->result() as $row) {
            $data[]=array("id"=>$row->idtbl_print_material_info, "text"=>$row->materialname);
        }
        
        echo json_encode($data);
    }

	public function Getstockqty() {
		$recordID=$this->input->post('recordID');
		$companyID=$this->input->post('companyID');
		$branchID=$this->input->post('branchID');
		$sql = "SELECT SUM(`qty`) AS qty FROM `tbl_print_stock` LEFT JOIN `tbl_print_material_info` ON `tbl_print_material_info`.`idtbl_print_material_info`=`tbl_print_stock`.`tbl_print_material_info_idtbl_print_material_info` WHERE `tbl_print_stock`.`status`=1 AND `materialname`=? AND `tbl_print_stock`.`company_id`=? AND `tbl_print_stock`.`company_branch_id`=?";
		$respond=$this->db->query($sql, array($recordID, $companyID, $branchID));
		
		if ($respond->num_rows() > 0) {
			$result = $respond->row(); 
			echo json_encode(array('qty' => $result->qty));
		} else {
			echo json_encode(array('qty' => 0));
		}
	}

	public function Getproductaccosupplier() {
		$sql = "SELECT `idtbl_print_material_info`, `materialinfocode`, `materialname` , `name` FROM `tbl_print_material_info` LEFT JOIN `tbl_supplier` ON `tbl_supplier`.`idtbl_supplier`=`tbl_print_material_info`.`tbl_supplier_idtbl_supplier` WHERE `tbl_print_material_info`.`status`=1";
		$respond = $this->db->query($sql);
		
		echo json_encode($respond->result());
	}
	
	public function Getsparepartaccosupplier() {
		$sql = "SELECT `idtbl_spareparts`, `spare_part_name` FROM `tbl_spareparts` WHERE `status`=1";
		$respond = $this->db->query($sql);
		
		echo json_encode($respond->result());
	}

	public function Getproductforvehicle() {
		$recordID=$this->input->post('recordID');
		$sql="SELECT `idtbl_service_item_list`, `service_type` FROM `tbl_service_item_list` WHERE `status`=1";
		$respond=$this->db->query($sql, array($recordID));

		echo json_encode($respond->result());
	}

	public function Getproductformachine() {
		$recordID=$this->input->post('recordID');
		$sql="SELECT `idtbl_machine`, `machine` FROM `tbl_machine` WHERE `status`=1";
		$respond=$this->db->query($sql, array($recordID));

		echo json_encode($respond->result());
	}

	public function Getproductforsparepart() {
		$recordID=$this->input->post('recordID');
		$sql="SELECT `idtbl_spareparts`, `name` FROM `tbl_spareparts` WHERE `status`=1";
		$respond=$this->db->query($sql, array($recordID));

		echo json_encode($respond->result());
	}	

	public function fetchMaterials($query) {
		$companyID=$_SESSION['company_id'];
		$branchID=$_SESSION['branch_id'];

		$this->db->select('materialname');
		$this->db->from('tbl_print_material_info');
		$this->db->like('materialname', $query);
		$this->db->where('status', 1);
		$this->db->where('company_id', $companyID);
		$this->db->where('company_branch_id', $branchID);
		
		$printMaterialsQuery = $this->db->get();
		$printMaterials = $printMaterialsQuery->result_array();
	
		$this->db->select('spare_part_name as materialname');
		$this->db->from('tbl_spareparts');
		$this->db->like('spare_part_name', $query);
		$this->db->where('status', 1);
		$sparePartsQuery = $this->db->get();
		$spareParts = $sparePartsQuery->result_array();

		$this->db->select('machine as materialname');
		$this->db->from('tbl_machine');
		$this->db->like('machine', $query);
		$this->db->where('status', 1);
		$machineQuery = $this->db->get();
		$machineParts = $machineQuery->result_array();

		$this->db->select('service_name as materialname');
		$this->db->from('tbl_service_type');
		$this->db->like('service_name', $query);
		$this->db->where('status', 1);
		$serviceQuery = $this->db->get();
		$serviceParts = $serviceQuery->result_array();
	
		$materials = array_merge($printMaterials, $spareParts, $machineParts, $serviceParts);
	
		return $materials;
	}
	
			


	public function Getproductprice(){
        $recordID=$this->input->post('recordID');

		$this->db->select('*'); 
        $this->db->from('tbl_print_material_info');
        $this->db->where('status', 1);
        $this->db->where('idtbl_print_material_info', $recordID);

        $respond=$this->db->get();

        if($respond->num_rows()>0){
            $obj=new stdClass();
            $obj->unitprice=$respond->row(0)->unitprice;
        }

        else{
            $obj=new stdClass(); 
            $obj->unitprice=0;
          
        }
        echo json_encode($obj);
    }

	public function Getproductpricespare(){
        $recordID=$this->input->post('recordID');

		$this->db->select('*'); 
        $this->db->from('tbl_spareparts');
        $this->db->where('status', 1);
        $this->db->where('idtbl_spareparts', $recordID);

        $respond=$this->db->get();

        if($respond->num_rows()>0){
            $obj=new stdClass();
            $obj->unitprice=$respond->row(0)->unit_price;
        }

        else{
            $obj=new stdClass(); 
            $obj->unitprice=0;
          
        }
        echo json_encode($obj);
    }

	public function Newpurchaserequestinsertupdate() {
		$this->db->trans_begin();

		$userID=$_SESSION['userid'];

		$comapnyID=$_SESSION['company_id'];

		$date1 = $this->input->post('insertdatetime');
            $current = new DateTime($date1);
            
            $currentYear = $current->format('Y'); 
            $currentMonth = $current->format('m'); 
            
            if ($currentMonth < 4) { //03
                $startDate = new DateTime(($currentYear-1)."-04-01");
                $endDate = new DateTime($currentYear . "-03-31");
            } else {
                $startDate = new DateTime("$currentYear-04-01");
                $endDate = new DateTime(($currentYear + 1) . "-03-31");
            }
            
            $fromyear = $startDate->format('Y-m-d');
            $toyear = $endDate->format('Y-m-d');
            
            $query = $this->db->query("SELECT porder_req_no FROM tbl_print_porder_req WHERE company_id = $comapnyID AND `insertdatetime` BETWEEN '$fromyear' AND '$toyear' ORDER BY porder_req_no DESC LIMIT 1");
            
            if ($query->num_rows() > 0) {
                $last_req_no = $query->row()->porder_req_no;
                $req_number = intval(substr($last_req_no, -4));
                $count = $req_number;
            } else {
                $count = 0;
            }



		$tableData=$this->input->post('tableData');
		$company_id=$this->input->post('company_id');
		$branch_id=$this->input->post('branch_id');
		$ordertype=$this->input->post('ordertype');
		$servicetype=$this->input->post('servicetype');

        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

		$updatedatetime=date('Y-m-d H:i:s');
		$reqdate=date('Y-m-d');
		

		if($recordOption==1) {

			$data=array(
				'date'=> $reqdate,
				'confirmstatus'=> '0',
				'status'=> '1',
				'porderconfirm'=> '0',
				'insertdatetime'=> $updatedatetime,
				'tbl_user_idtbl_user'=> $userID,
				'tbl_order_type_idtbl_order_type'=> $ordertype,
				'company_id'=> $company_id, 
				'company_branch_id'=> $branch_id
			);

			$this->db->insert('tbl_print_porder_req', $data);

			$porderID=$this->db->insert_id();


			$result_array = array();
            $querydetails = $this->db->query("SELECT idtbl_print_porder_req FROM tbl_print_porder_req WHERE idtbl_print_porder_req = $porderID");
            if ($querydetails) {
                $result_array = $querydetails->result_array();
            }
    
            foreach ($result_array as $row) {
                $id = $row['idtbl_print_porder_req'];
    
                $count++; 
                $countPrefix = sprintf('%04d', $count);

                $invoiceDate = new DateTime($updatedatetime);
                $year = (int) $invoiceDate->format('Y');
                $month = (int) $invoiceDate->format('m');

                if ($month < 4) {
                    $year -= 1;
                }

                $yearDigit = substr($year, -2);

                $req_no = 'POR' . $yearDigit . $countPrefix;

                $invodetail = array(
                    'porder_req_no'=> $req_no, 
                    'updatedatetime'=> $updatedatetime
                );
        
                $this->db->where('idtbl_print_porder_req', $id);
                $this->db->update('tbl_print_porder_req', $invodetail);
            }

				foreach ($tableData as $rowtabledata) {
					$materialname=$rowtabledata['col_1'];
					$qty=$rowtabledata['col_2'];
					$uom=$rowtabledata['col_4'];

					$dataone=array(
						'qty'=> $qty,
						'measure_type_id'=> $uom,
						'status'=> '1',
						'insertdatetime'=> $updatedatetime,
						'tbl_print_porder_idtbl_print_porder'=> $porderID,
						'requestname'=> $materialname,
					);

					$this->db->insert('tbl_print_porder_req_detail', $dataone);
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
	}

	public function Purchaseorderview() {
		$recordID=$this->input->post('recordID');

		$this->db->select('tbl_print_porder_req_detail.*,tbl_print_porder_req.tbl_order_type_idtbl_order_type,tbl_measurements.measure_type ');
		$this->db->from('tbl_print_porder_req_detail');
		$this->db->join('tbl_measurements', 'tbl_measurements.idtbl_mesurements = tbl_print_porder_req_detail.measure_type_id', 'left');
		$this->db->join('tbl_print_porder_req', 'tbl_print_porder_req.idtbl_print_porder_req = tbl_print_porder_req_detail.tbl_print_porder_idtbl_print_porder', 'left');
		$this->db->where('tbl_print_porder_req_detail.tbl_print_porder_idtbl_print_porder', $recordID);
		$this->db->where('tbl_print_porder_req_detail.status', 1);

		$responddetail=$this->db->get();

		$html='';

		$html.='
        <div class="row">
        </div>
		<div class="row">
		<div class="col-12">
		<hr>
		<table class="table table-striped table-bordered table-sm">
		<thead>
		<th style="background-color: #c3faf6">Product Info</th>
		<th style="background-color: #c3faf6">Qty</th>
		<th style="background-color: #c3faf6">Uom</th>
		</thead>
		<tbody>';
        foreach($responddetail->result() as $roworderinfo) {
			if($roworderinfo->tbl_order_type_idtbl_order_type==3) {
				$html.='<tr>
        <td>'.$roworderinfo->requestname.'</td><td>'.$roworderinfo->qty.'</td><td>'.$roworderinfo->measure_type.'</td></tr>';

			}

			else if($roworderinfo->tbl_order_type_idtbl_order_type==4) {
				$html.='<tr>
        <td>'.$roworderinfo->requestname.'</td><td>'.$roworderinfo->qty.'</td><td>'.$roworderinfo->measure_type.'</td></tr>';

			}

			else if($roworderinfo->tbl_order_type_idtbl_order_type==1) {
				$html.='<tr>
        <td>'.$roworderinfo->requestname.'</td><td>'.$roworderinfo->qty.'</td><td>'.$roworderinfo->measure_type.'</td></tr>';

			}

			else {
				$html.='<tr>
        <td>'.$roworderinfo->requestname.'</td><td>'.$roworderinfo->qty.'</td><td>'.$roworderinfo->measure_type.'</td></tr>';

			}
		}

		$html.='</tbody>
        </table></div></div>';

		echo $html;
	}

	public function porderviewheader() {
		$recordID=$this->input->post('recordID');

		$this->db->select('tbl_print_porder_req.*,
								tbl_company.company AS companyname,tbl_company.address1 As companyaddress,tbl_company.mobile AS companymobile,
                                tbl_company.phone companyphone,tbl_company.email AS companyemail,
                                tbl_company_branch.branch AS branchname');
		$this->db->from('tbl_print_porder_req');
		$this->db->join('tbl_company', 'tbl_company.idtbl_company = tbl_print_porder_req.company_id', 'left');
		$this->db->join('tbl_company_branch', 'tbl_company_branch.idtbl_company_branch = tbl_print_porder_req.company_branch_id', 'left');
		$this->db->where('idtbl_print_porder_req', $recordID);
		$this->db->where('tbl_print_porder_req.status', 1);

		$respond=$this->db->get();

		$obj=new stdClass();
		$obj->porder_no=$respond->row(0)->porder_req_no;
		$obj->companyname=$respond->row(0)->companyname;
		$obj->companyaddress=$respond->row(0)->companyaddress;
		$obj->companymobile=$respond->row(0)->companymobile;
		$obj->companyphone=$respond->row(0)->companyphone;
		$obj->companyemail=$respond->row(0)->companyemail;
		$obj->branchname=$respond->row(0)->branchname;

		echo json_encode($obj);
	}

	public function Newpurchaserequeststatus() {
		$this->db->trans_begin();

        $recordID=$this->input->post('approvebtn');
		$userID=$_SESSION['userid'];
		$updatedatetime=date('Y-m-d H:i:s');

			$data=array('confirmstatus'=> '1',
				'updateuser'=> $userID,
				'updatedatetime'=> $updatedatetime);

			$this->db->where('idtbl_print_porder_req', $recordID);
			$this->db->update('tbl_print_porder_req', $data);


			$this->db->trans_complete();

			if ($this->db->trans_status()===TRUE) {
				$this->db->trans_commit();

				$actionObj=new stdClass();
				$actionObj->icon='fas fa-check';
				$actionObj->title='';
				$actionObj->message='Order Request Confirm Successfully';
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
				$actionObj->icon='fas fa-warning';
				$actionObj->title='';
				$actionObj->message='Record Error';
				$actionObj->url='';
				$actionObj->target='_blank';
				$actionObj->type='danger';

				$actionJSON=json_encode($actionObj);

				$obj=new stdClass();
				$obj->status=2;
				$obj->action=$actionJSON;

				echo json_encode($obj);
			}
	}
	public function Newpurchaserequestreject() {
		$this->db->trans_begin();

        $recordID=$this->input->post('rejectbtn');
		$userID=$_SESSION['userid'];
		$updatedatetime=date('Y-m-d H:i:s');

			$data=array('confirmstatus'=> '2',
				'updateuser'=> $userID,
				'updatedatetime'=> $updatedatetime);

			$this->db->where('idtbl_print_porder_req', $recordID);
			$this->db->update('tbl_print_porder_req', $data);


			$this->db->trans_complete();

			if ($this->db->trans_status()===TRUE) {
				$this->db->trans_commit();

				$actionObj=new stdClass();
				$actionObj->icon='fas fa-check';
				$actionObj->title='';
				$actionObj->message='Order Request Confirm Successfully';
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
				$actionObj->icon='fas fa-warning';
				$actionObj->title='';
				$actionObj->message='Record Error';
				$actionObj->url='';
				$actionObj->target='_blank';
				$actionObj->type='danger';

				$actionJSON=json_encode($actionObj);

				$obj=new stdClass();
				$obj->status=2;
				$obj->action=$actionJSON;

				echo json_encode($obj);
			}
	}
}