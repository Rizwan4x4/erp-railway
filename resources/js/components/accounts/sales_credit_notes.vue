<template>
    <div >
        <div class="app-content content ">
            <div class="noprint content-overlay"></div>
            <div class="noprint cheader-navbar-shadow"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="noprint content-header row">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                           <li class="breadcrumb-item">
                                <router-link to="/accounts" style="text-decoration: none;">Accounts Dashboard</router-link>
                            </li>
                            <li class="breadcrumb-item active">
                                Credit Note(s)
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="content-body">
                    <section class="invoice-add-wrapper">
                    <div class="row invoice-add">
                        <!-- Invoice Add Left starts -->
                        <div class="col-xl-9 col-md-8 col-12">
                            <div class="card invoice-preview-card">
                                <!-- Header starts -->
                                <div class="card-body  pb-0">
                                    <div class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0" style="margin-bottom:0px">
                                         <div v-for='companydetail1 in companydetail' style="margin-left:30px">
                                                    <div style="padding-top:10px;margin-bottom: 0px;" class="logo-wrapper">
                                                        <h3 class="text-primary invoice-logo" style="margin-left: 0px;">{{companydetail1.company_name}}</h3>
                                                    </div>
                                                    <p class="card-text mb-25">Address: {{companydetail1.company_address}} , </p> <p class="card-text mb-25">City: {{companydetail1.city}} - {{companydetail1.country}}</p>
                                                    <p class="card-text mb-0">Phone: {{companydetail1.phone_number}}</p>
                                                </div>
                                        <div class="invoice-number-date mt-md-0 mt-2">
                                            <div class="d-flex align-items-center justify-content-md-end mb-1">
                                                <h4 class="invoice-title">Rcvd Id</h4>
                                                <div class="input-group input-group-merge invoice-edit-input-group">
                                                    <div class="input-group-text">
                                                       <i class="fa-solid fa-hashtag"></i>
                                                    </div>
                                                    <input type="text" class="form-control invoice-edit-input" placeholder="53634" />
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center mb-1">
                                                <span class="title">Date:</span>
                                                <input type="date" class="form-control invoice-edit-input " />
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!-- Header ends -->
                               <div class="divider">
                                        <div class="divider-text" style="font-size: 24px;font-weight: 900;">Credit Note(s)</div>
                                    </div>
                                <!-- Address and Contact starts -->
                                <div class="card-body invoice-padding pt-0">
                                    <div class="row row-bill-to invoice-spacing" style="margin-top:0px">

                                        <div class="col-xl-8 mb-lg-1 col-bill-to ps-0">
                                            <h6 class="invoice-to-title" style="margin-bottom:5px">Customer Name:</h6>
                                            <div class="invoice-customer">
                                                <select class="invoiceto form-select">
                                                    <option></option>
                                                    <option value="shelby">Shelby Company Limited</option>
                                                    <option value="hunters">Hunters Corp</option>
                                                </select>
                                            </div>
                                            <div class="row" style="margin-top:10px">
                                            <div class="col-md-6">
                                             <h6 class="invoice-to-title" style="margin-bottom:5px">Against Invoice:</h6>
                                            <div class="invoice-customer">
                                                <select class="invoiceto form-select">
                                                    <option></option>
                                                    <option value="shelby">Shelby Company Limited</option>
                                                    <option value="hunters">Hunters Corp</option>
                                                </select>
                                            </div>
                                            </div>
                                             <div class="col-md-6">
                                             <h6 class="invoice-to-title" style="margin-bottom:5px">Amount:</h6>
                                            <div class="invoice-customer">
                                                 <input type="text" class="form-control ms-50" id="salesperson" placeholder="" />
                                            </div>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 p-0 ps-xl-2 mt-xl-0 mt-2">
                                            <h6 class="mb-2" style="font-weight:bold">Customer Details:</h6>
                                            <table>
                                                <tbody>

                                                    <tr>
                                                        <td class="pe-1">Name:</td>
                                                        <td>American Bank</td>
                                                    </tr>
                                                     <tr>
                                                        <td class="pe-1">Total Dues:</td>
                                                        <td><strong>$12,110.55</strong></td>
                                                    </tr>


                                                </tbody>
                                            </table>
                                             <hr class="my-50" />
                                                <div class="invoice-total-item">
                                                 <p class="invoice-total-title" style="margin-bottom:0px;font-weight:bold" >Invoice Detail:</p>
                                                    <p class="invoice-total-title" style="margin-bottom:0px">Invoice Amount: $1690</p>
                                                     <p class="invoice-total-title">Balance Amount: $1690</p>
                                                </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- Invoice Total ends -->
                                <hr class="invoice-spacing mt-0" style="margin-top:0px;" />
                                <div class="card-body invoice-padding py-0">
                                    <!-- Invoice Note starts -->
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-2">
                                                <label for="note" class="form-label fw-bold">Narration:</label>
                                                <textarea class="form-control" rows="2" id="note"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Invoice Note ends -->
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-4 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <button class="btn btn-primary w-100 mb-75">Post Voucher</button>
                                    <a href="#" class="btn btn-outline-primary w-100 mb-75">Preview</a>

                                </div>
                            </div>

                        </div>
                        <!-- Invoice Add Right ends -->
                    </div>

                </section>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

    export default {
        data() {
            return {
             
                  counter: 1,
                companydetail: {},





                disabled: false,
                timeout: null,
            }
        },
        methods: {


            delay() {
                this.disabled = true
                this.timeout = setTimeout(() => {
                    this.disabled = false
                }, 5000)
                this.issue_warning()
            },
        },
        mounted() {
            axios.get('overall_empcode')
                .then(response => this.empcode = response.data)
                .catch(error => { });

            axios.get('warning_reasons')
                .then(response => this.reason = response.data)

            axios.get('fetch_companyDetail')
                .then(response => this.companydetail = response.data)
            console.log('warning')
        
        }
    }
