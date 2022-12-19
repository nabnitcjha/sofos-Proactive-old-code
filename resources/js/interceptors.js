import axios from "axios";

import  store  from './vuex/store';

export default function interceptorRequests(){
    axios.interceptors.request.use(function (config) {
        // Do something before request is sent
        return config;
      }, function (error) {
        if (error && error.response && error.response.data && error.response.data.message=="Unauthenticated.") {
            store.dispatch('setAuthenticationFalse')
            location.href = window.location.origin + "/#/adminlogin";
          }
        // Do something with request error
        // store.dispatch('setAuthenticationFalse')
        return Promise.reject(error);
      });

    // Add a response interceptor
    axios.interceptors.response.use(function (response) {
        // Any status code that lie within the range of 2xx cause this function to trigger
        // Do something with response data
        return response;
      }, function (error) {
        if (error && error.response && error.response.data && error.response.data.message=="Unauthenticated.") {
            store.dispatch('setAuthenticationFalse')
            location.href = window.location.origin + "/#/adminlogin";
          }
        // Any status codes that falls outside the range of 2xx cause this function to trigger
        // Do something with response error


        return Promise.reject(error);
      });

}


