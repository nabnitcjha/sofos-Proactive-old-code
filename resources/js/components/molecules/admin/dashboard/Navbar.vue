<template>
  <nav
    class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top"
  >
    <button
      id="sidebarToggleTop"
      class="btn btn-link rounded-circle mr-3 burger-menu"
      @click.stop="$root.toggleClassRemoveOrAdd"
    >
      <i class="fa fa-bars"></i> 
    </button>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <div class="p-3 animated--grow-in">
          
          <!-- <form class="navbar-search">
            <div class="input-group">
              <input
                type="text"
                class="form-control bg-light border-1 small nav-search"
                placeholder="search"
                aria-label="Search"
                aria-describedby="basic-addon2"
                style="border-color: #3f51b5"
              />
            </div>
          </form> -->
        </div>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown no-arrow mx-1">
        <a
          class="nav-link dropdown-toggle"
        >
          <i class="fas fa-bell fa-fw"></i>
          <span class="badge badge-danger badge-counter">{{user.name}}</span>
        </a>
        
      </li>
      <li class="nav-item dropdown no-arrow mx-1">
        <a
          class="nav-link dropdown-toggle"
        >
          <i class="fas fa-envelope fa-fw"></i>
          <span class="badge badge-warning badge-counter">{{user.roleNames[0]}}</span>
        </a>
         
      </li>

      <li class="nav-item dropdown no-arrow">
        <a
          class="nav-link dropdown-toggle"
          href="#"
          id="userDropdown"
          role="button"
          data-toggle="dropdown"
          aria-haspopup="true"
          aria-expanded="false"
        >
          <img
            class="img-profile rounded-circle"
            :src="
              user.user_image == 0 ? Student : $root.getMedia(user.user_image)
            "
            style="max-width: 60px"
          />
          <!-- <span class="ml-2 d-none d-lg-inline text-white small">Maman Ketoprak</span> -->
        </a>
        <div
          class="dropdown-menu header-dd dropdown-menu-right shadow animated--grow-in"
          aria-labelledby="userDropdown"
        >
          <a
            class="dropdown-item"
            @click="
              menuClick(
                'userProfile',
                (mode = 'Profile Setting')
              )
            "
          >
            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
            Profile
          </a>
          <a
            class="dropdown-item"
            @click="
              menuClick(
                $root.changeRoute('/role-permission'),
                (mode = 'Role Permission')
              )
            "
            v-if="user.roleNames[0]=='admin'"
          >
            <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
            Settings
          </a>
          <!-- <a class="dropdown-item" >
            <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
            Activity Log
          </a> -->
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" @click.stop="logout">
            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
            Logout
          </a>
        </div>
      </li>
    </ul>
  </nav>
  <!-- <div class="navbar__page fixed">
        <nav
            class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top"
        >
            <ul class="navbar-nav ml-auto">
                <div class="topbar-divider d-none d-sm-block"></div>
                <li class="nav-item dropdown no-arrow">
                    <a
                        class="nav-link dropdown-toggle"
                        href="#"
                        id="userDropdown"
                        role="button"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                    >
                        <img
                            class="img-profile rounded-circle"
                            :src="user.user_image == 0 ? Student:$root.getMedia(user.user_image)"
                            style=""
                        />
                        <span
                            class="ml-2 d-none d-lg-inline text-white small user-name"
                            >{{user.name}}</span
                        >
                    </a>
                    <div
                        class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                        aria-labelledby="userDropdown"
                    >
                        <a class="dropdown-item" href="#">
                            <i
                                class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"
                            ></i>
                            Profile
                        </a>
                        <a class="dropdown-item" href="#">
                            <i
                                class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"
                            ></i>
                            Settings
                        </a>
                        <a class="dropdown-item" href="#">
                            <i
                                class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"
                            ></i>
                            Activity Log
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="login.html">
                            <i
                                class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"
                            ></i>
                            Logout
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
    </div> -->
</template>

<script>
import { Student } from "../../../../Assets/dashboard/index";
import { mapActions, mapGetters } from "vuex";
import "./style.css";
export default {
  data: function () {
    return {
      Student: Student,
      loginStatus: "",
      clickedMode: "",
    };
  },
  computed: {
    ...mapGetters({
      isAuthenticated: "isAuthenticated",
      isFirstTime: "isFirstTime",
      user: "user",
    }),
  },
  methods: {
    ...mapActions({
      firstTimeValue: "firstTimeValue",
      setAuthenticationFalse: "setAuthenticationFalse",
      setPageTitle: "setPageTitle",
    }),
    logout() {
      axios.defaults.headers.common["Authorization"] =
        "Bearer " + localStorage.getItem("token");
      localStorage.removeItem("token");
      axios.post("/api/logout").then((response) => {
        let formData = {};
        formData["makeTrue"] = false;
        this.firstTimeValue(formData);
        this.setAuthenticationFalse();

        this.$router.push("/");
      });
    },
    menuClick(routeURL, mode) {
      if (this.clickedMode === mode) {
        return;
      }
      if (mode) {
        this.setPageTitle(mode);
      }
      if (routeURL=='userProfile') {
        //$root.changeRoute('/admin-profile')
        if (this.user.roleNames[0]=='admin') {
          this.$router.push("/admin-profile")
        }else if(this.user.roleNames[0]=='teacher'){
            this.$router.push("/teacher-profile")
        }else if(this.user.roleNames[0]=='student'){
            this.$router.push("/student-profile")
        }else{
            this.$router.push("/parent-profile")
        }
      }
      this.clickedMode = mode;
    },
  },
  mounted() {
    // if (localStorage.getItem("token") == null) {
    //     this.loginStatus = "not-login";
    // } else {
    //     this.loginStatus = "login";
    // }
  },
};
</script>
