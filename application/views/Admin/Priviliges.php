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
                                <h4>USER PRIVILIGES</h4>
                            </div>
                        </div>
                        <div class="panel-body">
                            <?php if ($this->session->flashdata('message')): ?>
                                <div class="<?php echo $this->session->flashdata('cls') ?>">
                                    <strong><?php echo $this->session->flashdata('message'); ?></strong> 
                                </div>
                            <?php endif; ?>
                            <div id="errordiv" class="alert alert-dismissable" style="display: none;">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <p id="errordivmsg"></p>
                            </div>
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tab1" data-toggle="tab">Record's</a></li>
                                <li><a href="#tab2" data-toggle="tab">Add New User Priviliges</a></li>
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
                                                    <th>No</th>
                                                    <th>User Name</th>
                                                    <th>Menu Assigned</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                <tr>
                                                    <th>No</th>
                                                    <th>User Name</th>
                                                    <th>Menu Assigned</th>
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
                                    <form method="post" action="<?php echo base_url() ?>Admin/Priviliegs/insert" name="from">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="form-group col-sm-3">
                                                    <select class="form-control" name="type">
                                                        <option value="0">---Select User---</option>
                                                        <?php
                                                        foreach ($user as $u) {
                                                            if ($_SESSION['id'] != $u['si_admin_id']) {
                                                                ?>
                                                                <option value="<?php echo $u['si_admin_id'] ?>"><?php echo $u['username'] ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-sm-4">
                                                    <label>Client Details</label>
                                                    <select class="form-control fix-multiselect" name="clinet_menu[]" multiple="">
                                                        <?php
                                                        foreach ($menu as $key => $val) {
                                                            if ($val['parent_id'] == 1) {
                                                                ?>
                                                                <option value="<?php echo $val['si_menu_id'] ?>"><?php echo $val['menu_name'] ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-sm-4">
                                                    <label>Contact Details</label>
                                                    <select class="form-control fix-multiselect" name="contact_menu[]" multiple="">
                                                        <?php
                                                        foreach ($menu as $key => $val) {
                                                            if ($val['parent_id'] == 2) {
                                                                ?>
                                                                <option value="<?php echo $val['si_menu_id'] ?>"><?php echo $val['menu_name'] ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-sm-4">
                                                    <label>Product Details</label>
                                                    <select class="form-control fix-multiselect" name="product_menu[]" multiple="">
                                                        <?php
                                                        foreach ($menu as $key => $val) {
                                                            if ($val['parent_id'] == 3) {
                                                                ?>
                                                                <option value="<?php echo $val['si_menu_id'] ?>"><?php echo $val['menu_name'] ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-8">
                                                <input type="submit" value="ADD" class="btn btn-primary">
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
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog" style="height: auto;width: auto;margin: 0px;">
            <form action="<?php echo base_url('Admin/Priviliegs/update'); ?>" method="post" >    
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
                                        <option value="<?php echo $u['si_admin_id'] ?>"><?php echo $u['username'] ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-4">
                                <label>Client Details</label>
                                <select class="form-control fix-multiselect" name="e_clinet_menu[]" id="client1" multiple="">
                                    <?php
                                    foreach ($menu as $key => $val) {
                                        if ($val['parent_id'] == 1) {
                                            ?>
                                            <option value="<?php echo $val['si_menu_id'] ?>"><?php echo $val['menu_name'] ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-sm-4">
                                <label>Contact Details</label>
                                <select class="form-control fix-multiselect" name="e_contact_menu[]" id="contact1" multiple="">
                                    <?php
                                    foreach ($menu as $key => $val) {
                                        if ($val['parent_id'] == 2) {
                                            ?>
                                            <option value="<?php echo $val['si_menu_id'] ?>"><?php echo $val['menu_name'] ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-sm-4">
                                <label>Product Details</label>
                                <select class="form-control fix-multiselect" name="e_product_menu[]" id="product1" multiple="">
                                    <?php
                                    foreach ($menu as $key => $val) {
                                        if ($val['parent_id'] == 3) {
                                            ?>
                                            <option value="<?php echo $val['si_menu_id'] ?>"><?php echo $val['menu_name'] ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
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
                url: "<?php echo base_url(); ?>Admin/Priviliegs/select_priviliegs",
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



</script>



<script>

    function edit_menu(id)
    {
        $('input[name=edit_id]').val(id);
        $.ajax({
            url: '<?php echo base_url() . 'Admin/Priviliegs/edit'; ?>',
            method: 'post',
            dataType: 'json',
            data: {'id': id},
            success: function (data) {
                // console.log(data);
                $('select[name=e_type]').val(data.si_admin_id);

                var client_form = data.client_form.split(",");
                // alert(JSON.stringify(menu)); return false;
                for (var i = 0; i < client_form.length; i++)
                {
                    $('#client1 option[value=' + client_form[i] + ']').attr('selected', true);
                    $('#client1 option[value=' + client_form[i] + ']').css('color', 'red');
//                    $("#client1").val("+ client_form[i] +").change();
                }
                var contact_form = data.contact_form.split(",");
                // alert(JSON.stringify(menu)); return false;
                for (var i = 0; i < contact_form.length; i++)
                {
                    $('#contact1 option[value=' + contact_form[i] + ']').attr('selected', 'selected');
                    $('#contact1 option[value=' + contact_form[i] + ']').css('color', 'red');
                }
                var product_form = data.product_form.split(",");
                // alert(JSON.stringify(menu)); return false;
                for (var i = 0; i < product_form.length; i++)
                {
                    $('#product1 option[value=' + product_form[i] + ']').attr('selected', 'selected');
                    $('#product1 option[value=' + product_form[i] + ']').css('color', 'red');
                }


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
                    'tbl': 'si_menu_assign',
                    'status':'B'
                },
                url: '<?php echo base_url() ?>Helper/change_status',
                dataType: 'json',
                success: function (data) {
                    if (data == 1) {
                        $('#errordiv').show();
                        prop = 'alert alert-success alert-dismissable';
                        msg = '<strong>Success!</strong> Row Deleted';
                    } else {
                        $('#errordiv').show();
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
</script>
