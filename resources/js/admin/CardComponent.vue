<template>
    <div>
        <Toast />
        <div class="grid">
            <div class="col-12">
                <h1 class="layout-text">Cards</h1>
            </div>
        </div>
        <div class="grid mb-2 flex justify-flex-start">
            <div class="col-12 lg:col-6 xl:col-3">
                <div class="card mb-0 bg-green-100">
                    <div class="flex justify-content-between mb-3">
                        <div>
                            <span
                                class="block font-medium text-4xl font-bold mb-3"
                                >{{ available }}</span
                            >
                            <div class="text-900">available</div>
                        </div>
                        <div
                            class="flex align-items-center justify-content-center"
                            style="width: 2.5rem; height: 2.5rem"
                        ></div>
                    </div>
                </div>
            </div>
            <div class="col-12 lg:col-6 xl:col-3">
                <div class="card mb-0 bg-pink-100">
                    <div class="flex justify-content-between mb-3">
                        <div>
                            <span
                                class="block font-medium text-4xl font-bold mb-3"
                                >{{ not_available }}</span
                            >
                            <div class="text-900">Not Available</div>
                        </div>

                        <div
                            class="flex align-items-center justify-content-center"
                            style="width: 2.5rem; height: 2.5rem"
                        ></div>
                    </div>
                </div>
            </div>

            <div class="col-12 lg:col-6 xl:col-3">
                <div class="card mb-0 bg-blue-100">
                    <div class="flex justify-content-between mb-3">
                        <div>
                            <span
                                class="block font-medium text-4xl font-bold mb-3"
                                >{{ total }}</span
                            >
                            <div class="text-900">Total</div>
                        </div>
                        <div
                            class="flex align-items-center justify-content-center"
                            style="width: 2.5rem; height: 2.5rem"
                        ></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid p-fluid">
            <div class="col-12">
                <div class="card">
                    <DataTable
                        :value="cards"
                        :filters="filters"
                        breakpoint="1230px"
                        :paginator="true"
                        :rows="15"
                    >
                        <div class="grid formgrid">
                            <div class="col-12 mb-2 lg:col-4 lg:mb-0">
                                <span class="p-input-icon-left">
                                    <i class="pi pi-search" />
                                    <InputText
                                        v-model="filters['global'].value"
                                        placeholder="Keyword Search"
                                    />
                                </span>
                            </div>
                            <div class="col-12 mb-2 lg:col-4 lg:mb-0">
                                <Dropdown
                                    v-model="filters['availability'].value"
                                    :showClear="true"
                                    :options="availability"
                                    optionLabel="availability"
                                    optionValue="value"
                                    placeholder="Filter by availability"
                                    @change="getFilterBlockLot"
                                ></Dropdown>
                            </div>
                            <div
                                class="col-12 mb-2 lg:col-4 lg:mb-0 flex justify-content-end"
                            >
                                <Button
                                    icon="pi pi-filter-slash"
                                    class="my-2 p-button-outlined p-button-secondary"
                                    @click="clearFilter"
                                    v-tooltip="'Clear'"
                                />
                                <Button
                                    label="Add"
                                    icon="pi pi-plus"
                                    class="ml-2 my-2 p-button-primary"
                                    style="width: auto"
                                    @click="createPosition"
                                />
                            </div>
                        </div>
                        <template #empty> No cards found </template>

                        <Column header="Number" field="card_number">
                            <template #body="{ data }">
                                {{
                                    (data["card_number"] =
                                        "Card #" + data.number)
                                }}
                            </template>
                        </Column>

                        <Column header="Logged by" field="name">
                            <template #body="{ data }">
                                <div v-if="!data.availability">
                                    {{
                                        (data["name"] =
                                            data.log.user_login.first_name +
                                            " " +
                                            data.log.user_login.last_name)
                                    }}
                                </div>
                            </template>
                        </Column>
                        <Column header="Holder" field="logged_named">
                            <template #body="{ data }">
                                <div v-if="!data.availability">
                                    {{ (data["logged_named"] = data.log.name) }}
                                </div>
                            </template>
                        </Column>
                        <Column header="Availability" field="availability">
                            <template #body="{ data }">
                                <Badge
                                    v-if="data.availability"
                                    :class="badgecolor(data.availability)"
                                    >available</Badge
                                >
                                <Badge
                                    v-else
                                    :class="badgecolor(data.availability)"
                                    >not available</Badge
                                >
                            </template>
                        </Column>
                        <Column header="Date Logged" field="log.updated_at">
                            <template #body="{ data }">
                                <div v-if="!data.availability">
                                    {{ dateFormat(data.log.updated_at) }}
                                </div>
                            </template>
                        </Column>
                        <Column header="Actions" field="actions">
                            <template #body="{ data }">
                                <Button
                                    type="button"
                                    icon="pi pi-ellipsis-h"
                                    class="p-button-rounded p-button-info"
                                    @click="toggle(data)"
                                    aria-haspopup="true"
                                    aria-controls="overlay_menu"
                                />
                                <Menu
                                    id="overlay_menu"
                                    ref="menu"
                                    :model="menus"
                                    :popup="true"
                                />
                            </template>
                        </Column>
                    </DataTable>

                    <Dialog
                        v-model:visible="deleteCardDialog"
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
                                        >Are you sure you want to delete card #
                                        <b>{{ number }}</b
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
                                @click="deleteCardDialog = false"
                            />
                            <Button
                                label="Delete"
                                icon="pi pi-check"
                                class="p-button-text p-button-danger"
                                @click="confirmDeleteCard"
                            />
                        </template>
                    </Dialog>
                    <Dialog
                        v-model:visible="updateCardDialog"
                        :style="{ width: '500px' }"
                        header="Update Card"
                        :modal="true"
                    >
                        <div class="grid">
                            <div class="col-12">
                                <div class="field">
                                    <label>Card name</label>
                                    <InputText
                                        v-model="number"
                                        :class="{
                                            'p-invalid': error_number,
                                        }"
                                        class="w-full"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_number"
                                        >{{ error_number }}</label
                                    >
                                </div>
                            </div>
                        </div>
                        <template #footer>
                            <Button
                                label="Cancel"
                                icon="pi pi-times"
                                class="p-button-text"
                                @click="updateCardDialog = false"
                            />
                            <Button
                                label="Update"
                                icon="pi pi-check"
                                class="p-button-text p-button-success"
                                @click="confirmUpdateCard"
                            />
                        </template>
                    </Dialog>
                    <Dialog
                        v-model:visible="createCardDialog"
                        :style="{ width: '500px' }"
                        header="Create Card"
                        :modal="true"
                    >
                        <div class="grid">
                            <div class="col-12">
                                <div class="field">
                                    <label>Card name</label>
                                    <InputText
                                        v-model="number"
                                        :class="{
                                            'p-invalid': error_number,
                                        }"
                                        class="w-full"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_number"
                                        >{{ error_number }}</label
                                    >
                                </div>
                            </div>
                        </div>
                        <template #footer>
                            <Button
                                label="Cancel"
                                icon="pi pi-times"
                                class="p-button-text"
                                @click="createCardDialog = false"
                            />
                            <Button
                                label="Create"
                                icon="pi pi-check"
                                class="p-button-text p-button-success"
                                @click="addClick"
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
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import { FilterMatchMode } from "primevue/api";
import { computed } from "vue";
import { useStore } from "vuex";
// import store from "../store/store";

