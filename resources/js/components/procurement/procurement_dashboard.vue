<template>
    <div >
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow-tem-change"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active">
                                Procurement Dashboard
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="content-body">

                    <div class="row match-height">
                        <div class="col-lg-8 col-12">
                            <div class="card card-statistics">
                                <div class="card-header">
                                    <h4 class="card-title">Month-wise Purchase</h4>
                                </div>
                                <div class="card-body statistics-body">
                                    <apexchart type="bar" :options="options" :series="series"></apexchart>
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="row match-height">
                                <!-- Bar Chart - Orders -->
                                <div class="col-lg-12 col-md-12 col-6">
                                    <div class="card">
                                        <div class="card-header"
                                             style="text-align:center;padding-bottom: 0px !important;">
                                            <h4 class="card-title" style="width:100%">Top Rated Vendor(s)</h4>
                                        </div>
                                        <div class="card-body row" style="width:100%">
                                            <div style="width:100%;text-align:center">
                                                <img src="public/app-assets/first.jpg" style="width:75px">
                                                <h6 class="" style="width:100%">
                                                    {{ this.TopRatedVendor[0].VendorName }}</h6>
                                                <p style="margin-bottom: 0px !important">Orders
                                                    ({{ this.TopRatedVendor[0].TotalOrder }})</p>
                                            </div>
                                            <div class="col-md-6 col-12" style="text-align:center">
                                                <img src="public/app-assets/third.jpg" style="width:50px">
                                                <h6 class="" style="width:100%">
                                                    {{ this.TopRatedVendor[1].VendorName }}</h6>
                                                <p style="margin-bottom: 0px !important">Orders
                                                    ({{ this.TopRatedVendor[1].TotalOrder }})</p>
                                            </div>
                                            <div class="col-md-6 col-12" style="text-align:center">
                                                <img src="public/app-assets/second.jpg" style="width:50px">
                                                <h6 class="" style="width:100%">
                                                    {{ this.TopRatedVendor[2].VendorName }}</h6>
                                                <p style="margin-bottom: 0px !important">Orders
                                                    ({{ this.TopRatedVendor[2].TotalOrder }})</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--/ Bar Chart - Orders -->
                                <!-- Bar Chart - Orders -->
                                <div  class="col-lg-12 col-md-12 col-6">
                                    <div class="card">
                                        <div class="card-header"
                                             style="text-align:center;padding-bottom: 0px !important;">
                                            <h4 class="card-title" style="width:100%">Your Top Customers(s)</h4>
                                        </div>
                                        <div class="card-body row" style="width:100%">
                                            <div style="width:100%;text-align:center">
                                                <img src="public/app-assets/first.jpg" style="width:75px">
                                                <h6 class="" style="width:100%"></h6>
                                                <p style="margin-bottom: 0px !important">Orders
                                                    </p>
                                            </div>
                                            <div class="col-md-6 col-12" style="text-align:center">
                                                <img src="public/app-assets/third.jpg" style="width:50px">
                                                <h6 class="" style="width:100%">
                                                    </h6>
                                                <p style="margin-bottom: 0px !important">Orders</p>
                                            </div>
                                            <div class="col-md-6 col-12" style="text-align:center">
                                                <img src="public/app-assets/second.jpg" style="width:50px">
                                                <h6 class="" style="width:100%"></h6>
                                                <p style="margin-bottom: 0px !important">Orders</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--/ Bar Chart - Orders -->
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="row match-height">
                                <div class="col-lg-12 col-md-12 col-6">
                                    <div class="card-header">
                                        <h4 class="card-title">Demand Requisitions</h4>
                                    </div>
                                    <div class="card">
                                        <apexchart type="bar" height="350" :options="chartOptions5"
                                                   :series="series5"></apexchart>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-6">
                                    <div class="card-header">
                                        <h4 class="card-title">Assets Catagores</h4>
                                    </div>
                                    <div class="card">

                                        <apexchart width="400" type="pie" :options="options4"
                                                   :series="series4"></apexchart>

                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="col-lg-8 col-12">
                            <div class="card card-statistics">
                                <div class="card-header">
                                    <h4 class="card-title">Purchase Inventory Catagores</h4>
                                </div>

                                <div class="card-body statistics-body">
                                    <!-- <div class="row card-revenue-budget">

                                 <div class="col-md-4 col-12" style="position: end;">
                                        <div class="d-flex justify-content-between mb-1">
                                        <div class="d-flex align-items-center">
                                            <i class="fa-regular fa-circle text-success"></i>
                                            <span class="fw-bold ms-75">Total Requisitions</span>
                                        </div>
                                        <span>{{Math.floor(this.count_req.total)}}</span>
                                    </div>

                                    <div class="d-flex justify-content-between mb-1">
                                        <div class="d-flex align-items-center">
                                            <i class="fa-regular fa-circle text-primary"></i>
                                            <span class="fw-bold ms-75">Approved</span>
                                        </div>
                                        <span>{{Math.floor(this.count_req.approved)}}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <div class="d-flex align-items-center">
                                            <i class="fa-regular fa-circle text-warning"></i>
                                            <span class="fw-bold ms-75">Pending</span>
                                        </div>
                                        <span>{{parseInt(this.count_req.pending)}}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <i class="fa-regular fa-circle text-danger"></i>
                                            <span class="fw-bold ms-75">Rejected</span>
                                        </div>
                                        <span>{{Math.floor(this.count_req.rejected)}}</span>
                                    </div>
                                    </div>
                                    <br/> -->
                                    <div class="col-md-12 col-12" style="position: relative;">
                                        <!-- </div> -->
                                        <apexchart width="780" type="donut" :options="options3"
                                                   :series="series3"></apexchart>

                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="col-lg-8 col-12">
                            <div class="card card-statistics">
                                <div class="card-header">
                                    <h4 class="card-title">Department Wise Purchase Value</h4>
                                </div>

                                <div class="card-body statistics-body">

                                    <div class="col-md-12 col-12" style="position: relative;">
                                        <div v-if="loader" class="text-center">
                                            <div class="spinner-border spinner-border-sm" role="status"></div>
                                            <span class="loading-text">Loading...</span>
                                        </div>
                                        <apexchart v-if="!loader" width="780" type="donut" :options="options5"
                                                   :series="series6"></apexchart>

                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="row match-height">
                                <div class="col-lg-12 col-md-12 col-6">
                                    <div class="card-header">
                                        <h4 class="card-title">Purchase Requisitions Vs GRN Generated</h4>
                                    </div>
                                    <div class="card">
                                        <div v-if="loader2" class="text-center">
                                            <div class="spinner-border spinner-border-sm" role="status"></div>
                                            <span class="loading-text">Loading...</span>
                                        </div>
                                        <apexchart v-if="!loader2" type="bar" height="350" :options="chartOptions6"
                                                   :series="series7"></apexchart>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row match-height">
                            <!-- Medal Card -->
                            <div class="col-xl-4 col-md-6 col-12">

                                <div class="card card-developer-meetup">
                                    <div class="card-body" style="">
                                        <div class="card-header d-flex justify-content-between">
                                            <h4 class="card-title">Inventory Detail</h4>
                                        </div>
                                        <div id="chart">
                                            <apexchart type="radialBar" height="350" :options="chartOptions2"
                                                       :series="series2"></apexchart>
                                        </div>
                                        <div class="d-flex justify-content-between mb-1">
                                            <div class="d-flex align-items-center">
                                                <i class="fa-regular fa-circle text-success "></i>
                                                <span class="fw-bold ms-75">Total Products</span>
                                            </div>
                                            <span>{{ (Math.floor(this.radio.total_products)).toLocaleString() }}</span>
                                        </div>

                                        <div class="d-flex justify-content-between mb-1">
                                            <div class="d-flex align-items-center">
                                                <i class="fa-regular fa-circle text-primary"></i>
                                                <span class="fw-bold ms-75">Available Products</span>
                                            </div>
                                            <span>{{ (Math.floor(this.radio.available_products)).toLocaleString() }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <i class="fa-regular fa-circle text-danger"></i>
                                                <span class="fw-bold ms-75">Low Stock Products1</span>
                                            </div>
                                            <span>{{ (Math.floor(this.radio.not_available)).toLocaleString() }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-1">
                                            <div class="d-flex align-items-center">
                                                <i class="fa-regular fa-circle text-warning"></i>
                                                <span class="fw-bold ms-75">Available Stock</span>
                                            </div>
                                            <span>{{ radio.available_stock }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ Medal Card -->
                            <!-- Statistics Card -->
                            <div class="col-xl-8 col-md-6 col-12 ">
                                <div class="row card-revenue-budget">
                                    <div class="col-md-4 col-12" style="position: relative;">
                                        <div class=" budget-wrapper card">
                                            <div class="card-header d-flex justify-content-between"
                                                 style="padding-top:0px !important">
                                                <h4 class="card-title">Demand Requisitions</h4>
                                            </div>
                                            <h2 class="mb-25">{{ req_d.pending }}</h2>
                                            <div class="d-flex justify-content-center">
                                                <span class="fw-bolder me-25">Pending</span>
                                            </div>
                                            <hr>
                                            <h2 class="mb-25" style="font-size: 14px;"><br/></h2>
                                            <div class="d-flex justify-content-center">
                                                <span class="fw-bolder me-25"><br/></span>
                                            </div>
                                            <br>
                                            <router-link to="/purchase/requistion_detail"

                                                         class="btn btn-primary waves-effect waves-float waves-light">
                                                View Requisitions
                                            </router-link>
                                            <!-- <a v-else class="btn btn-primary waves-effect waves-float waves-light">View
                                                Requisitions</a> -->
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12 " style="position: relative;">
                                        <div class=" budget-wrapper card">
                                            <div class="card-header d-flex justify-content-between"
                                                 style="padding-top:0px !important">
                                                <h4 class="card-title" style="padding-left:20% !important">Stock
                                                    Summary</h4>
                                            </div>
                                            <h2 class="mb-25">{{ radio.available_stock }}</h2>
                                            <div class="d-flex justify-content-center">
                                                <span class="fw-bolder me-25">Available Stock</span>
                                            </div>
                                            <hr>
                                            <h2 class="mb-25" style="font-size: 14px;">Rs.
                                                {{ this.radio.stock_value }}</h2>
                                            <div class="d-flex justify-content-center">
                                                <span class="fw-bolder me-25">Estimated Value</span>
                                            </div>
                                            <br>
                                            <router-link  to="/Inventory/Detail"
                                                         class="btn btn-primary waves-effect waves-float waves-light">
                                                View Report
                                            </router-link>
                                            <!-- <a v-else class="btn btn-primary waves-effect waves-float waves-light">View
                                                Report</a> -->
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12" style="position: relative;">
                                        <div class=" budget-wrapper card">
                                            <div class="card-header d-flex justify-content-between"
                                                 style="padding-top:0px !important">
                                                <h4 class="card-title">Purchase Invoices</h4>
                                            </div>
                                            <h2 class="mb-25">{{ (po.inv_count).toLocaleString() }}</h2>
                                            <div class="d-flex justify-content-center">
                                                <span class="fw-bolder me-25">This Session</span>
                                            </div>
                                            <hr>
                                            <h2 class="mb-25" style="font-size: 14px;">Rs.
                                                {{ (Math.floor(po.inv_amount)).toLocaleString() }}</h2>
                                            <div class="d-flex justify-content-center">
                                                <span class="fw-bolder me-25">Amount</span>
                                            </div>
                                            <br>
                                            <router-link
                                                         to="purchase_invoice/detail"
                                                         class="btn btn-primary waves-effect waves-float waves-light">
                                                View Detail
                                            </router-link>
                                            <a class="btn btn-primary waves-effect waves-float waves-light">View
                                                Detail</a>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12" style="position: relative;">
                                        <div class="card">
                                            <div class="card-header" style="text-align:center">
                                                <h4 class="card-title" style="width:100%">Top Consumed Products</h4>
                                                <p class="card-text font-small-3">Top Three Consumed Product Throughtout
                                                    Session</p>
                                            </div>
                                            <div class="row avg-sessions pt-50">
                                                <div class="col-12 mb-2" style="padding-left:5%;padding-right:5%;">

                                                    <p class="mb-50">{{ topCI[2].Name }} :
                                                        {{ (Math.floor(topCI[2].TotalConsumed)).toLocaleString() }}</p>
                                                    <div class="progress progress-bar-primary" style="height: 6px">
                                                        <div class="progress-bar" role="progressbar" aria-valuenow="50"
                                                             aria-valuemin="50" aria-valuemax="100"
                                                             style="width: 90%"></div>
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-2" style="padding-left:5%;padding-right:5%;">
                                                    <p class="mb-50">{{ topCI[1].Name }} :
                                                        {{ (Math.floor(topCI[1].TotalConsumed)).toLocaleString() }}</p>
                                                    <div class="progress progress-bar-primary" style="height: 6px">
                                                        <div class="progress-bar" role="progressbar" aria-valuenow="50"
                                                             aria-valuemin="50" aria-valuemax="100"
                                                             style="width: 50%"></div>
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-2" style="padding-left:5%;padding-right:5%;">
                                                    <p class="mb-50">{{ topCI[0].Name }} :
                                                        {{ (Math.floor(topCI[0].TotalConsumed)).toLocaleString() }}</p>
                                                    <div class="progress progress-bar-primary" style="height: 6px">
                                                        <div class="progress-bar" role="progressbar" aria-valuenow="50"
                                                             aria-valuemin="50" aria-valuemax="100"
                                                             style="width: 30%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12" style="position: relative;">
                                        <div class="card">
                                            <div class="card-header" style="text-align:center">
                                                <h4 class="card-title" style="width:100%">High Stock Products</h4>
                                                <p class="card-text font-small-3" style="width:100%">Top Three High
                                                    Stock Product </p>
                                            </div>
                                            <div class="row avg-sessions pt-50">
                                                <div class="col-12 mb-2" style="padding-left:5%;padding-right:5%;">
                                                    <p class="mb-50">{{ highSI[0].Name }} :
                                                        {{ (Math.floor(highSI[0].Qty)).toLocaleString() }}</p>
                                                    <div class="progress progress-bar-primary" style="height: 6px">
                                                        <div class="progress-bar" role="progressbar" aria-valuenow="50"
                                                             aria-valuemin="50" aria-valuemax="100"
                                                             style="width: 80%"></div>
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-2" style="padding-left:5%;padding-right:5%;">
                                                    <p class="mb-50">{{ highSI[1].Name }} :
                                                        {{ (Math.floor(highSI[1].Qty)).toLocaleString() }}</p>
                                                    <div class="progress progress-bar-primary" style="height: 6px">
                                                        <div class="progress-bar" role="progressbar" aria-valuenow="50"
                                                             aria-valuemin="50" aria-valuemax="100"
                                                             style="width: 60%"></div>
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-2" style="padding-left:5%;padding-right:5%;">
                                                    <p class="mb-50">{{ highSI[2].Name }} :
                                                        {{ (Math.floor(highSI[2].Qty)).toLocaleString() }}</p>
                                                    <div class="progress progress-bar-primary" style="height: 6px">
                                                        <div class="progress-bar" role="progressbar" aria-valuenow="50"
                                                             aria-valuemin="50" aria-valuemax="100"
                                                             style="width: 30%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ Statistics Card -->

                        </div>

                        <div class="row match-height">

                            <div class="col-xl-4 col-md-6 col-12">

                                <div class="row card-revenue-budget">

                                    <div class="col-md-6 col-12" style="position: relative;">
                                        <div class="card">
                                            <div class="card-header" style="text-align:center">
                                                <h2 class="card-text font-small-10">
                                                    {{ (Math.floor(Assets1[0].TotalAssets)).toLocaleString() }}</h2>
                                                <h4 class="card-title" style="width:100%">Total Assets</h4>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12" style="position: relative;">
                                        <div class="card">
                                            <div class="card-header" style="text-align:center">
                                                <h2 class="card-text font-small-10">
                                                    {{ (Math.floor(Assets1[0].AvailableAsset)).toLocaleString() }}</h2>
                                                <h4 class="card-title" style="width:100%">Available</h4>

                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12" style="position: relative;">
                                        <div class="card">
                                            <div class="card-header" style="text-align:center">
                                                <h2 class="card-text font-small-10">
                                                    {{ (Math.floor(Assets1[0].AssignedAssets)).toLocaleString() }}</h2>
                                                <h4 class="card-title" style="width:100%">Assigned</h4>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12" style="position: relative;">
                                        <div class="card">
                                            <div class="card-header" style="text-align:center">
                                                <h2 class="card-text font-small-10"><br/></h2>
                                                <h4 class="card-title" style="width:100%"><br/></h4>
                                            </div>

                                        </div>
                                    </div>

                                </div>


                                <div class="col-lg-12 col-md-12 col-6">
                                    <div class="card-header">
                                        <h4 class="card-title">Average Procurement Cycle In Days</h4>
                                    </div>
                                    <div class="card">
                                        <div v-if="loader1" class="text-center">
                                            <div class="spinner-border spinner-border-sm" role="status"></div>
                                            <span class="loading-text">Loading...</span>
                                        </div>
                                        <apexchart v-if="!loader1" type="bar" height="350" :options="chartOptions7"
                                                   :series="series8"></apexchart>
                                    </div>
                                </div>


                            </div>


                            <div class="col-xl-8 col-md-6 col-12 ">
                                <div class="row card-revenue-budget">

                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Assets Detail</h4>
                                        </div>
                                        <div class="card-body">
                                            <div>
                                                <datatable :data="adsdata" :columns="columns1"
                                                           :on-click="click"></datatable>
                                            </div>
                                            <div class="card-body pb-50" style="position: relative;">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!--/ Statistics Card -->
                            <div class="col-xl-6 col-md-6 col-12 ">
                                <div class="row card-revenue-budget">

                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Purchase Comparison Department Wise</h4>
                                        </div>
                                        <div class="card-body">
                                            <div>
                                                <datatable :data="adsdata1" :columns="columns4"></datatable>
                                            </div>
                                            <div class="card-body pb-50" style="position: relative;">


                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-12 ">
                                <div class="row card-revenue-budget">

                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Purchase Comparison Vendor Wise</h4>
                                        </div>
                                        <div class="card-body">
                                            <div>
                                                <datatable :data="pr_vendor" :columns="columns5"></datatable>
                                            </div>
                                            <div class="card-body pb-50" style="position: relative;">


                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-12 ">
                                <div class="row card-revenue-budget">

                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Purchase Comparison Item Category</h4>
                                        </div>
                                        <div class="card-body">
                                            <div>
                                                <datatable :data="pr_item" :columns="columns7"></datatable>
                                            </div>
                                            <div class="card-body pb-50" style="position: relative;">


                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-12 ">
                                <div class="row card-revenue-budget">

                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Average Procurement Cycle Vendor wise</h4>
                                        </div>
                                        <div class="card-body">
                                            <div>
                                                <datatable :data="days_vendor" :columns="columns8"></datatable>
                                            </div>
                                            <div class="card-body pb-50" style="position: relative;">


                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- Apply for leave modal  -->
                        <div class="modal fade" id="addNewCard" tabindex="-1" aria-labelledby="addNewCardTitle"
                             aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-transparent">
                                        <div class="text-center mb-2">
                                            <h1 class="mb-1">ASSETS DETAILS</h1>
                                        </div>
                                        <button type="button" @click="out()" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body px-sm-5 mx-50 pb-5">
                                        <!-- form -->
                                        <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75"
                                              onsubmit="return false">
                                            <div class="col-12">
                                                <datatable :data="adsdata2" :columns="columns2"></datatable>

                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/ Apply for leave modal  -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import {thisTypeAnnotation} from '@babel/types';
import moment from 'moment';
import VueApexCharts from 'vue-apexcharts';

require("bootstrap-vue-datatable");

Vue.filter('formatDate', function (value) {
    if (value) {
        return moment(String(value)).format('ddd MMM DD,YYYY')
    }
})

export default {

    components: {
        apexchart: VueApexCharts,
    },
    data: function () {
        return {
            po: {},
            dde: [],
            ddf: [],
            dre: [],
            drf: [],
            radio: {},
            count_grn: {},
            adsdata1: [],
            pr_vendor: [],
            pr_item: [],
            days_vendor: [],
            loader: true,
            loader1: true,
            loader2: true,

            first: '',
            second: '',
            third: '',
            fourth: '',

            options: {
                chart: {
                    type: 'bar',
                    height: 350
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: ['Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                },
                yaxis: {
                    title: {
                        text: 'Amount. (Rupees)'
                    }
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return "Rs. " + val + ".00"
                        }
                    }
                }
            },
            series: [ {
                name: 'Purchase',
                data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
            },

            ],


            show1: "#addNewCard",

            series2: [100, 0, 0, 0, 0],
            chartOptions2: {
                chart: {
                    height: 350,
                    type: 'radialBar',
                },
                plotOptions: {
                    radialBar: {
                        dataLabels: {
                            name: {
                                fontSize: '22px',
                            },
                            value: {
                                fontSize: '16px',
                            },
                            total: {
                                show: true,
                                label: 'Total',
                                formatter: function (w) {

                                    return
                                }
                            }
                        }
                    }
                },
                colors: ['#026440', '#0084ff', '#FF0000', '#FFA500', '#808080'],
                labels: ['Product', 'Available Products', 'Not Available Products', 'Stock', 'Expired Stock'],
            },

            req_d: {},
            highSI: {},
            AssetsC: {},
            InventoryC: {},
            Assets1: {},
            pvalue: {},

            expense: '',
            Top3Customers: [{CustomerName: '', TotalOrder: ''}, {CustomerName: '', TotalOrder: ''}, {
                CustomerName: '',
                TotalOrder: ''
            }],

            TopRatedVendor: {},

            topCI: {},

            options3: {
                chart: {
                    width: 580,
                    type: 'pie',
                },
                labels: [],
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 400
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]

            },
            options5: {
                chart: {
                    width: 580,
                    type: 'pie',
                },
                labels: [],
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 400
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            },
            series3: [0],
            series6: [0],

            options4: {
                labels: [],
                chart: {
                    width: 380,
                    type: 'pie',
                },
                responsive: [{
                    breakpoint: 280,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            },
            series4: [0],


            series5: [{
                name: '',
                data: [0]

            }],
            series7: [{
                name: '',
                data: [0]
            }],
            series8: [{
                name: '',
                data: [0]
            }

            ],
            chartOptions5: {
                chart: {
                    type: 'bar',
                    height: 350
                },
                labels: ['Total', 'Approved', 'Pending', 'Issued'],
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        horizontal: true,
                    }
                },
                dataLabels: {
                    enabled: true
                },
                xaxis: {

                    categories: ['Total', 'Approved', 'Pending', 'Issued'],
                },

            },
            chartOptions6: {
                chart: {
                    type: 'bar',
                    height: 350
                },
                labels: ['PRs', 'GRN', 'Percentage'],
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        horizontal: true,
                    }
                },
                dataLabels: {
                    enabled: true
                },
                xaxis: {

                    categories: ['PRs', 'GRN', 'Percentage'],
                },
            },
            chartOptions7: {
                chart: {
                    type: 'bar',
                    height: 350
                },
                labels: ['avg no of days'],
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        horizontal: true,
                    }
                },
                dataLabels: {
                    enabled: true
                },
                xaxis: {

                    categories: ['avg no of days'],
                },

            },
            count_req: {},
            adsdata: [],
            adsdata2: [],


            // Columns that should be displayed on The Table
            columns1: [
                {name: "Name", th: "Name"},
                {name: "CategoryName", th: "Catagores"},
                {name: "TotalAssets", th: "Total"},
                {name: "AvailableAsset", th: "Available"},

            ],
            columns4: [
                {name: "DepartmentName", th: "Dept.Name"},
                {name: "2022", th: "2022"},
                {name: "2022_Percentage", th: "%age"},
                {name: "2023", th: "2023"},
                {name: "2023_Percentage", th: "%age"},
            ],
            columns5: [
                {name: "vendorName", th: "Vendor.Name"},
                {name: "2022", th: "2022"},
                {name: "2022_Percentage", th: "%age"},
                {name: "2023", th: "2023"},
                {name: "2023_Percentage", th: "%age"},
            ],
            columns7: [
                {name: "ItemName", th: "Vendor.Name"},
                {name: "2022", th: "2022"},
                {name: "2022_Percentage", th: "%age"},
                {name: "2023", th: "2023"},
                {name: "2023_Percentage", th: "%age"},
            ],
            columns8: [
                {name: "vendor_name", th: "Vendor.Name"},
                {name: "average_days", th: "Average Days"},
            ],
            columns2: [
                {name: "AssetsUniqueID", th: "ID"},
                {name: "Name", th: "Name"},
                {name: "CategoryName", th: "Catagores"},
                {name: "Qty", th: "Qty"},


            ],


        }
    },
    methods: {
        click(row, cell, name, index) {
            $('#addNewCard').modal('show');
            axios.get('accounts/RemainingAssets_Dashboard/' + row.Name)//use for single assets details
                .then(response => {
                    this.adsdata2 = response.data;
                })
        },
        out() {

        }, set1() {

            let c = 0;
            for (let i in this.AssetsC) {
                c = c + parseInt(this.AssetsC[i].Qty);
            }
            for (let i in this.AssetsC) {
                this.options4.labels.push(this.AssetsC[i].CategoryName);

                this.series4[i] = parseFloat(((parseInt(this.AssetsC[i].Qty) / c) * 100).toFixed(2));
            }

        },
        set2() {
            let c = 0;
            for (let i in this.InventoryC) {
                c = c + parseInt(this.InventoryC[i].Qty);
            }
            for (let i in this.InventoryC) {
                this.options3.labels.push(this.InventoryC[i].CategoryName);
                this.series3[i] = parseFloat(((parseInt(this.InventoryC[i].Qty) / c) * 100).toFixed(2));
            }

        },
        set3() {
            this.series5[0] = this.series5[0] = {
                name: '',
                data: [this.count_req.total, this.count_req.approved, this.count_req.pending, this.count_req.issued]
            };
        },
        set5() {
            this.series7[0] = {
                name: '',
                data: [this.count_grn.total_req, this.count_grn.total_grn, this.count_grn.percentage]
            };
        },
        set6() {
            this.series8[0] = {
                name: '',
                data: [this.days.average_days]
            }
        },
        set4() {
            let d = 0;
            for (let i in this.pvalue) {
                d = d + parseInt(this.pvalue[i].TotalPrice);
            }
            for (let i in this.pvalue) {
                // this.options5.labels.push(this.pvalue[i].DepartmentName);
                // this.series6[i]=parseFloat(((parseInt(this.pvalue[i].TotalPrice)/d)*100).toFixed(2));
                let totalPrice = parseInt(this.pvalue[i].TotalPrice);
                let percentage = ((totalPrice / d) * 100).toFixed(2);
                this.options5.labels.push(`${this.pvalue[i].DepartmentName} - ${totalPrice} (${percentage}%)`);
                this.series6[i] = parseFloat(percentage);
            }
        },

    },
    mounted() {




        axios.get('account_stock_counter')
            .then(data => {
                this.radio = data.data;
                this.series2 = [100, ((this.radio.available_products / this.radio.total_products) * 100).toFixed(2), ((this.radio.not_available / this.radio.total_products) * 100).toFixed(2), 100, ((this.radio.expired_items / this.radio.available_stock) * 100).toFixed(2)]
            })

        // axios.get('Accounts/fetch_dashboard_customers')
        //     .then(response => {
        //         this.Top3Customers = response.data;
        //     })

        axios.get('Accounts/fetch_dashboard_vendors')
            .then(response => {
                this.TopRatedVendor = response.data;
            })

        axios.get('Accounts/fetch_dashboard_TopConsumedItem')
            .then(response => {
                this.topCI = response.data;
            })

        axios.get('Accounts/fetch_dashboard_TopItem')
            .then(response => {
                this.highSI = response.data;
            })

        axios.get('accounts/count_demandrequisitions1')
            .then(response => {
                this.count_req = response.data
                this.set3();
            })

        axios.get('Accounts/fetch_dashboard_TopCategoryInventory')
            .then(response => {
                this.InventoryC = response.data;
                this.set2();
            })
        axios.get('Accounts/fetch_dashboard_TopAssetCategory')
            .then(response => {
                this.AssetsC = response.data;
                this.set1();
            })


                axios.get('Accounts/count_purchase_d/')
                    .then(data => {
                        this.ddf = data.data;
                        this.series = [
                            {
                                name: 'Purchase',
                                data: this.ddf
                            },
                        ]

                    })


        axios.get('accounts/Assets_D')
            .then(response => {
                this.Assets1 = response.data;
            })
        axios.get('accounts/Assets_Detail_CategoryWi')
            .then(response => {
                this.adsdata = response.data;

            })


        axios.get('accounts/count_req_amt_d')
            .then(response => {
                this.req_d = response.data;
            })


        axios.get('accounts/count_po_amt_d')
            .then(response => {
                this.po = response.data;
            })

        axios.get('accounts/get_purchase_value_department').then(response => {
            this.pvalue = response.data;
            this.set4();
            this.loader = false;
        })
        axios.get('accounts/grn_vs_pr').then(response => {
            this.count_grn = response.data
            this.set5();
            this.loader2 = false;
        })
        axios.get('accounts/procurement_cycle_days')
            .then(response => {
                this.days = response.data;
                this.set6();
                this.loader1 = false;
            })
        axios.get('accounts/get_department_name')
            .then(response => {
                this.adsdata1 = response.data;
            })
        axios.get('accounts/get_purchaseReport_vendor')
            .then(response => {
                this.pr_vendor = response.data;
            })
        axios.get('accounts/get_purchaseReport_ItemCategory')
            .then(response => {
                this.pr_item = response.data;
            })
        axios.get('accounts/procurement_cycle_supplier')
            .then(response => {
                this.days_vendor = response.data;
            })
    }
}

</script>
