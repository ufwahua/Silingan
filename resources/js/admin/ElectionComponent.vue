<template>
    <div>
        <div v-if="loading"></div>
        <div v-else>
            <div v-if="!election_on_going">
                <div class="flex justify-content-center">
                    <Card class="mb-4" style="width: 23em">
                        <template #title> <h2>Start Election</h2> </template>
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
                <div v-if="result">
                    <hr />
                    <h2 class="text-center">
                        ELECTION RESULT ( {{ election_start }} -
                        {{ election_end }} )
                    </h2>
                    <h3 class="text-center">
                        Voted {{ number_voted }} out of {{ total_voter }}
                    </h3>
                    <div class="flex justify-content-center">
                        <Button
                            label="Generate Result"
                            icon="pi pi-file-pdf"
                            @click="generateResult"
                        />
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
            <div v-else>
                <h4 class="text-center">
                    ELECTION IS ON GOING ( {{ election_start }} -
                    {{ election_end }} )
                </h4>
                <h3 class="text-center">Voted</h3>
                <h2 class="text-center">
                    {{ number_voted }} out of {{ total_voter }}
                </h2>
                <div
                    v-if="
                        userLogged.has_voted == 0 &&
                        userLogged.role == 'officer'
                    "
                >
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
                                            <template #content>
                                                <div
                                                    v-if="!result"
                                                    class="flex justify-content-center"
                                                >
                                                    <Button
                                                        icon="pi pi-trash"
                                                        class="p-button-rounded p-button-secondary mr-2"
                                                        @click="
                                                            deleteCandidate(
                                                                candidate
                                                            )
                                                        "
                                                        v-tooltip="
                                                            'Delete Candidate'
                                                        "
                                                    />
                                                    <Button
                                                        icon="pi pi-pencil"
                                                        class="p-button-rounded p-button-primary"
                                                        @click="
                                                            updateCandidate(
                                                                candidate
                                                            )
                                                        "
                                                        v-tooltip="
                                                            'Edit Candidate'
                                                        "
                                                    />
                                                </div>
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
        </div>
        <Toast />
    </div>
</template>
<script>
import { computed } from "vue";
import { useStore } from "vuex";
import { jsPDF } from "jspdf";
import axios from "axios";
export default {
    setup() {
        const store = useStore();
        return {
            blocks: computed(() => store.state.blocks.blocks),
            filteredLots: computed(() => store.state.lots.filteredLots),
            userLogged: computed(() => store.state.userLogged),
            positions: computed(() => store.state.positions.positions),
            candidates: computed(() => store.state.candidates.candidates),
            last_candidates: computed(
                () => store.state.candidates.last_candidates
            ),
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
            selected_candidate: [],
            date: null,
            date_formated: null,
            loading: false,
            createCandidateDialog: false,
            deleteCandidateDialog: false,
            updateCandidateDialog: false,
            createElectionDialog: false,
            viewCandidateDialog: false,
            viewOfficerDialog: false,
            confirmVoteDialog: false,
            id: null,
            result: false,
            position_id: null,
            user_id: null,
            name: null,
            election_id: null,
            dateFormatted: null,
            election_on_going: false,

            invalidDates: null,
            error_position_id: null,
            error_user_id: null,
            error_date: null,

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
            tag: [
                { tag: "owner" },
                { tag: "renter" },
                { tag: "family member" },
            ],
            election_start: null,
            election_end: null,
        };
    },
    computed: {
        resultElection() {
            let temp = [];

            this.positions.forEach((pos) => {
                temp.push([pos.name, "", ""]);
                this.last_candidates.forEach((cand) => {
                    if (pos.id == cand.position_id) {
                        temp.push([
                            "",
                            cand.user.first_name + " " + cand.user.last_name,
                            cand.vote_count,
                        ]);
                    }
                });
            });

            return temp;
        },
    },
    methods: {
        generateResult() {
            let finalY = 1;
            const doc = new jsPDF();
            doc.text(
                "Election Result ( " +
                    this.election_start +
                    " - " +
                    this.election_end +
                    " )",
                15,
                finalY + 15
            );
            doc.autoTable({
                startY: finalY + 20,
                theme: "plain",
                head: [["Position", "Full name", "Vote Count"]],
                body: this.resultElection,
            });
            doc.save(
                "Election Result " +
                    this.election_start +
                    "-" +
                    this.election_end
            );
        },
        dateFormat(date) {
            var options = {
                year: "numeric",
                month: "long",
                day: "numeric",
            };

            return new Date(date).toLocaleDateString("en-US", options);
        },
        showWarningVote() {
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
                this.showWarningVote();
            } else {
                this.confirmVoteDialog = true;
            }
        },
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
        viewUser(data) {
            console.log("view user", data);
            this.populateCandidates(data);
            if (data.role == "officer") {
                this.viewOfficerDialog = true;
            } else {
                this.viewCandidateDialog = true;
            }
        },
        populateCandidates(data) {
            this.form.selected_block = data.user.lot.block.number;
            this.getBlockLot();
            this.form.selected_block_lot = data.user.lot.id;
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
        },
        getBlockLot() {
            this.form.selected_block_lot = null;
            this.$store.dispatch("lots/getBlockLots", this.form.selected_block);
        },
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
                            console.log("notify announcement success");
                        })
                        .catch((e) => {
                            console.log(e.response);
                        });
                    await axios({
                        method: "post",
                        url: "/api/election/update-voters",
                    })
                        .then(() => {
                            console.log("updated voters ");
                            this.$store.dispatch("getUsersVerified");
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
                    this.$store.dispatch("filterResident", this.election_id);
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
                    console.log("post candidate election id", this.election_id);
                    this.$store.dispatch("candidates/getAll", this.election_id);
                    this.$store.dispatch("filterResident", this.election_id);
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
                    console.log("result", (this.result = res.data.result));
                    var end_date = res.data.end_date;
                    var start_date = res.data.start_date;
                    this.election_start = this.dateFormat(start_date);
                    console.log("election_start", this.election_start);
                    this.election_end = this.dateFormat(end_date);
                    console.log("election_end", this.election_end);
                    // this.$store.state.timeNow.timeNow.datetime
                    var date = new Date(),
                        mnth = ("0" + (date.getMonth() + 1)).slice(-2),
                        day = ("0" + date.getDate()).slice(-2);
                    var date_now = [date.getFullYear(), mnth, day].join("-");

                    if (!this.id) {
                        console.log("NO ELECTION");
                        this.election_id = 1;
                        this.$store.dispatch(
                            "candidates/getLastCandidates",
                            this.election_id
                        );
                    } else if (this.id && end_date > date_now) {
                        console.log("ELECTION ON GOING 2nd if ");
                        this.election_id = res.data.id;
                        this.$store.dispatch(
                            "candidates/getLastCandidates",
                            this.election_id
                        );
                        this.election_on_going = true;
                    } else {
                        console.log("NO ELECTION 3rd");
                        this.$store.dispatch(
                            "candidates/getLastCandidates",
                            this.id
                        );
                        this.election_id = parseInt(res.data.id) + 1;
                        this.election_on_going = false;
                        if (this.result == 0) {
                            axios({
                                method: "put",
                                url: "/api/election/" + res.data.id,
                                data: {
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
        this.$store.dispatch("getUsersVerified");
        this.$store.dispatch("getOfficers");

        this.positions.forEach((elem) => {
            this.selected_candidate[elem.name] = null;
        });
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
