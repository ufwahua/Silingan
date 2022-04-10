<template>
    <div class="grid">
        <div
            class="col-12 sm:col-12 md:col-10 md:col-offset-1 lg:col-6 lg:col-offset-1 xl:col-6 xl:col-offset-1"
        >
            <div class="col justify-content-center pt-0">
                <Fieldset class="mb-3" legend="Activate Account">
                    <p class="p-4 text-center">
                        Return account back to normal and features like chat,
                        post, comments, replies will now be seen again.
                    </p>
                    <div>
                        <div class="flex justify-content-center mb-4">
                            <Button
                                label="Activate"
                                class="p-button-outlined p-button-primary"
                                @click="openDeactivateDialog"
                            ></Button>
                        </div>
                    </div>
                </Fieldset>
            </div>
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
            v-model:visible="activateDialog"
            :style="{ width: '450px' }"
            :header="`Activate Account`"
            :modal="true"
        >
            <div class="confirmation-content">
                <div class="grid">
                    <div
                        class="col-12 flex align-items-center justify-content-center"
                    >
                        <span
                            >Are you sure you want to activate your account?
                        </span>
                    </div>
                </div>
            </div>
            <template #footer>
                <Button
                    label="Cancel"
                    class="p-button-text"
                    @click="activateDialog = false"
                />
                <Button
                    label="Confirm"
                    class="p-button-success"
                    @click="activateAccount(this.userLogged)"
                />
            </template>
        </Dialog>
        <Toast />
    </div>
</template>

<script>
import { computed } from "vue";
import { useStore } from "vuex";
export default {
    name: "ActivateAccountComponent",

    setup() {
        const store = useStore();
        return {
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
            activateDialog: false,
        };
    },
    methods: {
        async activateAccount(data) {
            this.process = true;
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
                    this.$store.dispatch("getUserLogged");
                    this.process = false;
                    this.$router.push("/" + this.userLogged.role + "/timeline");
                })
                .catch((err) => {
                    console.log(err.response);
                    this.process = false;
                });
        },
        openDeactivateDialog() {
            this.activateDialog = true;
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
        console.log("userLogged", this.userLogged);
    },
};
</script>

<style></style>
