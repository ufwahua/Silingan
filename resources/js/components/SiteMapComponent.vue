<template>
    <div class="grid">
        <div
            class="col-12 sm:col-12 md:col-10 md:col-offset-1 lg:col-6 lg:col-offset-1 xl:col-6 xl:col-offset-1"
        >
            <Galleria
                :value="images"
                v-model:activeIndex="activeIndex"
                :responsiveOptions="responsiveOptions"
                :numVisible="7"
                containerStyle="max-width: 850px"
                :circular="true"
                :fullScreen="true"
                :showItemNavigators="true"
                :showThumbnails="false"
                v-model:visible="displayCustom"
            >
                <template #item="slotProps">
                    <img
                        :src="slotProps.item"
                        :alt="slotProps.item"
                        style="object-fit: fit; max-width: 800px; height: 800px"
                        class="w-full"
                    />
                </template>
            </Galleria>
            <div v-for="(image, index) of images" class="col-12" :key="index">
                <img
                    :src="image"
                    :alt="image"
                    style="
                        cursor: pointer;
                        object-fit: fit;
                        width: 100%;
                        height: 50%;
                    "
                    @click="imageClick(index)"
                />
            </div>
        </div>
        <div
            class="col-12 sm:col-12 md:col-10 md:col-offset-1 lg:col-4 lg:col-offset-1 xl:col-4 xl:col-offset-1"
        >
            <Fieldset class="mb-3" legend="Local News">
                <NewsComponent />
            </Fieldset>
        </div>
    </div>
</template>

<script>
import { computed } from "vue";
import { useStore } from "vuex";
import NewsComponent from "./NewsComponent.vue";

export default {
    name: "SettingComponent",
    components: {
        NewsComponent,
    },
    setup() {
        const store = useStore();
        return {
            userLogged: computed(() => store.state.userLogged),
        };
    },
    data() {
        return {
            images: ["/storage/images/deca 4 map.jpg"],
            activeIndex: 0,
            responsiveOptions: [
                {
                    breakpoint: "1024px",
                    numVisible: 5,
                },
                {
                    breakpoint: "768px",
                    numVisible: 3,
                },
                {
                    breakpoint: "560px",
                    numVisible: 1,
                },
            ],
            displayCustom: false,
        };
    },
    methods: {
        imageClick(index) {
            this.activeIndex = index;
            this.displayCustom = true;
        },
    },
};
</script>

<style></style>
