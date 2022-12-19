<template>
    <div class="sendSMS__page">
        <div class="input-form" style="margin-top:5%">
            <div class="card card-common-design col-6" style="text-align:justify;">
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

                        <button  class="btn send_btn mt-3" @click.stop="registerUser">
                            Send SMS
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import "./style.css";
export default {
    data: function() {
        return {
            message: '',
            recipients: '',
            countryCode: ''
        };
    },
    methods:{
        smsNotSend(errorMessage){
        this.$toast.open({
        message: errorMessage,
        type: "error",
        duration: 5000,
        dismissible: true,
      });
        },

        smsSendSuccessfully(){
        this.$toast.open({
        message: 'SMS send Successfully',
        type: "success",
        duration: 5000,
        dismissible: true,
      });
        },

        countryChanged(country) {
            this.countryCode = country.dialCode
    },
        registerUser(e){
            
           let that = this;
            
            e.preventDefault();
            if (that.recipients=='') {
                that.smsNotSend('Phone Field is empty');
            }else{
                axios.defaults.headers.common["Authorization"] =
                "Bearer " + localStorage.getItem("token");
            let formData = {};
            formData['message'] = that.message;
            formData['recipients'] ='+'+ that.countryCode+that.recipients;
           
            axios.post('/api/sendMessage', formData).then(response => {
                
                that.smsSendSuccessfully();
                that.message ='';
                that.recipients='';
            }).catch(function(error){
                that.smsNotSend('Message not Send !! Number is not Registerd');
                that.message ='';
                that.recipients='';
            });
            }
        }
    },
    mounted() {

    }
};
</script>
