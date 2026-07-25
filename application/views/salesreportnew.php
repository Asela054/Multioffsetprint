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
<i class="fas fa-chart-line"></i>
</div>

<span>
&nbsp; Sales Report
</span>


</h1>


</div>

</div>

</div>




<div class="container-fluid mt-2 p-2">


<div class="card">


<div class="card-body">


<form id="searchsales">


<div class="form-row">



<div class="col-3">


<label class="small font-weight-bold">
Customer
</label>


<select class="form-control form-control-sm selecter2"
id="customer">


<option value="all">
All
</option>



<?php foreach($getcustomer->result() as $row){ ?>

<option value="<?php echo $row->idtbl_customer;?>">

<?php echo $row->customer;?>

</option>


<?php } ?>


</select>


</div>




<div class="col-2">


<label class="small font-weight-bold">
Date From
</label>


<input type="date"
class="form-control form-control-sm"
id="date_from">


</div>



<div class="col-2">


<label class="small font-weight-bold">
Date To
</label>


<input type="date"
class="form-control form-control-sm"
id="date_to">


</div>



<div class="col-2">
<br>


<button class="btn btn-info btn-sm"
type="submit">


<i class="fas fa-search"></i>
Search


</button>


</div>



</div>



</form>


<hr>




<table class="table table-bordered table-striped table-sm nowrap w-100"
id="dataTable">


<thead class="thead-light">


<tr>


<th>
Invoice No
</th>


<th>
Date
</th>


<th>
Customer Name
</th>


<th>
Description
</th>


<th class="text-right">
Amount Without Tax
</th>


</tr>


</thead>



<tbody></tbody>



</table>



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



$("#searchsales").submit(function(e){


e.preventDefault();



$('#dataTable').DataTable({


destroy:true,


processing:true,


serverSide:true,



ajax:{


url:"<?php echo base_url();?>scripts/saleslistreport.php",


type:"POST",


data:function(d){


return $.extend({},d,{


customer:$("#customer").val(),

search_from_date:$("#date_from").val(),

search_to_date:$("#date_to").val()


});


}


},



columns:[


{data:'inv_no'},


{data:'date'},


{data:'customer'},


{data:'description'},


{
    data:'amount',
    className:'text-right',
    render: function(data, type, row){
        return parseFloat(data).toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }
}

],



dom:"<'row'<'col-sm-4'B><'col-sm-3'l><'col-sm-5'f>>"+
"<'row'<'col-sm-12'tr>>"+
"<'row'<'col-sm-5'i><'col-sm-7'p>>",



buttons:[


{
extend:'excel',
className:'btn btn-success btn-sm',
title:'Sales Report'
},


{
extend:'pdf',
className:'btn btn-primary btn-sm',
title:'Sales Report'
},


{
extend:'print',
className:'btn btn-warning btn-sm',
title:'Sales Report'
}


]


});



});



});


</script>


<?php include "include/footer.php"; ?>