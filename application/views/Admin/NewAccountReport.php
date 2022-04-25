<html>
<head>
<?php $this->load->view('template/headerlink'); ?>
</head>
<body class="fix-header">
<div id="wrapper">
  <?php $this->load->view('template/header'); ?>
  <?php $this->load->view('template/sidebar'); ?>
  <div id="page-wrapper">
    <div class="container-fluid">
      <?php if ($this->session->flashdata('error') != ""): ?>
      <div class="row bg-title">
        <div id="errordiv1" class="alert <?php echo $this->session->flashdata('errorcls'); ?> alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <?php echo $this->session->flashdata('error'); ?></div>
      </div>
      <?php
                    endif;
                    ?>
      <!-- ============================================================== --> 
      <!-- Different data Product --> 
      <!-- ============================================================== -->
      <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">
          <div class="white-box">
            <header>
              <ul class="nav nav-tabs" id="myTab">
                <li class="active"><a data-toggle="tab" href="#sales_report12" id="view">Sales Report</a></li>
                <li><a data-toggle="tab" href="#sales_report3" id="view2">LAN Sale Report</a></li>
                <li><a data-toggle="tab" href="#purchase_report12" id="view3">Purchase Report</a></li>
                <li><a data-toggle="tab" href="#purchase_report3" id="view4">LAN Purchase Report</a></li>
              </ul>
            </header>
            <div class="tab-content">
              <div id="sales_report12" class="tab-pane fade in active">
                <div class="panel">
                  <div class="panel-heading">Sales Report</div>
                  <div class="row">
                    <div class="form-group col-sm-2 ">
                      <select class="form-control" id="si_for_year_id" name="si_for_year_id[]">
                        <?php
                                                foreach ($for_year as $p_year) {    
													if($p_year['yearname']== date("Y"))
													{
														$ischecked="selected";
													}
													else 
													{
														$ischecked="";
													}
                                                echo "<option value='" . $p_year['yearname'] . "' $ischecked >" . $p_year['yearname'] . "</option>";
                                                }
                                                ?>
                      </select>
                    </div>
                    <div class="form-group col-sm-2">
                      <select class="form-control pull-right" id="si_for_month_id" name="si_for_month_id[]">
                        <option <?php if(date("m")=='1') echo "selected";?> value="1">Jan</option>
                        <option value="2" <?php if(date("m")=='2') echo "selected";?>>Feb</option>
                        <option value="3" <?php if(date("m")=='3') echo "selected";?>>Mar</option>
                        <option value="4" <?php if(date("m")=='4') echo "selected";?>>Apr</option>
                        <option value="5" <?php if(date("m")=='5') echo "selected";?>>May</option>
                        <option value="6" <?php if(date("m")=='6') echo "selected";?>>Jun</option>
                        <option value="7" <?php if(date("m")=='7') echo "selected";?>>Jul</option>
                        <option value="8" <?php if(date("m")=='8') echo "selected";?>>Aug</option>
                        <option value="9" <?php if(date("m")=='9') echo "selected";?>>Sep</option>
                        <option value="10" <?php if(date("m")=='10') echo "selected";?>>Oct</option>
                        <option value="11" <?php if(date("m")=='11') echo "selected";?>>Nov</option>
                        <option value="12" <?php if(date("m")=='12') echo "selected";?>>Dec</option>
                      </select>
                    </div>
                  </div>
                  <div class="table-responsive">
                    <table id="product" class="table table-striped table-bordered manage-u-table optimize-table">
                      <thead>
                        <tr>
                          <th class="text-center">#</th>
                          <th>Group</th>
                          <th>Product Name</th>
                          <th>Rate</th>
                          <th>Qty</th>
                          <th>Total Amount</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div id="sales_report3" class="tab-pane fade in">
                <div class="panel">
                  <div class="panel-heading">LAN Sales Report</div>
                  <div class="row">
                    <div class="form-group col-sm-2 ">
                      <select class="form-control" id="si_for_year_id2" name="si_for_year_id2">
                        <?php
                                                foreach ($for_year as $p_year) {    
													if($p_year['yearname']== date("Y"))
													{
														$ischecked="selected";
													}
													else 
													{
														$ischecked="";
													}
                                                echo "<option value='" . $p_year['yearname'] . "' $ischecked >" . $p_year['yearname'] . "</option>";
                                                }
                                                ?>
                      </select>
                    </div>
                    <div class="form-group col-sm-2">
                      <select class="form-control pull-right" id="si_for_month_id2" name="si_for_month_id2">
                        <option <?php if(date("m")=='01') echo "selected";?> value="1">Jan</option>
                        <option value="2" <?php if(date("m")=='02') echo "selected";?>>Feb</option>
                        <option value="3" <?php if(date("m")=='03') echo "selected";?>>Mar</option>
                        <option value="4" <?php if(date("m")=='04') echo "selected";?>>Apr</option>
                        <option value="5" <?php if(date("m")=='05') echo "selected";?>>May</option>
                        <option value="6" <?php if(date("m")=='06') echo "selected";?>>Jun</option>
                        <option value="7" <?php if(date("m")=='07') echo "selected";?>>Jul</option>
                        <option value="8" <?php if(date("m")=='08') echo "selected";?>>Aug</option>
                        <option value="9" <?php if(date("m")=='09') echo "selected";?>>Sep</option>
                        <option value="10" <?php if(date("m")=='10') echo "selected";?>>Oct</option>
                        <option value="11" <?php if(date("m")=='11') echo "selected";?>>Nov</option>
                        <option value="12" <?php if(date("m")=='12') echo "selected";?>>Dec</option>
                      </select>
                    </div>
                  </div>
                  <div class="table-responsive">
                    <table id="product2" class="table table-striped table-bordered manage-u-table optimize-table">
                      <thead>
                        <tr>
                          <th class="text-center">#</th>
                          <th>Group</th>
                          <th>Product Name</th>
                          <th>Rate</th>
                          <th>Qty</th>
                          <th>Total Amount</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div id="purchase_report12" class="tab-pane fade in">
                <div class="panel">
                  <div class="panel-heading"> Purchase Report</div>
                  <div class="row">
                    <div class="form-group col-sm-2 ">
                      <select class="form-control" id="si_for_year_id3" name="si_for_year_id3">
                        <?php
                                                foreach ($for_year as $p_year) {    
													if($p_year['yearname']== date("Y"))
													{
														$ischecked="selected";
													}
													else 
													{
														$ischecked="";
													}
                                                echo "<option value='" . $p_year['yearname'] . "' $ischecked >" . $p_year['yearname'] . "</option>";
                                                }
                                                ?>
                      </select>
                    </div>
                    <div class="form-group col-sm-2">
                      <select class="form-control pull-right" id="si_for_month_id3" name="si_for_month_id3">
                        <option <?php if(date("m")=='01') echo "selected";?> value="1">Jan</option>
                        <option value="2" <?php if(date("m")=='02') echo "selected";?>>Feb</option>
                        <option value="3" <?php if(date("m")=='03') echo "selected";?>>Mar</option>
                        <option value="4" <?php if(date("m")=='04') echo "selected";?>>Apr</option>
                        <option value="5" <?php if(date("m")=='05') echo "selected";?>>May</option>
                        <option value="6" <?php if(date("m")=='06') echo "selected";?>>Jun</option>
                        <option value="7" <?php if(date("m")=='07') echo "selected";?>>Jul</option>
                        <option value="8" <?php if(date("m")=='08') echo "selected";?>>Aug</option>
                        <option value="9" <?php if(date("m")=='09') echo "selected";?>>Sep</option>
                        <option value="10" <?php if(date("m")=='10') echo "selected";?>>Oct</option>
                        <option value="11" <?php if(date("m")=='11') echo "selected";?>>Nov</option>
                        <option value="12" <?php if(date("m")=='12') echo "selected";?>>Dec</option>
                      </select>
                    </div>
                  </div>
                  <div class="table-responsive">
                    <table id="product3" class="table table-striped table-bordered manage-u-table optimize-table">
                      <thead>
                        <tr>
                          <th class="text-center">#</th>
                          <th>Group</th>
                          <th>Product Name</th>
                          <th>Rate</th>
                          <th>Qty</th>
                          <th>Total Amount</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div id="purchase_report3" class="tab-pane fade in">
                <div class="panel">
                  <div class="panel-heading">LAN Purchase Report</div>
                  <div class="row">
                    <div class="form-group col-sm-2 ">
                      <select class="form-control" id="si_for_year_id4" name="si_for_year_id4">
                        <?php
                                                foreach ($for_year as $p_year) {    
													if($p_year['yearname']== date("Y"))
													{
														$ischecked="selected";
													}
													else 
													{
														$ischecked="";
													}
                                                echo "<option value='" . $p_year['yearname'] . "' $ischecked >" . $p_year['yearname'] . "</option>";
                                                }
                                                ?>
                      </select>
                    </div>
                    <div class="form-group col-sm-2">
                      <select class="form-control pull-right" id="si_for_month_id4" name="si_for_month_id4">
                        <option <?php if(date("m")=='01') echo "selected";?> value="1">Jan</option>
                        <option value="2" <?php if(date("m")=='02') echo "selected";?>>Feb</option>
                        <option value="3" <?php if(date("m")=='03') echo "selected";?>>Mar</option>
                        <option value="4" <?php if(date("m")=='04') echo "selected";?>>Apr</option>
                        <option value="5" <?php if(date("m")=='05') echo "selected";?>>May</option>
                        <option value="6" <?php if(date("m")=='06') echo "selected";?>>Jun</option>
                        <option value="7" <?php if(date("m")=='07') echo "selected";?>>Jul</option>
                        <option value="8" <?php if(date("m")=='08') echo "selected";?>>Aug</option>
                        <option value="9" <?php if(date("m")=='09') echo "selected";?>>Sep</option>
                        <option value="10" <?php if(date("m")=='10') echo "selected";?>>Oct</option>
                        <option value="11" <?php if(date("m")=='11') echo "selected";?>>Nov</option>
                        <option value="12" <?php if(date("m")=='12') echo "selected";?>>Dec</option>
                      </select>
                    </div>
                  </div>
                  <div class="table-responsive">
                    <table id="product4" class="table table-striped table-bordered manage-u-table optimize-table">
                      <thead>
                        <tr>
                          <th class="text-center">#</th>
                          <th>Group</th>
                          <th>Product Name</th>
                          <th>Rate</th>
                          <th>Qty</th>
                          <th>Total Amount</th>
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

