<?php
class InvoicePrintinfo extends CI_Model{

    public function Printinvoice($x){
        $recordID=$x;
        $sql =" SELECT * FROM `tbl_print_porder` 
        LEFT JOIN `tbl_supplier` ON `tbl_supplier`.`idtbl_supplier` = `tbl_print_porder`.`tbl_supplier_idtbl_supplier` 
        -- LEFT JOIN `tbl_routes` ON `tbl_routes`.`idtbl_routes` = `tbl_print_porder`.`tbl_routes_idtbl_routes`
        -- LEFT JOIN `tbl_vehicle` ON `tbl_vehicle`.`idtbl_vehicle` = `tbl_print_porder`.`tbl_vehicle_idtbl_vehicle`
        WHERE `idtbl_print_porder` = '$recordID'";

        $this->db->select('tbl_company.company AS companyname,tbl_company.address1 As companyaddress,tbl_company.mobile AS companymobile,
                                tbl_company.phone companyphone,tbl_company.email AS companyemail,
                                tbl_company_branch.branch AS branchname');
		$this->db->from('tbl_print_porder');
		$this->db->join('tbl_company', 'tbl_company.idtbl_company = tbl_print_porder.company_id', 'left');
        $this->db->join('tbl_company_branch', 'tbl_company_branch.idtbl_company_branch = tbl_print_porder.company_branch_id', 'left');
		$this->db->where('tbl_print_porder.idtbl_print_porder', $recordID);
		$companydetails = $this->db->get();

$path = 'images/book.jpg';
$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);



    $respond=$this->db->query($sql, array(1, $recordID));

    // $net=$respond->row(0)->nettotal;
    // $mileage=$respond->row(0)->mileage;
    $net = sprintf('%0.2f', $respond->row(0)->nettotal);
    // $discount=sprintf('%0.2f', $respond->row(0)->discount);
    // $balance=sprintf('%0.2f', $respond->row(0)->balance);
    // $cash=sprintf('%0.2f', $respond->row(0)->cash);
    // $credit=sprintf('%0.2f', $respond->row(0)->credit);
    // $batta=sprintf('%0.2f', $respond->row(0)->batta);
    // $cheque=sprintf('%0.2f', $respond->row(0)->cheque);
    // $debt=sprintf('%0.2f', $respond->row(0)->debt);
    // $total=sprintf('%0.2f', $respond->row(0)->total);
    // $routes=$respond->row(0)->route;
    // $sales_ref=$respond->row(0)->name;
    

    $htmltbl = '';
    $sql2="SELECT 
    `tbl_print_porder_detail`.*,
    `tbl_print_porder`.*,
    `tbl_print_material_info`.`materialinfocode`,
    `tbl_print_material_info`.`materialname`,
    `tbl_service_type`.`service_name`,
    `tbl_machine`.`machine`,
	`tbl_measurements`.`measure_type`

	FROM `tbl_print_porder`
	LEFT JOIN `tbl_print_porder_detail` ON `tbl_print_porder`.`idtbl_print_porder` = `tbl_print_porder_detail`.`tbl_print_porder_idtbl_print_porder`
	LEFT JOIN `tbl_order_type` ON `tbl_order_type`.`idtbl_order_type` = `tbl_print_porder`.`tbl_order_type_idtbl_order_type`
	LEFT JOIN `tbl_print_material_info` ON `tbl_print_material_info`.`idtbl_print_material_info` = `tbl_print_porder_detail`.`tbl_material_id`
	LEFT JOIN `tbl_machine` ON `tbl_machine`.`idtbl_machine` = `tbl_print_porder_detail`.`tbl_machine_id`
	LEFT JOIN `tbl_service_type` ON `tbl_service_type`.`idtbl_service_type` = `tbl_print_porder_detail`.`tbl_service_type_id`
	LEFT JOIN `tbl_measurements` ON `tbl_measurements`.`idtbl_mesurements` = `tbl_print_porder_detail`.`measure_type_id`
	WHERE 
    `tbl_print_porder_detail`.`status` = '1'
    AND `tbl_print_porder`.`idtbl_print_porder` = '$recordID'";


     $respond2=$this->db->query($sql2, array(1, $recordID));

     $dataArray = [];
     $count = 0;
     $section = 1;
     foreach ($respond2->result() as $rowlist) {
        $nettotal = $rowlist->unitprice * $rowlist->qty;
        $materialInfoCode = $rowlist->materialinfocode;
        $qty = $rowlist->qty;
        $measureType = $rowlist->measure_type;
        $unitPrice = $rowlist->unitprice;
    
        if ($respond2->row()->tbl_order_type_idtbl_order_type == 2) {
            $itemDescription = $rowlist->service_name;
        } elseif ($respond2->row()->tbl_order_type_idtbl_order_type == 3) {
            $itemDescription = $rowlist->materialname;
        } else {
            $itemDescription = $rowlist->machine;
        }
    
        if ($count % 4 == 0) {
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
    
        if ($count % 4 == 0) {
            $section++;
        }
        
    }



        $htmlcusdetail='';
        $travelinfotbl='';
        $additional ='';
        $chequeinfotbl ='';
        $cashinfotbl ='';
        

        $html = '
    <!DOCTYPE html>
    <html>

    <head>
    	<title>Multi Offset Printers</title>
    	<link rel="icon" type="image/x-icon" href="assets/img/firstclass.png" />
    	<style>
            @page {
                size: 220mm 120mm;
                margin: 5mm 15mm 5mm 5mm; /* top right bottom left */
            }
            body {
               margin: 0;
               font-family: Arial, sans-serif;
               font-size: 1rem;
               line-height: 1.5;
               text-align:left;
             }
    		.tg td {
    			font-size: 14px;
    			overflow: hidden;
    			word-break: normal;
    		}

    		.tg th {
    			font-size: 14px;
    			font-weight: normal;
    			overflow: hidden;
    			word-break: normal;
    		}

    		.tg .tg-btmp {
    			color: #000;
    			text-align: left;
    			vertical-align: top
    		}

    		.tg .tg-0lax {
    			text-align: left;
    			vertical-align: top
    		}
            .tg td {
            	font-size: 11px;
            	overflow: hidden;
            	word-break: normal;
            }

            .tg th {
            	font-size: 12px;
            	font-weight: normal;
            	overflow: hidden;
            	word-break: normal;
            }

            .tg .tg-btmp {
            	color: #000;
            	text-align: left;
            	vertical-align: top
            }

            .tg .tg-0lax {
            	text-align: left;
            	vertical-align: top
            }

    	</style>
    </head>

    <body>';
    foreach ($dataArray as $index => $section) {
    $html .= '
    <table style="width:100%;">
                <tr>
                    <td style="width: 50%;text-align: left;vertical-align: top;">
                        <h3 style="font-size:15px;  font-weight:bold;margin-top:-10px;  font-family: Arial, sans-serif;">PURCHASE ORDER</h3>
                        <h3 style="font-size:11px;  font-weight:bold;margin-top:-15px;   font-family: Arial, sans-serif;">To : '.$respond->row(0)->name.'</h3>
                        <h3 style="font-size:11px;  font-weight:normal;margin-top:-15px;margin-left:24px; font-family: Arial, sans-serif;"> '.$respond->row(0)->address_line1.',</h3>
                        <h3 style="font-size:11px;  font-weight:normal;margin-top:-15px;margin-left:24px; font-family: Arial, sans-serif;"> '.$respond->row(0)->address_line2.',</h3>
                        <h3 style="font-size:11px;  font-weight:normal;margin-top:-15px;margin-left:24px; font-family: Arial, sans-serif;"> '.$respond->row(0)->city.'.</h3>
                        <h3 style="font-size:11px;  font-weight:normal;margin-top:-15px;margin-left:24px; font-family: Arial, sans-serif;"> '.$respond->row(0)->telephone_no.'</h3>

                         <h3 style="font-size:11px;  font-weight:bold;;   font-family: Arial, sans-serif;">Atten ..................................</h3>
                    </td>
                    <td style="width: 50%;text-align: left;vertical-align: top;">
                        <h3 style="font-size:15px;  font-weight:bold;margin-top:-10px;margin-left:145px;  font-family: Arial, sans-serif;">'.$companydetails->row()->companyname.'</h3>
                        <h3 style="font-size:11px;  font-weight:normal;margin-top:-17px;margin-left:145px;   font-family: Arial, sans-serif;">'.$companydetails->row()->companyaddress.'</h3>
                        <h3 style="font-size:11px;  font-weight:normal;margin-top:-12px;margin-left:145px;margin-bottom:20px;   font-family: Arial, sans-serif;">Phone : '.$companydetails->row()->companymobile.'/'.$companydetails->row()->companyphone.'</h3>
                        <h3 style="font-size:11px;  font-weight:normal;margin-top:-20px;margin-left:145px;margin-bottom:20px;   font-family: Arial, sans-serif;">E-Mail : '.$companydetails->row()->companyemail.'</h3>

                        <h3 style="font-size:11px;  font-weight:normal;margin-top:-14px;margin-left:145px;   font-family: Arial, sans-serif;">PO No: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MO/PO-000'.$respond->row(0)->idtbl_print_porder.'</h3>
                        <h3 style="font-size:11px;  font-weight:normal;margin-top:-13px;margin-left:145px;   font-family: Arial, sans-serif;">Date : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$respond->row(0)->orderdate.'</h3>
                        <h3 style="font-size:11px;  font-weight:normal;margin-top:-13px;margin-left:145px;   font-family: Arial, sans-serif;">Our Vat No: &nbsp; 103305667-7000</h3>
                    </td>
                </tr>
        </table>
        
        <table class="tg" style="table-layout: fixed;padding:3px;width:100%;border-collapse: collapse;">
            <tr>
                <th style="width: 10%; text-align:center; border: 1px solid #000;font-weight:bold">Code</th>
                <th style="width: 40%; text-align:center; border: 1px solid #000;font-weight:bold">Item Description </th>
                <th style="width: 10%; text-align:center; border: 1px solid #000;font-weight:bold">Quantity</th>
                <th style="width: 10%; text-align:center; border: 1px solid #000;font-weight:bold">UOM</th>
                <th style="width: 15%; text-align:center; border: 1px solid #000;font-weight:bold">Unit Price</th>
                <th style="width: 15%; text-align:center; border: 1px solid #000;font-weight:bold">Total</th>
            </tr>
            <tbody>';
    
                foreach ($section as $row) {
                    $html .= '<tr>
                        <td style="width: 10%; text-align:center; border-right: 1px solid black; border-left: 1px solid #000;">' . htmlspecialchars($row['materialInfoCode']) . '</td>
                        <td style="width: 40%; text-align:center; border-right: 1px solid black;">' . htmlspecialchars($row['itemDescription']) . '</td>
                        <td style="width: 10%; text-align:center; border-right: 1px solid black;">' . htmlspecialchars($row['qty']) . '</td>
                        <td style="width: 10%; text-align:center; border-right: 1px solid black;">' . htmlspecialchars($row['measureType']) . '</td>
                        <td style="width: 15%; text-align:center; border-right: 1px solid black;">' . htmlspecialchars($row['unitPrice']) . '</td>
                        <td style="width: 15%; text-align:right; border-right: 1px solid black;">' . htmlspecialchars($row['nettotal']) . '</td>
                    </tr>';
                }
                
                if ($index === count($dataArray) - 1) {
                $html .= '</tbody>
                <tfoot>
                <tr>
                    <th colspan="4" style=" border-top: 1px solid #000;"></th>
                    <th style="text-align:left; font-weight:bold; border: 1px solid #000;">Total (Excl)</th>
                    <th style="font-weight:bold text-dark; text-align:right; border: 1px solid #000;"><label id="lbltotal"></label></th>
                </tr>
                <tr>
                    <th colspan="4"></th>
                    <th style="text-align:left; font-weight:bold; border: 1px solid #000;">Tax</th>
                    <th style="text-align:right; border: 1px solid #000;"><label class="font-weight-bold text-dark" id="lbldiscount"></label></th>
                </tr>
                <tr>
                    <th colspan="4"></th>
                    <th style="text-align:left; font-weight:bold; border: 1px solid #000;">Total (Incl)</th>
                    <th style="text-align:right; border: 1px solid #000;"><label class="font-weight-bold text-dark" id="lblbalance"></label></th>
                </tr>
               
             </tfoot>';
            } else {
                $html .= '</tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" style=" border-top: 1px solid #000;"></th>
                        <th style="text-align:left; font-weight:bold; border: 1px solid #000;">Total (Excl)</th>
                        <th style="font-weight:bold text-dark; text-align:right; border: 1px solid #000;"><label id="lbltotal">'.$net.'</label></th>
                    </tr>
                    <tr>
                        <th colspan="4"></th>
                        <th style="text-align:left; font-weight:bold; border: 1px solid #000;">Tax</th>
                        <th style="text-align:right; border: 1px solid #000;"><label class="font-weight-bold text-dark" id="lbldiscount"></label></th>
                    </tr>
                    <tr>
                        <th colspan="4" ></th>
                        <th style="text-align:left; font-weight:bold; border: 1px solid #000;">Total (Incl)</th>
                        <th style="text-align:right; border: 1px solid #000;"><label class="font-weight-bold text-dark" id="lblbalance">'.$net.'</label></th>
                    </tr>
                </tfoot>';
            }
        $html .= '</table>

        <table style="width:100%;margin-top:-25px;">
                <tr>
                    <td style="width: 12%;text-align: left;vertical-align: top;">
                      
                        <h3 style="font-size:11px;  font-weight:bold;margin-top:-10px;   font-family: Arial, sans-serif;">PR No. :</h3>
                        <h3 style="font-size:11px;  font-weight:bold;margin-top:-10px;   font-family: Arial, sans-serif;">GRV No. :</h3>
                        <h3 style="font-size:11px;  font-weight:bold;margin-top:-10px;margin-bottom:10px;   font-family: Arial, sans-serif;">INV No. :</h3>
                        <h3 style="font-size:11px;  font-weight:bold;margin-top:10px;   font-family: Arial, sans-serif;">Prepared by :..................................</h3>
                        <h3 style="font-size:11px;  font-weight:bold;margin-top:20px;   font-family: Arial, sans-serif;">Checked by :...................................</h3>
                    </td>
                    <td style="width: 10%;text-align: left;vertical-align: top;">
                        <h3 style="font-size:11px;  font-weight:bold;margin-top:55px;margin-left:30px;   font-family: Arial, sans-serif;">Contact Person</h3>
                        <h3 style="font-size:11px;  font-weight:bold;margin-top:20px;margin-left:30px;   font-family: Arial, sans-serif;">Contact No</h3>
                    </td>
                     <td style="width: 10%;text-align: center;vertical-align: top;">
                        <h3 style="font-size:15px;  font-weight:bold;margin-top:35px;  font-family: Arial, sans-serif;">'.$companydetails->row()->companyname.'</h3>
                        <h3 style="font-size:11px;  font-weight:bold;margin-top:0px;  font-family: Arial, sans-serif;">..........................................................</h3>
                        <h3 style="font-size:11px;  font-weight:bold;margin-top:-0px; font-family: Arial, sans-serif;">Authorise Officer</h3>
                    </td>
                </tr>
        </table>';

        if ($index === count($dataArray) - 1) {
            $html .= '<div style="page-break-before: always;"></div>'; 
        }
    }
$html .= '

    </body>

    </html>
';





    $this->load->library('pdf');
    $this->pdf->loadHtml($html);
	$this->pdf->render();
	$this->pdf->stream( "MULTI OFFSET PRINTERS-PURCHASE ORDER- ".$recordID.".pdf", array("Attachment"=>0));


    }

}
