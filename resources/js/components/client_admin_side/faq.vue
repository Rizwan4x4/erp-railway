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
                                <li class="breadcrumb-item active">
                                    FAQs
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="content-body">
                        <!-- /search header -->
                        <!-- frequently asked questions tabs pills -->
                        <section id="faq-tabs">
                            <!-- vertical tab pill -->
                            <div class="row">
                                <div class="col-lg-3 col-md-4 col-sm-12">
                                    <div class="faq-navigation d-flex justify-content-between flex-column mb-2 mb-md-0">
                                        <!-- pill tabs navigation -->
                                        <ul class="nav nav-pills nav-left flex-column" role="tablist">
                                            <!-- payment -->
                                            <li class="nav-item" v-for="allcatg1 in allcatg">
                                                <a class="nav-link" @click="getbyfilter(allcatg1.Catagory)" id="payment" data-bs-toggle="pill" href="#faq-payment" aria-expanded="true" role="tab">
                                                    <i class="fa-solid fa-question"></i>
                                                    <span class="fw-bold">{{allcatg1.Catagory}}</span>
                                                </a>
                                            </li>
                                        </ul>
                                        <!-- FAQ image -->
                                        <img src="public/app-assets/images/illustration/faq-illustrations.svg" class="img-fluid d-none d-md-block" alt="demand img" />
                                    </div>
                                </div>

                                <div class="col-lg-9 col-md-8 col-sm-12">
                                    <!-- pill tabs tab content -->
                                    <div class="tab-content">
                                        <!-- payment panel -->
                                        <div role="tabpanel" class="tab-pane active" id="faq-payment" aria-labelledby="payment" aria-expanded="true">
                                            <!-- icon and header -->
                                            <div class="d-flex align-items-center" v-if="this.catag != ''">
                                                <div class="avatar avatar-tag bg-light-primary me-1">

                                                    <i class="fa-solid fa-question"></i>
                                                </div>
                                                <div>
                                                    <h4 class="mb-0">{{catag}}</h4>
                                                    <span>Acquire information regarding various aspects of our company</span>
                                                </div>
                                            </div>

                                            <!-- frequent answer and question  collapse  -->
                                            <div class="accordion accordion-margin mt-2">
                                                <div class="tab-content">
                                                    <div class="tab-pane active" role="tabpanel">
                                                        <p>
                                                            <div class="accordion accordion-border" id="accordionBorder">
                                                                <div class="accordion-item" v-for="allfaqs1 in allfaqs">
                                                                    <h2 class="accordion-header" :id="'headingBorder'+allfaqs1.faqId">
                                                                        <button @click="getResult(adsdata1.department_name)" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" :data-bs-target="'#accordionBorder'+allfaqs1.faqId" aria-expanded="false" :aria-controls="'accordionBorder'+allfaqs1.faqId">
                                                                            {{allfaqs1.Question}}
                                                                        </button>
                                                                    </h2>
                                                                    <div :id="'accordionBorder'+allfaqs1.faqId" class="accordion-collapse collapse" :aria-labelledby="'headingBorder'+allfaqs1.faqId" data-bs-parent="#accordionBorder">
                                                                        <div class="accordion-body">
                                                                            {{allfaqs1.Answer}}
                                                                        </div>
                                                                        <!-- <video width="320" height="240" autoplay muted>
                                                                        <source src="https://youtu.be/kM0bEh9sLkc" type="video/mp4">
                                                                        Your browser does not support the video tag.
                                                                        </video> -->
                                                                        <div class="m-5">
                                                                        <iframe class="embed-video" width="600" height="315"
                                                                         :src="`https://www.youtube.com/embed/${allfaqs1.Link}?mute=1`">
                                                                        </iframe>
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
                                </div>
                            </div>
                        </section>
                        <!-- / frequently asked questions tabs pills -->
                        <!-- contact us -->
                        <section class="faq-contact">
                            <div class="row mt-5 pt-75">
                                <div class="col-12 text-center">
                                    <h2>You still have a question?</h2>
                                    <p class="mb-3">
                                        If you cannot find a question in our FAQ, you can always contact us. We will answer to you shortly!
                                    </p>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card text-center faq-contact-card shadow-none py-1">
                                        <div class="accordion-body">
                                            <div class="avatar avatar-tag bg-light-primary mb-2 mx-auto">
                                                <i data-feather="phone-call" class="font-medium-3"></i>
                                            </div>
                                            <h4>+92 343 6666636</h4>
                                            <span class="text-body">We are always happy to help!</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card text-center faq-contact-card shadow-none py-1">
                                        <div class="accordion-body">
                                            <div class="avatar avatar-tag bg-light-primary mb-2 mx-auto">
                                                <i data-feather="mail" class="font-medium-3"></i>
                                            </div>
                                            <h4>Info@sasystems.solutions</h4>
                                            <span class="text-body">Best way to get answer faster!</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!--/ contact us -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'

    export default {

        data() {
            return {
                allfaqs: {},
                allcatg: {},
                adsdata: {},
                catag: 'Human Resource',
            }
        },
        methods: {
            getbyfilter(cat) {
                this.catag = cat;
                axios.get('./get_faqs/' + this.catag)
                    .then(data => {
                        this.allfaqs = data.data;
                    })
            },
        },
        mounted() {
            this.getbyfilter(this.catag);
            axios.get('get_faqs_cat')
                .then(data => this.allcatg = data.data)
                .catch(error => { });



            axios.get('department_detail2')
                .then(data => this.adsdata = data.data)
                .catch(error => { });


        },
    }
</script>
<style scoped>
@media (max-width: 1200px)
{
    .embed-video{
        width: 400px;
        height: 215px;
    }
}
@media(max-width: 800px){
   .embed-video{
    width: 280px;
    height: 160px;
   }

}
@media(max-width: 400px){
   .embed-video{
    width: 200px;
    height: 140px;
   }

}

</style>
