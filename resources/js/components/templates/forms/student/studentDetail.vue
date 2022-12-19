<template>
    <div class="studentDetailTemplate__page col-12">
         <div class="text-center">
      <!-- <b-spinner
        style="width: 3rem; height: 3rem"
        label="Large Spinner"
        variant="success"
        v-show="loading"
      ></b-spinner> -->
    </div>
        <student-form :titleInfo="titleInfo" :studentDetail="studentDetail" @get-student-detail="getDetails"></student-form>
    </div>
</template>

<script>
import "../style.css";
import studentDetail from "../../../molecules/student/studentDetail";
import formMixins from "../../../../Mixins/form";
export default {
    data: function() {
        return {
            titleInfo:{
                pageTitle:"Add Student",
                logo:"fa fa-chevron-left",
                logoType:"icon",
                actionName:"Back",
                allowAction:true,
                pageType:'add'
            },
            studentDetail:[],
            loading:true
        };
    },
    components:{
        "student-form":studentDetail
    },
      methods: {
        async getData(){
            this.loading = true;
            let frmData = [...this.studentDetail];
            frmData = await this.getSpecificRecord('student',this.$route.params.id);
            this.studentDetail = frmData;
            this.loading = false;
        },
         getDetails(){
            this.getData();
        }
    },
      mounted() {
        this.getData();
    },
     mixins: [formMixins]
};
</script>
