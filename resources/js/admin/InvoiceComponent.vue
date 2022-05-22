<template>
    <div>
        <Toast />
        <TabView ref="view_billing">
            <TabPanel header="Association Dues">
                <h1>Association Dues Invoices</h1>
                <div class="card">
                    <DataTable :value="invoices" :rows="20" :filters="filters">
                        <template #header>
                            <div class="flex flex-wrap justify-content-between">
                                <span class="p-input-icon-left inline-block">
                                    <i class="pi pi-search" />
                                    <InputText
                                        v-model="filters['global'].value"
                                        placeholder="Keyword Search"
                                        class="my-2"
                                    />
                                </span>
                                <Dropdown
                                    v-model="filters['lot.block.number'].value"
                                    :showClear="true"
                                    :options="blocks"
                                    optionLabel="number"
                                    optionValue="number"
                                    placeholder="Filter by block"
                                    class="my-2"
                                    style="width: 200px"
                                    @change="getFilterBlockLot"
                                ></Dropdown>
                                <Dropdown
                                    v-model="filters['lot.number'].value"
                                    :showClear="true"
                                    :options="filteredLots"
                                    optionLabel="number"
                                    optionValue="number"
                                    placeholder="Filter by lot"
                                    style="width: 200px"
                                    class="my-2"
                                ></Dropdown>

                                <Dropdown
                                    v-model="filters['status'].value"
                                    :showClear="true"
                                    :options="status"
                                    optionLabel="status"
                                    optionValue="status"
                                    placeholder="Filter by status"
                                    style="width: 200px"
                                    class="my-2"
                                ></Dropdown>

                                <Button
                                    label="Clear"
                                    icon="pi pi-filter-slash"
                                    class="my-2 p-button-outlined p-button-secondary"
                                    @click="clearFilter"
                                />
                                <div class="mr-2">
                                    <Button
                                        label="Generate Invoice"
                                        icon="pi pi-file-pdf"
                                        class="p-button-primary p-mr-2"
                                        @click="generatePDF()"
                                    />
                                </div>
                            </div>
                        </template>
                        <template #empty> No Invoice found </template>
                        <template #loading> Loading data </template>
                        <Column field="invoice_id" header="Invoice #">
                            <template #body="{ data }">
                                <Button
                                    @click="showInvoice(data)"
                                    label="Primary"
                                    class="p-button-text"
                                    v-tooltip="'View PDF'"
                                >
                                    {{
                                        (data["invoice_id"] =
                                            "Invoice#" + data.id)
                                    }}
                                </Button>
                            </template>
                        </Column>
                        <Column field="name" header="Issued by">
                            <template #body="{ data }">
                                {{
                                    (data["name"] =
                                        data.user.first_name +
                                        " " +
                                        data.user.last_name)
                                }}
                            </template>
                        </Column>
                        <Column field="lot.block.number" header="Block">
                        </Column>
                        <Column field="lot.number" header="Lot"> </Column>

                        <Column field="status" header="Status"
                            ><template #body="{ data }">
                                <div v-if="data.payment" class="text-green-700">
                                    {{ (data["status"] = "paid") }}
                                </div>
                                <div v-else class="text-pink-700">
                                    {{ (data["status"] = "unpaid") }}
                                </div>
                            </template>
                        </Column>
                        <Column field="due_date" header="Due Date"></Column>
                    </DataTable>
                </div>
            </TabPanel>
            <TabPanel header="Payment">
                <h1>Payment Invoices</h1>
                <div class="card">
                    <DataTable
                        :value="association_dues_payments"
                        :rows="20"
                        :filters="filters2"
                    >
                        <template #header>
                            <div class="flex flex-wrap justify-content-between">
                                <span class="p-input-icon-left inline-block">
                                    <i class="pi pi-search" />
                                    <InputText
                                        v-model="filters2['global'].value"
                                        placeholder="Keyword Search"
                                        class="my-2"
                                    />
                                </span>
                                <Dropdown
                                    v-model="filters2['lot.block.number'].value"
                                    :showClear="true"
                                    :options="blocks"
                                    optionLabel="number"
                                    optionValue="number"
                                    placeholder="Filter by block"
                                    class="my-2"
                                    style="width: 200px"
                                    @change="getFilterBlockLot2"
                                ></Dropdown>
                                <Dropdown
                                    v-model="filters2['lot.number'].value"
                                    :showClear="true"
                                    :options="filteredLots"
                                    optionLabel="number"
                                    optionValue="number"
                                    placeholder="Filter by lot"
                                    style="width: 200px"
                                    class="my-2"
                                ></Dropdown>
                                <Dropdown
                                    v-model="
                                        filters2['collection_type.name'].value
                                    "
                                    :showClear="true"
                                    :options="dropdown_collection_type"
                                    optionLabel="name"
                                    optionValue="name"
                                    placeholder="Filter by collection type"
                                    style="width: 250px"
                                    class="my-2"
                                ></Dropdown>

                                <Button
                                    label="Clear"
                                    icon="pi pi-filter-slash"
                                    class="my-2 p-button-outlined p-button-secondary"
                                    @click="clearFilter"
                                />
                            </div>
                        </template>
                        <template #empty> No Invoice found </template>
                        <template #loading> Loading data </template>
                        <Column field="invoice_id" header="Invoice #">
                            <template #body="{ data }">
                                <Button
                                    @click="showPayment(data)"
                                    label="Primary"
                                    class="p-button-text"
                                    v-tooltip="'View Invoice'"
                                >
                                    {{
                                        (data["invoice_id"] =
                                            "Invoice#" + data.id)
                                    }}
                                </Button>
                            </template>
                        </Column>
                        <Column field="name" header="Issued by">
                            <template #body="{ data }">
                                {{
                                    (data["name"] =
                                        data.user.first_name +
                                        " " +
                                        data.user.last_name)
                                }}
                            </template>
                        </Column>
                        <Column field="lot.block.number" header="Block">
                        </Column>
                        <Column field="lot.number" header="Lot"> </Column>
                        <Column
                            field="collection_type.name"
                            header="Collection Type"
                        >
                        </Column>
                        <Column field="created_at" header="Payment Date">
                            <template #body="{ data }">
                                {{
                                    (data["created_at"] = dateFormat(
                                        data.created_at
                                    ))
                                }}
                            </template></Column
                        >
                    </DataTable>
                </div>
            </TabPanel>
        </TabView>

        <!-- 
      Generate Report Modal
     -->
        <Dialog
            header="Generate Invoice"
            v-model:visible="generateReportModal"
            :style="{ width: '40vw' }"
            :modal="true"
        >
            <div class="grid p-fluid">
                <div class="col-12 lg:col-6">
                    <h5>Bill to</h5>
                    <Dropdown
                        v-model="form.bill_to"
                        :showClear="true"
                        :options="bill_to_dropdown"
                        optionLabel="bill"
                        optionValue="bill"
                        class="my-2"
                        :class="{
                            'p-invalid': error_bill_to,
                        }"
                    ></Dropdown>
                    <label style="color: red" v-if="error_bill_to">{{
                        error_bill_to
                    }}</label>
                </div>
                <div class="col-12 lg:col-6">
                    <h5>Due Date</h5>
                    <Calendar
                        :class="{
                            'p-invalid': error_due_date,
                        }"
                        v-model="form.due_date"
                        :manualInput="false"
                        :showIcon="true"
                        :disabledDates="invalidDates"
                    />
                    <label style="color: red" v-if="error_due_date">{{
                        error_due_date
                    }}</label>
                </div>
                <div
                    v-if="form.bill_to == 'specific block & lot'"
                    class="col-12 lg:col-6"
                >
                    <label>Block</label>

                    <Dropdown
                        v-model="form.selected_block"
                        :options="blocks"
                        optionLabel="number"
                        optionValue="number"
                        placeholder="Select Block"
                        @change="getBlockLot(this.form.selected_block_lot)"
                        :class="{
                            'p-invalid': error_selected_block,
                        }"
                    />
                    <label style="color: red" v-if="error_selected_block">{{
                        error_selected_block
                    }}</label>
                </div>

                <div
                    v-if="form.bill_to == 'specific block & lot'"
                    class="col-12 lg:col-6"
                >
                    <label>Lot</label>

                    <Dropdown
                        v-model="form.selected_block_lot"
                        :options="filteredLots"
                        optionLabel="number"
                        optionValue="id"
                        placeholder="Select Lot"
                        :class="{
                            'p-invalid': error_selected_block_lot,
                        }"
                        :disabled="form.selected_block ? false : true"
                    />
                    <label style="color: red" v-if="error_selected_block_lot">{{
                        error_selected_block_lot
                    }}</label>
                </div>
                <div class="col-12 lg:col-6">
                    <h5>Collection Type</h5>
                    <Dropdown
                        v-model="form.collection_type_id"
                        :options="dropdown_collection_type"
                        optionLabel="name"
                        optionValue="id"
                        :class="{
                            'p-invalid': error_collection_type_id,
                        }"
                        @change="setAmount"
                    ></Dropdown>
                    <label style="color: red" v-if="error_collection_type_id">{{
                        error_collection_type_id
                    }}</label>
                </div>
                <div class="col-12 lg:col-6">
                    <h5>Amount</h5>
                    <InputText
                        v-model="form.collection_amount"
                        :class="{
                            'p-invalid': error_collection_amount,
                        }"
                        disabled
                    ></InputText>
                    <label style="color: red" v-if="error_collection_amount">{{
                        error_collection_amount
                    }}</label>
                </div>
            </div>
            <template #footer>
                <Button
                    label="Generate File"
                    icon="pi pi-download"
                    autofocus
                    @click="makeInvoice"
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
import { computed } from "vue";
import { useStore } from "vuex";
import { FilterMatchMode, FilterOperator } from "primevue/api";
import axios from "axios";

