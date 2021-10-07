require("./bootstrap");
import Vue from "vue";
import router from "./routes";
import VueRouter from "vue-router";
import Index from "./Index";

window.Vue = require("vue").default;

// Vue.component(
//     "login-component",
//     require("./components/LoginComponent.vue").default
// );
// Vue.component(
//     "dashboard-component",
//     require("./components/DashboardComponent.vue").default
// );

Vue.use(VueRouter);

const app = new Vue({
    el: "#app",
    router,
    components: {
        index: Index
    }
});
