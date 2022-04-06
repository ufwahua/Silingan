<template>
    <div class="layout-profile">
        <div class="grid">
            <div class="col-12 title-form">
                <label><h3>Profile Picture</h3></label>
            </div>
            <div class="col-12 flex justify-content-center">
                <div v-if="profile_pic">
                    <Avatar
                        :image="`http://127.0.0.1:8000${profile_pic}`"
                        style="width: 300px; height: 300px"
                        shape="circle"
                    />
                </div>
                <div v-else>
                    <Avatar
                        image="http://127.0.0.1:8000/storage/images/default-prof-pic.png"
                        style="width: 300px; height: 300px"
                        shape="circle"
                    />
                </div>
            </div>
            <div class="col-12 flex justify-content-center">
                <FileUpload
                    name="demo[]"
                    mode="basic"
                    accept="image/*"
                    :customUpload="true"
                    @uploader="onUpload"
                    :auto="true"
                    :fileLimit="1"
                    :maxFileSize="2000000"
                />
            </div>
        </div>
        <div class="grid">
            <div class="col-12 title-form">
                <label><h3>Profile Settings</h3></label>
            </div>

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
                            <label style="color: red" v-if="error_gender">{{
                                error_gender
                            }}</label>
                        </div>
                    </div>
                </div>
                <div class="formgroup-inline flex justify-content-around">
                    <label style="color: red" v-if="error_gender">{{
                        error_gender
                    }}</label>
                </div>
                <div class="field col-12 md:col-12">
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

                <div class="field col-12 md:col-12">
                    <label>Contact Number</label>
                    <InputText
                        :class="{
                            'p-invalid': error_contact_num,
                        }"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                        v-model="contact_num"
                    />
                    <label style="color: red" v-if="error_contact_num">{{
                        error_contact_num
                    }}</label>
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
                    <label style="color: red" v-if="error_selected_block">{{
                        error_selected_block
                    }}</label>
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
                    />
                    <label style="color: red" v-if="error_selected_lot">{{
                        error_selected_lot
                    }}</label>
                </div>
                <div class="field col-12 md:col-12">
                    <label>Email</label>
                    <InputText
                        type="text"
                        :class="{
                            'p-invalid': error_email,
                        }"
                        name="email"
                        v-model="email"
                    />
                    <label style="color: red" v-if="error_email">{{
                        error_email
                    }}</label>
                </div>
            </div>
        </div>
        <div class="grid">
            <div class="col-4"></div>
            <div class="col-4">
                <div class="p-fluid mb-2">
                    <Button
                        label="Update"
                        class="p-button p-button-primary"
                        @click="confirmUpdateUser"
                        :disabled="!btnUpdate ? true : false"
                    />
                </div>
            </div>
        </div>
        <div class="col-12 title-form">
            <h3>Change Password</h3>
        </div>

        <div class="grid">
            <div class="col-6">
                <div class="p-fluid mb-2">
                    <h6>Enter Current Password</h6>
                    <Password
                        v-model="old_password"
                        @keyup.enter="changePassword"
                        :class="{ 'p-invalid': error_old_password }"
                        toggleMask
                    ></Password>

                    <label
                        style="color: red"
                        for="contact_number"
                        v-if="error_old_password"
                        >{{ error_old_password }}</label
                    >
                </div>
            </div>
        </div>
        <div class="grid">
            <div class="col-6">
                <div class="p-fluid mb-2">
                    <h6>New Password</h6>
                    <Password
                        v-model="new_password"
                        @keyup.enter="changePassword"
                        :class="{ 'p-invalid': error_new_password }"
                        toggleMask
                    ></Password>

                    <label
                        style="color: red"
                        for="contact_number"
                        v-if="error_new_password"
                        >{{ error_new_password }}</label
                    >
                </div>
            </div>
            <div class="col-6">
                <div class="p-fluid mb-2">
                    <h6>Confirm Password</h6>
                    <Password
                        v-model="confirm_password"
                        @keyup.enter="changePassword"
                        :class="{ 'p-invalid': error_confirm_password }"
                        toggleMask
                    ></Password>

                    <label
                        style="color: red"
                        for="contact_number"
                        v-if="error_confirm_password"
                        >{{ error_confirm_password }}</label
                    >
                </div>
            </div>
        </div>
        <div class="grid">
            <div class="col-4"></div>
            <div class="col-4">
                <div class="p-fluid mb-2">
                    <Button
                        label="Change Password"
                        class="p-button p-button-primary"
                        @click="changePassword"
                    />
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
        <Toast />
    </div>
</template>

