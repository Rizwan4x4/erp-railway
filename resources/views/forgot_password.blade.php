<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
    <meta name="author" content="PIXINVENT">
    <title>SA Gardens - MIS</title>
    <link rel="apple-touch-icon" href="<?php echo asset(''); ?>public/app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo asset(''); ?>public/app-assets/images/ico/app_icon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">
 <style>
        .fa-solid{
            font-size:22px !important;
        }
        .dropdown-menu .dropdown-item {

                    padding-top: 10px !important;
                    padding-bottom: 10px !important;
                }
                .vertical-layout.vertical-menu-modern .main-menu .navigation li a{
                    text-decoration: none !important;
                }
                .card-header:first-child {
    border-radius: 0.428rem 0.428rem 0 0 !important;
}
.card-header {
    padding: 1.5rem 1.5rem !important;
    margin-bottom: 0;
    background-color: #fff !important;
    border-bottom: 0 solid rgba(34, 41, 47, 0.125) !important;
}
.table:not(.table-dark):not(.table-light) thead:not(.table-dark) th, .table:not(.table-dark):not(.table-light) tfoot:not(.table-dark) th {
    background-color: #f3f2f7 !important;
}
.table thead th, .table tfoot th {
    vertical-align: top !important;
    text-transform: uppercase !important;
    font-size: 0.857rem !important;
    letter-spacing: 0.5px !important;
}
.table > :not(caption) > * > * {
    padding: 0.72rem 2rem !important;
    background-color: var(--bs-table-bg) !important;
    border-bottom-width: 1px !important;
    box-shadow: inset 0 0 0 9999px var(--bs-table-accent-bg) !important;
}
.page-link {
    position: relative !important;
    display: block !important;
    color: #6e6b7b !important;
    background-color: #f3f2f7 !important;
    border: 0 solid #dae1e7 !important;
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out !important, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out !important;
}
.page-item.active .page-link {
    z-index: 3 !important;
    border-radius: 5rem !important;
    background-color: #7367f0 !important;
    color: #fff !important ;
    font-weight: 600;
}
.custom-control-label{
    padding-left:10px;
}
.modal-header>.close{
border: none !important;
    background: #f8f8f8 !important;
    font-size: 30px !important;

}
.modal .modal-footer{
  border: none !important;
}

    </style>
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo asset(''); ?>public/app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo asset(''); ?>public/app-assets/vendors/css/forms/wizard/bs-stepper.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo asset(''); ?>public/app-assets/vendors/css/forms/select/select2.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo asset(''); ?>public/app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?php echo asset(''); ?>public/app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="<?php echo asset(''); ?>public/app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="<?php echo asset(''); ?>public/app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="<?php echo asset(''); ?>public/app-assets/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="<?php echo asset(''); ?>public/app-assets/css/themes/bordered-layout.css">
    <link rel="stylesheet" type="text/css" href="<?php echo asset(''); ?>public/app-assets/css/themes/semi-dark-layout.css">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo asset(''); ?>public/app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="<?php echo asset(''); ?>public/app-assets/css/plugins/forms/form-wizard.css">
    <link rel="stylesheet" type="text/css" href="<?php echo asset(''); ?>public/app-assets/css/plugins/forms/form-validation.css">
    <link rel="stylesheet" type="text/css" href="<?php echo asset(''); ?>public/app-assets/css/pages/authentication.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo asset(''); ?>public/assets/css/style.css">
    <!-- END: Custom CSS-->
<link rel="stylesheet" type="text/css" href="{{asset('public/css/app.css')}}">
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="blank-page">

      <div id="app">
       <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow-tem-change"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="auth-wrapper auth-cover">
                    <div class="auth-inner row m-0">
                        <!-- Brand logo--><a class="brand-logo" >
                        <a href="#" class="brand-logo" style="width:300px;text-decoration:none" to="/">
                            <h2 class="brand-text text-primary ms-1"><img class="img-fluid" src="public/images/loginLogo.png" height="60" width="150" /></h2>
                        </a>
                        </a>
                        <!-- /Brand logo-->
                        <!-- Left Text-->
                        <div class="d-none d-lg-flex col-lg-8 align-items-center p-5">
                            <div class="w-100 d-lg-flex align-items-center justify-content-center px-5"><img class="img-fluid" src="public/app-assets/images/pages/forgot-password-v2.svg" alt="Forgot password V2" /></div>
                        </div>
                        <!-- /Left Text-->
                        <!-- Forgot password-->
                        <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
                            <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                                <h2 class="card-title fw-bold mb-1">Forgot Password? 🔒</h2>
                                <p class="card-text mb-2">Please contact to relevent department. Thank you!</p>
                                <!--
                                    <form class="auth-forgot-password-form mt-2" action="auth-reset-password-cover.html" method="POST">
                                    <div class="mb-1">
                                        <label class="form-label" for="forgot-password-email">Email</label>
                                        <input class="form-control" id="forgot-password-email" type="text" name="forgot-password-email" placeholder="john@example.com" aria-describedby="forgot-password-email" autofocus="" tabindex="1" />
                                    </div>
                                    <a href="../verify_email" class="btn btn-primary w-100" tabindex="2">Send reset link</a>
                                </form>
                                -->
                                <a onclick="getURL()" ><i data-feather="chevron-left"></i>Back to login</a>
                            </div>
                        </div>
                        <!-- /Forgot password-->
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>

    <!-- BEGIN: Vendor JS-->
    <script src="<?php echo asset(''); ?>public/app-assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="<?php echo asset(''); ?>public/app-assets/vendors/js/forms/wizard/bs-stepper.min.js"></script>
    <script src="<?php echo asset(''); ?>public/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
    <script src="<?php echo asset(''); ?>public/app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
    <script src="<?php echo asset(''); ?>public/app-assets/vendors/js/forms/cleave/cleave.min.js"></script>
    <script src="<?php echo asset(''); ?>public/app-assets/vendors/js/forms/cleave/addons/cleave-phone.us.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="<?php echo asset(''); ?>public/app-assets/js/core/app-menu.js"></script>
    <script src="<?php echo asset(''); ?>public/app-assets/js/core/app.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="<?php echo asset(''); ?>public/app-assets/js/scripts/pages/auth-register.js"></script>
    <script src="<?php echo asset(''); ?>public/app-assets/js/scripts/pages/auth-login.js"></script>
    <!-- END: Page JS-->

    <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })
    </script>
    <script src="{{asset('public/js/app.js')}}"></script>
  <script>
    function getURL() {
        var full_url = window.location.href;
        var url1 = full_url.split('/');
        var url = url1[0] + '//' + url1[2] + '/' + url1[3];
        window.location.replace(url)
        //console.log(url);
    }
    </script>
</body>
<!-- END: Body-->

</html>
