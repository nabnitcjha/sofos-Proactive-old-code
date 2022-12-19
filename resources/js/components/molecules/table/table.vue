<template>
  <div class="tableIndex__page">
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
    <table class="table table-responsive" v-if="!loading">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">Email</th>
          <th scope="col">Phone</th>
          <th scope="col">Country</th>
          <th scope="col">Address</th>
          <th
            scope="col"
            v-if="checkPermission(['update']) || checkPermission(['delete'])"
          >
            Action
          </th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="(tblData, index) in tableData.data"
          :key="index"
          @click.stop="
            checkPermission(['update']) == true
              ? $root.changeRoute('/' + inforUrl + '/' + tblData.id)
              : fakeClick
          "
          style="cursor: pointer"
        >
          <th class="tableIndex__page--data">{{ index + 1 }}</th>
          <th class="tableIndex__page--data">{{ tblData.full_name }}</th>
          <th class="tableIndex__page--data">{{ tblData.email }}</th>
          <th class="tableIndex__page--data">{{ tblData.phoneNumber }}</th>
          <th class="tableIndex__page--data">{{ tblData.country }}</th>
          <th class="tableIndex__page--data">{{ tblData.address }}</th>
          <th
            class="tableIndex__page--data"
            v-if="checkPermission(['update']) || checkPermission(['delete'])"
          >
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
              @click.stop="deleteData(tblData.id, tblData.full_name)"
              class="pointer-hand"
              v-if="checkPermission(['delete'])"
              ><i class="fas fa-trash-alt" style="color: #fe8b24"></i
            ></span>
          </th>
        </tr>
      </tbody>
    </table>
    <p
      class="table-null"
      v-if="tableData && tableData.data && tableData.data.length == 0"
    >
      No record found
    </p>
    <v-pagination
      v-if="paginationTotal > 1 && !loading"
      v-model="paginationCurrent"
      :page-count="paginationTotal"
      @input="nextPage"
      :classes="bootstrapPaginationClasses"
    ></v-pagination>
  </div>
</template>

<script>
import vPagination from "vue-plain-pagination";
import deleteModal from "../modals/delete";
import { mapGetters } from "vuex";
import formMixins from "../../../Mixins/form";
import "./style.css";
export default {
  props: {
    tableHeader: Array,
    editUrl: {
      type: String,
      default: "",
    },
    apiType: String,
    inforUrl: String,
  },

  data() {
    return {
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
    };
  },
  computed: {
    ...mapGetters({
      permissions: "permissions",
    }),
  },
  watch: {
    apiType: function (newVal, oldVal) {
      if (newVal == "activeTeacher") {
        this.getActiveTeacher(1);
      } else if (newVal == "activeStudent") {
        this.getActiveStudent(1);
      } else if (newVal == "allTeacher") {
        this.getAllTeacherData(1);
      } else if (newVal == "allStudent") {
        this.getAllStudentData(1);
      } else if (newVal == "allGrade") {
        this.getAllGradeData(1);
      } else if (newVal == "allSubject") {
        this.getAllSubjectData(1);
      } else if (newVal == "allTimeTable") {
        this.getAllTimeTableData(1);
      }
    },
  },
  mounted() {
    this.reloadTableData();
  },
  components: {
    "delete-modal": deleteModal,
    vPagination,
  },
  methods: {
    nextPage() {
      this.tableData = [];
      this.reloadTableData();
    },

    async getAllGradeData(event) {
      this.tableData = [];
      this.tableData = await this.getRecord("grade", event, true);
      this.paginationCurrent = this.tableData.current_page;
      this.paginationTotal = this.tableData.last_page;
      this.loading = false;
    },
    async getAllSubjectData(event) {
      this.tableData = [];
      this.tableData = await this.getRecord("subject", event, true);
      this.paginationCurrent = this.tableData.current_page;
      this.paginationTotal = this.tableData.last_page;
      this.loading = false;
    },
    async getAllTimeTableData(event) {
      this.tableData = [];
      this.tableData = await this.getRecord("timeTable", event, true);
      this.paginationCurrent = this.tableData.current_page;
      this.paginationTotal = this.tableData.last_page;
      this.loading = false;
    },

    async getAllStudentData(event) {
      this.tableData = [];
      this.tableData = await this.getRecord("student", event, true);
      this.paginationCurrent = this.tableData.current_page;
      this.paginationTotal = this.tableData.last_page;
      this.loading = false;
    },
    async getAllTeacherData(event) {
      this.tableData = [];
      this.tableData = await this.getRecord("teacher", event, true);
      this.paginationCurrent = this.tableData.current_page;
      this.paginationTotal = this.tableData.last_page;
      this.loading = false;
    },
    async getActiveTeacher(event) {
      this.loading = true;
      this.tableData = [];
      this.tableData = await this.getActiveRecord("teacher", event);

      this.paginationCurrent = this.tableData.current_page;
      this.paginationTotal = this.tableData.last_page;
      this.loading = false;
    },
    async getActiveStudent(event) {
      this.loading = true;
      this.tableData = [];
      this.tableData = await this.getActiveRecord("student", event);

      this.paginationCurrent = this.tableData.current_page;
      this.paginationTotal = this.tableData.last_page;
      this.loading = false;
    },

    checkPermission(arr) {
      let boolValue = this.permissions.some((permission) => {
        return arr.includes(permission);
      });

      return boolValue;
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
      if (this.apiType == "activeTeacher" || this.apiType == "allTeacher") {
        isDelete = await this.deleteRecord("teacher", this.deleteId);
      }
      if (this.apiType == "activeStudent" || this.apiType == "allStudent") {
        isDelete = await this.deleteRecord("student", this.deleteId);
      }
      if (isDelete.status == "ok") {
        this.closeModal();
        this.reloadTableData();
      }
    },
    reloadTableData() {
      if (this.apiType == "activeTeacher") {
        this.getActiveTeacher(this.paginationCurrent);
      } else if (this.apiType == "activeStudent") {
        this.getActiveStudent(this.paginationCurrent);
      } else if (this.apiType == "allTeacher") {
        this.getAllTeacherData(this.paginationCurrent);
      } else if (this.apiType == "allStudent") {
        this.getAllStudentData(this.paginationCurrent);
      } else if (this.apiType == "allGrade") {
        this.getAllGradeData(1);
      } else if (this.apiType == "allSubject") {
        this.getAllSubjectData(1);
      } else if (this.apiType == "allTimeTable") {
        this.getAllTimeTableData(1);
      }
    },
  },
  mixins: [formMixins],
};
</script>
