<template>
    <div>
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow-tem-change"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                </div>
                <div class="content-body">
                    <div class="content-header row">
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <router-link to="/recruitment/recDashboard"
                                        style="text-decoration: none;">Dashboard</router-link>
                                </li>
                                <li class="breadcrumb-item active">
                                    Create Club
                                </li>
                            </ol>
                        </div>
                    </div>
                    <!--Search code-->
                    <div class="card-body ">
                        <h4 class="card-title">Search & Filter</h4>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Club Name</label>
                                <input type="text" v-model="search_club_name" class="form-control"
                                    placeholder="Club Name" />
                            </div>

                            <div class="col-md-3">
                                <div style="height:27px;"></div>
                                <button @click="search_club()" class="dt-button add-new btn btn-primary" tabindex="0"
                                    type="button"><span>Search</span></button>
                                <button @click="reset_filters()" class="dt-button add-new btn btn-secondary" tabindex="0"
                                    type="button">
                                    <span>Reset</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div style="margin-bottom:20px;"
                        class="d-flex justify-content-between align-items-center header-actions mx-2 row mt-75">
                        <div class="col-sm-12 col-lg-12 ps-xl-75 ps-0">
                            <div v-if="hasPermission('Admin Club Management Create Club AddNewClub')"  style="float:left;">
                                <router-link to="" class="dt-button add-new btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addclub" tabindex="0" type="button"><span>+ Add new
                                        Club</span></router-link>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <table class="user-list-table table">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:100px; text-align:center;">No</th>
                                    <th style="width:200px; text-align:center;">Club Name</th>
                                    <th style="width:200px; text-align:center;">Type</th>
                                    <th style="width:200px; text-align:center;">Employee fee</th>
                                    <th style="width:200px; text-align:center;">Resident fee</th>
                                    <th style="width:200px; text-align:center;">Outsider fee</th>
                                    <th style="width:200px; text-align:center;">status</th>
                                    <th style="width:200px; text-align:center;">Description</th>

                                    <th style="width:200px; text-align:center;">Action</th>

                                </tr>
                            </thead>

                            <tbody>
                                <tr v-if="foundClubData">
                                    <td style="vertical-align: middle; text-align: center;">1</td>
                                    <td style="vertical-align: middle; text-align: center;"><b>{{ foundClubData.Name }}</b></td>
                                    <td style="vertical-align: middle; text-align: center;">{{ foundClubData.Type }}</td>
                                    <td style="vertical-align: middle; text-align: center;">{{ foundClubData.Employee_fee }}</td>
                                    <td style="vertical-align: middle; text-align: center;">{{ foundClubData.Resident_fee }}</td>
                                    <td style="vertical-align: middle; text-align: center;">{{ foundClubData.Outsider_fee }}</td>
                                    <td v-if="foundClubData.status=='Active'" style="vertical-align: middle; text-align: center; color: green;"> {{ foundClubData.status }}</td>
                                    <td v-if="foundClubData.status=='Non active'" style="vertical-align: middle; text-align: center; color: red;"> {{ foundClubData.status }}</td>
                                    <td style="vertical-align: middle; text-align: center;">{{ foundClubData.Description }}
                                    </td>

                                    <td class="td-center">

                                        <a class="me-25" @click="editclub(c_data1.id)" data-bs-toggle="modal"
                                            data-bs-target="#PREQ_view">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a class="me-25" @click="delclub(c_data1.id)" data-bs-toggle="modal"
                                            data-bs-target="#Del_club">
                                            <i class="fas fa-trash" style="font-size: 20px;"></i>
                                        </a>
                                    </td>

                                </tr>
                                <tr v-else v-for="(c_data1, index) in club_data">
                                    <td style="vertical-align: middle; text-align: center;"> {{ index+1 }}</td>
                                    <td style="vertical-align: middle; text-align: center;"><b> {{ c_data1.Name }}</b></td>
                                    <td style="vertical-align: middle; text-align: center;"> {{ c_data1.Type }}</td>
                                    <td style="vertical-align: middle; text-align: center;"> {{ c_data1.Employee_fee }}</td>
                                    <td style="vertical-align: middle; text-align: center;"> {{ c_data1.Resident_fee }}</td>
                                    <td style="vertical-align: middle; text-align: center;"> {{ c_data1.Outsider_fee }}</td>
                                    <td v-if="c_data1.status=='Active'" style="vertical-align: middle; text-align: center; color: green;"> {{ c_data1.status }}</td>
                                    <td v-if="c_data1.status=='Non active'" style="vertical-align: middle; text-align: center; color: red;"> {{ c_data1.status }}</td>
                                    <td style="vertical-align: middle; text-align: center;"> {{ c_data1.Description }}</td>
                                    <td class="td-center">

                                        <a v-if="hasPermission('Admin Club Management Create Club EditClubDetails')" class="me-25" @click="editclub(c_data1.id)" data-bs-toggle="modal"
                                            data-bs-target="#PREQ_view">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a v-if="hasPermission('Admin Club Management Create Club DeleteClub')" class="me-25" @click="delclub(c_data1.id)" data-bs-toggle="modal"
                                            data-bs-target="#Del_club">
                                            <i class="fas fa-trash" style="font-size: 20px;"></i>


                                        </a>
                                    </td>
                                </tr>
                            </tbody>

                        </table>
                    </div>
                    <!-- Add Club model-->
                    <div class="modal fade" id="addclub" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <div class="text-center mb-2">
                                        <h1 class="mb-1">Add Club Details</h1>

                                    </div>
                                    <form id="editUserForm" class="row gy-1 pt-75" onsubmit="return false">
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Club Name</label>
                                            <span style="color: #DB4437; font-size: 11px;">*</span>
                                            <input type="text" v-model="club_name" class="form-control"
                                                placeholder="Enter Club full name" />
                                            <span style="color: #DB4437; font-size: 11px;" v-if="club_name == ''">{{
                                                name_error }}</span>
                                        </div>


                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Type</label>
                                            <span style="color: #DB4437; font-size: 11px;">*</span>

                                            <multiselect style="margin-right: 10px;" v-model="club_type"
                                                :show-labels="false" placeholder="Select" :options="options1">
                                            </multiselect>
                                            <span style="color: #DB4437; font-size: 11px;" v-if="club_type == ''">{{
                                                type_error }}</span>
                                        </div>
                                        <div></div>
                                        <!--  -->
                                        <div class="col-12 col-md-4">
                                            <label class="form-label">Fee for Employee</label>
                                            <span style="color: #DB4437; font-size: 11px;">*</span>
                                            <input type="number" v-model="employee_fee" class="form-control"
                                                placeholder="Enter Club Fee for Employee" />
                                            <span style="color: #DB4437; font-size: 11px;" v-if="employee_fee == ''">{{
                                            employee_fee_error }}</span>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label class="form-label">Fee for Resident</label>
                                            <span style="color: #DB4437; font-size: 11px;">*</span>
                                            <input type="number" v-model="Resident_fee" class="form-control"
                                                placeholder="Enter Club Fee for Resident" />
                                            <span style="color: #DB4437; font-size: 11px;" v-if="Resident_fee == ''">{{
                                                Resident_fee_error }}</span>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label class="form-label">Fee for Outsider</label>
                                            <span style="color: #DB4437; font-size: 11px;">*</span>
                                            <input type="number" v-model="Outsider_fee" class="form-control"
                                                placeholder="Enter Club Fee for Outsider" />
                                            <span style="color: #DB4437; font-size: 11px;" v-if="Outsider_fee == ''">{{
                                                Outsider_fee_error }}</span>
                                        </div>
                                        <!--  -->
                                        <div class="col-12">
                                            <label class="form-label">Description</label>

                                            <textarea style="max-height:150px;" v-model="description" class="form-control"
                                                rows="2" id="note"></textarea>
                                            <span style="color: #DB4437; font-size: 11px;" v-if="description == ''">{{
                                                des_error }}</span>
                                        </div>
                                        <div class="col-12 text-center mt-2 pt-50">
                                            <button :disabled="disabled" @click="delay()"
                                                class="btn btn-primary me-1">Add</button>
                                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                                aria-label="Close">
                                                Cancel
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / Add candidate model-->
                    <!-- edit club Modal -->
                    <div class="modal fade" id="PREQ_view" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <div class="text-center mb-2">
                                        <h1 class="mb-1">Edit Club Details</h1>

                                    </div>
                                    <form id="editUserForm" class="row gy-1 pt-75" onsubmit="return false">
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Club Name</label>
                                            <span style="color: #DB4437; font-size: 11px;">*</span>
                                            <input type="text" v-model="edit_club_name" class="form-control" />
                                            <span style="color: #DB4437; font-size: 11px;" v-if="edit_club_name == ''">{{
                                                edit_name_error }}</span>
                                        </div>


                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Type</label>
                                            <span style="color: #DB4437; font-size: 11px;">*</span>

                                            <multiselect style="margin-right: 10px;" v-model="edit_club_type"
                                                :show-labels="false" placeholder="Select" :options="options1">
                                            </multiselect>
                                            <span style="color: #DB4437; font-size: 11px;" v-if="edit_club_type == ''">{{
                                                edit_type_error }}</span>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Status</label>
                                            <span style="color: #DB4437; font-size: 11px;">*</span>

                                            <multiselect style="margin-right: 10px;" v-model="edit_club_status"
                                                :show-labels="false" placeholder="Select" :options="options2">
                                            </multiselect>
                                            <span style="color: #DB4437; font-size: 11px;" v-if="edit_club_status == ''">{{
                                                edit_status_error }}</span>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Fee for Employee</label>
                                            <span style="color: #DB4437; font-size: 11px;">*</span>
                                            <input type="number" v-model="edit_employee_fee" class="form-control"
                                                placeholder="Enter Club Fee for Employee" />
                                            <span style="color: #DB4437; font-size: 11px;" v-if="edit_employee_fee == ''">{{
                                            edit_employee_fee_error }}</span>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Fee for Resident</label>
                                            <span style="color: #DB4437; font-size: 11px;">*</span>
                                            <input type="number" v-model="edit_Resident_fee" class="form-control"
                                                placeholder="Enter Club Fee for Resident" />
                                            <span style="color: #DB4437; font-size: 11px;" v-if="edit_Resident_fee == ''">{{
                                                edit_Resident_fee_error }}</span>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Fee for Outsider</label>
                                            <span style="color: #DB4437; font-size: 11px;">*</span>
                                            <input type="number" v-model="edit_Outsider_fee" class="form-control"
                                                placeholder="Enter Club Fee for Outsider" />
                                            <span style="color: #DB4437; font-size: 11px;" v-if="edit_Outsider_fee == ''">{{
                                                edit_Outsider_fee_error }}</span>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Description</label>

                                            <textarea style="max-height:150px;" v-model="edit_club_desc"
                                                class="form-control" rows="2" id="note"></textarea>
                                            <span style="color: #DB4437; font-size: 11px;" v-if="edit_club_desc == ''">{{
                                                edit_des_error }}</span>
                                        </div>
                                        <div class="col-12 text-center mt-2 pt-50">
                                            <button :disabled="disabled" @click="update_club(club_id)"
                                                class="btn btn-primary me-1">Update</button>
                                            <button type="reset" id="cancelButton" class="btn btn-outline-secondary"
                                                data-bs-dismiss="modal" aria-label="Close">
                                                Cancel
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- edit club Modal -->
                    <!-- Delete Club Modal -->
                    <div class="modal fade" id="Del_club" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-md modal-dialog-centered modal-edit-user">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <div class="text-center mb-2">
                                        <h4 class="mb-1">Are you sure to delete this club?</h4>

                                    </div>
                                    <div class="col-12 text-center mt-2 pt-50">
                                        <button :disabled="disabled" @click="del_club(club_id_del)"
                                            class="btn btn-primary me-1" data-bs-dismiss="modal"
                                            aria-label="Close">Yes</button>
                                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            No
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- Delete Club Modal -->

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
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
            search_club_name: '',
            foundClubData: null,
            club_name: "",
            club_type: "",
            club_status: "Active",
            Outsider_fee:'',
            Resident_fee:'',
            employee_fee:'',
            description: "",
            club_data: [],
            edit_club_name: '',
            edit_club_type: '',
            edit_club_status: '',
            edit_Outsider_fee:'',
            edit_Resident_fee:'',
            edit_employee_fee:'',
            edit_club_desc: '',
            club_id: 0,
            club_id_del: 0,
            edit_name_error: "",
            name_error: "",
            employee_fee_error: "",
            Resident_fee_error: "",
            Outsider_fee_error: "",
            edit_employee_fee_error: "",
            edit_Resident_fee_error: "",
            edit_Outsider_fee_error: "",
            edit_des_error: "",
            edit_type_error: "",
            edit_status_error: "",


            type_error: "",
            des_error: "",
            options: [],
            options1: ["Building", "Sports", "General","Other"],
            options2: ["Active", "Non active"],
            s_post: '',
            s_name: '',
            s_address: '',


            s0: 0,
            s1: 1,
            s2: 2,
            s3: 3,
            s4: 4,
            s5: 5,





            disabled: false,
            timeout: null,

            disabled1: false,
            timeout1: null,

            disabled2: false,
            timeout2: null,
        }
    },
    methods: {
        get_all_club()
{
    axios.get('get_club_data').then(res => {
            this.club_data = res.data.data;

        })
            .catch(error => {
                console.error("Error during getting club data:", error);

            });
},




        editclub(id) {

            const foundClub = this.club_data.find((club) => club.id === id);


            if (foundClub) {
                this.edit_club_name = foundClub.Name;
                this.edit_club_type = foundClub.Type;
                this.edit_Outsider_fee = foundClub.Outsider_fee;
                this.edit_Resident_fee = foundClub.Resident_fee;
                this.edit_employee_fee = foundClub.Employee_fee;
                this.edit_club_desc = foundClub.Description;
                this.edit_club_status = foundClub.status;
                this.club_id = foundClub.id;
            } else {
                this.$toastr.e("Club don't Exists");
            }
        },
        delclub(id) {
            const foundClub_del = this.club_data.find((club) => club.id === id);
            if (foundClub_del) {
                this.club_id_del = foundClub_del.id;
            } else {
                this.$toastr.e("Club don't Exists");
            }
        },
        del_club(id) {
            axios.post('del_club', { id: id }).then(data => {
                if (data.status === 200) {
                    this.$toastr.s("Club Deleted successfully!", "Congratulations!");
                    const index = this.club_data.findIndex(club => club.id === id);

                    // If the club is found, remove it from club_data using splice
                    if (index !== -1) {
                        this.club_data.splice(index, 1);
                    }
                }

            })
                .catch(error => this.error = error.response.data.errors)
        },

        delay() {
            this.disabled = true
            this.timeout = setTimeout(() => {
                this.disabled = false
            }, 5000)
            this.add_club()
        },


        add_club() {
            if (this.club_name == '' || this.club_type == '' || this.description == '' || this.employee_fee == '' || this.Outsider_fee == '' || this.Resident_fee == '') {
                this.$toastr.e("Please fill required fields!", "Caution!");
                if (this.club_name == '') {
                    this.name_error = 'Full name required.';
                }
                else {
                    this.name_error = '';
                }
                if (this.employee_fee == '') {
                    this.employee_fee_error = 'Fee for Employee required.';
                }
                else {
                    this.employee_fee_error = '';
                }
                if (this.Resident_fee == '') {
                    this.Resident_fee_error = 'Fee for Resident required.';
                }
                else {
                    this.Resident_fee_error = '';
                }
                if (this.Outsider_fee == '') {
                    this.Outsider_fee_error = 'Fee for Outsider required.';
                }
                else {
                    this.Outsider_fee_error = '';
                }
                if (this.club_type == '') {
                    this.type_error = 'Select Type';
                }
                else {
                    this.type_error = '';
                }
                if (this.description == '') {
                    this.des_error = 'Write description';
                }
                else {
                    this.des_error = '';
                }


            } else {

                axios.post('./create_new_club', {
                    club_name: this.club_name,
                    employee_fee: this.employee_fee,
                    Resident_fee: this.Resident_fee,
                    Outsider_fee: this.Outsider_fee,
                    club_type: this.club_type,
                    description: this.description,
                    status: this.club_status,
                })
                    .then(data => {
                        if (data.status === 200) {
                            this.$toastr.s("Club added successfully!", "Congratulations!");
                            this.club_data.unshift({
                                id: data.data.data,
                                Name: this.club_name,
                                Type: this.club_type,
                                status: this.club_status,
                                Employee_fee: this.employee_fee,
                                Resident_fee: this.Resident_fee,
                                Outsider_fee: this.Outsider_fee,
                                Description: this.description,
                            });
                            this.club_name = '';
                            this.club_type = '';
                            this.club_status = 'Active';
                            this.employee_fee = '',
                            this.Resident_fee = '',
                            this.Outsider_fee = '',
                            this.description = '';
                            this.name_error = '';
                            this.employee_fee_error = '',
                            this.Resident_fee_error = '',
                            this.Outsider_fee_error = '',
                            this.type_error = '';
                            this.des_error = '';

                            // Trigger the close button's click event
                            const closeButton = document.querySelector('.btn-close');
                            if (closeButton) {
                                closeButton.click();
                            }
                        }
                    })
                    .catch(error => {
                        if (error.response) {
                            const errors = error.response.data.errors;
                            // Display errors using Toastr or other notification library
                            for (const key in errors) {

                                if (errors[key][0] == "The club name already exists in the Clubs table.") {
                                    this.$toastr.e('This club name is currently unavailable.');
                                }
                                else {
                                    this.$toastr.e(errors[key][0]);
                                }

                            }
                        } else {
                            // Handle other errors or show a generic error message
                            this.$toastr.e('An unexpected error occurred.');
                        }
                    });
            }

        },
        search_club() {

            if(this.search_club_name !=''){
            const lowerCaseSearchName = this.search_club_name.toLowerCase();
            this.foundClubData = this.club_data.find(club => club.Name.toLowerCase() === lowerCaseSearchName);
            // return this.adsdata.filter(obj => obj.Name.toLowerCase().startsWith(name.toLowerCase()));

            if (!this.foundClubData) {
                // console.log('No match found for:', this.search_club_name);
                this.$toastr.e('No trace of : ' + this.search_club_name, 'Search & Filter');
            }}
            else{
                this.foundClubData=null;
            }
        },
        reset_filters(){
            this.search_club_name='';
            this.foundClubData=null;

        },

        update_club(id) {
            if (this.edit_club_name == '' || this.edit_club_type == '' || this.edit_club_desc == '' || this.edit_employee_fee == '' || this.edit_Outsider_fee == '' || this.edit_Resident_fee == '') {
                this.$toastr.e("Please fill required fields!", "Caution!");
                if (this.edit_club_name == '') {
                    this.edit_name_error = 'Full name required.';
                }
                else {
                    this.edit_name_error = '';
                }
                if (this.edit_employee_fee == '') {
                    this.edit_employee_fee_error = 'Fee for Employee required.';
                }
                else {
                    this.edit_employee_fee_error = '';
                }
                if (this.edit_Resident_fee == '') {
                    this.edit_Resident_fee_error = 'Fee for Resident required.';
                }
                else {
                    this.edit_Resident_fee_error = '';
                }
                if (this.edit_Outsider_fee == '') {
                    this.edit_Outsider_fee_error = 'Fee for Outsider required.';
                }
                else {
                    this.edit_Outsider_fee_error = '';
                }
                if (this.edit_club_type == '') {
                    this.edit_type_error = 'Select Type';
                }
                else {
                    this.edit_type_error = '';
                }
                if (this.edit_club_status == '') {
                    this.edit_status_error = 'Select Type';
                }
                else {
                    this.edit_type_error = '';
                }
                if (this.edit_club_desc == '') {
                    this.edit_des_error = 'Write description';
                }
                else {
                    this.edit_des_error = '';
                }


            }
            else {
                axios.post('./update_club' + '/' + id, {
                    club_name: this.edit_club_name,
                    club_type: this.edit_club_type,
                    club_status: this.edit_club_status,
                    employee_fee: this.edit_employee_fee,
                    Resident_fee: this.edit_Resident_fee,
                    Outsider_fee: this.edit_Outsider_fee,
                    description: this.edit_club_desc,
                    // Id:this.foundClub.id
                })
                    .then(data => {
                        if (data.status === 200) {
                            this.$toastr.s("Club updated successfully!", "Congratulations!");
                            const existingClubIndex = this.club_data.findIndex(club => club.id === id);

                            if (existingClubIndex !== -1) {
                                // Update the club properties with the new values
                                this.club_data[existingClubIndex].Name = this.edit_club_name;
                                this.club_data[existingClubIndex].Type = this.edit_club_type;
                                this.club_data[existingClubIndex].status = this.edit_club_status;
                                this.club_data[existingClubIndex].Employee_fee = this.edit_employee_fee;
                                this.club_data[existingClubIndex].Resident_fee = this.edit_Resident_fee;
                                this.club_data[existingClubIndex].Outsider_fee = this.edit_Outsider_fee;
                                this.club_data[existingClubIndex].Description = this.edit_club_desc;
                            }
                            this.edit_club_name = '';
                            this.edit_club_type = '';
                            this.edit_club_status = '';
                            this.edit_employee_fee = '';
                            this.edit_Resident_fee = '';
                            this.edit_Outsider_fee = '';
                            this.edit_club_desc = '';
                            this.edit_name_error = '';
                            this.edit_type_error = '';
                            this.edit_status_error = '';
                            this.edit_employee_fee_error = '';
                            this.edit_Resident_fee_error = '';
                            this.edit_Outsider_fee_error = '';
                            this.edit_des_error = '';
                            // Trigger the click event of the "Cancel" button
                            const cancelButton = document.getElementById('cancelButton');
                            cancelButton.click();

                        }
                    })
                    .catch(error => {
                        if (error.response) {
                            const errors = error.response.data.errors;
                            // Display errors using Toastr or other notification library
                            for (const key in errors) {

                                if (errors[key][0] == "The club name already exists in the Clubs table.") {
                                    this.$toastr.e('This club name is currently unavailable.');
                                }
                                else {
                                    this.$toastr.e(errors[key][0]);
                                }

                            }
                        } else {
                            // Handle other errors or show a generic error message
                            this.$toastr.e('An unexpected error occurred.');
                        }
                    });
            }

        },
    },
    mounted() {
    this.get_all_club();
    },

}
</script>

