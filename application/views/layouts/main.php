<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg">

<head>
  <!-- include header links -->
  <?php $this->load->view('layouts/template/headerLinks'); ?>
</head>

<body>
  <!-- Begin page -->
  <div id="layout-wrapper">
    <!-- include header -->
    <?php $this->load->view('layouts/template/header'); ?>

    <!-- include siderbar/navbar -->
    <?php $this->load->view('layouts/template/sidebar'); ?>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
      <div class="page-content">
        <div class="container-fluid">
        </div>
      </div>

      <!-- include footer -->
    <?php $this->load->view('layouts/template/footer'); ?>
      
    </div>
    <!-- end main content-->

  </div>
  <!-- END layout-wrapper -->

  <!-- include footer componant -->  
  <?php $this->load->view('layouts/template/_footerComponant'); ?>

  <!-- include footer links -->
  <?php $this->load->view('layouts/template/footerLinks'); ?>
</body>

</html>