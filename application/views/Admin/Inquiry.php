<html>
<head>
<?php $this->load->view('template/headerlink'); ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assetss/plugins/bower_components/switchery/dist/switchery.min.css" rel="stylesheet" /> 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" />
<style>
tfoot input {
  width: 100%;
  padding: 3px;
  box-sizing: border-box;
}
tfoot {
  display: table-header-group;
}
.box-shdow {
  border-radius: 0;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.19);
}
.radiox-input-wrap {
  float: left;
  margin-left: 10px;
  display: none;
  width: inherit;
}
.radio-input-wrappers {
  float: left;
}
.inquiry-status > .radio {
  clear: both;
  display: inline-block;
  margin: 0;
}
</style>
</head>
<?php  if($this->session->flashdata('flashmsg')!='') { ?>
<div class="myadmin-alert myadmin-alert-icon myadmin-alert-click alert-success myadmin-alert-bottom alertbottom" style="display: block;"><i class="fa fa-phone"></i><?php echo $this->session->flashdata('flashmsg'); ?><a href="#" class="closed">×</a></div>
<?php } ?>

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
  <input type="hidden" id="numm">
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
      <?php endif; ?>
      <!-- ============================================================== --> 
      <!-- Different data Product --> 
      <!-- ============================================================== -->
      <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">
          <div class="white-box">
            <header>
              <ul class="nav nav-tabs" id="myTab">
                <li onClick="RES();" class="active"><a data-toggle="tab" href="#view" >View All </a></li>
                <li onClick="RES();"><a data-toggle="tab" href="#addinquiry" onClick="$('#edit_li').hide();"> Add Inquiry <i class="fa fa-plus"></i></a></li>
                <li id="edit_li"><a data-toggle="tab" href="#add"> Edit Inquiry <i class="fa fa-edit"></i> </a></li>
                <?php  if ($this->session->userdata('role') == "SA") { ?>
                <li onClick="Pending();RES();" ><a data-toggle="tab" href="#pending" >Pending Inquiries</a></li>
                <li onClick="Completed();RES();"><a data-toggle="tab" href="#completed" >Completed Inquiries</a></li>
                <?php } ?>
              </ul>
            </header>
            <div class="tab-content">
              <div id="view" class="tab-pane fade in active">
                <div class="panel">
                  <div class="panel-heading">
                    <div class="row">
                      <form action="<?php echo base_url().'Admin/Inquiry/get_inquiry_report';?>">
                      <div class="form-group col-sm-2 ">
                        <p>Inquiries </p>
                        <select class="form-control " id="select_inq" name="select_inq">
                          <option value="Pending" selected >Pending Inquiries</option>
                          <option value="Completed"  >Completed Inquiries</option>
                          <option value="L"  >Low_Interest Inquiries</option>
                          <option value="All"   >All Inquiries</option>
                        </select>
                      </div>
                      <div class="form-group col-sm-2 ">
                        <p>DateFrom</p>
                        <input type="text" name="datefrom" id="datefrom"class="rangedate form-control mydatepicker" value="<?php $dv = strtotime("-123 day"); echo date('d-m-Y',$dv); ?>">
                      </div>
                      <div class="form-group col-sm-2 ">
                        <p>DateTo </p>
                        <input class="rangedate form-control mydatepicker" id="dateto" name="dateto" value="<?php echo date('t-m-Y'); ?>">
                      </div>
                      <div class="form-group col-sm-2 "> 
                       <p>&nbsp; </p> 
                       <input type="submit" class="form-control pull-left" id="GetData" name="excel" style="background-color: #2ca958;" value="Excel Export">
                      </div>
                    </form>
                      <div class="form-group col-sm-2 ">
                        <p>&nbsp; </p>
                        <button type="button" class="btn btn-info" id="check" name="check"  title="Check" onClick="mydata(0);"><i class="fa fa-check fa-2x"></i> </button>
                      </div>

                      <div class="form-group col-sm-2 pull-right">
                        <p>&nbsp; </p>
                          <button type="button" id="sms_id" class="btn btn-info" onClick="send_multi_sms();">Send Bulk SMS</button>
                       </div>

                    </div>
                  </div>
                  <div class="table-responsive">
                    <table id="inquirytbl" class="table table-striped table-bordered manage-u-table optimize-table">
                      <!----    table table-striped table-bordered manage-u-table optimize-table      ---->
                      <thead>
                        <tr>
                          <th width="70" class="text-center"> # &nbsp <input type="checkbox" id="selectAllid" onClick="selectAll(this)"></th>
                          <th width="250">Inquiry / Firm Name</th>
                          <th width="120">Mobile No.</th>
                          <th width="250"> Ref By. </th>
                          <th width="250">City</th>
                          <th width="250">Product</th>
                          <th width="250">Inquiry By</th>
                          <th width="250">Status Of Completion</th>
                          <th width="250"><button type="button" id="today" value="A" class="btn btn-default" onClick="Today()" 
                          style="color:blue; background-color:#FFF; border:hidden">
                          <b style="color:black">Options <i class="fa fa-sort"></i></button></b></th>
                          <th width="250">Generated Date</th>
                          <th style="width:90px;">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                      <tfoot>
                        <tr>
                          <th width="70" class="text-center"></th>
                          <th width="250"></th>
                          <th width="250"></th>
                          <th width="250"></th>
                          <th width="250"></th>
                          <th width="250"></th>
                          <th width="250"></th>
                          <th width="250"></th>
                          <th style="width:90px;"></th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
              <div id="addinquiry" class="tab-pane fade in ">
                <div class="panel">
                  <div  class="panel-heading">Add Request</div>
                  <form id="addData_Inquiry" data-toggle="validator" class="clearfix" action="<?php echo base_url("Admin/Inquiry/addData_Inquiry") ?>" method="post" >
                    <input type="hidden" name="selected_list"   id="selected_list" value="">
                    <div class="col-sm-5">
                      <div class="white-box bg-white-dark optimize-box m-b-0">
                        <div class="row optimize-spacing clearfix">
                          <div class="form-group has-error col-sm-12">
                            <center>
                              <h3 class="box-title m-b-10">INQUIRY MASTER AND FOLLOW UP SHEET [ ADD ]</h3>
                            </center>
                          </div>

                           <!---Existing User ------------------->
                <div class="form-group col-sm-12" id="div21a" title="Fill Data from Existing Customer (ON / OFF)" >
                        <span  id='chkk' what='1' onclick='fun21()' class='switchery switchery-small' 
      style='background-color: rgb(19, 218, 254);border-color: rgb(19, 218, 254);box-shadow: rgb(19, 218, 254) 0px 0px 0px 11px inset;transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s, background-color 1.2s ease 0s;'>
      <small id='chkk1' 
      style='left:13px;transition: background-color 0.4s ease 0s,left 0.2s ease 0s; background-color:rgb(255, 255, 255);'></small></span> <b id="b12">Turn Off</b> &nbsp; You can Fill Data from Existing Customers !! 
          </div>
                          <div class="form-group col-sm-12" id="div21b">
                        <!----------  Select 2 -------->
           <select id="selUser"><option value=""></option></select>
              <!----------  Select 2 --------> 
                        </div>
                          <script type="text/javascript">
                            function fun21() {
                              var w = $('#chkk').attr('what');
      if(w==0) { //THIS WILL ON
    $('#chkk').attr('style','background-color: rgb(19, 218, 254);border-color: rgb(19, 218, 254);box-shadow: rgb(19, 218, 254) 0px 0px 0px 11px inset;transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s, background-color 1.2s ease 0s;');
    $('#chkk1').attr('style','left:13px;transition: background-color 0.4s ease 0s,left 0.2s ease 0s; background-color:rgb(255, 255, 255);');
    $('#chkk').attr('what',1); $('#div21b').show();  $('#b12').html('Turn OFF'); 
    
    }  else { //THIS WILL Off

  $('#chkk').attr('style','background-color: rgb(255, 255, 255);border-color: rgb(223, 223, 223);box-shadow: rgb(223, 223, 223) 0px 0px 0px 0px inset;transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s;');
  $('#chkk1').attr('style','left: 0px; transition: background-color 0.4s ease 0s, left 0.2s ease 0s;');
  $('#chkk').attr('what',0); $('#div21b').hide(); $('#b12').html('Turn ON');  
               }

                        }

                          </script>
                         
                          <!---Existing User ------------------->

                          <hr class="full-width">
                         


                          <div class="form-group has-error col-sm-12" title="Today Date in Inquiry Date is set by Default">
                            <div class="input-group">
                              <input class="form-control mydatepicker" onBlur="b_iq1(this.value);b_iq(this.value);" onChange="b_iq(this.value)" readonly="" name="inquiry_date_a" id="inquiry_date_a" placeholder="Inquiry Date"
                               type="text" value="<?php echo date('Y-m-d')?>" required   >
                              <div class="input-group-addon">Inquiry Date <i class="fa fa-calendar"></i> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b id="b_iq"> </b></div>
                            </div>
                          </div>
                          <script>
                          function b_iq(v){ 
               ddmmyy=moment(v).format("DD-MMMM-YYYY");
              $("#b_iq").html(ddmmyy);  }
              function b_iq1(v){
                var regexDate=/([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))/;
                if (regexDate.test(v) == false)  { $("#inquiry_date_a").val("<?php echo date('Y-m-d')?>");
                $("#b_iq").val("<?php echo date('d-F-Y')?>");  return false;}
              }
                          </script>
                            

                          <div class="form-group col-sm-12">
                            <div class="input-group">
                              <input class="form-control" name="inquiry_firmname_a" id="inquiry_firmname_a" placeholder="Firm Name" type="text" >
                              <div class="input-group-addon">Firm Name <i class="fa fa-user"></i></div>
                            </div>
                          </div>
                          <div class="form-group col-sm-12">
                            <div class="input-group">
                              <input class="form-control" name="inquiry_name_a" id="inquiry_name_a" placeholder="Customer Name / Contact Person" type="text" required>
                              <div class="input-group-addon">Customer Name <i class="fa fa-user"></i></div>
                            </div>
                          </div>
                          <div class="form-group col-sm-12">
                            <div class="input-group">
                              <input class="form-control" name="inquiry_email_a" id="inquiry_email_a" placeholder="Customer Email Address" type="email" >
                              <div class="input-group-addon">Customer Email <i class="fa fa-envelope"></i></div>
                            </div>
                          </div>
                          <div class="form-group col-sm-12">
                            <div class="input-group">
                              <input class="form-control" name="inquiry_gstno_a" id="inquiry_gstno_a" placeholder="GST Number" type="text" >
                              <div class="input-group-addon">GST Number </div>
                            </div>
                          </div>
                        
                          <!---------multi number ------------------->
                          
                          <div class="form-group col-sm-9">
                            <div class="input-group">
                              <input class="form-control" name="inquiry_mobile_a" id="inquiry_mobile_a"  placeholder="Mobile / Landline Number" type="text" required>
                              <div class="input-group-addon">Mobile / Landline Number <i class="fa fa-mobile"></i></div>
                            </div>
                          </div>
                          <div class="form-group col-sm-3" id="af_div">
                              <div class="input-group">
                                <input type="button" title="You Can Add upto Five Contact Number" class="btn btn-info btn-outline" onClick="addnum();" value=" + Add Number">
                              </div>
                            </div>
                            
                            
                          <script type="text/javascript">
                            function addnum()  {  var nn = $('.ZYOCISW').length
                  if(nn==5){ alert("You can add maximum 5 Numbers"); return false }
                  else {
                  var nm=nn+1;
                  var r_str = "";  //var s = "abc4def1gh7ijk9l0mn8op3qrstu2vw5x6yz";
                  var s = "123456789987654321";
                 for (var i = 0; i < 10; i++) { r_str += s.charAt(Math.floor(Math.random() * s.length)); }  console.log(r_str);
                 
                html='<div class="ZYOCISW aa'+r_str+' form-group col-sm-9"><div class="input-group"><input class="form-control" name="iq_mob'+nm+'" id="iq_mob'+nm+'" placeholder="Mobile / Landline Number" type="text" required><div class="input-group-addon">Mobile / Landline Number <i class="fa fa-mobile"></i></div></div></div><div class="aa'+r_str+' form-group col-sm-3"><div class="input-group"><input type="button" class="btn btn-danger btn-outline" onClick="removenum('+r_str+');" value=" - Remove This"></div></div>';
              $('#af_div').after(html); 
              
                  }
              }
              
          function removenum(r_str){  $('.aa'+r_str).remove(); }
                            
                            </script>
                          
                            <!---------multi number ------------------->
                          <hr class="full-width">
                          <div class="form-group col-sm-12"> SELECT PRODUCT
                            <select class="js-example-basic-multiple " name="product_list" id="product_list"  multiple="multiple" required>
                              <option></option>
                              <?php  foreach ($product as $p) { 
                                                                        echo "<option value='" . $p['si_product_id'] . "' >" . $p['p_name'] . "</option>";
                                                                         }    ?>
                            </select>
                          </div>
                          <div class="form-group col-sm-12">
                            <div class="input-group">
                              <input class="form-control" placeholder="Interest Product % (number only)" name="interest_product_a" id="interest_product_a" maxlength="2"  type="text">
                              <div class="input-group-addon">Interest Product <i class="fa fa-percent"></i></div>
                            </div>
                          </div>
                          <div class="form-group col-sm-12">
                            <div class="input-group">
                              <input class="form-control" placeholder="Discount Offer ( optional )" name="discount_offer_a" id="discount_offer_a"  type="text">
                              <div class="input-group-addon">Discount Offer <i class="fa fa-percent"></i></div>
                            </div>
                          </div>
                          
                          <!------- Multi ------->
                          
                          <hr class="full-width">
                          <div class="form-group col-sm-12">
                            <div class="input-group">
                              <textarea class="form-control" name="inquiry_address_a" id="inquiry_address_a" rows="3" placeholder="Address" required></textarea>
                              <div class="input-group-addon">Address <i class="fa  fa-location-arrow"></i></div>
                            </div>
                          </div>
                          <div class="form-group col-sm-6">
                            <select class="form-control" name="inquiry_state_a" id="si_state_id_a" required >
                              <option value="">Select State</option>
                              <?php foreach ($states as $state) {
                                                                        echo "<option value='" . $state['si_state_id'] . "'>" . $state['name'] . "</option>";
                                                                         } ?>
                            </select>
                          </div>
                          <div class="form-group col-sm-6">
                            <div class="input-group">
                              <input class="form-control" name="inquiry_city_a" id="inquiry_city_a" placeholder="City" maxlength="25" minlength="3" required>
                              <div class="input-group-addon">City <i class="fa  fa-location-arrow"></i></div>
                            </div>
                          </div>
                          <hr class="full-width">
                          <div class="form-group col-sm-6">
                            <div class="input-group">
                              <input class="form-control" placeholder="Other Mobile Number" maxlength="10" minlength="10" name="inquiry_other_no_a" id="inquiry_other_no_a" type="text">
                              <div class="input-group-addon"><i class="fa fa-mobile"></i></div>
                            </div>
                          </div>
                          <div class="form-group col-sm-6">
                            <div class="input-group">
                              <input class="form-control" name="inquiry_ref_by_a" id="inquiry_ref_by_a" placeholder="Ref. By" type="text">
                              <div class="input-group-addon"><i class="fa fa-building"></i></div>
                            </div>
                          </div>
                          <div class="form-group col-sm-12">
                            <div class="input-group">
                              <textarea class="form-control" name="remark_a" id="remark_a" rows="2" placeholder="Remark / Comment"></textarea>
                              <div class="input-group-addon"><i class="fa fa-comment"></i></div>
                            </div>
                          </div>
                          <hr class="full-width">
                          <div class="form-group col-sm-12 text-right">
                            <button type="reset" class="btn btn-danger btn-lg" >Reset</button>
                            &nbsp;
                            <button type="submit" id="submit_btn"  class="btn btn-success btn-lg"   >Submit</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <div id="add" class="tab-pane fade">
                <div class="panel">
                  <div id="panelupdate" class="panel-heading">Update Request</div>
                  <form id="add_edit_formid" data-toggle="validator" class="edit_form clearfix" action="<?php echo base_url("Admin/Inquiry/updateData_inquiry") ?>" method="post" >
                    <input type="hidden" name="selected_list_e"  id="selected_list_e" value="">
                    <input type="hidden" name="hid" id="hid">
                    <div class="col-sm-5">
                      <div class="white-box bg-white-dark optimize-box m-b-0">
                        <div class="optimize-spacing clearfix">
                          <div class="col-sm-12">
                            <center>
                              <h3 class="box-title m-b-10">INQUIRY MASTER AND FOLLOW UP SHEET [ UPDATE ]</h3>
                            </center>
                            <div class="white-box bg-white-dark optimize-box m-b-0">
                              <div class="row optimize-spacing clearfix">
                                <hr class="full-width">
                                <div class="form-group has-error col-sm-12">
                                  <div class="input-group">
                                    <input class="form-control mydatepicker" readonly="" name="inquiry_date" id="inquiry_date" placeholder="Inquiry Date" type="text" required>
                                    <div class="input-group-addon">Inquiry Date <i class="fa fa-calendar"></i></div>
                                  </div>
                                </div>
                                <div class="form-group col-sm-12">
                                  <div class="input-group">
                                    <input class="form-control"  name="inquiry_firmname" id="inquiry_firmname"  placeholder="Firm Name" type="text" >
                                    <div class="input-group-addon">Firm Name <i class="fa fa-user"></i></div>
                                  </div>
                                </div>
                                <div class="form-group col-sm-12">
                                  <div class="input-group">
                                    <input class="form-control" name="inquiry_name" id="inquiry_name"  placeholder="Customer Name / Contact Person" type="text" required>
                                    <div class="input-group-addon">Customer Name <i class="fa fa-user"></i></div>
                                  </div>
                                </div>
                                <div class="form-group col-sm-12">
                            <div class="input-group">
                              <input class="form-control" name="inquiry_email" id="inquiry_email" placeholder="Customer Email Address" type="email" >
                              <div class="input-group-addon">Customer Email <i class="fa fa-envelope"></i></div>
                            </div>
                          </div>
                                <div class="form-group col-sm-12">
                                  <div class="input-group">
                                    <input class="form-control" name="inquiry_gstno" id="inquiry_gstno" placeholder="GST Number" type="text" >
                                    <div class="input-group-addon">GST Number </div>
                                  </div>
                                </div>
                                <div class="form-group col-sm-9">
                                  <div class="input-group">
                                    <input class="form-control" name="inquiry_mobile" id="inquiry_mobile" placeholder="Mobile / Landline Number" type="text" required>
                                    <div class="input-group-addon">Mobile / Landline Number <i class="fa fa-mobile"></i></div>
                                  </div>
                                </div>
                                
                          <div class="form-group col-sm-3" id="af_div_e">
                              <div class="input-group">
                                <input type="button" class="btn btn-info btn-outline" title="You Can Add upto Five Contact Number" onClick="addnum_e();" value=" + Add Number">
                              </div>
                            </div>
                            
                                <hr class="full-width">
                                <!------- Multi ------->
                                <div class="form-group col-sm-12"> SELECT PRODUCT
                                  <select class="js-example-basic-multiple" name="product_list_e" id="product_list_e"  multiple="multiple" required>
                                    <?php foreach ($product as $p) {
                                                                        echo "<option value='" . $p['si_product_id'] . "' >" . $p['p_name'] . "</option>";
                                                                           } ?>
                                  </select>
                                </div>
                                <div class="form-group col-sm-12">
                                  <div class="input-group">
                                    <input class="form-control" placeholder="Interest Product % (number only)" name="interest_product" id="interest_product" maxlength="2"  type="text">
                                    <div class="input-group-addon">Interest Product <i class="fa fa-percent"></i></div>
                                  </div>
                                </div>
                                <div class="form-group col-sm-12">
                            <div class="input-group">
                              <input class="form-control" placeholder="Discount Offer ( optional )" name="discount_offer" id="discount_offer"  type="text">
                              <div class="input-group-addon">Discount Offer <i class="fa fa-percent"></i></div>
                            </div>
                          </div>
                                <!------- Multi ------->
                                <hr class="full-width">
                                <div class="form-group col-sm-12">
                                  <div class="input-group">
                                    <textarea class="form-control" name="inquiry_address" id="inquiry_address" rows="3" placeholder="Address" required></textarea>
                                    <div class="input-group-addon">Address <i class="fa  fa-location-arrow"></i></div>
                                  </div>
                                </div>
                                <div class="form-group col-sm-6">
                                  <select class="form-control" name="inquiry_state" id="si_state_id" required>
                                    <option value="">Select State</option>
                                    <?php foreach ($states as $state) {
                                                                        echo "<option value='" . $state['si_state_id'] . "'>" . $state['name'] . "</option>";
                                                                         } ?>
                                  </select>
                                </div>
                                <div class="form-group col-sm-6">
                                  <div class="input-group">
                                    <input class="form-control" name="inquiry_city" id="inquiry_city" placeholder="City" required>
                                    <div class="input-group-addon">City <i class="fa  fa-location-arrow"></i></div>
                                  </div>
                                </div>
                                <hr class="full-width">
                                <div class="form-group col-sm-6">
                                  <div class="input-group">
                                    <input class="form-control" placeholder="Other Mobile Number" name="inquiry_other_no" id="inquiry_other_no" type="text">
                                    <div class="input-group-addon"><i class="fa fa-mobile"></i></div>
                                  </div>
                                </div>
                                <div class="form-group col-sm-6">
                                  <div class="input-group">
                                    <input class="form-control" name="inquiry_ref_by" id="inquiry_ref_by" placeholder="Ref. By" type="text">
                                    <div class="input-group-addon"><i class="fa fa-building"></i></div>
                                  </div>
                                </div>
                                <div class="form-group col-sm-12">
                                  <div class="input-group">
                                    <textarea class="form-control" name="remark" id="remark" rows="3" placeholder="Remark / Comment"></textarea>
                                    <div class="input-group-addon"><i class="fa fa-comment"></i></div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-12">
                            <div class="white-box bg-white-dark optimize-box m-b-0">
                              <div class="row optimize-spacing clearfix">
                                <div class="form-group col-sm-12 inquiry-status"> <strong>Inquiry Status : &nbsp; &nbsp; &nbsp;</strong>
                                  <div class="radio radio-warning">
                                    <input type="radio" name="inquiry_completion_status"  value="P">
                                    <label for="radio14" onClick="tickP();"> Pending  &nbsp; &nbsp; &nbsp; </label>
                                  </div>
                                  <div class="radio radio-warning">
                                    <input type="radio" name="inquiry_completion_status"  value="C">
                                    <label for="radio15"  onClick="tickC();"> Completed &nbsp; &nbsp; &nbsp; </label>
                                  </div>
                                  <div class="radio radio-warning">
                                    <input type="radio" name="inquiry_completion_status"  value="L">
                                    <label for="radio15"  onClick="tickL();"> Low_Interest </label>
                                  </div>
                                </div>
                                 <script>function tickP() {  $("input[name='inquiry_completion_status'][value='P']").prop('checked', true);  }
                       function tickC() {  $("input[name='inquiry_completion_status'][value='C']").prop('checked', true);  } 
                                             function tickL() {  $("input[name='inquiry_completion_status'][value='L']").prop('checked', true);  } </script> 
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-12">
                            <h3 class="box-title m-t-30">Inquiry May Be Pic From Existing Client Master For Other Products - Show Client Master List :</h3>
                            <!------------------------------------->
                            
                            <div class="form-group col-sm-9">
                              <div class="input-group">
                                <input class="form-control mydatepicker" readonly="" name="nfd" id="nfd" placeholder="Next Follow Date" type="text" >
                                <div class="input-group-addon">Next Follow Date <i class="fa fa-calendar"></i></div>
                              </div>
                            </div>
                            <div class="form-group col-sm-3">
                              <div class="input-group">
                                <input type="button" class="btn btn-danger btn-outline" onClick="$('#nfd').val('');" name="c" value="Remove Follow Date">
                              </div>
                            </div>
                            <div class="form-group col-sm-9">
                              <div class="input-group">
                                <input class="form-control" name="nfdt" id="nfdt" placeholder="Select Follow Time" type="text" >
                                <div class="input-group-addon">Next Follow Time <i class="fa fa-clock-o"></i></div>
                              </div>
                            </div>
                            <div class="form-group col-sm-3">
                              <div class="input-group">
                                <input type="button" class="btn btn-danger btn-outline" onClick="$('#nfdt').val('');" name="ct" value="Remove Follow Time">
                              </div>
                            </div>
                            <div class="form-group col-sm-12">
                              <div class="input-group">
                                <input class="form-control" placeholder=" Low Interest % (number only)" name="li" id="li" type="text" maxlength="2">
                                <div class="input-group-addon"> Low Interest <i class="fa fa-percent"></i></div>
                              </div>
                            </div>
                            <div class="form-group col-sm-1">
                              <div class="input-group">
                                <button type="button" id="dlt_bt" pdf="" class="btn btn-danger" disabled><i class="fa fa-trash"></i></button>
                              </div>
                            </div>
                            <div class="form-group col-sm-8">
                              <div class="input-group">
                                <input class="form-control" name="qpdf" id="qpdf" placeholder="PDF File Name will be Displayed Here... "  type="text" disabled>
                                <input name="qpdf_" id="qpdf_" type="hidden">
                                <div class="input-group-addon"> <i class="fa fa-link"></i> </div>
                              </div>
                            </div>
                            <div class="form-group col-sm-3">
                              <div class="input-group">
                                <input type="button" class="btn btn-info btn-outline" name="btnpdfff" onClick="$('#calci_modal').modal('show');cal33();" value="Generate  PDF Here..">
                              </div>
                            </div>
                          </div>
                          <hr class="full-width">
                          <div class="form-group col-sm-12">
                            <button type="reset" class="btn btn-danger waves-effect waves-light" id="reset">Reset</button>
                            <button type="submit" id="submit" class="btn btn-success waves-effect waves-light" >Submit</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <?php  if ($this->session->userdata('role') == "SA") { ?>
              <div id="pending" class="tab-pane fade in ">
                <div class="panel">
                  <div class="panel-heading">
                    <div class="row">
                      <div class="form-group col-sm-2 ">
                        <p> Pending Inquiry </p>
                        <select class="form-control " id="by_admin_pending" name="by_admin_pending">
                          <option value="all" <?php if(!isset($selected['admin'])) echo "selected";?> >All Admin</option>
                          <?php
                                    foreach ($admin as $p) {  
                                                             $sel="";  
                                                            if($selected['admin']==$p['name'])
                                                                $sel="selected";   
                                                            echo "<option value='" . $p['id'] . "'".$sel.">". $p['name'] . "</option>";
                                                            }
                                                         ?>
                        </select>
                      </div>
                      <div class="form-group col-sm-2 ">
                        <p>DateFrom</p>
                        <input type="text" name="datefromp" id="datefromp"class="rangedate form-control mydatepicker" value="<?php $dv = strtotime("-123 day"); echo date('d-m-Y',$dv); ?>">
                      </div>
                      <div class="form-group col-sm-2 ">
                        <p>DateTo </p>
                        <input class="rangedate form-control mydatepicker" id="datetop" name="datetop" value="<?php echo date('t-m-Y'); ?>">
                      </div>
                      <div class="form-group col-sm-2 ">
                        <p>&nbsp; </p>
                        <button type="button" class="btn btn-info" id="checkp" name="checkp" title="Check" onClick="Pending();"><i class="fa fa-check fa-2x"></i> </button>
                      </div>
                    </div>
                  </div>
                  <div class="table-responsive">
                    <table id="inquirytbl_pending" class="table table-striped table-bordered manage-u-table optimize-table">
                      <!----    table table-striped table-bordered manage-u-table optimize-table      ---->
                      <thead>
                        <tr>
                          <th width="70" class="text-center"> #</th>
                          <th width="250">Inquiry / Firm Name</th>
                          <th width="250">Mobile No.</th>
                          <th width="250"> Ref By. </th>
                          <th width="250">City</th>
                          <th width="250">Product</th>
                          <th width="250">Inquiry By</th>
                          <th width="250">Status Of Completion</th>
                          <th width="250">Option</th>
                          <th width="250">Generated Date</th>
                          <th style="width:90px;">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                      <tfoot>
                        <tr>
                          <th width="70" class="text-center"></th>
                          <th width="250"></th>
                          <th width="250"></th>
                          <th width="250"></th>
                          <th width="250"></th>
                          <th width="250"></th>
                          <th width="250"></th>
                          <th width="250"></th>
                          <th style="width:90px;"></th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
              <div id="completed" class="tab-pane fade in ">
                <div class="panel">
                  <div class="panel-heading">
                    <div class="row">
                      <div class="form-group col-sm-2 ">
                        <p> Completed Inquiry </p>
                        <select class="form-control " id="by_admin_completed" name="by_admin_completed">
                          <option value="all" <?php if(!isset($selected['admin'])) echo "selected";?> >All Admin</option>
                          <?php
                                    foreach ($admin as $p) {  
                                                             $sel="";  
                                                            if($selected['admin']==$p['name'])
                                                                $sel="selected";   
                                                            echo "<option value='" . $p['id'] . "'".$sel.">". $p['name'] . "</option>";
                                                            }
                                                         ?>
                        </select>
                      </div>
                      <div class="form-group col-sm-2 ">
                        <p>DateFrom</p>
                        <input type="text" name="datefromc" id="datefromc"class="rangedate form-control mydatepicker" value="<?php $dv = strtotime("-123 day"); echo date('d-m-Y',$dv); ?>">
                      </div>
                      <div class="form-group col-sm-2 ">
                        <p>DateTo </p>
                        <input class="rangedate form-control mydatepicker" id="datetoc" name="datetoc" value="<?php echo date('t-m-Y'); ?>">
                      </div>
                      <div class="form-group col-sm-2 ">
                        <p>&nbsp; </p>
                        <button type="button" class="btn btn-info" id="checkc" name="checkc"  title="Check" onClick="Completed();"><i class="fa fa-check fa-2x"></i> </button>
                      </div>
                    </div>
                  </div>
                  <div class="table-responsive">
                    <table id="inquirytbl_completed" class="table table-striped table-bordered manage-u-table optimize-table">
                      <!----    table table-striped table-bordered manage-u-table optimize-table      ---->
                      <thead>
                        <tr>
                          <th width="70" class="text-center"> #</th>
                          <th width="250">Inquiry / Firm Name</th>
                          <th width="250">Mobile No.</th>
                          <th width="250"> Ref By. </th>
                          <th width="250">City</th>
                          <th width="250">Product</th>
                          <th width="250">Inquiry By</th>
                          <th width="250">Status Of Completion</th>
                          <th width="250">Option</th>
                          <th width="250">Generated Date</th>
                          <th style="width:90px;">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                      <tfoot>
                        <tr>
                          <th width="70" class="text-center"></th>
                          <th width="250"></th>
                          <th width="250"></th>
                          <th width="250"></th>
                          <th width="250"></th>
                          <th width="250"></th>
                          <th width="250"></th>
                          <th width="250"></th>
                          <th style="width:90px;"></th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!---------Calculator------------->
<div class="modal fade " id="calci_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <table width="98%" class="table table-bordered">
        <tr>
          <td style="text-align: center" class="sag-shopping-drop"><input type="hidden" name="tid" id="tid" class="form-control" readonly />
            <select id="ddlSelectProduct" name="ddlSelectProduct" >
              <option value="1" >Genius</option>
              <option value="12">Gen IT (Income Tax)</option>
              <option value="13">Gen CMA/EMI</option>
              <option value="14">Gen Bal (Balance Sheet)</option>
              <option value="15">Gen Form Manager</option>
              <option value="16">Gen e-TDS</option>
              <option value="32">Gen GST(Desktop)</option>
              <option value="2">Gen Payroll</option>
              <option value="3">Gen Payroll Online</option>
              <option value="4">Gen Comp Law With XBRL</option>
              <option value="5">Gen Comp Law Without XBRL</option>
              <option value="10">Gen XBRL</option>
              <option value="28">Gen Portal</option>
              <option value="30">Gen Portal Android App</option>
              <option value="31">Gen Portal IOS App</option>
              <option value="22">Laptop Copy</option>
              <option value="23">LAN Copy</option>
              <option value="27">Bulk SMS</option>
            </select>
            <select id="ddlSelectPurchseType" name="ddlSelectPurchseType" >
              <option value="0">Installation Charges</option>
              <option value="1">Updation Charges</option>
            </select>
            <input id="Button1"class="btn btn-info btn-sm" type="button" value="ADD Products"onclick="showtbl()" /></td>
        </tr>
      </table>
      <div class="dashboard-container">
        <div class="box" align="center">
          <form  id="pdfff" >
            <input type="hidden" id="n1" name="n1" >
            <input type="hidden" id="n2" name="n2" >
            <input type="hidden" id="n3" name="n3" >
            <input type="hidden" id="n4" name="n4" >
            <input type="hidden" id="n5" name="n5" >
            <table id="ctl00_ContentPlaceHolder1_tblhdr">
              <tr style="display: none">
                <td colspan="2" align="left" style="padding-left: 30px;"><input id="ctl00_ContentPlaceHolder1_CBBankDetail0" type="checkbox" name="CBBankDetail0" />
                  <label for="ctl00_ContentPlaceHolder1_CBBankDetail0">Send Only Bank Details</label></td>
              </tr>
              <tr style="display: none">
                <td colspan="2" align="left" style="padding-left: 30px;"><input id="ctl00_ContentPlaceHolder1_CBnonassociateprice" type="checkbox" name="CBnonassociateprice" />
                  <label for="ctl00_ContentPlaceHolder1_CBnonassociateprice">Send Non Associate Price</label></td>
              </tr>
              <tr style="display: none">
                <td colspan="2" align="left" style="padding-left: 30px;"><input id="ctl00_ContentPlaceHolder1_CBassociateproce" type="checkbox" name="CBassociateproce" />
                  <label for="ctl00_ContentPlaceHolder1_CBassociateproce">Send Associate Price</label></td>
              </tr>
              <tr style="display: none">
                <td colspan="2" align="left" style="padding-left: 30px;"><input id="ctl00_ContentPlaceHolder1_CheckBox1" type="checkbox" name="CheckBox1" />
                  <label for="ctl00_ContentPlaceHolder1_CheckBox1">All DSC Price Details</label></td>
              </tr>
              <tr style="display: none">
                <td colspan="2" align="left" style="padding-left: 50px;"></td>
              </tr>
              <tr style="display: none">
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr style="display: none">
                <td style="width: 100px;"> Charges Type </td>
                <td><select name="ddlCType" id="ctl00_ContentPlaceHolder1_ddlCType" style="width:150px;">
                    <option selected="selected" value="0">Installation Charges</option>
                    <option value="1">Updation Charges</option>
                  </select></td>
              </tr>
              <tr style="display: none">
                <td align="left" style="padding-left: 30px;" colspan="2"><input id="ctl00_ContentPlaceHolder1_CBBankDetail" type="checkbox" name="CBBankDetail" checked="checked" />
                  <label for="ctl00_ContentPlaceHolder1_CBBankDetail">Send Bank Details</label></td>
              </tr>
            </table>
            <table id="ctl00_ContentPlaceHolder1_tbl" width="100%" border="1" class="Quotation">
              <tr id="ctl00_ContentPlaceHolder1_tblhead" style="display: none;">
                <th width="40%"> <center>
                    Particulars
                  </center>
                </th>
                <th width="10%" style="display: none;"> <center>
                    Installation
                  </center>
                </th>
                <th width="15%"> <center>
                    A.Y./F.Y.
                  </center>
                </th>
                <th width="15%"> <center>
                    Rates
                  </center>
                </th>
                <th width="6%"> <center>
                    Quantity
                  </center>
                </th>
                <th width="15%"> <center>
                    Total
                  </center>
                </th>
                <th width="10%"> Action </th>
              </tr>
              <tr id="tblGenius" style="display: none;">
                <td align="left"><div class="toggle">
                    <div class="toggle-label"> Genius Installation</div>
                    <div class="toggle-content" style="display: none;">
                      <table width="100%" class="pricalc">
                        <colgroup>
                        <col width="60%" />
                        <col width="30%" />
                        </colgroup>
                        <tr>
                          <td> Gen IT (Income Tax) Installation </td>
                          <th> AY–2019-20 </th>
                        </tr>
                        <tr>
                          <td> Gen CMA/EMI Installation </td>
                          <th> FY–2019-20 </th>
                        </tr>
                        <tr>
                          <td> Gen Bal (Balance Sheet) Installation </td>
                          <th> FY–2019-20 </th>
                        </tr>
                        <tr>
                          <td> Gen Form Manager Installation </td>
                          <th> FY–2019-20 </th>
                        </tr>
                        <tr>
                          <td> Gen e-TDS Installation </td>
                          <th> AY–2020-21 </th>
                        </tr>
                      </table>
                    </div>
                  </div></td>
                <td align="right" style="display: none;"> 9000/- <span id="ctl00_ContentPlaceHolder1_lblUp1">4000/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe1">AY–2019-20</span></td>
                <td><input name="txtI1" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI1" onBlur="calcProduct(),quantity(1)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><span class="width-small">
                  <input name="txtQ1" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ1" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" />
                  </span></td>
                <td align="right"><input name="lblL1" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL1" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre1" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(1)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID1">1</span></td>
              </tr>
              <tr id="tblGeniusUP" style="display: none;">
                <td align="left"><div class="toggle">
                    <div class="toggle-label"> Genius Updation</div>
                    <div class="toggle-content" style="display: none;">
                      <table width="100%" class="pricalc">
                        <colgroup>
                        <col width="60%" />
                        <col width="30%" />
                        </colgroup>
                        <tr>
                          <td> Gen IT (Income Tax) Installation </td>
                          <th> AY–2019-20 </th>
                        </tr>
                        <tr>
                          <td> Gen CMA/EMI Installation </td>
                          <th> FY–2019-20 </th>
                        </tr>
                        <tr>
                          <td> Gen Bal (Balance Sheet) Installation </td>
                          <th> FY–2017-16 </th>
                        </tr>
                        <tr>
                          <td> Gen Form Manager Installation </td>
                          <th> FY–2019-20 </th>
                        </tr>
                        <tr>
                          <td> Gen e-TDS Installation </td>
                          <th> AY–2020-21 </th>
                        </tr>
                      </table>
                    </div>
                  </div></td>
                <td align="right" style="display: none;"> 9000/- <span id="ctl00_ContentPlaceHolder1_lblUp25">4000/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe25">AY–2019-20</span></td>
                <td><input name="txtI25" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI25" onBlur="calcProduct(),quantity(25)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><span class="width-small">
                  <input name="txtQ25" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ25" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" />
                  </span></td>
                <td align="right"><input name="lblL25" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL25" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre25" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(25)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID25">1</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblPayroll" style="display: none;">
                <td align="left"> Gen Payroll Installation </td>
                <td align="right" style="display: none;"> 15000/- <span id="ctl00_ContentPlaceHolder1_lblUp2">4000/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe2">FY–2019-20</span></td>
                <td><input name="txtI2" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI2" onBlur="calcProduct(),quantity(2)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ2" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ2" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL2" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL2" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre2" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(2)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID2">6</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblPayrollUP" style="display: none;">
                <td align="left"> Gen Payroll Updation </td>
                <td align="right" style="display: none;"> 15000/- <span id="ctl00_ContentPlaceHolder1_lblUp26">4000/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe26">FY–2019-20</span></td>
                <td><input name="txtI26" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI26" onBlur="calcProduct(),quantity(26)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ26" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ26" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL26" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL26" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre26" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(26)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID26">6</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblPayrollOnline" style="display: none;">
                <td align="left"> Payroll Online Installation </td>
                <td align="right" style="display: none;"> 20000/- <span id="ctl00_ContentPlaceHolder1_lblUp3">5000/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe3">FY–2019-20</span></td>
                <td><input name="txtI3" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI3" onBlur="calcProduct(),quantity(3)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ3" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ3" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL3" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL3" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre3" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(3)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID3">51</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblPayrollOnlineUP" style="display: none;">
                <td align="left"> Payroll Online Updation (Without Domain Hosting) </td>
                <td align="right" style="display: none;"> 20000/- <span id="ctl00_ContentPlaceHolder1_lblUp27">5000/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe27">FY–2019-20</span></td>
                <td><input name="txtI27" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI27" onBlur="calcProduct(),quantity(27)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ27" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ27" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL27" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL27" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre27" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(27)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID27">51</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblCompLaw" style="display: none;">
                <td align="left"> Comp Law With XBRL Installation </td>
                <td align="right" style="display: none;"> 10000/- <span id="ctl00_ContentPlaceHolder1_lblUp4">10000/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe4">FY–2019-20</span></td>
                <td><input name="txtI4" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI4" onBlur="calcProduct(),quantity(4)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ4" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ4" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL4" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL4" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre4" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(4)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID4">7</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblCompLawUP" style="display: none;">
                <td align="left"> Comp Law With XBRL Updation </td>
                <td align="right" style="display: none;"> 3000/- <span id="ctl00_ContentPlaceHolder1_lblUp28">4000/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe28">FY–2019-20</span></td>
                <td><input name="txtI28" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI28" onBlur="calcProduct(),quantity(28)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ28" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ28" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL28" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL28" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre28" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(28)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID28">7</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblCompLawWXBRL" style="display: none;">
                <td align="left"> Comp Law Without XBRL Installation </td>
                <td align="right" style="display: none;"> 7000/- <span id="ctl00_ContentPlaceHolder1_lblUp5">7000/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe5">FY–2019-20</span></td>
                <td><input name="txtI5" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI5" onBlur="calcProduct(),quantity(5)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ5" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ5" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL5" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL5" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre5" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(5)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID5">42</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblCompLawWXBRLUP" style="display: none;">
                <td align="left"> Comp Law Without XBRL Updation </td>
                <td align="right" style="display: none;"> 7000/- <span id="ctl00_ContentPlaceHolder1_lblUp29">3000/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe29">FY–2019-20</span></td>
                <td><input name="txtI29" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI29" onBlur="calcProduct(),quantity(29)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ29" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ29" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL29" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL29" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre29" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(29)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID29">42</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblGenAVAT" style="display: none;">
                <td align="left"> Gen A-VAT (All States) Installation </td>
                <td align="right" style="display: none;"><span id="ctl00_ContentPlaceHolder1_lblUp6">10000/-</span> 10000/- </td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe6">FY–2019-20</span></td>
                <td><input name="txtI6" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI6" onBlur="calcProduct(),quantity(6)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ6" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ6" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL6" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL6" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre6" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(6)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID6">22</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblGenAVATUP" style="display: none;">
                <td align="left"> Gen A-VAT (All States) Updation </td>
                <td align="right" style="display: none;"><span id="ctl00_ContentPlaceHolder1_lblUp30">3000/-</span> 3000 </td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe30">FY–2019-20</span></td>
                <td><input name="txtI30" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI30" onBlur="calcProduct(),quantity(30)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ30" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ30" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL30" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL30" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre30" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(30)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID30">22</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblGenAVATSingle" style="display: none;">
                <td align="left"> Gen A-VAT (Single State) Installation </td>
                <td align="right" style="display: none;"><span id="ctl00_ContentPlaceHolder1_lblUp46">5000/-</span> 5000/- </td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe46">FY–2019-20</span></td>
                <td><input name="txtI46" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI46" onBlur="calcProduct(),quantity(46)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ46" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ46" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL46" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL46" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre46" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(46)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID46">31</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblGenAVATUPSingle" style="display: none;">
                <td align="left"> Gen A-VAT (Single State) Updation </td>
                <td align="right" style="display: none;"><span id="ctl00_ContentPlaceHolder1_lblUp47">2000/-</span> 2000 </td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe47">FY–2019-20</span></td>
                <td class="sag-check-center"><input name="txtI47" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI47" onBlur="calcProduct(),quantity(47)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ47" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ47" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL47" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL47" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre47" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(47)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID47">31</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblPortalIns" style="display: none;">
                <td align="left"> Gen Portal Installation </td>
                <td align="right" style="display: none;"> 10000/- <span id="ctl00_ContentPlaceHolder1_lblUp52">10000/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe52"></span></td>
                <td><input name="txtI52" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI52" onBlur="calcProduct(),quantity(52)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ52" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ52" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL52" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL52" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="right"><input id="btnre52" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(52)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID52">41</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblPortalUp" style="display: none;">
                <td align="left"> Gen Portal Updation </td>
                <td align="right" style="display: none;"> 5000/- <span id="ctl00_ContentPlaceHolder1_lblUp53">5000/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe53"></span></td>
                <td><input name="txtI53" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI53" onBlur="calcProduct(),quantity(53)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ53" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ53" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL53" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL53" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="right"><input id="btnre53" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(53)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID53">41</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblPaperLessOffice" style="display: none;">
                <td align="left"> Gen Paper Less Office Installation </td>
                <td align="right" style="display: none;"> 11000/- <span id="ctl00_ContentPlaceHolder1_lblUp7">8000/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe7"></span></td>
                <td><input name="txtI7" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI7" onBlur="calcProduct(),quantity(7)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ7" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ7" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL7" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL7" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre7" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(7)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID7">14</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblPaperLessOfficeUP" style="display: none;">
                <td align="left"> Gen Paper Less Office Updation </td>
                <td align="right" style="display: none;"> 11000/- <span id="ctl00_ContentPlaceHolder1_lblUp31">8000/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe31"></span></td>
                <td><input name="txtI31" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI31" onBlur="calcProduct(),quantity(31)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ31" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ31" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL31" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL31" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre31" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(31)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID31">14</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblGenSmartShoppee" style="display: none;">
                <td align="left"> Gen Smart Shoppee Installation </td>
                <td align="right" style="display: none;"> 10000/- <span id="ctl00_ContentPlaceHolder1_lblUp8">2500/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe8">FY–2019-20</span></td>
                <td><input name="txtI8" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI8" onBlur="calcProduct(),quantity(8)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ8" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ8" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL8" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL8" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre8" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(8)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID8">13</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblGenSmartShoppeeUP" style="display: none;">
                <td align="left"> Gen Smart Shoppee Updation </td>
                <td align="right" style="display: none;"> 10000/- <span id="ctl00_ContentPlaceHolder1_lblUp32">2500/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe32">FY–2019-20</span></td>
                <td><input name="txtI32" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI32" onBlur="calcProduct(),quantity(32)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ32" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ32" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL32" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL32" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre32" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(32)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID32">13</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblGenInvestor" style="display: none;">
                <td align="left"> Gen Investor Installation </td>
                <td align="right" style="display: none;"> 2000/- <span id="ctl00_ContentPlaceHolder1_lblUp9">1000/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe9">FY–2019-20</span></td>
                <td><input name="txtI9" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI9" onBlur="calcProduct(),quantity(9)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ9" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ9" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL9" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL9" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre9" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(9)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID9">12</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblGenInvestorUP" style="display: none;">
                <td align="left"> Gen Investor Updation </td>
                <td align="right" style="display: none;"> 2000/- <span id="ctl00_ContentPlaceHolder1_lblUp33">1000/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe33">FY–2019-20</span></td>
                <td><input name="txtI33" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI33" onBlur="calcProduct(),quantity(33)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ33" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ33" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL33" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL33" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre33" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(33)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID33">12</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblGenXBRL" style="display: none;">
                <td align="left"><span class="overflow_auto">Gen XBRL Installation</span></td>
                <td align="right" style="display: none;"> 5000/- <span id="ctl00_ContentPlaceHolder1_lblUp10">2000/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe10">FY–2019-20</span></td>
                <td><input name="txtI10" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI10" onBlur="calcProduct(),quantity(10)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ10" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ10" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL10" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL10" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre10" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(10)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID10">25</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblGenXBRLUP" style="display: none;">
                <td align="left"> Gen XBRL Updation </td>
                <td align="right" style="display: none;"> 5000/- <span id="ctl00_ContentPlaceHolder1_lblUp34">2000/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe34">FY–2019-20</span></td>
                <td><input name="txtI34" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI34" onBlur="calcProduct(),quantity(34)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ34" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ34" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL34" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL34" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre34" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(34)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID34">25</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblGenRVAT" style="display: none;">
                <td align="left"> Gen RVAT Installation </td>
                <td align="right" style="display: none;"> 4000/- <span id="ctl00_ContentPlaceHolder1_lblUp11">1500/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe11">FY–2019-20</span></td>
                <td><input name="txtI11" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI11" onBlur="calcProduct(),quantity(11)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ11" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ11" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL11" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL11" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre11" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(11)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID11">11</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblGenRVATUP" style="display: none;">
                <td align="left"> Gen RVAT Updation </td>
                <td align="right" style="display: none;"> 4000/- <span id="ctl00_ContentPlaceHolder1_lblUp35">1500/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe35">FY–2019-20</span></td>
                <td><input name="txtI35" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI35" onBlur="calcProduct(),quantity(35)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ35" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ35" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL35" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL35" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre35" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(35)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID35">11</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblGenIT" style="display: none;">
                <td align="left"> Gen IT (Income Tax) Installation </td>
                <td align="right" style="display: none;"> 4500/- <span id="ctl00_ContentPlaceHolder1_lblUp12">2000/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe12">AY–2019-20</span></td>
                <td><input name="txtI12" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI12" onBlur="calcProduct(),quantity(12)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ12" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ12" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL12" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL12" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre12" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(12)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID12">2</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblGenITUP" style="display: none;">
                <td align="left"> Gen IT (Income Tax) Updation </td>
                <td align="right" style="display: none;"> 4500/- <span id="ctl00_ContentPlaceHolder1_lblUp36">2000/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe36">AY–2019-20</span></td>
                <td><input name="txtI36" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI36" onBlur="calcProduct(),quantity(36)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ36" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ36" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL36" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL36" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre36" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(36)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID36">2</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblGenCMA" style="display: none;">
                <td align="left"> Gen CMA/EMI Installation </td>
                <td align="right" style="display: none;"> 2000/- <span id="ctl00_ContentPlaceHolder1_lblUp13">500/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe13">FY–2019-20</span></td>
                <td><input name="txtI13" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI13" onBlur="calcProduct(),quantity(13)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ13" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ13" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL13" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL13" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre13" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(13)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID13">5</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblGenCMAUP" style="display: none;">
                <td align="left"> Gen CMA/EMI Updation </td>
                <td align="right" style="display: none;"> 2000/- <span id="ctl00_ContentPlaceHolder1_lblUp37">500/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe37">FY–2019-20</span></td>
                <td><input name="txtI37" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI37" onBlur="calcProduct(),quantity(37)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ37" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ37" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL37" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL37" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre37" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(37)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID37">5</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblGenBal" style="display: none;">
                <td align="left"> Gen Bal (Balance Sheet) Installation </td>
                <td align="right" style="display: none;"> 5000/- <span id="ctl00_ContentPlaceHolder1_lblUp14">2500/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe14">FY–2019-20</span></td>
                <td><input name="txtI14" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI14" onBlur="calcProduct(),quantity(14)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ14" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ14" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL14" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL14" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre14" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(14)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID14">3</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblGenBalUP" style="display: none;">
                <td align="left"> Gen Bal (Balance Sheet) Updation </td>
                <td align="right" style="display: none;"> 5000/- <span id="ctl00_ContentPlaceHolder1_lblUp38">2500/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe38">FY–2019-20</span></td>
                <td><input name="txtI38" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI38" onBlur="calcProduct(),quantity(38)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ38" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ38" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL38" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL38" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre38" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(38)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID38">3</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblGenFormManager" style="display: none;">
                <td align="left"> Gen Form Manager Installation </td>
                <td align="right" style="display: none;"> 1500/- <span id="ctl00_ContentPlaceHolder1_lblUp15">500/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe15">FY–2019-20</span></td>
                <td><input name="txtI15" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI15" onBlur="calcProduct(),quantity(15)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ15" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ15" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL15" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL15" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre15" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(15)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID15">4</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblGenFormManagerUP" style="display: none;">
                <td align="left"> Gen Form Manager Updation </td>
                <td align="right" style="display: none;"> 1500/- <span id="ctl00_ContentPlaceHolder1_lblUp39">500/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe39">FY–2019-20</span></td>
                <td><input name="txtI39" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI39" onBlur="calcProduct(),quantity(39)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ39" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ39" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL39" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL39" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre39" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(39)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID39">4</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblGenTDS" style="display: none;">
                <td align="left"> Gen e-TDS Installation </td>
                <td align="right" style="display: none;"> 3500/- <span id="ctl00_ContentPlaceHolder1_lblUp16">1500/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe16">AY–2020-21</span></td>
                <td><input name="txtI16" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI16" onBlur="calcProduct(),quantity(16)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ16" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ16" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL16" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL16" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre16" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(16)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID16">8</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblGenTDSUP" style="display: none;">
                <td align="left"> Gen e-TDS Updation </td>
                <td align="right" style="display: none;"> 3500/- <span id="ctl00_ContentPlaceHolder1_lblUp40">1500/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe40">AY–2020-21</span></td>
                <td><input name="txtI40" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI40" onBlur="calcProduct(),quantity(40)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ40" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ40" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL40" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL40" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre40" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(40)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID40">8</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblGenServiceTax" style="display: none;">
                <td align="left"> Gen Service Tax Installation </td>
                <td align="right" style="display: none;"> 3500/- <span id="ctl00_ContentPlaceHolder1_lblUp17">1500/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe17">FY–2019-20</span></td>
                <td><input name="txtI17" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI17" onBlur="calcProduct(),quantity(17)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ17" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ17" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL17" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL17" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre17" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(17)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID17">9</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblGenServiceTaxUP" style="display: none;">
                <td align="left"> Gen Service Tax Updation </td>
                <td align="right" style="display: none;"> 3500/- <span id="ctl00_ContentPlaceHolder1_lblUp41">1500/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe41">FY–2019-20</span></td>
                <td><input name="txtI41" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI41" onBlur="calcProduct(),quantity(41)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ41" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ41" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL41" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL41" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre41" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(41)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID41">9</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblGenSmartBill" style="display: none;">
                <td align="left"> Gen Smart Bill Installation </td>
                <td align="right" style="display: none;"> 5000/- <span id="ctl00_ContentPlaceHolder1_lblUp18">1500/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe18">FY–2019-20</span></td>
                <td><input name="txtI18" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI18" onBlur="calcProduct(),quantity(18)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ18" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ18" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL18" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL18" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre18" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(18)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID18">23</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblGenSmartBillUP" style="display: none;">
                <td align="left"> Gen Smart Bill Updation </td>
                <td align="right" style="display: none;"> 5000/- <span id="ctl00_ContentPlaceHolder1_lblUp42">1500/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe42">FY–2019-20</span></td>
                <td><input name="txtI42" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI42" onBlur="calcProduct(),quantity(42)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ42" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ42" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL42" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL42" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre42" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(42)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID42">23</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblGenXDExcise" style="display: none;">
                <td align="left"> Gen XDExcise Installation </td>
                <td align="right" style="display: none;"> 10000/- <span id="ctl00_ContentPlaceHolder1_lblUp19">10000/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe19">FY–2019-20</span></td>
                <td><input name="txtI19" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI19" onBlur="calcProduct(),quantity(19)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ19" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ19" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL19" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL19" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre19" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(19)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID19">28</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblGenXDExciseUP" style="display: none;">
                <td align="left"> Gen XDExcise Updation </td>
                <td align="right" style="display: none;"> 10000/- <span id="ctl00_ContentPlaceHolder1_lblUp43">10000/-</span></td>
                <td align="right"><span id="ctl00_ContentPlaceHolder1_lblYe43">FY–2019-20</span></td>
                <td><input name="txtI43" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI43" onBlur="calcProduct(),quantity(43)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ43" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ43" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL43" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL43" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre43" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(43)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID43">28</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblPCSpy" style="display: none;">
                <td align="left"> PC Spy Installation </td>
                <td align="right" style="display: none;"> 5000/- <span id="ctl00_ContentPlaceHolder1_lblUp20">5000/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe20">FY–2019-20</span></td>
                <td><input name="txtI20" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI20" onBlur="calcProduct(),quantity(20)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ20" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ20" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL20" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL20" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre20" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(20)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID20">37</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblPCSpyUP" style="display: none;">
                <td align="left"> PC Spy Updation </td>
                <td align="right" style="display: none;"> 2000/- <span id="ctl00_ContentPlaceHolder1_lblUp44">2000/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe44">FY–2019-20</span></td>
                <td><input name="txtI44" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI44" onBlur="calcProduct(),quantity(44)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ44" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ44" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL44" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL44" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre44" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(44)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID44">37</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblAuditor" style="display: none;">
                <td align="left"> Auditor Installation </td>
                <td align="right" style="display: none;"> 5000/- <span id="ctl00_ContentPlaceHolder1_lblUp21">5000/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe21">FY–2019-20</span></td>
                <td><input name="txtI21" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI21" onBlur="calcProduct(),quantity(21)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ21" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ21" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL21" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL21" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="right"><input id="btnre21" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(21)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID21">36</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblAuditorUP" style="display: none;">
                <td align="left"> Auditor Updation </td>
                <td align="right" style="display: none;"> 2000/- <span id="ctl00_ContentPlaceHolder1_lblUp45">2000/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe45">FY–2019-20</span></td>
                <td><input name="txtI45" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI45" onBlur="calcProduct(),quantity(45)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ45" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ45" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL45" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL45" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="right"><input id="btnre45" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(45)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID45">36</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblProjectFinanceIns" style="display: none;">
                <td align="left"> Project Finance Installation </td>
                <td align="right" style="display: none;"> 10000/- <span id="ctl00_ContentPlaceHolder1_lblUp48">10000/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe48">FY–2019-20</span></td>
                <td><input name="txtI48" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI48" onBlur="calcProduct(),quantity(48)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ48" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ48" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL48" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL48" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="right"><input id="btnre48" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(48)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID48">45</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblProjectFinanceUp" style="display: none;">
                <td align="left"> Project Finance Updation </td>
                <td align="right" style="display: none;"> 2000/- <span id="ctl00_ContentPlaceHolder1_lblUp49">2000/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe49">FY–2019-20</span></td>
                <td><input name="txtI49" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI49" onBlur="calcProduct(),quantity(49)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ49" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ49" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL49" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL49" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="right"><input id="btnre49" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(49)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID49">45</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblPortalAppIns" style="display: none;">
                <td align="left"> Gen Portal Android App Installation </td>
                <td align="right" style="display: none;"> 5000/- <span id="ctl00_ContentPlaceHolder1_lblUp57">5000/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe57"></span></td>
                <td><input name="txtI57" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI57" onBlur="calcProduct(),quantity(57)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ57" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ57" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL57" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL57" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre57" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(57)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID57">504</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblPortalAppUp" style="display: none;">
                <td align="left"> Gen Portal Android App Updation </td>
                <td align="right" style="display: none;"> 2500/- <span id="ctl00_ContentPlaceHolder1_lblUp58">2500/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe58"></span></td>
                <td><input name="txtI58" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI58" onBlur="calcProduct(),quantity(58)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ58" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ58" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL58" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL58" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre58" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(58)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID58">504</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblPortalIOSAppIns" style="display: none;">
                <td align="left"> Gen Portal IOS App Installation </td>
                <td align="right" style="display: none;"> 5000/- <span id="ctl00_ContentPlaceHolder1_lblUp59">5000/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe59"></span></td>
                <td><input name="txtI59" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI59" onBlur="calcProduct(),quantity(59)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ59" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ59" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL59" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL59" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre59" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(59)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID59">504</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblPortalIOSAppUp" style="display: none;">
                <td align="left"> Gen Portal IOS App Updation </td>
                <td align="right" style="display: none;"> 2500/- <span id="ctl00_ContentPlaceHolder1_lblUp60">2500/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe60"></span></td>
                <td><input name="txtI60" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI60" onBlur="calcProduct(),quantity(60)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ60" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ60" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL60" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL60" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre60" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(60)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID60">504</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblGenGSTIns" style="display: none;">
                <td align="left"> Gen GST Desktop Installation </td>
                <td align="right" style="display: none;"> 5000/- <span id="ctl00_ContentPlaceHolder1_lblUp61">5000/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe61">FY–2019-20</span></td>
                <td><input name="txtI61" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI61" onBlur="calcProduct(),quantity(61)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ61" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ61" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL61" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL61" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre61" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(61)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID61">58</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblGenGSTUp" style="display: none;">
                <td align="left"> Gen GST Desktop Updation </td>
                <td align="right" style="display: none;"> 2000/- <span id="ctl00_ContentPlaceHolder1_lblUp62">2000/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe62">FY–2019-20</span></td>
                <td><input name="txtI62" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI62" onBlur="calcProduct(),quantity(62)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ62" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ62" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL62" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL62" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre62" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(62)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID62">58</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblGenGSTCludIns" style="display: none;">
                <td align="left"> Gen GST Cloud Installation </td>
                <td align="right" style="display: none;"> 5000/- <span id="ctl00_ContentPlaceHolder1_lblUp63">5000/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe63"></span></td>
                <td><input name="txtI63" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI63" onBlur="calcProduct(),quantity(63)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ63" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ63" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL63" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL63" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre63" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(63)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID63">50</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblGenGSTCludUp" style="display: none;">
                <td align="left"> Gen GST Cloud Updation </td>
                <td align="right" style="display: none;"> 2500/- <span id="ctl00_ContentPlaceHolder1_lblUp64">2500/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe64"></span></td>
                <td><input name="txtI64" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI64" onBlur="calcProduct(),quantity(64)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ64" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ64" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL64" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL64" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre64" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(64)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID64">50</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblLaptopCopy" style="display: none;">
                <td align="left"> Laptop Copy </td>
                <td align="right" style="display: none;"> 2000/- <span id="ctl00_ContentPlaceHolder1_lblUp22">2000/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe22">As per Product</span></td>
                <td><input name="txtI22" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI22" onBlur="calcProduct(),quantity(22)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td class="sag-check-center"><input name="txtQ22" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ22" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL22" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL22" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre22" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(22)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID22">501</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblLANCopy" style="display: none;">
                <td align="left"> LAN Copy </td>
                <td align="right" style="display: none;"> 500/- <span id="ctl00_ContentPlaceHolder1_lblUp23">500/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe23"></span></td>
                <td><input name="txtI23" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI23" onBlur="calcProduct(),quantity(23)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ23" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ23" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL23" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL23" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre23" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(23)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID23">500</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblBulkVeri" style="display: none;">
                <td align="left"> Bulk Email Verification Installation </td>
                <td align="right" style="display: none;"> 3000/- <span id="ctl00_ContentPlaceHolder1_lblUp50">3000/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe50"></span></td>
                <td><input name="txtI50" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI50" onBlur="calcProduct(),quantity(26)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ50" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ50" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL50" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL50" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre50" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(50)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID50">46</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblBulkVeriUp" style="display: none;">
                <td align="left"> Bulk Email Verification Updation </td>
                <td align="right" style="display: none;"> 3000/- <span id="ctl00_ContentPlaceHolder1_lblUp54">3000/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe54"></span></td>
                <td><input name="txtI54" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI54" onBlur="calcProduct(),quantity(26)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ54" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ54" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL54" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL54" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre54" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(54)" /></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblGenTimelog" style="display: none;">
                <td align="left"> Gen Time Logger </td>
                <td align="right" style="display: none;"> 3000/- <span id="ctl00_ContentPlaceHolder1_lblUp55">3000/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe55">FY–2019-20</span></td>
                <td><input name="txtI55" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI55" onBlur="calcProduct(),quantity(29)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ55" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ55" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL55" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL55" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre55" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(55)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID55">48</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblBulkSms" style="display: none;">
                <td align="left"><input name="lblBulkSms" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblBulkSms" onKeyPress="return blanck(event)" style="background-color:#E9E9E9;text-align: left;" /></td>
                <td align="right" style="display: none;"> 1500/- <span id="ctl00_ContentPlaceHolder1_lblUp51">1500/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe51"></span></td>
                <td><input name="txtI51" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI51" onBlur="calcProduct(),quantity(27)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ51" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ51" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL51" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL51" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre51" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(51)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID51">47</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblLaptop1" style="display: none;">
                <td align="left" class="lp-select"><div align="left"> <span class="lp-copy"> Laptop Copy </span>
                    <select name="ddllaptop" id="ctl00_ContentPlaceHolder1_ddllaptop" onChange="LancopyProduct()" style="margin-top: 3px; height: 23px; padding: 0px; width: 125px;">
                      <option value="1">Genius</option>
                      <option value="6">Gen Payroll</option>
                      <option value="2">Gen IT (Income Tax)</option>
                      <option value="5">Gen CMA/EMI</option>
                      <option value="3">Gen Bal (Balance Sheet)</option>
                      <option value="4">Gen Form Manager</option>
                      <option value="8">Gen e-TDS</option>
                      <option value="9">Gen Service Tax</option>
                      <option value="22">Gen A-VAT</option>
                      <option value="11">Gen RVAT</option>
                      <option value="28">Gen XDExcise</option>
                      <option value="36">Gen Auditor</option>
                      <option value="45">Project Finance</option>
                      <option value="13">Gen Smart Shoppee</option>
                      <option value="23">Gen Smart Bill</option>
                    </select>
                  </div></td>
                <td align="right" style="display: none;"> 2000/- <span id="ctl00_ContentPlaceHolder1_lblUp56">2000/-</span></td>
                <td align="center"><span id="ctl00_ContentPlaceHolder1_lblYe56"></span></td>
                <td><input name="txtI56" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI56" onBlur="calcProduct(),quantity(56)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ56" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ56" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL56" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL56" onKeyPress="return blanck(event)" style="text-align: right;" /></td>
                <td align="center"><input id="btnre56" type="button" class="btn btn-danger btn-sm" value="Remove" onClick="showtblremove(56)" /></td>
                <td style="display:none"><span id="ctl00_ContentPlaceHolder1_lblProduID56">1</span></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblDiscount" style="display: none;">
                <td align="left"> Discount </td>
                <td align="right" style="display: none;"> -- </td>
                <td align="right"> -- </td>
                <td><input name="txtI24" type="text" value="0" maxlength="5" id="ctl00_ContentPlaceHolder1_txtI24" onBlur="calcProduct(),quantity(24)" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td><input name="txtQ24" type="text" value="0" maxlength="2" id="ctl00_ContentPlaceHolder1_txtQ24" disabled="disabled" onBlur="calcProduct()" onKeyPress="return numbersonly(event, false)" style="text-align: right;" /></td>
                <td align="right"><input name="lblL24" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblL24" onKeyPress="return blanck(event)" style="width:95%;text-align: right;" /></td>
                <td align="center">&nbsp;</td>
              </tr>
            </table>
            <table class="table table-bordered custom" style="width: 100%">
              <tr id="tblTotalAmount" style="display: none;">
                <td align="right" colspan="5"><b>Total Amount</b></td>
                <td align="right" colspan="1"><input name="lblTtlTtl"  type="text" value="0" id="ctl00_ContentPlaceHolder1_lblTtlTtl" onKeyPress="return blanck(event)" style="text-align: right;
                                                            font-weight: bold; width: 120px;" /></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblServicesTaxPay" style="display: none;">
                <td align="right" colspan="5"> GST Tax @18.00% </td>
                <td align="right" colspan="1"><input name="lblST" type="text" value="0" id="ctl00_ContentPlaceHolder1_lblST" onKeyPress="return blanck(event)" style="text-align: right; width: 100%; font-weight: 700; width: 120px;" /></td>
              </tr>
              <tr id="ctl00_ContentPlaceHolder1_tblAmountPayablePay" style="display: none;">
                <td colspan="5" align="right" title="Online Charges will be Applied separately "><b> Total Amount Payable </b></td>
                <td align="right" colspan="1"><input name="lblAmtPayble" type="text" value="0" id="lblAmtPayble" onKeyPress="return blanck(event)" style="text-align: right;
                                                                    font-weight: bold; width: 120px;" /></td>
              </tr>
              <tr>
               <textarea class="form-control" style="width:90%; background-color:#f9dbf9; color:Black; font-weight:bold" name="Notes" id="Notes" rows="3" placeholder="Add Your Notes here And This Notes will be in your PDF "></textarea>
              </tr>
              <!--tr id="tblAmountTotalWithClient" style="display: none;">
                            <td colspan="5" align="right"><b>Total Online Payment Charges</b></td>
                            <td align="right" colspan="1"><input name="txtCleintTotalPay" type="text" value="0" id="txtCleintTotalPay" onKeyPress="return blanck(event)" style="text-align: right;
                                                                    font-weight: bold; width: 120px;" /></td>
                          </tr>
                          <tr id="tblAmountTotalPaybaleWithClient" style="display: none;"--> 
              <!--td colspan="5" align="right"><b>Total Amount With Online Payment Charges</b></td>
                            <td align="right" colspan="1" style="width: 20px;"><input name="txtCleintTotalAmountPayble" type="text" value="0" id="txtCleintTotalAmountPayble" onKeyPress="return blanck(event)" style="text-align: right;
                                                                    font-weight: bold; width: 120px;" /></td>
                          </tr--->
            </table>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" id="cal_sub_btn" class="btn btn-danger btn-sm" name="submit" >Create PDF and Save</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!----------Calculator--------------------> 
  
  <!-- /.container-fluid --> 
  
  <!--footer start-->
  <?php $this->load->view('template/footer'); ?>
  <!--footer end--> 
</div>
<!-- ============================================================== --> 
<!-- End Page Content --> 
<!-- ============================================================== --> 
<!--main content end -->
<div id="smsModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm"> 
    
    <!-- Modal content-->
    
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> Inquiry Message</h4>
      </div>
      <div class="modal-body clearfix">
        <div class="form-group col-sm-12">
          <label for="send_to">To:</label>
          <input type="text" class="form-control" id="send_to" name="send_to">
        </div>
        <div class="form-group col-sm-12 clearfix">
          <label for="send_msg">Message:</label>
          <textarea class="form-control" id="send_msg" rows="7" name="send_msg" placeholder="Hello, Start Writing Your Message From Here" onKeyPress="myf();"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-inverse waves-effect waves-light" data-dismiss="modal">Close</button>
        <a target="_blank" class="adata_id" >
        <button type="button" send="btn" class="btn btn-success waves-effect waves-light m-r-10">Send</button>
        </a> </div>
    </div>
  </div>
</div>

<!---========================= Text SMS Modal ==============---->
<div id="smsModal1" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body clearfix">
        <form id="sms_form">
          <input type="hidden" id="mobb" name="mob" value="" >
         
          <div class="form-group col-sm-6">
            <label for="send_from1">From:</label>
            <input type="text" class="form-control" id="send_from" name="send_from1" value="SAI INFOTECH" disabled>
          </div>
          <div class="form-group col-sm-4">
            <label for="send_to1">To:</label>
            <input type="text" class="form-control" id="send_to1" name="send_to" maxlength="10" disabled="">
          </div>
          <div class="form-group col-sm-10 clearfix">
            <label for="send_msg">Message: </label>
            <textarea class="msg form-control" id="send_msg1" rows="7" name="send_msg" maxlength="160" placeholder="Your Message Here ..."></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-inverse waves-effect waves-light" data-dismiss="modal">Close</button>
          <a target="_blank" class="adata_id" >
          <button class="btn btn-success waves-effect waves-light m-r-10" id="send_sms_btn" type="submit">Send SMS</button>
          </a> </div>
      </form>
    </div>
  </div>
</div>

<!---========================= Assign Modal ==============---->
<div id="assignModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> Assign To </h4>
      </div>
      <form id="assign_form">
        <div class="modal-body clearfix">
          <div class="form-group col-sm-12">
            <label for="assign_to">Assign To :</label>
            <select class="form-control" id="assign_id" name="assign_id">
            </select>
          </div>
        </div>
        <input type="hidden" name="hid_id" id="hid_id" >
        <div class="modal-footer">
          <button type="button" class="btn btn-inverse waves-effect waves-light" data-dismiss="modal">Close</button>
          <a target="_blank" class="adata_id" >
          <button type="submit" class="btn btn-success waves-effect waves-light m-r-10" >Assign</button>
          </a> </div>
      </form>
    </div>
  </div>
</div>
<!---========================= Assign Modal ==============---->

<?php $this->load->view('template/footerlink'); ?>
<script src="<?php echo base_url(); ?>assetss/plugins/bower_components/switchery/dist/switchery.min.js"></script>
<script src="<?php echo base_url(); ?>assetss/js/custom.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.full.min.js"></script> 
<script>
   $(document).ready(function (){ $('.js-example-basic-multiple').select2({ placeholder: "Select Product",width: "100%",  }); });
  $("#product_list").change(function() { var Id = $("#product_list").val(); $("#selected_list").val(Id); });
  $("#product_list_e").change(function() {var Id = $("#product_list_e").val();$("#selected_list_e").val(Id); });
    
  </script> 
<script> function RES() { $('.edit_form clearfix').trigger("reset"); }</script> 
<script type="text/javascript">
    $(document).ready(function(){ $('#edit_li').hide();});
    
   </script> 
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.1/moment.min.js"></script>
      <script type="text/javascript" src=" https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    
       <script type="text/javascript">
            $(function () {
                $('#nfdt').datetimepicker({
                    format: 'LT'
                });
            });
    </script>
<script type="text/javascript">
  $('#inquirytbl>tbody,#inquirytbl_completed>tbody,#inquirytbl_pending>tbody').on('click', '.edit', function () {
    $('#edit_li').show();  
                var id = $(this).data('id');
        $('.editBTN'+id).attr('disabled',''); 
        setTimeout(function(){  $('.editBTN'+id).removeAttr('disabled'); }, 4560);
      
                $.ajax({
                    type: 'POST', data: {'id': id, 'tbl': tbl},
                    url: '<?php echo base_url('Helper/GetEditData'); ?>',
                    dataType: 'json',
                    success: function (c) {    var PL = c.product_id.split(','); 
            var e = new Array();  //console.log(PL);
          for(var i=0; i < PL.length; i++) {  e.push(PL[i]); } $("#product_list_e").val(e).trigger('change');  
          
      $('#paneltitle').hide();$('#panelupdate').show();
            $('#inquiry_date').val(c.si_generated_date); $('#inquiry_city').val(c.inquiry_city);
            $('#myTab a[href="#add"]').tab('show');
      $('#inquiry_ref_by').val(c.inquiry_ref_by); $('#inquiry_name').val(c.inquiry_name);
            $('#inquiry_firmname').val(c.inquiry_firm_name);
      $('#inquiry_email').val(c.si_inquiry_email);
      $('#inquiry_gstno').val(c.inquiry_gstno); 
            $('#inquiry_gstno').val(c.inquiry_gstno);
           $('#si_state_id').val(c.inquiry_state); $('#inquiry_address').val(c.inquiry_address);
           $("input[name='inquiry_completion_status'][value='"+c.inquiry_completion_status+"']").prop('checked', true);
             $('#remark').val(c.remark);$('#interest_product').val(c.interest_product);
           $('#inquiry_mobile').val(c.inquiry_mobile);$('#inquiry_other_no').val(c.inquiry_other_no);
           $('#discount_offer').val(c.discount_offer);
           var m=c.multiple_mobile_number;
           //-------------Multiple Mobile Number
           $('.ZYOCISW_e,.FPNHYTU_e').remove();
           
           if(m!=null && m.length>2 )
           {    var nn = $('.ZYOCISW_e').length
             
                  var str2 = "<br>";
                  if(m.indexOf(str2) != -1)
                  {
                    var MN = m.split('<br>'); 
                    if(nn>1){ return false;}
                      var f = new Array();  
                    for(var i=0; i < MN.length; i++) {  f.push(MN[i]); 
                    
                    //--
                    nm=i+1;
                  var r_str = "";  
                  var s = "123456789987654321";
                 for (var j = 0; j < 10; j++) { r_str += s.charAt(Math.floor(Math.random() * s.length)); }  //console.log(r_str);
                    
                    html='<div class="ZYOCISW_e ae'+r_str+' form-group col-sm-9"><div class="input-group"><input class="form-control" name="iq_mob_e'+nm+'" id="iq_mob_e'+nm+'" value="'+MN[i]+'" placeholder="Mobile / Landline Number" type="text" required><div class="input-group-addon">Mobile / Landline Number <i class="fa fa-mobile"></i></div></div></div><div class="FPNHYTU_e ae'+r_str+' form-group col-sm-3"><div class="input-group"><input type="button" class="btn btn-danger btn-outline" onClick="removenum_e('+r_str+');" value=" - Remove This"></div></div>';
              $('#af_div_e').after(html); 
                    
                    
                    
                                              }    // console.log(str2 + " found <br> ");
                                                  console.log(MN[1]);
                  }
                    else {  // console.log(str2 + "Not  found <br> ");
                    if(nn>=1){ return false;}
                    
                    var r_str = "";  
                  var s = "123456789987654321";
                 for (var j = 0; j < 10; j++) { r_str += s.charAt(Math.floor(Math.random() * s.length)); }  
                    
                    html='<div class="ZYOCISW_e ae'+r_str+' form-group col-sm-9"><div class="input-group"><input class="form-control" value="'+m+'" name="iq_mob_e1" id="iq_mob_e1" placeholder="Mobile / Landline Number" type="text" required><div class="input-group-addon">Mobile / Landline Number <i class="fa fa-mobile"></i></div></div></div><div class="FPNHYTU_e ae'+r_str+' form-group col-sm-3"><div class="input-group"><input type="button" class="btn btn-danger btn-outline" onClick="removenum_e('+r_str+');" value=" - Remove This"></div></div>';
              $('#af_div_e').after(html); 
                
                                }
             
             
             
           }
           //-------------Multiple Mobile Number
           
           if(c.generated_pdf) {
              $('#dlt_bt').attr('pdf',c.generated_pdf);
              $('#dlt_bt').attr('title','Delete This PDF '+c.generated_pdf); $('#dlt_bt').removeAttr('disabled');
               }
           
           $('#nfd').val(c.next_follow_date);$('#nfdt').val(c.next_follow_time);$('#qpdf,#qpdf_').val(c.generated_pdf);$('#li').val(c.low_interest);
           $('#hid').val(c.si_inquiry_detail_id);$('#submit').empty();$('#submit').html('Update');  
           }
                });
            });
  
  //<!-------------------------------------POPover--------------------->
 
    $('#inquirytbl>tbody,#inquirytbl_completed>tbody,#inquirytbl_pending>tbody').on('click mouseover', '.seePro', function () {
      if($(this).attr('ok')) { return false;} 
      
      var idd = $(this).attr('id');  var seepro = $(this).attr('seepro');   
      
                $.ajax({
                    type: 'POST', data: {id : seepro},
                    url: '<?php echo base_url('Admin/Inquiry/seeProOnPopOver'); ?>',
                    dataType: 'JSON',
                    success: function (data) {   
          //$('.'+idd).popover({ trigger: "hover" }); 
          $('.'+idd).attr({ 'ok':'ok','data-toggle':'tooltip','title':data});
          $('.'+idd).tooltip('show');
          //setTimeout(function(){ $('.'+idd).popover('hide'); }, 3450);
           }
                });
              
            });
  //<!-----------------------------------------POPover---------------------->
      
       $('#dlt_bt').on('click', function () {
       var pdf = $('#dlt_bt').attr('pdf');
      var id = $('#hid').attr('value');
        swal({
            title: 'Are you Sure?',
            text: "Delete This PDF File",
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
                type: 'get',
                 url: '<?php echo base_url('Admin/Inquiry/Unlink_file'); ?>',
                 data:{"id":id,"pdf":pdf},
                dataType: 'json',
                success: function (data) {
                    if (data == 1) {
            swal(
                                'Successful !',
                                'Selected PDF has been  Deleted.',
                                'success'
                                )
                $('#qpdf').val('');
                    }
          else {
            swal(
                                'Not Found !!',
                                'Selected PDF could not be Deleted.',
                                'error'
                                )
            }
                }
            });
        }, function (dismiss) {
            if (dismiss === 'cancel') {
                swal(
                        'Cancelled',
                        'Your PDF File is Safe :)',
                        'error'
                        )
            }
        })
    });
  
      
      
