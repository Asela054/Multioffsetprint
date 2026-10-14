<?php
use Dompdf\Dompdf;
use Dompdf\Options;

class Grnreqinfo extends CI_Model {

    public function Printinvoice($x){
        $recordID = $x;

        $this->db->select('
            tbl_grn_req.idtbl_grn_req,
            tbl_grn_req.tbl_machine_idtbl_machine,
            tbl_location.location,
            employees.emp_id,
            employees.emp_name_with_initial,
            tbl_material_group.group AS ordergroup,
            tbl_machine.machine,
            tbl_grn_req_detail.qty,
            tbl_print_material_info.materialname,
            tbl_print_material_info.materialinfocode,
            tbl_measurements.measure_type
        ', false);
        $this->db->from('tbl_grn_req');
        $this->db->join('tbl_grn_req_detail', 'tbl_grn_req.idtbl_grn_req = tbl_grn_req_detail.tbl_grn_req_idtbl_grn_req AND tbl_grn_req_detail.status = 1', 'left');
        $this->db->join('tbl_print_material_info', 'tbl_grn_req_detail.tbl_material_id = tbl_print_material_info.idtbl_print_material_info', 'left');
        $this->db->join('tbl_measurements', 'tbl_grn_req_detail.tbl_measurements_id = tbl_measurements.idtbl_mesurements', 'left');
        $this->db->join('tbl_location', 'tbl_grn_req.company_id = tbl_location.idtbl_location', 'left');
        $this->db->join('employees', 'tbl_grn_req.employee_id = employees.id', 'left');
        $this->db->join('tbl_material_group', 'tbl_grn_req.tbl_material_group_idtbl_material_group = tbl_material_group.idtbl_material_group', 'left');
        $this->db->join('tbl_machine', 'tbl_grn_req.tbl_machine_idtbl_machine = tbl_machine.idtbl_machine', 'left');
        $this->db->where('tbl_grn_req.idtbl_grn_req', $recordID);
        $query = $this->db->get();

        if ($query->num_rows() == 0) {
            show_404();
            return;
        }

        $h = $query->row();

        // Request number, e.g. IR0009
        $reqNo = 'IR' . str_pad($h->idtbl_grn_req, 4, '0', STR_PAD_LEFT);

        // Machine: only when not 0 / empty
        $machineId   = (int) $h->tbl_machine_idtbl_machine;
        $showMachine = ($machineId !== 0 && !empty($h->machine));

        $this->load->library('pdf');

        $options = new Options();
        $options->set('fontDir', 'fonts/');
        $options->set('isPhpEnabled', true);
        $options->set('defaultFont', 'Helvetica');
        $dompdf = new Dompdf($options);

        $accent = '#1f3a5f';
        $light  = '#f3f6fa';

        // ---- Details card cells ----
        $details  = '<td width="50%" valign="top" class="dcell"><span class="dl">Location</span><br><span class="dv">' . html_escape($h->location) . '</span></td>';
        $details .= '<td width="50%" valign="top" class="dcell"><span class="dl">Employee</span><br><span class="dv">' . html_escape($h->emp_name_with_initial . ' - ' . $h->emp_id) . '</span></td>';
        $details .= '</tr><tr>';
        $details .= '<td width="50%" valign="top" class="dcell"><span class="dl">Order Type</span><br><span class="dv">' . html_escape($h->ordergroup) . '</span></td>';
        if ($showMachine) {
            $details .= '<td width="50%" valign="top" class="dcell"><span class="dl">Machine</span><br><span class="dv">' . html_escape($h->machine) . '</span></td>';
        } else {
            $details .= '<td width="50%" class="dcell"></td>';
        }

        // ---- Item rows ----
        $rows = '';
        $i = 1;
        $totalQty = 0;
        foreach ($query->result() as $row) {
            if ($row->materialname === null && $row->qty === null) {
                continue; // header with no detail rows
            }
            $bg = ($i % 2 == 0) ? $light : '#ffffff';
            $totalQty += (float) $row->qty;
            $rows .= '<tr style="background-color:' . $bg . ';">
                        <td class="tdc" style="text-align:center;">' . $i++ . '</td>
                        <td class="tdc">' . html_escape($row->materialname) . '<br><span class="sub">' . html_escape($row->materialinfocode) . '</span></td>
                        <td class="tdc" style="text-align:center;">' . html_escape($row->measure_type) . '</td>
                        <td class="tdc" style="text-align:right;">' . html_escape($row->qty) . '</td>
                      </tr>';
        }
        if ($rows === '') {
            $rows = '<tr><td class="tdc" colspan="4" style="text-align:center;color:#888;">No items found</td></tr>';
        }

        $html = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Internal Item Request - ' . $reqNo . '</title>
            <style>
                /* Top and bottom margins reserve room for the fixed header and footer */
                @page { margin: 125pt 35pt 115pt 35pt; }
                body { font-family: Helvetica, Arial, sans-serif; font-size: 12px; color: #222; margin: 0; }

                /* ---------- HEADER (repeats on every page) ---------- */
                #header { position: fixed; top: -105pt; left: 0; right: 0; height: 90pt; }
                .banner { background-color: ' . $accent . '; color: #ffffff; padding: 12px 10px; text-align: center; }
                .banner h2 { margin: 0 0 4px 0; font-size: 20px; letter-spacing: 1px; }
                .banner div { font-size: 10px; line-height: 1.5; color: #dbe5f1; }

                /* ---------- FOOTER (repeats on every page) ---------- */
                #footer { position: fixed; bottom: -92pt; left: 0; right: 0; height: 75pt; }
                .sign { width: 100%; border-collapse: collapse; }
                .sign td { width: 33%; text-align: center; font-size: 11px; color: #444; padding: 0 15px; }
                .sspace { height: 38pt; }
                .sline { border-top: 1px solid #555; padding-top: 5px; }

                /* ---------- BODY ---------- */
                .titlebar { width: 100%; border-collapse: collapse; }
                .title { font-size: 17px; font-weight: bold; color: ' . $accent . '; }
                .refbox { background-color: ' . $light . '; border: 1px solid #c9d4e3; padding: 6px 12px; text-align: right; font-size: 12px; }
                .accentline { border-top: 3px solid ' . $accent . '; margin: 8px 0 12px 0; }
                .dcard { width: 100%; border-collapse: collapse; background-color: ' . $light . '; border: 1px solid #c9d4e3; }
                .dcell { padding: 8px 12px; border-bottom: 1px solid #e1e8f1; }
                .dl { font-size: 9px; text-transform: uppercase; color: #6b7a90; letter-spacing: 0.5px; }
                .dv { font-size: 13px; font-weight: bold; color: #111; }
                .items { width: 100%; border-collapse: collapse; margin-top: 18px; }
                .thc { background-color: ' . $accent . '; color: #ffffff; padding: 8px; font-size: 11px; text-transform: uppercase; border: 1px solid ' . $accent . '; }
                .tdc { padding: 7px 8px; border: 1px solid #d5dde8; font-size: 12px; }
                .sub { font-size: 10px; color: #7a869a; }
                .total td { background-color: #e6ecf5; font-weight: bold; padding: 8px; border: 1px solid #c9d4e3; }
                tr { page-break-inside: avoid; }
            </style>
        </head>
        <body>

            <div id="header">
                <div class="banner">
                    <h2>MULTI OFFSET PRINTERS (PVT) LTD</h2>
                    <div>345, Negombo Road, Mukalangamuwa, Seeduwa</div>
                    <div>Tel: +94-11-2253505, 2253876, 2256615 &nbsp;|&nbsp; Fax: +94-11-2254057</div>
                    <div>E-Mail: multioffsetprinters@gmail.com</div>
                </div>
            </div>

            <div id="footer">
                <table class="sign">
                    <tr>
                        <td><div class="sspace"></div><div class="sline">Requested By</div></td>
                        <td><div class="sspace"></div><div class="sline">Approved By</div></td>
                        <td><div class="sspace"></div><div class="sline">Received By</div></td>
                    </tr>
                </table>
            </div>

            <table class="titlebar">
                <tr>
                    <td class="title">Internal Item Request</td>
                    <td width="35%">
                        <div class="refbox">
                            <span class="dl">Request No</span><br>
                            <b>' . $reqNo . '</b>
                        </div>
                    </td>
                </tr>
            </table>

            <div class="accentline"></div>

            <table class="dcard">
                <tr>' . $details . '</tr>
            </table>

            <table class="items">
                <thead>
                    <tr>
                        <th class="thc" width="8%">#</th>
                        <th class="thc" style="text-align:left;">Item Name / Code</th>
                        <th class="thc" width="18%">UOM</th>
                        <th class="thc" width="16%" style="text-align:right;">Qty</th>
                    </tr>
                </thead>
                <tbody>' . $rows . '</tbody>
                <tfoot>
                    <tr class="total">
                        <td colspan="3" style="text-align:right;">Total Quantity</td>
                        <td style="text-align:right;">' . $totalQty . '</td>
                    </tr>
                </tfoot>
            </table>

            <script type="text/php">
                if (isset($pdf)) {
                    $font = $fontMetrics->get_font("helvetica", "normal");
                    $pdf->page_text(35, 822, "Printed: ' . date('Y-m-d H:i') . '", $font, 8, array(0.45, 0.45, 0.45));
                    $pdf->page_text(490, 822, "Page {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0.45, 0.45, 0.45));
                }
            </script>

        </body>
        </html>';

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('Internal Item Request - ' . $reqNo . '.pdf', ["Attachment" => 0]);
    }
}