<template>
    <div class="grid">
        <div
            class="col-12 sm:col-12 md:col-10 md:col-offset-1 lg:col-6 lg:col-offset-1 xl:col-6 xl:col-offset-1"
        >
            <div class="col justify-content-center pt-0">
                <Fieldset class="mb-3" legend="Manage Blocking">
                    <p class="p-4">
                        Once you block someone, that person can no longer see
                        things you post on your timeline and in the marketplace.
                    </p>
                    <div>
                        <div class="flex justify-content-center mb-4">
                            <b class="flex align-items-center mr-2 p-2"
                                >Block Users</b
                            >
                            <Dropdown
                                v-model="selectedUser"
                                :options="users"
                                optionLabel="full_name"
                                optionValue="id"
                                :filter="true"
                                placeholder="Select a user"
                                :showClear="true"
                                class="mr-2"
                            >
                                <template #option="slotProps">
                                    {{
                                        (slotProps.option["full_name"] =
                                            slotProps.option.first_name +
                                            " " +
                                            slotProps.option.last_name)
                                    }}
                                </template>
                            </Dropdown>
                            <Button
                                label="Block"
                                @click="openBlockDialog"
                                class="p-button-outlined"
                                :disabled="selectedUser ? false : true"
                            ></Button>
                        </div>
                    </div>
                    <div v-if="block_users[0]" class="card flex flex-column">
                        <div
                            v-for="block_user in block_users"
                            :key="block_user.id"
                            class="flex flex-row justify-content-center"
                        >
                            <span class="text-center p-2">
                                {{ block_user.block_user.first_name }}
                                {{ block_user.block_user.last_name }}
                            </span>
                            <span>
                                <Button
                                    class="p-button-text p-button-sm p-2"
                                    label="Unblock"
                                    @click="openUnblockDialog(block_user)"
                                ></Button
                            ></span>
                        </div>
                    </div>
                    <div v-else class="card flex justify-content-center">
                        <p>You haven't added anyone to your block list.</p>
                    </div>
                </Fieldset>
            </div>
            <div class="col justify-content-center pt-0">
                <Fieldset class="mb-3">
                    <template #legend>
                        <span>
                            Manage Vehicle

                            <Button
                                icon="pi pi-plus"
                                class="ml-2 p-button-rounded p-button-outlined p-button-success"
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
                                            style="width: 300px; height: 300px"
                                            shape="circle"
                                        />
                                    </div>
                                    <div v-else>
                                        <Avatar
                                            image="http://127.0.0.1:8000/storage/images/default-prof-pic.png"
                                            style="width: 300px; height: 300px"
                                            shape="circle"
                                        />
                                    </div>
                                </div>
                            </template>
                            <template #title>
                                <div class="flex justify-content-center">
                                    <span class="text-center m-4">
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
            </div>
            <div class="col justify-content-center pt-0">
                <Fieldset class="mb-3" legend="Deactivate Account">
                    <p class="p-4 text-center">
                        Temporarily Deactivate your account
                    </p>
                    <div>
                        <div class="flex justify-content-center mb-4">
                            <Button
                                label="Deactivate"
                                class="p-button-outlined p-button-danger"
                                @click="openDeactivateDialog"
                            ></Button>
                        </div>
                    </div>
                </Fieldset>
            </div>
        </div>
        <div
            class="col-12 sm:col-12 md:col-10 md:col-offset-1 lg:col-4 lg:col-offset-1 xl:col-4 xl:col-offset-1"
        >
            <Fieldset class="mb-3" legend="Local News">
                <NewsComponent />
            </Fieldset>
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
        <Dialog
            v-model:visible="blockDialog"
            :style="{ width: '450px' }"
            :header="`Are you sure you want to block ${name}`"
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
                            ><b>{{ name }} will no longer be able to: </b></span
                        >
                        <ul>
                            <li>Start a conversation with you</li>
                            <li>See things you post on your timeline</li>
                        </ul>
                    </div>
                </div>
            </div>
            <template #footer>
                <Button
                    label="Cancel"
                    class="p-button-text"
                    @click="blockDialog = false"
                />
                <Button
                    label="Block"
                    class="p-button p-button-danger"
                    @click="blockUser"
                />
            </template>
        </Dialog>
        <Dialog
            v-model:visible="unblockDialog"
            :style="{ width: '450px' }"
            :header="`Unblock ${name}`"
            :modal="true"
        >
            <div class="confirmation-content">
                <div class="grid">
                    <div
                        class="col-12 flex align-items-center justify-content-center"
                    >
                        <span
                            >Are you sure you want to unblock {{ name }}?
                        </span>
                    </div>
                </div>
            </div>
            <template #footer>
                <Button
                    label="Cancel"
                    class="p-button-text"
                    @click="unblockDialog = false"
                />
                <Button
                    label="Confirm"
                    class="p-button-primary"
                    @click="unblockUser"
                />
            </template>
        </Dialog>
        <Dialog
            v-model:visible="deactivateDialog"
            :style="{ width: '450px' }"
            :header="`Deactivate Account`"
            :modal="true"
        >
            <div class="confirmation-content">
                <div class="grid">
                    <div
                        class="col-12 flex align-items-center justify-content-center"
                    >
                        <span
                            >Are you sure you want to deactivate your account?
                        </span>
                    </div>
                </div>
            </div>
            <template #footer>
                <Button
                    label="Cancel"
                    class="p-button-text"
                    @click="deactivateDialog = false"
                />
                <Button
                    label="Confirm"
                    class="p-button-danger"
                    @click="deactivateAccount(this.userLogged)"
                />
            </template>
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
        <Toast />
    </div>
