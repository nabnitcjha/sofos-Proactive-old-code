<template>
  <teacher-form></teacher-form>
</template>

<script>
import "../style.css";
import teacherDetail from "../../../molecules/teacher/teacherDetail";
export default {
  data: function () {
    return {};
  },
  components: {
    "teacher-form": teacherDetail,
  },
};
</script>
