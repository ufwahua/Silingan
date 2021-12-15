<template>
  <div>
    <div class="grid">
      <div class="col-12">
        <h1>Vendor</h1>
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
                  @click="openVendorModal"
                />
              </div>
            </template>
          </Toolbar>
        </div>
      </div>
      <div class="grid">
        <div class="col-12">
          <DataTable :value="vendor" :filters="filters">
            <template #empty> No vendor found </template>
            <template #loading> Loading </template>
            <Column field="id" header="ID"></Column>
            <Column field="name" header="Name"></Column>
            <Column field="address" header="Address"></Column>
            <Column field="contact_number" header="Contact Number"></Column>
            <Column header="Actions" field="actions">
              <template #body="{ data }">
                <Button
                  icon="pi pi-pencil"
                  class="p-button-rounded p-button-primary mr-2"
                  @click="
                    openEditVendorModal(
                      data.name,
                      data.address,
                      data.contact_number,
                      data.id
                    )
                  "
                />
                <Button
                  icon="pi pi-trash"
                  class="p-button-rounded p-button-danger"
                  @click="openDeleteVendorModal(data.name, data.id)"
                />
              </template>
            </Column>
          </DataTable>
        </div>
      </div>

      <Dialog
        v-model:visible="createModal"
        :style="{ width: '450px' }"
        header="Create new vendor"
        :modal="true"
        :closeOnEscape="true"
      >
        <div class="grid">
          <div class="col-12">
            <div class="p-fluid">
              <h5>Name</h5>
              <InputText v-model="form.name" />
              <label style="color: red" for="name" v-if="error_name">{{
                this.error_name
              }}</label>
              <h5>Address</h5>
              <InputText v-model="form.address" />
              <h5>Contact Number</h5>
              <InputText v-model="form.contact_number" />
              <label
                style="color: red"
                for="contact_number"
                v-if="error_contact_number"
                >{{ this.error_contact_number }}</label
              >
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
            @click="confirmCreateVendor()"
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
              <label style="color: red" for="name" v-if="error_name">{{
                this.error_name
              }}</label>
              <h5>Address</h5>
              <InputText v-model="address" />
              <h5>Contact Number</h5>
              <InputText v-model="contact_number" />
              <label
                style="color: red"
                for="contact_number"
                v-if="error_contact_number"
                >{{ this.error_contact_number }}</label
              >
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
            @click="confirmUpdateVendor()"
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
            @click="confirmDeleteVendor()"
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
  name: "VendorComponent",
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
      vendor: null,

      //edit form
      id: null,
      name: null,
      address: null,
      contact_number: null,

      filters: {},
      search: null,
      process: false,
      actions: null,

      //form data
      form: {
        name: null,
        address: null,
        contact_number: null,
      },

      //Validation
      error_name: null,
      error_contact_number: null,

      //MODAL
      createModal: false,
      updateModal: false,
      deleteModal: false,
    };
  },
  methods: {
    // Create New Vendor Modal
    openVendorModal() {
      this.createModal = true;
      this.resetFields();
    },
    openEditVendorModal(name, address, contact_number, id) {
      this.resetFields();
      this.id = id;
      this.name = name;
      this.address = address;
      this.contact_number = contact_number;
      this.updateModal = true;
    },
    openDeleteVendorModal(name, id) {
      this.resetFields();
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
      this.form.name = null;
      this.form.address = null;
      this.form.contact_number = null;
      this.error_name = null;
      this.error_contact_number = null;
    },
    showCreateToast() {
      this.$toast.add({
        severity: "success",
        summary: "Success Message",
        detail: "Added new vendor",
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
        detail: "Updated vendor",
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
        detail: "Deleted vendor",
        life: 3000,
      });
      this.resetFields();
    },

    async getVendor() {
      try {
        const { data } = await axios({
          method: "get",
          url: "/api/vendor",
        });
        this.vendor = data;
      } catch (err) {
        console.log(err);
      }
      this.process = false;
    },
    async confirmCreateVendor() {
      try {
        this.process = true;
        await axios({
          method: "post",
          url: "/api/vendor",
          data: {
            name: this.form.name,
            address: this.form.address,
            contact_number: this.form.contact_number,
          },
        })
          .then((res) => {
            this.createModal = false;
            this.getVendor();
            this.showCreateToast();
          })
          .catch((err) => {
            this.resetFields();
            if (err.response.data.errors.name[0]) {
              this.error_name = err.response.data.errors.name[0];
            }
            if (err.response.data.errors.contact_number[0]) {
              this.error_contact_number =
                err.response.data.errors.contact_number[0];
            }
            this.process = false;
          });
      } catch (err) {
        this.process = false;
        console.log(err);
      }
    },

    async confirmUpdateVendor() {
      try {
        this.process = true;
        await axios({
          method: "put",
          url: "/api/vendor/" + this.id,
          data: {
            name: this.name,
            address: this.address,
            contact_number: this.contact_number,
          },
        })
          .then((res) => {
            this.updateModal = false;
            this.getVendor();
            this.showUpdateToast();
          })
          .catch((err) => {
            this.resetFields();
            this.error_name = err.response.data.errors.name[0];
            this.error_contact_number =
              err.response.data.errors.contact_number[0];
            this.process = false;
          });
      } catch (err) {
        console.log(error);
        this.process = false;
      }
    },
    async confirmDeleteVendor() {
      try {
        this.process = true;
        await axios({
          method: "delete",
          url: "/api/vendor/" + this.id,
        })
          .then((res) => {
            this.deleteModal = false;
            this.getVendor();
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
    this.getVendor();
  },
};
</script>

<style></style>
