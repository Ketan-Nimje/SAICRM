<!-- ============================================================== -->
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<?php if ($this->session->userdata('role') == "SA"){ ?>

<div class="navbar-default sidebar" role="navigation">
  <div class="sidebar-nav">
    <div class="sidebar-head">
      <h3><span class="fa-fw open-close"><i class="ti-menu hidden-xs"></i><i class="ti-close visible-xs"></i></span> <span class="hide-menu">Navigation</span></h3>
    </div>
    <ul class="nav" id="side-menu">
      <li class="user-pro"> <a href="javascript:void(0)" class="waves-effect"><img src="<?php echo base_url(); ?>assetss/plugins/images/users/varun.jpg" alt="user-img" class="img-circle"> <span class="hide-menu"> <span class="fa arrow"></span></span> </a>
        <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
          <li><a href="javascript:void(0)"><i class="ti-user"></i> <span class="hide-menu">My Profile</span></a></li>
          <li><a href="javascript:void(0)"><i class="ti-settings"></i> <span class="hide-menu">Account Setting</span></a></li>
          <li><a href="javascript:void(0)"><i class="fa fa-power-off"></i> <span class="hide-menu">Logout</span></a></li>
        </ul>
      </li>
      <li> <a href="<?php echo base_url(); ?>Admin/AdminDashboard" class="waves-effect active"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> <span class="hide-menu"> Dashboard <span class="fa arrow"></span> <span class="label label-rouded label-inverse pull-right">4</span></span></a> </li>
      <li> <a href="javascript:void(0)" class="waves-effect"><i class="mdi mdi-table fa-fw"></i> <span class="hide-menu">Tables<span class="fa arrow"></span><span class="label label-rouded label-danger pull-right">9</span></span></a>
        <ul class="nav nav-second-level">
          <li><a href="<?php echo base_url(); ?>Admin/Client"><i class="fa-fw">C</i><span class="hide-menu">Client Master</span></a></li>
          <li><a href="<?php echo base_url(); ?>Client"><i class="fa-fw">V</i><span class="hide-menu">Client View</span></a></li>
          <li><a href="<?php echo base_url(); ?>Admin/TransactionsDetail"><i class="fa-fw">T</i><span class="hide-menu">Transactions Master</span></a></li>
          
          <!-- <li><a href="table-layouts.html"><i class="fa-fw">L</i><span class="hide-menu">Table Layouts</span></a></li>
                        <li><a href="data-table.html"><i class="fa-fw">D</i><span class="hide-menu">Data Table</span></a></li>
                        <li><a href="bootstrap-tables.html"><i class="fa-fw">B</i><span class="hide-menu">Bootstrap Tables</span></a></li>
                        <li><a href="responsive-tables.html"><i class="fa-fw">R</i><span class="hide-menu">Responsive Tables</span></a></li>
                        <li><a href="editable-tables.html"><i class="fa-fw">E</i><span class="hide-menu">Editable Tables</span></a></li>
                        <li><a href="foo-tables.html"><i class="fa-fw">F</i><span class="hide-menu">FooTables</span></a></li>
                        <li><a href="jsgrid.html"><i class="fa-fw">J</i><span class="hide-menu">JsGrid Tables</span></a></li> -->
        </ul>
      </li>
      <li class="last-nav"><a href="javascript:void(0)" class="waves-effect"><i class="mdi mdi-apps fa-fw"></i> <span class="hide-menu">Configuration<span class="fa arrow"></span></span></a>
        <ul class="nav nav-second-level">
          <li><a href="<?php echo base_url('Admin') ?>/Product"><i class="ti-comments-smiley fa-fw"></i><span class="hide-menu">Product</span></a></li>
          <li><a href="<?php echo base_url('Admin') ?>/State" class="waves-effect"><i class="ti-user fa-fw"></i><span class="hide-menu">State</span></a> </li>
          <li><a href="<?php echo base_url('Admin') ?>/Foryear" class="waves-effect"><i class="ti-user fa-fw"></i><span class="hide-menu">Foryear</span></a> </li>
          <li> <a href="<?php echo base_url('Admin') ?>/Gstkey" class="waves-effect"><i class="mdi mdi-chart-bar fa-fw"></i> <span class="hide-menu">GST Key</span></a> </li>
        </ul>
      </li>
      <li class="last-nav"><a href="javascript:void(0)" class="waves-effect"><i class="mdi mdi-apps fa-fw"></i> <span class="hide-menu">Accounts<span class="fa arrow"></span></span></a>
        <ul class="nav nav-second-level">
          <li><a href="<?php echo base_url('Admin') ?>/Sadmin"><i class="ti-user fa-fw"></i><span class="hide-menu">Administrators</span></a></li>
          <li><a href="<?php echo base_url('Admin') ?>/Priviliegs" class="waves-effect"><i class="ti-user fa-fw"></i><span class="hide-menu">User Priviliges</span></a></li>
          <li><a href="<?php echo base_url('Admin') ?>/MenuAssign" class="waves-effect"><i class="ti-user fa-fw"></i><span class="hide-menu">Menu Assign</span></a></li>
        </ul>
      </li>
      <li class="last-nav"><a href="javascript:void(0)" class="waves-effect"><i class="mdi mdi-file fa-fw"></i> <span class="hide-menu">Reports<span class="fa arrow"></span></span></a>
        <ul class="nav nav-second-level">
          <li><a href="<?php echo base_url('Admin') ?>/SmsReport"><i class="mdi mdi-gmail fa-fw"></i><span class="hide-menu">SMS Report</span></a></li>
          <li><a href="<?php echo base_url('Admin') ?>/AccountReport"><i class="mdi mdi-apps fa-fw"></i><span class="hide-menu">Account Report</span></a></li>
          <li><a href="<?php echo base_url('Admin') ?>/ProductTransactionsDetail"><i class="mdi mdi-apps fa-fw"></i><span class="hide-menu">Transactions Report</span></a></li>
          <li><a href="javascript:void(0)"><i class="mdi mdi-file fa-fw"></i><span class="hide-menu">Extra Report(s)</span></a>
        <ul class="nav nav-third-level pull-right" >
           <li><a href="<?php echo base_url('Admin') ?>/ProductPandingDetail" style="color:red"><i class="mdi mdi-apps fa-fw"></i><span class="hide-menu">Due Report</span></a></li>
          <li><a href="<?php echo base_url('Admin') ?>/GstReport" style="color:red"><i class="mdi mdi-file fa-fw"></i><span class="hide-menu">Gst Updation Report</span></a></li>
            <li><a href="<?php echo base_url('Admin') ?>/LogsReport" style="color:red"><i class="mdi mdi-file fa-fw"></i><span class="hide-menu">Logs Report</span></a>
              <li><a href="<?php echo base_url('Admin') ?>/ClientReport" style="color:red"><i class="mdi mdi-file fa-fw"></i><span class="hide-menu">ClientReport</span></a></li>
              <li><a href="<?php echo base_url('Client-Report-Product') ?>" style="color:red"><i class="mdi mdi-file fa-fw"></i><span class="hide-menu">Product-Report</span></a></li>
        </ul>
           </li>
        
      </li>
      </ul>
         </li>
      <li class="devider"></li>
      <li> <a href="<?php echo base_url('Admin') ?>/HelpDesk" class="waves-effect"><i  class="mdi mdi-settings fa-fw"></i> <span class="hide-menu">Help</span></a> </li>
      <li> <a href="<?php echo base_url('Admin') ?>/Inquiry" class="waves-effect"><i  class="mdi mdi-phone fa-fw"></i> <span class="hide-menu">Inquiry</span></a> </li>
    </ul>
    <ul class="nav navbar-top-links navbar-right pull-right">
      <style>
.inq_scroll { height:450px; overflow-y: scroll;  } 
</style>
      <?php
                $sql = "select cs.si_customer_solution_id,cs.si_admin_id,p.p_name,csh.remark,sa.name,cs.created_date,cs.status,csh.cs_proccess from si_customer_solution cs
                                inner join si_customer_solution_history csh on csh.si_customer_solution_id = cs.si_customer_solution_id
        inner join si_product as p on p.si_product_id=cs.si_product_id
        inner join si_clients as sic on sic.si_clients_id=cs.si_clients_id
        inner join si_admin as sa on sa.si_admin_id=cs.si_admin_id
        where cs.status IN ('A','D') and csh.cs_proccess='H' and  cs.is_seen = 'U' GROUP BY cs.si_admin_id order by cs.si_customer_solution_id desc";
                $staffnotify = $this->Data_model->Custome_query($sql);
                ?>
      <?php  $abc="SELECT inquiry_name as inm,inquiry_mobile as mob,inquiry_completion_status as ics from si_inquiry_detail 
    WHERE CHAR_LENGTH(next_follow_date) >3  AND status='A' 
     AND next_follow_date <= CURDATE() AND inquiry_completion_status IN ('L','P') ORDER BY next_follow_date DESC ";
                $ab = $this->Data_model->Custome_query($abc);
        ?>
      <?php if(count($ab)!=0) { ?>
      <li class="dropdown"><a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="javascript:void(0)"> <i class="mdi mdi-bell" style="vertical-align: middle;"></i> ( <?php echo count($ab); ?> ) Inquiry
        <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
        </a>
        <ul class="dropdown-menu mailbox animated bounceInDown">
          <li>
            <div class="drop-title"> <?php echo count($ab); ?> Inquiry Notifications </div>
          </li>
          <li>
            <div class="inq_scroll message-center">
              <?php foreach ($ab as $ab) {   
         if($ab['ics']=='L'){ $mark=' style="background-color:#e2c7e2;" title="This Notification is of Low interest Category" ';} else{ $mark=''; }
         ?>
              <a href="javascript:void(0)" class="inqNotify"  data-id="" <?php echo $mark; ?>>
              <div class="mail-contnet"> <span class="mail-desc">
                <?php 
      echo $ab['inm']." : ".$ab['mob']; 
         ?>
                </span> 
                <!--span class="time"><?php //echo $sn['created_date']; ?></span--> 
              </div>
              </a>
              <?php } ?>
            </div>
          </li>
          <?php if(count($ab)>10) { ?>
          <li> <a class="text-center allNotify" href="javascript:void(0);"> <strong>See all notifications</strong> <i class="fa fa-angle-right"></i> </a> </li>
          <?php } ?>
        </ul>
        <!-- /.dropdown-messages --> 
      </li>
      <?php } ?>
      <!---------------Notification ------------------------------------------>
      <li class="dropdown"> <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="javascript:void(0)"> <i class="mdi mdi-gmail" style="vertical-align: middle;"></i> Staff
        <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
        </a>
        <ul class="dropdown-menu mailbox animated bounceInDown">
          <li>
            <div class="drop-title">You have <?php echo count($staffnotify); ?> new messages</div>
          </li>
          <li>
            <div class="message-center">
              <?php foreach ($staffnotify as $sn) { ?>
              <a href="javascript:void(0)" class="userNotify" id="userNotify<?php echo $sn['si_admin_id'] ?>" data-id="<?php echo $sn['si_admin_id'] ?>"> 
              <!--                                        <div class="user-img"> <img src="../plugins/images/users/pawandeep.jpg" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>-->
              <div class="mail-contnet">
                <h5><?php echo $sn['name']; ?></h5>
                <span class="mail-desc"><?php echo(strlen($sn['remark']) >= 22 ? substr($sn['remark'], 0, 20) . "..." : $sn['remark']); ?></span> <span class="time"><?php echo $sn['created_date']; ?></span> </div>
              </a>
              <?php } ?>
              <!--                                    <a href="javascript:void(0)">
                                                                        <div class="user-img"> <img src="../plugins/images/users/sonu.jpg" alt="user" class="img-circle"> <span class="profile-status busy pull-right"></span> </div>
                                                                        <div class="mail-contnet">
                                                                            <h5>Sonu Nigam</h5> <span class="mail-desc">I've sung a song! See you at</span> <span class="time">9:10 AM</span> </div>
                                                                    </a>
                                                                    <a href="javascript:void(0)">
                                                                        <div class="user-img"> <img src="../plugins/images/users/arijit.jpg" alt="user" class="img-circle"> <span class="profile-status away pull-right"></span> </div>
                                                                        <div class="mail-contnet">
                                                                            <h5>Arijit Sinh</h5> <span class="mail-desc">I am a singer!</span> <span class="time">9:08 AM</span> </div>
                                                                    </a>
                                                                    <a href="javascript:void(0)">
                                                                        <div class="user-img"> <img src="../plugins/images/users/pawandeep.jpg" alt="user" class="img-circle"> <span class="profile-status offline pull-right"></span> </div>
                                                                        <div class="mail-contnet">
                                                                            <h5>Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:02 AM</span> </div>
                                                                    </a>--> 
            </div>
          </li>
          <li> <a class="text-center allNotify" href="javascript:void(0);"> <strong>See all notifications</strong> <i class="fa fa-angle-right"></i> </a> </li>
        </ul>
        <!-- /.dropdown-messages --> 
      </li>
      <!--</ul>-->
      <li class="dropdown"> <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="javascript:void(0)"> <img src="<?php echo base_url(); ?>assetss/plugins/images/users/varun.jpg" alt="user-img" width="36" class="img-circle"><b class="hidden-xs"><?php echo $_SESSION['name']; ?></b><span class="caret"></span> </a>
        <ul class="dropdown-menu dropdown-user animated flipInY">
          <li>
            <div class="dw-user-box">
              <div class="u-img"><img src="<?php echo base_url(); ?>assetss/plugins/images/users/varun.jpg" alt="user" /></div>
              <div class="u-text">
                <h4><?php echo $_SESSION['name']; ?></h4>
              </div>
            </div>
          </li>
          <li role="separator" class="divider"></li>
          <li><a href="javascript:void(0)"><i class="ti-user"></i> My Profile</a></li>
          <li><a href="#" onClick="$('#reset_password').modal('show');"><i class="fa fa-key"></i> <span class="hide-menu">Reset Password</span></a></li>
          <li role="separator" class="divider"></li>
          <li><a href="javascript:void(0)"><i class="ti-settings"></i> Account Setting</a></li>
          <li role="separator" class="divider"></li>
          <li> <a href="<?php echo base_url() . $this->config->item('admin'); ?>Helper/Logout"><i class="fa fa-power-off"></i> Logout</a></li>
        </ul>
      </li>
    </ul>
    <!-----  Notification for logs------------------->
    <ul class="nav navbar-top-links navbar-right pull-right">
      <li class="dropdown"><a onclick="notifications_modal();" class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="javascript:void(0)"> <i class="mdi mdi-phone" style="vertical-align: middle;"> </i> <b id="SA_count_calls"></b> Calls
<b  style="color:red"id="SA_count_calls1"></b>        <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
        </a> </li>
    </ul>
    <!-----  Notification for logs-------------------> 
    
  </div>
</div>
<?php } else if ($this->session->userdata('role') == 'A') {  ?>
<div class="navbar-default sidebar" role="navigation">
  <div class="sidebar-nav">
    <div class="sidebar-head">
      <h3><span class="fa-fw open-close"><i class="ti-menu hidden-xs"></i><i class="ti-close visible-xs"></i></span> <span class="hide-menu">Navigation</span></h3>
    </div>
    <ul class="nav" id="side-menu">
      <li class="user-pro"> <a href="javascript:void(0)" class="waves-effect"><img src="<?php echo base_url(); ?>assetss/plugins/images/users/varun.jpg" alt="user-img" class="img-circle"> <span class="hide-menu"> <span class="fa arrow"></span></span> </a>
        <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
          <li><a href="javascript:void(0)"><i class="ti-user"></i> <span class="hide-menu">My Profile</span></a></li>
          <li><a href="javascript:void(0)"><i class="ti-settings"></i> <span class="hide-menu">Account Setting</span></a></li>
          <li><a href="javascript:void(0)"><i class="fa fa-power-off"></i> <span class="hide-menu">Logout</span></a></li>
        </ul>
      </li>
      <li> <a href="<?php echo base_url(); ?>Dashboard" class="waves-effect active"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> <span class="hide-menu"> Dashboard <span class="fa arrow"></span> <span class="label label-rouded label-inverse pull-right">4</span></span></a> </li>
      <li> <a href="javascript:void(0)" class="waves-effect"><i class="mdi mdi-table fa-fw"></i> <span class="hide-menu">Tables<span class="fa arrow"></span><span class="label label-rouded label-danger pull-right">9</span></span></a>
        <ul class="nav nav-second-level">
          <li><a href="<?php echo base_url(); ?>Client"><i class="fa-fw">C</i><span class="hide-menu">Client View</span></a></li>
          <!--<li><a href="<?php echo base_url(); ?>Cproduct"><i class="fa-fw">P</i><span class="hide-menu">Product Master</span></a></li>--> 
          <!-- <li><a href="table-layouts.html"><i class="fa-fw">L</i><span class="hide-menu">Table Layouts</span></a></li>
                        <li><a href="data-table.html"><i class="fa-fw">D</i><span class="hide-menu">Data Table</span></a></li>
                        <li><a href="bootstrap-tables.html"><i class="fa-fw">B</i><span class="hide-menu">Bootstrap Tables</span></a></li>

                        <li><a href="responsive-tables.html"><i class="fa-fw">R</i><span class="hide-menu">Responsive Tables</span></a></li>
                        <li><a href="editable-tables.html"><i class="fa-fw">E</i><span class="hide-menu">Editable Tables</span></a></li>
                        <li><a href="foo-tables.html"><i class="fa-fw">F</i><span class="hide-menu">FooTables</span></a></li>
                        <li><a href="jsgrid.html"><i class="fa-fw">J</i><span class="hide-menu">JsGrid Tables</span></a></li> -->
        </ul>
      </li>
      <li class="devider"></li>
      <li> <a href="<?php echo base_url('HelpDesk') ?>" class="waves-effect"><i  class="mdi mdi-settings fa-fw"></i> <span class="hide-menu">Help</span></a> </li>
      <!--                <li class="last-nav"><a href="javascript:void(0)" class="waves-effect"><i class="mdi mdi-apps fa-fw"></i> <span class="hide-menu">Configuration<span class="fa arrow"></span></span></a>
                    <ul class="nav nav-second-level">
                         <li><a href="<?php echo base_url('') ?>Product"><i class="ti-comments-smiley fa-fw"></i><span class="hide-menu">Product</span></a></li>
                        <li><a href="<?php echo base_url('') ?>State" class="waves-effect"><i class="ti-user fa-fw"></i><span class="hide-menu">State</span></a>
                        </li>
                        <li><a href="<?php echo base_url('') ?>Foryear" class="waves-effect"><i class="ti-user fa-fw"></i><span class="hide-menu">Foryear</span></a>
                        </li>
                        <li> <a href="<?php echo base_url('') ?>Gstkey" class="waves-effect"><i class="mdi mdi-chart-bar fa-fw"></i> <span class="hide-menu">GST Key</span></a>
                        </li> 

                    </ul>
                </li>--> 
      <!-- <li class="devider"></li>
                <li> <a href="widgets.html" class="waves-effect"><i  class="mdi mdi-settings fa-fw"></i> <span class="hide-menu">Widgets</span></a> </li> -->
    </ul>
    <ul class="nav navbar-top-links navbar-right pull-right">
      <li class="dropdown"> <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="javascript:void(0)"> <img src="<?php echo base_url(); ?>assetss/plugins/images/users/varun.jpg" alt="user-img" width="36" class="img-circle"><b class="hidden-xs"><?php echo $_SESSION['name']; ?></b><span class="caret"></span> </a>
        <ul class="dropdown-menu dropdown-user animated flipInY">
          <li>
            <div class="dw-user-box">
              <div class="u-img"><img src="<?php echo base_url(); ?>assetss/plugins/images/users/varun.jpg" alt="user" /></div>
              <div class="u-text">
                <h4><?php echo $_SESSION['name']; ?></h4>
              </div>
            </div>
          </li>
          <li role="separator" class="divider"></li>
          <li><a href="javascript:void(0)"><i class="ti-user"></i> My Profile</a></li>
          <li><a href="#" onClick="$('#reset_password').modal('show');"><i class="fa fa-key"></i> <span class="hide-menu">Reset Password</span></a></li>
          <li role="separator" class="divider"></li>
          <li><a href="javascript:void(0)"><i class="ti-settings"></i> Account Setting</a></li>
          <li role="separator" class="divider"></li>
          <li> <a href="<?php echo base_url() . $this->config->item('admin'); ?>Helper/Logout"><i class="fa fa-power-off"></i> Logout</a></li>
        </ul>
      </li>
    </ul>
    
    <!-----  Notification for logs------------------->
    <ul class="nav navbar-top-links navbar-right pull-right">
      <li class="dropdown"><a onclick="notifications_modal();" class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="javascript:void(0)"> <i class="mdi mdi-phone" style="vertical-align: middle;"> </i> <b id="SA_count_calls"></b> Calls
<b  style="color:red"id="SA_count_calls1"></b>        <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
        </a> </li>
    </ul>
    <!-----  Notification for logs-------------------> 
  </div>
</div>
<?php
} else {
  
    ?>
<div class="navbar-default sidebar" role="navigation">
  <div class="sidebar-nav">
    <ul class="nav" id="side-menu">
      <?php
                $smsMenu = 1;
                $uid = $_SESSION['id'];
                $qr = 'select * from si_main_menu_assign where si_admin_id="' . $uid . '"';
                $result1 = $this->Data_model->Custome_query($qr);
                $cnt = 1;
                $menuId = explode(',', $result1[0]['si_main_menu_id']);
  // echo "<pre>";print_r($menuId); die;

                for ($j = 0; $j < count($menuId); $j++) {
            if($menuId[$j]==13)
                    { ?>
      <li class="devider"></li>
      <li> <a href="<?php echo base_url('Admin') ?>/Inquiry" class="waves-effect"><i  class="mdi mdi-phone fa-fw"></i> <span class="hide-menu">Inquiry</span></a> </li>
      <?php } 
          
          if($menuId[$j]==12)
                    { ?>
      <li class="devider"></li>
      <li> <a href="<?php echo base_url('HelpDesk') ?>" class="waves-effect"><i  class="mdi mdi-settings fa-fw"></i> <span class="hide-menu">Help</span></a> </li>
      <?php 

                    }
          
         $qr = 'select * from si_main_menu where si_main_menu_id="' . $menuId[$j] . '" and parent_id=0';
                    $result2 = $this->Data_model->Custome_query($qr);
//                echo "<pre>" ;
//                print_r($result2);

                    if (count($result2) > 0) {
                        $ss = 'select * from si_main_menu where parent_id="' . $menuId[$j] . '" group by si_main_menu_id';
                        $ss1 = $this->Data_model->Custome_query($ss);
//                 echo "<pre>" ;
//                print_r($ss1);
                        $smd = 'select group_concat(link) as l from si_main_menu where parent_id="' . $menuId[$j] . '"';
                        $smd1 = $this->Data_model->Custome_query($smd);
//             print_r($smd1);
                        $sm = "";
                        if (strpos($smd1[0]['l'], $this->uri->segment(1)) !== false) {
                            $sm = "active";
                        }

                        foreach ($result2 as $res) {

                            if ($result2[0]['main_menu'] == 'Dashboard') {
                                echo '<li> <a href="' . $lk . '" class="waves-effect"><i class="' . $res['icon'] . ' fa-fw"></i> <span class="hide-menu">' . $result2[0]['main_menu'] . '<span class="fa arrow"></span><span class="label label-rouded label-danger pull-right">9</span></span></a></li>';
                            }
                            if ($res['link'] == '') {
                                if ($result2[0]['main_menu'] == 'SMS') {
                                    $smsMenu = 0;
                                } else {
                                    ?>
      <li> <a href="javascript:void(0)" class="waves-effect"><i class="<?php echo $res['icon']; ?> fa-fw"></i> <span class="hide-menu"><?php echo $result2[0]['main_menu']; ?><span class="fa arrow"></span><span class="label label-rouded label-danger pull-right">9</span></span></a> 
        <!--                    <li class="treeview">
                                                                <a href="javascript:;" class="{!! $sm !!}">
                                                                <a href="javascript:;" class="<?php echo $sm ?>">
                                                                    {{--<i class="fa fa-truck"></i>--}}
                                                                    <span><?php echo $result2[0]['main_menu']; ?></span>
                                                                    <i class="fa fa-angle-left pull-right"></i>
                                                                </a>-->
        
        <?php
                                        if (count($ss1) > 0) {
                                            ?>
        <ul class="nav nav-second-level">
          <?php
                                                foreach ($ss1 as $s1) {
                                                    if (in_array($s1['si_main_menu_id'], $menuId)) {
                                                        $link = 'select * from si_main_menu where si_main_menu_id="' . $s1['si_main_menu_id'] . '"';
                                                        $lnk = $this->Data_model->Custome_query($smd);
//                                        echo "<pre>";
//                                        print_r($lnk);
                                                        $menu_link = 'select * from si_main_menu where main_menu="' . $s1['main_menu'] . '"';
                                                        $menu_link1 = $this->Data_model->Custome_query($menu_link);
                                                        $lk = $menu_link1[0]['link'];
                                                        ?>
          
          <!--<li><a href="<?php echo base_url($lk); ?>"><i class="<?php echo $res['icon'] ?>fa-fw"></i><span class="hide-menu"><?php echo $s1['main_menu']; ?></span></a></li>-->
          <li><a href="<?php echo $lk; ?>"><i class="<?php echo $s1['icon'] ?> fa-fw"></i><span class="hide-menu"><?php echo $s1['main_menu']; ?></span></a></li>
          <!--                                        <li class="<?php
                                                        if ($this->uri->segment(1) == $lk) {
                                                            echo 'active';
                                                        }
                                                        ?>"><a href="<?php echo base_url($lk); ?>"><?php echo $s1['main_menu']; ?></a></li>-->
          <?php
                                                    }
                                                }
                                                ?>
        </ul>
        <?php
                                        }
                                        echo " </li>";
                                    }
                                }
                            }
                        }
                    }
//                    echo "</ul>";
                    ?>
    </ul>
    <ul class="nav navbar-top-links navbar-right pull-right">
      <!----------------Inquiry Notification ------------------------------------->
      
      <style>
.inq_scroll { height:450px; overflow-y: scroll;  } 
</style>
      <?php
                $sql = "select cs.si_customer_solution_id,cs.si_admin_id,p.p_name,csh.remark,sa.name,cs.created_date,cs.status,csh.cs_proccess from si_customer_solution cs
                                inner join si_customer_solution_history csh on csh.si_customer_solution_id = cs.si_customer_solution_id
        inner join si_product as p on p.si_product_id=cs.si_product_id
        inner join si_clients as sic on sic.si_clients_id=cs.si_clients_id
        inner join si_admin as sa on sa.si_admin_id=cs.si_admin_id
        where cs.status IN ('A','D') and csh.cs_proccess='H' and  cs.is_seen = 'U' GROUP BY cs.si_admin_id order by cs.si_customer_solution_id desc";
                $staffnotify = $this->Data_model->Custome_query($sql);
                ?>
      <?php  $abc=" SELECT inquiry_name as inm,inquiry_mobile as mob,inquiry_completion_status as ics from si_inquiry_detail 
    WHERE CHAR_LENGTH(next_follow_date) >3 AND status='A' 
     AND next_follow_date <=CURDATE()  AND inquiry_completion_status = ('L','P') ";
                $ab = $this->Data_model->Custome_query($abc);
        ?>
      <?php if(count($ab)!=0) { ?>
      <li class="dropdown"><a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="javascript:void(0)"> <i class="mdi mdi-bell" style="vertical-align: middle;"></i> ( <?php echo count($ab); ?> ) Inquiry
        <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
        </a>
        <ul class="dropdown-menu mailbox animated bounceInDown">
          <li>
            <div class="drop-title"><?php echo count($ab); ?> Inquiry Notifications </div>
          </li>
          <li>
            <div class="inq_scroll message-center">
              <?php foreach ($ab as $ab) {   
         if($ab['ics']=='L'){ $mark=' style="background-color:#e2c7e2;" title="This Notification is of Low interest Category" ';} else{ $mark=''; }
         ?>
              <a href="javascript:void(0)" class="inqNotify"  data-id="" <?php echo $mark; ?>>
              <div class="mail-contnet"> <span class="mail-desc">
                <?php 
      echo $ab['inm']." : ".$ab['mob']; 
         ?>
                </span> 
                <!--span class="time"><?php //echo $sn['created_date']; ?></span--> 
              </div>
              </a>
              <?php } ?>
            </div>
          </li>
          <?php if(count($ab)>10) { ?>
          <li> <a class="text-center allNotify" href="javascript:void(0);"> <strong>See all notifications</strong> <i class="fa fa-angle-right"></i> </a> </li>
          <?php } ?>
        </ul>
        <!-- /.dropdown-messages --> 
      </li>
      <?php } ?>
      <!---------------Notification ------------------------------------------>
      
      <?php
                if ($smsMenu == 0) {
                    $sql = "select cs.si_customer_solution_id,cs.si_admin_id,p.p_name,csh.remark,sa.name,cs.created_date,cs.status,csh.cs_proccess from si_customer_solution cs
        inner join si_customer_solution_history csh on csh.si_customer_solution_id = cs.si_customer_solution_id
                                inner join si_product as p on p.si_product_id=cs.si_product_id
        inner join si_clients as sic on sic.si_clients_id=cs.si_clients_id
        inner join si_admin as sa on sa.si_admin_id=cs.si_admin_id
        where cs.status IN ('A','D') and csh.cs_proccess='H' and  cs.is_seen = 'U'  and csh.s_type='SendTL' GROUP BY cs.si_admin_id order by cs.si_customer_solution_id desc";
                    $staffnotify = $this->Data_model->Custome_query($sql);
                    ?>
      <li class="dropdown"> <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="javascript:void(0)"> <i class="mdi mdi-gmail" style="vertical-align: middle;"></i> Staff
        <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
        </a>
        <ul class="dropdown-menu mailbox animated bounceInDown">
          <li>
            <div class="drop-title">You have <?php echo count($staffnotify); ?> new messages</div>
          </li>
          <li>
            <div class="message-center">
              <?php foreach ($staffnotify as $sn) { ?>
              <a href="javascript:void(0)" class="userNotify" id="userNotify<?php echo $sn['si_admin_id'] ?>" data-id="<?php echo $sn['si_admin_id'] ?>"> 
              <!--                                        <div class="user-img"> <img src="../plugins/images/users/pawandeep.jpg" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>-->
              <div class="mail-contnet">
                <h5><?php echo $sn['name']; ?></h5>
                <span class="mail-desc"><?php echo(strlen($sn['remark']) >= 22 ? substr($sn['remark'], 0, 20) . "..." : $sn['remark']); ?></span> <span class="time"><?php echo $sn['created_date']; ?></span> </div>
              </a>
              <?php } ?>
              <!--                                    <a href="javascript:void(0)">
                                                                            <div class="user-img"> <img src="../plugins/images/users/sonu.jpg" alt="user" class="img-circle"> <span class="profile-status busy pull-right"></span> </div>
                                                                            <div class="mail-contnet">
                                                                                <h5>Sonu Nigam</h5> <span class="mail-desc">I've sung a song! See you at</span> <span class="time">9:10 AM</span> </div>
                                                                        </a>
                                                                        <a href="javascript:void(0)">
                                                                            <div class="user-img"> <img src="../plugins/images/users/arijit.jpg" alt="user" class="img-circle"> <span class="profile-status away pull-right"></span> </div>
                                                                            <div class="mail-contnet">
                                                                                <h5>Arijit Sinh</h5> <span class="mail-desc">I am a singer!</span> <span class="time">9:08 AM</span> </div>
                                                                        </a>
                                                                        <a href="javascript:void(0)">
                                                                            <div class="user-img"> <img src="../plugins/images/users/pawandeep.jpg" alt="user" class="img-circle"> <span class="profile-status offline pull-right"></span> </div>
                                                                            <div class="mail-contnet">
                                                                                <h5>Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:02 AM</span> </div>
                                                                        </a>--> 
            </div>
          </li>
          <li> <a class="text-center  allNotify" href="javascript:void(0);"> <strong>See all notifications</strong> <i class="fa fa-angle-right"></i> </a> </li>
        </ul>
        <!-- /.dropdown-messages --> 
      </li>
      <?php } ?>
      <li class="dropdown"> <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="javascript:void(0)"> <img src="<?php echo base_url(); ?>assetss/plugins/images/users/varun.jpg" alt="user-img" width="36" class="img-circle"><b class="hidden-xs"><?php echo $_SESSION['name']; ?></b><span class="caret"></span> </a>
        <ul class="dropdown-menu dropdown-user animated flipInY">
          <li>
            <div class="dw-user-box">
              <div class="u-img"><img src="<?php echo base_url(); ?>assetss/plugins/images/users/varun.jpg" alt="user" /></div>
              <div class="u-text">
                <h4><?php echo $_SESSION['name']; ?></h4>
              </div>
            </div>
          </li>
          <li role="separator" class="divider"></li>
          <li><a href="javascript:void(0)"><i class="ti-user"></i> My Profile</a></li>
          <li><a href="#" onClick="$('#reset_password').modal('show');"><i class="fa fa-key"></i> <span class="hide-menu">Reset Password</span></a></li>
          <li role="separator" class="divider"></li>
          <li><a href="javascript:void(0)"><i class="ti-settings"></i> Account Setting</a></li>
          <li role="separator" class="divider"></li>
          <li> <a href="<?php echo base_url() . $this->config->item('admin'); ?>Helper/Logout"><i class="fa fa-power-off"></i> Logout</a></li>
        </ul>
      </li>
    </ul>
    
    <!-----  Notification for logs------------------->
    <ul class="nav navbar-top-links navbar-right pull-right">
      <li class="dropdown"><a onclick="notifications_modal();" class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="javascript:void(0)"> <i class="mdi mdi-phone" style="vertical-align: middle;"> </i> <b id="SA_count_calls"></b> Calls
<b  style="color:red"id="SA_count_calls1"></b>        <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
        </a> </li>
    </ul>
    <!-----  Notification for logs-------------------> 
    
  </div>
</div>
<?php
}
?>

