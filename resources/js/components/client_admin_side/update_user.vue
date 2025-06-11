<template>
    <div>
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow-tem-change"></div>
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
                                        <h4 class="card-title">Update User</h4>
                                    </div>
                                    <div class="card-body">
                                        <p v-if="errors.length">
                                            <b>Please correct the following error(s):</b>
                                            <ul>
                                                <li v-for="error in errors" style="color:red;">{{ error }}</li>
                                            </ul>
                                        </p>
                                        <div class="row">
                                            <div class="mb-1 col-md-6">
                                                <label class="form-label" for="first-name">First Name <span
                                                    style="color:red">*</span></label>
                                                <input required="" type="text" v-model="first_name" id="first-name"
                                                       class="form-control" placeholder="Please Type First Name Here"/>

                                            </div>
                                            <div class="mb-1 col-md-6">
                                                <label class="form-label" for="last-name">Last Name <span
                                                    style="color:red">*</span></label>
                                                <input id="last-name" v-model="last_name" required="" type="text"
                                                       class="form-control">
                                            </div>
                                            <div class="mb-1 col-md-6">
                                                <label class="form-label" for="town-city">Department <span
                                                    style="color:red">*</span></label>
                                                <select v-model="department" class="form-select" id="basicSelect">
                                                    <option value="">Select department</option>
                                                    <option v-for='departments1 in departments'
                                                            :value='departments1.department_name'>
                                                        {{ departments1.department_name }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-1">
                                                <label class="form-label" for="pin-code">Employee Code</label>
                                                <select v-model="emp_code" class="form-select" id="basicSelect">
                                                    <option value="">Select Employee Code</option>
                                                    <option v-for='empcode1 in empcode' :value='empcode1.EmployeeCode'>
                                                        {{ empcode1.EmployeeCode }}
                                                    </option>
                                                </select>

                                            </div>
                                            <div class="col-md-6 mb-1">
                                                <label class="form-label" for="email">Email <span
                                                    style="color:red">*</span></label>
                                                <input readonly="" type="email" name="email" v-model="email" id="email"
                                                       class="form-control" placeholder="john.doe@email.com"
                                                       aria-label="john.doe"/>

                                            </div>


                                            <div class="col-md-6 mb-1">
                                                <label class="form-label" for="password">Password <span
                                                    style="color:red">*</span></label>
                                                <div class="input-group input-group-merge form-password-toggle">
                                                    <input type="password" name="password" v-model="password"
                                                           id="password" class="form-control"
                                                           placeholder="min 8 characters"/>
                                                    <span class="input-group-text cursor-pointer"><i
                                                        data-feather="eye"></i></span>
                                                </div>
                                            </div>


                                            <div class="mb-1 col-md-6">
                                                <label class="form-label" for="country">Designation</label>
                                                <select value="" v-model="designation" class="form-select"
                                                        id="basicSelect">
                                                    <option value="">Select Designation</option>
                                                    <option v-for='designation1 in designations'
                                                            :value='designation1.designation_name'>
                                                        {{ designation1.designation_name }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="mb-1 col-md-6">
                                                <label class="form-label" for="town-city">Location <span
                                                    style="color:red">*</span></label>
                                                <select v-model="location" class="form-select" id="basicSelect">
                                                    <option value="">Select Location</option>
                                                    <option v-for='locations1 in locations'
                                                            :value='locations1.location_name'>
                                                        {{ locations1.location_name }}
                                                    </option>
                                                </select>
                                            </div>

                                            <div class="col-12 mb-1">
                                                <label class="form-label" for="home-address">Home Address <span
                                                    style="color:red">*</span></label>
                                                <input required="" type="text" name="address" v-model="address"
                                                       id="home-address" class="form-control" placeholder="Address"/>
                                            </div>


                                        </div>
                                        <div class="col-12 d-flex justify-content-end mt-4 ">
                                            <button @click="submit_data()" class="btn btn-success btn-next">
                                                <span class="align-middle d-sm-inline-block d-none">Submit</span>
                                            </button>
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
export default {
    data() {
        return {
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
            errors: [],
        }
    },
    methods: {
        validEmail: function (email) {
            var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        },
        submit_data() {
            this.errors = [];
            if (this.emp_code == '') {
                this.errors.push('Employee Code Required!');
            }
            if (this.first_name == '') {
                this.errors.push('First Name Required!');
            }
            if (this.last_name == '') {
                this.errors.push('Last Name Required!');
            }

            if (this.email == '') {
                this.errors.push('Email Id required!');
            } else if (!this.validEmail(this.email)) {
                this.errors.push('Valid email required!');
            }

            if (this.location == '') {
                this.errors.push('Office Location Required!');
            }
            if (this.designation == '') {
                this.errors.push('Designation Required!');
            }
            if (this.department == '') {
                this.errors.push('Department Required!');
            }
            if (this.last_name == '' || this.first_name == '' || this.location == '' || this.emp_code == '' || this.designation == '' || this.department == '' || this.password == '' || this.email == '') {
                this.$toastr.e("Firsty complete all Compulsory fields", "Important Detail Missing!");
            } else {
                axios.post('./update_user/' + this.$route.params.id, {
                    address: this.address,
                    password: this.password,
                    email: this.email,
                    emp_code: this.emp_code,
                    last_name: this.last_name,
                    first_name: this.first_name,
                    location: this.location,
                    designation: this.designation,
                    department: this.department,

                })
                    .then(data => {
                        if (data.data == 'User Already Exists In Your Company Database!') {
                            this.$toastr.e("User Already Exists", "Please Try Other One!");
                        } else if (data.data == 'User Created Successfully!') {
                            this.$toastr.s("User Updated Successfully", "Congratulations!");

                        }


                    })
                    .catch(error => this.error = error.response.data.errors)

            }


        },
    },
    async mounted() {
        this.locations = await this.$helpers.checkLocal('overall_location');
        this.designations  = await this.$helpers.checkLocal('overall_designation');

        axios.get('overall_department')
            .then(response => this.departments = response.data)
            .catch(error => {
            });
        axios.get('overall_empcode')
            .then(response => this.empcode = response.data)
            .catch(error => {
            });

        axios.get('getuser_detail/' + this.$route.params.id)
            .then(data => {

                this.emp_code = data.data[0].emp_code;
                this.last_name = data.data[0].last_name;
                this.first_name = data.data[0].first_name;
                this.address = data.data[0].user_address;
                this.location = data.data[0].ofc_location;
                this.designation = data.data[0].user_role;
                this.department = data.data[0].department;
                this.password = data.data[0].user_password;
                this.email = data.data[0].email;
            })


    }
}
</script>
