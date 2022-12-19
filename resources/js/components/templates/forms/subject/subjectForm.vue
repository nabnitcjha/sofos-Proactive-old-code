<template>
    <div class="subjectFormTemplate__page col-12">
         <div class="text-center">
      <b-spinner
        style="width: 3rem; height: 3rem"
        label="Large Spinner"
        variant="success"
        v-show="loading"
      ></b-spinner>
    </div>
        <subject-form :subjectDetail="subjectDetail" @get-subject-detail="getDetails"></subject-form>
    </div>
</template>

<script>
import "../style.css";
import subjectForm from "../../../molecules/subject/subjectForm";  
import formMixins from "../../../../Mixins/form";
export default {
    data: function() {
        return {
            titleInfo:{
                pageTitle:"Add subject",
                logo:"fa fa-chevron-left",
                logoType:"icon",
                actionName:"Back",
                allowAction:true,
                pageType:'ad'
            },
            subjectDetail:[],
            loading: true,
        };
    },
    components:{
        "subject-form":subjectForm
    },
        methods: {
        async getData(){
            this.loading = true;
            let frmData = [...this.subjectDetail];
            frmData = await this.getSpecificRecord('subject',this.$route.params.id); 
            this.subjectDetail = frmData;
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