<!-- ============================================================== --> 
<!-- End Left Sidebar --> 
<!-- ============================================================== --> 

<!---------------------> 

<!--  News Edit Model  start--> 
<!-- Modal -->
<div class="modal fade" id="reset_password" role="dialog" data-backdrop='static'  data-keyboard='false'>
  <div class="modal-dialog">
    <form id="resetps_frm">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" >RESET PASSWORD </h4>
          <p id="errordiv" style="color:red"></p>
        </div>
        <div class="modal-body">
          <div class="form-group  col-lg-6">
            <label>Name*</label>
            <input type="text" name="e_name" class="form-control" disabled="disabled" value="<?php echo $this->session->userdata('name')?>" >
            <input type="hidden" name="edit_id">
          </div>
          <div class="form-group  col-lg-6">
            <label>Current Password*</label>
            <input type="password" name="cur_pass" class="form-control" placeholder="Enter Current Password" >
          </div>
          <div class="form-group  col-lg-6">
            <label>New Password*</label>
            <input type="password" name="new_pass" class="form-control" placeholder="Enter New Password" >
          </div>
          <div class="form-group  col-lg-6">
            <label>Confirm New Password*</label>
            <input type="password" name="cnew_pass" class="form-control" placeholder="Confirm New Password" >
          </div>
        </div>
        <div class="modal-footer">
          <input type="button" onclick="resetpass(<?php echo $_SESSION['id'] ?>)" class="btn btn-primary" value="Submit">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!--  News Edit Model  End--> 

