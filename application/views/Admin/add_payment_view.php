<html>
<head>
<?php $this->load->view('template/headerlink'); ?>
<style>
.w-left {
	float: left;
	width: 100%;
}
tfoot input {
	width: 100%;
	padding: 3px;
	box-sizing: border-box;
}
tfoot {
	display: table-header-group;
}
table#amount_table {
	border: 1px solid;
	padding: 10px;
	width: 100%;
	display: block;
	border-collapse: collapse;
	margin: 10px 0;
}
table#amount_table th {
	padding: 3px;
}
.form-group.w-left.p-d {
	display: flex;
	flex-wrap: nowrap;
	align-items: center;
}
.d-in-b {
	width: 25%;
}
.form-control.d-in-b {
	width: 75%;
	float: left;
}
table#lan_count_table {
	float: left;
	width: 100%;
	margin: 10px 0;
}
</style>
<link href="<?php echo base_url(); ?>assetss/css/editor.css" type="text/css" rel="stylesheet"/>
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
        <div id="errordiv1" class="alert <?php echo $this->session->flashdata('errorcls'); ?> alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <?php echo $this->session->flashdata('error'); ?> </div>
      </div>
      <?php
              endif;
       ?>
      <!-- ============================================================== --> 
      <!-- Different data Product --> 
      <!-- ============================================================== -->
      <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12"> <a href="<?php echo base_url() . 'Client'; ?>">
          <button class="btn btn-primary popovers" data-trigger="hover" data-placement="top" data-content="Back" style="float:right;margin-right: 5%;margin-top: 1%;"><i class="fa fa-hand-o-left"></i></button>
          </a>
          <div class="white-box">
            <header>
              <ul class="nav nav-tabs" id="myTab">
                <li ><a data-toggle="tab" href="#home" id="addnewclient">Add Payment Request</a></li>
              </ul>
            </header>
            <div class="tab-content"> 
              <!-------------------------------------------->
              <?php  if($this->session->userdata('id')==1 ){ ?>
              <form enctype="multipart/form-data" data-toggle="validator" class="clearfix" action="<?php echo base_url("Admin/TransactionsDetail/addData") ?>" method="post" id="formid">
               <?php } ?> <div class="row">
                  <div class="col-sm-4 col-sm-12">
                    <div class="white-box bg-white-dark optimize-box m-b-0">
                      <center>
                        <h3 class="box-title m-b-10">Client Details</h3>
                        <!--<p class="text-muted"> Enter below detail</p>-->
                      </center>
                      <div class="optimize-spacing">
                        <div class="form-group">
                          <div class="input-group">
                            <input type="text" class="form-control" id="contact_person" name="contact_person" required placeholder="Contact Person" value="<?php echo $contact['contact_person']; ?>" >
                            <input  type="hidden" name="si_clients_id" value="<?php echo $contact['si_clients_id']; ?>" id="hid" >
                            <div class="input-group-addon"><i class="fa fa-user"></i></div>
                          </div>
                        </div>
                        <p class="text-muted m-b-0 m-t-10">Firm (Company) Name</p>
                        <div class="form-group">
                          <div class="input-group">
                            <input type="text" class="form-control" id="firm_name" name="firm_name"  placeholder="Firm Name" value="<?php echo $contact['firm_name']; ?>">
                            <div class="input-group-addon"><i class="fa fa-building"></i></div>
                          </div>
                        </div>
                        <p class="text-muted m-b-0 m-t-10">Mobile Number</p>
                        <div class="form-group">
                          <div class="input-group">
                            <input type="text" class="form-control" id="registed_mobile" name="registed_mobile" required placeholder="Registered Mobile" value="<?php echo $contact['registed_mobile']; ?>" maxlength="10" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                            <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                          </div>
                        </div>
                        <p class="text-muted m-b-0 m-t-10">Email Address</p>
                        <div class="form-group">
                          <div class="input-group">
                            <input type="email" class="form-control" id="register_email" name="register_email" required value="<?php echo $contact['register_email']; ?>" placeholder="Register email">
                            <div class="input-group-addon"><i class="fa fa-envelope"></i></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4 col-sm-12">
                    <div class="white-box bg-white-dark optimize-box m-b-0">
                      <center>
                        <h3 class="box-title m-b-10">Address Details</h3>
                      </center>
                      <div class="optimize-spacing">
                        <div class="form-group">
                          <select class="form-control" id="si_state_id" required name="si_state_id">
                            <option value="0">Select State</option>
                            <?php
							 $selected_state_id = isset($contact['si_state_id']) ? $contact['si_state_id'] : 0;
                                        foreach ($states as $state) { 
										$whr ='';
											if($selected_state_id!=0) { 
													if($state['si_state_id']==$selected_state_id) { $whr = "selected";}
											}
                                        echo "<option value='" . $state['si_state_id'] . "'  ".$whr." >" . $state['name'] . "</option>";
                                        }
                              ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <div class="input-group">
                            <input type="text" class="form-control" id="city" name="city" required placeholder="City" value="<?php echo $contact['city']; ?>">
                            <div class="input-group-addon"><i class="fa fa-map-marker"></i></div>
                            <input type="text" class="form-control" id="pincode" name="pincode" required placeholder="Pin Code" value="<?php echo $contact['pincode']; ?>" maxlength="6" onkeypress='return event.charCode >= 48 && event.charCode <= 57' minlength="6">
                            <div class="input-group-addon"><i class="fa fa-map-marker"></i></div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="input-group">
                            <input type="text" class="form-control" id="area" name="area" required placeholder="Area" value="<?php echo $contact['area']; ?>">
                            <div class="input-group-addon"><i class="fa fa-map-marker"></i></div>
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
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4 col-sm-12">
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
                </div>
                
                <?php  if($this->session->userdata('id')==1 ){ ?>
                <hr style="margin-top:20px; border-color:black">
                <div class="row">
                <div class="col-sm-4 col-sm-12">
                  <div class="white-box bg-white-dark optimize-box m-b-0">
                    <center>
                      <h3 class="box-title m-b-10">Product Details</h3>
                    </center>
                    <div class="no-bg-addon row optimize-spacing">
                      <div class="form-group col-sm-6">
                        <select class="form-control vb56R78_uietEfJui9Cx" id="category_id" name="category_id[]" onChange="referbyshow(this.value)">
                          <option value="1" >Installation</option>
                          <option value="2" selected>Updatation</option>
                          <option value="3">Lan</option>
                          <option value="4">Conversion</option>
                        </select>
                      </div>
                      <script>function referbyshow(v){if(v==1) { $('#rfid').css('display','block'); } else {  $('#rfid').css('display','none'); }}</script>
                      <div class="form-group col-sm-6">
                        <select class="form-control txb93etmj_jst4fh" id="si_product_id"  required name="si_clients_details_id" required>
                        <option data-product_id="0" data-selling_price="0" data-purchase_price="0" value="">Product</option>
                        <?php
                             foreach ($product as $p_value) {
                                            echo "<option data-product_id='" . $p_value['product_id'] . "' data-selling_price='" . $p_value['sale_amount'] . "' data-purchase_price='" . $p_value['purchase_amount'] . "'  value='" . $p_value['si_clients_details_id'] . "'>" . $p_value['p_name'] . "</option>"; 
							 } ?>
                        </select>
                      </div>
                      <div class="form-group col-sm-12" id="rfid" style="display:none">
                        <select class="form-control" id="referby" name="referby">
                          <?php foreach ($admin as $a) { echo "<option value='" . $a['name'] . "' >Referred By -- " . $a['name'] . "</option>"; } ?>
                          <option value="Admin" style='color:red' selected>Referred By ( Default ) -- Admin</option>
                        </select>
                      </div>
                      <div class="form-group col-sm-6">
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
                      </div>
                      <div class="form-group col-sm-6">
                        <select class="form-control" id="reg_type" name="reg_type[]">
                          <option value="O">Online</option>
                          <option value="H">HLock</option>
                        </select>
                      </div>
                      <div class="form-group col-sm-6">
                        <select class="form-control" id="si_for_year_id"  required name="si_for_year_id[]">
                          <option value="">For Year</option>
                          <?php
                                                                        foreach ($for_year as $p_year) {
                                                                            if ($p_year['yearname'] == date("Y"))
                                                                                $ischecked = "selected";
                                                                            else
                                                                                $ischecked = "";
                                                                            echo "<option value='" . $p_year['si_for_year_id'] . "' $ischecked >" . $p_year['yearname'] . "</option>";
                                                                        }
                                                                        ?>
                        </select>
                      </div>
                      <div class="form-group col-sm-6"> 
                        <!--<select class="form-control" id="serial_no" name="serial_no"><option>Serial No/ HLock No</option></select>-->
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
                        <input class="form-control"   placeholder="Registered email" type="email" name="regemail" value="<?php echo $contact['register_email']; ?>" id="regemail">
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
                      <div class="form-group col-sm-12 checkbox checkbox-danger email-change">
                        <input id="changeemail" type="checkbox">
                        <label for="changeemail"> Change Email </label>
                      </div>
                      
                      <!-- <div class="form-group col-sm-12 checkbox checkbox-danger lan"><div class="pull-left"><input id="lan" type="checkbox"><label for="lan">UL</label></div><input class="form-control" id="total_lan" name="total_lan[]"  type="text" placeholder="Lan" value="0">
</div> --> 
                    </div>
                  </div>
                </div>
                <div class="col-sm-4 col-sm-12">
                  <div class="bg-white-dark clearfix">
                    <div class="white-box bg-white-dark optimize-box m-b-0">
                      <center>
                        <h3 class="box-title m-b-10">Amount Details</h3>
                      </center>
                      <div class="optimize-spacing">
                        <label class="text-muted m-b-0 m-t-10"> Lan Type</label>
                        <div class="form-group col-sm-12 checkbox checkbox-danger lan">
                          <div style="margin-bottom: 3px;">
                            <select class="form-control Dx6qwOP09_Sh45JynMkz" id="s_pc" name="s_pc[]">
                              <option value="0">Declaration Without Service</option>
                              <option value="1">Declaration With Service</option>
                              <option value="2">LAN</option>
                            </select>
                          </div>
                          <div class="row">
                            <div id="label_lan"> </div>
                            <div class="col-lg-6">
                              <input class="form-control VbtyJI_90rtDLO98rtddWE67sw" maxlength="2" id="total_lan" name="total_lan[]"  type="text" placeholder="No. of new lan" style="display:none" onKeyPress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57 || event.keyCode === 8;">
                            </div>
                            <div class="col-lg-6">
                              <input class="form-control" id="old_lan" name="old_lan"  type="text" placeholder="old lan" value="0" readonly>
                            </div>
                          </div>
                        </div>
                        
                        <!--div class="clearfix"> </div--> 
                        <br>
                        <div class="row three-parts-inline-input">
                          <div class="form-group col-sm-4"> </div>
                          <div class="ul-info col-sm-12 clearfix"  style="display:none">
                            <div class="form-group col-sm-6">
                              <label> UL Declaration Form </label>
                              <a href="<?= base_url("/assetss/pdf/LANDeclarationForm.pdf") ?>" class="btn btn-primary optimize-btn"  target="_blank">Download</a> </div>
                            <div class="form-group col-sm-6">
                              <label> Upload UL Form </label>
                              <div class="fileupload btn btn-warning optimize-btn"><span><i class="ion-upload m-r-5"></i>Upload</span>
                                <input type="file" class="upload">
                              </div>
                            </div>
                          </div>
                          <div class="email-info col-sm-12  clearfix" style="display:none">
                            <div class="form-group col-sm-6">
                              <label> Change Email Form </label>
                              <a href="<?= base_url("/assetss/pdf/RequestForEmailidChangeForm.pdf") ?>" class="btn btn-primary optimize-btn" target="_blank">Download</a> </div>
                            <div class="form-group col-sm-6">
                              <label> Upload Form </label>
                              <div class="fileupload btn btn-warning optimize-btn"><span><i class="ion-upload m-r-5"></i>Upload</span>
                                <input type="file" class="upload">
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="form-group col-sm-12 checkbox checkbox-danger ">
                        <p class="text-muted m-b-0 m-t-10"> Declaration Attachment File</p>
                          <div style="margin-bottom: 3px;">
                            <input type="file" name="declaration_attachment_file" id="declaration_attachment_file" accept="application/pdf">
                          </div>
                        </div>
                        
                        <div class="w-left m-b-5">
                          <div class="form-group checkbox checkbox-danger email-change bill-pay">
                            <input id="billpayment" name="isbill" value="1" type="checkbox">
                            <label for="billpayment"> Bill </label>
                          </div>
                          <div class="form-group billno" style="display: none;">
                            <div class="input-group">
                              <input class="form-control" id="billnumber" name="billnumber" placeholder="Bill Number" type="text">
                              <div class="input-group-addon"><i class="fa fa-building"></i></div>
                            </div>
                          </div>
                        </div>
                        <div class="w-left">
                          <div class="form-group checkbox checkbox-danger email-change bill-pay">
                            <input id="in_scheme" name="in_scheme" value="0" type="checkbox">
                            <label for="in_scheme"> Scheme </label>
                          </div>
                          <div class="form-group in_scheme" style="display: none;">
                            <div class="input-group">
                              <input class="form-control" id="in_scheme_comment" name="in_scheme_comment" placeholder="scheme reason" type="text">
                              <div class="input-group-addon"><i class="fa fa-building"></i></div>
                            </div>
                          </div>
                        </div>
                        
                        <!--- Table--- Start---Lan--->
                        <input type="hidden" value="0" name="lan_new_count_name" id="lan_new_count_id">
                        <input type="hidden" value="0" name="lan_product_id_value" id="lan_product_id_value">
                        <table id="lan_count_table">
                          <thead id="thead_lan_id">
                          </thead>
                          <tbody id="tbody_lan_count">
                          </tbody>
                        </table>
                        <!--- Table--- End----Lan----> 
                        
                        <!--p class="text-muted m-b-0 m-t-10">Amount</p--> 
                        <!--- Table--- Start---->
                        
                        <table id="amount_table" class="w-left">
                          <thead>
                            <tr>
                              <th>###</th>
                              <th>Sales Amount</th>
                              <th>Purchase Amount</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <th>LAN Amount</th>
                              <th><input class="form-control Cv56xp02_uMkolSEgTf7b" id="total_lan_amout" name="total_lan_amout[]"  type="text" placeholder="Amt." style="display:none" value="0"></th>
                              <th><input class="form-control TYnj45fg_rtER456jkcRti9rdg" id="total_lan_cost_amout" name="total_lan_cost_amount[]"  type="text" placeholder="Purchase Amt." style="display:none" value="0" readonly></th>
                            </tr>
                            <tr>
                              <th>Product Amount</th>
                              <th><input class="form-control OPrt56bbft_erYTHL89frt_rtSEr5s" id="amount" required name="amount" placeholder="Sale Amount" type="text" value="0"></th>
                              <th><input class="form-control Ym67Ssfrt45_UUKDEFFhju_78ftse" id="costamount" required name="costamount" placeholder="Purchase Amount" type="text" value="0" readonly></th>
                            </tr>
                            <tr>
                              <th>Tax Amount</th>
                              <input id="tax_hidden" name="tax" type="hidden">
                              <th><input class="form-control" id="tax" required name="tax" placeholder="Sale Tax Amount" type="text" value="0"></th>
                              <th><input class="form-control YU6734Njd_ik8ERw21Vgtm98Aq" id="tax_purchase" required name="tax_purchase" placeholder="Purchase Tax Amount" type="text" value="0" readonly></th>
                            </tr>
                            <tr>
                              <th>Grand Total Amount</th>
                              <th><input class="form-control" id="sale_grand_total_amount" required name="sale_grand_total_amount" placeholder="Sale Grand Amount" type="text" value="0"></th>
                              <th><input class="form-control uXer45987_weDBy233DDerjiukjAW" id="purchase_grand_total_amount" required name="purchase_grand_total_amount" placeholder="Purchase Grand Amount" type="text" value="0" readonly></th>
                            </tr>
                          <br>
                          <tr>
                            <th><button type="button" id="bDxtb5hYh6_R4CnhYkx" class="btn btn-sm btn-primary">Calculate Amount</button></th>
                            <th></th>
                            <th><button type="button" id="f56hjgjTH_yrsw32HBGUas" class="btn btn-xs btn-info pull-right" onClick="edit_amount_readonly(1);" title="Edit Amount"><i class="fa fa-edit"></i></button></th>
                          </tr>
                          </tbody>
                          
                        </table>
                        
                        <!--- Table--- End----> 
                        
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-4 col-sm-12">
                  <div class="white-box bg-white-dark optimize-box m-b-0">
                    <div class="optimize-spacing">
                      <center>
                        <h3 class="box-title m-b-10">Payment Details</h3>
                      </center>
                      <div class="form-group checkbox checkbox-danger email-change p-l-0">
                        <input id="paymentdue" name="paymentdue" value="1" type="checkbox">
                        <label for="paymentdue"> Payment Due</label>
                      </div>
                      <div class="form-group paymentdue">
                        <div class="input-group">
                          <input class="form-control" id="deposit_bank"  name="deposit_bank" placeholder="Deposit Bank Name" type="text">
                          <div class="input-group-addon"><i class="fa fa-asterisk"></i></div>
                        </div>
                      </div>
                      <div class=" form-group checkbox checkbox-primary email-change p-l-0 w-left">
                        <input name="offre_cash" id="offre_cash1"  value="1" type="checkbox">
                        <label for="offre_cash1"> Offer </label>
                      </div>
                      <div class="form-group  w-left p-d">
                        <div class="d-in-b"> Transaction Date</div>
                        <input class="form-control mydatepicker d-in-b" id="transaction_date" required name="transaction_date" placeholder="Transaction Date" type="text">
                      </div>
                      <div class="bank-transfers paymentdue clearfix w-left">
                        <div class="checkbox-tags clearfix">
                          <div class="checkbox checkbox-primary email-change p-l-0">
                            <input name="payment_type[]" id="Bank"  value="Bank" type="checkbox">
                            <label for="Bank"> Bank </label>
                          </div>
                          <div class="checkbox checkbox-info email-change">
                            <input name="payment_type[]" id="Online"  value="Online" type="checkbox">
                            <label for="Online"> Online </label>
                          </div>
                          <div class="checkbox checkbox-success email-change">
                            <input name="payment_type[]" id="Cash" value="Cash" type="checkbox">
                            <label for="Cash"> Cash </label>
                          </div>
                        </div>
                        <div class="form-group bank" style="display: none;">
                          <div class="input-group three-parts">
                            <input class="form-control" id="bank_name" name="bank_name" placeholder="Bank Name" type="text">
                            <input class="form-control" id="cheque" name="cheque" placeholder="Cheque Number" type="text">
                            <input class="form-control" id="bank_amount" name="bank_amount" value="0" placeholder="Bank Amount" type="text">
                          </div>
                        </div>
                        <div class="two-parts">
                          <div class="form-group online" style="display: none;">
                            <div class="input-group">
                              <input class="form-control" id="online_amount" value="0" name="online_amount" placeholder="Online Amount" type="text">
                              <input class="form-control" id="online-transaction" name="online_transaction" placeholder="Online Transaction" type="text">
                            </div>
                          </div>
                          <div class="form-group cash" style="display: none;">
                            <div class="input-group">
                              <input class="form-control" id="cash_amount" name="cash_amount" value="0" placeholder="Cash Amount" type="text">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="input-group">
                          <textarea class="form-control" id="billremarks" name="billremarks" rows="5" placeholder="Remarks"></textarea>
                          <div class="input-group-addon"><i class="fa  fa-star"></i></div>
                        </div>
                      </div>
                      <div class="form-group col-sm-12 m-t-10">
                        <button type="reset" class="btn btn-danger waves-effect waves-light m-l-10 pull-right" id="reset">Cancel</button>
                        <button id="submit_id" type="submit" class="btn btn-success waves-effect waves-light pull-right">Submit</button>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
            <?php } ?>
            <!-------------------------------------------->
            <hr style="margin-top:20px; border-color:black">
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
                          <th>Session</th>
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

