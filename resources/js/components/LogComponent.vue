<template>
    <div>
        <Toast />
        <div class="mb-4">
            <h5>Log Masterlist</h5>
            <TabView class="tabview-custom" ref="tabview4">
                <TabPanel>
                    <template #header>
                        <i class="pi pi-user mr-2"></i>
                        <span>Visitor</span>
                    </template>

                    <div class="grid">
                        <div class="col-12">
                            <DataTable
                                :value="visitor_logs"
                                :filters="filters_masterlist"
                                breakpoint="1230px"
                                :rows="15"
                            >
                                <template #empty> No Visitors found </template>
                                <template #loading> Loading Visitors </template>
                                <template #header>
                                    <div
                                        class="flex flex-wrap justify-content-between"
                                    >
                                        <div class="my-2">
                                            <span
                                                class="p-input-icon-left inline-block"
                                            >
                                                <i class="pi pi-search" />
                                                <InputText
                                                    v-model="
                                                        filters_masterlist[
                                                            'global'
                                                        ].value
                                                    "
                                                    placeholder="Keyword Search"
                                                />
                                            </span>
                                        </div>
                                        <div class="my-2">
                                            <Dropdown
                                                v-model="
                                                    filters_masterlist[
                                                        'lot.block.number'
                                                    ].value
                                                "
                                                style="width: 150px"
                                                :showClear="true"
                                                :options="blocks"
                                                optionLabel="number"
                                                optionValue="number"
                                                placeholder="Filter block"
                                                @change="
                                                    getFilterBlockLotMaster
                                                "
                                            ></Dropdown>
                                        </div>
                                        <div class="my-2">
                                            <Dropdown
                                                v-model="
                                                    filters_masterlist[
                                                        'lot.number'
                                                    ].value
                                                "
                                                style="width: 150px"
                                                :showClear="true"
                                                :options="filteredLots"
                                                optionLabel="number"
                                                optionValue="number"
                                                placeholder="Filter lot"
                                            ></Dropdown>
                                        </div>
                                        <div class="my-2">
                                            <Calendar
                                                v-model="from_masterlist"
                                                placeholder="From"
                                                dateFormat="yy-mm-dd"
                                                @date-select="
                                                    changeFromToDate(
                                                        'log_master'
                                                    )
                                                "
                                            />
                                        </div>
                                        <div class="my-2">
                                            <Calendar
                                                v-model="to_masterlist"
                                                placeholder="To"
                                                dateFormat="yy-mm-dd"
                                                @date-select="
                                                    changeFromToDate(
                                                        'log_master'
                                                    )
                                                "
                                                :disabled="
                                                    from_masterlist
                                                        ? false
                                                        : true
                                                "
                                            />
                                        </div>
                                        <div class="my-2">
                                            <Button
                                                icon="pi pi-filter-slash"
                                                class="p-button-outlined p-button-secondary"
                                                @click="clearFilterMaster"
                                                v-tooltip="'Clear Filters'"
                                            />
                                        </div>
                                    </div>
                                </template>
                                <Column header="Visitor Name" field="name">
                                </Column>
                                <Column header="Login by" field="login_by">
                                    <template #body="{ data }">
                                        {{
                                            (data["login_by"] =
                                                data.user_login.first_name +
                                                " " +
                                                data.user_login.last_name)
                                        }}
                                    </template>
                                </Column>
                                <Column header="Logout by" field="logout_by">
                                    <template #body="{ data }">
                                        {{
                                            (data["logout_by"] =
                                                data.user_logout.first_name +
                                                " " +
                                                data.user_logout.last_name)
                                        }}
                                    </template>
                                </Column>
                                <Column
                                    header="Purpose of Visit"
                                    field="purpose_visit"
                                >
                                </Column>
                                <Column header="Block" field="lot.block.number">
                                </Column>
                                <Column header="Lot" field="lot.number">
                                </Column>
                                <Column header="Login" field="created_at">
                                    <template #body="{ data }">
                                        {{ dateFormat(data.created_at) }}
                                    </template>
                                </Column>
                                <Column header="Logout" field="updated_at">
                                    <template #body="{ data }">
                                        {{ dateFormat(data.updated_at) }}
                                    </template>
                                </Column>
                            </DataTable>
                        </div>
                    </div>
                </TabPanel>
                <TabPanel>
                    <template #header>
                        <i class="pi pi-car mr-2"></i>
                        <span>Vehicles</span>
                    </template>

                    <div class="grid">
                        <div class="col-12">
                            <DataTable
                                :value="vehicle_logs"
                                :filters="filters_masterlist"
                                breakpoint="1230px"
                                :rows="15"
                            >
                                <template #empty> No Vehicles found </template>
                                <template #loading> Loading Visitors </template>
                                <template #header>
                                    <div
                                        class="flex flex-wrap justify-content-between"
                                    >
                                        <div class="my-2">
                                            <span
                                                class="p-input-icon-left inline-block"
                                            >
                                                <i class="pi pi-search" />
                                                <InputText
                                                    v-model="
                                                        filters_masterlist[
                                                            'global'
                                                        ].value
                                                    "
                                                    placeholder="Keyword Search"
                                                />
                                            </span>
                                        </div>
                                        <div class="my-2">
                                            <Dropdown
                                                v-model="
                                                    filters_masterlist[
                                                        'vehicle_label'
                                                    ].value
                                                "
                                                style="width: 150px"
                                                :showClear="true"
                                                :options="vehicle_types"
                                                optionLabel="type"
                                                optionValue="type"
                                                placeholder="Filter type"
                                            ></Dropdown>
                                        </div>
                                        <div class="my-2">
                                            <Dropdown
                                                v-model="
                                                    filters_masterlist[
                                                        'vehicle_type'
                                                    ].value
                                                "
                                                style="width: 150px"
                                                :showClear="true"
                                                :options="vehicle_tags"
                                                optionLabel="tag"
                                                optionValue="tag"
                                                placeholder="Filter tag"
                                            ></Dropdown>
                                        </div>
                                        <div class="my-2">
                                            <Dropdown
                                                v-model="
                                                    filters_masterlist[
                                                        'lot.block.number'
                                                    ].value
                                                "
                                                style="width: 150px"
                                                :showClear="true"
                                                :options="blocks"
                                                optionLabel="number"
                                                optionValue="number"
                                                placeholder="Filter block"
                                                @change="
                                                    getFilterBlockLotMaster
                                                "
                                            ></Dropdown>
                                        </div>
                                        <div class="my-2">
                                            <Dropdown
                                                v-model="
                                                    filters_masterlist[
                                                        'lot.number'
                                                    ].value
                                                "
                                                style="width: 150px"
                                                :showClear="true"
                                                :options="filteredLots"
                                                optionLabel="number"
                                                optionValue="number"
                                                placeholder="Filter lot"
                                            ></Dropdown>
                                        </div>
                                        <div class="my-2">
                                            <Calendar
                                                v-model="from_masterlist"
                                                placeholder="From"
                                                dateFormat="yy-mm-dd"
                                                @date-select="
                                                    changeFromToDate(
                                                        'log_master'
                                                    )
                                                "
                                            />
                                        </div>
                                        <div class="my-2">
                                            <Calendar
                                                v-model="to_masterlist"
                                                placeholder="To"
                                                dateFormat="yy-mm-dd"
                                                @date-select="
                                                    changeFromToDate(
                                                        'log_master'
                                                    )
                                                "
                                                :disabled="
                                                    from_masterlist
                                                        ? false
                                                        : true
                                                "
                                            />
                                        </div>
                                        <div class="my-2">
                                            <Button
                                                icon="pi pi-filter-slash"
                                                class="p-button-outlined p-button-secondary"
                                                @click="clearFilterMaster"
                                                v-tooltip="'Clear Filters'"
                                            />
                                        </div>
                                    </div> </template
                                ><Column
                                    header="Vehicle Type"
                                    field="vehicle_label"
                                ></Column>
                                <Column
                                    header="Vehicle Tag"
                                    field="vehicle_type"
                                ></Column>
                                <Column
                                    header="Plate Number"
                                    field="plate_number"
                                >
                                </Column>
                                <Column header="Login by" field="login_by">
                                    <template #body="{ data }">
                                        {{
                                            (data["login_by"] =
                                                data.user_login.first_name +
                                                " " +
                                                data.user_login.last_name)
                                        }}
                                    </template>
                                </Column>
                                <Column header="Logout by" field="logout_by">
                                    <template #body="{ data }">
                                        {{
                                            (data["logout_by"] =
                                                data.user_logout.first_name +
                                                " " +
                                                data.user_logout.last_name)
                                        }}
                                    </template>
                                </Column>
                                <Column
                                    header="Purpose of Visit"
                                    field="purpose_visit"
                                >
                                </Column>
                                <Column header="Block" field="lot.block.number">
                                </Column>
                                <Column header="Lot" field="lot.number">
                                </Column>
                                <Column header="Card" field="card.number">
                                </Column>
                                <Column header="Login" field="created_at">
                                    <template #body="{ data }">
                                        {{ dateFormat(data.created_at) }}
                                    </template>
                                </Column>
                                <Column header="Logout" field="created_at">
                                    <template #body="{ data }">
                                        {{ dateFormat(data.created_at) }}
                                    </template>
                                </Column>
                            </DataTable>
                        </div>
                    </div>
                </TabPanel>
            </TabView>
        </div>
        <div class="card">
            <h5>Log</h5>
            <TabView class="tabview-custom" ref="tabview4">
                <TabPanel>
                    <template #header>
                        <i class="pi pi-user mr-2"></i>
                        <span>Visitor</span>
                    </template>

                    <div class="grid">
                        <div class="col-12">
                            <DataTable
                                :value="visitors"
                                :filters="filters"
                                breakpoint="1230px"
                                :rows="15"
                            >
                                <template #empty> No Visitors found </template>
                                <template #loading> Loading Visitors </template>
                                <template #header>
                                    <div
                                        class="flex flex-wrap align-content-center justify-content-between"
                                    >
                                        <div class="my-2">
                                            <span
                                                class="p-input-icon-left inline-block"
                                            >
                                                <i class="pi pi-search" />
                                                <InputText
                                                    v-model="
                                                        filters['global'].value
                                                    "
                                                    placeholder="Keyword Search"
                                                />
                                            </span>
                                        </div>
                                        <div class="my-2">
                                            <Dropdown
                                                v-model="
                                                    filters['lot.block.number']
                                                        .value
                                                "
                                                style="width: 150px"
                                                :showClear="true"
                                                :options="blocks"
                                                optionLabel="number"
                                                optionValue="number"
                                                placeholder="Filter block"
                                                @change="getFilterBlockLot"
                                            ></Dropdown>
                                        </div>
                                        <div class="my-2">
                                            <Dropdown
                                                v-model="
                                                    filters['lot.number'].value
                                                "
                                                style="width: 150px"
                                                :showClear="true"
                                                :options="filteredLots"
                                                optionLabel="number"
                                                optionValue="number"
                                                placeholder="Filter lot"
                                            ></Dropdown>
                                        </div>
                                        <div class="my-2">
                                            <Calendar
                                                v-model="from"
                                                placeholder="From"
                                                dateFormat="yy-mm-dd"
                                                @date-select="
                                                    changeFromToDate('log')
                                                "
                                            />
                                        </div>
                                        <div class="my-2">
                                            <Calendar
                                                v-model="to"
                                                placeholder="To"
                                                dateFormat="yy-mm-dd"
                                                @date-select="
                                                    changeFromToDate('log')
                                                "
                                                :disabled="from ? false : true"
                                            />
                                        </div>
                                        <div class="my-2">
                                            <Button
                                                icon="pi pi-filter-slash"
                                                class="p-button-outlined p-button-secondary"
                                                @click="clearFilter"
                                                v-tooltip="'Clear Filters'"
                                            />
                                        </div>
                                        <div class="my-2">
                                            <Button
                                                label="Log in"
                                                icon="pi pi-user-plus"
                                                class="p-button-success p-mr-2"
                                                @click="
                                                    openLogDialog('visitor')
                                                "
                                            />
                                        </div>
                                    </div>
                                </template>
                                <Column header="Visitor Name" field="name">
                                </Column>
                                <Column header="Login by" field="login_by">
                                    <template #body="{ data }">
                                        {{
                                            (data["login_by"] =
                                                data.user_login.first_name +
                                                " " +
                                                data.user_login.last_name)
                                        }}
                                    </template>
                                </Column>
                                <Column
                                    header="Purpose of Visit"
                                    field="purpose_visit"
                                >
                                </Column>
                                <Column header="Block" field="lot.block.number">
                                </Column>
                                <Column header="Lot" field="lot.number">
                                </Column>
                                <Column header="Card" field="card.number">
                                </Column>
                                <Column header="Login" field="created_at">
                                    <template #body="{ data }">
                                        {{ dateFormat(data.created_at) }}
                                    </template>
                                </Column>

                                <Column header="Actions" field="actions">
                                    <template #body="{ data }">
                                        <Button
                                            icon="pi pi-pencil"
                                            class="p-button-rounded p-button-primary mr-2"
                                            v-tooltip="'Edit Log'"
                                            @click="updateLog(data)"
                                        />
                                        <Button
                                            icon="pi pi-user-minus"
                                            class="p-button-rounded p-button-danger"
                                            v-tooltip="'Logout'"
                                            @click="logout(data)"
                                        />
                                    </template>
                                </Column>
                            </DataTable>
                        </div>
                    </div>
                </TabPanel>
                <TabPanel>
                    <template #header>
                        <i class="pi pi-car mr-2"></i>
                        <span>Vehicles</span>
                    </template>

                    <div class="grid">
                        <div class="col-12">
                            <DataTable
                                :value="vehicles"
                                :filters="filters"
                                breakpoint="1230px"
                                :rows="15"
                            >
                                <template #empty> No Vehicles found </template>
                                <template #loading> Loading Visitors </template>
                                <template #header>
                                    <div
                                        class="flex flex-wrap align-content-center justify-content-between"
                                    >
                                        <div class="my-2">
                                            <span
                                                class="p-input-icon-left inline-block"
                                            >
                                                <i class="pi pi-search" />
                                                <InputText
                                                    v-model="
                                                        filters['global'].value
                                                    "
                                                    placeholder="Keyword Search"
                                                />
                                            </span>
                                        </div>
                                        <div class="my-2">
                                            <Dropdown
                                                v-model="
                                                    filters['vehicle_label']
                                                        .value
                                                "
                                                style="width: 150px"
                                                :showClear="true"
                                                :options="vehicle_types"
                                                optionLabel="type"
                                                optionValue="type"
                                                placeholder="Filter type"
                                            ></Dropdown>
                                        </div>
                                        <div class="my-2">
                                            <Dropdown
                                                v-model="
                                                    filters['vehicle_type']
                                                        .value
                                                "
                                                style="width: 150px"
                                                :showClear="true"
                                                :options="vehicle_tags"
                                                optionLabel="tag"
                                                optionValue="tag"
                                                placeholder="Filter tag"
                                            ></Dropdown>
                                        </div>
                                        <div class="my-2">
                                            <Dropdown
                                                v-model="
                                                    filters['lot.block.number']
                                                        .value
                                                "
                                                style="width: 150px"
                                                :showClear="true"
                                                :options="blocks"
                                                optionLabel="number"
                                                optionValue="number"
                                                placeholder="Filter block"
                                                @change="getFilterBlockLot"
                                            ></Dropdown>
                                        </div>

                                        <div class="my-2">
                                            <Dropdown
                                                v-model="
                                                    filters['lot.number'].value
                                                "
                                                style="width: 150px"
                                                :showClear="true"
                                                :options="filteredLots"
                                                optionLabel="number"
                                                optionValue="number"
                                                placeholder="Filter lot"
                                            ></Dropdown>
                                        </div>
                                        <div class="my-2">
                                            <Calendar
                                                v-model="from"
                                                placeholder="From"
                                                dateFormat="yy-mm-dd"
                                                @date-select="
                                                    changeFromToDate('log')
                                                "
                                            />
                                        </div>
                                        <div class="my-2">
                                            <Calendar
                                                v-model="to"
                                                placeholder="To"
                                                dateFormat="yy-mm-dd"
                                                @date-select="
                                                    changeFromToDate('log')
                                                "
                                                :disabled="from ? false : true"
                                            />
                                        </div>
                                        <div class="my-2">
                                            <Button
                                                icon="pi pi-filter-slash"
                                                class="p-button-outlined p-button-secondary"
                                                @click="clearFilter"
                                                v-tooltip="'Clear Filters'"
                                            />
                                        </div>
                                        <div class="my-2">
                                            <Button
                                                label="Log in"
                                                icon="pi pi-user-plus"
                                                class="p-button-success p-mr-2"
                                                @click="
                                                    openLogDialog('vehicle')
                                                "
                                            />
                                        </div>
                                    </div>
                                </template>
                                <Column
                                    header="Vehicle Type"
                                    field="vehicle_label"
                                >
                                </Column>
                                <Column
                                    header="Vehicle Tag"
                                    field="vehicle_type"
                                >
                                </Column>
                                <Column
                                    header="Plate Number"
                                    field="plate_number"
                                >
                                </Column>
                                <Column header="Login by" field="login_by">
                                    <template #body="{ data }">
                                        {{
                                            (data["login_by"] =
                                                data.user_login.first_name +
                                                " " +
                                                data.user_login.last_name)
                                        }}
                                    </template>
                                </Column>
                                <Column
                                    header="Purpose of Visit"
                                    field="purpose_visit"
                                >
                                </Column>
                                <Column header="Block" field="lot.block.number">
                                </Column>
                                <Column header="Lot" field="lot.number">
                                </Column>
                                <Column header="Card" field="card.number">
                                </Column>
                                <Column header="Login" field="created_at">
                                    <template #body="{ data }">
                                        {{ dateFormat(data.created_at) }}
                                    </template>
                                </Column>

                                <Column header="Actions" field="actions">
                                    <template #body="{ data }">
                                        <Button
                                            icon="pi pi-pencil"
                                            class="p-button-rounded p-button-primary mr-2"
                                            v-tooltip="'Edit Log'"
                                            @click="updateLog(data)"
                                        />
                                        <Button
                                            icon="pi pi-user-minus"
                                            class="p-button-rounded p-button-danger"
                                            v-tooltip="'Logout'"
                                            @click="logout(data)"
                                        />
                                    </template>
                                </Column>
                            </DataTable>
                        </div>
                    </div>
                </TabPanel>
            </TabView>
        </div>
        <Dialog
            v-model:visible="logOutDialog"
            :style="{ width: '450px' }"
            header="Logout"
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
                            >Logout
                            <b>{{
                                name === null
                                    ? "Plate number: " + plate_number
                                    : name
                            }}</b
                            >?</span
                        >
                    </div>
                </div>
            </div>
            <template #footer>
                <Button
                    label="Cancel"
                    class="p-button-text"
                    @click="logOutDialog = false"
                />
                <Button
                    label="Logout"
                    class="p-button p-button-danger"
                    @click="logOut"
                />
            </template>
        </Dialog>
        <Dialog
            v-model:visible="logUpdate"
            :style="{ width: '500px' }"
            header="Update Log"
            :modal="true"
        >
            <div class="grid">
                <div class="col-12">
                    <div v-if="log_type === 'visitor'" class="field">
                        <div class="grid formgrid">
                            <div class="col-12">
                                <div class="field">
                                    <label>Name</label>
                                    <InputText
                                        v-model="name"
                                        :class="{
                                            'p-invalid': error_name,
                                        }"
                                        class="w-full"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_name"
                                        >{{ error_name }}</label
                                    >
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="field">
                                    <label>Purpose of Visit</label>
                                    <Textarea
                                        v-model="purpose_visit"
                                        :class="{
                                            'p-invalid': error_purpose_visit,
                                        }"
                                        class="w-full"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_purpose_visit"
                                        >{{ error_purpose_visit }}</label
                                    >
                                </div>
                            </div>

                            <div class="col-12 md:col-6">
                                <div class="field">
                                    <label>Block</label>
                                    <Dropdown
                                        v-model="selected_block"
                                        :class="{
                                            'p-invalid': error_selected_block,
                                        }"
                                        class="w-full"
                                        :options="blocks"
                                        optionLabel="number"
                                        optionValue="number"
                                        placeholder="Destination Block"
                                        @change="getBlockLot"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_selected_block"
                                        >{{ error_selected_block }}</label
                                    >
                                </div>
                            </div>

                            <div class="col-12 md:col-6">
                                <div class="field">
                                    <label>Lot</label>
                                    <Dropdown
                                        v-model="selected_block_lot"
                                        :class="{
                                            'p-invalid': error_selected_lot,
                                        }"
                                        class="w-full"
                                        :options="filteredLots"
                                        optionLabel="number"
                                        optionValue="id"
                                        placeholder="Destination Lot"
                                        @change="getResidents"
                                        :disabled="
                                            selected_block ? false : true
                                        "
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_selected_lot"
                                        >{{ error_selected_lot }}</label
                                    >
                                </div>
                            </div>
                            <div v-if="selected_block_lot" class="col-12 mb-3">
                                <div v-if="filtered_resident_block_lot[0]">
                                    <DataTable
                                        :value="filtered_resident_block_lot"
                                        class="w-full"
                                    >
                                        <template #header>
                                            <h6 class="text-center mb-0">
                                                House Residents
                                            </h6>
                                        </template>
                                        <Column
                                            header="Full name"
                                            field="full_name"
                                        >
                                            <template #body="{ data }">
                                                {{
                                                    (data["full_name"] =
                                                        data.first_name +
                                                        " " +
                                                        data.last_name)
                                                }}
                                            </template>
                                        </Column>
                                        <Column
                                            field="role"
                                            header="Role"
                                        ></Column>
                                        <Column
                                            field="tag_as"
                                            header="Tag"
                                        ></Column>
                                    </DataTable>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="field">
                                    <label>Card Number</label>
                                    <InputText
                                        v-model="selected_card"
                                        class="w-full"
                                        disabled
                                    />

                                    <label
                                        style="color: red"
                                        v-if="error_card"
                                        >{{ error_card }}</label
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else class="field">
                        <div class="grid formgrid">
                            <div class="col-6">
                                <div class="field">
                                    <label>Vehicle Type</label>
                                    <Dropdown
                                        v-model="vehicle_label"
                                        :class="{
                                            'p-invalid': error_vehicle_type,
                                        }"
                                        class="w-full"
                                        :options="vehicle_types"
                                        optionLabel="type"
                                        optionValue="type"
                                        placeholder="Select vehicle type"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_vehicle_type"
                                        >{{ error_vehicle_type }}</label
                                    >
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="field">
                                    <label>Vehicle Tag</label>
                                    <Dropdown
                                        v-model="vehicle_type"
                                        :class="{
                                            'p-invalid': error_vehicle_tag,
                                        }"
                                        class="w-full"
                                        :options="vehicle_tags"
                                        optionLabel="tag"
                                        optionValue="tag"
                                        placeholder="Select vehicle tag"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_vehicle_tag"
                                        >{{ error_vehicle_tag }}</label
                                    >
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="field">
                                    <label>Plate Number</label>
                                    <InputText
                                        v-model="plate_number"
                                        :class="{
                                            'p-invalid': error_plate_number,
                                        }"
                                        class="w-full"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_plate_number"
                                        >{{ error_plate_number }}</label
                                    >
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="field">
                                    <label>Purpose of Visit</label>
                                    <Textarea
                                        v-model="purpose_visit"
                                        :autoResize="true"
                                        :class="{
                                            'p-invalid': error_purpose_visit,
                                        }"
                                        class="w-full"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_purpose_visit"
                                        >{{ error_purpose_visit }}</label
                                    >
                                </div>
                            </div>

                            <div class="col-12 md:col-6">
                                <div class="field">
                                    <label>Block</label>
                                    <Dropdown
                                        v-model="selected_block"
                                        :class="{
                                            'p-invalid': error_selected_block,
                                        }"
                                        class="w-full"
                                        :options="blocks"
                                        optionLabel="number"
                                        optionValue="number"
                                        placeholder="Destination Block"
                                        @change="getBlockLot"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_selected_block"
                                        >{{ error_selected_block }}</label
                                    >
                                </div>
                            </div>

                            <div class="col-12 md:col-6">
                                <div class="field">
                                    <label>Lot</label>
                                    <Dropdown
                                        v-model="selected_block_lot"
                                        :class="{
                                            'p-invalid': error_selected_lot,
                                        }"
                                        class="w-full"
                                        :options="filteredLots"
                                        optionLabel="number"
                                        optionValue="id"
                                        placeholder="Destination Lot"
                                        @change="getResidents"
                                        :disabled="
                                            selected_block ? false : true
                                        "
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_selected_lot"
                                        >{{ error_selected_lot }}</label
                                    >
                                </div>
                            </div>
                            <div v-if="selected_block_lot" class="col-12 mb-3">
                                <div v-if="filtered_resident_block_lot[0]">
                                    <DataTable
                                        :value="filtered_resident_block_lot"
                                        class="w-full"
                                    >
                                        <template #header>
                                            <h6 class="text-center mb-0">
                                                House Residents
                                            </h6>
                                        </template>
                                        <Column
                                            header="Full name"
                                            field="full_name"
                                        >
                                            <template #body="{ data }">
                                                {{
                                                    (data["full_name"] =
                                                        data.first_name +
                                                        " " +
                                                        data.last_name)
                                                }}
                                            </template>
                                        </Column>
                                        <Column
                                            field="role"
                                            header="Role"
                                        ></Column>
                                        <Column
                                            field="tag_as"
                                            header="Tag"
                                        ></Column>
                                    </DataTable>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="field">
                                    <label>Card Number</label>
                                    <InputText
                                        v-model="selected_card"
                                        class="w-full"
                                        disabled
                                    />

                                    <label
                                        style="color: red"
                                        v-if="error_card"
                                        >{{ error_card }}</label
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <template #footer>
                <Button
                    label="Cancel"
                    icon="pi pi-times"
                    class="p-button-text"
                    @click="logUpdate = false"
                />
                <Button
                    label="Update"
                    icon="pi pi-check"
                    class="p-button-text p-button-warning"
                    @click="confirmUpdate"
                />
            </template>
        </Dialog>
        <Dialog
            v-model:visible="logVisitorDialog"
            :style="{ width: '500px' }"
            header="Log In"
            :modal="true"
        >
            <div v-if="log_type == 'visitor'">
                <div class="grid formgrid">
                    <div class="col-12">
                        <div class="field">
                            <label>Name</label>
                            <InputText
                                v-model="name"
                                :class="{
                                    'p-invalid': error_name,
                                }"
                                class="w-full"
                            />
                            <label style="color: red" v-if="error_name">{{
                                error_name
                            }}</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="field">
                            <label>Purpose of Visit</label>
                            <Textarea
                                v-model="purpose_visit"
                                :class="{
                                    'p-invalid': error_purpose_visit,
                                }"
                                class="w-full"
                            />
                            <label
                                style="color: red"
                                v-if="error_purpose_visit"
                                >{{ error_purpose_visit }}</label
                            >
                        </div>
                    </div>

                    <div class="col-12 md:col-6">
                        <div class="field">
                            <label>Block</label>
                            <Dropdown
                                v-model="selected_block"
                                :class="{
                                    'p-invalid': error_selected_block,
                                }"
                                class="w-full"
                                :options="blocks"
                                optionLabel="number"
                                optionValue="number"
                                placeholder="Destination Block"
                                @change="getBlockLot"
                            />
                            <label
                                style="color: red"
                                v-if="error_selected_block"
                                >{{ error_selected_block }}</label
                            >
                        </div>
                    </div>

                    <div class="col-12 md:col-6">
                        <div class="field">
                            <label>Lot</label>
                            <Dropdown
                                v-model="selected_block_lot"
                                :class="{
                                    'p-invalid': error_selected_lot,
                                }"
                                class="w-full"
                                :options="filteredLots"
                                optionLabel="number"
                                optionValue="id"
                                placeholder="Destination Lot"
                                @change="getResidents"
                                :disabled="selected_block ? false : true"
                            />
                            <label
                                style="color: red"
                                v-if="error_selected_lot"
                                >{{ error_selected_lot }}</label
                            >
                        </div>
                    </div>
                    <div
                        v-if="selected_block_lot"
                        class="col-12 md:col-12 mb-3"
                    >
                        <div v-if="filtered_resident_block_lot[0]">
                            <DataTable
                                :value="filtered_resident_block_lot"
                                class="w-full"
                            >
                                <template #header>
                                    <h6 class="text-center mb-0">
                                        House Residents
                                    </h6>
                                </template>
                                <Column header="Full name" field="full_name">
                                    <template #body="{ data }">
                                        {{
                                            (data["full_name"] =
                                                data.first_name +
                                                " " +
                                                data.last_name)
                                        }}
                                    </template>
                                </Column>
                                <Column field="role" header="Role"></Column>
                                <Column field="tag_as" header="Tag"></Column>
                            </DataTable>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="field">
                            <label>Card Number</label>
                            <Dropdown
                                v-model="selected_card_id"
                                :options="cards"
                                optionLabel="number"
                                :class="{
                                    'p-invalid': error_card,
                                }"
                                optionValue="id"
                                :filter="true"
                                :showClear="true"
                                class="w-full"
                            />

                            <label style="color: red" v-if="error_card">{{
                                error_card
                            }}</label>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else>
                <div class="grid formgrid">
                    <div class="col-6">
                        <div class="field">
                            <label>Vehicle Type</label>
                            <Dropdown
                                v-model="vehicle_label"
                                :class="{
                                    'p-invalid': error_vehicle_type,
                                }"
                                class="w-full"
                                :options="vehicle_types"
                                optionLabel="type"
                                optionValue="type"
                                placeholder="Select vehicle type"
                            />
                            <label
                                style="color: red"
                                v-if="error_vehicle_type"
                                >{{ error_vehicle_type }}</label
                            >
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="field">
                            <label>Vehicle Tag</label>
                            <Dropdown
                                v-model="vehicle_type"
                                :class="{
                                    'p-invalid': error_vehicle_tag,
                                }"
                                class="w-full"
                                :options="vehicle_tags"
                                optionLabel="tag"
                                optionValue="tag"
                                placeholder="Select vehicle tag"
                            />
                            <label
                                style="color: red"
                                v-if="error_vehicle_tag"
                                >{{ error_vehicle_tag }}</label
                            >
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="field">
                            <label>Plate Number</label>
                            <InputText
                                v-model="plate_number"
                                :class="{
                                    'p-invalid': error_plate_number,
                                }"
                                class="w-full"
                            />
                            <label
                                style="color: red"
                                v-if="error_plate_number"
                                >{{ error_plate_number }}</label
                            >
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="field">
                            <label>Purpose of Visit</label>
                            <Textarea
                                v-model="purpose_visit"
                                :autoResize="true"
                                :class="{
                                    'p-invalid': error_purpose_visit,
                                }"
                                class="w-full"
                            />
                            <label
                                style="color: red"
                                v-if="error_purpose_visit"
                                >{{ error_purpose_visit }}</label
                            >
                        </div>
                    </div>

                    <div class="col-12 md:col-6">
                        <div class="field">
                            <label>Block</label>
                            <Dropdown
                                v-model="selected_block"
                                :class="{
                                    'p-invalid': error_selected_block,
                                }"
                                class="w-full"
                                :options="blocks"
                                optionLabel="number"
                                optionValue="number"
                                placeholder="Destination Block"
                                @change="getBlockLot"
                            />
                            <label
                                style="color: red"
                                v-if="error_selected_block"
                                >{{ error_selected_block }}</label
                            >
                        </div>
                    </div>

                    <div class="col-12 md:col-6">
                        <div class="field">
                            <label>Lot</label>
                            <Dropdown
                                v-model="selected_block_lot"
                                :class="{
                                    'p-invalid': error_selected_lot,
                                }"
                                class="w-full"
                                :options="filteredLots"
                                optionLabel="number"
                                optionValue="id"
                                placeholder="Destination Lot"
                                @change="getResidents"
                                :disabled="selected_block ? false : true"
                            />
                            <label
                                style="color: red"
                                v-if="error_selected_lot"
                                >{{ error_selected_lot }}</label
                            >
                        </div>
                    </div>
                    <div v-if="selected_block_lot" class="col-12 mb-3">
                        <div v-if="filtered_resident_block_lot[0]">
                            <DataTable
                                :value="filtered_resident_block_lot"
                                class="w-full"
                            >
                                <template #header>
                                    <h6 class="text-center mb-0">
                                        House Residents
                                    </h6>
                                </template>
                                <Column header="Full name" field="full_name">
                                    <template #body="{ data }">
                                        {{
                                            (data["full_name"] =
                                                data.first_name +
                                                " " +
                                                data.last_name)
                                        }}
                                    </template>
                                </Column>
                                <Column field="role" header="Role"></Column>
                                <Column field="tag_as" header="Tag"></Column>
                            </DataTable>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="field">
                            <label>Card Number</label>
                            <Dropdown
                                v-model="selected_card_id"
                                :options="cards"
                                optionLabel="number"
                                :class="{
                                    'p-invalid': error_card,
                                }"
                                optionValue="id"
                                :filter="true"
                                :showClear="true"
                                class="w-full"
                            />

                            <label style="color: red" v-if="error_card">{{
                                error_card
                            }}</label>
                        </div>
                    </div>
                </div>
            </div>

            <template #footer>
                <Button
                    label="Cancel"
                    class="p-button-text"
                    @click="logVisitorDialog = false"
                />
                <Button
                    label="Log in"
                    class="p-button p-button-success"
                    @click="logIn"
                />
            </template>
        </Dialog>

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
    </div>
