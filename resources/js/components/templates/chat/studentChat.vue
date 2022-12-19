<template>
<div class="wrapper-content">
        <main class="content chat-message">
          <div class="container p-0">
          <div class="card">
            <div class="row g-0">
              <div class="col-12 col-lg-5 col-xl-3 border-right">
      
                <div class="px-4 d-none d-md-block">
                  <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                      <!-- <input type="text" class="form-control my-3" placeholder="Search..."> -->
                    </div>
                  </div>
                </div>


                <a class="list-group-item list-group-item-action border-0" 
                @click.stop="openChat(user,index)"
              v-for="(user, index) in userLists"
              :key="index"
                >
                  <!-- <div class="badge bg-success float-right">5</div> -->
                  <div class="d-flex align-items-start">
                    <img  :src="require('./profile.jpg').default" class="rounded-circle mr-1" alt="Vanessa Tucker" width="40" height="40">
                    <div class="flex-grow-1 ml-3"  v-if="index==0">
                      {{ user.name }}
                      <!-- <div class="small"><span class="fas fa-circle chat-online"></span> Online</div> -->
                    </div>
                     <div class="flex-grow-1 ml-3"  v-else>
                      {{ user.first_name }}{{' '}}{{ user.last_name }}
                      <!-- <div class="small"><span class="fas fa-circle chat-online"></span> Online</div> -->
                    </div>
                  </div>
                </a>
                <hr class="d-block d-lg-none mt-1 mb-0">
              </div>
              <div class="col-12 col-lg-7 col-xl-9"  v-if="isChatOpen">
                <div class="py-2 px-4 border-bottom d-none d-lg-block">
                  <div class="d-flex align-items-center py-1">
                    <div class="position-relative">
                      <img  :src="require('./profile.jpg').default" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">
                    </div>
                    <div class="flex-grow-1 pl-3 friend-name">
                      <strong>{{ friendName }}</strong>
                       <span
                class="teacher-type"
                >{{ currentIndex == 0 ?'admin':'teacher'}}</span
              >
                      <!-- <div class="text-muted small"><em>Typing...</em></div> -->
                    </div>
                    <!-- <div>
                      <button class="btn btn-primary btn-lg mr-1 px-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone feather-lg"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg></button>
                      <button class="btn btn-info btn-lg mr-1 px-3 d-none d-md-inline-block"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-video feather-lg"><polygon points="23 7 16 12 23 17 23 7"></polygon><rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect></svg></button>
                      <button class="btn btn-light border btn-lg px-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal feather-lg"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg></button>
                    </div> -->
                  </div>
                </div>
      
                <div class="position-relative">
                  <div class="chat-messages p-4">
      
                    <div 
                     v-bind:class="[
                  '',
                  currentUserID == message.my_id
                    ? 'chat-message-right pb-4'
                    : 'chat-message-left pb-4',
                ]"
                v-for="(message, index) in privateMessages"
                :key="index"
                    >
                      <div>
                        <img  :src="require('./profile.jpg').default" class="rounded-circle mr-1" alt="Chris Wood" width="40" height="40">
                        <div class="text-muted small text-nowrap mt-2">2:33 am</div>
                      </div>
                      <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3"  v-if="message.user.id==1">
                        <div class="font-weight-bold mb-1">{{currentUserID == message.my_id?'You':message.user.name}}</div>
                          {{ message.message }}
                      </div><div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3"  v-else>
                        <div class="font-weight-bold mb-1">{{currentUserID == message.my_id?'You':message.user.first_name + ' ' + message.user.last_name}}</div>
                          {{ message.message }}
                      </div>

                    </div>
                  </div>
                </div>
      
                <div class="flex-grow-0 py-3 px-4 border-top">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Type your message" v-model="message">
                    <button class="btn btn-primary" 
                    @click.stop="sendMessage"
                    >Send</button>
                  </div>
                </div>
      
              </div>
            </div>
          </div>
        </div>
      </main>   
  </div>
  <!-- <div class="row card-common-design admin-chat">
    <div class="col-lg-3 detail-card change-password-card">
      <div class="card mb-4 col-12">
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
          <h6 class="m-0 font-weight-bold text-primary">Teachers</h6>
        </div>
        <div class="card-body chat-left-card">
          <form class="user-list">
            <div
              class="form-group"
              @click.stop="openChat(user,index)"
              v-for="(user, index) in userLists"
              :key="index"
            >
              <div class="user-name" v-if="index==0">
                {{ user.name }}
              </div>
              <div class="user-name" v-else>
                {{ user.first_name }}{{' '}}{{ user.last_name }}
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-lg-9 detail-card change-password-card" v-if="isChatOpen">
      <div class="card mb-4 col-12">
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
          <h6 class="m-0 font-weight-bold text-primary">{{ friendName }}
          <span
                class="teacher-type"
                >{{ currentIndex == 0 ?'admin':'teacher'}}</span
              >
          </h6>
        </div>
        <div class="card-body">
          <div class="form-group col-sm-6 col-lg-12 chat-body">
            <ul class="chat">
              <li
                v-bind:class="[
                  '',
                  currentUserID == message.my_id
                    ? 'myMessage'
                    : 'friendMessage',
                ]"
                v-for="(message, index) in privateMessages"
                :key="index"
              >
                <div class="chat-body">
                  <div class="header">
                    <strong class="primary-font" v-if="message.my_id==1">
                      {{ message.user.name }}
                    </strong>
                    <strong class="primary-font" v-else>
                      {{ message.user.first_name }}{{' '}}{{ message.user.last_name }}
                    </strong>
                  </div>
                  <p>
                    {{ message.message }}
                  </p>
                </div>
              </li>
            </ul>
          </div>
          <div class="input-group">
            <input
              id="btn-input"
              type="text"
              name="message"
              class="form-control input-sm type-message-input"
              placeholder="Type your message here..."
              v-model="message"
              @keyup.enter="sendMessage"
            />
            <span class="input-message-svg" @click="sendMessage">
              <img
                class="img-profile rounded-circle"
                :src="Ellipse"
                style="border: none !important"
              />
              <img class="admin-arrow-svg" :src="Vector" style="" />
            </span>
          </div>
        </div>
      </div>
    </div>
  </div> -->
