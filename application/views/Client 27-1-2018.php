<html>
    <head>

        <?php $this->load->view('template/headerlink'); ?>    
        <style>
            .trcolor{
                background-color: #CDE69C !important;
            }

        </style>
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
                <div class="container-fluid">
                    <?php if ($this->session->flashdata('error') != ""): ?>
                        <div class="row bg-title"> 

                            <div id="errordiv1"
                                 class="alert <?php echo $this->session->flashdata('errorcls'); ?> alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <?php echo $this->session->flashdata('error'); ?>
                            </div>

                        </div>     <?php
                    endif;
                    ?>    
                    <!-- ============================================================== -->
                    <!-- Different data Product -->
                    <!-- ============================================================== -->
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">                               
                            <div class="white-box"> 


                                <div class="panel clearfix">
                                    <div class="row">
                                        <div class="col-sm-12 col-lg-12">
                                            <?php
                                            if (count($client_form) > 0) {
                                                if ($client_form[0]['client_form'] != '') {
                                                    $cf = explode(",", $client_form[0]['client_form']);
                                                    $ct = explode(",", $client_form[0]['c_type']);
                                                    $cnt_rcrd = count($cf);
                                                    ?>
                                                    <div class="col-sm-4 col-sm-12">
                                                        <div class="white-box bg-white-dark optimize-box m-b-0">
                                                            <center> 
                                                                <h3 class="box-title m-b-10">Client Details</h3>
                                                                <!--<p class="text-muted"> Enter below detail</p>-->
                                                            </center>
                                                            <div class="optimize-spacing">
                                                                <?php
                                                                if (in_array('Contact Person', $cf)) {
                                                                    ?>
                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <input type="text" class="form-control" id="contact_person" data-id="1" name="contact_person" required placeholder="Contact Person"> <input  type="hidden" name="hid" id="hid" >
                                                                            <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                if (in_array('Firm Name', $cf)) {
                                                                    ?>
                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <input type="text" class="form-control" id="firm_name" name="firm_name" data-id="2" placeholder="Firm Name">
                                                                            <div class="input-group-addon"><i class="fa fa-building"></i></div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                if (in_array('Address', $cf)) {
                                                                    ?>
                                                                    <p class="text-muted m-b-0 m-t-10">Correspondance Address</p>
                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <textarea class="form-control" id="address" name="address" required rows="2" data-id="6" placeholder="Address"></textarea>
                                                                            <div class="input-group-addon"><i class="fa  fa-location-arrow"></i></div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                if (in_array('Other Address', $cf)) {
                                                                    ?>
                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <textarea class="form-control" id="address1" name="address1"  rows="2" data-id="7" placeholder="Other Address"></textarea>
                                                                            <div class="input-group-addon"><i class="fa  fa-location-arrow"></i></div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                if (in_array('Area', $cf)) {
                                                                    ?>
                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <input type="text" class="form-control" id="area" name="area" data-id="8" required placeholder="Area">
                                                                            <div class="input-group-addon"><i class="fa fa-map-marker"></i></div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                if (in_array('City', $cf)) {
                                                                    ?>
                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <input type="text" class="form-control" data-id="9" id="city" name="city" required placeholder="City">
                                                                            <div class="input-group-addon"><i class="fa fa-map-marker"></i></div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                if (in_array('State', $cf)) {
                                                                    ?>
                                                                    <div class="form-group">
                                                                        <select class="form-control" id="si_state_id" data-id="10" required name="si_state_id">
                                                                            <option value="0">Select State</option>

                                                                            <?php
                                                                            foreach ($states as $state) {
                                                                                echo "<option value='" . $state['si_state_id'] . "'>" . $state['name'] . "</option>";
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                if (in_array('Pincode', $cf)) {
                                                                    ?>
                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <input type="text" class="form-control" id="pincode" name="pincode" data-id="11" required placeholder="Pin Code" maxlength="6" onkeypress='return event.charCode >= 48 && event.charCode <= 57' minlength="6">
                                                                            <div class="input-group-addon"><i class="fa fa-map-marker"></i></div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                if (in_array('Register Mobile', $cf)) {
                                                                    ?>
                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <input type="text" class="form-control" id="registed_mobile" data-id="12" name="registed_mobile" required placeholder="Registered Mobile" maxlength="10" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                                                            <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                if (in_array('Register Email', $cf)) {
                                                                    ?>
                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <input type="email" class="form-control" id="register_email" name="register_email" data-id="13" required  placeholder="Register email">
                                                                            <div class="input-group-addon"><i class="fa fa-envelope"></i></div>
                                                                        </div>
                                                                    </div>
                                                                <?php }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            <?php
                                            if (count($contact_form) > 0) {
                                                if ($contact_form[0]['contact_form'] != '') {
                                                    $cof = explode(",", $contact_form[0]['contact_form']);
                                                    $cot = explode(",", $contact_form[0]['cn_type']);
                                                    $cont_rcrd = count($cof);
                                                    ?>
                                                    <div class="col-sm-4 col-sm-12">
                                                        <div class="white-box bg-white-dark optimize-box m-b-0">
                                                            <center>
                                                                <h3 class="box-title m-b-10">Contact Details</h3> 
                                                            </center>
                                                            <div class="optimize-spacing">
                                                                <?php
                                                                if (in_array('Mobile No 1', $cof)) {
                                                                    ?>
                                                                    <p class="text-muted m-b-0 m-t-10"> Other Mobile No</p>
                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <input type="text" class="form-control" id="mobile1" name="mobile1" data-id="14" placeholder="Mobile No 1" maxlength="10" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                                                            <div class="input-group-addon"><i class="fa fa-mobile"></i></div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                if (in_array('Mobile No 2', $cof)) {
                                                                    ?>
                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <input type="text" class="form-control" id="mobile2" name="mobile2" data-id="15" placeholder="Mobile No 2" maxlength="10" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                                                            <div class="input-group-addon"><i class="fa fa-mobile"></i></div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                if (in_array('Mobile No 3', $cof)) {
                                                                    ?>
                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <input type="text" class="form-control" id="mobile3" name="mobile3" data-id="16" placeholder="Mobile No 3" maxlength="10" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                                                            <div class="input-group-addon"><i class="fa fa-mobile"></i></div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                if (in_array('Phone No 1', $cof)) {
                                                                    ?>
                                                                    <p class="text-muted m-b-0 m-t-10"> Other Phone No</p>
                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <input type="text" class="form-control" id="phone1" name="phone1" placeholder="Phone No 1" data-id="17" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                                                            <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                if (in_array('Phone No 2', $cof)) {
                                                                    ?>
                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <input type="text" class="form-control" id="phone2" name="phone2" placeholder="Phone No 2" data-id="18" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                                                            <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                if (in_array('GSTN No', $cof)) {
                                                                    ?>
                                                                    <p class="text-muted m-b-0 m-t-10">GSTN No</p>
                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <input type="text" class="form-control" id="gstin_no" name="gstin_no" placeholder="GSTN No" data-id="19" maxlength="15">
                                                                            <div class="input-group-addon"><i class="fa fa-barcode"></i></div>
                                                                        </div>
                                                                    </div>
                                                                <?php }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            <?php
                                            if (count($product_form) > 0) {
                                                if ($product_form[0]['product_form'] != '') {
                                                    $pf = explode(",", $product_form[0]['product_form']);
                                                    $pt = explode(",", $product_form[0]['p_type']);
                                                    $prdct_rcrd = count($pf);
                                                    ?>
                                                    <div class="col-sm-4 col-sm-12">
                                                        <div class="white-box bg-white-dark optimize-box m-b-0">
                                                            <center>
                                                                <h3 class="box-title m-b-10">Product Details</h3> 
                                                            </center>
                                                            <div class="no-bg-addon row optimize-spacing">
                                                                <?php
                                                                if (in_array('Installation', $pf)) {
                                                                    ?>
                                                                    <div class="form-group col-sm-6">
                                                                        <select class="form-control" id="category_id" data-id="20" name="category_id[]">
                                                                            <option value="1">Installtion</option><!-- 
                                                                            -->                                                                            <option value="2">Updatation</option>
                                                                            <option value="3">Lan</option>
                                                                            <option value="4">Conversion</option>  
                                                                        </select>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                if (in_array('product', $pf)) {
                                                                    ?>
                                                                    <div class="form-group col-sm-6">
                                                                        <select class="form-control" id="si_product_id" data-id="21" name="si_product_id[]" required>
                                                                            <option value="0">Product</option>
                                                                            <?php
                                                                            foreach ($product as $p_value) {
                                                                                echo "<option value='" . $p_value['si_product_id'] . "'>" . $p_value['p_name'] . "</option>";
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                if (in_array('Conversion Product', $pf)) {
                                                                    ?>
                                                                    <div class="form-group col-sm-6">
                                                                        <select class="form-control" id="si_conversion_product_id" data-id="22" name="si_conversion_product_id[]">
                                                                            <option value="0">Conversion Product</option>
                                                                        </select>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                if (in_array('No Laptop', $pf)) {
                                                                    ?>
                                                                    <div class="form-group col-sm-6">
                                                                        <select class="form-control" id="laptop" name="laptop[]" data-id="23">
                                                                            <option value="NL">No Laptop</option>
                                                                            <option value="OL">Only Laptop</option>
                                                                            <option value="WL">With Laptop</option>  
                                                                        </select>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                if (in_array('Online', $pf)) {
                                                                    ?>
                                                                    <div class="form-group col-sm-6">
                                                                        <select class="form-control" id="reg_type" name="reg_type[]" data-id="24">
                                                                            <option value="O">Online</option>
                                                                            <option value="H">HLock</option>  
                                                                        </select>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                if (in_array('For Year', $pf)) {
                                                                    ?>
                                                                    <div class="form-group col-sm-6">
                                                                        <select class="form-control" id="si_for_year_id" name="si_for_year_id[]" data-id="25">
                                                                            <option value="0">For Year</option>
                                                                            <?php
                                                                            foreach ($for_year as $p_year) {
                                                                                echo "<option value='" . $p_year['si_for_year_id'] . "'>" . $p_year['yearname'] . "</option>";
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                if (in_array('Serial NO/HLock No', $pf)) {
                                                                    ?>
                                                                    <div class="form-group col-sm-6">
                                                                        <!--<select class="form-control" id="serial_no" name="serial_no">
                                                                            <option>Serial No/ HLock No</option>
                                                                        </select>-->
                                                                        <input type="text" name="serial_no[]" id="searial_no" class="form-control" data-id="3" placeholder="Enter Serial No/ HLock No">
                                                                    </div>
                                                                    <?php
                                                                }
                                                                if (in_array('Activation Code', $pf)) {
                                                                    ?>
                                                                    <div class="form-group col-sm-6">
                                                                        <input class="form-control" name="activation_code[]" id="activation_code" data-id="4" placeholder="Activation Code" type="text">
                                                                    </div>
                                                                    <?php
                                                                }
                                                                if (in_array('Purchase Date', $pf)) {
                                                                    ?>
                                                                    <div class="form-group col-sm-6">
                                                                        <input class="form-control mydatepicker" name="purchase_date[]" id="purchase_date" data-id="26" placeholder="Purchase Date" type="text">
                                                                    </div>
                                                                    <?php
                                                                }
                                                                if (in_array('Renewal Date', $pf)) {
                                                                    ?>
                                                                    <div class="form-group col-sm-6">
                                                                        <input class="form-control mydatepicker" name="last_renewal_date[]" id="last_renewal_date" data-id="27" placeholder="Renewal Date" type="text">
                                                                    </div>
                                                                    <?php
                                                                }
                                                                ?>

                                                            </div>
                                                        </div>

                                                    </div></div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-12">
                                    <div class="table-responsive p-t-30" style="width: 100%;"> 
                                        <h3 class="box-title m-b-10">MANAGE CLIENT</h3>
                                        <table id="product" class="table table-striped table-bordered manage-u-table optimize-table">
                                            <thead>
                                                <tr>
                                                    <th style="width: 70px !important;" class="text-center">#<input type="hidden" id="hiddenRowId"></th>
                                                    <th width="250">Customer Name</th>    
                                                    <th width="250">Firm Name</th>
                                                    <th width="250">Serial No</th>
                                                    <th width="250">Activation Code</th>
                                                    <th width="250">Lan Type</th>
                                                    <th style="width:90px;">Action</th>
                                                    <th style="display: none;"></th>
                                                    <th style="display: none;"></th>
                                                    <th style="display: none;"></th>
                                                    <th style="display: none;"></th>
                                                    <th style="display: none;"></th>
                                                    <th style="display: none;"></th>
                                                    <th style="display: none;"></th>
                                                    <th style="display: none;"></th>
                                                    <th style="display: none;"></th>
                                                    <th style="display: none;"></th>
                                                    <th style="display: none;"></th>
                                                    <th style="display: none;"></th>
                                                    <th style="display: none;"></th>
                                                    <th style="display: none;"></th>
                                                    <th style="display: none;"></th>
                                                    <th style="display: none;"></th>
                                                    <th style="display: none;"></th>
                                                    <th style="display: none;"></th>
                                                    <th style="display: none;"></th>
                                                    <th style="display: none;"></th>
                                                    <th style="display: none;"></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div> 

                                <div class="row" id="productdetailrow" style="display: none">
                                    <div class="col-sm-12">
                                        <div class="white-box bg-white-dark">
                                            <h3 class="box-title m-b-10">Client Product Detail
                                          <!-- <button class="btn btn-success waves-effect waves-light fix-btn m-l-10" type="button" data-toggle="modal" data-target="#productadd"><span class="btn-label"><i class="fa fa-plus"></i></span>Add Product</button>--></h3> 
                                            <div class="table-responsive">
                                                <table id="productdetail" class="table table-striped table-bordered optimize-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Sr. No.</th>
                                                            <th>Product Name</th>
                                                            <th>Purc Year</th>
<!--                                                                <th>Activation Code</th>
                                                            <th>Serial No</th>-->
                                                            <th>purc date</th>
                                                            <th>renew date</th>
                                                            <th>Lan</th>
                                                            <th>Reg Type</th>
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
<div id="productadd" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">??</button>
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
<!-- js placed at the end of the document so the pages load faster -->
<?php $this->load->view('template/footerlink'); ?>

<!-- Editable
 <script src="<?php echo base_url(); ?>assetss/js/custom.min.js"></script>
<script src="<?php echo base_url(); ?>assetss/plugins/bower_components/jsgrid/db.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assetss/plugins/bower_components/jsgrid/dist/jsgrid.min.js"></script>
<script src="<?php echo base_url(); ?>assetss/js/jsgrid-init.js"></script> -->
<!--Style Switcher -->


</body>

<script>

    $('.mydatepicker, #datepicker').datepicker({
        format: 'yyyy-mm-dd'
    });
    $('#c_id').change(function () {
        if (!this.checked)
            $('#conversion').fadeOut('slow');
        else
            $('#conversion').fadeIn('slow');
    });
    $('#panelupdate').hide();
    var tbl = 'si_clients';
    var cntrl = '<?php echo $this->uri->segment(2); ?>';
    var tabs = $('#product').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "<?php echo base_url() . 'Client/GetData'; ?>",
        "aoColumnDefs": [
            {
                bSortable: false,
                aTargets: [-1, -2]
            }
        ],
        "fnRowCallback": function (nRow, aData, iDisplayIndex) {
            for (var i = 7; i <= 27; i++) {

                $('td:eq(' + i + ')', nRow).css("display", "none");
            }
            return nRow;
        },
    });
    $('#product>tbody').on('click', '.status', function () {
        var id = $(this).data('id');
        var st = $(this).data('status');
        if (st != "A") {
            var msg = "You won't be deactive this Client?";
            var btn = 'Yes, De-active it!';
            var title = "De-Activate";
        } else {
            var msg = "You won't be active this Client?";
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
                                'Selected Client has been ' + title + '.',
                                'success'
                                )
                        tabs.draw(false);
                    }
                }
            });
        }, function (dismiss) {
            if (dismiss === 'cancel') {
                swal(
                        'Cancelled',
                        'Your imaginary Client is safe :)',
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
            text: "You won't be delete this Client",
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
                                'Selected Client has been  Deleted.',
                                'success'
                                )
                        tabs.draw(false);
                    }
                }
            });
        }, function (dismiss) {
            if (dismiss === 'cancel') {
                swal(
                        'Cancelled',
                        'Your imaginary Client is safe :)',
                        'error'
                        )
            }
        })
    });
    $('#product>tbody').on('click', '.edit', function () {
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

//        TreeTable(id);
//        $('#productdetail').DataTable().destroy();
//        var url = "<?php echo base_url() . 'Client/get_client_all_product'; ?>";
//        $('#productdetailrow').show();
//        var tabs1 = $('#productdetail').DataTable({
//            "processing": true,
//            "serverSide": true,
//            "searching": false,
//            "ajax": {
//                "url": url,
//                "data": {
//                    "id": id,
//                }
//            }
//        });
//        });
//        $.ajax({
//            type: 'post',
//            data: {'id': id, 'tbl': tbl},
//            url: '<?php echo base_url('Client/get_client_edit_data'); ?>',
//            dataType: 'json',
//            success: function (data) {
//                $('#myTab a[href="#menu1"]').tab('show');
//                $('#category_id').find('option').remove();
//                $('#category_id')
//                        .append($("<option></option>")
//                                .attr("value", 1)
//                                .text("Installtion"));
//                $('#category_id')
//                        .append($("<option></option>")
//                                .attr("value", 2)
//                                .text("Updatation"));
//                $('#category_id')
//                        .append($("<option></option>")
//                                .attr("value", 3)
//                                .text("lan"));
//                $('#category_id')
//                        .append($("<option></option>")
//                                .attr("value", 4)
//                                .text("Conversion"));
//                $('#category_id').val("2").attr("selected", "selected");
//                $('#paneltitle').hide();
//                $('#panelupdate').show();
//                $('#hid').val(data.contact.si_clients_id);
//                $('#contact_person').val(data.contact.contact_person);
//                $('#firm_name').val(data.contact.firm_name);
//                $('#address').val(data.contact.address);
//                $('#address1').val(data.contact.address1);
//                $('#area').val(data.contact.area);
//                $('#city').val(data.contact.city);
//                $('#pincode').val(data.contact.pincode);
//                $('#registed_mobile').val(data.contact.registed_mobile);
//                $('#register_email').val(data.contact.register_email);
//                $('#regemail').val(data.contact.register_email);
//                $('#mobile1').val(data.contact.mobile1);
//                $('#mobile2').val(data.contact.mobile2);
//                $('#mobile3').val(data.contact.mobile3);
//                $('#phone1').val(data.contact.phone1);
//                $('#phone2').val(data.contact.phone2);
//                $('#gstin_no').val(data.contact.gstin_no);
//                $('#si_state_id').val(data.contact.si_state_id).attr("selected", "selected");
//                $('#si_product_id').find('option').remove();
//                $('#si_product_id')
//                        .append($("<option></option>")
//                                .attr("value", 0)
//                                .text('Selected Product'));
//                $.each(data.product, function (key, value) {
//                    $('#si_product_id')
//                            .append($("<option></option>")
//                                    .attr("value", value.si_product_id)
//                                    .text(value.p_name));
//                    //console.log('value : '+value.p_name);
//                });
//                if (data.is_conversion_id == "0")
//                {
//                    $('#conversion').fadeOut('slow');
//                    $('#c_id').removeAttr("checked");
//                } else
//                {
//                    $('#conversion').fadeIn('slow');
//                    $('#c_id').attr("checked", "checked");
//                }
//                $('#conversion_id').val(data.is_conversion_id);
//                $('#tblhid').val(tbl);
//                $('#tblcntrl').val(cntrl);
//                $('#editmenu').modal('show');
//            }
//        });
    });
    // View Table In Tree Start
    function TreeTable(id) {

        $("#hiddenRowId").val(id);
        $("#dynOrderRow").remove();
        $.ajax({
            url: "<?php echo base_url() . 'Client/get_client_all_product' ?>",
            data: {'id': id},
            method: 'post',
            dataType: 'html',
            success: function (data) {
                console.log(data);
                if (data.length > 0) {
                    $('#Rows_id' + id).after(data);
                } else {
                    $("#Rows_id" + id).remove();
                }
            }
        });
    }
    // View Table In Tree End

    $('#lan').change(function () {
        if ($(this).prop("checked")) {
            $('.ul-info').show();
            $('#total_lan').val("UL");
            $('#total_lan').attr("readonly", "readonly");
        } else {
            $('.ul-info').hide();
            $('#total_lan').val('0');
            $('#total_lan').removeAttr("readonly");
        }
    });
    $('#changeemail').change(function () {
        if ($(this).prop("checked")) {
            $('.email-info').show()
        } else {
            $('.email-info').hide()
        }
    });
    $('#si_product_id').change(function () {
        if ($(this).val() == "57") {
            $(".gstkeyselection").show()
        } else {
            $(".gstkeyselection").hide()
        }


    });
    $('#category_id').change(function () {

        change_product_con();
    });
    function change_product_con() {
        var id = $('#hid').val();
        if ($('#category_id').val() == "1" && id) {
            $.ajax({
                type: 'post',
                data: {'all_p': 'All'},
                url: '<?php echo base_url('Admin/Client/get_conversion_data'); ?>',
                dataType: 'json',
                success: function (data) {
                    $('#si_product_id').find('option').remove();
                    $('#si_product_id')
                            .append($("<option></option>")
                                    .attr("value", 0)
                                    .text('Selected Product'));
                    $.each(data.product, function (key, value) {
                        $('#si_product_id')
                                .append($("<option></option>")
                                        .attr("value", value.si_product_id)
                                        .text(value.p_name));
                        //console.log('value : '+value.p_name);
                    });
                }
            });
        }
        if ($('#category_id').val() == "2") {
            var id = $('#hid').val();
            console.log('update cat' + id + 'tbl : ' + tbl);
            $.ajax({
                type: 'post',
                data: {'id': id, 'tbl': tbl},
                url: '<?php echo base_url('Admin/Client/get_client_edit_data'); ?>',
                dataType: 'json',
                success: function (data) {
                    $('#si_product_id').find('option').remove();
                    $('#si_product_id')
                            .append($("<option></option>")
                                    .attr("value", 0)
                                    .text('Selected Product'));
                    $.each(data.product, function (key, value) {
                        $('#si_product_id')
                                .append($("<option></option>")
                                        .attr("value", value.si_product_id)
                                        .text(value.p_name));
                        //console.log('value : '+value.p_name);
                    });
                }
            });
        } else if ($('#category_id').val() == "4" && $('#si_product_id').val() == 1) {

            var id = $('#hid').val();
            if (id) {
                $.ajax({
                    type: 'post',
                    data: {'tbl': tbl},
                    url: '<?php echo base_url('Admin/Client/get_conversion_data'); ?>',
                    dataType: 'json',
                    success: function (data) {
                        $('#si_conversion_product_id').find('option').remove();
                        $('#si_conversion_product_id')
                                .append($("<option></option>")
                                        .attr("value", 0)
                                        .text('Conversion Product'));
                        $.each(data.product, function (key, value) {
                            $('#si_conversion_product_id')
                                    .append($("<option></option>")
                                            .attr("value", value.si_product_id)
                                            .text(value.p_name));
                            console.log('value : ' + value.p_name);
                        });
                    }
                });
            }
        } else
        {
            $('#si_conversion_product_id').find('option').remove();
            $('#si_conversion_product_id')
                    .append($("<option></option>")
                            .attr("value", 0)
                            .text('Conversion Product'));
        }

    }


    $('#reset, #view').on('click', function () {
        $('#hid').val("");
        $('.form-group input[type="text"]').val('');
        $('.form-group input[type="email"]').val('');
        $('.form-group select[id="si_state_id"]').val('0');
        $('.form-group select[id="si_product_id"]').val('0');
        $('.form-group select[id="si_for_year_id"]').val('0');
        $('.form-group select[id="reg_type"]').val('O');
        $('.form-group select[id="si_conversion_product_id"]').val('0');
        $('.form-group select[id="category_id"]').val('1');
        $('.form-group input[type="checkbox"]').removeAttr("checked");
        $('#total_lan').val('0');
        $('#total_lan').removeAttr("readonly");
        $('.ul-info').hide();
        $('.email-info').hide();
        $('.form-group textarea').val('');
        $('#productdetail').DataTable().destroy();
    });
    $('#reset, #view').on('click', function () {
        $('#hid').val("");
        $('.form-group input[type="text"]').val('');
        $('.form-group input[type="email"]').val('');
        $('.form-group select[id="si_state_id"]').val('0');
        $('.form-group select[id="si_product_id"]').val('0');
        $('.form-group select[id="si_for_year_id"]').val('0');
        $('.form-group select[id="reg_type"]').val('O');
        $('.form-group select[id="si_conversion_product_id"]').val('0');
        $('.form-group select[id="category_id"]').val('1');
        $('.form-group input[type="checkbox"]').removeAttr("checked");
        $('#total_lan').val('0');
        $('#total_lan').removeAttr("readonly");
        $('.ul-info').hide();
        $('.email-info').hide();
        $('.form-group textarea').val('');
        $('#productdetail').DataTable().destroy();
    });
    $('#mytab li').on("click", '#addnewclient', function () {
        $('#productdetail').DataTable().clear().draw();
        if ($('#mytab li').hasClass("active") && $('#hid').val() == "") {
            $('#productdetailrow').hide();
        } else {

        }
    });
    $("#s_pc").change(function () {
        if ($(this).val() == 1) {
            $("#total_lan").show();
        } else if ($(this).val() == 2) {
            $("#total_lan").show();
        } else {
            $("#total_lan").hide();
        }
    });
    $('#productdetail>tbody').on('click', '.status', function () {
        var id = $(this).data('id');
        var hid = $("#hid").val();
        console.log(hid);
        var st = $(this).data('status');
        var detailtbl = "si_clients_details";
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
                data: {'id': id, 'status': st, 'tbl': detailtbl},
                url: '<?php echo base_url('Helper/change_status'); ?>',
                dataType: 'json',
                success: function (data) {
                    if (data == 1) {
                        swal(
                                'Successfully!',
                                'Selected Client has been ' + title + '.',
                                'success'
                                )
                        TreeTable(id);
                    }
                }
            });
        }, function (dismiss) {
            if (dismiss === 'cancel') {
                swal(
                        'Cancelled',
                        'Your imaginary Client is safe :)',
                        'error'
                        )
            }
        })
    });</script>


<script>
    // Client Script
<?php
if (count($client_form) > 0) {
    if ($client_form[0]['client_form'] != '') {
        $cf = explode(",", $client_form[0]['client_form']);
        $ct = explode(",", $client_form[0]['c_type']);
        $cnt_rcrd = count($cf);
        ?>
        <?php
        if (in_array('Contact Person', $cf)) {
            ?>

                $(document).on('keydown', '#contact_person', function (e) { // search data by invoice or datewise
                    var code = e.keyCode || e.which;
                    if (code === 9 || code == 13) {

                        var cont = $('#contact_person').val();
                        var col = $(this).data('id');

                        tabs.column(col).search(cont).draw();
                    }
                });
            <?php
        }
        if (in_array('Firm Name', $cf)) {
            ?>
                $(document).on('keydown', '#firm_name', function (e) { // search data by invoice or datewise
                    var code = e.keyCode || e.which;
                    if (code === 9 || code == 13) {

                        var cont = $('#firm_name').val();
                        var col = $(this).data('id');

                        tabs.column(col).search(cont).draw();
                    }
                });
            <?php
        }
        if (in_array('Address', $cf)) {
            ?>
                $(document).on('keydown', '#address', function (e) { // search data by invoice or datewise


                    var cont = $('#address').val();
                    var col = $(this).data('id');

                    tabs.column(col).search(cont).draw();
                });
            <?php
        }
        if (in_array('Other Address', $cf)) {
            ?>
                $(document).on('keydown', '#address1', function () { // search data by invoice or datewise

                    var cont = $('#address1').val();
                    var col = $(this).data('id');

                    tabs.column(col).search(cont).draw();
                });
            <?php
        }
        if (in_array('Area', $cf)) {
            ?>
                $(document).on('keydown', '#area', function (e) { // search data by invoice or datewise
                    var code = e.keyCode || e.which;
                    if (code === 9 || code == 13) {

                        var cont = $('#area').val();
                        var col = $(this).data('id');

                        tabs.column(col).search(cont).draw();
                    }
                });
            <?php
        }
        if (in_array('City', $cf)) {
            ?>
                $(document).on('keydown', '#city', function (e) { // search data by invoice or datewise
                    var code = e.keyCode || e.which;
                    if (code === 9 || code == 13) {

                        var cont = $('#city').val();
                        var col = $(this).data('id');

                        tabs.column(col).search(cont).draw();
                    }
                });
            <?php
        }
        if (in_array('State', $cf)) {
            ?>
                $(document).on('change', '#si_state_id', function () { // search data by invoice or datewise

                    var cont = $('#si_state_id').val();
                    var col = $(this).data('id');

                    tabs.column(col).search(cont).draw();
                });
            <?php
        }
        if (in_array('Pincode', $cf)) {
            ?>
                $(document).on('keydown', '#pincode', function (e) { // search data by invoice or datewise
                    var code = e.keyCode || e.which;
                    if (code === 9 || code == 13) {

                        var cont = $('#pincode').val();
                        var col = $(this).data('id');

                        tabs.column(col).search(cont).draw();
                    }
                });
            <?php
        }
        if (in_array('Register Mobile', $cf)) {
            ?>
                $(document).on('keydown', '#registed_mobile', function (e) { // search data by invoice or datewise
                    var code = e.keyCode || e.which;
                    if (code === 9 || code == 13) {

                        var cont = $('#registed_mobile').val();
                        var col = $(this).data('id');

                        tabs.column(col).search(cont).draw();
                    }
                });
            <?php
        }
        if (in_array('Register Email', $cf)) {
            ?>
                $(document).on('keydown', '#register_email', function (e) { // search data by invoice or datewise
                    var code = e.keyCode || e.which;
                    if (code === 9 || code == 13) {

                        var cont = $('#register_email').val();
                        var col = $(this).data('id');

                        tabs.column(col).search(cont).draw();
                    }
                });
            <?php
        }
    }
}
// Contact script
if (count($contact_form) > 0) {
    if ($contact_form[0]['contact_form'] != '') {
        $cof = explode(",", $contact_form[0]['contact_form']);
        $cot = explode(",", $contact_form[0]['cn_type']);
        $cont_rcrd = count($cof);

        if (in_array('Mobile No 1', $cof)) {
            ?>
                $(document).on('keydown', '#mobile1', function (e) { // search data by invoice or datewise
                    var code = e.keyCode || e.which;
                    if (code === 9 || code == 13) {

                        var cont = $('#mobile1').val();
                        var col = $(this).data('id');

                        tabs.column(col).search(cont).draw();
                    }
                });
            <?php
        }
        if (in_array('Mobile No 2', $cof)) {
            ?>
                $(document).on('keydown', '#mobile2', function (e) { // search data by invoice or datewise
                    var code = e.keyCode || e.which;
                    if (code === 9 || code == 13) {

                        var cont = $('#mobile2').val();
                        var col = $(this).data('id');

                        tabs.column(col).search(cont).draw();
                    }
                });
            <?php
        }
        if (in_array('Mobile No 3', $cof)) {
            ?>
                $(document).on('keydown', '#mobile3', function (e) { // search data by invoice or datewise
                    var code = e.keyCode || e.which;
                    if (code === 9 || code == 13) {

                        var cont = $('#mobile3').val();
                        var col = $(this).data('id');

                        tabs.column(col).search(cont).draw();
                    }
                });
            <?php
        }
        if (in_array('Phone No 1', $cof)) {
            ?>
                $(document).on('keydown', '#phone1', function (e) { // search data by invoice or datewise
                    var code = e.keyCode || e.which;
                    if (code === 9 || code == 13) {

                        var cont = $('#phone1').val();
                        var col = $(this).data('id');

                        tabs.column(col).search(cont).draw();
                    }
                });
            <?php
        }
        if (in_array('Phone No 2', $cof)) {
            ?>
                $(document).on('keydown', '#phone2', function (e) { // search data by invoice or datewise
                    var code = e.keyCode || e.which;
                    if (code === 9 || code == 13) {

                        var cont = $('#phone2').val();
                        var col = $(this).data('id');

                        tabs.column(col).search(cont).draw();
                    }
                });
            <?php
        }
        if (in_array('GSTN No', $cof)) {
            ?>
                $(document).on('keydown', '#gstin_no', function (e) { // search data by invoice or datewise
                    var code = e.keyCode || e.which;
                    if (code === 9 || code == 13) {

                        var cont = $('#gstin_no').val();
                        var col = $(this).data('id');

                        tabs.column(col).search(cont).draw();
                    }
                });
            <?php
        }
    }
}
// Product script
if (count($product_form) > 0) {
    if ($product_form[0]['product_form'] != '') {
        $pf = explode(",", $product_form[0]['product_form']);
        $pt = explode(",", $product_form[0]['p_type']);
        $prdct_rcrd = count($pf);
        ?>

        <?php
        if (in_array('Installation', $pf)) {
            ?>
                $(document).on('change', '#category_id', function () { // search data by invoice or datewise

                    var cont = $('#category_id').val();
                    var col = $(this).data('id');

                    tabs.column(col).search(cont).draw();
                });
            <?php
        }
        if (in_array('product', $pf)) {
            ?>
                $(document).on('change', '#si_product_id', function () { // search data by invoice or datewise

                    var cont = $('#si_product_id').val();
                    var col = $(this).data('id');

                    tabs.column(col).search(cont).draw();
                });
            <?php
        }
        if (in_array('Conversion Product', $pf)) {
            ?>
                $(document).on('change', '#si_conversion_product_id', function () { // search data by invoice or datewise

                    var cont = $('#si_conversion_product_id').val();
                    var col = $(this).data('id');

                    tabs.column(col).search(cont).draw();
                });
            <?php
        }
        if (in_array('No Laptop', $pf)) {
            ?>
                $(document).on('change', '#laptop', function () { // search data by invoice or datewise

                    var cont = $('#laptop').val();
                    var col = $(this).data('id');

                    tabs.column(col).search(cont).draw();
                });
            <?php
        }
        if (in_array('Online', $pf)) {
            ?>
                $(document).on('change', '#reg_type', function () { // search data by invoice or datewise

                    var cont = $('#reg_type').val();
                    var col = $(this).data('id');

                    tabs.column(col).search(cont).draw();
                });
            <?php
        }
        if (in_array('For Year', $pf)) {
            ?>
                $(document).on('change', '#si_for_year_id', function () { // search data by invoice or datewise

                    var cont = $('#si_for_year_id').val();
                    var col = $(this).data('id');

                    tabs.column(col).search(cont).draw();
                });
            <?php
        }
        if (in_array('Serial NO/HLock No', $pf)) {
            ?>
                $(document).on('keydown', '#searial_no', function (e) { // search data by invoice or datewise
                    var code = e.keyCode || e.which;
                    if (code === 9 || code == 13) {

                        var cont = $('#searial_no').val();
                        var col = $(this).data('id');

                        tabs.column(col).search(cont).draw();
                    }
                });
            <?php
        }
        if (in_array('Activation Code', $pf)) {
            ?>
                $(document).on('keydown', '#activation_code', function (e) { // search data by invoice or datewise
                    var code = e.keyCode || e.which;
                    if (code === 9 || code == 13) {

                        var cont = $('#activation_code').val();
                        var col = $(this).data('id');

                        tabs.column(col).search(cont).draw();
                    }
                });
            <?php
        }
        if (in_array('Purchase Date', $pf)) {
            ?>
                $(document).on('blur', '#purchase_date', function (e) { // search data by invoice or datewise
            //                    var code = e.keyCode || e.which;
            //                    if (code === 9 || code == 13) {
                    var cont = $('#purchase_date').val();
                    var col = $(this).data('id');
                    tabs.column(col).search(cont).draw();
            //                    }
                });
            <?php
        }
        if (in_array('Renewal Date', $pf)) {
            ?>
                $(document).on('blur', '#last_renewal_date', function (e) { // search data by invoice or datewise
            //                    var code = e.keyCode || e.which;
            //                    if (code === 9 || code == 13) {
                    var cont = $('#last_renewal_date').val();
                    var col = $(this).data('id');

                    tabs.column(col).search(cont).draw();
            //                    }
                });
            <?php
        }
    }
}
?>
</script>
</html>