<template>
  <div class="student-wrapper">
    <vs-modal v-model="openMeetwith" class="modal-ac">
      <div slot="modal-header" class="modal-header">
        <span class="hp-3-title"><b style="color:green;">Sesseion Description :</b> {{event_message}} </span>
        <v-icon @click.stop="modalClose"> mdi-close-circle</v-icon>
      </div>

      <div slot="modal-footer" class="modal-footer">
        <button type="button" class="btn btn-success" @click.stop="goToDetailPage">
          Yes
        </button>
        <button type="button" class="btn btn-danger" @click.stop="modalClose">
          No
        </button>
      </div>
    </vs-modal>
    <div class="col-12 make-right">
        <button type="button" class="btn btn-orange ml-2" @click="goBack">
          Back
        </button>

      </div>
      <b-overlay
        id="overlay-background"
        :show="show"
        :variant="variant"
        :opacity="opacity"
        :blur="blur"
        rounded="sm"
      >
    <div class="wrapper-content section-wrapper">
      <h5 class="title text-left" v-if="todayTimetable.length>0"><span>Today</span> &nbsp; &nbsp;<span class=""
          style="font-size:16px; font-weight:500;">{{moment().format('ddd D MMM')}}</span></h5>
      <div class="row">
        <!-- @click.stop="
              checkPermission(['update']) == true
                ? $root.changeRoute('/session-detail/' + todaySession.id)
                : fakeClick
            " -->
        <div class="col-sm-4" v-for="(todaySession,index) in todayTimetable" :key="index">
          <div class="session-card mt-4">
            <div class="teacher-info mt-3">
              <div class="teacher-img">
                <img class="img-fluid teacher-profile-img"
                  :src="user.user_image == 0 ? adminImage:$root.getMedia(user.user_image)">
              </div>
              <article class="teacher-content">
                <p>Session number: {{todaySession.id}}</p>
                <p>{{todaySession.teacherName}}</p>
                <p>{{todaySession.subjectName}}</p>
              </article>
            </div>
            <div class="General-info">
              <h3 class="">{{todaySession.topic}}</h3>
              <div class="student-imgs mt-3">
                <div class="st-1 st-img" v-for="(std,ind) in todaySession.students" :key="ind" v-if="ind<2">
                  <img class="img-fluid student-1.png"
                    :src="std.student_image == null ? adminImage:$root.getMedia(std.student_image)">
                </div>

                <div class="more-student">
                  <a v-if="todaySession.students.length>2">
                    <p class="" style="color: #589A42;"> &nbsp;+{{todaySession.students.length-2}} more... </p>
                  </a>
                </div>
              </div>
              <div class="link-meet-with mt-2" @click.stop="openDetailModel(todaySession)">
                <a><button class="button btn-meet-with pointer-hand">Meet with</button></a>
              </div>
              <div class="time-zone">
                <p>Time</p>
                <p>{{todaySession.time_am_pm}} <span>GMT</span></p>
              </div>
            </div>
          </div>
          <!-- end of session-card -->
        </div>

      </div>
      <v-pagination v-if="todayPaginationTotal > 1" v-model="todayPaginationCurrent" :page-count="todayPaginationTotal"
        @input="nextPage('today')" :classes="bootstrapPaginationClasses"></v-pagination>
    </div>

    <!-- upcoming class -->
    <div class="wrapper-content section-wrapper">
      <h5 class="title text-left mt-5" v-if="weeklyTimetable.length>0"><span>Upcoming Class(next 7 days)</span> &nbsp;
        &nbsp;<span class="" style="font-size:16px; font-weight:500;"></span></h5>
      <div class="row">
        <div class="col-sm-4" v-for="(weeklySession,index) in weeklyTimetable" :key="index">
          <div class="session-card mt-4">
            <div class="teacher-info mt-3">
              <div class="teacher-img">
                <img class="img-fluid teacher-profile-img"
                  :src="user.user_image == 0 ? adminImage:$root.getMedia(user.user_image)">
              </div>
              <article class="teacher-content">
                <p>Session number: {{weeklySession.id}}</p>
                <p>{{weeklySession.teacherName}}</p>
                <p>{{weeklySession.subjectName}}</p>
              </article>
            </div>
            <div class="General-info">
              <h3 class="">{{weeklySession.topic}}</h3>
              <div class="student-imgs mt-3">
                <div class="st-1 st-img" v-for="(std,ind) in weeklySession.students" :key="ind" v-if="ind<2">
                  <img class="img-fluid student-1.png"
                    :src="std.student_image == null ? adminImage:$root.getMedia(std.student_image)">
                </div>

                <div class="more-student">
                  <a v-if="weeklySession.students.length>2">
                    <p class="" style="color: #589A42;"> &nbsp;+{{weeklySession.students.length-2}} more... </p>
                  </a>
                </div>
              </div>
              <div class="link-meet-with mt-2" @click.stop="openDetailModel(weeklySession)">
                <a><button class="button btn-meet-with pointer-hand">Meet with</button></a>
              </div>
              <div class="time-zone">
                <p>Time</p>
                <p>{{weeklySession.time_am_pm}} <span>GMT</span></p>
              </div>
            </div>
          </div>
          <!-- end of session-card -->
        </div>

      </div>
      <v-pagination v-if="weeklyPaginationTotal > 1" v-model="weeklyPaginationCurrent"
        :page-count="weeklyPaginationTotal" @input="nextPage('weekly')" :classes="bootstrapPaginationClasses">
      </v-pagination>
    </div>

    <!-- history class -->

    <div class="wrapper-content section-wrapper">
      <h5 class="title history-title text-left mt-5" v-if="previousTimeTable.length>0"><span>Previous Class</span>
        &nbsp; &nbsp;<span class="" style="font-size:16px; font-weight:500;"></span></h5>
      <div class="row">
        <div class="col-sm-4" v-for="(previousSession,index) in previousTimeTable" :key="index">
          <div class="session-card mt-4">
            <div class="teacher-info mt-3">
              <div class="teacher-img">
                <img class="img-fluid teacher-profile-img"
                  :src="user.user_image == 0 ? adminImage:$root.getMedia(user.user_image)">
              </div>
              <article class="teacher-content">
                <p>Session number: {{previousSession.id}}</p>
                <p>{{previousSession.teacherName}}</p>
                <p>{{previousSession.subjectName}}</p>
              </article>
            </div>
            <div class="General-info">
              <h3 class="">{{previousSession.topic}}</h3>
              <div class="student-imgs mt-3">
                <div class="st-1 st-img" v-for="(std,ind) in previousSession.students" :key="ind" v-if="ind<2">
                  <img class="img-fluid student-1.png"
                    :src="std.student_image == null ? adminImage:$root.getMedia(std.student_image)">
                </div>

                <div class="more-student">
                  <a v-if="previousSession.students.length>2">
                    <p class="" style="color: #589A42;"> &nbsp;+{{previousSession.students.length-2}} more... </p>
                  </a>
                </div>
              </div>
              <div class="link-meet-with mt-2" @click.stop="openDetailModel(previousSession)">
                <a><button class="button btn-meet-with pointer-hand">Meet with</button></a>
              </div>
              <div class="time-zone">
                <p>Time</p>
                <p>{{previousSession.time_am_pm}} <span>GMT</span></p>
              </div>
            </div>
          </div>
          <!-- end of session-card -->
        </div>

      </div>
      <v-pagination v-if="previousPaginationTotal > 1" v-model="previousPaginationCurrent"
        :page-count="previousPaginationTotal" @input="nextPage('previous')" :classes="bootstrapPaginationClasses">
      </v-pagination>
    </div>
    <div class="no-record"
      v-if="todayTimetable.length == 0 ? weeklyTimetable.length==0?previousTimeTable.length==0?true:false:false:false">
      No session found
    </div>


