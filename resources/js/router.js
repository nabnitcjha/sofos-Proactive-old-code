import Vue from 'vue';
import VueRouter from 'vue-router';
import VueRouteMiddleware from 'vue-route-middleware';
// import Chat from "./components/templates/chat/Chat.vue";
import Chat from "./components/templates/chat/chat.vue";

import AuthMiddleWare from './Middleware/authUser';

import AdminChat from "./components/templates/chat/adminChat.vue";
import ParentChat from "./components/templates/chat/parentChat.vue";
import StudentChat from "./components/templates/chat/studentChat.vue";
import TeacherChat from "./components/templates/chat/teacherChat.vue";

import Home from "./components/templates/admin/home.vue";
import Student from "./components/templates/forms/student/student.vue";
import StudentDetail from "./components/templates/forms/student/studentDetail.vue";

import SubjectDetail from "./components/templates/forms/subject/subjectDetail.vue";

import AddStudent from "./components/templates/forms/student/addStudent.vue";
import EditStudent from "./components/templates/forms/student/editStudent.vue";
import Teacher from "./components/templates/forms/teacher/teacher.vue"; 
import teacherDetail from "./components/templates/forms/teacher/teacherDetail.vue";
import AddTeacher from "./components/templates/forms/teacher/addTeacher.vue";
import EditTeacher from "./components/templates/forms/teacher/editTeacher.vue";
import Parent from "./components/templates/forms/parent/parent.vue";
import AddParent from "./components/templates/forms/parent/addParent.vue";
import EditParent from "./components/templates/forms/parent/editParent.vue";

import Grade from "./components/templates/forms/grade/grade.vue";
import AddGrade from "./components/templates/forms/grade/addGrade.vue";
import GradeDetail from "./components/templates/forms/grade/gradeDetail.vue";
import EditGrade from "./components/templates/forms/grade/editGrade.vue";

import Subject from "./components/templates/forms/subject/subject.vue";
import AddSubject from "./components/templates/forms/subject/addSubject.vue";
import EditSubject from "./components/templates/forms/subject/editSubject.vue";

import TeacherClasses from "./components/templates/forms/teacherClasses/teacherClasses.vue";
import AllClasses from "./components/templates/forms/teacherClasses/allClasses.vue";
import TeacherClassesDetail from "./components/templates/forms/teacherClasses/TeacherClassesDetail.vue";

import TeacherTimeTable from "./components/templates/forms/teacherTimetable/teacherTimetable.vue";
import TimeTableDetail from "./components/templates/forms/timeTable/timeTableDetail.vue";

import StudentTimeTable from "./components/templates/forms/studentTimetable/studentTimetable.vue";

import ParentTimeTable from "./components/templates/forms/parentTimetable/parentTimetable.vue";

import TeacherStudent from "./components/templates/forms/teacherStudents/teacherStudents.vue";

import StudentTeacher from "./components/templates/forms/studentTeachers/studentTeachers.vue";

import StudentParent from "./components/templates/forms/studentParent/studentParent.vue";

import ParentStudent from "./components/templates/forms/parentStudent/parentStudent.vue";
import ParentTeacher from "./components/templates/forms/parentTeacher/parentTeacher.vue";

import TeacherMessage from "./components/templates/forms/teacherMessage/teacherMessage.vue";

import StudentClasses from "./components/templates/forms/studentClasses/studentClasses.vue";
import StudentClassesDetail from "./components/templates/forms/studentClasses/studentClassesDetail.vue";

import TimeTable from "./components/templates/forms/timeTable/timetable.vue";
import AddTimetableFromCalendar from "./components/molecules/timeTable/addTimetableFromCalendar.vue";
import AddTimeTable from "./components/templates/forms/timeTable/addTimeTable.vue";
import EditTimeTable from "./components/templates/forms/timeTable/editTimeTable.vue";
import Login from "./components/templates/auth/LogIn/login.vue";

