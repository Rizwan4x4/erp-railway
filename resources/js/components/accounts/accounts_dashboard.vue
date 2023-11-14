<template>
    <div
       >
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active">
                                Accounts Dashboard
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="content-body">
                    <div class="row match-height">
                        <!-- Medal Card -->
                        
                        <div  class="col-lg-6 col-sm-6 col-12">
                            <div class="card card-congratulation-medal">
                                <div class="card-body">
                                    <div id="chart">
                                        <apexchart type="line" height="350" :options="chartOptions"
                                                   :series="series1"></apexchart>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="card-header"
                                 style="margin-bottom: 10px;padding-top: 5px !important;padding-bottom: 5px !important;border-radius: 0px !important;">
                                <h4 class="card-title" style="text-align:center">{{ test_array.current_month }}
                                    Summary</h4>
                            </div>
                            <!--/ Medal Card -->
                            <div class="row">
                                <div class="col-lg-6 col-sm-12 col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div>
                                                <h3 v-if="test_array.acc_receivable!=0 || test_array.acc_receivable!=null"
                                                    class="fw-bolder mb-0"
                                                    style="margin-bottom: 20px !important;font-size: 16px;">Rs.
                                                    {{ (Math.floor(test_array.acc_receivable)).toLocaleString() }}</h3>
                                                <h3 v-else class="fw-bolder mb-0"
                                                    style="margin-bottom: 20px !important;font-size: 16px;">Rs. 0</h3>
                                                <p class="card-text">Account Receivable</p>
                                            </div>
                                            <div class="avatar bg-light-warning p-50 m-0">
                                                <div class="avatar-content">
                                                    <i class="fa-sharp fa-solid fa-credit-card"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12 col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div>
                                                <h3 v-if="test_array.acc_payable!=0 || test_array.acc_payable!=null"
                                                    class="fw-bolder mb-0"
                                                    style="margin-bottom: 20px !important;font-size: 16px;">Rs.
                                                    {{ (Math.floor(test_array.acc_payable)).toLocaleString() }}</h3>
                                                <h3 v-else class="fw-bolder mb-0"
                                                    style="margin-bottom: 20px !important;font-size: 16px;">Rs. 0</h3>
                                                <p class="card-text">Account Payable</p>
                                            </div>
                                            <div class="avatar bg-light-warning p-50 m-0">
                                                <div class="avatar-warning">
                                                    <i class="fa-sharp fa-solid fa-credit-card"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12 col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div>
                                                <h3 v-if="test_array.acc_income!=0 || test_array.acc_income!=null"
                                                    class="fw-bolder mb-0"
                                                    style="margin-bottom: 20px !important;font-size: 16px;">Rs.
                                                    {{ (Math.floor(test_array.acc_income)).toLocaleString() }}</h3>
                                                <h3 v-else class="fw-bolder mb-0"
                                                    style="margin-bottom: 20px !important;font-size: 16px;">Rs. 0</h3>
                                                <p class="card-text">Total Income</p>
                                            </div>
                                            <div class="avatar bg-light-success p-50 m-0">
                                                <div class="avatar-content">
                                                    <i class="fa-sharp fa-solid fa-credit-card"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12 col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div>
                                                <h3 v-if="test_array.acc_expense!=0 || test_array.acc_expense!=null"
                                                    class="fw-bolder mb-0"
                                                    style="margin-bottom: 20px !important;font-size: 16px;">Rs.
                                                    {{ (Math.floor(test_array.acc_expense)).toLocaleString() }}</h3>
                                                <h3 v-else class="fw-bolder mb-0"
                                                    style="margin-bottom: 20px !important;font-size: 16px;">Rs. 0</h3>
                                                <p class="card-text">Expense</p>
                                            </div>
                                            <div class="avatar bg-light-success p-50 m-0">
                                                <div class="avatar-content">
                                                    <i class="fa-sharp fa-solid fa-credit-card"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12 col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div>
                                                <h3 v-if="test_array.overdue_po!=0 || test_array.overdue_po!=null"
                                                    class="fw-bolder mb-0"
                                                    style="margin-bottom: 20px !important;font-size: 16px;">Rs.
                                                    {{ (Math.floor(test_array.overdue_po)).toLocaleString() }}</h3>
                                                <h3 v-else class="fw-bolder mb-0"
                                                    style="margin-bottom: 20px !important;font-size: 16px;">Rs. 0</h3>
                                                <p class="card-text">Overdue PO</p>
                                            </div>
                                            <div class="avatar bg-light-primary p-50 m-0">
                                                <div class="avatar-content">
                                                    <i class="fa-sharp fa-solid fa-credit-card"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12 col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div>
                                                <h3 v-if="test_array.cash_in_hand!=0 || test_array.cash_in_hand!=null"
                                                    class="fw-bolder mb-0"
                                                    style="margin-bottom: 20px !important;font-size: 16px;">Rs.
                                                    {{ (Math.floor(test_array.cash_in_hand)).toLocaleString() }}</h3>
                                                <h3 v-else class="fw-bolder mb-0"
                                                    style="margin-bottom: 20px !important;font-size: 16px;">Rs. 0</h3>
                                                <p class="card-text">Cash in Hand</p>
                                            </div>
                                            <div class="avatar bg-light-primary p-50 m-0">
                                                <div class="avatar-content">
                                                    <i class="fa-sharp fa-solid fa-credit-card"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row match-height">

                        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Transaction Detail</h4>
                                    <span class="badge rounded-pill badge-light-primary">Top Five</span>
                                </div>
                                <div class="card-body">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="homeIcon-tab" data-bs-toggle="tab"
                                               href="#homeIcon" aria-controls="home" role="tab" aria-selected="true">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                     class="feather feather-home">
                                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                                </svg>
                                                Purchase
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="profileIcon-tab" data-bs-toggle="tab"
                                               href="#profileIcon" aria-controls="profile" role="tab"
                                               aria-selected="false">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                     class="feather feather-tool">
                                                    <path
                                                        d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path>
                                                </svg>
                                                Sale
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#disabledIcon" id="disabledIcon-tab" class="nav-link"
                                               data-bs-toggle="tab" role="tab" aria-selected="false">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                     class="feather feather-eye-off">
                                                    <path
                                                        d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                                                    <line x1="1" y1="1" x2="23" y2="23"></line>
                                                </svg>
                                                Payment Voucher
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="aboutIcon-tab" data-bs-toggle="tab"
                                               href="#aboutIcon" aria-controls="about" role="tab" aria-selected="false">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                     class="feather feather-user">
                                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                    <circle cx="12" cy="7" r="4"></circle>
                                                </svg>
                                                Received Voucher
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="aboutIcon-tab9" data-bs-toggle="tab"
                                               href="#aboutIcon9" aria-controls="about" role="tab"
                                               aria-selected="false">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                     class="feather feather-user">
                                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                    <circle cx="12" cy="7" r="4"></circle>
                                                </svg>
                                                Journal Voucher
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="homeIcon" aria-labelledby="homeIcon-tab"
                                             role="tabpanel">
                                            <p>
                                                <div class="table-responsive" style="overflow-x: initial !important;">
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <th style="text-align:center; vertical-align:middle !important;">
                                                                INV ID
                                                            </th>
                                                            <th style="text-align:center; vertical-align:middle !important;">
                                                                Date
                                                            </th>
                                                            <th style="">Vendor Name</th>
                                                            <th style="">Against Dept. /Project</th>
                                                            <th style="text-align:center;">SubTotal</th>
                                                            <th style="text-align:center;">Tax</th>
                                                            <th style="text-align:center;">Delivery</th>
                                                            <th style="text-align:center;">Total</th>
                                                            <th style="text-align:center; vertical-align:middle !important;">
                                                                Status
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr class="odd" v-for="adsdata1 in adsdata">
                                                            <td class=" control" tabindex="0"
                                                                style="display: none;"></td>
                                                            <td style="text-align: center; vertical-align: middle !important;">
                                                                {{ adsdata1.FormID }}
                                                            </td>
                                                            <td style="text-align: center; vertical-align: middle !important;">
                                                                {{ adsdata1.Dated }}
                                                            </td>
                                                            <td style="vertical-align: middle !important;"
                                                                class="sorting_1">
                                                                {{ adsdata1.vendorName }}
                                                            </td>
                                                            <td style="text-align: center; vertical-align: middle !important;">
                                                                <div
                                                                    class="d-flex justify-content-left align-items-center">
                                                                    <div class="d-flex flex-column"><a
                                                                        class="user_name text-truncate text-body"><span
                                                                        class="fw-bolder">{{
                                                                            adsdata1.DepartmentName
                                                                        }}</span></a><small
                                                                        class="emp_post text-muted">{{
                                                                            adsdata1.ProjectName
                                                                        }}</small>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td style="text-align:center;">
                                                                Rs.{{ Math.floor(adsdata1.SubTotal) }}
                                                            </td>
                                                            <td style="text-align:center;">
                                                                Rs.{{ Math.floor(adsdata1.Tax) }}
                                                            </td>
                                                            <td style="text-align:center;">
                                                                Rs.{{ Math.floor(adsdata1.ShippingCharges) }}
                                                            </td>
                                                            <td style="text-align:center;">
                                                                Rs.{{ Math.floor(adsdata1.TotalAmount) }}
                                                            </td>
                                                            <td style="text-align: center; vertical-align: middle !important;">
                                                                <span v-if="adsdata1.Status=='Fully Completed'"
                                                                      class="badge bg-light-success">{{
                                                                        adsdata1.Status
                                                                    }}</span>
                                                                <span v-else-if="adsdata1.Status=='Partially Completed'"
                                                                      class="badge bg-light-primary">{{
                                                                        adsdata1.Status
                                                                    }}</span>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </p>
                                        </div>
                                        <div class="tab-pane" id="profileIcon" aria-labelledby="profileIcon-tab"
                                             role="tabpanel">
                                            <p>
                                                <div class="table-responsive" style="overflow-x: initial !important;">
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <th style="text-align:center; vertical-align:middle !important;">
                                                                INV ID
                                                            </th>
                                                            <th style="text-align:center; vertical-align:middle !important;">
                                                                Date
                                                            </th>
                                                            <th style="">Customer Name</th>
                                                            <th style="text-align:center;">SubTotal</th>
                                                            <th style="text-align:center;">Tax</th>
                                                            <th style="text-align:center;">Delivery</th>
                                                            <th style="text-align:center;">Total</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr class="odd" v-for="adsdata21 in adsdata2">
                                                            <td class=" control" tabindex="0"
                                                                style="display: none;"></td>
                                                            <td style="text-align: center; vertical-align: middle !important;">
                                                                {{ adsdata21.saleID }}
                                                            </td>
                                                            <td style="text-align: center; vertical-align: middle !important;">
                                                                {{ adsdata21.Dated }}
                                                            </td>
                                                            <td style="vertical-align: middle !important;"
                                                                class="sorting_1">
                                                                {{ adsdata21.CustomerName }}
                                                            </td>
                                                            <td style="text-align:center;">
                                                                Rs.{{ Math.floor(adsdata21.SubTotal) }}
                                                            </td>
                                                            <td style="text-align:center;">
                                                                Rs.{{ Math.floor(adsdata21.Tax) }}
                                                            </td>
                                                            <td style="text-align:center;">
                                                                Rs.{{ Math.floor(adsdata21.ShippingCharges) }}
                                                            </td>
                                                            <td style="text-align:center;">
                                                                Rs.{{ Math.floor(adsdata21.TotalAmount) }}
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </p>
                                        </div>
                                        <div class="tab-pane" id="disabledIcon" aria-labelledby="disabledIcon-tab"
                                             role="tabpanel">
                                            <p>
                                                <div class="table-responsive" style="overflow-x: initial !important;">
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>ID</th>
                                                            <th>AccountID</th>
                                                            <th>Payment To</th>
                                                            <th>Payment Method</th>
                                                            <th>Against</th>
                                                            <th>Amount</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr class="odd" v-for="adsdata31 in adsdata3">
                                                            <td class=" control" tabindex="0"
                                                                style="display: none;"></td>
                                                            <td class="sorting_1">{{ adsdata31.VoucherDate }}</td>
                                                            <td>{{ adsdata31.PVID }}</td>
                                                            <td>{{ adsdata31.AccountID }}</td>
                                                            <td>
                                                                <div
                                                                    class="d-flex justify-content-left align-items-center">
                                                                    <div class="d-flex flex-column">
                                                                        <h6 class="user-name text-truncate mb-0">
                                                                            {{ adsdata31.PaymentAgainst }}</h6>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>{{ adsdata31.MethodType }}</td>
                                                            <td>{{ adsdata31.InvoiceNumber }}</td>
                                                            <td>Rs. {{ Math.floor(adsdata31.Amount) }}/-</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </p>
                                        </div>
                                        <div class="tab-pane" id="aboutIcon" aria-labelledby="aboutIcon-tab"
                                             role="tabpanel">
                                            <p>
                                                <div class="table-responsive" style="overflow-x: initial !important;">
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>ID</th>
                                                            <th>AccountID</th>
                                                            <th>Received From</th>
                                                            <th>Payment Method</th>
                                                            <th>Against</th>
                                                            <th>Amount</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr class="odd" v-for="adsdata41 in adsdata4">
                                                            <td class=" control" tabindex="0"
                                                                style="display: none;"></td>
                                                            <td class="sorting_1">{{ adsdata41.VoucherDate }}</td>
                                                            <td>{{ adsdata41.RVID }}</td>
                                                            <td>{{ adsdata41.AccountID }}</td>
                                                            <td>
                                                                <div
                                                                    class="d-flex justify-content-left align-items-center">
                                                                    <div class="d-flex flex-column">
                                                                        <h6 class="user-name text-truncate mb-0">
                                                                            {{ adsdata41.ReceivedAgainst }}</h6>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>{{ adsdata41.MethodType }}</td>
                                                            <td>{{ adsdata41.InvoiceNumber }}</td>
                                                            <td>Rs. {{ Math.floor(adsdata41.Amount) }}/-</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </p>
                                        </div>
                                        <div class="tab-pane" id="aboutIcon9" aria-labelledby="aboutIcon-tab9"
                                             role="tabpanel">
                                            <p>
                                                <div class="table-responsive" style="overflow-x: initial !important;">
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Issued Date</th>
                                                            <th>Narration</th>
                                                            <th>Amount</th>
                                                            <th>Created By</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr class="odd" v-for="adsdata51 in adsdata5">
                                                            <td class=" control" tabindex="0"
                                                                style="display: none;"></td>
                                                            <td class="sorting_1"><a class="fw-bold">
                                                                {{ adsdata51.JVID }}</a></td>
                                                            <td>{{ adsdata51.JVDate }}</td>
                                                            <td>
                                                                {{ adsdata51.Narration }}
                                                            </td>
                                                            <td>
                                                                Rs.
                                                                {{ Math.floor(adsdata51.TransactionAmount) }}/-
                                                            </td>
                                                            <td>{{ adsdata51.CreatedBy }}</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </p>
                                        </div>
                                        <div class="col-lg-8 col-12" >
                            <div class="card card-statistics">
                                <div class="card-header">
                                    <h4 class="card-title">Month-wise Units Management Sales </h4>
                                </div>
                                <div class="card-body statistics-body">
                                    <apexchart type="bar" :options="options" :series="series"></apexchart>
                                </div>
                            </div>
                        </div>
                                        <div class="col-lg-8 col-12" v-if="toggle==false">
                                            <div class="card card-statistics">
                                                <div class="card-header">
                                                    <h4 class="card-title">Project Wise Issuance Value</h4>
                                                </div>

                                                <div class="card-body statistics-body">

                                                    <div class="col-md-12 col-12" style="position: relative;">
                                                        <!-- </div> -->
                                                        <apexchart width="780" type="donut" :options="options5"
                                                                   :series="series6"></apexchart>

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
    </div>
