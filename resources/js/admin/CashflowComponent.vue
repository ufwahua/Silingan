<template>
    <div>
        <Toast />
        <h1>Total Funds</h1>
        <div class="grid">
            <div class="col-6">
                <h1 class="ml-4">₱ {{ total_funds }}</h1>
            </div>
        </div>
        <div class="card">
            <div class="grid mb-2">
                <div class="col-12">
                    <h4>Cash Flow</h4>
                </div>
            </div>
            <div class="grtid mb-2">
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
                    </Toolbar>
                </div>
            </div>
            <DataTable
                :value="cashflow"
                :paginator="true"
                :rows="15"
                :filters="filters"
            >
                <template #empty> No Cash Flow found </template>
                <template #loading> Loading data </template>
                <Column field="user" header="From">
                    <template #body="{ data }">
                        {{ data.user.first_name }} {{ data.user.last_name }}
                    </template>
                </Column>
                <Column header="Source">
                    <template #body="{ data }">
                        <div v-if="data.collection_type">
                            {{ data.collection_type.name }}
                        </div>
                        <div v-else>
                            {{ data.notes }}
                        </div>
                    </template>
                </Column>
                <Column field="amount" header="Credit/Debit">
                    <template #body="{ data }">
                        <div v-if="data.collection_type" class="text-green-700">
                            ₱{{ data.amount.toLocaleString() }}
                        </div>
                        <div v-else class="text-pink-700">
                            ₱{{ data.amount.toLocaleString() }}
                        </div>
                    </template>
                </Column>
                <Column field="running_balance" header="Running Balance">
                    <template #body="{ data }">
                        ₱{{ data.running_balance.toLocaleString() }}
                    </template>
                </Column>
            </DataTable>
        </div>
        <div class="card">
            <TabView>
                <!-- 
              REVENUE TAB 
            -->
                <TabPanel header="Revenue">
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
                                    @click="addRevenue"
                                />
                            </div>
                        </template>
                    </Toolbar>
                    <div class="grid mt-2">
                        <div class="col-12">
                            <DataTable
                                :value="revenue"
                                :paginator="true"
                                :rows="15"
                                :filters="filters"
                            >
                                <template #empty> No Revenue found </template>
                                <template #loading> Loading data </template>
                                <Column field="id" header="ID"></Column>
                                <Column field="lot" header="Block and Lot">
                                    <template #body="{ data }">
                                        Block {{ data.lot[0].block_id }} Lot
                                        {{ data.lot[0].number }}
                                    </template>
                                </Column>
                                <Column
                                    field="collection_type.name"
                                    header="Type"
                                ></Column>
                                <Column field="amount" header="Credit">
                                    <template #body="{ data }">
                                        ₱{{ data.amount }}
                                    </template>
                                </Column>
                                <Column field="notes" header="Note"></Column>
                                <Column
                                    field="created_at"
                                    header="Date and Time"
                                >
                                    <template #body="{ data }">
                                        {{
                                            new Date(
                                                data.created_at.toString()
                                            ).getMonth() + 1
                                        }}-{{
                                            new Date(
                                                data.created_at.toString()
                                            ).getDate()
                                        }}-{{
                                            new Date(
                                                data.created_at.toString()
                                            ).getFullYear()
                                        }}
                                        {{
                                            new Date(
                                                data.created_at.toString()
                                            ).getHours()
                                        }}:{{
                                            new Date(
                                                data.created_at.toString()
                                            ).getMinutes()
                                        }}
                                    </template>
                                </Column>
                            </DataTable>
                        </div>
                    </div>
                </TabPanel>
                <!-- 
            EXPENSES TAB 
            -->
                <TabPanel header="Expenses">
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
                                    @click="addExpense"
                                />
                            </div>
                        </template>
                    </Toolbar>
                    <div class="grid mt-2">
                        <div class="col-12">
                            <DataTable
                                :value="expense"
                                :paginator="true"
                                :rows="15"
                                :filters="filters"
                            >
                                <template #empty> No Revenue found </template>
                                <template #loading> Loading data </template>
                                <Column field="id" header="ID"></Column>
                                <Column field="user" header="From">
                                    <template #body="{ data }">
                                        {{ data.user.first_name }}
                                        {{ data.user.last_name }}
                                    </template>
                                </Column>
                                <Column field="notes" header="Expense"></Column>
                                <Column field="credit" header="Debit">
                                    <template #body="{ data }">
                                        ₱{{ data.amount.toLocaleString() }}
                                    </template>
                                </Column>
                                <Column
                                    field="created_at"
                                    header="Date and Time"
                                >
                                    <template #body="{ data }">
                                        {{
                                            new Date(
                                                data.created_at.toString()
                                            ).getMonth() + 1
                                        }}-{{
                                            new Date(
                                                data.created_at.toString()
                                            ).getDate()
                                        }}-{{
                                            new Date(
                                                data.created_at.toString()
                                            ).getFullYear()
                                        }}
                                        {{
                                            new Date(
                                                data.created_at.toString()
                                            ).getHours()
                                        }}:{{
                                            new Date(
                                                data.created_at.toString()
                                            ).getMinutes()
                                        }}
                                    </template>
                                </Column>
                            </DataTable>
                        </div>
                    </div>
                </TabPanel>
            </TabView>
        </div>
        <!-- 
        Dialogs
     -->

        <!-- Add Revenue Modal -->
        <Dialog
            header="Add Revenue"
            v-model:visible="addRevenueModal"
            :style="{ width: '40vw' }"
            :modal="true"
        >
            <div class="grid p-fluid">
                <div class="col-12 lg:col-6">
                    <h5>Collection Type</h5>
                    <Dropdown
                        v-model="revenue_form.collection_type"
                        :options="dropdown_collection_type"
                        optionLabel="name"
                        optionValue="code"
                        placeholder="Select Collection Type"
                        @change="setAmount()"
                        :class="{
                            'p-invalid': revenue_valid.state.collection_type,
                        }"
                    />
                    <small
                        v-if="revenue_valid.state.collection_type"
                        class="p-error"
                        >{{ revenue_valid.msg.collection_type }}</small
                    >
                </div>
                <div class="col-12 lg:col-6">
                    <h5>Amount</h5>
                    <InputNumber
                        v-model="revenue_form.amount"
                        mode="currency"
                        currency="PHP"
                        :useGrouping="false"
                        :placeholder="amount_placeholder"
                        :class="{ 'p-invalid': revenue_valid.state.amount }"
                    />
                    <small v-if="revenue_valid.state.amount" class="p-error">{{
                        revenue_valid.msg.amount
                    }}</small>
                </div>
                <div class="col-12 lg:col-6">
                    <h5>Block</h5>
                    <Dropdown
                        v-model="revenue_form.block"
                        :options="blocks"
                        optionLabel="name"
                        optionValue="code"
                        placeholder="Select Block and Lot"
                        @change="setLots()"
                        :class="{ 'p-invalid': revenue_valid.state.block }"
                    />
                    <small v-if="revenue_valid.state.block" class="p-error">{{
                        revenue_valid.msg.block
                    }}</small>
                </div>
                <div class="col-12 lg:col-6">
                    <h5>Lot</h5>
                    <Dropdown
                        v-model="revenue_form.lot"
                        :options="lot_dropdown"
                        optionLabel="name"
                        optionValue="code"
                        placeholder="Select Block and Lot"
                        :disabled="lot_bool"
                        :class="{ 'p-invalid': revenue_valid.state.lot }"
                    />
                    <small v-if="revenue_valid.state.lot" class="p-error">{{
                        revenue_valid.msg.lot
                    }}</small>
                </div>
                <div class="col-12">
                    <h5>Notes</h5>
                    <Textarea type="text" v-model="revenue_form.notes" />
                </div>
            </div>
            <template #footer>
                <Button
                    class="p-button-success"
                    label="Submit"
                    icon="pi pi-check"
                    @click="confirmAddRevenue()"
                    autofocus
                />
            </template>
        </Dialog>
        <!-- Add Expense Modal -->
        <Dialog
            header="Add Expense"
            v-model:visible="addExpenseModal"
            :style="{ width: '40vw' }"
            :modal="true"
        >
            <div class="grid p-fluid">
                <div class="col-12 lg:col-6">
                    <h5>Amount</h5>
                    <InputNumber
                        v-model="expense_form.amount"
                        mode="currency"
                        currency="PHP"
                        :useGrouping="false"
                        :class="{ 'p-invalid': expense_valid.state.amount }"
                    />
                    <small v-if="expense_valid.state.amount" class="p-error">{{
                        expense_valid.msg.amount
                    }}</small>
                </div>
                <div class="col-12 lg:col-6">
                    <h5>Official Receipt Number</h5>
                    <InputText type="text" v-model="expense_form.ornumber" />
                </div>
                <div class="col-12">
                    <h5>Notes</h5>
                    <Textarea
                        type="text"
                        v-model="expense_form.notes"
                        :class="{ 'p-invalid': expense_valid.state.notes }"
                    />
                    <small v-if="expense_valid.state.notes" class="p-error">{{
                        expense_valid.msg.notes
                    }}</small>
                </div>
            </div>
            <template #footer>
                <Button
                    class="p-button-success"
                    label="Submit"
                    icon="pi pi-check"
                    @click="confirmAddExpense()"
                    autofocus
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
</template>

