<template>
  <div class="row card-common-design detail-page">
    <delete-modal
      @confirm-delete="confirmDelete"
      @close-modal="closeModal"
      :showDeleteModel="showDeleteModel"
      :userType="userType"
    ></delete-modal>
    <div class="col-12 make-right">
      <button
                type="button"
                class="btn btn-orange ml-2"
                @click="goBack"
              >
                Back
              </button>
          
        </div>
    <div class="col-lg-12 detail-card">
      <div class="card mb-4 col-lg-3 img-card">
        <div class="card-body col-lg-12">
          <form>
            <div class="form-group col-sm-12 col-lg-12">
              <figure v-if="teacherImageId">
                <img
                  class="img-fluid make-image-circle"
                  :src="$root.getMedia(teacherImageId)"
                  @click="openImageBrowser"
                />
                <span class="form-control">{{ teacherFullName }}</span>
              </figure>
              <figure class="no-image" v-else>
                <img
                  class="img-profile make-image-circle"
                  :src="teacherImage"
                  style=""
                  @click="openImageBrowser"
                />
                <span class="form-control">{{ teacherFullName }}</span>
              </figure>
              <label
                for="cover-upload"
                class="custom-file-upload"
                id="image-upload-from-label"
              >
              </label>
              <input
                ref="imgfile"
                type="file"
                name="user_image"
                accept="image/*"
                id="cover-upload"
                style="visibility: hidden"
              />
            </div>
          </form>
        </div>
      </div>
      <div class="card mb-4 col-lg-8">
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
          <h6 class="m-0 font-weight-bold text-primary">General Information</h6>
          <div>
            <span
              @click.stop="$root.changeRoute('/edit-teacher/' + teacherID)"
              class="pointer-hand"
              ><i class="far fa-edit" style="color: #8bc34a"></i></span
            >&nbsp;
          </div>
        </div>
        <div class="card-body col-lg-12">
          <form class="detail-form">
            <div class="form-group col-sm-6 col-lg-4">
              <label for="teacherFullName">Full Name</label>
              <span
                style="border: none; padding-left: 0; font-size: 14px"
                class="form-control"
                id="teacherFullName"
                >{{ teacherFullName }}</span
              >
            </div>
            <div class="form-group col-sm-6 col-lg-4">
              <label for="teacherEmail">Email</label>
              <span
                style="border: none; padding-left: 0; font-size: 14px"
                class="form-control"
                id="teacherEmail"
                >{{ teacherEmail }}</span
              >
            </div>
            <div class="form-group col-sm-6 col-lg-4">
              <label for="teacherPhone">Phone</label>
              <span
                style="border: none; padding-left: 0; font-size: 14px"
                class="form-control"
                id="teacherPhone"
                >{{
                  teacherPhone == null ? "no address found" : teacherPhone
                }}</span
              >
            </div>
            <!-- <div class="form-group col-sm-6 col-lg-4">
              <label for="teacherAddress">Address</label>
              <span
                style="border: none; padding-left: 0; font-size: 14px"
                class="form-control"
                id="teacherAddress"
                >{{ teacherAddress }}</span
              >
            </div> -->
            <div class="form-group col-sm-6 col-lg-4">
                <!-- <label for="studentAddress">Session</label> -->
                <div class="form-group col-lg-12 text-justify">
                  <button type="button" class="btn btn-success" @click.stop="$root.changeRoute('/teacher-calendar/'+$route.params.id)">
                    CALENDAR
                  </button>
                </div>
              </div>
              <!-- <div class="form-group col-sm-6 col-lg-4">
                <div class="form-group col-lg-12 text-justify">
                  <button type="button" class="btn btn-success" @click.stop="$root.changeRoute('/teacher-session-detail/'+$route.params.id)">
                    SESSION
                  </button>
                </div>
              </div> -->
              <div class="form-group col-sm-6 col-lg-4">
                <!-- <label for="studentAddress">Session</label> -->
                <div class="form-group col-lg-12 text-justify">
                  <button type="button" class="btn btn-success" @click.stop="$root.changeRoute('/add-teacher-class-schedule/'+$route.params.id)">
                   CLASS SCHEDULE <i class="fa fa-plus" style="color: #1a130c;"></i>
                  </button>
                </div>
              </div>
            <!-- <div class="form-group col-sm-6 col-lg-12" v-if="teacherSubject.length>0">
              <label for="teacherSubject">Subject</label>
              <span
                style="border: none; padding-left: 0; font-size: 12px"
                class="form-control"
                id="teacherSubject"
                ><span v-for="(sub, index) in teacherSubject" :key="index"
                  >{{ sub.name
                  }}<span v-if="index + 1 < teacherSubject.length">{{
                    " - "
                  }}</span></span
                ></span
              >
            </div>
            <span v-else class="no-subject">
                {{'no subject found'}}
            </span> -->
          </form>
        </div>
      </div>
    </div>
    <!-- <div class="col-lg-12 detail-card">
      <div class="card mb-4 col-lg-12">
        <div class="card-header py-3 align-items-center card-header-mobo">
          <h6 class="m-0 font-weight-bold text-left col-lg-3">
            Associated Student
          </h6>
          <input
            class="form-control mr-sm-2 search col-lg-3"
            type="search"
            placeholder="Search"
            aria-label="Search"
            v-model="searchText"
            v-on:input="searchStudent"
          />
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
                <tr
                  class="custom-checkbox"
                  v-for="(student, index) in students"
                  :key="index"
                >
                  <td>
                    <input
                      style="position: inherit"
                      type="checkbox"
                      class="custom-control-input"
                      :id="index"
                      :checked="student.teacher.length == 0 ? false : true"
                      @click="selectStudent($event, student)"
                    />
                    <label class="custom-control-label" :for="index"
                      >{{ student.first_name }} {{ " " }}
                      {{ student.last_name }}</label
                    >
                  </td>
                  <td>{{ student.email }}</td>
                  <td>{{ student.phone }}</td>
                </tr>
              </tbody>
            </table>
            <p class="table-null" v-if="students && students.length == 0">
              No record found
            </p>
          </div>
        </div>
      </div>
    </div> -->
    <v-pagination
      v-if="paginationTotal > 1"
      v-model="paginationCurrent"
      :page-count="paginationTotal"
      @input="nextPage"
      :classes="bootstrapPaginationClasses"
    ></v-pagination>

    <!-- associated subjects -->

    <div class="col-lg-12 detail-card">
      <div class="card mb-4 col-lg-12">
        <div class="card-header py-3 align-items-center card-header-mobo">
          <h6 class="m-0 font-weight-bold text-left col-lg-3">
            Associated Subjects
          </h6>
        </div>
        <div class="card-body col-lg-12">
          <div class="table-responsive">
            <table class="table align-items-center table-flush">
              <thead class="thead-light">
                <tr>
                  <th>S.N</th>
                  <th>Subjects</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  class=""
                  v-for="(subject, index) in teacherSubject"
                  :key="index"
                >
                  <!-- <pre>{{ subject }}</pre> -->
                  <td>
                    <label :for="index">{{ index + 1 }}</label>
                  </td>
                  <td>
                    <label :for="index">{{ subject.name }}</label>
                  </td>
                </tr>
              </tbody>
            </table>
            <p
              class="table-null"
              v-if="teacherSubject && teacherSubject.length == 0"
            >
              No record found
            </p>
          </div>
        </div>
      </div>
    </div>

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
              <input
                v-model="teacher.password"
                type="password"
                class="form-control"
                id="exampleInputPassword1"
                placeholder="Password"
              />
            </div>
            <div class="form-group col-sm-6 col-lg-6 text-justify">
              <label for="confirmPassword">Confirm Password</label>
              <input
                v-model="teacher.confirmPassword"
                type="password"
                class="form-control"
                id="confirmPassword"
                placeholder="Password"
              />
            </div>
            <div class="form-group col-sm-6 col-lg-12 text-justify">
              <button
                type="button"
                class="btn btn-orange"
                @click.stop="changePassword"
              >
                Change
              </button>
            </div>
          </form>
        </div>
      </div>
      
    </div>
    <div class="col-sm-6 col-lg-12 text-justify">
        <button
          type="button"
          class="btn btn-danger pointer-hand"
          @click.stop="deleteData(teacherID, teacherFullName)"
        >
          Delete
        </button>
      </div>
  </div>
