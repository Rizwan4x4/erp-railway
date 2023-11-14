<template>
    <div>
        <!-- BEGIN: Content-->
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                </div>
                <div class="content-body">
                    <div class="content-header row">
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <router-link to="/hr/dashboard" style="text-decoration: none;">Dashboard</router-link>
                                </li>
                                <li class="breadcrumb-item active">
                                    Departments
                                </li>
                            </ol>
                        </div>
                    </div>
                    <section class="app-user-view-account">
                        <div class="row">
                            <!-- User Sidebar -->
                            <div class="col-xl-12 col-lg-12 col-md-12 order-1 order-md-0">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Add New Department</h4>
                                    </div>
                                    <div class="card-body">
                                        <form class="form form-vertical">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <label class="form-label">Department Name <span style="color: #DB4437; font-size: 11px;">*</span></label>
                                                    <input type="text" class="form-control" v-model='department_name' placeholder="Must be Unique">
                                                    <span style="color: #DB4437; font-size: 11px;" v-if="department_name==''">{{e_department_name}}</span>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label" v-if="company_name!='New company'">Select Company Name <span style="color: #DB4437; font-size: 11px;">*</span></label>
                                                    <label class="form-label" v-else>New Company Name <span style="color: #DB4437; font-size: 11px;">*</span></label>
                                                    <multiselect v-if="company_name!='New company'" :show-labels="false" style="margin-right: 10px; font-size: 15px;" placeholder="Child Company" v-model="company_name" :options="options">
                                                    </multiselect>
                                                    <input v-if="company_name=='New company'" value="" type="text" class="form-control" v-model='new_company_name' placeholder="Must be Unique">
                                                    <span style="color: #DB4437; font-size: 11px;" v-if="(company_name!='New company' && (company_name=='' || company_name==null)) || (company_name=='New company' && new_company_name=='')">{{e_company_name}}</span>
                                                </div>
                                                <div class="col-md-3" style="margin-top:28px;">
                                                    <button v-if="hasPermission('Add new department')"  type="button" @click="submit_department()" class="btn btn-primary me-1 waves-effect waves-float waves-light">Submit</button>
                                                    <button  v-if="hasPermission('Reset department')" type="reset" @click="reset()" class="btn btn-outline-secondary waves-effect">Reset</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!--/ User Sidebar -->

                            <div class="col-xl-12 col-lg-12 col-md-12 order-1 order-md-0">
                                <!-- User Card -->
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row" style="margin-bottom:10px;">
                                            <div class="col-md-4">
                                                <input type="text" name="keyword1" v-model="keyword1" class="form-control" placeholder="Search By Department name" />
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" name="keyword2" v-model="keyword2" class="form-control" placeholder="Search By Company name" />
                                            </div>
                                            <div class="col-md-1">

                                                <button  v-if="hasPermission('clear department')" type="reset" @click="clear_search()" class="btn btn-outline-secondary waves-effect">Clear</button>
                                            </div>
                                        </div>
                                        <div class="table-responsive" style="overflow-x: initial !important;">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="sticky-th-left">Department Name</th>
                                                        <th class="sticky-th-left">Company Name</th>
                                                        <th class="sticky-th-center">Dept. Status</th>
                                                        <th class="sticky-th-center">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="adsdata1 in adsdata.data">
                                                        <td>{{adsdata1.Department}}</td>
                                                        <td>{{adsdata1.Company}}</td>
                                                        <td class="td-center">
                                                            <span v-if="adsdata1.Status=='Active'" class="badge bg-light-success">{{adsdata1.Status}}</span>
                                                            <span v-else class="badge bg-light-danger">{{adsdata1.Status}}</span>
                                                        </td>
                                                        <td class="td-center">
                                                            <div class="btn-group">
                                                                <a v-if="hasPermission('department actions')" class="btn btn-sm dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <button v-if="adsdata1.Status=='Active'" @click="deactive(adsdata1.ID)" class="dropdown-item">
                                                                        <i class="fa-solid fa-rotate-left"></i>Disable
                                                                    </button>
                                                                    <button v-if="adsdata1.Status=='Disabled'" @click="active(adsdata1.ID)" class="dropdown-item">
                                                                        <i class="fa-solid fa-rotate-left"></i>Activate
                                                                    </button>
                                                                    <a v-if="adsdata1.Status=='Active'" @click="fetch_department(adsdata1.ID)" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editDepartment">
                                                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                                                    </a>
                                                                    <a @click="delete_department(adsdata1.ID)" class="dropdown-item">
                                                                        <i class="fa-solid fa-trash-can"></i> Delete
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div style="text-align:center;padding-top:20px">
                                            <pagination :limit="limit" :data="adsdata" @pagination-change-page="getResults"></pagination>
                                        </div>
                                    </div>
                                </div>
                                <!-- /User Card -->
                            </div>
                        </div>
                    </section>
                    <div class="modal fade" id="editDepartment" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <h3 class="text-center mb-1" id="addNewCardTitle">Edit Department</h3>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body px-sm-5 mx-50 pb-5">
                                    <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                                        <div class="col-12">
                                            <label class="form-label" for="modalAddCardName">Department Name({{department_cons}})</label>
                                            <input type="text" v-model="ed_department_name" class="form-control" placeholder="Department name">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label" for="modalAddCardName">Company Name({{company_cons}})</label>
                                            <multiselect :show-labels="false" style="margin-right: 10px; font-size: 15px;" placeholder="Child Company" v-model="ed_company_name" :options="options">
                                            </multiselect>
                                        </div>
                                        <div class="col-12 text-center">
                                            <button type="submit" @click="update_department()" class="btn btn-primary me-1 mt-1" data-bs-dismiss="modal" aria-label="Close">Update</button>
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
            </div>
        </div>
    </div>
