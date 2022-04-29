<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="<?= base_url() ?>" class="logo logo-dark">
            <span class="logo-sm">
                <img src="<?= base_url() ?>assets/images/sai-logo-sm.jpg" alt="" height="40">
            </span>
            <span class="logo-lg">
                <img src="<?= base_url() ?>assets/images/sai-logo.jpg" alt="" height="50">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="<?= base_url() ?>" class="logo logo-light">
            <span class="logo-sm">
                <img src="<?= base_url() ?>assets/images/sai-logo-sm.jpg" alt="" height="40">
            </span>
            <span class="logo-lg">
                <img src="<?= base_url() ?>assets/images/sai-logo.jpg" alt="" height="50">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Analytics</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link <?= in_array($_controller_path ?? "", [base_url() . 'dashboard/']) ? 'active' : '' ?>" href="<?= base_url() ?>dashboard">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboard">Dashboard</span>
                    </a>
                </li>
                <!-- end Dashboard Menu -->

                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-pages">Follow up</span></li>

                <?php
                $group_menu = [
                    base_url() . 'manage-inquires/contact/',
                    base_url() . 'manage-inquires/download-setup/',
                    base_url() . 'manage-inquires/gst/',
                    base_url() . 'manage-inquires/job/',
                    base_url() . 'manage-inquires/product-download/',
                    base_url() . 'manage-inquires/product/',
                    base_url() . 'manage-inquires/quick/',
                    base_url() . 'manage-inquires/transaction/',
                ];
                ?>

                <li class="nav-item">
                    <a class="nav-link menu-link <?= in_array($_controller_path ?? "", $group_menu) ? 'collapsed active' : '' ?>" href="#sidebar3" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar3">
                        <i class="ri-question-answer-line"></i> <span data-key="t-sidebar3">Manage Inquires</span>
                    </a>
                    <div class="collapse menu-dropdown <?= in_array($_controller_path ?? "", $group_menu) ? 'show' : '' ?>" id="sidebar3">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?= base_url() ?>manage-inquires/contact" class="nav-link <?= in_array($_controller_path ?? "", [base_url() . 'manage-inquires/contact/']) ? 'active' : '' ?>" data-key="t-contact"> Contact </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url() ?>manage-inquires/download-setup" class="nav-link <?= in_array($_controller_path ?? "", [base_url() . 'manage-inquires/download-setup/']) ? 'active' : '' ?>" data-key="t-download-setup"> Download Setup </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url() ?>manage-inquires/gst" class="nav-link <?= in_array($_controller_path ?? "", [base_url() . 'manage-inquires/gst/']) ? 'active' : '' ?>" data-key="t-gst"> GST </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url() ?>manage-inquires/job" class="nav-link <?= in_array($_controller_path ?? "", [base_url() . 'manage-inquires/job/']) ? 'active' : '' ?>" data-key="t-job"> Job </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url() ?>manage-inquires/product-download" class="nav-link <?= in_array($_controller_path ?? "", [base_url() . 'manage-inquires/product-download/']) ? 'active' : '' ?>" data-key="t-product-download"> Product Download </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url() ?>manage-inquires/product" class="nav-link <?= in_array($_controller_path ?? "", [base_url() . 'manage-inquires/product/']) ? 'active' : '' ?>" data-key="t-product"> Product Inquiry </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url() ?>manage-inquires/quick" class="nav-link <?= in_array($_controller_path ?? "", [base_url() . 'manage-inquires/quick/']) ? 'active' : '' ?>" data-key="t-quick"> Quick </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url() ?>manage-inquires/transaction" class="nav-link <?= in_array($_controller_path ?? "", [base_url() . 'manage-inquires/transaction/']) ? 'active' : '' ?>" data-key="t-transaction"> Transaction </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <?php
                $group_menu = [
                    base_url() . 'manage-products/category/',
                    base_url() . 'manage-products/product/',
                ];
                ?>
                <li class="nav-item">
                    <a class="nav-link menu-link <?= in_array($_controller_path ?? "", $group_menu) ? 'collapsed active' : '' ?>" href="#sidebar5" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar5">
                        <i class="ri-product-hunt-line"></i> <span data-key="t-sidebar5">Manage Products</span>
                    </a>
                    <div class="collapse menu-dropdown <?= in_array($_controller_path ?? "", $group_menu) ? 'show' : '' ?>" id="sidebar5">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?= base_url() ?>manage-products/category" class="nav-link <?= in_array($_controller_path ?? "", [base_url() . 'manage-products/category/']) ? 'active' : '' ?>" data-key="t-category"> Category </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url() ?>manage-products/product" class="nav-link <?= in_array($_controller_path ?? "", [base_url() . 'manage-products/product/']) ? 'active' : '' ?>" data-key="t-product"> Product </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link <?= in_array($_controller_path ?? "", [base_url() . 'manage-seo/seo/']) ? 'active' : '' ?>" href="<?= base_url() ?>manage-seo/seo">
                        <i class="ri-search-2-line"></i> <span data-key="t-seo">SEO</span>
                    </a>

                </li>

                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-pages">Pages</span></li>

                <?php
                $group_menu = [
                    base_url() . 'manage-homepage/announcement/',
                    base_url() . 'manage-homepage/client/',
                    base_url() . 'manage-homepage/home-popup/',
                    base_url() . 'manage-homepage/slider/',
                    base_url() . 'manage-homepage/software-feature/',
                    base_url() . 'manage-homepage/testimoinal/',
                    base_url() . 'manage-homepage/welcome/',
                ];
                ?>
                <li class="nav-item">
                    <a class="nav-link menu-link <?= in_array($_controller_path ?? "", $group_menu) ? 'collapsed active' : '' ?>" href="#sidebar2" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar2">
                        <i class="ri-layout-3-line"></i> <span data-key="t-sidebar2">Manage Homepage</span>
                    </a>
                    <div class="collapse menu-dropdown <?= in_array($_controller_path ?? "", $group_menu) ? 'show' : '' ?>" id="sidebar2">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?= base_url() ?>manage-homepage/announcement" class="nav-link <?= in_array($_controller_path ?? "", [base_url() . 'manage-homepage/announcement/']) ? 'active' : '' ?>" data-key="t-announcement"> Announcement </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url() ?>manage-homepage/client" class="nav-link <?= in_array($_controller_path ?? "", [base_url() . 'manage-homepage/client/']) ? 'active' : '' ?>" data-key="t-client"> Client </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url() ?>manage-homepage/home-popup" class="nav-link <?= in_array($_controller_path ?? "", [base_url() . 'manage-homepage/home-popup/']) ? 'active' : '' ?>" data-key="t-homepopup"> Home Popup </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url() ?>manage-homepage/slider" class="nav-link <?= in_array($_controller_path ?? "", [base_url() . 'manage-homepage/slider/']) ? 'active' : '' ?>" data-key="t-slider"> Slider </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url() ?>manage-homepage/software-feature" class="nav-link <?= in_array($_controller_path ?? "", [base_url() . 'mmanage-homepage/software-feature/']) ? 'active' : '' ?>" data-key="t-software-feature"> Software Feature </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url() ?>manage-homepage/testimoinal" class="nav-link <?= in_array($_controller_path ?? "", [base_url() . 'manage-homepage/testimoinal/']) ? 'active' : '' ?>" data-key="t-testimoinal"> Testimoinal </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url() ?>manage-homepage/welcome" class="nav-link <?= in_array($_controller_path ?? "", [base_url() . 'manage-homepage/welcome/']) ? 'active' : '' ?>" data-key="t-welcome"> Welcome Message </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <?php
                $group_menu = [
                    base_url() . 'manage-custom-pages/about-us/',
                    base_url() . 'manage-custom-pages/bank-detail/',
                    base_url() . 'manage-custom-pages/career-job/',
                    base_url() . 'manage-custom-pages/career/',
                    base_url() . 'manage-custom-pages/contact-info/',
                    base_url() . 'manage-custom-pages/digital-sign/',
                    base_url() . 'manage-custom-pages/faq/',
                    base_url() . 'manage-custom-pages/privacy/',
                    base_url() . 'manage-custom-pages/social-media/',
                    base_url() . 'manage-custom-pages/term/',
                ];
                ?>
                <li class="nav-item">
                    <a class="nav-link menu-link <?= in_array($_controller_path ?? "", $group_menu) ? 'collapsed active' : '' ?>" href="#sidebar4" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar4">
                        <i class="ri-settings-3-line"></i> <span data-key="t-sidebar4">Manage Custom Pages</span>
                    </a>
                    <div class="collapse menu-dropdown <?= in_array($_controller_path ?? "", $group_menu) ? 'show' : '' ?>" id="sidebar4">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?= base_url() ?>manage-custom-pages/about-us" class="nav-link <?= in_array($_controller_path ?? "", [base_url() . 'manage-custom-pages/about-us/']) ? 'active' : '' ?>" data-key="t-about"> About Us </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url() ?>manage-custom-pages/bank-detail" class="nav-link <?= in_array($_controller_path ?? "", [base_url() . 'manage-custom-pages/bank-detail/']) ? 'active' : '' ?>" data-key="t-bank-detail"> Bank Detail </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url() ?>manage-custom-pages/career-job" class="nav-link <?= in_array($_controller_path ?? "", [base_url() . 'manage-custom-pages/career-job/']) ? 'active' : '' ?>" data-key="t-career-job"> Career Job </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url() ?>manage-custom-pages/career" class="nav-link <?= in_array($_controller_path ?? "", [base_url() . 'manage-custom-pages/career/']) ? 'active' : '' ?>" data-key="t-career"> Career </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url() ?>manage-custom-pages/contact-info" class="nav-link <?= in_array($_controller_path ?? "", [base_url() . 'manage-custom-pages/contact-info/']) ? 'active' : '' ?>" data-key="t-contact-info"> Contact Info </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url() ?>manage-custom-pages/digital-sign" class="nav-link <?= in_array($_controller_path ?? "", [base_url() . 'manage-custom-pages/digital-sign/']) ? 'active' : '' ?>" data-key="t-digital-sign"> Digital Sign </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url() ?>manage-custom-pages/faq" class="nav-link <?= in_array($_controller_path ?? "", [base_url() . 'manage-custom-pages/faq/']) ? 'active' : '' ?>" data-key="t-faq"> FAQ </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url() ?>manage-custom-pages/privacy" class="nav-link <?= in_array($_controller_path ?? "", [base_url() . 'manage-custom-pages/privacy/']) ? 'active' : '' ?>" data-key="t-privacy"> Privacy </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url() ?>manage-custom-pages/social-media" class="nav-link <?= in_array($_controller_path ?? "", [base_url() . 'manage-custom-pages/social-media/']) ? 'active' : '' ?>" data-key="t-social-media"> Social Media </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url() ?>manage-custom-pages/term" class="nav-link <?= in_array($_controller_path ?? "", [base_url() . 'manage-custom-pages/term/']) ? 'active' : '' ?>" data-key="t-terms"> Terms & Conditions </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-user-or-team">Manage Account & Priviliges</span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link <?= in_array($_controller_path ?? "", [base_url() . 'manage-account-priviliges/user/']) ? 'active' : '' ?>" href="<?= base_url() ?>manage-account-priviliges/user">
                        <i class="ri-user-line"></i> <span data-key="t-user">Users</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link <?= in_array($_controller_path ?? "", [base_url() . 'manage-account-priviliges/user-priviliges/']) ? 'active' : '' ?>" href="<?= base_url() ?>manage-account-priviliges/user-priviliges">
                        <i class="ri-user-settings-line"></i> <span data-key="t-user-priviliges">User Priviliges</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link <?= in_array($_controller_path ?? "", [base_url() . 'manage-account-priviliges/menu-assign/']) ? 'active' : '' ?>" href="<?= base_url() ?>manage-account-priviliges/menu-assign">
                        <i class="ri-menu-add-line"></i> <span data-key="t-menu-assign">Menu Assign</span>
                    </a>
                </li>

                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-user-or-team">Configuration</span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link <?= in_array($_controller_path ?? "", [base_url() . 'configuration/product/']) ? 'active' : '' ?>" href="<?= base_url() ?>configuration/product">
                        <i class="ri-product-hunt-line"></i> <span data-key="t-product">Product</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link <?= in_array($_controller_path ?? "", [base_url() . 'configuration/gst-key/']) ? 'active' : '' ?>" href="<?= base_url() ?>configuration/gst-key">
                        <i class="ri-google-line"></i> <span data-key="t-gst-key">GST Key</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link <?= in_array($_controller_path ?? "", [base_url() . 'configuration/for-year/']) ? 'active' : '' ?>" href="<?= base_url() ?>configuration/for-year">
                        <i class="ri-xing-line"></i> <span data-key="t-for-year">For Year</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link <?= in_array($_controller_path ?? "", [base_url() . 'configuration/state/']) ? 'active' : '' ?>" href="<?= base_url() ?>configuration/state">
                        <i class="ri-skype-line"></i> <span data-key="t-state">State</span>
                    </a>
                </li>

                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-user-or-team">HelpDesk</span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link <?= in_array($_controller_path ?? "", [base_url() . 'help-desk/help/']) ? 'active' : '' ?>" href="<?= base_url() ?>help-desk/help">
                        <i class="ri-heading"></i> <span data-key="t-help-desk">Help</span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>