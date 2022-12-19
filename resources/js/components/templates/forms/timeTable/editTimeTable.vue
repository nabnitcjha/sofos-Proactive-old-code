<template>
  <div class="editTimeTable__page col-12">
    <timeTable :titleInfo="titleInfo"></timeTable>
  </div>
</template>

<script>
import "../style.css";
import timeTableComponent from "../../../molecules/timeTable/timetable";
import formMixins from "../../../../Mixins/form";
export default {
  data: function () {
    return {
      titleInfo: {
        pageTitle: "Edit timeTable",
        logo: "fa fa-chevron-left",
        logoType: "icon",
        actionName: "Back",
        allowAction: true,
        pageType: "edit",
      }
    };
  },
  components: {
    timeTable: timeTableComponent,
  },
};
</script>
