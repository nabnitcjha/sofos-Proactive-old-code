<template>
  <v-app>
    <adminTemplate-component v-if="isAuthenticated"></adminTemplate-component>
  <div class="app__before--login" v-else>
    <router-view></router-view>
  </div>
  </v-app>
  <!-- <div class="app_page">
        <div class="app__admin--template" v-if="isAuthenticated">
            <adminTemplate-component></adminTemplate-component>
        </div>
        <div class="app__before--login" v-else>
            <router-view></router-view>
        </div>

    </div> -->
</template>

<script>
import AdminTemplate from "./templates/admin/dashboard/Admin";
import BeforeLogin from "../components/molecules/common/beforeLogin";
import { mapGetters } from "vuex";
export default {
  data: function () {
    return {};
  },
  computed: {
    ...mapGetters({
      isAuthenticated: "isAuthenticated",
    }),
  },
  components: {
    "adminTemplate-component": AdminTemplate,
    "before-login": BeforeLogin,
  },
  methods: {},
  created() {
    // window.Echo.private("newTask").listen("TaskCreatedEvent", (e) => {
    //   console.log(e);
    // });
  },
  mounted() {
     window.Echo.private("newTask").listen(".task.created", e => {
        console.log(e);
    });
  },
};
</script>
