<template>
    <div
        class="surface-0 flex align-items-center justify-content-center min-h-screen min-w-screen overflow-hidden"
    >
        <div class="card">
            <div
                class="grid justify-content-center p-2 lg:p-0"
                style="width: 60vw"
            >
                <div class="col-12 mb-2 lg:col-12 lg:mb-3 text-center">
                    <router-link to="/" :key="$route.fullPath">
                        <img
                            class="Silingan-logo"
                            alt="Silingan-Logo"
                            src="https://i.ibb.co/V3B8NBM/silingan-icon.png"
                    /></router-link>
                </div>

                <div class="col-12 title-form">
                    <Badge
                        :value="1"
                        severity="info"
                        class="mr-2 mb-2"
                        size="large"
                    ></Badge>
                    <label><h6>Your Basic Information</h6></label>
                </div>
                <form @submit.prevent="onRegisterClick" autocomplete="on">
                    <div class="p-fluid formgrid grid">
                        <div class="field col-12 md:col-6">
                            <label>Firstname</label>

                            <InputText
                                id="firstname"
                                :class="{
                                    'p-invalid': error_first_name,
                                }"
                                type="text"
                                v-model="first_name"
                            />
                            <label style="color: red" v-if="error_first_name">{{
                                error_first_name
                            }}</label>
                        </div>

                        <div class="field col-12 md:col-6">
                            <label>Lastname</label>

                            <InputText
                                :class="{
                                    'p-invalid': error_last_name,
                                }"
                                id="last_name"
                                type="text"
                                v-model="last_name"
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
                                        :class="{
                                            'p-invalid': error_gender,
                                        }"
                                        value="male"
                                        v-model="gender"
                                        block_number
                                    />
                                    <label class="mb-0 ml-1 mr-5">Male</label>
                                    <RadioButton
                                        name="gender"
                                        :class="{
                                            'p-invalid': error_gender,
                                        }"
                                        value="female"
                                        v-model="gender"
                                        block_number
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
                                :class="{
                                    'p-invalid': error_age,
                                }"
                                type="number"
                                min="0"
                                step="1"
                                onfocus="this.previousValue = this.value"
                                onkeydown="this.previousValue = this.value"
                                oninput="validity.valid || (value = this.previousValue)"
                                v-model="age"
                            />
                            <label style="color: red" v-if="error_age">{{
                                error_age
                            }}</label>
                        </div>

                        <div class="field col-12 md:col-6">
                            <label>Contact Number</label>

                            <div class="p-inputgroup">
                                <span class="p-inputgroup-addon"> +63 </span>

                                <InputMask
                                    mask="(999) 99-999-9999"
                                    placeholder="(639) 99-999-9999"
                                    :unmask="true"
                                    :class="{
                                        'p-invalid': error_contact_num,
                                    }"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                    v-model="contact_num"
                                />
                            </div>

                            <label
                                style="color: red"
                                v-if="error_contact_num"
                                >{{ error_contact_num }}</label
                            >
                        </div>
                        <div class="field col-12 md:col-6">
                            <label>Tag as</label>

                            <Dropdown
                                v-model="selected_tag"
                                :class="{
                                    'p-invalid': error_selected_tag,
                                }"
                                :options="tag"
                                optionLabel="tag"
                                optionValue="tag"
                                placeholder="Select tag"
                            />
                            <label
                                style="color: red"
                                v-if="error_selected_tag"
                                >{{ error_selected_tag }}</label
                            >
                        </div>
                        <div class="field col-12 md:col-6">
                            <label>Block</label>

                            <Dropdown
                                v-model="selected_block"
                                :class="{
                                    'p-invalid': error_selected_block,
                                }"
                                :options="blocks"
                                optionLabel="number"
                                optionValue="number"
                                placeholder="Select Block"
                                @change="getBlockLot"
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
                                v-model="selected_block_lot"
                                :class="{
                                    'p-invalid': error_selected_lot,
                                }"
                                :options="filteredLots"
                                optionLabel="number"
                                optionValue="id"
                                placeholder="Select Lot"
                                :disabled="selected_block ? false : true"
                            />
                            <label
                                style="color: red"
                                v-if="error_selected_lot"
                                >{{ error_selected_lot }}</label
                            >
                        </div>

                        <br />

                        <div class="col-12 title-form">
                            <Badge
                                :value="2"
                                severity="info"
                                class="mr-2 mb-2"
                                size="large"
                            ></Badge>
                            <label><h6>Your Security Information</h6></label>
                        </div>

                        <div class="field col-12 md:col-4">
                            <label>Email</label>
                            <InputText
                                type="text"
                                :class="{ 'p-invalid': error_email }"
                                name="email"
                                v-model="email"
                            />
                            <label style="color: red" v-if="error_email">{{
                                error_email
                            }}</label>
                        </div>
                        <div class="field col-12 md:col-4">
                            <label>Password</label>
                            <Password
                                :class="{ 'p-invalid': error_password }"
                                v-model="password"
                                toggleMask
                            ></Password>
                            <label style="color: red" v-if="error_password">{{
                                error_password
                            }}</label>
                        </div>
                        <div class="field col-12 md:col-4">
                            <label>Confirm Password</label>
                            <Password
                                :class="{ 'p-invalid': error_confirm_password }"
                                v-model="confirm_password"
                                toggleMask
                            ></Password>
                            <label
                                style="color: red"
                                v-if="error_confirm_password"
                                >{{ error_confirm_password }}</label
                            >
                        </div>
                        <div
                            class="col-12 mb-2 lg:col-12 flex align-items-center"
                        >
                            <Checkbox v-model="eula" :binary="true" />

                            I accept the
                            <Button
                                class="p-button-link py-0 px-1"
                                style="width: 152px"
                                @click="showEula"
                                >terms and condition</Button
                            >
                            for website access
                        </div>
                        <div class="col-12 mb-2 lg:col-12 lg:mb-0">
                            <Button
                                :disabled="!eula"
                                type="submit"
                                label="Register"
                            />
                        </div>
                        <div class="col-12 mb-2 lg:col-12 lg:mb-0">
                            <p class="custom-text">
                                Already have an account?
                                <router-link to="login" :key="$route.fullPath">
                                    <a class="custom-link" href="#"
                                        >Login
                                    </a></router-link
                                >
                            </p>
                        </div>
                    </div>
                </form>
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
        <Dialog
            v-model:visible="eulaDialog"
            :style="{ width: '500px' }"
            :modal="true"
            :closeOnEscape="true"
            header='End-User License Agreement ("Agreement")'
        >
            <div>
                <p>Last updated: May 24, 2022</p>
                <p>
                    Please read this End-User License Agreement carefully before
                    clicking the &quot;I Agree&quot; button, downloading or
                    using Silingan.
                </p>
                <h3>Interpretation and Definitions</h3>
                <h4>Interpretation</h4>
                <p>
                    The words of which the initial letter is capitalized have
                    meanings defined under the following conditions. The
                    following definitions shall have the same meaning regardless
                    of whether they appear in singular or in plural.
                </p>
                <h4>Definitions</h4>
                <p>For the purposes of this End-User License Agreement:</p>
                <ul>
                    <li>
                        <p>
                            <strong>Agreement</strong> means this End-User
                            License Agreement that forms the entire agreement
                            between You and the Company regarding the use of the
                            Application. This Agreement has been created with
                            the help of the
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
                            program provided by the Company downloaded by You to
                            a Device, named Silingan
                        </p>
                    </li>
                    <li>
                        <p>
                            <strong>Company</strong> (referred to as either
                            &quot;the Company&quot;, &quot;We&quot;,
                            &quot;Us&quot; or &quot;Our&quot; in this Agreement)
                            refers to Silingan.
                        </p>
                    </li>
                    <li>
                        <p>
                            <strong>Content</strong> refers to content such as
                            text, images, or other information that can be
                            posted, uploaded, linked to or otherwise made
                            available by You, regardless of the form of that
                            content.
                        </p>
                    </li>
                    <li>
                        <p><strong>Country</strong> refers to: Philippines</p>
                    </li>
                    <li>
                        <p>
                            <strong>Device</strong> means any device that can
                            access the Application such as a computer, a
                            cellphone or a digital tablet.
                        </p>
                    </li>
                    <li>
                        <p>
                            <strong>Third-Party Services</strong> means any
                            services or content (including data, information,
                            applications and other products services) provided
                            by a third-party that may be displayed, included or
                            made available by the Application.
                        </p>
                    </li>
                    <li>
                        <p>
                            <strong>You</strong> means the individual accessing
                            or using the Application or the company, or other
                            legal entity on behalf of which such individual is
                            accessing or using the Application, as applicable.
                        </p>
                    </li>
                </ul>
                <h3>Acknowledgment</h3>
                <p>
                    By clicking the &quot;I Agree&quot; button, downloading or
                    using the Application, You are agreeing to be bound by the
                    terms and conditions of this Agreement. If You do not agree
                    to the terms of this Agreement, do not click on the &quot;I
                    Agree&quot; button, do not download or do not use the
                    Application.
                </p>
                <p>
                    This Agreement is a legal document between You and the
                    Company and it governs your use of the Application made
                    available to You by the Company.
                </p>
                <p>
                    The Application is licensed, not sold, to You by the Company
                    for use strictly in accordance with the terms of this
                    Agreement.
                </p>
                <h3>License</h3>
                <h4>Scope of License</h4>
                <p>
                    The Company grants You a revocable, non-exclusive,
                    non-transferable, limited license to download, install and
                    use the Application strictly in accordance with the terms of
                    this Agreement.
                </p>
                <p>
                    The license that is granted to You by the Company is solely
                    for your personal, non-commercial purposes strictly in
                    accordance with the terms of this Agreement.
                </p>
                <h3>Third-Party Services</h3>
                <p>
                    The Application may display, include or make available
                    third-party content (including data, information,
                    applications and other products services) or provide links
                    to third-party websites or services.
                </p>
                <p>
                    You acknowledge and agree that the Company shall not be
                    responsible for any Third-party Services, including their
                    accuracy, completeness, timeliness, validity, copyright
                    compliance, legality, decency, quality or any other aspect
                    thereof. The Company does not assume and shall not have any
                    liability or responsibility to You or any other person or
                    entity for any Third-party Services.
                </p>
                <p>
                    You must comply with applicable Third parties' Terms of
                    agreement when using the Application. Third-party Services
                    and links thereto are provided solely as a convenience to
                    You and You access and use them entirely at your own risk
                    and subject to such third parties' Terms and conditions.
                </p>
                <h3>Term and Termination</h3>
                <p>
                    This Agreement shall remain in effect until terminated by
                    You or the Company. The Company may, in its sole discretion,
                    at any time and for any or no reason, suspend or terminate
                    this Agreement with or without prior notice.
                </p>
                <p>
                    This Agreement will terminate immediately, without prior
                    notice from the Company, in the event that you fail to
                    comply with any provision of this Agreement. You may also
                    terminate this Agreement by deleting the Application and all
                    copies thereof from your Device or from your computer.
                </p>
                <p>
                    Upon termination of this Agreement, You shall cease all use
                    of the Application and delete all copies of the Application
                    from your Device.
                </p>
                <p>
                    Termination of this Agreement will not limit any of the
                    Company's rights or remedies at law or in equity in case of
                    breach by You (during the term of this Agreement) of any of
                    your obligations under the present Agreement.
                </p>
                <h3>Indemnification</h3>
                <p>
                    You agree to indemnify and hold the Company and its parents,
                    subsidiaries, affiliates, officers, employees, agents,
                    partners and licensors (if any) harmless from any claim or
                    demand, including reasonable attorneys' fees, due to or
                    arising out of your: (a) use of the Application; (b)
                    violation of this Agreement or any law or regulation; or (c)
                    violation of any right of a third party.
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
                    including all implied warranties of merchantability, fitness
                    for a particular purpose, title and non-infringement, and
                    warranties that may arise out of course of dealing, course
                    of performance, usage or trade practice. Without limitation
                    to the foregoing, the Company provides no warranty or
                    undertaking, and makes no representation of any kind that
                    the Application will meet your requirements, achieve any
                    intended results, be compatible or work with any other
                    software, applications, systems or services, operate without
                    interruption, meet any performance or reliability standards
                    or be error free or that any errors or defects can or will
                    be corrected.
                </p>
                <p>
                    Without limiting the foregoing, neither the Company nor any
                    of the company's provider makes any representation or
                    warranty of any kind, express or implied: (i) as to the
                    operation or availability of the Application, or the
                    information, content, and materials or products included
                    thereon; (ii) that the Application will be uninterrupted or
                    error-free; (iii) as to the accuracy, reliability, or
                    currency of any information or content provided through the
                    Application; or (iv) that the Application, its servers, the
                    content, or e-mails sent from or on behalf of the Company
                    are free of viruses, scripts, trojan horses, worms, malware,
                    timebombs or other harmful components.
                </p>
                <p>
                    Some jurisdictions do not allow the exclusion of certain
                    types of warranties or limitations on applicable statutory
                    rights of a consumer, so some or all of the above exclusions
                    and limitations may not apply to You. But in such a case the
                    exclusions and limitations set forth in this section shall
                    be applied to the greatest extent enforceable under
                    applicable law. To the extent any warranty exists under law
                    that cannot be disclaimed, the Company shall be solely
                    responsible for such warranty.
                </p>
                <h1>Limitation of Liability</h1>
                <p>
                    Notwithstanding any damages that You might incur, the entire
                    liability of the Company and any of its suppliers under any
                    provision of this Agreement and your exclusive remedy for
                    all of the foregoing shall be limited to the amount actually
                    paid by You for the Application or through the Application
                    or 100 USD if You haven't purchased anything through the
                    Application.
                </p>
                <p>
                    To the maximum extent permitted by applicable law, in no
                    event shall the Company or its suppliers be liable for any
                    special, incidental, indirect, or consequential damages
                    whatsoever (including, but not limited to, damages for loss
                    of profits, loss of data or other information, for business
                    interruption, for personal injury, loss of privacy arising
                    out of or in any way related to the use of or inability to
                    use the Application, third-party software and/or third-party
                    hardware used with the Application, or otherwise in
                    connection with any provision of this Agreement), even if
                    the Company or any supplier has been advised of the
                    possibility of such damages and even if the remedy fails of
                    its essential purpose.
                </p>
                <p>
                    Some states/jurisdictions do not allow the exclusion or
                    limitation of incidental or consequential damages, so the
                    above limitation or exclusion may not apply to You.
                </p>
                <h3>Severability and Waiver</h3>
                <h4>Severability</h4>
                <p>
                    If any provision of this Agreement is held to be
                    unenforceable or invalid, such provision will be changed and
                    interpreted to accomplish the objectives of such provision
                    to the greatest extent possible under applicable law and the
                    remaining provisions will continue in full force and effect.
                </p>
                <h4>Waiver</h4>
                <p>
                    Except as provided herein, the failure to exercise a right
                    or to require performance of an obligation under this
                    Agreement shall not effect a party's ability to exercise
                    such right or require such performance at any time
                    thereafter nor shall the waiver of a breach constitute a
                    waiver of any subsequent breach.
                </p>
                <h3>Product Claims</h3>
                <p>
                    The Company does not make any warranties concerning the
                    Application.
                </p>
                <h3>United States Legal Compliance</h3>
                <p>
                    You represent and warrant that (i) You are not located in a
                    country that is subject to the United States government
                    embargo, or that has been designated by the United States
                    government as a &quot;terrorist supporting&quot; country,
                    and (ii) You are not listed on any United States government
                    list of prohibited or restricted parties.
                </p>
                <h3>Changes to this Agreement</h3>
                <p>
                    The Company reserves the right, at its sole discretion, to
                    modify or replace this Agreement at any time. If a revision
                    is material we will provide at least 30 days' notice prior
                    to any new terms taking effect. What constitutes a material
                    change will be determined at the sole discretion of the
                    Company.
                </p>
                <p>
                    By continuing to access or use the Application after any
                    revisions become effective, You agree to be bound by the
                    revised terms. If You do not agree to the new terms, You are
                    no longer authorized to use the Application.
                </p>
                <h3>Governing Law</h3>
                <p>
                    The laws of the Country, excluding its conflicts of law
                    rules, shall govern this Agreement and your use of the
                    Application. Your use of the Application may also be subject
                    to other local, state, national, or international laws.
                </p>
                <h3>Entire Agreement</h3>
                <p>
                    The Agreement constitutes the entire agreement between You
                    and the Company regarding your use of the Application and
                    supersedes all prior and contemporaneous written or oral
                    agreements between You and the Company.
                </p>
                <p>
                    You may be subject to additional terms and conditions that
                    apply when You use or purchase other Company's services,
                    which the Company will provide to You at the time of such
                    use or purchase.
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
        </Dialog>
    </div>
