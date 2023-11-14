<template>
    <div>
        <!-- BEGIN: Content-->
        <div class="app-content content">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <router-link
                                    to="/hr/dashboard"
                                    style="text-decoration: none"
                                    >Dashboard</router-link
                                >
                            </li>
                            <li class="breadcrumb-item">
                                <router-link
                                    to="/hr/attendance/dashboard"
                                    style="text-decoration: none"
                                    >Attendance Detail
                                </router-link>
                            </li>
                            <li class="breadcrumb-item active">
                                Rosters Detail
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="content-body">
                    <topBar :active="active" />
                    <section class="app-user-view-account">
                        <div class="row">
                            <!-- User Sidebar -->
                            <div
                                class="col-xl-6 col-lg-6 col-md-6 order-1 order-md-0"
                            >
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">
                                            Add New Roster
                                        </h4>
                                    </div>
                                    <div class="card-body">
                                        <form class="form form-vertical">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="mb-1">
                                                        <label
                                                            class="form-label"
                                                            for="first-name-vertical"
                                                            >Roster Name</label
                                                        >
                                                        <input
                                                            type="text"
                                                            id="first-name-vertical"
                                                            class="form-control"
                                                            required=""
                                                            v-model="
                                                                roster_name
                                                            "
                                                            placeholder="Must Be Unique"
                                                        />
                                                    </div>
                                                </div>
                                                <div
                                                    class="col-12"
                                                    style="margin-top: 20px"
                                                >
                                                    <div class="mb-1">
                                                        <label
                                                            class="form-label"
                                                            for="first-name-vertical"
                                                            >Roster Timing
                                                            Detail</label
                                                        >

                                                        <div
                                                            class="table-responsive"
                                                        >
                                                            <table v-if="hasPermission('HRMS Attendance Shifts Edit')"
                                                                class="table table-flush-spacing"
                                                            >
                                                                <tbody>
                                                                    <tr>
                                                                        <td
                                                                            class="text-nowrap fw-bolder"
                                                                            style="
                                                                                width: 100px;
                                                                            "
                                                                        >
                                                                            Monday
                                                                        </td>
                                                                        <td
                                                                            class="text-nowrap"
                                                                        >
                                                                            <div 
                                                                                style="
                                                                                    margin-bottom: 10px;
                                                                                "
                                                                                class="form-check form-check-info form-switch"
                                                                            >
                                                                                <input
                                                                                    style="
                                                                                        width: 50px;
                                                                                    "
                                                                                    type="checkbox"
                                                                                    v-model="
                                                                                        monday_s
                                                                                    "
                                                                                    checked=""
                                                                                    class="form-check-input"
                                                                                    id="customSwitch3"
                                                                                />
                                                                            </div>
                                                                        </td>
                                                                        <td
                                                                            class="text-nowrap fw-bolder"
                                                                        >
                                                                            <input
                                                                                v-if="
                                                                                    monday_s ==
                                                                                    true
                                                                                "
                                                                                type="time"
                                                                                v-model="
                                                                                    monday_in
                                                                                "
                                                                                class="form-control"
                                                                                style=""
                                                                                placeholder="Monday Check In"
                                                                                step="300"
                                                                            />
                                                                        </td>
                                                                        <td
                                                                            class="text-nowrap fw-bolder"
                                                                        >
                                                                            <input
                                                                                v-if="
                                                                                    monday_s ==
                                                                                    true
                                                                                "
                                                                                type="time"
                                                                                v-model="
                                                                                    monday_out
                                                                                "
                                                                                class="form-control"
                                                                                style=""
                                                                                placeholder="Monday Check In"
                                                                                step="300"
                                                                            />
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td
                                                                            class="text-nowrap fw-bolder"
                                                                            style="
                                                                                width: 100px;
                                                                            "
                                                                        >
                                                                            Tuesday
                                                                        </td>
                                                                        <td
                                                                            class="text-nowrap"
                                                                        >
                                                                            <div
                                                                                style="
                                                                                    margin-bottom: 10px;
                                                                                "
                                                                                class="form-check form-check-info form-switch"
                                                                            >
                                                                                <input
                                                                                    style="
                                                                                        width: 50px;
                                                                                    "
                                                                                    type="checkbox"
                                                                                    v-model="
                                                                                        tuesday_s
                                                                                    "
                                                                                    checked=""
                                                                                    class="form-check-input"
                                                                                    id="customSwitch3"
                                                                                />
                                                                            </div>
                                                                        </td>
                                                                        <td
                                                                            class="text-nowrap fw-bolder"
                                                                        >
                                                                            <input
                                                                                v-if="
                                                                                    tuesday_s ==
                                                                                    true
                                                                                "
                                                                                type="time"
                                                                                v-model="
                                                                                    tuesday_in
                                                                                "
                                                                                class="form-control"
                                                                                style=""
                                                                                placeholder="Monday Check In"
                                                                                step="300"
                                                                            />
                                                                        </td>
                                                                        <td
                                                                            class="text-nowrap fw-bolder"
                                                                        >
                                                                            <input
                                                                                v-if="
                                                                                    tuesday_s ==
                                                                                    true
                                                                                "
                                                                                type="time"
                                                                                v-model="
                                                                                    tuesday_out
                                                                                "
                                                                                class="form-control"
                                                                                style=""
                                                                                placeholder=" Check In"
                                                                                step="300"
                                                                            />
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td
                                                                            class="text-nowrap fw-bolder"
                                                                            style="
                                                                                width: 100px;
                                                                            "
                                                                        >
                                                                            Wednesday
                                                                        </td>
                                                                        <td
                                                                            class="text-nowrap"
                                                                        >
                                                                            <div
                                                                                style="
                                                                                    margin-bottom: 10px;
                                                                                "
                                                                                class="form-check form-check-info form-switch"
                                                                            >
                                                                                <input
                                                                                    style="
                                                                                        width: 50px;
                                                                                    "
                                                                                    type="checkbox"
                                                                                    v-model="
                                                                                        wednesday_s
                                                                                    "
                                                                                    checked=""
                                                                                    class="form-check-input"
                                                                                    id="customSwitch3"
                                                                                />
                                                                            </div>
                                                                        </td>
                                                                        <td
                                                                            class="text-nowrap fw-bolder"
                                                                        >
                                                                            <input
                                                                                v-if="
                                                                                    wednesday_s ==
                                                                                    true
                                                                                "
                                                                                type="time"
                                                                                v-model="
                                                                                    wednesday_in
                                                                                "
                                                                                class="form-control"
                                                                                style=""
                                                                                placeholder="Monday Check In"
                                                                                step="300"
                                                                            />
                                                                        </td>
                                                                        <td
                                                                            class="text-nowrap fw-bolder"
                                                                        >
                                                                            <input
                                                                                v-if="
                                                                                    wednesday_s ==
                                                                                    true
                                                                                "
                                                                                type="time"
                                                                                v-model="
                                                                                    wednesday_out
                                                                                "
                                                                                class="form-control"
                                                                                style=""
                                                                                placeholder="Monday Check In"
                                                                                step="300"
                                                                            />
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td
                                                                            class="text-nowrap fw-bolder"
                                                                            style="
                                                                                width: 100px;
                                                                            "
                                                                        >
                                                                            Thursday
                                                                        </td>
                                                                        <td
                                                                            class="text-nowrap"
                                                                        >
                                                                            <div
                                                                                style="
                                                                                    margin-bottom: 10px;
                                                                                "
                                                                                class="form-check form-check-info form-switch"
                                                                            >
                                                                                <input
                                                                                    style="
                                                                                        width: 50px;
                                                                                    "
                                                                                    type="checkbox"
                                                                                    v-model="
                                                                                        thursday_s
                                                                                    "
                                                                                    checked=""
                                                                                    class="form-check-input"
                                                                                    id="customSwitch3"
                                                                                />
                                                                            </div>
                                                                        </td>
                                                                        <td
                                                                            class="text-nowrap fw-bolder"
                                                                        >
                                                                            <input
                                                                                v-if="
                                                                                    thursday_s ==
                                                                                    true
                                                                                "
                                                                                type="time"
                                                                                v-model="
                                                                                    thursday_in
                                                                                "
                                                                                class="form-control"
                                                                                style=""
                                                                                placeholder="Monday Check In"
                                                                                step="300"
                                                                            />
                                                                        </td>
                                                                        <td
                                                                            class="text-nowrap fw-bolder"
                                                                        >
                                                                            <input
                                                                                v-if="
                                                                                    thursday_s ==
                                                                                    true
                                                                                "
                                                                                type="time"
                                                                                v-model="
                                                                                    thursday_out
                                                                                "
                                                                                class="form-control"
                                                                                style=""
                                                                                placeholder="Monday Check In"
                                                                                step="300"
                                                                            />
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td
                                                                            class="text-nowrap fw-bolder"
                                                                            style="
                                                                                width: 100px;
                                                                            "
                                                                        >
                                                                            Friday
                                                                        </td>
                                                                        <td
                                                                            class="text-nowrap"
                                                                        >
                                                                            <div
                                                                                style="
                                                                                    margin-bottom: 10px;
                                                                                "
                                                                                class="form-check form-check-info form-switch"
                                                                            >
                                                                                <input
                                                                                    style="
                                                                                        width: 50px;
                                                                                    "
                                                                                    type="checkbox"
                                                                                    v-model="
                                                                                        friday_s
                                                                                    "
                                                                                    checked=""
                                                                                    class="form-check-input"
                                                                                    id="customSwitch3"
                                                                                />
                                                                            </div>
                                                                        </td>
                                                                        <td
                                                                            class="text-nowrap fw-bolder"
                                                                        >
                                                                            <input
                                                                                v-if="
                                                                                    friday_s ==
                                                                                    true
                                                                                "
                                                                                type="time"
                                                                                v-model="
                                                                                    friday_in
                                                                                "
                                                                                class="form-control"
                                                                                style=""
                                                                                placeholder="Monday Check In"
                                                                                step="300"
                                                                            />
                                                                        </td>
                                                                        <td
                                                                            class="text-nowrap fw-bolder"
                                                                        >
                                                                            <input
                                                                                v-if="
                                                                                    friday_s ==
                                                                                    true
                                                                                "
                                                                                type="time"
                                                                                v-model="
                                                                                    friday_out
                                                                                "
                                                                                class="form-control"
                                                                                style=""
                                                                                placeholder="Monday Check In"
                                                                                step="300"
                                                                            />
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td
                                                                            class="text-nowrap fw-bolder"
                                                                            style="
                                                                                width: 100px;
                                                                            "
                                                                        >
                                                                            Saturday
                                                                        </td>
                                                                        <td
                                                                            class="text-nowrap"
                                                                        >
                                                                            <div
                                                                                style="
                                                                                    margin-bottom: 10px;
                                                                                "
                                                                                class="form-check form-check-info form-switch"
                                                                            >
                                                                                <input
                                                                                    style="
                                                                                        width: 50px;
                                                                                    "
                                                                                    type="checkbox"
                                                                                    v-model="
                                                                                        saturday_s
                                                                                    "
                                                                                    checked=""
                                                                                    class="form-check-input"
                                                                                    id="customSwitch3"
                                                                                />
                                                                            </div>
                                                                        </td>
                                                                        <td
                                                                            class="text-nowrap fw-bolder"
                                                                        >
                                                                            <input
                                                                                v-if="
                                                                                    saturday_s ==
                                                                                    true
                                                                                "
                                                                                type="time"
                                                                                v-model="
                                                                                    saturday_in
                                                                                "
                                                                                class="form-control"
                                                                                style=""
                                                                                placeholder="Monday Check In"
                                                                                step="300"
                                                                            />
                                                                        </td>
                                                                        <td
                                                                            class="text-nowrap fw-bolder"
                                                                        >
                                                                            <input
                                                                                v-if="
                                                                                    saturday_s ==
                                                                                    true
                                                                                "
                                                                                type="time"
                                                                                v-model="
                                                                                    saturday_out
                                                                                "
                                                                                class="form-control"
                                                                                style=""
                                                                                placeholder="Monday Check In"
                                                                                step="300"
                                                                            />
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td
                                                                            class="text-nowrap fw-bolder"
                                                                            style="
                                                                                width: 100px;
                                                                            "
                                                                        >
                                                                            Sunday
                                                                        </td>
                                                                        <td
                                                                            class="text-nowrap"
                                                                        >
                                                                            <div
                                                                                style="
                                                                                    margin-bottom: 10px;
                                                                                "
                                                                                class="form-check form-check-info form-switch"
                                                                            >
                                                                                <input
                                                                                    style="
                                                                                        width: 50px;
                                                                                    "
                                                                                    type="checkbox"
                                                                                    v-model="
                                                                                        sunday_s
                                                                                    "
                                                                                    checked=""
                                                                                    class="form-check-input"
                                                                                    id="customSwitch3"
                                                                                />
                                                                            </div>
                                                                        </td>
                                                                        <td
                                                                            class="text-nowrap fw-bolder"
                                                                        >
                                                                            <input
                                                                                v-if="
                                                                                    sunday_s ==
                                                                                    true
                                                                                "
                                                                                type="time"
                                                                                v-model="
                                                                                    sunday_in
                                                                                "
                                                                                class="form-control"
                                                                                style=""
                                                                                placeholder="Monday Check In"
                                                                                step="300"
                                                                            />
                                                                        </td>
                                                                        <td
                                                                            class="text-nowrap fw-bolder"
                                                                        >
                                                                            <input
                                                                                v-if="
                                                                                    sunday_s ==
                                                                                    true
                                                                                "
                                                                                type="time"
                                                                                v-model="
                                                                                    sunday_out
                                                                                "
                                                                                class="form-control"
                                                                                style=""
                                                                                placeholder="Monday Check In"
                                                                                step="300"
                                                                            />
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <button v-if="hasPermission('HRMS Attendance Shifts add new')"
                                                        type="button"
                                                        @click="submit_roster()"
                                                        class="btn btn-primary me-1 waves-effect waves-float waves-light"
                                                    >
                                                        Submit
                                                    </button>
                                                    <button v-else
                                                        type="button"
                                                    
                                                        class="btn btn-danger me-1 waves-effect waves-float waves-light"
                                                    >
                                                        Submit
                                                    </button>
                                                    <button
                                                        type="reset"
                                                        class="btn btn-outline-secondary waves-effect"
                                                    >
                                                        Reset
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!--/ User Sidebar -->

                            <div
                                class="col-xl-6 col-lg-6 col-md-6 order-1 order-md-0"
                            >
                                <!-- User Card -->
                                <div class="card">
                                    <div class="card-body">
                                        <div
                                            style="margin-bottom: 20px"
                                            class="d-flex justify-content-between align-items-center header-actions mx-2 row mt-75"
                                        >
                                            <div
                                                class="col-sm-12 col-lg-12 ps-xl-75 ps-0"
                                            >
                                                <div
                                                    class="dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap"
                                                >
                                                    <div class="me-1">
                                                        <div
                                                            id="DataTables_Table_0_filter"
                                                            class="dataTables_filter"
                                                            style="
                                                                margin-top: 5px;
                                                            "
                                                        >
                                                            <label>
                                                                <input
                                                                    autocomplete="off"
                                                                    class="form-control"
                                                                    style=""
                                                                    placeholder="Search By Location"
                                                                />
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <section id="accordion-with-border">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div
                                                        id="accordionWrapa50"
                                                        role="tablist"
                                                        aria-multiselectable="true"
                                                    >
                                                        <div class="card">
                                                            <div
                                                                class="card-header"
                                                            >
                                                                <h4
                                                                    class="card-title"
                                                                >
                                                                    Roster
                                                                    Details
                                                                </h4>
                                                            </div>
                                                            <div
                                                                class="card-body"
                                                            >
                                                                <div
                                                                    class="accordion accordion-border"
                                                                    id="accordionBorder"
                                                                >
                                                                    <div
                                                                        class="accordion-item"
                                                                        v-for="adsdata1 in adsdata"
                                                                    >
                                                                        <h2
                                                                            class="accordion-header"
                                                                            :id="
                                                                                'headingBorder' +
                                                                                adsdata1.RosterID
                                                                            "
                                                                        >
                                                                            <button
                                                                                class="accordion-button collapsed"
                                                                                type="button"
                                                                                data-bs-toggle="collapse"
                                                                                :data-bs-target="
                                                                                    '#accordionBorder' +
                                                                                    adsdata1.RosterID
                                                                                "
                                                                                aria-expanded="false"
                                                                                :aria-controls="
                                                                                    'accordionBorder' +
                                                                                    adsdata1.RosterID
                                                                                "
                                                                            >
                                                                                {{
                                                                                    adsdata1.RosterName
                                                                                }}
                                                                            </button>
                                                                        </h2>

                                                                        <div
                                                                            :id="
                                                                                'accordionBorder' +
                                                                                adsdata1.RosterID
                                                                            "
                                                                            class="accordion-collapse collapse"
                                                                            :aria-labelledby="
                                                                                'headingBorder' +
                                                                                adsdata1.RosterID
                                                                            "
                                                                            data-bs-parent="#accordionBorder"
                                                                        >
                                                                            <div
                                                                                class="accordion-body"
                                                                            >
                                                                                <a
                                                                                    @click="
                                                                                        roster_view(
                                                                                            adsdata1.RosterID
                                                                                        )
                                                                                    "
                                                                                    style="
                                                                                        float: right;
                                                                                        margin-bottom: 10px;
                                                                                    "
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#overall_grace"
                                                                                    class="btn btn-info"
                                                                                    ><i
                                                                                        class="fa-solid fa-pen-to-square"
                                                                                    ></i
                                                                                ></a>
                                                                                <table
                                                                                    class="table"
                                                                                >
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>
                                                                                                Day
                                                                                                Name
                                                                                            </th>
                                                                                            <th>
                                                                                                Day
                                                                                                Timing
                                                                                            </th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <tr
                                                                                            class="odd"
                                                                                        >
                                                                                            <td>
                                                                                                Monday
                                                                                            </td>
                                                                                            <td>
                                                                                                {{
                                                                                                    adsdata1.Mon
                                                                                                }}
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr
                                                                                            class="odd"
                                                                                        >
                                                                                            <td>
                                                                                                Tuesday
                                                                                            </td>
                                                                                            <td>
                                                                                                {{
                                                                                                    adsdata1.Tue
                                                                                                }}
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr
                                                                                            class="odd"
                                                                                        >
                                                                                            <td>
                                                                                                Wednesday
                                                                                            </td>
                                                                                            <td>
                                                                                                {{
                                                                                                    adsdata1.Wed
                                                                                                }}
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr
                                                                                            class="odd"
                                                                                        >
                                                                                            <td>
                                                                                                Thursday
                                                                                            </td>
                                                                                            <td>
                                                                                                {{
                                                                                                    adsdata1.Thu
                                                                                                }}
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr
                                                                                            class="odd"
                                                                                        >
                                                                                            <td>
                                                                                                Friday
                                                                                            </td>
                                                                                            <td>
                                                                                                {{
                                                                                                    adsdata1.Fri
                                                                                                }}
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr
                                                                                            class="odd"
                                                                                        >
                                                                                            <td>
                                                                                                Saturday
                                                                                            </td>
                                                                                            <td>
                                                                                                {{
                                                                                                    adsdata1.Sat
                                                                                                }}
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr
                                                                                            class="odd"
                                                                                        >
                                                                                            <td>
                                                                                                Sunday
                                                                                            </td>
                                                                                            <td>
                                                                                                {{
                                                                                                    adsdata1.Sun
                                                                                                }}
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        <!-- Accordion with border end -->
                                    </div>
                                </div>
                                <!-- /User Card -->
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <div
            class="modal fade"
            id="overall_grace"
            aria-labelledby="overall_grace"
            tabindex="-1"
            style="display: none"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalToggleLabel">
                            Update Roster
                        </h5>

                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-1">
                                    <label
                                        class="form-label"
                                        for="first-name-vertical"
                                        >Roster Name</label
                                    >
                                    <input
                                        type="text"
                                        id="first-name-vertical"
                                        class="form-control"
                                        readonly
                                        required=""
                                        v-model="u_roster_name"
                                        placeholder="Must Be Unique"
                                    />
                                    <input
                                        type="text"
                                        id="first-name-vertical"
                                        class="form-control"
                                        hidden
                                        required=""
                                        v-model="u_roster_id"
                                        placeholder="Must Be Unique"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-flush-spacing">
                                <tbody>
                                    <tr>
                                        <td
                                            class="text-nowrap fw-bolder"
                                            style="width: 100px"
                                        >
                                            Monday
                                        </td>
                                        <td class="text-nowrap">
                                            <div
                                                style="margin-bottom: 10px"
                                                class="form-check form-check-info form-switch"
                                            >
                                                <input
                                                    style="width: 50px"
                                                    type="checkbox"
                                                    v-model="u_monday_s"
                                                    checked=""
                                                    class="form-check-input"
                                                    id="customSwitch3"
                                                />
                                            </div>
                                        </td>
                                        <td class="text-nowrap fw-bolder">
                                            <input
                                                v-if="u_monday_s == true"
                                                type="time"
                                                v-model="u_monday_in"
                                                class="form-control"
                                                style=""
                                                placeholder="Monday Check In"
                                                step="300"
                                            />
                                        </td>
                                        <td class="text-nowrap fw-bolder">
                                            <input
                                                v-if="u_monday_s == true"
                                                type="time"
                                                v-model="u_monday_out"
                                                class="form-control"
                                                style=""
                                                placeholder="Monday Check In"
                                                step="300"
                                            />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="text-nowrap fw-bolder"
                                            style="width: 100px"
                                        >
                                            Tuesday
                                        </td>
                                        <td class="text-nowrap">
                                            <div
                                                style="margin-bottom: 10px"
                                                class="form-check form-check-info form-switch"
                                            >
                                                <input
                                                    style="width: 50px"
                                                    type="checkbox"
                                                    v-model="u_tuesday_s"
                                                    checked=""
                                                    class="form-check-input"
                                                    id="customSwitch3"
                                                />
                                            </div>
                                        </td>
                                        <td class="text-nowrap fw-bolder">
                                            <input
                                                v-if="u_tuesday_s == true"
                                                type="time"
                                                v-model="u_tuesday_in"
                                                class="form-control"
                                                style=""
                                                placeholder="Monday Check In"
                                                step="300"
                                            />
                                        </td>
                                        <td class="text-nowrap fw-bolder">
                                            <input
                                                v-if="u_tuesday_s == true"
                                                type="time"
                                                v-model="u_tuesday_out"
                                                class="form-control"
                                                style=""
                                                placeholder=" Check In"
                                                step="300"
                                            />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="text-nowrap fw-bolder"
                                            style="width: 100px"
                                        >
                                            Wednesday
                                        </td>
                                        <td class="text-nowrap">
                                            <div
                                                style="margin-bottom: 10px"
                                                class="form-check form-check-info form-switch"
                                            >
                                                <input
                                                    style="width: 50px"
                                                    type="checkbox"
                                                    v-model="u_wednesday_s"
                                                    checked=""
                                                    class="form-check-input"
                                                    id="customSwitch3"
                                                />
                                            </div>
                                        </td>
                                        <td class="text-nowrap fw-bolder">
                                            <input
                                                v-if="u_wednesday_s == true"
                                                type="time"
                                                v-model="u_wednesday_in"
                                                class="form-control"
                                                style=""
                                                placeholder="Monday Check In"
                                                step="300"
                                            />
                                        </td>
                                        <td class="text-nowrap fw-bolder">
                                            <input
                                                v-if="u_wednesday_s == true"
                                                type="time"
                                                v-model="u_wednesday_out"
                                                class="form-control"
                                                style=""
                                                placeholder="Monday Check In"
                                                step="300"
                                            />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="text-nowrap fw-bolder"
                                            style="width: 100px"
                                        >
                                            Thursday
                                        </td>
                                        <td class="text-nowrap">
                                            <div
                                                style="margin-bottom: 10px"
                                                class="form-check form-check-info form-switch"
                                            >
                                                <input
                                                    style="width: 50px"
                                                    type="checkbox"
                                                    v-model="u_thursday_s"
                                                    checked=""
                                                    class="form-check-input"
                                                    id="customSwitch3"
                                                />
                                            </div>
                                        </td>
                                        <td class="text-nowrap fw-bolder">
                                            <input
                                                v-if="u_thursday_s == true"
                                                type="time"
                                                v-model="u_thursday_in"
                                                class="form-control"
                                                style=""
                                                placeholder="Monday Check In"
                                                step="300"
                                            />
                                        </td>
                                        <td class="text-nowrap fw-bolder">
                                            <input
                                                v-if="u_thursday_s == true"
                                                type="time"
                                                v-model="u_thursday_out"
                                                class="form-control"
                                                style=""
                                                placeholder="Monday Check In"
                                                step="300"
                                            />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="text-nowrap fw-bolder"
                                            style="width: 100px"
                                        >
                                            Friday
                                        </td>
                                        <td class="text-nowrap">
                                            <div
                                                style="margin-bottom: 10px"
                                                class="form-check form-check-info form-switch"
                                            >
                                                <input
                                                    style="width: 50px"
                                                    type="checkbox"
                                                    v-model="u_friday_s"
                                                    checked=""
                                                    class="form-check-input"
                                                    id="customSwitch3"
                                                />
                                            </div>
                                        </td>
                                        <td class="text-nowrap fw-bolder">
                                            <input
                                                v-if="u_friday_s == true"
                                                type="time"
                                                v-model="u_friday_in"
                                                class="form-control"
                                                style=""
                                                placeholder="Monday Check In"
                                                step="300"
                                            />
                                        </td>
                                        <td class="text-nowrap fw-bolder">
                                            <input
                                                v-if="u_friday_s == true"
                                                type="time"
                                                v-model="u_friday_out"
                                                class="form-control"
                                                style=""
                                                placeholder="Monday Check In"
                                                step="300"
                                            />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="text-nowrap fw-bolder"
                                            style="width: 100px"
                                        >
                                            Saturday
                                        </td>
                                        <td class="text-nowrap">
                                            <div
                                                style="margin-bottom: 10px"
                                                class="form-check form-check-info form-switch"
                                            >
                                                <input
                                                    style="width: 50px"
                                                    type="checkbox"
                                                    v-model="u_saturday_s"
                                                    checked=""
                                                    class="form-check-input"
                                                    id="customSwitch3"
                                                />
                                            </div>
                                        </td>
                                        <td class="text-nowrap fw-bolder">
                                            <input
                                                v-if="u_saturday_s == true"
                                                type="time"
                                                v-model="u_saturday_in"
                                                class="form-control"
                                                style=""
                                                placeholder="Monday Check In"
                                                step="300"
                                            />
                                        </td>
                                        <td class="text-nowrap fw-bolder">
                                            <input
                                                v-if="u_saturday_s == true"
                                                type="time"
                                                v-model="u_saturday_out"
                                                class="form-control"
                                                style=""
                                                placeholder="Monday Check In"
                                                step="300"
                                            />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="text-nowrap fw-bolder"
                                            style="width: 100px"
                                        >
                                            Sunday
                                        </td>
                                        <td class="text-nowrap">
                                            <div
                                                style="margin-bottom: 10px"
                                                class="form-check form-check-info form-switch"
                                            >
                                                <input
                                                    style="width: 50px"
                                                    type="checkbox"
                                                    v-model="u_sunday_s"
                                                    checked=""
                                                    class="form-check-input"
                                                    id="customSwitch3"
                                                />
                                            </div>
                                        </td>
                                        <td class="text-nowrap fw-bolder">
                                            <input
                                                v-if="u_sunday_s == true"
                                                type="time"
                                                v-model="u_sunday_in"
                                                class="form-control"
                                                style=""
                                                placeholder="Monday Check In"
                                                step="300"
                                            />
                                        </td>
                                        <td class="text-nowrap fw-bolder">
                                            <input
                                                v-if="u_sunday_s == true"
                                                type="time"
                                                v-model="u_sunday_out"
                                                class="form-control"
                                                style=""
                                                placeholder="Monday Check In"
                                                step="300"
                                            />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            class="btn btn-primary"
                            @click="update_roster()"
                        >
                            Update
                        </button>
                        <button
                            type="button"
                            class="btn btn-primary"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        >
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import topBar from "./topBar.vue";
export default {
    data() {
        return {
            active: "attendance_rosters",
            roster_name: "",
            monday_s: true,
            monday_in: "08:00",
            monday_out: "18:00",
            tuesday_s: true,
            tuesday_in: "08:00",
            tuesday_out: "18:00",
            wednesday_s: true,
            wednesday_in: "08:00",
            wednesday_out: "18:00",
            thursday_s: true,
            thursday_in: "08:00",
            thursday_out: "18:00",
            friday_s: true,
            friday_in: "08:00",
            friday_out: "18:00",
            saturday_s: true,
            saturday_in: "08:00",
            saturday_out: "18:00",
            sunday_s: true,
            sunday_in: "08:00",
            sunday_out: "18:00",

            u_roster_id: "",
            u_roster_name: "",
            u_monday_s: true,
            u_monday_in: "",
            u_monday_out: "",
            u_tuesday_s: true,
            u_tuesday_in: "",
            u_tuesday_out: "",
            u_wednesday_s: true,
            u_wednesday_in: "",
            u_wednesday_out: "",
            u_thursday_s: true,
            u_thursday_in: "",
            u_thursday_out: "",
            u_friday_s: true,
            u_friday_in: "",
            u_friday_out: "",
            u_saturday_s: true,
            u_saturday_in: "",
            u_saturday_out: "",
            u_sunday_s: true,
            u_sunday_in: "",
            u_sunday_out: "",
            adsdata: {},
        };
    },
    components: {
        topBar,
    },
    methods: {
        roster_view(roster_id) {
            axios
                .get("fetch_roster_detail/" + roster_id)
                .then((response) => {
                    this.u_roster_id = response.data[0].RosterID;
                    this.u_roster_name = response.data[0].RosterName;
                    var u_monday = response.data[0].Mon.split("-");
                    this.u_monday_in = u_monday[0];
                    this.u_monday_out = u_monday[1];
                    if (this.u_monday_in != "") {
                        this.u_monday_s = true;
                    } else {
                        this.u_monday_s = false;
                    }
                    var u_tuesday = response.data[0].Tue.split("-");
                    this.u_tuesday_in = u_tuesday[0];
                    this.u_tuesday_out = u_tuesday[1];
                    if (this.u_tuesday_in != "") {
                        this.u_tuesday_s = true;
                    } else {
                        this.u_tuesday_s = false;
                    }
                    var u_wednesday = response.data[0].Wed.split("-");
                    this.u_wednesday_in = u_wednesday[0];
                    this.u_wednesday_out = u_wednesday[1];
                    if (this.u_wednesday_in != "") {
                        this.u_wednesday_s = true;
                    } else {
                        this.u_wednesday_s = false;
                    }
                    var u_thursday = response.data[0].Thu.split("-");
                    this.u_thursday_in = u_thursday[0];
                    this.u_thursday_out = u_thursday[1];
                    if (this.u_thursday_in != "") {
                        this.u_thursday_s = true;
                    } else {
                        this.u_thursday_s = false;
                    }
                    var u_friday = response.data[0].Fri.split("-");
                    this.u_friday_in = u_friday[0];
                    this.u_friday_out = u_friday[1];
                    if (this.u_friday_in != "") {
                        this.u_friday_s = true;
                    } else {
                        this.u_friday_s = false;
                    }
                    var u_saturday = response.data[0].Sat.split("-");
                    this.u_saturday_in = u_saturday[0];
                    this.u_saturday_out = u_saturday[1];
                    if (this.u_saturday_in != "") {
                        this.u_saturday_s = true;
                    } else {
                        this.u_saturday_s = false;
                    }
                    var u_sunday = response.data[0].Sun.split("-");
                    this.u_sunday_in = u_sunday[0];
                    this.u_sunday_out = u_sunday[1];
                    if (this.u_sunday_in != "") {
                        this.u_sunday_s = true;
                    } else {
                        this.u_sunday_s = false;
                    }
                })
                .catch((error) => {});
        },

        update_roster() {
            axios
                .post("submit_update_roster", {
                    uroster_id: this.u_roster_id,
                    uroster_name: this.u_roster_name,
                    umonday_s: this.u_monday_s,
                    umonday_in: this.u_monday_in,
                    umonday_out: this.u_monday_out,
                    utuesday_s: this.u_tuesday_s,
                    utuesday_in: this.u_tuesday_in,
                    utuesday_out: this.u_tuesday_out,
                    uwednesday_s: this.u_wednesday_s,
                    uwednesday_in: this.u_wednesday_in,
                    uwednesday_out: this.u_wednesday_out,
                    uthursday_s: this.u_thursday_s,
                    uthursday_in: this.u_thursday_in,
                    uthursday_out: this.u_thursday_out,
                    ufriday_s: this.u_friday_s,
                    ufriday_in: this.u_friday_in,
                    ufriday_out: this.u_friday_out,
                    usaturday_s: this.u_saturday_s,
                    usaturday_in: this.u_saturday_in,
                    usaturday_out: this.u_saturday_out,
                    usunday_s: this.u_sunday_s,
                    usunday_in: this.u_sunday_in,
                    usunday_out: this.u_sunday_out,
                })
                .then((data) => {
                    this.adsdata = data.data;
                    this.$router.go(0);
                    this.$toastr.s(
                        "Updated Roster Successfully!",
                        "Updated Record"
                    );
                })
                .catch((error) => {});
        },
        submit_roster() {
            if (this.roster_name == "") {
                this.$toastr.e(
                    "Please select unique roster name",
                    "Roster Name Missing"
                );
            } else {
                axios
                    .post("submit_roster", {
                        roster_name: this.roster_name,
                        monday_s: this.monday_s,
                        monday_in: this.monday_in,
                        monday_out: this.monday_out,
                        tuesday_s: this.tuesday_s,
                        tuesday_in: this.tuesday_in,
                        tuesday_out: this.tuesday_out,
                        wednesday_s: this.wednesday_s,
                        wednesday_in: this.wednesday_in,
                        wednesday_out: this.wednesday_out,
                        thursday_s: this.thursday_s,
                        thursday_in: this.thursday_in,
                        thursday_out: this.thursday_out,
                        friday_s: this.friday_s,
                        friday_in: this.friday_in,
                        friday_out: this.friday_out,
                        saturday_s: this.saturday_s,
                        saturday_in: this.saturday_in,
                        saturday_out: this.saturday_out,
                        sunday_s: this.sunday_s,
                        sunday_in: this.sunday_in,
                        sunday_out: this.sunday_out,
                    })
                    .then((data) => {
                        if (data.data == "Roster Name Already Exists") {
                            this.$toastr.e(
                                "Roster Name Already Exists!",
                                "Change Roster Name"
                            );
                        } else {
                            this.adsdata = data.data;
                            this.$router.go(0);
                        }
                    })
                    .catch((error) => {});
            }
        },
        getResult() {
            axios
                .get("roster_detail/")
                .then((response) => (this.adsdata = response.data))
                .catch((error) => {});
        },
    },

    mounted() {
        this.getResult();
    },
};
</script>
