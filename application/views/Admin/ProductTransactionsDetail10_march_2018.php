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
                                                        <div class="panel-heading">Clients Transaction Details</div>
                                                        <div class="row"> 
                                            <div class="form-group col-sm-2 ">
                                                <p>Product </p>
                                            <select class="form-control" id="si_for_year_id" name="si_for_year_id[]">                
                                                <option value="All">All</option>
                                            <?php
                                                foreach ($product as $p1) {    
                                                
                                                echo "<option value='" . $p1['p_name'] . "' >" . $p1['p_name'] . "</option>";
                                                }
                                           
                                                ?>
                                            </select>
                                            </div>
                                             <div class="form-group col-sm-2">
                                                <p>Type </p>
                                            <select class="form-control pull-right" id="category_id" name="category_id">
                                                <option value="A" selected>All</option>
                                                <option value="1">Sale</option>
                                                <option value="2" >Updatation</option>
                                                <option value="3">Lan</option>
                                                <option value="4">Conversion</option> 
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
                                            </div>
                                                        <div class="table-responsive">
                                                            <table id="product" class="table table-hover manage-u-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="70" class="text-center">#</th>
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
    <!-- js placed at the end of the document so the pages load faster -->
    <?php $this->load->view('template/footerlink'); ?>
    </body>
    <script>
        $('.mydatepicker, #datepicker').datepicker({format: 'dd-mm-yyyy',orientation: "bottom", todayHighlight: true
    });
        $('#billpayment').change(function () {
        if ($(this).prop("checked")) {
            $('.billno').show()
        } else {
            $('.billno').hide()
        }
    });
            var tbl = 'si_transactions_detail';
            var datefrom= $('#datefrom').val();
            var dateto= $('#dateto').val(); 
            $('#panelupdate').hide();
            var cntrl = '<?php echo $this->uri->segment(2); ?>';            
            var tabs = $('#product').DataTable({
                "processing": true,
                "destroy": true,
                "serverSide": true,
				"lengthMenu": [[10, 50, 100, -1], [10, 50, 100, "All"]],
		        "pageLength": 100,
                "ajax": {"url":"<?php echo base_url() . 'Admin/ProductTransactionsDetail/GetData'; ?>",
                "data":function ( d ) { d.datefrom = datefrom;d.dateto=dateto;d.condtion='tere'}},
				"order": [[ 0, "desc" ]]
            });
                   
            $('#category_id').change(function(){
                var datefrom= $('#datefrom').val();
                var dateto= $('#dateto').val(); 
                var category_id=$('#category_id').val();
                var p_name =$('#si_for_year_id').val();
            $('#product').DataTable({
                "processing": true,
                "destroy": true,
                "serverSide": true,
				"lengthMenu": [[10, 50, 100, -1], [10, 50, 100, "All"]],
		        "pageLength": 100,                            
                "ajax": {"url":"<?php echo base_url().'Admin/ProductTransactionsDetail/GetData'; ?>",
                         "data":function ( d ) { d.datefrom = datefrom;d.dateto=dateto;d.category_id=category_id;d.p_name=p_name}},
                });
            });
            $('#si_for_year_id').change(function(){
                var datefrom= $('#datefrom').val();
                var dateto= $('#dateto').val(); 
                var category_id=$('#category_id').val();
                var p_name =$('#si_for_year_id').val();
            $('#product').DataTable({
                "processing": true,
                "destroy": true,
                "serverSide": true,  
				"lengthMenu": [[10, 50, 100, -1], [10, 50, 100, "All"]],
		        "pageLength": 100,                          
                "ajax": {"url":"<?php echo base_url().'Admin/ProductTransactionsDetail/GetData'; ?>",
                         "data":function ( d ) { d.datefrom = datefrom;d.dateto=dateto;d.category_id=category_id;d.p_name=p_name}},
                });
            });
</script>
</html>