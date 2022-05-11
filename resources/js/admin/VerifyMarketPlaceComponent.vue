<template>
    <div class="grid">
        <div
            class="col-12 sm:col-12 md:col-8 md:col-offset-2 lg:col-6 lg:col-offset-1 xl:col-6 xl:col-offset-1"
        >
            <h2>Verify Post in Marketplace</h2>
            <div class="col justify-content-center pt-0">
                <div
                    v-for="post in post_marketplace_not_verified"
                    :key="post.id"
                >
                    <PostComponent
                        :post="post"
                        :group_id="post.group_id"
                        :approved="post.approved"
                    />
                </div>
            </div>
        </div>
        <div
            class="col-12 sm:col-12 md:col-8 md:col-offset-2 lg:col-4 lg:col-offset-1 xl:col-4 xl:col-offset-1"
        >
            <Fieldset class="mb-3" legend="Local News">
                <NewsComponent />
            </Fieldset>
        </div>
        <Dialog
            v-model:visible="openPostModal"
            :style="{ width: '500px' }"
            header="Create Post"
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
                    <FileUpload
                        name="demo[]"
                        accept="image/*"
                        :multiple="true"
                        :customUpload="true"
                        @uploader="onUpload"
                        :auto="true"
                        :maxFileSize="2000000"
                        :showUploadButton="false"
                        :showCancelButton="false"
                    >
                        <template #empty>
                            <p>Drag and drop files to here to upload.</p>
                        </template>
                    </FileUpload>
                </div>
            </div>

            <template #footer>
                <div v-if="content || images">
                    <Button
                        label="Post"
                        icon="pi pi-check"
                        class="p-button-text p-button-post"
                        @click="enterPost"
                    />
                </div>
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
        <Toast />
    </div>
</template>

<script>
import { computed } from "vue";
import { useStore } from "vuex";
import NewsComponent from "../components/NewsComponent.vue";
import PostComponent from "../components/PostComponent.vue";
export default {
    name: "VerifyMarketPlaceComponent",
    components: {
        NewsComponent,
        PostComponent,
    },
    setup() {
        const store = useStore();
        return {
            post_marketplace_not_verified: computed(
                () => store.state.posts.post_marketplace_not_verified
            ),
            userLogged: computed(() => store.state.userLogged),
        };
    },
    data() {
        return {
            profile_pic: null,
            loading: null,
            user_id: null,
            groud_id: null,
            images: null,
            content: null,
            openPostModal: false,
        };
    },
    methods: {
        // Open Add Lot Modal
        openAddLotModal() {
            this.resetFields();
            this.openPostModal = true;
        },
        resetFields() {
            this.images = null;
            this.content = null;
            this.user_id = null;
        },
        showPostedToast() {
            this.$toast.add({
                severity: "success",
                summary: "Success Message",
                detail: "Please wait for the admin/officers to accept your post",
                life: 3000,
            });
        },
        async onUpload(event) {
            let formData = new FormData();
            this.images = event.files;
            for (let file of this.images) {
                formData.append("images[]", file);
            }
            formData.append("user_id", this.$store.state.userLogged.id);

            if (this.images) {
                await axios
                    .post("/upload", formData, {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                    })
                    .then((res) => {
                        this.images = res.data;
                    })
                    .catch((e) => {
                        console.log(e.response);
                    });
            }
        },
        async enterPost() {
            this.loading = true;
            await axios({
                method: "post",
                url: "/api/post",
                data: {
                    group_id: 2,
                    user_id: this.$store.state.userLogged.id,
                    images: JSON.stringify(this.images),
                    content: this.content,
                    approved: 0,
                },
            })
                .then((res) => {
                    this.openPostModal = false;
                    this.$store.dispatch(
                        "posts/getMarketPlaceNotVerified",
                        this.$store.state.userLogged.id
                    );
                    this.showPostedToast();
                    this.loading = false;
                })
                .catch((error) => {
                    console.log(error.response);
                    this.loading = false;
                });
        },
    },
    mounted() {
        this.$store.dispatch(
            "posts/getMarketPlaceNotVerified",
            this.$store.state.userLogged.id
        );
    },
};
</script>

<style></style>
