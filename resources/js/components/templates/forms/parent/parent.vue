<template>
  <div class="row list-student">
 
    <div class="col-lg-12 mb-4">
      <!-- Simple Tables -->
      <div class="card">
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
          <h6 class="m-0 font-weight-bold text-primary">parent Info</h6>
        </div>
        <div class="table-responsive">
          <table class="table align-items-center table-flush">
            <thead class="thead-light">
              <tr>
                <th>Name</th>
                <th>Contact</th>
                <th>Email</th>
                
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="(tblData, index) in parents"
                :key="index"
                
              >
                <td>
                  {{ tblData.first_name }}{{ " " }}{{ tblData.last_name }}
                </td>
              
                <td>{{ tblData.phone }}</td>
                <td>{{ tblData.email }}</td>
             
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
import tableComponent from "../../../molecules/table/table";
import formTitle from "../../../molecules/common/formTitle";
import deleteModal from "../../../molecules/modals/delete.vue";
import formMixins from "../../../../Mixins/form";
import vPagination from "vue-plain-pagination";
import { mapGetters } from "vuex";
import "../style.css";
export default {
  data() {
    return {
      loading: true,
      parents: [],
      deleteId: "",
      showDeleteModel: false,
      userType: "",
      bootstrapPaginationClasses: {
        ul: "pagination",
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
      user: "user"
    }),
  },
  methods: {
    checkPermission(arr) {
      let boolValue = this.permissions.some((permission) => {
        return arr.includes(permission);
      });

      return boolValue;
    },
    async getParents() {
      axios.get("/api/getParent/"+this.user.parent.id).then((response) => {
             this.parents = response.data.result;
        });
    },
    
   
   
  },
  mounted() {
    this.getParents();
  },
  mixins: [formMixins],
};
</script>
