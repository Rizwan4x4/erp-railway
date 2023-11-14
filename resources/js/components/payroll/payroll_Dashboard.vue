<template>
    <div
>
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active">
                                Payroll Dashboard
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="content-body">
                    <div class="row match-height">
                        <div  class="col-lg-12 col-sm-6 col-12">
                            <!--/ Medal Card -->
                            <div class="row">

                                <div class="col-lg-12 col-6 col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div>
                                                <apexchart :height="300" type="bar" :options="options3"
                                                           :series="series3"></apexchart>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-6 col-12">
                                    <div class="card">
                                        <div class="card-body">

                                            <div>
                                                <apexchart :height="300" type="bar" :options="options4"
                                                           :series="series4"></apexchart>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div  class="col-lg-12 col-sm-12 col-12">

                        <div class="card card-congratulation-medal">
                            <div class="card-body">
                                <div id="chart">
                                    <apexchart :height="500" type="bar" :options="options2"
                                               :series="series2"></apexchart>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div  class="col-lg-12 col-sm-12 col-12">
                        <div class="card card-congratulation-medal">
                            <div class="card-body">
                                <div id="chart">

                                    <apexchart type="bar" height="750" :options="chartOptions1"
                                               :series="series1"></apexchart>
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
import moment from 'moment';
import VueApexCharts from 'vue-apexcharts';

Vue.filter('formatDate', function (value) {
    if (value) {
        return moment(String(value)).format('ddd MMM DD,YYYY')
    }
})

