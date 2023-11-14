<template>
    <div>
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                </div>
                <div class="content-body">
                    <div class="content-header row">
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <p style="text-decoration: none;">Admin</p>
                                </li>
                                <li class="breadcrumb-item active">
                                    Members Fees
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="row">
                            <div class="col-lg-3 col-sm-12">
                                <div class="card">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div>
                                            <h3 class="fw-bolder mb-75">{{Totals.totalMembers}}</h3>
                                            <span>Total Registered Members</span>
                                        </div>
                                        <div class="avatar bg-light-primary p-50">
                                            <span class="avatar-content">
                                                <i class="fa-solid fa-users"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    
                            <div class="col-lg-3 col-sm-12">
                                <div class="card">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div>
                                            <h3 class="fw-bolder mb-75">{{Totals.paidEmployeeCount}}</h3>
                                            <span>Month's Paid Members</span>
                                        </div>
                                        <div class="avatar bg-light-warning p-50">
                                            <span class="avatar-content">
                                                <i class="fa-solid fa-user-large"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-12">
                                <div class="card">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div>
                                            <h3 class="fw-bolder mb-75">{{Totals.totalMembers - Totals.paidEmployeeCount}}</h3>
                                            <span>Month's Unpaid Members</span>
                                        </div>
                                        <div class="avatar bg-light-warning p-50">
                                            <span class="avatar-content">
                                                <i style="color:red" class="fa-solid fa-user-large-slash"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-12">
                                <div class="card">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div>
                                            <h3 class="fw-bolder mb-75">{{Totals.totalFee}}</h3>
                                            <span>Month's Fees Paid </span>
                                        </div>
                                        <div class="avatar bg-light-success p-50">
                                            <span class="avatar-content">
                                                <i class="fa-solid fa-user-shield"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="row" style="margin-top:10px">
                                   
                        <div class="row justify-content-end">
    <div class="col-md-4 col-12 mb-2 position-relative">
        <div class="row">
            <div class="col-md-9 col-12 mb-2">
                <input type="text" v-model="search_name" class="form-control" placeholder="Search By Emp. Name or Code">
            </div>
            <div class="col-md-3 col-12 mb-2">
                <button @click="search_member()" class="dt-button add-new btn btn-primary" tabindex="0" type="button">
                    <span>Search</span>
                </button>
            </div>
        </div>
    </div>
</div>
                       
                                </div>
                                <div class="card p-1">
                    <table class="user-list-table table" >
                        <thead class="table-light">
                        <tr>
                            <th class="text-center">Member Name</th>
                            <th class="text-center">Cnic</th>
                            <th class="text-center">Phone no</th>
                            <th class="text-center">Email</th>
                            <th class="text-center"><strong>Fees</strong></th>
                            <th class="text-center">Date</th>
                           
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="member in this.fees">
                                <th scope="row" class="text-center">{{member.Name   }}</th>
                            <td class="text-center">{{member.Cnic }}</td>
                            <td class="text-center">{{ member.PhoneNo }}</td>
                            <td class="text-center">{{ member.Email }}</td>
                            <td class="text-center"><strong>{{member.FeeAmount}}</strong> </td>

                            <td class="text-center">{{new Date(member.date).toISOString().split('T')[0] }}</td>

    

                        </tr>
                        </tbody>

                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import MaskedInput from 'vue-masked-input'
import Multiselect from 'vue-multiselect'
const image = "";

export default {
    components: {
        MaskedInput,
        Multiselect
    },
    props: ['receipt'],
    data() {
        return {
            loader: true,
            fees: [],
            search_name: '',
            selected_club_id:'',
            Totals:'',
            page: 1,
            limit: 10,
            pageN: '',
            pagination: {},
        }
    },

    methods: {
        search_member(page = 1) {
           axios.post('search_MemberFees', {
                'name': this.search_name,

            }).then(res => {
                this.fees=[];
                console.log()
                this.fees = res.data.data.data;
                this.pagination = res.data.data;

                this.page = page;
            }).catch(error => this.error = error.response.data.errors)
         
    },
        fetchFees(page = 1){
            axios.get('./get_fees'+'/?page=' + page).then(res => {
                this.fees = res.data.data.data;
                this.pagination = res.data.data;
                this.page = page;
                console.log('Fees Data',this.fees);
            })
            .catch(error => {
                console.error("Error during getting club data:", error);
                this.pageN = 3;
            });
        }
    },
   
    mounted() {
       
       this.fetchFees();
        axios.get('./get_Totalfees').then(res => {

                this.Totals = res.data.data;
                console.log("Total Fees", res.data.data.totalFee)
            })
            .catch(error => {
                console.error("Error during getting club data:", error);
            });

    },
   
}
</script>

