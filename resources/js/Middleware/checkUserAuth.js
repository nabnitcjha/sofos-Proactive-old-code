import store from "../vuex/store/index";
export default (to, from, next) => {
    let user = store.getters["isAuthenticated"];
    if (!user) {
        return next({
            path: "/adminlogin"
        });
    }
    next();
};
