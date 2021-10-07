import Home from "./components/HomeComponent.vue";
import Login from "./components/LoginComponent.vue";
import VueRouter from "vue-router";
const routes = [
    {
        path: "/",
        component: Home,
        name: "home"
    },
    {
        path: "/login",
        component: Login,
        name: "login"
    }
];

const router = new VueRouter({
    routes,
    mode: "history"
});

export default router;
