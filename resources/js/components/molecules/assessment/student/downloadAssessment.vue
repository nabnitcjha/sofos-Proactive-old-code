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
          <table class="table table-responsive">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Class</th>
                <th scope="col">Deadline</th>
                <th scope="col">Remark</th>
                <th scope="col"> Action</th>
              </tr>
            </thead>
            <tbody v-if="tableData.length > 0">
              <tr
                v-for="(tblData, index) in tableData"
                :key="index"
              >
                <th>{{ index + 1 }}</th>
                <th>{{ tblData.grade.name }}</th>
                <th>{{ tblData.time_am_pm }}</th>
                <th>{{ tblData.remark }}</th>
                <th>
                <span
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

</template>


<script>
import vPagination from "vue-plain-pagination";
import { mapGetters } from "vuex";
import formMixins from "../../../../Mixins/form";

export default {
  data() {
    return {
     
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
    
      tableData: [],
     
    };
  },
  computed: {
    ...mapGetters({
        user:'user',
      permissions: "permissions",
    }),
  },
  components: {
    vPagination,
  },
  methods: {
   nextPage(){

   },
    downloadAssessment(id) {
      this.assessmentID = id;
      location.href =
        window.location.origin + "/api/downloadFile/" + this.assessmentID;
    },
    checkPermission(arr) {
      let boolValue = this.permissions.some((permission) => {
        return arr.includes(permission);
      });

      return boolValue;
    },
     getAssessmentLists() {
      let formData = {};
      formData["student_id"] = this.user.student.id;
      axios
        .post("/api/getStudentAssessment", formData)
        .then((response) => {
          this.tableData = response.data.result;
        });
    },
  },
  mounted() {
      this.getAssessmentLists();
  },
  mixins: [formMixins],
};
</script>
<style>
.nav-pills .nav-item {
  cursor: pointer;
}
</style>
