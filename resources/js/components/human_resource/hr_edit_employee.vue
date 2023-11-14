<template>
    <div>
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><router-link to="/hr/dashboard" style="text-decoration: none;">Dashboard</router-link>
                                    </li>
                                    <li class="breadcrumb-item">
                                    <router-link to="/hr/employees_detail" style="text-decoration: none;">Employees Detail</router-link>
                                    </li>
                                    <li class="breadcrumb-item active">Edit Employee
                                    </li>
                                </ol>
                </div>
                </div>
                <div class="content-body">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Create New Employee</h4>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-pills nav-fill">
                                <li class="nav-item">
                                    <a class="nav-link  active" id="home-tab-fill" data-bs-toggle="pill" href="#home-fill" aria-expanded="true">Personal Detail</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="about-tab-fill" data-bs-toggle="pill" href="#about-fill" aria-expanded="false">Qualification</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="about-tab-fill" data-bs-toggle="pill" href="#work-fill" aria-expanded="false">Work Experience</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="about-tab-fill" data-bs-toggle="pill" href="#employment-fill" aria-expanded="false">Employment Detail</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane  active" id="home-fill" aria-labelledby="home-tab-fill" aria-expanded="true">
                                    <div class="card">
                                        <div class="card-header border-bottom">
                                            <h4 class="card-title">Profile Details</h4>
                                        </div>
                                        <div class="card-body py-2 my-25">
                                            <!-- header section -->
                                            <div class="d-flex">
                                                <a href="#" class="me-25">
                                                    <img src="public/app-assets/images/portrait/small/avatar-s-11.jpg" id="account-upload-img" class="uploadedAvatar rounded me-50" alt="profile image" height="100" width="100">
                                                </a>
                                                <!-- upload and reset button -->
                                                <div class="d-flex align-items-end mt-75 ms-1">
                                                    <div>
                                                        <label for="account-upload" class="btn btn-sm btn-primary mb-75 me-75 waves-effect waves-float waves-light">Upload</label>
                                                        <input type="file" id="account-upload" hidden="" accept="image/*">
                                                        <button type="button" id="account-reset" class="btn btn-sm btn-outline-secondary mb-75 waves-effect">Reset</button>
                                                        <p class="mb-0">Allowed file types: png, jpg, jpeg.</p>
                                                    </div>
                                                </div>
                                                <!--/ upload and reset button -->
                                            </div>
                                            <!--/ header section -->
                                            <!-- form -->
                                            <div class="row">
                                                <div class="col-12 col-sm-6 mb-1">
                                                    <label class="form-label" for="accountFirstName">Full Name</label>
                                                    <input type="text" class="form-control" id="accountFirstName" v-model="full_name" placeholder="Full Name Here">
                                                </div>
                                                <div class="col-12 col-sm-6 mb-1">
                                                    <label class="form-label" for="accountLastName">Father's Name</label>
                                     <input type="text" class="form-control" id="accountLastName" v-model="father_name" placeholder="Father's Name Here">

                                                </div>
                                                <div class="col-12 col-sm-6 mb-1">
                                                    <div class="mb-1">
                                                        <label class="form-label" for="basicSelect">Gender</label>
                                                        <div class="demo-inline-spacing">
                                                            <div class="form-check form-check-inline" style="margin-top:0px">
                                                                <input class="form-check-input" type="radio" v-model="gender" name="inlineRadioOptions" id="inlineRadio1" value="Male" checked="">
                                                                <label class="form-check-label" for="inlineRadio1">Male</label>
                                                            </div>
                                                            <div class="form-check form-check-inline" style="margin-top:0px">
                                                                <input class="form-check-input" type="radio" v-model="gender" name="inlineRadioOptions" id="inlineRadio2" value="Female">
                                                                <label class="form-check-label" for="inlineRadio2">Female</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-6 mb-1">
                                                    <label class="form-label">Martial Status</label>
                                                    <select class="form-select" v-model="blood_group">
                                                        <option value="">Select Status</option>
                                                        <option value="Single">Single</option>
                                                        <option value="Married">Married</option>
                                                        
                                                    </select>
                                                </div>
                                                <div class="col-12 col-sm-6 mb-1">
                                                    <label class="form-label">Blood Group</label>
                                                    <select class="form-select" v-model="blood_group">
                                                        <option value="">Select Group</option>
                                                        <option value="A+">A+</option>
                                                        <option value="B+">B+</option>
                                                        <option value="AB+">AB+</option>
                                                        <option value="AB-">AB-</option>
                                                        <option value="O+">O+</option>
                                                        <option value="O-">O-</option>
                                                    </select>
                                                </div>
                                                <div class="col-12 col-sm-6 mb-1">
                                                    <label class="form-label" for="accountEmail">Email</label>
                                                    <input type="email" class="form-control" id="accountEmail" v-model="email" placeholder="abc@gmail.com">
                                                </div>
                                                <div class="col-12 col-sm-6 mb-1">
                                                    <label class="form-label" for="accountEmail">Company Email</label>
                                                    <input type="email" class="form-control" v-model="company_email" placeholder="abc@gmail.com">
                                                </div>
                                                <div class="col-12 col-sm-6 mb-1">
                                                    <label class="form-label" for="accountOrganization">CNIC No.</label>
                                                   
                                                    <masked-input class="form-control account-number-mask" mask="11111-1111111-1" v-model="cnic" placeholder="00000-0000000-0" />
                                                </div>
                                                <div class="col-12 col-sm-6 mb-1">
                                                    <label class="form-label" for="accountOrganization">CNIC Expiry</label>
                                                    <input type="date" class="form-control" v-model="cnic_expiry">
                                                </div>
                                                <div class="col-12 col-sm-6 mb-1">
                                                    <label class="form-label" for="accountPhoneNumber">Personal Number</label>
                                                   
                                                    <masked-input class="form-control account-number-mask" v-model="phone_number"mask="0092-111 -1111111" placeholder="Phone Number Here" />
                                                </div>
                                                <div class="col-12 col-sm-6 mb-1">
                                                    <label class="form-label" for="accountPhoneNumber">Date of Birth</label>
                                                    <input type="date" class="form-control account-number-mask" v-model="dob">
                                                </div>
                                                <div class="col-12 col-sm-6 mb-1">
                                                    <label class="form-label" for="accountPhoneNumber">Date of Joining</label>
                                                    <input type="date" class="form-control account-number-mask" v-model="doj">
                                                </div>
                                                <div class="col-12 col-sm-6 mb-1">
                                                    <label class="form-label">Religion</label>
                                                    <select class="form-select" v-model="religion">
                                                        <option value="">Select Religion</option>
                                                        <option value="Islam">Islam</option>
                                                        <option value="Christan">Christan</option>
                                                        <option value="Other">Other</option>
                                                    </select>
                                                </div>
                                                <div class="col-12 col-sm-6 mb-1">
                                                    <label class="form-label" for="accountPhoneNumber">Emergency Number</label>
                                                   
                                                     <masked-input class="form-control account-number-mask"  mask="0092-111 -1111111" v-model="phone_number2" placeholder="Phone Number Here" />
                                                </div>
                                                <div class="col-12 col-sm-6 mb-1">
                                                    <label class="form-label" for="accountPhoneNumber">Relationship</label>
                                                    <input type="text" class="form-control account-number-mask" id="accountPhoneNumber" v-model="relation" placeholder="Contact Number Relationship">
                                                </div>
                                                <div class="col-12 col-sm-6 mb-1">
                                                    <label class="form-label" for="accountState">City Name</label>
                                                    <input type="text" class="form-control" id="accountState" v-model="city" placeholder="City Name Here">
                                                </div>
                                                <div class="col-12 col-sm-12 mb-1">
                                                    <label class="form-label" for="accountAddress">Address</label>
                                                    <input type="text" class="form-control" v-model="address" placeholder="Your Address">
                                                </div>
                                                <div class="col-12" style="text-align:center">
                                                    <button type="submit" class="btn btn-primary mt-1 me-1 waves-effect waves-float waves-light">Save Employee Profile</button>
                                                </div>
                                            </div>
                                            <!--/ form -->
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="about-fill" role="tabpanel" aria-labelledby="about-tab-fill" aria-expanded="false">
                                    <p>
                                        <div class="row">
                                            <!-- Invoice repeater -->
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h4 class="card-title">Add Education Detail</h4>
                                                        <div data-repeater-create="" class="btn btn-primary" v-on:click="add_xz_repeater()">
                                                            <span>
                                                                <i class="fa fas-plus"></i>
                                                                <span>Add</span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="form-group xz_form  row animated slideInDown" v-for="count in counter" :id="count" style="border: 2px solid lightgrey;padding: 10px;margin-top:5px;margin-bottom:5px">
