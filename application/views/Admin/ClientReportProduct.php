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
<link href="<?php echo base_url(); ?>assetss/Custom/multiSelect/jquery.multiselect.css" rel="stylesheet">
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
        <div id="errordiv1" class="alert <?php echo $this->session->flashdata('errorcls'); ?> alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <?php echo $this->session->flashdata('error'); ?></div>
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
                <h3 class="box-title m-b-10">Product REPORT</h3>
                <div class="row">
                  <form target="_blank" method="post" action="<?php echo base_url() .'Admin/ClientReport/Excel_product_report'; ?>">
                    <div class="form-group col-sm-1">
                      <button type="submit" class="btn btn-info pull-left" id="export_excel" title="Export Excel File">EXCEL</button>
                    </div>
                    <div class="form-group col-sm-4">
                      <select id="select_inq" name="select_inq[]" multiple>
                        <?php
                                foreach ($product as $p) 
                                  {    
                                      echo "<option value='" . $p['si_product_id'] . "' selected>" . $p['p_name'] . "</option>";
                                  }
                        ?>
                      </select>
                    </div>
                    <div class="form-group col-sm-2 pull-right">
                      <button type="button" id="sms_id" class="btn btn-info" onClick="send_multi_sms();">Send Bulk SMS</button>
                    </div>
                  </form>
                </div>
                <table id="product" class="table table-striped table-bordered manage-u-table optimize-table noselect select-third">
                  <thead>
                    <tr>
                      <th class="text-center"># &nbsp
                        <input type="checkbox" id="selectAllid" onClick="selectAll(this)"></th>
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
<!---Message--Start--Modal---->
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
          <a target="_blank" class="adata_id">
          <button class="btn btn-success waves-effect waves-light m-r-10" id="send_sms_btn" type="submit">Send SMS</button>
          </a> </div>
      </form>
    </div>
  </div>
</div>
<!---Message--End--Modal----> 

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
<script src="<?php echo base_url(); ?>assetss/Custom/multiSelect/jquery.multiselect.js"></script> 
<script>
     $("#sms_form").submit(function (event) { event.preventDefault();
          var mob= $("input[id=mobb]").val();
          var msg=  $('textarea#send_msg1').val();  
            
      if (msg.length< 5 )
        {  
                  $(".modal-title").html("<marquee style='color:red'>Too Short Message</marquee>"); 
                  $('#send_msg:visible').first().focus(); return false
                }
           var selected = [];$(".select:checked").each(function() { selected.push($(this).val()); });
           var Con1 = confirm("Do You Want to Send SMS to  "+ selected.length +" Selected Customer ??"); 
                  if(Con1 == true) 
            { 
                        alert("You're Going to Send SMS to All  !! ");   
                    } 
                  else 
            { 
                        $('#smsModal1').modal('hide'); return false;
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
        setTimeout(function () { alert("You've Sent SMS Successfully !!! "); }, 2020);
        },
        error: function(){  alert("Something Went Wrong !!! "); }
        });
        return false;
    });


      ///-------------- Send Multiple ( Bulk ) SMS ------
   function send_multi_sms() { 
           var selected = [];
       var cn = [];
       $('#send_to').removeAttr("disabled");
           $(".select:checked").each(function() { selected.push($(this).val()); });
       $(".select:checked").each(function() { cn.push($(this).attr("cn")); });
       var c = selected.length;
           if( c < 1)
       {
                 alert("You've not selected  !!! "); return false
            }
            else
      {
                $('#send_msg').val(''); 
                $('.modal-title').html('Customer Number List');
                $("#smsModal1").modal({backdrop: 'static', keyboard: false});
              $("#send_sms_btn").html('Send Bulk SMS');
              $("#mobb").val(selected);
              $("#send_to1").attr({ 'style':'background-color : #d9c3e5', 'type':'button', 'cu':''+selected+'', 'cn':''+cn+'', 'class':'seeNumber form-control', 'value':'Total '+ c+' Customer' });
            }
      }
    
    ////----------------------


  $(document).ready(function(e) { 
    $('#select_inq').multiselect({ columns: 2, search: true,  selectAll: true,checkboxAutoFit:true, texts : { placeholder: 'Select Product ', search : 'Search Product '} });
    datatable();  
    /*
      $('#select_inq').multiselect({
     columns: 2,
     search: true,
     selectAll: true,
     checkboxAutoFit:true,
     texts : 
     {
       placeholder: 'Select Product ', 
       search : 'Search Product '
      }
    });
    */
  });

  $('#select_inq').change(function(){  datatable(); });
  
  function datatable() { 
      //var tbl = 'si_clients';
      //var cntrl = '<?php echo $this->uri->segment(1); ?>';
      var tabs = $('#product').DataTable({
        "processing": true,
        "responsive": true,
        "serverSide": true,
        "destroy": true,
        "lengthMenu": [[10,30,40,50,100,500], [10,30,40,50,100,500]],"pageLength": 100, "order": [[ 0, "desc" ]],
        "ajax": { 
        "data":{"select_inq": $("#select_inq").val() },
        "url":"<?php echo base_url() .'Admin/ClientReport/GetData_report'; ?>" },
        "aoColumnDefs": [
          {
            bSortable: false,
            aTargets: [0]
          } //,{"targets": [-1,-2,-3,-4,-5,-6,-7,-8,-9],"visible": false }
        ],
        "fnRowCallback": function (nRow, aData, iDisplayIndex) {
        },
      });
}
  
        function selectAll(source) {
            checkboxes = document.getElementsByName('id[]');
            for (var i = 0, n = checkboxes.length; i < n; i++) {
                checkboxes[i].checked = source.checked; }
                if($("#selectAllid").prop('checked') == true){
                var ck = [];
                        $.each($("input[name='id[]']:checked"),function(){
              ck.push($(this).data('id'));
                      $('#ALL').val(ck);    
                        });
                 }
                else 
        {
          $('#ALL').val('');
        }
          }
</script>
</body>
</html>