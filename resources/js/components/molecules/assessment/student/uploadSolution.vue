<template>
  <div class="row card-common-design student-class-detail">
    <!-- assignment upload start -->
    <div class="col-lg-12 detail-card">
      <div class="card mb-4 col-lg-12">
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
          <h6 class="m-0 font-weight-bold text-primary">Upload Solution</h6>
        </div>
        <div class="card-body col-lg-12">
          <div class="upload-card-body">
            <ul class="list-group col-sm-12 col-lg-6 text-justify">
              <li
                class="list-group-item custom-checkbox"
                v-for="(assmList, index) in assessmentLists"
                :key="index"
              >
                <input
                  style="position: inherit"
                  type="checkbox"
                  v-bind:disabled="assmList.assessmentsolution == null ? false : true"
                  v-bind:class="[
                    '',
                     assmList.assessmentsolution == null
                        ? 'assessment-checkbox'
                        : 'always-checked',
                ]"
                  :id="'cb' + `${index + 1}`"
                  :checked="assmList.assessmentsolution == null ? false : true"
                  @click="selectAssessment($event, assmList)"
                />&nbsp;
                {{ assmList.assessmentFile.original_filename }}
              </li>
            </ul>
            <form class="col-sm-12 col-lg-6 make-center dark-background">
              <div
                class="form-group text-center pointer-hand"
                @click.stop="openFileUploadDialog"
              >
                <img :src="Upload" alt="" />
                <p>Drag and upload your file</p>
              </div>
              <div class="progress" v-if="showProgress">
                <div
                  class="progress-bar"
                  role="progressbar"
                  style="width: 100%"
                  aria-valuenow="25"
                  aria-valuemin="0"
                  aria-valuemax="100"
                >
                  100%
                </div>
              </div>
            </form>
          </div>
          <div class="space-between">
            <div class="form-group" style="visibility: hidden">
              <label for="student-assignment-upload">Example file input</label>
              <input
                type="file"
                class="form-control-file"
                id="student-assignment-upload"
                @change="handleFile"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- assignment upload end -->
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import formMixins from "../../../../Mixins/form";
import "../../../templates/forms/studentClasses/studentClasses.css";
import { Upload } from "../../../molecules/admin/dashboard/Icons/index";
import deleteModal from "../../../molecules/modals/delete.vue";

export default {
  data() {
    return {
      showProgress: false,
      Upload: Upload,
      allowAddNotes: false,
      classDetails: [],
      deadline: [],
      student_id: "",
      class_id: "",
      subject_id: "",
      studentNote: "",
      studentNotes: [],
      isEditClick: false,
      currentNoteId: "",
      userType: "",
      showDeleteModel: false,
      assessment_file: "",
      assessmentLists: [],
      currentAssessmentId: "",
      studyResourcesList: [],
    };
  },
  components: {
    "delete-modal": deleteModal,
  },
  computed: {
    ...mapGetters({
      user: "user",
      permissions: "permissions",
    }),
  },
  methods: {
    cbclick(e) {
      var cb = e.srcElement || e.target;
      let cbxs = document.querySelectorAll(".assessment-checkbox");
      cbxs.forEach(function (a) {
        if (a.type && a.type == "checkbox" && a.id !== cb.id) {
          a.checked = false;
        }
      });
    },
    selectAssessment(event, assmList) {
      this.cbclick(event);
      if (event.target.checked) {
        this.currentAssessmentId = assmList.id;
      }
    },
    getAssessmentLists() {
      let formData = {};
      formData["student_id"] = this.user.student.id;
      axios.post("/api/getStudentAssessment", formData).then((response) => {
        this.assessmentLists = response.data.result;
      });
    },

    openFileUploadDialog() {
      $("#student-assignment-upload").click();
    },
    handleFile() {
      this.assessment_file =
        document.querySelector("input[type=file]").files[0];
      this.showProgress = true;
      this.saveAssessmentAnswer();
    },

    checkPermission(arr) {
      let boolValue = this.permissions.some((permission) => {
        return arr.includes(permission);
      });

      return boolValue;
    },

    async saveAssessmentAnswer() {
      var form = new FormData();
      form.append("assessment_id", this.currentAssessmentId);
      form.append("student_id", this.user.student.id);
      form.append("assessment_answer_file", this.assessment_file);

      axios.post("/api/addAssessmentSolution", form).then((response) => {
        this.getAssessmentLists();
      });

      this.showProgress = false;
    },
  },
  mounted() {
    this.getAssessmentLists();
  },
  mixins: [formMixins],
};
</script>
