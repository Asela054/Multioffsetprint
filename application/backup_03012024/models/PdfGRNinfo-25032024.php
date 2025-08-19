<?php
use Dompdf\Dompdf;
use Dompdf\Options;

class PdfGRNinfo extends CI_Model {

    public function pdfgrnget($x) {

        $recordID=$x;
        $insertdatetime=date('Y-m-d H:i:s');

        $this->db->select('*, COALESCE(tbl_print_grn.idtbl_print_grn, 0) AS idtbl_print_grn, COALESCE(tbl_print_grn.total, 0) AS grn_total, COALESCE(tbl_print_grn.discount, 0) AS discount, COALESCE(tbl_print_grndetail.qty, 0) AS qty, COALESCE(tbl_print_grndetail.unitprice, 0) AS unitprice');
        $this->db->from('tbl_print_grn');
        $this->db->join('tbl_print_grndetail', 'tbl_print_grn.idtbl_print_grn = tbl_print_grndetail.tbl_print_grn_idtbl_print_grn', 'left');
        $this->db->join('tbl_print_material_info', 'tbl_print_grndetail.tbl_print_material_info_idtbl_print_material_info = tbl_print_material_info.idtbl_print_material_info', 'left');
        $this->db->join('tbl_machine', 'tbl_print_grndetail.tbl_machine_id = tbl_machine.idtbl_machine', 'left');
        $this->db->join('tbl_supplier', 'tbl_print_grn.tbl_supplier_idtbl_supplier = tbl_supplier.idtbl_supplier', 'left');
        $this->db->join('tbl_location', 'tbl_print_grn.tbl_location_idtbl_location = tbl_location.idtbl_location', 'left');
        $this->db->join('tbl_order_type', 'tbl_print_grn.tbl_order_type_idtbl_order_type = tbl_order_type.idtbl_order_type', 'left');
        $this->db->join('tbl_measurements', 'tbl_print_grndetail.measure_type_id = tbl_measurements.idtbl_mesurements', 'left');
        $this->db->where('tbl_print_grn.idtbl_print_grn' ,$recordID);
        $query = $this->db->get();

        /*$result =$query->result();

        echo "<pre>";
        print_r($result);
        echo "</pre>";*/

        $path = 'images/book.jpg';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $this->load->library('pdf');

        $fontDir = 'fonts/';
        $options = new Options();
        $options->set('fontDir', $fontDir);
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf = new Dompdf($options);

        $html = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Goods Received Note</title>
            <style>
                @font-face {
                    font-family: "comicz";
                    src: url("' . $fontDir . 'comicz.ttf");
                }
                @font-face {
                    font-family: "RussoOne";
                    src: url("' . $fontDir . 'RussoOne.ttf");
                }
                body {
                    margin: 0px;
                    padding: 0px;
                    font-family: Arial, sans-serif;
                    width: 100%;
                    font-size: small;
                }
                p {
                    font-size: 14px;
                    line-height: 3px;
                }
                .pheader {
                    font-size: 12px;
                    font-style: italic;
                    line-height: 1.5px;
                }
                .tablec {
                    width: 100%;
                    border: 1px solid black;
                    border-collapse: collapse;
                    margin-bottom: 20px;
                    font-size: 8;
                }
                .thc {
                    border: 1px solid black;
                    padding: 5px;
                    height: 10px
                }
                .tdc {
                    border-left: 1px solid black;
                    border-right: 1px solid black;
                    padding: 5px;
                }
                .td-bottom{
                    border-bottom: none;
                }
                .thpadding{
                    padding-top: 2px; 
                    padding-bottom: 2px;
                }
                .tdpadding{
                    padding-top: 2px; 
                    padding-bottom: 2px;
                }
                hr {
                    border: 1px solid #ddd;
                }
                .postion {
                    position: relative;
                }
                .pos {
                    padding-bottom: -20px; 
                }
                .pos2 {
                    padding-top: -22px; 
                    padding-bottom: -22px;
                }
                .page-text {
                    font-size: 8;
                    color: #696969;
                }
                .leftmargin {
                    margin-left: 25px;
                }
                .table2 {
                    padding-top: -10px; 
                    padding-bottom: -10px;
                }
                .table2s {
                    padding-top: -25px; 
                    padding-bottom: -25px;
                }
                .div-text {
                    text-align: left; 
                    margin-right: -50px;
                    max-width: 150px;
                }
                .tddc table {
                    height: 20px; 
                }
                .tddc table p {
                    padding: 5;
                    margin: 0px;
                }
                .tdnew {
                    border: 1px solid black;
                    padding: 5px; 
                }
                .toppadding {
                    padding-bottom: -2px;
                }
                .marg {
                    padding-top: 25px;
                    padding-bottom: -5px;
                }
                .table2position {
                    padding-top: -10px;
                }
            </style>
        </head>
        <body>

        <div>

            <table border="0" width="100%">
                <tr>
                    <th width="25%" align="right"><img src="'.$base64.'"/></th>
                    <td align="center">
                        <h3><i>MULTI OFFSET PRINTERS (PVT) LTD</i></h3>
                        <p class="pheader">345,NEGOMBO ROAD MUKALANGAMUWA, SEEDUWA</p>
                        <p class="pheader">Phone : +94-11-2253505, 2253876, 2256615</p>
                        <p class="pheader">E-Mail : multioffsetprinters@gmail.com</p>
                        <p class="pheader">Fax : +94-11-2254057</p>
                    </td>
                    <th width="25%" align="right" valign="top" class="postion"></th>
                </tr>

                <tr>
                    <th colspan="3" align="right" class="postion pos2" style="padding-right:46px;"><h5>GRN No: MO/GRN-0000'. $query->row()->idtbl_print_grn .'</h5></th>
                </tr>

                <tr>
                    <th colspan="3" align="center" class="postion pos2"><h4><u>Goods Received Note</u></h4></th>
                </tr>
            </table>
            
            <table border="0" width="100%">
                <tr>
                    <td class="table2s" width="280px" valign="top">
                        <h5 style="margin-left:2px;">To: '. $query->row()->name .'</h5>
                        <p class="leftmargin" style="font-size:9; padding-top:-5px">'. $query->row()->delivery_address_line1 .', '. $query->row()->delivery_address_line2 .',</p>
                        <p class="leftmargin" style="font-size:9;">'. $query->row()->delivery_city .',</p>
                        <p class="leftmargin" style="font-size:9;">'. $query->row()->delivery_state .'.</p>
                    </td>
                    <td class="table2"></td>
                    <td class="" height="90px">
                        <table border="0" align="right">
                            <tr>
                                <td style="padding-top:-10px; padding-bottom:-10px"><p style="font-size:9;"><b>Date</b></p></td>
                                <td style="padding-top:-10px; padding-bottom:-10px"><p>:</p></td>
                                <td style="padding-top:-10px; padding-bottom:-10px"><p style="font-size:9;">'. $query->row()->grndate .'</p></td>
                            </tr>
                            <tr>
                                <td style="padding-top:-10px; padding-bottom:-10px"><p style="font-size:9;"><b>Invoice Number</b></p></td>
                                <td style="padding-top:-10px; padding-bottom:-10px"><p>:</p></td>
                                <td style="padding-top:-10px; padding-bottom:-10px"><p style="font-size:9;">'. $query->row()->invoicenum .'</p></td>
                            </tr>
                            <tr>
                                <td style="padding-top:-10px; padding-bottom:-10px"><p style="font-size:9;"><b>Batch Number</b></p></td>
                                <td style="padding-top:-10px; padding-bottom:-10px"><p>:</p></td>
                                <td style="padding-top:-10px; padding-bottom:-10px"><p style="font-size:9;">'. $query->row()->batchno .'</p></td>
                            </tr>
                            <tr>
                                <td style="padding-top:-10px; padding-bottom:-10px"><p style="font-size:9;"><b>Location</b></p></td>
                                <td style="padding-top:-10px; padding-bottom:-10px"><p>:</p></td>
                                <td style="padding-top:-10px; padding-bottom:-10px"><p style="font-size:9;">'. $query->row()->location .'</p></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <table class="tablec" width="100%">
                    <tr>
                        <th class="thc thpadding" rowspan="2" align="center" width="73px">Item Code</th>
                        <th class="thc thpadding" rowspan="2" align="center" width="250px">Item Description</th>
                        <th class="thc thpadding" colspan="3" align="center" width="312px">Quantity</th>
                        <th class="thc thpadding" rowspan="2" align="center">Unit</th>
                        <th class="thc thpadding" rowspan="2" align="center">Price</th>
                        <th class="thc thpadding" rowspan="2" align="center">Total</th>
                    </tr>
                    <tr>
                        <th class="thc tdpadding" align="center"><b>Ordered</b></td>
                        <th class="thc tdpadding" align="center"><b>Prev</b></td>
                        <th class="thc tdpadding" align="center"><b>Received</b></td>
                    </tr>';

                    $totalSum = 0;
                    $discount = $query->row()->discount;
                    $vat = $query->row()->vat;
                    $fullTotal = 0;
                    $grn_total = $query->row()->grn_total;

                    foreach ($query->result() as $row) {

                        if ($query->row()->tbl_order_type_idtbl_order_type == 2) {
                            $itemtype = "Service";
                            $totalSum += $row->total;
                            
                            $html .= '

                            <tr>
                                <td class="tdc"></td>
                                <td class="tdc">' . $row->service_type . '</td>
                                <td class="tdc" align="right">' . $row->qty . '</td>
                                <td class="tdc"> </td>
                                <td class="tdc" align="right">' . $row->qty . '</td>
                                <td class="tdc" align="center">' . $row->measure_type . '</td>
                                <td class="tdc" align="right">' . number_format($row->unitprice) . '</td>
                                <td class="tdc" align="right" style="padding-right:11px;">' . number_format($row->total) . '</td>
                            </tr>';

                        } elseif ($query->row()->tbl_order_type_idtbl_order_type == 3) {
                            $itemtype = "Material";
                            $totalSum += $row->total;

                            $html .= '

                            <tr>
                                <td class="tdc">' . $row->materialinfocode . '</td>
                                <td class="tdc">' . $row->materialname . '</td>
                                <td class="tdc" align="right">' . $row->qty . '</td>
                                <td class="tdc"> </td>
                                <td class="tdc" align="right">' . $row->qty . '</td>
                                <td class="tdc" align="center">' . $row->measure_type . '</td>
                                <td class="tdc" align="right">' . number_format($row->unitprice) . '</td>
                                <td class="tdc" align="right" style="padding-right:11px;">' . number_format($row->total) . '</td>
                            </tr>';

                        } elseif ($query->row()->tbl_order_type_idtbl_order_type == 4) {
                            $itemtype = "Machine";
                            $totalSum += $row->total;

                            $html .= '

                            <tr>
                                <td class="tdc">' . $row->machinecode . '</td>
                                <td class="tdc">' . $row->machine . '</td>
                                <td class="tdc" align="right">' . $row->qty . '</td>
                                <td class="tdc"> </td>
                                <td class="tdc" align="right">' . $row->qty . '</td>
                                <td class="tdc" align="center">' . $row->measure_type . '</td>
                                <td class="tdc" align="right">' . number_format($row->unitprice) . '</td>
                                <td class="tdc" align="right" style="padding-right:11px;">' . number_format($row->total) . '</td>
                            </tr>';

                        }
                    }

                    $fullTotal = $totalSum - $discount * $vat / 100;

                    $html .= '

                    <tr>
                        <td class="tdc tddc"></td>
                        <td class="tdc tddc"></td>
                        <td class="tdc tddc"></td>
                        <td class="tdc tddc"></td>
                        <td class="tdc tddc"></td>
                        <td class="tdc tddc"></td>
                        <td class="tdc tddc">
                            <table border="0" width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="32%"></td>
                                    <td>
                                        <p style="margin:0; padding-right:0; font-size:8;" align="left"><b>Total (Ex)</b></p>
                                        <p style="margin:0; padding-right:0; font-size:8;"><b>Discount</b></p>
                                        <p style="margin:0; padding-right:0; font-size:8;"><b>Vat(%)</b></p>
                                        <p style="margin:0; padding-right:0; font-size:8;" align="left"><b>Total with Tax</b></p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td class="tdc tddc" align="right">
                            <table border="0" width="100%" cellspacing="0" cellpadding="0" align="right">
                                <tr>
                                    <td align="right">
                                        <p style="font-size:8;"><b>'. number_format($totalSum) .'</b></p>
                                        <p style="font-size:8;"><b>'. number_format($discount) .'</b></p>
                                        <p style="font-size:8;"><b>'. $row->vat . '%' .'</b></p>
                                        <p style="font-size:8;"><b>'. number_format($grn_total) .'</b></p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
            </table>

            <table width="100%" border="1" class="tablec table2position">
                <tr>
                    <td class="tdnew" rowspan="2" height="30px" valign="top" width="161px">Received by </td>
                    <td class="tdnew" rowspan="2" valign="top" width="161px">Approved by </td>
                    <td class="tdnew" width="85px">Voucher No </td>
                    <td class="tdnew" colspan="2"></td>
                    <td class="tdnew" colspan="3" align="center"><b>Accounts Department</b></td>
                </tr>
                <tr>
                    <td class="tdnew">Date</td>
                    <td class="tdnew" colspan="2"></td>
                    <td class="tdnew" width="85px">Prepared by </td>
                    <td class="tdnew" colspan="2"></td>
                </tr>
                <tr>
                    <td class="tdnew" rowspan="3" colspan="2" height="50px" valign="top">Remarks </td>
                    <td class="tdnew" rowspan="3" colspan="3" valign="top">Contact Person : </td>
                    <td class="tdnew" width="85px">Checked by </td>
                    <td class="tdnew" colspan="2"></td>
                </tr>
                <tr>
                    <td class="tdnew toppadding" colspan="3" rowspan="2" align="center" height="30px"><p style="font-size:8;" class="marg">............................................</p>
                    <p style="font-size:8;">Accountant</p></td>
                </tr>
                <tr>
                
                </tr>
            </table>
            
        </div>
               
        </body>
        </html>
        '; 
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream("Goods Received Note - ". $recordID .".pdf", ["Attachment"=>0]);
    }

}