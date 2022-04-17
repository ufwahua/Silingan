<template>
    <div>
        <Toast />
        <div class="card">
            <h5>Logs</h5>
            <TabView class="tabview-custom" ref="tabview4">
                <TabPanel>
                    <template #header>
                        <i class="pi pi-user mr-2"></i>
                        <span>Visitor</span>
                    </template>

                    <div class="grid mb-4">
                        <div class="col-12">
                            <Toolbar>
                                <template #start>
                                    <span
                                        class="p-input-icon-left inline-block"
                                    >
                                        <i class="pi pi-search" />
                                        <InputText
                                            v-model="filters['global'].value"
                                            placeholder="Keyword Search"
                                        />
                                    </span>
                                </template>
                            </Toolbar>
                        </div>
                    </div>
                    <div class="grid">
                        <div class="col-12">
                            <DataTable
                                :value="visitor_logs"
                                :filters="filters"
                                breakpoint="1230px"
                                :paginator="true"
                                :rows="15"
                            >
                                <template #empty> No Visitors found </template>
                                <template #loading> Loading Visitors </template>

                                <Column header="Name" field="name"> </Column>
                                <Column header="Card" field="card.number">
                                </Column>
                                <Column header="Login" field="created_at">
                                </Column>
                                <Column header="Logout" field="updated_at">
                                </Column>
                                <Column header="Actions" field="actions">
                                    <template #body="{ data }">
                                        <Button
                                            icon="pi pi-pencil"
                                            class="p-button-rounded p-button-primary mr-2"
                                            v-tooltip="'Edit Log'"
                                            @click="updateLog(data)"
                                        />
                                        <Button
                                            icon="pi pi-user-minus"
                                            class="p-button-rounded p-button-danger"
                                            v-tooltip="'Logout'"
                                            @click="logout(data)"
                                        />
                                    </template>
                                </Column>
                            </DataTable>
                        </div>
                    </div>
                </TabPanel>
                <TabPanel>
                    <template #header>
                        <i class="pi pi-car mr-2"></i>
                        <span>Vehicles</span>
                    </template>

                    <div class="grid mb-4">
                        <div class="col-12">
                            <Toolbar>
                                <template #start>
                                    <span
                                        class="p-input-icon-left inline-block"
                                    >
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
                                            label="Log in"
                                            icon="pi pi-user-plus"
                                            class="p-button-success p-mr-2"
                                            @click="LogVehicle"
                                        />
                                    </div>
                                </template>
                            </Toolbar>
                        </div>
                    </div>
                    <div class="grid">
                        <div class="col-12">
                            <DataTable
                                :value="vehicle_logs"
                                :filters="filters"
                                breakpoint="1230px"
                                :paginator="true"
                                :rows="15"
                            >
                                <template #empty> No Vehicles found </template>
                                <template #loading> Loading Visitors </template>

                                <Column
                                    header="Plate Number"
                                    field="plate_number"
                                >
                                </Column>
                                <Column header="Card" field="card.number">
                                </Column>
                                <Column header="Login" field="created_at">
                                </Column>
                                <Column header="Logout" field="updated_at">
                                </Column>
                                <Column header="Actions" field="actions">
                                    <template #body="{ data }">
                                        <Button
                                            icon="pi pi-pencil"
                                            class="p-button-rounded p-button-primary mr-2"
                                            v-tooltip="'Edit Log'"
                                            @click="updateLog(data)"
                                        />
                                        <Button
                                            icon="pi pi-user-minus"
                                            class="p-button-rounded p-button-danger"
                                            v-tooltip="'Logout'"
                                            @click="logout(data)"
                                        />
                                    </template>
                                </Column>
                            </DataTable>
                        </div>
                    </div>
                </TabPanel>
            </TabView>
        </div>
        <div class="card">
            <h5>Log</h5>
            <TabView class="tabview-custom" ref="tabview4">
                <TabPanel>
                    <template #header>
                        <i class="pi pi-user mr-2"></i>
                        <span>Visitor</span>
                    </template>

                    <div class="grid mb-4">
                        <div class="col-12">
                            <Toolbar>
                                <template #start>
                                    <span
                                        class="p-input-icon-left inline-block"
                                    >
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
                                            label="Log in"
                                            icon="pi pi-user-plus"
                                            class="p-button-success p-mr-2"
                                            @click="LogVisitor"
                                        />
                                    </div>
                                </template>
                            </Toolbar>
                        </div>
                    </div>
                    <div class="grid">
                        <div class="col-12">
                            <DataTable
                                :value="visitors"
                                :filters="filters"
                                breakpoint="1230px"
                                :paginator="true"
                                :rows="15"
                            >
                                <template #empty> No Visitors found </template>
                                <template #loading> Loading Visitors </template>

                                <Column header="Name" field="name"> </Column>
                                <Column header="Card" field="card.number">
                                </Column>
                                <Column header="Login" field="created_at">
                                </Column>

                                <Column header="Actions" field="actions">
                                    <template #body="{ data }">
                                        <Button
                                            icon="pi pi-pencil"
                                            class="p-button-rounded p-button-primary mr-2"
                                            v-tooltip="'Edit Log'"
                                            @click="updateLog(data)"
                                        />
                                        <Button
                                            icon="pi pi-user-minus"
                                            class="p-button-rounded p-button-danger"
                                            v-tooltip="'Logout'"
                                            @click="logout(data)"
                                        />
                                    </template>
                                </Column>
                            </DataTable>
                        </div>
                    </div>
                </TabPanel>
                <TabPanel>
                    <template #header>
                        <i class="pi pi-car mr-2"></i>
                        <span>Vehicles</span>
                    </template>

                    <div class="grid mb-4">
                        <div class="col-12">
                            <Toolbar>
                                <template #start>
                                    <span
                                        class="p-input-icon-left inline-block"
                                    >
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
                                            label="Log in"
                                            icon="pi pi-user-plus"
                                            class="p-button-success p-mr-2"
                                            @click="LogVehicle"
                                        />
                                    </div>
                                </template>
                            </Toolbar>
                        </div>
                    </div>
                    <div class="grid">
                        <div class="col-12">
                            <DataTable
                                :value="vehicles"
                                :filters="filters"
                                breakpoint="1230px"
                                :paginator="true"
                                :rows="15"
                            >
                                <template #empty> No Vehicles found </template>
                                <template #loading> Loading Visitors </template>

                                <Column
                                    header="Plate Number"
                                    field="plate_number"
                                >
                                </Column>
                                <Column header="Card" field="card.number">
                                </Column>
                                <Column header="Login" field="created_at">
                                </Column>
                                <Column header="Actions" field="actions">
                                    <template #body="{ data }">
                                        <Button
                                            icon="pi pi-pencil"
                                            class="p-button-rounded p-button-primary mr-2"
                                            v-tooltip="'Edit Log'"
                                            @click="updateLog(data)"
                                        />
                                        <Button
                                            icon="pi pi-user-minus"
                                            class="p-button-rounded p-button-danger"
                                            v-tooltip="'Logout'"
                                            @click="logout(data)"
                                        />
                                    </template>
                                </Column>
                            </DataTable>
                        </div>
                    </div>
                </TabPanel>
            </TabView>
        </div>
        <Dialog
            v-model:visible="logOutDialog"
            :style="{ width: '450px' }"
            header="Logout"
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
                            >Logout
                            <b>{{
                                name === null
                                    ? "Plate number: " + plate_number
                                    : name
                            }}</b
                            >?</span
                        >
                    </div>
                </div>
            </div>
            <template #footer>
                <Button
                    label="Cancel"
                    class="p-button-text"
                    @click="logOutDialog = false"
                />
                <Button
                    label="Logout"
                    class="p-button p-button-danger"
                    @click="logOut"
                />
            </template>
        </Dialog>
        <Dialog
            v-model:visible="logUpdate"
            :style="{ width: '500px' }"
            header="Update Log"
            :modal="true"
        >
            <div class="grid">
                <div class="col-12">
                    <div v-if="log_type === 'visitor'" class="field">
                        <label>Name</label>
                        <InputText
                            v-model="name"
                            :class="{
                                'p-invalid': error_name,
                            }"
                            class="w-full"
                        />
                        <label style="color: red" v-if="error_name">{{
                            error_name
                        }}</label>
                    </div>
                    <div v-else class="field">
                        <label>Plate number</label>
                        <InputText
                            v-model="plate_number"
                            :class="{
                                'p-invalid': error_name,
                            }"
                            class="w-full"
                        />
                        <label style="color: red" v-if="error_name">{{
                            error_name
                        }}</label>
                    </div>
                </div>
            </div>
            <template #footer>
                <Button
                    label="Cancel"
                    icon="pi pi-times"
                    class="p-button-text"
                    @click="logUpdate = false"
                />
                <Button
                    label="Update"
                    icon="pi pi-check"
                    class="p-button-text p-button-warning"
                    @click="confirmUpdateVisitor"
                    :disabled="name || plate_number ? false : true"
                />
            </template>
        </Dialog>
        <Dialog
            v-model:visible="logVisitorDialog"
            :style="{ width: '500px' }"
            header="Log In"
            :modal="true"
        >
            <div class="grid">
                <div class="col-12">
                    <div class="field">
                        <label>Name</label>
                        <InputText
                            v-model="name"
                            :class="{
                                'p-invalid': error_name,
                            }"
                            class="w-full"
                        />
                        <label style="color: red" v-if="error_name">{{
                            error_name
                        }}</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="field">
                        <label>Card Number</label>
                        <Dropdown
                            v-model="selected_card"
                            :options="cards"
                            optionLabel="number"
                            :class="{
                                'p-invalid': error_card,
                            }"
                            optionValue="id"
                            :filter="true"
                            :showClear="true"
                            class="w-full"
                        />

                        <label style="color: red" v-if="error_card">{{
                            error_card
                        }}</label>
                    </div>
                </div>
            </div>
            <template #footer>
                <Button
                    label="Cancel"
                    class="p-button-text"
                    @click="logVisitorDialog = false"
                />
                <Button
                    label="Log in"
                    class="p-button p-button-success"
                    @click="logIn('visitor')"
                    :disabled="!name"
                />
            </template>
        </Dialog>
        <Dialog
            v-model:visible="logVehicleDialog"
            :style="{ width: '500px' }"
            header="Log In"
            :modal="true"
        >
            <div class="grid">
                <div class="col-12">
                    <div class="field">
                        <label>Plate Number</label>
                        <InputText
                            v-model="plate_number"
                            :class="{
                                'p-invalid': error_plate_number,
                            }"
                            class="w-full"
                        />
                        <label style="color: red" v-if="error_plate_number">{{
                            error_plate_number
                        }}</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="field">
                        <label>Card Number</label>
                        <Dropdown
                            v-model="selected_card"
                            :options="cards"
                            optionLabel="number"
                            :class="{
                                'p-invalid': error_card,
                            }"
                            optionValue="id"
                            :filter="true"
                            :showClear="true"
                            class="w-full"
                        />

                        <label style="color: red" v-if="error_card">{{
                            error_card
                        }}</label>
                    </div>
                </div>
            </div>
            <template #footer>
                <Button
                    label="Cancel"
                    class="p-button-text"
                    @click="logVehicleDialog = false"
                />
                <Button
                    label="Log in"
                    class="p-button p-button-success"
                    @click="logIn('vehicle')"
                    :disabled="!plate_number"
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
import axios from "axios";
import { FilterMatchMode } from "primevue/api";
import { computed } from "vue";
import { useStore } from "vuex";

