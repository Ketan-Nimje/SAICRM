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
            <div class="page-content listing">
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
                                                <h4 class="card-title mb-0">List</h4>
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
                                                    <th>Customer Name</th>
                                                    <th>Firm Name</th>
                                                    <th>Mobile No.</th>
                                                    <th>Email</th>
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

    <div class="modal zoomIn" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-light p-3">
                    <h5 class="modal-title" id="exampleModalLabel">Add <?= $_view_title ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                </div>
                <form data-modal="showModal" method="POST" action="<?= $_controller_path ?>add_update" class="needs-validation form-submit" enctype="multipart/form-data" novalidate>
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                    <div class="modal-body">
                        <input type="hidden" name="id" value="0" id="id-field" class="form-control form-control-sm" placeholder="ID" required />
                        <div class="row text-end d-none">
                            <p><label class="required"></label> = Mandatory field(s).</p>
                        </div>
                        <div>
                            <h5>Customer Info</h5>
                            <p class="text-muted">Fill all mandatory information below</p>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="contact_person-field" class="form-label required">Contact Person:</label>
                                <input type="text" name="contact_person" id="contact_person-field" class="form-control form-control-sm" placeholder="Enter Contact Person" required />
                                <div class="invalid-feedback">
                                    Please enter contact person.
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="firm_name-field" class="form-label required">Firm Name:</label>
                                <input type="text" name="firm_name" id="firm_name-field" class="form-control form-control-sm" placeholder="Enter Firm Name" required />
                                <div class="invalid-feedback">
                                    Please enter firm name.
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="mobile-field" class="form-label required">Mobile No:</label>
                                <input type="text" name="mobile" id="mobile-field" class="form-control form-control-sm" placeholder="Enter Mobile No." required />
                                <div class="invalid-feedback">
                                    Please enter mobile no.
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="email-field" class="form-label required">Email Address:</label>
                                <input type="email" name="email" id="email-field" class="form-control form-control-sm" placeholder="Enter Email Address" required />
                                <div class="invalid-feedback">
                                    Please enter email address.
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="address1-field" class="form-label required">Address 1:</label>
                                <input type="text" name="address1" id="address1-field" class="form-control form-control-sm" placeholder="Enter Address 1" required />
                                <div class="invalid-feedback">
                                    Please enter address 1.
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="address2-field" class="form-label">Address 2:</label>
                                <input type="text" name="address2" id="address2-field" class="form-control form-control-sm" placeholder="Enter Address 2" />
                                <div class="invalid-feedback">
                                    Please enter address 2.
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="area-field" class="form-label required">Area:</label>
                                <input type="text" name="area" id="area-field" class="form-control form-control-sm" placeholder="Enter Area" required />
                                <div class="invalid-feedback">
                                    Please enter area.
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="city-field" class="form-label required">City:</label>
                                <input type="text" name="city" id="city-field" class="form-control form-control-sm" placeholder="Enter City" required />
                                <div class="invalid-feedback">
                                    Please enter city.
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="state-field" class="form-label required">State:</label>
                                <select class="form-control form-control-sm" name="state" id="state-field" required>
                                    <option value="">--- Select State ---</option>
                                    <?php
                                    foreach ($states as $sKey => $state) {
                                    ?>
                                        <option value="<?= $state['si_state_id'] ?>"><?= $state['name'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <div class="invalid-feedback">
                                    Please select state.
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="pincode-field" class="form-label required">Pincode:</label>
                                <input type="text" name="pincode" id="pincode-field" class="form-control form-control-sm" placeholder="Enter Pincode" required />
                                <div class="invalid-feedback">
                                    Please enter pincode.
                                </div>
                            </div>
                        </div>
                        <hr class="my-4 text-muted">
                        <div>
                            <h5>Contact Info</h5>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label for="mobile1-field" class="form-label">Mobile No. 1:</label>
                                <input type="text" name="mobile1" id="mobile1-field" class="form-control form-control-sm" placeholder="Enter Mobile No 1" />
                            </div>
                            <div class="col-md-2">
                                <label for="mobile2-field" class="form-label">Mobile No. 2:</label>
                                <input type="text" name="mobile2" id="mobile2-field" class="form-control form-control-sm" placeholder="Enter Mobile No 2" />
                            </div>
                            <div class="col-md-2">
                                <label for="mobile3-field" class="form-label">Mobile No. 3:</label>
                                <input type="text" name="mobile3" id="mobile3-field" class="form-control form-control-sm" placeholder="Enter Mobile No 3" />
                            </div>
                            <div class="col-md-2">
                                <label for="phone1-field" class="form-label">Phone No. 1:</label>
                                <input type="text" name="phone1" id="phone1-field" class="form-control form-control-sm" placeholder="Enter Phone No 1" />
                            </div>
                            <div class="col-md-2">
                                <label for="phone2-field" class="form-label">Phone No. 2:</label>
                                <input type="text" name="phone2" id="phone2-field" class="form-control form-control-sm" placeholder="Enter Phone No 2" />
                            </div>
                            <div class="col-md-2">
                                <label for="gstno-field" class="form-label">GST No.:</label>
                                <input type="text" name="gstno" id="gstno-field" class="form-control form-control-sm" placeholder="Enter GST No." />
                            </div>
                        </div>
                        <hr class="my-4 text-muted">
                        <div>
                            <h5>Product Info</h5>
                            <p class="text-muted">Fill all mandatory information below</p>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label for="category-field" class="form-label">Type:</label>
                                <select class="form-control form-control-sm" name="category" id="category-field" data-defval="1" data-event="change">
                                    <option value="1">Installation</option>
                                    <option value="2" class="hide-me d-none">Updatation</option>
                                    <option value="3" class="hide-me d-none">Lan</option>
                                    <option value="4" class="hide-me d-none">Conversion</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please select type.
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="product-field" class="form-label">Product:</label>
                                <select class="form-control form-control-sm" name="product" id="product-field" data-defval="0">
                                    <option value="0">--- Select Product ---</option>
                                    <?php
                                    foreach ($products as $pKey => $product) {
                                    ?>
                                        <option value="<?= $product['si_product_id'] ?>"><?= $product['p_name'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <div class="invalid-feedback">
                                    Please select product.
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="referby-field" class="form-label required">Referred By:</label>
                                <select class="form-control form-control-sm" name="referby" id="referby-field" data-defval="Admin">
                                    <option value="Admin">Admin</option>
                                    <?php
                                    foreach ($users as $uKey => $user) {
                                    ?>
                                        <option value="<?= $user['si_admin_id'] ?>"><?= $user['name'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <div class="invalid-feedback">
                                    Please select refer by.
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="conversion_product-field" class="form-label">Conversion Product:</label>
                                <select class="form-control form-control-sm" name="conversion_product" id="conversion_product-field" data-defval="0">
                                    <option value="0">Conversion Product</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please select conversion product.
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="laptop-field" class="form-label">Laptop Device:</label>
                                <select class="form-control form-control-sm" name="laptop" id="laptop-field" data-defval="NL">
                                    <?php
                                    foreach ($laptop_devices as $lKey => $ld) {
                                    ?>
                                        <option value="<?= $lKey ?>"><?= $ld ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <div class="invalid-feedback">
                                    Please select laptop device.
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="reg_type-field" class="form-label">Reg. Type:</label>
                                <select class="form-control form-control-sm" name="reg_type" id="reg_type-field" data-defval="O">
                                    <?php
                                    foreach ($reg_types as $rKey => $rt) {
                                    ?>
                                        <option value="<?= $rKey ?>"><?= $rt ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <div class="invalid-feedback">
                                    Please select Reg. Type.
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="for_year-field" class="form-label">For Year:</label>
                                <select class="form-control form-control-sm" name="for_year" id="for_year-field" data-defval="<?= $for_years[0]['si_for_year_id'] ?>">
                                    <?php
                                    foreach ($for_years as $fKey => $fy) {
                                    ?>
                                        <option value="<?= $fy['si_for_year_id'] ?>"><?= $fy['yearname'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <div class="invalid-feedback">
                                    Please select for year.
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="serial_no-field" class="form-label">Serial No./HLock No.:</label>
                                <input type="text" name="serial_no" id="serial_no-field" class="form-control form-control-sm" placeholder="Enter Serial No./HLock No." />
                            </div>
                            <div class="col-md-2">
                                <label for="activation_code-field" class="form-label">Activation Code:</label>
                                <input type="text" name="activation_code" id="activation_code-field" class="form-control form-control-sm" placeholder="Enter Activation Code" />
                            </div>
                            <div class="col-md-2">
                                <label for="purchase_date-field" class="form-label">Purchase Date:</label>
                                <input type="text" name="purchase_date" id="purchase_date-field" class="form-control form-control-sm" placeholder="Enter Purchase Date" />
                            </div>
                            <div class="col-md-2">
                                <label for="renewal_date-field" class="form-label">Renewal Date:</label>
                                <input type="text" name="renewal_date" id="renewal_date-field" class="form-control form-control-sm" placeholder="Enter Renewal Date" />
                            </div>
                            <div class="col-md-3">
                                <label for="srv_lan-field" class="form-label">Srv/Lan:</label>
                                <select class="form-control form-control-sm" name="srv_lan" id="srv_lan-field" data-defval="0" data-event="change">
                                    <?php
                                    foreach ($lan_types as $lKey => $lt) {
                                    ?>
                                        <option value="<?= $lKey ?>"><?= $lt ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2" style="display: none;">
                                <label for="srv_lan_no-field" class="form-label">Srv/Lan No.:</label>
                                <input type="text" name="srv_lan_no" id="srv_lan_no-field" class="form-control form-control-sm" placeholder="Enter Srv/Lan No." />
                            </div>
                            <div class="col-md-4">
                                <input class="form-check-input" type="checkbox" id="change_email-field" name="change_email" value="1" data-def-check="false" data-event="change">
                                <label class="form-check-label me-2" for="change_email-field">
                                    Change Email
                                </label>
                                <a href="<?= base_url() ?>assets/pdf/RequestForEmailidChangeForm.pdf" class="badge badge-outline-primary ms-1 change-email d-none" target="_blank" title="View & Download PDF"><i class="ri-file-ppt-line label-icon align-middle fs-16 me-2"></i>View & Download</a>
                                <div class="row change-email d-none">
                                    <div class="col-md-4">
                                        <label class="col-form-label">Upload Form:</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="file" name="change_email_form" id="change_email_form-field" class="form-control form-control-sm" placeholder="Upload Form" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-sm btn-light btn-label waves-effect waves-light rounded-pill" data-bs-dismiss="modal"><i class="ri-close-line label-icon align-middle fs-16 me-2"></i> Close</button>
                            <button type="submit" id="edit-btn" class="btn btn-sm btn-success btn-label waves-effect waves-light rounded-pill"><i class="ri-check-double-line label-icon align-middle fs-16 me-2"></i> Add <?= $_view_title ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal zoomIn" id="showProductModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-light p-3">
                    <h5 class="modal-title" id="productModalLabel">View Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                </div>
                <div class="modal-body">
                    <div id="table-fixed-header1">
                        <table id="product-rows" class="stripe row-border order-column nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Purc. Year</th>
                                    <th>Activation Code</th>
                                    <th>Serial #</th>
                                    <th>Purc. Date</th>
                                    <th>Renew. Date</th>
                                    <th>Decl Srv</th>
                                    <th>Lan</th>
                                    <th>Reg. Type</th>
                                    <th>File</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-sm btn-light btn-label waves-effect waves-light rounded-pill" data-bs-dismiss="modal"><i class="ri-close-line label-icon align-middle fs-16 me-2"></i> Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- include footer links -->
    <?php $this->load->view('layouts/template/footerLinks'); ?>

    <script src="<?= base_url() ?>assets/js/pages/form-validation.init.js"></script>

    <script type="text/javascript">

        $(document).on('change', '#category-field', function(){
            var cVal = parseInt($(this).val());
            if (cVal === 1) {
                $("#referby-field").parent().show();
                $("#product-field > option.phide").removeClass('d-none');
            } else {
                $("#referby-field").parent().hide();
                $("#product-field > option.phide").addClass('d-none');
            }
        });
        $(document).on('change', '#srv_lan-field', function(){
            var cVal = parseInt($(this).val());
            if (cVal === 0) {
                $("#srv_lan_no-field").parent().hide();
                $("#srv_lan_no-field").val('');
            } else {
                $("#srv_lan_no-field").parent().show();
                $("#srv_lan_no-field").val(0);
            }
        });
        $(document).on('change', '#change_email-field', function(){
            if ($(this).prop('checked') == true) {
                $(".change-email").removeClass('d-none');
            } else {
                $(".change-email").addClass('d-none');
            }
        });

        $('#showProductModal').on('shown.bs.modal', function (event) {
            var ele = event.relatedTarget;
            var id = $(ele).data('id');
            $('#product-rows').DataTable().destroy();

            dataTable = $('#product-rows').DataTable({
            destroy: true,
            scrollY: 400,
            scrollX: true,
            scrollCollapse: true,
            paging: true,
            fixedColumns: {
                left: 1,
                right: 1
            },
            fixedHeader: {
                header: true,
                // footer: true
            },
            order: [
                [0, "desc"]
            ],
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?= $_controller_path ."client-product/" ?>"+id,
                type: "get", // method  , by default get
                dataType: 'json',
            },
            aoColumnDefs: [{
                bSortable: false,
                aTargets: [-1]
            }]
        });
        });
    </script>

</body>

</html>