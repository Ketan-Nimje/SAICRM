<html>
<head>

    <?php $this->load->view('template/headerlink'); ?>    
</head>

<body class="fix-header">
    <!-- ============================================================== -->
    <!-- Wrapper -->
    <!-- ============================================================== -->
    <div id="wrapper">

            <!--header start-->
            <?php  $this->load->view('template/header'); ?>
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
             <?php if ($this->session->userdata('error') != ""): ?>
                <div class="row bg-title"> 
                           
                                <div id="errordiv1"
                                     class="alert <?php echo $this->session->userdata('errorcls'); ?> alert-dismissable">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <?php echo $this->session->userdata('error'); ?>
                                </div>

                                         
                </div>
                 <?php
                            endif;
                            $this->session->unset_userdata('error');
                            ?>        
                <!-- ============================================================== -->
                <!-- Different data Product -->
                <!-- ============================================================== -->
                <div class="row">
                            <div class="col-lg-12 col-sm-12 col-xs-12">                               
                                <div class="white-box">
                                        <header>
                                            <ul class="nav nav-tabs" id="myTab">
                                                <li class="active"><a data-toggle="tab" href="#home" id="view">View</a></li>                  
                                            </ul>
                                        </header>
                                        <div class="tab-content">
                                            <div id="home" class="tab-pane fade in active">    
                                                    <div class="panel">
                                                        <div class="panel-heading">Clients Transaction Details
                                                         <a  title="REFRESH" href="<?php echo base_url().'Admin/ProductTransactionsDetail';?>"class="btn btn-danger">
                                            <i class="fa fa-refresh"></i></a>
                                                        </div>
                                                        <div>
                                                        <?php //echo "<pre>";print_r($selected); die; ?>
                                                        </div>
                                                        <!----------------------------------------------------------->
                                                       <link href="<?php echo base_url(); ?>assetss/Custom/multiSelect/jquery.multiselect.css" rel="stylesheet">
                                                            <!----------------------------------------------->
                                                        
                                                        
                                                        <div class="row"> 
            <form action="<?php //echo base_url().'Admin/ProductTransactionsDetail/get_excel_data';?>">
                <input type="hidden" name="ALL"  id="ALL"  value="">
                                            <div class="form-group col-sm-4 ">
                                                <p>Product </p>
                                                
<select name="si_for_year_id[]"  id="si_for_year_id" multiple>
                                        <?php  foreach ($product as $p1) {   $p_sel=""; 
                                                if($selected['product']==$p1['p_name'])
                                                    $p_sel="selected";   
                                                echo "<option value='" . $p1['p_name'] . "'".$p_sel.">". $p1['p_name'] . "</option>";
                                                }  ?>
</select>
                                            
                                            </div>
                                            <div class="col-sm-8">
                                             <div class="form-group col-sm-2">
                                                <p>Type </p>
                                            <select class="form-control pull-right" id="category_id" name="category_id">                                                
                                                <option value="A" <?php if(!isset($selected['type'])) echo "selected";?>>All</option>
                                                <option value="1" <?php if($selected['type']==1) echo "selected";?> >Sale</option>
                                                <option value="2" <?php if($selected['type']==2) echo "selected";?>>Updatation</option>
                                                <option value="3" <?php if($selected['type']==3) echo "selected";?>>Lan</option>
                                                <option value="4" <?php if($selected['type']==4) echo "selected";?>>Conversion</option> 
                                                <option value="5" <?php if($selected['type']==5) echo "selected";?>>Lan With SRV</option>
                                            </select>                                            
                                            </div>
                                             <div class="form-group col-sm-2">
                                                <p>DateFrom</p>
                                            <input type="text" name="datefrom" id="datefrom"class="form-control  mydatepicker pull-right" value="<?php echo date('01-m-Y'); ?>">                
                                            </div>
                                             <div class="form-group col-sm-2">
                                                <p>DateTo </p>
                                            <input class="form-control mydatepicker pull-right" id="dateto" name="dateto" value="<?php echo date('t-m-Y'); ?>">                    
                                            </div>
                                            <div class="form-group col-sm-2">
                                                <p>&nbsp;</p>
                                            <button type="button" class="btn btn-info" id="check" name="check" title="Check Final Report " onclick="mydata();">CHECK <i class="fa fa-check"></i></button>
                                            </div>
                                            
                                            <div class="form-group col-sm-2">
                                                <p>OutSatnding Report</p>
                                            <input class="form-control" title="Check OutSatnding Report " id="payment" name="payment" type="checkbox" value="1">                    
                                            </div>
                                            
                                            <div class="form-group col-sm-2">
                                                <p>&nbsp; </p>
                                            <!--input type="submit" class="btn btn-primary" title="Export EXCEL " id="GetData" name="excel"  value="EXCEL"--->

                          <button type="button" class="btn btn-info" id="export_excel" name="export_excel" onClick="Excel();" title="Export Excel File">EXCEL</button>                   
                                            </div>
                                            </div>
                                            
                                            </form>
                                            </div>
                                                        <div class="table-responsive">
                                                            <table id="product" class="table table-striped table-bordered manage-u-table optimize-table">
                                                                <thead>
                                                                    <tr>
                                    <th width="70" class="text-center"># &nbsp
                            <input type="checkbox" id="selectAllid" onClick="selectAll(this)">
                        </th>
                                                                        <th>Purchase Date</th>
                                                                        <th>Group</th> 
                                                                        <th>Clients Name </th>
                                                                        <th>Serial No</th>
                                                                        <th>Product Name</th> 
                                                                        <th>Session</th>
                                                                        <th>Amount</th>    
                                                                        <th>Payment Type</th>    
                                                                        <th>Bill Remarks</th>    
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
    <!---========================= Assign Modal ==============---->
