<template>
  <div class="row mb-3 add-student">
    <!-- Admin and Teacher -->
    <div
      class="col-xl-3 col-md-6 mb-4"
      v-if="user.roleNames[0] == 'teacher' || user.roleNames[0] == 'admin'"
    >
      <div class="card h-100">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col mr-2">
              <div
                class="
                  h5
                  mb-0
                  font-weight-bold
                  text-gray-800 text-justify
                  bg-font
                "
              >
                {{ totalStudent }}
              </div>
              <div class="mt-2 mb-0 text-muted text-xs text-justify md-font">
                <span>Students</span>
              </div>
            </div>
            <div class="col-auto">
              <img :src="Group1" class="dashboard-icon-size" />
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Admin and Student -->
    <div
      class="col-xl-3 col-md-6 mb-4"
      v-if="user.roleNames[0] == 'student' || user.roleNames[0] == 'admin'"
    >
      <div class="card h-100">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <!-- <div class="text-xs font-weight-bold text-uppercase mb-1">
                      Sales
                    </div> -->
              <div
                class="
                  h5
                  mb-0
                  font-weight-bold
                  text-gray-800 text-justify
                  bg-font
                "
              >
                {{ totalTeacher }}
              </div>
              <div class="mt-2 mb-0 text-muted text-xs text-justify md-font">
                <span>Teachers</span>
              </div>
            </div>
            <div class="col-auto">
              <img :src="Group" class="dashboard-icon-size" />
              <!-- <i class="fas fa-shopping-cart fa-2x text-success"></i> -->
            </div>
          </div>
        </div>
      </div>
    </div>

        <!-- Only Parent -->
    <div
      class="col-xl-3 col-md-12 mb-4"
      v-if="user.roleNames[0] == 'parent'"
    >
      <div class="card h-100">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col mr-2">
              <div
                class="
                  h5
                  mb-0
                  font-weight-bold
                  text-gray-800 text-justify
                  bg-font
                "
              >
                {{ totalStudent }}
              </div>
              <div class="mt-2 mb-0 text-muted text-xs text-justify md-font">
                <span>Students</span>
              </div>
            </div>
            <div class="col-auto">
              <img :src="Group1" class="dashboard-icon-size" />
            </div>
          </div>
        </div>
      </div>
    </div>
            <!-- Only Parent -->
    <div
      class="col-xl-3 col-md-12 mb-4"
      v-if="user.roleNames[0] == 'parent'"
    >
       <div class="card h-100">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <!-- <div class="text-xs font-weight-bold text-uppercase mb-1">
                      Sales
                    </div> -->
              <div
                class="
                  h5
                  mb-0
                  font-weight-bold
                  text-gray-800 text-justify
                  bg-font
                "
              >
                {{ totalTeacher }}
              </div>
              <div class="mt-2 mb-0 text-muted text-xs text-justify md-font">
                <span>Teachers</span>
              </div>
            </div>
            <div class="col-auto">
              <img :src="Group" class="dashboard-icon-size" />
              <!-- <i class="fas fa-shopping-cart fa-2x text-success"></i> -->
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- All User -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card h-100">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <!-- <div class="text-xs font-weight-bold text-uppercase mb-1">
                      New User
                    </div> -->
              <div
                class="
                  h5
                  mb-0
                  mr-3
                  font-weight-bold
                  text-gray-800 text-justify
                  bg-font
                "
              >
                {{ totalClass }}
              </div>
              <div class="mt-2 mb-0 text-muted text-xs text-justify md-font">
                <span>Classes</span>
              </div>
            </div>
            <div class="col-auto">
              <img :src="Group2" class="dashboard-icon-size" />
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Pending Requests Card Example -->
   

    <!-- Area Chart -->
    <div class="col-xl-7 col-lg-7">
      <div class="card mb-4">
        <div
          class="
            card-header
            py-3
            d-flex
            flex-row
            align-items-center
            justify-content-between
          "
        >
          <h6 class="m-0 font-weight-bold text-primary">Student Attendance</h6>
        </div>
        <div class="card-body">
          <div class="chart-area">
            <!-- <canvas id="myAreaChart"></canvas> -->
            <apexchart
              width="500"
              type="bar"
              :options="chartOptions1"
              :series="series1"
            ></apexchart>
          </div>
          <div id="chart">
            <!-- <apexchart
              type="bar"
              height="350"
              :options="chartOptions1"
              :series="series1"
            ></apexchart> -->
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-5 col-lg-5" v-if="user.roleNames[0] == 'admin'">
      <div class="card mb-4">
        <div
          class="
            card-header
            py-3
            d-flex
            flex-row
            align-items-center
            justify-content-between
          "
        >
          <h6 class="m-0 font-weight-bold text-primary">Newly Added Student</h6>
        </div>
        <div class="card-body nw-std-style">
          <div
            class="task"
            v-for="(std, index) in newlyAddedStudent"
            :key="index"
          >
            <div class="task-flex">
              <div class="task-time">
                <img
                  class=""
                  :src="
                    std.student_image == null
                      ? studentImage
                      : $root.getMedia(std.student_image)
                  "
                />
              </div>
              <div class="task-content m-4">
                <p>{{ std.first_name }}{{ " " }}{{ std.last_name }}</p>
              </div>
            </div>
          </div>
        </div>
         
      </div>
      <v-pagination
              v-if="paginationTotal > 1"
              v-model="paginationCurrent"
              :page-count="paginationTotal"
              @input="nextPage"
              :classes="bootstrapPaginationClasses"
            ></v-pagination>
    </div>
    <div class="col-xl-5 col-lg-5" v-else>
      <div class="card mb-4">
        <div
          class="
            card-header
            py-3
            d-flex
            flex-row
            align-items-center
            justify-content-between
          "
        >
          <h6 class="m-0 font-weight-bold text-primary">Today's Class</h6>
        </div>
        <div class="card-body" v-if="todayClass.length > 0">
          <div class="task" v-for="(cls, index) in todayClass" :key="index">
            <div class="task-flex">
              <div class="task-time">
                {{ cls.time_am_pm.slice(0, 2)
                }}{{ cls.time_am_pm.slice(9, 11) }}
              </div>
              <div class="task-content m-4">
                <p>{{ cls.topic }}</p>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body" v-else>
          <div class="no-record" v-if="todayClass.length == 0">
            No record found
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import vPagination from "vue-plain-pagination";
import { Student } from "../../../../Assets/dashboard/index";
import { mapActions, mapGetters } from "vuex";
import {
  Group,
  Group1,
  Group2,
  Group3,
  Group4,
  Vector,
  Vector1,
  Subject,
  Timetable,
} from "./Icons/index";
import formMixins from "../../../../Mixins/form";
import "./dashboard.css";
export default {
  data() {
    return {
      bootstrapPaginationClasses: {
        ul: "custom-pagination",
        li: "page-item",
        liActive: "active",
        liDisable: "disabled",
        button: "page-link",
      },
      paginationAnchorTexts: {
        first: "First",
        prev: "Previous",
        next: "Next",
        last: "Last",
      },
      paginationCurrent: "",
      paginationTotal: "",
      pagetype:"",
      options: {
        chart: {
          id: "vuechart-example",
        },
        xaxis: {
          categories: [1991, 1992, 1993, 1994, 1995, 1996, 1997, 1998],
        },
      },
      series: [
        {
          name: "series-1",
          data: [30, 40, 45, 50, 49, 60, 70, 91],
        },
      ],

      series1: [
        {
          name: "Items",
          data: [44, 55, 57, 56, 61, 58, 63, 60, 66],
        },
      ],
      chartOptions1: {
        chart: {
          type: "bar",
          height: 350,
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: "55%",
            endingShape: "rounded",
          },
        },
        dataLabels: {
          enabled: false,
        },
        stroke: {
          show: true,
          width: 2,
          colors: ["transparent"],
        },
        xaxis: {
          categories: [
            "Feb",
            "Mar",
            "Apr",
            "May",
            "Jun",
            "Jul",
            "Aug",
            "Sep",
            "Oct",
          ],
        },
        yaxis: {
          title: {
            text: "Student present this month",
          },
        },
        fill: {
          opacity: 1,
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return val;
            },
          },
        },
      },
 chartOptions: {
                    chart: {
                        type: 'bar',
                        height: 350
                    },
                    plotOptions: {
                        bar: {
                            borderRadius: 4,
                            horizontal: true,
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    xaxis: {
                        categories: ['Total Subscribers', 'Total Programs', 'Total Revenue', 'Total Organization', 'Active Users', 'Non Active Users','Account Access', 'Total Items Added'
                        ],
                    }
                },
      studentImage: Student,
      dashboardData: "",
      Group: Group,
      Group1: Group1,
      Group2: Group2,
      Group3: Group3,
      Group4: Group4,
      Vector: Vector,
      Vector1: Vector1,
      Subject: Subject,
      Timetable: Timetable,
      totalClass: "",
      totalStudent: "",
      totalTeacher: "",
      newlyAddedStudent: [],
      todayClass: [],
    };
  },
    components: {
    vPagination
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

     nextPage() {
      this.tableData = [];
      this.getData(this.paginationCurrent);
    },

    getData(currentPage) {
      
      let formData = {};
      if (this.user.roleNames[0] == "teacher") {
        formData["teacher_id"] = this.user.teacher.id;
        formData["mode"] = "teacher";
      } else if (this.user.roleNames[0] == "student") {
        formData["student_id"] = this.user.student.id;
        formData["mode"] = "student";
      } else if (this.user.roleNames[0] == "parent") {
        formData["parent_id"] = this.user.parent.id;
        formData["mode"] = "parent";
      } else {
        formData["mode"] = "admin";
      }
      
      axios.post("/api/getDashboard"+"?page="+currentPage, formData).then((response) => {
        this.totalClass = response.data.totalClass;
        this.totalStudent = response.data.totalStudent;
        this.totalTeacher = response.data.totalTeacher;
        if (this.user.roleNames[0] == "admin") {
          this.newlyAddedStudent = response.data.newlyAddedStudent;
          // this.paginationCurrent = response.data.newlyAddedStudent.current_page;
          // this.paginationTotal = response.data.newlyAddedStudent.last_page;
        } else {
          this.todayClass = response.data.todayClass;
        }
        
      });
    },
  },
  mounted() {
    this.getData(1);
  },

  mixins: [formMixins],
};
</script>