</template>
<script>
import moment from 'moment';
import VueApexCharts from 'vue-apexcharts';

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
            series6: [0],
            dde: [],
            ddf: [],
            dre: [],
            drf: [],
            radio: {},
            avail_stock: 0,
            first: '',
            second: '',
            third: '',
            fourth: '',
            series1: [{
                name: "Revenue",
                data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
            },
                {
                    name: "Expense",
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                },

            ],
            chartOptions: {
                chart: {
                    height: 350,
                    type: 'line',
                    zoom: {
                        enabled: false
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: [5, 7, 5],
                    curve: 'straight',
                    dashArray: [0, 8, 5]
                },
                title: {
                    text: 'Current Year Statistics',
                    align: 'left'
                },
                legend: {
                    tooltipHoverFormatter: function (val, opts) {
                        return val + ' - ' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + ''
                    }
                },
                markers: {
                    size: 0,
                    hover: {
                        sizeOffset: 6
                    }
                },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                },
                tooltip: {
                    y: [{
                        title: {
                            formatter: function (val) {
                                return val + " (Rs. )"
                            }
                        }
                    },
                        {
                            title: {
                                formatter: function (val) {
                                    return val + " Rs. "
                                }
                            }
                        },

                    ]
                },
                grid: {
                    borderColor: '#f1f1f1',
                }
            },
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
                    categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
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
            series: [{
                name: 'Sales',
                data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
            }

            ],
            series2: [0, 0, 0, 0],
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

                                    return 1
                                }
                            }
                        }
                    }
                },
                labels: ['Available Product', 'Available Stock', 'Total Product', 'Not Available'],
            },

            req_d: {},
            account_payable: '',
            account_receivable: '',
            total_income: '',
            expense: '',
            overdue_po: '',
            overdue_sale: '',
            test_array: {},
            c1_name: '',
            c2_name: '',
            c3_name: '',
            c1_order: '0',
            c2_order: '0',
            c3_order: '0',

            v1_name: '',
            v2_name: '',
            v3_name: '',
            v1_order: '0',
            v2_order: '0',
            v3_order: '0',
            toggle:true,
            adsdata: {},
            adsdata2: {},
            adsdata3: {},
            adsdata4: {},
            adsdata5: {},
        }
    },
    methods: {
        set4() {
            this.toggle=false
            let d = 0;
            for (let i in this.i_value) {
                d = d + parseInt(this.i_value[i].TotalPrice);
            }
            for (let i in this.i_value) {
                let totalPrice = parseInt(this.i_value[i].TotalPrice);
                let percentage = ((totalPrice / d) * 100).toFixed(2);
                this.options5.labels.push(`${this.i_value[i].ProjectName} - ${totalPrice} (${percentage}%)`);
                this.series6[i] = parseFloat(percentage);

            }
        },

   
    },
    mounted() {

       

        axios.get('account_stock_counter')
            .then(data => {
                this.radio = data.data;
            })

        axios.get('stock_sum')
            .then(data => {
                this.avail_stock = data.data[0].Total;
            })
        axios.get('Accounts/fetch_dashboard_customers')
            .then(response => {
                if (response.data.length == 1) {
                    this.c1_name = response.data[0].CustomerName;
                    this.c1_order = response.data[0].TotalOrder;
                } else if (response.data.length == 2) {
                    this.c2_name = response.data[1].CustomerName;
                    this.c2_order = response.data[1].TotalOrder;
                } else if (response.data.length == 3) {
                    this.c3_name = response.data[2].CustomerName;
                    this.c3_order = response.data[2].TotalOrder;
                }
            })
        axios.get('Accounts/fetch_dashboard_vendors')
            .then(response => {
                this.v1_name = response.data[0].VendorName;
                this.v1_order = response.data[0].TotalOrder;
                this.v2_name = response.data[1].VendorName;
                this.v2_order = response.data[1].TotalOrder;
                this.v3_name = response.data[2].VendorName;
                this.v3_order = response.data[2].TotalOrder;
            })
        axios.get('accounts/get_sum_accounts_data/')
            .then(response => {
                this.test_array = response.data;

            })

        axios.get('Accounts/count_sales_d/')
            .then(response => {
                this.dde = response.data;
             
                        this.series = [{
                            name: 'Sales',
                            data: this.dde
                        }
                        ]

                  
            })

        axios.get('Accounts/count_revenue_d/')
            .then(response => {
                this.dre = response.data;
                axios.get('Accounts/count_expense_d/')
                    .then(data => {
                        this.drf = data.data;
                        this.series1 = [{
                            name: 'Revenue',
                            data: this.dre
                        },
                            {
                                name: 'Expense',
                                data: this.drf
                            },
                        ]
                    })
            })
        axios.get('Accounts/get_d_purchase/')
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
        axios.get('Accounts/get_d_sale/')
            .then(response => {
                this.adsdata2 = response.data;
            })
        axios.get('Accounts/get_d_payment/')
            .then(response => {
                this.adsdata3 = response.data;
            })
        axios.get('Accounts/get_d_received/')
            .then(response => {
                this.adsdata4 = response.data;
            })
        axios.get('Accounts/get_d_jv/')
            .then(response => {
                this.adsdata5 = response.data;
            })
        axios.get('accounts/get_Issuance_value_project').then(response => {
            this.i_value = response.data;
            this.set4();
        })

    }
}

</script>