</template>
<script>
import axios from "axios";
import { computed } from "vue";
import { useStore } from "vuex";
export default {
    setup() {
        const store = useStore();
        return {
            blocks: computed(() => store.state.blocks.blocks),
            lots: computed(() => store.state.lots.lots),
            filteredLots: computed(() => store.state.lots.filteredLots),
        };
    },
    data() {
        return {
            loading: null,
            first_name: null,
            last_name: null,
            gender: null,
            selected_block_lot: null,
            email: null,
            password: null,
            confirm_password: null,
            verified: 0,
            eula: false,
            age: null,
            contact_num: null,
            role: "resident",
            selected_block: null,
            selected_tag: null,
            tag: [
                { tag: "owner" },
                { tag: "renter" },
                { tag: "family member" },
            ],
            error_first_name: null,
            error_last_name: null,
            error_gender: null,
            error_selected_block: null,
            error_selected_lot: null,
            error_email: null,
            error_password: null,
            error_confirm_password: null,
            error_age: null,
            error_contact_num: null,
            error_selected_tag: null,

            eulaDialog: false,
        };
    },

    computed: {},
    methods: {
        showEula() {
            this.eulaDialog = true;
        },
        async onRegisterClick() {
            this.loading = true;
            await axios({
                method: "post",
                url: "/api/user",
                data: {
                    first_name: this.first_name,
                    last_name: this.last_name,
                    gender: this.gender,
                    block_lot_id: this.selected_block_lot,
                    email: this.email,
                    password: this.password,
                    confirm_password: this.confirm_password,
                    verified: 0,

                    age: this.age,
                    contact_num: this.contact_num,
                    role: "resident",
                    status: "active",
                    tag_as: this.selected_tag,
                },
            })
                .then(() => {
                    this.loading = false;
                    this.$router.push({ name: "login" });
                })
                .catch((err) => {
                    console.log(err.response.data);
                    this.resetErrors();
                    this.validate(err);
                    this.loading = false;
                });
        },
        resetFields() {
            this.first_name = null;
            this.last_name = null;
            this.gender = null;
            this.selected_block_lot = null;
            this.email = null;
            this.password = null;
            this.confirm_password = null;
            this.verified = 0;

            this.age = null;
            this.contact_num = null;
            this.role = "resident";
        },
        resetErrors() {
            this.error_first_name = null;
            this.error_last_name = null;
            this.error_gender = null;
            this.error_selected_block = null;
            this.error_selected_lot = null;
            this.error_email = null;
            this.error_password = null;
            this.error_confirm_password = null;
            this.error_age = null;
            this.error_contact_num = null;
            this.error_selected_tag = null;
        },
        validate(error) {
            if (error.response.data.errors.first_name)
                this.error_first_name =
                    error.response.data.errors.first_name[0];
            if (error.response.data.errors.last_name)
                this.error_last_name = error.response.data.errors.last_name[0];
            if (error.response.data.errors.gender)
                this.error_gender = error.response.data.errors.gender[0];
            if (error.response.data.errors.block_lot_id) {
                this.error_selected_block = "Complete block and lot field";
                this.error_selected_lot = "Complete block and lot field";
            }

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
            if (!this.selected_tag) {
                this.error_selected_tag = "This tag field is required.";
            }
        },

        getBlockLot() {
            this.selected_block_lot = null;
            this.$store.dispatch("lots/getBlockLots", this.selected_block);
        },
    },
    mounted() {
        this.$store.dispatch("blocks/getAll");
        this.$store.dispatch("lots/getAll");
    },
};
</script>

