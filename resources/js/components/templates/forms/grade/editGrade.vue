<template>
    <div class="editGrade__page col-12">
        <grade :titleInfo="titleInfo"></grade>
    </div>
</template>

<script>
import "../style.css";
import gradeComponent from "../../../molecules/grade/grade";
import formMixins from "../../../../Mixins/form";
export default {
    data: function() {
        return {
            titleInfo: {
                pageTitle: "Edit grade",
                logo: "fa fa-chevron-left",
                logoType: "icon",
                actionName: "Back",
                allowAction: true,
                pageType:'edit'
            },
            editData:[] 
        };
    },
    components: {
        grade: gradeComponent
    },
    methods: {
        async getData(){
            let frmData = {...this.editData};
            frmData = await this.getSpecificRecord('grade',this.$route.params.id);
            this.editData = frmData;
        }
    },
    mounted() {
        this.getData();
    },
    mixins: [formMixins]
};
</script>
