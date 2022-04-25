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
                                     <li class="active"><a data-toggle="tab" href="#client" id="view1">Client Report</a></li>   
                                        <li class=""><a data-toggle="tab" href="#home" id="view">GST Updation Report</a></li>    
                                    </ul>
                                </header>
                                <div class="tab-content">
                                <div id="client" class="tab-pane fade in active">    
                                        <div class="panel">
                                            <div class="panel-heading">Client Report 
                                            <a href="" class="btn btn-success"><i class="fa fa-refresh"></i></a> 
                                            </div>
                                            <div class="row">
                      <div class="form-group col-sm-2 ">
                        
                        <select name="select"  id="select" class="form-control " >
                                        <?php  foreach ($product as $p1) {   $p_sel=""; 
                                                if($selected['product']==$p1['p_name'])
                                                    $p_sel="selected";   
                                                echo "<option value='" . $p1['p_name'] . "'".$p_sel.">". $p1['p_name'] . "</option>";
                                                }  ?>
                        </select>
                      </div>
                
                    </div>
                                       
                                            
                                            <div class="table-responsive">
                                                <table id="product1" class="table table-striped table-bordered manage-u-table optimize-table">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">#</th>
                                                             <th>Client Name</th>
                                                             <th>Mobile</th>    
                                                            <th>Email</th>
                                                            <th>Client since</th>
                                                            </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    
                                          <div id="home" class="tab-pane fade in ">    
                                        <div class="panel">
                                            <div class="panel-heading">GST Updation Report 
                                            <a href="" class="btn btn-success"><i class="fa fa-refresh"></i></a> 
                                            </div>
                                            
                                            <div class="table-responsive">
                                                <table id="product" class="table table-striped table-bordered manage-u-table optimize-table">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">#</th>
                                                             <th>Client Name</th>
                                                             <th>Mobile</th>    
                                                            <th>Email</th>
                                                            <th>Update Date</th>
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
    var tabs = $('#product').DataTable({
        "processing": true,
        "destroy": true,
        "serverSide": true,        
        "lengthMenu": [[10, 50, 100,500,1000], [10, 50, 100,500,1000]],
        "pageLength": 100,
        "ajax": {"url":"<?php echo base_url() . 'Admin/GstReport/getData'; ?>",},
        "aoColumnDefs": [{ 'bSortable': false, 'aTargets': [0,-1] }],
        "order": [[ 0, "DESC" ]]
    });
    
      var tabs1 = $('#product1').DataTable({
        "processing": true,
        "destroy": true,
        "serverSide": true,        
        "lengthMenu": [[10, 50, 100,500,1000], [10, 50, 100,500,1000]],
        "pageLength": 100,
        "ajax": {"url":"<?php echo base_url() . 'Admin/GstReport/getData'; ?>",},
        "aoColumnDefs": [{ 'bSortable': false, 'aTargets': [0,-1] }],
        "order": [[ 0, "DESC" ]]
    });
    
    $(document).ready(function(e) {    var v =$('#select').val();  mydata(v);  });
    $('#select').change(function(){ var v =$('#select').val();  mydata(v);  });  
  
   function mydata(v) { 
     $('#product1').DataTable({"processing": true, "destroy": true, "serverSide": true,  
        "lengthMenu": [[10, 50, 100], [10, 50, 100]], "pageLength": 100,"order": [[ 0, "desc" ]],
        "ajax":  { "data":{"p_name": v },
        "url":"<?php echo base_url() .'Admin/GstReport/getClientReport'; ?>" },
        "aoColumnDefs": [{ 'bSortable': false, 'aTargets': [0] }],
    });} 
    
  
   
</script>
</html>