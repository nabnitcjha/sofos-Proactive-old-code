<template>
<div class="student-wrapper">
        <div class="wrapper-content section-wrapper">
        <!-- <h5 class="title text-left"><span>Today</span> &nbsp; &nbsp;<span class="" style="font-size:16px; font-weight:500;">{{moment().format('ddd D MMM')}}</span></h5> -->
        <h5 class="title text-left mt-5" v-if="todayTimetable.length>0"><span>Today({{moment().format('ddd D MMM')}})</span> &nbsp; &nbsp;<span class="" style="font-size:16px; font-weight:500;"></span></h5>
        <div class="row">
          <div class="col-sm-4 pointer-hand" v-for="(todaySession,index) in todayTimetable" :key="index"
            @click.stop="
              checkPermission(['update']) == true
                ? $root.changeRoute('/session-detail/' + todaySession.id)
                : fakeClick
            "
          >
            <div class="session-card mt-4">
              <div class="teacher-info mt-3">
                <div class="teacher-img">
                <img class="img-fluid teacher-profile-img"
                 :src="user.user_image == 0 ? adminImage:$root.getMedia(user.user_image)"     
                 >
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
                  <div class="st-1 st-img"  v-for="(std,ind) in todaySession.students" :key="ind" v-if="ind<2">
                  <img class="img-fluid student-1.png" 
                  :src="std.student_image == null ? adminImage:$root.getMedia(std.student_image)" 
                  >
                </div>
                
                <div class="more-student">
                <a v-if="todaySession.students.length>2"><p class="" style="color: #589A42;"> &nbsp;+{{todaySession.students.length-2}} more... </p></a>
                </div>
                </div>
                <div class="link-meet-with mt-2">
                  <a><button class="button btn-meet-with">Meet with</button></a>
                </div>
                <div class="time-zone mt-2">
                <p>{{todaySession.time_am_pm}} <span>GMT</span></p>
              </div>
              </div>
            </div>
            <!-- end of session-card -->
          </div>
        </div>
        </div>

        <!-- upcoming class -->
        <div class="wrapper-content section-wrapper">
        <h5 class="title text-left mt-5" v-if="weeklyTimetable.length>0"><span>Upcoming Classes(next 7 days)</span> &nbsp; &nbsp;<span class="" style="font-size:16px; font-weight:500;"></span></h5>
        <div class="row">
          <div class="col-sm-4 pointer-hand" v-for="(weeklySession,index) in weeklyTimetable" :key="index"
           @click.stop="
              checkPermission(['update']) == true
                ?goDetail(weeklySession)
                : fakeClick
            "
          
          >
            <div class="session-card mt-4">
              <div class="teacher-info mt-3">
                <div class="teacher-img">
                <img class="img-fluid teacher-profile-img"
                 :src="user.user_image == 0 ? adminImage:$root.getMedia(user.user_image)"     
                 >
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
                   <div class="st-1 st-img"  v-for="(std,ind) in weeklySession.students" :key="ind"  v-if="ind<2">
                  <img class="img-fluid student-1.png" 
                  :src="std.student_image == null ? adminImage:$root.getMedia(std.student_image)" 
                  >
                </div>
               
                <div class="more-student">
                <a v-if="weeklySession.students.length>2"><p class="" style="color: #589A42;"> &nbsp;+{{weeklySession.students.length-2}} more... </p></a>
                </div>
                </div>
                <div class="link-meet-with mt-2">
                  <a href="#"><button class="button btn-meet-with">Meet with</button></a>
                </div>
                <div class="time-zone mt-2">
                <h5>{{getDay(weeklySession.start_date)}}</h5>
                <p>{{weeklySession.time_am_pm}} <span>GMT</span></p>
              </div>
              </div>
            </div>
            <!-- end of session-card -->
          </div>
        </div>
        </div>

        <!-- History class -->
        <div class="wrapper-content section-wrapper">
        <h5 class="title text-left mt-5" v-if="previousTimeTable.length>0"><span>Pervious Classes</span> &nbsp; &nbsp;<span class="" style="font-size:16px; font-weight:500;"></span></h5>
        <div class="row">
          <div class="col-sm-4 pointer-hand" v-for="(previousSession,index) in previousTimeTable" :key="index"
           @click.stop="
              checkPermission(['update']) == true
                ?goDetail(previousSession)
                : fakeClick
            "
          
          >
            <div class="session-card mt-4">
              <div class="teacher-info mt-3">
                <div class="teacher-img">
                <img class="img-fluid teacher-profile-img"
                 :src="user.user_image == 0 ? adminImage:$root.getMedia(user.user_image)"     
                 >
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
                   <div class="st-1 st-img"  v-for="(std,ind) in previousSession.students" :key="ind"  v-if="ind<2">
                  <img class="img-fluid student-1.png" 
                  :src="std.student_image == null ? adminImage:$root.getMedia(std.student_image)" 
                  >
                </div>
               
                <div class="more-student">
                <a v-if="previousSession.students.length>2"><p class="" style="color: #589A42;"> &nbsp;+{{previousSession.students.length-2}} more... </p></a>
                </div>
                </div>
                <div class="link-meet-with mt-2">
                  <a href="#"><button class="button btn-meet-with">Meet with</button></a>
                </div>
                <div class="time-zone mt-2">
                <h5>{{getDay(previousSession.start_date)}}</h5>
                <p>{{previousSession.time_am_pm}} <span>GMT</span></p>
              </div>
              </div>
            </div>
            <!-- end of session-card -->
          </div>
        </div>
        </div>
        <div class="no-record" v-if="todayTimetable.length == 0 ? weeklyTimetable.length==0?previousTimeTable.length==0?true:false:false:false">
            No session found
          </div>
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
import { mapGetters } from "vuex";
import formMixins from "../../../../Mixins/form";
import "./teacherClasses.css";
import { Student } from "../../../../Assets/dashboard/index";
import { SubIcon } from "../../../molecules/admin/dashboard/Icons/index";
import moment from "moment";
export default {
  data() {
    return {
      adminImage: Student,
      classes: [],
      subject: "",
      SubIcon: SubIcon,
      moment: moment,
      makeGray:false,
      todayTimetable:[],
      weeklyTimetable:[],
      previousTimeTable:[]
    };
  },
  computed: {
    ...mapGetters({
      user: "user",
      permissions: "permissions",
    }),
  },
  methods: {
    goDetail(weeklySession){
       this.$router.push('/session-detail/' + weeklySession.id); 
    },
    checkTodayClass(isToday,classEndTime){
      
      if (isToday=='yes') {
        let currentTime =  moment().format("HH:mm:ss a")
        if (currentTime<classEndTime) {
           this.makeGray = false;
        }else{
          this.makeGray = true;
        }
      }
    },
    getTeacherClassess() {  
      axios
        .get("/api/getTeacherClassess/" + this.user.teacher.id) 
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
    this.getTeacherClassess();
  },
  mixins: [formMixins],
};
</script>
