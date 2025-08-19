<?php
class Qualitycheckinfo extends CI_Model{
    public function GRNqualityform(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `tbl_quality_subcategory`.`idtbl_quality_subcategory`, `tbl_quality_subcategory`.`qualitysubcategory`, `tbl_quality_subcategory`.`inputtype` FROM `tbl_quality_subcategory` LEFT JOIN `tbl_quality_category` ON `tbl_quality_category`.`idtbl_quality_category`=`tbl_quality_subcategory`.`tbl_quality_category_idtbl_quality_category` WHERE `tbl_quality_subcategory`.`status`=? AND `tbl_quality_category`.`idtbl_quality_category`=?";
        $respond=$this->db->query($sql, array(1, 1));

        $sqlgrn="SELECT `idtbl_print_grn`, `grndate` FROM `tbl_print_grn` WHERE `status`=? AND `idtbl_print_grn`=?";
        $respondgrn=$this->db->query($sqlgrn, array(1, $recordID));

        $sqlmaterial="SELECT `tbl_print_material_info`.`materialinfocode`, `tbl_print_material_info`.`idtbl_print_material_info`, `tbl_print_material_info`.`materialname`
        FROM `tbl_print_material_info`
        -- LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_print_material_info`.`tbl_material_code_idtbl_material_code`
        LEFT JOIN `tbl_print_grndetail` ON `tbl_print_grndetail`.`tbl_print_material_info_idtbl_print_material_info`=`tbl_print_material_info`.`idtbl_print_material_info`
        WHERE `tbl_print_grndetail`.`status`=? AND `tbl_print_grndetail`.`tbl_print_grn_idtbl_print_grn`=? 
        AND `tbl_print_material_info`.`idtbl_print_material_info` NOT IN (SELECT `tbl_print_material_info_idtbl_print_material_info` FROM `tbl_quality_info` WHERE `status`=? AND `tbl_print_grn_idtbl_print_grn`=?)";
        $respondmaterial=$this->db->query($sqlmaterial, array(1, $recordID, 1, $recordID));

        $r=1;
        $html='';

        $html.='
        <div class="form-row">
            <div class="col">
                <label class="small font-weight-bold text-dark">GRN#</label>
                <input type="text" name="grn" id="grn" class="form-control form-control-sm" value="'.$respondgrn->row(0)->idtbl_print_grn.'" readonly>
            </div>
            <div class="col">
                <label class="small font-weight-bold text-dark">GRN DATE</label>
                <input type="text" name="grndate" id="grndate" class="form-control form-control-sm" value="'.$respondgrn->row(0)->grndate.'" readonly>
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <label class="small font-weight-bold text-dark">ITEM DESCRIPTION</label>
                <textarea name="itemdesc" id="itemdesc" class="form-control form-control-sm"></textarea>
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <label class="small font-weight-bold text-dark">Material</label>
                <select name="materialinfo" id="materialinfo" class="form-control form-control-sm">
                    <option value="">Select</option>';
                    foreach($respondmaterial->result() AS $rowmateriallist){
                        $html.='<option value="'.$rowmateriallist->idtbl_print_material_info.'">'.$rowmateriallist->materialname.' - '.$rowmateriallist->materialinfocode.'</option>';
                    }
                $html.='</select>
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <label class="small font-weight-bold text-dark">GRN QUANTITY</label>
                <input type="text" name="grnqty" id="grnqty" class="form-control form-control-sm" value="" readonly>
            </div>
            <div class="col">
                <label class="small font-weight-bold text-dark">PACKAGE DETAILS (GRN)</label>
                <input type="text" name="grnpackinfo" id="grnpackinfo" class="form-control form-control-sm" value="">
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <label class="small font-weight-bold text-dark">ACTUAL QUANTITY</label>
                <input type="text" name="actualqty" id="actualqty" class="form-control form-control-sm" value="">
            </div>
            <div class="col">
                <label class="small font-weight-bold text-dark">PACKAGE DETAILS (ACTUAL)</label>
                <input type="text" name="actualpackinfo" id="actualpackinfo" class="form-control form-control-sm" value="">
            </div>
        </div>
        ';

        foreach($respond->result() as $rowqualitylist){
            if($rowqualitylist->inputtype==1){
                $html.='
                <div class="form-row">
                    <div class="col">
                        <label class="small font-weight-bold text-dark">'.$rowqualitylist->qualitysubcategory.'</label>
                        <input type="text" name="qualityform'.$rowqualitylist->idtbl_quality_subcategory.'" class="form-control form-control-sm">
                        <input type="hidden" name="qualityformhide[]" value="'.$rowqualitylist->idtbl_quality_subcategory.'">
                    </div>
                </div>
                ';
            }
            else if($rowqualitylist->inputtype==2){
                $html.='
                <label class="small font-weight-bold text-dark">'.$rowqualitylist->qualitysubcategory.'</label><br>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="passfail'.$r.'" name="qualityform'.$rowqualitylist->idtbl_quality_subcategory.'" class="custom-control-input" value="1">
                    <label class="custom-control-label" for="passfail'.$r.'">Pass</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="passfailsecond'.$r.'" name="qualityform'.$rowqualitylist->idtbl_quality_subcategory.'" class="custom-control-input" value="0" checked>
                    <label class="custom-control-label" for="passfailsecond'.$r.'">Fail</label>
                </div>
                <input type="hidden" name="qualityformhide[]" value="'.$rowqualitylist->idtbl_quality_subcategory.'">
                ';
            }
            else if($rowqualitylist->inputtype==3){

            }
            else if($rowqualitylist->inputtype==4){
                $html.='
                <div class="form-row">
                    <div class="col">
                        <label class="small font-weight-bold text-dark">'.$rowqualitylist->qualitysubcategory.'</label>
                        <textarea name="qualityform'.$rowqualitylist->idtbl_quality_subcategory.'" class="form-control form-control-sm"></textarea>
                    </div>
                </div>
                <input type="hidden" name="qualityformhide[]" value="'.$rowqualitylist->idtbl_quality_subcategory.'">
                ';
            }
            if($rowqualitylist->inputtype==5){
                $html.='
                <div class="form-row">
                    <div class="col">
                        <label class="small font-weight-bold text-dark">'.$rowqualitylist->qualitysubcategory.'</label>
                        <input type="datetime-local" name="qualityform'.$rowqualitylist->idtbl_quality_subcategory.'" class="form-control form-control-sm">
                        <input type="hidden" name="qualityformhide[]" value="'.$rowqualitylist->idtbl_quality_subcategory.'">
                    </div>
                </div>
                ';
            }
            $r++;
        }

        echo $html;
    }
    public function GRNqualityinsertupdate(){
        $this->db->trans_begin();
        // $fieldlist=$this->input->post('qualityform');
        $grnid=$this->input->post('hidegrnid');
        $grndate=$this->input->post('grndate');
        $materialinfo=$this->input->post('materialinfo');
        $grnpackinfo=$this->input->post('grnpackinfo');
        $actualqty=$this->input->post('actualqty');
        $actualpackinfo=$this->input->post('actualpackinfo');
        $itemdesc=$this->input->post('itemdesc');
        $qualityformhide=$this->input->post('qualityformhide');
        $qualitycategoryID=1;

        $userID=$_SESSION['userid'];
        $updatedatetime=date('Y-m-d H:i:s');

        $i=0;
        foreach($qualityformhide as $subcategorylist){
            $descorstatus=$this->input->post('qualityform'.$subcategorylist);
            $subcategoryID=$subcategorylist;

            $data = array(
                'descstatus'=> $descorstatus, 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime,
                // 'tbl_production_material_idtbl_production_material'=> '', 
                'tbl_print_material_info_idtbl_print_material_info'=> $materialinfo, 
                'tbl_print_grn_idtbl_print_grn'=> $grnid, 
                'tbl_quality_category_idtbl_quality_category'=> $qualitycategoryID, 
                'tbl_quality_subcategory_idtbl_quality_subcategory'=> $subcategoryID,
                'tbl_user_idtbl_user'=> $userID
            );

            $this->db->insert('tbl_quality_info', $data);

            $i++;
        }

        $data = array(
            'actualqty'=> $actualqty, 
            'packgrn'=> $grnpackinfo, 
            'packactual'=> $actualpackinfo, 
            'itemdesc'=> $itemdesc,
            'updateuser'=> $userID, 
            'updatedatetime'=> $updatedatetime, 
        );

        $this->db->where('tbl_print_grn_idtbl_print_grn', $grnid);
        $this->db->where('tbl_print_material_info_idtbl_print_material_info', $materialinfo);
        $this->db->update('tbl_print_grndetail', $data);


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

    public function Qualitycheckstatus($x, $y){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $recordID=$x;
        $type=$y;
        $updatedatetime=date('Y-m-d H:i:s');

        if($type==1){
            $data = array(
                'qualitycheck' => '1',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_print_grn', $recordID);
            $this->db->update('tbl_print_grn', $data);

            $this->db->select('`batchno`, `tbl_print_porder_idtbl_print_porder`');
            $this->db->from('tbl_print_grn');
            $this->db->where('status', 1);
            $this->db->where('idtbl_print_grn', $recordID);

            $respondgrn=$this->db->get();

            $porderID=$respondgrn->row(0)->tbl_print_porder_idtbl_print_porder;

            $dataporder = array(
                'grnconfirm' => '1',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_print_porder', $porderID);
            $this->db->update('tbl_print_porder', $dataporder);

            $this->db->select('`actualqty`, `tbl_print_material_info_idtbl_print_material_info`');
            $this->db->from('tbl_print_grndetail');
            $this->db->where('status', 1);
            $this->db->where('tbl_print_grn_idtbl_print_grn', $recordID);

            $respond=$this->db->get();

            foreach($respond->result() as $grnproductlist){
                $batchno=$respondgrn->row(0)->batchno;
                $qty=$grnproductlist->actualqty;
                $materialID=$grnproductlist->tbl_print_material_info_idtbl_print_material_info;

                $sqlcheck="SELECT `qty` FROM `tbl_print_stock` WHERE `tbl_print_material_info_idtbl_print_material_info`=? AND `batchno`=? AND `status`=?";
                $respondcheck=$this->db->query($sqlcheck, array($materialID, $batchno, 1));
                
                if(empty($respondcheck->row(0)->qty)){
                    $data = array(
                        'batchno'=>$batchno, 
                        'qty'=>$qty, 
                        'status'=>'1', 
                        'insertdatetime'=>$updatedatetime, 
                        'tbl_user_idtbl_user'=>$userID, 
                        'tbl_print_material_info_idtbl_print_material_info'=>$materialID
                    );
                    $respond= $this->db->insert('tbl_print_stock', $data);
                }
                else{
                    $newqty=$respondcheck->row(0)->qty+$qty;

                    $data = array( 
                        'qty'=>$newqty,
                        'updateuser'=>$userID,
                        'updatedatetime'=>$updatedatetime
                    );
                    $this->db->where('batchno', $batchno);
                    $this->db->where('tbl_print_material_info_idtbl_print_material_info', $materialID);
                    $respond = $this->db->update('tbl_print_stock', $data);
                }
            }

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
                redirect('Qualitycheck');                
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
                redirect('Qualitycheck');
            }
        }
    }

    public function Getqualityviewdescription(){

        $recordID=$this->input->post('recordID');
        $html='';

        $sql="SELECT IFNULL(`tblel`.`ds`, `tbl_quality_info`.`descstatus`) As descstatus,`tbl_quality_subcategory`.`qualitysubcategory` FROM `tbl_quality_info` 
        LEFT JOIN `tbl_quality_subcategory` ON `tbl_quality_subcategory`.`idtbl_quality_subcategory`=`tbl_quality_info`.`tbl_quality_subcategory_idtbl_quality_subcategory`
        LEFT JOIN(SELECT 1 AS type, 'PASS' AS ds, 2 As el UNION ALL SELECT 0 AS type, 'FAIL' AS ds, 2 As el) As tblel ON (`tbl_quality_info`.`descstatus`=`tblel`.`type` AND `tbl_quality_subcategory`.`inputtype`=`tblel`.`el`)
        WHERE `tbl_quality_info`.`tbl_print_grn_idtbl_print_grn`=? AND `tbl_quality_info`.`status`=?";

        $respond=$this->db->query($sql, array($recordID, 1));

        foreach($respond->result() as $rowlist){
            $html.='

            <ul>
                <li>

                    <label for="">'.$rowlist->qualitysubcategory.' : <span>&nbsp;'.$rowlist->descstatus.'</span></label>
                </li>
            </ul>

            
            ';
        }

        echo $html;
    }

    public function Editqualityinfo(){
        $recordID=$this->input->post('recordID');

        $updatesql="SELECT `tbl_quality_info`.`tbl_print_grn_idtbl_print_grn`, `tbl_print_material_info`.`idtbl_print_material_info`,`tbl_print_material_info`.`materialinfocode`, `tbl_quality_info`.`descstatus`, `tbl_quality_subcategory`.`idtbl_quality_subcategory`, `tbl_quality_subcategory`.`qualitysubcategory`, `tbl_quality_subcategory`.`inputtype` FROM `tbl_quality_subcategory`
        LEFT JOIN `tbl_quality_info` ON `tbl_quality_subcategory`.`idtbl_quality_subcategory`=`tbl_quality_info`.`tbl_quality_subcategory_idtbl_quality_subcategory`
    LEFT JOIN `tbl_print_material_info` ON `tbl_print_material_info`.`idtbl_print_material_info`=`tbl_quality_info`.`tbl_print_material_info_idtbl_print_material_info`     
       LEFT JOIN `tbl_quality_category` ON `tbl_quality_category`.`idtbl_quality_category`=`tbl_quality_subcategory`.`tbl_quality_category_idtbl_quality_category` WHERE `tbl_quality_subcategory`.`status`=? AND `tbl_quality_category`.`idtbl_quality_category`=? AND `tbl_quality_info`.`tbl_print_grn_idtbl_print_grn`=? AND `tbl_quality_info`.`status`=?";
        $updaterespond=$this->db->query($updatesql, array(1, 1, $recordID, 1));

        $updatesql="SELECT `tbl_print_material_info`.`idtbl_print_material_info`,`tbl_print_material_info`.`materialinfocode`, `tbl_quality_info`.`descstatus`, `tbl_quality_subcategory`.`idtbl_quality_subcategory`, `tbl_quality_subcategory`.`qualitysubcategory`, `tbl_quality_subcategory`.`inputtype` FROM `tbl_quality_subcategory`
        LEFT JOIN `tbl_quality_info` ON `tbl_quality_subcategory`.`idtbl_quality_subcategory`=`tbl_quality_info`.`tbl_quality_subcategory_idtbl_quality_subcategory`
    LEFT JOIN `tbl_print_material_info` ON `tbl_print_material_info`.`idtbl_print_material_info`=`tbl_quality_info`.`tbl_print_material_info_idtbl_print_material_info`     
       LEFT JOIN `tbl_quality_category` ON `tbl_quality_category`.`idtbl_quality_category`=`tbl_quality_subcategory`.`tbl_quality_category_idtbl_quality_category` WHERE `tbl_quality_subcategory`.`status`=? AND `tbl_quality_category`.`idtbl_quality_category`=? AND `tbl_quality_info`.`tbl_print_grn_idtbl_print_grn`=? AND `tbl_quality_info`.`status`=?";
        $updaterespond=$this->db->query($updatesql, array(1, 1, $recordID, 1));

        $editsqlgrn="SELECT `idtbl_print_grn`, `grndate` FROM `tbl_print_grn` WHERE `status`=? AND `idtbl_print_grn`=?";
        $editrespondgrn=$this->db->query($editsqlgrn, array(1, $recordID));

        $r=1;
        $html='';

        $html.='
        <div class="form-row">
            <div class="col">
                <label class="small font-weight-bold text-dark">GRN#</label>
                <input type="text" name="grn" id="grn" class="form-control form-control-sm" value="'.$editrespondgrn->row(0)->idtbl_print_grn.'" readonly>
            </div>
            <div class="col">
                <label class="small font-weight-bold text-dark">GRN DATE</label>
                <input type="text" name="grndate" id="grndate" class="form-control form-control-sm" value="'.$editrespondgrn->row(0)->grndate.'" readonly>
            </div>
        </div>
        ';
        foreach($updaterespond->result() as $rowupdatequalitylist){
            if($rowupdatequalitylist->inputtype==1){
                $html.='
                <div class="form-row">
                <div class="col">
                    <label class="small font-weight-bold text-dark d-none">Material</label>
                    <input type="text" name="hidematerialinfo" id="hidematerialinfo" class="form-control form-control-sm d-none" value="'.$rowupdatequalitylist->idtbl_print_material_info.'">
                </div>
            </div>
                <div class="form-row">
                    <div class="col">
                        <label class="small font-weight-bold text-dark">'.$rowupdatequalitylist->qualitysubcategory.'</label>
                        <input type="text" name="editqualityform'.$rowupdatequalitylist->idtbl_quality_subcategory.'" value="'.$rowupdatequalitylist->descstatus.'" class="form-control form-control-sm">
                        <input type="hidden" name="editqualityformhide[]" value="'.$rowupdatequalitylist->idtbl_quality_subcategory.'">
                    </div>
                </div>
                ';
            }
            else if($rowupdatequalitylist->inputtype==2){
                $html.='
                <label class="small font-weight-bold text-dark">'.$rowupdatequalitylist->qualitysubcategory.'</label><br>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="passfail'.$r.'" name="editqualityform'.$rowupdatequalitylist->idtbl_quality_subcategory.'" class="custom-control-input" value="1">
                    <label class="custom-control-label" for="passfail'.$r.'">Pass</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="passfailsecond'.$r.'" name="editqualityform'.$rowupdatequalitylist->idtbl_quality_subcategory.'" class="custom-control-input" value="0" checked>
                    <label class="custom-control-label" for="passfailsecond'.$r.'">Fail</label>
                </div>
                <input type="hidden" name="editqualityformhide[]" value="'.$rowupdatequalitylist->idtbl_quality_subcategory.'">
                ';
            }
            else if($rowupdatequalitylist->inputtype==3){

            }
            else if($rowupdatequalitylist->inputtype==4){
                $html.='
                <div class="form-row">
                    <div class="col">
                        <label class="small font-weight-bold text-dark">'.$rowupdatequalitylist->qualitysubcategory.'</label>
                        <textarea name="editqualityform'.$rowupdatequalitylist->idtbl_quality_subcategory.'" value="'.$rowupdatequalitylist->descstatus.'" class="form-control form-control-sm"></textarea>
                    </div>
                </div>
                <input type="hidden" name="editqualityformhide[]" value="'.$rowupdatequalitylist->idtbl_quality_subcategory.'">
                ';
            }
            if($rowupdatequalitylist->inputtype==5){
                $html.='
                <div class="form-row">
                    <div class="col">
                        <label class="small font-weight-bold text-dark">'.$rowupdatequalitylist->qualitysubcategory.'</label>
                        <input type="datetime-local" name="qualityform'.$rowupdatequalitylist->idtbl_quality_subcategory.'" value="'.$rowupdatequalitylist->descstatus.'" class="form-control form-control-sm">
                        <input type="hidden" name="qualityformhide[]" value="'.$rowupdatequalitylist->idtbl_quality_subcategory.'">
                    </div>
                </div>
                ';
            }
            $r++;
        }
        echo $html;
    }

    public function NewGRNinsertupdate(){
        $this->db->trans_begin();
        // $fieldlist=$this->input->post('qualityform');
        $editedproductionmaterial=$this->input->post('editedproductionmaterial');
        $editmainpassfail=$this->input->post('editmainpassfail');
        $editqualityformhide=$this->input->post('editqualityformhide');
        $editmaterialinfo=$this->input->post('hidematerialinfo');
        $editedgrnid=$this->input->post('editedgrnid');
        $editqualitycategoryID=1;

        $userID=$_SESSION['userid'];
        $updatedatetime=date('Y-m-d H:i:s');

        // $this->db->where('tbl_print_grn_idtbl_print_grn', $editedgrnid);
        // $this->db->delete('tbl_quality_info');

        $data = array( 
            'status'=> 3,

        );
        $this->db->where('tbl_print_grn_idtbl_print_grn', $editedgrnid);
        $respond = $this->db->update('tbl_quality_info', $data);

        $i=0;
        foreach($editqualityformhide as $editsubcategorylist){
            $editdescorstatus=$this->input->post('editqualityform'.$editsubcategorylist);
            $editsubcategoryID=$editsubcategorylist;

            $data = array(
                'descstatus'=> $editdescorstatus, 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime,
                // 'tbl_production_material_idtbl_production_material'=> '', 
                'tbl_print_material_info_idtbl_print_material_info'=> $editmaterialinfo, 
                'tbl_print_grn_idtbl_print_grn'=> $editedgrnid,
                'tbl_quality_category_idtbl_quality_category'=> $editqualitycategoryID, 
                'tbl_quality_subcategory_idtbl_quality_subcategory'=> $editsubcategoryID,
                'tbl_user_idtbl_user'=> $userID
            );

            $this->db->insert('tbl_quality_info', $data);

            $i++;
        }


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
    public function Getmaterialqtyaccomaterialid(){
        $recordID=$this->input->post('recordID');
        $grnID=$this->input->post('grnID');

        $sql="SELECT `qty` FROM `tbl_print_grndetail` WHERE `tbl_print_grn_idtbl_print_grn`=? AND `tbl_print_material_info_idtbl_print_material_info`=?";
        $respond=$this->db->query($sql, array($grnID, $recordID));

        echo $respond->row(0)->qty;
    }

    public function Getmaterialinfo(){

        $recordID=$this->input->post('recordID');
        $html='';

        $sql="SELECT `tbl_print_grn`.`idtbl_print_grn`, `tbl_print_material_info`.`idtbl_print_material_info`, `tbl_print_material_info`.`materialinfocode` FROM `tbl_quality_info`
        LEFT JOIN `tbl_print_grn` ON `tbl_print_grn`.`idtbl_print_grn`=`tbl_quality_info`.`tbl_print_grn_idtbl_print_grn`
       LEFT JOIN `tbl_print_material_info` ON `tbl_print_material_info`.`idtbl_print_material_info`=`tbl_quality_info`.`tbl_print_material_info_idtbl_print_material_info` WHERE `tbl_quality_info`.`tbl_print_grn_idtbl_print_grn`=? AND `tbl_quality_info`.`status`=? GROUP BY `tbl_quality_info`.`tbl_print_material_info_idtbl_print_material_info`";

        $respond=$this->db->query($sql, array($recordID, 1));


        foreach($respond->result() as $rowlist){
            $html .= '
              <tr>
              	<td>' . $rowlist->materialinfocode . '</td>
              	<td>
                  <a href="' . base_url() . 'Qualitycheck/Qualitycheckreport/' . $rowlist->idtbl_print_grn . '/' . $rowlist->idtbl_print_material_info .'"
                  class="btn btn-warning btn-sm float-right ml-1" target="_blank"><i class="fas fa-file"></i></a>
              		<button type="button" id="' . $rowlist->idtbl_print_grn . '"
              			class="btnViewqualityinfo btn btn-primary btn-sm float-right" data-toggle="modal"
              			data-target="#exampleModal">
              			<i class="fas fa-eye"></i>
              		</button>
              	</td>
              </tr>
            ';
        }
        

        echo $html;
    }

}