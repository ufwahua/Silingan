<template>
    <div class="mr-5">
        <div v-if="loading"></div>
        <div v-else>
            <div v-if="election_on_going">
                <div v-if="userLogged.lot.has_voted == 0">
                    <h4 class="text-center">
                        ELECTION IS ON GOING ( {{ election_start }} -
                        {{ election_end }} )
                    </h4>
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
                    <h4 class="text-center">
                        ELECTION IS ON GOING ( {{ election_start }} -
                        {{ election_end }} )
                    </h4>
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
            <Dialog
                v-model:visible="confirmVoteDialog"
                :style="{ width: '500px' }"
                header='End-User License Agreement ("Agreement")'
                :modal="true"
            >
                <div>
                    <p>Last updated: May 24, 2022</p>
                    <p>
                        Please read this End-User License Agreement carefully
                        before clicking the &quot;I Agree&quot; button,
                        downloading or using Silingan.
                    </p>
                    <h3>Interpretation and Definitions</h3>
                    <h4>Interpretation</h4>
                    <p>
                        The words of which the initial letter is capitalized
                        have meanings defined under the following conditions.
                        The following definitions shall have the same meaning
                        regardless of whether they appear in singular or in
                        plural.
                    </p>
                    <h4>Definitions</h4>
                    <p>For the purposes of this End-User License Agreement:</p>
                    <ul>
                        <li>
                            <p>
                                <strong>Agreement</strong> means this End-User
                                License Agreement that forms the entire
                                agreement between You and the Company regarding
                                the use of the Application. This Agreement has
                                been created with the help of the
                                <a
                                    href="https://www.termsfeed.com/eula-generator/"
                                    target="_blank"
                                    >EULA Generator</a
                                >.
                            </p>
                        </li>
                        <li>
                            <p>
                                <strong>Application</strong> means the software
                                program provided by the Company downloaded by
                                You to a Device, named Silingan
                            </p>
                        </li>
                        <li>
                            <p>
                                <strong>Company</strong> (referred to as either
                                &quot;the Company&quot;, &quot;We&quot;,
                                &quot;Us&quot; or &quot;Our&quot; in this
                                Agreement) refers to Silingan.
                            </p>
                        </li>
                        <li>
                            <p>
                                <strong>Content</strong> refers to content such
                                as text, images, or other information that can
                                be posted, uploaded, linked to or otherwise made
                                available by You, regardless of the form of that
                                content.
                            </p>
                        </li>
                        <li>
                            <p>
                                <strong>Country</strong> refers to: Philippines
                            </p>
                        </li>
                        <li>
                            <p>
                                <strong>Device</strong> means any device that
                                can access the Application such as a computer, a
                                cellphone or a digital tablet.
                            </p>
                        </li>
                        <li>
                            <p>
                                <strong>Third-Party Services</strong> means any
                                services or content (including data,
                                information, applications and other products
                                services) provided by a third-party that may be
                                displayed, included or made available by the
                                Application.
                            </p>
                        </li>
                        <li>
                            <p>
                                <strong>You</strong> means the individual
                                accessing or using the Application or the
                                company, or other legal entity on behalf of
                                which such individual is accessing or using the
                                Application, as applicable.
                            </p>
                        </li>
                    </ul>
                    <h3>Acknowledgment</h3>
                    <p>
                        By clicking the &quot;I Agree&quot; button, downloading
                        or using the Application, You are agreeing to be bound
                        by the terms and conditions of this Agreement. If You do
                        not agree to the terms of this Agreement, do not click
                        on the &quot;I Agree&quot; button, do not download or do
                        not use the Application.
                    </p>
                    <p>
                        This Agreement is a legal document between You and the
                        Company and it governs your use of the Application made
                        available to You by the Company.
                    </p>
                    <p>
                        The Application is licensed, not sold, to You by the
                        Company for use strictly in accordance with the terms of
                        this Agreement.
                    </p>
                    <h3>License</h3>
                    <h4>Scope of License</h4>
                    <p>
                        The Company grants You a revocable, non-exclusive,
                        non-transferable, limited license to download, install
                        and use the Application strictly in accordance with the
                        terms of this Agreement.
                    </p>
                    <p>
                        The license that is granted to You by the Company is
                        solely for your personal, non-commercial purposes
                        strictly in accordance with the terms of this Agreement.
                    </p>
                    <h3>Third-Party Services</h3>
                    <p>
                        The Application may display, include or make available
                        third-party content (including data, information,
                        applications and other products services) or provide
                        links to third-party websites or services.
                    </p>
                    <p>
                        You acknowledge and agree that the Company shall not be
                        responsible for any Third-party Services, including
                        their accuracy, completeness, timeliness, validity,
                        copyright compliance, legality, decency, quality or any
                        other aspect thereof. The Company does not assume and
                        shall not have any liability or responsibility to You or
                        any other person or entity for any Third-party Services.
                    </p>
                    <p>
                        You must comply with applicable Third parties' Terms of
                        agreement when using the Application. Third-party
                        Services and links thereto are provided solely as a
                        convenience to You and You access and use them entirely
                        at your own risk and subject to such third parties'
                        Terms and conditions.
                    </p>
                    <h3>Term and Termination</h3>
                    <p>
                        This Agreement shall remain in effect until terminated
                        by You or the Company. The Company may, in its sole
                        discretion, at any time and for any or no reason,
                        suspend or terminate this Agreement with or without
                        prior notice.
                    </p>
                    <p>
                        This Agreement will terminate immediately, without prior
                        notice from the Company, in the event that you fail to
                        comply with any provision of this Agreement. You may
                        also terminate this Agreement by deleting the
                        Application and all copies thereof from your Device or
                        from your computer.
                    </p>
                    <p>
                        Upon termination of this Agreement, You shall cease all
                        use of the Application and delete all copies of the
                        Application from your Device.
                    </p>
                    <p>
                        Termination of this Agreement will not limit any of the
                        Company's rights or remedies at law or in equity in case
                        of breach by You (during the term of this Agreement) of
                        any of your obligations under the present Agreement.
                    </p>
                    <h3>Indemnification</h3>
                    <p>
                        You agree to indemnify and hold the Company and its
                        parents, subsidiaries, affiliates, officers, employees,
                        agents, partners and licensors (if any) harmless from
                        any claim or demand, including reasonable attorneys'
                        fees, due to or arising out of your: (a) use of the
                        Application; (b) violation of this Agreement or any law
                        or regulation; or (c) violation of any right of a third
                        party.
                    </p>
                    <h3>No Warranties</h3>
                    <p>
                        The Application is provided to You &quot;AS IS&quot; and
                        &quot;AS AVAILABLE&quot; and with all faults and defects
                        without warranty of any kind. To the maximum extent
                        permitted under applicable law, the Company, on its own
                        behalf and on behalf of its affiliates and its and their
                        respective licensors and service providers, expressly
                        disclaims all warranties, whether express, implied,
                        statutory or otherwise, with respect to the Application,
                        including all implied warranties of merchantability,
                        fitness for a particular purpose, title and
                        non-infringement, and warranties that may arise out of
                        course of dealing, course of performance, usage or trade
                        practice. Without limitation to the foregoing, the
                        Company provides no warranty or undertaking, and makes
                        no representation of any kind that the Application will
                        meet your requirements, achieve any intended results, be
                        compatible or work with any other software,
                        applications, systems or services, operate without
                        interruption, meet any performance or reliability
                        standards or be error free or that any errors or defects
                        can or will be corrected.
                    </p>
                    <p>
                        Without limiting the foregoing, neither the Company nor
                        any of the company's provider makes any representation
                        or warranty of any kind, express or implied: (i) as to
                        the operation or availability of the Application, or the
                        information, content, and materials or products included
                        thereon; (ii) that the Application will be uninterrupted
                        or error-free; (iii) as to the accuracy, reliability, or
                        currency of any information or content provided through
                        the Application; or (iv) that the Application, its
                        servers, the content, or e-mails sent from or on behalf
                        of the Company are free of viruses, scripts, trojan
                        horses, worms, malware, timebombs or other harmful
                        components.
                    </p>
                    <p>
                        Some jurisdictions do not allow the exclusion of certain
                        types of warranties or limitations on applicable
                        statutory rights of a consumer, so some or all of the
                        above exclusions and limitations may not apply to You.
                        But in such a case the exclusions and limitations set
                        forth in this section shall be applied to the greatest
                        extent enforceable under applicable law. To the extent
                        any warranty exists under law that cannot be disclaimed,
                        the Company shall be solely responsible for such
                        warranty.
                    </p>
                    <h1>Limitation of Liability</h1>
                    <p>
                        Notwithstanding any damages that You might incur, the
                        entire liability of the Company and any of its suppliers
                        under any provision of this Agreement and your exclusive
                        remedy for all of the foregoing shall be limited to the
                        amount actually paid by You for the Application or
                        through the Application or 100 USD if You haven't
                        purchased anything through the Application.
                    </p>
                    <p>
                        To the maximum extent permitted by applicable law, in no
                        event shall the Company or its suppliers be liable for
                        any special, incidental, indirect, or consequential
                        damages whatsoever (including, but not limited to,
                        damages for loss of profits, loss of data or other
                        information, for business interruption, for personal
                        injury, loss of privacy arising out of or in any way
                        related to the use of or inability to use the
                        Application, third-party software and/or third-party
                        hardware used with the Application, or otherwise in
                        connection with any provision of this Agreement), even
                        if the Company or any supplier has been advised of the
                        possibility of such damages and even if the remedy fails
                        of its essential purpose.
                    </p>
                    <p>
                        Some states/jurisdictions do not allow the exclusion or
                        limitation of incidental or consequential damages, so
                        the above limitation or exclusion may not apply to You.
                    </p>
                    <h3>Severability and Waiver</h3>
                    <h4>Severability</h4>
                    <p>
                        If any provision of this Agreement is held to be
                        unenforceable or invalid, such provision will be changed
                        and interpreted to accomplish the objectives of such
                        provision to the greatest extent possible under
                        applicable law and the remaining provisions will
                        continue in full force and effect.
                    </p>
                    <h4>Waiver</h4>
                    <p>
                        Except as provided herein, the failure to exercise a
                        right or to require performance of an obligation under
                        this Agreement shall not effect a party's ability to
                        exercise such right or require such performance at any
                        time thereafter nor shall the waiver of a breach
                        constitute a waiver of any subsequent breach.
                    </p>
                    <h3>Product Claims</h3>
                    <p>
                        The Company does not make any warranties concerning the
                        Application.
                    </p>
                    <h3>United States Legal Compliance</h3>
                    <p>
                        You represent and warrant that (i) You are not located
                        in a country that is subject to the United States
                        government embargo, or that has been designated by the
                        United States government as a &quot;terrorist
                        supporting&quot; country, and (ii) You are not listed on
                        any United States government list of prohibited or
                        restricted parties.
                    </p>
                    <h3>Changes to this Agreement</h3>
                    <p>
                        The Company reserves the right, at its sole discretion,
                        to modify or replace this Agreement at any time. If a
                        revision is material we will provide at least 30 days'
                        notice prior to any new terms taking effect. What
                        constitutes a material change will be determined at the
                        sole discretion of the Company.
                    </p>
                    <p>
                        By continuing to access or use the Application after any
                        revisions become effective, You agree to be bound by the
                        revised terms. If You do not agree to the new terms, You
                        are no longer authorized to use the Application.
                    </p>
                    <h3>Governing Law</h3>
                    <p>
                        The laws of the Country, excluding its conflicts of law
                        rules, shall govern this Agreement and your use of the
                        Application. Your use of the Application may also be
                        subject to other local, state, national, or
                        international laws.
                    </p>
                    <h3>Entire Agreement</h3>
                    <p>
                        The Agreement constitutes the entire agreement between
                        You and the Company regarding your use of the
                        Application and supersedes all prior and contemporaneous
                        written or oral agreements between You and the Company.
                    </p>
                    <p>
                        You may be subject to additional terms and conditions
                        that apply when You use or purchase other Company's
                        services, which the Company will provide to You at the
                        time of such use or purchase.
                    </p>
                    <h3>Contact Us</h3>
                    <p>
                        If you have any questions about this Agreement, You can
                        contact Us:
                    </p>
                    <ul>
                        <li>By email: silinganapp.ph@gmail.com</li>
                    </ul>
                </div>
                <div class="flex align-items-center">
                    <Checkbox v-model="eula" :binary="true" />

                    I accept the terms and condition for website access
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
                        :disabled="!eula"
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
import { jsPDF } from "jspdf";
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
                store.state.lots.lots.forEach((elem) => {
                    if (elem.has_voted == 1) {
                        temp.push(elem);
                    }
                });
                return temp.length;
            }),
            total_voter: computed(() => {
                let temp = [];
                store.state.lots.lots.forEach((elem) => {
                    temp.push(elem);
                });
                return temp.length;
            }),
        };
    },
    data() {
        return {
            eula: false,
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
        submitVote() {
            this.loading = true;

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
                        if (this.userLogged.lot.has_voted == 0) {
                            await axios({
                                method: "put",
                                url:
                                    "/api/lot/vote/" +
                                    this.$store.state.userLogged.block_lot_id,
                                data: {
                                    has_voted: 1,
                                },
                            })
                                .then((res) => {
                                    console.log(
                                        "changed has voted for ",
                                        this.$store.state.userLogged.id
                                    );
                                    this.$store.dispatch("lots/getAll");
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
            this.candidates.forEach((elem) => {
                if (this.selected_candidate[elem.position.name] == null) {
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
        dateFormat(date) {
            var options = {
                year: "numeric",
                month: "long",
                day: "numeric",
            };

            return new Date(date).toLocaleDateString("en-US", options);
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
                    var start_date = res.data.start_date;
                    this.election_start = this.dateFormat(start_date);
                    console.log("election_start", this.election_start);
                    this.election_end = this.dateFormat(end_date);
                    console.log("election_end", this.election_end);
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
                        this.$store.dispatch(
                            "candidates/getLastCandidates",
                            this.election_id
                        );
                    } else {
                        console.log("NO ELECTION 3rd");
                        this.$store.dispatch(
                            "candidates/getLastCandidates",
                            this.id
                        );
                        this.election_on_going = false;
                        this.election_id = parseInt(res.data.id) + 1;
                    }
                    console.log("election id", this.election_id);
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
        this.$store.dispatch("positions/getAll");
        this.$store.dispatch("getOfficers");

        this.positions.forEach((elem) => {
            this.candidates.forEach((e) => {
                if (e.position_id == elem.position_id) {
                    this.selected_candidate[elem.name] = null;
                }
            });
        });

        this.$store.dispatch("getUsersVerified");
        this.$store.dispatch("getUserLogged");
        console.log("userLogged", this.userLogged);
    },
    created() {},
};
</script>
