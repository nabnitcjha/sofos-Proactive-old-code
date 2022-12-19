<template>
    <div class="beforeLogin__page">
        <div><h1 class="beforelogin-header">Please Login As</h1></div>
        <div class="user__group">
             <div class="user__group--teacher">
                <active-user-logo :user="teacher" :loginType="teacher"></active-user-logo>
            </div>
            <!-- <div class="user__group--student">
                <active-user-logo :user="student" :loginType="student"></active-user-logo>
            </div>
            <div class="user__group--parent">
                <active-user-logo :user="parent" :loginType="parent"></active-user-logo>
            </div> -->
        </div>
    </div>
</template>

<script>
import activeUserLogo from "../../atoms/common/activeUserLogo";
import { Student, Teacher , Parents} from "../../../Assets/index";
import "./molecule-common.css";
export default {
    data: function() {
        return {
            student: {
                type: "student",
                logo:Student
            },
            teacher: {
                type: "teacher",
                logo:Teacher
            },
            parent: {
                type: "parent",
                logo:Parents
            },
             admin: {
                type: "admin",
                logo:Parents
            }
        };
    },
    components: {
        "active-user-logo": activeUserLogo
    }
};
</script>
