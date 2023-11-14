<template>
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="auth-wrapper auth-cover">
                    <div class="auth-inner row m-0">
                        <!-- Brand logo-->
                        <router-link class="brand-logo" style="width:300px;text-decoration:none" to="/">
                            <h2 class="brand-text text-primary ms-1"><img class="img-fluid"
                                    src="public/images/loginLogo.png" height="60" width="150" /></h2>
                        </router-link>
                        <!-- /Brand logo-->
                        <!-- Left Text-->
                        <div class="d-none d-lg-flex col-lg-8 align-items-center p-5">
                            <div class="w-100 d-lg-flex align-items-center justify-content-center px-5"><img
                                    class="img-fluid" src="public/app-assets/images/pages/login-v2.svg" alt="Login V2" />
                            </div>
                        </div>
                        <!-- /Left Text-->
                        <!-- Login-->
                        <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
                            <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                                <h2 class="card-title fw-bold mb-1">Welcome to ! 👋</h2>
                                <p class="card-text mb-2">Please sign-in to your account and start the adventure</p>
                                <div class="auth-login-form mt-2">
                                    <!--                                    <div class="mb-1">-->
                                    <!--                                        <label class="form-label" for="login-email">Username</label>-->
                                    <!--                                        <input class="form-control" type="text" name="login-username" v-model="username" placeholder="abc@company.com" />-->

                                    <!--                                    </div>-->
                                    <div class="form-floating mb-1">
                                        <input type="text" v-model="username" class="form-control" id="floatingInput"
                                            placeholder="abc@company.com">
                                        <label for="floatingInput">Email</label>
                                    </div>

                                    <div class="form-floating mb-1 input-group input-group-merge form-password-toggle">
                                        <input v-bind:type="[showPassword ? 'text' : 'password']" type="password" v-model="password" class="form-control" id="floatingPassword" placeholder="Password">
                                        <span class="input-group-text cursor-pointer" @click="showPassword = !showPassword">
                                                <svg v-if="!showPassword" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"/></svg>
                                            <svg v-else xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L525.6 386.7c39.6-40.6 66.4-86.1 79.9-118.4c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C465.5 68.8 400.8 32 320 32c-68.2 0-125 26.3-169.3 60.8L38.8 5.1zM223.1 149.5C248.6 126.2 282.7 112 320 112c79.5 0 144 64.5 144 144c0 24.9-6.3 48.3-17.4 68.7L408 294.5c8.4-19.3 10.6-41.4 4.8-63.3c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3c0 10.2-2.4 19.8-6.6 28.3l-90.3-70.8zM373 389.9c-16.4 6.5-34.3 10.1-53 10.1c-79.5 0-144-64.5-144-144c0-6.9 .5-13.6 1.4-20.2L83.1 161.5C60.3 191.2 44 220.8 34.5 243.7c-3.3 7.9-3.3 16.7 0 24.6c14.9 35.7 46.2 87.7 93 131.1C174.5 443.2 239.2 480 320 480c47.8 0 89.9-12.9 126.2-32.5L373 389.9z"/></svg>
                                            </span>
                                        <label for="floatingPassword">Password</label>
                                    </div>
                                    <!--                                    <div class="mb-1">-->
                                    <!--                                        <div class="d-flex justify-content-between">-->
                                    <!--                                            <label class="form-label" for="login-password">Password</label>-->
                                    <!--                                        </div>-->
                                    <!--                                        <div class="input-group input-group-merge form-password-toggle">-->
                                    <!--                                            <input v-bind:type="[showPassword ? 'text' : 'password']" type="password" v-model="password" class="form-control form-control-merge" placeholder="********" />-->
                                    <!--                                            <span class="input-group-text cursor-pointer" @click="showPassword = !showPassword">-->
                                    <!--                                                <i data-feather="eye"></i>-->
                                    <!--                                            </span>-->
                                    <!--                                        </div>-->
                                    <!--                                    </div>-->
                                    <div v-if="success != ''" style="margin-top:5px;margin-bottom:5px;">
                                        <p class="alert alert-danger"
                                            style="padding-left:10px;padding-right:10px;padding-top:5px;padding-bottom:5px">
                                            {{ success }}</p>
                                    </div>
                                    <button @click="loginform()" class="btn btn-primary w-100" tabindex="4">Sign in</button>
                                    <div class="mb-1" style="margin-top:10px">
                                        <div class="form-check">
                                            <input class="form-check-input" v-model="remember" id="remember-me"
                                                type="checkbox" tabindex="3" />
                                            <label class="form-check-label" for="remember-me"> Remember Me</label>
                                            <a style="float:right" href="/lakecity1.1/forgot_password"><small>Forgot
                                                    Password?</small></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Login-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->
