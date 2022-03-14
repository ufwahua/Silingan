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
                    <label style="color: red" v-if="!first_name">*</label>
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
                    <label style="color: red" v-if="!last_name">*</label>
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
                        <label style="color: red" v-if="!gender">*</label>
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
                    <label>Age</label
                    ><label style="color: red" v-if="!age">*</label>
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
                    <label>Contact Number</label
                    ><label style="color: red" v-if="!contact_num">*</label>
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
                    <label style="color: red" v-if="!selected_block">*</label>
                    <Dropdown
                        v-model="selected_block"
                        :class="{
                            'p-invalid': error_selected_block,
                        }"
                        :options="blocks"
                        optionLabel="number"
                        optionValue="id"
                        placeholder="Select Block"
                        @change="getBlockLot"
                    />
                    <label style="color: red" v-if="error_selected_block">{{
                        error_selected_block
                    }}</label>
                </div>

                <div class="field col-12 md:col-6">
                    <label>Lot</label>
                    <label style="color: red" v-if="!selected_block_lot"
                        >*</label
                    >
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
                    <label>Email</label
                    ><label style="color: red" v-if="!email">*</label>
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
        <div align="right" class="mb-4">
            <div v-if="btnUpdate">
                <Button
                    label="Update"
                    class="p-button p-button-primary"
                    @click="confirmUpdateUser"
                />
            </div>
            <div v-else>
                <Button
                    label="Update"
                    class="p-button p-button-primary"
                    @click="confirmUpdateUser"
                    disabled
                />
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
                { type: "security_officer", value: "security_officer" },
                { type: "admin", value: "admin" },
            ],

            selected_block: null,
            selected_block_lot: null,
            btnUpdate: false,
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
            error_role: "",
        };
    },
    methods: {
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
                    console.log(err.response);
                    this.validate(err);
                    this.loading = false;
                });
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
            this.error_role = "";
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
            this.selected_block_lot = null;
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
