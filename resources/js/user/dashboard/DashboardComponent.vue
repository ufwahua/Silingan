<template>
    <div>
        <div class="container lanex-font">
            <div class="grid">
                <div class="col-12">
                    <h1>Dashboard</h1>
                </div>
            </div>
            <div class="grid">
                <div class="col-12 lg:col-6 xl:col-3 mb-4">
                    <Card class="shadow-4 bg-yellow-100">
                        <template #title>
                            <div class="grid m-1">
                                <div class="col-6">
                                    <span class="block mb-3">100</span>
                                </div>
                                <div class="col-6 text-right">
                                    <i
                                        class="pi pi-book text-yellow-500"
                                        style="fontsize: 3rem"
                                    ></i>
                                </div>
                            </div>
                        </template>
                        <template #subtitle>
                            <div class="grid m-1">
                                <div class="col-12">
                                    <span class="text-700"
                                        >Pending Requests</span
                                    >
                                </div>
                            </div>
                        </template>
                    </Card>
                </div>
                <div class="col-12 lg:col-6 xl:col-3 mb-4">
                    <Card class="shadow-4 bg-green-100">
                        <template #title>
                            <div class="grid m-1">
                                <div class="col-6">
                                    <span class="block mb-3">200</span>
                                </div>
                                <div class="col-6 text-right">
                                    <i
                                        class="pi pi-inbox text-green-500"
                                        style="fontsize: 3rem"
                                    ></i>
                                </div>
                            </div>
                        </template>
                        <template #subtitle>
                            <div class="grid m-1">
                                <div class="col-12">
                                    <span class="text-700"
                                        >Available Devices</span
                                    >
                                </div>
                            </div>
                        </template>
                    </Card>
                </div>
                <div class="col-12 lg:col-6 xl:col-3 mb-4">
                    <Card class="shadow-4 bg-pink-100">
                        <template #title>
                            <div class="grid m-1">
                                <div class="col-6">
                                    <span class="block mb-3">300</span>
                                </div>
                                <div class="col-6 text-right">
                                    <i
                                        class="pi pi-book text-pink-500"
                                        style="fontsize: 3rem"
                                    ></i>
                                </div>
                            </div>
                        </template>
                        <template #subtitle>
                            <div class="grid m-1">
                                <div class="col-12">
                                    <span class="text-700"
                                        >Recent Rejected Requests</span
                                    >
                                </div>
                            </div>
                        </template>
                    </Card>
                </div>
            </div>
            <div class="grid">
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
                                    class="
                                        col-6
                                        text-right
                                        align-items-center
                                        justify-content-end
                                        flex
                                    "
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
            </div>
        </div>
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
    

    mounted(){
        this.$router.go(this.$router.currentRoute);
    }
};
</script>

<style>
@import "./App.scss";
@import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap");

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
