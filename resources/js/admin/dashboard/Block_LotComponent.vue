<template>
    <div>
        <div class="grid">
            <div class="col-12">
                <h1>Block</h1>
            </div>
        </div>
        <div class="card">
            <div class="grid mb-4">
                <div class="col-12">
                    <Toolbar>
                        <template #left>
                            <span class="p-input-icon-left inline-block">
                                <i class="pi pi-search" />
                                <InputText
                                    v-model="filters['global'].value"
                                    placeholder="Keyword Search"
                                />
                            </span>
                        </template>

                        <template #right>
                            <div class="mr-2">
                                <Button
                                    label="Add"
                                    icon="pi pi-plus"
                                    class="p-button-success p-mr-2"
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
                    <DataTable :value="block" :filters="filters">
                        <template #empty> No Blocks found </template>
                        <template #loading> Loading </template>

                        <Column field="block_number" header="Block Number">
                            <template #body="{ data }">
                                Block {{ data.block_number }}
                            </template></Column
                        >

                        <Column header="Actions" field="actions">
                            <template #body="{ data }">
                                <Button
                                    icon="pi pi-plus"
                                    class="p-button-rounded p-button-success mr-1"
                                    v-tooltip="'Add lots'"
                                    @click="openLotModal(data.block_number)"
                                />
                                <Button
                                    icon="pi pi-pencil"
                                    class="p-button-rounded p-button-primary mr-1"
                                    v-tooltip="'Edit'"
                                    @click="
                                        openEditBlockModal(
                                            data.block_number,
                                            data.id
                                        )
                                    "
                                />
                                <Button
                                    icon="pi pi-trash"
                                    class="p-button-rounded p-button-danger"
                                    v-tooltip="'Delete'"
                                    @click="
                                        openDeleteBlockModal(
                                            data.block_number,
                                            data.id
                                        )
                                    "
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
                                id="block_number"
                                type="number"
                                min="0"
                                step="1"
                                onfocus="this.previousValue = this.value"
                                onkeydown="this.previousValue = this.value"
                                oninput="validity.valid || (value = this.previousValue)"
                                class="inputfield w-full"
                                v-model="form_block_number"
                                placeholder="How many blocks you want to create"
                            />
                            <label
                                style="color: red"
                                for="block_number"
                                v-if="error"
                                >{{ this.error }}</label
                            >
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
                :header="block_number"
                :modal="true"
                :closeOnEscape="true"
            >
                <div class="card">
                    <div class="grid mb-4">
                        <div class="col-12">
                            <Toolbar>
                                <template #left>
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

                                <template #right>
                                    <div class="mr-2">
                                        <Button
                                            label="Add"
                                            icon="pi pi-plus"
                                            class="p-button-success p-mr-2"
                                            @click="openAddLotModal()"
                                        />
                                    </div>
                                </template>
                            </Toolbar>
                        </div>
                    </div>

                    <div class="grid">
                        <div class="col-12">
                            <DataTable :value="lot" :filters="filters">
                                <template #empty> No Lots found </template>
                                <template #loading> Loading </template>

                                <Column field="lot_number" header="Lot Houses">
                                    <template #body="{ data }">
                                        Lot {{ data.lot_number }}
                                    </template></Column
                                >

                                <Column header="Actions" field="actions">
                                    <template #body="{ data }">
                                        <Button
                                            icon="pi pi-pencil"
                                            class="p-button-rounded p-button-primary mr-1"
                                            v-tooltip="'Edit'"
                                            @click="
                                                openEditLotModal(
                                                    data.id,
                                                    data.block_id,
                                                    data.lot_number
                                                )
                                            "
                                        />
                                        <Button
                                            icon="pi pi-trash"
                                            class="p-button-rounded p-button-danger"
                                            v-tooltip="'Delete'"
                                            @click="
                                                openDeleteLotModal(
                                                    data.id,
                                                    data.lot_number
                                                )
                                            "
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
                                        id="lot_number"
                                        type="number"
                                        min="0"
                                        step="1"
                                        onfocus="this.previousValue = this.value"
                                        onkeydown="this.previousValue = this.value"
                                        oninput="validity.valid || (value = this.previousValue)"
                                        class="inputfield w-full"
                                        v-model="form_lot_number"
                                        placeholder="How many lots you want to create"
                                    />
                                    <label
                                        style="color: red"
                                        for="lot_number"
                                        v-if="error"
                                        >{{ this.error }}</label
                                    >
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
                                    <InputText v-model="form_lot_number" />
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
                                        <b>Lot {{ lot_number }}</b
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
                        v-model:visible="process"
                        :style="{ width: '450px' }"
                        :modal="true"
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
                                <span class="block">Processing Request...</span>
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
                            <InputText v-model="block_number" />
                            <label
                                style="color: red"
                                for="block_number"
                                v-if="error"
                                >{{ this.error }}</label
                            >
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
                                <b>Block {{ block_number }}</b
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
                v-model:visible="process"
                :style="{ width: '450px' }"
                :modal="true"
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
                        <span class="block">Processing Request...</span>
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

