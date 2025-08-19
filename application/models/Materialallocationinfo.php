<?php
use Dompdf\Dompdf;
use Dompdf\Options;

class Materialallocationinfo extends CI_Model{
    public function Getcustomerinquirylist() {
        $searchTerm = $this->input->post('searchTerm');
        $customerid = $this->input->post('customerid');
    
        if(!isset($searchTerm)){
            $this->db->select('tbl_customerinquiry_detail.job, tbl_customerinquiry.idtbl_customerinquiry, tbl_customerinquiry_detail.job_no, tbl_customerinquiry_detail.qty, SUM(CASE WHEN tbl_jobcard.approvestatus < 2 THEN IFNULL(tbl_jobcard.issueqty, 0) ELSE 0 END) AS issueqty');
            $this->db->from('tbl_customerinquiry_detail');
            $this->db->join('tbl_customerinquiry', 'tbl_customerinquiry.idtbl_customerinquiry = tbl_customerinquiry_detail.tbl_customerinquiry_idtbl_customerinquiry', 'left');
            $this->db->join('tbl_jobcard', 'tbl_jobcard.tbl_customerinquiry_idtbl_customerinquiry = tbl_customerinquiry_detail.tbl_customerinquiry_idtbl_customerinquiry', 'left');
            $this->db->where('tbl_customerinquiry.tbl_customer_idtbl_customer', $customerid);
            $this->db->where('tbl_customerinquiry.status', 1);
            $this->db->where('tbl_customerinquiry.approvestatus', 1);
            $this->db->where('tbl_customerinquiry_detail.job_finish_status', 0);
            $this->db->group_by("tbl_customerinquiry_detail.idtbl_customerinquiry_detail");
            $this->db->limit(5);
            $respond = $this->db->get();
        }
        else{            
            if(!empty($searchTerm)){
                $this->db->select('tbl_customerinquiry_detail.job, tbl_customerinquiry.idtbl_customerinquiry, tbl_customerinquiry_detail.job_no, tbl_customerinquiry_detail.qty, SUM(CASE WHEN tbl_jobcard.approvestatus < 2 THEN IFNULL(tbl_jobcard.issueqty, 0) ELSE 0 END) AS issueqty');
                $this->db->from('tbl_customerinquiry_detail');
                $this->db->join('tbl_customerinquiry', 'tbl_customerinquiry.idtbl_customerinquiry = tbl_customerinquiry_detail.tbl_customerinquiry_idtbl_customerinquiry', 'left');
                $this->db->join('tbl_jobcard', 'tbl_jobcard.tbl_customerinquiry_idtbl_customerinquiry = tbl_customerinquiry_detail.tbl_customerinquiry_idtbl_customerinquiry', 'left');
                $this->db->where('tbl_customerinquiry.tbl_customer_idtbl_customer', $customerid);
                $this->db->where('tbl_customerinquiry.status', 1);
                $this->db->where('tbl_customerinquiry.approvestatus', 1);
                $this->db->where('tbl_customerinquiry_detail.job_finish_status', 0);
                $this->db->like('tbl_customerinquiry_detail.job_no', $searchTerm, 'both'); 
                $this->db->or_like('tbl_customerinquiry_detail.job', $searchTerm, 'both');
                $this->db->group_by("tbl_customerinquiry_detail.idtbl_customerinquiry_detail");
                $respond=$this->db->get();
            }
            else{
                $this->db->select('tbl_customerinquiry_detail.job, tbl_customerinquiry.idtbl_customerinquiry, tbl_customerinquiry_detail.job_no, tbl_customerinquiry_detail.qty, SUM(CASE WHEN tbl_jobcard.approvestatus < 2 THEN IFNULL(tbl_jobcard.issueqty, 0) ELSE 0 END) AS issueqty');
                $this->db->from('tbl_customerinquiry_detail');
                $this->db->join('tbl_customerinquiry', 'tbl_customerinquiry.idtbl_customerinquiry = tbl_customerinquiry_detail.tbl_customerinquiry_idtbl_customerinquiry', 'left');
                $this->db->join('tbl_jobcard', 'tbl_jobcard.tbl_customerinquiry_idtbl_customerinquiry = tbl_customerinquiry_detail.tbl_customerinquiry_idtbl_customerinquiry', 'left');
                $this->db->where('tbl_customerinquiry.tbl_customer_idtbl_customer', $customerid);
                $this->db->where('tbl_customerinquiry.status', 1);
                $this->db->where('tbl_customerinquiry.approvestatus', 1);
                $this->db->where('tbl_customerinquiry_detail.job_finish_status', 0);
                $this->db->group_by("tbl_customerinquiry_detail.idtbl_customerinquiry_detail");
                $this->db->limit(5);
                $respond=$this->db->get();         
            }
        }
        
        $data=array();
        
        foreach ($respond->result() as $row) {
            $data[]=array("id"=>$row->idtbl_customerinquiry, "text"=>$row->job_no.' '.$row->job, "qty" => $row->qty, "issueqty" => $row->issueqty);
        }   
        echo json_encode($data);
    }
    public function GetBomInfoAccoJobId(){
        $recordID = $this->input->post('recordID');

        $this->db->select('idtbl_jobcard_bom, jobbomname');
        $this->db->from('tbl_jobcard_bom');
        $this->db->join('tbl_customerinquiry_detail', 'tbl_customerinquiry_detail.job_id = tbl_jobcard_bom.tbl_customer_job_details_idtbl_customer_job_details', 'left');
        $this->db->where('tbl_jobcard_bom.status', 1);
        $this->db->where('tbl_customerinquiry_detail.tbl_customerinquiry_idtbl_customerinquiry', $recordID);
        
        $respond=$this->db->get();

        echo json_encode($respond->result());
    }
    public function CheckBomMaterialInfo(){
        $cusinquiryid = $this->input->post('cusinquiryid');
        $inquiryqty = $this->input->post('inquiryqty');
        $issueqty = $this->input->post('issueqty');
        $bominfo = $this->input->post('bominfo');
        $section = $this->input->post('section');
        $html='';
        $warningstockstatus=0;
        $warningstocktext='';

        //Material Section
        if($section==1){
            $this->db->select('tbl_jobcard_bom_material.sheetqty, tbl_jobcard_bom_material.wastage, tbl_jobcard_bom_material.tbl_print_material_info_idtbl_print_material_info, tbl_print_material_info.materialname, tbl_jobcard_bom_material.cutsize, SUM(tbl_print_stock.qty) AS `totqty`');
            $this->db->from('tbl_jobcard_bom_material');
            $this->db->join('tbl_print_stock', 'tbl_print_stock.tbl_print_material_info_idtbl_print_material_info = tbl_jobcard_bom_material.tbl_print_material_info_idtbl_print_material_info', 'left');
            $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_bom_material.tbl_print_material_info_idtbl_print_material_info', 'left');
            $this->db->where('tbl_jobcard_bom_material.status', 1);
            $this->db->where('tbl_jobcard_bom_material.tbl_jobcard_bom_idtbl_jobcard_bom', $bominfo);
            $this->db->group_by("tbl_jobcard_bom_material.tbl_print_material_info_idtbl_print_material_info");

            $respondmaterial=$this->db->get();

            if($respondmaterial->num_rows()>0){
                $html.='
                <tr>
                    <th colspan="4">Material Section</th>
                </tr>
                ';
                foreach($respondmaterial->result() as $rowmaterial){
                    $wastagepre = (100 + $rowmaterial->wastage)/100;
                    $requiredQtyWithWastage = ceil((($rowmaterial->sheetqty * $issueqty) / $rowmaterial->cutsize) * $wastagepre);

                    $html.='
                    <tr>
                        <td class="d-none">1</td>
                        <td>'.$rowmaterial->materialname.'</td>
                        <td class="text-center">'.$rowmaterial->sheetqty.'</td>
                        <td class="text-center">'.$requiredQtyWithWastage.'</td>
                        <td class="batchnolist"></td>
                        <td class="d-none">'.$rowmaterial->tbl_print_material_info_idtbl_print_material_info.'</td>
                        <td class="d-none">'.$issueqty.'</td>
                    </tr>
                    ';

                    if($requiredQtyWithWastage > $rowmaterial->totqty){$warningstockstatus=1;$warningstocktext.=$rowmaterial->materialname.', ';}
                }
            }
        }

        //Coating Section
        if($section==2){
            $this->db->select('tbl_jobcard_bom_varnish.varnishQty, tbl_jobcard_bom_varnish.tbl_print_material_info_idtbl_print_material_info, tbl_print_material_info.materialname, SUM(tbl_print_stock.qty) AS `totqty`');
            $this->db->from('tbl_jobcard_bom_varnish');
            $this->db->join('tbl_print_stock', 'tbl_print_stock.tbl_print_material_info_idtbl_print_material_info = tbl_jobcard_bom_varnish.tbl_print_material_info_idtbl_print_material_info', 'left');
            $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_bom_varnish.tbl_print_material_info_idtbl_print_material_info', 'left');
            $this->db->where('tbl_jobcard_bom_varnish.status', 1);
            $this->db->where('tbl_jobcard_bom_varnish.tbl_jobcard_bom_idtbl_jobcard_bom', $bominfo);
            $this->db->group_by("tbl_jobcard_bom_varnish.tbl_print_material_info_idtbl_print_material_info");

            $respondcoating=$this->db->get();

            if($respondcoating->num_rows()>0){
                $html.='
                <tr>
                    <th colspan="4">Coating Section</th>
                </tr>
                ';
                foreach($respondcoating->result() as $rowcoating){
                    $html.='
                    <tr>
                        <td class="d-none">2</td>
                        <td>'.$rowcoating->materialname.'</td>
                        <td class="text-center">'.$rowcoating->varnishQty.'</td>
                        <td class="text-center">'.ceil($rowcoating->varnishQty*$issueqty).'</td>
                        <td class="batchnolist"></td>
                        <td class="d-none">'.$rowcoating->tbl_print_material_info_idtbl_print_material_info.'</td>
                        <td class="d-none">'.$issueqty.'</td>
                    </tr>
                    ';

                    if(($rowcoating->varnishQty*$issueqty) > $rowcoating->totqty){$warningstockstatus=1;$warningstocktext.=$rowcoating->materialname.', ';}
                }
            }
        }

        //Color Section
        if($section==3){
            $this->db->select('tbl_jobcard_bom_color.qty, tbl_jobcard_bom_color.tbl_print_material_info_idtbl_print_material_info, tbl_print_material_info.materialname, SUM(tbl_print_stock.qty) AS `totqty`');
            $this->db->from('tbl_jobcard_bom_color');
            $this->db->join('tbl_print_stock', 'tbl_print_stock.tbl_print_material_info_idtbl_print_material_info = tbl_jobcard_bom_color.tbl_print_material_info_idtbl_print_material_info', 'left');
            $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_bom_color.tbl_print_material_info_idtbl_print_material_info', 'left');
            $this->db->where('tbl_jobcard_bom_color.status', 1);
            $this->db->where('tbl_jobcard_bom_color.tbl_jobcard_bom_idtbl_jobcard_bom', $bominfo);
            $this->db->group_by("tbl_jobcard_bom_color.tbl_print_material_info_idtbl_print_material_info");

            $respondcolor=$this->db->get();

            if($respondcolor->num_rows()>0){
                $html.='
                <tr>
                    <th colspan="4">Color Section</th>
                </tr>
                ';
                foreach($respondcolor->result() as $rowcolor){
                    $html.='
                    <tr>
                        <td class="d-none">3</td>
                        <td>'.$rowcolor->materialname.'</td>
                        <td class="text-center">'.$rowcolor->qty.'</td>
                        <td class="text-center">'.ceil($rowcolor->qty*$issueqty).'</td>
                        <td class="batchnolist"></td>
                        <td class="d-none">'.$rowcolor->tbl_print_material_info_idtbl_print_material_info.'</td>
                        <td class="d-none">'.$issueqty.'</td>
                    </tr>
                    ';

                    if(($rowcolor->qty*$issueqty) > $rowcolor->totqty){$warningstockstatus=1;$warningstocktext.=$rowcolor->materialname.', ';}
                }
            }
        }

        //Lamination Section
        if($section==4){
            $this->db->select('tbl_jobcard_bom_lamination.lamination_qty, tbl_jobcard_bom_lamination.tbl_print_material_info_idtbl_print_material_info, tbl_print_material_info.materialname, SUM(tbl_print_stock.qty) AS `totqty`');
            $this->db->from('tbl_jobcard_bom_lamination');
            $this->db->join('tbl_print_stock', 'tbl_print_stock.tbl_print_material_info_idtbl_print_material_info = tbl_jobcard_bom_lamination.tbl_print_material_info_idtbl_print_material_info', 'left');
            $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_bom_lamination.tbl_print_material_info_idtbl_print_material_info', 'left');
            $this->db->where('tbl_jobcard_bom_lamination.status', 1);
            $this->db->where('tbl_jobcard_bom_lamination.tbl_jobcard_bom_idtbl_jobcard_bom', $bominfo);
            $this->db->group_by("tbl_jobcard_bom_lamination.tbl_print_material_info_idtbl_print_material_info");

            $respondlamination=$this->db->get();

            if($respondlamination->num_rows()>0){
                $html.='
                <tr>
                    <th colspan="4">Lamination Section</th>
                </tr>
                ';
                foreach($respondlamination->result() as $rowlamination){
                    $html.='
                    <tr>
                        <td class="d-none">4</td>
                        <td>'.$rowlamination->materialname.'</td>
                        <td class="text-center">'.$rowlamination->lamination_qty.'</td>
                        <td class="text-center">'.ceil($rowlamination->lamination_qty*$issueqty).'</td>
                        <td class="batchnolist"></td>
                        <td class="d-none">'.$rowlamination->tbl_print_material_info_idtbl_print_material_info.'</td>
                        <td class="d-none">'.$issueqty.'</td>
                    </tr>
                    ';

                    if(($rowlamination->lamination_qty*$issueqty) > $rowlamination->totqty){$warningstockstatus=1;$warningstocktext.=$rowlamination->materialname.', ';}
                }
            }
        }

        //Rimming Section
        if($section==5){
            $this->db->select('tbl_jobcard_bom_rimming.qty, tbl_jobcard_bom_rimming.tbl_print_material_info_idtbl_print_material_info, tbl_print_material_info.materialname, SUM(tbl_print_stock.qty) AS `totqty`');
            $this->db->from('tbl_jobcard_bom_rimming');
            $this->db->join('tbl_print_stock', 'tbl_print_stock.tbl_print_material_info_idtbl_print_material_info = tbl_jobcard_bom_rimming.tbl_print_material_info_idtbl_print_material_info', 'left');
            $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_bom_rimming.tbl_print_material_info_idtbl_print_material_info', 'left');
            $this->db->where('tbl_jobcard_bom_rimming.status', 1);
            $this->db->where('tbl_jobcard_bom_rimming.tbl_jobcard_bom_idtbl_jobcard_bom', $bominfo);
            $this->db->group_by("tbl_jobcard_bom_rimming.tbl_print_material_info_idtbl_print_material_info");

            $respondrimming=$this->db->get();

            if($respondrimming->num_rows()>0){
                $html.='
                <tr>
                    <th colspan="4">Rimming Section</th>
                </tr>
                ';
                foreach($respondrimming->result() as $rowrimming){
                    $html.='
                    <tr>
                        <td class="d-none">5</td>
                        <td>'.$rowrimming->materialname.'</td>
                        <td class="text-center">'.$rowrimming->qty.'</td>
                        <td class="text-center">'.ceil($rowrimming->qty*$issueqty).'</td>
                        <td class="batchnolist"></td>
                        <td class="d-none">'.$rowrimming->tbl_print_material_info_idtbl_print_material_info.'</td>
                        <td class="d-none">'.$issueqty.'</td>
                    </tr>
                    ';

                    if(($rowrimming->qty*$issueqty) > $rowrimming->totqty){$warningstockstatus=1;$warningstocktext.='Rimming Section, ';}
                }
            }
        }

        //Other Section
        if($section==7){
            $this->db->select('tbl_jobcard_bom_other.qty, tbl_jobcard_bom_other.tbl_print_material_info_idtbl_print_material_info, tbl_print_material_info.materialname, SUM(tbl_print_stock.qty) AS `totqty`');
            $this->db->from('tbl_jobcard_bom_other');
            $this->db->join('tbl_print_stock', 'tbl_print_stock.tbl_print_material_info_idtbl_print_material_info = tbl_jobcard_bom_other.tbl_print_material_info_idtbl_print_material_info', 'left');
            $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_bom_other.tbl_print_material_info_idtbl_print_material_info', 'left');
            $this->db->where('tbl_jobcard_bom_other.status', 1);
            $this->db->where('tbl_jobcard_bom_other.tbl_jobcard_bom_idtbl_jobcard_bom', $bominfo);
            $this->db->group_by("tbl_jobcard_bom_other.tbl_print_material_info_idtbl_print_material_info");

            $respondother=$this->db->get();

            if($respondother->num_rows()>0){
                $html.='
                <tr>
                    <th colspan="4">Lamination Section</th>
                </tr>
                ';
                foreach($respondother->result() as $rowother){
                    $html.='
                    <tr>
                        <td class="d-none">7</td>
                        <td>'.$rowother->materialname.'</td>
                        <td class="text-center">'.$rowother->qty.'</td>
                        <td class="text-center">'.ceil($rowother->qty*$issueqty).'</td>
                        <td class="batchnolist"></td>
                        <td class="d-none">'.$rowother->tbl_print_material_info_idtbl_print_material_info.'</td>
                        <td class="d-none">'.$issueqty.'</td>
                    </tr>
                    ';

                    if(($rowother->qty*$issueqty) > $rowother->totqty){$warningstockstatus=1;$warningstocktext.=$rowother->materialname.', ';}
                }
            }
        }

        $obj=new stdClass();
        $obj->tabledata=$html;
        $obj->warnstatus=$warningstockstatus;
        $obj->warntext=$warningstocktext;

        echo json_encode($obj);
    }
    public function Getbatchnolistaccomaterial(){
        $materialID=$this->input->post('materialID');
        $companyID=$_SESSION['company_id'];
        $branchID=$_SESSION['branch_id'];

        $this->db->select('`batchno`, `qty`, `unitprice`');
        $this->db->from('tbl_print_stock');
        $this->db->where('status', 1);
        $this->db->where('qty >', 0);
        $this->db->where('tbl_print_material_info_idtbl_print_material_info', $materialID);
        $this->db->where('tbl_company_idtbl_company', $companyID);
        $this->db->where('tbl_company_branch_idtbl_company_branch', $branchID);

        $respond=$this->db->get();

        echo json_encode($respond->result());
    }
    public function Issuematerialinsertupdate(){
        $this->db->trans_begin();

        $customer=$this->input->post('customer');
        $cusinquiry=$this->input->post('cusinquiry');
        $bominfo=$this->input->post('bominfo');
        $issueqty=$this->input->post('issueqty');
        $tableData=$this->input->post('tableData');
        
        $companyID=$_SESSION['company_id'];
        $branchID=$_SESSION['branch_id'];
        $userID=$_SESSION['userid'];

        $updatedatetime=date('Y-m-d H:i:s');
        $today=date('Y-m-d');

        $this->db->select('`idtbl_jobcard`');
        $this->db->from('tbl_jobcard');
        $this->db->where('tbl_customerinquiry_idtbl_customerinquiry', $cusinquiry);
        $this->db->where('tbl_company_idtbl_company', $companyID);
        $this->db->where('tbl_company_branch_idtbl_company_branch', $branchID);

        $respondcheckjobcard=$this->db->get();

        if(empty($respondcheckjobcard->row(0)->idtbl_jobcard)){
            $this->db->select('COUNT(`idtbl_jobcard`) AS `count`');
            $this->db->from('tbl_jobcard');
            $this->db->where('tbl_company_idtbl_company', $companyID);
            $this->db->where('tbl_company_branch_idtbl_company_branch', $branchID);

            $respond=$this->db->get();

            $this->db->select('`job`, `job_no`');
            $this->db->from('tbl_customerinquiry_detail');
            $this->db->where('tbl_customerinquiry_idtbl_customerinquiry', $cusinquiry);

            $respondjobinfo=$this->db->get();
            
            $jobdesc=$respondjobinfo->row(0)->job.' '.$respondjobinfo->row(0)->job_no;

            if($respond->num_rows()==0){$jobcardno=date('Ym').'1';}
            else{$jobcardno=date('Ym').($respond->row(0)->count+1);}

            $data = array(
                'jobcardno'=> $jobcardno,
                'job_description'=> $jobdesc,
                'date'=> $today,
                'docno'=> '',
                'issueqty'=> $issueqty,
                'status'=> '1',
                'insertdatetime'=> $updatedatetime,
                'tbl_user_idtbl_user'=> $userID,
                'tbl_customerinquiry_idtbl_customerinquiry'=> $cusinquiry,
                'tbl_jobcard_bom_idtbl_jobcard_bom'=> $bominfo,
                'tbl_company_idtbl_company'=> $companyID,
                'tbl_company_branch_idtbl_company_branch'=> $branchID,
                'tbl_customer_idtbl_customer'=> $customer
            );

            $this->db->insert('tbl_jobcard', $data);

            $jobCardID=$this->db->insert_id();
        }
        else{
            $jobCardID = $respondcheckjobcard->row(0)->idtbl_jobcard;

            $data = array(
                'approvestatus'=> '0',
                'issuematerialstatus'=> '0',
                'check_by'=> '0',
                'updatedatetime'=> $updatedatetime
            );
            $this->db->where('idtbl_jobcard', $jobCardID);
			$this->db->update('tbl_jobcard', $data);            
        }

        foreach($tableData as $rowdatalist){
            $type=$rowdatalist['col_1'];
            $materialname=$rowdatalist['col_2'];
            $bomqty=$rowdatalist['col_3'];
            $issueqtydata=$rowdatalist['col_4'];
            $batchnolist=$rowdatalist['col_5'];
            $materialID=$rowdatalist['col_6'];
            $reqissueqty=$rowdatalist['col_7'];

            if($type==1){//Material Section
                $this->db->select('`cutsize`, `sheetqty`, `tbl_printing_format_idtbl_printing_format`');
                $this->db->from('tbl_jobcard_bom_material');
                $this->db->where('tbl_print_material_info_idtbl_print_material_info', $materialID);
                $this->db->where('tbl_jobcard_bom_idtbl_jobcard_bom', $bominfo);

                $respondbommateinfo=$this->db->get();
                
                $datamaterial = array(
                    'cutsize'=> $respondbommateinfo->row(0)->cutsize, 
                    'sheetqty'=> $respondbommateinfo->row(0)->sheetqty, 
                    'batchno'=> $batchnolist, 
                    'issueqty'=> $issueqtydata, 
                    'status'=> '1', 
                    'insertdatetime'=> $updatedatetime, 
                    'tbl_user_idtbl_user'=> $userID, 
                    'tbl_printing_format_idtbl_printing_format'=> $respondbommateinfo->row(0)->tbl_printing_format_idtbl_printing_format, 
                    'tbl_print_material_info_idtbl_print_material_info'=> $materialID, 
                    'tbl_jobcard_idtbl_jobcard'=> $jobCardID
                );
       
                $this->db->insert('tbl_jobcard_material', $datamaterial);

                $jobcardotherID=$this->db->insert_id();

                $explodebatch=explode(',', $batchnolist);

                $balqty=$issueqtydata;

                foreach($explodebatch as $rowbatchno){
                    $this->db->select('`batchno`, `qty`, `unitprice`');
                    $this->db->from('tbl_print_stock');
                    $this->db->where('tbl_print_material_info_idtbl_print_material_info', $materialID);
                    $this->db->where('batchno', $rowbatchno);
                    $this->db->where('tbl_company_idtbl_company', $companyID);
                    $this->db->where('tbl_company_branch_idtbl_company_branch', $branchID);
                    $this->db->where('status', 1);

                    $respondstock=$this->db->get();

                    if($balqty>0){
                        if($respondstock->row(0)->qty>=$balqty){
                            $issueqty=$balqty;
                            $balqty=0;
                        }
                        else{
                            $balqty=$balqty-$respondstock->row(0)->qty;
                            $issueqty=$respondstock->row(0)->qty;
                        }

                        $datamaterialissue = array(
                            'sectiontype'=> $type, 
                            'issuedate'=> $today, 
                            'batchno'=> $rowbatchno, 
                            'reqissueqty'=> $reqissueqty, 
                            'issueqty'=> $issueqty, 
                            'unitprice'=> $respondstock->row(0)->unitprice, 
                            'status'=> '1', 
                            'insertdatetime'=> $updatedatetime, 
                            'tbl_user_idtbl_user'=> $userID, 
                            'tbl_jobcard_idtbl_jobcard'=> $jobCardID, 
                            'tbl_print_material_info_idtbl_print_material_info'=> $materialID,
                            'jobcard_other_id'=> $jobcardotherID
                        );
            
                        $this->db->insert('tbl_jobcard_issue_meterial', $datamaterialissue);

                        // //Stock Update Query
                        // $this->db->where('batchno', $rowbatchno);
                        // $this->db->where('tbl_print_material_info_idtbl_print_material_info', $materialID);
                        // $this->db->where('tbl_company_idtbl_company', $companyID);
                        // $this->db->where('tbl_company_branch_idtbl_company_branch', $branchID);

                        // $this->db->set('qty', 'qty - '.$issueqty, false);
                        // $this->db->update('tbl_print_stock');
                    }
                }
            }
            if($type==2){//Coating Section
                $this->db->select('`varnishQty`, `tbl_varnish_idtbl_varnish`');
                $this->db->from('tbl_jobcard_bom_varnish');
                $this->db->where('tbl_print_material_info_idtbl_print_material_info', $materialID);
                $this->db->where('tbl_jobcard_bom_idtbl_jobcard_bom', $bominfo);

                $respondbomvarnishinfo=$this->db->get();
                
                $datavarnish = array(
                    'varnishQty'=> $respondbomvarnishinfo->row(0)->varnishQty, 
                    'batchno'=> $batchnolist, 
                    'issueqty'=> $issueqtydata, 
                    'status'=> '1', 
                    'insertdatetime'=> $updatedatetime, 
                    'tbl_user_idtbl_user'=> $userID, 
                    'tbl_print_material_info_idtbl_print_material_info'=> $materialID, 
                    'tbl_varnish_idtbl_varnish'=> $respondbomvarnishinfo->row(0)->tbl_varnish_idtbl_varnish, 
                    'tbl_jobcard_idtbl_jobcard'=> $jobCardID
                );
       
                $this->db->insert('tbl_jobcard_varnish', $datavarnish);

                $jobcardotherID=$this->db->insert_id();

                $explodebatch=explode(',', $batchnolist);

                $balqty=$issueqtydata;

                foreach($explodebatch as $rowbatchno){
                    $this->db->select('`batchno`, `qty`, `unitprice`');
                    $this->db->from('tbl_print_stock');
                    $this->db->where('tbl_print_material_info_idtbl_print_material_info', $materialID);
                    $this->db->where('batchno', $rowbatchno);
                    $this->db->where('tbl_company_idtbl_company', $companyID);
                    $this->db->where('tbl_company_branch_idtbl_company_branch', $branchID);
                    $this->db->where('status', 1);

                    $respondstock=$this->db->get();

                    if($balqty>0){
                        if($respondstock->row(0)->qty>=$balqty){
                            $issueqty=$balqty;
                            $balqty=0;
                        }
                        else{
                            $balqty=$balqty-$respondstock->row(0)->qty;
                            $issueqty=$respondstock->row(0)->qty;
                        }

                        $datamaterialissue = array(
                            'sectiontype'=> $type, 
                            'issuedate'=> $today, 
                            'batchno'=> $rowbatchno, 
                            'reqissueqty'=> $reqissueqty,
                            'issueqty'=> $issueqty, 
                            'unitprice'=> $respondstock->row(0)->unitprice, 
                            'status'=> '1', 
                            'insertdatetime'=> $updatedatetime, 
                            'tbl_user_idtbl_user'=> $userID, 
                            'tbl_jobcard_idtbl_jobcard'=> $jobCardID, 
                            'tbl_print_material_info_idtbl_print_material_info'=> $materialID,
                            'jobcard_other_id'=> $jobcardotherID
                        );
            
                        $this->db->insert('tbl_jobcard_issue_meterial', $datamaterialissue);

                        // //Stock Update Query
                        // $this->db->where('batchno', $rowbatchno);
                        // $this->db->where('tbl_print_material_info_idtbl_print_material_info', $materialID);
                        // $this->db->where('tbl_company_idtbl_company', $companyID);
                        // $this->db->where('tbl_company_branch_idtbl_company_branch', $branchID);

                        // $this->db->set('qty', 'qty - '.$issueqty, false);
                        // $this->db->update('tbl_print_stock');
                    }
                }
            }
            if($type==3){//Color Section
                $this->db->select('`qty`, `cmyk`, `metlic`, `anyother`, `remark`');
                $this->db->from('tbl_jobcard_bom_color');
                $this->db->where('tbl_print_material_info_idtbl_print_material_info', $materialID);
                $this->db->where('tbl_jobcard_bom_idtbl_jobcard_bom', $bominfo);

                $respondbomcolorinfo=$this->db->get();
                
                $datacolor = array(
                    'cmyk'=> $respondbomcolorinfo->row(0)->cmyk, 
                    'metlic'=> $respondbomcolorinfo->row(0)->metlic, 
                    'another'=> $respondbomcolorinfo->row(0)->anyother, 
                    'remark'=> $respondbomcolorinfo->row(0)->remark, 
                    'qty'=> $respondbomcolorinfo->row(0)->qty, 
                    'batchno'=> $batchnolist, 
                    'issueqty'=> $issueqtydata, 
                    'status'=> '1', 
                    'insertdatetime'=> $updatedatetime, 
                    'tbl_user_idtbl_user'=> $userID, 
                    'tbl_jobcard_idtbl_jobcard'=> $jobCardID, 
                    'tbl_print_material_info_idtbl_print_material_info'=> $materialID
                );
       
                $this->db->insert('tbl_jobcard_color', $datacolor);

                $jobcardotherID=$this->db->insert_id();

                $explodebatch=explode(',', $batchnolist);

                $balqty=$issueqtydata;

                foreach($explodebatch as $rowbatchno){
                    $this->db->select('`batchno`, `qty`, `unitprice`');
                    $this->db->from('tbl_print_stock');
                    $this->db->where('tbl_print_material_info_idtbl_print_material_info', $materialID);
                    $this->db->where('batchno', $rowbatchno);
                    $this->db->where('tbl_company_idtbl_company', $companyID);
                    $this->db->where('tbl_company_branch_idtbl_company_branch', $branchID);
                    $this->db->where('status', 1);

                    $respondstock=$this->db->get();

                    if($balqty>0){
                        if($respondstock->row(0)->qty>=$balqty){
                            $issueqty=$balqty;
                            $balqty=0;
                        }
                        else{
                            $balqty=$balqty-$respondstock->row(0)->qty;
                            $issueqty=$respondstock->row(0)->qty;
                        }

                        $datamaterialissue = array(
                            'sectiontype'=> $type, 
                            'issuedate'=> $today, 
                            'batchno'=> $rowbatchno, 
                            'reqissueqty'=> $reqissueqty,
                            'issueqty'=> $issueqty, 
                            'unitprice'=> $respondstock->row(0)->unitprice, 
                            'status'=> '1', 
                            'insertdatetime'=> $updatedatetime, 
                            'tbl_user_idtbl_user'=> $userID, 
                            'tbl_jobcard_idtbl_jobcard'=> $jobCardID, 
                            'tbl_print_material_info_idtbl_print_material_info'=> $materialID,
                            'jobcard_other_id'=> $jobcardotherID
                        );
            
                        $this->db->insert('tbl_jobcard_issue_meterial', $datamaterialissue);

                        // //Stock Update Query
                        // $this->db->where('batchno', $rowbatchno);
                        // $this->db->where('tbl_print_material_info_idtbl_print_material_info', $materialID);
                        // $this->db->where('tbl_company_idtbl_company', $companyID);
                        // $this->db->where('tbl_company_branch_idtbl_company_branch', $branchID);

                        // $this->db->set('qty', 'qty - '.$issueqty, false);
                        // $this->db->update('tbl_print_stock');
                    }
                }
            }
            if($type==4){//Lamination Section
                $this->db->select('`sides`, `filmsize`, `micron`, `lamination_qty`, `tbl_lamination_idtbl_lamination`');
                $this->db->from('tbl_jobcard_bom_lamination');
                $this->db->where('tbl_print_material_info_idtbl_print_material_info', $materialID);
                $this->db->where('tbl_jobcard_bom_idtbl_jobcard_bom', $bominfo);

                $respondbomlamination=$this->db->get();
                
                $datalamination = array(
                    'sides'=> $respondbomlamination->row(0)->sides, 
                    'filmsize'=> $respondbomlamination->row(0)->filmsize, 
                    'micron'=> $respondbomlamination->row(0)->micron, 
                    'lamination_qty'=> $respondbomlamination->row(0)->lamination_qty, 
                    'batchno'=> $batchnolist, 
                    'issueqty'=> $issueqtydata, 
                    'status'=> '1', 
                    'insertdatetime'=> $updatedatetime, 
                    'tbl_user_idtbl_user'=> $userID, 
                    'tbl_print_material_info_idtbl_print_material_info'=> $materialID, 
                    'tbl_lamination_idtbl_lamination'=> $respondbomlamination->row(0)->tbl_lamination_idtbl_lamination, 
                    'tbl_jobcard_idtbl_jobcard'=> $jobCardID
                );
       
                $this->db->insert('tbl_jobcard_lamination', $datalamination);

                $jobcardotherID=$this->db->insert_id();

                $explodebatch=explode(',', $batchnolist);

                $balqty=$issueqtydata;

                foreach($explodebatch as $rowbatchno){
                    $this->db->select('`batchno`, `qty`, `unitprice`');
                    $this->db->from('tbl_print_stock');
                    $this->db->where('tbl_print_material_info_idtbl_print_material_info', $materialID);
                    $this->db->where('batchno', $rowbatchno);
                    $this->db->where('tbl_company_idtbl_company', $companyID);
                    $this->db->where('tbl_company_branch_idtbl_company_branch', $branchID);
                    $this->db->where('status', 1);

                    $respondstock=$this->db->get();

                    if($balqty>0){
                        if($respondstock->row(0)->qty>=$balqty){
                            $issueqty=$balqty;
                            $balqty=0;
                        }
                        else{
                            $balqty=$balqty-$respondstock->row(0)->qty;
                            $issueqty=$respondstock->row(0)->qty;
                        }

                        $datamaterialissue = array(
                            'sectiontype'=> $type, 
                            'issuedate'=> $today, 
                            'batchno'=> $rowbatchno, 
                            'reqissueqty'=> $reqissueqty,
                            'issueqty'=> $issueqty, 
                            'unitprice'=> $respondstock->row(0)->unitprice, 
                            'status'=> '1', 
                            'insertdatetime'=> $updatedatetime, 
                            'tbl_user_idtbl_user'=> $userID, 
                            'tbl_jobcard_idtbl_jobcard'=> $jobCardID, 
                            'tbl_print_material_info_idtbl_print_material_info'=> $materialID,
                            'jobcard_other_id'=> $jobcardotherID
                        );
            
                        $this->db->insert('tbl_jobcard_issue_meterial', $datamaterialissue);

                        // //Stock Update Query
                        // $this->db->where('batchno', $rowbatchno);
                        // $this->db->where('tbl_print_material_info_idtbl_print_material_info', $materialID);
                        // $this->db->where('tbl_company_idtbl_company', $companyID);
                        // $this->db->where('tbl_company_branch_idtbl_company_branch', $branchID);

                        // $this->db->set('qty', 'qty - '.$issueqty, false);
                        // $this->db->update('tbl_print_stock');
                    }
                }
            }
            if($type==5){//Rimming Section
                $this->db->select('`sides`, `length`, `qty`, `tbl_rimming_idtbl_rimming`');
                $this->db->from('tbl_jobcard_bom_rimming');
                $this->db->where('tbl_print_material_info_idtbl_print_material_info', $materialID);
                $this->db->where('tbl_jobcard_bom_idtbl_jobcard_bom', $bominfo);

                $respondbomrimming=$this->db->get();
                
                $datarimming = array(
                    'sides'=> $respondbomrimming->row(0)->sides, 
                    'length'=> $respondbomrimming->row(0)->length, 
                    'qty'=> $respondbomrimming->row(0)->qty, 
                    'batchno'=> $batchnolist, 
                    'issueqty'=> $issueqtydata, 
                    'status'=> '1', 
                    'insertdatetime'=> $updatedatetime, 
                    'tbl_user_idtbl_user'=> $userID, 
                    'tbl_print_material_info_idtbl_print_material_info'=> $materialID, 
                    'tbl_rimming_idtbl_rimming'=> $respondbomrimming->row(0)->tbl_rimming_idtbl_rimming, 
                    'tbl_jobcard_idtbl_jobcard'=> $jobCardID
                );
       
                $this->db->insert('tbl_jobcard_rimming', $datarimming);

                $jobcardotherID=$this->db->insert_id();

                $explodebatch=explode(',', $batchnolist);

                $balqty=$issueqtydata;

                foreach($explodebatch as $rowbatchno){
                    $this->db->select('`batchno`, `qty`, `unitprice`');
                    $this->db->from('tbl_print_stock');
                    $this->db->where('tbl_print_material_info_idtbl_print_material_info', $materialID);
                    $this->db->where('batchno', $rowbatchno);
                    $this->db->where('tbl_company_idtbl_company', $companyID);
                    $this->db->where('tbl_company_branch_idtbl_company_branch', $branchID);
                    $this->db->where('status', 1);

                    $respondstock=$this->db->get();

                    if($balqty>0){
                        if($respondstock->row(0)->qty>=$balqty){
                            $issueqty=$balqty;
                            $balqty=0;
                        }
                        else{
                            $balqty=$balqty-$respondstock->row(0)->qty;
                            $issueqty=$respondstock->row(0)->qty;
                        }

                        $datamaterialissue = array(
                            'sectiontype'=> $type, 
                            'issuedate'=> $today, 
                            'batchno'=> $rowbatchno, 
                            'reqissueqty'=> $reqissueqty,
                            'issueqty'=> $issueqty, 
                            'unitprice'=> $respondstock->row(0)->unitprice, 
                            'status'=> '1', 
                            'insertdatetime'=> $updatedatetime, 
                            'tbl_user_idtbl_user'=> $userID, 
                            'tbl_jobcard_idtbl_jobcard'=> $jobCardID, 
                            'tbl_print_material_info_idtbl_print_material_info'=> $materialID,
                            'jobcard_other_id'=> $jobcardotherID
                        );
            
                        $this->db->insert('tbl_jobcard_issue_meterial', $datamaterialissue);

                        // //Stock Update Query
                        // $this->db->where('batchno', $rowbatchno);
                        // $this->db->where('tbl_print_material_info_idtbl_print_material_info', $materialID);
                        // $this->db->where('tbl_company_idtbl_company', $companyID);
                        // $this->db->where('tbl_company_branch_idtbl_company_branch', $branchID);

                        // $this->db->set('qty', 'qty - '.$issueqty, false);
                        // $this->db->update('tbl_print_stock');
                    }
                }
            }
            if($type==7){//Other Section
                $this->db->select('`qty`');
                $this->db->from('tbl_jobcard_bom_other');
                $this->db->where('tbl_print_material_info_idtbl_print_material_info', $materialID);
                $this->db->where('tbl_jobcard_bom_idtbl_jobcard_bom', $bominfo);

                $respondbomother=$this->db->get();
                
                $dataother = array(
                    'qty'=> $respondbomother->row(0)->qty, 
                    'batchno'=> $batchnolist, 
                    'issueqty'=> $issueqtydata, 
                    'status'=> '1', 
                    'insertdatetime'=> $updatedatetime, 
                    'tbl_user_idtbl_user'=> $userID, 
                    'tbl_print_material_info_idtbl_print_material_info'=> $materialID, 
                    'tbl_jobcard_idtbl_jobcard'=> $jobCardID
                );
       
                $this->db->insert('tbl_jobcard_other', $dataother);

                $jobcardotherID=$this->db->insert_id();

                $explodebatch=explode(',', $batchnolist);

                $balqty=$issueqtydata;

                foreach($explodebatch as $rowbatchno){
                    $this->db->select('`batchno`, `qty`, `unitprice`');
                    $this->db->from('tbl_print_stock');
                    $this->db->where('tbl_print_material_info_idtbl_print_material_info', $materialID);
                    $this->db->where('batchno', $rowbatchno);
                    $this->db->where('tbl_company_idtbl_company', $companyID);
                    $this->db->where('tbl_company_branch_idtbl_company_branch', $branchID);
                    $this->db->where('status', 1);

                    $respondstock=$this->db->get();

                    if($balqty>0){
                        if($respondstock->row(0)->qty>=$balqty){
                            $issueqty=$balqty;
                            $balqty=0;
                        }
                        else{
                            $balqty=$balqty-$respondstock->row(0)->qty;
                            $issueqty=$respondstock->row(0)->qty;
                        }

                        $datamaterialissue = array(
                            'sectiontype'=> $type, 
                            'issuedate'=> $today, 
                            'batchno'=> $rowbatchno, 
                            'reqissueqty'=> $reqissueqty,
                            'issueqty'=> $issueqty, 
                            'unitprice'=> $respondstock->row(0)->unitprice, 
                            'status'=> '1', 
                            'insertdatetime'=> $updatedatetime, 
                            'tbl_user_idtbl_user'=> $userID, 
                            'tbl_jobcard_idtbl_jobcard'=> $jobCardID, 
                            'tbl_print_material_info_idtbl_print_material_info'=> $materialID,
                            'jobcard_other_id'=> $jobcardotherID
                        );
            
                        $this->db->insert('tbl_jobcard_issue_meterial', $datamaterialissue);

                        // //Stock Update Query
                        // $this->db->where('batchno', $rowbatchno);
                        // $this->db->where('tbl_print_material_info_idtbl_print_material_info', $materialID);
                        // $this->db->where('tbl_company_idtbl_company', $companyID);
                        // $this->db->where('tbl_company_branch_idtbl_company_branch', $branchID);

                        // $this->db->set('qty', 'qty - '.$issueqty, false);
                        // $this->db->update('tbl_print_stock');
                    }
                }
            }
        }

        //Diecutting Section
        $this->db->select('COUNT(*) AS `count`');
        $this->db->from('tbl_jobcard_diecutting');
        $this->db->where('tbl_jobcard_idtbl_jobcard', $jobCardID);
        $this->db->where('status', '1');

        $respondcheckdiecut=$this->db->get();

        if($respondcheckdiecut->row(0)->count==0){
            $this->db->select("`peraforation`, `halfCutting`, `fullCutting`, `qty`, 1 AS `status`, '$updatedatetime' AS `insertdatetime`, '$userID' AS `tbl_user_idtbl_user`, '$jobCardID' AS `tbl_jobcard_idtbl_jobcard`");
            $this->db->from('tbl_jobcard_bom_diecutting');
            $this->db->where('status', 1);
            $this->db->where('tbl_jobcard_bom_idtbl_jobcard_bom', $bominfo);
            
            $responddiecut = $this->db->get();

            if ($responddiecut->num_rows() > 0) {
                $data = $responddiecut->result_array();
                $this->db->insert_batch('tbl_jobcard_diecutting', $data);
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
    public function Getjobissuematerialinfo(){
        $recordID=$this->input->post('recordID');

        $this->db->select('jobcardno, job_description, date, company, branch, customer');
		$this->db->from('tbl_jobcard');
        $this->db->join('tbl_company', 'tbl_company.idtbl_company = tbl_jobcard.tbl_company_idtbl_company');
        $this->db->join('tbl_company_branch', 'tbl_company_branch.idtbl_company_branch = tbl_jobcard.tbl_company_branch_idtbl_company_branch');
        $this->db->join('tbl_customer', 'tbl_customer.idtbl_customer = tbl_jobcard.tbl_customer_idtbl_customer');
		$this->db->where('tbl_jobcard.status', 1);
		$this->db->where('tbl_jobcard.idtbl_jobcard', $recordID);
		$respond=$this->db->get();

        $this->db->select('tbl_jobcard_material.cutsize, tbl_jobcard_material.sheetqty, tbl_jobcard_material.batchno, tbl_jobcard_material.issueqty, tbl_printing_format.format_name, tbl_print_material_info.materialname');
		$this->db->from('tbl_jobcard_material');
        $this->db->join('tbl_printing_format', 'tbl_printing_format.idtbl_printing_format = tbl_jobcard_material.tbl_printing_format_idtbl_printing_format', 'left');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_material.tbl_print_material_info_idtbl_print_material_info', 'left');
		$this->db->where('tbl_jobcard_material.tbl_jobcard_idtbl_jobcard', $recordID);
		$this->db->where('tbl_jobcard_material.status', 1);

		$respondmaterial=$this->db->get();

        $this->db->select('tbl_jobcard_varnish.varnishQty, tbl_jobcard_varnish.batchno, tbl_jobcard_varnish.issueqty, tbl_varnish.varnish, tbl_print_material_info.materialname');
		$this->db->from('tbl_jobcard_varnish');
        $this->db->join('tbl_varnish', 'tbl_varnish.idtbl_varnish = tbl_jobcard_varnish.tbl_varnish_idtbl_varnish', 'left');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_varnish.tbl_print_material_info_idtbl_print_material_info', 'left');
		$this->db->where('tbl_jobcard_varnish.tbl_jobcard_idtbl_jobcard', $recordID);
		$this->db->where('tbl_jobcard_varnish.status', 1);

		$respondvarnish=$this->db->get();

        $this->db->select([
            'TRIM(BOTH ", " FROM CONCAT(
                IF(tbl_jobcard_color.cmyk = 1, "CMYK, ", ""),
                IF(tbl_jobcard_color.metlic = 1, "Metlic Color, ", ""),
                IF(tbl_jobcard_color.another = 1, "Any Other, ", "")
            )) AS color_types',
            'tbl_jobcard_color.remark',
            'tbl_jobcard_color.qty',
            'tbl_jobcard_color.issueqty',
            'tbl_jobcard_color.batchno',
            'tbl_print_material_info.materialname'
        ]);
		$this->db->from('tbl_jobcard_color');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_color.tbl_print_material_info_idtbl_print_material_info', 'left');
		$this->db->where('tbl_jobcard_color.tbl_jobcard_idtbl_jobcard', $recordID);
		$this->db->where('tbl_jobcard_color.status', 1);

		$respondcolor=$this->db->get();

        $this->db->select(['IF(tbl_jobcard_lamination.sides = 1, "One Side", "Both Side") AS sides', 'tbl_jobcard_lamination.filmsize', 'tbl_jobcard_lamination.micron', 'tbl_jobcard_lamination.lamination_qty', 'tbl_jobcard_lamination.batchno', 'tbl_jobcard_lamination.issueqty', 'tbl_lamination.lamination', 'tbl_print_material_info.materialname']);
		$this->db->from('tbl_jobcard_lamination');
        $this->db->join('tbl_lamination', 'tbl_lamination.idtbl_lamination = tbl_jobcard_lamination.tbl_lamination_idtbl_lamination', 'left');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_lamination.tbl_print_material_info_idtbl_print_material_info', 'left');
		$this->db->where('tbl_jobcard_lamination.tbl_jobcard_idtbl_jobcard', $recordID);
		$this->db->where('tbl_jobcard_lamination.status', 1);

		$respondlamination=$this->db->get();

        $this->db->select(['IF(tbl_jobcard_rimming.sides = 1, "One Side", "Both Side") AS sides', 'tbl_jobcard_rimming.length', 'tbl_jobcard_rimming.qty', 'tbl_jobcard_rimming.batchno', 'tbl_jobcard_rimming.issueqty', 'tbl_rimming.rimming', 'tbl_print_material_info.materialname']);
		$this->db->from('tbl_jobcard_rimming');
        $this->db->join('tbl_rimming', 'tbl_rimming.idtbl_rimming = tbl_jobcard_rimming.tbl_rimming_idtbl_rimming', 'left');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_rimming.tbl_print_material_info_idtbl_print_material_info', 'left');
		$this->db->where('tbl_jobcard_rimming.tbl_jobcard_idtbl_jobcard', $recordID);
		$this->db->where('tbl_jobcard_rimming.status', 1);

		$respondrimming=$this->db->get();

        $this->db->select(['IF(tbl_jobcard_diecutting.peraforation = 1, "Yes", "No") AS peraforation', 'IF(tbl_jobcard_diecutting.halfCutting = 1, "Yes", "No") AS halfCutting', 'IF(tbl_jobcard_diecutting.fullCutting = 1, "Yes", "No") AS fullCutting', 'tbl_jobcard_diecutting.qty']);
		$this->db->from('tbl_jobcard_diecutting');
		$this->db->where('tbl_jobcard_idtbl_jobcard', $recordID);
		$this->db->where('status', 1);

		$responddiecut=$this->db->get();

        $this->db->select('tbl_jobcard_other.qty, tbl_jobcard_other.batchno, tbl_jobcard_other.issueqty, tbl_print_material_info.materialname');
		$this->db->from('tbl_jobcard_other');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_other.tbl_print_material_info_idtbl_print_material_info', 'left');
		$this->db->where('tbl_jobcard_other.tbl_jobcard_idtbl_jobcard', $recordID);
		$this->db->where('tbl_jobcard_other.status', 1);

		$respondother=$this->db->get();

        $html='';
        $html.='
        <div class="row">
            <div class="col-6 small"><label class="small font-weight-bold text-dark mb-1">Date:</label> '.$respond->row(0)->date.'<br><label class="small font-weight-bold text-dark mb-1">PO No:</label> '.$respond->row(0)->jobcardno.'<br><label class="small font-weight-bold text-dark mb-1">Job Desc:</label> '.$respond->row(0)->job_description.'</div>
            <div class="col-6 small"><label class="small font-weight-bold text-dark mb-1">Customer:</label> '.$respond->row(0)->customer.'<br><label class="small font-weight-bold text-dark mb-1">Company:</label> '.$respond->row(0)->company.'<br><label class="small font-weight-bold text-dark mb-1">Branch:</label> '.$respond->row(0)->branch.'</div>
        </div>
        <hr class="border-dark">
        <h6 class="small title-style"><span>Material Section</span></h6>
        <table class="table table-striped table-bordered table-sm small w-100 nowrap">
            <thead>
                <tr>
                    <th>Format</th>
                    <th>Material</th>
                    <th>Cut Size</th>
                    <th>Sheet Size</th>
                    <th>Batch No</th>
                    <th>Issue Qty</th>
                </tr>
            </thead>';
            foreach($respondmaterial->result() as $rowmaterialdata){
            $html.='
            <tbody>
                <tr>
                    <td>'.$rowmaterialdata->format_name.'</td>
                    <td>'.$rowmaterialdata->materialname.'</td>
                    <td>'.$rowmaterialdata->cutsize.'</td>
                    <td>'.$rowmaterialdata->sheetqty.'</td>
                    <td>'.$rowmaterialdata->batchno.'</td>
                    <td>'.$rowmaterialdata->issueqty.'</td>
                </tr>
            </tbody>
            ';
            }
        $html.='</table>
        <h6 class="small title-style"><span>Coating Section</span></h6>
        <table class="table table-striped table-bordered table-sm small w-100 nowrap">
            <thead>
                <tr>
                    <th>Varnish</th>
                    <th>Material</th>
                    <th>Sheets</th>
                    <th>Batch No</th>
                    <th>Issue Qty</th>
                </tr>
            </thead>';
            foreach($respondvarnish->result() as $rowvarnishdata){
            $html.='
            <tbody>
                <tr>
                    <td>'.$rowvarnishdata->varnish.'</td>
                    <td>'.$rowvarnishdata->materialname.'</td>
                    <td>'.$rowvarnishdata->varnishQty.'</td>
                    <td>'.$rowvarnishdata->batchno.'</td>
                    <td>'.$rowvarnishdata->issueqty.'</td>
                </tr>
            </tbody>
            ';
            }
        $html.='</table>
        <h6 class="small title-style"><span>Color Section</span></h6>
        <table class="table table-striped table-bordered table-sm small w-100 nowrap">
            <thead>
                <tr>
                    <th>Color Type</th>
                    <th>Meterial</th>
                    <th>Qty</th>
                    <th>Remark</th>
                    <th>Batch No</th>
                    <th>Issue Qty</th>
                </tr>
            </thead>';
            foreach($respondcolor->result() as $rowrespondcolordata){
            $html.='
            <tbody>
                <tr>
                    <td>'.$rowrespondcolordata->color_types.'</td>
                    <td>'.$rowrespondcolordata->materialname.'</td>
                    <td>'.$rowrespondcolordata->qty.'</td>
                    <td>'.$rowrespondcolordata->remark.'</td>
                    <td>'.$rowrespondcolordata->batchno.'</td>
                    <td>'.$rowrespondcolordata->issueqty.'</td>
                </tr>
            </tbody>
            ';
            }
        $html.='</table>
        <h6 class="small title-style"><span>Lamination Section</span></h6>
        <table class="table table-striped table-bordered table-sm small w-100 nowrap">
            <thead>
                <tr>
                    <th>Lamination</th>
                    <th>Material</th>
                    <th>Film Size</th>
                    <th>Microne</th>
                    <th>Sides</th>
                    <th>Sheets</th>
                    <th>Batch No</th>
                    <th>Issue Qty</th>
                </tr>
            </thead>';
            foreach($respondlamination->result() as $rowrespondlaminationdata){
            $html.='
            <tbody>
                <tr>
                    <td>'.$rowrespondlaminationdata->lamination.'</td>
                    <td>'.$rowrespondlaminationdata->materialname.'</td>
                    <td>'.$rowrespondlaminationdata->filmsize.'</td>
                    <td>'.$rowrespondlaminationdata->micron.'</td>
                    <td>'.$rowrespondlaminationdata->sides.'</td>
                    <td>'.$rowrespondlaminationdata->lamination_qty.'</td>
                    <td>'.$rowrespondlaminationdata->batchno.'</td>
                    <td>'.$rowrespondlaminationdata->issueqty.'</td>
                </tr>
            </tbody>
            ';
            }
        $html.='</table>
        <h6 class="small title-style"><span>Rimming Section</span></h6>
        <table class="table table-striped table-bordered table-sm small w-100 nowrap">
            <thead>
                <tr>
                    <th>Rimming Type</th>
                    <th>Material</th>
                    <th>Length</th>
                    <th>Sides</th>
                    <th>Sheets</th>
                    <th>Batch No</th>
                    <th>Issue Qty</th>
                </tr>
            </thead>';
            foreach($respondrimming->result() as $rowrespondrimmingdata){
            $html.='
            <tbody>
                <tr>
                    <td>'.$rowrespondrimmingdata->rimming.'</td>
                    <td>'.$rowrespondrimmingdata->materialname.'</td>
                    <td>'.$rowrespondrimmingdata->length.'</td>
                    <td>'.$rowrespondrimmingdata->sides.'</td>
                    <td>'.$rowrespondrimmingdata->qty.'</td>
                    <td>'.$rowrespondrimmingdata->batchno.'</td>
                    <td>'.$rowrespondrimmingdata->issueqty.'</td>
                </tr>
            </tbody>
            ';
            }
        $html.='</table>
        <h6 class="small title-style"><span>Die Cutting Section</span></h6>
        <table class="table table-striped table-bordered table-sm small w-100 nowrap">
            <thead>
                <tr>
                    <th>Qty</th>
                    <th>Perforaction</th>
                    <th>Half Cutting</th>
                    <th>Full Cutting</th>
                </tr>
            </thead>';
            foreach($responddiecut->result() as $rowresponddiecutdata){
            $html.='
            <tbody>
                <tr>
                    <td>'.$rowresponddiecutdata->qty.'</td>
                    <td>'.$rowresponddiecutdata->peraforation.'</td>
                    <td>'.$rowresponddiecutdata->halfCutting.'</td>
                    <td>'.$rowresponddiecutdata->fullCutting.'</td>
                </tr>
            </tbody>
            ';
            }
        $html.='</table>
        <h6 class="small title-style"><span>Other Section</span></h6>
        <table class="table table-striped table-bordered table-sm small w-100 nowrap">
            <thead>
                <tr>
                    <th>Material</th>
                    <th>Qty</th>
                    <th>Batch No</th>
                    <th>Issue Qty</th>
                </tr>
            </thead>';
            foreach($respondother->result() as $rowrespondotherdata){
            $html.='
            <tbody>
                <tr>
                    <td>'.$rowrespondotherdata->materialname.'</td>
                    <td>'.$rowrespondotherdata->qty.'</td>
                    <td>'.$rowrespondotherdata->batchno.'</td>
                    <td>'.$rowrespondotherdata->issueqty.'</td>
                </tr>
            </tbody>
            ';
            }
        $html.='</table>
        ';

        echo $html;
    }
    public function MaterialAllocationapprove() {
        $userID = $_SESSION['userid'];
        $companyID = $_SESSION['company_id'];
        $branchID = $_SESSION['branch_id'];
        $recordID = $this->input->post('recordID');
        $confirmnot = $this->input->post('confirmnot');
        $updatedatetime = date('Y-m-d H:i:s');
    
        $obj = new stdClass();
        $actionObj = new stdClass();
    
        try {
            $this->db->trans_begin();
    
            if ($confirmnot == 1) {
                // APPROVE PROCESS
                $data = array(
                    'approvestatus' => $confirmnot,
                    'updatedatetime' => $updatedatetime
                );
                
                $this->db->where('idtbl_jobcard', $recordID);
                $this->db->update('tbl_jobcard', $data);

                // //Deduct stock
                // $this->db->select('`idtbl_jobcard_issue_meterial`, `batchno`, `issueqty`, `tbl_print_material_info_idtbl_print_material_info`');
                // $this->db->from('tbl_jobcard_issue_meterial');
                // $this->db->where('status', '1');
                // $this->db->where('tbl_jobcard_idtbl_jobcard', $recordID);
                // $respondissue=$this->db->get();

                // foreach ($respondissue->result() as $rowissue) {
                //     $issueqty=$rowissue->issueqty;
                //     $batchno=$rowissue->batchno;
                //     $materialID=$rowissue->tbl_print_material_info_idtbl_print_material_info;

                //     $this->db->where('batchno', $batchno);
                //     $this->db->where('tbl_print_material_info_idtbl_print_material_info', $materialID);
                //     $this->db->where('tbl_company_idtbl_company', $companyID);
                //     $this->db->where('tbl_company_branch_idtbl_company_branch', $branchID);
                //     $this->db->set('qty', 'qty - '.$issueqty, false);
                //     $this->db->update('tbl_print_stock');
                // }
    
                // // Get material value
                // $this->db->select('SUM(`tbl_jobcard_issue_meterial`.`issueqty`*`tbl_jobcard_issue_meterial`.`unitprice`) AS `issuematerialvalue`');
                // $this->db->from('tbl_jobcard_issue_meterial');
                // $this->db->where('status', 1);
                // $this->db->where('tbl_jobcard_idtbl_jobcard', $recordID);
                // $respond = $this->db->get();
    
                // // Get job description
                // $this->db->select('job_description');
                // $this->db->from('tbl_jobcard');
                // $this->db->where('status', 1);
                // $this->db->where('idtbl_jobcard', $recordID);
                // $respondjobcard = $this->db->get();
    
                // $tradate = date('Y-m-d');
                // $traamount = $respond->row(0)->issuematerialvalue;
                // $narrationcr = $respondjobcard->row(0)->job_description.' Material Issued on '.$tradate;
                // $narrationdr = $respondjobcard->row(0)->job_description.' Material Issued on '.$tradate;
                // if ($companyID == 1) {
                //     $accountdrno = 114;
                //     $accountcrno = 115;
                // }
    
                // // Make API call
                // $apiURL = $_SESSION['accountapiurl'].'Api/Issuematerialprocess';
                // $postData = "userid=$userID&company=$companyID&branch=$branchID&tradate=$tradate&traamount=$traamount&accountcrno=$accountcrno&narrationcr=$narrationcr&accountdrno=$accountdrno&narrationdr=$narrationdr";
    
                // $ch = curl_init();
                // curl_setopt($ch, CURLOPT_URL, $apiURL);
                // curl_setopt($ch, CURLOPT_POST, 1);
                // curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
                // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                // curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                // $server_output = curl_exec($ch);
                
                // if (curl_errno($ch)) {
                //     throw new Exception("API call failed: " . curl_error($ch));
                // }
                
                // $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                // curl_close($ch);
    
                // if ($httpCode != 200) {
                //     throw new Exception("API returned HTTP code: $httpCode");
                // }
    
                // // Update issue material status
                // $dataissue = array(
                //     'status' => '2',
                //     'updateuser' => $userID,
                //     'updatedatetime' => $updatedatetime
                // );
                
                // $this->db->where('tbl_jobcard_idtbl_jobcard', $recordID);
                // $this->db->update('tbl_jobcard_issue_meterial', $dataissue);
    
            } 
            else {
                // REJECT PROCESS
                $data = array(
                    'approvestatus' => $confirmnot,
                    'updatedatetime' => $updatedatetime
                );
                
                $this->db->where('idtbl_jobcard', $recordID);
                $this->db->update('tbl_jobcard', $data);
                
                // // Get issued materials to return to stock
                // $this->db->select('issueqty, batchno, tbl_print_material_info_idtbl_print_material_info');
                // $this->db->from('tbl_jobcard_issue_meterial');
                // $this->db->where('status', 1);
                // $this->db->where('tbl_jobcard_idtbl_jobcard', $recordID);
                
                // $respondissuematerial = $this->db->get();
    
                // foreach ($respondissuematerial->result() as $rowissuematerial) {
                //     // Return stock
                //     $this->db->where('batchno', $rowissuematerial->batchno);
                //     $this->db->where('tbl_print_material_info_idtbl_print_material_info', $rowissuematerial->tbl_print_material_info_idtbl_print_material_info);
                //     $this->db->where('tbl_company_idtbl_company', $companyID);
                //     $this->db->where('tbl_company_branch_idtbl_company_branch', $branchID);
    
                //     $this->db->set('qty', 'qty + '.$rowissuematerial->issueqty, false);
                //     if (!$this->db->update('tbl_print_stock')) {
                //         throw new Exception("Failed to update stock for batch: ".$rowissuematerial->batchno);
                //     }
                // }
    
                // // Update issue material status
                // $dataissue = array(
                //     'status' => '2',
                //     'updateuser' => $userID,
                //     'updatedatetime' => $updatedatetime
                // );
                
                // $this->db->where('tbl_jobcard_idtbl_jobcard', $recordID);
                // $this->db->update('tbl_jobcard_issue_meterial', $dataissue);
            }
    
            $this->db->trans_commit();
    
            $actionObj->icon = 'fas fa-check-circle';
            $actionObj->title = '';
            $actionObj->message = ($confirmnot == 1) ? 'Record Approved Successfully' : 'Record Rejected Successfully';
            $actionObj->url = '';
            $actionObj->target = '_blank';
            $actionObj->type = 'success';
    
            $obj->status = 1;
            $obj->action = json_encode($actionObj);
    
        } catch (Exception $e) {
            $this->db->trans_rollback();
            
            error_log("MaterialAllocationapprove Error: " . $e->getMessage());
            
            $actionObj->icon = 'fas fa-exclamation-triangle';
            $actionObj->title = '';
            $actionObj->message = 'Operation Failed: ' . $e->getMessage();
            $actionObj->url = '';
            $actionObj->target = '_blank';
            $actionObj->type = 'danger';
    
            $obj->status = 0;
            $obj->action = json_encode($actionObj);
        }
    
        echo json_encode($obj);
    }
    public function Jobcardstatus($x, $y){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $recordID=$x;
        $type=$y;
        $updatedatetime=date('Y-m-d H:i:s');

        if($type==3){
            // Jobcard Delete Process
            $data = array(
                'status' => '3',
                'tbl_user_idtbl_user'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_jobcard', $recordID);
            $this->db->update('tbl_jobcard', $data);

            // Jobcard Material Delete Process
            $this->db->where('tbl_jobcard_idtbl_jobcard', $recordID);
            $this->db->update('tbl_jobcard_material', $data);

            // Jobcard Varnish Delete Process
            $this->db->where('tbl_jobcard_idtbl_jobcard', $recordID);
            $this->db->update('tbl_jobcard_varnish', $data);

            // Jobcard Lamination Delete Process
            $this->db->where('tbl_jobcard_idtbl_jobcard', $recordID);
            $this->db->update('tbl_jobcard_lamination', $data);

            // Jobcard Rimming Delete Process
            $this->db->where('tbl_jobcard_idtbl_jobcard', $recordID);
            $this->db->update('tbl_jobcard_rimming', $data);

            // Jobcard Diecutting Delete Process
            $this->db->where('tbl_jobcard_idtbl_jobcard', $recordID);
            $this->db->update('tbl_jobcard_diecutting', $data);

            // Jobcard Color Delete Process
            $data2 = array(
                'status' => '3',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('tbl_jobcard_idtbl_jobcard', $recordID);
            $this->db->update('tbl_jobcard_color', $data2);

            // Jobcard Issue Material Delete Process
            $this->db->where('tbl_jobcard_idtbl_jobcard', $recordID);
            $this->db->update('tbl_jobcard_issue_meterial', $data2);

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
                redirect('MaterialAllocation');                
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
                redirect('MaterialAllocation');
            }
        }
    }
    public function jobCardPdf($recordID){
        $this->db->select('jobcardno, job_description, date, company, branch, customer');
		$this->db->from('tbl_jobcard');
        $this->db->join('tbl_company', 'tbl_company.idtbl_company = tbl_jobcard.tbl_company_idtbl_company');
        $this->db->join('tbl_company_branch', 'tbl_company_branch.idtbl_company_branch = tbl_jobcard.tbl_company_branch_idtbl_company_branch');
        $this->db->join('tbl_customer', 'tbl_customer.idtbl_customer = tbl_jobcard.tbl_customer_idtbl_customer');
		$this->db->where('tbl_jobcard.status', 1);
		$this->db->where('tbl_jobcard.idtbl_jobcard', $recordID);
		$respond=$this->db->get();

        $this->db->select('tbl_jobcard_material.cutsize, tbl_jobcard_material.sheetqty, tbl_jobcard_material.batchno, tbl_jobcard_material.issueqty, tbl_printing_format.format_name, tbl_print_material_info.materialname');
		$this->db->from('tbl_jobcard_material');
        $this->db->join('tbl_printing_format', 'tbl_printing_format.idtbl_printing_format = tbl_jobcard_material.tbl_printing_format_idtbl_printing_format', 'left');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_material.tbl_print_material_info_idtbl_print_material_info', 'left');
		$this->db->where('tbl_jobcard_material.tbl_jobcard_idtbl_jobcard', $recordID);
		$this->db->where('tbl_jobcard_material.status', 1);

		$respondmaterial=$this->db->get();

        $this->db->select('tbl_jobcard_varnish.varnishQty, tbl_jobcard_varnish.batchno, tbl_jobcard_varnish.issueqty, tbl_varnish.varnish, tbl_print_material_info.materialname');
		$this->db->from('tbl_jobcard_varnish');
        $this->db->join('tbl_varnish', 'tbl_varnish.idtbl_varnish = tbl_jobcard_varnish.tbl_varnish_idtbl_varnish', 'left');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_varnish.tbl_print_material_info_idtbl_print_material_info', 'left');
		$this->db->where('tbl_jobcard_varnish.tbl_jobcard_idtbl_jobcard', $recordID);
		$this->db->where('tbl_jobcard_varnish.status', 1);

		$respondvarnish=$this->db->get();

        $this->db->select([
            'TRIM(BOTH ", " FROM CONCAT(
                IF(tbl_jobcard_color.cmyk = 1, "CMYK, ", ""),
                IF(tbl_jobcard_color.metlic = 1, "Metlic Color, ", ""),
                IF(tbl_jobcard_color.another = 1, "Any Other, ", "")
            )) AS color_types',
            'tbl_jobcard_color.remark',
            'tbl_jobcard_color.qty',
            'tbl_jobcard_color.issueqty',
            'tbl_jobcard_color.batchno',
            'tbl_print_material_info.materialname'
        ]);
		$this->db->from('tbl_jobcard_color');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_color.tbl_print_material_info_idtbl_print_material_info', 'left');
		$this->db->where('tbl_jobcard_color.tbl_jobcard_idtbl_jobcard', $recordID);
		$this->db->where('tbl_jobcard_color.status', 1);

		$respondcolor=$this->db->get();

        $this->db->select(['IF(tbl_jobcard_lamination.sides = 1, "One Side", "Both Side") AS sides', 'tbl_jobcard_lamination.filmsize', 'tbl_jobcard_lamination.micron', 'tbl_jobcard_lamination.lamination_qty', 'tbl_jobcard_lamination.batchno', 'tbl_jobcard_lamination.issueqty', 'tbl_lamination.lamination', 'tbl_print_material_info.materialname']);
		$this->db->from('tbl_jobcard_lamination');
        $this->db->join('tbl_lamination', 'tbl_lamination.idtbl_lamination = tbl_jobcard_lamination.tbl_lamination_idtbl_lamination', 'left');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_lamination.tbl_print_material_info_idtbl_print_material_info', 'left');
		$this->db->where('tbl_jobcard_lamination.tbl_jobcard_idtbl_jobcard', $recordID);
		$this->db->where('tbl_jobcard_lamination.status', 1);

		$respondlamination=$this->db->get();

        $this->db->select(['IF(tbl_jobcard_rimming.sides = 1, "One Side", "Both Side") AS sides', 'tbl_jobcard_rimming.length', 'tbl_jobcard_rimming.qty', 'tbl_jobcard_rimming.batchno', 'tbl_jobcard_rimming.issueqty', 'tbl_rimming.rimming', 'tbl_print_material_info.materialname']);
		$this->db->from('tbl_jobcard_rimming');
        $this->db->join('tbl_rimming', 'tbl_rimming.idtbl_rimming = tbl_jobcard_rimming.tbl_rimming_idtbl_rimming', 'left');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_rimming.tbl_print_material_info_idtbl_print_material_info', 'left');
		$this->db->where('tbl_jobcard_rimming.tbl_jobcard_idtbl_jobcard', $recordID);
		$this->db->where('tbl_jobcard_rimming.status', 1);

		$respondrimming=$this->db->get();

        $this->db->select(['IF(tbl_jobcard_diecutting.peraforation = 1, "Yes", "No") AS peraforation', 'IF(tbl_jobcard_diecutting.halfCutting = 1, "Yes", "No") AS halfCutting', 'IF(tbl_jobcard_diecutting.fullCutting = 1, "Yes", "No") AS fullCutting', 'tbl_jobcard_diecutting.qty']);
		$this->db->from('tbl_jobcard_diecutting');
		$this->db->where('tbl_jobcard_idtbl_jobcard', $recordID);
		$this->db->where('status', 1);

		$responddiecut=$this->db->get();

        $this->db->select('tbl_jobcard_other.qty, tbl_jobcard_other.batchno, tbl_jobcard_other.issueqty, tbl_print_material_info.materialname');
		$this->db->from('tbl_jobcard_other');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_other.tbl_print_material_info_idtbl_print_material_info', 'left');
		$this->db->where('tbl_jobcard_other.tbl_jobcard_idtbl_jobcard', $recordID);
		$this->db->where('tbl_jobcard_other.status', 1);

		$respondother=$this->db->get();

        $html = '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Goods Received Note</title>
            <style>
                @page {
                    margin: 5mm 5mm 5mm 5mm; /* top right bottom left */
                    font-family: Arial, sans-serif;
                }
                body {
                    font-family: Arial, sans-serif;
                    line-height: 1.5;
                    text-align:left;
                }

                .table-sub  {
                    border-collapse: collapse;
                    width: 100%;
                }

                .table-sub th, .table-sub td {
                    padding: 5px;
                    text-align: left;
                }

                .table-sub th {
                    background-color:rgb(241, 241, 241);
                    font-weight: bold;
                }

                .table-sub tr:nth-child(even) {
                    background-color: rgb(241, 241, 241);
                }

                .table-sub tr:hover {
                    background-color: #f1f1f1;
                }

                .table-sub td {
                    vertical-align: top;
                    border-bottom: 1px solid #dee2e6;
                }
                
                /** Define the footer rules **/
                footer {
                    position: fixed; 
                    bottom: 0px; 
                    left: 0px; 
                    right: 0px;
                    height: 128px;
                }
            </style>
        </head>
        <body>
            <table width="100%" style="font-size: 12px;">
                <tr>
                    <td colspan="2" style="text-align: center;">
                        <h3 style="margin: 0px;"><u>Job Card Information</u></h3>
                    </td>
                </tr>
                <tr>
                    <td width="50%"><b>Date:</b> '.$respond->row(0)->date.'</td>
                    <td><b>Customer:</b> '.$respond->row(0)->customer.'</td>
                </tr>
                <tr>
                    <td><b>PO No:</b> '.$respond->row(0)->jobcardno.'</td>
                    <td><b>Company:</b> '.$respond->row(0)->company.'</td>
                </tr>
                <tr>
                    <td><b>Job Desc:</b> '.$respond->row(0)->job_description.'</td>
                    <td><b>Branch:</b> '.$respond->row(0)->branch.'</td>
                </tr>
                <tr>
                    <td colspan="2"><hr style="border: .1px solid;"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <u>Material Section</u>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table class="table-sub"">
                            <thead>
                                <tr>
                                    <th style="font-size: 12px;">Format</th>
                                    <th style="font-size: 12px;">Material</th>
                                    <th style="font-size: 12px;text-align: center;">Cut Size</th>
                                    <th style="font-size: 12px;text-align: center;">Sheet Size</th>
                                    <th style="font-size: 12px;text-align: center;">Batch No</th>
                                    <th style="font-size: 12px;text-align: center;">Issue Qty</th>
                                </tr>
                            </thead>';
                            foreach($respondmaterial->result() as $rowmaterialdata){
                            $html.='
                            <tbody>
                                <tr>
                                    <td style="font-size: 12px;">'.$rowmaterialdata->format_name.'</td>
                                    <td style="font-size: 12px;">'.$rowmaterialdata->materialname.'</td>
                                    <td style="font-size: 12px;text-align: center;">'.$rowmaterialdata->cutsize.'</td>
                                    <td style="font-size: 12px;text-align: center;">'.$rowmaterialdata->sheetqty.'</td>
                                    <td style="font-size: 12px;text-align: center;">'.$rowmaterialdata->batchno.'</td>
                                    <td style="font-size: 12px;text-align: center;">'.$rowmaterialdata->issueqty.'</td>
                                </tr>
                            </tbody>
                            ';
                            }
                        $html.='</table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <u>Coating Section</u>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table class="table-sub">
                            <thead>
                                <tr>
                                    <th>Varnish</th>
                                    <th>Material</th>
                                    <th style="font-size: 12px;text-align: center;">Sheets</th>
                                    <th style="font-size: 12px;text-align: center;">Batch No</th>
                                    <th style="font-size: 12px;text-align: center;">Issue Qty</th>
                                </tr>
                            </thead>';
                            foreach($respondvarnish->result() as $rowvarnishdata){
                            $html.='
                            <tbody>
                                <tr>
                                    <td>'.$rowvarnishdata->varnish.'</td>
                                    <td>'.$rowvarnishdata->materialname.'</td>
                                    <td style="font-size: 12px;text-align: center;">'.$rowvarnishdata->varnishQty.'</td>
                                    <td style="font-size: 12px;text-align: center;">'.$rowvarnishdata->batchno.'</td>
                                    <td style="font-size: 12px;text-align: center;">'.$rowvarnishdata->issueqty.'</td>
                                </tr>
                            </tbody>
                            ';
                            }
                        $html.='</table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <u>Color Section</u>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table class="table-sub">
                            <thead>
                                <tr>
                                    <th>Color Type</th>
                                    <th>Meterial</th>
                                    <th style="text-align: center">Qty</th>
                                    <th>Remark</th>
                                    <th style="text-align: center">Batch No</th>
                                    <th style="text-align: center">Issue Qty</th>
                                </tr>
                            </thead>';
                            foreach($respondcolor->result() as $rowrespondcolordata){
                            $html.='
                            <tbody>
                                <tr>
                                    <td>'.$rowrespondcolordata->color_types.'</td>
                                    <td>'.$rowrespondcolordata->materialname.'</td>
                                    <td style="text-align: center">'.$rowrespondcolordata->qty.'</td>
                                    <td>'.$rowrespondcolordata->remark.'</td>
                                    <td style="text-align: center">'.$rowrespondcolordata->batchno.'</td>
                                    <td style="text-align: center">'.$rowrespondcolordata->issueqty.'</td>
                                </tr>
                            </tbody>
                            ';
                            }
                        $html.='</table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <u>Lamination Section</u>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table class="table-sub">
                            <thead>
                                <tr>
                                    <th>Lamination</th>
                                    <th>Material</th>
                                    <th>Film Size</th>
                                    <th>Microne</th>
                                    <th>Sides</th>
                                    <th style="font-size: 12px;text-align: center;">Sheets</th>
                                    <th style="font-size: 12px;text-align: center;">Batch No</th>
                                    <th style="font-size: 12px;text-align: center;">Issue Qty</th>
                                </tr>
                            </thead>';
                            foreach($respondlamination->result() as $rowrespondlaminationdata){
                            $html.='
                            <tbody>
                                <tr>
                                    <td>'.$rowrespondlaminationdata->lamination.'</td>
                                    <td>'.$rowrespondlaminationdata->materialname.'</td>
                                    <td>'.$rowrespondlaminationdata->filmsize.'</td>
                                    <td>'.$rowrespondlaminationdata->micron.'</td>
                                    <td>'.$rowrespondlaminationdata->sides.'</td>
                                    <td style="font-size: 12px;text-align: center;">'.$rowrespondlaminationdata->lamination_qty.'</td>
                                    <td style="font-size: 12px;text-align: center;">'.$rowrespondlaminationdata->batchno.'</td>
                                    <td style="font-size: 12px;text-align: center;">'.$rowrespondlaminationdata->issueqty.'</td>
                                </tr>
                            </tbody>
                            ';
                            }
                        $html.='</table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <u>Rimming Section</u>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table class="table-sub">
                            <thead>
                                <tr>
                                    <th>Rimming Type</th>
                                    <th>Material</th>
                                    <th>Length</th>
                                    <th>Sides</th>
                                    <th style="font-size: 12px;text-align: center;">Sheets</th>
                                    <th style="font-size: 12px;text-align: center;">Batch No</th>
                                    <th style="font-size: 12px;text-align: center;">Issue Qty</th>
                                </tr>
                            </thead>';
                            foreach($respondrimming->result() as $rowrespondrimmingdata){
                            $html.='
                            <tbody>
                                <tr>
                                    <td>'.$rowrespondrimmingdata->rimming.'</td>
                                    <td>'.$rowrespondrimmingdata->materialname.'</td>
                                    <td>'.$rowrespondrimmingdata->length.'</td>
                                    <td>'.$rowrespondrimmingdata->sides.'</td>
                                    <td style="font-size: 12px;text-align: center;">'.$rowrespondrimmingdata->qty.'</td>
                                    <td style="font-size: 12px;text-align: center;">'.$rowrespondrimmingdata->batchno.'</td>
                                    <td style="font-size: 12px;text-align: center;">'.$rowrespondrimmingdata->issueqty.'</td>
                                </tr>
                            </tbody>
                            ';
                            }
                        $html.='</table>  
                    </td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <u>Cutting Section</u>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table class="table-sub">
                            <thead>
                                <tr>
                                    <th>Qty</th>
                                    <th>Perforaction</th>
                                    <th style="font-size: 12px;text-align: center;">Half Cutting</th>
                                    <th style="font-size: 12px;text-align: center;">Full Cutting</th>
                                </tr>
                            </thead>';
                            foreach($responddiecut->result() as $rowresponddiecutdata){
                            $html.='
                            <tbody>
                                <tr>
                                    <td>'.$rowresponddiecutdata->qty.'</td>
                                    <td>'.$rowresponddiecutdata->peraforation.'</td>
                                    <td style="font-size: 12px;text-align: center;">'.$rowresponddiecutdata->halfCutting.'</td>
                                    <td style="font-size: 12px;text-align: center;">'.$rowresponddiecutdata->fullCutting.'</td>
                                </tr>
                            </tbody>
                            ';
                            }
                        $html.='</table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <u>Other Section</u>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table class="table-sub">
                            <thead>
                                <tr>
                                    <th>Material</th>
                                    <th style="text-align: center;">Qty</th>
                                    <th style="text-align: center;">Batch No</th>
                                    <th style="text-align: center;">Issue Qty</th>
                                </tr>
                            </thead>';
                            foreach($respondother->result() as $rowrespondotherdata){
                            $html.='
                            <tbody>
                                <tr>
                                    <td>'.$rowrespondotherdata->materialname.'</td>
                                    <td style="text-align: center;">'.$rowrespondotherdata->qty.'</td>
                                    <td style="text-align: center;">'.$rowrespondotherdata->batchno.'</td>
                                    <td style="text-align: center;">'.$rowrespondotherdata->issueqty.'</td>
                                </tr>
                            </tbody>
                            ';
                            }
                        $html.='</table>
                    </td>
                </tr>
            </table>
            <footer style="border-radius: 10px; border: 1px solid #000;padding: 5px; ">
                <table width="100%" style="border-collapse: collapse;">
                    <tr>
                        <td style="vertical-align: top;font-size: 12px;padding-left: 5px;padding-bottom: 50px;" colspan="3">Remarks</td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;font-size: 12px; text-align:center;padding-top: 10px; padding-left: 5px;" rowspan="2">...................................<br>Prepare by</td>
                        <td style="vertical-align: top;font-size: 12px; text-align:center;padding-top: 10px; padding-left: 5px;" rowspan="2">...................................<br>Approved by</td>
                        <td style="vertical-align: top;font-size: 12px; text-align:center;padding-top: 10px; padding-left: 5px;" rowspan="2">...................................<br>Issued by</td>
                    </tr>
                    <tr></tr>
                </table>
            </footer>
        </body>
        </html>';
        $this->load->library('pdf');

        $options = new Options();
		$options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("Goods Received Note - ". $recordID .".pdf", ["Attachment"=>0]);
    }
    public function GetRequestIssueQty(){
        $recordID = $this->input->post('recordID');
        $sectionType = $this->input->post('sectionType');
        
        $this->db->select('DISTINCT(jm.reqissueqty)');
        $this->db->from('tbl_jobcard_issue_meterial jm');
        $this->db->join('tbl_jobcard j', 'j.idtbl_jobcard = jm.tbl_jobcard_idtbl_jobcard', 'left');
        $this->db->where('j.tbl_customerinquiry_idtbl_customerinquiry', $recordID);
        $this->db->where('jm.sectiontype', $sectionType);
        $subquery = $this->db->get_compiled_select();

        $this->db->select('SUM(distinct_values.reqissueqty) as total_reqissueqty');
        $this->db->from("($subquery) as distinct_values");
        $query = $this->db->get();

        $result = $query->row();
        echo json_encode(['total_reqissueqty' => $result->total_reqissueqty ?? 0]);
    }
    public function MaterialAllocationcheckstatus(){
        $this->db->trans_begin();

        $recordID=$this->input->post('jobcardid');
		$confirmnot=$this->input->post('confirmnot');
		$userID=$_SESSION['userid'];
		$updatedatetime=date('Y-m-d H:i:s');

        $data=array(
            'check_by'=> $userID
        );

        $this->db->where('idtbl_jobcard', $recordID);
        $this->db->update('tbl_jobcard', $data);


        $this->db->trans_complete();

        if ($this->db->trans_status()===TRUE) {
            $this->db->trans_commit();

            $actionObj=new stdClass();
            $actionObj->icon='fas fa-check';
            $actionObj->title='';
            if($confirmnot==1){$actionObj->message='Record Checked Successfully';}
            else{$actionObj->message='Record Rejected Successfully';}
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
