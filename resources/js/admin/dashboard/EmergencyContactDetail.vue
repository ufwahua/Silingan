<template>
    <div>
        <Toast />
        <div class="grid">
            <div class="col-12">
                <h1>Emergency Contact Details</h1>
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
                        :value="emergency_contact_details"
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
                        <Column header="User Firstname" field="user.first_name">
                        </Column>
                        <Column header="User Lastname" field="user.last_name">
                        </Column>
                        <Column header="Contact Name" field="name">
                            <template #body="{ data }">
                                {{ data.name }}
                            </template>
                        </Column>
                        <Column header="Contact Number" field="number">
                            <template #body="{ data }">
                                {{ data.number }}
                            </template>
                        </Column>

                        <Column header="Actions" field="actions">
                            <template #body="{ data }">
                                <Button
                                    icon="pi pi-pencil"
                                    class="p-button-rounded p-button-primary mr-2"
                                    @click="updateContact(data)"
                                />
                                <Button
                                    icon="pi pi-trash"
                                    class="p-button-rounded p-button-danger"
                                    @click="
                                        deleteUser(
                                            data.contact_name,
                                            data.contact_number,
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
                        v-model:visible="updateContactDialog"
                        :style="{ width: '500px' }"
                        header="Update Contact"
                        :modal="true"
                    >
                        <div class="grid">
                            <div class="col-12 title-form">
                                <label><h6>User Information</h6></label>
                            </div>

                            <div class="p-fluid formgrid grid">
                                <div class="field col-12 md:col-6">
                                    <label for="first_name">Firstname</label>
                                    <label
                                        style="color: red"
                                        for="first_name"
                                        v-if="!first_name"
                                        >*</label
                                    >
                                    <InputText
                                        id="firstname"
                                        type="text"
                                        v-model="first_name"
                                        disabled="true"
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
                                        v-if="!last_name"
                                        >*</label
                                    >
                                    <InputText
                                        id="last_name"
                                        type="text"
                                        v-model="last_name"
                                        disabled="true"
                                    />
                                    <label
                                        style="color: red"
                                        for="lastname"
                                        v-if="error_last_name"
                                        >{{ error_last_name }}</label
                                    >
                                </div>
                            <div class="col-12 title-form">
                                <label><h6>Contact Information</h6></label>
                            </div>

                            <div class="p-fluid formgrid grid">
                                <div class="field col-12 md:col-6">
                                    <label for="first_name">Contact Name</label>
                                    <label
                                        style="color: red"
                                        for="contact_name"
                                        v-if="!contact_name"
                                        >*</label
                                    >
                                    <InputText
                                        id="contact_name"
                                        type="text"
                                        v-model="contact_name"
                                    />
                                    <label
                                        style="color: red"
                                        for="Contact_name"
                                        v-if="error_contact_name"
                                        >{{ error_contact_name }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-6">
                                    <label for="contact_number">Contact Number</label>
                                    <label
                                        style="color: red"
                                        for="contact_number"
                                        v-if="!contact_number"
                                        >*</label
                                    >
                                    <InputText
                                        id="contact_number"
                                        type="text"
                                        v-model="contact_number"
                                    />
                                    <label
                                        style="color: red"
                                        for="contact_number"
                                        v-if="contact_number"
                                        >{{ error_contact_number }}</label
                                    >
                                </div>
                            </div>
                            </div>
                        </div>
                        <template >
                            <Button
                                label="Cancel"
                                icon="pi pi-times"
                                class="p-button-text"
                                @click="updateContactDialog = false"
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
                                    <label for="contact_name">Firstname</label>
                                    <label
                                        style="color: red"
                                        for="contact_name"
                                        v-if="!form.contact_name"
                                        >*</label
                                    >
                                    <InputText
                                        id="firstname"
                                        type="text"
                                        v-model="form.contact_name"
                                        @keydown.enter="onRegisterClick"
                                    />
                                    <label
                                        style="color: red"
                                        for="contact_name"
                                        v-if="error_contact_name"
                                        >{{ error_contact_name }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-6">
                                    <label for="contact_number">Lastname</label>
                                    <label
                                        style="color: red"
                                        for="contact_number"
                                        v-if="!form.contact_number"
                                        >*</label
                                    >
                                    <InputText
                                        id="contact_number"
                                        type="text"
                                        v-model="form.contact_number"
                                        @keydown.enter="onRegisterClick"
                                    />
                                    <label
                                        style="color: red"
                                        for="contact_number"
                                        v-if="error_contact_number"
                                        >{{ error_contact_number }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-6">
                                    <div>
                                        <label for="gender">Gender</label>
                                        <label
                                            style="color: red"
                                            for="gender"
                                            v-if="!gender"
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
                                                for="form.gender"
                                                v-if="error_gender"
                                                >{{ error_gender }}</label
                                            >
                                        </div>
                                    </div>
                                </div>
                                <div class="formgroup-inline flex justify-content-around">
                                    <label
                                        style="color: red"
                                        for="form.gender"
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
                                        for="form.role"
                                        v-if="error_role"
                                        >{{ error_role }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-12">
                                    <label for="age">Age</label
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
                                        for="selected_block"
                                        v-if="error_selected_block"
                                        >{{ error_selected_block }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-6">
                                    <label for="selected_block_lot">Lot</label>
                                    <label
                                        style="color: red"
                                        for="selected_block_lot"
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
                                        for="selected_block_lot"
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
                                    <label for="form.contact_name">contact_name</label
                                    ><label
                                        style="color: red"
                                        for="form.form.contact_name"
                                        v-if="!form.contact_name"
                                        >*</label
                                    >
                                    <InputText
                                        type="text"
                                        name="contact_name"
                                        v-model="form.contact_name"
                                        @keydown.enter="onRegisterClick"
                                    />
                                    <label
                                        style="color: red"
                                        for="form.contact_name"
                                        v-if="error_contact_name"
                                        >{{ error_contact_name }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-4">
                                    <label for="form.contact_number">contact_number</label
                                    ><label
                                        style="color: red"
                                        for="form.contact_number"
                                        v-if="!form.contact_number"
                                        >*</label
                                    >
                                    <InputText
                                        type="contact_number"
                                        name="contact_number"
                                        v-model="form.contact_number"
                                        @keydown.enter="onRegisterClick"
                                    />
                                    <label
                                        style="color: red"
                                        for="form.contact_number"
                                        v-if="error_contact_number"
                                        >{{ error_contact_number }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-4">
                                    <label for="confirm_contact_number"
                                        >Confirm contact_number</label
                                    >
                                    <label
                                        style="color: red"
                                        for="confirm_contact_number"
                                        v-if="!form.confirm_contact_number"
                                        >*</label
                                    >
                                    <InputText
                                        type="contact_number"
                                        name="confirmcontact_number"
                                        v-model="form.confirm_contact_number"
                                        @keydown.enter="onRegisterClick"
                                    />
                                    <label
                                        style="color: red"
                                        for="confirm_contact_number"
                                        v-if="error_confirm_contact_number"
                                        >{{ error_confirm_contact_number }}</label
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
    name: "EmergencyContactDetailComponent",
    setup() {
        const store = useStore();
        return {
            emergency_contact_details: computed(
                () => store.state.emergency_contact_details.emergency_contact_details
            ),
        };
    },
    data() {
        return {
            isInvalid: false,
            filters: {},
            id: null,
            name: null,
            number: null,
            process: false,
            registerUserDialog: false,
            deleteUserDialog: false,
            updateContactDialog: false,
            form: {
                contact_name: "",
                contact_number: "",
            },

            contact_name: null,
            contact_number: null,

            user: null,

            error_contact_name: "",
            error_contact_number: "",
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
        deleteUser(contact_name, contact_number, id) {
            this.id = id;
            this.name = contact_name + " " + contact_number;
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
        updateContact(data) {
            console.log(data);
            this.resetFields();
            this.resetErrors();
            this.id = data.id;
            this.updateContactDialog = true;
            this.contact_name = data.contact_name;
            this.contact_number = data.contact_number;
            this.gender = data.gender;
            this.selected_block = data.block_lot.block.id;
            this.getBlockLot();
            this.selected_block_lot = data.block_lot.id;
            this.contact_name = data.contact_name;
            this.age = data.age;
            this.contact_num = data.contact_num;
            this.selected_role = data.role;
        },
        async confirmupdateContact() {
            this.process = true;
            await axios({
                method: "put",
                url: "/api/user/" + this.id,
                data: {
                    contact_name: this.contact_name,
                    contact_number: this.contact_number,
                    gender: this.gender,
                    block_lot_id: this.selected_block_lot,
                    contact_name: this.contact_name,
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
                    this.updateContactDialog = false;
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
            this.form.contact_name = null;
            this.resetFields();
            this.resetErrors();
        },
        async onRegisterClick() {
            this.process = true;
            await axios({
                method: "post",
                url: "/api/user",
                data: {
                    contact_name: this.form.contact_name,
                    contact_number: this.form.contact_number,
                    gender: this.form.gender,
                    block_lot_id: this.selected_block_lot,
                    contact_name: this.form.contact_name,
                    contact_number: this.form.contact_number,
                    confirm_contact_number: this.form.confirm_contact_number,
                    verified: 1,
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
            this.selected_block_lot= null;
            this.form = {
                contact_name: "",
                contact_number: "",
                gender: "",
                selected_block: "",
                selected_block_lot: "",
                contact_name: "",
                contact_number: "",
                confirm_contact_number: "",
                age: "",
                contact_num: "",
                selected_role: "resident",
            };
        },
        resetErrors() {
            this.error_contact_name = "";
            this.error_contact_number = "";
            this.error_gender = "";
            this.error_selected_block = "";
            this.error_selected_lot = "";
            this.error_contact_name = "";
            this.error_contact_number = "";
            this.error_confirm_contact_number = "";
            this.error_age = "";
            this.error_contact_num = "";
            this.error_role = "";
        },
        validate(error) {
            if (error.response.data.errors.contact_name)
                this.error_contact_name =
                    error.response.data.errors.contact_name[0];
            if (error.response.data.errors.contact_number)
                this.error_contact_number = error.response.data.errors.contact_number[0];
            if (error.response.data.errors.gender)
                this.error_gender = error.response.data.errors.gender[0];
            if (error.response.data.errors.selected_block)
                this.error_selected_block =
                    error.response.data.errors.selected_block[0];
            if (error.response.data.errors.selected_block_lot)
                this.error_selected_lot =
                    error.response.data.errors.selected_block_lot[0];
            if (error.response.data.errors.contact_name)
                this.error_contact_name = error.response.data.errors.contact_name[0];
            if (error.response.data.errors.contact_number)
                this.error_contact_number = error.response.data.errors.contact_number[0];
            if (error.response.data.errors.confirm_contact_number)
                this.error_confirm_contact_number =
                    error.response.data.errors.confirm_contact_number[0];
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
