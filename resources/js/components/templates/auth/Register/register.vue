<template>
    <div class="register__page">
        <!-- Register Content -->
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
                                                Register As {{ $route.params.type }}
                                            </h1>
                                        </div>
                                        <form>
                                            <div class="form-group">
                                                <label>First Name</label>
                                                <input
                                                    type="text"
                                                    v-model="
                                                        register.first_name
                                                    "
                                                    class="form-control"
                                                    id="exampleInputFirstName"
                                                    placeholder="Enter First Name"
                                                />
                                            </div>
                                            <div class="form-group">
                                                <label>Last Name</label>
                                                <input
                                                    type="text"
                                                    v-model="register.last_name"
                                                    class="form-control"
                                                    id="exampleInputLastName"
                                                    placeholder="Enter Last Name"
                                                />
                                            </div>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input
                                                    type="email"
                                                    v-model="register.email"
                                                    class="form-control"
                                                    id="exampleInputEmail"
                                                    aria-describedby="emailHelp"
                                                    placeholder="Enter Email Address"
                                                />
                                            </div>
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input
                                                    type="password"
                                                    v-model="register.password"
                                                    class="form-control"
                                                    id="exampleInputPassword"
                                                    placeholder="Password"
                                                />
                                            </div>
                                            <!-- <div class="form-group">
                      <label>Repeat Password</label>
                      <input type="password" v-model="register.confirmPassword"  class="form-control" id="exampleInputPasswordRepeat"
                        placeholder="Repeat Password">
                    </div> -->
                                            <div class="form-group">
                                                <button
                                                    class="btn btn-primary btn-block"
                                                    @click="submit"
                                                >
                                                    Register
                                                </button>
                                            </div>
                                            <hr />
                                        <div class="text-center">
                                            <span>Already an Account!</span>
                                            <router-link :to="'/login/'+`${$route.params.type}`"
                                                ><span style="color:orange">LogIn</span>
                                            </router-link>
                                        </div>
                                            <!-- <a href="index.html" class="btn btn-google btn-block">
                      <i class="fab fa-google fa-fw"></i> Register with Google
                    </a>
                    <a href="index.html" class="btn btn-facebook btn-block">
                      <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                    </a> -->
                                        </form>
                                        <!-- <hr>
                  <div class="text-center">
                    <a class="font-weight-bold small" href="login.html">Already have an account?</a>
                  </div>
                  <div class="text-center">
                  </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Register Content -->
    </div>
</template>

<script>
import "./register.css";
import axios from "axios";
export default {
    data: function() {
        return {
            register: {
                first_name: "",
                last_name: "",
                email: "",
                password: "",
                confirmPassword: "",
                messageColor: ""
            }
        };
    },
    methods: {
        submit() {

            let formData = {};
            formData["name"] =
                this.register.first_name + " " + this.register.last_name;
            formData["email"] = this.register.email;
            formData["password"] = this.register.password;

            axios.post("/api/register", formData).then(response => {
                let makeEmpty = { ...this.register };
                makeEmpty = {};
                this.register = makeEmpty;
            });
        }
    }
};
</script>
