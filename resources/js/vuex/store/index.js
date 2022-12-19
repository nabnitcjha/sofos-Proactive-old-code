import Vue from "vue";

import createPersistedState from "vuex-persistedstate";

import Vuex from "vuex";
import auth from "./auth";


Vue.use(Vuex);

export default new Vuex.Store({
    state: {},
    mutations: {},
    actions: {},
    modules: {
        auth,
    },
    plugins: [createPersistedState()],
});
