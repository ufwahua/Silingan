<template>
    <div>
        <Toast />
        <div class="grid">
            <div class="col-12">
                <h1 class="layout-text">All Users</h1>
            </div>
        </div>
        <div class="grid mb-2 flex justify-content-flex-start">
            <div class="col-12 lg:col-6 xl:col-3">
                <div class="card mb-0 bg-green-100">
                    <div class="flex justify-content-between mb-3">
                        <div>
                            <span
                                class="block font-medium text-4xl font-bold mb-3"
                                >{{ active }}</span
                            >
                            <div class="text-900">Active</div>
                        </div>
                        <div
                            class="flex align-items-center justify-content-center"
                            style="width: 2.5rem; height: 2.5rem"
                        ></div>
                    </div>
                </div>
            </div>
            <div class="col-12 lg:col-6 xl:col-3">
                <div class="card mb-0 bg-pink-100">
                    <div class="flex justify-content-between mb-3">
                        <div>
                            <span
                                class="block font-medium text-4xl font-bold mb-3"
                                >{{ inactive }}</span
                            >
                            <div class="text-900">Inactive</div>
                        </div>

                        <div
                            class="flex align-items-center justify-content-center"
                            style="width: 2.5rem; height: 2.5rem"
                        ></div>
                    </div>
                </div>
            </div>
            <div class="col-12 lg:col-6 xl:col-3">
                <div class="card mb-0 bg-green-100">
                    <div class="flex justify-content-between mb-3">
                        <div>
                            <span
                                class="block font-medium text-4xl font-bold mb-3"
                                >{{ verified }}</span
                            >
                            <div class="text-900">Verified</div>
                        </div>

                        <div
                            class="flex align-items-center justify-content-center"
                            style="width: 2.5rem; height: 2.5rem"
                        ></div>
                    </div>
                </div>
            </div>
            <div class="col-12 lg:col-6 xl:col-3">
                <div class="card mb-0 bg-pink-100">
                    <div class="flex justify-content-between mb-3">
                        <div>
                            <span
                                class="block font-medium text-4xl font-bold mb-3"
                                >{{ not_verified }}</span
                            >
                            <div class="text-900">Not Verified</div>
                        </div>

                        <div
                            class="flex align-items-center justify-content-center"
                            style="width: 2.5rem; height: 2.5rem"
                        ></div>
                    </div>
                </div>
            </div>
            <div class="col-12 lg:col-6 xl:col-3">
                <div class="card mb-0 bg-green-100">
                    <div class="flex justify-content-between mb-3">
                        <div>
                            <span
                                class="block font-medium text-4xl font-bold mb-3"
                                >{{ not_flagged }}</span
                            >
                            <div class="text-900">Not Flagged</div>
                        </div>
                        <div
                            class="flex align-items-center justify-content-center"
                            style="width: 2.5rem; height: 2.5rem"
                        ></div>
                    </div>
                </div>
            </div>
            <div class="col-12 lg:col-6 xl:col-3">
                <div class="card mb-0 bg-pink-100">
                    <div class="flex justify-content-between mb-3">
                        <div>
                            <span
                                class="block font-medium text-4xl font-bold mb-3"
                                >{{ flagged }}</span
                            >
                            <div class="text-900">Flagged</div>
                        </div>

                        <div
                            class="flex align-items-center justify-content-center"
                            style="width: 2.5rem; height: 2.5rem"
                        ></div>
                    </div>
                </div>
            </div>
            <!-- <div class="col-12 lg:col-6 xl:col-3">
                <div class="card mb-0 bg-green-100">
                    <div class="flex justify-content-between mb-3">
                        <div>
                            <span
                                class="block font-medium text-4xl font-bold mb-3"
                                >{{ not_flagged }}</span
                            >
                            <div class="text-900">Not Flagged</div>
                        </div>

                        <div
                            class="flex align-items-center justify-content-center"
                            style="width: 2.5rem; height: 2.5rem"
                        ></div>
                    </div>
                </div>
            </div>
            <div class="col-12 lg:col-6 xl:col-3">
                <div class="card mb-0 bg-pink-100">
                    <div class="flex justify-content-between mb-3">
                        <div>
                            <span
                                class="block font-medium text-4xl font-bold mb-3"
                                >{{ flagged }}</span
                            >
                            <div class="text-900">Flagged</div>
                        </div>

                        <div
                            class="flex align-items-center justify-content-center"
                            style="width: 2.5rem; height: 2.5rem"
                        ></div>
                    </div>
                </div>
            </div> -->
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

        <div class="grid p-fluid">
            <div class="col-12">
                <div class="card">
                    <DataTable
                        :value="users"
                        :filters="filters"
                        breakpoint="1350px"
                        :rows="10"
                    >
                        <div>
                            <div class="grid formgrid">
                                <div class="col-12 mb-2 lg:col-4 lg:mb-0">
                                    <span class="p-input-icon-left">
                                        <i class="pi pi-search" />
                                        <InputText
                                            v-model="filters['global'].value"
                                            placeholder="Keyword Search"
                                        />
                                    </span>
                                </div>
                                <div class="col-12 mb-2 lg:col-2 lg:mb-0">
                                    <Dropdown
                                        v-model="
                                            filters['lot.block.number'].value
                                        "
                                        :showClear="true"
                                        :options="blocks"
                                        optionLabel="number"
                                        optionValue="number"
                                        placeholder="Filter by block"
                                        @change="getFilterBlockLot"
                                    ></Dropdown>
                                </div>
                                <div class="col-12 mb-2 lg:col-2 lg:mb-0">
                                    <Dropdown
                                        v-model="filters['lot.number'].value"
                                        :showClear="true"
                                        :options="filteredLots"
                                        optionLabel="number"
                                        optionValue="number"
                                        placeholder="Filter by lot"
                                    ></Dropdown>
                                </div>
                                <div class="col-12 mb-2 lg:col-2 lg:mb-0">
                                    <Dropdown
                                        v-model="filters['tag_as'].value"
                                        :showClear="true"
                                        :options="tag"
                                        optionLabel="tag"
                                        optionValue="tag"
                                        placeholder="Filter by tag"
                                    ></Dropdown>
                                </div>

                                <div class="col-12 mb-2 lg:col-2 lg:mb-0">
                                    <Dropdown
                                        v-model="filters['role'].value"
                                        :showClear="true"
                                        :options="role"
                                        optionLabel="role"
                                        optionValue="role"
                                        placeholder="Filter by role"
                                    ></Dropdown>
                                </div>
                                <div class="col-12 mb-2 lg:col-2 lg:mb-0 mt-2">
                                    <Dropdown
                                        v-model="filters['status'].value"
                                        :showClear="true"
                                        :options="status"
                                        optionLabel="status"
                                        optionValue="status"
                                        placeholder="Filter by status"
                                    ></Dropdown>
                                </div>
                                <div class="col-12 mb-2 lg:col-2 lg:mb-0 mt-2">
                                    <Dropdown
                                        v-model="filters['verified'].value"
                                        :showClear="true"
                                        :options="verification"
                                        optionLabel="status"
                                        optionValue="value"
                                        placeholder="Filter by verification"
                                    ></Dropdown>
                                </div>
                                <div class="col-12 mb-2 lg:col-2 lg:mb-0 mt-2">
                                    <Dropdown
                                        v-model="filters['flagged'].value"
                                        :showClear="true"
                                        :options="flag_dropdown"
                                        optionLabel="status"
                                        optionValue="value"
                                        placeholder="Filter flag"
                                    ></Dropdown>
                                </div>

                                <div
                                    class="col-12 mb-2 lg:col-4 lg:mb-0 flex justify-content-end mt-2"
                                >
                                    <Button
                                        icon="pi pi-filter-slash"
                                        class="p-button-outlined p-button-secondary"
                                        @click="clearFilter"
                                        v-tooltip="'Clear'"
                                    />

                                    <Button
                                        label="Add"
                                        icon="pi pi-plus"
                                        class="ml-2 p-button-primary"
                                        style="width: auto"
                                        @click="registerUser"
                                    />
                                </div>
                            </div>
                        </div>

                        <template #empty> No registered users found </template>
                        <template #loading> Loading Users </template>
                        <Column header="Profile Pic">
                            <template #body="{ data }">
                                <div v-if="data.profile_pic">
                                    <Avatar
                                        :image="`http://127.0.0.1:8000${data.profile_pic}`"
                                        style="width: 100px; height: 100px"
                                        shape="circle"
                                    />
                                </div>
                                <div v-else>
                                    <Avatar
                                        image="http://127.0.0.1:8000/storage/images/avatar.png"
                                        style="width: 100px; height: 100px"
                                        shape="circle"
                                    />
                                </div> </template
                        ></Column>
                        <Column header="Name" field="name">
                            <template #body="{ data }">
                                {{
                                    (data["name"] =
                                        data.first_name + " " + data.last_name)
                                }}
                            </template>
                        </Column>

                        <Column header="Block" field="lot.block.number">
                        </Column>
                        <Column header="Lot" field="lot.number"> </Column>
                        <Column header="Tag" field="tag_as"> </Column>
                        <Column
                            header="Role"
                            field="role"
                            style="min-width: 9rem"
                        >
                            <template #body="{ data }">
                                <Badge :class="badgecolor(data.role)">{{
                                    data.role
                                }}</Badge>
                            </template>
                        </Column>
                        <Column header="Status" field="status">
                            <template #body="{ data }">
                                <Badge :class="badgecolor(data.status)">{{
                                    data.status
                                }}</Badge>
                            </template>
                        </Column>
                        <Column
                            header="Verify"
                            field="verified"
                            style="min-width: 8rem"
                        >
                            <template #body="{ data }">
                                <div v-if="data.verified == 0">
                                    <Badge :class="badgecolor(data.verified)">
                                        not verified
                                    </Badge>
                                </div>
                                <div v-else>
                                    <Badge :class="badgecolor(data.verified)">
                                        verified
                                    </Badge>
                                </div>
                            </template>
                        </Column>
                        <Column header="Flag" field="flag">
                            <template #body="{ data }">
                                <Button
                                    v-if="data.flagged == true"
                                    icon="pi pi-flag-fill"
                                    class="p-button-rounded p-button-danger"
                                    disabled
                                />
                                <Button
                                    v-else
                                    icon="pi pi-flag-fill"
                                    class="p-button-rounded p-button-success"
                                    disabled
                                />
                            </template>
                        </Column>
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
                        v-model:visible="deleteUserDialog"
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
                                        >Are you sure you want to delete
                                        <b>{{ name }}</b
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
                                @click="deleteUserDialog = false"
                            />
                            <Button
                                label="Delete"
                                icon="pi pi-check"
                                class="p-button-text p-button-danger"
                                @click="confirmDeleteItem"
                            />
                        </template>
                    </Dialog>
                    <Dialog
                        v-model:visible="updateUserDialog"
                        :style="{ width: '500px' }"
                        header="Update User"
                        :modal="true"
                    >
                        <div
                            v-if="form.selected_role == 'resident'"
                            class="grid"
                        >
                            <div class="col-12 title-form">
                                <Badge
                                    :value="1"
                                    severity="info"
                                    class="mr-2 mb-2"
                                    size="large"
                                ></Badge>
                                <label><h6>Basic Information</h6></label>
                            </div>

                            <div class="p-fluid formgrid grid">
                                <div class="field col-12 md:col-6">
                                    <label>Firstname</label>

                                    <InputText
                                        id="firstname"
                                        type="text"
                                        v-model="form.first_name"
                                        :class="{
                                            'p-invalid': error_first_name,
                                        }"
                                        @keydown.enter="onRegisterClick"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_first_name"
                                        >{{ error_first_name }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-6">
                                    <label>Lastname</label>

                                    <InputText
                                        id="last_name"
                                        type="text"
                                        v-model="form.last_name"
                                        :class="{
                                            'p-invalid': error_last_name,
                                        }"
                                        @keydown.enter="onRegisterClick"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_last_name"
                                        >{{ error_last_name }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-6">
                                    <div>
                                        <label>Gender</label>
                                    </div>

                                    <div>
                                        <div class="field-radiobutton mb-0">
                                            <RadioButton
                                                name="gender"
                                                value="male"
                                                v-model="form.gender"
                                                :class="{
                                                    'p-invalid': error_gender,
                                                }"
                                                @keydown.enter="onRegisterClick"
                                            />
                                            <label class="mb-0 ml-1 mr-5"
                                                >Male</label
                                            >
                                            <RadioButton
                                                name="gender"
                                                value="female"
                                                :class="{
                                                    'p-invalid': error_gender,
                                                }"
                                                v-model="form.gender"
                                                @keydown.enter="onRegisterClick"
                                            />
                                            <label class="mb-0 ml-1"
                                                >Female</label
                                            >
                                        </div>
                                        <div>
                                            <label
                                                style="color: red"
                                                v-if="error_gender"
                                                >{{ error_gender }}</label
                                            >
                                        </div>
                                    </div>
                                </div>

                                <div class="field col-12 md:col-6">
                                    <label>Age</label>
                                    <InputText
                                        id="age"
                                        type="number"
                                        min="0"
                                        step="1"
                                        onfocus="this.previousValue = this.value"
                                        onkeydown="this.previousValue = this.value"
                                        oninput="validity.valid || (value = this.previousValue)"
                                        v-model="form.age"
                                        :class="{
                                            'p-invalid': error_age,
                                        }"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_age"
                                        >{{ error_age }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-6">
                                    <label>Block</label>

                                    <Dropdown
                                        v-model="form.selected_block"
                                        :options="blocks"
                                        optionLabel="number"
                                        optionValue="number"
                                        placeholder="Select Block"
                                        @change="
                                            getBlockLot(form.selected_block)
                                        "
                                        :class="{
                                            'p-invalid': error_selected_block,
                                        }"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_selected_block"
                                        >{{ error_selected_block }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-6">
                                    <label>Lot</label>

                                    <Dropdown
                                        v-model="form.selected_block_lot"
                                        :options="filteredLots"
                                        optionLabel="number"
                                        optionValue="id"
                                        placeholder="Select Lot"
                                        :class="{
                                            'p-invalid': error_selected_lot,
                                        }"
                                        :disabled="
                                            form.selected_block ? false : true
                                        "
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_selected_lot"
                                        >{{ error_selected_lot }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-6">
                                    <label>Role</label>

                                    <Dropdown
                                        v-model="form.selected_role"
                                        :class="{
                                            'p-invalid': error_role,
                                        }"
                                        :options="role"
                                        optionLabel="role"
                                        optionValue="role"
                                        placeholder="Select Role"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_role"
                                        >{{ error_role }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-6">
                                    <label>Tag as</label>

                                    <Dropdown
                                        v-model="form.selected_tag"
                                        :class="{
                                            'p-invalid': error_selected_tag,
                                        }"
                                        :options="tag"
                                        optionLabel="tag"
                                        optionValue="tag"
                                        placeholder="Select tag"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_selected_tag"
                                        >{{ error_selected_tag }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-12">
                                    <label>Contact Number</label>
                                    <div class="p-inputgroup">
                                        <span class="p-inputgroup-addon">
                                            +63
                                        </span>
                                        <InputMask
                                            mask="(999) 99-999-9999"
                                            placeholder="(639) 99-999-9999"
                                            :unmask="true"
                                            id="contact_num"
                                            type="text"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                            v-model="form.contact_num"
                                            @keydown.enter="onRegisterClick"
                                            :class="{
                                                'p-invalid': error_contact_num,
                                            }"
                                        />
                                    </div>

                                    <label
                                        style="color: red"
                                        v-if="error_contact_num"
                                        >{{ error_contact_num }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-12">
                                    <label>Email</label>
                                    <InputText
                                        type="text"
                                        v-model="form.email"
                                        @keydown.enter="onRegisterClick"
                                        :class="{
                                            'p-invalid': error_email,
                                        }"
                                        disabled
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_email"
                                        >{{ error_email }}</label
                                    >
                                </div>
                                <br />
                            </div>
                        </div>
                        <div
                            v-else-if="form.selected_role == 'officer'"
                            class="grid"
                        >
                            <div class="col-12 title-form">
                                <Badge
                                    :value="1"
                                    severity="info"
                                    class="mr-2 mb-2"
                                    size="large"
                                ></Badge>
                                <label><h6>Basic Information</h6></label>
                            </div>

                            <div class="p-fluid formgrid grid">
                                <div class="field col-12 md:col-6">
                                    <label>Firstname</label>

                                    <InputText
                                        id="firstname"
                                        type="text"
                                        v-model="form.first_name"
                                        :class="{
                                            'p-invalid': error_first_name,
                                        }"
                                        @keydown.enter="onRegisterClick"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_first_name"
                                        >{{ error_first_name }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-6">
                                    <label>Lastname</label>

                                    <InputText
                                        id="last_name"
                                        type="text"
                                        v-model="form.last_name"
                                        :class="{
                                            'p-invalid': error_last_name,
                                        }"
                                        @keydown.enter="onRegisterClick"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_last_name"
                                        >{{ error_last_name }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-6">
                                    <div>
                                        <label>Gender</label>
                                    </div>

                                    <div>
                                        <div class="field-radiobutton mb-0">
                                            <RadioButton
                                                name="gender"
                                                value="male"
                                                v-model="form.gender"
                                                :class="{
                                                    'p-invalid': error_gender,
                                                }"
                                                @keydown.enter="onRegisterClick"
                                            />
                                            <label class="mb-0 ml-1 mr-5"
                                                >Male</label
                                            >
                                            <RadioButton
                                                name="gender"
                                                value="female"
                                                :class="{
                                                    'p-invalid': error_gender,
                                                }"
                                                v-model="form.gender"
                                                @keydown.enter="onRegisterClick"
                                            />
                                            <label class="mb-0 ml-1"
                                                >Female</label
                                            >
                                        </div>
                                        <div>
                                            <label
                                                style="color: red"
                                                v-if="error_gender"
                                                >{{ error_gender }}</label
                                            >
                                        </div>
                                    </div>
                                </div>

                                <div class="field col-12 md:col-6">
                                    <label>Age</label>
                                    <InputText
                                        id="age"
                                        type="number"
                                        min="0"
                                        step="1"
                                        onfocus="this.previousValue = this.value"
                                        onkeydown="this.previousValue = this.value"
                                        oninput="validity.valid || (value = this.previousValue)"
                                        v-model="form.age"
                                        :class="{
                                            'p-invalid': error_age,
                                        }"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_age"
                                        >{{ error_age }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-6">
                                    <label>Block</label>

                                    <Dropdown
                                        v-model="form.selected_block"
                                        :options="blocks"
                                        optionLabel="number"
                                        optionValue="number"
                                        placeholder="Select Block"
                                        @change="
                                            getBlockLot(form.selected_block)
                                        "
                                        :class="{
                                            'p-invalid': error_selected_block,
                                        }"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_selected_block"
                                        >{{ error_selected_block }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-6">
                                    <label>Lot</label>

                                    <Dropdown
                                        v-model="form.selected_block_lot"
                                        :options="filteredLots"
                                        optionLabel="number"
                                        optionValue="id"
                                        placeholder="Select Lot"
                                        :class="{
                                            'p-invalid': error_selected_lot,
                                        }"
                                        :disabled="
                                            form.selected_block ? false : true
                                        "
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_selected_lot"
                                        >{{ error_selected_lot }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-6">
                                    <label>Tag as</label>

                                    <Dropdown
                                        v-model="form.selected_tag"
                                        :class="{
                                            'p-invalid': error_selected_tag,
                                        }"
                                        :options="tag"
                                        optionLabel="tag"
                                        optionValue="tag"
                                        placeholder="Select tag"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_selected_tag"
                                        >{{ error_selected_tag }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-6">
                                    <label>Contact Number</label>
                                    <div class="p-inputgroup">
                                        <span class="p-inputgroup-addon">
                                            +63
                                        </span>
                                        <InputMask
                                            mask="(999) 99-999-9999"
                                            placeholder="(639) 99-999-9999"
                                            :unmask="true"
                                            type="text"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                            v-model="form.contact_num"
                                            @keydown.enter="onRegisterClick"
                                            :class="{
                                                'p-invalid': error_contact_num,
                                            }"
                                        />
                                    </div>

                                    <label
                                        style="color: red"
                                        v-if="error_contact_num"
                                        >{{ error_contact_num }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-6">
                                    <label>Role</label>

                                    <Dropdown
                                        v-model="form.selected_role"
                                        :class="{
                                            'p-invalid': error_role,
                                        }"
                                        :options="role"
                                        optionLabel="role"
                                        optionValue="role"
                                        placeholder="Select Role"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_role"
                                        >{{ error_role }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-6">
                                    <label>Position</label>

                                    <Dropdown
                                        v-model="form.selected_position"
                                        :class="{
                                            'p-invalid':
                                                error_selected_position,
                                        }"
                                        :options="positions"
                                        optionLabel="name"
                                        optionValue="id"
                                        placeholder="Select Position"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_selected_position"
                                        >{{ error_selected_position }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-12">
                                    <label>Email</label>
                                    <InputText
                                        type="text"
                                        v-model="form.email"
                                        @keydown.enter="onRegisterClick"
                                        :class="{
                                            'p-invalid': error_email,
                                        }"
                                        disabled
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_email"
                                        >{{ error_email }}</label
                                    >
                                </div>

                                <br />
                            </div>
                        </div>
                        <div v-else class="grid">
                            <div class="col-12 title-form">
                                <Badge
                                    :value="1"
                                    severity="info"
                                    class="mr-2 mb-2"
                                    size="large"
                                ></Badge>
                                <label><h6>Basic Information</h6></label>
                            </div>

                            <div class="p-fluid formgrid grid">
                                <div class="field col-12 md:col-6">
                                    <label>Firstname</label>

                                    <InputText
                                        id="firstname"
                                        type="text"
                                        v-model="form.first_name"
                                        :class="{
                                            'p-invalid': error_first_name,
                                        }"
                                        @keydown.enter="onRegisterClick"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_first_name"
                                        >{{ error_first_name }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-6">
                                    <label>Lastname</label>

                                    <InputText
                                        id="last_name"
                                        type="text"
                                        v-model="form.last_name"
                                        :class="{
                                            'p-invalid': error_last_name,
                                        }"
                                        @keydown.enter="onRegisterClick"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_last_name"
                                        >{{ error_last_name }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-6">
                                    <div>
                                        <label>Gender</label>
                                    </div>

                                    <div>
                                        <div class="field-radiobutton mb-0">
                                            <RadioButton
                                                name="gender"
                                                value="male"
                                                v-model="form.gender"
                                                :class="{
                                                    'p-invalid': error_gender,
                                                }"
                                                @keydown.enter="onRegisterClick"
                                            />
                                            <label class="mb-0 ml-1 mr-5"
                                                >Male</label
                                            >
                                            <RadioButton
                                                name="gender"
                                                value="female"
                                                :class="{
                                                    'p-invalid': error_gender,
                                                }"
                                                v-model="form.gender"
                                                @keydown.enter="onRegisterClick"
                                            />
                                            <label class="mb-0 ml-1"
                                                >Female</label
                                            >
                                        </div>
                                        <div>
                                            <label
                                                style="color: red"
                                                v-if="error_gender"
                                                >{{ error_gender }}</label
                                            >
                                        </div>
                                    </div>
                                </div>
                                <div class="field col-12 md:col-6">
                                    <label>Age</label>
                                    <InputText
                                        id="age"
                                        type="number"
                                        min="0"
                                        step="1"
                                        onfocus="this.previousValue = this.value"
                                        onkeydown="this.previousValue = this.value"
                                        oninput="validity.valid || (value = this.previousValue)"
                                        v-model="form.age"
                                        :class="{
                                            'p-invalid': error_age,
                                        }"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_age"
                                        >{{ error_age }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-12">
                                    <label>Role</label>

                                    <Dropdown
                                        v-model="form.selected_role"
                                        :class="{
                                            'p-invalid': error_role,
                                        }"
                                        :options="role"
                                        optionLabel="role"
                                        optionValue="role"
                                        placeholder="Select Role"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_role"
                                        >{{ error_role }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-12">
                                    <label>Contact Number</label>
                                    <div class="p-inputgroup">
                                        <span class="p-inputgroup-addon">
                                            +63
                                        </span>
                                        <InputMask
                                            mask="(999) 99-999-9999"
                                            placeholder="(639) 99-999-9999"
                                            :unmask="true"
                                            id="contact_num"
                                            type="text"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                            v-model="form.contact_num"
                                            @keydown.enter="onRegisterClick"
                                            :class="{
                                                'p-invalid': error_contact_num,
                                            }"
                                        />
                                    </div>

                                    <label
                                        style="color: red"
                                        v-if="error_contact_num"
                                        >{{ error_contact_num }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-12">
                                    <label>Email</label>
                                    <InputText
                                        type="text"
                                        v-model="form.email"
                                        @keydown.enter="onRegisterClick"
                                        :class="{
                                            'p-invalid': error_email,
                                        }"
                                        disabled
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_email"
                                        >{{ error_email }}</label
                                    >
                                </div>
                            </div>
                        </div>
                        <template #footer>
                            <Button
                                label="Cancel"
                                icon="pi pi-times"
                                class="p-button-text"
                                @click="updateUserDialog = false"
                            />
                            <Button
                                label="Update"
                                icon="pi pi-check"
                                class="p-button-text p-button-success"
                                @click="confirmUpdateUser"
                            />
                        </template>
                    </Dialog>

                    <Dialog
                        v-model:visible="registerUserDialog"
                        :style="{ width: '500px' }"
                        header="Register User"
                        :modal="true"
                    >
                        <div
                            v-if="form.selected_role == 'resident'"
                            class="grid"
                        >
                            <div class="col-12 title-form">
                                <Badge
                                    :value="1"
                                    severity="info"
                                    class="mr-2 mb-2"
                                    size="large"
                                ></Badge>
                                <label><h6>Basic Information</h6></label>
                            </div>

                            <div class="p-fluid formgrid grid">
                                <div class="field col-12 md:col-6">
                                    <label>Firstname</label>

                                    <InputText
                                        id="firstname"
                                        type="text"
                                        v-model="form.first_name"
                                        :class="{
                                            'p-invalid': error_first_name,
                                        }"
                                        @keydown.enter="onRegisterClick"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_first_name"
                                        >{{ error_first_name }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-6">
                                    <label>Lastname</label>

                                    <InputText
                                        id="last_name"
                                        type="text"
                                        v-model="form.last_name"
                                        :class="{
                                            'p-invalid': error_last_name,
                                        }"
                                        @keydown.enter="onRegisterClick"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_last_name"
                                        >{{ error_last_name }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-6">
                                    <div>
                                        <label>Gender</label>
                                    </div>

                                    <div>
                                        <div class="field-radiobutton mb-0">
                                            <RadioButton
                                                name="gender"
                                                value="male"
                                                v-model="form.gender"
                                                :class="{
                                                    'p-invalid': error_gender,
                                                }"
                                                @keydown.enter="onRegisterClick"
                                            />
                                            <label class="mb-0 ml-1 mr-5"
                                                >Male</label
                                            >
                                            <RadioButton
                                                name="gender"
                                                value="female"
                                                :class="{
                                                    'p-invalid': error_gender,
                                                }"
                                                v-model="form.gender"
                                                @keydown.enter="onRegisterClick"
                                            />
                                            <label class="mb-0 ml-1"
                                                >Female</label
                                            >
                                        </div>
                                        <div>
                                            <label
                                                style="color: red"
                                                v-if="error_gender"
                                                >{{ error_gender }}</label
                                            >
                                        </div>
                                    </div>
                                </div>

                                <div class="field col-12 md:col-6">
                                    <label>Age</label>
                                    <InputText
                                        id="age"
                                        type="number"
                                        min="0"
                                        step="1"
                                        onfocus="this.previousValue = this.value"
                                        onkeydown="this.previousValue = this.value"
                                        oninput="validity.valid || (value = this.previousValue)"
                                        v-model="form.age"
                                        :class="{
                                            'p-invalid': error_age,
                                        }"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_age"
                                        >{{ error_age }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-6">
                                    <label>Block</label>

                                    <Dropdown
                                        v-model="form.selected_block"
                                        :options="blocks"
                                        optionLabel="number"
                                        optionValue="number"
                                        placeholder="Select Block"
                                        @change="
                                            getBlockLot(form.selected_block)
                                        "
                                        :class="{
                                            'p-invalid': error_selected_block,
                                        }"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_selected_block"
                                        >{{ error_selected_block }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-6">
                                    <label>Lot</label>

                                    <Dropdown
                                        v-model="form.selected_block_lot"
                                        :options="filteredLots"
                                        optionLabel="number"
                                        optionValue="id"
                                        placeholder="Select Lot"
                                        :class="{
                                            'p-invalid': error_selected_lot,
                                        }"
                                        :disabled="
                                            form.selected_block ? false : true
                                        "
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_selected_lot"
                                        >{{ error_selected_lot }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-6">
                                    <label>Role</label>

                                    <Dropdown
                                        v-model="form.selected_role"
                                        :class="{
                                            'p-invalid': error_role,
                                        }"
                                        :options="role"
                                        optionLabel="role"
                                        optionValue="role"
                                        placeholder="Select Role"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_role"
                                        >{{ error_role }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-6">
                                    <label>Tag as</label>

                                    <Dropdown
                                        v-model="form.selected_tag"
                                        :class="{
                                            'p-invalid': error_selected_tag,
                                        }"
                                        :options="tag"
                                        optionLabel="tag"
                                        optionValue="tag"
                                        placeholder="Select tag"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_selected_tag"
                                        >{{ error_selected_tag }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-12">
                                    <label>Contact Number</label>
                                    <div class="p-inputgroup">
                                        <span class="p-inputgroup-addon">
                                            +63 </span
                                        ><InputMask
                                            mask="(999) 99-999-9999"
                                            placeholder="(639) 99-999-9999"
                                            :unmask="true"
                                            id="contact_num"
                                            type="text"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                            v-model="form.contact_num"
                                            @keydown.enter="onRegisterClick"
                                            :class="{
                                                'p-invalid': error_contact_num,
                                            }"
                                        />
                                    </div>

                                    <label
                                        style="color: red"
                                        v-if="error_contact_num"
                                        >{{ error_contact_num }}</label
                                    >
                                </div>

                                <br />

                                <div class="col-12 title-form">
                                    <Badge
                                        :value="2"
                                        severity="info"
                                        class="mr-2 mb-2"
                                        size="large"
                                    ></Badge>
                                    <label><h6>Security Information</h6></label>
                                </div>

                                <div class="field col-12 md:col-12">
                                    <label>Email</label>
                                    <InputText
                                        type="text"
                                        name="email"
                                        v-model="form.email"
                                        @keydown.enter="onRegisterClick"
                                        :class="{
                                            'p-invalid': error_email,
                                        }"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_email"
                                        >{{ error_email }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-12">
                                    <label>Password</label>
                                    <InputText
                                        type="password"
                                        name="password"
                                        v-model="form.password"
                                        @keydown.enter="onRegisterClick"
                                        :class="{
                                            'p-invalid': error_password,
                                        }"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_password"
                                        >{{ error_password }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-12">
                                    <label>Confirm Password</label>

                                    <InputText
                                        type="password"
                                        name="confirmpassword"
                                        v-model="form.confirm_password"
                                        @keydown.enter="onRegisterClick"
                                        :class="{
                                            'p-invalid': error_confirm_password,
                                        }"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_confirm_password"
                                        >{{ error_confirm_password }}</label
                                    >
                                </div>
                            </div>
                        </div>
                        <div
                            v-else-if="form.selected_role == 'officer'"
                            class="grid"
                        >
                            <div class="col-12 title-form">
                                <Badge
                                    :value="1"
                                    severity="info"
                                    class="mr-2 mb-2"
                                    size="large"
                                ></Badge>
                                <label><h6>Basic Information</h6></label>
                            </div>

                            <div class="p-fluid formgrid grid">
                                <div class="field col-12 md:col-6">
                                    <label>Firstname</label>

                                    <InputText
                                        id="firstname"
                                        type="text"
                                        v-model="form.first_name"
                                        :class="{
                                            'p-invalid': error_first_name,
                                        }"
                                        @keydown.enter="onRegisterClick"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_first_name"
                                        >{{ error_first_name }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-6">
                                    <label>Lastname</label>

                                    <InputText
                                        id="last_name"
                                        type="text"
                                        v-model="form.last_name"
                                        :class="{
                                            'p-invalid': error_last_name,
                                        }"
                                        @keydown.enter="onRegisterClick"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_last_name"
                                        >{{ error_last_name }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-6">
                                    <div>
                                        <label>Gender</label>
                                    </div>

                                    <div>
                                        <div class="field-radiobutton mb-0">
                                            <RadioButton
                                                name="gender"
                                                value="male"
                                                v-model="form.gender"
                                                :class="{
                                                    'p-invalid': error_gender,
                                                }"
                                                @keydown.enter="onRegisterClick"
                                            />
                                            <label class="mb-0 ml-1 mr-5"
                                                >Male</label
                                            >
                                            <RadioButton
                                                name="gender"
                                                value="female"
                                                :class="{
                                                    'p-invalid': error_gender,
                                                }"
                                                v-model="form.gender"
                                                @keydown.enter="onRegisterClick"
                                            />
                                            <label class="mb-0 ml-1"
                                                >Female</label
                                            >
                                        </div>
                                        <div>
                                            <label
                                                style="color: red"
                                                v-if="error_gender"
                                                >{{ error_gender }}</label
                                            >
                                        </div>
                                    </div>
                                </div>

                                <div class="field col-12 md:col-6">
                                    <label>Age</label>
                                    <InputText
                                        id="age"
                                        type="number"
                                        min="0"
                                        step="1"
                                        onfocus="this.previousValue = this.value"
                                        onkeydown="this.previousValue = this.value"
                                        oninput="validity.valid || (value = this.previousValue)"
                                        v-model="form.age"
                                        :class="{
                                            'p-invalid': error_age,
                                        }"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_age"
                                        >{{ error_age }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-6">
                                    <label>Block</label>

                                    <Dropdown
                                        v-model="form.selected_block"
                                        :options="blocks"
                                        optionLabel="number"
                                        optionValue="number"
                                        placeholder="Select Block"
                                        @change="
                                            getBlockLot(form.selected_block)
                                        "
                                        :class="{
                                            'p-invalid': error_selected_block,
                                        }"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_selected_block"
                                        >{{ error_selected_block }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-6">
                                    <label>Lot</label>

                                    <Dropdown
                                        v-model="form.selected_block_lot"
                                        :options="filteredLots"
                                        optionLabel="number"
                                        optionValue="id"
                                        placeholder="Select Lot"
                                        :class="{
                                            'p-invalid': error_selected_lot,
                                        }"
                                        :disabled="
                                            form.selected_block ? false : true
                                        "
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_selected_lot"
                                        >{{ error_selected_lot }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-6">
                                    <label>Tag as</label>

                                    <Dropdown
                                        v-model="form.selected_tag"
                                        :class="{
                                            'p-invalid': error_selected_tag,
                                        }"
                                        :options="tag"
                                        optionLabel="tag"
                                        optionValue="tag"
                                        placeholder="Select tag"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_selected_tag"
                                        >{{ error_selected_tag }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-6">
                                    <label>Contact Number</label>
                                    <div class="p-inputgroup">
                                        <span class="p-inputgroup-addon">
                                            +63 </span
                                        ><InputMask
                                            mask="(999) 99-999-9999"
                                            placeholder="(639) 99-999-9999"
                                            :unmask="true"
                                            id="contact_num"
                                            type="text"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                            v-model="form.contact_num"
                                            @keydown.enter="onRegisterClick"
                                            :class="{
                                                'p-invalid': error_contact_num,
                                            }"
                                        />
                                    </div>

                                    <label
                                        style="color: red"
                                        v-if="error_contact_num"
                                        >{{ error_contact_num }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-6">
                                    <label>Role</label>

                                    <Dropdown
                                        v-model="form.selected_role"
                                        :class="{
                                            'p-invalid': error_role,
                                        }"
                                        :options="role"
                                        optionLabel="role"
                                        optionValue="role"
                                        placeholder="Select Role"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_role"
                                        >{{ error_role }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-6">
                                    <label>Position</label>

                                    <Dropdown
                                        v-model="form.selected_position"
                                        :class="{
                                            'p-invalid':
                                                error_selected_position,
                                        }"
                                        :options="positions"
                                        optionLabel="name"
                                        optionValue="id"
                                        placeholder="Select Position"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_selected_position"
                                        >{{ error_selected_position }}</label
                                    >
                                </div>

                                <div class="col-12 title-form">
                                    <Badge
                                        :value="2"
                                        severity="info"
                                        class="mr-2 mb-2"
                                        size="large"
                                    ></Badge>
                                    <label><h6>Security Information</h6></label>
                                </div>

                                <div class="field col-12 md:col-4">
                                    <label>Email</label>
                                    <InputText
                                        type="text"
                                        name="email"
                                        v-model="form.email"
                                        @keydown.enter="onRegisterClick"
                                        :class="{
                                            'p-invalid': error_email,
                                        }"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_email"
                                        >{{ error_email }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-4">
                                    <label>Password</label>
                                    <InputText
                                        type="password"
                                        name="password"
                                        v-model="form.password"
                                        @keydown.enter="onRegisterClick"
                                        :class="{
                                            'p-invalid': error_password,
                                        }"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_password"
                                        >{{ error_password }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-4">
                                    <label>Confirm Password</label>

                                    <InputText
                                        type="password"
                                        name="confirmpassword"
                                        v-model="form.confirm_password"
                                        @keydown.enter="onRegisterClick"
                                        :class="{
                                            'p-invalid': error_confirm_password,
                                        }"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_confirm_password"
                                        >{{ error_confirm_password }}</label
                                    >
                                </div>

                                <br />
                            </div>
                        </div>
                        <div v-else class="grid">
                            <div class="col-12 title-form">
                                <Badge
                                    :value="1"
                                    severity="info"
                                    class="mr-2 mb-2"
                                    size="large"
                                ></Badge>
                                <label><h6>Basic Information</h6></label>
                            </div>

                            <div class="p-fluid formgrid grid">
                                <div class="field col-12 md:col-6">
                                    <label>Firstname</label>

                                    <InputText
                                        id="firstname"
                                        type="text"
                                        v-model="form.first_name"
                                        :class="{
                                            'p-invalid': error_first_name,
                                        }"
                                        @keydown.enter="onRegisterClick"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_first_name"
                                        >{{ error_first_name }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-6">
                                    <label>Lastname</label>

                                    <InputText
                                        id="last_name"
                                        type="text"
                                        v-model="form.last_name"
                                        :class="{
                                            'p-invalid': error_last_name,
                                        }"
                                        @keydown.enter="onRegisterClick"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_last_name"
                                        >{{ error_last_name }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-6">
                                    <div>
                                        <label>Gender</label>
                                    </div>

                                    <div>
                                        <div class="field-radiobutton mb-0">
                                            <RadioButton
                                                name="gender"
                                                value="male"
                                                v-model="form.gender"
                                                :class="{
                                                    'p-invalid': error_gender,
                                                }"
                                                @keydown.enter="onRegisterClick"
                                            />
                                            <label class="mb-0 ml-1 mr-5"
                                                >Male</label
                                            >
                                            <RadioButton
                                                name="gender"
                                                value="female"
                                                :class="{
                                                    'p-invalid': error_gender,
                                                }"
                                                v-model="form.gender"
                                                @keydown.enter="onRegisterClick"
                                            />
                                            <label class="mb-0 ml-1"
                                                >Female</label
                                            >
                                        </div>
                                        <div>
                                            <label
                                                style="color: red"
                                                v-if="error_gender"
                                                >{{ error_gender }}</label
                                            >
                                        </div>
                                    </div>
                                </div>
                                <div class="field col-12 md:col-6">
                                    <label>Age</label>
                                    <InputText
                                        id="age"
                                        type="number"
                                        min="0"
                                        step="1"
                                        onfocus="this.previousValue = this.value"
                                        onkeydown="this.previousValue = this.value"
                                        oninput="validity.valid || (value = this.previousValue)"
                                        v-model="form.age"
                                        :class="{
                                            'p-invalid': error_age,
                                        }"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_age"
                                        >{{ error_age }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-12">
                                    <label>Role</label>

                                    <Dropdown
                                        v-model="form.selected_role"
                                        :class="{
                                            'p-invalid': error_role,
                                        }"
                                        :options="role"
                                        optionLabel="role"
                                        optionValue="role"
                                        placeholder="Select Role"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_role"
                                        >{{ error_role }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-12">
                                    <label>Contact Number</label>
                                    <div class="p-inputgroup">
                                        <span class="p-inputgroup-addon">
                                            +63 </span
                                        ><InputMask
                                            mask="(999) 99-999-9999"
                                            placeholder="(639) 99-999-9999"
                                            :unmask="true"
                                            id="contact_num"
                                            type="text"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                            v-model="form.contact_num"
                                            @keydown.enter="onRegisterClick"
                                            :class="{
                                                'p-invalid': error_contact_num,
                                            }"
                                        />
                                    </div>

                                    <label
                                        style="color: red"
                                        v-if="error_contact_num"
                                        >{{ error_contact_num }}</label
                                    >
                                </div>

                                <div class="col-12 title-form">
                                    <Badge
                                        :value="2"
                                        severity="info"
                                        class="mr-2 mb-2"
                                        size="large"
                                    ></Badge>
                                    <label><h6>Security Information</h6></label>
                                </div>

                                <div class="field col-12 md:col-4">
                                    <label>Email</label>
                                    <InputText
                                        type="text"
                                        name="email"
                                        v-model="form.email"
                                        @keydown.enter="onRegisterClick"
                                        :class="{
                                            'p-invalid': error_email,
                                        }"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_email"
                                        >{{ error_email }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-4">
                                    <label>Password</label>
                                    <InputText
                                        type="password"
                                        name="password"
                                        v-model="form.password"
                                        @keydown.enter="onRegisterClick"
                                        :class="{
                                            'p-invalid': error_password,
                                        }"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_password"
                                        >{{ error_password }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-4">
                                    <label>Confirm Password</label>

                                    <InputText
                                        type="password"
                                        name="confirmpassword"
                                        v-model="form.confirm_password"
                                        @keydown.enter="onRegisterClick"
                                        :class="{
                                            'p-invalid': error_confirm_password,
                                        }"
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_confirm_password"
                                        >{{ error_confirm_password }}</label
                                    >
                                </div>
                            </div>
                        </div>
                        <template #footer>
                            <Button
                                label="Cancel"
                                icon="pi pi-times"
                                class="p-button-text"
                                @click="registerUserDialog = false"
                            />
                            <Button
                                label="Register"
                                icon="pi pi-check"
                                class="p-button-text p-button-success"
                                @click="onRegisterClick"
                            />
                        </template>
                    </Dialog>
                    <Dialog
                        v-model:visible="viewUserDialog"
                        :style="{ width: '500px' }"
                        header="View User"
                        :modal="true"
                    >
                        <div
                            v-if="form.selected_role == 'resident'"
                            class="grid"
                        >
                            <div class="col-12 title-form">
                                <Badge
                                    :value="1"
                                    severity="info"
                                    class="mr-2 mb-2"
                                    size="large"
                                ></Badge>
                                <label><h6>Basic Information</h6></label>
                            </div>

                            <div class="p-fluid formgrid grid">
                                <div class="field col-12 md:col-6">
                                    <label>Firstname</label>

                                    <InputText
                                        id="firstname"
                                        type="text"
                                        v-model="form.first_name"
                                        :class="{
                                            'p-invalid': error_first_name,
                                        }"
                                        @keydown.enter="onRegisterClick"
                                        disabled
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_first_name"
                                        >{{ error_first_name }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-6">
                                    <label>Lastname</label>

                                    <InputText
                                        id="last_name"
                                        type="text"
                                        v-model="form.last_name"
                                        :class="{
                                            'p-invalid': error_last_name,
                                        }"
                                        @keydown.enter="onRegisterClick"
                                        disabled
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_last_name"
                                        >{{ error_last_name }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-6">
                                    <div>
                                        <label>Gender</label>
                                    </div>

                                    <div>
                                        <div class="field-radiobutton mb-0">
                                            <RadioButton
                                                name="gender"
                                                value="male"
                                                v-model="form.gender"
                                                :class="{
                                                    'p-invalid': error_gender,
                                                }"
                                                @keydown.enter="onRegisterClick"
                                                :disabled="true"
                                            />
                                            <label class="mb-0 ml-1 mr-5"
                                                >Male</label
                                            >
                                            <RadioButton
                                                name="gender"
                                                value="female"
                                                :class="{
                                                    'p-invalid': error_gender,
                                                }"
                                                v-model="form.gender"
                                                @keydown.enter="onRegisterClick"
                                                :disabled="true"
                                            />
                                            <label class="mb-0 ml-1"
                                                >Female</label
                                            >
                                        </div>
                                        <div>
                                            <label
                                                style="color: red"
                                                v-if="error_gender"
                                                >{{ error_gender }}</label
                                            >
                                        </div>
                                    </div>
                                </div>

                                <div class="field col-12 md:col-6">
                                    <label>Age</label>
                                    <InputText
                                        id="age"
                                        type="number"
                                        min="0"
                                        step="1"
                                        onfocus="this.previousValue = this.value"
                                        onkeydown="this.previousValue = this.value"
                                        oninput="validity.valid || (value = this.previousValue)"
                                        v-model="form.age"
                                        :class="{
                                            'p-invalid': error_age,
                                        }"
                                        disabled
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_age"
                                        >{{ error_age }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-6">
                                    <label>Block</label>

                                    <Dropdown
                                        v-model="form.selected_block"
                                        :options="blocks"
                                        optionLabel="number"
                                        optionValue="number"
                                        placeholder="Select Block"
                                        @change="
                                            getBlockLot(form.selected_block)
                                        "
                                        :class="{
                                            'p-invalid': error_selected_block,
                                        }"
                                        disabled
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_selected_block"
                                        >{{ error_selected_block }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-6">
                                    <label>Lot</label>

                                    <Dropdown
                                        v-model="form.selected_block_lot"
                                        :options="filteredLots"
                                        optionLabel="number"
                                        optionValue="id"
                                        placeholder="Select Lot"
                                        :class="{
                                            'p-invalid': error_selected_lot,
                                        }"
                                        disabled
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_selected_lot"
                                        >{{ error_selected_lot }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-6">
                                    <label>Role</label>

                                    <Dropdown
                                        v-model="form.selected_role"
                                        :class="{
                                            'p-invalid': error_role,
                                        }"
                                        :options="role"
                                        optionLabel="role"
                                        optionValue="role"
                                        placeholder="Select Role"
                                        disabled
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_role"
                                        >{{ error_role }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-6">
                                    <label>Tag as</label>

                                    <Dropdown
                                        v-model="form.selected_tag"
                                        :class="{
                                            'p-invalid': error_selected_tag,
                                        }"
                                        :options="tag"
                                        optionLabel="tag"
                                        optionValue="tag"
                                        placeholder="Select tag"
                                        disabled
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_selected_tag"
                                        >{{ error_selected_tag }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-12">
                                    <label>Contact Number</label>
                                    <div class="p-inputgroup">
                                        <span class="p-inputgroup-addon">
                                            +63 </span
                                        ><InputMask
                                            mask="(999) 99-999-9999"
                                            placeholder="(639) 99-999-9999"
                                            :unmask="true"
                                            id="contact_num"
                                            type="text"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                            v-model="form.contact_num"
                                            @keydown.enter="onRegisterClick"
                                            :class="{
                                                'p-invalid': error_contact_num,
                                            }"
                                            disabled
                                        />
                                    </div>

                                    <label
                                        style="color: red"
                                        v-if="error_contact_num"
                                        >{{ error_contact_num }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-12">
                                    <label>Email</label>
                                    <InputText
                                        type="text"
                                        v-model="form.email"
                                        @keydown.enter="onRegisterClick"
                                        :class="{
                                            'p-invalid': error_email,
                                        }"
                                        disabled
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_email"
                                        >{{ error_email }}</label
                                    >
                                </div>

                                <br />
                            </div>
                        </div>
                        <div
                            v-else-if="form.selected_role == 'officer'"
                            class="grid"
                        >
                            <div class="col-12 title-form">
                                <Badge
                                    :value="1"
                                    severity="info"
                                    class="mr-2 mb-2"
                                    size="large"
                                ></Badge>
                                <label><h6>Basic Information</h6></label>
                            </div>

                            <div class="p-fluid formgrid grid">
                                <div class="field col-12 md:col-6">
                                    <label>Firstname</label>

                                    <InputText
                                        id="firstname"
                                        type="text"
                                        v-model="form.first_name"
                                        :class="{
                                            'p-invalid': error_first_name,
                                        }"
                                        @keydown.enter="onRegisterClick"
                                        disabled
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_first_name"
                                        >{{ error_first_name }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-6">
                                    <label>Lastname</label>

                                    <InputText
                                        id="last_name"
                                        type="text"
                                        v-model="form.last_name"
                                        :class="{
                                            'p-invalid': error_last_name,
                                        }"
                                        @keydown.enter="onRegisterClick"
                                        disabled
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_last_name"
                                        >{{ error_last_name }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-6">
                                    <div>
                                        <label>Gender</label>
                                    </div>

                                    <div>
                                        <div class="field-radiobutton mb-0">
                                            <RadioButton
                                                name="gender"
                                                value="male"
                                                v-model="form.gender"
                                                :class="{
                                                    'p-invalid': error_gender,
                                                }"
                                                @keydown.enter="onRegisterClick"
                                                :disabled="true"
                                            />
                                            <label class="mb-0 ml-1 mr-5"
                                                >Male</label
                                            >
                                            <RadioButton
                                                name="gender"
                                                value="female"
                                                :class="{
                                                    'p-invalid': error_gender,
                                                }"
                                                v-model="form.gender"
                                                @keydown.enter="onRegisterClick"
                                                :disabled="true"
                                            />
                                            <label class="mb-0 ml-1"
                                                >Female</label
                                            >
                                        </div>
                                        <div>
                                            <label
                                                style="color: red"
                                                v-if="error_gender"
                                                >{{ error_gender }}</label
                                            >
                                        </div>
                                    </div>
                                </div>

                                <div class="field col-12 md:col-6">
                                    <label>Age</label>
                                    <InputText
                                        id="age"
                                        type="number"
                                        min="0"
                                        step="1"
                                        onfocus="this.previousValue = this.value"
                                        onkeydown="this.previousValue = this.value"
                                        oninput="validity.valid || (value = this.previousValue)"
                                        v-model="form.age"
                                        :class="{
                                            'p-invalid': error_age,
                                        }"
                                        disabled
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_age"
                                        >{{ error_age }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-6">
                                    <label>Block</label>

                                    <Dropdown
                                        v-model="form.selected_block"
                                        :options="blocks"
                                        optionLabel="number"
                                        optionValue="number"
                                        placeholder="Select Block"
                                        @change="
                                            getBlockLot(form.selected_block)
                                        "
                                        :class="{
                                            'p-invalid': error_selected_block,
                                        }"
                                        disabled
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_selected_block"
                                        >{{ error_selected_block }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-6">
                                    <label>Lot</label>

                                    <Dropdown
                                        v-model="form.selected_block_lot"
                                        :options="filteredLots"
                                        optionLabel="number"
                                        optionValue="id"
                                        placeholder="Select Lot"
                                        :class="{
                                            'p-invalid': error_selected_lot,
                                        }"
                                        disabled
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_selected_lot"
                                        >{{ error_selected_lot }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-6">
                                    <label>Tag as</label>

                                    <Dropdown
                                        v-model="form.selected_tag"
                                        :class="{
                                            'p-invalid': error_selected_tag,
                                        }"
                                        :options="tag"
                                        optionLabel="tag"
                                        optionValue="tag"
                                        placeholder="Select tag"
                                        disabled
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_selected_tag"
                                        >{{ error_selected_tag }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-6">
                                    <label>Contact Number</label>
                                    <div class="p-inputgroup">
                                        <span class="p-inputgroup-addon">
                                            +63 </span
                                        ><InputMask
                                            mask="(999) 99-999-9999"
                                            placeholder="(639) 99-999-9999"
                                            :unmask="true"
                                            id="contact_num"
                                            type="text"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                            v-model="form.contact_num"
                                            @keydown.enter="onRegisterClick"
                                            :class="{
                                                'p-invalid': error_contact_num,
                                            }"
                                            disabled
                                        />
                                    </div>

                                    <label
                                        style="color: red"
                                        v-if="error_contact_num"
                                        >{{ error_contact_num }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-6">
                                    <label>Role</label>

                                    <Dropdown
                                        v-model="form.selected_role"
                                        :class="{
                                            'p-invalid': error_role,
                                        }"
                                        :options="role"
                                        optionLabel="role"
                                        optionValue="role"
                                        placeholder="Select Role"
                                        disabled
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_role"
                                        >{{ error_role }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-6">
                                    <label>Position</label>

                                    <Dropdown
                                        v-model="form.selected_position"
                                        :class="{
                                            'p-invalid':
                                                error_selected_position,
                                        }"
                                        :options="positions"
                                        optionLabel="name"
                                        optionValue="id"
                                        placeholder="Select Position"
                                        disabled
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_selected_position"
                                        >{{ error_selected_position }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-12">
                                    <label>Email</label>
                                    <InputText
                                        type="text"
                                        v-model="form.email"
                                        @keydown.enter="onRegisterClick"
                                        :class="{
                                            'p-invalid': error_email,
                                        }"
                                        disabled
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_email"
                                        >{{ error_email }}</label
                                    >
                                </div>

                                <br />
                            </div>
                        </div>
                        <div v-else class="grid">
                            <div class="col-12 title-form">
                                <Badge
                                    :value="1"
                                    severity="info"
                                    class="mr-2 mb-2"
                                    size="large"
                                ></Badge>
                                <label><h6>Basic Information</h6></label>
                            </div>

                            <div class="p-fluid formgrid grid">
                                <div class="field col-12 md:col-6">
                                    <label>Firstname</label>

                                    <InputText
                                        id="firstname"
                                        type="text"
                                        v-model="form.first_name"
                                        :class="{
                                            'p-invalid': error_first_name,
                                        }"
                                        @keydown.enter="onRegisterClick"
                                        disabled
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_first_name"
                                        >{{ error_first_name }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-6">
                                    <label>Lastname</label>

                                    <InputText
                                        id="last_name"
                                        type="text"
                                        v-model="form.last_name"
                                        :class="{
                                            'p-invalid': error_last_name,
                                        }"
                                        @keydown.enter="onRegisterClick"
                                        disabled
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_last_name"
                                        >{{ error_last_name }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-6">
                                    <div>
                                        <label>Gender</label>
                                    </div>

                                    <div>
                                        <div class="field-radiobutton mb-0">
                                            <RadioButton
                                                name="gender"
                                                value="male"
                                                v-model="form.gender"
                                                :class="{
                                                    'p-invalid': error_gender,
                                                }"
                                                @keydown.enter="onRegisterClick"
                                                :disabled="true"
                                            />
                                            <label class="mb-0 ml-1 mr-5"
                                                >Male</label
                                            >
                                            <RadioButton
                                                name="gender"
                                                value="female"
                                                :class="{
                                                    'p-invalid': error_gender,
                                                }"
                                                v-model="form.gender"
                                                @keydown.enter="onRegisterClick"
                                                :disabled="true"
                                            />
                                            <label class="mb-0 ml-1"
                                                >Female</label
                                            >
                                        </div>
                                        <div>
                                            <label
                                                style="color: red"
                                                v-if="error_gender"
                                                >{{ error_gender }}</label
                                            >
                                        </div>
                                    </div>
                                </div>
                                <div class="field col-12 md:col-6">
                                    <label>Age</label>
                                    <InputText
                                        id="age"
                                        type="number"
                                        min="0"
                                        step="1"
                                        onfocus="this.previousValue = this.value"
                                        onkeydown="this.previousValue = this.value"
                                        oninput="validity.valid || (value = this.previousValue)"
                                        v-model="form.age"
                                        :class="{
                                            'p-invalid': error_age,
                                        }"
                                        disabled
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_age"
                                        >{{ error_age }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-12">
                                    <label>Role</label>

                                    <Dropdown
                                        v-model="form.selected_role"
                                        :class="{
                                            'p-invalid': error_role,
                                        }"
                                        :options="role"
                                        optionLabel="role"
                                        optionValue="role"
                                        placeholder="Select Role"
                                        disabled
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_role"
                                        >{{ error_role }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-12">
                                    <label>Contact Number</label>
                                    <div class="p-inputgroup">
                                        <span class="p-inputgroup-addon">
                                            +63 </span
                                        ><InputMask
                                            mask="(999) 99-999-9999"
                                            placeholder="(639) 99-999-9999"
                                            :unmask="true"
                                            id="contact_num"
                                            type="text"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                            v-model="form.contact_num"
                                            @keydown.enter="onRegisterClick"
                                            :class="{
                                                'p-invalid': error_contact_num,
                                            }"
                                            disabled
                                        />
                                    </div>

                                    <label
                                        style="color: red"
                                        v-if="error_contact_num"
                                        >{{ error_contact_num }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-12">
                                    <label>Email</label>
                                    <InputText
                                        type="text"
                                        v-model="form.email"
                                        @keydown.enter="onRegisterClick"
                                        :class="{
                                            'p-invalid': error_email,
                                        }"
                                        disabled
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_email"
                                        >{{ error_email }}</label
                                    >
                                </div>
                            </div>
                        </div>
                    </Dialog>
                    <Dialog
                        v-model:visible="viewVerifytDialog"
                        :style="{ width: '500px' }"
                        header="Verify Resident"
                        :modal="true"
                    >
                        <div class="grid">
                            <div class="col-12 title-form">
                                <Badge
                                    :value="1"
                                    severity="info"
                                    class="mr-2 mb-2"
                                    size="large"
                                ></Badge>
                                <label><h6>Basic Information</h6></label>
                            </div>

                            <div class="p-fluid formgrid grid">
                                <div class="field col-12 md:col-6">
                                    <label>Firstname</label>

                                    <InputText
                                        id="firstname"
                                        type="text"
                                        v-model="form.first_name"
                                        :class="{
                                            'p-invalid': error_first_name,
                                        }"
                                        @keydown.enter="onRegisterClick"
                                        disabled
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_first_name"
                                        >{{ error_first_name }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-6">
                                    <label>Lastname</label>

                                    <InputText
                                        id="last_name"
                                        type="text"
                                        v-model="form.last_name"
                                        :class="{
                                            'p-invalid': error_last_name,
                                        }"
                                        @keydown.enter="onRegisterClick"
                                        disabled
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_last_name"
                                        >{{ error_last_name }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-6">
                                    <div>
                                        <label>Gender</label>
                                    </div>

                                    <div>
                                        <div class="field-radiobutton mb-0">
                                            <RadioButton
                                                name="gender"
                                                value="male"
                                                v-model="form.gender"
                                                :disabled="true"
                                                :class="{
                                                    'p-invalid': error_gender,
                                                }"
                                                @keydown.enter="onRegisterClick"
                                            />
                                            <label class="mb-0 ml-1 mr-5"
                                                >Male</label
                                            >
                                            <RadioButton
                                                name="gender"
                                                value="female"
                                                :disabled="true"
                                                :class="{
                                                    'p-invalid': error_gender,
                                                }"
                                                v-model="form.gender"
                                                @keydown.enter="onRegisterClick"
                                            />
                                            <label class="mb-0 ml-1"
                                                >Female</label
                                            >
                                        </div>
                                        <div>
                                            <label
                                                style="color: red"
                                                v-if="error_gender"
                                                >{{ error_gender }}</label
                                            >
                                        </div>
                                    </div>
                                </div>
                                <div class="field col-12 md:col-6">
                                    <label>Age</label>
                                    <InputText
                                        id="age"
                                        type="number"
                                        min="0"
                                        step="1"
                                        onfocus="this.previousValue = this.value"
                                        onkeydown="this.previousValue = this.value"
                                        oninput="validity.valid || (value = this.previousValue)"
                                        v-model="form.age"
                                        :class="{
                                            'p-invalid': error_age,
                                        }"
                                        disabled
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_age"
                                        >{{ error_age }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-6">
                                    <label>Block</label>

                                    <Dropdown
                                        v-model="form.selected_block"
                                        :options="blocks"
                                        optionLabel="number"
                                        optionValue="number"
                                        placeholder="Select Block"
                                        @change="
                                            getBlockLot(form.selected_block)
                                        "
                                        :class="{
                                            'p-invalid': error_selected_block,
                                        }"
                                        disabled
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_selected_block"
                                        >{{ error_selected_block }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-6">
                                    <label>Lot</label>

                                    <Dropdown
                                        v-model="form.selected_block_lot"
                                        :options="filteredLots"
                                        optionLabel="number"
                                        optionValue="id"
                                        placeholder="Select Lot"
                                        :class="{
                                            'p-invalid': error_selected_lot,
                                        }"
                                        disabled
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_selected_lot"
                                        >{{ error_selected_lot }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-6">
                                    <label>Role</label>

                                    <Dropdown
                                        v-model="form.selected_role"
                                        :class="{
                                            'p-invalid': error_role,
                                        }"
                                        :options="role"
                                        optionLabel="type"
                                        optionValue="value"
                                        placeholder="Select Role"
                                        disabled
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_role"
                                        >{{ error_role }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-6">
                                    <label>Tag as</label>

                                    <Dropdown
                                        v-model="form.selected_tag"
                                        :class="{
                                            'p-invalid': error_selected_tag,
                                        }"
                                        :options="tag"
                                        optionLabel="tag"
                                        optionValue="tag"
                                        placeholder="Select tag"
                                        disabled
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_selected_tag"
                                        >{{ error_selected_tag }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-12">
                                    <label>Contact Number</label>
                                    <div class="p-inputgroup">
                                        <span class="p-inputgroup-addon">
                                            +63
                                        </span>
                                        <InputMask
                                            mask="(999) 99-999-9999"
                                            placeholder="(639) 99-999-9999"
                                            :unmask="true"
                                            id="contact_num"
                                            type="text"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                            v-model="form.contact_num"
                                            @keydown.enter="onRegisterClick"
                                            :class="{
                                                'p-invalid': error_contact_num,
                                            }"
                                            disabled
                                        />
                                    </div>

                                    <label
                                        style="color: red"
                                        v-if="error_contact_num"
                                        >{{ error_contact_num }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-12">
                                    <label>Email</label>
                                    <InputText
                                        type="text"
                                        v-model="form.email"
                                        @keydown.enter="onRegisterClick"
                                        :class="{
                                            'p-invalid': error_email,
                                        }"
                                        disabled
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_email"
                                        >{{ error_email }}</label
                                    >
                                </div>
                                <br />
                            </div>
                        </div>
                        <template #footer>
                            <Button
                                label="Cancel"
                                icon="pi pi-times"
                                class="p-button-text"
                                @click="viewVerifytDialog = false"
                            />
                            <Button
                                label="Verify"
                                icon="pi pi-check"
                                class="p-button-text p-button-success"
                                @click="verifyUser"
                            />
                        </template>
                    </Dialog>
                    <Dialog
                        v-model:visible="emergencyContactDialog"
                        :style="{ width: '500px' }"
                        header="Emergency Contacts"
                        :modal="true"
                    >
                        <DataTable :value="emergency_contacts" :rows="10">
                            <template #empty>
                                No emergency contacts found
                            </template>

                            <Column header="Contact Name" field="name">
                                <template #body="{ data }">
                                    {{ data.name }}
                                </template>
                            </Column>
                            <Column
                                header="Contact Number"
                                field="contact_number"
                            >
                                <template #body="{ data }">
                                    {{ data.contact_number }}
                                </template>
                            </Column>
                        </DataTable>
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
    name: "RegisterUsersComponent",
    setup() {
        const store = useStore();
        return {
            blocks: computed(() => store.state.blocks.blocks),
            filteredLots: computed(() => store.state.lots.filteredLots),
            lots: computed(() => store.state.lots.lots),
            users: computed(() => store.state.users),
            positions: computed(() => store.state.positions.positions),
            active: computed(() => {
                let active = [];

                store.state.users.forEach((elem) => {
                    if (elem.status == "active") {
                        active.push(elem);
                    }
                });
                return active.length;
            }),
            inactive: computed(() => {
                let inactive = [];

                store.state.users.forEach((elem) => {
                    if (elem.status == "inactive") {
                        inactive.push(elem);
                    }
                });
                return inactive.length;
            }),
            verified: computed(() => {
                let verified = [];

                store.state.users.forEach((elem) => {
                    if (elem.verified == 1) {
                        verified.push(elem);
                    }
                });
                return verified.length;
            }),
            not_verified: computed(() => {
                let not_verified = [];

                store.state.users.forEach((elem) => {
                    if (elem.verified == 0) {
                        not_verified.push(elem);
                    }
                });
                return not_verified.length;
            }),
            flagged: computed(() => {
                let flagged = [];

                store.state.users.forEach((elem) => {
                    if (elem.flagged == true) {
                        flagged.push(elem);
                    }
                });
                return flagged.length;
            }),
            not_flagged: computed(() => {
                let not_flagged = [];

                store.state.users.forEach((elem) => {
                    if (elem.flagged == false) {
                        not_flagged.push(elem);
                    }
                });
                return not_flagged.length;
            }),
            total: computed(() => {
                return store.state.users.length;
            }),
        };
    },
    data() {
        return {
            //menu

            menus: null,
            isInvalid: false,
            filters: {},
            id: null,
            name: null,
            loading: false,
            registerUserDialog: false,
            deleteUserDialog: false,
            updateUserDialog: false,
            viewUserDialog: false,
            viewVerifytDialog: false,
            form: {
                first_name: "",
                last_name: "",
                gender: "",
                selected_block: "",
                selected_block_lot: "",
                email: "",
                password: "",
                confirm_password: "",
                age: "",
                contact_num: "",
                selected_role: "resident",
                verified: "",

                status: "",
                selected_tag: "",
                selected_position: "",
                flagged: "",
            },

            first_name: null,
            last_name: null,
            gender: null,
            block_lot_id: null,
            email: null,
            password: null,
            confirm_password: null,
            verify: 1,

            age: null,
            contact_num: null,
            user: null,
            role: [
                { role: "admin" },
                { role: "resident" },
                { role: "officer" },
                { role: "security officer" },
            ],
            error_first_name: "",
            error_last_name: "",
            error_gender: "",
            error_selected_block: "",
            error_selected_lot: "",
            error_email: "",
            error_password: "",
            error_confirm_password: "",
            error_age: "",
            error_contact_num: "",
            error_role: "",

            role: [
                { role: "admin" },
                { role: "resident" },
                { role: "security officer" },
                { role: "officer" },
            ],
            status: [{ status: "active" }, { status: "inactive" }],
            tag: [
                { tag: "owner" },
                { tag: "renter" },
                { tag: "family member" },
            ],
            verification: [
                { status: "verified", value: 1 },
                { status: "not verified", value: 0 },
            ],
            flag_dropdown: [
                { status: "flagged", value: 1 },
                { status: "not flagged", value: 0 },
            ],
            emergencyContactDialog: false,
            emergency_contacts: null,
        };
    },
    methods: {
        async changeFlagStatus() {
            this.loading = true;

            await axios({
                method: "put",
                url: "/api/user/" + this.id,
                data: {
                    first_name: this.form.first_name,
                    last_name: this.form.last_name,
                    gender: this.form.gender,
                    block_lot_id: this.form.selected_block_lot,
                    email: this.form.email,
                    verified: this.form.verified,

                    age: this.form.age,
                    contact_num: this.form.contact_num,
                    role: this.form.selected_role,
                    status: this.form.status,
                    tag_as: this.form.selected_tag,
                    flagged: this.form.flagged ? false : true,
                },
            })
                .then(() => {
                    this.$toast.add({
                        severity: "success",
                        summary: "Successful",
                        detail:
                            this.form.flagged == false
                                ? "User Flagged"
                                : "User UnFlagged",
                        life: 3000,
                    });
                    this.$store.dispatch("getAllUsers");
                    this.resetFields();
                    this.loading = false;
                })
                .catch((err) => {
                    console.log(err.response);
                    this.resetErrors();
                    this.validate(err);
                    this.loading = false;
                });
        },
        async viewEmergencyContacts() {
            this.loading = true;
            await axios({
                method: "get",
                url: "/api/emergency-contact-detail/" + this.id,
            })
                .then((res) => {
                    console.log("emergency", res.data);
                    this.emergency_contacts = res.data;
                    this.emergencyContactDialog = true;
                    this.loading = false;
                })
                .catch((err) => {
                    console.log(err.response.data);
                });
        },
        viewUser() {
            this.viewUserDialog = true;
        },
        badgecolor(color) {
            if (color == "active") {
                return "bg-green-500";
            } else if (color == 1) {
                return "bg-orange-500";
            } else if (color == 0) {
                return "bg-gray-500";
            } else if (color == "admin") {
                return "bg-purple-500";
            } else if (color == "security officer") {
                return "bg-yellow-800";
            } else if (color == "resident") {
                return "bg-indigo-500";
            } else if (color == "officer") {
                return "bg-blue-500";
            } else {
                return "bg-pink-500";
            }
        },
        toggle(data) {
            this.$refs.menu.toggle(event);
            this.populateFields(data);
            this.menus = [];
            this.menus.push({
                label: `View ${data.role}`,
                icon: "pi pi-user",
                command: () => {
                    this.getBlockLot(this.form.selected_block_lot);
                    this.viewUser();
                },
            });
            this.menus.push({
                label: `Update ${data.role}`,
                icon: "pi pi-pencil",
                command: () => {
                    this.getBlockLot(this.form.selected_block_lot);
                    this.updateUser();
                },
            });
            this.menus.push({
                label: "Emergency Contacts",
                icon: "pi pi-id-card",
                command: () => {
                    this.getBlockLot(this.form.selected_block_lot);
                    this.viewEmergencyContacts();
                },
            });
            if (data.verified == false) {
                this.menus.push({
                    label: `Verify ${data.role}`,
                    icon: "pi pi-check",
                    command: () => {
                        this.getBlockLot(this.form.selected_block_lot);
                        this.viewVerifytDialog = true;
                    },
                });
            }
            if (data.status == "active") {
                this.menus.push({
                    label: `Deactivate ${data.role}`,
                    icon: "pi pi-lock",
                    command: () => {
                        this.getBlockLot(this.form.selected_block_lot);
                        this.changeStatus();
                    },
                });
            } else {
                this.menus.push({
                    label: `Activate ${data.role}`,
                    icon: "pi pi-unlock",
                    command: () => {
                        this.getBlockLot(this.form.selected_block_lot);
                        this.changeStatus();
                    },
                });
            }
            if (data.flagged == false) {
                this.menus.push({
                    label: `Flag ${data.role}`,
                    icon: "pi pi-flag-fill",
                    command: () => {
                        this.getBlockLot(this.form.selected_block_lot);
                        this.changeFlagStatus();
                    },
                });
            } else {
                this.menus.push({
                    label: `UnFlag ${data.role}`,
                    icon: "pi pi-flag",
                    command: () => {
                        this.getBlockLot(this.form.selected_block_lot);
                        this.changeFlagStatus();
                    },
                });
            }

            // if (data.status == "active" && data.verified == 1) {
            //     this.menus = [
            //         {
            //             label: `View ${data.role}`,
            //             icon: "pi pi-user",
            //             command: () => {},
            //         },
            //         {
            //             label: `Update ${data.role}`,
            //             icon: "pi pi-pencil",
            //             command: () => {},
            //         },
            //         {
            //             label: "Emergency Contacts",
            //             icon: "pi pi-id-card",
            //             command: () => {},
            //         },
            //         {
            //             label: `Deactivate ${data.role}`,
            //             icon: "pi pi-lock",
            //             command: () => {},
            //         },
            //     ];
            // } else if (data.status == "active" && data.verified == 0) {
            //     this.menus = [
            //         {
            //             label: `View ${data.role}`,
            //             icon: "pi pi-user",
            //             command: () => {
            //                 this.getBlockLot(this.form.selected_block_lot);
            //                 this.viewUser();
            //             },
            //         },
            //         {
            //             label: `Verify ${data.role}`,
            //             icon: "pi pi-check",
            //             command: () => {},
            //         },
            //         {
            //             label: `Update ${data.role}`,
            //             icon: "pi pi-pencil",
            //             command: () => {
            //                 this.getBlockLot(this.form.selected_block_lot);
            //                 this.updateUser();
            //             },
            //         },
            //         {
            //             label: "Emergency Contacts",
            //             icon: "pi pi-id-card",
            //             command: () => {
            //                 this.getBlockLot(this.form.selected_block_lot);
            //                 this.viewEmergencyContacts();
            //             },
            //         },
            //         {
            //             label: `Deactivate ${data.role}`,
            //             icon: "pi pi-unlock",
            //             command: () => {
            //                 this.getBlockLot(this.form.selected_block_lot);
            //                 this.changeStatus();
            //             },
            //         },
            //     ];
            // } else if (data.status == "inactive" && data.verified == 1) {
            //     this.menus = [
            //         {
            //             label: `View ${data.role}`,
            //             icon: "pi pi-user",
            //             command: () => {
            //                 this.getBlockLot(this.form.selected_block_lot);
            //                 this.viewUser();
            //             },
            //         },
            //         {
            //             label: `Update ${data.role}`,
            //             icon: "pi pi-pencil",
            //             command: () => {
            //                 this.getBlockLot(this.form.selected_block_lot);
            //                 this.updateUser();
            //             },
            //         },
            //         {
            //             label: "Emergency Contacts",
            //             icon: "pi pi-id-card",
            //             command: () => {
            //                 this.getBlockLot(this.form.selected_block_lot);
            //                 this.viewEmergencyContacts();
            //             },
            //         },
            //         {
            //             label: `Activate ${data.role}`,
            //             icon: "pi pi-unlock",
            //             command: () => {},
            //         },
            //     ];
            // } else {
            //     this.menus = [
            //         {
            //             label: `View ${data.role}`,
            //             icon: "pi pi-user",
            //             command: () => {
            //                 this.getBlockLot(this.form.selected_block_lot);
            //                 this.viewUser();
            //             },
            //         },
            //         {
            //             label: `Verify ${data.role}`,
            //             icon: "pi pi-check",
            //             command: () => {
            //                 this.getBlockLot(this.form.selected_block_lot);
            //                 this.viewVerifytDialog = true;
            //             },
            //         },
            //         {
            //             label: `Update ${data.role}`,
            //             icon: "pi pi-pencil",
            //             command: () => {
            //                 this.getBlockLot(this.form.selected_block_lot);
            //                 this.updateUser();
            //             },
            //         },
            //         {
            //             label: "Emergency Contacts",
            //             icon: "pi pi-id-card",
            //             command: () => {
            //                 this.getBlockLot(this.form.selected_block_lot);
            //                 this.viewEmergencyContacts();
            //             },
            //         },

            //         {
            //             label: `Activate ${data.role}`,
            //             icon: "pi pi-unlock",
            //             command: () => {
            //                 this.changeStatus();
            //             },
            //         },
            //     ];
            // }
        },
        populateFields(data) {
            this.resetFields();
            this.resetErrors();
            this.id = data.id;
            this.name = data.name;
            this.form.first_name = data.first_name;
            this.form.last_name = data.last_name;
            this.form.gender = data.gender;
            if (data.role != "security officer" && data.role != "admin") {
                this.form.selected_block = data.lot.block.number;
                this.form.selected_block_lot = data.block_lot_id;
            }
            if (data.role == "officer") {
                this.form.selected_position = data.position_id;
            }
            this.form.email = data.email;
            this.form.age = data.age;
            this.form.contact_num = data.contact_num;
            this.form.selected_role = data.role;
            this.form.verified = data.verified;

            this.form.status = data.status;
            this.form.selected_tag = data.tag_as;
            this.form.flagged = data.flagged;
        },
        clearFilter() {
            this.filters["lot.block.number"].value = null;
            this.filters["lot.number"].value = null;
            this.filters["tag_as"].value = null;
            this.filters["role"].value = null;
            this.filters["status"].value = null;
            this.filters["verified"].value = null;
            this.filters["flagged"].value = null;
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

                "lot.block.number": {
                    value: null,
                    matchMode: FilterMatchMode.EQUALS,
                },
                "lot.number": {
                    value: null,
                    matchMode: FilterMatchMode.EQUALS,
                },
                tag_as: {
                    value: null,
                    matchMode: FilterMatchMode.EQUALS,
                },
                role: {
                    value: null,
                    matchMode: FilterMatchMode.EQUALS,
                },
                status: {
                    value: null,
                    matchMode: FilterMatchMode.EQUALS,
                },
                verified: {
                    value: null,
                    matchMode: FilterMatchMode.EQUALS,
                },
                flagged: {
                    value: null,
                    matchMode: FilterMatchMode.EQUALS,
                },
            };
        },

        deleteUser(first_name, last_name, id) {
            this.id = id;
            this.name = first_name + " " + last_name;
            this.deleteUserDialog = true;
        },
        async confirmDeleteItem() {
            try {
                this.deleteUserDialog = false;
                this.loading = true;
                await axios({
                    method: "delete",
                    url: "/api/user/" + this.id,
                });
                this.$store.dispatch("getAllUsers");
                this.loading = false;
                this.$toast.add({
                    severity: "success",
                    summary: "Successful Request",
                    detail: "Deleted User",
                    life: 3000,
                });
            } catch (err) {
                this.loading = false;
                console.log(err.response);
            }
        },
        updateUser() {
            this.updateUserDialog = true;
        },
        async confirmUpdateUser() {
            this.loading = true;
            await axios({
                method: "put",
                url: "/api/user/" + this.id,
                data: {
                    first_name: this.form.first_name,
                    last_name: this.form.last_name,
                    gender: this.form.gender,
                    block_lot_id: this.form.selected_block_lot,

                    verified: this.form.verified,

                    age: this.form.age,
                    contact_num: this.form.contact_num,
                    role: this.form.selected_role,
                    status: this.form.status,
                },
            })
                .then(() => {
                    this.$toast.add({
                        severity: "success",
                        summary: "Successful Request",
                        detail: "Updated User",
                        life: 3000,
                    });
                    this.$store.dispatch("getAllUsers");
                    this.resetFields();
                    this.updateUserDialog = false;
                    this.loading = false;
                })
                .catch((err) => {
                    console.log(err.response);
                    this.resetErrors();
                    this.validate(err);
                    this.loading = false;
                });
        },
        async verifyUser() {
            this.loading = true;
            await axios({
                method: "post",
                url: "/api/sms/",
                data: {
                    contact_num: this.form.contact_num,
                },
            })
                .then(async () => {
                    await axios({
                        method: "put",
                        url: "/api/user/" + this.id,
                        data: {
                            first_name: this.form.first_name,
                            last_name: this.form.last_name,
                            gender: this.form.gender,
                            block_lot_id: this.form.selected_block_lot,
                            email: this.form.email,
                            verified: 1,

                            age: this.form.age,
                            contact_num: this.form.contact_num,
                            role: this.form.selected_role,
                            status: this.form.status,
                            tag_as: this.form.selected_tag,
                        },
                    })
                        .then(() => {
                            this.$toast.add({
                                severity: "success",
                                summary: "Successful",
                                detail: "Resident Verified",
                                life: 3000,
                            });
                            this.$store.dispatch("getAllUsers");
                            this.resetFields();
                            this.viewVerifytDialog = false;
                            this.loading = false;
                        })
                        .catch((err) => {
                            console.log(err.response);
                            this.resetErrors();
                            this.validate(err);
                            this.loading = false;
                        });
                })
                .catch(async (err) => {
                    console.log(err.response);
                    this.loading = false;
                });
        },
        async changeStatus() {
            this.loading = true;
            await axios({
                method: "put",
                url: "/api/user/" + this.id,
                data: {
                    first_name: this.form.first_name,
                    last_name: this.form.last_name,
                    gender: this.form.gender,
                    block_lot_id: this.form.selected_block_lot,
                    email: this.form.email,
                    verified: this.form.verified,

                    age: this.form.age,
                    contact_num: this.form.contact_num,
                    role: this.form.selected_role,
                    status:
                        this.form.status == "active" ? "inactive" : "active",
                    tag_as: this.form.selected_tag,
                },
            })
                .then(() => {
                    this.$toast.add({
                        severity: "success",
                        summary: "Successful",
                        detail:
                            this.form.status != "active"
                                ? "User Activated"
                                : "User Deactivated",
                        life: 3000,
                    });
                    this.$store.dispatch("getAllUsers");
                    this.resetFields();
                    this.loading = false;
                })
                .catch((err) => {
                    console.log(err.response);
                    this.resetErrors();
                    this.validate(err);
                    this.loading = false;
                });
        },
        //REGISTER USER
        registerUser() {
            this.registerUserDialog = true;
            this.form.email = null;
            this.resetFields();
            this.resetErrors();
        },
        async onRegisterClick() {
            this.loading = true;
            await axios({
                method: "post",
                url: "/api/user",
                data: {
                    first_name: this.form.first_name,
                    last_name: this.form.last_name,
                    gender: this.form.gender,
                    block_lot_id: this.form.selected_block_lot,
                    email: this.form.email,
                    password: this.form.password,
                    confirm_password: this.form.confirm_password,
                    verified: 1,

                    age: this.form.age,
                    contact_num: this.form.contact_num,
                    role: this.form.selected_role,
                    status: "active",
                },
            })
                .then(() => {
                    this.registerUserDialog = false;
                    this.resetFields();
                    this.$store.dispatch("getAllUsers");
                    this.$toast.add({
                        severity: "success",
                        summary: "Successful Request",
                        detail: "Registered User",
                        life: 3000,
                    });
                    this.loading = false;
                })
                .catch((err) => {
                    console.log(err.response);
                    this.resetErrors();
                    this.validate(err);
                    this.loading = false;
                });
        },
        resetFields() {
            this.form = {
                first_name: "",
                last_name: "",
                gender: "",
                selected_block: "",
                selected_block_lot: "",
                email: "",
                password: "",
                confirm_password: "",
                age: "",
                contact_num: "",
                selected_role: "resident",
            };
        },
        resetErrors() {
            this.error_first_name = "";
            this.error_last_name = "";
            this.error_gender = "";
            this.error_selected_block = "";
            this.error_selected_lot = "";
            this.error_email = "";
            this.error_password = "";
            this.error_confirm_password = "";
            this.error_age = "";
            this.error_contact_num = "";
            this.error_role = "";
            this.error_selected_tag = "";
            this.error_selected_position = "";
        },
        validate(error) {
            if (error.response.data.errors.first_name)
                this.error_first_name =
                    error.response.data.errors.first_name[0];
            if (error.response.data.errors.last_name)
                this.error_last_name = error.response.data.errors.last_name[0];
            if (error.response.data.errors.gender)
                this.error_gender = error.response.data.errors.gender[0];

            if (error.response.data.errors.email)
                this.error_email = error.response.data.errors.email[0];
            if (error.response.data.errors.password)
                this.error_password = error.response.data.errors.password[0];
            if (error.response.data.errors.confirm_password)
                this.error_confirm_password =
                    error.response.data.errors.confirm_password[0];
            if (error.response.data.errors.age)
                this.error_age = error.response.data.errors.age[0];
            if (error.response.data.errors.contact_num)
                this.error_contact_num =
                    error.response.data.errors.contact_num[0];
            if (error.response.data.errors.role)
                this.error_role = error.response.data.errors.role[0];
            if (!this.form.selected_block)
                this.error_selected_block = "The block field is required";
            if (!this.form.selected_block_lot)
                this.error_selected_lot = "The lot field is required";
            if (!this.form.selected_tag)
                this.error_selected_tag = "The tag field is required";
            if (!this.form.selected_position)
                this.error_selected_position = "The position field is required";
        },

        getBlockLot(lot) {
            this.$store.dispatch("lots/getBlockLots", this.form.selected_block);
            this.form.selected_block_lot = lot;
        },
        getFilterBlockLot() {
            this.$store.dispatch(
                "lots/getBlockLots",
                this.filters["lot.block.number"].value
            );
        },
    },

    created() {
        this.initFilters();
    },
};
</script>

<style></style>
