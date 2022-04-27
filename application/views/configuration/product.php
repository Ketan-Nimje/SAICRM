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
        /* .card {
            height: calc(100vh - (195px + 1.5rem));
        } */
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
                                                    <th>Product Name</th>
                                                    <th>Category</th>
                                                    <th>Sale Amount</th>
                                                    <th>Purchase Amount</th>
                                                    <th>Created Date</th>
                                                    <th>Updated Date</th>
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
                            <label for="pname-field" class="form-label required">Product Name: </label>
                            <input type="text" name="p_name" id="pname-field" class="form-control" placeholder="Enter Product Name" required />
                            <div class="invalid-feedback">
                                Please enter product name.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="sale_amount-field" class="form-label required">Sale Amount Installation: </label>
                            <input type="number" min="0" name="sale_amount" id="sale_amount-field" class="form-control" placeholder="Enter Sale Amount Installation" required />
                            <div class="invalid-feedback">
                                Please enter sale amount installation.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="sale_amount2-field" class="form-label required">Sale Amount Updation: </label>
                            <input type="number" min="0" name="sale_amount2" id="sale_amount2	-field" class="form-control" placeholder="Enter Sale Amount Updation" required />
                            <div class="invalid-feedback">
                                Please enter sale amount updation.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="purchase_amount-field" class="form-label required">Purchase Amount Installation: </label>
                            <input type="number" min="0" name="purchase_amount" id="purchase_amount-field" class="form-control" placeholder="Enter Purchase Amount Installation" required />
                            <div class="invalid-feedback">
                                Please enter purchase amount installation.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="purchase_amount2-field" class="form-label required">Purchase Amount Updation: </label>
                            <input type="number" min="0" name="purchase_amount2" id="purchase_amount2-field" class="form-control" placeholder="Enter Purchase Amount Updation" required />
                            <div class="invalid-feedback">
                                Please enter purchase amount updation.
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