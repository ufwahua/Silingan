import Login from "../login/LoginComponent.vue";
import Register from "../login/RegisterComponent.vue";
import ForgotPassword from "../login/ForgotPasswordComponent.vue";
//admin
import IndexComponent from "../home/IndexComponent.vue";
import HomeComponent from "../admin/dashboard/HomeComponent.vue";
import DashboardComponent from "../admin/dashboard/DashboardComponent.vue";
import Block_Lot from "../admin/dashboard/Block_LotComponent.vue";
import RegisteredUsersComponent from "../admin/dashboard/RegisterUsersComponent.vue";
import Announcement from "../admin/dashboard/Announcement.vue";
import ResidentComponent from "../admin/dashboard/ResidentComponent.vue";

import Position from "../admin/dashboard/PositionComponent.vue";

//user
import UserHome from "../user/dashboard/UserHomeComponent.vue";
import UserDashboard from "../user/dashboard/UserDashboardComponent.vue";

import NotFound from "../not-found-components/NotFoundComponent.vue";
import { createRouter, createWebHistory } from "vue-router";
import store from "../store/store";

function checkRole(to, from, next) {
    let isAuthenticated = false;
    let userLogged = store.state.userLogged;
    if (userLogged) isAuthenticated = true;
    else isAuthenticated = false;

    if (!isAuthenticated) {
        next({ name: "login" });
    } else {
        if (userLogged.role === "admin" && to.meta.role === "resident") {
            next("/admin/dashboard");
        }
        if (userLogged.role === "resident" && to.meta.role === "admin") {
            next("/resident/dashboard");
        }
        next();
    }
}
function checkLogged(to, from, next) {
    let isAuthenticated = false;
    let userLogged = store.state.userLogged;

    if (userLogged) isAuthenticated = true;
    else isAuthenticated = false;

    if (isAuthenticated && userLogged.role === "admin") {
        next("/admin/dashboard");
    } else if (isAuthenticated && userLogged.role === "resident") {
        next("/resident/dashboard");
    } else {
        next();
    }
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
            path: "/forgotpassword",
            component: ForgotPassword,
            beforeEnter: checkLogged,
            name: "forgotpassword",
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
            meta: {
                role: "admin",
            },
            children: [
                {
                    path: "/admin/dashboard",
                    beforeEnter: checkRole,
                    meta: {
                        role: "admin",
                    },
                    components: {
                        default: NotFound,
                        contents: DashboardComponent,
                    },
                },
                {
                    path: "block-lot",
                    beforeEnter: checkRole,
                    meta: {
                        role: "admin",
                    },
                    components: {
                        default: NotFound,
                        contents: Block_Lot,
                    },
                },
                {
                    path: "residents",
                    meta: {
                        role: "admin",
                    },
                    beforeEnter: checkRole,
                    components: {
                        default: NotFound,
                        contents: ResidentComponent,
                    },
                },
                {
                    path: "registered-users",
                    meta: {
                        role: "admin",
                    },
                    beforeEnter: checkRole,
                    components: {
                        default: NotFound,
                        contents: RegisteredUsersComponent,
                    },
                },
                {
                    path: "position",
                    meta: {
                        role: "admin",
                    },
                    beforeEnter: checkRole,
                    components: {
                        default: NotFound,
                        contents: Position,
                    },
                },
                {
                    path: "announcement",
                    meta: {
                        role: "admin",
                    },
                    beforeEnter: checkRole,
                    components: {
                        default: NotFound,
                        contents: Announcement,
                    },
                },
            ],
        },
        {
            path: "/resident",
            component: UserHome,
            meta: {
                role: "resident",
            },
            beforeEnter: checkRole,
            name: "userhome",
            children: [
                {
                    path: "/resident/dashboard",
                    meta: {
                        role: "resident",
                    },
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
