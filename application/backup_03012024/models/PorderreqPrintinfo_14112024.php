<?php
use Dompdf\Dompdf;
use Dompdf\Options;

class PorderreqPrintinfo extends CI_Model {

     public function Printinvoice($x){
        $recordID=$x;

        $this->db->select('*');
        $this->db->from('tbl_print_porder_req');
        $this->db->join('tbl_print_porder_req_detail', 'idtbl_print_porder_req = tbl_print_porder_req_detail.tbl_print_porder_idtbl_print_porder', 'left');
        $this->db->join('tbl_order_type', 'tbl_print_porder_req.tbl_order_type_idtbl_order_type = tbl_order_type.idtbl_order_type', 'left');
        $this->db->join('tbl_measurements', 'tbl_print_porder_req_detail.measure_type_id = tbl_measurements.idtbl_mesurements', 'left');
        $this->db->where('tbl_print_porder_req.idtbl_print_porder_req', $recordID);
        
        $query = $this->db->get();
        
        $path = 'images/book.jpg';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $this->load->library('pdf');

        $fontDir = 'fonts/';
        $options = new Options();
        $options->set('fontDir', $fontDir);
        $options->set('isPhpEnabled', true);
        $dompdf = new Dompdf($options);

        $html = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Purchase Order Request</title>
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
                    margin: 5px;
                    padding: 5px;
                    font-family: Arial, sans-serif;
                    width: 100%;
                }
                p {
                    font-size: 14px;
                    line-height: 3px;
                }
                .pheader {
                    font-size: 12px;
                    line-height: 1.5px;
                }
                .tablec {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 20px;
                }
                .thc, .tdc {
                    padding: 5px;
                    text-align: left;
                    border: 1px solid black;
                }
                .thc {
                    background-color: #f2f2f2;
                    font: RussoOne;
                }
                hr {
                    border: 1px solid #ddd;
                }
                .postion {
                    position: relative;
                }
                .pos{
                    padding-bottom: -20px; 
                }
                .hedfont {
                    font: 20px comicz;
                }
            </style>
        </head>
        <body>

            <table border="0" width="100%">

                <tr>
                    <th width="15%"><img src="'. $base64 .'"/></th>
                    <td align="center">
                        <h3><i>MULTI OFFSET PRINTERS (PVT) LTD</i></h3>
                        <p class="pheader"><i>345,NEGOMBO ROAD MUKALANGAMUWA, SEEDUWA</i></p>
                        <p class="pheader"><i>Phone : +94-11-2253505, 2253876, 2256615</i></p>
                        <p class="pheader"><i>E-Mail : multioffsetprinters@gmail.com</i></p>
                        <p class="pheader"><i>Fax : +94-11-2254057</i></p>
                    </td>
                    <th width="15%"></th>
                </tr>

                <tr>
                    <th colspan="3" height="25px"></th>
                </tr>

                <tr>
                    <td colspan="3"><hr></td>
                </tr>

                <tr>
                    <td colspan="3">
                    <table class="tablec">
                    <thead class="thc">
                        <tr>
                            <th class="thc" width="40%">Product Info</th>
                            <th class="thc" style="text-align:center;" width="25%">Qty</th>
                            <th class="thc" width="25%" style="text-align:center;">Measurements</th>
                        </tr>
                    </thead>
                    <tbody class="tdc">';

                    foreach ($query->result() as $row) {

                        if ($query->row()->tbl_order_type_idtbl_order_type == 2) {
                            $itemtype = "Service";
                            
                            $html .= '
                            <tr>
                                <td class="tdc">' . $row->requestname . '</td>
                                <td class="tdc" style="text-align:center;">' . $row->qty . '</td>
                                <td class="tdc" style="text-align:center;">' . $row->measure_type . '</td>
                            </tr>';

                        } elseif ($query->row()->tbl_order_type_idtbl_order_type == 3) {
                            $itemtype = "Material";

                            $html .= '
                            <tr>
                                <td class="tdc">' . $row->requestname . '</td>
                                <td class="tdc" style="text-align:center;">' . $row->qty . '</td>
                                <td class="tdc" style="text-align:center;">' . $row->measure_type . '</td>
                            </tr>';
                            
                        } else {
                            $itemtype = "Machine";

                            $html .= '
                            <tr>
                                <td class="tdc">' . $row->requestname . '</td>
                                <td class="tdc" style="text-align:center;">' . $row->qty . '</td>
                                <td class="tdc" style="text-align:center;">' . $row->measure_type . '</td>
                            </tr>';
                           
                        }
                    }
                    $html .= '

                    </tbody>
                </table>
                    </td>
                </tr>

            </table>
        </body>
        </html>
        ';  

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("Purchase Order Request- ". $recordID .".pdf", ["Attachment"=>0]);
    }

}