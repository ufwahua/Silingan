<template>
    <div>
        <div class="col-12 p-0 m-0">
            <div class="p-inputgroup pt-1 pb-0 my-0">
                <div v-if="reply.user.profile_pic">
                    <Avatar
                        :image="`http://127.0.0.1:8000${reply.user.profile_pic}`"
                        class="mr-2"
                        size="large"
                        shape="circle"
                        alt="Image"
                    />
                </div>
                <div v-else>
                    <Avatar
                        image="http://127.0.0.1:8000/storage/images/default-prof-pic.png"
                        class="mr-2"
                        size="large"
                        shape="circle"
                        alt="Image"
                    />
                </div>
                <div
                    class="card pb-0 pt-1 px-2 mb-0 mt-1"
                    style="background-color: var(--blue-50)"
                >
                    <div class="grid grid-nogutter">
                        <div class="col-12">
                            <b>
                                {{ reply.user.first_name }}
                                {{ reply.user.last_name }}
                            </b>
                        </div>
                        <div class="col-12 pb-1">
                            {{ reply.message }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 pl-7 p-0 m-0">
            <ul class="m-0 p-0" style="list-style-type: none">
                <li
                    v-if="reply.user.id == userLogged.id"
                    style="display: inline"
                >
                    <Button
                        label="Delete"
                        class="p-button-secondary p-button-text m-0 p-0 mr-2"
                        @click="showDeleteDialog"
                    />
                </li>

                <li style="display: inline">
                    <span>{{ reply.updated_at }}</span>
                </li>
            </ul>
        </div>
        <Dialog
            v-model:visible="deleteModal"
            :style="{ width: '450px' }"
            header="Delete reply?"
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
                        <span>Are you sure you want to delete this reply?</span>
                    </div>
                </div>
            </div>
            <template #footer>
                <Button
                    label="Cancel"
                    icon="pi pi-times"
                    class="p-button-text"
                    @click="deleteModal = false"
                />
                <Button
                    label="Delete"
                    icon="pi pi-check"
                    class="p-button-text p-button-danger"
                    @click="deleteReply"
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
    setup() {
        const store = useStore();
        return {
            userLogged: computed(() => store.state.userLogged),
        };
    },
    props: {
        reply: {
            type: Object,
        },
        group_id: {
            type: Number,
        },
    },
    data() {
        return {
            deleteModal: false,
            loading: false,
        };
    },
    methods: {
        async deleteReply() {
            this.loading = true;
            await axios({
                method: "delete",
                url: "/api/reply/" + this.reply.id,
            })
                .then((res) => {
                    this.deleteModal = false;
                    if (this.group_id == 1) {
                        this.$store.dispatch(
                            "posts/getTimeLine",
                            this.$store.state.userLogged.id
                        );
                    } else {
                        this.$store.dispatch(
                            "posts/getMarketPlaceVerified",
                            this.$store.state.userLogged.id
                        );
                    }
                    this.showDeletedtToast();
                    this.loading = false;
                })
                .catch((error) => {
                    console.log(error.response);
                    this.loading = false;
                });
        },
        showDeletedtToast() {
            this.$toast.add({
                severity: "success",
                summary: "Success Message",
                detail: "Deleted reply",
                life: 3000,
            });
        },
        showDeleteDialog() {
            this.deleteModal = true;
        },
    },
};
</script>
