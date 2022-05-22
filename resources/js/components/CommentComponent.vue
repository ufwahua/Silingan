<template>
    <div class="grid">
        <div class="col-12 pb-0 mb-0">
            <div class="p-inputgroup pt-1 pb-0 my-0">
                <div v-if="comment.user.profile_pic">
                    <Avatar
                        :image="`http://127.0.0.1:8000${comment.user.profile_pic}`"
                        class="mr-2"
                        size="large"
                        shape="circle"
                        alt="Image"
                    />
                </div>
                <div v-else>
                    <Avatar
                        image="http://127.0.0.1:8000/storage/images/avatar.png"
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
                                {{ comment.user.first_name }}
                                {{ comment.user.last_name }}</b
                            >
                        </div>
                        <div class="col-12 pb-1">
                            {{ comment.message }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 pl-7 p-0 m-0">
            <ul class="m-0 p-0" style="list-style-type: none">
                <li
                    v-if="comment.user.id == userLogged.id"
                    style="display: inline"
                >
                    <Button
                        label="Delete"
                        class="p-button-secondary p-button-text m-0 p-0 mr-2"
                        @click="showDeleteDialog"
                    />
                </li>
                <li style="display: inline">
                    <Button
                        label="Reply"
                        class="p-button-secondary p-button-text m-0 p-0 mr-2"
                        @click="showReply"
                    />
                </li>
                <li style="display: inline">
                    <span>{{ comment.updated_at }}</span>
                </li>
            </ul>
        </div>

        <div v-if="show_reply" class="col-11 col-offset-1 pt-2 mt-2">
            <div v-if="!userLogged.flagged" class="p-inputgroup mb-2">
                <div v-if="userLogged.profile_pic">
                    <Avatar
                        :image="`http://127.0.0.1:8000${userLogged.profile_pic}`"
                        class="mr-2"
                        size="large"
                        shape="circle"
                        alt="Image"
                    />
                </div>
                <div v-else>
                    <Avatar
                        image="http://127.0.0.1:8000/storage/images/avatar.png"
                        class="mr-2"
                        size="large"
                        shape="circle"
                        alt="Image"
                    />
                </div>
                <Textarea
                    @keypress.enter="replyPost"
                    v-model="message"
                    :autoResize="true"
                    rows="1"
                    class="w-full"
                >
                </Textarea>
            </div>
            <div v-else class="p-inputgroup mb-2">
                <div v-if="userLogged.profile_pic">
                    <Avatar
                        :image="`http://127.0.0.1:8000${userLogged.profile_pic}`"
                        class="mr-2"
                        size="large"
                        shape="circle"
                        alt="Image"
                    />
                </div>
                <div v-else>
                    <Avatar
                        image="http://127.0.0.1:8000/storage/images/avatar.png"
                        class="mr-2"
                        size="large"
                        shape="circle"
                        alt="Image"
                    />
                </div>
                <Textarea
                    @keypress.enter="replyPost"
                    v-model="message"
                    :autoResize="true"
                    rows="1"
                    class="w-full"
                    placeholder="Can't reply because your account is flagged please contact an admin/officer"
                    disabled
                >
                </Textarea>
            </div>
        </div>
        <div v-if="show_reply" class="col-11 col-offset-1 py-0 my-0">
            <div v-for="reply in comment.reply" :key="reply.id">
                <ReplyComponent
                    v-if="reply.id"
                    :reply="reply"
                    :group_id="group_id"
                />
            </div>
        </div>
        <Dialog
            v-model:visible="deleteModal"
            :style="{ width: '450px' }"
            header="Delete comment?"
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
                            >Are you sure you want to delete this comment?</span
                        >
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
                    @click="deleteComment"
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
import ReplyComponent from "./ReplyComponent.vue";
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
        comment: {
            type: Object,
        },
        post_id: { type: Number },
        group_id: { type: Number },
    },
    components: {
        ReplyComponent,
    },
    data() {
        return {
            profile_pic: null,
            show_reply: false,
            message: null,
            deleteModal: false,
            loading: false,
        };
    },
    methods: {
        async deleteComment() {
            this.loading = true;
            console.log("comment id", this.comment.id);
            await axios({
                method: "delete",
                url: "/api/comment/" + this.comment.id,
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
                detail: "Deleted comment",
                life: 3000,
            });
        },
        showDeleteDialog() {
            this.deleteModal = true;
        },
        async replyPost() {
            await axios({
                method: "post",
                url: "/api/reply",
                data: {
                    comment_id: this.comment.id,
                    user_id: this.userLogged.id,
                    message: this.message,
                },
            })
                .then(async (res) => {
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
                    if (
                        this.comment.user.id != this.$store.state.userLogged.id
                    ) {
                        await axios({
                            method: "post",
                            url: "/api/notification/comment",
                            data: {
                                from_user_id: this.$store.state.userLogged.id,
                                to_user_id: this.comment.user.id,
                                post_id: this.post_id,
                                message: "has replied on your comment",
                            },
                        })
                            .then(() => {
                                console.log("notify success");
                            })
                            .catch((e) => {
                                console.log(e.response);
                            });
                    }
                    this.$store.dispatch("posts/getSpecificPost", this.post_id);
                    this.message = null;
                })
                .catch((error) => {
                    console.log(error.response);
                });
        },
        showReply() {
            this.show_reply = !this.show_reply;
        },
    },
};
</script>
