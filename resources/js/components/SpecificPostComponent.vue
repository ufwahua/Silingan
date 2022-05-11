<template>
    <div class="grid">
        <div
            class="col-12 sm:col-12 md:col-8 md:col-offset-2 lg:col-6 lg:col-offset-1 xl:col-6 xl:col-offset-1"
        >
            <div
                v-if="specific_post.approved"
                class="col justify-content-center pt-0"
            >
                <PostComponent
                    :post="specific_post"
                    :group_id="specific_post.group_id"
                    :approved="specific_post.approved"
                />
            </div>
            <div v-else class="col justify-content-center pt-0">
                This post is not yet approved
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
            specific_post: computed(() => store.state.posts.specific_post),
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
        resetFields() {
            this.images = null;
            this.content = null;
            this.user_id = null;
        },
    },
    mounted() {
        this.$store.dispatch("posts/getSpecificPost", this.$route.params.post);
    },
};
</script>

<style></style>
