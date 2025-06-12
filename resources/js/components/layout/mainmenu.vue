<template>
    <!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item me-auto">
                    <router-link class="navbar-brand" to="/company_dashboard">
                        <span class="brand-logo">
                        </span>
                        <h2 class="brand-text">SA Solution</h2>
                    </router-link>
                </li>
                <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li class=" nav-item">
                    <router-link to="/company_dashboard" class="d-flex align-items-center"><i data-feather="home"></i><span class="menu-title text-truncate" data-i18n="Dashboards">Dashboards</span></router-link>
                </li>
                <li class=" nav-item">
                    <a class="d-flex align-items-center"><i data-feather="settings"></i><span class="menu-title text-truncate" data-i18n="Settings">Settings</span></a>
                    <ul class="menu-content">
                        <li>
                            <router-link class="d-flex align-items-center" to="/overall_companies"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="List">Companies</span></router-link>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <!-- END: Main Menu-->
</template>

<script>
    export default {
        data() {
            return {
                company1: {},
            }
        },
        mounted() {
            axios.get('session_check2')
                .then((response) => this.company1 = response.data)


        }
    }
</script>
