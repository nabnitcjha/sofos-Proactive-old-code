<template>
    <div class="row card-common-design">
      <div class="col-lg-12 detail-card">
        <calendar-slot-add-component></calendar-slot-add-component>
      </div>
    </div>
  </template>
  <script>
  import moment from 'moment';
  import { mapActions, mapGetters } from "vuex";
  import formMixins from "../../../Mixins/form";
  import formTitle from "../common/formTitle";
  import "./timetable.css";
  export default {
    data() {
      return {
        currentTeacherId: "",
        currentTeacherIdBackup:"",
        editSessionId:"",
        repeatDays: [],
        sessionRepeat: 1,
        weekDays: [
          { id: 0, name: "Sun" },
          { id: 1, name: "Mon" },
          { id: 2, name: "Tue" },
          { id: 3, name: "Wed" },
          { id: 4, name: "Thu" },
          { id: 5, name: "Fri" },
          { id: 6, name: "Sat" },
        ],
        loading: true,
        bootstrapPaginationClasses: {
          ul: "custom-pagination",
          li: "page-item",
          liActive: "active",
          liDisable: "disabled",
          button: "page-link",
        },
  
        topic: "",
        subjects: [],
        event_message:'',
        students: [],
        selectedSubject: [],
        grades: [],
        selectedGrade: [],
        teachers: [],
        slotTimes: [],
        selectedTeacher: [],
        selectedStudent: [],
        classStartDate:'',
        classStartDateBackUP:'',
        classEndDate:'',
        classStartTime: '',
        classEndTime: '',
        repeatLastDate: new Date(),
        disabledDates: {
          to: new Date(Date.now() - 8640000),
        },
        isEditPageLoadFirstTime: true,
      };
    },
    props: {
      titleInfo: Object,
    },
    computed: {
      ...mapGetters({
        pageView: "pageView",
        pageTitle:"pageTitle"
      }),
    },
    components: {
      "form-title": formTitle,
    },
    methods: {
         removeStudent(studentId) {
        let arr = [...this.selectedStudent];
        let x = this.selectedStudent;
        arr = arr.filter(function (item) {
          return item.id !== studentId;
        });
        this.selectedStudent = arr;
      },
        ...mapActions({
        setPageTitle: "setPageTitle",
      }),
      selectStudent(event, day,d,i) {
        console.log('d',d);
        console.log('i',i);
        if (event.target.checked) {
          let days = [...this.repeatDays];
          console.log('days',days)
          days.push(day);
          this.repeatDays = days;
        } else {
          let days = [...this.repeatDays];
          let items = days.filter((dayName) => dayName !== day);
          this.repeatDays = items;
        }
      },
      disabledBeforeToday(date) {
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        return date < today;
      },
      async updateTimeTable(e) {
        var startDate = new Date();
        var endDate = new Date();
        e.preventDefault();
        this.addTimeTableRecord(e);
        // this.classTime.map((data, index) => {
        //   if (index == 0) {
        //     startDate = this.dateFormater(data);
        //   } else {
        //     endDate = this.dateFormater(data);
        //   }
        // });
  
        // let time_am_pm = await this.single_dateFormater_AM_PM(this.classTime);
  
        // let formData = {};
    
        // formData["subject_id"] = this.selectedSubject.id;
        // formData["teacher_id"] = this.selectedTeacher[0].id;
        // formData["studentIds"] = this.selectedStudent;
        // formData["topic"] = this.topic;
        // formData["start_date"] = startDate;
        // formData["end_date"] = endDate;
        // formData["time_am_pm"] = time_am_pm;
        // formData["event_message"] = this.event_message;
        // this.updateRecord(
        //   "timeTable",
        //   formData,
        //   this.$route.params.id,
        //   "/class-schedule"
        // );
      },
      cancelTimeTableRecord(){
        this.repeatDays=[];
        this.event_message="";
        this.sessionRepeat = 1;
        this.classStartDate="";
        this.classStartTime="";
        this.classEndTime="";
        this.topic="";
        this.subjects=[];
        this.students=[];
        this.selectedSubject=[];
        this.grades=[];
        this.selectedGrade=[];
        this.teachers=[];
        this.slotTimes=[];
        this.selectedTeacher=[];
        this.selectedStudent=[];
      },
      async addTimeTableRecord(e) {
        
        let slotTimes = [...this.slotTimes];
        this.classStartDateBackUP = new Date(this.classStartDate);
        let repeatDays = this.sessionRepeat * 7;
        var startDate = new Date();
        var endDate = new Date();
        var startTime = new Date();
        var endTime = new Date();
        e.preventDefault();
        
        startDate = this.dateFormater(this.classStartDate); 
        
        endDate = this.dateFormater(this.classStartDate);
     
        this.repeatLastDate.setDate(this.classStartDate.getDate() + repeatDays);
  
        let time_am_pm =
          (await this.single_dateFormater_AM_PM(this.classStartTime)) +
          " - " +
          (await this.single_dateFormater_AM_PM(this.classEndTime));
        startTime=this.single_dateFormater(this.classStartTime);
        endTime = this.single_dateFormater(this.classEndTime);
        
        startDate = this.timeAndDate(startDate,moment(startTime).format('HH:mm:ss'));
        endDate = this.timeAndDate(endDate,moment(endTime).format('HH:mm:ss'));
  
   
  
        
        slotTimes.push({
          startDate:startDate,
          endDate:endDate,
          startTime:startTime ,
          endTime:endTime ,
          time_am_pm: time_am_pm,
        });
        
        let strtDate = this.classStartDate.setDate(
          this.classStartDate.getDate() + 1
        );
        this.classStartDate = new Date(strtDate);
  
    
        this.classEndDate = new Date(strtDate);
        
    
        while (this.classStartDate <= this.repeatLastDate) {
          
          let day = this.classStartDate.getDay();
     
          if (this.repeatDays.indexOf(day) !== -1) {
            let startDate = this.dateFormater(this.classStartDate);
            let start_time_am_pm = await this.single_dateFormater_AM_PM(
              this.classStartTime
            );
          
            let endDate = this.dateFormater(this.classEndDate);
            let end_time_am_pm = await this.single_dateFormater_AM_PM(
              this.classEndTime
            );
  
            let time_am_pm = start_time_am_pm + " - " + end_time_am_pm;
            
            startDate = this.timeAndDate(startDate,moment(startTime).format('HH:mm:ss'));
            endDate = this.timeAndDate(endDate,moment(endTime).format('HH:mm:ss'));
            
   
            
            slotTimes.push({
              startDate:startDate,
              endDate:endDate,
              startTime:startTime ,
              endTime:endTime ,
              time_am_pm: time_am_pm,
            });
          }
          
          let stDate = this.classStartDate.setDate(
            this.classStartDate.getDate() + 1
          );
          let eDate = this.classEndDate.setDate(this.classEndDate.getDate() + 1);
          this.classStartDate = new Date(stDate);
          this.classEndDate = new Date(eDate);
        }
        
        this.slotTimes = slotTimes;
        let formData = {};
        formData["subject_id"] = this.selectedSubject.id;
        formData["teacher_id"] = this.selectedTeacher.id;
        formData["students"] = this.selectedStudent;
        formData["topic"] = this.topic;
        formData["slotTimes"] = this.slotTimes;
        formData["event_message"] = this.event_message;
        
        formData["selected_day"] = this.repeatDays;
        formData["session_repeat"] = this.sessionRepeat;
        formData["pageType"] = this.titleInfo.pageType;
        formData["session_id"] = this.editSessionId;
  
        axios.post("/api/addTimeTable", formData).then((res) => { 
          
        this.classStartDate = this.classStartDateBackUP;
          this.slotTimes = [];
          if (res.data.message == "teacher not available") {
            this.teacherNotAvailable(res.data.startDate,res.data.time_am_pm,res.data.current_time_am_pm);
          } else if(res.data.message == "student not available"){
            this.studentNotAvailable(res.data.startDate,res.data.time_am_pm,res.data.current_time_am_pm);
          }else {
            this.setPageTitle("Time Table");
            this.addStatus('Success');
            this.$router.push("/class-schedule");
          }
        });
     
      },
      teacherNotAvailable(startDate,time_am_pm,current_time_am_pm) {
        this.$toast.open({
          message: "Teacher not available  -" + `${startDate}`+" ("+  `${current_time_am_pm}`+" )</br></br>Teacher Current Class -"+`${startDate}`+" ( "+`${time_am_pm}`+" )",
          type: "error", 
          duration: 5000,
          dismissible: true,
        });
      },
       studentNotAvailable(startDate,time_am_pm,current_time_am_pm) {
        this.$toast.open({
          message: "Student not available  -" + `${startDate}`+" ("+  `${current_time_am_pm}`+" )</br></br>Student Current Class -"+`${startDate}`+" ( "+`${time_am_pm}`+" )",
          type: "error",
          duration: 5000,
          dismissible: true,
        });
      },
      async getSubjects(event) {
        this.subjects = await this.getRecord("subject", event, false);
        this.getData();
        this.getAllTeachers();
      },
      getAllTeachers() {
        
        axios.get("/api/getAllTeachers").then((response) => {
          
          this.teachers = [];
          response.data.result.map((x)=>{
            if (x.name!=null) {
              this.teachers.push(x);
            }
          })
       
        });
      },
      // async updateSelectedSubject() {
      //   if (this.isEditPageLoadFirstTime && this.titleInfo.pageType == "edit") {
      //     this.isEditPageLoadFirstTime = false;
      //     this.teachers = [];
      //   } else {
      //     this.teachers = [];
      //     this.selectedTeacher = [];
      //   }
  
      //   let formData = {};
      //   formData["subject_id"] = this.selectedSubject.id;
      //   let teacherData = [];
      //   axios.post("/api/teacherAccordingSubject", formData).then((res) => {
      //     if (res.data.result.length > 0) {
      //       res.data.result.map((val) => {
      //         teacherData.push({
      //           id: val.id,
      //           name:
      //             val.first_name + " " + val.last_name,
      //         });
      //       });
      //     }
      //     this.teachers = teacherData;
      //     this.isEditPageLoadFirstTime = false;
      //   });
      // },
      updateSelectedTeacher() {
        if (this.titleInfo.pageType =='edit') {
          if (this.currentTeacherIdBackup == this.selectedTeacher.id) {
            this.getData();
          }else{
            this.selectedStudent = '';
          }
          
        }
        this.currentTeacherId = this.selectedTeacher.id;
        // this.getAllStudents();
      },
      getAllStudents() {
        
        this.students = [];
        let formData = {};
        // formData["teacherId"] = this.currentTeacherId;
        formData["teacherId"] = '';
        axios
          .post("/api/getStudentAccordingTeacher", formData)
          .then((response) => {
            response.data.result.map((stu) => {
              // if (stu.teacher.length > 0) {
                this.students.push({
                  id: stu.id,
                  name: stu.name,
                });
              // }
            });
          });
      },
      async getData() {
        
        let frmData = [];
        this.classTime = [];
        frmData = await this.getSpecificRecord(
          "timeTable",
          this.$route.params.id
        );
        
        this.topic = frmData.topic;
        this.selectedSubject = frmData.subject;
        this.editSessionId = frmData.session_id;
  
        this.classStartDate = new Date(frmData.start_date);
        this.classStartTime = new Date(frmData.start_time);
        this.classEndTime = new Date(frmData.end_time);
  
        let classTime = [...this.classTime];
        
        this.classTime = classTime.push(new Date(frmData.start_date));
        this.classTime = classTime.push(new Date(frmData.end_date));
        if (frmData && frmData.selected_day && frmData.selected_day.length>0) {
          let repeatDays = frmData.selected_day.split(',');
          this.repeatDays = repeatDays.map(day => parseInt(day));
        }else{
          this.repeatDays = [];
        }
        
        // console.log('this.repeatDays',this.repeatDays)
        this.event_message = frmData.event_message;
        this.sessionRepeat = frmData.session_repeat;
        let teacherData = [];
        let studentData = [];
        if (frmData.teacher != null) {
          teacherData.push({
            id: frmData.teacher.id,
            name:
              frmData.teacher.first_name +
              " " +
              frmData.teacher.last_name,
          });
        }
        if (frmData.student != null) {
          frmData.student.map((std)=>{
              studentData.push({
            id: std.id,
            name:
              std.first_name +
              " " +
              std.last_name,
          });
          })
        }
        
        this.selectedStudent = studentData;
        this.selectedTeacher = teacherData[0];
        if (this.titleInfo.pageType == 'edit') {
          this.currentTeacherId = teacherData[0].id;
          this.currentTeacherIdBackup = teacherData[0].id;
          // this.getAllStudents();
        }
        // this.updateSelectedSubject();
        this.loading = false;
      },
    },
    mounted() {
      let x = this.$route;
      this.getSubjects(1);
      this.getAllStudents();
    },
    mixins: [formMixins],
  };
  </script>
  <style>
  .timeTable .v-application--wrap {
    min-height: unset !important;
  }
  </style>