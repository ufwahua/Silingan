<template>
    <div class="grid">
        <div
            class="col-12 sm:col-12 md:col-10 md:col-offset-1 lg:col-10 lg:col-offset-1 xl:col-10 xl:col-offset-1"
        >
            <div class="col justify-content-center pt-0">
                <h1 class="text-center">View Billing</h1>
                <div class="grid">
                    <div class="col-12 lg:col-6 card">
                        <b>Balance Details</b>
                    </div>
                    <div class="col-12 lg:col-6 card">
                        <p><b>Account Information</b></p>
                        <p>
                            <b>Full name:</b
                            ><span> Joshua Henry G. Diamos</span>
                        </p>
                        <p>
                            <b>Block:</b><span class="mr-2"> 1</span><b>Lot:</b
                            ><span> 2</span>
                        </p>
                        <p><b>Tag:</b><span class="mr-2"> renter</span></p>
                    </div>
                </div>
            </div>
        </div>
        <div
            class="col-12 sm:col-12 md:col-0 md:col-offset-1 lg:col-0 lg:col-offset-1 xl:col-0 xl:col-offset-1"
        ></div>

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
export default {
    name: "AnnouncementComponent",
    components: {
        NewsComponent,
    },
    setup() {
        const store = useStore();
        return {
            posts: computed(() => store.state.posts.posts),
            userLogged: computed(() => store.state.userLogged),
            announcements: computed(
                () => store.state.announcements.announcements
            ),
        };
    },
    data() {
        return {
            loading: null,
            user_id: null,
            groud_id: null,
        };
    },
    mounted() {
        this.$store.dispatch("announcements/getAll");
    },
};
</script>

<style></style>
