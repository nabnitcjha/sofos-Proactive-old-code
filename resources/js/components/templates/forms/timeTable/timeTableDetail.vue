<template>
  <div class="row card-common-design admin-timetable-detail">
    <delete-modal
      @confirm-delete="confirmDelete"
      @close-modal="closeModal"
      :showDeleteModel="showDeleteModel"
      :userType="userType"
    ></delete-modal>
    <delete-modal
      @confirm-delete="confirmDeleteAll"
      @close-modal="closeModal"
      :showDeleteModel="showDeleteModelAll"
      :userType="userType"
    ></delete-modal>
    <div class="col-12 make-right">
        <button type="button" class="btn btn-orange ml-2" @click="goBack">
          Back
        </button>
      </div>
    <!-- <div class="col-lg-12 mb-4 detail-card" v-if="pageView == 'table'">
      <b-overlay
        id="overlay-background"
        :show="show"
        :variant="variant"
        :opacity="opacity"
        :blur="blur"
        rounded="sm"
        class="col-lg-12"
      >
        <div class="card col-lg-12">
           
          <div class="session-header">
            <h5 class="title">
              <span
                >{{ classDetails.topic }} ({{ classDetails.subjectName }})</span
              >
               
            </h5>
            <div class="make-right">
              <span
                @click.stop="
                  $root.changeRoute(
                    editUrl + '/' + this.$route.params.session_id
                  )
                "
                class="pointer-hand"
                v-if="checkPermission(['update'])"
                ><i class="far fa-edit" style="color: #8bc34a"></i
              ></span>
              <button type="button" class="btn btn-orange ml-2" @click="goBack">
                Back
              </button>
            </div>
          </div>

          <div
            class="student-in-tb"
            v-if="
              user.roleNames[0] == 'student' || user.roleNames[0] == 'parent'
            "
          >
            <label for="meetWith">Teacher : </label>&nbsp;
            <div class="student-list">
              <span class="form-control">
                {{ timetableDetails[0].teacher.first_name }}{{ " "
                }}{{ timetableDetails[0].teacher.last_name }}
              </span>
            </div>
          </div>
          <div class="student-in-tb" v-else>
            <div class="custom-student-list">
              <div
                class="std-list st-1"
                v-for="(std, index) in students"
                :key="index"
              >
                <img
                  class="img-fluid"
                  :src="
                    std.student_image == null
                      ? adminImage
                      : $root.getMedia(std.student_image)
                  "
                />
                <span>{{ std.first_name }}{{ " " }}{{ std.last_name }}</span>
              </div>
            </div>
          </div>
          <div class="Session-detail mt-4">
            <h5 class="title sub-title text-justify">
              <span>Session Detail </span>
            </h5>
            <div class="session-detail-text text-left mt-3">
              {{ classDetails.event_message }}
            </div>
          </div>
          <hr />

          <div class="Session-uncomplete mt-4">
            <h5 class="title sub-title text-justify">
              <span>Classes </span><span></span>
            </h5>
            <div class="session-uncomplete-list">
              <div
                class="s-list mb-2"
                v-for="(tblData, index) in timetableDetails"
                :key="index"
              >
                <p>
                  {{ getDay(tblData.start_date) }}{{ "   :   " }}
                  {{ tblData.time_am_pm }} GMT
                </p>
                <a>
                   
                  &nbsp;<span
                    @click.stop="deleteData(tblData.id, tblData.subject.name)"
                    class="pointer-hand"
                    v-if="user.roleNames[0] == 'admin'"
                    ><i class="fas fa-trash-alt" style="color: #fe8b24"></i
                  ></span>
                </a>
              </div>
            </div>
          </div>
          <p
            class="table-null"
            v-if="timetableDetails && timetableDetails.length == 0"
          >
            No record found
          </p>
           
          <div class="col-sm-6 col-lg-12 text-justify">
            <button
              type="button"
              class="btn btn-danger pointer-hand"
              @click.stop="
                deleteDataAll($route.params.session_id, ' All Record')
              "
            >
              Delete
            </button>
          </div>
        </div>

        
      </b-overlay>
    </div> -->
    <div class="col-lg-12 detail-card">
     
      <calendar-slot-view-component
      ></calendar-slot-view-component>

    </div>
  </div>
