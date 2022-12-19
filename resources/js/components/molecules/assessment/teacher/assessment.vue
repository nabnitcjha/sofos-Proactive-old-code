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
          <h6 class="m-0 font-weight-bold text-primary">Assessment Info</h6>
        </div>
        <div class="card-body col-lg-12">
          <ul class="nav nav-pills custom-tab">
            <li class="nav-item">
              <a
                class="nav-link"
                v-bind:class="[
                  'nav-link',
                  isNewClicked == true ? 'active' : '',
                ]"
                @click.stop="menuClick('new')"
                >New</a
              >
            </li>
            <li class="nav-item">
              <a
                class="nav-link"
                v-bind:class="[
                  'nav-link',
                  isPreviousClicked == true ? 'active' : '',
                ]"
                @click.stop="menuClick('previous')"
                >Previous</a
              >
            </li>
          </ul>
           <div class="assignment-table mt-4" >
                      <table
                        class="table table-borderless table-responsive-md mt-3"
                      >
                        <thead>
                          <tr>
                            <!-- <th scope="col">Title</th> -->
                            <th scope="col">Created Date</th>
                            <th scope="col">Deadline</th>
                            <th scope="col">Files</th>
                            <th scope="col">Submitted</th>
                            <th scope="col">Submitted Date</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody v-if="tableData.length > 0">
                          <tr
                            class="custom-checkbox"
                            v-for="(tblData, index) in tableData"
                            :key="index"
                            @click.stop="
                              checkPermission(['update']) == true
                                ? $root.changeRoute('/' + inforUrl + '/' + tblData.id)
                                : fakeClick
                            "
                            style="cursor: pointer"
                          >
                            <!-- <td>{{ tblData.topic }}</td> -->
                            <td>{{ formatedDate(tblData.created_at) }}</td>
                            <td>{{ formatedDate(tblData.deadline) }}</td>
                            <td class="assignment-docs">
                              <span>
                                <i class="far fa-file-alt"></i>
                                {{
                                  tblData.assessmentFile.original_filename
                                }}</span
                              >
                            </td>
                            <td class="pointer-hand" v-if="tblData.assessmentsolution!=null" @click.stop="downloadAssessment(tblData.assessmentsolution.assessment_answer_file)">
                              {{tblData.solutionFile.original_filename}}</td>
                            <td v-else>{{' '}}</td>

                            <td v-if="tblData.submitted_date!=''">{{ formatedDate(tblData.submitted_date) }}</td>
                            <td v-else>{{' '}}</td>
              
                             <td>
                              <ul class="list-inline">
                                <a
                                  ><li class="list-inline-item">
                                    <img
                                    @click.stop="downloadAssessment(tblData.assessment_file)"
                                      class="img-fluid"
                                      :src="Download"
                                    /></li
                                ></a>
                               
                                <a
                                  ><li class="list-inline-item">
                                    <img class="img-fluid" :src="View" @click.stop="showDocument(tblData.assessment_file)"/></li
                                ></a>
                                <a
                                  ><li class="list-inline-item">
                                    <img class="img-fluid" :src="Delete"  @click.stop="deleteAssessment(tblData.id)"/></li
                                ></a>
                              </ul>
                            </td>
                          </tr>
                        </tbody>
                        <p
                          class="table-null"
                          v-if="tableData.length == 0"
                 
                        >
                          No record found
                        </p>
                       
                      </table>
                    </div>
          
        </div>
      </div>
       <v-pagination
            v-if="paginationTotal > 1 && !loading"
            v-model="paginationCurrent"
            :page-count="paginationTotal"
            @input="nextPage"
            :classes="bootstrapPaginationClasses"
          ></v-pagination>
    </div>
  </div>

  <!-- <div class="teacher-assessment col-12">
    <b-modal id="modal-1" title="Assessment Send" v-if="assignModal">
      <div class="form-group col-12">
        <multiselect
          v-model="selectedStudents"
          :options="students"
          :searchable="true"
          :multiple="true"
          :close-on-select="false"
          :allow-empty="false"
          :preselect-first="true"
          label="name"
          placeholder="Select Student"
          track-by="name"
          @input="updateSelectedStudent"
        ></multiselect>
      </div>
      <button class="btn btn-success" @click.stop="assignAssessment">
        Assign Assessment
      </button>
    </b-modal>
    <div class="text-center">
      <b-spinner
        style="width: 3rem; height: 3rem"
        label="Large Spinner"
        variant="success"
        v-show="loading"
      ></b-spinner>
    </div>
    <delete-modal
      @confirm-delete="confirmDelete"
      @close-modal="closeModal"
      :showDeleteModel="showDeleteModel"
      :userType="userType"
    ></delete-modal>
    <ul class="nav nav-pills">
      <li class="nav-item">
        <a
          class="nav-link"
          v-bind:class="['nav-link', isNewClicked == true ? 'active' : '']"
          @click.stop="menuClick('new')"
          >New</a
        >
      </li>
      <li class="nav-item">
        <a
          class="nav-link"
          v-bind:class="['nav-link', isPreviousClicked == true ? 'active' : '']"
          @click.stop="menuClick('previous')"
          >Previous</a
        >
      </li>
    </ul>
    <table class="table" v-if="!loading">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Class</th>
          <th scope="col">Deadline</th>
          <th scope="col">Remark</th>
          <th
            scope="col"
            v-if="checkPermission(['update']) || checkPermission(['delete'])"
          >
            Action
          </th>
        </tr>
      </thead>
      <tbody v-if="tableData.length > 0">
        <tr
          v-for="(tblData, index) in tableData"
          :key="index"
          @click.stop="
            checkPermission(['update']) == true
              ? $root.changeRoute('/' + inforUrl + '/' + tblData.id)
              : fakeClick
          "
          style="cursor: pointer"
        >
          <th>{{ index + 1 }}</th>
          <th>{{ tblData.grade.name }}</th>
          <th>{{ tblData.time_am_pm }}</th>
          <th>{{ tblData.remark }}</th>
          <th v-if="checkPermission(['update']) || checkPermission(['delete'])">
            <span
              @click.stop="$root.changeRoute(editUrl + '/' + tblData.id)"
              class="pointer-hand"
              v-if="checkPermission(['update'])"
              ><i class="far fa-edit" style="color: #8bc34a"></i></span
            >&nbsp;<span
              class="action-seprator"
              v-if="checkPermission(['update']) && checkPermission(['delete'])"
              >|</span
            >&nbsp;<span
              @click.stop="deleteData(tblData.id, tblData.grade.name)"
              class="pointer-hand action-seprator"
              v-if="checkPermission(['delete'])"
              ><i class="fas fa-trash-alt" style="color: #fe8b24"></i>|</span
            >&nbsp;<span
              @click.stop="downloadAssessment(tblData.assessment_file)"
              class="pointer-hand action-seprator"
              v-if="checkPermission(['read'])"
              ><i class="fas fa-download" style="color: #8bc34a"></i
            ></span>
          </th>
        </tr>
      </tbody>
    </table>
    <p class="table-null" v-if="tableData.length == 0">No record found</p>
    <v-pagination
      v-if="paginationTotal > 1 && !loading"
      v-model="paginationCurrent"
      :page-count="paginationTotal"
      @input="nextPage"
      :classes="bootstrapPaginationClasses"
    ></v-pagination>
  </div> -->
