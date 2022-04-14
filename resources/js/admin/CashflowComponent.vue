<template>
  <div>
    <h1>Total Funds</h1>
    <div class="grid">
      <div class="col-6">
        <h1 class="ml-4">₱{{ total_funds.toLocaleString() }}</h1>
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
        <Column field="user" header="From"></Column>
        <Column field="source" header="Source"></Column>
        <Column field="cash" header="Credit/Debit">
          <template #body="{ data }">
            ₱{{ data.cash.toLocaleString() }}
          </template>
        </Column>
        <Column field="bal" header="Running Balance">
          <template #body="{ data }">
            ₱{{ data.bal.toLocaleString() }}
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
                <Column field="bl" header="Block and Lot"></Column>
                <Column field="type" header="Type"></Column>
                <Column field="credit" header="Credit">
                  <template #body="{ data }">
                    ₱{{ data.credit.toLocaleString() }}
                  </template>
                </Column>
                <Column field="note" header="Note"></Column>
                <Column field="id" header="Actions"></Column>
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
                <Column field="bl" header="Block and Lot"></Column>
                <Column field="type" header="Type"></Column>
                <Column field="credit" header="Credit">
                  <template #body="{ data }">
                    ₱{{ data.credit.toLocaleString() }}
                  </template>
                </Column>
                <Column field="note" header="Note"></Column>
                <Column field="id" header="Actions"></Column>
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
      <div class="grid">
        <div class="col-12">
          <h1>Sample</h1>
        </div>
      </div>
      <template #footer>
        <Button
          class="p-button-success"
          label="Submit"
          icon="pi pi-check"
          @click="closeModal"
          autofocus
        />
      </template>
    </Dialog>
  </div>
</template>

<script>
import { FilterMatchMode } from "primevue/api";
export default {
  setup() {},
  data() {
    return {
      //Modal Control
      addRevenueModal: false,

      filters: {},
      total_funds: 1000,
      cashflow: [
        {
          user: "Joshua",
          source: "Rental",
          cash: 1000,
          bal: 1000,
        },
      ],
      revenue: [
        {
          id: 1,
          bl: "Block 1 Lot 1",
          type: "Rental",
          credit: 1000,
          note: "sample",
        },
        {
          id: 1,
          bl: "Block 1 Lot 1",
          type: "Rental",
          credit: 1000,
          note: "sample",
        },
        {
          id: 1,
          bl: "Block 1 Lot 1",
          type: "Rental",
          credit: 1000,
          note: "sample",
        },
      ],
    };
  },
  methods: {
    addRevenue() {
      this.addRevenueModal = !this.addRevenueModal;
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

<style>
</style>