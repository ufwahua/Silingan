<template>
    <div>
        <Toast />
        <div class="grid">
            <div class="col-12">
                <h1>Residents</h1>
            </div>
        </div>
        <div class="card">
            <div class="grid mb-4">
                <div class="col-12">
                    <Toolbar>
                        <template #start>
                            <span class="p-input-icon-left inline-block">
                                <i class="pi pi-search" />
                                <InputText
                                    v-model="filters['global'].value"
                                    placeholder="Keyword Search"
                                />
                            </span>
                        </template>

                        <template #end>
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
                        <!-- <Column header="Role" field="role">
                            <template #body="{ data }">
                                <Badge :class="badgecolor(data.role)">{{
                                    data.role
                                }}</Badge>
                            </template>
                        </Column> -->
                        <Column header="Status" field="status">
                            <template #body="{ data }">
                                <Badge
                                    v-if="data.verified == 1"
                                    :class="badgecolor(data.verified)"
                                    >{{ "Approved" }}</Badge
                                >
                                <Badge
                                    v-if="data.verified == 0"
                                    :class="badgecolor(data.verified)"
                                    >{{ "Pending" }}</Badge
                                >
                            </template>
                        </Column>
                        <Column header="Verify" field="verify">
                            <template #body="{ data }">
                                <Button
                                    v-if="data.verified == 0"
                                    label="Accept"
                                    icon="pi pi-check"
                                    class="p-button-sm"
                                    @click="verify(data)"
                                />
                                <Button
                                    v-if="data.verified == 1"
                                    label="Accept"
                                    icon="pi pi-check"
                                    class="p-button-sm"
                                    disabled="isDisabled"
                                />
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
                                    <label>Firstname</label>
                                    <label style="color: red" v-if="!first_name"
                                        >*</label
                                    >
                                    <InputText
                                        id="firstname"
                                        type="text"
                                        v-model="first_name"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_first_name"
                                        >{{ error_first_name }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-6">
                                    <label>Lastname</label>
                                    <label style="color: red" v-if="!last_name"
                                        >*</label
                                    >
                                    <InputText
                                        id="last_name"
                                        type="text"
                                        v-model="last_name"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_last_name"
                                        >{{ error_last_name }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-6">
                                    <div>
                                        <label>Gender</label>
                                        <label style="color: red" v-if="!gender"
                                            >*</label
                                        >
                                    </div>

                                    <div>
                                        <div class="field-radiobutton mb-0">
                                            <RadioButton
                                                name="gender"
                                                value="male"
                                                v-model="gender"
                                                @keydown.enter="onRegisterClick"
                                            />
                                            <label class="mb-0 ml-1 mr-5"
                                                >Male</label
                                            >
                                            <RadioButton
                                                name="gender"
                                                value="female"
                                                v-model="gender"
                                                @keydown.enter="onRegisterClick"
                                            />
                                            <label class="mb-0 ml-1"
                                                >Female</label
                                            >
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
                                <div
                                    class="formgroup-inline flex justify-content-around"
                                >
                                    <label
                                        style="color: red"
                                        v-if="error_gender"
                                        >{{ error_gender }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-6">
                                    <label>Role</label>
                                    <label
                                        style="color: red"
                                        v-if="!selected_role"
                                        >*</label
                                    >
                                    <Dropdown
                                        v-model="selected_role"
                                        :options="role"
                                        optionLabel="type"
                                        optionValue="value"
                                        placeholder="Select Role"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_role"
                                        >{{ error_role }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-12">
                                    <label>Age</label
                                    ><label style="color: red" v-if="!age"
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
                                        v-model="age"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_age"
                                        >{{ error_age }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-12">
                                    <label>Contact Number</label
                                    ><label
                                        style="color: red"
                                        v-if="!contact_num"
                                        >*</label
                                    >
                                    <InputText
                                        id="contact_num"
                                        type="text"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                        v-model="contact_num"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_contact_num"
                                        >{{ error_contact_num }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-6">
                                    <label>Block</label>
                                    <label
                                        style="color: red"
                                        v-if="!selected_block"
                                        >*</label
                                    >
                                    <Dropdown
                                        v-model="selected_block"
                                        :options="blocks"
                                        optionLabel="number"
                                        optionValue="id"
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
                                    <label
                                        style="color: red"
                                        v-if="!selected_block_lot"
                                        >*</label
                                    >
                                    <Dropdown
                                        v-model="selected_block_lot"
                                        :options="filteredLots"
                                        optionLabel="number"
                                        optionValue="id"
                                        placeholder="Select Lot"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_selected_lot"
                                        >{{ error_selected_lot }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-12">
                                    <label>Email</label
                                    ><label style="color: red" v-if="!email"
                                        >*</label
                                    >
                                    <InputText
                                        type="text"
                                        name="email"
                                        v-model="email"
                                    />
                                    <label
                                        style="color: red"
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
                                    <label>Firstname</label>
                                    <label
                                        style="color: red"
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
                                        v-if="error_first_name"
                                        >{{ error_first_name }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-6">
                                    <label>Lastname</label>
                                    <label
                                        style="color: red"
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
                                        v-if="error_last_name"
                                        >{{ error_last_name }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-6">
                                    <div>
                                        <label>Gender</label>
                                        <label style="color: red" v-if="!gender"
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
                                            <label class="mb-0 ml-1 mr-5"
                                                >Male</label
                                            >
                                            <RadioButton
                                                name="gender"
                                                value="female"
                                                v-model="form.gender"
                                                @keydown.enter="onRegisterClick"
                                            />
                                            <label class="mb-0 ml-1"
                                                >Female</label
                                            >
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
                                <div
                                    class="formgroup-inline flex justify-content-around"
                                >
                                    <label
                                        style="color: red"
                                        v-if="error_gender"
                                        >{{ error_gender }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-6">
                                    <label>Role</label>
                                    <label
                                        style="color: red"
                                        v-if="!selected_role"
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
                                        v-if="error_role"
                                        >{{ error_role }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-12">
                                    <label>Age</label
                                    ><label style="color: red" v-if="!age"
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
                                        v-if="error_age"
                                        >{{ error_age }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-12">
                                    <label>Contact Number</label
                                    ><label
                                        style="color: red"
                                        v-if="!form.contact_num"
                                        >*</label
                                    >
                                    <InputText
                                        id="contact_num"
                                        type="text"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                        v-model="form.contact_num"
                                        @keydown.enter="onRegisterClick"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_contact_num"
                                        >{{ error_contact_num }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-6">
                                    <label>Block</label>
                                    <label
                                        style="color: red"
                                        v-if="!selected_block"
                                        >*</label
                                    >
                                    <Dropdown
                                        v-model="selected_block"
                                        :options="blocks"
                                        optionLabel="number"
                                        optionValue="id"
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
                                    <label
                                        style="color: red"
                                        v-if="!selected_block_lot"
                                        >*</label
                                    >
                                    <Dropdown
                                        v-model="selected_block_lot"
                                        :options="filteredLots"
                                        optionLabel="number"
                                        optionValue="id"
                                        placeholder="Select Lot"
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
                                    <label><h6>Security Information</h6></label>
                                </div>

                                <div class="field col-12 md:col-4">
                                    <label>Email</label
                                    ><label
                                        style="color: red"
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
                                        v-if="error_email"
                                        >{{ error_email }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-4">
                                    <label>Password</label
                                    ><label
                                        style="color: red"
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
                                        v-if="error_password"
                                        >{{ error_password }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-4">
                                    <label>Confirm Password</label>
                                    <label
                                        style="color: red"
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
            blocks: computed(() => store.state.blocks.blocks),
            filteredLots: computed(() => store.state.lots.filteredLots),
            lots: computed(() => store.state.lots.lots),
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
                role: "",
            },
            block: null,
            lot: null,
            selected_block: null,
            selected_block_lot: null,
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
            role: null,
            selected_role: null,
            user: null,
            role: [{ type: "resident", value: "resident" }],
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
                role: { value: "resident", matchMode: FilterMatchMode.EQUALS },
            };
        },
        badgecolor(color) {
            if (color == "admin") {
                return "bg-gray-500";
            } else if (color == "resident") {
                return "bg-orange-500";
            } else if (color == "security_officer") {
                return "bg-yellow-500";
            } else if (color == 1) {
                return "bg-green-500";
            } else if (color == 0) {
                return "bg-gray-500";
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
                this.$store.dispatch("registeredUsers/getAll");
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
            console.log(data);
            this.resetFields();
            this.resetErrors();
            this.id = data.id;
            this.updateUserDialog = true;
            this.first_name = data.first_name;
            this.last_name = data.last_name;
            this.gender = data.gender;
            this.selected_block = data.block_lot.block.id;
            this.getBlockLot();
            this.selected_block_lot = data.block_lot.id;
            this.email = data.email;
            this.age = data.age;
            this.contact_num = data.contact_num;
            this.selected_role = data.role;
        },
        async confirmUpdateUser() {
            this.process = true;
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
                },
            })
                .then(() => {
                    this.$toast.add({
                        severity: "success",
                        summary: "Successful Request",
                        detail: "Updated User",
                        life: 3000,
                    });
                    this.$store.dispatch("registeredUsers/getAll");
                    this.resetFields();
                    this.updateUserDialog = false;
                    this.process = false;
                })
                .catch((err) => {
                    console.log(err.response);
                    this.validate(err);
                    this.process = false;
                });
        },
        async verify(data) {
            this.process = true;
            await axios({
                method: "put",
                url: "/api/user/" + data.id,
                data: {
                    first_name: data.first_name,
                    last_name: data.last_name,
                    gender: data.gender,
                    block_lot_id: data.selected_block_lot,
                    email: data.email,
                    verified: 1,
                    has_voted: 0,
                    age: data.age,
                    contact_num: data.contact_num,
                    role: data.role,
                },
            })
                .then(() => {
                    this.$toast.add({
                        severity: "success",
                        summary: "Successful",
                        detail: "Resident Verified",
                        life: 3000,
                    });
                    this.$store.dispatch("registeredUsers/getAll");
                    this.resetFields();
                    this.process = false;
                })
                .catch((err) => {
                    console.log(err.response);
                    this.validate(err);
                    this.process = false;
                });
        },
        //REGISTER USER
        registerUser() {
            this.registerUserDialog = true;
            this.form.email = null;
            this.resetFields();
            this.resetErrors();
        },
        async onRegisterClick() {
            this.process = true;
            await axios({
                method: "post",
                url: "/api/user",
                data: {
                    first_name: this.form.first_name,
                    last_name: this.form.last_name,
                    gender: this.form.gender,
                    block_lot_id: this.selected_block_lot,
                    email: this.form.email,
                    password: this.form.password,
                    confirm_password: this.form.confirm_password,
                    verified: 0,
                    has_voted: 0,
                    age: this.form.age,
                    contact_num: this.form.contact_num,
                    role: this.form.selected_role,
                },
            })
                .then(() => {
                    this.registerUserDialog = false;
                    this.resetFields();
                    this.$store.dispatch("registeredUsers/getAll");
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
            this.selected_block = null;
            this.selected_block_lot = null;
            this.form = {
                first_name: "",
                last_name: "",
                gender: "",
                selected_block: "",
                selected_block_lot: "",
                email: "",
                password: "",
                confirm_password: "",
                age: "",
                contact_num: "",
                selected_role: "resident",
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
    },
    created() {
        this.initFilters();
    },
};
</script>

<style></style>
