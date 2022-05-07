<template>
    <div>
        <Toast />
        <div class="grid">
            <div class="col-12">
                <h1>Expense Types</h1>
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
                                    @click="addExpenseType()"
                                />
                            </div>
                        </template>
                    </Toolbar>
                </div>
            </div>
            <DataTable :value="expense_type" :rows="15" :filters="filters">
                <template #empty> No Expense Type found </template>
                <template #loading> Loading data </template>
                <Column field="id" header="ID"></Column>
                <Column field="name" header="Name"></Column>
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
            <!-- Add Expense Type Modal -->
            <Dialog
                header="Add Expense Type"
                v-model:visible="addExpenseTypeModal"
                :style="{ width: '40vw' }"
                :modal="true"
            >
                <div class="grid p-fluid">
                    <div class="col-12 lg:col-6">
                        <h5>Name</h5>
                        <InputText
                            v-model="add_expensetype.name"
                            :useGrouping="false"
                            :class="{
                                'p-invalid': expensetype_valid.state.name,
                            }"
                        />
                        <small
                            v-if="expensetype_valid.state.name"
                            class="p-error"
                            >{{ expensetype_valid.msg.name }}</small
                        >
                    </div>
                </div>
                <template #footer>
                    <Button
                        class="p-button-success"
                        label="Submit"
                        icon="pi pi-check"
                        @click="confirmAddExpenseType()"
                        autofocus
                    />
                </template>
            </Dialog>
            <!-- Edit Expense Type Modal -->
            <Dialog
                header="Edit Colleciton Type"
                v-model:visible="editExpenseTypeModal"
                :style="{ width: '40vw' }"
                :modal="true"
            >
                <div class="grid p-fluid">
                    <div class="col-12 lg:col-6">
                        <h5>Name</h5>
                        <InputText
                            v-model="add_expensetype.name"
                            :useGrouping="false"
                            :class="{
                                'p-invalid': expensetype_valid.state.name,
                            }"
                        />
                        <small
                            v-if="expensetype_valid.state.name"
                            class="p-error"
                            >{{ expensetype_valid.msg.name }}</small
                        >
                    </div>
                </div>
                <template #footer>
                    <Button
                        class="p-button-success"
                        label="Submit"
                        icon="pi pi-check"
                        @click="confirmEditExpenseType()"
                        autofocus
                    />
                </template>
            </Dialog>
            <Dialog
                v-model:visible="deleteExpenseTypeModal"
                :style="{ width: '500px' }"
                header="Delete Expense Type"
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
                                <b>{{ add_expensetype.name }}</b
                                >?</span
                            >
                        </div>
                    </div>
                </div>
                <template #footer>
                    <Button
                        label="Cancel"
                        class="p-button-text p-button-primary"
                        @click="deleteExpenseTypeModal = false"
                    />
                    <Button
                        label="Delete"
                        class="p-button p-button-danger"
                        @click="confirmDeleteExpenseType"
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
            expense_type: computed(() => store.state.expenseType.ExpenseType),
        };
    },
    data() {
        return {
            process: false,

            //MOdal Control
            addExpenseTypeModal: false,
            editExpenseTypeModal: false,
            deleteExpenseTypeModal: false,
            //Add and Edit Form
            type_id: null,
            add_expensetype: {
                name: null,
            },
            //validation
            expensetype_valid: {
                state: {
                    name: false,
                },
                msg: {
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
                        this.editExpenseTypeModal = true;
                    },
                },
                {
                    label: "Delete",
                    icon: "pi pi-trash",
                    command: () => {
                        this.deleteExpenseTypeModal = true;
                    },
                },
            ],
        };
    },
    methods: {
        async confirmAddExpenseType() {
            this.resetFormError();
            this.process = true;
            try {
                await axios({
                    url: "/api/expense_type",
                    method: "post",
                    data: {
                        name: this.add_expensetype.name,
                    },
                });
                this.process = false;
                this.$store.dispatch("expenseType/getAll");
                this.showSuccess();
                this.addExpenseTypeModal = false;
            } catch (error) {
                this.process = false;
                this.FormError(error.response.data);
                console.log(error.response.data);
            }
        },
        async confirmEditExpenseType() {
            this.resetFormError();
            this.process = true;
            try {
                await axios({
                    url: "/api/expense_type/" + this.type_id,
                    method: "put",
                    data: {
                        name: this.add_expensetype.name,
                    },
                });
                this.process = false;
                this.$store.dispatch("expenseType/getAll");
                this.showSuccess();
                this.editExpenseTypeModal = false;
            } catch (error) {
                this.process = false;
                this.FormError(error.response.data);
                console.log(error.response.data);
            }
        },
        async confirmDeleteExpenseType() {
            this.process = true;
            try {
                await axios({
                    url: "/api/expense_type/" + this.type_id,
                    method: "delete",
                });
                this.process = false;
                this.$store.dispatch("expenseType/getAll");
                this.showSuccess();
                this.deleteExpenseTypeModal = false;
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
            if (e.errors.name) {
                this.expensetype_valid.state.name = true;
                this.expensetype_valid.msg.name = e.errors.name[0];
            }
        },
        resetFormError() {
            this.expensetype_valid = {
                state: {
                    name: false,
                },
                msg: {
                    name: null,
                },
            };
        },
        populateFields(data) {
            this.add_expensetype.name = data.name;
            this.type_id = data.id;
        },
        addExpenseType() {
            this.addExpenseTypeModal = true;
            this.add_expensetype = {
                name: null,
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
