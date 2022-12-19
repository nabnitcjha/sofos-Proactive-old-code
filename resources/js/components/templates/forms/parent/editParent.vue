<template>
    <div class="editParent__page">
        <parent :titleInfo="titleInfo" :editData="editData"></parent>
    </div>
</template>

<script>
import "../style.css";
import parentComponent from "../../../molecules/parent/parent";
import formMixins from "../../../../Mixins/form";
export default {
    data: function() {
        return {
            titleInfo:{
                pageTitle:"Edit Parent",
                logo:"fa fa-chevron-left",
                logoType:"icon",
                actionName:"Back",
                allowAction:true,
                pageType:'edit'
            },
            editData:{}
        };

    },
    components:{
         "parent":parentComponent
    },
    methods: {
       async getData(){
            let frmData = {...this.editData};
            frmData = await this.getSpecificRecord('parent',this.$route.params.id);
            this.editData = frmData;
        }
    },
    mounted(){
        this.getData();
    },
    mixins: [formMixins]
};
</script>

