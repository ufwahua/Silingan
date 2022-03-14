<template>
    <div>
        <div v-if="loading"></div>
        <div v-else>
            <div v-if="!checkElection" class="flex justify-content-center">
                <Card class="mb-4" style="width: 23em">
                    <template #title> <h4>Start Election</h4> </template>
                    <template #content>
                        <div>
                            <Calendar
                                id="range"
                                :class="{
                                    'p-invalid': error_date,
                                }"
                                v-model="date"
                                selectionMode="range"
                                :manualInput="false"
                                :showIcon="true"
                                dateFormat="mm-dd-yy"
                                placeholder="Select start and end date"
                            />
                            <Button
                                label="Start"
                                class="ml-3 p-button-primary"
                                @click="showElectionDialog"
                            />
                        </div>
                        <label
                            style="color: red"
                            for="position_id"
                            v-if="error_date"
                            >{{ error_date }}</label
                        >
                    </template>
                </Card>
            </div>
            <div v-else class="flex justify-content-center">
                <div class="card mb-4">
                    <h4>ELECTION IS ON GOING</h4>
                </div>
            </div>

            <div v-for="position in positions" :key="position.id">
                <hr />
                <div class="grid flex">
                    <div
                        class="col-12 p-inputgroup flex justify-content-center"
                    >
                        <h4 class="text-center mr-2">{{ position.name }}</h4>
                        <Button
                            v-if="!checkElection"
                            icon="pi pi-plus"
                            class="p-button-rounded p-button-success"
                            v-tooltip="`Add ${position.name}`"
                            @click="addCandidate(position.id)"
                        />
                    </div>

                    <div class="col-12 flex justify-content-center flex-wrap">
                        <div
                            v-for="candidate in candidates"
                            :key="candidate.id"
                        >
                            <Card
                                v-if="candidate.position_id === position.id"
                                class="mr-2 m-2"
                                style="width: 200px; min-height: 300px"
                            >
                                <template #header>
                                    <img
                                        v-if="
                                            candidate.user.profile_pic !== null
                                        "
                                        src="https://www.primefaces.org/wp-content/uploads/2020/02/primefacesorg-primevue-2020.png"
                                        style="height: 7rem"
                                    />
                                    <img
                                        v-else
                                        src="http://127.0.0.1:8000/storage/images/default-prof-pic.png"
                                        style="height: 10rem"
                                    />
                                </template>
                                <template #title>
                                    <h5>
                                        {{ candidate.user.first_name }}
                                        {{ candidate.user.last_name }}
                                    </h5>
                                </template>
                                <template #subtitle>
                                    Block:
                                    {{ candidate.user.block_lot.block_id }}
                                    Lot: {{ candidate.user.block_lot.number }}
                                </template>
                                <template #footer>
                                    <div
                                        v-if="!checkElection"
                                        class="flex justify-content-center"
                                    >
                                        <Button
                                            icon="pi pi-trash"
                                            class="p-button-rounded p-button-secondary mr-2"
                                            @click="deleteCandidate(candidate)"
                                            v-tooltip="'Delete Candidate'"
                                        />
                                        <Button
                                            icon="pi pi-pencil"
                                            class="p-button-rounded p-button-primary"
                                            @click="updateCandidate(candidate)"
                                            v-tooltip="'Edit Candidate'"
                                        />
                                    </div>
                                </template>
                            </Card>
                        </div>
                    </div>
                </div>
            </div>

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
                                    v-model="position_id"
                                    :options="positions"
                                    optionLabel="name"
                                    optionValue="id"
                                    placeholder="Select Positions"
                                    :class="{
                                        'p-invalid': error_position_id,
                                    }"
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
                                    :class="{
                                        'p-invalid': error_user_id,
                                    }"
                                    class="w-full"
                                    :filter="true"
                                    :showClear="true"
                                >
                                </Dropdown>
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
                        class="p-button-text"
                        @click="createCandidateDialog = false"
                    />
                    <Button
                        label="Create"
                        class="p-button-success"
                        @click="onCreatePositionsClick"
                    />
                </template>
            </Dialog>
            <!-- UPDATE CANDIDATE -->
            <Dialog
                v-model:visible="updateCandidateDialog"
                :style="{ width: '500px' }"
                header="Update Candidate"
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
                                    :class="{
                                        'p-invalid': error_position_id,
                                    }"
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
                                    :class="{
                                        'p-invalid': error_user_id,
                                    }"
                                    class="w-full"
                                    :filter="true"
                                    :showClear="true"
                                >
                                </Dropdown>
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
                        class="p-button-text"
                        @click="updateCandidateDialog = false"
                    />
                    <Button
                        label="Update"
                        class="p-button-primary"
                        @click="confirmUpdateCandidate"
                    />
                </template>
            </Dialog>
            <!-- DELETE CANDIDATE -->
            <Dialog
                v-model:visible="deleteCandidateDialog"
                :style="{ width: '500px' }"
                header="Delete Candidate"
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
                        class="p-button-text"
                        @click="deleteCandidateDialog = false"
                    />
                    <Button
                        label="Delete"
                        class="p-button-secondary"
                        @click="confirmDeleteCandidate"
                    />
                </template>
            </Dialog>
            <!-- START ELECTION -->
            <Dialog
                v-model:visible="createElectionDialog"
                :style="{ width: '400px' }"
                header="Start Election?"
                :modal="true"
            >
                <div class="confirmation-content">
                    <div
                        class="grid flex align-items-center justify-content-center"
                    >
                        <div class="col-12">
                            <h6>Starting Date: {{ date[0] }}</h6>
                            <h6>End Date: {{ date[1] }}</h6>
                        </div>
                    </div>
                </div>
                <template #footer>
                    <Button
                        label="Cancel"
                        class="p-button-text"
                        @click="createElectionDialog = false"
                    />
                    <Button
                        label="Start"
                        class="p-button-primary"
                        @click="startElection"
                    />
                </template>
            </Dialog>
            <!-- LOADING -->
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
                () => store.state.registeredUsersFname.registeredUsersFname
            ),
        };
    },
    data() {
        return {
            date: null,
            loading: false,
            createCandidateDialog: false,
            deleteCandidateDialog: false,
            updateCandidateDialog: false,
            createElectionDialog: false,
            id: null,
            position_id: null,
            user_id: null,
            election_id: null,
            name: null,
            dateFormatted: null,
            checkElection: null,

            error_position_id: null,
            error_user_id: null,
            error_date: null,
        };
    },
    methods: {
        validateCandidates() {
            this.positions.forEach((e) => {
                this.candidates.forEach((e2) => {
                    console.log("e" + e);
                    console.log("e2" + e2);
                });
            });
        },
        convertDate(str) {
            var temp = [];
            str.forEach((element) => {
                var date = new Date(element),
                    mnth = ("0" + (date.getMonth() + 1)).slice(-2),
                    day = ("0" + date.getDate()).slice(-2);
                temp.push([date.getFullYear(), mnth, day].join("-"));
            });
            this.date = temp;
        },
        showStartedElection() {
            this.$toast.add({
                severity: "success",
                summary: "Successful Request",
                detail: "Started Election",
                life: 3000,
            });
        },
        showElectionDialog() {
            if (this.date === null) {
                this.error_date = "Date field is required";
            } else {
                this.resetErrors();
                this.convertDate(this.date);
                this.createElectionDialog = true;
            }
        },
        async startElection() {
            this.loading = true;
            await axios({
                method: "post",
                url: "/api/election",
                data: {
                    start_date: this.date[0],
                    end_date: this.date[1],
                },
            })
                .then(() => {
                    this.createElectionDialog = false;
                    this.showStartedElection();
                    this.resetFields();
                    this.checkElectionDate();
                    this.loading = false;
                })
                .catch((err) => {
                    console.log(err.response);
                    this.loading = false;
                });
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
                    election_id: this.election_id,
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
                    position_id: this.position_id,
                    user_id: this.user_id,
                    election_id: this.election_id,
                },
            })
                .then(() => {
                    this.$store.dispatch("candidates/getAll");
                    this.showCreateCandidateToast();
                    this.createCandidateDialog = false;
                    this.loading = false;
                })
                .catch((err) => {
                    console.log(err.response);
                    this.resetErrors();
                    this.validate(err.response.data.errors);
                    this.loading = false;
                });
        },
        addCandidate(position_id) {
            this.resetErrors();
            this.position_id = position_id;
            this.createCandidateDialog = true;
            this.validateCandidates();
            console.log("test");
        },
        resetFields() {
            this.id = null;
            this.position_id = null;
            this.user_id = null;
            this.date = null;
        },
        resetErrors() {
            this.error_position_id = null;
            this.error_user_id = null;
            this.error_date = null;
        },
        validate(error) {
            if (error.position_id)
                this.error_position_id = error.position_id[0];
            if (error.user_id) this.error_user_id = error.user_id[0];
        },
        async checkElectionDate() {
            this.loading = true;
            await axios({
                method: "get",
                url: "/api/election",
            })
                .then(async (res) => {
                    var id = res.data.id;
                    var end_date = res.data.end_date;
                    // this.$store.state.timeNow.timeNow.datetime;
                    var date = new Date(
                            this.$store.state.timeNow.timeNow.datetime
                        ),
                        mnth = ("0" + (date.getMonth() + 1)).slice(-2),
                        day = ("0" + date.getDate()).slice(-2);
                    var date_now = [date.getFullYear(), mnth, day].join("-");
                    console.log(end_date);
                    console.log(date_now);

                    if (!id) {
                        console.log("NO ELECTION");
                        this.election_id = 1;
                    } else if (id && end_date > date_now) {
                        console.log("ELECTION ON GOING 2nd if ");
                        this.checkElection = res.data.end_date;
                    } else {
                        console.log("NO ELECTION 3rd");
                        axios({
                            method: "delete",
                            url: "/api/candidate/election/" + id,
                        })
                            .then(() => {
                                this.election_id = id + 1;
                                this.$store.dispatch("candidates/getAll");
                            })
                            .catch((err) => {
                                console.log(err);
                            });
                    }
                    this.loading = false;
                })
                .catch((err) => {
                    this.election_id = 1;
                    console.log(err.response);
                    this.loading = false;
                });
        },
    },
    mounted() {
        this.$store.dispatch("timeNow/getAll");
        this.checkElectionDate();
        this.$store.dispatch("candidates/getAll");
    },
    created() {},
};
</script>
