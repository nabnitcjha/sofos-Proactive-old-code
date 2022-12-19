<template>
    <div class="commonheader__page">
        <div class="header__group" v-if="isForHome==false">
             <div 
                v-bind:class="[
                    'header__group--teacher',
                    allowActiveTeacher == true ? 'active__border--color' : ''
                ]"
                  v-if="checkRole(['admin','teacher'])" @click.stop="showActiveTeacher">
                <active-user-logo :user="teacher"></active-user-logo>
            </div>
            <div 
            v-bind:class="[
                    'header__group--student',
                    allowActiveStudent == true ? 'active__border--color' : ''
                ]"
             v-if="checkRole(['admin','student'])" @click.stop="showActiveStudent">
                <active-user-logo :user="student"></active-user-logo>
            </div>
        </div>
        <div class="header__group" v-else>
             <div 
              v-bind:class="[
                    'header__group--teacher',
                    allowActiveTeacher == true ? 'active__border--color' : ''
                ]"
              v-if="checkRole(['admin','teacher'])" @click.stop="showActiveTeacher">
                <active-user-logo :user="teacher" :isForHome="isForHome"></active-user-logo>
            </div>
            <div 
             v-bind:class="[
                    'header__group--student',
                    allowActiveStudent == true ? 'active__border--color' : ''
                ]"
             v-if="checkRole(['admin','student'])" @click.stop="showActiveStudent">
                <active-user-logo :user="student" :isForHome="isForHome"></active-user-logo>
            </div>
        </div>
        <div class="active-teacher-data" v-if="allowActiveTeacher">
            <form-title :titleInfo="teacherTitleInfo"></form-title>
            <table-com 
            :apiType="apiType"
            :editUrl="editUrl"
            :inforUrl="inforUrl"
            ></table-com>
        </div>
         <div class="active-teacher-data" v-if="allowActiveStudent">
             <form-title :titleInfo="StudentTitleInfo"></form-title>
            <table-com 
            :apiType="apiType"
            :editUrl="editUrl"
            :inforUrl="inforUrl"
            ></table-com>
        </div>
    </div>
</template>

<script>
import activeUserLogo from "../../atoms/common/activeUserLogo";
import { mapGetters } from "vuex";
import { Student, Teacher } from "../../../Assets/index";
import formMixins from "../../../Mixins/form";
import tableComponent from "../../molecules/table/table"; 
import formTitle from "../../molecules/common/formTitle";
import "./molecule-common.css";
export default {
    data: function() {
        return {
            loading:true,
            student: {
                type: "Student",
                logo:Student
            },
            teacher: {
                type: "Teacher",
                logo:Teacher
            },
             teacherTitleInfo:{
                pageTitle:"Recent Active Teacher",
                allowAction:false
            },
             StudentTitleInfo:{
                pageTitle:"Recent Active Student",
                allowAction:false
            },
            allowActiveTeacher:false,
            allowActiveStudent:false,
            apiType:'',
            editUrl:'',
            inforUrl:''
        };
    },
    computed: {
        ...mapGetters({
            roleNames:'roleNames'
        })
    },
    props:{
        isForHome:{
            type:Boolean,
            default:false
        },
        parentType:String,
        teacherAPI:String, 
        studentAPI:String
    }, 
    mounted(){
        
        this.showActiveTeacher();
    },
    methods:{
          classRemove() {
            let achors = document.querySelectorAll(".active__border--color");
            achors.forEach(function(a) {
                a.classList.remove("active__border--color");
            });
        },
          nextPage(event){          
            if (this.allowActiveTeacher) {
                this.getActiveTeacher(event);
            }
            if (this.allowActiveStudent) {
                this.getActiveStudent(event);
            }
        },
        showActiveTeacher(){
            
            if (this.allowActiveTeacher) {
                    return;
            }
            this.classRemove();
            this.allowActiveStudent = false;
            this.allowActiveTeacher = true;
            this.editUrl = '/edit-teacher';
            this.apiType = 'activeTeacher';
            this.inforUrl = 'teacher-detail';
            // this.getActiveTeacher(1);
        },
        showActiveStudent(){
            if (this.allowActiveStudent) {
                return;
            }
            this.classRemove();
            this.allowActiveTeacher = false;
            this.allowActiveStudent = true;
            this.editUrl = '/edit-student';
            this.apiType = 'activeStudent';
            this.inforUrl = 'student-detail';
            // this.getActiveStudent(1);
            
        },
       
        checkRole(arr){
           let boolValue = this.roleNames.some(role => {
               return arr.includes(role);
           });
           return boolValue;
        },
    },
    components: {
        "active-user-logo": activeUserLogo,
        "table-com":tableComponent,
        "form-title":formTitle
    },
    mixins: [formMixins]
};
</script>
<style>
.active__border--color{
    border: 2px solid #589a42;
    border-radius: 13px;
}
</style>