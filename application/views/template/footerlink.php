<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="<?php echo base_url(); ?>assetss/plugins/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Data Tables JavaScript -->
<script src="<?php echo base_url(); ?>assetss/plugins/bower_components/datatables/jquery.dataTables.min.js"></script>        
<!-- Bootstrap Core JavaScript -->
<script src="<?php echo base_url(); ?>assetss/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Menu Plugin JavaScript -->
<script src="<?php echo base_url(); ?>assetss/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
<!--  sweetalert JavaScript -->
<script src="<?php echo base_url(); ?>assetss/js/sweetalert2.min.js"></script>
<script src="<?php echo base_url(); ?>assetss/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<!--slimscroll JavaScript -->
<script src="<?php echo base_url(); ?>assetss/js/jquery.slimscroll.js"></script>
<!--Wave Effects -->
<script src="<?php echo base_url(); ?>assetss/js/waves.js"></script> 
<script src="<?php echo base_url(); ?>assetss/js/validator.js"></script>    
<script>
    $(".userNotify").click(function () {
        var id = $(this).data('id');
        $.ajax({
            type: 'post',
            data: {'id': id},
            url: '<?php echo base_url('Admin/SmsReport/UpdateSmsSeen'); ?>',
            dataType: 'json',
            success: function (data) {

                window.location.href = "<?php echo base_url('Admin/SmsReport'); ?>";
            }
        });
    });

    $(".allNotify").click(function () {
//            alert("hi"); 
        var id;
        $(".userNotify").each(function () {
            id = $(this).data('id');
            $.ajax({
                type: 'post',
                data: {'id': id},
                url: '<?php echo base_url('Admin/SmsReport/UpdateSmsSeen'); ?>',
                dataType: 'json',
                success: function (data) {
                    window.location.href = "<?php echo base_url('Admin/SmsReport'); ?>";
                }
            });
        });

    });
$(document).ready(function(e) {
            count_calls_live();
        });
        
    $('#notifications>tbody').on('click', '.se', function () {
        var f=$(this).data('id');
        
        if(window.location.href=='<?php echo base_url('Client')?>') {
            $('#notifications_modal').modal('hide');
            $('input[type=search]').val(f);
            $('input[type=search]').focus();
            tabs.search(f).draw();
        }
        
        else 
        {   gg=confirm('You are not on Client View Page, Do You Want to Go Client View Page ? '); 
        if(gg==true){  window.location.href = "<?php echo base_url('Client'); ?>";  }  }
                
                        
            });

    
</script>