export default {
    block_number: "DeviceBlockComponent",
    setup() {},
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
            block_number: null,

            lot: null,
            lot_id: null,
            lot_number: null,
            filters: {},
            search: null,
            process: false,
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
        };
    },
    methods: {
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

        //GET BLOCK
        async getBlock() {
            await axios({
                method: "get",
                url: "/api/block/",
            })
                .then((res) => {
                    this.block = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
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
            this.process = true;
            await axios({
                method: "post",
                url: "/api/block",
                data: {
                    block_number: this.form_block_number,
                },
            })
                .then((res) => {
                    this.addBlockModal = false;
                    this.getBlock();
                    this.showAddBlockToast();
                    this.process = false;
                })
                .catch((error) => {
                    if (error.response.data.errors.block_number)
                        this.error = error.response.data.errors.block_number[0];
                    this.process = false;
                });
        },
        // Edit Block Modal
        openEditBlockModal(block_number, block_id) {
            this.block_id = block_id;
            this.block_number = block_number;
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
            this.process = true;
            await axios({
                method: "put",
                url: "/api/block/" + this.block_id,
                data: {
                    block_number: this.block_number,
                },
            })
                .then((res) => {
                    this.updateBlockModal = false;
                    this.getBlock();
                    this.showUpdateBlockToast();
                    this.process = false;
                })
                .catch((error) => {
                    if (error.response.data.errors.block_number)
                        this.error = error.response.data.errors.block_number[0];
                    this.process = false;
                });
        },
        // Delete Block Modal
        openDeleteBlockModal(block_number, block_id) {
            this.block_id = block_id;
            this.block_number = block_number;
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
            this.process = true;
            await axios({
                method: "delete",
                url: "/api/block/" + this.block_id,
            })
                .then((res) => {
                    this.deleteModal = false;
                    this.getBlock();
                    this.showDeleteBlockToast();
                    this.process = false;
                })
                .catch((error) => {
                    console.log(error);
                    this.process = false;
                });
        },

        //LOT
        async getLot() {
            await axios({
                method: "get",
                url: "/api/lot/" + this.block_id,
            })
                .then((res) => {
                    this.lot = res.data;
                })
                .catch((error) => {
                    this.lot = null;
                    console.log(error);
                });
        },

        // Open Lot Modal
        openLotModal(block_number) {
            this.block_id = block_number;
            this.block_number = "Block " + block_number;
            this.lotModal = true;
            this.getLot();
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
            this.process = true;
            await axios({
                method: "post",
                url: "/api/lot",
                data: {
                    block_id: this.block_id,
                    lot_number: this.form_lot_number,
                },
            })
                .then((res) => {
                    this.addLotModal = false;
                    this.getLot();
                    this.showAddLotToast();
                    this.process = false;
                })
                .catch((error) => {
                    if (error.response.data.errors.lot)
                        this.error = error.response.data.errors.lot_number[0];
                    this.lot = [];
                    this.process = false;
                });
        },

        //Open  Edit Lot Modal
        openEditLotModal(lot_id, block_id, lot_number) {
            this.resetFields();
            this.lot_id = lot_id;
            this.block_id = block_id;
            this.form_lot_number = lot_number;
            this.updateLotModal = true;
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
            this.process = true;
            await axios({
                method: "put",
                url: "/api/lot/" + this.lot_id,
                data: {
                    id: this.lot_id,
                    block_id: this.block_id,
                    lot_number: this.form_lot_number,
                },
            })
                .then(() => {
                    console.log(
                        "id",
                        this.lot_id,
                        "block_id",
                        this.block_id,
                        "lot_number",
                        this.form_lot_number
                    );
                    this.updateLotModal = false;
                    this.getLot();
                    this.showUpdateLotToast();
                    this.process = false;
                })
                .catch((error) => {
                    console.log(error);
                    this.error = "The lot number has already been taken.";
                    this.process = false;
                });
        },
        // Delete Lot Modal
        openDeleteLotModal(lot_id, lot_number) {
            this.lot_id = lot_id;
            this.lot_number = lot_number;
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
            this.process = true;
            await axios({
                method: "delete",
                url: "/api/lot/" + this.lot_id,
            })
                .then((res) => {
                    this.deleteLotModal = false;
                    this.getLot();
                    this.showDeleteToast();
                    this.process = false;
                })
                .catch((error) => {
                    this.lot = [];
                    console.log(error);
                    this.process = false;
                });
        },
    },

    created() {
        this.initFilters();
    },
    mounted() {
        this.getBlock();
    },
};
</script>

<style></style>
