<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
    <meta name="author" content="PIXINVENT">
    <title><?php echo company_detail()->company_prefix ?> - Login</title>
    <link rel="apple-touch-icon" href="<?php echo asset(''); ?>/public/app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo asset(''); ?>/public/app-assets/images/ico/app_icon.ico">
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
    <!-- <link rel="stylesheet" type="text/css" href="<?php echo asset(''); ?>/public/app-assets/vendors/css/vendors.min.css"> -->
    <link rel="stylesheet" type="text/css" href="<?php echo asset('/app-assets/vendors/css/vendors.min.css'); ?>">

    <link rel="stylesheet" type="text/css" href="<?php echo asset(''); ?>/resources/public/app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo asset(''); ?>/public/app-assets/vendors/css/forms/wizard/bs-stepper.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo asset(''); ?>/public/app-assets/vendors/css/forms/select/select2.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <!-- <link rel="stylesheet" type="text/css" href="<?php echo asset(''); ?>/public/app-assets/css/bootstrap.css"> -->
    <link rel="stylesheet" type="text/css" href="<?php echo asset('/app-assets/css/bootstrap.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset(''); ?>/public/app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="<?php echo asset(''); ?>/public/app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="<?php echo asset(''); ?>/public/app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="<?php echo asset(''); ?>/public/app-assets/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="<?php echo asset(''); ?>/public/app-assets/css/themes/bordered-layout.css">
    <link rel="stylesheet" type="text/css" href="<?php echo asset(''); ?>/public/app-assets/css/themes/semi-dark-layout.css">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo asset(''); ?>/public/app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="<?php echo asset(''); ?>/public/app-assets/css/plugins/forms/form-wizard.css">
    <link rel="stylesheet" type="text/css" href="<?php echo asset(''); ?>/public/app-assets/css/plugins/forms/form-validation.css">
    <link rel="stylesheet" type="text/css" href="<?php echo asset(''); ?>/public/app-assets/css/pages/authentication.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo asset(''); ?>/public/assets/css/style.css">
    <!-- END: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('public/css/app.css')}}">
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="blank-page">

<div id="app" >
    <login_page></login_page>
    <!--  <create_company></create_company> -->

</div>

<!-- BEGIN: Vendor JS-->
<script src="<?php echo asset(''); ?>/public/app-assets/vendors/js/vendors.min.js"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="<?php echo asset(''); ?>/public/app-assets/vendors/js/forms/wizard/bs-stepper.min.js"></script>
<script src="<?php echo asset(''); ?>/public/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<script src="<?php echo asset(''); ?>/public/app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
<script src="<?php echo asset(''); ?>/public/app-assets/vendors/js/forms/cleave/cleave.min.js"></script>
<script src="<?php echo asset(''); ?>/public/app-assets/vendors/js/forms/cleave/addons/cleave-phone.us.js"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="<?php echo asset(''); ?>/public/app-assets/js/core/app-menu.js"></script>
<script src="<?php echo asset(''); ?>/public/app-assets/js/core/app.js"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<script src="<?php echo asset(''); ?>/public/app-assets/js/scripts/pages/auth-register.js"></script>
<script src="<?php echo asset(''); ?>/public/app-assets/js/scripts/pages/auth-login.js"></script>
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
