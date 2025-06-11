<template>
 <div>
   <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow-tem-change"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">
               <section class="app-user-view-account">
                    <div class="row">
                        <!-- User Sidebar -->
                        <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
                            <!-- User Card -->
                            <div class="card">
                                <div class="card-body"  v-for="compan1 in compan">
                                    <div class="user-avatar-section">
                                        <div class="d-flex align-items-center flex-column">
                                            <img class="img-fluid rounded mt-3 mb-2" v-bind:src="`public/images/${compan1.company_logo}`"  height="110" width="110" alt="User avatar" />
                                            <div class="user-info text-center">
                                                <h4>{{compan1.company_name}}</h4>

                                            </div>
                                        </div>
                                    </div>

                                    <h4 class="fw-bolder border-bottom pb-50 mb-1">Details</h4>
                                    <div class="info-container">
                                        <ul class="list-unstyled">
                                            <li class="mb-75">
                                                <span class="fw-bolder me-25">Company Name:</span>
                                                <span>{{compan1.company_name}}</span>
                                            </li>
                                            <li class="mb-75">
                                                <span class="fw-bolder me-25">Email Address:</span>
                                                <span>{{compan1.company_email}}</span>
                                            </li>
                                            <li class="mb-75">
                                                <span class="fw-bolder me-25">License Id:</span>
                                                <span>{{compan1.license_id}}</span>
                                            </li>
                                            <li class="mb-75">
                                                <span class="fw-bolder me-25">Phone Number:</span>
                                                <span>{{compan1.phone_number}}</span>
                                            </li>
                                            <li class="mb-75">
                                                <span class="fw-bolder me-25">Address:</span>
                                                <span>{{compan1.company_address}}</span>
                                            </li>
                                            <li class="mb-75">
                                                <span class="fw-bolder me-25">Website Link:</span>
                                                <span>{{compan1.company_link}}</span>
                                            </li>
                                            <li class="mb-75">
                                                <span class="fw-bolder me-25">City:</span>
                                                <span>{{compan1.city}}</span>
                                            </li>
                                            <li class="mb-75">
                                                <span class="fw-bolder me-25">Country:</span>
                                                <span>{{compan1.country}}</span>
                                            </li>
                                            <li class="mb-75">
                                                <span class="fw-bolder me-25">Status:</span>
                                                <span v-if="compan1.c_status=='Active'" class="badge bg-light-success">{{compan1.c_status}}</span>
                                                <span v-else class="badge bg-light-danger">{{compan1.c_status}}</span>
                                            </li>
                                        </ul>
                                        <div class="d-flex justify-content-center pt-2">
                                            <router-link :to="{ name: 'company_edit', params: { id: compan1.company_id }}"  class="btn btn-primary me-1" >
                                                Edit
                                            </router-link>

                                            <button v-if="compan1.c_status=='Active'" @click="deactive(compan1.company_id)" class="btn btn-outline-danger suspend-user">Suspend</button>
                                            <button v-if="compan1.c_status=='Not Active'" @click="active(compan1.company_id)" class="btn btn-outline-info suspend-user">Activate</button>


                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /User Card -->

                        </div>
                        <!--/ User Sidebar -->

                        <!-- User Content -->
                        <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
                            <!-- User Pills -->
                            <ul class="nav nav-pills mb-2">
                                <li class="nav-item">
                                    <a class="nav-link active" href="app-user-view-account.html">
                                        <i data-feather="user" class="font-medium-3 me-50"></i>
                                        <span class="fw-bold">Account</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="app-user-view-security.html">
                                        <i data-feather="lock" class="font-medium-3 me-50"></i>
                                        <span class="fw-bold">Security</span>
                                    </a>
                                </li>



                            </ul>
                            <!--/ User Pills -->

                            <!-- Project table -->
                            <div class="card">
                                <h4 class="card-header">Company Projects List</h4>
                                <div class="table-responsive">
                                    <table class="table datatable-project">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Project Name</th>
                                                <th>Project Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="companydetail11 in companydetail1">
                                        <td></td>
                                         <td style="text-transform: uppercase;">{{companydetail11.permission_module}}</td>
                                          <td>{{companydetail11.module_status}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- /Project table -->

                            <!-- Activity Timeline -->
                            <div class="card">
                                <h4 class="card-header">Company Activity Timeline</h4>
                                <div class="card-body pt-1">
                                    <ul class="timeline ms-50">
                                        <li class="timeline-item">
                                            <span class="timeline-point timeline-point-indicator"></span>
                                            <div class="timeline-event">
                                                <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                                    <h6>User login</h6>
                                                    <span class="timeline-event-time me-1">12 min ago</span>
                                                </div>
                                                <p>User login at 2:12pm</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- /Activity Timeline -->


                        </div>
                        <!--/ User Content -->
                    </div>
                </section>

            </div>
        </div>
    </div>
    <!-- END: Content-->

   </div>
</template>

<script>
    export default {
    data() {
        return {

        compan:{ },
        companydetail1:{ },
        }
        },
        methods:{
            deactive(id){

                axios.get('./deactivate_company/'+id)
                            .then((response) => this.compan = response.data)
                            .catch(error => console.log(error));

                },
                active(id){

                axios.get('./activate_company/'+id)
                            .then((response) => this.compan = response.data)
                            .catch(error => console.log(error));

                },
        },
        mounted() {
        axios.get('getcompany_detail/' + this.$route.params.id)
            .then((response) => this.compan = response.data)
            .catch((error) => console.log(error));

            axios.get('getcompany_modules/' + this.$route.params.id)
            .then((response) => this.companydetail1 = response.data)
            .catch((error) => console.log(error));
        }
    }
</script>
