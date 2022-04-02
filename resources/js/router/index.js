import Login from "../login/LoginComponent.vue";
import Register from "../login/RegisterComponent.vue";
import ForgotPassword from "../login/ForgotPasswordComponent.vue";
import ResetPasswordComponent from "../login/ResetPasswordComponent.vue";
//admin
<<<<<<< HEAD
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
import ViewAnnouncement from "../components/AnnouncementComponent.vue";
import Marketplace from "../components/PostMarketplaceComponent.vue";

//user
import UserHome from "../user/dashboard/UserHomeComponent.vue";
import UserDashboard from "../user/dashboard/UserDashboardComponent.vue";
//import AnnouncementComponent from "../components/AnnouncementComponent.vue";
=======
import HomeComponent from "../admin/HomeComponent.vue";
import Block_Lot from "../admin/Block_LotComponent.vue";
import RegisteredUsersComponent from "../admin/RegisterUsersComponent.vue";
import Announcement from "../admin/Announcement.vue";
import ResidentComponent from "../admin/ResidentComponent.vue";
import OfficerComponent from "../admin/OfficerComponent.vue";
import SecurityOfficerComponent from "../admin/SecurityOfficerComponent.vue";
import EmergencyContactDetail from "../admin/EmergencyContactDetail.vue";
import Position from "../admin/PositionComponent.vue";
import Candidate from "../admin/CandidateComponent.vue";
import ElectionComponent from "../admin/ElectionComponent.vue";

//user
import UserHome from "../user/UserHomeComponent.vue";
>>>>>>> 4db789ac93e6d00324b76355b86341ebd84bb5b0

//security officer
import SecurityHome from "../security_officer/SecurityHomeComponent.vue";
import LogComponent from "../security_officer/LogComponent.vue";

import TimelineComponent from "../components/TimelineComponent.vue";
import MarketplaceComponent from "../components/MarketplaceComponent.vue";
import IndexComponent from "../home/IndexComponent.vue";
import AnnouncementComponent from "../components/AnnouncementComponent.vue";
import EmergencyContactComponent from "../components/EmergencyContactComponent.vue";
import NotFound from "../components/NotFoundComponent.vue";
import AppProfile from "../components/AppProfile.vue";
import BlockUser from "../components/BlockUserComponent.vue";
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
            (userLogged.role === "admin" || userLogged.role === "officer") &&
            (to.meta.role === "resident" || to.meta.role === "security_officer")
        ) {
            next("/admin/timeline");
        }
        if (
            userLogged.role === "resident" &&
            (to.meta.role === "admin" || to.meta.role === "security_officer")
        ) {
            next("/resident/timeline");
        }
        if (
            userLogged.role === "security_officer" &&
            (to.meta.role === "admin" || to.meta.role === "resident")
        ) {
            next("/security/timeline");
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

    if (
        isAuthenticated &&
        (userLogged.role === "admin" || userLogged.role === "officer")
    ) {
        next("/admin/timeline");
    } else if (isAuthenticated && userLogged.role === "resident") {
        next("/resident/timeline");
    } else if (isAuthenticated && userLogged.role === "security_officer") {
        next("/security_officer/timeline");
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
                    path: "/admin/timeline",
                    beforeEnter: checkRole,
                    meta: {
                        role: "admin",
                    },
                    components: {
                        default: NotFound,
                        contents: TimelineComponent,
                    },
                },
                {
                    path: "marketplace",
                    beforeEnter: checkRole,
                    meta: {
                        role: "admin",
                    },
                    components: {
                        default: NotFound,
                        contents: MarketplaceComponent,
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
                    path: "block_user",
                    meta: {
                        role: "admin",
                    },
                    beforeEnter: checkRole,
                    components: {
                        default: NotFound,
                        contents: BlockUser,
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
                {
                    path: "view-announcement",
                    meta: {
                        role: "admin",
                    },
                    beforeEnter: checkRole,
                    components: {
                        default: NotFound,
                        contents: ViewAnnouncement,
                    },
                },
                {
                    path: "marketplace",
                    meta: {
                        role: "admin",
                    },
                    beforeEnter: checkRole,
                    components: {
                        default: NotFound,
                        contents: Marketplace,
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
                    path: "/resident/timeline",
                    meta: {
                        role: "resident",
                    },
                    beforeEnter: checkRole,
                    meta: {
                        reload: true,
                    },
                    components: {
                        default: NotFound,
                        contents: TimelineComponent,
                    },
                },
                {
                    path: "marketplace",
                    beforeEnter: checkRole,
                    meta: {
                        role: "resident",
                    },
                    components: {
                        default: NotFound,
                        contents: MarketplaceComponent,
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
                    path: "block_user",
                    meta: {
                        role: "resident",
                    },
                    beforeEnter: checkRole,
                    components: {
                        default: NotFound,
                        contents: BlockUser,
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
                {
<<<<<<< HEAD
                    path: "marketplace",
=======
                    path: "emergency",
>>>>>>> 4db789ac93e6d00324b76355b86341ebd84bb5b0
                    meta: {
                        role: "resident",
                    },
                    beforeEnter: checkRole,
                    components: {
                        default: NotFound,
<<<<<<< HEAD
                        contents: Marketplace,
=======
                        contents: EmergencyContactComponent,
>>>>>>> 4db789ac93e6d00324b76355b86341ebd84bb5b0
                    },
                },
            ],
        },
        {
            path: "/security_officer",
            component: SecurityHome,
            meta: {
                role: "security_officer",
            },
            beforeEnter: checkRole,
            name: "securityhome",
            children: [
                {
                    path: "/security_officer/timeline",
                    meta: {
                        role: "security_officer",
                    },
                    beforeEnter: checkRole,
                    meta: {
                        reload: true,
                    },
                    components: {
                        default: NotFound,
                        contents: TimelineComponent,
                    },
                },
                {
                    path: "marketplace",
                    beforeEnter: checkRole,
                    meta: {
                        role: "securit_officer",
                    },
                    components: {
                        default: NotFound,
                        contents: MarketplaceComponent,
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
                {
                    path: "block_user",
                    meta: {
                        role: "security_officer",
                    },
                    beforeEnter: checkRole,
                    components: {
                        default: NotFound,
                        contents: BlockUser,
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
                    path: "emergency",
                    meta: {
                        role: "security_officer",
                    },
                    beforeEnter: checkRole,
                    components: {
                        default: NotFound,
                        contents: EmergencyContactComponent,
                    },
                },
                {
                    path: "marketplace",
                    meta: {
                        role: "security_officer",
                    },
                    beforeEnter: checkRole,
                    components: {
                        default: NotFound,
                        contents: Marketplace,
                    },
                },
            ],
        },
    ],
});

export default router;
