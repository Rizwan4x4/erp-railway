/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue').default;

import Vue from 'vue';
import VueRouter from 'vue-router';
import 'bootstrap/dist/css/bootstrap.css';
import {BootstrapVue, IconsPlugin} from 'bootstrap-vue';
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
// import 'bootstrap/dist/css/bootstrap.css';
// import 'bootstrap-vue/dist/bootstrap-vue.css';
const EventBus = new Vue();

export default EventBus;
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)
Vue.use(VueRouter)
import VueToastr from "vue-toastr";
// use plugin

// const toastrOptions = {
//     defaultTimeout: 500000, // Set the default timeout in milliseconds (e.g., 5000ms or 5 seconds)
//     position: "top-right", // Set the position of the toastr notifications
//     // Add any other options you want to customize
//   };
Vue.use(VueToastr);
import VueApexCharts from 'vue-apexcharts'
Vue.use(VueApexCharts)

// import vfr from 'vue_form_repeater';

// Vue.use(vfr);
Vue.component('apexchart', VueApexCharts)
Vue.component('pagination', require('laravel-vue-pagination'));

import VueTour from 'vue-tour'
require('vue-tour/dist/vue-tour.css')
Vue.use(VueTour)
import fullCalendar from 'vue-fullcalendar'
import RoleAccordions from './components/client_admin_side/RoleAccordions.vue';

Vue.component('role-accordion', RoleAccordions);

import loader from "vue-ui-preloader";
Vue.use(loader);
import Popover from 'vue-js-popover';
 Vue.use(Popover)

import Multiselect from 'vue-multiselect'
Vue.component('multiselect', Multiselect);

import VueHtml2pdf from 'vue-html2pdf'
Vue.component('VueHtml2pdf', VueHtml2pdf);

import DateRangePicker from 'vue2-daterange-picker';
Vue.component('DateRangePicker', DateRangePicker);

// Vue.config.devtools = false
// Vue.config.debug = false
// Vue.config.silent = true


import * as helpers from './helper/helper';
Vue.prototype.$helpers = helpers;
import * as apihelpers from './helper/apihelper';
Vue.prototype.$apihelpers = apihelpers;



const permissionMixin = {
    methods: {
      hasPermission(permission) {
        // Access the hasPermission function from this.$helpers
        return this.$helpers.hasPermission(permission);
      },
    },
  };

  // Apply the global mixin to all Vue components
  Vue.mixin(permissionMixin);
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
const PdcReceivable = require('./components/accounts/PdcReceivable.vue').default;
// vue.component('chart', require('./components/human_resource/chart.vue').default);

const sam_voucher = require('./components/accounts/unit_pending_sam_voucher.vue').default;
const create_received_voucher2 = require('./components/accounts/sale_received_voucher2.vue').default;
const calander = require('./components/layout/hr_calander.vue').default;
const dashboard=  require('./components/main_dashboard.vue').default;
const comp_dashboard=require('./components/layout/company_dashboard.vue').default;
Vue.component('footer_bottom', require('./components/footer.vue').default);
Vue.component('navbar', require('./components/layout/navbar.vue').default);

Vue.component('navbar1', require('./components/layout/navbar1.vue').default);
Vue.component('mainmenu1', require('./components/layout/mainmenu1.vue').default);
Vue.component('mainmenu', require('./components/layout/mainmenu.vue').default);
Vue.component('main_dashboard', require('./components/main_dashboard.vue').default);
const create_company=require('./components/layout/create_company.vue').default;
const chat=require('./components/layout/chat.vue').default;
const overall_companies=require('./components/layout/overall_companies.vue').default;
const company_detail=require('./components/layout/company_detail.vue').default;
const company_edit=require('./components/layout/company_edit.vue').default;
//const forget_password=require('./components/user_folder/forget_password.vue').default;
//user-admin side components
const users_page=require('./components/client_admin_side/users_page.vue').default;
const rolesandPermissions=require('./components/client_admin_side/RolesAndPermissions.vue').default;
const CreateRoles=require('./components/client_admin_side/CreateRoles.vue').default;
const create_user=require('./components/client_admin_side/create_user.vue').default;
const location_detail=require('./components/client_admin_side/location_detail.vue').default;
const designation_detail=require('./components/client_admin_side/designation_detail.vue').default;
const department_detail=require('./components/client_admin_side/department_detail.vue').default;
const activity_log = require('./components/client_admin_side/activity_log.vue').default;
const update_user=require('./components/client_admin_side/update_user.vue').default;
const faq_page = require('./components/client_admin_side/faq.vue').default;
Vue.component('login_page', require('./components/client_admin_side/login_page.vue').default);


//HR SIDE
const py_tax_holding=require('./components/payroll/py_tax_holding.vue').default;
const fuel_allowance = require('./components/payroll/py_allowance_fuel.vue').default;
const fuelallowance = require('./components/payroll/Fuelallowance.vue').default;
const fuel_bills = require('./components/payroll/py_bill_fuel.vue').default;
const fuelbill_detail = require('./components/payroll/py_fuelbill_detail.vue').default;
const py_stipend = require('./components/payroll/py_stipend.vue').default;


const hr_dashboard=require('./components/human_resource/humanresource_dashboard.vue').default;
const hr_employee_detail=require('./components/human_resource/hr_employee_detail.vue').default;
const employee_detail=require('./components/human_resource/ind_employee_detail.vue').default;
const employee_perfomance=require('./components/human_resource/ind_employee_connection.vue').default;
const create_employee=require('./components/human_resource/hr_create_employee.vue').default;
const create_employee_education=require('./components/human_resource/hr_create_emp_education.vue').default;
const create_employee_experience=require('./components/human_resource/hr_create_emp_experience.vue').default;
const create_employee_employeement=require('./components/human_resource/hr_create_emp_employment.vue').default;
const edit_employee=require('./components/human_resource/hr_edit_employee.vue').default;
const update_employee_profile=require('./components/human_resource/update_employee_profile.vue').default;
const update_education_profile=require('./components/human_resource/update_education_profile.vue').default;
const create_documents=require('./components/human_resource/ind_documents.vue').default;

