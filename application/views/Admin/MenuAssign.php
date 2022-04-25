<!DOCTYPE html>
<html lang="en">
    <head>
        <?php $this->load->view('template/headerlink'); ?>
<!--        <link href="<?php echo base_url(); ?>assets/css/daterangepicker.css" rel="stylesheet">
        <link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
        <link rel="stylesheet" href="http://demo.expertphp.in/css/jquery.treeview.css" />-->
        <link href="<?php echo base_url(); ?>assetss/plugins/bower_components/custom-select/custom-select.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assetss/plugins/bower_components/switchery/dist/switchery.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assetss/plugins/bower_components/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assetss/plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assetss/plugins/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assetss/plugins/bower_components/multiselect/css/multi-select.css" rel="stylesheet" type="text/css" />
    </head>
    <body  class="fix-header">
        <div id="wrapper">

            <!-- side bar -->
            <?php $this->load->view('template/header') ?>
            <!-- Site bar end --> 

            <!-- Header --> 
            <?php $this->load->view('template/sidebar') ?>




            <div id="page-wrapper">
                <div class="container-fluid">

                    <div class="row">

                        <div class="white-box clearfix">
                            <?php if ($this->session->flashdata('cls') != ""): ?>
                                <div class="row bg-title"> 

                                    <div id="errordiv1"
                                         class="alert <?php echo $this->session->flashdata('cls'); ?> alert-dismissable">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <?php echo $this->session->flashdata('msg'); ?>
                                    </div>

                                </div>     <?php
                            endif;
                            ?>  
                            <section class="panel">

                                <header class="panel-heading tab-bg-dark-navy-blue ">
                                    <ul class="nav nav-tabs">

                                        <li class="active sdt1">
                                            <a data-toggle="tab" href="#about">Show Assign Menu</a>
                                        </li>

                                        <li class="sdt1">
                                            <a data-toggle="tab" href="#assign">Assign Menu</a>
                                        </li>
                                        <!--<li class="sdt">
                                            <a data-toggle="tab" href="#show_menu">Show Menu</a>
                                        </li>
                                        <li class="sdt">
                                            <a data-toggle="tab" href="#home">Add New Menu</a>
                                        </li>-->
                                    </ul>
                                </header>

                                <div class="panel-body">

                                    <div class="tab-content" style="margin: 0;">

                                        <div id="about" class="tab-pane active"> 

                                            <table id="Bank_details" class="table table-striped table-bordered" cellspacing="0"
                                                   width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Team Leader</th>
                                                        <th>Menu Assigned</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Team Leader</th>
                                                        <th>Menu Assigned</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </tr>
                                                </tfoot>
                                                <tbody>

                                                </tbody>
                                            </table>



                                        </div>
                                        <div id="assign" class="tab-pane">
                                            <form method="post" action="<?php echo base_url() ?>Admin/MenuAssign/insertLeaderMenu" name="from">
                                                <div class="">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <select class="form-control" name="type" required>
                                                                <option value="0">---Team Leader---</option>
                                                                <?php
                                                                foreach ($user as $u) {
                                                                    if ($_SESSION['id'] != $u['si_admin_id']) {
                                                                        ?>
                                                                        <option value="<?php echo $u['si_admin_id'] ?>"><?php echo $u['name'] ?></option>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-lg-8">
                                                            <div class="panel-group wow fadeInUp" id="accordion" data-wow-duration="2s">

                                                                <?php
                                                                foreach ($menu as $m) {
                                                                    ?>
                                                                    <div class="panel panel-default">
                                                                        <div class="panel-heading panel-heading-faq">
                                                                            <h4 class="panel-title">
                                                                                <?php // print_r($account['datas']) ?>
                                                                                <!--<a class="close<?php echo $m['si_main_menu_id'] ?> accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?php echo $m['si_main_menu_id'] ?>">-->
                                                                                <input type="checkbox" id="main<?php echo $m['si_main_menu_id'] ?>" name="menu[]" value="<?php echo $m['si_main_menu_id'] ?>" class="chk<?php echo $m['si_main_menu_id'] ?>" onclick="toggle(<?php echo $m['si_main_menu_id'] ?>)"> <label class="text-defaul" for="main<?php echo $m['si_main_menu_id'] ?>" ><?php echo $m['main_menu'] ?>  </label>
                                                                                <!--</a>--> 
                                                                            </h4>
                                                                            <div class="subdiv_menu" id="dropmenu<?php echo $m['si_main_menu_id'] ?>"> </div>
                                                                        </div>

                                                                        <!--
                                                                                                                        <div id="collapseOne<?php echo $m->sai_menu_id ?>" class="panel-collapse collapse<?php echo $m->sai_menu_id ?>">
                                                                                                                            <div class="panel-body panel-faq">
                                                            
                                                                                                                                <input type="checkbox" name="menu[]" onclick="toggle(<?php echo $m->sai_menu_id ?>)"> <span class="text-default"><?php echo $m->menu_name ?>  </span>
                                                            
                                                                                                                            </div>
                                                                                                                        </div>-->
                                                                    </div>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-lg-8">
                                                            <input type="submit" value="ADD" class="btn btn-primary">
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div id="show_menu" class="tab-pane">
                                            <table id="menu_details" class="table table-striped table-bordered" cellspacing="0"
                                                   width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>User</th>
                                                        <th>Menu Name</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>User</th>
                                                        <th>Menu Name</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </tr>
                                                </tfoot>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                        <div id="home" class="tab-pane">


                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="basic_info">
                                                    <div class="panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">Basic Information</h4>
                                                        </div>
                                                        <div class="panel-body">
                                                            <form method="post" action="<?php echo base_url() ?>Admin/MenuAssign/insert">

                                                                <div  class="clearfix">&nbsp;</div>
                                                                <div class="form-group col-lg-6 col-md-6">
                                                                    <label>Menu Name<span class="text-danger">(*)</span></label>
                                                                    <input type="text" name="account_type" class="form-control" id="account_type" placeholder="Menu Name ..." required="">
                                                                    <div id="error"></div>
                                                                </div>
                                                                <div class="form-group col-lg-6">
                                                                    <label>Location</label>
                                                                    <select class="form-control " name="maincat" id="maincat">
                                                                        <?php
                                                                        print_r($account['data']);
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-lg-6 col-md-6">
                                                                    <label>URL</label>
                                                                    <input type="url" name="link" class="form-control" id="link" value="<?php echo base_url(); ?>" placeholder="Enter URL ...">
                                                                </div>
                                                                <div class="form-group col-lg-6 col-md-6">
                                                                    <label>Icon<span class="text-danger">(*)</span></label>
                                                                    <input type="text" name="icon" class="form-control" id="txticon" placeholder="Enter Icon name in  font awesome class ..." required="">
                                                                </div>
                                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                    <input class="btn btn-success pull-right" name="submit" type="submit" value="Submit">
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>


                            </section>
                        </div>
                    </div>
                    <!-- row -->


                </div>
            </div>
        </div>

        <!-- Main Page-->


        <!-- End Main Page -->

        <!-- Account Edit Modal Start -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
                <form action="<?php echo base_url('Admin/MenuAssign/update'); ?>" method="post" >    
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Update Menu Assign</h4>
                        </div>

                        <div class="modal-body">
                            <div class="form-group">
                                <input type="hidden" name="edit_id" id="id">
                                <select class="form-control" name="e_type">
                                    <option value="0">---Select User---</option>
                                    <?php
                                    foreach ($user as $u) {
                                        if ($_SESSION['id'] != $u['si_admin_id']) {
                                            ?>
                                            <option value="<?php echo $u['si_admin_id'] ?>"><?php echo $u['name'] ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="panel-group wow fadeInUp" id="accordion" data-wow-duration="2s">

                                    <?php
//                                    foreach ($menu as $m) {
                                    ?>
                                    <div class="panel panel-default">
                                        <div class="panel-heading panel-heading-faq">
                                            <h4 class="panel-title">
                                                <?php print_r($account['e_datas']) ?>
                                                <!--<a class="close<?php echo $m->sai_menu_id ?> accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?php echo $m->sai_menu_id ?>">-->
                                                <!--<input type="checkbox" id="e_main<?php echo $m['si_main_menu_id'] ?>" name="menu[]" value="<?php echo $m['si_main_menu_id'] ?>" class="e_chk<?php echo $m['si_main_menu_id'] ?>" onclick="e_toggle(<?php echo $m['si_main_menu_id'] ?>)"> <label class="text-default" for="e_main<?php echo $m['si_main_menu_id'] ?>"><?php echo $m['main_menu'] ?>  </label>-->
                                                <!--</a>--> 
                                            </h4>
                                            <div class="subdiv_menu" id="dropmenu_edit<?php echo $m['si_main_menu_id'] ?>"> </div>
                                        </div>

                                        <!--
                                                                            <div id="collapseOne<?php //  echo $m->sai_menu_id                         ?>" class="panel-collapse collapse<?php //echo $m->sai_menu_id                         ?>">
                                                                                <div class="panel-body panel-faq">
                                    
                                                                                    <input type="checkbox" name="menu[]" onclick="toggle(<?php //echo $m->sai_menu_id                         ?>)"> <span class="text-default"><?php //echo $m->menu_name                         ?>  </span>
                                    
                                                                                </div>
                                                                            </div>-->
                                    </div>
                                    <?php
//                                    }
                                    ?>
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <input type="submit" class="btn btn-primary " value="Submit">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Account Edit Modal End -->

        <div class="modal fade" id="myMenuModal" role="dialog">
            <div class="modal-dialog">
                <form action="<?php echo base_url('Admin/MenuAssign/updateMenu'); ?>" method="post" >    
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Update Menu</h4>
                        </div>

                        <div class="modal-body">
                            <input type="hidden" id="hdnMenuId" name="menuId">
                            <div class="form-group">
                                <label>Menu Name<span class="text-danger">(*)</span></label>
                                <input type="text" name="menu_name" class="form-control" id="menu_name" placeholder="Menu Name ..." required="">
                            </div>
                            <div class="form-group">
                                <label>URL</label>
                                <input type="url" name="e_link" class="form-control" id="e_link" placeholder="Enter URL ...">
                            </div>
                            <div class="form-group">
                                <label>Icon<span class="text-danger">(*)</span></label>
                                <input type="text" name="e_icon" class="form-control" id="e_txticon" placeholder="Enter Icon name in  font awesome class ..." required="">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <input type="submit" class="btn btn-primary " value="Update">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php $this->load->view('template/footer'); ?>
        <?php $this->load->view('template/footerlink') ?>

<!--                    <script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/daterangepicker.js"></script>
<script src="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-treeview.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/treeview_live.js" type="text/javascript"></script>-->
        <script>
            var table;
            var table1;
            $(document).ready(function () {


                table = $('#Bank_details').DataTable({
                    order: [[0, "desc"]],
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        url: "<?php echo base_url(); ?>Admin/MenuAssign/selectLeaderMenu",
                        type: "post", // method  , by default get
                        dataType: 'json',
                    },
                    "aoColumnDefs": [
                        {
                            bSortable: false,
                            aTargets: [-1]
                        }
                    ]
                });

            })

            table1 = $('#menu_details').DataTable({
                order: [[0, "desc"]],
                "processing": true,
                "serverSide": true,
                "ajax": {
                    url: "<?php echo base_url(); ?>Admin/MenuAssign/select_Menu",
                    type: "post", // method  , by default get
                    dataType: 'json',
                },
                "aoColumnDefs": [
                    {
                        bSortable: false,
                        aTargets: [-1]
                    }
                ]
            });

            $('.sdt1').click(function () {
                $('.dd1').hide();
                $('.dd').hide();
            });
            $('.sdt').click(function () {
                $('.dd').show();
                $('.dd1').show();
            });
            function toggle(id)
            {
//        if( ! $('.panel-heading h4 a input[type=checkbox]').is(':checked') )
                if (!$('.chk' + id).is(':checked'))
                {
                    $('#dropmenu' + id).html('');

                } else {

                    $.ajax({
                        url: "<?php echo base_url() ?>Admin/MenuAssign/drop_menu",
                        method: "post",
                        dataType: "json",
                        data: {'id': id},
                        success: function (data)
                        {
                            // console.log(data);
                            // alert(data);
                            $('#dropmenu' + id).html(data);
                        }

                    })
                }
            }

            function e_toggle(id)
            {
//                alert(id); return false;
                if (!$('.e_chk' + id).is(':checked'))
                {
                    $('.subhid' + id).html('');
                } else {
                    $.ajax({
                        url: "<?php echo base_url() ?>Admin/MenuAssign/drop_menu",
                        method: "post",
                        dataType: "json",
                        data: {'id': id},
                        success: function (data)
                        {
                            $('#dropmenu_edit' + id).html(data);
                        }

                    });
                }
            }


            $(document).on('click', '.delete', function () {
                var id = $(this).data('id');
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
                        url: '<?php echo base_url('Admin/MenuAssign/DeleteAccount/'); ?>' + id,
                        dataType: 'html',
                        success: function (data) {
                            if (data == 1) {

                                swal({
                                    title: "Successfully",
                                    text: "Selected Row has been  Deleted.",
                                    type: "success"
                                }).then(function () {
                                    table.draw(false);
                                });
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
            $(document).on('click', '.del', function () {
                var id = $(this).data('id');
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
                        url: '<?php echo base_url('Admin/MenuAssign/DeleteMenu/'); ?>' + id,
                        dataType: 'html',
                        success: function (data) {
                            if (data == 1) {

                                swal({
                                    title: "Successfully",
                                    text: "Selected Row has been  Deleted.",
                                    type: "success"
                                }).then(function () {
                                    table1.draw(false);
                                });
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

            $(document).on('click', '.edit_menu', function () {
                var id = $(this).data('id');

                $('input[name=edit_id]').val(id);
                $.ajax({
                    url: '<?php echo base_url('Admin/MenuAssign/EditAccount/'); ?>' + id,
                    method: 'post',
                    dataType: 'json',
                    data: {'id': id},
                    success: function (data) {
                        console.log(data);
                        $('select[name=e_type]').val(data.si_admin_id);

                        var menu = data.si_main_menu_id.split(",");
//                         alert(JSON.stringify(menu)); return false;
                        for (var i = 0; i < menu.length; i++)
                        {
//                            $('#e_main' + menu[i]).prop('checked', true);
                            $('.e_chk' + menu[i]).prop('checked', true);
//                            e_toggle(menu[i]);
//                            $('.e_chk' + menu[i]).val(menu[i]);

                            // e_toggle(menu[i]);
                        }
                        $("#myModal").modal({backdrop: 'static', keyboard: false});

                    }
                });

            });

            $(document).on('click', '.status', function () {
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
                        data: {'id': id, 'status': st},
                        url: '<?php echo base_url('MenuAssign/StatusAccount/'); ?>',
                        dataType: 'json',
                        success: function (data) {
                            if (data == 1) {
                                //                                swal(
                                //                                        'Successfully!',
                                //                                        'Selected Menu has been ' + title + '.',
                                //                                        'success'
                                //                                        )
                                //                                tabs.draw();
                                swal({
                                    title: "Successfully",
                                    text: "Selected Menu has been " + title + ".",
                                    type: "success"
                                }).then(function () {
                                    location.reload();
                                });
                            }
                        }
                    });
                }, function (dismiss) {
                    if (dismiss === 'cancel') {
                        swal(
                                'Cancelled',
                                'Your imaginary file is safe :)',
                                'error'
                                );

                    }
                })
            });

            $(document).on('click', '.edit', function () {
            
                var id = $(this).data('id');
                $('#hdnMenuId').val(id);
                $.ajax({
                    url: '<?php echo base_url('Admin/MenuAssign/EditMenu/'); ?>' + id,
                    method: 'post',
                    dataType: 'json',
                    data: {'id': id},
                    success: function (data) {
//                        console.log(data);
                        $("#menu_name").val(data.main_menu);
                        $("#e_link").val(data.link);
                        $("#e_txticon").val(data.icon);
                        $("#myMenuModal").modal({backdrop: 'static', keyboard: false});
                    }
                });
            });
        </script>


