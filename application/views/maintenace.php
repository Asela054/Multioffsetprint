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
                        <h1 class="page-header-title font-weight-light">
                            <div class="page-header-icon"><i data-feather="car"></i></div>
                            <span>Maintance</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                       
                                <form action="<?php echo base_url() ?>Maintenace/maintenaceinsertupdate" method="post" autocomplete="off" enctype="multipart/form-data">
                        <div class="row">	
						  
                            <div class="col-4">
                                <div class="form-group">
                                        <label class="small font-weight-bold">Vehicle Reg NO*</label>
                                        <select class="form-control form-control-sm" name="vehicleregno" id="vehicleregno" required>
                                            <option value="">Select</option>
                                            <?php foreach ($VehicleRegNo->result() as $rowvehicleregno) { ?>
                                            <option value="<?php echo $rowvehicleregno->idtbl_vehicle ?>"><?php echo $rowvehicleregno->vehicle_reg_no ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    </div>
                                    <div class="col-4">
                                <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Service Charge*</label>
                                        <input type="text" class="form-control form-control-sm" name="servicecharge" id="servicecharge" required>
                                    </div>
                                    </div>
                                  
                                 
                                    <div class="col-4">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Discription*</label>
                                        <input type="text" rows="4" cols="50" class="form-control form-control-sm" name="discription" id="discription" required>
                                    </div>
                                    </div>
                        </div>
                        <div class="Row">

                                    <div class="col-4">
                                    <div class="form-group mb-1"> 
                                    <label class="small font-weight-bold">Bill*</label>
                                    <div class="filebody">
                                            <div class="drag-area">
                                                <div class="icon"><i class="fas fa-cloud-upload-alt"></i></div>
                                                <header>Drag & Drop to Upload File</header>
                                                <span>OR</span>
                                                <button>Browse File</button>
                                                <input type="file" name="bill" id="bill" hidden>
                                            </div>
                                            </div>

                                    </div>
                                    </div>
                                    </div>

                                    <div class="form-group mt-5 text-right">
                                        <button type="submit" id="submitBtn" class="btn btn-primary btn-sm px-4" 
                                        <?php if($addcheck==0){echo 'disabled';} ?>>
                                        <i class="far fa-save"></i>&nbsp;Add</button>
                                    </div>
                                    <input type="hidden" name="recordOption" id="recordOption" value="1">
                                    <input type="hidden" name="recordID" id="recordID" value="">
                                </form>
                            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
						<div class="row">
						  <div class="col-12">
                                <div class="scrollbar pb-3" id="style-2">
                                    <table class="table table-bordered table-striped table-sm nowrap" id="dataTable">
                                        <thead>
                                            <tr>
                                                <th>#</th> 
                                                <th>VEHICLE REG NO</th>
                                                <th>SERVICE CHARGE</th> 
                                                <th>DISCRIPTION</th>

                                                <th class="text-right">Actions</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
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
        var addcheck='<?php echo $addcheck; ?>';
        var editcheck='<?php echo $editcheck; ?>';
        var statuscheck='<?php echo $statuscheck; ?>';
        var deletecheck='<?php echo $deletecheck; ?>';

        $('#dataTable').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            dom: "<'row'<'col-sm-5'B><'col-sm-2'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            responsive: true,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            "buttons": [
                { extend: 'csv', className: 'btn btn-success btn-sm', title: 'Maintenace Information', text: '<i class="fas fa-file-csv mr-2"></i> CSV', },
                { extend: 'pdf', className: 'btn btn-danger btn-sm', title: 'Maintenace Information', text: '<i class="fas fa-file-pdf mr-2"></i> PDF', },
                { 
                    extend: 'print', 
                    title: 'Maintenace  Information',
                    className: 'btn btn-primary btn-sm', 
                    text: '<i class="fas fa-print mr-2"></i> Print',
                    customize: function ( win ) {
                        $(win.document.body).find( 'table' )
                            .addClass( 'compact' )
                            .css( 'font-size', 'inherit' );
                    }, 
                },
                // 'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            ajax: {
                url: "<?php echo base_url() ?>scripts/maintancelist.php",
                type: "POST", // you can use GET
                // data: function(d) { }
            },
            "order": [[ 0, "desc" ]],
            "columns": [
                {
                    "data": "idtbl_maintenace"
                },
                {
                    "data": "vehicle_reg_no"
                },
                {
                    "data": "service_charge"
                },
                {
                    "data": "comments"
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function(data, type, full) {
                        var button='';
                        button+='<a href="<?php echo base_url() ?>Servicesitem/index/'+full['idtbl_maintenace']+'" target="_self" class="btn btn-secondary btn-sm mr-1"><i class="fas fa-file"></i></a>';

                        button+='<button class="btn btn-primary btn-sm btnEdit mr-1 ';if(editcheck!=1){button+='d-none';}button+='" id="'+full['idtbl_maintenace']+'"><i class="fas fa-pen"></i></button>';
                        if(full['status']==1){
                            button+='<a href="<?php echo base_url() ?>Maintenace/maintenacestatus/'+full['idtbl_maintenace']+'/2" onclick="return deactive_confirm()" target="_self" class="btn btn-success btn-sm mr-1 ';if(statuscheck!=1){button+='d-none';}button+='"><i class="fas fa-check"></i></a>';
                        }else{
                            button+='<a href="<?php echo base_url() ?>Maintenace/maintenacestatus/'+full['idtbl_maintenace']+'/1" onclick="return active_confirm()" target="_self" class="btn btn-warning btn-sm mr-1 ';if(statuscheck!=1){button+='d-none';}button+='"><i class="fas fa-times"></i></a>';
                        }
                        button+='<a href="<?php echo base_url() ?>Maintenace/maintenacestatus/'+full['idtbl_maintenace']+'/3" onclick="return delete_confirm()" target="_self" class="btn btn-danger btn-sm ';if(deletecheck!=1){button+='d-none';}button+='"><i class="fas fa-trash-alt"></i></a>';
                        
                        return button;
                    }
                }
            ],
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
        $('#dataTable tbody').on('click', '.btnEdit', function() {
            var r = confirm("Are you sure, You want to Edit this ? ");
            if (r == true) {
                var id = $(this).attr('id');
                $.ajax({
                    type: "POST",
                    data: {
                        recordID: id
                    },
                    url: '<?php echo base_url() ?>Maintenace/maintenaceedit',
                    success: function(result) { //alert(result);
                        var obj = JSON.parse(result);
                        $('#recordID').val(obj.id);
                        $('#vehicleregno').val(obj.vehicleregno); 
                        $('#servicecharge').val(obj.servicecharge); 
                        $('#discription').val(obj.comments); 
                        // $('#bill').val(obj.bill); 

                        $('#recordOption').val('2');
                        $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');
                    }
                });
            }
        });
    });

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
<script src="https://kit.fontawesome.com/a076d05399.js"></script>

