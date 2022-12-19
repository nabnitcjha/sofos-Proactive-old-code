<template>
  <div class="row add-grade card-common-design">
        <div class="col-lg-12 detail-card">
          <div class="card mb-4 grade-info col-lg-12">
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
              <h6 class="m-0 font-weight-bold text-primary">Grade Info</h6>
            </div>
            <div class="card-body col-lg-12">
              <form>
                <div class="form-group col-sm-6 col-lg-3">
                  <label for="gradeName">Class</label>
                  <input
                    v-model="name"
                    type="text"
                    class="form-control"
                    id="gradeName"
                    placeholder="class name"
                  />
                </div>
                <div class="form-group col-sm-6 col-lg-3">
                  <label for="teacherFirstName">Class Type</label>
                  <multiselect
                    v-model="selectedClassType"
                    :options="ClassTypes"
                    :close-on-select="false"
                    :searchable="true"
                    :allow-empty="false"
                    :preselect-first="false"
                    placeholder="Pick ClassType"
                    label="name"
                    track-by="name"
                    @input="updateselectedClassType"
                  ></multiselect>
                </div>
                <div class="form-group col-sm-6 col-lg-3">
                  <label for="gradesubjects">Subject</label>
                  <multiselect
                    v-model="selectedSubject"
                    :options="subjects"
                    :searchable="true"
                    :close-on-select="false"
                    :allow-empty="false"
                    :preselect-first="true"
                    label="name"
                    placeholder="Select Subject"
                    track-by="name"
                    @input="updateselectedSubject"
                  ></multiselect>
                </div>
                <div class="form-group col-sm-6 col-lg-3">
                  <label for="teacherName">Teacher Name</label>
                  <multiselect
                    v-model="selectedTeacher"
                    :options="teachers"
                    :searchable="true"
                    :close-on-select="false"
                    :allow-empty="false"
                    :preselect-first="false"
                    label="name"
                    placeholder="Select teacher"
                    track-by="name"
                    @input="updateselectedTeacher"
                  ></multiselect>
                </div>
                <div class="form-group col-sm-6 col-lg-3">
                  <label for="chooseSlots">Choose Slots</label>
                  <multiselect
                    v-model="selectedSlots"
                    :options="slots"
                    :searchable="true"
                    :close-on-select="false"
                    :allow-empty="false"
                    :preselect-first="false"
                    label="name"
                    placeholder="Select slot"
                    track-by="name"
                  ></multiselect>
                </div>

                <div class="form-group col-12">
                  <button
                    type="button"
                    class="btn btn-success"
                    @click="updateGrade"
                    v-if="titleInfo.pageType == 'edit'"
                  >
                    Update
                  </button>
                  <button
                    type="button"
                    class="btn btn-success"
                    @click="saveGrade"
                    v-else
                  >
                    Save
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
</template>
<script>
import "vue-multiselect/dist/vue-multiselect.min.css";
import formMixins from "../../../Mixins/form";
import formTitle from "../common/formTitle";
import "./grade.css";
export default {
  data() {
    return {
      selectedClassType: [],
      ClassTypes: [{ name: "one-to-one" }, { name: "group" }],
      name: "",
      selectedSubject: [],
      subjects: [],
      selectedTeacher: [],
      teachers: [],
      selectedSlots: [],
      slots: [],
      editData: [],
      isEditLoadFirstTime: true,
    };
  },
  props: {
    titleInfo: Object,
  },

  components: {
    "form-title": formTitle,
  },
  methods: {
    updateGrade() {
      let formData = {};
      formData["name"] = this.name;
      formData["ClassType"] = this.selectedClassType[0].name;
      formData["subject_id"] = this.selectedSubject[0].id;
      formData["teacher_id"] = this.selectedTeacher[0].id;
      formData["slot_id"] = this.$route.params.id;

      this.updateRecord("grade", formData, this.$route.params.id, "/grade");
    },
    saveGrade() {
      let formData = {};
      formData["name"] = this.name;
      formData["ClassType"] = this.selectedClassType.name;
      formData["subject_id"] = this.selectedSubject.id;
      formData["teacher_id"] = this.selectedTeacher.id;
      formData["slot_id"] = this.selectedSlots.id;
      this.addRecord("grade", formData, "/grade");
    },
    updateselectedSubject() {
      let formData = {};
      this.teachers = [];
      if (this.titleInfo.pageType == "edit" && this.isEditLoadFirstTime) {
        formData["subject_id"] = this.selectedSubject[0].id;
        // this.isEditLoadFirstTime = false;
      } else {
        this.selectedTeacher = [];
        formData["subject_id"] = this.selectedSubject.id;
      }

      axios.post("/api/teacherAccordingSubject", formData).then((res) => {
        if (res.data.result.length > 0) {
          res.data.result.map((val) => {
            this.teachers.push({
              id: val.id,
              name:
                val.first_name + " " + val.middle_name + " " + val.last_name,
            });
          });
        }
      });
    },
    updateselectedTeacher() {
      let formData = {};
      if (this.titleInfo.pageType == "edit" && this.isEditLoadFirstTime) {
        formData["subject_id"] = this.selectedSubject[0].id;
        formData["teacher_id"] = this.selectedTeacher[0].id;
        this.isEditLoadFirstTime = false;
      } else {
        formData["subject_id"] = this.selectedSubject.id;
        formData["teacher_id"] = this.selectedTeacher.id;
      }

      let slotData = [];

      axios.post("/api/teacherSlots", formData).then((res) => {
        if (res.data.result.length > 0) {
          res.data.result.map((val) => {
            if (val.used_slot == null) {
              slotData.push({
                id: val.id,
                name: val.start_date + " ~ " + val.end_date,
              });
            }
          });
        }

        this.slots = slotData;
      });
    },
    updateselectedClassType() {},
    async getSubjects(event) {
      this.subjects = await this.getRecord("subject", event, false);
      if (this.titleInfo.pageType == "edit") {
        this.getData();
      }
    },
    async getData() {
      this.editData = await this.getSpecificRecord(
        "grade",
        this.$route.params.id
      );

      this.name = this.editData.name;
      this.selectedClassType.push({
        name: this.editData.ClassType,
      });
      this.selectedSubject.push({
        id: this.editData.subject.id,
        name: this.editData.subject.name,
      });
      this.updateselectedSubject();
      this.selectedTeacher.push({
        id: this.editData.teacher.id,
        name:
          this.editData.teacher.first_name +
          " " +
          this.editData.teacher.middle_name +
          " " +
          this.editData.teacher.last_name,
      });

      if (this.editData.timetable != null) {
        this.selectedSlots.push({
          id: this.editData.timetable.id,
          name: this.editData.timetable.time_am_pm,
        });
      }

      this.updateselectedTeacher();
    },
  },
  created() {},
  mounted() {
    this.getSubjects(1);
  },
  mixins: [formMixins],
};
</script>
<style>
.grade .v-application--wrap {
  min-height: unset !important;
}
</style>