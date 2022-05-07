<template>
    <div>
        <Toast />
        <div class="grid">
            <div class="col-12">
                <h1>Collection Types</h1>
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
                                    @click="addCollectionType()"
                                />
                            </div>
                        </template>
                    </Toolbar>
                </div>
            </div>
            <DataTable :value="collection_type" :rows="15" :filters="filters">
                <template #empty> No Collection Type found </template>
                <template #loading> Loading data </template>
                <Column field="id" header="ID"></Column>
                <Column field="name" header="Name"></Column>
                <Column field="amount" header="Amount"></Column>
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
            <!-- Add Collection Type Modal -->
            <Dialog
                header="Add Collection Type"
                v-model:visible="addCollectionTypeModal"
                :style="{ width: '40vw' }"
                :modal="true"
            >
                <div class="grid p-fluid">
                    <div class="col-12 lg:col-6">
                        <h5>Name</h5>
                        <InputText
                            v-model="add_collectiontype.name"
                            :useGrouping="false"
                            :class="{
                                'p-invalid': collectiontype_valid.state.name,
                            }"
                        />
                        <small
                            v-if="collectiontype_valid.state.name"
                            class="p-error"
                            >{{ collectiontype_valid.msg.name }}</small
                        >
                    </div>
                    <div class="col-12 lg:col-6">
                        <h5>Amount</h5>
                        <InputNumber
                            v-model="add_collectiontype.amount"
                            mode="currency"
                            currency="PHP"
                            :useGrouping="false"
                            :class="{
                                'p-invalid': collectiontype_valid.state.amount,
                            }"
                            :min="1"
                        />
                        <small
                            v-if="collectiontype_valid.state.amount"
                            class="p-error"
                            >{{ collectiontype_valid.msg.amount }}</small
                        >
                    </div>
                </div>
                <template #footer>
                    <Button
                        class="p-button-success"
                        label="Submit"
                        icon="pi pi-check"
                        @click="confirmAddCollectionType()"
                        autofocus
                    />
                </template>
            </Dialog>
            <!-- Edit Collection Type Modal -->
            <Dialog
                header="Edit Colleciton Type"
                v-model:visible="editCollectionTypeModal"
                :style="{ width: '40vw' }"
                :modal="true"
            >
                <div class="grid p-fluid">
                    <div class="col-12 lg:col-6">
                        <h5>Name</h5>
                        <InputText
                            v-model="add_collectiontype.name"
                            :useGrouping="false"
                            :class="{
                                'p-invalid': collectiontype_valid.state.name,
                            }"
                        />
                        <small
                            v-if="collectiontype_valid.state.name"
                            class="p-error"
                            >{{ collectiontype_valid.msg.name }}</small
                        >
                    </div>
                    <div class="col-12 lg:col-6">
                        <h5>Amount</h5>
                        <InputNumber
                            v-model="add_collectiontype.amount"
                            mode="currency"
                            currency="PHP"
                            :useGrouping="false"
                            :class="{
                                'p-invalid': collectiontype_valid.state.amount,
                            }"
                            :min="1"
                        />
                        <small
                            v-if="collectiontype_valid.state.amount"
                            class="p-error"
                            >{{ collectiontype_valid.msg.amount }}</small
                        >
                    </div>
                </div>
                <template #footer>
                    <Button
                        class="p-button-success"
                        label="Submit"
                        icon="pi pi-check"
                        @click="confirmEditCollectionType()"
                        autofocus
                    />
                </template>
            </Dialog>
            <Dialog
                v-model:visible="deleteCollectionTypeModal"
                :style="{ width: '500px' }"
                header="Delete Collection Type"
                :modal="true"
                :draggable="false"
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
                                <b>{{ add_collectiontype.name }}</b
                                >?</span
                            >
                        </div>
                    </div>
                </div>
                <template #footer>
                    <Button
                        label="Cancel"
                        class="p-button-text p-button-primary"
                        @click="deleteCollectionTypeModal = false"
                    />
                    <Button
                        label="Delete"
                        class="p-button p-button-danger"
                        @click="confirmDeleteCollectionType"
                    />
                </template>
            </Dialog>
            <Dialog
                v-model:visible="process"
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
</template>

