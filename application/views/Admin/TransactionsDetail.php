<html>
<head>

    <?php $this->load->view('template/headerlink'); ?>    
</head>

<body class="fix-header">
    <!-- ============================================================== -->
    <!-- Wrapper -->
    <?php  if(!$this->session->userdata('Passcode')) { ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>
    <script>
        (async function passcode () {
        const {value: password} = await 
        swal({
       title: 'Enter the Passcode ', confirmButtonText: 'Check Passcode !!', confirmButtonColor: '#8808b2',
          // text: "Type Your Passcode to see Dashboard ",
            type: 'warning',
      customClass: 'bounceInDown',
      animation: true,
      allowOutsideClick: false,
      allowEscapeKey:false,
      input: 'password',
      width: 999,
      padding: '12em',
      backdrop: "radial-gradient(white,purple,blue,pink,green,black,yellow)",
      html:'<h1>Type Your Passcode to see Dashboard OR <a href="<?php echo base_url('Client');?>">View Client </a> OR <a href="<?php echo base_url('Helper/logout');?>">Log Out</a></h1>',
      //background: '#fff url(/Saiinfotech/saicrm/assetss/alert.gif)',
      inputPlaceholder: 'Enter the Passcode'
      })
      
       var tt = $('.swal2-input').val();
      //console.log(tt);
      
      if (tt=='') { location.reload(); return false;}
      else {
        $.ajax({
        type:"POST",
              url: "<?php echo base_url('Admin/AdminDashboard/Passcode'); ?>",
              data :{"passcode":tt},
              dataType:"json",
              success:function(e)
            {   
            if(e==1) {  
            location.reload();
              }
              else { 
                swal({
       title: 'Wrong Passcode !!',
             text: "Wait 2-3 Seconds to Retry .....",
             type: 'error', customClass: 'tada',
       animation: true,
       allowOutsideClick: false,
         //width: 999,
         //padding: '12em',
       showConfirmButton: false,
       backdrop: "radial-gradient(white,purple,blue,pink,green,black,yellow)",
                })
      setTimeout(function(){location.reload();},2345);
        }
          },error: function(){ location.reload(); }     
        });
      }
    }) ()
  </script>
<?php 
die;
} ?>

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
                                                <li><a data-toggle="tab" href="#menu1">Add/Edit</a></li>
                                            </ul>
                                        </header>
                                        <div class="tab-content">
                                            <div id="home" class="tab-pane fade in active">    
                                                    <div class="panel">
                                                        <div class="panel-heading">Manage TransactionsDetail</div>
                                                        <div class="table-responsive">
                                                            <table id="product" class="table table-hover manage-u-table manage-u-table-none optimize-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th > # </th>
                                                                        <th>Clients Name </th>    
                                                                        <th>Product Name</th>
                                                                        <th>Serial No </th>
                                                                        <th>Group</th>   
                                                                        <th>Session</th>
                                                                        <th>Amount</th>
                                                                        <th>Purchase Amount</th>    
                                                                        <th>Tax Amount</th>    
                                                                        <th>LAN</th>    
                                                                        <th>LAN Amount</th> 
                                                                        <th>Bill Number</th>
                                                                        <th>Payment Type</th>    
                                                                        <th>Bill Remarks</th>    
                                                                        <th>Transactions Date</th>    
                                                                        <th style="min-width: 80px;">Action</th>
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
                                                      <div id="paneltitle" class="panel-heading">Add TransactionsDetail </div> 
                                                      <div id="panelupdate" class="panel-heading">Update TransactionsDetail</div> 
                                                    <form name="ff" class="form-horizontal" method="post"
                                                          action="<?php echo base_url() . 'Admin/' . $this->uri->segment(2) . '/addData'; ?>">  
                                                          <div class="form-group">
                                                                <label class="col-md-12">Client </label>
                                                                <div class="col-md-6">
                                                                <select class="form-control" name="si_clients_id" id="si_clients_id">
                                                                         <option value="0">Select Client</option>
                                                                        <?php foreach ($client as $c_value) {
                                                                        echo "<option value='".$c_value['si_clients_id']."'>".$c_value['contact_person']."</option>";
                                                                        } ?>
                                                                    </select> 
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-12">Product </label>
                                                                <div class="col-md-6">
                                                                <select class="form-control" name="si_clients_details_id" id="si_clients_details_id">
                                                                         <!-- <option value="0">Select Product</option>  -->     
                                                                    </select> 
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-12">For Year </label>
                                                                <div class="col-md-6">
                                                                <select class="form-control" name=" for_year" id="for_year">
                                                                         <option value="0">Select Year</option>
                                                                        <?php foreach ($for_year as $y_value) {
                                                                        echo "<option value='".$y_value['yearname']."'>".$y_value['yearname']."</option>";
                                                                        } ?>
                                                                    </select> 
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-12">Amount <span class="help"> E.g. "1500"</span></label>
                                                                <div class="col-md-6">
                                                                <input  type="hidden" name="hid" id="hid" >
                                                               <input class="form-control" id="amount" name="amount" placeholder="Amount" type="text">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-12">Payment By</label>
                                                                <div class="col-md-6">
                                                                <div class="white-box bg-white-dark optimize-box m-b-0 clearfix" style="padding: 0px 12px 5px;"> 
                                                                        <div class="bank-transfers clearfix">
                                                                            <div class="radio radio-primary">
                                                                                <input name="payment_type" id="Bank" value="Bank" type="radio">
                                                                                <label for="Bank"> Bank </label>
                                                                            </div>
                                                                            <div class="radio radio-success">
                                                                                <input name="payment_type" id="Check" value="Check" type="radio">
                                                                                <label for="Check"> Check </label>
                                                                            </div>
                                                                            <div class="radio radio-info">
                                                                                <input name="payment_type" id="Online" value="Online" type="radio">
                                                                                <label for="Online"> Online </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                <label class="col-md-12">Bill </label>
                                                                <div class="col-md-12">
                                                                <input id="billpayment" name="isbill" type="checkbox" value="1">
                                                               
                                                                </div>
                                                            </div>                                                            
                                                                        <div class="form-group billno" style="display: none;">
                                                                <div class="col-md-12">
                                                                <input class="form-control" id="billnumber" name="billnumber" placeholder="Bill No" type="text">
                                                                </div>
                                                            </div>                                                  <div class="form-group">
                                                                <label class="col-md-12">Bill Remarks</label>
                                                                <div class="col-md-12">
                                                                <textarea class="form-control" id="billremarks" name="billremarks" rows="5" placeholder="Remarks"></textarea>
                                                                </div>
                                                            </div>                     
                                                                        </div>
                                                                </div>
                                                            </div> 

                                                            <div class="form-group">
                                                                <div class="col-sm-12">
                                                                <!--input type="submit" name="btn" id="btn_stm" class="btn btn-success aves-effect waves-light m-r-10" value="Add"--> <input type="reset" class="btn btn-danger" value="Reset" id="reset" name="reset">
                                                                </div>
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
        $('#billpayment').change(function () {
        if ($(this).prop("checked")) {
            $('.billno').show()
        } else {
            $('.billno').hide()
        }
    });
            var tbl = 'si_transactions_detail';
            $('#panelupdate').hide();
            var cntrl = '<?php echo $this->uri->segment(2); ?>';            
            var tabs = $('#product').DataTable({
                "processing": true,
                "serverSide": true,
                "lengthMenu": [[10, 50, 100, -1], [10, 50, 100, "All"]],
                "pageLength": 100,
                "order": [[ 0, "desc" ]],
                "ajax": "<?php echo base_url() . 'Admin/TransactionsDetail/GetData'; ?>",
                "aoColumnDefs": [{ 'bSortable': false,'aTargets': [0,-1]  }],
            });
            $('#product>tbody').on('click', '.status', function () {
                var id = $(this).data('id');
                var st = $(this).data('status');

                if (st != "A") {
                    var msg = "You won't be deactive this Transactions?";
                    var btn = 'Yes, De-active it!';
                    var title = "De-Activate";
                } else {
                    var msg = "You won't be active this Transactions?";
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
                                        'Selected Year has been ' + title + '.',
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
                                'Your imaginary Transactions is safe :)',
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
                    text: "You won't be delete this Transactions",
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
                                        'Selected Transactions has been  Deleted.',
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
                                'Your imaginary Transactions is safe :)',
                                'error'
                                )
                    }
                })
            });
            //payment_type
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
                        $('#hid').val(data.si_transactions_detail_id);
                        $('#for_year').find('option').remove();
                        $('#for_year').append($("<option></option>")
                                    .attr("value", data.for_year)
                                    .text(data.for_year));
                        $('#si_clients_details_id').find('option').remove();
                        $('#si_clients_details_id').append($("<option></option>")
                                    .attr("value", data.si_clients_details_id)
                                    .text(data.p_name));
                        //$('#'+data.payment_type).val(data.payment_type);

                        $('input[name=payment_type]:checked', '#ff').val(data.payment_type);
                        $('#amount').val(data.amount);
                        if(data.is_bill==1)
                        {                            
                          $('#billpayment').attr("checked", "checked");
                          $('.billno').show()
                        }
                        $('#si_clients_id').val(data.si_clients_id).attr("selected", "selected");
                        $('#billnumber').val(data.billnumber);
                        $('#billremarks').val(data.billremarks);
                        $('#btn_stm').val('update');
                        $('#tblhid').val(tbl);
                        $('#tblcntrl').val(cntrl);
                        $('#editmenu').modal('show');
                    }
                });
            });
            $('#si_clients_id').change(function () {
                var end = this.value;                
                //console.log('vaie'+end);
                 $.ajax({
                        type: 'post',
                        data: {'si_clients_id': end},
                        url: '<?php echo base_url('Admin/TransactionsDetail/get_product'); ?>',
                        dataType: 'json',
                        success: function (data) {
                             $('#si_clients_details_id').find('option').remove();
                    $('#si_clients_details_id')
                            .append($("<option></option>")
                                    .attr("value", 0)
                                    .text('Selected Product'));
                    $.each(data.product, function (key, value) {
                        $('#si_clients_details_id')
                                .append($("<option></option>")
                                        .attr("value", value.si_clients_details_id)
                                        .text(value.p_name));
                        //console.log('value : '+value.p_name);
                    });
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