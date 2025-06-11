<template>
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow-tem-change"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section class="app-user-list">
                    <div class="row d-flex justify-content-between my-3">
                        <div class="col-md-2">
                            <h3 class="fw-bolder  mb-100" style=" color: #7367f0;">Roles List:</h3>

                        </div>

                        <div class="col-md-2">

                            <router-link to="/settings/CreateRoles" type="button" class="btn btn-primary"
                                        >
                                        <i class="fas fa-plus"></i> Create Roles
                                    </router-link>
                        </div>



                    </div>
                </section>
                <div class="table-responsive" style="overflow-x: initial !important;">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <!-- <th class="sticky-th-center">Sr. #</th> -->
                                <th class="sticky-th-center">Roles Name</th>
                                <th class="sticky-th-center">Users to whome<br />this role is assign</th>
                                <th class="sticky-th-center">Created On</th>
                                <!-- <th class="sticky-th-center">Joining Date<br />& Salary</th>
                                            <th class="sticky-th-center">Status</th> -->
                                <th class="sticky-th-center" style="max-width: 25px;">Edit Role</th>
                                <th class="sticky-th-center">Delete Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(role, roleName) in adsdata" class="odd">
                                <!-- <td class="td-center">1</td> -->
                                <td class="td-center">{{ role.name }}</td>
                                <td class="td-center ">
                                    <ul  v-for="(user, index) in role.users.slice(0, 3)" :key="user.id" class="badge  rounded-pill badge-light-success">
                                        <li >{{ user.first_name }}</li>


                                    </ul>
                                    <ul v-if="role.users.length > 3 && !showMoreUsers" class="badge  rounded-pill badge-success">
        <li>
          <a href="#" @click.prevent="showMoreUsers = !showMoreUsers">......</a>
        </li>
      </ul>

      <!-- Show additional users when "More" is clicked -->
      <br>
      <ul v-if="showMoreUsers"  v-for="(user, index) in role.users.slice(3, 6)" class="badge rounded-pill badge-light-success">

        <li :key="index">
          {{ user.first_name }}
        </li>
      </ul>

                                </td>
                                <td class="td-center ">{{ formatCreatedAt(role.created_at) }}</td>
                                <!-- <td class="td-center">yes</td>
                                            <td class="td-center">yes</td> -->
                                <td class="td-center">
                                    <button type="button" class="btn btn-primary"
                                        @click="clickEditRole(role.id, role.permissions, role.name), openEditRoleModal()">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                </td>
                                <td class="td-center">
                                   <i @click="clickEditRole(role.id, role.permissions, role.name)" style="color: #dc3545;" class="fa-solid fa-trash " v-b-modal.modal-1></i>


                                </td>
                            </tr>

                        </tbody>
                    </table>

                </div>


            </div>

        </div>

        <b-modal @ok="deleteRole" id="modal-1" title="Delete Role">
            <p class="my-4">Are you sure ? you want delete this Role !</p>
        </b-modal>

        <b-modal id="modal-edit-lg" size="xl" title="Role Permissions To User" ok-only>
            <div class="row" style="margin-top:10px">

                <div class="row justify-content-center">
                    <div class="col-md-4 col-12 mb-2 position-relative">
                        <div class="row">
                            <div class="col-md-8 col-12 mb-2">
                                <input type="text" v-model="role_name" class="form-control" placeholder="Enter Role Name">
                            </div>
                            <div class="col-md-4 col-12 mb-2">
                                <button @click="updateRole()" class="dt-button add-new btn btn-primary" tabindex="0"
                                    type="button">
                                    <span>Update Role</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <role-accordion :Showpermissions="permissionsToUpdate" :Showroles="roleNameToUpdate"
                @pass-data="receiveDataFromChild" />


        </b-modal>
    </div>
</template>

<script>
import axios from 'axios';
import RoleAccordions from './RoleAccordions.vue';
import EventBus from '../../app.js';

