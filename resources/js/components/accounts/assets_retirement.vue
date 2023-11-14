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
                                <router-link to="/accounts" style="text-decoration: none;">Accounts Dashboard</router-link>
                            </li>
                            <li class="breadcrumb-item active">Assets Retirement
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
                                            <a style="float: left" data-bs-toggle="modal" data-bs-target="#addNewCard" class="btn btn-primary waves-effect">Create New Asset Retirement</a>
                                        </div>

                                </div>
                                <div class="col-sm-7 col-lg-7 ps-xl-75 ps-0">
                                    <div class="dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap">


                                             <div class="col-md-3 col-12  position-relative" style="padding-top: 20px;">
                                                 <div class="me-1">
                                            <div class="dataTables_filter" style="margin-top:5px">
                                                <label>
                                                    <input autocomplete="off" type="text" name="keyword1" v-model="keyword1" class="form-control" style="" placeholder="Search by Unique ID" />
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
                                            <th>Asssets Unique ID</th>
                                            <th>Retirement Type</th>
                                            <th>Retirement Date</th>
                                            <th>Sale Value</th>
                                            <th>Status</th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="odd" v-for="adsdata1 in adsdata.data">
                                            <td class=" control" tabindex="0" style="display: none;"></td>
                                            <td class="sorting_1">{{adsdata1.AssetsUniqueID}}</td>
                                            <td>{{adsdata1.RetirementType}}</td>
                                            <td>{{ adsdata1.RetirementDate.slice(0, 10) }}</td>
                                            <td>{{Number(adsdata1.NetValueBalance).toFixed(2)}}</td>
                                            <td>

                                                <span class="badge badge-glow bg-secondary">{{adsdata1.Status}}</span>

                                            </td>

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
                            Create New Retirement Asset Category
                        </h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-sm-5 mx-50 pb-5">
                        <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">


                            <!-- <div class="col-md-6 col-12 "> -->
                                <div class="col-12">
                                    <label class="form-label" for="modalAddCardName">Select Asset <span style="color: #DB4437; font-size: 11px;">*</span></label>
                                    <multiselect :show-labels="false" v-model="assets_name" style="margin-right: 10px; font-size: 15px;" id="modalAddCardName" placeholder="Asset Name"
                                    :options="option" @input=" handleAsset_name" >
                                        </multiselect>
                                        <span style="color: #db4437; font-size: 11px" v-if="assets_name == ''">{{ e_assets_name }}</span>

                                    <div class="form-group">
                                    <label class="form-label" for="modalAddCardName">Retirement Type <span style="color: #DB4437; font-size: 11px;">*</span></label>
                                    <select v-model="Retirement_type" class="form-select"  @change="Selected_Rtype()">
                                        <option value="">Select Retirement Type</option>
                                        <option value="General">General</option>
                                        <option value="Sell">Sell</option>
                                        <option value="Destroyed">Destroyed</option>
                                        </select>
                                    <span style="color: #db4437; font-size: 11px" v-if="Retirement_type == ''">{{ e_Retirement_type }}</span>

                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="modalAddCardName">Depreciaition Starting Date</label>
                                    <input type="date" readonly v-model="closing_date" class="form-control" style="" />


                                </div>

                                    <div class="form-group">
                                    <label class="form-label" for="modalAddCardName">Retirement Date <span style="color: #DB4437; font-size: 11px;">*</span></label>
                                    <input type="date" :min="session_start" :max="session_end" v-model="Retirement_date" class="form-control" placeholder="Retirement date" style=""  @change="handledate()" />

                                </div>

                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="modalAddCardName">Net Value Balance <span style="color: #DB4437; font-size: 11px;">*</span></label>
                                    <input type="number" placeholder="Net value Balance"  v-model="net_value" class="form-control" style="" value="0" />
                                    <span style="color: #db4437; font-size: 11px" v-if="net_value == null">{{ e_net_Value }}</span>

                                </div>
                                <div class="mb-2">
                             <label for="note" class="form-label fw-bold">Narration:</label>
                              <textarea v-model="narration" class="form-control" rows="2" id="note"></textarea>
                              <span style="color: #db4437; font-size: 11px" v-if="narration == ''">{{ e_narration }}</span>
                                </div>




                                <div class="form-group" v-if="toggle">
                                    <label class="form-label" for="modalAddCardName">Depreciation Percentage</label>
                                    <input type="number" v-model="percentage" class="form-control" placeholder="type Percentage i.e 5,10,20" style="" />
                                    <span style="color: #db4437; font-size: 11px" v-if="percentage == ''">{{ e_percentage }}</span>



                                </div>

                            <div class="col-12" style="text-align: center">
                                <button :disabled="disabled1" @click="delay1()" type="button" class=" btn btn-primary mt-1 me-1 waves-effect waves-float waves-light ">
                                    Save Retirement
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
            adsdata: {},
            dated: new Date().toJSON().slice(0, 10),
            depr_name:'',
            net_value:null,
            e_net_Value:'',
            current_value:0,

            e_depr_name:'',
            narration:'',
            e_narration:'',
            percentage:0,
            e_percentage:'',
            depr_method:'',
            Retirement_type:'',
            Retirement_date:new Date().toJSON().slice(0, 10),
            closing_date: '',
            e_depr_method:'',
            e_Retirement_type:'',
            assets_category:'',
            assets_name: '',
            e_assets_name:'',
            e_assets_category:'',
            category_list:{},
            companydetail: {},
            success: '',
            toggle:false,

            keyword1: '',
            option:[],
            disabled1: false,
            timeout1: null,
            session_start: {},
            session_end:{}

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
            this.submit_AssetRetirement();
        },

        handleAsset_name() {
  axios.get("accounts/get_starting_date/" + this.assets_name).then((response) => {
    if(response.data){
        this.closing_date = response.data.StartingDate;
    this.net_value=''
    this.Retirement_type=''
    }else{
        this.closing_date=''
    }


  });
},
Selected_Rtype(){
    if(this.Retirement_type == "Destroyed"){
    this.net_value = 0;

}
else if(this.Retirement_type == "General"){
    axios.get("accounts/get_net_value_salvage/" + this.assets_name).then((response)=>{
     const netValue = response.data;
     if(netValue.SalvageValue == null){
        this.net_value = 0;
     }else{
    this.net_value = netValue.SalvageValue;
     }
})
}
else if(this.Retirement_type == "Sell"){
    let newdate=new Date().toJSON().slice(0, 10)
    axios.get("accounts/get_net_value/"+newdate+'/'+this.assets_name).then((response)=>{
        const netValue = response.data;
        if(netValue[0].ClosingValue !=null){
    this.net_value = netValue[0].ClosingValue;
        }else{
        this.net_value=0
        }

})
}

},
 handledate(){
 axios.get("accounts/get_net_value/"+this.Retirement_date+'/'+this.assets_name).then((response)=>{
 const netValue = response.data;
    this.net_value = netValue[0].ClosingValue;

})

},

        handleMethod(){
        if(this.depr_method=='Reducing_balance'){
            this.toggle=true
        }else{
            this.toggle=false
        }
        },
        submit_AssetRetirement() {
        if(this.assets_name==''||this.Retirement_type =='' || this.narration=='' || this.net_value == null ){
        this.$toastr.e("Please fill required fields!", "Caution!");
         if(this.assets_name=='')
         {
         this.e_assets_name = "Select Asset";
         }
         if(this.Retirement_type==''){
            this.e_Retirement_type='Select Retirement Type'
         }
         if(this.narration==''){
            this.e_narration='Please Enter Narration'
         }
         if(this.net_value == null){
            this.e_net_Value='Please Select Retirement Date to get Net Balance Value '
         }
        }
        else {
        axios.post('accounts/submit_AssetRetirement', {
        assets_name: this.assets_name,
        Retirement_type: this.Retirement_type,
        Retirement_date:this.Retirement_date,
        narration:this.narration,
        net_value:this.net_value,
        closing_date:this.closing_date,
        })
.then(data => {
    if (data.data == "Submitted") {
        this.$toastr.s("Submitted successfully!", "Congratulations");
        this.getResult();
        this.assets_name = "";
        this.Retirement_type= "";
        this.Retirement_date='';
        this.narration='';
        this.net_value=null
        this.closing_date='';
        this.getResults1()
    }else{
        this.$toastr.e(data.data, "Caution!");
    }
})
        }

        },



        getResult(page = 1) {

            axios.get('accounts/assets_retirement_detail/?page=' + page)
                .then(response => this.adsdata = response.data)
                .catch(error => {});
        },
        getResults() {
            axios.get('accounts/search_asset_retirement_byAssetUniqueID',{params:{keyword1:this.keyword1}})
                .then(response => {

                    this.adsdata = response.data
                })
                .catch(error => console.log(error));
        },
        getResults1() {
            axios.get('accounts/assets_detail')
.then(response => {
    this.category_list=response.data.filter((cur)=>{
        return cur.Qty ==0 && cur.IsRetired ==null;
    })
 this.option = [];

    var $this = this;
    for (var j = 0; j < $this.category_list.length; j++) {
        this.option.push($this.category_list[j].AssetsUniqueID+'_'+$this.category_list[j].Name);
    }
})
        },
    },
    watch: {
        keyword1(after, before) {
            this.getResults();
        }
    },
    mounted() {
     this.getResults1();
    
        axios.get('fetch_companyDetail')
            .then(response => this.companydetail = response.data)
            axios.get('accounts/get_session_dates')
  .then(response => {
    const startDateTime = response.data[0].StartDate;
    const endDateTime = response.data[0].EndDate;
    this.session_start = new Date(startDateTime).toISOString().substr(0, 10);
    this.session_end = new Date(endDateTime).toISOString().substr(0, 10);
  });


        this.getResult();
    }
}

</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
