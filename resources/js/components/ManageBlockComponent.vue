<template>
    <div>
        <Fieldset class="mb-3" legend="Manage Block">
            <p class="p-4">
                Once you block someone, that person can no longer see things you
                post on your timeline and in the marketplace.
            </p>
            <div>
                <div class="flex justify-content-center mb-4">
                    <b class="flex align-items-center mr-2 p-2">Block Users</b>
                    <Dropdown
                        v-model="selectedUser"
                        :options="not_blocked_users"
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
                                    slotProps.option.last_name +
                                    " [" +
                                    slotProps.option.role +
                                    "]")
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
                        {{ block_user.block_user.last_name }} [
                        {{ block_user.block_user.role }}]
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
import { computed } from "vue";
import { useStore } from "vuex";
export default {
    name: "ManageBlockComponent",
    setup() {
        const store = useStore();
        return {
            not_blocked_users: computed(() => store.state.not_blocked_users),
            block_users: computed(() => store.state.block_users),
        };
    },
    data() {
        return {
            name: null,
            loading: false,
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
        this.$store.dispatch(
            "getUsersNotBlocked",
            this.$store.state.userLogged.id
        );
    },
};
</script>