</script>
<style scoped>
    @media print {
        .noprint {
            visibility: hidden;
        }
    }
    .invoice-preview .invoice-padding,
.invoice-edit .invoice-padding,
.invoice-add .invoice-padding {
  padding-left: 2.5rem;
  padding-right: 2.5rem; }

.invoice-preview .table th:first-child,
.invoice-preview .table td:first-child,
.invoice-edit .table th:first-child,
.invoice-edit .table td:first-child,
.invoice-add .table th:first-child,
.invoice-add .table td:first-child {
  padding-left: 2.5rem; }

.invoice-preview .logo-wrapper,
.invoice-edit .logo-wrapper,
.invoice-add .logo-wrapper {
  display: flex;
  align-items: center;
  margin-bottom: 1.9rem; }

.invoice-preview .logo-wrapper .invoice-logo,
.invoice-edit .logo-wrapper .invoice-logo,
.invoice-add .logo-wrapper .invoice-logo {
  font-size: 2.142rem;
  font-weight: bold;
  letter-spacing: -0.54px;
  margin-left: 1rem;
  margin-bottom: 0; }

.invoice-preview .invoice-title,
.invoice-edit .invoice-title,
.invoice-add .invoice-title {
  font-size: 1.285rem;
  margin-bottom: 1rem; }

.invoice-preview .invoice-title .invoice-number,
.invoice-edit .invoice-title .invoice-number,
.invoice-add .invoice-title .invoice-number {
  font-weight: 600; }

.invoice-preview .invoice-date-wrapper,
.invoice-edit .invoice-date-wrapper,
.invoice-add .invoice-date-wrapper {
  display: flex;
  align-items: center; }

.invoice-preview .invoice-date-wrapper:not(:last-of-type),
.invoice-edit .invoice-date-wrapper:not(:last-of-type),
.invoice-add .invoice-date-wrapper:not(:last-of-type) {
  margin-bottom: 0.5rem; }

.invoice-preview .invoice-date-wrapper .invoice-date-title,
.invoice-edit .invoice-date-wrapper .invoice-date-title,
.invoice-add .invoice-date-wrapper .invoice-date-title {
  width: 7rem;
  margin-bottom: 0; }

.invoice-preview .invoice-date-wrapper .invoice-date,
.invoice-edit .invoice-date-wrapper .invoice-date,
.invoice-add .invoice-date-wrapper .invoice-date {
  margin-left: 0.5rem;
  font-weight: 600;
  margin-bottom: 0; }

