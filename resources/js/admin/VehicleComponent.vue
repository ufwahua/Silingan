<template>
    <div>
        <Toast />
        <div class="grid">
            <div class="col-12">
                <h1 class="text-center">Vehicles</h1>
            </div>
        </div>
        <div class="grid mb-2 flex justify-content-center">
            <div class="col-12 lg:col-6 xl:col-3">
                <div class="card mb-0 bg-blue-100">
                    <div class="flex justify-content-between mb-3">
                        <div>
                            <span
                                class="block font-medium text-4xl font-bold mb-3"
                                >{{ total }}</span
                            >
                            <div class="text-900">Total</div>
                        </div>
                        <div
                            class="flex align-items-center justify-content-center"
                            style="width: 2.5rem; height: 2.5rem"
                        ></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="grid">
                <div class="col-12">
                    <DataTable
                        :value="adminVehicles"
                        :filters="filters"
                        breakpoint="1350px"
                        :paginator="true"
                        :rows="10"
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
                                    v-model="
                                        filters['user.lot.block.number'].value
                                    "
                                    :showClear="true"
                                    :options="blocks"
                                    optionLabel="number"
                                    optionValue="number"
                                    placeholder="Filter by block"
                                    class="my-2"
                                    style="width: 200px"
                                    @change="getFilterBlockLot"
                                ></Dropdown>
                                <Dropdown
                                    v-model="filters['user.lot.number'].value"
                                    :showClear="true"
                                    :options="filteredLots"
                                    optionLabel="number"
                                    optionValue="number"
                                    placeholder="Filter by lot"
                                    style="width: 200px"
                                    class="my-2"
                                ></Dropdown>
                                <Dropdown
                                    v-model="filters['user.role'].value"
                                    :showClear="true"
                                    :options="role"
                                    optionLabel="role"
                                    optionValue="role"
                                    placeholder="Filter by role"
                                    style="width: 200px"
                                    class="my-2"
                                ></Dropdown>

                                <Button
                                    label="Add"
                                    icon="pi pi-plus"
                                    class="p-button-primary my-2"
                                    @click="registerVehicle"
                                />
                            </div>
                        </template>
                        <template #empty>
                            No registered vehicles found
                        </template>
                        <template #loading> Loading Users </template>
                        <Column header="Image">
                            <template #body="{ data }">
                                <div v-if="data.image">
                                    <Avatar
                                        :image="`http://127.0.0.1:8000${data.image}`"
                                        style="width: 100px; height: 100px"
                                        shape="circle"
                                    />
                                </div>
                                <div v-else>
                                    <Avatar
                                        image="http://127.0.0.1:8000/storage/images/default-prof-pic.png"
                                        style="width: 100px; height: 100px"
                                        shape="circle"
                                    />
                                </div> </template
                        ></Column>
                        <Column header="Type" field="type"> </Column>
                        <Column header="Make" field="make"> </Column>
                        <Column header="Model" field="model"> </Column>
                        <Column header="Color" field="color"> </Column>
                        <Column header="Owner" field="name">
                            <template #body="{ data }">
                                {{
                                    (data["name"] =
                                        data.user.first_name +
                                        " " +
                                        data.user.last_name)
                                }}
                            </template>
                        </Column>
                        <Column header="Block" field="user.lot.block.number">
                        </Column>
                        <Column header="Lot" field="user.lot.number"> </Column>
                        <Column header="Role" field="user.role"> </Column>

                        <Column header="Actions" field="actions">
                            <template #body="{ data }">
                                <Button
                                    type="button"
                                    icon="pi pi-ellipsis-h"
                                    class="p-button-rounded p-button-info"
                                    @click="toggle(data)"
                                    aria-haspopup="true"
                                    aria-controls="overlay_menu"
                                />
                                <Menu
                                    id="overlay_menu"
                                    ref="menu"
                                    :model="menus"
                                    :popup="true"
                                />
                            </template>
                        </Column>
                    </DataTable>

                    <Dialog
                        v-model:visible="deleteVehicleDialog"
                        :style="{ width: '450px' }"
                        header="Delete Vehicle?"
                        :modal="true"
                    >
                        <div class="confirmation-content">
                            <div class="grid">
                                <div class="col-12 flex justify-content-center">
                                    <div
                                        v-if="image"
                                        class="flex justify-content-center"
                                    >
                                        <Avatar
                                            :image="`http://127.0.0.1:8000${image}`"
                                            style="width: 300px; height: 300px"
                                            shape="circle"
                                        />
                                    </div>
                                    <div
                                        v-else
                                        class="flex justify-content-center"
                                    >
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
                                            <b>Owner: </b>
                                            {{ name }}
                                        </p>

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
                                @click="confirmDeleteVehicle"
                            />
                        </template>
                    </Dialog>
                    <Dialog
                        v-model:visible="updateUserDialog"
                        :style="{ width: '500px' }"
                        header="Update User"
                        :modal="true"
                    >
                        <div class="grid">
                            <div class="col-12 flex justify-content-center">
                                <div
                                    v-if="image"
                                    class="flex justify-content-center"
                                >
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
                            <div class="field col-12 md:col-12">
                                <h6>Full name</h6>

                                <Dropdown
                                    v-model="user_id"
                                    :options="users"
                                    optionLabel="full_name"
                                    optionValue="id"
                                    placeholder="Select user"
                                    :class="{
                                        'p-invalid': error_user,
                                    }"
                                    class="w-full"
                                    :filter="true"
                                    :showClear="true"
                                >
                                    <template #value="slotProps">
                                        <div v-if="slotProps.value.id">
                                            <div>
                                                {{
                                                    (slotProps.option["id"] =
                                                        slotProps.value.id)
                                                }}
                                            </div>
                                        </div>
                                    </template>
                                    <template #option="slotProps">
                                        {{
                                            (slotProps.option["full_name"] =
                                                slotProps.option.first_name +
                                                " " +
                                                slotProps.option.last_name +
                                                " [" +
                                                slotProps.option.role +
                                                "]")
                                        }}
                                    </template>
                                </Dropdown>
                                <small v-if="error_user" class="p-error">{{
                                    error_user
                                }}</small>
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
                                    <small
                                        v-if="error_selected_type"
                                        class="p-error"
                                        >{{ error_selected_type }}</small
                                    >
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-fluid mb-2">
                                    <h6>
                                        Make
                                        <span class="text-blue-500"
                                            ><small
                                                >ex: Honda,Yamaha,etc.</small
                                            ></span
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
                                        :class="{
                                            'p-invalid': error_plate_number,
                                        }"
                                    />
                                    <small
                                        v-if="error_plate_number"
                                        class="p-error"
                                        >{{ error_plate_number }}</small
                                    >
                                </div>
                            </div>
                        </div>
                        <template #footer>
                            <Button
                                label="Cancel"
                                class="p-button-text p-button-danger"
                                @click="updateUserDialog = false"
                            />
                            <Button
                                label="Update"
                                class="p-button-primary"
                                @click="confirmUpdateVehicle"
                            />
                        </template>
                    </Dialog>

                    <Dialog
                        v-model:visible="addVehicleDialog"
                        :style="{ width: '500px' }"
                        header="Register Vehicle"
                        :modal="true"
                    >
                        <div class="grid">
                            <div class="col-12 flex justify-content-center">
                                <div
                                    v-if="image"
                                    class="flex justify-content-center"
                                >
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
                            <div class="field col-12 md:col-12">
                                <h6>Full name</h6>

                                <Dropdown
                                    v-model="user_id"
                                    :options="users"
                                    optionLabel="full_name"
                                    optionValue="id"
                                    placeholder="Select user"
                                    :class="{
                                        'p-invalid': error_user,
                                    }"
                                    class="w-full"
                                    :filter="true"
                                    :showClear="true"
                                >
                                    <template #option="slotProps">
                                        {{
                                            (slotProps.option["full_name"] =
                                                slotProps.option.first_name +
                                                " " +
                                                slotProps.option.last_name +
                                                " [" +
                                                slotProps.option.role +
                                                "]")
                                        }}
                                    </template>
                                </Dropdown>
                                <small v-if="error_user" class="p-error">{{
                                    error_user
                                }}</small>
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
                                    <small
                                        v-if="error_selected_type"
                                        class="p-error"
                                        >{{ error_selected_type }}</small
                                    >
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-fluid mb-2">
                                    <h6>
                                        Make
                                        <span class="text-blue-500"
                                            ><small
                                                >ex: Honda,Yamaha,etc.</small
                                            ></span
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
                                        :class="{
                                            'p-invalid': error_plate_number,
                                        }"
                                    />
                                    <small
                                        v-if="error_plate_number"
                                        class="p-error"
                                        >{{ error_plate_number }}</small
                                    >
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
                                label="Register"
                                class="p-button-primary"
                                @click="addVehicle"
                            />
                        </template>
                    </Dialog>
                    <Dialog
                        v-model:visible="viewVehicleDialog"
                        :style="{ width: '500px' }"
                        header="View Vehicle"
                        :modal="true"
                    >
                        <div class="grid">
                            <div class="col-12 flex justify-content-center">
                                <div
                                    v-if="image"
                                    class="flex justify-content-center"
                                >
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

                            <div class="field col-12 md:col-12">
                                <h6>Full name</h6>

                                <Dropdown
                                    v-model="user_id"
                                    :options="users"
                                    optionLabel="full_name"
                                    optionValue="id"
                                    placeholder="Select user"
                                    :class="{
                                        'p-invalid': error_user,
                                    }"
                                    class="w-full"
                                    :filter="true"
                                    :showClear="true"
                                    disabled
                                >
                                    <template #value="slotProps">
                                        <div v-if="slotProps.value.id">
                                            <div>
                                                {{
                                                    (slotProps.option["id"] =
                                                        slotProps.value.id)
                                                }}
                                            </div>
                                        </div>
                                    </template>
                                    <template #option="slotProps">
                                        {{
                                            (slotProps.option["full_name"] =
                                                slotProps.option.first_name +
                                                " " +
                                                slotProps.option.last_name +
                                                " [" +
                                                slotProps.option.role +
                                                "]")
                                        }}
                                    </template>
                                </Dropdown>
                                <small v-if="error_user" class="p-error">{{
                                    error_user
                                }}</small>
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
                                        disabled
                                    />
                                    <small
                                        v-if="error_selected_type"
                                        class="p-error"
                                        >{{ error_selected_type }}</small
                                    >
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-fluid mb-2">
                                    <h6>Make</h6>

                                    <InputText
                                        v-model="make"
                                        :class="{ 'p-invalid': error_make }"
                                        disabled
                                    />
                                    <small v-if="error_make" class="p-error">{{
                                        error_make
                                    }}</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-fluid mb-2">
                                    <h6>Model</h6>
                                    <InputText
                                        v-model="model"
                                        :class="{ 'p-invalid': error_model }"
                                        disabled
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
                                        disabled
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
                                        :class="{
                                            'p-invalid': error_plate_number,
                                        }"
                                        disabled
                                    />
                                    <small
                                        v-if="error_plate_number"
                                        class="p-error"
                                        >{{ error_plate_number }}</small
                                    >
                                </div>
                            </div>
                        </div>
                    </Dialog>

                    <Dialog
                        v-model:visible="process"
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
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import { FilterMatchMode } from "primevue/api";
import { computed } from "vue";
import { useStore } from "vuex";
export default {
    name: "VehicleComponent",
    setup() {
        const store = useStore();
        return {
            users: computed(() => store.state.users),
            blocks: computed(() => store.state.blocks.blocks),
            filteredLots: computed(() => store.state.lots.filteredLots),
            lots: computed(() => store.state.lots.lots),

            total: computed(() => {
                return store.state.adminVehicles.adminVehicles.length;
            }),
            adminVehicles: computed(
                () => store.state.adminVehicles.adminVehicles
            ),
        };
    },
    data() {
        return {
            menus: null,

            filters: {},
            id: null,

            process: false,
            addVehicleDialog: false,
            deleteVehicleDialog: false,
            updateUserDialog: false,
            viewVehicleDialog: false,

            //vehicle dialog
            user_id: null,
            name: null,
            image: null,
            selected_type: null,
            make: null,
            model: null,
            color: null,
            plate_number: null,
            type: [{ type: "Car" }, { type: "Motorcycle" }],

            erro_user: null,
            error_selected_type: null,
            error_make: null,
            error_model: null,
            error_color: null,
            error_plate_number: null,
            role: [
                { role: "admin" },
                { role: "resident" },
                { role: "officer" },
                { role: "security officer" },
            ],
        };
    },
    methods: {
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
        async addVehicle() {
            this.loading = true;
            await axios({
                method: "post",
                url: "/api/vehicle/",
                data: {
                    user_id: this.user_id,
                    image: this.image,
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
                    this.$store.dispatch("adminVehicles/getAll");
                    this.loading = false;
                })
                .catch((err) => {
                    this.resetErrors();
                    this.validate(err);
                    this.loading = false;
                });
        },
        viewVehicle() {
            if (this.users) {
                this.viewVehicleDialog = true;
            }
        },
        toggle(data) {
            this.$refs.menu.toggle(event);
            this.populateFields(data);
            this.menus = [
                {
                    label: "View Vehicle",
                    icon: "pi pi-user",
                    command: () => {
                        this.viewVehicle();
                    },
                },
                {
                    label: "Update Vehicle",
                    icon: "pi pi-pencil",
                    command: () => {
                        this.updateVehicle();
                    },
                },
                {
                    label: "Delete Vehicle",
                    icon: "pi pi-lock",
                    command: () => {
                        this.deleteVehicle();
                    },
                },
            ];
        },
        populateFields(data) {
            this.resetFields();
            this.resetErrors();
            this.user_id = data.user.id;
            this.name = data.user.first_name + " " + data.user.last_name;
            this.image = data.image;
            this.selected_type = data.type;
            this.make = data.make;
            this.model = data.model;
            this.color = data.color;
            this.plate_number = data.plate_number;
        },
        clearFilter() {
            this.filters["user.lot.block.number"].value = null;
            this.filters["user.lot.number"].value = null;
            this.filters["user.role"].value = null;
        },
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

                "user.lot.block.number": {
                    value: null,
                    matchMode: FilterMatchMode.EQUALS,
                },
                "user.lot.number": {
                    value: null,
                    matchMode: FilterMatchMode.EQUALS,
                },
                "user.role": {
                    value: null,
                    matchMode: FilterMatchMode.EQUALS,
                },
            };
        },
        badgecolor(color) {
            if (color == "active") {
                return "bg-green-500";
            } else if (color == 1) {
                return "bg-orange-500";
            } else if (color == 0) {
                return "bg-gray-500";
            } else {
                return "bg-pink-500";
            }
        },
        deleteVehicle() {
            this.deleteVehicleDialog = true;
        },
        async confirmDeleteVehicle() {
            try {
                this.deleteVehicleDialog = false;
                this.process = true;
                await axios({
                    method: "delete",
                    url: "/api/vehicle/" + this.id,
                });
                this.$store.dispatch("adminVehicles/getAll");
                this.process = false;
                this.$toast.add({
                    severity: "success",
                    summary: "Successful Request",
                    detail: "Deleted Vehicle",
                    life: 3000,
                });
            } catch (err) {
                this.process = false;
                console.log(err.response);
            }
        },
        updateVehicle() {
            if (this.users) {
                this.updateUserDialog = true;
            }
        },
        async confirmUpdateVehicle() {
            this.process = true;
            await axios({
                method: "put",
                url: "/api/user/" + this.id,
                data: {
                    user_id: this.user_id,
                    image: this.image,
                    type: this.selected_type,
                    make: this.make,
                    model: this.model,
                    color: this.color,
                    plate_number: this.plate_number,
                },
            })
                .then(() => {
                    this.updateUserDialog = false;
                    this.$toast.add({
                        severity: "success",
                        summary: "Successful Request",
                        detail: "Updated User",
                        life: 3000,
                    });
                    this.$store.dispatch("adminVehicles/getAll");
                    this.process = false;
                })
                .catch((err) => {
                    console.log(err.response);
                    this.resetErrors();
                    this.validate(err);
                    this.process = false;
                });
        },

        //REGISTER Vehicle
        registerVehicle() {
            this.resetFields();
            this.resetErrors();
            this.addVehicleDialog = true;
            this.form.email = null;
        },

        resetFields() {
            this.id = null;
            this.user_id = null;
            this.image = null;
            this.selected_type = null;
            this.make = null;
            this.model = null;
            this.color = null;
            this.plate_number = null;
        },
        resetErrors() {
            this.error_user = null;
            this.error_selected_type = null;
            this.error_make = null;
            this.error_model = null;
            this.error_color = null;
            this.error_plate_number = null;
        },
        validate(error) {
            if (!this.user_id)
                this.error_user = "The full name field is required";
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
    },

    created() {
        this.initFilters();
    },
};
</script>

<style></style>
