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
                                <li class="breadcrumb-item">
                                    <router-link to="/accounts" style="text-decoration: none;">Accounts Dashboard
                                    </router-link>
                                </li>
                                <li class="breadcrumb-item active">Chart of Accounts
                                </li>
                        </ol>
                    </div>
                </div>
                <div class="content-body">
                    <section class="app-user-view-account">
                        <div class="row">
                            <!-- User Sidebar -->
                            <!--/ User Sidebar -->
                            <div class="col-xl-12 col-lg-12 col-md-12 order-1 order-md-0">
                                <!-- User Card -->
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Chart of Accounts Detail</h4>
                                        <div style="text-align: right;width: 30% !important;">
                                            <a v-if="hasPermission('Accounts Configurations  create-COA')" style="float:left" data-bs-toggle="modal" data-bs-target="#addNewCard"
                                               class="btn btn-outline-primary waves-effect" type="button">Create New</a>
                                            <div class="" style="float:right">
                                                <div style=""><label>
                                                    <input autocomplete="off" class="form-control" v-model="keyword1"
                                                           style="" placeholder="Search By Name"/>
                                                </label></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div style="margin-bottom:20px;"
                                             class="d-flex justify-content-between align-items-center header-actions mx-2 row mt-75">
                                            <section id="accordion-with-border">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div id="accordionWrapa50" role="tablist"
                                                             aria-multiselectable="true">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-md-4"
                                                                             style="border-right: 1px solid lightgray;padding-right: 0px">
                                                                            <div class=""
                                                                                 style="background:#0d6efd !important;margin-bottom:10px;padding:4px;border-radius:0px !important;font-size:16px">
                                                                                <h6 style="color:white !important">
                                                                                    Types</h6>
                                                                            </div>
                                                                            <ul id="myUL">
                                                                                <li><span class="caret"
                                                                                          @click="fetch_overall_coa2()">{{ this.company_name }}</span>
                                                                                    <ul class="nested">
                                                                                        <li @click="fetch_types_menu('Assets');fetch_types('Assets');">
                                                                                            <span class="caret">1 : Assets</span>
                                                                                            <ul class="nested">
                                                                                                <li v-for="fetch_menu_journals1 in fetch_menu_journals"
                                                                                                    @click="fetch_journal_data_assets(fetch_menu_journals1.journalCode)">
                                                                                                    <span class="caret">{{ fetch_menu_journals1.journalCode }} : {{ fetch_menu_journals1.JournalName }}</span>
                                                                                                    <ul>
                                                                                                        <li v-if="fetch_menu_journals1.journalCode==code"
                                                                                                            class="caret"
                                                                                                            v-for="curr_assets_list1 in curr_assets_list"
                                                                                                            :key="curr_assets_list1"
                                                                                                            @click.stop="nested_curr_Assets(curr_assets_list1.ID)">
                                                                                                            {{ curr_assets_list1.ID }}:
                                                                                                            {{ curr_assets_list1.AccountName }}
                                                                                                            <ul>
                                                                                                                <li v-if="curr_assets_list1.ID==code1"
                                                                                                                    class="caret"
                                                                                                                    v-for="curr_assets_nestedlist1 in curr_assets_nestedlist"
                                                                                                                    :key="curr_assets_nestedlist1"
                                                                                                                    @click.stop="fullnested_curr_Assets(curr_assets_nestedlist1.ID)">
                                                                                                                    {{
                                                                                                                        curr_assets_nestedlist1.ID
                                                                                                                    }}:
                                                                                                                    {{
                                                                                                                        curr_assets_nestedlist1.AccountName
                                                                                                                    }}
                                                                                                                    <ul>
                                                                                                                        <li v-if="curr_assets_nestedlist1.ID==code10"
                                                                                                                            class="caret"
                                                                                                                            v-for="curr_assets_fullnestedlist1 in curr_assets_fullnestedlist"
                                                                                                                            :key="curr_assets_fullnestedlist1">
                                                                                                                            {{
                                                                                                                                curr_assets_fullnestedlist1.ID
                                                                                                                            }}:
                                                                                                                            {{
                                                                                                                                curr_assets_fullnestedlist1.AccountName
                                                                                                                            }}

                                                                                                                        </li>
                                                                                                                    </ul>
                                                                                                                </li>
                                                                                                            </ul>
                                                                                                        </li>
                                                                                                    </ul>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </li>
                                                                                        <li @click="fetch_types_menu2('Liabilities');fetch_types('Liabilities');">
                                                                                            <span class="caret">2 : Liabilities</span>
                                                                                            <ul class="nested">
                                                                                                <li v-for="fetch_menu_journals22 in fetch_menu_journals2"
                                                                                                    @click="fetch_journal_data_liab(fetch_menu_journals22.journalCode)">
                                                                                                    <span class="caret">{{ fetch_menu_journals22.journalCode }} : {{ fetch_menu_journals22.JournalName }}</span>
                                                                                                    <ul>
                                                                                                        <li v-if="fetch_menu_journals22.journalCode==code2"
                                                                                                            class="caret"
                                                                                                            v-for="curr_liab_list1 in curr_liab_list"
                                                                                                            :key="curr_liab_list1"
                                                                                                            @click.stop="nested_curr_liab(curr_liab_list1.ID)">
                                                                                                            {{ curr_liab_list1.ID }}:
                                                                                                            {{ curr_liab_list1.AccountName }}
                                                                                                            <ul>
                                                                                                                <li v-if="curr_liab_list1.ID==code3"
                                                                                                                    class="caret"
                                                                                                                    v-for="curr_liab_nestedlist1 in curr_liab_nestedlist"
                                                                                                                    :key="curr_liab_nestedlist1"
                                                                                                                    @click.stop="fullnested_curr_liab(curr_liab_nestedlist1.ID)">
                                                                                                                    {{
                                                                                                                        curr_liab_nestedlist1.ID
                                                                                                                    }}:
                                                                                                                    {{
                                                                                                                        curr_liab_nestedlist1.AccountName
                                                                                                                    }}
                                                                                                                    <ul>
                                                                                                                        <li v-if="curr_liab_nestedlist1.ID==code11"
                                                                                                                            class="caret"
                                                                                                                            v-for="curr_liab_fullnestedlist1 in curr_liab_fullnestedlist"
                                                                                                                            :key="curr_liab_fullnestedlist1">
                                                                                                                            {{
                                                                                                                                curr_liab_fullnestedlist1.ID
                                                                                                                            }}:
                                                                                                                            {{
                                                                                                                                curr_liab_fullnestedlist1.AccountName
                                                                                                                            }}

                                                                                                                        </li>
                                                                                                                    </ul>
                                                                                                                </li>
                                                                                                            </ul>
                                                                                                        </li>
                                                                                                    </ul>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </li>
                                                                                        <li @click="fetch_types_menu3('Equity');fetch_types('Equity');">
                                                                                            <span class="caret">3 : Equity</span>
                                                                                            <ul class="nested">
                                                                                                <li v-for="fetch_menu_journals33 in fetch_menu_journals3"
                                                                                                    @click="fetch_journal_data_equity(fetch_menu_journals33.journalCode)">
                                                                                                    <span class="caret">{{ fetch_menu_journals33.journalCode }} : {{ fetch_menu_journals33.JournalName }}</span>
                                                                                                    <ul>
                                                                                                        <li v-if="fetch_menu_journals33.journalCode==code4"
                                                                                                            class="caret"
                                                                                                            v-for="curr_equity_list1 in curr_equity_list"
                                                                                                            :key="curr_equity_list1"
                                                                                                            @click.stop="nested_curr_equity(curr_equity_list1.ID)">
                                                                                                            {{ curr_equity_list1.ID }}:
                                                                                                            {{ curr_equity_list1.AccountName }}
                                                                                                            <ul>
                                                                                                                <li v-if="curr_equity_list1.ID==code5"
                                                                                                                    class="caret"
                                                                                                                    v-for="curr_equity_nestedlist1 in curr_equity_nestedlist"
                                                                                                                    :key="curr_equity_nestedlist1"
                                                                                                                    @click.stop="fullnested_curr_equity(curr_equity_nestedlist1.ID)">
                                                                                                                    {{
                                                                                                                        curr_equity_nestedlist1.ID
                                                                                                                    }}:
                                                                                                                    {{
                                                                                                                        curr_equity_nestedlist1.AccountName
                                                                                                                    }}
                                                                                                                    <ul>
                                                                                                                        <li v-if="curr_equity_nestedlist1.ID==code12"
                                                                                                                            class="caret"
                                                                                                                            v-for="curr_equity_fullnestedlist1 in curr_equity_fullnestedlist"
                                                                                                                            :key="curr_equity_fullnestedlist1">
                                                                                                                            {{
                                                                                                                                curr_equity_fullnestedlist1.ID
                                                                                                                            }}:
                                                                                                                            {{
                                                                                                                                curr_equity_fullnestedlist1.AccountName
                                                                                                                            }}

                                                                                                                        </li>
                                                                                                                    </ul>
                                                                                                                </li>
                                                                                                            </ul>
                                                                                                        </li>
                                                                                                    </ul>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </li>
                                                                                        <li @click="fetch_types_menu4('Income');fetch_types('Income');">
                                                                                            <span class="caret">4 : Income</span>
                                                                                            <ul class="nested">
                                                                                                <li v-for="fetch_menu_journals44 in fetch_menu_journals4"
                                                                                                    @click="fetch_journal_data_income(fetch_menu_journals44.journalCode)">
                                                                                                    <span class="caret">{{ fetch_menu_journals44.journalCode }} : {{ fetch_menu_journals44.JournalName }}</span>
                                                                                                    <ul>
                                                                                                        <li v-if="fetch_menu_journals44.journalCode==code6"
                                                                                                            class="caret"
                                                                                                            v-for="curr_income_list1 in curr_income_list"
                                                                                                            :key="curr_income_list1"
                                                                                                            @click.stop="nested_curr_income(curr_income_list1.ID)">
                                                                                                            {{ curr_income_list1.ID }}:
                                                                                                            {{ curr_income_list1.AccountName }}
                                                                                                            <ul>
                                                                                                                <li v-if="curr_income_list1.ID==code7"
                                                                                                                    class="caret"
                                                                                                                    v-for="curr_income_nestedlist1 in curr_income_nestedlist"
                                                                                                                    :key="curr_income_nestedlist1"
                                                                                                                    @click.stop="fullnested_curr_income(curr_income_nestedlist1.ID)">
                                                                                                                    {{
                                                                                                                        curr_income_nestedlist1.ID
                                                                                                                    }}:
                                                                                                                    {{
                                                                                                                        curr_income_nestedlist1.AccountName
                                                                                                                    }}
                                                                                                                    <ul>
                                                                                                                        <li v-if="curr_income_nestedlist1.ID==code13"
                                                                                                                            class="caret"
                                                                                                                            v-for="curr_income_fullnestedlist1 in curr_income_fullnestedlist"
                                                                                                                            :key="curr_income_fullnestedlist1">
                                                                                                                            {{
                                                                                                                                curr_income_fullnestedlist1.ID
                                                                                                                            }}:
                                                                                                                            {{
                                                                                                                                curr_income_fullnestedlist1.AccountName
                                                                                                                            }}

                                                                                                                        </li>
                                                                                                                    </ul>
                                                                                                                </li>
                                                                                                            </ul>
                                                                                                        </li>
                                                                                                    </ul>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </li>
                                                                                        <li @click="fetch_types_menu5('Expenses');fetch_types('Expenses');">
                                                                                            <span class="caret">5 : Expenses</span>
                                                                                            <ul class="nested">
                                                                                                <li v-for="fetch_menu_journals55 in fetch_menu_journals5"
                                                                                                    @click="fetch_journal_data_expenses(fetch_menu_journals55.journalCode)">
                                                                                                    <span class="caret">{{ fetch_menu_journals55.journalCode }} : {{ fetch_menu_journals55.JournalName }}</span>
                                                                                                    <ul>
                                                                                                        <li v-if="fetch_menu_journals55.journalCode==code8"
                                                                                                            class="caret"
                                                                                                            v-for="curr_expenses_list1 in curr_expenses_list"
                                                                                                            :key="curr_expenses_list1"
                                                                                                            @click.stop="nested_curr_expenses(curr_expenses_list1.ID)">
                                                                                                            {{ curr_expenses_list1.ID }}:
                                                                                                            {{ curr_expenses_list1.AccountName }}
                                                                                                            <ul>
                                                                                                                <li v-if="curr_expenses_list1.ID==code9"
                                                                                                                    class="caret"
                                                                                                                    v-for="curr_expenses_nestedlist1 in curr_expenses_nestedlist"
                                                                                                                    :key="curr_expenses_nestedlist1"
                                                                                                                    @click.stop="fullnested_curr_expenses(curr_expenses_nestedlist1.ID)">
                                                                                                                    {{
                                                                                                                        curr_expenses_nestedlist1.ID
                                                                                                                    }}:
                                                                                                                    {{
                                                                                                                        curr_expenses_nestedlist1.AccountName
                                                                                                                    }}
                                                                                                                    <ul>
                                                                                                                        <li v-if="curr_expenses_nestedlist1.ID==code14"
                                                                                                                            class="caret"
                                                                                                                            v-for="curr_expenses_fullnestedlist1 in curr_expenses_fullnestedlist"
                                                                                                                            :key="curr_expenses_fullnestedlist1">
                                                                                                                            {{
                                                                                                                                curr_expenses_fullnestedlist1.ID
                                                                                                                            }}:
                                                                                                                            {{
                                                                                                                                curr_expenses_fullnestedlist1.AccountName
                                                                                                                            }}

                                                                                                                        </li>
                                                                                                                    </ul>
                                                                                                                </li>
                                                                                                            </ul>
                                                                                                        </li>
                                                                                                    </ul>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </li>


                                                                                    </ul>
                                                                                </li>
                                                                            </ul>


                                                                        </div>
                                                                        <div class="col-md-8" style="padding-left: 0px">
                                                                            <div class=""
                                                                                 style="background:#0d6efd !important;padding:4px;border-radius:0px !important;font-size:16px">
                                                                                <h6 style="color:white !important">
                                                                                    Detail</h6>
                                                                            </div>
                                                                            <div class="table-responsive"
                                                                                 style="overflow-x: initial !important;">
                                                                                <table class="table table-hover">
                                                                                    <thead>
                                                                                    <tr>
                                                                                        <th>Code</th>
                                                                                        <th>Account Name</th>
                                                                                        <th>Type</th>
                                                                                        <th>Journal Head</th>
                                                                                        <th>Head Code</th>
                                                                                        <th>COA Type</th>
                                                                                    </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                    <tr class="odd"
                                                                                        v-for="fetch_overall_coa1 in fetch_overall_coa">
                                                                                        <td>
                                                                                            {{ fetch_overall_coa1.ID }}
                                                                                        </td>
                                                                                        <td>
                                                                                            {{ fetch_overall_coa1.AccountName }}
                                                                                        </td>
                                                                                        <td>
                                                                                            {{ fetch_overall_coa1.AccountType }}
                                                                                        </td>
                                                                                        <td>
                                                                                            {{ fetch_overall_coa1.AccountHead }}
                                                                                        </td>
                                                                                        <td>
                                                                                            {{ fetch_overall_coa1.AccountCode }}
                                                                                        </td>
                                                                                        <td>
                                                                                            {{ fetch_overall_coa1.CoaType }}
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
                                            </section>
                                        </div>
                                    </div>
                                </div>
                                <!-- /User Card -->
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <div class="modal fade" id="addNewCard" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <h3 class="text-center mb-1" id="addNewCardTitle">Create New Ledger Account</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-sm-5 mx-50 pb-5">
                        <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="col-md-12 col-12">
                                <label class="form-label" for="modalAddCardName">Account Name <span
                                    style="color:red">*</span></label>
                                <input type="text" v-model="account_name" class="form-control" style=""/>
                            </div>
                            <div class="col-md-12 col-12">
                                <label class="form-label" for="modalAddCardName">Type <span
                                    style="color:red">*</span></label>
                                <select @change="fetch_mainhead()" class="form-select" v-model="account_type">
                                    <option value="">Select Account Type</option>
                                    <option v-for='get_accounts_type1 in get_accounts_type'
                                            :value='get_accounts_type1.HeadName'>{{ get_accounts_type1.HeadCode }} :
                                        {{ get_accounts_type1.HeadName }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-12 col-12">
                                <label class="form-label" for="modalAddCardName">Journal Head <span
                                    style="color:red">*</span></label>
                                <select @change="check_node()" class="form-select" v-model="main_head">
                                    <option value="">Select Journal Head</option>
                                    <option v-for='get_coa_mainhead1 in get_coa_mainhead'
                                            :value='get_coa_mainhead1.journalCode'>{{ get_coa_mainhead1.journalCode }} :
                                        {{ get_coa_mainhead1.JournalName }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-12 col-12" v-if="get_coa_subhead.length">
                                <label class="form-label" for="modalAddCardName">Journal Sub Head</label>
                                <select @change="check_second_node()" class="form-select" v-model="sub_head">
                                    <option value="">Select Sub Head</option>
                                    <option v-for='get_coa_subhead1 in get_coa_subhead' :value='get_coa_subhead1.ID'>
                                        {{ get_coa_subhead1.ID }} : {{ get_coa_subhead1.AccountName }}
                                    </option>
                                </select>
                            </div>


                            <div class="col-md-12 col-12" v-if="get_coa_subhead2.length">
                                <label class="form-label" for="modalAddCardName">Journal Sub Head</label>
                                <select @change="check_third_node()" class="form-select" v-model="sub_head2">
                                    <option value="">Select Second Sub Head</option>
                                    <option v-for='get_coa_subhead21 in get_coa_subhead2' :value='get_coa_subhead21.ID'>
                                        {{ get_coa_subhead21.ID }} : {{ get_coa_subhead21.AccountName }}
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-12 col-12" v-if="get_coa_subhead3.length">
                                <label class="form-label" for="modalAddCardName">Journal Sub Head</label>
                                <select class="form-select" v-model="sub_head3">
                                    <option value="">Select Third Sub Head</option>
                                    <option v-for='get_coa_subhead31 in get_coa_subhead3' :value='get_coa_subhead31.ID'>
                                        {{ get_coa_subhead31.ID }} : {{ get_coa_subhead31.AccountName }}
                                    </option>
                                </select>
                            </div>


                            <div class="col-12 col-sm-12 mb-1">
                                <div class="mb-1">
                                    <label class="form-label" for="basicSelect">Ledger Type</label>
                                    <label style="color: #d93025">*</label>
                                    <div class="demo-inline-spacing">
                                        <div class="form-check form-check-inline" style="margin-top:0px">
                                            <input class="form-check-input" type="radio" v-model="coa_type"
                                                   name="inlineRadioOptions" id="inlineRadio1" value="Transaction"
                                                   checked="">
                                            <label class="form-check-label" for="inlineRadio1">Transaction</label>
                                        </div>
                                        <div class="form-check form-check-inline" style="margin-top:0px">
                                            <input class="form-check-input" type="radio" v-model="coa_type"
                                                   name="inlineRadioOptions" id="inlineRadio2" value="Node">
                                            <label class="form-check-label" for="inlineRadio2">Node</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <label style="width:100%;">Allow Reconcilation</label>
                                <div style="margin-bottom:10px;margin-top:10px;"
                                     class="form-check form-check-info form-switch">
                                    <input style="width: 50px;" type="checkbox" v-model="allow_reconcilation"
                                           class="form-check-input" id="customSwitch3">
                                </div>
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" @click="delay()" class="btn btn-primary me-1 mt-1">Submit</button>
                                <button type="reset" class="btn btn-outline-secondary mt-1" data-bs-dismiss="modal"
                                        aria-label="Close">
                                    Cancel
                                </button>
                            </div>
                        </form>
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
            disabled: false,
            timeout: null,
            keyword1: '',

            company_name: '',
            get_accounts_type: {},
            account_name: '',
            account_type: '',
            main_head: '',
            sub_head: '',
            sub_head2: '',
            curr_assets_list: {},
            sub_head3: '',
            JC: 102,
            allow_reconcilation: '',
            coa_type: 'Transaction',
            adsdata: {},
            get_coa_mainhead: {},
            get_coa_subhead: {},
            get_coa_subhead2: {},
            get_coa_subhead3: {},
            fetch_type: {},
            active: false,
            curr_income_nestedlist: {},
            curr_expenses_nestedlist: {},
            active1: false,
            active2: false,
            active3: false,
            active4: false,
            curr_liab_nestedlist: {},
            curr_assets_nestedlist: {},
            curr_equity_nestedlist: {},
            curr_equity_list: {},
            curr_equity_fullnestedlist: {},
            curr_expenses_fullnestedlist: {},
            fetch_overall_coa: {},
            curr_liab_list: {},
            curr_income_fullnestedlist: {},
            fetch_menu_journals: {},
            fetch_menu_journals2: {},
            fetch_menu_journals3: {},
            fetch_menu_journals4: {},
            curr_income_list: {},
            code: '',
            code1: '',
            code2: '',
            code3: '',
            code4: '',
            code5: '',
            code6: '',
            code7: '',
            code8: '',
            code9: '',
            code10: '',
            code11: '',
            code12: '',
            code13: '',
            code14: '',
            curr_assets_fullnestedlist: {},
            curr_expenses_list: {},
            fetch_menu_journals5: {},
        }
    },
    watch: {
        keyword1(after, before) {
            this.getResults();
        }
    },
    methods: {
        nested_curr_Assets(journal_id) {

            this.code1 = journal_id

            if (this.code1 == journal_id) {
                axios.get('accounts/fetch_journal_data_assets/' + journal_id)
                    .then(response => {
                        this.fetch_overall_coa = response.data;
                    })
                axios.get('accounts/fetch_journal_data_assets_unique/' + journal_id)
                    .then(response => {
                        this.curr_assets_nestedlist = response.data
                    })
            }


        },
        fullnested_curr_Assets(journal_id) {
            this.code10 = journal_id
            axios.get('accounts/fetch_journal_data_assets/' + journal_id)
                .then(response => {
                    this.fetch_overall_coa = response.data;
                })
            axios.get('accounts/fetch_journal_data_assets_unique/' + journal_id)
                .then(response => {
                    this.curr_assets_fullnestedlist = response.data
                })


        },
        fullnested_curr_liab(journal_id) {
            this.code11 = journal_id
            axios.get('accounts/fetch_journal_data_assets/' + journal_id)
                .then(response => {
                    this.fetch_overall_coa = response.data;
                })
            axios.get('accounts/fetch_journal_data_assets_unique/' + journal_id)
                .then(response => {
                    this.curr_liab_fullnestedlist = response.data
                })


        },
        fullnested_curr_equity(journal_id) {
            this.code12 = journal_id
            axios.get('accounts/fetch_journal_data_assets/' + journal_id)
                .then(response => {
                    this.fetch_overall_coa = response.data;
                })
            axios.get('accounts/fetch_journal_data_assets_unique/' + journal_id)
                .then(response => {
                    this.curr_equity_fullnestedlist = response.data
                })


        },
        fullnested_curr_income(journal_id) {
            this.code13 = journal_id
            axios.get('accounts/fetch_journal_data_assets/' + journal_id)
                .then(response => {
                    this.fetch_overall_coa = response.data;
                })
            axios.get('accounts/fetch_journal_data_assets_unique/' + journal_id)
                .then(response => {
                    this.curr_income_fullnestedlist = response.data
                })


        },
        fullnested_curr_expenses(journal_id) {
            this.code14 = journal_id
            axios.get('accounts/fetch_journal_data_assets/' + journal_id)
                .then(response => {
                    this.fetch_overall_coa = response.data;
                })
            axios.get('accounts/fetch_journal_data_assets_unique/' + journal_id)
                .then(response => {
                    this.curr_expenses_fullnestedlist = response.data
                })


        },
        nested_curr_liab(journal_id) {
            this.code3 = journal_id
            axios.get('accounts/fetch_journal_data_assets/' + journal_id)
                .then(response => {
                    this.fetch_overall_coa = response.data;
                })
            axios.get('accounts/fetch_journal_data_assets_unique/' + journal_id)
                .then(response => {
                    this.curr_liab_nestedlist = response.data
                })


        },
        nested_curr_equity(journal_id) {
            this.code5 = journal_id
            axios.get('accounts/fetch_journal_data_assets/' + journal_id)
                .then(response => {
                    this.fetch_overall_coa = response.data;
                })
            axios.get('accounts/fetch_journal_data_assets_unique/' + journal_id)
                .then(response => {
                    this.curr_equity_nestedlist = response.data
                })


        },
        nested_curr_income(journal_id) {
            this.code7 = journal_id
            axios.get('accounts/fetch_journal_data_assets/' + journal_id)
                .then(response => {
                    this.fetch_overall_coa = response.data;
                })
            axios.get('accounts/fetch_journal_data_assets_unique/' + journal_id)
                .then(response => {
                    this.curr_income_nestedlist = response.data
                })


        },
        nested_curr_expenses(journal_id) {
            this.code9 = journal_id
            axios.get('accounts/fetch_journal_data_assets/' + journal_id)
                .then(response => {
                    this.fetch_overall_coa = response.data;
                })
            axios.get('accounts/fetch_journal_data_assets_unique/' + journal_id)
                .then(response => {
                    this.curr_expenses_nestedlist = response.data
                })


        },
        getResults() {
            axios.get('accounts/searchcoa_name/' + this.keyword1)
                .then(response => this.fetch_overall_coa = response.data)
                .catch(error => {
                    console.log(error)
                })
        },
        fetch_journal_data(journal_id) {


            axios.get('accounts/fetch_journal_data/' + journal_id)
                .then(response => {
                    this.fetch_overall_coa = response.data;
                })

        },
        fetch_journal_data_assets(journal_id) {
            this.code = journal_id
            this.active = true
            axios.get('accounts/fetch_journal_data_assets/' + journal_id)
                .then(response => {
                    this.fetch_overall_coa = response.data;
                })
            axios.get('accounts/fetch_journal_data_assets_unique/' + journal_id)
                .then(response => {
                    this.curr_assets_list = response.data
                })
        },
        fetch_journal_data_liab(journal_id) {
            this.code2 = journal_id
            this.active1 = true
            axios.get('accounts/fetch_journal_data_assets/' + journal_id)
                .then(response => {
                    this.fetch_overall_coa = response.data;
                })
            axios.get('accounts/fetch_journal_data_assets_unique/' + journal_id)
                .then(response => {
                    this.curr_liab_list = response.data
                })
        },
        fetch_journal_data_equity(journal_id) {
            this.code4 = journal_id
            this.active2 = true
            axios.get('accounts/fetch_journal_data_assets/' + journal_id)
                .then(response => {
                    this.fetch_overall_coa = response.data;
                })
            axios.get('accounts/fetch_journal_data_assets_unique/' + journal_id)
                .then(response => {
                    this.curr_equity_list = response.data
                })
        },
        fetch_journal_data_income(journal_id) {
            this.code6 = journal_id
            this.active3 = true
            axios.get('accounts/fetch_journal_data_assets/' + journal_id)
                .then(response => {
                    this.fetch_overall_coa = response.data;
                })
            axios.get('accounts/fetch_journal_data_assets_unique/' + journal_id)
                .then(response => {
                    this.curr_income_list = response.data
                })
        },
        fetch_journal_data_expenses(journal_id) {
            this.code8 = journal_id
            this.active4 = true
            axios.get('accounts/fetch_journal_data_assets/' + journal_id)
                .then(response => {
                    this.fetch_overall_coa = response.data;
                })
            axios.get('accounts/fetch_journal_data_assets_unique/' + journal_id)
                .then(response => {
                    this.curr_expenses_list = response.data
                })
        },

        fetch_types_menu(head_name) {
            if (this.active == false && this.active1 == false && this.active2 == false && this.active3 == false && this.active4 == false) {
                axios.get('accounts/fetch_type_menu/' + head_name)
                    .then(response => {
                        this.fetch_menu_journals = response.data;

                    })
            }

        },
        fetch_types_menu2(head_name) {
            axios.get('accounts/fetch_type_menu/' + head_name)
                .then(response => {
                    this.fetch_menu_journals2 = response.data;

                })
        },
        fetch_types_menu3(head_name) {
            axios.get('accounts/fetch_type_menu/' + head_name)
                .then(response => {
                    this.fetch_menu_journals3 = response.data;

                })
        },
        fetch_types_menu4(head_name) {
            axios.get('accounts/fetch_type_menu/' + head_name)
                .then(response => {
                    this.fetch_menu_journals4 = response.data;

                })
        },
        fetch_types_menu5(head_name) {
            axios.get('accounts/fetch_type_menu/' + head_name)
                .then(response => {
                    this.fetch_menu_journals5 = response.data;

                })
        },


        fetch_types(head_name) {
            if (this.active == false && this.active1 == false && this.active2 == false && this.active3 == false && this.active4 == false) {
                axios.get('accounts/fetch_type_coa/' + head_name)
                    .then(response => {
                        this.fetch_overall_coa = response.data;

                    })
            }

        },

        fetch_overall_coa2() {
            axios.get('accounts/fetch_overall_coa/')
                .then(response => {
                    this.fetch_overall_coa = response.data;
                })
        },


        fetch_mainhead() {
            axios.get('accounts/get_coa_main_head/' + this.account_type)
                .then(response => {
                    this.get_coa_mainhead = response.data;
                })
        },
        check_node() {
            axios.get('accounts/get_coa_sub_head/' + this.main_head)
                .then(response => {
                    this.get_coa_subhead = response.data;
                })

        },
        check_second_node() {
            axios.get('accounts/get_coa_sub_head2/' + this.sub_head)
                .then(response => {
                    this.get_coa_subhead2 = response.data;
                })
        },
        check_third_node() {
            axios.get('accounts/get_coa_sub_head3/' + this.sub_head2)
                .then(response => {
                    this.get_coa_subhead3 = response.data;
                })
        },


        delay() {
            this.disabled = true
            this.timeout = setTimeout(() => {
                this.disabled = false
            }, 5000)
            this.submit_coa()
        },
        submit_coa() {
            const account_name1 = this.account_name.replace("/", '-');

            if (this.sub_head != '' && this.sub_head2 != '' && this.sub_head3 != '') {
                this.main_head = this.sub_head3;
            } else if (this.sub_head != '' && this.sub_head2 != '' && this.sub_head3 == '') {
                this.main_head = this.sub_head2;
            } else if (this.sub_head != '' && this.sub_head2 == '' && this.sub_head3 == '') {
                this.main_head = this.sub_head;
            }


            if (this.account_name == '' || this.account_type == '' || this.main_head == '' || this.coa_type == '') {
                this.$toastr.e("Please fill required fields!", "Caution!");

            } else {
                axios.post("./accounts/submit_chart_of_accounts", {
                    account_name: account_name1,
                    account_type: this.account_type,
                    main_head: this.main_head,
                    coa_type: this.coa_type,
                })
                    .then((data) => {
                        if (data.data == 'Already Exists') {
                            this.$toastr.e("Account Head Already Exists in Same Ledger!", "Caution!");
                        } else {
                            this.fetch_overall_coa = data.data;
                            this.account_name = '';
                            this.account_type = '';
                            this.main_head = '';
                            this.sub_head = '';
                            this.sub_head2 = '';
                            this.coa_type = 'Transaction';
                            this.$toastr.s("Successfully Added", "Caution!");
                        }


                    })
            }

        },


    },

    mounted() {
        axios.get('accounts/fetch_account_type/')
            .then(response => {
                this.fetch_type = response.data;
            })
        axios.get('accounts/get_account_type')
            .then(response => {
                this.get_accounts_type = response.data;
            })

        axios.get('fetch_only_company_name')
            .then(response => {
                this.company_name = response.data;
                var toggler = document.getElementsByClassName("caret");
                var i;

                for (i = 0; i < toggler.length; i++) {
                    toggler[i].addEventListener("click", function () {
                        this.parentElement.querySelector(".nested").classList.toggle("active");
                        this.classList.toggle("caret-down");

                    });
                }
            })


    }
}

