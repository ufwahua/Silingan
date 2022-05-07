<template>
    <div>
        <Toast />
        <div class="grid">
            <div class="col-12">
                <h1 class="layout-text">Security Officers</h1>
            </div>
        </div>
        <div class="grid mb-2 flex justify-flex-start">
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
        <!-- <div class="card">
            <div class="grid">
                <div class="col-12">
                    <DataTable
                        :value="users"
                        :filters="filters"
                        breakpoint="1350px"
                        
                        :rows="10"
                    > -->
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
                                <div class="col-12 mb-2 lg:col-3 lg:mb-0">
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
                                        v-model="filters['status'].value"
                                        :showClear="true"
                                        :options="status"
                                        optionLabel="status"
                                        optionValue="status"
                                        placeholder="Filter by status"
                                    ></Dropdown>
                                </div>
                                <div class="col-12 mb-2 lg:col-2 lg:mb-0">
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
                                    class="col-12 mb-2 lg:col-2 lg:mb-0 flex justify-content-end"
                                >
                                    <Button
                                        icon="pi pi-filter-slash"
                                        class="my-2 p-button-outlined p-button-secondary"
                                        @click="clearFilter"
                                        v-tooltip="'Clear'"
                                    />

                                    <Button
                                        label="Add"
                                        icon="pi pi-plus"
                                        class="ml-2 my-2 p-button-primary"
                                        style="width: auto"
                                        @click="registerUser"
                                    />
                                </div>
                            </div>
                        </div>
                        <!-- <template #header>
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
                                    v-model="filters['status'].value"
                                    :showClear="true"
                                    :options="status"
                                    optionLabel="status"
                                    optionValue="status"
                                    placeholder="Filter by status"
                                    style="width: 200px"
                                    class="my-2"
                                ></Dropdown>
                                <Button
                                    label="Clear"
                                    icon="pi pi-filter-slash"
                                    class="my-2 p-button-outlined p-button-secondary"
                                    @click="clearFilter"
                                />
                                <Button
                                    label="Add"
                                    icon="pi pi-plus"
                                    class="p-button-primary my-2"
                                    @click="registerUser"
                                />
                            </div>
                        </template> -->
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
                        <Column header="Shift" field="shift">
                            <template #body="{ data }"
                                >{{ (data["shift"] = getShift(data)) }}
                            </template></Column
                        >
                        <Column header="Status" field="status">
                            <template #body="{ data }">
                                <Badge :class="badgecolor(data.status)">{{
                                    data.status
                                }}</Badge>
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
                        header="Update Security Officer"
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
                                    />
                                    <label
                                        style="color: red"
                                        v-if="error_role"
                                        >{{ error_role }}</label
                                    >
                                </div>

                                <div class="field col-12 md:col-12">
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
                                    <label class="">Shift</label>
                                </div>
                                <div class="field col-12 md:col-6">
                                    <Calendar
                                        v-model="form.from"
                                        :timeOnly="true"
                                        :showTime="true"
                                        hourFormat="12"
                                        placeholder="From"
                                        :class="{
                                            'p-invalid': error_security_shift,
                                        }"
                                    />
                                </div>
                                <div class="field col-12 md:col-6">
                                    <Calendar
                                        v-model="form.to"
                                        :timeOnly="true"
                                        :showTime="true"
                                        hourFormat="12"
                                        placeholder="To"
                                        :class="{
                                            'p-invalid': error_security_shift,
                                        }"
                                    />
                                </div>
                                <div class="field col-12 md:col-12">
                                    <label
                                        style="color: red"
                                        v-if="error_security_shift"
                                        >{{ error_security_shift }}</label
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
                                        name="email"
                                        v-model="form.email"
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
                        header="Register Security Officer"
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
                                        optionLabel="type"
                                        optionValue="value"
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
                                    <label class="">Shift</label>
                                </div>
                                <div class="field col-12 md:col-6">
                                    <Calendar
                                        v-model="form.from"
                                        :timeOnly="true"
                                        :showTime="true"
                                        hourFormat="12"
                                        placeholder="From"
                                        :class="{
                                            'p-invalid': error_security_shift,
                                        }"
                                    />
                                </div>
                                <div class="field col-12 md:col-6">
                                    <Calendar
                                        v-model="form.to"
                                        :timeOnly="true"
                                        :showTime="true"
                                        hourFormat="12"
                                        placeholder="To"
                                        :class="{
                                            'p-invalid': error_security_shift,
                                        }"
                                    />
                                </div>
                                <div class="field col-12 md:col-12">
                                    <label
                                        style="color: red"
                                        v-if="error_security_shift"
                                        >{{ error_security_shift }}</label
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
                        v-model:visible="viewSecurityDialog"
                        :style="{ width: '500px' }"
                        header="View Security Officer"
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
                                    <label class="">Shift</label>
                                </div>
                                <div class="field col-12 md:col-6">
                                    <Calendar
                                        v-model="form.from"
                                        :timeOnly="true"
                                        :showTime="true"
                                        hourFormat="12"
                                        placeholder="From"
                                        :class="{
                                            'p-invalid': error_security_shift,
                                        }"
                                        disabled
                                    />
                                </div>
                                <div class="field col-12 md:col-6">
                                    <Calendar
                                        v-model="form.to"
                                        :timeOnly="true"
                                        :showTime="true"
                                        hourFormat="12"
                                        placeholder="To"
                                        :class="{
                                            'p-invalid': error_security_shift,
                                        }"
                                        disabled
                                    />
                                </div>
                                <div class="field col-12 md:col-12">
                                    <label
                                        style="color: red"
                                        v-if="error_security_shift"
                                        >{{ error_security_shift }}</label
                                    >
                                </div>
                                <div class="field col-12 md:col-12">
                                    <label>Email</label>
                                    <InputText
                                        type="text"
                                        name="email"
                                        v-model="form.email"
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
    name: "RegisterUsersComponent",
    setup() {
        const store = useStore();
        return {
            users: computed(() => store.state.users),
            active: computed(() => {
                let temp = [];
                let active = [];
                store.state.users.forEach((elem) => {
                    if (elem.role.toUpperCase() == "SECURITY OFFICER") {
                        temp.push(elem);
                    }
                });
                temp.forEach((elem) => {
                    if (elem.status == "active") {
                        active.push(elem);
                    }
                });
                return active.length;
            }),
            inactive: computed(() => {
                let temp = [];
                let inactive = [];
                store.state.users.forEach((elem) => {
                    if (elem.role.toUpperCase() == "SECURITY OFFICER") {
                        temp.push(elem);
                    }
                });
                temp.forEach((elem) => {
                    if (elem.status == "inactive") {
                        inactive.push(elem);
                    }
                });
                return inactive.length;
            }),
            flagged: computed(() => {
                let temp = [];
                let flagged = [];
                store.state.users.forEach((elem) => {
                    if (elem.role.toUpperCase() == "SECURITY OFFICER") {
                        temp.push(elem);
                    }
                });
                temp.forEach((elem) => {
                    if (elem.flagged == true) {
                        flagged.push(elem);
                    }
                });
                return flagged.length;
            }),
            not_flagged: computed(() => {
                let temp = [];
                let not_flagged = [];
                store.state.users.forEach((elem) => {
                    if (elem.role.toUpperCase() == "SECURITY OFFICER") {
                        temp.push(elem);
                    }
                });
                temp.forEach((elem) => {
                    if (elem.flagged == false) {
                        not_flagged.push(elem);
                    }
                });
                return not_flagged.length;
            }),
            total: computed(() => {
                let temp = [];
                store.state.users.forEach((elem) => {
                    if (elem.role.toUpperCase() == "SECURITY OFFICER") {
                        temp.push(elem);
                    }
                });
                return temp.length;
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
            process: false,
            registerUserDialog: false,
            deleteUserDialog: false,
            updateUserDialog: false,
            viewOfficerDialog: false,
            viewSecurityDialog: false,
            form: {
                first_name: "",
                last_name: "",
                gender: "",

                email: "",
                password: "",
                confirm_password: "",
                age: "",
                contact_num: "",
                selected_role: "",
                verified: "",
                has_voted: "",
                status: "",
                to: "",
                from: "",
                flagged: "",
            },
            security_shift: "",

            user: null,
            role: [{ type: "security officer", value: "security officer" }],
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
            error_security_shift: "",

            status: [{ status: "active" }, { status: "inactive" }],
            verification: [
                { status: "verified", value: true },
                { status: "not verified", value: false },
            ],
            flag_dropdown: [
                { status: "flagged", value: true },
                { status: "not flagged", value: false },
            ],

            emergencyContactDialog: false,
            emergency_contacts: null,
        };
    },
    methods: {
        async changeFlagStatus(data) {
            this.process = true;
            console.log("verify", data);
            await axios({
                method: "put",
                url: "/api/user/" + data.id,
                data: {
                    first_name: data.first_name,
                    last_name: data.last_name,
                    gender: data.gender,
                    block_lot_id: null,
                    email: data.email,
                    verified: data.verified,
                    status: data.status,
                    flagged: data.flagged ? false : true,
                    has_voted: data.has_voted,
                    age: data.age,
                    contact_num: data.contact_num,
                    role: data.role,
                    security_shift: data.security_shift,
                },
            })
                .then(() => {
                    this.$toast.add({
                        severity: "success",
                        summary: "Successful",
                        detail:
                            data.flagged == false
                                ? "Security Officer flagged"
                                : "Security Officer unflagged",
                        life: 3000,
                    });
                    this.$store.dispatch("getAllUsers");
                    this.resetFields();
                    this.process = false;
                })
                .catch((err) => {
                    console.log(err.response);
                    this.resetErrors();
                    this.validate(err);
                    this.process = false;
                });
        },
        getShift(data) {
            const shift = data.security_shift.split(" - ");

            const from = new Date(shift[0]).toLocaleTimeString("en-US", {
                hour12: true,
                hour: "numeric",
                minute: "numeric",
            });
            const to = new Date(shift[1]).toLocaleTimeString("en-US", {
                hour12: true,
                hour: "numeric",
                minute: "numeric",
            });

            return from + " - " + to;
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
        clearFilter() {
            this.filters["status"].value = null;
            this.filters["flagged"].value = null;
        },
        viewSecurityOfficer() {
            this.viewSecurityDialog = true;
        },
        toggle(data) {
            this.$refs.menu.toggle(event);
            this.populateFields(data);
            this.menus = [];
            this.menus.push({
                label: "View Security Officer",
                icon: "pi pi-user",
                command: () => {
                    this.viewSecurityOfficer();
                },
            });
            this.menus.push({
                label: "Update Security Officer",
                icon: "pi pi-pencil",
                command: () => {
                    this.updateUser();
                },
            });
            this.menus.push({
                label: "Emergency Contacts",
                icon: "pi pi-id-card",
                command: () => {
                    this.viewEmergencyContacts();
                },
            });

            if (data.status == "active") {
                this.menus.push({
                    label: "Deactivate Security Officer",
                    icon: "pi pi-lock",
                    command: () => {
                        this.changeStatus(data);
                    },
                });
            } else {
                this.menus.push({
                    label: "Activate Security Officer",
                    icon: "pi pi-unlock",
                    command: () => {
                        this.changeStatus(data);
                    },
                });
            }
            if (data.flagged == false) {
                this.menus.push({
                    label: `Flag ${data.role}`,
                    icon: "pi pi-flag-fill",
                    command: () => {
                        this.changeFlagStatus(data);
                    },
                });
            } else {
                this.menus.push({
                    label: `UnFlag ${data.role}`,
                    icon: "pi pi-flag",
                    command: () => {
                        this.changeFlagStatus(data);
                    },
                });
            }
            // if (data.status == "active") {
            //     this.menus = [
            //         {
            //             label: "View Security Officer",
            //             icon: "pi pi-user",
            //             command: () => {
            //                 this.viewSecurityOfficer();
            //             },
            //         },
            //         {
            //             label: "Update Security Officer",
            //             icon: "pi pi-pencil",
            //             command: () => {
            //                 this.updateUser();
            //             },
            //         },
            //         {
            //             label: "Emergency Contacts",
            //             icon: "pi pi-id-card",
            //             command: () => {
            //                 this.viewEmergencyContacts();
            //             },
            //         },
            //         {
            //             label: "Deactivate Security Officer",
            //             icon: "pi pi-lock",
            //             command: () => {
            //                 this.changeStatus(data);
            //             },
            //         },
            //     ];
            // } else {
            //     this.menus = [
            //         {
            //             label: "View Security Officer",
            //             icon: "pi pi-user",
            //             command: () => {
            //                 this.viewSecurityOfficer();
            //             },
            //         },
            //         {
            //             label: "Update Security Officer",
            //             icon: "pi pi-pencil",
            //             command: () => {
            //                 this.updateUser();
            //             },
            //         },
            //         {
            //             label: "Emergency Contacts",
            //             icon: "pi pi-id-card",
            //             command: () => {
            //                 this.viewEmergencyContacts();
            //             },
            //         },

            //         {
            //             label: "Activate Security Officer",
            //             icon: "pi pi-unlock",
            //             command: () => {
            //                 this.changeStatus(data);
            //             },
            //         },
            //     ];
            // }
        },
        populateFields(data) {
            this.resetFields();
            this.resetErrors();
            this.name = data.name;
            this.position = data.position;
            this.id = data.id;
            this.form.first_name = data.first_name;
            this.form.last_name = data.last_name;
            this.form.gender = data.gender;
            this.form.email = data.email;
            this.form.age = data.age;
            this.form.contact_num = data.contact_num;
            this.form.selected_role = data.role;
            this.form.verified = data.verified;
            this.form.has_voted = data.has_voted;
            this.form.status = data.status;
            this.form.flagged = data.flagged;
            if (data.security_shift) {
                let shift = data.security_shift.split(" - ");

                this.form.from = new Date(shift[0]).toLocaleTimeString(
                    "en-US",
                    {
                        hour12: true,
                        hour: "numeric",
                        minute: "numeric",
                    }
                );
                this.form.to = new Date(shift[1]).toLocaleTimeString("en-US", {
                    hour12: true,
                    hour: "numeric",
                    minute: "numeric",
                });
            }
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
                role: {
                    value: "security officer",
                    matchMode: FilterMatchMode.EQUALS,
                },
                status: {
                    value: null,
                    matchMode: FilterMatchMode.EQUALS,
                },
                flagged: {
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
        deleteUser(first_name, last_name, id) {
            this.id = id;
            this.name = first_name + " " + last_name;
            this.deleteUserDialog = true;
        },
        async confirmDeleteItem() {
            try {
                this.deleteUserDialog = false;
                this.process = true;
                await axios({
                    method: "delete",
                    url: "/api/user/" + this.id,
                });
                this.$store.dispatch("getAllUsers");
                this.process = false;
                this.$toast.add({
                    severity: "success",
                    summary: "Successful Request",
                    detail: "Deleted Security Officer",
                    life: 3000,
                });
            } catch (err) {
                this.process = false;
                console.log(err.response);
            }
        },
        updateUser() {
            this.updateUserDialog = true;
        },
        async confirmUpdateUser() {
            this.process = true;

            this.security_shift = this.form.from + " - " + this.form.to;
            if (!this.form.from || !this.form.to) {
                this.security_shift = null;
            }
            await axios({
                method: "put",
                url: "/api/user/" + this.id,
                data: {
                    first_name: this.form.first_name,
                    last_name: this.form.last_name,
                    gender: this.form.gender,
                    block_lot_id: null,
                    email: this.form.email,
                    password: this.form.password,
                    confirm_password: this.form.confirm_password,
                    verified: this.form.verified,
                    has_voted: this.form.has_voted,
                    age: this.form.age,
                    contact_num: this.form.contact_num,
                    role: this.form.selected_role,
                    status: this.form.status,
                    security_shift: this.security_shift,
                },
            })
                .then(() => {
                    this.$toast.add({
                        severity: "success",
                        summary: "Successful Request",
                        detail: "Updated Security Officer",
                        life: 3000,
                    });
                    this.$store.dispatch("getAllUsers");
                    this.resetFields();
                    this.updateUserDialog = false;
                    this.process = false;
                })
                .catch((err) => {
                    console.log(err.response);
                    this.resetErrors();
                    this.validate(err);
                    this.process = false;
                });
        },
        async verifyUser(data) {
            this.process = true;
            console.log("verify", data);
            await axios({
                method: "put",
                url: "/api/user/" + data.id,
                data: {
                    first_name: data.first_name,
                    last_name: data.last_name,
                    gender: data.gender,
                    block_lot_id: null,
                    email: data.email,
                    verified: 1,
                    status: data.status,
                    has_voted: data.has_voted,
                    age: data.age,
                    contact_num: data.contact_num,
                    role: data.role,
                },
            })
                .then(() => {
                    this.$toast.add({
                        severity: "success",
                        summary: "Successful",
                        detail: "Security Officer Verified",
                        life: 3000,
                    });
                    this.$store.dispatch("getAllUsers");
                    this.resetFields();
                    this.process = false;
                })
                .catch((err) => {
                    console.log(err.response);
                    this.resetErrors();
                    this.validate(err);
                    this.process = false;
                });
        },
        async changeStatus(data) {
            this.process = true;
            console.log("verify", data);
            await axios({
                method: "put",
                url: "/api/user/" + data.id,
                data: {
                    first_name: data.first_name,
                    last_name: data.last_name,
                    gender: data.gender,
                    block_lot_id: null,
                    email: data.email,
                    verified: data.verified,
                    status: data.status == "active" ? "inactive" : "active",
                    has_voted: data.has_voted,
                    age: data.age,
                    contact_num: data.contact_num,
                    role: data.role,
                    security_shift: data.security_shift,
                },
            })
                .then(() => {
                    this.$toast.add({
                        severity: "success",
                        summary: "Successful",
                        detail:
                            data.status != "active"
                                ? "Security Officer Activated"
                                : "Security Officer Deactivated",
                        life: 3000,
                    });
                    this.$store.dispatch("getAllUsers");
                    this.resetFields();
                    this.process = false;
                })
                .catch((err) => {
                    console.log(err.response);
                    this.resetErrors();
                    this.validate(err);
                    this.process = false;
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
            this.process = true;
            const from = new Date(this.form.from).toLocaleTimeString("en-US", {
                hour: "numeric",
                minute: "numeric",
            });
            const to = new Date(this.form.to).toLocaleTimeString("en-US", {
                hour: "numeric",
                minute: "numeric",
            });
            this.security_shift = from + " - " + to;
            if (!this.form.from || !this.form.to) {
                this.security_shift = null;
            }

            await axios({
                method: "post",
                url: "/api/user",
                data: {
                    first_name: this.form.first_name,
                    last_name: this.form.last_name,
                    gender: this.form.gender,
                    block_lot_id: null,
                    email: this.form.email,
                    password: this.form.password,
                    confirm_password: this.form.confirm_password,
                    verified: 1,
                    has_voted: 0,
                    age: this.form.age,
                    contact_num: this.form.contact_num,
                    role: this.form.selected_role,
                    status: "active",
                    security_shift: this.security_shift,
                },
            })
                .then(() => {
                    this.registerUserDialog = false;
                    this.resetFields();
                    this.$store.dispatch("getAllUsers");
                    this.$toast.add({
                        severity: "success",
                        summary: "Successful Request",
                        detail: "Registered Security Officer",
                        life: 3000,
                    });
                    this.process = false;
                })
                .catch((err) => {
                    console.log(err.response);
                    this.resetErrors();
                    this.validate(err);
                    this.process = false;
                });
        },
        resetFields() {
            this.form = {
                first_name: "",
                last_name: "",
                gender: "",

                email: "",
                password: "",
                confirm_password: "",
                age: "",
                contact_num: "",
                selected_role: "security officer",
                from: "",
                to: "",
            };
        },
        resetErrors() {
            this.error_first_name = "";
            this.error_last_name = "";
            this.error_gender = "";

            this.error_email = "";
            this.error_password = "";
            this.error_confirm_password = "";
            this.error_age = "";
            this.error_contact_num = "";
            this.error_role = "";
            this.error_security_shift = "";
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
            if (error.response.data.errors.security_shift)
                this.error_security_shift =
                    error.response.data.errors.security_shift[0];
        },
    },

    created() {
        this.initFilters();
    },
};
</script>

<style></style>
