<template>
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section class="app-user-list">
                    <div class="row mx-2 ">
                        <div class="card " style="box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);">
                            <h3 class="fw-bolder mt-3  mb-100" style="margin: 10px 52px; color: #7367f0;">Roles
                                List:</h3>
                            <div class="row" style="margin-top:10px">
                                <div class="row " style="margin: 5px 38px;">
                                    <div class="col-md-12 col-12 mb-2 position-relative">
                                        <div class="row justify-content-between">
                                            <div class="col-md-4 col-12 ">
                                                <input type="text" v-model="role_name" class="form-control"
                                                       placeholder="Enter Role Name">
                                            </div>
                                            <div class="col-md-4 col-12 float-end">
                                                <button @click="Add_Role" class="dt-button add-new btn btn-primary my-2"
                                            tabindex="0" type="button">
                                        <span>Create Role</span>
                                    </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <role-accordion @pass-data="receiveDataFromChild"/>
                            <!-- <div class="row justify-content-end">
                                <div class="col-md-2 mr-5">
                                    <button @click="Add_Role" class="dt-button add-new btn btn-primary my-2"
                                            tabindex="0" type="button">
                                        <span>Create Role</span>
                                    </button>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</template>

<script>
// './components/client_admin_side/users_page.vue'
import RoleAccordions from './RoleAccordions.vue';

import axios from 'axios';

export default {

    data() {
        return {
            adsdata: {},
            openAccordion: null,
            toggle: false,
            selectedIds: [],
            role_name: '',
            test: '',
            selectedRoles: [], // To store selected role IDs
            selectedPermissions: [],
            selectedRolesPermissions: [],
            receivedData: {},
        }
    },
    components: {
        RoleAccordions,
    },
    methods: {

        receiveDataFromChild(data) {
            // Handle the received data from the child component
            console.log("dataCreate", data)
            this.receivedData = data;
        },
        Add_Role() {
            if (this.receivedData.selectedPermissions.length === 0) {
        // Show a toastr message indicating that permissions should be selected
        this.$toastr.e('Please select roles and permissions before creating a role');
        return; // Don't proceed with the POST request if permissions are empty
    }
    if (!this.role_name) {
        // Show a toastr message indicating that a role name should be added
        this.$toastr.e('Please add a role name');
        return; // Don't proceed with the POST request if role name is empty
    }
            const data = {
                role_name: this.role_name,
                selected_permissions: this.receivedData.selectedPermissions,
                selected_roles: this.receivedData.selectedRoles,
            };
            // Make a POST request to your Laravel API route
            axios.post('./addrole', data)
                .then(response => {
                    // Handle the success response
                    this.$toastr.s('Role created successfully:', response.data.message);
                    console.log('Role created successfully:', response.data.message);

                    // Navigate to the CreateRoles route
                    this.$router.push({path: '/settings/rolesPermissions'});

                    // Optionally, you can reset the form fields or perform other actions
                })
                .catch(error => {
                    // Handle the error response
                    console.error('Error creating role:', error.response.data.message);
                    this.$toastr.e('Role creation error:',error.response.data.message);
                    // this.$toastr.e('Role creation error:',error.response.data.message.errors.role_name[0]);


                });
        },
        fetchData() {
            axios.get('./all-roles-and-permissions')
                .then(response => {
                    // Handle the response data here
                    console.log(response.data.data);
                    this.adsdata = response.data.data; // Assuming 'data' is the key in your JSON response
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        },

    },
    mounted() {
        this.fetchData();
    }
}
</script>
<style>

</style>
