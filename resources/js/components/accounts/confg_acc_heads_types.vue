<template>
    <div>
        <!-- BEGIN: Content-->
        <div class="app-content content">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <router-link to="/accounts" style="text-decoration: none;">Accounts Dashboard</router-link>
                            </li>
                            <li class="breadcrumb-item active">Accounts Heads/Types</li>
                        </ol>
                    </div>
                </div>
                <div class="content-body">
                    <section class="app-user-view-account">
                        <div class="row">
                            <!-- User Sidebar -->
                            <div class="col-xl-6 col-lg-6 col-md-6 order-1 col-12 order-md-0">
                                <!-- User Card -->
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Accounts Type</h4>
                                        <div style="text-align: right; width: 60% !important">
                                            <!--<a style="float: left" data-bs-toggle="modal" data-bs-target="#addNewCard" class="btn btn-outline-primary waves-effect" type="button">Create New</a>-->
                                            <div class="" style="float: right">
                                                <div style="">
                                                    <label>
                                                        <input autocomplete="off" id="name" type="text" name="name" v-model="name" class="form-control" @change="getAccType()" placeholder="Search By Name" />
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div style="margin-bottom: 20px" class="d-flex justify-content-between align-items-center header-actions mx-2 row mt-75">
                                            <section id="accordion-with-border">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div id="accordionWrapa50" role="tablist" aria-multiselectable="true">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="table-responsive" style="overflow-x: initial !important">
                                                                        <table class="table table-hover">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Head Code</th>
                                                                                    <th>Name</th>
                                                                                    <th>Description</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr v-for="adsdata1 in adsdata.data">
                                                                                    <td>{{adsdata1.HeadCode}}</td>
                                                                                    <td>{{adsdata1.HeadName}}</td>
                                                                                    <td>{{adsdata1.Description}}</td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div style="text-align: center; padding-top: 20px; ">
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
                            <!--/ User Sidebar -->
                            <div class="col-xl-6 col-lg-6 col-md-6 order-1 col-12 order-md-0">
                                <!-- User Card -->
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Journal Heads</h4>
                                        <div style="text-align: right; width: 60% !important">
                                            <a v-if="hasPermission('Accounts Configurations Accounts-heads create-journal-heads')" style="float: left" data-bs-toggle="modal" data-bs-target="#addNewCard2" class="btn btn-outline-primary waves-effect">Create New</a>
                                            <div class="" style="float: right">
                                                <div style="">
                                                    <label>
                                                        <input autocomplete="off" id="jHead" type="text" name="jHead" v-model="jHead" class="form-control" @change="getJurHead()" placeholder="Search By Name" />
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div style="margin-bottom: 20px" class="d-flex justify-content-between align-items-center header-actions mx-2 row mt-75 ">
                                            <section id="accordion-with-border">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div id="accordionWrapa50" role="tablist" aria-multiselectable="true">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="table-responsive" style="overflow-x: initial !important">
                                                                        <table class="table table-hover">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Head Code</th>
                                                                                    <th>Journal Name</th>
                                                                                    <th>Accounts Type</th>

                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr v-for="journal_data1 in journal_data.data">
                                                                                    <td>{{journal_data1.journalCode}}</td>
                                                                                    <td>{{journal_data1.JournalName}}</td>
                                                                                    <td>{{journal_data1.HeadId}}</td>
                                                                                </tr>

                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div style="text-align: center;padding-top: 20px;">
                                                                        <pagination :data="journal_data" @pagination-change-page="getResult2"></pagination>
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
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <h3 class="text-center mb-1" id="addNewCardTitle">
                            Create Accounts Category
                        </h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-sm-5 mx-50 pb-5">
                        <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="col-12">
                                <label class="form-label" for="modalAddCardName">Category Name</label>
                                <input autocomplete="off" v-model="category_name" class="form-control" style="" placeholder="Type Accounts Type Here" />
                                <span style="color: #db4437; font-size: 11px" v-if="category_name == ''">{{ category_name_error }}</span>
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="modalAddCardName">Head Code</label>
                                <masked-input class="form-control account-number-mask" v-model="head_code" mask="1" placeholder="Head Code Here" />
                                <span style="color: #db4437; font-size: 11px" v-if="head_code == ''">{{ head_code_error }}</span>
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="modalAddCardName">Description</label>
<textarea class="form-control" v-model="Description" placeholder="Type Product Description Here"></textarea>
                                <span style="color: #db4437; font-size: 11px" v-if="Description == ''">{{ Description_error }}</span>
                            </div>
                            <div class="col-12 text-center">
                                <button type="button" :disabled="disabled" @click="delay()" class="btn btn-primary me-1 mt-1">
                                    Submit
                                </button>
                                <button type="reset" class="btn btn-outline-secondary mt-1" data-bs-dismiss="modal" aria-label="Close">
                                    Close
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="addNewCard2" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <h3 class="text-center mb-1" id="addNewCardTitle">
                            Create Journal Head
                        </h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-sm-5 mx-50 pb-5">
                        <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="col-12">
                                <label class="form-label" for="modalAddCardName">Journal Name</label>
                                <input autocomplete="off" v-model="journal_name" class="form-control" style="" placeholder="Type Journal Name Here" />
                                <span style="color: #db4437; font-size: 11px" v-if="journal_name == ''">{{ journal_name_error }}</span>
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="modalAddCardName">Journal Code</label>
                                <input class="form-control" type="number" v-model="journal_code" placeholder="Please Type 3 Character Journal Code e.g 101" />
                                <span style="color: #db4437; font-size: 11px" v-if="journal_code == ''">{{ journal_code_error }}</span>
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="modalAddCardName">Type</label>
                                <select v-model="type" class="form-select">
                                    <option value="">Select Type</option>
                                    <option v-for='get_accounts_type1 in get_accounts_type' :value='get_accounts_type1.HeadName'>{{ get_accounts_type1.HeadName }}</option>



                                </select>
                                <span style="color: #db4437; font-size: 11px" v-if="type == ''">{{ type_error }}</span>
                            </div>


                            <div class="col-12 text-center">
                                <button type="submit" :disabled1="disabled1" @click="delay1()" class="btn btn-primary me-1 mt-1">
                                    Submit
                                </button>
                                <button type="reset" class="btn btn-outline-secondary mt-1" data-bs-dismiss="modal" aria-label="Close">
                                    Close
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
    import MaskedInput from "vue-masked-input";
    export default {
        data() {
            return {
                disabled: false,
                disabled1: false,
                timeout1: null,
                timeout: null,
                get_accounts_type: {},
                name: '',
                jHead: '',


                journal_name: "",
                journal_name_error: "",
                journal_code: "",
                journal_code_error: "",
                type: "",
                type_error: "",

                category_name: "",
                Description: "",
                head_code: '',
                head_code_error: '',
                category_name_error: "",
                Description_error: "",
                category_status: "true",
                adsdata: {},
                journal_data: {},
            };
        },
        components: {
            MaskedInput,
        },
        methods: {
            delay() {
                this.disabled = true
                this.timeout = setTimeout(() => {
                    this.disabled = false
                }, 5000)
                this.submit_cateogory()
            },

            delay1() {
                this.disabled1 = true
                this.timeout1 = setTimeout(() => {
                    this.disabled1 = false
                }, 5000)
                this.submit_heads()
            },

            submit_heads() {
                if (
                    this.journal_name == "" ||
                    this.type == "" ||
                    this.journal_code == ""
                ) {
                    this.$toastr.e("Please fill required fields!", "Caution!");
                    if (this.journal_name == "") {
                        this.journal_name_error = "Please enter journal name";
                    }
                    if (this.journal_code == "") {
                        this.journal_code_error = "Please enter journal code";
                    }
                    if (this.type == "") {
                        this.type_error = "Please select type";
                    }


                }
                else {
                    axios.post("./accounts/submit_journal_head", {
                        journal_name: this.journal_name,
                        type: this.type,
                        journal_code: this.journal_code,
                    })
                        .then((data) => {
                            if (data.data == "Please select 3 Digits Code") {
                                this.$toastr.e("Please Select 3 DigitCode!", "Caution!");
                            }
                            else if (data.data == "Please Select Valid Head Code") {
                                this.$toastr.e("Please Select Valid Head Code!", "Caution!");
                            }
                            else if (data.data == "Head Code Already Exists in Our Record.Please Try Other One") {
                                this.$toastr.e("Head Code Already Exists in Our Record.Please Try Other One!", "Caution!");
                            }
                            else if (data.data == "Journal Name Already Exists in Our Record.Please Try Other One") {
                                this.$toastr.e("Journal Name Already Exists in Our Record.Please Try Other One", "Caution!");
                            }
                            else {
                                this.journal_data = data.data;
                                this.journal_name = "";
                                this.type = "";
                                this.journal_code = "";
                                this.$toastr.s("Journal Head Added Successfully!", "Congratulations!");
                            }

                        })

                }

            },
            submit_cateogory() {
                if (this.category_name == "" || this.Description == "" || this.head_code == '') {
                    this.$toastr.e("Please fill required fields!", "Caution!");
                    if (this.category_name == "") {
                        this.category_name_error = "Please enter Account Type";
                    }
                    if (this.Description == "") {
                        this.Description_error = "Please enter Description";
                    }
                    if (this.head_code == "") {
                        this.head_code_error = "Please enter Head Code";
                    }
                }
                else {
                    axios.post("./accounts/submit_account_type", {
                        category_name: this.category_name,
                        Description: this.Description,
                        head_code: this.head_code,
                    })
                        .then((data) => {
                            if (data.data == "Head Code Already Exists in Our Record.Please Try Other One") {
                                this.$toastr.e("Head Code Already Exists in Our Record.Please Try Other One", "Caution!");
                            }
                            else if (data.data == "Accounts Type Already Exists in Our Record.Please Try Other One") {
                                this.$toastr.e("Accounts Type Already Exists in Our Record.Please Try Other One", "Caution!");
                            }
                            else {
                                this.adsdata = data.data;
                                this.category_name = "";
                                this.Description = "";
                                this.head_code = "";
                                this.$toastr.s("Accounts Type Added Successfully!", "Congratulations!");
                            }

                        })
                }
                axios.get('accounts/get_account_type')
                    .then(response => {
                        this.get_accounts_type = response.data;
                    })
            },
            getResult(page = 1) {
                axios.get("accounts/acc_types/?page=" + page)
                    .then((response) => (this.adsdata = response.data))
                    .catch((error) => { });
            },
            getResult2(page = 1) {
                axios.get("accounts/acc_journal/?page=" + page)
                    .then((response) => (this.journal_data = response.data))
                    .catch((error) => { });
            },
            getAccType(page = 1) {
                axios.get('./accounts_AccType/?page=' + page, { params: { name: this.name } })
                    .then(response => this.adsdata = response.data)
                    .catch(error => { });
            },

            getJurHead(page = 1) {
                axios.get('./accounts_AJurHead/?page=' + page, { params: { jHead: this.jHead } })
                    .then(response => this.journal_data = response.data)
                    .catch(error => { });
            },
        },
        watch: {
            name(after, before) {
                this.getAccType();
            },
            jHead(after, before) {
                this.getJurHead();
            }
        },
        mounted() {
            this.getResult();
            this.getResult2();

            axios.get('accounts/get_account_type')
                .then(response => {
                    this.get_accounts_type = response.data;
                })
        },
    };

</script>
<style>
</style>
