<!-- JAVASCRIPT -->
<script src="<?= base_url() ?>assets/js/jquery-3.5.1.js"></script>
<script src="<?= base_url() ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url() ?>assets/libs/simplebar/simplebar.min.js"></script>
<script src="<?= base_url() ?>assets/libs/node-waves/waves.min.js"></script>
<script src="<?= base_url() ?>assets/libs/feather-icons/feather.min.js"></script>
<script src="<?= base_url() ?>assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
<script src="<?= base_url() ?>assets/js/plugins.js"></script>



<!-- apexcharts -->
<!-- <script src="<?= base_url() ?>assets/libs/apexcharts/apexcharts.min.js"></script> -->

<!-- Vector map-->
<!-- <script src="<?= base_url() ?>assets/libs/jsvectormap/js/jsvectormap.min.js"></script> -->
<!-- <script src="<?= base_url() ?>assets/libs/jsvectormap/maps/world-merc.js"></script> -->

<!--Swiper slider js-->
<script src="<?= base_url() ?>assets/libs/swiper/swiper-bundle.min.js"></script>

<!-- Dashboard init -->
<!-- <script src="<?= base_url() ?>assets/js/pages/dashboard-ecommerce.init.js"></script> -->

<!-- form wizard init -->
<script src="<?= base_url() ?>assets/js/pages/form-wizard.init.js"></script>

<!-- App js -->
<script src="<?= base_url() ?>assets/js/app.js"></script>

<!-- Sweet Alerts js -->
<script src="<?= base_url() ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>

<script src="<?= base_url() ?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>assets/js/dataTables.fixedColumns.min.js"></script>
<script src="<?= base_url() ?>assets/js/dataTables.fixedHeader.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<script>
    var dataTable;
    $(document).ready(function() {
        var screen_width = ($(".table-card").height() - 200);
        console.log($(".table-card").height(), screen_width);
        dataTable = $('#example').DataTable({
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
                url: "<?= $_controller_path ."get_data". ($this->input->get('category') ? '?category='. $this->input->get('category'): '') ?>",
                type: "post", // method  , by default get
                dataType: 'json',
            },
            aoColumnDefs: [{
                bSortable: false,
                aTargets: [-1]
            }]
        });
    });
    $(document).on('click', '.delete-row', function(e) {
        e.stopImmediatePropagation();
        e.preventDefault();
        var page_module = $(this).data('module');
        page_module = page_module.replace('-', ' ');
        Swal.fire({
            html: '<div class="mt-3"><lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon><div class="mt-4 pt-2 fs-15 mx-5"><h4>Are you Sure ?</h4></div></div>',
            showCancelButton: !0,
            confirmButtonClass: "btn btn-primary w-xs me-2 mb-1",
            confirmButtonText: "Yes, Delete It!",
            cancelButtonClass: "btn btn-danger w-xs mb-1",
            buttonsStyling: !1,
            showCloseButton: !0
        }).then((result) => {
            if (result.isConfirmed) {
                var id = $(this).data('id');
                var url = $(this).data('url');

                $.ajax({
                    url,
                    data: {
                        id
                    },
                    method: 'post',
                    dataType: 'json',
                    success: function(res) {
                        if (res.status) {
                            var response = res;
                            Swal.fire(
                                'Deleted!',
                                'Your "' + page_module + '" has been deleted.',
                                'success'
                            ).then((res) => {
                                console.log("here", response);
                                if (response.is_redirect) {
                                    window.location.href = response.url;
                                }
                            });
                            dataTable.draw();
                        }
                    }
                })
            } else {
                Swal.fire(
                    'Cancelled',
                    'Your "' + page_module + '" is safe :)',
                    'error'
                )
            }
        })
    });

    $(document).on('click', '.change-status', function(e) {
        e.stopImmediatePropagation();
        e.preventDefault();
        var page_module = $(this).data('module');
        page_module = page_module.replace('-', ' ');
        Swal.fire({
            title: 'Are you Sure ?',
            text: 'Do you want to change this "' + page_module + '" status ?',
            icon: 'question',
            showCancelButton: !0,
            confirmButtonClass: "btn btn-primary w-xs me-2 mb-1",
            confirmButtonText: "Yes, Change It!",
            cancelButtonClass: "btn btn-danger w-xs mb-1",
            buttonsStyling: !1,
            showCloseButton: !0
        }).then((result) => {
            if (result.isConfirmed) {
                var id = $(this).data('id');
                var url = $(this).data('url');
                var status = $(this).data('status');

                $.ajax({
                    url,
                    data: {
                        id,
                        status
                    },
                    method: 'post',
                    dataType: 'json',
                    success: function(res) {
                        var response = res;
                        if (res.status) {
                            Swal.fire(
                                'Status Changed!',
                                'Your "' + page_module + '" status has been updated.',
                                'success'
                            ).then((res) => {
                                console.log("here", response);
                                if (response.is_redirect) {
                                    window.location.href = response.url;
                                }
                            });
                            dataTable.draw();
                        }
                    }
                })
            }
            // else {
            //     Swal.fire(
            //         'Cancelled',
            //         'Your "' + page_module + '" is safe :)',
            //         'error'
            //     )
            // }
        })
    });
</script>

<!-- Custom script js -->
<script src="<?= base_url() ?>assets/js/script.js"></script>