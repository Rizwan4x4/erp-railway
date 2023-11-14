<template>
    <div>
        <!-- BEGIN: Content-->
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <router-link to="/" style="text-decoration: none;">Payroll</router-link>
                            </li>
                            <li class="breadcrumb-item active">
                                Fuel Bills Detail
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="content-body">
                    <!-- users list start -->
                    <section class="app-user-list">
                        <div clas="card" style="background-color:white !important">
                            <div style="margin-bottom:20px;" class="d-flex justify-content-between align-items-center header-actions mx-2 row mt-75">

                                <div class="col-sm-12 col-lg-12 ps-xl-75 ps-0">
                                    <h4>Total Fuel : {{ fuelAmount }} <span>Liters</span></h4>
                                    <div class="dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap">

                                        <div class="me-1">
                                            <div class="dataTables_filter" style="margin-top:5px">
                                                <label>
                                                    <input autocomplete="off" type="text" class="form-control" placeholder="Search By Name" />
                                                </label>
                                            </div>
                                        </div>
                                        <div v-if="hasPermission('Fuel new bill')" class="dt-buttons d-inline-flex mt-50">
                                            <router-link to="/payroll/fuelbills/add" class="dt-button add-new btn btn-primary" tabindex="0" type="button"><span>New Fuel Bill</span></router-link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive" style="overflow-x: initial !important;">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Emp. Code</th>
                                            <th>Name<br />Dept. & Designation</th>
                                            <th>Applied Date</th>
                                            <th>Amount</th>
                                            <th>Fuel Quantity</th>
                                            <th>Description</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="all_sals1 in adsdata.data">
                                            <td style="text-align:center;border-right:1px solid lightgrey">{{all_sals1.EmployeeCode}}</td>
                                            <td style="border-right:1px solid lightgrey">
                                                <div class="d-flex flex-column">
                                                    <a class="user_name text-truncate text-body"><span class="fw-bolder">{{all_sals1.Name}} </span></a><small class="emp_post text-muted">
                                                        <span v-if="all_sals1.Department!=null">{{all_sals1.Department}} - </span>
                                                        <span v-else></span>
                                                        <span v-if="all_sals1.Designation!=null">{{all_sals1.Designation}}</span>
                                                        <span v-else></span>
                                                    </small>
                                                </div>
                                            </td>
                                            <td style="text-align:center;border-right:1px solid lightgrey">{{all_sals1.CreatedOn.slice(0, 10)}}</td>
                                            <td style="text-align:center;border-right:1px solid lightgrey">{{all_sals1.BillAmount}}</td>
                                            <td style="text-align:center;border-right:1px solid lightgrey">{{Math.floor(all_sals1.FuelQuantity)}} Liter<label v-if="all_sals1.FuelQuantity > 1">s</label></td>
                                            <td style="text-align:center;border-right:1px solid lightgrey">{{all_sals1.Description}}</td>
                                            <td>
                                                <a v-if="hasPermission('Fuel bill actions') && all_sals1.Status=='Pending'" @click="fetch_emp_payroll(all_sals1.AllowanceID)" data-bs-toggle="modal" data-bs-target="#editpayroll"><i style="color:#d42f2f" class="fa-solid fa-pencil"></i><span></span></a>
                                                <a v-else><i style="color:#d42f2f" class="fa-solid fa-pencil"></i><span></span></a>
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
    </div>
</template>
<script>
    export default {
        data() {
            return {

                adsdata: {

                },
                currency: '',
                companydetail: {},
                vendors: {},
                keyword1: '',
                vendor_name: 'All',
                status1: 'All',
                status2: 'All',
                startingdate1: '',
                closingdate1: '',
                closingdate: '',
                startingdate: '',
                get_grndata: {},
                get_grndata1: {},

                count_users: {},

                up_sts: '',
                get_id: '',
                disabled: false,
                timeout: null,
                up_sts: '',
                e_up_sts: '',
                fuelAmount:''
            }
        },
        methods: {

            getResult(page = 1) {

                axios.get('accounts/bills_detail/?page=' + page)
                    .then(response => this.adsdata = response.data)
                    .catch(error => { });
            },
            getResults(page = 1) {
                this.vendor_name = 'All';
                this.status1 = 'All';
                this.status2 = 'All';
                this.startingdate = '';
                this.closingdate = '';
                axios.get('./accounts_grnbyVendor?page=' + page, { params: { name: this.keyword1 } })
                    .then(response => this.adsdata = response.data)
                    .catch(error => { });
            },
        },
        watch: {
            keyword1(after, before) {
                this.getResults();
            }
        },
        mounted() {
            axios.get('TotalFuelAmount').then(response => {
                    this.fuelAmount = response.data[0];
                })
         

            axios.get('fetch_companyDetail')
                .then(response => this.companydetail = response.data)


            this.getResult();
        }
    }

</script>