</template>

<script>
import { fetchDepartment, overall_designation, overall_location } from "../../helper/apihelper";


export default {
    data() {
        return {
            url: window.location.href,
            cache: '11-09-2023',
            url_s1: '',
            url_s2: '',
            username: '',
            password: '',
            success: '',
            remember: false,
            showPassword: false,
            departments: [],
            designations: [],
            locations: []
        }
    },
    methods: {
        get_ip() {
            this.url_s1 = this.url.split('/');
            this.url_s2 = this.url_s1[0] + '//' + this.url_s1[2] + '/' + this.url_s1[3];
        },
        //read cookie
        getCookie() {
            if (document.cookie.length > 0) {
                //Use semicolon (;) as the separator cookie string
                var arr = document.cookie.split(";");
                //loop through the separated string array
                for (var i = 0; i < arr.length; i++) {
                    //Then divide the string by the equal sign (=)
                    var arr2 = arr[i].split('=');
                    //Determine and find the corresponding value, replace(/\s*/g, "") means to remove the spaces in the string
                    if (arr2[0].replace(/\s*/g, "") === 'username') {
                        this.username = arr2[1];
                    }
                    else if (arr2[0].replace(/\s*/g, "") === 'password') {
                        this.password = arr2[1];
                    }
                }
            }
        },
        //Clear cookies
        clearCookie() {
            this.setCookie("", -1);//Set the value to empty and the number of days is negative
        },
        //set cookie
        setCookie(username, password) {
            var date = new Date();
            date.setTime(date.getTime() + 24 * 60 * 60 * 1000 * 3);//here is 3 days
            window.document.cookie = "username" + "=" + this.username + ";path=" + this.url_s2 + "/#/;expires=" + date.toGMTString();
            window.document.cookie = "password" + "=" + this.password + ";path=" + this.url_s2 + "/#/;expires=" + date.toGMTString();
        },
        async fetchHrSession() {
            await this.$apihelpers.getHrSeesion()
        },
        async loginform() {
            try {
                const response = await axios.post('./login_success', {
                    username: this.username,
                    password: this.password,
                    cache: this.cache,
                });

                // Clear the local storage
                // localStorage.clear();

                if (response.data === 'login') {

                    
                localStorage.clear();

                    const fetchPromises = [

                        this.fetchHrSession(),

                        this.getPermissions(),
                        this.$apihelpers.fetchDepartment(),
                        this.$apihelpers.overall_designation(),
                        this.$apihelpers.overall_location()
                    ];

                    // Await all the Promises to complete
                    await Promise.all(fetchPromises);

                    if (this.remember === true) {
                        this.setCookie(this.username, this.password);
                    }

                    // Reload the page after all functions are executed
                    window.location.reload();
                    // this.$router.push('/hr/employee_dashboard');

                } else {
                    this.success = response.data;
                }
            } catch (error) {
                this.error = error.response.data.errors;
            }
        },
        getPermissions() {
            axios.get('get_permissions', {
            })
                .then(data => {
                    console.log(data.data.data)
                    localStorage.setItem('permissions', JSON.stringify(data.data.data));
                })
                .catch(err => {
                    console.log(err)
                })
        },




    },
    mounted() {
        this.get_ip();
        this.getCookie();
    }
}
</script>
<style>

</style>