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
                            <li class="breadcrumb-item active">Assets Book
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

                                </div>
                                <div class="col-sm-7 col-lg-7 ps-xl-75 ps-0">
                                    <div class="dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap">
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
                            <div class="table-responsive" style="overflow-x: initial !important;">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Starting Date</th>
                                            <th>Unique ID</th>
                                            <th>Asset Name</th>
                                            <th>Method</th>
                                            <th>Percentage</th>
                                            <th>Opening Value</th>
                                            <th>Closing Value</th>
                                            <th>Depreciated Value</th>
                                            <th>Closing Date</th>
                                            <th>Status</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="odd" v-for="adsdata1 in adsdata.data">
                                            <td class=" control" tabindex="0" style="display: none;"></td>
                                            <td >{{adsdata1.StartingDate}}</td>
                                            <td >{{adsdata1.AssetId}}</td>
                                            <td >{{adsdata1.Name}}</td>
                                            <td >{{adsdata1.Methods}}</td>
                                            <td >{{adsdata1.Percentage}}</td>


                                            <td>{{Number(adsdata1.StartingValue)}}</td>
                                            <td>{{Number(adsdata1.ClosingValue)}}</td>
                                            <td>{{Number(adsdata1.DepreciatedValue)}}</td>
                                            <td>{{adsdata1.ClosingDate}}</td>
                                            <td>
                                                <span v-if="adsdata1.Status=='active'" class="badge badge-glow bg-primary">{{adsdata1.Status}}</span>
                                                <span v-else class="badge badge-glow bg-secondary">{{adsdata1.Status}}</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </section>
                    <div style="text-align:center;padding-top:20px">
                                <pagination :data="adsdata" @pagination-change-page="getResult"></pagination>
                            </div>
                    <!-- users list ends -->
                </div>
            </div>
        </div>

    </div>
</template>
<script>
export default {
    data() {
        return {
            adsdata: {

            },
            keyword1: '',


        }
    },

    methods: {



        getResult(page = 1) {
            axios.get('accounts/depreciated_assets_bookdetails/?page='+page)
                .then(response => this.adsdata = response.data)
                .catch(error => {});
        },
        getResults(page=1) {
            axios.get('accounts/search_assets_bookbyname/?page='+page,{params:{keyword1:this.keyword1}})
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



        this.getResult();
    }
}

</script>