<!-- Modal --> 

<!-- ============================================================== --> 
<!-- End Page Content --> 
<!-- ============================================================== --> 
<!--main content end -->
</div>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-xs"> 
    <!-- Modal content--> 
    <!--<form method="post" onsubmit="javascript:addCustomerSolution();" action="<?php echo base_url("Client/CustomerSolution"); ?>" >-->
    <form method="post" id="myform" action="<?php echo base_url("Admin/TransactionsDetail/AddTransDet"); ?>" >
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Product Payment</h4>
        </div>
        <div class="modal-body clearfix">
          <div class="row">
            <div class="col-sm-12 col-sm-12">
              <div class="bg-white-dark clearfix">
                <div class="col-sm-12 col-sm-12 p-0">
                  <div class="white-box bg-white-dark optimize-box m-b-0 clearfix" style="padding: 0px 12px 5px;">
                    <div class="optimize-spacing">
                      <p class="text-muted m-b-0 m-t-10">Product</p>
                      <div class="form-group">
                        <select class="form-control" id="si_product_id-edit"  required name="si_clients_details_id" required>
                        </select>
                        <input  type="hidden" name="si_clients_id" value="<?php echo $contact['si_clients_id']; ?>" id="hid" >
                        <input  type="hidden" name="hid" id="tid" >
                      </div>
                      <p class="text-muted m-b-0 m-t-10">Session</p>
                      <div class="form-group">
                        <select class="form-control" id="si_for_year_id-edit"  required name="si_for_year_id[]">
                          <option value="">For Year</option>
                          <?php
                                                    foreach ($for_year as $p_year) {
                                                        if ($p_year['yearname'] == date("Y"))
                                                            $ischecked = "selected";
                                                        else
                                                            $ischecked = "";
                                                        echo "<option value='" . $p_year['si_for_year_id'] . "' $ischecked >" . $p_year['yearname'] . "</option>";
                                                    }
                                                    ?>
                        </select>
                      </div>
                      <p class="text-muted m-b-0 m-t-10">Amount</p>
                      <div class="form-group">
                        <div class="input-group">
                          <input class="form-control" id="amount-edit" required name="amount" placeholder="Amount" type="text">
                          <div class="input-group-addon"><i class="fa fa-asterisk"></i></div>
                        </div>
                      </div>
                      <p class="text-muted m-b-0 m-t-10">Cost</p>
                      <div class="form-group">
                        <div class="input-group">
                          <input class="form-control" id="costamount-edit" required name="costamount" placeholder="Purchase Amount" type="text">
                          <div class="input-group-addon"><i class="fa fa-asterisk"></i></div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="input-group">
                          <input class="form-control mydatepicker" id="transaction_date-edit" required name="transaction_date" placeholder="Transaction Date" type="text">
                          <div class="input-group-addon"><i class="fa fa-asterisk"></i></div>
                        </div>
                      </div>
                      <p class="text-muted m-b-0 m-t-10">Lan Amount</p>
                      <div class="form-group">
                        <div class="input-group">
                          <input class="form-control" id="total_lan_amout-edit" name="total_lan_amout[]"  type="text" placeholder="Lan" value="0">
                        </div>
                      </div>
                      <p class="text-muted m-b-0 m-t-10">Cost Amount</p>
                      <div class="form-group">
                        <div class="input-group">
                          <input class="form-control" id="total_lan_cost_amout-edit" name="total_lan_cost_amount[]"  type="text" placeholder="Lan" value="0">
                        </div>
                      </div>
                      <p class="text-muted m-b-0 m-t-10">Tax Amount</p>
                      <div class="form-group">
                        <div class="input-group">
                          <input class="form-control" id="tax_amount-edit" name="tax_amount[]"  type="text" placeholder="Tax Amount" value="0">
                        </div>
                      </div>
                      <div class="form-group checkbox checkbox-danger email-change email-change p-l-0">
                        <input id="paymentdue-edit" name="paymentdue" value="1" type="checkbox">
                        <label for="paymentdue-edit"> Payment Due</label>
                      </div>
                      <div class="form-group paymentdue-edit">
                        <p class="text-muted m-b-0 m-t-10">Deposit Bank</p>
                        <div class="input-group">
                          <input class="form-control" id="deposit_bank-edit" 
                                                           name="deposit_bank" placeholder="Deposit Bank" type="text">
                          <div class="input-group-addon"><i class="fa fa-asterisk"></i></div>
                        </div>
                      </div>
                      <div class="bank-transfers paymentdue-edit clearfix">
                        <div class="checkbox-tags clearfix">
                          <div class="checkbox checkbox-primary email-change p-l-0">
                            <input name="payment_type[]" id="Bank-edit"  value="Bank" type="checkbox">
                            <label for="Bank-edit"> Bank </label>
                          </div>
                          <div class="checkbox checkbox-info email-change">
                            <input name="payment_type[]" id="Online-edit"  value="Online" type="checkbox">
                            <label for="Online-edit"> Online </label>
                          </div>
                          <div class="checkbox checkbox-success email-change">
                            <input name="payment_type[]" id="Cash-edit" value="Cash" type="checkbox">
                            <label for="Cash-edit"> Cash </label>
                          </div>
                        </div>
                        <div class="form-group bank-edit" style="display: none;">
                          <div class="input-group three-parts">
                            <input class="form-control" id="bank_name-edit" name="bank_name" placeholder="Bank Name" type="text">
                            <input class="form-control" id="cheque-edit" name="cheque" placeholder="Cheque" type="text">
                            <input class="form-control" id="bank_amount-edit" name="bank_amount" value="0" placeholder="Bank Amount" type="text">
                          </div>
                        </div>
                        <div class="two-parts">
                          <div class="form-group online-edit" style="display: none;">
                            <div class="input-group">
                              <input class="form-control" id="online_amount-edit" value="0" name="online_amount" placeholder="Online Amount" type="text">
                              <input class="form-control" id="online-transaction-edit" name="online_transaction" placeholder="Online Transaction" type="text">
                            </div>
                          </div>
                          <div class="form-group cash-edit" style="display: none;">
                            <div class="input-group">
                              <input class="form-control" id="cash_amount-edit" value="0" name="cash_amount" placeholder="Cash Amount" type="text">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group checkbox checkbox-danger email-change bill-pay">
                        <input id="billpayment-edit" name="isbill" value="1" type="checkbox">
                        <label for="billpayment-edit"> Bill </label>
                      </div>
                      <div class="form-group billno-edit" style="display: none;">
                        <div class="input-group">
                          <input class="form-control" id="billnumber-edit" name="billnumber" placeholder="Bill No" type="text">
                          <div class="input-group-addon"><i class="fa fa-building"></i></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12 col-sm-12 p-0">
                  <div class="white-box bg-white-dark optimize-box m-b-0">
                    <div class="optimize-spacing">
                      <div class="form-group">
                        <div class="input-group">
                          <textarea class="form-control" id="billremarks-edit" name="billremarks" rows="5" placeholder="Remarks"></textarea>
                          <div class="input-group-addon"><i class="fa  fa-star"></i></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group ">
                  <?php  if($this->session->userdata('id')==1 ){ ?>
                  <button type="submit" class="btn btn-success waves-effect waves-light pull-right">Submit</button> <?php } ?>
                  <button type="button" class="btn btn-inverse waves-effect waves-light pull-right" data-dismiss="modal">Close</button>
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
            <input type="text" class="form-control" id="send_from" name="send_from" required="" >
          </div>
          <div class="form-group col-sm-4">
            <label for="send_to">To:</label>
            <input type="text" class="form-control" id="send_to" name="send_to" required="" >
          </div>
          <div class="form-group col-sm-4">
            <label for="send_sub">Subject:</label>
            <input type="text" class="form-control" id="send_sub" name="send_sub" required="" >
          </div>
          <div class="form-group col-sm-12 clearfix">
            <label for="send_msg">Message:</label>
            <!-- <textarea class="form-control" id="send_msg" rows="7" name="send_msg"></textarea> -->
            <textarea class="editormail-text" name="sai_mail_msg" id="send_msg"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-inverse waves-effect waves-light" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success waves-effect waves-light m-r-10"  >Submit</button>
          <!--<button type="button" class="btn btn-inverse waves-effect waves-light" data-dismiss="modal">Close</button>--> 
        </div>
      </div>
    </form>
  </div>
