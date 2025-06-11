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
                                    <router-link to="/recruitment/recDashboard"
                                        style="text-decoration: none;">Dashboard</router-link>
                                </li>
                                <li class="breadcrumb-item active">
                                    <router-link class="d-flex align-items-center" to="/recruitment/jobs">
                                        Job openings
                                    </router-link>
                                </li>
                                <li class="breadcrumb-item active">
                                    Job details
                                </li>
                            </ol>
                        </div>
                    </div>
                    <!-- <h1>Jobs details</h1> -->
                    <div v-for="job_detail1 in job_detail" class="card top-radius bottom-radius border-0 p-5 mb-4 border rounded">
                        <!-- Header -->
                        <div class="d-flex justify-content-between align-items-center mb-3 border-bottom py-3">
                            <div>
                                <h3 class="mb-1 fs-3">{{ job_detail1.PostTitle }}</h3>

                                <small class="text-muted">
                                    <i class="fas fa-calendar-alt me-1"></i> {{ job_detail1.StartDate }}
                                </small>
                            </div>
                            <!-- <button class="btn btn-outline-primary btn-sm">Edit</button> -->
                        </div>

                        <!-- Stats Section -->
                         <h5 class="fw-bolder py-50 mb-1 fs-4">your Stats</h5>
                        <div class="row mb-4">
                            <div class="col-md-6 mb-2">
                                <strong>Department:</strong>  {{ job_detail1.Department }}
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Job Type:</strong>  {{ job_detail1.PostTitle }}
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Experience:</strong>  {{ job_detail1.Experience }}
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Location:</strong>  {{ job_detail1.Address }}
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Number of Jobs:</strong>  {{ job_detail1.JobNumber }}
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Created At:</strong>  {{ job_detail1.CreatedOn }}
                            </div>
                        </div>

                        <!-- Responsibilities -->
                        <h5 class="fw-bolder py-50 mb-1 fs-4">Responsibilities</h5>
                        <p v-html="job_detail1.Duties"></p>

                        <!-- Requirements -->
                        <h5 class="fw-bolder py-50 mb-1 fs-4">Requirements</h5>
                        <ul class="list-unstyled">
                            <li v-for="(skill, index) in job_detail1.Skill.split(',')" :key="index">
                                <i class="bi bi-check-circle text-primary me-2"></i><span v-html="skill"></span>
                            </li>
                        </ul>

                        <!-- Save Button -->
                        <!-- <div class="text-end">
                            <button class="btn btn-primary">Save</button>
                        </div> -->
                    </div>

                    <!-- <div v-for='job_detail1 in job_detail'>
                        <div class="card">
                            <img src="public/app-assets/images/banner/banner-12.jpg" class="img-fluid card-img-top"
                                alt="Blog Detail Pic" />
                            <div class="card-body">
                                <h4 class="card-title">We are looking for a {{ job_detail1.PostTitle }}<span
                                        v-if="job_detail1.JobNumber > 2">s</span><span v-else></span> to work in our
                                    {{ job_detail1.Department }} Office, {{ job_detail1.Address }}.</h4>
                                <div class="d-flex">
                                    <div class="avatar me-50">
                                        <img src="public/app-assets/images/portrait/small/avatar-s-7.jpg" alt="Avatar"
                                            width="24" height="24" />
                                    </div>
                                    <div class="author-info">
                                        <small class="text-muted me-25">by</small>
                                        <small><a href="#" class="text-body">{{ job_detail1.CreatedBy }}</a></small>
                                        <span class="text-muted ms-50 me-25">|</span>
                                        <small class="text-muted">{{ job_detail1.StartDate }}</small>
                                    </div>
                                </div>
                                <div class="my-1 py-25">
                                    <a href="#">
                                        <span class="badge rounded-pill badge-light-danger me-50">{{
                                            job_detail1.Department }}</span>
                                    </a>
                                </div>
                                <span class="fw-bolder me-25">Duties and responsibilities:</span>
                                <ul class="p-0 mb-2">
                                    <li class="d-block" v-html="job_detail1.Duties"></li>
                                </ul>
                                <span class="fw-bolder me-25">Qualification required:</span>
                                <ul class="p-0 mb-2">
                                    <li class="d-block" v-html="job_detail1.Education"></li>
                                </ul>
                                <span class="fw-bolder me-25">Skills required:</span>
                                <ul class="p-0 mb-2">
                                    <li class="d-block" v-html="job_detail1.Skill"></li>
                                </ul>
                                <table>
                                    <tr>
                                        <td><span class="fw-bolder me-25">Experiance required:</span></td>
                                        <td><span>{{ job_detail1.Experience }}</span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="fw-bolder me-25">Posting Date:</span></td>
                                        <td><span>{{ job_detail1.StartDate }}</span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="fw-bolder me-25">Last date to apply:</span></td>
                                        <td><span>{{ job_detail1.EndDate }}</span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="fw-bolder me-25">Total <span
                                                    v-if="job_detail1.JobNumber < 2">Position:</span><span
                                                    v-else></span>Positions:</span></td>
                                        <td><span>{{ job_detail1.JobNumber }}</span></td>
                                    </tr>
                                </table>
                                <hr class="my-2" />
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            job_detail: {},
        }
    },
    mounted() {
        axios.get('ind_job_detail2/' + this.$route.params.id)
            .then(data => {
                this.job_detail = data.data;
                console.log(this.job_detail,"job detail");

            })
            .catch(error => { });
    }
}
</script>
<style scoped>
.border-0 {
    border: 0 !important;
}

.top-radius {
    border-top-left-radius: 12px !important;
    border-top-right-radius: 12px !important;
}

.bottom-radius {
    border-bottom-left-radius: 12px !important;
    border-bottom-right-radius: 12px !important;
}
</style>
