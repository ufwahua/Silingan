<template>
    <div class="mr-5">
        <div v-if="loading"></div>
        <div v-else>
            <div v-if="election_on_going">
                <div v-if="userLogged.has_voted == 0">
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
                                    class="flex flex-column"
                                >
                                    <Button
                                        v-if="
                                            candidate.position_id == position.id
                                        "
                                        label="Primary"
                                        class="p-button-text"
                                        @click="viewUser(candidate)"
                                        v-tooltip="'View Candidate'"
                                    >
                                        <Card
                                            class="mr-2 m-2"
                                            style="
                                                width: 200px;
                                                min-height: 300px;
                                            "
                                        >
                                            <template #header>
                                                <img
                                                    v-if="
                                                        candidate.user
                                                            .profile_pic !==
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
                                                <h5>
                                                    {{
                                                        candidate.user
                                                            .first_name
                                                    }}
                                                    {{
                                                        candidate.user.last_name
                                                    }}
                                                </h5>
                                            </template>
                                        </Card>
                                    </Button>
                                    <div class="flex justify-content-center">
                                        <RadioButton
                                            v-if="
                                                candidate.position_id ==
                                                position.id
                                            "
                                            :name="`${candidate.position.name}`"
                                            :value="`${candidate.id}`"
                                            v-model="
                                                selected_candidate[
                                                    `${candidate.position.name}`
                                                ]
                                            "
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div class="flex justify-content-center mb-3">
                        <Button
                            label="Submit Vote"
                            class="p-button-rounded p-button-primary"
                            @click="validateVote"
                        />
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
                                        v-if="
                                            candidate.position_id ===
                                            position.id
                                        "
                                        class="mr-2 m-2"
                                        style="width: 200px; min-height: 350px"
                                    >
                                        <template #header>
                                            <img
                                                v-if="
                                                    candidate.user
                                                        .profile_pic !== null
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
            </div>

            <div v-else>
                <div>
                    <h4 class="text-center">Current Officers</h4>
                </div>

                <div
                    v-if="officers"
                    class="flex justify-content-center flex-row flex-wrap"
                >
                    <div v-for="officer in officers" :key="officer.id">
                        <Button
                            label="Primary"
                            class="p-button-text w-full"
                            @click="viewUser(officer)"
                            v-tooltip="'View Officer'"
                        >
                            <Card
                                class="mr-2 m-2"
                                style="width: 200px; height: 300px"
                            >
                                <template #header>
                                    <h4 class="text-center mr-2">
                                        {{ officer.position.name }}
                                    </h4>
                                    <img
                                        v-if="officer.profile_pic !== null"
                                        :src="`http://127.0.0.1:8000${officer.profile_pic}`"
                                        style="height: 7rem"
                                    />
                                    <img
                                        v-else
                                        src="http://127.0.0.1:8000/storage/images/default-prof-pic.png"
                                        style="height: 7rem"
                                    />
                                </template>
                                <template #title>
                                    <h5 class="text-center">
                                        {{ officer.first_name }}
                                        {{ officer.last_name }}
                                    </h5>
                                </template>
                            </Card>
                        </Button>
                    </div>
                </div>
                <div v-else class="text-center">No current officers added</div>
                <div v-if="result">
                    <hr />
                    <h2 class="text-center">ELECTION RESULT</h2>
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
                                    v-for="candidate in last_candidates"
                                    :key="candidate.id"
                                >
                                    <Card
                                        v-if="
                                            candidate.position_id == position.id
                                        "
                                        class="mr-2 m-2"
                                        style="width: 200px; min-height: 350px"
                                    >
                                        <template #header>
                                            <img
                                                v-if="
                                                    candidate.user
                                                        .profile_pic !== null
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
            </div>
            <Dialog
                v-model:visible="confirmVoteDialog"
                :style="{ width: '400px' }"
                header="Submit Vote?"
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
                                >Are you sure you want to submit your
                                votes?</span
                            >
                        </div>
                    </div>
                </div>
                <template #footer>
                    <Button
                        label="Cancel"
                        class="p-button-text"
                        @click="confirmVoteDialog = false"
                    />
                    <Button
                        label="Start"
                        class="p-button-primary"
                        @click="submitVote"
                    />
                </template>
            </Dialog>
            <Dialog
                v-model:visible="viewOfficerDialog"
                :style="{ width: '500px' }"
                header="View Officer"
                :modal="true"
            >
                <div class="grid">
                    <div class="p-fluid formgrid grid">
                        <div class="field col-12 md:col-6 mt-2">
                            <label>Firstname</label>

                            <InputText
                                id="firstname"
                                type="text"
                                v-model="form.first_name"
                                :class="{
                                    'p-invalid': error_first_name,
                                }"
                                disabled
                            />
                            <label style="color: red" v-if="error_first_name">{{
                                error_first_name
                            }}</label>
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
                                disabled
                            />
                            <label style="color: red" v-if="error_last_name">{{
                                error_last_name
                            }}</label>
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
                                        :disabled="true"
                                    />
                                    <label class="mb-0 ml-1 mr-5">Male</label>
                                    <RadioButton
                                        name="gender"
                                        value="female"
                                        :class="{
                                            'p-invalid': error_gender,
                                        }"
                                        v-model="form.gender"
                                        :disabled="true"
                                    />
                                    <label class="mb-0 ml-1">Female</label>
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
                                disabled
                            />
                            <label style="color: red" v-if="error_age">{{
                                error_age
                            }}</label>
                        </div>

                        <div class="field col-12 md:col-6">
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
                                disabled
                            />
                            <label
                                style="color: red"
                                v-if="error_selected_block"
                                >{{ error_selected_block }}</label
                            >
                        </div>
                        <div class="field col-12 md:col-6">
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
                                disabled
                            />
                            <label
                                style="color: red"
                                v-if="error_selected_lot"
                                >{{ error_selected_lot }}</label
                            >
                        </div>
                        <div class="field col-12 md:col-6">
                            <label>Tag as</label>

                            <Dropdown
                                v-model="form.selected_tag"
                                :class="{
                                    'p-invalid': error_selected_tag,
                                }"
                                :options="tag"
                                optionLabel="tag"
                                optionValue="tag"
                                placeholder="Select tag"
                                disabled
                            />
                            <label
                                style="color: red"
                                v-if="error_selected_tag"
                                >{{ error_selected_tag }}</label
                            >
                        </div>

                        <div class="field col-12 md:col-6">
                            <label>Contact Number</label>
                            <div class="p-inputgroup">
                                <span class="p-inputgroup-addon"> +63 </span>
                                <InputMask
                                    mask="(999) 99-999-9999"
                                    placeholder="(639) 99-999-9999"
                                    :unmask="true"
                                    id="contact_num"
                                    type="text"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                    v-model="form.contact_num"
                                    :class="{
                                        'p-invalid': error_contact_num,
                                    }"
                                    disabled
                                />
                            </div>

                            <label
                                style="color: red"
                                v-if="error_contact_num"
                                >{{ error_contact_num }}</label
                            >
                        </div>
                        <div class="field col-12 md:col-6">
                            <label>Role</label>

                            <Dropdown
                                v-model="form.selected_role"
                                :class="{
                                    'p-invalid': error_role,
                                }"
                                :options="role"
                                optionLabel="type"
                                optionValue="value"
                                placeholder="Select Role"
                                disabled
                            />
                            <label style="color: red" v-if="error_role">{{
                                error_role
                            }}</label>
                        </div>
                        <div class="field col-12 md:col-6">
                            <label>Position</label>

                            <Dropdown
                                v-model="form.selected_position"
                                :class="{
                                    'p-invalid': error_selected_position,
                                }"
                                :options="positions"
                                optionLabel="name"
                                optionValue="id"
                                placeholder="Select position"
                                disabled
                            />
                            <label
                                style="color: red"
                                v-if="error_selected_position"
                                >{{ error_selected_position }}</label
                            >
                        </div>

                        <br />
                    </div>
                </div>
            </Dialog>
            <Dialog
                v-model:visible="viewCandidateDialog"
                :style="{ width: '500px' }"
                header="View Candidate"
                :modal="true"
            >
                <div class="grid">
                    <div class="p-fluid formgrid grid">
                        <div class="field col-12 md:col-12 mt-2">
                            <label>Running for</label>

                            <Dropdown
                                v-model="form.selected_position"
                                :class="{
                                    'p-invalid': error_selected_position,
                                }"
                                :options="positions"
                                optionLabel="name"
                                optionValue="id"
                                placeholder="Select position"
                                disabled
                            />
                            <label
                                style="color: red"
                                v-if="error_selected_position"
                                >{{ error_selected_position }}</label
                            >
                        </div>
                        <div class="field col-12 md:col-6">
                            <label>Firstname</label>

                            <InputText
                                id="firstname"
                                type="text"
                                v-model="form.first_name"
                                :class="{
                                    'p-invalid': error_first_name,
                                }"
                                disabled
                            />
                            <label style="color: red" v-if="error_first_name">{{
                                error_first_name
                            }}</label>
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
                                disabled
                            />
                            <label style="color: red" v-if="error_last_name">{{
                                error_last_name
                            }}</label>
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
                                        :disabled="true"
                                    />
                                    <label class="mb-0 ml-1 mr-5">Male</label>
                                    <RadioButton
                                        name="gender"
                                        value="female"
                                        :class="{
                                            'p-invalid': error_gender,
                                        }"
                                        v-model="form.gender"
                                        :disabled="true"
                                    />
                                    <label class="mb-0 ml-1">Female</label>
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
                                disabled
                            />
                            <label style="color: red" v-if="error_age">{{
                                error_age
                            }}</label>
                        </div>

                        <div class="field col-12 md:col-6">
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
                                disabled
                            />
                            <label
                                style="color: red"
                                v-if="error_selected_block"
                                >{{ error_selected_block }}</label
                            >
                        </div>
                        <div class="field col-12 md:col-6">
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
                                disabled
                            />
                            <label
                                style="color: red"
                                v-if="error_selected_lot"
                                >{{ error_selected_lot }}</label
                            >
                        </div>
                        <div class="field col-12 md:col-6">
                            <label>Tag as</label>

                            <Dropdown
                                v-model="form.selected_tag"
                                :class="{
                                    'p-invalid': error_selected_tag,
                                }"
                                :options="tag"
                                optionLabel="tag"
                                optionValue="tag"
                                placeholder="Select tag"
                                disabled
                            />
                            <label
                                style="color: red"
                                v-if="error_selected_tag"
                                >{{ error_selected_tag }}</label
                            >
                        </div>

                        <div class="field col-12 md:col-6">
                            <label>Contact Number</label>
                            <div class="p-inputgroup">
                                <span class="p-inputgroup-addon"> +63 </span>
                                <InputMask
                                    mask="(999) 99-999-9999"
                                    placeholder="(639) 99-999-9999"
                                    :unmask="true"
                                    id="contact_num"
                                    type="text"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                    v-model="form.contact_num"
                                    :class="{
                                        'p-invalid': error_contact_num,
                                    }"
                                    disabled
                                />
                            </div>

                            <label
                                style="color: red"
                                v-if="error_contact_num"
                                >{{ error_contact_num }}</label
                            >
                        </div>

                        <br />
                    </div>
                </div>
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
            userLogged: computed(() => store.state.userLogged),
            blocks: computed(() => store.state.blocks.blocks),
            filteredLots: computed(() => store.state.lots.filteredLots),
            positions: computed(() => store.state.positions.positions),
            candidates: computed(() => store.state.candidates.candidates),
            last_candidates: computed(
                () => store.state.candidates.last_candidates
            ),
            officers: computed(() => store.state.officers),
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
            loading: false,
            viewOfficerDialog: false,
            viewCandidateDialog: false,
            confirmVoteDialog: false,
            id: null,
            role: [
                { type: "officer", value: "officer" },
                { type: "resident", value: "resident" },
            ],
            tag: [
                { tag: "owner" },
                { tag: "renter" },
                { tag: "family member" },
            ],
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
                selected_position: "",
                selected_tag: "",
            },
            selected_candidate: [],

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
            error_selected_position: "",
            error_selected_tag: "",

            election_id: null,
            election_on_going: false,
            result: false,
        };
    },
    methods: {
        submitVote() {
            this.loading = true;
            console.log(this.selected_candidate);
            this.positions.forEach((elem) => {
                axios({
                    method: "put",
                    url:
                        "/api/candidate/vote/" +
                        this.selected_candidate[elem.name],
                    data: {
                        vote_count: 1,
                    },
                })
                    .then(async (res) => {
                        console.log(
                            "vote for candidate id",
                            this.selected_candidate[elem.name]
                        );
                        if (this.$store.state.userLogged.has_voted == 0) {
                            await axios({
                                method: "put",
                                url:
                                    "/api/user/vote/" +
                                    this.$store.state.userLogged.id,
                                data: {
                                    has_voted: 1,
                                },
                            })
                                .then((res) => {
                                    console.log(
                                        "changed has voted for ",
                                        this.$store.state.userLogged.id
                                    );
                                    this.$store.dispatch("getUserLogged");
                                    this.$store.dispatch("getUsersVerified");
                                    this.$store.dispatch(
                                        "candidates/getAll",
                                        this.election_id
                                    );
                                })
                                .catch((err) => {
                                    console.log(err.response);
                                });
                        }
                    })
                    .catch((err) => {
                        console.log(err.response);
                    });
            });

            this.showVoteSucess();
            this.confirmVoteDialog = false;
            this.loading = false;
        },
        showVoteSucess() {
            this.$toast.add({
                severity: "success",
                summary: "Success Message",
                detail: "Voted Successfully",
                life: 3000,
            });
        },
        showWarningStartElection() {
            this.$toast.add({
                severity: "warn",
                summary: "Warning Message",
                detail: "Please vote all the position fields",
                life: 3000,
            });
        },
        validateVote() {
            var validation = null;
            this.positions.forEach((elem) => {
                if (this.selected_candidate[elem.name] == null) {
                    ++validation;
                }
            });
            if (validation) {
                this.showWarningStartElection();
            } else {
                this.confirmVoteDialog = true;
            }
        },
        viewUser(data) {
            console.log(data);
            this.populateFields(data);
            if (data.role == "officer") {
                this.viewOfficerDialog = true;
            } else {
                this.viewCandidateDialog = true;
            }
        },
        populateFields(data) {
            this.id = data.id;

            if (data.role == "officer") {
                this.form.selected_block = data.lot.block.number;
                this.getBlockLot();
                this.form.selected_block_lot = data.block_lot_id;

                this.name = data.name;
                this.form.first_name = data.first_name;
                this.form.last_name = data.last_name;
                this.form.gender = data.gender;
                this.form.selected_position = data.position_id;
                this.form.age = data.age;
                this.form.contact_num = data.contact_num;
                this.form.selected_role = data.role;
                this.form.verified = data.verified;
                this.form.has_voted = data.has_voted;
                this.form.status = data.status;
                this.form.selected_tag = data.tag_as;
            } else {
                this.form.selected_block = data.user.lot.block.number;
                this.getBlockLot();
                this.form.selected_block_lot = data.user.block_lot_id;
                this.name = data.user.name;
                this.form.first_name = data.user.first_name;
                this.form.last_name = data.user.last_name;
                this.form.gender = data.user.gender;
                this.form.selected_position = data.position_id;
                this.form.age = data.user.age;
                this.form.contact_num = data.user.contact_num;
                this.form.selected_role = data.user.role;
                this.form.verified = data.user.verified;
                this.form.has_voted = data.user.has_voted;
                this.form.status = data.user.status;
                this.form.selected_tag = data.user.tag_as;
            }
        },
        getBlockLot() {
            this.form.selected_block_lot = null;
            this.$store.dispatch("lots/getBlockLots", this.form.selected_block);
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
                .then((res) => {
                    this.id = res.data.id;
                    console.log("result", (this.result = res.data.result));
                    var end_date = res.data.end_date;

                    // var date = new Date(
                    //         this.$store.state.timeNow.timeNow.datetime
                    //     ),
                    //     mnth = ("0" + (date.getMonth() + 1)).slice(-2),
                    //     day = ("0" + date.getDate()).slice(-2);
                    // var date_now = [date.getFullYear(), mnth, day].join("-");

                    var date = new Date(),
                        mnth = ("0" + (date.getMonth() + 1)).slice(-2),
                        day = ("0" + date.getDate()).slice(-2);
                    var date_now = [date.getFullYear(), mnth, day].join("-");

                    if (!this.id) {
                        console.log("NO ELECTION");
                        this.election_id = 1;
                    } else if (this.id && end_date > date_now) {
                        console.log("ELECTION ON GOING 2nd if ");
                        this.election_on_going = true;
                        this.election_id = res.data.id;
                    } else {
                        console.log("NO ELECTION 3rd");
                        this.$store.dispatch(
                            "candidates/getLastCandidates",
                            this.id
                        );
                        this.election_on_going = false;
                        this.election_id = parseInt(res.data.id) + 1;
                    }
                    this.$store.dispatch("candidates/getAll", this.election_id);
                    this.$store.dispatch("filterResident", this.election_id);
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
        this.$store.dispatch("getOfficers");

        this.positions.forEach((elem) => {
            this.selected_candidate[elem.name] = null;
        });
        this.$store.dispatch("getUsersVerified");
    },
    created() {},
};
</script>
