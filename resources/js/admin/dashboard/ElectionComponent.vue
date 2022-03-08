<template>
    <div>
        <div v-for="position in positions" :key="position.id">
            <div class="grid">
                <div class="col-12 p-inputgroup flex justify-content-center">
                    <h3 class="text-center mr-2">{{ position.name }}</h3>
                    <Button
                        icon="pi pi-plus"
                        class="p-button-rounded p-button-success"
                        v-tooltip="`Add ${position.name}`"
                        @click="addCandidate(position.id)"
                    />
                </div>

                <div class="col-12 flex justify-content-center flex-wrap">
                    <div v-for="candidate in candidates" :key="candidate.id">
                        <Card
                            v-if="candidate.pos_id === position.id"
                            class="mr-2 m-2"
                            style="width: 232px; min-height: 300px"
                        >
                            <template #header>
                                <img
                                    v-if="candidate.user.profile_pic === null"
                                    src="http://127.0.0.1:8000/storage/images/default-prof-pic.png"
                                    style="height: 10rem"
                                />
                                <img
                                    v-else
                                    src="https://www.primefaces.org/wp-content/uploads/2020/02/primefacesorg-primevue-2020.png"
                                />
                            </template>
                            <template #title>
                                <h4>
                                    {{ candidate.user.first_name }}
                                    {{ candidate.user.last_name }}
                                </h4>
                            </template>
                            <template #subtitle>
                                Block:
                                {{ candidate.user.block_lot.block_id }}
                                Lot: {{ candidate.user.block_lot.number }}
                            </template>
                            <template #footer>
                                <Button
                                    label="Remove"
                                    class="p-button-secondary"
                                    style="width: 100px"
                                    @click="deleteCandidate(candidate)"
                                />
                                <Button
                                    label="Edit"
                                    class="p-button-primary"
                                    style="width: 100px"
                                    @click="updateCandidate(candidate)"
                                />
                            </template>
                        </Card>
                    </div>
                </div>
            </div>
            <hr />
        </div>
        <Card style="width: 23em">
            <template #title> <h5>Start Election</h5> </template>
            <template #content>
                <p>Select start and end date</p>
                <Calendar
                    id="range"
                    v-model="dates2"
                    selectionMode="range"
                    :manualInput="false"
                    :showIcon="true"
                />
                <Button label="Start" class="ml-3 p-button-primary" />
            </template>
            <template #footer> </template>
        </Card>
        <!-- ADD CANDIDATE -->
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
                                v-model="pos_id"
                                :options="positions"
                                optionLabel="name"
                                optionValue="id"
                                placeholder="Select Positions"
                                :class="{
                                    'p-invalid': error_pos_id,
                                }"
                                class="w-full"
                                dis
                            />
                        </div>
                        <label style="color: red" v-if="error_pos_id">{{
                            error_pos_id
                        }}</label>
                        <div class="field col-12 md:col-12">
                            <label>Candidate name</label>
                            <label style="color: red">*</label>
                            <Dropdown
                                v-model="user_id"
                                :options="registeredUsersFname"
                                optionLabel="full_name"
                                optionValue="user.id"
                                placeholder="Select Candidates"
                                :class="{
                                    'p-invalid': error_user_id,
                                }"
                                class="w-full"
                                :filter="true"
                                :showClear="true"
                            >
                            </Dropdown>
                            <label style="color: red" v-if="error_user_id">{{
                                error_user_id
                            }}</label>
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
                            <label style="color: red">*</label>
                            <Dropdown
                                v-model="pos_id"
                                :options="positions"
                                optionLabel="name"
                                optionValue="id"
                                placeholder="Select Positions"
                                :class="{
                                    'p-invalid': error_pos_id,
                                }"
                                class="w-full"
                                dis
                            />
                        </div>
                        <label style="color: red" v-if="error_pos_id">{{
                            error_pos_id
                        }}</label>
                        <div class="field col-12 md:col-12">
                            <label>Candidate name</label>
                            <label style="color: red">*</label>
                            <Dropdown
                                v-model="user_id"
                                :options="registeredUsersFname"
                                optionLabel="full_name"
                                optionValue="user.id"
                                placeholder="Select Candidates"
                                :class="{
                                    'p-invalid': error_user_id,
                                }"
                                class="w-full"
                                :filter="true"
                                :showClear="true"
                            >
                            </Dropdown>
                            <label style="color: red" v-if="error_user_id">{{
                                error_user_id
                            }}</label>
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
            v-model:visible="deleteCandidateDialog"
            :style="{ width: '500px' }"
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
                            >Are you sure you want to delete candidate
                            <b> {{ name }} </b>?</span
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
import { computed } from "vue";
import { useStore } from "vuex";
import axios from "axios";
export default {
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
            dates2: null,
            loading: false,
            createCandidateDialog: false,
            deleteCandidateDialog: false,
            updateCandidateDialog: false,

            id: null,
            pos_id: null,
            user_id: null,
            name: null,

            error_pos_id: null,
            error_user_id: null,
        };
    },
    methods: {
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
        deleteCandidate(data) {
            this.id = data.id;
            this.name =
                data.position.name +
                " - " +
                data.user.first_name +
                " " +
                data.user.last_name;
            this.deleteCandidateDialog = true;
        },
        updateCandidate(data) {
            this.resetFields();
            this.resetErrors();
            this.id = data.id;
            this.pos_id = data.position.id;
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
                    pos_id: this.pos_id,
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
        async onCreatePositionsClick() {
            this.loading = true;
            await axios({
                method: "post",
                url: "/api/candidate",
                data: {
                    pos_id: this.pos_id,
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
                    console.log(err.response);
                    this.resetErrors();
                    this.validate(err.response.data.errors);
                    this.loading = false;
                });
        },
        addCandidate(pos_id) {
            this.resetFields();
            this.resetErrors();
            this.pos_id = pos_id;
            this.createCandidateDialog = true;
        },
        resetFields() {
            this.id = null;
            this.pos_id = null;
            this.user_id = null;
        },
        resetErrors() {
            this.error_pos_id = "";
            this.error_user_id = "";
        },
        validate(error) {
            if (error.pos_id) this.error_pos_id = error.pos_id[0];
            if (error.user_id) this.error_user_id = error.user_id[0];
        },
    },
};
</script>
