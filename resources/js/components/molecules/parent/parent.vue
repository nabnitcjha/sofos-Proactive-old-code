<template>
  <div class="row add-student spinner-position">
    <b-spinner
      style="width: 3rem; height: 3rem"
      label="Large Spinner"
      variant="success"
      v-show="loading"
    ></b-spinner>
    <div class="col-lg-12">
   
      <div class="card mb-4 student-info">
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
          <h6 class="m-0 text-primary">Parent Info</h6>
        </div>

        <div class="card-body col-lg-12">
          <form
          @submit="save"
          >
            <!-- ------------ dynamic add parent field -------------- -->
            <div
              class="dynamic-add-parent col-12"
              v-for="(input, index) in dynamicParentList"
              :key="index"
            >
              <div class="form-group col-sm-6 col-lg-3">
                <label for="studentFirstName">First Name</label>
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
                <label for="studentLastName">Last Name</label>
                <input
                  v-model="input.last_name"
                  type="text"
                  class="form-control"
                  id="studentLastName"
                  placeholder="Last Name"
                  @change="changeField($event, 'last_name', input.parent_id)"
                />
              </div>

              <div class="form-group col-sm-6 col-lg-3">
                <label for="studentPhone">Contact</label>
                <input
                  v-model="input.phone"
                  type="text"
                  class="form-control"
                  id="studentPhone"
                  placeholder="Phone"
                  @change="changeField($event, 'phone', input.parent_id)"
                />
              </div>

              <div class="form-group col-sm-6 col-lg-3">
                <label for="studentEmail">Email</label>
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
                <label for="studentAddress">Address</label>
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
                <label for="studentCountry">Country</label>
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
                <label for="studentState">State</label>
                <input
                  v-model="input.state"
                  type="text"
                  class="form-control"
                  id="studentState"
                  placeholder="State"
                  @change="changeField($event, 'state', input.parent_id)"
                />
              </div>

              <!-- <div class="form-group col-12 add-guardian" v-if="index==0">
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
              </div> -->
            </div>
            <!-- ------------ dynamic add parent field end ---------- -->
            <div class="form-group col-12 action-btn text-right">
              <!-- <button class="btn btn-primary back-btn" @click.stop="parentBack">
                Back
              </button> -->
              <button class="btn btn-save next-btn text-right">
                {{ titleInfo.pageType == "edit" ? "Update" : "Save" }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
 
 <script>
import { mapGetters } from "vuex";
import "vue-multiselect/dist/vue-multiselect.min.css";
import formMixins from "../../../Mixins/form";
export default {
  data: function () {
    return {
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
          uploadPhoto: "",
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
   computed: {
    ...mapGetters({
      user: "user",
    }),
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
  methods: {
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
        uploadPhoto: "",
      });
      this.dynamicParentList = dynamicList;
    },
    removeParent(parent_id) {
      this.dynamicParentList=this.dynamicParentList.filter(parentItem=>parentItem.parent_id !== parent_id);
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
      
      formData["dynamic_parent_list"] = this.dynamicParentList;
      if(this.$route.name== "add-parent-from-detail"){
        formData["student_id"] = this.$route.params.id;
        axios.post("/api/addParentFromDetail", formData).then((response) => {
            
            this.loading = false;
            this.$router.go(-1);
        });
      }
      formData['parent_id'] = this.user.parent.id;
      if (this.titleInfo.pageType == "edit") {
        
        formData["student_id"] = this.$route.params.id;
        axios.post("/api/updateParent", formData).then((response) => {
            this.loading = false;
            this.$router.push("/parent");
        });
      } else {
          
        axios.post("/api/addParent", formData).then((response) => {
            
            this.loading = false;
            this.$router.push("/parent");
        });
      }
    },
    handleStudentFile(e) {
      this.student_image = e.target.files[0];
      // this.userImage = e.target.files[0];
      const file = document.querySelector("input[type=file]").files[0];
      const callBack = (imgUrl) => {
        this.studentImage = imgUrl;
        this.addImage();
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
    handleParentFile(e) {
      this.parent_image = e.target.files[0];
      // this.userImage = e.target.files[0];
      const file = document.querySelector("input[type=file]").files[0];
      const callBack = (imgUrl) => {
        this.parentImage = imgUrl;
        this.addImage();
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
      reader.readAsDataURL(file);
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
        this.student_first_name = response.data.result[0].first_name;
        this.student_last_name = response.data.result[0].last_name;

        this.student_dob = new Date(response.data.result[0].DOB);
        this.student_phone = response.data.result[0].phone;
        this.student_email = response.data.result[0].email;
        
        this.dynamicParentList = response.data.result[0].parent;
        
      });
    },
  },
  mounted() {
    // this.getSubjects(1);
  },
  mixins: [formMixins],
};
</script>