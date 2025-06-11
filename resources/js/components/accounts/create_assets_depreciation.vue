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
                            <li class="breadcrumb-item active">Proceed Assets Depreciation
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="content-body">
                    <!-- users list start -->
                    <section class="app-user-list">
                        <div clas="card" style="background-color:white !important">
                            <div style="margin-bottom:20px;padding-top:20px" class="d-flex justify-content-between align-items-center header-actions mx-2 row mt-75">
                                <div class="col-sm-5 col-lg-5 ps-xl-75 ps-0">
                                    <div class="dt-buttons d-inline-flex mt-50" style="min-width: 50px !important;">
                                        <router-link style="float:left" to="/Accounts/assets_book" class="btn btn-primary waves-effect">Assets Book</router-link>
                                    </div>
                                </div>
                                <div class="col-sm-7 col-lg-7 ps-xl-75 ps-0">
                                    <div class="dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap">
                                        <div class="me-1">
                                            <div class="dataTables_filter" style="margin-top:5px">
                                                <label class="d-flex">
                                                    <input autocomplete="off" id="keyword2" type="text" name="keyword2" v-model="keyword2" class="form-control" style="" placeholder="Asset Unique ID" />
                                                    <input autocomplete="off" type="text" name="keyword1" v-model="keyword1" class="form-control mx-2" style="" placeholder="Search By Name" />
                                                </label>
                                            </div>
                                        </div>
                                        <!-- <div class="invoice_status ms-sm-2" >

                                            <button style="float:left" @click="delay1()"  class="btn btn-primary waves-effect">Proceed</button>
                                            </div> -->

                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive" style="overflow-x: initial !important;">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Unique ID</th>
                                            <th>Date</th>
                                            <th>Name</th>
                                            <th>Category Name</th>
                                            <th>Age</th>
                                            <th>Unit</th>
                                            <th>Purchase Cost</th>

                                            <th>Salvage Value</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="odd" v-for="adsdata1 in adsdata">
                                            <td class=" control" tabindex="0" style="display: none;"></td>

                                            <td>{{adsdata1.AssetsUniqueID}}</td>
                                            <td>{{adsdata1.Dated}}</td>
                                            <td>{{adsdata1.Name}}</td>
                                            <td>{{adsdata1.CategoryName}}</td>
                                            <td>{{adsdata1.EstLife}}</td>
                                            <td>{{adsdata1.Unit}}</td>
                                            <td>{{Number(adsdata1.CostUnit)}}</td>

                                            <td>{{adsdata1.SalvageValue}}</td>

                                            <td>
                                                <div class="d-flex align-items-center col-actions">

                                               <a  @click="depreciationdetail(adsdata1.Reference,adsdata1.AssetsUniqueID,adsdata1.Category_id,(Number(adsdata1.CostUnit)));test(adsdata1.EstLife,adsdata1.SalvageValue,adsdata1.Dated,adsdata1.Name)" data-bs-toggle="modal" data-bs-target="#editproduct" class="dropdown-item">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                            Proceed
                                                        </a>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </section>
                    <!-- users list ends -->
                    <div class="modal fade" id="editproduct" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <h3 class="text-center mb-1" id="addNewCardTitle">
                            Proceed Asset Depreciation
                        </h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-sm-5 mx-50 pb-5">
                        <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">

                            <div class="col-12">
                                    <label class="form-label" for="modalAddCardName">Select Depreciation Method</label>
                                    <select v-model="depr_method" class="form-select" @change="handleMethod()" placeholder="Select Method">
                                        <option value="">Select Method</option>
                                        <option value="Reducing_balance">Reducing Balance</option>
                                        <option value="straight_line">Straight Line</option>
                                        </select>
                                    <span style="color: #db4437; font-size: 11px" v-if="depr_method == ''">{{ e_depr_method }}</span>
                                </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group col-12" >
                                    <label class="form-label" for="modalAddCardName">Cost for Depreciation</label>
                                    <input type="number" v-model="closing_value"  class="form-control" readonly />

                                </div>
                                <div class="form-group col-12" v-if="toggle">
                                    <label class="form-label" for="modalAddCardName">Depreciation Percentage</label>
                                    <input type="number" v-model="percentage"  class="form-control" placeholder="type Percentage i.e 5,10,20" style="" />

                                </div>
                                <div class="form-group col-12" v-if="toggle==false">
                                    <label class="form-label" for="modalAddCardName">Estimate Life</label>
                                    <input type="month" readonly v-model="est_life"  class="form-control"  />
                                    <span style="color: #db4437; font-size: 11px" v-if="est_life == ''">{{ e_est_life }}</span>

                                </div>

                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="form-label" for="modalAddCardName">Starting Date</label>
                                    <input type="date" placeholder="Date" :min="test_date" v-model="starting_date" class="form-control"  />
                                    <span style="color: #db4437; font-size: 11px" v-if="starting_date == ''">{{ e_starting_date }}</span>

                                </div>
                                <div class="form-group" v-if="toggle==false">
                                    <label class="form-label" for="modalAddCardName">Salvage Value</label>
                                    <input type="number" readonly placeholder="salvage value"  v-model="salvage_value" class="form-control" style="" value="0" />


                                </div>

                            </div>
                            <div class="col-12" style="text-align: center">
                                <button :disabled="disabled" @click="delay1()" type="button" class="btn btn-primary mt-1 me-1 waves-effect waves-float waves-light" data-bs-dismiss="modal" aria-label="Close">Proceed Depreciation</button>
                                <button type="submit" class="btn btn-outline-primary waves-effect" data-bs-dismiss="modal" aria-label="Close">Close</button>
                            </div>
                        </form>
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
import axios from 'axios'
export default {
    data() {
        return {
            adsdata: {

            },
            companydetail: {},
            paymentVchrs: {},
            keyword1: '',
            keyword2: '',
            disabled1: false,
            starting_date:'',
            closing_date:'',
            closing_value:0,
            e_depr_method:'',
            e_starting_date:'',
            e_est_life:'',
            salvage_value:0,
            purchaseDate:'',
            est_life:'',
            percentage:0,
            asset_name:'',
            timeout1: null,
            depr_method:'',
            toggle:true,
            asset_id:'',
            num:100,
            cate_id:'',
            test_date:'',
        }
    },

    methods: {
        delay1() {
            this.disabled1 = true
            this.timeout1 = setTimeout(() => {
                this.disabled1 = false
            }, 5000)
            this.proced_booking();
        },
        test(life,salvage,Dated,Name){
       this.est_life=life
       this.salvage_value=salvage
       this.purchaseDate=Dated
       this.asset_name=Name
        },
        handleMethod(){
        if(this.depr_method=='Reducing_balance'){
            this.toggle=true
        }else{
            this.toggle=false
        }
        },
        depreciationdetail(Reference,id,catid,cost_unit){
            this.asset_id=id
            this.cate_id=catid
            let arry=Reference.split(" ");
            let grn_id = arry[arry.length - 1];

    axios.get("depreciationexisting_date/"+id+'/'+catid)
            .then((response)=>{
                if(response.data.ClosingDate){
                   axios.get("adddayin_date",{params:{date:response.data.ClosingDate}})
                   .then((resp)=>{

                    this.starting_date=resp.data
                this.test_date=resp.data
                   })
                }else{
                    this.starting_date= new Date().toJSON().slice(0, 10)

                }

               if(response.data.ClosingValue){
                this.closing_value=response.data.ClosingValue
               }else{
                this.closing_value=cost_unit
               }
            })

   axios.get("depreciationmethods_detail/"+catid)
   .then((response)=>{
   this.depr_method=response.data[0].Methods
   if(this.depr_method=='Reducing_balance'){
            this.toggle=true
        }else{
            this.toggle=false
        }
   this.percentage=response.data[0].Percentage
   })

        },
        proced_booking() {
            if(this.depr_method=='' || this.starting_date==undefined ){
   this.$toastr.e("Select Compulsory fields!", "Caution!");

        if(this.depr_method==''){
            this.e_depr_method='Select method'
        }
        if(this.starting_date==undefined){
            this.e_starting_date='Select Date'
        }

            }else{
                axios.post('accounts/submit_assetbook', {
								category_id:this.cate_id,
                                assetid:this.asset_id,
                                percentage:this.percentage,
                                method:this.depr_method,
                                starting_date:this.starting_date,
                                cost_unit:this.closing_value,
                                est_life:this.est_life,
                                salvage_value:this.salvage_value,
                                purchase_date:this.purchaseDate,
                                asset_name:this.asset_name
							})
                        .then(data => {
                          if(data.data=='Submitted'){
                           this.$toastr.s("Assets Depreciated Successfully", "Congratulations!");
                           this.$router.push({ name: 'assets_book'})
                          this.getResult();

                          }else{
                            this.$toastr.e(data.data, "Caution!");
                          }
                        })
            }
        },



        getResult(page = 1) {
            axios.get('accounts/fetch_assets_depreciation')
                .then(response => {
                    this.adsdata = response.data
                })
                .catch(error => {});
        },
        getResults() {
            axios.get('accounts/search_assetsbyname',{params:{keyword1:this.keyword1}})
                .then(response => {

                    this.adsdata = response.data

                })
                .catch(error => console.log(error));
        },
        getResults1() {
            axios.get('accounts/search_assetsbyuniqueid',{params:{keyword1:this.keyword2}})
                .then(response => {

                    this.adsdata = response.data

                })
                .catch(error => console.log(error));
        },
    },
    watch: {
        keyword1(after, before) {
            this.getResults();
        },
        keyword2(after, before) {
            this.getResults1();
        }
    },
    mounted() {



        this.getResult();
    }
}

</script>
