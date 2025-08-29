<?php 
include "include/header.php";  
include "include/topnavbar.php"; 
?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include "include/menubar.php"; ?>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header page-header-light bg-white shadow">
                <div class="container-fluid">
                    <div class="page-header-content py-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fas fa-list"></i></div>
                            <span>Material Group</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-3">
                                <form action="<?php echo base_url() ?>Materialgroup/Materialgroupinsertupdate"
                                    method="post" autocomplete="off">
                                    <div class="form-group">
                                        <label class="small font-weight-bold text-dark">Group Category*</label>
                                        <input type="text" class="form-control form-control-sm" name="category" id="category" required>
                                    </div>
                                    <div class="form-group mt-2">
                                        <button type="submit" id="submitBtn" class="btn btn-outline-primary btn-sm w-50 fa-pull-right" <?php if($addcheck==0){echo 'disabled';} ?>><i class="far fa-save"></i>&nbsp;Add</button>
                                    </div>
                                    <input type="hidden" name="recordOption" id="recordOption" value="1">
                                    <input type="hidden" name="recordID" id="recordID" value="">
                                </form>
                            </div>
                            <div class="col-9">
                                <table class="table table-bordered table-striped table-sm nowrap" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Group Category</th>
                                            <th class="text-right">Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php include "include/footerbar.php"; ?>
    </div>
</div>

