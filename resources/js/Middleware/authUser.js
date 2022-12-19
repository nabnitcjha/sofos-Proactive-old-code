import store from "../vuex/store/index";

export default (to, from, next) => {
    if (store.getters["isAuthenticated"]) {
        let user = store.getters["user"];
        if (!user) {
            return next({
                path: "/"
            });
        }
        // let isAdminAllow = user.role.indexOf("superadmin") > -1;
        // let isOrgAllow = user.role.indexOf("businessowner") > -1;
        // let isCandidateAllow = user.role.indexOf("candidate") > -1;

        // console.log('path',to.fullPath);
        // if(to.fullPath == '/employer/login' && !isOrgAllow){
        //     return next({
        //         path: "/changeLogin/organization",
        //     });
        // }
        // if(to.fullPath == '/admin/login' && !isAdminAllow){
        //     return next({
        //         path: "/changeLogin/admin",
        //     });
        // }
        // if(to.fullPath == '/login' && !isCandidateAllow){
        //     return next({
        //         path: "/changeLogin/candidate",
        //     });
        // }
        // return next({
        //     path: "/",
        // });

    }
    next();
}
