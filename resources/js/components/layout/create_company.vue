<template>
    <div>
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                </div>
                <div class="content-body">
                    <!-- Validation -->
                    <section class="bs-validation">
                        <div class="row">
                            <!-- Bootstrap Validation -->
                            <div class="col-md-12 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Create New Company</h4>
                                    </div>
                                    <div class="card-body">
                                        <p v-if="errors.length">
                                            <b>Please correct the following error(s):</b>
                                            <ul>
                                              <li v-for="error in errors" style="color:red;">{{ error }}</li>
                                            </ul>
                                          </p>
                                        <div class="row">
                                            <div class="mb-1 col-md-6">
                                                <label class="form-label" for="first-name">Company Name <span style="color:red">*</span></label>
                                                <input required="" type="text" v-model="company_name" id="first-name" class="form-control" placeholder="Please Type Company Name Here" />
                                            </div>
                                            <div class="mb-1 col-md-2">
                                                <label class="form-label" for="first-name">Company Prefix <span style="color:red">*</span></label>
                                                <input required="" type="text" v-model="company_prefix" id="first-name" class="form-control" placeholder="Prefix" maxlength="3"/>
                                            </div>
                                            <div class="mb-1 col-md-4">
                                                <label class="form-label" for="last-name">Company Logo <span style="color:red">*</span></label>
                                                <input id="last-name" name="last-name" required="" type="file" v-on:change="onImageChange" accept="image/x-png,image/gif,image/jpeg" class="form-control">
                                            </div>
                                            <div class="col-md-6 mb-1">
                                                <label class="form-label" for="mobile-number">Mobile numbers <span style="color:red">*</span></label>
                                                <input required=""  type="number" name="phone_number" v-model="phone_number" id="mobile-number" class="form-control mobile-number-mask" placeholder="(472) 765-3654"/>
                                            </div>
                                            <div class="col-md-6 mb-1">
                                                <label class="form-label" for="pin-code">License Id</label>
                                                <input type="text" v-model="license_id" id="pin-code" class="form-control pin-code-mask" placeholder="Code" maxlength="6" />
                                            </div>
                                            <div class="col-md-6 mb-1">
                                                <label class="form-label" for="email">Email <span style="color:red">*</span></label>
                                                <input type="email" name="email" v-model="email" id="email" class="form-control" placeholder="john.doe@email.com" aria-label="john.doe" />

                                            </div>


                                            <div class="col-md-6 mb-1">
                                                <label class="form-label" for="password">Password <span style="color:red">*</span></label>
                                                <div class="input-group input-group-merge form-password-toggle">
                                                    <input type="password" name="password" v-model="password" id="password" class="form-control" placeholder="min 8 characters" />
                                                    <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                                </div>
                                            </div>

                                            <div class="mb-1 col-md-6">
                                                <label class="form-label" for="town-city">Town/City <span style="color:red">*</span></label>
                                                <input type="text" name="city" required="" v-model="city" id="town-city" class="form-control" placeholder="Town/City" />
                                            </div>
                                            <div class="mb-1 col-md-6">
                                                <label class="form-label" for="country">Country</label>
                                                <input type="text" v-model="country" readonly="" id="town-country" class="form-control" placeholder="Town/City" />
                                            </div>


                                            <div class="col-12 mb-1">
                                                <label class="form-label" for="home-address">Home Address <span style="color:red">*</span></label>
                                                <input required="" type="text" name="address" v-model="address" id="home-address" class="form-control" placeholder="Address" />
                                            </div>
                                            <div class="col-12 mb-1">
                                                <label class="form-label" for="area-address">Area, Street, Sector, Village</label>
                                                <input type="text" v-model="sector" id="area-address" class="form-control" placeholder="Area, Street, Sector, Village" />
                                            </div>
                                            <div class="col-12 mb-1">
                                                <label class="form-label" for="multiStepsURL">Profile Link</label>
                                                <input type="text" name="multiStepsURL" v-model="website_link" id="multiStepsURL" class="form-control" placeholder="johndoe/profile" aria-label="johndoe" />
                                            </div>
                                        </div>
                                        <button @click="submit_data()" class="btn btn-success btn-next">
                                            <span class="align-middle d-sm-inline-block d-none">Submit</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- /Validation -->
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
            image: '',
        company_name:'',
        phone_number:'',
        license_id:'',
        address:'',
        company_prefix:'',
        website_link:'',
        city:'',
        country:'Pakistan',
         password:'',
        email:'',
        sector:'',
          errors: [],

        }
    },
    methods: {
    onImageChange(e) {
            let files = e.target.files || e.dataTransfer.files;
            if (!files.length)
                return;
            this.createImage(files[0]);
        },
        createImage(file) {
            let reader = new FileReader();
            let vm = this;
            reader.onload = (e) => {
                vm.image = e.target.result;
            };
            reader.readAsDataURL(file);
        },
       validEmail: function (email) {
      var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(email);
    },
         submit_data(){
               this.errors = [];
               if (this.company_name == '') {
                    this.errors.push('Company Name Required!');
                  }
             if (this.company_prefix == '') {
                 this.errors.push('Company Prefix Required!');
             }
                   if (this.phone_number == '') {
                    this.errors.push('Phone Number Required!');
                  }
                    if (this.email == '') {
                    this.errors.push('Email Id required!');
                  } else if (!this.validEmail(this.email)) {
                    this.errors.push('Valid email required!');
                  }
                  if (this.image == '') {
                    this.errors.push('Company Logo Required!');
                  }
                  if (this.address == '') {
                    this.errors.push('Company Address Required!');
                  }
                  if (this.city == '') {
                    this.errors.push('Company City Required!');
                  }


             if (this.image == '' || this.phone_number == '' || this.address == '' || this.city == '' || this.company_name == '' || this.company_prefix == '' ||  this.password == ''|| this.email == '') {
                this.$toastr.e("Firsty complete all Compulsory fields", "Important Detail Missing!");
            } else {
                    axios.post('./create_company', {
                     image: this.image,
                     company_name:this.company_name,
                        company_prefix: this.company_prefix,
                    phone_number:this.phone_number,
                    license_id:this.license_id,
                    address:this.address,
                    website_link:this.website_link,
                    city:this.city,
                    country:this.country,
                    username:this.username,
                    password:this.password,
                    email:this.email,
                    sector:this.sector,
                    })
                    .then(data => {
                        if(data.data=='Company Already Exists in Our Database.Please Try Other One!'){
                         this.$toastr.e("Company Already Exists", "Please Try Other One!");
                        }else if (data.data == 'Data Submit Successfully') {
                            this.$toastr.s("Company Created Successfully", "Congratulations!");

                         }


                    })
                    .catch(error => this.error = error.response.data.errors)
            }



        },
    },
    mounted() {
    }
}

</script>
