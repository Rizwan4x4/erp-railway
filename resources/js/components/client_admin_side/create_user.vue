<template>
    <div>
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                </div>
                <div class="content-body">
                    <!-- Validation -->
                    <section class="bs-validation">
                        <div class="row">
                            <!-- Bootstrap Validation -->
                            <div class="col-md-12 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Create New User</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="mb-1 col-md-4">
                                                <label class="form-label" for="first-name">First Name <span style="color:red">*</span></label>
                                                <input required="" type="text" v-model="first_name" id="first-name" class="form-control" placeholder="First Name" />
                                                <span style="color: #DB4437; font-size: 11px;" v-if="this.first_name == ''">{{ e_first_name }}</span>
                                            </div>
                                            <div class="mb-1 col-md-4">
                                                <label class="form-label" for="last-name">Last Name <span style="color:red">*</span></label>
                                                <input id="last-name" v-model="last_name" required="" type="text" class="form-control" placeholder="Last Name">
                                                <span style="color: #DB4437; font-size: 11px;" v-if="this.last_name ==''">{{ e_last_name }}</span>
                                            </div>
                                            <div class="col-md-4 mb-1">
                                                <label class="form-label" for="pin-code">Employee Code (Name)<span style="color:red">*</span></label>
                                                <multiselect @input="fetch_emp_detail(emp_code)" style="margin-right: 10px;" :show-labels="false" v-model="emp_code" :options="options"></multiselect>
                                                <span style="color: #DB4437; font-size: 11px;" v-if="emp_code == ''">{{ e_emp_code }}</span>
                                            </div>
                                            <div class="mb-1 col-md-4">
                                                <label class="form-label" for="town-city">Department <span style="color:red">*</span></label>
                                                <multiselect style="margin-right: 10px;" :show-labels="false" v-model="department" :options="options1"></multiselect>
                                                <span style="color: #DB4437; font-size: 11px;" v-if="department ==''">{{ e_department }}</span>
                                            </div>
                                            <div class="mb-1 col-md-4">
                                                <label class="form-label" for="country">Designation<span style="color:red">*</span></label>
                                                <multiselect style="margin-right: 10px;" :show-labels="false" v-model="designation" :options="options2"></multiselect>
                                                <span style="color: #DB4437; font-size: 11px;" v-if="designation ==''">{{ e_designation }}</span>
                                            </div>
                                            <div class="col-md-4 mb-1">
                                                <label class="form-label" for="email">Email address<span style="color:red">*</span></label>
                                                <input type="email" name="email" v-model="email" id="email" class="form-control" placeholder="abcdef.xyz@email.com" aria-label="john.doe" />
                                                <span style="color: #DB4437; font-size: 11px;" v-if="email == '' || !this.validEmail(this.email)">{{ e_email }}</span>
                                            </div>
                                            <div class="col-md-4 mb-1">
                                                <label class="form-label" for="password">Password <span style="color:red">*</span></label>
                                                <div class="input-group input-group-merge form-password-toggle">
                                                    <input v-bind:type="[showPassword ? 'text' : 'password']" type="password" name="password" v-model="password" id="password" class="form-control" placeholder="min 8 characters" />
                                                    <span v-if="showPassword" @click="showPassword = !showPassword" class="input-group-text cursor-pointer">
                                                        <i class="fa-regular fa-eye-slash"></i>
                                                    </span>
                                                    <span title="Show Password" v-else class="input-group-text cursor-pointer" @click="showPassword = !showPassword">
                                                        <i class="fa-regular fa-eye"></i>
                                                    </span>
                                                </div>
                                                <span style="color: #DB4437; font-size: 11px;" v-if="password == ''">{{ e_password }}</span>
                                            </div>
                                            <div class="mb-1 col-md-4">
                                                <label class="form-label" for="town-city">Location <span style="color:red">*</span></label>
                                                <multiselect style="margin-right: 10px;" :show-labels="false" v-model="location" :options="options3"></multiselect>
                                                <span style="color: #DB4437; font-size: 11px;" v-if="location == ''">{{ e_location }}</span>
                                            </div>
                                            <div class="col-4 mb-1">
                                                <label class="form-label" for="home-address">Home Address </label>
                                                <textarea v-model="address" class="form-control" rows="2" placeholder="Home Address"></textarea>
                                            </div>
                                            <div class="col-4 mb-1">
                                                <label class="form-label" for="home-address">Roles </label>
                                                <multiselect v-model="roles" :multiple="true"  :options="userrolenames"  group-label="select" :group-select="true">