<!--  Notification  Model  start--> 
<!-- Modal -->
<div class="modal fade" id="notifications_modal" role="dialog" data-backdrop='static'  data-keyboard='false'>
  <div class="modal-dialog modal-lg">
  
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="calls modal-title"> Notification for Calls <?php if($this->session->userdata('role')=="SA") { ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;<a  href="<?php echo base_url('Admin/LogsReport')?>"><button type="button" class="btn btn-info btn-xs">See Call Logs</button></a>
          <?php } ?> </h4>
          </div>
        <div class="modal-body">
    <table id="notifications" class="table table-striped table-bordered manage-u-table optimize-table">

      <thead>
        <tr>
          <th width="70" class="text-center"> #</th>
          <th width="250">Admin By</th>
          <th width="250">Firm Name</th>
          <th width="250">Time on</th>
          <th width="250">Timer</th>
          </tr>
      </thead>
      <tbody>
      </tbody>
      <tfoot>
        <tr>
          <th width="70" class="text-center"></th>
          <th width="250"></th>
          <th width="250"></th>
          <th width="250"></th>
          <th width="250"></th>
          </tr>
      </tfoot>
    </table>
    </div>
    <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
    
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/easytimer@1.1.1/src/easytimer.min.js" type="text/javascript"></script>

<!--  Notification  Model  End--> 
<script type="text/javascript">
      
  var ajax='<?php echo base_url() . 'Admin/LogsReport/GetData_Noti'; ?>';
  function notifications_modal() { $('#notifications_modal').modal('show');
  //$( '#notifications>tbody').remove('.se small');
   
  var table = $('#notifications').DataTable({
    "processing": true,
    "serverSide": true,
    "paging": true,
    "searching": true,
    "destroy":true,
    "lengthMenu": [[10,20], [10, 20]],
    "pageLength": 10,
    "order": [[ 3, "DESC" ]],
    "ajax":  { 
    //"data":{"id": "67"  },
    "url":ajax},
    "aoColumnDefs": [{ 'bSortable': false, 'aTargets': [0,-1]  }, {'aTargets':[-1],'sClass':'clock'}],
    
  //  "columnDefs": [{ className: "clock", "targets": [ -1 ] }],
          createdRow: function (row, data, dataIndex) { $(row).find("td:eq(4)").attr('id', 'td'+data[5]); 
        //if($(row).find("td:eq(4)").text() ) 
  
        var L=data.length;
       //console.log(L);
        for(var i=0; i<L; i++) { //---for
        var timer = new Timer();
        timer.start({ startValues: {seconds: data[4] } });    
        
        timer.addEventListener('secondsUpdated', function (e) 
        {
          $('#td'+data[5]).html(timer.getTimeValues().toString());});}//FOR

         if(data[4]>1200)
          {
            $(row).attr({ style:"color:red;",title:"This Calls is Exceeded its 20 mins Limit" });
          }
        }
                                          
  });// DATATABLES ENDS HERE
   //alert(L);
  }//FUNCTION ENDS HERE 
  
   
  /* table.on( 'xhr', function () {
    var f = table.ajax.json();  var e=f.data;
    console.log(e);
          });*/
  
  
  
  
  
  
  







