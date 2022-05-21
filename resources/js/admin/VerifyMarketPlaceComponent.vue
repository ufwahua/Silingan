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
        };
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
