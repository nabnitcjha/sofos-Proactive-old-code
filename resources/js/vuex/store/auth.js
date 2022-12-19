export default {
    state: {
        token: null,
        user: null,
        permissions:null,
        roleNames:null,
        notification: null,
        isFirstTime: false,
        pageTitle:'',
        pageView:'',
        authenticationStatus: false,
        session:null,
        isStudentAdd:false,
        isTeacherAdd:false,
    },
    getters: {
        isAuthenticated(state) {
            if (state.token) {
                state.authenticationStatus = true;
                return state.authenticationStatus;
            } else {
                state.authenticationStatus = false;
                return state.authenticationStatus;
            }
        },
        isStudentAdd(state){
            return state.isStudentAdd;
        },
        isTeacherAdd(state){
            return state.isTeacherAdd;
        },
        user(state) {
            return state.user;
        },
        permissions(state) {
            return state.permissions;
        },
        roleNames(state) {
            return state.roleNames;
        },
        authtoken(state) {

            return state.token;
        },
        isFirstTime(state) {
            return state.isFirstTime;
        },
        pageTitle(state) {
            return state.pageTitle;
        },
        pageView(state) {
            return state.pageView;
        },
        session(state) {
            return state.session;
        }
    },
    mutations: {
        SET_STUDENT_ADD_INFO(state, status) {
            state.isStudentAdd = status;
        },
        SET_TEACHER_ADD_INFO(state, status) {
            state.isTeacherAdd = status;
        },
        SET_TOKEN(state, token) {
            state.token = token;
        },
        SET_SESSION(state, session) {
            state.session = session;
        },
        SET_USER(state, user) {
            state.user = user;
        },
        SET_PERMISSIONS(state, permissions) {
            state.permissions = permissions;
        },
        SET_ROLENAMES(state, roleNames) {
            state.roleNames = roleNames;
        },
        SET_ISFIRSTTIME(state, value) {
            state.isFirstTime = value;
        },
        SET_PAGE_TITLE(state, value) {
            console.log('value ==>>>',value);
            
            state.pageTitle = value;
        },
        SET_PAGE_VIEW(state, value) {
            console.log('value ==>>>',value);
            
            state.pageView = value;
        }
    },
    actions: {
        // ----------------------------- after login go to dashboard help function -------------------------
        async studentAddStatus({ commit }, data) {
            commit("SET_STUDENT_ADD_INFO", data);
        },
        async teacherAddStatus({ commit }, data) {
            commit("SET_TEACHER_ADD_INFO", data);
        },
        async reloadUser({ commit }, data) {
            commit("SET_USER", data);
        },
        async afterLogin({ dispatch }, credential) {
            return dispatch("attempt", credential.access_token);
        },
        async attempt({ commit }, token) {
            
            if (token) {
                commit("SET_TOKEN", token);
            }
            if (!token) {
                return;
            }
            try {
                
                axios.defaults.headers.common["Authorization"] =
                    "Bearer " + token;
                axios.get("/api/me").then(response => {
                    
                    commit("SET_USER", response.data);
                    var newPermissions = response.data.permissions.map(function(val, index){
                        return val.name;
                    });
                    commit("SET_PERMISSIONS",newPermissions);
                    commit("SET_ROLENAMES",response.data.roleNames);
                });
            } catch (e) {
                commit("SET_USER", null);
                commit("SET_TOKEN", null);
            }
        },
        // ------------------------------------ dashboard issue fix function ---------------------------
        async firstTimeValue({ dispatch }, credential) {
            return dispatch("setIsFirstTimeValue", credential.makeTrue);
        },
        async setIsFirstTimeValue({ commit }, makeTrue) {
            commit("SET_ISFIRSTTIME", makeTrue);
        },
        async setPageTitle({ commit }, title) {
            
            commit("SET_PAGE_TITLE", title);
        },
        async setPageView({ commit }, title) {
            
            commit("SET_PAGE_VIEW", title);
        },
        async setSession({ commit }, session) {
            
            commit("SET_SESSION", session);
        },
        // -------------------- after logout user still in dashboard so help to go outside from dashboard function ------------
        async setAuthenticationFalse({ dispatch }) {
            return dispatch("setUserAuth");
        },
        async setUserAuth({ commit }) {
            commit("SET_USER", null);
            commit("SET_TOKEN", null);
        }
    }
};
