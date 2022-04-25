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
                                     class="alert <?php echo $this->session->userdata('errorcls'); ?> alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <?php echo $this->session->userdata('error'); ?> </div>
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
                  <div class="panel-heading">Clients Pending Details</div>
                  <div style='text-align: end;'>
                    <?php //print_r($selected); ?>
                    <a href="<?php echo  base_url('Admin/ProductPandingDetail/get_due_report'); ?>"> Due All 2020 Product</a>
                    <a href="<?php echo  base_url('Admin/ProductPandingDetail/get_due_report2021'); ?>"> Due All 2021 Product</a>
                  </div>
                  <div class="row ">
                    <form action="<?php echo base_url().'Admin/ProductPandingDetail/get_excel_data';?>">
                      <div class="col-sm-2 ">
                        <p>Product
                          <button type="button" id="sms_id" class="btn btn-info" onClick="send_multi_sms();$('#send_sms_btn').attr('type','submit');">Send Bulk SMS</button>
                        </p>
                        <select class="form-control" id="si_product_id" name="p_name" >
                          <option value="All" <?php if(!isset($selected['product'])) echo "selected";?> >All</option>
                          <?php
                                                           
                                                            foreach ($product as $p1) {  
                                                             $p_sel="";  
                                                            if($selected['product']==$p1['p_name'])
                                                                $p_sel="selected";   
                                                            echo "<option value='" . $p1['p_name'] . "'".$p_sel.">". $p1['p_name'] . "</option>";
                                                            }
                                                       
                                                            ?>
                        </select>
                        
                      
                        
                        <?php //print_r($selected); ?>
                      </div>
                      <div class="col-sm-2 ">
                        <p>
                          <button type="button" class="btn btn-dark" disabled="" >Year  Wise</button>
                        </p>
                        <select class="form-control" id="si_years_id" name="yearname" >
                          <option value="All" <?php if(!isset($selected['years'])) echo "selected";?> >Select Year</option>
                          <?php
                                            foreach ($years as $p1) {  
                                                             $p_sel="";  
                                                            if($selected['years']==$p1['yearname'])
                                                                $p_sel="selected";   
                                                            echo "<option value='" . $p1['yearname'] . "'".$p_sel.">". $p1['yearname'] . "</option>";
                                                            }
                                                       
                                                            ?>
                        </select>
                        </div>
                        <div class="col-sm-2 ">
                        <p>
                          <button type="button" class="btn btn-dark" disabled="" >Disable list</button>
                        </p>
                        <input type="checkbox" id="st_status" name="st_status" value="1"> 
                        </div>
                        
                      <div class="form-group col-sm-6"></div>
                      <div class="form-group col-sm-2">
                        <p></p>
                        <input type="submit" class="form-control pull-left" id="GetData" name="excel" style="background-color: #2ca958;" value="Excel">
                      </div>
                    </form>
                  </div>
                  <div class="table-responsive">
                    <table id="product" class="table table-hover optimize-table">
                      <thead>
                        <tr>
                          <th width="70" class="text-center"># &nbsp
                            <input type="checkbox" id="selectAllid" onClick="selectAll(this)"></th>
                          <th>Firm Name</th>
                          <th>Clients Name </th>
                          <th width="250">Serial No</th>
                          <th>Product Name</th>
                          <th>LAN</th>
                          <!-- <th>Address</th> 
                        <th>Purchase Date</th> -->
                          <th>Registed Mobile</th>
                          <th>Registed Email</th>
                          <th style="width:90px;">ACTION</th>
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
<div id="smsModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form  id="sms_form" >
        <input type="hidden" id="hid" name="hid" value="" >
        <div class="modal-header">
          <input type="hidden" id="numm">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body clearfix">
          <input type="hidden" id="mob" name="mob" value="" >
            <input type="hidden" id="serialno" name="serialno" value="" >
          <input type="hidden" id="pro_name" name="pro_name" value="" >
          <div class="form-group col-sm-6">
            <label for="send_from">From:</label>
            <input type="text" class="form-control" id="send_from" name="send_from" value="SAI INFOTECH" disabled>
          </div>
          <div class="form-group col-sm-4">
            <label for="send_to">To:</label>
            <input type="text" class="form-control" id="send_to" name="send_to" maxlength="10">
          </div>
          <div class="form-group col-sm-10 clearfix">
            <!--label for="send_msg">Message: <input type="radio"name="l" class="ch160" title="160 Character Limit" checked> 160 Character Limit <input type="radio"name="l" class="ch320" title="320 Character Limit"> 320 Character Limit</label-->
            
            <label for="">Message Type : 
              <input type="radio" name="mt" value="0" class="mt_normal" onClick="$('#send_msg').val('');countCharacter($('textarea#send_msg').val());" title="Send Normal SMS" checked>
              Normal 
              <input type="radio" name="mt" value="1" class="mt_custom" title="Send Custom SMS" onClick="fillCustomMessage();countCharacter($('textarea#send_msg').val());" >
              Custom </label>
               <label id="crview">Message Length/Credits : &nbsp;&nbsp;&nbsp; 0/0</label>
            <textarea class="msg form-control" id="send_msg" rows="7" onKeyPress="myf();"  name="send_msg" maxlength="999" onKeyUp="countCharacter(this.value);" placeholder="Your Message Here ..."></textarea>

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-inverse waves-effect waves-light" data-dismiss="modal">Close</button>
          <a target="_blank" class="adata_id" ><button send="btn"  class="btn btn-success waves-effect waves-light m-r-10" id="send_sms_btn" type="submit">Send SMS</button></a>
        </div>
      </form>
    </div>
  </div>
