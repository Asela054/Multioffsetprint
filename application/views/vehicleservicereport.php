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

                            <div class="page-header-icon">
                                <i class="fas fa-tools"></i>
                            </div>

                            <span>&nbsp; Vehicle Service Report</span>

                        </h1>

                    </div>

                </div>

            </div>



            <div class="container-fluid mt-2 p-0 p-2">


                <div class="card">


                    <div class="card-body p-0 p-2">


                        <form id="searchservice">


                            <div class="form-row">


                                <div class="col-3">


                                    <label class="small font-weight-bold">
                                        Service Type
                                    </label>


                                    <select id="service_type"
                                    class="form-control form-control-sm selecter2">


                                        <option value="all">
                                            All
                                        </option>


                                        <?php foreach($servicetype->result() as $row){ ?>


                                        <option value="<?=$row->idtbl_service_type?>">
                                            <?=$row->service_name?>
                                        </option>


                                        <?php } ?>


                                    </select>


                                </div>




                                <div class="col-3">


                                    <label class="small font-weight-bold">
                                        Vehicle / Engine / Chassis
                                    </label>


                                    <input type="text"
                                    id="search"
                                    class="form-control form-control-sm">


                                </div>




                                <div class="col-2"><br>


                                    <button type="submit"
                                    class="btn btn-info btn-sm">


                                        <i class="fas fa-search mr-2"></i>
                                        Search


                                    </button>


                                </div>



                            </div>


                        </form>




                        <div class="col-12">


                            <hr style="border:1px solid #ddd;">


                        </div>





                        <div class="scrollbar pb-3" id="style-2">


                            <table class="table table-bordered table-striped table-sm nowrap w-100"
                            id="serviceTable">


                                <thead class="thead-light">


                                    <tr>


                                        <th>Service Type</th>
                                        <th>Service Date</th>
                                        <th>Location</th>
                                        <th>Vehicle Reg No</th>
                                        <th>Model</th>
                                        <th>Brand</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Description</th>
                                        <th>Current Mileage</th>
                                        <th>Next Service Mileage</th>
                                        <th>Next Service Date</th>
                                        <th>Next Renew Date</th>


                                    </tr>


                                </thead>


                                <tbody></tbody>


                            </table>


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


$(document).ready(function(){



$('.selecter2').select2();




$("#searchservice").submit(function(e){


e.preventDefault();



$('#serviceTable').DataTable({


destroy:true,


processing:true,


serverSide:true,



ajax:{


url:"<?=base_url()?>scripts/vehicleservicelistreport.php",


type:"POST",



data:function(d){


return $.extend({},d,{


service_type:$("#service_type").val(),

search:$("#search").val()


});


}



},




columns:[


{
data:'service_type'
},


{
data:'service_date'
},


{
data:'service_location'
},


{
data:'vehicle_reg_no'
},


{
data:'vehicle_model'
},


{
data:'vehicle_brand'
},


{
data:'vehicle_type'
},


{
data:'amount',
className:'text-right',
render:function(data){

return Number(data).toLocaleString();

}

},


{
data:'description'
},


{
data:'current_mileage',
className:'text-right'
},


{
data:'next_service_mileage',
className:'text-right'
},


{
data:'next_service_date'
},


{
data:'next_renew_date'
}



],




dom: "<'row'<'col-sm-4'B><'col-sm-3'l><'col-sm-5'f>>"+
"<'row'<'col-sm-12'tr>>"+
"<'row'<'col-sm-5'i><'col-sm-7'p>>",




responsive:true,



lengthMenu:[

[-1],

['All']

],




buttons:[



{


extend:'pdf',

className:'btn btn-primary btn-sm',

text:'<i class="fas fa-file-pdf mr-2"></i> PDF',

title:'Vehicle Service Report',

filename:'Vehicle Service Report'


},




{


extend:'excel',

className:'btn btn-success btn-sm',

text:'<i class="fas fa-file-excel mr-2"></i> EXCEL',

title:'Vehicle Service Report'


},




{


extend:'csv',

className:'btn btn-info btn-sm',

text:'<i class="fas fa-file-csv mr-2"></i> CSV'


},




{


extend:'print',

className:'btn btn-warning btn-sm',

text:'<i class="fas fa-print mr-2"></i> PRINT',

title:'Vehicle Service Report'


}



]



});



});



});



</script>



<?php include "include/footer.php"; ?>