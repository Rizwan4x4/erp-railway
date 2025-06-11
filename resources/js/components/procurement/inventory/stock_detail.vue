<template>
    <div>
        <!-- BEGIN: Content-->
        <div class="app-content content">
            <div class="content-overlay"></div>
            <div class="-tem-change"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <router-link
                                    to="/accounts"
                                    style="text-decoration: none"
                                    >Accounts Dashboard</router-link
                                >
                            </li>
                            <li class="breadcrumb-item active">Stock Detail</li>
                        </ol>
                    </div>
                </div>
                <div class="content-body">
                    <!-- users list start -->
                    <section class="app-user-list">
                        <div class="row">
                            <div class="col-xl-2 col-md-4 col-sm-6">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <div
                                            class="avatar bg-light-info p-50 mb-1"
                                        >
                                            <div class="avatar-content">
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    width="14"
                                                    height="14"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    class="feather feather-eye font-medium-5"
                                                >
                                                    <path
                                                        d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"
                                                    ></path>
                                                    <circle
                                                        cx="12"
                                                        cy="12"
                                                        r="3"
                                                    ></circle>
                                                </svg>
                                            </div>
                                        </div>
                                        <h2 class="fw-bolder">
                                            {{ counter.total_products }}
                                        </h2>
                                        <p class="card-text">Total Products</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-4 col-sm-6">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <div
                                            class="avatar bg-light-warning p-50 mb-1"
                                        >
                                            <div class="avatar-content">
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    width="14"
                                                    height="14"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    class="feather feather-message-square font-medium-5"
                                                >
                                                    <path
                                                        d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"
                                                    ></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <h2 class="fw-bolder">
                                            {{ counter.available_products }}
                                        </h2>
                                        <p class="card-text">
                                            Available Products
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-4 col-sm-6">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <div
                                            class="avatar bg-light-danger p-50 mb-1"
                                        >
                                            <div class="avatar-content">
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    width="14"
                                                    height="14"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    class="feather feather-shopping-bag font-medium-5"
                                                >
                                                    <path
                                                        d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"
                                                    ></path>
                                                    <line
                                                        x1="3"
                                                        y1="6"
                                                        x2="21"
                                                        y2="6"
                                                    ></line>
                                                    <path
                                                        d="M16 10a4 4 0 0 1-8 0"
                                                    ></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <h2 class="fw-bolder">
                                            {{ counter.not_available }}
                                        </h2>
                                        <p class="card-text">Not Available</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-4 col-sm-6">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <div
                                            class="avatar bg-light-primary p-50 mb-1"
                                        >
                                            <div class="avatar-content">
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    width="14"
                                                    height="14"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    class="feather feather-heart font-medium-5"
                                                >
                                                    <path
                                                        d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"
                                                    ></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <h2 class="fw-bolder">
                                            {{ counter.available_stock }}
                                        </h2>
                                        <p class="card-text">Available Stock</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-4 col-sm-6">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <div
                                            class="avatar bg-light-success p-50 mb-1"
                                        >
                                            <div class="avatar-content">
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    width="14"
                                                    height="14"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    class="feather feather-award font-medium-5"
                                                >
                                                    <circle
                                                        cx="12"
                                                        cy="8"
                                                        r="7"
                                                    ></circle>
                                                    <polyline
                                                        points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"
                                                    ></polyline>
                                                </svg>
                                            </div>
                                        </div>
                                        <div v-if="stockloader">
                                            <div
                                                class="spinner-border spinner-border-lg mt-2"
                                                role="status"
                                            ></div>
                                        </div>
                                        <div v-else>
                                            <h2 class="fw-bolder">
                                                {{ counters.stock_value }}
                                            </h2>
                                        </div>
                                        <p class="card-text">Stock Value</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-4 col-sm-6">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <div
                                            class="avatar bg-light-danger p-50 mb-1"
                                        >
                                            <div class="avatar-content">
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    width="14"
                                                    height="14"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    class="feather feather-truck font-medium-5"
                                                >
                                                    <rect
                                                        x="1"
                                                        y="3"
                                                        width="15"
                                                        height="13"
                                                    ></rect>
                                                    <polygon
                                                        points="16 8 20 8 23 11 23 16 16 16 16 8"
                                                    ></polygon>
                                                    <circle
                                                        cx="5.5"
                                                        cy="18.5"
                                                        r="2.5"
                                                    ></circle>
                                                    <circle
                                                        cx="18.5"
                                                        cy="18.5"
                                                        r="2.5"
                                                    ></circle>
                                                </svg>
                                            </div>
                                        </div>
                                        <h2 class="fw-bolder">
                                            {{ counter.expired_items }}
                                        </h2>
                                        <p class="card-text">Expired Items</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="card"
                            style="background-color: white !important"
                        >
                            <div class="card-body border-bottom">
                                <h4 class="card-title">Search & Filter</h4>
                                <div class="row">
                                    <!--                                    <div class="col-md-3 user_status">-->
                                    <!--                                        <label class="form-label" for="UserRole">By Name</label>-->
                                    <!--                                        <div class="dataTables_filter" style="">-->
                                    <!--                                            <label>-->
                                    <!--                                                <input autocomplete="off" id="keyword1" type="text" name="keyword1" v-model="keyword1" class="form-control" style="" placeholder="Search By Name" />-->
                                    <!--                                            </label>-->
                                    <!--                                        </div>-->
                                    <!--                                    </div>-->
                                    <div class="col-md-3 user_status">
                                        <div
                                            class="dt-buttons d-inline-flex mt-50"
                                        >
                                            <router-link
                                              v-if="hasPermission('Inventory StockDetail stock-adjustment') "
                                                to="/inventory/adjustment"
                                                class="btn btn-primary waves-effect"
                                                >Inventory
                                                Adjustment</router-link
                                            >
                                            <button
                                                v-else
                                                class="btn btn-danger waves-effect"
                                            >
                                                Inventory Adjustment
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--                            <div class="table-responsive" style="overflow-x: initial !important;">-->
                            <!--                                <table class="table">-->
                            <!--                                    <thead>-->
                            <!--                                        <tr>-->
                            <!--                                            <th style="text-align:center; vertical-align:middle !important;">ItemCode</th>-->
                            <!--                                            <th style="vertical-align:middle !important;">Product Name</th>-->
                            <!--                                            <th style="text-align:center; vertical-align:middle !important;">Category Name</th>-->
                            <!--                                            <th style="text-align:center; vertical-align:middle !important;">Availabe Quantity</th>-->
                            <!--                                            <th  style="text-align:center; vertical-align:middle !important;">Cost Value</th>-->

                            <!--                                            <th style="text-align:center; vertical-align:middle !important;">Action</th>-->
                            <!--                                        </tr>-->
                            <!--                                    </thead>-->
                            <!--                                    <tbody>-->
                            <!--                                        <tr class="odd" v-for="adsdata1 in adsdata">-->
                            <!--                                            <td class=" control" tabindex="0" style="text-align:center;">{{adsdata1.ItemCode}}</td>-->
                            <!--                                            <td class=" control" tabindex="0">{{adsdata1.Name}}</td>-->
                            <!--                                            <td class=" control" tabindex="0" style="text-align:center;">{{adsdata1.CategoryName}}</td>-->
                            <!--                                            <td class=" control" tabindex="0" style="text-align:center;">{{adsdata1.Qty}}</td>-->
                            <!--                                            <td class=" control" tabindex="0" style="text-align:center;">{{Number(adsdata1.AVG)}}</td>-->

                            <!--                                            <td class=" control" tabindex="0" style="text-align:center;">-->
                            <!--                                                <div class="d-flex align-items-center col-actions">-->
                            <!--                                                    <a @click="getitemdata(adsdata1.ItemID)" class="me-25" data-bs-toggle="modal" data-bs-target="#viewstock">-->
                            <!--                                                        <i class="fa-solid fa-eye"></i>-->
                            <!--                                                    </a>-->
                            <!--                                                </div>-->
                            <!--                                            </td>-->
                            <!--                                        </tr>-->
                            <!--                                    </tbody>-->
                            <!--                                </table>-->
                            <!--                            </div>-->

                            <!--                            <div style="text-align:center;padding-top:20px">-->
                            <!--                            </div>-->
                            <div
                                class="d-flex justify-content-center"
                                v-if="loader"
                            >
                                <div
                                    class="spinner-border spinner-border-lg mt-2"
                                    role="status"
                                    style="width: 10rem; height: 10rem"
                                ></div>
                            </div>

                            <div v-else>
                                <div class="fixed-height-table">
                                    <vue-good-table
                                        :columns="columns"
                                        :rows="adsdata"
                                        :search-options="{
                                            enabled: true,
                                        }"
                                        :stickyHeader="true"
                                        :pagination-options="{
                                            enabled: true,
                                            perPageDropdown: [
                                                10, 20, 50, 100, 500, 1000,
                                            ],
                                        }"
                                    >
                                        <template
                                            slot="table-row"
                                            slot-scope="props"
                                        >
                                            <span
                                                v-if="
                                                    props.column.field ==
                                                    'action'
                                                "
                                            >
                                                <a
                                                    @click="
                                                        getitemdata(
                                                            props.row.ItemID
                                                        )
                                                    "
                                                    class="me-25"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#viewstock"
                                                >
                                                    <i
                                                        class="fa-solid fa-eye"
                                                    ></i>
                                                </a>
                                            </span>
                                        </template>
                                    </vue-good-table>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- users list ends -->
                </div>
                <div
                    class="modal fade"
                    id="viewstock"
                    tabindex="-1"
                    aria-hidden="true"
                >
                    <div
                        class="modal-dialog modal-lg modal-dialog-centered modal-edit-user"
                    >
                        <div class="modal-content">
                            <div class="modal-header bg-transparent">
                                <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal"
                                    aria-label="Close"
                                ></button>
                            </div>
                            <div class="col-xl-12 col-md-12 col-12">
                                <div class="card invoice-preview-card">
                                    <div class="card-body invoice-padding pb-0">
                                        <div
                                            class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0"
                                        >
                                            <div class="col-md-6">
                                                <h3 style="text-align: center">
                                                    Product
                                                </h3>
                                                <h3 style="text-align: center">
                                                    Available Stock
                                                </h3>
                                            </div>
                                            <div class="col-md-6">
                                                <h3
                                                    style="
                                                        text-align: center;
                                                        padding-top: 30px;
                                                    "
                                                >
                                                    {{ Number(getitemtotal) }}
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="divider">
                                        <div
                                            class="divider-text"
                                            style="
                                                font-size: 24px;
                                                font-weight: 900;
                                            "
                                        >
                                            Stock Overall Detail
                                        </div>
                                    </div>

                                    <!-- Address and Contact ends -->
                                    <!-- Invoice Description starts -->
                                    <!-- Address and Contact ends -->
                                    <!-- Invoice Description starts -->
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th class="py-1">Date</th>
                                                    <th class="py-1">
                                                        Item Name
                                                    </th>
                                                    <th class="py-1">
                                                        Category
                                                    </th>
                                                    <th class="py-1">
                                                        Quantity
                                                    </th>
                                                    <th class="py-1">Unit</th>
                                                    <th class="py-1">
                                                        Reference
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr
                                                    v-for="getitemwise1 in getitemwise"
                                                >
                                                    <td class="py-1">
                                                        <span class="fw-bold">{{
                                                            getitemwise1.Dated
                                                        }}</span>
                                                    </td>
                                                    <td class="py-1">
                                                        <span class="fw-bold">{{
                                                            getitemwise1.Name
                                                        }}</span>
                                                    </td>
                                                    <td class="py-1">
                                                        <span class="fw-bold">{{
                                                            getitemwise1.CategoryName
                                                        }}</span>
                                                    </td>
                                                    <td class="py-1">
                                                        <span class="fw-bold">{{
                                                            getitemwise1.Quantity
                                                        }}</span>
                                                    </td>
                                                    <td class="py-1">
                                                        <span class="fw-bold">{{
                                                            getitemwise1.Unit
                                                        }}</span>
                                                    </td>
                                                    <td class="py-1">
                                                        <p
                                                            class="card-text fw-bold mb-25"
                                                        >
                                                            {{
                                                                getitemwise1.Reference
                                                            }}
                                                        </p>
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
    </div>
