<template>
  <div class="calendar-slot-wrapper col-12">
    <delete-modal
      @confirm-delete="confirmDelete"
      @close-modal="closeModel"
      :showDeleteModel="showDeleteModel"
      :userType="userType"
    ></delete-modal>
    <vs-modal v-model="showStartModel" class="modal-ac">
      <div slot="modal-header" class="modal-header">
        <span class="hp-3-title">Meet with | Join with </span>
        <v-icon @click.stop="modalClose"> mdi-close-circle</v-icon>
      </div>
      <div slot="modal-body" class="modal-body">
        <div class="form-group col-sm-12 col-lg-12">
          <!-- <label for="meetWith">Meet with | Join with</label> -->
          <div class="zoom-link">
            <input
              v-model="zoomLink"
              type="text"
              class="form-control remove-border"
              id="zoomlink"
              placeholder="add link"
              @input="saveZoomLink"
            />
            <i class="fa fa-copy" @click.stop="copyZoomLink"></i>
          </div>
          <div
                          class="button btn-session pointer-hand col-3 mt-2 mx-auto go-to-link"
                          @click.stop="openLink"
                        >
                          Go to Link
                        </div>
          
        </div>
      </div>
      <div slot="modal-footer" class="modal-footer">
      </div>
    </vs-modal>
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
    <vs-modal v-model="editOpen" class="modal-ac update-modal">
      <div slot="modal-header" class="modal-header">
        <span class="hp-3-title">Update Slot </span>
        <v-icon @click.stop="modalClose"> mdi-close-circle</v-icon>
      </div>
      <div slot="modal-body" class="modal-body">
        <time-table :titleInfo="titleInfo" :currentEvent="currentEvent"></time-table>
      </div>
      <div slot="modal-footer" class="modal-footer" style="visibility:hidden;">
        <button type="button" class="btn btn-success" @click.stop="goToDetailPage">
          Yes
        </button>
        <button type="button" class="btn btn-danger" @click.stop="modalClose">
          No
        </button>
      </div>
    </vs-modal>
    <v-row class="fill-height">
      <v-col>
        <v-sheet height="64">
          <v-toolbar flat>
            <v-btn outlined class="mr-4" color="grey darken-2" @click.stop="setToday">
              Today
            </v-btn>
            <v-btn fab text small color="grey darken-2" @click.stop="prev">
              <v-icon small>
                mdi-chevron-left
              </v-icon>
            </v-btn>
            <v-btn fab text small color="grey darken-2" @click.stop="next">
              <v-icon small>
                mdi-chevron-right
              </v-icon>
            </v-btn>
            <v-toolbar-title v-if="$refs.calendar">
              {{ $refs.calendar.title }}
            </v-toolbar-title>
            <v-toolbar-title v-else>
              {{ calendarTitle }}
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <v-menu bottom right>
              <template v-slot:activator="{ on, attrs }">
                <v-btn outlined color="grey darken-2" v-bind="attrs" v-on="on">
                  <span>{{ typeToLabel[type] }}</span>
                  <v-icon right>
                    mdi-menu-down
                  </v-icon>
                </v-btn>
              </template>
              <v-list>
                <v-list-item @click.stop="type = 'day'">
                  <v-list-item-title>Day</v-list-item-title>
                </v-list-item>
                <v-list-item @click.stop="type = 'week'">
                  <v-list-item-title>Week</v-list-item-title>
                </v-list-item>
                <v-list-item @click.stop="type = 'month'">
                  <v-list-item-title>Month</v-list-item-title>
                </v-list-item>
                <v-list-item @click.stop="type = '4day'">
                  <v-list-item-title>4 days</v-list-item-title>
                </v-list-item>
              </v-list>
            </v-menu>
          </v-toolbar>
        </v-sheet>
        <calendar-month-drag-component v-if="type=='month'" 
        @change-type="currentType"
        @open-edit="openEdit"
        @send-email="sendEmail"
        @close-model="closeModel"
        @open-detail-model="openDetailModel"
        @view-day="monthViewDay"
        @calendar-title="calTitle"
        @set-focus="setFocus"
        @calendar-today-title="calendarTodayTitle"
        @start-class="startClass"
        @current-zoom-link="saveCurrentZoomLink"
        @delete-slot="deleteSlot"
        :focus="focus"
        ></calendar-month-drag-component>

        <v-sheet height="600" v-else>
          <v-calendar ref="calendar" v-model="focus" color="primary" :events="events" :event-color="getEventColor"
            :type="type" @click:event="showEvent" @click:more="viewDay" @click:date="viewDay" @change="updateRange"
            @mousedown:event="startDrag" @mousedown:time="startTime" @mousemove:time="mouseMove" @mouseup:time="endDrag"
            @mouseleave.native="cancelDrag">
            <template v-slot:event="{ event, timed, eventSummary }">
              <div class="v-event-draggable">
                <component :is="{ render: eventSummary }"></component>
              </div>
              <div v-if="timed" class="v-event-drag-bottom" @mousedown.stop="extendBottom(event)"></div>
              <div class="custom-p">{{ event.name }}{{' '}}{{time_am_pm(event.start)}} </div>
            </template>
          </v-calendar>
          <v-menu v-model="selectedOpen" :activator="selectedElement" offset-x v-if="type!='month'">
            <v-card color="grey lighten-4" min-width="350px" flat>
              <v-toolbar :color="selectedEvent.color" dark>
                <v-btn icon @click.stop="openEdit">
                  <v-icon>mdi-pencil</v-icon>
                </v-btn>
                <v-toolbar-title v-html="selectedEvent.name"></v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn icon @click.stop="sendEmail">
                  <v-icon>mdi-email</v-icon>
                </v-btn>
                <!-- <v-btn icon>
                <v-icon>mdi-dots-vertical</v-icon>
              </v-btn> -->
                <!-- <div  class="custom-p" v-if="isTeacher">{{ event.teacher.first_name }} </div> -->
              </v-toolbar>
              <v-card-text>
                <span v-html="selectedEvent.teacher.first_name"
                  v-if="isTeacher && selectedEvent.teacher !=null"></span><br>
                <span v-html="selectedEvent.event_message"></span> <br>
                <span v-html="selectedEvent.start"></span>
              </v-card-text>
              <v-card-actions>
                <v-btn text color="secondary" @click.stop="deleteSlot">
                  Cancel
                </v-btn>
                <v-btn text color="secondary" @click.stop="openDetailModel">
                  Detail
                </v-btn>
                <v-btn
                text
                color="secondary"
                @click.stop="startClass"
              >
                Zoom
              </v-btn>
              </v-card-actions>
            </v-card>
          </v-menu>
        </v-sheet>
      </v-col>
    </v-row>


  </div>
