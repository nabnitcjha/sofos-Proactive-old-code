<template>
  <div class="row card-common-design">
    <delete-modal
      @confirm-delete="confirmDelete"
      @close-modal="closeModal"
      :showDeleteModel="showDeleteModel"
      :userType="userType"
    ></delete-modal>
    <b-overlay
          id="overlay-background"
          :show="show"
          :variant="variant"
          :opacity="opacity"
          :blur="blur"
          rounded="sm"
          class="col-lg-12"
        >
        <div class="col-12 make-right mb-4" v-if="pageView=='table'">
          <input
            class="form-control mr-sm-2 search col-lg-3"
            type="search"
            placeholder="Search"
            aria-label="Search"
            v-model="searchText"
            v-on:input="searchStudent"
            v-bind:disabled="!allowType"
          />
        </div>
    <div class="col-lg-12 mb-4 detail-card" v-if="pageView == 'table'">

      <div class="card col-lg-12 list-card-height">
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
          <h6 class="m-0 text-primary">Timetable Info</h6>
          <!-- <input
            class="form-control mr-sm-2 search col-lg-3"
            type="search"
            placeholder="Search"
            aria-label="Search"
            v-model="searchText"
            v-on:input="searchTeacher"
            v-bind:disabled="!allowType"
          /> -->
          <button
            class="btn btn-orange"
            @click="
              $root.changeRoute('/add-class-schedule')
            "
            >ADD CLASS SCHEDULE</button
          >
        </div>

        <div class="table-responsive">
          <table class="table align-items-center table-flush">
            <thead class="thead-light">
              <tr>
                <th>Subject</th>
                <th>Teacher</th>
                <th>Topic</th>

                <th>Time</th>
                <th>Created At</th>
                <!-- <th
                  v-if="
                    checkPermission(['update']) || checkPermission(['delete'])
                  "
                >
                  Action
                </th> -->
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="(tblData, index) in tableData"
                :key="index"
                @click.stop="
                  checkPermission(['update']) == true
                    ? goToDetail(tblData)
                    : fakeClick
                "
                style="cursor: pointer"
              >
                <td>{{ tblData.subjectName }}</td>
                <td>{{ tblData.teacherName }}</td>
                <td>{{ tblData.topic }}</td>

                <td>
                  {{ tblData.start_date.slice(0, 11) }}{{ " ( "
                  }}{{ tblData.time_am_pm }}{{ " )" }}
                </td>
                <td>{{ dateFormater(tblData.created_at) }}</td>
                <td
                  v-if="
                    checkPermission(['update']) || checkPermission(['delete'])
                  "
                >
                  <!-- <span
                    @click.stop="$root.changeRoute(editUrl + '/' + tblData.id)"
                    class="pointer-hand"
                    v-if="checkPermission(['update'])"
                    ><i class="far fa-edit" style="color: #8bc34a"></i></span
                  >&nbsp;<span
                    class="action-seprator"
                    v-if="
                      checkPermission(['update']) && checkPermission(['delete'])
                    "
                    >|</span
                  >&nbsp;<span
                    @click.stop="deleteData(tblData.id, tblData.className)"
                    class="pointer-hand"
                    v-if="checkPermission(['delete'])"
                    ><i class="fas fa-trash-alt" style="color: #fe8b24"></i
                  ></span> -->
                </td>
              </tr>
            </tbody>
          </table>
          <p class="table-null" v-if="tableData && tableData.length == 0">
            No record found
          </p>
        </div>
      </div>
    </div>
    <div class="col-lg-12 detail-card" v-else>
      <calendar-slot-view-component></calendar-slot-view-component>
    </div>
    <v-pagination
      v-if="paginationTotal > 1 && pageView == 'table'"
      v-model="paginationCurrent"
      :page-count="paginationTotal"
      @input="nextPage"
      :classes="bootstrapPaginationClasses"
    ></v-pagination>
  </b-overlay>
  </div>
</template>

<script>
import vPagination from "vue-plain-pagination";
import deleteModal from "../../../molecules/modals/delete.vue";
import { mapActions, mapGetters } from "vuex";
import tableComponent from "../../../molecules/table/table";
import formTitle from "../../../molecules/common/formTitle";
import formMixins from "../../../../Mixins/form";
import "../style.css";
export default {
  data() {
    return {
      allowType:true,
      show:false,
      searchText: "",
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
      editUrl: "/edit-class-schedule",
      apiType: "allTimeTable",
      inforUrl: "class-schedule-detail",
    };
  },
  computed: {
    ...mapGetters({
      permissions: "permissions",
      pageTitle: "pageTitle",
      pageView: "pageView",
    }),
  },
  components: {
    "table-com": tableComponent,
    "form-title": formTitle,
    "delete-modal": deleteModal,
    vPagination,
  },
  methods: {
    searchTeacher(event) {
      if (event.target.value == "") {
        this.searchText = "";
        this.getAllTimeTableData(this.paginationCurrent);
      } else {
        this.allowType = false;
        this.show=true;
        let formData = {};
        formData["searchText"] = event.target.value;

        axios.post("/api/getFilteredTimetable", formData).then((response) => {
          let filterData = response.data.result.filter(
            (word) => word.textMatch == true
          );

          this.tableData = filterData;
          this.allowType=true;
          this.show=false;
        });
      }
    },
    ...mapActions({
      setPageTitle: "setPageTitle",
    }),
    goToDetail(tblData) {
      this.setPageTitle("Timetable Detail");
      this.$router.push("/" + this.inforUrl + "/" + tblData.session_id);
    },
    nextPage() {
      this.tableData = [];
      this.getAllTimeTableData(this.paginationCurrent);
    },
    async getAllTimeTableData(event) {
      this.allowType=false;
          this.show=true;
      this.tableData = [];
      let ttdata = await this.getRecord("timeTable", event, true);
      this.tableData = ttdata.data;
      this.paginationCurrent = ttdata.current_page;
      this.paginationTotal = ttdata.last_page;
      this.allowType=true;
          this.show=false;
      this.loading = false;
    },
    async confirmDelete() {
      let isDelete = "";
      isDelete = await this.deleteRecord("timeTable", this.deleteId);

      if (isDelete.status == "ok") {
        this.closeModal();
        this.getAllTimeTableData(this.paginationCurrent);
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
    this.getAllTimeTableData(1);
  },
  mixins: [formMixins],
};
</script>
