<template>
    <div>
        <Toast />
        <div class="grid">
            <div class="col-12">
                <h1>Positions</h1>
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
                                    label="Add Position"
                                    icon="pi pi-plus"
                                    class="p-button-success p-mr-2"
                                    @click="createPosition"
                                />
                            </div>
                        </template>
                    </Toolbar>
                </div>
            </div>
            <div class="grid">
                <div class="col-12">
                    <DataTable
                        :value="positions"
                        :filters="filters"
                        breakpoint="1230px"
                    >
                        <template #empty> No positions found </template>
                        <!-- <Column header="ID" field="id"> </Column> -->
                        <Column header="Position name" field="name"> </Column>

                        <Column header="Actions" field="actions">
                            <template #body="{ data }">
                                <Button
                                    icon="pi pi-pencil"
                                    class="p-button-rounded p-button-primary mr-2"
                                    @click="updatePosition(data)"
                                />
                                <Button
                                    icon="pi pi-trash"
                                    class="p-button-rounded p-button-danger"
                                    @click="deletePosition(data)"
                                />
                            </template>
                        </Column>
                    </DataTable>

                    <Dialog
                        v-model:visible="deletePositionDialog"
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
                                        position <b>{{ name }}</b
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
                                @click="deletePositionDialog = false"
                            />
                            <Button
                                label="Delete"
                                icon="pi pi-check"
                                class="p-button-text p-button-danger"
                                @click="confirmDeletePosition"
                            />
                        </template>
                    </Dialog>
                    <Dialog
                        v-model:visible="updatePositionDialog"
                        :style="{ width: '500px' }"
                        header="Update Position"
                        :modal="true"
                    >
                        <div class="grid">
                            <div class="col-12">
                                <div class="field">
                                    <label>Position name</label>
                                    <InputText
                                        v-model="name"
                                        :class="{
                                            'p-invalid': error_name,
                                        }"
                                        class="w-full"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_name"
                                        >{{ error_name }}</label
                                    >
                                </div>
                            </div>
                        </div>
                        <template #footer>
                            <Button
                                label="Cancel"
                                icon="pi pi-times"
                                class="p-button-text"
                                @click="updatePositionDialog = false"
                            />
                            <Button
                                label="Update"
                                icon="pi pi-check"
                                class="p-button-text p-button-warning"
                                @click="confirmUpdatePosition"
                            />
                        </template>
                    </Dialog>
                    <Dialog
                        v-model:visible="createPositionDialog"
                        :style="{ width: '500px' }"
                        header="Create Position"
                        :modal="true"
                    >
                        <div class="grid">
                            <div class="col-12">
                                <div class="field">
                                    <label>Position name</label>
                                    <InputText
                                        v-model="name"
                                        :class="{
                                            'p-invalid': error_name,
                                        }"
                                        class="w-full"
                                    />
                                    <label
                                        style="color: red"
                                        for="form.password"
                                        v-if="error_name"
                                        >{{ error_name }}</label
                                    >
                                </div>
                            </div>
                        </div>
                        <template #footer>
                            <Button
                                label="Cancel"
                                icon="pi pi-times"
                                class="p-button-text"
                                @click="createPositionDialog = false"
                            />
                            <Button
                                label="Create"
                                icon="pi pi-check"
                                class="p-button-text p-button-success"
                                @click="onCreatePositionsClick"
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
    name: "PositionComponent",
    setup() {
        const store = useStore();

        return {
            positions: computed(() => store.state.positions.positions),
            users: computed(() => store.state.registeredUsers.registeredUsers),
        };
    },
    data() {
        return {
            filters: {},

            loading: false,
            createPositionDialog: false,
            deletePositionDialog: false,
            updatePositionDialog: false,

            id: null,
            name: null,
            selected_user: null,
            error_name: null,
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

        deletePosition(data) {
            this.id = data.id;
            this.name = data.name;
            this.deletePositionDialog = true;
        },
        showDeletePositiontToast() {
            this.$toast.add({
                severity: "success",
                summary: "Successful Request",
                detail: "Deleted Position",
                life: 3000,
            });
        },
        async confirmDeletePosition() {
            this.loading = true;
            await axios({
                method: "delete",
                url: "/api/position/" + this.id,
            })
                .then(() => {
                    this.deletePositionDialog = false;
                    this.$store.dispatch("positions/getAll");
                    this.showDeletePositiontToast();
                    this.loading = false;
                })
                .catch((err) => {
                    console.log(err.response);
                    this.resetErrors();
                    this.loading = false;
                });
        },

        updatePosition(data) {
            this.resetFields();
            this.resetErrors();
            this.id = data.id;
            this.name = data.name;
            this.updatePositionDialog = true;
        },
        showUpdatePositionToast() {
            this.$toast.add({
                severity: "success",
                summary: "Successful Request",
                detail: "Updated Position",
                life: 3000,
            });
        },
        async confirmUpdatePosition() {
            this.loading = true;
            await axios({
                method: "put",
                url: "/api/position/" + this.id,
                data: {
                    name: this.name,
                },
            })
                .then(() => {
                    this.updatePositionDialog = false;
                    this.$store.dispatch("positions/getAll");
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
                detail: "Created Position",
                life: 3000,
            });
        },
        //REGISTER POSITION
        createPosition() {
            this.createPositionDialog = true;
            this.resetFields();
            this.resetErrors();
        },
        async onCreatePositionsClick() {
            this.loading = true;
            await axios({
                method: "post",
                url: "/api/position",
                data: {
                    name: this.name,
                },
            })
                .then(() => {
                    this.createPositionDialog = false;
                    this.$store.dispatch("positions/getAll");
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
                    pos_id: this.id,
                    user_id: this.getBlockLot(),
                },
            });
        },

        resetFields() {
            this.id = null;
            this.name = null;
        },
        resetErrors() {
            this.error_name = "";
        },
        validate(error) {
            if (error.name) this.error_name = error.name[0];
        },
        refreshList() {},

        getBlockLot() {
            this.$store.dispatch("users/getAll", this.selected_user);
        },
    },
    created() {
        this.initFilters();
    },
    mounted() {},
};
</script>

<style scoped></style>