</template>

<script>
import axios from "axios";
import { FilterMatchMode } from "primevue/api";
import { computed } from "vue";
import { useStore } from "vuex";

export default {
    name: "AnnouncementComponent",
    setup() {
        const store = useStore();

        return {
            cards: computed(() => store.state.cards.cards),
            blocks: computed(() => store.state.blocks.blocks),
            filteredLots: computed(() => store.state.lots.filteredLots),
            filtered_resident_block_lot: computed(
                () => store.state.filtered_resident_block_lot
            ),
            visitor_logs: computed(() => {
                let temp = [];
                store.state.logs.logs_masterlist.forEach((elem) => {
                    if (
                        elem.log_type == "visitor" &&
                        elem.user_logout_id != null
                    ) {
                        temp.push(elem);
                    }
                });
                return temp;
            }),
            vehicle_logs: computed(() => {
                let temp = [];
                store.state.logs.logs_masterlist.forEach((elem) => {
                    if (
                        elem.log_type == "vehicle" &&
                        elem.user_logout_id != null
                    ) {
                        temp.push(elem);
                    }
                });
                return temp;
            }),
            visitors: computed(() => {
                // return store.state.logs.logs;
                let temp = [];
                store.state.logs.logs.forEach((elem) => {
                    if (
                        elem.log_type == "visitor" &&
                        elem.user_logout_id == null
                    ) {
                        temp.push(elem);
                    }
                });
                return temp;
            }),
            vehicles: computed(() => {
                let temp = [];
                store.state.logs.logs.forEach((elem) => {
                    if (
                        elem.log_type == "vehicle" &&
                        elem.user_logout_id == null
                    ) {
                        temp.push(elem);
                    }
                });
                return temp;
            }),
        };
    },
    data() {
        return {
            filters_masterlist: {},
            filters: {},
            from_masterlist: null,
            from: null,
            to_masterlist: null,
            to: null,
            user_login_id: null,
            selected_card: null,
            selected_card_id: null,
            purpose_visit: null,
            selected_block: null,
            selected_block_lot: null,
            name: null,
            vehicle_label: null,
            vehicle_type: null,
            plate_number: null,
            log_type: null,
            loading: false,
            logVisitorDialog: false,
            logOutDialog: false,
            logUpdate: false,
            id: null,
            error_name: null,
            error_card: null,
            error_plate_number: null,
            error_purpose_visit: null,
            error_selected_block: null,
            error_selected_lot: null,
            error_vehicle_type: null,
            error_vehicle_tag: null,

            vehicle_types: [
                { type: "car" },
                { type: "motorcycle" },
                { type: "van" },
                { type: "truck" },
                { type: "tricycle" },
            ],
            vehicle_tags: [{ tag: "private" }, { tag: "public" }],
        };
    },
    methods: {
        getResidents() {
            this.$store.dispatch(
                "filterResidentBlockLot",
                this.selected_block_lot
            );
        },
        clearFilter() {
            this.filters["global"].value = null;
            this.filters["lot.block.number"].value = null;
            this.filters["lot.number"].value = null;
            this.filters["vehicle_type"].value = null;
            this.filters["vehicle_label"].value = null;
            this.from = null;
            this.to = null;
            this.$store.dispatch("logs/getAll");
        },
        clearFilterMaster() {
            this.filters_masterlist["global"].value = null;
            this.filters_masterlist["lot.block.number"].value = null;
            this.filters_masterlist["lot.number"].value = null;
            this.filters_masterlist["vehicle_type"].value = null;
            this.filters_masterlist["vehicle_label"].value = null;
            this.from_masterlist = null;
            this.to_masterlist = null;
            this.$store.dispatch("logs/getAll");
        },
        async changeFromToDate(type) {
            if (type == "log_master") {
                await axios({
                    method: "post",
                    url: "/api/log/filter/",
                    data: {
                        from: this.from_masterlist,
                        to: this.to_masterlist,
                    },
                })
                    .then((res) => {
                        this.$store.commit("logs/getLogMasterList", res.data);
                    })
                    .catch((err) => {
                        console.log(err.response.data);
                    });
            } else {
                await axios({
                    method: "post",
                    url: "/api/log/filter/",
                    data: {
                        from: this.from,
                        to: this.to,
                    },
                })
                    .then((res) => {
                        console.log("from_to", res.data);
                        this.$store.commit("logs/getLogs", res.data);
                    })
                    .catch((err) => {
                        console.log(err.response.data);
                    });
            }
        },
        getFilterBlockLot() {
            this.$store.dispatch(
                "lots/getBlockLots",
                this.filters["lot.block.number"].value
            );
        },
        getFilterBlockLotMaster() {
            this.$store.dispatch(
                "lots/getBlockLots",
                this.filters_masterlist["lot.block.number"].value
            );
        },
        dateFormat(date) {
            var options = {
                year: "numeric",
                month: "long",
                day: "numeric",
                hour12: true,
                hour: "numeric",
                minute: "numeric",
            };

            return new Date(date).toLocaleDateString("en-US", options);
        },
        getBlockLot() {
            this.selected_block_lot = null;
            this.$store.dispatch("lots/getBlockLots", this.selected_block);
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
            this.filters_masterlist = {
                global: { value: null, matchMode: FilterMatchMode.CONTAINS },
                "lot.block.number": {
                    value: null,
                    matchMode: FilterMatchMode.EQUALS,
                },
                "lot.number": {
                    value: null,
                    matchMode: FilterMatchMode.EQUALS,
                },
                vehicle_label: {
                    value: null,
                    matchMode: FilterMatchMode.EQUALS,
                },
                vehicle_type: {
                    value: null,
                    matchMode: FilterMatchMode.EQUALS,
                },
            };
            this.filters = {
                global: { value: null, matchMode: FilterMatchMode.CONTAINS },
                vehicle_label: {
                    value: null,
                    matchMode: FilterMatchMode.EQUALS,
                },
                vehicle_type: {
                    value: null,
                    matchMode: FilterMatchMode.EQUALS,
                },
                "lot.block.number": {
                    value: null,
                    matchMode: FilterMatchMode.EQUALS,
                },
                "lot.number": {
                    value: null,
                    matchMode: FilterMatchMode.EQUALS,
                },
            };
        },

        logout(data) {
            this.id = data.id;
            this.user_login_id = data.user_login_id;
            this.log_type = data.log_type;
            this.selected_card = data.card.number;
            this.selected_card_id = data.card_id;
            this.selected_block_lot = data.block_lot_id;
            this.purpose_visit = data.purpose_visit;
            if (data.log_type == "visitor") {
                this.name = data.name;
            } else {
                this.plate_number = data.plate_number;
                this.vehicle_label = data.vehicle_label;
                this.vehicle_type = data.vehicle_type;
            }
            console.log(data);
            this.logOutDialog = true;
        },
        showLogoutToast() {
            this.$toast.add({
                severity: "success",
                summary: "Successful Request",
                detail: "Successful Logout",
                life: 3000,
            });
        },
        async logOut() {
            this.loading = true;
            if (this.log_type == "visitor") {
                await axios({
                    method: "put",
                    url: "/api/log/" + this.id,
                    data: {
                        user_login_id: this.user_login_id,
                        user_logout_id: this.$store.state.userLogged.id,
                        card_id: this.selected_card_id,
                        block_lot_id: this.selected_block_lot,
                        purpose_visit: this.purpose_visit,
                        log_type: this.log_type,
                        name: this.name,
                    },
                })
                    .then(() => {
                        this.logOutDialog = false;
                        this.resetFields();
                        this.$store.dispatch("logs/getAll");
                        this.$store.dispatch("cards/getAll");
                        this.showLogoutToast();
                        this.loading = false;
                    })
                    .catch((err) => {
                        console.log(err.response);
                        this.resetErrors();
                        this.validate(err);
                        this.loading = false;
                    });
            } else {
                await axios({
                    method: "put",
                    url: "/api/log/" + this.id,
                    data: {
                        user_login_id: this.user_login_id,
                        user_logout_id: this.$store.state.userLogged.id,
                        card_id: this.selected_card_id,
                        block_lot_id: this.selected_block_lot,
                        purpose_visit: this.purpose_visit,
                        log_type: this.log_type,
                        plate_number: this.plate_number,
                        vehicle_label: this.vehicle_label,
                        vehicle_type: this.vehicle_type,
                    },
                })
                    .then(() => {
                        this.logOutDialog = false;
                        this.resetFields();
                        this.$store.dispatch("logs/getAll");
                        this.$store.dispatch("cards/getAll");
                        this.showLogoutToast();
                        this.loading = false;
                    })
                    .catch((err) => {
                        console.log(err.response.data);
                        this.resetErrors();
                        this.validate(err);
                        this.loading = false;
                    });
            }
        },
        updateLog(data) {
            this.resetErrors();
            this.id = data.id;
            if (data.log_type == "visitor") {
                this.name = data.name;
            } else {
                this.user_login_id = data.user_login_id;
                this.plate_number = data.plate_number;
                this.vehicle_label = data.vehicle_label;
                this.vehicle_type = data.vehicle_type;
            }
            this.log_type = data.log_type;
            this.selected_card = data.card.number;
            this.selected_card_id = data.card.id;
            this.selected_block = data.lot.block.number;
            this.getBlockLot();
            this.selected_block_lot = data.block_lot_id;
            this.getResidents();
            this.purpose_visit = data.purpose_visit;
            this.logUpdate = true;
        },
        showUpdateToast() {
            this.$toast.add({
                severity: "success",
                summary: "Successful Request",
                detail: "Updated Log",
                life: 3000,
            });
        },
        async confirmUpdate() {
            this.loading = true;
            if (this.log_type == "visitor") {
                await axios({
                    method: "put",
                    url: "/api/log/" + this.id,
                    data: {
                        user_login_id: this.$store.state.userLogged.id,
                        card_id: this.selected_card_id,
                        block_lot_id: this.selected_block_lot,
                        purpose_visit: this.purpose_visit,
                        log_type: this.log_type,
                        name: this.name,
                    },
                })
                    .then(() => {
                        this.logUpdate = false;
                        this.resetFields();
                        this.$store.dispatch("logs/getAll");
                        this.$store.dispatch("cards/getAll");
                        this.showUpdateToast();
                        this.loading = false;
                    })
                    .catch((err) => {
                        console.log(err.response);
                        this.resetErrors();
                        this.validate(err);
                        this.loading = false;
                    });
            } else {
                await axios({
                    method: "put",
                    url: "/api/log/" + this.id,
                    data: {
                        user_login_id: this.$store.state.userLogged.id,
                        card_id: this.selected_card_id,
                        block_lot_id: this.selected_block_lot,
                        purpose_visit: this.purpose_visit,
                        log_type: this.log_type,
                        plate_number: this.plate_number,
                        vehicle_label: this.vehicle_label,
                        vehicle_type: this.vehicle_type,
                    },
                })
                    .then(() => {
                        this.logUpdate = false;
                        this.resetFields();
                        this.$store.dispatch("logs/getAll");
                        this.$store.dispatch("cards/getAll");
                        this.showUpdateToast();
                        this.loading = false;
                    })
                    .catch((err) => {
                        console.log(err.response);
                        this.resetErrors();
                        this.validate(err);
                        this.loading = false;
                    });
            }
        },
        showLogToast() {
            this.$toast.add({
                severity: "success",
                summary: "Successful Request",
                detail: "Successfully Log",
                life: 3000,
            });
        },
        //Log Visitor
        openLogDialog(log_type) {
            this.resetFields();
            this.resetErrors();
            this.log_type = log_type;
            this.logVisitorDialog = true;
        },

        async logIn() {
            this.loading = true;
            if (this.log_type == "visitor") {
                await axios({
                    method: "post",
                    url: "/api/log",
                    data: {
                        user_login_id: this.$store.state.userLogged.id,
                        card_id: this.selected_card_id,
                        purpose_visit: this.purpose_visit,
                        block_lot_id: this.selected_block_lot,
                        log_type: this.log_type,
                        name: this.name,
                    },
                })
                    .then(async () => {
                        this.logVisitorDialog = false;
                        this.logVisitorDialog = false;
                        this.$store.dispatch("logs/getAll");
                        this.$store.dispatch("cards/getAll");
                        this.showLogToast();
                        await axios({
                            method: "post",
                            url: "/api/notification/security-log",
                            data: {
                                from_user_id: this.$store.state.userLogged.id,
                                message:
                                    "has logged that you have a visitor named" +
                                    this.name,
                                block_lot_id: this.selected_block_lot,
                            },
                        })
                            .then((res) => {
                                console.log("notify announcement success");
                            })
                            .catch((e) => {
                                console.log(e.response);
                            });
                        this.loading = false;
                    })
                    .catch((err) => {
                        console.log(err.response.data);
                        this.resetErrors();
                        this.validate(err);
                        this.loading = false;
                    });
            } else {
                await axios({
                    method: "post",
                    url: "/api/log",
                    data: {
                        user_login_id: this.$store.state.userLogged.id,
                        card_id: this.selected_card_id,
                        purpose_visit: this.purpose_visit,
                        block_lot_id: this.selected_block_lot,
                        log_type: this.log_type,
                        vehicle_label: this.vehicle_label,
                        vehicle_type: this.vehicle_type,
                        plate_number: this.plate_number,
                    },
                })
                    .then(async () => {
                        this.logVisitorDialog = false;
                        this.logVisitorDialog = false;
                        this.$store.dispatch("logs/getAll");
                        this.$store.dispatch("cards/getAll");
                        this.showLogToast();
                        await axios({
                            method: "post",
                            url: "/api/notification/security-log",
                            data: {
                                from_user_id: this.$store.state.userLogged.id,
                                message:
                                    "has logged a visitor with a vehicle of " +
                                    this.vehicle_type +
                                    " [" +
                                    this.vehicle_type +
                                    "] " +
                                    "Plate no. " +
                                    this.plate_number,
                                block_lot_id: this.selected_block_lot,
                            },
                        })
                            .then((res) => {
                                console.log("notify announcement success");
                            })
                            .catch((e) => {
                                console.log(e.response);
                            });
                        this.loading = false;
                    })
                    .catch((err) => {
                        console.log(err.response.data);
                        this.resetErrors();
                        this.validate(err);
                        this.loading = false;
                    });
            }
        },

        resetFields() {
            this.id = null;
            this.name = null;
            this.plate_number = null;
            this.selected_card = null;
            this.selected_card_id = null;
            this.selected_block = null;
            this.selected_block_lot = null;
            this.purpose_visit = null;
            this.vehicle_label = null;
            this.vehicle_type = null;
        },
        resetErrors() {
            this.error_name = null;
            this.error_card = null;
            this.error_purpose_visit = null;
            this.error_selected_block = null;
            this.error_selected_lot = null;
            this.error_plate_number = null;
            this.error_vehicle_type = null;
            this.error_vehicle_tag = null;
        },
        validate(error) {
            if (error.response.data.errors.name)
                this.error_name = error.response.data.errors.name[0];
            if (error.response.data.errors.purpose_visit)
                this.error_purpose_visit =
                    error.response.data.errors.purpose_visit[0];
            if (error.response.data.errors.block_lot_id) {
                this.error_selected_block = "Complete block and lot field";
                this.error_selected_lot = "Complete block and lot field";
            }
            if (error.response.data.errors.card_id)
                this.error_card = "This card number field is required";
            if (error.response.data.errors.plate_number)
                this.error_plate_number =
                    error.response.data.errors.plate_number[0];
            if (error.response.data.errors.vehicle_label)
                this.error_vehicle_type =
                    error.response.data.errors.vehicle_label[0];
            if (error.response.data.errors.vehicle_type)
                this.error_vehicle_tag =
                    error.response.data.errors.vehicle_type[0];
        },
    },
    created() {
        this.initFilters();
    },
    mounted() {
        this.$store.dispatch("logs/getAll");
        this.$store.dispatch("cards/getAll");
    },
};
</script>

<style scoped></style>