</template>

<script>
import vPagination from "vue-plain-pagination";
import formMixins from "../../../Mixins/form";
import ImageUpolad from "../../atoms/common/imageUpload";
import { Teacher } from "../../../Assets/dashboard/index";
import Chat from "../../templates/chat/chat";
import deleteModal from "../modals/delete.vue";
import "./teacher.css";
export default {
  data: function () {
    return {
      deleteId: "",
      showDeleteModel: false,
      userType: "",
      loading: true,
      teacherFullName: "",
      teacherSubject: [],
      teacherPhone: "",
      teacherEmail: "",
      teacherAddress: "",
      teacherID: "",
      teacherImageId: "",
      titleInfo: {
        pageTitle: "Add Teacher",
        logo: "fa fa-chevron-left",
        logoType: "icon",
        actionName: "Back",
        allowAction: true,
        pageType: "ad",
      },
      teacher: {
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
      teacherImage: Teacher,
      imgURL: "",
      userImage: "",
      userType: "teacher",
      tab: null,
      items: ["Detail", "Message", "Setting"],
      text: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
    };
  },

  components: {
    "image-upload": ImageUpolad,
    "delete-modal": deleteModal,
    "chat-component": Chat,
    vPagination,
  },
  watch: {
    students: function (newVal, oldVal) {
      // this.paginationCurrent = newVal.current_page;
      // this.paginationTotal = newVal.last_page;
    },
  },
  methods: {
    closeModal() {
      this.showDeleteModel = false;
    },
    async confirmDelete() {
      let isDelete = "";
      isDelete = await this.deleteRecord("teacher", this.deleteId);
      if (isDelete.status == "ok") {
        this.closeModal();
        this.$router.push("/teacher");
      }
    },
    deleteData(id, userType) {
      this.deleteId = id;
      this.userType = userType;
      this.showDeleteModel = true;
    },
    async getData() {
      let teacherDetail = [];
      teacherDetail = await this.getSpecificRecord(
        "teacher",
        this.$route.params.id
      );

      teacherDetail.map((val) => {
        this.teacherID = val.id;
        this.teacherImageId = val.teacher_image;
        this.teacherFullName = val.first_name + " " + val.last_name;
        //this.teacherSubject = val.subject;
        this.teacherEmail = val.email;
        this.teacherAddress = val.address;
        this.teacherPhone = val.phone;
      });
    },

    //get subject according to teacher (bipin)
    getTeacherSubject() {
      // let teacherId = this.$route.params.id
      // let url = "/api/getTeacherSubject/" + teacherId;

      let formData = {};
      formData["teacher_id"] = this.$route.params.id;

      // .get(url, teacherId)
      // .then((response) => {
      //   console.log(response.data.result);
      //   this.teacherSubject = response.data.result;
      // })
      axios.post("/api/getTeacherSubject", formData).then((response) => {
        this.teacherSubject = response.data.result;
      });
    },

    searchStudent(event) {
      if (event.target.value == "") {
        this.getAssosiatedStudents(this.paginationCurrent);
      } else {
        let formData = {};
        formData["searchText"] = event.target.value;
        formData["teacher_id"] = this.$route.params.id;
        axios
          .post("/api/getFilteredAssociatedStudents", formData)
          .then((response) => {
            this.students = response.data.result;
          });
      }
    },
    nextPage() {
      this.getAssosiatedStudents(this.paginationCurrent);
    },
    updateUserLists(data) {
      this.students = data;
    },
    selectStudent(event, student) {
      let formData = {};
      formData["student_id"] = student.id;
      formData["teacher_id"] = this.$route.params.id;
      if (event.target.checked) {
        // this.addRecord("studentTeacher", formData);
        axios.post("/api/addStudentTeacher", formData).then((response) => {
          this.getAssosiatedStudents(this.paginationCurrent);
        });
      } else {
        axios.post("/api/deleteStudentTeacher", formData).then((response) => {
          this.getAssosiatedStudents(this.paginationCurrent);
        });
      }
    },
    changePassword(e) {
      e.preventDefault();
      if (this.teacher.password == "") {
        this.validationRule.isPasswordEmpty = true;
        this.passwordEmpty();
      } else {
        this.validationRule.isPasswordEmpty = false;
        if (this.teacher.password != this.teacher.confirmPassword) {
          this.validationRule.isPasswordNotMatch = true;
          this.passwordNotMatch();
        } else {
          let formData = {};
          formData["password"] = this.teacher.password;
          //formData["full_name"] = "nabnit chandra jha";
          formData["teacher_id"] = this.$route.params.id;
          this.validationRule.isPasswordNotMatch = false;
          //this.updateRecord("teacher", formData, this.teacherID);

          /*bipin*/
          axios.post("api/updateTeacherPassword", formData).then((response) => {
            this.teacher.password = "";
            this.teacher.confirmPassword = "";
            this.passwordChangeSccessfully();
          });
        }
      }
    },
    handleFile(e) {
      this.userImage = e.target.files[0];
      const file = document.querySelector("input[type=file]").files[0];

      const callBack = (imgUrl) => {
        this.teacherImage = imgUrl;
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
      form.append("imageURL", this.teacherImage);
      axios.post("/api/uploadTeacherImage", form).then((response) => {
        this.getData();
      });
    },

    getAssosiatedStudents(event) {
      let formData = {};
      formData["teacherId"] = this.$route.params.id;
      let url = "/api/" + "get" + "AssociatedStudent" + "s" + "?page=" + event;
      axios.post(url, formData).then((response) => {
        this.students = response.data.result.data;
        this.paginationCurrent = response.data.result.current_page;
        this.paginationTotal = response.data.result.last_page;
        this.loading = false;
      });
    },
  },

  mounted() {
    this.getData();
    this.getAssosiatedStudents(1);
    this.getTeacherSubject();
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
.teacher__form--name {
  color: #ff9800 !important;
  font-size: 29px !important;
  text-transform: capitalize;
}
</style>
