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
                            <li class="breadcrumb-item">
                                <router-link to="/accounts/land_payment_detail" style="text-decoration: none;">Land Detail</router-link>
                            </li>

                            <li class="breadcrumb-item active">
                               Seller Detail
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="content-body">
                    <!-- users list start -->
                    <section class="app-user-list">
                        <div clas="card" style="background-color:white !important">
                            <div style="margin-bottom:20px;padding-top:20px" class="d-flex justify-content-between align-items-center header-actions mx-2 row mt-75">
                                <div class="col-sm-6 col-lg-6 ps-xl-75 ps-0">
                                    <h4 class="card-title">Search & Filter</h4>
                                </div>
                                <div class="col-sm-6 col-lg-6 ps-xl-75 ps-0">
                                    <div class="dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap">
                                        <div class="me-1">
                                            <div class="dataTables_filter" style="margin-top:5px">
                                                <label>
                                                    <input autocomplete="off" type="text" name="keyword1" v-model="keyword1" @change="search_by_name()" class="form-control" style="" placeholder="Search By Name" />
                                                </label>
                                            </div>
                                        </div>
                                        <div class="dt-buttons d-inline-flex mt-50">
                                            <a style="float:left" data-bs-toggle="modal" data-bs-target="#addNewCustomer" class="btn btn-outline-primary waves-effect">Create New Seller</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive" style="overflow-x: initial !important;">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Mobile</th>
                                            <th>CNIC</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="customers1 in customers.data">
                                            <td>{{customers1.SellerID}}</td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <a class="user_name text-truncate text-body"><span class="fw-bolder">{{customers1.SellerName}} </span></a>
                                                </div>
                                            </td>
                                            <td>{{customers1.Mobile}}</td>
                                            <td>{{customers1.CNIC}}</td>

                                            <td style="vertical-align: middle; text-align: center;">
                                            <a data-bs-toggle="modal" @click="fetch_customer_detail(customers1.SellerID)" class="dropdown-item" data-bs-target="#viewCustomer">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </a>

                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div style="text-align:center;padding-top:20px">
                                <pagination :data="customers" @pagination-change-page="getResult"></pagination>
                            </div>
                        </div>
                    </section>
                    <!-- users list ends -->
                </div>
            </div>
        </div>
        <!-- END: Content-->
        <div class="modal fade" id="addNewCustomer" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <h3 class="text-center mb-1" id="addNewCardTitle">Create New Seller</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-sm-5 mx-50 pb-5">
                        <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">

                            <div class="col-md-6 col-12" >
                                <label class="form-label" for="modalAddCardName">Seller Name<span style="color: #db4437; font-size: 11px">*</span></label>
                                <input type="text" v-model="customer_name" class="form-control" placeholder='Type Seller Name' style="" />
                                <span style="color: #db4437; font-size: 11px" v-if="customer_name == ''">{{ e_customer_name }}</span>
                            </div>

                            <div class="col-md-6 col-12" >
                                <label class="form-label" for="modalAddCardName">CNIC Number<span style="color: #db4437; font-size: 11px">*</span></label>
                                <masked-input class="form-control account-number-mask" mask="11111-1111111-1" v-model="cnic" placeholder="CNIC Number Here" />
                                <span style="color: #db4437; font-size: 11px" v-if="cnic == ''">{{ e_cnic }}</span>
                            </div>




                            <div class="col-md-6 col-12">
                                <label class="form-label" for="modalAddCardName">Mobile Number<span style="color: #db4437; font-size: 11px">*</span></label>
                                <masked-input class="form-control account-number-mask" mask="0311-1111111" v-model="c_mobile" placeholder="Phone Number Here"/>
                                <span style="color: #db4437; font-size: 11px" v-if="c_mobile == ''">{{ e_c_mobile }}</span>
                            </div>
                            <div class="col-12" style="text-align:center">
                                <button :disabled="disabled" @click="delay()" type="button" class="btn btn-primary mt-1 me-1 waves-effect waves-float waves-light">Save Seller</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="viewCustomer" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-5 px-sm-5 pt-50">
                        <div class="text-center mb-2">
                            <center>
                                <div class="col-md-12" v-for="customer_detail1 in customer_detail">
                                    <table style="width:100%;">
                                        <thead style="float:left; width:100%;">
                                            <h2 style="text-align:center;"> Detail of seller</h2>
                                            <tr>

                                                <th style="width:25%;">Seller Name: </th>
                                                <td style="width:25%;">{{customer_detail1.SellerName}}</td>
                                            </tr>

                                            <tr>
                                                <th>Phone Number: </th>
                                                <td>{{customer_detail1.Mobile}}</td>
                                                <th>CNIC: </th>
                                                <td>{{customer_detail1.CNIC}}</td>
                                            </tr>


                                        </thead>
                                    </table>
                                </div>
                                <div class="col-12 text-center">
                                    <button type="reset" class="btn btn-outline-secondary mt-2" data-bs-dismiss="modal" aria-label="Close">
                                        Close
                                    </button>
                                </div>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import MaskedInput from 'vue-masked-input';
    export default {
        data() {
            return {
                customer_detail: {},
                customers: {},

                success: '',
                keyword1: '',

                activate: 'Active',
                c_type: 'Company',
                edc_type: 'Company',
                c_phone: '',
                c_mobile: '',
                c_website: '',
                c_email: '',
                customer_name: '',
                father_name: '',
                e_father_name: '',
                cnic: '',
                e_cnic: '',
                date: '',
                e_date: '',

                e_customer_name: '',
                e_c_email: '',
                e_c_mobile: '',
                e_c_address: '',

                ed_father_name: '',
                edc_phone: '',
                edc_mobile: '',
                ed_date: '',
                ed_cnic: '',
                edc_email: '',
                edcustomer_name: '',
                edc_type: 'Company',
                customer_id: '',

                e_edcustomer_name: '',
                e_edc_email: '',
                e_edc_mobile: '',
                e_ed_cnic: '',

                disabled: false,
                timeout: null,
                disabled1: false,
                timeout1: null,
            }
        },
        components: {
            MaskedInput
        },
        methods: {

            fetch_customer_detail(id) {

                axios.get('accounts_fetch_seller/' + id)
                    .then(response => {
                    this.customer_detail=response.data;
                        this.edcustomer_name = response.data[0].SellerName;
                        this.ed_cnic = response.data[0].CNIC;
                        this.edc_mobile = response.data[0].Mobile;
                        this.customer_id = response.data[0].SellerID;

                    })
                    .catch(error => { });

            },
            changeStatus(id, sts) {

                axios.post('./accounts_update_cusSts', {
                    ed_cusid: id,
                    status: sts,
                })
                    .then(data => {
                        if (data.data == 'Status updated!') {
                            this.$toastr.s("Status updated Successfully!", "Congratulations!");
                            this.getResult();
                        }
                    })
                    .catch(error => this.error = error.responce.data.errors)

            },
            delay() {
                this.disabled = true
                this.timeout = setTimeout(() => {
                    this.disabled = false
                }, 5000)
                this.submit_customer();
            },
            delay1() {
                this.disabled1 = true
                this.timeout1 = setTimeout(() => {
                    this.disabled1 = false
                }, 5000)
                this.update_customer();
            },
            submit_customer() {
                if (this.c_mobile == '' || this.customer_name == '' || this.cnic == '') {
                    if (this.c_mobile == '') {
                        this.e_c_mobile = "Enter mobile number";
                    }
                    else {
                        this.e_c_mobile = "Enter mobile number";
                    }
                    if (this.customer_name == '') {
                        this.e_customer_name = "Enter name";
                    }
                    else {
                        this.e_customer_name = "";
                    }


                    this.$toastr.e("Please fill required fields!", "Caution!");
                }
                else {
                    axios.post('./land_add_seller', {
                        customer_name: this.customer_name,
                        c_mobile: this.c_mobile,
                       	cnic: this.cnic,
                    })
                        .then(data => {
                            if (data.data == 'Seller Added Successfully') {
                                this.$toastr.s("Seller Added Successfully", "Congratulations!");
                                this.getResult();
                                this.c_mobile = '';
                                this.customer_name = '';
                                this.cnic == '';

                            }
                            else{
                                this.$toastr.e("Seller already exists!", "Caution!");
                            }
                        })
                }
            },

            search_by_name(page = 1) {
                axios.get('./accounts_customer_byname/?page=' + page, { params: { name: this.keyword1 } })
                    .then(data => this.customers = data.data)
                    .catch(error => { });
            },
            getResult(page = 1) {
                axios.get('accounts_seller_detail/?page=' + page)
                    .then(data => this.customers = data.data)
                    .catch(error => { });
            }
        },
        watch: {
            keyword1(after, before) {
                this.search_by_name();
            }
        },
        mounted() {


            this.getResult();
        }
    }

</script>
