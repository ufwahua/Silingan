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
                            src="https://i.ibb.co/V3B8NBM/silingan-icon.png"
                    /></router-link>
                </div>
                <form
                    class="w-full md:w-10 mx-auto"
                    @submit.prevent="sendPasswordLink"
                >
                    <label class="block text-900 text-xl font-medium mb-2"
                        >Email</label
                    >
                    <InputText
                        id="email1"
                        :class="{ 'p-invalid': error_email }"
                        v-model="email"
                        type="text"
                        class="w-full mb-3"
                        placeholder="Email"
                        style="padding: 1rem"
                    />
                    <label style="color: green" v-if="message">{{
                        message
                    }}</label>
                    <label style="color: red" v-if="error_email">{{
                        error_email
                    }}</label>
                    <Button
                        label="Send Password Link"
                        type="submit"
                        class="w-full p-3 text-xl"
                    ></Button>
                </form>

                <div class="col-12 mb-2 lg:col-12 lg:mb-0">
                    <p class="custom-text">
                        Back to
                        <router-link to="login" :key="$route.fullPath">
                            <a class="custom-link" href="#"
                                >Login
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
import { computed } from "vue";
import { useStore } from "vuex";
import axios from "axios";

export default {
    setup() {
        const store = useStore();
        return {
            user: computed(() => store.state.user),
        };
    },
    data() {
        return {
            loading: false,
            email: null,
            message: null,
            error_email: null,
        };
    },
    methods: {
        async sendPasswordLink() {
            this.loading = true;
            await axios({
                method: "post",
                url: "/api/forgot-password",
                data: {
                    email: this.email,
                },
            })
                .then((res) => {
                    this.message = res.data.status;
                    this.loading = false;
                })
                .catch((err) => {
                    this.error_email = "";
                    console.log(err.response);
                    if (err.response.data.errors.email) {
                        this.error_email = err.response.data.errors.email[0];
                    }
                    this.loading = false;
                });
        },
    },
};
</script>

<style scoped>
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