<div data-repeater-list="" class="col-lg-12">
<div data-repeater-item="" class="form-group row align-items-center">
<div class="col-xs-1 delete_btn" style="border-radius:14px;">
    <div data-repeater-delete="" class="btn " style="margin-right: 6px;" v-on:click="delete_xz_form(count)">
        <span style="padding-top: 14px;padding-left: 7px;">
            <i class="fas fa-trash-alt"></i>
        </span>
    </div>
</div>
<slot>
    <div class="col-md-3">
        <div class="form__group">
            <div class="form__label">
                <label class="label">Degree Type</label>
            </div>
            <div class="form_control">
                <select id="UserPlan" class="form-select mb-md-0 mb-2">
                    <option value="">Degree Type </option>
                    <option value="">Diploma</option>
                    <option value="">Certificate </option>
                    <option value="">Degree</option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form__group">
            <div class="form__label">
                <label class="label">Degree Name</label>
            </div>
            <div class="form_control">
                <input type="text" class="form-control">
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form__group">
            <div class="form__label">
                <label class="label">Institute Name</label>
            </div>
            <div class="form_control">
                <input type="text" class="form-control">
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form__group">
            <div class="form__label">
                <label class="label">Passing Year</label>
            </div>
            <div class="form_control">
                <input type="number" class="form-control">
            </div>
        </div>
    </div>
