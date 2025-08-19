<?php
class Jobcardallocationinfo extends CI_Model{

	public function GetCustomerjobid($x){
          $customerid = $x;
		return $respond=$customerid;
	}
    public function Getmeasuretype() {
		$this->db->select('`idtbl_mesurements`, `measure_type`');
		$this->db->from('tbl_measurements');
		$this->db->where('status', 1);

		return $respond=$this->db->get();
	}
    public function Getcustomerjobs() {
        $recordID = $this->input->post('recordID');
    
        $this->db->select('`idtbl_customerinquiry_detail`,`job`, `job_no`, `job_id`');
		$this->db->from('tbl_customerinquiry_detail');
		$this->db->join('tbl_customerinquiry', 'tbl_customerinquiry.idtbl_customerinquiry = tbl_customerinquiry_detail.tbl_customerinquiry_idtbl_customerinquiry');
		$this->db->where('tbl_customerinquiry.status', 1);
		$this->db->where('tbl_customerinquiry.approvestatus', 1);
		$this->db->where('tbl_customerinquiry.tbl_customer_idtbl_customer', $recordID);
        $this->db->group_by('job_id');

    
        $respond = $this->db->get();
    
        if ($respond->num_rows() > 0) {
            echo json_encode($respond->result());
        }
    }
    public function Getmateriallist() {
        $this->db->select('`idtbl_print_material_info`, `materialname`');
        $this->db->from('tbl_print_material_info');
        $this->db->where('status', 1);
        return $respond=$this->db->get();
    }

    public function GetmateriallistStock() {
        $this->db->select('`idtbl_print_material_info`, `materialname`, `batchno`, `qty`, `idtbl_print_stock`');
        $this->db->from('tbl_print_material_info');
		$this->db->join('tbl_print_stock', 'tbl_print_stock.tbl_print_material_info_idtbl_print_material_info = tbl_print_material_info.idtbl_print_material_info');
        $this->db->where('tbl_print_material_info.status', 1);
        $this->db->where('tbl_print_stock.qty >', 0); // Add this condition

        return $respond=$this->db->get();
    }
    public function Getbatchnolistaccomaterial() {
        $materialID = $this->input->post('materialID');

        $this->db->select('`batchno`, `qty`, `idtbl_print_stock`');
        $this->db->from('tbl_print_stock');
        $this->db->where('status', 1);
        $this->db->where('qty >', 0); 
        $this->db->where('tbl_print_material_info_idtbl_print_material_info', $materialID); 

        $respond = $this->db->get();
        echo json_encode($respond->result());
    }

    public function Getprintingformatlist() {
        $this->db->select('`idtbl_printing_format`,`format_name`,`printing_width`,`printing_height`');
        $this->db->from('tbl_printing_format');
        $this->db->where('status', 1);
        return $respond=$this->db->get();
    }

    // public function Getcolorlist() {
    //     $this->db->select('`idtbl_print_color`,`color_name`');
    //     $this->db->from('tbl_print_color');
    //     $this->db->where('status', 1);
    //     return $respond=$this->db->get();
    // }
    public function Getcolorlist() {
        $this->db->select('`idtbl_color`,`color`');
        $this->db->from('tbl_color');
        $this->db->where('status', 1);
        return $respond=$this->db->get();
    }
    public function Getvarnishlist() {
        $this->db->select('`idtbl_varnish`,`varnish`');
        $this->db->from('tbl_varnish');
        $this->db->where('status', 1);
        return $respond=$this->db->get();
    }
    public function Getlaminationlist() {
        $this->db->select('`idtbl_lamination`,`lamination`');
        $this->db->from('tbl_lamination');
        $this->db->where('status', 1);
        return $respond=$this->db->get();
    }
    public function Getfoilinglist() {
        $this->db->select('`idtbl_foiling`,`foiling`');
        $this->db->from('tbl_foiling');
        $this->db->where('status', 1);
        return $respond=$this->db->get();
    } 
    public function Getrimminglist() {
        $this->db->select('`idtbl_rimming`,`rimming`');
        $this->db->from('tbl_rimming');
        $this->db->where('status', 1);
        return $respond=$this->db->get();
    } 
    public function Getotherfinishinglist() {
        $this->db->select('`idtbl_finishing_other`,`finishing_other`');
        $this->db->from('tbl_finishing_other');
        $this->db->where('status', 1);
        return $respond=$this->db->get();
    }
    public function Getdiecuttinglist() {
        $this->db->select('`idtbl_diecutting`,`diecutting_name`');
        $this->db->from('tbl_diecutting');
        $this->db->where('status', 1);
        return $respond=$this->db->get();
    }
    public function Getpastinglist() {
        $this->db->select('`idtbl_pasting`,`pasting_name`');
        $this->db->from('tbl_pasting');
        $this->db->where('status', 1);
        return $respond=$this->db->get();
    }
    public function Getbinderylist() {
        $this->db->select('`idtbl_bindery`,`bindery_name`');
        $this->db->from('tbl_bindery');
        $this->db->where('status', 1);
        return $respond=$this->db->get();
    }
    public function GetNonValidatedAccounts() {
        $recordId = $this->input->post('recordID');

        $this->db->select('tbl_print_grn.batchno, tbl_print_grn.voucherissue');
        $this->db->from('tbl_jobcard_material');
        $this->db->join('tbl_print_grn', 'FIND_IN_SET(tbl_print_grn.batchno, tbl_jobcard_material.usedbatches) > 0');
        $this->db->where('tbl_jobcard_material.tbl_jobcard_idtbl_jobcard', $recordId);
        $this->db->group_by('tbl_print_grn.batchno');
        $query1 = $this->db->get_compiled_select();

        $this->db->select('`tbl_print_grn.batchno`, `tbl_print_grn`.`voucherissue`');
        $this->db->from('tbl_jobcard_lamination');
        $this->db->join('tbl_print_grn', 'FIND_IN_SET(tbl_print_grn.batchno, tbl_jobcard_lamination.usedbatches) > 0');
        $this->db->where('tbl_jobcard_lamination.tbl_jobcard_idtbl_jobcard', $recordId);
        $this->db->group_by('`tbl_print_grn.batchno`');
        $query2 = $this->db->get_compiled_select();

        $this->db->select('`tbl_print_grn.batchno`, `tbl_print_grn`.`voucherissue`');
        $this->db->from('tbl_jobcard_rimming');
        $this->db->join('tbl_print_grn', 'FIND_IN_SET(tbl_print_grn.batchno, tbl_jobcard_rimming.usedbatches) > 0');
        $this->db->where('tbl_jobcard_rimming.tbl_jobcard_idtbl_jobcard', $recordId);
        $this->db->group_by('`tbl_print_grn.batchno`');
        $query3 = $this->db->get_compiled_select();
        
        $this->db->select('`tbl_print_grn.batchno`, `tbl_print_grn`.`voucherissue`');
        $this->db->from('tbl_jobcard_varnish');
        $this->db->join('tbl_print_grn', 'FIND_IN_SET(tbl_print_grn.batchno, tbl_jobcard_varnish.usedbatches) > 0');
        $this->db->where('tbl_jobcard_varnish.tbl_jobcard_idtbl_jobcard', $recordId);
        $this->db->group_by('`tbl_print_grn.batchno`');
        $query4 = $this->db->get_compiled_select();

        $final_query = $this->db->query($query1 . ' UNION ' . $query2 . ' UNION ' . $query3);

        $results = $final_query->result();
        echo json_encode($results);

    }