</template>
<script>
import moment from 'moment';
import formMixins from "../../../Mixins/form";
import timetable from "../../molecules/timeTable/timetable.vue";
import deleteModal from "../modals/delete.vue";
export default {
  data: () => ({
    showDeleteModel:false,
    currentEvent:{},
    currentZoomLink:'',
    showStartModel: false,
    monthCalendar:{},
    calendarTitle:'',
    startDragAttempt: 0,
    show: true,
    sessionId: '',
    event_message: '',
    openMeetwith: false,
    titleInfo: {},
    openDetail: false,
    editOpen: false,
    isStudent: false,
    isTeacher: false,
    focus: '',
    type: 'month',
    typeToLabel: {
      month: 'Month',
      week: 'Week',
      day: 'Day',
      '4day': '4 Days',
    },
    selectedEvent: {},
    zoomLink: "",
    selectedElement: null,
    selectedOpen: false,
    events: [],
    slots: [],
    colors: [ '#4CAF50', '#FF9800', '#757575'],
    names: ['Meeting', 'Holiday', 'PTO', 'Travel', 'Event', 'Birthday', 'Conference', 'Party'],
    dragEvent: null,
    dragStart: null,
    createEvent: null,
    createStart: null,
    extendOriginal: null,
  }),
 
  props: {
    // session: Array,
  },
  watch: {
    // session: function (newval, oldval) {
    //      if(newval!=''){
    //       this.editOpen=false;
    //       this.updateRange();
    //      }
    // }
  },

  components: {
    'time-table': timetable,
    "delete-modal": deleteModal,
  },
  mounted() {
    if (this.$route.name == 'studentCalendarDetail') {
      this.isStudent = false;
      this.isTeacher = true;
    }
    if (this.$route.name == 'teacherCalendarDetail') {
      this.isStudent = true;
      this.isTeacher = false;
    }
    this.$refs.calendar.checkChange()

  },
  // watch:{
  //   calendarTitle:function(val,oldVal){

  //   }
  // },
  methods: {
    async confirmDelete() {
      let isDelete = "";
      isDelete = await this.deleteRecord("SingleTimetable", this.current_timetable_id);
      if (isDelete.status == "ok") {
        this.closeModel();
        location.reload();
      }
    },
    deleteSlot(){
      this.showDeleteModel = true;
      this.userType=' this slot';
    },
    saveCurrentZoomLink(val){
      this.currentEvent = val;
      this.zoomLink = val.zoomLink;
      this.current_timetable_id = val.id;
    },
    startClass() {
      this.showStartModel = true;
    },
    emptyLink() {
      this.$toast.open({
        message: "Link is not added",
        type: "warning",
        duration: 5000,
        dismissible: true,
      });
    },
        openLink() {
      if (this.zoomLink!=null) {
        window.open(this.zoomLink)
      }else{
        this.emptyLink();
      }
    },
    zoomSaveSuccessfully() {
      this.$toast.open({
        message: "link save successfully",
        type: "success",
        duration: 5000,
        dismissible: true,
      });
    },
    saveZoomLink(e) {
      
      let formData = {};
      formData["zoomLink"] = e.target.value;
      formData["timetable_id"] = this.current_timetable_id;
      
      axios.post("/api/saveZoomLink", formData).then((response) => {
        
        this.zoomSaveSuccessfully();
      });
    },
    copyZoomLink() {
      /* Get the text field */
      var copyText = document.getElementById("zoomlink");

      /* Select the text field */
      copyText.select();
      copyText.setSelectionRange(0, 99999); /* For mobile devices */

      /* Copy the text inside the text field */
      navigator.clipboard.writeText(copyText.value);

      /* Alert the copied text */
      // alert( copyText.value);
    },
    calendarTodayTitle(val){
      this.calendarTitle = val;
    },
    setFocus(val){
       this.focus = val;
    },
    calTitle(val){
      this.calendarTitle = val.title;
      this.monthCalendar = val;
    },
    currentType(type) {
      this.type = type;
    },
    closeModel() {
      this.showStartModel = false;
      this.selectedOpen = false;
      this.openDetail = false;
      this.editOpen = false;
      this.showDeleteModel = false;
      // location.reload();
    },
    startDrag({ event, timed }) {

      if (event && timed) {
        this.dragEvent = event
        this.dragTime = null
        this.extendOriginal = null
      }

      if (this.startDragAttempt > 0) {
        
        let x = event.start;
        let y = this.start_end_time(event.start, event.end);
       
      }
      if (this.startDragAttempt == 0) {
        this.startDragAttempt = 1;
      }
    },
    startTime(tms) {

      const mouse = this.toTime(tms)

      if (this.dragEvent && this.dragTime === null) {
        const start = this.dragEvent.start

        this.dragTime = mouse - start
      } else {
        this.createStart = this.roundTime(mouse)
        // this.createEvent = {
        //   name: `Event-1 #${this.events.length}`,
        //   color: this.rndElement(this.colors),
        //   start: this.createStart,
        //   end: this.createStart,
        //   timed: true,
        // }

        // this.events.push(this.createEvent)
      }
    },
    mouseMove(tms) {
      const mouse = this.toTime(tms)

      if (this.dragEvent && this.dragTime !== null) {
        const start = this.dragEvent.start
        const end = this.dragEvent.end
        const duration = end - start
        const newStartTime = mouse - this.dragTime
        const newStart = this.roundTime(newStartTime)
        const newEnd = newStart + duration

        // this.dragEvent.start = newStart
        // this.dragEvent.end = newEnd
        
        this.dragEvent.start = new Date(newStart)
         this.dragEvent.end = new Date(newEnd)
         let formData = {};
         
        formData["id"] = this.dragEvent.id;
        formData["end_time"] = this.single_dateFormater(this.dragEvent.end);
        formData["start_time"] = this.single_dateFormater(this.dragEvent.start);
        formData["start_date"] = this.single_dateFormater(this.dragEvent.start);
        formData["end_date"] = this.single_dateFormater(this.dragEvent.end);
        formData["time_am_pm"] = this.start_end_time(this.dragEvent.start,this.dragEvent.end);
        
        axios.post("/api/updateDragTimeTable", formData).then((response) => {
        
         
      });

      } else if (this.createEvent && this.createStart !== null) {
        const mouseRounded = this.roundTime(mouse, false)
        const min = Math.min(mouseRounded, this.createStart)
        const max = Math.max(mouseRounded, this.createStart)

        this.createEvent.start = min
        this.createEvent.end = max
      }
    },

    extendBottom(event) {
      this.createEvent = event
      this.createStart = event.start
      this.extendOriginal = event.end
    },
    endDrag() {
      this.dragTime = null
      this.dragEvent = null
      this.createEvent = null
      this.createStart = null
      this.extendOriginal = null
    },
    cancelDrag() {
      if (this.createEvent) {
        if (this.extendOriginal) {
          this.createEvent.end = this.extendOriginal
        } else {
          const i = this.events.indexOf(this.createEvent)
          if (i !== -1) {
            this.events.splice(i, 1)
          }
        }
      }

      this.createEvent = null
      this.createStart = null
      this.dragTime = null
      this.dragEvent = null
    },
    roundTime(time, down = true) {
      const roundTo = 15 // minutes
      const roundDownTime = roundTo * 60 * 1000

      return down
        ? time - time % roundDownTime
        : time + (roundDownTime - (time % roundDownTime))
    },
    toTime(tms) {
      return new Date(tms.year, tms.month - 1, tms.day, tms.hour, tms.minute).getTime()
    },
    getEventColor(event) {
      const rgb = parseInt(event.color.substring(1), 16)
      const r = (rgb >> 16) & 0xFF
      const g = (rgb >> 8) & 0xFF
      const b = (rgb >> 0) & 0xFF

      return event === this.dragEvent
        ? `rgba(${r}, ${g}, ${b}, 0.7)`
        : event === this.createEvent
          ? `rgba(${r}, ${g}, ${b}, 0.7)`
          : event.color
    },
    getEvents({ start, end }) {
      const events = []

      const min = new Date(`${start.date}T00:00:00`).getTime()
      const max = new Date(`${end.date}T23:59:59`).getTime()
      const days = (max - min) / 86400000
      const eventCount = this.rnd(days, days + 20)

      for (let i = 0; i < eventCount; i++) {
        const timed = this.rnd(0, 3) !== 0
        const firstTimestamp = this.rnd(min, max)
        const secondTimestamp = this.rnd(2, timed ? 8 : 288) * 900000
        const start = firstTimestamp - (firstTimestamp % 900000)
        const end = start + secondTimestamp

        events.push({
          name: this.rndElement(this.names),
          color: this.rndElement(this.colors),
          start,
          end,
          timed,
        })
      }

      this.events = events
    },
    rnd(a, b) {
      return Math.floor((b - a + 1) * Math.random()) + a
    },
    rndElement(arr) {
      return arr[this.rnd(0, arr.length - 1)]
    },
    goToDetailPage() {
      this.$root.changeRoute('/student-session-detail/' + this.$route.params.student_id)
      this.openMeetwith = false;
    },
    openDetailModel() {
      this.sessionId = this.selectedEvent.session_id;
      this.event_message = this.selectedEvent.event_message;
      this.openMeetwith = true;
    },
    modalClose() {
      this.openMeetwith = false;
      this.closeModel();
    },
    openEdit() {
      this.selectedOpen = false;
      this.editOpen = true;
      this.titleInfo={'pageType':'edit'};
    },
    sendEmail() {
      let y = this.selectedEvent;
      this.addStatus('Email send successfully');
    },
    monthViewDay(date) {
      this.focus = date
      this.type = 'day'
    },
    viewDay({ date }) {
      this.focus = date
      this.type = 'day'
    },
    getEventColor(event) {
      return event.color
    },
    setToday() {
      this.focus = ''
      this.calendarTitle=this.monthCalendar.title;
    },
   async prev(){
      if(this.type=='month'){
        
      let pre = await  this.monthCalendar.prev();
        this.calendarTitle=this.monthCalendar.title;
      }else{
      this.$refs.calendar.prev()
      }
    },
  async  next() {
      if(this.type=='month'){
       let nex = await this.monthCalendar.next();
        this.calendarTitle=this.monthCalendar.title;
      }else{
      this.$refs.calendar.next()
      }
    },
    showEvent({ nativeEvent, event }) {
      this.currentEvent = event;
      this.zoomLink = event.zoomLink;
      this.current_timetable_id = event.id;
      const open = () => {
        this.selectedEvent = event
        this.selectedElement = nativeEvent.target
        requestAnimationFrame(() => requestAnimationFrame(() => this.selectedOpen = true))
      }
      if (this.selectedOpen) {
        this.selectedOpen = false
        requestAnimationFrame(() => requestAnimationFrame(() => open()))
      } else {
        open()
      }

      nativeEvent.stopPropagation()
    },
    updateRange() {

      // this.show = true;
      let formData = {};
      const events = [];
      if (this.$route.name == 'studentCalendarDetail') {
        formData["student_id"] = this.$route.params.student_id;
        formData["submode"] = 'admin-student';
      }
      if (this.$route.name == 'teacherCalendarDetail') {
        formData["teacher_id"] = this.$route.params.teacher_id;
        formData["submode"] = 'admin-teacher';
      }

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
        this.slots.map((data) => {
          events.push({
            id: data.id,
            name: data.topic,
            color: this.colors[this.rnd(0, this.colors.length - 1)],
            start: new Date(data.start_date),
            end: new Date(data.end_date),
            timed: data.start_date,
            event_message: data.event_message,
            students: data.student,
            teacher: data.teacher,
            session_id: data.session_id,
            zoomLink: data.zoomLink,
            teacher:data.teacher,
            subject:data.subject,
          })
        });
      });
      
      this.events = events;
      this.show = false;
      // const events = []

      // const min = new Date(`${start.date}T00:00:00`)
      // const max = new Date(`${end.date}T23:59:59`)
      // const days = (max.getTime() - min.getTime()) / 86400000
      // const eventCount = this.rnd(days, days + 20)

      // for (let i = 0; i < eventCount; i++) {
      //   const allDay = this.rnd(0, 3) === 0
      //   const firstTimestamp = this.rnd(min.getTime(), max.getTime())
      //   const first = new Date(firstTimestamp - (firstTimestamp % 900000))
      //   const secondTimestamp = this.rnd(2, allDay ? 288 : 8) * 900000
      //   const second = new Date(first.getTime() + secondTimestamp)

      //   events.push({
      //     name: this.names[this.rnd(0, this.names.length - 1)],
      //     start: first,
      //     end: second,
      //     color: this.colors[this.rnd(0, this.colors.length - 1)],
      //     timed: !allDay,
      //   })
      // }

      // this.events = events

    },
    rnd(a, b) {
      return Math.floor((b - a + 1) * Math.random()) + a
    },
  },
  mixins: [formMixins],
}
</script>