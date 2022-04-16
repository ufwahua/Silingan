<template>
    <div>
        <Fieldset class="mb-3">
            <template #legend>
                <span>
                    Emergency Contact Details

                    <Button
                        icon="pi pi-plus"
                        class="ml-2 p-button-rounded p-button-outlined p-button-primary"
                        v-tooltip="`Add Emergency Contact`"
                        @click="showAddEmergencyContactDialog"
                /></span>
            </template>

            <div v-if="emergency_contacts" class="card">
                <DataTable
                    :value="emergency_contacts"
                    :filters="filters"
                    :paginator="true"
                    breakpoint="1300px"
                    :rows="10"
                >
                    <template #empty> No registered users found </template>
                    <template #loading> Loading Users </template>

                    <Column header="Contact Name" field="name">
                        <template #body="{ data }">
                            {{ data.name }}
                        </template>
                    </Column>
                    <Column header="Contact Number" field="contact_number">
                        <template #body="{ data }">
                            {{ data.contact_number }}
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
            </div>
            <div v-else class="card flex justify-content-center">
                <p>
                    You haven't added anyone to your emergency contact details.
                </p>
            </div>
        </Fieldset>

        <!-- Add Modal -->
        <Dialog
            v-model:visible="addEmergencyContactDialog"
            :style="{ width: '500px' }"
            header="Add Emergency Contact"
            :modal="true"
            :draggable="false"
        >
            <div class="grid">
                <div class="col-12">
                    <div class="p-fluid mb-2">
                        <h6>Name</h6>
                        <InputText
                            v-model="name"
                            :class="{ 'p-invalid': error_name }"
                        />
                        <small v-if="error_name" class="p-error">{{
                            error_name
                        }}</small>
                    </div>
                </div>
                <div class="col-12">
                    <div class="p-fluid mb-2">
                        <h6>Contact Number</h6>
                        <div class="p-inputgroup">
                            <span class="p-inputgroup-addon"> +63 </span>
                            <InputMask
                                mask="(999) 99-999-9999"
                                placeholder="(639) 99-999-9999"
                                id="contact_num"
                                type="text"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                v-model="contact_number"
                                :class="{
                                    'p-invalid': error_contact_number,
                                }"
                            />
                        </div>

                        <small v-if="error_contact_number" class="p-error">{{
                            error_contact_number
                        }}</small>
                    </div>
                </div>
            </div>

            <template #footer>
                <Button
                    label="Cancel"
                    class="p-button-text p-button-danger"
                    @click="addEmergencyContactDialog = false"
                />
                <Button
                    label="Confirm"
                    class="p-button p-button-primary"
                    @click="addEmergencyContact"
                />
            </template>
        </Dialog>
        <!-- Update Modal -->
        <Dialog
            v-model:visible="updateEmergencyContactDialog"
            :style="{ width: '500px' }"
            header="Update Emergency Contact"
            :modal="true"
            :draggable="false"
        >
            <div class="grid">
                <div class="col-12">
                    <div class="p-fluid mb-2">
                        <h6>Name</h6>
                        <InputText
                            v-model="name"
                            :class="{ 'p-invalid': error_name }"
                        />
                        <small v-if="error_name" class="p-error">{{
                            error_name
                        }}</small>
                    </div>
                </div>
                <div class="col-12">
                    <div class="p-fluid mb-2">
                        <h6>Contact Number</h6>
                        <div class="p-inputgroup">
                            <span class="p-inputgroup-addon"> +63 </span>
                            <InputMask
                                mask="(999) 99-999-9999"
                                placeholder="(639) 99-999-9999"
                                id="contact_num"
                                type="text"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                v-model="contact_number"
                                :class="{
                                    'p-invalid': error_contact_number,
                                }"
                            />
                        </div>

                        <small v-if="error_contact_number" class="p-error">{{
                            error_contact_number
                        }}</small>
                    </div>
                </div>
            </div>
            <template #footer>
                <Button
                    label="Cancel"
                    class="p-button-text p-button-danger"
                    @click="updateEmergencyContactDialog = false"
                />
                <Button
                    label="Confirm"
                    class="p-button p-button-primary"
                    @click="updateContact"
                />
            </template>
        </Dialog>
        <!-- Delete Modal -->
        <Dialog
            v-model:visible="deleteEmergencyContactDialog"
            :style="{ width: '450px' }"
            header="Delete Emergency Contact?"
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
                            >Are you sure you want to delete <b>{{ name }}</b
                            >?</span
                        >
                    </div>
                </div>
            </div>
            <template #footer>
                <Button
                    label="Cancel"
                    class="p-button-text"
                    @click="deleteEmergencyContactDialog = false"
                />
                <Button
                    label="Delete"
                    class="p-button-danger"
                    @click="confirmDeleteItem"
                />
            </template>
        </Dialog>
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
import { computed } from "vue";
import { useStore } from "vuex";