<!-- Modal start  -->
<div class="modal fade" id="dx_modal" role="dialog" data-backdrop='static'  data-keyboard='false'>
  <div class="modal-dialog modal-lg" style="width: 1160px;">
  
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="calls modal-title"> Details </h4>
          </div>
        <div class="modal-body">
    <table id="dx" class="table table-striped table-bordered manage-u-table optimize-table">

      <thead>
        <tr>
          <th width="70" class="text-center"> #</th>
          <th width="250">Purchase Date</th>
          <th width="250">Serial Number</th>
          <th width="250">Year</th>
          <th width="250">Client</th>
          <th width="250">Sale Amount</th>
          <th width="250">Purchase Amount</th>
          <th width="250">Payment Type</th>
          <th width="250">Bill Remark</th>
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
          <th width="250"></th>
          </tr>
      </tfoot>
    </table>
    </div>
    <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
    
  </div>
</div>
<!-- Modal end -->


<!-- Modal start  -->
<div class="modal fade" id="dx_modal1" role="dialog" data-backdrop='static' data-keyboard='false'>
  <div class="modal-dialog modal-lg" style="width: 1160px;">

      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="calls modal-title"> LAN </h4>
          </div>
        <div class="modal-body">
    <table id="dx1" class="table table-striped table-bordered manage-u-table optimize-table">

      <thead>
        <tr>
          <th width="70" class="text-center"> #</th>
          <th width="250">Purchase Date</th>
          <th width="250">Serial Number</th>
          <th width="250">Year</th>
          <th width="250">Client</th>
          <th width="250">Sale Amount</th>
          <th width="250">Purchase Amount</th>
          <th width="250">Payment Type</th>
          <th width="250">Bill Remark</th>
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
          <th width="250"></th>
          </tr>
      </tfoot>
    </table>
    </div>
    <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
  </div>
