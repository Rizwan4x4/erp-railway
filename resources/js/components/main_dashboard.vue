<template>
 <div>


    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow-tem-change"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">


            </div>
        </div>
    </div>
    <!-- END: Content-->

</div>
    </template>

<script>
    export default {
        mounted() {

         this.$toastr.s("Please visit your dashboard", "Welcome Back");

        }
    }
</script>
