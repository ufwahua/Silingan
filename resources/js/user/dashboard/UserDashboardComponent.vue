<template>
    <div class="grid">
        <div class="col-12 sm:col-12 md:col-8 lg:col-9">
            <div class="row justify-content-center">
                <div class="col">
                    <Fieldset class="mb-3" legend="Announcement">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing
                            elit, sed do eiusmod tempor incididunt ut labore et
                            dolore magna aliqua. Ut enim ad minim veniam, quis
                            nostrud exercitation ullamco laboris nisi ut aliquip
                            ex ea commodo consequat. Duis aute irure dolor in
                            reprehenderit in voluptate velit esse cillum dolore
                            eu fugiat nulla pariatur. Excepteur sint occaecat
                            cupidatat non proident, sunt in culpa qui officia
                            deserunt mollit anim id est laborum.
                        </p>
                    </Fieldset>
                    <div v-for="post in posts" :key="post.id">
                        <PostComponent
                            v-if="post.group_id === 1"
                            v-bind:post="post"
                        />
                    </div>
                </div>
            </div>
        </div>
        <div class="sm:col-12 md:col-4 lg:col-3">
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