export default {
    setup() {
        const store = useStore();
        return {
            invoices: computed(() => store.state.invoices),
            association_dues_payments: computed(
                () => store.state.collection.association_dues_payments
            ),
            userLogged: computed(() => store.state.userLogged),
            blocks: computed(() => store.state.blocks.blocks),
            filteredLots: computed(() => store.state.lots.filteredLots),
            lots: computed(() => store.state.lots.lots),
            dropdown_collection_type: computed(
                () => store.state.collectionType.CollectionType
            ),
        };
    },
    data() {
        return {
            filters: {},
            filters2: {},
            loading: false,
            specific_invoices: [],
            //Modal Control
            generateReportModal: false,

            status: [{ status: "paid" }, { status: "unpaid" }],
            form: {
                bill_to: null,
                due_date: null,
                selected_block: null,
                selected_block_lot: null,
                collection_type_id: 1,
                collection_amount: null,
            },
            bill_to_dropdown: [
                { bill: "all residents" },
                { bill: "specific block & lot" },
            ],

            error_bill_to: null,
            error_due_date: null,
            error_selected_block: null,
            error_selected_block_lot: null,
            error_collection_type_id: null,
            error_collection_amount: null,
        };
    },
    methods: {
        async showPayment(data) {
            this.loading = true;
            //specific block and lot
            // await axios({
            //     method: "get",
            //     url: "/api/invoice/" + data.id,
            // })
            //     .then((res) => {
            //         this.specific_invoices = res.data;
            //         console.log("specific_invoices", res.data);
            // var temp = [];
            // if (this.specific_invoices[0]) {
            //     this.specific_invoices.forEach((elem) => {
            //         if (elem != null && !elem.payment) {
            //             temp.push([
            //                 "Invoice#" + elem.id,
            //                 this.dateFormat(elem.due_date),
            //                 elem.collection_type.amount,
            //             ]);
            //         }
            //     });
            // }
            var props = {
                outputType: "save",
                returnJsPDFDocObject: true,
                fileName:
                    "Invoice#" +
                    data.id +
                    "_" +
                    this.dateFormat(data.created_at),
                orientationLandscape: false,
                compress: true,
                logo: {
                    src: "http://127.0.0.1:8000/storage/images/silingan-icon.png",
                    type: "PNG", //optional, when src= data:uri (nodejs case)
                    width: 53.33, //aspect ratio = width/height
                    height: 26.66,
                    margin: {
                        top: 0, //negative or positive num, from the current position
                        left: 0, //negative or positive num, from the current position
                    },
                },
                business: {
                    label: "Invoice issued for:",
                    name: "Silingan",
                    address: "Camella Homes Mactan, Lapu-Lapu City",
                    phone: "(+63) 908 302 4328",
                    email: "silinganapp.ph@gmail.com",
                    website: "http://127.0.0.1:8000/",
                },
                contact: {
                    label: "Invoice issued for:",
                    name:
                        "Block " +
                        data.lot.block.number +
                        " Lot " +
                        data.lot.number,
                    address: "Camella Homes Mactan, Lapu Lapu City",
                },
                invoice: {
                    label: "Invoice #: ",
                    num: data.id,
                    invGenDate:
                        "Invoice Date: " + this.dateFormat(data.created_at),
                    header: [
                        {
                            title: "Collection Type",
                            style: {
                                width: 42,
                            },
                        },
                        {
                            title: "Notes",
                            style: {
                                width: 125,
                            },
                        },
                        {
                            title: "Amount",
                            style: {
                                width: 90,
                            },
                        },
                    ],
                    table: Array.from([
                        [
                            data.collection_type.name,
                            data.notes != null ? data.notes : "",
                            data.amount.toString(),
                        ],
                    ]),
                    invTotalLabel: "Total:",
                    invTotal: data.amount.toString(),

                    invDescLabel: "Issued By:",
                    invDesc:
                        data.user.first_name +
                        " " +
                        data.user.last_name +
                        " [" +
                        data.user.role +
                        "] ",
                },
                footer: {
                    text: "The invoice is created on a computer and is valid without the signature and stamp and Kindly settle your accounts in the admin office thank you!",
                },
                pageEnable: true,
                pageLabel: "Page ",
            };
            jsPDFInvoiceTemplate.default(props);
            this.loading = false;
            // })
            // .catch((err) => {
            //     console.log(err.response);
            // });
        },
        showDate() {
            console.log("due date", this.form.due_date);
        },
        resetFields() {
            this.form.bill_to = null;
            this.form.due_date = null;
            this.form.selected_block = null;
            this.form.selected_block_lot = null;
            this.form.collection_type_id = 1;
            this.setAmount();
        },
        dateFormat(date) {
            var options = {
                year: "numeric",
                month: "long",
                day: "numeric",
            };

            return new Date(date).toLocaleDateString("en-US", options);
        },

        async showInvoice(data) {
            this.loading = true;
            //specific block and lot
            // await axios({
            //     method: "get",
            //     url: "/api/invoice/" + data.id,
            // })
            //     .then((res) => {
            //         this.specific_invoices = res.data;
            //         console.log("specific invoices", res.data);
            var props = {
                outputType: "save",
                returnJsPDFDocObject: true,
                fileName:
                    "Invoice#" + data.id + "_" + this.dateFormat(data.due_date),
                orientationLandscape: false,
                compress: true,
                logo: {
                    src: "http://127.0.0.1:8000/storage/images/silingan-icon.png",
                    type: "PNG", //optional, when src= data:uri (nodejs case)
                    width: 53.33, //aspect ratio = width/height
                    height: 26.66,
                    margin: {
                        top: 0, //negative or positive num, from the current position
                        left: 0, //negative or positive num, from the current position
                    },
                },
                business: {
                    name: "Silingan",
                    address: "Camella Homes Mactan, Lapu-Lapu City",
                    phone: "(+63) 908 302 4328",
                    email: "silinganapp.ph@gmail.com",
                    website: "http://127.0.0.1:8000/",
                },
                contact: {
                    label: "Invoice issued for:",
                    name:
                        "Block " +
                        data.lot.block.number +
                        " Lot " +
                        data.lot.number,
                    address: "Camella Homes Mactan, Lapu Lapu City",
                },
                invoice: {
                    label: "Invoice #: ",
                    num: data.id,
                    invDate: "Due Date: " + data.due_date,
                    invGenDate:
                        "Invoice Date: " + this.dateFormat(data.created_at),

                    invTotalLabel: "Out. Balance:",
                    invTotal: this.getOBalance(
                        data.over_due,
                        data.collection_type.amount
                    ).toString(),
                    row1: {
                        col1: "Current:",
                        col2: data.collection_type.amount.toString(),
                        style: {
                            fontSize: 10, //optional, default 12
                        },
                    },
                    row2: {
                        col1: "Overdue:",
                        col2: this.getOverDue(data.over_due).toString(),
                        style: {
                            fontSize: 10, //optional, default 12
                        },
                    },

                    invDescLabel: "Invoice Note",
                    invDesc:
                        "Please settle your accounts in the admin office thank you!",
                },
                footer: {
                    text: "The invoice is created on a computer and is valid without the signature and stamp.",
                },
                pageEnable: true,
                pageLabel: "Page ",
            };
            jsPDFInvoiceTemplate.default(props);
            this.loading = false;
            // })
            // .catch((err) => {
            //     console.log(err.response);
            // });
        },

        getOverDue(over_due) {
            if (over_due > 0) {
                return over_due;
            } else {
                return "0";
            }
        },
        getOBalance(over_due, collection_amount) {
            let number = +over_due + +collection_amount;
            console.log("over_due", over_due);
            return number.toString();
        },
        async makeInvoice() {
            this.loading = true;
            if (this.form.bill_to == "all residents") {
                if (this.form.bill_to && this.form.due_date) {
                    await axios({
                        method: "post",
                        url: "/api/invoice/bill-all/",
                        data: {
                            user_id_from: this.$store.state.userLogged.id,
                            collection_type_id: this.form.collection_type_id,
                            due_date: this.form.due_date,
                        },
                    })
                        .then((res) => {
                            console.log(res.data);
                            console.log("invoice created");
                            this.$store.dispatch("getAllInvoice");
                            this.generateReportModal = false;
                        })
                        .catch((err) => {
                            console.log(err.response.data.message);

                            this.generateReportModal = false;
                        });
                } else {
                    this.resetErrors();
                    if (!this.form.bill_to) {
                        this.error_bill_to = "This bill to field is required";
                    }
                    if (!this.form.due_date) {
                        this.error_due_date = "This due date field is required";
                    }
                    if (!this.form.collection_type_id) {
                        this.error_collection_type_id =
                            "This collection type field is required";
                    }
                    if (!this.form.collection_amount) {
                        this.error_collection_amount =
                            "This amount field is required";
                    }
                }
            } else {
                if (
                    this.form.bill_to &&
                    this.form.due_date &&
                    this.form.selected_block &&
                    this.form.selected_block_lot
                ) {
                    await axios({
                        method: "post",
                        url: "/api/invoice/bill-specific/",
                        data: {
                            user_id_from: this.$store.state.userLogged.id,
                            collection_type_id: this.form.collection_type_id,
                            block_lot_id: this.form.selected_block_lot,
                            due_date: this.form.due_date,
                        },
                    })
                        .then((res) => {
                            console.log(res.data);
                            console.log("invoice created");
                            this.$store.dispatch("getAllInvoice");
                            this.generateReportModal = false;
                        })
                        .catch((err) => {
                            console.log(err.response);

                            this.generateReportModal = false;
                        });
                } else {
                    this.resetErrors();
                    if (!this.form.bill_to) {
                        this.error_bill_to = "This bill to field is required";
                    }
                    if (!this.form.due_date) {
                        this.error_due_date = "This due date field is required";
                    }
                    if (!this.form.collection_type_id) {
                        this.error_collection_type_id =
                            "This collection type field is required";
                    }
                    if (!this.form.collection_amount) {
                        this.error_collection_amount =
                            "This amount field is required";
                    }
                    if (!this.form.selected_block) {
                        this.error_selected_block =
                            "This block field is required";
                    }
                    if (!this.form.selected_block_lot) {
                        this.error_selected_block_lot =
                            "This lot field is required";
                    }
                }
            }
            this.loading = false;
        },
        resetErrors() {
            this.error_bill_to = null;
            this.error_due_date = null;
            this.error_selected_block = null;
            this.error_selected_block_lot = null;
            this.error_collection_type_id = null;
            this.error_collection_amount = null;
        },
        generatePDF() {
            this.resetFields();
            this.generateReportModal = true;
        },
        clearFilter() {
            this.filters["lot.block.number"].value = null;
            this.filters["lot.number"].value = null;
            this.filters["status"].value = null;
        },
        initFilters() {
            this.filters = {
                global: { value: null, matchMode: FilterMatchMode.CONTAINS },

                "lot.block.number": {
                    value: null,
                    matchMode: FilterMatchMode.EQUALS,
                },
                "lot.number": {
                    value: null,
                    matchMode: FilterMatchMode.EQUALS,
                },

                status: {
                    value: null,
                    matchMode: FilterMatchMode.EQUALS,
                },
            };
            this.filters2 = {
                global: { value: null, matchMode: FilterMatchMode.CONTAINS },
                "lot.block.number": {
                    value: null,
                    matchMode: FilterMatchMode.EQUALS,
                },
                "lot.number": {
                    value: null,
                    matchMode: FilterMatchMode.EQUALS,
                },
                "collection_type.name": {
                    value: null,
                    matchMode: FilterMatchMode.EQUALS,
                },
            };
        },
        getBlockLot(lot) {
            this.$store.dispatch("lots/getBlockLots", this.form.selected_block);
            this.form.selected_block_lot = lot;
        },
        getFilterBlockLot() {
            this.$store.dispatch(
                "lots/getBlockLots",
                this.filters["lot.block.number"].value
            );
        },
        getFilterBlockLot2() {
            this.$store.dispatch(
                "lots/getBlockLots",
                this.filters2["lot.block.number"].value
            );
        },
        setAmount() {
            this.dropdown_collection_type.forEach((elem) => {
                if (elem.id == this.form.collection_type_id) {
                    this.form.collection_amount = elem.amount;
                }
            });
        },
    },
    mounted() {
        this.setAmount();
        this.$store.dispatch("getAllInvoice");
        this.$store.dispatch("collection/getAllCollection");
        console.log("collection", this.association_dues_payments);
    },
    created() {
        this.initFilters();
        let today = new Date();
        let yesterday = new Date();
        yesterday.setDate(today.getDate() - 1);
        var invalid_dates = [];
        var firstDay = new Date(today.getFullYear(), today.getMonth(), 1);

        for (let i = firstDay.getDate(); i <= yesterday.getDate(); i++) {
            let date = new Date();
            date.setDate(today.getDate() - i);
            invalid_dates.push(date);
        }
        this.invalidDates = invalid_dates;
    },
};
</script>

<style></style>