export default {
    components: {
        apexchart: VueApexCharts,
    },
    data: function () {
        return {
            options3: {
                chart: {
                    type: 'bar',
                    height: 250
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 1,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: [],

                },
                title: {
                    text: 'Salaries Distribution Report',
                    align: 'left'
                },
                yaxis: {
                    // title: {
                    //     text: 'Income Statement'
                    // }
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return "Rs. " + val + ".00"
                        }
                    }
                }
            },
            series3: [{
                name: 'Total',
                data: [0]
            }, {
                name: 'Paid',
                data: [0]
            },
                {
                    name: 'Pending',
                    data: [0]
                }

            ],


            options4: {
                chart: {
                    type: 'bar',
                    height: 250
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                        columnWidth: '65%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: true
                },
                stroke: {
                    show: true,
                    width: 1,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: [''],
                },
                title: {
                    text: 'Current Session Loan & Advance'
                },
                yaxis: {
                    // title: {
                    //     text: ''
                    // }
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return "Rs. " + val + ".00"
                        }
                    }
                }
            },
            series4: [{
                name: 'Total',
                data: [0]
            }, {
                name: 'Loan',
                data: [0]
            },
                {
                    name: 'Advance',
                    data: [0]
                },
                {
                    name: 'Approved Advance',
                    data: [0]
                },
                {
                    name: 'Pending Advance',
                    data: [0]
                },
                {
                    name: 'Rejected Advance',
                    data: [0]
                },
                {
                    name: 'Approved Loan',
                    data: [0]
                },
                {
                    name: 'Pending Loan',
                    data: [0]
                },
                {
                    name: 'Rejected Loan',
                    data: [0]
                }],

            series1: [{
                name: '',
                data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
            }, {
                name: '',
                data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
            }, {
                name: '',
                data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
            },
                {
                    name: '',
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                }, {
                    name: ' ',
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                }, {
                    name: '',
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                },
                {
                    name: '',
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                },
                {
                    name: '',
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                }, {
                    name: '',
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                }, {
                    name: '',
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                },
                {
                    name: '',
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                }, {
                    name: '',
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                }, {
                    name: '',
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                },
                {
                    name: '',
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                }, {
                    name: '',
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                }, {
                    name: '',
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                },
                {
                    name: '',
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                }, {
                    name: '',
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                },
                {
                    name: '',
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                },
                {
                    name: ' ',
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                },
                {
                    name: '',
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                }
            ],
            chartOptions1: {
                chart: {
                    type: 'bar',
                    height: 350,
                    stacked: true,
                    stackType: '100%'
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        legend: {
                            position: 'bottom',
                            offsetX: -10,
                            offsetY: 0
                        }
                    }
                }],
                title: {
                    text: 'Salaries Percentage  of each Company By Month',
                    align: 'left'
                },
                xaxis: {
                    categories: ['', '', '', '', '', '', '', '', '', '', '', ''],
                },
                fill: {
                    opacity: 1
                },
                legend: {
                    position: 'right',
                    offsetX: 0,
                    offsetY: 50
                },
            },
            adsdata: {},

            options2: {
                chart: {
                    type: 'bar',
                    height: 250
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 1,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: [],
                },
                title: {
                    text: 'Month Wise Allowance',
                    align: 'left'
                },
                yaxis: {
                    // title: {
                    //     text: 'Income Statement'
                    // }
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return "Rs. " + val + ".00"
                        }
                    }
                }
            },
            series2: [
                {
                    name: 'Bonuses',
                    data: [0]
                },
                {
                    name: 'Arrears',
                    data: [0]
                },
                {
                    name: 'Overtime',
                    data: [0]
                },
                {
                    name: 'Fuel',
                    data: [0]
                },
                {
                    name: 'Stipend',
                    data: [0]
                }, {
                    name: 'Allowance',
                    data: [0]
                },

            ],
            SDR: {},
            AR: {},
            CS: {},
            GCS: {},
            show: [0, 0, 0, 0, 0, 0, 0, 0, 0]
        }
    },
    methods: {
        set1() {
            for (let i in this.AR) {
                if (this.AR[i].SessionName != null) {
                    this.options2.xaxis.categories[i] = this.AR[i].SessionName;
                } else {
                    this.options2.xaxis.categories[i] = '';
                }
                this.series2[0].data[i] = this.AR[i].BonusAmount
                this.series2[1].data[i] = this.AR[i].ArrearsAmount;
                this.series2[2].data[i] = this.AR[i].Overtime;
                this.series2[3].data[i] = this.AR[i].FuelAmount;
                this.series2[4].data[i] = this.AR[i].StipendAmount;
                this.series2[5].data[i] = this.AR[i].AllowanceAmount;
            }
        },
        set2() {
            for (let i in this.SDR) {
                if (this.SDR[i].SessionName != null) {
                    this.options3.xaxis.categories[i] = this.SDR[i].SessionName;
                } else {
                    this.options3.xaxis.categories[i] = '';
                }
                this.series3[0].data[i] = this.SDR[i].TotalPayable;
                this.series3[1].data[i] = this.SDR[i].Paid;
                this.series3[2].data[i] = this.SDR[i].Pending;
            }
        },
        set3() {
            for (let ii in this.CS[0]) {
                this.chartOptions1.xaxis.categories[ii] = this.CS[0][ii].SessionName;
            }
            let p = 0;
            for (let i1 in this.CS[1]) {
                if (this.CS[1][i1].CompanyName != null) {
                    this.series1[p].name = this.CS[1][i1].CompanyName;
                    p++;

                    for (let i in this.CS[2]) {
                        if (this.CS[2][i].CompanyName == this.CS[1][i1].CompanyName) {
                            for (let ii in this.CS[0]) {
                                if (this.CS[2][i].SessionName == this.CS[0][ii].SessionName) {
                                    this.series1[i1].data[ii] = this.CS[2][i].PayableSalary;

                                }
                            }

                        }
                    }
                }
            }
        },
        
    }
    ,
    mounted() {

        axios.get('Salary_DistributionReport')
            .then(response => {
                this.SDR = response.data;
                this.set2();
            })
            .catch(error => {
            });


        axios.get('Companywise_Salary')
            .then(response => {
                this.CS = response.data;
                this.set3();
            })
            .catch(error => {
            });


        axios.get('AllowancesReport')
            .then(response => {
                this.AR = response.data;
                this.set1();
            })
            .catch(error => {
            });

        axios.get('getLoan_C_Session')
            .then(response => {
                this.GCS = response.data;
                this.series4[0].data[0] = parseFloat(this.GCS[0]);
                this.series4[1].data[0] = parseFloat(this.GCS[1]);
                this.series4[2].data[0] = parseFloat(this.GCS[2]);

                this.series4[3].data[0] = parseFloat(this.GCS[3]);
                this.series4[4].data[0] = parseFloat(this.GCS[4]);
                this.series4[5].data[0] = parseFloat(this.GCS[5]);

                this.series4[6].data[0] = parseFloat(this.GCS[6]);
                this.series4[7].data[0] = parseFloat(this.GCS[7]);
                this.series4[8].data[0] = parseFloat(this.GCS[8]);

            })
            .catch(error => {
            });

      
    }
}

</script>