</script> 
<script>
 $(".myadmin-alert .closed").click(function(event){$(this).parents(".myadmin-alert").fadeToggle(350); return false; });
 $('.rangedate').datepicker({format: 'dd-mm-yyyy', todayHighlight: true,    });

<?php  if ($this->session->userdata('role') == "SA") { ?>
  $('#by_admin_completed').change(function (){  Completed(); }); 
  $('#by_admin_pending').change(function (){  Pending(); }); 
  
  function Pending(){ 
  var Id = $("#by_admin_pending").val();
  var Pending = $('#inquirytbl_pending').DataTable({
    "processing": true,"serverSide": true,
    "destroy": true, "paging": true,"searching": true,
    "lengthMenu": [[10, 50, 100, -1], [10, 50, 100, "All"]],"pageLength": 100,  "order": [[ 0, "desc" ]],
    "ajax":  { 
    "data":{"select_inq": "Pending" ,"select_id" :Id,"v":0  ,"datefrom" :$("input[id=datefromp]").val() ,"dateto" :$("input[id=datetop]").val() ,"sms":"nosms"  },
    "url":"<?php echo base_url() . 'Admin/' . $this->uri->segment(2) . '/GetData'; ?>" },
    "aoColumnDefs": [{ 'bSortable': false, 'aTargets': [0,-1,-3] },{"targets": [-4],"visible": false }],
     "createdRow": function( row, data, dataIndex ){ if ( data[7] == "C"){$(row).attr({ style:"color:Green",title:"This Inquiry is Solved / Completed" });} }
   });  }
   function Completed() {
     var Id = $("#by_admin_completed").val();
    var Completed = $('#inquirytbl_completed').DataTable({
    "processing": true, "serverSide": true,
     "destroy": true, "paging": true,"searching": true,
         "lengthMenu": [[10, 50, 100, -1], [10, 50, 100, "All"]], "pageLength": 100,  "order": [[ 0, "desc" ]],
        "ajax":  { 
    "data":{"select_inq": "Completed","select_id" :Id,"v":0  ,"datefrom" :$("input[id=datefromc]").val() ,"dateto" :$("input[id=datetoc]").val(),"sms":"nosms"  },
    "url":"<?php echo base_url() . 'Admin/' . $this->uri->segment(2) . '/GetData'; ?>" },
    "aoColumnDefs": [{ 'bSortable': false, 'aTargets': [0,-1,-3] },{"targets": [-4],"visible": false }],
     "createdRow": function( row, data, dataIndex ){ if ( data[7] == "C"){$(row).attr({ style:"color:Green",title:"This Inquiry is Solved / Completed" });} }
   });  }
  <?php }  ?>

   $('#panelupdate').hide(); 
    var tbl = 'si_inquiry_detail';
    var cntrl = '<?php echo $this->uri->segment(2); ?>';
    var tabs = $('#inquirytbl').DataTable({
    "processing": true, "serverSide": true,
    "lengthMenu": [[10, 50, 100, -1], [10, 50, 100, "All"]],"pageLength": 100,
    "order": [[ 0, "desc" ]],
        "ajax":  { 
      "data":{"select_inq": $("#select_inq").val(),"select_id" :"all" ,"datefrom" : $("input[id=datefrom]").val() ,"dateto" : $("input[id=dateto]").val(),"v": 0,"sms":"sms" },
    "url":"<?php echo base_url() . 'Admin/' . $this->uri->segment(2) . '/GetData'; ?>" },
    "aoColumnDefs": [{ 'bSortable': false, 'aTargets': [0,-1,-3] },{"targets": [-4],"visible": false }],
     //"columnDefs": [ {  "targets": -5, "createdCell": function (td, cellData, rowData, row, col) { if(cellData =="surat") { $(td).css('color', 'red') }}} ],
     "createdRow": function( row, data, dataIndex ){  if (data[7] == "C"){$(row).attr({ style:"color:Green",title:"This Inquiry is Solved / Completed" });} }
   });
   
  $('#select_inq').change(function(){  mydata(0);  }); 
  
   function mydata(v) { var select_inq =$('#select_inq').val();
     $('#inquirytbl').DataTable({"processing": true, "destroy": true, "serverSide": true,  
     "lengthMenu": [[10, 50, 100, -1], [10, 50, 100, "All"]], "pageLength": 100,"order": [[ 0, "desc" ]],
     "ajax":  { "data":{"select_inq": $("#select_inq").val() ,"select_id" :"all","v": v ,"datefrom" :$("input[id=datefrom]").val() ,"dateto" :$("input[id=dateto]").val(),"sms":"sms" },
   "url":"<?php echo base_url() . 'Admin/' . $this->uri->segment(2) . '/GetData'; ?>" },
   "aoColumnDefs": [{ 'bSortable': false, 'aTargets': [-1,-3,0] },{"targets": [-4],"visible": false }],
   
   "createdRow": function( row, data, dataIndex ){ if ( data[7] == "C"){$(row).attr({ style:"color:Green",title:"This Inquiry is Solved / Completed" });} }
   });} 
   
   
  $('.mydatepicker, #datepicker').datepicker({format: 'yyyy-mm-dd', todayHighlight: true,    });
  $("input[type='radio']").click(function() {
    /*  $('#follow-date').css('display', ($(this).val() === 'follow-date') ? 'block':'none');
    $('#cln').css('display', ($(this).val() === 'cln') ? 'block':'none');
    $('#gpdf').css('display', ($(this).val() === 'gpdf') ? 'block':'none');
    $('#qpc').css('display', ($(this).val() === 'qpc') ? 'block':'none');*/
  });

  function Today() { mydata(1);  }
  

     $('#inquirytbl>tbody,#inquirytbl_completed>tbody,#inquirytbl_pending>tbody').on('click', '.status', function (){
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
                type: 'get',
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
  
 $('#inquirytbl>tbody,#inquirytbl_completed>tbody,#inquirytbl_pending>tbody').on('click', '.delete', function () {
        var id = $(this).data('id');
        var st = $(this).data('status');
        var isst = $(this).data('isstatus');        
        if(isst=='D')
        {
            swal(
                        'Cancelled',
                        'Contact to Admin  :)',
                        'error'
                        );
        }
        else
        {
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
                type: 'get',
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
        }
    });
  
  
    $('#inquirytbl>tbody,#inquirytbl_completed>tbody,#inquirytbl_pending>tbody').on('click', '.whatsapp', function () {    
        $('#send_to').val($(this).data('id')); $('#numm').val($(this).data('id')); 
        $('#send_msg').val('Your Message Here');$('#send_to').attr('disabled','disabled');
        $("#smsModal").modal({backdrop: 'static', keyboard: false}); });
    
    function myf() { n= $("#numm").val();
    var msg = $("#send_msg").val().replace(" ", "%20");
    var e ="https://web.whatsapp.com:/send?phone=+91"+n+"&text="+msg+"%20https://www.saiinfotech.co/Shoppingcart";
    $('.adata_id').attr('href',e); }

      $('#inquirytbl>tbody,#inquirytbl_completed>tbody,#inquirytbl_pending>tbody').on('click', '.assign', function () {
     var id = $(this).data('id'); $("#hid_id").val(id); 
     $.ajax({   type:'POST', 
     url: '<?php echo base_url('Admin/Inquiry/assigned'); ?>',
       data : {'id': id}, dataType: 'json',
       success: function (Result) {
    $.ajax({ url: '<?php echo base_url('Admin/Inquiry/listAdmin'); ?>',
         dataType: 'json', success: function (dt) {  e=Result.assigned;     
     if((e=='') || (e==null)) { 
        op='<option value="" selected style="color:red"> Select Anyone to Assign </option>';
      $("#assign_id").html(op);  //console.log(data); 
      for (var i =0; i < dt.length; i++) {  var vk=dt[i]; 
             html='<option value="'+vk.id+'">'+vk.name+'</option>';
             $("#assign_id").append(html);   } 
       } else {  var   //console.log(Result.assigned);   
      op='<option value="" style="color:red"> Remove Assigned </option>';
      $("#assign_id").html(op);
      for (var i =0; i < dt.length; i++) {  var vk=dt[i];
      if(e==vk.id){ html='<option value="'+vk.id+'" selected  style="color:blue">'+vk.name+'</option>';
             $("#assign_id").append(html);  
       } else {  html='<option value="'+vk.id+'">'+vk.name+'</option>';
             $("#assign_id").append(html);  }}}}});
       $("#assignModal").modal({backdrop: 'static', keyboard: false});
        }});});
       </script> 
<script type="text/javascript" >
    $("#assign_form").submit(function (event) { event.preventDefault();
        var formData = new FormData($("#assign_form")[0]); 
      $.ajax({
        url: "<?php echo base_url(). 'AssignInquiry'; ?>", 
        type: 'POST', data: formData,
                contentType: false, processData: false,
         success: function (data) { 
         $('#assignModal').modal('hide');
         tabs.draw();
         },  error: function(){  alert("Something Went Wrong !! "); }
            });  return false; });
     </script> 
<script type="text/javascript">
      function swap() {
      document.getElementById('ctl00_ContentPlaceHolder1_testdiv1').style.display = 'none';
            document.getElementById('backwdth').style.display = 'none';
            location.href = 'index.html';
        }
      
</script> 
<script type="text/javascript" >
    $("#pdfff").submit(function (event) { event.preventDefault();
        var formData = new FormData($("#pdfff")[0]); 
      
              $.ajax({
        url: "<?php echo base_url("Admin/Inquiry/pdf_calci")?>", 
        type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
         success: function (data) 
                {   dt=data.replace(/"/g, ""); // console.log(dt);
                 $('#qpdf').val(dt);$('#qpdf_').val(dt);
           $('#myTab a[href="#add"]').tab('show');  
           $('#calci_modal').modal('hide');
        
          $('#dlt_bt').attr('pdf',dt); $('#dlt_bt').removeAttr('disabled');
          $('#dlt_bt').attr('title','Delete This PDF '+dt); 
          //----------------
          var pdf = $('#dlt_bt').attr('pdf');
          var id = $('#hid').attr('value');
           $.ajax({
                  url: '<?php echo base_url('Admin/Inquiry/UpdatePDF'); ?>',
                  data:{"id":id,"pdf":pdf}, dataType: 'json',
                success: function (res) {
          //saves------------
           }
           });
          ////----------------
         },
        error: function(){  alert("Something Went Wrong !! "); }
        });
        return false;
    });

      function cal33() {
    $("#n1").val($("#inquiry_name").val()); $("#n2").val($("#inquiry_address").val());
    $("#n3").val($("#inquiry_mobile").val()); $("#n4").val($("#inquiry_gstno").val());
    $("#n5").val($("#inquiry_firmname").val()); 
    }  


    </script>
</body>
</html>
<script type="text/javascript" language="javascript">
        function copydatatext(id) {
            if (id == "1" && document.getElementById('ctl00_ContentPlaceHolder1_CheckBox2').checked == true) {
                document.getElementById('ctl00_ContentPlaceHolder1_txtaddrresi').value = document.getElementById('ctl00_ContentPlaceHolder1_txtoaddrs').value;
                document.getElementById('ctl00_ContentPlaceHolder1_txtaddrresi').readOnly = true;
            }
            if (id == "2" && document.getElementById('ctl00_ContentPlaceHolder1_CheckBox2').checked == true) {
                document.getElementById('ctl00_ContentPlaceHolder1_txtcityresi').value = document.getElementById('ctl00_ContentPlaceHolder1_txtcityOffice').value;
                document.getElementById('ctl00_ContentPlaceHolder1_txtcityresi').readOnly = true;
            }
            if (id == "3" && document.getElementById('ctl00_ContentPlaceHolder1_CheckBox2').checked == true) {
                document.getElementById('ctl00_ContentPlaceHolder1_txtpinresi').value = document.getElementById('ctl00_ContentPlaceHolder1_txtpin').value;
                document.getElementById('ctl00_ContentPlaceHolder1_txtpinresi').readOnly = true;
            }
            if (id == "4" && document.getElementById('ctl00_ContentPlaceHolder1_CheckBox2').checked == true) {
                document.getElementById("ctl00_ContentPlaceHolder1_ddlstateresi").selectedIndex = document.getElementById('ctl00_ContentPlaceHolder1_ddlstate').selectedIndex;

            }
        }
        function OptionsSelected(id) {
         
           
            if (document.getElementById(id).checked == false) {
                document.getElementById('ctl00_ContentPlaceHolder1_txtaddrresi').value = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtaddrresi').readOnly = true;

                document.getElementById('ctl00_ContentPlaceHolder1_txtcityresi').value = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtcityresi').readOnly = true;

                document.getElementById('ctl00_ContentPlaceHolder1_txtpinresi').value = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtpinresi').readOnly = true;

                //document.getElementById("ctl00_ContentPlaceHolder1_ddlstateresi").selectedIndex = '';
 }
            else {

                document.getElementById('ctl00_ContentPlaceHolder1_txtaddrresi').value = document.getElementById('ctl00_ContentPlaceHolder1_txtoaddrs').value;
                document.getElementById('ctl00_ContentPlaceHolder1_txtaddrresi').readOnly = false;

                document.getElementById('ctl00_ContentPlaceHolder1_txtcityresi').value = document.getElementById('ctl00_ContentPlaceHolder1_txtcityOffice').value;
                document.getElementById('ctl00_ContentPlaceHolder1_txtcityresi').readOnly = false;

                document.getElementById('ctl00_ContentPlaceHolder1_txtpinresi').value = document.getElementById('ctl00_ContentPlaceHolder1_txtpin').value;
                document.getElementById('ctl00_ContentPlaceHolder1_txtpinresi').readOnly = false;

                document.getElementById("ctl00_ContentPlaceHolder1_ddlstateresi").selectedIndex = document.getElementById('ctl00_ContentPlaceHolder1_ddlstate').selectedIndex;

            }
        }

       
        function showtbl() {

            var paybaltota = document.getElementById('lblAmtPayble').value;
            document.getElementById("ctl00_ContentPlaceHolder1_tblhead").style.display = '';
            document.getElementById("ctl00_ContentPlaceHolder1_tblServicesTaxPay").style.display = '';
            //document.getElementById("ctl00_ContentPlaceHolder1_tblGrossAmountPay").style.display = '';
            //document.getElementById("ctl00_ContentPlaceHolder1_tblVATCSTPay").style.display = '';
            document.getElementById("ctl00_ContentPlaceHolder1_tblAmountPayablePay").style.display = '';
            //document.getElementById("ctl00_ContentPlaceHolder1_tblSwachhBharat").style.display = '';
            //document.getElementById("ctl00_ContentPlaceHolder1_tblKrishiKalyan").style.display = '';

            //document.getElementById("ctl00_ContentPlaceHolder1_tblAmountClientCASS").style.display = '';
           // document.getElementById("ctl00_ContentPlaceHolder1_tblAmountClientService").style.display = '';
            //document.getElementById("tblAmountTotalWithClient").style.display = '';
           // document.getElementById("tblAmountTotalPaybaleWithClient").style.display = '';
            
            
            //document.getElementById("tbldetailsbank").style.display = '';
          
            document.getElementById("tblTotalAmount").style.display = '';

            if (document.getElementById("ddlSelectProduct").value == 1 && document.getElementById("ddlSelectPurchseType").value == 0) {
                document.getElementById("tblGenius").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI1').value = 10000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ1').value = 1;
            }
           //if (document.getElementById("ctl00_ContentPlaceHolder1_").value == 1) {
           //     document.getElementById("tblGenius").style.display = '';
           //     document.getElementById('ctl00_ContentPlaceHolder1_txtI1').value = 7000;
           //     document.getElementById('ctl00_ContentPlaceHolder1_txtQ1').value = 1;

           //     document.getElementById("ctl00_ContentPlaceHolder1_tblGenGSTIns").style.display = '';
           //     document.getElementById('ctl00_ContentPlaceHolder1_txtI61').value = 4000;
           //     document.getElementById('ctl00_ContentPlaceHolder1_txtQ61').value = 1;
           // }

            if (document.getElementById("ddlSelectProduct").value == 1 && document.getElementById("ddlSelectPurchseType").value == 1) {
                document.getElementById("tblGeniusUP").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI25').value = 4000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ25').value = 1;
            }


            if (document.getElementById("ddlSelectProduct").value == 2 && document.getElementById("ddlSelectPurchseType").value == 0) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblPayroll").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI2').value = 15000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ2').value = 1;
            }

            if (document.getElementById("ddlSelectProduct").value == 2 && document.getElementById("ddlSelectPurchseType").value == 1) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblPayrollUP").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI26').value = 4000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ26').value = 1;
            }

            if (document.getElementById("ddlSelectProduct").value == 3 && document.getElementById("ddlSelectPurchseType").value == 0) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblPayrollOnline").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI3').value = 20000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ3').value = 1;
            }

            if (document.getElementById("ddlSelectProduct").value == 3 && document.getElementById("ddlSelectPurchseType").value == 1) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblPayrollOnlineUP").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI27').value = 5000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ27').value = 1;
            }

            if (document.getElementById("ddlSelectProduct").value == 4 && document.getElementById("ddlSelectPurchseType").value == 0) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblCompLaw").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI4').value = 15000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ4').value = 1;
            }

            if (document.getElementById("ddlSelectProduct").value == 4 && document.getElementById("ddlSelectPurchseType").value == 1) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblCompLawUP").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI28').value = 4000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ28').value = 1;
            }
            if (document.getElementById("ddlSelectProduct").value == 5 && document.getElementById("ddlSelectPurchseType").value == 0) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblCompLawWXBRL").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI5').value = 10000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ5').value = 1;
            }

            if (document.getElementById("ddlSelectProduct").value == 5 && document.getElementById("ddlSelectPurchseType").value == 1) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblCompLawWXBRLUP").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI29').value = 3000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ29').value = 1;
            }

            if (document.getElementById("ddlSelectProduct").value == 6 && document.getElementById("ddlSelectPurchseType").value == 0) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenAVAT").style.display = '';
                //if (document.getElementById('ctl00_ContentPlaceHolder1_Avat').checked) {
                document.getElementById('ctl00_ContentPlaceHolder1_txtI6').value = 10000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ6').value = 1;
                //} else {
                // document.getElementById('ctl00_ContentPlaceHolder1_txtI6').value = 10000;
                //document.getElementById('ctl00_ContentPlaceHolder1_txtQ6').value = 1;
                //}
            }

            if (document.getElementById("ddlSelectProduct").value == 6 && document.getElementById("ddlSelectPurchseType").value == 1) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenAVATUP").style.display = '';
                //if (document.getElementById('ctl00_ContentPlaceHolder1_Avat1').checked) {
                //document.getElementById('ctl00_ContentPlaceHolder1_txtI30').value = 2000;
                //document.getElementById('ctl00_ContentPlaceHolder1_txtQ30').value = 1;
                //} else {
                document.getElementById('ctl00_ContentPlaceHolder1_txtI30').value = 3000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ30').value = 1;
                //}
            }
            if (document.getElementById("ddlSelectProduct").value == 24 && document.getElementById("ddlSelectPurchseType").value == 0) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenAVATSingle").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI46').value = 5000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ46').value = 1;
            }
            if (document.getElementById("ddlSelectProduct").value == 24 && document.getElementById("ddlSelectPurchseType").value == 1) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenAVATUPSingle").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI47').value = 2000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ47').value = 1;
            }
            if (document.getElementById("ddlSelectProduct").value == 7 && document.getElementById("ddlSelectPurchseType").value == 0) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblPaperLessOffice").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI7').value = 11000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ7').value = 1;
            }

            if (document.getElementById("ddlSelectProduct").value == 7 && document.getElementById("ddlSelectPurchseType").value == 1) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblPaperLessOfficeUP").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI31').value = 8000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ31').value = 1;
            }
            if (document.getElementById("ddlSelectProduct").value == 8 && document.getElementById("ddlSelectPurchseType").value == 0) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenSmartShoppee").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI8').value = 10000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ8').value = 1;
            }

            if (document.getElementById("ddlSelectProduct").value == 8 && document.getElementById("ddlSelectPurchseType").value == 1) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenSmartShoppeeUP").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI32').value = 2500;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ32').value = 1;
            }
            if (document.getElementById("ddlSelectProduct").value == 9 && document.getElementById("ddlSelectPurchseType").value == 0) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenInvestor").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI9').value = 2000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ9').value = 1;
            }

            if (document.getElementById("ddlSelectProduct").value == 9 && document.getElementById("ddlSelectPurchseType").value == 1) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenInvestorUP").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI33').value = 1000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ33').value = 1;
            }
            if (document.getElementById("ddlSelectProduct").value == 10 && document.getElementById("ddlSelectPurchseType").value == 0) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenXBRL").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI10').value = 10000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ10').value = 1;
            }

            if (document.getElementById("ddlSelectProduct").value == 10 && document.getElementById("ddlSelectPurchseType").value == 1) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenXBRLUP").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI34').value = 2500;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ34').value = 1;
            }
            if (document.getElementById("ddlSelectProduct").value == 11 && document.getElementById("ddlSelectPurchseType").value == 0) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenRVAT").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI11').value = 4000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ11').value = 1;
            }

            if (document.getElementById("ddlSelectProduct").value == 11 && document.getElementById("ddlSelectPurchseType").value == 1) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenRVATUP").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI35').value = 1500;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ35').value = 1;
            }
            if (document.getElementById("ddlSelectProduct").value == 12 && document.getElementById("ddlSelectPurchseType").value == 0) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenIT").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI12').value = 4500;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ12').value = 1;
            }

            if (document.getElementById("ddlSelectProduct").value == 12 && document.getElementById("ddlSelectPurchseType").value == 1) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenITUP").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI36').value = 2000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ36').value = 1;
            }
            if (document.getElementById("ddlSelectProduct").value == 13 && document.getElementById("ddlSelectPurchseType").value == 0) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenCMA").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI13').value = 2000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ13').value = 1;
            }

            if (document.getElementById("ddlSelectProduct").value == 13 && document.getElementById("ddlSelectPurchseType").value == 1) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenCMAUP").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI37').value = 500;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ37').value = 1;
            }
            if (document.getElementById("ddlSelectProduct").value == 14 && document.getElementById("ddlSelectPurchseType").value == 0) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenBal").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI14').value = 5000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ14').value = 1;
            }

            if (document.getElementById("ddlSelectProduct").value == 14 && document.getElementById("ddlSelectPurchseType").value == 1) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenBalUP").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI38').value = 2500;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ38').value = 1;
            }
            if (document.getElementById("ddlSelectProduct").value == 15 && document.getElementById("ddlSelectPurchseType").value == 0) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenFormManager").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI15').value = 1500;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ15').value = 1;
            }

            if (document.getElementById("ddlSelectProduct").value == 15 && document.getElementById("ddlSelectPurchseType").value == 1) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenFormManagerUP").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI39').value = 500;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ39').value = 1;
            }
            if (document.getElementById("ddlSelectProduct").value == 16 && document.getElementById("ddlSelectPurchseType").value == 0) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenTDS").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI16').value = 3500;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ16').value = 1;
            }

            if (document.getElementById("ddlSelectProduct").value == 16 && document.getElementById("ddlSelectPurchseType").value == 1) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenTDSUP").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI40').value = 1500;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ40').value = 1;
            }
            if (document.getElementById("ddlSelectProduct").value == 17 && document.getElementById("ddlSelectPurchseType").value == 0) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenServiceTax").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI17').value = 3500;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ17').value = 1;
            }

            if (document.getElementById("ddlSelectProduct").value == 17 && document.getElementById("ddlSelectPurchseType").value == 1) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenServiceTaxUP").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI41').value = 1500;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ41').value = 1;
            }
            if (document.getElementById("ddlSelectProduct").value == 18 && document.getElementById("ddlSelectPurchseType").value == 0) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenSmartBill").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI18').value = 5000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ18').value = 1;
            }

            if (document.getElementById("ddlSelectProduct").value == 18 && document.getElementById("ddlSelectPurchseType").value == 1) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenSmartBillUP").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI42').value = 2000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ42').value = 1;
            }

            if (document.getElementById("ddlSelectProduct").value == 19 && document.getElementById("ddlSelectPurchseType").value == 0) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenXDExcise").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI19').value = 10000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ19').value = 1;
            }

            if (document.getElementById("ddlSelectProduct").value == 19 && document.getElementById("ddlSelectPurchseType").value == 1) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenXDExciseUP").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI43').value = 3000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ43').value = 1;
            }

            if (document.getElementById("ddlSelectProduct").value == 20 && document.getElementById("ddlSelectPurchseType").value == 0) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblPCSpy").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI20').value = 5000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ20').value = 1;
            }

            if (document.getElementById("ddlSelectProduct").value == 20 && document.getElementById("ddlSelectPurchseType").value == 1) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblPCSpyUP").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI44').value = 2000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ44').value = 1;
            }

            if (document.getElementById("ddlSelectProduct").value == 21 && document.getElementById("ddlSelectPurchseType").value == 0) {

                document.getElementById("ctl00_ContentPlaceHolder1_tblAuditor").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI21').value = 5000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ21').value = 1;
            }

            if (document.getElementById("ddlSelectProduct").value == 21 && document.getElementById("ddlSelectPurchseType").value == 1) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblAuditorUP").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI45').value = 2000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ45').value = 1;
            }

            if (document.getElementById("ddlSelectProduct").value == 22 && document.getElementById("ddlSelectPurchseType").value == 0) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblLaptop1").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI56').value = 2000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ56').value = 1;
            }

            if (document.getElementById("ddlSelectProduct").value == 22 && document.getElementById("ddlSelectPurchseType").value == 1) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblLaptop1").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI56').value = 2000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ56').value = 1;
            }

            if (document.getElementById("ddlSelectProduct").value == 23 && document.getElementById("ddlSelectPurchseType").value == 0) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblLANCopy").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI23').value = 500;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ23').value = 1;
            }

            if (document.getElementById("ddlSelectProduct").value == 23 && document.getElementById("ddlSelectPurchseType").value == 1) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblLANCopy").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI23').value = 500;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ23').value = 1;
            }
            if (document.getElementById("ddlSelectProduct").value == 25 && document.getElementById("ddlSelectPurchseType").value == 0) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblProjectFinanceIns").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI48').value = 10000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ48').value = 1;
            }
            if (document.getElementById("ddlSelectProduct").value == 25 && document.getElementById("ddlSelectPurchseType").value == 1) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblProjectFinanceUp").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI49').value = 3000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ49').value = 1;
            }

            if (document.getElementById("ddlSelectProduct").value == 26 && document.getElementById("ddlSelectPurchseType").value == 0) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblBulkVeri").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI50').value = 3000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ50').value = 1;
            }

            if (document.getElementById("ddlSelectProduct").value == 26 && document.getElementById("ddlSelectPurchseType").value == 1) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblBulkVeriUp").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI54').value = 2000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ54').value = 1;
            }
            if (document.getElementById("ddlSelectProduct").value == 27 && document.getElementById("ddlSelectPurchseType").value == 0) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblBulkSms").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI51').value = 1500;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ51').value = 1;

            }

            if (document.getElementById("ddlSelectProduct").value == 27 && document.getElementById("ddlSelectPurchseType").value == 1) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblBulkSms").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI51').value = 1500;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ51').value = 1;

            }
            if (document.getElementById("ddlSelectProduct").value == 28 && document.getElementById("ddlSelectPurchseType").value == 0) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblPortalIns").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI52').value = 10000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ52').value = 1;
            }

            if (document.getElementById("ddlSelectProduct").value == 28 && document.getElementById("ddlSelectPurchseType").value == 1) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblPortalUp").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI53').value = 5000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ53').value = 1;
            }
            if (document.getElementById("ddlSelectProduct").value == 29 && document.getElementById("ddlSelectPurchseType").value == 0) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenTimelog").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI55').value = 5000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ55').value = 1;
            }
            if (document.getElementById("ddlSelectProduct").value == 29 && document.getElementById("ddlSelectPurchseType").value == 1) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenTimelog").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI55').value = 5000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ55').value = 1;
            }
            if (document.getElementById("ddlSelectProduct").value == 30 && document.getElementById("ddlSelectPurchseType").value == 0) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblPortalAppIns").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI57').value = 5000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ57').value = 1;
            }
            if (document.getElementById("ddlSelectProduct").value == 30 && document.getElementById("ddlSelectPurchseType").value == 1) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblPortalAppUp").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI58').value = 2500;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ58').value = 1;
            }
            if (document.getElementById("ddlSelectProduct").value == 31 && document.getElementById("ddlSelectPurchseType").value == 0) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblPortalIOSAppIns").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI59').value = 5000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ59').value = 1;
            }
            if (document.getElementById("ddlSelectProduct").value == 31 && document.getElementById("ddlSelectPurchseType").value == 1) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblPortalIOSAppUp").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI60').value = 2500;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ60').value = 1;
            }
            if (document.getElementById("ddlSelectProduct").value == 32 && document.getElementById("ddlSelectPurchseType").value == 0) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenGSTIns").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI61').value = 5000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ61').value = 1;
            }
            if (document.getElementById("ddlSelectProduct").value == 32 && document.getElementById("ddlSelectPurchseType").value == 1) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenGSTUp").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI62').value = 2000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ62').value = 1;
            }
            if (document.getElementById("ddlSelectProduct").value == 33 && document.getElementById("ddlSelectPurchseType").value == 0) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenGSTCludIns").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI63').value = 25000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ63').value = 1;
            }
            if (document.getElementById("ddlSelectProduct").value == 33 && document.getElementById("ddlSelectPurchseType").value == 1) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenGSTCludUp").style.display = '';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI64').value = 10000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ64').value = 1;
            }
        calcProduct();
        }

        function showtblremove(ttt) {
            if (ttt == 1) {
                document.getElementById("tblGenius").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI1').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ1').value = 0;
            }
            if (ttt == 2) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblPayroll").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI2').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ2').value = 0;
            }
            if (ttt == 3) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblPayrollOnline").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI3').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ3').value = 0;
            }
            if (ttt == 4) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblCompLaw").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI4').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ4').value = 0;
            }
            if (ttt == 5) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblCompLawWXBRL").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI5').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ5').value = 0;
            }
            if (ttt == 6) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenAVAT").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI6').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ6').value = 0;
            }
            if (ttt == 7) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblPaperLessOffice").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI7').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ7').value = 0;
            }
            if (ttt == 8) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenSmartShoppee").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI8').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ8').value = 0;
            }
            if (ttt == 9) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenInvestor").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI9').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ9').value = 0;
            }
            if (ttt == 10) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenXBRL").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI10').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ10').value = 0;
            }
            if (ttt == 11) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenRVAT").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI11').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ11').value = 0;
            }
            if (ttt == 12) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenIT").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI12').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ12').value = 0;
            }
            if (ttt == 13) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenCMA").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI13').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ13').value = 0;
            }
            if (ttt == 14) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenBal").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI14').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ14').value = 0;
            }
            if (ttt == 15) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenFormManager").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI15').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ15').value = 0;
            }
            if (ttt == 16) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenTDS").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI16').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ16').value = 0;
            }
            if (ttt == 17) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenServiceTax").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI17').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ17').value = 0;
            }
            if (ttt == 18) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenSmartBill").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI18').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ18').value = 0;
            }
            if (ttt == 19) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenXDExcise").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI19').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ19').value = 0;
            }
            if (ttt == 20) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblPCSpy").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI20').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ20').value = 0;
            }
            if (ttt == 21) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblAuditor").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI21').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ21').value = 0;
            }
            if (ttt == 22) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblLaptopCopy").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI22').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ22').value = 0;
            }
            if (ttt == 23) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblLANCopy").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI23').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ23').value = 0;
            }
            if (ttt == 25) {
                document.getElementById("tblGeniusUP").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI25').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ25').value = 0;
            }
            if (ttt == 26) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblPayrollUP").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI26').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ26').value = 0;
            }
            if (ttt == 27) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblPayrollOnlineUP").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI27').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ27').value = 0;
            }
            if (ttt == 28) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblCompLawUP").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI28').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ28').value = 0;
            }
            if (ttt == 29) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblCompLawWXBRLUP").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI29').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ29').value = 0;
            }
            if (ttt == 30) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenAVATUP").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI30').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ30').value = 0;
            }
            if (ttt == 31) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblPaperLessOfficeUP").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI31').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ31').value = 0;
            }
            if (ttt == 32) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenSmartShoppeeUP").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI32').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ32').value = 0;
            }
            if (ttt == 33) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenInvestorUP").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI33').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ33').value = 0;
            }
            if (ttt == 34) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenXBRLUP").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI34').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ34').value = 0;
            }
            if (ttt == 35) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenRVATUP").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI35').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ35').value = 0;
            }
            if (ttt == 36) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenITUP").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI36').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ36').value = 0;
            }
            if (ttt == 37) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenCMAUP").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI37').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ37').value = 0;
            }
            if (ttt == 38) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenBalUP").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI38').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ38').value = 0;
            }
            if (ttt == 39) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenFormManagerUP").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI39').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ39').value = 0;
            }
            if (ttt == 40) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenTDSUP").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI40').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ40').value = 0;
            }
            if (ttt == 41) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenServiceTaxUP").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI41').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ41').value = 0;
            }
            if (ttt == 42) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenSmartBillUP").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI42').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ42').value = 0;
            }
            if (ttt == 43) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenXDExciseUP").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI43').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ43').value = 0;
            }
            if (ttt == 44) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblPCSpyUP").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI44').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ44').value = 0;
            }
            if (ttt == 45) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblAuditorUP").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI45').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ45').value = 0;
            }
            if (ttt == 46) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenAVATSingle").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI46').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ46').value = 0;
            }
            if (ttt == 47) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenAVATUPSingle").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI47').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ47').value = 0;
            }
            if (ttt == 48) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblProjectFinanceIns").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI48').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ48').value = 0;
            }
            if (ttt == 49) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblProjectFinanceUp").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI49').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ49').value = 0;
            }
            if (ttt == 50) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblBulkVeri").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI50').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ50').value = 0;
            }
            if (ttt == 51) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblBulkSms").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI51').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ51').value = 0;
            }
            if (ttt == 52) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblPortalIns").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI52').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ52').value = 0;
            }
            if (ttt == 53) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblPortalUp").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI53').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ53').value = 0;
            }
            if (ttt == 54) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblBulkVeriUp").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI54').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ54').value = 0;
            }
            if (ttt == 55) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenTimelog").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI55').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ55').value = 0;
            }
            if (ttt == 56) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblLaptop1").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI56').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ56').value = 0;
            }
            if (ttt == 57) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblPortalAppIns").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI57').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ57').value = 0;
            }
            if (ttt == 58) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblPortalAppUp").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI58').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ58').value = 0;
            }
            if (ttt == 59) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblPortalIOSAppIns").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI59').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ59').value = 0;
            }
            if (ttt == 60) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblPortalIOSAppUp").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI60').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ60').value = 0;
            }

            if (ttt == 61) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenGSTIns").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI61').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ61').value = 0;
            }
            if (ttt == 62) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenGSTUp").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI62').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ62').value = 0;
            }
            if (ttt == 63) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenGSTCludIns").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI63').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ63').value = 0;
            }
            if (ttt == 64) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblGenGSTCludUp").style.display = 'none';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI64').value = 0;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ64').value = 0;
            }
           
            calcProduct();

            if (document.getElementById('lblAmtPayble').value == 0) {
                document.getElementById("ctl00_ContentPlaceHolder1_tblhead").style.display = 'none';
                document.getElementById("ctl00_ContentPlaceHolder1_tblServicesTaxPay").style.display = 'none';
                //document.getElementById("ctl00_ContentPlaceHolder1_tblGrossAmountPay").style.display = 'none';
                //document.getElementById("ctl00_ContentPlaceHolder1_tblVATCSTPay").style.display = 'none';
                document.getElementById("ctl00_ContentPlaceHolder1_tblAmountPayablePay").style.display = 'none';
                //document.getElementById("ctl00_ContentPlaceHolder1_tblSwachhBharat").style.display = 'none';
                //document.getElementById("ctl00_ContentPlaceHolder1_tblKrishiKalyan").style.display = 'none';
                //document.getElementById("tbldetailsbank").style.display = 'none';
                document.getElementById("SubmitbtnPay").style.display = 'none';
                document.getElementById("tblTotalAmount").style.display = 'none';

                //document.getElementById("ctl00_ContentPlaceHolder1_tblAmountClientCASS").style.display = 'none';
                //document.getElementById("ctl00_ContentPlaceHolder1_tblAmountClientService").style.display = 'none';
                //document.getElementById("tblAmountTotalWithClient").style.display = 'none';
                //document.getElementById("tblAmountTotalPaybaleWithClient").style.display = 'none';
            }
        }



        function calcProduct() {

            for (i = 1; i <= 64; i++) {
                var instl = document.getElementById('ctl00_ContentPlaceHolder1_txtI' + i).value;
                var upd = document.getElementById('ctl00_ContentPlaceHolder1_txtQ' + i).value;
                document.getElementById('ctl00_ContentPlaceHolder1_lblL' + i).value = parseInt(instl) * parseInt(upd);
                instl = ""; upd = "";
                if (i == 51) {
                    document.getElementById('ctl00_ContentPlaceHolder1_lblBulkSms').value = 'Bulk SMS (' + parseInt(5000) * parseInt(document.getElementById('ctl00_ContentPlaceHolder1_txtQ' + i).value) + ' SMS)';
                }
            }

            var ttlInstl = "0", ttlUpd = "0"; ttlTtl = "0";

            for (j = 1; j < 65; j++) {

                ttlInstl = parseInt(ttlInstl) + parseInt(document.getElementById('ctl00_ContentPlaceHolder1_txtI' + j).value);
                ttlUpd = parseInt(ttlUpd) + parseInt(document.getElementById('ctl00_ContentPlaceHolder1_txtQ' + j).value);
                ttlTtl = parseInt(ttlTtl) + parseInt(document.getElementById('ctl00_ContentPlaceHolder1_lblL' + j).value);

            }
            var ttlDiscount = document.getElementById('ctl00_ContentPlaceHolder1_txtI24').value;
            document.getElementById('ctl00_ContentPlaceHolder1_lblL24').value = ttlDiscount;


            //            document.getElementById('lblInstTtl').value = parseInt(ttlInstl) - parseInt(ttlDiscount);
            //            document.getElementById('lblUpdTtl').value = ttlUpd;
            document.getElementById('ctl00_ContentPlaceHolder1_lblTtlTtl').value = parseInt(ttlTtl) - parseInt(ttlDiscount);

            ttlTtl = "";
            ttlTtl = document.getElementById('ctl00_ContentPlaceHolder1_lblTtlTtl').value;

            var ttlST = (parseInt(ttlTtl) * 18.00) / 100;
           
            document.getElementById('ctl00_ContentPlaceHolder1_lblST').value = parseInt(Math.round(ttlST));
    
            //document.getElementById('ctl00_ContentPlaceHolder1_lblGAmt').value = parseInt(Math.round(ttlTtl)) + parseInt(Math.round(ttlST));
            //var bulksmstotal = parseInt(document.getElementById('ctl00_ContentPlaceHolder1_lblL51').value);
           
            //bulksmstotal = bulksmstotal + (parseInt(bulksmstotal) / 100) * 15;
            //var bulksmstotalvat = (parseInt(bulksmstotal)* 5.50) / 100;
            //var ttlVAT = (parseInt(document.getElementById('ctl00_ContentPlaceHolder1_lblGAmt').value) * 5.50) / 100;
            //ttlVAT = ttlVAT - (parseInt(document.getElementById('ctl00_ContentPlaceHolder1_txtQ51').value) * 94.90);
           // ttlVAT = ttlVAT - bulksmstotalvat;
           
            document.getElementById('lblAmtPayble').value = parseInt(Math.round(ttlTtl)) + parseInt(Math.round(ttlST));
            //document.getElementById('ctl00_ContentPlaceHolder1_txtClientCass').value = Math.round((document.getElementById('lblAmtPayble').value * 2) / 100);
            //document.getElementById('ctl00_ContentPlaceHolder1_txtClientServiceTax').value = Math.round((document.getElementById('ctl00_ContentPlaceHolder1_txtClientCass').value * 15) / 100);
           //document.getElementById('txtCleintTotalPay').value = Math.round((document.getElementById('lblAmtPayble').value / 97.64) * 100) - document.getElementById('lblAmtPayble').value;
            //document.getElementById('txtCleintTotalAmountPayble').value = Math.round((document.getElementById('lblAmtPayble').value / 97.64) * 100);
            
        }



        function quantity(p) {
            //alert(p);
            aa = parseInt(document.getElementById('ctl00_ContentPlaceHolder1_txtI' + p).value);
            if (aa > 0) {
                bb = parseInt(document.getElementById('ctl00_ContentPlaceHolder1_txtQ' + p).value);
                if (bb == 0) {
                    document.getElementById('ctl00_ContentPlaceHolder1_txtQ' + p).value = 1;
                }
            }
            calcProduct();
        }

        function blanck(e) {
            var KeyID = (window.event) ? event.keyCode : e.which;
            return (KeyID == 1);
        }

        function numbersonly(e, decimal) {
            var key;
            var keychar;

            if (window.event) {
                key = window.event.keyCode;
            }
            else if (e) {
                key = e.which;
            }
            else {
                return true;
            }
            keychar = String.fromCharCode(key);

            if ((key == null) || (key == 0) || (key == 8) || (key == 9) || (key == 27) || (key == 190)) {
                return true;
            }
            else if ((("0123456789").indexOf(keychar) > -1)) {
                return true;
            }
            //            else if (decimal && (keychar == ".")) {
            //                return true;
            //            }
            else
                return false;
        }



        function toggleDropDownList(source) {
            if (document.getElementById('ctl00_ContentPlaceHolder1_Avat').checked == 1) {
                document.getElementById('ctl00_ContentPlaceHolder1_DropDownList1').disabled = !source.checked;


                document.getElementById('ctl00_ContentPlaceHolder1_Label1').innerHTML = '5000/-';
                document.getElementById('ctl00_ContentPlaceHolder1_lblUp6').innerHTML = '1500/-';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI6').value = 5000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ6').value = 1;
            }
            else {
                // document.getElementById('DropDownList1').enable = !source.checked;
                document.getElementById('ctl00_ContentPlaceHolder1_Label1').innerHTML = '10000/-';
                document.getElementById('ctl00_ContentPlaceHolder1_lblUp6').innerHTML = '3000/-';
                document.getElementById('ctl00_ContentPlaceHolder1_DropDownList1').disabled = !document.getElementById('ctl00_ContentPlaceHolder1_DropDownList1').disabled;
                document.getElementById('ctl00_ContentPlaceHolder1_txtI6').value = 10000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ6').value = 1;
            }
            showtbl();
            //var dd=document.getElementById('Avat').value;    
            //alert(dd);
        }

        function LancopyProduct() {
            document.getElementById('ctl00_ContentPlaceHolder1_lblProduID56').innerHTML = document.getElementById("ctl00_ContentPlaceHolder1_ddllaptop").value;
        }
        function toggleDropDownList1(source) {
            if (document.getElementById('ctl00_ContentPlaceHolder1_Avat1').checked == 1) {
                document.getElementById('ctl00_ContentPlaceHolder1_DropDownList11').disabled = !source.checked;
                document.getElementById('ctl00_ContentPlaceHolder1_Label11').innerHTML = '5000/-';
                document.getElementById('ctl00_ContentPlaceHolder1_lblUp30').innerHTML = '1500/-';
                document.getElementById('ctl00_ContentPlaceHolder1_txtI30').value = 1500;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ30').value = 1;
            }
            else {
                // document.getElementById('DropDownList1').enable = !source.checked;
                document.getElementById('ctl00_ContentPlaceHolder1_Label11').innerHTML = '10000/-';
                document.getElementById('ctl00_ContentPlaceHolder1_lblUp30').innerHTML = '3000/-';
                document.getElementById('ctl00_ContentPlaceHolder1_DropDownList11').disabled = !document.getElementById('ctl00_ContentPlaceHolder1_DropDownList11').disabled;
                document.getElementById('ctl00_ContentPlaceHolder1_txtI30').value = 3000;
                document.getElementById('ctl00_ContentPlaceHolder1_txtQ30').value = 1;

            }
            showtbl();
            //var dd=document.getElementById('Avat').value;    
            //alert(dd);
        }
     
    </script>
