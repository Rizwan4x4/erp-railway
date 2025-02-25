<template>
    <nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow container-xxl">
        <div class="navbar-container d-flex content">
            <div class="bookmark-wrapper d-flex align-items-center">
                <ul class="nav navbar-nav d-xl-none">
                    <li class="nav-item"><a class="nav-link menu-toggle" href="#"><i class="ficon" data-feather="menu"></i></a></li>
                </ul>
            </div>
            <ul class="nav navbar-nav align-items-center ms-auto">
                <li class="nav-item d-none d-lg-block"><a class="nav-link"><i class="ficon" data-feather="moon"></i></a></li>
                <li class="nav-item dropdown dropdown-user">
                    <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="user-nav d-sm-flex d-none"><span class="user-name fw-bolder">SA Systems</span><span class="user-status">Admin</span></div><span class="avatar"><img class="round" src="../../../../public/images/logo/sasystems.png" alt="avatar" height="40" width="40"><span class="avatar-status-online"></span></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user">
                        <button @click="logout()" style="width:100%" class="dropdown-item"><i class="me-50" data-feather="power"></i> Logout</button>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</template>
<script>
    export default {
        data() {
            return {
                url: '',
            }
        },
        methods: {
            logout() {
                axios.get('logout/')
                    .then(
                        response => {
                            window.location.assign(this.url);
                            this.$toastr.i("Logout Successfully");
                        })
                    .catch((error) => console.log(error));
            },
        },
        mounted() {
            const url2 = window.location.href;
            const url_s1 = url2.split('/');
            this.url = url_s1[0] + '//' + url_s1[2] + '/' + url_s1[3];
        }
    }

</script>
