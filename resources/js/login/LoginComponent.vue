<template>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic">
                    <img
                        class="img-login"
                        src="/../../images/home-pic.jpg"
                        alt="IMG"
                    />
                </div>

                <div class="login100-form">
                    <div class="flex justify-content-center">
                        <span class="login100-form-title">
                            <img
                                class="img-login"
                                src="/../../images/silingan-icon.png"
                                alt="IMG"
                            />
                        </span>
                    </div>

                    <div class="wrap-input100">
                        <label
                            class="flex justify-content-center"
                            style="color: red"
                            for="name"
                            v-if="error"
                            >{{ this.error }}</label
                        >
                        <input
                            class="input100"
                            type="text"
                            name="email"
                            v-model="form.email"
                            placeholder="Email"
                        />
                    </div>

                    <div class="wrap-input100">
                        <input
                            class="input100"
                            type="password"
                            name="password"
                            v-model="form.password"
                            placeholder="Password"
                        />
                    </div>
                    <div class="p-field-checkbox flex justify-content-end">
                        <Checkbox
                            id="remember"
                            name="remember"
                            v-model="form.remember"
                        />
                        <label
                            style="color: black"
                            class="ml-1 mb-0"
                            for="remember"
                            >Remember Me</label
                        >
                    </div>
                    <div class="container-login100-form-btn">
                        <button
                            @click="onLoginSubmit"
                            type="submit"
                            class="login100-form-btn"
                        >
                            Login
                        </button>
                    </div>

                    <div class="text-center p-t-12">
                        <label style="color: black">Forgot</label>
                        <a class="txt2" href="#"> Username / Password? </a>
                    </div>

                    <div class="text-center p-t-136">
                        <span style="color: black">Don't have an account?</span>
                        <router-link to="register">
                            <span class="txt2" href="#">
                                Register
                                <i
                                    class="fa fa-long-arrow-right m-l-5"
                                    aria-hidden="true"
                                ></i> </span
                        ></router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Checkbox from "primevue/checkbox";
import axios from "axios";

export default {
    components: {
        Checkbox,
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
                    console.log("Successfully Login");
                    this.$router.push("/home/dashboard");
                })
                .catch((err) => {
                    this.error = err.response.data.error;
                });
        },
    },
    mounted() {},
};
</script>

<style></style>
