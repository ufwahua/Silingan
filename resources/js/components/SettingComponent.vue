<template>
    <div class="grid">
        <div
            class="col-12 sm:col-12 md:col-10 md:col-offset-1 lg:col-6 lg:col-offset-1 xl:col-6 xl:col-offset-1"
        >
            <div class="col justify-content-center pt-0">
                <ManageBlockComponent></ManageBlockComponent>
            </div>
            <!-- <div class="col justify-content-center pt-0">
                <ManageVehicleComponent></ManageVehicleComponent>
            </div> -->
            <div class="col justify-content-center pt-0">
                <EmergencyContactDetailComponent></EmergencyContactDetailComponent>
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
import ManageBlockComponent from "./ManageBlockComponent.vue";
import ManageVehicleComponent from "./ManageVehicleComponent.vue";
import EmergencyContactDetailComponent from "./EmergencyContactDetailComponent.vue";
export default {
    name: "SettingComponent",
    components: {
        NewsComponent,
        ManageBlockComponent,
        ManageVehicleComponent,
        EmergencyContactDetailComponent,
    },
    setup() {
        const store = useStore();
        return {
            userLogged: computed(() => store.state.userLogged),
        };
    },
    data() {
        return {
            loading: null,
            deactivateDialog: false,
        };
    },
    methods: {
        async deactivateAccount(data) {
            this.loading = true;
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
                    this.loading = false;
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
                    this.loading = false;
                });
        },
        openDeactivateDialog() {
            this.deactivateDialog = true;
        },
    },
};
</script>

<style></style>
