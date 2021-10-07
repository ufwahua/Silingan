require("./bootstrap");
import Vue from "vue";
import router from "./routes";
import VueRouter from "vue-router";

window.Vue = require("vue").default;

Vue.component(
    "example-component",
    require("./components/HomeComponent.vue").default
);

Vue.component(
    "login-component",
    require("./components/LoginComponent.vue").default
);

Vue.use(VueRouter);

const app = new Vue({
    el: "#app",
    router
});
