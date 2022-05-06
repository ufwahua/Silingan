<template>
    <div>
        <Toast />
        <h1>View Billing</h1>

        <div class="card">
            <DataTable
                :value="block_lot_invoices"
                :paginator="true"
                :rows="20"
                :filters="filters"
            >
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
                        >
                            {{ (data["invoice_id"] = "Invoice#" + data.id) }}
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
            block_lot_invoices: computed(() => store.state.block_lot_invoices),

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
            loading: false,

            //Modal Control
            generateReportModal: false,
            specific_invoices: [],
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
            await axios({
                method: "get",
                url: "/api/invoice/" + data.id,
            })
                .then((res) => {
                    this.specific_invoices = res.data;
                    console.log("all invoices", res.data);
                    var temp = [];
                    if (this.specific_invoices[0]) {
                        this.specific_invoices.forEach((elem) => {
                            if (elem != null && !elem.payment) {
                                temp.push([
                                    "Invoice#" + elem.id,
                                    this.dateFormat(elem.due_date),
                                    elem.collection_type.amount,
                                ]);
                            }
                        });
                        var props = {
                            outputType: "save",
                            returnJsPDFDocObject: true,
                            fileName:
                                "Invoice#" +
                                data.id +
                                "_" +
                                this.dateFormat(data.due_date),
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
                                invDate: "Due Date: " + data.due_date,
                                invGenDate:
                                    "Invoice Date: " +
                                    this.dateFormat(data.created_at),

                                invTotalLabel: "Out. Balance:",
                                invTotal: this.getOBalance(
                                    data.over_due,
                                    data.collection_type.amount
                                ),
                                row1: {
                                    col1: "Current:",
                                    col2: data.collection_type.amount,
                                    style: {
                                        fontSize: 10, //optional, default 12
                                    },
                                },
                                row2: {
                                    col1: "Overdue:",
                                    col2: this.getOverDue(data.over_due),
                                    style: {
                                        fontSize: 10, //optional, default 12
                                    },
                                },

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
                    }
                })
                .catch((err) => {
                    console.log(err.response);
                });

            var first_invoice = null;

            this.loading = false;
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
        },

        getFilterBlockLot() {
            this.$store.dispatch(
                "lots/getBlockLots",
                this.filters["lot.block.number"].value
            );
        },
    },
    mounted() {
        this.$store.dispatch(
            "getBlockLotInvoices",
            this.$store.state.userLogged.block_lot_id
        );
    },
    created() {
        this.initFilters();
    },
};
</script>

<style></style>
