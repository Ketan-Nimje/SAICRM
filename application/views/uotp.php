<!DOCTYPE html>  
<html lang="en">

    <!-- Mirrored from wrappixel.com/ampleadmin/ampleadmin-html/ampleadmin-horizontal-nav/login2.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 01 Jan 2018 05:44:56 GMT -->
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
    <body><!-- Preloader -->
        <div class="preloader">
            <div class="cssload-speeding-wheel"></div>
        </div>

        <div class="auth-page-wrapper pt-5">
            <?php
            $_SESSION['page'] = $_SESSION['page'] + 1;
            ?>
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
                            <?php if ($this->session->flashdata('success')) { ?>
                                <div class="alert alert-success">
                                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                                    <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
                                </div>
                            <?php } else if ($this->session->flashdata('error')) { ?>
                                <?php ?>
                                <div class="alert alert-danger">
                                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                                    <strong>Error!</strong> <?php echo $km = $this->session->flashdata('error'); ?>
                                </div>

                            <?php } ?>

                            <div class="card mt-4">

                                <div class="card-body p-4">
                                    <div class="text-center mt-2">
                                        <h5 class="text-primary">Two Step Verification !</h5>

                                        <p class="text-muted">Your otp will Expire in <span id="counter"></span> Seconds...</p>
                                    </div>
                                    <div class="p-2 mt-4">

                                        <?php $this->load->view('layouts/template/_messages.php') ?>

                                        <?php if (array_key_exists("captcha", $_SESSION)) { ?>
                                            <form action="<?php echo base_url() . 'welcome/aftercaptcha'; ?>" method="post">
                                                <div class="form-group input-group toshow" <?php print ( (array_key_exists("captcha", $_SESSION)) ? 'class="hidden"' : ''); ?> >
                                                    <div align="center" class="image">

                                                        <input class="form-control" type="text" id ="auotp" name="auotp"  placeholder="Enter Otp" maxlength="5" mimlength="1" required/>

                                                        <div class="" style="color: #000; font-size: 16px;">Im not robot</div>

                                                        <?= $_SESSION['cimg']; ?>
                                                        <input class="form-control" type="text" id ="" name="capt"  placeholder="Enter Above Text" maxlength="6" mimlength="1" required/>
                                                        <div class="form-group form-action">
                                                            <button type="submit" name ="submit" onClick="onClick()" value="" id="btnplus" class="btn btn-block btn-default">Submit</button>
                                                        </div>;
                                                    </div>
                                                </div>
                                            </form>
                                            } else {
                                            ?>
                                            <form  action="<?php echo base_url() . 'Uotp/Process'; ?>" method="post"> 
                                                <div class="form-group input-group">
                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                                    <input class="form-control" type="text" id ="uotp" name='uotp'  placeholder="Enter Otp" maxlength="5" mimlength="1" required/>
                                                </div> 
                                                <div class="form-group form-action">
                                                    <button type="submit" name ="submit" onClick="onClick()" value="" id="btnplus" class="btn btn-block btn-default">Submit</button>
                                                </div> 
                                            </form>
                                            <?php
                                        }
                                        ?>



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
                                        <div id="h" style="display:none">
                                            <form class="login-form otp-form" action="<?php echo base_url() . 'Uotp/Process'; ?>" method="post"> 
                                                <div class="form-group form-action">
                                                    <button type="submit" name ="submit" class="btn btn-block btn-default">Resend OTP</button>
                                                </div> 
                                            </form>
                                        </div>
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
        <!-- jQuery -->
        <script src="<?= base_url() ?>assets/js/jquery-3.5.1.js"></script>

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

        <script>
                                                    var updateTimer = function () {
                                                        timer = localStorage.getItem('timer') || 0;
                                                        if (timer === 0) {
                                                            // $("div#timer").html("Timer is unset");
                                                        } else {
                                                            timer--;
                                                            localStorage.setItem('timer', timer);
                                                            $("div#timer").html(timer);
                                                        }
                                                    };

                                                    $(function () {
                                                        setInterval(updateTimer, 1000);

                                                        $("#start").click(function () {
                                                            localStorage.setItem('timer', 10);
                                                        });
                                                    });
        </script>
<!--        <script>
            $(function(){
            $("#timer2").countdowntimer({
            minutes : 20�
                    seconds : 10�
                    size : "lg"
            });
            }
            );
        </script>-->
        <script>
            history.pushState(null, null, location.href);
            window.onpopstate = function () {
                history.go(1);
            };
        </script>

        <script>
            function showresend() {
                setTimeout(function () {
                    $("#h").hide();
                    window.location.href = "<?php echo base_url('helper/logout'); ?>";
                }, 120000);
            }
            showresend();
        </script>

        <script>
            setTimeout(function () {
                $(".error_div").hide();
            }, 3000);

            $(document).on("click", "#recaptcha", function () {
                $(this).addClass("fa-spin");
                $(this).removeAttr("id");
                $.ajax({
                    url: "<?= base_url() ?>Welcome/NewCaptcha",
                    method: "post",
                    dataType: "json",
                    success: function (data) {

                        console.log(data);

                        $(".disabled").removeClass("fa-spin");
                        $(".disabled").attr("id", "recaptcha");
                        $("#captchaimage").attr("src", base_url + "assets/images/captcha/" + data.filename + ".jpg");

                    }

                });
            });
        </script>
        <script type="text/javascript">
            function getCookie(cname) {
                var name = cname + "=";
                var decodedCookie = decodeURIComponent(document.cookie);
                var ca = decodedCookie.split(';');
                for (var i = 0; i < ca.length; i++) {
                    var c = ca[i];
                    while (c.charAt(0) == ' ') {
                        c = c.substring(1);
                    }
                    if (c.indexOf(name) == 0) {
                        return c.substring(name.length, c.length);
                    }
                }
                return "";
            }

            var cnt = 900;
            function counter() {
                if (getCookie("cnt") > 0) {
                    cnt = getCookie("cnt");
                }
                cnt -= 1;
                document.cookie = "cnt=" + cnt;
                jQuery("#counter").text(getCookie("cnt"));

                if (cnt > 0) {
                    setTimeout(counter, 1000);
                }


                if (cnt <= 0) {
                    //$.session.clear();
                    window.location.href = "<?php echo base_url('helper/logout'); ?>";
                }

            }
            counter();
        </script>
    </body>
</html>