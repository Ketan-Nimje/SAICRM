<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg">

    <head>
        <meta charset="utf-8" />
        <title>Saiinfotech Admin</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Saiinfotech Control Panel" name="description" />
        <meta content="Saiinfotech" name="author" />
        <meta content="<?= base_url() ?>" name="base_url" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?= base_url() ?>assets/images/sai-logo-sm.jpg" type="image/x-icon">

        <!-- Layout config Js -->
        <script src="<?= base_url() ?>assets/js/layout.js"></script>
        <!-- Bootstrap Css -->
        <link href="<?= base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="<?= base_url() ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="<?= base_url() ?>assets/css/app.min.css" rel="stylesheet" type="text/css" />
        <!-- custom Css-->
        <link href="<?= base_url() ?>assets/css/custom.min.css" rel="stylesheet" type="text/css" />
    </head>

    <body>


        <div class="auth-page-wrapper pt-5">
            <!-- auth page bg -->
            <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
                <div class="bg-overlay"></div>

                <div class="shape">
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                    </svg>
                </div>
            </div>

            <!-- auth page content -->
            <div class="auth-page-content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center mt-sm-5 mb-4 text-white-50">
                                <div>
                                    <a href="<?= base_url() ?>" class="d-inline-block auth-logo">
                                        <img src="<?= base_url() ?>assets/images/sai-logo.jpg" alt="" height="40">
                                    </a>
                                </div>
                                <p class="mt-3 fs-15 fw-medium">Saiinfotech Control Panel</p>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->

                    <div class="row justify-content-center">
                        <div class="col-md-8 col-lg-6 col-xl-5">
                            <div class="card mt-4">

                                <div class="card-body p-4">
                                    <div class="text-center mt-2">
                                        <h5 class="text-primary">Welcome Back !</h5>
                                        <p class="text-muted">Sign in to continue to Saiinfotech Control Panel.</p>
                                    </div>
                                    <div class="p-2 mt-4">

                                        <?php $this->load->view('layouts/template/_messages.php') ?>
                                        <form method="post" action="<?= base_url() . 'welcome/Process'; ?>">
                                            <div class="mb-3">
                                                <label for="username" class="form-label">Username</label>
                                                <input type="text" class="form-control" required="" name="email" placeholder="User ID" value='<?= (isset($_COOKIE['username']) ? $_COOKIE['username'] : "") ?>' autofocus>

                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label" for="password-input">Password</label>
                                                <div class="position-relative auth-pass-inputgroup mb-3">
                                                    <input type="password" class="form-control pe-5" name="password" required="" placeholder="Password" value="<?= (isset($_COOKIE['password']) ? $_COOKIE['password'] : ""); ?>" >
                                                    <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                                </div>
                                            </div>

                                            <div class="form-check d-none">
                                                <input class="form-check-input" type="checkbox" value="" id="auth-remember-check">
                                                <label class="form-check-label" for="auth-remember-check">Remember me</label>
                                            </div>

                                            <div class="mt-4">
                                                <input class="btn btn-success w-100" type="submit" name="submit" value="Sign In">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->


                        </div>
                    </div>
                    <!-- end row -->
                </div>
                <!-- end container -->
            </div>
            <!-- end auth page content -->

            <!-- footer -->
            <footer class="footer">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center">
                                <p class="mb-0 text-muted">All rights reserved &copy; <?= date('Y') ?> Saiinfotech.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end Footer -->
        </div>
        <!-- end auth-page-wrapper -->


        <!-- JAVASCRIPT -->
        <script src="<?= base_url() ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="<?= base_url() ?>assets/libs/simplebar/simplebar.min.js"></script>
        <script src="<?= base_url() ?>assets/libs/node-waves/waves.min.js"></script>
        <script src="<?= base_url() ?>assets/libs/feather-icons/feather.min.js"></script>
        <script src="<?= base_url() ?>assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
        <script src="<?= base_url() ?>assets/js/plugins.js"></script>

        <!-- particles js -->
        <script src="<?= base_url() ?>assets/libs/particles.js/particles.js"></script>
        <!-- particles app js -->
        <script src="<?= base_url() ?>assets/js/pages/particles.app.js"></script>
        <!-- password-addon init -->
        <script src="<?= base_url() ?>assets/js/pages/password-addon.init.js"></script>
    </body>

</html>