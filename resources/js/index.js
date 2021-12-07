import Login from "./login/LoginComponent.vue";
import Register from "./login/RegisterComponent.vue";

import HomeComponent from "./admin/dashboard/HomeComponent.vue";
import DashboardComponent from "./admin/contents/DashboardComponent.vue";
import DeviceStatusComponent from "./admin/contents/DeviceStatusComponent.vue";
import DeviceConditionComponent from "./admin/contents/DeviceConditionComponent.vue";
import MakeComponent from "./admin/contents/MakeComponent.vue";
import TypeComponent from "./admin/contents/TypeComponent.vue";
import VendorComponent from "./admin/contents/VendorComponent.vue";
import NotFound from "./components/NotFoundComponent.vue";

import { createRouter, createWebHistory } from "vue-router";
import axios from "axios";

const toHome = async (to, from, next) => {
    try {
        const { data } = await axios({
            method: "get",
            url: "/api/verify",
        });
        if (data.user != null && data.id != null) {
            next({ name: "home" });
        } else {
            next();
        }
    } catch (e) {
        console.log(e);
    }
};

export default createRouter({
    history: createWebHistory(),
    linkActiveClass: "active",
    routes: [
        { path: "/:pathMatch(.*)*", component: NotFound },
        {
            path: "/",
            component: Login,
            beforeEnter: toHome,
            name: "login",
        },
        {
            path: "/register",
            component: Register,
            name: "register",
        },
        {
            path: "/home",
            component: HomeComponent,
            name: "home",
            beforeEnter: (to, from, next) => {
                axios
                    .get("/api/authenticated")
                    .then(() => {
                        next();
                    })
                    .catch(() => {
                        return next({ name: "login" });
                    });
            },
            children: [
                {
                    path: "dashboard",
                    components: {
                        default: NotFound,
                        contents: DashboardComponent,
                    },
                },
                {
                    path: "devicestatus",
                    components: {
                        default: NotFound,
                        contents: DeviceStatusComponent,
                    },
                },
                {
                    path: "devicecondition",
                    components: {
                        default: NotFound,
                        contents: DeviceConditionComponent,
                    },
                },
                {
                    path: "make",
                    components: {
                        default: NotFound,
                        contents: MakeComponent,
                    },
                },
                {
                    path: "type",
                    components: {
                        default: NotFound,
                        contents: TypeComponent,
                    },
                },
                {
                    path: "vendor",
                    components: {
                        default: NotFound,
                        contents: VendorComponent,
                    },
                },
            ],
        },
    ],
});