<script>//selecting all required elements
const dropArea = document.querySelector(".drag-area"),
dragText = dropArea.querySelector("header"),
button = dropArea.querySelector("button"),
input = dropArea.querySelector("input");
let file; //this is a global variable and we'll use it inside multiple functions

button.onclick = ()=>{
  input.click(); //if user click on the button then the input also clicked
}

input.addEventListener("change", function(){
  //getting user select file and [0] this means if user select multiple files then we'll select only the first one
  file = this.files[0];
  dropArea.classList.add("active");
  showFile(); //calling function
});


//If user Drag File Over DropArea
dropArea.addEventListener("dragover", (event)=>{
  event.preventDefault(); //preventing from default behaviour
  dropArea.classList.add("active");
  dragText.textContent = "Release to Upload File";
});

//If user leave dragged File from DropArea
dropArea.addEventListener("dragleave", ()=>{
  dropArea.classList.remove("active");
  dragText.textContent = "Drag & Drop to Upload File";
});

//If user drop File on DropArea
dropArea.addEventListener("drop", (event)=>{
  event.preventDefault(); //preventing from default behaviour
  //getting user select file and [0] this means if user select multiple files then we'll select only the first one
  file = event.dataTransfer.files[0];
  showFile(); //calling function
});

function showFile(){
  let fileType = file.type; //getting selected file type
  let validExtensions = ["image/jpeg", "image/jpg", "image/png"]; //adding some valid image extensions in array
  if(validExtensions.includes(fileType)){ //if user selected file is an image file
    let fileReader = new FileReader(); //creating new FileReader object
    fileReader.onload = ()=>{
      let fileURL = fileReader.result; //passing user file source in fileURL variable
      let imgTag = `<img src="${fileURL}" alt="">`; //creating an img tag and passing user selected file source inside src attribute
      dropArea.innerHTML = imgTag; //adding that created img tag inside dropArea container
    }
    fileReader.readAsDataURL(file);
  }else{
    alert("This is not an Image File!");
    dropArea.classList.remove("active");
    dragText.textContent = "Drag & Drop to Upload File";
  }
}</script>
<?php include "include/footer.php"; ?>
