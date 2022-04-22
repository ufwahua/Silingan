<template>
    <div>
        <div class="grid">
            <div class="col-12">
                <h1 class="text-center">Blocks</h1>
            </div>
        </div>
        <div class="grid mb-2 flex justify-content-center">
            <div class="col-12 lg:col-6 xl:col-3">
                <div class="card mb-0 bg-yellow-400">
                    <div class="flex justify-content-between mb-3">
                        <div>
                            <span
                                class="block font-medium text-4xl font-bold mb-3"
                                >{{ blocks.length }}</span
                            >
                            <div class="text-900">Blocks</div>
                        </div>

                        <div
                            class="flex align-items-center justify-content-center"
                            style="width: 2.5rem; height: 2.5rem"
                        ></div>
                    </div>
                </div>
            </div>
            <div class="col-12 lg:col-6 xl:col-3">
                <div class="card mb-0 bg-purple-100">
                    <div class="flex justify-content-between mb-3">
                        <div>
                            <span
                                class="block font-medium text-4xl font-bold mb-3"
                                >{{ lots.length }}</span
                            >
                            <div class="text-900">Lots</div>
                        </div>

                        <div
                            class="flex align-items-center justify-content-center"
                            style="width: 2.5rem; height: 2.5rem"
                        ></div>
                    </div>
                </div>
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
                                    label="Add"
                                    icon="pi pi-plus"
                                    class="p-button-primary p-mr-2"
                                    v-tooltip="'Add Blocks'"
                                    @click="openAddBlockModal"
                                />
                            </div>
                        </template>
                    </Toolbar>
                </div>
            </div>
            <div class="grid">
                <div class="col-12">
                    <DataTable
                        :value="blocks"
                        :filters="filters"
                        :paginator="true"
                        :rows="10"
                    >
                        <template #empty> No Blocks found </template>
                        <template #loading> Loading </template>

                        <Column field="number" header="Block Number">
                            <template #body="{ data }">
                                Block {{ data.number }}
                            </template></Column
                        >

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
                </div>
            </div>
            <!-- Block Modal -->
            <Dialog
                v-model:visible="addBlockModal"
                :style="{ width: '450px' }"
                header="Create blocks"
                :modal="true"
                :closeOnEscape="true"
            >
                <div class="grid">
                    <div class="col-12">
                        <div class="p-fluid">
                            <h5>Block</h5>
                            <InputText
                                id="number"
                                type="number"
                                :class="{ 'p-invalid': error }"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                class="inputfield w-full"
                                v-model="form_block_number"
                            />
                            <label style="color: red" v-if="error">{{
                                this.error
                            }}</label>
                        </div>
                    </div>
                </div>
                <template #footer>
                    <Button
                        label="Cancel"
                        icon="pi pi-times"
                        class="p-button-text"
                        @click="closeBlockModal"
                    />
                    <Button
                        label="Create"
                        icon="pi pi-check"
                        class="p-button-text p-button-success"
                        @click="confirmCreateBlock()"
                    />
                </template>
            </Dialog>

            <!-- Lot Modal -->
            <Dialog
                v-model:visible="lotModal"
                :style="{ width: '800px' }"
                :modal="true"
                :closeOnEscape="true"
            >
                <template #header>
                    <h3>Block {{ number }}</h3>
                </template>
                <div class="grid mb-2 flex justify-content-center">
                    <div class="col-12 lg:col-6 xl:col-3">
                        <div class="card mb-0 bg-purple-100">
                            <div class="flex justify-content-between mb-3">
                                <div>
                                    <span
                                        class="block font-medium text-4xl font-bold mb-3"
                                        >{{ filteredLots.length }}</span
                                    >
                                    <div class="text-900">Lots</div>
                                </div>

                                <div
                                    class="flex align-items-center justify-content-center"
                                    style="width: 2.5rem; height: 2.5rem"
                                ></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
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
                                            label="Add"
                                            icon="pi pi-plus"
                                            class="p-button-primary p-mr-2"
                                            @click="openAddLotModal()"
                                        />
                                    </div>
                                </template>
                            </Toolbar>
                        </div>
                    </div>

                    <div class="grid">
                        <div class="col-12">
                            <DataTable :value="filteredLots" :filters="filters">
                                <template #empty> No Lots found </template>
                                <template #loading> Loading </template>

                                <Column field="number" header="Lot Houses">
                                    <template #body="{ data }">
                                        Lot {{ data.number }}
                                    </template></Column
                                >

                                <Column header="Actions" field="actions">
                                    <template #body="{ data }">
                                        <Button
                                            type="button"
                                            icon="pi pi-ellipsis-h"
                                            class="p-button-rounded p-button-info"
                                            @click="toggleLot(data)"
                                            aria-haspopup="true"
                                            aria-controls="lot_overlay"
                                        />
                                        <Menu
                                            id="lot_overlay"
                                            ref="menu_lot"
                                            :model="lot_menu"
                                            :popup="true"
                                        />
                                    </template>
                                </Column>
                            </DataTable>
                        </div>
                    </div>

                    <Dialog
                        v-model:visible="addLotModal"
                        :style="{ width: '450px' }"
                        header="Create Lot"
                        :modal="true"
                        :closeOnEscape="true"
                    >
                        <div class="grid">
                            <div class="col-12">
                                <div class="p-fluid">
                                    <h5>Lots</h5>
                                    <InputText
                                        id="number"
                                        type="number"
                                        :class="{ 'p-invalid': error }"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                        class="inputfield w-full"
                                        v-model="form_lot_number"
                                    />
                                    <label style="color: red" v-if="error">{{
                                        this.error
                                    }}</label>
                                </div>
                            </div>
                        </div>
                        <template #footer>
                            <Button
                                label="Cancel"
                                icon="pi pi-times"
                                class="p-button-text"
                                @click="closeAddLotModal()"
                            />
                            <Button
                                label="Create"
                                icon="pi pi-check"
                                class="p-button-text p-button-success"
                                @click="confirmCreateLot()"
                            />
                        </template>
                    </Dialog>

                    <Dialog
                        v-model:visible="updateLotModal"
                        :style="{ width: '450px' }"
                        header="Edit"
                        :modal="true"
                        :closeOnEscape="true"
                    >
                        <div class="grid">
                            <div class="col-12">
                                <div class="p-fluid">
                                    <h5>Lot Number</h5>
                                    <InputText
                                        :class="{ 'p-invalid': error }"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                        v-model="form_lot_number"
                                    />
                                    <label style="color: red" v-if="error">{{
                                        this.error
                                    }}</label>
                                </div>
                            </div>
                        </div>
                        <template #footer>
                            <Button
                                label="Cancel"
                                icon="pi pi-times"
                                class="p-button-text"
                                @click="closeUpdateLotModal"
                            />
                            <Button
                                label="Edit"
                                icon="pi pi-check"
                                class="p-button-text p-button-warning"
                                @click="confirmEditLot"
                            />
                        </template>
                    </Dialog>
                    <Dialog
                        v-model:visible="deleteLotModal"
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
                                        <b>Lot {{ form_lot_number }}</b
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
                                @click="deleteLotModal = false"
                            />
                            <Button
                                label="Delete"
                                icon="pi pi-check"
                                class="p-button-text p-button-danger"
                                @click="confirmDeleteLot()"
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
            </Dialog>

            <Dialog
                v-model:visible="updateBlockModal"
                :style="{ width: '450px' }"
                header="Edit"
                :modal="true"
                :closeOnEscape="true"
            >
                <div class="grid">
                    <div class="col-12">
                        <div class="p-fluid">
                            <h5>Block Number</h5>
                            <InputText
                                :class="{ 'p-invalid': error }"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                v-model="number"
                            />
                            <label style="color: red" v-if="error">{{
                                this.error
                            }}</label>
                        </div>
                    </div>
                </div>
                <template #footer>
                    <Button
                        label="Cancel"
                        icon="pi pi-times"
                        class="p-button-text"
                        @click="closeUpdateBlockModal()"
                    />
                    <Button
                        label="Edit"
                        icon="pi pi-check"
                        class="p-button-text p-button-warning"
                        @click="confirmEditBlock()"
                    />
                </template>
            </Dialog>
            <Dialog
                v-model:visible="deleteModal"
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
                                <b>Block {{ number }}</b
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
                        @click="deleteModal = false"
                    />
                    <Button
                        label="Delete"
                        icon="pi pi-check"
                        class="p-button-text p-button-danger"
                        @click="confirmDeleteBlock()"
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
                </div> </Dialog
            ><Dialog
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
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import ColumnGroup from "primevue/columngroup";
import Button from "primevue/button";
import Toolbar from "primevue/toolbar";
import { FilterMatchMode } from "primevue/api";
import InputText from "primevue/inputtext";
import Dialog from "primevue/dialog";
import Card from "primevue/card";
import axios from "axios";
import { computed } from "vue";
import { useStore } from "vuex";