const update_experience_profile=require('./components/human_resource/update_experience_profile.vue').default;
const warning_detail=require('./components/human_resource/hr_warning_detail.vue').default;
const warning_view=require('./components/human_resource/hr_warning_view.vue').default;
const warning_create=require('./components/human_resource/hr_warning_create.vue').default;
const hr_reports=require('./components/human_resource/hr_reports.vue').default;
//attendance
const hr_att_rosters=require('./components/human_resource/hr_att_rosters.vue').default;
const attendance_grace_periods=require('./components/human_resource/attendance_grace_periods.vue').default;
const hr_attendance_dashboard=require('./components/human_resource/hr_attendance_dashboard.vue').default;
const hr_attendance_machines = require('./components/human_resource/hr_attendance_machines.vue').default;
const hr_attendance_emp=require('./components/human_resource/hr_emp_att_detail.vue').default;
const hr_emp_overtime=require('./components/human_resource/hr_emp_att_overtime.vue').default;
const hr_leaves_detail=require('./components/human_resource/hr_leaves_dashboard.vue').default;

const int_att = require('./components/human_resource/hr_team_member_att.vue').default; //individual team member attandence
const ind_view_dashboard=require('./components/human_resource/ind_view_dashboard.vue').default;
const ind_team_attendance=require('./components/human_resource/ind_team_attendance.vue').default;
const ind_emp_detail=require('./components/human_resource/ind_emp_detail.vue').default;
const hr_controller=require('./components/human_resource/hr_controller.vue').default;
const hr_configuration=require('./components/human_resource/hr_configuration.vue').default;
const employee_all_leaves = require('./components/human_resource/hr_leaves.vue').default;
// const team_leaves = require('./components/human_resource/hr_leaves_team.vue').default;
const final_settlement = require('./components/payroll/final_settlement.vue').default;
//Recruitment components
Vue.component('all_jobs', require('./components/layout/allJobs.vue').default);



const club_register = require('../js/admin/clubManagement/pages/clubRegister.vue').default;
const member_register = require('../js/admin/clubManagement/pages/memberRegister.vue').default;
const club_member_fee = require('../js/admin/clubManagement/pages/clubMembersFee.vue').default;

const NotPermission = require('../js/admin/Roles/NotPermission.vue').default;


const recruitment_jobs = require('./components/recruitement/jobs.vue').default;
const recruitment_job_detail = require('./components/recruitement/job_details.vue').default;
const recruitment_candidates = require('./components/recruitement/candidates.vue').default;
const recruitment_interviews = require('./components/recruitement/interviews.vue').default;
const recruitment_dashboard = require('./components/recruitement/rec_dashboard.vue').default;

//Payroll dashboard
const advance_loans = require('./components/payroll/py_loan.vue').default;
const payroll_pending_salaries=require('./components/payroll/payroll_pending_salaries.vue').default;
const py_salary_generation = require('./components/payroll/py_salary_generation.vue').default;

const payroll_employees_detail= require('./components/payroll/payroll_employees_detail.vue').default;
const payroll_hr_approval= require('./components/payroll/payroll_hr_approval.vue').default;
const payroll_finance_approval= require('./components/payroll/payroll_finance_approval.vue').default;
const payroll_distribution=require('./components/payroll/payroll_distribution.vue').default;
const payroll_arrears=require('./components/payroll/py_arrears.vue').default;
const payroll_bonuses=require('./components/payroll/py_bonuses.vue').default;
const payroll_dues=require('./components/payroll/py_dues.vue').default;
const payroll_allowance=require('./components/payroll/py_allowance.vue').default;
const payroll_cash_distribution=require('./components/payroll/payroll_cash_distribution.vue').default;

//payroll_arrears

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


//Accounts
const acc_dashboard = require('./components/accounts/accounts_dashboard.vue').default;
const accounting_edit_si = require('./components/accounts/accounting_edit_si.vue').default;
const config_general = require('./components/accounts/config_general.vue').default;
const accounts_session = require('./components/accounts/confg_accounts_sessions.vue').default;
const currencies = require('./components/accounts/confg_currencies.vue').default;
const product_categories = require('./components/accounts/confg_products_categories.vue').default;
const acc_heads_types = require('./components/accounts/confg_acc_heads_types.vue').default;
const confg_taxes = require('./components/accounts/confg_taxes.vue').default;
const confg_coa = require('./components/accounts/confg_coa.vue').default;
const confg_payment_terms = require('./components/accounts/payment_terms.vue').default;
const sales_customer_details = require('./components/accounts/sales_customer_detail.vue').default;

const sales_invoice = require('./components/accounts/sales_invoice.vue').default;
const sales_invoice_detail = require('./components/accounts/sales_invoice_detail.vue').default;
const sales_received_voucher_detail = require('./components/accounts/sales_payment_received_detail.vue').default;
const sales_received_voucher = require('./components/accounts/sales_received_voucher.vue').default;
const create_credit_notes = require('./components/accounts/sales_credit_notes.vue').default;
const credit_notes_detail = require('./components/accounts/sales_credit_notes_detail.vue').default;
const sales_quotation = require('./components/accounts/sales_quotation.vue').default;
const sales_quotation_detail = require('./components/accounts/sales_quotation_detail.vue').default;
const purchase_payment_voucher_detail = require('./components/accounts/purchase_payment_detail.vue').default;
const create_payment_voucher = require('./components/accounts/purchase_payment_voucher.vue').default;
const create_debit_notes = require('./components/accounts/purchase_debit_notes.vue').default;
const credit_debit_detail = require('./components/accounts/purchase_debit_note_detail.vue').default;
//Vouchers
const accounting_jv_detail = require('./components/accounts/Vouchers/accounting_jv_detail.vue').default;
const accounting_jv_create = require('./components/accounts/Vouchers/accounting_jv_create.vue').default;
const accounting_edit_jv = require('./components/accounts/Vouchers/accounting_edit_jv.vue').default;

