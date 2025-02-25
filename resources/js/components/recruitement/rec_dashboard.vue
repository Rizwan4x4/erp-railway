<template>
    <div>
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                </div>
                <div class="content-body">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <router-link class="d-flex align-items-center" to="/">
                                    Home
                                </router-link>
                            </li>
                            <li class="breadcrumb-item">
                                Recruitment
                            </li>
                        </ol>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="card border-0 top-radius bottom-radius" data-bs-target="#viewposts"
                                data-bs-toggle="modal" style="cursor:pointer;">
                                <div class="card-header align-items-start top-radius bottom-radius">
                                    <div>
                                        <div>
                                            <h6 class="fw-bolder">Total Posts </h6>
                                        </div>
                                        <h2 class="fw-bolder mb-0" v-if="postsct < 10 && postsct != 0">0{{ postsct }}
                                        </h2>
                                        <h2 class="fw-bolder mb-0" v-else>0{{ postsct }}</h2>
                                        <p class="card-text">Posts</p>
                                    </div>
                                    <div class=" m-0">
                                        <div class="avatar-content ">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="card border-0 top-radius bottom-radius">
                                <div class="card-header align-items-start top-radius bottom-radius ">
                                    <div>
                                        <h6 class="fw-bolder">Total Applications</h6>
                                        <h2 class="fw-bolder mb-0">0{{ top_counters.short_listed }}</h2>
                                        <h2 class="fw-bolder mb-0"></h2>
                                        <p class="card-text">Applications</p>
                                    </div>
                                    <div class=" m-0">
                                        <div class="avatar-content">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="card border-0 top-radius bottom-radius">
                                <div class="card-header align-items-start top-radius bottom-radius">
                                    <div>
                                        <h6 class="fw-bolder">Ongoing Interviews</h6>
                                        <h2 class="fw-bolder mb-0" v-if="ct_ong_int < 10 && ct_ong_int != 0">
                                            {{ ct_ong_int }}</h2>
                                        <h2 class="fw-bolder mb-0" v-else>0{{ ct_ong_int }}</h2>
                                        <p class="card-text">Interviews</p>
                                    </div>
                                    <div class=" m-0">
                                        <div class="avatar-content">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="card border-0 top-radius bottom-radius">
                                <div class="card-header align-items-start top-radius bottom-radius">
                                    <div>
                                        <h6 class="fw-bolder">Short Listed</h6>
                                        <h2 class="fw-bolder mb-0" v-if="slcandsct < 10 && slcandsct != 0">
                                            0{{ slcandsct }}</h2>
                                        <h2 class="fw-bolder mb-0" v-else>0{{ slcandsct }}</h2>
                                        <p class="card-text">Listed</p>
                                    </div>
                                    <div class=" m-0">
                                        <div class="avatar-content">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Second Section -->
                    <div class="row">
                        <div class="col-xl-8 col-md-6 col-12">
                            <div class="card card-developer-meetup rounded-4 border-0">
                                <div class="d-flex">
                                    <div class="w-100 p-4 ">
                                        <h4 class=" fw-semibold">Hiring</h4>
                                        <div class="chart-container">
                                            <div class="card-body statistics-body">
                                                <apexchart type="bar" height="220px" :options="options"
                                                    :series="series">
                                                </apexchart>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6 col-12">
                            <div class="card card-developer-meetup rounded-4 border-0">
                                <div class="d-flex">
                                    <div class="w-100 p-4 ">
                                        <h4 class=" fw-semibold">Hiring Ratio</h4>
                                        <div class="chart-container">
                                            <div class="card-body statistics-body">
                                                <apexchart type="donut" height="230" :options="chartOptions9"
                                                    :series="series9">
                                                </apexchart>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- inner second section -->
                        <div class="col-xl-4 col-md-6 col-12">
                            <div class="card card-developer-meetup rounded-4 border-0">
                                <div class="d-flex">
                                    <div class="w-100 p-4 ">
                                        <h4 class=" fw-semibold">Hires by source</h4>
                                        <div class="chart-container">
                                            <div class="card-body statistics-body d-flex  align-items-center p-2">
                                                <span class="text-primary rounded-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                        fill="currentColor" class="bi bi-linkedin" viewBox="0 0 16 16">
                                                        <path
                                                            d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854zm4.943 12.248V6.169H2.542v7.225zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248S2.4 3.226 2.4 3.934c0 .694.521 1.248 1.327 1.248zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016l.016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225z" />
                                                    </svg>
                                                </span>
                                                <span class="h6 fw-bold p-2">LinkedIn</span>
                                                <span class="ms-auto p-2"><strong>65%</strong></span>
                                            </div>
                                            <div class="card-body statistics-body d-flex  align-items-center p-2">
                                                <span class="text-primary rounded-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="32"
                                                        height="32" viewBox="0 0 32 32">
                                                        <path
                                                            d="M 18.5 2 C 10.75 2 6 11.25 6 16 C 6 16 9.25 4 19 4 C 22.625 4 25 6 25 6 C 25 6 24 2 18.5 2 z M 17.5 7 A 3.5 3.5 0 1 0 17.5 14 A 3.5 3.5 0 1 0 17.5 7 z M 20 16 C 20 16 19 17 15 17 L 15 27.5 C 15 28.881 16.119 30 17.5 30 C 18.881 30 20 28.881 20 27.5 L 20 16 z">
                                                        </path>
                                                    </svg>
                                                </span>
                                                <span class="h6 fw-bold p-2">Indeed</span>
                                                <span class="ms-auto p-2"><strong>35%</strong></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-developer-meetup rounded-4 border-0">
                                <div class="d-flex">
                                    <div class="w-100 p-4 ">
                                        <h4 class=" fw-semibold">Calender</h4>
                                        <div class="chart-container">
                                            <div class="card-body statistics-body d-flex  align-items-center p-2">
                                                <!-- body -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-8 col-md-6 col-12">
                            <div class="card card-developer-meetup rounded-4 border-0">
                                <div class="d-flex">
                                    <div class="w-100 p-4 ">
                                        <h4 class=" fw-semibold">Active Posts</h4>
                                        <div class="chart-container">
                                            <div
                                                class="card-body statistics-body d-flex justify-content-between align-items-center w-100 p-2">
                                                <span class="p-2 fw-bold">Product Designer</span>
                                                <span class="px-2 bg-primary-subtle text-primary rounded-2">31
                                                    Inbox</span>
                                                <span class="px-2 bg-danger-subtle text-danger rounded-2">12
                                                    Interview</span>
                                                <span class="px-2 bg-success-subtle text-success rounded-2">05
                                                    Hired</span>
                                                <span
                                                    class="px-2 pb-1 bg-body-secondary rounded-2 self-align-center"><strong>...</strong></span>
                                            </div>
                                            <div
                                                class="card-body statistics-body d-flex justify-content-between align-items-center w-100 p-2">
                                                <span class="p-2 fw-bold">Product Designer</span>
                                                <span class="px-2 bg-primary-subtle text-primary rounded-2">31
                                                    Inbox</span>
                                                <span class="px-2 bg-danger-subtle text-danger rounded-2">12
                                                    Interview</span>
                                                <span class="px-2 bg-success-subtle text-success rounded-2">05
                                                    Hired</span>
                                                <span
                                                    class="px-2 pb-1 bg-body-secondary rounded-2 self-align-center"><strong>...</strong></span>
                                            </div>
                                            <div
                                                class="card-body statistics-body d-flex justify-content-between align-items-center w-100 p-2">
                                                <span class="p-2 fw-bold">Product Designer</span>
                                                <span class="px-2 bg-primary-subtle text-primary rounded-2">31
                                                    Inbox</span>
                                                <span class="px-2 bg-danger-subtle text-danger rounded-2">12
                                                    Interview</span>
                                                <span class="px-2 bg-success-subtle text-success rounded-2">05
                                                    Hired</span>
                                                <span
                                                    class="px-2 pb-1 bg-body-secondary rounded-2 self-align-center"><strong>...</strong></span>
                                            </div>
                                            <div
                                                class="card-body statistics-body d-flex justify-content-between align-items-center w-100 p-2">
                                                <span class="p-2 fw-bold">Product Designer</span>
                                                <span class="px-2 bg-primary-subtle text-primary rounded-2">31
                                                    Inbox</span>
                                                <span class="px-2 bg-danger-subtle text-danger rounded-2">12
                                                    Interview</span>
                                                <span class="px-2 bg-success-subtle text-success rounded-2">05
                                                    Hired</span>
                                                <span
                                                    class="px-2 pb-1 bg-body-secondary rounded-2 self-align-center"><strong>...</strong></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-developer-meetup rounded-4 border-0">
                                <div class="d-flex">
                                    <div class="w-100 p-4 ">
                                        <h4 class=" fw-semibold">Performed Activities</h4>
                                        <div class="chart-container">
                                            <div
                                                class="card-body statistics-body d-flex justify-content-between align-items-center border-bottom w-100 p-2 set-overlap">
                                                <div class="d-flex flex-column  w-100 ">
                                                    <span class="fw-bold">First Interview of Olivier Scheduled.</span>
                                                    <p>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                            fill="currentColor" class="bi bi-calendar-week"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5z" />
                                                            <path
                                                                d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z" />
                                                        </svg>
                                                        Monday, Nov 27
                                                    </p>
                                                </div>

                                                <img src="../../../../public/images/logo/sagroup.png" alt="Profile-img"
                                                    class="ms-auto rounded-circle pro-img ">
                                                <img src="../../../../public/images/logo/sagroup.png" alt="Profile-img"
                                                    class="ms-auto rounded-circle pro-img">
                                            </div>
                                            <div
                                                class="card-body statistics-body d-flex justify-content-between align-items-center border-bottom w-100 p-2 set-overlap">
                                                <div class="d-flex flex-column  w-100 ">
                                                    <span class="fw-bold">Hired Candidates for multiple positions.</span>
                                                    <p>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                            fill="currentColor" class="bi bi-calendar-week"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5z" />
                                                            <path
                                                                d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z" />
                                                        </svg>
                                                        Monday, Nov 27
                                                    </p>
                                                </div>

                                                <img src="../../../../public/images/logo/sagroup.png" alt="Profile-img"
                                                    class="ms-auto rounded-circle pro-img ">
                                                <img src="../../../../public/images/logo/sagroup.png" alt="Profile-img"
                                                    class="ms-auto rounded-circle pro-img">
                                            </div>
                                            <div
                                                class="card-body statistics-body d-flex justify-content-between align-items-center border-bottom w-100 p-2 set-overlap">
                                                <div class="d-flex flex-column  w-100 ">
                                                    <span class="fw-bold">First Interview of Henry Scheduled.</span>
                                                    <p>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                            fill="currentColor" class="bi bi-calendar-week"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5z" />
                                                            <path
                                                                d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z" />
                                                        </svg>
                                                        Monday, Nov 27
                                                    </p>
                                                </div>

                                                <img src="../../../../public/images/logo/sagroup.png" alt="Profile-img"
                                                    class="ms-auto rounded-circle pro-img ">
                                                <img src="../../../../public/images/logo/sasystems.png" alt="Profile-img"
                                                    class="ms-auto rounded-circle pro-img">
                                            </div>
                                            <div
                                                class="card-body statistics-body d-flex justify-content-between align-items-center border-bottom w-100 p-2 set-overlap">
                                                <div class="d-flex flex-column  w-100 ">
                                                    <span class="fw-bold">Hired Candidates for multiple positions.</span>
                                                    <p>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                            fill="currentColor" class="bi bi-calendar-week"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5z" />
                                                            <path
                                                                d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z" />
                                                        </svg>
                                                        Monday, Nov 27
                                                    </p>
                                                </div>

                                                <img src="../../../../public/images/logo/garden.jpg" alt="Profile-img"
                                                    class="ms-auto rounded-circle pro-img ">
                                                <img src="../../../../public/images/logo/sagroup.png" alt="Profile-img"
                                                    class="ms-auto rounded-circle pro-img">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Inner third Section -->








                        <!-- <div class="col-lg-4 col-md-6 col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title">Candidates ratio</h4>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="feather feather-help-circle font-medium-3 text-muted cursor-pointer">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                                    </svg>
                                </div>
                                <div class="card-body p-0" style="position: relative;">
                                    <div id="goal-overview-radial-bar-chart" class="my-2" style="min-height: 236px;">
                                        <div id="apexchartsk5hzssku"
                                            class="apexcharts-canvas apexchartsk5hzssku apexcharts-theme-light"
                                            style="width: 382px; height: 205.633px;">
                                            <svg id="SvgjsSvg1730" width="382" height="205.63333333333335"
                                                xmlns="http://www.w3.org/2000/svg" version="1.1"
                                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                                xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg"
                                                xmlns:data="ApexChartsNS" transform="translate(0, 0)"
                                                style="background: transparent;">
                                                <g id="SvgjsG1732" class="apexcharts-inner apexcharts-graphical"
                                                    transform="translate(68.5, -10)">

                                                    <g id="SvgjsG1736" class="apexcharts-radialbar">
                                                        <g id="SvgjsG1737">
                                                            <g id="SvgjsG1738" class="apexcharts-tracks">
                                                                <g id="SvgjsG1739"
                                                                    class="apexcharts-radialbar-track apexcharts-track"
                                                                    rel="1">
                                                                    <path id="apexcharts-radialbarTrack-0"
                                                                        d="M 77.85670731707313 184.82445114399718 A 89.28658536585367 89.28658536585367 0 1 1 167.14329268292684 184.82445114399718"
                                                                        fill="none" fill-opacity="1"
                                                                        stroke="rgba(235,233,241,0.85)"
                                                                        stroke-opacity="1" stroke-linecap="round"
                                                                        stroke-width="3.5304878048780495"
                                                                        stroke-dasharray="0"
                                                                        class="apexcharts-radialbar-area"
                                                                        data:pathOrig="M 77.85670731707313 184.82445114399718 A 89.28658536585367 89.28658536585367 0 1 1 167.14329268292684 184.82445114399718">
                                                                    </path>
                                                                </g>
                                                            </g>
                                                            <g id="SvgjsG1745">
                                                                <g id="SvgjsG1749"
                                                                    class="apexcharts-series apexcharts-radial-series"
                                                                    seriesName="seriesx1" rel="1" data:realIndex="0">
                                                                    <path id="SvgjsPath1754"
                                                                        d="M 77.85670731707313 184.82445114399718 A 89.28658536585367 89.28658536585367 0 1 1 210.6873193374061 121.46749921697622"
                                                                        fill="none" fill-opacity="0.85"
                                                                        stroke="url(#SvgjsLinearGradient1750)"
                                                                        stroke-opacity="1" stroke-linecap="round"
                                                                        stroke-width="7.060975609756099"
                                                                        stroke-dasharray="0"
                                                                        class="apexcharts-radialbar-area apexcharts-radialbar-slice-0"
                                                                        data:angle="249" data:value="83" index="0" j="0"
                                                                        data:pathOrig="M 77.85670731707313 184.82445114399718 A 89.28658536585367 89.28658536585367 0 1 1 210.6873193374061 121.46749921697622"
                                                                        filter="url(#SvgjsFilter1782)">
                                                                    </path>
                                                                </g>
                                                                <g id="SvgjsG1747" class="apexcharts-datalabels-group"
                                                                    transform="translate(0, 0) scale(1)"
                                                                    style="opacity: 1;">
                                                                    <text id="SvgjsText1748"
                                                                        font-family="Helvetica, Arial, sans-serif"
                                                                        x="122.5" y="123.5" text-anchor="middle"
                                                                        dominant-baseline="auto" font-size="2.86rem"
                                                                        font-weight="600" fill="#5e5873"
                                                                        class="apexcharts-text apexcharts-datalabel-value"
                                                                        style="font-family: Helvetica, Arial, sans-serif;">
                                                                        {{ parseInt((ct_ong_int /
                                                                            candsct) * 100) }}%
                                                                    </text>
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                    <line id="SvgjsLine1764" x1="0" y1="0" x2="245" y2="0"
                                                        stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1"
                                                        class="apexcharts-ycrosshairs">
                                                    </line>
                                                    <line id="SvgjsLine1765" x1="0" y1="0" x2="245" y2="0"
                                                        stroke-dasharray="0" stroke-width="0"
                                                        class="apexcharts-ycrosshairs-hidden"></line>
                                                </g>
                                                <g id="SvgjsG1733" class="apexcharts-annotations"></g>
                                            </svg>
                                            <div class="apexcharts-legend"></div>
                                        </div>
                                    </div>
                                    <div class="row border-top text-center mx-0">
                                        <div class="col-6 border-end py-1">
                                            <p class="card-text text-muted mb-0">Total</p>
                                            <h3 class="fw-bolder mb-0">{{ candsct }}</h3>
                                        </div>
                                        <div class="col-6 py-1">
                                            <p class="card-text text-muted mb-0">In Progress</p>
                                            <h3 class="fw-bolder mb-0">{{ ct_ong_int }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title">Hiring ratio</h4>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="feather feather-help-circle font-medium-3 text-muted cursor-pointer">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                                    </svg>
                                </div>
                                <div class="card-body p-0" style="position: relative;">
                                    <div id="goal-overview-radial-bar-chart" class="my-2" style="min-height: 236px;">
                                        <div id="apexchartsk5hzssku"
                                            class="apexcharts-canvas apexchartsk5hzssku apexcharts-theme-light"
                                            style="width: 382px; height: 205.633px;">
                                            <svg id="SvgjsSvg1730" width="382" height="205.63333333333335"
                                                xmlns="http://www.w3.org/2000/svg" version="1.1"
                                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                                xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg"
                                                xmlns:data="ApexChartsNS" transform="translate(0, 0)"
                                                style="background: transparent;">
                                                <g id="SvgjsG1732" class="apexcharts-inner apexcharts-graphical"
                                                    transform="translate(68.5, -10)">
                                                    <defs id="SvgjsDefs1731">
                                                        <clipPath id="gridRectMaskk5hzssku">
                                                            <rect id="SvgjsRect1734" width="251" height="217" x="-3"
                                                                y="-1" rx="0" ry="0" opacity="1" stroke-width="0"
                                                                stroke="none" stroke-dasharray="0" fill="#fff">
                                                            </rect>
                                                        </clipPath>
                                                        <clipPath id="gridRectMarkerMaskk5hzssku">
                                                            <rect id="SvgjsRect1735" width="249" height="219" x="-2"
                                                                y="-2" rx="0" ry="0" opacity="1" stroke-width="0"
                                                                stroke="none" stroke-dasharray="0" fill="#fff">
                                                            </rect>
                                                        </clipPath>
                                                        <linearGradient id="SvgjsLinearGradient1740" x1="0" y1="1"
                                                            x2="1" y2="1">
                                                            <stop id="SvgjsStop1741" stop-opacity="1"
                                                                stop-color="rgba(40,199,111,1)" offset="0"></stop>
                                                            <stop id="SvgjsStop1742" stop-opacity="1"
                                                                stop-color="rgba(235,233,241,1)" offset="1"></stop>
                                                            <stop id="SvgjsStop1743" stop-opacity="1"
                                                                stop-color="rgba(235,233,241,1)" offset="1"></stop>
                                                        </linearGradient>
                                                        <linearGradient id="SvgjsLinearGradient1750" x1="0" y1="1"
                                                            x2="1" y2="1">
                                                            <stop id="SvgjsStop1751" stop-opacity="1"
                                                                stop-color="rgba(40,199,111,1)" offset="0"></stop>
                                                            <stop id="SvgjsStop1752" stop-opacity="1"
                                                                stop-color="rgba(81,229,168,1)" offset="1"></stop>
                                                            <stop id="SvgjsStop1753" stop-opacity="1"
                                                                stop-color="rgba(81,229,168,1)" offset="1"></stop>
                                                        </linearGradient>
                                                        <filter id="SvgjsFilter1782" filterUnits="userSpaceOnUse"
                                                            width="200%" height="200%" x="-50%" y="-50%">
                                                            <feFlood id="SvgjsFeFlood1783" flood-color="#000000"
                                                                flood-opacity="0.1" result="SvgjsFeFlood1783Out"
                                                                in="SourceGraphic"></feFlood>
                                                            <feComposite id="SvgjsFeComposite1784"
                                                                in="SvgjsFeFlood1783Out" in2="SourceAlpha" operator="in"
                                                                result="SvgjsFeComposite1784Out">
                                                            </feComposite>
                                                            <feOffset id="SvgjsFeOffset1785" dx="1" dy="1"
                                                                result="SvgjsFeOffset1785Out"
                                                                in="SvgjsFeComposite1784Out"></feOffset>
                                                            <feGaussianBlur id="SvgjsFeGaussianBlur1786"
                                                                stdDeviation="3 " result="SvgjsFeGaussianBlur1786Out"
                                                                in="SvgjsFeOffset1785Out">
                                                            </feGaussianBlur>
                                                            <feMerge id="SvgjsFeMerge1787" result="SvgjsFeMerge1787Out"
                                                                in="SourceGraphic">
                                                                <feMergeNode id="SvgjsFeMergeNode1788"
                                                                    in="SvgjsFeGaussianBlur1786Out">
                                                                </feMergeNode>
                                                                <feMergeNode id="SvgjsFeMergeNode1789"
                                                                    in="[object Arguments]">
                                                                </feMergeNode>
                                                            </feMerge>
                                                            <feBlend id="SvgjsFeBlend1790" in="SourceGraphic"
                                                                in2="SvgjsFeMerge1787Out" mode="normal"
                                                                result="SvgjsFeBlend1790Out"></feBlend>
                                                        </filter>
                                                    </defs>
                                                    <g id="SvgjsG1736" class="apexcharts-radialbar">
                                                        <g id="SvgjsG1737">
                                                            <g id="SvgjsG1738" class="apexcharts-tracks">
                                                                <g id="SvgjsG1739"
                                                                    class="apexcharts-radialbar-track apexcharts-track"
                                                                    rel="1">
                                                                    <path id="apexcharts-radialbarTrack-0"
                                                                        d="M 77.85670731707313 184.82445114399718 A 89.28658536585367 89.28658536585367 0 1 1 167.14329268292684 184.82445114399718"
                                                                        fill="none" fill-opacity="1"
                                                                        stroke="rgba(235,233,241,0.85)"
                                                                        stroke-opacity="1" stroke-linecap="round"
                                                                        stroke-width="3.5304878048780495"
                                                                        stroke-dasharray="0"
                                                                        class="apexcharts-radialbar-area"
                                                                        data:pathOrig="M 77.85670731707313 184.82445114399718 A 89.28658536585367 89.28658536585367 0 1 1 167.14329268292684 184.82445114399718">
                                                                    </path>
                                                                </g>
                                                            </g>
                                                            <g id="SvgjsG1745">
                                                                <g id="SvgjsG1749"
                                                                    class="apexcharts-series apexcharts-radial-series"
                                                                    seriesName="seriesx1" rel="1" data:realIndex="0">
                                                                    <path id="SvgjsPath1754"
                                                                        d="M 77.85670731707313 184.82445114399718 A 89.28658536585367 89.28658536585367 0 1 1 210.6873193374061 121.46749921697622"
                                                                        fill="none" fill-opacity="0.85"
                                                                        stroke="url(#SvgjsLinearGradient1750)"
                                                                        stroke-opacity="1" stroke-linecap="round"
                                                                        stroke-width="7.060975609756099"
                                                                        stroke-dasharray="0"
                                                                        class="apexcharts-radialbar-area apexcharts-radialbar-slice-0"
                                                                        data:angle="249" data:value="83" index="0" j="0"
                                                                        data:pathOrig="M 77.85670731707313 184.82445114399718 A 89.28658536585367 89.28658536585367 0 1 1 210.6873193374061 121.46749921697622"
                                                                        filter="url(#SvgjsFilter1782)">
                                                                    </path>
                                                                </g>
                                                                <circle id="SvgjsCircle1746" r="82.52134146341464"
                                                                    cx="122.5" cy="107.5"
                                                                    class="apexcharts-radialbar-hollow"
                                                                    fill="transparent"></circle>
                                                                <g id="SvgjsG1747" class="apexcharts-datalabels-group"
                                                                    transform="translate(0, 0) scale(1)"
                                                                    style="opacity: 1;">
                                                                    <text id="SvgjsText1748"
                                                                        font-family="Helvetica, Arial, sans-serif"
                                                                        x="122.5" y="123.5" text-anchor="middle"
                                                                        dominant-baseline="auto" font-size="2.86rem"
                                                                        font-weight="600" fill="#5e5873"
                                                                        class="apexcharts-text apexcharts-datalabel-value"
                                                                        style="font-family: Helvetica, Arial, sans-serif;">
                                                                        {{ parseInt((cnd_hir /
                                                                            ct_ong_int) * 100) }}%
                                                                    </text>
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                    <line id="SvgjsLine1764" x1="0" y1="0" x2="245" y2="0"
                                                        stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1"
                                                        class="apexcharts-ycrosshairs">
                                                    </line>
                                                    <line id="SvgjsLine1765" x1="0" y1="0" x2="245" y2="0"
                                                        stroke-dasharray="0" stroke-width="0"
                                                        class="apexcharts-ycrosshairs-hidden"></line>
                                                </g>
                                                <g id="SvgjsG1733" class="apexcharts-annotations"></g>
                                            </svg>
                                            <div class="apexcharts-legend"></div>
                                        </div>
                                    </div>
                                    <div class="row border-top text-center mx-0">
                                        <div class="col-6 border-end py-1">
                                            <p class="card-text text-muted mb-0">Total</p>
                                            <h3 class="fw-bolder mb-0">{{ ct_ong_int }}</h3>
                                        </div>
                                        <div class="col-6 py-1">
                                            <p class="card-text text-muted mb-0">Hired</p>
                                            <h3 class="fw-bolder mb-0">{{ cnd_hir }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <!-- Hired candidate Card -->
                        <!-- <div class="col-lg-4 col-md-6 col-12">
                            <div class="card card-employee-task">
                                <div class="card-header">
                                    <h4 class="card-title">Hired this month</h4>
                                </div>
                                <div class="card-body" style="height:308px; overflow:auto;">
                                    <div class="employee-task d-flex justify-content-between align-items-center"
                                        v-for="mnth_hir1 in mnth_hir" data-bs-target="#viewhiredcandidate"
                                        data-bs-toggle="modal" style="cursor:pointer;">
                                        <div class="d-flex flex-row">
                                            <div class="avatar me-75" style="height:max-content">
                                                <img src="public/app-assets/images/portrait/small/avatar-s-16.jpg"
                                                    class="rounded" width="42" height="42" alt="Avatar" />
                                            </div>
                                            <div class="my-auto">
                                                <h6 class="mb-0">{{ mnth_hir1.CandName }}</h6>
                                                <small>{{ mnth_hir1.PostTitle }}</small>
                                            </div>
                                        </div>
                                        <div class="d-flex" style="float: right; max-width: 25%; ">
                                            <small class="text-muted me-75" style=" font-size:11px; ">{{
                                                mnth_hir1.updatedOn }}</small>
                                        </div>
                                    </div>
                                    <hr />
                                </div>
                            </div>
                        </div> -->
                        <!--/ Hired candidate Card -->
                        <!--  hired candidate  -->
                        <!-- <div class="modal fade" id="viewhiredcandidate" tabindex="-1" aria-labelledby="addNewCardTitle"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-transparent">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body px-sm-5 mx-50 pb-5">

                                        <div class="user-avatar-section">
                                            <div class="d-flex align-items-center flex-column">
                                                <img class="img-fluid rounded mt-3 mb-2"
                                                    src="public/app-assets/images/portrait/small/avatar-s-2.jpg"
                                                    height="110" width="110" alt="User avatar" />
                                                <div class="user-info text-center">
                                                    <h4>Gertrude Barton</h4>
                                                    <span class="badge bg-light-secondary">Author</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-around my-2 pt-75">
                                            <div class="d-flex align-items-start me-2">
                                                <span class="badge bg-light-primary p-75 rounded">
                                                    <i data-feather="check" class="font-medium-2"></i>
                                                </span>
                                                <div class="ms-75">
                                                    <h4 class="mb-0">1.23k</h4>
                                                    <small>Tasks Done</small>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-start">
                                                <span class="badge bg-light-primary p-75 rounded">
                                                    <i data-feather="briefcase" class="font-medium-2"></i>
                                                </span>
                                                <div class="ms-75">
                                                    <h4 class="mb-0">568</h4>
                                                    <small>Projects Done</small>
                                                </div>
                                            </div>
                                        </div>
                                        <h4 class="fw-bolder border-bottom pb-50 mb-1">Details</h4>
                                        <div class="info-container">
                                            <ul class="list-unstyled">
                                                <li class="mb-75">
                                                    <span class="fw-bolder me-25">Username:</span>
                                                    <span>violet.dev</span>
                                                </li>
                                                <li class="mb-75">
                                                    <span class="fw-bolder me-25">Billing Email:</span>
                                                    <span>vafgot@vultukir.org</span>
                                                </li>
                                                <li class="mb-75">
                                                    <span class="fw-bolder me-25">Status:</span>
                                                    <span class="badge bg-light-success">Active</span>
                                                </li>
                                                <li class="mb-75">
                                                    <span class="fw-bolder me-25">Role:</span>
                                                    <span>Author</span>
                                                </li>
                                                <li class="mb-75">
                                                    <span class="fw-bolder me-25">Tax ID:</span>
                                                    <span>Tax-8965</span>
                                                </li>
                                                <li class="mb-75">
                                                    <span class="fw-bolder me-25">Contact:</span>
                                                    <span>+1 (609) 933-44-22</span>
                                                </li>
                                                <li class="mb-75">
                                                    <span class="fw-bolder me-25">Language:</span>
                                                    <span>English</span>
                                                </li>
                                                <li class="mb-75">
                                                    <span class="fw-bolder me-25">Country:</span>
                                                    <span>Wake Island</span>
                                                </li>
                                            </ul>
                                            <div class="d-flex justify-content-center pt-2">
                                                <a href="javascript:;" class="btn btn-primary me-1"
                                                    data-bs-target="#editUser" data-bs-toggle="modal">
                                                    Edit
                                                </a>
                                                <a href="javascript:;"
                                                    class="btn btn-outline-danger suspend-user">Suspended</a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <!--/  hired candidate  -->
                    </div>
                    <div class="col-md-12 col-12">
                        <div clas="card" style="background-color:white !important">
                            <div class="table-responsive" style="overflow-x: auto !important;">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th style="width: 34%; text-align: center; white-space: nowrap;">
                                                Post name
                                            </th>
                                            <th style="width: 21%; text-align: center; white-space: nowrap;">
                                                Applications
                                                received
                                            </th>
                                            <th style="width: 0px; text-align: center; white-space: nowrap;">
                                            </th>
                                            <th style="width: auto; text-align: center; white-space: nowrap;">
                                                Ongoing
                                                interviews
                                            </th>
                                            <th style="width: auto; text-align: center; white-space: nowrap;">
                                                Offered
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                                <div class="table-responsive" style="max-height:300px ;overflow-y:auto;">
                                    <table class="table mb-0">
                                        <tbody>
                                            <tr v-for="jobs1 in jobs" style="height: 1em; overflow: hidden;">
                                                <td style="width:26%; vertical-align: middle; white-space:nowrap;"
                                                    colspan="2">
                                                    <h6 class="mb-0">{{ jobs1.PostTitle }}</h6>
                                                </td>
                                                <td
                                                    style="font-size:0px; overflow: hidden; width: 0px; max-height:10px">
                                                    <span v-for="candidates1 in candidates"
                                                        v-if="candidates1.JobID == jobs1.JobID">{{ a = a
                                                            + 1 }}</span>
                                                </td>
                                                <td
                                                    style="vertical-align: middle; text-align: center; white-space: nowrap;">
                                                    <span class="badge rounded-pill badge-light-primary me-1">{{
                                                        a
                                                    }}</span>
                                                </td>
                                                <td
                                                    style="font-size: 0px; overflow: hidden; width: 0px; max-height: 10px">
                                                    <span v-for="interview1 in interview"
                                                        v-if="interview1.JobID == jobs1.JobID && interview1.hire_sts != '1'">{{
                                                            b = b + 1 }}</span>
                                                </td>
                                                <td
                                                    style="width: 26%; vertical-align: middle; text-align: center; white-space: nowrap;">
                                                    <span class="badge rounded-pill badge-light-primary me-1">{{
                                                        b
                                                    }}</span>
                                                </td>
                                                <td
                                                    style="text-align: center; visibility: hidden; overflow: hidden; width: 13%;">
                                                    <span class="badge badge-light-danger">{{ a = 0 }}{{
                                                        b = 0 }}</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Activities Performed</h4>
                            </div>
                            <div class="card-body" style="height: 500px; overflow: scroll;">
                                <ul class="timeline" v-for="recs1 in recs">
                                    <li class="timeline-item" style="border-left-color: #c1c1c180 !important ">
                                        <span class="timeline-point timeline-point-success timeline-point-indicator"
                                            v-if="recs1.EventStatus == 'Interview scheduled' || recs1.EventStatus == 'Candidate added'"></span>
                                        <span class="timeline-point timeline-point-success"
                                            v-else-if="recs1.EventStatus == 'Candidate shortlisted'">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-user">
                                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2">
                                                </path>
                                                <circle cx="12" cy="7" r="4"></circle>
                                            </svg>
                                        </span>
                                        <span class="timeline-point timeline-point-success"
                                            v-else-if="recs1.EventStatus == 'Candidate hired'">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none"
                                                class="bi bi-person-check-fill" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M15.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z" />
                                                <path
                                                    d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                                            </svg>
                                        </span>
                                        <span class="timeline-point timeline-point-warning timeline-point-indicator"
                                            v-else></span>
                                        <div class="timeline-event">
                                            <div
                                                class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                                <h6 class="mb-50">{{ recs1.EventStatus }}</h6>
                                                <span class="timeline-event-time">{{ recs1.ActivityTime
                                                    }}</span>
                                            </div>
                                            <p>{{ recs1.Description }}</p>
                                            <hr />
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- view posts modal -->
                <div class="modal fade" id="viewposts" tabindex="-1" aria-labelledby="pricingModalTitle"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl">
                        <div class="modal-content">
                            <div class="modal-header bg-transparent">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body px-sm-5 mx-50 pb-5">
                                <div id="pricing-plan">
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-6 col-md-6" v-for="jobs3 in jobs">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between">
                                                        <span><span v-if="jobs3.JobNumber < 2">Only</span><span
                                                                v-else>Total</span> {{ jobs3.JobNumber
                                                            }} <span v-if="jobs3.JobNumber < 2">vacancy</span><span
                                                                v-else>vacancies</span></span>
                                                        <ul
                                                            class="list-unstyled d-flex align-items-center avatar-group mb-0">
                                                            <li class="avatar avatar-sm pull-up"
                                                                v-for="candidates3 in candidates"
                                                                v-if="candidates3.JobID == jobs3.JobID">
                                                                <img class="rounded-circle"
                                                                    src="public/app-assets/images/avatars/2.png"
                                                                    alt="Avatar" />
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div
                                                        class="d-flex justify-content-between align-items-end mt-1 pt-25">
                                                        <div class="role-heading">
                                                            <h4 class="fw-bolder">{{ jobs3.PostTitle }}
                                                            </h4>
                                                        </div>
                                                    </div>

                                                    <small class="fw-bolder" style="color: #b9b9c3">
                                                        <cite title="View applications"> Last date to
                                                            apply is:
                                                            <label>{{ jobs3.EndDate }}</label></cite>
                                                    </small>
                                                    <small class="fw-bolder" style="float:right;">
                                                        <router-link class="align-items-center" style="color:dimgray"
                                                            to="">
                                                            <i data-feather='edit' style="width: 25px;"></i>
                                                        </router-link>

                                                        <router-link class="align-items-center" style="color:dimgray"
                                                            to="">
                                                            <i data-feather='trash' style="width: 20px;"></i>
                                                        </router-link>
                                                    </small>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ view posts modal -->
            </div>
        </div>
    </div>
</template>

<script>
export default {

    // components: {
    //     apexchart: VueApexCharts,
    // },
    data() {
        return {
            a: 1,
            b: 1,
            c: 1,
            value: 0,
            postsct: '',
            candsct: '',
            slcandsct: '',
            ct_ong_int: '',
            top_counters: {},

            count: 1,
            mnth_hir: {},
            candidates: {},
            recs: {},
            jobs: {},
            cnd_hir: '',
            rel_int_ct: '',
            interview: {},


            series9: [20, 22],  //Will be populated with API data Employee Composition
            //  chartKey: 0,
            chartOptions9: {
                pie: {
                    donut: {
                        size: '100%'  // Smaller inner circle = thicker donut
                    }
                },
                chart: {
                    type: "donut",
                },
                labels: ["Candidate Ratio", "Hiring Ratio"],
                colors: ["#0070F2", "#FF6900"],
                dataLabels: {
                    style: {
                        fontSize: '9px',
                    }
                },
                legend: {
                    show: true,   // Ensure legend is visible
                    position: 'bottom',  // Moves legend to the bottom
                    horizontalAlign: 'center' // Centers the legend
                },
                stroke: {
                    width: 0
                }
            },

            series: [
                {
                    name: 'Hired Persons',
                    data: [44, 55, 41, 67, 22],
                    color: '#FF6900'
                }, {
                    name: 'Pendding Persons',
                    data: [21, 7, 25, 13, 22],
                    color: '#0070F2'
                }
            ],
            options: {
                chart: {
                    type: 'bar',
                    height: 350,
                    stacked: true,
                    toolbar: {
                        show: true
                    },

                    zoom: {
                        enabled: true
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        legend: {
                            position: 'bottom',
                            offsetX: -20,
                            offsetY: 0
                        }
                    }
                }],
                plotOptions: {
                    bar: {
                        horizontal: false,
                        borderRadius: 10,
                        borderRadiusApplication: 'end', // 'around', 'end'
                        borderRadiusWhenStacked: 'last', // 'all', 'last'
                        dataLabels: {
                            total: {
                                enabled: true,
                                style: {
                                    fontSize: '13px',
                                    fontWeight: 900
                                }
                            }
                        }
                    },
                },
                xaxis: {
                    //   type: 'datetime',
                    categories: ['Week 01', 'Week 02', 'Week 03', 'Week 04', 'Week 05'],
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'right',
                    formatter: function (seriesName) {
                        return '<span style="margin-right: 30px;">' + seriesName + '</span>';
                    }
                }
                ,
                fill: {
                    opacity: 1
                }
            },



        }
    },
    methods: {

    },
    mounted() {






        axios.get('top_counters') //Count top list of dashboard
            .then(data => {
                this.top_counters = data.data;
                this.postsct = this.top_counters.jobs_count;
                this.candsct = this.top_counters.applications;
                this.ct_ong_int = this.top_counters.ongoing_interview;
                this.slcandsct = this.top_counters.short_listed;
            })
            .catch(error => {
            });

        axios.get('job_detail2')  //Get all posts
            .then(data => this.jobs = data.data)
            .catch(error => {
            });

        axios.get('rel_cand_count') //Count relevent job interviews
            .then(data => this.interview = data.data)
            .catch(error => {
            });

        axios.get('mnth_hired')  //Get hired candidates of last 30 days
            .then(data => this.mnth_hir = data.data)
            .catch(error => {
            });

        axios.get('cnd_hired')  //Count hired candidates
            .then(data => this.cnd_hir = data.data)
            .catch(error => {
            });

        axios.get('rec_activities')  //Recruitment activities
            .then(data => this.recs = data.data)
            .catch(error => {
            });

        axios.get('candidate_detail2') // Get all candidates
            .then(data => this.candidates = data.data)
            .catch(error => {
            });

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

.pro-img {
    height: 50px;
    width: 50px;
    object-fit: cover;
    position: relative;
}
.set-overlap img:not(:last-child) {
    position: relative; /* Ensures controlled movement */
    left: 5%; /* Overlaps previous image */
    z-index: 0;
}
</style>
