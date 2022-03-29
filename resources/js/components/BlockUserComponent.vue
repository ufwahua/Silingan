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
                                style="width: 200px"
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
                    <div v-if="block_users" class="card flex flex-column">
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
        <Toast />
    </div>
</template>

<script>
import { computed } from "vue";
import { useStore } from "vuex";
import NewsComponent from "./NewsComponent.vue";
export default {
    name: "BlockUserComponent",
    components: {
        NewsComponent,
    },
    setup() {
        const store = useStore();
        return {
            posts: computed(() => store.state.posts.posts),
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
        };
    },
    methods: {
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
};
</script>

<style></style>
