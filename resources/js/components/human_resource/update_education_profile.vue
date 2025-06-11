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
                                <router-link to="/" style="text-decoration: none;">Dashboard</router-link>
                            </li>
                            <li class="breadcrumb-item">
                                <router-link to="/" style="text-decoration: none;">Employees Detail
                                </router-link>
                            </li>
                            <li class="breadcrumb-item active">Add Employee Education
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
                                                <h4 class="card-title">Add Education Detail</h4>

                                                <div data-repeater-create="" class="btn btn-primary"
                                                     v-on:click="add_xz_repeater();">
                        <span>
                            <i class="fa fas-plus"></i>
                            <span>Add</span>
                        </span>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div v-for="edu_data1 in edu_data" class="row"
                                                     style="border: 2px solid lightgrey;padding: 10px;margin-top:5px;margin-bottom:5px">

                                                    <div class="col-md-3">
                                                        <div class="form__group">
                                                            <div class="form__label">
                                                                <label class="label">Degree Type</label>
                                                            </div>
                                                            <div class="form_control">
                                                                <select id="first[]" name="first[]"
                                                                        class="form-select mb-md-0 mb-2">
                                                                    <option v-bind:value="edu_data1.DegreeType">
                                                                        {{ edu_data1.DegreeType }}
                                                                    </option>
                                                                    <option value="Diploma">Diploma</option>
                                                                    <option value="Certificate">Certificate</option>
                                                                    <option value="Degree">Degree</option>
                                                                </select>
                                                                <multiselect id="first[]" name="first[]"
                                                                             style="margin-right: 10px;"
                                                                             placeholder="Degree Type"
                                                                             v-model="m_status" :options="options2">
                                                                </multiselect>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form__group">
                                                            <div class="form__label">
                                                                <label class="label">Degree Name</label>
                                                            </div>
                                                            <div class="form_control">
                                                                <input name="second[]"
                                                                       v-bind:value="edu_data1.DegreeName" type="text"
                                                                       class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form__group">
                                                            <div class="form__label">
                                                                <label class="label">Institute Name</label>
                                                            </div>
                                                            <div class="form_control">
                                                                <input name="third[]"
                                                                       v-bind:value="edu_data1.InstituteName"
                                                                       type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form__group">
                                                            <div class="form__label">
                                                                <label class="label">Passing Year</label>
                                                            </div>
                                                            <div class="form_control">
                                                                <input name="fourth[]"
                                                                       v-bind:value="edu_data1.PassingYear"
                                                                       type="number" class="form-control">
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>
                                                <div class="form-group xz_form  row animated slideInDown"
                                                     v-for="count in counter" :id="count"
                                                     style="border: 2px solid lightgrey;padding: 10px;margin-top:5px;margin-bottom:5px">
                                                    <div data-repeater-list="" class="col-lg-12">
                                                        <div data-repeater-item=""
                                                             class="form-group row align-items-center">
                                                            <div class="col-xs-1 delete_btn"
                                                                 style="border-radius:14px;">
                                                                <div data-repeater-delete="" class="btn "
                                                                     style="margin-right: 6px;"
                                                                     v-on:click="delete_xz_form(count)">
                            <span style="padding-top: 14px;padding-left: 7px;">
                                <i class="fas fa-trash-alt"></i>
                            </span>
                                                                </div>
                                                            </div>
                                                            <slot>

                                                                <div class="col-md-3">
                                                                    <div class="form__group">
                                                                        <div class="form__label">
                                                                            <label class="label">Degree Type</label>
                                                                        </div>
                                                                        <div class="form_control">
                                                                            <select id="first[]" name="first[]"
                                                                                    class="form-select mb-md-0 mb-2">
                                                                                <option value="">Degree Type</option>
                                                                                <option value="Diploma">Diploma</option>
                                                                                <option value="Certificate">
                                                                                    Certificate
                                                                                </option>
                                                                                <option value="Degree">Degree</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form__group">
                                                                        <div class="form__label">
                                                                            <label class="label">Degree Name</label>
                                                                        </div>
                                                                        <div class="form_control">
                                                                            <input name="second[]" type="text"
                                                                                   class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form__group">
                                                                        <div class="form__label">
                                                                            <label class="label">Institute Name</label>
                                                                        </div>
                                                                        <div class="form_control">
                                                                            <input name="third[]" type="text"
                                                                                   class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form__group">
                                                                        <div class="form__label">
                                                                            <label class="label">Passing Year</label>
                                                                        </div>
                                                                        <div class="form_control">
                                                                            <input name="fourth[]" type="number"
                                                                                   class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </slot>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12" style="text-align:center">
                                                    <button @click="skip_education()" type="button"
                                                            class="btn btn-primary">Skip This Step
                                                    </button>
                                                    <button @click="test_array2()" type="button"
                                                            class="btn btn-primary mt-1 me-1 waves-effect waves-float waves-light">
                                                        Save Education Detail
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
import Multiselect from 'vue-multiselect'

export default {
    components: {
        Multiselect
    },
    data() {
        return {
            id: this.$route.params.id,
            counter: 0,
            edu_data: {},
        }
    },
    methods: {
        test_array2() {
            var first = document.getElementsByName('first[]');
            var second = document.getElementsByName('second[]');
            var third = document.getElementsByName('third[]');
            var fourth = document.getElementsByName('fourth[]');
            var k = 'zero';
            var l = 'zero';
            var m = 'zero';
            var n = 'zero';
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
            axios.post('./insert_education', {
                first: k,
                second: l,
                third: m,
                fourth: n,
                id: this.id,
            })
                .then(data => {
                    this.$toastr.s("Updated Education Step Successfully", "Congratulations");
                })
                .catch((error) => console.log(error));
        },
        add_xz_repeater() {
            this.counter++;
            // let itm  = document.getElementsByClassName("xz_form")[0];
            // let cln = itm.cloneNode(true);
            // cln.id = this.counter;
            // document.getElementsByClassName("container")[0].insertBefore(cln,document.getElementsByClassName("adding")[0]);
        },
        delete_xz_form(id) {

            const r = confirm("Are you sure?");
            if (r == true) {
                let node = document.getElementById(id);
                node.remove();
            }
        },
        skip_education() {
            var skip = 'skip';
            axios.post('./skip_education', {
                id: this.id,
            })
                .then(data => {
                    if (data.data == "Skip the Education Step Successfully") {
                        this.$toastr.s("Skiped Education Step Successfully", "Congratulations");
                        this.$router.push('/hr/employees_detail');
                    }
                })
        }
    },
    mounted() {


        axios.get('getemployee_update_education/' + this.$route.params.id)
            .then(data => {
                this.edu_data = data.data;
            })
    }
}

</script>
