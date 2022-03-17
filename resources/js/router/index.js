import Login from "../login/LoginComponent.vue";
import Register from "../login/RegisterComponent.vue";
import ForgotPassword from "../login/ForgotPasswordComponent.vue";
import ResetPasswordComponent from "../login/ResetPasswordComponent.vue";
//admin
import HomeComponent from "../admin/dashboard/HomeComponent.vue";
import DashboardComponent from "../admin/dashboard/DashboardComponent.vue";
import Block_Lot from "../admin/dashboard/Block_LotComponent.vue";
import RegisteredUsersComponent from "../admin/dashboard/RegisterUsersComponent.vue";
import Announcement from "../admin/dashboard/Announcement.vue";
import ResidentComponent from "../admin/dashboard/ResidentComponent.vue";
import OfficerComponent from "../admin/dashboard/OfficerComponent.vue";
import SecurityOfficerComponent from "../admin/dashboard/SecurityOfficerComponent.vue";
import AppProfile from "../components/AppProfile.vue";
import EmergencyContactDetail from "../admin/dashboard/EmergencyContactDetail.vue";
import Position from "../admin/dashboard/PositionComponent.vue";
import Candidate from "../admin/dashboard/CandidateComponent.vue";
import ElectionComponent from "../admin/dashboard/ElectionComponent.vue";

//user
import UserHome from "../user/dashboard/UserHomeComponent.vue";
import UserDashboard from "../user/dashboard/UserDashboardComponent.vue";

//security officer
import SecurityHome from "../security_officer/dashboard/SecurityHomeComponent.vue";
import SecurityDashboard from "../security_officer/dashboard/SecurityDashboardComponent.vue";
import LogComponent from "../security_officer/dashboard/LogComponent.vue";

import IndexComponent from "../home/IndexComponent.vue";
import AnnouncementComponent from "../components/AnnouncementComponent.vue";
import NotFound from "../components/NotFoundComponent.vue";
import { createRouter, createWebHistory } from "vue-router";
import store from "../store/store";

function checkRole(to, from, next) {
    let isAuthenticated = false;
    store.dispatch("getUserLogged");
    let userLogged = store.state.userLogged;
    if (userLogged) isAuthenticated = true;
    else isAuthenticated = false;

    if (!isAuthenticated) {
        next({ name: "login" });
    } else {
        if (
            userLogged.role === "admin" &&
            (to.meta.role === "resident" || to.meta.role === "security_officer")
        ) {
            next("/admin/dashboard");
        }
        if (
            userLogged.role === "resident" &&
            (to.meta.role === "admin" || to.meta.role === "security_officer")
        ) {
            next("/resident/dashboard");
        }
        if (
            userLogged.role === "security_officer" &&
            (to.meta.role === "admin" || to.meta.role === "resident")
        ) {
            next("/security/dashboard");
        }

        next();
    }
}
function checkLogged(to, from, next) {
    let isAuthenticated = false;
    store.dispatch("getUserLogged");
    let userLogged = store.state.userLogged;
    if (userLogged) isAuthenticated = true;
    else isAuthenticated = false;

    if (isAuthenticated && userLogged.role === "admin") {
        next("/admin/dashboard");
    } else if (isAuthenticated && userLogged.role === "resident") {
        next("/resident/dashboard");
    } else if (isAuthenticated && userLogged.role === "security_officer") {
        next("/security/dashboard");
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
            path: "/forgot-password",
            component: ForgotPassword,
            beforeEnter: checkLogged,
            name: "forgotpassword",
        },
        {
            path: "/reset-password",
            component: ResetPasswordComponent,
            beforeEnter: checkLogged,
            name: "resetpassword",
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
                    path: "candidate",
                    meta: {
                        role: "admin",
                    },
                    beforeEnter: checkRole,
                    components: {
                        default: NotFound,
                        contents: Candidate,
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
                {
                    path: "officers",
                    meta: {
                        role: "admin",
                    },
                    beforeEnter: checkRole,
                    components: {
                        default: NotFound,
                        contents: OfficerComponent,
                    },
                },
                {
                    path: "security-officers",
                    meta: {
                        role: "admin",
                    },
                    beforeEnter: checkRole,
                    components: {
                        default: NotFound,
                        contents: SecurityOfficerComponent,
                    },
                },
                {
                    path: "profile",
                    meta: {
                        role: "admin",
                    },
                    beforeEnter: checkRole,
                    components: {
                        default: NotFound,
                        contents: AppProfile,
                    },
                },
                {
                    path: "emergency-contact-detail",
                    meta: {
                        role: "admin",
                    },
                    beforeEnter: checkRole,
                    components: {
                        default: NotFound,
                        contents: EmergencyContactDetail,
                    },
                },
                {
                    path: "election",
                    meta: {
                        role: "admin",
                    },
                    beforeEnter: checkRole,
                    components: {
                        default: NotFound,
                        contents: ElectionComponent,
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
                {
                    path: "profile",
                    meta: {
                        role: "resident",
                    },
                    beforeEnter: checkRole,
                    components: {
                        default: NotFound,
                        contents: AppProfile,
                    },
                },
                {
                    path: "announcement",
                    meta: {
                        role: "resident",
                    },
                    beforeEnter: checkRole,
                    components: {
                        default: NotFound,
                        contents: AnnouncementComponent,
                    },
                },
            ],
        },
        {
            path: "/security",
            component: SecurityHome,
            meta: {
                role: "security_officer",
            },
            beforeEnter: checkRole,
            name: "securityhome",
            children: [
                {
                    path: "/security/dashboard",
                    meta: {
                        role: "security_officer",
                    },
                    beforeEnter: checkRole,
                    meta: {
                        reload: true,
                    },
                    components: {
                        default: NotFound,
                        contents: SecurityDashboard,
                    },
                },
                {
                    path: "profile",
                    meta: {
                        role: "security_officer",
                    },
                    beforeEnter: checkRole,
                    components: {
                        default: NotFound,
                        contents: AppProfile,
                    },
                },
                {
                    path: "announcement",
                    meta: {
                        role: "security_officer",
                    },
                    beforeEnter: checkRole,
                    components: {
                        default: NotFound,
                        contents: AnnouncementComponent,
                    },
                },
                {
                    path: "log",
                    meta: {
                        role: "security_officer",
                    },
                    beforeEnter: checkRole,
                    components: {
                        default: NotFound,
                        contents: LogComponent,
                    },
                },
            ],
        },
    ],
});

export default router;
