import Dashboard from "./components/DashboardComponent.vue";
import Login from "./components/LoginComponent.vue";
import { createRouter, createWebHistory } from "vue-router";
const routes = [
    {
        path: "/",
        component: Login,
        name: "login"
    },
    {
        path: "/dashboard",
        component: Dashboard,
        name: "dashboard"
    }
];

// const router = new VueRouter({
//     routes,
//     mode: "history"
// });

export default createRouter({
    history: createWebHistory(),
    routes
});
