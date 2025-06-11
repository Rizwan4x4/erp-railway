<template>
    <div>
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow-tem-change"></div>
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
                                        <h4 class="card-title">Update Company Detail</h4>
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
                                            <div class="mb-1 col-md-6">
                                                <label class="form-label" for="last-name">Company Logo <span style="color:red">*</span></label>
                                                <input id="last-name" name="last-name" required="" type="file" v-on:change="onImageChange" accept="image/x-png,image/gif,image/jpeg" class="form-control">
                                            </div>
                                            <div class="col-md-6 mb-1">
                                                <label class="form-label" for="mobile-number">Mobile number <span style="color:red">*</span></label>
                                                <input required=""  type="number" name="phone_number" v-model="phone_number" id="mobile-number" class="form-control mobile-number-mask" placeholder="(472) 765-3654" />
                                            </div>
                                            <div class="col-md-6 mb-1">
                                                <label class="form-label" for="pin-code">License Id</label>
                                                <input type="text" v-model="license_id" id="pin-code" class="form-control pin-code-mask" placeholder="Code" maxlength="6" />
                                            </div>
                                            <div class="col-md-6 mb-1">
                                                <label class="form-label" for="email">Email <span style="color:red">*</span></label>
                                                <input type="email" name="email" v-model="email" id="email" class="form-control" placeholder="john.doe@email.com" aria-label="john.doe" />

                                                <input type="text" hidden v-model="id" class="form-control" placeholder="john.doe@email.com" aria-label="john.doe" />

                                            </div>



                                            <div class="mb-1 col-md-6">
                                                <label class="form-label" for="town-city">Town/City <span style="color:red">*</span></label>
                                                <input type="text" name="city" required="" v-model="city" id="town-city" class="form-control" placeholder="Town/City" />
                                            </div>



                                            <div class="col-12 mb-1">
                                                <label class="form-label" for="home-address">Home Address <span style="color:red">*</span></label>
                                                <input required="" type="text" name="address" v-model="address" id="home-address" class="form-control" placeholder="Address" />
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
        website_link:'',
        city:'',
        country:'Pakistan',
         password:'',
        email:'',
       	id:'',
          errors: [],
          compan:{ },
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
                   if (this.phone_number == '') {
                    this.errors.push('Phone Number Required!');
                  }
                    if (this.email == '') {
                    this.errors.push('Email Id required!');
                  } else if (!this.validEmail(this.email)) {
                    this.errors.push('Valid email required!');
                  }

                  if (this.address == '') {
                    this.errors.push('Company Address Required!');
                  }
                  if (this.city == '') {
                    this.errors.push('Company City Required!');
                  }


                if(  this.phone_number == '' || this.address == '' || this.city == '' || this.company_name == '' || this.email == '') {
                this.$toastr.e("Firsty complete all Compulsory fields", "Important Detail Missing!");
            } else {
                    axios.post('./update_company', {

                     company_name:this.company_name,
                    phone_number:this.phone_number,
                    license_id:this.license_id,
                    address:this.address,
                    website_link:this.website_link,
                    city:this.city,
                    country:this.country,
                   	id:this.id,
                    email:this.email,

                    })
                    .then(data => {
                        if(data.data=='Record Updated Successfully'){
                         this.$toastr.s("Record Updated Successfully", "Congratulations");
                        }


                    })
                    .catch(error => this.error = error.response.data.errors)
            }



        },
    },
    mounted() {
     axios.get('getcompany_detail/' + this.$route.params.id)
            .then(data => {

				  this.company_name = data.data[0].company_name;
				  this.phone_number = data.data[0].phone_number;
				  this.license_id = data.data[0].license_id;
				  this.address = data.data[0].company_address;
				  this.website_link = data.data[0].company_link;
				  this.city = data.data[0].city;
				  this.country = data.data[0].country;
				  this.email = data.data[0].company_email;
				  this.id = data.data[0].id;

          		   })
            .catch((error) => console.log(error));

    }
}

</script>
