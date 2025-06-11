<template>
<div>
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow-tem-change"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <router-link to="/accounts" style="text-decoration: none;">Accounts Dashboard</router-link>
                        </li>
                        <li class="breadcrumb-item active">Accounts & Procurement Repor-ts</li>
                    </ol>
                </div>
            </div>
            <div class="content-body">
                <div class="card">
                    <div class="row" style="margin-left: 10px; margin-top: 15px;">
                        <div class="col-md-4" v-if=" (this.$helpers.hasPermission('Inventory Account-Reports accounting') || this.$helpers.hasPermission('Inventory Account-Reports overall'))">
                            <accounts_reports :start_date="start_date" :end_date="end_date" />
                        </div>
                        <div class="col-md-4" v-if=" (this.$helpers.hasPermission('Inventory Account-Reports sales') || this.$helpers.hasPermission('Inventory Account-Reports overall'))">
                            <sales_reports :start_date="start_date" :end_date="end_date" />
                        </div>
                        <div class="col-md-4" v-if="(this.$helpers.hasPermission('Inventory Account-Reports purchase') || this.$helpers.hasPermission('Inventory Account-Reports overall'))">
                            <purchase_reports :optionsdept1="optionsdept"  :optionsdemand1="optionsdemand" :optionsrid1="optionsrid" :start_date="start_date" :end_date="end_date" />  </div>
                        <div class="col-md-4 ms-3" v-if="(this.$helpers.hasPermission('Inventory Account-Reports inventory') || this.$helpers.hasPermission('Inventory Account-Reports overall'))">
                            <inventory_reports :start_date="start_date" :end_date="end_date" :optionsdept1="optionsdept" />

                        </div>
                        <div class="col-md-5 ms-3" style="margin-top: 30px" v-if="(this.$helpers.hasPermission('Inventory Account-Reports inventory-statements') || this.$helpers.hasPermission('Inventory Account-Reports overall'))">
                            <inv_statement_reports :start_date="start_date" :end_date="end_date" :optionsdept1="optionsdept"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>

import Multiselect from 'vue-multiselect'
import accounts_reports from './reports/accounts_reports.vue';
import purchase_reports from './reports/purchase_reports.vue';
import sales_reports from './reports/sales_reports.vue';
import inventory_reports from './reports/inventory_reports.vue';
import inv_statement_reports from './reports/inv_statement_reports.vue';

export default {
  name: 'App',

      data() {
        return {
            start_date: '00-00-0020',
            end_date: '99-99-9999',
            optionsdept: [],
            optionsrid: [],
            optionsdemand: [],

        }
    },
    components: {
        Multiselect,
        accounts_reports,
        purchase_reports,
        sales_reports,
        inventory_reports,
        inv_statement_reports
    },
    watch: {
        genPdfLoader(after, before) {

        },
        pagination(after, before) {

        },
        allLedger(after, before) {

        },

    },
    methods: {


    },
    mounted() {


        axios.get("accounts_session_detail1")
            .then((response) => {
                this.start_date = response.data[0].StartDate.split(" ")[0]
                this.end_date = response.data[0].EndDate.split(" ")[0]

            })
            axios.get('accounts/dept_data')
                .then(response => {

                    this.departments1 = response.data
                    this.optionsdept = [];

                    var $this = this;
                    for (var i = 0; i < $this.departments1.length; i++) {
                        this.optionsdept.push($this.departments1[i].COmpanyName);
                    }

                })

        axios.get("requisition_detail_report").then((response) => {
            this.req_details = response.data
            this.optionsrid = [];

            var $this = this;
            for (var i = 0; i < $this.req_details.length; i++) {
                this.optionsrid.push($this.req_details[i].RId);
            }

        })

        axios.get("accounts/demand_requisition_all").then((response) => {
            this.demand_list = response.data
            this.optionsdemand = [];

            var $this = this;
            for (var i = 0; i < $this.demand_list.length; i++) {
                this.optionsdemand.push($this.demand_list[i].RId);
            }
        })



    }
}
</script>

<style scoped>
@keyframes ldio-qxxhsg5wen {
    0% {
        opacity: 1
    }

    50% {
        opacity: .5
    }

    100% {
        opacity: 1
    }
}

.ldio-qxxhsg5wen div {
    position: absolute;
    width: 20px;
    height: 80px;
    top: 60px;
    animation: ldio-qxxhsg5wen 1s cubic-bezier(0.5, 0, 0.5, 1) infinite;
}

.ldio-qxxhsg5wen div:nth-child(1) {
    transform: translate(30px, 0);
    background: #e15b64;
    animation-delay: -0.6s;
}

.ldio-qxxhsg5wen div:nth-child(2) {
    transform: translate(70px, 0);
    background: #f47e60;
    animation-delay: -0.4s;
}

.ldio-qxxhsg5wen div:nth-child(3) {
    transform: translate(110px, 0);
    background: #f8b26a;
    animation-delay: -0.2s;
}

.ldio-qxxhsg5wen div:nth-child(4) {
    transform: translate(150px, 0);
    background: #abbd81;
    animation-delay: -1s;
}

.loadingio-spinner-bars-0opevbvvjcw {
    width: 200px;
    height: 200px;
    display: inline-block;
    overflow: hidden;
    background: #ffffff;
}

.ldio-qxxhsg5wen {
    width: 100%;
    height: 100%;
    position: relative;
    transform: translateZ(0) scale(1);
    backface-visibility: hidden;
    transform-origin: 0 0;
    /* see note above */
}

.ldio-qxxhsg5wen div {
    box-sizing: content-box;
}

/* generated by https://loading.io/ */
.ng-star-inserted>a {
    cursor: pointer;
    border-bottom: 1px dashed #ccc;
    padding-top: 5px;
    padding-bottom: 5px;
    display: block;
    max-width: 250px;
    margin-left: 20px;
    color: #2485e8;
    text-decoration: none;
}

.mt-HeaderDialouge .table-responsive {
    height: calc(80vh - 100px);
    overflow-y: auto;
}

.td-center {
    z-index: 1;
    text-align: center;
    vertical-align: middle !important;
}
    .reports-th-center {
        z-index: 1;
        position: sticky;
        top: 0px !important;
        text-align: center;
        vertical-align: middle !important;
    }
    .reports-th-left {
        z-index: 1;
        position: sticky;
        top: 94px;
        text-align: left;
        vertical-align: middle !important;
    }
    .pa-2{
        padding: 1.5rem !important;
    }
.reports-th-center {
    z-index: 1;
    position: sticky;
    top: 0px;
    text-align: center;
    vertical-align: middle !important;
}
.reports-th-left {
    z-index: 1;
    position: sticky;
    top: 94px;
    text-align: left;
    vertical-align: middle !important;
}
</style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
