<template>
     @click="openFirstScheduledModal(interviews1)
     <div class="modal fade" id="sentmail" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <div class="text-center mb-2">
                                        <h1 class="mb-1">Edit Interview Details</h1>
                                        <p>Editting interview details.</p>
                                    </div>
                                    <form id="editUserForm" class="row gy-1 pt-75" onsubmit="return false">
                                        <div class="col-12 col-md-6">
                                            <label class="form-label" for="modalEditUserFirstName">Candidate
                                                Name</label>
                                            <input type="text" v-model="ed_i_c_name" class="form-control" disabled />
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label" for="modalEditUserLastName">Posting
                                                Title</label>
                                            <input type="text" disabled="disabled" v-model="ed_i_post_title"
                                                name="modalEditUserLastName" class="form-control" placeholder="Doe"
                                                value="Barton" data-msg="Please enter your last name" />
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label" for="modalEditUserFirstName">Assesment
                                                Name</label>
                                            <input type="text" v-model="assesment_name" text="abc" class="form-control"
                                                disabled />
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label" for="modalEditUserFirstName">Interviewer
                                                Name</label>
                                            <input type="text" v-model="ed_i_name" class="form-control"
                                                placeholder="Interviewer name" />
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label" for="modalEditUserFirstName">Online
                                                link</label>
                                            <input type="text" v-model="ed_i_link" name="modalEditUserLastName"
                                                class="form-control" placeholder="Online Link" value="Barton" />
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label" for="modalEditUserLastName">Interview
                                                Location</label>
                                            <input type="text" v-model="ed_i_location" name="modalEditUserLastName"
                                                class="form-control" placeholder="Interview Location"
                                                data-msg="Please enter your last name" />
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label" for="modalEditUserLastName">Interview
                                                Comments</label>
                                            <input type="text" v-model="ed_i_comment" class="form-control"
                                                placeholder="Add comments" data-msg="Please enter your last name" />
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label" for="modalEditUserName">Date</label>
                                            <input type="date" v-model="ed_i_date" class="form-control"
                                                placeholder="00-00-0000" />
                                            <span style="color: #DB4437; font-size:11px;" v-if="ed_i_date == null">{{
                                                ed_i_date_error }}</span>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <label class="form-label" for="modalEditUserEmail">From</label>
                                            <input type="time" v-model="ed_i_from" class="form-control"
                                                placeholder="11:00 am" />
                                            <span style="color: #DB4437; font-size:11px;" v-if="ed_i_from == null">{{
                                                ed_i_time_error }}</span>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <label class="form-label" for="modalEditUserEmail">To</label>
                                            <input type="time" v-model="ed_i_to" class="form-control"
                                                placeholder="12:30 pm" />
                                        </div>
                                        <div class="col-12 text-center mt-2 pt-50">
                                            <button :disabled="disabled" @click="delay()" type="submit"
                                                class="btn btn-primary bg-primary me-1">Update</button>
                                            <button type="reset" class="btn btn-outline-secondary"
                                                data-bs-dismiss="modal" aria-label="Close">
                                                cancel
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

</template>
<script>
openFirstScheduledModal(interviews1) {  
            let status = interviews1.firstInterviewstatus;

            if (status === 'Not scheduled') {
                this.fetch_interview_detail(interviews1.InterviewID, 'firstns');
                this.modal = new bootstrap.Modal(document.getElementById('editinterview'));
                this.modal.show();
            }
            else {
                console.log("No modal for this status.okoko");
            }
        },

fetch_interview_detail(id, ok) {
            this.resetInterviewData();
            this.id2 = id;
            this.which = ok;
            //start
            axios.get('fetch_interviews/' + this.id2)
                .then(responce => {
                    this.iId = responce.data[0].InterviewID;
                    this.i_c_name = responce.data[0].CandName;
                    this.ed_i_c_name = responce.data[0].CandName;
                    this.ed_i_post_title = responce.data[0].PostTitle;
                    this.ed_i_name = responce.data[0].InterviewerName;
                    this.ed_i_location = responce.data[0].InterviewLocation;
                    this.ed_i_from = responce.data[0].StartTime;
                    this.ed_i_to = responce.data[0].EndTime;
                    this.ed_i_date = responce.data[0].DayDate;
                    this.com1 = responce.data[0].firstInterviewComments;
                    this.com2 = responce.data[0].secondInterviewComments;
                    this.com3 = responce.data[0].finalInterviewComments;
                    this.hire_sts = responce.data[0].hire_sts;
                    this.ratings = responce.data[0].rating;
                    this.Status1 = responce.data[0].firstInterviewstatus;
                    this.Status2 = responce.data[0].secondInterviewstatus;
                    this.Status3 = responce.data[0].finalInterviewstatus;

                    if (this.which == "firstns" || this.which == "firstsdld") {
                        this.assesment_name = "First interview";
                        this.ed_i_comment = responce.data[0].firstInterviewComments;
                        this.up_sts = responce.data[0].firstInterviewstatus;
                    }
                    else if (this.which == "secondns" || this.which == "secondsdld") {
                        this.assesment_name = "Second interview";
                        this.ed_i_comment = responce.data[0].secondInterviewComments;
                        this.up_sts = responce.data[0].secondInterviewstatus;
                    }
                    else if (this.which == "finalns" || this.which == "finalsdld") {
                        this.assesment_name = "Final interview";
                        this.ed_i_comment = responce.data[0].finalInterviewComments;
                        this.up_sts = responce.data[0].finalInterviewstatus;
                    }
                })
                .catch(error => { });
        },
</script>