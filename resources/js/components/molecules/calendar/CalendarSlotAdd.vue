<template>
  <div class="calendar__page col-lg-12">
    <div id="calendar" class="col-lg-12">
      <table class="col-lg-12">
        <thead class="color">
          <tr>
            <th colspan="7" class="center">
              <h4 id="cal-year">{{ currentYear }}</h4>
              <div>
                <i class="fas fa-caret-left icon" @click.stop="previous"></i>
                <h3 class="cal-month" style="text-transform:uppercase;">{{ currentMonth }}</h3>
                <i class="fas fa-caret-right icon" @click.stop="next"></i>
              </div>
              <!-- <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button
                    class="nav-link active"
                    id="pills-home-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#pills-home"
                    type="button"
                    role="tab"
                    aria-controls="pills-home"
                    aria-selected="true"
                  >
                    MONTH
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button
                    class="nav-link"
                    id="pills-profile-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#pills-profile"
                    type="button"
                    role="tab"
                    aria-controls="pills-profile"
                    aria-selected="false"
                  >
                    WEEK
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button
                    class="nav-link"
                    id="pills-contact-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#pills-contact"
                    type="button"
                    role="tab"
                    aria-controls="pills-contact"
                    aria-selected="false"
                  >
                    DAYS
                  </button>
                </li>
              </ul> -->
            </th>
          </tr>
          <tr>
            <th class="weekday">Sun</th>
            <th class="weekday">Mon</th>
            <th class="weekday">Tue</th>
            <th class="weekday">Wed</th>
            <th class="weekday">Thu</th>
            <th class="weekday">Fri</th>
            <th class="weekday">Sat</th>
          </tr>
        </thead>
        <tbody id="calendar-body"></tbody>
      </table>
    </div>
    <!-- Button trigger modal -->
    <button
      type="button"
      class="btn btn-primary"
      id="modelOpenBtn"
      data-toggle="modal"
      data-target="#exampleModal"
      style="visibility: hidden"
    >
      Launch demo modal
    </button>

    <!-- Modal -->
    <div
      class="modal fade"
      id="exampleModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Session</h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body add-session-modal">
            <div class="form-group col-sm-6 col-lg-4">
              <label for="topicName">Topic</label>
              <input
                v-model="topic"
                type="text"
                class="form-control"
                id="topicName"
                placeholder="topic"
              />
            </div>
            <div class="form-group col-sm-6 col-lg-4">
              <label for="selectSubject">Subject</label>
              <multiselect
                v-model="selectedSubject"
                :options="subjects"
                :searchable="true"
                :close-on-select="false"
                :allow-empty="false"
                :preselect-first="true"
                label="name"
                placeholder="Select Subject"
                track-by="id"
              ></multiselect>
            </div>
            <div class="form-group col-sm-6 col-lg-4">
              <label for="selectTeacher">Teacher</label>
              <multiselect
                v-model="selectedTeacher"
                :options="teachers"
                :searchable="true"
                :close-on-select="false"
                :allow-empty="false"
                :preselect-first="true"
                label="name"
                placeholder="Select Teacher"
                track-by="id"
                @input="updateSelectedTeacher"
              ></multiselect>
            </div>
            <div class="form-group col-sm-6 col-lg-4">
              <label for="selectStudent">Student</label>
              <multiselect
                v-model="selectedStudent"
                :options="students"
                :searchable="true"
                :multiple="true"
                :close-on-select="false"
                :allow-empty="false"
                :preselect-first="true"
                label="name"
                placeholder="Select Student"
                track-by="id"
              ></multiselect>
            </div>
            
             <!-- <div class="form-group col-sm-6 col-lg-4 date-design">
              <label for="starttime">Start Date</label>
              <date-picker
                v-model="classStartDate"
                type="date"
                placeholder="Select date"
                format="YYYY-MM-DD"
                :default-value="new Date()"
                :disabled-date="disabledBeforeToday"
              ></date-picker>
            </div> -->
            <div class="form-group col-sm-6 col-lg-4 date-design">
              <label for="starttime">Start Time</label>
              <date-picker
                v-model="classStartTime"
                type="time"
                placeholder="end date"
                format="hh:mm a"
                :default-value="new Date()"
                :disabled-date="disabledBeforeToday"
              ></date-picker>
            </div>

            <div class="form-group col-sm-6 col-lg-4 date-design">
              <label for="endtime">End Time</label>
              <date-picker
                v-model="classEndTime"
                type="time"
                placeholder="end date"
                format="hh:mm a"
                :default-value="new Date()"
                :disabled-date="disabledBeforeToday"
              ></date-picker>
            </div>
             <div class="form-group col-sm-6 col-lg-4 date-design">
              <label for="endtime">Event Message</label>
               <input
                v-model="event_message"
                type="text"
                class="form-control"
                id="topicName"
                placeholder="event message"
              />
            </div>
            <div
              class="form-group col-sm-12 col-lg-12 custom-checkbox"
              style="border: 1px solid #c4c4c4"
            >
              <label for="repeat">Repeat</label>
              <div class="week-days col-12">
                <div class="" v-for="(day, index) in weekDays" :key="index">
                  <input
                    style="position: inherit"
                    type="checkbox"
                    class="custom-control-input"
                    :id="index"
                    @click="selectStudent($event, day.id)"
                  />
                  <label class="custom-control-label" :for="index">{{
                    day.name
                  }}</label>
                </div>
              </div>
              <div class="session-repeat col-4">
                <label for="repeat">Session Repeat</label>
                <input
                  type="number"
                  v-model="sessionRepeat"
                  min="1"
                  max="100"
                />
              </div>
            </div>
            
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
            >
              Close
            </button>
            <button
              type="button"
              class="btn btn-primary"
              @click="addTimeTableRecord"
            >
              Save
            </button>
          </div>
        </div>
      </div>
    </div>
    <!-- <div class="form-group col-md-3 custom-date-picker">
            <date-picker
              v-model="slotDate"
              type="time"
              placeholder="Select time"
              format="hh:mm a"
            ></date-picker>
          </div>
          <textarea
            v-model="note"
            name="slot-note"
            id="edit-note"
            class="font"
            cols="30"
            rows="10"
          ></textarea>
          <div class="mt-5 mb-5">
            <button
              class="btn button btn-success"
              id="add-note"
              @click.stop="addTimeTableRecord"
            >
              Save
            </button>
          </div> -->
  </div>
