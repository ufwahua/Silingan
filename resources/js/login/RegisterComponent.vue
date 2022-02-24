<template>
    <div
        class="surface-0 flex align-items-center justify-content-center min-h-screen min-w-screen overflow-hidden"
    >
        <div class="card">
            <div
                class="grid justify-content-center p-2 lg:p-0"
                style="width: 60vw"
            >
                <div class="col-12 mb-2 lg:col-12 lg:mb-3 text-center">
                    <router-link to="/" :key="$route.fullPath">
                        <img
                            class="Silingan-logo"
                            alt="Silingan-Logo"
                            src="https://i.ibb.co/V3B8NBM/silingan-icon.png"
                    /></router-link>
                </div>

                <div class="col-12 title-form">
                    <Badge
                        :value="1"
                        severity="info"
                        class="mr-2 mb-2"
                        size="large"
                    ></Badge>
                    <label><h6>Your Basic Information</h6></label>
                </div>
                <form @submit.prevent="onRegisterClick" autocomplete="on">
                    <div class="p-fluid formgrid grid">
                        <div class="field col-12 md:col-6">
                            <label for="first_name">Firstname</label>
                            <label
                                style="color: red"
                                for="first_name"
                                v-if="!form.first_name"
                                >*</label
                            >
                            <InputText
                                id="firstname"
                                type="text"
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
                            <label for="last_name">Lastname</label>
                            <label
                                style="color: red"
                                for="last_name"
                                v-if="!form.last_name"
                                >*</label
                            >
                            <InputText
                                id="last_name"
                                type="text"
                                v-model="form.last_name"
                            />
                            <label
                                style="color: red"
                                for="first_name"
                                v-if="error_last_name"
                                >{{ error_last_name }}</label
                            >
                        </div>

                        <div class="field col-12 md:col-6">
                            <div class="field-radiobutton mb-0">
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
                                    for="gender"
                                    v-if="!form.gender"
                                    >*</label
                                >
                            </div>
                        </div>
                        <div class="field col-12 md:col-6">
                            <div class="field-radiobutton mb-0">
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
                                    for="gender"
                                    v-if="!form.gender"
                                    >*</label
                                >
                            </div>
                        </div>
                        <div
                            class="formgroup-inline flex justify-content-around"
                        >
                            <label
                                style="color: red"
                                for="first_name"
                                v-if="error_gender"
                                >{{ error_gender }}</label
                            >
                        </div>

                        <div class="field col-12 md:col-6">
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
                                v-model="form.age"
                            />
                            <label
                                style="color: red"
                                for="form.age"
                                v-if="error_age"
                                >{{ error_age }}</label
                            >
                        </div>

                        <div class="field col-12 md:col-6">
                            <label for="form.contact_num">Contact Number</label
                            ><label
                                style="color: red"
                                for="form.contact_num"
                                v-if="!form.contact_num"
                                >*</label
                            >
                            <InputText
                                id="contact_num"
                                type="number"
                                oninput="validity.valid||(value='');"
                                v-model="form.contact_num"
                            />
                            <label
                                style="color: red"
                                for="form.contact_num"
                                v-if="error_contact_num"
                                >{{ error_contact_num }}</label
                            >
                        </div>

                        <div class="field col-12 md:col-6">
                            <label for="selected_block">Block</label>
                            <label
                                style="color: red"
                                for="selected_block"
                                v-if="!form.selected_block"
                                >*</label
                            >
                            <Dropdown
                                v-model="form.selected_block"
                                :options="block"
                                optionLabel="block_number"
                                optionValue="block_number"
                                placeholder="Select Block"
                                @change="getBlockLot"
                            />
                            <label
                                style="color: red"
                                for="form.selected_block"
                                v-if="error_selected_block"
                                >{{ error_selected_block }}</label
                            >
                        </div>

                        <div class="field col-12 md:col-6">
                            <label for="selected_lot">Lot</label>
                            <label
                                style="color: red"
                                for="selected_lot"
                                v-if="!form.selected_lot"
                                >*</label
                            >
                            <Dropdown
                                v-model="form.selected_lot"
                                :options="filteredLots"
                                optionLabel="lot_number"
                                optionValue="lot_number"
                                placeholder="Select Lot"
                            />
                            <label
                                style="color: red"
                                for="form.selected_lot"
                                v-if="error_selected_lot"
                                >{{ error_selected_lot }}</label
                            >
                        </div>

                        <br />

                        <div class="col-12 title-form">
                            <Badge
                                :value="2"
                                severity="info"
                                class="mr-2 mb-2"
                                size="large"
                            ></Badge>
                            <label><h6>Your Security Information</h6></label>
                        </div>

                        <div class="field col-12 md:col-4">
                            <label for="form.email">Email</label
                            ><label
                                style="color: red"
                                for="form.form.email"
                                v-if="!form.email"
                                >*</label
                            >
                            <InputText
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
                        <div class="field col-12 md:col-4">
                            <label for="form.password">Password</label
                            ><label
                                style="color: red"
                                for="form.password"
                                v-if="!form.password"
                                >*</label
                            >
                            <Password
                                name="password"
                                v-model="form.password"
                                autocomplete="off"
                                toggleMask
                            ></Password>
                            <label
                                style="color: red"
                                for="form.password"
                                v-if="error_password"
                                >{{ error_password }}</label
                            >
                        </div>
                        <div class="field col-12 md:col-4">
                            <label for="confirm_password"
                                >Confirm Password</label
                            >
                            <label
                                style="color: red"
                                for="confirm_password"
                                v-if="!form.confirm_password"
                                >*</label
                            >
                            <Password
                                name="confirmpassword"
                                autocomplete="off"
                                v-model="form.confirm_password"
                                toggleMask
                            ></Password>
                            <label
                                style="color: red"
                                for="confirm_password"
                                v-if="error_confirm_password"
                                >{{ error_confirm_password }}</label
                            >
                        </div>
                        <div class="col-12 mb-2 lg:col-12 lg:mb-0">
                            <Button type="submit" label="Register" />
                        </div>
                        <div class="col-12 mb-2 lg:col-12 lg:mb-0">
                            <p class="custom-text">
                                Already have an account?
                                <router-link to="login" :key="$route.fullPath">
                                    <a class="custom-link" href="#"
                                        >Login
                                    </a></router-link
                                >
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
import axios from "axios";
import { computed } from "vue";
import { useStore } from "vuex";
export default {
    setup() {
        const store = useStore();
        return {
            block: computed(() => store.state.block.block),
            lot: computed(() => store.state.lot.lot),
            filteredLots: computed(() => store.state.lot.filteredLots),
        };
    },
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
                role: "resident",
            },

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

    computed: {},
    methods: {
        async onRegisterClick() {
            await axios({
                method: "post",
                url: "api/user",
                data: {
                    first_name: this.form.first_name,
                    last_name: this.form.last_name,
                    gender: this.form.gender,
                    block_number: this.form.selected_block,
                    lot_number: this.form.selected_lot,
                    age: this.form.age,
                    contact_num: this.form.contact_num,
                    email: this.form.email,
                    password: this.form.password,
                    confirm_password: this.form.confirm_password,
                    role: this.form.role,
                },
            })
                .then(() => {
                    console.log("Successfully Registered");
                    this.$router.push({ name: "login" });
                })
                .catch((err) => {
                    this.resetErrors();
                    this.validate(err);
                    console.log(err.response.data);
                });
        },
        resetFields() {
            this.form = {
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
                role: "resident",
            };
        },
        resetErrors() {
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

        async getBlockLot() {
            this.$store.dispatch("lot/getBlockLots", this.form.selected_block);
        },
    },
    created() {
        this.$store.dispatch("block/getAll");
        this.$store.dispatch("lot/getAll");
    },
};
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap");

.login100-form {
    height: auto;
    width: 720px;
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

.input100 {
    width: 410px;
}

.ch-remember {
    padding-left: 10px;
}

.link-forgot {
    padding-left: 70px;
}

.title-form {
    margin-top: 20px;
}
</style>
