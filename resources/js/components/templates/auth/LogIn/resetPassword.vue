<template>
  <div>
    <div id="highlighted" class="hl-basic hidden-xs">
      <div class="container-fluid">
        <div class="row">
          <div
            class="
              col-sm-9
              col-sm-offset-3
              col-md-9
              col-md-offset-3
              col-lg-10
              col-lg-offset-2
            "
          >
            <h1 class="text-center">Reset Password</h1>
          </div>
        </div>
      </div>
    </div>
    <div id="content" class="interior-page">
      <div class="container-fluid">
        <div class="row">
          <!--Sidebar-->

          <!--Content-->
          <div class="col-sm-9 col-md-9 col-lg-10 content equal-height">
            <div class="content-area-right">
              <div class="row">
                <div class="col-md-5 forgot-form">
                  <p>Please enter your new password</p>
                  <label class="label-default" for="un">New Password</label>
                  <input
                    id="email_addy"
                    name="email_addy"
                    class="form-control"
                    type="password"
                    v-model="newPassword"
                  /><br />
                  <label class="label-default" for="un">Confirm Password</label>
                  <input
                    id="email_addy"
                    name="email_addy"
                    class="form-control"
                    type="password"
                    v-model="confirmPassword"
                  /><br />
                  <a
                    id="mybad"
                    class="btn btn-primary"
                    role="button"
                    @click.stop="resetPassword"
                    >SAVE</a
                  >
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
 
<script>
import "./forgetPassword.css";

export default {
  data: function () {
    return {
      newPassword:'',
      confirmPassword: "",
    };
  },

  methods: {
    passwordChange() {
      this.$toast.open({
        message: "Password Change Successfully",
        type: "success",
        duration: 5000,
        dismissible: true,
      });
    },
    passwordNotMatch() {
      this.$toast.open({
        message: "Password not match",
        type: "Error",
        duration: 5000,
        dismissible: true,
      });
    },

    serverIssue(svrError) {
      this.$toast.open({
        message: svrError,
        type: "Error",
        duration: 5000,
        dismissible: true,
      });
    },

    resetPassword(e) {
      let that = this;
      e.preventDefault();
      if (this.newPassword != this.confirmPassword) {
        that.passwordNotMatch();
      } else {
        let formData = {};
        formData["password"] = that.newPassword;
        formData["id"] = this.$route.params.userId;
        axios
          .post("/api/reset-password", formData)
          .then((response) => {
              this.newPassword = '';
              this.confirmPassword = '';
            that.passwordChange();
          })
          .catch(function (error) {
            that.serverIssue(error.message);
          });
      }
    },

  }
};
</script>
