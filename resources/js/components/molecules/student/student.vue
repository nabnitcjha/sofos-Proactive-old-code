<template>
  <div class="row add-student spinner-position">
    <div class="col-lg-12">
      <b-overlay
        id="overlay-background"
        :show="show"
        :variant="variant"
        :opacity="opacity"
        :blur="blur"
        rounded="sm"
      >
      <div class="card mb-4 student-info" v-if="step == 'student-info'">
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
          <h6 class="m-0 text-primary">Student Info</h6>
          <button
            type="button"
            class="btn btn-orange ml-2"
            @click="goBack"
            v-if="pageView != 'RegisterStudent'"
          >
            Back
          </button>
        </div>
        <div class="card-body col-lg-12">
          <form @submit="save">
            <div class="form-group col-sm-6 col-lg-3">
              <label for="studentRegistration">
                <img :src="First_name" /> First Name</label
              >
              <input
                v-model="student_first_name"
                type="text"
                class="form-control"
                id="studentFirstName"
                placeholder="First Name"
                required
              />
            </div>

            <div class="form-group col-sm-6 col-lg-3">
              <label for="studentLastName"
                ><img :src="Last_name" />Last Name</label
              >
              <input
                v-model="student_last_name"
                type="text"
                class="form-control"
                id="studentLastName"
                placeholder="Last Name"
                required
              />
            </div>

            <div class="form-group col-sm-6 col-lg-3">
              <label for="studentPhone"><img :src="Phone" />&nbsp; Phone</label>
              <input
                v-model="student_phone"
                type="text"
                class="form-control"
                id="studentPhone"
                placeholder="Phone"
                required
              />
            </div>
            <div class="form-group col-sm-6 col-lg-3">
              <label for="studentEmail"><img :src="Email" />Email</label>
              <input
                v-model="student_email"
                type="text"
                class="form-control"
                id="studentEmail"
                placeholder="Email"
                required
              />
            </div>

            <div class="form-group col-sm-6 col-lg-3 custom-date-picker">
              <label for="dob"><img :src="Dob" />DOB</label>
              <date-picker
                v-model="student_dob"
                type="datetime"
                placeholder="Select datetime"
                format="YYYY-MM-DD hh:mm a"
              ></date-picker>
            </div>

            <div class="form-group col-sm-6 col-lg-3">
              <label for="studentAddress"
                ><img :src="studentAddress" />Address</label
              >
              <input
                v-model="student_address"
                type="text"
                class="form-control"
                id="studentAddress"
                placeholder="Address"
              />
            </div>
            <div class="form-group col-sm-6 col-lg-3">
              <label for="studentUploadPhoto" style="cursor: pointer"
                >Upload Photo</label
              >
              <input
                v-model="studentImageText"
                type="text"
                class="form-control"
                id="studentUploadPhoto"
                placeholder="upload photo"
                @click.stop="openStudentFileDialog"
                style="caret-color: transparent; cursor: pointer"
              />
              <div class="custom-file">
                <input
                  type="file"
                  class="custom-file-input col-sm-6 col-lg-3"
                  id="customFile"
                  @change="handleStudentFile"
                  style="visibility: hidden"
                />
                <label
                  class="custom-file-label"
                  for="customFile"
                  style="visibility: hidden"
                  id="student-image-upload"
                  >Choose file</label
                >
              </div>
              <div>
                <img
                  class="upload-image-size image-upload img-fluid-mobile"
                  :src="$root.getMedia(student_image)"
                  @click="handleStudentFile"
                  v-if="
                    studentImage == '' &&
                    student_image != '' &&
                    student_image != null
                  "
                />
                <img
                  class="upload-image-size image-upload img-fluid-mobile"
                  :src="studentImage"
                  style=""
                />
              </div>
            </div>
            <!-- <div class="form-group col-12 next-btn">
              <button class="btn btn-orange" type="submit">
                Next
              </button>
            </div> -->
            <div
              class="
                card-header
                py-3
                d-flex
                flex-row
                align-items-center
                justify-content-between
                col-12
              "
            >
              <h6 class="m-0 text-primary">Parent Info</h6>
            </div>
            <!-- ------------ dynamic add parent field -------------- -->
            <div
              class="dynamic-add-parent col-12"
              v-for="(input, index) in dynamicParentList"
              :key="index"
            >
              <div class="form-group col-sm-6 col-lg-3">
                <label for="studentFirstName"
                  ><img :src="First_name" />First Name</label
                >
                <input
                  v-model="input.first_name"
                  type="text"
                  class="form-control"
                  id="studentFirstName"
                  placeholder="First Name"
                  @change="changeField($event, 'first_name', input.parent_id)"
                  required
                />
              </div>

              <div class="form-group col-sm-6 col-lg-3">
                <label for="studentLastName"
                  ><img :src="First_name" />Last Name</label
                >
                <input
                  v-model="input.last_name"
                  type="text"
                  class="form-control"
                  id="studentLastName"
                  placeholder="Last Name"
                  @change="changeField($event, 'last_name', input.parent_id)"
                  required
                />
              </div>

              <div class="form-group col-sm-6 col-lg-3">
                <label for="studentPhone"
                  ><img :src="Phone" />&nbsp; Contact</label
                >
                <input
                  v-model="input.phone"
                  type="text"
                  class="form-control"
                  id="studentPhone"
                  placeholder="Phone"
                  @change="changeField($event, 'phone', input.parent_id)"
                  required
                />
              </div>

              <div class="form-group col-sm-6 col-lg-3">
                <label for="studentEmail"><img :src="Email" />Email</label>
                <input
                  v-model="input.email"
                  type="text"
                  class="form-control"
                  id="studentEmail"
                  placeholder="Email"
                  @change="changeField($event, 'email', input.parent_id)"
                  required
                />
              </div>

              <div class="form-group col-sm-6 col-lg-3">
                <label for="studentAddress"
                  ><img :src="Address" />Address</label
                >
                <input
                  v-model="input.address"
                  type="text"
                  class="form-control"
                  id="studentAddress"
                  placeholder="Address"
                  @change="changeField($event, 'address', input.parent_id)"
                />
              </div>
              <div class="form-group col-sm-6 col-lg-3">
                <label for="studentCountry"
                  ><img :src="Country" />Country</label
                >
                <input
                  v-model="input.country"
                  type="text"
                  class="form-control"
                  id="studentCountry"
                  placeholder="Country"
                  @change="changeField($event, 'country', input.parent_id)"
                />
              </div>
              <div class="form-group col-sm-6 col-lg-3">
                <label for="studentState"
                  ><img :src="State" />&nbsp;State</label
                >
                <input
                  v-model="input.state"
                  type="text"
                  class="form-control"
                  id="studentState"
                  placeholder="State"
                  @change="changeField($event, 'state', input.parent_id)"
                />
              </div>

              <!-- <div
                class="form-group col-sm-6 col-lg-3 parent-photo-down"
                style="cursor: pointer"
              >
                <label for="parentUploadPhoto" style="cursor: pointer"
                  >Upload Photo-parent</label
                >
                <input
                  type="text"
                  class="form-control"
                  id="parentUploadPhoto"
                  placeholder="upload photo"
                  @click.stop="openParentFileDialog"
                  style="caret-color: transparent; cursor: pointer"
                />
                <div class="custom-file">
                  <input
                    type="file"
                    class="custom-file-input col-sm-6 col-lg-5 image-upload"
                    id="customFileParent"
                    @change="
                      handleParentFile($event, 'parent_image', input.parent_id)
                    "
                    style="visibility: hidden"
                  />
                  <label
                    style="visibility: hidden"
                    class="custom-file-label"
                    for="customFileParent"
                    id="parent-image-upload"
                    >Upload Photo</label
                  >
                </div>
                <div>
                  <img
                    class="upload-image-size image-upload img-fluid-mobile"
                    :src="$root.getMedia(parent_image)"
                    @click="
                      handleParentFile($event, 'parent_image', input.parent_id)
                    "
                    v-if="
                      parentImage == '' &&
                      parent_image != '' &&
                      parent_image != null
                    "
                  />
                  <img
                    class="upload-image-size image-upload img-fluid-mobile"
                    :src="parentImage"
                    style=""
                  />
                </div>
                
              </div> -->
              <div class="form-group col-12 add-guardian" v-if="index == 0">
                Add Guardians
                <i
                  class="fas fa-plus"
                  style="color: #8bc34a"
                  @click.stop="addGuardian"
                ></i>
              </div>
              <div class="form-group col-sm-6 col-lg-3 remove-guardian" v-else>
                Remove Guardians
                <i
                  class="fas fa-minus"
                  style="color: red"
                  @click.stop="removeParent(input.parent_id)"
                ></i>
              </div>
              <div class="form-group col-12">
                <hr class="parent-divider" />
              </div>
            </div>
            <!-- ------------ dynamic add parent field end ---------- -->
            <div class="form-group col-12 back-next">
              <!-- <b-spinner
                style="width: 3rem; height: 3rem"
                label="Large Spinner"
                variant="success"
                v-show="loading"
              ></b-spinner> -->
              <!-- <button class="btn back-btn" @click.stop="parentBack">
                Back
              </button> -->
              <button class="btn btn-save next-btn" type="submit">
                {{ titleInfo.pageType == "edit" ? "Update" : "Save" }}
              </button>
              <button
                type="button"
                class="btn btn-danger ml-2"
                @click="cancelStudentParentRecord"
              >
                Cancel
              </button>
            </div>
          </form>
        </div>
      </div>
      </b-overlay>
    </div>
  </div>
