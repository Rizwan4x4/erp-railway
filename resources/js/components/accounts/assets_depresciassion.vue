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
                            <li class="breadcrumb-item active">Assets Depreciation
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
                                    <div class="dt-buttons d-inline-flex mt-50">
                                            <a style="float: left" data-bs-toggle="modal" data-bs-target="#addNewCard" class="btn btn-primary waves-effect">Create New Depreciation</a>
                                        </div>
                                    <div class="dt-buttons d-inline-flex mt-50" style="min-width: 50px !important;">
                                        <router-link style="float:left" to="/Accounts/create_assets_depreciation" class="btn btn-primary waves-effect">Proceed Asset Depreciation</router-link>
                                    </div>
                                </div>
                                <div class="col-sm-7 col-lg-7 ps-xl-75 ps-0">
                                    <div class="dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap">


                                             <div class="col-md-3 col-12  position-relative" style="padding-top: 20px;">
                                                 <div class="me-1">
                                            <div class="dataTables_filter" style="margin-top:5px">
                                                <label>
                                                    <input autocomplete="off" type="text" name="keyword1" v-model="keyword1" class="form-control" style="" placeholder="Search By Name" />
                                                </label>
                                            </div>
                                        </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive" style="overflow-x: initial !important;">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Depreciation Name</th>
                                            <th>Method</th>
                                            <th>Category Name</th>
                                            <th>Percentage</th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="odd" v-for="adsdata1 in adsdata.data">
                                            <td class=" control" tabindex="0" style="display: none;"></td>
                                            <td class="sorting_1">{{adsdata1.DeprName}}</td>
                                            <td v-if="adsdata1.Methods=='straight_line'">Straight Line</td>
                                            <td v-else>Reducing Balance</td>
                                            <td>{{adsdata1.CategoryName}}</td>
                                            <td>{{adsdata1.Percentage}}</td>


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
        <div class="modal fade" id="addNewCard" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <h3 class="text-center mb-1" id="addNewCardTitle">
                            Create New Depreciation Asset Category
                        </h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-sm-5 mx-50 pb-5">
                        <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">


                            <!-- <div class="col-md-6 col-12 "> -->
                                <div class="col-12">
                                    <label class="form-label" for="modalAddCardName">Assets Category</label>
                                    <!-- <multiselect style="margin-right: 10px;"
                                                     v-model="assets_category" :options="options">
                                        </multiselect> -->
                                        <select v-model="assets_category" class="form-select">
                                        <option value="">Select Category</option>
                                        <option v-for='category_detail1 in category_list' :value='category_detail1.ID'>{{ category_detail1.CategoryName}}</option>
                                    </select>
                                    <span style="color: #db4437; font-size: 11px" v-if="assets_category == ''">{{ e_assets_category }}</span>

                                    <div class="form-group">
                                    <label class="form-label" for="modalAddCardName">Depreciation Name</label>
                                    <input type="text" v-model="depr_name" class="form-control" placeholder="Depreciation Name" style="" />
                                    <span style="color: #db4437; font-size: 11px" v-if="depr_name == ''">{{ e_depr_name }}</span>

                                </div>
                                    <div class="form-group">
                                    <label class="form-label" for="modalAddCardName">Starting Date</label>
                                    <input type="date" v-model="starting_date" class="form-control" placeholder="Starting date" style="" />


                                </div>

                                </div>

                                <div class="col-12">
                                    <label class="form-label" for="modalAddCardName">Methods</label>
                                    <select v-model="depr_method" class="form-select" @change="handleMethod()">
                                        <option value="">Select Method</option>
                                        <option value="Reducing_balance">Reducing Balance</option>
                                        <option value="straight_line">Straight Line</option>
                                        </select>
                                    <span style="color: #db4437; font-size: 11px" v-if="depr_method == ''">{{ e_depr_method }}</span>
                                </div>
                                <div class="form-group" v-if="toggle">
                                    <label class="form-label" for="modalAddCardName">Depreciation Percentage</label>
                                    <input type="number" v-model="percentage" class="form-control" placeholder="type Percentage i.e 5,10,20" style="" />
                                    <span style="color: #db4437; font-size: 11px" v-if="percentage == ''">{{ e_percentage }}</span>



                                </div>

                            <div class="col-12" style="text-align: center">
                                <button :disabled="disabled1" @click="delay1()" type="button" class=" btn btn-primary mt-1 me-1 waves-effect waves-float waves-light " data-bs-dismiss="modal" aria-label="Close">
                                    Save Depreciation
                                </button>
                                <button type="submit" class="btn btn-outline-primary waves-effect" data-bs-dismiss="modal" aria-label="Close">Close</button>
                            </div>
                            <!-- </div> -->
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>


<script>
 import MaskedInput from 'vue-masked-input'
import Multiselect from 'vue-multiselect';
export default {
    data() {
        return {
            adsdata: {

            },
            depr_name:'',
            e_depr_name:'',
            percentage:0,
            e_percentage:'',
            depr_method:'',
            starting_date:new Date().toJSON().slice(0, 10),
            closing_date:'',
            e_depr_method:'',
            assets_category:'',
            e_assets_category:'',
            category_list:{},
            companydetail: {},
            paymentVchrs: {},
            success: '',
            toggle:false,
            pv_id:'',
            keyword1: '',
            option:[],
            disabled1: false,
            timeout1: null,

        }
    },
    components: {
        Multiselect,
        MaskedInput
    },
    methods: {
        delay1() {
            this.disabled1 = true
            this.timeout1 = setTimeout(() => {
                this.disabled1 = false
            }, 5000)
            this.submit_depreciation();
        },
        handleMethod(){
        if(this.depr_method=='Reducing_balance'){
            this.toggle=true
        }else{
            this.toggle=false
        }
        },
        submit_depreciation() {
        if(this.assets_category==''||this.depr_name=='' || this.depr_method=='' ){
        this.$toastr.e("Please fill required fields!", "Caution!");
         if(this.assets_category=='')
         {
         this.e_assets_category = "Select Category";
         }
         if(this.depr_name==''){
            this.e_depr_name='Enter name'
         }
         if(this.depr_method==''){
            this.e_depr_method='Select method'
         }

        }
        else {
        axios.post('accounts/submit_depreciassion', {
        categoty: this.assets_category,
        name: this.depr_name,
        method:this.depr_method,
        percentage:this.percentage,
        starting_date:this.starting_date,
        })
.then(data => {
    if (data.data == "Submitted") {
        this.$toastr.s("Submitted successfully!", "Congratulations");
        this.getResult();
        this.depr_name = "";
        this.depr_method= "";
        this.percentage='';
        this.assets_category=''
    }else{
        this.$toastr.e(data.data, "Caution!");
    }
})
        }

        },



        getResult(page = 1) {

            axios.get('accounts/assets_depreciasion_detail/?page=' + page)
                .then(response => this.adsdata = response.data)
                .catch(error => {});
        },
        getResults() {
            axios.get('accounts/search_depreciationbyname',{params:{keyword1:this.keyword1}})
                .then(response => {

                    this.adsdata = response.data
                })
                .catch(error => console.log(error));
        },
    },
    watch: {
        keyword1(after, before) {
            this.getResults();
        }
    },
    mounted() {
        axios.get('accounts/assets_category1')
.then(response => {
this.category_list = response.data
 this.option = [];

    var $this = this;
    for (var j = 0; j < $this.category_list.length; j++) {
        this.option.push($this.category_list[j].ID+'_'+$this.category_list[j].CategoryName);
    }
})

        axios.get('fetch_companyDetail')
            .then(response => this.companydetail = response.data)

        this.getResult();
    }
}

</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