</slot>
</div>
</div>
</div>
<div class="m-form__group form-group row adding" style="margin-top: 20px;">
<div class="col-lg-4">
</div>
</div>
</div>
</div>
</div>
<!-- /Invoice repeater -->
</div>
</p>
                                </div>
                                <div class="tab-pane" id="work-fill" role="tabpanel" aria-labelledby="about-tab-fill" aria-expanded="false">
                                    <p>
                                        <div class="row">
                                            <!-- Invoice repeater -->
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add Experience Detail</h4>
                    <div data-repeater-create="" class="btn btn-primary" v-on:click="add_xz_repeater1()">
                        <span>
                            <i class="fa fas-plus"></i>
                            <span>Add</span>
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group xz_form  row animated slideInDown" v-for="count1 in counter1" :id="count1" style="border: 2px solid lightgrey;padding: 10px;margin-top:5px;margin-bottom:5px">
                        <div data-repeater-list="" class="col-lg-12">
                            <div data-repeater-item="" class="form-group row align-items-center">
                                <div class="col-xs-1 delete_btn" style="border-radius:14px;">
                                    <div data-repeater-delete="" class="btn " style="margin-right: 6px;" v-on:click="delete_xz_form1(count1)">
                                        <span style="padding-top: 14px;padding-left: 7px;">
                                            <i class="fas fa-trash-alt"></i>
                                        </span>
                                    </div>
                                </div>
                                <slot>
                                    <div class="col-md-2">
                                        <div class="form__group">
                                            <div class="form__label">
                                            <label class="label">Degree Type</label>
                                            </div>
                                            <div class="form_control">
                                                <select id="UserPlan" class="form-select mb-md-0 mb-2">
                                                    <option value="">Job Position</option>
                                                    <option value="">Diploma</option>
                                                    <option value="">Certificate </option>
                                                    <option value="">Degree</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form__group">
                                            <div class="form__label">
                                                <label class="label">Company Name</label>
                                            </div>
                                            <div class="form_control">
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form__group">
                                            <div class="form__label">
                                                <label class="label">Starting Date</label>
                                            </div>
                                            <div class="form_control">
                                                <input type="date" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form__group">
                                            <div class="form__label">
                                                <label class="label">Closing Date Year</label>
                                            </div>
                                            <div class="form_control">
                                                <input type="date" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form__group">
                                            <div class="form__label">
                                                <label class="label">Reference</label>
                                            </div>
                                            <div class="form_control">
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </slot>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
                                            <!-- /Invoice repeater -->
                                        </div>
                                    </p>
                                </div>
                                <div class="tab-pane" id="employment-fill" role="tabpanel" aria-labelledby="about-tab-fill" aria-expanded="false">
                                    <p >

 <div class="row" style="border: 1px solid lightgrey;padding-top:20px;padding-bottom:10px">
 <div class=" col-12 col-sm-12 mb-1card-header"><h4 class="card-title">Employement Detail</h4></div>
    <div class="col-md-4 col-sm-6 mb-1">
        <label class="form-label">Reporting To</label>
        <select class="form-select" v-model="blood_group">
            <option value="">Select Employee</option>
        </select>
    </div>
    <div class="col-md-4 col-sm-6 mb-1">
        <label class="form-label" for="accountPhoneNumber">Second Reporting</label>
        <select class="form-select" v-model="emp_status">
            <option value="">Select Employee</option>
        </select>
    </div>
    <div class="col-md-4 col-sm-6 mb-1">
        <label class="form-label">Job Shift</label>
        <select class="form-select" v-model="blood_group">
            <option value="">Select Shift</option>
        </select>
    </div>
     <div class="col-md-4 col-sm-6 mb-1">
        <label class="form-label">Work Location</label>
        <select class="form-select" v-model="blood_group">
            <option value="">Select Location</option>
        </select>
    </div>
   
    <div class="col-md-4 col-sm-6 mb-1">
        <label class="form-label" for="accountEmail">Date Of Joining</label>
        <input type="date" class="form-control" id="accountEmail" v-model="doj" placeholder="">
    </div>
    <div class="col-md-4 col-sm-6 mb-1">
        <label class="form-label" for="accountEmail">Salary</label>
        <input type="number" class="form-control" v-model="emp_salary" placeholder="abc@gmail.com">
    </div>
    <div class="col-md-4 col-sm-6 mb-1">
        <label class="form-label" for="accountOrganization">Stipend</label>
        <input type="number" class="form-control" v-model="emp_stipend">
    </div>
    <div class="col-md-4 col-sm-6 mb-1">
        <label class="form-label" for="accountPhoneNumber">Employee Status</label>
        <select class="form-select" v-model="emp_status">
            <option value="">Select Status</option>
            <option value="Suspended">Suspended</option>
            <option value="Terminate">Terminate</option>
            <option value="Resigned">Resigned</option>
            <option value="Registered">Registered</option>
        </select>
    </div>
    <div class="col-md-4 col-sm-6 mb-1">
        <label class="form-label" for="accountPhoneNumber">Job Status</label>
        <select class="form-select" v-model="emp_job_status">
            <option value="">Select Status</option>
            <option value="Probation">Probation</option>
            <option value="Parmanent">Parmanent</option>
        </select>
    </div>
    <div class="col-md-4 col-sm-6 mb-1">
        <label class="form-label" for="accountPhoneNumber">Probation End</label>
        <input type="date" class="form-control account-number-mask" v-model="emp_pro_end">
    </div>
    <div class="col-md-4 col-sm-12 mb-1">
        <label class="form-label">Job Description</label>
        <textarea class="form-control" v-model="job_description"></textarea>
    </div>
   

