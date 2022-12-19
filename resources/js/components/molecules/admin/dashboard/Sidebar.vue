<template>
  <ul
    class="navbar-nav sidebar sidebar-light accordion toggleTest"
    id="accordionSidebar"
  >
    <a class="sidebar-brand d-flex align-items-center justify-content-center">
      <div class="sidebar-brand-icon brand-mobo">
        <img :src="LogoProactive" @click.stop="goDashboard" class="pointer-hand"/>
        <button
          id="sidebarToggleTop"
          class="btn btn-link rounded-circle mr-3 burger-menu burger-menu-mobo"
          @click.stop="$root.toggleClassRemoveOrAdd"
        >
          <i class="fa fa-bars"></i>
        </button>
      </div>
      <!-- <div class="sidebar-brand-text mx-3">PROACTIVE</div> -->
    </a>
    <hr class="sidebar-divider my-0" />

    <!-- Admin Side bar Start -->
    <li class="nav-item" v-if="checkRoles(['admin'])">
      <a
        class="nav-link"
        @click="
          menuClick($root.changeRoute('/admin-dashboard'), (mode = 'Dashboard'))
        "
      >
        <img :src="Vector" class="icon-size ml-3" />
        <span>Dashboard</span></a
      >
    </li>
    <!-- <li class="nav-item sidebar-margin-top" v-if="checkRoles(['admin'])">
      <a
        class="nav-link collapsed"
        href="#"
        data-toggle="collapse"
        data-target="#collapseStudent"
        aria-expanded="true"
        aria-controls="collapseStudent"
      >
        <img :src="Group1" class="icon-size ml-3" />
        <span>Students</span>
      </a>
      <div
        id="collapseStudent"
        class="collapse"
        aria-labelledby="headingBootstrap"
        data-parent="#accordionSidebar"
      >
        <div class="bg-custom-gray py-2 collapse-inner rounded">
          <a
            class="collapse-item"
            @click="
              menuClick(
                $root.changeRoute('/add-student'),
                (mode = 'Add Student')
              )
            "
            >Add Students</a
          >
          <a
            class="collapse-item"
            @click="
              menuClick($root.changeRoute('/student'), (mode = 'View Students'))
            "
            >View Students</a
          >
        </div>
      </div>
    </li>

    <li class="nav-item sidebar-margin-top" v-if="checkRoles(['admin'])">
      <a
        class="nav-link collapsed"
        href="#"
        data-toggle="collapse"
        data-target="#collapseTeacher"
        aria-expanded="true"
        aria-controls="collapseTeacher"
      >
        <img :src="Group" class="icon-size ml-3" />
        <span>Teachers</span>
      </a>
      <div
        id="collapseTeacher"
        class="collapse"
        aria-labelledby="headingBootstrap"
        data-parent="#accordionSidebar"
      >
        <div class="bg-custom-gray py-2 collapse-inner rounded">
          <a
            class="collapse-item"
            @click="
              menuClick(
                $root.changeRoute('/add-teacher'),
                (mode = 'Add Teacher')
              )
            "
            >Add Teachers</a
          >
          <a
            class="collapse-item"
            @click="
              menuClick($root.changeRoute('/teacher'), (mode = 'Teachers'))
            "
            >View Teachers</a
          >
        </div>
      </div>
    </li> -->
    <li class="nav-item sidebar-margin-top" v-if="checkRoles(['admin'])">
      <a
        class="nav-link"
        @click="
          menuClick($root.changeRoute('/student'), (mode = 'student'))
        "
      >
        <img :src="Community" class="icon-size ml-3" />
        <span>Students</span>
      </a>
    </li>
    <li class="nav-item sidebar-margin-top" v-if="checkRoles(['admin'])">
      <a
        class="nav-link"
        @click="
          menuClick($root.changeRoute('/teacher'), (mode = 'teacher'))
        "
      >
        <img :src="Community" class="icon-size ml-3" />
        <span>Teachers</span>
      </a>
    </li>
    <!-- <li class="nav-item sidebar-margin-top" v-if="checkRoles(['admin'])">
      <a
        class="nav-link"
        @click="
          menuClick($root.changeRoute('/admin-chat'), (mode = 'Admin Chat'))
        "
      >
        <img :src="Message" class="icon-size ml-3" />
        <span>Message</span>
      </a>
    </li> -->

    <!-- <li class="nav-item sidebar-margin-top" v-if="checkRoles(['admin'])">
      <a
        class="nav-link collapsed"
        href="#"
        data-toggle="collapse"
        data-target="#collapseGrade"
        aria-expanded="true"
        aria-controls="collapseGrade"
      >
        <img :src="Group2" class="icon-size ml-3" />
        <span>Classes</span>
      </a>
      <div
        id="collapseGrade"
        class="collapse"
        aria-labelledby="headingBootstrap"
        data-parent="#accordionSidebar"
      >
        <div class="bg-custom-gray py-2 collapse-inner rounded">
          <a
            class="collapse-item"
            @click="
              menuClick($root.changeRoute('/add-grade'), (mode = 'Add Class'))
            "
            >Add Classes</a
          >
          <a
            class="collapse-item"
            @click="menuClick($root.changeRoute('/grade'), (mode = 'Classes'))"
            >View Classes</a
          >
        </div>
      </div>
    </li> -->
    
    <!-- <li class="nav-item sidebar-margin-top" v-if="checkRoles(['admin'])">
      <a
        class="nav-link collapsed"
        href="#"
        data-toggle="collapse"
        data-target="#collapseSubject"
        aria-expanded="true"
        aria-controls="collapseSubject"
      >
        <img :src="Subject" class="icon-size ml-3" />
        <span>Subjects</span>
      </a>
      <div
        id="collapseSubject"
        class="collapse"
        aria-labelledby="headingBootstrap"
        data-parent="#accordionSidebar"
      >
        <div class="bg-custom-gray py-2 collapse-inner rounded">
          <a
            class="collapse-item"
            @click="
              menuClick(
                $root.changeRoute('/add-subject'),
                (mode = 'Add Subject')
              )
            "
            >Add Subjects</a
          >
          <a
            class="collapse-item"
            @click="
              menuClick($root.changeRoute('/subject'), (mode = 'Subjects'))
            "
            >View Subjects</a
          >
        </div>
      </div>
    </li> -->
    <!-- <li class="nav-item sidebar-margin-top" v-if="checkRoles(['admin'])">
      <a
        class="nav-link"
        @click="
          menuClick($root.changeRoute('/class-schedule'), (mode = 'Add Timetable'))
        "
      >
        <img :src="Timetable" class="icon-size ml-3" />
        <span>Class Schedule</span>
      </a>
    </li> -->
    <!-- <li class="nav-item sidebar-margin-top" v-if="checkRoles(['admin'])">
      <a
        class="nav-link collapsed"
        href="#"
        data-toggle="collapse"
        data-target="#collapseTimetable"
        aria-expanded="true"
        aria-controls="collapseTimetable"
      >
        <img :src="Timetable" class="icon-size ml-3" />
        <span>Timetable</span>
      </a>
      <div
        id="collapseTimetable"
        class="collapse"
        aria-labelledby="headingBootstrap"
        data-parent="#accordionSidebar"
      >
        <div class="bg-custom-gray py-2 collapse-inner rounded">
          <a
            class="collapse-item"
            @click="
              menuClick(
                $root.changeRoute('/add-class-schedule'),
                (mode = 'Add Timetable')
              )
            "
            >Add Timetable</a
          >
          <a
            class="collapse-item"
            @click="
              menuClick($root.changeRoute('/class-schedule'), (mode = 'Time Table'))
            "
            >View Timetable</a
          >
        </div>
      </div>
    </li> -->
    <!-- <li class="nav-item sidebar-margin-top" v-if="checkRoles(['admin'])">
      <a
        class="nav-link"
        @click="
          menuClick($root.changeRoute('/session'), (mode = 'Sessions'))
        "
      >
        <img :src="Classes" class="icon-size ml-3" />
        <span>Sessions</span>
      </a>
    </li> -->
    
    <!--   Admin Side bar End -->

    <!-- Teacher Side bar Start -->

    <!-- <li class="nav-item" v-if="checkRoles(['teacher'])">
      <a
        class="nav-link"
        @click="
          menuClick(
            $root.changeRoute('/teacher-dashboard'),
            (mode = 'Dashboard')
          )
        "
      >
        <img :src="Vector" class="icon-size ml-3" />
        <span>Dashboard</span></a
      >
    </li> -->
    <li class="nav-item sidebar-margin-top" v-if="checkRoles(['teacher'])">
      <a
        class="nav-link"
        @click="
          menuClick($root.changeRoute('/teacher-classes'), (mode = 'Sessions'))
        "
      >
        <img :src="Classes" class="icon-size ml-3" />
        <span>Sessions</span>
      </a>
    </li>

    <li class="nav-item sidebar-margin-top" v-if="checkRoles(['teacher'])">
      <a
        class="nav-link"
        @click="
          menuClick($root.changeRoute('/teacher-student'), (mode = 'Students'))
        "
      >
        <img :src="Community" class="icon-size ml-3" />
        <span>Students</span>
      </a>
    </li>

     <li class="nav-item sidebar-margin-top" v-if="checkRoles(['teacher'])">
      <a
        class="nav-link"
        @click="
              menuClick(
                $root.changeRoute('/list-teacher-assessment'),
                (mode = 'Assignments')
              )
            "
      >
        <img :src="Group4" class="icon-size ml-3" />
        <span>Assignment</span>
      </a>
    </li>


 
    <li class="nav-item sidebar-margin-top" v-if="checkRoles(['teacher'])">
      <a
        class="nav-link"
        @click="
          menuClick(
            $root.changeRoute('/teacher-class-schedule'),
            (mode = 'Time Table')
          )
        "
      >
        <img :src="Timetable" class="icon-size ml-3" />
        <span>Class Schedule</span>
      </a>
    </li>
    <!-- <li class="nav-item sidebar-margin-top" v-if="checkRoles(['teacher'])">
      <a
        class="nav-link collapsed"
        href="#"
        data-toggle="collapse"
        data-target="#collapseTimetable"
        aria-expanded="true"
        aria-controls="collapseTimetable"
      >
        <img :src="Timetable" class="icon-size ml-3" />
        <span>Timetable</span>
      </a>
      <div
        id="collapseTimetable"
        class="collapse"
        aria-labelledby="headingBootstrap"
        data-parent="#accordionSidebar"
      >
        <div class="bg-custom-gray py-2 collapse-inner rounded">
          <a
            class="collapse-item"
            @click="
              menuClick(
                $root.changeRoute('/add-class-schedule'),
                (mode = 'Add Timetable')
              )
            "
            >Add Timetable</a
          >
          <a
            class="collapse-item"
            @click="
              menuClick($root.changeRoute('/class-schedule'), (mode = 'Time Table'))
            "
            >View Timetable</a
          >
        </div>
      </div>
    </li> -->
    <li class="nav-item sidebar-margin-top" v-if="checkRoles(['teacher'])">
      <a
        class="nav-link"
        @click="
          menuClick($root.changeRoute('/teacher-chat'), (mode = 'Message'))
        "
      >
        <img :src="Community" class="icon-size ml-3" />
        <span>Messages</span>
      </a>
    </li>
    <!-- <li class="nav-item sidebar-margin-top" v-if="checkRoles(['teacher'])">
      <a class="nav-link" href="forms.html">
        <img :src="Group1" class="icon-size ml-3" />
        <span>Community</span>
      </a>
    </li> -->

    <!--   Teacher Side bar End -->

    <!--   Student Side bar Start -->

      <!-- <li class="nav-item" v-if="checkRoles(['student'])">
      <a
        class="nav-link"
        @click="
          menuClick($root.changeRoute('/student-dashboard'), (mode = 'Dashboard'))
        "
      >
        <img :src="Vector" class="icon-size ml-3" />
        <span>Dashboard</span></a
      >
    </li> -->

    <li class="nav-item sidebar-margin-top" v-if="checkRoles(['student'])">
      <a
        class="nav-link"
        @click="
          menuClick($root.changeRoute('/student-classes'), (mode = 'Sessions'))
        "
      >
        <img :src="Classes" class="icon-size ml-3" />
        <span>Sessions</span>
      </a>
    </li>
    <!-- <li class="nav-item sidebar-margin-top" v-if="checkRoles(['student'])">
      <a
        class="nav-link collapsed"
        href="#"
        data-toggle="collapse"
        data-target="#collapseAssignment"
        aria-expanded="true"
        aria-controls="collapseAssignment"
      >
        <img :src="Group4" class="icon-size ml-3" />
        <span>Assignment</span>
      </a>
      <div
        id="collapseAssignment"
        class="collapse"
        aria-labelledby="headingBootstrap"
        data-parent="#accordionSidebar"
      >
        <div class="bg-custom-gray py-2 collapse-inner rounded">
          <a
            class="collapse-item"
            @click="
              menuClick(
                $root.changeRoute('/Upload-student-assessment'),
                (mode = 'Upload Assignment Solution')
              )
            "
            >Upload Solution</a
          >
          <a
            class="collapse-item"
            @click="
              menuClick(
                $root.changeRoute('/download-student-assessment'),
                (mode = 'Download Assignments')
              )
            "
            >Download Assignment</a
          >
        </div>
      </div>
    </li> -->

    <li class="nav-item sidebar-margin-top" v-if="checkRoles(['student'])">
      <a
        class="nav-link"
        @click="
          menuClick($root.changeRoute('/student-teacher'), (mode = 'Teachers'))
        "
      >
        <img :src="Community" class="icon-size ml-3" />
        <span>Teachers</span>
      </a>
    </li>
    <li class="nav-item sidebar-margin-top" v-if="checkRoles(['student'])">
      <a
        class="nav-link"
        @click="
          menuClick($root.changeRoute('/student-parent'), (mode = 'Parents'))
        "
      >
        <img :src="Community" class="icon-size ml-3" />
        <span>Parents</span>
      </a>
    </li>

    <li class="nav-item sidebar-margin-top" v-if="checkRoles(['student'])">
      <a
        class="nav-link"
        @click="
          menuClick(
            $root.changeRoute('/student-class-schedule'),
            (mode = 'Time Table')
          )
        "
      >
        <img :src="Timetable" class="icon-size ml-3" />
        <span>Class Schedule</span>
      </a>
    </li>
    <li class="nav-item sidebar-margin-top" v-if="checkRoles(['student'])">
      <a
        class="nav-link"
        @click="
          menuClick($root.changeRoute('/student-chat'), (mode = 'Message'))
        "
      >
        <img :src="Community" class="icon-size ml-3" />
        <span>Messages</span>
      </a>
    </li>
    <li class="nav-item" v-if="checkRoles(['admin', 'teacher', 'student'])">
      <a
        class="nav-link"
        @click="menuClick($root.changeRoute('/send-sms'), (mode = 'Send-SMS'))"
      >
        <img :src="Attendance" class="icon-size ml-3" />
        <span>Send SMS</span></a
      >
    </li>


