<template> 
   <v-sheet height="600">
           <v-calendar
             ref="monthCalendar"
             v-model="value"
             color="primary"
             type="month"
             :events="events"
             :event-color="getEventColor"
             :event-ripple="false"
             @change="getEvents"

             @click:event="showEvent" 
             @click:more="viewDay" 
             @click:date="viewDay" 

             @mousedown:event="startDrag"
             @mousedown:day="startTime"
             @mousemove:day="mouseMove"
             @mouseup:day="endDrag"
             @mouseleave.native="cancelDrag"
           >
           <template v-slot:event="{ event, timed, eventSummary }">
              <div class="v-event-draggable">
                <component :is="{ render: eventSummary }"></component>
              </div>
              <div v-if="timed" class="v-event-drag-bottom" @mousedown.stop="extendBottom(event)"></div>
              <div class="custom-p">{{ event.name }}{{' '}}{{time_am_pm(event.start)}} </div>
            </template>
           </v-calendar>
           <v-menu
          v-model="selectedOpen"
          :activator="selectedElement"
          offset-x
        >
          <v-card
            color="grey lighten-4"
            min-width="350px"
            flat
          >
            <v-toolbar
              :color="selectedEvent.color"
              dark
            >
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
              <span v-html="selectedEvent.teacher.first_name"  v-if="isTeacher && selectedEvent.teacher !=null"></span><br>
              <span v-html="selectedEvent.event_message"></span> <br>
              <span v-html="selectedEvent.start"></span>
            </v-card-text>
            <v-card-actions>
              <v-btn
                text
                color="secondary"
                @click.stop="deleteSlot"
                
              >
                Cancel
              </v-btn>
              <v-btn
                text
                color="secondary"
                @click.stop="openDetailModel"
                
              >
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
 </template>
 <script>
   import moment from 'moment';
   import formMixins from "../../../Mixins/form";
   import  timetable  from "../../molecules/timeTable/timetable.vue";
   export default {
     data: () => ({
      isStudent:false,
      isTeacher:false,
      currentMonthName:'',
      selectedOpen:false,
      selectedEvent:{},
      selectedElement:null,
      dragAttempt:0,
      type:'month',
     value: '',
     events: [],
     colors: [ '#4CAF50', '#FF9800', '#757575'],
     names: ['Meeting', 'Holiday', 'PTO', 'Travel', 'Event', 'Birthday', 'Conference', 'Party'],
     dragEvent: null,
     dragStart: null,
     createEvent: null,
     createStart: null,
     extendOriginal: null,
   }),
   props:{
    focus:String,
   },
   watch:{
    focus:function(val,oldVal){
      if(val ==''){
      this.value=val;
      this.$emit('calendar-today-title',this.currentMonthName );
      }
    },
   },
   methods: {
    deleteSlot(){
      this.$emit('delete-slot');
    },
    calendarTitle() {
      this.$emit('calendar-title',this.$refs.monthCalendar );
    },
    viewDay({ date }) {
      this.$emit('view-day',date);
    },
    startClass(){
      this.$emit('start-class');
    },
    openDetailModel(){
      this.$emit('open-detail-model');
    },
    closeModel(){
      this.$emit('close-model');
    },
    sendEmail(){
      this.$emit('send-email');
    },
    openEdit(){
      this.$emit('open-edit');
    },
    showEvent({ nativeEvent, event }) {
      this.$emit('current-zoom-link',event);
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
    changeType(val){
      this.$emit('change-type',val);
    },
     startDrag ({ event, timed }) {
      
       if (event  && !timed) {
 //console.log("we are in")
         this.dragEvent = event
         this.dragTime = null
         this.extendOriginal = null
       }
       if (this.dragAttempt>0) {
        

        }
        if (this.dragAttempt==0) {
          this.dragAttempt = 1;
        }
     },
     startTime (tms) {
     //  console.log("we are in",tms)
       const mouse = this.toTime(tms)
 
       if (this.dragEvent) {
         const start = this.dragEvent.start
         this.dragTime = mouse - start
       } 
       else {
 //         this.createStart = this.roundTime(mouse)
 //         this.createEvent = {
 //           name: `Event #${this.events.length}`,
 //           color: this.rndElement(this.colors),
 //           start: this.createStart,
 //           end: this.createStart,
 //           timed: false,
 //         }
 
 //         this.events.push(this.createEvent)
       }
     },
     extendBottom (event) {
       this.createEvent = event
       this.createStart = event.start
       this.extendOriginal = event.end
     },
     mouseMove (tms) {
       
       const mouse = this.toTime(tms)
       //console.log("mouse move working",tms.date)
       if (this.dragEvent ) {
         const start = this.dragEvent.start
         const end = this.dragEvent.end
         const duration = end - start
         const newStartTime = mouse - this.dragTime
         const newStart = this.roundTime(newStartTime)
         const newEnd = newStart + duration
         console.log("this.dragEvent.start",this.dragEvent.start)
         console.log("this.dragEvent.end",this.dragEvent.end)
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
 //         const mouseRounded = this.roundTime(mouse, false)
 //         const min = Math.min(mouseRounded, this.createStart)
 //         const max = Math.max(mouseRounded, this.createStart)
 
 //         this.createEvent.start = min
 //         this.createEvent.end = max
       }
     },
     endDrag () {
       this.dragTime = null
       this.dragEvent = null
       this.createEvent = null
       this.createStart = null
       this.extendOriginal = null
     },
     cancelDrag () {
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
     roundTime (time, down = true) {
       const roundTo = 15 // minutes
       const roundDownTime = roundTo * 60 * 1000
 
       return down
         ? time - time % roundDownTime
         : time + (roundDownTime - (time % roundDownTime))
     },
     toTime (tms) {
       return new Date(tms.year, tms.month - 1, tms.day, tms.hour, tms.minute).getTime()
     },
     getEventColor (event) {
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
     getEvents ({ start, end }) {
      this.$emit('set-focus',this.value);
      let formData = {};
        const events = [];
        if (this.$route.name=='studentCalendarDetail') {
          formData["student_id"] = this.$route.params.student_id;
          formData["submode"] = 'admin-student';
      }
      if(this.$route.name=='teacherCalendarDetail'){
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
        this.slots.map((data)=>{
          events.push({
          id:data.id,
          name: data.topic,
          color: this.colors[this.rnd(0, this.colors.length - 1)],
          start:new Date(data.start_date),
          end:new Date(data.end_date),
          timed:data.start_date,
          event_message:data.event_message,
          students:data.student,
          teacher:data.teacher,
          session_id:data.session_id,
          zoomLink: data.zoomLink,
          teacher:data.teacher,
          subject:data.subject,
        })
        });
      });
      
      this.events = events;
      //  const events = []
 
      //  const min = new Date(`${start.date}T00:00:00`).getTime()
      //  const max = new Date(`${end.date}T23:59:59`).getTime()
      //  const days = 1
      //  const eventCount = this.rnd(days, days + 20)
 
      //  for (let i = 0; i < eventCount; i++) {
      //    const timed = false
      //    const firstTimestamp = this.rnd(min, max)
      //    const secondTimestamp = 1 * 900000
      //    const start = firstTimestamp - (firstTimestamp % 900000)
      //    const end = start + secondTimestamp
 
      //    events.push({
      //      name: this.rndElement(this.names),
      //      color: this.rndElement(this.colors),
      //      start,
      //      end,
      //      timed,
      //    })
      //  }
 
      //  this.events = events
     },
     rnd (a, b) {
       return Math.floor((b - a + 1) * Math.random()) + a
     },
     rndElement (arr) {
       return arr[this.rnd(0, arr.length - 1)]
     },
   },
   mounted(){
    if (this.$route.name == 'studentCalendarDetail') {
      this.isStudent = false;
      this.isTeacher = true;
    }
    if (this.$route.name == 'teacherCalendarDetail') {
      this.isStudent = true;
      this.isTeacher = false;
    }
    this.currentMonthName = this.$refs.monthCalendar.title;
    this.calendarTitle();
   },
     mixins: [formMixins],
   }
 </script>
 