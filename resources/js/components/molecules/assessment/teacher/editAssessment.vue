<template>
  <div class="teacher-create-assessment col-md-12">
    <div class="form-row">
      <div class="form-group col-md-3">
        <label for="grade">Grade</label>
        <multiselect
          v-model="selectedGrade"
          :options="grades"
          :searchable="true"
          :close-on-select="false"
          :allow-empty="false"
          :preselect-first="false"
          label="name"
          placeholder="Select Grade"
          track-by="name"
          @input="updateSelectedGrade"
        ></multiselect>
      </div>
      <div class="form-group col-md-3">
        <label for="subject">Subject</label>
        <multiselect
          v-model="selectedSubject"
          :options="subjects"
          :searchable="true"
          :close-on-select="false"
          :allow-empty="false"
          :preselect-first="false"
          label="name"
          placeholder="Select Type"
          track-by="name"
          @input="updateSelectedSubject"
        ></multiselect>
      </div>
      <div class="form-group col-md-3">
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
      <div class="form-group col-md-3 custom-date-picker">
        <label for="submitedby">Submited By</label>
        <date-picker
          v-model="assessment.deadline"
          type="datetime"
          placeholder="Select datetime"
          format="YYYY-MM-DD hh:mm a"
        ></date-picker>
      </div>
    </div>
    <div
      class="form-group col-md-8"
      style="
        display: flex;
        justify-content: space-between;
        flex-direction: column;
      "
    >
      <label for="assessmentFile" class="col-2">Chosen file</label>
      <div
        class="col-4 form-control"
        style="
          display: flex;
          justify-content: space-between;
          align-items: center;
          cursor: pointer;
        "
        @click.stop="openImageBrowser"
      >
        <a>{{ assessment_file }}</a>
        <span style="margin-left: 15px"><i class="fa fa-edit"></i></span>
      </div>

      <input
        type="file"
        class="form-control"
        @change="handleFile"
        id="assessmentFile"
        v-bind:class="['form-control', hideFile == true ? 'hide-file' : '']"
      />
    </div>
    <div class="form-group col-12">
      <label for="remark">Remark</label>
      <textarea
        class="form-control"
        id="remark"
        rows="3"
        v-model="assessment.remark"
      ></textarea>
    </div>
    <button class="btn btn-success" @click.stop="updateAssessment">
      Create
    </button>
  </div>
</template>

<script>
import formMixins from "../../../../Mixins/form";
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      hideFile: true,
      selectedSubject: "",
      selectedType: "",
      selectedGrade: "",
      subjects: [],
      teacher_id: "",
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
  computed: {
    ...mapGetters({
      user: "user",
    }),
  },
  methods: {
    classRemove() {
      let achors = document.querySelectorAll(".hide-file");
      achors.forEach(function (a) {
        a.classList.remove("hide-file");
      });
    },
    updateSelectedGrade() {
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
    async getAssessment() {
      axios
        .get("/api/getAssessment/" + this.$route.params.assessmentID)
        .then((response) => {
          this.selectedGrade = {
            id: response.data.result[0].grade.id,
            name: response.data.result[0].grade.name,
          };
          this.selectedSubject = {
            id: response.data.result[0].subject.id,
            name: response.data.result[0].subject.name,
          };

          this.selectedType = this.types.find((o) => {
            return o.id == response.data.result[0].assessment_type_id;
          });

          this.assessment = {
            ...this.assessment,
            remark: response.data.result[0].remark,
          };
          this.assessment_file =
            response.data.result[0].assessmentFile.original_filename;

          this.assessment = {
            ...this.assessment,
            deadline: new Date(response.data.result[0].deadline),
          };
          this.loading = false;
        });
    },

  async  updateAssessment() {
      let date = await this.dateFormater(this.assessment.deadline);
      let time_am_pm = await this.dateFormater_AM_PM(this.assessment.deadline);
      var form = new FormData();
      form.append("subject_id", this.selectedSubject.id);
      form.append("assessment_type_id", this.selectedType.id);
      form.append("grade_id", this.selectedGrade.id);
      form.append("assessment_id", this.$route.params.assessmentID);
      form.append("assessment_file", this.assessment.assessment_file);
      form.append("deadline", date);
      form.append("time_am_pm", time_am_pm);
      form.append("remark", this.assessment.remark);
      axios.post("/api/updateTeacherAssessment", form).then((response) => {
           this.$router.go(-1);
      });
    },
    openImageBrowser() {
      $("#assessmentFile").click();
    },
    handleFile(e) {
        
      this.assessment = {
        ...this.assessment,
        assessment_file: e.target.files[0],
      };
      
      this.assessment_file = e.target.files[0].name;
    },
  },
  mounted() {
    this.loading = true;
    this.grades = this.user.teacher.grade;
    this.teacher_id = this.user.teacher.id;
    this.subjects = [];
    this.subjects = [
      {
        id: this.user.teacher.subject.id,
        name: this.user.teacher.subject.name,
      },
    ];
    this.getAssessment();
    this.loading = false;
  },
  mixins: [formMixins],
};
</script>
 <style scoped>
.hide-file {
  visibility: hidden;
}
</style>