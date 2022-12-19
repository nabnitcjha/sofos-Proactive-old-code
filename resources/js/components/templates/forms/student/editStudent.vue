<template>
    <student :titleInfo="titleInfo" :editData="editData"></student>
</template>

<script>
import "./student.css";
import studentComponent from "../../../molecules/student/student.vue";
export default {
    data: function() {
        return {
            titleInfo:{
                pageTitle:"Edit Student",
                logo:"fa fa-chevron-left",
                logoType:"icon",
                actionName:"Back",
                allowAction:true,
                pageType:'edit' 
            },
            editData:[]
        };
    },
    components:{
        "student":studentComponent
    },
};
</script>
