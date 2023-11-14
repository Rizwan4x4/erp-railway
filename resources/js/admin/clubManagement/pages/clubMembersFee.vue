<template>
    <memberRegister :receipt =  'receipt'/>

</template>
<script>
import memberRegister from "./memberRegister.vue";
 import axios from 'axios'


    export default {
        components: {
            "memberRegister": memberRegister,
        },

        data() {
            return {
                member_data:[],
                receipt: true

            }
        },
        methods: {
        },
        mounted() {
            axios.get('./get_member_data').then(res => {
                this.member_data = res.data.data;
                console.log(this.member_data)

              })
              .catch(error => {
                                console.error("Error during getting member data:", error);

                            });
        }
    }
</script>

