import axios from "axios";
import moment from 'moment';
export default {
    data() {
        return {};
    },
    methods: {
        textValidation(addMessage){
            this.$toast.open({
            message: addMessage,
            type: "error",
            duration: 5000,
            dismissible: true,
          });
        },
        addStatus(addMessage){
            this.$toast.open({
            message: addMessage,
            type: "success",
            duration: 5000,
            dismissible: true,
          });
        },
        passwordChangeSccessfully() {
            this.$toast.open({
              message: "Password Change Successfully",
              type: "success",
              duration: 5000,
              dismissible: true,
            });
          },
          passwordNotMatch() {
            this.$toast.open({
              message: "Password not match",
              type: "error",
              duration: 5000,
              dismissible: true,
            });
          },
          passwordEmpty() {
            this.$toast.open({
              message: "Password field is empty",
              type: "error",
              duration: 5000,
              dismissible: true,
            });
          },
        disabledBeforeToday(date) {
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            return date < today;
          },
          time_am_pm(val){
            return moment(val).format('hh:mm a');
          },
        single_dateFormater_AM_PM(val) {
            // let x = moment(val).utc();
            let x = moment(val).format('hh:mm:ss a');
            return moment(val).format('hh:mm:ss a');
             
            // return moment(val).format('DD.MM.YYYY  HH:mm:ss a');
            
            // var hours = event.getHours();
            // var minutes = event.getMinutes();
            // var ampm = hours >= 12 ? "pm" : "am";
            // hours = hours % 12;
            // hours = hours ? hours : 12; // the hour '0' should be '12'
            // minutes = minutes < 10 ? "0" + minutes : minutes;
            // // var strTime = hours + ":" + minutes + " " + ampm;
            // var strTime = hours + ":" + minutes + " " + ampm;

            // let date = JSON.stringify(event);
            // date = date.slice(1, 11) + " " + strTime;

            // return date;
        },
        single_dateFormater(val) {
            
            let x = moment(val).format('YYYY-MM-DD hh:mm:ss');
            return moment(val).format('YYYY-MM-DD HH:mm:ss a');
            // var hours = event.getHours();
            // var minutes = event.getMinutes();
            // let date = JSON.stringify(event);
            // date = date.slice(1, 11) + " " + hours + ":" + minutes;

            // return date;
        },
        start_end_time(start,end) {
            
            let start_time = moment(start).format('hh:mm:ss a');
            let end_time = moment(end).format('hh:mm:ss a');

            return start_time+'-'+end_time;
        },

        dateFormater_AM_PM(val) {
            var fromDate = "";
            var toDate = "";
            val.map((data, index) => {
                if (index == 0) {
                    return moment(data).format('DD.MM.YYYY  hh:mm:ss a');
                   
                    // var hours = event.getHours();
                    // var minutes = event.getMinutes();
                    // var ampm = hours >= 12 ? "pm" : "am";
                    // hours = hours % 12;
                    // hours = hours ? hours : 12; // the hour '0' should be '12'
                    // minutes = minutes < 10 ? "0" + minutes : minutes;
                    // // var strTime = hours + ":" + minutes + " " + ampm;
                    // var strTime = hours + ":" + minutes + " " + ampm;

                    // fromDate = JSON.stringify(event);
                    // fromDate = fromDate.slice(1, 11) + " " + strTime;
                } else {
                   
                    return moment(data).format('YYYY-MM-DD hh:mm:ss a');
             
                    // var hours = event.getHours();
                    // var minutes = event.getMinutes();
                    // var ampm = hours >= 12 ? "pm" : "am";
                    // hours = hours % 12;
                    // hours = hours ? hours : 12; // the hour '0' should be '12'
                    // minutes = minutes < 10 ? "0" + minutes : minutes;
                    // var strTime = hours + ":" + minutes + " " + ampm;
                    // var strTime = hours + ":" + minutes + " " + ampm;

                    // toDate = JSON.stringify(event);
                    // toDate = toDate.slice(1, 11) + " " + strTime;
                }
            });

            let finalDate = fromDate + "~" + toDate;

            return finalDate;
        },
        timeAndDate(date,time) {
           
            let x = moment(date + ' ' + time).format('YYYY-MM-DD HH:mm:ss');
            // let x = moment(val).format('YYYY-MM-DD');
            return moment(date + ' ' + time).format('YYYY-MM-DD HH:mm:ss');
        },
        timeFormater(val) {
           
            let x = moment(val).format('hh:mm:ss a');
            return moment(val).format('hh:mm:ss a');
            // return moment(val).format('YYYY-MM-DD hh:mm');

            // var hours = event.getHours();
            // var minutes = event.getMinutes();
            // let date = JSON.stringify(event);
            // date = date.slice(1, 11) + " " + hours + ":" + minutes;
            // return date;
        },
        dateFormater(val) {
            
            let x = moment(val).format('YYYY-MM-DD');
            return moment(val).format('YYYY-MM-DD');
            // return moment(val).format('YYYY-MM-DD hh:mm');

            // var hours = event.getHours();
            // var minutes = event.getMinutes();
            // let date = JSON.stringify(event);
            // date = date.slice(1, 11) + " " + hours + ":" + minutes;
            // return date;
        },
        sendMoblieSMS(countryCode, number, message) {
            this.setTokenToHeader();
            let formData = {};
            formData["message"] = message;
            formData["recipients"] = "+" + countryCode + number;
            axios
                .post("/api/sendMessage", formData)
                .then(response => {
                    return true;
                })
                .catch(error => {
                    return false;
                });
        },
        fakeClick() {
            return false;
        },
        getDay(d){
            var oldDate = new Date(d);
            return moment(oldDate).format('ddd D MMM');
          },
          formatedDate(d){
            var oldDate = new Date(d);
            return moment(oldDate).format('MMM-D-YYYY');
          },
        setTokenToHeader() {
            axios.defaults.headers.common["Authorization"] =
                "Bearer " + localStorage.getItem("token");
        },
        requiredFieldCheck(checkField, fieldName) {
            if (checkField == "") {
                return `${fieldName} is required`;
            }
            return true;
        },
        addRecord(type, formData, targetPage) {
            let text = this.capitalize(type);
            let url = "/api/" + "add" + text;
            if (url == "/api/add/Teacher") {
                formData["phoneNumber"] =
                    "+" +
                    formData.teacher.countryCode +
                    this.teacher.phoneNumber;
            }

            axios.post(url, formData).then(response => {
                // this.goBack();
                // this.addStatus('Add Successfully');
                this.$router.push(targetPage);
            });
        },
        updateRecord(type, formData, id, targetPage) {
            let text = this.capitalize(type);
            let url = "/api/" + "update" + text + "/" + id;

            console.log(url);

            axios.post(url, formData).then(response => {
                // this.goBack();
                this.addStatus('update successfully');
                this.$router.push(targetPage);
            });
        },
        getSpecificRecord(type, id) {
            let text = this.capitalize(type);
            let url = "/api/" + "get" + text + "/" + id;

            return axios.get(url).then(response => {
                return response.data.result;
            });
        },

        //get subject according to subject
        /*getTeacherSpecificSubject(id){
            let url = "/api/get/getTeacherSubject" + id;

            return axios.get(url).then(response => {
                return response.data.result;
            });
        },*/
        deleteRecord(type, id) {
            
            let text = this.capitalize(type);
            let url = "/api/" + "delete" + text;
            let formData = {};
            formData["id"] = id;
            return axios.post(url, formData).then(response => {
                return response.data;
            });
        },
        async getRecord(type, event, allowPagination = true) {
            let text = this.capitalize(type);
            let url = "";
            if (allowPagination) {
                url = "/api/" + "get" + text + "s" + "?page=" + event;
            } else {
                url =
                    "/api/" +
                    "get" +
                    text +
                    "s" +
                    "?allowPagination=false" +
                    "?page=" +
                    event;
            }
            return axios.post(url).then(response => {

                return response.data.result;
            });
        },
        async getActiveRecord(type, event) {
            let text = this.capitalize(type);
            let url =
                "/api/" + "getAll-Active-" + text + "s" + "?page=" + event;

            return axios.post(url).then(response => {
                return response.data.result;
            });
        },
        capitalize(text) {
            return text.replace(/\b\w/g, function(m) {
                return m.toUpperCase();
            });
        },
        goBack() {
            this.$router.go(-1);
        }
    }
};
