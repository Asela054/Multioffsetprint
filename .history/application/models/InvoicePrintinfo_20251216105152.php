<?php
class InvoicePrintinfo extends CI_Model{

    public function Printinvoice($x){
        $recordID=$x;
        $sql =" SELECT * FROM `tbl_print_porder` 
        LEFT JOIN `tbl_supplier` ON `tbl_supplier`.`idtbl_supplier` = `tbl_print_porder`.`tbl_supplier_idtbl_supplier` 
        WHERE `idtbl_print_porder` = '$recordID'";
        $respond=$this->db->query($sql, array(1, $recordID));

        if ($respond->num_rows() > 0) {
            $company_id = $respond->row(0)->tbl_company_idtbl_company;
        
            $prefix = 'MO';
            if ($company_id == 2) {
                $prefix = 'FT';
            } elseif ($company_id == 3) {
                $prefix = 'RM';
            }
        }

        $this->db->select('tbl_company.company AS companyname,tbl_company.address1 As companyaddress,tbl_company.mobile AS companymobile,
                                tbl_company.phone companyphone,tbl_company.email AS companyemail,
                                tbl_company_branch.branch AS branchname');
		$this->db->from('tbl_print_porder');
		$this->db->join('tbl_company', 'tbl_company.idtbl_company = tbl_print_porder.tbl_company_idtbl_company', 'left');
        $this->db->join('tbl_company_branch', 'tbl_company_branch.idtbl_company_branch = tbl_print_porder.tbl_company_branch_idtbl_company_branch', 'left');
		$this->db->where('tbl_print_porder.idtbl_print_porder', $recordID);
		$companydetails = $this->db->get();

        $net = sprintf('%0.2f', $respond->row(0)->nettotal);
    
        $sql2="SELECT 
        `tbl_print_porder_detail`.*,
        `tbl_print_porder`.*,
        `tbl_print_material_info`.`materialinfocode`,
        `tbl_print_material_info`.`materialname`,
        `tbl_measurements`.`measure_type`,
        `tbl_material_group`.`idtbl_material_group`
        FROM `tbl_print_porder`
        LEFT JOIN `tbl_print_porder_detail` ON `tbl_print_porder`.`idtbl_print_porder` = `tbl_print_porder_detail`.`tbl_print_porder_idtbl_print_porder`
        LEFT JOIN `tbl_material_group` ON `tbl_material_group`.`idtbl_material_group` = `tbl_print_porder`.`tbl_material_group_idtbl_material_group`
        LEFT JOIN `tbl_print_material_info` ON `tbl_print_material_info`.`idtbl_print_material_info` = `tbl_print_porder_detail`.`tbl_material_id`
        LEFT JOIN `tbl_measurements` ON `tbl_measurements`.`idtbl_mesurements` = `tbl_print_porder_detail`.`tbl_measurements_idtbl_measurements`
        WHERE 
        `tbl_print_porder_detail`.`status` = '1'
        AND `tbl_print_porder`.`idtbl_print_porder` = '$recordID'";
        $respond2=$this->db->query($sql2, array(1, $recordID));

        $dataArray = [];
        $count = 0;
        $section = 1;
        foreach ($respond2->result() as $rowlist) {
            $unitPrice = !empty($rowlist->packetprice) ? $rowlist->packetprice : $rowlist->unitprice;
        
            $nettotal = $unitPrice * $rowlist->qty;
            $materialInfoCode = $rowlist->materialinfocode;
            if ($rowlist->idtbl_material_group == 4) {
                $itemDescription = $rowlist->comment;
            } else {
                $itemDescription = $rowlist->materialname;
            }
            $qty = $rowlist->qty;
            $measureType = $rowlist->measure_type;
    
        
            if ($count % 5 == 0) {
                $dataArray[$section] = [];
            }
        
            $dataArray[$section][] = [
                'materialInfoCode' => $materialInfoCode,
                'itemDescription' => $itemDescription,
                'qty' => $qty,
                'measureType' => $measureType,
                'unitPrice' => $unitPrice,
                'nettotal' => $nettotal
            ];
        
            $count++;
        
            if ($count % 5 == 0) {
                $section++;
            }
        }        



        $htmlcusdetail='';
        $travelinfotbl='';
        $additional ='';
        $chequeinfotbl ='';
        $cashinfotbl ='';

        $tpnumber='&nbsp;';
        if(strlen($respond->row(0)->telephone_no)>=9){$tpnumber=$respond->row(0)->telephone_no;}
        

        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Multi Offset Printers</title>
            <style>
                @page {
                    size: 220mm 140mm;
                    margin: 5mm 5mm 5mm 5mm; /* top right bottom left */
                    font-family: Arial, sans-serif;
                }
                body {
                    font-family: Arial, sans-serif;
                    line-height: 1.5;
                    text-align:left;
                    margin-top: 160px;
                }

                /** Define the header rules **/
                header {
                    position: fixed;
                    top: 0px;
                    left: 0px;
                    right: 0px;
                    height: 250px;
                }

                /** Define the footer rules **/
                footer {
                    position: fixed; 
                    bottom: 0px; 
                    left: 0px; 
                    right: 0px;
                    height: 100px;
                }
            </style>
        </head>
        <body>
            <header>
                <table style="width:100%;border-collapse: collapse;">
                    <tr>
$address = '';

if (!empty($respond->row(0)->address_line1)) {
    $address .= '<p style="margin:0px;font-size:13px;padding-left:24px;">'
              . $respond->row(0)->address_line1 . ',</p>';
}

if (!empty($respond->row(0)->address_line2)) {
    $address .= '<p style="margin:0px;font-size:13px;padding-left:24px;">'
              . $respond->row(0)->address_line2 . ',</p>';
}

if (!empty($respond->row(0)->city)) {
    $address .= '<p style="margin:0px;font-size:13px;padding-left:24px;">'
              . $respond->row(0)->city . '.</p>';
}

if (!empty($tpnumber)) {
    $address .= '<p style="margin:0px;font-size:13px;padding-left:24px;">'
              . $tpnumber . '</p>';
}

echo '
<td width="55%" style="vertical-align: top;padding:0px;">
    <p style="margin:0px;font-size:16px;font-weight:bold;">PURCHASE ORDER</p>
    <p style="margin:0px;font-size:13px;font-weight:bold;">
        To: '.$respond->row(0)->suppliername.'
    </p>
    '.$address.'
    <p style="font-size:13px;">Atten ....................................................</p>
</td>';

                        <td style="vertical-align: top;padding:0px;">
                            <p style="margin:0px;font-size:18px;font-weight:bold;text-transform: uppercase;">'.$companydetails->row()->companyname.'</p>
                            <p style="margin:0px;font-size:13px;font-weight:normal;text-transform: uppercase;">'.$companydetails->row()->companyaddress.'</p>
                            <p style="margin:0px;font-size:13px;font-weight:normal;">Phone : '.$companydetails->row()->companymobile.'/'.$companydetails->row()->companyphone.'</p>
                            <p style="margin:0px;font-size:13px;font-weight:normal;"><u>E-Mail : '.$companydetails->row()->companyemail.'</u></p>
                            <p style="margin:0px;font-size:13px;font-weight:normal;">PO No : ' . $prefix . '/' . $respond->row(0)->porder_no . '</p>
                            <p style="margin:0px;font-size:13px;font-weight:normal;">Date : '.$respond->row(0)->orderdate.'</p>
                            '.($respond->num_rows() > 0 && $company_id == 1 ? '<p style="margin:0px;font-size:13px;font-weight:normal;">Our Vat No : &nbsp; 103305667-7000</p>' : '').'
                        </td>
                    </tr>
                </table>
            </header>

            <footer>
                <table style="width:100%;">
                    <tr>
                        <td style="vertical-align: top;">
                            <table style="width:100%;font-size:12px;margin-top: 15px;">
                                <tr>
                                    <td>Prepared by</td>
                                    <td style="width: 5%;">:</td>
                                    <td>...................................</td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 15px;">Checked by</td>
                                    <td style="width: 5%;padding-top: 15px;">:</td>
                                    <td style="padding-top: 15px;">...................................</td>
                                </tr>
                            </table>
                        </td>
                        <td style="vertical-align: top;">
                            <table style="width:100%;font-size:12px;margin-top: 15px;">
                                <tr>
                                    <td>Contact Person</td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 15px;">Contact No</td>
                                </tr>
                            </table>
                        </td>
                        <td style="text-align: center;vertical-align: top;">
                            <p style="margin:0;font-size:12px;text-transform: uppercase;font-weight: bold;">'.$companydetails->row()->companyname.'</p>
                            <p style="margin:0;margin-top:25px;font-size:12px;">..........................................................</p>
                            <p style="margin:0;font-size:12px;">Authorise Officer</p>
                        </td>
                    </tr>
                </table>
            </footer>';

            foreach ($dataArray as $index => $section) {
                $html.='<main>
                    <table style="table-layout: fixed;padding:3px;width:100%;border-collapse: collapse;font-size: 13px;">
                        <thead>
                            <tr>
                                <th style="width: 10%;text-align:center; border: 1px solid #000;">Code</th>
                                <th style="width: 40%;text-align:center; border: 1px solid #000;">Item Description </th>
                                <th style="width: 10%;text-align:center; border: 1px solid #000;">Quantity</th>
                                <th style="width: 10%;text-align:center; border: 1px solid #000;">UOM</th>
                                <th style="width: 15%;text-align:right; border: 1px solid #000;padding-right: 10px;">Unit Price</th>
                                <th style="width: 15%;text-align:right; border: 1px solid #000;padding-right: 10px;">Total</th>
                            </tr>
                        </thead>
                        <tbody>';
                            foreach ($section as $row) {
                                $html .= '<tr>
                                    <td style="width: 10%; text-align:center; border-right: 1px solid black; border-left: 1px solid #000;">' . htmlspecialchars($row['materialInfoCode']) . '</td>
                                    <td style="width: 40%; border-right: 1px solid black; padding-left: 10px;">' . htmlspecialchars($row['itemDescription']) . '</td>
                                    <td style="width: 10%; text-align:center; border-right: 1px solid black;">' . htmlspecialchars($row['qty']) . '</td>
                                    <td style="width: 10%; text-align:center; border-right: 1px solid black;">' . htmlspecialchars($row['measureType']) . '</td>
                                    <td style="width: 15%; text-align:right; border-right: 1px solid black;padding-right: 10px;">' . htmlspecialchars(number_format($row['unitPrice'],2)) . '</td>
                                    <td style="width: 15%; text-align:right; border-right: 1px solid black;padding-right: 10px;">' . htmlspecialchars(number_format($row['nettotal'],2)) . '</td>
                                </tr>';
                            }
                        $html.='</tbody>';
                        if ($index === count($dataArray) - 1) {
                            $html .= '<tfoot>
                                <tr>
                                    <td colspan="2" style="border-top: 1px solid #000;font-size:12px;">PRF INV DETAILS.</td>
                                    <td colspan="2" style="border-top: 1px solid #000;border-left: 1px solid #000;border-right: 1px solid #000;text-align:left;padding-left:35px;">Total (Excl)</td>
                                    <td colspan="2" style="border-top: 1px solid #000;border-left: 1px solid #000;border-right: 1px solid #000;text-align:right;padding-right:10px;"><label id="lbltotal"></label></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="font-size:11px;">IP REF</td>
                                    <td colspan="2" style="border-left: 1px solid #000;border-right: 1px solid #000;text-align:left;padding-left:35px;">Tax</td>
                                    <td colspan="2" style="border-left: 1px solid #000;border-right: 1px solid #000;text-align:right;"><label class="padding-right:10px;" id="lbldiscount"></label></td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="2" style="border-bottom: 1px solid #000;border-left: 1px solid #000;border-right: 1px solid #000;text-align:left; font-weight:bold;padding-left:35px;">Total (Incl)</td>
                                    <th colspan="2" style="border-bottom: 1px solid #000;border-left: 1px solid #000;border-right: 1px solid #000;text-align:right;padding-right:10px;"><label class="font-weight-bold text-dark" id="lblbalance"></label></th>
                                </tr>
                            </tfoot>';
                        } else {
                            $html .= '<tfoot>
                                <tr>
                                    <td colspan="2" style="border-top: 1px solid #000;font-size:12px;">PRF INV DETAILS.</td>
                                    <td colspan="2" style="border-top: 1px solid #000;border-left: 1px solid #000;border-right: 1px solid #000;text-align:left;padding-left:35px;">Total (Excl)</td>
                                    <td colspan="2" style="border-top: 1px solid #000;border-left: 1px solid #000;border-right: 1px solid #000;text-align:right;padding-right:10px;"><label id="lbltotal">'.number_format($net,2).'</label></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="font-size:11px;">IP REF</td>
                                    <td colspan="2" style="border-left: 1px solid #000;border-right: 1px solid #000;text-align:left;padding-left:35px;">Tax</td>
                                    <td colspan="2" style="border-left: 1px solid #000;border-right: 1px solid #000;text-align:right;"><label class="padding-right:10px;" id="lbldiscount"></label></td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="2" style="border-bottom: 1px solid #000;border-left: 1px solid #000;border-right: 1px solid #000;text-align:left; font-weight:bold;padding-left:35px;">Total (Incl)</td>
                                    <th colspan="2" style="border-bottom: 1px solid #000;border-left: 1px solid #000;border-right: 1px solid #000;text-align:right;padding-right:10px;"><label class="font-weight-bold text-dark" id="lblbalance">'.number_format($net,2).'</label></th>
                                </tr>
                            </tfoot>';
                        }
                    $html.='</table>
                </main>';
                if ($index === count($dataArray) - 1) {
                    $html .= '<div style="page-break-before: always;"></div>'; 
                }
            }
        $html .= '</body>
        </html>';

        $this->load->library('pdf');
        $this->pdf->loadHtml($html);
        $this->pdf->render();
        $this->pdf->stream( "MULTI OFFSET PRINTERS-PURCHASE ORDER- ".$recordID.".pdf", array("Attachment"=>0));
    }

}