</div>
<!-- Modal end -->


<!-- js placed at the end of the document so the pages load faster -->
<?php $this->load->view('template/footerlink'); ?>
</body>
<script>
  function dx_modal(category_id , p_name , main_amount , type) {
	 //  $('.cvbx2tn').click(function () {
	   $('#dx_modal').modal('show');
		/*category_id = $(this).data('category_id');
		p_name = $(this).data('p_name');
		main_amount = $(this).data('main_amount');
		type = $(this).data('type');*/
		if(type=='s') { 
		var year= $('#si_for_year_id').val();
    	var month= $('#si_for_month_id').val();
		}
		else
		{
		var year= $('#si_for_year_id3').val();
    	var month= $('#si_for_month_id3').val();
		}
		
  		//console.log(category_id); return false;
  
var dx = $('#dx').DataTable({
        "processing": true,
        "destroy": true,
        "serverSide": true,        
        "lengthMenu": [[10, 50, 100, 250], [10, 50, 100,250]],
        "pageLength": 100,
        "ajax": {"url":"<?php echo base_url() . 'Admin/NewAccountReport/getDetails'; ?>",
        "data":function ( d ) { d.year=year; d.month=month; d.category_id=category_id; d.p_name=p_name; d.main_amount=main_amount; d.type=type;}
        },
        "order": [[ 2, "asc" ]]
    });
	
	//});
	
  }

  function dx_modal1(category_id , p_name , main_amount , type) {
	   $('#dx_modal1').modal('show');
		if(type=='s') { 
		var year= $('#si_for_year_id2').val();
    	var month= $('#si_for_month_id2').val();
		}
		else
		{
		var year= $('#si_for_year_id4').val();
    	var month= $('#si_for_month_id4').val();
		}

var dx1 = $('#dx1').DataTable({
        "processing": true,
        "destroy": true,
        "serverSide": true,        
        "lengthMenu": [[10, 50, 100, 250], [10, 50, 100,250]],
        "pageLength": 100,
        "ajax": {"url":"<?php echo base_url() . 'Admin/NewAccountReport/getDetails1'; ?>",
        "data":function ( d ) { d.year=year; d.month=month; d.category_id=category_id; d.p_name=p_name; d.main_amount=main_amount; d.type=type;}
        },
        "order": [[ 2, "asc" ]]
    });
  }





    $('#c_id').change(function () {
        if (!this.checked)
            $('#conversion').fadeOut('slow');
        else
            $('#conversion').fadeIn('slow');
    });
    $('#panelupdate').hide();
	
	
    var year= $('#si_for_year_id').val();
    var month= $('#si_for_month_id').val();
    var tabs = $('#product').DataTable({
        "processing": true,
        "destroy": true,
        "serverSide": true,        
        "lengthMenu": [[10, 50, 100, -1], [10, 50, 100, "All"]],
        "pageLength": 100,
        "ajax": {"url":"<?php echo base_url() . 'Admin/NewAccountReport/getData'; ?>",
        "data":function ( d ) { d.year=year; d.month=month;}
        },
        "order": [[ 2, "asc" ]]
    });
    
    $('#si_for_year_id,#si_for_month_id').change(function(){
    	var year= $('#si_for_year_id').val();
		var month= $('#si_for_month_id').val();    

     $('#product').DataTable({
        "processing": true, "destroy": true, "serverSide": true,
        "lengthMenu": [[10, 50, 100, -1], [10, 50, 100, "All"]],
		"pageLength": 100,               
        "ajax":
				{
					"url":"<?php echo base_url() . 'Admin/NewAccountReport/getData'; ?>",
                    "data":function ( d ) { d.year=year; d.month=month; d.condtion='tere'}
				},
        "order": [[ 2, "asc" ]]
    	});
   });


    var year2= $('#si_for_year_id2').val();
    var month2= $('#si_for_month_id2').val();
    var tabs2 = $('#product2').DataTable({
        "processing": true,
        "destroy": true,
        "serverSide": true,        
        "lengthMenu": [[10, 50, 100, -1], [10, 50, 100, "All"]],
        "pageLength": 100,
        "ajax": {"url":"<?php echo base_url() . 'Admin/NewAccountReport/getData2'; ?>",
        "data":function ( d ) { d.year=year2; d.month=month2;}
        },
        "order": [[ 2, "asc" ]]
    });
    
    $('#si_for_year_id2,#si_for_month_id2').change(function(){
    	var year2= $('#si_for_year_id2').val();
		var month2= $('#si_for_month_id2').val();    

     $('#product2').DataTable({
        "processing": true, "destroy": true, "serverSide": true,
        "lengthMenu": [[10, 50, 100, -1], [10, 50, 100, "All"]],
		"pageLength": 100,               
        "ajax":
				{
					"url":"<?php echo base_url() . 'Admin/NewAccountReport/getData2'; ?>",
                    "data":function ( d ) { d.year=year2; d.month=month2; d.condtion='tere'}
				},
        "order": [[ 2, "asc" ]]
    	});
   });




    var year3= $('#si_for_year_id3').val();
    var month3= $('#si_for_month_id3').val();
    var tabs3 = $('#product3').DataTable({
        "processing": true,
        "destroy": true,
        "serverSide": true,        
        "lengthMenu": [[10, 50, 100, -1], [10, 50, 100, "All"]],
        "pageLength": 100,
        "ajax": {"url":"<?php echo base_url() . 'Admin/NewAccountReport/getData3'; ?>",
        "data":function ( d ) { d.year=year3; d.month=month3;}
        },
        "order": [[ 2, "asc" ]]
    });
    
    $('#si_for_year_id3,#si_for_month_id3').change(function(){
    	var year3= $('#si_for_year_id3').val();
		var month3= $('#si_for_month_id3').val();    

     $('#product3').DataTable({
        "processing": true, "destroy": true, "serverSide": true,
        "lengthMenu": [[10, 50, 100, -1], [10, 50, 100, "All"]],
		"pageLength": 100,               
        "ajax":
				{
					"url":"<?php echo base_url() . 'Admin/NewAccountReport/getData3'; ?>",
                    "data":function ( d ) { d.year=year3; d.month=month3; d.condtion='tere'}
				},
        "order": [[ 2, "asc" ]]
    	});
   });





    var year4= $('#si_for_year_id4').val();
    var month4= $('#si_for_month_id4').val();
    var tabs4 = $('#product4').DataTable({
        "processing": true,
        "destroy": true,
        "serverSide": true,        
        "lengthMenu": [[10, 50, 100, -1], [10, 50, 100, "All"]],
        "pageLength": 100,
        "ajax": {"url":"<?php echo base_url() . 'Admin/NewAccountReport/getData4'; ?>",
        "data":function ( d ) { d.year=year4; d.month=month4;}
        },
        "order": [[ 2, "asc" ]]
    });
    
    $('#si_for_year_id4,#si_for_month_id4').change(function(){
    	var year4= $('#si_for_year_id4').val();
		var month4= $('#si_for_month_id4').val();    

     $('#product4').DataTable({
        "processing": true, "destroy": true, "serverSide": true,
        "lengthMenu": [[10, 50, 100, -1], [10, 50, 100, "All"]],
		"pageLength": 100,               
        "ajax":
				{
					"url":"<?php echo base_url() . 'Admin/NewAccountReport/getData4'; ?>",
                    "data":function ( d ) { d.year=year4; d.month=month4; d.condtion='tere'}
				},
        "order": [[ 2, "asc" ]]
    	});
   });


   
</script>
</html>