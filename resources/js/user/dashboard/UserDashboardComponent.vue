<template>
    <div class="grid">
        <div class="col-10 sm:col-10 md:col-10 lg:col-6 xl:col-6 col-offset-1">
            <div class="col justify-content-center pt-0">
                <Fieldset class="mb-3" legend="Announcement">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                        sed do eiusmod tempor incididunt ut labore et dolore
                        magna aliqua. Ut enim ad minim veniam, quis nostrud
                        exercitation ullamco laboris nisi ut aliquip ex ea
                        commodo consequat. Duis aute irure dolor in
                        reprehenderit in voluptate velit esse cillum dolore eu
                        fugiat nulla pariatur. Excepteur sint occaecat cupidatat
                        non proident, sunt in culpa qui officia deserunt mollit
                        anim id est laborum.
                    </p>
                </Fieldset>
                <div class="card">
                    <div class="p-inputgroup mb-2">
                        <Avatar
                            image="https://www.primefaces.org/wp-content/uploads/2020/05/placeholder.png"
                            class="mr-2"
                            size="xlarge"
                            shape="circle"
                            alt="Image"
                        />
                        <Textarea :autoResize="true" class="w-full"> </Textarea>
                    </div>
                    <hr />
                    <FileUpload
                        name="demo[]"
                        url="./upload.php"
                        accept="image/*"
                        :customUpload="true"
                        @uploader="myUploader"
                        :maxFileSize="2000000"
                        :fileLimit="3"
                        :showUploadButton="false"
                        :showCancelButton="false"
                    >
                        <template #empty>
                            <p>Drag and drop files to here to upload.</p>
                        </template>
                    </FileUpload>
                </div>
                <div v-for="post in posts" :key="post.id">
                    <PostComponent
                        v-if="post.group_id === 1"
                        v-bind:post="post"
                    />
                </div>
            </div>
        </div>
        <div class="col-10 sm:col-10 md:col-10 lg:col-4 xl:col-4 col-offset-1">
            <NewsComponent />
        </div>
    </div>
</template>

<script>
import { computed } from "vue";
import { useStore } from "vuex";
import NewsComponent from "./NewsComponent.vue";
import PostComponent from "./PostComponent.vue";
export default {
    name: "UserDashboardComponent",
    components: {
        NewsComponent,
        PostComponent,
    },
    setup() {
        const store = useStore();
        return {
            posts: computed(() => store.state.posts.posts),
        };
    },
    data() {
        return {
            data: [
                {
                    name: "Jayson Cadiz",
                    date: "January 1, 2021",
                    type: "Laptop",
                    model: "Aspire-15",
                    brand: "Acer",
                },
                {
                    name: "Gio Alfanta",
                    date: "January 2, 2021",
                    type: "Desktop",
                    model: "Aspire-15",
                    brand: "Acer",
                },
                {
                    name: "Godfrey Español",
                    date: "January 3, 2021",
                    type: "Mouse",
                    model: "Abyssus",
                    brand: "Razer",
                },
            ],
        };
    },
    methods: {
        myUploader() {},
    },
};
</script>

<style>
@import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap");

.container {
    margin-left: 5%;
    margin-right: 5%;
}
.lanex-font {
    font-family: "Poppins", sans-serif;
}
.lanex-font-title {
    font-size: 24px;
}
.lanex-font-content {
    font-size: 14px;
}
</style>
