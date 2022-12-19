<template>
  <div class="row card-common-design">
    <div class="col-lg-12 mb-4"   v-if="pageView == 'table'">
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
          <h6 class="m-0 font-weight-bold text-primary">Timetable Info</h6>
        </div>
        <div class="table-responsive alignment-table">
          <table class="table table-flush">
            <thead class="thead-light">
              <tr>
                <!-- <th>Class</th> -->
                <th>Subject</th>
                <th>Teacher</th>
                <th>Topic</th>
                <th>Description</th>
                <th>Time</th>
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
                <td>
                  {{ tblData.teacherName }}
                </td>
                <td>{{ tblData.topic }}</td>
                <td>{{ tblData.event_message }}</td>
                <td>{{ tblData.start_date.slice(0, 11) }}{{ " ( " }}{{ tblData.time_am_pm }}{{ " )" }}</td>
              </tr>
            </tbody>
          </table>
          <p class="table-null" v-if="tableData && tableData.length == 0"> 
            No record found
          </p>
        </div>
        <!-- <div class="card-footer"></div> -->
      </div>
    </div>
    <div class="col-lg-12 detail-card" v-else>
      <calendar-slot-view-component :userType="userType"></calendar-slot-view-component>
    </div>
  </div>
</template>
<script>
import { mapActions, mapGetters } from "vuex";
export default {
  data() {
    return {
      tableData: [],
       inforUrl: "class-schedule-detail",
       userType:'student'
    };
  },
  computed: {
    ...mapGetters({
      user: "user",
      permissions: "permissions",
      pageView: "pageView"
    }),
  },
  methods: {
      ...mapActions({
      setPageTitle: "setPageTitle",
    }),
      goToDetail(tblData){
      this.setPageTitle('Timetable Detail');
      this.$router.push('/' + this.inforUrl + '/' + tblData.session_id); 
      // this.$root.changeRoute('/' + this.inforUrl + '/' + tblData.session_id)
    },
    async getData() {
      axios
        .get("/api/getStudentTimeTable/" + this.user.student.id)
        .then((response) => {
          this.tableData = response.data.result;
        });
    },
      checkPermission(arr) {
      let boolValue = this.permissions.some((permission) => {
        return arr.includes(permission);
      });

      return boolValue;
    },
  },
  mounted() {
    this.getData();
  },
};
</script>
<style>
.timeTable .v-application--wrap {
  min-height: unset !important;
}
</style>