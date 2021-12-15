<template>
    <div>
        <div class="grid mb-2">
            <div class="col-12">
                <h1>Dashboard</h1>
            </div>
        </div>
        <div class="grid mb-2">
            <div class="col-12 lg:col-6 xl:col-3">
                <div class="card mb-0 bg-blue-100">
                    <div class="flex justify-content-between mb-3">
                        <div>
                            <span class="block font-bold mb-3">Accounts</span>
                            <div class="text-900 font-medium text-xl">1000</div>
                        </div>
                        <div
                            class="
                                flex
                                align-items-center
                                justify-content-center
                            "
                            style="width: 2.5rem; height: 2.5rem"
                        >
                            <i class="pi pi-users text-blue-500 text-xl"></i>
                        </div>
                    </div>
                    <span class="font-medium">10 </span>
                    <span>accounts recently loggedin</span>
                </div>
            </div>
            <div class="col-12 lg:col-6 xl:col-3">
                <div class="card mb-0 bg-pink-100">
                    <div class="flex justify-content-between mb-3">
                        <div>
                            <span class="block font-bold mb-3">Laptops</span>
                            <div class="text-900 font-medium text-xl">2000</div>
                        </div>
                        <div
                            class="
                                flex
                                align-items-center
                                justify-content-center
                            "
                            style="width: 2.5rem; height: 2.5rem"
                        >
                            <i class="pi pi-desktop text-pink-500 text-xl"></i>
                        </div>
                    </div>
                    <span class="font-medium">10 </span>
                    <span>recently requested</span>
                </div>
            </div>
            <div class="col-12 lg:col-6 xl:col-3">
                <div class="card mb-0 bg-yellow-100">
                    <div class="flex justify-content-between mb-3">
                        <div>
                            <span class="block font-bold mb-3">Monitors</span>
                            <div class="text-900 font-medium text-xl">3000</div>
                        </div>
                        <div
                            class="
                                flex
                                align-items-center
                                justify-content-center
                            "
                            style="width: 2.5rem; height: 2.5rem"
                        >
                            <i
                                class="pi pi-desktop text-yellow-500 text-xl"
                            ></i>
                        </div>
                    </div>
                    <span class="font-medium">10 </span>
                    <span>recently requested</span>
                </div>
            </div>
            <div class="col-12 lg:col-6 xl:col-3">
                <div class="card mb-0 bg-green-100">
                    <div class="flex justify-content-between mb-3">
                        <div>
                            <span class="block font-bold mb-3"
                                >Other Devices</span
                            >
                            <div class="text-900 font-medium text-xl">4000</div>
                        </div>
                        <div
                            class="
                                flex
                                align-items-center
                                justify-content-center
                            "
                            style="width: 2.5rem; height: 2.5rem"
                        >
                            <i class="pi pi-inbox text-xl"></i>
                        </div>
                    </div>
                    <span class="font-medium">10 </span>
                    <span>newly added</span>
                </div>
            </div>
        </div>
        <div class="grid">
            <div class="col-12">
                <DataTable :value="data">
                    <template #header>
                        <div class="grid">
                            <div class="col-6">
                                <h4 class="inline-block">Assigned Devices</h4>
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
                                <span class="p-input-icon-left inline-block">
                                    <i class="pi pi-search" />
                                    <InputText placeholder="Keyword Search" />
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
</template>

<script>
export default {
    name: "DashboardComponent",
    data() {
        return {
            products: null,
            lineData: {
                labels: [
                    "January",
                    "February",
                    "March",
                    "April",
                    "May",
                    "June",
                    "July",
                ],
                datasets: [
                    {
                        label: "Revenue",
                        data: [65, 59, 80, 81, 56, 55, 40],
                        fill: false,
                        backgroundColor: "#2f4860",
                        borderColor: "#2f4860",
                        tension: 0.4,
                    },
                    {
                        label: "Sales",
                        data: [28, 48, 40, 19, 86, 27, 90],
                        fill: false,
                        backgroundColor: "#00bb7e",
                        borderColor: "#00bb7e",
                        tension: 0.4,
                    },
                ],
            },
            items: [
                { label: "Add New", icon: "pi pi-fw pi-plus" },
                { label: "Remove", icon: "pi pi-fw pi-minus" },
            ],
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

<style></style>
