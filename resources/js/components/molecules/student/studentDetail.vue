<template>
  <div class="row card-common-design detail-page">
    <delete-modal @confirm-delete="confirmDelete" @close-modal="closeModal" :showDeleteModel="showDeleteModel"
      :userType="userType"></delete-modal>
    <b-overlay id="overlay-background" :show="show" :variant="variant" :opacity="opacity" :blur="blur" rounded="sm"
      class="col-lg-12" spinner-type="grow">
      <div class="col-12 make-right">
        <button type="button" class="btn btn-orange ml-2" @click="goBack">
          Back
        </button>

      </div>
      <div class="col-lg-12 detail-card">
        <div class="card mb-4 col-lg-3 img-card">
          <div class="card-body col-lg-12">
            <form>
              <div class="form-group col-sm-12 col-lg-12">
                <figure v-if="studentImageId">
                  <img class="img-fluid make-image-circle" :src="$root.getMedia(studentImageId)"
                    @click="openImageBrowser" />
                  <span class="form-control">{{ studentFullName }}</span>
                </figure>
                <figure class="no-image" v-else>
                  <img class="img-profile make-image-circle" :src="studentImage" style="" @click="openImageBrowser" />
                  <span class="form-control">{{ studentFullName }}</span>
                </figure>
                <label for="cover-upload" class="custom-file-upload" id="image-upload-from-label">
                </label>
                <input ref="imgfile" type="file" name="user_image" accept="image/*" id="cover-upload"
                  style="visibility: hidden" />
              </div>
            </form>
          </div>
        </div>

        <div class="card mb-4 col-lg-8">
          <div class="
            card-header
            py-3
            d-flex
            flex-row
            align-items-center
            justify-content-between
          ">
            <h6 class="m-0 font-weight-bold text-primary">General Information</h6>
            <div>
              <span @click.stop="
                $root.changeRoute('/edit-student/' + studentID)
              " class="pointer-hand"><i class="far fa-edit" style="color: #8bc34a"></i></span>&nbsp;<span
                class="action-seprator">
              </span>
              &nbsp;

            </div>
          </div>
          <div class="card-body col-lg-12">
            <form class="detail-form">
              <div class="form-group col-sm-6 col-lg-4">
                <label for="studentFullName">Full Name</label>
                <span style="border: none; padding-left: 0; font-size: 14px" class="form-control"
                  id="studentFullName">{{ studentFullName }}</span>
              </div>
              <div class="form-group col-sm-6 col-lg-4">
                <label for="studentEmail">Email</label>
                <span style="border: none; padding-left: 0; font-size: 14px" class="form-control" id="studentEmail">{{
                studentEmail }}</span>
              </div>
              <div class="form-group col-sm-6 col-lg-4">
                <label for="studentEmail">Phone</label>
                <span style="border: none; padding-left: 0; font-size: 14px" class="form-control" id="studentPhone">{{
                studentPhone }}</span>
              </div>
              <!-- <div class="form-group col-sm-6 col-lg-4">
                <label for="studentAddress">Address</label>
                <span style="border: none; padding-left: 0; font-size: 14px" class="form-control" id="studentAddress">{{
                studentAddress==null?'no address found':studentAddress }}</span>
              </div> -->
              <div class="form-group col-sm-6 col-lg-4">
                <!-- <label for="studentAddress">Session</label> -->
                <div class="form-group col-lg-12 text-justify">
                  <button type="button" class="btn btn-success" @click.stop="$root.changeRoute('/student-calendar/'+$route.params.id)">
                    CALENDAR
                  </button>
                </div>
              </div>
              <!-- <div class="form-group col-sm-6 col-lg-4">
                <div class="form-group col-lg-12 text-justify">
                  <button type="button" class="btn btn-success" @click.stop="$root.changeRoute('/student-session-detail/'+$route.params.id)">
                    SESSION
                  </button>
                </div>
              </div> -->
              <div class="form-group col-sm-6 col-lg-4">
                <!-- <label for="studentAddress">Session</label> -->
                <div class="form-group col-lg-12 text-justify">
                  <button type="button" class="btn btn-success" @click.stop="$root.changeRoute('/add-student-class-schedule/'+$route.params.id)">
                   CLASS SCHEDULE <i class="fa fa-plus" style="color: #1a130c;"></i>
                  </button>
                </div>
              </div>
              <!-- <div class="form-group col-sm-6 col-lg-12">
              <label for="studentSubject">Subject</label>
              <span
                style="border: none; padding-left: 0; font-size: 12px"
                class="form-control"
                id="studentSubject"
                v-if="studentSubject.length>0"
                ><span v-for="(sub, index) in studentSubject" :key="index"
                  >{{ sub.name
                  }}<span v-if="index + 1 < studentSubject.length">{{
                    " - "
                  }}</span></span
                ></span
              >
              <span v-else class="no-subject">
                {{'no subject found'}}
              </span>
            </div> -->
            </form>
          </div>
        </div>


        <v-pagination v-if="paginationTotal > 1 && !loading" v-model="paginationCurrent" :page-count="paginationTotal"
          @input="nextPage" :classes="bootstrapPaginationClasses"></v-pagination>
      </div>
      <div>
        <div class="row">
          <div class="col-sm-12">
            <div class="session-wrapper">
              <div class="mt-4">
                <div class="tab-bar-custom">
                  <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                      <a class="nav-link active" id="pills-parent-info-tab" data-toggle="pill" href="#pills-parent-info"
                        role="tab" aria-controls="pills-parent-info" aria-selected="true">Parent Info</a>
                    </li>
                    <!-- <li class="nav-item" role="presentation">
                      <a class="nav-link" id="pills-calendar-tab" data-toggle="pill" href="#pills-calendar" role="tab"
                        aria-controls="pills-calendar" aria-selected="false">Calendar</a>
                    </li>
                    <li class="nav-item" role="presentation">
                      <a class="nav-link" id="pills-session-tab" data-toggle="pill" href="#pills-session" role="tab"
                        aria-controls="pills-session" aria-selected="false">Session</a>
                    </li> -->
                    <li class="nav-item" role="presentation">
                      <a class="nav-link" id="pills-change-password-tab" data-toggle="pill"
                        href="#pills-change-password" role="tab" aria-controls="pills-change-password"
                        aria-selected="false">Change Password</a>
                    </li>
                    <li class="nav-item" role="presentation">
                      <a class="nav-link" id="pills-timetable-information-tab" data-toggle="pill"
                        href="#pills-timetable-information" role="tab" aria-controls="pills-timetable-information"
                        aria-selected="false">Timetable Information</a>
                    </li>
                  </ul>
                  <div class="tab-content proactive-card" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-parent-info" role="tabpanel"
                      aria-labelledby="pills-parent-info-tab">
                      <div class="col-lg-12 detail-card">
                        <div class="card mb-4 col-lg-12">
                          <div class="card-header py-3 align-items-center card-header-mobo">
                            <h6 class="m-0 font-weight-bold text-left col-lg-3">
                              Guardians Information
                            </h6>
                            <div>
                              <button class="btn btn-orange" @click="
                                $root.changeRoute('/add-parent/'+$route.params.id)
                              ">ADD PARENT</button>
                            </div>
                          </div>
                          <div class="card-body col-lg-12">
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
                                  <tr class="custom-checkbox" v-for="(parent, index) in parents" :key="index">
                                    <td>
                                      {{ parent.first_name }}{{' '}}{{ parent.last_name }}
                                    </td>
                                    <td>{{ parent.email }}</td>
                                    <td>{{ parent.phone }}</td>
                                  </tr>
                                </tbody>
                              </table>
                              <p class="table-null" v-if="parents && parents.length == 0">
                                No record found
                              </p>

                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="pills-calendar" role="tabpanel" aria-labelledby="pills-calendar-tab">
                      <p>this is calendar tab</p>

                    </div>
                    <div class="tab-pane fade" id="pills-session" role="tabpanel" aria-labelledby="pills-session-tab">
                      <p>this is session</p>
                      <all-classes />
                    </div>

                    <div class="tab-pane fade" id="pills-change-password" role="tabpanel"
                      aria-labelledby="pills-change-password-tab">
                      <div class="col-lg-12 detail-card change-password-card">
                        <div class="card mb-4 col-lg-12">
                          <div class="card-header py-3 align-items-center">
                            <h6 class="m-0 font-weight-bold text-left col-lg-3">
                              Change Password
                            </h6>
                          </div>
                          <div class="card-body col-lg-12">
                            <form>
                              <div class="form-group col-sm-6 col-lg-6 text-justify">
                                <label for="exampleInputPassword1">Password</label>
                                <input v-model="student.password" type="password" class="form-control"
                                  id="exampleInputPassword1" placeholder="Password" />
                              </div>
                              <div class="form-group col-sm-6 col-lg-6 text-justify">
                                <label for="confirmPassword">Confirm Password</label>
                                <input v-model="student.confirmPassword" type="password" class="form-control"
                                  id="confirmPassword" placeholder="Password" />
                              </div>
                              <div class="form-group col-sm-6 col-lg-12 text-justify">
                                <button type="button" class="btn btn-success" @click.stop="changePassword">
                                  Change
                                </button>
                              </div>

                              <!-- <span
                    @click.stop="deleteData(studentID, studentFullName)"
                    class="pointer-hand"
                    ><i class="fas fa-trash-alt" style="color: #fe8b24"></i
                  ></span> -->
                            </form>
                          </div>

                        </div>
                      </div>
                    </div>

                    <div class="tab-pane fade" id="pills-timetable-information" role="tabpanel"
                      aria-labelledby="pills-timetable-tab">
                      <div class="col-lg-12 detail-card">
                        <div class="card mb-4 col-lg-12">
                          <div class="card-header py-3 align-items-center card-header-mobo">
                            <h6 class="m-0 font-weight-bold text-left col-lg-3">
                              Timetable Information
                            </h6>
                          </div>
                          <div class="card-body col-lg-12">
                            <div class="table-responsive">
                              <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                  <tr>
                                    <th>Topic</th>
                                    <th>Description</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr class="custom-checkbox" v-for="(tmtbl, index) in timetable" :key="index">
                                    <td>{{ tmtbl.topic }}</td>
                                    <td>{{ tmtbl.event_message }}</td>
                                  </tr>
                                </tbody>
                              </table>
                              <p class="table-null" v-if="timetable && timetable.length == 0">
                                No record found
                              </p>

                            </div>
                          </div>
                        </div>
                      </div>

                    </div>

                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>




      <div class="form-group col-lg-12 text-justify">
        <button type="button" class="btn btn-danger" @click.stop="deleteData(studentID, studentFullName)">
          Delete
        </button>
      </div>
    </b-overlay>
  </div>