export default {
    name: "CardComponent",
    setup() {
        const store = useStore();

        return {
            cards: computed(() => store.state.cards.allCards),
            users: computed(() => store.state.users),
            available: computed(() => {
                let available = [];
                store.state.cards.allCards.forEach((elem) => {
                    if (elem.availability == true) {
                        available.push(elem);
                    }
                });

                return available.length;
            }),
            not_available: computed(() => {
                let not_available = [];
                store.state.cards.allCards.forEach((elem) => {
                    if (elem.availability == false) {
                        not_available.push(elem);
                    }
                });

                return not_available.length;
            }),

            total: computed(() => {
                let total = [];
                store.state.cards.allCards.forEach((elem) => {
                    total.push(elem);
                });
                return total.length;
            }),
        };
    },
    data() {
        return {
            filters: {},

            loading: false,
            createCardDialog: false,
            deleteCardDialog: false,
            updateCardDialog: false,

            id: null,
            number: null,
            card_availability: null,
            selected_user: null,
            error_number: null,
            availability: [
                { availability: "available", value: true },
                { availability: "not available", value: false },
            ],
            //action menu overlay
            menus: [
                {
                    label: "Edit",
                    icon: "pi pi-pencil",
                    command: () => {
                        this.updatePosition();
                    },
                },
                {
                    label: "Delete",
                    icon: "pi pi-trash",
                    command: () => {
                        this.deletePosition();
                    },
                },
            ],
        };
    },
    methods: {
        dateFormat(date) {
            var options = {
                year: "numeric",
                month: "long",
                day: "numeric",
                hour12: true,
                hour: "numeric",
                minute: "numeric",
            };

            return new Date(date).toLocaleDateString("en-US", options);
        },
        clearFilter() {
            this.filters["availability"].value = null;
        },
        badgecolor(color) {
            if (color == 1) {
                return "bg-green-500";
            } else {
                return "bg-gray-500";
            }
        },
        toggle(data) {
            this.$refs.menu.toggle(event);
            this.populateFields(data);
        },
        populateFields(data) {
            this.resetFields();
            this.resetErrors();
            this.id = data.id;
            this.number = data.number;
            this.card_availability = data.availability;
        },
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
                availability: {
                    value: null,
                    matchMode: FilterMatchMode.EQUALS,
                },
            };
        },

        deletePosition() {
            this.deleteCardDialog = true;
        },
        showDeletePositionToast() {
            this.$toast.add({
                severity: "success",
                summary: "Successful Request",
                detail: "Deleted Card",
                life: 3000,
            });
        },
        async confirmDeleteCard() {
            this.loading = true;
            await axios({
                method: "delete",
                url: "/api/card/" + this.id,
            })
                .then(() => {
                    this.deleteCardDialog = false;
                    this.$store.dispatch("cards/getAllCards");
                    this.showDeletePositionToast();
                    this.loading = false;
                })
                .catch((err) => {
                    console.log(err.response);
                    this.resetErrors();
                    this.loading = false;
                });
        },

        updatePosition() {
            this.updateCardDialog = true;
        },
        showUpdatePositionToast() {
            this.$toast.add({
                severity: "success",
                summary: "Successful Request",
                detail: "Updated Card",
                life: 3000,
            });
        },
        async confirmUpdateCard() {
            this.loading = true;
            await axios({
                method: "put",
                url: "/api/card/" + this.id,
                data: {
                    number: this.number,
                    availability: this.card_availability,
                },
            })
                .then(() => {
                    this.updateCardDialog = false;
                    this.$store.dispatch("cards/getAllCards");
                    this.loading = false;
                    this.showUpdatePositionToast();
                })
                .catch((err) => {
                    this.resetErrors();
                    this.validate(err.response.data.errors);
                    this.loading = false;
                });
        },
        showCreatePositionToast() {
            this.$toast.add({
                severity: "success",
                summary: "Successful Request",
                detail: "Created Card",
                life: 3000,
            });
        },
        //REGISTER POSITION
        createPosition() {
            this.createCardDialog = true;
            this.resetFields();
            this.resetErrors();
        },
        async addClick() {
            this.loading = true;
            await axios({
                method: "post",
                url: "/api/card",
                data: {
                    number: this.number,
                    availability: 1,
                },
            })
                .then(() => {
                    this.createCardDialog = false;
                    this.$store.dispatch("cards/getAllCards");
                    this.showCreatePositionToast();
                    this.loading = false;
                })
                .catch((err) => {
                    this.resetErrors();
                    this.validate(err.response.data.errors);
                    this.loading = false;
                });

            await axios({
                method: "post",
                url: "/api/candidate",
                data: {
                    position_id: this.id,
                    user_id: this.getBlockLot(),
                },
            });
        },

        resetFields() {
            this.id = null;
            this.number = null;
        },
        resetErrors() {
            this.error_number = "";
        },
        validate(error) {
            if (error.number) this.error_number = error.number[0];
        },
        refreshList() {},

        getBlockLot() {
            this.$store.dispatch("users/getAll", this.selected_user);
        },
    },
    mounted() {
        console.log(this.allCards);
    },
    created() {
        this.initFilters();
    },
};
</script>

<style scoped></style>
