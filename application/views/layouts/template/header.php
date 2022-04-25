<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="<?= base_url() ?>" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="<?= base_url() ?>assets/images/sai-logo-sm.jpg" alt="" height="40">
                        </span>
                        <span class="logo-lg">
                            <img src="<?= base_url() ?>assets/images/sai-logo.jpg" alt="" height="50">
                        </span>
                    </a>

                    <a href="<?= base_url() ?>" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="<?= base_url() ?>assets/images/sai-logo-sm.jpg" alt="" height="40">
                        </span>
                        <span class="logo-lg">
                            <img src="<?= base_url() ?>assets/images/sai-logo.jpg" alt="" height="50">
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>

                <!-- App Search-->
                <form class="app-search d-none">
                    <div class="position-relative">
                        <input type="text" class="form-control" placeholder="Search..." autocomplete="off" id="search-options" value="">
                        <span class="mdi mdi-magnify search-widget-icon"></span>
                        <span class="mdi mdi-close-circle search-widget-icon search-widget-icon-close d-none" id="search-close-options"></span>
                    </div>
                    <div class="dropdown-menu dropdown-menu-lg" id="search-dropdown">
                        <div data-simplebar style="max-height: 320px;">
                            <!-- item-->
                            <div class="dropdown-header">
                                <h6 class="text-overflow text-muted mb-0 text-uppercase">Recent Searches</h6>
                            </div>

                            <div class="dropdown-item bg-transparent text-wrap">
                                <a href="<?= base_url() ?>" class="btn btn-soft-secondary btn-sm btn-rounded">how to setup <i class="mdi mdi-magnify ms-1"></i></a>
                                <a href="<?= base_url() ?>" class="btn btn-soft-secondary btn-sm btn-rounded">buttons <i class="mdi mdi-magnify ms-1"></i></a>
                            </div>
                            <!-- item-->
                            <div class="dropdown-header mt-2">
                                <h6 class="text-overflow text-muted mb-1 text-uppercase">Pages</h6>
                            </div>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="ri-bubble-chart-line align-middle fs-18 text-muted me-2"></i>
                                <span>Analytics Dashboard</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="ri-lifebuoy-line align-middle fs-18 text-muted me-2"></i>
                                <span>Help Center</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="ri-user-settings-line align-middle fs-18 text-muted me-2"></i>
                                <span>My account settings</span>
                            </a>

                            <!-- item-->
                            <div class="dropdown-header mt-2">
                                <h6 class="text-overflow text-muted mb-2 text-uppercase">Members</h6>
                            </div>

                            <div class="notification-list">
                                <!-- item -->
                                <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                                    <div class="d-flex">
                                        <img src="<?= base_url() ?>assets/images/users/avatar-2.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        <div class="flex-1">
                                            <h6 class="m-0">Angela Bernier</h6>
                                            <span class="fs-11 mb-0 text-muted">Manager</span>
                                        </div>
                                    </div>
                                </a>
                                <!-- item -->
                                <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                                    <div class="d-flex">
                                        <img src="<?= base_url() ?>assets/images/users/avatar-3.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        <div class="flex-1">
                                            <h6 class="m-0">David Grasso</h6>
                                            <span class="fs-11 mb-0 text-muted">Web Designer</span>
                                        </div>
                                    </div>
                                </a>
                                <!-- item -->
                                <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                                    <div class="d-flex">
                                        <img src="<?= base_url() ?>assets/images/users/avatar-5.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        <div class="flex-1">
                                            <h6 class="m-0">Mike Bunch</h6>
                                            <span class="fs-11 mb-0 text-muted">React Developer</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="text-center pt-3 pb-1">
                            <a href="pages-search-results.html" class="btn btn-primary btn-sm">View All Results <i class="ri-arrow-right-line ms-1"></i></a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="d-flex align-items-center">

                <div class="dropdown d-md-none topbar-head-dropdown header-item d-none">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bx bx-search fs-22"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-search-dropdown">
                        <form class="p-3">
                            <div class="form-group m-0">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                                    <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="dropdown ms-1 topbar-head-dropdown header-item d-none">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img id="header-lang-img" src="<?= base_url() ?>assets/images/flags/us.svg" alt="Header Language" height="20" class="rounded">
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item language py-2" data-lang="en" title="English">
                            <img src="<?= base_url() ?>assets/images/flags/us.svg" alt="user-image" class="me-2 rounded" height="18">
                            <span class="align-middle">English</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="sp" title="Spanish">
                            <img src="<?= base_url() ?>assets/images/flags/spain.svg" alt="user-image" class="me-2 rounded" height="18">
                            <span class="align-middle">Española</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="gr" title="German">
                            <img src="<?= base_url() ?>assets/images/flags/germany.svg" alt="user-image" class="me-2 rounded" height="18"> <span class="align-middle">Deutsche</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="it" title="Italian">
                            <img src="<?= base_url() ?>assets/images/flags/italy.svg" alt="user-image" class="me-2 rounded" height="18">
                            <span class="align-middle">Italiana</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="ru" title="Russian">
                            <img src="<?= base_url() ?>assets/images/flags/russia.svg" alt="user-image" class="me-2 rounded" height="18">
                            <span class="align-middle">русский</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="ch" title="Chinese">
                            <img src="<?= base_url() ?>assets/images/flags/china.svg" alt="user-image" class="me-2 rounded" height="18">
                            <span class="align-middle">中国人</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="fr" title="French">
                            <img src="<?= base_url() ?>assets/images/flags/french.svg" alt="user-image" class="me-2 rounded" height="18">
                            <span class="align-middle">français</span>
                        </a>
                    </div>
                </div>

                <div class="dropdown topbar-head-dropdown ms-1 header-item d-none">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class='bx bx-category-alt fs-22'></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg p-0 dropdown-menu-end">
                        <div class="p-3 border-top-0 border-start-0 border-end-0 border-dashed border">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="m-0 fw-semibold fs-15"> Web Apps </h6>
                                </div>
                                <div class="col-auto">
                                    <a href="#!" class="btn btn-sm btn-soft-info"> View All Apps
                                        <i class="ri-arrow-right-s-line align-middle"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="p-2">
                            <div class="row g-0">
                                <div class="col">
                                    <a class="dropdown-icon-item" href="#!">
                                        <img src="<?= base_url() ?>assets/images/brands/github.png" alt="Github">
                                        <span>GitHub</span>
                                    </a>
                                </div>
                                <div class="col">
                                    <a class="dropdown-icon-item" href="#!">
                                        <img src="<?= base_url() ?>assets/images/brands/bitbucket.png" alt="bitbucket">
                                        <span>Bitbucket</span>
                                    </a>
                                </div>
                                <div class="col">
                                    <a class="dropdown-icon-item" href="#!">
                                        <img src="<?= base_url() ?>assets/images/brands/dribbble.png" alt="dribbble">
                                        <span>Dribbble</span>
                                    </a>
                                </div>
                            </div>

                            <div class="row g-0">
                                <div class="col">
                                    <a class="dropdown-icon-item" href="#!">
                                        <img src="<?= base_url() ?>assets/images/brands/dropbox.png" alt="dropbox">
                                        <span>Dropbox</span>
                                    </a>
                                </div>
                                <div class="col">
                                    <a class="dropdown-icon-item" href="#!">
                                        <img src="<?= base_url() ?>assets/images/brands/mail_chimp.png" alt="mail_chimp">
                                        <span>Mail Chimp</span>
                                    </a>
                                </div>
                                <div class="col">
                                    <a class="dropdown-icon-item" href="#!">
                                        <img src="<?= base_url() ?>assets/images/brands/slack.png" alt="slack">
                                        <span>Slack</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-toggle="fullscreen">
                        <i class='bx bx-fullscreen fs-22'></i>
                    </button>
                </div>

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
                        <i class='bx bx-moon fs-22'></i>
                    </button>
                </div>

                <?php
                $get_header_counts = get_header_counts();
                // print_r($get_header_counts);
                $contact_count = count($get_header_counts['contact'] ?? []);
                $quick_count = count($get_header_counts['quick'] ?? []);
                $down_inq_count = count($get_header_counts['down_inq'] ?? []);
                $pi_count = count($get_header_counts['pi'] ?? []);
                ?>

                <div class="dropdown topbar-head-dropdown ms-1 header-item">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false" title="Download Inquiry">
                        <i class='bx bx-download fs-22'></i>
                        <span class="position-absolute topbar-badge cartitem-badge1 fs-10 translate-middle badge rounded-pill bg-success"><?= $down_inq_count > 99 ? '99+' : $down_inq_count ?></span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end p-0 dropdown-menu-cart" aria-labelledby="page-header-cart-dropdown">
                        <div class="p-3 border-top-0 border-start-0 border-end-0 border-dashed border">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="m-0 fs-16 fw-semibold"> Download Inquiry </h6>
                                </div>
                                <div class="col-auto">
                                    <span class="badge badge-soft-warning fs-13"><span class="cartitem-badge1"><?= $down_inq_count > 99 ? '99+' : $down_inq_count ?></span>
                                        items</span>
                                </div>
                            </div>
                        </div>
                        <div data-simplebar style="max-height: 300px;">
                            <div class="p-2">
                                <div class="text-center empty-cart1 <?= $down_inq_count > 0 ? 'd-none' : '' ?>">
                                    <div class="avatar-md mx-auto my-3">
                                        <div class="avatar-title bg-soft-info text-info fs-36 rounded-circle">
                                            <i class='bx bx-download'></i>
                                        </div>
                                    </div>
                                    <h5 class="mb-3">Your Download Inquiry is Empty!</h5>
                                </div>

                                <?php
                                if ($down_inq_count > 0) :
                                    foreach ($get_header_counts['down_inq'] as $di_val) :
                                        ?>
                                        <div class="d-block dropdown-item dropdown-item-cart text-wrap px-3 py-2">
                                            <div class="d-flex align-items-center">
                                                 <!-- <img src="<?= base_url() ?>assets/images/products/img-1.png" class="me-3 rounded-circle avatar-sm p-2 bg-light" alt="user-pic"> -->
                                                <span class="me-3 rounded-circle avatar-sm p-2 bg-light"><?= to_title_case(@$di_val['sai_download_inquiry_user'][0]) ?></span>
                                                <div class="flex-1">
                                                    <h6 class="mt-0 mb-1 fs-14">
                                                        <a href="<?= base_url() ?>manage-inquires/product-download/show/<?= $di_val['sai_download_inquiry_id'] ?>" class="text-reset"><?= to_title_case($di_val['sai_download_inquiry_user']) ?></a>
                                                    </h6>
                                                    <p class="mb-0 fs-12 text-muted">
                                                        <?= to_title_case($di_val['sai_download_inquiry_company']) ?>
                                                    </p>
                                                </div>
                                                <div class="px-2">
                                                    <h5 class="m-0 fw-normal"><span class="cart-item-price"><?= to_title_case($di_val['sai_download_inquiry_city']) ?></span></h5>
                                                </div>
                                                <div class="ps-2">
                                                    <a href="<?= base_url() ?>manage-inquires/product-download/show/<?= $di_val['sai_download_inquiry_id'] ?>" class="btn btn-icon btn-sm btn-ghost-secondary remove-item-btn1"><i class="ri-eye-fill fs-16"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    endforeach;
                                endif;
                                ?>

                            </div>
                        </div>
                        <?php
                        if ($down_inq_count > 0) :
                            ?>
                            <div class="p-3 border-bottom-0 border-start-0 border-end-0 border-dashed border">
                                <a href="<?= base_url() ?>manage-inquires/product-download" class="btn btn-success text-center w-100">
                                    View All
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="dropdown topbar-head-dropdown ms-1 header-item">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false" title="Product Inquiry">
                        <i class='bx bx-shopping-bag fs-22'></i>
                        <span class="position-absolute topbar-badge cartitem-badge1 fs-10 translate-middle badge rounded-pill bg-info"><?= $pi_count > 99 ? '99+' : $pi_count ?></span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end p-0 dropdown-menu-cart" aria-labelledby="page-header-cart-dropdown">
                        <div class="p-3 border-top-0 border-start-0 border-end-0 border-dashed border">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="m-0 fs-16 fw-semibold"> Product Inquiry </h6>
                                </div>
                                <div class="col-auto">
                                    <span class="badge badge-soft-warning fs-13"><span class="cartitem-badge1"><?= $pi_count > 99 ? '99+' : $pi_count ?></span>
                                        items</span>
                                </div>
                            </div>
                        </div>
                        <div data-simplebar style="max-height: 300px;">
                            <div class="p-2">
                                <div class="text-center empty-cart1 <?= $pi_count > 0 ? 'd-none' : '' ?>">
                                    <div class="avatar-md mx-auto my-3">
                                        <div class="avatar-title bg-soft-info text-info fs-36 rounded-circle">
                                            <i class='bx bx-shopping-bag'></i>
                                        </div>
                                    </div>
                                    <h5 class="mb-3">Your Product Inquiry is Empty!</h5>
                                </div>

                                <?php
                                if ($pi_count > 0) :
                                    foreach ($get_header_counts['pi'] as $pi_val) :
                                        ?>
                                        <div class="d-block dropdown-item dropdown-item-cart text-wrap px-3 py-2">
                                            <div class="d-flex align-items-center">
                                                 <!-- <img src="<?= base_url() ?>assets/images/products/img-1.png" class="me-3 rounded-circle avatar-sm p-2 bg-light" alt="user-pic"> -->
                                                <span class="me-3 rounded-circle avatar-sm p-2 bg-light"><?= to_title_case(@$pi_val['sai_pi_user'][0]) ?></span>
                                                <div class="flex-1">
                                                    <h6 class="mt-0 mb-1 fs-14">
                                                        <a href="<?= base_url() ?>manage-inquires/product/show/<?= $pi_val['sai_pi_id'] ?>" class="text-reset"><?= to_title_case($pi_val['sai_pi_user']) ?></a>
                                                    </h6>
                                                    <p class="mb-0 fs-12 text-muted">
                                                        <?= to_title_case($pi_val['sai_pi_company']) ?>
                                                    </p>
                                                </div>
                                                <div class="px-2">
                                                    <h5 class="m-0 fw-normal"><span class="cart-item-price"><?= to_title_case($pi_val['sai_pi_city']) ?></span></h5>
                                                </div>
                                                <div class="ps-2">
                                                    <a href="<?= base_url() ?>manage-inquires/product/show/<?= $pi_val['sai_pi_id'] ?>" class="btn btn-icon btn-sm btn-ghost-secondary remove-item-btn1"><i class="ri-eye-fill fs-16"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    endforeach;
                                endif;
                                ?>

                            </div>
                        </div>
                        <?php
                        if ($pi_count > 0) :
                            ?>
                            <div class="p-3 border-bottom-0 border-start-0 border-end-0 border-dashed border">
                                <a href="<?= base_url() ?>manage-inquires/product" class="btn btn-info text-center w-100">
                                    View All
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="dropdown topbar-head-dropdown ms-1 header-item">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false" title="Contact Us">
                        <i class='bx bx-envelope fs-22'></i>
                        <span class="position-absolute topbar-badge cartitem-badge1 fs-10 translate-middle badge rounded-pill bg-dark"><?= $contact_count > 99 ? '99+' : $contact_count ?></span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end p-0 dropdown-menu-cart" aria-labelledby="page-header-cart-dropdown">
                        <div class="p-3 border-top-0 border-start-0 border-end-0 border-dashed border">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="m-0 fs-16 fw-semibold"> Contact Us </h6>
                                </div>
                                <div class="col-auto">
                                    <span class="badge badge-soft-warning fs-13"><span class="cartitem-badge1"><?= $contact_count > 99 ? '99+' : $contact_count ?></span>
                                        items</span>
                                </div>
                            </div>
                        </div>
                        <div data-simplebar style="max-height: 300px;">
                            <div class="p-2">
                                <div class="text-center empty-cart1 <?= $contact_count > 0 ? 'd-none' : '' ?>">
                                    <div class="avatar-md mx-auto my-3">
                                        <div class="avatar-title bg-soft-info text-info fs-36 rounded-circle">
                                            <i class='bx bx-envelope'></i>
                                        </div>
                                    </div>
                                    <h5 class="mb-3">Your Contact Us is Empty!</h5>
                                </div>

                                <?php
                                if ($contact_count > 0) :
                                    foreach ($get_header_counts['contact'] as $cu_val) :
                                        ?>
                                        <div class="d-block dropdown-item dropdown-item-cart text-wrap px-3 py-2">
                                            <div class="d-flex align-items-center">
                                                 <!-- <img src="<?= base_url() ?>assets/images/products/img-1.png" class="me-3 rounded-circle avatar-sm p-2 bg-light" alt="user-pic"> -->
                                                <span class="me-3 rounded-circle avatar-sm p-2 bg-light"><?= to_title_case(@$cu_val['name'][0]) ?></span>
                                                <div class="flex-1">
                                                    <h6 class="mt-0 mb-1 fs-14">
                                                        <a href="<?= base_url() ?>manage-inquires/contact/show/<?= $cu_val['contact_us_id'] ?>" class="text-reset"><?= to_title_case($cu_val['name']) ?></a>
                                                    </h6>
                                                    <p class="mb-0 fs-12 text-muted">
                                                        <?= to_read_more(strip_tags($cu_val['message'])) ?>
                                                    </p>
                                                </div>
                                                <div class="px-2">
                                                    <h5 class="m-0 fw-normal"><span class="cart-item-price"><?= $cu_val['number'] ?></span></h5>
                                                </div>
                                                <div class="ps-2">
                                                    <a href="<?= base_url() ?>manage-inquires/contact/show/<?= $cu_val['contact_us_id'] ?>" class="btn btn-icon btn-sm btn-ghost-secondary remove-item-btn1"><i class="ri-eye-fill fs-16"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    endforeach;
                                endif;
                                ?>

                            </div>
                        </div>
                        <?php
                        if ($contact_count > 0) :
                            ?>
                            <div class="p-3 border-bottom-0 border-start-0 border-end-0 border-dashed border">
                                <a href="<?= base_url() ?>manage-inquires/contact" class="btn btn-dark text-center w-100">
                                    View All
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="dropdown topbar-head-dropdown ms-1 header-item">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false" title="Quick Inquiry">
                        <i class='bx bx-bell fs-22'></i>
                        <span class="position-absolute topbar-badge cartitem-badge1 fs-10 translate-middle badge rounded-pill bg-danger"><?= $quick_count > 99 ? '99+' : $quick_count ?></span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end p-0 dropdown-menu-cart" aria-labelledby="page-header-cart-dropdown">
                        <div class="p-3 border-top-0 border-start-0 border-end-0 border-dashed border">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="m-0 fs-16 fw-semibold"> Quick Inquiry </h6>
                                </div>
                                <div class="col-auto">
                                    <span class="badge badge-soft-warning fs-13"><span class="cartitem-badge1"><?= $quick_count > 99 ? '99+' : $quick_count ?></span>
                                        items</span>
                                </div>
                            </div>
                        </div>
                        <div data-simplebar style="max-height: 300px;">
                            <div class="p-2">
                                <div class="text-center empty-cart1 <?= $quick_count > 0 ? 'd-none' : '' ?>">
                                    <div class="avatar-md mx-auto my-3">
                                        <div class="avatar-title bg-soft-info text-info fs-36 rounded-circle">
                                            <i class='bx bx-bell'></i>
                                        </div>
                                    </div>
                                    <h5 class="mb-3">Your Quick Inquiry is Empty!</h5>
                                </div>

                                <?php
                                if ($quick_count > 0) :
                                    foreach ($get_header_counts['quick'] as $q_val) :
                                        ?>
                                        <div class="d-block dropdown-item dropdown-item-cart text-wrap px-3 py-2">
                                            <div class="d-flex align-items-center">
                                                 <!-- <img src="<?= base_url() ?>assets/images/products/img-1.png" class="me-3 rounded-circle avatar-sm p-2 bg-light" alt="user-pic"> -->
                                                <span class="me-3 rounded-circle avatar-sm p-2 bg-light"><?= to_title_case(@$q_val['name'][0]) ?></span>
                                                <div class="flex-1">
                                                    <h6 class="mt-0 mb-1 fs-14">
                                                        <a href="<?= base_url() ?>manage-inquires/quick/show/<?= $q_val['si_quick_inquiry_id'] ?>" class="text-reset"><?= to_title_case($q_val['name']) ?></a>
                                                    </h6>
                                                    <p class="mb-0 fs-12 text-muted">
                                                        <?= to_read_more(strip_tags($q_val['message'])) ?>
                                                    </p>
                                                </div>
                                                <div class="px-2">
                                                    <h5 class="m-0 fw-normal"><span class="cart-item-price"><?= $q_val['number'] ?></span></h5>
                                                </div>
                                                <div class="ps-2">
                                                    <a href="<?= base_url() ?>manage-inquires/quick/show/<?= $q_val['si_quick_inquiry_id'] ?>" class="btn btn-icon btn-sm btn-ghost-secondary remove-item-btn1"><i class="ri-eye-fill fs-16"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    endforeach;
                                endif;
                                ?>

                            </div>
                        </div>
                        <?php
                        if ($quick_count > 0) :
                            ?>
                            <div class="p-3 border-bottom-0 border-start-0 border-end-0 border-dashed border">
                                <a href="<?= base_url() ?>manage-inquires/quick" class="btn btn-danger text-center w-100">
                                    View All
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user" src="<?= base_url() ?>assets/images/users/user-dummy-img.jpg" alt="Header Avatar">
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text"><?= strtolower($this->session->userdata('username')); ?></span>
                                <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text"><?= ($this->session->userdata('role') == 'A' ? 'Admin' : 'Super Admin') ?></span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header">Welcome <?= strtolower($this->session->userdata('username')); ?>!</h6>
                        <a class="dropdown-item" href="<?= base_url() ?>change-password"><i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Change Password</span></a>
                        <!-- <a class="dropdown-item" href="apps-chat.html"><i class="mdi mdi-message-text-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Messages</span></a>
                        <a class="dropdown-item" href="apps-tasks-kanban.html"><i class="mdi mdi-calendar-check-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Taskboard</span></a>
                        <a class="dropdown-item" href="pages-faqs.html"><i class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Help</span></a> -->
                        <!-- <div class="dropdown-divider"></div> -->
                        <!-- <a class="dropdown-item" href="pages-profile.html"><i class="mdi mdi-wallet text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Balance : <b>$5971.67</b></span></a>
                        <a class="dropdown-item" href="pages-profile-settings.html"><span class="badge bg-soft-success text-success mt-1 float-end">New</span><i class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Settings</span></a>
                        <a class="dropdown-item" href="auth-lockscreen-basic.html"><i class="mdi mdi-lock text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Lock screen</span></a> -->
                        <a class="dropdown-item" href="<?= base_url() ?>logout"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout">Logout</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>