</div>

<div class="row" style="border: 1px solid lightgrey;margin-top:20px;padding-top:20px;padding-bottom:20px">
<div class=" col-12 col-sm-12 mb-1card-header"><h4 class="card-title">Add Designation And Department</h4></div>
    <div class="col-md-4 col-sm-6 mb-1">
        <label class="form-label">Child Company</label>
        <select class="form-select" v-model="blood_group">
            <option value="">Child Company</option>
        </select>
    </div>
    <div class="col-md-4 col-sm-6 mb-1">
        <label class="form-label" for="accountPhoneNumber">Department</label>
        <select class="form-select" v-model="emp_status">
            <option value="">Select Department</option>
        </select>
    </div>
    
    
    
    <div class="col-md-4 col-sm-6 mb-1">
        <label class="form-label" for="accountPhoneNumber">Designation</label>
        <select class="form-select" v-model="emp_status">
            <option value="">Select Status</option>
            <option value="Suspended">Suspended</option>
            <option value="Terminate">Terminate</option>
            <option value="Resigned">Resigned</option>
            <option value="Registered">Registered</option>
        </select>
    </div>
   
   
   
   

</div>


<div class="row" style="border: 1px solid lightgrey;margin-top:20px;padding-top:20px;padding-bottom:20px">
<div class=" col-12 col-sm-12 mb-1card-header"><h4 class="card-title">Attendance and ESS Access</h4></div>
    <div class="col-md-12 col-sm-6 mb-1">
        <label class="form-label" style="font-size:14px;padding-right:20px">Notifications:</label>
       <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="inlineCheckbox2" >
                                            <label class="form-check-label" for="inlineCheckbox2">Send eMail,SMS notification of HR Activities</label>
                                        </div>
    </div>
         <div class="col-md-12 col-sm-6 mb-1">
        <label class="form-label" style="font-size:14px;padding-right:20px" for="accountPhoneNumber">Permissions:</label>
         <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" v-model="att_check" id="inlineCheckbox1" >
                                            <label class="form-check-label" for="inlineCheckbox1">Allow to other employees  Punch In & Out from the employee's Application</label>

                                         </div>
                                </div>
                                <div class="col-md-12 col-sm-6 mb-1">

                                         <label class="form-label" style="font-size:14px;padding-right:20px" for="accountPhoneNumber">Portal Access:</label>
                                         <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" v-model="login_check" id="inlineCheckbox1" >
                                            <label class="form-check-label" for="inlineCheckbox1">Login to the  Application, Employee can login with their eMail and Password to the Application</label>
                                         </div>
                                          <div v-if="login_check==true" class="row">
                                               <div class="col-md-6 col-sm-6 mb-1">
                                                <label class="form-label" for="accountEmail">User Email</label>
                                                    <input type="email" class="form-control" id="accountEmail" v-model="user_email" placeholder="abc@gmail.com">
                                                </div>
                                                 <div class="col-md-6 col-sm-6 mb-1">
                                                 <label class="form-label" for="accountpassword">User Password</label>
                                                    <input type="password" class="form-control" id="password" v-model="user_password" >
                                                </div>
                                            </div>
    </div>
    
    
    <div class="col-12" style="text-align:center">
        <button type="submit" class="btn btn-primary mt-1 me-1 waves-effect waves-float waves-light">Save Employee Profile</button>
    </div>

