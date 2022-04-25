<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="keywords" content="">


        <title>
            Sai Infotech | Admin
        </title>

        <?php $this->load->view('template/headerlink'); ?>
    </head>
    <body>
        <!--header start-->
        <?php $this->load->view('template/header'); ?>
        <!--header end-->
        <?php $this->load->view('template/sidebar'); ?>
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content">

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="panel panel-bd lobidisable">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h4>ADMINISTRATOR</h4>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div id="errordiv" class="alert alert-dismissable" style="display: none;">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <p id="errordivmsg"></p>
                            </div>
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tab1" data-toggle="tab">Record's</a></li>
                                <li><a href="#tab2" data-toggle="tab">Add New Administrator</a></li>
                                <!--<li><a href="#tab3" data-toggle="tab">Add New Client CSV</a></li>-->
                            </ul>
                            <!-- Tab panels -->
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="tab1">

                                    <div class="panel-body">
                                        <table id="Bank_details" class="table table-striped table-bordered" cellspacing="0"
                                               width="100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Username</th>
                                                    <th>Phone</th>
                                                    <th>Type</th>
                                                    <th>Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                <tr>
                                                    <th#</th>
                                                <th>Name</th>
                                                <th>Username</th>
                                                <th>Phone</th>
                                                <th>Type</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                            </tr>
                                        </tfoot>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab2">
                                <div id="errordiv1" class="alert alert-dismissable" style="display: none;">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <p id="errordivmsg1"></p>
                                </div>
                                <form  method="post" name="ff">
                                    <div class="panel-body">

                                        <div class="form-group col-lg-6">
                                            <label>Name*</label>
                                            <input type="text" name="adminname" class="form-control" placeholder="Enter Name" >
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label>Username*</label>
                                            <input type="text" name="username" class="form-control" placeholder="Enter Username" >
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label>Phone*</label>
                                            <input type="text" maxlength="10" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.keyCode === 8" name="phone" class="form-control" placeholder="Enter Phone" >
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label>Password*</label>
                                            <input type="password" name="pwd" class="form-control" placeholder="Enter Password" >
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label>Confirm Password*</label>
                                            <input type="password" name="con_pwd" class="form-control" placeholder="Enter Confirm Password" >
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label>Type*</label>
                                            <select class="form-control" name="type">
                                                <option value="0">---Select Type---</option>
                                                <option value="SA">Admin</option>
                                                <option value="A" selected="">Staff</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label>Status*</label>
                                            <label class="radio-inline"><input type="radio" name="status" value="A"  checked> Active</label>
                                            <label class="radio-inline"><input type="radio" name="status" value="D"> De-Active</label>

                                        </div>
                                        <div class="form-group col-lg-12 ">
                                            <input type="button" class="btn btn-primary" onclick="add_admin()" value="Submit">
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
    </div>
</section>
<!--  News Edit Model  start-->
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog" data-backdrop='static'  data-keyboard='false'>
    <div class="modal-dialog">
        <form action="<?php echo base_url('Admin/Sadmin/update'); ?>" method="post">    
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">UPDATE PROFILE (ADMIN/SUB ADMIN)</h4>
                </div>

                <div class="modal-body">
                    <div id="errordiv2" class="alert alert-dismissable" style="display: none;">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <p id="errordivmsg2"></p>
                    </div>
                    <div class="form-group  col-lg-6">
                        <label>Name*</label>
                        <input type="text" name="e_name" class="form-control" placeholder="Enter Name" >
                        <input type="hidden" name="edit_id">
                    </div>
                    <div class="form-group col-lg-6">
                        <label>Username*</label>
                        <input type="text" name="e_username" class="form-control" placeholder="Enter Username" >
                    </div>
                    <div class="form-group col-lg-6">
                        <label>Phone*</label>
                        <input type="text" maxlength="10" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.keyCode === 8" name="e_phone" class="form-control" placeholder="Enter Phone" >
                    </div>
                    <div class="form-group  col-lg-6">
                        <label>Password*</label>
                        <input type="password" name="e_pwd" class="form-control" placeholder="Enter Password" >
                    </div>
                    <div class="form-group  col-lg-6">
                        <label>Confirm Password*</label>
                        <input type="password" name="e_con_pwd" class="form-control" placeholder="Enter Confirm Password" >
                    </div>
                    <div class="form-group  col-lg-6">
                        <label>Type*</label>
                        <select class="form-control" name="e_type">
                            <option value="0">---Select Type---</option>
                            <option value="SA">Admin</option>
                            <option value="A">Staff</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <input type="button" onclick="update_admin()" class="btn btn-primary " value="Submit">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!--  News Edit Model  End-->
