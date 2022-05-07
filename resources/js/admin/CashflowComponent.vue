<template>
    <div>
        <Toast />
        <h1>Total Revenues</h1>
        <div class="grid">
            <div v-for="fund in funds" class="col-12 lg:col-4">
                <div class="card mb-0">
                    <div class="flex justify-content-between mb-3">
                        <div>
                            <span
                                class="block font-medium text-4xl font-bold mb-3"
                                >₱{{ fund.amount.toLocaleString() }}</span
                            >
                            <div class="text-900">{{ fund.fund_type }}</div>
                        </div>
                        <div
                            class="flex align-items-center justify-content-center"
                            style="width: 2.5rem; height: 2.5rem"
                        >
                            <i class="pi pi-dollar text-blue-500 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="grid mb-2">
                <div class="col-12">
                    <h4>Cash Flow</h4>
                </div>
            </div>
            <div class="grid mb-2">
                <div class="col-12">
                    <Toolbar>
                        <template #start>
                            <span class="p-input-icon-left inline-block">
                                <i class="pi pi-search" />
                                <InputText
                                    class="mr-2"
                                    v-model="filters['global'].value"
                                    placeholder="Keyword Search"
                                />
                            </span>
                        </template>
                        <!-- <template #end>
                            <div class="mr-2">
                                <Button
                                    label="Download PDF Report"
                                    icon="pi pi-file-pdf"
                                    class="p-button-primary p-mr-2"
                                    @click="generatePDF()"
                                />
                            </div>
                        </template> -->
                    </Toolbar>
                </div>
            </div>
            <DataTable
                :value="cashflow"
                :rows="15"
                :filters="filters"
                filterDisplay="menu"
            >
                <template #empty> No Cash Flow found </template>
                <template #loading> Loading data </template>
                <Column field="user.first_name" header="From">
                    <template #body="{ data }">
                        {{ data.user.first_name }} {{ data.user.last_name }}
                    </template>
                </Column>
                <Column field="usage" header="Usage"></Column>
                <Column field="amount" header="Charges">
                    <template #body="{ data }">
                        <div
                            v-if="data.collection_type_id"
                            class="text-green-700"
                        >
                            ₱{{ data.amount.toLocaleString() }}
                        </div>
                        <div v-else class="text-pink-700">
                            ₱{{ data.amount.toLocaleString() }}
                        </div>
                    </template>
                </Column>
                <Column
                    field="fund.fund_type"
                    header="Running Balance"
                    :showFilterMatchModes="false"
                    filterField="fund.fund_type"
                >
                    <template #body="{ data }">
                        ₱{{ data.running_balance.toLocaleString() }} -
                        {{ data.fund.fund_type }}
                    </template>
                    <template #filter="{ filterModel, filterCallback }">
                        <Dropdown
                            v-model="this.filters['fund.fund_type'].value"
                            @change="filterCallback()"
                            :options="funds"
                            placeholder="Any"
                            class="p-column-filter"
                            :showClear="true"
                            optionLabel="fund_type"
                            optionValue="fund_type"
                        >
                        </Dropdown>
                    </template>
                    <template #filterclear="{ filterCallback }"> </template>
                    <template #filterapply="{ filterCallback }"> </template>
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
                                    v-model="revenue_filters['global'].value"
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
                                :rows="15"
                                :filters="revenue_filters"
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
                                    v-model="expense_filters['global'].value"
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
                                :rows="15"
                                :filters="expense_filters"
                            >
                                <template #empty> No Expense found </template>
                                <template #loading> Loading data </template>
                                <Column field="id" header="ID"></Column>
                                <Column field="user" header="From">
                                    <template #body="{ data }">
                                        {{ data.user.first_name }}
                                        {{ data.user.last_name }}
                                    </template>
                                </Column>
                                <Column
                                    field="expense_type.name"
                                    header="Expense Type"
                                ></Column>
                                <Column field="credit" header="Debit">
                                    <template #body="{ data }">
                                        ₱{{ data.amount.toLocaleString() }}
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
                    INCOME STATEMENT TAB
                 -->
                <TabPanel header="Income Statement">
                    <Toolbar>
                        <template #end>
                            <div class="mr-2">
                                <CascadeSelect
                                    v-model="reportDate"
                                    :options="reportDateSelect"
                                    optionLabel="name"
                                    optionValue="value"
                                    optionGroupLabel="name"
                                    :optionGroupChildren="['range']"
                                    style="minwidth: 14rem"
                                    placeholder="Date"
                                    @change="setStatement()"
                                />
                            </div>
                            <!-- <div class="mr-2">
                <Button
                  label="Download Income Statement"
                  icon="pi pi-file-pdf"
                  class="p-button-primary p-mr-2"
                  @click="generatePDF()"
                />
              </div> -->
                            <div class="mr-2">
                                <Button
                                    label="Download Income Statement"
                                    icon="pi pi-file-pdf"
                                    class="p-button-primary p-mr-2"
                                    @click="verifyDate()"
                                />
                            </div>
                        </template>
                    </Toolbar>
                    <div class="grid mt-2">
                        <div :class="{ hidden: false }">
                            <!-- <table id="statement">
                <tbody>
                  <tr v-for="record in statement">
                    <td v-if="record.type == 'Revenue'">
                      {{ record.type }} {{setRevRowSize()}}
                    </td>
                    <td v-if="record.type == 'Revenue'">
                      {{ record.created_at.getMonth() + 1 }}/{{
                        record.created_at.getDate()
                      }}/{{ record.created_at.getFullYear() }}
                    </td>
                    <td v-if="record.type == 'Revenue'">{{ record.usage }}</td>
                    <td v-if="record.type == 'Revenue'">
                      {{ record.amount.toLocaleString() }} PHP
                    </td>
                  </tr>
                  <tr>
                    <td colspan="3">Total:</td>
                    <td>{{ revenueCount.toLocaleString() }} PHP</td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr v-for="record in statement">
                    <td v-if="record.type == 'Expense'">{{ record.type }}</td>
                    <td v-if="record.type == 'Expense'">
                      {{ record.created_at.getMonth() + 1 }}/{{
                        record.created_at.getDate()
                      }}/{{ record.created_at.getFullYear() }}
                    </td>
                    <td v-if="record.type == 'Expense'">{{ record.usage }}</td>
                    <td v-if="record.type == 'Expense'">
                      {{ record.amount.toLocaleString() }} PHP
                    </td>
                  </tr>
                  <tr>
                    <td colspan="3">Total:</td>
                    <td>{{ expenseCount.toLocaleString() }} PHP</td>
                  </tr>
                </tbody>
                <tfoot>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td colspan="3">Net Income</td>
                    <td>{{ statement.length }}</td>
                  </tr>
                </tfoot>
              </table> -->
                        </div>
                        <div class="col-12">
                            <DataTable
                                class="p-datatable-sm"
                                :value="statement"
                                :rows="15"
                                id="statement"
                                rowGroupMode="rowspan"
                                groupRowsBy="type"
                                sortMode="single"
                                sortField="type"
                                :sortOrder="-1"
                            >
                                <template #empty> No Data</template>
                                <template #loading> Loading data </template>
                                <Column field="type"></Column>
                                <Column field="created_at">
                                    <template #body="{ data }">
                                        {{ data.created_at.getMonth() + 1 }}/{{
                                            data.created_at.getDate()
                                        }}/{{ data.created_at.getFullYear() }}
                                    </template>
                                </Column>
                                <Column field="usage"></Column>
                                <Column field="amount">
                                    <template #body="{ data }">
                                        ₱{{ data.amount.toLocaleString() }}
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
                    <h5>Add Credit to</h5>
                    <Dropdown
                        v-model="revenue_form.source"
                        :options="funds"
                        optionLabel="fund_type"
                        optionValue="id"
                        placeholder="Select Fund Source"
                        :class="{
                            'p-invalid': revenue_valid.state.source,
                        }"
                    />
                    <small v-if="revenue_valid.state.source" class="p-error">{{
                        revenue_valid.msg.source
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
                        @change="getBalance"
                    />
                    <small v-if="revenue_valid.state.lot" class="p-error">{{
                        revenue_valid.msg.lot
                    }}</small>
                </div>
                <div class="col-12 lg:col-6">
                    <h5>Amount</h5>
                    <InputNumber
                        v-model="revenue_form.amount"
                        mode="currency"
                        currency="PHP"
                        :useGrouping="false"
                        :class="{ 'p-invalid': revenue_valid.state.amount }"
                    />
                    <small v-if="revenue_valid.state.amount" class="p-error">{{
                        revenue_valid.msg.amount
                    }}</small>
                </div>
                <div class="col-12 lg:col-6">
                    <h5>Balance</h5>
                    <InputNumber
                        v-model="balance"
                        mode="currency"
                        currency="PHP"
                        :useGrouping="false"
                        disabled
                    />
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
                    <h5>Get Funds From</h5>
                    <Dropdown
                        v-model="expense_form.source"
                        :options="funds"
                        optionLabel="fund_type"
                        optionValue="id"
                        placeholder="Select Fund Source"
                        :class="{
                            'p-invalid': expense_valid.state.source,
                        }"
                    />
                    <small v-if="expense_valid.state.source" class="p-error">{{
                        expense_valid.msg.source
                    }}</small>
                </div>
                <div class="col-12 lg:col-6">
                    <h5>Expense Type</h5>
                    <Dropdown
                        v-model="expense_form.type"
                        :options="dropdown_expense_type"
                        optionLabel="name"
                        optionValue="id"
                        placeholder="Select expense type"
                        :class="{
                            'p-invalid': expense_valid.state.type,
                        }"
                    />
                    <small v-if="expense_valid.state.type" class="p-error">{{
                        expense_valid.msg.type
                    }}</small>
                </div>
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
        <!-- 
      Generate Report Modal
     -->
        <Dialog
            header="Generate Report"
            v-model:visible="generateReportModal"
            :style="{ width: '40vw' }"
            :modal="true"
        >
            <div class="grid p-fluid">
                <div class="col-12 lg:col-6">
                    <h5>Start</h5>
                    <Calendar
                        v-model="report.start"
                        autocomplete="off"
                        :class="{ 'p-invalid': report_valid.state.start }"
                        :maxDate="new Date()"
                        :manualInput="false"
                    ></Calendar>
                    <small v-if="report_valid.state.start" class="p-error">{{
                        report_valid.msg.start
                    }}</small>
                </div>
                <div class="col-12 lg:col-6">
                    <h5>End</h5>
                    <Calendar
                        v-model="report.end"
                        autocomplete="off"
                        :class="{ 'p-invalid': report_valid.state.end }"
                        :maxDate="new Date()"
                        :manualInput="false"
                    />
                    <small v-if="report_valid.state.end" class="p-error">{{
                        report_valid.msg.end
                    }}</small>
                </div>
            </div>
            <template #footer>
                <Button
                    label="Generate File"
                    icon="pi pi-download"
                    autofocus
                    @click="verifyDate()"
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
import { FilterMatchMode, FilterOperator } from "primevue/api";
import axios from "axios";
import { jsPDF } from "jspdf";
import { applyPlugin } from "jspdf-autotable";
applyPlugin(jsPDF);
export default {
    setup() {
        const store = useStore();
        return {
            userLogged: computed(() => store.state.userLogged),
            funds: computed(() => store.state.fund.Fund),
            dropdown_expense_type: computed(
                () => store.state.expenseType.ExpenseType
            ),
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
            specific_invoices: computed(() => store.state.specific_invoices),
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
                revenue.forEach((elem) => {
                    elem["usage"] = elem.collection_type.name;
                });
                let expense = store.state.expense.Expense;
                expense.forEach((elem) => {
                    elem["usage"] = elem.expense_type.name;
                });
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
            revRowSize: true,
            expRowSize: true,
            reportDate: null,
            reportDateSelect: [
                {
                    name: "Quarterly",
                    range: [
                        {
                            name: "Jan - Mar",
                            value: 1,
                        },
                        {
                            name: "Apr - Jun",
                            value: 2,
                        },
                        {
                            name: "Jul - Sep",
                            value: 3,
                        },
                        {
                            name: "Oct - Dec",
                            value: 4,
                        },
                    ],
                },
                {
                    name: "Monthly",
                    range: [
                        {
                            name: "January",
                            value: "JAN",
                        },
                        {
                            name: "February",
                            value: "FEB",
                        },
                        {
                            name: "March",
                            value: "MAR",
                        },
                        {
                            name: "April",
                            value: "APR",
                        },
                        {
                            name: "May",
                            value: "MAY",
                        },
                        {
                            name: "June",
                            value: "JUN",
                        },
                        {
                            name: "July",
                            value: "JUL",
                        },
                        {
                            name: "August",
                            value: "AUG",
                        },
                        {
                            name: "September",
                            value: "SEP",
                        },
                        {
                            name: "October",
                            value: "OCT",
                        },
                        {
                            name: "November",
                            value: "NOV",
                        },
                        {
                            name: "December",
                            value: "DEC",
                        },
                    ],
                },
                {
                    name: "Anually",
                    value: 12,
                },
            ],
            statement: [],
            process: false,
            //Modal Control
            addRevenueModal: false,
            addExpenseModal: false,
            generateReportModal: false,
            //Revenue
            lot_dropdown: null,
            lot_bool: true,
            revenue_form: {
                amount: null,
                collection_type: null,
                block: null,
                lot: null,
                notes: null,
                source: null,
            },
            //Expense
            expense_form: {
                amount: null,
                ornumber: null,
                notes: null,
                source: null,
                type: null,
            },
            //Expense Validation
            expense_valid: {
                state: {
                    amount: false,
                    ornumber: false,
                    notes: false,
                    source: false,
                    type: false,
                },
                msg: {
                    amount: null,
                    ornumber: null,
                    notes: null,
                    source: null,
                    type: null,
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
            // Report Form
            report: {
                start: null,
                end: null,
            },
            //Report Validation
            report_valid: {
                state: {
                    start: false,
                    end: false,
                },
                msg: {
                    start: null,
                    end: null,
                },
            },
            filters: {},
            revenue_filters: {},
            expense_filters: {},

            balance: null,
        };
    },
    methods: {
        async getBalance() {
            await this.$store.dispatch(
                "getSpecificInvoices",
                this.revenue_form.lot
            );
            if (this.specific_invoices.running_balance > 0) {
                this.balance = this.specific_invoices.running_balance;
            } else {
                this.balance = 0;
            }
        },
        // testTable() {
        //   var doc = new jsPDF();
        //   doc.autoTable({ html: "#statement", theme: "plain" });
        //   doc.save("table.pdf");
        // },
        setStatement() {
            if (this.reportDate == 1) {
                let temp = [];
                let list = this.cashflow;
                let start = new Date(new Date().getFullYear(), 0, 1);
                let end = new Date(new Date().getFullYear(), 3, 1);
                list.reverse();
                list.forEach((elem) => {
                    elem.created_at = new Date(elem.created_at);
                    if (elem.created_at >= start && elem.created_at <= end) {
                        if (elem.collection_type_id) {
                            elem["type"] = "Revenue";
                            temp.push(elem);
                        } else {
                            elem["type"] = "Expense";
                            temp.push(elem);
                        }
                    }
                });
                this.statement = temp;
            }
            if (this.reportDate == 2) {
                let temp = [];
                let list = this.cashflow;
                let start = new Date(new Date().getFullYear(), 3, 1);
                let end = new Date(new Date().getFullYear(), 6, 1);
                list.reverse();
                list.forEach((elem) => {
                    elem.created_at = new Date(elem.created_at);
                    if (elem.created_at >= start && elem.created_at <= end) {
                        if (elem.collection_type_id) {
                            elem["type"] = "Revenue";
                            temp.push(elem);
                        } else {
                            elem["type"] = "Expense";
                            temp.push(elem);
                        }
                    }
                });
                this.statement = temp;
            }
            if (this.reportDate == 3) {
                let temp = [];
                let list = this.cashflow;
                let start = new Date(new Date().getFullYear(), 6, 1);
                let end = new Date(new Date().getFullYear(), 9, 1);
                list.reverse();
                list.forEach((elem) => {
                    elem.created_at = new Date(elem.created_at);
                    if (elem.created_at >= start && elem.created_at <= end) {
                        if (elem.collection_type_id) {
                            elem["type"] = "Revenue";
                            temp.push(elem);
                        } else {
                            elem["type"] = "Expense";
                            temp.push(elem);
                        }
                    }
                });
                this.statement = temp;
            }
            if (this.reportDate == 4) {
                let temp = [];
                let list = this.cashflow;
                let start = new Date(new Date().getFullYear(), 0, 1);
                let end = new Date(new Date().getFullYear() + 1, 0, 1);
                list.reverse();
                list.forEach((elem) => {
                    elem.created_at = new Date(elem.created_at);
                    if (elem.created_at >= start && elem.created_at <= end) {
                        if (elem.collection_type_id) {
                            elem["type"] = "Revenue";
                            temp.push(elem);
                        } else {
                            elem["type"] = "Expense";
                            temp.push(elem);
                        }
                    }
                });
                this.statement = temp;
            }
            if (this.reportDate == "JAN") {
                let temp = [];
                let list = this.cashflow;
                let start = new Date(new Date().getFullYear(), 0, 1);
                let end = new Date(new Date().getFullYear(), 1, 1);
                list.reverse();
                list.forEach((elem) => {
                    elem.created_at = new Date(elem.created_at);
                    if (elem.created_at >= start && elem.created_at <= end) {
                        if (elem.collection_type_id) {
                            elem["type"] = "Revenue";
                            temp.push(elem);
                        } else {
                            elem["type"] = "Expense";
                            temp.push(elem);
                        }
                    }
                });
                this.statement = temp;
            }
            if (this.reportDate == "FEB") {
                let temp = [];
                let list = this.cashflow;
                let start = new Date(new Date().getFullYear(), 1, 1);
                let end = new Date(new Date().getFullYear(), 2, 1);
                list.reverse();
                list.forEach((elem) => {
                    elem.created_at = new Date(elem.created_at);
                    if (elem.created_at >= start && elem.created_at <= end) {
                        if (elem.collection_type_id) {
                            elem["type"] = "Revenue";
                            temp.push(elem);
                        } else {
                            elem["type"] = "Expense";
                            temp.push(elem);
                        }
                    }
                });
                this.statement = temp;
            }
            if (this.reportDate == "MAR") {
                let temp = [];
                let list = this.cashflow;
                let start = new Date(new Date().getFullYear(), 2, 1);
                let end = new Date(new Date().getFullYear(), 3, 1);
                list.reverse();
                list.forEach((elem) => {
                    elem.created_at = new Date(elem.created_at);
                    if (elem.created_at >= start && elem.created_at <= end) {
                        if (elem.collection_type_id) {
                            elem["type"] = "Revenue";
                            temp.push(elem);
                        } else {
                            elem["type"] = "Expense";
                            temp.push(elem);
                        }
                    }
                });
                this.statement = temp;
            }
            if (this.reportDate == "APR") {
                let temp = [];
                let list = this.cashflow;
                let start = new Date(new Date().getFullYear(), 3, 1);
                let end = new Date(new Date().getFullYear(), 4, 1);
                list.reverse();
                list.forEach((elem) => {
                    elem.created_at = new Date(elem.created_at);
                    if (elem.created_at >= start && elem.created_at <= end) {
                        if (elem.collection_type_id) {
                            elem["type"] = "Revenue";
                            temp.push(elem);
                        } else {
                            elem["type"] = "Expense";
                            temp.push(elem);
                        }
                    }
                });
                this.statement = temp;
            }
            if (this.reportDate == "MAY") {
                let temp = [];
                let list = this.cashflow;
                let start = new Date(new Date().getFullYear(), 4, 1);
                let end = new Date(new Date().getFullYear(), 5, 1);
                list.reverse();
                list.forEach((elem) => {
                    elem.created_at = new Date(elem.created_at);
                    if (elem.created_at >= start && elem.created_at <= end) {
                        if (elem.collection_type_id) {
                            elem["type"] = "Revenue";
                            temp.push(elem);
                        } else {
                            elem["type"] = "Expense";
                            temp.push(elem);
                        }
                    }
                });
                this.statement = temp;
            }
            if (this.reportDate == "JUN") {
                let temp = [];
                let list = this.cashflow;
                let start = new Date(new Date().getFullYear(), 5, 1);
                let end = new Date(new Date().getFullYear(), 6, 1);
                list.reverse();
                list.forEach((elem) => {
                    elem.created_at = new Date(elem.created_at);
                    if (elem.created_at >= start && elem.created_at <= end) {
                        if (elem.collection_type_id) {
                            elem["type"] = "Revenue";
                            temp.push(elem);
                        } else {
                            elem["type"] = "Expense";
                            temp.push(elem);
                        }
                    }
                });
                this.statement = temp;
            }
            if (this.reportDate == "JUL") {
                let temp = [];
                let list = this.cashflow;
                let start = new Date(new Date().getFullYear(), 6, 1);
                let end = new Date(new Date().getFullYear(), 7, 1);
                list.reverse();
                list.forEach((elem) => {
                    elem.created_at = new Date(elem.created_at);
                    if (elem.created_at >= start && elem.created_at <= end) {
                        if (elem.collection_type_id) {
                            elem["type"] = "Revenue";
                            temp.push(elem);
                        } else {
                            elem["type"] = "Expense";
                            temp.push(elem);
                        }
                    }
                });
                this.statement = temp;
            }
            if (this.reportDate == "AUG") {
                let temp = [];
                let list = this.cashflow;
                let start = new Date(new Date().getFullYear(), 7, 1);
                let end = new Date(new Date().getFullYear(), 8, 1);
                list.reverse();
                list.forEach((elem) => {
                    elem.created_at = new Date(elem.created_at);
                    if (elem.created_at >= start && elem.created_at <= end) {
                        if (elem.collection_type_id) {
                            elem["type"] = "Revenue";
                            temp.push(elem);
                        } else {
                            elem["type"] = "Expense";
                            temp.push(elem);
                        }
                    }
                });
                this.statement = temp;
            }
            if (this.reportDate == "SEP") {
                let temp = [];
                let list = this.cashflow;
                let start = new Date(new Date().getFullYear(), 8, 1);
                let end = new Date(new Date().getFullYear(), 9, 1);
                list.reverse();
                list.forEach((elem) => {
                    elem.created_at = new Date(elem.created_at);
                    if (elem.created_at >= start && elem.created_at <= end) {
                        if (elem.collection_type_id) {
                            elem["type"] = "Revenue";
                            temp.push(elem);
                        } else {
                            elem["type"] = "Expense";
                            temp.push(elem);
                        }
                    }
                });
                this.statement = temp;
            }
            if (this.reportDate == "OCT") {
                let temp = [];
                let list = this.cashflow;
                let start = new Date(new Date().getFullYear(), 9, 1);
                let end = new Date(new Date().getFullYear(), 10, 1);
                list.reverse();
                list.forEach((elem) => {
                    elem.created_at = new Date(elem.created_at);
                    if (elem.created_at >= start && elem.created_at <= end) {
                        if (elem.collection_type_id) {
                            elem["type"] = "Revenue";
                            temp.push(elem);
                        } else {
                            elem["type"] = "Expense";
                            temp.push(elem);
                        }
                    }
                });
                this.statement = temp;
            }
            if (this.reportDate == "NOV") {
                let temp = [];
                let list = this.cashflow;
                let start = new Date(new Date().getFullYear(), 10, 1);
                let end = new Date(new Date().getFullYear(), 11, 1);
                list.reverse();
                list.forEach((elem) => {
                    elem.created_at = new Date(elem.created_at);
                    if (elem.created_at >= start && elem.created_at <= end) {
                        if (elem.collection_type_id) {
                            elem["type"] = "Revenue";
                            temp.push(elem);
                        } else {
                            elem["type"] = "Expense";
                            temp.push(elem);
                        }
                    }
                });
                this.statement = temp;
            }
            if (this.reportDate == "DEC") {
                let temp = [];
                let list = this.cashflow;
                let start = new Date(new Date().getFullYear(), 11, 1);
                let end = new Date(new Date().getFullYear() + 1, 0, 1);
                list.reverse();
                list.forEach((elem) => {
                    elem.created_at = new Date(elem.created_at);
                    if (elem.created_at >= start && elem.created_at <= end) {
                        if (elem.collection_type_id) {
                            elem["type"] = "Revenue";
                            temp.push(elem);
                        } else {
                            elem["type"] = "Expense";
                            temp.push(elem);
                        }
                    }
                });
                this.statement = temp;
            }
            if (this.reportDate == 12) {
                let temp = [];
                let list = this.cashflow;
                let start = new Date(new Date().getFullYear(), 0, 1);
                let end = new Date(new Date().getFullYear() + 1, 0, 1);
                list.reverse();
                list.forEach((elem) => {
                    elem.created_at = new Date(elem.created_at);
                    if (elem.created_at >= start && elem.created_at <= end) {
                        if (elem.collection_type_id) {
                            elem["type"] = "Revenue";
                            temp.push(elem);
                        } else {
                            elem["type"] = "Expense";
                            temp.push(elem);
                        }
                    }
                });
                this.statement = temp;
            }
        },
        resetGeneratePDF() {
            this.report = {
                start: null,
                end: null,
            };
        },
        resetErrorGeneratePDF() {
            this.report_valid = {
                state: {
                    start: false,
                    end: false,
                },
                msg: {
                    start: null,
                    end: null,
                },
            };
        },
        // generatePDF() {
        //   this.generateReportModal = true;
        //   this.resetErrorGeneratePDF();
        //   this.resetGeneratePDF();
        // },
        verifyDate() {
            //   this.resetErrorGeneratePDF();
            //   let start = this.report.start;
            //   let end = this.report.end;
            let month = [
                "January",
                "February",
                "March",
                "April",
                "May",
                "June",
                "July",
                "August",
                "September",
                "October",
                "November",
                "December",
            ];
            const doc = new jsPDF();
            let finalY = 1;
            let start = null;
            let end = null;
            if (this.reportDate == 1) {
                start = new Date(new Date().getFullYear(), 0, 1);
                end = new Date(new Date().getFullYear(), 2, 1);
                doc.text(
                    "Financial Statement Report " +
                        month[start.getMonth()] +
                        " " +
                        start.getFullYear() +
                        " to " +
                        month[end.getMonth()] +
                        " " +
                        end.getFullYear(),
                    15,
                    finalY + 15
                );
            }
            if (this.reportDate == 2) {
                start = new Date(new Date().getFullYear(), 3, 1);
                end = new Date(new Date().getFullYear(), 5, 1);
                doc.text(
                    "Financial Statement Report " +
                        month[start.getMonth()] +
                        " " +
                        start.getFullYear() +
                        " to " +
                        month[end.getMonth()] +
                        " " +
                        end.getFullYear(),
                    15,
                    finalY + 15
                );
            }
            if (this.reportDate == 3) {
                start = new Date(new Date().getFullYear(), 6, 1);
                end = new Date(new Date().getFullYear(), 8, 1);
                doc.text(
                    "Financial Statement Report " +
                        month[start.getMonth()] +
                        " " +
                        start.getFullYear() +
                        " to " +
                        month[end.getMonth()] +
                        " " +
                        end.getFullYear(),
                    15,
                    finalY + 15
                );
            }
            if (this.reportDate == 4) {
                start = new Date(new Date().getFullYear(), 0, 1);
                end = new Date(new Date().getFullYear(), 11, 1);
                doc.text(
                    "Financial Statement Report " +
                        month[start.getMonth()] +
                        " " +
                        start.getFullYear() +
                        " to " +
                        month[end.getMonth()] +
                        " " +
                        end.getFullYear(),
                    15,
                    finalY + 15
                );
            }
            if (this.reportDate == "JAN") {
                start = new Date(new Date().getFullYear(), 0, 1);
                end = new Date(new Date().getFullYear(), 1, 1);
                doc.text(
                    "Financial Statement Report " +
                        month[start.getMonth()] +
                        " " +
                        start.getFullYear(),
                    15,
                    finalY + 15
                );
            }
            if (this.reportDate == "FEB") {
                start = new Date(new Date().getFullYear(), 1, 1);
                end = new Date(new Date().getFullYear(), 2, 1);
                doc.text(
                    "Financial Statement Report " +
                        month[start.getMonth()] +
                        " " +
                        start.getFullYear(),
                    15,
                    finalY + 15
                );
            }
            if (this.reportDate == "MAR") {
                start = new Date(new Date().getFullYear(), 2, 1);
                end = new Date(new Date().getFullYear(), 3, 1);
                doc.text(
                    "Financial Statement Report " +
                        month[start.getMonth()] +
                        " " +
                        start.getFullYear(),
                    15,
                    finalY + 15
                );
            }
            if (this.reportDate == "APR") {
                start = new Date(new Date().getFullYear(), 3, 1);
                end = new Date(new Date().getFullYear(), 4, 1);
                doc.text(
                    "Financial Statement Report " +
                        month[start.getMonth()] +
                        " " +
                        start.getFullYear(),
                    15,
                    finalY + 15
                );
            }
            if (this.reportDate == "MAY") {
                start = new Date(new Date().getFullYear(), 4, 1);
                end = new Date(new Date().getFullYear(), 5, 1);
                doc.text(
                    "Financial Statement Report " +
                        month[start.getMonth()] +
                        " " +
                        start.getFullYear(),
                    15,
                    finalY + 15
                );
            }
            if (this.reportDate == "JUN") {
                start = new Date(new Date().getFullYear(), 5, 1);
                end = new Date(new Date().getFullYear(), 6, 1);
                doc.text(
                    "Financial Statement Report " +
                        month[start.getMonth()] +
                        " " +
                        start.getFullYear(),
                    15,
                    finalY + 15
                );
            }
            if (this.reportDate == "JUL") {
                start = new Date(new Date().getFullYear(), 6, 1);
                end = new Date(new Date().getFullYear(), 7, 1);
                doc.text(
                    "Financial Statement Report " +
                        month[start.getMonth()] +
                        " " +
                        start.getFullYear(),
                    15,
                    finalY + 15
                );
            }
            if (this.reportDate == "AUG") {
                start = new Date(new Date().getFullYear(), 7, 1);
                end = new Date(new Date().getFullYear(), 8, 1);
                doc.text(
                    "Financial Statement Report " +
                        month[start.getMonth()] +
                        " " +
                        start.getFullYear(),
                    15,
                    finalY + 15
                );
            }
            if (this.reportDate == "SEP") {
                start = new Date(new Date().getFullYear(), 8, 1);
                end = new Date(new Date().getFullYear(), 9, 1);
                doc.text(
                    "Financial Statement Report " +
                        month[start.getMonth()] +
                        " " +
                        start.getFullYear(),
                    15,
                    finalY + 15
                );
            }
            if (this.reportDate == "OCT") {
                start = new Date(new Date().getFullYear(), 9, 1);
                end = new Date(new Date().getFullYear(), 10, 1);
                doc.text(
                    "Financial Statement Report " +
                        month[start.getMonth()] +
                        " " +
                        start.getFullYear(),
                    15,
                    finalY + 15
                );
            }
            if (this.reportDate == "NOV") {
                start = new Date(new Date().getFullYear(), 10, 1);
                end = new Date(new Date().getFullYear(), 11, 1);
                doc.text(
                    "Financial Statement Report " +
                        month[start.getMonth()] +
                        " " +
                        start.getFullYear(),
                    15,
                    finalY + 15
                );
            }
            if (this.reportDate == "DEC") {
                start = new Date(new Date().getFullYear(), 11, 1);
                end = new Date(new Date().getFullYear() + 1, 0, 1);
                doc.text(
                    "Financial Statement Report " +
                        month[start.getMonth()] +
                        " " +
                        start.getFullYear(),
                    15,
                    finalY + 15
                );
            }
            if (this.reportDate == 12) {
                start = new Date(new Date().getFullYear(), 0, 1);
                end = new Date(new Date().getFullYear(), 11, 1);
                doc.text(
                    "Financial Statement Report " +
                        month[start.getMonth()] +
                        " " +
                        start.getFullYear() +
                        " to " +
                        month[end.getMonth()] +
                        " " +
                        end.getFullYear(),
                    15,
                    finalY + 15
                );
            }
            doc.autoTable({
                startY: finalY + 20,
                theme: "plain",
                head: [["Revenue", "", ""]],
                body: this.revenueReport,
                foot: [
                    [
                        { content: "", colSpan: 1, rowSpan: 1 },
                        {
                            content: "Total",
                            colSpan: 1,
                            rowSpan: 1,
                            styles: { halign: "right" },
                        },
                        {
                            content:
                                this.revenueTotal.toLocaleString() + " PHP",
                            colSpan: 1,
                            rowSpan: 1,
                        },
                    ],
                ],
            });
            doc.addPage();
            doc.autoTable({
                startY: finalY + 20,
                theme: "plain",
                head: [["Expenses", "", ""]],
                body: this.expenseReport,
                foot: [
                    [
                        { content: "", colSpan: 1, rowSpan: 1 },
                        {
                            content: "Total",
                            colSpan: 1,
                            rowSpan: 1,
                            styles: { halign: "right" },
                        },
                        {
                            content:
                                this.expenseTotal.toLocaleString() + " PHP",
                            colSpan: 1,
                            rowSpan: 1,
                        },
                    ],
                ],
            });
            doc.addPage();
            doc.autoTable({
                startY: finalY + 20,
                theme: "plain",
                head: [["Net Income", "", ""]],
                body: [
                    ["", "Revenue", this.revenueTotal + " PHP"],
                    ["", "Expense", this.expenseTotal + " PHP"],
                ],
                foot: [
                    [
                        { content: "", colSpan: 1, rowSpan: 1 },
                        {
                            content: "Total",
                            colSpan: 1,
                            rowSpan: 1,
                            styles: { halign: "right" },
                        },
                        {
                            content:
                                (
                                    this.revenueTotal - this.expenseTotal
                                ).toLocaleString() + " PHP",
                            colSpan: 1,
                            rowSpan: 1,
                        },
                    ],
                ],
            });
            if (start != null && end != null) {
                doc.save(
                    "Income Statement " +
                        month[start.getMonth()] +
                        "" +
                        start.getFullYear() +
                        " to " +
                        month[end.getMonth()] +
                        "" +
                        end.getFullYear()
                );
            }
        },
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
            this.revenue_form.amount = temp[0].amount;
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
                source: null,
                type: null,
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
                source: null,
            };
            this.lot_bool = true;
        },
        initFilters() {
            this.filters = {
                global: { value: null, matchMode: FilterMatchMode.CONTAINS },
                "fund.fund_type": {
                    value: null,
                    matchMode: FilterMatchMode.EQUALS,
                },
            };
            this.revenue_filters = {
                global: { value: null, matchMode: FilterMatchMode.CONTAINS },
            };
            this.expense_filters = {
                global: { value: null, matchMode: FilterMatchMode.CONTAINS },
            };
        },
        async confirmAddExpense() {
            this.resetExpenseFormError();
            this.process = !this.process;
            try {
                if (this.expense_form.source != null) {
                    if (
                        this.funds[this.expense_form.source - 1].amount -
                            this.expense_form.amount <
                        0
                    ) {
                        this.process = false;
                        throw {
                            response: {
                                data: {
                                    errors: { amount: ["Not enough funds."] },
                                },
                            },
                        };
                    }
                } else {
                    throw {
                        response: {
                            data: {
                                errors: {
                                    source: [
                                        "Please select source of funds first.",
                                    ],
                                },
                            },
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
                            this.expense_form.source == null
                                ? null
                                : +this.funds[this.expense_form.source - 1]
                                      .amount - +this.expense_form.amount,
                        fund_id: this.expense_form.source,
                        expense_type_id: this.expense_form.type,
                    },
                });
                this.process = !this.process;
                this.addExpenseModal = !this.addExpenseModal;
                this.$store.dispatch("expense/getAll");
                try {
                    await axios({
                        url: "/api/fund/" + this.expense_form.source,
                        method: "put",
                        data: {
                            amount:
                                +this.funds[this.expense_form.source - 1]
                                    .amount - +this.expense_form.amount,
                            fund_type:
                                this.funds[this.expense_form.source - 1]
                                    .fund_type,
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
            if (e.errors.source) {
                this.expense_valid.state.source = true;
                this.expense_valid.msg.source = e.errors.source[0];
            }
            if (e.errors.expense_type_id) {
                this.expense_valid.state.type = true;
                this.expense_valid.msg.type = e.errors.expense_type_id[0];
            }
        },
        resetExpenseFormError() {
            this.expense_valid = {
                state: {
                    amount: false,
                    ornumber: false,
                    notes: false,
                    source: false,
                    type: false,
                },
                msg: {
                    amount: null,
                    ornumber: null,
                    notes: null,
                    source: null,
                    type: null,
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
                            this.revenue_form.source == null
                                ? null
                                : +this.funds[this.revenue_form.source - 1]
                                      .amount + +this.revenue_form.amount,
                        fund_id: this.revenue_form.source,
                    },
                });
                this.process = !this.process;
                this.addRevenueModal = !this.addRevenueModal;
                this.$store.dispatch("collection/getAll");
                try {
                    await axios({
                        url: "/api/fund/" + this.revenue_form.source,
                        method: "put",
                        data: {
                            amount:
                                +this.funds[this.revenue_form.source - 1]
                                    .amount + +this.revenue_form.amount,
                            fund_type:
                                this.funds[this.revenue_form.source - 1]
                                    .fund_type,
                        },
                    });
                    this.$store.dispatch("fund/getAll");
                    this.showSuccess();
                } catch (error) {
                    console.log(error.response.date);
                }
            } catch (error) {
                this.process = false;
                console.error(error);
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
            if (e.errors.fund_id) {
                this.revenue_valid.state.source = true;
                this.revenue_valid.msg.source =
                    "The source of fund field is required.";
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
                    source: false,
                },
                msg: {
                    amount: null,
                    collection_type: null,
                    block: null,
                    lot: null,
                    notes: null,
                    source: null,
                },
            };
        },
        setRevRowSize() {
            this.revRowSize = false;
        },
    },
    computed: {
        revenueReport() {
            let start = null;
            let end = null;
            if (this.reportDate == 1) {
                start = new Date(new Date().getFullYear(), 0, 1);
                end = new Date(new Date().getFullYear(), 3, 1);
            }
            if (this.reportDate == 2) {
                start = new Date(new Date().getFullYear(), 3, 1);
                end = new Date(new Date().getFullYear(), 6, 1);
            }
            if (this.reportDate == 3) {
                start = new Date(new Date().getFullYear(), 6, 1);
                end = new Date(new Date().getFullYear(), 9, 1);
            }
            if (this.reportDate == 4) {
                start = new Date(new Date().getFullYear(), 0, 1);
                end = new Date(new Date().getFullYear() + 1, 0, 1);
            }
            if (this.reportDate == "JAN") {
                start = new Date(new Date().getFullYear(), 0, 1);
                end = new Date(new Date().getFullYear(), 1, 1);
            }
            if (this.reportDate == "FEB") {
                start = new Date(new Date().getFullYear(), 1, 1);
                end = new Date(new Date().getFullYear(), 2, 1);
            }
            if (this.reportDate == "MAR") {
                start = new Date(new Date().getFullYear(), 2, 1);
                end = new Date(new Date().getFullYear(), 3, 1);
            }
            if (this.reportDate == "APR") {
                start = new Date(new Date().getFullYear(), 3, 1);
                end = new Date(new Date().getFullYear(), 4, 1);
            }
            if (this.reportDate == "MAY") {
                start = new Date(new Date().getFullYear(), 4, 1);
                end = new Date(new Date().getFullYear(), 5, 1);
            }
            if (this.reportDate == "JUN") {
                start = new Date(new Date().getFullYear(), 5, 1);
                end = new Date(new Date().getFullYear(), 6, 1);
            }
            if (this.reportDate == "JUL") {
                start = new Date(new Date().getFullYear(), 6, 1);
                end = new Date(new Date().getFullYear(), 7, 1);
            }
            if (this.reportDate == "AUG") {
                start = new Date(new Date().getFullYear(), 7, 1);
                end = new Date(new Date().getFullYear(), 8, 1);
            }
            if (this.reportDate == "SEP") {
                start = new Date(new Date().getFullYear(), 8, 1);
                end = new Date(new Date().getFullYear(), 9, 1);
            }
            if (this.reportDate == "OCT") {
                start = new Date(new Date().getFullYear(), 9, 1);
                end = new Date(new Date().getFullYear(), 10, 1);
            }
            if (this.reportDate == "NOV") {
                start = new Date(new Date().getFullYear(), 10, 1);
                end = new Date(new Date().getFullYear(), 11, 1);
            }
            if (this.reportDate == "DEC") {
                start = new Date(new Date().getFullYear(), 11, 1);
                end = new Date(new Date().getFullYear() + 1, 0, 1);
            }
            if (this.reportDate == 12) {
                start = new Date(new Date().getFullYear(), 0, 1);
                end = new Date(new Date().getFullYear() + 1, 0, 1);
            }
            let temp = [];
            let list = this.cashflow;
            let month = [
                "January",
                "February",
                "March",
                "April",
                "May",
                "June",
                "July",
                "August",
                "September",
                "October",
                "November",
                "December",
            ];
            list.sort((a, b) => {
                return new Date(a.created_at) - new Date(b.created_at);
            });
            list.forEach((elem) => {
                let item_date = new Date(elem.created_at);
                if (
                    elem.collection_type_id &&
                    item_date >= start &&
                    item_date <= end
                ) {
                    temp.push([
                        {
                            content:
                                month[new Date(elem.created_at).getMonth()] +
                                "/" +
                                new Date(elem.created_at).getDate() +
                                "/" +
                                new Date(elem.created_at).getFullYear(),
                            colSpan: 1,
                            rowSpan: 1,
                        },
                        {
                            content: elem.collection_type.name,
                            colSpan: 1,
                            rowSpan: 1,
                        },
                        {
                            content: elem.amount.toLocaleString() + " PHP",
                            colSpan: 1,
                            rowSpan: 1,
                        },
                    ]);
                }
            });
            return temp;
        },
        revenueTotal() {
            let start = null;
            let end = null;
            if (this.reportDate == 1) {
                start = new Date(new Date().getFullYear(), 0, 1);
                end = new Date(new Date().getFullYear(), 3, 1);
            }
            if (this.reportDate == 2) {
                start = new Date(new Date().getFullYear(), 3, 1);
                end = new Date(new Date().getFullYear(), 6, 1);
            }
            if (this.reportDate == 3) {
                start = new Date(new Date().getFullYear(), 6, 1);
                end = new Date(new Date().getFullYear(), 9, 1);
            }
            if (this.reportDate == 4) {
                start = new Date(new Date().getFullYear(), 0, 1);
                end = new Date(new Date().getFullYear() + 1, 0, 1);
            }
            if (this.reportDate == "JAN") {
                start = new Date(new Date().getFullYear(), 0, 1);
                end = new Date(new Date().getFullYear(), 1, 1);
            }
            if (this.reportDate == "FEB") {
                start = new Date(new Date().getFullYear(), 1, 1);
                end = new Date(new Date().getFullYear(), 2, 1);
            }
            if (this.reportDate == "MAR") {
                start = new Date(new Date().getFullYear(), 2, 1);
                end = new Date(new Date().getFullYear(), 3, 1);
            }
            if (this.reportDate == "APR") {
                start = new Date(new Date().getFullYear(), 3, 1);
                end = new Date(new Date().getFullYear(), 4, 1);
            }
            if (this.reportDate == "MAY") {
                start = new Date(new Date().getFullYear(), 4, 1);
                end = new Date(new Date().getFullYear(), 5, 1);
            }
            if (this.reportDate == "JUN") {
                start = new Date(new Date().getFullYear(), 5, 1);
                end = new Date(new Date().getFullYear(), 6, 1);
            }
            if (this.reportDate == "JUL") {
                start = new Date(new Date().getFullYear(), 6, 1);
                end = new Date(new Date().getFullYear(), 7, 1);
            }
            if (this.reportDate == "AUG") {
                start = new Date(new Date().getFullYear(), 7, 1);
                end = new Date(new Date().getFullYear(), 8, 1);
            }
            if (this.reportDate == "SEP") {
                start = new Date(new Date().getFullYear(), 8, 1);
                end = new Date(new Date().getFullYear(), 9, 1);
            }
            if (this.reportDate == "OCT") {
                start = new Date(new Date().getFullYear(), 9, 1);
                end = new Date(new Date().getFullYear(), 10, 1);
            }
            if (this.reportDate == "NOV") {
                start = new Date(new Date().getFullYear(), 10, 1);
                end = new Date(new Date().getFullYear(), 11, 1);
            }
            if (this.reportDate == "DEC") {
                start = new Date(new Date().getFullYear(), 11, 1);
                end = new Date(new Date().getFullYear() + 1, 0, 1);
            }
            if (this.reportDate == 12) {
                start = new Date(new Date().getFullYear(), 0, 1);
                end = new Date(new Date().getFullYear() + 1, 0, 1);
            }
            let total = 0;
            let list = this.cashflow;
            let month = [
                "January",
                "February",
                "March",
                "April",
                "May",
                "June",
                "July",
                "August",
                "September",
                "October",
                "November",
                "December",
            ];
            list.sort((a, b) => {
                return new Date(a.created_at) - new Date(b.created_at);
            });
            list.forEach((elem) => {
                let item_date = new Date(elem.created_at);
                if (
                    elem.collection_type_id &&
                    item_date >= start &&
                    item_date <= end
                ) {
                    total += elem.amount;
                }
            });
            return total;
        },
        expenseReport() {
            let start = null;
            let end = null;
            if (this.reportDate == 1) {
                start = new Date(new Date().getFullYear(), 0, 1);
                end = new Date(new Date().getFullYear(), 3, 1);
            }
            if (this.reportDate == 2) {
                start = new Date(new Date().getFullYear(), 3, 1);
                end = new Date(new Date().getFullYear(), 6, 1);
            }
            if (this.reportDate == 3) {
                start = new Date(new Date().getFullYear(), 6, 1);
                end = new Date(new Date().getFullYear(), 9, 1);
            }
            if (this.reportDate == 4) {
                start = new Date(new Date().getFullYear(), 0, 1);
                end = new Date(new Date().getFullYear() + 1, 0, 1);
            }
            if (this.reportDate == "JAN") {
                start = new Date(new Date().getFullYear(), 0, 1);
                end = new Date(new Date().getFullYear(), 1, 1);
            }
            if (this.reportDate == "FEB") {
                start = new Date(new Date().getFullYear(), 1, 1);
                end = new Date(new Date().getFullYear(), 2, 1);
            }
            if (this.reportDate == "MAR") {
                start = new Date(new Date().getFullYear(), 2, 1);
                end = new Date(new Date().getFullYear(), 3, 1);
            }
            if (this.reportDate == "APR") {
                start = new Date(new Date().getFullYear(), 3, 1);
                end = new Date(new Date().getFullYear(), 4, 1);
            }
            if (this.reportDate == "MAY") {
                start = new Date(new Date().getFullYear(), 4, 1);
                end = new Date(new Date().getFullYear(), 5, 1);
            }
            if (this.reportDate == "JUN") {
                start = new Date(new Date().getFullYear(), 5, 1);
                end = new Date(new Date().getFullYear(), 6, 1);
            }
            if (this.reportDate == "JUL") {
                start = new Date(new Date().getFullYear(), 6, 1);
                end = new Date(new Date().getFullYear(), 7, 1);
            }
            if (this.reportDate == "AUG") {
                start = new Date(new Date().getFullYear(), 7, 1);
                end = new Date(new Date().getFullYear(), 8, 1);
            }
            if (this.reportDate == "SEP") {
                start = new Date(new Date().getFullYear(), 8, 1);
                end = new Date(new Date().getFullYear(), 9, 1);
            }
            if (this.reportDate == "OCT") {
                start = new Date(new Date().getFullYear(), 9, 1);
                end = new Date(new Date().getFullYear(), 10, 1);
            }
            if (this.reportDate == "NOV") {
                start = new Date(new Date().getFullYear(), 10, 1);
                end = new Date(new Date().getFullYear(), 11, 1);
            }
            if (this.reportDate == "DEC") {
                start = new Date(new Date().getFullYear(), 11, 1);
                end = new Date(new Date().getFullYear() + 1, 0, 1);
            }
            if (this.reportDate == 12) {
                start = new Date(new Date().getFullYear(), 0, 1);
                end = new Date(new Date().getFullYear() + 1, 0, 1);
            }
            let temp = [];
            let list = this.cashflow;
            let month = [
                "January",
                "February",
                "March",
                "April",
                "May",
                "June",
                "July",
                "August",
                "September",
                "October",
                "November",
                "December",
            ];
            list.sort((a, b) => {
                return new Date(a.created_at) - new Date(b.created_at);
            });
            list.forEach((elem) => {
                let item_date = new Date(elem.created_at);
                if (
                    elem.expense_type_id &&
                    item_date >= start &&
                    item_date <= end
                ) {
                    temp.push([
                        {
                            content:
                                month[new Date(elem.created_at).getMonth()] +
                                "/" +
                                new Date(elem.created_at).getDate() +
                                "/" +
                                new Date(elem.created_at).getFullYear(),
                            colSpan: 1,
                            rowSpan: 1,
                        },
                        {
                            content: elem.expense_type.name,
                            colSpan: 1,
                            rowSpan: 1,
                        },
                        {
                            content: elem.amount.toLocaleString() + " PHP",
                            colSpan: 1,
                            rowSpan: 1,
                        },
                    ]);
                }
            });
            return temp;
        },
        expenseTotal() {
            let start = null;
            let end = null;
            if (this.reportDate == 1) {
                start = new Date(new Date().getFullYear(), 0, 1);
                end = new Date(new Date().getFullYear(), 3, 1);
            }
            if (this.reportDate == 2) {
                start = new Date(new Date().getFullYear(), 3, 1);
                end = new Date(new Date().getFullYear(), 6, 1);
            }
            if (this.reportDate == 3) {
                start = new Date(new Date().getFullYear(), 6, 1);
                end = new Date(new Date().getFullYear(), 9, 1);
            }
            if (this.reportDate == 4) {
                start = new Date(new Date().getFullYear(), 0, 1);
                end = new Date(new Date().getFullYear() + 1, 0, 1);
            }
            if (this.reportDate == "JAN") {
                start = new Date(new Date().getFullYear(), 0, 1);
                end = new Date(new Date().getFullYear(), 1, 1);
            }
            if (this.reportDate == "FEB") {
                start = new Date(new Date().getFullYear(), 1, 1);
                end = new Date(new Date().getFullYear(), 2, 1);
            }
            if (this.reportDate == "MAR") {
                start = new Date(new Date().getFullYear(), 2, 1);
                end = new Date(new Date().getFullYear(), 3, 1);
            }
            if (this.reportDate == "APR") {
                start = new Date(new Date().getFullYear(), 3, 1);
                end = new Date(new Date().getFullYear(), 4, 1);
            }
            if (this.reportDate == "MAY") {
                start = new Date(new Date().getFullYear(), 4, 1);
                end = new Date(new Date().getFullYear(), 5, 1);
            }
            if (this.reportDate == "JUN") {
                start = new Date(new Date().getFullYear(), 5, 1);
                end = new Date(new Date().getFullYear(), 6, 1);
            }
            if (this.reportDate == "JUL") {
                start = new Date(new Date().getFullYear(), 6, 1);
                end = new Date(new Date().getFullYear(), 7, 1);
            }
            if (this.reportDate == "AUG") {
                start = new Date(new Date().getFullYear(), 7, 1);
                end = new Date(new Date().getFullYear(), 8, 1);
            }
            if (this.reportDate == "SEP") {
                start = new Date(new Date().getFullYear(), 8, 1);
                end = new Date(new Date().getFullYear(), 9, 1);
            }
            if (this.reportDate == "OCT") {
                start = new Date(new Date().getFullYear(), 9, 1);
                end = new Date(new Date().getFullYear(), 10, 1);
            }
            if (this.reportDate == "NOV") {
                start = new Date(new Date().getFullYear(), 10, 1);
                end = new Date(new Date().getFullYear(), 11, 1);
            }
            if (this.reportDate == "DEC") {
                start = new Date(new Date().getFullYear(), 11, 1);
                end = new Date(new Date().getFullYear() + 1, 0, 1);
            }
            if (this.reportDate == 12) {
                start = new Date(new Date().getFullYear(), 0, 1);
                end = new Date(new Date().getFullYear() + 1, 0, 1);
            }
            let total = 0;
            let list = this.cashflow;
            let month = [
                "January",
                "February",
                "March",
                "April",
                "May",
                "June",
                "July",
                "August",
                "September",
                "October",
                "November",
                "December",
            ];
            list.sort((a, b) => {
                return new Date(a.created_at) - new Date(b.created_at);
            });
            list.forEach((elem) => {
                let item_date = new Date(elem.created_at);
                if (
                    !elem.collection_type_id &&
                    item_date >= start &&
                    item_date <= end
                ) {
                    total += elem.amount;
                }
            });
            return total;
        },
        // revenueCount() {
        //   let count = 0;
        //   this.statement.forEach((elem) => {
        //     if (elem.type == "Revenue") {
        //       count += 1;
        //     }
        //   });
        //   return count;
        // },
        // expenseCount() {
        //   let count = 0;
        //   this.statement.forEach((elem) => {
        //     if (elem.type == "Expense") {
        //       count += 1;
        //     }
        //   });
        //   return count;
        // },
        incomeStatement() {
            let list = this.cashflow;
            list.reverse();
            list.forEach((elem) => {
                elem.created_at = new Date(elem.created_at);
                if (elem.collection_type_id) {
                    elem["type"] = "Revenue";
                } else {
                    elem["type"] = "Expense";
                }
            });
            return list;
        },
    },
    created() {
        this.initFilters();
    },
};
</script>

<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td,
th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}
</style>
