<template>
<div class="row  card-common-design">
       <delete-modal
      @confirm-delete="confirmDelete"
      @close-modal="closeModal"
      :showDeleteModel="showDeleteModel"
      :userType="userType"
    ></delete-modal>
      <div class="col-lg-12 mb-4 detail-card sub-pagination">
        <!-- Simple Tables -->
        <b-overlay
          id="overlay-background"
          :show="show"
          :variant="variant"
          :opacity="opacity"
          :blur="blur"
          rounded="sm"
        >
        <div class="col-12 make-right mb-4">
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
            <h6 class="m-0 text-primary">Subject Info</h6>
            <!-- <input
            class="form-control mr-sm-2 search col-lg-3"
            type="search"
            placeholder="Search"
            aria-label="Search"
            v-model="searchText"
            v-on:input="searchSubject"
            v-bind:disabled="!allowType"
          />  -->
          <button
            class="btn btn-orange"
            @click="
              $root.changeRoute('/add-subject')
            "
            >ADD SUBJECT</button
          >
          </div>
         
          <div class="table-responsive">
            <table class="table align-items-center table-flush">
              <thead class="thead-light">
                <tr>
                  <th class="left-align">Name</th>
                  <!-- <th class="center-align">Action</th> -->
                </tr>
              </thead>
              <!-- @click.stop="
                    checkPermission(['update']) == true
                      ? $root.changeRoute('/' + inforUrl + '/' + tblData.id)
                      : fakeClick
                  " -->
              <tbody>
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
                  <td class="left-align">
                    {{ tblData.name }}
                  </td>
                
                  <!-- <td
                    class="tableIndex__page--data right-align"
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
                  </td> -->
                </tr>
              </tbody>
            </table>
            <p
              class="table-null"
              v-if="tableData && tableData.length == 0"
            >
              No record found
            </p>
            
          </div>
          <!-- <div class="card-footer"></div> -->
        </div>
        <v-pagination
              v-if="paginationTotal > 1"
              v-model="paginationCurrent"
              :page-count="paginationTotal"
              @input="nextPage"
              :classes="bootstrapPaginationClasses"
            ></v-pagination>
            </b-overlay>
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
      show:false,
      allowType:true,
      searchText:"",
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
        pageTitle: "subjects",
        logo: "fa fa-plus",
        logoType: "icon",
        actionName: "Add-subject",
        btnBackColor: "#589A42",
        btnTxtColor: "#fff",
        routeUrl: "/add-subject",
        allowAction: true,
      },
      tableData: [],
      editUrl: "/edit-subject",
      apiType: "allSubject",
      inforUrl: "subject-detail",
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
    searchSubject(event) {
      
      if(event.target.value==""){

        this.searchText='';
        this.getAllSubjectData(this.paginationCurrent);
      }else{
        
        this.allowType = false;
        this.show=true;
        let formData = {};
        this.searchText =  event.target.value;
      formData["searchText"] = event.target.value;
      axios
        .post("/api/getFilteredSubjects", formData)
        .then((response) => {
          
          this.tableData = response.data.result;
          this.allowType=true;
          this.show=false;
        });
      }
    },
    nextPage() {
      this.tableData = [];
      this.getAllSubjectData(this.paginationCurrent);
    },
    async getAllSubjectData(event) {
      this.allowType=true;
      this.show=true;
      this.tableData = [];
      axios.post("/api/getAllSubjects/"+"?page=" + event).then((response) => {  
        this.tableData =    response.data.result.data;
      this.paginationCurrent = response.data.result.current_page;
      this.paginationTotal = response.data.result.last_page;
      this.show=false;
      this.allowType=true;
      });

      // this.loading = false;
    },
    async confirmDelete() {
      let isDelete = "";
      isDelete = await this.deleteRecord("subject", this.deleteId);

      if (isDelete.status == "ok") {
        this.closeModal();
        this.getAllSubjectData(this.paginationCurrent);
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
    this.getAllSubjectData(1);
  },
  mixins: [formMixins],
};
</script>
