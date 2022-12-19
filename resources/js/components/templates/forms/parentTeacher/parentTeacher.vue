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
          <h6 class="m-0 font-weight-bold text-primary">Associated Teachers</h6>
        </div>
        <div class="table-responsive">
          <table class="table align-items-center table-flush">
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
                v-for="(tec, index) in teachers"
                :key="index"
              >
                <td>
                  {{
                    tec.first_name +
                    " " +
                    tec.last_name
                  }}
                </td>
                <td>{{ tec.email }}</td>
                <td>{{ tec.phone }}</td>
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
import { mapGetters } from "vuex";
import formMixins from "../../../../Mixins/form";
export default {
  data() {
    return {
      teachers: [],
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
        .get("/api/getTeacherAccordingParent/" + this.user.parent.id)
        .then((response) => {
          this.teachers = response.data.result;
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