<template>
  <div class="row add-teacher"> 
        <div class="col-lg-12">
          <b-overlay
          id="overlay-background"
          :show="show"
          :variant="variant"
          :opacity="opacity"
          :blur="blur"
          rounded="sm"
        >
          <div class="card mb-4 teacher-info" v-if="step == 'teacher-info'">
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
              <button
                type="button"
                class="btn btn-orange ml-2"
                @click="goBack"
            v-if="pageView!='RegisterTeacher'"

              >
                Back
              </button>
            </div>
            <div class="card-body col-lg-12">
              <form
              @submit="save"
              >
                <div class="form-group col-sm-6 col-lg-3">
                  <label for="teacherRegistration"><img :src="First_name">First Name</label>
                  <input
                    v-model="teacher_first_name"
                    type="text"
                    class="form-control"
                    id="teacherFirstName"
                    placeholder="First Name"
                    required
                  />
                </div>
                 <div class="form-group col-sm-6 col-lg-3">
                  <label for="teacherLastName"><img :src="Last_name">Last Name</label>
                  <input
                    v-model="teacher_last_name"
                    type="text"
                    class="form-control"
                    id="teacherLastName"
                    placeholder="Last Name"
                    required
                  />
                </div>

                
                <div class="form-group col-sm-6 col-lg-3">
                  <label for="teacherEmail"><img :src="Email">Email</label>
                  <input
                    v-model="teacher_email"
                    type="text"
                    class="form-control"
                    id="teacherEmail"
                    placeholder="Email"
                    required
                  />
                </div>
               
                <div class="form-group col-sm-6 col-lg-3">
                  <label for="teacherUploadPhoto" style="cursor: pointer"
                    ><img :src="Upload_form">Upload Photo</label
                  >
                  <input
                    v-model="teacherImageText"
                    type="text"
                    class="form-control"
                    id="teacherUploadPhoto"
                    placeholder="upload photo"
                    @click.stop="openteacherFileDialog"
                    style="caret-color: transparent; cursor: pointer"
                  />
                  <div class="custom-file">
                    <input
                      type="file"
                      class="custom-file-input col-sm-6 col-lg-3"
                      id="customFile"
                      @change="handleteacherFile"
                      style="visibility: hidden"
                    />
                    <label
                      class="custom-file-label"
                      for="customFile"
                      style="visibility: hidden"
                      id="teacher-image-upload"
                      >Choose file</label
                    >
                  </div>
                  <div>
                    <img
                      class="upload-image-size image-upload img-fluid-mobile"
                      :src="$root.getMedia(teacher_image)"
                      @click="handleteacherFile"
                      v-if="teacherImage == '' && teacher_image !='' && teacher_image != null" 
                    />
                    <img
                      class="upload-image-size image-upload img-fluid-mobile"
                      :src="teacherImage"
                      style=""
                      v-else
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
              <h6 class="m-0 text-primary">Contact Info</h6>
            </div>
            <div class="form-group col-sm-6 col-lg-3">
                  <label for="teacherFirstName"><img :src="Address">Address</label>
                  <input
                    v-model="teacher_address"
                    type="text"
                    class="form-control"
                    id="teacherFirstName"
                    placeholder="address"
                  />
                </div>
                <div class="form-group col-sm-6 col-lg-3">
                  <label for="teacherMiddleName"><img :src="Address">Address 2</label>
                  <input
                    v-model="teacher_address2"
                    type="text"
                    class="form-control"
                    id="teacherMiddleName"
                    placeholder="address"
                  />
                </div>
                <div class="form-group col-sm-6 col-lg-3">
                  <label for="teacherLastName"><img :src="Country">Country</label>
                  <input
                    v-model="teacher_country"
                    type="text"
                    class="form-control"
                    id="teacherLastName"
                    placeholder="country"
                  />
                </div>
                <div class="form-group col-sm-6 col-lg-3">
                  <label for="teacterstate"><img :src="State">&nbsp; state</label>
                  <input
                    v-model="teacher_state"
                    type="text"
                    class="form-control"
                    id="teacterstate"
                    placeholder="state"
                  />
                </div>
                <div class="form-group col-sm-6 col-lg-3">
                  <label for="teacherOccupation"><img :src="Postal_code">&nbsp; Postal code</label>
                  <input
                    v-model="teacher_zip"
                    type="text"
                    class="form-control"
                    id="teacherOccupation"
                    placeholder="postal code"
                  />
                </div>
                <div class="form-group col-sm-6 col-lg-3">
                  <label for="teacherPhone"><img :src="Phone">&nbsp; phone</label>
                  <input
                    v-model="teacher_phone"
                    type="text"
                    class="form-control"
                    id="teacherPhone"
                    placeholder="Phone"
                    required
                  />
                </div>
                <div class="form-group col-sm-6 col-lg-3">
                  <label for="teacheralternate_phone"><img :src="Phone">&nbsp; Alternate Contact</label>
                  <input
                    v-model="teacher_alternate_phone"
                    type="text"
                    class="form-control"
                    id="teacheralternate_phone"
                    placeholder="alternate_phone"
                  />
                </div>

                <div class="form-group col-12 back-next">
                  <!-- <button
                    class="btn  back-btn"
                    @click.stop="currentBack"
                  >
                    Back
                  </button> -->
                   <button
                    class="btn btn-save next-btn"
                    type="submit"
                  >
                    {{titleInfo.pageType == 'edit'?'Update':'Save'}}
                  </button>
                  <button
                type="button"
                class="btn btn-danger ml-2"
                @click="cancelTeacherRecord"
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
import { First_name,Last_name,Phone,Email,Dob,Address,Country,State,Upload_form,Postal_code } from "../../../Assets/formIcons/index";
import "vue-multiselect/dist/vue-multiselect.min.css";
import formMixins from "../../../Mixins/form";
import "./teacher.css";
import { mapGetters , mapActions } from "vuex"; 
export default {
  data: function () {
    return {
      show:false,
      First_name:First_name,
      Last_name:Last_name,
      Phone:Phone,
      Email:Email,
      Dob:Dob,
      Address:Address,
      Country:Country,
      State:State,
      Upload_form:Upload_form,
      Postal_code:Postal_code,

      step: "teacher-info",
      teacherGenders: [{ name: "male" }, { name: "female" }, { name: "other" }],
      teacherReligions: [
        { name: "hindu" },
        { name: "muslim" },
        { name: "other" },
      ],
      selectedteacherReligion: "",
      teacher_first_name: "",
      teacher_middle_name: "",
      teacher_last_name: "",
      selectedteacherGender: "",
      teacher_gender: "",
      teacher_dob: "",
      teacher_phone: "",
      teacher_email: "",
      teacher_religion: "",
      selectedGrade: [],
      grades: [],
      teacher_selectedSubjects: [],
      subjects: [],
      teacherImageText: "",
      teacher_image: "",
      teacherImage: "",

      teacher_address: "",
      teacher_address2: "",
      teacher_country: "",
      teacher_state: "",
      teacher_zip: "",
      teacher_phone: "",
      teacher_alternate_phone: "",

      teacher_highest_degree: "",
      teacher_collage: "",
      teacher_year_passed: "",
      teacher_cgpa: "",
      teacher_other_degree: "",
      teacher_other_collage: "",
      teacher_other_year_passed: "",
      teacher_other_cgpa: "",
    };
  },
  props: {
    titleInfo: Object
  },
  watch: {
    teacherImageText: function (newval, oldval) {
      this.openTeacherFileDialog();
    },
  },
  computed: {
    ...mapGetters({
      pageView:"pageView"
    }),
  },
  methods: {
    ...mapActions({
            teacherAddStatus: "teacherAddStatus"
        }),
    async getSubjects(event) {
      this.subjects= await this.getRecord("subject", event, false);
       if (this.titleInfo.pageType == 'edit') {
        this.getTeacher();
      }
    },
    cancelTeacherRecord(){
      this.teacher_first_name= "";
      this.teacher_middle_name= "";
      this.teacher_last_name= "";
      this.teacher_gender= "";
      this.teacher_dob= "";
      this.teacher_phone= "";
      this.teacher_email= "";
      this.teacher_religion= "";
      this.teacherImageText= "";
      this.teacher_image= "";
      this.teacherImage= "";

      this.teacher_address= "";
      this.teacher_address2= "";
      this.teacher_country= "";
      this.teacher_state= "";
      this.teacher_zip= "";
      this.teacher_phone= "";
      this.teacher_alternate_phone= "";
    },
    async save(e) {
      e.preventDefault();
      this.show=true;
      // if(this.teacher_first_name==""){
      //   this.textValidation('teacher first name required');
      //   return;
      // }else if(this.teacher_last_name==""){
      //   this.textValidation('teacher last name required');
      //   return;
      // }else if(this.teacher_email==""){
      //   this.textValidation('teacher email required');
      //   return;
      // }
      // let teacher_dob = await this.dateFormater(this.teacher_dob);
      // let teacher_year_passed = await this.dateFormater(
      //   this.teacher_year_passed
      // );
      // let teacher_other_year_passed = await this.dateFormater(
      //   this.teacher_other_year_passed
      // );
      //let time_am_pm = await this.dateFormater_AM_PM(this.student_dob);
      var form = new FormData();
      form.append("teacher_first_name", this.teacher_first_name);
      // form.append("teacher_middle_name", this.teacher_middle_name);
      form.append("teacher_last_name", this.teacher_last_name);

      form.append("teacher_gender", this.teacher_gender);
      // form.append("teacher_dob", teacher_dob);
      form.append("teacher_phone", this.teacher_phone);
      form.append("teacher_email", this.teacher_email);
      form.append("teacher_religion", this.teacher_religion);

      form.append("teacher_image", this.teacher_image);

      form.append("teacher_address", this.teacher_address);
      form.append("teacher_address2", this.teacher_address2);
      form.append("teacher_country", this.teacher_country);
      form.append("teacher_state", this.teacher_state);
      form.append("teacher_zip", this.teacher_zip);
      form.append("teacher_phone", this.teacher_phone);
      form.append("teacher_alternate_phone", this.teacher_alternate_phone);
      // form.append("teacher_highest_degree", this.teacher_highest_degree);
      // form.append("teacher_collage", this.teacher_collage);
      // form.append("teacher_year_passed", teacher_year_passed);
      // form.append("teacher_cgpa", this.teacher_cgpa);
      // form.append("teacher_other_degree", this.teacher_other_degree);
      // form.append("teacher_other_collage", this.teacher_other_collage);
      // form.append("teacher_other_year_passed", teacher_other_year_passed);
      // form.append("teacher_other_cgpa", this.teacher_other_cgpa);
      
      if (this.titleInfo.pageType == 'edit') {
        form.append("teacher_id", this.$route.params.id);
          axios.post("/api/updateTeacher", form).then((response) => {
            this.teacherAddStatus(true);
            this.addStatus('Teacher Update Successfully');
            this.$router.push("/teacher");
      });
      }else{
        
         axios.post("/api/addTeacher", form).then((response) => {
          this.teacherAddStatus(true);
          this.addStatus('Teacher Add Successfully');
         this.$router.push("/teacher");
      });
      }
    },
    async getGrades(event) {
      this.grades = await this.getRecord("grade", event, false);
      if (this.titleInfo.pageType == 'edit') {
        this.getTeacher();
      }
    },
    teacherNext() {
      this.step = "current-info";
    },
    currentBack() {
      this.step = "teacher-info";
    },
    currentNext() {
      this.step = "academic-info";
    },
    academicBack() {
      this.step = "current-info";
    },
    updateselectedteacherGender() {
      this.teacher_gender = this.selectedteacherGender.name;
    },
    updateselectedteacherReligion() {
      this.teacher_religion = this.selectedteacherReligion.name;
    },
    // async updateSelectedGrade(type) {
    //   if (type=='whenGradeChange') {
    //     this.teacher_selectedSubjects = [];
    //   }
    //   let gradeIds = [];
    //   let i = 0;
    //   this.selectedGrade.map((grade) => {
    //     i = i + 1;
    //     gradeIds.push(grade.id);
    //     if (this.selectedGrade.length == i) {
    //       let formData = {};
    //       formData["grade_ids"] = gradeIds;
    //       axios
    //         .post("/api/getSubjectAccordingGrade", formData)
    //         .then((response) => {
    //           this.subjects = response.data.result;
    //         });
    //     }
    //   });
    // },
    openTeacherFileDialog() {
      if (this.teacherImageText == "") {
        return;
      }
      $("#teacher-image-upload").click();
      this.teacherImageText = "";
    },
    openteacherFileDialog() {
      $("#teacher-image-upload").click();
      this.teacherImageText = "";
    },
    handleteacherFile(e) {
      this.teacher_image = e.target.files[0];
      // this.userImage = e.target.files[0];
      const file = document.querySelector("input[type=file]").files[0];
      const callBack = (imgUrl) => {
        this.teacherImage = imgUrl;
      };

      const reader = new FileReader();
      reader.addEventListener(
        "load",
        function () {
          // convert image file to base64 string
          this.teacherImage = reader.result;
          callBack(reader.result);

          document.getElementById("teacher-image-upload").value = "";
        },
        false
      );
      reader.readAsDataURL(file);
    },
    getTeacher() {
      axios.get("/api/getTeacher/" + this.$route.params.id).then((response) => {
        // response.data.result[0].grade.map((val) => {
        //   this.selectedGrade.push({
        //     id: val.id,
        //     name: val.name,
        //   });
        // });
        // response.data.result[0].subject.map((val) => {
        //   this.teacher_selectedSubjects.push({
        //     id: val.id,
        //     name: val.name,
        //   });
        // });
        // this.updateSelectedGrade('fromGetTeacher');
     
        this.teacher_first_name = response.data.result[0].first_name=="null"?'':response.data.result[0].first_name;
        // this.teacher_middle_name = response.data.result[0].middle_name;
        this.teacher_last_name = response.data.result[0].last_name=="null"?'':response.data.result[0].last_name;

        // this.teacher_gender = response.data.result[0].gender;
        // this.teacher_dob = new Date(response.data.result[0].DOB);
        // this.teacher_phone = response.data.result[0].phone;
        this.teacher_email = response.data.result[0].email;
        // this.teacher_religion = response.data.result[0].religion;

        this.teacher_image = response.data.result[0].teacher_image=="null"?'':response.data.result[0].teacher_image;

        this.teacher_address = response.data.result[0].address=="null"?'':response.data.result[0].address;
        this.teacher_address2 = response.data.result[0].address2=="null"?'':response.data.result[0].address2;
        this.teacher_country = response.data.result[0].country=="null"?'':response.data.result[0].country;
        this.teacher_state = response.data.result[0].state=="null"?'':response.data.result[0].state;
        this.teacher_zip = response.data.result[0].zip=="null"?'':response.data.result[0].zip;
        this.teacher_phone = response.data.result[0].phone=="null"?'':response.data.result[0].phone;
        this.teacher_alternate_phone = response.data.result[0].alternate_phone=="null"?'':response.data.result[0].alternate_phone;
        // this.teacher_highest_degree = response.data.result[0].highest_degree;
        // this.teacher_collage = response.data.result[0].university;
        // this.teacher_year_passed = new Date(
        //   response.data.result[0].year_passed
        // );
        // this.teacher_cgpa = response.data.result[0].cgpa;
        // this.teacher_other_degree = response.data.result[0].other_degree;
        // this.teacher_other_collage = response.data.result[0].other_university;
        // this.teacher_other_year_passed = new Date(
        //   response.data.result[0].other_year_passed
        // );
        // this.teacher_other_cgpa = response.data.result[0].other_cgpa;
      });
    },
  },
  mounted() {
    this.getTeacher();
  },
  mixins: [formMixins],
};
</script>