export default {
    name: "EmergencyContactDetailComponent",

    setup() {
        const store = useStore();
        return {
            emergency_contacts: computed(
                () => store.state.emergency_contact_details.emergency_contacts
            ),
        };
    },
    data() {
        return {
            loading: false,
            menus: null,
            addEmergencyContactDialog: false,
            updateEmergencyContactDialog: false,
            deleteEmergencyContactDialog: false,
            //Emergency Contact dialog

            name: null,
            user_id: null,
            contact_number: null,

            error_name: null,
            error_contact_number: null,
        };
    },
    methods: {
        toggle(data) {
            this.menus = [
                {
                    label: "Update Contact",
                    icon: "pi pi-user-edit",
                    command: () => {
                        this.showUpdateEmergencyContact();
                    },
                },
                {
                    label: "Delete Contact",
                    icon: "pi pi-trash",
                    command: () => {
                        this.showDeleteEmergencyContact();
                    },
                },
            ];

            this.$refs.menu.toggle(event);
            this.populateFields(data);
        },
        populateFields(data) {
            this.resetErrors();
            this.resetFields();
            this.id = data.id;
            this.name = data.name;
            this.user_id = data.user_id;
            this.contact_number = data.contact_number;
        },
        showDeleteEmergencyContact() {
            this.deleteEmergencyContactDialog = true;
        },
        async confirmDeleteItem() {
            this.loading = true;
            await axios({
                method: "delete",
                url: "/api/emergency-contact-detail/" + this.id,
            })
                .then((res) => {
                    this.deleteEmergencyContactDialog = false;
                    this.$store.dispatch(
                        "emergency_contact_details/getContacts",
                        this.$store.state.userLogged.id
                    );
                    this.loading = false;
                    this.$toast.add({
                        severity: "success",
                        summary: "Successful Request",
                        detail: "Deleted Contact",
                        life: 3000,
                    });
                })
                .catch((error) => {
                    this.loading = false;
                    console.log(err.response);
                });
        },
        showAddEmergencyContactDialog() {
            this.resetFields();
            this.resetErrors();
            this.addEmergencyContactDialog = true;
        },
        async addEmergencyContact() {
            this.loading = true;
            await axios({
                method: "post",
                url: "/api/emergency-contact-detail",
                data: {
                    name: this.name,
                    contact_number: this.contact_number,
                    user_id: this.$store.state.userLogged.id,
                },
            })
                .then(() => {
                    this.addEmergencyContactDialog = false;
                    this.resetFields();
                    this.$store.dispatch(
                        "emergency_contact_details/getContacts",
                        this.$store.state.userLogged.id
                    );
                    this.$toast.add({
                        severity: "success",
                        summary: "Successful Request",
                        detail: "Added Emergency Contact",
                        life: 3000,
                    });
                    this.loading = false;
                })
                .catch((err) => {
                    this.resetErrors();
                    this.validate(err);
                    this.loading = false;
                });
        },
        showUpdateEmergencyContact() {
            this.updateEmergencyContactDialog = true;
        },
        async updateContact() {
            this.loading = true;
            await axios({
                method: "put",
                url: "/api/emergency-contact-detail/" + this.id,
                data: {
                    name: this.name,
                    contact_number: this.contact_number,
                    user_id: this.$store.state.userLogged.id,
                },
            })
                .then((res) => {
                    this.updateEmergencyContactDialog = false;
                    this.$toast.add({
                        severity: "success",
                        summary: "Successful Request",
                        detail: "Updated Contact",
                        life: 3000,
                    });
                    this.$store.dispatch(
                        "emergency_contact_details/getContacts",
                        this.$store.state.userLogged.id
                    );
                    this.loading = false;
                })
                .catch((err) => {
                    console.log(err.response);
                    this.resetErrors();
                    this.validate(err);
                    this.loading = false;
                });
        },
        validate(error) {
            if (error.response.data.errors.name)
                this.error_name = error.response.data.errors.name[0];
            if (error.response.data.errors.contact_number)
                this.error_contact_number =
                    error.response.data.errors.contact_number[0];
        },
        resetFields() {
            this.name = null;
            this.user_id = null;
            this.contact_number = null;
        },
        resetErrors() {
            this.error_name = null;
            this.error_contact_number = null;
        },
    },
    mounted() {
        this.$store.dispatch(
            "emergency_contact_details/getContacts",
            this.$store.state.userLogged.id
        );
    },
};
</script>
