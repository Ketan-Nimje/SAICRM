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
            <?php  $this->load->view('template/header'); ?>
            <!--header end-->

            <!--sidebar start-->
            <?php $this->load->view('template/sidebar'); ?>
            <!--sidebar end-->

            <!--main content start-->
             <!-- ============================================================== -->
        <!-- Page Content -->
        <!-- ============================================================== -->
        <div id="page-wrapper">
            <div class="container-fluid">
             <?php if ($this->session->userdata('error') != ""): ?>
                <div class="row bg-title"> 
                           
                                <div id="errordiv1"
                                     class="alert <?php echo $this->session->userdata('errorcls'); ?> alert-dismissable">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <?php echo $this->session->userdata('error'); ?>
                                </div>
                                         
                </div>
                 <?php
                            endif;
                            $this->session->unset_userdata('error');
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
                                                        <div class="panel-heading">Manage Years</div>
                                                        <div class="table-responsive">
                                                            <table id="product" class="table table-hover manage-u-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="70" class="text-center">#</th>
                                                                        <th>NAME</th>    
                                                                        <th width="300">Action</th>
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
                                                      <div id="paneltitle" class="panel-heading">Add Year</div> 
                                                      <div id="panelupdate" class="panel-heading">Update Year</div> 
                                                    <form name="ff" class="form-horizontal" method="post"
                                                          action="<?php echo base_url() . 'Admin/' . $this->uri->segment(2) . '/addData'; ?>">       
                                                            <div class="form-group">
                                                                <label class="col-md-12">Year Name <span class="help"> E.g. "2018-2019"</span></label>
                                                                <div class="col-md-12">
                                                                <input  type="hidden" name="hid" id="hid" >
                                                                <input type="text" name="yearname" id="yearname" class="form-control">
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
    <!-- js placed at the end of the document so the pages load faster -->
    <?php $this->load->view('template/footerlink'); ?>
    </body>
    <script>
            var tbl = 'si_for_year';
            $('#panelupdate').hide();
            var cntrl = '<?php echo $this->uri->segment(2); ?>';            
            var tabs = $('#product').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "<?php echo base_url() . 'Admin/Foryear/GetData'; ?>",
                "aoColumnDefs": [{ 'bSortable': false,'aTargets': [0,-1]  }],
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
                                        'Selected Year has been ' + title + '.',
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
                                'Your imaginary Year is safe :)',
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
                    text: "You won't be delete this Year",
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
                                        'Selected Year has been  Deleted.',
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
                                'Your imaginary Year is safe :)',
                                'error'
                                )
                    }
                })
            });
            $('#product>tbody').on('click', '.edit', function () {
                var id = $(this).data('id');
                $.ajax({
                    type: 'post',
                    data: {'id': id, 'tbl': tbl},
                    url: '<?php echo base_url('Helper/GetEditData'); ?>',
                    dataType: 'json',
                    success: function (data) {                        
                        $('#myTab a[href="#menu1"]').tab('show');
                        $('#paneltitle').hide();
                        $('#panelupdate').show();
                        $('#yearname').val(data.yearname);
                        $('#hid').val(data.si_for_year_id);
                        $('#btn_stm').val('update');
                        $('#tblhid').val(tbl);
                        $('#tblcntrl').val(cntrl);
                        $('#editmenu').modal('show');
                    }
                });
            });

			$('#reset, #view').on('click',function(){
					$('#hid').val("");
					$('#btn_stm').val('Add');
					$('#paneltitle').show();
					$('#panelupdate').hide();
					$('.form-group input[type="text"]').val('');
				});        

</script>
</html>