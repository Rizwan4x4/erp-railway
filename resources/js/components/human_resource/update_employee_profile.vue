<template>
    <div >
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <router-link to="/hr/dashboard" style="text-decoration: none;">Dashboard</router-link>
                            </li>
                            <li class="breadcrumb-item">
                                <router-link to="/hr/employees_detail" style="text-decoration: none;">Employees Detail
                                </router-link>
                            </li>
                            <li class="breadcrumb-item active">
                                Update Employee
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="content-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="card">
                                <form method="post" enctype="multipart/form-data">
                                    <div class="card-header border-bottom">
                                        <h4 class="card-title">Profile Details</h4>
                                    </div>
                                    <div class="card-body py-2 my-25">
                                        <!-- header section -->
                                        <div class="d-flex">
                                            <span v-for="product in emp_data">
                                                <img v-if="url" :src="url" id="account-upload-img"
                                                     class="uploadedAvatar rounded me-50" alt="profile image"
                                                     style="width:155px;height:180px">
                                                <img v-else-if="product.Photo!=''" v-bind:src="`public/images/profile_images/${product.Photo}`" id="account-upload-img" class="uploadedAvatar rounded me-50" alt="profile image" style="width:155px;height:180px">
                                                <img v-else src="public/app-assets/images/portrait/small/profile.jpg" id="account-upload-img" class="uploadedAvatar rounded me-50" alt="profile image">
                                            </span>
                                            <!-- upload and reset button -->
                                            <div class="d-flex align-items-end mt-75 ms-1">
                                                <div>
                                                    <input type="file" id="image_file" :v-model="image_file"
                                                           name="image_file" @change="onFileChange" accept="image/*"
                                                           class="input-file">
                                                    <button type="button" @click="clear_image()" id="account-reset"
                                                            class="btn btn-sm btn-outline-secondary mb-75 waves-effect">
                                                        Clear
                                                    </button>
                                                    <p class="mb-0">Add profile image(.png, .jpg, .jpeg) </p>
                                                    <p v-if="fileSize">File size: {{fileSize.toLocaleString()}} bytes</p>
                                                </div>
                                            </div>
                                            <!--/ upload and reset button -->
                                        </div>
                                        <!--/ header section -->
                                        <!-- form -->
                                        <div class="row">
                                            <div class="col-12 col-sm-6 mb-1">
                                                <label class="form-label" for="accountFirstName">Full Name</label>
                                                <label style="color: #d93025">*</label>
                                                <input type="text" class="form-control" id="accountFirstName"
                                                       v-model="full_name" placeholder="Full Name Here">
                                                <span style="color: #d93025"
                                                      v-if="full_name==''">{{ e_full_name }}</span>
                                            </div>
                                            <div class="col-12 col-sm-6 mb-1">
                                                <label class="form-label" for="accountLastName">Father's Name</label>
                                                <label style="color: #d93025">*</label>
                                                <input type="text" class="form-control" id="accountLastName"
                                                       v-model="father_name" placeholder="Father's Name Here">
                                                <span style="color: #d93025"
                                                      v-if="father_name==''">{{ e_father_name }}</span>
                                            </div>
                                            <div class="col-12 col-sm-3 mb-1">
                                                <div class="mb-1">
                                                    <label class="form-label" for="basicSelect">Gender</label>
                                                    <label style="color: #d93025">*</label>
                                                    <div class="demo-inline-spacing">
                                                        <div class="form-check form-check-inline"
                                                             style="margin-top:0px">
                                                            <input class="form-check-input" type="radio"
                                                                   v-model="gender" name="inlineRadioOptions"
                                                                   id="inlineRadio1" value="Male" checked="">
                                                            <label class="form-check-label"
                                                                   for="inlineRadio1">Male</label>
                                                        </div>
                                                        <div class="form-check form-check-inline"
                                                             style="margin-top:0px">
                                                            <input class="form-check-input" type="radio"
                                                                   v-model="gender" name="inlineRadioOptions"
                                                                   id="inlineRadio2" value="Female">
                                                            <label class="form-check-label"
                                                                   for="inlineRadio2">Female</label>
                                                        </div>
                                                    </div>
                                                    <span style="color: #d93025" v-if="gender==''">{{ e_gender }}</span>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-3 mb-1">
                                                <label class="form-label">Martial Status</label>
                                                <label style="color: #d93025">*</label>
                                                <select class="form-select" v-model="m_status">
                                                    <option value="" selected>Select Status</option>
                                                    <option value="Single">Single</option>
                                                    <option value="Married">Married</option>
                                                </select>
