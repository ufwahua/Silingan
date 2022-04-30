import Login from "../login/LoginComponent.vue";
import Register from "../login/RegisterComponent.vue";
import ForgotPassword from "../login/ForgotPasswordComponent.vue";
import ResetPasswordComponent from "../login/ResetPasswordComponent.vue";
//admin
import AdminHomeComponent from "../admin/AdminHomeComponent.vue";
import BlockLot from "../admin/BlockLotComponent.vue";
import RegisteredUsersComponent from "../admin/RegisterUsersComponent.vue";
import Announcement from "../admin/Announcement.vue";
import ResidentComponent from "../admin/ResidentComponent.vue";
import OfficerComponent from "../admin/OfficerComponent.vue";
import SecurityOfficerComponent from "../admin/SecurityOfficerComponent.vue";
import Position from "../admin/PositionComponent.vue";
import ElectionComponent from "../admin/ElectionComponent.vue";
import CardComponent from "../admin/CardComponent.vue";
import VehicleComponent from "../admin/VehicleComponent.vue";
import VerifyMarketPlaceComponent from "../admin/VerifyMarketPlaceComponent.vue";
import CashflowComponent from "../admin/CashflowComponent.vue";
import CollectionTypeComponent from "../admin/CollectionTypeComponent.vue";

//resident
import ResidentHomeComponent from "../resident/ResidentHomeComponent.vue";
import BillingComponent from "../resident/BillingComponent.vue";
import VoteElectionComponent from "../resident/VoteElectionComponent.vue";

//security officer
import SecurityHome from "../security_officer/SecurityHomeComponent.vue";

//all
import TimelineComponent from "../components/TimelineComponent.vue";
import MarketplaceComponent from "../components/MarketplaceComponent.vue";
import IndexComponent from "../home/IndexComponent.vue";
import AnnouncementComponent from "../components/AnnouncementComponent.vue";
import NotFound from "../components/NotFoundComponent.vue";
import AppProfile from "../components/AppProfile.vue";
import SettingComponent from "../components/SettingComponent.vue";
import ActivateAccountComponent from "../components/ActivateAccountComponent.vue";
import LogComponent from "../components/LogComponent.vue";
import SpecificPostComponent from "../components/SpecificPostComponent.vue";

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
            userLogged.role === "security officer" &&
            (to.meta.role === "admin" || to.meta.role === "resident")
        ) {
            next("/security/timeline");
        }

        next();
    }
}

function checkLogged(to, from, next) {
    let isAuthenticated = false;
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
    } else if (isAuthenticated && userLogged.role === "security officer") {
        next("/security-officer/timeline");
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
            component: AdminHomeComponent,
            beforeEnter: checkRole,
            name: "adminHome",
            meta: {
                role: "admin",
            },
            children: [
                {
                    path: "timeline",
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
                        contents: BlockLot,
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
                    path: "setting",
                    meta: {
                        role: "admin",
                    },
                    beforeEnter: checkRole,
                    components: {
                        default: NotFound,
                        contents: SettingComponent,
                    },
                },

                {
                    path: "activate-account",
                    meta: {
                        role: "admin",
                    },

                    components: {
                        default: NotFound,
                        contents: ActivateAccountComponent,
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
                    path: "card",
                    meta: {
                        role: "admin",
                    },
                    beforeEnter: checkRole,
                    components: {
                        default: NotFound,
                        contents: CardComponent,
                    },
                },
                {
                    path: "vehicle",
                    meta: {
                        role: "admin",
                    },
                    beforeEnter: checkRole,
                    components: {
                        default: NotFound,
                        contents: VehicleComponent,
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

                        contents: AnnouncementComponent,
                    },
                },
                {
                    path: "verify-marketplace",
                    meta: {
                        role: "admin",
                    },
                    beforeEnter: checkRole,
                    components: {
                        default: NotFound,

                        contents: VerifyMarketPlaceComponent,
                    },
                },
                {
                    path: "cashflow",
                    meta: {
                        role: "admin",
                    },
                    beforeEnter: checkRole,
                    components: {
                        default: NotFound,

                        contents: CashflowComponent,
                    },
                },
                {
                    path: "collection_type",
                    meta: {
                        role: "admin",
                    },
                    beforeEnter: checkRole,
                    components: {
                        default: NotFound,

                        contents: CollectionTypeComponent,
                    },
                },
                {
                    path: "log",
                    meta: {
                        role: "admin",
                    },
                    beforeEnter: checkRole,
                    components: {
                        default: NotFound,
                        contents: LogComponent,
                    },
                },
                {
                    path: "post/:post",
                    meta: {
                        role: "admin",
                    },
                    beforeEnter: checkRole,
                    components: {
                        default: NotFound,
                        contents: SpecificPostComponent,
                    },
                },
            ],
        },
        {
            path: "/resident",
            component: ResidentHomeComponent,
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
                    path: "setting",
                    meta: {
                        role: "resident",
                    },
                    beforeEnter: checkRole,
                    components: {
                        default: NotFound,
                        contents: SettingComponent,
                    },
                },

                {
                    path: "view-announcement",
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
                    path: "activate-account",
                    meta: {
                        role: "resident",
                    },

                    components: {
                        default: NotFound,
                        contents: ActivateAccountComponent,
                    },
                },
                {
                    path: "view-billing",
                    meta: {
                        role: "resident",
                    },

                    components: {
                        default: NotFound,
                        contents: BillingComponent,
                    },
                },
                {
                    path: "post/:post",
                    meta: {
                        role: "resident",
                    },
                    beforeEnter: checkRole,
                    components: {
                        default: NotFound,
                        contents: SpecificPostComponent,
                    },
                },
                {
                    path: "election",
                    meta: {
                        role: "resident",
                    },
                    beforeEnter: checkRole,
                    components: {
                        default: NotFound,
                        contents: VoteElectionComponent,
                    },
                },
            ],
        },
        {
            path: "/security-officer",
            component: SecurityHome,
            meta: {
                role: "security_officer",
            },
            beforeEnter: checkRole,
            name: "securityhome",

            children: [
                {
                    path: "/security-officer/timeline",

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
                    path: "setting",
                    meta: {
                        role: "security_officer",
                    },
                    beforeEnter: checkRole,
                    components: {
                        default: NotFound,
                        contents: SettingComponent,
                    },
                },
                {
                    path: "view-announcement",
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
                    path: "activate-account",
                    meta: {
                        role: "security_officer",
                    },

                    components: {
                        default: NotFound,
                        contents: ActivateAccountComponent,
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
                        contents: MarketplaceComponent,
                    },
                },
                {
                    path: "post/:post",
                    meta: {
                        role: "security_officer",
                    },
                    beforeEnter: checkRole,
                    components: {
                        default: NotFound,
                        contents: SpecificPostComponent,
                    },
                },
            ],
        },
    ],
});

export default router;
