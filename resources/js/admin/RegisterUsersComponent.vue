<template>
    <div>
        <Toast />
        <div class="grid">
            <div class="col-12">
                <h1>Registered Users</h1>
            </div>
        </div>
        <div class="card">
            <div class="grid">
                <div class="col-12">
                    <DataTable
                        :value="users"
                        :filters="filters"
                        breakpoint="1350px"
                        :paginator="true"
                        :rows="10"
                    >
                        <template #header>
                            <div class="flex flex-wrap justify-content-between">
                                <span class="p-input-icon-left inline-block">
                                    <i class="pi pi-search" />
                                    <InputText
                                        v-model="filters['global'].value"
                                        placeholder="Keyword Search"
                                        class="my-2"
                                    />
                                </span>
                                <Dropdown
                                    v-model="filters['lot.block.number'].value"
                                    :showClear="true"
                                    :options="blocks"
                                    optionLabel="number"
                                    optionValue="number"
                                    placeholder="Filter by block"
                                    class="my-2"
                                    style="width: 200px"
                                    @change="getFilterBlockLot"
                                ></Dropdown>
                                <Dropdown
                                    v-model="filters['lot.number'].value"
                                    :showClear="true"
                                    :options="filteredLots"
                                    optionLabel="number"
                                    optionValue="number"
                                    placeholder="Filter by lot"
                                    style="width: 200px"
                                    class="my-2"
                                ></Dropdown>
                                <Dropdown
                                    v-model="filters['role'].value"
                                    :showClear="true"
                                    :options="role"
                                    optionLabel="role"
                                    optionValue="role"
                                    placeholder="Filter by Role"
                                    style="width: 200px"
                                    class="my-2"
                                ></Dropdown>
                                
                                <Button
                                    label="Clear"
                                    icon="pi pi-filter-slash"
                                    class="my-2 p-button-outlined p-button-secondary"
                                    @click="clearFilter"
                                />
                                <Button
                                    label="Add"
                                    icon="pi pi-plus"
                                    class="p-button-primary my-2"
                                    @click="registerUser"
                                />
                            </div>
                        </template>
                        <template #empty> No registered users found </template>
                        <template #loading> Loading Users </template>
                        <Column header="Id" field="id">
                            <template #body="{ data }">
                                {{ data.id }}
                            </template>
                        </Column>
                        <Column header="Name" field="name">
                            <template #body="{ data }">
                                {{
                                    (data["name"] =
                                        data.first_name + " " + data.last_name)
                                }}
                            </template>
                        </Column>
                        <Column header="Email" field="email">
                            <template #body="{ data }">
                                {{ data.email }}
                            </template>
                        </Column>
                        <Column header="Block" field="lot.block.number">
                        </Column>
                        <Column header="Lot" field="lot.number"> </Column>
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
                                    type="button"
                                    icon="pi pi-ellipsis-h"
                                    class="p-button-rounded p-button-info"
                                    @click="toggle(data)"
                                    aria-haspopup="true"
                                    aria-controls="overlay_menu"
                                />
                                <Menu
                                    id="overlay_menu"
                                    ref="menu"
                                    :model="menus"
                                    :popup="true"
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

                                    <InputText
                                        id="firstname"
                                        type="text"
                                        v-model="form.first_name"
                                        :class="{
                                            'p-invalid': error_first_name,
                                        }"
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

                                    <InputText
                                        id="last_name"
                                        type="text"
                                        v-model="form.last_name"
                                        :class="{
                                            'p-invalid': error_last_name,
                                        }"
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
                                    </div>

                                    <div>
                                        <div class="field-radiobutton mb-0">
                                            <RadioButton
                                                name="gender"
                                                value="male"
                                                v-model="form.gender"
                                                :class="{
                                                    'p-invalid': error_gender,
                                                }"
                                                @keydown.enter="onRegisterClick"
                                            />
                                            <label class="mb-0 ml-1 mr-5"
                                                >Male</label
                                            >
                                            <RadioButton
                                                name="gender"
                                                value="female"
                                                :class="{
                                                    'p-invalid': error_gender,
                                                }"
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

                                <div class="field col-12 md:col-6">
                                    <label>Role</label>

                                    <Dropdown
                                        v-model="form.selected_role"
                                        :class="{
                                            'p-invalid': error_role,
                                        }"
                                        :options="role"
                                        optionLabel="role"
                                        optionValue="role"
                                        placeholder="Select Role"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_role"
                                        >{{ error_role }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-12">
                                    <label>Age</label>
                                    <InputText
                                        id="age"
                                        type="number"
                                        min="0"
                                        step="1"
                                        onfocus="this.previousValue = this.value"
                                        onkeydown="this.previousValue = this.value"
                                        oninput="validity.valid || (value = this.previousValue)"
                                        v-model="form.age"
                                        :class="{
                                            'p-invalid': error_age,
                                        }"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_age"
                                        >{{ error_age }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-12">
                                    <label>Contact Number</label>
                                    <InputText
                                        id="contact_num"
                                        type="text"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                        v-model="form.contact_num"
                                        @keydown.enter="onRegisterClick"
                                        :class="{
                                            'p-invalid': error_contact_num,
                                        }"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_contact_num"
                                        >{{ error_contact_num }}</label
                                    >
                                </div>

                                <div
                                    v-if="
                                        form.selected_role != 'security_officer'
                                    "
                                    class="field col-12 md:col-6"
                                >
                                    <label>Block</label>

                                    <Dropdown
                                        v-model="form.selected_block"
                                        :options="blocks"
                                        optionLabel="number"
                                        optionValue="number"
                                        placeholder="Select Block"
                                        @change="getBlockLot"
                                        :class="{
                                            'p-invalid': error_selected_block,
                                        }"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_selected_block"
                                        >{{ error_selected_block }}</label
                                    >
                                </div>

                                <div
                                    v-if="
                                        form.selected_role != 'security_officer'
                                    "
                                    class="field col-12 md:col-6"
                                >
                                    <label>Lot</label>

                                    <Dropdown
                                        v-model="form.selected_block_lot"
                                        :options="filteredLots"
                                        optionLabel="number"
                                        optionValue="id"
                                        placeholder="Select Lot"
                                        :class="{
                                            'p-invalid': error_selected_lot,
                                        }"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_selected_lot"
                                        >{{ error_selected_lot }}</label
                                    >
                                </div>
                                <br />
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

                                    <InputText
                                        id="firstname"
                                        type="text"
                                        v-model="form.first_name"
                                        :class="{
                                            'p-invalid': error_first_name,
                                        }"
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

                                    <InputText
                                        id="last_name"
                                        type="text"
                                        v-model="form.last_name"
                                        :class="{
                                            'p-invalid': error_last_name,
                                        }"
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
                                    </div>

                                    <div>
                                        <div class="field-radiobutton mb-0">
                                            <RadioButton
                                                name="gender"
                                                value="male"
                                                v-model="form.gender"
                                                :class="{
                                                    'p-invalid': error_gender,
                                                }"
                                                @keydown.enter="onRegisterClick"
                                            />
                                            <label class="mb-0 ml-1 mr-5"
                                                >Male</label
                                            >
                                            <RadioButton
                                                name="gender"
                                                value="female"
                                                :class="{
                                                    'p-invalid': error_gender,
                                                }"
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

                                <div class="field col-12 md:col-6">
                                    <label>Role</label>

                                    <Dropdown
                                        v-model="form.selected_role"
                                        :class="{
                                            'p-invalid': error_role,
                                        }"
                                        :options="role"
                                        optionLabel="role"
                                        optionValue="role"
                                        placeholder="Select Role"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_role"
                                        >{{ error_role }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-12">
                                    <label>Age</label>
                                    <InputText
                                        id="age"
                                        type="number"
                                        min="0"
                                        step="1"
                                        onfocus="this.previousValue = this.value"
                                        onkeydown="this.previousValue = this.value"
                                        oninput="validity.valid || (value = this.previousValue)"
                                        v-model="form.age"
                                        :class="{
                                            'p-invalid': error_age,
                                        }"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_age"
                                        >{{ error_age }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-12">
                                    <label>Contact Number</label>
                                    <InputText
                                        id="contact_num"
                                        type="text"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                        v-model="form.contact_num"
                                        @keydown.enter="onRegisterClick"
                                        :class="{
                                            'p-invalid': error_contact_num,
                                        }"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_contact_num"
                                        >{{ error_contact_num }}</label
                                    >
                                </div>

                                <div
                                    v-if="
                                        form.selected_role != 'security_officer'
                                    "
                                    class="field col-12 md:col-6"
                                >
                                    <label>Block</label>

                                    <Dropdown
                                        v-model="form.selected_block"
                                        :options="blocks"
                                        optionLabel="number"
                                        optionValue="number"
                                        placeholder="Select Block"
                                        @change="getBlockLot"
                                        :class="{
                                            'p-invalid': error_selected_block,
                                        }"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_selected_block"
                                        >{{ error_selected_block }}</label
                                    >
                                </div>

                                <div
                                    v-if="
                                        form.selected_role != 'security_officer'
                                    "
                                    class="field col-12 md:col-6"
                                >
                                    <label>Lot</label>

                                    <Dropdown
                                        v-model="form.selected_block_lot"
                                        :options="filteredLots"
                                        optionLabel="number"
                                        optionValue="id"
                                        placeholder="Select Lot"
                                        :class="{
                                            'p-invalid': error_selected_lot,
                                        }"
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
                                    <label>Email</label>
                                    <InputText
                                        type="text"
                                        name="email"
                                        v-model="form.email"
                                        @keydown.enter="onRegisterClick"
                                        :class="{
                                            'p-invalid': error_email,
                                        }"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_email"
                                        >{{ error_email }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-4">
                                    <label>Password</label>
                                    <InputText
                                        type="password"
                                        name="password"
                                        v-model="form.password"
                                        @keydown.enter="onRegisterClick"
                                        :class="{
                                            'p-invalid': error_password,
                                        }"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_password"
                                        >{{ error_password }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-4">
                                    <label>Confirm Password</label>

                                    <InputText
                                        type="password"
                                        name="confirmpassword"
                                        v-model="form.confirm_password"
                                        @keydown.enter="onRegisterClick"
                                        :class="{
                                            'p-invalid': error_confirm_password,
                                        }"
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
            users: computed(() => store.state.users),
        };
    },
    data() {
        return {
            //menu

            menus: null,
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
                selected_block_lot: "",
                email: "",
                password: "",
                confirm_password: "",
                age: "",
                contact_num: "",
                selected_role: "",
                verified: "",
                has_voted: "",
                status: "",
            },

            first_name: null,
            last_name: null,
            gender: null,
            block_lot_id: null,
            email: null,
            password: null,
            confirm_password: null,
            verify: 1,
            has_voted: 0,
            age: null,
            contact_num: null,
            selected_role: null,
            user: null,
            role: [
                { role: "admin" },
                { role: "resident" },
                { role: "officer" },
                { role: "security_officer" },
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

            role: [{ role: "admin" }, { role: "resident" }, { role: "security_officer" }, { role: "officer" }],
           
        };
    },
    methods: {
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
        toggle(data) {
           
            this.menus = [
                {
                    label: "Update User",
                    icon: "pi pi-pencil",
                    command: () => {
                        this.updateUser(data);
                    },
                },
                
            ];

            this.$refs.menu.toggle(event);
            this.populateFields(data);
        },
        populateFields(data) {
            this.id = data.id;
            this.name = data.name;
            this.position = data.position;
        },
        clearFilter() {
            this.filters["lot.block.number"].value = null;
            this.filters["lot.number"].value = null;
            this.filters["role"].value = null;
           
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

                "lot.block.number": {
                    value: null,
                    matchMode: FilterMatchMode.EQUALS,
                },
                "lot.number": {
                    value: null,
                    matchMode: FilterMatchMode.EQUALS,
                },
                role: {
                    value: null,
                    matchMode: FilterMatchMode.EQUALS,
                },
                
            };
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
                this.$store.dispatch("getAllUsers");
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
            console.log("update", data);
            this.resetFields();
            this.resetErrors();
            this.id = data.id;
            this.updateUserDialog = true;
            this.first_name = data.first_name;
            this.last_name = data.last_name;
            this.gender = data.gender;
            this.email = data.email;
            this.age = data.age;
            this.contact_num = data.contact_num;
            this.selected_role = data.role;
            this.selected_block = data.block_lot.block.id;
            this.getBlockLot();
            this.selected_block_lot = data.block_lot.id;
            this.form.first_name = data.first_name;
            this.form.last_name = data.last_name;
            this.form.gender = data.gender;
            if (data.role != "security_officer") {
                this.form.selected_block = data.lot.block.number;
                this.getBlockLot();
                this.form.selected_block_lot = data.lot.id;
            }

            this.form.email = data.email;
            this.form.age = data.age;
            this.form.contact_num = data.contact_num;
            this.form.selected_role = data.role;
            this.form.verified = data.verified;
            this.form.has_voted = data.has_voted;
            this.form.status = data.status;
        },
        async confirmUpdateUser() {
            this.process = true;
            await axios({
                method: "put",
                url: "/api/user/" + this.id,
                data: {
                    first_name: this.form.first_name,
                    last_name: this.form.last_name,
                    gender: this.form.gender,
                    block_lot_id: this.form.selected_block_lot,
                    
                    verified: this.form.verified,
                    has_voted: this.form.has_voted,
                    age: this.form.age,
                    contact_num: this.form.contact_num,
                    role: this.form.selected_role,
                    status: this.form.status,

                    
                },
            })
                .then(() => {
                    this.$toast.add({
                        severity: "success",
                        summary: "Successful Request",
                        detail: "Updated User",
                        life: 3000,
                    });
                    this.$store.dispatch("getAllUsers");
                    this.resetFields();
                    this.updateUserDialog = false;
                    this.process = false;
                })
                .catch((err) => {
                    console.log(err.response);
                    this.resetErrors();
                    this.validate(err);
                    this.process = false;
                });
        },
        async verifyUser(data) {
            this.process = true;
            console.log("verify", data);
            await axios({
                method: "put",
                url: "/api/user/" + data.id,
                data: {
                    first_name: data.first_name,
                    last_name: data.last_name,
                    gender: data.gender,
                    block_lot_id: data.lot.id,
                    email: data.email,
                    verified: 1,
                    status: data.status,
                    has_voted: data.has_voted,
                    age: data.age,
                    contact_num: data.contact_num,
                    role: data.role,
                },
            })
                .then(() => {
                    this.$toast.add({
                        severity: "success",
                        summary: "Successful",
                        detail: "User Verified",
                        life: 3000,
                    });
                    this.$store.dispatch("getAllUsers");
                    this.resetFields();
                    this.process = false;
                })
                .catch((err) => {
                    console.log(err.response);
                    this.resetErrors();
                    this.validate(err);
                    this.process = false;
                });
        },
        async changeStatus(data) {
            this.process = true;
            console.log("verify", data);
            await axios({
                method: "put",
                url: "/api/user/" + data.id,
                data: {
                    first_name: data.first_name,
                    last_name: data.last_name,
                    gender: data.gender,
                    block_lot_id: data.lot.id,
                    email: data.email,
                    verified: data.verified,
                    status: data.status == "active" ? "inactive" : "active",
                    has_voted: data.has_voted,
                    age: data.age,
                    contact_num: data.contact_num,
                    role: data.role,
                },
            })
                .then(() => {
                    this.$toast.add({
                        severity: "success",
                        summary: "Successful",
                        detail:
                            data.status != "active"
                                ? "User Activated"
                                : "User Deactivated",
                        life: 3000,
                    });
                    this.$store.dispatch("getAllUsers");
                    this.resetFields();
                    this.process = false;
                })
                .catch((err) => {
                    console.log(err.response);
                    this.resetErrors();
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
                    block_lot_id: this.form.selected_block_lot,
                    email: this.form.email,
                    password: this.form.password,
                    confirm_password: this.form.confirm_password,
                    verified: 1,
                    has_voted: 0,
                    age: this.form.age,
                    contact_num: this.form.contact_num,
                    role: this.form.selected_role,
                    status: "active",
                },
            })
                .then(() => {
                    this.registerUserDialog = false;
                    this.resetFields();
                    this.$store.dispatch("getAllUsers");
                    this.$toast.add({
                        severity: "success",
                        summary: "Successful Request",
                        detail: "Registered User",
                        life: 3000,
                    });
                    this.process = false;
                })
                .catch((err) => {
                    console.log(err.response);
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
            if (!this.form.selected_block)
                this.error_selected_block = "The block field is required";
            if (!this.form.selected_block_lot)
                this.error_selected_lot = "The lot field is required";
        },

        getBlockLot() {
            this.form.selected_block_lot = null;
            this.$store.dispatch("lots/getBlockLots", this.form.selected_block);
        },
        getFilterBlockLot() {
            this.$store.dispatch(
                "lots/getBlockLots",
                this.filters["lot.block.number"].value
            );
        },
    },

    created() {
        this.initFilters();
    },
};
</script>

<style></style>
