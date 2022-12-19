<template>
 <teacher :titleInfo="titleInfo"></teacher>
</template>

<script>
import "../style.css";
import teacherComponent from "../../../molecules/teacher/teacher.vue";
export default {
  data: function () {
    return {
      titleInfo: {
        pageTitle: "Edit Teacher",
        logo: "fa fa-chevron-left",
        logoType: "icon",
        actionName: "Back",
        allowAction: true,
        pageType: "edit",
      }
    };
  },
  components: {
    teacher: teacherComponent,
  },
};
</script>
