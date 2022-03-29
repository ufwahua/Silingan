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
                                    image="http://127.0.0.1:8000/storage/images/default-prof-pic.png"
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
                                </div>
                                <div class="col-12">
                                    <p>{{ post.updated_at }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        v-if="post.group_id === 1"
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
                            :model="items"
                            :popup="true"
                        />
                    </div>
                </div>
            </div>
            <div class="card-body p-0 m-0">
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
            <div class="flex justify-content-between p-0 m-0">
                <Button
                    label="Comment"
                    icon="pi pi-comment"
                    style="width: 150px"
                    class="p-button-outlined p-button-primary ml-5"
                    @click="commentShow"
                />
                <Button
                    v-if="comment_count === 1"
                    :label="`${comment_count.toString()} comment`"
                    class="p-button-primary p-button-text"
                    @click="commentShow"
                />
                <Button
                    v-if="comment_count > 1"
                    :label="`${comment_count.toString()} comments`"
                    class="p-button-primary p-button-text"
                    @click="commentShow"
                />
            </div>

            <hr />
            <div class="p-3" v-if="comment_show">
                <div class="p-inputgroup mb-2">
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
                            image="http://127.0.0.1:8000/storage/images/default-prof-pic.png"
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
                <div v-for="comment in post.comment" :key="comment.id">
                    <CommentComponent
                        v-if="comment.id"
                        v-bind:comment="comment"
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
                <div v-if="content === post.content">
                    <Button
                        label="Save"
                        class="p-button-text p-button-primary"
                        @click="savePost"
                        disabled
                    />
                </div>
                <div v-else>
                    <Button
                        label="Save"
                        class="p-button-text p-button-primary"
                        @click="savePost"
                    />
                </div>
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
            items: null,
        };
    },

    methods: {
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
                .then((res) => {
                    this.$store.dispatch("posts/getAll");
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
                    this.$store.dispatch("posts/getAll");
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
                    this.$store.dispatch("posts/getAll");
                    this.showEditPostToast();
                    this.loading = false;
                })
                .catch((error) => {
                    console.log(error.response);
                    this.loading = false;
                });
        },
        populateMenu() {
            if (this.post.user.id === this.userLogged.id) {
                this.items = [
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
            } else {
                this.items = [
                    {
                        label: "Block " + this.post.user.first_name,
                        icon: "pi pi-user-edit",
                        command: () => {},
                    },
                ];
            }
        },
    },
    mounted() {
        this.comment_count = this.post.comment_count + this.post.reply_count;
    },
    created() {
        this.populateMenu();
    },
};
</script>
