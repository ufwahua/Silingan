<template>
  <div>
    <Toast />
    <div class="grid">
      <div class="col-12">
        <h1>Device Condition</h1>
      </div>
    </div>
    <div class="card">
      <div class="grid mb-4">
        <div class="col-12">
          <Toolbar>
            <template #left>
              <span class="p-input-icon-left inline-block">
                <i class="pi pi-search" />
                <InputText
                  v-model="filters['global'].value"
                  placeholder="Keyword Search"
                />
              </span>
            </template>

            <template #right>
              <div class="mr-2">
                <Button
                  label="New"
                  icon="pi pi-plus"
                  class="p-button-success p-mr-2"
                  @click="addItem()"
                />
              </div>
            </template>
          </Toolbar>
        </div>
      </div>
      <div class="grid">
        <div class="col-12">
          <DataTable :value="data" :filters="filters">
            <template #empty> No device conditions found </template>
            <template #loading> Loading Devices </template>
            <Column header="Id" field="id" style="min-width: 14rem">
              <template #body="{ data }">
                {{ data.id }}
              </template>
            </Column>
            <Column header="Name" field="name" style="min-width: 14rem">
              <template #body="{ data }">
                <Badge :class="badgecolor(data.name)">{{ data.name }}</Badge>
              </template>
            </Column>
            <Column header="Actions" field="actions">
              <template #body="{ data }">
                <Button
                  icon="pi pi-pencil"
                  class="p-button-rounded p-button-primary mr-2"
                  @click="editItem(data.name, data.id)"
                />
                <Button
                  icon="pi pi-trash"
                  class="p-button-rounded p-button-danger"
                  @click="deleteItem(data.name, data.id)"
                />
              </template>
            </Column>
          </DataTable>

          <Dialog
            v-model:visible="deleteItemDialog"
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
                    >Are you sure you want to delete <b>{{ name }}</b
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
                @click="deleteItemDialog = false"
              />
              <Button
                label="Delete"
                icon="pi pi-check"
                class="p-button-text p-button-danger"
                @click="confirmDeleteItem(id)"
              />
            </template>
          </Dialog>
          <Dialog
            v-model:visible="editItemDialog"
            :style="{ width: '450px' }"
            header="Edit"
            :modal="true"
          >
            <div class="grid">
              <div class="col-12">
                <div class="p-fluid">
                  <h5>Name</h5>
                  <InputText v-model="name" />
                </div>
              </div>
            </div>
            <template #footer>
              <Button
                label="Cancel"
                icon="pi pi-times"
                class="p-button-text"
                @click="editItemDialog = false"
              />
              <Button
                label="Edit"
                icon="pi pi-check"
                class="p-button-text p-button-warning"
                @click="confirmEditItem(id)"
              />
            </template>
          </Dialog>
          <Dialog
            v-model:visible="addItemDialog"
            :style="{ width: '450px' }"
            header="Add"
            :modal="true"
          >
            <div class="grid">
              <div class="col-12">
                <div class="p-fluid">
                  <h5>Name</h5>
                  <InputText v-model="name" :class="{'p-invalid':isInvalid}"/>
                  <div v-if="isInvalid">
                      <p class="text-pink-900 mt-2">{{invalidMsg}}</p>
                  </div>
                </div>
              </div>
            </div>
            <template #footer>
              <Button
                label="Cancel"
                icon="pi pi-times"
                class="p-button-text"
                @click="addItemDialog = false"
              />
              <Button
                label="Add"
                icon="pi pi-check"
                class="p-button-text p-button-success"
                @click="confirmAddItem()"
              />
            </template>
          </Dialog>
          <Dialog
            v-model:visible="process"
            :style="{ width: '450px' }"
            :modal="true"
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
                <span class="block">Processeing Request...</span>
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
export default {
  name: "DeviceConditionComponent",
  data() {
    return {
      invalidMsg: "asd",
      isInvalid: false,
      filters: {},
      id: null,
      name: null,
      process: false,
      addItemDialog: false,
      deleteItemDialog: false,
      editItemDialog: false,
      data: [
        {
          id: 1,
          name: "Brand New",
        },
        {
          id: 2,
          name: "Good",
        },
        {
          id: 3,
          name: "Fair",
        },
        {
          id: 4,
          name: "Old",
        },
        {
          id: 5,
          name: "Poor",
        },
        {
          id: 6,
          name: "For Disposal",
        },
        {
          id: 7,
          name: "For Repair",
        },
        {
          id: 8,
          name: "Sold",
        },
      ],
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
    badgecolor(color) {
      if (color == "Good") {
        return "bg-yellow-500";
      } else if (color == "Fair" || color == "For Repair") {
        return "bg-orange-500";
      } else if (color == "Old") {
        return "surface-500";
      } else if (color == "Poor" || color == "For Disposal") {
        return "bg-pink-500";
      } else if (color == "Brand New") {
        return "bg-green-500";
      } else if (color == "Sold") {
        return "bg-gray-900";
      }
    },
    deleteItem(name, id) {
      this.id = id;
      this.name = name;
      this.deleteItemDialog = true;
    },
    editItem(name, id) {
      this.id = id;
      this.name = name;
      this.editItemDialog = true;
    },
    addItem() {
      this.addItemDialog = true;
    },
    async confirmDeleteItem(id) {
      try {
        this.deleteItemDialog = false;
        this.process = true;
        await axios({
          method: "delete",
          url: "/api/device-condition/" + id,
        });
        this.get();
        this.process = false;
        this.$toast.add({
          severity: "success",
          summary: "Successful Request",
          detail: "Deleted Condition",
          life: 3000,
        });
      } catch (err) {
        this.process = false;
        console.log(err.response);
        this.$toast.add({
          severity: "error",
          summary: "Invalid Request",
          detail: err.response.data.errors.name[0],
          life: 3000,
        });
      }
    },
    async confirmEditItem(id) {
      try {
        this.editItemDialog = false;
        this.process = true;
        await axios({
          method: "put",
          url: "/api/device-condition/" + id,
          data: {
            name: this.name,
          },
        });
        this.get();
        this.process = false;
        this.$toast.add({
          severity: "success",
          summary: "Successful Request",
          detail: "Edited Condition",
          life: 3000,
        });
      } catch (err) {
        this.process = false;
        console.log(err.response);
        this.$toast.add({
          severity: "error",
          summary: "Invalid Request",
          detail: err.response.data.errors.name[0],
          life: 3000,
        });
      }
    },
    async get() {
      try {
        const { data } = await axios({
          method: "get",
          url: "/api/device-condition/",
        });
        this.data = data;
      } catch (err) {
        console.log(err);
      }
    },
    async confirmAddItem() {
      try {
        this.process = true;
        const { data } = await axios({
          method: "post",
          url: "/api/device-condition",
          data: {
            name: this.name,
          },
        });
        this.isInvalid=false;
        this.addItemDialog = false;
        this.get();
        this.process = false;
        this.$toast.add({
          severity: "success",
          summary: "Successful Request",
          detail: "Added new condition",
          life: 3000,
        });
      } catch (err) {
        this.process = false;
        this.isInvalid=true;
        this.invalidMsg = err.response.data.errors.name[0]
      }
    },
  },
  created() {
    this.initFilters();
  },
  mounted() {
    this.get();
  },
};
</script>

<style></style>
