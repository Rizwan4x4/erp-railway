<template>
    <div>
        <!-- BEGIN: Content-->
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow-tem-change"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <router-link to="/accounts" style="text-decoration: none;">Accounts Dashboard</router-link>
                            </li>
                            <li class="breadcrumb-item active">
                                Payment Terms
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="content-body">
                    <section class="app-user-view-account">
                        <div class="row">
                            <!-- User Sidebar -->
                            <!--/ User Sidebar -->
                            <div class="col-xl-12 col-lg-12 col-md-12 order-1 order-md-0">
                                <!-- User Card -->
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Payment Terms Detail</h4>
                                        <div style="text-align: right;width: 30% !important;">
                                            <a v-if="hasPermission('Accounts Configurations  create-payment-terms')" style="float:left" data-bs-toggle="modal" data-bs-target="#addNewCard" class="btn btn-outline-primary waves-effect" type="button">Create New</a>
                                            <div class="" style="float:right">
                                                <div style="">
                                                    <label>
                                                        <input autocomplete="off" class="form-control" style="" placeholder="Search By Name" />
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div style="margin-bottom:20px;" class="d-flex justify-content-between align-items-center header-actions mx-2 row mt-75">
                                            <section id="accordion-with-border">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div id="accordionWrapa50" role="tablist" aria-multiselectable="true">
                                                            <div class="card">

                                                                <div class="card-body">
                                                                    <div class="table-responsive" style="overflow-x: initial !important;">
                                                                        <table class="table table-hover">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Payment Term ID</th>
                                                                                    <th>Payment Term Name</th>
                                                                                    <th>Status</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr class="odd" v-for="adsdata1 in adsdata">

                                                                                    <td>{{adsdata1.PaymentTermId}}</td>
                                                                                    <td>{{adsdata1.PaymentTermName}}</td>
                                                                                    <td v-if="adsdata1.Status=='1'">Enable</td>
                                                                                    <td v-else>Not current</td>

                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div style="text-align:center;padding-top:20px">
                                                                        <pagination :data="adsdata" @pagination-change-page="getResult"></pagination>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                        </div>

                                    </div>
                                </div>
                                <!-- /User Card -->
                            </div>
                        </div>
                    </section>

                </div>
            </div>
        </div>
        <div class="modal fade" id="addNewCard" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <h3 class="text-center mb-1" id="addNewCardTitle">Create Payment Terms</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-sm-5 mx-50 pb-5">

                        <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="col-md-6 col-12">
                                <label class="form-label" for="modalAddCardName">Payment Terms</label>
                                <input type="text" v-model="payment_name" class="form-control" style="" />
                            </div>
                            <div class="col-md-6 col-12">
                                <label style="width:100%">Active</label>
                                <div style="margin-bottom:10px;margin-top:5px" class="form-check form-check-info form-switch">
                                    <input style="width: 50px;" type="checkbox" v-model="payment_status" class="form-check-input" id="customSwitch3">
                                </div>
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" @click="submit_payment_Term()" class="btn btn-primary me-1 mt-1" data-bs-dismiss="modal" aria-label="Close">Submit</button>
                                <button type="reset" class="btn btn-outline-secondary mt-1" data-bs-dismiss="modal" aria-label="Close">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {

                payment_name: '',
                payment_status1: '',
                payment_status: true,
                adsdata: {

                },

            }
        },

        methods: {
            fetch_session_id(id) {
                this.fetch_sessoin_id = id;
            },
            update_session_payroll() {
                axios.get('update_payroll_status/' + this.fetch_sessoin_id)
                    .then(response => {

                        this.$toastr.s("Attendance Closed and proceed in Payroll Section!", "Information");

                    })
                this.$router.go(0);
            },
            delete_session(id) {
                axios.get('delete_session/' + id)
                    .then(response => {
                        this.$toastr.s("Delete Record Successfully!", "Deleted");
                        this.adsdata = response.data

                    })
                    .catch(error => { });

            },

            submit_payment_Term() {

                axios.post('submit_payment_term', {
                    payment_name: this.payment_name,
                    payment_status: this.payment_status
                })
                    .then(data => {
                        if (data.data == "Submitted") {
                            this.$toastr.s("Payment term has been added successfully", "Congratulations");
                            this.getResult();
                        }
                        else {
                            this.$toastr.e("Payment term not created", "Error!");
                        }
                    })
            },
            getResult(page = 1) {

                axios.get('account_payment_terms/?page=' + page)
                    .then(response => this.adsdata = response.data)
                    .catch(error => { });
            },
        },

        mounted() {

            this.getResult();
        }
    }

</script>
