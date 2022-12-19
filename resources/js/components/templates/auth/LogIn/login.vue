<template>
<div class="login-page">

 <div class="background">
  <div class="shape"></div>
  <div class="shape"></div>
</div>
<form>
  <div class="signup">signup</div>
  <h3>Login</h3>

  <label for="username">Username</label>
  <input type="text" class="login-signup" placeholder="Email or Phone" id="username" v-model="login.email">

  <label for="password">Password</label>
  <input type="password" class="login-signup" placeholder="Password" id="password" v-model="login.password">

  <button class="login-btn" @click="userlogin">Log In</button>
 
 <div class="forget-password" @click.stop="forgetPassword">Forget Password?</div>
  
</form>
</div>
  

    <!-- <div class="login__page">
        <div class="container-login">
            <div class="row justify-content-center">
                <div class="col-xl-10 col-lg-12 col-md-9">
                    <div class="card shadow-sm my-5 card-start">
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="login-form">
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-4">
                                                Login As
                                                {{ $route.params.type }}
                                            </h1>
                                        </div>
                                        <form class="user">
                                            <div class="form-group">
                                                <input
                                                    type="email"
                                                    v-model="login.email"
                                                    class="form-control"
                                                    id="exampleInputEmail"
                                                    aria-describedby="emailHelp"
                                                    placeholder="Enter Email Address"
                                                />
                                            </div>
                                            <div class="form-group">
                                                <input
                                                    type="password"
                                                    v-model="login.password"
                                                    class="form-control"
                                                    id="exampleInputPassword"
                                                    placeholder="Password"
                                                />
                                            </div>
                                          
                                            <div class="form-group">
                                                <a
                                                    class="btn btn-primary btn-block"
                                                    @click="userlogin"
                                                    >Login</a
                                                >
                                            </div>
                                        </form>
                
                                        <div class="text-center"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
</template>

<script>
import "./login.css";
import { mapGetters , mapActions } from "vuex"; 

export default {
    data: function() {
        return {
            login: {
                email: "",
                password: ""
            }
        };
    },
      computed: {
    ...mapGetters({
      user: "user"
    }),
  },
  watch:{
      user:function(newVal,oldVal){
           if (newVal.roleNames[0]=='admin') {
                    this.$router.push("/admin-dashboard");
                    this.setPageTitle('Dashboard');
                }
                if (newVal.roleNames[0]=='teacher') {
                    this.setPageTitle('Classes');
                    this.$router.push("/teacher-classes");
                }
                 if (newVal.roleNames[0]=='student') {
                    this.setPageTitle('Classes');
                    this.$router.push("/student-classes");
                }
                if (newVal.roleNames[0]=='parent') {
                    this.setPageTitle('Classes');
                    this.$router.push("/student-classes");
                }
                 
      }
  },
    methods: {
        forgetPassword(){
             this.$router.push('/forget-password'); 
        },
        loginFailed(errorMessage){
        this.$toast.open({
        message: errorMessage,
        type: "error",
        duration: 5000,
        dismissible: true,
      });
        },
        ...mapActions({
            afterLogin: "afterLogin",
            setPageTitle: "setPageTitle"
        }),
        userlogin(e) {
            let that = this;
            e.preventDefault();
            if(that.login.email==''){
                that.loginFailed('Please insert email address');
            }else if(that.login.password==''){
                that.loginFailed('Please insert correct password');
            }else{
                axios.post("/api/login", that.login).then(response => {
                localStorage.setItem("token", response.data.access_token);
                that.afterLogin(response.data);
            }).catch(function(error){
                that.loginFailed('login unsuccessful');
            });
            }
            
        }
    }
};
</script>
