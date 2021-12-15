<template>
    <div>
        <div class="grid">
            <div class="col-12">
                <h1>Lot</h1>
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
                                    @click="openBlockModal"
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

                        <Column field="block_number" header="Lot Number">
                            <template #body="{ data }">
                                Block {{ data.block_number }}
                            </template></Column
                        >

                        <Column header="Actions" field="actions">
                            <template #body="{ data }">
                                <Button
                                    icon="pi pi-pencil"
                                    class="
                                        p-button-rounded p-button-primary
                                        mr-2
                                    "
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

            <Dialog
                v-model:visible="createModal"
                :style="{ width: '450px' }"
                header="Create new block"
                :modal="true"
                :closeOnEscape="true"
            >
                <div class="grid">
                    <div class="col-12">
                        <div class="p-fluid">
                            <h5>Lot</h5>
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
                        @click="closeCreateModal()"
                    />
                    <Button
                        label="Create"
                        icon="pi pi-check"
                        class="p-button-text p-button-success"
                        @click="confirmCreateBlock()"
                    />
                </template>
            </Dialog>

            <Dialog
                v-model:visible="updateModal"
                :style="{ width: '450px' }"
                header="Edit"
                :modal="true"
                :closeOnEscape="true"
            >
                <div class="grid">
                    <div class="col-12">
                        <div class="p-fluid">
                            <h5>Lot Number</h5>
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
                        @click="closeUpdateModal()"
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
                            class="
                                col-12
                                flex
                                align-items-center
                                justify-content-center
                            "
                        >
                            <i
                                class="pi pi-exclamation-triangle mr-3"
                                style="font-size: 2rem"
                            />
                            <span
                                >Are you sure you want to delete
                                <b>Lot {{ block_number }}</b
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
                        <span class="block">Processeing Request...</span>
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
            id: null,
            block_number: null,
            filters: {},
            search: null,
            process: false,
            actions: null,
            form_block_number: null,
            error: null,

            //MODAL
            createModal: false,
            updateModal: false,
            deleteModal: false,
        };
    },
    methods: {
        // Create New Lot Modal
        openBlockModal() {
            this.createModal = true;
            this.form_block_number = null;
            this.error = null;
        },
        openEditBlockModal(block_number, id) {
            this.id = id;
            this.block_number = block_number;
            console.log(this.block_number);
            this.updateModal = true;
        },
        openDeleteBlockModal(block_number, id) {
            this.id = id;
            this.block_number = block_number;
            this.deleteModal = true;
        },

        initFilters() {
            this.filters = {
                global: { value: null, matchMode: FilterMatchMode.CONTAINS },
            };
        },
        resetFields() {
            this.form_block_number = null;
            this.error = null;
        },
        showCreateToast() {
            this.$toast.add({
                severity: "success",
                summary: "Success Message",
                detail: "Added new block",
                life: 3000,
            });
            this.resetFields();
        },
        closeCreateModal() {
            this.createModal = false;
            this.resetFields();
        },
        showUpdateToast() {
            this.$toast.add({
                severity: "success",
                summary: "Success Message",
                detail: "Updated block",
                life: 3000,
            });
            this.resetFields();
        },
        closeUpdateModal() {
            this.updateModal = false;
            this.resetFields();
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

        async getBlock() {
            try {
                const { data } = await axios({
                    method: "get",
                    url: "/api/block/",
                });
                this.block = data;
            } catch (error) {
                console.log(error);
            }
            this.process = false;
        },
        async confirmCreateBlock() {
            try {
                this.process = true;
                await axios({
                    method: "post",
                    url: "/api/block",
                    data: {
                        block_number: this.form_block_number,
                    },
                })
                    .then((res) => {
                        this.createModal = false;
                        this.getBlock();
                        this.showCreateToast();
                    })
                    .catch((error) => {
                        if (error.response.data.errors.block_number)
                            this.error =
                                error.response.data.errors.block_number[0];
                        this.process = false;
                    });
            } catch (error) {
                this.process = false;
                console.log(error);
            }
        },

        async confirmEditBlock() {
            try {
                this.process = true;
                await axios({
                    method: "put",
                    url: "/api/block/" + this.id,
                    data: {
                        block_number: this.block_number,
                    },
                })
                    .then((res) => {
                        this.updateModal = false;
                        this.getBlock();
                        this.showUpdateToast();
                    })
                    .catch((error) => {
                        if (error.response.data.errors.block_number)
                            this.error =
                                error.response.data.errors.block_number[0];
                        this.process = false;
                        console.log(error);
                    });
            } catch (error) {
                this.process = false;
                console.log(error);
            }
        },
        async confirmDeleteBlock() {
            try {
                this.process = true;
                await axios({
                    method: "delete",
                    url: "/api/block/" + this.id,
                })
                    .then((res) => {
                        this.deleteModal = false;
                        this.getBlock();
                        this.showDeleteToast();
                    })
                    .catch((error) => {
                        this.process = false;
                        console.log(error);
                    });
            } catch (error) {
                this.process = false;
                console.log(error);
            }
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
