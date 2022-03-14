<template>
    <div>
        <Toast />
        <div class="grid">
            <div class="col-12">
                <h1>Candidates</h1>
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
                                    label="Add Candidate"
                                    icon="pi pi-plus"
                                    class="p-button-success p-mr-2"
                                    @click="createCandidate"
                                />
                            </div>
                        </template>
                    </Toolbar>
                </div>
            </div>
            <div class="grid">
                <div class="col-12">
                    <DataTable
                        :value="candidates"
                        :filters="filters"
                        breakpoint="1230px"
                    >
                        <template #empty> No candidates found </template>
                        <Column header="Position name" field="position.name">
                        </Column>
                        <Column header="Candidate name">
                            <template #body="{ data }">
                                {{ data.user.first_name }}
                                {{ data.user.last_name }}
                            </template>
                        </Column>

                        <Column header="Actions" field="actions">
                            <template #body="{ data }">
                                <Button
                                    icon="pi pi-pencil"
                                    class="p-button-rounded p-button-primary mr-2"
                                    @click="updateCandidate(data)"
                                />
                                <Button
                                    icon="pi pi-trash"
                                    class="p-button-rounded p-button-danger"
                                    @click="
                                        deleteCandidate(
                                            data.user.first_name,
                                            data.user.last_name,
                                            data.position.name,
                                            data.id
                                        )
                                    "
                                />
                            </template>
                        </Column>
                    </DataTable>

                    <Dialog
                        v-model:visible="deleteCandidateDialog"
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
                                        candidate <b> {{ name }} </b>?</span
                                    >
                                </div>
                            </div>
                        </div>
                        <template #footer>
                            <Button
                                label="Cancel"
                                icon="pi pi-times"
                                class="p-button-text"
                                @click="deleteCandidateDialog = false"
                            />
                            <Button
                                label="Delete"
                                icon="pi pi-check"
                                class="p-button-text p-button-danger"
                                @click="confirmDeleteCandidate"
                            />
                        </template>
                    </Dialog>
                    <Dialog
                        v-model:visible="updateCandidateDialog"
                        :style="{ width: '500px' }"
                        header="Update Position"
                        :modal="true"
                    >
                        <div class="grid">
                            <div class="col-12">
                                <div class="field">
                                    <div class="field col-12 md:col-12">
                                        <label>Position name</label>
                                        <label
                                            style="color: red"
                                            v-if="!position_id"
                                            >*</label
                                        >
                                        <Dropdown
                                            v-model="position_id"
                                            :options="positions"
                                            optionLabel="name"
                                            optionValue="id"
                                            placeholder="Select Positions"
                                            class="w-full"
                                        />
                                    </div>
                                    <div class="field col-12 md:col-12">
                                        <label>Candidate name</label>
                                        <label
                                            style="color: red"
                                            v-if="!user_id"
                                            >*</label
                                        >
                                        <Dropdown
                                            v-model="user_id"
                                            :options="registeredUsersFname"
                                            optionLabel="full_name"
                                            optionValue="user.id"
                                            placeholder="Select Candidates"
                                            class="w-full"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <template #footer>
                            <Button
                                label="Cancel"
                                icon="pi pi-times"
                                class="p-button-text"
                                @click="updateCandidateDialog = false"
                            />
                            <Button
                                label="Update"
                                icon="pi pi-check"
                                class="p-button-text p-button-warning"
                                @click="confirmUpdateCandidate"
                            />
                        </template>
                    </Dialog>
                    <Dialog
                        v-model:visible="createCandidateDialog"
                        :style="{ width: '500px' }"
                        header="Add Candidate"
                        :modal="true"
                    >
                        <div class="grid">
                            <div class="col-12">
                                <div class="field">
                                    <div class="field col-12 md:col-12">
                                        <label>Position name</label>
                                        <label style="color: red">*</label>
                                        <Dropdown
                                            v-model="position_id"
                                            :options="positions"
                                            optionLabel="name"
                                            optionValue="id"
                                            placeholder="Select Positions"
                                            class="w-full"
                                        />
                                    </div>
                                    <label
                                        style="color: red"
                                        v-if="error_position_id"
                                        >{{ error_position_id }}</label
                                    >
                                    <div class="field col-12 md:col-12">
                                        <label>Candidate name</label>
                                        <label style="color: red">*</label>
                                        <Dropdown
                                            v-model="user_id"
                                            :options="registeredUsersFname"
                                            optionLabel="full_name"
                                            optionValue="user.id"
                                            placeholder="Select Candidates"
                                            class="w-full"
                                        />
                                        <label
                                            style="color: red"
                                            v-if="error_user_id"
                                            >{{ error_user_id }}</label
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <template #footer>
                            <Button
                                label="Cancel"
                                icon="pi pi-times"
                                class="p-button-text"
                                @click="createCandidateDialog = false"
                            />
                            <Button
                                label="Create"
                                icon="pi pi-check"
                                class="p-button-text p-button-success"
                                @click="onCreatePositionsClick"
                            />
                        </template>
                    </Dialog>
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
    </div>
