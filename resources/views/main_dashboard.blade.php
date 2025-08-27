<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width,initial-scale=1.0">
     <style>
    .toast-error {
    background-color: #bd362f !important;
}
.toast-success {
    background-color: #51a351 !important;
}

.toast-warning {
    background-color: orange !important;
}
        .content-body{
            min-height: 550px;
        }
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
            vertical-align: middle !important;
            text-transform: uppercase !important;
            font-size: 0.857rem !important;
            letter-spacing: 0.5px !important;
        }
        .table > :not(caption) > * > * {
            padding: 0.72rem 0.5rem !important;
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
        @media (min-width: 1200px)
        {
            .modal-xl {
                max-width: 1340px !important;
            }
        }
        @media(max-width: 830px){
            .nav-search{
                display: none !important;
            }
        }
    </style>
    <!--
     <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous"> -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome.min.css') }}">


    <meta name="author" content="PIXINVENT">
    <title><?php echo company_detail()->company_prefix ?> - <?php echo Session::get('UserName') ?></title>
    <link rel="apple-touch-icon" href="{{ asset('app-assets/images/ico/apple-icon-120.png') }}">


    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('app-assets/images/ico/app_icon.ico') }}">



    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/wizard/bs-stepper.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/select/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/themes/dark-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/menu/menu-types/vertical-menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/authentication.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">

    <link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}">

</head>
<body class="vertical-layout vertical-menu-modern navbar-floating footer-static" data-open="click" data-menu="vertical-menu-modern" >

<div id="app">
    <navbar1></navbar1>
    <mainmenu1></mainmenu1>
    <router-view></router-view>
    <footer class="sidenav-overlay">
</div>
<div class="drag-target"></div>
<div class="footer footer-static footer-light">
    <p class="clearfix mb-0" style="margin-left:55px;margin-right:30px;padding-bottom: 30px"><span class="float-md-start d-block d-md-inline-block mt-25">COPYRIGHT &copy; <span id="year"></span><a class="ms-25" href="https://nanobitworld.com/" target="_blank">Nano-bit World</a><span class="d-none d-sm-inline-block">, All rights Reserved</span></span></p>
     </footer>

    <button class="btn btn-primary bg-primary btn-icon scroll-top" type="button"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-up"><line x1="12" y1="19" x2="12" y2="5"></line><polyline points="5 12 12 5 19 12"></polyline></svg></button>


</div>
<!-- BEGIN: Vendor JS-->

<script src="{{ asset('app-assets/vendors/js/vendors.min.js') }}"></script>

<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="{{ asset('app-assets/vendors/js/forms/wizard/bs-stepper.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/forms/cleave/cleave.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/forms/cleave/addons/cleave-phone.us.js') }}"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{ asset('app-assets/js/core/app-menu.js') }}"></script>
<script src="{{ asset('app-assets/js/core/app.js') }}"></script>


<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<script src="{{ asset('app-assets/js/scripts/pages/auth-register.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/pages/auth-login.js') }}"></script>
<!-- END: Page JS-->

<script>
    document.getElementById("year").innerHTML=new Date().getFullYear()
    $(window).on('load', function() {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    })
</script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('app-assets/js/f4a2b22af3.js') }}"></script>

<script src="{{ mix('js/app.js') }}?v=3"></script>

</body>
<!-- END: Body-->

</html>
