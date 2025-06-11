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
                            <li class="breadcrumb-item active">Add Documents
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="content-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="row" v-for="doc_data1 in doc_data" >
                                <div class="col-md-3" style="border: 2px solid lightgrey;padding: 10px;margin-top:5px;margin-left:3%;margin-right:3%;margin-bottom:5px;text-align:center">


                                    <img v-if="url" :src="url" id="account-upload-img" class="uploadedAvatar rounded me-50" alt="profile image" style="width:155px;height:180px">
                                     <img v-else-if="doc_data1.Image1!=''" v-bind:src="`public/images/documents/${doc_data1.Image1}`" id="account-upload-img" style="width:100%" alt="profile image">

                                    <img v-else src="public/images/documents/sample.jpg" id="account-upload-img" style="width:100%" alt="profile image">
                                    <input type="file" id="image_file" :v-model="image_file" name="image_file" @change="onFileChange" accept="image/*" class="input-file" style="width: 100px;margin-top: 20px;">
                                    <p v-if="fileSize1" style="margin-top: 10px;">File size: {{ fileSize1 }} bytes</p>
                                </div>
                                <div class="col-md-3" style="border: 2px solid lightgrey;padding: 10px;margin-top:5px;margin-bottom:5px;margin-left:3%;margin-right:3%;text-align:center">
                                    <img v-if="url2" :src="url2" id="account-upload-img" class="uploadedAvatar rounded me-50" alt="profile image" style="width:155px;height:180px">
                                    <img v-else-if="doc_data1.Image2!=''" v-bind:src="`public/images/documents/${doc_data1.Image2}`" id="account-upload-img" style="width:100%" alt="profile image">
                                    <img v-else src="public/images/documents/sample.jpg" id="account-upload-img" style="width:100%" alt="profile image">
                                    <input type="file" id="image_file2" :v-model="image_file2" name="image_file2" @change="onFileChange2" accept="image/*" class="input-file" style="width: 100px;margin-top: 20px;">
                                    <p v-if="fileSize2" style="margin-top: 10px;">File size: {{ fileSize2 }} bytes</p>
                                </div>

                                <div class="col-md-3" style="border: 2px solid lightgrey;padding: 10px;margin-top:5px;margin-bottom:5px;margin-left:3%;margin-right:3%;text-align:center">
                                    <img v-if="url3" :src="url3" id="account-upload-img" class="uploadedAvatar rounded me-50" alt="profile image" style="width:155px;height:180px">
                                    <img v-else-if="doc_data1.Image3!=''" v-bind:src="`public/images/documents/${doc_data1.Image3}`" id="account-upload-img" style="width:100%" alt="profile image">
                                    <img v-else src="public/images/documents/sample.jpg" id="account-upload-img" style="width:100%" alt="profile image">
                                    <input type="file" id="image_file3" :v-model="image_file3" name="image_file3" @change="onFileChange3" accept="image/*" class="input-file" style="width: 100px;margin-top: 20px;">
                                    <p v-if="fileSize3" style="margin-top: 10px;">File size: {{ fileSize3 }} bytes</p>
                                </div>
                                <div class="col-md-3" style="border: 2px solid lightgrey;padding: 10px;margin-top:5px;margin-bottom:5px;margin-left:3%;margin-right:3%;text-align:center">
                                    <img v-if="url4" :src="url4" id="account-upload-img" class="uploadedAvatar rounded me-50" alt="profile image" style="width:155px;height:180px">
                                    <img v-else-if="doc_data1.Image4!=''" v-bind:src="`public/images/documents/${doc_data1.Image4}`" id="account-upload-img" style="width:100%" alt="profile image">
                                    <img v-else src="public/images/documents/sample.jpg" id="account-upload-img" style="width:100%" alt="profile image">
                                    <input type="file" id="image_file4" :v-model="image_file4" name="image_file4" @change="onFileChange4" accept="image/*" class="input-file" style="width: 100px;margin-top: 20px;">
                                    <p v-if="fileSize4" style="margin-top: 10px;">File size: {{ fileSize4 }} bytes</p>
                                </div>
                                <div class="col-md-3" style="border: 2px solid lightgrey;padding: 10px;margin-top:5px;margin-bottom:5px;margin-left:3%;margin-right:3%;text-align:center">
                                    <img v-if="url5" :src="url5" id="account-upload-img" class="uploadedAvatar rounded me-50" alt="profile image" style="width:155px;height:180px">
                                    <img v-else-if="doc_data1.Image5!=''" v-bind:src="`public/images/documents/${doc_data1.Image5}`" id="account-upload-img" style="width:100%" alt="profile image">
                                    <img v-else src="public/images/documents/sample.jpg" id="account-upload-img" style="width:100%" alt="profile image">
                                    <input type="file" id="image_file5" :v-model="image_file5" name="image_file5" @change="onFileChange5" accept="image/*" class="input-file" style="width: 100px;margin-top: 20px;">
                                    <p v-if="fileSize5" style="margin-top: 10px;">File size: {{ fileSize5 }} bytes</p>
                                </div>
                                <div class="col-md-3" style="border: 2px solid lightgrey;padding: 10px;margin-top:5px;margin-bottom:5px;margin-left:3%;margin-right:3%;text-align:center">
                                    <img v-if="url6" :src="url6" id="account-upload-img" class="uploadedAvatar rounded me-50" alt="profile image" style="width:155px;height:180px">
                                    <img v-else-if="doc_data1.Image6!=''" v-bind:src="`public/images/documents/${doc_data1.Image6}`" id="account-upload-img" style="width:100%" alt="profile image">
                                    <img v-else src="public/images/documents/sample.jpg" id="account-upload-img" style="width:100%" alt="profile image">
                                    <input type="file" id="image_file6" :v-model="image_file6" name="image_file6" @change="onFileChange6" accept="image/*" class="input-file" style="width: 100px;margin-top: 20px;">
                                    <p v-if="fileSize6" style="margin-top: 10px;">File size: {{ fileSize6 }} bytes</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Content-->
    </div>
