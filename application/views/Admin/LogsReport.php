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
                <div class="container-fluid"><?php if ($this->session->flashdata('error') != ""): ?>
                        <div class="row bg-title"> 

                            <div id="errordiv1"
                                 class="alert <?php echo $this->session->flashdata('errorcls'); ?> alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <?php echo $this->session->flashdata('error'); ?>
                            </div>

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
                                        <li class="active"><a data-toggle="tab" href="#home" id="view">View</a></li>                    
                                    </ul>
                                </header>
                                <div class="tab-content">
                                    <div id="home" class="tab-pane fade in active">    
                                        <div class="panel">
                                            <div class="panel-heading">Logs 
                                            <a href="" class="btn btn-success"><i class="fa fa-refresh"></i></a> 
                                            </div>
                                            <div class="row"> 
                                            <div class="form-group col-sm-2 ">
                                            <select class="form-control" id="si_for_year_id" name="si_for_year_id[]">                
                                            <?php
                                                foreach ($for_year as $p_year) {    
                                                if($p_year['yearname']== date("Y"))
                                                    $ischecked="selected";
                                                else                                                $ischecked="";
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
                                            <div class="form-group col-sm-2">
                                            <button type="button" class="btn btn-info pull-right" id="export_excel" name="export_excel" onClick="Excel();" title="Export Excel File">EXCEL</button>
                                            </div>
                                            </div>
                                            <div class="table-responsive">
                                                <table id="product" class="table table-striped table-bordered manage-u-table optimize-table">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">#</th>
                                                            <th>Admin</th>    
                                                            <th>Client Name</th>
                                                            <th>Time On</th>
                                                            <th>Time Off</th>
                                                            <th>Total Time Duration</th>
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
</body>


<script>
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
        "lengthMenu": [[10, 50, 100,500,1000], [10, 50, 100,500,1000]],
        "pageLength": 100,
        "ajax": {"url":"<?php echo base_url() . 'Admin/LogsReport/getData'; ?>",},
		"aoColumnDefs": [{ 'bSortable': false, 'aTargets': [0,-1] }],
        "order": [[ 0, "DESC" ]]
    });
	
   $('#si_for_year_id,#si_for_month_id').change(function(){
    var year= $('#si_for_year_id').val(); var month= $('#si_for_month_id').val();    
	  //console.log(year);
  
     $('#product').DataTable({
        "processing": true, "destroy": true, "serverSide": true,
        "lengthMenu": [[10, 50, 100], [10, 50, 100]], "pageLength": 100,               
        "ajax": {"url":"<?php echo base_url() . 'Admin/LogsReport/getData'; ?>",
                	"data":function ( d ) { d.year=year; d.month=month; d.condtion='tere'}},
        "order": [[ 0, "DESC" ]]
    });
   });
   
   	$('#product>tbody').on('click', '.eye', function() {    
       alert("This is nothing");
		 });
		 
	$('#product>tbody').on('click', '.delete', function() {    
        var id = $(this).data('id');
         
      swal({
            title: 'Are you sure?',
            text: "You won't be delete this Data",
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
                type: 'POST',
                url: '<?php echo base_url('Admin/LogsReport/DeleteLogs'); ?>',
                data: {'id': id},
                dataType: 'html',
                success: function (data) {
                    if (data == 1) {
                        swal(
                                'Successfully!',
                                'Selected Data has been  Deleted.',
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
                        'Your Data is safe :)',
                        'error'
                        )
            }
        })

		 });
		
   
</script>
<script type="text/javascript">
           function Excel() {
               
            swal({
            title: 'Export Excel',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Export Excel !',
            cancelButtonText: 'No!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
             buttonsStyling: true,
            html:
    '<label>Date From </label><input id="swal-input1" class="swal2-input" type="text" readonly="" value="<?php echo date('01-m-Y')?>" >' +
    '<label>Date To </label> <input id="swal-input2" class="swal2-input"  type="text" readonly="" value="<?php echo date('d-m-Y')?>" >',
        onOpen : function(){$('.swal2-input').datepicker({ format: 'dd-mm-yyyy'});},
           
        }).then(function () {
            
      var datefrom=document.getElementById('swal-input1').value;
      var dateto=document.getElementById('swal-input2').value;
            
            /*$.ajax({
                type: 'POST',
                 url: '<?php //echo base_url('Admin/LogsReport/Export_Excel_Logs_Calls1'); ?>',
                 data:{"datefrom":datefrom,"dateto":dateto},
                dataType: 'json',
                success: function (data) {
                    if(data==1) {  */
                        window.location.href = "<?php echo base_url()?>Admin/LogsReport/Export_Excel_Logs_Calls/"+datefrom+'/'+dateto; 
                        //}
                        /*else { alert("It is taking too much time , Try Again"); }
            });  **/
        }, function (dismiss) {
            if (dismiss === 'cancel') {
                swal(
                        'Cancelled',
                        'Your Excel File is not Created  :)',
                        'error'
                        )
            }
        })   
             
          }//function ends
          
            </script>

</html>