</template>
<script>
import "vue-good-table/dist/vue-good-table.css";
import { VueGoodTable } from "vue-good-table";
export default {
    components: {
        VueGoodTable,
    },
    data() {
        return {
            loader: true,
            columns: [
                {
                    label: "ITEM CODE",
                    field: "ItemCode",
                    type: "string",
                    class: "sticky-th-center",
                },
                {
                    label: "PRODUCT NAME",
                    field: "Name",
                    type: "string",
                    class: "sticky-th-center",
                },
                {
                    label: "CATEGORY NAME",
                    field: "CategoryName",
                    type: "string",
                    class: "sticky-th-center",
                },
                {
                    label: "AVAILABLE QUANTITY",
                    field: "Qty",
                    type: "number",
                    class: "sticky-th-center",
                },
                {
                    label: "AVG VALUE",
                    field: "CostUnit",
                    type: "number",
                    class: "sticky-th-center",
                },
                {
                    label: "FACE VALUE",
                    field: "FaceValue",
                    type: "number",
                    class: "sticky-th-center",
                },
                {
                    label: "ACTION",
                    field: "action",
                    class: "sticky-th-center",
                },
            ],
            user_access: {},
            companydetail: {},
            stockloader: true,
            counters: {},
            adsdata: {},
            success: "",
            keyword1: "",

            category: "",
            e_search: "",
            count_users: {},
            getitemwise: {},
            itemid: "",
            getitemtotal: "",
            counter: {},
        };
    },
    methods: {
        getitemdata(id) {
            this.itemid = id;
            axios
                .get("accounts/getindstock/" + this.itemid)
                .then((response) => (this.getitemwise = response.data))
                .catch((error) => {});
            axios
                .get("accounts/getindtotalstock/" + this.itemid)
                .then(
                    (response) =>
                        (this.getitemtotal = response.data[0].Remaining)
                );
        },
        getResult(page = 1) {
            axios
                .get("accounts/stock_detail/?page=" + page)
                .then((response) => {
                    this.loader = false;
                    this.adsdata = response.data;
                    this.adsdata.filter((val) => {
                        val.CostUnit = Number(val.CostUnit);
                        val.Qty = Number(val.Qty);
                        val.FaceValue = Number(val.FaceValue);
                    });
                })
                .catch((error) => {
                    this.loader = false;
                    this.$toastr.e(error.response.data.message);
                });
        },
        getResults() {
            axios
                .get("./search_item", { params: { keyword1: this.keyword1 } })
                .then((response) => (this.adsdata = response.data))
                .catch((error) => console.log(error));
        },
    },
    watch: {
        keyword1(after, before) {
            this.getResults();
        },
    },
    mounted() {
        this.getResult();

        axios
            .get("fetch_companydetail")
            .then((response) => (this.companydetail = response.data));

        axios
            .get("./account_stock_counter1")
            .then((response) => {
                this.stockloader = false;
                this.counters = response.data;
            })
            .catch((error) => {
                this.stockloader = false;
            });

        axios
            .get("./fetch_user_audit_roles")
            .then((response) => (this.user_access = response.data));

        axios
            .get("account_stock_available")
            .then((res) => {
                this.counter = res.data.data;
            })
            .catch((err) => {
                console.log(err);
            });
    },
};
</script>
<style>
.vgt-responsive {
    height: 560px;
    overflow-y: auto;
}
.vgt-table thead {
    position: sticky;
    top: 0;
    background-color: #F8F8F8;
}
.vgt-global-search__input{
    flex-grow: 0;
}
</style>

