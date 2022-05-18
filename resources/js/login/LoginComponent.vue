<template>
    <div
        class="surface-0 flex align-items-center justify-content-center min-h-screen min-w-screen overflow-hidden"
    >
        <div class="card">
            <div
                class="grid justify-content-center p-2 lg:p-0"
                style="min-width: 80%"
            >
                <div class="col-12 mt-5 xl:mt-0 text-center">
                    <router-link to="/" :key="$route.fullPath">
                        <img
                            class="Silingan-logo"
                            alt="Silingan-Logo"
                            src="http://127.0.0.1:8000/storage/images/silingan-icon.png"
                        />
                        <!-- <img
                            class="Silingan-logo"
                            alt="Silingan-Logo"
                            src="https://i.ibb.co/V3B8NBM/silingan-icon.png"
                        /> -->
                    </router-link>
                </div>
                <div class="w-full md:w-10 mx-auto" autocomplete="on">
                    <label
                        for="email1"
                        class="block text-900 text-xl font-medium mb-2"
                        >Email</label
                    >
                    <InputText
                        id="email1"
                        :class="{ 'p-invalid': error }"
                        v-model="email"
                        type="text"
                        class="w-full mb-3"
                        style="padding: 1rem"
                        @keypress.enter="onLoginSubmit"
                    />

                    <label class="block text-900 font-medium text-xl mb-2"
                        >Password</label
                    >
                    <Password
                        :class="{ 'p-invalid': error }"
                        v-model="password"
                        :toggleMask="true"
                        :feedback="false"
                        class="w-full mb-3"
                        inputClass="w-full"
                        inputStyle="padding:1rem"
                        @keypress.enter="onLoginSubmit"
                    >
                    </Password>
                    <label style="color: red" v-if="error">{{
                        this.error
                    }}</label>
                    <div
                        class="flex align-items-center justify-content-between mb-5"
                    >
                        <div class="flex align-items-center">
                            <Checkbox
                                id="rememberme1"
                                v-model="remember"
                                :binary="true"
                                class="mr-2"
                            ></Checkbox>
                            <label>Remember me</label>
                        </div>

                        <router-link
                            to="forgot-password"
                            :key="$route.fullPath"
                        >
                            <a
                                class="font-medium no-underline ml-2 text-right cursor-pointer"
                                style="color: var(--primary-color)"
                                href="#"
                                >Forgot password?
                            </a></router-link
                        >
                    </div>
                    <Button
                        label="Sign In"
                        type="submit"
                        class="w-full p-3 text-xl"
                        @click="onLoginSubmit"
                    ></Button>
                </div>

                <div class="col-12 mb-2 lg:col-12 lg:mb-0">
                    <p class="custom-text">
                        Don't have an account?
                        <router-link to="register" :key="$route.fullPath">
                            <a
                                class="font-medium no-underline ml-2 text-right cursor-pointer"
                                style="color: var(--primary-color)"
                                href="#"
                                >Register
                            </a></router-link
                        >
                    </p>
                </div>
            </div>
        </div>
        <Dialog
            v-model:visible="loading"
            :style="{ width: '450px' }"
            :modal="true"
            :closable="false"
            :closeOnEscape="true"
        >
            <div class="grid">
                <div class="col-12 text-center">
                    <ProgressSpinner
                        class="block mb-4"
                        style="width: 100px; height: 100px"
                        strokeWidth="4"
                        fill="#EEEEEE"
                        animationDuration="1s"
                    />
                </div>
            </div>
        </Dialog>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            loading: false,

            email: null,
            password: null,
            remember: false,

            token: null,
            error: null,
        };
    },
    methods: {
        async onLoginSubmit() {
            this.loading = true;
            if (this.password && this.email) {
                await axios({
                    method: "post",
                    url: "/api/login",
                    data: {
                        email: this.email,
                        password: this.password,
                        remember: this.remember,
                    },
                })
                    .then((response) => {
                        this.error = "";
                        this.$store.commit("getUserLogged", response.data);
                        if (response.data.status == "inactive") {
                            this.$router.push(
                                "/" + response.data.role + "/activate-account"
                            );
                        } else if (response.data.role === "resident") {
                            this.loading = false;
                            this.$router.push("/resident/timeline");
                        } else if (response.data.role === "security officer") {
                            this.loading = false;
                            this.$router.push("/security-officer/timeline");
                        } else {
                            this.loading = false;
                            this.$router.push("/admin/timeline");
                        }
                    })
                    .catch((err) => {
                        this.error = "";
                        console.log(err.response);
                        if (err.response.data.errors) {
                            this.error = err.response.data.errors;
                        }
                        this.loading = false;
                    });
            } else {
                this.error = "";
                if (!this.email && !this.password) {
                    this.error = "please enter email and password";
                } else if (!this.email && this.password) {
                    this.error = "please enter email";
                } else {
                    this.error = "please enter password";
                }
                this.loading = false;
            }
        },
    },
};
</script>

<style scoped>
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
