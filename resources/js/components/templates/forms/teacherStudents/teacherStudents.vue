<template>
  <div class="row card-common-design">
    <div class="col-lg-12 mb-4">
      <!-- Simple Tables -->
      <div class="card detail-card">
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
          <h6 class="m-0 font-weight-bold text-primary">Associated Students</h6>
        </div>
        <div class="table-responsive alignment-table">
          <table class="table table-flush">
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
                  {{
                    student.first_name +
                    " " +
                    student.last_name
                  }}
                </td>
                <td>{{ student.email }}</td>
                <td>{{ student.phone }}</td>
              </tr>
            </tbody>
          </table>
          <p
            class="table-null"
            v-if="tableData && tableData.data && tableData.data.length == 0"
          >
            No record found
          </p>
         
        </div>
        <!-- <div class="card-footer"></div> -->
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
import { mapGetters } from "vuex";
import formMixins from "../../../../Mixins/form";
export default {
  data() {
    return {
      students: [],
    };
  },
  computed: {
    ...mapGetters({
      user: "user",
    }),
  },
  methods: {
     getData() {
      axios
        .get("/api/getTeacherStudents/" + this.user.teacher.id)
        .then((response) => {
          this.students = response.data.result.student;
        });
    },
  },
  mounted() {
    this.getData();
  },
  mixins: [formMixins],
};
</script>
<style>
.timeTable .v-application--wrap {
  min-height: unset !important;
}
</style>