</template>

<script>
import vPagination from "vue-plain-pagination";
import formMixins from "../../../Mixins/form";
import ImageUpolad from "../../atoms/common/imageUpload";
import { Student } from "../../../Assets/dashboard/index";
import Chat from "../../templates/chat/chat";
import deleteModal from "../modals/delete.vue";
import "./student.css";
import allClasses from "../../templates/forms/teacherClasses/allClasses.vue";
export default {
  data: function () {
    return {
      show: true,
      deleteId: "",
      showDeleteModel: false,
      userType: "",
      parents: [],
      timetable: [],
      studentFullName: "",
      studentPhone: "",
      studentSubject: [],
      studentEmail: "",
      studentAddress: "",
      studentID: "",
      studentImageId: "",
      titleInfo: {
        pageTitle: "Add Student",
        logo: "fa fa-chevron-left",
        logoType: "icon",
        actionName: "Back",
        allowAction: true,
        pageType: "ad",
      },
      student: {
        password: "",
        confirmPassword: "",
      },
      validationRule: {
        isPasswordNotMatch: false,
        isPasswordEmpty: false,
      },
      searchText: "",
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
      students: [],
      studentImage: Student,
      imgURL: "",
      userImage: "",
      userType: "student",
      tab: null,
      items: ["Detail", "Message", "Setting"],
      text: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
    };
  },

  components: {
    "all-classes": allClasses,
    "delete-modal": deleteModal,
    "image-upload": ImageUpolad,
    "chat-component": Chat,
    vPagination,
  },
  watch: {
    students: function (newVal, oldVal) {
      this.paginationCurrent = newVal.current_page;
      this.paginationTotal = newVal.last_page;
    },
  },
  methods: {
    closeModal() {
      this.showDeleteModel = false;
    },
    async confirmDelete() {
      let isDelete = "";
      isDelete = await this.deleteRecord("student", this.deleteId);
      if (isDelete.status == "ok") {
        this.closeModal();
        this.$router.push('/student');
      }
    },
    deleteData(id, userType) {
      this.deleteId = id;
      this.userType = userType;
      this.showDeleteModel = true;
    },
    async getData() {
      let studentDetail = [];
      studentDetail = await this.getSpecificRecord(
        "student",
        this.$route.params.id
      );

      studentDetail.map((val) => {
        this.studentID = val.id;
        this.studentImageId = val.student_image;

        let fname = val.first_name == null ? " " : val.first_name;
        let lname = val.last_name == null ? " " : val.last_name;
        this.studentFullName = fname + '  ' + lname;
        this.studentPhone = val.phone;
        this.studentSubject = val.subject;
        this.studentEmail = val.email;
        this.studentAddress = val.country;
      });
      this.show = false;
    },
    searchStudent(event) {
      let formData = {};
      formData["searchText"] = event.target.value;
      formData["student_id"] = this.$route.params.id;
      axios
        .post("/api/getFilteredAssociatedStudents", formData)
        .then((response) => {
          this.students = response.data.result.data;
        });
    },
    nextPage() {
      this.getStudentWithParent(this.paginationCurrent);
    },
    updateUserLists(data) {
      this.students = data;
    },

    changePassword(e) {
      e.preventDefault();
      if (this.student.password == "") {
        this.validationRule.isPasswordEmpty = true;
        this.passwordEmpty();
      } else {
        this.validationRule.isPasswordEmpty = false;
        if (this.student.password != this.student.confirmPassword) {
          this.validationRule.isPasswordNotMatch = true;
          this.passwordNotMatch();
        } else {
          let formData = {};
          formData["password"] = this.student.password;
          //formData["full_name"] = "nabnit chandra jha";
          formData["student_id"] = this.$route.params.id;
          this.validationRule.isPasswordNotMatch = false;
          //this.updateRecord("student", formData, this.studentID);
          axios.post("api/updateStudentPassword", formData).then((response) => {
            this.student.password = ''
            this.student.confirmPassword = ''
            this.passwordChangeSccessfully();
          });
        }
      }
    },
    handleFile(e) {
      this.userImage = e.target.files[0];
      const file = document.querySelector("input[type=file]").files[0];

      const callBack = (imgUrl) => {
        this.studentImage = imgUrl;
        this.addImage();
      };

      const reader = new FileReader();
      reader.addEventListener(
        "load",
        function () {
          callBack(reader.result);
          document.getElementById("cover-upload").value = "";
        },
        false
      );
      reader.readAsDataURL(file);
    },

    openImageBrowser() {
      // $("#image-upload-from-label").click();
    },
    async addImage() {
      let x = this.userImage;
      var form = new FormData();
      form.append("userImage", this.userImage);
      form.append("id", this.$route.params.id);
      form.append("imageURL", this.studentImage);
      axios.post("/api/uploadstudentImage", form).then((response) => {
        this.getData();
      });
    },

    getStudentWithParent(event) {
      let formData = {};
      formData["studentId"] = this.$route.params.id;
      let url = "/api/" + "get" + "AssociatedParent" + "s" + "?page=" + event;
      axios.post(url, formData).then((response) => {
        this.parents = response.data.result.data[0].parent;
      });
    },

    getStudentTimetableDetails(event) {
      let formData = {};
      formData["studentId"] = this.$route.params.id;
      axios.get("/api/getStudentTimetableDetails/" + this.$route.params.id).then((response) => {
        this.timetable = response.data.result;
      });
    },
  },

  mounted() {
    this.getStudentTimetableDetails();
    this.getData();
    this.getStudentWithParent(1);
  },
  mixins: [formMixins],
};
</script>
<style>
.basil {
  background-color: #fff !important;
}

.basil--text {
  color: #8bc34a !important;
  font-size: 29px !important;
}

.student__form--name {
  color: #ff9800 !important;
  font-size: 29px !important;
  text-transform: capitalize;
}
</style>