const accounting_delivery = require('./components/accounts/config_delivery.vue').default;
const account_reports = require("./components/accounts/account_reports.vue").default;
const assets_detail = require("./components/accounts/assets_detail.vue").default;
const sales_return_detail = require('./components/accounts/sales_return_detail.vue').default;
const sales_return = require('./components/accounts/sales_return.vue').default;
const banksdetail = require('./components/accounts/config_banks.vue').default;

const user_base_access = require('./components/accounts/user_base_access.vue').default;
const pattycash_access = require('./components/accounts/pattycash_access.vue').default;
const petty_cash_detail = require('./components/accounts/petty_cash_detail.vue').default;
const create_petty_cash = require('./components/accounts/create_petty_cash.vue').default;
const unit_controller = require('./components/accounts/unit_controller.vue').default;
const cash_counter = require('./components/accounts/cash_counter.vue').default;
const pending_booking = require('./components/accounts/unit_pending_booking.vue').default;

//Procurement/INVENTORY

const pending_cash = require('./components/accounts/unit_pending_cash.vue').default;
const pending_chq = require('./components/accounts/unit_pending_chq.vue').default;
const PdcPayable = require('./components/accounts/PdcPayable.vue').default;
const edit_pettycash = require('./components/accounts/edit_pettycash.vue').default;
const pending_electricity = require('./components/accounts/unit_pending_electricity.vue').default;
const pending_services = require('./components/accounts/unit_services.vue').default;
const pending_dbt = require('./components/accounts/unit_pending_dbt.vue').default;
const pending_online = require('./components/accounts/unit_pending_online.vue').default;
const service_bill_detail = require('./components/accounts/service_bill_detail.vue').default;
const service_bill_create = require('./components/accounts/service_bill.vue').default;
const pending_dealervoucher = require('./components/accounts/units_dealer_voucher.vue').default;
const assets_retirement = require('./components/accounts/assets_retirement.vue').default;



const time_adjustment = require('./components/human_resource/time_adjustment.vue').default;
const hr_department_detail = require('./components/human_resource/hr_department_detail.vue').default;
const seller_detail = require('./components/accounts/seller_detail.vue').default;
const add_land_record = require('./components/accounts/add_land_record.vue').default;

const payroll_Dashboard = require('./components/payroll/payroll_Dashboard.vue').default;//payroll dashboard
const land_payment_detail = require('./components/accounts/land_payment_detail.vue').default;

const py_welfare_allowance = require('./components/payroll/py_welfare_allowance.vue').default;
const assets_depresciassion = require('./components/accounts/assets_depresciassion.vue').default;
const assets_book = require('./components/accounts/assets_book.vue').default;
const create_assets_depreciation = require('./components/accounts/create_assets_depreciation.vue').default;
const units_refund = require('./components/accounts/units_refund.vue').default;
const pending_adjust = require('./components/accounts/unit_pending_adjust.vue').default;

const membersFees = require('./admin/clubManagement/pages/membersFees.vue').default;

console.log(membersFees)
//Procurement
const purchase_services_requisition = require('./components/procurement/purchase_services_requisition.vue').default;
const purchase_assets_requisition = require('./components/procurement/purchase_assets_requisition.vue').default;
const demand_requisition_services = require('./components/procurement/demand_requisition_services.vue').default;
const demand_requisition_assets = require('./components/procurement/demand_requisition_assets.vue').default;
const purchase_merge_requisition = require('./components/procurement/purchase_merge_requisition.vue').default;
const requistion_detail = require('./components/procurement/purchase_requistion_detail.vue').default;
const purchase_vendor_detail = require('./components/procurement/purchase_vendor_detail.vue').default;
const purchase_po_detail = require('./components/procurement/po_detail.vue').default;
const purchase_po_create = require('./components/procurement/po_create.vue').default;
const purchase_inv_detail = require('./components/procurement/purchase_inv_detail.vue').default;
const create_quotation = require('./components/procurement/purchase_create_quotation.vue').default;
const purchase_return = require('./components/procurement/purchase_return_detail.vue').default;
const purchase_return_create = require('./components/procurement/purchase_return.vue').default;
const edit_quotation = require('./components/procurement/purchase_edit_quotation.vue').default;
const requistion_create = require('./components/procurement/purchase_requistion.vue').default;
const create_pinvoice = require('./components/procurement/create_pinvoice.vue').default;
const edit_perinvoice = require('./components/procurement/edit_pinvoice.vue').default;
const products_detail = require('./components/procurement/products_detail.vue').default;
const demand_requisition = require('./components/procurement/demand_requisition.vue').default;
const procurement_dashboard = require('./components/procurement/procurement_dashboard.vue').default;

//Procurement/INVENTORY
const stock_detail = require('./components/procurement/inventory/stock_detail.vue').default;
const grn_detail = require('./components/procurement/inventory/grn_detail.vue').default;
const create_grn = require('./components/procurement/inventory/create_grn.vue').default;
const issuance_detail = require('./components/procurement/inventory/issuance_detail.vue').default;
const create_issuance = require('./components/procurement/inventory/create_issuance.vue').default;
const inventory_adjustment = require('./components/procurement/inventory/inventory_adjustment.vue').default;
const issuance_return_detail = require('./components/procurement/inventory/issuance_return_detail.vue').default;
const issuance_return = require('./components/procurement/inventory/issuance_return.vue').default;
const create_site_issuance = require('./components/procurement/inventory/create_site_issuance.vue').default;
const PathNotFound = require('./components/404.vue').default;