<!--                                                <multiselect :show-labels="false" style="margin-right: 10px;"-->
<!--                                                             placeholder="Select Status"-->
<!--                                                             v-model="m_status" :options="options2">-->
<!--                                                </multiselect>-->
                                                <span style="color: #d93025" v-if="m_status==''">{{ e_m_status }}</span>
                                            </div>
                                            <div class="col-12 col-sm-6 mb-1">
                                                <label class="form-label">Blood Group</label>
                                                <multiselect :show-labels="false" style="margin-right: 10px;"
                                                             placeholder="Select Group"
                                                             v-model="blood_group" :options="options">
                                                </multiselect>
                                            </div>
                                            <div class="col-12 col-sm-6 mb-1">
                                                <label class="form-label" for="accountEmail">Email</label>
                                                <input type="email" class="form-control" id="accountEmail"
                                                       v-model="email" placeholder="abc@gmail.com">
                                                <span style="color: #d93025"
                                                      v-if="!validEmail(email)">{{ e_email }}</span>
                                            </div>

                                            <div class="col-12 col-sm-3 mb-1">
                                                <label class="form-label" for="accountOrganization">CNIC No.</label>
                                                <label style="color: #d93025">*</label>
                                                <masked-input class="form-control account-number-mask"
                                                              mask="11111-1111111-1" v-model="cnic"
                                                              placeholder="00000-0000000-0"/>
                                                <span style="color: #d93025" v-if="cnic==''">{{ e_cnic }}</span>
                                            </div>
                                            <div class="col-12 col-sm-3 mb-1">
                                                <label class="form-label" for="accountOrganization">CNIC Expiry</label>
                                                <label style="color: #d93025">*</label>
                                                <input type="date" class="form-control" v-model="cnic_expiry">
                                                <span style="color: #d93025"
                                                      v-if="cnic_expiry==''">{{ e_cnic_expiry }}</span>
                                            </div>
                                            <div class="col-12 col-sm-3 mb-1">
                                                <label class="form-label" for="accountPhoneNumber">Personal
                                                    Number</label>
                                                <label style="color: #d93025">*</label>
                                                <masked-input class="form-control account-number-mask"
                                                              v-model="phone_number" mask="0311-1111111"
                                                              placeholder="Phone Number Here"/>
                                                <span style="color: #d93025"
                                                      v-if="phone_number==''">{{ e_phone_number }}</span>
                                            </div>
                                            <div class="col-12 col-sm-3 mb-1">
                                                <label class="form-label" for="accountPhoneNumber">Date of Birth</label>
                                                <label style="color: #d93025">*</label>
                                                <input type="date" class="form-control account-number-mask"
                                                       v-model="dob">
                                                <span style="color: #d93025" v-if="dob==''">{{ e_dob }}</span>
                                            </div>
                                            <div class="col-12 col-sm-3 mb-1">
                                                <label class="form-label" for="accountPhoneNumber">Emergency Number ({{relation}})</label>
                                                <label style="color: #d93025">*</label>
                                                <masked-input class="form-control account-number-mask" mask="0311-1111111" v-model="phone_number2" placeholder="Phone Number Here"/>
                                                <span style="color: #d93025" v-if="phone_number2==''">{{ e_phone_number2 }}</span>
                                            </div>
                                            <div class="col-12 col-sm-3 mb-1">
                                                <label class="form-label" for="accountPhoneNumber">Relationship</label>
                                                <label style="color: #d93025">*</label>
                                                <input type="text" class="form-control account-number-mask"
                                                       id="accountPhoneNumber" v-model="relation"
                                                       placeholder="Contact Number Relationship">
                                                <span style="color: #d93025" v-if="relation==''">{{ e_relation }}</span>
                                            </div>
                                            <div class="col-12 col-sm-6 mb-1">
                                                <label class="form-label" for="countrySelect">Country</label>
                                                <label style="color: #d93025">*</label>
                                                <multiselect :show-labels="false"
                                                             style="margin-right: 10px; font-size: 15px;"
                                                             placeholder="Select Country" v-model="selectedCountry"
                                                             :options="countries"></multiselect>
                                                <span style="color: #d93025" v-if="!selectedCountry">{{
                                                        e_country
                                                    }}</span>
                                            </div>
                                            <div class="col-12 col-sm-3 mb-1">
                                                <label class="form-label">Religion</label>
                                                <label style="color: #d93025">*</label>
                                                <multiselect :show-labels="false" style=" font-size: 12px;"
                                                             placeholder="Select Religion" class="multiselect"
                                                             v-model="religion" :options="options1">
                                                </multiselect>
                                                <span style="color: #d93025" v-if="religion==''">{{ e_religion }}</span>
                                            </div>
                                            <div class="col-12 col-sm-3 mb-1">
                                                <label class="form-label" for="accountState">City Name</label>
                                                <label style="color: #d93025">*</label>
                                                <input type="text" class="form-control" id="accountState" v-model="city"
                                                       placeholder="City Name Here">
                                                <span style="color: #d93025" v-if="city==''">{{ e_city }}</span>
                                            </div>
                                            <div class="col-12 col-sm-12 mb-1">
                                                <label class="form-label" for="accountAddress">Address</label>
                                                <label style="color: #d93025">*</label>
                                                <input type="text" class="form-control" v-model="address"
                                                       placeholder="Your Address">
                                                <span style="color: #d93025" v-if="address==''">{{ e_address }}</span>
                                            </div>

                                        </div>
                                        <!--/ form -->

                                    </div>
                                </form>
                                <div class="col-12" style="text-align:center">
                                    <button :disabled="disabled" @click="delay()" type="button"
                                            class="btn btn-primary mt-1 me-1 waves-effect waves-float waves-light">
                                        Update Employee Profile
                                    </button>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Content-->
    </div>
