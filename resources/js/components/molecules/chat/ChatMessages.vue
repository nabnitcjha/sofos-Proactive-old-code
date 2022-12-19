<template>
<div class="chatMessage__page">
      <ul class="chat">
        <li v-bind:class="[
                    '',
                    currentUserID == message.my_id
                        ? 'myMessage'
                        : 'friendMessage',
                ]" v-for="(message,index) in privateMessages" :key="index">
            <div class="chat-body">
                <div class="header">
                    <strong class="primary-font">
                        {{ message.user.name }}
                    </strong>
                </div>
                <p>
                    {{ message.message }} 
                </p>
            </div>
        </li>
    </ul>
</div>

</template>

<script>
import  "./style.css";
  export default {
    props: {
        privateMessages:Array, 
        currentUserID: Number,
    }
  };
</script>
