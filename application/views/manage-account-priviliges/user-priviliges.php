<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg">

<head>
    <!-- include header links -->
    <?php $this->load->view('layouts/template/headerLinks'); ?>
    <!-- gridjs css -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/fixedColumns.dataTables.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/fixedHeader.dataTables.min.css">
    <style>
        .fix-multiselect {
            min-height: 250px;
        }
    </style>
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
                                <h4 class="mb-sm-0"><?= $_view_title ?></h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);"><?= $_breadcrumb_heading ?></a></li>
                                        <li class="breadcrumb-item active"><?= $_view_title ?></li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card table-card">
                                <div class="card-header">
                                    <div class="row g-4 mb-0">
                                        <div class="col-sm-auto">
                                            <div>
                                                <h4 class="card-title mb-0">Listing</h4>
                                            </div>
                                        </div>
                                        <div class="col-sm">
                                            <div class="d-flex justify-content-sm-end">
                                                <button type="button" class="btn btn-label btn-rounded btn-sm btn-dark waves-effect waves-light create-btn" data-modal="showModal" data-modal-title="Add <?= $_view_title ?>"><i class="ri-add-line label-icon align-middle fs-16 me-2 "></i> Add </button>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- end card header -->

                                <div class="card-body">
                                    <div id="table-fixed-header">
                                        <table id="example" class="stripe row-border order-column nowrap" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Username</th>
                                                    <th>Menu</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div><!-- end card-body -->
                            </div><!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
            </div>

            <!-- include footer -->
            <?php // $this->load->view('layouts/template/footer'); 
            ?>

        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- include footer componant -->
    <?php $this->load->view('layouts/template/_footerComponant'); ?>

    <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light p-3">
                    <h5 class="modal-title" id="exampleModalLabel">Add <?= $_view_title ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                </div>
                <form data-modal="showModal" method="POST" action="<?= $_controller_path ?>add_update" class="needs-validation form-submit" novalidate>
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                    <div class="modal-body">
                        <input type="hidden" name="id" value="0" id="id-field" class="form-control" placeholder="ID" required />
                        <div class="mb-3"><p class="float-end"><label class="required"></label> = Mandatory field(s).</p></div>
                        <div class="mb-3">
                            <label for="user-field" class="form-label required">User:</label>
                            <select class="form-control" name="user" id="user-field" required>
                                <option value="">--- Select User ---</option>
                                <?php
                                foreach ($users as $user) {
                                    ?>
                                    <option value="<?= $user['si_admin_id'] ?>"><?= $user['name'] . ' ('.strtolower($user['username']).')'; ?></option>
                                    <?php
                                }
                                 ?>
                            </select>
                            <div class="invalid-feedback">
                                Please select user.
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-md-4">
                                <label for="client_form-field" class="form-label required">Client Form:</label>
                                <select class="form-control fix-multiselect" name="client_form[]" id="client_form-field" multiple required>
                                    <?php
                                        foreach ($menus as $key => $val) {
                                            if ($val['parent_id'] == 1) {
                                                ?>
                                                <option value="<?php echo $val['si_menu_id'] ?>"><?php echo $val['menu_name'] ?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                                <div class="invalid-feedback">
                                    Please select client form.
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="contact_form-field" class="form-label required">Contact Form:</label>
                                <select class="form-control fix-multiselect" name="contact_form[]" id="contact_form-field" multiple required>
                                    <?php
                                        foreach ($menus as $key => $val) {
                                            if ($val['parent_id'] == 2) {
                                                ?>
                                                <option value="<?php echo $val['si_menu_id'] ?>"><?php echo $val['menu_name'] ?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                                <div class="invalid-feedback">
                                    Please select contact form.
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="product_form-field" class="form-label required">Product Form:</label>
                                <select class="form-control fix-multiselect" name="product_form[]" id="product_form-field" multiple required>
                                    <?php
                                        foreach ($menus as $key => $val) {
                                            if ($val['parent_id'] == 3) {
                                                ?>
                                                <option value="<?php echo $val['si_menu_id'] ?>"><?php echo $val['menu_name'] ?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                                <div class="invalid-feedback">
                                    Please select product form.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-sm btn-light btn-label waves-effect waves-light rounded-pill" data-bs-dismiss="modal"><i class="ri-close-line label-icon align-middle rounded-pill fs-16 me-2"></i> Close</button>
                            <button type="submit" id="edit-btn" class="btn btn-sm btn-success btn-label waves-effect waves-light rounded-pill"><i class="ri-check-double-line label-icon align-middle rounded-pill fs-16 me-2"></i> Add <?= $_view_title ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- include footer links -->
    <?php $this->load->view('layouts/template/footerLinks'); ?>

    <script src="<?= base_url() ?>assets/js/pages/form-validation.init.js"></script>

</body>

</html>