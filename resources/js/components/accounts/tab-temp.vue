<template>
    <div class="row match-height">
        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
            <div class="card top-radius bottom-radius border-0">
                <div class="card-header">
                    <h4 class="card-title">Transaction Detail</h4>
                    <span class="badge rounded-pill badge-light-primary">Top Five</span>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs main_nav" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active nav_link" id="assets-detail-tab" data-bs-toggle="tab" href="#assets-detail"
                                aria-controls="home" role="tab" aria-selected="true">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-home">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg>
                                Purchase
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav_link" id="department-wise-tab" data-bs-toggle="tab" href="#department-wise"
                                aria-controls="profile" role="tab" aria-selected="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-tool">
                                    <path
                                        d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z">
                                    </path>
                                </svg>
                                Sale
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#vendor-wise" id="vendor-wise-tab" class="nav-link nav_link" data-bs-toggle="tab"
                                role="tab" aria-selected="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-eye-off">
                                    <path
                                        d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24">
                                    </path>
                                    <line x1="1" y1="1" x2="23" y2="23"></line>
                                </svg>
                                Payment Voucher
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav_link" id="item-category-tab" data-bs-toggle="tab" href="#item-category"
                                aria-controls="about" role="tab" aria-selected="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-user">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                Received Voucher
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav_link" id="cycle-vendor-wise-tab" data-bs-toggle="tab" href="#cycle-vendor-wise"
                                aria-controls="about" role="tab" aria-selected="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-user">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                Journal Voucher
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="assets-detail" aria-labelledby="assets-detail-tab" role="tabpanel">
                            <datatable :limit="10" :data="adsdata" :columns="columns1"
                                                    :on-click="click">
                                                </datatable>
                        </div>
                        <div class="tab-pane" id="department-wise" aria-labelledby="department-wise-tab" role="tabpanel">
                            <datatable :data="adsdata1" :columns="columns4"></datatable>
                        </div>
                        <div class="tab-pane" id="vendor-wise" aria-labelledby="vendor-wise-tab" role="tabpanel">
                            <datatable :data="pr_vendor" :columns="columns5"></datatable>
                        </div>
                        <div class="tab-pane" id="item-category" aria-labelledby="item-category-tab" role="tabpanel">
                            <datatable :data="pr_item" :columns="columns7"></datatable>
                        </div>
                        <div class="tab-pane" id="cycle-vendor-wise" aria-labelledby="cycle-vendor-wise-tab" role="tabpanel">
                            <datatable :data="days_vendor" :columns="columns8"></datatable>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
