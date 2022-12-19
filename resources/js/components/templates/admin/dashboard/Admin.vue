<template>
  <div id="wrapper" >
       <!-- TopBar -->
        <navbar-component></navbar-component>
        <!-- Topbar -->
    <!-- Sidebar -->
    <sidebar-component></sidebar-component>
    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column"> 
      <div id="content">
     

        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div
            class="d-sm-flex align-items-center justify-content-between mb-4"
          >
            <!-- <h1 class="h3 mb-0 text-gray-800">{{this.pageTitle}}</h1> -->
            <h1 class="h3 mb-0 text-gray-800">{{" "}}</h1>
            <div class="form-group col-sm-6 col-lg-4" v-if="pageTitle=='Timetable Detail' || pageTitle=='Time Table' || pageTitle=='teacher-class-schedule'">
              <label for="selectSubject">View</label>
              <multiselect 
                v-model="selectedView"
                :options="views"
                :searchable="true"
                :close-on-select="false"
                :allow-empty="false"
                :preselect-first="true"
                label="name"
                placeholder="Select view"
                track-by="id"
                @input="setView"
              ></multiselect>
            </div>
            <!-- <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item">Pages</li>
              <li class="breadcrumb-item active" aria-current="page">
                Blank Page
              </li>
            </ol> -->
          </div>

          <div class="text-center">
            <router-view></router-view>
          </div>
        </div>
        <!---Container Fluid-->
      </div>
      <!-- Footer -->
      <!-- <footer-component></footer-component>  -->
      <!-- Footer -->
    </div>
  </div>

  <!-- Scroll to top -->
</template>

<script>
import Sidebar from "../../../molecules/admin/dashboard/Sidebar";
import Navbar from "../../../molecules/admin/dashboard/Navbar";
import Footer from "../../../molecules/admin/dashboard/Footer";
import { mapGetters , mapActions } from "vuex";

import "./admin.css";
export default {
  data: function () {
    return {
      views:[{id:0,name:"table"},{id:1,name:"calendar"}],
      selectedView:this.pageView,
      currentRouteName:''
    };
  },
  components: {
    "sidebar-component": Sidebar, 
    "navbar-component": Navbar,
    "footer-component": Footer,
  },
   watch: {
    pageView: function (newAddress, oldAddress) {
      this.selectedView = {
        ...this.selectedView,
        name:newAddress
      }
      // this.selectedView.name = newAddress;
    }
   },
  computed: {
    ...mapGetters({
      isFirstTime: "isFirstTime",
      pageTitle:"pageTitle",
      pageView:"pageView"
    }),
  },
  methods:{
    ...mapActions({
      setPageView:"setPageView"  
    }),
    setView(){
      let mode = this.selectedView.name;
        this.setPageView(mode);
      // if (this.$route.name=='timeTableDetail') {
      //   this.setPageView('timeTableDetail');
      //   this.setSession(this.$route.params.session_id);
      // }else{
      //   let mode = this.selectedView.name;
      //   this.setPageView(mode);
      // }
    }
  },
  mounted() {
    this.currentRouteName = this.$route.name;
  },
};
</script>
