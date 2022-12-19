<template>
   <div class="row parent-profile card-common-design">
        <div class="col-lg-12 detail-card">
          <!-- Form Basic -->
          <div class="card mb-4 col-lg-12">
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
              <h6 class="m-0 font-weight-bold text-primary">Profile Info</h6>
            </div>
            <div class="profile-seperator">
              <div class="card-body img-body col-sm-12 col-lg-4">
                <label
                  for="cover-upload"
                  class="custom-file-upload"
                  id="image-upload-from-label"
                >
                </label>
                <input
                  ref="imgfile"
                  type="file"
                  @change="handleFile"
                  name="user_image"
                  accept="image/*"
                  id="cover-upload"
                  style="visibility: hidden"
                />
                <img
                  class="upload-image-size image-upload img-fluid-mobile"
                  :src="user.user_image == 0 ? adminImage:$root.getMedia(user.user_image)"
                  @click="handleAdminFile"
                />
                <i class="fas fa-pencil-alt edit-icon" @click="handleAdminFile"></i>
              </div>
              <div class="card-body info-body col-sm-12 col-lg-8">
                <form>
                  <div class="form-group col-sm-6 col-lg-6 text-justify">
                    <label for="adminEmail">email</label>
                    <input
                      v-model="email"
                      type="text"
                      class="form-control"
                      id="adminEmail"
                      placeholder="Enter Name"
                      disabled
                    />
                  </div>

                  <div class="form-group col-sm-6 col-lg-6 text-justify">
                    <label for="adminName">Name</label>
                    <input
                      v-model="name"
                      type="text"
                      class="form-control"
                      id="adminName"
                      placeholder="Enter Name"
                    />
                  </div>
                  <div class="form-group col-sm-6 col-lg-6 text-justify">
                    <label for="exampleInputPassword1">Password</label>
                    <input
                      v-model="password"
                      type="password"
                      class="form-control"
                      id="exampleInputPassword1"
                      placeholder="Password"
                    />
                  </div>
                  <div class="form-group col-sm-6 col-lg-6 text-justify">
                    <label for="confirmPassword">Confirm Password</label>
                    <input
                      v-model="c_password"
                      type="password"
                      class="form-control"
                      id="confirmPassword"
                      placeholder="Password"
                    />
                  </div>

                  <button
                    type="button"
                    class="btn btn-success"
                    @click.stop="changeProfile"
                  >
                    Change
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
</template>

<script>
import { Student } from "../../../Assets/dashboard/index";
import { mapGetters,mapActions } from "vuex";
import "./profile.css";
export default {
  data: function () {
    return {
      adminImage: Student,
      userImage: "",
      admin_image: "",
      name:"",
      password:"",
      c_password:"",
      email:""
    };
  },
   computed: {
    ...mapGetters({
      user: "user",
    }),
  },
  methods: {
        ...mapActions({
            reloadUser: "reloadUser"
        }),
       passwordNotMatch() {
      this.$toast.open({
        message: "password not match",
        type: "error",
        duration: 5000,
        dismissible: true,
      });
    },
      passwordChange() {
      this.$toast.open({
        message: "password change successfully",
        type: "success",
        duration: 5000,
        dismissible: true,
      });
    },
    imageChange() {
      this.$toast.open({
        message: "image change successfully",
        type: "success",
        duration: 5000,
        dismissible: true,
      });
    },
    changeProfile(e) {
      e.preventDefault();
    if (this.password = this.c_password) {
        let formData = {};
     formData['name']= this.name;
     formData['password'] = this.password;
      axios
        .post("/api/updateAdminProfile", formData)
        .then((response) => {
          this.name='';
          this.password = '';
          this.c_password = '';
          this.passwordChange();
        })
        .catch((error) => console.log("err ==>>", error));
    }else{
        this.passwordNotMatch();
    }
     
    },
    handleFile(e) {
      this.userImage = e.target.files[0];
      // const preview = document.querySelector('.img-profile');
      const file = document.querySelector("input[type=file]").files[0];

      const callBack = (imgUrl) => {
        this.adminImage = imgUrl;
        this.addImage();
      };

      const reader = new FileReader();
      reader.addEventListener(
        "load",
        function () {
          // convert image file to base64 string
          // preview.src = reader.result;
          callBack(reader.result);

          document.getElementById("cover-upload").value = "";
        },
        false
      );
      reader.readAsDataURL(file);
    },
    handleAdminFile() {
      $("#image-upload-from-label").click();
    },
    addImage() {
      var form = new FormData();
      form.append("userImage", this.userImage);
      form.append("mode", 'common');
      axios
        .post("/api/uploadImage", form)
        .then((response) => {
          this.reloadUser(response.data.result);
          this.imageChange();
        })
        .catch((error) => console.log("err ==>>", error));
    },
  },
  mounted() {
      this.name = this.user.name;
      this.email= this.user.email;
  },
};
</script>

