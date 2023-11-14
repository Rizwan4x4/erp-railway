<template>
 <div>
 
  
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
            <div class="content-body ">
                <div class="misc-inner p-2 p-sm-3 ">
                        <div class="w-100 text-center">
                             <img class="img-fluid" src="public/app-assets/images/pages/error.svg" alt="Error page">
                             <h2 class="mb-1">Page Not Found 🕵🏻&zwj;♀️</h2>
                            <p class="mb-2">Oops! 😖 The requested URL was not found on this server.</p>
                            <div style="width:100%">
                            <router-link class="btn btn-primary mb-2 btn-sm-block waves-effect waves-float waves-light" to="/">Back to home</router-link>
                            </div>
                        </div>
                    </div>

            </div>
        </div>
    </div>
    <!-- END: Content-->
   
</div>
    </template>

<script>
    export default {
        mounted() {

         
        }
    }
</script>