<style scoped>
.login100-form {
    height: auto;
    width: 720px;
    left: 0px;
    top: 0px;
    margin-top: 50px;
    margin-right: auto;
    margin-left: auto;
    margin-bottom: 50px;
    padding: 30px;
    box-sizing: border-box;
    background-color: rgb(255, 255, 255);
    border-radius: 5px;
    box-shadow: rgb(123 158 176 / 10%) 0px 2px 10px 4px;
}

.Silingan-logo {
    height: 50px;
    width: 179px;
    margin-bottom: 30px;
    text-align: center;
}

.custom-text {
    white-space: pre-wrap;
    overflow: visible;
    padding-bottom: 0px;
    font-family: Poppins;
    font-size: 14px;
    color: rgb(59, 59, 59);
    margin-top: 30px;

    text-align: center;
    line-height: 1.4;
    border-radius: 0px;
}

.custom-link {
    font-family: Poppins;
    font-size: 14px;
    color: rgb(0, 203, 255);
    text-align: center;
    line-height: 1.4;
    border-radius: 0px;
    cursor: pointer;
}

.login-btn {
    height: 40px;
    width: 345px;
    left: 0px;
    top: 0px;
    padding: 0px;
    cursor: pointer;
    background: none rgb(27, 120, 242);
    border: 1px none rgb(27, 120, 242);
    text-align: center;
    font-family: Poppins;
    font-size: 14px;
    font-weight: 500;
    color: rgb(255, 255, 255);
    line-height: 1;
    border-radius: 8px;
    transition: background 250ms ease 0s;
    box-shadow: none;
}

.input100 {
    width: 410px;
}

.ch-remember {
    padding-left: 10px;
}

.link-forgot {
    padding-left: 70px;
}

.title-form {
    margin-top: 20px;
}
</style>
