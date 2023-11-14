<template>
  <div>
   <div class="app-content content ">
         <div class="content-overlay"></div>
         <div class="header-navbar-shadow"></div>

         <!-- <h1 v-if="show==1" >Loading....<h2>Please wait</h2></h1> -->
         <div  v-if="show==1"  class="d-flex justify-content-center w-100 h-100">
            <div class="spinner-border " role="status" style="width: 5rem; height: 5rem">
              <span class="visually-hidden">Loading...</span>
            </div>
         </div>

          <div v-else>
            <TreeChart :json="ds" />
          </div>


         <br><br><br><br><br><br><br><br>
         <br><br><br><br><br><br><br><br>
     </div>
    </div>
 </template>


 <script>

import TreeChart from "vue-tree-chart";
 import 'vue-organization-chart/dist/orgchart.css'

     export default {
      components: {
    TreeChart
  },
     data(){
     return {
      url: null,
      team:{},
     adsdata:{},
     show:1,
     emp_detail:'',
     ds: {
     image_url: "./public/images/profile_images/pro.png",
     name:'Sohail Afzal Malik',
     title:'Chairman',
     extend:false,
     children: [  ],
     },
     }
     },

     methods:{
       delay() {
                 this.timeout = setTimeout(() => {
                 }, 5000)

                 this.seting(2);
             },
 checkchild(id){
         let n=0;

         for(let ii=0;ii<this.team.length;ii++){
           if(this.team[ii].ReportingTo == id ) {
             n++;
           }
         }
       return n;
 },
       checkteam(id){
         let let1=[];

         let c=0;
         for(let ii=0;ii<this.team.length;ii++){

                                           if(this.team[ii].ReportingTo == id ) {
                                            c++;
                                            let n=this.checkchild(this.team[ii].EmployeeID);
                                            if(n>0){

                                               let1.push({image_url: "./public/images/profile_images/"+this.team[ii].Photo,name:this.team[ii].Name,extend:false,children:this.checkteam(this.team[ii].EmployeeID)});

                                             }
                                             else{
                                             let1.push({image_url: "./public/images/profile_images/"+this.team[ii].Photo,name:this.team[ii].Name,extend:false,children:''});
                                             }
                                           }
                                          }
              return let1;
       },
       seting(id)
       {
       this.ds.children.push({image_url: "./public/images/profile_images/pro.png",name:this.emp_detail[0].Name,extend:false,children:this.checkteam(id)});
       this.show++;
  },
      },
         mounted() {
           axios.get('getindemployee_detail/' + 2)
                 .then(data => {
                     this.emp_detail = data.data.data;

                 })


             axios.get('organization_chart')
           .then(response =>
           {

            this.team = response.data;
            this.delay();
          })
           .catch(error => { });



         }
     }
 </script>
 <style >
.node .person[data-v-3e1326fa]{
  width: 13em !important;
}
.extend_handle[data-v-3e1326fa] {

     bottom: 30px !important;
    width: 20px !important;
    height: 20px  !important;
    padding: 5px !important;
   margin-left: 4px !important;
}
 </style>