<!-- parent side bar -->
  <!-- <li class="nav-item" v-if="checkRoles(['parent'])">
      <a
        class="nav-link"
        @click="
          menuClick($root.changeRoute('/parent-dashboard'), (mode = 'Dashboard'))
        "
      >
        <img :src="Vector" class="icon-size ml-3" />
        <span>Dashboard</span></a
      >
    </li> -->
    <li class="nav-item sidebar-margin-top" v-if="checkRoles(['parent'])">
      <a
        class="nav-link"
        @click="
          menuClick($root.changeRoute('/student-classes'), (mode = 'session'))
        "
      >
        <img :src="Classes" class="icon-size ml-3" />
        <span>Sessions</span>
      </a>
    </li>

    <li class="nav-item sidebar-margin-top" v-if="checkRoles(['parent'])">
      <a
        class="nav-link"
        @click="
          menuClick($root.changeRoute('/parent-student'), (mode = 'Students'))
        "
      >
        <img :src="Community" class="icon-size ml-3" />
        <span>Students</span>
      </a>
    </li>
    <li class="nav-item sidebar-margin-top" v-if="checkRoles(['parent'])">
      <a
        class="nav-link"
        @click="
          menuClick($root.changeRoute('/parent-teacher'), (mode = 'Teachers'))
        "
      >
        <img :src="Community" class="icon-size ml-3" />
        <span>Teacher</span>
      </a>
    </li>
    <li class="nav-item sidebar-margin-top" v-if="checkRoles(['parent'])">
      <a
        class="nav-link"
        @click="
          menuClick(
            $root.changeRoute('/parent-class-schedule'),
            (mode = 'Time Table')
          )
        "
      >
        <img :src="Timetable" class="icon-size ml-3" />
        <span>Class Schedule</span>
      </a>
    </li>
    <li class="nav-item sidebar-margin-top" v-if="checkRoles(['parent'])">
      <a
        class="nav-link"
        @click="
          menuClick($root.changeRoute('/parent-chat'), (mode = 'Message'))
        "
      >
        <img :src="Community" class="icon-size ml-3" />
        <span>Messages</span>
      </a>
    </li>
    <li class="nav-item sidebar-margin-top" v-if="checkRoles(['parent'])">
      <a
        class="nav-link collapsed"
        href="#"
        data-toggle="collapse"
        data-target="#collapseStudent"
        aria-expanded="true"
        aria-controls="collapseStudent"
      >
        <img :src="Group1" class="icon-size ml-3" />
        <span>Parent</span>
      </a>
      <div
        id="collapseStudent"
        class="collapse"
        aria-labelledby="headingBootstrap"
        data-parent="#accordionSidebar"
      >
        <div class="bg-custom-gray py-2 collapse-inner rounded">
          <a
            class="collapse-item"
            @click="
              menuClick($root.changeRoute('/add-parent'), (mode = 'Add Parent'))
            "
            >Add Parents</a
          >
          <a
            class="collapse-item"
            @click="
              menuClick($root.changeRoute('/parent'), (mode = 'View parent'))
            "
            >View Parent</a
          >
        </div>
      </div>
    </li>
    <!-- <li class="nav-item sidebar-margin-top" v-if="checkRoles(['parent'])">
      <a class="nav-link"
                  @click="
              menuClick($root.changeRoute('/add-parent'), (mode = 'Add Parent'))
            "
      >
        <img :src="Vector1" class="icon-size ml-3" />
        <span>Add Parent</span>
      </a>
    </li> -->
    <li class="nav-item" v-if="checkRoles(['parent'])">
      <a
        class="nav-link"
        @click="menuClick($root.changeRoute('/send-sms'), (mode = 'Send-SMS'))"
      >
        <img :src="Attendance" class="icon-size ml-3" />
        <span>Send SMS</span></a
      >
    </li>
    <li class="nav-item sidebar-margin-top" v-if="checkRoles(['admin'])">
      <a
        class="nav-link collapsed"
        href="#"
        data-toggle="collapse"
        data-target="#collapseTeacher"
        aria-expanded="true"
        aria-controls="collapseTeacher"
      >
        <img :src="Group" class="icon-size ml-3" />
        <span>Settings</span>
      </a>
      <div
        id="collapseTeacher"
        class="collapse"
        aria-labelledby="headingBootstrap"
        data-parent="#accordionSidebar"
      >
        <div class="bg-custom-gray py-2 collapse-inner rounded">
          <a
            class="collapse-item"
            @click="
              menuClick(
                $root.changeRoute('/add-student'),
                (mode = 'RegisterStudent')
              )
            "
            >Register Student</a
          >
          <a
            class="collapse-item"
            @click="
              menuClick($root.changeRoute('/add-teacher'), (mode = 'RegisterTeacher'))
            "
            >Register Teacher</a
          >
          <a
            class="collapse-item"
            @click="
              menuClick($root.changeRoute('/subject'), (mode = 'Subjects'))
            "
            >Subject</a
          >
        </div>
      </div>
    </li> 
    <!--   Student Side bar End -->
    <div class="version sidebar-margin-top" id="version-ruangadmin">
      Version 1.0.0
    </div>
  </ul>
  <!-- <div class="sidbar__page">
    <div class="sidebar-brand-icon">
      <img :src="LogoProactive" />
    </div>
    <div class="sidebar__menu--lists" v-if="checkRoles(['admin'])">
      <div
        v-bind:class="[
          'sidebar__menu',
          1 == clickedIndex ? 'active__menu--color' : '',
        ]"
        @click="menuClick($root.changeRoute('/home'), (index = 1))"
      >
        <i class="fas fa-fw fa-tachometer-alt change-fontsize"></i
        ><span class="change-fontsize">Dashboard</span>
      </div>

      <div
        v-bind:class="[
          'sidebar__menu',
          2 == clickedIndex ? 'active__menu--color' : '',
        ]"
        @click="menuClick($root.changeRoute('/teacher'), (index = 2))"
      >
        <i class="fas fa-chalkboard-teacher change-fontsize"></i
        ><span class="change-fontsize">Teacher</span>
      </div>
      <div
        v-bind:class="[
          'sidebar__menu',
          3 == clickedIndex ? 'active__menu--color' : '',
        ]"
        @click="menuClick($root.changeRoute('/student'), (index = 3))"
      >
        <i class="fas fa-user-graduate change-fontsize"></i>&nbsp;<span
          class="change-fontsize"
          >Student</span
        >
      </div>
      <div
        v-bind:class="[
          'sidebar__menu',
          4 == clickedIndex ? 'active__menu--color' : '',
        ]"
        @click="menuClick($root.changeRoute('/grade'), (index = 4))"
      >
        <i class="fas fa-user-graduate change-fontsize"></i>&nbsp;<span
          class="change-fontsize"
          >Class</span
        >
      </div>
      <div
        v-bind:class="[
          'sidebar__menu',
          5 == clickedIndex ? 'active__menu--color' : '',
        ]"
        @click="menuClick($root.changeRoute('/subject'), (index = 5))"
      >
        <i class="fas fa-user-graduate change-fontsize"></i>&nbsp;<span
          class="change-fontsize"
          >Subject</span
        >
      </div>
      <div
        v-bind:class="[
          'sidebar__menu',
          6 == clickedIndex ? 'active__menu--color' : '',
        ]"
        @click="menuClick($root.changeRoute('/class-schedule'), (index = 6))"
      >
        <i class="fas fa-user-graduate change-fontsize"></i>&nbsp;<span
          class="change-fontsize"
          >Time Table</span
        >
      </div>

      <hr class="sidebar-divider" />
      <div class="menu-divider" style="color: #4e4e4e">Setting Section</div>
      <hr class="sidebar-divider" />
      <div
        v-bind:class="[
          'sidebar__menu',
          7 == clickedIndex ? 'active__menu--color' : '',
        ]"
        @click="menuClick($root.changeRoute('/role-permission'), (index = 7))"
      >
        <i class="fas fa-person-booth change-fontsize"></i>&nbsp;<span
          class="change-fontsize"
          >Role-Permission</span
        >
      </div>
      <hr class="sidebar-divider" />
      <div class="menu-divider" style="color: #4e4e4e">Auth Section</div>
      <hr class="sidebar-divider" />
      <div
        class="nav-item move-middle sidebar__menu"
        @click.stop="logout"
        style="cursor: pointer; color: #4e4e4e"
      >
        <i class="fas fa-user-plus change-fontsize"></i>&nbsp;<span
          class="change-fontsize"
          >Logout</span
        >
      </div>
    </div>
    <div class="sidebar__menu--lists" v-if="checkRoles(['teacher'])">
        <button class="dropdown-btn sub-menu-title">Assessment 
    <i class="fa fa-caret-down"></i>
  </button>
      <div class="dropdown-container">
        <div
          v-bind:class="[
            'sidebar__menu sidebar__menu-create-assessment',
            1 == clickedIndex ? 'active__menu--color' : '',
          ]"
          @click="
            menuClick(
              $root.changeRoute('/create-teacher-assessment'),
              (index = 1)
            )
          "
        >
          <i class="fas fa-tasks change-fontsize"></i
          ><span class="change-fontsize">Create Assessment</span>
        </div>
        <div
          v-bind:class="[
            'sidebar__menu sidebar__menu-assessment',
            2 == clickedIndex ? 'active__menu--color' : '',
          ]"
          @click="
            menuClick(
              $root.changeRoute('/list-teacher-assessment'),
              (index = 2)
            )
          "
        >
          <i class="fab fa-fantasy-flight-games change-fontsize"></i
          ><span class="change-fontsize">Assessment</span>
        </div>
      </div>

      <div
        v-bind:class="[
          'sidbar__menu-class',
          3 == clickedIndex ? 'active__menu--color' : '',
        ]"
        @click="menuClick($root.changeRoute('/teacher-classes'), (index = 3))"
      >
        <i class="fas fa-users change-fontsize"></i
        ><span class="change-fontsize">Classes</span>
      </div>

   

      <hr class="sidebar-divider" />
      <div class="menu-divider" style="color: #4e4e4e">Auth Section</div>
      <hr class="sidebar-divider" />
      <div
        class="nav-item move-middle sidebar__menu"
        @click.stop="logout"
        style="cursor: pointer; color: #4e4e4e"
      >
        <i class="fas fa-user-plus change-fontsize"></i>&nbsp;<span
          class="change-fontsize"
          >Logout</span
        >
      </div>
    </div>
  </div> -->
