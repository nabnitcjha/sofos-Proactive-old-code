<template>
    <div class="chatIndex__page col-12">
        <vs-modal v-model="messageModal" class="modal-ac">
            <div slot="modal-header" class="modal-header">
                <span class="hp-3-title">{{ friendName }}</span>
                <v-icon @click.stop="messageModal = false">
                    mdi-close-circle</v-icon
                >
            </div>
            <div slot="modal-body" class="modal-body">
                <div class="panel-body-mobile" v-chat-scroll>
                    <chat-messages
                        :privateMessages="privateMessages"
                        :currentUserID="currentUserID"
                    ></chat-messages> 
                </div>
            </div>
            <div slot="modal-footer" class="modal-footer">
                <div class="panel-footer">
                    <chat-form v-on:messagesent="addMessage"></chat-form>
                </div>
            </div>
        </vs-modal>
        <div class="">
            <div class="chat-header col-12">
                <div class="col-6">
                    <form-title :titleInfo="titleInfo"></form-title>
                </div>

                <div class="col-6 chatIndex__page--header">
                    <span>{{ friendName }}</span>
                    <span>{{ friendEmail }}</span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-md-offset-2 chat__user--lists">
                    <div
                        v-for="(user, index) in students"
                        :key="index"
                        @click="letsChat(user, index)"
                        v-bind:class="[
                            'user-lists ',
                            index === clickedIndex ? user.teacher.length > 0?'allow-light-border':'allow-light-border div-hide' :  user.teacher.length > 0?'':'div-hide'
                        ]"
                          v-if="user.teacher.length > 0"
                    >
                        <div class="image__circle"  v-if="user.teacher.length > 0">
                            <figure v-if="user.image_url" class="">
                                <img
                                    class="image__circle"
                                    :src="user.image_url"
                                    alt=""
                                />
                            </figure>
                            <figure class="" v-else>
                                <i
                                    class="fa fa-user"
                                    style="transform: translate(76%,31%);"
                                ></i>
                            </figure>
                        </div>
                        <div class="chat__user--detials"  v-if="user.teacher.length > 0"> 
                            <span style="font-size: 15px;">{{
                                user.full_name
                            }}</span>
                            <span style="font-size: 11px;">{{
                                user.email
                            }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-md-offset-2 chat__user--message">
                    <div class="panel panel-default" v-if="openChatModal">
                        <div class="chatIndex-header"></div>

                        <div class="panel-body" v-chat-scroll>
                            <chat-messages
                                :privateMessages="privateMessages"
                                :currentUserID="currentUserID"
                            ></chat-messages>
                        </div>
                        <div class="panel-footer">
                            <chat-form
                                v-on:messagesent="addMessage"
                            ></chat-form> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import "./chat.css";
import ChatMessage from "../../molecules/chat/ChatMessages";
import ChatForm from "../../molecules/chat/ChatForm";
import formTitle from "../../molecules/common/formTitle";
import formMixins from "../../../Mixins/form";
export default {
    data: function() {
        return {
            currentUserID: 0,
            myDetail: "",
            friendId: 0,
            friendName: "",
            friendEmail: "",
            friendMobile:"",
            friendCountryCode:"",
            // students: [],
            privateMessages: [],
            openChatModal: false,
            messages: "",
            clickedIndex: -11,
            titleInfo: {
                pageTitle: "",
                // logo: "fa fa-chevron-left",
                // logoType: "icon",
                // actionName: "Back",
                // allowAction: true,
                // pageType: "chat"
            },
            messageModal: false
        };
    },
    props:{
        userType:String,
        students:Array,
        teacher:Object
    },
    components: {
        "chat-messages": ChatMessage,
        "chat-form": ChatForm,
        "form-title": formTitle
    },
    created() {
        window.Echo.private("privateChat").listen("ChatEvent", e => {
            this.realTime(e);
        });
    },
    methods: {
        classRemove() {
            let achors = document.querySelectorAll(".allow-light-border");
            achors.forEach(function(a) {
                a.classList.remove("allow-light-border");
            });
        },
        realTime(info) {
            let formData = {};
            formData["friendId"] = info.friendId;
            formData["my_ID"] = info.my_ID;
            axios
                .post("/getRealTimePrivateMessage", formData)
                .then(response => {
                    this.currentUserID = response.data.currentUserID;
                    let pvtMessages = [...this.privateMessages];
                    pvtMessages = response.data.privateMessage;
                    this.privateMessages = pvtMessages;
                    this.openChatModal = true;
                });
        },
        getUsers() {
            let formData = {};
            formData["userType"] = this.userType;
            this.setTokenToHeader();
            axios.post("/api/getUserList", formData).then(response => {
                let users = [...this.students];
                users = response.data.users;
                this.$emit("update-user-lists", users);
                // this.students = users;
            });
        },
        closeChatModal() {
            this.openChatModal = false;
        },
        letsChat(user, index) {
            if (this.clickedIndex == index) {
                return;
            }
            this.classRemove();
            this.clickedIndex = index;

            this.isMobileDevice();
            this.friendId = user.user_id;
            this.friendName = user.full_name;
            this.friendEmail = user.email;


            this.friendMobile = user.phoneNumber;
            this.friendCountryCode = user.studentCountryCode;

            let formData = {};
            formData["friendId"] = user.user_id;
            formData["myId"] = this.teacher.user_id;
            axios.post("/getPrivateMessage", formData).then(response => {
                this.currentUserID = response.data.currentUserID;
                let pvtMessages = [...this.privateMessages];
                pvtMessages = response.data.privateMessage;
                this.privateMessages = pvtMessages;
                this.openChatModal = true;
            });
        },
        fetchMessages(friendId) {
            axios.get("/messages").then(response => {
                this.messages = response.data;
            });
        },
        sendSMS(countryCode,number,message){
            let formData = {};
            formData['message'] = message["message"];
            formData['recipients'] ='+'+ countryCode+number;
            formData["friendId"] = this.friendId;
            axios.post('/api/sendMessage', formData).then(response => {
      
            let sendData = {};
            sendData["message"] = message["message"];
            sendData["friendId"] = this.friendId;
            sendData["myId"] = this.teacher.user_id;
            axios.post("/messages", sendData).then(response => {
                
                let info = {};
                info["friendId"] = this.friendId;
                info["myId"] = this.teacher.user_id;
                axios.post("/getPrivateMessage", info).then(response => {
                    
                    this.currentUserID = response.data.currentUserID;
                    let pvtMessages = [...this.privateMessages];
                    pvtMessages = response.data.privateMessage;
                    this.privateMessages = pvtMessages;
                    this.openChatModal = true;
                });
            });

            });
        },
        addMessage(message) {
            this.sendSMS(this.friendCountryCode,this.friendMobile,message);
            // let formData = {};
            // formData["message"] = message["message"];
            // formData["friendId"] = this.friendId;
            // formData["myId"] = this.teacher.user_id;
            
            // axios.post("/messages", formData).then(response => {
                
            //     let info = {};
            //     info["friendId"] = this.friendId;
            //     info["myId"] = this.teacher.user_id;
            //     axios.post("/getPrivateMessage", info).then(response => {
                    
            //         this.currentUserID = response.data.currentUserID;
            //         let pvtMessages = [...this.privateMessages];
            //         pvtMessages = response.data.privateMessage;
            //         this.privateMessages = pvtMessages;
            //         this.openChatModal = true;
            //     });
            // }); 
        },
        isMobileDevice: function() {
            var check = false;
            (function(a) {
                if (
                    /(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|iphone|od|iris|kindle|lge |maemo|midp|samsung|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(
                        a
                    ) ||
                    /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(
                        a.substr(0, 4)
                    )
                )
                    check = true;
            })(navigator.userAgent || navigator.vendor || window.opera);
            if (check) {
                this.messageModal = true;
            }
            return this.messageModal;
        }
    },
    mounted() {
        // this.getUsers();
    },
    mixins: [formMixins]
};
</script>
