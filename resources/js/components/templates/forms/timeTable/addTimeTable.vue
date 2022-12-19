<template>
    <div class="addForm__page">
        <timeTable :titleInfo="titleInfo"></timeTable>
    </div>
</template>

<script>
import "../style.css";
import timeTableComponent from "../../../molecules/timeTable/timetable";  
export default {
    data: function() {
        return {
            titleInfo:{
                pageTitle:"Add timeTable",
                logo:"fa fa-chevron-left",
                logoType:"icon",
                actionName:"Back",
                allowAction:true,
                pageType:'ad'
            }
        };
    },
    components:{
        "timeTable":timeTableComponent 
    }
};
</script>

