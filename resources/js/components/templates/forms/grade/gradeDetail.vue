<template>
  <div class="row card-common-design">
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
          <h6 class="m-0 font-weight-bold text-primary">General Information</h6>
        </div>
        <div class="card-body col-lg-12">
          <form class="detail-form">
            <div class="form-group col-sm-6 col-lg-4">
              <label for="className">Class</label>
              <span
                style="border: none; padding-left: 0; font-size: 12px"
                class="form-control"
                id="className"
                >{{ gradeName }}</span
              >
            </div>
            <div class="form-group col-sm-6 col-lg-4">
              <label for="classType">classType</label>
              <span
                style="border: none; padding-left: 0; font-size: 12px"
                class="form-control"
                id="classType"
                >{{ classType }}</span
              >
            </div>
            <div class="form-group col-sm-6 col-lg-4">
              <label for="teacherName">Teacher Name</label>
              <span
                style="border: none; padding-left: 0; font-size: 12px"
                class="form-control"
                id="teacherName"
                >{{ teacherName }}</span
              >
            </div>
            <div class="form-group col-sm-6 col-lg-4">
              <label for="subjects">Subjects</label>
              <span
                style="border: none; padding-left: 0; font-size: 12px"
                class="form-control"
                id="subjects"
                >{{ subjects }}</span
              >
            </div>
            <div class="form-group col-sm-6 col-lg-4">
              <label for="slots">Slots</label>
              <span
                style="border: none; padding-left: 0; font-size: 12px"
                class="form-control"
                id="slots"
                >{{ slots }}</span
              >
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-lg-12 detail-card">
      <div class="card mb-4 col-lg-12">
        <div class="card-header py-3 align-items-center card-header-mobo">
          <h6 class="m-0 font-weight-bold text-primary col-lg-3">
            Associated Student
          </h6>
          <input
            class="form-control mr-sm-2 search col-lg-3"
            type="search"
            placeholder="Search"
            aria-label="Search"
            v-model="searchText"
            v-on:input="searchStudent"
            v-if="students.length > 0"
          />
        </div>
        <div class="card-body col-lg-12">
          <div class="table-responsive">
            <table class="table align-items-center table-flush">
              <thead class="thead-light">
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone Number</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  class="custom-checkbox"
                  v-for="(student, index) in students"
                  :key="index"
                >
                  <td>
                    <input
                      style="position: inherit"
                      type="checkbox"
                      class="custom-control-input"
                      :checked="student.allotedclass.length >0 ? true : false"
                      :id="'cb' + `${index + 1}`"
                      @click="selectStudent($event, student)"
                    />
                    <label
                      class="custom-control-label"
                      :for="'cb' + `${index + 1}`"
                      >{{
                        student.first_name +
                        " " +
                        student.middle_name +
                        " " +
                        student.last_name
                      }}</label
                    >
                  </td>
                  <td>{{ student.email }}</td>
                  <td>{{ student.phone }}</td>
                </tr>
              </tbody>
            </table>
            <p class="table-null" v-if="students && students.length == 0">
              No record found
            </p>
          
          </div>
        </div>
      </div>
        <v-pagination
              v-if="paginationTotal > 1"
              v-model="paginationCurrent"
              :page-count="paginationTotal"
              @input="nextPage"
              :classes="bootstrapPaginationClasses"
            ></v-pagination>
    </div>
  </div>
</template>

<script>
import vPagination from "vue-plain-pagination";
import formMixins from "../../../../Mixins/form";
import "../style.css";

export default {
  data: function () {
    return {
      pre_student_id: "",
      pre_teacher_id: "",
      pre_subject_id: "",
      pre_slot_id: "",
      pre_grade_id: "",

      gradeName: "",
      classType: "",
      teacherName: "",
      subjects: "",
      slots: "",
      teacher_id: "",
      subject_id: "",
      slot_id: "",
      grade_id: "",
      searchText: "",
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
      students: [],
      tableData: [],
    };
  },
  components: {
    vPagination,
  },
  mounted() {
    this.getData();
  },
  mixins: [formMixins],
  methods: {
    cbclick(e) {
      var cb = e.srcElement || e.target;
      let cbxs = document.querySelectorAll(".custom-control-input");
      cbxs.forEach(function (a) {
        if (a.type && a.type == "checkbox" && a.id !== cb.id) {
          a.checked = false;
        }
      });
    },
    async getData() {
      let frmData = [];
      frmData = await this.getSpecificRecord("grade", this.$route.params.id);

      this.gradeName = frmData.name;
      this.classType = frmData.ClassType;
      this.teacherName =
        frmData.teacher.first_name +
        " " +
        frmData.teacher.middle_name +
        " " +
        frmData.teacher.last_name +
        " ";
      this.subjects = frmData.subject.name;
      this.slots = frmData.timetable.time_am_pm;
      this.teacher_id = frmData.teacher_id;
      this.subject_id = frmData.subject_id;
      this.slot_id = frmData.timetable.id;
      this.grade_id = frmData.id;
      this.getStudentForSlots(1);
    },

    nextPage() {
      this.getStudentWithTeacher(this.paginationCurrent);
    },
    getStudentForSlots(event) { 
      let formData = {};
      formData["teacher_id"] = this.teacher_id;
      formData["subject_id"] = this.subject_id;
      formData["slot_id"] = this.slot_id;
      let url = "/api/" + "get" + "studentForSlot" + "s" + "?page=" + event;
      axios.post(url, formData).then((response) => {
        this.students = response.data.result.data;
       
      });
    },
    getStudentWithTeacher(event) {
      let formData = {};
      formData["teacherId"] = this.teacher_id;
      let url = "/api/" + "get" + "AssociatedStudent" + "s" + "?page=" + event;
      axios.post(url, formData).then((response) => {
        this.students = response.data.result.data;
      });
    },
    searchStudent(event) {
      let formData = {};
      formData["searchText"] = event.target.value;
      formData["teacher_id"] = this.teacher_id;
      axios
        .post("/api/getFilteredAssociatedStudents", formData)
        .then((response) => {
          this.students = response.data.result.data;
        });
    },
    selectStudent(event, student) {
      
      if (this.classType == "one-to-one" || this.classType == "group") {
        if (this.pre_teacher_id != "" && this.classType != "group") {
          let preformData = {};
          preformData["student_id"] = this.pre_student_id;
          preformData["teacher_id"] = this.pre_teacher_id;
          preformData["subject_id"] = this.pre_subject_id;
          preformData["slot_id"] = this.pre_slot_id;
          preformData["grade_id"] = this.pre_grade_id;
          axios
            .post("/api/deleteAlotClass", preformData)
            .then((response) => {
              
            });
        }
        this.pre_student_id = student.id;
        this.pre_teacher_id = this.teacher_id;
        this.pre_subject_id = this.subject_id;
        this.pre_slot_id = this.slot_id;
        this.pre_grade_id = this.grade_id;
        this.cbclick(event);
      }

      let formData = {};
      formData["student_id"] = student.id;
      formData["teacher_id"] = this.teacher_id;
      formData["subject_id"] = this.subject_id;
      formData["slot_id"] = this.slot_id;
      formData["grade_id"] = this.grade_id;
      formData["mode"] = 'one-to-one';
      
      if (event.target.checked) {
        // this.addRecord("studentTeacher", formData);
        axios.post("/api/alotClass", formData).then((response) => {
          
        });
      } else {
        axios.post("/api/deleteAlotClass", formData).then((response) => {
          
        });
      }
    },
  },
};
</script>
