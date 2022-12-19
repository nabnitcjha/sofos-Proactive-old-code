<template>
    <div>
        <div
            class="activeUserLogo__page user__type--teacher"
            @click.stop="loginAs"
            v-if="isForHome == false"
        >
            <div class="student-logo">
                <img :src="user.logo" />
            </div>
            <div class="user-type">
                <h1>{{ user.type }}</h1>
            </div>
        </div>
        <div class="activeUserLogo__page user__type--teacher" v-else>
            <div class="student-logo">
                <img :src="user.logo" />
            </div>
            <div class="user-type">
                <h1>{{ user.type }}</h1>
            </div>
        </div>
    </div>
</template>

<script>
import "./atom-common.css";
export default {
    data: function() {
        return {};
    },
    props: {
        user: {
            type: Object,
            default: () => {}
        },
        loginType: {
            type: Object,
            default: () => {}
        },
        isForHome: {
            type: Boolean,
            default: false
        }
    },
    methods: {
        loginAs() {
            if (this.loginType.type == undefined) {
                return;
            }
            // this.$router.push("/login");
            this.$router.push({
                path: "/login/" + this.loginType.type, 
                params: { data: this.loginType.type }
            });
        }
    }
};
</script>
