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
                        :value="emergency_contact_details"
                        :filters="filters"
                        breakpoint="1230px"
                        :paginator="true"
                        :rows="10"
                    >
                        <template #empty> No registered users found </template>
                        <template #loading> Loading Users </template>

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
                                            data.name,
                                            data.number,
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
                        header="Update Emergency Contact"
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
                                <label><h6>Emergency Information</h6></label>
                            </div>

                            <div class="p-fluid formgrid grid">
                                <div class="field col-12 md:col-6">
                                    <label>Name</label>

                                    <InputText
                                        id="name"
                                        type="text"
                                        v-model="form.name"
                                        @keydown.enter="onRegisterClick"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_name"
                                        >{{ error_name }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-6">
                                    <label>Contact Details</label>

                                    <Textarea
                                        v-model="form.number"
                                        :autoResize="true"
                                        :class="{
                                            'p-invalid': error_number,
                                        }"
                                        class="w-full"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_number"
                                        >{{ error_number }}</label
                                    >
                                </div>
                            </div>
                        </div>
                        <template #footer>
                            <Button
                                label="Cancel"
                                icon="pi pi-times"
                                class="p-button-text"
                                @click="updateContactDialog = false"
                            />
                            <Button
                                label="Update"
                                icon="pi pi-check"
                                class="p-button-text p-button-success"
                                @click="confirmUpdateContact"
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
                                <label><h6>Emergency Information</h6></label>
                            </div>

                            <div class="p-fluid formgrid grid">
                                <div class="field col-12 md:col-6">
                                    <label>Name</label>

                                    <InputText
                                        id="firstname"
                                        type="text"
                                        v-model="form.name"
                                        @keydown.enter="onRegisterClick"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_name"
                                        >{{ error_name }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-6">
                                    <label>Contact Details</label>
                                    <Textarea
                                        v-model="form.number"
                                        :autoResize="true"
                                        :class="{
                                            'p-invalid': error_number,
                                        }"
                                        class="w-full"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_number"
                                        >{{ error_number }}</label
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
                () =>
                    store.state.emergency_contact_details
                        .emergency_contact_details
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
                name: "",
                number: "",
            },

            user_id: null,

            error_name: "",
            error_number: "",
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
            } else if (color == "security officer") {
                return "bg-yellow-500";
            } else {
                return "bg-yellow-800";
            }
        },
        deleteUser(name, number, id) {
            this.id = id;
            this.name = name + " " + number;
            this.deleteUserDialog = true;
        },
        async confirmDeleteItem() {
            try {
                this.deleteUserDialog = false;
                this.process = true;
                await axios({
                    method: "delete",
                    url: "/api/emergency_contact_detail/" + this.id,
                });
                this.$store.dispatch("emergency_contact_details/getAll");
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
            //console.log(data);
            this.resetFields();
            this.resetErrors();
            this.id = data.id;
            this.updateContactDialog = true;
            this.form.name = data.name;
            this.form.number = data.number;
            //console.log(this.$store.state.userLogged.id);
        },
        async confirmUpdateContact() {
            this.process = true;
            await axios({
                method: "put",
                url: "/api/emergency_contact_detail/" + this.id,
                data: {
                    name: this.form.name,
                    number: this.form.number,
                    user_id: this.$store.state.userLogged.id,
                },
            })
                .then(() => {
                    this.$toast.add({
                        severity: "success",
                        summary: "Successful Request",
                        detail: "Updated Emergency Contact",
                        life: 3000,
                    });
                    this.$store.dispatch("emergency_contact_details/getAll");
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
            this.form.name = null;
            this.form.number = null;
            this.resetFields();
            this.resetErrors();
        },
        async onRegisterClick() {
            this.process = true;
            await axios({
                method: "post",
                url: "/api/emergency_contact_detail",
                data: {
                    name: this.form.name,
                    number: this.form.number,
                    user_id: this.$store.state.userLogged.id,
                },
            })
                .then(() => {
                    this.registerUserDialog = false;
                    this.resetFields();
                    this.$store.dispatch("emergency_contact_details/getAll");
                    this.$toast.add({
                        severity: "success",
                        summary: "Successful Request",
                        detail: "Added Emergency Contact",
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
                name: "",
                number: "",
            };
        },
        resetErrors() {
            this.error_name = "";
            this.error_number = "";
        },
        validate(error) {
            if (error.response.data.errors.name)
                this.error_name = error.response.data.errors.name[0];
            if (error.response.data.errors.number)
                this.error_number = error.response.data.errors.number[0];
        },
    },
    created() {
        this.initFilters();
    },
};
</script>

<style></style>