</template>
<script>
const image = "";
const image2 = "";
const image3 = "";
const image4 = "";
const image5 = "";
const image6 = "";
export default {

    data() {

        return {
            id: this.$route.params.id,
            url: null,
            image_file: '',
            url2: null,
            image_file2: '',
             url3: null,
            image_file3: '',
            url4: null,
            image_file4: '',
            url5: null,
            image_file5: '',
             url6: null,
            image_file6: '',
            image,
            doc_data:{ },
            fileSize1:null,
            fileSize2:null,
            fileSize3:null,
            fileSize4:null,
            fileSize5:null,
            fileSize6:null,
        }
    },
    methods: {
        onFileChange(e) {
            let files = e.target.files || e.dataTransfer.files;
            const file = files[0];
            this.image = files[0];
            this.url = URL.createObjectURL(file);
            const fileSize = file.size;
        this.fileSize1 = fileSize;

            const formData = new FormData();
            formData.append('image_file', this.image, this.image.name);
            formData.append('id', this.id);
            axios.post('./update_emp_docs', formData)
                .then(data => {
                    this.$toastr.s("Image Saved Successfully!", "Congratulations");

                })


        },
        onFileChange2(e) {
            let files = e.target.files || e.dataTransfer.files;
            const file = files[0];
            this.image2 = files[0];
            this.url2 = URL.createObjectURL(file);
            const fileSize = file.size;
        this.fileSize2 = fileSize;

            const formData = new FormData();
            formData.append('image_file2', this.image2, this.image2.name);
            formData.append('id', this.id);
            axios.post('./update_emp_docs', formData)
                .then(data => {
                    this.$toastr.s("Image Saved Successfully!", "Congratulations");

                })


        },
        onFileChange3(e) {
            let files = e.target.files || e.dataTransfer.files;
            const file = files[0];
            this.image3 = files[0];
            this.url3 = URL.createObjectURL(file);
            const fileSize = file.size;
        this.fileSize3 = fileSize;

            const formData = new FormData();
            formData.append('image_file3', this.image3, this.image3.name);
            formData.append('id', this.id);
            axios.post('./update_emp_docs', formData)
                .then(data => {
                    this.$toastr.s("Image Saved Successfully!", "Congratulations");

                })

        },
onFileChange4(e) {
            let files = e.target.files || e.dataTransfer.files;
            const file = files[0];
            this.image4 = files[0];
            this.url4 = URL.createObjectURL(file);
            const fileSize = file.size;
        this.fileSize4 = fileSize;

            const formData = new FormData();
            formData.append('image_file4', this.image4, this.image4.name);
            formData.append('id', this.id);
            axios.post('./update_emp_docs', formData)
                .then(data => {
                    this.$toastr.s("Image Saved Successfully!", "Congratulations");

                })


        },
onFileChange5(e) {
            let files = e.target.files || e.dataTransfer.files;
            const file = files[0];
            this.image5 = files[0];
            this.url5 = URL.createObjectURL(file);
            const fileSize = file.size;
        this.fileSize5 = fileSize;

            const formData = new FormData();
            formData.append('image_file5', this.image5, this.image5.name);
            formData.append('id', this.id);
            axios.post('./update_emp_docs', formData)
                .then(data => {
                    this.$toastr.s("Image Saved Successfully!", "Congratulations");

                })


        },
        onFileChange6(e) {
            let files = e.target.files || e.dataTransfer.files;
            const file = files[0];
            this.image6 = files[0];
            this.url6 = URL.createObjectURL(file);
            const fileSize = file.size;
        this.fileSize6 = fileSize;

            const formData = new FormData();
            formData.append('image_file6', this.image6, this.image6.name);
            formData.append('id', this.id);
            axios.post('./update_emp_docs', formData)
                .then(data => {

                    this.$toastr.s("Image Saved Successfully!", "Congratulations");
                })


        },


    },
    mounted() {
   axios.get('getemployee_documents/' + this.$route.params.id)
                .then(data => {
                    nameId: this.$route.params.id,
                    this.doc_data = data.data;
                })


    }
}

</script>
