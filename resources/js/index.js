import Login from "./login/LoginComponent.vue";
import Register from "./login/RegisterComponent.vue";

import Home from "./home/HomeComponent.vue";

import HomeComponent from "./user/dashboard/HomeComponent.vue";
import DashboardComponent from "./user/contents/DashboardComponent.vue";
import MakeComponent from "./user/contents/MakeComponent.vue";
import TypeComponent from "./user/contents/TypeComponent.vue";
import VendorComponent from "./user/contents/VendorComponent.vue";

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
            next({ name: "index" });
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
            component: Home,
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