</template>
<script>
import MaskedInput from 'vue-masked-input'
import Multiselect from 'vue-multiselect'

const image = "";
export default {
    components: {
        MaskedInput,
        Multiselect
    },
    data() {
        return {
            options: ["A+", "A-", "B+", "B-", "AB+", "AB-", "O+", "O-"],
            options1: ["Islam", "Christian", "Other"],
            options2: ["Single", "Married"],
            options3: [],
            id: this.$route.params.id,
            url: null,
            image_file: '',
            image,
            cnic_expiry: '',
            e_cnic_expiry: '',

            full_name: '',
            e_full_name: '',
            countries: [], // Country options
            cities: [], // City options
            selectedCountry: '', // Selected country
            selectedCity: [], // Selected cities
            e_country: "", // Error message for country
            father_name: '',
            e_father_name: '',
            gender: '',
            e_gender: '',
            m_status: '',
            e_m_status: '',

            blood_group: '',
            email: '',
            e_email: '',

            company_email: '',
            cnic: '',
            e_cnic: '',

            phone_number: '',
            e_phone_number: '',

            phone_number2: '',
            e_phone_number2: '',
            dob: '',
            e_dob: '',


            religion: '',
            e_religion: '',

            address: '',
            e_address: '',

            city: '',
            e_city: '',

            relation: '',
            e_relation: '',

            image_path: '',
            emp_data: {},

            disabled: false,
            timeout: null,
            fileSize: null,
        }
    },
    methods: {
        delay() {
            this.disabled = true
            this.timeout = setTimeout(() => {
                this.disabled = false
            }, 5000)
            this.submit_employee()
        },
        validEmail: function (email) {
            var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        },
        onFileChange(e) {
            let files = e.target.files || e.dataTransfer.files;
            if (!files.length) {
            }

            const file = files[0];
            this.image = files[0];
            this.url = URL.createObjectURL(file);
            const fileSize = file.size;
            this.fileSize = fileSize;
        },
        submit_form(e) {
            const formData = new FormData();
            formData.append('image_file', this.image, this.image.name);
            axios.post('./test_image/submit', formData, {}).then((response) => {
                this.image_path = response.data;
                alert(this.image_path);
            })
                .catch(function (err) {
                    console.log(err)
                });
        },
        submit_employee() {
            if (this.full_name == '' || this.father_name == '' || this.gender == '' || this.m_status == '' ||
                this.cnic == '' || this.cnic_expiry == '' || this.phone_number == '' ||
                this.relation == '' || this.address == '' || this.city == '' || this.selectedCountry == '') {
                if (this.full_name == '') {
                    this.e_full_name = 'Full name is required'
                } else {
                    this.e_full_name = ''
                }
                if (this.father_name == '') {
                    this.e_father_name = 'Father\'s name is required'
                } else {
                    this.e_father_name = ''
                }
                if (this.gender == '') {
                    this.e_gender = 'Select your gender'
                } else {
                    this.e_gender = ''
                }
                if (this.m_status == '') {
                    this.e_m_status = 'Select marital status'
                } else {

                    this.e_m_status = ''
                }
                if (this.cnic == '') {
                    this.e_cnic = 'CNIC required'
                } else {
                    this.e_cnic = ''
                }
                if (this.cnic_expiry == '') {
                    this.e_cnic_expiry = 'CNIC expiry date is required'
                } else {
                    this.e_cnic_expiry = ''
                }

                if (this.phone_number == '') {
                    this.e_phone_number = 'Phone number required!'
                } else {
                    this.e_phone_number = ''
                }
                if (this.dob == '') {
                    this.e_dob = 'Date of birth required'
                } else {
                    this.e_dob = ''
                }

                if (this.religion == '') {
                    this.e_religion = 'Select religion'
                } else {
                    this.e_religion = ''
                }
                if (this.phone_number2 == '') {
                    this.e_phone_number2 = 'Emergency phone number required'
                } else {
                    this.e_phone_number2 = ''
                }
                if (this.relation == '') {
                    this.e_relation = 'Enter relationship'
                } else {
                    this.e_relation = ''
                }
                if (this.address == '') {
                    this.e_address = 'Address is required'
                } else {
                    this.e_address = ''
                }
                if (this.city == '') {
                    this.e_city = 'Address is required'
                }
                if (this.selectedCountry == '') {
                    this.e_country = 'country is required'
                } else {
                    this.e_city = ''
                }
            } else {

                const formData = new FormData();
                if (this.url == null) {
                } else {
                    formData.append('image_file', this.image, this.image.name);
                }
                formData.append('id', this.id);
                formData.append('full_name', this.full_name);
                formData.append('father_name', this.father_name);
                formData.append('gender', this.gender);
                formData.append('blood_group', this.blood_group);
                formData.append('dob', this.dob);
                formData.append('email', this.email);
                formData.append('cnic', this.cnic);
                formData.append('phone_number', this.phone_number);
                formData.append('phone_number2', this.phone_number2);
                formData.append('religion', this.religion);
                formData.append('address', this.address);
                formData.append('city', this.city);
                formData.append('Country', this.selectedCountry);
                formData.append('m_status', this.m_status);
                formData.append('relation', this.relation);
                formData.append('cnic_expiry', this.cnic_expiry);


                axios.post('./update_employee', formData)
                    .then(data => {
                        this.$toastr.s("Update Employee  Successfully.Please Complete The Profile", "Congratulations");

                    })
                    .catch(error => this.error = error.response.data.errors)
            }
        },
        clear_image() {
            this.url = null;
            this.image_file = '';
            this.image = '';
        }
    },
    mounted() {
 

        axios.get('https://countriesnow.space/api/v0.1/countries')
            .then(response => {
                // Extract the country data from the API response
                const countryData = response.data.data;

                // Extract country names from the data
                const countries = countryData.map(country => country.country);

                // Update the data property
                this.countries = countries;
            })
            .catch(error => {
                console.error(error);
            });

        axios.get('getemployee_detail/' + this.$route.params.id)
            .then(data => {
                this.emp_data = data.data;

                this.cnic_expiry = data.data[0].CnicExpiry;
                this.full_name = data.data[0].Name;
                this.father_name = data.data[0].FatherHusband;
                this.gender = data.data[0].Gender;
                this.m_status = data.data[0].MaritalStatus;
                this.blood_group = data.data[0].BloodGroup;
                this.email = data.data[0].Email;

                this.cnic = data.data[0].CNIC;
                this.phone_number = data.data[0].Mobile;
                this.phone_number2 = data.data[0].Phone;
                this.dob = data.data[0].DOB;
                this.religion = data.data[0].Religion;
                this.address = data.data[0].Address;
                this.city = data.data[0].City;
                this.selectedCountry = data.data[0].Country;
                this.relation = data.data[0].Relation;
            })
    }
}

</script>