</template>

<script>

    import Multiselect from 'vue-multiselect'

    export default {
        data() {
            return {
                new_company_name: '',
                company_name1: '',
                keyword2: '',
                options: [],
                child_comlist: {},
                e_department_name: '',
                company_name: '',
                e_company_name: '',
                ed_company_name: '',
                department_cons: '',
                company_cons: '',

                limit: 10,
                errors: [],
                department_name: '',
                ed_department_name: '',
                dep_id: '',
                keyword1: '',
                adsdata: {},
            }
        },
        components: { Multiselect },
        watch: {
            keyword1(after, before) {
                this.getResults();
            },
            keyword2(after, before) {
                this.getResults();
            }
        },
        methods: {
            delete_department(id) {
                axios.get('delete_hr_department/' + id)
                    .then(data => {
                        if (data.data == 'Department deleted') {
                            this.$toastr.s("Department Deleted Successfully!", "Success!");
                            console.log(id);
                            const updatedIndex = this.adsdata.data.findIndex(item => item.ID === id);
                            console.log(updatedIndex)
            if (updatedIndex !== -1) {
         
                this.adsdata.data.splice(updatedIndex, 1);
                
            }
                        }
                    })
                    .catch(error => { });
            },
            update_department() {
                axios.post('./update_hr_department', {
                    dep_id: this.dep_id,
                    ed_department_name: this.ed_department_name,
                    ed_company_name: this.ed_company_name,
                    old_department:this.department_cons,
                    old_company:this.company_cons
                })
                    .then(data => {
                        if (data.data == 'Department exist') {
                            this.$toastr.e("Department already exist in " + this.ed_company_name + "!", "Caution!");
                        }
                        else if (data.data == 'Department updated') {
                            this.$toastr.s("Department updated Successfully!", "Congratulations!");
                           
                            const updatedIndex = this.adsdata.data.findIndex(item => item.ID === this.dep_id);
            if (updatedIndex !== -1) {
         
                this.adsdata.data[updatedIndex].Department = this.ed_department_name;  
                this.adsdata.data[updatedIndex].Company = this.ed_company_name;  

            
                this.dep_id = '';
                            this.ed_department_name = '';
                            this.ed_company_name = '';
                            this.department_cons = '';
                            this.company_cons = '';
             
                // Update other properties as needed
            }
                        }
                        else {
                            this.$toastr.s(data.data, "Error!");
                        }
                    })
                    .catch(error => this.error = error.responce.data.errors)
            },
            fetch_department(id) {
                axios.get('fetch_hr_department/' + id)
                    .then(responce => {
                        this.dep_id = responce.data[0].ID;
                        this.ed_department_name = responce.data[0].Department;
                        this.ed_company_name = responce.data[0].Company;
                        this.department_cons = responce.data[0].Department;
                        this.company_cons = responce.data[0].Company;
                    })
                    .catch(error => { });
            },
            getResults(page = 1) {
                axios.get('./department_byName?page=' + page, { params: { keyword1: this.keyword1, keyword2: this.keyword2 } })
                    .then(response => this.adsdata = response.data)
                    .catch(error => console.log(error));
            },
            submit_department() {
                this.errors = [];
                if (this.department_name == '' || (this.company_name != 'New company' && (this.company_name == '' || this.company_name == null)) || (this.company_name == 'New company' && this.new_company_name == '')) {
                    if (this.department_name == '') {
                        this.e_department_name = 'Enter department name';
                    }
                    else {
                        this.e_department_name = '';
                    }
                    if (this.company_name != 'New company' && (this.company_name == '' || this.company_name == null)) {
                        this.e_company_name = 'Select company name';
                    }
                    else if (this.company_name == 'New company' && this.new_company_name == '') {
                        this.e_company_name = 'Enter company name';
                    }
                    else {
                        this.e_company_name = '';
                    }
                }
                else {
                    this.e_department_name = '';
                    this.e_company_name = '';
                    if (this.company_name == 'New company') {
                        this.company_name1 = this.new_company_name;
                    }
                    else {
                        this.company_name1 = this.company_name;
                    }
                    axios.post('./submit_hr_department', {
                        department_name: this.department_name,

                        company_name: this.company_name1,
                    })
                        .then(data => {
                            if (data.data.message == 'Already Exist') {
                                this.$toastr.e("Department already exist in " + this.company_name1 + "!", "Caution!");
                            }
                            else if (data.data.message == 'Department added') {
                                this.$apihelpers.fetchDepartment();
                                this.$toastr.s("Department added successfully", "Congratulations");
                                this.department_name = '';
                                this.company_name = '';
                                this.company_name1 = '';
                                this.new_company_name = '';
                              
                                this.adsdata.data.unshift(data.data.data);
                            }
                            else {
                                this.$toastr.e(data.data, "Error!");
                            }
                        })
                        .catch(error => this.error = error.response.data.errors)
                }
            },
            reset() {
                this.department_name = '';
                this.company_name = '';
                this.company_name1 = '';
                this.new_company_name = '';
            },
            clear_search() {
                this.keyword1 = '';
                this.keyword2 = '';
                this.getResults();
            },
            deactive(id) {
                axios.get('./disable_department/' + id)
                    .then((response) => {
                        this.$toastr.s('Department has been disabled!', "Success!");
                        const updatedIndex = this.adsdata.data.findIndex(item => item.ID === id);
            if (updatedIndex !== -1) {
         
                this.adsdata.data[updatedIndex].Status =  "Disabled";
              

             
                // Update other properties as needed
            }
                   
                    })
                    .catch(error => console.log(error));
            },
            active(id) {
                axios.get('./active_department/' + id)
                    .then((response) => {
                    
                        this.$toastr.s('Department has been activated!', "Success!");
                        const updatedIndex = this.adsdata.data.findIndex(item => item.ID === id);
            if (updatedIndex !== -1) {
         
                this.adsdata.data[updatedIndex].Status =  "Active";
              

             
                // Update other properties as needed
            }
                    })
                    .catch(error => console.log(error));
            },
        },
        mounted() {
            this.getResults();

            axios.get('overall_child_companies_emp')
                .then(response => {
                    this.child_comlist = response.data
                    this.options = [];

                    var $this = this;
                    for (var i = 0; i < $this.child_comlist.length; i++) {
                        this.options.push($this.child_comlist[i].Company);
                    }
                    this.options.push('New company');
                })
        }
    }
</script>
