<template>
    <div class="grid">
        <div
            class="sm:col-6 md:col-12 lg:col-12"
            v-for="article in news"
            :key="article.id"
        >
            <a :href="article.url" style="text-decoration: none">
                <Card>
                    <template #header>
                        <img
                            :src="article.urlToImage"
                            alt="Image"
                            class="w-full p-0 m-0 h-20rem"
                        />
                    </template>
                    <template #title>
                        <h2>{{ article.title }}</h2></template
                    >
                    <template #subtitle> {{ article.author }} </template>
                    <template #content>
                        {{ article.description }}
                    </template>
                </Card>
            </a>
        </div>
    </div>
</template>

<script>
import { computed } from "vue";
import { useStore } from "vuex";

export default {
    setup() {
        const store = useStore();
        return {
            news: computed(() => store.state.news.news),
        };
    },
};
</script>