</template>

<script>
import moment from 'moment';
import { mapActions, mapGetters } from "vuex";
import formMixins from "../../../Mixins/form";
import "./calendar.css";
export default {
  data: function () {
    return {
      currentTeacherId: "",
      moment: moment,
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
      event_message:'',
      subjects: [],
      students: [],
      selectedSubject: [],
      grades: [],
      selectedGrade: [],
      teachers: [],
      slotTimes: [],
      selectedTeacher: [],
      selectedStudent: [],
      classStartDate:[],
      classStartTime: [],
      classEndTime: [],
      repeatLastDate: new Date(),
      disabledDates: {
        to: new Date(Date.now() - 8640000),
      },
      isEditPageLoadFirstTime: true,

      note: "",
      clickedCellDate: "",
      slotDate: "",
      slots: [],
      filteredSlots: [],
      openSlotModel: false,
      currentYear: "",
      currentMonth: "",
      currentDate: "",
      currentMonthInDigit: "",
      calendar: {
        month: "",
        year: "",
      },
    };
  },
  props: {
    teacher_id: String,
    subject_id: String,
    class_id: String,
  },
  computed: {
    ...mapGetters({
      pageTitle: "pageTitle",
    }),
  },
  watch: {
    pageTitle: function (newVal, oldVal) {
      if (newVal == "Time Table") {
        $("#exampleModal").modal("hide");
        this.$router.push("/class-schedule");
      }
    },
    teacher_id: function (newVal, oldVal) {
      if (newVal != "") {
        this.currentDate = new Date();
        this.currentYear = this.currentDate.getFullYear();
        this.currentMonthInDigit = this.currentDate.getMonth() + 1;
        let callback = () => {
          let currentMonth = this.currentDate.getMonth();
          let currentYear = this.currentDate.getFullYear();
          this.showCalendar(currentMonth, currentYear);
        };

        this.getTeacherSlots(callback);
      }
    },
  },
  mounted() {
    this.currentDate = new Date();
    let currentMonth = this.currentDate.getMonth();
    let currentYear = this.currentDate.getFullYear();
    this.showCalendar(currentMonth, currentYear);
    this.getSubjects(1);
    $("#calendar").datepicker({ maxDate: 0 });
  },
  methods: {
    ...mapActions({
      setPageTitle: "setPageTitle",
    }),
    getAllStudents() {
      this.students = [];
      let formData = {};
      formData["teacherId"] = this.currentTeacherId;
      axios
        .post("/api/getStudentAccordingTeacher", formData)
        .then((response) => {
          response.data.result.map((stu) => {
            if (stu.teacher.length > 0) {
              this.students.push({
                id: stu.id,
                name: stu.name,
              });
            }
          });
        });
    },
    updateSelectedTeacher() {
      this.currentTeacherId = this.selectedTeacher.id;
      this.getAllStudents();
    },
    disabledBeforeToday(date) {
      const today = new Date();
      today.setHours(0, 0, 0, 0);
      return date < today;
    },
    selectStudent(event, day) {
      if (event.target.checked) {
        let days = [...this.repeatDays];
        days.push(day);
        this.repeatDays = days;
      } else {
        let days = [...this.repeatDays];
        let items = days.filter((dayName) => dayName !== day);
        this.repeatDays = items;
      }
    },
    checkSlots(a) {
      let date = this.currentYear + "-" + this.currentMonthInDigit + "-" + a;
      let { slots } = this;
      const filteredSlots = slots.filter((slot) => {
        let time = slot.time.split(/(\s+)/);
        time = time[0];
        if (time == date) {
          return true;
        }
        return false;
      });
      return filteredSlots;
    },
    addSlot(a) {
      
      let day = parseInt(a.currentTarget.innerText);
      day = day < 10 ? `0${day}` : `${day}`;

      this.openSlotModel = true;
      $("#modelOpenBtn").click();
      this.clickedCellDate =
        this.currentYear + "-" + this.currentMonthInDigit + "-" + day;

        this.classStartDate = this.clickedCellDate;
                
    },
    async addTimeTableRecord(e) {
      if (this.openSlotModel) {
        this.classStartDate = moment(this.classStartDate, "YYYY/MM/DD").toDate();
      } 
      this.classEndDate = this.classStartDate;
      let slotTimes = [...this.slotTimes];

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

      slotTimes.push({
        startDate:startDate,
        endDate:startDate,
        startTime:startTime,
        endTime:endTime,
        time_am_pm: time_am_pm,
      });

      let strtDate = this.classStartDate.setDate(
        this.classStartDate.getDate() + 1
      );
      this.classStartDate = new Date(strtDate);

      let eDate = this.classEndDate.setDate(this.classEndDate.getDate() + 1);
      this.classEndDate = new Date(eDate);

      // add repeat date into slotTimes Array
      
      while (this.classStartDate <= this.repeatLastDate) {
        let day = this.classStartDate.getDay();
        // first check next day is present in repeatDays array or not , if present then only push into slotTimes array
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

          // final slot times
          slotTimes.push({
            startDate:startDate,
            endDate:startDate,
            startTime:startTime,
            endTime:endTime,
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
      // formData["class_id"] = this.selectedGrade.id;
      formData["subject_id"] = this.selectedSubject.id;
      formData["teacher_id"] = this.selectedTeacher.id;
      formData["students"] = this.selectedStudent;
      formData["topic"] = this.topic;
      formData["slotTimes"] = this.slotTimes;
      formData["event_message"] = this.event_message;
      
     axios.post("/api/addTimeTable", formData).then((res) => {
       
       if (res.data.message == "teacher not available") {
          this.teacherNotAvailable(res.data.startDate,res.data.time_am_pm,res.data.current_time_am_pm);
        }else if(res.data.message == "student not available"){
          this.studentNotAvailable(res.data.startDate,res.data.time_am_pm,res.data.current_time_am_pm);
        } else {
          $("#modelOpenBtn").click();
          this.openSlotModel = false;
          this.setPageTitle("Time Table");
          // this.getSlots();
        }
        
         
      });
      // this.addRecord("timeTable", formData, "/class-schedule");
    },
    teacherNotAvailable(startDate,time_am_pm,current_time_am_pm) {
      this.$toast.open({
        message: "Teacher not available -" + `${startDate}`+" ("+  `${current_time_am_pm}`+" )</br></br>Teacher Current Class -"+`${startDate}`+" ( "+`${time_am_pm}`+" )",
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
        this.teachers = response.data.result;
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
      // this.classTime = new Date(frmData.start_date, frmData.end_date);
      this.classTime.push(new Date(frmData.start_date));
      this.classTime.push(new Date(frmData.end_date));

      let teacherData = [];
      if (frmData.teacher != null) {
        teacherData.push({
          id: frmData.teacher.id,
          name:
            frmData.teacher.first_name +
            " " +
            frmData.teacher.middle_name +
            " " +
            frmData.teacher.last_name,
        });
      }
      this.selectedTeacher = teacherData;
      this.updateSelectedSubject();
      this.loading = false;
    },

    getTeacherSlots(callback) {
      let formData = {};
      formData["teacher_id"] = this.teacher_id;
      formData["class_id"] = this.class_id;
      formData["year"] = this.currentYear;
      formData["month"] = this.currentMonthInDigit;

      axios.post("/api/getTeacherSlots", formData).then((response) => {
        this.slots = response.data.result;
        if (callback) {
          callback();
        }
      });
    },
    async updateSelectedSubject() {
      if (this.isEditPageLoadFirstTime && this.titleInfo.pageType == "edit") {
        this.isEditPageLoadFirstTime = false;
        this.teachers = [];
      } else {
        this.teachers = [];
        this.selectedTeacher = [];
      }

      let formData = {};
      formData["subject_id"] = this.selectedSubject.id;
      let teacherData = [];
      axios.post("/api/teacherAccordingSubject", formData).then((res) => {
        if (res.data.result.length > 0) {
          res.data.result.map((val) => {
            teacherData.push({
              id: val.id,
              name:
                val.first_name + " " + val.middle_name + " " + val.last_name,
            });
          });
        }
        this.teachers = teacherData;
        this.isEditPageLoadFirstTime = false;
      });
    },
    next() {
      let currentMonth = this.currentDate.getMonth();
      let currentYear = this.currentDate.getFullYear();
      currentYear = currentMonth === 11 ? currentYear + 1 : currentYear;
      currentMonth = (currentMonth + 1) % 12;
      this.currentDate = new Date(currentYear, currentMonth);
      this.showCalendar(currentMonth, currentYear);
    },

    previous() {
      let currentMonth = this.currentDate.getMonth();
      let currentYear = this.currentDate.getFullYear();
      currentYear = currentMonth === 0 ? currentYear - 1 : currentYear;
      currentMonth = currentMonth === 0 ? 11 : currentMonth - 1;
      this.currentDate = new Date(currentYear, currentMonth);
      this.showCalendar(currentMonth, currentYear);
    },

    showCalendar(month, year) {
      let today = new Date();
      let months = [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December",
      ];

      let firstDay = new Date(year, month).getDay();
      let daysInMonth = 32 - new Date(year, month, 32).getDate();
      let tbl = document.getElementById("calendar-body"); // body of the calendar

      // clearing all previous cells
      tbl.innerHTML = "";

      // filing data about month and in the page via DOM.
      this.currentMonth = months[month];

      this.currentMonthInDigit =
        month + 1 < 10 ? `0${month + 1}` : `${month + 1}`;
      this.currentYear = year;

      // creating all cells
      let date = 1;
      let filteredSlots = [];
      for (let i = 0; i < 6; i++) {
        // creates a table row
        let row = document.createElement("tr");
        //creating individual cells, filing them up with data.
        for (let j = 0; j < 7; j++) {
          if (i === 0 && j < firstDay) {
            let cell = document.createElement("td");
            let cellText = document.createTextNode("");
            cell.appendChild(cellText);
            row.appendChild(cell);
          } else if (date > daysInMonth) {
            break;
          } else {
            let cell = document.createElement("td");
            var plusIcon = cell.appendChild(document.createElement("i"));
            plusIcon.classList.add("fas");
            plusIcon.classList.add("fa-plus");
            plusIcon.classList.add("slot-add-icon");
            cell.onclick = this.addSlot.bind(this);

            let cellText = document.createTextNode(date);
            let cellSlot = "";
            let filteredSlots = this.checkSlots(
              date < 10 ? `0${date}` : `${date}`
            );
            if (filteredSlots.length > 0) {
              const rndInt = Math.floor(Math.random() * 5) + 1;
              var img = cell.appendChild(document.createElement("img"));
              console.log("img", img);
              img.setAttribute("src", "./Images/note1.png");
              //  img.setAttribute("src", `./Images/note${rndInt}.png`);
              var span = cell.appendChild(document.createElement("SPAN"));
              span.classList.add("slot-span");

              filteredSlots.map((val) => {
                var a = cell.appendChild(document.createElement("a"));
                a.classList.add("slot-anchor");
                cellSlot = document.createTextNode(
                  "* " + val.topic + "(" + val.time_am_pm.slice(10) + " )"
                );
                a.appendChild(cellSlot);
                span.appendChild(a);
              });
              cell.classList.add("tooltips");
            }
            if (
              date === today.getDate() &&
              year === today.getFullYear() &&
              month === today.getMonth()
            ) {
              cell.classList.add("today-color");
            } // color today's date
            if (
              date < today.getDate() &&
              year <= today.getFullYear() &&
              month <= today.getMonth()
            ) {
              cell.classList.add("session-not-allow");
            }
            if (year <= today.getFullYear() && month < today.getMonth()) {
              cell.classList.add("session-not-allow");
            }
            cell.appendChild(cellText);
            row.appendChild(cell);
            date = date + 1;
          }
        }

        tbl.appendChild(row); // appending each row into calendar body.
      }
    },
  },
  mixins: [formMixins],
};
</script>

