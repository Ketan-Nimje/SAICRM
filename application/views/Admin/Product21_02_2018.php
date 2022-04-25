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
                <!-- Different data Product -->
                <!-- ============================================================== -->
                <div class="row">
                            <div class="col-lg-12 col-sm-12 col-xs-12">                               
                                <div class="white-box">
                                        <header>
                                            <ul class="nav nav-tabs" id="myTab">
                                                <li class="active"><a data-toggle="tab" href="#home" id="view">View</a></li>
                                                <li><a data-toggle="tab" href="#menu1">Add/Edit</a></li>
                                            </ul>
                                        </header>
                                        <div class="tab-content">
                                            <div id="home" class="tab-pane fade in active">    
                                                    <div class="panel">
                                                        <div class="panel-heading">MANAGE Product</div>
                                                        <div class="table-responsive">
                                                            <table id="product" class="table table-hover manage-u-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="70" class="text-center">#</th>
                                                                        <th>NAME</th>    
                                                                        <th width="250">CATEGORY</th>
                                                                        <th width="300">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>                            
                                            <div id="menu1" class="tab-pane fade">  
                                                    <div class="panel">
                                                      <div id="paneltitle" class="panel-heading">Add Product</div> 
                                                      <div id="panelupdate" class="panel-heading">Update Product</div> 
                                                    <form name="ff" class="form-horizontal" method="post"
                                                          action="<?php echo base_url() . 'Admin/' . $this->uri->segment(2) . '/addData'; ?>" id="form1">       
                                                            <div class="form-group">
                                                                <label class="col-md-12">Product Name <span class="help"> e.g. "Genius"</span></label>
                                                                <div class="col-md-12">
                                                                <input  type="hidden" name="hid" id="hid" >
                                                                <input type="text" name="p_name" id="p_name" class="form-control">
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="form-group checkbox checkbox-success">
                                                            	<div class="col-md-12">
                                                                    <input name="c_id" id="c_id" type="checkbox">
                                                                    <label for="c_id"> Is conversion Product  </label>
                                                                </div>
                                                            </div> 
                                                            
                                                             <div class="form-group " id="conversion" style="display: none;">
                                                                <label class="col-sm-12">Conversion Product Select </label>
                                                                <div class="col-sm-12">
                                                                    <select class="form-control" name="conversion_id" id="conversion_id">
                                                                         <option value="0">Select Product</option>
                                                                        <?php foreach ($product as $p_value) {
                                                                        echo "<option value='".$p_value['si_product_id']."'>".$p_value['p_name']."</option>";
                                                                        } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label class="col-sm-12">Category Select</label>
                                                                <div class="col-sm-12">
                                                                    <select class="form-control" name=" category_id" id="category_id">
                                                                        <option value="1">Installtion</option>
                                                                        <option value="2">Updatation</option>
                                                                        <option value="3">Lan</option>
                                                                        <option value="4">Conversion</option>    
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-sm-12">
                                                                <input type="submit" name="btn" id="btn_stm" class="btn btn-success aves-effect waves-light m-r-10" value="Add"> <input type="reset" class="btn btn-danger" value="Reset" id="reset" name="reset">
                                                                </div>
                                                            </div>                      
                                                    </form>
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
            var tbl = 'si_product';
            var cntrl = '<?php echo $this->uri->segment(2); ?>';            
            var tabs = $('#product').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "<?php echo base_url() . 'Admin/' . $this->uri->segment(2) . '/GetData'; ?>"
            });
            $('#product>tbody').on('click', '.status', function () {
                var id = $(this).data('id');
                var st = $(this).data('status');

                if (st != "A") {
                    var msg = "You won't be deactive this Product?";
                    var btn = 'Yes, De-active it!';
                    var title = "De-Activate";
                } else {
                    var msg = "You won't be active this Product?";
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
                        type: 'post',
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
            $('#product>tbody').on('click', '.delete', function () {
                var id = $(this).data('id');
                var st = $(this).data('status');
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
                        type: 'post',
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
            });
            $('#product>tbody').on('click', '.edit', function () {
                var id = $(this).data('id');
                $.ajax({
                    type: 'post',
                    data: {'id': id, 'tbl': tbl},
                    url: '<?php echo base_url('Helper/GetEditData'); ?>',
                    dataType: 'json',
                    success: function (data) {                        
                        $('#myTab a[href="#menu1"]').tab('show');
                        $('#paneltitle').hide();
                        $('#panelupdate').show();
                        $('#p_name').val(data.p_name);
                        $('#hid').val(data.si_product_id);                        
                        if(data.is_conversion_id=="0")
                        {
                            $('#conversion').fadeOut('slow'); 
                            $('#c_id').removeAttr("checked");                           
                        }
                        else
                        {
                            $('#conversion').fadeIn('slow');
                            $('#c_id').attr( "checked","checked" );
                        }
                        console.log('pr'+data.is_conversion_id);
                        $('#conversion_id').val(data.is_conversion_id);
                        $('#category_id').val(data.category_id);
                        $('#btn_stm').val('update');
                        $('#tblhid').val(tbl);
                        $('#tblcntrl').val(cntrl);
                        $('#editmenu').modal('show');
                    }
                });
            });


				$('#reset, #view').on('click',function(){
					$('#hid').val("");
					$('#btn_stm').val('Add');
					$('#paneltitle').show();
					$('#panelupdate').hide();
					$('.form-group input[type="text"]').val('');
				});        

        </script>
</html>