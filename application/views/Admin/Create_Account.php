<!DOCTYPE html>
<html lang="en">

    <!-- Mirrored from thevectorlab.net/flatlab/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 13 Jun 2017 05:32:47 GMT -->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Mosaddek">
        <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
        <link rel="shortcut icon" href="img/favicon.html">

        <title>Order Fresh Shop</title>

        <?php $this->load->view('template/headerlink'); ?>
    </head>

    <body>

        <section id="container">
            <!--header start-->
            <?php $this->load->view('template/header'); ?>
            <!--header end-->

            <!--sidebar start-->
            <?php $this->load->view('template/sidebar'); ?>
            <!--sidebar end-->

            <!--main content start-->
            <section id="main-content" class="stock-manage">
                <section class="wrapper">
                    <div class="col-lg-12">

                        <div class="main-box clearfix">

                            <?php if ($this->session->userdata('error') != ""): ?>
                                <div id="errordiv1"
                                     class="alert <?php echo $this->session->userdata('errorcls'); ?> alert-dismissable">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <?php echo $this->session->userdata('error'); ?>
                                </div>
                                <?php
                            endif;
                            $this->session->unset_userdata('error');
                            ?>

                            <div class="">
<header class="panel-heading">
                                <ul class="nav nav-tabs" id="myTab">
                                    <li class="active"><a data-toggle="tab" href="#home">View</a></li>
                                    <li><a data-toggle="tab" href="#menu1">Add</a></li>
                                </ul>