</div>

<?php $this->load->view('template/footer'); ?>

<?php $this->load->view('template/footerlink'); ?>
<script type="text/javascript">
    var table;
    $(document).ready(function () {


        table = $('#Bank_details').DataTable({
            order: [[0, "desc"]],
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "<?php echo base_url(); ?>Admin/Sadmin/select_sadmin",
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




    function edit_sadmin(id)
    {
        $('input[name=edit_id]').val(id);
        $.ajax({
            url: '<?php echo base_url() . 'Admin/Sadmin/edit'; ?>',
            method: 'post',
            dataType: 'json',
            data: {'id': id},
            success: function (data) {
                console.log(data);
                console.log(data.name);
                $('input[name=e_name]').val(data.name);
                $('input[name=e_username]').val(data.username);
                $('input[name=e_phone]').val(data.phone);
                $('input[name=e_pwd]').val(data.password);
                $('input[name=e_con_pwd]').val(data.password);
                $('select[name=e_type]').val(data.role);
            }
        });
    }

    function sts(i, c) {

        var prop = "", msg = "";
        $.ajax({
            type: 'POST',
            data: {
                'id': i,
                'status': c,
                'tbl': 'si_admin'
            },
            url: '<?php echo base_url(); ?>Helper/change_status',
            dataType: 'json',
            success: function (data) {
                if (data == 1 && c == 'A') {
                    $('#errordiv').show();
                    $('#errordivmsg').show();
                    prop = 'alert alert-success alert-dismissable';
                    msg = '<strong>Success!</strong> Status Activated.';
                } else {
                    $('#errordiv').show();
                    $('#errordivmsg').show();
                    prop = 'alert alert-warning alert-dismissable';
                    msg = '<strong>Success!</strong> Status De-Activated.';
                }
                $('#errordiv').prop('class', prop);
                $('#errordivmsg').html(msg);
                table.draw(false);
                setTimeout(hide, 3000);
            }
        });

    }
    function dlt(i) {
        var prop = "", msg = "";

        var x = confirm('Are You Sure To Delete?');
        if (x) {
            $.ajax({
                type: 'POST',
                data: {
                    'id': i,
                    'status': "B",
                    'tbl': 'si_admin'
                },
                url: '<?php echo base_url() ?>Helper/change_status',
                dataType: 'json',
                success: function (data) {
                    if (data == 1) {
                        $('#errordiv').show();
                        $('#errordivmsg').show();
                        prop = 'alert alert-success alert-dismissable';
                        msg = '<strong>Success!</strong> Row Deleted';
                    } else {
                        $('#errordiv').show();
                        $('#errordivmsg').show();
                        prop = 'alert alert-danger alert-dismissable';
                        msg = '<strong>Success!</strong> Row Not Deleted';
                    }
                    $('#errordiv').prop('class', prop);
                    $('#errordivmsg').html(msg);
                    table.draw(false);
                    setTimeout(hide, 3000);
                }
            });
        } else {
            return false;
        }
    }

    var hide = function () {
        $('#errordiv').hide();
        $('#errordivmsg').hide();
    }


</script>
<script>
    function add_admin()
    {
        var prop = "", msg = "";
        var name1 = $('input[name=adminname]').val();
        var username = $('input[name=username]').val();
        var phone = $('input[name=phone]').val();
        var pwd = $('input[name=pwd]').val();
        var con_pwd = $('input[name=con_pwd]').val();
        var type = $('select[name=type]').val();
        var status = $('input[name=status]').val();

        if (name1 == '')
        {
            $('#errordiv1').show();
            $('#errordivmsg1').show();
            prop = 'alert alert-danger alert-dismissable';
            msg = '<strong>Success!</strong> Enter Name.';
            $('#errordiv1').prop('class', prop);
            $('#errordivmsg1').html(msg);
            table.draw(false);
            setTimeout(hide, 3000);
            $('input[name=adminname]').focus();
        } else if (username == '')
        {
            $('#errordiv1').show();
            $('#errordivmsg1').show();
            prop = 'alert alert-danger alert-dismissable';
            msg = '<strong>Success!</strong> Enter username.';
            $('#errordiv1').prop('class', prop);
            $('#errordivmsg1').html(msg);
            table.draw(false);
            setTimeout(hide, 3000);
            $('input[name=username]').focus();
        } else if (phone == '')
        {
            $('#errordiv1').show();
            $('#errordivmsg1').show();
            prop = 'alert alert-danger alert-dismissable';
            msg = '<strong>Success!</strong> Enter Phone.';
            $('#errordiv1').prop('class', prop);
            $('#errordivmsg1').html(msg);
            table.draw(false);
            setTimeout(hide, 3000);
            $('input[name=phone]').focus();
        } else if (!/^[6789]\d{9}$/.test(phone)) {
            $('#errordiv1').show();
            $('#errordivmsg1').show();
            prop = 'alert alert-danger alert-dismissable';
            msg = '<strong>Success!</strong> Enter Valid Mobile.';
            $('#errordiv1').prop('class', prop);
            $('#errordivmsg1').html(msg);
            table.draw(false);
            setTimeout(hide, 3000);
            $('input[name=phone]').focus();
        } else if (pwd == '')
        {
            $('#errordiv1').show();
            $('#errordivmsg1').show();
            prop = 'alert alert-danger alert-dismissable';
            msg = '<strong>Success!</strong> Enter Password.';
            $('#errordiv1').prop('class', prop);
            $('#errordivmsg1').html(msg);
            table.draw(false);
            setTimeout(hide, 3000);
            $('input[name=pwd]').focus();
        } else if (con_pwd == '')
        {
            $('#errordiv1').show();
            $('#errordivmsg1').show();
            prop = 'alert alert-danger alert-dismissable';
            msg = '<strong>Success!</strong> Enter Confirm Password.';
            $('#errordiv1').prop('class', prop);
            $('#errordivmsg1').html(msg);
            table.draw(false);
            setTimeout(hide, 3000);
            $('input[name=con_pwd]').focus();
        } else if (pwd != con_pwd)
        {
            $('#errordiv1').show();
            $('#errordivmsg1').show();
            prop = 'alert alert-danger alert-dismissable';
            msg = '<strong>Success!</strong> Password doesnot Match!!! Try Again.';
            $('input[name=pwd]').val('');
            $('input[name=pwd]').focus();
            $('input[name=con_pwd]').val('');
            $('input[name=con_pwd]').focus();
            $('#errordiv1').prop('class', prop);
            $('#errordivmsg1').html(msg);
            table.draw(false);
            setTimeout(hide, 3000);
        } else if (type == 0)
        {
            $('#errordiv1').show();
            $('#errordivmsg1').show();
            prop = 'alert alert-danger alert-dismissable';
            msg = '<strong>Success!</strong> Select Type.';
            $('#errordiv1').prop('class', prop);
            $('#errordivmsg1').html(msg);
            table.draw(false);
            setTimeout(hide, 3000);
            $('select[name=type]').focus();
        } else
        {
            $.ajax({
                type: 'POST',
                data: {'name': name1, 'username': username, 'phone': phone, 'pwd': pwd, 'type': type, 'status': status},
                url: '<?php echo base_url(); ?>Admin/Sadmin/insert',
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    if (data == 1) {
                        window.location.href = '<?php echo base_url('Admin/Sadmin') ?>';
                    } else {
                        $('#errordiv1').show();
                        prop = 'alert alert-info alert-dismissable';
                        msg = '<strong>Success!</strong> Admin/ Sub-Admin Already Exist.';
                    }
                    $('#errordiv1').prop('class', prop);
                    $('#errordivmsg1').html(msg);
                    table.draw(false);
                    setTimeout(hide, 3000);
                }
            })
        }

    }
    var hide = function () {
        $('#errordiv1').hide();
        $('#errordivmsg1').hide();
    }

<?php if (isset($_REQUEST['value'])) { ?>

        var value = "<?php echo $_REQUEST['value']; ?>";
        if (value == "null")
        {
            swal(
                    'Try Again!',
                    'User Already Assign',
                    'error'
                    );

        }
<?php } ?>

</script>
<script>
    function update_admin()
    {
        var prop = "", msg = "";
        var name = $('input[name=e_name]').val();
        var username = $('input[name=e_username]').val();
        var phone = $('input[name=e_phone]').val();
        var pwd = $('input[name=e_pwd]').val();
        var con_pwd = $('input[name=e_con_pwd]').val();
        var type = $('select[name=e_type]').val();
        var edit_id = $('input[name=edit_id]').val();

        if (name == '')
        {
            $('#errordiv2').show();
            prop = 'alert alert-danger alert-dismissable';
            msg = '<strong>Success!</strong> Enter Name.';
            $('#errordiv2').prop('class', prop);
            $('#errordivmsg2').html(msg);
            table.draw(false);
            setTimeout(hide, 3000);
            $('input[name=e_name]').focus();
        } else if (username == '')
        {
            $('#errordiv2').show();
            prop = 'alert alert-danger alert-dismissable';
            msg = '<strong>Success!</strong> Enter username.';
            $('#errordiv2').prop('class', prop);
            $('#errordivmsg2').html(msg);
            table.draw(false);
            setTimeout(hide, 3000);
            $('input[name=e_username]').focus();
        } else if (phone == '')
        {
            $('#errordiv2').show();
            prop = 'alert alert-danger alert-dismissable';
            msg = '<strong>Success!</strong> Enter phone.';
            $('#errordiv2').prop('class', prop);
            $('#errordivmsg2').html(msg);
            table.draw(false);
            setTimeout(hide, 3000);
            $('input[name=e_phone]').focus();
        } else if (!/^[6789]\d{9}$/.test(phone)) {
            $('#errordiv2').show();
            $('#errordivmsg2').show();
            prop = 'alert alert-danger alert-dismissable';
            msg = '<strong>Success!</strong> Enter Valid Mobile.';
            $('#errordiv2').prop('class', prop);
            $('#errordivmsg2').html(msg);
            table.draw(false);
            setTimeout(hide, 3000);
            $('input[name=e_phone]').focus();

        } else if (pwd == '')
        {
            $('#errordiv2').show();
            prop = 'alert alert-danger alert-dismissable';
            msg = '<strong>Success!</strong> Enter Password.';
            $('#errordiv2').prop('class', prop);
            $('#errordivmsg2').html(msg);
            table.draw(false);
            setTimeout(hide, 3000);
            $('input[name=e_pwd]').focus();
        } else if (con_pwd == '')
        {
            $('#errordiv2').show();
            prop = 'alert alert-danger alert-dismissable';
            msg = '<strong>Success!</strong> Enter Confirm Password.';
            $('#errordiv2').prop('class', prop);
            $('#errordivmsg2').html(msg);
            table.draw(false);
            setTimeout(hide, 3000);
            $('input[name=e_con_pwd]').focus();
        } else if (pwd != con_pwd)
        {
            $('#errordiv2').show();
            prop = 'alert alert-danger alert-dismissable';
            msg = '<strong>Success!</strong> Password doesnot Match!!! Try Again.';
            $('input[name=e_pwd]').val('');
            $('input[name=e_pwd]').focus();
            $('input[name=e_con_pwd]').val('');
            $('input[name=e_con_pwd]').focus();
            $('#errordiv2').prop('class', prop);
            $('#errordivmsg2').html(msg);
            table.draw(false);
            setTimeout(hide, 3000);
        } else if (type == 0)
        {
            $('#errordiv2').show();
            prop = 'alert alert-danger alert-dismissable';
            msg = '<strong>Success!</strong> Select Type.';
            $('#errordiv2').prop('class', prop);
            $('#errordivmsg2').html(msg);
            table.draw(false);
            setTimeout(hide, 3000);
            $('select[name=e_type]').focus();
        } else
        {
            $.ajax({
                type: 'POST',
                data: {'e_name': name, 'e_username': username, 'e_phone': phone, 'e_pwd': pwd, 'e_type': type, 'edit_id': edit_id},
                url: '<?php echo base_url(); ?>Admin/Sadmin/update',
                dataType: 'json',
                success: function (data) {
                    if (data == 1) {
                        window.location.href = '<?php echo base_url('Admin/Sadmin') ?>';
                    } else {
                        $('#errordiv2').show();
                        prop = 'alert alert-warning alert-dismissable';
                        msg = '<strong>Success!</strong> Admin/ Sub-Admin Already Exist.';
                    }
                    $('#errordiv2').prop('class', prop);
                    $('#errordivmsg2').html(msg);
                    table.draw(false);
                    setTimeout(hide2, 3000);
                }
            })
        }

    }
    var hide2 = function () {
        $('#errordiv2').hide();
        $('#errordivmsg2').hide();
    }
</script>