</template>

<script>
import { mapGetters } from "vuex";
import "./chat.css";
import formMixins from "../../../Mixins/form";
import { Ellipse, Vector } from "../../../Assets/chat/index";
export default {
  data: function () {
    return {
      isChatOpen: false,
      userLists: [],
      friendId: "",
      friendName: "",
      friendEmail: "",
      Ellipse: Ellipse,
      Vector: Vector,
      privateMessages:[],
      currentUserID:'',
      message:'',
      currentIndex:''
    };
  },
   computed: {
    ...mapGetters({
      user: "user",
    }),
  },
  methods: {
    openChat(user,index) {
      if (index==0) {
                this.friendId = user.id;
                this.friendName = user.name;
                this.friendEmail = user.email;
      }else{
              this.friendId = user.user_id;
              this.friendName = user.first_name + ' ' + user.last_name;
              this.friendEmail = user.email;
      };
      this.currentIndex = index;
      this.getMessage();
      this.isChatOpen = true;
    },
     getData() {
      axios
        .get("/api/getStudentTeachers/" + this.user.student.id) 
        .then((response) => {
          this.userLists = response.data.result.teacher;
          this.userLists.unshift(response.data.admin);
        });
    },
    // getAllUserLists() {
    //   axios.get("/api/getAllUserList").then((response) => { 
    //     this.userLists = response.data.result;
    //   });
    // },
     sendMessage() {
            let formData = {};
            formData["friendId"] = this.friendId;
            formData["message"] = this.message;
            formData["mode"] = 'student';
            axios
                .post("/api/messages", formData)
                .then(response => {
                    this.message="";
                    this.getMessage();
                });
        },
     getMessage() {
            
            let formData = {};
            formData["friendId"] = this.friendId;
            axios
                .post("/api/getPrivateMessage", formData)
                .then(response => {
                  
                    this.currentUserID = response.data.currentUserID;
                    let pvtMessages = [...this.privateMessages];
                    pvtMessages = response.data.privateMessage;
                    this.privateMessages = pvtMessages;
                    
                });
        },
  },
  mounted() {
    this.getData();
  },
  mixins: [formMixins],
};
</script>
