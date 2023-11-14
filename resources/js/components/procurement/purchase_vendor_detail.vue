<template>
    <div>
        <!-- BEGIN: Content-->
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                           <li class="breadcrumb-item">
                                <router-link to="/accounts" style="text-decoration: none;">Accounts Dashboard</router-link>
                            </li>
                            <li class="breadcrumb-item active">
                                Vendors Detail
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
                                            <a v-if="hasPermission('Accounting procurement-configuration create-vendors')" style="float:left" data-bs-toggle="modal" data-bs-target="#addNewVendor" class="btn btn-outline-primary waves-effect">Create New Vendor</a>
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
                                            <th>Mobile</th>
                                            <th>Email</th>
                                            <th>Website</th>
                                            <th>Address</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="vendors1 in vendors.data">
                                            <td>{{vendors1.ID}}</td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <a class="user_name text-truncate text-body"><span class="fw-bolder">{{vendors1.CompanyName}} </span></a><small class="emp_post text-muted">
                                                        Type: <span v-if="vendors1.type!=null">{{vendors1.type}}</span>
                                                        <span v-else></span>
                                                    </small>
                                                </div>
                                            </td>
                                            <td>{{vendors1.Mobile}}</td>
                                            <td>{{vendors1.Email}}</td>
                                            <td>{{vendors1.weblink}}</td>
                                            <td style="max-width:180px">{{vendors1.Address}}</td>
                                            <td>
                                                <span v-if="vendors1.Status=='Active'" class="badge badge-glow bg-primary">Active</span>
                                                <span v-else class="badge badge-glow bg-secondary">Disabled</span>
                                            </td>
                                            <td style="vertical-align: middle; text-align: center;">
                                                <div class="btn-group">
                                                    <a v-if="hasPermission('Accounting procurement-configuration actions')" class="btn btn-sm dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a data-bs-toggle="modal" @click="fetch_vendor_detail(vendors1.ID)" class="dropdown-item" data-bs-target="#viewVendor">
                                                            <i class="fa-solid fa-eye"></i> View Detail
                                                        </a>
                                                        <a data-bs-toggle="modal" @click="fetch_vendor_detail(vendors1.ID)" data-bs-target="#updateVendor" class="dropdown-item">
                                                            <i class="fa-solid fa-pen-to-square"></i> Edit Vendor
                                                        </a>
                                                        <a v-if="vendors1.Status=='Disabled'" @click="changeStatus(vendors1.ID, 'Active')" class="dropdown-item">
                                                            <i class="fa-brands fa-creative-commons-sa"></i>
                                                            Activate
                                                        </a>
                                                        <a v-else @click="changeStatus(vendors1.ID, 'Disabled')" class="dropdown-item">
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
                                <pagination :data="vendors" @pagination-change-page="getResult"></pagination>
                            </div>
                        </div>
                    </section>
                    <!-- users list ends -->
                </div>
            </div>
        </div>
        <!-- END: Content-->
        <div class="modal fade" id="addNewVendor" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <h3 class="text-center mb-1" id="addNewCardTitle">Create New Vendor</h3>
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
                            <div class="col-md-12 col-12" v-if="this.c_type=='Individual'">
                                <label class="form-label" for="modalAddCardName">Vendor Name<span style="color: #db4437; font-size: 11px">*</span></label>
                                <input type="text" v-model="vendor_name" class="form-control" placeholder='Type Vendor Name' style="" />
                                <span style="color: #db4437; font-size: 11px" v-if="vendor_name == ''">{{ e_vendor_name }}</span>
                            </div>

                            <div class="col-md-12 col-12" v-if="this.c_type=='Company'">
                                <label class="form-label" for="modalAddCardName">Company Name</label>
                                <input type="text" placeholder='Type Company Name' v-model="vendor_name" class="form-control" style="" />
                                <span style="color: #db4437; font-size: 11px" v-if="vendor_name == ''">{{ e_vendor_name }}</span>
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label" for="modalAddCardName">Phone Number</label>
                                <masked-input class="form-control account-number-mask" mask="0311-1111111" v-model="v_phone" placeholder="Phone Number Here" />
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label" for="modalAddCardName">Email Address</label>
                                <input type="text" placeholder="Type Email Address" v-model="v_email" class="form-control" style="" value="0" />
                                <span style="color: #db4437; font-size: 11px" v-if="this.v_email!='' && !this.validEmail(this.v_email)">{{ e_v_email }}</span>
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label" for="modalAddCardName">Mobile Number<span style="color: #db4437; font-size: 11px">*</span></label>
                                <masked-input class="form-control account-number-mask" mask="0311-1111111" v-model="v_mobile" placeholder="Phone Number Here" />
                                <span style="color: #db4437; font-size: 11px" v-if="v_mobile == ''">{{ e_v_mobile }}</span>
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label" for="modalAddCardName">Website Link</label>
                                <input type="text" placeholder="Type website link" v-model="v_website" class="form-control" style="" />
                            </div>
                            <div class="col-md-12 col-12">
                                <label class="form-label" for="modalAddCardName">Address<span style="color: #db4437; font-size: 11px">*</span></label>
                                <textarea placeholder="Type Office Or Delivery Address" v-model="v_address" class="form-control"></textarea>
                                <span style="color: #db4437; font-size: 11px" v-if="v_address == ''">{{ e_v_address }}</span>
                            </div>
                            <div class="col-12" style="text-align:center">
                                <button :disabled="disabled" @click="delay()" type="button" class="btn btn-primary mt-1 me-1 waves-effect waves-float waves-light">Save Vendor</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="updateVendor" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <h3 class="text-center mb-1" id="addNewCardTitle">Update Vendor</h3>
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
                            <div class="col-md-12 col-12" v-if="this.edc_type=='Individual'">
                                <label class="form-label" for="modalAddCardName">Vendor Name<span style="color: #db4437; font-size: 11px">*</span></label>
                                <input type="text" v-model="edvendor_name" readonly class="form-control" placeholder='Type Vendor Name' style="" />
                                <span style="color: #db4437; font-size: 11px" v-if="edvendor_name == ''">{{ e_vendor_name }}</span>
                            </div>

                            <div class="col-md-12 col-12" v-if="this.edc_type=='Company'">
                                <label class="form-label" for="modalAddCardName">Company Name</label>
                                <input type="text" placeholder='Type Company Name' readonly v-model="edvendor_name" class="form-control" style="" />
                                <span style="color: #db4437; font-size: 11px" v-if="edvendor_name == ''">{{ e_vendor_name }}</span>
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label" for="modalAddCardName">Phone Number</label>
                                <masked-input class="form-control account-number-mask" mask="0311-1111111" v-model="edv_phone" placeholder="Phone Number Here" />
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label" for="modalAddCardName">Email Address<span style="color: #db4437; font-size: 11px">*</span></label>
                                <input type="text" placeholder="Type Email Address" v-model="edv_email" class="form-control" style="" value="0" />
                                <span style="color: #db4437; font-size: 11px" v-if="this.edv_email!='' && !this.validEmail(this.edv_email)">{{ e_edv_email }}</span>
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label" for="modalAddCardName">Mobile Number<span style="color: #db4437; font-size: 11px">*</span></label>
                                <masked-input class="form-control account-number-mask" mask="0311-1111111" v-model="edv_mobile" placeholder="Phone Number Here" />
                                <span style="color: #db4437; font-size: 11px" v-if="edv_mobile == ''">{{ e_edv_mobile }}</span>
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label" for="modalAddCardName">Website Link</label>
                                <input type="text" placeholder="Type website link" v-model="edv_website" class="form-control" style="" />
                            </div>
                            <div class="col-md-12 col-12">
                                <label class="form-label" for="modalAddCardName">Address<span style="color: #db4437; font-size: 11px">*</span></label>
                                <textarea placeholder="Type Office Or Delivery Address" v-model="edv_address" class="form-control"></textarea>
                                <span style="color: #db4437; font-size: 11px" v-if="edv_address == ''">{{ e_edv_address }}</span>
                            </div>
                            <div class="col-12" style="text-align:center">
                                <button :disabled="disabled1" @click="delay1()" type="button" class="btn btn-primary mt-1 me-1 waves-effect waves-float waves-light" data-bs-dismiss="modal" aria-label="Close">Update Vendor</button>
                                <button type="reset" class="btn btn-outline-secondary mt-2" data-bs-dismiss="modal" aria-label="Close">
                                    Cancle
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="viewVendor" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-5 px-sm-5 pt-50">
                        <div class="text-center mb-2">
                            <center>
                                <div class="col-md-12" v-for="vendor_detail1 in vendor_detail">
                                    <table style="width:100%;">
                                        <thead style="float:left; width:100%;">
                                            <h2 style="text-align:center;"> Details of Vendor</h2>
                                            <tr>
                                                <th style="width:25%;">Vendor ID: </th>
                                                <td style="width:25%;">{{vendor_detail1.ID}}</td>
                                                <th style="width:25%;">Vendor Name: </th>
                                                <td style="width:25%;">{{vendor_detail1.CompanyName}}</td>
                                            </tr>
                                            <tr>
                                                <th>Phone Number: </th>
                                                <td>{{vendor_detail1.Phone}}</td>
                                                <th>Email Address: </th>
                                                <td>{{vendor_detail1.Email}}</td>
                                            </tr>
                                            <tr>
                                                <th>Mobile number: </th>
                                                <td>{{vendor_detail1.Mobile}}</td>
                                                <th>Type: </th>
                                                <td>{{vendor_detail1.type}}</td>
                                            </tr>
                                            <tr>
                                                <th>Web link: </th>
                                                <td>{{vendor_detail1.weblink}}</td>
                                                <th>Address: </th>
                                                <td>{{vendor_detail1.Address}}</td>
                                            </tr>
                                            <tr>
                                                <th>Status: </th>
                                                <td>
                                                    <span v-if="vendor_detail1.Status=='Active'" class="badge badge-glow bg-primary">Active</span>
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
                vendor_detail: {},
                vendors: {},
                success: '',
                keyword1: '',

                activate: 'Active',
                c_type: 'Company',
                edc_type: 'Company',
                v_phone:'',
                v_mobile: '',
                v_website: '',
                v_address: '',
                v_email:'',
                vendor_name: '',

                e_v_companyname: '',
                e_vendor_name: '',
                e_v_email:'',
                e_v_mobile: '',
                e_v_address: '',

                edv_phone:'',
                edv_mobile: '',
                edv_website: '',
                edv_address: '',
                edv_email:'',
                edvendor_name: '',
                edv_type: '',
                vendor_id: '',
                e_v_email: '',

                e_edvendor_name: '',
                e_edv_email:'',
                e_edv_mobile: '',
                e_edv_address: '',

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
            fetch_vendor_detail(id) {
                axios.get('accounts_fetch_vendors/' + id)
                    .then(response => {
                        this.vendor_detail = response.data;
                        this.edvendor_name = response.data[0].CompanyName;
                        this.edv_companyname = response.data[0].CompanyName;
                        this.edv_phone = response.data[0].Phone;
                        this.edv_email = response.data[0].Email;
                        this.edv_mobile = response.data[0].Mobile;
                        this.edv_website = response.data[0].weblink;
                        this.edv_address = response.data[0].Address;
                        this.edc_type = response.data[0].type;
                        this.vendor_id = response.data[0].ID;
                    })
                    .catch(error => { });
            },
            changeStatus(id, sts) {
                axios.post('./accounts_update_venSts', {
                    ed_venid: id,
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
                this.submit_vendor();
            },
            delay1() {
                this.disabled1 = true
                this.timeout1 = setTimeout(() => {
                    this.disabled1 = false
                }, 5000)
                this.update_vendor();
            },
            validEmail: function (email) {
                var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            },
            submit_vendor() {
                 const account_name1=this.vendor_name.replace("/",'-');

                if (this.v_mobile == '' || this.v_address == '' || this.vendor_name == '' || (this.v_email != '' && !this.validEmail(this.v_email))) {
                    if (this.v_mobile == '') {
                        this.e_v_mobile = "Enter mobile number";
                    }
                    else {
                        this.e_v_mobile = "Enter mobile number";
                    }
                    if (this.v_address == '') {
                        this.e_v_address = "Enter address";
                    }
                    else {
                        this.e_v_address = "";
                   }
                    if (this.vendor_name == '') {
                        this.e_vendor_name = "Enter vendors name";
                    }
                    else {
                        this.e_vendor_name = "";
                    }
                    if (this.v_email != '' && !this.validEmail(this.v_email)) {
                        this.e_v_email = "Enter valid email address";
                    }
                    else {
                        this.e_v_email = "";
                    }
                    this.$toastr.e("Please fill required fields!", "Caution!");
                }
                else {
                    axios.post('./accounts_add_vendor', {
                        vendor_name: account_name1,
                        v_phone: this.v_phone,
                        v_email: this.v_email,
                        v_mobile: this.v_mobile,
                        v_website: this.v_website,
                        v_address: this.v_address,
                        c_type: this.c_type,
                    })
                        .then(data => {

                            if(data.data == 'Vendor Added Successfully') {
                                this.$toastr.s("Vendor Added Successfully", "Congratulations!");

                                this.getResult();

                                this.v_mobile = '';
                                this.v_phone = '';
                                this.v_address = '';
                                this.v_email = '';
                                this.vendor_name = '';
                                this.v_website = '';

                                this.e_v_mobile = '';
                                this.e_v_address = '';
                                this.e_vendor_name = '';
                                this.e_v_email = '';
                            }
                            else {
                             this.$toastr.e("Vendor Already Exists", "Cautions!");
                            }
                        })
                }
            },
            update_vendor() {
                if (this.edv_mobile == '' || this.edv_address == '' || this.edvendor_name == '' || (this.edv_email != '' && !this.validEmail(this.edv_email))){
                    if (this.edv_mobile == '') {
                        this.e_edv_mobile = "Enter mobile number";
                    }
                    else {
                        this.e_edv_mobile = "";
                    }
                    if (this.edv_address == '') {
                        this.e_edv_address = "Enter Address";
                    }
                    else {
                        this.e_edv_address = "";
                    }
                    if (this.edvendor_name == '') {
                        this.e_edvendor_name = "Enter name";
                    }
                    else {
                        this.e_edvendor_name = "";
                    }
                    if (this.edv_email != '' && !this.validEmail(this.edv_email)) {
                        this.e_edv_email = "Enter valid email address";
                    }
                    else {
                        this.e_edv_email = "";
                    }
                    this.$toastr.e("Please fill required fields!", "Caution!");
                }
                else {

                    axios.post('./accounts_update_vendor', {

                        edvendor_name: this.edvendor_name,
                        edv_phone: this.edv_phone,
                        edv_email: this.edv_email,
                        edv_mobile: this.edv_mobile,
                        edv_website: this.edv_website,
                        edv_address: this.edv_address,
                        edc_type: this.edc_type,
                        vendor_id: this.vendor_id,
                    })
                        .then(data => {

                            if (data.data == 'Vendor updated!') {
                                this.$toastr.s("Vendor updated!", "Congratulations!");
                                this.getResult();
                                this.edvendor_name = '';
                                this.edv_phone = '';
                                this.edv_mobile = '';
                                this.edv_email = '';
                                this.edv_website = '';
                                this.edv_address = '';
                                this.vendor_id = '';

                                this.e_edv_mobile = '';
                                this.e_edv_address = '';
                                this.e_edvendor_name = '';
                                this.e_edv_email = '';
                            }
                            else {
                             this.$toastr.e("Vendor Already Exists", "Cautions!");
                            }
                        })

                }

            },
            search_by_name(page = 1) {
                axios.get('./accounts_vendor_byname?page=' + page, { params: { name: this.keyword1 } })
                    .then(data => this.vendors = data.data)
                    .catch(error => { });
            },
            getResult(page = 1) {
                axios.get('accounts_vendor_detail?page=' + page)
                    .then(data => this.vendors = data.data)
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
