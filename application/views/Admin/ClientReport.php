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
<link href="<?php echo base_url(); ?>assetss/css/editor.css" type="text/css" rel="stylesheet"/>

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

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
                                 class="alert <?php echo $this->session->flashdata('errorcls'); ?> alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <?php echo $this->session->flashdata('error'); ?> </div>
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
            <div class="col-sm-12 col-lg-12">
              <div class="table-responsive p-t-30" style="width: 100%;">
                <h3 class="box-title m-b-10">REPORT CLIENT</h3>
                <div class="row">
                <form target="_blank" method="post" action="<?php echo base_url() .'Admin/ClientReport/Excel'; ?>">
                  <div class="col-sm-1">
                    <select class="form-control " id="select_inq" name="select_inq">
                      <option value="A" >Active</option>
                      <option value="D"  >Deactive</option>
                      <option value="All" selected>All </option>
                    </select>
                  </div>
                  <div class="col-sm-2">
                    <select class="form-control " id="select_inq1" name="select_inq1">
                      <option value="P" >Purchase_Date</option>
                      <option value="R"  >Renewal_Date</option>
                      <option value="All" selected>Any </option>
                    </select>
                  </div>
               
                  <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
                          <input type="text" id="reportrange1" class="form-control"  placeholder="Select Date" name="date" value="<?= date("Y-m-d | Y-m-d"); ?>" readonly>
                        </div>  
                           <div class="form-group col-sm-2">
                  <button type="submit" class="btn btn-info pull-right" id="export_excel" title="Export Excel File">EXCEL</button>
                  </div>                        
                       </form>                     
                </div>
                <table id="product" class="table table-striped table-bordered manage-u-table optimize-table noselect select-third">
                  <thead>
                    <tr>
                      <th class="text-center">#</th>
                      <th>Customer Name</th>
                      <th>Firm Name</th>
                      <th>Mobile</th>
                      <th>Email</th>
                     
                    </tr>
                  </thead>
                  <tfoot>
                  <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    
                    </tfoot>
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
<script src="<?php echo base_url(); ?>assetss/js/dataTables.responsive.js"></script> 
<script src="<?php echo base_url(); ?>assetss/plugins/bower_components/switchery/dist/switchery.min.js"></script> 
<script src="<?php echo base_url(); ?>assetss/plugins/bower_components/custom-select/custom-select.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url(); ?>assetss/plugins/bower_components/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url(); ?>assetss/plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script> 
<script src="<?php echo base_url(); ?>assetss/plugins/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js" type="text/javascript"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assetss/plugins/bower_components/multiselect/js/jquery.multi-select.js"></script> 
<script src="<?php echo base_url(); ?>assetss/js/editor.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>



</body>
<script>

    $('#editable').DataTable({
        responsive: false
    });
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
        "responsive": true,
        "serverSide": true,
        "destroy": true,
        "lengthMenu": [[10,30,40,50,100,500], [10,30,40,50,100,500]],"pageLength": 100, "order": [[ 0, "desc" ]],
        "ajax": { 
         "data":{"select_inq": $("#select_inq").val() },
        "url":"<?php echo base_url() .'Admin/ClientReport/GetData'; ?>" },
        "aoColumnDefs": [
            {
                bSortable: false,
                aTargets: [0]
            }//,{"targets": [-1,-2,-3,-4,-5,-6,-7,-8,-9],"visible": false }
        ],
        
        "fnRowCallback": function (nRow, aData, iDisplayIndex) {
//                                                                            for (var i = 7; i <= 27; i++) {
//
//                                                                                $('td:eq(' + i + ')', nRow).css("display", "none");
//                                                                            }
//                                                                            return nRow;
        },
    });
    $('#select_inq').change(function(){              
         var tabs = $('#product').DataTable({
        "processing": true,
        "responsive": true,
        "destroy": true,
        "serverSide": true,
        "lengthMenu": [[10,30,40,50,100,500], [10,30,40,50,100,500]],"pageLength": 100, "order": [[ 0, "desc" ]],
        "ajax": { 
         "data":{"select_inq": $("#select_inq").val() },
        "url":"<?php echo base_url() .'Admin/ClientReport/GetData'; ?>" },
        "aoColumnDefs": [
            {
                bSortable: false,
                aTargets: [0]
            }
        ],
       
        "fnRowCallback": function (nRow, aData, iDisplayIndex) {
//                                                                            for (var i = 7; i <= 27; i++) {
//
//                                                                                $('td:eq(' + i + ')', nRow).css("display", "none");
//                                                                            }
//                                                                            return nRow;
        },
    }); }); 

//---------------------
</script>

<script>

		var currentYear = (new Date).getFullYear();
        var currentMonth = (new Date).getMonth();
        var currentDay = (new Date).getDate();
	
			
        $(function () {

            var start = moment().subtract(364, 'days');
            var end = moment();

            function cb(start, end) {
                var dat = start.format('YYYY-MM-DD') + '/' + end.format('YYYY-MM-DD');
				/*GetAllCourier(dat);
				dataTable.columns(9).search(dat).draw(); */
            }

            $('#reportrange1').daterangepicker({
                autoUpdateInput: false,
                maxDate: moment().endOf("day"),
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
					'Last 365 Days': [moment().subtract(364, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }, locale: {
                    format: 'YYYY-MM-DD'
                }
            }, cb);

            $('input[name="date"]').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' | ' + picker.endDate.format('YYYY-MM-DD'));
            });
            $('input[name="date"]').on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');
            });
        });
		
	

</script>
</html>