<script>
import { computed } from "vue";
import { useStore } from "vuex";
import { FilterMatchMode } from "primevue/api";
import axios from "axios";
export default {
    setup() {
        const store = useStore();
        return {
            userLogged: computed(() => store.state.userLogged),
            total_funds: computed(() => store.state.fund.Fund[0].amount),
            dropdown_collection_type: computed(() => {
                let temp = [];
                store.state.collectionType.CollectionType.forEach((elem) => {
                    temp.push({
                        name: elem.name,
                        code: elem.id,
                        amount: elem.amount,
                    });
                });
                return temp;
            }),
            revenue: computed(() => store.state.collection.Collection),
            expense: computed(() => store.state.expense.Expense),
            blocks: computed(() => {
                let temp = [];
                store.state.blocks.blocks.forEach((elem) => {
                    temp.push({
                        name: elem.number,
                        code: elem.id,
                        number: elem.number,
                    });
                });
                return temp;
            }),
            lots: computed(() => store.state.lots.lots),
            cashflow: computed(() => {
                let revenue = store.state.collection.Collection;
                let expense = store.state.expense.Expense;
                let cashflow = revenue.concat(expense);
                cashflow.sort((a, b) => {
                    return new Date(b.created_at) - new Date(a.created_at);
                });
                return cashflow;
            }),
        };
    },
    data() {
        return {
            process: false,
            amount_placeholder: null,
            //Modal Control
            addRevenueModal: false,
            addExpenseModal: false,

            //Revenue
            lot_dropdown: null,
            lot_bool: true,
            revenue_form: {
                amount: null,
                collection_type: null,
                block: null,
                lot: null,
                notes: null,
            },

            //Expense
            expense_form: {
                amount: null,
                ornumber: null,
                notes: null,
            },

            //Expense Validation
            expense_valid: {
                state: {
                    amount: false,
                    ornumber: false,
                    notes: false,
                },
                msg: {
                    amount: null,
                    ornumber: null,
                    notes: null,
                },
            },

            //Revenue Validation
            revenue_valid: {
                state: {
                    amount: false,
                    collection_type: false,
                    block: false,
                    lot: false,
                    notes: false,
                },
                msg: {
                    amount: null,
                    collection_type: null,
                    block: null,
                    lot: null,
                    notes: null,
                },
            },

            filters: {},
            // cashflow: [
            //   {
            //     user: "Joshua",
            //     source: "Rental",
            //     cash: 1000,
            //     bal: 1000,
            //   },
            // ],
        };
    },
    methods: {
        setLots() {
            this.lot_bool = false;
            let temp = null;
            let list = [];
            // console.log(this.lots.filter(elem=>{return elem.block_id===this.blocks.code}))
            temp = this.lots.filter((elem) => {
                return elem.block_id === this.revenue_form.block;
            });

            temp.forEach((elem) => {
                list.push({ name: elem.number, code: elem.id });
            });

            this.lot_dropdown = list;
        },
        setAmount() {
            this.revenue_form.amount = null;
            let temp = this.dropdown_collection_type.filter((elem) => {
                return elem.code === this.revenue_form.collection_type;
            });
            this.amount_placeholder = temp[0].amount;
        },
        showSuccess() {
            this.$toast.add({
                severity: "success",
                summary: "Success Message",
                detail: "Successfully Added",
                life: 3000,
            });
        },
        addExpense() {
            this.resetExpenseFormError();
            this.addExpenseModal = !this.addExpenseModal;
            this.expense_form = {
                amount: null,
                ornumber: null,
                notes: null,
            };
        },
        addRevenue() {
            this.resetRevenueFormError();
            this.addRevenueModal = !this.addRevenueModal;
            this.revenue_form = {
                amount: null,
                collection_type: null,
                block: null,
                lot: null,
                notes: null,
            };
            this.amount_placeholder = null;
            this.lot_bool = true;
        },
        initFilters() {
            this.filters = {
                global: { value: null, matchMode: FilterMatchMode.CONTAINS },
            };
        },
        async confirmAddExpense() {
            this.resetExpenseFormError();
            this.process = !this.process;
            try {
                if (this.total_funds - this.expense_form.amount < 0) {
                    this.process = false;
                    throw {
                        response: {
                            data: { errors: { amount: ["Not enough funds."] } },
                        },
                    };
                }
                let { data } = await axios({
                    url: "/api/expense",

                    method: "post",

                    data: {
                        user_id: this.userLogged.id,
                        amount: this.expense_form.amount,
                        notes: this.expense_form.notes,
                        running_balance:
                            this.total_funds - this.expense_form.amount,
                    },
                });
                this.process = !this.process;
                this.addExpenseModal = !this.addExpenseModal;
                this.$store.dispatch("expense/getAll");
                try {
                    await axios({
                        url: "http://localhost:8000/api/fund/1",
                        method: "put",
                        data: {
                            amount: this.total_funds - this.expense_form.amount,
                        },
                    });
                    this.$store.dispatch("fund/getAll");
                    this.showSuccess();
                } catch (error) {
                    console.log(error.response.date);
                }
            } catch (error) {
                this.process = false;
                this.expenseFormError(error.response.data);
                console.log(error.response.data);
            }
        },
        expenseFormError(e) {
            if (e.errors.amount) {
                this.expense_valid.state.amount = true;
                this.expense_valid.msg.amount = e.errors.amount[0];
            }
            if (e.errors.notes) {
                this.expense_valid.state.notes = true;
                this.expense_valid.msg.notes = e.errors.notes[0];
            }
        },
        resetExpenseFormError() {
            this.expense_valid = {
                state: {
                    amount: false,
                    ornumber: false,
                    notes: false,
                },
                msg: {
                    amount: null,
                    ornumber: null,
                    notes: null,
                },
            };
        },
        async confirmAddRevenue() {
            this.resetRevenueFormError();
            this.process = !this.process;
            console.log(this.revenue_form);
            try {
                let { data } = await axios({
                    url: "/api/collection",
                    method: "post",

                    data: {
                        collection_type_id: this.revenue_form.collection_type,
                        user_id: this.userLogged.id,
                        block_lot_id: this.revenue_form.lot,
                        amount: this.revenue_form.amount,
                        notes: this.revenue_form.notes,
                        running_balance:
                            this.total_funds + this.revenue_form.amount,
                    },
                });
                this.process = !this.process;
                this.addRevenueModal = !this.addRevenueModal;
                this.$store.dispatch("collection/getAll");
                try {
                    await axios({
                        url: "http://localhost:8000/api/fund/1",
                        method: "put",
                        data: {
                            amount: this.total_funds + this.revenue_form.amount,
                        },
                    });
                    this.$store.dispatch("fund/getAll");
                    this.showSuccess();
                } catch (error) {
                    console.log(error.response.date);
                }
            } catch (error) {
                this.process = false;
                this.revenueFormError(error.response.data);
                console.log(error.response.data);
            }
        },
        revenueFormError(e) {
            if (e.errors.amount) {
                this.revenue_valid.state.amount = true;
                this.revenue_valid.msg.amount = e.errors.amount[0];
            }
            if (e.errors.collection_type_id) {
                this.revenue_valid.state.collection_type = true;
                this.revenue_valid.msg.collection_type =
                    "The collection type field is required.";
            }
            if (this.revenue_form.block == null) {
                this.revenue_valid.state.block = true;
                this.revenue_valid.msg.block = "The block field is required.";
            }
            if (this.revenue_form.lot == null) {
                this.revenue_valid.state.lot = true;
                this.revenue_valid.msg.lot = "The lot field is required.";
            }
        },
        resetRevenueFormError() {
            this.revenue_valid = {
                state: {
                    amount: false,
                    collection_type: false,
                    block: false,
                    lot: false,
                    notes: false,
                },
                msg: {
                    amount: null,
                    collection_type: null,
                    block: null,
                    lot: null,
                    notes: null,
                },
            };
        },
    },
    mounted() {},
    created() {
        this.initFilters();
    },
};
</script>

<style></style>