</div>
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
<div id="numModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
         <input type="hidden" id="numm">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body clearfix">
          <div class="form-group col-sm-5">
           
            <table border="2" align="center"  width="100%">
            <tr>
            <th> Number : </th>
            <th> Name : </th>
            <th>Serial No :</th>
            <th>Product :</th>
            </tr>
            <tbody id="all_num" > 
            </tbody>

            </table>
            </div>      
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-inverse waves-effect waves-light" data-dismiss="modal">Close</button>
          </div>
     </div>
  </div>
</div>
<script>

        $('.mydatepicker, #datepicker').datepicker({format: 'dd-mm-yyyy',orientation: "bottom", todayHighlight: true });
        $('#billpayment').change(function () {
        if ($(this).prop("checked")) {
            $('.billno').show()
        } else {
            $('.billno').hide()
        }
    });

        var tbl = 'si_transactions_detail';      
        var p_name =$('#si_product_id').val();                  
        $('#product').DataTable({
                "processing": true,
                "destroy": false,
                //"stateSave": true,
                "checkboxes": { 
                "selectRow": true } ,
                "serverSide": true,
                "lengthMenu": [[10, 50, 100,-1], [10, 50, 100,"ALL"]],
                "pageLength": 100, 
                "ajax": {
                  "url":"<?php echo base_url().'Admin/ProductPandingDetail/GetData'; ?>",
                "data":function (d) { d.p_name=p_name}} , 
        "aoColumnDefs": [{ 
          "bSortable": false, 
          "aTargets": [-9,-1] , 
        }], 
                 });
				 
        $('#si_product_id,#si_years_id').change(function(){  
		            
                var p_name = $('#si_product_id').val();
				        var yearname = $('#si_years_id').val();
				        
                if ($('#st_status').is(":checked"))
                {
                  var st_status= 1;
                }
                else{
                  var st_status= 0;
                }

            $('#product').DataTable({
                "processing": true,
                "destroy": true,
                "serverSide": true,  
                "lengthMenu": [[10, 50, 100, -1], [10, 50, 100, "All"]],
                "pageLength": 100,                          
                "ajax": {"url":"<?php echo base_url().'Admin/ProductPandingDetail/GetData'; ?>",
                       "data": { "p_name":p_name ,"st_status":st_status, "yearname":yearname}} ,
        "aoColumnDefs": [{ 
          "bSortable": false,  
          "aTargets": [-9,-1], 
                      }],  
                });
            }); 
      
      $("#product>tbody").on("click", ".sms", function () {
        var id=$(this).data('id');       
        $('#send_to').removeAttr("disabled onclick cu cn style title value");$('#send_to').attr("type","input");
        $('#send_to').val($(this).data('smsid'));
        $('#send_msg').val(''); $('#hid').val('1');
        $('.modal-title').html('Due Report SMS');
        $('#send_sms_btn').attr('type','submit');
        $('#send_sms_btn').html('Send SMS');
        $("#smsModal").modal({backdrop: 'static', keyboard: false});
     });
    
    $('#product>tbody').on('click', '.whatsapp', function () {    
        $('#send_to').val($(this).data('id')); 
        $('#numm').val($(this).data('id')); 
        $('#send_msg').val('Your Message Here');
        $('#send_to').attr('disabled','disabled');
        $('#send_sms_btn').attr('type','button');
        $('#send_sms_btn').html('WhatsApp Now');
        $("#smsModal").modal({backdrop: 'static', keyboard: false});
        });
    
    function myf() {
      n= $("#numm").val();
      var msg = $("#send_msg").val().replace(" ", "%20");
      var e ="https://web.whatsapp.com://send?phone=+91"+n+"&amp;text="+msg+"%20https://www.saiinfotech.co/Shoppingcart";
      $('.adata_id').attr('href',e);
    }
    function countCharacter(len) {
        len= len.length;
      cr =Math.ceil(len/145); 
    $('#crview').html("Message Length/Credits : &nbsp;&nbsp;&nbsp; "+ len +"/"+ cr ); 
  }
  
  
      $("#sms_form").submit(function (event) { event.preventDefault();
         mt=$("input[name='mt']:checked").val(); 

    var Mob= $("input[name=send_to]").val();
    var Msg=  $('textarea#send_msg').val();  
     Mob_reg = /^[5-9]{1}[0-9]{9}$/;  

     if($("input[id=hid]").val()==1) {
     if (Mob_reg.test(Mob) == false) {  
      $(".modal-title").html("<marquee style='color:red'>InValid Mobile Number !!!</marquee>"); 
      $('#send_to:visible').first().focus(); return false } }

     if (Msg.length< 5 ) {  
      $(".modal-title").html("<marquee style='color:red'>Too Short Message</marquee>"); 
      $('#send_msg:visible').first().focus(); return false }
       var formData = new FormData($("#sms_form")[0]); 
       var s=$("input[id=hid]").val();
      
      if(s==0) {  
        var selected = [];
        $(".delete:checked").each(function(){ 
            selected.push($(this).val()); 
          });

      var Con1 = confirm("Do You Want to Send SMS to All "+ selected.length +" Selected Customer ??  "); 

       if(Con1 == true) 
        { 
        alert("You're Going to Send SMS to All  !! ");   
        }
        else 
        { 
        $('#smsModal').modal('hide'); return false 
        } 
      } 

       else if(s==1) {  var Con2 = confirm("Do You Want to Send this SMS to "+Mob+" Customer ??  "); 
       if(Con2 == true) { alert("You're Going to Send SMS !!! ");  } else {    $('#smsModal').modal('hide'); return false } } 

       if(mt==0) 
        {
        url="<?php echo base_url().'Send-SMS'; ?>";  
        }
       else 
        {  
          url="<?php echo base_url().'Send-Custom-SMS';?>";  
        }
           
             $.ajax({
                 url: url,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (data)  {
          $('#smsModal').modal('hide');
        setTimeout(function () {  alert("You've Sent SMS Successfully !!! ");  }, 2000);
        },
         //setTimeout(function () {  $("#errdiv").hide();  }, 5000);
        error: function(){  alert("Something Went Wrong !!! "); }
        });
        return false;
    });
   
  //-------- Send Multiple ( Bulk ) SMS ------
      function send_multi_sms() { 
      $('#send_to').removeAttr("disabled");
        var selected = [];$(".delete:checked").each(function() {
        selected.push($(this).val());
      });
      var cn = [];
      var sn = [];
      var pn = [];
      $(".delete:checked").each(function() {
        cn.push($(this).attr("cn"));
        sn.push($(this).attr("sn"));
        pn.push($(this).attr("pn"));
      });
      // console.log(cn);
       var c = selected.length;
        if( c < 1)
        { alert("You've not selected  !!! "); return false  }
        else {
        $('#send_msg').val(''); $('#hid').val('0');
        $('.modal-title').html('Customer Number List');
        $("#smsModal").modal({backdrop: 'static', keyboard: false});
        $("#send_sms_btn").html('Send Bulk SMS');
        $("#mob").val(selected);
        $("#serialno").val(sn);
        $("#pro_name").val(pn);
        $("#send_to").attr({ 'style':'background-color : #d9c3e5', 'type':'button', 'cu':''+selected+'', 'cn':''+cn+'', 'sn':''+sn+'', 'pn':''+pn+'', 'class':'seeNumber form-control','onclick':'see_all_number()','title':'Click to View All Customer Number', 'value':'Total '+ c+' Customer' });
          
          }
      }
      function see_all_number() {
         $("#all_num").empty();
         var c=$("#send_to").attr("cu");
         var cn=$("#send_to").attr("cn");
         var sn=$("#send_to").attr("sn");
         var pn=$("#send_to").attr("pn");
         // console.log(c);
         cb = c.split(','); 
         c_name = cn.split(','); 
         serail_number = sn.split(',');   
         product_name = pn.split(','); 

      for(i=0; i < cb.length; i++) {  
        html='<tr><td> &nbsp&nbsp&nbsp&nbsp'+cb[i]+' &nbsp&nbsp&nbsp&nbsp</td><td> &nbsp'+c_name[i]+' </td><td> &nbsp'+serail_number[i]+' </td><td> &nbsp'+product_name[i]+' </td></tr>';
        $("#all_num").append(html); 
        }
      $("#numModal").modal({backdrop: 'static', keyboard: false});
      
      }
  //-------- Send Multiple ( Bulk ) SMS ------
        function selectAll(source) {
            checkboxes = document.getElementsByName('id[]');
            for (var i = 0, n = checkboxes.length; i < n; i++) {
                checkboxes[i].checked = source.checked; }
          }
//-----------------------fillCustomMessage------------------
    function fillCustomMessage()
      {
      custom_msg = '{ProductName} : YOUR {ProductName} SR NO - {SerialNumber} IS DUE FOR AY 2019-20. PLEASE CONTACT US TO UPDATE THE SOFWTARE. IF ALREADY UPDATED PLEASE IGNORE SAI INFOTECH 0261-2369109,4897600'; 
      $('#send_msg').val(custom_msg);
      
      }
//-----------------------fillCustomMessage------------------


                       
</script>
</html>