<template>
    <div class="row">
        <div class="col-12">
            <div
                class="alert alert-primary"
                style="padding-top: 0px; padding-bottom: 0px"
                role="alert"
            >
                <div class="alert-body">
                    <ul class="nav nav-pills mb-2" style="padding-left: 10px !important">
                        <li class="nav-item" >
                            <router-link v-if="hasPermission('HRMS Attendance Live-Attendance overall-view') " to="/hr/live_attendance" class="nav-link"
                                         :class="active == 'live' ? 'active' : ''">
                                <i class="fa-solid fa-calendar-day"></i>
                                <span class="fw-bold">Live Attendance</span>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link
                            v-if="hasPermission('HRMS Attendance Overall-Attendance overall-view') "
                                to="/hr/all_attendance"
                                class="nav-link"
                                :class="active == 'all' ? 'active' : ''"
                            >
                                <i class="fa-solid fa-calendar-days"></i>
                                <span class="fw-bold">Overall Attendance</span>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link  v-if="hasPermission('HRMS Attendance Employees-Overtime overall-view') "
                                to="/hr/overtime"
                                class="nav-link"
                                :class="active == 'overtime' ? 'active' : ''"
                            >
                                <i class="fa-solid fa-hourglass-end"></i>
                                <span class="fw-bold">Employees Overtime</span>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link v-if="hasPermission('HRMS Attendance Time-Adjustment overall-view') "
                                to="/hr/time_adjustment"
                                class="nav-link"
                                :class="
                                    active == 'time_adjustment' ? 'active' : ''
                                "
                            >
                                <i class="fa-solid fa-clock-rotate-left"></i>
                                <span class="fw-bold">Time adjustment</span>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link v-if="hasPermission('HRMS Attendance Grace-periods overall-view') "
                                to="/hr/attendance_grace_periods"
                                class="nav-link"
                                :class="
                                    active == 'attendance_grace_periods'
                                        ? 'active'
                                        : ''
                                "
                            >
                                <i class="fa-solid fa-clipboard-check"></i>
                                <span class="fw-bold">Grace Periods </span>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link v-if="hasPermission('HRMS Attendance Shifts view') "
                                to="/hr/attendance_rosters"
                                class="nav-link"
                                :class="
                                    active == 'attendance_rosters'
                                        ? 'active'
                                        : ''
                                "
                            >
                                <i class="fa-solid fa-clock"></i>
                                <span class="fw-bold">Shifts </span>
                            </router-link>
                        </li>
                        <!-- <li class="nav-item" >
                            <b-dropdown id="dropdown-right" right text="Actions" style="background-color: #0d6efd;" class="m-2">
                                <b-dropdown-item :to="{ path: '/hr/attendance_grace_periods' }"> Grace Periods </b-dropdown-item>
                                <b-dropdown-item :to="{ path: '/hr/attendance_rosters' }"> Shifts </b-dropdown-item>
                            </b-dropdown>
                        </li> -->
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import {defineComponent} from "vue";

export default defineComponent({
    name: "topBar",
    props: {
        active: {
            type: String,
            required:  true,
        },
    },
    data() {
        return {
        };
    },
    mounted() {
   

    }
});
</script>