import forgetPassword from "./components/templates/auth/LogIn/forgetPassword.vue";
import resetPassword from "./components/templates/auth/LogIn/resetPassword.vue";

import Register from "./components/templates/auth/Register/register.vue";
import BeforeLogIn from "./components/molecules/common/beforeLogin.vue";
import AdminTemplate from "./components/templates/admin/dashboard/Admin";

import AdminProfile from "./components/templates/admin/profile.vue";
import TeacherProfile from "./components/templates/admin/teacherProfile.vue";
import StudentProfile from "./components/templates/admin/studentProfile.vue";
import ParentProfile from "./components/templates/admin/parentProfile.vue";

import CheckUserAuth from './Middleware/checkUserAuth';
import RolePermission from "./components/molecules/spite/rolePermission.vue";
import UserRole from "./components/molecules/spite/userRole.vue";
import sendSMS from "./components/templates/admin/sendSMS.vue";
import AssessmentType from "./components/molecules/assessment/assessmentType.vue";

import UploadSolution from "./components/molecules/assessment/student/uploadSolution.vue";
import DownloadAssessment from "./components/molecules/assessment/student/downloadAssessment.vue";

import CreateTeacherAssement from "./components/molecules/assessment/teacher/createAssessment.vue";
import ListTeacherAssement from "./components/molecules/assessment/teacher/assessment.vue";
import EditTeacherAssement from "./components/molecules/assessment/teacher/editAssessment.vue";

import Calendar from "./components/molecules/calendar/CalendarSlotAdd.vue";
import AdminCalendarDetail from "./components/molecules/calendar/AdminCalendarDetail.vue";
import TeacherCalendarDetail from "./components/molecules/calendar/TeacherCalendarDetail.vue";
import StudentCalendarDetail from "./components/molecules/calendar/StudentCalendarDetail.vue";
import ParentCalendarDetail from "./components/molecules/calendar/ParentCalendarDetail.vue";

import userActivation from "./components/userActivation.vue";


import AdminDashboard from "./components/molecules/admin/dashboard/Dashboard.vue";

Vue.use(VueRouter)

