import Login from "../login/LoginComponent.vue";
import Register from "../login/RegisterComponent.vue";
import IndexComponent from "../home/IndexComponent.vue";
import HomeComponent from "../admin/dashboard/HomeComponent.vue";
import DashboardComponent from "../admin/dashboard/DashboardComponent.vue";
import Block_Lot from "../admin/dashboard/Block_LotComponent.vue";
import RegisteredUsersComponent from "../admin/dashboard/RegisterUsersComponent.vue";

import UserHome from "../user/dashboard/UserHomeComponent.vue";
import UserDashboard from "../user/dashboard/UserDashboardComponent.vue";

import NotFound from "../not-found-components/NotFoundComponent.vue";
import { createRouter, createWebHistory } from "vue-router";
import { computed } from "vue";
import { useStore } from "vuex";

function checkRole(to, from, next) {
    var isAuthenticated = false;
    var role = localStorage.role;
    if (localStorage.getItem("user")) isAuthenticated = true;
    else isAuthenticated = false;
    if (isAuthenticated) {
        next();
    } else {
        next("/login");
    }

    // let isAuthenticated = false;
    // let userLogged = store.state.userLogged;
    // if (userLogged) isAuthenticated = true;
    // else isAuthenticated = false;

    // if (!isAuthenticated) {
    //     next({ name: "login" });
    // } else {
    //     console.log(to.name);
    //     if (userLogged.type === "admin" && to.meta.role === "employee") {
    //         next("/admin/dashboard");
    //     }
    //     if (userLogged.type === "employee" && to.meta.role === "admin") {
    //         next("/employee/dashboard");
    //     }
    //     next();
    // }
}
function checkLogged(to, from, next) {
    var isAuthenticated = false;
    var role = localStorage.role;
    if (localStorage.getItem("user")) isAuthenticated = true;
    else isAuthenticated = false;
    if (isAuthenticated && role === "admin") {
        next("/admin/dashboard");
    } else if (isAuthenticated && role === "resident") {
        next("/user/dashboard");
    } else {
        next();
    }

    //  let isAuthenticated = false;
    //  let userLogged = store.state.userLogged;
    //  if (userLogged) isAuthenticated = true;
    //  else isAuthenticated = false;

    //  if (isAuthenticated && userLogged.type === "admin") {
    //      next("/admin/dashboard");
    //  } else if (isAuthenticated && userLogged.type === "employee") {
    //      next("/employee/dashboard");
    //  } else {
    //      next();
    //  }
}
const router = createRouter({
    history: createWebHistory(),
    linkActiveClass: "active",
    routes: [
        { path: "/:pathMatch(.*)*", component: NotFound },
        {
            path: "/",
            component: IndexComponent,
            beforeEnter: checkLogged,
            name: "index",
            meta: {
                reload: true,
            },
        },
        {
            path: "/login",
            component: Login,
            beforeEnter: checkLogged,
            name: "login",
        },
        {
            path: "/register",
            component: Register,
            beforeEnter: checkLogged,
            name: "register",
        },
        {
            path: "/admin",
            component: HomeComponent,
            beforeEnter: checkRole,
            name: "adminHome",

            children: [
                {
                    path: "/admin/dashboard",
                    beforeEnter: checkRole,

                    components: {
                        default: NotFound,
                        contents: DashboardComponent,
                    },
                },
                {
                    path: "block-lot",
                    beforeEnter: checkRole,
                    components: {
                        default: NotFound,
                        contents: Block_Lot,
                    },
                },
                {
                    path: "registered-users",
                    beforeEnter: checkRole,
                    components: {
                        default: NotFound,
                        contents: RegisteredUsersComponent,
                    },
                },
            ],
        },
        {
            path: "/user",
            component: UserHome,
            beforeEnter: checkRole,
            name: "userhome",
            children: [
                {
                    path: "/user/dashboard",
                    beforeEnter: checkRole,
                    meta: {
                        reload: true,
                    },
                    components: {
                        default: NotFound,
                        contents: UserDashboard,
                    },
                },
            ],
        },
    ],
});

export default router;
