<template>
    <div>
        <div v-if="loading"></div>
        <div v-else>
            <div v-if="!checkElection">
                <div class="flex justify-content-center">
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
                                    :disabledDates="invalidDates"
                                />
                                <Button
                                    label="Start"
                                    class="ml-2 p-button-primary"
                                    @click="showElectionDialog"
                                />
                            </div>
                            <label style="color: red" v-if="error_date">{{
                                error_date
                            }}</label>
                        </template>
                    </Card>
                </div>

                <div v-for="position in positions" :key="position.id">
                    <hr />
                    <div class="grid flex">
                        <div
                            class="col-12 p-inputgroup flex justify-content-center"
                        >
                            <h4 class="text-center mr-2">
                                {{ position.name }}
                            </h4>
                            <Button
                                icon="pi pi-plus"
                                class="p-button-rounded p-button-success"
                                v-tooltip="`Add ${position.name}`"
                                @click="addCandidate(position.id)"
                            />
                        </div>

                        <div
                            class="col-12 flex justify-content-center flex-wrap"
                        >
                            <div
                                v-for="candidate in candidates"
                                :key="candidate.id"
                            >
                                <Card
                                    v-if="candidate.position_id === position.id"
                                    class="mr-2 m-2"
                                    style="'width: 200px; min-height: 330px'"
                                >
                                    <template #header>
                                        <img
                                            v-if="
                                                candidate.user.profile_pic !==
                                                null
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
                                        <h5 class="text-center">
                                            {{ candidate.user.first_name }}
                                            {{ candidate.user.last_name }}
                                        </h5>
                                    </template>
                                    <template #content>
                                        <div
                                            class="flex justify-content-center"
                                        >
                                            <Button
                                                icon="pi pi-trash"
                                                class="p-button-rounded p-button-secondary mr-2"
                                                @click="
                                                    deleteCandidate(candidate)
                                                "
                                                v-tooltip="'Delete Candidate'"
                                            />
                                            <Button
                                                icon="pi pi-pencil"
                                                class="p-button-rounded p-button-primary"
                                                @click="
                                                    updateCandidate(candidate)
                                                "
                                                v-tooltip="'Edit Candidate'"
                                            />
                                        </div>
                                    </template>
                                </Card>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else>
                <h4 class="text-center">ELECTION IS ON GOING</h4>
                <h3 class="text-center">Voted</h3>
                <h2 class="text-center">
                    {{ number_voted }} out of {{ total_voter }}
                </h2>
                <div v-for="position in positions" :key="position.id">
                    <hr />
                    <div class="grid flex">
                        <div
                            class="col-12 p-inputgroup flex justify-content-center"
                        >
                            <h4 class="text-center mr-2">
                                {{ position.name }}
                            </h4>
                        </div>

                        <div
                            class="col-12 flex justify-content-center flex-wrap"
                        >
                            <div
                                v-for="candidate in candidates"
                                :key="candidate.id"
                            >
                                <Card
                                    v-if="candidate.position_id === position.id"
                                    class="mr-2 m-2"
                                    style="width: 200px; min-height: 350px"
                                >
                                    <template #header>
                                        <img
                                            v-if="
                                                candidate.user.profile_pic !==
                                                null
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
                                        <h5 class="text-center">
                                            {{ candidate.user.first_name }}
                                            {{ candidate.user.last_name }}
                                        </h5>
                                    </template>
                                    <template #content>
                                        <div class="text-center">
                                            <p>Vote count:</p>
                                            {{ candidate.vote_count }}
                                        </div>
                                    </template>
                                </Card>
                            </div>
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

                                <Dropdown
                                    v-model="user_id"
                                    :options="filtered_resident"
                                    optionLabel="full_name"
                                    optionValue="id"
                                    placeholder="Select Candidates"
                                    :class="{
                                        'p-invalid': error_user_id,
                                    }"
                                    class="w-full"
                                    :filter="true"
                                    :showClear="true"
                                >
                                    <template #option="slotProps">
                                        {{
                                            (slotProps.option["full_name"] =
                                                slotProps.option.first_name +
                                                " " +
                                                slotProps.option.last_name)
                                        }}
                                    </template>
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

                                <InputText
                                    v-model="name"
                                    class="w-full"
                                    disabled
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
                            <h6>Starting Date: {{ date_formated[0] }}</h6>
                            <h6>End Date: {{ date_formated[1] }}</h6>
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
            filtered_resident: computed(() => store.state.filtered_resident),
            number_voted: computed(() => {
                let temp = [];
                store.state.users_verified.forEach((elem) => {
                    if (
                        elem.has_voted == 1 &&
                        (elem.role == "resident" || elem.role == "officer")
                    ) {
                        temp.push(elem);
                    }
                    return temp;
                });
                return temp.length;
            }),
            total_voter: computed(() => {
                let temp = [];
                store.state.users_verified.forEach((elem) => {
                    if (elem.role == "resident" || elem.role == "officer") {
                        temp.push(elem);
                    }
                });
                return temp.length;
            }),
        };
    },
    data() {
        return {
            date: null,
            date_formated: null,
            loading: false,
            createCandidateDialog: false,
            deleteCandidateDialog: false,
            updateCandidateDialog: false,
            createElectionDialog: false,
            id: null,
            result: null,
            position_id: null,
            user_id: null,
            name: null,
            election_id: null,
            dateFormatted: null,
            checkElection: null,

            invalidDates: null,
            error_position_id: null,
            error_user_id: null,
            error_date: null,
        };
    },
    methods: {
        convertDate(str) {
            var temp = [];
            str.forEach((element) => {
                var date = new Date(element),
                    mnth = ("0" + (date.getMonth() + 1)).slice(-2),
                    day = ("0" + date.getDate()).slice(-2);
                temp.push([date.getFullYear(), mnth, day].join("-"));
            });
            this.date_formated = temp;
        },
        showWarningDate() {
            this.$toast.add({
                severity: "warn",
                summary: "Warning Message",
                detail: "Choose starting and end date properly",
                life: 3000,
            });
        },
        showStartedElection() {
            this.$toast.add({
                severity: "success",
                summary: "Successful Request",
                detail: "Started Election",
                life: 3000,
            });
        },
        showWarningStartElection() {
            this.$toast.add({
                severity: "warn",
                summary: "Warning Message",
                detail: "Put atleast 2 candidates per position",
                life: 3000,
            });
        },
        showElectionDialog() {
            var validation = null;
            this.positions.forEach((p) => {
                var candidates = [];
                this.candidates.forEach((c) => {
                    if (c.position_id == p.id) {
                        candidates.push(c);
                    }
                });
                if (candidates.length < 2) {
                    ++validation;
                }
            });
            if (this.date === null) {
                this.error_date = "Date field is required";
            } else if (validation) {
                this.showWarningStartElection();
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
                    start_date: this.date_formated[0],
                    end_date: this.date_formated[1],
                },
            })
                .then(async (res) => {
                    this.createElectionDialog = false;
                    this.showStartedElection();
                    this.resetFields();
                    this.checkElectionDate();
                    await axios({
                        method: "post",
                        url: "/api/notification/election",
                        data: {
                            from_user_id: this.$store.state.userLogged.id,
                            message:
                                "election is on going, please vote thank you!",
                            election_id: res.data.id,
                        },
                    })
                        .then(() => {
                            console.log("notify announcement success ");
                        })
                        .catch((e) => {
                            console.log(e.response);
                        });
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
                    this.$store.dispatch("candidates/getAll", this.election_id);
                    this.$store.dispatch("filterResident");
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
            console.log("data", data);
            this.id = data.id;
            this.position_id = data.position.id;
            this.user_id = data.user_id;
            this.name = data.user.first_name + " " + data.user.last_name;
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
                    this.$store.dispatch("candidates/getAll", this.election_id);
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
                    this.$store.dispatch("candidates/getAll", this.election_id);
                    this.$store.dispatch("filterResident");
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
                    this.id = res.data.id;

                    this.result = res.data.result;
                    var end_date = res.data.end_date;
                    // this.$store.state.timeNow.timeNow.datetime
                    var date = new Date(),
                        mnth = ("0" + (date.getMonth() + 1)).slice(-2),
                        day = ("0" + date.getDate()).slice(-2);
                    var date_now = [date.getFullYear(), mnth, day].join("-");

                    if (!this.id) {
                        console.log("NO ELECTION");
                        this.election_id = 1;
                    } else if (this.id && end_date > date_now) {
                        console.log("ELECTION ON GOING 2nd if ");
                        this.checkElection = res.data.end_date;
                    } else {
                        console.log("NO ELECTION 3rd");
                        this.election_id = parseInt(res.data.id) + 1;
                        this.checkElection = null;
                        if (this.result == 0) {
                            axios({
                                method: "put",
                                url: "/api/election/" + this.id,
                                data: {
                                    start_date: res.data.start_date,
                                    end_date: res.data.end_date,
                                    result: 1,
                                },
                            })
                                .then(async () => {
                                    console.log("election ended");
                                    await axios({
                                        method: "post",
                                        url: "/api/notification/election",
                                        data: {
                                            from_user_id:
                                                this.$store.state.userLogged.id,
                                            message:
                                                "election ended, thank you for cooperation!",
                                            election_id: res.data.id,
                                        },
                                    })
                                        .then(() => {
                                            console.log(
                                                "notify announcement success "
                                            );
                                        })
                                        .catch((e) => {
                                            console.log(e.response);
                                        });
                                })
                                .catch((err) => {
                                    console.log(err);
                                });
                        }
                    }
                    this.$store.dispatch("candidates/getAll", this.election_id);
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

        this.$store.dispatch("filterResident");
        this.$store.dispatch("getUsersVerified");
    },
    created() {
        let today = new Date();
        let yesterday = new Date();
        yesterday.setDate(today.getDate() - 1);
        var invalid_dates = [];
        var firstDay = new Date(today.getFullYear(), today.getMonth(), 1);

        for (let i = firstDay.getDate(); i <= yesterday.getDate(); i++) {
            let date = new Date();
            date.setDate(today.getDate() - i);
            invalid_dates.push(date);
        }
        this.invalidDates = invalid_dates;
    },
};
</script>