const routes = [

    {
        path: '/Accounts/assets_retirement',
        name: 'assets_retirement',
        component:assets_retirement,
    },
    {
        path: '/accounts/land_payment_detail',
        name: 'land_payment_detail',
        component:land_payment_detail,
        meta: {
            permission: 'Units-Management units-data readOnly'
        }
    },
    {
        path: '/accounts/seller_detail',
        name: 'seller_detail',
        component:seller_detail,
        meta: {
            permission: 'Units-Management units-data readOnly'
        }
    },
    {
        path: '/accounts/add_land_record',
        name: 'add_land_record',
        component:add_land_record,
    },
    {
        path: '/dashboards/procurement',
        name: 'procurement_dashboard',
        component:procurement_dashboard,
        meta: {
            permission: 'Procurement Dashboard overall-view'
        }
    },
    {
        path: '/payroll',
        name: 'payroll_Dashboard',
        component:payroll_Dashboard,
        meta: {
            permission: 'Payroll Dashboard overall-view'
        }
    },

{
        path: '/Inventory/create_site_issuance',
        name: 'create_site_issuance',
        component:create_site_issuance,
        meta: {
            permission: 'Inventory Issuance create-issuance-site'
        }
    },

    {
        path: '/purchase/purchase_merge_requisition',
        name: 'purchase_merge_requisition',
        component:purchase_merge_requisition,
        meta: {
            permission: 'Purchase Requisition Merge'
        }
    },
    {
        path: '/purchase/demand_requisition',
        name: 'demand_requisition',
        component:demand_requisition,
        meta: {
            permission: 'Demand Requisition view'
        }
    },
    {
        path: '/Accounts/dealer_voucher',
        name: 'pending_dealervoucher',
        component: pending_dealervoucher,
    },
     {
        path: '/purchase/demand_requisition_services',
        name: 'demand_requisition_services',
        component:demand_requisition_services,
        meta: {
            permission: 'Demand Requisition Service View'
        }
    },
     {
        path: '/purchase/demand_requisition_assets',
        name: 'demand_requisition_assets',
        component:demand_requisition_assets,
        meta: {
            permission:   'Demand Requisition Assets View'
        }
    },



{
        path: '/Accounts/assets_depresciassion',
        name: 'assets_depresciassion',
        component:assets_depresciassion,
    },

    {
        path: '/Accounts/assets_book',
        name: 'assets_book',
        component:assets_book,
    },
    {
        path: '/Accounts/create_assets_depreciation',
        name: 'create_assets_depreciation',
        component:create_assets_depreciation,
    },

 {
        path: '/purchase/units_refund',
        name: 'units_refund',
        component: units_refund,
        meta: {
            permission: 'Units-Management units-data readOnly'
        }
    },
	{
        path: '/Accounts/pending_adjust',
        name: 'pending_adjust',
        component:pending_adjust,
        meta: {
            permission: 'Units-Management units-data readOnly'
        }
    },
    {
        path: '/sales/PdcReceivable',
        name: 'PdcReceivable',
        component:PdcReceivable,
        meta: {
            permission: 'Accounting Payment-voucher pdc'
        }
    },
    {
        path: '/accounting/accounting_edit_si/:id',
        name: 'accounting_edit_si',
        component:accounting_edit_si,
    },
    {
        path: '/sales/create_received_voucher2',
        name: 'create_received_voucher2',
        component:create_received_voucher2,
        meta: {
            permission: 'Accounting Receipt-voucher create-rv'
        }
    },
    {
        path: '/Accounts/Sam_Voucher',
        name: 'sam_voucher',
        component:sam_voucher,
        meta: {
            permission: 'Units-Management units-data readOnly'
        }
    },
 {
        path: '/Accounts/pending_online',
        name: 'pending_online',
        component:pending_online,
        meta: {
            permission: 'Units-Management units-data readOnly'
        }
    },
    {
        path: '/Accounts/pending_debit_credit',
        name: 'pending_dbt',
        component:pending_dbt,
        meta: {
            permission: 'Units-Management units-data readOnly'
        }
    },
    {
        path: '/ServiceBill',
        name: 'service_bill_detail',
        component: service_bill_detail,
    },
    {
        path: '/ServiceBill/Create',
        name: 'service_bill_create',
        component: service_bill_create,
    },
 {
        path: '/Accounts/pending_electricity',
        name: 'pending_electricity',
        component:pending_electricity,
        meta: {
            permission: 'Units-Management units-data readOnly'
        }
    },
{
        path: '/Accounts/pending_services',
        name: 'pending_services',
        component:pending_services,
        meta: {
            permission: 'Units-Management units-data readOnly'
        }
    },
    {
        path: '/edit_pettycash/:id',
        name: 'edit_pettycash',
        component: edit_pettycash,
    },
    {
        path: '/purchase/purchase_assets_requisition',
        name: 'purchase_assets_requisition',
        component: purchase_assets_requisition,
        meta: {
            permission:  'Purchase Requisition View Assets'
        }
    },
    {
        path: '/purchase/purchase_services_requisition',
        name: 'purchase_services_requisition',
        component: purchase_services_requisition,
        meta: {
            permission:'Purchase Requisition View Services'
        }
    },
    {
        path: '/accounting/PdcPayable',
        name: 'PdcPayable',
        component:PdcPayable,
        meta: {
            permission: 'Accounting Payment-voucher pdc'
        }
    },
    {
        path: '/Accounts/units_cash',
        name: 'pending_cash',
        component: pending_cash,
        meta: {
            permission: 'Units-Management units-data readOnly'
        }
    },
     {
        path: '/Accounts/units_chq',
        name: 'pending_chq',
        component: pending_chq,
        meta: {
            permission: 'Units-Management units-data readOnly'
        }
    },
    {
        path: '/Accounts/booking',
        name: 'pending_booking',
        component: pending_booking,
        meta: {
            permission: 'Units-Management units-data readOnly'
        }
    },
    {
        path: '/Accounts/cash_counter',
        name: 'cash_counter',
        component: cash_counter,
        meta: {
            permission: 'Units-Management units-data readOnly'
        }
    },
    {
        path: '/Accounts/units_controller',
        name: 'unit_controller',
        component: unit_controller,
        meta: {
            permission: 'Units-Management units-data readOnly'
        }
    },
    {
        path: '/petty_cash/detail',
        name: 'petty_cash_detail',
        component: petty_cash_detail,
           meta: {
            permission: 'Accounting petty-cash overall-view'
        }
    },
    {
        path: '/create_petty_cash',
        name: 'create_petty_cash',
        component: create_petty_cash,
         meta: {
            permission: 'Accounting petty-cash create-pettycash'
        }
    },
{
        path: '/Accounts/PettyCash',
        name: 'pattycash_access',
        component: pattycash_access,
        meta: {
            permission: 'Accounting pettycash_access overall-view'
        }
    },
{
        path: '/Accounts/user_base_access',
        name: 'user_base_access',
        component:user_base_access,
        meta: {
            permission: 'Accounts Configurations  department access'
        }
    },
 {
        path: '/Inventory/Issuance_return',
        name: 'issuance_return_detail',
        component:issuance_return_detail,
        meta: {
            permission: 'Inventory Issuance-return overall-view'
        }
    },
    {
        path: '/Inventory/Issuance_return/create',
        name: 'issuance_return',
        component: issuance_return,
        meta: {
            permission: 'Inventory Issuance-return create-issuance-return'
        }
    },
 {
        path: "/accounts/banksdetail",
        name: "banksdetail",
        component: banksdetail,
        meta: {
            permission: 'Accounts Configurations bank-detail'
        }
    },
    {
        path: "/accounts/report",
        name: "account_reports",
        component: account_reports,
        meta: {
            permission: 'Inventory Account-Reports overall'
        }
    },
    {
        path: "/accounts/assets_detail",
        name: "assets_detail",
        component: assets_detail,
        meta: {
            permission: 'Inventory Assets readyOnly'
        }
    },
    {
        path: '/purchase_invoice/detail',
        name: 'purchase_inv_detail',
        component: purchase_inv_detail,
        meta: {
            permission: 'Services Invoice View'
        }
    },

    {
        path: '/purchase_invoice/create_invoice',
        name: 'create_pinvoice',
        component:create_pinvoice,
        meta: {
            permission: 'Services Invoice Create'
        }
    },
    {
        path: '/purchase/quotation/:id/:rid',
        name: 'create_quotation',
        component: create_quotation,
    },
    {
        path: '/purchase/editquotation/:id/:rid',
        name: 'edit_quotation',
        component: edit_quotation,
    },


{
        path: '/sales-return/create',
        name: 'sales_return',
        component: sales_return,
    },

    {
        path: '/sales/return',
        name: 'sales_return_detail',
        component: sales_return_detail,
    },
    {
        path: '/inventory/adjustment',
        name: 'inventory_adjustment',
        component: inventory_adjustment,
        meta: {
            permission: 'Inventory StockDetail stock-adjustment'
        }
    },
    {
        path: '/purchase/return',
        name: 'purchase_return',
        component: purchase_return,
        meta: {
            permission: 'Purchase Returns View'
        }
    },
    {
        path: '/purchase/return/create',
        name: 'purchase_return_create',
        component: purchase_return_create,
        meta: {
            permission: 'Purchase Returns Create'
        }
    },
    {
        path: '/Inventory/create_issuance',
        name: 'create_issuance',
        component:create_issuance,
        meta: {
            permission: 'Inventory Issuance create-issuance'
        }
    },
    {
        path: '/Inventory/create_grn',
        name: 'create_grn',
        component:create_grn,
        meta: {
            permission: 'Inventory Grn create-grn'
        }
    },
    {
        path: '/Inventory/Issuance',
        name: 'issuance_detail',
        component:issuance_detail,
        meta: {
            permission: 'Inventory Issuance overall-view'
        }
    },
     {
        path: '/Inventory/Detail',
        name: 'stock_detail',
        component:stock_detail,
        meta: {
            permission: 'Inventory StockDetail overall-view'
        }
    },
    {
        path: '/Inventory/GRN',
        name: 'grn_detail',
        component:grn_detail,
        meta: {
            permission: ['Inventory Grn overall-view', 'GRN View']
        }
    },

 {
        path: '/accounts/delivery',
        name: 'accounting_delivery',
        component:accounting_delivery,
        meta: {
            permission: 'Accounting procurement-configuration Delivery'
        }
    },


    {
        path: '/accounts',
        name: 'acc_dashboard',
        component:acc_dashboard,
        meta: {
            permission: 'Accounts Dashboard overall-view'
        }
    },
    {
        path: '/accounting/journal_voucher',
        name: 'accounting_jv_detail',
        component:accounting_jv_detail,
        meta: {
            permission: 'Accounting journal_voucher overall-view'
        }
    },
    {
        path: '/payroll/py_welfare_allowance',
        name: 'py_welfare_allowance',
        component: py_welfare_allowance,
        meta: {
            permission: 'Payroll Welfare Allowances'
        }
    },
    {
        path: '/accounting/create_journal_voucher',
        name: 'accounting_jv_create',
        component:accounting_jv_create,
        meta: {
            permission: 'Accounting journal_voucher create-jv'
        }
    },
    {
        path: '/accounting/accounting_edit_jv/:id',
        name: 'accounting_edit_jv',
        component:accounting_edit_jv,
        meta: {
            permission: 'Accounting journal_voucher edit-jv'
        }
    },
    {
        path: '/purchase/create_debit_notes',
        name: 'create_debit_notes',
        component:create_debit_notes,
        meta: {
            permission: 'Accounting debit-notes create-dn'
        }
    },
    {
        path: '/purchase/debit_detail',
        name: 'credit_debit_detail',
        component:credit_debit_detail,
        meta: {
            permission: 'Accounting debit-notes overall-view'
        }
    },
    {
        path: '/purchase/create_payment_voucher',
        name: 'create_payment_voucher',
        component:create_payment_voucher,
        meta: {
            permission: 'Accounting Payment-voucher create-pv'
        }
    },
      {
        path: '/purchase_invoice/edit/:id',
        name: 'edit_perinvoice',
        component: edit_perinvoice,
    },
    {
        path: '/purchase/payment_detail',
        name: 'purchase_payment_voucher_detail',
        component:purchase_payment_voucher_detail,
        meta: {
            permission: 'Accounting Payment-voucher overall-view'
        }
    },

 {
        path: '/purchase/vendor_detail',
        name: 'purchase_vendor_detail',
        component:purchase_vendor_detail,
        meta: {
            permission: 'Accounting procurement-configuration vendors'
        }
    },
     {
        path: '/purchase/requistion_detail',
        name: 'requistion_detail',
        component:requistion_detail,
        meta: {
            permission: 'Purchase Requisition view'
        }
    },
    {
          path: '/purchase/requistion_create',
        name: 'requistion_create',
        component:requistion_create,
        meta: {
            permission: 'Demand Requisition Create'
        }
    },
    {
        path: '/purchase/detail',
        name: 'purchase_po_detail',
        component:purchase_po_detail,
        meta: {
            permission: 'Purchase Orders View'
        }
    },
    {
          path: '/purchase/create',
        name: 'purchase_po_create',
        component:purchase_po_create,
        meta: {
            permission: 'Purchase Orders Create'
        }
    },

    {
        path: '/sales/quotation',
        name: 'sales_quotation',
        component:sales_quotation,
    },
    {
          path: '/sales/quotation_detail',
        name: 'sales_quotation_detail',
        component:sales_quotation_detail,
    },


      {
        path: '/sales/create_credit_notes',
        name: 'create_credit_notes',
        component:create_credit_notes,
    },
    {
        path: '/sales/credit_notes_detail',
        name: 'credit_notes_detail',
        component:credit_notes_detail,
    },
        {
        path: '/sales/create_received_voucher',
        name: 'sales_received_voucher',
        component:sales_received_voucher,
    },
    {
        path: '/sales/received_voucher_detail',
        name: 'sales_received_voucher_detail',
        component:sales_received_voucher_detail,
        meta: {
            permission: 'Accounting Receipt-voucher overall-view'
        }
    },
    {
        path: '/sales/invoice_detail',
        name: 'sales_invoice_detail',
        component:sales_invoice_detail,
    },
     {
        path: '/sales/invoice',
        name: 'sales_invoice',
        component:sales_invoice,
    },
    {
        path: '/sales/customer_details',
        name: 'sales_customer_details',
        component:sales_customer_details,
    },
     {
        path: '/products_detail',
        name: 'products_detail',
        component:products_detail,
        meta: {
            permission: 'Inventory Products readOnly'
        }
    },

     {
        path: '/accounts/sessions',
        name: 'accounts_session',
        component:accounts_session,
        meta: {
            permission: 'Accounts Configurations  session'
        }
    },
    {
        path: '/accounts/currencies',
        name: 'currencies',
        component:currencies,
    },
    {
        path: '/accounts/product_categories',
        name: 'product_categories',
        component:product_categories,
        meta: {
            permission: 'Inventory Product-Categories readyOnly'
        }
    },
    {
        path: '/accounts/heads_types',
        name: 'acc_heads_types',
        component:acc_heads_types,
        meta: {
            permission: 'Accounts Configurations Accounts heads'
        }
    },
    {
        path: '/accounts/taxes',
        name: 'confg_taxes',
        component:confg_taxes,
        meta: {
            permission: 'Accounts Configurations  taxes'
        }
    },
     {
        path: '/accounts/chart_of_accounts',
        name: 'confg_coa',
        component:confg_coa,
        meta: {
            permission: 'Accounts Configurations COA'
        }
    },
    {
         path: '/accounts/payment_terms',
        name: 'confg_payment_terms',
        component:confg_payment_terms,
        meta: {
            permission: 'Accounts Configurations payment terms'
        }
    },

    {
         path: '/accounts/config',
        name: 'config_general',
        component:config_general,
        meta: {
            permission: 'Accounts Configurations  general'
        }
    },

//HRMS & PAYROLL
{
        path: '/payroll/payroll_pending_salaries',
        name: 'payroll_pending_salaries',
        component: payroll_pending_salaries,
        meta: {
            permission: 'Payroll Pending Salaries'
        }
    },
{
    path: '/pyroll/stipends',
    name: 'py_stipend',
    component: py_stipend,
    meta: {
        permission: 'Payroll employee Stipend Details'
    }
},
{
        path: '/payroll/fuelbills',
        name: 'fuelbill_detail',
        component: fuelbill_detail,
        meta: {
            permission: 'Fuel bills'
        }
    },
 {
        path: '/payroll/fuelbills/add',
        name: 'fuel_bills',
        component: fuel_bills,
        meta: {
            permission: 'Fuel new bill'
        }
    },
 {
        path: '/payroll/allowances/fuel',
        name: 'fuel_allowance',
        component: fuel_allowance,
        meta: {
            permission: 'Fuel Setting'
        }

    },
    {
        path: '/payroll/Fuelallowances',
        name: 'fuelallowance',
        component: fuelallowance,
        meta: {
            permission: 'Payroll Fuel Allowances'
        }
    },
    {
        path: '/payroll/employees_detail',
        name: 'payroll_employees_detail',
        component: payroll_employees_detail,
        meta: {
            permission: 'Payroll employee Salary Details'
        }
    },
    {
        path: '/payroll/taxholding',
        name: 'payroll_taxholding',
        component: py_tax_holding,
        meta: {
            permission: 'Payroll Taxes Details'
        }
    },

{
    path: '/calander',
    name: 'calander',
    component: calander,
    },
{
    path:'/FAQs',
    name:'faq_page',
    component: faq_page,
},
    {
        path: '/payroll/salary_generation',
        name: 'py_salary_generation',
        component: py_salary_generation,
        meta: {
            permission: 'Payroll Salary Processsing'
        }
    },
     {
        path: '/payroll/payroll_hr_approval',
        name: 'payroll_hr_approval',
        component: payroll_hr_approval,
        meta: {
            permission: 'Payroll HR Approval'
        }
    },
   {
        path: '/payroll/payroll_finance_approval',
        name: 'payroll_finance_approval',
        component: payroll_finance_approval,
        meta: {
            permission: 'Payroll Finance Approval'
        }
    },
    {
        path: '/payroll/distribution',
        name: 'payroll_distribution',
        component: payroll_distribution,
        meta: {
            permission: 'Payroll Salary Distribution'
        }
    },

   {
        path: '/payroll/loans',
        name: 'payroll_loans',
        component: advance_loans,
        meta: {
            permission: 'Payroll Loan and Advance'
        }
    },
    {
        path: '/hr/departments',
        name: 'hr_department_detail',
        component: hr_department_detail,
        meta: {
            permission: 'Department overall-view'
        }
    },
    {
        path: '/payroll/arrears',
        name: 'payroll_arrears',
        component: payroll_arrears,
        meta: {
            permission: 'Payroll Arrears'
        }
    },
    {
        path: '/hr/time_adjustment',
        name: 'time_adjustment',
        component: time_adjustment,
        meta: {
            permission: 'HRMS Attendance Time-Adjustment overall-view'
        }
    },
    {
        path: '/payroll/bonuses',
        name: 'payroll_bonuses',
        component: payroll_bonuses,
        meta: {
            permission: 'Payroll Bonuses'
        }

    },
    {
        path: '/payroll/dues',
        name: 'payroll_dues',
        component: payroll_dues,
        meta: {
            permission: 'Payroll Dues Details'
        }
    },
    {
        path: '/payroll/allowance',
        name: 'payroll_allowance',
        component: payroll_allowance,
        meta: {
            permission: 'Payroll Other Allowances'
        }
    },


{
        path: '/hr/member_att/:id',
        name: 'int_att',
        component: int_att,
    },
// {
//         path: '/hr/team_leaves',
//         name: 'team_leaves',
//         component: team_leaves,
//     },
{
    path:'/hr/leaves_dashbaord',
     name:'hr_leaves_detail',
    component:hr_leaves_detail,
    meta: {
        permission: 'HRMS leaves_detail overall-view-request'
    }
},
{
    path:'/hr/attendance_rosters',
     name:'hr_att_rosters',
    component:hr_att_rosters,
    meta: {
        permission: 'HRMS Attendance Shifts view'
    }
},
{
    path:'/hr/attendance_grace_periods',
     name:'attendance_grace_periods',
    component:attendance_grace_periods,
    meta: {
        permission: 'HRMS Attendance Grace-periods overall-view'
    }
},

{
    path:'/hr/update_employee_profile/:id',
     name:'update_employee_profile',
    component:update_employee_profile,
    meta: {
        permission: 'HRMS employees_detail update_employee_profile'
    }
},
{
    path:'/hr/organization_cart',
     name:'hr_controller',
    component:hr_controller,
    meta: {
        permission: 'HRMS Organization_Cart  view'
    }
},
{
    path:'/hr/configuration',
     name:'hr_configuration',
    component:hr_configuration,
    meta: {
        permission: 'HR Controller overall-view'
    }
},
{
        path: '/hr/employee_all_leaves',
        name: 'employee_all_leaves',
        component: employee_all_leaves,
        meta: {
            permission: 'HRMS leaves_detail overall-view'
        }
    },
{
    path:'/hr/emp_detail',
     name:'ind_emp_detail',
    component:ind_emp_detail,
},
{
    path:'/hr/team_attendance',
     name:'ind_team_attendance',
    component:ind_team_attendance,
},
{
        path: '/FinalSettlement',
        name: 'final_settlement',
        component: final_settlement,
        meta: {
            permission: 'Payroll Final Settlement'
        }
    },
{
    path:'/',
     name:'ind_view_dashboard',
    component:ind_view_dashboard,
},
{
    path:'/hr/employee_dashboard',
     name:'ind_view_dashboard',
    component:ind_view_dashboard,
},
{
    path:'/hr/all_attendance',
     name:'hr_attendance_emp',
    component:hr_attendance_emp,
    meta: {
        permission: 'HRMS Attendance Overall-Attendance overall-view'
    }
},
{
    path:'/hr/overtime',
     name:'hr_emp_overtime',
    component:hr_emp_overtime,
    meta: {
        permission: 'HRMS Attendance Employees-Overtime overall-view'
    }
},
{
    path:'/hr/live_attendance',
     name:'hr_attendance_dashboard',
    component:hr_attendance_dashboard,
    meta: {
        permission: 'HRMS Attendance overall-view'
    }
},
{
    path:'/hr/live_devices',
    name:'hr_attendance_machines',
    component: hr_attendance_machines,
},
{
    path:'/hr/reports',
     name:'hr_reports',
    component:hr_reports,
    meta: {
        permission: 'HRMS HR-Reports  view'
    }
},
{
    path:'/hr/warning_detail',
     name:'warning_detail',
    component:warning_detail,
    meta: {
        permission: 'HRMS warning_detail overall-view'
    }
},
{
    path:'/hr/create_warning',
     name:'warning_create',
    component:warning_create,
    meta: {
        permission: 'HRMS warning_detail create_warning'
    }

},
{
    path:'/hr/warning_view/:id',
     name:'warning_view',
    component:warning_view,
    meta: {
        permission: 'HRMS warning_detail actions'
    }
},
{
    path:'/hr/employee_perfomance',
     name:'employee_perfomance',
    component:employee_perfomance,
},

{
    path:'/hr/create_employee',
     name:'create_employee',
    component:create_employee,
    meta: {
        permission: 'HRMS employees_detail create_employee'
    }
},
{
    path:'/hr/edit_employee',
     name:'edit_employee',
    component:edit_employee,
},
{
    path:'/hr/employee_education/:id',
     name:'create_employee_education',
    component:create_employee_education,
},
{
    path:'/hr/update_education_profile/:id',
     name:'update_education_profile',
    component:update_education_profile,
    meta: {
        permission: 'HRMS employees_detail update employee_education'
    }
},
{
    path:'/hr/update_experience_profile/:id',
     name:'update_experience_profile',
    component:update_experience_profile,
    meta: {
        permission: 'HRMS employees_detail update employee_experience'
    }
},
{
    path:'/hr/add_documents/:id',
     name:'create_documents',
    component:create_documents,
    meta: {
        permission: 'HRMS employees_detail  add_documents'
    }
},

{
    path:'/hr/employee_experience/:id',
     name:'create_employee_experience',
    component:create_employee_experience,
},
{
    path:'/hr/employee_employeement/:id',
     name:'create_employee_employeement',
    component:create_employee_employeement,
    meta: {
        permission: 'HRMS employees_detail update employee_employeement'
    }
},
{
    path:'/hr/employee_detail/:id',
     name:'employee_detail',
    component:employee_detail,
    meta: {
        permission: 'HRMS employees_detail view employee profile'
    }
},
{
    path:'/hr/employees_detail',
     name:'hr_employee_detail',
    component:hr_employee_detail,
    meta: {
        permission: 'HRMS employees_detail overall-view'
    }
},
{
    path:'/hr/dashboard',
     name:'hr_dashboard',
    component:hr_dashboard,
    meta: {
        permission: 'Human Resource Dashboard overall-view'
    }
},
{
    path:'/settings/users',
     name:'users_page',
    component:users_page,
    meta: {
        permission: 'User Details oervall-view'
    }
},
{
    path:'/settings/rolesPermissions',
     name:'rolesandPermissions',
    component:rolesandPermissions,
    meta: {
        permission: 'Admin Created Roles view'
    }
},
{
    path:'/settings/createRoles',
     name:'CreateRoles',
    component:CreateRoles,
    meta: {
        permission: 'Admin Create Role view'
    }
},
{
        path: '/settings/activity_log',
        name: 'activity_log',
        component: activity_log,
        meta: {
            permission: 'Activity Log oervall-view'
        }
    },
{
    path:'/settings/location_detail',
     name:'location_detail',
    component:location_detail,
    meta: {
        permission: 'Work Location overall-view'
    }
},
{
    path:'/settings/designation_detail',
     name:'designation_detail',
    component:designation_detail,
    meta: {
        permission: 'Designantion overall-view'
    }
},
{
    path:'/settings/department_detail',
     name:'department_detail',
    component:department_detail,
    meta: {
        permission: 'AC Department oervall-view'
    }
},

{
    path:'/settings/create_user',
     name:'create_user',
    component:create_user,
    meta: {
        permission: 'User Details AddUser'
    }
},
{
    path:'/settings/update_user/:id',
     name:'update_user',
    component:update_user,
},
// {
//     path:'/',
//      name:'dashboard',
//     component:dashboard,
// },
{
    path:'/chat',
     name:'chat',
    component:chat,
},
{
    path:'/create_company',
     name:'create_company',
    component:create_company,
},
{
    path:'/overall_companies',
     name:'overall_companies',
    component:overall_companies,
},
{
    path:'/company_detail/:id',
     name:'company_detail',
    component:company_detail,
},
{
    path:'/company_edit/:id',
     name:'company_edit',
    component:company_edit,
},



    {
    path:'/company_dashboard',
    name:'comp_dashboard',
    component: comp_dashboard,
    },
 {
        path: '/recruitment/recDashboard',
        name: 'recruitment_dashboard',
        component: recruitment_dashboard,
        meta: {
            permission: 'Recuriment Dashboard overall-view'
        }
    },
    {
        path: '/recruitment/interviews',
        name: 'recruitment_interviews',
        component: recruitment_interviews,
        meta: {
            permission: 'Recruitment Interview view'
        }
    },
    {
        path: '/recruitment/candidates',
        name: 'recruitment_candidates',
        component: recruitment_candidates,
        meta: {
            permission: 'Recruitment Candidates view'
        }
    },
    // Club Management
    {
        path:'/admin/clubRegister',
        name: 'club_register',
        component: club_register,
        meta: {
            permission: 'Admin Club Management View Create Club Tab'
        }
    },
    {
        path: '/admin/memberRegister',
        name: 'member_register',
        component: member_register,
        meta: {
            permission: 'Admin Club Management View Register Member Tab'
        }
    },

    {
        path: '/admin/clubMembersFee',
        name: 'club_member_fee',
        component: club_member_fee,
        meta: {
            permission: 'Admin Club Management View Club Member Fees Tab'
        }
    },
    {
        path: '/admin/membersFees',
        name: 'membersFees',
        component: membersFees,
        meta: {
            permission: 'Admin Club Management View Member Fees Tab'
        }
    },

    {
        path: '/recruitment/job/detail/:id',
        name: 'recruitment_job_detail',
        component: recruitment_job_detail,
    },
    {
        path: '/recruitment/jobs',
        name: 'recruitment_jobs',
        component:recruitment_jobs,
        meta: {
            permission: 'Recruitment job opening view'
        }
    },
    {
        path: '/NotPermission',
        name: 'Not_Permission',
        component:NotPermission,
        meta: {
            permission: 'Recruitment job opening view'
        }
    },
      {
            path: '/:pathMatch(.*)*',
         component: PathNotFound
          },

];

