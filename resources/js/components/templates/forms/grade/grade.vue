<template>
     <div class="row card-common-design">
      <delete-modal
      @confirm-delete="confirmDelete"
      @close-modal="closeModal"
      :showDeleteModel="showDeleteModel"
      :userType="userType"
    ></delete-modal>
      <div class="col-lg-12 mb-4 detail-card">
        <!-- Simple Tables -->
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
            <h6 class="m-0 font-weight-bold text-primary">Grade Info</h6>
          </div>
          <div class="table-responsive">
            <table class="table align-items-center table-flush">
              <thead class="thead-light">
                <tr>
                  <th>Class</th>
                  <th>ClassType</th>
                  <th>Subject</th>
                  <th>Teacher</th>
                  <th>Action</th>
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
                  <td>
                    {{ tblData.name }}
                  </td>
                  <td>
                    {{ tblData.ClassType }}
                  </td>
                  <td>
                    {{ tblData.subject.name }}
                  </td>
                  <td>
                    {{ tblData.teacher.first_name }} {{ " "
                    }}{{ tblData.teacher.middle_name }}{{ " "
                    }}{{ tblData.teacher.last_name }}
                  </td>

                  <td
                    class="tableIndex__page--data"
                    v-if="
                      checkPermission(['update']) || checkPermission(['delete'])
                    "
                  >
                    <span
                      @click.stop="
                        $root.changeRoute(editUrl + '/' + tblData.id)
                      "
                      class="pointer-hand"
                      v-if="checkPermission(['update'])"
                      ><i class="far fa-edit" style="color: #8bc34a"></i></span
                    >&nbsp;<span
                      class="action-seprator"
                      v-if="
                        checkPermission(['update']) &&
                        checkPermission(['delete'])
                      "
                      >|</span
                    >&nbsp;<span
                      @click.stop="deleteData(tblData.id, tblData.name)"
                      class="pointer-hand"
                      v-if="checkPermission(['delete'])"
                      ><i class="fas fa-trash-alt" style="color: #fe8b24"></i
                    ></span>
                  </td>
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
          <!-- <div class="card-footer"></div> -->
        </div>
      </div>
    </div>
</template>

<script>
import vPagination from "vue-plain-pagination";
import deleteModal from "../../../molecules/modals/delete.vue";
import { mapGetters } from "vuex";
import tableComponent from "../../../molecules/table/table";
import formTitle from "../../../molecules/common/formTitle";
import formMixins from "../../../../Mixins/form";
import "../style.css";
export default {
  data() {
    return {
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
      paginationCurrent: "",
      paginationTotal: "",
      loading: true,
      titleInfo: {
        pageTitle: "grades",
        logo: "fa fa-plus",
        logoType: "icon",
        actionName: "Add-grade",
        btnBackColor: "#589A42",
        btnTxtColor: "#fff",
        routeUrl: "/add-grade",
        allowAction: true,
      },
      tableData: [],
      editUrl: "/edit-grade",
      apiType: "allGrade",
      inforUrl: "grade-detail",
    };
  },
  computed: {
    ...mapGetters({
      permissions: "permissions",
    }),
  },
  components: {
    "table-com": tableComponent,
    "form-title": formTitle,
    "delete-modal": deleteModal,
    vPagination,
  },
  methods: {
    nextPage() {
      this.tableData = [];
      this.getAllGradeData(this.paginationCurrent);
    },
    async getAllGradeData(event) {
      this.tableData = [];
      this.tableData = await this.getRecord("grade", event, true);
      
      this.paginationCurrent = this.tableData.current_page;
      this.paginationTotal = this.tableData.last_page;
      this.loading = false;
    },
    async confirmDelete() {
      let isDelete = "";
      isDelete = await this.deleteRecord("grade", this.deleteId);

      if (isDelete.status == "ok") {
        this.closeModal();
        this.getAllGradeData(this.paginationCurrent);
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
    this.getAllGradeData(1);
  },
  mixins: [formMixins],
};
</script>
