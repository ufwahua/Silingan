<template>
    <div class="grid">
        <div class="col-12">
            <h1>Dashboard</h1>
        </div>

        <div class="col-12 lg:col-6 xl:col-3">
            <div class="card mb-0">
                <div class="flex justify-content-between mb-3">
                    <div>
                        <span class="block text-500 font-medium mb-3"
                            >Orders</span
                        >
                        <div class="text-900 font-medium text-xl">152</div>
                    </div>
                    <div
                        class="flex align-items-center justify-content-center bg-blue-100 border-round"
                        style="width: 2.5rem; height: 2.5rem"
                    >
                        <i
                            class="pi pi-shopping-cart text-blue-500 text-xl"
                        ></i>
                    </div>
                </div>
                <span class="text-green-500 font-medium">24 new </span>
                <span class="text-500">since last visit</span>
            </div>
        </div>
        <div class="col-12 lg:col-6 xl:col-3">
            <div class="card mb-0">
                <div class="flex justify-content-between mb-3">
                    <div>
                        <span class="block text-500 font-medium mb-3"
                            >Revenue</span
                        >
                        <div class="text-900 font-medium text-xl">$2.100</div>
                    </div>
                    <div
                        class="flex align-items-center justify-content-center bg-orange-100 border-round"
                        style="width: 2.5rem; height: 2.5rem"
                    >
                        <i class="pi pi-map-marker text-orange-500 text-xl"></i>
                    </div>
                </div>
                <span class="text-green-500 font-medium">%52+ </span>
                <span class="text-500">since last week</span>
            </div>
        </div>
        <div class="col-12 lg:col-6 xl:col-3">
            <div class="card mb-0">
                <div class="flex justify-content-between mb-3">
                    <div>
                        <span class="block text-500 font-medium mb-3"
                            >Customers</span
                        >
                        <div class="text-900 font-medium text-xl">28441</div>
                    </div>
                    <div
                        class="flex align-items-center justify-content-center bg-cyan-100 border-round"
                        style="width: 2.5rem; height: 2.5rem"
                    >
                        <i class="pi pi-inbox text-cyan-500 text-xl"></i>
                    </div>
                </div>
                <span class="text-green-500 font-medium">520 </span>
                <span class="text-500">newly registered</span>
            </div>
        </div>
        <div class="col-12 lg:col-6 xl:col-3">
            <div class="card mb-0">
                <div class="flex justify-content-between mb-3">
                    <div>
                        <span class="block text-500 font-medium mb-3"
                            >Comments</span
                        >
                        <div class="text-900 font-medium text-xl">
                            152 Unread
                        </div>
                    </div>
                    <div
                        class="flex align-items-center justify-content-center bg-purple-100 border-round"
                        style="width: 2.5rem; height: 2.5rem"
                    >
                        <i class="pi pi-comment text-purple-500 text-xl"></i>
                    </div>
                </div>
                <span class="text-green-500 font-medium">85 </span>
                <span class="text-500">responded</span>
            </div>
        </div>

        <!-- <div class="grid">
                <div class="col-12">
                    <DataTable :value="data">
                        <template #header>
                            <div class="grid">
                                <div class="col-6">
                                    <h4 class="inline-block">
                                        Assigned Devices
                                    </h4>
                                </div>
                                <div
                                    class="col-6 text-right align-items-center justify-content-end flex"
                                >
                                    <span
                                        class="p-input-icon-left inline-block"
                                    >
                                        <i class="pi pi-search" />
                                        <InputText
                                            placeholder="Keyword Search"
                                        />
                                    </span>
                                </div>
                            </div>
                        </template>
                        <template #empty> No assigned devices found. </template>
                        <template #loading> Loading Devices </template>
                        <Column
                            header="Assigned To"
                            field="name"
                            sortable
                            style="min-width: 14rem"
                        >
                            <template #body="{ data }">
                                {{ data.name }}
                            </template>
                        </Column>
                        <Column
                            header="Assigned Date"
                            field="date"
                            sortable
                            style="min-width: 14rem"
                        >
                            <template #body="{ data }">
                                {{ data.date }}
                            </template>
                        </Column>
                        <Column
                            header="Type"
                            field="type"
                            sortable
                            style="min-width: 14rem"
                        >
                            <template #body="{ data }">
                                {{ data.type }}
                            </template>
                        </Column>
                        <Column
                            header="Model"
                            field="model"
                            sortable
                            style="min-width: 14rem"
                        >
                            <template #body="{ data }">
                                {{ data.model }}
                            </template>
                        </Column>
                        <Column
                            header="Brand"
                            field="brand"
                            sortable
                            style="min-width: 14rem"
                        >
                            <template #body="{ data }">
                                {{ data.brand }}
                            </template>
                        </Column>
                    </DataTable>
                </div>
            </div> -->
    </div>
</template>

<script>
import Card from "primevue/card";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import ColumnGroup from "primevue/columngroup";
import InputText from "primevue/inputtext";
export default {
    name: "DashboardComponent",
    components: {
        Card,
        DataTable,
        Column,
        ColumnGroup,
        InputText,
    },
    data() {
        return {
            data: [
                {
                    name: "Jayson Cadiz",
                    date: "January 1, 2021",
                    type: "Laptop",
                    model: "Aspire-15",
                    brand: "Acer",
                },
                {
                    name: "Gio Alfanta",
                    date: "January 2, 2021",
                    type: "Desktop",
                    model: "Aspire-15",
                    brand: "Acer",
                },
                {
                    name: "Godfrey Español",
                    date: "January 3, 2021",
                    type: "Mouse",
                    model: "Abyssus",
                    brand: "Razer",
                },
            ],
        };
    },
};
</script>

<style>
.container {
    margin-left: 5%;
    margin-right: 5%;
}
.lanex-font {
    font-family: "Poppins", sans-serif;
}
.lanex-font-title {
    font-size: 24px;
}
.lanex-font-content {
    font-size: 14px;
}
</style>
