<template>
    <div>
        <Toast />
        <div class="grid">
            <div class="col-12">
                <h1>Registered Users</h1>
            </div>
        </div>
        <div class="card">
            <div class="grid mb-4">
                <div class="col-12">
                    <Toolbar>
                        <template #left>
                            <span class="p-input-icon-left inline-block">
                                <i class="pi pi-search" />
                                <InputText
                                    v-model="filters['global'].value"
                                    placeholder="Keyword Search"
                                />
                            </span>
                        </template>

                        <template #right>
                            <div class="mr-2">
                                <Button
                                    label="Add"
                                    icon="pi pi-plus"
                                    class="p-button-success p-mr-2"
                                    @click="registerUser"
                                />
                            </div>
                        </template>
                    </Toolbar>
                </div>
            </div>
            <div class="grid">
                <div class="col-12">
                    <DataTable
                        :value="registeredUsers"
                        :filters="filters"
                        breakpoint="1230px"
                    >
                        <template #empty> No registered users found </template>
                        <template #loading> Loading Users </template>
                        <Column header="Id" field="id">
                            <template #body="{ data }">
                                {{ data.id }}
                            </template>
                        </Column>
                        <Column header="Name" field="name">
                            <template #body="{ data }">
                                {{ data.first_name }} {{ data.last_name }}
                            </template>
                        </Column>
                        <Column header="Email" field="email">
                            <template #body="{ data }">
                                {{ data.email }}
                            </template>
                        </Column>
                        <Column header="Block" field="block_lot.block.number">
                        </Column>
                        <Column header="Lot" field="block_lot.number"> </Column>
                        <Column header="Role" field="role">
                            <template #body="{ data }">
                                <Badge :class="badgecolor(data.role)">{{
                                    data.role
                                }}</Badge>
                            </template>
                        </Column>
                        <Column header="Actions" field="actions">
                            <template #body="{ data }">
                                <Button
                                    icon="pi pi-pencil"
                                    class="p-button-rounded p-button-primary mr-2"
                                    @click="updateUser(data)"
                                />
                                <Button
                                    icon="pi pi-trash"
                                    class="p-button-rounded p-button-danger"
                                    @click="
                                        deleteUser(
                                            data.first_name,
                                            data.last_name,
                                            data.id
                                        )
                                    "
                                />
                            </template>
                        </Column>
                    </DataTable>

                    <Dialog
                        v-model:visible="deleteUserDialog"
                        :style="{ width: '450px' }"
                        header="Confirm"
                        :modal="true"
                    >
                        <div class="confirmation-content">
                            <div class="grid">
                                <div
                                    class="col-12 flex align-items-center justify-content-center"
                                >
                                    <i
                                        class="pi pi-exclamation-triangle mr-3"
                                        style="font-size: 2rem"
                                    />
                                    <span
                                        >Are you sure you want to delete
                                        <b>{{ name }}</b
                                        >?</span
                                    >
                                </div>
                            </div>
                        </div>
                        <template #footer>
                            <Button
                                label="Cancel"
                                icon="pi pi-times"
                                class="p-button-text"
                                @click="deleteUserDialog = false"
                            />
                            <Button
                                label="Delete"
                                icon="pi pi-check"
                                class="p-button-text p-button-danger"
                                @click="confirmDeleteItem"
                            />
                        </template>
                    </Dialog>
                    <Dialog
                        v-model:visible="updateUserDialog"
                        :style="{ width: '500px' }"
                        header="Update User"
                        :modal="true"
                    >
                        <div class="grid">
                            <div class="col-12 title-form">
                                <Badge
                                    :value="1"
                                    severity="info"
                                    class="mr-2 mb-2"
                                    size="large"
                                ></Badge>
                                <label><h6>Basic Information</h6></label>
                            </div>

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
                                    <div>
                                        <label for="last_name">Gender</label>
                                        <label
                                            style="color: red"
                                            for="gender"
                                            v-if="!form.gender"
                                            >*</label
                                        >
                                    </div>

                                    <div>
                                        <div class="field-radiobutton mb-0">
                                            <RadioButton
                                                name="gender"
                                                value="male"
                                                v-model="form.gender"
                                                @keydown.enter="onRegisterClick"
                                            />
                                            <label
                                                class="mb-0 ml-1 mr-5"
                                                for="gender"
                                                >Male</label
                                            >
                                            <RadioButton
                                                name="gender"
                                                value="female"
                                                v-model="form.gender"
                                                @keydown.enter="onRegisterClick"
                                            />
                                            <label
                                                class="mb-0 ml-1"
                                                for="gender"
                                                >Female</label
                                            >
                                        </div>
                                        <div>
                                            <label
                                                style="color: red"
                                                for="first_name"
                                                v-if="error_gender"
                                                >{{ error_gender }}</label
                                            >
                                        </div>
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
                                    <label>Role</label>
                                    <label
                                        style="color: red"
                                        v-if="!form.selected_role"
                                        >*</label
                                    >
                                    <Dropdown
                                        v-model="form.selected_role"
                                        :options="role"
                                        optionLabel="type"
                                        optionValue="value"
                                        placeholder="Select Role"
                                    />
                                    <label
                                        style="color: red"
                                        for="first_name"
                                        v-if="error_role"
                                        >{{ error_role }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-12">
                                    <label for="form.age">Age</label
                                    ><label style="color: red" v-if="!form.age"
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

                                <div class="field col-12 md:col-12">
                                    <label for="form.contact_num"
                                        >Contact Number</label
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
                                        optionValue="value"
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
                                        :options="lot"
                                        optionLabel="lot_number"
                                        optionValue="value"
                                        placeholder="Select Lot"
                                    />
                                    <label
                                        style="color: red"
                                        for="form.selected_lot"
                                        v-if="error_selected_lot"
                                        >{{ error_selected_lot }}</label
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
                            </div>
                        </div>
                        <template #footer>
                            <Button
                                label="Cancel"
                                icon="pi pi-times"
                                class="p-button-text"
                                @click="updateUserDialog = false"
                            />
                            <Button
                                label="Update"
                                icon="pi pi-check"
                                class="p-button-text p-button-warning"
                                @click="confirmUpdateUser"
                            />
                        </template>
                    </Dialog>
                    <Dialog
                        v-model:visible="registerUserDialog"
                        :style="{ width: '500px' }"
                        header="Register User"
                        :modal="true"
                    >
                        <div class="grid">
                            <div class="col-12 title-form">
                                <Badge
                                    :value="1"
                                    severity="info"
                                    class="mr-2 mb-2"
                                    size="large"
                                ></Badge>
                                <label><h6>Basic Information</h6></label>
                            </div>

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
                                        @keydown.enter="onRegisterClick"
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
                                        @keydown.enter="onRegisterClick"
                                    />
                                    <label
                                        style="color: red"
                                        for="first_name"
                                        v-if="error_last_name"
                                        >{{ error_last_name }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-12">
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
                                        @keydown.enter="onRegisterClick"
                                    />
                                    <label
                                        style="color: red"
                                        for="form.age"
                                        v-if="error_age"
                                        >{{ error_age }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-12">
                                    <div>
                                        <label for="last_name">Gender</label>
                                        <label
                                            style="color: red"
                                            for="gender"
                                            v-if="!form.gender"
                                            >*</label
                                        >
                                    </div>

                                    <div>
                                        <div class="field-radiobutton mb-0">
                                            <RadioButton
                                                name="gender"
                                                value="male"
                                                v-model="form.gender"
                                                @keydown.enter="onRegisterClick"
                                            />
                                            <label
                                                class="mb-0 ml-1 mr-5"
                                                for="gender"
                                                >Male</label
                                            >
                                            <RadioButton
                                                name="gender"
                                                value="female"
                                                v-model="form.gender"
                                                @keydown.enter="onRegisterClick"
                                            />
                                            <label
                                                class="mb-0 ml-1"
                                                for="gender"
                                                >Female</label
                                            >
                                        </div>
                                        <div>
                                            <label
                                                style="color: red"
                                                for="first_name"
                                                v-if="error_gender"
                                                >{{ error_gender }}</label
                                            >
                                        </div>
                                    </div>
                                </div>
                                <div class="field col-12 md:col-12">
                                    <label for="form.contact_num"
                                        >Contact Number</label
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
                                        v-model="form.contact_num"
                                        @keydown.enter="onRegisterClick"
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
                                        optionValue="value"
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
                                        :options="lot"
                                        optionLabel="lot_number"
                                        optionValue="value"
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
                                    <label><h6>Security Information</h6></label>
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
                                        @keydown.enter="onRegisterClick"
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
                                    <InputText
                                        type="password"
                                        name="password"
                                        v-model="form.password"
                                        @keydown.enter="onRegisterClick"
                                    />
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
                                    <InputText
                                        type="password"
                                        name="confirmpassword"
                                        v-model="form.confirm_password"
                                        @keydown.enter="onRegisterClick"
                                    />
                                    <label
                                        style="color: red"
                                        for="confirm_password"
                                        v-if="error_confirm_password"
                                        >{{ error_confirm_password }}</label
                                    >
                                </div>
                            </div>
                        </div>
                        <template #footer>
                            <Button
                                label="Cancel"
                                icon="pi pi-times"
                                class="p-button-text"
                                @click="registerUserDialog = false"
                            />
                            <Button
                                label="Register"
                                icon="pi pi-check"
                                class="p-button-text p-button-success"
                                @click="onRegisterClick"
                            />
                        </template>
                    </Dialog>
                    <Dialog
                        v-model:visible="process"
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
                                <span class="block"
                                    >Processeing Request...</span
                                >
                            </div>
                        </div>
                    </Dialog>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import { FilterMatchMode } from "primevue/api";
import { computed } from "vue";
import { useStore } from "vuex";
export default {
    name: "RegisterUsersComponent",
    setup() {
        const store = useStore();

        return {
            registeredUsers: computed(
                () => store.state.registeredUsers.registeredUsers
            ),
        };
    },
    data() {
        return {
            isInvalid: false,
            filters: {},
            id: null,
            name: null,
            process: false,
            registerUserDialog: false,
            deleteUserDialog: false,
            updateUserDialog: false,

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
            block: null,
            lot: null,
            user: null,
            role: [
                { type: "officer", value: "officer" },
                { type: "resident", value: "resident" },
                { type: "security_officer", value: "security_officer" },
                { type: "admin", value: "admin" },
            ],

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
        async getUsers() {
            await axios({
                method: "get",
                url: "/api/user",
            })
                .then((res) => {
                    this.user = res.data;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        showSuccess() {
            this.$toast.add({
                severity: "success",
                summary: "Success Message",
                detail: "Message Content",
                life: 3000,
            });
        },
        initFilters() {
            this.filters = {
                global: { value: null, matchMode: FilterMatchMode.CONTAINS },
            };
        },
        badgecolor(color) {
            if (color == "admin") {
                return "bg-gray-500";
            } else if (color == "resident") {
                return "bg-orange-500";
            } else if (color == "security_officer") {
                return "bg-yellow-500";
            } else {
                return "bg-yellow-800";
            }
        },
        deleteUser(first_name, last_name, id) {
            this.id = id;
            this.name = first_name + " " + last_name;
            this.deleteUserDialog = true;
        },
        async confirmDeleteItem() {
            try {
                this.deleteUserDialog = false;
                this.process = true;
                await axios({
                    method: "delete",
                    url: "/api/user/" + this.id,
                });
                this.getUsers();
                this.process = false;
                this.$toast.add({
                    severity: "success",
                    summary: "Successful Request",
                    detail: "Deleted User",
                    life: 3000,
                });
            } catch (err) {
                this.process = false;
                console.log(err.response);
            }
        },
        updateUser(data) {
            this.resetFields();
            this.resetErrors();
            this.id = data.id;
            this.updateUserDialog = true;
            this.form.first_name = data.first_name;
            this.form.last_name = data.last_name;
            this.form.gender = data.gender;
            // this.form.selected_block = block_id;
            // this.form.selected_lot = lot_number;
            this.form.email = data.email;
            this.form.age = data.age;
            this.form.contact_num = data.contact_num;
            this.form.selected_role = data.role;
        },
        async confirmUpdateUser() {
            this.process = true;
            await axios({
                method: "put",
                url: "/api/user/" + this.id,
                data: {
                    id: this.id,
                    first_name: this.form.first_name,
                    last_name: this.form.last_name,
                    gender: this.form.gender,
                    block: this.form.selected_block,
                    lot: this.form.selected_lot,
                    age: this.form.age,
                    contact_num: this.form.contact_num,
                    email: this.form.email,
                    role: this.form.selected_role,
                },
            })
                .then(() => {
                    this.$toast.add({
                        severity: "success",
                        summary: "Successful Request",
                        detail: "Updated User",
                        life: 3000,
                    });
                    this.getUsers();
                    this.resetFields();
                    this.updateUserDialog = false;
                    this.process = false;
                })
                .catch((err) => {
                    this.validate(err);
                    this.process = false;
                });
        },
        //REGISTER USER
        registerUser() {
            this.registerUserDialog = true;
            this.resetFields();
            this.resetErrors();
        },
        async onRegisterClick() {
            this.process = true;
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
                    this.registerUserDialog = false;
                    this.resetFields();
                    this.getUsers();
                    this.$toast.add({
                        severity: "success",
                        summary: "Successful Request",
                        detail: "Registered User",
                        life: 3000,
                    });
                    this.process = false;
                })
                .catch((err) => {
                    this.resetErrors();
                    this.validate(err);
                    this.process = false;
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
            if (error.response.data.errors.role)
                this.error_role = error.response.data.errors.role[0];
        },
        async getBlock() {
            var temp = [];
            const blocks = await axios({
                method: "get",
                url: "/api/block",
            });
            blocks.data.forEach((elem) => {
                temp.push({
                    block_number: elem.block_number,
                    value: elem.block_number,
                });
            });
            this.block = temp;
        },
        async getLot() {
            var temp = [];
            const lots = await axios({
                method: "get",
                url: "/api/lot",
            });
            lots.data.forEach((elem) => {
                temp.push({
                    lot_number: elem.lot_number,
                    value: elem.lot_number,
                });
            });
            this.lot = temp;
        },
        async getBlockLot() {
            var temp = [];
            const lots = await axios({
                method: "get",
                url: "/api/lot/" + this.form.selected_block,
            });
            lots.data.forEach((elem) => {
                temp.push({
                    lot_number: elem.lot_number,
                    value: elem.lot_number,
                });
            });
            this.lot = temp;
        },
    },
    created() {
        this.initFilters();
    },
};
</script>

<style></style>