export default {
    data() {
        return {
            showMoreUsers: false,

            limit: 10,
            adsdata: {},
            adsdatas: {},

            hr_read: '',
            hr_write: '',
            hr_restricted: '',
            hr_attendance: '',
            hr_superadmin: '',
            hr_overall: '',
            keyword1: '',
            status: '',
            location: '',
            designation: '',
            designations: {},
            locations: {},
            id: '',
            email: '',
            count_users: {},
            pageNo: 1,

            payroll_read: '',
            payroll_write: '',
            payroll_restricted: '',
            payroll_superadmin: '',
            payroll_overall: '',

            accounts_read: '',
            accounts_write: '',
            accounts_overall: '',
            accounts_superadmin: '',

            store_read: '',
            store_write: '',
            store_overall: '',

            audit_superadmin: '',

            get_company_roles: {},
            selectedPermissions: [],
            receivedData: {},

            receivedroles: [],
            roleNameToUpdate: [],
            roleID: '',
            permissionsToUpdate: [],
            role_name: '',


        }
    },
    components: {
        RoleAccordions,
    },

    methods: {
        deleteRole() {
            if (this.roleID) {
                // Send an HTTP DELETE request to your backend route
                console.log(this.roleID);
                axios
                    .delete(`./delete-role/${this.roleID}`) // Replace with your backend route
                    .then((response) => {
                        // Handle the successful deletion
                        this.$toastr.s('Role deleted:', response.data.message);
                        console.log('Role deleted:', response.data);
                        this.adsdata = this.adsdata.filter((role) => role.id !== this.roleID);

                        // Close the modal
                        this.$bvModal.hide('modal-1');

                    })
                    .catch((error) => {
                        // Handle errors
                        console.error('Error deleting role:', error);

                        // Close the modal if needed
                        this.$bvModal.hide('modal-1');
                    });
            }
        },
        clickEditRole(roleId, permissions, roleName) {
            this.role_name = roleName;
            // const permissionIds = permissions.map(permission => permission.id);
            axios.get(`./getsinglerolepermission/${roleId}`)
                .then(response => {
                    // Handle the response data here
                    const responseData = response.data.data;
console.log('dateee',responseData);
                    this.permissionsToUpdate = responseData.permissions;
                    // You can access the backendRoles and other data from responseData
//  this.roleNameToUpdate = responseData.backendRoles

                    this.roleNameToUpdate = responseData.backendRoles.map(role => role.name);
                    console.log('pass to child', this.permissionsToUpdate, this.roleNameToUpdate)

                    EventBus.$emit('update-data', {

                permissionsToUpdate: this.permissionsToUpdate,
                roleNameToUpdate: this.roleNameToUpdate
            });
                    // Now you can use the backendRoles and other data as needed
                    // For example, you can set some state variables or perform other actions
                    // based on the API response.
                })
                .catch(error => {
                    // Handle errors here
                    console.error('API Error:', error);
                });

            this.roleID = roleId;


        },

        updateData(data) {
            // Receive updated data from the child component
            this.permissionsToUpdate = data.permissionsToUpdate;
            this.roleNameToUpdate = data.roleNameToUpdate;
        },
        async updateRole() {
            try {
                let combinedPermissions;

if (this.receivedData.length === 0) {
  // If receivedData is empty, use only permissionsToUpdate
  combinedPermissions = this.permissionsToUpdate;
} else {
  // Combine receivedData and permissionsToUpdate, removing duplicates
  const uniquePermissions = new Set([ ...this.receivedData]);
  combinedPermissions = Array.from(uniquePermissions);
}
                // Prepare the data you want to send to the API
                // const uniquePermissions = new Set([ ...this.permissionsToUpdate,...this.receivedData]);
                // const combinedPermissions = Array.from(uniquePermissions);

                // // const combinedPermissions = [...this.permissionsToUpdate, ...this.receivedData];
                // console.log('combine permission', uniquePermissions)
                // console.log(this.roleID);
                const dataToUpdate = {

                    role_name: this.role_name, // Use the stored role name
                    selected_permissions: combinedPermissions, // Use the stored permissions
                };

                console.log("data to update",dataToUpdate)
                // Send a PUT request to update the role
                // Replace 'ROLE_ID' with the ID of the role you want to update
                const response = await axios.put(`./update-role/${this.roleID}`, dataToUpdate)
                if (response.status === 200) {
  // Update the role name in the frontend without refreshing
  const updatedRoleIndex = this.adsdata.findIndex(role => role.id === this.roleID);

  if (updatedRoleIndex !== -1) {
    // Update the role name for the found role
    this.adsdata[updatedRoleIndex].name = this.role_name;
  }
} else {
  // Handle errors if the PUT request is not successful
  console.error('Error updating the role:', response.statusText);
}
                // Handle a successful response
                this.$toastr.s('Role Updated:', response.data.message);
                console.log('API response:', response.data);
                this.$bvModal.hide('modal-edit-lg');
                // Optionally, you can perform additional actions after updating the role
            } catch (error) {
                // Handle errors
                console.error('API error:', error);
                // Optionally, you can show an error message to the user
            }
        },
        receiveDataFromChild(data) {

            // Handle the received data from the child component
            console.log("data", data)
            this.receivedData = data.selectedPermissions;
            //   this.receivedroles = data.selectedRoles;
            //   this.permissionsToUpdate = [...data.selectedPermissions];
            this.receivedroles = [...data.selectedRoles];
            console.log("rec", this.receivedroles)
        },
        formattedPermissions() {
            // Extract and format permissions for each role
            const formattedPermissions = {};
            for (const roleName in this.adsdata) {
                formattedPermissions[roleName] = this.adsdata[roleName].permissions;
            }
            console.log(formattedPermissions);
            return formattedPermissions;
        },

        formatCreatedAt(timestamp) {
            const date = new Date(timestamp);
            return date.toISOString().split('T')[0]; // Extract and format the date portion
        },
        openEditRoleModal() {
            // Use the $bvModal service to show the modal by its ID
            console.log('model');
            this.$bvModal.show('modal-edit-lg');
        },
        openShowRolesModal() {
            console.log('models');
            // Use the $bvModal service to show the modal by its ID
            this.$bvModal.show('modal-lg'); // Replace 'modal-lg' with the actual modal ID

        },
        allroles(){
    axios.get('./showuserrole')
            .then(response => {
                console.log(response.data.roles)
                this.adsdata = response.data.roles;
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
},
    },

    mounted() {

        axios.get('./all-roles-and-permissions')
            .then(response => {
                // Handle the response data here
                console.log(response.data.data);
                this.adsdatas = response.data.data; // Assuming 'data' is the key in your JSON response
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
      this.allroles();

    }
}
</script>
<style scoped>
.card {
    background-clip: padding-box;
    box-shadow: 0 2px 6px 0 rgba(67, 89, 113, .12);
    /* Add any additional styles you want here */
}

.table-responsive {
    background-clip: padding-box;
    box-shadow: 0 2px 6px 0 rgba(67, 89, 113, .12);
    /* Add any additional styles you want here */
}</style>
