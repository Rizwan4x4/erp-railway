<template>
    <div>
        <!-- BEGIN: Content-->
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow-tem-change"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <router-link to="/accounts" style="text-decoration: none;">Accounts Dashboard</router-link>
                            </li>
                            <li class="breadcrumb-item active">
                                Assets Detail
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="content-body">
                    <!-- users list start -->
                    <section class="app-user-list">
                        <div class="row">
                            <div class="col-lg-4 col-sm-12">
                                <div class="card">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div>
                                            <h3 class="fw-bolder mb-75">{{ count_users.total }}</h3>
                                            <span>Total Assets</span>
                                        </div>
                                        <div class="avatar bg-light-primary p-50">
                                            <span class="avatar-content">
                                                <i class="fa-solid fa-users"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-12">
                                <div class="card">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div>
                                            <h3 class="fw-bolder mb-75">{{ count_users.fully }}</h3>
                                            <span>Assigned Assets</span>
                                        </div>
                                        <div class="avatar bg-light-success p-50">
                                            <span class="avatar-content">
                                                <i class="fa-solid fa-user-shield"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-12">
                                <div class="card">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div>
                                            <h3 class="fw-bolder mb-75">{{ count_users.partially }}</h3>
                                            <span>Available Assets</span>
                                        </div>
                                        <div class="avatar bg-light-warning p-50">
                                            <span class="avatar-content">
                                                <i class="fa-solid fa-user-large-slash"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card" style="background-color:white !important">
                            <div class="card-body border-bottom">
                                <h4 class="card-title">Search & Filter</h4>
                                <div class="row">
                                    <div class="col-md-3 user_role">
                                        <label class="form-label" for="UserRole">Category Name</label>
                                        <select id="UserRole" v-model="category" class="form-select mb-md-0 mb-2">
                                            <option value="all" selected>All Categories </option>
                                            <option :value="category" v-for="category in allCategory">{{ category }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 user_status">
                                        <label class="form-label" for="UserRole">By Name</label>
                                        <div class="dataTables_filter" style="">
                                            <label>
                                                <input autocomplete="off" type="text" name="keyword1" v-model="keyword1"
                                                    class="form-control" style="" placeholder="Search By Name" />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 user_status" style="padding-top: 20px;">

                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive" style="overflow-x: initial !important;">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center; vertical-align:middle !important;">Unique Id</th>
                                            <th style="vertical-align:middle !important;">Asset Name</th>
                                            <th style="vertical-align:middle !important;">Serial Number</th>
                                            <th style="text-align:center; vertical-align:middle !important;">Category Name
                                            </th>
                                            <th style="text-align:center; vertical-align:middle !important;">
                                                Availabe<br />Quantity</th>

                                            <th style="text-align: center; vertical-align: middle !important;">Barcode</th>
                                            <th style="text-align:center; vertical-align:middle !important;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="odd" v-for="adsdata1 in filterData">
                                            <td class=" control" tabindex="0" style="text-align:center;">
                                                {{ adsdata1.AssetsUniqueID }}</td>
                                            <td class=" control" tabindex="0">{{ adsdata1.Name }}</td>
                                            <td class=" control" tabindex="0">{{ adsdata1.SrNumber }}</td>
                                            <td class=" control" tabindex="0" style="text-align:center;">
                                                {{ adsdata1.CategoryName }}</td>
                                            <td class=" control" tabindex="0" style="text-align:center;">{{ adsdata1.Qty }}
                                            </td>

                                            <td>
                                                <barcode :value="'www./' + adsdata1.AssetsUniqueID" :formet="pharmacode"
                                                    :displayValue="false" :width="0.7" :height="30">
                                                    No barcode available
                                                </barcode>
                                            </td>
                                            <td class=" control" tabindex="0" style="text-align:center;">
                                                <div class="d-flex align-items-center col-actions">
                                                    <a v-if="hasPermission('Inventory Assets view-asset') " @click="getitemdata(adsdata1.AssetsUniqueID)" class="me-25"
                                                        data-bs-toggle="modal" data-bs-target="#viewstock">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </a>
                                                    <div class="btn-group" v-if="hasPermission('Inventory Assets actions') ">
                                                        <a   data-bs-toggle="dropdown"
                                                            class="btn btn-sm dropdown-toggle hide-arrow"><svg
                                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                class="feather feather-more-vertical font-small-4">
                                                                <circle cx="12" cy="12" r="1"></circle>
                                                                <circle cx="12" cy="5" r="1"></circle>
                                                                <circle cx="12" cy="19" r="1"></circle>
                                                            </svg></a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a v-if="adsdata1.Qty == 1 && adsdata1.IsRetired == null"
                                                                @click="fetch_asset(adsdata1.AssetsUniqueID)"
                                                                data-bs-toggle="modal" data-bs-target="#payloan"
                                                                class="dropdown-item">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                    height="16" fill="currentColor" viewBox="0 0 16 16"
                                                                    class="bi bi-eye">
                                                                    <path
                                                                        d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z">
                                                                    </path>
                                                                    <path
                                                                        d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z">
                                                                    </path>
                                                                </svg>
                                                                Assign Asset
                                                            </a>
                                                            <a v-if="adsdata1.Qty == 0 && adsdata1.IsRetired == null"
                                                                @click="fetch_asset(adsdata1.AssetsUniqueID)"
                                                                data-bs-toggle="modal" data-bs-target="#payloan1"
                                                                class="dropdown-item">
                                                                <i data-feather='arrow-up-left'></i>
                                                                Return Asset
                                                            </a>
                                                            <a target="_blank"
                                                                v-if="adsdata1.Qty == 0 && adsdata1.IsRetired == null"
                                                                v-bind:href="`Accounts/asset_assignletter/${adsdata1.AssetsUniqueID}`"
                                                                class="dropdown-item"><i
                                                                    class="fa-solid fa-print"></i>Assign Letter</a>

                                                            <a v-if="adsdata1.Qty == 1 && adsdata1.IsRetired == null"
                                                                @click="fetch_asset(adsdata1.AssetsUniqueID)"
                                                                data-bs-toggle="modal" data-bs-target="#editAsset"
                                                                class="dropdown-item">
                                                                <i class="fas fa-edit"></i>
                                                                Edit Asset
                                                            </a>
                                                            <a v-if="adsdata1.IsRetired != null" class="dropdown-item">
                                                                <i class="fas fa-circle-xmark"></i>
                                                                Asset Retired
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div style="text-align:center;padding-top:20px">
                            </div>
                        </div>
                    </section>
                    <!-- users list ends -->
                </div>
                <div class="modal fade" id="viewstock" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                        <div class="modal-content">
                            <div class="modal-header bg-transparent">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="col-xl-12 col-md-12 col-12">
                                <div class="card invoice-preview-card">
                                    <div class="card-body invoice-padding pb-0">
                                        <barcode :value="'www.google.com.com/' + this.asset_asset_code" :displayValue="false"
                                            :width="1" :height="40">
                                            No barcode available
                                        </barcode>


                                    </div>
                                    <div class="divider">
                                        <div class="divider-text" style="font-size: 24px;font-weight: 900;">Assets Overall
                                            Detail</div>
                                    </div>
                                    <!-- Address and Contact ends -->
                                    <!-- Invoice Description starts -->
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th class="py-1">Date</th>
                                                    <th class="py-1">Item Name</th>
                                                    <th class="py-1">Category</th>
                                                    <th class="py-1">Quantity</th>
                                                    <th class="py-1">Unit</th>
                                                    <th class="py-1">Reference</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="getitemwise1 in getitemwise">
                                                    <td class="py-1">
                                                        <span class="fw-bold">{{ getitemwise1.Dated }}</span>
                                                    </td>
                                                    <td class="py-1">
                                                        <span class="fw-bold">{{ getitemwise1.Name }}</span>
                                                    </td>
                                                    <td class="py-1">
                                                        <span class="fw-bold">{{ getitemwise1.CategoryName }}</span>
                                                    </td>
                                                    <td class="py-1">
                                                        <span class="fw-bold">{{ getitemwise1.Quantity }}</span>
                                                    </td>
                                                    <td class="py-1">
                                                        <span class="fw-bold">{{ getitemwise1.Unit }}</span>
                                                    </td>
                                                    <td class="py-1">
                                                        <p class="card-text fw-bold mb-25">{{ getitemwise1.Reference }}</p>

                                                    </td>
                                                </tr>
                                                <tr></tr>
                                                <tr v-if="depreciation_list != []"
                                                    v-for="depreciation_list1 in depreciation_list">
                                                    <td class="py-1">
                                                        <span class="fw-bold">Depreciation StartingDate:
                                                            {{ depreciation_list1.StartingDate }}</span>
                                                    </td>
                                                    <td class="py-1">
                                                        <span class="fw-bold">Depreciation Method:
                                                            {{ depreciation_list1.Methods }}</span>
                                                    </td>
                                                    <td class="py-1">
                                                        <span class="fw-bold">Depreciation Closing Date:
                                                            {{ depreciation_list1.ClosingDate }}</span>
                                                    </td>
                                                    <td class="py-1">
                                                        <span class="fw-bold">Starting Value:
                                                            {{ Number(depreciation_list1.StartingValue) }}</span>
                                                    </td>
                                                    <td class="py-1">
                                                        <span class="fw-bold">Closing Value:
                                                            {{ Number(depreciation_list1.ClosingValue) }}</span>
                                                    </td>

                                                    <td class="py-1">
                                                        <span class="fw-bold">Status: {{ depreciation_list1.Status }}</span>
                                                    </td>


                                                </tr>
                                                <tr v-if="retirement_list != []" v-for="retirement_list1 in retirement_list">
                                                    <td class="py-1">
                                                        <span class="fw-bold">Retirement Date:
                                                            {{ retirement_list1.RetirementDate.substr(0, 10) }}</span>
                                                    </td>
                                                    <td class="py-1">
                                                        <span class="fw-bold">Retirement Type:
                                                            {{ retirement_list1.RetirementType }}</span>
                                                    </td>
                                                    <td class="py-1">
                                                        <span class="fw-bold">Sale Value:
                                                            {{ retirement_list1.NetValueBalance }}</span>
                                                    </td>
                                                    <td class="py-1">
                                                        <span class="fw-bold">Status: {{ retirement_list1.Status }}</span>
                                                    </td>

                                                    <td class="py-1">
                                                        <p class="card-text fw-bold mb-25">Narration:
                                                            {{ retirement_list1.Narration }}</p>

                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Content-->
        <!--/ Update Loan status Modal -->
        <!-- Pay loan Modal -->
        <div class="modal fade" id="payloan" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-5 px-sm-5 pt-50">
                        <div class="text-center mb-2">
                            <center>
                                <div class="col-md-12">
          <table style="width: 100%;">
    <thead>
        <tr>
            <th colspan="4" style="text-align: center;">
                <h2>Assign Asset To Employee</h2>
            </th>
        </tr>
        <tr>
            <th style="width: 18%;">Asset ID: </th>
            <td style="width: 25%;">{{ asset_id }}</td>
            <th style="width: 25%;">Asset Name: </th>
            <td style="width: 32%;">{{ asset_name }}</td>
        </tr>
        <tr>
            <th>Asset Category: </th>
            <td>{{ asset_category }}</td>
            <th>Purchase Cost: </th>
            <td>{{ Number(asset_cost) }}</td>
        </tr>
        <tr style="height: 30px;"></tr>
        <tr >
            <th colspan="4">
                <div style="display: flex; align-items: center;">
                    <label class="form-label" style="margin-right: 10px;">Assign To Employee</label>
                    <multiselect :show-labels="false" style="font-size: 12px;" placeholder="Select Employee"
                                 value="id" label="label" v-model="emp_emp_id" :options="options4">
                    </multiselect>
                    <label class="form-label" style="margin-left: 20px; margin-right: 10px;">Assign To Department</label>
                    <multiselect :show-labels="false" style="font-size: 12px;" id="FilterTransaction"
                                 placeholder="All Departments" v-model="emp_Dept" :options="options2">
                    </multiselect>
                    <span style="color: #DB4437; font-size: 11px;" v-if="emp_Dept==''">{{e_emp_Dept}}</span>
                </div>
            </th>
        </tr>
        <tr style="height: 10px;"></tr>
        <tr>
            <th colspan="4">
                <div style="display: flex; align-items: center;">
                    <label class="form-label" style="margin-right: 10px;">Project</label>
                    <multiselect :show-labels="false" style="font-size: 15px;" id="UserPlan"
                                 placeholder="All Locations" v-model="project" :options="options3">
                    </multiselect>
                    <label class="form-label" style="margin-left: 20px; margin-right: 10px;">Location</label>
                    <multiselect :show-labels="false" style="font-size: 15px;" id="UserPlan"
                                 placeholder="All Locations" v-model="location" :options="options1">
                    </multiselect>
                </div>
            </th>
        </tr>
        <tr>
            <th colspan="4">
            <div class="col-xl-12 mb-lg-1 col-bill-to ps-0">
                <label for="note" class="form-label fw-bold">Narration:</label>
                                                            <textarea v-model="remarks" class="form-control" rows="2" id="note"></textarea>
                                                    </div></th>
        </tr>
    </thead>
</table>


                                </div>
                                <div class="col-12 text-center">
                                    <button type="submit" :disabled="disabled2" @click="delay2()"
                                        class="btn btn-primary me-1 mt-2" data-bs-dismiss="modal" >Assign
                                        Asset</button>
                                    <button type="reset" class="btn btn-outline-secondary mt-2" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        Cancel
                                    </button>
                                </div>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pay loan Modal -->
        <div class="modal fade" id="editAsset" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-5 px-sm-5 pt-50">
                        <div class="text-center mb-2">
                            <center>
                                <div class="col-md-12">
                                    <table style="width:100%;">
                                        <thead style="float:left; width:100%;">
                                            <h2 style="text-align:center;">Edit Asset</h2>
                                            <tr>
                                                <th style="width:18%;">Asset ID: </th>
                                                <td style="width:25%;">{{ asset_id }}</td>
                                                <th style="width:25%;">Asset Name: </th>
                                                <td style="width:32%;">{{ asset_name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Asset Category: </th>
                                                <td>{{ asset_category }}</td>
                                                <th>Purchase Cost: </th>
                                                <td>{{ Number(asset_cost) }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <div class="col-md-10">
                                                        <strong>Serial Number: </strong><span
                                                            style="color: #DB4437; font-size: 11px;">*</span>
                                                        <input type="text" class="form-control" v-model="sr_number"
                                                            placeholder="Serial number" />
                                                        <span style="color: #DB4437; font-size: 11px;"
                                                            v-if="this.sr_number == ''">{{ e_sr_number }}</span>
                                                    </div>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <div class="col-md-10">
                                                        <strong>Salvage Value: </strong><span
                                                            style="color: #DB4437; font-size: 11px;">*</span>
                                                        <input type="number" class="form-control" v-model="salvage_value"
                                                            placeholder="Salvage Value" />
                                                        <span style="color: #DB4437; font-size: 11px;"
                                                            v-if="this.salvage_value == ''">{{ this.e_salvage_value }}</span>
                                                    </div>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <div class="col-md-10">
                                                        <strong>Estimate Life: </strong><span
                                                            style="color: #DB4437; font-size: 11px;">*</span>
                                                        <input type="month" class="form-control" v-model="est_life"
                                                            placeholder="Serial number" />
                                                        <span style="color: #DB4437; font-size: 11px;"
                                                            v-if="this.est_life == ''">{{ this.e_est_life }}</span>
                                                    </div>
                                                </td>

                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="col-12 text-center">
                                    <button v-if="sr_number == ''" type="submit" :disabled="disabled1" @click="delay1()"
                                        class="btn btn-danger me-1 mt-2">Update Asset</button>
                                    <button v-else type="submit" :disabled="disabled1" @click="delay1()"
                                        class="btn btn-primary me-1 mt-2" data-bs-dismiss="modal" aria-label="Close">Update
                                        Asset</button>
                                    <button type="reset" class="btn btn-outline-secondary mt-2" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        Cancel
                                    </button>
                                </div>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pay loan Modal -->
        <div class="modal fade" id="payloan1" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-5 px-sm-5 pt-50">
                        <div class="text-center mb-2">
                            <center>
                                <div class="col-md-12">
                                    <table style="width:100%;">
                                        <thead style="float:left; width:100%;">
                                            <h2 style="text-align:center;">Return Asset(s) From Employee</h2>
                                            <tr>
                                                <th style="width:18%;">Asset ID: </th>
                                                <td style="width:25%;">{{ asset_id }}</td>
                                                <th style="width:25%;">Asset Name: </th>
                                                <td style="width:32%;">{{ asset_name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Asset Category: </th>
                                                <td>{{ asset_category }}</td>
                                                <th>Purchase Cost: </th>
                                                <td>{{ Number(asset_cost) }}</td>
                                            </tr>


                                            <tr>
                                                <tr >
                                   <th colspan="4">
                   <div style="display: flex; align-items: center;">
                    <label class="form-label" style="margin-right: 10px;">Return from  Employee</label>
                    <multiselect :show-labels="false" style="font-size: 12px;" placeholder="Select Employee"
                                 value="id" label="label" v-model="emp_emp_id" :options="options4">
                    </multiselect>
                    <label class="form-label" style="margin-left: 20px; margin-right: 10px;">Return From Department</label>
                    <multiselect :show-labels="false" style="font-size: 12px;" id="FilterTransaction"
                                 placeholder="All Departments" v-model="emp_Dept" :options="options2">
                    </multiselect>
                    <span style="color: #DB4437; font-size: 11px;" v-if="emp_Dept==''">{{e_emp_Dept}}</span>
                   </div>
            </th>
        </tr>

                                            </tr>
                                            <tr>
                  <th colspan="4">
                                    <div class="col-xl-12 mb-lg-1 col-bill-to ps-0">
                                    <label for="note" class="form-label fw-bold">Narration:</label>
                                    <textarea v-model="remarks" class="form-control" rows="2" id="note"></textarea>
                                                    </div></th>
        </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="col-12 text-center">
                                    <button type="submit" :disabled="disabled3" @click="delay3()"
                                        class="btn btn-primary me-1 mt-2" data-bs-dismiss="modal" aria-label="Close">Return
                                        Asset</button>
                                    <button type="reset" class="btn btn-outline-secondary mt-2" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        Cancel
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

import VueBarcode from 'vue-barcode';
import Multiselect from 'vue-multiselect';

export default {

    data() {
        return {
            emp_emp_id:'',
            sr_number: '',
            e_sr_number: '',
            salvage_value: '',
            e_salvage_value: '',
            est_life: '',
            e_est_life: '',
            remarks:'',
            companydetail: {},
            counters: {},
            adsdata: {},
            success: '',
            retirement_list: {},
            depreciation_list: {},
            keyword1: '',
            pharmacode: '',
            category: 'all',
            e_search: '',
            count_users: {},
            getitemwise: {},
            itemid: '',
            getitemtotal: '',
            project:'',
options2:[],
options1: [],
emp_Dept:'',
e_emp_Dept:'',
location:'',
            options4: [],
            options3:[],
            rcvBy: '',
            rcvBy_error: '',
            asset_id: '',
            asset_name: '',
            asset_category: '',
            unit: '',
            asset_cost: '',
            disabled1: false,
            timeout1: null,
            disabled2: false,
            asset_asset_code: '',
            timeout2: null,
            disabled3: false,
            timeout3: null,
            allCategory: null,
            filterData: null,
        }
    },
    components: { VueBarcode,Multiselect },
    methods: {
        async  fetchLocations() {
    try {
        this.locations = await this.$apihelpers.overall_location()
                    this.options1 = [];

                   var $this = this;
                   for (var i = 0; i < $this.locations.length; i++) {
                   this.options1.push($this.locations[i].location_name);
                    }
      // Process the data or perform additional actions here
    } catch (error) {
      console.error(error);
      // Additional error handling if needed
    }
  },
        getObjectsByCategory(categoryName) {
            return this.adsdata.filter(obj => obj.CategoryName === categoryName);
        },
        getObjectsByName(name) {
            return this.adsdata.filter(obj => obj.Name.toLowerCase().startsWith(name.toLowerCase()));
        },
        delay1() {
            this.disabled1 = true
            this.timeout1 = setTimeout(() => {
                this.disabled1 = false
            }, 5000)
            this.update_asset()
        },
        delay2() {
            this.disabled2 = true
            this.timeout2 = setTimeout(() => {
                this.disabled2 = false
            }, 5000)
            this.assign()
        },
        delay3() {
            this.disabled3 = true
            this.timeout3 = setTimeout(() => {
                this.disabled3 = false
            }, 5000)
            this.return()
        },
        assign() {
            if (this.emp_Dept == '' || this.asset_id == '' || this.emp_Dept == null ) {
                this.e_emp_Dept = "Select Dept";
                this.$toastr.e("Please Select Departmant", "Error!");

            }
            else {
                this.e_emp_Dept = "";
                axios.post('./Accounts/assign_asset', {
                    asset_id: this.asset_id,
                   emp_Dept: this.emp_Dept,
                   empCode:this.emp_emp_id.label,
                   location:this.location,
                   project:this.project,
                    unit: this.unit,
                    remarks:this.remarks
                })
                    .then(data => {
                        if (data.data == "submitted!") {
                            this.$toastr.s("Assigned Asset successfully!", "Congratulations");
                            this.asset_id = "";
                            this.emp_Dept = "";
                            this.empCode = "";
                            this.location="";
                            this.project="";
                            this.unit = "";
                            this.emp_emp_id ="";
                            this.getResult();

                        }

                    })

            }
        },
        update_asset() {
            if (this.sr_number == '' || this.est_life == '' || this.salvage_value == '') {

                this.$toastr.e("Please enter serial number", "Error!");
                if (this.sr_number == '') {
                    this.e_sr_number = "Enter serial number";
                }
                if (this.salvage_value == '') {
                    this.e_salvage_value = 'Enter Salvage Value'
                }
                if (this.est_life == '') {
                    this.e_est_life = 'Select Estimate Life'
                }
            }
            else {
                this.e_sr_number = '';
                axios.post('./Accounts/update_asset', {
                    sr_number: this.sr_number,
                    asset_id: this.asset_id,
                    salvage_value: this.salvage_value,
                    estlife: this.est_life,
                    asset_category: this.asset_category
                })
                    .then(data => {
                        if (data.data == "submitted!") {
                            this.$toastr.s("Asset updatd successfully!", "Congratulations");
                            this.asset_id = '';
                            this.sr_number = '';
                            this.getResult();
                        }
                    })
            }
        },
        return() {
            if (this.emp_Dept == '' || this.emp_Dept == null) {
                this.e_emp_Dept = "Select Department";
                this.$toastr.e("Please Select Receiver Name", "Error!");

            }
            else {
                this.e_emp_Dept = "";
                axios.post('./Accounts/return_asset', {
                    asset_id: this.asset_id,
                   emp_Dept: this.emp_Dept,
                   emp_Code: this.emp_emp_id.label,
                    unit: this.unit,
                    remarks:this.remarks

                })
                    .then(data => {
                        if (data.data == "submitted!") {
                            this.$toastr.s("Return Asset successfully!", "Congratulations");
                            this.asset_id = "";
                            this.emp_Dept = "";
                            this.emp_Code="";
                            this.unit = "";
                            this.emp_emp_id= "";
                            this.getResult();

                        }

                    })

            }
        },
        fetch_asset(id) {

            axios.get('accounts/fetch_asset/' + id)
                .then(responce => {
                    this.asset_id = responce.data[0].AssetsUniqueID;
                    this.asset_name = responce.data[0].Name;
                    this.asset_category = responce.data[0].CategoryName;
                    this.asset_cost = responce.data[0].CostUnit;
                    this.unit = responce.data[0].Unit;
                })
        },
        getitemdata(id) {
            this.itemid = id;
            axios.get('accounts/getindassets/' + this.itemid)
                .then(response => {
                    this.getitemwise = response.data;
                    this.asset_asset_code = response.data[0].AssetsUniqueID;
                    axios.get("accounts/assets_retirement_security/" + response.data[0].AssetsUniqueID)
                        .then((response) => {
                            this.retirement_list = response.data
                        })
                    axios.get("accounts/assets_depreciation_security/" + response.data[0].AssetsUniqueID)
                        .then((response) => {
                            this.depreciation_list = response.data
                        })

                }
                )
                .catch(error => { });



        },
        getResult(page = 1) {
            axios.get('accounts/assets_detail/?page=' + page)
                .then(response => {
                    this.adsdata = response.data;
                    this.filterData = this.adsdata;
                    this.allCategory = [...new Set(this.adsdata.map(obj => obj.CategoryName))];
                })
                .catch(error => { });
        },
    },
    watch: {
        category(after, before) {
            if (after == 'all') {
                this.filterData = this.adsdata;
            }
            else {
                this.filterData = this.getObjectsByCategory(after)
            }

            // this.adsdata = this.getObjectsByCategory(after)
        },
        keyword1(after, before) {
            if (after == 'all' || after == '') {
                this.filterData = this.adsdata
            }
            this.filterData = this.getObjectsByName(after)
        }
    },

    mounted() {
        axios.get('./accounts/get_coaProjects')
                .then(response => {this.projects = response.data
                    this.options3 = [];
                    var $this = this;
                    for (var i = 0; i < $this.projects.length; i++) {
                        this.options3.push($this.projects[i].ProjectName);
                    }

                })

        this.fetchLocations();
        axios.get('overall_department')
                .then(response => {
                    this.departments = response.data
                    this.options2 = [];

                    var $this = this;
                    for (var i = 0; i < $this.departments.length; i++) {
                        this.options2.push($this.departments[i].department_name);
                    }
                })
                .catch(error => { });
        axios.get('registered_empcode')
            .then(data => {
                this.find_emp = data.data;
                this.options4 = [];
                this.options4 = this.find_emp.map((obj) => ({
                    id: obj.EmployeeID,
                    label: `${obj.EmployeeCode}` + ' _ ' + `${obj.Name}`,
                }));
            })
            .catch(error => {
            });
        this.getResult();
        axios.get('fetch_companyDetail')
            .then(response => {
                this.companydetail = response.data
            }).catch((err => {
            }))
        axios.get('./account_stock_counter')
            .then(response => this.counters = response.data)
            .catch(error => { });
    }
}

</script>