</template>

<script>
import { computed } from "vue";
import { useStore } from "vuex";
import NewsComponent from "./NewsComponent.vue";
export default {
    name: "SettingComponent",
    components: {
        NewsComponent,
    },
    setup() {
        const store = useStore();
        return {
            users: computed(() => store.state.users),
            block_users: computed(() => store.state.block_users),
            userLogged: computed(() => store.state.userLogged),
            userVehicles: computed(() => store.state.userVehicles.userVehicles),
            adminVehicles: computed(
                () => store.state.adminVehicles.adminVehicles
            ),
        };
    },
    data() {
        return {
            loading: null,

            id: null,
            name: null,

            selectedUser: null,
            blockDialog: false,
            unblockDialog: false,
            deactivateDialog: false,
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
        async deactivateAccount(data) {
            this.process = true;
            console.log("verify", data);
            await axios({
                method: "put",
                url: "/api/user/" + data.id,
                data: {
                    first_name: data.first_name,
                    last_name: data.last_name,
                    gender: data.gender,
                    block_lot_id:
                        data.block_lot_id != null ? data.block_lot_id : null,
                    email: data.email,
                    verified: data.verified,
                    status: data.status == "active" ? "inactive" : "active",
                    has_voted: data.has_voted,
                    age: data.age,
                    contact_num: data.contact_num,
                    role: data.role,
                    tag_as: data.tag_as,
                },
            })
                .then(() => {
                    this.$toast.add({
                        severity: "success",
                        summary: "Successful",
                        detail:
                            data.status != "active"
                                ? "User Activated"
                                : "User Deactivated",
                        life: 3000,
                    });
                    this.$store.dispatch("getAllUsers");
                    this.process = false;
                    axios({
                        method: "get",
                        url: "/api/logout",
                    })
                        .then((response) => {
                            console.log(response);
                            this.$router.push("/login");
                            this.$store.dispatch("logout", null);
                        })
                        .catch((error) => {
                            console.log(error.response);
                        });
                })
                .catch((err) => {
                    console.log(err.response);
                    this.process = false;
                });
        },
        openDeactivateDialog() {
            this.deactivateDialog = true;
        },
        showUnblockToast() {
            this.$toast.add({
                severity: "success",
                summary: "Success Message",
                detail: "Successfully unblocked a user",
                life: 3000,
            });
        },
        async unblockUser() {
            this.loading = true;
            await axios({
                method: "delete",
                url: "/api/block_user/" + this.id,
            })
                .then((res) => {
                    this.$store.dispatch(
                        "getUsersNotBlocked",
                        this.$store.state.userLogged.id
                    );

                    this.$store.dispatch(
                        "getBlockUsers",
                        this.$store.state.userLogged.id
                    );
                    this.showUnblockToast();
                    this.unblockDialog = false;
                    this.loading = false;
                })
                .catch((error) => {
                    console.log(error.response);
                    this.unblockDialog = false;
                    this.loading = false;
                });
        },
        async openUnblockDialog(data) {
            this.unblockDialog = true;
            this.id = data.id;
            this.name =
                data.block_user.first_name + " " + data.block_user.last_name;
        },
        async openBlockDialog() {
            this.loading = true;
            this.blockDialog = true;
            await axios({
                method: "get",
                url: "/api/user/" + this.selectedUser,
            })
                .then((res) => {
                    console.log("fullname", res.data);
                    this.name = res.data.first_name + " " + res.data.last_name;
                    this.loading = false;
                })
                .catch((error) => {
                    this.loading = false;
                });
        },
        async blockUser() {
            this.loading = true;
            await axios({
                method: "post",
                url: "/api/block_user",
                data: {
                    user_id: this.$store.state.userLogged.id,
                    block_user_id: this.selectedUser,
                },
            })
                .then((res) => {
                    this.$store.dispatch(
                        "getUsersNotBlocked",
                        this.$store.state.userLogged.id
                    );

                    this.$store.dispatch(
                        "getBlockUsers",
                        this.$store.state.userLogged.id
                    );
                    this.showBlockToast();
                    this.selectedUser = null;
                    this.blockDialog = false;
                    this.loading = false;
                })
                .catch((error) => {
                    console.log(error.response);
                    this.blockDialog = false;
                    this.loading = false;
                });
        },

        showBlockToast() {
            this.$toast.add({
                severity: "success",
                summary: "Success Message",
                detail: "Successfully Blocked a user",
                life: 3000,
            });
        },
    },
};
</script>

<style></style>
