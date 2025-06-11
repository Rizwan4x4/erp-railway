<template>
    <div>
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow-tem-change"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                </div>
                <div class="content-body">
                    <div class="content-header row">
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <router-link to="/" style="text-decoration: none;">Dashboard</router-link>
                                </li>
                                <li class="breadcrumb-item">
                                    <router-link to="/hr/team_attendance" style="text-decoration: none;">Team attendance</router-link>
                                </li>
                                <li class="breadcrumb-item active">
                                    Team member's attandence
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 order-1 order-md-0">
                        <div class="card">
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="card-header">
                                        <h2 style="font-size:28px" class="card-title">{{name}}'s attendance Detail</h2>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="demo-inline-spacing">
                                        <a href="#" type="button" data-bs-toggle="modal" data-bs-target="#MarkAttendance" class="btn btn-outline-primary waves-effect">Mark Attandance</a>
                                    </div>
                                </div>
                            </div>

                            <table class="user-list-table table">
                                <thead class="table-light">
                                    <tr>
                                        <th class="sticky-th-center">Date</th>
                                        <th class="sticky-th-center">Day</th>
                                        <th class="sticky-th-center">Check In</th>
                                        <th class="sticky-th-center">Late</th>
                                        <th class="sticky-th-center">Marked By</th>
                                        <th class="sticky-th-center">Check Out</th>
                                        <th class="sticky-th-center">Excess</th>
                                        <th class="sticky-th-center">Marked By</th>
                                        <th style=" text-align:center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="attendance1 in att_detail" :class="[attendance1.AttStatus=='H' ? activeClass : '', attendance1.AttStatus=='LE' ? primaryClass : '']">
                                        <td class="text-center">{{attendance1.ATTDate}}</td>
                                                    <td class="text-center">{{dayname(attendance1.ATTDate)}}</td>
                                                    <td class="text-center" v-if="attendance1.AttStatus=='P' || attendance1.AttStatus=='L'">{{attendance1.CheckIN | formatTime}}</td>
                                                    <td class="text-center" v-else-if="attendance1.AttStatus=='H'">Holiday</td>
                                                    <td class="text-center" v-else-if="attendance1.AttStatus=='LE'">Leave</td>
                                                    <td class="text-center  " v-else-if="attendance1.AttStatus=='A'">Absent</td>
                                                    <td class="text-center" v-else>-</td>
                                                    <td class="text-center " v-if="attendance1.AttStatus=='L'">{{attendance1.CheckIN, attendance1.OpeningTime | moment-ago}} Late</td>
                                                    <td class="text-center " v-else-if="attendance1.AttStatus!='P' && attendance1.AttStatus!='L'">-</td>
                                                    <td class="text-center " v-else>{{attendance1.CheckIN, attendance1.OpeningTime | moment-ago}} Early</td>

                                                    <td class="text-center" v-if="attendance1.CheckInBy=='Manual_Attendance'">MIS</td>
                                                    <td class="text-center" v-else-if="attendance1.CheckInBy=='Machine_Attendance'">Machine</td>
                                                    <td class="text-center" v-else-if="attendance1.CheckInBy=='Updated_by_Mis'">Updated through MIS</td>
                                                    <td class="text-center" v-else>-</td>

                                                    <td class="text-center" v-if="attendance1.AttStatus=='P' || attendance1.AttStatus=='L'">{{attendance1.CheckOut | formatTime}}</td>
                                                    <td class="text-center" v-else>-</td>
                                                    <td class=" text-center" v-if="attendance1.CheckOut < attendance1.ClosingTime">{{attendance1.CheckOut, attendance1.ClosingTime | moment-ago}} Early</td>
                                                    <td class=" text-center" v-else-if="attendance1.CheckOut > (attendance1.ClosingTime+':00.0000000')">{{attendance1.CheckOut, attendance1.ClosingTime | moment-ago}} Excess</td>
                                                    <td class="text-center" v-else-if="(attendance1.CheckOut=='' || attendance1.CheckOut==null) && (attendance1.AttStatus=='P' || attendance1.AttStatus=='L')">Un-marked</td>
                                                    <td class="text-center" v-else-if="attendance1.AttStatus!='P' && attendance1.AttStatus!='L'">-</td>
                                                    <td class="text-center" v-else>On time</td>
                                                    <td class="text-center" v-if="attendance1.CheckOutBy=='Manual_Attendance'">MIS</td>
                                                    <td class="text-center" v-else-if="attendance1.CheckOutBy=='Machine_Attendance'">Machine</td>
                                                    <td class="text-center" v-else-if="attendance1.CheckOutBy=='Auto_CheckOut'">Auto CheckOut</td>
                                                    <td class="text-center" v-else-if="attendance1.CheckOutBy=='Updated_by_Mis'">Updated through MIS</td>
                                                    <td class="text-center" v-else>-</td>
                                        <td style="vertical-align: middle; text-align: center;">
                                            <div class="btn-group">
                                                <a class="btn btn-sm dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" @click="fetch_att_detail(attendance1.EmpID, attendance1.ATTDate)" data-bs-toggle="modal" data-bs-target="#editAttendance">
                                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                                        </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Edit attendence modal  -->
                    <div class="modal fade" id="editAttendance" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <h3 class="text-center mb-1" id="addNewCardTitle">Update Attendance</h3>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body px-sm-5 mx-50 pb-5">
                                    <!-- form -->
                                    <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">

                                        <div class="col-md-12">
                                            <label class="form-label" for="modalAddCardName">
                                                Date
                                                <span style="color: #DB4437; font-size: 11px;">*</span>
                                            </label>
                                            <input type="date" disabled v-model="date" class="form-control" />
                                        </div>

                                        <div class="row" style="margin-top: 3%; margin-bottom:3%;">
                                            <label class="form-label" for="modalAddCardName">
                                                Status
                                                <span style="color: #DB4437; font-size: 11px;">*</span>
                                            </label>
                                            <div class="col-md-6">
                                                <input class="form-check-input" type="radio" v-model="att_sts" name="inlineRadioOptions" id="inlineRadio1" value="A">
                                                <label class="form-check-label" for="inlineRadio1">Absent</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input class="form-check-input" type="radio" v-model="att_sts" name="inlineRadioOptions" id="inlineRadio1" value="P">
                                                <label class="form-check-label" for="inlineRadio1">Present</label>
                                            </div>
                                        </div>
                                        <span style="color: #DB4437; font-size: 11px;" v-if="this.att_sts==''">{{att_sts_error}}</span>
                                        <div class="col-md-12" v-if="this.att_sts=='P'">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="form-label" for="modalAddCardName">Check In</label>
                                                    <input type="time" v-model="cin" class="form-control" />
                                                    <span style="color: #DB4437; font-size: 11px;" v-if="this.cin==''">{{cin_error}}</span>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label" for="modalAddCardName">Check Out</label>
                                                    <input type="time" v-model="cout" class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 text-center">
                                            <br>
                                            <button type="submit" class="btn btn-primary me-1 mt-1" :disabled="disabled1" @click="delay1()" data-bs-dismiss="modal" aria-label="Close">Update</button>
                                            <button type="reset" class="btn btn-outline-secondary mt-1" data-bs-dismiss="modal" aria-label="Close">
                                                Cancel
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Edit attendence modal  -->
                    <!-- Mark attendence modal  -->
                    <div class="modal fade" id="MarkAttendance" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <h3 class="text-center mb-1" id="addNewCardTitle">Mark Attendance</h3>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body px-sm-5 mx-50 pb-5">
                                    <!-- form -->
                                    <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">

                                        <div class="col-md-12">
                                            <label class="form-label" for="modalAddCardName">Date<span style="color: #DB4437; font-size: 11px;">*</span></label>
                                            <input type="date" v-model="date" class="form-control" />
                                        </div>
                                        <span style="color: #DB4437; font-size: 11px;" v-if="date==''">{{date_error}}</span>
                                        <div class="row" style="margin-top: 3%; margin-bottom:3%;">
                                            <label class="form-label" for="modalAddCardName">
                                                Status
                                                <span style="color: #DB4437; font-size: 11px;">*</span>
                                            </label>
                                            <div class="col-md-6">
                                                <input class="form-check-input" type="radio" v-model="att_sts" name="inlineRadioOptions" id="inlineRadio1" value="A">
                                                <label class="form-check-label" for="inlineRadio1">Absent</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input class="form-check-input" type="radio" v-model="att_sts" name="inlineRadioOptions" id="inlineRadio1" value="P">
                                                <label class="form-check-label" for="inlineRadio1">Present</label>
                                            </div>
                                        </div>
                                        <span style="color: #DB4437; font-size: 11px;" v-if="att_sts==''">{{att_sts_error}}</span>
                                        <div class="col-md-12" v-if="att_sts=='P'">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="form-label" for="modalAddCardName">Check In</label>
                                                    <input type="time" v-model="cin" class="form-control" />
                                                    <span style="color: #DB4437; font-size: 11px;" v-if="this.cin==''">{{cin_error}}</span>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label" for="modalAddCardName">Check Out</label>
                                                    <input type="time" v-model="cout" class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 text-center">
                                            <br>
                                            <button type="submit" class="btn btn-primary me-1 mt-1" :disabled="disabled" @click="delay()" data-bs-dismiss="modal" aria-label="Close">Submit</button>
                                            <button type="reset" class="btn btn-outline-secondary mt-1" data-bs-dismiss="modal" aria-label="Close">
                                                Cancel
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Mark attendence modal  -->

                    <!-- Modal 1-->
                    <div class="modal fade" id="modalToggle" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalToggleLabel">Update Attendance Status</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row demo-inline-spacing">
                                        <div class="col-md-3 form-check form-check-inline" style="margin-top:0px; margin-left:45%; width: 20%;">
                                            <input class="form-check-input" type="radio" v-model="attendance" name="inlineRadioOptions" id="inlineRadio1" value="Absent">
                                            <label class="form-check-label" for="inlineRadio1">Absent</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / Modal 1-->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                activeClass: 'table-secondary',
                primaryClass: 'table-primary',
                isActive: true,
                CheckoutBy:'',
                att_detail: {},
                id: this.$route.params.id,
                id1: '',
                date: '',
                date_error: '',
                cin: '',
                cin_error: '',
                cout: '',
                att_sts: '',
                att_sts_error: '',
                name: {},
                attendance: '',
                f_date: '',

                disabled: false,
                timeout: null,

                disabled1: false,
                timeout1: null,
            }
        },
        methods: {
            dayname(dateS) {
                var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                var d = new Date(dateS);
                return days[d.getDay()];
            },
            delay1() {
                this.disabled1 = true
                this.timeout1 = setTimeout(() => {
                    this.disabled1 = false
                }, 5000)
                this.update_attendence()
            },
            delay() {
                this.disabled = true
                this.timeout = setTimeout(() => {
                    this.disabled = false
                }, 5000)
                this.add_attendence()
            },
            add_attendence() {
                if (this.date == '' || this.att_sts == '') {
                    if (this.date == '') {
                        this.date_error = "Select attandance status";
                    }
                    else {
                        this.date_error = '';
                    }
                    if (this.att_sts == '') {
                        this.att_sts_error = "Select attandance status";
                    }
                    else {
                        this.att_sts_error = '';
                    }
                    this.$toastr.e("Attandance not marked", "Error!");
                }
                else if (this.att_sts == "P" && this.cin == '') {
                    this.cin_error = "Select time";
                    this.$toastr.e("Attandance not marked", "Error!");
                }
                else {
                    this.date_error = '';
                    this.att_sts_error = '';
                    this.cin_error = '';

                    axios.post('./mark_team_att', {
                        date: this.date,
                        cin: this.cin,
                        cout: this.cout,
                        cId: this.$route.params.id,
                        att_sts: this.att_sts,
                    })
                        .then(data => {
                            if (data.data == 'Attendance marked') {
                                this.$toastr.s("Attandance marked successfully!", "Congratulations!");
                                axios.get('ind_att_detail2/' + this.$route.params.id)
                                    .then(data => {
                                        this.att_detail = data.data;
                                    })
                                this.date = "";
                                this.cin = "";
                                this.cout = "";
                                this.att_sts = "";
                            }
                        })
                }
            },
            fetch_att_detail(id, date) {
                this.id1 = id;
                this.f_date = date;
                axios.get('fetch_att/' + this.id1 + '/' + this.f_date)
                    .then(responce => {
                        this.date = responce.data[0].ATTDate;
                        this.cin = responce.data[0].CheckIN;
                        this.cout = responce.data[0].CheckOut;
                        this.att_sts = responce.data[0].AttStatus;
                        this.CheckoutBy = responce.data[0].CheckOutBy;
                        if (this.att_sts=="L") {
                            this.att_sts = "P";
                        }
                    })
            },
            update_attendence() {
                if (this.att_sts == '' || this.cin=='') {
                    if (this.cin == '') {
                        this.cin_error = "Select time";
                    }
                    else {
                        this.cin_error = '';
                    }
                    if (this.att_sts == '') {
                        this.att_sts_error = "Select attandance status";
                    }
                    else {
                        this.att_sts_error = '';
                    }
                    this.$toastr.e("Attandance not updated.", "Error!");
                }
                else if (this.att_sts == "P" && this.cin == '') {
                    this.cin_error = "Select time";
                    this.$toastr.e("Attandance not updated.", "Error!");
                }
                else {
                    this.date_error = '';
                    this.att_sts_error = '';
                    this.cin_error = '';
this.CheckoutBy='Updated_by_Mis';
                    axios.post('./update_attandence', {
                        Aid: this.id1,
                        cin: this.cin,
                        cout: this.cout,
                        att_sts: this.att_sts,
                        date: this.date,
                        CheckoutBy:this.CheckoutBy,

                    })
                        .then(data => {
                            if (data.data == 'Attendance updated Successfully!') {
                                this.$toastr.s("Attandence updated Successfully", "Congratulations!");
                                this.id1 = "";
                                this.date = "";
                                this.cin = "";
                                this.cout = "";
                                this.att_sts = "";

                                axios.get('ind_att_detail2/' + this.$route.params.id)
                                    .then(data => {
                                        this.att_detail = data.data;
                                    })
                            }
                        })
                        .catch(error => this.error = error.responce.data.errors)
                }
            }
        },
        mounted() {
            axios.get('this_user_attendence/' + this.id)
                .then(data => {

                    this.att_detail = data.data.data;

                })
                .catch(error => { });

            axios.get('ind_name/' + this.id)
                .then(data => {
                    this.name = data.data;
                })
                .catch(error => { });
        }
    }
</script>
