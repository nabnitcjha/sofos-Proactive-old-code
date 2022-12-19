<template>
  <div class="row list-student">
    <delete-modal @confirm-delete="confirmDelete" @close-modal="closeModal" :showDeleteModel="showDeleteModel"
      :userType="userType"></delete-modal>
    <div class="col-lg-12 mb-4">
      <!-- Simple Tables -->
      <b-overlay id="overlay-background" :show="show" :variant="variant" :opacity="opacity" :blur="blur" rounded="sm">
        <div class="col-12 make-right mb-4">
          <input class="form-control mr-sm-2 search col-lg-3" type="search" placeholder="Search" aria-label="Search"
            v-model="searchText" v-on:input="searchStudent" v-bind:disabled="!allowType" />
        </div>
        <div class="card list-card-height">
          <div class="
              card-header
              py-3
              d-flex
              flex-row
              align-items-center
              justify-content-between
            ">
            <h6 class="m-0 text-primary">Student Info</h6>

            <div>
              <button class="btn btn-orange" @click="$root.changeRoute('/add-student')">
                ADD STUDENT
              </button>
            </div>
          </div>
          <div class="table-responsive alignment-table">
            <table class="table table-flush">
              <thead class="thead-light">
                <tr>
                  <th>Name</th>
                  <th>Image</th>
                  <th>Contact</th>
                  <th>Email</th>
                  <th>Status</th>
                  <th>Parents</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(tblData, index) in tableData" :key="index">
                  <td @click.stop="
                    checkPermission(['update']) == true
                      ? $root.changeRoute('/student-detail/' + tblData.id)
                      : fakeClick
                  " style="cursor: pointer">
                    {{ tblData.first_name }}{{ " " }}{{ tblData.last_name }}
                  </td>
                  <td @click.stop="
                    checkPermission(['update']) == true
                      ? $root.changeRoute('/student-detail/' + tblData.id)
                      : fakeClick
                  " style="cursor: pointer">
                    <img class="img-profile rounded-corner" :src="
                      tblData.student_image == NULL
                        ? Student
                        : $root.getMedia(tblData.student_image)
                    " style="max-width: 60px" />
                  </td>
                  <td @click.stop="
                    checkPermission(['update']) == true
                      ? $root.changeRoute('/student-detail/' + tblData.id)
                      : fakeClick
                  " style="cursor: pointer">
                    {{ tblData.phone }}
                  </td>
                  <td @click.stop="
                    checkPermission(['update']) == true
                      ? $root.changeRoute('/student-detail/' + tblData.id)
                      : fakeClick
                  " style="cursor: pointer">
                    {{ tblData.email }}
                  </td>
                  <td>
                    <toggle-switch userType="student" :userId="tblData.id"
                      :checkStatus="tblData.isEnable == 0 ? 'true' : 'false'" @change-stuatus="changeStatus">
                    </toggle-switch>
                  </td>
                  <td>
                    <p v-if="tblData.parent != ''" v-for="(prnt, i) in tblData.parent" :key="i">
                      {{ prnt.first_name }}{{ " " }}{{ prnt.last_name }}
                    </p>
                <tr></tr>
                </td>
                </tr>
                <tr></tr>
              </tbody>
            </table>
            <p class="table-null" v-if="tableData && tableData.length == 0">
              No record found
            </p>
          </div>
          <!-- <div class="card-footer"></div> -->
        </div>

        <v-pagination v-if="paginationTotal > 1 && searchText == ''" v-model="paginationCurrent"
          :page-count="paginationTotal" @input="nextPage" :classes="bootstrapPaginationClasses"></v-pagination>
      </b-overlay>
    </div>
  </div>
</template>

<script>
import tableComponent from "../../../molecules/table/table";
import formTitle from "../../../molecules/common/formTitle";
import deleteModal from "../../../molecules/modals/delete.vue";
import formMixins from "../../../../Mixins/form";
import vPagination from "vue-plain-pagination";
import { mapGetters, mapActions } from "vuex";
import { Student } from "../../../../Assets/dashboard/index";
import "../style.css";
export default {
  data() {
    return {
      Student: Student,
      allowType: true,
      show: false,
      searchText: "",
      loading: true,
      tableData: [],
      deleteId: "",
      showDeleteModel: false,
      userType: "",
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
      paginationCurrent: 1,
      paginationTotal: "",
      titleInfo: {
        pageTitle: "Students",
        logo: "fa fa-plus",
        logoType: "icon",
        actionName: "Add-Student",
        btnBackColor: "#589A42",
        btnTxtColor: "#fff",
        routeUrl: "/add-student",
        allowAction: true,
      },
      tableData: [],
      editUrl: "/edit-student",
      apiType: "allStudent",
      inforUrl: "student-detail",
    };
  },
  components: {
    "table-com": tableComponent,
    "form-title": formTitle,
    "delete-modal": deleteModal,
    vPagination,
  },
  computed: {
    ...mapGetters({
      permissions: "permissions",
      isStudentAdd: "isStudentAdd",
      pageView: "pageView",
    }),
  },
  methods: {
    changeStatus(obj) {
      this.show = true;
      let formData = {};
      formData["student_id"] = obj.userId;
      formData["status"] = obj.status;
      axios.post("/api/studentEnableStatus", formData).then((response) => {
        this.getStudents(this.paginationCurrent);
        this.show = false;
      });
    },
    searchStudent(event) {
      if (event.target.value == "") {
        this.searchText = "";
        this.getStudents(this.paginationCurrent);
      } else {
        this.allowType = false;
        this.show = true;
        let formData = {};
        this.searchText = event.target.value;
        formData["searchText"] = event.target.value;
        axios.post("/api/getFilteredStudents", formData).then((response) => {
          this.tableData = response.data.result;
          this.allowType = true;
          this.show = false;
        });
      }
    },
    ...mapActions({
      studentAddStatus: "studentAddStatus",
    }),
    checkPermission(arr) {
      let boolValue = this.permissions.some((permission) => {
        return arr.includes(permission);
      });

      return boolValue;
    },
    nextPage() {
      this.getStudents(this.paginationCurrent);
    },
    async getStudents(event) {
      this.allowType = true;
      this.show = true;
      this.tableData = [];

      let stdData = await this.getRecord("student", event, true);
      this.tableData = stdData.data;

      this.studentAddStatus(false);
      this.paginationCurrent = stdData.current_page;
      this.paginationTotal = stdData.last_page;
      setTimeout(function () {
      }, 5000);

      this.show = false;
      if (this.isStudentAdd) {
        this.addStatus("Student added Successfully");
      }
      this.allowType = true;
      this.loading = false;
    },
    deleteData(id, userType) {
      this.deleteId = id;
      this.userType = userType;
      this.showDeleteModel = true;
    },
    closeModal() {
      this.showDeleteModel = false;
    },
    async confirmDelete() {
      let isDelete = "";
      isDelete = await this.deleteRecord("student", this.deleteId);
      if (isDelete.status == "ok") {
        this.closeModal();
        this.getStudents(1);
      }
    },
  },
  mounted() {
    this.getStudents(1);
  },
  mixins: [formMixins],
};
</script>
