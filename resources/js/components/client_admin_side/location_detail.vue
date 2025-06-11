<template>
    <div>
        <!-- BEGIN: Content-->
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow-tem-change"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                </div>
                <div class="content-body">
                    <section class="app-user-view-account">
                        <div class="row">
                            <!-- User Sidebar -->
                            <div class="col-xl-6 col-lg-6 col-md-6 order-1 order-md-0">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Add New Location</h4>
                                    </div>
                                    <div class="card-body">
                                        <form class="form form-vertical">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="mb-1">
                                                        <label class="form-label" for="first-name-vertical">Location
                                                            Name</label>
                                                        <input id="first-name-vertical" v-model='location_name' class="form-control"
                                                               placeholder="Must Be Unique" type="text">
                                                        <span style="color:red;">{{ e_location_name }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="mb-1">
                                                        <label class="form-label" for="email-id-vertical">Location
                                                            Address</label>
                                                        <input id="email-id-vertical" v-model="l_address" class="form-control"
                                                               placeholder="Complete Location Address"
                                                               type="text">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="mb-1">
                                                        <div class="form-check">
                                                            <input id="customCheck3" v-model="head_office"
                                                                   class="form-check-input" type="checkbox"
                                                                   value="true">
                                                            <label class="form-check-label" for="customCheck3">Head
                                                                Office</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <button  v-if="hasPermission('Add new Location')" class="btn btn-primary me-1 waves-effect waves-float waves-light" type="button"
                                                            @click="submit_location()">
                                                        Submit
                                                    </button>
                                                    <button class="btn btn-outline-secondary waves-effect" type="reset">
                                                        Reset
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!--/ User Sidebar -->
                            <div class="col-xl-6 col-lg-6 col-md-6 order-1 order-md-0">
                                <!-- User Card -->
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center header-actions mx-2 row mt-75"
                                             style="margin-bottom:20px;">

                                            <div class="col-sm-12 col-lg-12 ps-xl-75 ps-0">
                                                <div
                                                    class="dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap">
                                                    <div class="me-1">
                                                        <div id="DataTables_Table_0_filter" class="dataTables_filter"
                                                             style="margin-top:5px">
                                                            <label>
                                                                <input v-model="keyword1" autocomplete="off" class="form-control"
                                                                       name="keyword1" placeholder="Search By Location" style=""
                                                                       type="text"/>

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
                                                    <th>Location Name</th>
                                                    <th>Address</th>
                                                    <th>Head Office</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="adsdata1 in adsdata.data">
                                                    <td>{{ adsdata1.location_name }}</td>
                                                    <td>{{ adsdata1.location_address }}</td>
                                                    <td>{{ adsdata1.head_office }}</td>
                                                    <td>
                                                        <span v-if="adsdata1.l_status=='Active'"
                                                              class="badge bg-light-success">{{ adsdata1.l_status }}</span>
                                                        <span v-else
                                                              class="badge bg-light-danger">{{ adsdata1.l_status }}</span>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a v-if="hasPermission('Location actions')" class="btn btn-sm dropdown-toggle hide-arrow"
                                                               data-bs-toggle="dropdown">
                                                                <svg class="feather feather-more-vertical font-small-4" fill="none"
                                                                     height="24" stroke="currentColor" stroke-linecap="round"
                                                                     stroke-linejoin="round" stroke-width="2"
                                                                     viewBox="0 0 24 24" width="24"
                                                                     xmlns="http://www.w3.org/2000/svg">
                                                                    <circle cx="12" cy="12" r="1"></circle>
                                                                    <circle cx="12" cy="5" r="1"></circle>
                                                                    <circle cx="12" cy="19" r="1"></circle>
                                                                </svg>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                <button v-if="adsdata1.l_status=='Active'"
                                                                        class="dropdown-item"
                                                                        @click="deactive(adsdata1.id)">
                                                                    <svg class="feather feather-trash font-small-4 me-50" fill="none"
                                                                         height="24" stroke="currentColor" stroke-linecap="round"
                                                                         stroke-linejoin="round" stroke-width="2"
                                                                         viewBox="0 0 24 24" width="24"
                                                                         xmlns="http://www.w3.org/2000/svg">
                                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                                        <path
                                                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                                    </svg>
                                                                    Suspended
                                                                </button>
                                                                <button v-if="adsdata1.l_status=='Not Active'"
                                                                        class="dropdown-item"
                                                                        @click="active(adsdata1.id)">
                                                                    <svg class="feather feather-trash font-small-4 me-50" fill="none"
                                                                         height="24" stroke="currentColor" stroke-linecap="round"
                                                                         stroke-linejoin="round" stroke-width="2"
                                                                         viewBox="0 0 24 24" width="24"
                                                                         xmlns="http://www.w3.org/2000/svg">
                                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                                        <path
                                                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                                    </svg>
                                                                    Activate
                                                                </button>
                                                                <a class="dropdown-item"
                                                                   data-bs-target="#editLocation" data-bs-toggle="modal"
                                                                   @click="fetch_location(adsdata1.id)">
                                                                    <svg class="bi bi-pencil-square" fill="currentColor"
                                                                         height="16" viewBox="0 0 16 16"
                                                                         width="16"
                                                                         xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                            d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                                        <path d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"
                                                                              fill-rule="evenodd"/>
                                                                    </svg>
                                                                    Edit
                                                                </a>
                                                                <a class="dropdown-item"
                                                                   @click="delete_location(adsdata1.id)">
                                                                    <svg class="feather feather-trash font-small-4 me-50" fill="none"
                                                                         height="24" stroke="currentColor" stroke-linecap="round"
                                                                         stroke-linejoin="round" stroke-width="2"
                                                                         viewBox="0 0 24 24" width="24"
                                                                         xmlns="http://www.w3.org/2000/svg">
                                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                                        <path
                                                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                                    </svg>
                                                                    Delete
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div style="text-align:center;padding-top:20px">
                                            <pagination :data="adsdata"
                                            :limit="limit"
                                                        @pagination-change-page="getResult"></pagination>
                                        </div>

                                    </div>
                                </div>
                                <!-- /User Card -->
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 order-1 order-md-0">
                                <!-- User Card -->
                                <div class="card">
                                    <div class="card-body">
                                        <section id="accordion-with-border">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div id="accordionWrapa50" aria-multiselectable="true"
                                                         role="tablist">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h4 class="card-title">City Names</h4>
                                                                <a v-if="hasPermission('Add new city')"  class="btn btn-outline-primary waves-effect" data-bs-target="#addCity"
                                                                   data-bs-toggle="modal"
                                                                   type="button">Add City</a>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="table-responsive">
                                                                    <table class="table">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>City Name</th>
                                                                            <th style="text-align:center;">Action</th>
                                                                        </tr>
                                                                        </thead>
                                                                    </table>
                                                                    <div style=" height: 280px; overflow-y: scroll;">
                                                                        <table class="table">
                                                                            <tbody>
                                                                            <tr v-for="cities1 in cities.data"
                                                                                class="odd">
                                                                                <td>{{ cities1.city_name }}</td>
                                                                                <td style="text-align:center; min-width:90px">
                                                                                    <a v-if="hasPermission('Delete city')"  class="me-25"
                                                                                       @click="delete_city(cities1.id)">
                                                                                        <i class="fa-solid fa-trash"
                                                                                           style="color:#d42f2f"></i>
                                                                                    </a>
                                                                                </td>
                                                                            </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                <div style="text-align:center;padding-top:20px">
                                                                    <pagination :data="cities"
                                                                                @pagination-change-page="getResult3"></pagination>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                                <!-- /User Card -->
                            </div>
                        </div>
                    </section>

                    <div id="addCity" aria-hidden="true" aria-labelledby="addNewCardTitle" class="modal fade"
                         tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <h3 id="addNewCardTitle" class="text-center mb-1">Add new city</h3>
                                    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"
                                            type="button"></button>
                                </div>
                                <div class="modal-body px-sm-5 mx-50 pb-5">
                                    <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                                        <div class="col-12">
                                            <label class="form-label" for="modalAddCardName">City Name</label>
                                            <input v-model="city_name" class="form-control" placeholder="City name"
                                                   type="text">
                                        </div>
                                        <div class="col-12 text-center">
                                            <button aria-label="Close" class="btn btn-primary me-1 mt-1"
                                                    data-bs-dismiss="modal" type="submit"
                                                    @click="submit_cities()">Submit
                                            </button>
                                            <button aria-label="Close" class="btn btn-outline-secondary mt-1"
                                                    data-bs-dismiss="modal" type="reset">
                                                Cancel
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="editLocation" aria-hidden="true" aria-labelledby="addNewCardTitle" class="modal fade"
                         tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <h3 id="addNewCardTitle" class="text-center mb-1">Edit location</h3>
                                    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"
                                            type="button"></button>
                                </div>
                                <div class="modal-body px-sm-5 mx-50 pb-5">
                                    <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                                        <div class="col-12">
                                            <label class="form-label" for="modalAddCardName">Location Name</label>
                                            <input v-model="ed_location_name" class="form-control" placeholder="Location name"
                                                   type="text">
                                            <span style="color:red;">{{ e_location_name }}</span>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label" for="modalAddCardName">Location Address</label>
                                            <input v-model="ed_l_address" class="form-control" placeholder="Location address"
                                                   type="text">
                                        </div>
                                        <div class="col-12 text-center">
                                            <button aria-label="Close" class="btn btn-primary me-1 mt-1"
                                                    data-bs-dismiss="modal" type="submit"
                                                    @click="update_location()">Submit
                                            </button>
                                            <button aria-label="Close" class="btn btn-outline-secondary mt-1"
                                                    data-bs-dismiss="modal" type="reset">
                                                Cancel
                                            </button>
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
import {overall_location} from "../../helper/apihelper";

export default {
    data() {
        return {

            e_location_name: '',
            location_name: '',
            ed_location_name: '',
            head_office: '',
            l_address: '',
            ed_l_address: '',
            keyword1: '',
            adsdata: {},
            cities: {},
            city_name: '',
            id1: '',
            loc_id: '',
            limit:5,
        }
    },
    watch: {
        keyword1(after, before) {
            this.getResults();
        }
    },
    methods: {
        delete_location(id) {
            axios.get('delete_location/' + id)
                .then(data => {
                    this.$toastr.s("Location Deleted Successfully!", "Deleted");
                    this.adsdata = data.data;
                })
                .catch(error => {
                });
        },
        update_location() {
            axios.post('./update_location', {
                loc_id: this.loc_id,
                ed_location_name: this.ed_location_name,
                ed_l_address: this.ed_l_address,
            })
                .then(data => {
                    if (data.data == 'Location matched!') {
                        this.$toastr.e("Location Already Exists In Your Company", "Please try again");
                        this.e_location_name = "Location Already Exists In Your Company";
                    } else {
                        this.e_location_name = "";
                        this.$toastr.s("Location updated Successfully", "Congratulations!");
                        this.loc_id = '';
                        this.ed_location_name = '';
                        this.ed_l_address = '';
                        this.adsdata = data.data;
                    }
                })

        },
        fetch_location(id) {
            this.id1 = id;
            axios.get('fetch_locations/' + this.id1)
                .then(responce => {
                    this.loc_id = responce.data[0].id;
                    this.ed_location_name = responce.data[0].location_name;
                    this.ed_l_address = responce.data[0].location_address;
                })
                .catch(error => {
                });
        },
        delete_city(id) {
            axios.get('delete_city/' + id)
                .then(response => {
                    this.$toastr.s("City Delete Successfully!", "Deleted");
                    this.cities = response.data

                })
                .catch(error => {
                });

        },
        submit_cities() {
            axios.post('submit_c', {
                city_name: this.city_name
            })
                .then(data => {
                    this.cities = data.data;
                    this.city_name = "";
                    this.$toastr.s("City Added Successfully!", "Congratulations");
                })
        },
        getResults() {

            axios.get('./search_location', {params: {keyword1: this.keyword1}})
                .then(response => this.adsdata = response.data)
                .catch(error => console.log(error));
        },
        submit_location() {

            if (this.location_name == '') {
                this.e_location_name = 'Location Name Required!';
            } else {
                axios.post('./submit_location', {
                    location_name: this.location_name,
                    l_address: this.l_address,
                    head_office: this.head_office,
                })
                    .then(data => {
                        if (data.data == 'Location Already Exists In Your Company') {
                            this.e_location_name = "Location Already Exists In Your Company";
                            this.$toastr.e("Location Already Exists In Your Company", "Please try again");
                        } else {
                            this.$apihelpers.overall_location();
                            this.e_location_name = "";
                            this.$toastr.s("Location Saved Successfully", "Congratulations");
                            this.location_name = '';
                            this.head_office = '';
                            this.l_address = '';
                            this.adsdata = data.data
                        }

                    })

            }
        },
        getResult(page = 1) {

            axios.get('location_detail?page=' + page)
                .then(data => this.adsdata = data.data)
                .catch(error => {
                });
        },

        getResult3(page = 1) {

            axios.get('view_cities?page=' + page)
                .then(response => this.cities = response.data)
                .catch(error => {
                });
        },

        deactive(id) {

            axios.get('./deactivate_location/' + id)
                .then((response) => this.adsdata = response.data)
                .catch(error => console.log(error));

        },
        active(id) {

            axios.get('./activate_location/' + id)
                .then((response) => this.adsdata = response.data)
                .catch(error => console.log(error));

        },
    },

    mounted() {
        this.getResult();
        this.getResult3();
    }
}
</script>