.invoice-preview .invoice-spacing,
.invoice-edit .invoice-spacing,
.invoice-add .invoice-spacing {
  margin: 1.45rem 0; }

.invoice-preview .invoice-number-date .title,
.invoice-edit .invoice-number-date .title,
.invoice-add .invoice-number-date .title {
  width: 115px; }

.invoice-preview .invoice-total-wrapper,
.invoice-edit .invoice-total-wrapper,
.invoice-add .invoice-total-wrapper {
  width: 100%;
  max-width: 12rem; }

.invoice-preview .invoice-total-wrapper .invoice-total-item,
.invoice-edit .invoice-total-wrapper .invoice-total-item,
.invoice-add .invoice-total-wrapper .invoice-total-item {
  display: flex;
  align-items: center;
  justify-content: space-between; }

.invoice-preview .invoice-total-wrapper .invoice-total-item .invoice-total-title,
.invoice-edit .invoice-total-wrapper .invoice-total-item .invoice-total-title,
.invoice-add .invoice-total-wrapper .invoice-total-item .invoice-total-title {
  margin-bottom: 0.35rem; }

.invoice-preview .invoice-total-wrapper .invoice-total-item .invoice-total-amount,
.invoice-edit .invoice-total-wrapper .invoice-total-item .invoice-total-amount,
.invoice-add .invoice-total-wrapper .invoice-total-item .invoice-total-amount {
  margin-bottom: 0.35rem;
  font-weight: 600; }

@media (min-width: 768px) {
  .invoice-preview .invoice-title,
  .invoice-edit .invoice-title,
  .invoice-add .invoice-title {
    text-align: right;
    margin-bottom: 3rem; } }

.invoice-edit .invoice-preview-card .invoice-title,
.invoice-add .invoice-preview-card .invoice-title {
  text-align: left;
  margin-right: 3.5rem;
  margin-bottom: 0; }

.invoice-edit .invoice-preview-card .invoice-edit-input,
.invoice-edit .invoice-preview-card .invoice-edit-input-group,
.invoice-add .invoice-preview-card .invoice-edit-input,
.invoice-add .invoice-preview-card .invoice-edit-input-group {
  max-width: 11.21rem; }

.invoice-edit .invoice-preview-card .invoice-product-details,
.invoice-add .invoice-preview-card .invoice-product-details {
  background-color: #fcfcfc;
  padding: 3.75rem 3.45rem 2.3rem 3.45rem; }

.invoice-edit .invoice-preview-card .invoice-product-details .product-details-border,
.invoice-add .invoice-preview-card .invoice-product-details .product-details-border {
  border: 1px solid #ebe9f1;
  border-radius: 0.357rem; }

.invoice-edit .invoice-preview-card .invoice-to-title,
.invoice-add .invoice-preview-card .invoice-to-title {
  margin-bottom: 1.9rem; }

.invoice-edit .invoice-preview-card .col-title,
.invoice-add .invoice-preview-card .col-title {
  position: absolute;
  top: -1.75rem; }

.invoice-edit .invoice-preview-card .item-options-menu,
.invoice-add .invoice-preview-card .item-options-menu {
  min-width: 20rem; }

.invoice-edit .invoice-preview-card .repeater-wrapper:not(:last-child),
.invoice-add .invoice-preview-card .repeater-wrapper:not(:last-child) {
  margin-bottom: 3rem; }

.invoice-edit .invoice-preview-card .invoice-calculations .total-amt-title,
.invoice-add .invoice-preview-card .invoice-calculations .total-amt-title {
  width: 100px; }

@media (max-width: 769px) {
  .invoice-edit .invoice-preview-card .invoice-title,
  .invoice-add .invoice-preview-card .invoice-title {
    margin-right: 0;
    width: 115px; }
  .invoice-edit .invoice-preview-card .invoice-edit-input,
  .invoice-add .invoice-preview-card .invoice-edit-input {
    max-width: 100%; } }

@media (max-width: 992px) {
  .invoice-edit .col-title,
  .invoice-add .col-title {
    position: unset !important;
    top: -1.5rem !important; } }

</style>
