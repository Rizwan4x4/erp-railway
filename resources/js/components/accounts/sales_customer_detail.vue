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
                                Customers Detail
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
                                                    <input autocomplete="off" type="text" name="keyword1" v-model="keyword1" @change="search_by_name()" class="form-control" style="" placeholder="Search By Department" />
                                                </label>
                                            </div>
                                        </div>
                                        <div class="dt-buttons d-inline-flex mt-50">
                                            <a style="float:left" data-bs-toggle="modal" data-bs-target="#addNewCustomer" class="btn btn-outline-primary waves-effect">Create New Customer</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive" style="overflow-x: initial !important;">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name & Type</th>
                                            <th>Father's Name</th>
                                            <th>Mobile</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="customers1 in customers.data">
                                            <td>{{customers1.CustomerID}}</td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <a class="user_name text-truncate text-body"><span class="fw-bolder">{{customers1.CustomerName}} </span></a><small class="emp_post text-muted">
                                                        Type: <span v-if="customers1.CustomerType!=null">{{customers1.CustomerType}}</span>
                                                        <span v-else></span>
                                                    </small>
                                                </div>
                                            </td>
                                            <td>{{customers1.FatherHusband}}</td>
                                            <td>{{customers1.Mobile}}</td>
                                            <td>{{customers1.Email}}</td>
                                            <td>
                                                <span v-if="customers1.Status=='1'" class="badge badge-glow bg-primary">Active</span>
                                                <span v-else class="badge badge-glow bg-secondary">Disabled</span>
                                            </td>
                                            <td style="vertical-align: middle; text-align: center;">
                                                <div class="btn-group">
                                                    <a class="btn btn-sm dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a data-bs-toggle="modal" @click="fetch_customer_detail(customers1.CustomerID)" class="dropdown-item" data-bs-target="#viewCustomer">
                                                            <i class="fa-solid fa-eye"></i> View Detail
                                                        </a>
                                                        <a data-bs-toggle="modal" @click="fetch_customer_detail(customers1.CustomerID)" data-bs-target="#updateCustomer" class="dropdown-item">
                                                            <i class="fa-solid fa-pen-to-square"></i> Edit Customer
                                                        </a>
                                                        <a v-if="customers1.Status=='0'" @click="changeStatus(customers1.CustomerID, '1')" class="dropdown-item">
                                                            <i class="fa-brands fa-creative-commons-sa"></i>
                                                            Activate
                                                        </a>
                                                        <a v-else @click="changeStatus(customers1.CustomerID, '0')" class="dropdown-item">
                                                            <i class="fa-brands fa-creative-commons-sa"></i>
                                                            Disable
                                                        </a>
                                                    </div>
                                                </div>
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
                        <h3 class="text-center mb-1" id="addNewCardTitle">Create New Customer</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-sm-5 mx-50 pb-5">
                        <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="col-12 col-sm-12 mb-1">
                                <div class="mb-1">
                                    <div class="demo-inline-spacing">
                                        <div class="form-check form-check-inline" style="margin-top:0px">
                                            <input class="form-check-input" type="radio" v-model="c_type" name="inlineRadioOptions" id="inlineRadio1" value="Individual">
                                            <label class="form-check-label" for="inlineRadio1">Individual</label>
                                        </div>
                                        <div class="form-check form-check-inline" style="margin-top:0px">
                                            <input class="form-check-input" checked="" type="radio" v-model="c_type" name="inlineRadioOptions" id="inlineRadio2" value="Company">
                                            <label class="form-check-label" for="inlineRadio2">Company</label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-6 col-12" v-if="this.c_type=='Individual'">
                                <label class="form-label" for="modalAddCardName">Customer Name<span style="color: #db4437; font-size: 11px">*</span></label>
                                <input type="text" v-model="customer_name" class="form-control" placeholder='Type Customer Name' style="" />
                                <span style="color: #db4437; font-size: 11px" v-if="customer_name == ''">{{ e_customer_name }}</span>
                            </div>

                            <div class="col-md-6 col-12" v-if="this.c_type=='Individual'">
                                <label class="form-label" for="modalAddCardName">Father's Name<span style="color: #db4437; font-size: 11px">*</span></label>
                                <input type="text" v-model="father_name" class="form-control" placeholder="Type Father's Name" style="" />
                                <span style="color: #db4437; font-size: 11px" v-if="father_name == ''">{{ e_father_name }}</span>
                            </div>
                            <div class="col-md-12 col-12" v-if="this.c_type=='Company'">
                                <label class="form-label" for="modalAddCardName">Company Name</label>
                                <input type="text" placeholder='Type Company Name' v-model="customer_name" class="form-control" style="" />
                                <span style="color: #db4437; font-size: 11px" v-if="customer_name == ''">{{ e_customer_name }}</span>
                            </div>
                            <div class="col-md-6 col-12" v-if="this.c_type=='Individual'">
                                <label class="form-label" for="modalAddCardName">CNIC Number<span style="color: #db4437; font-size: 11px">*</span></label>
                                <masked-input class="form-control account-number-mask" mask="11111-1111111-1" v-model="cnic" placeholder="CNIC Number Here" />
                                <span style="color: #db4437; font-size: 11px" v-if="cnic == ''">{{ e_cnic }}</span>
                            </div>
                            <div class="col-md-6 col-12" v-if="this.c_type=='Individual'">
                                <label class="form-label" for="modalAddCardName">DOB</label>
                                <input type="date" placeholder="DOB" v-model="date" class="form-control" />
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label" for="modalAddCardName">Phone Number</label>
                                <masked-input class="form-control account-number-mask" mask="0311-1111111" v-model="c_phone" placeholder="Phone Number Here" />
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label" for="modalAddCardName">Email Address</label>
                                <input type="text" placeholder="Type Email Address" v-model="c_email" class="form-control" style="" value="0" />
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label" for="modalAddCardName">Mobile Number<span style="color: #db4437; font-size: 11px">*</span></label>
                                <masked-input class="form-control account-number-mask" mask="0311-1111111" v-model="c_mobile" placeholder="Phone Number Here" />
                                <span style="color: #db4437; font-size: 11px" v-if="c_mobile == ''">{{ e_c_mobile }}</span>
                            </div>
                            <div class="col-12" style="text-align:center">
                                <button :disabled="disabled" @click="delay()" type="button" class="btn btn-primary mt-1 me-1 waves-effect waves-float waves-light">Save Customer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="updateCustomer" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <h3 class="text-center mb-1" id="addNewCardTitle">Update Customer</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-sm-5 mx-50 pb-5">
                        <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="col-12 col-sm-12 mb-1">
                                <div class="mb-1">
                                    <div class="demo-inline-spacing">
                                        <div class="form-check form-check-inline" style="margin-top:0px">
                                            <input class="form-check-input" type="radio" v-model="edc_type" name="inlineRadioOptions" id="inlineRadio1" value="Individual">
                                            <label class="form-check-label" for="inlineRadio1">Individual</label>
                                        </div>
                                        <div class="form-check form-check-inline" style="margin-top:0px">
                                            <input class="form-check-input" checked="" type="radio" v-model="edc_type" name="inlineRadioOptions" id="inlineRadio2" value="Company">
                                            <label class="form-check-label" for="inlineRadio2">Company</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12" v-if="this.edc_type=='Individual'">
                                <label class="form-label" for="modalAddCardName">Customer Name<span style="color: #db4437; font-size: 11px">*</span></label>
                                <input type="text" v-model="edcustomer_name" class="form-control" placeholder='Type Customer Name' style="" />
                                <span style="color: #db4437; font-size: 11px" v-if="edcustomer_name == ''">{{ e_edcustomer_name }}</span>
                            </div>
                            <div class="col-md-6 col-12" v-if="this.edc_type=='Individual'">
                                <label class="form-label" for="modalAddCardName">Father's Name<span style="color: #db4437; font-size: 11px">*</span></label>
                                <input type="text" v-model="ed_father_name" class="form-control" placeholder="Type Father's Name" style="" />
                                <span style="color: #db4437; font-size: 11px" v-if="ed_father_name == ''">{{ e_ed_father_name }}</span>
                            </div>
                            <div class="col-md-12 col-12" v-if="this.edc_type=='Company'">
                                <label class="form-label" for="modalAddCardName">Company Name</label>
                                <input type="text" placeholder='Type Company Name' v-model="edcustomer_name" class="form-control" style="" />
                                <span style="color: #db4437; font-size: 11px" v-if="edcustomer_name == ''">{{ e_edcustomer_name }}</span>
                            </div>
                            <div class="col-md-6 col-12" v-if="this.edc_type=='Individual'">
                                <label class="form-label" for="modalAddCardName">CNIC Number<span style="color: #db4437; font-size: 11px">*</span></label>
                                <masked-input class="form-control account-number-mask" mask="11111-1111111-1" v-model="ed_cnic" placeholder="CNIC Number Here" />
                                <span style="color: #db4437; font-size: 11px" v-if="ed_cnic == ''">{{ e_ed_cnic }}</span>
                            </div>
                            <div class="col-md-6 col-12" v-if="this.edc_type=='Individual'">
                                <label class="form-label" for="modalAddCardName">DOB</label>
                                <input type="date" placeholder="DOB" v-model="ed_date" class="form-control" />
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label" for="modalAddCardName">Phone Number</label>
                                <masked-input class="form-control account-number-mask" mask="0311-1111111" v-model="edc_phone" placeholder="Phone Number Here" />
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label" for="modalAddCardName">Email Address</label>
                                <input type="text" placeholder="Type Email Address" v-model="edc_email" class="form-control" />
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label" for="modalAddCardName">Mobile Number<span style="color: #db4437; font-size: 11px">*</span></label>
                                <masked-input class="form-control account-number-mask" mask="0311-1111111" v-model="edc_mobile" placeholder="Phone Number Here" />
                                <span style="color: #db4437; font-size: 11px" v-if="edc_mobile == ''">{{ e_edc_mobile }}</span>
                            </div>
                            <div class="col-12" style="text-align:center">
                                <button :disabled="disabled1" @click="delay1()" type="button" class="btn btn-primary mt-1 me-1 waves-effect waves-float waves-light" data-bs-dismiss="modal" aria-label="Close">Update Customer</button>
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
                                            <h2 style="text-align:center;"> Details of Customer</h2>
                                            <tr>
                                                <th style="width:25%;">Customer ID: </th>
                                                <td style="width:25%;">{{customer_detail1.CustomerID}}</td>
                                                <th style="width:25%;">Customer Name: </th>
                                                <td style="width:25%;">{{customer_detail1.CustomerName}}</td>
                                            </tr>
                                            <tr v-if="customer_detail1.CustomerType=='Individual'">
                                                <th>CNIC Number: </th>
                                                <td>{{customer_detail1.CNIC}}</td>
                                                <th>DOB: </th>
                                                <td>{{customer_detail1.DOB}}</td>
                                            </tr>
                                            <tr>
                                                <th>Phone Number: </th>
                                                <td>{{customer_detail1.Phone}}</td>
                                                <th>Email Address: </th>
                                                <td>{{customer_detail1.Email}}</td>
                                            </tr>
                                            <tr>
                                                <th>Mobile number: </th>
                                                <td>{{customer_detail1.Mobile}}</td>
                                                <th>Type: </th>
                                                <td v-if="customer_detail1.CustomerType=='Company'">Company</td>
                                                <td v-else>Individual</td>
                                            </tr>
                                            <tr>
                                                <th>Status: </th>
                                                <td>
                                                    <span v-if="customer_detail1.Status=='1'" class="badge badge-glow bg-primary">Active</span>
                                                    <span v-else class="badge badge-glow bg-secondary">Disabled</span>
                                                </td>
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
    import MaskedInput from 'vue-masked-input'
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

                axios.get('accounts_fetch_customer/' + id)
                    .then(response => {
                        this.customer_detail = response.data;
                        this.edcustomer_name = response.data[0].CustomerName;
                        this.ed_father_name = response.data[0].FatherHusband;
                        this.ed_cnic = response.data[0].CNIC;
                        this.ed_date = response.data[0].DOB;
                        this.edc_phone = response.data[0].Phone;
                        this.edc_email = response.data[0].Email;
                        this.edc_mobile = response.data[0].Mobile;
                        this.edc_type = response.data[0].CustomerType;
                        this.customer_id = response.data[0].CustomerID;

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
                if (this.c_mobile == '' || this.customer_name == '' || (this.cnic == '' && this.c_type == 'Individual') || (this.father_name == '' && this.c_type == 'Individual')) {
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
                    if (this.father_name == '' && this.c_type == 'Individual') {
                        this.e_father_name = "Enter father's name";
                    }
                    else {
                        this.e_father_name = "";
                    }
                    if (this.cnic == '' && this.c_type == 'Individual') {
                        this.e_cnic = "Enter CNIC";
                    }
                    else {
                        this.e_cnic = "";
                    }
                    this.$toastr.e("Please fill required fields!", "Caution!");
                }
                else {
                    axios.post('./accounts_add_customer', {
                        customer_name: this.customer_name,
                        c_fathername: this.father_name,
                        c_phone: this.c_phone,
                        c_email: this.c_email,
                        c_mobile: this.c_mobile,
                        c_website: this.c_website,
                        c_type: this.c_type,
                        date: this.date,
                        cnic: this.cnic,
                    })
                        .then(data => {
                            if (data.data == 'Customer Added Successfully') {
                                this.$toastr.s("Customer Added Successfully", "Congratulations!");
                                this.getResult();
                                this.c_mobile = '';
                                this.c_phone = '';
                                this.c_email = '';
                                this.customer_name = '';
                                this.father_name = '';
                                this.c_website = '';
                                this.date = '';
                            }
                            else{
                                this.$toastr.e("Customer already exists!", "Caution!");
                            }
                        })
                }
            },
            update_customer() {
                if (this.edc_mobile == '' || (this.ed_father_name == '' && this.edc_type == 'Individual') || (this.ed_cnic == '' && this.edc_type == 'Individual') || this.edcustomer_name == '') {

                    if (this.edc_mobile == '') {
                        this.e_edc_mobile = "Enter mobile number";
                    }
                    else {
                        this.e_edc_mobile = "";
                    }
                    if (this.edcustomer_name == '') {
                        this.e_edcustomer_name = "Enter name";
                    }
                    else {
                        this.e_edcustomer_name = "";
                    }
                    if (this.ed_cnic == '' && this.edc_type == 'Individual') {
                        this.e_ed_cnic = "Enter CNIC";
                    }
                    else {
                        this.e_ed_cnic = "";
                    }
                    if (this.ed_father_name == '' && this.edc_type == 'Individual') {
                        this.e_ed_father_name = "Enter Father Name";
                    }
                    else {
                        this.e_ed_father_name = "";
                    }
                    this.$toastr.e("Please fill required fields!", "Caution!");
                }
                else {
                    axios.post('./accounts_update_customer', {
                        edcustomer_name: this.edcustomer_name,
                        ed_father_name: this.ed_father_name,
                        ed_cnic: this.ed_cnic,
                        ed_date: this.ed_date,
                        edc_phone: this.edc_phone,
                        edc_email: this.edc_email,
                        edc_mobile: this.edc_mobile,
                        edc_type: this.edc_type,
                        customer_id: this.customer_id,
                    })
                        .then(data => {
                            if (data.data == 'Customer updated!') {
                                this.$toastr.s("Customer updated!", "Congratulations!");
                                this.search_by_name();

                                this.edcustomer_name = '';
                                this.ed_father_name = '';
                                this.ed_cnic = '';
                                this.ed_date = '';
                                this.edc_phone = '';
                                this.edc_mobile = '';
                                this.edc_email = '';
                                this.customer_id = '';

                                this.getResult();
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
                axios.get('accounts_customer_detail/?page=' + page)
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