</template>

<script>
import { Student } from "../../../../Assets/dashboard/index";
import { mapGetters } from "vuex";
import formMixins from "../../../../Mixins/form";
import deleteModal from "../../../molecules/modals/delete.vue";

export default {
  data() {
    return {
      total_slots:[],
      show: false,
      students: [],
      timetableDetails: [],
      adminImage: Student,
      showDeleteModel: false,
      showDeleteModelAll: false,
      editUrl: "/edit-class-schedule",
      userType: "",
      deleteId: "",
      classDetails: {},
      session: "",
    };
  },
  components: {
    "delete-modal": deleteModal,
  },
  computed: {
    ...mapGetters({
      user: "user",
      permissions: "permissions",
      pageView: "pageView",
    }),
  },
  methods: {
    async confirmDeleteAll() {
      let formData = {};
      formData["session_id"] = this.deleteId;
      axios.post("/api/deleteTimeTable", formData).then((response) => {
        this.showDeleteModelAll = false;
        this.$router.go(-1);
      });
      this.closeModalAll();
    },
    closeModalAll() {
      this.showDeleteModelAll = false;
    },
    deleteDataAll(id, userType) {
      this.deleteId = id;
      this.userType = userType;
      this.showDeleteModelAll = true;
    },
    getAllTimeTables() {
      
      this.students = [];
      let formData = {};
      if (this.$route.name=='studentCalendarDetail') {
      formData["student_id"] = this.$route.params.student_id;
      formData["mode"] = 'student';
      }
      if (this.$route.name=='teacherCalendarDetail') {
      formData["teacher_id"] = this.$route.params.teacher_id;
      formData["mode"] = 'teacher';
      }
      // formData["session_id"] = this.$route.params.session_id;
      // this.session = this.$route.params.session_id;
      
      axios.post("/api/getAllTimeTables", formData).then((response) => {
        
        // let x = this.user.roleNames[0];
        this.session = response.data.sessionIds;
        // if (this.timetableDetails.length > 0) {
        //   this.students = this.timetableDetails[0].student;
        //   this.classDetails = {
        //     topic: this.timetableDetails[0].topic,
        //     subjectName: this.timetableDetails[0].subject.name,
        //     time_am_pm: this.timetableDetails[0].time_am_pm,
        //     event_message: this.timetableDetails[0].event_message,
        //   };
        // }
        this.show = false;
      });
    },

    checkPermission(arr) {
      let boolValue = this.permissions.some((permission) => {
        return arr.includes(permission);
      });

      return boolValue;
    },

    closeModal() {
      this.showDeleteModel = false;
    },
    confirmDelete() {
      let formData = {};
      formData["id"] = this.deleteId;
      axios.post("/api/deleteSingleTimetable", formData).then((response) => {
        this.showDeleteModel = false;
        this.getAllTimeTables();
      });
    },

    deleteData(id, userType) {
      this.deleteId = id;
      this.userType = userType;
      this.showDeleteModel = true;
    },
  },
  mounted() {
    this.getAllTimeTables();
  },
  mixins: [formMixins],
};
</script>
<style>
.student-in-tb {
  display: flex;
  flex-wrap: wrap;
  margin-top: 5px;
}
.student-in-tb label {
  align-self: baseline;
  font-size: 16px;
  text-transform: uppercase;
  font-weight: 400;
}
.student-in-tb .student-list span {
  border: none;
  font-size: 12px;
  width: auto;
  padding: 1rem;
  background-color: #74ab62;
  color: #fff;
  line-height: 0;
  font-weight: 500;
  font-size: 13px;
  border-radius: 20px;
  margin-left: 10px;
}
.student-in-tb .student-list {
  display: flex;
  justify-content: space-between;
}
</style>