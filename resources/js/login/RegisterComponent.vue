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
                            src="http://127.0.0.1:8000/storage/images/silingan-icon.png"
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
                            <InputText
                                :class="{ 'p-invalid': error_first_name }"
                                type="text"
                                v-model="first_name"
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
                            <InputText
                                :class="{ 'p-invalid': error_last_name }"
                                type="text"
                                v-model="last_name"
                            />
                            <label
                                style="color: red"
                                for="last_name"
                                v-if="error_last_name"
                                >{{ error_last_name }}</label
                            >
                        </div>

                        <div class="field col-12 md:col-6">
                            <div class="field-radiobutton mb-0">
                                <RadioButton
                                    :class="{ 'p-invalid': error_gender }"
                                    name="gender"
                                    value="male"
                                    v-model="gender"
                                />
                                <label class="mb-0 ml-1" for="gender"
                                    >Male</label
                                >
                                <label
                                    style="color: red"
                                    for="gender"
                                    v-if="!gender"
                                    >*</label
                                >
                            </div>
                        </div>
                        <div class="field col-12 md:col-6">
                            <div class="field-radiobutton mb-0">
                                <RadioButton
                                    :class="{ 'p-invalid': error_gender }"
                                    name="gender"
                                    value="female"
                                    v-model="gender"
                                />
                                <label class="mb-0 ml-1" for="gender"
                                    >Female</label
                                >
                                <label
                                    style="color: red"
                                    for="gender"
                                    v-if="!gender"
                                    >*</label
                                >
                            </div>
                        </div>
                        <div
                            class="formgroup-inline flex justify-content-around"
                        >
                            <label style="color: red" v-if="error_gender">{{
                                error_gender
                            }}</label>
                        </div>

                        <div class="field col-12 md:col-6">
                            <label for="age">Age</label
                            ><label style="color: red" for="age" v-if="!age"
                                >*</label
                            >
                            <InputText
                                id="age"
                                type="number"
                                :class="{ 'p-invalid': error_age }"
                                min="0"
                                step="1"
                                onfocus="this.previousValue = this.value"
                                onkeydown="this.previousValue = this.value"
                                oninput="validity.valid || (value = this.previousValue)"
                                v-model="age"
                            />
                            <label
                                style="color: red"
                                for="age"
                                v-if="error_age"
                                >{{ error_age }}</label
                            >
                        </div>

                        <div class="field col-12 md:col-6">
                            <label for="contact_num">Contact Number</label>
                            <InputText
                                id="contact_num"
                                :class="{ 'p-invalid': error_contact_num }"
                                type="number"
                                oninput="validity.valid||(value='');"
                                v-model="contact_num"
                            />
                            <label
                                style="color: red"
                                for="contact_num"
                                v-if="error_contact_num"
                                >{{ error_contact_num }}</label
                            >
                        </div>

                        <div class="field col-12 md:col-6">
                            <label for="selected_block">Block</label>

                            <Dropdown
                                v-model="selected_block"
                                :class="{ 'p-invalid': error_selected_block }"
                                :options="blocks"
                                optionLabel="number"
                                optionValue="id"
                                placeholder="Select Block"
                                @change="getBlockLot"
                            />
                            <label
                                style="color: red"
                                for="selected_block"
                                v-if="error_selected_block"
                                >{{ error_selected_block }}</label
                            >
                        </div>

                        <div class="field col-12 md:col-6">
                            <label for="selected_lot">Lot</label>

                            <Dropdown
                                v-model="block_lot_id"
                                :class="{ 'p-invalid': error_selected_lot }"
                                :options="filteredLots"
                                optionLabel="number"
                                optionValue="id"
                                placeholder="Select Lot"
                            />
                            <label
                                style="color: red"
                                for="selected_lot"
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
                            <label for="email">Email</label>
                            <InputText
                                type="text"
                                :class="{ 'p-invalid': error_email }"
                                name="email"
                                v-model="email"
                            />
                            <label
                                style="color: red"
                                for="email"
                                v-if="error_email"
                                >{{ error_email }}</label
                            >
                        </div>
                        <div class="field col-12 md:col-4">
                            <label for="password">Password</label>
                            <Password
                                :class="{ 'p-invalid': error_password }"
                                v-model="password"
                                autocomplete="off"
                                toggleMask
                            ></Password>
                            <label
                                style="color: red"
                                for="password"
                                v-if="error_password"
                                >{{ error_password }}</label
                            >
                        </div>
                        <div class="field col-12 md:col-4">
                            <label for="confirm_password"
                                >Confirm Password</label
                            >
                            <Password
                                :class="{ 'p-invalid': error_confirm_password }"
                                autocomplete="off"
                                v-model="confirm_password"
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
                    <span class="block">Processing Request...</span>
                </div>
            </div>
        </Dialog>
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
            blocks: computed(() => store.state.blocks.blocks),
            lots: computed(() => store.state.lots.lots),
            filteredLots: computed(() => store.state.lots.filteredLots),
        };
    },
    data() {
        return {
            loading: null,
            first_name: null,
            last_name: null,
            gender: null,
            block_lot_id: null,
            email: null,
            password: null,
            confirm_password: null,
            verified: 0,
            has_voted: 0,
            age: null,
            contact_num: null,
            role: "resident",

            selected_block: null,

            error_first_name: null,
            error_last_name: null,
            error_gender: null,
            error_selected_block: null,
            error_selected_lot: null,
            error_email: null,
            error_password: null,
            error_confirm_password: null,
            error_age: null,
            error_contact_num: null,
        };
    },

    computed: {},
    methods: {
        async onRegisterClick() {
            this.loading = true;
            await axios({
                method: "post",
                url: "/api/user",
                data: {
                    first_name: this.first_name,
                    last_name: this.last_name,
                    gender: this.gender,
                    block_lot_id: this.selected_block_lot,
                    email: this.email,
                    password: this.password,
                    confirm_password: this.confirm_password,
                    verified: 1,
                    has_voted: 0,
                    age: this.age,
                    contact_num: this.contact_num,
                    role: "resident",
                },
            })
                .then(() => {
                    this.loading = false;
                    this.$router.push({ name: "login" });
                })
                .catch((err) => {
                    console.log(err.response.data);
                    this.resetErrors();
                    this.validate(err);
                    this.loading = false;
                });
        },
        resetFields() {
            this.first_name = null;
            this.last_name = null;
            this.gender = null;
            this.block_lot_id = null;
            this.email = null;
            this.password = null;
            this.confirm_password = null;
            this.verified = true;
            this.has_voted = false;
            this.age = null;
            this.contact_num = null;
            this.role = "resident";
        },
        resetErrors() {
            this.error_first_name = null;
            this.error_last_name = null;
            this.error_gender = null;
            this.error_selected_block = null;
            this.error_selected_lot = null;
            this.error_email = null;
            this.error_password = null;
            this.error_confirm_password = null;
            this.error_age = null;
            this.error_contact_num = null;
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

        getBlockLot() {
            this.$store.dispatch("lots/getBlockLots", this.selected_block);
        },
    },
    created() {},
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