</template>

<script>
import vPagination from "vue-plain-pagination";
import deleteModal from "../../../molecules/modals/delete.vue";
import { mapGetters } from "vuex";
import formTitle from "../../../molecules/common/formTitle";
import formMixins from "../../../../Mixins/form";
import { Delete, Download, Edit, View } from "./img";
export default {
  data() {
    return {
      Delete: Delete,
      Download: Download,
      Edit: Edit,
      View: View,
      assignModal: false,
      selectedStudents: [],
      students: [],
      grade_id: "",
      subject_id: "",
      teacher_id: "",
      currentAssessmentId: "",
      clickedTab: "",
      isNewClicked: true,
      isPreviousClicked: false,
      deleteId: "",
      showDeleteModel: false,
      userType: "",
      assessmentID: "",
      assessmentID:"",
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
      loading: false,
      titleInfo: {
        pageTitle: "timeTables",
        logo: "fa fa-plus",
        logoType: "icon",
        actionName: "Add-timeTable",
        btnBackColor: "#589A42",
        btnTxtColor: "#fff",
        routeUrl: "/add-class-schedule",
        allowAction: true,
      },
      tableData: [],
      editUrl: "edit-teacher-assessment",
      apiType: "editTeacherAssessment",
      inforUrl: "edit-teacher-assessment-detail",
      currentAssessmentId:"",
      userType:""
    };
  },
  computed: {
    ...mapGetters({
      permissions: "permissions",
    }),
  },
  components: {
    "form-title": formTitle,
    "delete-modal": deleteModal,
    vPagination,
  },
  methods: {
    deleteAssessment(id) {
      this.currentAssessmentId = id;
      this.userType = "teacher-assessment";
      this.showDeleteModel = true;
    },
      showDocument(id){
       this.assessmentID = id;
      // location.href =
      //   window.location.origin + "/api/displayFile/" + this.assessmentID;
        window.open(window.location.origin + "/api/displayFile/" + this.assessmentID)
    },
     downloadAssessment(id) {
      this.assessmentID = id;
      location.href =
        window.location.origin + "/api/downloadFile/" + this.assessmentID;
    },
    assignAssessment() {
      let formData = {};
      formData["selectedStudents"] = this.selectedStudents;
      formData["assessment_id"] = this.currentAssessmentId;

      axios.post("/api/assignAssement", formData).then((response) => {
        this.assignModal = false;
      });
    },
    updateSelectedStudent() {},
    async getStudents() {
      let formData = {};
      formData["grade_id"] = this.grade_id;
      formData["subject_id"] = this.subject_id;
      formData["teacher_id"] = this.teacher_id;
      axios
        .post("/api/studentAccordingGradeSubject", formData)
        .then((response) => {
          let studentData = [];
          response.data.result.map((data) => {
            if (data.student != null) {
              studentData.push({
                id: data.student.id,
                name: data.student.full_name,
              });
            }
          });

          this.students = studentData;
        });
    },
    sendAssessment(tblData) {
      this.grade_id = tblData.grade_id;
      this.subject_id = tblData.subject_id;
      this.teacher_id = tblData.teacher_id;
      this.currentAssessmentId = tblData.id;
      this.getStudents();
      this.assignModal = true;
    },
    downloadAssessment(id) {
      this.assessmentID = id;
      location.href =
        window.location.origin + "/api/downloadFile/" + this.assessmentID;
    },

    menuClick(type) {
      if (type == "new" && this.isNewClicked == true) {
        return;
      }
      if (this.clickedTab == type) {
        return;
      }
      if (type == "new") {
        this.isPreviousClicked = false;
        this.isNewClicked = true;
      } else {
        this.isNewClicked = false;
        this.isPreviousClicked = true;
      }
      this.classRemove();
      this.clickedTab = type;
      console.log("before get assessment");
      this.getAssessment(1);
    },
    classRemove() {
      let achors = document.querySelectorAll(".active");
      achors.forEach(function (a) {
        a.classList.remove("active");
      });
    },
    getAssessment(event) {
      console.log("inside get assessment");
      this.tableData = [];
      let formData = {};
      if (this.isNewClicked) {
        formData["mode"] = "new";
      } else {
        formData["mode"] = "previous";
      }

      axios
        .post("/api/getAssessments" + "?page=" + event, formData)
        .then((response) => {
          this.tableData = response.data.result.data;
          this.paginationCurrent = response.data.result.current_page;
          this.paginationTotal = response.data.result.last_page;
          this.loading = false;
        });
    },
    async confirmDelete() {
      let isDelete = "";
      isDelete = await this.deleteRecord("assessment", this.deleteId);

      if (isDelete.status == "ok") {
        this.closeModal();
        this.getAssessment(this.paginationCurrent);
      }
    },
    closeModal() {
      this.showDeleteModel = false;
    },
    deleteData(id, userType) {
      this.deleteId = id;
      this.userType = userType;
      this.showDeleteModel = true;
    },
    checkPermission(arr) {
      let boolValue = this.permissions.some((permission) => {
        return arr.includes(permission);
      });

      return boolValue;
    },
  },
  mounted() {
    this.getAssessment(1);
  },
  mixins: [formMixins],
};
</script>
<style>
.nav-pills .nav-item {
  cursor: pointer;
}
</style>
