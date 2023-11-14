<template>
    <div class="row d-flex justify-content-center">


        <div class="accordion col-md-11 my-2" id="accordionExample">
            <div v-for="(categoryData, categoryName) in hierarchicalData" :key="categoryName" class="accordion-item accordion-shadow"
               >
                <div class="row d-flex justify-content-between my-4">
                    <div class="col-md-11 ">


                        <div class="bg-light pb-2" style="border-radius: 10px;">
                            <input class="mx-4 form-check-input my-1" type="checkbox"
                                :id="'category_checkbox_' + categoryName" @change="toggleCategory(categoryData.name)" />
                            <label class="form-check-label my-1 category-name" :for="'category_checkbox_' + categoryData.name"
                                >
                                {{ categoryData.name }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-1" style="
                                  
                                ">
                        <h2 class="accordion-header" :id="'heading_' + categoryData">
                            <button class="collapsed bg-white my-2"  style="border: none;"  type="button" data-bs-toggle="collapse" :data-bs-target="'#collapse_' + categoryName" aria-expanded="false" :aria-controls="'collapse_' + categoryName" @click="toggleCategoryAccordion(categoryName)">
                                                                                        <i class="fa-solid fa-circle-plus"></i>
                                                                                    </button>
                            <!-- <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                :data-bs-target="'#collapse_' + categoryName"
                                :aria-expanded="isAccordionExpanded(categoryName)"
                                :aria-controls="'collapse_' + categoryName" @click="toggleCategoryAccordion(categoryName)">
                                
                            </button> -->
                        </h2>
                    </div>
                </div>
                <div :id="'collapse_' + categoryName" class="accordion-collapse collapse show"
                :class="{ 'show': isAccordionExpanded(categoryName) }" :aria-labelledby="'heading_' + categoryName"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <span class="attractive-span ">Roles:</span>
                        <div v-for="(roleData, roleindex) in categoryData.roles" :key="roleindex"
                            class="mx-1 accordion-item mb-3 accordion-shadow" 
                            >
                            <div class=" row d-flex justify-content-between role-accordion" >

                                <div class="col-md-11">


                                    <div class=" " >
                                        <input class="mx-4 my-2 form-check-input" type="checkbox"
                                            :id="'role_checkbox_' + roleData.name"
                                            :checked="selectedRoles.includes(roleData.name)"
                                            @change="toggleRole(roleData.name)" />
                                        <label class="form-check-label my-2 role-name" :for="'role_checkbox_' + roleindex"
                                            >
                                            {{ roleData.name }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-1" style="
                                   
                                ">
                                    <h2 class=" accordion-header" :id="'heading_' + roleData.name">
                                        <!-- <button class=" my-2" type="button" style="border: none; background-color: #a1adf6; color: white;"
                                            @click="toggleAccordionAndFetchNestedRoles(roleData)">
                                            <i class="fa-solid fa-circle-plus"></i>
                                        </button> -->
                                          <button
    class="my-2 animate__animated animate__fadeIn role-button"
    type="button"
    
    @click="toggleAccordionAndFetchNestedRoles(roleData)"
  >
    <i class="fa-solid fa-circle-plus"></i>
  </button>
                                    </h2>
                                </div>
                            </div>
                            <div :id="'accordion_' + roleData.name" class="accordion-collapse collapse"
                                :aria-labelledby="'heading_' + roleData.name" :data-bs-parent="'#collapse_' + categoryName">
                                <div class="accordion-body">

                                    <!-- <label class="form-check-label" :for="'permission_checkbox_' + roleName">
                                        Permissions:
                                    </label> -->
                                    <div v-if="roleData.nestedRoles && roleData.nestedRoles.length > 0">
                                        <span class="nested-span ">Nested Roles:</span>
                                        <div v-for="(nestedroleData, nestedroleindex) in roleData.nestedRoles"
                                            :key="nestedroleindex" class=" mx-1 accordion-item mb-5 accordion-shadow"
                                           
                                           >
                                            <div class=" row d-flex justify-content-between nextedrole-accordion" >
                                                <div class="col-md-11">
                                                    <div class="pb-2"
                                                        >
                                                        <!-- <p>{{selectedNestedRoles.includes(nestedroleData.id) || selectedRoles.includes(roleData.id)}}</p> -->

                                                        <input class="mx-4 my-1 form-check-input" type="checkbox"
                                                            :id="'nestedrole_checkbox_' + nestedroleData.name"
                                                            :checked="selectedRoles.includes(nestedroleData.name)"
                                                            @change="toggleNestedRole(nestedroleData.name)" />
                                                        <label class="form-check-label my-1 nestedrole-name"
                                                            :for="'role_checkbox_' + nestedroleindex"
                                                            >
                                                            {{ nestedroleData.name }}
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-1" style="
                                   
                                ">
                                                    <h2 class=" accordion-header"
                                                        :id="'heading_' + nestedroleData.name">
                                                        <button class="my-2 nestedrole-button" type="button"
                                                            @click="toggleAccordionAndFetchNestedRoles(nestedroleData)">
                                                            <i class="fa-solid fa-circle-plus"></i>
                                                        </button>
                                                    </h2>
                                                </div>
                                            </div>
                                            <div :id="'accordion_' + nestedroleData.name"
                                                class="accordion-collapse collapse"
                                                :aria-labelledby="'heading_' + nestedroleData.name"
                                                :data-bs-parent="'#collapse_' + categoryName"
                                             
                                                >
                                                <div class="accordion-body">

                                                    <div class="row">
                                                        <div v-for="(nestedpermissionData, nestedpermission) in nestedroleData.permissions"
                                                            :key="nestedpermission" class="col-md-4">
                                                            <div class="d-flex  mb-1">
                                                                <input style="margin-top: 10px; margin-left: 5px;"
                                                                    class="mx-4 form-check-input" type="checkbox"
                                                                    @change="toggleNestedPermission(roleData.name, nestedroleData.name, nestedpermissionData.id)"
                                                                    :id="'nested_permission_checkbox_' + nestedroleData.name + '_' + nestedpermissionData.id"
                                                                    :checked="selectedPermissions.includes(nestedpermissionData.id)" />
                                                                <span class="nestedrolepermission"
                                                                   >{{
                                                                        nestedpermissionData.name }}</span>
                                                             
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div v-else>
                                        <div class="row">
                                            <div v-for="(permissionData, permission) in roleData.permissions"
                                                :key="permission" class="col-md-4">
                                                <div class="d-flex  mb-1">
                                                    <input style="margin-top: 10px; margin-left: 5px;"
                                                        class="mx-4 form-check-input" type="checkbox"
                                                        @change="togglePermission(roleData.name, permissionData.id)"
                                                        :id="'permission_checkbox_' + roleData.name + '_' + permissionData.id"
                                                        :checked="selectedPermissions.includes(permissionData.id)">
                                                    <span  class="rolepermision">{{
                                                        permissionData.name }}</span>
                                                    <!-- <p>{{selectedPermissions.includes(permissionData.id) || nestedPermissions.includes(permissionData.id)}}</p> -->
                                                  


                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
import EventBus from '../../app.js';
import axios from 'axios';
// import Vue from 'vue';
export default {
    // props: {
    //     Showpermissions: Array, // Adjust the type as needed
    //     Showroles: Array, // Correct prop name with an uppercase "S"
    // },
    data() {
        return {
            adsdata: {},
            activeCategory: null,

            hierarchicalData: {},
            openAccordion: null,
            toggle: false,
            selectedIds: [],
            role_name: '',
            test: '',

            //         selectedPermissions: [...this.Showpermissions],
            //   selectedRoles: [...this.Showroles],
            selectedRoles: [], // To store selected role IDs
            selectedNestedRoles: [],
            selectedPermissions: [],
            selectedCategories: [],
            selectedRolesPermissions: [],
            selectedRoleStatus: {},
            selectedAccordion: null,
            nestedRoles: [],
            nestedPermissions: [],

        }
    },
    created() {

        //     EventBus.$on('update-data', (data) => {
        //   // Update selectedRoles and selectedPermissions with the received data
        //   this.selectedRoles = data.roleNameToUpdate;
        //   this.selectedPermissions = data.permissionsToUpdate;
        //   console.log('roles', this.selectedRoles, 'permission', this.selectedPermissions);
        // });


    },
    // computed: {

    //     // Example computed property to check if all permissions for a role are selected
    //     isRoleSelected() {
    //         return (roleData) => {
    //             if (this.Showpermissions && this.Showpermissions.length > 0) {
    //                 // Assuming each role has a list of permission IDs associated with it
    //                 const rolePermissions = roleData.permissions.map(permission => permission.id);

    //                 // Check if all permissions for the role are in Showpermissions
    //                 return rolePermissions.every(permissionId => this.Showpermissions.includes(permissionId));
    //             }
    //             return false;
    //         };
    //     }
    // },

    methods: {


        toggleAccordionAndFetchNestedRoles(roleData) {



            this.toggleAccordion(roleData.name);
            this.getNestedRolesById(this.hierarchicalData, roleData.id);

        },
        getNestedRolesById(hierarchicalData, roleId) {
            // Iterate through categories
            console.log(roleId);
            for (const category of hierarchicalData) {
                // Iterate through roles within the category
                for (const role of category.roles) {
                    // Check if the current role's id matches the provided roleId
                    if (role.id === roleId && role.nestedRoles) {
                        // Return the nested roles if they exist
                        // this.nestedRoles = role.nestedRoles;
                        console.log(role.nestedRoles);
                        return role.nestedRoles;

                    }
                }
            }

            // If no matching role is found, return an empty array or handle the error as needed
            return [];
        },

        // toggleCategory(categoryName) {
        //     console.log('Selected Category:', categoryName);

        //     // Check if the category is already selected
        //     const isCategorySelected = this.selectedCategories.includes(categoryName);

        //     // Iterate through hierarchicalData
        //     for (const category of this.hierarchicalData) {
        //         if (category.name === categoryName) {
        //             // Toggle the category's selection
        //             if (isCategorySelected) {
        //                 const index = this.selectedCategories.indexOf(categoryName);
        //                 if (index !== -1) {
        //                     this.selectedCategories.splice(index, 1);
        //                 }

        //                 // Deselect all roles and associated permissions within the category
        //                 for (const role of category.roles) {
        //                     const roleIndex = this.selectedRoles.indexOf(role.name);
        //                     if (roleIndex !== -1) {
        //                         this.selectedRoles.splice(roleIndex, 1);
        //                     }

        //                     const permissionIds = role.permissions.map((permission) => permission.id);
        //                     this.selectedPermissions = this.selectedPermissions.filter(
        //                         (permissionId) => !permissionIds.includes(permissionId)
        //                     );

        //                     // Update checkboxes for roles and permissions
        //                     const roleCheckbox = document.getElementById(`role_checkbox_${role.name}`);
        //                     if (roleCheckbox) {
        //                         roleCheckbox.checked = false;
        //                     }

        //                     for (const permission of role.permissions) {
        //                         const permissionCheckbox = document.getElementById(`permission_checkbox_${role.name}_${permission.id}`);
        //                         if (permissionCheckbox) {
        //                             permissionCheckbox.checked = false;
        //                         }
        //                     }

        //                     // Deselect nested roles and their permissions
        //                     if (role.nestedRoles && role.nestedRoles.length > 0) {
        //                         for (const nestedRole of role.nestedRoles) {
        //                             const nestedRoleCheckbox = document.getElementById(`nestedrole_checkbox_${nestedRole.name}`);
        //                             if (nestedRoleCheckbox) {
        //                                 nestedRoleCheckbox.checked = false;
        //                             }

        //                             for (const permission of nestedRole.permissions) {
        //                                 const permissionCheckbox = document.getElementById(`nested_permission_checkbox_${nestedRole.name}_${permission.id}`);
        //                                 if (permissionCheckbox) {
        //                                     permissionCheckbox.checked = false;
        //                                 }
        //                             }
        //                         }
        //                     }
        //                 }
        //                 // Remove the category's permission ID from selectedPermissions
        //                 const categoryPermissionId = category.permissionId;
        //                 if (categoryPermissionId) {
        //                     const categoryPermissionIndex = this.selectedPermissions.indexOf(categoryPermissionId);
        //                     if (categoryPermissionIndex !== -1) {
        //                         this.selectedPermissions.splice(categoryPermissionIndex, 1);
        //                     }
        //                 }
        //             } else {
        //                 this.selectedCategories.push(categoryName);

        //                 // Select all roles and associated permissions within the category
        //                 for (const role of category.roles) {
        //                     if (!this.selectedRoles.includes(role.name)) {
        //                         this.selectedRoles.push(role.name);
        //                     }

        //                     const permissionIds = role.permissions.map((permission) => permission.id);
        //                     const newPermissionIds = permissionIds.filter(
        //                         (permissionId) => !this.selectedPermissions.includes(permissionId)
        //                     );
        //                     this.selectedPermissions = [...this.selectedPermissions, ...newPermissionIds];

        //                     // Update checkboxes for roles and permissions
        //                     const roleCheckbox = document.getElementById(`role_checkbox_${role.name}`);
        //                     if (roleCheckbox) {
        //                         roleCheckbox.checked = true;
        //                     }

        //                     for (const permission of role.permissions) {
        //                         const permissionCheckbox = document.getElementById(`permission_checkbox_${role.name}_${permission.id}`);
        //                         if (permissionCheckbox) {
        //                             permissionCheckbox.checked = true;
        //                         }
        //                     }

        //                     // Select nested roles and their permissions
        //                     if (role.nestedRoles && role.nestedRoles.length > 0) {
        //                         for (const nestedRole of role.nestedRoles) {
        //                             const nestedRoleCheckbox = document.getElementById(`nestedrole_checkbox_${nestedRole.name}`);
        //                             if (nestedRoleCheckbox) {
        //                                 nestedRoleCheckbox.checked = true;
        //                             }

        //                             for (const permission of nestedRole.permissions) {
        //                                 const permissionCheckbox = document.getElementById(`nested_permission_checkbox_${nestedRole.name}_${permission.id}`);
        //                                 if (permissionCheckbox) {
        //                                     permissionCheckbox.checked = true;
        //                                 }
        //                             }
        //                         }
        //                     }
        //                 }
        //                 const categoryPermissionId = category.permissionId;
        //                 if (categoryPermissionId && !this.selectedPermissions.includes(categoryPermissionId)) {
        //                     this.selectedPermissions.push(categoryPermissionId);
        //                 }
        //             }
        //             break; // Exit the loop since we found the category
        //         }
        //     }

        //     console.log(this.selectedRoles, this.selectedPermissions);

        //     // Emit data to the parent component
        //     this.passDataToParent();
        // },

toggleCategory(categoryName) {
    console.log('Selected Category:', categoryName);

    // Check if the category is already selected
    const isCategorySelected = this.selectedCategories.includes(categoryName);

    // Toggle the category's selection
    if (isCategorySelected) {
        this.deselectCategory(categoryName);
    } else {
        this.selectCategory(categoryName);
    }

    console.log(this.selectedRoles, this.selectedPermissions);

    // Emit data to the parent component
    this.passDataToParent();
},

selectCategory(categoryName) {
    this.selectedCategories.push(categoryName);

    // Iterate through hierarchicalData to select roles and permissions
    for (const category of this.hierarchicalData) {
        if (category.name === categoryName) {
            this.selectRolesAndPermissions(category);
            break; // Exit the loop since we found the category
        }
    }
},

deselectCategory(categoryName) {
    const index = this.selectedCategories.indexOf(categoryName);
    if (index !== -1) {
        this.selectedCategories.splice(index, 1);
    }

    // Iterate through hierarchicalData to deselect roles and permissions
    for (const category of this.hierarchicalData) {
        if (category.name === categoryName) {
            this.deselectRolesAndPermissions(category);
            break; // Exit the loop since we found the category
        }
    }
},

selectRolesAndPermissions(category) {
    // Select all roles and associated permissions within the category
    for (const role of category.roles) {
        if (!this.selectedRoles.includes(role.name)) {
            this.selectedRoles.push(role.name);
        }

        const permissionIds = role.permissions.map((permission) => permission.id);
        const newPermissionIds = permissionIds.filter(
            (permissionId) => !this.selectedPermissions.includes(permissionId)
        );
        this.selectedPermissions = [...this.selectedPermissions, ...newPermissionIds];

        // Update checkboxes for roles and permissions
        this.updateRoleAndPermissionCheckboxes(true, role);

        // Select nested roles and their permissions
        if (role.nestedRoles && role.nestedRoles.length > 0) {
            for (const nestedRole of role.nestedRoles) {
                this.updateRoleAndPermissionCheckboxes(true, nestedRole);
            }
        }
    }

    const categoryPermissionId = category.permissionId;
    if (categoryPermissionId && !this.selectedPermissions.includes(categoryPermissionId)) {
        this.selectedPermissions.push(categoryPermissionId);
    }
},

deselectRolesAndPermissions(category) {
    // Deselect all roles and associated permissions within the category
    for (const role of category.roles) {
        const roleIndex = this.selectedRoles.indexOf(role.name);
        if (roleIndex !== -1) {
            this.selectedRoles.splice(roleIndex, 1);
        }

        const permissionIds = role.permissions.map((permission) => permission.id);
        this.selectedPermissions = this.selectedPermissions.filter(
            (permissionId) => !permissionIds.includes(permissionId)
        );

        // Update checkboxes for roles and permissions
        this.updateRoleAndPermissionCheckboxes(false, role);

        // Deselect nested roles and their permissions
        if (role.nestedRoles && role.nestedRoles.length > 0) {
            for (const nestedRole of role.nestedRoles) {
                this.updateRoleAndPermissionCheckboxes(false, nestedRole);
            }
        }
    }

    // Remove the category's permission ID from selectedPermissions
    const categoryPermissionId = category.permissionId;
    if (categoryPermissionId) {
        const categoryPermissionIndex = this.selectedPermissions.indexOf(categoryPermissionId);
        if (categoryPermissionIndex !== -1) {
            this.selectedPermissions.splice(categoryPermissionIndex, 1);
        }
    }
},

updateRoleAndPermissionCheckboxes(select, role) {
    // Update checkboxes for roles and permissions
    const roleCheckbox = document.getElementById(`role_checkbox_${role.name}`);
    if (roleCheckbox) {
        roleCheckbox.checked = select;
    }

    for (const permission of role.permissions) {
        const permissionCheckbox = document.getElementById(`permission_checkbox_${role.name}_${permission.id}`);
        if (permissionCheckbox) {
            permissionCheckbox.checked = select;
        }
    }

    // Update checkboxes for nested roles and their permissions
    if (role.nestedRoles && role.nestedRoles.length > 0) {
        for (const nestedRole of role.nestedRoles) {
            const nestedRoleCheckbox = document.getElementById(`nestedrole_checkbox_${nestedRole.name}`);
            if (nestedRoleCheckbox) {
                nestedRoleCheckbox.checked = select;
            }

            for (const permission of nestedRole.permissions) {
                const permissionCheckbox = document.getElementById(`nested_permission_checkbox_${nestedRole.name}_${permission.id}`);
                if (permissionCheckbox) {
                    permissionCheckbox.checked = select;
                }
            }
        }
    }
},



        toggleNestedRole(nestedRoleName) {
            console.log('Selected Nested Role:', nestedRoleName);

            // Find the nested role within hierarchicalData
            for (const category of this.hierarchicalData) {
                for (const role of category.roles) {
                    if (role.nestedRoles && role.nestedRoles.length > 0) {
                        for (const nestedRole of role.nestedRoles) {
                            if (nestedRole.name === nestedRoleName) {
                                // Toggle the nested role's selection
                                const nestedRoleIndex = this.selectedRoles.indexOf(nestedRoleName);
                                console.log(nestedRoleIndex);
                                if (nestedRoleIndex !== -1) {
                                    // Nested role is already selected, so deselect it
                                    this.selectedRoles.splice(nestedRoleIndex, 1);

                                    // Deselect permissions associated with the nested role and its nested roles
                                    const nestedPermissionIds = new Set();
                                    const collectNestedPermissionIds = (permissions) => {
                                        for (const permission of permissions) {
                                            nestedPermissionIds.add(permission.id);
                                            if (permission.nestedRoles && permission.nestedRoles.length > 0) {
                                                collectNestedPermissionIds(permission.nestedRoles);
                                            }
                                        }
                                    };
                                    collectNestedPermissionIds(nestedRole.permissions);

                                    this.selectedPermissions = this.selectedPermissions.filter(
                                        (permissionId) => !nestedPermissionIds.has(permissionId)
                                    );

                                    // Update checkboxes for all permissions
                                    for (const permissionId of nestedPermissionIds) {
                                        const checkbox = document.getElementById(`nested_permission_checkbox_${nestedRoleName}_${permissionId}`);
                                        if (checkbox) {
                                            checkbox.checked = false;
                                        }
                                    }
                                    console.log(nestedPermissionIds);
                                    //                                     const anyNestedPermissionSelected = [...nestedPermissionIds].some(
                                    //     (permissionId) => this.selectedPermissions.includes(permissionId)
                                    // );
                                    // Check if any nested role permission is selected
                                    const anyNestedRolePermissionSelected = category.roles.some((existingRole) =>
                                        existingRole.nestedRoles && existingRole.nestedRoles.length > 0
                                            ? existingRole.nestedRoles.some((nestedRole) =>
                                                this.selectedRoles.includes(nestedRole.name) && nestedRole.permissions.some((permission) =>
                                                    this.selectedPermissions.includes(permission.id)
                                                )
                                            )
                                            : false
                                    );
                                    console.log(anyNestedRolePermissionSelected);
                                    if (!anyNestedRolePermissionSelected) { 

                                        const parentRole = role; // Assuming parent role is the immediate role
                                        if (parentRole.permissions && parentRole.permissions.length > 0) {
                                            const firstPermissionId = parentRole.permissions[0].id;
                                            if (firstPermissionId && this.selectedPermissions.includes(firstPermissionId)) {
                                                const firstPermissionIndex = this.selectedPermissions.indexOf(firstPermissionId);
                                                this.selectedPermissions.splice(firstPermissionIndex, 1);
                                                const firstPermissionCheckbox = document.getElementById(`permission_checkbox_${nestedRoleName}_${firstPermissionId}`);
                                                if (firstPermissionCheckbox) {
                                                    firstPermissionCheckbox.checked = false;
                                                }
                                            }
                                        }

                                        // Also, unselect the category's permission ID
                                        const categoryPermissionId = category.permissionId;
                                        if (categoryPermissionId && this.selectedPermissions.includes(categoryPermissionId)) {
                                            const categoryPermissionIndex = this.selectedPermissions.indexOf(categoryPermissionId);
                                            this.selectedPermissions.splice(categoryPermissionIndex, 1);
                                            const categoryPermissionCheckbox = document.getElementById(`category_checkbox_${category.name}`);
                                            if (categoryPermissionCheckbox) {
                                                categoryPermissionCheckbox.checked = false;
                                            }
                                        }
                                    }
                                } else {
                                    // Nested role is not selected, so select it
                                    this.selectedRoles.push(nestedRoleName);

                                    // Select permissions associated with the nested role and its nested roles
                                    const nestedPermissionIds = new Set();
                                    const collectNestedPermissionIds = (permissions) => {
                                        for (const permission of permissions) {
                                            nestedPermissionIds.add(permission.id);
                                            if (permission.nestedRoles && permission.nestedRoles.length > 0) {
                                                collectNestedPermissionIds(permission.nestedRoles);
                                            }
                                        }
                                    };
                                    collectNestedPermissionIds(nestedRole.permissions);

                                    // Add nested permissions to the Set
                                    nestedPermissionIds.forEach((permissionId) => {
                                        this.selectedPermissions.push(permissionId);
                                    });

                                    // Update checkboxes for all permissions
                                    for (const permissionId of nestedPermissionIds) {
                                        const checkbox = document.getElementById(`nested_permission_checkbox_${nestedRoleName}_${permissionId}`);
                                        if (checkbox) {
                                            checkbox.checked = true;
                                        }
                                    }

                                    // Now, select the first permission of the parent role
                                    const parentRole = role; // Assuming parent role is the immediate role
                                    if (parentRole.permissions && parentRole.permissions.length > 0) {
                                        const firstPermissionId = parentRole.permissions[0].id;
                                        if (firstPermissionId && !this.selectedPermissions.includes(firstPermissionId)) {
                                            this.selectedPermissions.push(firstPermissionId);
                                            const firstPermissionCheckbox = document.getElementById(`nested_permission_checkbox_${nestedRoleName}`);
                                            if (firstPermissionCheckbox) {
                                                firstPermissionCheckbox.checked = true;
                                            }
                                        }
                                    }

                                    // Also, add the category's permission ID
                                    const categoryPermissionId = category.permissionId;
                                    if (categoryPermissionId && !this.selectedPermissions.includes(categoryPermissionId)) {
                                        this.selectedPermissions.push(categoryPermissionId);
                                        const categoryPermissionCheckbox = document.getElementById(`category_checkbox_${category.name}_${categoryPermissionId}`);
                                        if (categoryPermissionCheckbox) {
                                            categoryPermissionCheckbox.checked = true;
                                        }
                                    }
                                }
                                break; // Exit the loop since we found the nested role
                            }
                        }
                    }
                }
            }

            console.log('Selected Roles:', this.selectedRoles);
            console.log('Selected Permissions:', this.selectedPermissions);

            // Emit data to the parent component
            this.passDataToParent();
        },




        toggleRole(roleName) {
            console.log('Selected Role:', roleName);

            // Find the role within hierarchicalData
            for (const category of this.hierarchicalData) {
                for (const role of category.roles) {
                    if (role.name === roleName) {
                        // Toggle the role's selection
                        if (this.selectedRoles.includes(roleName)) {
                            // Role is already selected, so deselect it
                            this.selectedRoles.splice(this.selectedRoles.indexOf(roleName), 1);

                            // Deselect the associated permissions (including nested permissions)
                            const deselectPermissions = (permissions) => {
                                for (const permission of permissions) {
                                    // this.selectedPermissions = this.selectedPermissions.filter(
                                    //     (permissionId) => permissionId !== permission.id
                                    // );
                                    const uniquePermissionIds = new Set(this.selectedPermissions);

                                    // Remove the current permission ID
                                    uniquePermissionIds.delete(permission.id);

                                    // Update selectedPermissions with the unique IDs
                                    this.selectedPermissions = Array.from(uniquePermissionIds);

                                    // Update checkboxes for all permissions
                                    for (const permissionId of permissionIds) {
                                        const checkbox = document.getElementById(`permission_checkbox_${roleName}_${permissionId}`);
                                        if (checkbox) {
                                            checkbox.checked = false;
                                        }
                                    }

                                    if (permission.nestedRoles && permission.nestedRoles.length > 0) {
                                        deselectPermissions(permission.nestedRoles);
                                    }
                                }
                            };

                            const permissionIds = role.permissions.map((permission) => permission.id);
                            deselectPermissions(role.permissions);

                            // Deselect nested roles (if any)
                            if (role.nestedRoles && role.nestedRoles.length > 0) {
                                for (const nestedRole of role.nestedRoles) {
                                    const nestedRoleName = nestedRole.name;
                                    this.selectedRoles.splice(this.selectedRoles.indexOf(nestedRoleName), 1);
                                    const nestedRoleCheckbox = document.getElementById(`nestedrole_checkbox_${nestedRoleName}`);
                                    if (nestedRoleCheckbox) {
                                        nestedRoleCheckbox.checked = false;
                                    }
                                    // Deselect permissions associated with the nested role and its nested roles
                                    const nestedPermissionIds = [];
                                    const collectNestedPermissionIds = (permissions) => {
                                        for (const permission of permissions) {
                                            nestedPermissionIds.push(permission.id);
                                            if (permission.nestedRoles && permission.nestedRoles.length > 0) {
                                                collectNestedPermissionIds(permission.nestedRoles);
                                            }
                                        }
                                    };
                                    collectNestedPermissionIds(nestedRole.permissions);

                                    this.selectedPermissions = this.selectedPermissions.filter(
                                        (permissionId) => !nestedPermissionIds.includes(permissionId)
                                    );

                                    // Update checkboxes for all permissions
                                    for (const permissionId of nestedPermissionIds) {
                                        const checkbox = document.getElementById(`nested_permission_checkbox_${nestedRoleName}_${permissionId}`);
                                        if (checkbox) {
                                            checkbox.checked = false;
                                        }
                                    }
                                }
                            }
                            const isAnyRoleFromCategorySelected = category.roles.some((r) => this.selectedRoles.includes(r.name));
                            const categoryPermissionId = category.permissionId;
                            if (categoryPermissionId && !isAnyRoleFromCategorySelected) {
                                const categoryPermissionIndex = this.selectedPermissions.indexOf(categoryPermissionId);
                                if (categoryPermissionIndex !== -1) {
                                    this.selectedPermissions.splice(categoryPermissionIndex, 1);
                                }
                            }
                        } else {
                            // Role is not selected, so select it
                            this.selectedRoles.push(roleName);

                            // Select all permissions associated with this role (including nested permissions)
                            const selectPermissions = (permissions) => {
                                for (const permission of permissions) {
                                    const uniquePermissionIds = new Set(this.selectedPermissions);

                                    // Add the current permission ID
                                    uniquePermissionIds.add(permission.id);

                                    // Update selectedPermissions with the unique IDs
                                    this.selectedPermissions = Array.from(uniquePermissionIds);

                                    // this.selectedPermissions.push(permission.id);

                                    // Update checkboxes for all permissions
                                    for (const permissionId of permissionIds) {
                                        const checkbox = document.getElementById(`permission_checkbox_${roleName}_${permissionId}`);
                                        if (checkbox) {
                                            checkbox.checked = true;
                                        }
                                    }

                                    if (permission.nestedRoles && permission.nestedRoles.length > 0) {
                                        selectPermissions(permission.nestedRoles);
                                    }
                                }
                            };

                            const permissionIds = role.permissions.map((permission) => permission.id);
                            selectPermissions(role.permissions);

                            // Select nested roles (if any)
                            if (role.nestedRoles && role.nestedRoles.length > 0) {
                                for (const nestedRole of role.nestedRoles) {
                                    const nestedRoleName = nestedRole.name;
                                    if (!this.selectedRoles.includes(nestedRoleName)) {
                                        this.selectedRoles.push(nestedRoleName);
                                        const nestedRoleCheckbox = document.getElementById(`nestedrole_checkbox_${nestedRoleName}`);
                                        if (nestedRoleCheckbox) {
                                            nestedRoleCheckbox.checked = true;
                                        }
                                        // Select permissions associated with the nested role and its nested roles
                                        const nestedPermissionIds = [];
                                        const collectNestedPermissionIds = (permissions) => {
                                            for (const permission of permissions) {
                                                nestedPermissionIds.push(permission.id);
                                                if (permission.nestedRoles && permission.nestedRoles.length > 0) {
                                                    collectNestedPermissionIds(permission.nestedRoles);
                                                }
                                            }
                                        };
                                        collectNestedPermissionIds(nestedRole.permissions);

                                        this.selectedPermissions = [...this.selectedPermissions, ...nestedPermissionIds];

                                        // Update checkboxes for all permissions
                                        for (const permissionId of nestedPermissionIds) {
                                            const checkbox = document.getElementById(`nested_permission_checkbox_${nestedRoleName}_${permissionId}`);
                                            if (checkbox) {
                                                checkbox.checked = true;
                                            }
                                        }
                                    }
                                }
                            }
                            const isAnyRoleFromCategorySelected = category.roles.some((r) =>
                                this.selectedRoles.includes(r.name)
                            );

                            // Add or remove the category's permission ID based on whether any role is selected
                            const categoryPermissionId = category.permissionId;
                            if (categoryPermissionId) {
                                if (isAnyRoleFromCategorySelected && !this.selectedPermissions.includes(categoryPermissionId)) {
                                    this.selectedPermissions.push(categoryPermissionId);
                                } else if (!isAnyRoleFromCategorySelected) {
                                    const categoryPermissionIndex = this.selectedPermissions.indexOf(categoryPermissionId);
                                    if (categoryPermissionIndex !== -1) {
                                        this.selectedPermissions.splice(categoryPermissionIndex, 1);
                                    }
                                }
                            }
                        }
                        break; // Exit the loop since we found the role
                    }
                }
            }

            console.log('Selected Roles:', this.selectedRoles);
            console.log('Selected Permissions:', this.selectedPermissions);

            // Emit data to the parent component
            this.passDataToParent();
        },


        toggleNestedPermission(roleName, nestedRoleName, permissionId) {
            console.log('Selected Role:', roleName);
            console.log('Selected Nested Role:', nestedRoleName);
            console.log('Selected Nested Permission:', permissionId);
            let anyNestedPermissionSelected = false;

            // Find the category containing roles
            for (const category of this.hierarchicalData) {
                // Find the specific role within the category's roles
                for (const role of category.roles) {
                    if (role.name === roleName) {
                        // Check if the current role has nested roles
                        if (role.nestedRoles && role.nestedRoles.length > 0) {
                            // Find the nested role within the current role's nested roles
                            for (const nestedRole of role.nestedRoles) {
                                if (nestedRole.name === nestedRoleName) {
                                    // Find the specific permission within the nested role's permissions
                                    const permission = nestedRole.permissions.find((perm) => perm.id === permissionId);

                                    if (permission) {
                                        // Check if the permission is already selected
                                        const isSelected = this.selectedPermissions.includes(permissionId);

                                        // Toggle the selectedPermissions array
                                        if (isSelected) {
                                            // Permission is already selected, remove it
                                            const index = this.selectedPermissions.indexOf(permissionId);
                                            if (index !== -1) {
                                                this.selectedPermissions.splice(index, 1);
                                            }

                                            // Uncheck the corresponding checkbox in the DOM
                                            const checkbox = document.getElementById(`permission_checkbox_${nestedRoleName}_${permissionId}`);
                                            if (checkbox) {
                                                checkbox.checked = false;
                                            }

                                            // Check if all permissions of the role are now selected
                                            const allPermissionsSelected = nestedRole.permissions.every(
                                                (perm) => this.selectedPermissions.includes(perm.id)
                                            );

                                            // If not all permissions are selected, deselect the role
                                            if (!allPermissionsSelected) {
                                                const roleIndex = this.selectedRoles.indexOf(roleName);
                                                if (roleIndex !== -1) {
                                                    this.selectedRoles.splice(roleIndex, 1);
                                                    const nestedRoleCheckbox = document.getElementById(`nestedrole_checkbox_${nestedRoleName}`);
                                                    if (nestedRoleCheckbox) {
                                                        nestedRoleCheckbox.checked = false;
                                                    }
                                                }
                                            }

                                                                                        const anyNestedRolePermissionSelected = category.roles.some((existingRole) =>
                                                existingRole.nestedRoles && existingRole.nestedRoles.length > 0
                                                    ? existingRole.nestedRoles.some((nestedRole) =>
                                                          this.selectedRoles.includes(nestedRole.name) && nestedRole.permissions.some((permission) =>
                                                              this.selectedPermissions.includes(permission.id)
                                                          )
                                                      )
                                                    : false
                                            );


                                            // Check if any permissions of the current role are selected
                                            const anyRolePermissionsSelected = nestedRole.permissions.some((permission) =>
                                                this.selectedPermissions.includes(permission.id)
                                            );
                                            console.log(anyRolePermissionsSelected);
                                            // If no nested role permissions are selected and no permissions of the current role are selected, deselect parent role and category permission
                                            if (!anyRolePermissionsSelected) {

                                                const parentRole = role; // Assuming parent role is the immediate role
                                        if (parentRole.permissions && parentRole.permissions.length > 0) {
                                            const firstPermissionId = parentRole.permissions[0].id;
                                            if (firstPermissionId && this.selectedPermissions.includes(firstPermissionId)) {
                                                const firstPermissionIndex = this.selectedPermissions.indexOf(firstPermissionId);
                                                this.selectedPermissions.splice(firstPermissionIndex, 1);
                                                const firstPermissionCheckbox = document.getElementById(`permission_checkbox_${roleName}_${firstPermissionId}`);
                                                if (firstPermissionCheckbox) {
                                                    firstPermissionCheckbox.checked = false;
                                                }
                                            }
                                        }

                                                // Also, unselect the category's permission ID
                                                const categoryPermissionId = category.permissionId;
                                                if (categoryPermissionId && this.selectedPermissions.includes(categoryPermissionId)) {
                                                    const categoryPermissionIndex = this.selectedPermissions.indexOf(categoryPermissionId);
                                                    this.selectedPermissions.splice(categoryPermissionIndex, 1);
                                                    const categoryPermissionCheckbox = document.getElementById(`category_checkbox_${category.name}`);
                                                    if (categoryPermissionCheckbox) {
                                                        categoryPermissionCheckbox.checked = false;
                                                    }
                                                }
                                            }

                                        } else {
                                            // Permission is not selected, add it
                                            this.selectedPermissions.push(permissionId);

                                            // Check the corresponding checkbox in the DOM
                                            const checkbox = document.getElementById(`nested_permission_checkbox_${nestedRoleName}_${permissionId}`);
                                            if (checkbox) {
                                                checkbox.checked = true;
                                            }

                                            // Check if all permissions of the role are now selected
                                            const allPermissionsSelected = nestedRole.permissions.every(
                                                (perm) => this.selectedPermissions.includes(perm.id)
                                            );

                                            // If all permissions are selected, select the role
                                            if (allPermissionsSelected && !this.selectedRoles.includes(roleName)) {
                                                this.selectedRoles.push(roleName);
                                                const nestedRoleCheckbox = document.getElementById(`nestedrole_checkbox_${nestedRoleName}`);
                                                if (nestedRoleCheckbox) {
                                                    nestedRoleCheckbox.checked = true;
                                                }
                                            }
                                                  // Now, select the first permission of the parent role
                                        const parentRole = role; // Assuming parent role is the immediate role
                                        if (parentRole.permissions && parentRole.permissions.length > 0) {
                                            const firstPermissionId = parentRole.permissions[0].id;
                                            if (firstPermissionId && !this.selectedPermissions.includes(firstPermissionId)) {
                                                this.selectedPermissions.push(firstPermissionId);
                                                const firstPermissionCheckbox = document.getElementById(`nested_permission_checkbox_${nestedRoleName}_${firstPermissionId}`);
                                                if (firstPermissionCheckbox) {
                                                    firstPermissionCheckbox.checked = true;
                                                }
                                            }
                                        }

                                        // Also, add the category's permission ID
                                        const categoryPermissionId = category.permissionId;
                                        if (categoryPermissionId && !this.selectedPermissions.includes(categoryPermissionId)) {
                                            this.selectedPermissions.push(categoryPermissionId);
                                            const categoryPermissionCheckbox = document.getElementById(`category_permission_checkbox_${category.name}_${categoryPermissionId}`);
                                            if (categoryPermissionCheckbox) {
                                                categoryPermissionCheckbox.checked = true;
                                            }
                                        }

                                        }
                                  
                                        console.log('Selected Roles:', this.selectedRoles);
                                        console.log('Selected Permissions:', this.selectedPermissions);

                                        // Emit data to the parent component
                                        this.passDataToParent();

                                        // Exit the loop since we found the role, nested role, and handled the permission
                                        return;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        },


        togglePermission(roleName, permissionId) {
            console.log('Selected Role:', roleName);
            console.log('Selected Permissionss:', permissionId);

            // Find the role within hierarchicalData
            for (const category of this.hierarchicalData) {
                for (const role of category.roles) {
                    if (role.name === roleName) {
                        // Find the specific permission within the role's permissions
                        const permission = role.permissions.find((perm) => perm.id === permissionId);

                        if (permission) {
                            // Check if the permission is already selected
                            const isSelected = this.selectedPermissions.includes(permissionId);

                            // Toggle the selectedPermissions array
                            if (isSelected) {
                                // Permission is already selected, remove it
                                const index = this.selectedPermissions.indexOf(permissionId);
                                if (index !== -1) {
                                    this.selectedPermissions.splice(index, 1);
                                }

                                // Uncheck the corresponding checkbox in the DOM
                                const checkbox = document.getElementById(`permission_checkbox_${roleName}_${permissionId}`);
                                if (checkbox) {
                                    checkbox.checked = false;
                                }

                                // Check if all permissions of the role are now selected
                                const allPermissionsSelected = role.permissions.every(
                                    (perm) => this.selectedPermissions.includes(perm.id)
                                );

                                // If not all permissions are selected, deselect the role
                                if (!allPermissionsSelected) {
                                    const roleIndex = this.selectedRoles.indexOf(roleName);
                                    if (roleIndex !== -1) {
                                        this.selectedRoles.splice(roleIndex, 1);

                                        const RoleCheckbox = document.getElementById(`role_checkbox_${roleName}`);
                                        if (RoleCheckbox) {
                                            RoleCheckbox.checked = false;
                                        }
                                    }
                                }
                                 // Check if any permissions of the current role are selected
                                 const anyRolePermissionsSelected = role.permissions.some((permission) =>
                                                this.selectedPermissions.includes(permission.id)
                                            );
                                            console.log(anyRolePermissionsSelected);
                                            // If no nested role permissions are selected and no permissions of the current role are selected, deselect parent role and category permission
                                            if (!anyRolePermissionsSelected) {

                                          // Also, unselect the category's permission ID
                                                const categoryPermissionId = category.permissionId;
                                                if (categoryPermissionId && this.selectedPermissions.includes(categoryPermissionId)) {
                                                    
                                                    const categoryPermissionIndex = this.selectedPermissions.indexOf(categoryPermissionId);
                                                    console.log(categoryPermissionIndex);
                                                    this.selectedPermissions.splice(categoryPermissionIndex, 1);
                                                    const categoryPermissionCheckbox = document.getElementById(`category_checkbox_${category.name}`);
                                                    if (categoryPermissionCheckbox) {
                                                        categoryPermissionCheckbox.checked = false;
                                                    }
                                                }
                                            }
                            } else {
                                // Permission is not selected, add it
                                this.selectedPermissions.push(permissionId);

                                // Check the corresponding checkbox in the DOM
                                const checkbox = document.getElementById(`permission_checkbox_${roleName}_${permissionId}`);
                                if (checkbox) {
                                    checkbox.checked = true;
                                }

                                // Check if all permissions of the role are now selected
                                const allPermissionsSelected = role.permissions.every(
                                    (perm) => this.selectedPermissions.includes(perm.id)
                                );

                                // If all permissions are selected, select the role
                                if (allPermissionsSelected && !this.selectedRoles.includes(roleName)) {
                                    this.selectedRoles.push(roleName);
                                    const RoleCheckbox = document.getElementById(`role_checkbox_${roleName}`);
                                    if (RoleCheckbox) {
                                        RoleCheckbox.checked = true;
                                    }
                                }
                                const categoryPermissionId = category.permissionId;
                            if (categoryPermissionId && !this.selectedPermissions.includes(categoryPermissionId)) {
                                this.selectedPermissions.push(categoryPermissionId);
                                const categoryPermissionCheckbox = document.getElementById(`category_checkbox_${category.name}_${categoryPermissionId}`);
                                if (categoryPermissionCheckbox) {
                                    categoryPermissionCheckbox.checked = true;
                                }
                            }
                            }
                      
                        
                            console.log('Selected Roles:', this.selectedRoles);
                            console.log('Selected Permissions:', this.selectedPermissions);

                            // Emit data to the parent component
                            this.passDataToParent();

                            // Exit the loop since we found the role and handled the permission
                            return;
                        }
                    }
                }
            }
        },







        passDataToParent() {
            // Emit a custom event with the selectedPermissions and selectedRoles data
            this.$emit('pass-data', {
                selectedPermissions: this.selectedPermissions,
                selectedRoles: this.selectedRoles,

            });

        },


        fetchDatas() {
            axios.get('./all-roles-and-permissions')
                .then(response => {
                    const data = response.data.data.type; // Assuming the response structure matches what you provided
                    const categorypermission = response.data.data.categoryPermissions; // Assuming the response structure matches what you provided
                    console.log(categorypermission)
                    // Create a hierarchical data structure to nest roles with shared permissions
                    const hierarchicalData = [];

                    for (const categoryName in data) {
                        if (data.hasOwnProperty(categoryName)) {
                            const categoryRoles = data[categoryName];

                            // Initialize the category with an empty roles array
                            const category = {
                                name: categoryName,
                                roles: [],
                                permissionId: null, // Initialize with null
                            };

                            hierarchicalData.push(category);

                            // Helper function to check if a role's permissions include a specific permission
                            const includesPermission = (role, permission) => {
                                return role.permissions.some(rolePermission => rolePermission.id === permission.id);
                            };

                            categoryRoles.forEach(role => {
                                let nested = false;

                                // Check if the role has any permissions that are already in nested roles
                                category.roles.forEach(existingRole => {
                                    if (role.permissions.some(permission => includesPermission(existingRole, permission))) {
                                        if (!existingRole.nestedRoles) {
                                            existingRole.nestedRoles = [];
                                        }
                                        existingRole.nestedRoles.push(role);
                                        nested = true;
                                    }
                                });

                                // If not nested, add the role as a top-level role within the category
                                if (!nested) {
                                    category.roles.push(role);
                                }

                                // Add one permission that is one less than the first role permission ID
                                // if (role.permissions.length > 0 && category.permissionId === null) {
                                //     const firstPermissionId = role.permissions[0].id;
                                //     console.log(firstPermissionId);
                                //     category.permissionId = firstPermissionId - 1;
                                // }
                                const matchingPermission = categorypermission.find(permission => permission.name === categoryName);
                                if (matchingPermission && category.permissionId === null) {
                                    category.permissionId = matchingPermission.id;
                                }

                            });
                        }
                    }

                    this.hierarchicalData = hierarchicalData;
                    console.log('hdata', hierarchicalData);
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        },



        isAccordionExpanded(categoryName) {
            // Check if the accordion is expanded based on its state
            return this.selectedAccordion === categoryName;
        },
        isAccordionOpen(targetId) {
            return this.openAccordion === targetId;
        },
        toggleCategoryAccordion(categoryName) {
    //         if (this.activeCategory === categoryName) {
    //     // If the clicked category is already active, close it
    //     this.activeCategory = null;
    //   } else {
    //     // Close the previously active category (if any) and open the clicked one
    //     this.activeCategory = categoryName;
    //   }
            // Toggle the selected accordion based on its current state
            // if (this.selectedAccordion === categoryName) {
            //     this.selectedAccordion = null;
            // } else {
            //     this.selectedAccordion = categoryName;
            // }
        },
        // toggleCategoryAccordion(categoryname) {
        //     // Get the HTML element of the accordion
        //     // console.log(roleName);

        //     const accordionElement = document.getElementById(`accordion_${roleName}`);

        //     if (accordionElement) {
        //         // Check if the accordion is currently collapsed
        //         const isCollapsed = accordionElement.classList.contains('collapse');

        //         // Toggle the accordion state
        //         if (isCollapsed) {
        //             accordionElement.classList.remove('collapse');
        //         } else {
        //             accordionElement.classList.add('collapse');
        //         }
        //     }
        // },
        toggleAccordion(roleName) {
            // Get the HTML element of the accordion
            // console.log(roleName);

            const accordionElement = document.getElementById(`accordion_${roleName}`);

            if (accordionElement) {
                // Check if the accordion is currently collapsed
                const isCollapsed = accordionElement.classList.contains('collapse');

                // Toggle the accordion state
                if (isCollapsed) {
                    accordionElement.classList.remove('collapse');
                } else {
                    accordionElement.classList.add('collapse');
                }
            }
        },
        updateData() {
            // console.log('parent',data);

            this.$on('update-data', (data) => {
                // Update selectedRoles and selectedPermissions with the received data
                this.selectedRoles = data.roleNameToUpdate;
                this.selectedPermissions = data.permissionsToUpdate;
                console.log('roles', this.selectedRoles, 'permission', this.selectedPermissions)

            });
            // Receive updated data from the child component
            // this.selectedPermissions = data.permissionsToUpdate;
            // this.selectedPermissions = data.permissionsToUpdate;
            // this.permissionsToUpdate = data.permissionsToUpdate;
            // this.roleNameToUpdate = data.roleNameToUpdate;

            // console.log( 'SSSroles',this.Showroles, 'SSSpermission',this.Showpermissions)
            console.log('uuroles', this.selectedRoles, 'uupermission', this.selectedPermissions)
        },
    },

    mounted() {

        EventBus.$on('update-data', (data) => {
            // Update selectedRoles and selectedPermissions with the received data
            this.selectedRoles = data.roleNameToUpdate;
            //   this.selectedPermissions = data.permissionsToUpdate;
            this.selectedPermissions = [...data.permissionsToUpdate];
            this.nestedPermissions = [...data.permissionsToUpdate];
            // Vue.set(this.selectedPermissions, 'selectedPermissions', data.permissionsToUpdate);
            console.log('roles', this.selectedRoles, 'permission', this.selectedPermissions);


        });

        setTimeout(() => {
            console.log('preeeee', this.selectedPermissions);
        }, 2000)
        this.fetchDatas();
        this.passDataToParent();
    }
}


</script>
<style scoped>


.attractive-span {
    display: inline-block;
    padding: 5px 10px;
    /* background-color: #ff6b6b; */
    color: #0f0707;
    /* Text color */
    border-radius: 5px;
    /* Rounded corners */
    /* box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2); */
    /* Drop shadow */
    font-weight: bold;
}

.nested-span {
    display: inline-block;
    padding: 5px 10px;
    /* background-color: #f4a1a1;  */
    color: #100808;
    /* Text color */
    border-radius: 5px;
    /* Rounded corners */
    /* box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2); */
    /* Drop shadow */
    font-weight: bold;
}

.sub-role-label {
    /* Add your preferred styles here */
    color: #8bb5e3;
    /* Adjust the color to make it lighter */
    font-size: 1rem;
    /* Adjust the font size as needed */
    /* Add more styles as desired */
}
.accordion-shadow{
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
}
.category-name{
    font-weight: bold;
     color: #000000;
     cursor: pointer;
}
.role-accordion{
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.2); 
    background-color: #a1adf6; 
    border-radius: 10px;
}
.role-name{
    font-weight: bold; color: #ffffff; cursor: pointer;
}
.role-button{
    border: none; background-color: #a1adf6; color: white;
}
.nextedrole-accordion{
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.2); background-color: #aeb4dc;  border-radius: 10px;
}
.nestedrole-name{
    font-weight: bold; color: #fbfbfb; cursor: pointer;
}
.nestedrole-button{
    border: none;
     background-color: #aeb4dc;
     color: white;
}
.nestedrolepermission{
    font-weight: bold; color: #666; cursor: pointer;
}
.rolepermision{
    font-weight: bold; color: #666; cursor: pointer;
}
/* @keyframes clickEffect {
  0% {
    transform: scale(1);
  }
  50% {
    transform: scale(0.9);
  }
  100% {
    transform: scale(1);
  } */
/* } */
</style>