</header><div class="col-lg-12 col-sm-12 col-lg-12 col-md-12">
                                <div class="tab-content">
                                    <div id="home" class="tab-pane fade in active">

                                        <table class="table table-responsive table-striped table-bordered optimize-spacing three-btns" width="100%">
                                            <thead>
                                                <tr>
                                                    <th><span>#</span></th>
                                                    <th><span>Name</span></a></th>
                                                    <th><span>Order Code</span></a></th>
                                                    <th><span>Email</span></th>
                                                    <th><span>Store Address</span></th>
                                                    <th><span>Store Phone</span></th>
                                                    <th><span>Role</span></th>
													<th><span>Discount</span></th>
													<th><span>SMS</span></th>
                                                    <th style="width: 75px;"><span>Action</span></th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody">

                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="menu1" class="tab-pane fade">
                                        <div class="table-responsive">


                                            <form name="ff" method="post"
                                                  action="<?php echo base_url() . 'Admin/' . $this->uri->segment(2) . '/addData'; ?>">
                                                <div class="panel-body">

                                                    <div class="form-group col-lg-6">
                                                        <label>Name*</label>
                                                        <input type="text" name="adminname" class="form-control" placeholder="Enter Name" >
                                                    </div>
                                                    <div class="form-group col-lg-6">
                                                        <label>Order Code*</label>
                                                        <input type="text" name="short_name" class="form-control" placeholder="Enter Order Code" >
                                                    </div>
                                                    <div class="form-group col-lg-6">
                                                        <label>Email*</label>
                                                        <input type="email" name="email" class="form-control" placeholder="Enter Email" >
                                                    </div>
                                                    <div class="form-group col-lg-6">
                                                        <label>Password*</label>
                                                        <input type="password" name="pwd" class="form-control pwd" placeholder="Enter Password" >
                                                    </div>
                                                    <div class="form-group col-lg-6">
                                                        <label>Confirm Password*</label>
                                                        <input type="password" name="con_pwd" class="form-control pwd1" placeholder="Enter Confirm Password" >
                                                    </div>
                                                    <div class="form-group col-lg-6">
                                                        <label>Store Phone No</label>
                                                        <input type="text" name="phone" class="form-control" placeholder="Enter Phone No" >
                                                    </div>
                                                    <div class="form-group col-lg-6">
                                                        <label>Address*</label>
                                                        <textarea name="address" class="form-control"></textarea>
                                                    </div>
                                                    <div class="form-group col-lg-8">
                                                        <label>Type*</label>
                                                        <select class="form-control" name="type">
                                                            <option value="SA">Sub-Admin</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-lg-6">
                                                        <label>Status*</label>
                                                        <label class="radio-inline"><input type="radio" name="status" value="A"  checked> Active</label>
                                                        <label class="radio-inline"><input type="radio" name="status" value="D"> De-Active</label>

                                                    </div>
                                                    <div class="form-group col-lg-12 ">
                                                        <input type="submit" class="btn btn-primary"  value="Submit">
                                                    </div>
                                                </div>
                                            </form>


                                        </div>
                                    </div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        &nbsp;
                    </div>
                    <div class="row">
                        &nbsp;
                    </div>
                    <div class="row">
                        &nbsp;
                    </div>
                    <div class="row">
                        &nbsp;
                    </div>

                </section>
            </section>
            <!--main content end-->



            <!--footer start-->
            <?php $this->load->view('template/footer'); ?>
            <!--footer end-->
        </section>
        <div class="modal fade" id="editmenu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Editing Menu</h4>
                            </div>
                            <form role="form" method="post"
                                  action="<?php echo base_url('Admin/Helper/UpdateData'); ?>">
                                <div class="modal-body">
                                    <div class="panel-body">

                                                    <div class="form-group col-lg-6">
                                                        <label>Name*</label>
                                                        <input type="hidden" id="hid" name="hid" >
                                                        <input type="hidden" id="tbl" name="tbl" value="of_admin">
                                                        <input type="text" id="adminname" name="name" class="form-control" placeholder="Enter Name" >
                                                    </div>
                                                    <div class="form-group col-lg-6">
                                                        <label>Order Code*</label>
                                                        <input type="text" id="short_name" name="short_name" class="form-control" placeholder="Enter Order Code" >
                                                    </div>
                                                    <div class="form-group col-lg-6">
                                                        <label>Email*</label>
                                                        <input type="email" id="email" name="email" class="form-control" placeholder="Enter Email" >
                                                    </div>                                            
                                                    <div class="form-group col-lg-6">
                                                        <label>Store Phone No</label>
                                                        <input type="text" id ="phone" name="phone" class="form-control" placeholder="Enter Phone No" >
                                                    </div>
                                                    <div class="form-group col-lg-6">
                                                        <label>Address*</label>
                                                        <textarea id="address" name="address" class="form-control"></textarea>
                                                    </div>                                            
                                                </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
        <!-- js placed at the end of the document so the pages load faster -->
        <?php $this->load->view('template/footerlink'); ?>
        <script>
            $('.pwd1').change(function () {
                var pass = $('.pwd').val();
                var passs = $('.pwd1').val();
                if (passs != pass)
                {
                    alert('Confirm Password Not Match..');
                    $('.pwd1').val('');
                    $('.pwd1').focus();
                    return false;
                }
            });
        </script>
        <script>
            var tbl = 'of_admin';
            var cntrl = '<?php echo $this->uri->segment(1); ?>';
            var tabs = $('.table').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "<?php echo base_url() . 'Admin/' . $this->uri->segment(2) . '/GetData'; ?>"
            });
            $('#tbody').on('click', '.status', function () {
                var id = $(this).data('id');
                var st = $(this).data('status');

                if (st == "A") {
                    var msg = "You won't be deactive this menu?";
                    var btn = 'Yes, De-active it!';
                    var title = "De-Activate";
                } else {
                    var msg = "You won't be active this menu?";
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
                                        'Selected Menu has been ' + title + '.',
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
                                'Your imaginary file is safe :)',
                                'error'
                                )
                    }
                })
            });
			$('#tbody').on('click', '.discount', function () {
                var id = $(this).data('id');
                var st = $(this).data('discount');
				console.log(st);
                if (st == "D") {
                    var msg = "You won't be deactive this Discount?";
                    var btn = 'Yes, De-active it!';
                    var title = "De-Activate";
                } else {
                    var msg = "You won't be active this Discount?";
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
                        data: {'id': id, 'discount': st, 'tbl': tbl},
                        url: '<?php echo base_url('Helper/change_discount'); ?>',
                        dataType: 'json',
                        success: function (data) {
                            if (data == 1) {
                                swal(
                                        'Successfully!',
                                        'Selected Menu has been ' + title + '.',
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
                                'Your imaginary file is safe :)',
                                'error'
                                )
                    }
                })
            });
			$('#tbody').on('click', '.sms', function () {
                var id = $(this).data('id');
                var st = $(this).data('sms');
				
                if (st == "D") {
                    var msg = "You won't be deactive this sms?";
                    var btn = 'Yes, De-active it!';
                    var title = "De-Activate";
                } else {
                    var msg = "You won't be active this sms?";
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
                        data: {'id': id, 'sms': st, 'tbl': tbl},
                        url: '<?php echo base_url('Helper/change_sms'); ?>',
                        dataType: 'json',
                        success: function (data) {
                            if (data == 1) {
                                swal(
                                        'Successfully!',
                                        'Selected Menu has been ' + title + '.',
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
                                'Your imaginary file is safe :)',
                                'error'
                                )
                    }
                })
            });
            $('#tbody').on('click', '.delete', function () {
                var id = $(this).data('id');
                var st = $(this).data('status');
                swal({
                    title: 'Are you sure?',
                    text: "You won't be delete this menu",
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
                                        'Selected Menu has been  Deleted.',
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
                                'Your imaginary menu is safe :)',
                                'error'
                                )
                    }
                })
            });
            $('#tbody').on('click', '.edit', function () {
                var id = $(this).data('id');
                console.log('edit no:'+id);
                $.ajax({
                    type: 'post',
                    data: {'id': id, 'tbl': tbl},
                    url: '<?php echo base_url('Helper/GetEditData'); ?>',
                    dataType: 'json',
                    success: function (data) {
                        $('#adminname').val(data.name);
                        $('#hid').val(data.of_admin_id);
                        $('#short_name').val(data.short_name);
                        $('#address').val(data.address);
                        $('#phone').val(data.phone);
                        $('#email').val(data.username);
                        $('#status').val(data.status);                        
                        //$('#tblhid').val(tbl);
                        //$('#tblcntrl').val(cntrl);
                        $('#editmenu').modal('show');
                    }
                });
            });

        </script>

    </body>

</html>