<script>
import axios from "axios";
import { FilterMatchMode } from "primevue/api";
import { computed } from "vue";
import { useStore } from "vuex";
export default {
    setup() {
        const store = useStore();
        return {
            collection_type: computed(
                () => store.state.collectionType.CollectionType
            ),
        };
    },
    data() {
        return {
            process: false,

            //MOdal Control
            addCollectionTypeModal: false,
            editCollectionTypeModal: false,
            deleteCollectionTypeModal: false,
            //Add and Edit Form
            type_id: null,
            add_collectiontype: {
                name: null,
                amount: null,
            },
            //validation
            collectiontype_valid: {
                state: {
                    amount: false,
                    name: false,
                },
                msg: {
                    amount: null,
                    name: null,
                },
            },

            filters: {},
            menus: [
                {
                    label: "Update",
                    icon: "pi pi-pencil",
                    command: () => {
                        this.resetFormError();
                        this.editCollectionTypeModal = true;
                    },
                },
                {
                    label: "Delete",
                    icon: "pi pi-trash",
                    command: () => {
                        this.deleteCollectionTypeModal = true;
                    },
                },
            ],
        };
    },
    methods: {
        async confirmAddCollectionType() {
            this.resetFormError();
            this.process = true;
            try {
                await axios({
                    url: "/api/collection_type",
                    method: "post",
                    data: {
                        name: this.add_collectiontype.name,
                        amount: this.add_collectiontype.amount,
                    },
                });
                this.process = false;
                this.$store.dispatch("collectionType/getAll");
                this.showSuccess();
                this.addCollectionTypeModal = false;
            } catch (error) {
                this.process = false;
                this.FormError(error.response.data);
                console.log(error.response.data);
            }
        },
        async confirmEditCollectionType() {
            this.resetFormError();
            this.process = true;
            try {
                await axios({
                    url: "/api/collection_type/" + this.type_id,
                    method: "put",
                    data: {
                        name: this.add_collectiontype.name,
                        amount: this.add_collectiontype.amount,
                    },
                });
                this.process = false;
                this.$store.dispatch("collectionType/getAll");
                this.showSuccess();
                this.editCollectionTypeModal = false;
            } catch (error) {
                this.process = false;
                this.FormError(error.response.data);
                console.log(error.response.data);
            }
        },
        async confirmDeleteCollectionType() {
            this.process = true;
            try {
                await axios({
                    url: "/api/collection_type/" + this.type_id,
                    method: "delete",
                });
                this.process = false;
                this.$store.dispatch("collectionType/getAll");
                this.showSuccess();
                this.deleteCollectionTypeModal = false;
            } catch (error) {
                this.process = false;
            }
        },
        showSuccess() {
            this.$toast.add({
                severity: "success",
                summary: "Success Message",
                detail: "Successfully Process Request",
                life: 3000,
            });
        },
        FormError(e) {
            if (e.errors.amount) {
                this.collectiontype_valid.state.amount = true;
                this.collectiontype_valid.msg.amount = e.errors.amount[0];
            }
            if (e.errors.name) {
                this.collectiontype_valid.state.name = true;
                this.collectiontype_valid.msg.name = e.errors.name[0];
            }
        },
        resetFormError() {
            this.collectiontype_valid = {
                state: {
                    amount: false,
                    name: false,
                },
                msg: {
                    amount: null,
                    name: null,
                },
            };
        },
        populateFields(data) {
            this.add_collectiontype.name = data.name;
            this.add_collectiontype.amount = data.amount;
            this.type_id = data.id;
        },
        addCollectionType() {
            this.addCollectionTypeModal = true;
            this.add_collectiontype = {
                name: null,
                amount: null,
            };
        },
        toggle(data) {
            this.$refs.menu.toggle(event);
            this.populateFields(data);
        },
        initFilters() {
            this.filters = {
                global: { value: null, matchMode: FilterMatchMode.CONTAINS },
            };
        },
    },
    created() {
        this.initFilters();
    },
};
</script>

<style></style>