</script>
<style>
ul,
#myUL {
    list-style-type: none;
}

#myUL {
    margin: 0;
    padding: 0;
}

.caret {
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

.caret::before {
    content: "\25B6";
    color: black;
    display: inline-block;
    margin-right: 6px;
}

.caret-down::before {
    -ms-transform: rotate(90deg);
    -webkit-transform: rotate(90deg);
    transform: rotate(90deg);
}

.nested {
    display: none;
}

.nested1 {
    display: none;
}

.active {
    display: block;
}

.tea:link {
    color: #000;
    text-decoration: none;
}

.tea:visited {
    color: #000;
    font-weight: bold;
}

.tea:active {
    color: #000;
    font-weight: bold;
}

.tree,
.section ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.tree {
    /* background: #FBFBFB; */
    /* border: 1px solid #D2D2D2; */
}

.tree li {
    /* border-bottom: 1px solid #D2D2D2; */
    padding: 15px 10px;
}

.tree li:last-child {
    border: 0;
}

/* (B) SUB-SECTIONS */
/* (B1) TOGGLE SHOW/HIDE */
.section ul {
    display: none;
}

.section input:checked ~ ul {
    display: block;
}

/* (B2) HIDE CHECKBOX */
.section input[type="checkbox"] {
    display: none;
}

/* (B3) ADD EXPAND/COLLAPSE ICON  */
.section {
    position: relative;
    padding-left: 35px !important;
}

.section label:after {
    content: "\0002B";
    position: absolute;
    top: 0;
    left: 0;
    padding: 10px;
    text-align: center;
    font-size: 30px;
    color: #f00;
    transition: all 0.5s;
}

.section input:checked ~ label:after {
    color: #23C37A;
    transform: rotate(45deg);
}

/* (B4) SUB-SECTION ITEMS */
.section ul {
    margin-top: 10px;
}

.section ul li {
    color: #D43D3D;
}

/* DOES NOT MATTER */
.tree {
    font-family: arial, sans-serif;
    font-size: 18px;
}
</style>
