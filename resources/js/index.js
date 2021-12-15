import Login from "./login/LoginComponent.vue";
import Register from "./login/RegisterComponent.vue";

import HomeComponent from "./admin/dashboard/HomeComponent.vue";
import DashboardComponent from "./admin/dashboard/DashboardComponent.vue";
import Block_Lot from "./admin/dashboard/Block_LotComponent.vue";
import LotComponent from "./admin/dashboard/LotComponent.vue";
import MakeComponent from "./admin/dashboard/MakeComponent.vue";
import TypeComponent from "./admin/dashboard/TypeComponent.vue";
import VendorComponent from "./admin/dashboard/VendorComponent.vue";
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
                    path: "block",
                    components: {
                        default: NotFound,
                        contents: Block_Lot,
                    },
                },
                {
                    path: "lot",
                    components: {
                        default: NotFound,
                        contents: LotComponent,
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