	public function InsertJobCardAllocation(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $updatedatetime=date('Y-m-d H:i:s');

        $materialTable = $this->input->post('materialTable');
        $varnishTable = $this->input->post('varnishTable');
        $rimmingTable = $this->input->post('rimmingTable');
        $diecuttingTable = $this->input->post('diecuttingTable');
        $laminationTable = $this->input->post('laminationTable');

        $jobdescription = $this->input->post('jobdescription');
        $customer = $this->input->post('customer');
        $job = $this->input->post('job');
        $stockId = 0;
        $jobcardData = array(
            'jobcardno'=> 'asd', 
            'job_description'=> $jobdescription,
            'status'=> '1', 
            'insertdatetime'=> $updatedatetime, 
            'tbl_user_idtbl_user'=> $userID,
            'tbl_customer_idtbl_customer'=> $customer,
            'tbl_customerinquiry_detail_idtbl_customerinquiry_detail'=> $job,
        );
        $this->db->insert('tbl_jobcard', $jobcardData);
        $jobCardId = $this->db->insert_id(); // Get the inserted ID


        foreach($materialTable as $materialData){
            $printingformatId=$materialData['col_1'];
            $cutMaterialId=$materialData['col_2'];
            $cutSize=$materialData['col_5'];
            $sheetQty=$materialData['col_6'];
            $requiredSheetQty=$materialData['col_7'];
            $usedBatches=$materialData['col_8'];

            $materialListData = array(
                'sheetqty'=> $sheetQty, 
                'requiredsheetqty'=> $requiredSheetQty, 
                'cutsize'=> $cutSize, 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime, 
                'tbl_user_idtbl_user'=> $userID,
                'tbl_printing_format_idtbl_printing_format'=> $printingformatId,
                'tbl_print_material_info_idtbl_print_material_info'=> $cutMaterialId,
                'tbl_jobcard_idtbl_jobcard'=> $jobCardId,
                'usedbatches'=> $usedBatches,
            );
            $this->db->insert('tbl_jobcard_material', $materialListData);
        }

        foreach($varnishTable as $varnishData){
            $varnishId=$varnishData['col_1'];
            $varnishMaterialId=$varnishData['col_2'];
            $varnishSheetQty=$varnishData['col_5'];
            $requiredVarnishSheetQty=$varnishData['col_6'];
            $usedBatches=$varnishData['col_7'];

            $varnishListData = array(
                'varnishQty'=> $varnishSheetQty, 
                'requiredVarnishQty'=> $requiredVarnishSheetQty, 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime, 
                'tbl_user_idtbl_user'=> $userID,
                'tbl_print_material_info_idtbl_print_material_info'=> $varnishMaterialId,
                'tbl_varnish_idtbl_varnish'=> $varnishId,
                'tbl_jobcard_idtbl_jobcard'=> $jobCardId,
                'usedbatches'=> $usedBatches,
            );
            $this->db->insert('tbl_jobcard_varnish', $varnishListData);
        }
       
       
        foreach($laminationTable as $laminationData){
            $laminationId=$laminationData['col_1'];
            $laminationMaterialId=$laminationData['col_2'];
            $laminationPrintSides=$laminationData['col_3'];
            $filmSize=$laminationData['col_6'];
            $micron=$laminationData['col_7'];
            $laminationsheet_qty=$laminationData['col_9'];
            $requiredLaminationsheet_qty=$laminationData['col_10'];
            $usedBatches=$laminationData['col_11'];

            $laminationListData = array(
                'sides'=> $laminationPrintSides, 
                'filmsize'=> $filmSize, 
                'micron'=> $micron, 
                'lamination_qty'=> $laminationsheet_qty, 
                'required_lamination_qty'=> $requiredLaminationsheet_qty, 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime, 
                'tbl_user_idtbl_user'=> $userID,
                'tbl_print_material_info_idtbl_print_material_info'=> $laminationMaterialId,
                'tbl_lamination_idtbl_lamination'=> $laminationId,
                'tbl_jobcard_idtbl_jobcard'=> $jobCardId,
                'usedbatches'=> $usedBatches,
            );
            $this->db->insert('tbl_jobcard_lamination', $laminationListData);
        }
       
        foreach($rimmingTable as $rimmingData){
            $rimmingId=$rimmingData['col_1'];
            $rimmingMaterialId=$rimmingData['col_2'];
            $printedSides=$rimmingData['col_3'];
            $length=$rimmingData['col_6'];
            $rimmingQty=$rimmingData['col_8'];
            $requiredrimmingQty=$rimmingData['col_9'];
            $usedbatches=$rimmingData['col_10'];

            $rimmingListData = array(
                'sides'=> $printedSides, 
                'length'=> $length, 
                'qty'=> $rimmingQty, 
                'required_qty'=> $requiredrimmingQty, 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime, 
                'tbl_user_idtbl_user'=> $userID,
                'tbl_print_material_info_idtbl_print_material_info'=> $rimmingMaterialId,
                'tbl_rimming_idtbl_rimming'=> $rimmingId,
                'tbl_jobcard_idtbl_jobcard'=> $jobCardId,
                'usedbatches'=> $usedbatches
            );
            $this->db->insert('tbl_jobcard_rimming', $rimmingListData);
        }
        
        foreach($diecuttingTable as $dieCuttingData){
            $peraforation=$dieCuttingData['col_1'];
            $halfCutting=$dieCuttingData['col_2'];
            $fullCutting=$dieCuttingData['col_3'];
            $qty=$dieCuttingData['col_4'];
            $requiredqty=$dieCuttingData['col_5'];

            $dieCuttingListData = array(
                'peraforation'=> $peraforation, 
                'halfCutting'=> $halfCutting, 
                'fullCutting'=> $fullCutting, 
                'qty'=> $qty, 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime, 
                'tbl_user_idtbl_user'=> $userID,
                'tbl_jobcard_idtbl_jobcard'=> $jobCardId,
            );
            $this->db->insert('tbl_jobcard_diecutting', $dieCuttingListData);
        }
        $this->db->trans_complete();

        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            
            $actionObj=new stdClass();
            $actionObj->icon='fas fa-check';
            $actionObj->title='';
            $actionObj->message='Record Inserted Successfully';
            $actionObj->url='';
            $actionObj->target='_blank';
            $actionObj->type='success';

            $actionJSON=json_encode($actionObj);
            
            $this->session->set_flashdata('msg', $actionJSON);
            redirect('JobCardAllocation/');             
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
            redirect('JobCardAllocation/');
        }
    }

    public function GetJobCardPrint() {
		$recordID=$this->input->post('recordID');

        $this->db->select('`idtbl_jobcard`,`job`, `jobcardno`, `job_description`, `name`, `tbl_jobcard.insertdatetime`, `job_no`');
		$this->db->from('tbl_jobcard');
		$this->db->join('tbl_customerinquiry_detail', 'tbl_jobcard.tbl_customerinquiry_detail_idtbl_customerinquiry_detail = tbl_customerinquiry_detail.idtbl_customerinquiry_detail');
		$this->db->join('tbl_customer', 'tbl_jobcard.tbl_customer_idtbl_customer = tbl_customer.idtbl_customer');
		$this->db->where('tbl_jobcard.idtbl_jobcard', $recordID);

        $responddetail = $this->db->get()->row();


        if ($responddetail) {
            $jobcardID = $responddetail->idtbl_jobcard;
            $job = $responddetail->job;
            $jobcardNo = $responddetail->jobcardno;
            $jobDescription = $responddetail->job_description;
            $customerName = $responddetail->name;
            $jobno = $responddetail->job_no;
            $jobname = $responddetail->job;
            $insertdate = date('Y-m-d', strtotime($responddetail->insertdatetime));
        }


        $this->db->select('`cutsize`,`sheetqty`, `materialname`, `format_name`');
		$this->db->from('tbl_jobcard');
		$this->db->join('tbl_jobcard_material', 'tbl_jobcard.idtbl_jobcard = tbl_jobcard_material.tbl_jobcard_idtbl_jobcard');
		$this->db->join('tbl_print_material_info', 'tbl_jobcard_material.tbl_print_material_info_idtbl_print_material_info = tbl_print_material_info.idtbl_print_material_info');
		$this->db->join('tbl_printing_format', 'tbl_jobcard_material.tbl_printing_format_idtbl_printing_format = tbl_printing_format.idtbl_printing_format');
		$this->db->where('tbl_jobcard.idtbl_jobcard', $recordID);
        $materialdetail = $this->db->get()->result();
       
       
        $this->db->select('`varnishQty`, `materialname`, `varnish`');
		$this->db->from('tbl_jobcard');
		$this->db->join('tbl_jobcard_varnish', 'tbl_jobcard.idtbl_jobcard = tbl_jobcard_varnish.tbl_jobcard_idtbl_jobcard');
		$this->db->join('tbl_print_material_info', 'tbl_jobcard_varnish.tbl_print_material_info_idtbl_print_material_info = tbl_print_material_info.idtbl_print_material_info');
		$this->db->join('tbl_varnish', 'tbl_jobcard_varnish.tbl_varnish_idtbl_varnish = tbl_varnish.idtbl_varnish');
		$this->db->where('tbl_jobcard.idtbl_jobcard', $recordID);
        $varnishdetail = $this->db->get()->result();
      
      
        $this->db->select('`sides`, `filmsize`, `lamination`, `micron`, `lamination_qty`, `materialname`');
		$this->db->from('tbl_jobcard');
		$this->db->join('tbl_jobcard_lamination', 'tbl_jobcard.idtbl_jobcard = tbl_jobcard_lamination.tbl_jobcard_idtbl_jobcard');
		$this->db->join('tbl_print_material_info', 'tbl_jobcard_lamination.tbl_print_material_info_idtbl_print_material_info = tbl_print_material_info.idtbl_print_material_info');
		$this->db->join('tbl_lamination', 'tbl_jobcard_lamination.tbl_lamination_idtbl_lamination = tbl_lamination.idtbl_lamination');
		$this->db->where('tbl_jobcard.idtbl_jobcard', $recordID);
        $laminationdetail = $this->db->get()->result();
    
    
        $this->db->select('`sides`, `length`, `qty`, `materialname`, `rimming`');
		$this->db->from('tbl_jobcard');
		$this->db->join('tbl_jobcard_rimming', 'tbl_jobcard.idtbl_jobcard = tbl_jobcard_rimming.tbl_jobcard_idtbl_jobcard');
		$this->db->join('tbl_print_material_info', 'tbl_jobcard_rimming.tbl_print_material_info_idtbl_print_material_info = tbl_print_material_info.idtbl_print_material_info');
		$this->db->join('tbl_rimming', 'tbl_jobcard_rimming.tbl_rimming_idtbl_rimming = tbl_rimming.idtbl_rimming');
		$this->db->where('tbl_jobcard.idtbl_jobcard', $recordID);
        $rimmingdetails = $this->db->get()->result();
        
        
        $this->db->select('`peraforation`, `halfCutting`, `fullCutting`, `qty`');
		$this->db->from('tbl_jobcard');
		$this->db->join('tbl_jobcard_diecutting', 'tbl_jobcard.idtbl_jobcard = tbl_jobcard_diecutting.tbl_jobcard_idtbl_jobcard');
		$this->db->where('tbl_jobcard.idtbl_jobcard', $recordID);
        $diecuttingdetails = $this->db->get()->result();

		$html='';

		$html = '
                <div class="row">
                    <div class="col-12 text-center">
                        <h4><u>JOB CARD</u></h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-9">
                        <label class="font-weight-bold">Customer: ' . $customerName . '</label>
                        <div class="card mt-2 border-secondary">
                            <div class="card-header p-2 border-secondary small">
                                Job Description
                            </div>
                            <div class="card-body p-2 small font-weight-bold">
                                ' . $jobDescription . '
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <label class="font-weight-bold">Date: <span class="font-weight-bold">' . $insertdate . '</span></label><br>
                        <label class="font-weight-bold">Job No: <span class="font-weight-bold">' . $jobno . '</span></label>
                        <ul class="list-group mt-2">
                            <li class="list-group-item px-2 py-0 small border-secondary">
                                Name: <span class="font-weight-bold">' . $jobname . '</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <h6>MATERIAL SECTION</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-9">
                        <table class="table table-sm table-striped table-bordered small">
                            <thead>
                                <tr>
                                    <td class="text-left border-secondary">No</td>
                                    <td class="text-center border-secondary">Format</td>
                                    <td class="text-center border-secondary">Paper/Board</td>
                                    <td class="text-center border-secondary">Cutting Size</td>
                                    <td class="text-center border-secondary">Sheets</td>
                                </tr>
                            </thead>
                            <tbody>';

                $i = 1;
                if ($materialdetail) {
                    foreach ($materialdetail as $materialrow) {
                        $cutSize = $materialrow->cutsize;
                        $sheetQty = $materialrow->sheetqty;
                        $materialName = $materialrow->materialname;
                        $formatName = $materialrow->format_name;

                        $html .= '
                                <tr>
                                    <td class="text-left border-secondary">' . $i . '</td>
                                    <td class="text-center border-secondary">' . $formatName . '</td>
                                    <td class="text-center border-secondary">' . $materialName . '</td>
                                    <td class="text-center border-secondary">' . $cutSize . '</td>
                                    <td class="text-center border-secondary">' . $sheetQty . '</td>
                                </tr>';
                        $i++;
                    }
                } else {
                    $html .= '
                                <tr>
                                    <td class="text-center border-secondary" colspan="5">No Data Preview</td>
                                </tr>';
                }

                $html .= '
                            </tbody>
                        </table>
                    </div>
                    <div class="col-3 text-center small">
                        .............................................<br>
                        .............................................<br>
                        .............................................<br><br>
                        .............................................<br>
                        Machine Operator
                    </div>
                </div>
                  <div class="row mt-3">
                  <div class="col-12">
                        <h6>VARNISH SECTION</h6>
                  </div>
                </div>
                <div class="row">
                    <div class="col-9">
                        <table class="table table-sm table-striped table-bordered small">
                            <thead>
                                <tr>
                                    <td class="text-left border-secondary">No</td>
                                    <td class="text-center border-secondary">Varnish</td>
                                    <td class="text-center border-secondary">Material</td>
                                    <td class="text-center border-secondary">Sheets</td>
                                </tr>
                            </thead>
                            <tbody>';

                $i = 1;
                if ($varnishdetail) {
                    foreach ($varnishdetail as $varnishRow) {
                        $varnishQty = $varnishRow->varnishQty;
                        $materialName = $varnishRow->materialname;
                        $varnish = $varnishRow->varnish;

                        $html .= '
                                <tr>
                                    <td class="text-left border-secondary">' . $i . '</td>
                                    <td class="text-center border-secondary">' . $varnish . '</td>
                                    <td class="text-center border-secondary">' . $materialName . '</td>
                                    <td class="text-center border-secondary">' . $varnishQty . '</td>
                                </tr>';
                        $i++;
                    }
                } else {
                    $html .= '
                                <tr>
                                    <td class="text-center border-secondary" colspan="5">No Data Preview</td>
                                </tr>';
                }

                $html .= '
                            </tbody>
                        </table>
                    </div>
                    <div class="col-3 text-center small">
                        .............................................<br>
                        .............................................<br>
                        .............................................<br><br>
                        .............................................<br>
                        Machine Operator
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <h6>LAMINATING SECTION</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-9">
                        <table class="table table-sm table-striped table-bordered small">
                            <thead>
                                <tr>
                                    <td class="text-left border-secondary">No</td>
                                    <td class="text-center border-secondary">Lamination</td>
                                    <td class="text-center border-secondary">Material</td>
                                    <td class="text-center border-secondary">Film Size</td>
                                    <td class="text-center border-secondary">Micron</td>
                                    <td class="text-center border-secondary">Sides</td>
                                </tr>
                            </thead>
                            <tbody>';

                $i = 1;
                if ($laminationdetail) {
                    foreach ($laminationdetail as $laminationrow) {
                        $sides = $laminationrow->sides;
                        $filmsize = $laminationrow->filmsize;
                        $lamination = $laminationrow->lamination;
                        $micron = $laminationrow->micron;
                        $lamination_qty = $laminationrow->lamination_qty;
                        $materialName = $laminationrow->materialname;

                        if($sides == 1){
                            $sidestext = 'One Sided';
                        }else{
                            $sidestext = 'Double Sided';
                        }
                        $html .= '
                                <tr>
                                    <td class="text-left border-secondary">' . $i . '</td>
                                    <td class="text-center border-secondary">' . $lamination . '</td>
                                    <td class="text-center border-secondary">' . $materialName . '</td>
                                    <td class="text-center border-secondary">' . $filmsize . '</td>
                                    <td class="text-center border-secondary">' . $micron . '</td>
                                    <td class="text-center border-secondary">' . $sidestext . '</td>
                                </tr>';
                        $i++;
                    }
                } else {
                    $html .= '
                                <tr>
                                    <td class="text-center border-secondary" colspan="5">No Data Preview</td>
                                </tr>';
                }

                $html .= '
                            </tbody>
                        </table>
                    </div>
                    <div class="col-3 text-center small">
                        .............................................<br>
                        .............................................<br>
                        .............................................<br><br>
                        .............................................<br>
                        Machine Operator
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <h6>LAMINATING SECTION</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-9">
                        <table class="table table-sm table-striped table-bordered small">
                            <thead>
                                <tr>
                                    <td class="text-left border-secondary">No</td>
                                    <td class="text-center border-secondary">Rimming</td>
                                    <td class="text-center border-secondary">Material</td>
                                    <td class="text-center border-secondary">Length</td>
                                    <td class="text-center border-secondary">Qty</td>
                                    <td class="text-center border-secondary">Sides</td>
                                </tr>
                            </thead>
                            <tbody>';

                $i = 1;
                if ($rimmingdetails) {
                    foreach ($rimmingdetails as $rimmingrow) {
                        $sides = $rimmingrow->sides;
                        $length = $rimmingrow->length;
                        $rimming = $rimmingrow->rimming;
                        $qty = $rimmingrow->qty;
                        $materialName = $rimmingrow->materialname;

                        if($sides == 1){
                            $sidestext = 'One Sided';
                        }else{
                            $sidestext = 'Double Sided';
                        }
                        $html .= '
                                <tr>
                                    <td class="text-left border-secondary">' . $i . '</td>
                                    <td class="text-center border-secondary">' . $rimming . '</td>
                                    <td class="text-center border-secondary">' . $materialName . '</td>
                                    <td class="text-center border-secondary">' . $length . '</td>
                                    <td class="text-center border-secondary">' . $qty . '</td>
                                    <td class="text-center border-secondary">' . $sidestext . '</td>
                                </tr>';
                        $i++;
                    }
                } else {
                    $html .= '
                                <tr>
                                    <td class="text-center border-secondary" colspan="5">No Data Preview</td>
                                </tr>';
                }

                $html .= '
                            </tbody>
                        </table>
                    </div>
                    <div class="col-3 text-center small">
                        .............................................<br>
                        .............................................<br>
                        .............................................<br><br>
                        .............................................<br>
                        Machine Operator
                    </div>
                </div>
                 <div class="row mt-3">
                    <div class="col-12">
                        <h6>DIE CUTTING SECTION</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-9">
                        <table class="table table-sm table-striped table-bordered small">
                            <thead>
                                <tr>
                                    <td class="text-left border-secondary">No</td>
                                    <td class="text-center border-secondary">Qty</td>
                                    <td class="text-center border-secondary">Peraforation</td>
                                    <td class="text-center border-secondary">Hald Cutting</td>
                                    <td class="text-center border-secondary">Full Cutting</td>
                                </tr>
                            </thead>
                            <tbody>';

                $i = 1;
                if ($diecuttingdetails) {
                    foreach ($diecuttingdetails as $diecuttingrow) {
                        $peraforation = $diecuttingrow->peraforation;
                        $halfCutting = $diecuttingrow->halfCutting;
                        $fullCutting = $diecuttingrow->fullCutting;
                        $qty = $diecuttingrow->qty;

                        if($peraforation == 0){
                            $pereforationtext = 'No';
                        }else{
                            $pereforationtext = 'Yes';
                        }
                        if($halfCutting == 0){
                            $halfCuttingtext = 'No';
                        }else{
                            $halfCuttingtext = 'Yes';
                        }
                        if($fullCutting == 0){
                            $fullCuttingtext = 'No';
                        }else{
                            $fullCuttingtext = 'Yes';
                        }
                        $html .= '
                                <tr>
                                    <td class="text-left border-secondary">' . $i . '</td>
                                    <td class="text-center border-secondary">' . $qty . '</td>
                                    <td class="text-center border-secondary">' . $pereforationtext . '</td>
                                    <td class="text-center border-secondary">' . $halfCuttingtext . '</td>
                                    <td class="text-center border-secondary">' . $fullCuttingtext . '</td>
                                </tr>';
                        $i++;
                    }
                } else {
                    $html .= '
                                <tr>
                                    <td class="text-center border-secondary" colspan="5">No Data Preview</td>
                                </tr>';
                }

                $html .= '
                            </tbody>
                        </table>
                    </div>
                    <div class="col-3 text-center small">
                        .............................................<br>
                        .............................................<br>
                        .............................................<br><br>
                        .............................................<br>
                        Machine Operator
                    </div>
                </div>
                <div class="row">
                    <div class="col-3 text-center small">
                        <br>.............................................<br>
                        Prepared by
                    </div>
                    <div class="col-3 text-center small">
                        <br>.............................................<br>
                        Approved by
                    </div>
                </div>';

       
         echo $html;

	}

    public function ApproveJobCard($x) {
		$this->db->trans_begin();

		$userID=$_SESSION['userid'];
        $recordID=$x;
        $updatedatetime=date('Y-m-d H:i:s');

        $data = array(
            'approve_status' => '1',
            'tbl_user_idtbl_user'=> $userID, 
            'updatedatetime'=> $updatedatetime
        );
        $this->db->where('idtbl_jobcard', $recordID);
        $this->db->update('tbl_jobcard', $data);

        $this->db->trans_complete();

        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            
            $actionObj=new stdClass();
            $actionObj->icon='fas fa-check';
            $actionObj->title='';
            $actionObj->message='Job Card Activate Successfully';
            $actionObj->url='';
            $actionObj->target='_blank';
            $actionObj->type='success';

            $actionJSON=json_encode($actionObj);
            
            $this->session->set_flashdata('msg', $actionJSON);
            redirect('JobCardAllocation');                
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
            redirect('JobCardAllocation');
        }
	}

    public function IssueStock($x) {
		$this->db->trans_begin();

		$userID=$_SESSION['userid'];
        $recordID=$x;
        $updatedatetime=date('Y-m-d H:i:s');

        $this->db->select('tbl_jobcard_material.requiredsheetqty AS requiredqty, 
                tbl_print_stock.idtbl_print_stock, 
                tbl_print_stock.qty, 
                tbl_print_stock.batchno,
                tbl_print_stock.unitprice,
                tbl_jobcard.idtbl_jobcard,
                tbl_jobcard_material.tbl_print_material_info_idtbl_print_material_info AS materialid');
        $this->db->from('tbl_jobcard');
        $this->db->join('tbl_jobcard_material', 'tbl_jobcard.idtbl_jobcard = tbl_jobcard_material.tbl_jobcard_idtbl_jobcard');
        $this->db->join('tbl_print_stock', 'FIND_IN_SET(tbl_print_stock.batchno, tbl_jobcard_material.usedbatches) > 0 AND tbl_print_stock.tbl_print_material_info_idtbl_print_material_info = tbl_jobcard_material.tbl_print_material_info_idtbl_print_material_info');
        $this->db->where('tbl_jobcard.idtbl_jobcard', $recordID);
        $materialdetail = $this->db->get()->result();
       
		$this->db->select('tbl_jobcard_varnish.requiredVarnishQty AS requiredqty, 
                tbl_print_stock.idtbl_print_stock, 
                tbl_print_stock.qty, 
                tbl_print_stock.batchno,
                tbl_print_stock.unitprice,
                tbl_jobcard.idtbl_jobcard,
                tbl_jobcard_varnish.tbl_print_material_info_idtbl_print_material_info AS materialid');
        $this->db->from('tbl_jobcard');
		$this->db->join('tbl_jobcard_varnish', 'tbl_jobcard.idtbl_jobcard = tbl_jobcard_varnish.tbl_jobcard_idtbl_jobcard');
        $this->db->join('tbl_print_stock', 'FIND_IN_SET(tbl_print_stock.batchno, tbl_jobcard_varnish.usedbatches) > 0 AND tbl_print_stock.tbl_print_material_info_idtbl_print_material_info = tbl_jobcard_varnish.tbl_print_material_info_idtbl_print_material_info');
		$this->db->where('tbl_jobcard.idtbl_jobcard', $recordID);
        $varnishdetail = $this->db->get()->result();
      
      
		$this->db->select('tbl_jobcard_lamination.required_lamination_qty AS requiredqty, 
                tbl_print_stock.idtbl_print_stock, 
                tbl_print_stock.qty, 
                tbl_print_stock.batchno,
                tbl_print_stock.unitprice,
                tbl_jobcard.idtbl_jobcard,
                tbl_jobcard_lamination.tbl_print_material_info_idtbl_print_material_info AS materialid');
        $this->db->from('tbl_jobcard');
		$this->db->join('tbl_jobcard_lamination', 'tbl_jobcard.idtbl_jobcard = tbl_jobcard_lamination.tbl_jobcard_idtbl_jobcard');
        $this->db->join('tbl_print_stock', 'FIND_IN_SET(tbl_print_stock.batchno, tbl_jobcard_lamination.usedbatches) > 0 AND tbl_print_stock.tbl_print_material_info_idtbl_print_material_info = tbl_jobcard_lamination.tbl_print_material_info_idtbl_print_material_info');
		$this->db->where('tbl_jobcard.idtbl_jobcard', $recordID);
        $laminationdetail = $this->db->get()->result();
    
    
		$this->db->select('tbl_jobcard_rimming.required_qty AS requiredqty, 
                tbl_print_stock.idtbl_print_stock, 
                tbl_print_stock.qty, 
                tbl_print_stock.batchno,
                tbl_print_stock.unitprice,
                tbl_jobcard.idtbl_jobcard,
                tbl_jobcard_rimming.tbl_print_material_info_idtbl_print_material_info AS materialid');
        $this->db->from('tbl_jobcard');
		$this->db->join('tbl_jobcard_rimming', 'tbl_jobcard.idtbl_jobcard = tbl_jobcard_rimming.tbl_jobcard_idtbl_jobcard');
        $this->db->join('tbl_print_stock', 'FIND_IN_SET(tbl_print_stock.batchno, tbl_jobcard_rimming.usedbatches) > 0 AND tbl_print_stock.tbl_print_material_info_idtbl_print_material_info = tbl_jobcard_rimming.tbl_print_material_info_idtbl_print_material_info');
		$this->db->where('tbl_jobcard.idtbl_jobcard', $recordID);
        $rimmingdetails = $this->db->get()->result();
        

        try {
            $remainingQty = 0;
            $lastQty = 0;
            $oldMaterialId = '';
            $newMaterialId = '';
            foreach ($materialdetail as $materialrow) {
                $stockqty = $materialrow->qty;
                $stockId = $materialrow->idtbl_print_stock;
                $batchno = $materialrow->batchno;
                $unitprice = $materialrow->unitprice;
                $jobCardId = $materialrow->idtbl_jobcard;
                
                $newMaterialId = $materialrow->materialid;

                if($oldMaterialId != $newMaterialId){
                    $oldMaterialId = $materialrow->materialid;
                    $remainingQty = $materialrow->requiredqty;
                }

                if($stockqty >= $remainingQty && $remainingQty != 0){

                    $materialdata = array(
                        'updateuser'=> $userID, 
                        'updatedatetime'=> $updatedatetime
                    );
    
                    $this->db->set('qty', 'qty - ' . $remainingQty, FALSE);
                    $this->db->where('idtbl_print_stock', $stockId);
                    $this->db->update('tbl_print_stock', $materialdata);
                    
                    $lastQty = $remainingQty;
                    $remainingQty = 0;
                }  else if($stockqty < $remainingQty && $remainingQty != 0){
                    $lastQty = $stockqty;
                    $remainingQty = $remainingQty - $stockqty;
                
                    $materialdata = array(
                        'updateuser'=> $userID, 
                        'updatedatetime'=> $updatedatetime,
                        'qty'=> 0
                    );
    
                    $this->db->where('idtbl_print_stock', $stockId);
                    $this->db->update('tbl_print_stock', $materialdata);
                }
                
                $historyData = array(
                    'batchno'=> $batchno, 
                    'unitprice'=> $unitprice, 
                    'usedqty'=> $lastQty, 
                    'status'=> '1', 
                    'type'=> '1', 
                    'insertdatetime'=> $updatedatetime, 
                    'tbl_user_idtbl_user'=> $userID,
                    'tbl_jobcard_material_idtbl_jobcard_material'=> $oldMaterialId,
                    'tbl_print_stock_idtbl_print_stock'=> $stockId,
                    'tbl_jobcard_idtbl_jobcard'=> $jobCardId,
                );
                $this->db->insert('tbl_job_card_allocation_history', $historyData);

            }
            if ($remainingQty > 0) {
                throw new Exception("Insufficient stock for Material ID: {$stockId}");
            }
            $remainingQty = 0;
            $lastQty = 0;
            $oldMaterialId = '';
            $newMaterialId = '';
            foreach ($varnishdetail as $varnishrow) {
                $stockqty = $materialrow->qty;
                $stockId = $materialrow->idtbl_print_stock;
                $batchno = $materialrow->batchno;
                $unitprice = $materialrow->unitprice;
                $jobCardId = $materialrow->idtbl_jobcard;

                $newMaterialId = $materialrow->materialid;

                if($oldMaterialId != $newMaterialId){
                    $oldMaterialId = $materialrow->materialid;
                    $remainingQty = $materialrow->requiredqty;
                }

                if($stockqty >= $remainingQty && $remainingQty != 0){
                    $varnishdata = array(
                        'updateuser'=> $userID, 
                        'updatedatetime'=> $updatedatetime
                    );
    
                    $this->db->set('qty', 'qty - ' . $remainingQty, FALSE);
                    $this->db->where('idtbl_print_stock', $stockId);
                    $this->db->update('tbl_print_stock', $varnishdata);

                    $lastQty = $remainingQty;
                    $remainingQty = 0;

                }  else if($stockqty < $remainingQty && $remainingQty != 0){
                    $lastQty = $stockqty;
                    $remainingQty = $remainingQty - $stockqty;

                    $varnishdata = array(
                        'updateuser'=> $userID, 
                        'updatedatetime'=> $updatedatetime,
                        'qty'=> 0
                    );
    
                    $this->db->where('idtbl_print_stock', $stockId);
                    $this->db->update('tbl_print_stock', $varnishdata);
                }

                if ($remainingQty != 0) {
                    throw new Exception("Insufficient stock for Material ID: {$stockId}");
                }

                $historyData = array(
                    'batchno'=> $batchno, 
                    'unitprice'=> $unitprice, 
                    'usedqty'=> $lastQty, 
                    'status'=> '1', 
                    'type'=> '2', 
                    'insertdatetime'=> $updatedatetime, 
                    'tbl_user_idtbl_user'=> $userID,
                    'tbl_jobcard_material_idtbl_jobcard_material'=> $oldMaterialId,
                    'tbl_print_stock_idtbl_print_stock'=> $stockId,
                    'tbl_jobcard_idtbl_jobcard'=> $jobCardId,
                );
                $this->db->insert('tbl_job_card_allocation_history', $historyData);
                
            }
            $remainingQty = 0;
            $lastQty = 0;
            $oldMaterialId = '';
            $newMaterialId = '';
            foreach ($laminationdetail as $laminationrow) {
                $stockqty = $materialrow->qty;
                $stockId = $materialrow->idtbl_print_stock;
                $batchno = $materialrow->batchno;
                $unitprice = $materialrow->unitprice;
                $jobCardId = $materialrow->idtbl_jobcard;

                $newMaterialId = $materialrow->materialid;

                if($oldMaterialId != $newMaterialId){
                    $oldMaterialId = $materialrow->materialid;
                    $remainingQty = $materialrow->requiredqty;
                }

                if($stockqty >= $remainingQty && $remainingQty != 0){
                    $laminationdata = array(
                        'updateuser'=> $userID, 
                        'updatedatetime'=> $updatedatetime
                    );
    
                    $this->db->set('qty', 'qty - ' . $remainingQty, FALSE);
                    $this->db->where('idtbl_print_stock', $stockId);
                    $this->db->update('tbl_print_stock', $laminationdata);

                    $lastQty = $remainingQty;
                    $remainingQty = 0;
                }  else if($stockqty < $remainingQty && $remainingQty != 0){
                    $lastQty = $stockqty;
                    $remainingQty = $remainingQty - $stockqty;

                    $laminationdata = array(
                        'updateuser'=> $userID, 
                        'updatedatetime'=> $updatedatetime,
                        'qty'=> 0
                    );
    
                    $this->db->where('idtbl_print_stock', $stockId);
                    $this->db->update('tbl_print_stock', $laminationdata);
                    
                }

                if ($remainingQty != 0) {
                    throw new Exception("Insufficient stock for Material ID: {$remainingQty}");
                }
                $historyData = array(
                    'batchno'=> $batchno, 
                    'unitprice'=> $unitprice, 
                    'usedqty'=> $lastQty, 
                    'status'=> '1', 
                    'type'=> '3', 
                    'insertdatetime'=> $updatedatetime, 
                    'tbl_user_idtbl_user'=> $userID,
                    'tbl_jobcard_material_idtbl_jobcard_material'=> $oldMaterialId,
                    'tbl_print_stock_idtbl_print_stock'=> $stockId,
                    'tbl_jobcard_idtbl_jobcard'=> $jobCardId,
                );
                $this->db->insert('tbl_job_card_allocation_history', $historyData);
                
            }
            $remainingQty = 0;
            $lastQty = 0;
            $oldMaterialId = '';
            $newMaterialId = '';
            foreach ($rimmingdetails as $rimmingrow) {
                $stockqty = $materialrow->qty;
                $stockId = $materialrow->idtbl_print_stock;
                $batchno = $materialrow->batchno;
                $unitprice = $materialrow->unitprice;
                $jobCardId = $materialrow->idtbl_jobcard;

                $newMaterialId = $materialrow->materialid;

                if($oldMaterialId != $newMaterialId){
                    $oldMaterialId = $materialrow->materialid;
                    $remainingQty = $materialrow->requiredqty;
                }

                if($stockqty >= $remainingQty && $remainingQty != 0){
                    $rimmingdata = array(
                        'updateuser'=> $userID, 
                        'updatedatetime'=> $updatedatetime
                    );
    
                    $this->db->set('qty', 'qty - ' . $remainingQty, FALSE);
                    $this->db->where('idtbl_print_stock', $stockId);
                    $this->db->update('tbl_print_stock', $rimmingdata);

                    $lastQty = $remainingQty;
                    $remainingQty = 0;
                }  else if($stockqty < $remainingQty && $remainingQty != 0){
                    $lastQty = $stockqty;
                    $remainingQty = $remainingQty - $stockqty;

                    $rimmingdata = array(
                        'updateuser'=> $userID, 
                        'updatedatetime'=> $updatedatetime,
                        'qty'=> 0
                    );
    
                    $this->db->where('idtbl_print_stock', $stockId);
                    $this->db->update('tbl_print_stock', $rimmingdata);
                }

                if ($remainingQty != 0) {
                    throw new Exception("Insufficient stock for Material ID: {$stockId}");
                }

                $historyData = array(
                    'batchno'=> $batchno, 
                    'unitprice'=> $unitprice, 
                    'usedqty'=> $lastQty, 
                    'status'=> '1', 
                    'type'=> '4', 
                    'insertdatetime'=> $updatedatetime, 
                    'tbl_user_idtbl_user'=> $userID,
                    'tbl_jobcard_material_idtbl_jobcard_material'=> $oldMaterialId,
                    'tbl_print_stock_idtbl_print_stock'=> $stockId,
                    'tbl_jobcard_idtbl_jobcard'=> $jobCardId,
                );
                $this->db->insert('tbl_job_card_allocation_history', $historyData);
            }

            $data = array(
                'stock_issue_status' => '1',
                'tbl_user_idtbl_user'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );
            $this->db->where('idtbl_jobcard', $recordID);
            $this->db->update('tbl_jobcard', $data);

        } catch (Exception $e) {
            $this->db->trans_rollback();

            $actionObj=new stdClass();
            $actionObj->icon='fas fa-warning';
            $actionObj->title='';
            $actionObj->message=$e->getMessage();;
            $actionObj->url='';
            $actionObj->target='_blank';
            $actionObj->type='danger';

            $actionJSON=json_encode($actionObj);
            
            $this->session->set_flashdata('msg', $actionJSON);
            redirect('JobCardAllocation');
        }

       

        $this->db->trans_complete();

        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            
            $actionObj=new stdClass();
            $actionObj->icon='fas fa-check';
            $actionObj->title='';
            $actionObj->message='Stock issued Successfully';
            $actionObj->url='';
            $actionObj->target='_blank';
            $actionObj->type='success';

            $actionJSON=json_encode($actionObj);
            
            $this->session->set_flashdata('msg', $actionJSON);
            redirect('JobCardAllocation');                
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
            redirect('JobCardAllocation');
        }
	}

    public function TransferToAccounts() {
		$this->db->trans_begin();

		$userID=$_SESSION['userid'];
        $comapnyID=$_SESSION['company_id'];
        $branch=$_SESSION['branch_id'];

		$recordID=$this->input->post('recordID');
        $updatedatetime=date('Y-m-d H:i:s');

        $fullTot = 0;
        $materialTot = 0;
        $varnishTot = 0;
        $laminationTot = 0;
        $rimmingTot = 0;

        $this->db->select('SUM(unitprice * usedqty) AS total_price');
        $this->db->from('tbl_job_card_allocation_history');
        $this->db->where('tbl_job_card_allocation_history.tbl_jobcard_idtbl_jobcard', $recordID);
        $querymaterial = $this->db->get();
        $fullTot = $querymaterial->row()->total_price;
       
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://aws.erav.lk/multioffsetaccount/Api/Issuematerialprocess");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "userid=$userID&company=$comapnyID&branch=$branch&tradate=$updatedatetime&traamount=$fullTot&accountcrno=$withvattotal&narrationcr=$segregationdataencode&accountdrno=$segregationdataencode&narrationdr=$segregationdataencode");
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
            redirect('JobCardAllocation');
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
                redirect('JobCardAllocation');
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
                redirect('JobCardAllocation');
            }
        }
	}

    public function GetJobBOMDetails() {
        $recordID = $this->input->post('recordID');
        $jobId = 0;
        $qty = 0;
    
        // Query to fetch job ID and quantity
        $this->db->select('`qty`, `job_id`');
        $this->db->from('tbl_customerinquiry_detail');
        $this->db->where('tbl_customerinquiry_detail.idtbl_customerinquiry_detail', $recordID);
    
        $responddetail = $this->db->get()->row();
    
        $mainObj = new stdClass(); 
    
        if ($responddetail) {
            $jobId = $responddetail->job_id;
            $qty = $responddetail->qty;
    
            $mainObj->qty = $qty;
            $mainObj->jobId = $jobId;
        }
    
        $this->db->select('*');
        $this->db->from('tbl_jobcard_bom_lamination');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_bom_lamination.tbl_print_material_info_idtbl_print_material_info');
        $this->db->join('tbl_lamination', 'tbl_lamination.idtbl_lamination = tbl_jobcard_bom_lamination.tbl_lamination_idtbl_lamination');
        $this->db->where('tbl_jobcard_bom_lamination.tbl_customer_job_details_idtbl_customer_job_details', $jobId);    
        $laminationDetail = $this->db->get()->result();
    
        $this->db->select('*');
        $this->db->from('tbl_jobcard_bom_material');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_bom_material.tbl_print_material_info_idtbl_print_material_info');
        $this->db->join('tbl_printing_format', 'tbl_printing_format.idtbl_printing_format = tbl_jobcard_bom_material.tbl_printing_format_idtbl_printing_format');
        $this->db->where('tbl_jobcard_bom_material.tbl_customer_job_details_idtbl_customer_job_details', $jobId);    
        $materialDetail = $this->db->get()->result();
        
        $this->db->select('*');
        $this->db->from('tbl_jobcard_bom_rimming');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_bom_rimming.tbl_print_material_info_idtbl_print_material_info');
        $this->db->join('tbl_rimming', 'tbl_rimming.idtbl_rimming = tbl_jobcard_bom_rimming.tbl_rimming_idtbl_rimming');
        $this->db->where('tbl_jobcard_bom_rimming.tbl_customer_job_details_idtbl_customer_job_details', $jobId);    
        $rimmingDetail = $this->db->get()->result();
     
        $this->db->select('*');
        $this->db->from('tbl_jobcard_bom_varnish');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_bom_varnish.tbl_print_material_info_idtbl_print_material_info');
        $this->db->join('tbl_varnish', 'tbl_varnish.idtbl_varnish = tbl_jobcard_bom_varnish.tbl_varnish_idtbl_varnish');
        $this->db->where('tbl_jobcard_bom_varnish.tbl_customer_job_details_idtbl_customer_job_details', $jobId);    
        $varnishDetail = $this->db->get()->result();
  
        $this->db->select('*');
        $this->db->from('tbl_jobcard_bom_diecutting');
        $this->db->where('tbl_jobcard_bom_diecutting.tbl_customer_job_details_idtbl_customer_job_details', $jobId);    
        $diecuttingDetail = $this->db->get()->result();
    

        $mainObj->laminationDetail = $laminationDetail;
        $mainObj->materialDetail = $materialDetail;
        $mainObj->rimmingDetail = $rimmingDetail;
        $mainObj->varnishDetail = $varnishDetail;
        $mainObj->diecuttingDetail = $diecuttingDetail;
    
        echo json_encode($mainObj);
    }
    public function Getmachinelist() {
        $this->db->select('idtbl_machine, machine');
        $this->db->from('tbl_machine');
        $this->db->where('status', 1);
        return $this->db->get();
    }
}


