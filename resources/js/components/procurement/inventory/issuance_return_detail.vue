<template>
    <div>
        <!-- BEGIN: Content-->
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="-tem-change"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <router-link to="/accounts" style="text-decoration: none;">Accounts Dashboard</router-link>
                            </li>
                            <li class="breadcrumb-item active">
                                Issuance Return
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="content-body">
                    <!-- users list start -->
                    <section class="app-user-list">
                        <div clas="card" style="background-color:white !important">
                            <div class="card-body border-bottom">
                                <h4 class="card-title">Search & Filter</h4>
                                <div class="row">
                                    <div class="col-md-3 user_role">
                                        <label class="form-label">Department / Child Company</label>
                                        <select v-model="department" class="form-select mb-md-0 mb-2">
                                            <option value="All">All Depts and Child Companies</option>
                                            <option v-for='departments1 in departments' :value='departments1.COmpanyName'>{{ departments1.COmpanyName }}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 user_plan">
                                        <label class="form-label" for="UserPlan">Project</label>
                                        <select v-model="project" id="UserPlan" class="form-select mb-md-0 mb-2">
                                            <option value="All">All Projects</option>
                                            <option v-for='projects1 in projects' :value='projects1.ProjectName'>{{ projects1.ProjectName }}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 col-12 mb-2 position-relative">
                                        <label class="form-label">Date From</label>
                                        <input type="date" v-model="startingdate" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="col-md-2 col-12 mb-3 position-relative">
                                        <label class="form-label">Date To</label>
                                        <input type="date" class="form-control" v-model="closingdate" placeholder="" required="">
                                    </div>
                                    <div class="col-md-2 user_status" style="padding-top:26px">
                                        <button @click="filter_issuance_rtn()"  style="background:#c1c1c1;width:100%;height: 35px !important;margin-bottom:20px;width: 60% !important;" class="btn btn-common">Search</button>
                                    </div>
                                </div>
                            </div>
                            <div style="margin-bottom:20px;" class="d-flex justify-content-between align-items-center header-actions mx-2 row mt-75">
                                <div class="col-sm-12 col-lg-12 ps-xl-75 ps-0">
                                    <div class="dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap">
                                        <div class="me-1">
                                            <div class="dataTables_filter" style="margin-top:5px">
                                                <label>
                                                    <input autocomplete="off" type="text" name="keyword1" v-model="keyword1" class="form-control" placeholder="Search By Department" />
                                                </label>
                                            </div>
                                        </div>
                                        <div class="dt-buttons d-inline-flex mt-50">
                                            <router-link   v-if="hasPermission('Inventory Issuance-return create-issuance-return') " to="/Inventory/Issuance_return/create" class="dt-button add-new btn btn-primary" tabindex="0" type="button"><span>New Issuance Return</span></router-link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive" style="overflow-x: initial !important;">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Date</th>
                                            <th>Department</th>
                                            <th>Project Name</th>
                                            <th>Against Iss.</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="odd" v-for="adsdata1 in adsdata.data">
                                            <td style="vertical-align: middle !important;">{{adsdata1.IRtnID}}</td>
                                            <td class="sorting_1">{{adsdata1.Dated}} </td>
                                            <td class="sorting_1">{{adsdata1.DepartmentName}}</td>
                                            <td style="">{{adsdata1.ProjectName}}</td>
                                            <td>{{adsdata1.IssuanceCode}}</td>
                                            <td>
                                                <span v-if="adsdata1.Status2=='Partially Returned'" class="badge badge-glow bg-primary">Partially Returned</span>
                                                <span v-else class="badge badge-glow bg-success">Fully Returned</span>
                                            </td>
                                            <td style="vertical-align: middle !important;">
                                                <a  v-if="hasPermission('Inventory Issuance-return view-issuance-return') " class="me-25" @click="get_issuancebyid(adsdata1.IssuenceReturnID)" data-bs-toggle="modal" data-bs-target="#viewGRN">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>
                                                <a  v-if="hasPermission('Inventory Issuance-return print-issuance-return') " target="_blank" v-bind:href="`Accounts/issuance_return_letter/${adsdata1.IssuenceReturnID}/${adsdata1.IRtnID}`"  class="btn btn-sm">
                                                  <i class="fa-solid fa-print"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div style="text-align:center;padding-top:20px">
                                <pagination :data="adsdata" @pagination-change-page="getResult"></pagination>
                            </div>
                        </div>
                    </section>
                    <!-- users list ends -->
                </div>
            </div>
        </div>
        <!-- END: Content-->

        <!-- END: Content-->
        <div class="modal fade" id="viewGRN" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-5 px-sm-5 pt-50">
                        <div class="text-center mb-2">
                            <center>
                                <div class="col-md-12" v-for="issuance_data1 in issuance_data">
                                    <table style="width:100%;">
                                        <thead style="float:left; width:100%;">
                                            <h2 style="text-align:center;"> Details of Issuance</h2>
                                            <tr>
                                                <th style="width:25%;">Issuance ID: </th>
                                                <td style="width:25%;">{{issuance_data1.IssuanceId}}</td>
                                                <th style="width:25%;">Issuance Code: </th>
                                                <td style="width:25%;">{{issuance_data1.IssuanceCode}}</td>
                                            </tr>
                                            <tr>
                                                <th>Department name: </th>
                                                <td>{{issuance_data1.DepartmentName}}</td>
                                                <th>Project name: </th>
                                                <td>{{issuance_data1.ProjectName}}</td>
                                            </tr>
                                            <tr>
                                                <th>Requisition ID: </th>
                                                <td>{{issuance_data1.RequisitionId}}</td>
                                                <th>Status: </th>
                                                <td>
                                                    <span v-if="issuance_data1.Status=='Fully Delivered'" class="badge badge-glow bg-success">Fully Delivered</span>
                                                    <span v-else class="badge badge-glow bg-secondary">Not Delivered</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Created By: </th>
                                                <td>{{issuance_data1.CreatedBy}}</td>
                                                <th>Created On: </th>
                                                <td>{{issuance_data1.CreatedOn}}</td>
                                            </tr>
                                            <tr>
                                                <th>Updated By: </th>
                                                <td>{{issuance_data1.UpdatedBy}}</td>
                                                <th>Updated On: </th>
                                                <td>{{issuance_data1.UpdatedOn}}</td>
                                            </tr>
                                            <tr>
                                                <th>Date: </th>
                                                <td>{{issuance_data1.IssuanceDate}}</td>
                                                <th>Session: </th>
                                                <td>{{issuance_data1.Session}}</td>
                                            </tr>
                                            <tr>
                                                <th>Narration: </th>
                                                <td colspan="3">{{issuance_data1.Narration}}</td>
                                            </tr>
                                        </thead>
                                    </table>

                                    <table class="table">
                                        <thead>
                                            <h4>Issuance Items</h4>
                                            <tr>
                                                <th>Item ID</th>
                                                <th>Item Name</th>
                                                <th>Return Quantity</th>
                                                <th>Unit</th>
                                                <th>Issuance Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="issuance_items1 in issuance_items">
                                                <td>{{issuance_items1.ItemId}}</td>
                                                <td>{{issuance_items1.ItemName}}</td>
                                                <td>{{Number(issuance_items1.ReturnQuantity)}}</td>
                                                <td>{{issuance_items1.unit}}</td>
                                                <td>{{Number(issuance_items1.IssuanceQuantity)}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-12 text-center">
                                    <button type="reset" class="btn btn-outline-secondary mt-2" data-bs-dismiss="modal" aria-label="Close">
                                        Close
                                    </button>
                                </div>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                adsdata: {},

                keyword1: '',
                closingdate: '',
                startingdate: '',
                department: 'All',
                project: 'All',

                projects: {},
                locations: {},
                departments: {},
                issuance_data: {},
                issuance_items: {},

            }
        },
        watch: {
            keyword1(after, before) {
                this.getResults();
            }
        },
        methods: {
            filter_issuance_rtn(page = 1) {
                this.keyword1 = '';
                if (this.startingdate == '') {
                    this.startingdate1 = "00-00-0000";
                }
                else {
                    this.startingdate1 = this.startingdate;
                }
                if (this.closingdate == '') {
                    this.closingdate1 = "99-99-9999";
                }
                else {
                    this.closingdate1 = this.closingdate;
                }
                axios.get('./searchissuanceRtn/' + this.department + '/' + this.project + '/' + this.startingdate1 + '/' + this.closingdate1 + '?page=' + page)
                    .then(data => this.adsdata = data.data)
                    .catch(error => this.error = error.response.data.errors)
            },
            getResult(page=1) {
                axios.get('accounts/issuance_returns/?page=' + page)
                    .then(response => this.adsdata = response.data)
                    .catch(error => { });


                axios.get('accounts/get_childcompany')
                    .then(response => this.departments = response.data)
                    .catch(error => { });

                axios.get('accounts/get_allprojects')
                    .then(response => this.projects = response.data)
                    .catch(error => { });

            },
            get_issuancebyid(id){
                axios.get('accounts/get_issuancereturn/'+id)
                    .then(response => this.issuance_data = response.data)
                    .catch(error => { });
                axios.get('accounts/get_issuancereturn1/'+id)
                    .then(response => this.issuance_items = response.data)
                    .catch(error => { });
            },
            getResults(page = 1) {
                this.department = 'All';
                this.project = 'All';
                this.startingdate = '';
                this.closingdate = '';

                axios.get('./accounts_issRtnByDepartment/?page=' + page, { params: { dept: this.keyword1 } })
                    .then(response => this.adsdata = response.data)
                    .catch(error => { });
            },
        },
        mounted() {
            this.getResult();
        }
    }

</script>