</div>
                                    </p>
                                </div>
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
export default {
components: {
  MaskedInput
},
    data() {
        return {
            cnic_expiry:'',
            counter: 1,
            counter1: 1,
            degree_type: '',
            degree_name: '',
            degree_year: '',
            degree_institute: '',
            full_name: '',
            father_name: '',
            gender: '',
            blood_group: '',
            email: '',
            company_email: '',
            cnic: '',
            phone_number: '',
            phone_number2: '',
            dob: '',
            doj: '',
            religion: '',
            address: '',
            city: '',
            relation: '',
            login_check:'',

        }
    },
    methods: {
        add_xz_repeater() {
            this.counter++;
            // let itm  = document.getElementsByClassName("xz_form")[0];
            // let cln = itm.cloneNode(true);
            // cln.id = this.counter;
            // document.getElementsByClassName("container")[0].insertBefore(cln,document.getElementsByClassName("adding")[0]);
        },
        delete_xz_form(id) {
            const r = confirm("Are you sure?");
            if (r == true) {
                let node = document.getElementById(id);
                node.remove();
            }
        },
         add_xz_repeater1() {
            this.counter1++;
            // let itm  = document.getElementsByClassName("xz_form")[0];
            // let cln = itm.cloneNode(true);
            // cln.id = this.counter;
            // document.getElementsByClassName("container")[0].insertBefore(cln,document.getElementsByClassName("adding")[0]);
        },
        delete_xz_form1(id) {
            const r = confirm("Are you sure?");
            if (r == true) {
                let node = document.getElementById(id);
                node.remove();
            }
        },

    },
    mounted() {


    }
}

</script>
