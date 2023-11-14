<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
    <meta name="author" content="PIXINVENT">
    <title>SASS Application</title>
    <link rel="apple-touch-icon" href="<?php echo asset(''); ?>public/app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo asset(''); ?>public/app-assets/images/ico/favicon.ico">
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
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
               <div class="auth-wrapper auth-cover">
                    <div class="auth-inner row m-0">
                        <!-- Brand logo--><a class="brand-logo" href="index.html">
                            <svg viewbox="0 0 139 95" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="28">
                                <defs>
                                    <lineargradient id="linearGradient-1" x1="100%" y1="10.5120544%" x2="50%" y2="89.4879456%">
                                        <stop stop-color="#000000" offset="0%"></stop>
                                        <stop stop-color="#FFFFFF" offset="100%"></stop>
                                    </lineargradient>
                                    <lineargradient id="linearGradient-2" x1="64.0437835%" y1="46.3276743%" x2="37.373316%" y2="100%">
                                        <stop stop-color="#EEEEEE" stop-opacity="0" offset="0%"></stop>
                                        <stop stop-color="#FFFFFF" offset="100%"></stop>
                                    </lineargradient>
                                </defs>
                                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g id="Artboard" transform="translate(-400.000000, -178.000000)">
                                        <g id="Group" transform="translate(400.000000, 178.000000)">
                                            <path class="text-primary" id="Path" d="M-5.68434189e-14,2.84217094e-14 L39.1816085,2.84217094e-14 L69.3453773,32.2519224 L101.428699,2.84217094e-14 L138.784583,2.84217094e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L6.71554594,44.4188507 C2.46876683,39.9813776 0.345377275,35.1089553 0.345377275,29.8015838 C0.345377275,24.4942122 0.230251516,14.560351 -5.68434189e-14,2.84217094e-14 Z" style="fill: currentColor"></path>
                                            <path id="Path1" d="M69.3453773,32.2519224 L101.428699,1.42108547e-14 L138.784583,1.42108547e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L32.8435758,70.5039241 L69.3453773,32.2519224 Z" fill="url(#linearGradient-1)" opacity="0.2"></path>
                                            <polygon id="Path-2" fill="#000000" opacity="0.049999997" points="69.3922914 32.4202615 32.8435758 70.5039241 54.0490008 16.1851325"></polygon>
                                            <polygon id="Path-21" fill="#000000" opacity="0.099999994" points="69.3922914 32.4202615 32.8435758 70.5039241 58.3683556 20.7402338"></polygon>
                                            <polygon id="Path-3" fill="url(#linearGradient-2)" opacity="0.099999994" points="101.428699 0 83.0667527 94.1480575 130.378721 47.0740288"></polygon>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                            <h2 class="brand-text text-primary ms-1">SA APP</h2>
                        </a>
                        <!-- /Brand logo-->
                        <!-- Left Text-->
                        <div class="d-none d-lg-flex col-lg-8 align-items-center p-5">
                            <div class="w-100 d-lg-flex align-items-center justify-content-center px-5"><img class="img-fluid" src="public/app-assets/images/illustration/verify-email-illustration.svg" alt="two steps verification" /></div>
                        </div>
                        <!-- /Left Text-->
                        <!-- verify email v2-->
                        <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
                            <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                                <h2 class="card-title fw-bolder mb-1">Verify your email &#x2709;&#xFE0F;</h2>
                                <p class="card-text mb-2">Account activation link sent to your email address:<span class="fw-bolder"> hello@sasytems.com</span> Please follow the link inside to continue.</p><a class="btn btn-primary w-100" href="../sa_sass1.1/reset_password">Skip for now</a>
                                <p class="text-center mt-2"><span>Didn&apos;t receive an email?</span><a href="Javascript:void(0)"><span>&nbsp;Resend</span></a></p>
                            </div>
                        </div>
                        <!-- verify email-->
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
</body>
<!-- END: Body-->

</html>