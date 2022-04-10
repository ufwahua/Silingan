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
                            ></Button>
                        </div>
                    </div>
                    <div v-if="block_users[0]" class="card flex flex-column">
                        <div
                            v-for="block_user in block_users"
                            :key="block_user.id"
                            class="flex flex-row justify-content-center"
                        >
                            <span class="text-center p-1">
                                {{ block_user.block_user.first_name }}
                                {{ block_user.block_user.last_name }}
                            </span>
                            <span
                                ><Button
                                    class="p-button-text p-button-sm p-1"
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
        };
    },
    methods: {
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
            this.loading = true;
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
    mounted() {
        console.log("users", this.users);
    },
};
</script>

<style></style>