<div id="assignModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Change Session </h4>
      </div>
      <div class="modal-body">
      <form id="assign_form">
      <label>For Year</label>
      <div class="input-group">
      <input type="hidden" name="hid_id" id="hid_id">
     <select class="form-control" id="assign_id" name="assign_id">
     </select>
     <span class="input-group-btn">
     <button type="submit" class="btn btn-info waves-effect waves-light">
     <i class="fa fa-check"></i> Save</button>
     <button type="button" data-dismiss="modal" class="btn btn-dark waves-effect waves-light">
      Cancel</button></span></div>
     </form>
     </div>
     </div>
     </div>
</div>
<!---========================= Assign Modal ==============---->
    <!-- js placed at the end of the document so the pages load faster -->
    <?php $this->load->view('template/footerlink'); ?>
    </body>

    <script type="text/javascript">
           function Excel() {
            var ck = [];
            $.each($("input[name='id[]']:checked"),function(){ ck.push($(this).data('id'));});     //console.log(ck);
            len=ck.length;
            var v = ck.toString();
            //var v=ck.join("_");
             GoNow(v,len);
          }//function ends
          
        function GoNow(v,len) {
         if(len==0){ 
         swal(
                        'Select First',
                        'You have not Selected Any Rows !!! :)',
                        'error'
                        )       
                          return false;}
        swal({
            title: 'Total '+len+' Row(s) !!',
            text: "Create Excel File ",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Export Excel File !',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: true
        }).then(function () {
                    $.ajax({
                                     type: 'POST',
                                     data: {'id': v},
                                    url: '<?php echo base_url('Admin/ProductTransactionsDetail/excel_ids_lists'); ?>',
                                    dataType: 'JSON',
                                    success: function (data)    {
                                        if(data==1) {
                        window.location.href = "<?php echo base_url()?>Admin/ProductTransactionsDetail/create_excel_sales_report/"; }
                        else { alert("It is taking too much time , Try Again"); }
                        
                                                                            }
                                     });    

                         },
         function (dismiss) {
            if (dismiss === 'cancel') {
                swal(
                        'Cancelled',
                        'Your Excel File is not Created :)',
                        'error'
                        )
            }
        })
     }
     
                //-------- Select All ------
        function selectAll(source) {
            
            checkboxes = document.getElementsByName('id[]');
            for (var i = 0, n = checkboxes.length; i < n; i++) {
                checkboxes[i].checked = source.checked; }
                if($("#selectAllid").prop('checked') == true){
                var ck = [];
                        $.each($("input[name='id[]']:checked"),function(){ ck.push($(this).data('id'));
                $('#ALL').val(ck);    
                        });
                 }
                else {   $('#ALL').val('');  }
                                                
          }
            </script>

        <script>
        $('.mydatepicker, #datepicker').datepicker({format: 'dd-mm-yyyy',orientation: "bottom", todayHighlight: true });
        $('#billpayment').change(function () {
        if ($(this).prop("checked")) { $('.billno').show()
        } else {  $('.billno').hide() } });

            var tbl = 'si_transactions_detail';
            $('#panelupdate').hide();
            var cntrl = '<?php echo $this->uri->segment(2); ?>';
              
            $('#category_id,#payment,#si_for_year_id').change(function(){  mydata();   });

            function mydata() {
                var datefrom= $('#datefrom').val();
                var dateto= $('#dateto').val(); 
                var category_id=$('#category_id').val();
                var p_name =$('#si_for_year_id').val();
                var t_pay=$('#payment').is(":checked");
                if(t_pay== true)
                    var payment =$('#payment').val();
                else
                    var payment =0;
                $('#product').DataTable({
                "processing": true, "serverSide": true, 
                "destroy": true,
                "lengthMenu": [[10, 50, 100, 500,1000,2500,5000], [10, 50, 100,500,1000,2500,5000]], "pageLength": 100,
                "aoColumnDefs": [{ "bSortable": false, "aTargets": [0] , }],                          
                "ajax": {"url":"<?php echo base_url().'Admin/ProductTransactionsDetail/GetData'; ?>",
                "data":function ( d ) { d.datefrom = datefrom;d.dateto=dateto;d.category_id=category_id;d.p_name=p_name;d.payment=payment
                <?php 
                if($_GET['month']== true && $_GET['year'] == true 
                && $_GET['month']>0 && $_GET['month']<=12  
                && $_GET['year']<=date('Y') && $_GET['year']>2000 ) {  ?>
                ,d.QQyear = <?php echo $y=$_GET['year']; ?>;d.QQmonth=<?php echo $m=$_GET['month'] ;?>;
                
                <?php $dat='12-'.$m.'-'.$y;  $datefrom=date("01-m-Y", strtotime($dat));  $dateto=date("t-m-Y", strtotime($datefrom)); ?>
                $('#datefrom').val('<?php echo $datefrom ?>');  
                $('#dateto').val('<?php echo $dateto ?>');
                $('#check,#datefrom,#dateto,#si_for_year_id,#category_id').attr('disabled','disabled');
                <?php } ?>
                 }},
                 });
            }
            $('#product>tbody').on('click', '.seePro', function () {
        $("#assign_id").empty(); 
        var id = $(this).data('id'); $("#hid_id").val(id);  
        $.ajax({   
                type:'POST', 
                url: '<?php echo base_url('Admin/ProductTransactionsDetail/assigned'); ?>',
                data : {'id': id}, 
                dataType: 'json',
                success: function (Result) {
                    var e=Result.assigned; $("#hid_id").attr('for_year',e);  
                                            $.ajax({ 
                                                        url: '<?php echo base_url('Admin/ProductTransactionsDetail/listYear'); ?>',
                                                        dataType: 'json', 
                                                        success: function (dt) {     
                             for (var i =0; i < dt.length; i++) {  var vk=dt[i];
                                            if(e==vk.year)   
                                            $("#assign_id").append('<option value="'+vk.year+'" selected  style="color:blue">'+vk.year+'</option>'); 
                                            else 
                                            $("#assign_id").append('<option value="'+vk.year+'">'+vk.year+'</option>'); 
                                                                                }
                                                                                            }
                                                    });
                    $("#assignModal").modal({backdrop: 'static', keyboard: false});
                                                        }
                   });
            });
        
         $("#assign_form").submit(function (event) { event.preventDefault();
                    var formData = new FormData($("#assign_form")[0]); 
                    if($("#assign_id").val()==$("#hid_id").attr('for_year')) {  alert("Nothing to Update !!!"); return false }
                            $.ajax({
                                        url: "<?php echo base_url(). 'Admin/ProductTransactionsDetail/assign_to'; ?>", 
                                        type: 'POST', 
                                        data: formData,
                                        contentType: false, 
                                        processData: false,
                                        success: function(data) { 
                                                    $('#assignModal').modal('hide');
                                                     mydata(); 
                                                            }, error: function(){  alert("Something Went Wrong !! "); }
                                        });  return false; });
             
            
             
