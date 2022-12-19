<template>
    <div class="editSubject__page col-12">
        <subject :titleInfo="titleInfo"></subject>
    </div>
</template>

<script>
import "../style.css";
import subjectComponent from "../../../molecules/subject/subject";
import formMixins from "../../../../Mixins/form";
export default {
    data: function() {
        return {
            titleInfo: {
                pageTitle: "Edit subject",
                logo: "fa fa-chevron-left",
                logoType: "icon",
                actionName: "Back",
                allowAction: true,
                pageType:'edit'
            },
        };
    },
    components: {
        subject: subjectComponent
    },
};
</script>