const routes = [
    {
        path:'/',
        name:'userLogin',
        component:Login,
    }, 
    {
        path:'/forget-password',
        name:'forgetPassword',
        component:forgetPassword,
    }, 
    {
        path:'/reset-password/:userId',
        name:'resetPassword',
        component:resetPassword,
    },
    {
        path:'/Upload-student-assessment',
        name:'uploadSolution',
        component:UploadSolution,
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/download-student-assessment',
        name:'downloadAssessment',
        component:DownloadAssessment,
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },



    {
        path:'/teacher-classes',
        name:'teacherClasses',
        component:TeacherClasses,
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/session',
        name:'allClasses',
        component:AllClasses,
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    // {
    //     path:'/student-session-detail/:student_id',
    //     name:'studentSessionDetail',
    //     component:AllClasses,
    //     meta: {
    //         middleware: [ AuthMiddleWare ]
    //     }
    // },
    {
        path:'/teacher-session-detail/:teacher_id',
        name:'teacherSessionDetail',
        component:TeacherClassesDetail,
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/student-classes',
        name:'studentClasses',
        component:StudentClasses,
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/admin-profile',
        name:'adminprofile',
        component:AdminProfile,
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },

    {
        path:'/teacher-profile',
        name:'teacherprofile',
        component:TeacherProfile,
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/student-profile',
        name:'studentprofile',
        component:StudentProfile,
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/parent-profile',
        name:'parentprofile',
        component:ParentProfile,
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },

    {
        path:'/teacher-dashboard',
        name:'teacherDashboard',
        component:AdminDashboard,
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/student-dashboard',
        name:'studentDashboard',
        component:AdminDashboard,
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/parent-dashboard',
        name:'parentDashboard',
        component:AdminDashboard,
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/admin-dashboard',
        name:'adminDashboard',
        component:AdminDashboard,
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/session-detail/:allot_class_id',
        name:'teacherClassesDetail',
        component:TeacherClassesDetail,
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    // {
    //     path:'/student-class-detail/:allot_class_id',
    //     name:'studentClassDetail',
    //     component:TeacherClassesDetail,
    //     meta: {
    //         middleware: [ AuthMiddleWare ]
    //     }
    // },
    {
        path:'/student-session-detail/:student_id',
        name:'StudentClassesDetail',
        component:StudentClassesDetail,
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/send-sms',
        name:'sendSms',
        component:sendSMS,
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/calendar',
        name:'calendar',
        component:Calendar,
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
   
    {
        path:'/teacher-calendar-detail/:id',
        name:'teacherCalendarDetail',
        component:TeacherCalendarDetail,
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/admin-calendar-detail/:id',
        name:'adminCalendarDetail',
        component:AdminCalendarDetail,
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/student-calendar-detail/:id',
        name:'studentCalendarDetail',
        component:StudentCalendarDetail,
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/parent-calendar-detail/:id',
        name:'parentCalendarDetail',
        component:ParentCalendarDetail,
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },

    {
        path:'/grade',
        name:'grade',
        component:Grade,
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/add-grade',
        name:'addGrade',
        component:AddGrade,
        // beforeEnter:CheckUserAuth
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/grade-detail/:id',
        name:'gradeDetail',
        component:GradeDetail,
        // beforeEnter:CheckUserAuth
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/edit-grade/:id',
        name:'editGrade',
        component:EditGrade,
        // beforeEnter:CheckUserAuth
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },


    {
        path:'/subject',
        name:'subject',
        component:Subject,
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/add-subject',
        name:'addSubject',
        component:AddSubject,
        // beforeEnter:CheckUserAuth
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/edit-subject/:id',
        name:'editSubject',
        component:EditSubject,
        // beforeEnter:CheckUserAuth
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },


    {
        path:'/class-schedule',
        name:'timeTable',
        component:TimeTable,
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/student-class-schedule-detail/:student_id',
        name:'studentClassScheduleDetial',
        component:TimeTableDetail,
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/teacher-class-schedule-detail/:teacher_id',
        name:'teacherClassScheduleDetial',
        component:TimeTableDetail,
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/student-calendar/:student_id',
        name:'studentCalendarDetail',
        component:TimeTableDetail,
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/teacher-calendar/:teacher_id',
        name:'teacherCalendarDetail',
        component:TimeTableDetail,
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/class-schedule-detail/:session_id',
        name:'timeTableDetail',
        component:TimeTableDetail,
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/teacher-class-schedule',
        name:'teachertimeTable',
        component:TeacherTimeTable,
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/student-class-schedule',
        name:'studenttimeTable',
        component:StudentTimeTable,
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/parent-class-schedule',
        name:'parenttimeTable',
        component:ParentTimeTable,
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/teacher-student',
        name:'teacherStudent',
        component:TeacherStudent,
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/student-teacher',
        name:'studentTeacher',
        component:StudentTeacher,
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/student-parent',
        name:'studentParent',
        component:StudentParent,
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/parent-student',
        name:'parentStudent',
        component:ParentStudent,
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/parent-teacher',
        name:'parentTeacher',
        component:ParentTeacher,
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/teacher-chat',
        name:'teacherChat',
        component:TeacherChat,
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/add-class-schedule-from-calendar',
        name:'addStudentClassSchedule',
        component:AddTimetableFromCalendar,
        // beforeEnter:CheckUserAuth
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/add-student-class-schedule/:student_id',
        name:'addStudentClassSchedule',
        component:AddTimeTable,
        // beforeEnter:CheckUserAuth
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/add-teacher-class-schedule/:teacher_id',
        name:'addTeacherClassSchedule',
        component:AddTimeTable,
        // beforeEnter:CheckUserAuth
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/add-class-schedule',
        name:'addTimeTable',
        component:AddTimeTable,
        // beforeEnter:CheckUserAuth
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/edit-class-schedule/:id',
        name:'editTimeTable',
        component:EditTimeTable,
        // beforeEnter:CheckUserAuth
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },


    {
        path:'/home',
        name:'home',
        component:Home,
        // beforeEnter:CheckUserAuth
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/adminlogin',
        name:'adminLogin',
        component:BeforeLogIn,
    },
    {
        path: "/user-activation/:token",
        name:'userActivation',
        component: userActivation,
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/user-role',
        name:'userRole',
        component:UserRole,
        // beforeEnter:CheckUserAuth
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/role-permission',
        name:'rolePermission',
        component:RolePermission,
        // beforeEnter:CheckUserAuth
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },

    {
        path:'/admin-template',
        name:'adminTemplate',
        component:AdminTemplate,
        // beforeEnter:CheckUserAuth
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/chat',
        name:'chat',
        component:Chat,
        // beforeEnter:CheckUserAuth
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },

    {
        path:'/admin-chat',
        name:'adminChat',
        component:AdminChat,
        // beforeEnter:CheckUserAuth
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/parent-chat',
        name:'parentChat',
        component:ParentChat,
        // beforeEnter:CheckUserAuth
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/student-chat',
        name:'studentChat',
        component:StudentChat,
        // beforeEnter:CheckUserAuth
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/teacher-chat',
        name:'teacherChat',
        component:TeacherChat,
        // beforeEnter:CheckUserAuth
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/parent',
        name:'parent',
        component:Parent,
        // beforeEnter:CheckUserAuth
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/add-parent',
        name:'addParent',
        component:AddParent,
        // beforeEnter:CheckUserAuth
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/add-parent/:id',
        name:'add-parent-from-detail',
        component:AddParent,
        // beforeEnter:CheckUserAuth
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/edit-parent/:id',
        name:'editParent',
        component:EditParent,
        // beforeEnter:CheckUserAuth
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/student',
        name:'student',
        component:Student,
        // beforeEnter:CheckUserAuth
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/studentDetail',
        name:'studentDetail',
        component:StudentDetail,
        // beforeEnter:CheckUserAuth
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/subject-detail/:id',
        name:'subjectDetail',
        component:SubjectDetail,
        // beforeEnter:CheckUserAuth
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/add-student', 
        name:'addStudent',
        component:AddStudent,
        // beforeEnter:CheckUserAuth
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/edit-student/:id',
        name:'editStudent',
        component:EditStudent,
        // beforeEnter:CheckUserAuth
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/student-detail/:id',
        name:'studentDetail',
        component:StudentDetail,
        // beforeEnter:CheckUserAuth
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/teacher',
        name:'teacher',
        component:Teacher,
        // beforeEnter:CheckUserAuth
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/teacher-detail/:id',
        name:'teachertDetail',
        component:teacherDetail,
        // beforeEnter:CheckUserAuth
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/teacher-detail',
        name:'teacherDetail',
        component:teacherDetail,
        // beforeEnter:CheckUserAuth
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/add-teacher',
        name:'addTeacher',
        component:AddTeacher,
        // beforeEnter:CheckUserAuth
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/edit-teacher/:id',
        name:'editTeacher',
        component:EditTeacher,
        // beforeEnter:CheckUserAuth
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/login/:type',
        name:'login',
        component:Login,
    },
    {
        path:'/register/:type',
        name:'register',
        component:Register,
    },
    {
        path:'/create-teacher-assessment',
        name:'createTeacherAssement',
        component:CreateTeacherAssement,
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/edit-teacher-assessment/:assessmentID',
        name:'editTeacherAssement',
        component:EditTeacherAssement,
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
    {
        path:'/list-teacher-assessment',
        name:'listTeacherAssement',
        component:ListTeacherAssement,
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
  
    {
        path:'/assessment-type',
        name:'assessmentType',
        component:AssessmentType,
        meta: {
            middleware: [ AuthMiddleWare ]
        }
    },
]

const router = new VueRouter({
    routes:routes,
})
router.beforeEach(VueRouteMiddleware({AuthMiddleWare}));
export default router
