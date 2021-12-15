<template>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic">
                    <img
                        class="img-login"
                        src="/../../images/register-pic.jpg"
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

                    <div class="formgrid grid">
                        <div class="field col-12 md:col-6">
                            <div v-if="this.error.first_name">
                                <label class="p-error" for="first_name"
                                    >First name required</label
                                >
                                <InputText
                                    id="firstname"
                                    type="text"
                                    class="p-invalid inputfield w-full"
                                    v-model="form.first_name"
                                />
                            </div>
                            <div v-else>
                                <label for="first_name">First name</label>
                                <InputText
                                    id="firstname"
                                    type="text"
                                    class="inputfield w-full"
                                    v-model="form.first_name"
                                />
                            </div>
                        </div>
                        <div class="field col-12 md:col-6">
                            <div v-if="this.error.last_name">
                                <label class="p-error" for="last_name"
                                    >Last name required</label
                                >
                                <InputText
                                    id="last_name"
                                    type="text"
                                    class="p-invalid inputfield w-full"
                                    v-model="form.last_name"
                                />
                            </div>
                            <div v-else>
                                <label for="last_name">Last name</label>
                                <InputText
                                    id="last_name"
                                    type="text"
                                    class="inputfield w-full"
                                    v-model="form.last_name"
                                />
                            </div>
                        </div>
                        <div class="wrap-input100">
                            <div
                                class="
                                    formgroup-inline
                                    flex
                                    justify-content-around
                                "
                            >
                                <div>
                                    <RadioButton
                                        name="gender"
                                        value="male"
                                        v-model="form.gender"
                                    />
                                    <label class="mb-0 ml-1" for="gender"
                                        >Male</label
                                    >
                                </div>
                                <div class>
                                    <RadioButton
                                        name="gender"
                                        value="female"
                                        v-model="form.gender"
                                    />
                                    <label class="mb-0 ml-1" for="gender"
                                        >Female</label
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="field col-12 md:col-6 lg:col-6">
                            <label for="state">Block</label>
                            <Dropdown
                                class="inputfield w-full"
                                v-model="form.selected_block"
                                :options="block"
                                optionLabel="block"
                            >
                            </Dropdown>
                        </div>
                        <div class="field col-12 md:col-6 lg:col-6">
                            <label for="state">Lot</label>
                            <Dropdown
                                class="inputfield w-full"
                                v-model="form.selected_lot"
                                :options="lot"
                                optionLabel="lot"
                            >
                            </Dropdown>
                        </div>
                        <div class="field col-12 md:col-6 lg:col-6">
                            <label for="state">Age</label>
                            <InputText
                                id="age"
                                type="text"
                                class="inputfield w-full"
                                v-model="form.age"
                            />
                        </div>
                        <div class="field col-12 md:col-6 lg:col-6">
                            <label for="state">Contact Number</label>
                            <InputText
                                id="contact_num"
                                type="text"
                                class="inputfield w-full"
                                v-model="form.contact_num"
                            />
                        </div>
                        <div class="field col-12 md:col-12">
                            <label for="firstname1">Email</label>
                            <InputText
                                class="inputfield w-full"
                                type="text"
                                name="email"
                                v-model="form.email"
                            />
                        </div>
                        <div class="field col-12 md:col-12">
                            <label for="firstname1">Password</label>
                            <InputText
                                class="inputfield w-full"
                                type="password"
                                name="password"
                                v-model="form.password"
                            />
                        </div>
                        <div class="field col-12 md:col-12">
                            <label for="firstname1">Confirm Password</label>
                            <InputText
                                class="inputfield w-full"
                                type="password"
                                name="confirmpassword"
                                v-model="form.confirm_password"
                            />
                        </div>
                    </div>

                    <div class="container-login100-form-btn">
                        <button
                            @click.prevent="onRegisterClick"
                            type="submit"
                            class="login100-form-btn"
                        >
                            Register
                        </button>
                    </div>

                    <div class="text-center p-t-12">
                        <router-link to="/"
                            ><a class="txt2" href="#">
                                Login
                                <i
                                    class="fa fa-long-arrow-right m-l-5"
                                    aria-hidden="true"
                                ></i> </a
                        ></router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import RadioButton from "primevue/radiobutton";
import InputText from "primevue/inputtext";
import Dropdown from "primevue/dropdown";
import axios from "axios";

export default {
    data() {
        return {
            form: {
                first_name: "",
                last_name: "",
                gender: "",
                selected_block: "",
                selected_lot: "",
                email: "",
                password: "",
                confirm_password: "",
                age: "",
                contact_num: "",
                role: "residents",
                profile_picture: "",

            },
            block: null,
            lot: null,
            error: [],
        };
    },
    components: {
        RadioButton,
        InputText,
        Dropdown,
    },
    methods: {
        onRegisterClick() {
            try{
                await axios
                .post("/api/register", this.form)
                .then(() => {
                    console.log("Successfully Registered");
                    this.$router.push({ name: "login" });
                })
                .catch((err) => {
                    this.error = err.response.data.errors;
                });
            }

        },
    },
    mounted() {
        this.block = [
            { block: "Block 1" },
            { block: "Block 2" },
            { block: "Block 3" },
            { block: "Block 4" },
            { block: "Block 5" },
        ];
        this.lot = [
            { lot: "Lot 1" },
            { lot: "Lot 2" },
            { lot: "Lot 3" },
            { lot: "Lot 4" },
            { lot: "Lot 5" },
        ];
    },
};
</script>

<style></style>
