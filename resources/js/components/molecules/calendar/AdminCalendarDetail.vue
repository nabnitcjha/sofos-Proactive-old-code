<template>
  <div class="row card-common-design teacher-class-detail">
     <b-spinner
      style="width: 3rem; height: 3rem"
      label="Large Spinner"
      variant="success"
      v-show="loading"
    ></b-spinner>
    
    <div class="col-lg-12 detail-card new-old-tab-card">
      <div class="card mb-4 mt-4 col-lg-12">
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
          <h6 class="m-0 font-weight-bold text-primary">
            {{ classDetails.subject.name }}
          </h6>
          <h6 class="m-0 font-weight-bold text-primary">
            {{ classDetails.topic }}
          </h6>
        </div>
        <div class="card-body col-lg-12">
          <form class="detail-form">
            <div class="form-group col-sm-6 col-lg-4">
              <label for="subjectTopic">Subject Topic</label>
              <span
                style=""
                class="form-control custom-border remove-border"
                id="subjectTopic"
                >{{ classDetails.topic }}</span
              >
            </div>
            <div class="form-group col-sm-6 col-lg-4">
              <label for="meetWith">Meet with | Join with</label>
              <div class="zoom-link">
                <input
                v-model="zoomLink"
                type="text"
                class="form-control remove-border"
                disabled="disabled"
                id="zoomlink"
                placeholder="add link"
                
              />
             <i class="fa fa-copy" @click.stop="copyZoomLink"></i>
              </div>
            </div>
             <div class="form-group col-sm-6 col-lg-4">
              <label for="meetWith">Teacher</label>
              <div class="teacher-list">
                <span
                  class="form-control custom-border remove-border"
                >
                  {{ classDetails.teacher.first_name }}{{ " " }}{{ classDetails.teacher.last_name }}
                </span>
              </div>
            </div>
            <div class="form-group col-sm-6 col-lg-4">
              <label for="meetWith">Students</label>
              <div class="student-list">
                <span
                  class="form-control custom-border remove-border"
                  v-for="(student, index) in studentList"
                  :key="index"
                >
                  {{ student.first_name }}{{ " " }}{{ student.last_name }}
                  {{ index + 1 == studentList.length ? "" : " , " }}
                </span>
              </div>
            </div>
            <div class="form-group col-sm-6 col-lg-12">
              <label for="assignment">Assignment</label>
              <div class="assignment-name-list" v-if="assessmentLists.length>0">
                <ul class="list-group col-sm-12 col-lg-6 text-justify">
                  <li
                    class="border-none remove-border"
                    v-for="(assmList, index) in assessmentLists"
                    :key="index"
                  >
                    {{ index + 1 }} {{ ".  " }}
                    {{ assmList.assessmentFile.original_filename }}
                  </li>
                </ul>
              </div>
              <p class="table-null" v-if="assessmentLists.length == 0" style="text-align:justify;">
              No record found
            </p>
            </div>
            <div class="form-group col-sm-6 col-lg-5" v-if="isPreviousClicked"> 
              <label for="timing">Timing</label>
              <span
                style=""
                class="form-control custom-border mb-2"
                v-for="(cls, index) in classes"
                :key="index"
              >
                &nbsp;&nbsp;<span class="all-class"
                  >{{ index + 1 }} {{ ".  " }} </span
                >&nbsp;&nbsp; {{ cls.start_date }}{{ "- "
                }}{{ cls.end_date }}&nbsp;&nbsp;<span
                  class="today-class"
                  v-if="cls.isToday == 'yes'"
                  >{{ cls.isToday == "yes" ? "today class" : "" }}</span
                ></span
              >
            </div>
         
          </form>
        </div>
      </div>
    </div>
    <div class="col-lg-12">
      <div
        class="
          d-sm-flex
          align-items-center
          justify-content-between
          mb-4
          mt-5
          col-lg-12
        "
      >
        <h1 class="h3 mb-0 text-gray-800">Notes</h1>
      </div>

      <div class="col-lg-12 detail-card">
        <div class="card mb-4 col-lg-12">
          <div class="card-body col-lg-12" v-if="teacherNotes.length>0">
            <form
              class="teacher-notes-list"
              v-for="(teachernote, index) in teacherNotes"
              :key="index"
            >
              <div class="form-group col-sm-11 col-lg-11 text-justify" v-if="teacherNotes.length>0">
                <span
                  v-bind:class="[
                    '',
                    teachernote.access_type == 'private'
                      ? 'private-type'
                      : 'public-type',
                  ]"
                  >{{ teachernote.access_type }}</span
                >
                <input
                  v-model="teachernote.notes"
                  type="text"
                  class="form-control"
                  id="teacherNotes"
                  disabled
                />
              </div>
             
            </form>
          </div>
           <p class="table-null" v-if="teacherNotes.length == 0" >
              No record found
            </p>
        </div>
      </div>

      <!-- assignment upload start -->
      <div
        class="
          d-sm-flex
          align-items-center
          justify-content-between
          mb-4
          col-lg-12
        "
      >
        <h1 class="h3 mb-0 text-gray-800">Assignments</h1>
      </div>
      <div class="col-lg-12 detail-card">
        <div class="card mb-4 col-lg-12">
          <div class="card-body col-lg-12">
            <div class="upload-card-body">
              <table class="table table-responsive col-sm-12 col-lg-6">
                <thead>
                  <tr>
                    <th scope="col" class="text-jutify">Title</th>
                    <th scope="col" class="text-jutify">Dead Line</th>
                  </tr>
                </thead>
                <tbody v-if="assessmentLists.length > 0">
                  <tr
                    class="custom-checkbox"
                    v-for="(assmList, index) in assessmentLists"
                    :key="index"
                  >
                    <th class="text-jutify td-font">
                      {{ assmList.assessmentFile.original_filename }}
                    </th>
                    <th class="text-jutify td-font">{{ assmList.deadline }}</th>
                  </tr>
                </tbody>
                <p
                  class="table-null"
                  v-if="assessmentLists.length == 0"
                  style="display: flex; justify-content: end"
                >
                  No record found
                </p>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- assignment upload end -->

      <!-- notes type assignment start -->
      <div
        class="
          d-sm-flex
          align-items-center
          justify-content-between
          mb-4
          col-lg-12
        "
      >
        <h1 class="h3 mb-0 text-gray-800">Study Resources</h1>
      </div>
      <div class="col-lg-12 detail-card">
        <div class="card mb-4 col-lg-12">
           
          <div class="card-body col-lg-12">
            <form>
              <div
                class="
                  form-group
                  col-sm-12 col-lg-12
                  text-justify-center
                  teacher-notes
                "
                v-if="teacherStudyResources.length>0"
              >
                <div
                  class="col-lg-3 topic-card"
                  v-for="(tsr, index) in teacherStudyResources"
                  :key="index"
                >
                  <h1 class="mb-4">{{ tsr.topic }}</h1>
                  <h5 class="mb-4">
                    {{ tsr.assessmentFile.original_filename }}
                  </h5>
                  <button
                    type="button"
                    class="btn btn-orange orange-color"
                    @click.stop="downloadStudyResources(tsr.assessmentFile.id)"
                  >
                    Download
                  </button>
                </div>
              
              </div>
            <p class="table-null" v-if="teacherStudyResources.length == 0" >
              No record found
            </p>
            </form>
          </div>
        </div>
      </div>
      <!-- notes type assignment end -->

      <!-- Assignment Solution start-->

      <div
        class="
          d-sm-flex
          align-items-center
          justify-content-between
          mb-4
          col-lg-12
        "
      >
        <h1 class="h3 mb-0 text-gray-800">Student's Response</h1>
      </div>

      <div class="col-lg-12 detail-card">
        <div class="card mb-4 col-lg-12">
          <div class="ml-3 col-lg-3 text-left">
            <h6>Assignment Solution</h6>
          </div>
          <div class="card-body col-lg-12 assignment-solution">
            <table class="table table-responsive">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Class</th>
                  <th scope="col">Student</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody v-if="studentResponse.length > 0">
                <tr v-for="(stdRes, index) in studentResponse" :key="index">
                  <th>{{ index + 1 }}</th>
                  <th>{{ classDetails.topic }}</th>
                  <th>
                    {{ stdRes.student.first_name }}{{ " "
                    }}{{ stdRes.student.middle_name }}{{ " "
                    }}{{ stdRes.student.last_name }}
                  </th>
                  <th>
                    <span
                      @click.stop="
                        downloadAssessment(stdRes.assessment_answer_file)
                      "
                      class="pointer-hand action-seprator"
                      v-if="checkPermission(['read'])"
                      ><i class="fas fa-download" style="color: #8bc34a"></i
                    ></span>
                  </th>
                </tr>
              </tbody>
            </table>
            <p class="table-null" v-if="studentResponse.length == 0" >
              No record found
            </p>
          </div>
        </div>
      </div>
      
      <!-- Assignment Solution end -->
    </div>
  </div>
  <!-- <div class="teacherClassDetail__page col-12">
    <div class="calendar-area">
      <calendar-component
        :teacher_id="teacher_id"
        :class_id="class_id"
        :subject_id="subject_id"
      ></calendar-component>
    </div>
  </div> -->
