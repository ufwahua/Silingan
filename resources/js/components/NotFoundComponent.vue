<template>
    <div>{{ foo }}</div>
</template>

<script>
import { computed, onBeforeMount } from "vue";

export default {
    name: "NotFoundComponent",
    setup() {
        return {
            foo: computed(() => "404 Not Found"),
        };
    },
};
</script>

<style scoped></style>
