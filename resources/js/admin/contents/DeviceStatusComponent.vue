<template>
  <div>
    <div class="grid">
      <div class="col-12">
        <h1>Device Status</h1>
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
                  @click="openStatusModal"
                />
              </div>
            </template>
          </Toolbar>
        </div>
      </div>
      <div class="grid">
        <div class="col-12">
          <DataTable :value="status" :filters="filters">
            <template #empty> No device status found </template>
            <template #loading> Loading </template>
            <Column field="id" header="ID"></Column>

            <Column field="name" header="Name"></Column>

            <Column header="Actions" field="actions">
              <template #body="{ data }">
                <Button
                  icon="pi pi-pencil"
                  class="p-button-rounded p-button-primary mr-2"
                  @click="openEditStatusModal(data.name, data.id)"
                />
                <Button
                  icon="pi pi-trash"
                  class="p-button-rounded p-button-danger"
                  @click="openDeleteStatusModal(data.name, data.id)"
                />
              </template>
            </Column>
          </DataTable>
        </div>
      </div>

      <Dialog
        v-model:visible="createModal"
        :style="{ width: '450px' }"
        header="Create new status"
        :modal="true"
        :closeOnEscape="true"
      >
        <div class="grid">
          <div class="col-12">
            <div class="p-fluid">
              <h5>Name</h5>
              <InputText v-model="form_name" />
              <label style="color: red" for="name" v-if="error">{{
                this.error
              }}</label>
            </div>
          </div>
        </div>
        <template #footer>
          <Button
            label="Cancel"
            icon="pi pi-times"
            class="p-button-text"
            @click="closeCreateModal()"
          />
          <Button
            label="Create"
            icon="pi pi-check"
            class="p-button-text p-button-success"
            @click="confirmCreateStatus()"
          />
        </template>
      </Dialog>

      <Dialog
        v-model:visible="updateModal"
        :style="{ width: '450px' }"
        header="Edit"
        :modal="true"
        :closeOnEscape="true"
      >
        <div class="grid">
          <div class="col-12">
            <div class="p-fluid">
              <h5>Name</h5>
              <InputText v-model="name" />
              <label style="color: red" for="name" v-if="error">{{
                this.error
              }}</label>
            </div>
          </div>
        </div>
        <template #footer>
          <Button
            label="Cancel"
            icon="pi pi-times"
            class="p-button-text"
            @click="closeUpdateModal()"
          />
          <Button
            label="Edit"
            icon="pi pi-check"
            class="p-button-text p-button-warning"
            @click="confirmEditStatus()"
          />
        </template>
      </Dialog>
      <Dialog
        v-model:visible="deleteModal"
        :style="{ width: '450px' }"
        header="Confirm"
        :modal="true"
      >
        <div class="confirmation-content">
          <div class="grid">
            <div class="col-12 flex align-items-center justify-content-center">
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
            @click="deleteModal = false"
          />
          <Button
            label="Delete"
            icon="pi pi-check"
            class="p-button-text p-button-danger"
            @click="confirmDeleteStatus()"
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
    <Toast />
  </div>
</template>

<script>
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import ColumnGroup from "primevue/columngroup";
import Button from "primevue/button";
import Toolbar from "primevue/toolbar";
import { FilterMatchMode } from "primevue/api";
import InputText from "primevue/inputtext";
import Dialog from "primevue/dialog";

import Card from "primevue/card";

import axios from "axios";

export default {
  name: "DeviceStatusComponent",
  setup() {},
  components: {
    DataTable,
    InputText,
    Column,
    ColumnGroup,
    Toolbar,
    Button,
    Dialog,
    Card,
  },
  data() {
    return {
      status: null,
      id: null,
      name: null,
      filters: {},
      search: null,
      process: false,
      actions: null,
      form_name: null,
      error: null,

      //MODAL
      createModal: false,
      updateModal: false,
      deleteModal: false,
    };
  },
  methods: {
    // Create New Status Modal
    openStatusModal() {
      this.createModal = true;
      this.form_name = null;
      this.error = null;
    },
    openEditStatusModal(name, id) {
      this.id = id;
      this.name = name;
      console.log(this.name);
      this.updateModal = true;
    },
    openDeleteStatusModal(name, id) {
      this.id = id;
      this.name = name;
      this.deleteModal = true;
    },

    initFilters() {
      this.filters = {
        global: { value: null, matchMode: FilterMatchMode.CONTAINS },
      };
    },
    resetFields() {
      this.form_name = null;
      this.error = null;
    },
    showCreateToast() {
      this.$toast.add({
        severity: "success",
        summary: "Success Message",
        detail: "Added new status",
        life: 3000,
      });
      this.resetFields();
    },
    closeCreateModal() {
      this.createModal = false;
      this.resetFields();
    },
    showUpdateToast() {
      this.$toast.add({
        severity: "success",
        summary: "Success Message",
        detail: "Updated status",
        life: 3000,
      });
      this.resetFields();
    },
    closeUpdateModal() {
      this.updateModal = false;
      this.resetFields();
    },
    showDeleteToast() {
      this.$toast.add({
        severity: "success",
        summary: "Successful Request",
        detail: "Deleted status",
        life: 3000,
      });
      this.resetFields();
    },

    async getStatus() {
      try {
        const { data } = await axios({
          method: "get",
          url: "/api/device-status/",
        });
        this.status = data;
      } catch (err) {
        console.log(err);
      }
      this.process = false;
    },
    async confirmCreateStatus() {
      try {
        this.process = true;
        await axios({
          method: "post",
          url: "/api/device-status",
          data: {
            name: this.form_name,
          },
        })
          .then((res) => {
            this.createModal = false;
            this.getStatus();
            this.showCreateToast();
          })
          .catch((err) => {
            this.error = this.form_name + " is already been taken";
            this.process = false;
          });
      } catch (err) {
        this.process = false;
        console.log(err);
      }
    },

    async confirmEditStatus() {
      try {
        this.process = true;
        await axios({
          method: "put",
          url: "/api/device-status/" + this.id,
          data: {
            name: this.name,
          },
        })
          .then((res) => {
            this.updateModal = false;
            this.getStatus();
            this.showUpdateToast();
          })
          .catch((err) => {
            this.error = this.name + " is already been taken";
            this.process = false;
            console.log(err);
          });
      } catch (err) {
        this.process = false;
        console.log(err);
      }
    },
    async confirmDeleteStatus() {
      try {
        this.process = true;
        await axios({
          method: "delete",
          url: "/api/device-status/" + this.id,
        })
          .then((res) => {
            this.deleteModal = false;
            this.getStatus();
            this.showDeleteToast();
          })
          .catch((err) => {
            this.process = false;
            console.log(err);
          });
      } catch (err) {
        this.process = false;
        console.log(err);
      }
    },
  },

  created() {
    this.initFilters();
  },
  mounted() {
    this.getStatus();
  },
};
</script>

<style></style>
