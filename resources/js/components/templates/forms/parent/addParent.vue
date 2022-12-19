<template>
    <div class="addParent__page">
        <parent :titleInfo="titleInfo"></parent>
    </div>
</template>

<script>
import "../style.css";
import parentComponent from "../../../molecules/parent/parent";
export default {
    data: function() {
        return {
            titleInfo:{
                pageTitle:"Add Parent",
                logo:"fa fa-chevron-left",
                logoType:"icon",
                actionName:"Back",
                allowAction:true,
                pageType:'add'
            }
        };
    },
    components:{
        "parent":parentComponent
    },
};
</script>

