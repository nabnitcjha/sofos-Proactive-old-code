<template>
    <div class="chatform__page">
         <div class="input-group">
        <input id="btn-input" type="text" name="message" class="form-control input-sm type-message-input" placeholder="Type your message here..." v-model="newMessage" @keyup.enter="sendMessage">
        <span class="input-message-svg"  @click="sendMessage">
                <img
                            class="img-profile rounded-circle"
                            :src="Ellipse"
                            style="border: none!important;"
                        />
                          <img
                            class="arrow-svg"
                            :src="Vector"
                            style=""
                        />
        </span>
    </div>
    </div>
</template>

<script>
import  "./style.css";
import {Ellipse,Vector} from "../../../Assets/index"
export default {
    props: {},

    data() {
        return {
            newMessage: "",
            Ellipse:Ellipse,
            Vector:Vector
        }; 
    },

    methods: {
        sendMessage() {
            this.$emit("messagesent", {  
                message: this.newMessage
            });

            this.newMessage = "";
        }
    }
};
</script>
