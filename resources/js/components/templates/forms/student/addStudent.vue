<template>
    <student :titleInfo="titleInfo"></student>
</template>

<script>
import "./student.css";
import studentComponent from "../../../molecules/student/student.vue";
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
            }
        };
    },
    components:{
        "student":studentComponent 
    }
};
</script>
