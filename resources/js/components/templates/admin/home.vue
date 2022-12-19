<template>
    <div class="hometemplate__page">
        <div class="header">
            <common-header :isForHome="isForHome" 
            :parentType="parentType"
            :teacherAPI="teacherAPI"
            :studentAPI="studentAPI"
            ></common-header> 
        </div> 
        <!-- <div class="input-form" style="margin-top:5%">
            <div class="card">
                <div class="card-header">
                    Send SMS
                </div>
                <div class="card-body">
                    <form>
                        <div class="form-group">
                            <label>Enter Phone Number</label>
                           
                            <vue-tel-input v-model="recipients"
                             v-on:country-changed="countryChanged"
                            ></vue-tel-input>
                        </div>
                        <div class="form-group">
                            <label>Enter Message</label>
                            <textarea
                                type="tel"
                                class="form-control"
                                placeholder="Enter Message"
                                v-model="message"
                            />
                        </div>
                        <button  class="btn send_btn" @click.stop="registerUser">
                            Send SMS
                        </button>
                    </form>
                </div>
            </div>
        </div> -->
    </div>
</template> 

<script>
import commonHeader from "../../molecules/common/header"; 
import sendSMS from "./sendSMS.vue";
import "./style.css";
export default {
    data: function() {
        return {
            isForHome: true,
            message: '',
            recipients: '',
            countryCode: '',
            parentType: 'admin',
            teacherAPI: 'all-active-teacher',
            studentAPI: 'all-active-student'
        };
    },
    components: {
        "common-header": commonHeader, 
        "send-sms": sendSMS
    },
    methods:{
        countryChanged(country) {
            this.countryCode = country.dialCode
    },
        registerUser(){
            axios.defaults.headers.common["Authorization"] =
                "Bearer " + localStorage.getItem("token");
            let formData = {};
            formData['message'] = this.message;
            formData['recipients'] ='+'+ this.countryCode+this.recipients;
            axios.post('/api/sendMessage', formData).then(response => {
                this.message ='';
                this.recipients='';
            });
        }
    },
    mounted() {
        
    }
};
</script>
