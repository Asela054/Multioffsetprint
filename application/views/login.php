<?php include "include/header.php"; ?>
<?php
 $companyaql="SELECT * FROM `tbl_company`";
 $companylist = $this->db->query($companyaql);
?>
<div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
        <main>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4">
                        <div class="card shadow-lg mt-5">
                            <div class="card-header justify-content-center bg-transparent"><img src="<?php echo base_url() ?>images/book.jpg" class="img-fluid" alt="" style="width: 200px;"></div>
                            <div class="card-body pt-3">
                                <form action="<?php echo base_url() ?>Welcome/LoginUser" method="post" autocomplete="off">
                                    <div class="form-group mb-1">
                                        <label class="small mb-1" for="inputEmailAddress">Email</label>
                                        <input class="form-control form-control-sm py-3" id="username" name="username" type="email" placeholder="Email" autofocus />
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small mb-1" for="inputPassword">Password</label>
                                        <input class="form-control form-control-sm py-3" id="password" name="password" type="password" placeholder="****" />
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Company*</label>
                                        <select class="form-control form-control-sm " name="company_id" id="company_id"
                                            required>
                                            <option value="">Select</option>
                                            <?php foreach($companylist->result() as $rowcompanylist){ ?>
                                            <option value="<?php echo $rowcompanylist->idtbl_company ?>">
                                                <?php echo $rowcompanylist->company ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Company Branch*</label>
                                        <select class="form-control form-control-sm" name="branch_id" id="branch_id"
                                            required>
                                            <option value="">Select</option>
                                            
                                        </select>
                                    </div>
                                    <input type="hidden" name="company_text" id="company_text">
                                    <input type="hidden" name="branch_text" id="branch_text">
                                    <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0"><button type="submit" class="btn btn-dark btn-sm ml-auto px-4"><i class="fas fa-lock mr-2"></i>Login</button></div>
                                </form>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-12 small text-center">Copyright &copy; Erav Technology <?php echo date('Y') ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<?php include "include/footerscripts.php"; ?>
<?php include "include/footer.php"; ?>

<script>
    $(document).ready(function() {
        sessionStorage.clear();

        $('#company_id').change(function() {
            var company_id = $(this).val();
            if (company_id != '') {
                $.ajax({
                    url: '<?php echo base_url('Welcome/Getbranchaccocompany'); ?>', // Replace with your actual controller and method
                    type: 'post',
                    data: {company_id: company_id},
                    dataType: 'json',
                    success:function(response) {
                        var len = response.length;
                        $('#branch_id').empty();
                        $('#branch_id').append("<option value=''>Select</option>");
                        for (var i = 0; i < len; i++) {
                            var id = response[i]['idtbl_company_branch'];
                            var name = response[i]['branch'];
                            $('#branch_id').append("<option value='" + id + "'>" + name + "</option>");
                        }
                    }
                });
            } else {
                $('#branch_id').empty();
                $('#branch_id').append("<option value=''>Select</option>");
            }
        });


        $('#branch_id').change(function() {
            var companyname = $("#company_id option:selected").text().trim();;
            var branchname = $("#branch_id option:selected").text().trim();;

            $('#company_text').val(companyname);
            $('#branch_text').val(branchname);
        })
    });
</script>