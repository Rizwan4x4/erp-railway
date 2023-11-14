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
                                    <router-link to="/" style="text-decoration: none;" >Dashboard</router-link>
                                </li>
                                <li class="breadcrumb-item active">
                                    My Tasks
                                </li>
                            </ol>
                        </div>
                    </div>
                    <!-- Full calendar start -->
                    <section>
                        <div class="app-calendar overflow-hidden border">
                            <div class="row g-0">
                                <!-- Sidebar -->
                                <div class="sidebar-wrapper col-md-2" style="background-color:white; border-right:1px solid lightgray">
                                    <div class=" row card-body d-flex justify-content-center">
                                        <button class="col-md-12 btn btn-primary btn-toggle-sidebar w-100" data-bs-toggle="modal" data-bs-target="#add-event">
                                            <span class="align-middle">Add task</span>
                                        </button>
                                    </div>
                                    <div class="mt-auto" style="margin-top:200px">
                                        <img src="public/app-assets/images/pages/calendar-illustration.png" alt="Calendar illustration" class="img-fluid" style="margin-top:505px;" />
                                    </div>
                                </div>
                                <!-- /Sidebar -->
                                <!-- Calendar -->
                                <div class="col position-relative">
                                    <div class="card shadow-none border-0 mb-0 rounded-0">
                                        <div class="card-body pb-0">
                                            <!-- Hoverable rows start -->
                                            <div class="row" id="table-hover-row">
                                                <div class="col-12">
                                                    <full-calendar :events="demoEvents1" locale="en"></full-calendar>
                                                </div>
                                            </div>
                                            <!-- Hoverable rows end -->
                                        </div>
                                    </div>
                                </div>
                                <!-- /Calendar -->
                                <div class="body-content-overlay"></div>
                            </div>
                        </div>
                    </section>
                    <!-- Calendar Add/Update/Delete event modal-->
                    <div class="modal modal-slide-in event-sidebar fade" id="add-event">
                        <div class="modal-dialog sidebar-lg">
                            <div class="modal-content p-0">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                                <div class="modal-header mb-1">
                                    <h5 class="modal-title">Add Event</h5>
                                </div>
                                <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                                    <form class="event-form needs-validation" data-ajax="false" novalidate>
                                        <div class="mb-1">
                                            <label for="title" class="form-label">Title</label>
                                            <input v-model="title" type="text" class="form-control" placeholder="Event Title" required />
                                            <span style="color: #DB4437; font-size: 11px;" v-if="this.title == ''">{{e_title}}</span>
                                        </div>
                                        <div class="mb-1">
                                            <label for="select-label" class="form-label">Share with</label>
                                            <multiselect style="margin-right: 10px;" v-model="selected" :multiple="true" :options="options"></multiselect>
                                        </div>
                                        <div class="mb-1">
                                            <div class="form-check form-switch">
                                                <input v-model="allDay" style="width:40px; margin-right:3%;" type="checkbox" class="form-check-input allDay-switch" id="customSwitch3" />
                                                <label class="form-check-label" for="customSwitch3">All Day</label>
                                            </div>
                                        </div>
                                        <div class="mb-1 row">
                                            <div class="col-md-6">
                                                <label v-if="this.allDay == false" for="start-date" class="form-label">Start </label>
                                                <label for="start-date" class="form-label">Date</label>
                                                <input v-model="startDate" type="date" class="form-control" placeholder="Start Date" />
                                                <span style="color: #DB4437; font-size: 11px;" v-if="this.startDate == ''">{{e_startDate}}</span>
                                            </div>
                                            <div class="col-md-6" v-if="this.allDay == false">
                                                <label for="end-date" class="form-label">End Date</label>
                                                <input v-model="endDate" type="date" class="form-control" placeholder="End Date" />
                                                <span style="color: #DB4437; font-size: 11px;" v-if="this.allDay == false && this.endDate == ''">{{e_endDate}}</span>
                                            </div>
                                        </div>
                                        <div class="mb-1 row">
                                            <div class="col-6">
                                                <label for="start-date" class="form-label">Start Time</label>
                                                <input v-model="startTime" type="time" class="form-control" />
                                            </div>
                                            <div class="col-6">
                                                <label for="start-date" class="form-label">End Time</label>
                                                <input v-model="endTime" type="time" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="mb-1">
                                            <label for="event-url" class="form-label">Event URL</label>
                                            <input v-model="url" type="url" class="form-control" id="event-url" placeholder="https://www.google.com" />
                                        </div>
                                        <div class="mb-1">
                                            <label for="event-location" class="form-label">Location</label>
                                            <input v-model="location" type="text" class="form-control" placeholder="Enter Location" />
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label">Description</label>
                                            <textarea v-model="description" name="event-description-editor" id="event-description-editor" class="form-control"></textarea>
                                        </div>
                                        <div class="mb-1 d-flex">
                                            <button :disabled="disabled" @click="delay()" type="submit" class="btn btn-primary add-event-btn me-1"data-bs-dismiss="modal" aria-label="Close">Add</button>
                                            <button type="button" class="btn btn-outline-secondary btn-cancel" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Calendar Add/Update/Delete event modal-->

                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Multiselect from 'vue-multiselect'

    export default {
        data() {
            return {
                demoEvents1: {},
                employees_detail5: {},

                e_title: '',
                e_startDate: '',
                e_endDate: '',
                title: '',
                selected: null,
                startDate: '',
                endDate: '',
                startTime: '',
                endTime: '',
                url: '',
                location: '',
                description: '',
                allDay: false,

                options: [],


                disabled: false,
                timeout: null,
            }
        },
        components: {
            'full-calendar': require('vue-fullcalendar'),
            Multiselect
        },

        methods: {
            delay() {
                this.disabled = true
                this.timeout = setTimeout(() => {
                    this.disabled = false
                }, 5000)
                this.add_event()
            },
            add_event() {
                if (this.title == '' || this.startDate == '' || this.allDay == false && this.endDate == '') {
                    if (this.title == '') {
                        this.e_title = "Title is required";
                    }
                    else {
                        this.e_title = "";
                    }
                    if (this.startDate == '') {
                        this.e_startDate = "Date is required";
                    }
                    else {
                        this.e_startDate = "";
                    }
                    if (this.allDay == false && this.endDate == '') {
                        this.e_endDate = "End date is required";
                    }
                    else {
                        this.e_endDate = "";
                    }
                    this.$toastr.e("Please fill all required fields", "Error!");
                }
                else {
                    axios.post('./add_event', {
                        title: this.title,
                        selected: this.selected,
                        startDate: this.startDate,
                        endDate: this.endDate,
                        url: this.url,
                        location: this.location,
                        description: this.description,
                        allDay: this.allDay,
                        startTime: this.startTime,
                        endTime: this.endTime,

                    })
                        .then(data => {
                            if (data.data == "Event added") {
                                this.$toastr.s("Event added Successfully", "Congratulations");

                                axios.get('fetch_event')
                                    .then((response) => this.demoEvents1 = response.data);

                                this.title = "";
                                this.selected = "";
                                this.startDate = "";
                                this.endDate = "";
                                this.url = "";
                                this.location = "";
                                this.description = "";
                                this.startTime = "";
                                this.endTime = "";
                            }
                        })
                }
            },
        },
        mounted() {
            axios.get('fetch_event')
                .then((response) => this.demoEvents1 = response.data);


            axios.get('get_com_users')
                .then(response => {
                    this.employees_detail5 = response.data;
                    this.options = [];

                    var $this = this;
                    for (var i = 0; i < $this.employees_detail5.length; i++) {

                        this.options.push($this.employees_detail5[i].first_name + ' ' + $this.employees_detail5[i].last_name + '_' + $this.employees_detail5[i].emp_code);

                    }
                })
        }
    }
</script>