<script type="text/javascript">
      function swap() {
      document.getElementById('ctl00_ContentPlaceHolder1_testdiv1').style.display = 'none';
            document.getElementById('backwdth').style.display = 'none';
            location.href = 'index.html';
          }
      </script>
<script type="text/javascript">
//<![CDATA[
function WebForm_OnSubmit() {
if (typeof(ValidatorOnSubmit) == "function" && ValidatorOnSubmit() == false) return false;
    return true;
}
//]]>
</script>

<script>
 $(document).ready(function(){
  $("#selUser").select2({
    placeholder: "Search Customer By Firm Name, Mobile or Email!!",
    width:"100%",
                ajax: {
                    url: '<?php echo base_url('Search-Customer-And-Select'); ?>',
                    type: "post",
                    dataType: 'json',
                    delay: 250,
                     data: function (params) {
                        return {
                            searchTerm: params.term // search term
                        };
                    },
                    processResults: function (response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
 
                }
            });
        });

 $("#selUser").change(function() {
    var id = $("#selUser").val(); // works
    //var Selected = $("#selUser").find('option:selected').text(); //  works
   // alert("This is ID :"+Id+" And This is Selected Text : " + Selected);
    
   $.ajax({
    type:"POST",
    url: "<?php echo base_url('Fill-Existing-Data-Inquiry-Form'); ?>",
    data:{id:id},
    dataType:"json",
    success: function(data){
      console.log(data);

       $('#inquiry_city_a').val(data.c);
       $('#inquiry_name_a').val(data.n);
       $('#inquiry_firmname_a').val(data.f);
      $('#inquiry_email_a').val(data.e);
      $('#inquiry_gstno_a').val(data.g); 
      $('#inquiry_mobile_a').val(data.m); 
      $('#inquiry_address_a').val(data.a);
      $('#inquiry_other_no_a').val(data.m1);
        
    },error:function() { alert("Something Went Wrong !!");}


   });
    });
 $('#interest_product,#interest_product_a,#li').on('blur', function() {    
    var v = $(this).val();   num =/^[0-9]*$/; 
    if(v!=null) {  if(num.test(v) == false || v.length > 2) { alert("Please Input Only Number in Interest % "); $(this).val(''); return false; } }
    });

</script>
<script type="text/javascript">
                            function addnum_e()  {  var nn = $('.ZYOCISW_e').length
                  if(nn==5){ alert("You can add maximum 5 Numbers"); return false }
                  else {
                  var nm=nn+1;
                  var r_str = "";  //var s = "abc4def1gh7ijk9l0mn8op3qrstu2vw5x6yz";
                  var s = "123456789987654321";
                 for (var i = 0; i < 10; i++) { r_str += s.charAt(Math.floor(Math.random() * s.length)); }  console.log(r_str);
                 
                html='<div class="ZYOCISW_e ae'+r_str+' form-group col-sm-9"><div class="input-group"><input class="form-control" name="iq_mob_e'+nm+'" id="iq_mob_e'+nm+'" placeholder="Mobile / Landline Number" type="text" required><div class="input-group-addon">Mobile / Landline Number <i class="fa fa-mobile"></i></div></div></div><div class="FPNHYTU_e ae'+r_str+' form-group col-sm-3"><div class="input-group"><input type="button" class="btn btn-danger btn-outline" onClick="removenum_e('+r_str+');" value=" - Remove This"></div></div>';
              $('#af_div_e').after(html); 
              
                  }
              }
              
              ///------------------
   

     $("#sms_form").submit(function (event) { event.preventDefault();
          var mob= $("input[id=mobb]").val();
            var msg=  $('textarea#send_msg1').val();  
            if (msg.length< 5 ) {  
                  $(".modal-title").html("<marquee style='color:red'>Too Short Message</marquee>"); 
                  $('#send_msg:visible').first().focus(); return false
                           }
                   
                  var selected = [];$(".select:checked").each(function() { selected.push($(this).val()); });
                  var Con1 = confirm("Do You Want to Send SMS to  "+ selected.length +" Selected Customer ??  "); 
                  if(Con1 == true) { 
                        alert("You're Going to Send SMS to All  !! ");   
                                } 
                  else { 
                        $('#smsModal1').modal('hide'); return false
                      }

                 var formData = new FormData($("#sms_form")[0]);

          $.ajax({
                url: "<?php echo base_url().'Send-SMS'; ?>",
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (data)  {
          $('#smsModal1').modal('hide');
        setTimeout(function () { alert("You've Sent SMS Successfully !!! "); }, 2000);
        },
         //setTimeout(function () {  $("#errdiv").hide();  }, 5000);
        error: function(){  alert("Something Went Wrong !!! "); }
        });
        return false;
    });
  




  ///-------------------------------   
       function selectAll(source) {
            checkboxes = document.getElementsByName('id[]');
            for (var i = 0, n=checkboxes.length; i < n; i++) {
            checkboxes[i].checked = source.checked; }
          }
 
  
      ///-------------- Send Multiple ( Bulk ) SMS ------
   function send_multi_sms() { 
                $('#send_to').removeAttr("disabled");
                var selected = [];
            $(".select:checked").each(function() {selected.push($(this).val()); });
            var cn = [];$(".select:checked").each(function() { cn.push($(this).attr("cn")); });

                var c = selected.length;
                if( c < 1){
                 alert("You've not selected  !!! "); return false
                   }
                else {
                $('#send_msg').val(''); 
                $('.modal-title').html('Customer Number List');
                $("#smsModal1").modal({backdrop: 'static', keyboard: false});
            $("#send_sms_btn").html('Send Bulk SMS');
            $("#mobb").val(selected);
            $("#send_to1").attr({ 'style':'background-color : #d9c3e5', 'type':'button', 'cu':''+selected+'', 'cn':''+cn+'', 'class':'seeNumber form-control', 'value':'Total '+ c+' Customer' });
                   }
      }
    
    ////----------------------


          function removenum_e(r_str){  $('.ae'+r_str).remove(); }
                            
                            </script>