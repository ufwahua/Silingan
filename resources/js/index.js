import Login from "./login/LoginComponent.vue";
import Register from "./login/RegisterComponent.vue";
import IndexComponent from "./home/IndexComponent.vue";
import HomeComponent from "./admin/dashboard/HomeComponent.vue";
import DashboardComponent from "./admin/dashboard/DashboardComponent.vue";
import Block_Lot from "./admin/dashboard/Block_LotComponent.vue";
import RegisteredUsersComponent from "./admin/dashboard/RegisterUsersComponent.vue";
import UserHome from "./user/dashboard/HomeComponent.vue";

import DeviceStatusComponent from "./user/contents/DeviceStatusComponent.vue";
import DeviceConditionComponent from "./user/contents/DeviceConditionComponent.vue";
import MakeComponent from "./user/contents/MakeComponent.vue";
import TypeComponent from "./user/contents/TypeComponent.vue";
import VendorComponent from "./user/contents/VendorComponent.vue";

import NotFound from "./components/NotFoundComponent.vue";

import { createRouter, createWebHistory } from "vue-router";
import axios from "axios";

// const toEnter = async (to, from, next) => {
//     try {
//         const { data } = await axios({
//             method: "get",
//             url: "/api/user/logged",
//         });
//         if (data.id != null) {
//             next({ name: "adminDashboard" });
//         } else {
//             to({ name: "login" });
//         }
//     } catch (e) {
//         console.log(e);
//     }
// };
export default createRouter({
    history: createWebHistory(),
    linkActiveClass: "active",
    routes: [
        { path: "/:pathMatch(.*)*", component: NotFound },
        {
            path: "/",
            component: IndexComponent,
            name: "index",
            meta: {
                reload: true,
            },
        },
        {
            path: "/login",
            component: Login,

            name: "login",
        },
        {
            path: "/register",
            component: Register,
            name: "register",
        },
        {
            path: "/admin",
            component: HomeComponent,
            name: "adminHome",
            children: [
                {
                    path: "/admin/dashboard",
                    name: "adminDashboard",
                    components: {
                        default: NotFound,
                        contents: DashboardComponent,
                    },
                },
                {
                    path: "/block-lot",
                    components: {
                        default: NotFound,
                        contents: Block_Lot,
                    },
                },
                {
                    path: "/registered-users",
                    components: {
                        default: NotFound,
                        contents: RegisteredUsersComponent,
                    },
                },

                {
                    path: "/devicestatus",
                    components: {
                        default: NotFound,
                        contents: DeviceStatusComponent,
                    },
                },
                {
                    path: "/devicecondition",
                    components: {
                        default: NotFound,
                        contents: DeviceConditionComponent,
                    },
                },
                {
                    path: "/make",
                    components: {
                        default: NotFound,
                        contents: MakeComponent,
                    },
                },
                {
                    path: "/type",
                    components: {
                        default: NotFound,
                        contents: TypeComponent,
                    },
                },
                {
                    path: "/vendor",
                    components: {
                        default: NotFound,
                        contents: VendorComponent,
                    },
                },
            ],
        },
        // {
        //     path: "/user",
        //     component: UserHome,
        //     name: "userhome",
        //     beforeEnter: (to, from, next) => {
        //         axios
        //             .get("/api/authenticated")
        //             .then(() => {
        //                 next();
        //             })
        //             .catch(() => {
        //                 return next({ path: "login" });
        //             });
        //     },
        //     children: [
        //         {
        //             path: "/dashboard",
        //             name: "userDashboard",
        //             components: {
        //                 default: NotFound,
        //                 contents: DashboardComponent,
        //             },
        //         },
        //         {
        //             path: "/block-lot",
        //             components: {
        //                 default: NotFound,
        //                 contents: Block_Lot,
        //             },
        //         },
        //         {
        //             path: "/registered-users",
        //             components: {
        //                 default: NotFound,
        //                 contents: RegisteredUsersComponent,
        //             },
        //         },

        //         {
        //             path: "/devicestatus",
        //             components: {
        //                 default: NotFound,
        //                 contents: DeviceStatusComponent,
        //             },
        //         },
        //         {
        //             path: "/devicecondition",
        //             components: {
        //                 default: NotFound,
        //                 contents: DeviceConditionComponent,
        //             },
        //         },
        //         {
        //             path: "/make",
        //             components: {
        //                 default: NotFound,
        //                 contents: MakeComponent,
        //             },
        //         },
        //         {
        //             path: "/type",
        //             components: {
        //                 default: NotFound,
        //                 contents: TypeComponent,
        //             },
        //         },
        //         {
        //             path: "/vendor",
        //             components: {
        //                 default: NotFound,
        //                 contents: VendorComponent,
        //             },
        //         },
        //     ],
        // },
    ],
});
