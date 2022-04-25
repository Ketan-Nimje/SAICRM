<html>

<head>
    <?php $this->load->view('template/headerlink'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assetss/css/responsive.dataTables.min.css">
    <link href="<?php echo base_url(); ?>assetss/plugins/bower_components/custom-select/custom-select.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assetss/plugins/bower_components/switchery/dist/switchery.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assetss/plugins/bower_components/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assetss/plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assetss/plugins/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assetss/plugins/bower_components/multiselect/css/multi-select.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assetss/css/editor.css" type="text/css" rel="stylesheet" />
    <style>
        .trcolor {
            background-color: #CDE69C !important;
        }

        tfoot input {
            width: 100%;
            padding: 3px;
            box-sizing: border-box;
        }

        tfoot {
            display: table-header-group;
        }
        a.client_info.small-btn {
            position: relative;
            padding-left: 30px;
            cursor: pointer;
        }
        a.client_info.small-btn span {
            /* top: 9px; */
            left: 4px;
            height: 14px;
            width: 14px;
            display: block;
            position: absolute;
            color: white;
            border: 2px solid white;
            border-radius: 14px;
            box-shadow: 0 0 3px #444;
            box-sizing: content-box;
            text-align: center;
            background-color: #31b131;
            line-height: 14px;
        }
        #clientDetail span.dtr-title {
            display: inline-block;
            min-width: 150px;
            font-weight: 400;
        }
        #clientDetail span.dtr-data {
            margin-left: 10px;
        }
        /* #clientDetail .customer_info,
        #clientDetail .customer_address_contact {
            border-right: 1px solid #eeeff0;
        } */
        #clientDetail .modal-body {
            -webkit-user-select: none;  /* Chrome all / Safari all */
            -moz-user-select: none;     /* Firefox all */
            -ms-user-select: none;      /* IE 10+ */
            user-select: none;          /* Likely future */ 
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
                <?php if ($this->session->flashdata('error') != "") : ?>
                    <div class="row bg-title">
                        <div id="errordiv1" class="alert <?php echo $this->session->flashdata('errorcls'); ?> alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <?php echo $this->session->flashdata('error'); ?> </div>
                    </div>
                <?php
                endif;
                ?>
                <!-- ============================================================== -->
                <!-- Different data Product -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-xs-12">
                        <div class="white-box clearfix">

                            <!--                                <div class="panel clearfix">
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
                                                                                                                                                                                                                                                                                                                                                                                                                <p class="text-muted"> Enter below detail</p>
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
                                        if (in_array('Category', $pf)) {
                                        ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <div class="form-group col-sm-6">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <select class="form-control" id="category_id" data-id="20" name="category_id[]">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <option value="1">Installtion</option> 
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <option value="2">Updatation</option>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <option value="3">Lan</option>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <option value="4">Conversion</option>  
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </select>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </div>
                                            <?php
                                        }
                                        if (in_array('Product', $pf)) {
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
                                        if (in_array('Laptop', $pf)) {
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
                                        if (in_array('Register Type', $pf)) {
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
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <select class="form-control" id="serial_no" name="serial_no">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <option>Serial No/ HLock No</option>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </select>
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
                                                                </div>-->
                            <div class="col-sm-12 col-lg-12">
                                <?php if ($this->session->userdata('id') == 1) { ?>
                                    <a href="<?php echo base_url('Admin/TransactionsDetail/add_payment_view'); ?>">
                                        <button class="btn btn-primary popovers" data-trigger="hover" data-placement="top" data-content="Back" style="float:right;margin-right: 5%;margin-top: 1%;"><i class="fa fa-plus"></i></button>
                                    </a>
                                <?php } ?>
                                <div class="table-responsive p-t-30" style="width: 100%;">
                                    <h3 class="box-title m-b-10">MANAGE CLIENT</h3>
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <select class="form-control " id="select_inq" name="select_inq">
                                                <option value="A">Active</option>
                                                <option value="D">Deactive</option>
                                                <option value="All" selected>All </option>
                                            </select>
                                        </div>
                                    </div>
                                    <table id="product" class="table table-striped table-bordered manage-u-table optimize-table noselect select-third">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#
                                                    <input type="hidden" id="hiddenRowId">
                                                </th>
                                                <th>Customer Name</th>
                                                <th>Firm Name</th>
                                                <th>Mobile</th>
                                                <th>Email</th>
                                                <th>Serial No</th>
                                                <!--<th width="250">Lan Type</th>-->
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <th></th>
                                            <th>Customer Name</th>
                                            <th>Firm Name</th>
                                            <th>Mobile</th>
                                            <th>Email</th>
                                            <th>Serial No</th>
                                            <!--<th width="250">Lan Type</th>-->
                                            <th>Action</th>
                                        </tfoot>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row" id="productdetailrow" style="display: none">
                                <div class="col-sm-12">
                                    <div class="white-box bg-white-dark">
                                        <h3 class="box-title m-b-10">Client Product Detail
                                            <!-- <button class="btn btn-success waves-effect waves-light fix-btn m-l-10" type="button" data-toggle="modal" data-target="#productadd"><span class="btn-label"><i class="fa fa-plus"></i></span>Add Product</button>-->
                                        </h3>
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
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Add Product</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">Recipient:</label>
                            <input type="text" class="form-control" id="recipient-name">
                        </div>
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
            <!--<form method="post" onsubmit="javascript:addCustomerSolution();" action="<?php echo base_url("Client1/CustomerSolution"); ?>" >-->
            <form method="post" id="myform">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Customer Inquiry</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="client_id" id="hdnclient_id">
                        <div class="col-sm-12">
                            <div class="radio radio-inline radio-danger">
                                <input name="s_type" id="radio1" value="Itself" required="" type="radio" checked>
                                <label for="radio1"> Solve By <?php echo $_SESSION['name']; ?> </label>
                            </div>
                            <div class="radio radio-inline radio-danger">
                                <input name="s_type" id="radio2" value="SendTL" required="" type="radio">
                                <label for="radio2"> Send To Team Leader </label>
                            </div>
                            <div class="radio radio-inline radio-danger">
                                <input name="s_type" id="radio3" value="SendAdmin" required="" type="radio">
                                <label for="radio3"> Send To Admin </label>
                            </div>
                        </div>
                        <div class="row m-b-10 clearfix">
                            <div class="col-sm-3 m-t-10">
                                <label>Select Product</label>
                                <!--<select multiple id="public-methods" class="userProduct" name="si_product_id[]" required="">-->
                                <select class="form-control userProduct" name="si_product_id" required="">
                                    <?php
                                    //                                foreach ($product as $p_value) {
                                    //                                    echo "<option value='" . $p_value['si_product_id'] . "'>" . $p_value['p_name'] . "</option>";
                                    //                                }
                                    ?>
                                </select>
                                <div class="inqviry-details">
                                    <div class="radio radio-custom">
                                        <input type="radio" name="inquiry" id="format" value="format">
                                        <label for="format"> Format </label>
                                    </div>
                                    <div class="radio radio-primary">
                                        <input type="radio" name="inquiry" id="queries" value="queries">
                                        <label for="queries"> Queries </label>
                                    </div>
                                    <div class="radio radio-success">
                                        <input type="radio" name="inquiry" id="technical" value="technical">
                                        <label for="technical"> Technical </label>
                                    </div>
                                    <div class="radio radio-info">
                                        <input type="radio" name="inquiry" id="lan-issues" value="lan-issues">
                                        <label for="lan-issues"> Lan Issues </label>
                                    </div>
                                    <div class="radio radio-danger">
                                        <input type="radio" name="inquiry" id="demo" value="demo">
                                        <label for="demo"> Demo </label>
                                    </div>
                                    <div class="radio radio-purple">
                                        <input type="radio" name="inquiry" id="others" value="others">
                                        <label for="others"> Others </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-t-10 col-sm-9 clearfix">
                                <label class="col-md-12">Remark</label>
                                <div class="col-md-12">
                                    <textarea class="form-control" rows="7" name="remark"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                            <!--<button type="button" class="btn btn-inverse waves-effect waves-light" data-dismiss="modal">Close</button>-->
                        </div>
                        <div class="row" id="customer">
                            <div class="col-sm-12">
                                <div class="white-box bg-white-dark">
                                    <h3 class="box-title m-b-10">Customer Product Solution Detail
                                        <!-- <button class="btn btn-success waves-effect waves-light fix-btn m-l-10" type="button" data-toggle="modal" data-target="#productadd"><span class="btn-label"><i class="fa fa-plus"></i></span>Add Product</button>-->
                                    </h3>
                                    <div class="table-responsive">
                                        <table id="customersolution" class="table table-striped table-bordered optimize-table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Product Name</th>
                                                    <th>Send To</th>
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
                        <button type="button" class="btn btn-inverse waves-effect waves-light" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="mailModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <form id="sendEmail" onsubmit="DoSubmit()">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Customer mail Inquiry</h4>
                    </div>
                    <div class="modal-body clearfix">
                        <input type="hidden" name="client_id" id="hdnclient_id">
                        <div class="form-group col-sm-4">
                            <label for="send_from">From:</label>
                            <input type="text" class="form-control" id="send_from" name="send_from" required="">
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="send_to">To:</label>
                            <input type="text" class="form-control" id="send_to" name="send_to" required="">
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="send_sub">Subject:</label>
                            <input type="text" class="form-control" id="send_sub" name="send_sub" required="">
                        </div>
                        <div class="form-group col-sm-12 clearfix">
                            <label for="send_msg">Message:</label>
                            <!-- <textarea class="form-control" id="send_msg" rows="7" name="send_msg"></textarea> -->
                            <textarea class="editor-text" name="sai_mail_msg" id="send_msg"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-inverse waves-effect waves-light" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                        <!--<button type="button" class="btn btn-inverse waves-effect waves-light" data-dismiss="modal">Close</button>-->
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
    <div id="clientDetail" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Customer Detail</h4>
                </div>
                <div class="modal-body clearfix">
                    <div class="customer_info col-lg-12">
                        <h5>CLIENT DETAILS</h5>
                        <hr>
                        <div>
                            <ul class="customer_info_li">
                            </ul>
                        </div>
                    </div>
                    <div class="customer_address_contact col-lg-12">
                        <h5>ADDRESS & CONTACT DETAILS</h5>
                        <hr>
                        <div>
                            <ul class="address_info_li">
                            </ul>
                        </div>
                    </div>
                    <div class="customer_product col-lg-12">
                        <h5>PRODUCT DETAILS</h5>
                        <hr>
                        <div>
                            <ul class="product_info_li">
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-inverse waves-effect waves-light" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!----- SMS Modal --------------------->
    <input type="hidden" id="numm">
    <div id="smsModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm">

            <!-- Modal content-->

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"> WhatsApp Message</h4>
                </div>
                <div class="modal-body clearfix">
                    <div class="form-group col-sm-12">
                        <label for="send_to_wa">To:</label>
                        <input type="text" class="form-control" id="send_to_wa" name="send_to_wa">
                    </div>
                    <div class="form-group col-sm-12 clearfix">
                        <label for="send_msg">Message:</label>
                        <textarea class="form-control" id="send_msg_wa" rows="7" name="send_msg_wa" placeholder="Hello, Start Writing Your Message From Here" onKeyPress="myf();"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-inverse waves-effect waves-light" data-dismiss="modal">Close</button>
                    <a target="_blank" class="adata_id">
                        <button type="button" send="btn" class="btn btn-success waves-effect waves-light m-r-10">Send</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!----- SMS Modal --------------------->
    <!-- js placed at the end of the document so the pages load faster -->
    <?php $this->load->view('template/footerlink'); ?>
    <script src="<?php echo base_url(); ?>assetss/js/dataTables.responsive.js"></script>
    <script src="<?php echo base_url(); ?>assetss/plugins/bower_components/switchery/dist/switchery.min.js"></script>
    <script src="<?php echo base_url(); ?>assetss/plugins/bower_components/custom-select/custom-select.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assetss/plugins/bower_components/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assetss/plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
    <script src="<?php echo base_url(); ?>assetss/plugins/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assetss/plugins/bower_components/multiselect/js/jquery.multi-select.js"></script>
    <script src="<?php echo base_url(); ?>assetss/js/editor.js"></script>
    <script>
        $(document).ready(function() {
            $(".editor-text").Editor();
        });

        $('#product>tbody').on('click', '.whatsapp', function() {
            var isst = $(this).data('isstatus');
            if (isst == 'D') {
                swal(
                    'Deactivate',
                    'Contact to Admin  :)',
                    'error'
                );
            } else {
                $('#send_to_wa').val($(this).data('id'));
                $('#numm').val($(this).data('id'));
                $('#send_msg_wa').val('Type Message Here');
                $('#send_to_wa').attr('disabled', 'disabled');
                $("#smsModal").modal({
                    backdrop: 'static',
                    keyboard: false
                });
            }
        });

        function myf() {
            n = $("#numm").val();
            var msg = $("#send_msg_wa").val().replace(" ", "%20");
            var e = "https://web.whatsapp.com:/send?phone=+91" + n + "&text=" + msg + "%20https://www.saiinfotech.co/Shoppingcart";
            $('.adata_id').attr('href', e);
        }
    </script>
    <!-- Editable
 <script src="<?php // echo base_url(); 
                ?>assetss/js/custom.min.js"></script>
<script src="<?php //echo base_url(); 
                ?>assetss/plugins/bower_components/jsgrid/db.js"></script>
<script type="text/javascript" src="<?php //echo base_url(); 
                                    ?>assetss/plugins/bower_components/jsgrid/dist/jsgrid.min.js"></script>
<script src="<?php //echo base_url(); 
                ?>assetss/js/jsgrid-init.js"></script> -->
    <!--Style Switcher -->

</body>
<script>
    $('#editable').DataTable({
        responsive: false
    });
    $('.mydatepicker, #datepicker').datepicker({
        format: 'yyyy-mm-dd'
    });
    $('#c_id').change(function() {
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
        "responsive": true,
        "serverSide": true,
        "destroy": true,
        "lengthMenu": [
            [10, 30, 40, 50, 100, 500],
            [10, 30, 40, 50, 100, 500]
        ],
        "pageLength": 10,
        "order": [
            [00, "desc"]
        ],
        "ajax": {
            "data": {
                "select_inq": $("#select_inq").val()
            },
            "url": "<?php echo base_url() . 'Client1/GetData'; ?>"
        },
        "aoColumnDefs": [{
                bSortable: false,
                aTargets: [-1, -2, 0]
            } //,{"targets": [-1,-2,-3,-4,-5,-6,-7,-8,-9],"visible": false }
            ,{
                bSearchable: false,
                aTargets: [1, 2]
            } 
        ]
    });
    $('#select_inq').change(function() {
        var tabs = $('#product').DataTable({
            "processing": true,
            "responsive": true,
            "destroy": true,
            "serverSide": true,
            "lengthMenu": [
                [10, 30, 40, 50, 100, 500],
                [10, 30, 40, 50, 100, 500]
            ],
            "pageLength": 10,
            "order": [
                [00, "desc"]
            ],
            "ajax": {
                "data": {
                    "select_inq": $("#select_inq").val()
                },
                "url": "<?php echo base_url() . 'Client1/GetData'; ?>"
            },
            "aoColumnDefs": [{
                bSortable: false,
                aTargets: [-1, -2]
            }]
        });
    });

    $('#product tfoot th').each(function(colIdx) {
        var abc = $("#product").find("tr:first th").length;
        //          console.log('sdjkj : ' + abc+'col :'+colIdx);

        if (colIdx == 1) {
            $(this).html('<input type="text" />');
        } else if (colIdx == 2) {
            $(this).html('<input type="text" />');
        } else if (colIdx == 3) {
            $(this).html('<input type="text" />');
        } else if (colIdx == 4) {
            $(this).html('<input type="text" />');
        } else if (colIdx == 5) {
            $(this).html('<input type="text" />');
        } else if (colIdx == 6) {
            // $(this).html('<input type="text" />');
            $(this).html('');
        } else {
            $(this).html('');
        }
    });
    tabs.columns().every(function(colIdx) {

        var that = this;
        $('input', tabs.column(colIdx).footer()).on('keyup change', function() {
            if (that.search() !== this.value) {
                that
                    .column(colIdx)
                    .search(this.value)
                    .draw();
            }
        });
        //                $('input', tabs.column(colIdx).footer()).on('change', function () {
        //                     datagridedit();
        //                });
        //                
        //                $('select', tabs.column(colIdx).footer()).on('keyup change', function () {
        //                    if (that.search() !== this.value) {
        //                        that
        //                                .column(colIdx)
        //                                .search(this.value)
        //                                .draw();
        //                                datagridedit();
        //                    }
        //                });
    });
    $('#product>tbody').on('click', '.status', function() {
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
        }).then(function() {
            $.ajax({
                type: 'post',
                data: {
                    'id': id,
                    'status': st,
                    'tbl': tbl
                },
                url: '<?php echo base_url('Helper/change_status'); ?>',
                dataType: 'json',
                success: function(data) {
                    if (data == 1) {
                        swal(
                            'Successfully!',
                            'Selected Client has been ' + title + '.',
                            'success'
                        )
                        tabs.draw();
                    }
                }
            });
        }, function(dismiss) {
            if (dismiss === 'cancel') {
                swal(
                    'Cancelled',
                    'Your imaginary Client is safe :)',
                    'error'
                )
            }
        })
    });
    $('#product>tbody').on('click', '.delete', function() {
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
        }).then(function() {
            $.ajax({
                type: 'post',
                url: '<?php echo base_url('Helper/change_status'); ?>',
                data: {
                    'id': id,
                    'status': st,
                    'tbl': tbl
                },
                dataType: 'html',
                success: function(data) {
                    if (data == 1) {
                        swal(
                            'Successfully!',
                            'Selected Client has been  Deleted.',
                            'success'
                        )
                        tabs.draw();
                    }
                }
            });
        }, function(dismiss) {
            if (dismiss === 'cancel') {
                swal(
                    'Deactivate',
                    'Your imaginary Client is safe :)',
                    'error'
                )
            }
        })
    });
    $('#product>tbody').on('click', '.edit', function() {
        var id = $(this).data('id');
        // $.ajax({
        //     type: "get",
        //     data: {
        //         "id": id
        //     },
        //     url: "<?php echo base_url() . 'Client1/check_if_any_deactive' ?>",
        //     success: function(data) {
        //         if (data == "1") {
        //             swal("Please Check This Data Carefully Because This Customer's Any Product is Expired or DeActive !! ");
        //         }
        //     }
        // });
        var rid = $("#dynOrderRow").data('id');
        var st = $(this).data('status');
        var isst = $(this).data('isstatus');
        if (isst == 'D') {
            swal(
                'Deactivate',
                'Contact to Admin  :)',
                'error'
            );
        } else {
            $('.odd').removeClass("trcolor");
            $('.even').removeClass("trcolor");
            $(".odd").removeClass("trredcolor");
            $(".even").removeClass("trredcolor");
            if (rid == id) {
                $("#hiddenRowId").val('');
                $("#Rows_id" + id).removeClass("trcolor");
                $("#dynOrderRow").remove();
                return false;
            } else {
                $("#Rows_id" + id).addClass("trcolor");
                TreeTable(id);
            }
        }
    });
    $("#product>tbody").on("click", ".pay", function() {
        var id = $(this).data('id');
        var st = $(this).data('status');
        var isst = $(this).data('isstatus');
        if (isst == 'D') {
            swal(
                'Deactivate',
                'Contact to Admin  :)',
                'error'
            );
        } else {
            var url = "<?php echo base_url() . 'Admin/TransactionsDetail/add_payment_view?id='; ?>" + id;
            window.location.href = url;
        }
    });
    $("#product>tbody").on("click", ".mail", function() {
        var id = $(this).data('id');
        var st = $(this).data('status');
        var isst = $(this).data('isstatus');
        var srno = $(this).data('serial');
        if (isst == 'D') {
            swal(
                'Deactivate',
                'Contact to Admin  :)',
                'error'
            );
        } else {
            $('#send_from').val('genius.surat@gmail.com');
            $('#send_to').val($(this).data('mailid'));
            $('#send_sub').val('GENIUS RENEWAL : A.Y. 2021-22. BANK DETAILS : SAI INFOTECH SURAT SrNo: ' + srno);
            $('#send_msg').val(' <p>Dear Sir,</p><p>Greetings For the day.</p><p>We are Thanking you to Choose our Software and Services.</p><p>Please find below details for Genius Software Renewal.</p><p>Please feel free to call us if any issues.</p><p>Amount -</p><p> You Can Also Pay Online With Payment Gateway via below link & For UPI Payment Scan the Bar Code Attached Or Pay On (9328394945@upi).</p><p><a href="https://saiinfotech.co/Shoppingcart">https://saiinfotech.co/Shoppingcart</a> </p><p>Please Send Payment receipt in <a href="mailto:genius.surat@gmail.com" target="_blank">genius.surat@gmail.com</a> to Complete your Activation Process.</p><p>Thanks</p><p>SAI Infotech, Surat</p><p>Supports - 0261-2369109 ( 12 Lines )</p><p>Sales - 0261-4897600 ( 6 Lines )</p><p style="text-decoration: underline;">BANK DETAIL </p><table style="border-collapse: separate; width: 500px; border: 1px solid black;"><tr><td style="padding: 3px; border: 1px solid black;">Account Name</td><td style="padding: 3px; border: 1px solid black;">SAI INFOTECH</td></tr><tr><td style="padding: 3px; border: 1px solid black;">Bank Name</td><td style="padding: 3px; border: 1px solid black;">INDUSIND Bank Ltd</td></tr><tr><td style="padding: 3px; border: 1px solid black;">Branch</td><td style="padding: 3px; border: 1px solid black;">Empire Estate Branch, Surat</td></tr><tr><td style="padding: 3px; border: 1px solid black;">Account Number</td><td style="padding: 3px; border: 1px solid black;">200999038453</td></tr><tr><td style="padding: 3px; border: 1px solid black;">IFSC Code</td><td style="padding: 3px; border: 1px solid black;">INDB0000023</td></tr><tr><td style="padding: 3px; border: 1px solid black;">Account Type</td><td style="padding: 3px; border: 1px solid black;">Current Account</td></tr></table><div><div dir="ltr"><br><img src="https://www.saiinfotech.co/assets/images/UPI_FINAL.JPG" width="452" height="224"><br><b>Thanks&nbsp;&amp; Regards..<br><?php echo $_SESSION['name']; ?></b><br><br><font face="tahoma, sans-serif"><font style="font-size:large" color="#000000"><b><img src="https://saiinfotech.co/assets/images/sai-logo.jpg" width="96" height="40" class="CToWUd">&nbsp;|<a href="http://www.saiinfotech.co" target="_blank" data-saferedirecturl="https://www.google.com/url?q=http://www.saiinfotech.co&amp;source=gmail&amp;ust=1553084931912000&amp;usg=AFQjCNGYRSyT6NKUCkUwByh0jqpYwS2qbA">www.saiinfotech.co</a></b></font></font></div><div dir="ltr"><font color="#000000" size="1" face="verdana, sans-serif"><b style="background-color:rgb(255,255,255)"><br></b></font></div><div dir="ltr"><font size="2"><font color="#000000" face="verdana, sans-serif"><b style="background-color:rgb(255,255,255)">Address:-&nbsp;</b></font><font face="tahoma, sans-serif"><font color="#000000">105-106, Ajanta Shopping Centre,&nbsp;</font><span style="color:rgb(0,0,0)">Nr. Kinnary Cinema,&nbsp;</span>Ring Road,&nbsp;SURAT : 395002</font></font></div><div dir="ltr"><div><div><font size="2"><font style="font-family:verdana,sans-serif" color="#000000"><strong>Sales&nbsp; &nbsp; &nbsp;:-</strong> </font><font face="tahoma, sans-serif"><font color="#000000">0</font>93283 94945 | 0261-4897600 (6 Lines)</font></font></div><div><font size="2"><font face="verdana, sans-serif"><font color="#000000"><strong>Support :-&nbsp;</strong></font></font><font face="tahoma, sans-serif">0261 2369109&nbsp;(12 LINES) |&nbsp;93777 94945 |&nbsp;94278 94946 | 93285 94945</font><span style="font-family:verdana,sans-serif">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</span></font></div><div><font size="2"><font style="font-family:verdana,sans-serif" color="#000000"><strong>E-Mail &nbsp; &nbsp;:-</strong></font><span style="font-family:verdana,sans-serif">&nbsp;</span><font face="tahoma, sans-serif"><a href="mailto:genius.surat@gmail.com" target="_blank">genius.surat@gmail.com</a><b>&nbsp;| </b><a href="mailto:sales@saiinfotech.co" target="_blank">sales@saiinfotech.co</a></font></font><br></div><div><br><font color="#bf9000" size="4" face="georgia, serif">Be Genius.... Use Genius....</font><div class="yj6qo"></div><div class="adL"><br><br><br><br></div></div></div></div></div>');
            $(".editor-text").Editor("setText", ' <p>Dear Sir,</p><p>Greetings For the day.</p><p>We are Thanking you to Choose our Software and Services.</p><p>Please find below details for Genius Software Renewal.</p><p>Please feel free to call us if any issues.</p><p>Amount -</p><p> You Can Also Pay Online With Payment Gateway via below link & For UPI Payment Scan the Bar Code Attached Or Pay On (9328394945@upi).</p><p><a href="https://saiinfotech.co/Shoppingcart">https://saiinfotech.co/Shoppingcart</a> </p><p>Please Send Payment receipt in <a href="mailto:genius.surat@gmail.com" target="_blank">genius.surat@gmail.com</a> to Complete your Activation Process.</p><p>Thanks</p><p>SAI Infotech, Surat</p><p>Supports - 0261-2369109 ( 12 Lines )</p><p>Sales - 0261-4897600 ( 6 Lines )</p><p style="text-decoration: underline;">BANK DETAIL </p><table style="border-collapse: separate; width: 500px; border: 1px solid black;"><tr><td style="padding: 3px; border: 1px solid black;">Account Name</td><td style="padding: 3px; border: 1px solid black;">SAI INFOTECH</td></tr><tr><td style="padding: 3px; border: 1px solid black;">Bank Name</td><td style="padding: 3px; border: 1px solid black;">INDUSIND Bank Ltd</td></tr><tr><td style="padding: 3px; border: 1px solid black;">Branch</td><td style="padding: 3px; border: 1px solid black;">Empire Estate Branch, Surat</td></tr><tr><td style="padding: 3px; border: 1px solid black;">Account Number</td><td style="padding: 3px; border: 1px solid black;">200999038453</td></tr><tr><td style="padding: 3px; border: 1px solid black;">IFSC Code</td><td style="padding: 3px; border: 1px solid black;">INDB0000023</td></tr><tr><td style="padding: 3px; border: 1px solid black;">Account Type</td><td style="padding: 3px; border: 1px solid black;">Current Account</td></tr></table><div><div dir="ltr"><br><img src="https://www.saiinfotech.co/assets/images/UPI_FINAL.JPG" width="452" height="224"><br><b>Thanks&nbsp;&amp; Regards..<br><?php echo $_SESSION['name']; ?></b><br><br><font face="tahoma, sans-serif"><font style="font-size:large" color="#000000"><b><img src="https://saiinfotech.co/assets/images/sai-logo.jpg" width="96" height="40" class="CToWUd">&nbsp;|<a href="http://www.saiinfotech.co" target="_blank" data-saferedirecturl="https://www.google.com/url?q=http://www.saiinfotech.co&amp;source=gmail&amp;ust=1553084931912000&amp;usg=AFQjCNGYRSyT6NKUCkUwByh0jqpYwS2qbA">www.saiinfotech.co</a></b></font></font></div><div dir="ltr"><font color="#000000" size="1" face="verdana, sans-serif"><b style="background-color:rgb(255,255,255)"><br></b></font></div><div dir="ltr"><font size="2"><font color="#000000" face="verdana, sans-serif"><b style="background-color:rgb(255,255,255)">Address:-&nbsp;</b></font><font face="tahoma, sans-serif"><font color="#000000">105-106, Ajanta Shopping Centre,&nbsp;</font><span style="color:rgb(0,0,0)">Nr. Kinnary Cinema,&nbsp;</span>Ring Road,&nbsp;SURAT : 395002</font></font></div><div dir="ltr"><div><div><font size="2"><font style="font-family:verdana,sans-serif" color="#000000"><strong>Sales&nbsp; &nbsp; &nbsp;:-</strong> </font><font face="tahoma, sans-serif"><font color="#000000">0</font>93283 94945 | 0261-4897600 (6 Lines)</font></font></div><div><font size="2"><font face="verdana, sans-serif"><font color="#000000"><strong>Support :-&nbsp;</strong></font></font><font face="tahoma, sans-serif">0261 2369109&nbsp;(12 LINES) |&nbsp;93777 94945 |&nbsp;94278 94946 | 93285 94945</font><span style="font-family:verdana,sans-serif">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</span></font></div><div><font size="2"><font style="font-family:verdana,sans-serif" color="#000000"><strong>E-Mail &nbsp; &nbsp;:-</strong></font><span style="font-family:verdana,sans-serif">&nbsp;</span><font face="tahoma, sans-serif"><a href="mailto:genius.surat@gmail.com" target="_blank">genius.surat@gmail.com</a><b>&nbsp;| </b><a href="mailto:sales@saiinfotech.co" target="_blank">sales@saiinfotech.co</a></font></font><br></div><div><br><font color="#bf9000" size="4" face="georgia, serif">Be Genius.... Use Genius....</font><div class="yj6qo"></div><div class="adL"><br><br><br><br></div></div></div></div></div>');
            $("#mailModal").modal({
                backdrop: 'static',
                keyboard: false
            });
            /*$.ajax({
                url: "<?php echo base_url() . 'Client1/send_mail'; ?>",
                method: 'post',
                data: {'tbl': 'send_mail', 'sai_mail_to': $('send_to').val(),'sai_mail_from':$('send_from').val(),'sai_mail_sub':$('send_sub').val(),'sai_mail_msg':$('send_msg').val()},
                dataType: 'json',
                success: function (data) {
                   console.log(data);
                },
            });*/
        }
    });
    $("#product>tbody").on("click", ".remark", function() {

        $("#hdnclient_id").val($(this).data('id'));
        var st = $(this).data('status');
        var isst = $(this).data('isstatus');
        if (isst == 'D') {
            swal(
                'Deactivate',
                'Contact to Admin  :)',
                'error'
            );
        } else {
            $("#myModal").modal({
                backdrop: 'static',
                keyboard: false
            });
            $.ajax({
                url: "<?php echo base_url() . 'Client1/get_client_edit_data'; ?>",
                method: 'post',
                data: {
                    'tbl': 'si_product',
                    'id': $(this).data('id')
                },
                dataType: 'json',
                success: function(data) {
                    $(".userProduct").html('');
                    //                $('.userProduct')
                    //                            .append($("<option></option>")
                    //                                    .attr("value", 0)
                    //                                    .text('Selected Product'));
                    $.each(data.product, function(key, value) {


                        $('.userProduct')
                            .append($("<option></option>")
                                .attr("value", value.si_product_id)
                                .text(value.p_name));
                        //                            $("#selection").html("<span>" + p_name + "</span>");


                        //console.log('value : '+value.p_name);
                    });
                },
            });
            CustomerSolutionDataTable($(this).data('id'));
        }
    });
    $('#myModal').on('hidden.bs.modal', function() {
        $("input[name=s_type").removeAttr("checked", true);
        $("textarea[name=remark]").val('');
    })
    // View Table In Tree Start
    function TreeTable(id) {

        $("#hiddenRowId").val(id);
        $("#dynOrderRow").remove();
        $.ajax({
            url: "<?php echo base_url() . 'Client1/get_client_all_product' ?>",
            data: {
                'id': id
            },
            method: 'post',
            dataType: 'html',
            success: function(data) {
                //console.log(data);
                var str1 = data;
                var str2 = "Decl Without Srv";
                if (str1.indexOf(str2) != -1) {
                    $("#Rows_id" + id).removeClass("trcolor");
                    $("#Rows_id" + id).addClass("trredcolor");
                }
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

    // Customer Solution DataTable Function Start
    function CustomerSolutionDataTable(id) {
        $('#customersolution').DataTable().destroy();
        var tabs1 = $('#customersolution').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [
                [1, "desc"]
            ],
            "ajax": {
                "url": "<?php echo base_url() . 'Client1/getCustomerSolution'; ?>",
                "data": {
                    "id": id,
                }
            },
            "aoColumnDefs": [{
                bSortable: false,
                aTargets: [-1],
            }],
        });
    }
    // Customer Solution DataTable Function End

    $('#lan').change(function() {
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
    $('#changeemail').change(function() {
        if ($(this).prop("checked")) {
            $('.email-info').show()
        } else {
            $('.email-info').hide()
        }
    });
    $('#si_product_id').change(function() {
        if ($(this).val() == "57") {
            $(".gstkeyselection").show()
        } else {
            $(".gstkeyselection").hide()
        }


    });
    $('#category_id').change(function() {

        change_product_con();
    });

    function change_product_con() {
        var id = $('#hid').val();
        if ($('#category_id').val() == "1" && id) {
            $.ajax({
                type: 'post',
                data: {
                    'all_p': 'All'
                },
                url: '<?php echo base_url('Admin/Client1/get_conversion_data'); ?>',
                dataType: 'json',
                success: function(data) {
                    $('#si_product_id').find('option').remove();
                    $('#si_product_id')
                        .append($("<option></option>")
                            .attr("value", 0)
                            .text('Selected Product'));
                    $.each(data.product, function(key, value) {
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
            //console.log('update cat' + id + 'tbl : ' + tbl);
            $.ajax({
                type: 'post',
                data: {
                    'id': id,
                    'tbl': tbl
                },
                url: '<?php echo base_url('Admin/Client1/get_client_edit_data'); ?>',
                dataType: 'json',
                success: function(data) {
                    $('#si_product_id').find('option').remove();
                    $('#si_product_id')
                        .append($("<option></option>")
                            .attr("value", 0)
                            .text('Selected Product'));
                    $.each(data.product, function(key, value) {
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
                    data: {
                        'tbl': tbl
                    },
                    url: '<?php echo base_url('Admin/Client1/get_conversion_data'); ?>',
                    dataType: 'json',
                    success: function(data) {
                        $('#si_conversion_product_id').find('option').remove();
                        $('#si_conversion_product_id')
                            .append($("<option></option>")
                                .attr("value", 0)
                                .text('Conversion Product'));
                        $.each(data.product, function(key, value) {
                            $('#si_conversion_product_id')
                                .append($("<option></option>")
                                    .attr("value", value.si_product_id)
                                    .text(value.p_name));
                            // console.log('value : ' + value.p_name);
                        });
                    }
                });
            }
        } else {
            $('#si_conversion_product_id').find('option').remove();
            $('#si_conversion_product_id')
                .append($("<option></option>")
                    .attr("value", 0)
                    .text('Conversion Product'));
        }

    }

    $('#myform').submit(function(evt) {
        var id = $("#hdnclient_id").val();
        var s_type = $("input[name=s_type]:checked").val();
        var si_product_id = $(".userProduct").val();
        var remark = $("textarea[name=remark]").val();
        var inquiry = $("input[name=inquiry]:checked").val();
        $.ajax({
            type: 'post',
            url: '<?php echo base_url("Client1/CustomerSolution"); ?>',
            data: {
                'client_id': id,
                's_type': s_type,
                'si_product_id': si_product_id,
                'remark': remark,
                'inquiry': inquiry
            },
            success: function(data) {
                //  console.log(data);
                swal(
                    'Successfully!',
                    'Successfully add inquiry.',
                    'success'
                );
                $("#radio1").attr('checked', true);
                $("textarea[name=remark]").val('');
                CustomerSolutionDataTable(id);

            }
            //prevents the default action
        });
        evt.preventDefault();
    });

    //--------------------GST_NEW

    $('#product>tbody').on('click', '.is_gst', function() {
        var id = $(this).data('id');

        var msg = "DO YOU WANT TO UPGRADE NEW VERSION OF GST SOFTWARE ?? ";
        var btn = ' UPGRADE NEW VERSION ';
        var title = "UPGRADED ! ";

        swal({
            title: 'Are you sure ?',
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
        }).then(function() {
            $.ajax({
                type: 'post',
                data: {
                    'id': id
                },
                url: '<?php echo base_url('Helper/upgrade_gst_new'); ?>',
                dataType: 'json',
                success: function(data) {
                    if (data == 1) {
                        swal(
                            'Successfully!',
                            'Selected Client GST has been ' + title + '.',
                            'success'
                        )
                        tabs.draw();
                    }
                }
            });
        }, function(dismiss) {
            if (dismiss === 'cancel') {
                swal(
                    'Cancelled',
                    'Your imaginary Client is safe :)',
                    'error'
                )

            }
        })
    });


    //---------------------
</script>
<script>
    jQuery(document).ready(function() {
        // Switchery

        $('#public-methods').multiSelect();
        $('#select-all').click(function() {
            $('#public-methods').multiSelect('select_all');
            return false;
        });
        $('#deselect-all').click(function() {
            $('#public-methods').multiSelect('deselect_all');
            return false;
        });
        $('#refresh').on('click', function() {
            $('#public-methods').multiSelect('refresh');
            return false;
        });
        $('#add-option').on('click', function() {
            $('#public-methods').multiSelect('addOption', {
                value: 42,
                text: 'test 42',
                index: 0
            });
            return false;
        });
    });
</script>
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

                $(document).on('keydown', '#contact_person', function(e) { // search data by invoice or datewise
                    var code = e.keyCode || e.which;
                    if (code === 9 || code == 13) {
                        // console.log("t " + e.keyCode);
                        // console.log("w " + e.which);
                        var cont = $('#contact_person').val();
                        var col = $(this).data('id');
                        tabs.column(col).search(cont).draw();
                    }
                });
            <?php
            }
            if (in_array('Firm Name', $cf)) {
            ?>
                $(document).on('keydown', '#firm_name', function(e) { // search data by invoice or datewise
                    var code = e.keyCode || e.which;
                    if (code === 9 || code == 13) {

                        var cont = $('#firm_name').val();
                        var col = $(this).data('id');
                        //console.log(col);
                        tabs.column(col).search(cont).draw();
                    }
                });
            <?php
            }
            if (in_array('Address', $cf)) {
            ?>
                $(document).on('keydown', '#address', function(e) { // search data by invoice or datewise


                    var cont = $('#address').val();
                    var col = $(this).data('id');
                    //console.log(col);
                    tabs.column(col).search(cont).draw();
                });
            <?php
            }
            if (in_array('Other Address', $cf)) {
            ?>
                $(document).on('keydown', '#address1', function() { // search data by invoice or datewise

                    var cont = $('#address1').val();
                    var col = $(this).data('id');
                    //console.log(col);
                    tabs.column(col).search(cont).draw();
                });
            <?php
            }
            if (in_array('Area', $cf)) {
            ?>
                $(document).on('keydown', '#area', function(e) { // search data by invoice or datewise
                    var code = e.keyCode || e.which;
                    if (code === 9 || code == 13) {

                        var cont = $('#area').val();
                        var col = $(this).data('id');
                        //console.log(col);
                        tabs.column(col).search(cont).draw();
                    }
                });
            <?php
            }
            if (in_array('City', $cf)) {
            ?>
                $(document).on('keydown', '#city', function(e) { // search data by invoice or datewise
                    var code = e.keyCode || e.which;
                    if (code === 9 || code == 13) {

                        var cont = $('#city').val();
                        var col = $(this).data('id');
                        // console.log(col);
                        tabs.column(col).search(cont).draw();
                    }
                });
            <?php
            }
            if (in_array('State', $cf)) {
            ?>
                $(document).on('change', '#si_state_id', function() { // search data by invoice or datewise

                    var cont = $('#si_state_id').val();
                    var col = $(this).data('id');
                    // console.log(col);
                    tabs.column(col).search(cont).draw();
                });
            <?php
            }
            if (in_array('Pincode', $cf)) {
            ?>
                $(document).on('keydown', '#pincode', function(e) { // search data by invoice or datewise
                    var code = e.keyCode || e.which;
                    if (code === 9 || code == 13) {

                        var cont = $('#pincode').val();
                        var col = $(this).data('id');
                        // console.log(col);
                        tabs.column(col).search(cont).draw();
                    }
                });
            <?php
            }
            if (in_array('Register Mobile', $cf)) {
            ?>
                $(document).on('keydown', '#registed_mobile', function(e) { // search data by invoice or datewise
                    var code = e.keyCode || e.which;
                    if (code === 9 || code == 13) {

                        var cont = $('#registed_mobile').val();
                        var col = $(this).data('id');
                        // console.log(col);
                        tabs.column(col).search(cont).draw();
                    }
                });
            <?php
            }
            if (in_array('Register Email', $cf)) {
            ?>
                $(document).on('keydown', '#register_email', function(e) { // search data by invoice or datewise
                    var code = e.keyCode || e.which;
                    if (code === 9 || code == 13) {

                        var cont = $('#register_email').val();
                        var col = $(this).data('id');
                        // console.log(col);
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
                $(document).on('keydown', '#mobile1', function(e) { // search data by invoice or datewise
                    var code = e.keyCode || e.which;
                    if (code === 9 || code == 13) {

                        var cont = $('#mobile1').val();
                        var col = $(this).data('id');
                        //console.log(col);
                        tabs.column(col).search(cont).draw();
                    }
                });
            <?php
            }
            if (in_array('Mobile No 2', $cof)) {
            ?>
                $(document).on('keydown', '#mobile2', function(e) { // search data by invoice or datewise
                    var code = e.keyCode || e.which;
                    if (code === 9 || code == 13) {

                        var cont = $('#mobile2').val();
                        var col = $(this).data('id');
                        // console.log(col);
                        tabs.column(col).search(cont).draw();
                    }
                });
            <?php
            }
            if (in_array('Mobile No 3', $cof)) {
            ?>
                $(document).on('keydown', '#mobile3', function(e) { // search data by invoice or datewise
                    var code = e.keyCode || e.which;
                    if (code === 9 || code == 13) {

                        var cont = $('#mobile3').val();
                        var col = $(this).data('id');
                        //  console.log(col);
                        tabs.column(col).search(cont).draw();
                    }
                });
            <?php
            }
            if (in_array('Phone No 1', $cof)) {
            ?>
                $(document).on('keydown', '#phone1', function(e) { // search data by invoice or datewise
                    var code = e.keyCode || e.which;
                    if (code === 9 || code == 13) {

                        var cont = $('#phone1').val();
                        var col = $(this).data('id');
                        //   console.log(col);
                        tabs.column(col).search(cont).draw();
                    }
                });
            <?php
            }
            if (in_array('Phone No 2', $cof)) {
            ?>
                $(document).on('keydown', '#phone2', function(e) { // search data by invoice or datewise
                    var code = e.keyCode || e.which;
                    if (code === 9 || code == 13) {

                        var cont = $('#phone2').val();
                        var col = $(this).data('id');
                        //  console.log(col);
                        tabs.column(col).search(cont).draw();
                    }
                });
            <?php
            }
            if (in_array('GSTN No', $cof)) {
            ?>
                $(document).on('keydown', '#gstin_no', function(e) { // search data by invoice or datewise
                    var code = e.keyCode || e.which;
                    if (code === 9 || code == 13) {

                        var cont = $('#gstin_no').val();
                        var col = $(this).data('id');
                        // console.log(col);
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
            if (in_array('Category', $pf)) {
            ?>
                $(document).on('change', '#category_id', function() { // search data by invoice or datewise

                    var cont = $('#category_id').val();
                    var col = $(this).data('id');
                    // console.log(col);
                    tabs.column(col).search(cont).draw();
                });
            <?php
            }
            if (in_array('Product', $pf)) {
            ?>
                $(document).on('change', '#si_product_id', function() { // search data by invoice or datewise

                    var cont = $('#si_product_id').val();
                    var col = $(this).data('id');
                    // console.log(col);
                    tabs.column(col).search(cont).draw();
                });
            <?php
            }
            if (in_array('Conversion Product', $pf)) {
            ?>
                $(document).on('change', '#si_conversion_product_id', function() { // search data by invoice or datewise

                    var cont = $('#si_conversion_product_id').val();
                    var col = $(this).data('id');
                    // console.log(col);
                    tabs.column(col).search(cont).draw();
                });
            <?php
            }
            if (in_array('Laptop', $pf)) {
            ?>
                $(document).on('change', '#laptop', function() { // search data by invoice or datewise

                    var cont = $('#laptop').val();
                    var col = $(this).data('id');
                    //  console.log(col);
                    tabs.column(col).search(cont).draw();
                });
            <?php
            }
            if (in_array('Register Type', $pf)) {
            ?>
                $(document).on('change', '#reg_type', function() { // search data by invoice or datewise

                    var cont = $('#reg_type').val();
                    var col = $(this).data('id');
                    // console.log(col);
                    tabs.column(col).search(cont).draw();
                });
            <?php
            }
            if (in_array('For Year', $pf)) {
            ?>
                $(document).on('change', '#si_for_year_id', function() { // search data by invoice or datewise

                    var cont = $('#si_for_year_id').val();
                    var col = $(this).data('id');
                    //console.log(col);
                    tabs.column(col).search(cont).draw();
                });
            <?php
            }
            if (in_array('Serial NO/HLock No', $pf)) {
            ?>
                $(document).on('keydown', '#searial_no', function(e) { // search data by invoice or datewise
                    var code = e.keyCode || e.which;
                    if (code === 9 || code == 13) {

                        var cont = $('#searial_no').val();
                        var col = $(this).data('id');
                        //  console.log(col);
                        tabs.column(col).search(cont).draw();
                    }
                });
            <?php
            }
            if (in_array('Activation Code', $pf)) {
            ?>
                $(document).on('keydown', '#activation_code', function(e) { // search data by invoice or datewise
                    var code = e.keyCode || e.which;
                    if (code === 9 || code == 13) {

                        var cont = $('#activation_code').val();
                        var col = $(this).data('id');
                        //  console.log(col);
                        tabs.column(col).search(cont).draw();
                    }
                });
            <?php
            }
            if (in_array('Purchase Date', $pf)) {
            ?>
                $(document).on('blur', '#purchase_date', function(e) { // search data by invoice or datewise
                    //                    var code = e.keyCode || e.which;
                    //                    if (code === 9 || code == 13) {
                    var cont = $('#purchase_date').val();
                    var col = $(this).data('id');
                    //  console.log(col);
                    // console.log(cont);
                    tabs.column(col).search(cont).draw();
                    //                    }
                });
            <?php
            }
            if (in_array('Renewal Date', $pf)) {
            ?>
                $(document).on('blur', '#last_renewal_date', function(e) { // search data by invoice or datewise
                    //                    var code = e.keyCode || e.which;
                    //                    if (code === 9 || code == 13) {
                    var cont = $('#last_renewal_date').val();
                    var col = $(this).data('id');
                    //  console.log(col);
                    tabs.column(col).search(cont).draw();
                    //                    }
                });
    <?php
            }
        }
    }
    ?>

    function DoSubmit() {
        var text_val = $(".editor-text").Editor("getText");
        $('#send_msg').val(text_val);
        return true;
    }

    // <!------------------Toggle ON OFF FULL Process Start -------------------------->
    function permit(id) {
        $.ajax({
            url: '<?php echo base_url('is_Permission_or_Not'); ?>',
            type: 'POST',
            data: {
                id: id
            },
            dataType: 'json',
            success: function(r) {
                if (r == 1) {
                    onoff(id, 1, 1);
                } else {
                    var by = $('#' + id + 'ed').attr('by');
                    if (!by) {
                        var by = "Someone ";
                    }
                    swal(
                        'Not Allowed !! ',
                        'This Client is currently Handling by ' + by.toUpperCase().fontcolor("Green") + ' ',
                        'info'
                    )

                    ///-------Recording logs
                    clicked_while(id);
                    ///-------Recording logs
                    return false;
                }
            }
        });
    }

    function ed(id) {
        $('#' + id + 'ed', '#' + id + 'ed1').removeAttr('style');
        $.ajax({
            url: '<?php echo base_url('is_Confirm_On_or_Off'); ?>',
            type: 'POST',
            data: {
                id: id
            },
            dataType: 'json',
            success: function(res) { //console.log(res);
                if (res == 1) {
                    permit(id);
                } else {
                    onoff(id, 0, 1);
                }
            },
            error: function() {
                alert("Something Went Wrong, Refresh The Page !! ");
            }
        });
    }

    function onoff(id, w, p) {
        $.ajax({
            url: '<?php echo base_url('Change_it_On_or_Off'); ?>',
            type: 'POST',
            data: {
                id: id,
                whatis: w
            },
            dataType: 'json',
            success: function(data) {
                if (w == 1 && p == 1) { //---this will off---
                    $('#' + id + 'ed').attr('style', 'background-color: rgb(255, 255, 255);border-color: rgb(223, 223, 223);box-shadow: rgb(223, 223, 223) 0px 0px 0px 0px inset;transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s;');
                    $('#' + id + 'ed1').attr('style', 'left: 0px; transition: background-color 0.4s ease 0s, left 0.2s ease 0s;');
                    $('#' + id + 'ed').attr({
                        hb: "",
                        by: "",
                        title: "Turn ON"
                    });
                    //--------------SweetAlert
                    swal({
                        title: "Successfully Turned Off ",
                        text: "This Client Handling is Completed !! ",
                        timer: 1516,
                        showConfirmButton: false,
                        type: "success"
                    }); //--------------SweetAlert 

                    ///-------Recording logs
                    insertLogs(id, 0);
                    ///-------Recording logs     
                } else if (w == 0) { //---this will on---

                    $('#' + id + 'ed').removeAttr('onclick');

                    $('#' + id + 'ed').attr('style', 'background-color: rgb(19, 218, 254);border-color: rgb(19, 218, 254);box-shadow: rgb(19, 218, 254) 0px 0px 0px 11px inset;transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s, background-color 1.2s ease 0s;');
                    $('#' + id + 'ed1').attr('style', 'left:13px;transition: background-color 0.4s ease 0s,left 0.2s ease 0s; background-color:rgb(255, 255, 255);');
                    $('#' + id + 'ed').attr('title', '<?php echo $this->session->userdata('name') ?>');
                    $('#' + id + 'ed').attr('by', '<?php echo $this->session->userdata('name') ?>');
                    $('#' + id + 'ed').attr('hb', '<?php echo $this->session->userdata('id') ?>');


                    setTimeout(function() {
                        $('#' + id + 'ed').attr('onclick', 'ed(' + id + ')');
                    }, 5000);

                    //--------------SweetAlert
                    swal({
                        title: 'Successfully Turned On ',
                        text: 'Selected Client is Handling by You !!',
                        type: 'success',
                        allowOutsideClick: false,
                    })
                    //--------------SweetAlert
                    ///-------Recording logs
                    insertLogs(id, 1);
                    ///-------Recording logs
                }
            },
            error: function() {
                alert("Something Went Wrong, Refresh The Page !! ");
            }
        });
    }

    function insertLogs(id, whattodo) {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url('CreateLogs'); ?>',
            data: {
                id: id,
                whattodo: whattodo
            },
            dataType: "json",
            success: function(data) {
                //------    
                /* if(data==0) {  $('#'+id+'ed').removeAttr('logs'); }
                else  {    $('#'+id+'ed').attr('logs',data);  }*/

            },
            error: function() {
                console.log("Something Went Wrong, Refresh The Page !! ");
            }
        });
    }

    function clicked_while(id) {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url('Clicked_While'); ?>',
            data: {
                id: id
            },
            dataType: "json",
            success: function(data) {
                //------    

            },
            error: function() {
                console.log("Something Went Wrong, Refresh The Page !! ");
            }
        });
    }
    //<!------------------Toggle ON OFF FULL Process END -------------------------->


    $("#sendEmail").submit(function(event) {
        event.preventDefault();
        var formData = new FormData($("#sendEmail")[0]);


        $.ajax({
            url: "<?php echo base_url("Client1/send_mail") ?>",
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                $('#mailModal').modal('hide');
                if (data == 1) {
                    alert("Sent Mail To Client Successfully !!!");
                } else {
                    alert("Not Sent Mail To Client !!!");
                }
            },
            error: function() {
                alert("Something Went Wrong !! ");
            }
        });
        return false;
    });

    
    $(document).on("click", "#product>tbody .client_info", function() {
        $("#clientDetail .modal-title").html('Customer Detail');
        $("#clientDetail .customer_info_li").html('<li>Customer detail is not available</li>');
        $("#clientDetail .address_info_li").html('<li>Customer address and contact details are not available</li>');
        $("#clientDetail .product_info_li").html('<li>Product detail is not available</li>');

        var id = $(this).data('id');
      
        $("#clientDetail").modal({
            backdrop: 'static',
            keyboard: false
        });
        $.ajax({
            url: "<?php echo base_url() . 'Client1/get_customer_details'; ?>",
            method: 'get',
            data: {'id': id},
            dataType: 'json',
            success: function (data) {
                $("#clientDetail .modal-title").html(data.title);
                $("#clientDetail .customer_info_li").html(data.customer_html);
                $("#clientDetail .address_info_li").html(data.address_html);
                $("#clientDetail .product_info_li").html(data.product_html);
            },
        });
    });
    //-----------------------------------
</script>

</html>