</template>
 
 <script>
import {
  First_name,
  Last_name,
  Phone,
  Email,
  Dob,
  Address,
  Country,
  State,
} from "../../../Assets/formIcons/index";
import "vue-multiselect/dist/vue-multiselect.min.css";
import "./student.css";
import formMixins from "../../../Mixins/form";
import { mapGetters, mapActions } from "vuex";
export default {
  data: function () {
    return {
      show:false,
      studentAddress: Address,
      First_name: First_name,
      Last_name: Last_name,
      Phone: Phone,
      Email: Email,
      Dob: Dob,
      Address: Address,
      Country: Country,
      State: State,
      loading: false,
      dynamicParentList: [
        {
          first_name: "",
          last_name: "",
          phone: "",
          email: "",
          address: "",
          country: "",
          state: "",
          parent_image: "",
          parent_id: 1,
        },
      ],
      grades: [],
      imageText: "",
      studentImageText: "",
      selectedGrade: "",
      selectedNationality: [],
      selectedRelation: [],
      selectedStudentGender: [],
      selectedParentGender: [],
      nationalities: [
        { name: "nepali" },
        { name: "indian" },
        { name: "other" },
      ],
      studentGenders: [{ name: "male" }, { name: "female" }, { name: "other" }],
      parentGenders: [{ name: "male" }, { name: "female" }, { name: "other" }],
      selectedParentReligion: [],
      selectedStudentReligion: [],
      parentReligions: [
        { name: "hindu" },
        { name: "muslim" },
        { name: "other" },
      ],
      studentReligions: [
        { name: "hindu" },
        { name: "muslim" },
        { name: "other" },
      ],
      relations: [{ name: "father" }, { name: "mother" }, { name: "other" }],
      subjects: [],
      selectedSubjects: [],
      studentImage: "",
      parentImage: "",
      step: "student-info",

      student_first_name: "",
      student_middle_name: "",
      student_last_name: "",
      student_gender: "",
      student_dob: "",
      student_phone: "",
      student_email: "",
      student_address: "",
      student_relation: "",
      student_image: "",
      student_selectedGrade: "",
      student_selectedSubjects: [],
      student_religion: "",

      parent_first_name: "",
      parent_middle_name: "",
      parent_last_name: "",
      parent_relation: "",
      parent_occupation: "",
      parent_phone: "",
      parent_alternate_phone: "",
      parent_email: "",
      parent_religion: "",
      parent_image: "",
      parent_nationality: "",
      parent_gender: "",
      parent_address: "",
      parent_country: "",
      parent_state: "",
      parent_zip: "",

      academic_registration: "",
      academic_section: "",
      academic_roll: "",
    };
  },
  props: {
    titleInfo: Object,
  },
  watch: {
    imageText: function (newval, oldval) {
      this.openParentImageBrowser();
    },
    studentImageText: function (neval, oldval) {
      this.openStudentImageBrowser();
    },
  },
  computed: {
    ...mapGetters({
      pageView: "pageView",
    }),
  },
  methods: {
    cancelStudentParentRecord() {
      this.student_first_name = "";
      this.student_last_name = "";
      this.student_dob = "";
      this.student_phone = "";
      this.student_email = "";
      this.student_address = "";
      this.dynamicParentList = [
        {
          first_name: "",
          last_name: "",
          phone: "",
          email: "",
          address: "",
          country: "",
          state: "",
          parent_image: "",
          parent_id: 1,
        },
      ];
    },
    ...mapActions({
      studentAddStatus: "studentAddStatus",
    }),
    addParentImageToDynamicParentList(file, type, id) {
      let dynamicParentList = [...this.dynamicParentList];
      let item = dynamicParentList.find(
        (parentItem) => parentItem.parent_id === id
      );
      let updatedItem = {
        ...item,
        parent_image: file,
      };

      item = updatedItem;
      this.dynamicParentList = dynamicParentList;
    },
    changeField(event, type, parent) {
      let dynamicParentList = [...this.dynamicParentList];
      let item = dynamicParentList.find(
        (parentItem) => parentItem.parent_id === parent
      );
      let updatedItem = {
        ...item,
        type: event.target.value,
      };

      item = updatedItem;
      this.dynamicParentList = dynamicParentList;
    },
    addGuardian() {
      let dynamicList = [...this.dynamicParentList];
      dynamicList.push({
        parent_id: this.dynamicParentList.length + 1,
        first_name: "",
        last_name: "",
        phone: "",
        email: "",
        address: "",
        country: "",
        state: "",
        parent_image: "",
      });
      this.dynamicParentList = dynamicList;
    },
    removeParent(parent_id) {
      this.dynamicParentList = this.dynamicParentList.filter(
        (parentItem) => parentItem.parent_id !== parent_id
      );
    },
    async getSubjects(event) {
      this.subjects = await this.getRecord("subject", event, false);
      if (this.titleInfo.pageType == "edit") {
        this.getStudent();
      }
    },
    async save(e) {
      e.preventDefault();
      this.loading = true;
      this.show = true;
      let date = "";
      if (this.student_dob == "") {
        date = "";
      } else {
        date = await this.dateFormater(this.student_dob);
      }
      console.log(this.dynamicParentList);
      //let time_am_pm = await this.dateFormater_AM_PM(this.student_dob);
      // var form = new FormData();
      // form.append("student_image", this.student_image);
      let formData = {};
      formData["student_first_name"] = this.student_first_name;
      formData["student_last_name"] = this.student_last_name;
      formData["student_dob"] = date;
      formData["student_phone"] = this.student_phone;
      formData["student_email"] = this.student_email;
      formData["student_address"] = this.student_address;
      formData["dynamic_parent_list"] = this.dynamicParentList;

      if (this.titleInfo.pageType == "edit") {
        formData["student_id"] = this.$route.params.id;
        axios.post("/api/updateStudent", formData).then((response) => {
          let form = new FormData();
          form.append("userImage", this.student_image);
          form.append("student_id", response.data.result.id);
          form.append("mode", "student");
          axios
            .post("/api/uploadImage", form)
            .then((response) => {
              this.addStatus('Student Update Successfully');
              this.$router.push("/student");
            })
            .catch((error) => console.log("err ==>>", error));
          
        });
      } else {
        axios.post("/api/addStudent", formData).then((response) => {
          let form = new FormData();
          form.append("userImage", this.student_image);
          form.append("student_id", response.data.result.id);
          form.append("mode", "student");
          axios
            .post("/api/uploadImage", form)
            .then((response) => {
              this.addStatus('Student Add Successfully');
              this.$router.push("/student");
            })
            .catch((error) => console.log("err ==>>", error));
          this.loading = false;
        });
      }
    },
    handleStudentFile(e) {
      this.student_image = e.target.files[0];
      // this.userImage = e.target.files[0];
      const file = document.querySelector("input[type=file]").files[0];
      const callBack = (imgUrl) => {
        this.studentImage = imgUrl;
        // this.addImage();
      };

      const reader = new FileReader();
      reader.addEventListener(
        "load",
        function () {
          // convert image file to base64 string
          this.studentImage = reader.result;
          callBack(reader.result);

          document.getElementById("student-image-upload").value = "";
        },
        false
      );
      reader.readAsDataURL(file);
    },
    openParentImageBrowser() {
      if (this.imageText == "") {
        return;
      }
      $("#parent-image-upload").click();
      this.imageText = "";
    },
    openParentFileDialog() {
      $("#parent-image-upload").click();
    },
    openStudentImageBrowser() {
      if (this.studentImageText == "") {
        return;
      }
      $("#student-image-upload").click();
      this.studentImageText = "";
    },
    openStudentFileDialog() {
      $("#student-image-upload").click();
    },
    handleParentFile(e, type, id) {
      this.parent_image = e.target.files[0];
      // this.userImage = e.target.files[0];
      // const file = document.querySelector("input[type=file]").files[0];
      const callBack = (imgUrl) => {
        this.parentImage = imgUrl;
        // this.addImage();
        this.addParentImageToDynamicParentList(this.parent_image, type, id);
      };

      const reader = new FileReader();
      reader.addEventListener(
        "load",
        function () {
          // convert image file to base64 string
          this.parentImage = reader.result;
          callBack(reader.result);

          document.getElementById("parent-image-upload").value = "";
        },
        false
      );
      reader.readAsDataURL(this.parent_image);
    },
    updateselectedStudentGender() {
      let selectedName = this.selectedStudentGender.name;
      this.student_gender = selectedName;
    },
    updateselectedParentGender() {
      let selectedName = this.selectedParentGender.name;
      this.parent_gender = selectedName;
    },

    updateSelectedNationality() {
      let selectedName = this.selectedNationality.name;
      this.parent_nationality = selectedName;
    },
    updateSelectedRelation() {
      let selectedName = this.selectedRelation.name;
      this.parent_relation = selectedName;
    },
    updateselectedStudentReligion() {
      let selectedName = this.selectedStudentReligion.name;
      this.student_religion = selectedName;
    },
    updateselectedParentReligion() {
      let selectedName = this.selectedParentReligion.name;
      this.parent_religion = selectedName;
    },
    // async updateSelectedGrade() {
    //   let selectedId = this.selectedGrade.id;
    //   this.student_selectedGrade = selectedId;

    //   let grade = await this.getSpecificRecord("grade", this.selectedGrade.id);
    //   if (grade.length > 0) {
    //     this.subjects = grade[0].subject;
    //     this.student_selectedSubjects = [];
    //   }
    // },
    // async getGrades(event) {
    //   this.grades = await this.getRecord("grade", event, false);
    //   if (this.titleInfo.pageType == "edit") {
    //     this.getStudent();
    //   }
    // },
    studentNext(e) {
      e.preventDefault();
      this.step = "parent-info";
    },
    parentBack(e) {
      e.preventDefault();
      this.step = "student-info";
    },
    parentNext(e) {
      e.preventDefault();
      this.step = "academic-info";
    },
    academicBack(e) {
      e.preventDefault();
      this.step = "parent-info";
    },
    getStudent() {
      this.loading = true;
      axios.get("/api/getStudent/" + this.$route.params.id).then((response) => {
        this.loading = false;
        let parentList = [];
        this.student_first_name = response.data.result[0].first_name;
        this.student_last_name = response.data.result[0].last_name;

        this.student_dob = new Date(response.data.result[0].DOB);
        this.student_phone = response.data.result[0].phone;
        this.student_email = response.data.result[0].email;
        this.student_address = response.data.result[0].country;
        this.student_image = response.data.result[0].student_image;

        response.data.result[0].parent &&
          response.data.result[0].parent.map((rec) => {
            parentList.push({
              address: rec.address,
              country: rec.country,
              email: rec.email,
              first_name: rec.first_name,
              last_name: rec.last_name,
              parent_id: rec.id,
              phone: rec.phone,
              state: rec.state,
              parent_image: rec.uploadPhoto,
            });
          });
        // this.dynamicParentList = response.data.result[0].parent;

        this.dynamicParentList = parentList;
      });
    },
  },
  mounted() {
    this.getSubjects(1);
  },
  mixins: [formMixins],
};
</script>