<script>
import axios from "axios";
import { FilterMatchMode } from "primevue/api";
import { computed } from "vue";
import { useStore } from "vuex";
export default {
    name: "AppProfile",
    setup() {
        const store = useStore();
        return {
            blocks: computed(() => store.state.blocks.blocks),
            filteredLots: computed(() => store.state.lots.filteredLots),
            lots: computed(() => store.state.lots.lots),
        };
    },
    data() {
        return {
            profile_pic: null,
            loading: false,
            isInvalid: false,
            filters: {},
            loading: false,

            first_name: null,
            last_name: null,
            gender: null,
            block_lot_id: null,
            email: null,
            password: null,
            confirm_password: null,
            verified: 1,
            has_voted: 0,
            age: null,
            contact_num: null,
            selected_role: null,
            role: [
                { type: "officer", value: "officer" },
                { type: "resident", value: "resident" },
                { type: "security officer", value: "security officer" },
                { type: "admin", value: "admin" },
            ],

            selected_block: null,
            selected_block_lot: null,
            btnUpdate: false,

            old_password: null,
            new_password: null,
            confirm_password: null,
            error_first_name: null,
            error_last_name: null,
            error_gender: null,
            error_selected_block: null,
            error_selected_lot: null,
            error_email: null,
            error_old_password: null,
            error_new_password: null,
            error_confirm_password: null,
            error_age: null,
            error_contact_num: null,
            error_role: null,
        };
    },
    methods: {
        showUpdatePasswordToast() {
            this.$toast.add({
                severity: "success",
                summary: "Success",
                detail: "Updated Password",
                life: 3000,
            });
        },
        async changePassword() {
            this.resetErrors();
            this.loading = true;
            await axios({
                method: "put",
                url: "/api/change-password/" + this.id,
                data: {
                    old_password: this.old_password,
                    new_password: this.new_password,
                    confirm_password: this.confirm_password,
                },
            })
                .then((res) => {
                    setTimeout(() => {
                        this.$store.dispatch("getUserLogged");
                        this.loading = false;
                        this.showUpdatePasswordToast();
                    }, 500);
                    this.resetErrors();
                })
                .catch((e) => {
                    this.loading = false;
                    this.resetErrors();
                    if (e.response.data.old_password) {
                        this.error_old_password = e.response.data.old_password;
                    }
                    if (e.response.data.errors.old_password) {
                        this.error_old_password =
                            e.response.data.errors.old_password[0];
                    }
                    if (e.response.data.errors.new_password) {
                        this.error_new_password =
                            e.response.data.errors.new_password[0];
                    }
                    if (e.response.data.errors.confirm_password) {
                        this.error_confirm_password =
                            e.response.data.errors.confirm_password[0];
                    }
                });
        },
        async onUpload(event) {
            let formData = new FormData();
            formData.append("images[]", event.files[0]);
            formData.append("user_id", this.$store.state.userLogged.id);
            await axios
                .post("/upload", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((res) => {
                    this.profile_pic = res.data[0];
                    console.log(this.profile_pic);
                })
                .catch((e) => {
                    console.log(e.response);
                });
        },
        async confirmUpdateUser() {
            this.loading = true;
            await axios({
                method: "put",
                url: "/api/user/" + this.id,
                data: {
                    first_name: this.first_name,
                    last_name: this.last_name,
                    gender: this.gender,
                    block_lot_id: this.selected_block_lot,
                    email: this.email,
                    verified: 1,
                    has_voted: 0,
                    age: this.age,
                    contact_num: this.contact_num,
                    role: this.selected_role,
                    profile_pic: this.profile_pic,
                    status: "active",
                },
            })
                .then((res) => {
                    console.log(res.data);
                    this.$toast.add({
                        severity: "success",
                        summary: "Successful Request",
                        detail: "Updated User",
                        life: 3000,
                    });
                    // this.$store.commit("getUserLogged", res.data);
                    this.loading = false;
                })
                .catch((err) => {
                    this.resetErrors();
                    this.resetErrors();
                    console.log(err.response);
                    this.validate(err);
                    this.loading = false;
                });
        },
        resetErrors() {
            this.error_first_name = null;
            this.error_last_name = null;
            this.error_gender = null;
            this.error_selected_block = null;
            this.error_selected_lot = null;
            this.error_email = null;
            this.error_old_password = null;
            this.error_new_password = null;
            this.error_confirm_password = null;
            this.error_age = null;
            this.error_contact_num = null;
            this.error_role = null;
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
            if (error.response.data.errors.selected_block_lot)
                this.error_selected_lot =
                    error.response.data.errors.selected_block_lot[0];
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
            if (error.response.data.errors.role)
                this.error_role = error.response.data.errors.role[0];
        },

        getBlockLot() {
            this.$store.dispatch("lots/getBlockLots", this.selected_block);
        },
        populateData() {
            this.id = this.$store.state.userLogged.id;
            this.first_name = this.$store.state.userLogged.first_name;
            this.last_name = this.$store.state.userLogged.last_name;
            this.gender = this.$store.state.userLogged.gender;
            this.block_lot_id = null;
            this.email = this.$store.state.userLogged.email;
            this.password = null;
            this.confirm_password = null;
            this.verified = 1;
            this.has_voted = 0;
            this.age = this.$store.state.userLogged.age;
            this.contact_num = this.$store.state.userLogged.contact_num;
            this.selected_role = this.$store.state.userLogged.role;
            this.selected_block = this.$store.state.userLogged.lot.block_id;
            this.getBlockLot();
            this.selected_block_lot = this.$store.state.userLogged.lot.id;
            this.profile_pic = this.$store.state.userLogged.profile_pic;
        },
    },
    watch: {
        selected_block() {
            if (this.selected_block && this.selected_block_lot) {
                this.btnUpdate = true;
            } else {
                this.btnUpdate = false;
            }
        },
        selected_block_lot() {
            if (this.selected_block && this.selected_block_lot) {
                this.btnUpdate = true;
            } else {
                this.btnUpdate = false;
            }
        },
    },
    mounted() {
        this.populateData();
    },
};
</script>

<style></style>
