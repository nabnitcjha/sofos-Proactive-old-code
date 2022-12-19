<template>
  <div class="row card-common-design">
    <div class="col-lg-12 mb-4 detail-card">
      <div class="card col-lg-12">
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
          <h6 class="m-0 font-weight-bold text-primary">Timetable Info</h6>
        </div>
        <div class="card-body col-lg-12">
          <form>
            <div class="form-group col-sm-6 col-lg-3">
              <label for="grade">Class</label>
              <multiselect
                v-model="selectedGrade"
                :options="grades"
                :searchable="true"
                :close-on-select="false"
                :allow-empty="false"
                :preselect-first="false"
                label="name"
                placeholder="Select Class"
                track-by="name"
                @input="updateSelectedGrade"
              ></multiselect>
            </div>

            <div class="form-group col-sm-6 col-lg-3">
              <label for="type">Type</label>
              <multiselect
                v-model="selectedType"
                :options="types"
                :searchable="true"
                :close-on-select="false"
                :allow-empty="false"
                :preselect-first="false"
                label="name"
                placeholder="Select Type"
                track-by="name"
                @input="updateSelectedType"
              ></multiselect>
            </div>

            <div class="form-group col-sm-6 col-lg-3 custom-date-picker">
              <label for="submitedby">DeadLine</label>
              <date-picker
                v-model="assessment.deadline"
                type="datetime"
                placeholder="Select datetime"
                format="YYYY-MM-DD hh:mm a"
              ></date-picker>
            </div>
            <div class="form-group col-sm-6 col-lg-3">
              <label for="teacherUploadFile" style="cursor: pointer"
                >File Upload</label
              >
              <input
                v-model="teacherAssessmentFile"
                type="text"
                class="form-control"
                id="teacherUploadFile"
                placeholder="upload file"
                @click.stop="openteacherFileDialog"
                style="caret-color: transparent; cursor: pointer"
              />
              <div class="custom-file">
                <input
                  type="file"
                  class="custom-file-input col-sm-6 col-lg-3"
                  id="customFile"
                  @change="handleFile"
                  style="visibility: hidden"
                />
                <label
                  class="custom-file-label"
                  for="customFile"
                  style="visibility: hidden"
                  id="teacher-assessment-file-upload"
                  >Choose file</label
                >
              </div>
            </div>

            <div class="form-group col-sm-6 col-lg-12">
              <label for="remark">Remark</label>
              <textarea
                class="form-control"
                id="remark"
                rows="3"
                v-model="assessment.remark"
              ></textarea>
            </div>

            <div class="form-group col-sm-6 col-lg-12">
              <button class="btn btn-success" @click.stop="createAssessment">
                Create
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import formMixins from "../../../../Mixins/form";
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      teacherAssessmentFile: "",
      selectedSubject: "",
      selectedType: "",
      selectedGrade: "",
      subjects: [],
      types: [
        { name: "Study Resources", id: "1" },
        { name: "Assignments", id: "2" },
        { name: "Other", id: "3" },
      ],
      grades: [],
      assessment: {
        subject_id: "",
        assessment_type_id: "",
        grade_id: "",
        assessment_file: "",
        deadline: "",
        remark: "",
      },
    };
  },
  watch: {
    teacherAssessmentFile: function (newval, oldval) {
      this.openTeacherFileDialog();
    },
  },
  computed: {
    ...mapGetters({
      user: "user",
    }),
  },
  methods: {
    openTeacherFileDialog() {
      if (this.teacherAssessmentFile == "") {
        return;
      }
      $("#teacher-assessment-file-upload").click();
      this.teacherAssessmentFile = "";
    },
    openteacherFileDialog() {
      $("#teacher-assessment-file-upload").click();
      this.teacherAssessmentFile = "";
    },
    getTeacherClassess() {
      axios
        .get("/api/getTeacherClassess/" + this.user.teacher.id)
        .then((response) => {
          this.grades = [];
          response.data.result.map((cls) => {
            this.grades.push({
              id: cls.id,
              name: cls.topic,
            });
          });
        });
    },
    async updateSelectedGrade() {
      this.loading = true;
      this.assessment = {
        ...this.assessment,
        grade_id: this.selectedGrade.id,
      };
    },
    updateSelectedType() {
      this.assessment = {
        ...this.assessment,
        assessment_type_id: this.selectedType.id,
      };
    },
    updateSelectedSubject() {
      this.assessment = {
        ...this.assessment,
        subject_id: this.selectedSubject.id,
      };
    },

    async createAssessment(e) {
      e.preventDefault();

      let date = await this.single_dateFormater(this.assessment.deadline);
      let time_am_pm = await this.single_dateFormater_AM_PM(
        this.assessment.deadline
      );
      var form = new FormData();
      form.append("assessment_type_id", this.assessment.assessment_type_id);
      form.append("grade_id", this.assessment.grade_id);
      form.append("assessment_file", this.assessment.assessment_file);
      form.append("deadline", date);
      form.append("time_am_pm", time_am_pm);
      form.append("remark", this.assessment.remark);

      this.addRecord("teacherAssessment", form, "/list-teacher-assessment");
    },
    openImageBrowser() {
      $("#submitedby").click();
    },
    handleFile(e) {
      this.assessment = {
        ...this.assessment,
        assessment_file: e.target.files[0],
      };
    },
  },
  mounted() {
    this.loading = true;
    this.getTeacherClassess();
    this.loading = false;
  },
  mixins: [formMixins],
};
</script>
 