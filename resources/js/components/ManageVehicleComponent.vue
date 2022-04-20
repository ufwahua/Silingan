<template>
    <div>
        <Fieldset class="mb-3">
            <template #legend>
                <span>
                    Manage Vehicle

                    <Button
                        icon="pi pi-plus"
                        class="ml-2 p-button-rounded p-button-outlined p-button-primary"
                        v-tooltip="`Add vehicle`"
                        @click="showAddVehicleDialog"
                /></span>
            </template>
            <p class="p-1 text-center">Register your vehicles</p>

            <div v-if="userVehicles" class="flex flex-column">
                <Card
                    v-for="userVehicle in userVehicles"
                    :key="userVehicle.id"
                    class="card flex flex-column justify-content-center"
                >
                    <template #header>
                        <div class="flex justify-content-center">
                            <div v-if="userVehicle.image">
                                <Avatar
                                    :image="`http://127.0.0.1:8000${userVehicle.image}`"
                                    style="width: 150px; height: 150px"
                                    shape="circle"
                                />
                            </div>
                            <div v-else>
                                <Avatar
                                    image="http://127.0.0.1:8000/storage/images/default-prof-pic.png"
                                    style="width: 150px; height: 150px"
                                    shape="circle"
                                />
                            </div>
                        </div>
                    </template>
                    <template #title>
                        <div class="flex justify-content-center">
                            <span class="text-center m-2">
                                <p>
                                    <b>Type: </b>
                                    {{ userVehicle.type }}
                                </p>

                                <p>
                                    <b>Make: </b>
                                    {{ userVehicle.make }}
                                </p>

                                <p>
                                    <b>Model: </b>
                                    {{ userVehicle.model }}
                                </p>
                                <p>
                                    <b>Color: </b>
                                    {{ userVehicle.color }}
                                </p>
                                <p>
                                    <b>Plate Number: </b>
                                    {{ userVehicle.plate_number }}
                                </p>
                            </span>
                        </div>
                    </template>

                    <template #footer>
                        <div class="flex justify-content-center">
                            <Button
                                icon="pi pi-trash"
                                class="p-button-rounded p-button-outlined p-button-danger mr-2"
                                @click="showDeleteVehicle(userVehicle)"
                                v-tooltip="'Delete Vehicle'"
                            />
                            <Button
                                icon="pi pi-pencil"
                                class="p-button-rounded p-button-outlined p-button-primary"
                                @click="showUpdateVehicle(userVehicle)"
                                v-tooltip="'Edit Vehicle'"
                            />
                        </div>
                    </template>
                </Card>
            </div>
            <div v-else class="card flex justify-content-center">
                <p>You haven't added vehicles.</p>
            </div>
        </Fieldset>
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
        <!-- Add Modal -->
        <Dialog
            v-model:visible="addVehicleDialog"
            :style="{ width: '500px' }"
            header="Add Vehicle"
            :modal="true"
            :draggable="false"
        >
            <div class="grid">
                <div class="col-12 flex justify-content-center">
                    <div v-if="image" class="flex justify-content-center">
                        <Avatar
                            :image="`http://127.0.0.1:8000${image}`"
                            style="width: 300px; height: 300px"
                            shape="circle"
                        />
                    </div>
                    <div v-else class="flex justify-content-center">
                        <Avatar
                            image="http://127.0.0.1:8000/storage/images/default-prof-pic.png"
                            style="width: 300px; height: 300px"
                            shape="circle"
                        />
                    </div>
                </div>
                <div class="col-12 flex justify-content-center">
                    <FileUpload
                        name="demo[]"
                        mode="basic"
                        accept="image/*"
                        :customUpload="true"
                        v-model="image"
                        @uploader="onUpload"
                        :auto="true"
                        :fileLimit="1"
                        :maxFileSize="2000000"
                        v-tooltip="'Add Vehicle Image'"
                    />
                </div>
                <div class="col-12">
                    <div class="p-fluid mb-2">
                        <h6>Type</h6>
                        <Dropdown
                            :class="{
                                'p-invalid': error_selected_type,
                            }"
                            v-model="selected_type"
                            :options="type"
                            optionLabel="type"
                            optionValue="type"
                            placeholder="Select type"
                        />
                        <small v-if="error_selected_type" class="p-error">{{
                            error_selected_type
                        }}</small>
                    </div>
                </div>
                <div class="col-6">
                    <div class="p-fluid mb-2">
                        <h6>
                            Make
                            <span class="text-blue-500"
                                ><small>ex: Honda,Yamaha,etc.</small></span
                            >
                        </h6>

                        <InputText
                            v-model="make"
                            :class="{ 'p-invalid': error_make }"
                        />
                        <small v-if="error_make" class="p-error">{{
                            error_make
                        }}</small>
                    </div>
                </div>
                <div class="col-6">
                    <div class="p-fluid mb-2">
                        <h6>
                            Model
                            <span class="text-blue-500"
                                ><small>ex: NMax,XRM,Sniper,etc.</small></span
                            >
                        </h6>
                        <InputText
                            v-model="model"
                            :class="{ 'p-invalid': error_model }"
                        />
                        <small v-if="error_model" class="p-error">{{
                            error_model
                        }}</small>
                    </div>
                </div>
                <div class="col-12">
                    <div class="p-fluid mb-2">
                        <h6>Color</h6>
                        <InputText
                            v-model="color"
                            :class="{ 'p-invalid': error_color }"
                        />
                        <small v-if="error_color" class="p-error">{{
                            error_color
                        }}</small>
                    </div>
                </div>
                <div class="col-12">
                    <div class="p-fluid mb-2">
                        <h6>Plate number</h6>
                        <InputText
                            v-model="plate_number"
                            :class="{ 'p-invalid': error_plate_number }"
                        />
                        <small v-if="error_plate_number" class="p-error">{{
                            error_plate_number
                        }}</small>
                    </div>
                </div>
            </div>

            <template #footer>
                <Button
                    label="Cancel"
                    class="p-button-text p-button-danger"
                    @click="addVehicleDialog = false"
                />
                <Button
                    label="Confirm"
                    class="p-button p-button-primary"
                    @click="addVehicle"
                />
            </template>
        </Dialog>
        <!-- Update Modal -->
        <Dialog
            v-model:visible="updateVehicleDialog"
            :style="{ width: '500px' }"
            header="Update Vehicle"
            :modal="true"
            :draggable="false"
        >
            <div class="grid">
                <div class="col-12 flex justify-content-center">
                    <div v-if="image" class="flex justify-content-center">
                        <Avatar
                            :image="`http://127.0.0.1:8000${image}`"
                            style="width: 300px; height: 300px"
                            shape="circle"
                        />
                    </div>
                    <div v-else class="flex justify-content-center">
                        <Avatar
                            image="http://127.0.0.1:8000/storage/images/default-prof-pic.png"
                            style="width: 300px; height: 300px"
                            shape="circle"
                        />
                    </div>
                </div>
                <div class="col-12 flex justify-content-center">
                    <FileUpload
                        name="demo[]"
                        mode="basic"
                        accept="image/*"
                        :customUpload="true"
                        v-model="image"
                        @uploader="onUpload"
                        :auto="true"
                        :fileLimit="1"
                        :maxFileSize="2000000"
                        v-tooltip="'Update Vehicle Image'"
                    />
                </div>
            </div>

            <div>
                <div class="grid">
                    <div class="col-12">
                        <div class="p-fluid mb-2">
                            <h6>Type</h6>
                            <Dropdown
                                :class="{
                                    'p-invalid': error_selected_type,
                                }"
                                v-model="selected_type"
                                :options="type"
                                optionLabel="type"
                                optionValue="type"
                                placeholder="Select type"
                            />
                            <small v-if="error_selected_type" class="p-error">{{
                                error_selected_type
                            }}</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-fluid mb-2">
                            <h6>
                                Make
                                <span class="text-blue-500"
                                    ><small>ex: Honda,Yamaha,etc.</small></span
                                >
                            </h6>

                            <InputText
                                v-model="make"
                                :class="{ 'p-invalid': error_make }"
                            />
                            <small v-if="error_make" class="p-error">{{
                                error_make
                            }}</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-fluid mb-2">
                            <h6>
                                Model
                                <span class="text-blue-500"
                                    ><small
                                        >ex: NMax,XRM,Sniper,etc.</small
                                    ></span
                                >
                            </h6>
                            <InputText
                                v-model="model"
                                :class="{ 'p-invalid': error_model }"
                            />
                            <small v-if="error_model" class="p-error">{{
                                error_model
                            }}</small>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-fluid mb-2">
                            <h6>Color</h6>
                            <InputText
                                v-model="color"
                                :class="{ 'p-invalid': error_color }"
                            />
                            <small v-if="error_color" class="p-error">{{
                                error_color
                            }}</small>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-fluid mb-2">
                            <h6>Plate number</h6>
                            <InputText
                                v-model="plate_number"
                                :class="{ 'p-invalid': error_plate_number }"
                            />
                            <small v-if="error_plate_number" class="p-error">{{
                                error_plate_number
                            }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <template #footer>
                <Button
                    label="Cancel"
                    class="p-button-text p-button-danger"
                    @click="updateVehicleDialog = false"
                />
                <Button
                    label="Confirm"
                    class="p-button p-button-primary"
                    @click="updateVehicle"
                />
            </template>
        </Dialog>
        <!-- Delete Modal -->
        <Dialog
            v-model:visible="deleteVehicleDialog"
            :style="{ width: '450px' }"
            header="Delete Vehicle?"
            :modal="true"
        >
            <div class="confirmation-content">
                <div class="grid">
                    <div class="col-12 flex justify-content-center">
                        <div v-if="image" class="flex justify-content-center">
                            <Avatar
                                :image="`http://127.0.0.1:8000${image}`"
                                style="width: 300px; height: 300px"
                                shape="circle"
                            />
                        </div>
                        <div v-else class="flex justify-content-center">
                            <Avatar
                                image="http://127.0.0.1:8000/storage/images/default-prof-pic.png"
                                style="width: 300px; height: 300px"
                                shape="circle"
                            />
                        </div>
                    </div>
                    <div
                        class="col-12 flex align-items-center justify-content-center"
                    >
                        <span class="text-center m-5">
                            <p>
                                <b>Type: </b>
                                {{ selected_type }}
                            </p>

                            <p>
                                <b>Make: </b>
                                {{ make }}
                            </p>

                            <p>
                                <b>Model: </b>
                                {{ model }}
                            </p>
                            <p>
                                <b>Color: </b>
                                {{ color }}
                            </p>
                            <p>
                                <b>Plate Number: </b>
                                {{ plate_number }}
                            </p>
                        </span>
                    </div>
                </div>
            </div>
            <template #footer>
                <Button
                    label="Cancel"
                    class="p-button-text"
                    @click="deleteVehicleDialog = false"
                />
                <Button
                    label="Delete"
                    class="p-button-danger"
                    @click="deleteVehicle"
                />
            </template>
        </Dialog>
    </div>
</template>
<script>
import { computed } from "vue";
import { useStore } from "vuex";
export default {
    name: "ManageVehicleComponent",
    setup() {
        const store = useStore();
        return {
            userVehicles: computed(() => store.state.userVehicles.userVehicles),
            adminVehicles: computed(
                () => store.state.adminVehicles.adminVehicles
            ),
        };
    },
    data() {
        return {
            loading: false,
            addVehicleDialog: false,
            updateVehicleDialog: false,
            deleteVehicleDialog: false,
            //vehicle dialog
            image: null,
            selected_type: null,
            make: null,
            model: null,
            color: null,
            plate_number: null,
            type: [{ type: "Car" }, { type: "Motorcycle" }],

            error_selected_type: null,
            error_make: null,
            error_model: null,
            error_color: null,
            error_plate_number: null,
        };
    },
    methods: {
        populateFields(data) {
            console.log("populate fields", data);
            this.id = data.id;
            this.image = data.image;
            this.selected_type = data.type;
            this.make = data.make;
            this.model = data.model;
            this.color = data.color;
            this.plate_number = data.plate_number;
        },
        showDeleteVehicle(data) {
            this.resetFields();
            this.resetErrors();
            this.populateFields(data);
            this.deleteVehicleDialog = true;
        },
        showUpdateVehicle(data) {
            this.resetFields();
            this.resetErrors();
            this.populateFields(data);
            this.updateVehicleDialog = true;
        },
        showAddVehicleDialog() {
            this.resetFields();
            this.resetErrors();
            this.addVehicleDialog = true;
        },
        async updateVehicle() {
            this.loading = true;
            this.resetErrors();
            await axios({
                method: "put",
                url: "/api/vehicle/" + this.id,
                data: {
                    image: this.image,
                    user_id: this.$store.state.userLogged.id,
                    type: this.selected_type,
                    make: this.make,
                    model: this.model,
                    color: this.color,
                    plate_number: this.plate_number,
                },
            })
                .then((res) => {
                    this.updateVehicleDialog = false;
                    this.$toast.add({
                        severity: "success",
                        summary: "Successful Request",
                        detail: "Updated Vehicle",
                        life: 3000,
                    });
                    this.$store.dispatch(
                        "userVehicles/getAll",
                        this.$store.state.userLogged.id
                    );
                    this.loading = false;
                })
                .catch((err) => {
                    this.resetErrors();
                    this.validate(err);
                    this.loading = false;
                });
        },
        async deleteVehicle() {
            this.loading = true;
            this.resetErrors();
            await axios({
                method: "delete",
                url: "/api/vehicle/" + this.id,
            })
                .then((res) => {
                    this.deleteVehicleDialog = false;
                    this.$toast.add({
                        severity: "success",
                        summary: "Successful Request",
                        detail: "Deleted Vehicle",
                        life: 3000,
                    });
                    this.$store.dispatch(
                        "userVehicles/getAll",
                        this.$store.state.userLogged.id
                    );
                    this.loading = false;
                })
                .catch((err) => {
                    this.resetErrors();
                    this.validate(err);
                    this.loading = false;
                });
        },
        async addVehicle() {
            this.loading = true;
            this.resetErrors();
            await axios({
                method: "post",
                url: "/api/vehicle/",
                data: {
                    image: this.image,
                    user_id: this.$store.state.userLogged.id,
                    type: this.selected_type,
                    make: this.make,
                    model: this.model,
                    color: this.color,
                    plate_number: this.plate_number,
                },
            })
                .then((res) => {
                    this.addVehicleDialog = false;
                    this.$toast.add({
                        severity: "success",
                        summary: "Successful Request",
                        detail: "Added Vehicle",
                        life: 3000,
                    });
                    this.$store.dispatch(
                        "userVehicles/getAll",
                        this.$store.state.userLogged.id
                    );
                    this.loading = false;
                })
                .catch((err) => {
                    this.resetErrors();
                    this.validate(err);
                    this.loading = false;
                });
        },
        validate(error) {
            if (error.response.data.errors.type)
                this.error_selected_type = error.response.data.errors.type[0];
            if (error.response.data.errors.make)
                this.error_make = error.response.data.errors.make[0];
            if (error.response.data.errors.model)
                this.error_model = error.response.data.errors.model[0];
            if (error.response.data.errors.color)
                this.error_color = error.response.data.errors.color[0];
            if (error.response.data.errors.plate_number)
                this.error_plate_number =
                    error.response.data.errors.plate_number[0];
        },
        resetFields() {
            this.id = null;
            this.image = null;
            this.selected_type = null;
            this.make = null;
            this.model = null;
            this.color = null;
            this.plate_number = null;
        },
        resetErrors() {
            this.error_selected_type = null;
            this.error_make = null;
            this.error_model = null;
            this.error_color = null;
            this.error_plate_number = null;
        },
        async onUpload(event) {
            let formData = new FormData();
            formData.append("images[]", event.files[0]);
            formData.append("user_id", this.$store.state.userLogged.id);
            await axios
                .post("/upload", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((res) => {
                    this.image = res.data[0];
                    console.log(this.image);
                })
                .catch((e) => {
                    console.log(e.response);
                });
        },
    },
};
</script>
