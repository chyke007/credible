import Vue from "vue";
import VueRouter from "vue-router";

//Auth Routes
import Login from "@/js/views/Login";
import Register from "@/js/views/Register";

//Secured routes
import Dashboard from "@/js/views/Dashboard";
import AllTransfer from "@/js/views/AllTransfer";
import Transfer from "@/js/views/Transfer";
import Profile from "@/js/views/Profile";
import Approve from "@/js/views/Approve";

//Officers
// import Payment from '@/js/Views/Payment'

//Vuex Store
import Store from "./stores";

//Route append
const routesWithPrefix = (prefix, routes) => {
    return routes.map(route => {
        route.path = `${prefix}${route.path}`;

        return route;
    });
};

Vue.use(VueRouter);

const router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/login",
            name: "login",
            component: Login,
            meta: {
                auth: false
            }
        },
        {
            path: "/register",
            name: "register",
            component: Register,
            meta: {
                auth: false
            }
        },
        //Secured Routes
        {
            path: "/dashboard",
            name: "dashboard",
            component: Dashboard,
            meta: {
                auth: true
                // requiresAdmin: true
            }
        },
        {
            path: "/transfer",
            name: "transfer",
            component: Transfer,
            meta: {
                auth: true,
                requiresUser: true
            }
        },
        {
            path: "/alltransfer",
            name: "alltransfer",
            component: AllTransfer,
            meta: {
                auth: true,
                requiresAdmin: true
            }
        },
        {
            path: "/profile",
            name: "profile",
            component: Profile,
            meta: {
                auth: true,
                requiresUser: true
            }
        },
        {
            path: "/approve",
            name: "approve",
            component: Approve,
            meta: {
                auth: true,
                requiresAdmin: true
            }
        },
        {
            path: "*",
            redirect: "/login"
        }
    ]
});

router.beforeEach((to, from, next) => {
    //Implements auth
    if (to.matched.some(record => record.meta.auth)) {
        if (Store.state.credpal.user_token == null) {
            next("login");
        } else {
            next();
        }
    } else if (to.matched.some(record => !record.meta.auth)) {
        if (Store.state.credpal.user_token == null) {
            next();
        } else {
            next("dashboard");
        }
    }

    if (to.fullPath == "/login") {
        if (Store.state.credpal.user_token != null) {
            next("dashboard");
        } else {
            next();
        }
    } else if (to.fullPath == "/dashboard") {
        if (Store.state.credpal.user_token == null) {
            next("login");
        } else {
            next();
        }
    }

    //checks for admin and user route and protect them adequately

    if (to.matched.some(record => record.meta.requiresAdmin)) {
        if (Store.state.credpal.user_role === 1) {
            next();
        } else {
            next("/dashboard");
        }
    }

    if (to.matched.some(record => record.meta.requiresUser)) {
        if (Store.state.credpal.user_role === 2) {
            next();
        } else {
            next("/dashboard");
        }
    }
});
export default router;