function resetpass(id) {
    
var curP= $("input[name=cur_pass]").val();var newP= $("input[name=new_pass]").val();var cnewP= $("input[name=cnew_pass]").val();

if(curP=="") { $("#errordiv").html("<marquee> Enter Current Password </marquee>"); return false } 
else if(newP=="") { $("#errordiv").html("<marquee> Enter New Password </marquee>"); return false} 
else if(cnewP=="") { $("#errordiv").html("<marquee> Enter Confirm Password Field </marquee>"); return false} 
else if(cnewP!=newP) { $("#errordiv").html("<marquee> Both Password must match !! </marquee>"); return false} 
else if((curP==cnewP) || (curP==newP)) { $("#errordiv").html("<marquee> New Password must be different from old Password </marquee>"); return false} 

     $.ajax({
                url: "<?php echo base_url('Password_Update');?>",
                type: "POST",
                data:{"curP":curP,"newP":newP,"cnewP":cnewP,"id":id},
                success: function (data) 
                {    
                if(data=="0") {  $("#errordiv").html("Your Current Password is not Correct ."); } 
               else if(data=="1") {  $('#reset_password').modal('hide');} 
               $('#resetps_frm')[0].reset();
                 },
                error: function(){  alert("Something Went Wrong !! "); }
        });

 }  
</script> 

<script type="text/javascript">
  
      function count_calls_live() {
        $.ajax({
                url: "<?php echo base_url('count_calls_live_every_5_seconds');?>",
                type: "POST",
        dataType:"json",
                success: function(data) {   
        //console.log(data.CL);
        
        if(data.CT==0)
        $('#SA_count_calls').html(data.CL);
         else 
        $('#SA_count_calls').html(data.CL).attr('title',data.CL+' Calls are Live');$('#SA_count_calls1').html(data.CT).attr('title',data.CT+' Calls are Exceeded 20 min Limit');
         
         
                 }
        });
              }

  setInterval(function(){ count_calls_live(); }, 60876);
</script>