export default {
    name: "AnnouncementComponent",
    setup() {
        const store = useStore();

        return {
            cards: computed(() => store.state.cards.cards),
            visitor_logs: computed(() => {
                let temp = [];
                store.state.logs.logs.forEach((elem) => {
                    if (
                        elem.plate_number === null &&
                        elem.name !== null &&
                        elem.status == "logout"
                    ) {
                        temp.push(elem);
                    }
                });
                return temp;
            }),
            vehicle_logs: computed(() => {
                let temp = [];
                store.state.logs.logs.forEach((elem) => {
                    if (
                        elem.name === null &&
                        elem.plate_number !== null &&
                        elem.status == "logout"
                    ) {
                        temp.push(elem);
                    }
                });
                return temp;
            }),
            visitors: computed(() => {
                // return store.state.logs.logs;
                let temp = [];
                store.state.logs.logs.forEach((elem) => {
                    if (
                        elem.plate_number === null &&
                        elem.name !== null &&
                        elem.status == "login"
                    ) {
                        temp.push(elem);
                    }
                });
                return temp;
            }),
            vehicles: computed(() => {
                let temp = [];
                store.state.logs.logs.forEach((elem) => {
                    if (
                        elem.name === null &&
                        elem.plate_number !== null &&
                        elem.status == "login"
                    ) {
                        temp.push(elem);
                    }
                });
                return temp;
            }),
        };
    },
    data() {
        return {
            filters: {},
            // announcements: this.$store.state.announcements.announcements,
            selected_card: null,
            name: null,
            plate_number: null,
            log_type: null,
            loading: false,
            logVisitorDialog: false,
            logVehicleDialog: false,
            logOutDialog: false,
            logUpdate: false,
            id: null,

            error_name: null,
            error_card: null,
            error_plate_number: null,
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

        logout(data) {
            this.id = data.id;
            this.name = data.name;
            this.log_type = data.log_type;
            this.selected_card = data.card_id;
            this.plate_number = data.plate_number;
            this.logOutDialog = true;
        },
        showLogoutToast() {
            this.$toast.add({
                severity: "success",
                summary: "Successful Request",
                detail: "Successful Logout",
                life: 3000,
            });
        },
        async logOut() {
            this.loading = true;
            await axios({
                method: "put",
                url: "/api/log/" + this.id,
                data: {
                    user_id: this.$store.state.userLogged.id,
                    card_id: this.selected_card,
                    log_type: this.log_type,
                    name: this.name,
                    plate_number: this.plate_number,
                    status: "logout",
                },
            })
                .then(() => {
                    this.logOutDialog = false;
                    this.resetFields();
                    this.$store.dispatch("logs/getAll");
                    this.$store.dispatch("cards/getAll");
                    this.showLogoutToast();
                    this.loading = false;
                })
                .catch((err) => {
                    console.log(err.response);
                    this.resetErrors();
                    // this.validate(err);
                    this.loading = false;
                });
        },
        updateLog(data) {
            this.resetErrors();
            this.id = data.id;
            this.log_type = data.log_type;
            this.user_id = this.$store.state.userLogged.id;
            this.selected_card = data.card_id;
            this.plate_number = data.plate_number;
            this.name = data.name;
            this.logUpdate = true;
        },
        showUpdateVisitorToast() {
            this.$toast.add({
                severity: "success",
                summary: "Successful Request",
                detail: "Updated Log",
                life: 3000,
            });
        },
        async confirmUpdateVisitor() {
            this.loading = true;
            await axios({
                method: "put",
                url: "/api/log/" + this.id,
                data: {
                    user_id: this.$store.state.userLogged.id,
                    card_id: this.selected_card,
                    log_type: "visitor",
                    name: this.name,
                    plate_number: this.plate_number,
                    status: "logout",
                },
            })
                .then(() => {
                    this.logUpdate = false;
                    this.resetFields();
                    this.$store.dispatch("logs/getAll");
                    this.showUpdateVisitorToast();
                    this.loading = false;
                })
                .catch((err) => {
                    this.resetErrors();
                    this.validate();
                    this.loading = false;
                });
        },
        showLogToast() {
            this.$toast.add({
                severity: "success",
                summary: "Successful Request",
                detail: "Successfully Log",
                life: 3000,
            });
        },
        //Log Visitor
        LogVisitor() {
            this.logVisitorDialog = true;
            this.resetFields();
            this.resetErrors();
        },
        //Log Vehicle
        LogVehicle() {
            this.logVehicleDialog = true;
            this.resetFields();
            this.resetErrors();
        },
        async logIn(type) {
            this.loading = true;
            await axios({
                method: "post",
                url: "/api/log",
                data: {
                    user_id: this.$store.state.userLogged.id,
                    card_id: this.selected_card,
                    log_type: type,
                    name: this.name,
                    plate_number: this.plate_number,
                    status: "login",
                },
            })
                .then(() => {
                    this.logVisitorDialog = false;
                    this.logVehicleDialog = false;
                    this.$store.dispatch("logs/getAll");
                    this.$store.dispatch("cards/getAll");
                    this.showLogToast();
                    this.loading = false;
                })
                .catch((err) => {
                    console.log(err.response);
                    this.resetErrors();
                    this.validate();
                    this.loading = false;
                });
        },

        resetFields() {
            this.id = null;
            this.name = null;
            this.plate_number = null;
            this.selected_card = null;
        },
        resetErrors() {
            this.error_name = null;
            this.error_card = null;
        },
        validate() {
            if (this.selected_card === null) {
                this.error_card = "This field is required";
            }
        },
    },
    created() {
        this.initFilters();
    },
    mounted() {
        this.$store.dispatch("logs/getAll");
        this.$store.dispatch("cards/getAll");
    },
};
</script>

<style scoped></style>
