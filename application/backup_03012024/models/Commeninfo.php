<?php
class Commeninfo extends CI_Model{
    public function Getmenuprivilege(){
        $userID=$_SESSION['userid'];

        $menuprivilegearray=array();
    
        $sql="SELECT `idtbl_menu_list`, `menu` FROM `tbl_menu_list` WHERE `status`=?";
        $respond=$this->db->query($sql, array(1));
        
        foreach($respond->result() as $row){
            $menucheckID=$row->idtbl_menu_list;
            $menuname=str_replace(" ","_",$row->menu);
            
            $sqlprivilegecheck="SELECT `create`, `update`, `statuschange`, `delete`, `view`, `idtbl_menu` FROM `permissions_machines` WHERE `idtbl_user_tbl_user`=? AND `idtbl_menu`=? AND `status`=?";
            $respondprivilegecheck=$this->db->query($sqlprivilegecheck, array($userID, $menucheckID, 1));
            
            if($respondprivilegecheck->num_rows()>0){
                $objmenu=new stdClass();
                $objmenu->add=$respondprivilegecheck->row(0)->create;
                $objmenu->edit=$respondprivilegecheck->row(0)->update;
                $objmenu->statuschange=$respondprivilegecheck->row(0)->statuschange;
                $objmenu->remove=$respondprivilegecheck->row(0)->delete;
                $objmenu->access_status=$respondprivilegecheck->row(0)->view;
                $objmenu->menuid=$respondprivilegecheck->row(0)->idtbl_menu;
                array_push($menuprivilegearray, $objmenu);
            }
        }

        return $menuprivilegearray;
    }
}