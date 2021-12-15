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
                            <label for="first_name">First Name</label
                            ><label
                                style="color: red"
                                for="first_name"
                                v-if="!form.first_name"
                                >*</label
                            >
                            <InputText
                                id="firstname"
                                type="text"
                                class="inputfield w-full"
                                v-model="form.first_name"
                            />
                            <label
                                style="color: red"
                                for="first_name"
                                v-if="error_first_name"
                                >{{ error_first_name }}</label
                            >
                        </div>
                        <div class="field col-12 md:col-6">
                            <label for="last_name">Last name</label>
                            <label
                                style="color: red"
                                for="last_name"
                                v-if="!form.last_name"
                                >*</label
                            >
                            <InputText
                                id="last_name"
                                type="text"
                                class="inputfield w-full"
                                v-model="form.last_name"
                            />
                            <label
                                style="color: red"
                                for="first_name"
                                v-if="error_last_name"
                                >{{ error_last_name }}</label
                            >
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
                                    <label
                                        style="color: red"
                                        for="last_name"
                                        v-if="!form.gender"
                                        >*</label
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
                                    <label
                                        style="color: red"
                                        for="last_name"
                                        v-if="!form.gender"
                                        >*</label
                                    >
                                </div>
                            </div>
                            <div
                                class="
                                    formgroup-inline
                                    flex
                                    justify-content-around
                                "
                            >
                                <label
                                    style="color: red"
                                    for="first_name"
                                    v-if="error_gender"
                                    >{{ error_gender }}</label
                                >
                            </div>
                        </div>
                        <div class="field col-12 md:col-6 lg:col-6">
                            <label for="selected_block">Block</label>
                            <label
                                style="color: red"
                                for="selected_block"
                                v-if="!form.selected_block"
                                >*</label
                            >
                            <Dropdown
                                class="inputfield w-full"
                                v-model="form.selected_block"
                                :options="block"
                                optionLabel="block"
                            />
                            <label
                                style="color: red"
                                for="first_name"
                                v-if="error_selected_block"
                                >{{ error_selected_block }}</label
                            >
                        </div>
                        <div class="field col-12 md:col-6 lg:col-6">
                            <label for="selected_lot">Lot</label>
                            <label
                                style="color: red"
                                for="selected_lot"
                                v-if="!form.selected_lot"
                                >*</label
                            >
                            <Dropdown
                                class="inputfield w-full"
                                v-model="form.selected_lot"
                                :options="lot"
                                optionLabel="lot"
                            />
                            <label
                                style="color: red"
                                for="first_name"
                                v-if="error_selected_lot"
                                >{{ error_selected_lot }}</label
                            >
                        </div>
                        <div class="field col-12 md:col-6 lg:col-6">
                            <label for="form.age">Age</label
                            ><label
                                style="color: red"
                                for="form.age"
                                v-if="!form.age"
                                >*</label
                            >
                            <InputText
                                id="age"
                                type="number"
                                min="0"
                                step="1"
                                onfocus="this.previousValue = this.value"
                                onkeydown="this.previousValue = this.value"
                                oninput="validity.valid || (value = this.previousValue)"
                                class="inputfield w-full"
                                v-model="form.age"
                            />
                            <label
                                style="color: red"
                                for="form.age"
                                v-if="error_age"
                                >{{ error_age }}</label
                            >
                        </div>
                        <div class="field col-12 md:col-6 lg:col-6">
                            <label for="form.contact_num">Contact Number</label
                            ><label
                                style="color: red"
                                for="form.contact_num"
                                v-if="!form.contact_num"
                                >*</label
                            >
                            <InputText
                                id="contact_num"
                                type="text"
                                onkeyup="if(this.value<0){this.value= this.value * -1}"
                                class="inputfield w-full"
                                v-model="form.contact_num"
                            />
                            <label
                                style="color: red"
                                for="form.contact_num"
                                v-if="error_contact_num"
                                >{{ error_contact_num }}</label
                            >
                        </div>
                        <div class="field col-12 md:col-12">
                            <label for="form.email">Email</label
                            ><label
                                style="color: red"
                                for="form.form.email"
                                v-if="!form.email"
                                >*</label
                            >
                            <InputText
                                class="inputfield w-full"
                                type="text"
                                name="email"
                                v-model="form.email"
                            />
                            <label
                                style="color: red"
                                for="form.email"
                                v-if="error_email"
                                >{{ error_email }}</label
                            >
                        </div>
                        <div class="field col-12 md:col-12">
                            <label for="form.password">Password</label
                            ><label
                                style="color: red"
                                for="form.password"
                                v-if="!form.password"
                                >*</label
                            >
                            <InputText
                                class="inputfield w-full"
                                type="password"
                                name="password"
                                v-model="form.password"
                            />
                            <label
                                style="color: red"
                                for="form.password"
                                v-if="error_password"
                                >{{ error_password }}</label
                            >
                        </div>
                        <div class="field col-12 md:col-12">
                            <label for="confirm_password"
                                >Confirm Password</label
                            >
                            <label
                                style="color: red"
                                for="confirm_password"
                                v-if="!form.confirm_password"
                                >*</label
                            >
                            <InputText
                                class="inputfield w-full"
                                type="password"
                                name="confirmpassword"
                                v-model="form.confirm_password"
                            />
                            <label
                                style="color: red"
                                for="confirm_password"
                                v-if="error_confirm_password"
                                >{{ error_confirm_password }}</label
                            >
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
            },
            block: null,
            lot: null,

            error_first_name: "",
            error_last_name: "",
            error_gender: "",
            error_selected_block: "",
            error_selected_lot: "",
            error_email: "",
            error_password: "",
            error_confirm_password: "",
            error_age: "",
            error_contact_num: "",
        };
    },
    components: {
        RadioButton,
        InputText,
        Dropdown,
    },
    computed: {},
    methods: {
        async onRegisterClick() {
            try {
                await axios
                    .post("/api/register", this.form)
                    .then(() => {
                        console.log("Successfully Registered");
                        this.$router.push({ name: "login" });
                    })
                    .catch((err) => {
                        this.resetFields();
                        this.validate(err);
                        console.log(error.response.data);
                    });
            } catch (error) {
                console.log(error.response.data);
                this.validate(error);
            }
        },
        resetFields() {
            this.error_first_name = "";
            this.error_last_name = "";
            this.error_gender = "";
            this.error_selected_block = "";
            this.error_selected_lot = "";
            this.error_email = "";
            this.error_password = "";
            this.error_confirm_password = "";
            this.error_age = "";
            this.error_contact_num = "";
        },
        validate(error) {
            if (error.response.data.errors.first_name)
                this.error_first_name =
                    error.response.data.errors.first_name[0];
            if (error.response.data.errors.last_name)
                this.error_last_name = error.response.data.errors.last_name[0];
            if (error.response.data.errors.gender)
                this.error_gender = error.response.data.errors.gender[0];
            if (error.response.data.errors.selected_block)
                this.error_selected_block =
                    error.response.data.errors.selected_block[0];
            if (error.response.data.errors.selected_lot)
                this.error_selected_lot =
                    error.response.data.errors.selected_lot[0];
            if (error.response.data.errors.email)
                this.error_email = error.response.data.errors.email[0];
            if (error.response.data.errors.password)
                this.error_password = error.response.data.errors.password[0];
            if (error.response.data.errors.confirm_password)
                this.error_confirm_password =
                    error.response.data.errors.confirm_password[0];
            if (error.response.data.errors.age)
                this.error_age = error.response.data.errors.age[0];
            if (error.response.data.errors.contact_num)
                this.error_contact_num =
                    error.response.data.errors.contact_num[0];
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
