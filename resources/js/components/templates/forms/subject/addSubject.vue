<template>
    <div class="addForm__page">
        <subject :titleInfo="titleInfo"></subject>
    </div>
</template>

<script>
import "../style.css";
import subjectComponent from "../../../molecules/subject/subject";  
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
            }
        };
    },
    components:{
        "subject":subjectComponent 
    }
};
</script>

