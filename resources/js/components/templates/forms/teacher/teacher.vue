<template>
    <div class="row list-teacher">
       <delete-modal
      @confirm-delete="confirmDelete"
      @close-modal="closeModal"
      :showDeleteModel="showDeleteModel"
      :userType="userType"
    ></delete-modal>
      <div class="col-lg-12 mb-4">
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
        <!-- Simple Tables -->
        <div class="card list-card-height">
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
            <h6 class="m-0 text-primary">Teacher Info</h6>
            <!-- <input
            class="form-control mr-sm-2 search col-lg-3"
            type="search"
            placeholder="Search"
            aria-label="Search"
            v-model="searchText"
            v-on:input="searchTeacher"
            v-bind:disabled="!allowType"
          /> -->
            <div>
            <button
            class="btn btn-orange"
            @click="
              $root.changeRoute('/add-teacher')
            "
            >ADD TEACHER</button
          >
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
                  <!-- <th>Action</th> -->
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="(tblData, index) in tableData"
                  :key="index"
                 
                >
                  <td
                  @click.stop="
                    checkPermission(['update']) == true
                      ? $root.changeRoute('/teacher-detail/' + tblData.id)
                      : fakeClick
                  "
                  style="cursor: pointer"
                  >
                    {{ tblData.first_name }}{{ " " }}{{ tblData.last_name }}
                  </td>
                  <td
                  @click.stop="
                    checkPermission(['update']) == true
                      ? $root.changeRoute('/teacher-detail/' + tblData.id)
                      : fakeClick
                  "
                  style="cursor: pointer"
                  >
                <img class="img-profile rounded-corner" :src="
              tblData.teacher_image == NULL ? Teacher : $root.getMedia(tblData.teacher_image)
            "
            style="max-width: 60px"
          />
                </td>
                  <td
                  @click.stop="
                    checkPermission(['update']) == true
                      ? $root.changeRoute('/teacher-detail/' + tblData.id)
                      : fakeClick
                  "
                  style="cursor: pointer"
                  >{{ tblData.phone }}</td>
                  <td
                  @click.stop="
                    checkPermission(['update']) == true
                      ? $root.changeRoute('/teacher-detail/' + tblData.id)
                      : fakeClick
                  "
                  style="cursor: pointer"
                  >{{ tblData.email }}</td>
                  <td><toggle-switch 
                    userType="teacher" 
                    :userId="tblData.id"  
                    :checkStatus="tblData.isEnable==0?'true':'false'"
                    @change-stuatus="changeStatus"
                    ></toggle-switch></td>
                  <!-- <td
                    v-if="
                      checkPermission(['update']) || checkPermission(['delete'])
                    "
                  >
                    <span
                      @click.stop="
                        $root.changeRoute('/edit-teacher/'+tblData.id)
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
                      @click.stop="deleteData(tblData.id, tblData.first_name)"
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
              v-if="paginationTotal > 1  && searchText==''"
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
import tableComponent from "../../../molecules/table/table";
import formTitle from "../../../molecules/common/formTitle";
import deleteModal from "../../../molecules/modals/delete.vue";
import formMixins from "../../../../Mixins/form";
import vPagination from "vue-plain-pagination";
import { mapGetters ,mapActions} from "vuex";
import { Teacher } from "../../../../Assets/dashboard/index";
import "./teacher.css";
export default {
  data() {
    return {
      Teacher:Teacher,
      allowType:true,
      show:false,
      searchText: "",
      loading: true,
      tableData: [],
      selectedGrade: [],
      grades: [],
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
      isTeacherAdd:"isTeacherAdd",
      pageView:"pageView"
    }),
  },
  methods: {
    changeStatus(obj){
      this.show=true;
      let formData = {};
      formData["teacher_id"] = obj.userId;
      formData["status"] = obj.status;
      axios
        .post("/api/teacherEnableStatus", formData)
        .then((response) => {
          this.getTeachers(this.paginationCurrent);
          this.show=false;
        });
    },
    searchTeacher(event) {
      if(event.target.value==""){
        this.getTeachers(this.paginationCurrent);
      }else{
        this.allowType = false;
        this.show=true;
        let formData = {};
      formData["searchText"] = event.target.value;
      axios
        .post("/api/getFilteredTeachers", formData)
        .then((response) => {
          this.tableData = response.data.result;
          this.allowType=true;
          this.show=false;
        });
      }
    },
    ...mapActions({
            teacherAddStatus: "teacherAddStatus"
        }),
    checkPermission(arr) {
      let boolValue = this.permissions.some((permission) => {
        return arr.includes(permission);
      });

      return boolValue;
    },
    nextPage(){
      this.getTeachers(this.paginationCurrent);
    },
    async getTeachers(event) {
      this.allowType=true;
      this.show=true;
      this.tableData = [];
      let tchData = await this.getRecord("teacher", event, true); 
      this.tableData = tchData.data;
      this.teacherAddStatus(false);
      this.selectedGrade = '';
      this.grades = '';
      this.paginationCurrent = tchData.current_page;
      this.paginationTotal = tchData.last_page;
      setTimeout(function () {
      }, 5000);
      this.show=false;
      this.allowType=true;
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
      isDelete = await this.deleteRecord("teacher", this.deleteId);
      if (isDelete.status == "ok") {
        this.closeModal();
        this.getTeachers(1);
      }
    },
  },
  mounted() {
      // if(this.isTeacherAdd){
      //   this.addStatus('Teacher added Successfully');
      // }
    this.getTeachers(1);
  },
  mixins: [formMixins],
};
</script>
