<template>
    <div class="grid p-fluid">
        <div class="col-12 md:col-12">
            <div class="login100-form">
                <div class="col-12 mb-2 lg:col-12 lg:mb-3 text-center">
                    <router-link to="/" :key="$route.fullPath">
                        <img
                            class="Silingan-logo"
                            alt="Silingan-Logo"
                            src="https://i.ibb.co/V3B8NBM/silingan-icon.png"
                    /></router-link>
                </div>

                <div class="col-12 mb-2 lg:col-12 lg:mb-0">
                    <span class="p-input-icon-left">
                        <i class="pi pi-user" />
                        <InputText
                            type="text"
                            placeholder="Email"
                            name="email"
                            v-model="form.email"
                        />
                    </span>
                </div>

                <div class="col-12 mb-2 lg:col-12 lg:mb-0">
                    <span class="p-input-icon-left">
                        <i class="pi pi-lock" />
                        <InputText
                            type="password"
                            placeholder="Password"
                            name="password"
                            v-model="form.password"
                        />
                    </span>
                </div>

                <div class="grid formgrid">
                    <div class="col-6">
                        <div class="field-checkbox mb-0 ch-remember">
                            <Checkbox
                                id="remember"
                                name="remember"
                                v-model="form.remember"
                            />
                            <label class="mb-0 ml-1" for="remember"
                                >Remember me</label
                            >
                        </div>
                    </div>
                    <div class="col-6">
                        <a class="custom-link link-forgot" href="#"
                            >Forgot Password?
                        </a>
                    </div>
                </div>
                <br />

                <div class="col-12 mb-2 lg:col-12 lg:mb-0">
                    <Button
                        label="Login"
                        class="p-button-info mr-2 mb-2 login-btn"
                        @click="onLoginSubmit"
                        type="submit"
                    />
                </div>

                <div class="col-12 mb-2 lg:col-12 lg:mb-0">
                    <p class="custom-text">
                        Don't have an account?
                        <router-link to="register" :key="$route.fullPath">
                            <a class="custom-link" href="#"
                                >Register
                            </a></router-link
                        >
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Checkbox from "primevue/checkbox";
import Button from "primevue/button";

import axios from "axios";

export default {
    components: {
        Checkbox,
        Button,
    },
    data() {
        return {
            form: {
                email: null,
                password: null,
                remember: false,
            },

            token: null,
            error: null,
        };
    },
    methods: {
        onLoginSubmit() {
            axios
                .post("/api/login", this.form)
                .then((response) => {
                    axios
                        .get("/api/user/logged")
                        .then((response) => {
                            if (response.data.role == "resident") {
                                this.$router.push({
                                    name: "userDashboard",
                                    params: {
                                        id: response.data.id,
                                        first_name: response.data.first_name,
                                        last_name: response.data.last_name,
                                    },
                                });
                            } else {
                                this.$router.push({
                                    name: "adminDashboard",
                                    params: {
                                        id: response.data.id,
                                        first_name: response.data.first_name,
                                        last_name: response.data.last_name,
                                    },
                                });
                            }
                        })
                        .catch((err) => {
                            console.log(err);
                        });
                })
                .catch((err) => {
                    this.error = err.response.data.error;
                });
        },
    },
    mounted() {},
};
</script>

<style scoped>
@import "./App.scss";
@import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap");

/* div {
    display: block;
    margin: auto;
} */

.login100-form {
    height: 475px;
    width: 475px;
    left: 0px;
    top: 0px;
    margin-top: 50px;
    margin-right: auto;
    margin-left: auto;
    margin-bottom: 50px;
    padding: 30px;
    box-sizing: border-box;
    background-color: rgb(255, 255, 255);
    border-radius: 5px;
    box-shadow: rgb(123 158 176 / 10%) 0px 2px 10px 4px;
}

.Silingan-logo {
    height: 50px;
    width: 179px;
    margin-bottom: 30px;
    text-align: center;
}

.custom-text {
    white-space: pre-wrap;
    overflow: visible;
    padding-bottom: 0px;
    font-family: Poppins;
    font-size: 14px;
    color: rgb(59, 59, 59);
    margin-top: 30px;

    text-align: center;
    line-height: 1.4;
    border-radius: 0px;
}

.custom-link {
    font-family: Poppins;
    font-size: 14px;
    color: rgb(0, 203, 255);
    text-align: center;
    line-height: 1.4;
    border-radius: 0px;
    cursor: pointer;
}

.login-btn {
    height: 40px;
    width: 345px;
    left: 0px;
    top: 0px;
    padding: 0px;
    cursor: pointer;
    background: none rgb(27, 120, 242);
    border: 1px none rgb(27, 120, 242);
    text-align: center;
    font-family: Poppins;
    font-size: 14px;
    font-weight: 500;
    color: rgb(255, 255, 255);
    line-height: 1;
    border-radius: 8px;
    transition: background 250ms ease 0s;
    box-shadow: none;
}

/* .shape-divider {
    margin-top: 15px;
    margin-bottom: 15px;
    box-sizing: border-box;
    height: 2px;
    width: 410px;
    left: 0px;
    top: 0px;
    background-color: rgb(222, 222, 222);
    border-radius: 0px;
} */

.input100 {
    width: 410px;
}

.ch-remember {
    padding-left: 10px;
}

.link-forgot {
    padding-left: 70px;
}
</style>
