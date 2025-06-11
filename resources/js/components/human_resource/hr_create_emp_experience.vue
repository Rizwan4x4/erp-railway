<template>
    <div >
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow-tem-change"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <router-link to="/hr/dashboard" style="text-decoration: none;">Dashboard</router-link>
                            </li>
                            <li class="breadcrumb-item">
                                <router-link to="/hr/employees_detail" style="text-decoration: none;">Employees Detail</router-link>
                            </li>
                            <li class="breadcrumb-item active">
                                Add Employee Experience
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="content-body">
                    <div class="card">

                        <div class="card-body">
                            <p>
                                <div class="row">
                                    <!-- Invoice repeater -->
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Add Experience Detail</h4>
                                                <div data-repeater-create="" class="btn btn-primary" v-on:click="add_xz_repeater();">
                                                    <span>
                                                        <i class="fa fas-plus"></i>
                                                        <span>Add</span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group xz_form  row animated slideInDown" v-for="count in counter" :id="count" style="border: 2px solid lightgrey;padding: 10px;margin-top:5px;margin-bottom:5px">
                                                    <div data-repeater-list="" class="col-lg-12">
                                                        <div data-repeater-item="" class="form-group row align-items-center">
                                                            <div class="col-xs-1 delete_btn" style="border-radius:14px;">
                                                                <div data-repeater-delete="" class="btn " style="margin-right: 6px;" v-on:click="delete_xz_form(count)">
                                                                    <span style="padding-top: 14px;padding-left: 7px;">
                                                                        <i class="fas fa-trash-alt"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <slot>

                                                                <div class="col-md-2">
                                                                    <div class="form__group">
                                                                        <div class="form__label">
                                                                            <label class="label">Job Position</label>
                                                                        </div>
                                                                        <div class="form_control">
                                                                            <input name="first[]" type="text" class="form-control">

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form__group">
                                                                        <div class="form__label">
                                                                            <label class="label">Company Name</label>
                                                                        </div>
                                                                        <div class="form_control">
                                                                            <input name="second[]" type="text" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form__group">
                                                                        <div class="form__label">
                                                                            <label class="label">Starting Date</label>
                                                                        </div>
                                                                        <div class="form_control">
                                                                            <input name="third[]" type="date" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form__group">
                                                                        <div class="form__label">
                                                                            <label class="label">Closing Date</label>
                                                                        </div>
                                                                        <div class="form_control">
                                                                            <input name="fourth[]" type="date" class="form-control">
                                                                        </div>

                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form__group">
                                                                        <div class="form__label">
                                                                            <label class="label">Reference</label>
                                                                        </div>
                                                                        <div class="form_control">
                                                                            <input name="fiveth[]" type="text" class="form-control">
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                            </slot>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12" style="text-align:center">
                                                    <button :disabled="disabled" @click="delay()" type="button" class="btn btn-primary">Skip This Step</button>
                                                    <button :disabled="disabled1" @click="delay1()" type="button" class="btn btn-primary mt-1 me-1 waves-effect waves-float waves-light">Save Experience Details</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </p>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Content-->
    </div>
</template>
<script>
    export default {

        data() {

            return {
                id: this.$route.params.id,
                counter: 1,

                disabled: false,
                timeout: null,

                disabled1: false,
                timeout1: null,
            }
        },
        methods: {
            delay() {
                this.disabled = true
                this.timeout = setTimeout(() => {
                    this.disabled = false
                }, 5000)
                this.skip_experience()
            },
            delay1() {
                this.disabled1 = true
                this.timeout1 = setTimeout(() => {
                    this.disabled1 = false
                }, 5000)
                this.test_array()
            },
            test_array() {
                var first = document.getElementsByName('first[]');
                var second = document.getElementsByName('second[]');
                var third = document.getElementsByName('third[]');
                var fourth = document.getElementsByName('fourth[]');
                var fiveth = document.getElementsByName('fiveth[]');
                var k = 'zero';
                var l = 'zero';
                var m = 'zero';
                var n = 'zero';
                var o = 'zero';
                for (var i = 0; i < first.length; i++) {
                    var a = first[i];
                    k = k + "," + a.value;
                }
                for (var j = 0; j < second.length; j++) {
                    var b = second[j];
                    l = l + "," + b.value;
                }
                for (var g = 0; g < third.length; g++) {
                    var c = third[g];
                    m = m + "," + c.value;
                }

                for (var h = 0; h < fourth.length; h++) {
                    var d = fourth[h];
                    n = n + "," + d.value;
                }
                for (var f = 0; f < fiveth.length; f++) {
                    var e = fiveth[f];
                    o = o + "," + e.value;
                }



                axios.post('./insert_experience', {
                    first: k,
                    second: l,
                    third: m,
                    fourth: n,
                    fiveth: o,
                    id: this.id,
                })
                    .then(data => {
                        this.$toastr.s("Inserted Experience Step Successfully", "Congratulations");
                    })
                    .catch((error) => console.log(error));


            },

            add_xz_repeater() {
                this.counter++;

            },
            delete_xz_form(id) {

                const r = confirm("Are you sure?");
                if (r == true) {
                    let node = document.getElementById(id);
                    node.remove();

                }
            },
            skip_experience() {
                var skip = 'skip';
                axios.post('./skip_experience', {
                    id: this.id,
                })
                    .then(data => {
                        if (data.data == "Skip the Education Step Successfully") {
                            this.$toastr.s("Skiped Experience Step Successfully", "Congratulations");
                            this.$router.push('/hr/employees_detail');
                        }

                    })
            }



        },
        mounted() {

        }
    }

</script>
