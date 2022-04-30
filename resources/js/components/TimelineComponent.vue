<template>
    <div class="grid">
        <div
            class="col-12 sm:col-12 md:col-8 md:col-offset-2 lg:col-6 lg:col-offset-1 xl:col-6 xl:col-offset-1"
        >
            <h2 class="layout-text">Timeline</h2>
            <div class="col justify-content-center pt-0">
                <div class="card p-3">
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
                                image="http://127.0.0.1:8000/storage/images/avatar.png"
                                class="mr-2"
                                size="large"
                                shape="circle"
                                alt="Image"
                            />
                        </div>

                        <Textarea
                            @click="openAddLotModal"
                            :autoResize="true"
                            class="w-full"
                            placeholder="What's on you mind?"
                            rows="1"
                        >
                        </Textarea>
                    </div>
                </div>
                <div v-for="post in posts" :key="post.id">
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
                        mode="basic"
                        accept="image/*"
                        :multiple="true"
                        @uploader="onUpload"
                        :auto="true"
                        :customUpload="true"
                        :maxFileSize="2000000"
                        :hidden="images ? true : false"
                    >
                        <template #empty>
                            <p>Drag and drop files to here to upload.</p>
                        </template>
                    </FileUpload>
                    <Galleria
                        :value="images"
                        :responsiveOptions="responsiveOptions"
                        :numVisible="3"
                        class="w-full mx-0"
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
import NewsComponent from "./NewsComponent.vue";
import PostComponent from "./PostComponent.vue";
export default {
    name: "TimelineComponent",
    components: {
        NewsComponent,
        PostComponent,
    },
    setup() {
        const store = useStore();
        return {
            posts: computed(() => store.state.posts.posts),
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
                detail: "Successfully posted",
                life: 3000,
            });
        },
        async onUpload(event) {
            this.loading = true;
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
                        this.loading = false;
                    })
                    .catch((e) => {
                        console.log(e.response);
                        this.loading = false;
                    });
            }
        },
        async enterPost() {
            this.loading = true;
            await axios({
                method: "post",
                url: "/api/post",
                data: {
                    group_id: 1,
                    user_id: this.$store.state.userLogged.id,
                    images: JSON.stringify(this.images),
                    content: this.content,
                    approved: 1,
                },
            })
                .then((res) => {
                    this.openPostModal = false;
                    this.$store.dispatch(
                        "posts/getTimeLine",
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
            "posts/getTimeLine",
            this.$store.state.userLogged.id
        );
    },
};
</script>

<style></style>