</template>

<script>
import vPagination from "vue-plain-pagination";
import { mapActions, mapGetters } from "vuex";
import formMixins from "../../../Mixins/form";
import "../../templates/forms/teacherClasses/teacherClasses.css";
import { Upload } from "../../molecules/admin/dashboard/Icons/index";
import deleteModal from "../../molecules/modals/delete.vue";

export default {
  data() {
    return {
      loading:false,
      zoomLink:'',
      classes: [],
      isNewClicked: true,
      isPreviousClicked: false,
      selectedAccessType: "private",
      accessTypes: [
        {
          name: "private",
        },
        {
          name: "public",
        },
      ],
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
      showProgress: false,
      Upload: Upload,
      allowAddNotes: false,
      classDetails: [],
      deadline: [],
      teacher_id: "",
      class_id: "",
      subject_id: "",
      teacherNote: "",
      teacherNotes: [],
      isEditClick: false,
      currentNoteId: "",
      userType: "",
      showDeleteModel: false,
      assessment_file: "",
      assessmentLists: [],
      studyResourcesList: [],
      studentResponse: [],
      study_resource_file: "",
      isViewAllClicked: false,
      teacherStudyResources: [],
      current_timetable_id: 0,
      current_teacher_id: 0,
      studentList: [],
      todayClassDetail: "",
    };
  },
  components: {
    "delete-modal": deleteModal,
    vPagination,
  },
  computed: {
    ...mapGetters({
      user: "user",
      permissions: "permissions",
    }),
  },
  methods: {
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
       ...mapActions({
      setPageTitle: "setPageTitle",
    }),
    getTeacherStudyResources() {
      let formData = {};
      formData["timetable_id"] = this.current_timetable_id;
      formData["teacher_id"] = this.current_teacher_id;
      axios.post("/api/teacherStudyResources", formData).then((response) => {
        this.teacherStudyResources = response.data.result;
      });
    },
    getTeacherNotes() {
      let formData = {};
      formData["timetable_id"] = this.current_timetable_id;
      formData["teacher_id"] = this.current_teacher_id;

      axios.post("/api/getTeacherNotes", formData).then((response) => {
        this.teacherNotes = response.data.result;
      });
    },

    downloadStudyResources(id) {
      this.assessmentID = id;
      location.href =
        window.location.origin + "/api/downloadFile/" + this.assessmentID;
    },
    downloadAssessment(id) {
      this.assessmentID = id;
      location.href =
        window.location.origin + "/api/downloadFile/" + this.assessmentID;
    },
    getStudentResponse() {
      let formData = {};
      formData["timetable_id"] = this.current_timetable_id;
      formData["teacher_id"] = this.current_teacher_id;
      axios.post("/api/getStudentResponse", formData).then((response) => {
        this.studentResponse = response.data.result;
      });
    },
    getStudyResourcesList() {
      let formData = {};
      if (this.isPreviousClicked) {
        formData["timetable_id"] = this.current_timetable_id;
        formData["teacher_id"] = this.current_teacher_id;
      } else {
        formData["timetable_id"] = this.current_timetable_id;
        formData["teacher_id"] = this.current_teacher_id;
      }

      formData["mode"] = "teacher-study-resources";
      axios
        .post("/api/getAssessmentAccordingGrade", formData)
        .then((response) => {
          this.studyResourcesList = response.data.result;
        });
    },
    getAssessmentLists() {
        
      let formData = {};
      formData["timetable_id"] = this.current_timetable_id;
      formData["teacher_id"] = this.current_teacher_id;
      formData["mode"] = "admin";
      axios
        .post("/api/getAssessmentAccordingGrade", formData)
        .then((response) => {
          this.assessmentLists = response.data.result;
        });
    },
  
    checkPermission(arr) {
      let boolValue = this.permissions.some((permission) => {
        return arr.includes(permission);
      });

      return boolValue;
    },
  
 
    getSessionDetails() {
        
        let formData = {};
        formData['timetable_id'] = this.$route.params.id;
      axios
        .post("/api/getSessionDetails",formData)
        .then((response) => {
            
         this.current_timetable_id = response.data.result[0].id;
         this.current_teacher_id = response.data.result[0].teacher_id;
         this.zoomLink = response.data.result[0].zoomLink;
          this.classDetails = response.data.result[0];
          this.studentList = response.data.result[0].student;
          this.getTeacherNotes();
          this.getAssessmentLists();
          this.getTeacherStudyResources();
          this.getStudentResponse();
        });
    },
 
  },
  mounted() {
    this.setPageTitle('Class Detail');
    this.getSessionDetails();
  },
  mixins: [formMixins],
};
</script>
