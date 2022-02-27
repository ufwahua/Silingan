<template>
    <div>
        <Toast />
        <div class="grid">
            <div class="col-12">
                <h1>Announcement</h1>
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
                                    label="Create"
                                    icon="pi pi-plus"
                                    class="p-button-success p-mr-2"
                                    @click="createAnnouncement"
                                />
                            </div>
                        </template>
                    </Toolbar>
                </div>
            </div>
            <div class="grid">
                <div class="col-12">
                    <DataTable
                        :value="announcements"
                        :filters="filters"
                        breakpoint="1230px"
                    >
                        <template #empty> No announcement found </template>
                        <template #loading> Loading Users </template>
                        <Column header="ID" field="id"> </Column>
                        <Column header="Firstname" field="user.first_name">
                        </Column>
                        <Column header="Lastname" field="user.last_name">
                        </Column>
                        <Column header="Role" field="user.role"> </Column>
                        <Column header="Title" field="title"> </Column>
                        <Column header="Created" field="created_at"> </Column>
                        <Column header="Content" field="content"> </Column>

                        <Column header="Actions" field="actions">
                            <template #body="{ data }">
                                <Button
                                    icon="pi pi-pencil"
                                    class="p-button-rounded p-button-primary mr-2"
                                    @click="updateAnnouncement(data)"
                                />
                                <Button
                                    icon="pi pi-trash"
                                    class="p-button-rounded p-button-danger"
                                    @click="deleteAnnouncement(data)"
                                />
                            </template>
                        </Column>
                    </DataTable>

                    <Dialog
                        v-model:visible="deleteAnnouncementDialog"
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
                                        announcement <b>{{ title }}</b
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
                                @click="deleteAnnouncementDialog = false"
                            />
                            <Button
                                label="Delete"
                                icon="pi pi-check"
                                class="p-button-text p-button-danger"
                                @click="confirmDeleteAnnouncement"
                            />
                        </template>
                    </Dialog>
                    <Dialog
                        v-model:visible="updateAnnouncementDialog"
                        :style="{ width: '500px' }"
                        header="Update Announcement"
                        :modal="true"
                    >
                        <div class="grid">
                            <div class="col-12">
                                <div class="field">
                                    <label for="firstname1">Title</label>
                                    <InputText v-model="title" class="w-full" />
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="field">
                                    <label for="firstname1">Content</label>
                                    <Textarea
                                        v-model="content"
                                        :autoResize="true"
                                        class="w-full"
                                    />
                                </div>
                            </div>
                        </div>
                        <template #footer>
                            <Button
                                label="Cancel"
                                icon="pi pi-times"
                                class="p-button-text"
                                @click="updateAnnouncementDialog = false"
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
                        v-model:visible="createAnnouncementDialog"
                        :style="{ width: '500px' }"
                        header="Create Announcement"
                        :modal="true"
                    >
                        <div class="grid">
                            <div class="col-12">
                                <div class="field">
                                    <label for="firstname1">Title</label>
                                    <InputText v-model="title" class="w-full" />
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="field">
                                    <label for="firstname1">Content</label>
                                    <Textarea
                                        v-model="content"
                                        :autoResize="true"
                                        class="w-full"
                                    />
                                </div>
                            </div>
                        </div>
                        <template #footer>
                            <Button
                                label="Cancel"
                                icon="pi pi-times"
                                class="p-button-text"
                                @click="createAnnouncementDialog = false"
                            />
                            <Button
                                label="Create"
                                icon="pi pi-check"
                                class="p-button-text p-button-success"
                                @click="onCreateAnnouncementClick"
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
                                <span class="block">Processing Request...</span>
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
    name: "AnnouncementComponent",
    setup() {
        const store = useStore();

        return {
            announcements: computed(
                () => store.state.announcements.announcements
            ),
        };
    },
    data() {
        return {
            filters: {},
            // announcements: this.$store.state.announcements.announcements,

            name: null,
            loading: false,
            createAnnouncementDialog: false,
            deleteAnnouncementDialog: false,
            updateAnnouncementDialog: false,
            id: null,
            user_id: null,
            title: null,
            content: null,

            error_title: "",
            error_content: "",
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

        deleteAnnouncement(data) {
            this.id = data.id;
            this.title = data.title;
            this.deleteAnnouncementDialog = true;
        },
        showDeleteAnnouncementToast() {
            this.$toast.add({
                severity: "success",
                summary: "Successful Request",
                detail: "Deleted Announcement",
                life: 3000,
            });
        },
        async confirmDeleteAnnouncement() {
            this.loading = true;
            await axios({
                method: "delete",
                url: "/api/announcement/" + this.id,
            })
                .then(() => {
                    this.deleteAnnouncementDialog = false;
                    this.resetFields();
                    this.$store.dispatch("announcements/getAll");
                    this.showDeleteAnnouncementToast();
                    this.loading = false;
                })
                .catch((err) => {
                    console.log(err.response);
                    this.resetErrors();
                    // this.validate(err);
                    this.loading = false;
                });
        },
        updateAnnouncement(data) {
            this.resetFields();
            this.resetErrors();
            this.id = data.id;
            this.user_id = this.$store.state.userLogged.id;
            this.title = data.title;
            this.content = data.content;
            this.updateAnnouncementDialog = true;
        },
        showUpdateAnnouncementToast() {
            this.$toast.add({
                severity: "success",
                summary: "Successful Request",
                detail: "Updated Announcement",
                life: 3000,
            });
        },
        async confirmUpdateUser() {
            this.loading = true;
            await axios({
                method: "put",
                url: "/api/announcement/" + this.id,
                data: {
                    user_id: this.user_id,
                    title: this.title,
                    content: this.content,
                },
            })
                .then(() => {
                    this.updateAnnouncementDialog = false;
                    this.resetFields();
                    this.$store.dispatch("announcements/getAll");
                    this.showCreateAnnouncementToast();
                    this.loading = false;
                })
                .catch((err) => {
                    console.log(err.response);
                    // this.validate(err);
                    this.loading = false;
                });
        },
        showCreateAnnouncementToast() {
            this.$toast.add({
                severity: "success",
                summary: "Successful Request",
                detail: "Created Announcement",
                life: 3000,
            });
        },
        //REGISTER USER
        createAnnouncement() {
            this.createAnnouncementDialog = true;
            this.resetFields();
            this.resetErrors();
        },
        async onCreateAnnouncementClick() {
            this.loading = true;
            await axios({
                method: "post",
                url: "/api/announcement",
                data: {
                    user_id: this.$store.state.userLogged.id,
                    title: this.title,
                    content: this.content,
                },
            })
                .then(() => {
                    this.createAnnouncementDialog = false;
                    this.resetFields();
                    this.$store.dispatch("announcements/getAll");
                    this.showCreateAnnouncementToast();
                    this.loading = false;
                })
                .catch((err) => {
                    console.log(err.response);
                    this.resetErrors();
                    // this.validate(err);
                    this.loading = false;
                });
        },

        resetFields() {},
        resetErrors() {
            this.error_title = "";
            this.error_content = "";
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
    },
    created() {
        this.initFilters();
    },
};
</script>

<style scoped></style>
