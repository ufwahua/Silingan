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
                            <label>Firstname</label>

                            <InputText
                                id="firstname"
                                :class="{
                                    'p-invalid': error_first_name,
                                }"
                                type="text"
                                v-model="first_name"
                            />
                            <label style="color: red" v-if="error_first_name">{{
                                error_first_name
                            }}</label>
                        </div>

                        <div class="field col-12 md:col-6">
                            <label>Lastname</label>

                            <InputText
                                :class="{
                                    'p-invalid': error_last_name,
                                }"
                                id="last_name"
                                type="text"
                                v-model="last_name"
                            />
                            <label style="color: red" v-if="error_last_name">{{
                                error_last_name
                            }}</label>
                        </div>

                        <div class="field col-12 md:col-6">
                            <div>
                                <label>Gender</label>
                            </div>

                            <div>
                                <div class="field-radiobutton mb-0">
                                    <RadioButton
                                        name="gender"
                                        :class="{
                                            'p-invalid': error_gender,
                                        }"
                                        value="male"
                                        v-model="gender"
                                        block_number
                                    />
                                    <label class="mb-0 ml-1 mr-5">Male</label>
                                    <RadioButton
                                        name="gender"
                                        :class="{
                                            'p-invalid': error_gender,
                                        }"
                                        value="female"
                                        v-model="gender"
                                        block_number
                                    />
                                    <label class="mb-0 ml-1">Female</label>
                                </div>
                                <div>
                                    <label
                                        style="color: red"
                                        v-if="error_gender"
                                        >{{ error_gender }}</label
                                    >
                                </div>
                            </div>
                        </div>

                        <div class="field col-12 md:col-6">
                            <label>Age</label>
                            <InputText
                                id="age"
                                :class="{
                                    'p-invalid': error_age,
                                }"
                                type="number"
                                min="0"
                                step="1"
                                onfocus="this.previousValue = this.value"
                                onkeydown="this.previousValue = this.value"
                                oninput="validity.valid || (value = this.previousValue)"
                                v-model="age"
                            />
                            <label style="color: red" v-if="error_age">{{
                                error_age
                            }}</label>
                        </div>

                        <div class="field col-12 md:col-6">
                            <label>Contact Number</label>

                            <div class="p-inputgroup">
                                <span class="p-inputgroup-addon"> +63 </span>

                                <InputMask
                                    mask="(999) 99-999-9999"
                                    placeholder="(639) 99-999-9999"
                                    :unmask="true"
                                    :class="{
                                        'p-invalid': error_contact_num,
                                    }"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                    v-model="contact_num"
                                />
                            </div>

                            <label
                                style="color: red"
                                v-if="error_contact_num"
                                >{{ error_contact_num }}</label
                            >
                        </div>
                        <div class="field col-12 md:col-6">
                            <label>Tag as</label>

                            <Dropdown
                                v-model="selected_tag"
                                :class="{
                                    'p-invalid': error_selected_tag,
                                }"
                                :options="tag"
                                optionLabel="tag"
                                optionValue="tag"
                                placeholder="Select tag"
                            />
                            <label
                                style="color: red"
                                v-if="error_selected_tag"
                                >{{ error_selected_tag }}</label
                            >
                        </div>
                        <div class="field col-12 md:col-6">
                            <label>Block</label>

                            <Dropdown
                                v-model="selected_block"
                                :class="{
                                    'p-invalid': error_selected_block,
                                }"
                                :options="blocks"
                                optionLabel="number"
                                optionValue="number"
                                placeholder="Select Block"
                                @change="getBlockLot"
                            />
                            <label
                                style="color: red"
                                v-if="error_selected_block"
                                >{{ error_selected_block }}</label
                            >
                        </div>

                        <div class="field col-12 md:col-6">
                            <label>Lot</label>

                            <Dropdown
                                v-model="selected_block_lot"
                                :class="{
                                    'p-invalid': error_selected_lot,
                                }"
                                :options="filteredLots"
                                optionLabel="number"
                                optionValue="id"
                                placeholder="Select Lot"
                                :disabled="selected_block ? false : true"
                            />
                            <label
                                style="color: red"
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
                            <label>Email</label>
                            <InputText
                                type="text"
                                :class="{ 'p-invalid': error_email }"
                                name="email"
                                v-model="email"
                            />
                            <label style="color: red" v-if="error_email">{{
                                error_email
                            }}</label>
                        </div>
                        <div class="field col-12 md:col-4">
                            <label>Password</label>
                            <Password
                                :class="{ 'p-invalid': error_password }"
                                v-model="password"
                                toggleMask
                            ></Password>
                            <label style="color: red" v-if="error_password">{{
                                error_password
                            }}</label>
                        </div>
                        <div class="field col-12 md:col-4">
                            <label>Confirm Password</label>
                            <Password
                                :class="{ 'p-invalid': error_confirm_password }"
                                v-model="confirm_password"
                                toggleMask
                            ></Password>
                            <label
                                style="color: red"
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
            selected_block_lot: null,
            email: null,
            password: null,
            confirm_password: null,
            verified: 0,
            has_voted: 0,
            age: null,
            contact_num: null,
            role: "resident",
            selected_block: null,
            selected_tag: null,
            tag: [
                { tag: "owner" },
                { tag: "renter" },
                { tag: "family member" },
            ],
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
            error_selected_tag: null,
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
                    verified: 0,
                    has_voted: 0,
                    age: this.age,
                    contact_num: this.contact_num,
                    role: "resident",
                    status: "active",
                    tag_as: this.selected_tag,
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
            this.selected_block_lot = null;
            this.email = null;
            this.password = null;
            this.confirm_password = null;
            this.verified = 0;
            this.has_voted = 0;
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
            this.error_selected_tag = null;
        },
        validate(error) {
            if (error.response.data.errors.first_name)
                this.error_first_name =
                    error.response.data.errors.first_name[0];
            if (error.response.data.errors.last_name)
                this.error_last_name = error.response.data.errors.last_name[0];
            if (error.response.data.errors.gender)
                this.error_gender = error.response.data.errors.gender[0];
            if (error.response.data.errors.block_lot_id) {
                this.error_selected_block = "Complete block and lot field";
                this.error_selected_lot = "Complete block and lot field";
            }

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
            if (!this.selected_tag) {
                this.error_selected_tag = "This tag field is required.";
            }
        },

        getBlockLot() {
            this.selected_block_lot = null;
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