</template>

<script>
import { LogoProactive, Teacher } from "../../../../Assets/dashboard/index";
import {
  Message,
    Community,
    Classes,
    Attendance,
    Assignment,
  Group,
  Group1,
  Group2,
  Group3,
  Group4,
  Vector,
  Vector1,
  Subject,
  Timetable,
  SubIcon,
} from "./Icons/index";
import { mapActions, mapGetters } from "vuex";
import "./style.css";
export default {
  data: function () {
    return {
      clickedMode: "",
      LogoProactive: LogoProactive,
      Community:Community,
    Classes:Classes,
    Attendance:Attendance,
    Assignment:Assignment,
    Message:Message,
      Group: Group,
      Group1: Group1,
      Group2: Group2,
      Group3: Group3,
      Group4: Group4,
      Vector: Vector,
      Vector1: Vector1,
      Subject: Subject,
      Timetable: Timetable,
      SubIcon: SubIcon,
      Teacher: Teacher,
      loginStatus: "",
      clickedIndex: -11,
      roleNames: [],
    };
  },
  watch: {
    user: function (newVal, oldVal) {
      if (newVal != null) {
        this.roleNames = newVal.roleNames;
      }
    },
    $route(newId, oldId) {
      this.activeMenuDetect();
    },
  },

  computed: {
    ...mapGetters({
      isAuthenticated: "isAuthenticated",
      isFirstTime: "isFirstTime",
      user: "user",
      pageView: "pageView"
    }),
  },

  methods: {
    ...mapActions({
      firstTimeValue: "firstTimeValue",
      setAuthenticationFalse: "setAuthenticationFalse",
      setPageTitle: "setPageTitle",
      setPageView:"setPageView" 
    }),
    goDashboard(){
      // checkRoles(['admin', 'teacher', 'student'])
      let isAdmin = this.checkRoles(['admin']);
      let isParent = this.checkRoles(['parent']);
      let isTeacher = this.checkRoles(['teacher']);
      let isStudent = this.checkRoles(['student']);
      if (isAdmin) {
        this.$router.push("/admin-dashboard");
      }else if(isTeacher){
        this.$router.push("/teacher-classes");
      }else if(isStudent){
        this.$router.push("/student-classes");
      }else{
        this.$router.push("/parent-class-schedule");
      }

    },
    checkRoles(roles) {
      if (this.roleNames.length == 0 && this.user != null) {
        let boolValue = this.user.roleNames.some((role) => {
          return roles.includes(role);
        });
        return boolValue;
      } else if (this.roleNames.length > 0) {
        let boolValue = this.roleNames.some((role) => {
          return roles.includes(role);
        });
        return boolValue;
      }
    },

    classRemove() {
      let achors = document.querySelectorAll(".active__menu--color");
      achors.forEach(function (a) {
        a.classList.remove("active__menu--color");
      });
    },
    menuClick(routeURL, mode) {
      this.setPageView(mode);
      // if(mode=='RegisterStudent' || mode=='RegisterTeacher'){
      //   this.setPageView(mode);
      // }else if(mode=='student' || mode=='teacher' ||mode=='session'){
      //   this.setPageView(mode);
      // }
      // else if (mode=='Add Timetable') {
      //   this.setPageView('table');
      // }else{
      //   if (this.pageView=='calendar') {
      //     this.setPageView('table');
      //   }
      // }
      
      this.$root.mobileMenuShow = false;
      let sideTogle = document.querySelectorAll(".sidebar-toggled");
      sideTogle.forEach(function (a) {
        a.classList.remove("sidebar-toggled");
      });
      let togle = document.querySelectorAll(".toggled");
      togle.forEach(function (a) {
        a.classList.remove("toggled");
      });
      if (this.clickedMode === mode) {
        this.setPageTitle(mode);
        return;
      }
      if (mode) {
        this.setPageTitle(mode);
      }
      this.clickedMode = mode;
    },
    logout() {
      axios.defaults.headers.common["Authorization"] =
        "Bearer " + localStorage.getItem("token");
      localStorage.removeItem("token");
      axios.post("/api/logout").then((response) => {
        let formData = {};
        formData["makeTrue"] = false;
        this.firstTimeValue(formData);
        this.setAuthenticationFalse();

        this.$router.push("/adminlogin");
      });
    },
    activeMenuDetect() {
      if (this.checkRoles(["admin"])) {
        if (this.$route.name === "home") this.clickedIndex = 1;
        else if (this.$route.name === "teacher") this.clickedIndex = 2;
        else if (this.$route.name === "student") this.clickedIndex = 3;
        else if (this.$route.name === "rolePermission") this.clickedIndex = 7;
        else if (this.$route.name === "grade") this.clickedIndex = 4;
        else if (this.$route.name === "subject") this.clickedIndex = 5;
        else if (this.$route.name === "timeTable") this.clickedIndex = 6;
        else if (this.$route.name === "teacherDetail") this.clickedIndex = 2;
        else if (this.$route.name === "studentDetail") this.clickedIndex = 3;
      }
      if (this.checkRoles(["teacher"])) {
        if (this.$route.name === "home") this.clickedIndex = 1;
        else if (this.$route.name === "teacher") this.clickedIndex = 2;
        else if (this.$route.name === "teacherDetail") this.clickedIndex = 2;
        else if (this.$route.name === "classes") this.clickedIndex = 3;
        else if (this.$route.name === "classDetail") this.clickedIndex = 3;
      }
      if (this.checkRoles(["student"])) {
        if (this.$route.name === "home") this.clickedIndex = 1;
        else if (this.$route.name === "student") this.clickedIndex = 2;
        else if (this.$route.name === "studentDetail") this.clickedIndex = 2;
      }
    },
  },
  mounted() {
    this.activeMenuDetect();
    if (!this.isFirstTime) {
      this.menuClick(1);
    }
  },
};
</script>