const router= new VueRouter({
    routes,
})
function getPermissions() {
    axios.get('get_permissions', {
    })
        .then(data => {
            console.log(data.data.data)
            localStorage.setItem('permissions', JSON.stringify(data.data.data));
        })
        .catch(err => {
            console.log(err)
        })
}
var permissions = JSON.parse(localStorage.getItem('permissions') || '[]');

router.beforeEach(async (to, from, next) => {
    const requiredPermissions = to.meta.permissions;  // Change to 'permissions'

    // Check if the route has required permissions
    if (requiredPermissions && Array.isArray(requiredPermissions)) {
        // Check if the user has at least one of the required permissions
        if (requiredPermissions.some(permission => permissions.includes(permission))) {
            // User has at least one of the permissions, proceed to the route
            next();
        } else {
            console.log("redirect to another one");

            // Check if the route is already the "Not_Permission" route
            if (to.name !== 'Not_Permission') {
                // User doesn't have any of the permissions, redirect to NoPermission component
                next({ name: 'Not_Permission' });
            } else {
                // Avoid infinite loop by not redirecting if already on the "Not_Permission" route
                next();
            }
        }
    } else {
        // If the route doesn't require permissions, proceed to the route
        next();
    }
});


const app = new Vue({
    data: {
        selectedPermissions: [], // Define the global selectedPermissions array here
      },
    el: '#app',
    router,
});
