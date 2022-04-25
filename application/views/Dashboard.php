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
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Dashboard</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                            <li class="breadcrumb-item active">Dashboard</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col">

                                <div class="h-100">
                                    <div class="row mb-3 pb-1">
                                        <div class="col-12">
                                            <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                                                <div class="flex-grow-1">
                                                    <h4 class="fs-16 mb-1">Welcome, <?= strtolower($this->session->userdata('username')) ?>!</h4>
                                                    <p class="text-muted mb-0">Here's what's happening with your control panel.</p>
                                                </div>
                                            </div><!-- end card header -->
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->

                                    <div class="row">
                                        <div class="col-xl-3 col-md-6">
                                            <!-- card -->
                                            <div class="card card-animate">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-grow-1 overflow-hidden">
                                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                                Total Products</p>
                                                        </div>
                                                        <div class="flex-shrink-0 d-none">
                                                            <h5 class="text-success fs-14 mb-0">
                                                                <i class="ri-arrow-right-up-line fs-13 align-middle"></i>
                                                                +16.24 %
                                                            </h5>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                                        <div>
                                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="<?= $_dash_product ?>">0</span>
                                                            </h4>
                                                            <a href="<?= base_url() ?>manage-products/product" class="text-decoration-underline">View all product</a>
                                                        </div>
                                                        <div class="avatar-sm flex-shrink-0">
                                                            <span class="avatar-title bg-soft-success rounded fs-3">
                                                                <i class="bx bxl-product-hunt text-success"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div><!-- end card body -->
                                            </div><!-- end card -->
                                        </div><!-- end col -->

                                        <div class="col-xl-3 col-md-6">
                                            <!-- card -->
                                            <div class="card card-animate">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-grow-1 overflow-hidden">
                                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                                Quick Inquiry</p>
                                                        </div>
                                                        <div class="flex-shrink-0 d-none">
                                                            <h5 class="text-danger fs-14 mb-0">
                                                                <i class="ri-arrow-right-down-line fs-13 align-middle"></i>
                                                                -3.57 %
                                                            </h5>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                                        <div>
                                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="<?= $_dash_quick ?>">0</span></h4>
                                                            <a href="<?= base_url() ?>manage-inquires/quick" class="text-decoration-underline">View all quick inquiry</a>
                                                        </div>
                                                        <div class="avatar-sm flex-shrink-0">
                                                            <span class="avatar-title bg-soft-info rounded fs-3">
                                                                <i class="bx bx bxl-quora text-info"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div><!-- end card body -->
                                            </div><!-- end card -->
                                        </div><!-- end col -->

                                        <div class="col-xl-3 col-md-6">
                                            <!-- card -->
                                            <div class="card card-animate">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-grow-1 overflow-hidden">
                                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                                Product Inquiry</p>
                                                        </div>
                                                        <div class="flex-shrink-0 d-none">
                                                            <h5 class="text-success fs-14 mb-0">
                                                                <i class="ri-arrow-right-up-line fs-13 align-middle"></i>
                                                                +29.08 %
                                                            </h5>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                                        <div>
                                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="<?= $_dash_pi ?>">0</span>
                                                            </h4>
                                                            <a href="<?= base_url() ?>manage-inquires/product" class="text-decoration-underline">View all product inquiry</a>
                                                        </div>
                                                        <div class="avatar-sm flex-shrink-0">
                                                            <span class="avatar-title bg-soft-warning rounded fs-3">
                                                                <i class="bx bx bx-phone-incoming text-warning"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div><!-- end card body -->
                                            </div><!-- end card -->
                                        </div><!-- end col -->

                                        <div class="col-xl-3 col-md-6">
                                            <!-- card -->
                                            <div class="card card-animate">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-grow-1 overflow-hidden">
                                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                                Contact Us</p>
                                                        </div>
                                                        <div class="flex-shrink-0 d-none">
                                                            <h5 class="text-muted fs-14 mb-0">
                                                                +0.00 %
                                                            </h5>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                                        <div>
                                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="<?= $_dash_contact ?>">0</span>
                                                            </h4>
                                                            <a href="<?= base_url() ?>manage-inquires/contact" class="text-decoration-underline">View all contact us</a>
                                                        </div>
                                                        <div class="avatar-sm flex-shrink-0">
                                                            <span class="avatar-title bg-soft-danger rounded fs-3">
                                                                <i class="bx bxs-contact text-danger"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div><!-- end card body -->
                                            </div><!-- end card -->
                                        </div><!-- end col -->
                                    </div> <!-- end row-->



                                </div> <!-- end .h-100-->

                            </div> <!-- end col -->
                        </div>

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