</b-overlay>
    <!-- end of main bodywrapper -->
  </div>
  <!-- <div class="teacherclass-area col-12">
    
    <div
      class="teacher-class mb-5"
      v-for="(cls, index) in classes"
      :key="index"
      @click.stop="
        checkPermission(['update']) == true
          ? $root.changeRoute('/session-detail/' + cls.id)
          : fakeClick
      "
    >
      <img :src="SubIcon" alt="" />
      <h1 class="mb-4">{{ cls.subjectName }}</h1>
      <h5>{{ cls.topic }}</h5>
      <h6 style="font-size: 15px; font-weight: 400">
        {{ moment(cls.start_date).format("DD-MMMM") }}
      </h6>
      <h6>{{checkTodayClass(cls.isToday,cls.classEndTime)}}</h6>
      <h6>{{makeGray==true?'allow gray':'not allow gray'}}</h6>
    </div>
  </div> -->
</template>

<script>
import vPagination from "vue-plain-pagination";
import { mapGetters } from "vuex";
import formMixins from "../../../../Mixins/form";
import "./teacherClasses.css";
import { Student } from "../../../../Assets/dashboard/index";
import { SubIcon } from "../../../molecules/admin/dashboard/Icons/index";
import moment from "moment";
export default {
  data() {
    return {
      event_message:'',
      show:false,
      todaySessionId: "",
      openMeetwith: false,
      adminImage: Student,
      classes: [],
      subject: "",
      SubIcon: SubIcon,
      moment: moment,
      makeGray: false,
      todayTimetable: [],
      weeklyTimetable: [],
      previousTimeTable: [],

      todayPaginationCurrent: '',
      todayPaginationTotal: '',

      weeklyPaginationCurrent: '',
      weeklyPaginationTotal: '',

      previousPaginationCurrent: '',
      previousPaginationTotal: '',

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
    };
  },
  computed: {
    ...mapGetters({
      user: "user",
      permissions: "permissions",
      pageView: "pageView"
    }),
  },
  components: {
    vPagination
  },
  methods: {
    goToDetailPage() {
      if (this.checkPermission(['update']) == true) {
        this.$root.changeRoute('/session-detail/' + this.todaySessionId)
      }
      this.openMeetwith = false;
    },
    openDetailModel(session) {
      this.todaySessionId = session.id;
      this.event_message = session.event_message;
      this.openMeetwith = true;
    },
    modalClose() {
      this.openMeetwith = false;
    },
    checkTodayClass(isToday, classEndTime) {

      if (isToday == 'yes') {
        let currentTime = moment().format("HH:mm:ss a")
        if (currentTime < classEndTime) {
          this.makeGray = false;
        } else {
          this.makeGray = true;
        }
      }
    },
    nextPage(type) {
      if (type == 'today') {
        this.getTodayClassess();
      } else if (type == 'weekly') {
        this.getWeeklyClassess();
      } else {
        this.getPreviousClassess();
      }
    },
    // getTeacherAndStudentClassess() {
    //   // this.show=true;
    //   let formData = {};
    //   if (this.$route.name == 'studentSessionDetail') {
    //     formData['mode'] = 'student';
    //     formData['student_id'] = this.$route.params.student_id;
    //   }
    //   if (this.$route.name == 'teacherSessionDetail') {
    //     formData['mode'] = 'teacher';
    //     formData['teacher_id'] = this.$route.params.teacher_id;
    //   }
    //   axios
    //     .post("/api/getTodayClassess" + "?page=" + this.todayPaginationCurrent, formData)
    //     .then((response) => {
    //       // today
    //       // this.todayPaginationCurrent = response.data.todayTimetable.current_page;
    //       // this.todayPaginationTotal = response.data.todayTimetable.last_page;
    //       this.todayTimetable = response.data.todayTimetable.data;

    //       // weekly
    //       // this.weeklyPaginationCurrent = response.data.weeklyTimetable.current_page;
    //       // this.weeklyPaginationTotal = response.data.weeklyTimetable.last_page;
    //       this.weeklyTimetable = response.data.weeklyTimetable.data;

    //       // previous
    //       // this.previousPaginationCurrent = response.data.previousTimeTable.current_page;
    //       // this.previousPaginationTotal = response.data.previousTimeTable.last_page;
    //       this.previousTimeTable = response.data.previousTimeTable.data;

    //       this.show=false;
    //     });
    // },
    getTodayClassess() {

      let formData = {};
      if (this.$route.name == 'studentSessionDetail') {
        formData['mode'] = 'student';
        formData['student_id'] = this.$route.params.student_id;
      }
      if (this.$route.name == 'teacherSessionDetail') {
        formData['mode'] = 'teacher';
        formData['teacher_id'] = this.$route.params.teacher_id;
      }

      axios
        .post("/api/getTodayClassess" + "?page=" + this.todayPaginationCurrent, formData)
        .then((response) => {

          this.todayPaginationCurrent = response.data.todayTimetable.current_page;
          this.todayPaginationTotal = response.data.todayTimetable.last_page;
          this.todayTimetable = response.data.todayTimetable.data;
        });
    },
    getWeeklyClassess() {

      let formData = {};
      if (this.$route.name == 'studentSessionDetail') {
        formData['mode'] = 'student';
        formData['student_id'] = this.$route.params.student_id;
      }
      if (this.$route.name == 'teacherSessionDetail') {
        formData['mode'] = 'teacher';
        formData['teacher_id'] = this.$route.params.teacher_id;
      }

      axios
        .post("/api/getWeeklyClassess" + "?page=" + this.weeklyPaginationCurrent, formData)
        .then((response) => {

          this.weeklyPaginationCurrent = response.data.weeklyTimetable.current_page;
          this.weeklyPaginationTotal = response.data.weeklyTimetable.last_page;
          this.weeklyTimetable = response.data.weeklyTimetable.data;
        });
    },
    getPreviousClassess() {

      let formData = {};
      if (this.$route.name == 'studentSessionDetail') {
        formData['mode'] = 'student';
        formData['student_id'] = this.$route.params.student_id;
      }
      if (this.$route.name == 'teacherSessionDetail') {
        formData['mode'] = 'teacher';
        formData['teacher_id'] = this.$route.params.teacher_id;
      }

      axios
        .post("/api/getPreviousClassess" + "?page=" + this.previousPaginationCurrent, formData)
        .then((response) => {

          this.previousPaginationCurrent = response.data.previousTimeTable.current_page;
          this.previousPaginationTotal = response.data.previousTimeTable.last_page;
          this.previousTimeTable = response.data.previousTimeTable.data;
        });
    },
    getTeacherClassess() {

      axios
        .post("/api/getAllClassess")
        .then((response) => {
          this.todayTimetable = response.data.todayTimetable;
          this.weeklyTimetable = response.data.weeklyTimetable;
          this.previousTimeTable = response.data.previousTimeTable;
          // this.classes = response.data.result;
        });
    },
    checkPermission(arr) {
      let boolValue = this.permissions.some((permission) => {
        return arr.includes(permission);
      });

      return boolValue;
    },
  },
  mounted() {
      this.getTodayClassess();
      this.getWeeklyClassess();
      this.getPreviousClassess();
    // this.getTeacherAndStudentClassess();
    // let x = this.$route;
    // if (this.$route.name == 'studentDetail' || this.$route.name == 'teacherDetail') {
    //   this.getTeacherAndStudentClassess();
    // } else {
    //   this.getTodayClassess();
    //   this.getWeeklyClassess();
    //   this.getPreviousClassess();
    // }
    // this.getTeacherClassess();

  },
  mixins: [formMixins],
};
</script>
