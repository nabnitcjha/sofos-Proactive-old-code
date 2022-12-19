<template>
  <div class="calendar__page col-lg-12">
    <div id="calendar" class="col-lg-12">
      <table class="col-lg-12">
        <thead class="color">
          <tr>
            <th colspan="8" class="center">
              <h2 id="cal-year">{{ currentYear }}</h2>
              <div>
                <i class="fas fa-caret-left icon" @click.stop="previous"></i>
                <h3 class="cal-month" style="text-transform: uppercase">
                  {{ currentMonth }}
                </h3>
                <i class="fas fa-caret-right icon" @click.stop="next"></i>
              </div>
              <ul
                class="nav nav-pills mb-3 calendar-view-type"
                id="pills-tab"
                role="tablist"
              >
                <li class="nav-item" role="presentation">
                  <button
                    id="pills-month-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#pills-month"
                    type="button"
                    role="tab"
                    aria-controls="pills-month"
                    aria-selected="true"
                    v-bind:class="[
                      'nav-link',
                      isMonthlyClicked == true ? 'active' : '',
                    ]"
                    @click.stop="monthlyRecord"
                  >
                    MONTH
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button
                    id="pills-week-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#pills-week"
                    type="button"
                    role="tab"
                    aria-controls="pills-week"
                    aria-selected="false"
                    v-bind:class="[
                      'nav-link',
                      isWeeklyClicked == true ? 'active' : '',
                    ]"
                    @click.stop="weeklyRecord"
                  >
                    WEEK
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button
                    id="pills-day-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#pills-day"
                    type="button"
                    role="tab"
                    aria-controls="pills-day"
                    aria-selected="false"
                    v-bind:class="[
                      'nav-link',
                      isDayClicked == true ? 'active' : '',
                    ]"
                    @click.stop="dayRecord"
                  >
                    DAYS
                  </button>
                </li>
              </ul>
            </th>
          </tr>
          <tr v-if="viewType == 'monthly'">
            <th class="weekday">Sun</th>
            <th class="weekday">Mon</th>
            <th class="weekday">Tue</th>
            <th class="weekday">Wed</th>
            <th class="weekday">Thu</th>
            <th class="weekday">Fri</th>
            <th class="weekday">Sat</th>
          </tr>
          <tr v-if="viewType == 'weekly'">
            <th class="no-border"></th>
            <th
              class="weekday"
              v-for="(week, index) in weekHeader"
              :key="index"
            >
              <span>{{ week.name }}</span>
              <span v-if="currentDay == week.day" class="today-date">{{
                week.day
              }}</span>
              <span v-else>{{ week.day }}</span>
            </th>
          </tr>
          <tr v-if="viewType == 'day'">
            <th class="no-border"></th>
            <th
              class="weekday day-th"
              v-for="(day, index) in dayHeader"
              :key="index"
            >
              <span>{{ day.name }}</span>
              <span v-if="currentDay == day.day" class="today-date">{{
                day.day
              }}</span>
              <span v-else>{{ day.day }}</span>
            </th>
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
            <div class="form-group col-sm-6 col-lg-4 calendar-select-student">
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
            <div class="form-group col-sm-12 col-lg-12">
              <div
                class="student-dlt"
                v-for="(std, index) in selectedStudent"
                :key="index"
              >
                <h4>
                  {{ std.name
                  }}<span
                    ><a
                      ><i
                        class="far fa-times-circle"
                        @click.stop="removeStudent(std.id)"
                      ></i></a
                  ></span>
                </h4>
              </div>
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
                  class="col-5"
                />
              </div>
            </div>
          </div>
          <div class="form-group col-sm-6 col-lg-12 date-design">
            <!-- <label for="endtime">Event Message</label> -->
            <textarea
              class="form-control event-description"
              rows="5"
              id="topicName"
              placeholder="Description"
              v-model="event_message"
            ></textarea>
            <!-- <input
                v-model="event_message"
                type="text"
                class="form-control"
                id="topicName"
                placeholder="event message"
              /> -->
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
              class="btn btn-orange"
              @click="addTimeTableRecord"
            >
              Save
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import moment from "moment";
import formMixins from "../../../Mixins/form";
import "./calendar.css";
export default {
  data: function () {
    return {
      selectColorClass: 2,
      isMonthlyClicked: true,
      isWeeklyClicked: false,
      isDayClicked: false,
      weekHeader: [],
      dayHeader: [],
      weekDate: [],
      classStartDateBackUP: [],
      classStartDate: [],
      viewType: "monthly",
      startOfWeek: "",
      endOfWeek: "",
      nextMonthStartOfWeekDate: "",
      previousMonthStartOfWeekDate: "",
      nextDay: "",
      previousDay: "",
      moment: moment,
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
      currentDay: "",
      inforUrl: "class-schedule-detail",
      calendar: {
        month: "",
        year: "",
      },
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
      event_message: "",
      subjects: [],
      students: [],
      selectedSubject: [],
      grades: [],
      selectedGrade: [],
      teachers: [],
      slotTimes: [],
      selectedTeacher: [],
      selectedStudent: [],
      classStartDate: [],
      classStartDateBackUP:'',
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
    userType: String,
    session: Array,
  },
  computed: {
    ...mapGetters({
      pageTitle: "pageTitle",
      user: "user",
    }),
  },
  watch: {
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
    this.getSlots();
    this.getSubjects(1);
    $("#calendar").datepicker({ maxDate: 0 });
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
      setPageView:"setPageView"
    }),
    callShowCalendar() {
      this.currentDate = new Date();
      let currentMonth = this.currentDate.getMonth();
      let currentYear = this.currentDate.getFullYear();

      let frmtDate = moment(this.currentDate, "YYYY/MM/DD");
      this.currentDay = frmtDate.format("D");
      this.showCalendar(currentMonth, currentYear);
    },
    dayRecord() {
      if (this.isDayClicked == true) {
        return;
      }
      this.isDayClicked = true;
      this.isWeeklyClicked = false;
      this.isMonthlyClicked = false;
      this.viewType = "day";
      this.dayHeader = [];

      let today = new Date();
      this.nextDay = moment(this.currentDate).add(1, "days").toDate();
      this.previousDay = moment(this.currentDate).add(-1, "days").toDate();

      this.currentYear = today.getFullYear();
      let months = [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec",
      ];

      // filing data about month and in the page via DOM.
      this.currentMonth = months[today.getMonth()];

      moment.locale("en");

      let formattedDate = moment(today, "YYYY/MM/DD");
      let startDayName = formattedDate.format("ddd");
      this.dayHeader.push({
        name: startDayName,
        day: formattedDate.format("D"),
      });

      let tbl = document.getElementById("calendar-body");
      tbl.innerHTML = "";

      for (let i = 0; i < 24; i++) {
        let row = document.createElement("tr");
        let timeCell = document.createElement("td");
        timeCell.classList.add("no-border");
        let leftSideTime = this.getLeftTime(i);
        let timeCellText = document.createTextNode(leftSideTime);
        timeCell.appendChild(timeCellText);
        row.appendChild(timeCell);
        tbl.appendChild(row);
        let check = moment(today, "YYYY/MM/DD");
        let date = check.format("D");
        let cell = document.createElement("td");

        // let cellText = document.createTextNode(date);
        let cellText = document.createTextNode("");
        let cellSlot = "";
        let filteredSlots = this.checkDaySlots(this.dateFormater(today));
        // Done
        if (filteredSlots.length > 0) {
          var span = cell.appendChild(document.createElement("SPAN"));
          span.classList.add("slot-span");

          filteredSlots.map((val) => {
            let slotTime = val.start_time.slice(11, 13);
            let getLeftTimeWithoutAM_PM = this.getLeftTimeWithoutAM_PM(i);
            if (slotTime == getLeftTimeWithoutAM_PM) {
              var a = cell.appendChild(document.createElement("a"));
              if (this.pageTitle == "Time Table") {
                a.onclick = this.goToDetailPage.bind(this);
                var sessionId = a.appendChild(document.createElement("SPAN"));
                sessionId.classList.add("slot-id");
                cellSlot = document.createTextNode(val.id);
                sessionId.appendChild(cellSlot);
                a.appendChild(sessionId);
                span.appendChild(a);
              }
              a.classList.add("slot-anchor");
              if (this.selectColorClass % 2 == 0) {
                a.classList.add("color-one");
              } else {
                a.classList.add("color-two");
              }
              this.selectColorClass = this.selectColorClass + 1;

              var sp1 = a.appendChild(document.createElement("SPAN"));
              sp1.classList.add("slot-title");
              cellSlot = document.createTextNode(val.topic);
              sp1.appendChild(cellSlot);
              a.appendChild(sp1);
              span.appendChild(a);

              var sp2 = a.appendChild(document.createElement("SPAN"));
              sp2.classList.add("slot-time");
              cellSlot = document.createTextNode(val.time_am_pm);
              sp2.appendChild(cellSlot);
              a.appendChild(sp2);
              span.appendChild(a);
            }
          });
          cell.classList.add("tooltips");
        }

        cell.appendChild(cellText);
        row.appendChild(cell);
        tbl.appendChild(row);
      }
    },
    disabledBeforeToday(date) {
      const today = new Date();
      today.setHours(0, 0, 0, 0);
      return date < today;
    },
    async getSubjects(event) {
      this.subjects = await this.getRecord("subject", event, false);
      this.getData();
      this.getAllTeachers();
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
    getAllTeachers() {
      axios.get("/api/getAllTeachers").then((response) => {
        this.teachers = response.data.result;
      });
    },
    getLeftTime(data) {
      switch (data) {
        case 0:
          return "1:00 AM";
        case 1:
          return "2:00 AM";
        case 2:
          return "3:00 AM";
        case 3:
          return "4:00 AM";
        case 4:
          return "5:00 AM";
        case 5:
          return "6:00 AM";
        case 6:
          return "7:00 AM";
        case 7:
          return "8:00 AM";
        case 8:
          return "9:00 AM";
        case 9:
          return "10:00 AM";
        case 10:
          return "11:00 AM";
        case 11:
          return "12:00 PM";
        case 12:
          return "13:00 PM";
        case 13:
          return "14:00 PM";
        case 14:
          return "15:00 PM";
        case 15:
          return "16:00 PM";
        case 16:
          return "17:00 PM";
        case 17:
          return "18:00 PM";
        case 18:
          return "19:00 PM";
        case 19:
          return "20:00 PM";
        case 20:
          return "21:00 PM";
        case 21:
          return "22:00 PM";
        case 22:
          return "23:00 PM";
        case 23:
          return "24:00 AM";
      }
    },
    getLeftTimeWithoutAM_PM(data) {
      switch (data) {
        case 0:
          return "01";
        case 1:
          return "02";
        case 2:
          return "03";
        case 3:
          return "04";
        case 4:
          return "05";
        case 5:
          return "06";
        case 6:
          return "07";
        case 7:
          return "08";
        case 8:
          return "09";
        case 9:
          return "10";
        case 10:
          return "11";
        case 11:
          return "12";
        case 12:
          return "13";
        case 13:
          return "14";
        case 14:
          return "15";
        case 15:
          return "16";
        case 16:
          return "17";
        case 17:
          return "18";
        case 18:
          return "19";
        case 19:
          return "20";
        case 20:
          return "21";
        case 21:
          return "22";
        case 22:
          return "23";
        case 23:
          return "24";
      }
    },
    weeklyRecord() {
      let today = new Date();
      let month = this.currentDate.getMonth();
      let year = this.currentDate.getFullYear();
      if (this.isWeeklyClicked == true) {
        return;
      }
      this.isWeeklyClicked = true;
      this.isMonthlyClicked = false;
      this.isDayClicked = false;
      this.viewType = "weekly";
      this.weekHeader = [];
      this.weekDate = [];

      moment.locale("en");
      this.startOfWeek = moment(this.currentDate).startOf("week").toDate();
      this.endOfWeek = moment(this.currentDate).endOf("week").toDate();
      // this.previousMonthStartOfWeekDate = moment(this.currentDate).startOf("week").toDate();
      // this.nextMonthStartOfWeekDate = moment(this.currentDate).add(7, 'days').toDate();
      this.previousMonthStartOfWeekDate = moment(this.currentDate)
        .startOf("week")
        .toDate();
      this.nextMonthStartOfWeekDate = moment(this.currentDate)
        .endOf("week")
        .toDate();

      let tbl = document.getElementById("calendar-body");
      tbl.innerHTML = "";

      while (this.startOfWeek < this.endOfWeek) {
        let strtwek = moment(this.startOfWeek, "YYYY/MM/DD");

        let startDayName = strtwek.format("ddd");
        this.weekHeader.push({ name: startDayName, day: strtwek.format("D") });
        this.weekDate.push(this.dateFormater(strtwek));

        this.startOfWeek = moment(this.startOfWeek).add(1, "days").toDate();
      }
      for (let i = 0; i < 24; i++) {
        let row = document.createElement("tr");
        let timeCell = document.createElement("td");
        timeCell.classList.add("no-border");
        let leftSideTime = this.getLeftTime(i);
        let timeCellText = document.createTextNode(leftSideTime);
        timeCell.appendChild(timeCellText);
        row.appendChild(timeCell);
        tbl.appendChild(row);

        this.weekDate.map((va) => {
          let check = moment(va, "YYYY/MM/DD");
          let date = check.format("D");
          let cell = document.createElement("td");
          // let cellText = document.createTextNode(date);
          let cellText = document.createTextNode("");
          let cellSlot = "";
          let filteredSlots = this.checkWeeklySlots(va);

          // done
          if (filteredSlots.length > 0) {
            const rndInt = Math.floor(Math.random() * 5) + 1;
            // var img = cell.appendChild(document.createElement("img"));
            // console.log("img", img);
            // img.setAttribute("src", "./Images/note1.png");
            //  img.setAttribute("src", `./Images/note${rndInt}.png`);
            var span = cell.appendChild(document.createElement("SPAN"));
            span.classList.add("slot-span");

            filteredSlots.map((val) => {
              let slotTime = val.start_time.slice(11, 13);
              let getLeftTimeWithoutAM_PM = this.getLeftTimeWithoutAM_PM(i);
              if (slotTime == getLeftTimeWithoutAM_PM) {
                var a = cell.appendChild(document.createElement("a"));
                if (this.pageTitle == "Time Table") {
                  a.onclick = this.goToDetailPage.bind(this);
                  var sessionId = a.appendChild(document.createElement("SPAN"));
                  sessionId.classList.add("slot-id");
                  cellSlot = document.createTextNode(val.id);
                  sessionId.appendChild(cellSlot);
                  a.appendChild(sessionId);
                  span.appendChild(a);
                }
                a.classList.add("slot-anchor");

                if (this.selectColorClass % 2 == 0) {
                  a.classList.add("color-one");
                } else {
                  a.classList.add("color-two");
                }
                this.selectColorClass = this.selectColorClass + 1;

                var sp1 = a.appendChild(document.createElement("SPAN"));
                sp1.classList.add("slot-title");
                cellSlot = document.createTextNode(val.topic);
                sp1.appendChild(cellSlot);
                a.appendChild(sp1);
                span.appendChild(a);

                var sp2 = a.appendChild(document.createElement("SPAN"));
                sp2.classList.add("slot-time");
                cellSlot = document.createTextNode(val.time_am_pm);
                sp2.appendChild(cellSlot);
                a.appendChild(sp2);
                span.appendChild(a);
              }
            });
            cell.classList.add("tooltips");
          }

          cell.appendChild(cellText);
          row.appendChild(cell);
          tbl.appendChild(row);
        });
      }
    },
    monthlyRecord() {
      if (this.isMonthlyClicked == true) {
        return;
      }
      this.isMonthlyClicked = true;
      this.isWeeklyClicked = false;
      this.isDayClicked = false;
      this.viewType = "monthly";
      this.currentDate = new Date();
      let currentMonth = this.currentDate.getMonth();
      let currentYear = this.currentDate.getFullYear();
      this.showCalendar(currentMonth, currentYear);
    },
    checkDaySlots(date) {
      let { slots } = this;
      const filteredSlots = slots.filter((slot) => {
        let start_date = slot.start_date.split(/(\s+)/);
        start_date = start_date[0];
        if (start_date == date) {
          return true;
        }
        return false;
      });
      return filteredSlots;
    },
    checkWeeklySlots(date) {
      let { slots } = this;
      const filteredSlots = slots.filter((slot) => {
        let start_date = slot.start_date.split(/(\s+)/);
        start_date = start_date[0];
        if (start_date == date) {
          return true;
        }
        return false;
      });
      return filteredSlots;
    },
    checkSlots(a) {
      let date = this.currentYear + "-" + this.currentMonthInDigit + "-" + a;
      let { slots } = this;
      const filteredSlots = slots.filter((slot) => {
        let start_date = slot.start_date.split(/(\s+)/);
        start_date = start_date[0];
        if (start_date == date) {
          return true;
        }
        return false;
      });
      return filteredSlots;
    },
    addSlot(a) {
     
     let dayString = a.srcElement.className.slice(26,28);
      let day = parseInt(dayString);
      day = day < 10 ? `0${day}` : `${day}`;

      this.openSlotModel = true;
      $("#modelOpenBtn").click();
      this.clickedCellDate =
        this.currentYear + "-" + this.currentMonthInDigit + "-" + day;

      this.classStartDate = this.clickedCellDate;
      this.classStartDateBackUP = this.clickedCellDate;

      this.startOfWeek = moment(this.clickedCellDate).startOf("week").toDate();
      this.endOfWeek = moment(this.clickedCellDate).endOf("week").toDate();
    },
    goToDetailPage(a) {
      let id = "";
      if (a.target.className == "slot-id") {
        id = a.target.childNodes[0].data;
      } else if (a.target.className == "slot-time") {
        id = a.target.previousSibling.previousSibling.innerHTML;
      } else if (a.target.className == "slot-anchor") {
        id = a.target.firstChild.innerHTML;
      } else {
        id = a.target.previousSibling.innerHTML;
      }

      this.setPageTitle("Timetable Detail");
      if (this.user.roleNames[0] == "admin") {
        // this.inforUrl = "admin-calendar-detail";
        this.setPageTitle('Session Detail');
        this.inforUrl = "session-detail";
      } else if (this.user.roleNames[0] == "teacher") {
        this.inforUrl = "teacher-calendar-detail";
      } else if (this.user.roleNames[0] == "student") {
        this.inforUrl = "student-calendar-detail";
      } else {
        this.inforUrl = "parent-calendar-detail";
      }
      this.$router.push("/" + this.inforUrl + "/" + id);
    },
    async addTimeTableRecord(e) {
      
      e.preventDefault();
      if (this.openSlotModel) {
        this.classStartDate = moment(
          this.classStartDate,
          "YYYY/MM/DD"
        ).toDate();
      }
      
      // this.classEndDate = this.classStartDate;
      let slotTimes = [...this.slotTimes];
      this.classStartDateBackUP = new Date(this.classStartDate);
      let repeatDays = this.sessionRepeat * 7;
      var startDate = new Date();
      var endDate = new Date();
      var startTime = new Date();
      var endTime = new Date();
      

      startDate = this.dateFormater(this.classStartDate);
      endDate = this.dateFormater(this.classStartDate);
      this.repeatLastDate.setDate(this.classStartDate.getDate() + repeatDays);

      let time_am_pm =
        (await this.single_dateFormater_AM_PM(this.classStartTime)) +
        " - " +
        (await this.single_dateFormater_AM_PM(this.classEndTime));

      startTime = this.single_dateFormater(this.classStartTime);
      endTime = this.single_dateFormater(this.classEndTime);
      
      startDate = this.timeAndDate(startDate,moment(startTime).format('hh:mm:ss'));
      endDate = this.timeAndDate(endDate,moment(endTime).format('hh:mm:ss'));
      

      slotTimes.push({
        startDate: startDate,
        endDate: endDate,
        startTime: startTime,
        endTime: endTime,
        time_am_pm: time_am_pm,
      });

      let strtDate = this.classStartDate.setDate(
        this.classStartDate.getDate() + 1
      );
      this.classStartDate = new Date(strtDate);

      this.classEndDate = new Date(strtDate);

      // let eDate = this.classEndDate.setDate(this.classEndDate.getDate() + 1);
      // this.classEndDate = new Date(eDate);

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
          startDate = this.timeAndDate(startDate,moment(startTime).format('hh:mm:ss'));
          endDate = this.timeAndDate(endDate,moment(endTime).format('hh:mm:ss'));
          

          // final slot times
          slotTimes.push({
            startDate: startDate,
            endDate: endDate,
            startTime: startTime,
            endTime: endTime,
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
        
        this.classStartDate = this.classStartDateBackUP;
        this.slotTimes = [];
        if (res.data.message == "teacher not available") {
          this.teacherNotAvailable(res.data.startDate,res.data.time_am_pm,res.data.current_time_am_pm);
        }else if(res.data.message == "student not available"){
          this.studentNotAvailable(res.data.startDate,res.data.time_am_pm,res.data.current_time_am_pm);
        } else {
          $("#modelOpenBtn").click();
          this.openSlotModel = false;
          this.setPageTitle("Time Table");
          this.getSlots();
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
    getSlots() {
      
      let formData = {};
      // if (this.pageTitle == "Time Table") {
      //   formData["session_id"] = "fetch all session";
      // } else {
      //   formData["session_id"] = this.$route.params.session_id;
      // }
      
      formData["session"] = this.session;
      if (this.userType == "teacher") {
        formData["mode"] = "teacher";
        formData["teacher_id"] = this.user.teacher.id;
      } else if (this.userType == "student") {
        formData["mode"] = "student";
        formData["student_id"] = this.user.student.id;
      } else if (this.userType == "parent") {
        formData["mode"] = "parent";
        formData["parent_id"] = this.user.parent.id;
      } else {
        formData["mode"] = "admin";
      }
      
      axios.post("/api/getSlots", formData).then((response) => {
        
        this.slots = response.data.result;
        this.callShowCalendar();
      });
    },
    next() {
      if (this.isMonthlyClicked) {
        let currentMonth = this.currentDate.getMonth();
        let currentYear = this.currentDate.getFullYear();
        currentYear = currentMonth === 11 ? currentYear + 1 : currentYear;
        currentMonth = (currentMonth + 1) % 12;
        this.currentDate = new Date(currentYear, currentMonth);
        this.showCalendar(currentMonth, currentYear);
      } else if (this.isWeeklyClicked) {
        moment.locale("en");

        this.nextMonthStartOfWeekDate = moment(this.nextMonthStartOfWeekDate)
          .add(7, "days")
          .toDate();

        this.startOfWeek = moment(this.nextMonthStartOfWeekDate)
          .startOf("week")
          .toDate();
        this.endOfWeek = moment(this.nextMonthStartOfWeekDate)
          .endOf("week")
          .toDate();

        this.previousMonthStartOfWeekDate = this.startOfWeek;
        this.nextMonthStartOfWeekDate = this.endOfWeek;

        let tbl = document.getElementById("calendar-body");
        tbl.innerHTML = "";
        this.weekHeader = [];
        this.weekDate = [];
        while (this.startOfWeek < this.endOfWeek) {
          let strtwek = moment(this.startOfWeek, "YYYY/MM/DD");
          let startDayName = strtwek.format("ddd");
          // this.weekHeader.push(startDayName);
          this.weekHeader.push({
            name: startDayName,
            day: strtwek.format("D"),
          });
          this.weekDate.push(this.dateFormater(strtwek));

          this.startOfWeek = moment(this.startOfWeek).add(1, "days").toDate();
        }
        for (let i = 0; i < 24; i++) {
          let row = document.createElement("tr");
          let timeCell = document.createElement("td");
          timeCell.classList.add("no-border");
          let leftSideTime = this.getLeftTime(i);
          let timeCellText = document.createTextNode(leftSideTime);
          timeCell.appendChild(timeCellText);
          row.appendChild(timeCell);
          tbl.appendChild(row);
          this.weekDate.map((va) => {
            let check = moment(va, "YYYY/MM/DD");
            let date = check.format("D");
            let cell = document.createElement("td");

            // let cellText = document.createTextNode(date);
            let cellText = document.createTextNode("");
            let cellSlot = "";
            let filteredSlots = this.checkWeeklySlots(va);
            // done
            if (filteredSlots.length > 0) {
              var span = cell.appendChild(document.createElement("SPAN"));
              span.classList.add("slot-span");

              filteredSlots.map((val) => {
                let slotTime = val.start_time.slice(11, 13);
                let getLeftTimeWithoutAM_PM = this.getLeftTimeWithoutAM_PM(i);
                if (slotTime == getLeftTimeWithoutAM_PM) {
                  var a = cell.appendChild(document.createElement("a"));
                  if (this.pageTitle == "Time Table") {
                    a.onclick = this.goToDetailPage.bind(this);
                    var sessionId = a.appendChild(
                      document.createElement("SPAN")
                    );
                    sessionId.classList.add("slot-id");
                    cellSlot = document.createTextNode(val.id);
                    sessionId.appendChild(cellSlot);
                    a.appendChild(sessionId);
                    span.appendChild(a);
                  }
                  a.classList.add("slot-anchor");

                  if (this.selectColorClass % 2 == 0) {
                    a.classList.add("color-one");
                  } else {
                    a.classList.add("color-two");
                  }
                  this.selectColorClass = this.selectColorClass + 1;

                  var sp1 = a.appendChild(document.createElement("SPAN"));
                  sp1.classList.add("slot-title");
                  cellSlot = document.createTextNode(val.topic);
                  sp1.appendChild(cellSlot);
                  a.appendChild(sp1);
                  span.appendChild(a);

                  var sp2 = a.appendChild(document.createElement("SPAN"));
                  sp2.classList.add("slot-time");
                  cellSlot = document.createTextNode(val.time_am_pm);
                  sp2.appendChild(cellSlot);
                  a.appendChild(sp2);
                  span.appendChild(a);
                }
              });
              cell.classList.add("tooltips");
            }

            cell.appendChild(cellText);
            row.appendChild(cell);
            tbl.appendChild(row);
          });
        }
      } else {
        this.viewType = "day";
        let today = this.nextDay;
        this.dayHeader = [];
        this.currentYear = today.getFullYear();
        let months = [
          "Jan",
          "Feb",
          "Mar",
          "Apr",
          "May",
          "Jun",
          "Jul",
          "Aug",
          "Sep",
          "Oct",
          "Nov",
          "Dec",
        ];

        // filing data about month and in the page via DOM.
        this.currentMonth = months[today.getMonth()];

        moment.locale("en");
        let formattedDate = moment(today, "YYYY/MM/DD");
        let startDayName = formattedDate.format("ddd");
        this.dayHeader.push({
          name: startDayName,
          day: formattedDate.format("D"),
        });

        let tbl = document.getElementById("calendar-body");
        tbl.innerHTML = "";

        for (let i = 0; i < 24; i++) {
          let row = document.createElement("tr");
          let timeCell = document.createElement("td");
          timeCell.classList.add("no-border");
          let leftSideTime = this.getLeftTime(i);
          let timeCellText = document.createTextNode(leftSideTime);
          timeCell.appendChild(timeCellText);
          row.appendChild(timeCell);
          tbl.appendChild(row);
          let check = moment(today, "YYYY/MM/DD");
          let date = check.format("D");
          let cell = document.createElement("td");

          // let cellText = document.createTextNode(date);
          let cellText = document.createTextNode("");
          let cellSlot = "";
          let filteredSlots = this.checkDaySlots(this.dateFormater(today));
          // done
          if (filteredSlots.length > 0) {
            var span = cell.appendChild(document.createElement("SPAN"));
            span.classList.add("slot-span");

            filteredSlots.map((val) => {
              let slotTime = val.start_time.slice(11, 13);
              let getLeftTimeWithoutAM_PM = this.getLeftTimeWithoutAM_PM(i);
              if (slotTime == getLeftTimeWithoutAM_PM) {
                var a = cell.appendChild(document.createElement("a"));
                if (this.pageTitle == "Time Table") {
                  a.onclick = this.goToDetailPage.bind(this);
                  var sessionId = a.appendChild(document.createElement("SPAN"));
                  sessionId.classList.add("slot-id");
                  cellSlot = document.createTextNode(val.id);
                  sessionId.appendChild(cellSlot);
                  a.appendChild(sessionId);
                  span.appendChild(a);
                }
                a.classList.add("slot-anchor");

                if (this.selectColorClass % 2 == 0) {
                  a.classList.add("color-one");
                } else {
                  a.classList.add("color-two");
                }
                this.selectColorClass = this.selectColorClass + 1;

                var sp1 = a.appendChild(document.createElement("SPAN"));
                sp1.classList.add("slot-title");
                cellSlot = document.createTextNode(val.topic);
                sp1.appendChild(cellSlot);
                a.appendChild(sp1);
                span.appendChild(a);

                var sp2 = a.appendChild(document.createElement("SPAN"));
                sp2.classList.add("slot-time");
                cellSlot = document.createTextNode(val.time_am_pm);
                sp2.appendChild(cellSlot);
                a.appendChild(sp2);
                span.appendChild(a);
              }
            });
            cell.classList.add("tooltips");
          }

          cell.appendChild(cellText);
          row.appendChild(cell);
          tbl.appendChild(row);

          this.nextDay = moment(today).add(1, "days").toDate();
          this.previousDay = moment(today).add(-1, "days").toDate();
        }
      }
    },

    previous() {
      if (this.isMonthlyClicked) {
        let currentMonth = this.currentDate.getMonth();
        let currentYear = this.currentDate.getFullYear();
        currentYear = currentMonth === 0 ? currentYear - 1 : currentYear;
        currentMonth = currentMonth === 0 ? 11 : currentMonth - 1;
        this.currentDate = new Date(currentYear, currentMonth);
        this.showCalendar(currentMonth, currentYear);
      } else if (this.isWeeklyClicked) {
        moment.locale("en");
        this.previousMonthStartOfWeekDate = moment(
          this.previousMonthStartOfWeekDate
        )
          .add(-7, "days")
          .toDate();

        this.startOfWeek = moment(this.previousMonthStartOfWeekDate)
          .startOf("week")
          .toDate();
        this.endOfWeek = moment(this.previousMonthStartOfWeekDate)
          .endOf("week")
          .toDate();

        this.previousMonthStartOfWeekDate = this.startOfWeek;
        this.nextMonthStartOfWeekDate = this.endOfWeek;

        let tbl = document.getElementById("calendar-body");
        tbl.innerHTML = "";
        this.weekHeader = [];
        this.weekDate = [];
        while (this.startOfWeek < this.endOfWeek) {
          let strtwek = moment(this.startOfWeek, "YYYY/MM/DD");
          let startDayName = strtwek.format("ddd");
          // this.weekHeader.push(startDayName);
          this.weekHeader.push({
            name: startDayName,
            day: strtwek.format("D"),
          });
          this.weekDate.push(this.dateFormater(strtwek));

          this.startOfWeek = moment(this.startOfWeek).add(1, "days").toDate();
        }

        for (let i = 0; i < 24; i++) {
          let row = document.createElement("tr");
          let timeCell = document.createElement("td");
          timeCell.classList.add("no-border");
          let leftSideTime = this.getLeftTime(i);
          let timeCellText = document.createTextNode(leftSideTime);
          timeCell.appendChild(timeCellText);
          row.appendChild(timeCell);
          tbl.appendChild(row);
          this.weekDate.map((va) => {
            let check = moment(va, "YYYY/MM/DD");
            let date = check.format("D");
            let cell = document.createElement("td");

            // let cellText = document.createTextNode(date);
            let cellText = document.createTextNode("");
            let cellSlot = "";
            let filteredSlots = this.checkWeeklySlots(va);
            // done
            if (filteredSlots.length > 0) {
              var span = cell.appendChild(document.createElement("SPAN"));
              span.classList.add("slot-span");

              filteredSlots.map((val) => {
                let slotTime = val.start_time.slice(11, 13);
                let getLeftTimeWithoutAM_PM = this.getLeftTimeWithoutAM_PM(i);
                if (slotTime == getLeftTimeWithoutAM_PM) {
                  var a = cell.appendChild(document.createElement("a"));
                  if (this.pageTitle == "Time Table") {
                    a.onclick = this.goToDetailPage.bind(this);
                    var sessionId = a.appendChild(
                      document.createElement("SPAN")
                    );
                    sessionId.classList.add("slot-id");
                    cellSlot = document.createTextNode(val.id);
                    sessionId.appendChild(cellSlot);
                    a.appendChild(sessionId);
                    span.appendChild(a);
                  }
                  a.classList.add("slot-anchor");

                  if (this.selectColorClass % 2 == 0) {
                    a.classList.add("color-one");
                  } else {
                    a.classList.add("color-two");
                  }
                  this.selectColorClass = this.selectColorClass + 1;

                  var sp1 = a.appendChild(document.createElement("SPAN"));
                  sp1.classList.add("slot-title");
                  cellSlot = document.createTextNode(val.topic);
                  sp1.appendChild(cellSlot);
                  a.appendChild(sp1);
                  span.appendChild(a);

                  var sp2 = a.appendChild(document.createElement("SPAN"));
                  sp2.classList.add("slot-time");
                  cellSlot = document.createTextNode(val.time_am_pm);
                  sp2.appendChild(cellSlot);
                  a.appendChild(sp2);
                  span.appendChild(a);
                }
              });
              cell.classList.add("tooltips");
            }

            cell.appendChild(cellText);
            row.appendChild(cell);
            tbl.appendChild(row);
          });
        }
      } else {
        this.viewType = "day";
        let today = this.previousDay;
        this.dayHeader = [];

        this.currentYear = today.getFullYear();
        let months = [
          "Jan",
          "Feb",
          "Mar",
          "Apr",
          "May",
          "Jun",
          "Jul",
          "Aug",
          "Sep",
          "Oct",
          "Nov",
          "Dec",
        ];

        // filing data about month and in the page via DOM.
        this.currentMonth = months[today.getMonth()];

        moment.locale("en");

        let formattedDate = moment(today, "YYYY/MM/DD");
        let startDayName = formattedDate.format("ddd");
        this.dayHeader.push({
          name: startDayName,
          day: formattedDate.format("D"),
        });

        let tbl = document.getElementById("calendar-body");
        tbl.innerHTML = "";

        for (let i = 0; i < 24; i++) {
          let row = document.createElement("tr");
          let timeCell = document.createElement("td");
          timeCell.classList.add("no-border");
          let leftSideTime = this.getLeftTime(i);
          let timeCellText = document.createTextNode(leftSideTime);
          timeCell.appendChild(timeCellText);
          row.appendChild(timeCell);
          tbl.appendChild(row);

          let check = moment(today, "YYYY/MM/DD");
          let date = check.format("D");
          let cell = document.createElement("td");

          // let cellText = document.createTextNode(date);
          let cellText = document.createTextNode("");
          let cellSlot = "";
          let filteredSlots = this.checkDaySlots(this.dateFormater(today));
          // done
          if (filteredSlots.length > 0) {
            var span = cell.appendChild(document.createElement("SPAN"));
            span.classList.add("slot-span");

            filteredSlots.map((val) => {
              let slotTime = val.start_time.slice(11, 13);
              let getLeftTimeWithoutAM_PM = this.getLeftTimeWithoutAM_PM(i);
              if (slotTime == getLeftTimeWithoutAM_PM) {
                var a = cell.appendChild(document.createElement("a"));
                if (this.pageTitle == "Time Table") {
                  a.onclick = this.goToDetailPage.bind(this);
                  var sessionId = a.appendChild(document.createElement("SPAN"));
                  sessionId.classList.add("slot-id");
                  cellSlot = document.createTextNode(val.id);
                  sessionId.appendChild(cellSlot);
                  a.appendChild(sessionId);
                  span.appendChild(a);
                }
                a.classList.add("slot-anchor");

                if (this.selectColorClass % 2 == 0) {
                  a.classList.add("color-one");
                } else {
                  a.classList.add("color-two");
                }
                this.selectColorClass = this.selectColorClass + 1;

                var sp1 = a.appendChild(document.createElement("SPAN"));
                sp1.classList.add("slot-title");
                cellSlot = document.createTextNode(val.topic);
                sp1.appendChild(cellSlot);
                a.appendChild(sp1);
                span.appendChild(a);

                var sp2 = a.appendChild(document.createElement("SPAN"));
                sp2.classList.add("slot-time");
                cellSlot = document.createTextNode(val.time_am_pm);
                sp2.appendChild(cellSlot);
                a.appendChild(sp2);
                span.appendChild(a);
              }
            });
            cell.classList.add("tooltips");
          }

          cell.appendChild(cellText);
          row.appendChild(cell);
          tbl.appendChild(row);

          this.nextDay = moment(today).add(1, "days").toDate();
          this.previousDay = moment(today).add(-1, "days").toDate();
        }
      }
    },

    showCalendar(month, year) { 
      let today = new Date();
      let months = [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec",
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
            let cell = document.createElement("td");
            let cellText = document.createTextNode("");
            cell.appendChild(cellText);
            row.appendChild(cell);
            // break;
          } else {
            let cell = document.createElement("td");

            let cellText = document.createTextNode(date);
            let cellSlot = "";
            let filteredSlots = this.checkSlots(
              date < 10 ? `0${date}` : `${date}`
            );
            // Done
            if (filteredSlots.length > 0) {
              const rndInt = Math.floor(Math.random() * 5) + 1;

              // if want to show notepad image on calendar cell then uncomment below code

              // var img = cell.appendChild(document.createElement("img"));
              // console.log("img", img);
              // img.setAttribute("src", "./Images/note1.png");

              var span = cell.appendChild(document.createElement("SPAN"));
              span.classList.add("slot-span");

              filteredSlots.map((val) => {
                var a = cell.appendChild(document.createElement("a"));
                // go to detail page code start
                a.onclick = this.goToDetailPage.bind(this);
                var sessionId = a.appendChild(document.createElement("SPAN"));
                sessionId.classList.add("slot-id");
                cellSlot = document.createTextNode(val.id);
                sessionId.appendChild(cellSlot);
                a.appendChild(sessionId);
                span.appendChild(a);

                // go to detail page code end

                a.classList.add("slot-anchor");

                if (this.selectColorClass % 2 == 0) {
                  a.classList.add("color-one");
                } else {
                  a.classList.add("color-two");
                }
                this.selectColorClass = this.selectColorClass + 1;

                var sp1 = a.appendChild(document.createElement("SPAN"));
                sp1.classList.add("slot-title");
                cellSlot = document.createTextNode(val.topic);
                sp1.appendChild(cellSlot);
                a.appendChild(sp1);
                span.appendChild(a);

                var sp2 = a.appendChild(document.createElement("SPAN"));
                sp2.classList.add("slot-time");
                cellSlot = document.createTextNode(val.time_am_pm);
                sp2.appendChild(cellSlot);
                a.appendChild(sp2);
                span.appendChild(a);
              });
              cell.classList.add("tooltips");
            }
            if (
              date === today.getDate() &&
              year === today.getFullYear() &&
              month === today.getMonth()
            ) {
              // color today's date
              if (this.user.roleNames[0] == "admin") {
                var plusIcon = cell.appendChild(document.createElement("i"));
                plusIcon.classList.add("fas");
                plusIcon.classList.add("fa-plus");
                plusIcon.classList.add("slot-add-icon");
                plusIcon.classList.add(`${cellText.data}`);
                plusIcon.onclick = this.addSlot.bind(this);
              }

              cell.classList.add("today-color");
              var sp3 = cell.appendChild(document.createElement("SPAN"));
              sp3.classList.add("current-date");
              sp3.appendChild(cellText);
              cell.appendChild(sp3);
              row.appendChild(cell);
              date = date + 1;
            } else {
              if (
                date >= today.getDate() &&
                year >= today.getFullYear() &&
                month >= today.getMonth() &&
                this.user.roleNames[0] == "admin"
              ) {
                var plusIcon = cell.appendChild(document.createElement("i"));
                plusIcon.classList.add("fas");
                plusIcon.classList.add("fa-plus");
                plusIcon.classList.add("slot-add-icon");
                plusIcon.classList.add(`${cellText.data}`);
                plusIcon.onclick = this.addSlot.bind(this);
              }
              var sp3 = cell.appendChild(document.createElement("SPAN"));
              sp3.classList.add("date-integer");
              sp3.appendChild(cellText);
              cell.appendChild(sp3);
              row.appendChild(cell);
              date = date + 1;
            }
          }
        }

        tbl.appendChild(row); // appending each row into calendar body.
      }
    },
  },
  mixins: [formMixins],
};
</script>

