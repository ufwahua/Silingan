div
<template>
    <!-- post and comment -->
    <div>
        <div class="card p-0">
            <div class="card-header p-3">
                <div class="grid grid-nogutter">
                    <div class="col">
                        <div class="p-inputgroup">
                            <div v-if="post.user.profile_pic">
                                <Avatar
                                    :image="`http://127.0.0.1:8000${post.user.profile_pic}`"
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

                            <div class="grid grid-nogutter">
                                <div class="col-12">
                                    <b class="p-0 m-0">
                                        {{ post.user.first_name }}
                                        {{ post.user.last_name }}</b
                                    >
                                    <b class="p-0 m-0">
                                        [{{ post.user.role }}]
                                    </b>
                                    <b v-if="post.user.lot">
                                        Block
                                        {{ post.user.lot.block.number }} Lot
                                        {{ post.user.lot.number }}</b
                                    >
                                </div>
                                <div class="col-12">
                                    <p>{{ post.updated_at }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        v-if="approved == true"
                        class="col-fix"
                        style="width: 30px"
                    >
                        <Button
                            class="p-button-text w-full h-full"
                            icon="pi pi-ellipsis-v"
                            @click="toggle"
                            aria-haspopup="true"
                            aria-controls="overlay_menu"
                        />
                        <Menu
                            id="overlay_menu"
                            ref="menu"
                            :model="menus"
                            :popup="true"
                        />
                    </div>
                </div>
            </div>
            <div class="card-body pt-2 p-0 m-0">
                <p class="p-2 m-">{{ post.content }}</p>
                <Galleria
                    v-if="images"
                    :value="images"
                    :responsiveOptions="responsiveOptions"
                    :numVisible="4"
                    class="w-full mx-0 px-0"
                    :showItemNavigators="true"
                    :showItemNavigatorsOnHover="true"
                >
                    <template #item="slotProps">
                        <img
                            :src="slotProps.item"
                            alt="image"
                            preview
                            style="object-fit: fit; height: 300px"
                            class="w-full"
                        />
                    </template>
                    <template #thumbnail="slotProps">
                        <Image
                            :src="slotProps.item"
                            alt="image"
                            width="100"
                            preview
                        />
                    </template>
                </Galleria>
            </div>
            <hr />
            <div
                v-if="approved == true"
                class="flex justify-content-end p-0 m-0 mr-4"
            >
                <Button
                    v-if="comment_count <= 1"
                    :label="`${comment_count.toString()} comment`"
                    icon="pi pi-comment"
                    style="width: 200px"
                    class="p-button-outlined p-button-primary ml-5"
                    @click="commentShow"
                />
                <Button
                    v-else
                    :label="`${comment_count.toString()} comments`"
                    icon="pi pi-comments"
                    style="width: 200px"
                    class="p-button-outlined p-button-primary ml-5"
                    @click="commentShow"
                />
            </div>

            <div v-else class="flex justify-content-end">
                <Button
                    icon="pi pi-times"
                    class="p-button-danger mr-3"
                    v-tooltip="'Decline'"
                    @click="openDeclineDialog"
                />
                <Button
                    icon="pi pi-check"
                    class="p-button-primary mr-3"
                    v-tooltip="'Approve'"
                    @click="openApproveDialog"
                />
            </div>
            <hr />
            <div class="p-3" v-if="comment_show">
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
                        @keypress.enter="commentPost"
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
                        @keypress.enter="commentPost"
                        v-model="message"
                        :autoResize="true"
                        rows="1"
                        class="w-full"
                        disabled
                        placeholder="Can't comment because your account is flagged please contact an admin/officer"
                    >
                    </Textarea>
                </div>
                <div v-for="comment in post.comment" :key="comment.id">
                    <CommentComponent
                        v-if="comment.id"
                        :comment="comment"
                        :group_id="group_id"
                        :post_id="comment.post_id"
                    />
                </div>
            </div>
        </div>
        <Dialog
            v-model:visible="editModal"
            :style="{ width: '500px' }"
            header="Edit Post"
            :modal="true"
            :closeOnEscape="true"
        >
            <div class="grid">
                <div class="col-12">
                    <Textarea
                        v-model="content"
                        :autoResize="true"
                        class="w-full"
                        placeholder="What's on you mind?"
                    >
                    </Textarea>
                </div>
                <div class="col-12">
                    <Galleria
                        v-if="images"
                        :value="images"
                        :responsiveOptions="responsiveOptions"
                        :numVisible="4"
                        class="w-full mx-0 px-0"
                        :showItemNavigators="true"
                        :showItemNavigatorsOnHover="true"
                    >
                        <template #item="slotProps">
                            <img
                                :src="slotProps.item"
                                alt="image"
                                preview
                                style="object-fit: fit; height: 500px"
                                class="w-full"
                            />
                        </template>
                        <template #thumbnail="slotProps">
                            <Image
                                :src="slotProps.item"
                                alt="image"
                                width="100"
                                preview
                            />
                        </template>
                    </Galleria>
                </div>
            </div>

            <template #footer>
                <Button
                    label="Save"
                    class="p-button-text p-button-primary"
                    @click="savePost"
                    :disabled="
                        this.content == post.content || !this.content
                            ? true
                            : false
                    "
                />
            </template>
        </Dialog>
        <Dialog
            v-model:visible="deleteModal"
            :style="{ width: '450px' }"
            header="Delete post?"
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
                        <span>Are you sure you want to delete this post?</span>
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
                    @click="deletePost"
                />
            </template>
        </Dialog>
        <Dialog
            v-model:visible="flagModal"
            :style="{ width: '450px' }"
            header="Flag user?"
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
                        <span>Are you sure you want to flag this user?</span>
                    </div>
                </div>
            </div>
            <template #footer>
                <Button
                    label="Cancel"
                    icon="pi pi-times"
                    class="p-button-text"
                    @click="flagModal = false"
                />
                <Button
                    label="Confirm"
                    icon="pi pi-check"
                    class="p-button-text p-button-danger"
                    @click="changeFlagStatus(this.post.user)"
                />
            </template>
        </Dialog>
        <Dialog
            v-model:visible="unflagModal"
            :style="{ width: '450px' }"
            header="Unflag user?"
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
                        <span>Are you sure you want to unflag this user?</span>
                    </div>
                </div>
            </div>
            <template #footer>
                <Button
                    label="Cancel"
                    icon="pi pi-times"
                    class="p-button-text"
                    @click="unflagModal = false"
                />
                <Button
                    label="Confirm"
                    icon="pi pi-check"
                    class="p-button-text p-button-success"
                    @click="changeFlagStatus(this.post.user)"
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
        <Dialog
            v-model:visible="approveDialog"
            :style="{ width: '450px' }"
            :header="`Approve Post?`"
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
                            >Are you sure you want to approve post of
                            <b
                                >{{ post.user.first_name }}
                                {{ post.user.last_name }}?</b
                            ></span
                        >
                    </div>
                </div>
            </div>
            <template #footer>
                <Button
                    label="Cancel"
                    class="p-button-text p-button-danger"
                    @click="approveDialog = false"
                />
                <Button
                    label="Approve"
                    class="p-button p-button-primary"
                    @click="approvePost"
                />
            </template>
        </Dialog>
        <Dialog
            v-model:visible="declineDialog"
            :style="{ width: '450px' }"
            :header="`Decline Post?`"
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
                            >Are you sure you want to decline post of
                            <b
                                >{{ post.user.first_name }}
                                {{ post.user.last_name }}?</b
                            >
                        </span>
                    </div>
                </div>
            </div>
            <template #footer>
                <Button
                    label="Cancel"
                    class="p-button-text"
                    @click="declineDialog = false"
                />
                <Button
                    label="Decline"
                    class="p-button p-button-danger"
                    @click="declinePost"
                />
            </template>
        </Dialog>
        <Dialog
            v-model:visible="blockDialog"
            :style="{ width: '450px' }"
            :header="`Are you sure you want to block ${post.user.first_name} ${post.user.last_name}`"
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
                            ><b
                                >{{ post.user.first_name }}
                                {{ post.user.last_name }} will no longer be able
                                to:
                            </b></span
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
    </div>
</template>

<script>
import CommentComponent from "./CommentComponent.vue";
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
        post: {
            type: Object,
        },
        group_id: { type: Number },
        approved: { type: Number },
    },
    components: {
        CommentComponent,
    },
    data() {
        return {
            profile_pic: null,
            loading: false,
            editModal: false,
            deleteModal: false,
            flagModal: false,
            unflagModal: false,
            blockDialog: false,
            declineDialog: false,
            approveDialog: false,
            content: null,
            message: null,
            comment_count: 0,
            comment_show: false,
            responsiveOptions: [
                {
                    breakpoint: "1600px",
                    numVisible: 3,
                },

                {
                    breakpoint: "1400px",
                    numVisible: 2,
                },
            ],
            images: JSON.parse(this.post.images),
            menus: null,
        };
    },

    methods: {
        async changeFlagStatus(data) {
            this.flagModal = false;
            this.unflagModal = false;
            this.loading = true;
            if (data.role == "security officer") {
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
                                    ? "User Flagged"
                                    : "User UnFlagged",
                            life: 3000,
                        });
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

                        this.loading = false;
                    })
                    .catch((err) => {
                        console.log(err.response);

                        this.loading = false;
                    });
            } else if (data.role == "officer" || data.role == "resident") {
                await axios({
                    method: "put",
                    url: "/api/user/" + data.id,
                    data: {
                        first_name: data.first_name,
                        last_name: data.last_name,
                        gender: data.gender,
                        block_lot_id: data.block_lot_id,
                        email: data.email,
                        verified: data.verified,

                        age: data.age,
                        contact_num: data.contact_num,
                        role: data.role,
                        status: data.status,
                        tag_as: data.tag_as,
                        flagged: data.flagged ? false : true,
                    },
                })
                    .then(() => {
                        this.$toast.add({
                            severity: "success",
                            summary: "Successful",
                            detail:
                                data.flagged == false
                                    ? "User Flagged"
                                    : "User UnFlagged",
                            life: 3000,
                        });
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

                        this.loading = false;
                    })
                    .catch((err) => {
                        console.log(err.response);

                        this.loading = false;
                    });
            }
        },
        async approvePost() {
            this.loading = true;
            await axios({
                method: "put",
                url: "/api/post/" + this.post.id,
                data: {
                    group_id: this.post.group.id,
                    user_id: this.post.user.id,
                    content: this.post.content,
                    approved: 1,
                },
            })
                .then((res) => {
                    this.approveDialog = false;

                    this.$store.dispatch(
                        "posts/getMarketPlaceNotVerified",
                        this.$store.state.userLogged.id
                    );

                    this.showApprovedToast();
                    this.loading = false;
                })
                .catch((error) => {
                    console.log(error.response);
                    this.loading = false;
                });
        },
        async declinePost() {
            this.loading = true;
            await axios({
                method: "delete",
                url: "/api/post/" + this.post.id,
            })
                .then((res) => {
                    this.declineDialog = false;
                    this.$store.dispatch(
                        "posts/getMarketPlaceVerified",
                        this.$store.state.userLogged.id
                    );
                    this.showDeclinedToast();
                    this.loading = false;
                })
                .catch((error) => {
                    console.log(error.response);
                    this.loading = false;
                });
        },
        openApproveDialog() {
            this.approveDialog = true;
        },
        openDeclineDialog() {
            this.declineDialog = true;
        },
        showApprovedToast() {
            this.$toast.add({
                severity: "success",
                summary: "Success Message",
                detail: "Approved post",
                life: 3000,
            });
        },
        showDeclinedToast() {
            this.$toast.add({
                severity: "success",
                summary: "Success Message",
                detail: "Declined post",
                life: 3000,
            });
        },
        async commentPost() {
            await axios({
                method: "post",
                url: "/api/comment",
                data: {
                    post_id: this.post.id,
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

                    if (this.post.user.id != this.$store.state.userLogged.id) {
                        await axios({
                            method: "post",
                            url: "/api/notification/comment",
                            data: {
                                from_user_id: this.$store.state.userLogged.id,
                                to_user_id: this.post.user.id,
                                post_id: this.post.id,
                                message: "has commented on your post",
                            },
                        })
                            .then(() => {
                                console.log("notify success");
                            })
                            .catch((e) => {
                                console.log(e.response);
                            });
                    }
                    this.$store.dispatch("posts/getSpecificPost", this.post.id);

                    this.message = null;
                })
                .catch((error) => {
                    console.log(error.response);
                });
        },
        commentShow() {
            this.comment_show = !this.comment_show;
        },
        toggle(event) {
            this.populateMenu();
            this.$refs.menu.toggle(event);
        },
        showDeletedPostToast() {
            this.$toast.add({
                severity: "success",
                summary: "Success Message",
                detail: "Deleted post",
                life: 3000,
            });
        },
        async deletePost() {
            this.loading = true;
            await axios({
                method: "delete",
                url: "/api/post/" + this.post.id,
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
                    this.showDeletedPostToast();
                    this.loading = false;
                })
                .catch((error) => {
                    console.log(error.response);
                    this.loading = false;
                });
        },
        showEditPostToast() {
            this.$toast.add({
                severity: "success",
                summary: "Success Message",
                detail: "Edited post",
                life: 3000,
            });
        },
        async savePost() {
            this.loading = true;
            await axios({
                method: "put",
                url: "/api/post/" + this.post.id,
                data: {
                    group_id: this.post.group.id,
                    user_id: this.userLogged.id,
                    content: this.content,
                    approved: 1,
                },
            })
                .then((res) => {
                    this.editModal = false;
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
                    this.showEditPostToast();
                    this.loading = false;
                })
                .catch((error) => {
                    console.log(error.response);
                    this.loading = false;
                });
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
        populateMenu() {
            if (this.post.user.id === this.userLogged.id) {
                this.menus = [
                    {
                        label: "Edit post",
                        icon: "pi pi-pencil",
                        command: () => {
                            this.editModal = true;
                            this.content = this.post.content;
                        },
                    },
                    {
                        label: "Delete post",
                        icon: "pi pi-trash",
                        command: () => {
                            this.deleteModal = true;
                        },
                    },
                ];
            } else if (
                this.userLogged.role == "admin" ||
                this.userLogged.role == "officer"
            ) {
                this.menus = [
                    {
                        label: "Block " + this.post.user.first_name,
                        icon: "pi pi-user-edit",
                        command: () => {
                            this.selectedUser = this.post.user.id;
                            this.openBlockDialog();
                        },
                    },
                    {
                        label: "Delete post",
                        icon: "pi pi-trash",
                        command: () => {
                            this.deleteModal = true;
                        },
                    },
                ];
                if (this.post.user.flagged) {
                    this.menus.push({
                        label: "UnFlag " + this.post.user.first_name,
                        icon: "pi pi-flag",
                        command: () => {
                            this.unflagModal = true;
                        },
                    });
                } else {
                    this.menus.push({
                        label: "Flag " + this.post.user.first_name,
                        icon: "pi pi-flag-fill",
                        command: () => {
                            this.flagModal = true;
                        },
                    });
                }
            } else {
                this.menus = [
                    {
                        label: "Block " + this.post.user.first_name,
                        icon: "pi pi-user-edit",
                        command: () => {
                            this.selectedUser = this.post.user.id;
                            this.openBlockDialog();
                        },
                    },
                ];
            }
        },
        countComment() {
            this.comment_count =
                this.post.comment_count + this.post.reply_count;
        },
    },
    mounted() {
        this.countComment();
    },
};
</script>
