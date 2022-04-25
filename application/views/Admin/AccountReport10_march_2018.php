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
                                            <div class="panel-heading">MANAGE Product</div>
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
                                            </div>
                                            <div class="table-responsive">
                                                <table id="product" class="table table-striped table-bordered manage-u-table">
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
    //console.log('year'+year+'month'+month);
    var tabs = $('#product').DataTable({
        "processing": true,
        "destroy": true,
        "serverSide": true,        
        "lengthMenu": [[10, 50, 100, -1], [10, 50, 100, "All"]],
        "pageLength": 100,
        "ajax": {"url":"<?php echo base_url() . 'Admin/AccountReport/getData'; ?>"},
		"order": [[ 2, "asc" ]]
    });
   $('#si_for_year_id').change(function(){
    var year= $('#si_for_year_id').val();
    var month= $('#si_for_month_id').val();    
     $('#product').DataTable({
        "processing": true,
        "destroy": true,
        "serverSide": true, 
		"lengthMenu": [[10, 50, 100, -1], [10, 50, 100, "All"]],
        "pageLength": 100,               
        "ajax": {"url":"<?php echo base_url() . 'Admin/AccountReport/getData'; ?>",
                "data":function ( d ) { d.year = year;d.month=month;d.condtion='tere'}},
		"order": [[ 2, "asc" ]]
    });
   });
   $('#si_for_month_id').change(function(){
    var year= $('#si_for_year_id').val();
    var month= $('#si_for_month_id').val();    
    $('#product').DataTable({
        "processing": true,
        "destroy": true,
        "serverSide": true,        
		"lengthMenu": [[10, 50, 100, -1], [10, 50, 100, "All"]],
        "pageLength": 100,
        "ajax": {"url":"<?php echo base_url() . 'Admin/AccountReport/getData'; ?>",
                 "data":function ( d ) { d.month = month;d.year=year;d.condtion='tere'}},
		"order": [[ 2, "asc" ]]
    });
   });
</script>
</html>