<?php include "include/footerscripts.php"; ?>
<script>
$(document).ready(function() {
    var addcheck = '<?php echo $addcheck; ?>';
    var editcheck = '<?php echo $editcheck; ?>';
    var statuscheck = '<?php echo $statuscheck; ?>';
    var deletecheck = '<?php echo $deletecheck; ?>';

    $('#dataTable').DataTable({
        "destroy": true,
        "processing": true,
        "serverSide": true,
        dom: "<'row'<'col-sm-5'B><'col-sm-2'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        responsive: true,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        "buttons": [{
                extend: 'csv',
                className: 'btn btn-success btn-sm',
                title: 'Material Information',
                text: '<i class="fas fa-file-csv mr-2"></i> CSV',
            },
            {
                extend: 'pdf',
                className: 'btn btn-danger btn-sm',
                title: 'Material Information',
                text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
            },
            {
                extend: 'print',
                title: 'Material Information',
                className: 'btn btn-primary btn-sm',
                text: '<i class="fas fa-print mr-2"></i> Print',
                customize: function(win) {
                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                },
            },
            // 'csv', 'pdf', 'print'
        ],
        ajax: {
            url: "<?php echo base_url() ?>scripts/materialgrouplist.php",
            type: "POST", // you can use GET
            "data": function(d) {
                return $.extend({}, d, {
                    "company_id": '<?php echo ($_SESSION['company_id']); ?>',
                });
            }
        },
        "order": [
            [0, "desc"]
        ],
        "columns": [
            {
                "data": null,
                "render": function(data, type, full, meta) {
                    return meta.settings._iRecordsDisplay - meta.row;
                }
            },
            {
                "data": "group"
            },
            {
                "targets": -1,
                "className": 'text-right',
                "data": null,
                "render": function(data, type, full) {
                    var button = '';
                    button += '<button class="btn btn-primary btn-sm btnEdit mr-1 ';
                        if(editcheck==1){
							button+='<button type="button" data-toggle="tooltip" data-placement="bottom" title="Edit" class="btn btn-primary btn-sm btnEdit mr-1" id="'+full['idtbl_material_group']+'"><i class="fas fa-pen"></i></button>';
						}
                        if (full['status'] == 1 && statuscheck == 1) {
                            button += '<button type="button" data-toggle="tooltip" data-placement="bottom" title="Active" data-url="Materialgroup/Materialgroupstatus/' + full['idtbl_material_group'] + '/2" data-actiontype="2" class="btn btn-success btn-sm mr-1 btntableaction"><i class="fas fa-check"></i></button>';
                        } else if (full['status'] != 1 && statuscheck == 1) {
                            button += '<button type="button" data-toggle="tooltip" data-placement="bottom" title="Deactive" data-url="Materialgroup/Materialgroupstatus/' + full['idtbl_material_group'] + '/1" data-actiontype="1" class="btn btn-warning btn-sm mr-1 btntableaction"><i class="fas fa-times"></i></button>';
                        }

                        if (deletecheck == 1) {
                            button += '<button type="button" data-toggle="tooltip" data-placement="bottom" title="Delete" data-url="Materialgroup/Materialgroupstatus/' + full['idtbl_material_group'] + '/3" data-actiontype="3" class="btn btn-danger btn-sm btntableaction"><i class="fas fa-trash-alt"></i></button>';
                        }

                    return button;
                }
            }
        ],
        drawCallback: function(settings) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });

    var materialCategory;
    var materialColor;
    var materialCategoryGauge;
    var concatenatedValue;

    $('#materialcategory, #material_color, #material_categorygauge').change(function() {
        updateMaterialName();
    });

    function updateMaterialName() {

        materialCategory = $('#materialcategory option:selected').text().trim();
        materialColor = $('#material_color option:selected').text().trim();
        materialCategoryGauge = $('#material_categorygauge option:selected').text().trim();

        concatenatedValue = materialCategory + ' ' + materialColor + ' ' + materialCategoryGauge;

        $('#materialname').val(concatenatedValue);
    }
    $('#dataTable tbody').on('click', '.btnEdit', async function () {
        var r = await Otherconfirmation("You want to Edit this ? ");
        if (r == true) {
            var id = $(this).attr('id');
            $.ajax({
                type: "POST",
                data: {
                    recordID: id
                },
                url: '<?php echo base_url() ?>Materialdetail/Materialdetailedit',
                success: function(result) { //alert(result);
                    var obj = JSON.parse(result);
                    // checkfield(obj.materialcategory);
                    $('#recordID').val(obj.id);
                    $('#materialname').val(obj.materialname);
                    $('#materialcategory').val(obj.materialcategory);
                    $('#material_color').val(obj.materialcolor);
                    $('#material_categorygauge').val(obj.materialcategorygauge);
                    $('#unitprice').val(obj.unitprice);
                    $('#materialcode').val(obj.materialcode);
                    $('#reorder').val(obj.reorderlevel);
                    $('#comment').val(obj.comment);
                    $('#supplier').val(obj.supplier);
                    $('#recordOption').val('2');
                    $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');
                }
            });
        }
    });
    $('#dataTable tbody').on('click', '.btnview', function () {
        var id = $(this).attr('id');
        $('#hiddenmaterialID').val(id);

        $.ajax({
            url: '<?php echo base_url() ?>Materialdetail/Getadduomqty',
            type: 'POST',
            data: {
                id: id
            },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    $('#uomCheckboxes').empty();
                    
                    // Use a Set to track unique conversion IDs
                    const uniqueUoms = new Set();
                    
                    response.uom_conversions.forEach(function (uom) {
                        // Skip duplicates
                        if (uniqueUoms.has(uom.idtbl_uom_conversions)) {
                            return;
                        }
                        uniqueUoms.add(uom.idtbl_uom_conversions);
                        
                        var checkedAttr = uom.is_checked == 1 ? 'checked' : '';
                        var checkbox = `
                            <div class="form-check p-2 border rounded bg-light mb-2 shadow-sm">
                                <input 
                                    class="form-check-input" 
                                    type="checkbox" 
                                    name="uom_options[]" 
                                    value="${uom.idtbl_uom_conversions}" 
                                    id="uomCheckbox_${uom.idtbl_uom_conversions}"
                                    ${checkedAttr}
                                    style="transform: scale(1.2); margin-right: 10px;">
                                <label 
                                    class="form-check-label text-dark font-weight-bold" 
                                    for="uomCheckbox_${uom.idtbl_uom_conversions}" 
                                    style="cursor: pointer;">
                                    1 ${uom.main_uom} <span class="text-muted">to</span> ${uom.convert_uom}
                                    <span class="badge badge-danger ml-2">${uom.qty}</span>
                                </label>
                            </div>
                        `;
                        $('#uomCheckboxes').append(checkbox);
                    });

                    $('#materialinfomodal').modal('show');
                } else {
                    alert(response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', error);
                console.error('XHR Object:', xhr);
                alert('Failed to retrieve data.');
            }
        });
    });

});

function addCommas(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

function deactive_confirm() {
    return confirm("Are you sure you want to deactive this?");
}

function active_confirm() {
    return confirm("Are you sure you want to active this?");
}

function delete_confirm() {
    return confirm("Are you sure you want to remove this?");
}
</script>
<?php include "include/footer.php"; ?>