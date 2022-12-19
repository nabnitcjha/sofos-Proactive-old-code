<template>
    <div class="main-container col-8 account-ativation">
        <div class="input-form" style="margin-top:5%">
            <div class="card">
                <div class="card-header">
                    Change Password
                </div> &nbsp;&nbsp;
                <div>
                    <h5 v-if="passwordNotMatch" style="color:red">password not match</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="form-group">
                            <label>New Password</label>
                            <input
                                type="password"
                                class="form-control"
                                placeholder="Enter New Password"
                                v-model="newPassword"
                            />
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input
                                type="password"
                                class="form-control"
                                placeholder="Confirm Password"
                                v-model="confirmPassword"
                            />
                        </div>
                        <button
                            class="btn send_btn"
                            @click.stop="activateAccount"
                        >
                            Save
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            newPassword: "",
            confirmPassword: "",
            user_status: 0,
            passwordNotMatch: false,
        };
    },
    methods: {
        activateAccount(event) {
            event.preventDefault();
            if (this.newPassword == this.confirmPassword) {
                this.passwordNotMatch = false;
                let formData = {};
                formData['token'] = this.$route.params.token;
                formData['password'] = this.newPassword;
                formData['user_status'] = 1;
                
                axios.post("/api/activateAccount", formData).then(response => {  
                    this.$router.push('/login/teacher');
                });
            }else{
                this.passwordNotMatch = true;
            }
        }
    },
    mounted() {
    }
};
</script>
<style>
.account-ativation{
    display: flex;
    justify-content: flex-end;
}
.account-ativation .input-form{
    width: 50%!important;
}
@media (max-width: 603px) {
    .text-center {
        text-align: center !important;
        margin-left: 20px !important;
    }
}
</style>