export default {
    number: "DeviceBlockComponent",
    setup() {
        const store = useStore();

        return {
            blocks: computed(() => store.state.blocks.blocks),
            filteredLots: computed(() => store.state.lots.filteredLots),
            lots: computed(() => store.state.lots.lots),
        };
    },
    components: {
        DataTable,
        InputText,
        Column,
        ColumnGroup,
        Toolbar,
        Button,
        Dialog,
        Card,
    },
    data() {
        return {
            block: null,
            block_id: null,
            number: null,

            lot: null,
            lot_id: null,
            number: null,
            filters: {},
            search: null,
            loading: false,
            actions: null,
            form_block_number: null,
            form_lot_number: null,
            error: null,

            //BLOCK MODAL
            addBlockModal: false,
            updateBlockModal: false,
            deleteModal: false,

            //LOT MODAL
            lotModal: false,
            addLotModal: false,
            updateLotModal: false,
            deleteLotModal: false,

            //action menu overlay
            menus: [
                {
                    label: "View Lots",
                    icon: "pi pi-plus",
                    command: () => {
                        this.openLotModal();
                    },
                },
                {
                    label: "Edit",
                    icon: "pi pi-pencil",
                    command: () => {
                        this.openEditBlockModal();
                    },
                },
                {
                    label: "Delete",
                    icon: "pi pi-trash",
                    command: () => {
                        this.openDeleteBlockModal();
                    },
                },
            ],
            lot_menu: [
                {
                    label: "Edit",
                    icon: "pi pi-pencil",
                    command: () => {
                        this.openEditLotModal();
                    },
                },
                {
                    label: "Delete",
                    icon: "pi pi-trash",
                    command: () => {
                        this.openDeleteLotModal();
                    },
                },
            ],
        };
    },
    methods: {
        toggleLot(data) {
            this.$refs.menu_lot.toggle(event);
            this.populateLotFields(data);
        },
        toggle(data) {
            this.$refs.menu.toggle(event);
            this.populateFields(data);
        },
        populateLotFields(data) {
            this.resetFields();
            this.lot_id = data.id;
            this.block_id = data.block_id;
            this.form_lot_number = data.number;
        },
        populateFields(data) {
            this.number = data.number;
            this.block_id = data.id;
        },
        initFilters() {
            this.filters = {
                global: { value: null, matchMode: FilterMatchMode.CONTAINS },
            };
        },
        resetFields() {
            this.form_block_number = null;
            this.form_lot_number = null;
            this.error = null;
        },

        // Open Block Modal
        openAddBlockModal() {
            this.addBlockModal = true;
            this.form_block_number = null;
            this.error = null;
        },
        closeBlockModal() {
            this.addBlockModal = false;
            this.resetFields();
        },
        showAddBlockToast() {
            this.$toast.add({
                severity: "success",
                summary: "Success Message",
                detail: "Added new block",
                life: 3000,
            });
            this.resetFields();
        },

        async confirmCreateBlock() {
            this.loading = true;
            await axios({
                method: "post",
                url: "/api/block",
                data: {
                    number: this.form_block_number,
                },
            })
                .then((res) => {
                    this.addBlockModal = false;
                    this.$store.dispatch("blocks/getAll");
                    this.showAddBlockToast();
                    this.loading = false;
                })
                .catch((error) => {
                    if (error.response.data.errors.number)
                        this.error = error.response.data.errors.number[0];
                    this.loading = false;
                });
        },
        // Edit Block Modal
        openEditBlockModal() {
            this.updateBlockModal = true;
        },
        closeUpdateBlockModal() {
            this.updateBlockModal = false;
            this.resetFields();
        },
        showUpdateBlockToast() {
            this.$toast.add({
                severity: "success",
                summary: "Success Message",
                detail: "Updated block",
                life: 3000,
            });
            this.resetFields();
        },
        async confirmEditBlock() {
            this.loading = true;
            await axios({
                method: "put",
                url: "/api/block/" + this.block_id,
                data: {
                    number: this.number,
                },
            })
                .then((res) => {
                    this.updateBlockModal = false;
                    this.$store.dispatch("blocks/getAll");
                    this.showUpdateBlockToast();
                    this.loading = false;
                })
                .catch((error) => {
                    if (error.response.data.errors.number)
                        this.error = error.response.data.errors.number[0];
                    this.loading = false;
                });
        },
        // Delete Block Modal
        openDeleteBlockModal() {
            this.deleteModal = true;
        },

        showDeleteBlockToast() {
            this.$toast.add({
                severity: "success",
                summary: "Successful Request",
                detail: "Deleted block",
                life: 3000,
            });
            this.resetFields();
        },

        async confirmDeleteBlock() {
            this.loading = true;
            await axios({
                method: "delete",
                url: "/api/block/" + this.block_id,
            })
                .then((res) => {
                    this.deleteModal = false;
                    this.$store.dispatch("blocks/getAll");
                    this.showDeleteBlockToast();
                    this.loading = false;
                })
                .catch((error) => {
                    console.log(error);
                    this.loading = false;
                });
        },

        // Open Lot Modal
        openLotModal() {
            this.lotModal = true;
            this.$store.dispatch("lots/getBlockLots", this.block_id);
        },
        closeLotModal() {
            this.lotModal = false;
            this.resetFields();
        },

        // Open Add Lot Modal
        openAddLotModal() {
            this.resetFields();
            this.addLotModal = true;
        },
        closeAddLotModal() {
            this.addLotModal = false;
            this.resetFields();
        },
        showAddLotToast() {
            this.$toast.add({
                severity: "success",
                summary: "Success Message",
                detail: "Added new lot",
                life: 3000,
            });
            this.resetFields();
        },
        async confirmCreateLot() {
            this.loading = true;
            await axios({
                method: "post",
                url: "/api/lot",
                data: {
                    block_id: this.block_id,
                    number: this.form_lot_number,
                },
            })
                .then((res) => {
                    console.log("post lot", res.data);
                    this.addLotModal = false;
                    this.$store.dispatch("lots/getAll");
                    this.$store.dispatch("lots/getBlockLots", this.block_id);
                    this.showAddLotToast();
                    this.loading = false;
                })
                .catch((error) => {
                    console.log(error.response);
                    if (error.response.data.error)
                        this.error = error.response.data.error;
                    this.lot = [];
                    this.loading = false;
                });
        },

        //Open  Edit Lot Modal
        openEditLotModal() {
            this.updateLotModal = true;
            console.log(this.lot_id, this.block_id, this.form_lot_number);
        },
        closeUpdateLotModal() {
            this.updateLotModal = false;
            this.resetFields();
            this.error = null;
        },
        showUpdateLotToast() {
            this.$toast.add({
                severity: "success",
                summary: "Success Message",
                detail: "Updated Lot",
                life: 3000,
            });
            this.resetFields();
        },
        async confirmEditLot() {
            this.loading = true;
            await axios({
                method: "put",
                url: "/api/lot/" + this.lot_id,
                data: {
                    block_id: this.block_id,
                    number: this.form_lot_number,
                },
            })
                .then((res) => {
                    this.updateLotModal = false;
                    this.$store.dispatch("lots/getBlockLots", this.block_id);
                    this.showUpdateLotToast();
                    this.loading = false;
                })
                .catch((error) => {
                    this.error = error.response.data;
                    this.loading = false;
                });
        },
        // Delete Lot Modal
        openDeleteLotModal() {
            this.deleteLotModal = true;
        },

        showDeleteToast() {
            this.$toast.add({
                severity: "success",
                summary: "Successful Request",
                detail: "Deleted block",
                life: 3000,
            });
            this.resetFields();
        },

        async confirmDeleteLot() {
            this.loading = true;
            await axios({
                method: "delete",
                url: "/api/lot/" + this.lot_id,
            })
                .then((res) => {
                    this.deleteLotModal = false;
                    this.$store.dispatch("lots/getBlockLots", this.block_id);
                    this.showDeleteToast();
                    this.loading = false;
                })
                .catch((error) => {
                    this.lot = [];
                    console.log(error);
                    this.loading = false;
                });
        },
    },

    created() {
        this.initFilters();
    },
};
</script>

<style></style>
