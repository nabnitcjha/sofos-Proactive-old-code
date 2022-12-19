<template>
<div class="login-page">
    <div class="background">
      <div class="shape"></div>
       <div class="shape"></div>
    </div> 
          <form>
            <h3>Forget Password</h3>
             <label for="username">Email</label> 
             <input type="text" placeholder="Email or Phone" id="username" class="login-signup"  v-model="userEmail">
             <div class="forget-password">Enter the email address associated with your account.</div>
               <button class="login-btn"  @click.stop="sendMail">SEND</button>
              </form>
        </div>
<!-- <div>
<div id="highlighted" class="hl-basic hidden-xs">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-9 col-sm-offset-3 col-md-9 col-md-offset-3 col-lg-10 col-lg-offset-2">
        <h1 class="text-center">Forgot Password</h1>
      </div>
    </div>
  </div>
</div>
<div id="content" class="interior-page">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-9 col-md-9 col-lg-10 content equal-height">
        <div class="content-area-right">
          <div class="row">
            <div class="col-md-5 forgot-form">
              <p>Please enter your email address below and we will send you information to change your password.</p>
              <label class="label-default" for="un">Email Address</label> <input id="email_addy" name="email_addy" class="form-control" type="text" v-model="userEmail"><br>
              <a id="mybad" class="btn btn-primary" role="button" @click.stop="sendMail">I FORGOT</a>
            </div>
            <div class="col-md-5 forgot-return" v-if="isMailSend">
              <h2>Reset Link Sent</h2>
              <p>An email has been sent to your address with a reset Link  you can use to access your account.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
 -->

</template>
 
<script>
import "./forgetPassword.css";
import { mapGetters , mapActions } from "vuex"; 

export default {
    data: function() {
        return {
            userEmail:'', 
            isMailSend:false
        };
    },

     watch: {
    userEmail: function (newVal, oldVal) {
                if (newVal !='') {
                  this.isMailSend = false;
                }
    },
  },

    methods: {
      
        mailNotSend(errorMessage){
        this.$toast.open({
        message: errorMessage,
        type: "error",
        duration: 5000,
        dismissible: true,
      });
        },

        mailSendSuccessfully(){
        this.$toast.open({
        message: 'Mail send Successfully',
        type: "success",
        duration: 5000,
        dismissible: true,
      });
        },

                emailNotValid(){
        this.$toast.open({
        message: 'Email address is not valid',
        type: "error",
        duration: 5000,
        dismissible: true,
      });
        },

        sendMail(e) {
            let that = this;
            e.preventDefault();
            let formData = {};
             formData['userEmail'] = that.userEmail;
             if (that.userEmail=='') {
               that.mailNotSend('Email is empty');
             }else{
                axios.post("/api/forgot-password", formData).then(response => {
                if (response.data.status=='Email not registered') {
                  that.mailNotSend(response.data.status);
                }else{
                  that.mailSendSuccessfully();
                }
              that.userEmail = '';
              that.isMailSend = true;
            }).catch(function(error){
                that.mailNotSend(error.message);
            });
             }
           
        }
    }
};
</script>