</div>
<!-- js placed at the end of the document so the pages load faster -->
<?php $this->load->view('template/footerlink'); ?>
<script type="text/javascript" src="<?php echo base_url(); ?>assetss/js/myowncustom.min.js"></script> 
<script src="<?php echo base_url(); ?>assetss/js/editor.js"></script> 
<!-- Editable
 <script src="<?php /*echo base_url(); ?>assetss/js/custom.min.js"></script>
<script src="<?php echo base_url(); ?>assetss/plugins/bower_components/jsgrid/db.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assetss/plugins/bower_components/jsgrid/dist/jsgrid.min.js"></script>
<script src="<?php echo base_url();*/ ?>assetss/js/jsgrid-init.js"></script> --> 
<!--Style Switcher -->

</body>

<script>

    var base_url = '<?php echo base_url()?>';
    var tbl = 'si_clients';
    $(document).ready(function () {
        $("#submit").click(function () {

            var product = $('#si_clients_details_id');
            if (product.val() === '0') {
                alert("Please select a Product and then proceed.");
                //$('#selBooks').focus();
                return false;
            } else
                return;
        });
        $(".editormail-text").Editor();                
    });
            
    $('#myTab a[href="#home"]').tab('show');
	
    $('.mydatepicker, #datepicker').datepicker({format: 'dd-mm-yyyy', todayHighlight: true });

    $('#c_id').change(function () {
        if (!this.checked)
            $('#conversion').fadeOut('slow');
        else
            $('#conversion').fadeIn('slow');
    });
    $('#Bank').change(function () {
        if ($(this).prop("checked")) {
            $('.bank').show();
        } else {
            $('.bank').hide();
        }
    });
    $('#Bank-edit').change(function () {
        if ($(this).prop("checked")) {
            $('.bank-edit').show();
        } else {
            $('.bank-edit').hide();
        }
    });
    $('#Cash').change(function () {
        if ($(this).prop("checked")) {
            $('.cash').show();
        } else {
            $('.cash').hide();
        }
    });
    $('#Cash-edit').change(function () {
        if ($(this).prop("checked")) {
            $('.cash-edit').show();
        } else {
            $('.cash-edit').hide();
        }
    });
    $('#Online').change(function () {
        if ($(this).prop("checked")) {
            $('.online').show();
        } else {
            $('.online').hide();
        }
    });
    $('#Online-edit').change(function () {
        if ($(this).prop("checked")) {
            $('.online-edit').show();
        } else {
            $('.online-edit').hide();
        }
    });
	$('#in_scheme').change(function () {
        if ($(this).prop("checked")) {
            $('.in_scheme').show()
        } else {
            $('.in_scheme').hide()
        }
    });
    $('#billpayment-edit').change(function () {
        if ($(this).prop("checked")) {
            $('.billno-edit').show()
        } else {
            $('.billno-edit').hide()
        }
    });
    $('#paymentdue').change(function () {
        if ($(this).prop("checked")) {
            $('.paymentdue').hide()
        } else {
            $('.paymentdue').show()
        }
    });
    $('#paymentdue-edit').change(function () {
        if ($(this).prop("checked")) {
            $('.paymentdue-edit').hide()
        } else {
            $('.paymentdue-edit').show()
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
        var s_id = $('#hid').val();
        var rid = $("#dynOrderRow").data('id');
        //console.log('id : '+ id+'rid : '+rid);
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
            TreeTable(id, s_id);
        }
    });
    $("#productdetail>tbody").on("click", ".view", function () {
        var p_id = $(this).data('id');
        var p_name = $(this).data('p_name');
        $('#tid').val('');
        $("#myModal").modal({backdrop: 'static', keyboard: false});
        $('#si_product_id-edit').find('option').remove();
        $('#si_product_id-edit').append($("<option></option>").attr("value", p_id).text(p_name));

        $('#amount-edit').val('');
        $('#costamount-edit').val('');
        $('#transaction_date-edit').val('');
        $('#total_lan_amout-edit').val('');
        $('#total_lan_cost_amout-edit').val('');
        $('#tax_amount-edit').val('');              $('#Bank-edit').removeAttr("checked");
        $('.bank-edit').hide();
        $('#Online-edit').removeAttr("checked");
        $('.online-edit').hide();
        $('#Cash-edit').removeAttr("checked");
        $('.cash-edit').hide();
        $('#online_amount-edit').val('');
        $('#online-transaction-edit').val('');
        $('#cash_amount-edit').val('');
        $('#bank_name-edit').val('');
        $('#cheque-edit').val('');
        $('#bank_amount-edit').val('');
        $('#deposit_bank-edit').val('');
        $('#billnumber-edit').val('');
        $('#billremarks-edit').val('');
        CustomerSolutionDataTable($(this).data('id'));

    });
    $("#productdetail>tbody").on("click", ".dlt", function () {
        var p_id = $(this).data('id');
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
                data: {'id': p_id, 'status': st, 'tbl': detailtbl},
                url: '<?php echo base_url('Helper/change_status'); ?>',
                dataType: 'json',
                success: function (data) {
                    if (data == 1) {
                        swal(
                                'Successfully!',
                                'Selected Product has been ' + title + '.',
                                'success'
                                )

                        //tabs1.ajax.params({'id':hid});                          tabs1.draw();
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
        });
    });
    $("#productdetail>tbody").on("click", ".t_edit", function () {
        var t_id = $(this).data('id');
        $("#myModal").modal({backdrop: 'static', keyboard: false});
        $('#si_product_id-edit').find('option').remove();
        $.ajax({
            type: 'post',
            data: {'id': t_id, 'tbl': 'si_transactions_detail'},
            url: '<?php echo base_url('Helper/GetEditData'); ?>',
            dataType: 'json',
            success: function (data) {
                console.log(data);
                $('#tid').val(data.si_transactions_detail_id);
                $('#si_product_id-edit').find('option').remove();
                $('#si_product_id-edit').append($("<option></option>").attr("value", data.si_clients_details_id).text(data.p_name));
                //$('#'+data.payment_type).val(data.payment_type);

                //$('input[name=payment_type]:checked', '#ff').val(data.payment_type);
                $('#amount-edit').val(data.amount);
                $('#costamount-edit').val(data.costamount);
                $('#transaction_date-edit').val(data.transaction_date);
                $('#total_lan_amout-edit').val(data.lan_amount);
                $('#tax_amount-edit').val(data.taxamount);
                $('#total_lan_cost_amout-edit').val(data.total_lan_cost_amount);
                if (data.paymentdue == 1) {
                    $('#paymentdue-edit').attr("checked", "checked");
                    $('.paymentdue-edit').hide()
                } else {
                    $('.paymentdue-edit').show()
                    $('#paymentdue-edit').removeAttr("checked");
                    if (data.payment_type != null) {
                        var splitString = data.payment_type.split(',');
                        var bankFound = false;
                        for (var i = 0; i < splitString.length; i++) {
                            var stringPart = splitString[i];
                            if (stringPart != 'Bank')
                                continue;
                            bankFound = true;
                            break;
                        }
                        var OnlineFound = false;
                        for (var i = 0; i < splitString.length; i++) {
                            var stringPart = splitString[i];
                            if (stringPart != 'Online')
                                continue;
                            OnlineFound = true;
                            break;
                        }
                        var CashFound = false;
                        for (var i = 0; i < splitString.length; i++) {
                            var stringPart = splitString[i];
                            if (stringPart != 'Cash')
                                continue;
                            CashFound = true;
                            break;
                        }
                        console.log('bankFound'+bankFound+'OnlineFound'+OnlineFound+'CashFound'+CashFound)
                        if (bankFound == true)
                        {
                            $('#Bank-edit').attr("checked", "checked");
                            $('.bank-edit').show();
                        }
                        if (OnlineFound == true)
                        {
                            $('#Online-edit').attr("checked", "checked");
                            $('.online-edit').show();
                        }
                        if (CashFound == true)
                        {
                            $('#Cash-edit').attr("checked", "checked");
                            $('.cash-edit').show();
                        }
                    }
                }
                $('#online_amount-edit').val(data.online_amount);
                $('#online-transaction-edit').val(data.online_transaction);
                $('#cash_amount-edit').val(data.cash_amount);
                $('#bank_name-edit').val(data.bank_name);
                $('#cheque-edit').val(data.cheque);
                $('#bank_amount-edit').val(data.bank_amount);
                $('#deposit_bank-edit').val(data.deposit_bank);
                if (data.is_bill == 1)
                {
                    $('#billpayment-edit').attr("checked", "checked");
                    $('.billno-edit').show()
                }
                $('#si_clients_id-edit').val(data.si_clients_id).attr("selected", "selected");
                $('#billnumber-edit').val(data.billnumber);
                $('#billremarks-edit').val(data.billremarks);
            }
        });


        /*$('#si_product_id-edit')
         .append($("<option></option>")
         .attr("value", p_id)
         .text(p_name));*/
        //CustomerSolutionDataTable($(this).data('id'));
    });
    function CustomerSolutionDataTable(id) {
        $('#customersolution').DataTable().destroy();
        var tabs1 = $('#customersolution').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [[1, "desc"]],
            "ajax": {
                "url": "<?php echo base_url() . 'Client/getCustomerSolution'; ?>",
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
    // View Table In Tree Start
    function TreeTable(id, s_id) {

        $("#hiddenRowId").val(id);
        $("#dynOrderRow").remove();
        $.ajax({
            url: "<?php echo base_url() . 'Admin/TransactionsDetail/get_product_all_purchese' ?>",
            data: {'id': id, 's_id': s_id},
            method: 'post',
            dataType: 'html',
            success: function (data) {
                //  console.log(data);
                if (data.length > 0) {
                    $('#Rows_id' + id).after('');
                    $('#Rows_id' + id).after(data);
                } else {
                    //$("#Rows_id" + id).remove();
                }
            }
        });
    }
    $('#si_product_id').change(function () {
        get_product_det();
		lan_dropdown_maintain();
		
    });
	
    function get_product_det() {
        if ($('#category_id').val() != "1") {
            var id = $('#hid').val();
            var p_id = $('#si_product_id').find(":selected").val();
			
            if (p_id == '' || id == '' || p_id == 0)
            {
                swal(
                        'Cancelled',
                        'you have not select product  :)',
                        'error'
                        );
				return false;
            }
			
            $.ajax({
                type: 'post',
                data: {'id': id, 'p_id': p_id},
                url: '<?php echo base_url('Admin/TransactionsDetail/get_product_data'); ?>',
                dataType: 'json',
                success: function (data) {
                    if(data==1){return false;}                           
                    $('#si_conversion_product_id').val(data[0].si_conversion_product_id);
                    $('#laptop').val(data[0].laptop);
                    $('#reg_type').val(data[0].reg_type);
                    //$('#si_for_year_id').val(data[0].yearname);
					$('#searial_no').val(data[0].serial_no);
                    $('#activation_code').val(data[0].activation_code);
                    $('#purchase_date').val(data[0].purchase_date);
                    var myDate = new Date(data[0].renewal_date);
                    myDate.setFullYear(myDate.getFullYear() + 1);
                    $('#last_renewal_date').val(myDate.getDate() + "-" + (myDate.getMonth() + 1) + "-" + myDate.getFullYear());
                    if (data[0].p_email != null) {
                        $('#regemail').val(data[0].p_email);
                    }
                    $('#s_pc').val(data[0].lan_type);
                    $("#total_lan").val(data[0].total_lan);
					$("#total_lan").val(0);
                    $("#old_lan").val(data[0].total_lan);
					
                    if (data[0].lan_type == 1 || data[0].lan_type == 2) {
                        $("#total_lan").show();
                        $("#label_lan").show();
                        $("#lable_lan_amout").show();
                        $("#lable_lan_cost_amout").show();
                        $("#total_lan_amout").show();
                        $("#total_lan_cost_amout").show();
                    } else {
                        $("#total_lan").hide();
                        $("#total_lan_amout").hide();
                        $("#total_lan_cost_amout").hide();
                        $("#label_lan").hide();
                        $("#lable_lan_amout").hide();
                        $("#lable_lan_cost_amout").hide();
                    }
					
                }
            });
        }
    }

    $('#category_id').change(function () { change_product_con(); delete_lan_table();  });

    function change_product_con() {
        var id = $('#hid').val();
		var category_id = $('#category_id').val();
		
        if (category_id=="1" && id) {
            $.ajax({
                type: 'post',
                data: {'all_p': 'All' , 'category_id' : category_id },
                url: '<?php echo base_url('Admin/Client/get_conversion_data'); ?>',
                dataType: 'json',
                success: function (data) {
                    $('#si_product_id').find('option').remove();
                    $('#si_product_id').append($("<option></option>").attr("value", 0).text('Selected Product'));
					
                    $.each(data.product, function (key, value) {
                        $('#si_product_id').append($("<option></option>").attr("value", value.si_product_id).attr("data-product_id", value.si_product_id).attr("data-selling_price", value.sale_amount).attr("data-purchase_amount", value.purchase_amount).text(value.p_name));
                    });
					
                    $('.form-group select[id="si_conversion_product_id"]').val('0');
                    $('.form-group select[id="reg_type"]').val('O');
                    $('.form-group select[id="si_for_year_id"]').val('0');
                    $('.form-group input[id="searial_no"]').val('');
                    $('.form-group input[id="activation_code"]').val('');
                    $('.form-group input[id="purchase_date"]').val('');
                    $('.form-group input[id="last_renewal_date"]').val('');
                    $('.form-group select[id="s_pc"]').val('0');
                    $("#total_lan").hide();
                    $("#total_lan_amout").hide();
                    $("#total_lan_cost_amout").hide();
                    $("#label_lan").hide();
                    $("#lable_lan_amout").hide();
                    $("#lable_lan_cost_amout").hide();
                    $('#total_lan').val('0');
                    $('#total_lan_amout').val('0');
                    $("#total_lan_cost_amout").val('0');
                    $('#total_lan').removeAttr("readonly");
                }
            });
        }
        if (category_id=="2" || category_id=="3" || category_id=="4") {
            var id = $('#hid').val();
            $.ajax({
                type: 'post',
                data: {'id': id, 'tbl': tbl , 'category_id' : category_id},
                url: '<?php echo base_url('Admin/TransactionsDetail/get_client_edit_data'); ?>',
                dataType: 'json',
                success: function (data) {
                    $('#si_product_id').find('option').remove();
                    $('#si_product_id').append($("<option></option>").attr("value", 0).text('Selected Product'));
					
                    $.each(data.product, function (key, value) {
                        $('#si_product_id').append($("<option></option>").attr("value", value.si_clients_details_id).attr("data-product_id", value.si_product_id).attr("data-selling_price", value.sale_amount).attr("data-purchase_amount", value.purchase_amount).text(value.p_name));
                    });
                }
            });


            if (category_id=="4")
            {
                $.ajax({
                    type: 'post',
                    data: {'all_p': 'All', 'category_id' : category_id},
                    url: '<?php echo base_url('Admin/Client/get_conversion_data'); ?>',
                    dataType: 'json',
                    success: function (data) {
                        $('#si_conversion_product_id').find('option').remove();
                        $('#si_conversion_product_id').append($("<option></option>").attr("value", 0).text('Selected Product'));
                        $.each(data.product, function (key, value) {
                            $('#si_conversion_product_id').append($("<option></option>").attr("value", value.si_product_id).attr("data-product_id", value.si_product_id).attr("data-selling_price", value.sale_amount).attr("data-purchase_amount", value.purchase_amount).text(value.p_name));
                        });
                    }
                });
            } else
            {
                $('#si_conversion_product_id').find('option').remove();
                $('#si_conversion_product_id').append($("<option></option>").attr("value", 0).text('Conversion Product'));
            }
        } else {
            $.ajax({
                type: 'post',
                data: {'all_p': 'All', 'category_id' : category_id},
                url: '<?php echo base_url('Admin/Client/get_conversion_data'); ?>',
                dataType: 'json',
                success: function (data) {
                    $('#si_product_id').find('option').remove();
                    $('#si_product_id').append($("<option></option>").attr("value", 0).text('Selected Product'));
                    $.each(data.product, function (key, value) {
                        $('#si_product_id').append($("<option></option>").attr("value", value.si_product_id).attr("data-product_id", value.si_product_id).attr("data-selling_price", value.sale_amount).attr("data-purchase_amount", value.purchase_amount).text(value.p_name));
                    });
                    $('.form-group select[id="si_conversion_product_id"]').val('0');
                    $('.form-group select[id="reg_type"]').val('O');
                    $('.form-group select[id="si_for_year_id"]').val('0');
                    $('.form-group input[id="searial_no"]').val('');
                    $('.form-group input[id="activation_code"]').val('');
                    $('.form-group input[id="purchase_date"]').val('');
                    $('.form-group input[id="last_renewal_date"]').val('');
                    $('.form-group select[id="s_pc"]').val('0');
                    $("#total_lan").hide();
                    $("#total_lan_amout").hide();
                    $("#total_lan_cost_amout").hide();
                    $("#label_lan").hide();
                    $("#lable_lan_amout").hide();
                    $('#total_lan').val('0');
                    $('#total_lan_amout').val('0');
                    $("#total_lan_cost_amout").val('0');
                    $('#total_lan').removeAttr("readonly");
                }
            });
        }
    }
	
    $("#s_pc").change(function () {
		$("#total_lan,#total_lan_amout,#total_lan_cost_amout").val(0);
        if ($(this).val() == 1 || $(this).val() == 2) {
            $("#total_lan").show();
            $("#label_lan").show();
            $("#lable_lan_amout").show();
            $("#lable_lan_cost_amout").show();
            $("#total_lan_amout").show();
            $("#total_lan_cost_amout").show();
        }  else {
            $("#total_lan").hide();
            $("#total_lan_amout").hide();
            $("#total_lan_cost_amout").hide();
            $("#label_lan").hide();
            $("#lable_lan_amout").hide();
            $("#lable_lan_cost_amout").hide();
        }
		delete_lan_table();
		cal_allx();
 });
	
    $('#changeemail').change(function () {
        if ($(this).prop("checked")) {
            $('.email-info').show();
        } else {
            $('.email-info').hide();
        }
    });
    function DoSubmit(){  
       var text_val= $(".editormail-text").Editor("getText");
       $('#send_msg').val(text_val);
        return true;
        }
    $("#productdetail>tbody").on("click", ".mail", function () {
        var id=$(this).data('id'); 
        var st = $(this).data('status');        
        var isst = $(this).data('isstatus'); 
        var srno = $(this).data('serial');        
        if(isst=='D')
        {
            swal(
                        'Deactivate',
                        'Contact to Admin  :)',
                        'error'
                        );
        }
        else
        {
        $('#send_from').val('genius.surat@gmail.com');
        $('#send_to').val($(this).data('mailid'));
        $('#send_sub').val('GENIUS RENEWAL : A.Y. 2022-23. BANK DETAILS : SAI INFOTECH SURAT SrNo: '+ srno);
        $('#send_msg').val(' <p>Dear Sir,</p><p>Greetings For the day.</p><p>We are Thanking you to Choose our Software and Services.</p><p>Please find below details for Genius Software Renewal.</p><p>Please feel free to call us if any issues.</p><p>Amount -</p><p> You Can Also Pay Online With Payment Gateway via below link & For UPI Payment Scan the Bar Code Attached Or Pay On (9328394945@upi).</p><p><a href="https://saiinfotech.co/Shoppingcart">https://saiinfotech.co/Shoppingcart</a> </p><p>Please Send Payment receipt in <a href="mailto:genius.surat@gmail.com" target="_blank">genius.surat@gmail.com</a> to Complete your Activation Process.</p><p>Thanks</p><p>SAI Infotech, Surat</p><p>Supports - 0261-2369109 ( 12 Lines )</p><p>Sales - 0261-4897600 ( 6 Lines )</p><p style="text-decoration: underline;">BANK DETAIL </p><table style="border-collapse: separate; width: 500px; border: 1px solid black;"><tr><td style="padding: 3px; border: 1px solid black;">Account Name</td><td style="padding: 3px; border: 1px solid black;">SAI INFOTECH</td></tr><tr><td style="padding: 3px; border: 1px solid black;">Bank Name</td><td style="padding: 3px; border: 1px solid black;">INDUSIND Bank Ltd</td></tr><tr><td style="padding: 3px; border: 1px solid black;">Branch</td><td style="padding: 3px; border: 1px solid black;">Empire Estate Branch, Surat</td></tr><tr><td style="padding: 3px; border: 1px solid black;">Account Number</td><td style="padding: 3px; border: 1px solid black;">200999038453</td></tr><tr><td style="padding: 3px; border: 1px solid black;">IFSC Code</td><td style="padding: 3px; border: 1px solid black;">INDB0000023</td></tr><tr><td style="padding: 3px; border: 1px solid black;">Account Type</td><td style="padding: 3px; border: 1px solid black;">Current Account</td></tr></table><div><div dir="ltr"><br><img src="https://www.saiinfotech.co/assets/images/UPI_FINAL.JPG" width="452" height="224"><br><b>Thanks&nbsp;&amp; Regards..<br><?php echo $_SESSION['name']; ?></b><br><br><font face="tahoma, sans-serif"><font style="font-size:large" color="#000000"><b><img src="https://saiinfotech.co/assets/images/sai-logo.jpg" width="96" height="40" class="CToWUd">&nbsp;|<a href="http://www.saiinfotech.co" target="_blank" data-saferedirecturl="https://www.google.com/url?q=http://www.saiinfotech.co&amp;source=gmail&amp;ust=1553084931912000&amp;usg=AFQjCNGYRSyT6NKUCkUwByh0jqpYwS2qbA">www.saiinfotech.co</a></b></font></font></div><div dir="ltr"><font color="#000000" size="1" face="verdana, sans-serif"><b style="background-color:rgb(255,255,255)"><br></b></font></div><div dir="ltr"><font size="2"><font color="#000000" face="verdana, sans-serif"><b style="background-color:rgb(255,255,255)">Address:-&nbsp;</b></font><font face="tahoma, sans-serif"><font color="#000000">105-106, Ajanta Shopping Centre,&nbsp;</font><span style="color:rgb(0,0,0)">Nr. Kinnary Cinema,&nbsp;</span>Ring Road,&nbsp;SURAT : 395002</font></font></div><div dir="ltr"><div><div><font size="2"><font style="font-family:verdana,sans-serif" color="#000000"><strong>Sales&nbsp; &nbsp; &nbsp;:-</strong> </font><font face="tahoma, sans-serif"><font color="#000000">0</font>93283 94945 | 0261-4897600 (6 Lines)</font></font></div><div><font size="2"><font face="verdana, sans-serif"><font color="#000000"><strong>Support :-&nbsp;</strong></font></font><font face="tahoma, sans-serif">0261 2369109&nbsp;(12 LINES) |&nbsp;93777 94945 |&nbsp;94278 94946 | 93285 94945</font><span style="font-family:verdana,sans-serif">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</span></font></div><div><font size="2"><font style="font-family:verdana,sans-serif" color="#000000"><strong>E-Mail &nbsp; &nbsp;:-</strong></font><span style="font-family:verdana,sans-serif">&nbsp;</span><font face="tahoma, sans-serif"><a href="mailto:genius.surat@gmail.com" target="_blank">genius.surat@gmail.com</a><b>&nbsp;| </b><a href="mailto:sales@saiinfotech.co" target="_blank">sales@saiinfotech.co</a></font></font><br></div><div><br><font color="#bf9000" size="4" face="georgia, serif">Be Genius.... Use Genius....</font><div class="yj6qo"></div><div class="adL"><br><br><br><br></div></div></div></div></div>');
        $(".editormail-text").Editor("setText",' <p>Dear Sir,</p><p>Greetings For the day.</p><p>We are Thanking you to Choose our Software and Services.</p><p>Please find below details for Genius Software Renewal.</p><p>Please feel free to call us if any issues.</p><p>Amount -</p><p> You Can Also Pay Online With Payment Gateway via below link & For UPI Payment Scan the Bar Code Attached Or Pay On (9328394945@upi).</p><p><a href="https://saiinfotech.co/Shoppingcart">https://saiinfotech.co/Shoppingcart</a> </p><p>Please Send Payment receipt in <a href="mailto:genius.surat@gmail.com" target="_blank">genius.surat@gmail.com</a> to Complete your Activation Process.</p><p>Thanks</p><p>SAI Infotech, Surat</p><p>Supports - 0261-2369109 ( 12 Lines )</p><p>Sales - 0261-4897600 ( 6 Lines )</p><p style="text-decoration: underline;">BANK DETAIL </p><table style="border-collapse: separate; width: 500px; border: 1px solid black;"><tr><td style="padding: 3px; border: 1px solid black;">Account Name</td><td style="padding: 3px; border: 1px solid black;">SAI INFOTECH</td></tr><tr><td style="padding: 3px; border: 1px solid black;">Bank Name</td><td style="padding: 3px; border: 1px solid black;">INDUSIND Bank Ltd</td></tr><tr><td style="padding: 3px; border: 1px solid black;">Branch</td><td style="padding: 3px; border: 1px solid black;">Empire Estate Branch, Surat</td></tr><tr><td style="padding: 3px; border: 1px solid black;">Account Number</td><td style="padding: 3px; border: 1px solid black;">200999038453</td></tr><tr><td style="padding: 3px; border: 1px solid black;">IFSC Code</td><td style="padding: 3px; border: 1px solid black;">INDB0000023</td></tr><tr><td style="padding: 3px; border: 1px solid black;">Account Type</td><td style="padding: 3px; border: 1px solid black;">Current Account</td></tr></table><div><div dir="ltr"><br><img src="https://www.saiinfotech.co/assets/images/UPI_FINAL.JPG" width="452" height="224"><br><b>Thanks&nbsp;&amp; Regards..<br><?php echo $_SESSION['name']; ?></b><br><br><font face="tahoma, sans-serif"><font style="font-size:large" color="#000000"><b><img src="https://saiinfotech.co/assets/images/sai-logo.jpg" width="96" height="40" class="CToWUd">&nbsp;|<a href="http://www.saiinfotech.co" target="_blank" data-saferedirecturl="https://www.google.com/url?q=http://www.saiinfotech.co&amp;source=gmail&amp;ust=1553084931912000&amp;usg=AFQjCNGYRSyT6NKUCkUwByh0jqpYwS2qbA">www.saiinfotech.co</a></b></font></font></div><div dir="ltr"><font color="#000000" size="1" face="verdana, sans-serif"><b style="background-color:rgb(255,255,255)"><br></b></font></div><div dir="ltr"><font size="2"><font color="#000000" face="verdana, sans-serif"><b style="background-color:rgb(255,255,255)">Address:-&nbsp;</b></font><font face="tahoma, sans-serif"><font color="#000000">105-106, Ajanta Shopping Centre,&nbsp;</font><span style="color:rgb(0,0,0)">Nr. Kinnary Cinema,&nbsp;</span>Ring Road,&nbsp;SURAT : 395002</font></font></div><div dir="ltr"><div><div><font size="2"><font style="font-family:verdana,sans-serif" color="#000000"><strong>Sales&nbsp; &nbsp; &nbsp;:-</strong> </font><font face="tahoma, sans-serif"><font color="#000000">0</font>93283 94945 | 0261-4897600 (6 Lines)</font></font></div><div><font size="2"><font face="verdana, sans-serif"><font color="#000000"><strong>Support :-&nbsp;</strong></font></font><font face="tahoma, sans-serif">0261 2369109&nbsp;(12 LINES) |&nbsp;93777 94945 |&nbsp;94278 94946 | 93285 94945</font><span style="font-family:verdana,sans-serif">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</span></font></div><div><font size="2"><font style="font-family:verdana,sans-serif" color="#000000"><strong>E-Mail &nbsp; &nbsp;:-</strong></font><span style="font-family:verdana,sans-serif">&nbsp;</span><font face="tahoma, sans-serif"><a href="mailto:genius.surat@gmail.com" target="_blank">genius.surat@gmail.com</a><b>&nbsp;| </b><a href="mailto:sales@saiinfotech.co" target="_blank">sales@saiinfotech.co</a></font></font><br></div><div><br><font color="#bf9000" size="4" face="georgia, serif">Be Genius.... Use Genius....</font><div class="yj6qo"></div><div class="adL"><br><br><br><br></div></div></div></div></div>');
        $("#mailModal").modal({backdrop: 'static', keyboard: false});
        /*$.ajax({
            url: "<?php echo base_url() . 'Client/send_mail'; ?>",
            method: 'post',
            data: {'tbl': 'send_mail', 'sai_mail_to': $('send_to').val(),'sai_mail_from':$('send_from').val(),'sai_mail_sub':$('send_sub').val(),'sai_mail_msg':$('send_msg').val()},
            dataType: 'json',
            success: function (data) {
               console.log(data);
            },
        });*/
        }
    });
    $("#sendEmail").submit(function (event) { event.preventDefault();
                var formData = new FormData($("#sendEmail")[0]);  
                $.ajax({
                  url: "<?php echo base_url("Client/send_mail")?>", 
                  type: 'POST',
                      data: formData,
                      contentType: false,
                      processData: false,
                  success: function (data) 
                      {   
                  $('#mailModal').modal('hide');
                  if(data==1) 
                  {
                    alert("Sent Mail To Client Successfully !!!");
                  }
                  else
                  {
                    alert("Not Sent Mail To Client !!!");
                  }
                   },
            error: function(){  alert("Something Went Wrong !! "); }
                  });
              return false;
      });
</script>
</html>