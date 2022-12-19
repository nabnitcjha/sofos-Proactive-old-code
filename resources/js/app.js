require("./bootstrap");
window.axios = require("axios");

import Vue from "vue";
import App from "./components/App.vue";
import CalendarSlotAdd from "./components/molecules/calendar/CalendarSlotAdd.vue";
import CalendarSlotView from "./components/molecules/calendar/CalendarSlotView.vue";
import CalendarMonthDrag from "./components/molecules/calendar/CalendarMonthDrag.vue";
import router from "./router";
import axios from "axios";
import VueChatScroll from "vue-chat-scroll";
import vuetify from "./vuetify";
import Vuex from "vuex";
import store from "../js/vuex/store/index";
import interceptorRequests from "./interceptors";

import ToggleSwitch from "./components/molecules/toggleswitch/toggleswitch.vue";

import moment from 'moment';
import VueMoment from 'vue-moment';

import VueApexCharts from "vue-apexcharts";
Vue.use(VueApexCharts);



// Load Locales ('en' comes loaded by default)
require('moment/locale/es');

// Choose Locale
moment.locale('en');

Vue.use(VueMoment, { moment });

import VueToast from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css'

Vue.use(Vuetify);
Vue.use(VueToast, {
    // One of the options
    position: "top-right",
});
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
Vue.component('date-picker', DatePicker)

import Multiselect from 'vue-multiselect'

// register globally
Vue.component("apexchart", VueApexCharts);
Vue.component('multiselect', Multiselect)
Vue.component('calendar-slot-add-component', CalendarSlotAdd)
Vue.component('calendar-slot-view-component', CalendarSlotView)
Vue.component('calendar-month-drag-component', CalendarMonthDrag)

Vue.component('toggle-switch', ToggleSwitch)
// Vue.component("vs-modal", require("vue-strap/src/Modal.vue"));
import VueTelInput from 'vue-tel-input'
import 'vue-tel-input/dist/vue-tel-input.css'

import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

// Import Bootstrap an BootstrapVue CSS files (order is important)
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)

Vue.use(VueTelInput)
Vue.component("vs-modal", () => import("vue-strap/src/Modal.vue"));

Vue.use(Vuex);
Vue.use(VueChatScroll);
Vue.prototype.$http = window.axios;

// axios.defaults.baseURL = "/api/";
axios.defaults.headers.common["Authorization"] =
    "Bearer " + localStorage.getItem("token");

interceptorRequests();

store.dispatch("attempt", localStorage.getItem("token")).then(() => {
    new Vue({
        el: "#app",
        vuetify,
        data: function() {
            return {
                friendId: "",
                mobileMenuShow:false,
            };
        },
        methods: {
            changeRoute(route) {
                this.$router.push(route);
            },
            getMedia: function(id) {
                return window.location.origin + "/api/displayFile/" + id;
            },
            deleteFile: function(id) {
                axios.get("/deleteFile/" + id).then(response => {
                    location.reload();
                });
            },
            toggleClassRemoveOrAdd() {
                this.mobileMenuShow = !this.mobileMenuShow;
                if(this.mobileMenuShow){
                    document.getElementById("page-top").classList.add("sidebar-toggled");
                    document.getElementById("accordionSidebar").classList.add("toggled");
                }else{
                    let sideTogle = document.querySelectorAll(".sidebar-toggled");
                    sideTogle.forEach(function (a) {
                    a.classList.remove("sidebar-toggled");
                    });
                    let togle = document.querySelectorAll(".toggled");
                    togle.forEach(function (a) {
                    a.classList.remove("toggled");
                    });
                }
              },
        },
        store,
        router,
        render: h => h(App)
    });
});
