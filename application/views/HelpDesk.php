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
                <!-- Different data HelpDesk -->
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
                                                        <div class="panel-heading">MANAGE HelpDesk</div>
                                                        <div class="table-responsive">
                                                            <table id="product" class="table table-hover manage-u-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="70" class="text-center">#</th>
                                                                        <th width="250">NAME</th>    
                                                                        <th width="300">Link</th>    
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
            var tbl = 'si_helpdesk';
            var cntrl = '<?php echo $this->uri->segment(1); ?>';            
            var tabs = $('#product').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "<?php echo base_url($this->uri->segment(1) . '/GetData') ; ?>"
            });
        </script>
</html>