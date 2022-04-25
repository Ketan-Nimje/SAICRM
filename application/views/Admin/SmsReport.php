<html>
    <head>

        <?php $this->load->view('template/headerlink'); ?>    
    </head>

    <body class="fix-header">
        <!-- ============================================================== -->
        <!-- Wrapper -->
        <!-- ============================================================== -->
        <div id="wrapper">

            <!--header start-->
            <?php $this->load->view('template/header'); ?>
            <!--header end-->

            <!--sidebar start-->
            <?php $this->load->view('template/sidebar'); ?>
            <!--sidebar end-->

            <!--main content start-->
            <!-- ============================================================== -->
            <!-- Page Content -->
            <!-- ============================================================== -->
            <div id="page-wrapper">
                <div class="container-fluid"><?php if ($this->session->flashdata('error') != ""): ?>
                        <div class="row bg-title"> 

                            <div id="errordiv1"
                                 class="alert <?php echo $this->session->flashdata('errorcls'); ?> alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <?php echo $this->session->flashdata('error'); ?>
                            </div>

                        </div>
                        <?php
                    endif;
                    ?>    
                    <!-- ============================================================== -->
                    <!-- Different data Product -->
                    <!-- ============================================================== -->
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">                               
                            <div class="white-box">
                                <header>
                                    <ul class="nav nav-tabs" id="myTab">
                                        <li class="active"><a data-toggle="tab" href="#home" id="view">View</a></li>
                                        <li><a data-toggle="tab" href="#menu1">Add/Edit</a></li>
                                    </ul>
                                </header>
                                <div class="tab-content">
                                    <div id="home" class="tab-pane fade in active">    
                                        <div class="panel">
                                            <div class="panel-heading">MANAGE Product</div>
                                            <div class="table-responsive">
                                                <table id="product" class="table table-striped table-bordered manage-u-table">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">#</th>
                                                            <th title="Staff / Team Leader">UserName</th>    
                                                            <th>Role</th>
                                                            <th>Date</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>                            
                                    <div id="menu1" class="tab-pane fade">  
                                        <div class="panel">
                                            <div id="paneltitle" class="panel-heading">Add Product</div> 
                                            <div id="panelupdate" class="panel-heading">Update Product</div> 
                                            <form name="ff" class="form-horizontal" method="post"
                                                  action="<?php echo base_url() . 'Admin/' . $this->uri->segment(2) . '/addData'; ?>" id="form1">       
                                                <div class="form-group">
                                                    <label class="col-md-12">Product Name <span class="help"> e.g. "Genius"</span></label>
                                                    <div class="col-md-12">
                                                        <input  type="hidden" name="hid" id="hid" >
                                                        <input type="text" name="p_name" id="p_name" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="form-group checkbox checkbox-success">
                                                    <div class="col-md-12">
                                                        <input name="c_id" id="c_id" type="checkbox">
                                                        <label for="c_id"> Is conversion Product  </label>
                                                    </div>
                                                </div> 

                                                <div class="form-group " id="conversion" style="display: none;">
                                                    <label class="col-sm-12">Conversion Product Select </label>
                                                    <div class="col-sm-12">
                                                        <select class="form-control" name="conversion_id" id="conversion_id">
                                                            <option value="0">Select Product</option>
                                                            <?php
                                                            foreach ($product as $p_value) {
                                                                echo "<option value='" . $p_value['si_product_id'] . "'>" . $p_value['p_name'] . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-12">Category Select</label>
                                                    <div class="col-sm-12">
                                                        <select class="form-control" name=" category_id" id="category_id">
                                                            <option value="1">Installtion</option>
                                                            <option value="2">Updatation</option>
                                                            <option value="3">Lan</option>
                                                            <option value="4">Conversion</option>    
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        <input type="submit" name="btn" id="btn_stm" class="btn btn-success aves-effect waves-light m-r-10" value="Add"> <input type="reset" class="btn btn-danger" value="Reset" id="reset" name="reset">
                                                    </div>
                                                </div>                      
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                            
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
        <!--footer start-->
        <?php $this->load->view('template/footer'); ?>
        <!--footer end-->
    </div>
    <!-- ============================================================== -->
    <!-- End Page Content -->
    <!-- ============================================================== -->
    <!--main content end -->
</div>  
<div id="inquiryModel" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Add Product</h4> </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Recipient:</label>
                        <input type="text" class="form-control" id="recipient-name"> </div>
                    <div class="form-group">
                        <label for="message-text" class="control-label">Message:</label>
                        <textarea class="form-control" id="message-text"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger waves-effect waves-light">Save changes</button>
            </div>
        </div>
    </div>
</div>

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <form method="post" action="<?php echo base_url("Admin/SmsReport/addCustomerSolution"); ?>" >
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title inquiry">Customer Inquiry</h4>
                </div>

                <div class="modal-body clearfix">

                    <input type="hidden" name="csId" id="hdnCS_id">
                    <div class="SmsRemarkDiv" style="display: none;"> 
                        <div class="col-sm-12">
                            <?php if ($this->session->userdata('role') == 'TL') { ?>
                                <div class="radio radio-inline radio-danger">
                                    <input name="s_type" id="radio2" value="SendTL" type="radio" required>
                                    <label for="radio2"> Solve By <?php echo $_SESSION['name']; ?> (Team Leader) </label>
                                </div>
                                <div class="radio radio-inline radio-danger">
                                    <input name="s_type" id="radio3" value="SendAdmin" type="radio" required>
                                    <label for="radio3"> Send To Admin </label>
                                </div>  
                            <?php } ?>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-md-12">Remark</label>
                            <div class="col-md-12">
                                <textarea class="form-control" rows="7" required="" name="remark"></textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                            <button type="button" class="btn btn-inverse waves-effect waves-light" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                    <div class="row" id="customer">
                        <div class="col-sm-12">
                            <div class="white-box bg-white-dark">
                                <h3 class="box-title m-b-10">Customer Product Solution Detail
                              <!-- <button class="btn btn-success waves-effect waves-light fix-btn m-l-10" type="button" data-toggle="modal" data-target="#productadd"><span class="btn-label"><i class="fa fa-plus"></i></span>Add Product</button>--></h3> 
                                <div class="table-responsive">
                                    <table id="customersolution" class="table table-striped table-bordered optimize-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Solution By</th>
                                                <th>Remark</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="modal-footer">
                    <!--<button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>-->
                    <button type="button" class="btn btn-inverse waves-effect waves-light" data-dismiss="modal">Close</button>
                </div>
        </form>

    </div>
</div>
<!-- js placed at the end of the document so the pages load faster -->
<?php $this->load->view('template/footerlink'); ?>
</body>
<script>
    $('#c_id').change(function () {
        if (!this.checked)
            $('#conversion').fadeOut('slow');
        else
            $('#conversion').fadeIn('slow');
    });
    $('#panelupdate').hide();
    
    var tabs = $('#product').DataTable({
        "processing": true,
        "serverSide": true,
         "lengthMenu": [[10, 50, 100,500,1000], [10, 50, 100,500,1000]],
        "pageLength": 50,
        "ajax": {"url":"<?php echo base_url() . 'Admin/SmsReport/getCustomerSolution'; ?>",},
        //"aoColumnDefs": [{ 'bSortable': false, 'aTargets': [0,-1] }],
        "order": [[ 0, "DESC" ]]
    });
    
    
    $('#product>tbody').on('click', '.status', function () {
        var id = $(this).data('id');
        var st = $(this).data('status');

        if (st != "A") {
            var msg = "You won't be deactive this Product?";
            var btn = 'Yes, De-active it!';
            var title = "De-Activate";
        } else {
            var msg = "You won't be active this Product?";
            var btn = 'Yes, Active it!';
            var title = "Activate";
        }

        swal({
            title: 'Are you sure?',
            text: msg,
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: btn,
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false
        }).then(function () {
            $.ajax({
                type: 'post',
                data: {'id': id, 'status': st, 'tbl': tbl},
                url: '<?php echo base_url('Helper/change_status'); ?>',
                dataType: 'json',
                success: function (data) {
                    if (data == 1) {
                        swal(
                                'Successfully!',
                                'Selected Product has been ' + title + '.',
                                'success'
                                )
                        tabs.draw();
                    }
                }
            });
        }, function (dismiss) {
            if (dismiss === 'cancel') {
                swal(
                        'Cancelled',
                        'Your imaginary Product is safe :)',
                        'error'
                        )
            }
        })
    });
    $('#product>tbody').on('click', '.delete', function () {
        var id = $(this).data('id');
        var st = $(this).data('status');
        swal({
            title: 'Are you sure?',
            text: "You won't be delete this Product",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete it!',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false
        }).then(function () {
            $.ajax({
                type: 'post',
                url: '<?php echo base_url('Helper/change_status'); ?>',
                data: {'id': id, 'status': st, 'tbl': tbl},
                dataType: 'html',
                success: function (data) {
                    if (data == 1) {
                        swal(
                                'Successfully!',
                                'Selected Product has been  Deleted.',
                                'success'
                                )
                        tabs.draw();
                    }
                }
            });
        }, function (dismiss) {
            if (dismiss === 'cancel') {
                swal(
                        'Cancelled',
                        'Your imaginary Product is safe :)',
                        'error'
                        )
            }
        })
    });
    $('#product>tbody').on('click', '.views', function () {
        var id = $(this).data('id');
        var rid = $("#dynOrderRow").data('id');
        $('.odd').removeClass("trcolor");
        $('.even').removeClass("trcolor");
        if (rid == id) {
            $("#hiddenRowId").val('');
            $("#Rows_id" + id).removeClass("trcolor");
            $("#dynOrderRow").remove();
            return false;
        } else {
            $("#Rows_id" + id).addClass("trcolor");
            TreeTable(id);
        }
//        $.ajax({
//            type: 'post',
//            data: {'id': id},
//            url: '<?php echo base_url('Admin/SmsReport/StaffInquiry'); ?>',
//            dataType: 'json',
//            success: function (data) {
//                
//                $('#inquiryModel').modal('show');
//            }
//        });
    });

    $(document).on('click', '.high', function () {
        var id = $(this).data('id');
        var st = $(this).data('status');
        var role = '<?php echo $this->session->userdata('role'); ?>';
        $.ajax({
            url: "<?php echo base_url('Admin/SmsReport/getCustomerSolutionEdit'); ?>",
            data: {'id': id, 'tbl': 'si_customer_solution'},
            method: 'post',
            dataType: 'json',
            success: function (data) {
//                console.log(data);
                $("#hdnCS_id").val(id);
                $(".inquiry").text("Customer inquiry for " + data.cs[0]['p_name'])
                if (data.csh[0]['is_complete'] == 'N') {
                    $("textarea[name=remark]").val(data.cs[0]['remark']);
                    if (role == 'TL' && st == 'TL') {
                        $(".SmsRemarkDiv").css('display', '');
                    }
                    if (role == 'SA' && st == 'AD') {
                        $(".SmsRemarkDiv").css('display', '');
                    }
                } else {
                    $(".SmsRemarkDiv").css('display', 'none');
                }
                $("#myModal").modal({backdrop: 'static', keyboard: false});
                CustomerSolutionDataTable(id);
            }
        });
    });

// View Table In Tree Start
    function TreeTable(id) {

        $("#hiddenRowId").val(id);
        $("#dynOrderRow").remove();
        $.ajax({
            url: "<?php echo base_url('Admin/SmsReport/StaffInquiry'); ?>",
            data: {'id': id},
            method: 'post',
            dataType: 'html',
            success: function (data) {
//                console.log(data);
                if (data.length > 0) {
                    $('#Rows_id' + id).after('');
                    $('#Rows_id' + id).after(data);
                } else {
                    $("#Rows_id" + id).remove();
                }
            }
        });
    }
    // View Table In Tree End

    $('#reset, #view').on('click', function () {
        $('#hid').val("");
        $('#btn_stm').val('Add');
        $('#paneltitle').show();
        $('#panelupdate').hide();
        $('.form-group input[type="text"]').val('');
    });


// Customer Solution DataTable Function Start
    function CustomerSolutionDataTable(id) {
        $('#customersolution').DataTable().destroy();
        var tabs1 = $('#customersolution').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo base_url() . 'Admin/SmsReport/CustomerSolutionHIstory'; ?>",
                "data": {
                    "id": id,
                }
            },
            "aoColumnDefs": [
                {
                    bSortable: false,
                    aTargets: [-1],
                }
            ],
        });
    }
    // Customer Solution DataTable Function End

</script>
</html>