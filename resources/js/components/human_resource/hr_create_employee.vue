<template>
    <div>
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
                                Add New Employee
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
                                        <!--                                        <div class="col-12 col-sm-6 mb-1">-->
                                        <!--                                            <img v-if="url" :src="url" id="account-upload-img"-->
                                        <!--                                                 class="uploadedAvatar rounded me-50" alt="profile image"-->
                                        <!--                                                 style="width:155px;height:180px">-->
                                        <!--                                            <img v-else src="public/app-assets/images/portrait/small/profile.jpg"-->
                                        <!--                                                 id="account-upload-img" class="uploadedAvatar rounded me-50"-->
                                        <!--                                                 alt="profile image">-->
                                        <!--                                            &lt;!&ndash; upload and reset button &ndash;&gt;-->
                                        <!--                                            <div class="d-flex align-items-end mt-75 ms-1">-->
                                        <!--                                                <div>-->
                                        <!--                                                    <input type="file" id="image_file" :v-model="image_file"-->
                                        <!--                                                           name="image_file" @change="onFileChange" accept="image/*"-->
                                        <!--                                                           class="input-file">-->
                                        <!--                                                    <button type="button" @click="clear_image()" id="account-reset"-->
                                        <!--                                                            class="btn btn-sm btn-outline-secondary mb-75 waves-effect">-->
                                        <!--                                                        Clear-->
                                        <!--                                                    </button>-->
                                        <!--                                                    <p class="mb-0">Add profile image(png, jpg, jpeg. ) </p>-->
                                        <!--                                                    <p v-if="fileSize">File size: {{ fileSize }} bytes</p>-->
                                        <!--                                                </div>-->
                                        <!--                                            </div>-->
                                        <!--                                            &lt;!&ndash;/ upload and reset button &ndash;&gt;-->
                                        <!--                                        </div>-->
                                        <!--                                        <span style="color: #d93025" v-if="!this.url">{{ e_url }}</span>-->
                                        <!--/ header section -->
                                        <!-- form -->
                                        <div class="row">
                                            <div class="col-12 col-sm-12 mb-1">
                                                <img v-if="url" :src="url" id="account-upload-img"
                                                    class="uploadedAvatar rounded me-50" alt="profile image"
                                                    style="width:155px;height:180px">
                                                <img v-else src="public/app-assets/images/portrait/small/profile.jpg"
                                                    id="account-upload-img" class="uploadedAvatar rounded me-50"
                                                    alt="profile image">
                                                <!-- upload and reset button -->
                                                <div class="col-12 col-sm-6 mb-1">
                                                    <div>
                                                        <input type="file" id="image_file" :v-model="image_file"
                                                            name="image_file" @change="onFileChange" accept="image/*"
                                                            class="input-file">
                                                        <button type="button" @click="clear_image()" id="account-reset"
                                                            class="btn btn-sm btn-outline-secondary mb-75 waves-effect">
                                                            Clear
                                                        </button>
                                                        <p class="mb-0">Add profile image(png, jpg, jpeg. ) </p>
                                                        <p v-if="fileSize">File size: {{ fileSize }} bytes</p>
                                                    </div>
                                                </div>
                                                <!--/ upload and reset button -->
                                            </div>
                                            <span style="color: #d93025" v-if="!this.url">{{ e_url }}</span>

                                            <div class="col-12 col-sm-6 mb-1">
                                                <label class="form-label" for="accountFirstName">Full Name</label>
                                                <label style="color: #d93025">*</label>
                                                <input type="text" class="form-control" id="accountFirstName"
                                                    v-model="full_name" placeholder="Full Name Here">
                                                <span style="color: #d93025" v-if="full_name == ''">{{ e_full_name
                                                    }}</span>
                                            </div>
                                            <div class="col-12 col-sm-6 mb-1">
                                                <label class="form-label" for="accountLastName">Father's Name</label>
                                                <label style="color: #d93025">*</label>
                                                <input type="text" class="form-control" id="accountLastName"
                                                    v-model="father_name" placeholder="Father's Name Here">
                                                <span style="color: #d93025" v-if="father_name == ''">{{ e_father_name
                                                    }}</span>
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
                                                    <span style="color: #d93025" v-if="gender == ''">{{ e_gender
                                                        }}</span>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-3 mb-1">
                                                <label class="form-label">Martial Status</label>
                                                <label style="color: #d93025">*</label>
                                                <multiselect :show-labels="false" style="margin-right: 10px;"
                                                    placeholder="Select Status" v-model="m_status" :options="options2">
                                                </multiselect>
                                                <span style="color: #d93025" v-if="m_status == ''">{{ e_m_status
                                                    }}</span>
                                            </div>
                                            <div class="col-12 col-sm-6 mb-1">
                                                <label class="form-label">Blood Group</label>
                                                <multiselect :show-labels="false" style="margin-right: 10px;"
                                                    placeholder="Select Group" v-model="blood_group" :options="options">
                                                </multiselect>
                                            </div>
                                            <div class="col-12 col-sm-6 mb-1">
                                                <label class="form-label" for="accountEmail">Email</label>
                                                <input type="email" class="form-control" id="accountEmail"
                                                    v-model="email" placeholder="abc@gmail.com">
                                                <span style="color: #d93025" v-if="!validEmail(email)">{{ e_email
                                                    }}</span>
                                            </div>

                                            <div class="col-12 col-sm-3 mb-1">
                                                <label class="form-label" for="accountOrganization">CNIC No.</label>
                                                <label style="color: #d93025">*</label>
                                                <masked-input class="form-control account-number-mask"
                                                    mask="11111-1111111-1" v-model="cnic"
                                                    placeholder="00000-0000000-0" />
                                                <span style="color: #d93025" v-if="cnic == ''">{{ e_cnic }}</span>
                                            </div>
                                            <div class="col-12 col-sm-3 mb-1">
                                                <label class="form-label" for="accountOrganization">CNIC Expiry</label>
                                                <label style="color: #d93025">*</label>
                                                <input type="date" class="form-control" v-model="cnic_expiry">
                                                <span style="color: #d93025" v-if="cnic_expiry == ''">{{ e_cnic_expiry
                                                    }}</span>
                                            </div>
                                            <div class="col-12 col-sm-3 mb-1">
                                                <label class="form-label" for="accountPhoneNumber">Personal
                                                    Number</label>
                                                <label style="color: #d93025">*</label>
                                                <masked-input class="form-control account-number-mask"
                                                    v-model="phone_number" mask="0311-1111111"
                                                    placeholder="Phone Number Here" />
                                                <span style="color: #d93025" v-if="phone_number == ''">{{ e_phone_number
                                                    }}</span>
                                            </div>
                                            <div class="col-12 col-sm-3 mb-1">
                                                <label class="form-label" for="accountPhoneNumber">Date of Birth</label>
                                                <label style="color: #d93025">*</label>
                                                <input type="date" class="form-control account-number-mask"
                                                    v-model="dob">
                                                <span style="color: #d93025" v-if="dob == ''">{{ e_dob }}</span>
                                            </div>

                                            <div class="col-12 col-sm-3 mb-1">
                                                <label class="form-label">Religion</label>
                                                <label style="color: #d93025">*</label>
                                                <multiselect :show-labels="false" style=" font-size: 12px;"
                                                    placeholder="Select Religion" class="multiselect" v-model="religion"
                                                    :options="options1">
                                                </multiselect>
                                                <span style="color: #d93025" v-if="religion == ''">{{ e_religion
                                                    }}</span>
                                            </div>
                                            <div class="col-12 col-sm-3 mb-1">
                                                <label class="form-label" for="accountPhoneNumber">Emergency
                                                    Number</label>
                                                <label style="color: #d93025">*</label>
                                                <masked-input class="form-control account-number-mask"
                                                    mask="0311-1111111" v-model="phone_number2"
                                                    placeholder="Phone Number Here" />
                                                <span style="color: #d93025" v-if="phone_number2 == ''">{{
                                                    e_phone_number2
                                                    }}</span>
                                            </div>
                                            <div class="col-12 col-sm-6 mb-1">
                                                <label class="form-label" for="accountPhoneNumber">Relationship</label>
                                                <label style="color: #d93025">*</label>
                                                <input type="text" class="form-control account-number-mask"
                                                    id="accountPhoneNumber" v-model="relation"
                                                    placeholder="Contact Number Relationship">
                                                <span style="color: #d93025" v-if="relation == ''">{{ e_relation
                                                    }}</span>
                                            </div>
                                            <div class="col-12 col-sm-3 mb-1">
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
                                                <label class="form-label" for="cityInput">City</label>
                                                <label style="color: #d93025">*</label>
                                                <multiselect :show-labels="false" style="margin-right: 10px;"
                                                    placeholder="City Name Here" v-model="city" :options="options3">
                                                </multiselect>
                                                <span style="color: #d93025" v-if="!this.city">{{ e_city }}</span>
                                            </div>
                                            <div class="col-12 col-sm-12 mb-1">
                                                <label class="form-label" for="accountAddress">Address</label>
                                                <label style="color: #d93025">*</label>
                                                <input type="text" class="form-control" v-model="address"
                                                    placeholder="Your Address">
                                                <span style="color: #d93025" v-if="address == ''">{{ e_address }}</span>
                                            </div>

                                        </div>
                                        <!--/ form -->
                                    </div>
                                </form>
                                <div class="col-12" style="text-align:center">
                                    <button :disabled="disabled" @click="submit_employee()" type="button"
                                        class="btn btn-primary mt-1 me-1 waves-effect waves-float waves-light">Add
                                        employee
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
import { ref } from 'vue';
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
            url: null,
            e_url: '',
            image_file: '',
            image: '',
            cnic_expiry: '',
            e_cnic_expiry: '',

            full_name: '',
            e_full_name: '',

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
            options: ["A+", "A-", "B+", "B-", "AB+", "AB-", "O+", "O-"],
            options1: ["Islam", "Christan", "Other"],
            options2: ["Single", "Married"],
            options3: [],
            religion: '',
            e_religion: '',

            address: '',
            e_address: '',

            city: '',

            relation: '',
            e_relation: '',

            image_path: '',
            fileSize: null,
            // cities: {},
            countries: [], // Country options
            cities: [], // City options
            selectedCountry: '', // Selected country
            e_country: "", // Error message for country
            e_city: "",
            disabled: false,
            timeout: null,
        }
    },
    methods: {
        validEmail: function (email) {
            var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        },
        onFileChange(e) {
            let files = e.target.files;
            if (!files || files.length === 0) {
                console.warn("No file selected.");
                return;
            }
            const file = files[0];
            this.image = file; // Store the file
            this.url = URL.createObjectURL(file); // Create a preview URL
            this.fileSize = file.size; // Store the file size
        },
        // onFileChange(e) {
        //     let files = e.target.files || e.dataTransfer.files;
        //     const file = files[0];
        //     this.image = files[0];
        //     this.url = URL.createObjectURL(file);
        //     const fileSize = file.size;
        //     this.fileSize = fileSize;
        // },
        submit_form(e) {
            const formData = new FormData();
            formData.append('image_file', this.image, this.image.name);
            axios.post('./test_image/submit', formData, {}).then((response) => {
                console.log("response in creater employee iss", response.data);

                this.image_path = response.data;
                alert(this.image_path);
            })
                .catch(function (err) {
                    console.log(err)
                });
        },
        submit_employee() {
            this.disabled = true;
            if (![this.url, this.full_name, this.father_name, this.gender, this.m_status, this.cnic, this.cnic_expiry, this.phone_number, this.relation, this.address, this.city, this.selectedCountry].every(Boolean)) {
                this.timeout = setTimeout(() => {
                    this.disabled = false;
                }, 5000);
                // show error messsage if any field in missing
                function setErrorMessage(variable, errorMessage) {
                    return !variable ? errorMessage : '';
                }

                this.e_full_name = setErrorMessage(this.full_name, 'Full name is required');
                this.e_url = setErrorMessage(this.url, 'Profile Image is required');
                this.e_father_name = setErrorMessage(this.father_name, "Father's name is required");
                this.e_gender = setErrorMessage(this.gender, 'Select your gender');
                this.e_m_status = setErrorMessage(this.m_status, 'Select marital status');
                this.e_cnic = setErrorMessage(this.cnic, 'CNIC required');
                this.e_cnic_expiry = setErrorMessage(this.cnic_expiry, 'CNIC expiry date is required');
                this.e_phone_number = setErrorMessage(this.phone_number, 'Phone number required!');
                this.e_dob = setErrorMessage(this.dob, 'Date of birth required');
                this.e_religion = setErrorMessage(this.religion, 'Select religion');
                this.e_phone_number2 = setErrorMessage(this.phone_number2, 'Emergency phone number required');
                this.e_relation = setErrorMessage(this.relation, 'Enter relationship');
                this.e_address = setErrorMessage(this.address, 'Address is required');
                this.e_country = setErrorMessage(this.selectedCountry, 'Select the country');
                this.e_city = setErrorMessage(this.city, 'City is required');

                this.$toastr.e("Please fill required fields!", "Caution!");
            } else {
                const formData = new FormData();
                formData.append('image_file', this.image, this.image.name);
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

                console.log(formData); //testing


                axios.post('create_employee', formData)
                    .then(data => {
                        console.log(
                            "I am hereeeee"
                        );

                        if (data.data == 'Employee added') {
                            this.timeout = setTimeout(() => {
                                this.disabled = false;
                            }, 5000);
                            this.$toastr.s("New Employee Added Successfully!", "Congratulations!");
                            this.image_file = '';
                            this.cnic_expiry = '';
                            this.full_name = '';
                            this.father_name = '';
                            this.gender = '';
                            this.m_status = '';
                            this.blood_group = '';
                            this.email = '';
                            this.company_email = '';
                            this.cnic = '';
                            this.phone_number = '';
                            this.phone_number2 = '';
                            this.dob = '';
                            this.religion = '';
                            this.address = '';
                            this.city = '';
                            this.selectedCountry = '';
                            this.relation = '';
                            this.image_path = '';
                            this.clear_image();
                        } else {
                            this.$toastr.e("Employee not added!", "Caution!");
                        }

                    })
                    .catch(error => this.error = error.response.data.errors)
            }


        },


        clear_image() {
            this.url = null;
            this.image_file = '';
            this.image = '';
        },
    },
    mounted() {

        axios.get('overall_cities')
            .then(response => {
                this.cities = response.data
                this.options3 = [];
                var $this = this;
                for (var i = 0; i < $this.cities.length; i++) {
                    this.options3.push($this.cities[i].city_name);
                }
            })
            .catch(error => {
            });

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


    }
}

</script>

<style scoped>
.multiselect {
    height: 20px;
    font-size: 12px;
}
</style>