</script>

<script src="<?php echo base_url(); ?>assetss/Custom/multiSelect/jquery.multiselect.js"></script>
<script type="text/javascript">
    $(document).ready(function(e) {
    $('#si_for_year_id').multiselect({
    columns: 2, search: true,  selectAll: true,checkboxAutoFit:true,
    texts    : { placeholder: 'Select Product ', search : 'Search Product ' } 
    });
    
    $('#si_for_year_id').multiselect( 'loadOptions', [  <?php foreach($product as $e) {   
        
        if($_GET[product] != true){ 
            echo $vv[]="{ name : '".$e['p_name']."', value : '".$e['p_name']."', checked : true },";
            }  
        else {  if($_GET[product]!=$e['p_name']) {
                        echo $vv[]="{ name : '".$e['p_name']."', value : '".$e['p_name']."', checked : false },";
                                    }
                                    else 
                                    {
                        echo $vv[]="{ name : '".$e['p_name']."', value : '".$e['p_name']."', checked : true },";
                                    }
            }   }  ?>
            ]);
             mydata(); 
        });

        //-------- Select All ------
        /*function selectAll(source) {
            checkboxes = document.getElementsByName('id[]');
            for (var i = 0, n = checkboxes.length; i < n; i++) {
                checkboxes[i].checked = source.checked; }
          }*/

</script>






</html>