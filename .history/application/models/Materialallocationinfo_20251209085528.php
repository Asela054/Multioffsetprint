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
            // $this->db->where('tbl_customerinquiry_detail.job_finish_status', 0);
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
                // $this->db->where('tbl_customerinquiry_detail.job_finish_status', 0);
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
                // $this->db->where('tbl_customerinquiry_detail.job_finish_status', 0);
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
        $this->db->join('tbl_customerinquiry_detail', 'tbl_customerinquiry_detail.tbl_jobcard_bom_idtbl_jobcard_bom = tbl_jobcard_bom.idtbl_jobcard_bom', 'left');
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
            $this->db->select('tbl_jobcard_bom_material.cutups, tbl_jobcard_bom_material.upspersheet, tbl_jobcard_bom_material.wastage, tbl_jobcard_bom_material.tbl_print_material_info_idtbl_print_material_info, tbl_print_material_info.materialname, tbl_jobcard_bom_material.cutsize, SUM(tbl_print_stock.qty) AS `totqty`, CEIL((("' . $issueqty . '"/(`tbl_jobcard_bom_material`.`cutups`*`tbl_jobcard_bom_material`.`upspersheet`))*(100+`tbl_jobcard_bom_material`.`wastage`)/100)) AS `issueqty`');
            $this->db->from('tbl_jobcard_bom_material');
            $this->db->join('tbl_print_stock', 'tbl_print_stock.tbl_print_material_info_idtbl_print_material_info = tbl_jobcard_bom_material.tbl_print_material_info_idtbl_print_material_info', 'left');
            $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_bom_material.tbl_print_material_info_idtbl_print_material_info', 'left');
            $this->db->where('tbl_jobcard_bom_material.status', 1);
            $this->db->where('tbl_jobcard_bom_material.tbl_jobcard_bom_idtbl_jobcard_bom', $bominfo);
            $this->db->group_by("tbl_jobcard_bom_material.tbl_print_material_info_idtbl_print_material_info");

            $respondmaterial=$this->db->get();

            if($respondmaterial->num_rows()>0){
                $html.='
                <tr data-otherrow="materialsection">
                    <th colspan="4" class="sectionremove">Material Section</th>
                </tr>
                ';
                foreach($respondmaterial->result() as $rowmaterial){
                    $html.='
                    <tr class="materialsection">
                        <td class="d-none">1</td>
                        <td>'.$rowmaterial->materialname.'</td>
                        <td class="text-center">'.$rowmaterial->upspersheet.'</td>
                        <td class="text-center">'.$rowmaterial->issueqty.'</td>
                        <td class="batchnolist"></td>
                        <td class="d-none">'.$rowmaterial->tbl_print_material_info_idtbl_print_material_info.'</td>
                        <td class="d-none">'.$issueqty.'</td>
                    </tr>
                    ';

                    if($rowmaterial->issueqty > $rowmaterial->totqty){$warningstockstatus=1;$warningstocktext.=$rowmaterial->materialname.', ';}
                }
            }
        }

        //Printing Section
        if($section==2){
            $this->db->select('tbl_jobcard_bom_color.qty, tbl_jobcard_bom_color.tbl_print_material_info_idtbl_print_material_info, tbl_print_material_info.materialname, SUM(tbl_print_stock.qty) AS `totqty`, CEIL("' . $issueqty . '"*`tbl_jobcard_bom_color`.`qty`) AS `issueqty`');
            $this->db->from('tbl_jobcard_bom_color');
            $this->db->join('tbl_print_stock', 'tbl_print_stock.tbl_print_material_info_idtbl_print_material_info = tbl_jobcard_bom_color.tbl_print_material_info_idtbl_print_material_info', 'left');
            $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_bom_color.tbl_print_material_info_idtbl_print_material_info', 'left');
            $this->db->where('tbl_jobcard_bom_color.status', 1);
            $this->db->where('tbl_jobcard_bom_color.tbl_jobcard_bom_idtbl_jobcard_bom', $bominfo);
            $this->db->group_by("tbl_jobcard_bom_color.tbl_print_material_info_idtbl_print_material_info");

            $respondcolor=$this->db->get();

            if($respondcolor->num_rows()>0){
                $html.='
                <tr data-otherrow="printingsection">
                    <th colspan="4" class="sectionremove">Printing Section</th>
                </tr>
                ';
                foreach($respondcolor->result() as $rowcolor){
                    $html.='
                    <tr class="printingsection">
                        <td class="d-none">2</td>
                        <td>'.$rowcolor->materialname.'</td>
                        <td class="text-center">'.$rowcolor->qty.'</td>
                        <td class="text-center">'.$rowcolor->issueqty.'</td>
                        <td class="batchnolist"></td>
                        <td class="d-none">'.$rowcolor->tbl_print_material_info_idtbl_print_material_info.'</td>
                        <td class="d-none">'.$issueqty.'</td>
                    </tr>
                    ';

                    if($rowcolor->issueqty > $rowcolor->totqty){$warningstockstatus=1;$warningstocktext.=$rowcolor->materialname.', ';}
                }
            }
        }

        //Coating Section
        if($section==3){
            $this->db->select('tbl_jobcard_bom_varnish.varnishQty, tbl_jobcard_bom_varnish.tbl_print_material_info_idtbl_print_material_info, tbl_print_material_info.materialname, SUM(tbl_print_stock.qty) AS `totqty`, CEIL("' . $issueqty . '"*`tbl_jobcard_bom_varnish`.`varnishQty`) AS `issueqty`');
            $this->db->from('tbl_jobcard_bom_varnish');
            $this->db->join('tbl_print_stock', 'tbl_print_stock.tbl_print_material_info_idtbl_print_material_info = tbl_jobcard_bom_varnish.tbl_print_material_info_idtbl_print_material_info', 'left');
            $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_bom_varnish.tbl_print_material_info_idtbl_print_material_info', 'left');
            $this->db->where('tbl_jobcard_bom_varnish.status', 1);
            $this->db->where('tbl_jobcard_bom_varnish.tbl_jobcard_bom_idtbl_jobcard_bom', $bominfo);
            $this->db->group_by("tbl_jobcard_bom_varnish.tbl_print_material_info_idtbl_print_material_info");

            $respondcoating=$this->db->get();

            if($respondcoating->num_rows()>0){
                $html.='
                <tr data-otherrow="coatingsection">
                    <th colspan="4" class="sectionremove">Coating Section</th>
                </tr>
                ';
                foreach($respondcoating->result() as $rowcoating){
                    $html.='
                    <tr class="coatingsection">
                        <td class="d-none">3</td>
                        <td>'.$rowcoating->materialname.'</td>
                        <td class="text-center">'.$rowcoating->varnishQty.'</td>
                        <td class="text-center">'.$rowcoating->issueqty.'</td>
                        <td class="batchnolist"></td>
                        <td class="d-none">'.$rowcoating->tbl_print_material_info_idtbl_print_material_info.'</td>
                        <td class="d-none">'.$issueqty.'</td>
                    </tr>
                    ';

                    if($rowcoating->issueqty > $rowcoating->totqty){$warningstockstatus=1;$warningstocktext.=$rowcoating->materialname.', ';}
                }
            }
        }

        //Foiling Section
        if($section==4){
            $this->db->select('tbl_jobcard_bom_foil.qty, tbl_jobcard_bom_foil.tbl_print_material_info_idtbl_print_material_info, tbl_print_material_info.materialname, SUM(tbl_print_stock.qty) AS `totqty`, CEIL("' . $issueqty . '"*`tbl_jobcard_bom_foil`.`qty`) AS `issueqty`');
            $this->db->from('tbl_jobcard_bom_foil');
            $this->db->join('tbl_print_stock', 'tbl_print_stock.tbl_print_material_info_idtbl_print_material_info = tbl_jobcard_bom_foil.tbl_print_material_info_idtbl_print_material_info', 'left');
            $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_bom_foil.tbl_print_material_info_idtbl_print_material_info', 'left');
            $this->db->where('tbl_jobcard_bom_foil.status', 1);
            $this->db->where('tbl_jobcard_bom_foil.tbl_jobcard_bom_idtbl_jobcard_bom', $bominfo);
            $this->db->group_by("tbl_jobcard_bom_foil.tbl_print_material_info_idtbl_print_material_info");

            $respondfoil=$this->db->get();

            if($respondfoil->num_rows()>0){
                $html.='
                <tr data-otherrow="foilsection">
                    <th colspan="4" class="sectionremove">Foiling Section</th>
                </tr>
                ';
                foreach($respondfoil->result() as $rowfoil){
                    $html.='
                    <tr class="foilsection">
                        <td class="d-none">4</td>
                        <td>'.$rowfoil->materialname.'</td>
                        <td class="text-center">'.$rowfoil->qty.'</td>
                        <td class="text-center">'.$rowfoil->issueqty.'</td>
                        <td class="batchnolist"></td>
                        <td class="d-none">'.$rowfoil->tbl_print_material_info_idtbl_print_material_info.'</td>
                        <td class="d-none">'.$issueqty.'</td>
                    </tr>
                    ';

                    if($rowfoil->issueqty > $rowfoil->totqty){$warningstockstatus=1;$warningstocktext.=$rowfoil->materialname.', ';}
                }
            }
        }

        //Lamination Section
        if($section==5){
            $this->db->select('tbl_jobcard_bom_lamination.lamination_qty, tbl_jobcard_bom_lamination.tbl_print_material_info_idtbl_print_material_info, tbl_print_material_info.materialname, SUM(tbl_print_stock.qty) AS `totqty`, CEIL("' . $issueqty . '"*`tbl_jobcard_bom_lamination`.`lamination_qty`) AS `issueqty`');
            $this->db->from('tbl_jobcard_bom_lamination');
            $this->db->join('tbl_print_stock', 'tbl_print_stock.tbl_print_material_info_idtbl_print_material_info = tbl_jobcard_bom_lamination.tbl_print_material_info_idtbl_print_material_info', 'left');
            $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_bom_lamination.tbl_print_material_info_idtbl_print_material_info', 'left');
            $this->db->where('tbl_jobcard_bom_lamination.status', 1);
            $this->db->where('tbl_jobcard_bom_lamination.tbl_jobcard_bom_idtbl_jobcard_bom', $bominfo);
            $this->db->group_by("tbl_jobcard_bom_lamination.tbl_print_material_info_idtbl_print_material_info");

            $respondlamination=$this->db->get();

            if($respondlamination->num_rows()>0){
                $html.='
                <tr data-otherrow="laminationsection">
                    <th colspan="4" class="sectionremove">Lamination Section</th>
                </tr>
                ';
                foreach($respondlamination->result() as $rowlamination){
                    $html.='
                    <tr class="laminationsection">
                        <td class="d-none">5</td>
                        <td>'.$rowlamination->materialname.'</td>
                        <td class="text-center">'.$rowlamination->lamination_qty.'</td>
                        <td class="text-center">'.$rowlamination->issueqty.'</td>
                        <td class="batchnolist"></td>
                        <td class="d-none">'.$rowlamination->tbl_print_material_info_idtbl_print_material_info.'</td>
                        <td class="d-none">'.$issueqty.'</td>
                    </tr>
                    ';

                    if($rowlamination->issueqty > $rowlamination->totqty){$warningstockstatus=1;$warningstocktext.=$rowlamination->materialname.', ';}
                }
            }
        }

        //Pasting Section
        if($section==6){
            $this->db->select('tbl_jobcard_bom_pasting.pasteqty, tbl_jobcard_bom_pasting.tbl_print_material_info_idtbl_print_material_info, tbl_print_material_info.materialname, SUM(tbl_print_stock.qty) AS `totqty`, CEIL("' . $issueqty . '"*`tbl_jobcard_bom_pasting`.`pasteqty`) AS `issueqty`');
            $this->db->from('tbl_jobcard_bom_pasting');
            $this->db->join('tbl_print_stock', 'tbl_print_stock.tbl_print_material_info_idtbl_print_material_info = tbl_jobcard_bom_pasting.tbl_print_material_info_idtbl_print_material_info', 'left');
            $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_bom_pasting.tbl_print_material_info_idtbl_print_material_info', 'left');
            $this->db->where('tbl_jobcard_bom_pasting.status', 1);
            $this->db->where('tbl_jobcard_bom_pasting.tbl_jobcard_bom_idtbl_jobcard_bom', $bominfo);
            $this->db->group_by("tbl_jobcard_bom_pasting.tbl_print_material_info_idtbl_print_material_info");

            $respondpaste=$this->db->get();

            if($respondpaste->num_rows()>0){
                $html.='
                <tr data-otherrow="pastesection">
                    <th colspan="4" class="sectionremove">Pasting Section</th>
                </tr>
                ';
                foreach($respondpaste->result() as $rowpaste){
                    $html.='
                    <tr class="pastesection">
                        <td class="d-none">6</td>
                        <td>'.$rowpaste->materialname.'</td>
                        <td class="text-center">'.$rowpaste->pasteqty.'</td>
                        <td class="text-center">'.$rowpaste->issueqty.'</td>
                        <td class="batchnolist"></td>
                        <td class="d-none">'.$rowpaste->tbl_print_material_info_idtbl_print_material_info.'</td>
                        <td class="d-none">'.$issueqty.'</td>
                    </tr>
                    ';

                    if($rowpaste->issueqty > $rowpaste->totqty){$warningstockstatus=1;$warningstocktext.=$rowpaste->materialname.', ';}
                }
            }
        }

        //Rimming Section
        if($section==7){
            $this->db->select('tbl_jobcard_bom_rimming.qty, tbl_jobcard_bom_rimming.tbl_print_material_info_idtbl_print_material_info, tbl_print_material_info.materialname, SUM(tbl_print_stock.qty) AS `totqty`, CEIL("' . $issueqty . '"*`tbl_jobcard_bom_rimming`.`qty`) AS `issueqty`');
            $this->db->from('tbl_jobcard_bom_rimming');
            $this->db->join('tbl_print_stock', 'tbl_print_stock.tbl_print_material_info_idtbl_print_material_info = tbl_jobcard_bom_rimming.tbl_print_material_info_idtbl_print_material_info', 'left');
            $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_bom_rimming.tbl_print_material_info_idtbl_print_material_info', 'left');
            $this->db->where('tbl_jobcard_bom_rimming.status', 1);
            $this->db->where('tbl_jobcard_bom_rimming.tbl_jobcard_bom_idtbl_jobcard_bom', $bominfo);
            $this->db->group_by("tbl_jobcard_bom_rimming.tbl_print_material_info_idtbl_print_material_info");

            $respondrimming=$this->db->get();

            if($respondrimming->num_rows()>0){
                $html.='
                <tr data-otherrow="rimmingsection">
                    <th colspan="4" class="sectionremove">Rimming Section</th>
                </tr>
                ';
                foreach($respondrimming->result() as $rowrimming){
                    $html.='
                    <tr class="rimmingsection">
                        <td class="d-none">7</td>
                        <td>'.$rowrimming->materialname.'</td>
                        <td class="text-center">'.$rowrimming->qty.'</td>
                        <td class="text-center">'.$rowrimming->issueqty.'</td>
                        <td class="batchnolist"></td>
                        <td class="d-none">'.$rowrimming->tbl_print_material_info_idtbl_print_material_info.'</td>
                        <td class="d-none">'.$issueqty.'</td>
                    </tr>
                    ';

                    if($rowrimming->issueqty > $rowrimming->totqty){$warningstockstatus=1;$warningstocktext.='Rimming Section, ';}
                }
            }
        }

        // //Other Section
        // if($section==7){
        //     $this->db->select('tbl_jobcard_bom_other.qty, tbl_jobcard_bom_other.tbl_print_material_info_idtbl_print_material_info, tbl_print_material_info.materialname, SUM(tbl_print_stock.qty) AS `totqty`');
        //     $this->db->from('tbl_jobcard_bom_other');
        //     $this->db->join('tbl_print_stock', 'tbl_print_stock.tbl_print_material_info_idtbl_print_material_info = tbl_jobcard_bom_other.tbl_print_material_info_idtbl_print_material_info', 'left');
        //     $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_bom_other.tbl_print_material_info_idtbl_print_material_info', 'left');
        //     $this->db->where('tbl_jobcard_bom_other.status', 1);
        //     $this->db->where('tbl_jobcard_bom_other.tbl_jobcard_bom_idtbl_jobcard_bom', $bominfo);
        //     $this->db->group_by("tbl_jobcard_bom_other.tbl_print_material_info_idtbl_print_material_info");

        //     $respondother=$this->db->get();

        //     if($respondother->num_rows()>0){
        //         $html.='
        //         <tr>
        //             <th colspan="4">Lamination Section</th>
        //         </tr>
        //         ';
        //         foreach($respondother->result() as $rowother){
        //             $html.='
        //             <tr>
        //                 <td class="d-none">7</td>
        //                 <td>'.$rowother->materialname.'</td>
        //                 <td class="text-center">'.$rowother->qty.'</td>
        //                 <td class="text-center">'.ceil($rowother->qty*$issueqty).'</td>
        //                 <td class="batchnolist"></td>
        //                 <td class="d-none">'.$rowother->tbl_print_material_info_idtbl_print_material_info.'</td>
        //                 <td class="d-none">'.$issueqty.'</td>
        //             </tr>
        //             ';

        //             if(($rowother->qty*$issueqty) > $rowother->totqty){$warningstockstatus=1;$warningstocktext.=$rowother->materialname.', ';}
        //         }
        //     }
        // }

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
        $jobcardtype=$this->input->post('jobcardtype');
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
                'jobcardtype'=> $jobcardtype,
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
            $batchnolist=$rowdatalist['col_4'];
            $materialID=$rowdatalist['col_6'];
            $reqissueqty=$rowdatalist['col_7'];

            if($type==1){//Material Section
                $this->db->select('`materialby`, `cutsize`, `cutups`, `upspersheet`, `wastage`');
                $this->db->from('tbl_jobcard_bom_material');
                $this->db->where('tbl_print_material_info_idtbl_print_material_info', $materialID);
                $this->db->where('tbl_jobcard_bom_idtbl_jobcard_bom', $bominfo);

                $respondbommateinfo=$this->db->get();
                
                $datamaterial = array(
                    'materialby'=> $respondbommateinfo->row(0)->materialby, 
                    'cutsize'=> $respondbommateinfo->row(0)->cutsize, 
                    'cutups'=> $respondbommateinfo->row(0)->cutups, 
                    'upspersheet'=> $respondbommateinfo->row(0)->upspersheet, 
                    'wastage'=> $respondbommateinfo->row(0)->wastage, 
                    'batchno'=> $batchnolist, 
                    'issueqty'=> $issueqtydata, 
                    'status'=> '1', 
                    'insertdatetime'=> $updatedatetime, 
                    'tbl_user_idtbl_user'=> $userID, 
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
            if($type==2){//Printing Section
                $this->db->select('`colormaterialby`, `colortype`, `remark`, `qty`');
                $this->db->from('tbl_jobcard_bom_color');
                $this->db->where('tbl_print_material_info_idtbl_print_material_info', $materialID);
                $this->db->where('tbl_jobcard_bom_idtbl_jobcard_bom', $bominfo);

                $respondbomcolorinfo=$this->db->get();
                
                $datacolor = array(
                    'colormaterialby'=> $respondbomcolorinfo->row(0)->colormaterialby, 
                    'colortype'=> $respondbomcolorinfo->row(0)->colortype, 
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
            if($type==3){//Coating Section
                $this->db->select('`glossmatt`, `fullspot`, `varnishQty`, `remark`, `tbl_varnish_idtbl_varnish`');
                $this->db->from('tbl_jobcard_bom_varnish');
                $this->db->where('tbl_print_material_info_idtbl_print_material_info', $materialID);
                $this->db->where('tbl_jobcard_bom_idtbl_jobcard_bom', $bominfo);

                $respondbomvarnishinfo=$this->db->get();
                
                $datavarnish = array(
                    'glossmatt'=> $respondbomvarnishinfo->row(0)->glossmatt, 
                    'fullspot'=> $respondbomvarnishinfo->row(0)->fullspot, 
                    'varnishQty'=> $respondbomvarnishinfo->row(0)->varnishQty, 
                    'remark'=> $respondbomvarnishinfo->row(0)->remark, 
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
            if($type==4){//Foiling Section
                $this->db->select('`foilmaterialby`, `qty`, `remark`, `tbl_foiling_idtbl_foiling`');
                $this->db->from('tbl_jobcard_foil');
                $this->db->where('tbl_print_material_info_idtbl_print_material_info', $materialID);
                $this->db->where('tbl_jobcard_bom_idtbl_jobcard_bom', $bominfo);

                $respondbomfoilinfo=$this->db->get();
                
                $datafoil = array(
                    'foilmaterialby'=> $respondbomfoilinfo->row(0)->foilmaterialby, 
                    'qty'=> $respondbomfoilinfo->row(0)->qty, 
                    'remark'=> $respondbomfoilinfo->row(0)->remark, 
                    'batchno'=> $batchnolist, 
                    'issueqty'=> $issueqtydata, 
                    'status'=> '1', 
                    'insertdatetime'=> $updatedatetime, 
                    'tbl_user_idtbl_user'=> $userID, 
                    'tbl_print_material_info_idtbl_print_material_info'=> $materialID, 
                    'tbl_foiling_idtbl_foiling'=> $respondbomfoilinfo->row(0)->tbl_foiling_idtbl_foiling, 
                    'tbl_jobcard_idtbl_jobcard'=> $jobCardID
                );
       
                $this->db->insert('tbl_jobcard_foil', $datafoil);

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
            if($type==5){//Lamination Section
                $this->db->select('`sides`, `filmsize`, `lamination_qty`, `wastage`, `tbl_lamination_idtbl_lamination`');
                $this->db->from('tbl_jobcard_bom_lamination');
                $this->db->where('tbl_print_material_info_idtbl_print_material_info', $materialID);
                $this->db->where('tbl_jobcard_bom_idtbl_jobcard_bom', $bominfo);

                $respondbomlamination=$this->db->get();
                
                $datalamination = array(
                    'sides'=> $respondbomlamination->row(0)->sides, 
                    'filmsize'=> $respondbomlamination->row(0)->filmsize, 
                    'lamination_qty'=> $respondbomlamination->row(0)->lamination_qty, 
                    'wastage'=> $respondbomlamination->row(0)->wastage, 
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
            if($type==6){//Paste Section
                $this->db->select('`pastetype`, `pasteqty`, `remark`, `tbl_machine_idtbl_machine`');
                $this->db->from('tbl_jobcard_bom_pasting');
                $this->db->where('tbl_print_material_info_idtbl_print_material_info', $materialID);
                $this->db->where('tbl_jobcard_bom_idtbl_jobcard_bom', $bominfo);

                $respondbompasting=$this->db->get();
                
                $datapasting = array(
                    'pastetype'=> $respondbompasting->row(0)->pastetype, 
                    'pasteqty'=> $respondbompasting->row(0)->pasteqty, 
                    'remark'=> $respondbompasting->row(0)->remark, 
                    'batchno'=> $batchnolist, 
                    'issueqty'=> $issueqtydata, 
                    'status'=> '1', 
                    'insertdatetime'=> $updatedatetime, 
                    'tbl_user_idtbl_user'=> $userID, 
                    'tbl_machine_idtbl_machine'=> $respondbompasting->row(0)->tbl_machine_idtbl_machine, 
                    'tbl_print_material_info_idtbl_print_material_info'=> $materialID, 
                    'tbl_jobcard_idtbl_jobcard'=> $jobCardID
                );
       
                $this->db->insert('tbl_jobcard_pasting', $datapasting);

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
            if($type==7){//Rimming Section
                $this->db->select('`rimmingby`, `sides`, `qty`, `remark`, `tbl_rimming_idtbl_rimming`');
                $this->db->from('tbl_jobcard_bom_rimming');
                $this->db->where('tbl_print_material_info_idtbl_print_material_info', $materialID);
                $this->db->where('tbl_jobcard_bom_idtbl_jobcard_bom', $bominfo);

                $respondbomrimming=$this->db->get();
                
                $datarimming = array(
                    'rimmingby'=> $respondbomrimming->row(0)->rimmingby, 
                    'sides'=> $respondbomrimming->row(0)->sides, 
                    'qty'=> $respondbomrimming->row(0)->qty, 
                    'remark'=> $respondbomrimming->row(0)->remark, 
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
        }

        //Diecutting Section
        $this->db->select('COUNT(*) AS `count`');
        $this->db->from('tbl_jobcard_diecutting');
        $this->db->where('tbl_jobcard_idtbl_jobcard', $jobCardID);
        $this->db->where('status', '1');

        $respondcheckdiecut=$this->db->get();

        if($respondcheckdiecut->row(0)->count==0){
            $this->db->select("`channel`, `board`, `size`, `qty`, `diecutby`, `embossby`, 1 AS `status`, '$updatedatetime' AS `insertdatetime`, '$userID' AS `tbl_user_idtbl_user`, '$jobCardID' AS `tbl_jobcard_idtbl_jobcard`");
            $this->db->from('tbl_jobcard_bom_diecutting');
            $this->db->where('status', 1);
            $this->db->where('tbl_jobcard_bom_idtbl_jobcard_bom', $bominfo);
            
            $responddiecut = $this->db->get();

            if ($responddiecut->num_rows() > 0) {
                $data = $responddiecut->result_array();
                $this->db->insert_batch('tbl_jobcard_diecutting', $data);
            }
        }

        //Other Section
        $this->db->select('COUNT(*) AS `count`');
        $this->db->from('tbl_jobcard_other');
        $this->db->where('tbl_jobcard_idtbl_jobcard', $jobCardID);
        $this->db->where('status', '1');

        $respondcheckother=$this->db->get();

        if($respondcheckother->row(0)->count==0){
            $this->db->select("`perfoating`, `gattering`, `rimming`, `binding`, `stapling`, `padding`, `creasing`, `threading`, 1 AS `status`, '$updatedatetime' AS `insertdatetime`, '$userID' AS `tbl_user_idtbl_user`, '$jobCardID' AS `tbl_jobcard_idtbl_jobcard`");
            $this->db->from('tbl_jobcard_bom_other');
            $this->db->where('status', 1);
            $this->db->where('tbl_jobcard_bom_idtbl_jobcard_bom', $bominfo);
            
            $respondother = $this->db->get();

            if ($respondother->num_rows() > 0) {
                $data = $respondother->result_array();
                $this->db->insert_batch('tbl_jobcard_other', $data);
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

        $this->db->select('tbl_jobcard_material.materialby, tbl_jobcard_material.cutsize, tbl_jobcard_material.cutups, tbl_jobcard_material.upspersheet, tbl_jobcard_material.wastage, tbl_jobcard_material.batchno, tbl_jobcard_material.issueqty, tbl_print_material_info.materialname');
		$this->db->from('tbl_jobcard_material');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_material.tbl_print_material_info_idtbl_print_material_info', 'left');
		$this->db->where('tbl_jobcard_material.tbl_jobcard_idtbl_jobcard', $recordID);
		$this->db->where('tbl_jobcard_material.status', 1);

		$respondmaterial=$this->db->get();

        $this->db->select([
            'tbl_jobcard_color.colormaterialby',
            'tbl_jobcard_color.colortype',
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

        $this->db->select('tbl_jobcard_varnish.glossmatt, tbl_jobcard_varnish.fullspot, tbl_jobcard_varnish.varnishQty, tbl_jobcard_varnish.batchno, tbl_jobcard_varnish.issueqty, tbl_varnish.varnish, tbl_print_material_info.materialname');
		$this->db->from('tbl_jobcard_varnish');
        $this->db->join('tbl_varnish', 'tbl_varnish.idtbl_varnish = tbl_jobcard_varnish.tbl_varnish_idtbl_varnish', 'left');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_varnish.tbl_print_material_info_idtbl_print_material_info', 'left');
		$this->db->where('tbl_jobcard_varnish.tbl_jobcard_idtbl_jobcard', $recordID);
		$this->db->where('tbl_jobcard_varnish.status', 1);

		$respondvarnish=$this->db->get();  
        
        $this->db->select('tbl_jobcard_foil.foilmaterialby, tbl_jobcard_foil.qty, tbl_jobcard_foil.remark, tbl_jobcard_foil.batchno, tbl_jobcard_foil.issueqty, tbl_foiling.foiling, tbl_print_material_info.materialname');
		$this->db->from('tbl_jobcard_foil');
        $this->db->join('tbl_foiling', 'tbl_foiling.idtbl_foiling = tbl_jobcard_foil.tbl_foiling_idtbl_foiling', 'left');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_foil.tbl_print_material_info_idtbl_print_material_info', 'left');
		$this->db->where('tbl_jobcard_foil.tbl_jobcard_idtbl_jobcard', $recordID);
		$this->db->where('tbl_jobcard_foil.status', 1);

		$respondfoiling=$this->db->get();  

        $this->db->select(['tbl_jobcard_lamination.sides', 'tbl_jobcard_lamination.filmsize', 'tbl_jobcard_lamination.lamination_qty', 'tbl_jobcard_lamination.wastage', 'tbl_jobcard_lamination.batchno', 'tbl_jobcard_lamination.issueqty', 'tbl_lamination.lamination', 'tbl_print_material_info.materialname']);
		$this->db->from('tbl_jobcard_lamination');
        $this->db->join('tbl_lamination', 'tbl_lamination.idtbl_lamination = tbl_jobcard_lamination.tbl_lamination_idtbl_lamination', 'left');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_lamination.tbl_print_material_info_idtbl_print_material_info', 'left');
		$this->db->where('tbl_jobcard_lamination.tbl_jobcard_idtbl_jobcard', $recordID);
		$this->db->where('tbl_jobcard_lamination.status', 1);

		$respondlamination=$this->db->get();

        $this->db->select('tbl_jobcard_pasting.pastetype, tbl_jobcard_pasting.pasteqty, tbl_jobcard_pasting.remark, tbl_jobcard_pasting.batchno, tbl_jobcard_pasting.issueqty, tbl_machine.machine, tbl_print_material_info.materialname');
		$this->db->from('tbl_jobcard_pasting');
        $this->db->join('tbl_machine', 'tbl_machine.idtbl_machine = tbl_jobcard_pasting.tbl_machine_idtbl_machine', 'left');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_pasting.tbl_print_material_info_idtbl_print_material_info', 'left');
		$this->db->where('tbl_jobcard_pasting.tbl_jobcard_idtbl_jobcard', $recordID);
		$this->db->where('tbl_jobcard_pasting.status', 1);

		$respondpasting=$this->db->get();  

        $this->db->select(['tbl_jobcard_diecutting.channel', 'tbl_jobcard_diecutting.board', 'tbl_jobcard_diecutting.size', 'tbl_jobcard_diecutting.qty', 'tbl_jobcard_diecutting.diecutby', 'tbl_jobcard_diecutting.embossby']);
		$this->db->from('tbl_jobcard_diecutting');
		$this->db->where('tbl_jobcard_idtbl_jobcard', $recordID);
		$this->db->where('status', 1);

		$responddiecut=$this->db->get();

        $this->db->select(['tbl_jobcard_rimming.rimmingby', 'tbl_jobcard_rimming.sides', 'tbl_jobcard_rimming.qty', 'tbl_jobcard_rimming.remark', 'tbl_jobcard_rimming.batchno', 'tbl_jobcard_rimming.issueqty', 'tbl_rimming.rimming', 'tbl_print_material_info.materialname']);
		$this->db->from('tbl_jobcard_rimming');
        $this->db->join('tbl_rimming', 'tbl_rimming.idtbl_rimming = tbl_jobcard_rimming.tbl_rimming_idtbl_rimming', 'left');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_rimming.tbl_print_material_info_idtbl_print_material_info', 'left');
		$this->db->where('tbl_jobcard_rimming.tbl_jobcard_idtbl_jobcard', $recordID);
		$this->db->where('tbl_jobcard_rimming.status', 1);

		$respondrimming=$this->db->get();

        $this->db->select('`perfoating`, `gattering`, `rimming`, `binding`, `stapling`, `padding`, `creasing`, `threading`');
		$this->db->from('tbl_jobcard_other');
		$this->db->where('tbl_jobcard_idtbl_jobcard', $recordID);
		$this->db->where('status', 1);

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
                    <th>By</th>
                    <th>Material</th>
                    <th>Cut Size</th>
                    <th>Cut Up`s</th>
                    <th>Up Sheets</th>
                    <th>Batch No</th>
                    <th>Issue Qty</th>
                </tr>
            </thead>';
            foreach($respondmaterial->result() as $rowmaterialdata){
            $html.='
            <tbody>
                <tr>
                    <td>'.$rowmaterialdata->materialby.'</td>
                    <td>'.$rowmaterialdata->materialname.'</td>
                    <td>'.$rowmaterialdata->cutsize.'</td>
                    <td>'.$rowmaterialdata->cutups.'</td>
                    <td>'.$rowmaterialdata->upspersheet.'</td>
                    <td>'.$rowmaterialdata->batchno.'</td>
                    <td>'.$rowmaterialdata->issueqty.'</td>
                </tr>
            </tbody>
            ';
            }
        $html.='</table>
        <h6 class="small title-style"><span>Printing Section</span></h6>
        <table class="table table-striped table-bordered table-sm small w-100 nowrap">
            <thead>
                <tr>
                    <th>By</th>
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
                    <td>'.$rowrespondcolordata->colormaterialby.'</td>
                    <td>'.$rowrespondcolordata->colortype.'</td>
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
        <h6 class="small title-style"><span>Coating Section</span></h6>
        <table class="table table-striped table-bordered table-sm small w-100 nowrap">
            <thead>
                <tr>
                    <th>Varnish</th>
                    <th>Gloss | Matt</th>
                    <th>Full | Spot</th>
                    <th>Material</th>
                    <th>Qty(KG)</th>
                    <th>Batch No</th>
                    <th>Issue Qty(KG)</th>
                </tr>
            </thead>';
            foreach($respondvarnish->result() as $rowvarnishdata){
            $html.='
            <tbody>
                <tr>
                    <td>'.$rowvarnishdata->varnish.'</td>
                    <td>'.$rowvarnishdata->glossmatt.'</td>
                    <td>'.$rowvarnishdata->fullspot.'</td>
                    <td>'.$rowvarnishdata->materialname.'</td>
                    <td>'.$rowvarnishdata->varnishQty.'</td>
                    <td>'.$rowvarnishdata->batchno.'</td>
                    <td>'.$rowvarnishdata->issueqty.'</td>
                </tr>
            </tbody>
            ';
            }
        $html.='</table>
        <h6 class="small title-style"><span>Foiling Section</span></h6>
        <table class="table table-striped table-bordered table-sm small w-100 nowrap">
            <thead>
                <tr>
                    <th>By</th>
                    <th>Material</th>
                    <th>Foil Type</th>
                    <th>Remark</th>
                    <th>Qty(Inch)</th>
                    <th>Batch No</th>
                    <th>Issue Qty</th>
                </tr>
            </thead>';
            foreach($respondfoiling->result() as $rowfoilingdata){
            $html.='
            <tbody>
                <tr>
                    <td>'.$rowfoilingdata->foilmaterialby.'</td>
                    <td>'.$rowfoilingdata->materialname.'</td>
                    <td>'.$rowfoilingdata->foiling.'</td>
                    <td>'.$rowfoilingdata->remark.'</td>
                    <td>'.$rowfoilingdata->qty.'</td>
                    <td>'.$rowfoilingdata->batchno.'</td>
                    <td>'.$rowfoilingdata->issueqty.'</td>
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
                    <th>Sides</th>
                    <th>Qty(KG)</th>
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
                    <td>'.$rowrespondlaminationdata->sides.'</td>
                    <td>'.$rowrespondlaminationdata->lamination_qty.'</td>
                    <td>'.$rowrespondlaminationdata->batchno.'</td>
                    <td>'.$rowrespondlaminationdata->issueqty.'</td>
                </tr>
            </tbody>
            ';
            }
        $html.='</table>
        <h6 class="small title-style"><span>Pasting Section</span></h6>
        <table class="table table-striped table-bordered table-sm small w-100 nowrap">
            <thead>
                <tr>
                    <th>Material</th>
                    <th>Machine</th>
                    <th>Paste Type</th>
                    <th>Remark</th>
                    <th>Qty(KG)</th>
                    <th>Batch No</th>
                    <th>Issue Qty</th>
                </tr>
            </thead>';
            foreach($respondpasting->result() as $rowpastingdata){
            $html.='
            <tbody>
                <tr>
                    <td>'.$rowpastingdata->materialname.'</td>
                    <td>'.$rowpastingdata->machine.'</td>
                    <td>'.$rowpastingdata->pastetype.'</td>
                    <td>'.$rowpastingdata->remark.'</td>
                    <td>'.$rowpastingdata->pasteqty.'</td>
                    <td>'.$rowpastingdata->batchno.'</td>
                    <td>'.$rowpastingdata->issueqty.'</td>
                </tr>
            </tbody>
            ';
            }
        $html.='</table>
        <h6 class="small title-style"><span>Die Cutting Section</span></h6>
        <table class="table table-striped table-bordered table-sm small w-100 nowrap">
            <thead>
                <tr>
                    <th>Channel</th>
                    <th>Board</th>
                    <th>Size</th>
                    <th>Qty(m)</th>
                    <th>Die cutting By</th>
                    <th>Embossing</th>
                </tr>
            </thead>';
            foreach($responddiecut->result() as $rowresponddiecutdata){
            $html.='
            <tbody>
                <tr>
                    <td>'.$rowresponddiecutdata->channel.'</td>
                    <td>'.$rowresponddiecutdata->board.'</td>
                    <td>'.$rowresponddiecutdata->size.'</td>
                    <td>'.$rowresponddiecutdata->qty.'</td>
                    <td>'.$rowresponddiecutdata->diecutby.'</td>
                    <td>'.$rowresponddiecutdata->embossby.'</td>
                </tr>
            </tbody>
            ';
            }
        $html.='</table>
        <h6 class="small title-style"><span>Rimming Section</span></h6>
        <table class="table table-striped table-bordered table-sm small w-100 nowrap">
            <thead>
                <tr>
                    <th>By</th>
                    <th>Rimming Type</th>
                    <th>Material</th>
                    <th>Remark</th>
                    <th>Side</th>
                    <th>Qty</th>
                    <th>Batch No</th>
                    <th>Issue Qty</th>
                </tr>
            </thead>';
            foreach($respondrimming->result() as $rowrespondrimmingdata){
            $html.='
            <tbody>
                <tr>
                    <td>'.$rowrespondrimmingdata->rimmingby.'</td>
                    <td>'.$rowrespondrimmingdata->rimming.'</td>
                    <td>'.$rowrespondrimmingdata->materialname.'</td>
                    <td>'.$rowrespondrimmingdata->remark.'</td>
                    <td>'.$rowrespondrimmingdata->sides.'</td>
                    <td>'.$rowrespondrimmingdata->qty.'</td>
                    <td>'.$rowrespondrimmingdata->batchno.'</td>
                    <td>'.$rowrespondrimmingdata->issueqty.'</td>
                </tr>
            </tbody>
            ';
            }
        $html.='</table>
        <h6 class="small title-style"><span>Other Section</span></h6>
        <table class="table table-striped table-bordered table-sm small w-100 nowrap">
            <thead>
                <tr>
                    <th>Perforating</th>
                    <th>Gattering</th>
                    <th>Rimming</th>
                    <th>Binding</th>
                    <th>Stapling</th>
                    <th>Padding</th>
                    <th>Creasing</th>
                    <th>Threading</th>
                </tr>
            </thead>';
            foreach($respondother->result() as $rowrespondotherdata){
            $html.='
            <tbody>
                <tr>
                    <td>'.$rowrespondotherdata->perfoating.'</td>
                    <td>'.$rowrespondotherdata->gattering.'</td>
                    <td>'.$rowrespondotherdata->rimming.'</td>
                    <td>'.$rowrespondotherdata->binding.'</td>
                    <td>'.$rowrespondotherdata->stapling.'</td>
                    <td>'.$rowrespondotherdata->padding.'</td>
                    <td>'.$rowrespondotherdata->creasing.'</td>
                    <td>'.$rowrespondotherdata->threading.'</td>
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

        $this->db->select('tbl_jobcard_material.materialby, tbl_jobcard_material.cutsize, tbl_jobcard_material.cutups, tbl_jobcard_material.upspersheet, tbl_jobcard_material.wastage, tbl_jobcard_material.batchno, tbl_jobcard_material.issueqty, tbl_print_material_info.materialname');
		$this->db->from('tbl_jobcard_material');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_material.tbl_print_material_info_idtbl_print_material_info', 'left');
		$this->db->where('tbl_jobcard_material.tbl_jobcard_idtbl_jobcard', $recordID);
		$this->db->where('tbl_jobcard_material.status', 1);

		$respondmaterial=$this->db->get();

        $this->db->select([
            'tbl_jobcard_color.colormaterialby',
            'tbl_jobcard_color.colortype',
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

        $this->db->select('tbl_jobcard_varnish.glossmatt, tbl_jobcard_varnish.fullspot, tbl_jobcard_varnish.varnishQty, tbl_jobcard_varnish.batchno, tbl_jobcard_varnish.issueqty, tbl_varnish.varnish, tbl_print_material_info.materialname');
		$this->db->from('tbl_jobcard_varnish');
        $this->db->join('tbl_varnish', 'tbl_varnish.idtbl_varnish = tbl_jobcard_varnish.tbl_varnish_idtbl_varnish', 'left');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_varnish.tbl_print_material_info_idtbl_print_material_info', 'left');
		$this->db->where('tbl_jobcard_varnish.tbl_jobcard_idtbl_jobcard', $recordID);
		$this->db->where('tbl_jobcard_varnish.status', 1);

		$respondvarnish=$this->db->get();  
        
        $this->db->select('tbl_jobcard_foil.foilmaterialby, tbl_jobcard_foil.qty, tbl_jobcard_foil.remark, tbl_jobcard_foil.batchno, tbl_jobcard_foil.issueqty, tbl_foiling.foiling, tbl_print_material_info.materialname');
		$this->db->from('tbl_jobcard_foil');
        $this->db->join('tbl_foiling', 'tbl_foiling.idtbl_foiling = tbl_jobcard_foil.tbl_foiling_idtbl_foiling', 'left');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_foil.tbl_print_material_info_idtbl_print_material_info', 'left');
		$this->db->where('tbl_jobcard_foil.tbl_jobcard_idtbl_jobcard', $recordID);
		$this->db->where('tbl_jobcard_foil.status', 1);

		$respondfoiling=$this->db->get();  

        $this->db->select(['tbl_jobcard_lamination.sides', 'tbl_jobcard_lamination.filmsize', 'tbl_jobcard_lamination.lamination_qty', 'tbl_jobcard_lamination.wastage', 'tbl_jobcard_lamination.batchno', 'tbl_jobcard_lamination.issueqty', 'tbl_lamination.lamination', 'tbl_print_material_info.materialname']);
		$this->db->from('tbl_jobcard_lamination');
        $this->db->join('tbl_lamination', 'tbl_lamination.idtbl_lamination = tbl_jobcard_lamination.tbl_lamination_idtbl_lamination', 'left');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_lamination.tbl_print_material_info_idtbl_print_material_info', 'left');
		$this->db->where('tbl_jobcard_lamination.tbl_jobcard_idtbl_jobcard', $recordID);
		$this->db->where('tbl_jobcard_lamination.status', 1);

		$respondlamination=$this->db->get();

        $this->db->select('tbl_jobcard_pasting.pastetype, tbl_jobcard_pasting.pasteqty, tbl_jobcard_pasting.remark, tbl_jobcard_pasting.batchno, tbl_jobcard_pasting.issueqty, tbl_machine.machine, tbl_print_material_info.materialname');
		$this->db->from('tbl_jobcard_pasting');
        $this->db->join('tbl_machine', 'tbl_machine.idtbl_machine = tbl_jobcard_pasting.tbl_machine_idtbl_machine', 'left');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_pasting.tbl_print_material_info_idtbl_print_material_info', 'left');
		$this->db->where('tbl_jobcard_pasting.tbl_jobcard_idtbl_jobcard', $recordID);
		$this->db->where('tbl_jobcard_pasting.status', 1);

		$respondpasting=$this->db->get();  

        $this->db->select(['tbl_jobcard_diecutting.channel', 'tbl_jobcard_diecutting.board', 'tbl_jobcard_diecutting.size', 'tbl_jobcard_diecutting.qty', 'tbl_jobcard_diecutting.diecutby', 'tbl_jobcard_diecutting.embossby']);
		$this->db->from('tbl_jobcard_diecutting');
		$this->db->where('tbl_jobcard_idtbl_jobcard', $recordID);
		$this->db->where('status', 1);

		$responddiecut=$this->db->get();

        $this->db->select(['tbl_jobcard_rimming.rimmingby', 'tbl_jobcard_rimming.sides', 'tbl_jobcard_rimming.qty', 'tbl_jobcard_rimming.remark', 'tbl_jobcard_rimming.batchno', 'tbl_jobcard_rimming.issueqty', 'tbl_rimming.rimming', 'tbl_print_material_info.materialname']);
		$this->db->from('tbl_jobcard_rimming');
        $this->db->join('tbl_rimming', 'tbl_rimming.idtbl_rimming = tbl_jobcard_rimming.tbl_rimming_idtbl_rimming', 'left');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_jobcard_rimming.tbl_print_material_info_idtbl_print_material_info', 'left');
		$this->db->where('tbl_jobcard_rimming.tbl_jobcard_idtbl_jobcard', $recordID);
		$this->db->where('tbl_jobcard_rimming.status', 1);

		$respondrimming=$this->db->get();

        $this->db->select('`perfoating`, `gattering`, `rimming`, `binding`, `stapling`, `padding`, `creasing`, `threading`');
		$this->db->from('tbl_jobcard_other');
		$this->db->where('tbl_jobcard_idtbl_jobcard', $recordID);
		$this->db->where('status', 1);

		$respondother=$this->db->get();

        $html = '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Material Allocate Note</title>
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

                /* Page break control for tables */
                table {
                    page-break-inside: auto;
                }
                
                tr {
                    page-break-inside: avoid;
                    page-break-after: auto;
                }
                
                thead {
                    display: table-header-group;
                }
                
                tfoot {
                    display: table-footer-group;
                }
                
                /** Define the footer rules **/
                footer {
                    position: fixed; 
                    bottom: 0px; 
                    left: 0px; 
                    right: 0px;
                    height: 128px;
                }

                /* Prevent sections from breaking in the middle */
                .section {
                    page-break-inside: avoid;
                }
                
                /* Force page break when needed */
                .page-break {
                    page-break-before: always;
                }
                
                /* Ensure content doesn`t break awkwardly */
                .no-break {
                    page-break-inside: avoid;
                }
            </style>
        </head>
        <body>
            <div class="section">
                <table width="100%" style="font-size: 12px;">
                    <tr>
                        <td colspan="2" style="text-align: center;">
                            <h3 style="margin: 0px;"><u>Job Material Allocation Information</u></h3>
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
                </table>
            </div>
            <div class="section">
                <table width="100%" style="font-size: 12px;">
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
                                        <th style="font-size: 12px;">By</th>
                                        <th style="font-size: 12px;">Material</th>
                                        <th style="font-size: 12px;text-align: center;">Cut Size</th>
                                        <th style="font-size: 12px;text-align: center;">Cut Up`s</th>
                                        <th style="font-size: 12px;text-align: center;">Up Sheets</th>
                                        <th style="font-size: 12px;text-align: center;">Batch No</th>
                                        <th style="font-size: 12px;text-align: center;">Issue Qty</th>
                                    </tr>
                                </thead>';
                                foreach($respondmaterial->result() as $rowmaterialdata){
                                $html.='
                                <tbody>
                                    <tr>
                                        <td style="font-size: 12px;">'.$rowmaterialdata->materialby.'</td>
                                        <td style="font-size: 12px;">'.$rowmaterialdata->materialname.'</td>
                                        <td style="font-size: 12px;text-align: center;">'.$rowmaterialdata->cutsize.'</td>
                                        <td style="font-size: 12px;text-align: center;">'.$rowmaterialdata->cutups.'</td>
                                        <td style="font-size: 12px;text-align: center;">'.$rowmaterialdata->upspersheet.'</td>
                                        <td style="font-size: 12px;text-align: center;">'.$rowmaterialdata->batchno.'</td>
                                        <td style="font-size: 12px;text-align: center;">'.$rowmaterialdata->issueqty.'</td>
                                    </tr>
                                </tbody>
                                ';
                                }
                            $html.='</table>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="section">
                <table width="100%" style="font-size: 12px;">
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <u>Printing Section</u>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <table class="table-sub">
                                <thead>
                                    <tr>
                                        <th>By</th>
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
                                        <td>'.$rowrespondcolordata->colormaterialby.'</td>
                                        <td>'.$rowrespondcolordata->colortype.'</td>
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
                </table>
            </div>
            <div class="section">
                <table width="100%" style="font-size: 12px;">
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
                                        <th>Gloss | Matt</th>
                                        <th>Full | Spot</th>
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
                                        <td>'.$rowvarnishdata->glossmatt.'</td>
                                        <td>'.$rowvarnishdata->fullspot.'</td>
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
                </table>
            </div>
            <div class="section">
                <table width="100%" style="font-size: 12px;">
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <u>Foiling Section</u>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <table class="table-sub">
                                <thead>
                                    <tr>
                                        <th>By</th>
                                        <th>Meterial</th>
                                        <th>Foil Type</th>
                                        <th>Remark</th>
                                        <th style="text-align: center">Qty</th>
                                        <th style="text-align: center">Batch No</th>
                                        <th style="text-align: center">Issue Qty</th>
                                    </tr>
                                </thead>';
                                foreach($respondfoiling->result() as $rowrespondfoilingdata){
                                $html.='
                                <tbody>
                                    <tr>
                                        <td>'.$rowrespondfoilingdata->foilmaterialby.'</td>
                                        <td>'.$rowrespondfoilingdata->materialname.'</td>
                                        <td>'.$rowrespondfoilingdata->foiling.'</td>
                                        <td>'.$rowrespondfoilingdata->remark.'</td>
                                        <td style="text-align: center">'.$rowrespondfoilingdata->qty.'</td>
                                        <td style="text-align: center">'.$rowrespondfoilingdata->batchno.'</td>
                                        <td style="text-align: center">'.$rowrespondfoilingdata->issueqty.'</td>
                                    </tr>
                                </tbody>
                                ';
                                }
                            $html.='</table>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="section">
                <table width="100%" style="font-size: 12px;">
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
                                        <th>Sides</th>
                                        <th style="font-size: 12px;text-align: center;">Qty(KG)</th>
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
                </table>
            </div>
            <div class="section">
                <table width="100%" style="font-size: 12px;">
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <u>Pasting Section</u>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <table class="table-sub">
                                <thead>
                                    <tr>
                                        <th>Meterial</th>
                                        <th>Machine</th>
                                        <th>Paste Type</th>
                                        <th>Remark</th>
                                        <th style="text-align: center">Qty(KG)</th>
                                        <th style="text-align: center">Batch No</th>
                                        <th style="text-align: center">Issue Qty</th>
                                    </tr>
                                </thead>';
                                foreach($respondpasting->result() as $rowrespondpastingdata){
                                $html.='
                                <tbody>
                                    <tr>
                                        <td>'.$rowrespondpastingdata->materialname.'</td>
                                        <td>'.$rowrespondpastingdata->machine.'</td>
                                        <td>'.$rowrespondpastingdata->pastetype.'</td>
                                        <td>'.$rowrespondpastingdata->remark.'</td>
                                        <td style="text-align: center">'.$rowrespondpastingdata->pasteqty.'</td>
                                        <td style="text-align: center">'.$rowrespondpastingdata->batchno.'</td>
                                        <td style="text-align: center">'.$rowrespondpastingdata->issueqty.'</td>
                                    </tr>
                                </tbody>
                                ';
                                }
                            $html.='</table>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="section">
                <table width="100%" style="font-size: 12px;">
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <u>Die Cutting Section</u>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <table class="table-sub">
                                <thead>
                                    <tr>
                                        <th>Channel</th>
                                        <th>Board</th>
                                        <th>Size</th>
                                        <th>Qty(m)</th>
                                        <th>Die cutting By</th>
                                        <th>Embossing</th>
                                    </tr>
                                </thead>';
                                foreach($responddiecut->result() as $rowresponddiecutdata){
                                $html.='
                                <tbody>
                                    <tr>
                                        <td>'.$rowresponddiecutdata->channel.'</td>
                                        <td>'.$rowresponddiecutdata->board.'</td>
                                        <td>'.$rowresponddiecutdata->size.'</td>
                                        <td>'.$rowresponddiecutdata->qty.'</td>
                                        <td>'.$rowresponddiecutdata->diecutby.'</td>
                                        <td>'.$rowresponddiecutdata->embossby.'</td>
                                    </tr>
                                </tbody>
                                ';
                                }
                            $html.='</table>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="section">
                <table width="100%" style="font-size: 12px;">
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
                                        <th>BY</th>
                                        <th>Rimming Type</th>
                                        <th>Material</th>
                                        <th>Remark</th>
                                        <th>Sides</th>
                                        <th style="font-size: 12px;text-align: center;">Qty</th>
                                        <th style="font-size: 12px;text-align: center;">Batch No</th>
                                        <th style="font-size: 12px;text-align: center;">Issue Qty</th>
                                    </tr>
                                </thead>';
                                foreach($respondrimming->result() as $rowrespondrimmingdata){
                                $html.='
                                <tbody>
                                    <tr>
                                        <td>'.$rowrespondrimmingdata->rimmingby.'</td>
                                        <td>'.$rowrespondrimmingdata->rimming.'</td>
                                        <td>'.$rowrespondrimmingdata->materialname.'</td>
                                        <td>'.$rowrespondrimmingdata->remark.'</td>
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
                </table>
            </div>
            <div class="section">
                <table width="100%" style="font-size: 12px;">
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
                                        <th>Perforating</th>
                                        <th>Gattering</th>
                                        <th>Rimming</th>
                                        <th>Binding</th>
                                        <th>Stapling</th>
                                        <th>Padding</th>
                                        <th>Creasing</th>
                                        <th>Threading</th>
                                    </tr>
                                </thead>';
                                foreach($respondother->result() as $rowrespondotherdata){
                                $html.='
                                <tbody>
                                    <tr>
                                        <td>'.$rowrespondotherdata->perfoating.'</td>
                                        <td>'.$rowrespondotherdata->gattering.'</td>
                                        <td>'.$rowrespondotherdata->rimming.'</td>
                                        <td>'.$rowrespondotherdata->binding.'</td>
                                        <td>'.$rowrespondotherdata->stapling.'</td>
                                        <td>'.$rowrespondotherdata->padding.'</td>
                                        <td>'.$rowrespondotherdata->creasing.'</td>
                                        <td>'.$rowrespondotherdata->threading.'</td>
                                    </tr>
                                </tbody>
                                ';
                                }
                            $html.='</table>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="section" style="border-radius: 10px; border: 1px solid #000;padding: 5px;">
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
            </div>
        </body>
        </html>';

        // echo $html;
        $this->load->library('pdf');

        $options = new Options();
		$options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("Material Allocate Note - ". $recordID .".pdf", ["Attachment"=>0]);
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
