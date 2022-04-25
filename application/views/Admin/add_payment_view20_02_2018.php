<html>
    <head>

        <?php $this->load->view('template/headerlink'); ?>    
        <style>
         
            tfoot input {
                width: 100%;
                padding: 3px;
                box-sizing: border-box;
            }

            tfoot{
                display: table-header-group;
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
                            <a href="<?php echo base_url().'Client';?>"><button class="btn btn-primary popovers" data-trigger="hover" data-placement="top" data-content="Back" style="float:right;margin-right: 5%;margin-top: 1%;"><i class="fa fa-hand-o-left"></i></button></a>
                            <div class="white-box">
                                <header>
                                    <ul class="nav nav-tabs" id="myTab">
                                        <li ><a data-toggle="tab" href="#home" id="addnewclient">Add Payment Request</a></li>
                                    </ul>
                                    
                                </header>
                                <div class="tab-content">                                  
                                    <div id="home" class="tab-pane fade">  
                                        <div class="row">
                                            <form data-toggle="validator" class="clearfix" action="<?php echo base_url("Admin/TransactionsDetail/addData") ?>" method="post">

                                                <div class="col-sm-4 col-sm-12">
                                                    <div class="white-box bg-white-dark optimize-box m-b-0">
                                                        <center> 
                                                            <h3 class="box-title m-b-10">Client Details</h3>
                                                            <!--<p class="text-muted"> Enter below detail</p>-->
                                                        </center>
                                                        <div class="optimize-spacing">
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" id="contact_person" name="contact_person" required placeholder="Contact Person" value="<?php echo $contact['contact_person']; ?>" > <input  type="hidden" name="si_clients_id" value="<?php echo $contact['si_clients_id']; ?>" id="hid" >
                                                                    <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" id="firm_name" name="firm_name"  placeholder="Firm Name" value="<?php echo $contact['firm_name']; ?>">
                                                                    <div class="input-group-addon"><i class="fa fa-building"></i></div>
                                                                </div>
                                                            </div>
                                                            <p class="text-muted m-b-0 m-t-10">Correspondance Address</p>
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <textarea class="form-control" id="address" name="address" required rows="2" placeholder="Address"><?php echo $contact['address']; ?></textarea>
                                                                    <div class="input-group-addon"><i class="fa  fa-location-arrow"></i></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <textarea class="form-control" id="address1" name="address1"  rows="2" placeholder="Other Address" ><?php echo $contact['address1']; ?></textarea>
                                                                    <div class="input-group-addon"><i class="fa  fa-location-arrow"></i></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" id="area" name="area" required placeholder="Area" value="<?php echo $contact['area']; ?>">
                                                                    <div class="input-group-addon"><i class="fa fa-map-marker"></i></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" id="city" name="city" required placeholder="City" value="<?php echo $contact['city']; ?>">
                                                                    <div class="input-group-addon"><i class="fa fa-map-marker"></i></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <select class="form-control" id="si_state_id" required name="si_state_id">
                                                                    <option value="0">Select State</option>

                                                                    <?php
                                                                    foreach ($states as $state) {
                                                                        echo "<option value='" . $state['si_state_id'] . "'>" . $state['name'] . "</option>";
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" id="pincode" name="pincode" required placeholder="Pin Code" value="<?php echo $contact['pincode']; ?>" maxlength="6" onkeypress='return event.charCode >= 48 && event.charCode <= 57' minlength="6">
                                                                    <div class="input-group-addon"><i class="fa fa-map-marker"></i></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" id="registed_mobile" name="registed_mobile" required placeholder="Registered Mobile" value="<?php echo $contact['registed_mobile']; ?>" maxlength="10" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                                                    <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <input type="email" class="form-control" id="register_email" name="register_email" required value="<?php echo $contact['register_email']; ?>" placeholder="Register email">
                                                                    <div class="input-group-addon"><i class="fa fa-envelope"></i></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                              <div class="col-sm-8 col-sm-12 p-0">
                                                    <div class="col-sm-6 col-sm-12">
                                                        <div class="white-box bg-white-dark optimize-box m-b-0">
                                                            <center>
                                                                <h3 class="box-title m-b-10">Contact Details</h3> 
                                                            </center>
                                                            <div class="optimize-spacing"> 
                                                                <p class="text-muted m-b-0 m-t-10"> Other Mobile No</p>
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" id="mobile1" name="mobile1" value="<?php echo $contact['mobile1']; ?>" placeholder="Mobile No 1" maxlength="10" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                                                        <div class="input-group-addon"><i class="fa fa-mobile"></i></div>
                                                                    </div>
                                                                </div>
    
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" id="mobile2" name="mobile2" placeholder="Mobile No 2" maxlength="10" value="<?php echo $contact['mobile2']; ?>" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                                                        <div class="input-group-addon"><i class="fa fa-mobile"></i></div>
                                                                    </div>
                                                                </div>
    
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" id="mobile3" name="mobile3" value="<?php echo $contact['mobile3']; ?>"  placeholder="Mobile No 3" maxlength="10" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                                                        <div class="input-group-addon"><i class="fa fa-mobile"></i></div>
                                                                    </div>
                                                                </div>
                                                                <p class="text-muted m-b-0 m-t-10"> Other Phone No</p>
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" id="phone1" name="phone1" value="<?php echo $contact['phone1']; ?>"  placeholder="Phone No 1" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                                                        <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                                                                    </div>
                                                                </div>
    
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" id="phone2" name="phone2" value="<?php echo $contact['phone2']; ?>" placeholder="Phone No 2" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                                                        <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                                                                    </div>
                                                                </div>
                                                                <p class="text-muted m-b-0 m-t-10">GSTN No</p>
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" id="gstin_no" name="gstin_no" value="<?php echo $contact['gstin_no']; ?>" placeholder="GSTN No" maxlength="15">
                                                                        <div class="input-group-addon"><i class="fa fa-barcode"></i></div>
                                                                    </div>
                                                                </div>  
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-sm-12">
                                                        <div class="white-box bg-white-dark optimize-box m-b-0">
                                                            <center>
                                                                <h3 class="box-title m-b-10">Product Details</h3> 
                                                            </center>
                                                            <div class="no-bg-addon row optimize-spacing">
    
                                                                <div class="form-group col-sm-6">
                                                                    <select class="form-control" id="category_id" name="category_id[]">
                                                                        <option value="1">Installtion</option>
                                                                        <option value="2">Updatation</option>
                                                                        <option value="3">Lan</option>
                                                                        <option value="4">Conversion</option> 
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-sm-6">
                                                                    <select class="form-control" required id="si_product_id" name="si_clients_details_id" required>
                                                                        <option value="">Product</option>
                                                                        <?php
                                                                        foreach ($product as $p_value) {
                                                                            echo "<option value='" . $p_value['si_clients_details_id'] . "'>" . $p_value['p_name'] . "</option>";
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div><div class="form-group col-sm-6">
                                                                    <select class="form-control" id="si_conversion_product_id" name="si_conversion_product_id[]">
                                                                        <option value="0">Conversion Product</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-sm-6">
                                                                    <select class="form-control" id="laptop" name="laptop[]">
                                                                        <option value="NL">No Laptop</option>
                                                                        <option value="OL">Only Laptop</option>
                                                                        <option value="WL">With Laptop</option>  
                                                                    </select>
                                                                </div><div class="form-group col-sm-6">
                                                                    <select class="form-control" id="reg_type" name="reg_type[]">
                                                                        <option value="O">Online</option>
                                                                        <option value="H">HLock</option>  
                                                                    </select>
                                                                </div><div class="form-group col-sm-6">
                                                                    <select class="form-control" required id="si_for_year_id" name="for_year">
                                                                        <option value="">For Year</option>
                                                                        <?php
                                                                        foreach ($for_year as $p_year) {
                                                                            echo "<option value='" . $p_year['yearname'] . "'>" . $p_year['yearname'] . "</option>";
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-sm-6">
                                                                    <!--<select class="form-control" id="serial_no" name="serial_no">
                                                                        <option>Serial No/ HLock No</option>
                                                                    </select>-->
                                                                    <input type="text" name="serial_no[]" id="searial_no" class="form-control" placeholder="Enter Serial No/ HLock No">
                                                                </div>
                                                                <div class="form-group col-sm-6">
                                                                    <input class="form-control" name="activation_code[]" id="activation_code" placeholder="Activation Code" type="text">
                                                                </div>
                                                                <div class="form-group col-sm-6">
                                                                    <input class="form-control mydatepicker" name="purchase_date[]" id="purchase_date" placeholder="Purchase Date" type="text">
                                                                </div>
                                                                <div class="form-group col-sm-6">
                                                                    <input class="form-control mydatepicker" name="last_renewal_date[]" id="last_renewal_date" placeholder="Renewal Date" type="text">
                                                                </div>
    
    
                                                                <div class="form-group col-sm-6">
                                                                    <div class="input-group">
                                                                        <input class="form-control" readonly  placeholder="Registered email" type="email" id="regemail">
                                                                        <div class="input-group-addon"><i class="ti-email"></i></div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-sm-6 gstkeyselection" style="display:none">
                                                                   <!-- <select class="form-control" id="si_gstkey_id" name="si_gstkey_id">
                                                                        <option>Select GST Key</option>
                                                                        <option>1</option>
                                                                        <option>2</option>
                                                                        <option>3</option>
                                                                        <option>4</option>
                                                                        <option>5</option>
                                                                    </select>-->
                                                                    <input class="form-control" id="si_gstkey_id" name="si_gstkey_id[]" type="text" placeholder="Enter Gst Key">
                                                                </div>  
    
    
    
                                                                <div class="form-group col-sm-6 checkbox checkbox-danger email-change">
                                                                    <input id="changeemail" type="checkbox">
                                                                    <label for="changeemail"> Change Email </label>
                                                                </div>
                                                                <!-- <div class="form-group col-sm-12 checkbox checkbox-danger lan">
                                                                     <div class="pull-left">   
                                                                        <input id="lan" type="checkbox">
                                                                        <label for="lan">UL</label></div><input class="form-control" id="total_lan" name="total_lan[]"  type="text" placeholder="Lan" value="0">
                                                                    </div> -->  
                                                                <div class="form-group col-sm-12 checkbox checkbox-danger lan">
                                                                    <div class="pull-left">   
                                                                       <!-- <input id="lan" type="checkbox">
                                                                       <label for="lan">UL</label></div><input class="form-control" id="total_lan" name="total_lan[]"  type="text" placeholder="Lan" value="0"> -->
                                                                        <select class="form-control" id="s_pc" name="s_pc[]">
                                                                            <option value="0">Decl Without Srv</option>
                                                                            <option value="1">Decl With Srv</option>
                                                                            <option value="2">Lan</option>
                                                                        </select>
    
                                                                    </div>  
                                                                    <div class="form-group col-sm-6">
                                                                        <input class="form-control" id="total_lan" name="total_lan[]"  type="text" placeholder="Lan" value="0" style="display:none">
                                                                    </div>
    
                                                                    <div class="ul-info col-sm-12 clearfix"  style="display:none">
                                                                        <div class="form-group col-sm-6">
                                                                            <label> UL Declaration Form </label>
                                                                            <a href="<?= base_url("/assetss/pdf/LANDeclarationForm.pdf") ?>" class="btn btn-primary optimize-btn"  target="_blank">Download</a>
                                                                        </div>  
                                                                        <div class="form-group col-sm-6">
                                                                            <label> Upload UL Form </label>
                                                                            <div class="fileupload btn btn-warning optimize-btn"><span><i class="ion-upload m-r-5"></i>Upload</span>
                                                                                <input type="file" class="upload"> </div>
                                                                        </div>  
                                                                    </div>
    
    
    
                                                                    <div class="email-info col-sm-12  clearfix" style="display:none">
                                                                        <div class="form-group col-sm-6">
                                                                            <label> Change Email Form </label>
                                                                            <a href="<?= base_url("/assetss/pdf/RequestForEmailidChangeForm.pdf") ?>" class="btn btn-primary optimize-btn" target="_blank">Download</a>
                                                                        </div> 
    
    
    
                                                                        <div class="form-group col-sm-6">
                                                                            <label> Upload Form </label>
                                                                            <div class="fileupload btn btn-warning optimize-btn"><span><i class="ion-upload m-r-5"></i>Upload</span>
                                                                                <input type="file" class="upload"> </div>
                                                                        </div> 
    
                                                                    </div> 
    
                                                                </div>
                                                            </div>
    
                                                        </div></div>
                                                        
                                                    <div class="col-sm-12 col-sm-12">
                                                    	<div class="bg-white-dark clearfix">
                                                        	<center>
                                                                <h3 class="box-title m-b-10">Payment Details</h3> 
                                                            </center>
                                                            <div class="col-sm-6 col-sm-12 p-0">
                                                                <div class="white-box bg-white-dark optimize-box m-b-0 clearfix" style="padding: 0px 12px 5px;"> 
                                                                    <div class="optimize-spacing">
                                                                        <p class="text-muted m-b-0 m-t-10">Amount</p>
                                                                        <div class="form-group">
                                                                            <div class="input-group">
                                                                                <input class="form-control" required id="amount" name="amount" placeholder="Amount" type="text">
                                                                                <div class="input-group-addon"><i class="fa fa-asterisk"></i></div>
                                                                            </div>
                                                                        </div> 
                                                                        <div class="bank-transfers clearfix">
                                                                            <div class="radio radio-primary">
                                                                                <input name="payment_type" required id="Bank" value="Bank" type="radio">
                                                                                <label for="Bank"> Bank </label>
                                                                            </div>
                                                                            <div class="radio radio-success">
                                                                                <input name="payment_type" required id="Check" value="Check" type="radio">
                                                                                <label for="Check"> Check </label>
                                                                            </div>
                                                                            <div class="radio radio-info">
                                                                                <input name="payment_type" required id="Online" value="Online" type="radio">
                                                                                <label for="Online"> Online </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group checkbox checkbox-danger email-change bill-pay">
                                                                            <input id="billpayment"  value="1" name="isbill" type="checkbox">
                                                                            <label for="billpayment"> Bill Number</label>
                                                                        </div>
                                                                        <div class="form-group billno" style="display: none;">
                                                                            <div class="input-group">
                                                                                <input class="form-control" id="billnumber" name="billnumber" placeholder="Bill No" type="text">
                                                                                <div class="input-group-addon"><i class="fa fa-building"></i></div>
                                                                            </div>
                                                                        </div> 
                                                                        </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 col-sm-12 p-0">
                                                                <div class="white-box bg-white-dark optimize-box m-b-0">
                                                                    <div class="optimize-spacing">
                                                                      <div class="form-group">
                                                                        <div class="input-group">
                                                                            <textarea class="form-control" id="billremarks" name="billremarks" rows="5" placeholder="Remarks"></textarea>
                                                                            <div class="input-group-addon"><i class="fa  fa-star"></i></div>
                                                                        </div>
                                                                    </div>
                                                                      <div class="form-group col-sm-12 m-t-10">
                                                                        <button type="reset" class="btn btn-danger waves-effect waves-light m-l-10 pull-right" id="reset">Cancel</button>
                                                                        <button type="submit" class="btn btn-success waves-effect waves-light pull-right">Submit</button>
    
                                                                    </div>
                                                                </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                              </div>
                                            </form>
                                        </div>
                                        <div class="row" id="productdetailrow">
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
                                                                    <th>Activation Code</th>
                                                                    <th>Serial No</th>
                                                                    <th>purc date</th>
                                                                    <th>renew date</th>
                                                                    <th>Decl srv</th>
                                                                    <th>Lan</th>
                                                                    <th>Reg Type</th>
                                                                    <th>Attach File</th>
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

<!-- Editable
 <script src="<?php echo base_url(); ?>assetss/js/custom.min.js"></script>
<script src="<?php echo base_url(); ?>assetss/plugins/bower_components/jsgrid/db.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assetss/plugins/bower_components/jsgrid/dist/jsgrid.min.js"></script>
<script src="<?php echo base_url(); ?>assetss/js/jsgrid-init.js"></script> -->
<!--Style Switcher -->


</body>

<script>
    $('#myTab a[href="#home"]').tab('show');    
    $('.mydatepicker, #datepicker').datepicker({format: 'dd-mm-yyyy', todayHighlight: true
    });

    $('#c_id').change(function () {
        if (!this.checked)
            $('#conversion').fadeOut('slow');
        else
            $('#conversion').fadeIn('slow');
    });
    $('#billpayment').change(function () {
        if ($(this).prop("checked")) {
            $('.billno').show()
        } else {
            $('.billno').hide()
        }
    });    
    var id = $("#hid").val();
                        var url = "<?php echo base_url() . 'Admin/TransactionsDetail/get_all_product'; ?>";
                        $('#productdetailrow').show();
                        var tabs1 = $('#productdetail').DataTable({
                            "processing": true,
                            "serverSide": true,
                            "ajax": {
                                "url": url,
                                "data": {
                                    "id": id,
                                }
                            }
                        });
                        $('#productdetail>tbody').on('click', '.edit', function () {
        var id = $(this).data('id');
        var s_id=$('#hid').val();
        var rid = $("#dynOrderRow").data('id');
        console.log('id : '+ id+'rid : '+rid);
        $('.odd').removeClass("trcolor");
        $('.even').removeClass("trcolor");
        if (rid == id) {
            $("#hiddenRowId").val('');
            $("#Rows_id" + id).removeClass("trcolor");
            $("#dynOrderRow").remove();
            return false;
        } else {
            $("#Rows_id" + id).addClass("trcolor");
            $("#Rows_id" + id).addClass("selectlast-two");  
            TreeTable(id,s_id);
        }
    });
    
 // View Table In Tree Start
    function TreeTable(id,s_id) {

        $("#hiddenRowId").val(id);
        $("#dynOrderRow").remove();
        $.ajax({
            url: "<?php echo base_url() . 'Admin/TransactionsDetail/get_product_all_purchese' ?>",
            data: {'id': id,'s_id':s_id},
            method: 'post',
            dataType: 'html',
            success: function (data) {
                console.log(data);
                if (data.length > 0) {
                    $('#Rows_id' + id).after('');
                    $('#Rows_id' + id).after(data);
                } else {
                    //$("#Rows_id" + id).remove();
                }
            }
        });
    }
</script>
<!-- Attach File script end -->

</html>