</template>

<script>
import axios from "axios";
import { FilterMatchMode } from "primevue/api";
import { computed } from "vue";
import { useStore } from "vuex";
// import store from "../store/store";

export default {
    name: "CandidateComponent",
    setup() {
        const store = useStore();

        return {
            positions: computed(() => store.state.positions.positions),
            candidates: computed(() => store.state.candidates.candidates),
            registeredUsers: computed(
                () => store.state.registeredUsers.registeredUsers
            ),
            registeredUsersFname: computed(
                () => store.state.registeredUsersFname.registeredUsers
            ),
        };
    },
    data() {
        return {
            filters: {},

            loading: false,
            createCandidateDialog: false,
            deleteCandidateDialog: false,
            updateCandidateDialog: false,

            id: null,
            position_id: null,
            user_id: null,
            name: null,

            error_position_id: null,
            error_user_id: null,
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

        deleteCandidate(first_name, last_name, name, id) {
            this.id = id;
            this.name = name + " - " + first_name + " " + last_name;
            this.deleteCandidateDialog = true;
        },
        showDeleteCandidatetToast() {
            this.$toast.add({
                severity: "success",
                summary: "Successful Request",
                detail: "Deleted Candidate",
                life: 3000,
            });
        },
        async confirmDeleteCandidate() {
            this.loading = true;
            await axios({
                method: "delete",
                url: "/api/candidate/" + this.id,
            })
                .then(() => {
                    this.deleteCandidateDialog = false;
                    this.$store.dispatch("candidates/getAll");
                    this.showDeleteCandidatetToast();
                    this.loading = false;
                })
                .catch((err) => {
                    console.log(err.response);
                    this.resetErrors();
                    this.loading = false;
                });
        },

        updateCandidate(data) {
            this.resetFields();
            this.resetErrors();
            this.id = data.id;
            this.position_id = data.position.id;
            this.user_id = data.user.id;
            this.updateCandidateDialog = true;
        },
        showUpdateCandidateToast() {
            this.$toast.add({
                severity: "success",
                summary: "Successful Request",
                detail: "Updated Candidate",
                life: 3000,
            });
        },
        async confirmUpdateCandidate() {
            this.loading = true;
            await axios({
                method: "put",
                url: "/api/candidate/" + this.id,
                data: {
                    position_id: this.position_id,
                    user_id: this.user_id,
                },
            })
                .then(() => {
                    this.updateCandidateDialog = false;
                    this.$store.dispatch("candidates/getAll");
                    this.loading = false;
                    this.showUpdateCandidateToast();
                })
                .catch((err) => {
                    this.resetErrors();
                    this.validate(err.response.data.errors);
                    this.loading = false;
                });
        },

        showCreateCandidateToast() {
            this.$toast.add({
                severity: "success",
                summary: "Successful Request",
                detail: "Added Candidate",
                life: 3000,
            });
        },
        //REGISTER POSITION
        createCandidate(position_id) {
            this.resetFields();
            this.resetErrors();
            this.position_id = position_id;
            this.createCandidateDialog = true;
        },
        async onCreatePositionsClick() {
            this.loading = true;
            await axios({
                method: "post",
                url: "/api/candidate",
                data: {
                    position_id: this.position_id,
                    user_id: this.user_id,
                },
            })
                .then(() => {
                    this.createCandidateDialog = false;
                    this.$store.dispatch("candidates/getAll");
                    this.showCreateCandidateToast();
                    this.loading = false;
                })
                .catch((err) => {
                    this.resetErrors();
                    this.validate(err.response.data.errors);
                    this.loading = false;
                });
        },

        resetFields() {
            this.id = null;
            this.position_id = null;
            this.user_id = null;
        },
        resetErrors() {
            this.error_position_id = "";
            this.error_user_id = "";
        },
        validate(error) {
            if (error.position_id)
                this.error_position_id = error.position_id[0];
            if (error.user_id) this.error_user_id = error.user_id[0];
        },
        refreshList() {},
    },
    created() {
        this.initFilters();
    },
    mounted() {},
};
</script>

<style scoped></style>
