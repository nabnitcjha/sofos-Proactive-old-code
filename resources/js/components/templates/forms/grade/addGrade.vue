<template>
  <div class="addForm__page">
    <grade :titleInfo="titleInfo"></grade>
  </div>
</template>

<script>
import "../style.css";
import gradeComponent from "../../../molecules/grade/grade";
export default {
  data: function () {
    return {
      titleInfo: {
        pageTitle: "Add grade",
        logo: "fa fa-chevron-left",
        logoType: "icon",
        actionName: "Back",
        allowAction: true,
        pageType: "ad",
      },
    };
  },
  created() {
    // window.Echo.private("newTask").listen(
    //   "App\\Events\\TaskCreatedEvent",
    //   (e) => {
    //     console.log(e);
    //   }
    // );
    //    window.Echo.private("privateChat").listen("ChatEvent", e => {
    //     this.realTime(e);
    // });
    //  window.Echo.channel("newTask").listen(".task-created", e => {
    //   this.$store.commit("ADD_TODO", e.task);
    //   this.newTodo.title = "";
    // });
  },
  mounted() {},
  components: {
    grade: gradeComponent,
  },
};
</script>