</multiselect>
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end mt-5">
                                            <button :disabled="disabled" @click="delay()" class="btn btn-success btn-next">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- /Validation -->
                </div>
            </div>
        </div>
        <!-- END: Content-->
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect';
    export default {
        data() {
            return {
                emp_code1: '',
                options: [],
                options1: [],
                options2: [],
                userrolenames:'',
                options3: [],
                showPassword: false,
                disabled: false,
                timeout: null,
                designations: {},
                locations: {},
                empcode: {},
                departments: {},
                emp_code: '',
                last_name: '',
                first_name: '',

                address: '',
                location: '',
                designation: '',
                department: '',
                password: '',
                email: '',
                roles:'',
                e_emp_code: '',
                e_last_name: '',
                e_first_name: '',
                e_email: '',
                e_password: '',
                e_address: '',
                e_location: '',
                e_designation: '',
                e_department: '',
            }
        },
        components: {
            Multiselect
        },
        methods: {
            fetch_emp_detail(id) {
                var s_url = id.split(' (');
                this.emp_code1 = s_url[0];

                axios.get('employee_dtl_bycode/' + this.emp_code1)
                    .then(responce => {
                        this.first_name = responce.data[0].Name;
                        this.department = responce.data[0].Department;
                        this.designation = responce.data[0].Designation;
                        this.location = responce.data[0].PostingCity;
                        this.address = responce.data[0].Address;
                        this.email = responce.data[0].Email;
                    })
                    .catch(error => { });
            },
            delay() {
                this.disabled = true
                this.timeout = setTimeout(() => {
                    this.disabled = false
                }, 5000)
                this.submit_data();
            },
            validEmail: function (email) {
                var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            },
            submit_data() {
                if (this.last_name == '' || this.first_name == '' || this.location == '' || this.emp_code == '' || this.designation == '' || this.department == '' || this.password == '' || !this.validEmail(this.email) || this.email == '' || this.password == '') {
                    if (this.emp_code == '') {
                        this.e_emp_code = 'Select employee Code';
                    }
                    else {
                        this.e_emp_code = '';
                    }
                    if (this.first_name == '') {
                        this.e_first_name = 'Enter first name';
                    }
                    else {
                        this.e_first_name = '';
                    }
                    if (this.last_name == '') {
                        this.e_last_name = 'Enter last Name';
                    }

                    if (this.email == '') {
                        this.e_email = 'Please enter email address';
                    }
                    else if (!this.validEmail(this.email)) {
                        this.e_email = 'Please enter valid email address';
                    }
                    if (this.location == '') {
                        this.e_location = 'Please enter office location';
                    }
                    if (this.password == '') {
                        this.e_password = 'Please enter Password';
                    }
                    if (this.designation == '') {
                        this.e_designation = 'Please select designation';
                    }
                    if (this.department == '') {
                        this.e_department = 'Please select department';
                    }
                    this.$toastr.e("Please fill required fields!", "Caution!");
                }
                else {
                    this.e_emp_code = '';
                    this.e_first_name = '';
                    this.e_location = '';
                    this.e_email = '';
                    this.e_designation = '';
                    this.e_department = '';
                    this.e_password = '';
                    axios.post('./create_user', {

                        address: this.address,
                        password: this.password,
                        email: this.email,
                        emp_code: this.emp_code1,
                        last_name: this.last_name,
                        first_name: this.first_name,
                        location: this.location,
                        designation: this.designation,
                        department: this.department,
                        roleName: this.roles,
                    })
                        .then(data => {
                            if (data.data == 'User Already Exists In Your Company Database!') {
                                this.$toastr.e("User Already Exists", "Please Try Other One!");
                            }
                            else if (data.data == 'User Created Successfully!') {
                                this.$toastr.s("User Created Successfully", "Congratulations!");
                                this.emp_code1 = '';
                                this.address = '';
                                this.password = '';
                                this.email = '';
                                this.last_name = '';
                                this.first_name = '';
                                this.location = '';
                                this.designation = '';
                                this.department = '';
                                this.roles='';
                            }
                            else {
                                this.$toastr.s(data.data, "Error!");

                            }
                        })
                }

            },
            async fetchLocations() {
                try {
                    this.locations = await this.$helpers.checkLocal('overall_location');
                    this.options3 = [];
                    var $this = this;
                    for (var i = 0; i < $this.locations.length; i++) {
                        this.options3.push($this.locations[i].location_name);
                    }
                    // Process the data or perform additional actions here
                } catch (error) {
                    console.error(error);
                    // Additional error handling if needed
                }
            },
            async fetchDesignation() {
                try {
                    this.designations = await this.$helpers.checkLocal('overall_designation');
                    this.options2 = [];

                    var $this = this;
                    for (var i = 0; i < $this.designations.length; i++) {
                        this.options2.push($this.designations[i].designation_name);
                    }
                    // Process the data or perform additional actions here
                } catch (error) {
                    console.error(error);
                    // Additional error handling if needed
                }
            },
        },
        mounted() {
            axios.get('./showuserrole')
            .then(response => {
                // Handle the response data here
                console.log(response.data);
                this.rolesdata = response.data;
                this.userrolenames = response.data.roles.map(role => role.name);
console.log('username',this.userrolenames); // Assuming 'data' is the key in your JSON response
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
            this.fetchLocations();
            this.fetchDesignation();
            axios.get('overall_department')
                .then(response => {
                    this.departments = response.data;
                    this.options1 = [];

                    var $this = this;
                    for (var i = 0; i < $this.departments.length; i++) {
                        this.options1.push($this.departments[i].department_name);
                    }
                })
                .catch(error => { });

            axios.get('registered_empcode')
                .then(response => {
                    this.empcode = response.data;
                    this.options = [];

                    var $this = this;
                    for (var i = 0; i < $this.empcode.length; i++) {
                        this.options.push($this.empcode[i].EmployeeCode + ' (' + $this.empcode[i].Name + ')');
                    }
                })
                .catch(error => { });
        }
    }
</script>
